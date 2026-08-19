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
    public string $activeTab = 'all'; // all, income, expense, expected, recurring
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
    public bool $showExpectedIncomeModal = false;

    // Beklenen Gelir Formu
    public ?int $expectedIncomeId = null;
    public string $expected_title = '';
    public float $expected_amount = 0.0;
    public string $expected_date = '';
    public string $expected_type = 'salary';
    public string $expected_frequency = 'monthly';
    public string $expected_notes = '';

    // Gelir Formu
    public ?int $incomeId = null;
    public string $income_title = '';
    public float $income_amount = 0.0;
    public string $income_date = '';
    public string $income_type = 'salary';
    public string $income_frequency = 'monthly';

    // Gider Formu
    public ?int $expenseId = null;
    public ?int $expense_category_id = null;
    public string $payment_method = 'credit_card'; // credit_card, account, kmh, cash
    public ?int $expense_credit_card_id = null;
    public ?int $expense_account_id = null;
    public bool $is_installment = false;
    public int $installment_count = 3;
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
        $this->income_date = Carbon::now()->format('Y-m-d');
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
        $this->income_date = $inc->income_date ? Carbon::parse($inc->income_date)->format('Y-m-d') : ($inc->created_at ? $inc->created_at->format('Y-m-d') : Carbon::now()->format('Y-m-d'));
        $this->income_type = $inc->type ?? 'salary';
        $this->income_frequency = $inc->frequency ?? 'monthly';
        $this->showIncomeModal = true;
    }

    public function saveIncome(): void
    {
        $this->validate([
            'income_title' => 'required|string|max:100',
            'income_amount' => 'required|numeric|min:1',
            'income_date' => 'required|date',
        ]);

        $day = !empty($this->income_date) ? \Carbon\Carbon::parse($this->income_date)->day : 1;

        $data = [
            'user_id' => Auth::id(),
            'title' => $this->income_title,
            'amount' => $this->income_amount,
            'income_date' => $this->income_date,
            'type' => $this->income_type,
            'frequency' => $this->income_frequency,
            'received_day' => $day,
            'is_recurring' => in_array($this->income_frequency, ['monthly', 'weekly']),
        ];

        if ($this->incomeId) {
            Income::where('user_id', Auth::id())->findOrFail($this->incomeId)->update($data);
        } else {
            Income::create($data);
            app(\App\Services\NotificationService::class)->triggerCashflowAlert(Auth::user(), 'income', (float) $this->income_amount, $this->income_title);
            $this->dispatch('refreshNotifications');
        }

        $this->showIncomeModal = false;
        $this->reset(['incomeId', 'income_title', 'income_amount', 'income_date']);
        session()->flash('message', 'Gelir kaydı başarıyla kaydedildi.');
    }

    public function openExpectedIncomeModal(): void
    {
        $this->reset(['expectedIncomeId', 'expected_title', 'expected_amount', 'expected_notes']);
        $this->expected_type = 'salary';
        $this->expected_frequency = 'monthly';
        $this->expected_date = Carbon::now()->format('Y-m-d');
        $this->showExpectedIncomeModal = true;
    }

    public function openEditExpectedIncome(int $id): void
    {
        $ei = \App\Models\ExpectedIncome::where('user_id', Auth::id())->findOrFail($id);
        $this->expectedIncomeId = $ei->id;
        $this->expected_title = $ei->title;
        $this->expected_amount = (float) $ei->amount;
        $this->expected_date = $ei->expected_date ? Carbon::parse($ei->expected_date)->format('Y-m-d') : Carbon::now()->format('Y-m-d');
        $this->expected_type = $ei->type ?? 'salary';
        $this->expected_frequency = $ei->frequency ?? 'monthly';
        $this->expected_notes = $ei->notes ?? '';
        $this->showExpectedIncomeModal = true;
    }

    public function saveExpectedIncome(): void
    {
        $this->validate([
            'expected_title' => 'required|string|max:100',
            'expected_amount' => 'required|numeric|min:1',
            'expected_date' => 'required|date',
        ]);

        $day = Carbon::parse($this->expected_date)->day;

        $data = [
            'user_id' => Auth::id(),
            'title' => $this->expected_title,
            'amount' => $this->expected_amount,
            'type' => $this->expected_type,
            'frequency' => $this->expected_frequency,
            'expected_day' => $day,
            'expected_date' => $this->expected_date,
            'notes' => $this->expected_notes,
            'is_active' => true,
            'status' => 'pending',
        ];

        if ($this->expectedIncomeId) {
            \App\Models\ExpectedIncome::where('user_id', Auth::id())->findOrFail($this->expectedIncomeId)->update($data);
        } else {
            \App\Models\ExpectedIncome::create($data);
        }

        $this->showExpectedIncomeModal = false;
        $this->reset(['expectedIncomeId', 'expected_title', 'expected_amount', 'expected_date', 'expected_notes']);
        session()->flash('message', 'Beklenen gelir başarıyla kaydedildi.');
    }

    public function deleteExpectedIncome(int $id): void
    {
        $ei = \App\Models\ExpectedIncome::where('user_id', Auth::id())->findOrFail($id);
        $ei->delete();
        session()->flash('message', 'Beklenen gelir kaydı silindi.');
    }

    public function confirmExpectedIncome(int $id): void
    {
        $ei = \App\Models\ExpectedIncome::where('user_id', Auth::id())->findOrFail($id);
        $ei->confirmReceived();
        session()->flash('message', '🎉 ' . $ei->title . ' (₺' . number_format($ei->amount, 2, ',', '.') . ') hesaba geçti olarak kaydedildi ve nakit akışına eklendi.');
    }

    public function delayExpectedIncome(int $id, int $days = 3): void
    {
        $ei = \App\Models\ExpectedIncome::where('user_id', Auth::id())->findOrFail($id);
        $ei->markDelayed($days);
        session()->flash('message', '⏳ ' . $ei->title . ' ' . $days . ' gün ertelendi (' . $ei->expected_date?->format('d.m.Y') . ').');
    }

    public function openExpenseModal(): void
    {
        $this->reset(['expenseId', 'expense_title', 'expense_amount', 'expense_category_id', 'expense_credit_card_id', 'expense_account_id', 'is_installment', 'expense_is_recurring']);
        $this->payment_method = 'credit_card';
        $this->installment_count = 3;
        $this->expense_date = Carbon::now()->format('Y-m-d');
        $this->showExpenseModal = true;
    }

    public function openEditExpense(int $id): void
    {
        $exp = Expense::where('user_id', Auth::id())->findOrFail($id);
        $this->expenseId = $exp->id;
        $this->expense_category_id = $exp->category_id;
        $this->payment_method = $exp->payment_method ?? 'credit_card';
        $this->expense_credit_card_id = $exp->credit_card_id;
        $this->expense_account_id = $exp->account_id;
        $this->is_installment = (bool) ($exp->installment_count > 1);
        $this->installment_count = $exp->installment_count ?: 3;
        $this->expense_title = $exp->title;
        $this->expense_amount = (float) ($exp->total_amount ?: $exp->amount);
        $this->expense_date = $exp->expense_date ? Carbon::parse($exp->expense_date)->format('Y-m-d') : Carbon::now()->format('Y-m-d');
        $this->expense_is_recurring = (bool) $exp->is_recurring;
        $this->showExpenseModal = true;
    }

    public function saveExpense(): void
    {
        $this->validate([
            'expense_title' => 'required|string|max:100',
            'expense_amount' => 'required|numeric|min:0.01',
            'expense_date' => 'required|date',
            'payment_method' => 'required|in:credit_card,account,kmh,cash',
            'expense_credit_card_id' => 'nullable|exists:credit_cards,id',
            'expense_account_id' => 'nullable|exists:accounts,id',
        ]);

        $userId = Auth::id();

        // 1. Taksitli Harcama Senaryosu
        if ($this->is_installment && $this->installment_count > 1 && !$this->expenseId) {
            $totalAmount = $this->expense_amount;
            $monthlyAmount = round($totalAmount / $this->installment_count, 2);

            // İlgili kredi kartı bilgisi
            $card = $this->expense_credit_card_id ? \App\Models\CreditCard::where('user_id', $userId)->find($this->expense_credit_card_id) : null;

            // Her bir taksiti ilgili aylara oluştur
            for ($i = 1; $i <= $this->installment_count; $i++) {
                $instDate = Carbon::parse($this->expense_date)->copy()->addMonthsNoOverflow($i - 1)->format('Y-m-d');
                Expense::create([
                    'user_id' => $userId,
                    'category_id' => $this->expense_category_id ?: null,
                    'credit_card_id' => $this->payment_method === 'credit_card' ? $this->expense_credit_card_id : null,
                    'account_id' => in_array($this->payment_method, ['account', 'kmh']) ? $this->expense_account_id : null,
                    'payment_method' => $this->payment_method,
                    'title' => $this->expense_title . ' (' . $i . '/' . $this->installment_count . ' Taksit)',
                    'amount' => $monthlyAmount,
                    'total_amount' => $totalAmount,
                    'installment_count' => $this->installment_count,
                    'current_installment' => $i,
                    'expense_date' => $instDate,
                    'is_recurring' => true,
                ]);
            }

            // Ayrıca Borçlar tablosuna taksitli borç olarak ekle
            \App\Models\Debt::create([
                'user_id' => $userId,
                'bank_id' => $card?->bank_id,
                'credit_card_id' => $this->payment_method === 'credit_card' ? $this->expense_credit_card_id : null,
                'account_id' => in_array($this->payment_method, ['account', 'kmh']) ? $this->expense_account_id : null,
                'type' => $this->payment_method === 'kmh' ? 'kmh' : 'credit_card',
                'title' => $this->expense_title . ' (' . $this->installment_count . ' Taksit)',
                'merchant_name' => $this->expense_title,
                'principal' => $totalAmount,
                'remaining' => $totalAmount,
                'installment_amount' => $monthlyAmount,
                'installment_count' => $this->installment_count,
                'current_installment' => 1,
                'total_installments' => $this->installment_count,
                'transaction_date' => $this->expense_date,
                'next_due_date' => $this->expense_date,
                'status' => 'active',
            ]);

            // Kredi kartının güncel borcunu ilk taksit kadar artır
            if ($card) {
                $card->increment('current_debt', $monthlyAmount);
            }
        } else {
            // 2. Tek Çekim / Peşin Harcama Senaryosu
            $data = [
                'user_id' => $userId,
                'category_id' => $this->expense_category_id ?: null,
                'credit_card_id' => $this->payment_method === 'credit_card' ? $this->expense_credit_card_id : null,
                'account_id' => in_array($this->payment_method, ['account', 'kmh']) ? $this->expense_account_id : null,
                'payment_method' => $this->payment_method,
                'title' => $this->expense_title,
                'amount' => $this->expense_amount,
                'total_amount' => $this->expense_amount,
                'installment_count' => null,
                'current_installment' => null,
                'expense_date' => $this->expense_date,
                'is_recurring' => $this->expense_is_recurring,
            ];

            if ($this->expenseId) {
                Expense::where('user_id', $userId)->findOrFail($this->expenseId)->update($data);
            } else {
                Expense::create($data);

                // Kredi kartı seçildiyse hem kart borcunu hem de Borçlar tablosundaki dönem borcunu otomatik artır
                if ($this->payment_method === 'credit_card' && $this->expense_credit_card_id) {
                    $card = \App\Models\CreditCard::where('user_id', $userId)->find($this->expense_credit_card_id);
                    if ($card) {
                        $card->increment('current_debt', $this->expense_amount);
                        // Asgari ödemeyi de güncelle (%20)
                        $card->update(['minimum_payment' => round($card->current_debt * 0.20, 2)]);
                    }

                    // Borçlar tablosundaki ekstre borcunu güncelle
                    $debt = \App\Models\Debt::where('user_id', $userId)
                        ->where('credit_card_id', $this->expense_credit_card_id)
                        ->where(function($q) {
                            $q->whereNull('total_installments')->orWhere('total_installments', '<=', 1);
                        })
                        ->first();

                    if ($debt) {
                        $debt->increment('remaining', $this->expense_amount);
                        $debt->increment('principal', $this->expense_amount);
                    }
                }
                // KMH veya Vadesiz Hesap seçildiyse bakiyeyi düşür
                elseif (in_array($this->payment_method, ['account', 'kmh']) && $this->expense_account_id) {
                    $acc = \App\Models\Account::where('user_id', $userId)->find($this->expense_account_id);
                    if ($acc) {
                        $acc->decrement('balance', $this->expense_amount);
                    }
                }

                app(\App\Services\NotificationService::class)->triggerCashflowAlert(Auth::user(), 'expense', (float) $this->expense_amount, $this->expense_title);
                $this->dispatch('refreshNotifications');
            }
        }

        $this->showExpenseModal = false;
        $this->reset(['expenseId', 'expense_title', 'expense_amount', 'expense_credit_card_id', 'expense_account_id']);
        session()->flash('message', 'Harcama kaydı başarıyla kaydedildi ve Borçlar & Kartlar alanları anında senkronize edildi.');
    }

    public function deleteIncome(int $id): void
    {
        Income::where('user_id', Auth::id())->findOrFail($id)->delete();
        session()->flash('message', 'Gelir kaydı silindi.');
    }

    public function deleteExpense(int $id): void
    {
        $userId = Auth::id();
        $exp = Expense::where('user_id', $userId)->findOrFail($id);

        // 1. Kredi kartı borcunu ve Borçlar tablosundaki kaydı otomatik geri düşür
        if ($exp->credit_card_id && $exp->payment_method === 'credit_card') {
            $card = \App\Models\CreditCard::where('user_id', $userId)->find($exp->credit_card_id);
            if ($card && $card->current_debt > 0) {
                $reduction = min((float)$card->current_debt, (float)$exp->amount);
                $card->decrement('current_debt', $reduction);
                $card->update(['minimum_payment' => round($card->current_debt * 0.20, 2)]);
            }

            $debt = \App\Models\Debt::where('user_id', $userId)
                ->where('credit_card_id', $exp->credit_card_id)
                ->where(function($q) {
                    $q->whereNull('total_installments')->orWhere('total_installments', '<=', 1);
                })
                ->first();

            if ($debt && $debt->remaining > 0) {
                $reduction = min((float)$debt->remaining, (float)$exp->amount);
                $debt->decrement('remaining', $reduction);
            }
        }
        // 2. Banka / KMH hesabı bakiyesini otomatik geri iade et
        elseif ($exp->account_id && in_array($exp->payment_method, ['account', 'kmh'])) {
            $acc = \App\Models\Account::where('user_id', $userId)->find($exp->account_id);
            if ($acc) {
                $acc->increment('balance', (float)$exp->amount);
            }
        }

        // 3. Taksitli bir işlem ise ve Borçlar tablosunda ilişkili kayıt varsa senkronize et
        if ($exp->total_amount && $exp->installment_count > 1) {
            $debt = \App\Models\Debt::where('user_id', $userId)
                ->where('merchant_name', $exp->title)
                ->orWhere('title', 'like', $exp->title . '%')
                ->first();
            if ($debt) {
                $debt->decrement('remaining', min((float)$debt->remaining, (float)$exp->amount));
                if ($debt->remaining <= 0) {
                    $debt->update(['status' => 'paid']);
                }
            }
        }

        $exp->delete();
        session()->flash('message', 'Gider kaydı silindi ve Borçlar & Kartlar bakiyesi otomatik olarak geri düşürüldü.');
    }



    public function exportExcel()
    {
        $userId = Auth::id();
        $incomes = Income::where('user_id', $userId)->get();
        $expenses = Expense::where('user_id', $userId)->with('category')->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="dvt_bank_nakit_akisi_' . date('Y-m-d_His') . '.csv"',
        ];

        $callback = function () use ($incomes, $expenses) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($file, [
                'Tarih',
                'İşlem Türü',
                'Kategori / Gelir Tipi',
                'Açıklama / Başlık',
                'Tutar (TL)',
                'Tekrarlayan Durum',
            ], ';');

            foreach ($incomes as $inc) {
                fputcsv($file, [
                    date('d.m.Y'),
                    'Gelir (+)',
                    $inc->type === 'salary' ? 'Maaş Geliri' : 'Ek Gelir',
                    $inc->title,
                    number_format($inc->amount, 2, ',', ''),
                    $inc->is_recurring ? 'Aylık Tekrarlayan' : 'Tek Seferlik',
                ], ';');
            }

            foreach ($expenses as $exp) {
                fputcsv($file, [
                    $exp->expense_date ? Carbon::parse($exp->expense_date)->format('d.m.Y') : date('d.m.Y'),
                    'Gider (-)',
                    $exp->category?->name ?? 'Genel Gider',
                    $exp->title,
                    number_format($exp->amount, 2, ',', ''),
                    $exp->is_recurring ? 'Aylık Sabit Fatura/Kira' : 'Değişken Harcama',
                ], ';');
            }

            fclose($file);
        };

        return response()->streamDownload($callback, 'dvt_bank_nakit_akisi_' . date('Y-m-d') . '.csv', $headers);
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
        if (!empty($this->date_from)) {
            $incomeQuery->where(function ($q) {
                $q->where('income_date', '>=', $this->date_from)
                  ->orWhere(function ($sq) {
                      $sq->whereNull('income_date')->where('created_at', '>=', $this->date_from);
                  });
            });
        }
        if (!empty($this->date_to)) {
            $incomeQuery->where(function ($q) {
                $q->where('income_date', '<=', $this->date_to)
                  ->orWhere(function ($sq) {
                      $sq->whereNull('income_date')->where('created_at', '<=', $this->date_to);
                  });
            });
        }

        // 2. GİDERLER SORGUSU
        $expenseQuery = Expense::where('user_id', $userId)->with(['category', 'creditCard.bank', 'account.bank']);
        if (!empty($this->search)) {
            $s = '%' . trim($this->search) . '%';
            $expenseQuery->where(function ($q) use ($s) {
                $q->where('title', 'like', $s)
                  ->orWhereHas('category', function ($cq) use ($s) {
                      $cq->where('name', 'like', $s);
                  })
                  ->orWhereHas('creditCard', function ($ccq) use ($s) {
                      $ccq->where('name', 'like', $s);
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
                    'category_name' => $inc->type === 'salary' ? 'Maaş / Ana Gelir' : ($inc->type === 'freelance' ? 'Hakediş / Serbest Gelir' : 'Ek Gelir'),
                    'date' => $inc->income_date ? Carbon::parse($inc->income_date)->format('Y-m-d') : ($inc->created_at ? $inc->created_at->format('Y-m-d') : Carbon::now()->format('Y-m-d')),
                    'is_recurring' => (bool) $inc->is_recurring,
                    'badge' => $inc->is_recurring ? 'Maaş / Düzenli Gelir' : 'Tek Seferlik Gelir',
                    'color' => '#10b981',
                    'source_label' => '💵 Banka / Maaş Hesabı',
                    'source_icon' => '💵',
                    'source_bank' => 'Maaş Hesabı',
                    'source_color' => '#10b981',
                    'installment_badge' => null,
                ]);
            }
        }

        if ($this->activeTab === 'all' || $this->activeTab === 'expense' || $this->activeTab === 'recurring') {
            foreach ($expenses as $exp) {
                if ($this->activeTab === 'recurring' && !$exp->is_recurring) {
                    continue;
                }

                $sourceLabel = '💵 Nakit / Cüzdan';
                $sourceIcon = '💵';
                $sourceBank = 'Nakit';
                $sourceColor = '#64748b';

                if ($exp->payment_method === 'credit_card' && $exp->creditCard) {
                    $sourceBank = $exp->creditCard->bank?->name ?? 'Banka Kartı';
                    $sourceLabel = ($exp->creditCard->bank?->name ?? 'Banka') . ' · ' . $exp->creditCard->name . ' (•••• ' . $exp->creditCard->last_four . ')';
                    $sourceIcon = '💳';
                    $sourceColor = $exp->creditCard->bank?->color ?? '#6366f1';
                } elseif (in_array($exp->payment_method, ['account', 'kmh']) && $exp->account) {
                    $sourceBank = $exp->account->bank?->name ?? 'Banka Hesabı';
                    $prefix = $exp->payment_method === 'kmh' ? '⚡ KMH: ' : '🏛️ ';
                    $sourceLabel = $prefix . ($exp->account->bank?->name ?? 'Banka') . ' · ' . $exp->account->name;
                    $sourceIcon = $exp->payment_method === 'kmh' ? '⚡' : '🏛️';
                    $sourceColor = $exp->account->bank?->color ?? '#0284c7';
                }

                $installmentBadge = null;
                if ($exp->installment_count && $exp->installment_count > 1) {
                    $installmentBadge = ($exp->current_installment ?: 1) . '/' . $exp->installment_count . ' Taksit';
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
                    'source_label' => $sourceLabel,
                    'source_icon' => $sourceIcon,
                    'source_bank' => $sourceBank,
                    'source_color' => $sourceColor,
                    'installment_badge' => $installmentBadge,
                ]);
            }
        }


        $expectedIncomes = \App\Models\ExpectedIncome::where('user_id', $userId)->active()->orderBy('expected_date', 'asc')->get();

        if ($this->activeTab === 'expected') {
            foreach ($expectedIncomes as $ei) {
                $stream->push((object) [
                    'id' => $ei->id,
                    'type' => 'expected_income',
                    'title' => $ei->title,
                    'amount' => (float) $ei->amount,
                    'category_name' => $ei->type === 'salary' ? 'Maaş / Ana Gelir' : ($ei->type === 'freelance' ? 'Hakediş' : 'Beklenen Gelir'),
                    'date' => $ei->expected_date ? $ei->expected_date->format('Y-m-d') : Carbon::now()->format('Y-m-d'),
                    'is_recurring' => $ei->frequency === 'monthly',
                    'badge' => $ei->status === 'delayed' ? '⏳ Gecikmeli Gelir' : '🔔 Beklenen Gelir',
                    'color' => '#14b8a6',
                    'source_label' => '🗓️ Vade: ' . ($ei->expected_date ? $ei->expected_date->format('d.m.Y') : '-'),
                    'source_icon' => '💵',
                    'source_bank' => 'Beklenen Nakit',
                    'source_color' => '#14b8a6',
                    'installment_badge' => $ei->frequency === 'monthly' ? 'Her Ay' : 'Tek Seferlik',
                    'status' => $ei->status,
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
        $totalExpectedIncome = $expectedIncomes->whereIn('status', ['pending', 'delayed'])->sum('amount');
        $netRemaining = $totalIncome - $totalExpense;
        $savingsRate = $totalIncome > 0 ? max(0, round(($netRemaining / $totalIncome) * 100)) : 0;

        $userCards = \App\Models\CreditCard::where('user_id', $userId)->with('bank')->get();
        $userAccounts = \App\Models\Account::where('user_id', $userId)->with('bank')->get();

        return view('livewire.cashflow.index', [
            'incomes' => $incomes,
            'expenses' => $expenses,
            'expectedIncomes' => $expectedIncomes,
            'totalExpectedIncome' => $totalExpectedIncome,
            'stream' => $stream,
            'categories' => $categories,
            'userCards' => $userCards,
            'userAccounts' => $userAccounts,
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'netRemaining' => $netRemaining,
            'savingsRate' => $savingsRate,
        ])->layout('layouts.app');
    }
}


