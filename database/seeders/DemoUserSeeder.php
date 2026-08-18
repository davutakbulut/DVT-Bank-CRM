<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Bank;
use App\Models\Category;
use App\Models\CreditCard;
use App\Models\Debt;
use App\Models\Expense;
use App\Models\Income;
use App\Models\Plan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoUserSeeder extends Seeder
{
    public function run(): void
    {
        $proPlan = Plan::where('slug', 'pro')->first();

        $demoUser = User::updateOrCreate(
            ['email' => 'demo@dvt.portegu.com'],
            [
                'name' => 'Davut Akbulut (Kriz Demo)',
                'password' => Hash::make('Demo123456!*'),
                'phone' => '05551234567',
                'plan_id' => $proPlan?->id,
                'status' => 'active',
                'monthly_income' => 65000.00,
                'onboarding_completed' => true,
                'email_verified_at' => now(),
            ]
        );

        $demoUser->syncRoles(['user']);

        // Sistem Bankaları
        $ziraat = Bank::where('name', 'Ziraat Bankası')->first();
        $isBank = Bank::where('name', 'Türkiye İş Bankası')->first();
        $garanti = Bank::where('name', 'Garanti BBVA')->first();
        $yapiKredi = Bank::where('name', 'Yapı Kredi')->first();
        $akbank = Bank::where('name', 'Akbank')->first();
        $enpara = Bank::where('name', 'Enpara.com')->first();

        // 1. ZİRAAT BANKASI
        if ($ziraat) {
            $ziraatKmh = Account::create([
                'user_id' => $demoUser->id,
                'bank_id' => $ziraat->id,
                'name' => 'Ziraat KMH (Ek Para Hesabı)',
                'type' => 'kmh',
                'iban' => 'TR920001000000000011112222',
                'balance' => -50000.00,
                'kmh_limit' => 50000.00,
                'kmh_interest_rate' => 5.0000,
            ]);

            $ziraatKart = CreditCard::create([
                'user_id' => $demoUser->id,
                'bank_id' => $ziraat->id,
                'name' => 'Ziraat Bankkart Combo',
                'last_four' => '1024',
                'credit_limit' => 60000.00,
                'current_debt' => 45000.00,
                'minimum_payment' => 18000.00,
                'statement_day' => 5,
                'due_day' => 15,
                'interest_rate' => 4.2500,
                'overdue_interest_rate' => 4.5500,
                'last_payment_date' => Carbon::now()->subDays(45),
            ]);

            Debt::create([
                'user_id' => $demoUser->id,
                'bank_id' => $ziraat->id,
                'account_id' => $ziraatKmh->id,
                'type' => 'kmh',
                'title' => 'Ziraat KMH / Eksi Bakiye Borcu',
                'principal' => 50000.00,
                'remaining' => 50000.00,
                'interest_rate' => 5.0000,
                'next_due_date' => Carbon::now()->addDays(5),
                'last_payment_date' => Carbon::now()->subDays(45),
                'days_overdue' => 45,
                'status' => 'active',
                'notes' => 'Acil KMH yapılandırması talep edilecek.',
            ]);

            Debt::create([
                'user_id' => $demoUser->id,
                'bank_id' => $ziraat->id,
                'credit_card_id' => $ziraatKart->id,
                'type' => 'credit_card',
                'title' => 'Ziraat Bankkart Dönem Borcu',
                'principal' => 45000.00,
                'remaining' => 45000.00,
                'interest_rate' => 4.2500,
                'next_due_date' => Carbon::now()->addDays(3),
                'last_payment_date' => Carbon::now()->subDays(45),
                'days_overdue' => 45,
                'status' => 'active',
            ]);
        }

        // 2. GARANTİ BBVA
        if ($garanti) {
            $garantiKart = CreditCard::create([
                'user_id' => $demoUser->id,
                'bank_id' => $garanti->id,
                'name' => 'Garanti BBVA Bonus Platinum',
                'last_four' => '4490',
                'credit_limit' => 80000.00,
                'current_debt' => 65000.00,
                'minimum_payment' => 26000.00,
                'statement_day' => 12,
                'due_day' => 22,
                'interest_rate' => 4.2500,
                'overdue_interest_rate' => 4.5500,
                'last_payment_date' => Carbon::now()->subDays(35),
            ]);

            Debt::create([
                'user_id' => $demoUser->id,
                'bank_id' => $garanti->id,
                'type' => 'loan',
                'title' => 'Garanti İhtiyaç Kredisi',
                'principal' => 150000.00,
                'remaining' => 120000.00,
                'interest_rate' => 3.8500,
                'installment_count' => 24,
                'installment_amount' => 8500.00,
                'start_date' => Carbon::now()->subMonths(6),
                'end_date' => Carbon::now()->addMonths(18),
                'next_due_date' => Carbon::now()->addDays(7),
                'last_payment_date' => Carbon::now()->subDays(25),
                'days_overdue' => 12,
                'status' => 'active',
            ]);

            Debt::create([
                'user_id' => $demoUser->id,
                'bank_id' => $garanti->id,
                'credit_card_id' => $garantiKart->id,
                'type' => 'credit_card',
                'title' => 'Garanti Bonus Borcu',
                'principal' => 65000.00,
                'remaining' => 65000.00,
                'interest_rate' => 4.2500,
                'next_due_date' => Carbon::now()->addDays(4),
                'last_payment_date' => Carbon::now()->subDays(35),
                'days_overdue' => 35,
                'status' => 'active',
            ]);
        }

        // 3. YAPI KREDİ (EN KRİTİK - 68 GÜN GECİKME)
        if ($yapiKredi) {
            $ykKmh = Account::create([
                'user_id' => $demoUser->id,
                'bank_id' => $yapiKredi->id,
                'name' => 'Yapı Kredi Esnek Hesap (KMH)',
                'type' => 'kmh',
                'iban' => 'TR440006700000000088889999',
                'balance' => -30000.00,
                'kmh_limit' => 30000.00,
                'kmh_interest_rate' => 5.0000,
            ]);

            $ykKart = CreditCard::create([
                'user_id' => $demoUser->id,
                'bank_id' => $yapiKredi->id,
                'name' => 'Yapı Kredi Worldcard',
                'last_four' => '8821',
                'credit_limit' => 75000.00,
                'current_debt' => 55000.00,
                'minimum_payment' => 22000.00,
                'statement_day' => 1,
                'due_day' => 10,
                'interest_rate' => 4.2500,
                'overdue_interest_rate' => 4.5500,
                'last_payment_date' => Carbon::now()->subDays(68),
            ]);

            Debt::create([
                'user_id' => $demoUser->id,
                'bank_id' => $yapiKredi->id,
                'account_id' => $ykKmh->id,
                'type' => 'kmh',
                'title' => 'Yapı Kredi Esnek Hesap Borcu (KRİTİK)',
                'principal' => 30000.00,
                'remaining' => 30000.00,
                'interest_rate' => 5.0000,
                'next_due_date' => Carbon::now()->addDays(2),
                'last_payment_date' => Carbon::now()->subDays(68),
                'days_overdue' => 68, // 90 güne 22 gün kaldı!
                'status' => 'active',
                'notes' => 'DİKKAT: 90 günlük yasal takibe 22 gün kaldı! İlk önce burası görüşülmeli!',
            ]);

            Debt::create([
                'user_id' => $demoUser->id,
                'bank_id' => $yapiKredi->id,
                'credit_card_id' => $ykKart->id,
                'type' => 'credit_card',
                'title' => 'Yapı Kredi Worldcard Borcu (KRİTİK)',
                'principal' => 55000.00,
                'remaining' => 55000.00,
                'interest_rate' => 4.2500,
                'next_due_date' => Carbon::now()->addDays(2),
                'last_payment_date' => Carbon::now()->subDays(68),
                'days_overdue' => 68,
                'status' => 'active',
            ]);
        }

        // 4. AKBANK
        if ($akbank) {
            $akKmh = Account::create([
                'user_id' => $demoUser->id,
                'bank_id' => $akbank->id,
                'name' => 'Akbank Artı Para Hesabı',
                'type' => 'kmh',
                'iban' => 'TR110004600000000033334444',
                'balance' => -25000.00,
                'kmh_limit' => 25000.00,
                'kmh_interest_rate' => 5.0000,
            ]);

            $akKart = CreditCard::create([
                'user_id' => $demoUser->id,
                'bank_id' => $akbank->id,
                'name' => 'Akbank Axess Wings',
                'last_four' => '7734',
                'credit_limit' => 85000.00,
                'current_debt' => 70000.00,
                'minimum_payment' => 28000.00,
                'statement_day' => 18,
                'due_day' => 28,
                'interest_rate' => 4.2500,
                'overdue_interest_rate' => 4.5500,
                'last_payment_date' => Carbon::now()->subDays(20),
            ]);

            Debt::create([
                'user_id' => $demoUser->id,
                'bank_id' => $akbank->id,
                'account_id' => $akKmh->id,
                'type' => 'kmh',
                'title' => 'Akbank Artı Para Borcu',
                'principal' => 25000.00,
                'remaining' => 25000.00,
                'interest_rate' => 5.0000,
                'next_due_date' => Carbon::now()->addDays(10),
                'last_payment_date' => Carbon::now()->subDays(20),
                'days_overdue' => 20,
                'status' => 'active',
            ]);

            Debt::create([
                'user_id' => $demoUser->id,
                'bank_id' => $akbank->id,
                'credit_card_id' => $akKart->id,
                'type' => 'credit_card',
                'title' => 'Akbank Axess Kart Borcu',
                'principal' => 70000.00,
                'remaining' => 70000.00,
                'interest_rate' => 4.2500,
                'next_due_date' => Carbon::now()->addDays(8),
                'last_payment_date' => Carbon::now()->subDays(20),
                'days_overdue' => 20,
                'status' => 'active',
            ]);
        }

        // 5. TÜRKİYE İŞ BANKASI
        if ($isBank) {
            $isKart = CreditCard::create([
                'user_id' => $demoUser->id,
                'bank_id' => $isBank->id,
                'name' => 'İş Bankası Maximum Kart',
                'last_four' => '5561',
                'credit_limit' => 50000.00,
                'current_debt' => 40000.00,
                'minimum_payment' => 16000.00,
                'statement_day' => 8,
                'due_day' => 18,
                'interest_rate' => 4.2500,
                'overdue_interest_rate' => 4.5500,
                'last_payment_date' => Carbon::now()->subDays(15),
            ]);

            Debt::create([
                'user_id' => $demoUser->id,
                'bank_id' => $isBank->id,
                'type' => 'loan',
                'title' => 'İş Bankası İhtiyaç Kredisi',
                'principal' => 100000.00,
                'remaining' => 80000.00,
                'interest_rate' => 3.9000,
                'installment_count' => 24,
                'installment_amount' => 5800.00,
                'start_date' => Carbon::now()->subMonths(5),
                'end_date' => Carbon::now()->addMonths(19),
                'next_due_date' => Carbon::now()->addDays(14),
                'last_payment_date' => Carbon::now()->subDays(15),
                'days_overdue' => 5,
                'status' => 'active',
            ]);

            Debt::create([
                'user_id' => $demoUser->id,
                'bank_id' => $isBank->id,
                'credit_card_id' => $isKart->id,
                'type' => 'credit_card',
                'title' => 'İş Bankası Maximum Borcu',
                'principal' => 40000.00,
                'remaining' => 40000.00,
                'interest_rate' => 4.2500,
                'next_due_date' => Carbon::now()->addDays(11),
                'last_payment_date' => Carbon::now()->subDays(15),
                'days_overdue' => 15,
                'status' => 'active',
            ]);
        }

        // 6. ENPARA.COM
        if ($enpara) {
            $enparaKart = CreditCard::create([
                'user_id' => $demoUser->id,
                'bank_id' => $enpara->id,
                'name' => 'Enpara Kredi Kartı',
                'last_four' => '9912',
                'credit_limit' => 40000.00,
                'current_debt' => 35000.00,
                'minimum_payment' => 14000.00,
                'statement_day' => 20,
                'due_day' => 30,
                'interest_rate' => 4.2500,
                'overdue_interest_rate' => 4.5500,
                'last_payment_date' => Carbon::now()->subDays(10),
            ]);

            Debt::create([
                'user_id' => $demoUser->id,
                'bank_id' => $enpara->id,
                'type' => 'loan',
                'title' => 'Enpara Masrafsız İhtiyaç Kredisi',
                'principal' => 60000.00,
                'remaining' => 45000.00,
                'interest_rate' => 3.9500,
                'installment_count' => 18,
                'installment_amount' => 4200.00,
                'start_date' => Carbon::now()->subMonths(4),
                'end_date' => Carbon::now()->addMonths(14),
                'next_due_date' => Carbon::now()->addDays(12),
                'last_payment_date' => Carbon::now()->subDays(10),
                'days_overdue' => 0,
                'status' => 'active',
            ]);

            Debt::create([
                'user_id' => $demoUser->id,
                'bank_id' => $enpara->id,
                'credit_card_id' => $enparaKart->id,
                'type' => 'credit_card',
                'title' => 'Enpara Kredi Kartı Borcu',
                'principal' => 35000.00,
                'remaining' => 35000.00,
                'interest_rate' => 4.2500,
                'next_due_date' => Carbon::now()->addDays(12),
                'last_payment_date' => Carbon::now()->subDays(10),
                'days_overdue' => 0,
                'status' => 'active',
            ]);
        }

        // Aylık Gelir
        Income::create([
            'user_id' => $demoUser->id,
            'title' => 'Aylık Net Maaş',
            'amount' => 65000.00,
            'type' => 'salary',
            'frequency' => 'monthly',
            'received_day' => 1,
            'is_recurring' => true,
        ]);

        // Temel Yaşam Giderleri
        $kiraCat = Category::where('name', 'Kira & Barınma')->first();
        $faturaCat = Category::where('name', 'Faturalar (Elektrik, Su, Doğalgaz)')->first();
        $marketCat = Category::where('name', 'Market & Gıda')->first();

        if ($kiraCat) {
            Expense::create([
                'user_id' => $demoUser->id,
                'category_id' => $kiraCat->id,
                'title' => 'Ev Kirası',
                'amount' => 20000.00,
                'expense_date' => Carbon::now()->startOfMonth(),
                'is_recurring' => true,
            ]);
        }

        if ($faturaCat) {
            Expense::create([
                'user_id' => $demoUser->id,
                'category_id' => $faturaCat->id,
                'title' => 'Elektrik + Doğalgaz + İnternet',
                'amount' => 4500.00,
                'expense_date' => Carbon::now()->startOfMonth()->addDays(5),
                'is_recurring' => true,
            ]);
        }

        if ($marketCat) {
            Expense::create([
                'user_id' => $demoUser->id,
                'category_id' => $marketCat->id,
                'title' => 'Mutfak & Market Harcaması',
                'amount' => 8500.00,
                'expense_date' => Carbon::now()->startOfMonth()->addDays(10),
                'is_recurring' => true,
            ]);
        }
    }
}
