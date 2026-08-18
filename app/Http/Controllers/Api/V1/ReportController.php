<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Debt;
use App\Models\Expense;
use App\Models\Income;
use App\Models\PaymentLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function overview(): JsonResponse
    {
        $userId = Auth::id();
        $debts = Debt::where('user_id', $userId)->where('status', 'active')->with('bank')->get();
        $logs = PaymentLog::where('user_id', $userId)->latest('paid_at')->take(10)->get();

        $totalRemaining = $debts->sum('remaining');
        $totalMonthlyIncome = Income::where('user_id', $userId)->sum('amount');
        $totalMonthlyExpense = Expense::where('user_id', $userId)->sum('amount');
        $netSavings = max(0, $totalMonthlyIncome - $totalMonthlyExpense);

        $monthsToPayoff = $netSavings > 0 ? ceil($totalRemaining / $netSavings) : null;

        // Banka bazlı faiz analizi
        $bankCostSummary = $debts->groupBy(fn($d) => $d->bank?->name ?? 'Diğer')->map(function ($group) {
            $totalDebt = $group->sum('remaining');
            $avgInterest = $group->avg('interest_rate');
            $monthlyInterest = $group->sum(fn($d) => $d->remaining * ($d->interest_rate / 100));

            return [
                'total_debt' => $totalDebt,
                'avg_monthly_interest_rate' => $avgInterest,
                'monthly_interest_cost' => $monthlyInterest,
                'annual_interest_cost' => $monthlyInterest * 12,
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => [
                'total_remaining_debt' => $totalRemaining,
                'net_monthly_budget' => $netSavings,
                'estimated_payoff_months' => $monthsToPayoff,
                'bank_cost_breakdown' => $bankCostSummary,
                'recent_payments' => $logs,
            ],
        ]);
    }
}
