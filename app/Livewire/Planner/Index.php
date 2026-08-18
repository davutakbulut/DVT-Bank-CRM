<?php

namespace App\Livewire\Planner;

use App\Models\Debt;
use App\Models\Expense;
use App\Models\Income;
use App\Models\PaymentLog;
use App\Models\PaymentPlan;
use App\Models\PaymentPlanItem;
use App\Services\DebtCalculator;
use App\Services\PaymentPlanner;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public bool $isCreatingPlan = false;
    public float $monthlyBudget = 0.0;
    public string $strategy = 'avalanche'; // avalanche (Çığ), snowball (Kartopu)
    public string $planName = 'Öncelikli Borç Kapatma Planı';

    public function mount(): void
    {
        $user = Auth::user();
        $totalIncome = Income::where('user_id', $user->id)->sum('amount');
        $totalExpense = Expense::where('user_id', $user->id)->sum('amount');
        $this->monthlyBudget = max(1000, $totalIncome - $totalExpense);
    }

    public function generateNewPlan(): void
    {
        $this->validate([
            'monthlyBudget' => 'required|numeric|min:500',
            'strategy' => 'required|in:avalanche,snowball,custom',
        ]);

        $planner = new PaymentPlanner();
        $planner->generatePlan(Auth::user(), $this->monthlyBudget, $this->strategy, $this->planName);

        $this->isCreatingPlan = false;
        session()->flash('message', 'Yeni borç kurtarma ödeme planınız başarıyla oluşturuldu!');
    }

    public function markAsPaid(int $itemId): void
    {
        $item = PaymentPlanItem::with('debt')->findOrFail($itemId);

        if ($item->status !== 'paid') {
            $item->update(['status' => 'paid']);

            if ($item->debt) {
                // Payments_log ekle
                PaymentLog::create([
                    'user_id' => Auth::id(),
                    'payable_type' => Debt::class,
                    'payable_id' => $item->debt->id,
                    'amount' => $item->allocated_amount,
                    'paid_at' => now(),
                    'method' => 'manual',
                    'note' => 'Ödeme planı üzerinden ödendi işaretlendi',
                ]);

                // Borcu düş
                $item->debt->remaining = max(0, $item->debt->remaining - $item->allocated_amount);
                $item->debt->last_payment_date = now();
                $item->debt->days_overdue = 0;
                if ($item->debt->remaining <= 0) {
                    $item->debt->status = 'paid';
                }
                $item->debt->save();
            }

            session()->flash('message', 'Plan ödemesi başarıyla işlendi ve borç bakiyesi düşürüldü.');
        }
    }

    public function render()
    {
        $user = Auth::user();
        $debts = Debt::where('user_id', $user->id)->where('status', 'active')->get();

        // Strateji karşılaştırma simülasyonu
        $calc = new DebtCalculator();
        $comparison = $calc->compareStrategies($debts->toArray(), $this->monthlyBudget);

        $activePlan = PaymentPlan::where('user_id', $user->id)
            ->where('status', 'active')
            ->with(['items.debt.bank'])
            ->latest()
            ->first();

        $monthlyGroups = [];
        if ($activePlan) {
            $monthlyGroups = $activePlan->items->groupBy(fn($item) => Carbon::parse($item->month)->format('Y-m'));
        }

        return view('livewire.planner.index', [
            'activePlan' => $activePlan,
            'monthlyGroups' => $monthlyGroups,
            'comparison' => $comparison,
            'debts' => $debts,
        ])->layout('layouts.app');
    }
}
