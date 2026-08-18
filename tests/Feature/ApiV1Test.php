<?php

namespace Tests\Feature;

use App\Models\Bank;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiV1Test extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(\Database\Seeders\RoleSeeder::class);

        Plan::create([
            'name' => 'Ücretsiz Plan',
            'slug' => 'free',
            'price' => 0,
            'interval' => 'month',
            'is_active' => true,
        ]);
    }

    public function test_api_auth_and_full_crud_flows(): void
    {
        // 1. Register API
        $regResponse = $this->postJson('/api/v1/auth/register', [
            'name' => 'Ahmet Yılmaz',
            'email' => 'ahmet@example.com',
            'password' => 'password123',
        ]);

        $regResponse->assertStatus(201)
            ->assertJsonStructure(['status', 'data' => ['user', 'token']]);

        $token = $regResponse->json('data.token');
        $headers = ['Authorization' => 'Bearer ' . $token];

        // 2. Auth Me API
        $this->getJson('/api/v1/auth/me', $headers)
            ->assertStatus(200)
            ->assertJsonPath('data.email', 'ahmet@example.com');

        // 3. Bank API
        $bankResponse = $this->postJson('/api/v1/banks', [
            'name' => 'Garanti BBVA',
            'code' => 'GARANTI',
            'color' => '#008543',
        ], $headers);

        $bankResponse->assertStatus(201);
        $bankId = $bankResponse->json('data.id');

        // 4. Account & KMH API
        $accResponse = $this->postJson('/api/v1/accounts', [
            'bank_id' => $bankId,
            'name' => 'Avans Hesap',
            'type' => 'kmh',
            'balance' => -25000,
            'kmh_limit' => 50000,
            'kmh_interest_rate' => 5.0,
        ], $headers);

        $accResponse->assertStatus(201)
            ->assertJsonPath('data.balance', '-25000.00');

        // 5. Credit Card API
        $cardResponse = $this->postJson('/api/v1/cards', [
            'bank_id' => $bankId,
            'name' => 'Bonus Kart',
            'last_four' => '1234',
            'credit_limit' => 80000,
            'current_debt' => 45000,
            'minimum_payment' => 18000,
            'statement_day' => 15,
            'due_day' => 25,
            'interest_rate' => 4.25,
        ], $headers);

        $cardResponse->assertStatus(201);

        // 6. Debt API
        $debtResponse = $this->postJson('/api/v1/debts', [
            'bank_id' => $bankId,
            'type' => 'loan',
            'title' => 'İhtiyaç Kredisi',
            'principal' => 100000,
            'remaining' => 80000,
            'interest_rate' => 3.90,
            'installment_amount' => 5500,
            'days_overdue' => 20,
        ], $headers);

        $debtResponse->assertStatus(201);
        $debtId = $debtResponse->json('data.id');

        // 7. Debt Pay API
        $payResponse = $this->postJson("/api/v1/debts/{$debtId}/pay", [
            'amount' => 5500,
            'note' => 'Taksit ödendi',
        ], $headers);

        $payResponse->assertStatus(200)
            ->assertJsonPath('data.remaining', '74500.00');

        // 8. Cashflow API
        $this->postJson('/api/v1/cashflow/incomes', [
            'title' => 'Maaş',
            'amount' => 70000,
        ], $headers)->assertStatus(201);

        $this->postJson('/api/v1/cashflow/expenses', [
            'title' => 'Ev Kirası',
            'amount' => 25000,
            'expense_date' => now()->format('Y-m-d'),
        ], $headers)->assertStatus(201);

        $this->getJson('/api/v1/cashflow/summary', $headers)
            ->assertStatus(200)
            ->assertJsonPath('data.net_remaining', 45000);

        // 9. Planner Compare & Generate API
        $this->postJson('/api/v1/planner/compare', [
            'monthly_budget' => 20000,
        ], $headers)->assertStatus(200);

        $this->postJson('/api/v1/planner/generate', [
            'monthly_budget' => 20000,
            'strategy' => 'avalanche',
        ], $headers)->assertStatus(201);

        // 10. Risk API
        $this->getJson('/api/v1/risk/summary', $headers)->assertStatus(200);
        $this->getJson('/api/v1/risk/deadlines', $headers)->assertStatus(200);

        // 11. AI Coach API
        $this->postJson('/api/v1/ai/generate-advice', ['type' => 'daily'], $headers)->assertStatus(200);
        $this->postJson('/api/v1/ai/chat', ['message' => 'Ödeme planım nasıl görünüyor?'], $headers)->assertStatus(200);
        $this->getJson('/api/v1/ai/history', $headers)->assertStatus(200);

        // 12. Report Overview API
        $this->getJson('/api/v1/reports/overview', $headers)->assertStatus(200);
    }
}
