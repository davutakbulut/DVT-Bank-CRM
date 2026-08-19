<?php

namespace App\Livewire\Reports;

use App\Models\Account;
use App\Models\CreditCard;
use App\Models\Debt;
use App\Models\Expense;
use App\Models\Income;
use App\Models\PaymentLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public string $period = 'this_month'; // this_month, last_month, last_30, last_90, this_year, all
    public string $activeTab = 'overview'; // overview, categories, timing, banks, limits

    public function setPeriod(string $p): void
    {
        $this->period = $p;
    }

    public function setTab(string $tab): void
    {
        $this->activeTab = $tab;
    }

    public function exportExcel()
    {
        $userId = Auth::id();
        $debts = Debt::where('user_id', $userId)->with('bank')->get();
        $cards = CreditCard::where('user_id', $userId)->with('bank')->get();
        $accounts = Account::where('user_id', $userId)->with('bank')->get();
        $expenses = Expense::where('user_id', $userId)->with('category')->get();
        $incomes = Income::where('user_id', $userId)->with('category')->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="dvt_bank_finansal_rapor_' . date('Y-m-d') . '.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($debts, $cards, $accounts, $expenses, $incomes) {
            $file = fopen('php://output', 'w');
            // Excel UTF-8 BOM
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // 1. Özet Başlığı
            fputcsv($file, ['=== DVT BANK CRM - KAPSAMLI FİNANSAL RAPOR ==='], ';');
            fputcsv($file, ['Rapor Tarihi', date('d.m.Y H:i:s')], ';');
            fputcsv($file, ['Toplam Borç (TL)', number_format($debts->sum('remaining'), 2, ',', '')], ';');
            fputcsv($file, ['Toplam Kart Limiti (TL)', number_format($cards->sum('credit_limit'), 2, ',', '')], ';');
            fputcsv($file, ['Toplam Kart Borcu (TL)', number_format($cards->sum('current_debt'), 2, ',', '')], ';');
            fputcsv($file, ['Toplam Gelir (TL)', number_format($incomes->sum('amount'), 2, ',', '')], ';');
            fputcsv($file, ['Toplam Gider (TL)', number_format($expenses->sum('amount'), 2, ',', '')], ';');
            fputcsv($file, [], ';');

            // 2. Borçlar Dökümü
            fputcsv($file, ['=== AKTİF BORÇLAR & KREDİLER ==='], ';');
            fputcsv($file, ['Banka', 'Borç Başlığı', 'Tür', 'Kalan Borç (TL)', 'Aylık Taksit (TL)', 'Aylık Faiz %', 'Gecikme Günü', 'Sonraki Vade'], ';');
            foreach ($debts as $d) {
                fputcsv($file, [
                    $d->bank?->name ?? 'Diğer',
                    $d->title,
                    $d->type,
                    number_format($d->remaining, 2, ',', ''),
                    number_format($d->installment_amount ?: 0, 2, ',', ''),
                    '%' . number_format($d->interest_rate, 2, ',', ''),
                    $d->days_overdue . ' Gün',
                    $d->next_due_date ? Carbon::parse($d->next_due_date)->format('d.m.Y') : '-',
                ], ';');
            }

            fputcsv($file, [], ';');

            // 3. Kredi Kartları Dökümü
            fputcsv($file, ['=== KREDİ KARTLARI LİMİT & BORÇ ANALİZİ ==='], ';');
            fputcsv($file, ['Banka', 'Kart Adı', 'Kart No', 'Limit (TL)', 'Dönem Borcu (TL)', 'Asgari (TL)', 'Puan/Jest Lira (TL)', 'Nakit Avans (TL)', 'Durum'], ';');
            foreach ($cards as $c) {
                fputcsv($file, [
                    $c->bank?->name ?? 'Banka',
                    $c->name,
                    $c->masked_card_number,
                    number_format($c->credit_limit, 2, ',', ''),
                    number_format($c->current_debt, 2, ',', ''),
                    number_format($c->minimum_payment, 2, ',', ''),
                    number_format($c->reward_balance ?: 0, 2, ',', ''),
                    number_format($c->cash_advance_limit ?: 0, 2, ',', ''),
                    $c->is_cash_advance_blocked ? 'Avans Kapalı' : 'Aktif',
                ], ';');
            }

            fclose($file);
        };

        return response()->streamDownload($callback, 'dvt_bank_finansal_rapor_' . date('Y-m-d') . '.csv', $headers);
    }


    public function render()
    {
        $user = Auth::user();
        $userId = $user->id;

        // Tarih aralığını belirle
        $now = Carbon::now();
        $startDate = null;
        $endDate = $now->copy()->endOfDay();

        switch ($this->period) {
            case 'this_month':
                $startDate = $now->copy()->startOfMonth();
                $endDate = $now->copy()->endOfMonth();
                break;
            case 'last_month':
                $startDate = $now->copy()->subMonth()->startOfMonth();
                $endDate = $now->copy()->subMonth()->endOfMonth();
                break;
            case 'last_30':
                $startDate = $now->copy()->subDays(15)->startOfDay();
                $endDate = $now->copy()->addDays(15)->endOfDay();
                break;
            case 'last_90':
                $startDate = $now->copy()->subDays(90)->startOfDay();
                $endDate = $now->copy()->endOfDay();
                break;
            case 'this_year':
                $startDate = $now->copy()->startOfYear();
                $endDate = $now->copy()->endOfYear();
                break;
            case 'all':
            default:
                $startDate = Carbon::create(2020, 1, 1);
                $endDate = Carbon::create(2035, 12, 31);
                break;
        }


        // 1. GİDERLER & GELİRLER
        $expensesQuery = Expense::where('user_id', $userId)->with('category');
        $incomesQuery = Income::where('user_id', $userId)->with('category');

        if ($this->period !== 'all') {
            $expensesQuery->whereBetween('expense_date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')]);
            $incomesQuery->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('income_date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
                  ->orWhere(function ($sq) use ($startDate, $endDate) {
                      $sq->whereNull('income_date')->whereBetween('created_at', [$startDate, $endDate]);
                  });
            });
        }

        $expenses = $expensesQuery->get();
        $incomes = $incomesQuery->get();

        // Toplam Gelir ve Gider
        $totalExpense = (float) $expenses->sum('amount');
        $totalIncome = (float) $incomes->sum('amount');
        $netSavings = $totalIncome - $totalExpense;
        $savingsRate = $totalIncome > 0 ? max(0, round(($netSavings / $totalIncome) * 100)) : 0;

        // 2. BORÇLAR & BANKALAR
        $debts = Debt::where('user_id', $userId)->where('status', 'active')->with('bank')->get();
        $totalDebt = (float) $debts->sum('remaining');
        $totalMonthlyInterest = $debts->sum(fn($d) => $d->remaining * (($d->interest_rate ?? 0) / 100));
        $totalAnnualInterest = $totalMonthlyInterest * 12;

        // 3. FİNANSAL SAĞLIK SKORU (0 - 100)
        // Kriterler: Borç/Gelir oranı, Tasarruf oranı, Gecikme durumu
        $debtToIncomeRatio = $totalIncome > 0 ? round($totalDebt / $totalIncome, 1) : 0;
        $hasCriticalOverdue = $debts->contains(fn($d) => $d->days_overdue >= 60);

        $healthScore = 100;
        if ($savingsRate < 10) $healthScore -= 20;
        elseif ($savingsRate < 25) $healthScore -= 10;

        if ($debtToIncomeRatio > 6) $healthScore -= 35;
        elseif ($debtToIncomeRatio > 3) $healthScore -= 20;
        elseif ($debtToIncomeRatio > 1) $healthScore -= 10;

        if ($hasCriticalOverdue) $healthScore -= 25;
        $healthScore = max(15, min(100, $healthScore));

        // 4. KATEGORİ BAZLI HARCAMA ANALİZİ (Nereye Harcıyorum?)
        $categoryBreakdown = $expenses->groupBy('category_id')->map(function ($group) use ($totalExpense) {
            $cat = $group->first()->category;
            $catAmount = (float) $group->sum('amount');
            $percentage = $totalExpense > 0 ? round(($catAmount / $totalExpense) * 100, 1) : 0;

            return [
                'name' => $cat?->name ?? 'Diğer / Genel',
                'color' => $cat?->color ?? '#6366f1',
                'icon' => $cat?->icon ?? '🛒',
                'amount' => $catAmount,
                'count' => $group->count(),
                'avg' => $group->count() > 0 ? round($catAmount / $group->count(), 2) : 0,
                'percentage' => $percentage,
            ];
        })->sortByDesc('amount')->values();

        // 5. ZAMAN VE DÖNGÜ ANALİZİ (Ne Zaman Harcıyorum?)
        $weekdayTotal = 0;
        $weekendTotal = 0;
        $period1to10 = 0;
        $period11to20 = 0;
        $period21to31 = 0;

        foreach ($expenses as $exp) {
            $d = Carbon::parse($exp->expense_date);
            $dayOfMonth = $d->day;

            if ($d->isWeekend()) {
                $weekendTotal += $exp->amount;
            } else {
                $weekdayTotal += $exp->amount;
            }

            if ($dayOfMonth <= 10) {
                $period1to10 += $exp->amount;
            } elseif ($dayOfMonth <= 20) {
                $period11to20 += $exp->amount;
            } else {
                $period21to31 += $exp->amount;
            }
        }

        $timingAnalysis = [
            'weekday_total' => $weekdayTotal,
            'weekday_percent' => $totalExpense > 0 ? round(($weekdayTotal / $totalExpense) * 100) : 0,
            'weekend_total' => $weekendTotal,
            'weekend_percent' => $totalExpense > 0 ? round(($weekendTotal / $totalExpense) * 100) : 0,
            'p1_10' => $period1to10,
            'p1_10_percent' => $totalExpense > 0 ? round(($period1to10 / $totalExpense) * 100) : 0,
            'p11_20' => $period11to20,
            'p11_20_percent' => $totalExpense > 0 ? round(($period11to20 / $totalExpense) * 100) : 0,
            'p21_31' => $period21to31,
            'p21_31_percent' => $totalExpense > 0 ? round(($period21to31 / $totalExpense) * 100) : 0,
        ];

        // 6. BANKA & FAİZ ANALİZİ (Hangi Banka Ne Kadar Alıyor?)
        $bankAnalysis = $debts->groupBy(fn($d) => $d->bank?->name ?? 'Diğer')->map(function ($group) use ($totalDebt) {
            $bDebt = (float) $group->sum('remaining');
            $avgInterest = (float) $group->avg('interest_rate');
            $monthlyCost = (float) $group->sum(fn($d) => $d->remaining * (($d->interest_rate ?? 0) / 100));
            $annualCost = $monthlyCost * 12;
            $bankColor = $group->first()->bank?->color ?? '#6366f1';
            $debtShare = $totalDebt > 0 ? round(($bDebt / $totalDebt) * 100, 1) : 0;

            return [
                'bank_name' => $group->first()->bank?->name ?? 'Diğer Banka',
                'bank_color' => $bankColor,
                'total_debt' => $bDebt,
                'avg_interest' => $avgInterest,
                'monthly_interest_cost' => $monthlyCost,
                'annual_interest_cost' => $annualCost,
                'debt_share' => $debtShare,
                'debts_count' => $group->count(),
            ];
        })->sortByDesc('monthly_interest_cost')->values();

        // 7. KART & KMH LİMİT YOĞUNLUK ANALİZİ
        $cards = CreditCard::where('user_id', $userId)->get();
        $totalCardLimit = (float) $cards->sum('credit_limit');
        $totalCardDebt = (float) $cards->sum('current_debt');
        $cardUtilization = $totalCardLimit > 0 ? round(($totalCardDebt / $totalCardLimit) * 100) : 0;

        $accounts = Account::where('user_id', $userId)->get();
        $totalKmhLimit = (float) $accounts->sum('kmh_limit');
        $totalKmhUsed = (float) $accounts->sum('kmh_used');
        $kmhUtilization = $totalKmhLimit > 0 ? round(($totalKmhUsed / $totalKmhLimit) * 100) : 0;

        $limitAnalysis = [
            'card_limit' => $totalCardLimit,
            'card_debt' => $totalCardDebt,
            'card_utilization' => $cardUtilization,
            'kmh_limit' => $totalKmhLimit,
            'kmh_used' => $totalKmhUsed,
            'kmh_utilization' => $kmhUtilization,
            'total_limit' => $totalCardLimit + $totalKmhLimit,
            'total_used' => $totalCardDebt + $totalKmhUsed,
            'total_utilization' => ($totalCardLimit + $totalKmhLimit) > 0 ? round((($totalCardDebt + $totalKmhUsed) / ($totalCardLimit + $totalKmhLimit)) * 100) : 0,
        ];

        // 8. SON ÖDEME GEÇMİŞİ
        $paymentLogs = PaymentLog::where('user_id', $userId)->latest('paid_at')->take(10)->get();
        $estimatedPayoffMonths = ($netSavings > 0 && $totalDebt > 0) ? ceil($totalDebt / $netSavings) : 0;

        // Chart Datasets for Reports
        // 1. Category Chart
        $reportCatLabels = $categoryBreakdown->pluck('name')->toArray();
        $reportCatValues = $categoryBreakdown->pluck('amount')->toArray();
        $reportCatColors = $categoryBreakdown->pluck('color')->toArray();

        // 2. Timing Chart (Ay içi dönemler + Hafta Sonu)
        $reportTimingLabels = ['1-10 Gün (Maaş Başı)', '11-20 Gün (Ay Ortası)', '21-31 Gün (Ay Sonu)', 'Hafta İçi', 'Hafta Sonu'];
        $reportTimingValues = [
            $timingAnalysis['p1_10'],
            $timingAnalysis['p11_20'],
            $timingAnalysis['p21_31'],
            $timingAnalysis['weekday_total'],
            $timingAnalysis['weekend_total'],
        ];

        // 3. Bank Debt & Interest Chart
        $reportBankNames = $bankAnalysis->pluck('bank_name')->toArray();
        $reportBankDebts = $bankAnalysis->pluck('total_debt')->toArray();
        $reportBankInterests = $bankAnalysis->pluck('annual_interest_cost')->toArray();
        $reportBankColors = $bankAnalysis->pluck('bank_color')->toArray();

        return view('livewire.reports.index', [
            'totalExpense' => $totalExpense,
            'totalIncome' => $totalIncome,
            'netSavings' => $netSavings,
            'savingsRate' => $savingsRate,
            'totalDebt' => $totalDebt,
            'totalMonthlyInterest' => $totalMonthlyInterest,
            'totalAnnualInterest' => $totalAnnualInterest,
            'healthScore' => $healthScore,
            'debtToIncomeRatio' => $debtToIncomeRatio,
            'categoryBreakdown' => $categoryBreakdown,
            'timingAnalysis' => $timingAnalysis,
            'bankAnalysis' => $bankAnalysis,
            'limitAnalysis' => $limitAnalysis,
            'paymentLogs' => $paymentLogs,
            'estimatedPayoffMonths' => $estimatedPayoffMonths,
            'reportCatLabels' => $reportCatLabels,
            'reportCatValues' => $reportCatValues,
            'reportCatColors' => $reportCatColors,
            'reportTimingLabels' => $reportTimingLabels,
            'reportTimingValues' => $reportTimingValues,
            'reportBankNames' => $reportBankNames,
            'reportBankDebts' => $reportBankDebts,
            'reportBankInterests' => $reportBankInterests,
            'reportBankColors' => $reportBankColors,
        ])->layout('layouts.app');
    }
}

