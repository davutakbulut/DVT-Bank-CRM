<?php

namespace App\Livewire\Notifications;

use App\Livewire\Concerns\HandlesNotifications;
use App\Models\FinancialNotification;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class Index extends Component
{
    use WithPagination;
    use HandlesNotifications;

    public string $activeTab = 'all'; // all, unread, ai_advice, risk_alert, cashflow_alert
    public string $search = '';

    protected $listeners = [
        'refreshNotifications' => '$refresh',
    ];

    public function updatedActiveTab(): void
    {
        $this->resetPage();
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $user = Auth::user();

        $query = FinancialNotification::where('user_id', $user->id)->latest();

        if ($this->activeTab === 'unread') {
            $query->unread();
        } elseif ($this->activeTab === 'ai_advice') {
            $query->where('type', 'ai_advice');
        } elseif ($this->activeTab === 'risk_alert') {
            $query->where('type', 'risk_alert');
        } elseif ($this->activeTab === 'cashflow_alert') {
            $query->where('type', 'cashflow_alert');
        }

        if (!empty(trim($this->search))) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('message', 'like', '%' . $this->search . '%');
            });
        }

        $notifications = $query->paginate(12);

        $counts = [
            'all' => FinancialNotification::where('user_id', $user->id)->count(),
            'unread' => FinancialNotification::where('user_id', $user->id)->unread()->count(),
            'read' => FinancialNotification::where('user_id', $user->id)->read()->count(),
            'ai_advice' => FinancialNotification::where('user_id', $user->id)->where('type', 'ai_advice')->count(),
            'risk_alert' => FinancialNotification::where('user_id', $user->id)->where('type', 'risk_alert')->count(),
            'cashflow_alert' => FinancialNotification::where('user_id', $user->id)->where('type', 'cashflow_alert')->count(),
        ];

        return view('livewire.notifications.index', compact('notifications', 'counts'));
    }
}
