<?php

namespace App\Livewire\Concerns;

use App\Models\FinancialNotification;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Auth;

trait HandlesNotifications
{
    public function markAllAsRead(): void
    {
        $user = Auth::user();
        if ($user) {
            $service = app(NotificationService::class);
            $service->markAllAsRead($user);
            $this->dispatch('refreshNotifications');
            session()->flash('message', 'Tüm bildirimler okundu olarak işaretlendi.');
        }
    }

    public function markAllAsUnread(): void
    {
        $user = Auth::user();
        if ($user) {
            $service = app(NotificationService::class);
            $service->markAllAsUnread($user);
            $this->dispatch('refreshNotifications');
            session()->flash('message', 'Tüm bildirimler okunmadı olarak işaretlendi.');
        }
    }

    public function toggleRead(int $id): void
    {
        $user = Auth::user();
        if ($user) {
            $service = app(NotificationService::class);
            $notif = $service->toggleRead($user, $id);
            $this->dispatch('refreshNotifications');
            if ($notif) {
                $msg = $notif->read_at ? 'Bildirim okundu olarak işaretlendi.' : 'Bildirim okunmadı olarak işaretlendi.';
                session()->flash('message', $msg);
            }
        }
    }

    public function markAsRead(int $id): void
    {
        $user = Auth::user();
        if (!$user) return;

        $notif = FinancialNotification::where('user_id', $user->id)->find($id);
        if ($notif) {
            $notif->markAsRead();
            $this->dispatch('refreshNotifications');
        }
    }

    public function deleteNotification(int $id): void
    {
        $user = Auth::user();
        if ($user) {
            FinancialNotification::where('user_id', $user->id)->where('id', $id)->delete();
            $this->dispatch('refreshNotifications');
            session()->flash('message', 'Bildirim başarıyla silindi.');
        }
    }

    public function deleteAll(): void
    {
        $user = Auth::user();
        if ($user) {
            $service = app(NotificationService::class);
            $service->deleteAll($user);
            $this->dispatch('refreshNotifications');
            session()->flash('message', 'Tüm bildirim geçmişi temizlendi.');
        }
    }

    public function generateAiAdvice(): void
    {
        $user = Auth::user();
        if ($user) {
            $service = app(NotificationService::class);
            $service->generateDailyAiNotification($user, true);
            $this->dispatch('refreshNotifications');
            session()->flash('message', '✨ Yeni Gemini AI Finansal Tavsiyesi başarıyla üretildi!');
        }
    }

    public function viewNotification(int $id): void
    {
        $user = Auth::user();
        if (!$user) return;

        $notif = FinancialNotification::where('user_id', $user->id)->find($id);
        if ($notif) {
            if (property_exists($this, 'selectedNotificationId')) {
                $this->selectedNotificationId = $notif->id;
            }
            if (property_exists($this, 'showDetailModal')) {
                $this->showDetailModal = true;
            }
            if (is_null($notif->read_at)) {
                $notif->markAsRead();
                $this->dispatch('refreshNotifications');
            }
        }
    }

    public function closeDetailModal(): void
    {
        if (property_exists($this, 'showDetailModal')) {
            $this->showDetailModal = false;
        }
        if (property_exists($this, 'selectedNotificationId')) {
            $this->selectedNotificationId = null;
        }
    }
}
