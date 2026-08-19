<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Bank;
use App\Models\Debt;
use App\Models\User;
use Illuminate\Database\Seeder;

class AkbankLiveSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'dvtakblt@gmail.com')->first() ?? User::find(2);
        if (!$user) {
            echo "User not found!\n";
            return;
        }

        // 1. Banka: Akbank
        $bank = Bank::where('name', 'Akbank')->first();
        if (!$bank) {
            $bank = Bank::create([
                'name' => 'Akbank',
                'color' => '#E30613',
                'is_system' => true,
            ]);
        }

        // 2. Vadesiz TL Hesabı (Artı Para)
        $account = Account::withoutGlobalScopes()->updateOrCreate(
            [
                'user_id' => $user->id,
                'bank_id' => $bank->id,
                'account_number' => '0296003',
            ],
            [
                'name' => 'Akbank Vadesiz TL (Artı Para)',
                'type' => 'checking',
                'iban' => 'TR24 0004 6004 4788 8000 2960 03',
                'branch_code' => '0447',
                'branch_name' => 'ESENLER/İSTANBUL',
                'balance' => -59380.90,
                'kmh_limit' => 65000.00,
                'kmh_interest_rate' => 4.25,
                'currency' => 'TRY',
            ]
        );

        // 3. Artı Para (KMH) Borcu
        Debt::withoutGlobalScopes()->updateOrCreate(
            [
                'user_id' => $user->id,
                'bank_id' => $bank->id,
                'account_id' => $account->id,
                'type' => 'kmh',
            ],
            [
                'title' => 'Akbank Artı Para / KMH Borcu',
                'principal' => 59380.90,
                'remaining' => 59380.90,
                'interest_rate' => 4.25,
                'installment_amount' => 6152.69,
                'next_due_date' => '2026-08-31',
                'days_overdue' => 0,
                'status' => 'active',
                'notes' => 'Hesap Özeti Kesim: 31.07.2026 | Son Ödeme: 31.08.2026 | Asgari Tutar: ₺6.152,69 | Limit: ₺65.000',
            ]
        );

        echo "Akbank account and Artı Para debt seeded successfully!\n";
    }
}
