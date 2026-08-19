<?php

namespace Tests\Feature;

use App\Models\AiAdvice;
use App\Models\Bank;
use App\Models\Debt;
use App\Models\Plan;
use App\Models\User;
use Database\Seeders\BankSeeder;
use Database\Seeders\PlanSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class PlanLimitsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed([RoleSeeder::class, PlanSeeder::class, BankSeeder::class]);
    }

    public function test_free_user_cannot_create_more_than_2_custom_banks(): void
    {
        $freePlan = Plan::where('slug', 'free')->first();
        $user = User::factory()->create(['plan_id' => $freePlan->id]);
        $user->assignRole('user');

        $this->assertTrue($user->canCreateBank());

        // 2 adet özel banka oluşturalım
        Bank::create(['user_id' => $user->id, 'name' => 'Banka 1', 'code' => 'B1', 'is_system' => false]);
        Bank::create(['user_id' => $user->id, 'name' => 'Banka 2', 'code' => 'B2', 'is_system' => false]);

        // 2 bankaya ulaşıldı, 3. bankayı oluşturamamalı
        $this->assertFalse($user->canCreateBank());
        $this->assertFalse(Gate::forUser($user)->allows('create-bank'));

        // Livewire / Controller seviyesinde engelleme testi
        $this->actingAs($user)
            ->postJson('/api/v1/banks', ['name' => 'Banka 3', 'code' => 'B3'])
            ->assertStatus(403)
            ->assertJsonPath('status', 'error')
            ->assertJsonPath('upgrade_required', true);
    }

    public function test_free_user_cannot_create_more_than_5_debts(): void
    {
        $freePlan = Plan::where('slug', 'free')->first();
        $user = User::factory()->create(['plan_id' => $freePlan->id]);
        $user->assignRole('user');

        $bank = Bank::where('is_system', true)->first();

        // 5 adet borç oluşturalım
        for ($i = 1; $i <= 5; $i++) {
            Debt::create([
                'user_id' => $user->id,
                'bank_id' => $bank->id,
                'type' => 'loan',
                'title' => "Borç {$i}",
                'principal' => 10000,
                'remaining' => 10000,
            ]);
        }

        // 5 borca ulaşıldı, 6. borcu oluşturamamalı
        $this->assertFalse($user->canCreateDebt());
        $this->assertFalse(Gate::forUser($user)->allows('create-debt'));

        // API seviyesinde engelleme testi
        $this->actingAs($user)
            ->postJson('/api/v1/debts', [
                'type' => 'loan',
                'title' => '6. Borç',
                'principal' => 5000,
                'remaining' => 5000,
                'interest_rate' => 3.5,
            ])
            ->assertStatus(403)
            ->assertJsonPath('status', 'error')
            ->assertJsonPath('upgrade_required', true);
    }

    public function test_free_user_cannot_generate_ai_advice_more_than_once_per_week(): void
    {
        $freePlan = Plan::where('slug', 'free')->first();
        $user = User::factory()->create(['plan_id' => $freePlan->id]);
        $user->assignRole('user');

        $this->assertTrue($user->canGenerateAiAdvice());

        // Kullanıcıya bugün bir AI tavsiyesi oluşturalım
        AiAdvice::create([
            'user_id' => $user->id,
            'type' => 'daily',
            'provider' => 'groq',
            'model' => 'llama-3.3-70b-versatile',
            'content' => 'Finansal tavsiye içeriği...',
        ]);

        // Haftalık frekansta olduğu için ve son 7 gün içinde tavsiye aldığı için false dönmeli
        $this->assertFalse($user->canGenerateAiAdvice());
        $this->assertFalse(Gate::forUser($user)->allows('generate-ai-advice'));
    }

    public function test_pro_user_can_create_unlimited_banks_and_debts(): void
    {
        $proPlan = Plan::where('slug', 'pro')->first();
        $user = User::factory()->create(['plan_id' => $proPlan->id]);
        $user->assignRole('user');

        $bank = Bank::where('is_system', true)->first();

        // 6 adet borç oluşturalım (Free limiti olan 5'i geçer)
        for ($i = 1; $i <= 6; $i++) {
            Debt::create([
                'user_id' => $user->id,
                'bank_id' => $bank->id,
                'type' => 'loan',
                'title' => "Pro Borç {$i}",
                'principal' => 10000,
                'remaining' => 10000,
            ]);
        }

        // Pro kullanıcı sınırsız ekleyebilmeli
        $this->assertTrue($user->canCreateDebt());
        $this->assertTrue($user->canCreateBank());
        $this->assertTrue($user->hasFeature('pdf_excel_export'));
    }
}
