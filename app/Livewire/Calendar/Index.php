<?php

namespace App\Livewire\Calendar;

use App\Models\Bank;
use App\Models\CreditCard;
use App\Models\Debt;
use App\Models\PaymentPlanItem;
use App\Models\Reminder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public string $currentMonth;
    public string $selectedDay = 'all'; // all, or 1..31
    public ?int $selected_bank_id = null;
    public string $payment_type = 'all'; // all, credit_card, loan, kmh, plan
    public bool $collision_only = false;
    public string $search = '';
    public string $viewMode = 'grid'; // grid (aylık takvim kutuları), feed (çakışma ve gün akışı), table (tablo)

    public function mount(): void
    {
        $this->currentMonth = now()->format('Y-m');
    }

    public function previousMonth(): void
    {
        $this->currentMonth = Carbon::parse($this->currentMonth . '-01')->subMonth()->format('Y-m');
        $this->selectedDay = 'all';
    }

    public function nextMonth(): void
    {
        $this->currentMonth = Carbon::parse($this->currentMonth . '-01')->addMonth()->format('Y-m');
        $this->selectedDay = 'all';
    }

    public function resetFilters(): void
    {
        $this->reset(['selectedDay', 'selected_bank_id', 'payment_type', 'collision_only', 'search']);
        $this->currentMonth = now()->format('Y-m');
    }

    public function render()
    {
        $userId = Auth::id();
        $date = Carbon::parse($this->currentMonth . '-01');
        $daysInMonth = $date->daysInMonth;
        $startOfWeek = ($date->copy()->startOfMonth()->dayOfWeekIso) - 1; // 0 = Pazartesi, 6 = Pazar

        $banks = Bank::all();
        $events = collect();

        // 1. KREDİ KARTLARI (due_day ile aylık son ödeme günü)
        $cards = CreditCard::where('user_id', $userId)->with('bank')->get();
        $trackedCardIds = [];

        foreach ($cards as $card) {
            $day = $card->due_day ? min($daysInMonth, (int)$card->due_day) : 15;
            $eventDate = $date->copy()->day($day)->format('Y-m-d');
            $trackedCardIds[] = $card->id;

            $events->push((object) [
                'id' => 'card-' . $card->id,
                'source_type' => 'credit_card',
                'title' => $card->name . ' (Ekstre Son Ödeme)',
                'bank_id' => $card->bank_id,
                'bank_name' => $card->bank?->name ?? 'Banka',
                'bank_color' => $card->bank?->color ?? '#6366f1',
                'amount' => (float) ($card->minimum_payment > 0 ? $card->minimum_payment : $card->current_debt),
                'total_debt' => (float) $card->current_debt,
                'due_date' => $eventDate,
                'day' => $day,
                'type_label' => 'Kredi Kartı',
                'type_icon' => '💳',
                'badge_style' => 'bg-amber-100 text-amber-800 border-amber-300',
            ]);
        }

        // 2. BORÇLAR & KREDİLER (next_due_date ile)
        $debts = Debt::where('user_id', $userId)
            ->where('status', 'active')
            ->with('bank')
            ->get();

        foreach ($debts as $debt) {
            // Eğer bu borç zaten yukarıda eklenen bir kredi kartının genel dönem ekstre borcunu temsil ediyorsa (taksitli harcama değilse) mükerrer ekleme
            if ($debt->type === 'credit_card' && $debt->credit_card_id && in_array($debt->credit_card_id, $trackedCardIds) && (empty($debt->total_installments) || $debt->total_installments <= 1)) {
                continue;
            }


            $dueCarbon = $debt->next_due_date ? Carbon::parse($debt->next_due_date) : null;
            $day = $dueCarbon ? $dueCarbon->day : 1;
            $eventDate = $date->copy()->day(min($daysInMonth, $day))->format('Y-m-d');

            $typeLabel = $debt->type === 'kmh' ? 'KMH / Eksi Bakiye' : ($debt->type === 'credit_card' ? 'Kart Taksiti' : 'Kredi Taksiti');
            $typeIcon = $debt->type === 'kmh' ? '⚡' : ($debt->type === 'credit_card' ? '💳' : '🏦');

            $events->push((object) [
                'id' => 'debt-' . $debt->id,
                'source_type' => $debt->type,
                'title' => $debt->title,
                'bank_id' => $debt->bank_id,
                'bank_name' => $debt->bank?->name ?? 'Diğer / Şahıs',
                'bank_color' => $debt->bank?->color ?? '#6366f1',
                'amount' => (float) ($debt->installment_amount > 0 ? $debt->installment_amount : $debt->remaining),
                'total_debt' => (float) $debt->remaining,
                'due_date' => $eventDate,
                'day' => min($daysInMonth, $day),
                'type_label' => $typeLabel,
                'type_icon' => $typeIcon,
                'days_overdue' => (int) $debt->days_overdue,
                'badge_style' => $debt->type === 'kmh' ? 'bg-red-100 text-red-800 border-red-300' : 'bg-blue-100 text-blue-800 border-blue-300',
            ]);
        }


        // 3. ÖDEME PLANI KALEMLERİ
        $planItems = PaymentPlanItem::whereHas('paymentPlan', fn($q) => $q->where('user_id', $userId)->where('status', 'active'))
            ->whereYear('month', $date->year)
            ->whereMonth('month', $date->month)
            ->with('debt.bank')
            ->get();

        foreach ($planItems as $item) {
            $events->push((object) [
                'id' => 'plan-' . $item->id,
                'source_type' => 'plan',
                'title' => 'Plan: ' . ($item->debt?->title ?? 'Stratejik Ödeme'),
                'bank_id' => $item->debt?->bank_id,
                'bank_name' => $item->debt?->bank?->name ?? 'Plan',
                'bank_color' => $item->debt?->bank?->color ?? '#4f46e5',
                'amount' => (float) $item->allocated_amount,
                'total_debt' => (float) ($item->debt?->remaining ?? 0),
                'due_date' => $date->copy()->day(1)->format('Y-m-d'),
                'day' => 1,
                'type_label' => 'Ödeme Planı',
                'type_icon' => '🎯',
                'status' => $item->status,
                'badge_style' => 'bg-indigo-100 text-indigo-800 border-indigo-300',
            ]);
        }

        // FİLTRELEME İŞLEMLERİ
        $filteredEvents = $events;

        if ($this->payment_type !== 'all') {
            $filteredEvents = $filteredEvents->filter(fn($e) => $e->source_type === $this->payment_type);
        }

        if (!empty($this->selected_bank_id)) {
            $filteredEvents = $filteredEvents->filter(fn($e) => $e->bank_id == $this->selected_bank_id);
        }

        if (!empty($this->search)) {
            $s = mb_strtolower(trim($this->search));
            $filteredEvents = $filteredEvents->filter(fn($e) => str_contains(mb_strtolower($e->title), $s) || str_contains(mb_strtolower($e->bank_name), $s));
        }

        if ($this->selectedDay !== 'all') {
            $dayInt = (int)$this->selectedDay;
            $filteredEvents = $filteredEvents->filter(fn($e) => $e->day === $dayInt);
        }

        // Günlere göre gruplama (Tüm ayın çakışma haritası)
        $eventsByDay = [];
        for ($d = 1; $d <= $daysInMonth; $d++) {
            $eventsByDay[$d] = $filteredEvents->where('day', $d)->values();
        }

        // Çakışan Günleri Tespit Et (Aynı günde birden fazla ödeme)
        $collisionDays = [];
        $totalCollisionAmount = 0;
        foreach ($eventsByDay as $d => $dayEvs) {
            if ($dayEvs->count() > 1) {
                $collisionDays[$d] = $dayEvs;
                $totalCollisionAmount += $dayEvs->sum('amount');
            }
        }

        if ($this->collision_only) {
            $filteredEvents = $filteredEvents->filter(fn($e) => isset($collisionDays[$e->day]));
        }

        // Aylık Finansal Özetler
        $totalMonthAmount = $filteredEvents->sum('amount');
        $cardAmount = $filteredEvents->where('source_type', 'credit_card')->sum('amount');
        $loanAmount = $filteredEvents->whereIn('source_type', ['loan', 'kmh'])->sum('amount');

        return view('livewire.calendar.index', [
            'monthTitle' => $date->translatedFormat('F Y'),
            'currentDate' => $date,
            'daysInMonth' => $daysInMonth,
            'startOfWeek' => $startOfWeek,
            'banks' => $banks,
            'events' => $filteredEvents->sortBy('day'),
            'eventsByDay' => $eventsByDay,
            'collisionDays' => $collisionDays,
            'totalCollisionAmount' => $totalCollisionAmount,
            'totalMonthAmount' => $totalMonthAmount,
            'cardAmount' => $cardAmount,
            'loanAmount' => $loanAmount,
        ])->layout('layouts.app');
    }
}

