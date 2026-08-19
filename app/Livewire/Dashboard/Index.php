<?php

namespace App\Livewire\Dashboard;

use App\Livewire\Concerns\HandlesNotifications;
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
    use HandlesNotifications;

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

    public function confirmExpectedIncome(int $id): void
    {
        $ei = \App\Models\ExpectedIncome::where('user_id', Auth::id())->findOrFail($id);
        $income = $ei->confirmReceived();

        session()->flash('message', '🎉 ' . $ei->title . ' (₺' . number_format($ei->amount, 2, ',', '.') . ') hesaba geçti olarak kaydedildi ve nakit akışına eklendi.');
    }

    public function delayExpectedIncome(int $id, int $days = 3): void
    {
        $ei = \App\Models\ExpectedIncome::where('user_id', Auth::id())->findOrFail($id);
        $ei->markDelayed($days);

        session()->flash('message', '⏳ ' . $ei->title . ' ' . $days . ' gün ertelendi (' . $ei->expected_date?->format('d.m.Y') . '). Ödeme planı ve risk durumu güncellendi.');
    }

    public function cancelExpectedIncome(int $id): void
    {
        $ei = \App\Models\ExpectedIncome::where('user_id', Auth::id())->findOrFail($id);
        $ei->markCancelled();

        session()->flash('message', '❌ ' . $ei->title . ' iptal edildi olarak işaretlendi.');
    }

    public function render()
    {
        $user = Auth::user();
        $riskService = new RiskCounter();
        $riskSummary = $riskService->calculateUserRiskSummary($user);

        // Beklenen Gelirler: Onay bekleyenler (vadesi bugün veya geçmiş olanlar)
        $dueExpectedIncomes = \App\Models\ExpectedIncome::where('user_id', $user->id)
            ->dueForConfirmation()
            ->get();

        // Yaklaşan Beklenen Gelirler (Gelecek 15 gün içindekiler)
        $upcomingExpectedIncomes = \App\Models\ExpectedIncome::where('user_id', $user->id)
            ->upcoming(15)
            ->get();

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

        // Günlük AI Önerisi (Öncelikle Groq modeli tarafından üretilen kriz raporu)
        $latestAdvice = AiAdvice::where('user_id', $user->id)
            ->where('type', 'daily')
            ->where('provider', 'groq')
            ->latest()
            ->first();

        if (!$latestAdvice) {
            $latestAdvice = AiAdvice::where('user_id', $user->id)
                ->where('type', 'daily')
                ->latest()
                ->first();
        }

        // Aylık Gelir & Bu Ayın Gider Özeti
        $thisMonthRealizedIncome = (float) Income::where('user_id', $user->id)
            ->whereYear('income_date', now()->year)
            ->whereMonth('income_date', now()->month)
            ->sum('amount');

        $expectedMonthlyIncome = (float) \App\Models\ExpectedIncome::where('user_id', $user->id)
            ->where('is_active', true)
            ->where('frequency', 'monthly')
            ->sum('amount');

        // Aylık aktif bütçe hesabı: Bu ay gerçekleşen gelir + kalan beklenen düzenli gelir
        $totalMonthlyIncome = $thisMonthRealizedIncome > 0 
            ? ($thisMonthRealizedIncome + $expectedMonthlyIncome) 
            : ($expectedMonthlyIncome ?: (float) $user->monthly_income);

        $totalMonthlyExpense = (float) Expense::where('user_id', $user->id)
            ->whereYear('expense_date', now()->year)
            ->whereMonth('expense_date', now()->month)
            ->sum('amount');
        $availableForDebt = max(0, $totalMonthlyIncome - $totalMonthlyExpense);


        // Ekstra Zengin Finansal Metrikler (Doğrudan Veritabanı)
        $activeDebtsCount = Debt::where('user_id', $user->id)->where('status', 'active')->count();
        $activeCardsCount = CreditCard::where('user_id', $user->id)->count();
        $activeAccountsCount = Account::where('user_id', $user->id)->count();
        $debtToIncomeRatio = $totalMonthlyIncome > 0 ? round(($riskSummary['total_monthly_commitment'] / $totalMonthlyIncome) * 100, 1) : 0;

        // Kullanıcının aktif işlem gördüğü benzersiz banka adedi (Dinamik DB)
        $userBankIds = collect()
            ->merge(Debt::where('user_id', $user->id)->where('status', 'active')->pluck('bank_id'))
            ->merge(CreditCard::where('user_id', $user->id)->pluck('bank_id'))
            ->merge(Account::where('user_id', $user->id)->pluck('bank_id'))
            ->filter()
            ->unique();
        $connectedBanksCount = $userBankIds->count();

        // Chart 1: Banka Dağılımı Grafiği Verileri
        $chartBankLabels = [];
        $chartBankValues = [];
        $chartBankColors = [];

        foreach ($bankDistribution as $bankName => $info) {
            $chartBankLabels[] = $bankName;
            $chartBankValues[] = round($info['total'], 2);
            $chartBankColors[] = $info['color'] ?: '#6366f1';
        }

        // Chart 2: 6 Aylık Borç Ödeme ve Erime Projeksiyonu
        $activePlan = \App\Models\PaymentPlan::where('user_id', $user->id)->where('status', 'active')->first();
        $projectionLabels = [];
        $projectionPayments = [];
        $projectionBalances = [];

        if ($activePlan) {
            $planItems = \App\Models\PaymentPlanItem::where('payment_plan_id', $activePlan->id)
                ->get()
                ->groupBy('month');

            $runningBalance = (float) Debt::where('user_id', $user->id)->where('status', 'active')->sum('remaining');

            foreach ($planItems->take(6) as $monthStr => $items) {
                $monthName = \Carbon\Carbon::parse($monthStr)->translatedFormat('M Y');
                $monthPayment = (float) $items->sum('allocated_amount');
                $runningBalance = max(0, $runningBalance - $monthPayment);

                $projectionLabels[] = $monthName;
                $projectionPayments[] = round($monthPayment, 2);
                $projectionBalances[] = round($runningBalance, 2);
            }
        }

        return view('livewire.dashboard.index', [
            'riskSummary' => $riskSummary,
            'dueExpectedIncomes' => $dueExpectedIncomes,
            'upcomingExpectedIncomes' => $upcomingExpectedIncomes,
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
            'connectedBanksCount' => $connectedBanksCount,
            'chartBankLabels' => $chartBankLabels,
            'chartBankValues' => $chartBankValues,
            'chartBankColors' => $chartBankColors,
            'projectionLabels' => $projectionLabels,
            'projectionPayments' => $projectionPayments,
            'projectionBalances' => $projectionBalances,
        ])->layout('layouts.app');
    }
}
