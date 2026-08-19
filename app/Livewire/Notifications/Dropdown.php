<?php

namespace App\Livewire\Notifications;

use App\Models\FinancialNotification;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dropdown extends Component
{
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

    public function viewNotification(string|int $id)
    {
        $user = Auth::user();
        if (!$user) {
            return;
        }

        $notif = FinancialNotification::where('user_id', $user->id)->find((int) $id);
        if ($notif) {
            $notif->markAsRead();
            $this->dispatch('refreshNotifications');
            if (!empty($notif->action_url)) {
                return $this->redirect($notif->action_url, navigate: true);
            }
        }
    }

    public function markAsRead(int $id): void
    {
        $user = Auth::user();
        if (!$user) {
            return;
        }

        $notif = FinancialNotification::where('user_id', $user->id)->find($id);
        if ($notif) {
            $notif->markAsRead();
            $this->dispatch('refreshNotifications');
        }
    }

    public function toggleRead(int $id): void
    {
        $user = Auth::user();
        if (!$user) {
            return;
        }

        $service = app(NotificationService::class);
        $service->toggleRead($user, $id);
        $this->dispatch('refreshNotifications');
    }

    public function markAllAsRead(): void
    {
        $user = Auth::user();
        if (!$user) {
            return;
        }

        $service = app(NotificationService::class);
        $service->markAllAsRead($user);
        $this->dispatch('refreshNotifications');
    }

    public function markAllAsUnread(): void
    {
        $user = Auth::user();
        if (!$user) {
            return;
        }

        $service = app(NotificationService::class);
        $service->markAllAsUnread($user);
        $this->dispatch('refreshNotifications');
    }

    public function deleteNotification(int $id): void
    {
        $user = Auth::user();
        if (!$user) {
            return;
        }

        FinancialNotification::where('user_id', $user->id)->where('id', $id)->delete();
        $this->dispatch('refreshNotifications');
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
