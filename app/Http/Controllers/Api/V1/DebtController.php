<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Debt;
use App\Models\PaymentLog;
use App\Services\DebtCalculator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DebtController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Debt::where('user_id', Auth::id())->with('bank');

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $debts = $query->orderBy('days_overdue', 'desc')->get();

        return response()->json([
            'status' => 'success',
            'data' => $debts,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        if (!Auth::user()->canCreateDebt()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ücretsiz planınız maksimum 5 borç eklemenize izin vermektedir. Sınırsız borç eklemek için Pro Plana yükseltin.',
                'upgrade_required' => true,
            ], 403);
        }

        $validated = $request->validate([
            'bank_id' => 'nullable|exists:banks,id',
            'type' => 'required|in:loan,kmh,credit_card,personal,other',
            'title' => 'required|string|max:150',
            'principal' => 'required|numeric|min:0',
            'remaining' => 'required|numeric|min:0',
            'interest_rate' => 'required|numeric|min:0',
            'installment_count' => 'nullable|integer|min:1',
            'installment_amount' => 'nullable|numeric|min:0',
            'next_due_date' => 'nullable|date',
            'last_payment_date' => 'nullable|date',
            'days_overdue' => 'nullable|integer|min:0',
            'notes' => 'nullable|string',
        ]);

        $debt = Debt::create([
            'user_id' => Auth::id(),
            'bank_id' => $validated['bank_id'] ?? null,
            'type' => $validated['type'],
            'title' => $validated['title'],
            'principal' => $validated['principal'],
            'remaining' => $validated['remaining'],
            'interest_rate' => $validated['interest_rate'],
            'installment_count' => $validated['installment_count'] ?? null,
            'installment_amount' => $validated['installment_amount'] ?? null,
            'next_due_date' => $validated['next_due_date'] ?? null,
            'last_payment_date' => $validated['last_payment_date'] ?? null,
            'days_overdue' => $validated['days_overdue'] ?? 0,
            'notes' => $validated['notes'] ?? null,
            'status' => $validated['remaining'] <= 0 ? 'paid' : 'active',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Borç kaydı oluşturuldu.',
            'data' => $debt->load('bank'),
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $debt = Debt::where('user_id', Auth::id())->with('bank')->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $debt,
        ]);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $debt = Debt::where('user_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'bank_id' => 'nullable|exists:banks,id',
            'type' => 'sometimes|required|in:loan,kmh,credit_card,personal,other',
            'title' => 'sometimes|required|string|max:150',
            'principal' => 'sometimes|required|numeric|min:0',
            'remaining' => 'sometimes|required|numeric|min:0',
            'interest_rate' => 'sometimes|required|numeric|min:0',
            'installment_count' => 'nullable|integer|min:1',
            'installment_amount' => 'nullable|numeric|min:0',
            'next_due_date' => 'nullable|date',
            'last_payment_date' => 'nullable|date',
            'days_overdue' => 'nullable|integer|min:0',
            'notes' => 'nullable|string',
        ]);

        $debt->update($validated);

        if (isset($validated['remaining']) && $validated['remaining'] <= 0) {
            $debt->update(['status' => 'paid']);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Borç güncellendi.',
            'data' => $debt->fresh()->load('bank'),
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $debt = Debt::where('user_id', Auth::id())->findOrFail($id);
        $debt->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Borç silindi.',
        ]);
    }

    public function pay(Request $request, int $id): JsonResponse
    {
        $debt = Debt::where('user_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'note' => 'nullable|string|max:255',
        ]);

        $amount = (float) $validated['amount'];

        PaymentLog::create([
            'user_id' => Auth::id(),
            'payable_type' => Debt::class,
            'payable_id' => $debt->id,
            'amount' => $amount,
            'paid_at' => now(),
            'method' => 'manual',
            'note' => $validated['note'] ?? 'API üzerinden borç ödemesi yapıldı',
        ]);

        $debt->remaining = max(0, $debt->remaining - $amount);
        $debt->last_payment_date = now();
        $debt->days_overdue = 0;
        if ($debt->remaining <= 0) {
            $debt->status = 'paid';
        }
        $debt->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Ödeme başarıyla işlendi ve borç bakiyesi düşürüldü.',
            'data' => $debt->fresh()->load('bank'),
        ]);
    }

    public function priorityOrder(): JsonResponse
    {
        $debts = Debt::where('user_id', Auth::id())->where('status', 'active')->get();
        $calc = new DebtCalculator();
        $priorities = $calc->calculatePriorityList($debts->toArray());

        return response()->json([
            'status' => 'success',
            'data' => $priorities,
        ]);
    }
}
