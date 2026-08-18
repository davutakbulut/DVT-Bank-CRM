<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index(): JsonResponse
    {
        $accounts = Account::where('user_id', Auth::id())->with('bank')->get();

        return response()->json([
            'status' => 'success',
            'data' => $accounts,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'bank_id' => 'required|exists:banks,id',
            'name' => 'required|string|max:100',
            'type' => 'required|in:checking,savings,kmh',
            'iban' => 'nullable|string|max:34',
            'balance' => 'required|numeric',
            'kmh_limit' => 'nullable|numeric|min:0',
            'kmh_interest_rate' => 'nullable|numeric|min:0',
        ]);

        $account = Account::create([
            'user_id' => Auth::id(),
            'bank_id' => $validated['bank_id'],
            'name' => $validated['name'],
            'type' => $validated['type'],
            'iban' => $validated['iban'] ?? null,
            'balance' => $validated['balance'],
            'kmh_limit' => $validated['type'] === 'kmh' ? ($validated['kmh_limit'] ?? null) : null,
            'kmh_interest_rate' => $validated['type'] === 'kmh' ? ($validated['kmh_interest_rate'] ?? 5.0) : null,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Hesap kaydedildi.',
            'data' => $account->load('bank'),
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $account = Account::where('user_id', Auth::id())->with('bank')->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $account,
        ]);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $account = Account::where('user_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'bank_id' => 'sometimes|required|exists:banks,id',
            'name' => 'sometimes|required|string|max:100',
            'type' => 'sometimes|required|in:checking,savings,kmh',
            'iban' => 'nullable|string|max:34',
            'balance' => 'sometimes|required|numeric',
            'kmh_limit' => 'nullable|numeric|min:0',
            'kmh_interest_rate' => 'nullable|numeric|min:0',
        ]);

        $account->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Hesap güncellendi.',
            'data' => $account->fresh()->load('bank'),
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $account = Account::where('user_id', Auth::id())->findOrFail($id);
        $account->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Hesap silindi.',
        ]);
    }
}
