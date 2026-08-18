<?php

namespace App\Services;

use App\Models\Debt;
use App\Models\PaymentPlan;
use App\Models\PaymentPlanItem;
use App\Models\User;
use Carbon\Carbon;

class PaymentPlanner
{
    /**
     * Kullanıcının seçtiği stratejiye (avalanche/snowball) ve aylık bütçesine göre plan üretir.
     */
    public function generatePlan(User $user, float $monthlyBudget, string $strategy = 'avalanche', string $planName = 'Kurtarma Planı'): PaymentPlan
    {
        // Varsa eski taslak veya aktif planı kapat/arşivle
        PaymentPlan::where('user_id', $user->id)->where('status', 'active')->update(['status' => 'completed']);

        $plan = PaymentPlan::create([
            'user_id' => $user->id,
            'name' => $planName,
            'strategy' => $strategy,
            'monthly_budget' => $monthlyBudget,
            'status' => 'active',
            'created_via' => 'wizard',
        ]);

        $debts = Debt::where('user_id', $user->id)
            ->where('status', 'active')
            ->get();

        if ($debts->isEmpty() || $monthlyBudget <= 0) {
            return $plan;
        }

        // Simülasyon verisi hazırla
        $simDebts = $debts->map(function ($d) {
            return [
                'id' => $d->id,
                'title' => $d->title,
                'remaining' => (float) $d->remaining,
                'interest_rate' => (float) $d->interest_rate / 100,
                'min_payment' => (float) ($d->installment_amount ?: ($d->remaining * 0.10)),
            ];
        })->toArray();

        // Stratejiye göre sırala
        if ($strategy === 'avalanche') {
            usort($simDebts, fn($a, $b) => $b['interest_rate'] <=> $a['interest_rate']);
        } else {
            usort($simDebts, fn($a, $b) => $a['remaining'] <=> $b['remaining']);
        }

        $currentMonth = Carbon::now()->startOfMonth();
        $monthCounter = 0;
        $maxMonths = 48; // Max 4 yıl projeksiyon

        while ($monthCounter < $maxMonths) {
            $hasRemaining = false;
            foreach ($simDebts as $d) {
                if ($d['remaining'] > 0.01) {
                    $hasRemaining = true;
                    break;
                }
            }

            if (!$hasRemaining) {
                break;
            }

            $currentMonth = $currentMonth->copy()->addMonth();
            $monthCounter++;
            $availableBudget = $monthlyBudget;
            $priority = 1;

            // 1. Faiz işlet
            foreach ($simDebts as &$sd) {
                if ($sd['remaining'] > 0) {
                    $sd['remaining'] += ($sd['remaining'] * $sd['interest_rate']);
                }
            }
            unset($sd);

            // 2. Asgari ödemeleri dağıt
            foreach ($simDebts as &$sd) {
                if ($sd['remaining'] > 0) {
                    $allocated = min($sd['min_payment'], $sd['remaining']);
                    $allocated = min($allocated, $availableBudget);

                    if ($allocated > 0) {
                        PaymentPlanItem::create([
                            'payment_plan_id' => $plan->id,
                            'debt_id' => $sd['id'],
                            'priority' => $priority++,
                            'allocated_amount' => round($allocated, 2),
                            'month' => $currentMonth->format('Y-m-d'),
                            'status' => 'pending',
                        ]);

                        $sd['remaining'] -= $allocated;
                        $availableBudget -= $allocated;
                    }
                }
            }
            unset($sd);

            // 3. Kalan bütçeyi öncelikli borca ek ödeme olarak dağıt
            if ($availableBudget > 0) {
                foreach ($simDebts as &$sd) {
                    if ($sd['remaining'] > 0) {
                        $extra = min($sd['remaining'], $availableBudget);
                        if ($extra > 0) {
                            // Var olan ayı güncelle veya ek kalem
                            PaymentPlanItem::create([
                                'payment_plan_id' => $plan->id,
                                'debt_id' => $sd['id'],
                                'priority' => 99, // Ekstra kartopu/çığ payı
                                'allocated_amount' => round($extra, 2),
                                'month' => $currentMonth->format('Y-m-d'),
                                'status' => 'pending',
                            ]);

                            $sd['remaining'] -= $extra;
                            $availableBudget -= $extra;
                        }

                        if ($availableBudget <= 0) {
                            break;
                        }
                    }
                }
                unset($sd);
            }
        }

        return $plan;
    }
}
