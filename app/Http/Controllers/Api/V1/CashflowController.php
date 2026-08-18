<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Expense;
use App\Models\Income;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CashflowController extends Controller
{
    public function summary(): JsonResponse
    {
        $userId = Auth::id();
        $incomes = Income::where('user_id', $userId)->get();
        $expenses = Expense::where('user_id', $userId)->with('category')->get();

        $totalIncome = $incomes->sum('amount');
        $totalExpense = $expenses->sum('amount');
        $netRemaining = $totalIncome - $totalExpense;

        return response()->json([
            'status' => 'success',
            'data' => [
                'total_income' => $totalIncome,
                'total_expense' => $totalExpense,
                'net_remaining' => $netRemaining,
                'incomes' => $incomes,
                'expenses' => $expenses,
            ],
        ]);
    }

    public function storeIncome(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'amount' => 'required|numeric|min:1',
            'type' => 'nullable|in:salary,freelance,rental,investment,other',
            'frequency' => 'nullable|in:monthly,weekly,one_time,irregular',
        ]);

        $income = Income::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'amount' => $validated['amount'],
            'type' => $validated['type'] ?? 'salary',
            'frequency' => $validated['frequency'] ?? 'monthly',
            'is_recurring' => true,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Gelir eklendi.',
            'data' => $income,
        ], 201);
    }

    public function destroyIncome(int $id): JsonResponse
    {
        $income = Income::where('user_id', Auth::id())->findOrFail($id);
        $income->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Gelir silindi.',
        ]);
    }

    public function storeExpense(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'title' => 'required|string|max:100',
            'amount' => 'required|numeric|min:1',
            'expense_date' => 'required|date',
            'is_recurring' => 'nullable|boolean',
        ]);

        $expense = Expense::create([
            'user_id' => Auth::id(),
            'category_id' => $validated['category_id'] ?? null,
            'title' => $validated['title'],
            'amount' => $validated['amount'],
            'expense_date' => $validated['expense_date'],
            'is_recurring' => $validated['is_recurring'] ?? false,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Gider eklendi.',
            'data' => $expense->load('category'),
        ], 201);
    }

    public function destroyExpense(int $id): JsonResponse
    {
        $expense = Expense::where('user_id', Auth::id())->findOrFail($id);
        $expense->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Gider silindi.',
        ]);
    }
}
