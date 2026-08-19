<?php

namespace App\Livewire\Notifications;

use App\Models\FinancialNotification;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class Index extends Component
{
    use WithPagination;

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

    public function toggleRead(int $id): void
    {
        $user = Auth::user();
        if (!$user) return;

        $service = app(NotificationService::class);
        $notif = $service->toggleRead($user, $id);
        $this->dispatch('refreshNotifications');

        if ($notif) {
            $msg = $notif->read_at ? 'Bildirim okundu olarak işaretlendi.' : 'Bildirim okunmadı olarak işaretlendi.';
            session()->flash('message', $msg);
        }
    }

    public function markAsRead(int $id)
    {
        $user = Auth::user();
        if (!$user) return;

        $notif = FinancialNotification::where('user_id', $user->id)->find($id);

        if ($notif) {
            $notif->markAsRead();
            $this->dispatch('refreshNotifications');

            if ($notif->action_url) {
                return redirect()->to($notif->action_url);
            }
        }
    }

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
