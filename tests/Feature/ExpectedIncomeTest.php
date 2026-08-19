<?php

namespace Tests\Feature;

use App\Livewire\Cashflow\Index as CashflowIndex;
use App\Livewire\Dashboard\Index as DashboardIndex;
use App\Models\ExpectedIncome;
use App\Models\Income;
use App\Models\User;
use App\Services\AI\UserContextBuilder;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ExpectedIncomeTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_expected_income_and_isolated_by_user(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $ei1 = ExpectedIncome::create([
            'user_id' => $user1->id,
            'title' => 'Maaş Geliri',
            'amount' => 50000,
            'type' => 'salary',
            'frequency' => 'monthly',
            'expected_day' => 15,
            'expected_date' => Carbon::now()->format('Y-m-d'),
            'status' => 'pending',
            'is_active' => true,
        ]);

        $this->actingAs($user2);
        $user2Expected = ExpectedIncome::all();
        $this->assertCount(0, $user2Expected);

        $this->actingAs($user1);
        $user1Expected = ExpectedIncome::all();
        $this->assertCount(1, $user1Expected);
        $this->assertEquals('Maaş Geliri', $user1Expected->first()->title);
    }

    public function test_confirm_received_creates_income_and_advances_monthly_date(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $today = Carbon::parse('2026-08-15');
        Carbon::setTestNow($today);

        $ei = ExpectedIncome::create([
            'user_id' => $user->id,
            'title' => 'Melih Günal Hakediş',
            'amount' => 50000,
            'type' => 'freelance',
            'frequency' => 'monthly',
            'expected_day' => 15,
            'expected_date' => '2026-08-15',
            'status' => 'pending',
            'is_active' => true,
        ]);

        $income = $ei->confirmReceived('2026-08-15');

        // Gerçek Income tablosunda kayıt oluşmalı
        $this->assertDatabaseHas('incomes', [
            'user_id' => $user->id,
            'title' => 'Melih Günal Hakediş',
            'amount' => 50000,
        ]);
        $this->assertEquals('2026-08-15', $income->income_date->format('Y-m-d'));

        // Beklenen gelir bir sonraki aya ötelenmeli
        $ei->refresh();
        $this->assertEquals('2026-09-15', $ei->expected_date->format('Y-m-d'));
        $this->assertEquals('pending', $ei->status);
        $this->assertEquals('2026-08-15', $ei->last_confirmed_date->format('Y-m-d'));

        Carbon::setTestNow();
    }

    public function test_mark_delayed_updates_expected_date(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $ei = ExpectedIncome::create([
            'user_id' => $user->id,
            'title' => 'Elden Tahsilat',
            'amount' => 10000,
            'type' => 'debt_collection',
            'frequency' => 'once',
            'expected_date' => '2026-08-20',
            'status' => 'pending',
            'is_active' => true,
        ]);

        $ei->markDelayed(5);

        $ei->refresh();
        $this->assertEquals('2026-08-25', $ei->expected_date->format('Y-m-d'));
        $this->assertEquals('delayed', $ei->status);
    }

    public function test_user_context_builder_includes_expected_incomes(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        ExpectedIncome::create([
            'user_id' => $user->id,
            'title' => 'Kira Geliri',
            'amount' => 15000,
            'type' => 'rental',
            'frequency' => 'monthly',
            'expected_day' => 1,
            'expected_date' => Carbon::now()->format('Y-m-d'),
            'status' => 'pending',
            'is_active' => true,
        ]);

        $context = (new UserContextBuilder())->build($user);

        $this->assertArrayHasKey('beklenen_gelirler', $context);
        $this->assertCount(1, $context['beklenen_gelirler']);
        $this->assertEquals('Kira Geliri', $context['beklenen_gelirler'][0]['baslik']);
        $this->assertEquals(15000.0, $context['beklenen_gelirler'][0]['tutar']);
    }

    public function test_dashboard_and_cashflow_livewire_actions(): void
    {
        $user = User::factory()->create(['onboarding_completed' => true]);
        $this->actingAs($user);

        $ei = ExpectedIncome::create([
            'user_id' => $user->id,
            'title' => 'Hakediş Ödemesi',
            'amount' => 30000,
            'type' => 'freelance',
            'frequency' => 'monthly',
            'expected_day' => 15,
            'expected_date' => Carbon::now()->format('Y-m-d'),
            'status' => 'pending',
            'is_active' => true,
        ]);

        // Dashboard Livewire confirmation
        Livewire::test(DashboardIndex::class)
            ->call('confirmExpectedIncome', $ei->id);

        $this->assertDatabaseHas('incomes', [
            'user_id' => $user->id,
            'title' => 'Hakediş Ödemesi',
            'amount' => 30000,
        ]);

        // Cashflow Livewire new expected income
        Livewire::test(CashflowIndex::class)
            ->set('expected_title', 'Yeni Danışmanlık')
            ->set('expected_amount', 25000)
            ->set('expected_date', Carbon::now()->addDays(5)->format('Y-m-d'))
            ->call('saveExpectedIncome');

        $this->assertDatabaseHas('expected_incomes', [
            'user_id' => $user->id,
            'title' => 'Yeni Danışmanlık',
            'amount' => 25000,
        ]);
    }
}
