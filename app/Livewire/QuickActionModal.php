<?php

namespace App\Livewire;

use App\Models\Bank;
use App\Models\Category;
use App\Models\CreditCard;
use App\Models\Debt;
use App\Models\Expense;
use App\Models\Income;
use App\Services\NaturalLanguageTransactionParser;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class QuickActionModal extends Component
{
    public bool $isOpen = false;
    public string $activeTab = 'ai'; // ai, expense, debt, bulk

    // AI Smart Input
    public string $aiInputText = '';
    public ?array $parsedData = null;
    public array $parsedTransactions = [];

    // Hızlı Gider / Gelir Formu
    public string $cashflowType = 'expense'; // expense, income
    public float $amount = 0.0;
    public string $title = '';
    public ?int $category_id = null;
    public string $expense_date = '';
    public bool $is_recurring = false;

    // Hızlı Borç / Kredi / Kart Formu
    public string $debtType = 'credit_card'; // credit_card, loan, kmh
    public ?int $bank_id = null;
    public string $debtTitle = '';
    public float $debtAmount = 0.0;
    public float $installmentAmount = 0.0;
    public float $interestRate = 4.25;
    public string $dueDate = '';

    // Toplu Satır Ekstre Yükleme
    public string $bulkText = '';
    public array $bulkParsedList = [];

    protected $listeners = [
        'openQuickAction' => 'open',
        'openQuickActionTab' => 'openWithTab',
    ];

    public function mount(): void
    {
        $this->expense_date = Carbon::today()->format('Y-m-d');
        $this->dueDate = Carbon::today()->addDays(15)->format('Y-m-d');
    }

    public function open(): void
    {
        $this->isOpen = true;
    }

    public function openWithTab(string $tab): void
    {
        $this->activeTab = $tab;
        $this->isOpen = true;
    }

    public function close(): void
    {
        $this->isOpen = false;
        $this->reset(['parsedData', 'parsedTransactions', 'aiInputText', 'bulkText', 'bulkParsedList']);
    }

    public function markAllAsRead(): void
    {
        $user = Auth::user();
        if ($user) {
            $service = app(\App\Services\NotificationService::class);
            $service->markAllAsRead($user);
            $this->dispatch('refreshNotifications');
        }
    }

    public function markAllAsUnread(): void
    {
        $user = Auth::user();
        if ($user) {
            $service = app(\App\Services\NotificationService::class);
            $service->markAllAsUnread($user);
            $this->dispatch('refreshNotifications');
        }
    }

    public function toggleRead(int $id): void
    {
        $user = Auth::user();
        if ($user) {
            $service = app(\App\Services\NotificationService::class);
            $service->toggleRead($user, $id);
            $this->dispatch('refreshNotifications');
        }
    }

    public function deleteNotification(int $id): void
    {
        $user = Auth::user();
        if ($user) {
            \App\Models\FinancialNotification::where('user_id', $user->id)->where('id', $id)->delete();
            $this->dispatch('refreshNotifications');
        }
    }

    public function updatedAiInputText(string $value): void
    {
        if (mb_strlen(trim($value)) >= 3) {
            $parser = new NaturalLanguageTransactionParser();
            $this->parsedTransactions = $parser->parseAll($value, Auth::user());
            $this->parsedData = $this->parsedTransactions[0] ?? null;
        } else {
            $this->parsedTransactions = [];
            $this->parsedData = null;
        }
    }

    public function parseManual(): void
    {
        if (mb_strlen(trim($this->aiInputText)) >= 3) {
            $parser = new NaturalLanguageTransactionParser();
            $this->parsedTransactions = $parser->parseAll($this->aiInputText, Auth::user());
            $this->parsedData = $this->parsedTransactions[0] ?? null;
        }
    }

    public function saveSingleTransaction(int $index): void
    {
        if (!isset($this->parsedTransactions[$index])) {
            return;
        }

        $p = $this->parsedTransactions[$index];
        $this->persistTransactionItem($p);

        unset($this->parsedTransactions[$index]);
        $this->parsedTransactions = array_values($this->parsedTransactions);
        $this->parsedData = $this->parsedTransactions[0] ?? null;

        if (empty($this->parsedTransactions)) {
            $this->close();
        }
        $this->dispatch('refreshTransactions');
    }

    public function saveAllTransactions(): void
    {
        if (empty($this->parsedTransactions)) {
            if ($this->parsedData) {
                $this->persistTransactionItem($this->parsedData);
            } else {
                session()->flash('error', 'Lütfen geçerli bir tutar içeren metin girin.');
                return;
            }
        } else {
            $count = 0;
            foreach ($this->parsedTransactions as $p) {
                if (!empty($p['amount']) && $p['amount'] > 0) {
                    $this->persistTransactionItem($p);
                    $count++;
                }
            }
            session()->flash('success', "✨ Toplam {$count} adet işlem başarıyla veritabanına kaydedildi!");
        }

        $this->close();
        $this->dispatch('refreshTransactions');
    }

    public function saveParsedTransaction(): void
    {
        $this->saveAllTransactions();
    }

    protected function persistTransactionItem(array $p): void
    {
        $userId = Auth::id();

        if ($p['type'] === 'income') {
            $catId = $p['category_id'];
            if (!$catId) {
                $cat = Category::where('user_id', $userId)->where('type', 'income')->first()
                    ?? Category::firstOrCreate(['name' => 'Maaş & Düzenli Gelir'], ['user_id' => $userId, 'icon' => '💵', 'type' => 'income']);
                $catId = $cat->id;
            }

            $date = $p['date'] ?? Carbon::today()->format('Y-m-d');
            $day = (int) date('d', strtotime($date));

            Income::create([
                'user_id' => $userId,
                'category_id' => $catId,
                'title' => $p['title'] ?: 'Gelir Girişi',
                'amount' => $p['amount'],
                'income_date' => $date,
                'type' => $p['income_type'] ?? 'salary',
                'frequency' => $p['frequency'] ?? ($p['is_recurring'] ? 'monthly' : 'one_time'),
                'received_day' => $day,
                'is_recurring' => (bool) ($p['is_recurring'] ?? false),
            ]);
        } elseif ($p['type'] === 'card') {
            CreditCard::create([
                'user_id' => $userId,
                'bank_id' => $p['bank_id'] ?: Bank::first()?->id,
                'name' => $p['title'] ?: 'Kredi Kartı',
                'credit_limit' => $p['credit_limit'] ?: $p['amount'],
                'current_debt' => 0.0,
                'interest_rate' => $p['interest_rate'] ?? 4.25,
                'due_day' => 15,
                'status' => 'active',
            ]);
        } elseif ($p['type'] === 'debt') {
            Debt::create([
                'user_id' => $userId,
                'bank_id' => $p['bank_id'],
                'type' => 'loan',
                'title' => $p['title'] ?: 'Kredi Borcu',
                'principal' => $p['amount'],
                'remaining' => $p['amount'],
                'interest_rate' => $p['interest_rate'] ?? 4.25,
                'installment_amount' => $p['installment_amount'] ?: round($p['amount'] / 12, 2),
                'next_due_date' => Carbon::parse($p['date'] ?? Carbon::today())->addMonth()->format('Y-m-d'),
                'status' => 'active',
            ]);
        } else {
            // Expense
            $catId = $p['category_id'];
            if (!$catId) {
                $cat = Category::where('user_id', $userId)->where('type', 'expense')->first()
                    ?? Category::firstOrCreate(['name' => 'Market & Alışveriş'], ['user_id' => $userId, 'icon' => '🛒', 'type' => 'expense']);
                $catId = $cat->id;
            }

            Expense::create([
                'user_id' => $userId,
                'category_id' => $catId,
                'credit_card_id' => $p['credit_card_id'] ?? null,
                'title' => $p['title'] ?: 'Harcama',
                'amount' => $p['amount'],
                'expense_date' => $p['date'] ?? Carbon::today()->format('Y-m-d'),
                'payment_method' => $p['payment_method'] ?? 'cash',
                'is_recurring' => (bool) ($p['is_recurring'] ?? false),
            ]);
        }
    }

    public function addQuickAmount(float $val): void
    {
        $this->amount += $val;
    }

    public function applyPreset(string $preset): void
    {
        $categories = Category::all();

        switch ($preset) {
            case 'coffee':
                $this->cashflowType = 'expense';
                $this->amount = 150.0;
                $this->title = 'Kahve & Dışarıda Yeme';
                $this->category_id = $categories->first(fn($c) => str_contains(mb_strtolower($c->name), 'yemek'))?->id;
                break;
            case 'market':
                $this->cashflowType = 'expense';
                $this->amount = 750.0;
                $this->title = 'Market & Mutfak Alışverişi';
                $this->category_id = $categories->first(fn($c) => str_contains(mb_strtolower($c->name), 'market'))?->id;
                break;
            case 'fuel':
                $this->cashflowType = 'expense';
                $this->amount = 1250.0;
                $this->title = 'Akaryakıt & Benzin';
                $this->category_id = $categories->first(fn($c) => str_contains(mb_strtolower($c->name), 'ulaşım'))?->id;
                break;
            case 'bill':
                $this->cashflowType = 'expense';
                $this->amount = 450.0;
                $this->title = 'Fatura Ödemesi';
                $this->category_id = $categories->first(fn($c) => str_contains(mb_strtolower($c->name), 'fatura'))?->id;
                break;
            case 'rent':
                $this->cashflowType = 'expense';
                $this->amount = 15000.0;
                $this->title = 'Kira & Aidat';
                $this->category_id = $categories->first(fn($c) => str_contains(mb_strtolower($c->name), 'kira') || str_contains(mb_strtolower($c->name), 'konut'))?->id;
                break;
            case 'salary':
                $this->cashflowType = 'income';
                $this->amount = 45000.0;
                $this->title = 'Maaş Geliri';
                $this->category_id = $categories->first(fn($c) => str_contains(mb_strtolower($c->name), 'maaş'))?->id;
                break;
        }
    }

    public function saveManualCashflow(): void
    {
        $this->validate([
            'amount' => 'required|numeric|min:1',
            'title' => 'required|string|max:255',
            'expense_date' => 'required|date',
        ]);

        $userId = Auth::id();

        if ($this->cashflowType === 'income') {
            Income::create([
                'user_id' => $userId,
                'category_id' => $this->category_id,
                'title' => $this->title,
                'amount' => $this->amount,
                'received_day' => Carbon::parse($this->expense_date)->day,
                'is_recurring' => $this->is_recurring,
            ]);
            session()->flash('success', '🟢 Gelir kaydı başarıyla kaydedildi!');
        } else {
            Expense::create([
                'user_id' => $userId,
                'category_id' => $this->category_id,
                'title' => $this->title,
                'amount' => $this->amount,
                'expense_date' => $this->expense_date,
                'is_recurring' => $this->is_recurring,
            ]);
            session()->flash('success', '🔴 Gider kaydı başarıyla kaydedildi!');
        }

        $this->close();
        $this->dispatch('refreshTransactions');
    }

    public function saveManualDebt(): void
    {
        $this->validate([
            'debtAmount' => 'required|numeric|min:10',
            'debtTitle' => 'required|string|max:255',
        ]);

        $userId = Auth::id();

        if ($this->debtType === 'credit_card') {
            CreditCard::create([
                'user_id' => $userId,
                'bank_id' => $this->bank_id ?: Bank::first()?->id,
                'name' => $this->debtTitle,
                'credit_limit' => $this->debtAmount,
                'current_debt' => $this->installmentAmount ?: 0,
                'interest_rate' => $this->interestRate,
                'due_day' => Carbon::parse($this->dueDate)->day,
                'status' => 'active',
            ]);
            session()->flash('success', '💳 Kredi kartı başarıyla eklendi!');
        } else {
            Debt::create([
                'user_id' => $userId,
                'bank_id' => $this->bank_id,
                'type' => $this->debtType,
                'title' => $this->debtTitle,
                'principal' => $this->debtAmount,
                'remaining' => $this->debtAmount,
                'interest_rate' => $this->interestRate,
                'installment_amount' => $this->installmentAmount ?: round($this->debtAmount / 12, 2),
                'next_due_date' => $this->dueDate,
                'status' => 'active',
            ]);
            session()->flash('success', '🏦 Borç / Kredi kaydı başarıyla eklendi!');
        }

        $this->close();
        $this->dispatch('refreshTransactions');
    }

    public function parseBulk(): void
    {
        $parser = new NaturalLanguageTransactionParser();
        $this->bulkParsedList = $parser->parseBulkLines($this->bulkText);
    }

    public function saveAllBulk(): void
    {
        if (empty($this->bulkParsedList)) {
            return;
        }

        $userId = Auth::id();
        $count = 0;

        foreach ($this->bulkParsedList as $p) {
            Expense::create([
                'user_id' => $userId,
                'category_id' => $p['category_id'],
                'title' => $p['title'] ?: 'Ekstre Harcaması',
                'amount' => $p['amount'],
                'expense_date' => $p['date'],
                'is_recurring' => false,
            ]);
            $count++;
        }

        session()->flash('success', '📄 Toplam ' . $count . ' adet harcama kaydı başarıyla veritabanına aktarıldı!');
        $this->close();
        $this->dispatch('refreshTransactions');
    }

    public function render()
    {
        $categories = Category::all();
        $banks = Bank::all();

        return view('livewire.quick-action-modal', [
            'categories' => $categories,
            'banks' => $banks,
        ]);
    }
}
