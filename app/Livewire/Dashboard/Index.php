<?php

namespace App\Livewire\Dashboard;

use App\Models\Account;
use App\Models\AiAdvice;
use App\Models\CreditCard;
use App\Models\Debt;
use App\Models\Expense;
use App\Models\Income;
use App\Models\PaymentLog;
use App\Services\DebtCalculator;
use App\Services\RiskCounter;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public bool $showPaymentModal = false;
    public ?int $selectedDebtId = null;
    public float $paymentAmount = 0.0;
    public string $paymentNote = '';

    public function mount(): void
    {
        $user = Auth::user();
        if ($user && !$user->onboarding_completed) {
            redirect()->route('onboarding.index');
        }
    }

    public function openPaymentModal(int $debtId): void
    {
        $debt = Debt::find($debtId);
        if ($debt) {
            $this->selectedDebtId = $debt->id;
            $this->paymentAmount = (float) ($debt->installment_amount ?: $debt->remaining);
            $this->showPaymentModal = true;
        }
    }

    public function recordPayment(): void
    {
        $this->validate([
            'paymentAmount' => 'required|numeric|min:1',
        ]);

        $debt = Debt::find($this->selectedDebtId);
        if ($debt) {
            // Ödeme kaydet
            PaymentLog::create([
                'user_id' => Auth::id(),
                'payable_type' => Debt::class,
                'payable_id' => $debt->id,
                'amount' => $this->paymentAmount,
                'paid_at' => now(),
                'method' => 'manual',
                'note' => $this->paymentNote ?: 'Manuel ödeme kaydedildi',
            ]);

            // Kalan tutarı düş ve son ödeme tarihini güncelle
            $debt->remaining = max(0, $debt->remaining - $this->paymentAmount);
            $debt->last_payment_date = now();
            $debt->days_overdue = 0;
            if ($debt->remaining <= 0) {
                $debt->status = 'paid';
            }
            $debt->save();

            $this->showPaymentModal = false;
            $this->reset(['selectedDebtId', 'paymentAmount', 'paymentNote']);
            session()->flash('message', 'Ödeme başarıyla kaydedildi ve bakiye güncellendi.');
        }
    }

    public function render()
    {
        $user = Auth::user();
        $riskService = new RiskCounter();
        $riskSummary = $riskService->calculateUserRiskSummary($user);

        // Yaklaşan ve geciken ödemeler (14 gün içinde)
        $upcomingDebts = Debt::where('user_id', $user->id)
            ->where('status', 'active')
            ->with('bank')
            ->orderBy('days_overdue', 'desc')
            ->orderBy('next_due_date', 'asc')
            ->take(6)
            ->get();

        // Banka bazında borç dağılımı
        $bankDistribution = Debt::where('user_id', $user->id)
            ->where('status', 'active')
            ->with('bank')
            ->get()
            ->groupBy(fn($d) => $d->bank?->name ?? 'Diğer')
            ->map(fn($group) => [
                'total' => $group->sum('remaining'),
                'color' => $group->first()->bank?->color ?? '#6366f1',
            ]);

        // Günlük AI Önerisi
        $latestAdvice = AiAdvice::where('user_id', $user->id)
            ->where('type', 'daily')
            ->latest()
            ->first();

        // Ekstra Zengin Finansal Metrikler
        $activeDebtsCount = Debt::where('user_id', $user->id)->where('status', 'active')->count();
        $activeCardsCount = CreditCard::where('user_id', $user->id)->count();
        $activeAccountsCount = Account::where('user_id', $user->id)->count();
        $debtToIncomeRatio = $totalMonthlyIncome > 0 ? round(($riskSummary['total_monthly_commitment'] / $totalMonthlyIncome) * 100, 1) : 0;

        return view('livewire.dashboard.index', [
            'riskSummary' => $riskSummary,
            'upcomingDebts' => $upcomingDebts,
            'bankDistribution' => $bankDistribution,
            'latestAdvice' => $latestAdvice,
            'totalMonthlyIncome' => $totalMonthlyIncome,
            'totalMonthlyExpense' => $totalMonthlyExpense,
            'availableForDebt' => $availableForDebt,
            'activeDebtsCount' => $activeDebtsCount,
            'activeCardsCount' => $activeCardsCount,
            'activeAccountsCount' => $activeAccountsCount,
            'debtToIncomeRatio' => $debtToIncomeRatio,
        ])->layout('layouts.app');
    }
}
