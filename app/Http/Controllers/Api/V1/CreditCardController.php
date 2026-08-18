<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\CreditCard;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CreditCardController extends Controller
{
    public function index(): JsonResponse
    {
        $cards = CreditCard::where('user_id', Auth::id())->with('bank')->get();

        return response()->json([
            'status' => 'success',
            'data' => $cards,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'bank_id' => 'required|exists:banks,id',
            'name' => 'required|string|max:100',
            'last_four' => 'nullable|string|size:4',
            'credit_limit' => 'required|numeric|min:0',
            'current_debt' => 'required|numeric|min:0',
            'minimum_payment' => 'nullable|numeric|min:0',
            'statement_day' => 'required|integer|between:1,31',
            'due_day' => 'required|integer|between:1,31',
            'interest_rate' => 'nullable|numeric|min:0',
            'last_payment_date' => 'nullable|date',
        ]);

        $card = CreditCard::create([
            'user_id' => Auth::id(),
            'bank_id' => $validated['bank_id'],
            'name' => $validated['name'],
            'last_four' => $validated['last_four'] ?? null,
            'credit_limit' => $validated['credit_limit'],
            'current_debt' => $validated['current_debt'],
            'minimum_payment' => $validated['minimum_payment'] ?? ($validated['current_debt'] * 0.40),
            'statement_day' => $validated['statement_day'],
            'due_day' => $validated['due_day'],
            'interest_rate' => $validated['interest_rate'] ?? 4.25,
            'last_payment_date' => $validated['last_payment_date'] ?? null,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Kredi kartı eklendi.',
            'data' => $card->load('bank'),
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $card = CreditCard::where('user_id', Auth::id())->with('bank')->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $card,
        ]);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $card = CreditCard::where('user_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'bank_id' => 'sometimes|required|exists:banks,id',
            'name' => 'sometimes|required|string|max:100',
            'last_four' => 'nullable|string|size:4',
            'credit_limit' => 'sometimes|required|numeric|min:0',
            'current_debt' => 'sometimes|required|numeric|min:0',
            'minimum_payment' => 'nullable|numeric|min:0',
            'statement_day' => 'sometimes|required|integer|between:1,31',
            'due_day' => 'sometimes|required|integer|between:1,31',
            'interest_rate' => 'sometimes|required|numeric|min:0',
            'last_payment_date' => 'nullable|date',
        ]);

        $card->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Kredi kartı güncellendi.',
            'data' => $card->fresh()->load('bank'),
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $card = CreditCard::where('user_id', Auth::id())->findOrFail($id);
        $card->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Kart silindi.',
        ]);
    }
}
