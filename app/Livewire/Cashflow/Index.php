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
    // Filtreleme & Arama Özellikleri
    public string $activeTab = 'all'; // all, income, expense, recurring
    public string $search = '';
    public ?int $selected_category_id = null;
    public ?string $date_from = null;
    public ?string $date_to = null;
    public string $date_preset = 'this_month'; // all, this_month, last_30, last_month, this_year
    public string $sortBy = 'date_desc'; // date_desc, date_asc, amount_desc, amount_asc, title
    public string $viewMode = 'feed'; // feed (zaman akışı), columns (çift kolon), table (tablo)

    // Modallar
    public bool $showIncomeModal = false;
    public bool $showExpenseModal = false;

    // Gelir Formu
    public ?int $incomeId = null;
    public string $income_title = '';
    public float $income_amount = 0.0;
    public string $income_type = 'salary';
    public string $income_frequency = 'monthly';

    // Gider Formu
    public ?int $expenseId = null;
    public ?int $expense_category_id = null;
    public string $expense_title = '';
    public float $expense_amount = 0.0;
    public string $expense_date = '';
    public bool $expense_is_recurring = false;

    public function mount(): void
    {
        $this->setDatePreset('this_month');
    }

    public function setDatePreset(string $preset): void
    {
        $this->date_preset = $preset;

        if ($preset === 'this_month') {
            $this->date_from = Carbon::now()->startOfMonth()->format('Y-m-d');
            $this->date_to = Carbon::now()->endOfMonth()->format('Y-m-d');
        } elseif ($preset === 'last_30') {
            $this->date_from = Carbon::now()->subDays(30)->format('Y-m-d');
            $this->date_to = Carbon::now()->format('Y-m-d');
        } elseif ($preset === 'last_month') {
            $this->date_from = Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d');
            $this->date_to = Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d');
        } elseif ($preset === 'this_year') {
            $this->date_from = Carbon::now()->startOfYear()->format('Y-m-d');
            $this->date_to = Carbon::now()->endOfYear()->format('Y-m-d');
        } else {
            $this->date_from = null;
            $this->date_to = null;
        }
    }

    public function resetFilters(): void
    {
        $this->reset([
            'search',
            'selected_category_id',
            'activeTab',
            'date_from',
            'date_to',
            'date_preset',
            'sortBy',
        ]);
        $this->sortBy = 'date_desc';
        $this->setDatePreset('this_month');
    }

    public function openIncomeModal(): void
    {
        $this->reset(['incomeId', 'income_title', 'income_amount']);
        $this->income_type = 'salary';
        $this->income_frequency = 'monthly';
        $this->showIncomeModal = true;
    }

    public function openEditIncome(int $id): void
    {
        $inc = Income::where('user_id', Auth::id())->findOrFail($id);
        $this->incomeId = $inc->id;
        $this->income_title = $inc->title;
        $this->income_amount = (float) $inc->amount;
        $this->income_type = $inc->type ?? 'salary';
        $this->income_frequency = $inc->frequency ?? 'monthly';
        $this->showIncomeModal = true;
    }

    public function saveIncome(): void
    {
        $this->validate([
            'income_title' => 'required|string|max:100',
            'income_amount' => 'required|numeric|min:1',
        ]);

        $data = [
            'user_id' => Auth::id(),
            'title' => $this->income_title,
            'amount' => $this->income_amount,
            'type' => $this->income_type,
            'frequency' => $this->income_frequency,
            'is_recurring' => true,
        ];

        if ($this->incomeId) {
            Income::where('user_id', Auth::id())->findOrFail($this->incomeId)->update($data);
        } else {
            Income::create($data);
        }

        $this->showIncomeModal = false;
        $this->reset(['incomeId', 'income_title', 'income_amount']);
        session()->flash('message', 'Gelir kaydı başarıyla kaydedildi.');
    }

    public function openExpenseModal(): void
    {
        $this->reset(['expenseId', 'expense_title', 'expense_amount', 'expense_category_id', 'expense_is_recurring']);
        $this->expense_date = Carbon::now()->format('Y-m-d');
        $this->showExpenseModal = true;
    }

    public function openEditExpense(int $id): void
    {
        $exp = Expense::where('user_id', Auth::id())->findOrFail($id);
        $this->expenseId = $exp->id;
        $this->expense_category_id = $exp->category_id;
        $this->expense_title = $exp->title;
        $this->expense_amount = (float) $exp->amount;
        $this->expense_date = $exp->expense_date ? Carbon::parse($exp->expense_date)->format('Y-m-d') : Carbon::now()->format('Y-m-d');
        $this->expense_is_recurring = (bool) $exp->is_recurring;
        $this->showExpenseModal = true;
    }

    public function saveExpense(): void
    {
        $this->validate([
            'expense_title' => 'required|string|max:100',
            'expense_amount' => 'required|numeric|min:1',
            'expense_date' => 'required|date',
        ]);

        $data = [
            'user_id' => Auth::id(),
            'category_id' => $this->expense_category_id ?: null,
            'title' => $this->expense_title,
            'amount' => $this->expense_amount,
            'expense_date' => $this->expense_date,
            'is_recurring' => $this->expense_is_recurring,
        ];

        if ($this->expenseId) {
            Expense::where('user_id', Auth::id())->findOrFail($this->expenseId)->update($data);
        } else {
            Expense::create($data);
        }

        $this->showExpenseModal = false;
        $this->reset(['expenseId', 'expense_title', 'expense_amount']);
        session()->flash('message', 'Gider kaydı başarıyla kaydedildi.');
    }

    public function deleteIncome(int $id): void
    {
        Income::where('user_id', Auth::id())->findOrFail($id)->delete();
        session()->flash('message', 'Gelir kaydı silindi.');
    }

    public function deleteExpense(int $id): void
    {
        Expense::where('user_id', Auth::id())->findOrFail($id)->delete();
        session()->flash('message', 'Gider kaydı silindi.');
    }

    public function render()
    {
        $userId = Auth::id();
        $categories = Category::where('type', 'expense')->get();

        // 1. GELİRLER SORGUSU
        $incomeQuery = Income::where('user_id', $userId);
        if (!empty($this->search)) {
            $s = '%' . trim($this->search) . '%';
            $incomeQuery->where('title', 'like', $s);
        }

        // 2. GİDERLER SORGUSU
        $expenseQuery = Expense::where('user_id', $userId)->with('category');
        if (!empty($this->search)) {
            $s = '%' . trim($this->search) . '%';
            $expenseQuery->where(function ($q) use ($s) {
                $q->where('title', 'like', $s)
                  ->orWhereHas('category', function ($cq) use ($s) {
                      $cq->where('name', 'like', $s);
                  });
            });
        }
        if (!empty($this->selected_category_id)) {
            $expenseQuery->where('category_id', $this->selected_category_id);
        }
        if (!empty($this->date_from)) {
            $expenseQuery->where('expense_date', '>=', $this->date_from);
        }
        if (!empty($this->date_to)) {
            $expenseQuery->where('expense_date', '<=', $this->date_to);
        }

        $incomes = $incomeQuery->get();
        $expenses = $expenseQuery->get();

        // 3. Ortak Akış Öğeleri (Unified Feed Stream)
        $stream = collect();

        if ($this->activeTab === 'all' || $this->activeTab === 'income' || $this->activeTab === 'recurring') {
            foreach ($incomes as $inc) {
                if ($this->activeTab === 'recurring' && !$inc->is_recurring) {
                    continue;
                }
                $stream->push((object) [
                    'id' => $inc->id,
                    'type' => 'income',
                    'title' => $inc->title,
                    'amount' => (float) $inc->amount,
                    'category_name' => $inc->type === 'salary' ? 'Maaş / Ana Gelir' : 'Ek Gelir',
                    'date' => Carbon::now()->startOfMonth()->format('Y-m-d'), // Aylık periyot
                    'is_recurring' => true,
                    'badge' => 'Maaş / Düzenli Gelir',
                    'color' => '#10b981',
                ]);
            }
        }

        if ($this->activeTab === 'all' || $this->activeTab === 'expense' || $this->activeTab === 'recurring') {
            foreach ($expenses as $exp) {
                if ($this->activeTab === 'recurring' && !$exp->is_recurring) {
                    continue;
                }
                $stream->push((object) [
                    'id' => $exp->id,
                    'type' => 'expense',
                    'title' => $exp->title,
                    'amount' => (float) $exp->amount,
                    'category_name' => $exp->category?->name ?? 'Genel Gider',
                    'date' => $exp->expense_date ? Carbon::parse($exp->expense_date)->format('Y-m-d') : Carbon::now()->format('Y-m-d'),
                    'is_recurring' => (bool) $exp->is_recurring,
                    'badge' => $exp->category?->name ?? 'Gider',
                    'color' => $exp->category?->color ?? '#ef4444',
                ]);
            }
        }

        // Sıralama
        if ($this->sortBy === 'date_desc') {
            $stream = $stream->sortByDesc('date');
        } elseif ($this->sortBy === 'date_asc') {
            $stream = $stream->sortBy('date');
        } elseif ($this->sortBy === 'amount_desc') {
            $stream = $stream->sortByDesc('amount');
        } elseif ($this->sortBy === 'amount_asc') {
            $stream = $stream->sortBy('amount');
        } elseif ($this->sortBy === 'title') {
            $stream = $stream->sortBy('title');
        }

        // Finansal KPI Özetleri
        $totalIncome = $incomes->sum('amount');
        $totalExpense = $expenses->sum('amount');
        $netRemaining = $totalIncome - $totalExpense;
        $savingsRate = $totalIncome > 0 ? max(0, round(($netRemaining / $totalIncome) * 100)) : 0;

        return view('livewire.cashflow.index', [
            'incomes' => $incomes,
            'expenses' => $expenses,
            'stream' => $stream,
            'categories' => $categories,
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'netRemaining' => $netRemaining,
            'savingsRate' => $savingsRate,
        ])->layout('layouts.app');
    }
}

