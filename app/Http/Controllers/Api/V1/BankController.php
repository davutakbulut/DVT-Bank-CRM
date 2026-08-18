<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BankController extends Controller
{
    public function index(): JsonResponse
    {
        $banks = Bank::all();

        return response()->json([
            'status' => 'success',
            'data' => $banks,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'required|string|max:20',
            'color' => 'nullable|string|max:7',
        ]);

        $bank = Bank::create([
            'user_id' => Auth::id(),
            'name' => $validated['name'],
            'code' => strtoupper($validated['code']),
            'color' => $validated['color'] ?? '#6366f1',
            'is_system' => false,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Banka başarıyla eklendi.',
            'data' => $bank,
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $bank = Bank::findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $bank,
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $bank = Bank::where('user_id', Auth::id())->findOrFail($id);
        $bank->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Banka silindi.',
        ]);
    }
}
