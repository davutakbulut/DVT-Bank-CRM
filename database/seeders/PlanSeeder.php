<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        Plan::updateOrCreate(
            ['slug' => 'free'],
            [
                'name' => 'Ücretsiz Plan',
                'price_monthly' => 0.00,
                'max_banks' => 2,
                'max_debts' => 5,
                'ai_frequency' => 'weekly',
                'features' => [
                    'basic_dashboard' => true,
                    'ai_coach_weekly' => true,
                    'risk_counter' => true,
                    'export' => false,
                ],
                'is_active' => true,
            ]
        );

        Plan::updateOrCreate(
            ['slug' => 'pro'],
            [
                'name' => 'Pro Plan',
                'price_monthly' => 149.00,
                'max_banks' => -1, // Sınırsız
                'max_debts' => -1, // Sınırsız
                'ai_frequency' => 'daily',
                'features' => [
                    'unlimited_banks' => true,
                    'unlimited_debts' => true,
                    'payment_planner' => true,
                    'ai_coach_daily' => true,
                    'ai_chat' => true,
                    'reports_and_charts' => true,
                    'pdf_excel_export' => true,
                    'custom_reminders' => true,
                ],
                'is_active' => true,
            ]
        );
    }
}
