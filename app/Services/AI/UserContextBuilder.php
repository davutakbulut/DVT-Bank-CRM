<?php

namespace App\Services\AI;

use App\Models\CreditCard;
use App\Models\Debt;
use App\Models\Expense;
use App\Models\ExpectedIncome;
use App\Models\Income;
use App\Models\PaymentPlan;
use App\Models\User;
use App\Services\RiskCounter;
use Carbon\Carbon;

class UserContextBuilder
{
    public function build(User $user): array
    {
        // 1. Aylık Gelir Hesaplaması (Sadece İçinde Bulunulan Ay veya Son 30 Gün)
        $monthlyIncome = (float) $user->monthly_income;
        if ($monthlyIncome <= 0) {
            $monthlyIncome = (float) Income::where('user_id', $user->id)
                ->whereYear('income_date', Carbon::now()->year)
                ->whereMonth('income_date', Carbon::now()->month)
                ->sum('amount');

            if ($monthlyIncome <= 0) {
                $monthlyIncome = (float) Income::where('user_id', $user->id)
                    ->where('income_date', '>=', Carbon::now()->subDays(30))
                    ->sum('amount');
            }
        }

        $debts = Debt::where('user_id', $user->id)
            ->where('status', 'active')
            ->with('bank')
            ->get();

        $creditCards = CreditCard::where('user_id', $user->id)
            ->where('status', 'active')
            ->with('bank')
            ->get();

        $riskSummary = (new RiskCounter())->calculateUserRiskSummary($user);

        $debtList = [];
        $highestInterestDebt = null;
        $maxInterest = -1;

        foreach ($debts as $d) {
            $bankLabel = $d->bank?->name ?? 'Banka';
            $monthlyMin = $d->installment_amount ?: ($d->type === 'credit_card' ? ($d->remaining * 0.40) : ($d->remaining * 0.05));
            $daysOverdue = (int) $d->days_overdue;

            if ($d->interest_rate > $maxInterest) {
                $maxInterest = $d->interest_rate;
                $highestInterestDebt = "{$bankLabel} {$d->title} (%{$d->interest_rate})";
            }

            $debtList[] = [
                'banka' => $bankLabel,
                'baslik' => $d->title,
                'tip' => $d->type,
                'kalan' => (float) $d->remaining,
                'aylik_taksit_veya_asgari' => (float) $monthlyMin,
                'aylik_faiz_yuzde' => (float) $d->interest_rate,
                'son_odeme_tarihi' => $d->next_due_date ? Carbon::parse($d->next_due_date)->format('Y-m-d') : null,
                'gun_gecikmede' => $daysOverdue,
                'takibe_kalan_gun' => max(0, 90 - $daysOverdue),
                'yapilandirilmis' => (bool) $d->is_restructured,
            ];
        }

        $activePlan = PaymentPlan::where('user_id', $user->id)->where('status', 'active')->first();

        // 90 gün riskli liste
        $legalRisks = [];
        foreach ($debtList as $d) {
            if ($d['takibe_kalan_gun'] <= 50) {
                $legalRisks[] = [
                    'banka' => $d['banka'] . ' (' . $d['baslik'] . ')',
                    'kalan_gun' => $d['takibe_kalan_gun'],
                    'gecikme' => $d['gun_gecikmede'],
                ];
            }
        }

        // Beklenen / Planlanan Nakit Girişleri
        $expectedIncomes = \App\Models\ExpectedIncome::where('user_id', $user->id)
            ->where('is_active', true)
            ->get()
            ->map(function ($ei) {
                $today = Carbon::now()->format('Y-m-d');
                $isOverdue = $ei->expected_date && $ei->expected_date->format('Y-m-d') < $today && in_array($ei->status, ['pending', 'delayed']);
                return [
                    'baslik' => $ei->title,
                    'tutar' => (float) $ei->amount,
                    'tur' => $ei->type,
                    'siklik' => $ei->frequency,
                    'beklenen_tarih' => $ei->expected_date ? $ei->expected_date->format('Y-m-d') : null,
                    'durum' => $ei->status,
                    'gecikmede_mi' => $isOverdue,
                ];
            })->toArray();

        // 2. Aylık Sabit Giderler Hesaplaması (Sadece İçinde Bulunulan Ay veya Son 30 Gün)
        $fixedExpensesSum = (float) Expense::where('user_id', $user->id)
            ->whereYear('expense_date', Carbon::now()->year)
            ->whereMonth('expense_date', Carbon::now()->month)
            ->sum('amount');

        if ($fixedExpensesSum <= 0) {
            $fixedExpensesSum = (float) Expense::where('user_id', $user->id)
                ->where('expense_date', '>=', Carbon::now()->subDays(30))
                ->sum('amount');
        }
        $expectedIncomesSum = (float) \App\Models\ExpectedIncome::where('user_id', $user->id)->where('is_active', true)->sum('amount');
        $totalMonthlyCommitment = (float) $riskSummary['total_monthly_commitment'];
        $totalMonthlyIncome = $monthlyIncome + $expectedIncomesSum;
        $netCashflow = $totalMonthlyIncome - ($fixedExpensesSum + $totalMonthlyCommitment);

        $incomeNote = $monthlyIncome > 0 
            ? 'Kullanıcının kayıtlı aylık geliri mevcuttur.' 
            : 'DİKKAT: Kullanıcı sisteme henüz aylık gelir kaydı girmemiştir (0 TL). Analizde gelirin henüz girilmediğini, bu yüzden açık hesabının gelir hariç yapıldığını belirtin.';

        $expenseNote = $fixedExpensesSum > 0 
            ? 'İçinde bulunulan ayki / son 30 günlük sabit giderler.' 
            : 'Kullanıcının bu ay kayıtlı sabit gideri bulunmamaktadır.';

        return [
            'aylik_gelir' => $monthlyIncome,
            'gelir_durumu_notu' => $incomeNote,
            'beklenen_gelirler_toplami' => $expectedIncomesSum,
            'toplam_aylik_gelir' => $totalMonthlyIncome,
            'sabit_giderler_toplami' => $fixedExpensesSum,
            'gider_durumu_notu' => $expenseNote,
            'toplam_asgari_borc_odemesi' => $totalMonthlyCommitment,
            'bu_ayki_net_nakit_acigi_veya_fazlasi' => $netCashflow,
            'toplam_borc' => (float) $riskSummary['total_remaining'],
            'bu_ay_yukumluluk' => $totalMonthlyCommitment,
            'en_yuksek_faizli' => $highestInterestDebt ?: 'Belirtilmedi',
            'yasal_takip_riski' => $legalRisks,
            'borclar' => $debtList,
            'beklenen_gelirler' => $expectedIncomes,
            'plan_stratejisi' => $activePlan?->strategy ?? 'avalanche',
            'para_birimi' => 'TRY',
        ];
    }
}
