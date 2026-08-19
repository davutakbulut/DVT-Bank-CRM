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
    public float $monthlyBudget = 15000.0;
    public string $strategy = 'avalanche'; // avalanche (Çığ), snowball (Kartopu), hybrid (90 Gün Hibrit)
    public string $planName = 'Matematiksel Çığ Borç Kapatma Planı';
    public string $activeStrategyTab = 'avalanche'; // avalanche, snowball, hybrid

    public function mount(): void
    {
        $user = Auth::user();
        $activePlan = PaymentPlan::where('user_id', $user->id)
            ->where('status', 'active')
            ->latest()
            ->first();

        if ($activePlan) {
            $this->monthlyBudget = (float) $activePlan->monthly_budget;
            $this->strategy = $activePlan->strategy;
            $this->activeStrategyTab = $activePlan->strategy;
            $this->planName = $activePlan->name;
        } else {
            $totalIncome = (float) Income::where('user_id', $user->id)->sum('amount');
            $totalExpense = (float) Expense::where('user_id', $user->id)->sum('amount');
            $availableNet = max(0.0, $totalIncome - $totalExpense);
            
            $this->monthlyBudget = $availableNet > 500 ? $availableNet : 15000.0;
        }
    }

    public function generateNewPlan(): void
    {
        $this->validate([
            'monthlyBudget' => 'required|numeric|min:500',
            'strategy' => 'required|in:avalanche,snowball,custom,hybrid',
        ]);

        $planner = new PaymentPlanner();
        $planner->generatePlan(Auth::user(), $this->monthlyBudget, $this->strategy, $this->planName);

        $this->activeStrategyTab = $this->strategy;
        $this->isCreatingPlan = false;
        session()->flash('message', 'Yeni borç kurtarma ödeme planınız başarıyla oluşturuldu!');
    }

    public function deletePlan(): void
    {
        $user = Auth::user();
        PaymentPlan::where('user_id', $user->id)->delete();
        session()->flash('message', 'Aktif ödeme planınız ve tüm ödeme takviminiz başarıyla silindi.');
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

    public function exportExcel()
    {
        $user = Auth::user();
        $activePlan = PaymentPlan::where('user_id', $user->id)
            ->where('status', 'active')
            ->with(['items.debt.bank'])
            ->latest()
            ->first();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="dvt_bank_odeme_plani_' . date('Y-m-d_His') . '.csv"',
        ];

        $callback = function () use ($activePlan) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($file, [
                'Plan Adı',
                'Strateji Türü',
                'Ödeme Ayı',
                'Banka Adı',
                'Borç Kalemi',
                'Aylık Faiz Oranı (%)',
                'Planlanan Ödeme Tutarı (TL)',
                'Ödeme Durumu',
            ], ';');

            if ($activePlan) {
                foreach ($activePlan->items as $item) {
                    $strategyLabel = match($activePlan->strategy) {
                        'avalanche' => 'Çığ (En Yüksek Faiz Öncelikli)',
                        'snowball' => 'Kartopu (En Küçük Borç Öncelikli)',
                        default => 'DVT 90 Gün Hibrit Kalkanı',
                    };

                    fputcsv($file, [
                        $activePlan->name,
                        $strategyLabel,
                        Carbon::parse($item->month)->translatedFormat('F Y'),
                        $item->debt?->bank?->name ?? 'Diğer Banka',
                        $item->debt?->title ?? 'Borç Kalemi',
                        '%' . number_format($item->debt?->interest_rate ?? 0, 2, ',', ''),
                        number_format($item->allocated_amount, 2, ',', ''),
                        $item->status === 'paid' ? 'Ödendi ✓' : 'Beklemede',
                    ], ';');
                }
            }

            fclose($file);
        };

        return response()->streamDownload($callback, 'dvt_bank_odeme_plani_' . date('Y-m-d') . '.csv', $headers);
    }

    public function render()
    {
        $user = Auth::user();
        $debts = Debt::where('user_id', $user->id)->where('status', 'active')->with('bank')->get();

        $activePlan = PaymentPlan::where('user_id', $user->id)
            ->where('status', 'active')
            ->with(['items.debt.bank'])
            ->latest()
            ->first();

        $effectiveBudget = $activePlan ? (float) $activePlan->monthly_budget : $this->monthlyBudget;
        $effectiveStrategy = $activePlan ? $activePlan->strategy : $this->activeStrategyTab;

        // Strateji karşılaştırma simülasyonu
        $calc = new DebtCalculator();
        $comparison = $calc->compareStrategies($debts->toArray(), $effectiveBudget);

        $monthlyGroups = [];
        $totalAllocated = 0;
        $totalPaidInPlan = 0;
        $planProgressPercent = 0;

        if ($activePlan) {
            $monthlyGroups = $activePlan->items->groupBy(fn($item) => Carbon::parse($item->month)->format('Y-m'));
            $totalAllocated = $activePlan->items->sum('allocated_amount');
            $totalPaidInPlan = $activePlan->items->where('status', 'paid')->sum('allocated_amount');
            $planProgressPercent = $totalAllocated > 0 ? min(100, round(($totalPaidInPlan / $totalAllocated) * 100)) : 0;
        }

        // Borç Kapatma Sıralaması & Yol Haritası (Simülasyon Hedefleri)
        $roadmap = [];
        $sortedDebts = $debts;

        if ($this->activeStrategyTab === 'avalanche') {
            $sortedDebts = $debts->sortByDesc('interest_rate')->values();
        } elseif ($this->activeStrategyTab === 'snowball') {
            $sortedDebts = $debts->sortBy('remaining')->values();
        } else {
            // Hibrit: önce gecikmedeki borçlar, sonra yüksek faiz
            $sortedDebts = $debts->sortByDesc('days_overdue')->values();
        }

        $cumulativeMonths = 0;
        foreach ($sortedDebts as $index => $d) {
            $debtMonthlyAlloc = max(1, $effectiveBudget * 0.70); // %70 ana odak
            $approxMonths = ceil($d->remaining / $debtMonthlyAlloc);
            $cumulativeMonths += $approxMonths;

            $roadmap[] = [
                'order' => $index + 1,
                'debt' => $d,
                'target_month' => Carbon::now()->addMonths($cumulativeMonths)->translatedFormat('F Y'),
                'months_to_kill' => $cumulativeMonths,
                'is_current_target' => $index === 0,
            ];
        }

        $totalDebtSum = $debts->sum('remaining');
        $activeStrategyResult = $comparison[$effectiveStrategy] ?? ($comparison['hybrid'] ?? ($comparison['avalanche'] ?? ['months' => 12]));
        $freedomMonths = $activeStrategyResult['months'] ?? 12;
        $freedomDate = Carbon::now()->addMonths($freedomMonths)->translatedFormat('F Y');

        return view('livewire.planner.index', [
            'activePlan' => $activePlan,
            'monthlyGroups' => $monthlyGroups,
            'comparison' => $comparison,
            'debts' => $debts,
            'roadmap' => $roadmap,
            'totalDebtSum' => $totalDebtSum,
            'freedomDate' => $freedomDate,
            'freedomMonths' => $freedomMonths,
            'effectiveBudget' => $effectiveBudget,
            'planProgressPercent' => $planProgressPercent,
            'totalPaidInPlan' => $totalPaidInPlan,
        ])->layout('layouts.app');
    }
}

