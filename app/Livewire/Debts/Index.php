<?php

namespace App\Livewire\Debts;

use App\Models\Bank;
use App\Models\Debt;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    // Filtreleme & Arama Özellikleri
    public string $activeTab = 'all'; // all, loan, kmh, credit_card, personal, other
    public string $search = '';
    public ?int $selected_bank_id = null;
    public string $risk_status = 'all'; // all, critical, overdue, regular, paid
    public ?string $date_from = null;
    public ?string $date_to = null;
    public string $date_preset = 'all'; // all, this_month, next_30, past_due
    public string $sortBy = 'risk'; // risk, interest_desc, remaining_asc, remaining_desc, next_due, title
    public string $sortDir = 'desc';
    public string $viewMode = 'flow'; // flow (kart akışı), table (tablo görünümü)

    // Modal & Form Özellikleri
    public bool $showModal = false;
    public ?int $debtId = null;
    public ?int $bank_id = null;
    public string $type = 'loan';
    public string $title = '';
    public float $principal = 0.0;
    public float $remaining = 0.0;
    public float $interest_rate = 3.90;
    public ?int $installment_count = 12;
    public ?float $installment_amount = null;
    public ?string $next_due_date = null;
    public ?string $last_payment_date = null;
    public int $days_overdue = 0;
    public string $notes = '';

    protected $rules = [
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
    ];

    public function setDatePreset(string $preset): void
    {
        $this->date_preset = $preset;

        if ($preset === 'this_month') {
            $this->date_from = Carbon::now()->startOfMonth()->format('Y-m-d');
            $this->date_to = Carbon::now()->endOfMonth()->format('Y-m-d');
        } elseif ($preset === 'next_30') {
            $this->date_from = Carbon::now()->format('Y-m-d');
            $this->date_to = Carbon::now()->addDays(30)->format('Y-m-d');
        } elseif ($preset === 'past_due') {
            $this->date_from = null;
            $this->date_to = Carbon::now()->format('Y-m-d');
            $this->risk_status = 'overdue';
        } else {
            $this->date_from = null;
            $this->date_to = null;
        }
    }

    public function resetFilters(): void
    {
        $this->reset([
            'search',
            'selected_bank_id',
            'activeTab',
            'risk_status',
            'date_from',
            'date_to',
            'date_preset',
            'sortBy',
            'sortDir',
        ]);
        $this->sortBy = 'risk';
        $this->sortDir = 'desc';
    }

    public function openCreateModal(): void
    {
        $this->reset(['debtId', 'bank_id', 'title', 'principal', 'remaining', 'installment_count', 'installment_amount', 'next_due_date', 'last_payment_date', 'notes']);
        $this->type = 'loan';
        $this->interest_rate = 3.90;
        $this->showModal = true;
    }

    public function openEditModal(int $id): void
    {
        $debt = Debt::where('user_id', Auth::id())->findOrFail($id);
        $this->debtId = $debt->id;
        $this->bank_id = $debt->bank_id;
        $this->type = $debt->type;
        $this->title = $debt->title;
        $this->principal = (float) $debt->principal;
        $this->remaining = (float) $debt->remaining;
        $this->interest_rate = (float) $debt->interest_rate;
        $this->installment_count = $debt->installment_count;
        $this->installment_amount = (float) $debt->installment_amount;
        $this->next_due_date = $debt->next_due_date ? Carbon::parse($debt->next_due_date)->format('Y-m-d') : null;
        $this->last_payment_date = $debt->last_payment_date ? Carbon::parse($debt->last_payment_date)->format('Y-m-d') : null;
        $this->days_overdue = (int) $debt->days_overdue;
        $this->notes = $debt->notes ?? '';
        $this->showModal = true;
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'user_id' => Auth::id(),
            'bank_id' => $this->bank_id ?: null,
            'type' => $this->type,
            'title' => $this->title,
            'principal' => $this->principal,
            'remaining' => $this->remaining,
            'interest_rate' => $this->interest_rate,
            'installment_count' => $this->installment_count,
            'installment_amount' => $this->installment_amount,
            'next_due_date' => $this->next_due_date ?: null,
            'last_payment_date' => $this->last_payment_date ?: null,
            'days_overdue' => $this->days_overdue,
            'notes' => $this->notes,
            'status' => $this->remaining <= 0 ? 'paid' : 'active',
        ];

        if ($this->debtId) {
            Debt::where('user_id', Auth::id())->findOrFail($this->debtId)->update($data);
        } else {
            Debt::create($data);
        }

        $this->showModal = false;
        $this->reset(['debtId', 'bank_id', 'title', 'principal', 'remaining']);
        session()->flash('message', 'Borç kaydı başarıyla kaydedildi.');
    }

    public function delete(int $id): void
    {
        Debt::where('user_id', Auth::id())->findOrFail($id)->delete();
        session()->flash('message', 'Borç kaydı silindi.');
    }

    public function render()
    {
        $userId = Auth::id();
        $query = Debt::where('user_id', $userId)->with('bank');

        // 1. Sekme / Tür Filtresi
        if ($this->activeTab !== 'all') {
            $query->where('type', $this->activeTab);
        }

        // 2. Metin Arama
        if (!empty($this->search)) {
            $search = '%' . trim($this->search) . '%';
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', $search)
                  ->orWhere('notes', 'like', $search)
                  ->orWhereHas('bank', function ($bq) use ($search) {
                      $bq->where('name', 'like', $search);
                  });
            });
        }

        // 3. Banka Filtresi
        if (!empty($this->selected_bank_id)) {
            $query->where('bank_id', $this->selected_bank_id);
        }

        // 4. Risk / Gecikme Durumu Filtresi
        if ($this->risk_status === 'critical') {
            $query->where('days_overdue', '>=', 65);
        } elseif ($this->risk_status === 'overdue') {
            $query->where('days_overdue', '>', 0);
        } elseif ($this->risk_status === 'regular') {
            $query->where('days_overdue', '=', 0)->where('remaining', '>', 0);
        } elseif ($this->risk_status === 'paid') {
            $query->where('remaining', '<=', 0);
        }

        // 5. Tarih Aralığı Filtresi (Vade / Son Ödeme)
        if (!empty($this->date_from)) {
            $query->where(function ($q) {
                $q->where('next_due_date', '>=', $this->date_from)
                  ->orWhere('last_payment_date', '>=', $this->date_from);
            });
        }
        if (!empty($this->date_to)) {
            $query->where(function ($q) {
                $q->where('next_due_date', '<=', $this->date_to)
                  ->orWhere('last_payment_date', '<=', $this->date_to);
            });
        }

        // 6. Sıralama
        switch ($this->sortBy) {
            case 'interest_desc':
                $query->orderBy('interest_rate', 'desc');
                break;
            case 'remaining_asc':
                $query->orderBy('remaining', 'asc');
                break;
            case 'remaining_desc':
                $query->orderBy('remaining', 'desc');
                break;
            case 'next_due':
                $query->orderByRaw('next_due_date IS NULL, next_due_date ASC');
                break;
            case 'title':
                $query->orderBy('title', $this->sortDir === 'desc' ? 'desc' : 'asc');
                break;
            case 'risk':
            default:
                $query->orderBy('days_overdue', 'desc')->orderBy('interest_rate', 'desc');
                break;
        }

        $debts = $query->get();
        $banks = Bank::all();

        // Finansal Özet İstatistikleri (Tüm Filtrelenen Borçlar Üzerinden)
        $totalRemaining = $debts->sum('remaining');
        $totalMonthly = $debts->sum('installment_amount');
        $criticalCount = $debts->filter(fn($d) => (90 - $d->days_overdue) <= 25 && $d->days_overdue > 0)->count();
        $avgInterest = $debts->count() > 0 ? $debts->avg('interest_rate') : 0.0;

        return view('livewire.debts.index', [
            'debts' => $debts,
            'banks' => $banks,
            'totalRemaining' => $totalRemaining,
            'totalMonthly' => $totalMonthly,
            'criticalCount' => $criticalCount,
            'avgInterest' => $avgInterest,
        ])->layout('layouts.app');
    }
}

