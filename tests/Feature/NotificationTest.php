<?php

namespace Tests\Feature;

use App\Models\FinancialNotification;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_access_notifications_page(): void
    {
        $user = User::factory()->create([
            'status' => 'active',
            'onboarding_completed' => true,
        ]);

        $response = $this->actingAs($user)->get('/app/bildirimler');
        $response->assertStatus(200);
    }

    public function test_notification_service_generates_ai_advice_and_risk_alerts(): void
    {
        $user = User::factory()->create();

        $service = new NotificationService();
        $notif = $service->generateDailyAiNotification($user, true);

        $this->assertNotNull($notif);
        $this->assertEquals($user->id, $notif->user_id);
        $this->assertEquals('ai_advice', $notif->type);

        $unreadCount = $service->getUnreadCount($user);
        $this->assertGreaterThanOrEqual(1, $unreadCount);

        $service->markAllAsRead($user);
        $this->assertEquals(0, $service->getUnreadCount($user));

        $service->markAllAsUnread($user);
        $this->assertEquals(1, $service->getUnreadCount($user));
    }

    public function test_livewire_notifications_component_actions(): void
    {
        $user = User::factory()->create([
            'status' => 'active',
            'onboarding_completed' => true,
        ]);

        $notif = FinancialNotification::create([
            'user_id' => $user->id,
            'type' => 'ai_advice',
            'title' => 'Test Başlık',
            'message' => 'Test Mesaj',
            'severity' => 'info',
        ]);

        \Livewire\Livewire::actingAs($user)
            ->test(\App\Livewire\Notifications\Index::class)
            ->assertSee('Test Başlık')
            ->call('toggleRead', $notif->id)
            ->assertDispatched('refreshNotifications')
            ->call('deleteNotification', $notif->id)
            ->assertDispatched('refreshNotifications');

        $this->assertDatabaseMissing('financial_notifications', ['id' => $notif->id]);
    }
}
