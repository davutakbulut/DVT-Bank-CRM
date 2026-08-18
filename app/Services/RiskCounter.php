<?php

namespace App\Services;

use App\Models\CreditCard;
use App\Models\Debt;
use App\Models\User;
use Carbon\Carbon;

class RiskCounter
{
    public const LEGAL_DEADLINE_DAYS = 90;

    /**
     * Kullanıcının borç ve kartlarına göre genel risk özetini hesaplar.
     */
    public function calculateUserRiskSummary(User $user): array
    {
        $debts = Debt::where('user_id', $user->id)
            ->where('status', 'active')
            ->with(['bank', 'creditCard', 'account'])
            ->get();

        $creditCards = CreditCard::where('user_id', $user->id)
            ->where('status', 'active')
            ->with('bank')
            ->get();

        $totalRemaining = $debts->sum('remaining');
        $totalMonthlyCommitment = 0;
        $maxOverdueDays = 0;
        $mostCriticalItem = null;

        $riskItems = [];

        foreach ($debts as $debt) {
            $daysOverdue = $debt->days_overdue;
            if ($debt->last_payment_date) {
                $daysSinceLastPayment = Carbon::parse($debt->last_payment_date)->diffInDays(now());
                if ($daysSinceLastPayment > $daysOverdue) {
                    $daysOverdue = (int) $daysSinceLastPayment;
                }
            }

            $daysToLegal = max(0, self::LEGAL_DEADLINE_DAYS - $daysOverdue);

            if ($daysOverdue > $maxOverdueDays) {
                $maxOverdueDays = $daysOverdue;
                $mostCriticalItem = [
                    'title' => $debt->title,
                    'bank' => $debt->bank?->name ?? 'Banka',
                    'bank_color' => $debt->bank?->color ?? '#64748B',
                    'amount' => $debt->remaining,
                    'days_overdue' => $daysOverdue,
                    'days_left' => $daysToLegal,
                    'type' => $debt->type,
                ];
            }

            $monthlyAmount = $debt->installment_amount ?? ($debt->type === 'kmh' ? ($debt->remaining * ($debt->interest_rate / 100)) : 0);
            $totalMonthlyCommitment += $monthlyAmount;

            $riskItems[] = [
                'id' => $debt->id,
                'title' => $debt->title,
                'bank_name' => $debt->bank?->name ?? 'Diğer',
                'bank_color' => $debt->bank?->color ?? '#64748B',
                'remaining' => $debt->remaining,
                'interest_rate' => $debt->interest_rate,
                'days_overdue' => $daysOverdue,
                'days_left' => $daysToLegal,
                'risk_level' => $this->getRiskLevel($daysToLegal),
                'next_due_date' => $debt->next_due_date,
            ];
        }

        // Kredi Kartı asgari tutarlarını da ekle
        foreach ($creditCards as $card) {
            $totalMonthlyCommitment += $card->minimum_payment;
        }

        // Aciliyete göre sırala (kalan gün en az olan en üstte)
        usort($riskItems, fn($a, $b) => $a['days_left'] <=> $b['days_left']);

        return [
            'total_remaining' => $totalRemaining,
            'total_monthly_commitment' => $totalMonthlyCommitment,
            'max_overdue_days' => $maxOverdueDays,
            'most_critical_item' => $mostCriticalItem,
            'risk_level' => $this->getRiskLevel(max(0, self::LEGAL_DEADLINE_DAYS - $maxOverdueDays)),
            'days_to_legal_minimum' => max(0, self::LEGAL_DEADLINE_DAYS - $maxOverdueDays),
            'items' => $riskItems,
        ];
    }

    public function getRiskLevel(int $daysLeft): string
    {
        if ($daysLeft <= 25) {
            return 'critical'; // Kırmızı alarm (yasal takibe çok yakın)
        }

        if ($daysLeft <= 50) {
            return 'warning'; // Sarı uyarı (ihtar süreci yaklaşıyor)
        }

        return 'normal'; // Yeşil / Güvenli alan
    }
}
