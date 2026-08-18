<?php

namespace App\Livewire\Reports;

use App\Models\Debt;
use App\Models\Expense;
use App\Models\Income;
use App\Models\PaymentLog;
use App\Services\RiskCounter;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $user = Auth::user();
        $debts = Debt::where('user_id', $user->id)->where('status', 'active')->with('bank')->get();
        $paymentLogs = PaymentLog::where('user_id', $user->id)->latest('paid_at')->take(10)->get();

        $totalRemaining = $debts->sum('remaining');
        $totalMonthlyIncome = Income::where('user_id', $user->id)->sum('amount');
        $totalMonthlyExpense = Expense::where('user_id', $user->id)->sum('amount');
        $netMonthlySavings = max(500, $totalMonthlyIncome - $totalMonthlyExpense);

        $estimatedPayoffMonths = $netMonthlySavings > 0 ? ceil($totalRemaining / $netMonthlySavings) : 0;

        // Banka bazında toplam faiz yükü
        $bankCostSummary = $debts->groupBy(fn($d) => $d->bank?->name ?? 'Diğer')->map(function ($group) {
            $totalDebt = $group->sum('remaining');
            $avgInterest = $group->avg('interest_rate');
            $monthlyInterestCost = $group->sum(fn($d) => $d->remaining * ($d->interest_rate / 100));

            return [
                'total_debt' => $totalDebt,
                'avg_interest' => $avgInterest,
                'monthly_interest_cost' => $monthlyInterestCost,
                'annual_interest_cost' => $monthlyInterestCost * 12,
            ];
        });

        return view('livewire.reports.index', [
            'debts' => $debts,
            'paymentLogs' => $paymentLogs,
            'totalRemaining' => $totalRemaining,
            'estimatedPayoffMonths' => $estimatedPayoffMonths,
            'netMonthlySavings' => $netMonthlySavings,
            'bankCostSummary' => $bankCostSummary,
        ])->layout('layouts.app');
    }
}
