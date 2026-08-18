<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Bank;
use App\Models\CreditCard;
use App\Models\Debt;
use App\Models\User;
use Database\Seeders\BankSeeder;
use Database\Seeders\PlanSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DataIsolationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_cannot_access_or_query_another_users_financial_records(): void
    {
        $this->seed([RoleSeeder::class, PlanSeeder::class, BankSeeder::class]);

        $userA = User::factory()->create();
        $userA->assignRole('user');

        $userB = User::factory()->create();
        $userB->assignRole('user');

        $bank = Bank::where('is_system', true)->first();

        // User A records
        $accountA = Account::create([
            'user_id' => $userA->id,
            'bank_id' => $bank->id,
            'name' => 'User A KMH',
            'type' => 'kmh',
            'balance' => -10000,
        ]);

        $debtA = Debt::create([
            'user_id' => $userA->id,
            'bank_id' => $bank->id,
            'type' => 'loan',
            'title' => 'User A Secret Debt',
            'principal' => 50000,
            'remaining' => 50000,
        ]);

        // User B logs in
        $this->actingAs($userB);

        // BelongsToUser Global Scope must hide User A records from User B
        $this->assertCount(0, Account::all());
        $this->assertCount(0, Debt::all());
        $this->assertNull(Debt::find($debtA->id));
        $this->assertNull(Account::find($accountA->id));

        // User A logs in
        $this->actingAs($userA);
        $this->assertCount(1, Account::all());
        $this->assertCount(1, Debt::all());
        $this->assertEquals($debtA->id, Debt::first()->id);
    }
}
