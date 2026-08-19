<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Bank;
use App\Models\Category;
use App\Models\CreditCard;
use App\Models\Expense;
use App\Models\Income;
use App\Models\User;
use Illuminate\Database\Seeder;

class QnbLiveSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'dvtakblt@gmail.com')->first() ?? User::find(2);
        if (!$user) {
            echo "User not found!\n";
            return;
        }

        // 1. Banka: QNB Bank
        $bank = Bank::where('name', 'QNB Bank')->orWhere('name', 'QNB Finansbank')->first();
        if (!$bank) {
            $bank = Bank::create([
                'name' => 'QNB Bank',
                'color' => '#7A1F5C',
                'is_system' => true,
            ]);
        }

        // 2. Vadesiz TL Hesabı
        $account = Account::withoutGlobalScopes()->updateOrCreate(
            [
                'user_id' => $user->id,
                'bank_id' => $bank->id,
                'account_number' => '0162264341',
            ],
            [
                'name' => 'QNB TL Vadesiz Hesap',
                'type' => 'checking',
                'iban' => 'TR43 0011 1000 0000 0162 2643 41',
                'branch_name' => 'Bağcılar Şubesi',
                'balance' => 0.00,
                'currency' => 'TRY',
            ]
        );

        // 3. Kredi Kartı: QNB Mastercard (•••• 4945)
        $card = CreditCard::withoutGlobalScopes()->updateOrCreate(
            [
                'user_id' => $user->id,
                'bank_id' => $bank->id,
                'last_four' => '4945',
            ],
            [
                'name' => 'QNB Mastercard (4945)',
                'credit_limit' => 24000.00,
                'current_debt' => 0.00,
                'minimum_payment' => 0.00,
                'statement_day' => 18,
                'due_day' => 28,
                'next_due_date' => '2026-08-28',
                'interest_rate' => 3.25,
                'overdue_interest_rate' => 3.55,
                'reward_balance' => 0.00,
                'cash_advance_limit' => 6000.00,
                'is_cash_advance_blocked' => false,
                'status' => 'active',
            ]
        );

        // 4. Prim Gelirleri (18.06.2026 & 23.07.2026)
        $incomes = [
            ['2026-06-18', '2026-Mayıs Prim Ödemesi (QNB)', 23152.71, 'freelance'],
            ['2026-07-23', '2026-Haziran Prim Ödemesi (QNB)', 21700.00, 'freelance'],
        ];

        foreach ($incomes as $inc) {
            Income::withoutGlobalScopes()->updateOrCreate(
                [
                    'user_id' => $user->id,
                    'title' => $inc[1],
                    'income_date' => $inc[0],
                ],
                [
                    'amount' => $inc[2],
                    'type' => $inc[3],
                    'frequency' => 'one_time',
                    'received_day' => (int) date('d', strtotime($inc[0])),
                    'is_recurring' => false,
                ]
            );
        }

        // 5. Kart Aidatı Gideri
        $catFinance = Category::firstOrCreate(['name' => 'Banka & Finansman Gideri'], ['user_id' => $user->id, 'icon' => '🏛️', 'type' => 'expense']);
        Expense::withoutGlobalScopes()->updateOrCreate(
            [
                'user_id' => $user->id,
                'credit_card_id' => $card->id,
                'title' => 'QNB Yıllık Kart Üyelik Ücreti (Kart Aidatı)',
                'expense_date' => '2026-07-07',
            ],
            [
                'amount' => 982.50,
                'category_id' => $catFinance->id,
                'payment_method' => 'credit_card',
                'is_recurring' => false,
            ]
        );

        echo "QNB Bank account, Mastercard (borçsuz), prim incomes, and card fee expense seeded successfully!\n";
    }
}
