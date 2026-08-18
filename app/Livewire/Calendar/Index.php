<?php

namespace App\Livewire\Calendar;

use App\Models\Debt;
use App\Models\PaymentPlanItem;
use App\Models\Reminder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public string $currentMonth;

    public function mount(): void
    {
        $this->currentMonth = now()->format('Y-m');
    }

    public function previousMonth(): void
    {
        $this->currentMonth = Carbon::parse($this->currentMonth . '-01')->subMonth()->format('Y-m');
    }

    public function nextMonth(): void
    {
        $this->currentMonth = Carbon::parse($this->currentMonth . '-01')->addMonth()->format('Y-m');
    }

    public function render()
    {
        $user = Auth::user();
        $date = Carbon::parse($this->currentMonth . '-01');

        $debts = Debt::where('user_id', $user->id)
            ->where('status', 'active')
            ->whereNotNull('next_due_date')
            ->with('bank')
            ->get();

        $planItems = PaymentPlanItem::whereHas('paymentPlan', fn($q) => $q->where('user_id', $user->id)->where('status', 'active'))
            ->whereYear('month', $date->year)
            ->whereMonth('month', $date->month)
            ->with('debt.bank')
            ->get();

        $reminders = Reminder::where('user_id', $user->id)
            ->whereYear('remind_at', $date->year)
            ->whereMonth('remind_at', $date->month)
            ->get();

        return view('livewire.calendar.index', [
            'monthTitle' => $date->translatedFormat('F Y'),
            'debts' => $debts,
            'planItems' => $planItems,
            'reminders' => $reminders,
        ])->layout('layouts.app');
    }
}
