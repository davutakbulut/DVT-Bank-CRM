<?php

namespace Tests\Feature;

use App\Models\Bank;
use App\Models\CreditCard;
use App\Models\Debt;
use App\Models\User;
use App\Services\AI\AiManager;
use App\Services\DebtCalculator;
use App\Services\PaymentPlanner;
use App\Services\RiskCounter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FinancialPlannerTest extends TestCase
{
    use RefreshDatabase;

    public function test_risk_counter_calculates_overdue_and_legal_deadlines(): void
    {
        $user = User::factory()->create();

        $bank = Bank::create([
            'name' => 'Garanti BBVA',
            'code' => 'GARANTI',
            'color' => '#008543',
            'is_system' => true,
        ]);

        Debt::create([
            'user_id' => $user->id,
            'bank_id' => $bank->id,
            'type' => 'kmh',
            'title' => 'Avans Hesap',
            'principal' => 50000,
            'remaining' => 50000,
            'interest_rate' => 5.0,
            'days_overdue' => 34,
            'status' => 'active',
        ]);

        $riskCounter = new RiskCounter();
        $summary = $riskCounter->calculateUserRiskSummary($user);

        $this->assertEquals(50000, $summary['total_remaining']);
        $this->assertEquals(34, $summary['max_overdue_days']);
        $this->assertEquals(56, $summary['days_to_legal_minimum']); // 90 - 34 = 56
        $this->assertEquals('normal', $summary['risk_level']);
    }

    public function test_debt_calculator_compares_avalanche_and_snowball_strategies(): void
    {
        $calculator = new DebtCalculator();

        $debts = [
            [
                'id' => 1,
                'title' => 'Borç A',
                'remaining' => 10000,
                'interest_rate' => 5.0, // Aylık %5
                'installment_amount' => 1000,
            ],
            [
                'id' => 2,
                'title' => 'Borç B',
                'remaining' => 40000,
                'interest_rate' => 3.5,
                'installment_amount' => 2000,
            ],
        ];

        $comparison = $calculator->compareStrategies($debts, 5000);

        $this->assertArrayHasKey('avalanche', $comparison);
        $this->assertArrayHasKey('snowball', $comparison);
        $this->assertArrayHasKey('savings_amount', $comparison);
        $this->assertGreaterThanOrEqual(0, $comparison['savings_amount']);
    }

    public function test_ai_manager_uses_offline_fallback_when_no_api_keys(): void
    {
        $user = User::factory()->create();

        $aiManager = new AiManager();
        $advice = $aiManager->generateAdviceForUser($user, 'daily');

        $this->assertNotNull($advice);
        $this->assertEquals('fallback', $advice->status);
        $this->assertEquals('rule_engine', $advice->provider);
        $this->assertStringContainsString('6362 sayılı', $advice->content);
    }

    public function test_payment_planner_generates_monthly_items(): void
    {
        $user = User::factory()->create();

        $debt = Debt::create([
            'user_id' => $user->id,
            'type' => 'loan',
            'title' => 'İhtiyaç Kredisi',
            'principal' => 30000,
            'remaining' => 30000,
            'interest_rate' => 3.5,
            'installment_amount' => 2500,
            'status' => 'active',
        ]);

        $planner = new PaymentPlanner();
        $plan = $planner->generatePlan($user, 4000, 'avalanche');

        $this->assertNotNull($plan);
        $this->assertEquals('active', $plan->status);
        $this->assertGreaterThan(0, $plan->items()->count());
    }
}
