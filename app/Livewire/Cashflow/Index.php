<?php

namespace App\Livewire\Cashflow;

use App\Models\Category;
use App\Models\Expense;
use App\Models\Income;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public bool $showIncomeModal = false;
    public bool $showExpenseModal = false;

    // Gelir Formu
    public string $income_title = '';
    public float $income_amount = 0.0;
    public string $income_type = 'salary';
    public string $income_frequency = 'monthly';

    // Gider Formu
    public ?int $expense_category_id = null;
    public string $expense_title = '';
    public float $expense_amount = 0.0;
    public string $expense_date = '';
    public bool $expense_is_recurring = false;

    public function openIncomeModal(): void
    {
        $this->reset(['income_title', 'income_amount']);
        $this->income_type = 'salary';
        $this->income_frequency = 'monthly';
        $this->showIncomeModal = true;
    }

    public function saveIncome(): void
    {
        $this->validate([
            'income_title' => 'required|string|max:100',
            'income_amount' => 'required|numeric|min:1',
        ]);

        Income::create([
            'user_id' => Auth::id(),
            'title' => $this->income_title,
            'amount' => $this->income_amount,
            'type' => $this->income_type,
            'frequency' => $this->income_frequency,
            'is_recurring' => true,
        ]);

        $this->showIncomeModal = false;
        $this->reset(['income_title', 'income_amount']);
        session()->flash('message', 'Gelir kaydı eklendi.');
    }

    public function openExpenseModal(): void
    {
        $this->reset(['expense_title', 'expense_amount', 'expense_category_id', 'expense_is_recurring']);
        $this->expense_date = Carbon::now()->format('Y-m-d');
        $this->showExpenseModal = true;
    }

    public function saveExpense(): void
    {
        $this->validate([
            'expense_title' => 'required|string|max:100',
            'expense_amount' => 'required|numeric|min:1',
            'expense_date' => 'required|date',
        ]);

        Expense::create([
            'user_id' => Auth::id(),
            'category_id' => $this->expense_category_id ?: null,
            'title' => $this->expense_title,
            'amount' => $this->expense_amount,
            'expense_date' => $this->expense_date,
            'is_recurring' => $this->expense_is_recurring,
        ]);

        $this->showExpenseModal = false;
        $this->reset(['expense_title', 'expense_amount']);
        session()->flash('message', 'Gider kaydı eklendi.');
    }

    public function deleteIncome(int $id): void
    {
        Income::where('user_id', Auth::id())->findOrFail($id)->delete();
        session()->flash('message', 'Gelir silindi.');
    }

    public function deleteExpense(int $id): void
    {
        Expense::where('user_id', Auth::id())->findOrFail($id)->delete();
        session()->flash('message', 'Gider silindi.');
    }

    public function render()
    {
        $user = Auth::user();
        $incomes = Income::where('user_id', $user->id)->get();
        $expenses = Expense::where('user_id', $user->id)->with('category')->latest('expense_date')->get();
        $categories = Category::where('type', 'expense')->get();

        $totalIncome = $incomes->sum('amount');
        $totalExpense = $expenses->sum('amount');
        $netRemaining = $totalIncome - $totalExpense;

        return view('livewire.cashflow.index', [
            'incomes' => $incomes,
            'expenses' => $expenses,
            'categories' => $categories,
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'netRemaining' => $netRemaining,
        ])->layout('layouts.app');
    }
}
