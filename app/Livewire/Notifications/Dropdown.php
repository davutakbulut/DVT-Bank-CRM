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

    public function mount(NotificationService $service): void
    {
        $user = Auth::user();
        if ($user) {
            // Arka planda günlük kontrol yap
            $service->generateDailyAiNotification($user);
            $service->checkAndCreateRiskAlerts($user);
        }
    }

    public function handleUpdate(): void
    {
        // Tetikleme sonrası yeniden render et
    }

    public function toggleDropdown(): void
    {
        $this->isOpen = !$this->isOpen;
    }

    public function closeDropdown(): void
    {
        $this->isOpen = false;
    }

    public function markAsRead(int $id, NotificationService $service)
    {
        $user = Auth::user();
        $notif = FinancialNotification::where('user_id', $user->id)->find($id);

        if ($notif) {
            $notif->markAsRead();
            if ($notif->action_url) {
                $this->isOpen = false;
                return redirect()->to($notif->action_url);
            }
        }
    }

    public function toggleRead(int $id, NotificationService $service): void
    {
        $user = Auth::user();
        if ($user) {
            $service->toggleRead($user, $id);
            $this->dispatch('refreshNotifications');
        }
    }

    public function deleteNotification(int $id): void
    {
        $user = Auth::user();
        if ($user) {
            FinancialNotification::where('user_id', $user->id)->where('id', $id)->delete();
            $this->dispatch('refreshNotifications');
        }
    }

    public function markAllAsRead(NotificationService $service): void
    {
        $user = Auth::user();
        if ($user) {
            $service->markAllAsRead($user);
            $this->dispatch('refreshNotifications');
        }
    }

    public function render(NotificationService $service)
    {
        $user = Auth::user();
        $unreadCount = $user ? $service->getUnreadCount($user) : 0;
        $notifications = $user ? $service->getRecent($user, 6) : collect();

        return view('livewire.notifications.dropdown', compact('unreadCount', 'notifications'));
    }
}
