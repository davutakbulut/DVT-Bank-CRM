<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Bank;
use App\Models\Category;
use App\Models\CreditCard;
use App\Models\Debt;
use App\Models\Expense;
use App\Models\Income;
use App\Models\User;
use Illuminate\Database\Seeder;

class EnparaLiveSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'dvtakblt@gmail.com')->first();
        if (!$user) {
            $user = User::find(2);
        }
        if (!$user) {
            echo "User not found!\n";
            return;
        }

        $bank = Bank::where('name', 'Enpara.com')->first();
        if (!$bank) {
            $bank = Bank::create([
                'name' => 'Enpara.com',
                'color' => '#5E2750',
                'is_system' => true,
            ]);
        }

        // 1. Account (Vadesiz TL & Ekpara)
        $account = Account::withoutGlobalScopes()->updateOrCreate(
            [
                'user_id' => $user->id,
                'bank_id' => $bank->id,
                'iban' => 'TR14 0015 7000 0000 0101 3584 64',
            ],
            [
                'name' => 'Enpara Vadesiz TL (Ekpara)',
                'type' => 'checking',
                'account_number' => '101358464',
                'branch_code' => '03663',
                'branch_name' => 'Enpara Bank A.Ş.',
                'balance' => -77118.64,
                'kmh_limit' => 84500.00,
                'kmh_interest_rate' => 4.25,
                'currency' => 'TRY',
            ]
        );

        // 2. Credit Card
        $card = CreditCard::withoutGlobalScopes()->updateOrCreate(
            [
                'user_id' => $user->id,
                'bank_id' => $bank->id,
                'last_four' => '7505',
            ],
            [
                'name' => 'ENPARA KREDİ KARTI',
                'card_number' => '5269 1101 1624 7505',
                'card_holder' => 'Davut Akbulut',
                'expiry_date' => '11/28',
                'credit_limit' => 169000.00,
                'cash_advance_limit' => 169000.00,
                'is_cash_advance_blocked' => false,
                'current_debt' => 143225.76,
                'minimum_payment' => 48142.00,
                'reward_balance' => 0.00,
                'statement_day' => 2,
                'due_day' => 12,
                'statement_date' => '2026-08-02',
                'next_statement_date' => '2026-09-02',
                'next_due_date' => '2026-08-12',
                'interest_rate' => 3.75,
                'overdue_interest_rate' => 4.05,
                'status' => 'active',
            ]
        );

        // 3. Debts
        // A) Ekpara / KMH Borcu
        Debt::withoutGlobalScopes()->updateOrCreate(
            [
                'user_id' => $user->id,
                'bank_id' => $bank->id,
                'account_id' => $account->id,
                'type' => 'kmh',
            ],
            [
                'title' => 'Enpara.com Ekpara / KMH Borcu',
                'merchant_name' => 'Enpara Bank A.Ş.',
                'principal' => 77118.64,
                'remaining' => 77118.64,
                'interest_rate' => 4.25,
                'next_due_date' => '2026-09-01',
                'days_overdue' => 0,
                'status' => 'active',
                'notes' => 'Kullanılan Ekpara: ₺77.118,64 / Limit: ₺84.500,00 | Aylık Faiz: %4,25 (Aylık Faiz Yükü: ~₺3.277,54)',
            ]
        );

        // B) Güncel Ekstre Borcu
        Debt::withoutGlobalScopes()->updateOrCreate(
            [
                'user_id' => $user->id,
                'bank_id' => $bank->id,
                'credit_card_id' => $card->id,
                'type' => 'credit_card',
                'title' => 'Enpara Kredi Kartı - Güncel Ekstre Borcu',
            ],
            [
                'merchant_name' => 'Enpara.com Kredi Kartı',
                'principal' => 120353.17,
                'remaining' => 120353.17,
                'interest_rate' => 3.75,
                'installment_amount' => 48142.00,
                'start_date' => '2026-08-02',
                'next_due_date' => '2026-08-12',
                'days_overdue' => 7,
                'status' => 'active',
                'notes' => 'Son Ekstre: ₺120.353,17 | Asgari: ₺48.142,00 | Güncel Dönem Borcu: ₺143.225,76 | 7 Gün Gecikmede',
            ]
        );

        // C) QNBpay / N0SH AUTO Motor Bedeli (3/8 Taksit)
        Debt::withoutGlobalScopes()->updateOrCreate(
            [
                'user_id' => $user->id,
                'bank_id' => $bank->id,
                'credit_card_id' => $card->id,
                'type' => 'credit_card',
                'merchant_name' => 'QNBpay / N0SH AUTO',
            ],
            [
                'title' => 'QNBpay / N0SH AUTO - Motor Bedeli (3/8 Taksit)',
                'principal' => 50000.00,
                'remaining' => 31250.00,
                'installment_count' => 8,
                'total_installments' => 8,
                'current_installment' => 3,
                'installment_amount' => 6250.00,
                'interest_rate' => 0.00,
                'transaction_date' => '2026-05-25',
                'start_date' => '2026-05-25',
                'next_due_date' => '2026-09-12',
                'days_overdue' => 0,
                'status' => 'active',
                'notes' => 'Toplam: ₺50.000,00 | Ödenen: ₺18.750,00 (3 Taksit) | Kalan: ₺31.250,00 (5 Taksit)',
            ]
        );

        // D) Zara Giyim Alışverişi (2/3 Taksit)
        Debt::withoutGlobalScopes()->updateOrCreate(
            [
                'user_id' => $user->id,
                'bank_id' => $bank->id,
                'credit_card_id' => $card->id,
                'type' => 'credit_card',
                'merchant_name' => 'ZARAGIYIMITHALATIHRACAT',
            ],
            [
                'title' => 'Zara Giyim Alışverişi (2/3 Taksit)',
                'principal' => 3039.00,
                'remaining' => 1013.00,
                'installment_count' => 3,
                'total_installments' => 3,
                'current_installment' => 2,
                'installment_amount' => 1013.00,
                'interest_rate' => 0.00,
                'transaction_date' => '2026-06-24',
                'start_date' => '2026-06-24',
                'next_due_date' => '2026-09-12',
                'days_overdue' => 0,
                'status' => 'active',
                'notes' => 'Toplam: ₺3.039,00 | Ödenen: ₺2.026,00 (2 Taksit) | Kalan: ₺1.013,00 (1 Taksit)',
            ]
        );

        // 4. Categories lookup
        $catGida = Category::where('name', 'Market & Gıda')->first()?->id ?? 3;
        $catUlasim = Category::where('name', 'Ulaşım & Akaryakıt')->first()?->id ?? Category::where('name', 'Ulaşım & Yakıt')->first()?->id ?? 4;
        $catRestoran = Category::where('name', 'Restoran & Yeme/İçme')->first()?->id ?? 16;
        $catAbonelik = Category::where('name', 'Abonelikler & Dijital')->first()?->id ?? 7;
        $catFatura = Category::where('name', 'Faturalar (Elektrik, Su, Doğalgaz)')->first()?->id ?? 2;
        $catGiyim = Category::where('name', 'Giyim & Alışveriş')->first()?->id ?? 22;
        $catTaksit = Category::where('name', 'Sigorta, Kasko & Taksitler')->first()?->id ?? 14;
        $catVergi = Category::where('name', 'Vergi & Resmi Harçlar')->first()?->id ?? 19;
        $catBanka = Category::where('name', 'Banka Faiz & Vergi Kesintileri')->first()?->id ?? 21;
        $catDiger = Category::where('name', 'Diğer Giderler')->first()?->id ?? 9;

        // 5. Incomes (Kampanya İadeleri)
        $incomes = [
            ['title' => 'Enpara Kampanya İadesi (Netflix, Spotify, Youtube)', 'amount' => 150.00, 'type' => 'other', 'frequency' => 'once', 'is_recurring' => false],
            ['title' => 'Enpara Kampanya İadesi (Masterpass Kahve)', 'amount' => 150.00, 'type' => 'other', 'frequency' => 'once', 'is_recurring' => false],
            ['title' => 'Enpara Kampanya İadesi (ChatGPT & Gemini)', 'amount' => 125.00, 'type' => 'other', 'frequency' => 'once', 'is_recurring' => false],
        ];

        foreach ($incomes as $inc) {
            Income::withoutGlobalScopes()->updateOrCreate(
                [
                    'user_id' => $user->id,
                    'title' => $inc['title'],
                ],
                $inc
            );
        }

        // 6. Expenses (Son Ekstre & Dönem İçi Harcamalar)
        $expenses = [
            ['title' => 'DOST PETROL SAN.VE T', 'amount' => 841.75, 'category_id' => $catUlasim, 'date' => '2026-07-02', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'GUNAYDIN ET KANYON', 'amount' => 921.00, 'category_id' => $catRestoran, 'date' => '2026-07-02', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'S/KARAYOLLARI GM.', 'amount' => 173.00, 'category_id' => $catUlasim, 'date' => '2026-07-03', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'KAHVEHANE SOSYAL TES', 'amount' => 240.00, 'category_id' => $catRestoran, 'date' => '2026-07-03', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'WWW.AVRASYATUNELI.COM', 'amount' => 546.00, 'category_id' => $catUlasim, 'date' => '2026-07-03', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'Q LOUNGE CAFE', 'amount' => 2000.00, 'category_id' => $catRestoran, 'date' => '2026-07-04', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'ÖDEAL//MOGAF', 'amount' => 415.00, 'category_id' => $catGida, 'date' => '2026-07-04', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'PAYCELL/FATURAODEMEMASTER', 'amount' => 200.00, 'category_id' => $catFatura, 'date' => '2026-07-04', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'VATAN BİLGİSAYAR (3/3 Taksit)', 'amount' => 2869.00, 'category_id' => $catGiyim, 'date' => '2026-07-04', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'PAYCELL/DO TALİMATLI MP', 'amount' => 1121.70, 'category_id' => $catFatura, 'date' => '2026-07-09', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'PAYCELL/FATURAODEMEMASTER', 'amount' => 250.00, 'category_id' => $catFatura, 'date' => '2026-07-09', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'PAYCELL/FATURAODEMEMASTER - 2', 'amount' => 250.00, 'category_id' => $catFatura, 'date' => '2026-07-09', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'Trendyol - Yemek', 'amount' => 459.89, 'category_id' => $catRestoran, 'date' => '2026-07-09', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'Trendyol - Yemek', 'amount' => 367.00, 'category_id' => $catRestoran, 'date' => '2026-07-10', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'S/KARAYOLLARI GM.', 'amount' => 40.00, 'category_id' => $catUlasim, 'date' => '2026-07-11', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'WWW.AVRASYATUNELI.COM', 'amount' => 257.40, 'category_id' => $catUlasim, 'date' => '2026-07-11', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'Netflix.com', 'amount' => 289.99, 'category_id' => $catAbonelik, 'date' => '2026-07-11', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'APPLE.COM/BILL', 'amount' => 129.99, 'category_id' => $catAbonelik, 'date' => '2026-07-11', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'APPLE.COM/BILL - 2', 'amount' => 249.99, 'category_id' => $catAbonelik, 'date' => '2026-07-11', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'Trendyol - Yemek', 'amount' => 504.99, 'category_id' => $catRestoran, 'date' => '2026-07-11', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'Trendyol - Yemek', 'amount' => 364.99, 'category_id' => $catRestoran, 'date' => '2026-07-11', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'Trendyol - Yemek', 'amount' => 305.81, 'category_id' => $catRestoran, 'date' => '2026-07-11', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'TOBACCO SHOP', 'amount' => 710.00, 'category_id' => $catDiger, 'date' => '2026-07-12', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'GITHUB, INC. (10 USD)', 'amount' => 478.35, 'category_id' => $catAbonelik, 'date' => '2026-07-12', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'IYZICO/amazon.com.tr', 'amount' => 150.00, 'category_id' => $catGiyim, 'date' => '2026-07-12', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'TRENDYOL.COM', 'amount' => 2484.85, 'category_id' => $catGiyim, 'date' => '2026-07-12', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'TRENDYOL.COM - 2', 'amount' => 437.56, 'category_id' => $catGiyim, 'date' => '2026-07-12', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'Trendyol - Yemek', 'amount' => 509.99, 'category_id' => $catRestoran, 'date' => '2026-07-12', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'Trendyol - Yemek', 'amount' => 349.98, 'category_id' => $catRestoran, 'date' => '2026-07-13', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'Trendyol - Yemek', 'amount' => 534.99, 'category_id' => $catRestoran, 'date' => '2026-07-13', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'ESPRESSOLAB', 'amount' => 501.00, 'category_id' => $catRestoran, 'date' => '2026-07-15', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'Trendyol - Yemek', 'amount' => 659.99, 'category_id' => $catRestoran, 'date' => '2026-07-15', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'Zekeriya Sarı', 'amount' => 300.00, 'category_id' => $catDiger, 'date' => '2026-07-18', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'GARENTA BAŞAKŞEHİR', 'amount' => 329.00, 'category_id' => $catUlasim, 'date' => '2026-07-18', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'IYZICO/AmazonPrimeTR', 'amount' => 69.90, 'category_id' => $catAbonelik, 'date' => '2026-07-18', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'OBİLET İSTANBUL', 'amount' => 3019.90, 'category_id' => $catUlasim, 'date' => '2026-07-18', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'MEHMET SIDDIK CIFTCI SAHI', 'amount' => 305.00, 'category_id' => $catRestoran, 'date' => '2026-07-19', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'HALKÖDE ÖD/POAŞ BAŞAKŞEHİR', 'amount' => 1346.64, 'category_id' => $catUlasim, 'date' => '2026-07-19', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'PETROL OFISI A.Ş.', 'amount' => 300.00, 'category_id' => $catUlasim, 'date' => '2026-07-19', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'GARENTA BAŞAKŞEHİR', 'amount' => 267.60, 'category_id' => $catUlasim, 'date' => '2026-07-19', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'GOOGLE *YouTubePremium', 'amount' => 119.99, 'category_id' => $catAbonelik, 'date' => '2026-07-19', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'Trendyol - Yemek', 'amount' => 379.99, 'category_id' => $catRestoran, 'date' => '2026-07-19', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'GARENTA BAŞAKŞEHİR', 'amount' => 244.20, 'category_id' => $catUlasim, 'date' => '2026-07-20', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'Trendyol - Yemek', 'amount' => 359.99, 'category_id' => $catRestoran, 'date' => '2026-07-22', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'Trendyol - Yemek', 'amount' => 865.00, 'category_id' => $catRestoran, 'date' => '2026-07-23', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'ZARA GİYİM (2/3 Taksit)', 'amount' => 1013.00, 'category_id' => $catGiyim, 'date' => '2026-07-24', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'Trendyol - Yemek', 'amount' => 464.89, 'category_id' => $catRestoran, 'date' => '2026-07-25', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'QNBpay / N0SH AUTO - Motor Bedeli (3/8 Taksit)', 'amount' => 6250.00, 'category_id' => $catTaksit, 'date' => '2026-07-25', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'Motorlu Taşıtlar Vergisi (MTV) Tahsilatı', 'amount' => 1107.00, 'category_id' => $catVergi, 'date' => '2026-07-27', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'TURK.NET İnternet Faturası', 'amount' => 949.90, 'category_id' => $catFatura, 'date' => '2026-07-28', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'SHELL ESENLER', 'amount' => 230.00, 'category_id' => $catUlasim, 'date' => '2026-07-29', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'SHELL ESENLER - 2', 'amount' => 689.58, 'category_id' => $catUlasim, 'date' => '2026-07-29', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'Trendyol - Yemek', 'amount' => 394.90, 'category_id' => $catRestoran, 'date' => '2026-07-29', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'S/ICA YSS 3 KÖPRÜ GEÇİŞİ', 'amount' => 144.00, 'category_id' => $catUlasim, 'date' => '2026-07-31', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'S/KARAYOLLARI GM.', 'amount' => 140.00, 'category_id' => $catUlasim, 'date' => '2026-07-31', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'Disney Plus Aboneliği', 'amount' => 449.90, 'category_id' => $catAbonelik, 'date' => '2026-07-31', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'Trendyol - Yemek', 'amount' => 344.00, 'category_id' => $catRestoran, 'date' => '2026-07-31', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'Avrupa Otoyolu Yatır', 'amount' => 40.00, 'category_id' => $catUlasim, 'date' => '2026-07-31', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'FİLE F103 DOĞANBEY BAĞCILAR', 'amount' => 2515.00, 'category_id' => $catGida, 'date' => '2026-08-01', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'GOOGLE *Google One Aboneliği', 'amount' => 1479.99, 'category_id' => $catAbonelik, 'date' => '2026-08-01', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'Trendyol - Yemek', 'amount' => 360.00, 'category_id' => $catRestoran, 'date' => '2026-08-01', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'Enpara Kredi Kartı Alışveriş Faizi', 'amount' => 2813.34, 'category_id' => $catBanka, 'date' => '2026-08-02', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'Enpara Kart Faiz KKDF Kesintisi', 'amount' => 422.00, 'category_id' => $catBanka, 'date' => '2026-08-02', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'Enpara Kart Faiz & Ücret BSMV Kesintisi', 'amount' => 422.00, 'category_id' => $catBanka, 'date' => '2026-08-02', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            
            // Ekpara Faizleri (Account - KMH)
            ['title' => 'Temmuz 2026 dönemi Ekpara kullanım faizi', 'amount' => 3125.43, 'category_id' => $catBanka, 'date' => '2026-08-03', 'method' => 'kmh', 'card' => null, 'acc' => $account->id],
            ['title' => 'Temmuz 2026 dönemi Ekpara kullanım faizi KKDF', 'amount' => 468.81, 'category_id' => $catBanka, 'date' => '2026-08-03', 'method' => 'kmh', 'card' => null, 'acc' => $account->id],
            ['title' => 'Temmuz 2026 dönemi Ekpara kullanım faizi BSMV', 'amount' => 468.81, 'category_id' => $catBanka, 'date' => '2026-08-03', 'method' => 'kmh', 'card' => null, 'acc' => $account->id],
        ];

        foreach ($expenses as $exp) {
            Expense::withoutGlobalScopes()->updateOrCreate(
                [
                    'user_id' => $user->id,
                    'title' => $exp['title'],
                    'expense_date' => $exp['date'],
                    'amount' => $exp['amount'],
                ],
                [
                    'category_id' => $exp['category_id'],
                    'credit_card_id' => $exp['card'],
                    'account_id' => $exp['acc'],
                    'payment_method' => $exp['method'],
                    'total_amount' => $exp['amount'],
                    'installment_count' => 1,
                    'current_installment' => 1,
                    'is_recurring' => false,
                ]
            );
        }

        echo "Enpara data successfully seeded for User ID: {$user->id}\n";
    }
}
