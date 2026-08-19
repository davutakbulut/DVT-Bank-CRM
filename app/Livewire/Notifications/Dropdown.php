<?php

namespace App\Livewire\Notifications;

use App\Livewire\Concerns\HandlesNotifications;
use App\Models\FinancialNotification;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dropdown extends Component
{
    use HandlesNotifications;

    public bool $isOpen = false;

    protected $listeners = [
        'refreshNotifications' => '$refresh',
        'cashflowUpdated' => 'handleUpdate',
        'debtUpdated' => 'handleUpdate',
    ];

    public function mount(): void
    {
        $user = Auth::user();
        if ($user) {
            $service = app(NotificationService::class);
            $service->generateDailyAiNotification($user);
            $service->checkAndCreateRiskAlerts($user);
        }
    }

    public function handleUpdate(): void
    {
        // Re-render
    }

    public function toggleDropdown(): void
    {
        $this->isOpen = !$this->isOpen;
    }

    public function closeDropdown(): void
    {
        $this->isOpen = false;
    }

    public function render()
    {
        $user = Auth::user();
        $service = app(NotificationService::class);
        $unreadCount = $user ? $service->getUnreadCount($user) : 0;
        $notifications = $user ? $service->getRecent($user, 6) : collect();

        return view('livewire.notifications.dropdown', compact('unreadCount', 'notifications'));
    }
}
