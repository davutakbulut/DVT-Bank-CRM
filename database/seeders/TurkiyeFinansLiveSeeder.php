<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Bank;
use App\Models\Category;
use App\Models\CreditCard;
use App\Models\Debt;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Database\Seeder;

class TurkiyeFinansLiveSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'dvtakblt@gmail.com')->first() ?? User::find(2);
        if (!$user) {
            echo "User not found!\n";
            return;
        }

        // 1. Banka: Türkiye Finans Katılım Bankası
        $bank = Bank::where('name', 'Türkiye Finans')->first();
        if (!$bank) {
            $bank = Bank::create([
                'name' => 'Türkiye Finans',
                'color' => '#00A389',
                'is_system' => true,
            ]);
        }

        // 2. Banka Hesapları (Başakşehir Şubesi)
        $account1 = Account::withoutGlobalScopes()->updateOrCreate(
            [
                'user_id' => $user->id,
                'bank_id' => $bank->id,
                'iban' => 'TR79 0020 6002 8005 0060 8400 01',
            ],
            [
                'name' => 'Türkiye Finans Cari Hesap (HESAP-1)',
                'type' => 'checking',
                'account_number' => '5006084-1',
                'branch_code' => '280',
                'branch_name' => 'Başakşehir Şubesi',
                'balance' => 0.00,
                'currency' => 'TRY',
            ]
        );

        $account2 = Account::withoutGlobalScopes()->updateOrCreate(
            [
                'user_id' => $user->id,
                'bank_id' => $bank->id,
                'iban' => 'TR52 0020 6002 8005 0060 8400 02',
            ],
            [
                'name' => 'Türkiye Finans Cari Hesap (HESAP-2)',
                'type' => 'checking',
                'account_number' => '5006084-2',
                'branch_code' => '280',
                'branch_name' => 'Başakşehir Şubesi',
                'balance' => 0.00,
                'currency' => 'TRY',
            ]
        );

        $account3 = Account::withoutGlobalScopes()->updateOrCreate(
            [
                'user_id' => $user->id,
                'bank_id' => $bank->id,
                'iban' => 'TR75 0020 6002 8005 0060 8421 10',
            ],
            [
                'name' => 'Türkiye Finans Teminat Hesabı',
                'type' => 'checking',
                'account_number' => '5006084-2110',
                'branch_code' => '280',
                'branch_name' => 'Başakşehir Şubesi',
                'balance' => 0.00,
                'currency' => 'TRY',
            ]
        );

        // 3. Kredi Kartı: Happy Zero (•••• 7709)
        $card = CreditCard::withoutGlobalScopes()->updateOrCreate(
            [
                'user_id' => $user->id,
                'bank_id' => $bank->id,
                'last_four' => '7709',
            ],
            [
                'name' => 'HAPPY ZERO VISA (7709)',
                'credit_limit' => 150000.00,
                'current_debt' => 42799.20,
                'minimum_payment' => 17414.00,
                'statement_day' => 29,
                'due_day' => 10,
                'next_due_date' => '2026-08-10',
                'interest_rate' => 3.25,
                'overdue_interest_rate' => 3.55,
                'reward_balance' => 186.40,
                'cash_advance_limit' => 0.00,
                'is_cash_advance_blocked' => true,
                'status' => 'active',
            ]
        );

        // 4. Aktif Borçlar
        // A) Happy Zero Güncel Ekstre Borcu (9 gün gecikmede)
        Debt::withoutGlobalScopes()->updateOrCreate(
            [
                'user_id' => $user->id,
                'bank_id' => $bank->id,
                'credit_card_id' => $card->id,
                'title' => 'Türkiye Finans Happy Zero - Güncel Ekstre Borcu',
            ],
            [
                'type' => 'credit_card',
                'principal' => 42799.20,
                'remaining' => 42799.20,
                'interest_rate' => 3.25,
                'installment_amount' => 17414.00,
                'next_due_date' => '2026-08-10',
                'days_overdue' => 9,
                'status' => 'active',
                'notes' => 'Hesap Kesim: 29.07.2026 | Son Ödeme: 10.08.2026 | Asgari: ₺17.414,00 | Limit: ₺150.000',
            ]
        );

        // B) QNBPAY / NISH AUTO (ADV 350 Motor Bedeli - 3/8 Taksit, Kalan 5 Taksit: ₺93.750)
        Debt::withoutGlobalScopes()->updateOrCreate(
            [
                'user_id' => $user->id,
                'bank_id' => $bank->id,
                'credit_card_id' => $card->id,
                'title' => 'QNBPAY / NISH AUTO - Motor Bedeli (3/8 Taksit)',
            ],
            [
                'type' => 'credit_card',
                'merchant_name' => 'QNBPAY / NISH AUTO İSTANBUL',
                'principal' => 150000.00,
                'remaining' => 93750.00,
                'interest_rate' => 0.00,
                'total_installments' => 8,
                'current_installment' => 3,
                'installment_amount' => 18750.00,
                'transaction_date' => '2026-05-25',
                'start_date' => '2026-05-25',
                'next_due_date' => '2026-09-10',
                'days_overdue' => 0,
                'status' => 'active',
                'notes' => 'ADV 350 motor taksiti. Toplam: ₺150.000 (8 x ₺18.750). Ödenen 3 taksit, kalan 5 taksit: ₺93.750',
            ]
        );

        // 5. Kategoriler & Harcama Geçmişi (Ekstre Kalemleri)
        $catFuel = Category::firstOrCreate(['name' => 'Akaryakıt & Ulaşım'], ['user_id' => $user->id, 'icon' => '⛽', 'type' => 'expense']);
        $catFood = Category::firstOrCreate(['name' => 'Yeme & İçme'], ['user_id' => $user->id, 'icon' => '🍔', 'type' => 'expense']);
        $catMarket = Category::firstOrCreate(['name' => 'Market & Alışveriş'], ['user_id' => $user->id, 'icon' => '🛒', 'type' => 'expense']);
        $catFinance = Category::firstOrCreate(['name' => 'Banka & Finansman Gideri'], ['user_id' => $user->id, 'icon' => '🏛️', 'type' => 'expense']);
        $catOther = Category::firstOrCreate(['name' => 'Diğer Giderler'], ['user_id' => $user->id, 'icon' => '📦', 'type' => 'expense']);

        $expenses = [
            // Haziran 2026 Ekstresi
            ['2026-06-19', 'MC DONALDS-MERTER İSTANBUL', 600.00, $catFood->id],
            ['2026-06-29', 'Türkiye Finans Happy Zero Kar Payı Kesintisi', 286.62, $catFinance->id],
            ['2026-06-29', 'Türkiye Finans Happy Zero BSMV', 42.99, $catFinance->id],
            ['2026-06-29', 'Türkiye Finans Happy Zero KKDF', 43.00, $catFinance->id],

            // Temmuz 2026 Ekstresi
            ['2026-07-04', 'SHELL ESENLER İSTANBUL', 664.32, $catFuel->id],
            ['2026-07-04', 'RAMAZAN ADAK SAHIS FIRMASI İSTANBUL', 375.00, $catFood->id],
            ['2026-07-05', 'SHELL PETROL İSTANBUL', 1000.00, $catFuel->id],
            ['2026-07-06', 'MINI MARKET İSTANBUL', 360.00, $catMarket->id],
            ['2026-07-06', 'HUB COFFEE KİTCHEN KOCAELİ', 505.00, $catFood->id],
            ['2026-07-06', 'ACCRACHOCOLATE İNŞAAT KOCAELİ', 1040.00, $catFood->id],
            ['2026-07-07', 'TARHAN KURUYEMİŞ İSTANBUL', 349.00, $catMarket->id],
            ['2026-07-07', 'KÜÇÜKÇEKMECE İDMAN YURDU İSTANBUL', 210.00, $catOther->id],
            ['2026-07-07', 'ZEREN KAFE İSTANBUL', 900.00, $catFood->id],
            ['2026-07-07', 'MEHMETÇİK VAKFI LTD. ŞTİ. İSTANBUL', 650.00, $catOther->id],
            ['2026-07-08', 'ŞOK-FINDIKZADE MOLLA GÜRANİ İSTANBUL', 227.25, $catMarket->id],
            ['2026-07-08', 'ARDA DONDURMA İSTANBUL', 780.00, $catFood->id],
            ['2026-07-09', 'ŞOK-FINDIKZADE MOLLA GÜRANİ İSTANBUL', 230.00, $catMarket->id],
            ['2026-07-09', 'PWN PEANUT WAFFLE ŞERİF İSTANBUL', 320.00, $catFood->id],
            ['2026-07-10', 'MİGROS YEŞİLKÖY ÇARŞI DÜZCE', 588.40, $catMarket->id],
            ['2026-07-10', 'MİGROS YEŞİLKÖY ÇARŞI DÜZCE', 115.00, $catMarket->id],
            ['2026-07-10', 'MINI MARKET İSTANBUL', 305.00, $catMarket->id],
            ['2026-07-10', 'MINI MARKET İSTANBUL', 70.00, $catMarket->id],
            ['2026-07-10', 'BEYOĞLU DÖNER İSTANBUL', 810.00, $catFood->id],
            ['2026-07-11', 'CEMPAŞ MARKET İSTANBUL', 275.00, $catMarket->id],
            ['2026-07-13', 'DAĞYOLU PETROL İSTANBUL', 659.70, $catFuel->id],
            ['2026-07-13', 'MINI MARKET İSTANBUL', 375.00, $catMarket->id],
            ['2026-07-15', 'GÖKKUŞAĞI MARKETLERİ İSTANBUL', 230.00, $catMarket->id],
            ['2026-07-15', 'BÜYÜKDERE KAFE İSTANBUL', 380.00, $catFood->id],
            ['2026-07-16', 'SHELL-ESENLER İSTANBUL', 180.00, $catFuel->id],
            ['2026-07-16', 'MINI MARKET İSTANBUL', 230.00, $catMarket->id],
            ['2026-07-16', 'HATAY GIDA-2 İSTANBUL', 120.00, $catMarket->id],
            ['2026-07-29', 'Türkiye Finans Happy Zero Kar Payı Kesintisi', 377.33, $catFinance->id],
            ['2026-07-29', 'Türkiye Finans Happy Zero BSMV', 56.60, $catFinance->id],
            ['2026-07-29', 'Türkiye Finans Happy Zero KKDF', 56.60, $catFinance->id],
        ];

        foreach ($expenses as $e) {
            Expense::withoutGlobalScopes()->updateOrCreate(
                [
                    'user_id' => $user->id,
                    'credit_card_id' => $card->id,
                    'title' => $e[1],
                    'amount' => $e[2],
                    'expense_date' => $e[0],
                ],
                [
                    'category_id' => $e[3],
                    'payment_method' => 'credit_card',
                    'is_recurring' => false,
                ]
            );
        }

        echo "Türkiye Finans accounts, Happy Zero card, motor debt and 34 statement expenses seeded successfully!\n";
    }
}
