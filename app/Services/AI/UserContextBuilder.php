<?php

namespace App\Services\AI;

use App\Models\CreditCard;
use App\Models\Debt;
use App\Models\Income;
use App\Models\PaymentPlan;
use App\Models\User;
use App\Services\RiskCounter;
use Carbon\Carbon;

class UserContextBuilder
{
    /**
     * AI servisine gönderilecek anonimleştirilmiş finansal özet verisini üretir.
     */
    public function build(User $user): array
    {
        $monthlyIncome = (float) ($user->monthly_income ?: Income::where('user_id', $user->id)->sum('amount'));

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

        return [
            'aylik_gelir' => $monthlyIncome,
            'toplam_borc' => (float) $riskSummary['total_remaining'],
            'bu_ay_yukumluluk' => (float) $riskSummary['total_monthly_commitment'],
            'en_yuksek_faizli' => $highestInterestDebt ?: 'Belirtilmedi',
            'yasal_takip_riski' => $legalRisks,
            'borclar' => $debtList,
            'plan_stratejisi' => $activePlan?->strategy ?? 'avalanche',
            'para_birimi' => 'TRY',
        ];
    }
}
