<?php

namespace App\Services;

use App\Models\User;

class DebtCalculator
{
    /**
     * Borçları öncelik skoruna göre puanlar (Yüksek faiz + Yüksek gecikme = Yüksek öncelik)
     */
    public function calculatePriorityScore(array $debt): float
    {
        $interestRate = (float) ($debt['interest_rate'] ?? 0);
        $daysOverdue = (int) ($debt['days_overdue'] ?? 0);
        $remaining = (float) ($debt['remaining'] ?? 0);

        // Skor formülü: (Faiz * 15) + (Gecikme Günü * 2.5) + (10000 / remaining)
        $score = ($interestRate * 15) + ($daysOverdue * 2.5);
        if ($remaining > 0) {
            $score += min(20, 10000 / $remaining);
        }

        return round($score, 2);
    }

    /**
     * Kartopu (Snowball) ve Çığ (Avalanche) stratejilerini simüle eder ve karşılaştırır.
     */
    public function compareStrategies(array $debts, float $monthlyBudget): array
    {
        if (empty($debts) || $monthlyBudget <= 0) {
            return [
                'avalanche' => ['months' => 0, 'total_interest' => 0, 'total_paid' => 0],
                'snowball' => ['months' => 0, 'total_interest' => 0, 'total_paid' => 0],
                'savings_amount' => 0,
                'months_saved' => 0,
            ];
        }

        $avalancheResult = $this->simulateStrategy($debts, $monthlyBudget, 'avalanche');
        $snowballResult = $this->simulateStrategy($debts, $monthlyBudget, 'snowball');

        $savingsAmount = max(0, $snowballResult['total_interest'] - $avalancheResult['total_interest']);
        $monthsSaved = max(0, $snowballResult['months'] - $avalancheResult['months']);

        return [
            'avalanche' => $avalancheResult,
            'snowball' => $snowballResult,
            'savings_amount' => round($savingsAmount, 2),
            'months_saved' => $monthsSaved,
        ];
    }

    /**
     * Belirli bir strateji için simülasyon çalıştırır.
     */
    public function simulateStrategy(array $debts, float $monthlyBudget, string $strategy): array
    {
        // Klonla
        $activeDebts = array_map(function ($d) {
            return [
                'id' => $d['id'] ?? 0,
                'title' => $d['title'] ?? 'Borç',
                'remaining' => (float) ($d['remaining'] ?? 0),
                'interest_rate' => (float) ($d['interest_rate'] ?? 0) / 100, // aylık faiz oranı
                'min_payment' => (float) ($d['installment_amount'] ?? ($d['remaining'] * 0.10)),
            ];
        }, $debts);

        // Sıralama
        if ($strategy === 'avalanche') {
            // En yüksek faiz en başta
            usort($activeDebts, fn($a, $b) => $b['interest_rate'] <=> $a['interest_rate']);
        } else {
            // Kartopu: En küçük borç en başta
            usort($activeDebts, fn($a, $b) => $a['remaining'] <=> $b['remaining']);
        }

        $month = 0;
        $totalInterestPaid = 0;
        $totalPrincipalPaid = 0;
        $maxMonths = 120; // 10 yıl max sınır

        while ($month < $maxMonths) {
            $hasRemainingDebt = false;
            foreach ($activeDebts as $d) {
                if ($d['remaining'] > 0.01) {
                    $hasRemainingDebt = true;
                    break;
                }
            }

            if (!$hasRemainingDebt) {
                break;
            }

            $month++;
            $availableBudget = $monthlyBudget;

            // 1. Faizleri işlet
            foreach ($activeDebts as &$debt) {
                if ($debt['remaining'] > 0) {
                    $monthlyInterest = $debt['remaining'] * $debt['interest_rate'];
                    $totalInterestPaid += $monthlyInterest;
                    $debt['remaining'] += $monthlyInterest;
                }
            }
            unset($debt);

            // 2. Asgari ödemeleri yap
            foreach ($activeDebts as &$debt) {
                if ($debt['remaining'] > 0) {
                    $minPay = min($debt['min_payment'], $debt['remaining']);
                    $minPay = min($minPay, $availableBudget);
                    $debt['remaining'] -= $minPay;
                    $totalPrincipalPaid += $minPay;
                    $availableBudget -= $minPay;
                }
            }
            unset($debt);

            // 3. Kalan bütçeyi öncelikli borca yatır (Kartopu / Çığ odağı)
            if ($availableBudget > 0) {
                foreach ($activeDebts as &$debt) {
                    if ($debt['remaining'] > 0) {
                        $extraPay = min($debt['remaining'], $availableBudget);
                        $debt['remaining'] -= $extraPay;
                        $totalPrincipalPaid += $extraPay;
                        $availableBudget -= $extraPay;

                        if ($availableBudget <= 0) {
                            break;
                        }
                    }
                }
                unset($debt);
            }
        }

        return [
            'strategy' => $strategy,
            'months' => $month,
            'total_interest' => round($totalInterestPaid, 2),
            'total_paid' => round($totalPrincipalPaid + $totalInterestPaid, 2),
        ];
    }
}
