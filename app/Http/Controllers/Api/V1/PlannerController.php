<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Debt;
use App\Models\PaymentLog;
use App\Models\PaymentPlan;
use App\Models\PaymentPlanItem;
use App\Services\DebtCalculator;
use App\Services\PaymentPlanner;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlannerController extends Controller
{
    public function activePlan(): JsonResponse
    {
        $plan = PaymentPlan::where('user_id', Auth::id())
            ->where('status', 'active')
            ->with(['items.debt.bank'])
            ->latest()
            ->first();

        return response()->json([
            'status' => 'success',
            'data' => $plan,
        ]);
    }

    public function compareStrategies(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'monthly_budget' => 'required|numeric|min:100',
        ]);

        $debts = Debt::where('user_id', Auth::id())->where('status', 'active')->get();
        $calc = new DebtCalculator();
        $comparison = $calc->compareStrategies($debts->toArray(), (float) $validated['monthly_budget']);

        return response()->json([
            'status' => 'success',
            'data' => $comparison,
        ]);
    }

    public function generate(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'monthly_budget' => 'required|numeric|min:500',
            'strategy' => 'required|in:avalanche,snowball,custom',
            'plan_name' => 'nullable|string|max:100',
        ]);

        $planner = new PaymentPlanner();
        $plan = $planner->generatePlan(
            user: Auth::user(),
            monthlyBudget: (float) $validated['monthly_budget'],
            strategy: $validated['strategy'],
            planName: $validated['plan_name'] ?? 'Ödeme Kurtarma Planı'
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Ödeme planı oluşturuldu.',
            'data' => $plan->load('items.debt.bank'),
        ], 201);
    }

    public function markItemPaid(int $itemId): JsonResponse
    {
        $item = PaymentPlanItem::with('debt')->findOrFail($itemId);

        if ($item->paymentPlan->user_id !== Auth::id()) {
            return response()->json(['status' => 'error', 'message' => 'Yetkisiz işlem.'], 403);
        }

        if ($item->status !== 'paid') {
            $item->update(['status' => 'paid']);

            if ($item->debt) {
                PaymentLog::create([
                    'user_id' => Auth::id(),
                    'payable_type' => Debt::class,
                    'payable_id' => $item->debt->id,
                    'amount' => $item->allocated_amount,
                    'paid_at' => now(),
                    'method' => 'manual',
                    'note' => 'Plan ödemesi API ile işlendi',
                ]);

                $item->debt->remaining = max(0, $item->debt->remaining - $item->allocated_amount);
                $item->debt->last_payment_date = now();
                $item->debt->days_overdue = 0;
                if ($item->debt->remaining <= 0) {
                    $item->debt->status = 'paid';
                }
                $item->debt->save();
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Plan ödemesi tamamlandı ve borç bakiyesi düşüldü.',
            'data' => $item->fresh(),
        ]);
    }
}
