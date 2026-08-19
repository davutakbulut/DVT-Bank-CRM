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
use Illuminate\Support\Facades\DB;

class EnparaAccurateSyncSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'dvtakblt@gmail.com')->first() ?? User::find(2);
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
                'notes' => 'Kullanılan Ekpara: ₺77.118,64 / Limit: ₺84.500,00 | Aylık Faiz: %4,25',
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

        // C) QNBpay / N0SH AUTO Motor Bedeli
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

        // D) Zara Giyim Alışverişi
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

        // Clean existing Enpara specific expenses and incomes to avoid duplication
        Expense::withoutGlobalScopes()
            ->where('user_id', $user->id)
            ->where(function($q) use ($card, $account) {
                $q->where('credit_card_id', $card->id)
                  ->orWhere('account_id', $account->id);
            })->forceDelete();

        Income::withoutGlobalScopes()
            ->where('user_id', $user->id)
            ->where('title', 'like', '%Enpara%')
            ->orWhere('title', 'like', '%Melih Günal%')
            ->orWhere('title', 'like', '%Mustafa Beyazyüz%')
            ->orWhere('title', 'like', '%Sayit Sayıcı%')
            ->orWhere('title', 'like', '%Batuhan Sağlam%')
            ->orWhere('title', 'like', '%Yasin Can Gör%')
            ->orWhere('title', 'like', '%Mücahit Kara%')
            ->orWhere('title', 'like', '%Meral Yılmaz%')
            ->forceDelete();

        // Kategori Eşleştirmeleri
        $catGida = Category::where('name', 'Market & Gıda')->first()?->id ?? 3;
        $catUlasim = Category::where('name', 'Ulaşım & Akaryakıt')->first()?->id ?? Category::where('name', 'Ulaşım & Yakıt')->first()?->id ?? 4;
        $catRestoran = Category::where('name', 'Restoran & Yeme/İçme')->first()?->id ?? 16;
        $catAbonelik = Category::where('name', 'Abonelikler & Dijital')->first()?->id ?? 7;
        $catFatura = Category::where('name', 'Faturalar (Elektrik, Su, Doğalgaz)')->first()?->id ?? 2;
        $catGiyim = Category::where('name', 'Giyim & Alışveriş')->first()?->id ?? 22;
        $catTaksit = Category::where('name', 'Sigorta, Kasko & Taksitler')->first()?->id ?? 14;
        $catVergi = Category::where('name', 'Vergi & Resmi Harçlar')->first()?->id ?? 19;
        $catBanka = Category::where('name', 'Banka Faiz & Vergi Kesintileri')->first()?->id ?? 21;
        $catSaglik = Category::where('name', 'Sağlık & Eczane')->first()?->id ?? Category::where('name', 'Sağlık & İlaç')->first()?->id ?? 5;
        $catDiger = Category::where('name', 'Diğer Giderler')->first()?->id ?? 9;

        // ==========================================
        // 1. GELİRLER (PDF Sayfa 1-7 Arası Tüm Gelen Transferler & İadeler)
        // ==========================================
        $incomesData = [
            // Kampanya İadeleri
            ['title' => 'Enpara Kampanya İadesi (Netflix, Spotify, Youtube)', 'amount' => 150.00, 'type' => 'other', 'frequency' => 'once', 'created_at' => '2026-08-04'],
            ['title' => 'Enpara Kampanya İadesi (Masterpass Kahve)', 'amount' => 150.00, 'type' => 'other', 'frequency' => 'once', 'created_at' => '2026-08-04'],
            ['title' => 'Enpara Kampanya İadesi (ChatGPT & Gemini)', 'amount' => 125.00, 'type' => 'other', 'frequency' => 'once', 'created_at' => '2026-08-04'],
            ['title' => 'Enpara Kampanya İadesi (Netflix, Spotify, Youtube - Mart)', 'amount' => 40.00, 'type' => 'other', 'frequency' => 'once', 'created_at' => '2026-03-04'],

            // Dış Transfer Girişleri (Hakedişler ve Ödemeler)
            ['title' => 'Mustafa Beyazyüz - Gelen Transfer', 'amount' => 800.00, 'type' => 'other', 'frequency' => 'once', 'created_at' => '2026-08-17'],
            ['title' => 'Osman Gül - Gelen Transfer', 'amount' => 400.00, 'type' => 'other', 'frequency' => 'once', 'created_at' => '2026-08-11'],
            ['title' => 'Osman Gül - Gelen Transfer', 'amount' => 1000.00, 'type' => 'other', 'frequency' => 'once', 'created_at' => '2026-08-11'],
            ['title' => 'Aytuğ Atabek - Gelen Transfer', 'amount' => 1800.00, 'type' => 'other', 'frequency' => 'once', 'created_at' => '2026-07-22'],
            ['title' => 'Metehan Yeşiltepe - Gelen Transfer', 'amount' => 300.00, 'type' => 'other', 'frequency' => 'once', 'created_at' => '2026-07-22'],
            ['title' => 'Mücahit Abdullah Tepeyurt - Gelen Transfer', 'amount' => 5000.00, 'type' => 'other', 'frequency' => 'once', 'created_at' => '2026-07-16'],
            ['title' => 'Dilan Göçer - Gelen Transfer', 'amount' => 3000.00, 'type' => 'other', 'frequency' => 'once', 'created_at' => '2026-07-15'],
            ['title' => 'Şerife Demirci - Gelen Transfer', 'amount' => 5170.00, 'type' => 'other', 'frequency' => 'once', 'created_at' => '2026-07-14'],
            ['title' => 'Necdet Kılıç - Gelen Transfer', 'amount' => 1930.00, 'type' => 'other', 'frequency' => 'once', 'created_at' => '2026-07-13'],
            ['title' => 'Mert Can - Gelen Transfer', 'amount' => 3300.00, 'type' => 'other', 'frequency' => 'once', 'created_at' => '2026-07-13'],
            ['title' => 'Berkay Gavaz - Gelen Transfer', 'amount' => 410.00, 'type' => 'other', 'frequency' => 'once', 'created_at' => '2026-07-04'],
            ['title' => 'Yasin Can Gör - Gelen Transfer', 'amount' => 500.00, 'type' => 'other', 'frequency' => 'once', 'created_at' => '2026-07-04'],
            ['title' => 'Songül Yalun - Gelen Transfer', 'amount' => 2500.00, 'type' => 'other', 'frequency' => 'once', 'created_at' => '2026-07-01'],
            ['title' => 'Orhan Saruhan - Gelen Transfer', 'amount' => 2250.00, 'type' => 'other', 'frequency' => 'once', 'created_at' => '2026-06-26'],
            ['title' => 'Erk Bahadır Amaç - Gelen Transfer', 'amount' => 2500.00, 'type' => 'other', 'frequency' => 'once', 'created_at' => '2026-06-09'],
            ['title' => 'Şehriban Baykal - Gelen Transfer', 'amount' => 600.00, 'type' => 'other', 'frequency' => 'once', 'created_at' => '2026-06-09'],
            ['title' => 'Şeref Sinir - Gelen Transfer', 'amount' => 7300.00, 'type' => 'other', 'frequency' => 'once', 'created_at' => '2026-06-03'],
            ['title' => 'Mücahit Kara - Gelen Transfer', 'amount' => 50000.00, 'type' => 'other', 'frequency' => 'once', 'created_at' => '2026-06-01'],
            ['title' => 'Emre Akbulut - Gelen Transfer', 'amount' => 10000.00, 'type' => 'other', 'frequency' => 'once', 'created_at' => '2026-05-29'],
            ['title' => 'Gülcan Çürüksulu - Gelen Transfer', 'amount' => 12750.00, 'type' => 'other', 'frequency' => 'once', 'created_at' => '2026-05-26'],
            ['title' => 'Altan Demirel - Gelen Transfer', 'amount' => 7029.00, 'type' => 'other', 'frequency' => 'once', 'created_at' => '2026-05-25'],
            ['title' => 'Esra Kan - Gelen Transfer', 'amount' => 8000.00, 'type' => 'other', 'frequency' => 'once', 'created_at' => '2026-05-25'],
            ['title' => 'Sayit Sayıcı - Gelen Transfer', 'amount' => 100000.00, 'type' => 'other', 'frequency' => 'once', 'created_at' => '2026-05-25'],
            ['title' => 'Yasin Can Gör - Gelen Transfer', 'amount' => 50000.00, 'type' => 'other', 'frequency' => 'once', 'created_at' => '2026-05-25'],
            ['title' => 'Didem Öçal Türkyılmaz - Gelen Transfer', 'amount' => 8000.00, 'type' => 'other', 'frequency' => 'once', 'created_at' => '2026-05-22'],
            ['title' => 'Furkan Karakuş - Gelen Transfer', 'amount' => 5000.00, 'type' => 'other', 'frequency' => 'once', 'created_at' => '2026-05-18'],
            ['title' => 'Altan Demirel - Gelen Transfer', 'amount' => 4910.00, 'type' => 'other', 'frequency' => 'once', 'created_at' => '2026-05-12'],
            ['title' => 'Mert Can - Gelen Transfer', 'amount' => 5500.00, 'type' => 'other', 'frequency' => 'once', 'created_at' => '2026-05-08'],
            ['title' => 'Mustafa Beyazyüz - Gelen Transfer', 'amount' => 30000.00, 'type' => 'other', 'frequency' => 'once', 'created_at' => '2026-05-04'],
            ['title' => 'Halide Doğan Arslan - Gelen Transfer', 'amount' => 3000.00, 'type' => 'other', 'frequency' => 'once', 'created_at' => '2026-04-23'],
            ['title' => 'Layal Choukeifeh - Gelen Transfer', 'amount' => 17500.00, 'type' => 'other', 'frequency' => 'once', 'created_at' => '2026-04-20'],
            ['title' => 'Adil Çelikbaş - Gelen Transfer', 'amount' => 15000.00, 'type' => 'other', 'frequency' => 'once', 'created_at' => '2026-04-20'],
            ['title' => 'Arda Aydın - Gelen Transfer', 'amount' => 2600.00, 'type' => 'other', 'frequency' => 'once', 'created_at' => '2026-04-18'],
            ['title' => 'Yakup Altan - Gelen Transfer', 'amount' => 1500.00, 'type' => 'other', 'frequency' => 'once', 'created_at' => '2026-04-18'],
            ['title' => 'Batuhan Sağlam - Gelen Transfer', 'amount' => 7500.00, 'type' => 'other', 'frequency' => 'once', 'created_at' => '2026-04-18'],
            ['title' => 'İlhan Demirtaş - Gelen Transfer', 'amount' => 13000.00, 'type' => 'other', 'frequency' => 'once', 'created_at' => '2026-04-18'],
            ['title' => 'Batuhan Sağlam - Gelen Transfer', 'amount' => 57500.00, 'type' => 'other', 'frequency' => 'once', 'created_at' => '2026-04-17'],
            ['title' => 'Mustafa Beyazyüz - Gelen Transfer', 'amount' => 100000.00, 'type' => 'other', 'frequency' => 'once', 'created_at' => '2026-04-01'],
            ['title' => 'Melih Günal - Hakediş Geliri', 'amount' => 50000.00, 'type' => 'freelance', 'frequency' => 'once', 'created_at' => '2026-03-23'],
            ['title' => 'Orhan Saruhan - Gelen Transfer', 'amount' => 1500.00, 'type' => 'other', 'frequency' => 'once', 'created_at' => '2026-02-28'],
            ['title' => 'Kübra Söylemez - Gelen Transfer', 'amount' => 15000.00, 'type' => 'other', 'frequency' => 'once', 'created_at' => '2026-02-23'],
            ['title' => 'Meral Yılmaz - Gelen Transfer', 'amount' => 6000.00, 'type' => 'other', 'frequency' => 'once', 'created_at' => '2026-02-23'],
            ['title' => 'Melih Günal - Hakediş Geliri', 'amount' => 50000.00, 'type' => 'freelance', 'frequency' => 'once', 'created_at' => '2026-02-16'],
            ['title' => 'Remzi Volkan Sözüçok - Gelen Transfer', 'amount' => 2800.00, 'type' => 'other', 'frequency' => 'once', 'created_at' => '2026-02-13'],
            ['title' => 'Kübra Söylemez - Gelen Transfer', 'amount' => 3000.00, 'type' => 'other', 'frequency' => 'once', 'created_at' => '2026-02-12'],
            ['title' => 'Berat Caner Köroğlu - Gelen Transfer', 'amount' => 500.00, 'type' => 'other', 'frequency' => 'once', 'created_at' => '2026-01-19'],
            ['title' => 'Berkay Gavaz - Gelen Transfer', 'amount' => 900.00, 'type' => 'other', 'frequency' => 'once', 'created_at' => '2026-01-18'],
            ['title' => 'Melih Günal - Hakediş Geliri', 'amount' => 32315.00, 'type' => 'freelance', 'frequency' => 'once', 'created_at' => '2026-01-13'],
            ['title' => 'Meral Yılmaz - Gelen Transfer', 'amount' => 850.00, 'type' => 'other', 'frequency' => 'once', 'created_at' => '2026-01-11'],
            ['title' => 'Meral Yılmaz - Gelen Transfer', 'amount' => 5000.00, 'type' => 'other', 'frequency' => 'once', 'created_at' => '2026-01-03'],
            ['title' => 'Meral Yılmaz - Gelen Transfer', 'amount' => 8700.00, 'type' => 'other', 'frequency' => 'once', 'created_at' => '2025-12-08'],
            ['title' => 'Melih Günal - Tedo Transfer', 'amount' => 2000.00, 'type' => 'other', 'frequency' => 'once', 'created_at' => '2025-12-07'],
            ['title' => 'Seçkin Türkmen Diş Hekimi - Gelen Transfer', 'amount' => 15000.00, 'type' => 'other', 'frequency' => 'once', 'created_at' => '2025-12-04'],
            ['title' => 'Melih Günal - Transfer Girişi', 'amount' => 29720.00, 'type' => 'other', 'frequency' => 'once', 'created_at' => '2025-12-03'],
            ['title' => 'Meral Yılmaz - Gelen Transfer', 'amount' => 27000.00, 'type' => 'other', 'frequency' => 'once', 'created_at' => '2025-11-21'],
        ];

        foreach ($incomesData as $inc) {
            Income::withoutGlobalScopes()->create([
                'user_id' => $user->id,
                'title' => $inc['title'],
                'amount' => $inc['amount'],
                'type' => $inc['type'],
                'frequency' => $inc['frequency'],
                'is_recurring' => false,
                'created_at' => $inc['created_at'],
                'updated_at' => $inc['created_at'],
            ]);
        }

        // ==========================================
        // 2. GİDERLER (Vadesiz TL Ekpara & Kredi Kartı Ekstreleri)
        // ==========================================
        $expensesData = [
            // --- VADESİZ TL / EKPARA DÖKÜMÜNDEN ÇIKAN NET GİDERLER ---
            ['title' => 'Nuri Aydoğan - Bireysel Ödeme (FAST)', 'amount' => 1600.00, 'cat' => $catDiger, 'date' => '2026-08-16', 'acc' => $account->id, 'card' => null, 'method' => 'bank_account'],
            ['title' => 'Ömer Faruk Tercüman - Transfer', 'amount' => 1700.00, 'cat' => $catDiger, 'date' => '2026-08-16', 'acc' => $account->id, 'card' => null, 'method' => 'bank_account'],
            ['title' => 'Yasin Can Gör - Transfer (FAST)', 'amount' => 58950.00, 'cat' => $catDiger, 'date' => '2026-08-15', 'acc' => $account->id, 'card' => null, 'method' => 'bank_account'],
            ['title' => 'QNB ATM - Nakit Para Çekme', 'amount' => 3000.00, 'cat' => $catDiger, 'date' => '2026-08-14', 'acc' => $account->id, 'card' => null, 'method' => 'bank_account'],
            ['title' => 'Yılmaz Günay - Bireysel Ödeme (FAST)', 'amount' => 1000.00, 'cat' => $catDiger, 'date' => '2026-08-14', 'acc' => $account->id, 'card' => null, 'method' => 'bank_account'],
            ['title' => 'QNB ATM - Nakit Para Çekme', 'amount' => 2800.00, 'cat' => $catDiger, 'date' => '2026-08-12', 'acc' => $account->id, 'card' => null, 'method' => 'bank_account'],
            ['title' => 'QNB ATM - Nakit Para Çekme', 'amount' => 1200.00, 'cat' => $catDiger, 'date' => '2026-08-11', 'acc' => $account->id, 'card' => null, 'method' => 'bank_account'],
            ['title' => 'Temmuz 2026 dönemi Ekpara kullanım faizi BSMV', 'amount' => 468.81, 'cat' => $catBanka, 'date' => '2026-08-03', 'acc' => $account->id, 'card' => null, 'method' => 'kmh'],
            ['title' => 'Temmuz 2026 dönemi Ekpara kullanım faizi KKDF', 'amount' => 468.81, 'cat' => $catBanka, 'date' => '2026-08-03', 'acc' => $account->id, 'card' => null, 'method' => 'kmh'],
            ['title' => 'Temmuz 2026 dönemi Ekpara kullanım faizi', 'amount' => 3125.43, 'cat' => $catBanka, 'date' => '2026-08-03', 'acc' => $account->id, 'card' => null, 'method' => 'kmh'],
            ['title' => 'Yılmaz Günay - Bireysel Ödeme (FAST)', 'amount' => 850.00, 'cat' => $catDiger, 'date' => '2026-08-01', 'acc' => $account->id, 'card' => null, 'method' => 'bank_account'],
            ['title' => 'Sercan Yalçın - Bireysel Ödeme (FAST)', 'amount' => 1000.00, 'cat' => $catDiger, 'date' => '2026-07-31', 'acc' => $account->id, 'card' => null, 'method' => 'bank_account'],
            ['title' => 'Melih Günal - Bireysel Ödeme (FAST)', 'amount' => 4910.00, 'cat' => $catDiger, 'date' => '2026-07-20', 'acc' => $account->id, 'card' => null, 'method' => 'bank_account'],
            ['title' => 'Haziran 2026 dönemi Ekpara kullanım faizi BSMV', 'amount' => 314.91, 'cat' => $catBanka, 'date' => '2026-07-01', 'acc' => $account->id, 'card' => null, 'method' => 'kmh'],
            ['title' => 'Haziran 2026 dönemi Ekpara kullanım faizi KKDF', 'amount' => 314.91, 'cat' => $catBanka, 'date' => '2026-07-01', 'acc' => $account->id, 'card' => null, 'method' => 'kmh'],
            ['title' => 'Haziran 2026 dönemi Ekpara kullanım faizi', 'amount' => 2099.38, 'cat' => $catBanka, 'date' => '2026-07-01', 'acc' => $account->id, 'card' => null, 'method' => 'kmh'],
            ['title' => 'Amjad Alnomary - Bireysel Ödeme (FAST)', 'amount' => 18820.00, 'cat' => $catDiger, 'date' => '2026-06-30', 'acc' => $account->id, 'card' => null, 'method' => 'bank_account'],
            ['title' => 'Melih Günal - Bireysel Ödeme (FAST)', 'amount' => 2500.00, 'cat' => $catDiger, 'date' => '2026-06-30', 'acc' => $account->id, 'card' => null, 'method' => 'bank_account'],
            ['title' => 'QNB ATM - Nakit Para Çekme', 'amount' => 5000.00, 'cat' => $catDiger, 'date' => '2026-06-21', 'acc' => $account->id, 'card' => null, 'method' => 'bank_account'],
            ['title' => 'Emre Akbulut - Bireysel Ödeme (FAST)', 'amount' => 3000.00, 'cat' => $catDiger, 'date' => '2026-06-17', 'acc' => $account->id, 'card' => null, 'method' => 'bank_account'],
            ['title' => 'Mücahit Kara - Bireysel Ödeme (FAST)', 'amount' => 25000.00, 'cat' => $catDiger, 'date' => '2026-06-16', 'acc' => $account->id, 'card' => null, 'method' => 'bank_account'],
            ['title' => 'Mayıs 2026 dönemi Ekpara kullanım faizi BSMV', 'amount' => 212.32, 'cat' => $catBanka, 'date' => '2026-06-01', 'acc' => $account->id, 'card' => null, 'method' => 'kmh'],
            ['title' => 'Mayıs 2026 dönemi Ekpara kullanım faizi KKDF', 'amount' => 212.32, 'cat' => $catBanka, 'date' => '2026-06-01', 'acc' => $account->id, 'card' => null, 'method' => 'kmh'],
            ['title' => 'Mayıs 2026 dönemi Ekpara kullanım faizi', 'amount' => 1415.46, 'cat' => $catBanka, 'date' => '2026-06-01', 'acc' => $account->id, 'card' => null, 'method' => 'kmh'],
            ['title' => 'Yakup Sevim - Transfer (FAST)', 'amount' => 1000.00, 'cat' => $catDiger, 'date' => '2026-05-26', 'acc' => $account->id, 'card' => null, 'method' => 'bank_account'],
            ['title' => 'Yakup Sevim - Transfer (FAST)', 'amount' => 24500.00, 'cat' => $catDiger, 'date' => '2026-05-26', 'acc' => $account->id, 'card' => null, 'method' => 'bank_account'],
            ['title' => 'Yakup Sevim - Transfer (FAST)', 'amount' => 5000.00, 'cat' => $catDiger, 'date' => '2026-05-26', 'acc' => $account->id, 'card' => null, 'method' => 'bank_account'],
            ['title' => 'Gökhan Yanar - Transfer (FAST)', 'amount' => 7029.00, 'cat' => $catDiger, 'date' => '2026-05-25', 'acc' => $account->id, 'card' => null, 'method' => 'bank_account'],
            ['title' => 'Serdar Tekin - Transfer', 'amount' => 400.00, 'cat' => $catDiger, 'date' => '2026-05-25', 'acc' => $account->id, 'card' => null, 'method' => 'bank_account'],
            ['title' => 'NİSH AUTO - ADV 350 MOTOR PEŞİNATI', 'amount' => 348000.00, 'cat' => $catTaksit, 'date' => '2026-05-25', 'acc' => $account->id, 'card' => null, 'method' => 'bank_account'],
            ['title' => 'Furkan Karakuş - Transfer (FAST)', 'amount' => 100.00, 'cat' => $catDiger, 'date' => '2026-05-22', 'acc' => $account->id, 'card' => null, 'method' => 'bank_account'],
            ['title' => 'Zemhanur Akbulut - Transfer (FAST)', 'amount' => 1000.00, 'cat' => $catDiger, 'date' => '2026-05-22', 'acc' => $account->id, 'card' => null, 'method' => 'bank_account'],
            ['title' => 'Cafer Yıldızhan - Transfer (FAST)', 'amount' => 250.00, 'cat' => $catDiger, 'date' => '2026-05-21', 'acc' => $account->id, 'card' => null, 'method' => 'bank_account'],
            ['title' => 'Muhammed Kuş - Transfer (FAST)', 'amount' => 750.00, 'cat' => $catDiger, 'date' => '2026-05-15', 'acc' => $account->id, 'card' => null, 'method' => 'bank_account'],
            ['title' => 'Zekeriya Sarı - Transfer', 'amount' => 1500.00, 'cat' => $catDiger, 'date' => '2026-05-12', 'acc' => $account->id, 'card' => null, 'method' => 'bank_account'],
            ['title' => 'Emre Akbulut - Transfer (FAST)', 'amount' => 20000.00, 'cat' => $catDiger, 'date' => '2026-05-12', 'acc' => $account->id, 'card' => null, 'method' => 'bank_account'],
            ['title' => 'Yuşa Arif Kabaca - Transfer (FAST)', 'amount' => 2000.00, 'cat' => $catDiger, 'date' => '2026-05-08', 'acc' => $account->id, 'card' => null, 'method' => 'bank_account'],
            ['title' => 'Gökhan Yanar - Transfer (FAST)', 'amount' => 17500.00, 'cat' => $catDiger, 'date' => '2026-05-07', 'acc' => $account->id, 'card' => null, 'method' => 'bank_account'],
            ['title' => 'Nisan 2026 dönemi Ekpara faizi BSMV', 'amount' => 197.23, 'cat' => $catBanka, 'date' => '2026-05-04', 'acc' => $account->id, 'card' => null, 'method' => 'kmh'],
            ['title' => 'Nisan 2026 dönemi Ekpara faizi KKDF', 'amount' => 197.23, 'cat' => $catBanka, 'date' => '2026-05-04', 'acc' => $account->id, 'card' => null, 'method' => 'kmh'],
            ['title' => 'Nisan 2026 dönemi Ekpara kullanım faizi', 'amount' => 1314.86, 'cat' => $catBanka, 'date' => '2026-05-04', 'acc' => $account->id, 'card' => null, 'method' => 'kmh'],
            ['title' => 'Mert Can - Transfer (FAST)', 'amount' => 5000.00, 'cat' => $catDiger, 'date' => '2026-04-29', 'acc' => $account->id, 'card' => null, 'method' => 'bank_account'],
            ['title' => 'Mehmet Emin Ekinci - Transfer (FAST)', 'amount' => 450.00, 'cat' => $catDiger, 'date' => '2026-04-28', 'acc' => $account->id, 'card' => null, 'method' => 'bank_account'],
            ['title' => 'İbrahim Görgöz - Transfer (FAST)', 'amount' => 250.00, 'cat' => $catDiger, 'date' => '2026-04-26', 'acc' => $account->id, 'card' => null, 'method' => 'bank_account'],
            ['title' => 'Emre İlhan - Transfer (FAST)', 'amount' => 3000.00, 'cat' => $catDiger, 'date' => '2026-04-24', 'acc' => $account->id, 'card' => null, 'method' => 'bank_account'],
            ['title' => 'Yılmaz Günay - Transfer (FAST)', 'amount' => 800.00, 'cat' => $catDiger, 'date' => '2026-04-21', 'acc' => $account->id, 'card' => null, 'method' => 'bank_account'],
            ['title' => 'Gökhan Yanar - Transfer (FAST)', 'amount' => 82100.00, 'cat' => $catDiger, 'date' => '2026-04-18', 'acc' => $account->id, 'card' => null, 'method' => 'bank_account'],
            ['title' => 'Harun Özdemir - Transfer (FAST)', 'amount' => 655.00, 'cat' => $catDiger, 'date' => '2026-04-16', 'acc' => $account->id, 'card' => null, 'method' => 'bank_account'],
            ['title' => 'Kerem Toprak - Transfer (FAST)', 'amount' => 405.00, 'cat' => $catDiger, 'date' => '2026-04-15', 'acc' => $account->id, 'card' => null, 'method' => 'bank_account'],
            ['title' => 'Mehmet Yusuf Kaya - Transfer (FAST)', 'amount' => 3500.00, 'cat' => $catDiger, 'date' => '2026-04-15', 'acc' => $account->id, 'card' => null, 'method' => 'bank_account'],
            ['title' => 'Kenan Şeker - Transfer (FAST)', 'amount' => 300.00, 'cat' => $catDiger, 'date' => '2026-04-15', 'acc' => $account->id, 'card' => null, 'method' => 'bank_account'],
            ['title' => 'Kenan Şeker - Transfer (FAST)', 'amount' => 500.00, 'cat' => $catDiger, 'date' => '2026-04-15', 'acc' => $account->id, 'card' => null, 'method' => 'bank_account'],
            ['title' => 'Kenan Şeker - Transfer (FAST)', 'amount' => 600.00, 'cat' => $catDiger, 'date' => '2026-04-15', 'acc' => $account->id, 'card' => null, 'method' => 'bank_account'],
            ['title' => 'Kenan Şeker - Transfer (FAST)', 'amount' => 665.00, 'cat' => $catDiger, 'date' => '2026-04-15', 'acc' => $account->id, 'card' => null, 'method' => 'bank_account'],
            ['title' => 'Amjad Alnomary - Transfer (FAST)', 'amount' => 9900.00, 'cat' => $catDiger, 'date' => '2026-04-14', 'acc' => $account->id, 'card' => null, 'method' => 'bank_account'],
            ['title' => 'Mart 2026 dönemi Ekpara faizi BSMV', 'amount' => 263.20, 'cat' => $catBanka, 'date' => '2026-04-01', 'acc' => $account->id, 'card' => null, 'method' => 'kmh'],
            ['title' => 'Mart 2026 dönemi Ekpara faizi KKDF', 'amount' => 263.20, 'cat' => $catBanka, 'date' => '2026-04-01', 'acc' => $account->id, 'card' => null, 'method' => 'kmh'],
            ['title' => 'Mart 2026 dönemi Ekpara kullanım faizi', 'amount' => 1754.67, 'cat' => $catBanka, 'date' => '2026-04-01', 'acc' => $account->id, 'card' => null, 'method' => 'kmh'],

            // --- KREDİ KARTI EKSTRELERİNDEN ÇIKAN NET HARCAMALAR ---
            // Ağustos 2026 Ekstresi
            ['title' => 'DOST PETROL SAN.VE T', 'amount' => 841.75, 'cat' => $catUlasim, 'date' => '2026-07-02', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'GUNAYDIN ET KANYON', 'amount' => 921.00, 'cat' => $catRestoran, 'date' => '2026-07-02', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'S/KARAYOLLARI GM.', 'amount' => 173.00, 'cat' => $catUlasim, 'date' => '2026-07-03', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'KAHVEHANE SOSYAL TES', 'amount' => 240.00, 'cat' => $catRestoran, 'date' => '2026-07-03', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'WWW.AVRASYATUNELI.COM', 'amount' => 546.00, 'cat' => $catUlasim, 'date' => '2026-07-03', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'Q LOUNGE CAFE', 'amount' => 2000.00, 'cat' => $catRestoran, 'date' => '2026-07-04', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'ÖDEAL//MOGAF', 'amount' => 415.00, 'cat' => $catGida, 'date' => '2026-07-04', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'PAYCELL/FATURAODEMEMASTER', 'amount' => 200.00, 'cat' => $catFatura, 'date' => '2026-07-04', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'VATAN BİLGİSAYAR (3/3 Taksit)', 'amount' => 2869.00, 'cat' => $catGiyim, 'date' => '2026-07-04', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'PAYCELL/DO TALİMATLI MP', 'amount' => 1121.70, 'cat' => $catFatura, 'date' => '2026-07-09', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'PAYCELL/FATURAODEMEMASTER', 'amount' => 250.00, 'cat' => $catFatura, 'date' => '2026-07-09', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'PAYCELL/FATURAODEMEMASTER - 2', 'amount' => 250.00, 'cat' => $catFatura, 'date' => '2026-07-09', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'Trendyol - Yemek', 'amount' => 459.89, 'cat' => $catRestoran, 'date' => '2026-07-09', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'Trendyol - Yemek', 'amount' => 367.00, 'cat' => $catRestoran, 'date' => '2026-07-10', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'S/KARAYOLLARI GM.', 'amount' => 40.00, 'cat' => $catUlasim, 'date' => '2026-07-11', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'WWW.AVRASYATUNELI.COM', 'amount' => 257.40, 'cat' => $catUlasim, 'date' => '2026-07-11', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'Netflix.com', 'amount' => 289.99, 'cat' => $catAbonelik, 'date' => '2026-07-11', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'APPLE.COM/BILL', 'amount' => 129.99, 'cat' => $catAbonelik, 'date' => '2026-07-11', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'APPLE.COM/BILL - 2', 'amount' => 249.99, 'cat' => $catAbonelik, 'date' => '2026-07-11', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'Trendyol - Yemek', 'amount' => 504.99, 'cat' => $catRestoran, 'date' => '2026-07-11', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'Trendyol - Yemek', 'amount' => 364.99, 'cat' => $catRestoran, 'date' => '2026-07-11', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'Trendyol - Yemek', 'amount' => 305.81, 'cat' => $catRestoran, 'date' => '2026-07-11', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'TOBACCO SHOP', 'amount' => 710.00, 'cat' => $catDiger, 'date' => '2026-07-12', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'GITHUB, INC. (10 USD)', 'amount' => 478.35, 'cat' => $catAbonelik, 'date' => '2026-07-12', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'IYZICO/amazon.com.tr', 'amount' => 150.00, 'cat' => $catGiyim, 'date' => '2026-07-12', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'TRENDYOL.COM', 'amount' => 2484.85, 'cat' => $catGiyim, 'date' => '2026-07-12', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'TRENDYOL.COM - 2', 'amount' => 437.56, 'cat' => $catGiyim, 'date' => '2026-07-12', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'Trendyol - Yemek', 'amount' => 509.99, 'cat' => $catRestoran, 'date' => '2026-07-12', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'Trendyol - Yemek', 'amount' => 349.98, 'cat' => $catRestoran, 'date' => '2026-07-13', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'Trendyol - Yemek', 'amount' => 534.99, 'cat' => $catRestoran, 'date' => '2026-07-13', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'ESPRESSOLAB', 'amount' => 501.00, 'cat' => $catRestoran, 'date' => '2026-07-15', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'Trendyol - Yemek', 'amount' => 659.99, 'cat' => $catRestoran, 'date' => '2026-07-15', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'Zekeriya Sarı', 'amount' => 300.00, 'cat' => $catDiger, 'date' => '2026-07-18', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'GARENTA BAŞAKŞEHİR', 'amount' => 329.00, 'cat' => $catUlasim, 'date' => '2026-07-18', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'IYZICO/AmazonPrimeTR', 'amount' => 69.90, 'cat' => $catAbonelik, 'date' => '2026-07-18', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'OBİLET İSTANBUL', 'amount' => 3019.90, 'cat' => $catUlasim, 'date' => '2026-07-18', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'MEHMET SIDDIK CIFTCI SAHI', 'amount' => 305.00, 'cat' => $catRestoran, 'date' => '2026-07-19', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'HALKÖDE ÖD/POAŞ BAŞAKŞEHİR', 'amount' => 1346.64, 'cat' => $catUlasim, 'date' => '2026-07-19', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'PETROL OFISI A.Ş.', 'amount' => 300.00, 'cat' => $catUlasim, 'date' => '2026-07-19', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'GARENTA BAŞAKŞEHİR', 'amount' => 267.60, 'cat' => $catUlasim, 'date' => '2026-07-19', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'GOOGLE *YouTubePremium', 'amount' => 119.99, 'cat' => $catAbonelik, 'date' => '2026-07-19', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'Trendyol - Yemek', 'amount' => 379.99, 'cat' => $catRestoran, 'date' => '2026-07-19', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'GARENTA BAŞAKŞEHİR', 'amount' => 244.20, 'cat' => $catUlasim, 'date' => '2026-07-20', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'Trendyol - Yemek', 'amount' => 359.99, 'cat' => $catRestoran, 'date' => '2026-07-22', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'Trendyol - Yemek', 'amount' => 865.00, 'cat' => $catRestoran, 'date' => '2026-07-23', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'ZARA GİYİM (2/3 Taksit)', 'amount' => 1013.00, 'cat' => $catGiyim, 'date' => '2026-07-24', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'Trendyol - Yemek', 'amount' => 464.89, 'cat' => $catRestoran, 'date' => '2026-07-25', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'QNBpay / N0SH AUTO - Motor Bedeli (3/8 Taksit)', 'amount' => 6250.00, 'cat' => $catTaksit, 'date' => '2026-07-25', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'Motorlu Taşıtlar Vergisi (MTV) Tahsilatı', 'amount' => 1107.00, 'cat' => $catVergi, 'date' => '2026-07-27', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'TURK.NET İnternet Faturası', 'amount' => 949.90, 'cat' => $catFatura, 'date' => '2026-07-28', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'SHELL ESENLER', 'amount' => 230.00, 'cat' => $catUlasim, 'date' => '2026-07-29', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'SHELL ESENLER - 2', 'amount' => 689.58, 'cat' => $catUlasim, 'date' => '2026-07-29', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'Trendyol - Yemek', 'amount' => 394.90, 'cat' => $catRestoran, 'date' => '2026-07-29', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'S/ICA YSS 3 KÖPRÜ GEÇİŞİ', 'amount' => 144.00, 'cat' => $catUlasim, 'date' => '2026-07-31', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'S/KARAYOLLARI GM.', 'amount' => 140.00, 'cat' => $catUlasim, 'date' => '2026-07-31', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'Disney Plus Aboneliği', 'amount' => 449.90, 'cat' => $catAbonelik, 'date' => '2026-07-31', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'Trendyol - Yemek', 'amount' => 344.00, 'cat' => $catRestoran, 'date' => '2026-07-31', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'Avrupa Otoyolu Yatır', 'amount' => 40.00, 'cat' => $catUlasim, 'date' => '2026-07-31', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'FİLE F103 DOĞANBEY BAĞCILAR', 'amount' => 2515.00, 'cat' => $catGida, 'date' => '2026-08-01', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'GOOGLE *Google One Aboneliği', 'amount' => 1479.99, 'cat' => $catAbonelik, 'date' => '2026-08-01', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'Trendyol - Yemek', 'amount' => 360.00, 'cat' => $catRestoran, 'date' => '2026-08-01', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'Enpara Kredi Kartı Alışveriş Faizi', 'amount' => 2813.34, 'cat' => $catBanka, 'date' => '2026-08-02', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'Enpara Kart Faiz KKDF Kesintisi', 'amount' => 422.00, 'cat' => $catBanka, 'date' => '2026-08-02', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'Enpara Kart Faiz & Ücret BSMV Kesintisi', 'amount' => 422.00, 'cat' => $catBanka, 'date' => '2026-08-02', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],

            // Temmuz 2026 Ekstresi
            ['title' => 'AIRBNB KONAKLAMA (103 USD)', 'amount' => 4834.77, 'cat' => $catUlasim, 'date' => '2026-06-06', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'OBİLET SEYAHAT', 'amount' => 3884.10, 'cat' => $catUlasim, 'date' => '2026-06-06', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'SHELL OTOGAR İSTANBUL', 'amount' => 1500.00, 'cat' => $catUlasim, 'date' => '2026-06-06', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'SALTBAE GALATAPORT', 'amount' => 1380.00, 'cat' => $catRestoran, 'date' => '2026-06-21', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'TRENDYOL.COM ALIŞVERİŞ', 'amount' => 1814.59, 'cat' => $catGiyim, 'date' => '2026-06-02', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'IYZICO/AMAZON.COM.TR', 'amount' => 1079.21, 'cat' => $catGiyim, 'date' => '2026-06-02', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'HEPSİBURADA ALIŞVERİŞ', 'amount' => 861.00, 'cat' => $catGiyim, 'date' => '2026-06-02', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'ÇİÇEKSEPETİ ALIŞVERİŞ', 'amount' => 779.99, 'cat' => $catDiger, 'date' => '2026-06-13', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'DAGYOLU PETROL AKARYAKIT', 'amount' => 700.02, 'cat' => $catUlasim, 'date' => '2026-06-23', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'YUCEL ANASAL ÇİKOLATA', 'amount' => 690.00, 'cat' => $catGida, 'date' => '2026-06-23', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'ZARA GİYİM (1/3 Taksit)', 'amount' => 1013.00, 'cat' => $catGiyim, 'date' => '2026-06-24', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'QNBpay / N0SH AUTO - Motor Bedeli (2/8 Taksit)', 'amount' => 6250.00, 'cat' => $catTaksit, 'date' => '2026-06-25', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'VATAN BİLGİSAYAR (2/3 Taksit)', 'amount' => 2869.00, 'cat' => $catGiyim, 'date' => '2026-06-04', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'Alışveriş Faizi (Temmuz Ekstresi)', 'amount' => 2428.60, 'cat' => $catBanka, 'date' => '2026-07-02', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'Faizlerin KKDF\'si (Temmuz Ekstresi)', 'amount' => 364.29, 'cat' => $catBanka, 'date' => '2026-07-02', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'Faiz ve Ücretlerin BSMV\'si (Temmuz Ekstresi)', 'amount' => 364.29, 'cat' => $catBanka, 'date' => '2026-07-02', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],

            // Haziran 2026 Ekstresi
            ['title' => 'DECATHLON MAĞAZASI', 'amount' => 5955.00, 'cat' => $catGiyim, 'date' => '2026-05-03', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'DECATHLON BAYRAMPAŞA', 'amount' => 1545.00, 'cat' => $catGiyim, 'date' => '2026-05-25', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'TRENDYOL.COM ALIŞVERİŞ', 'amount' => 3088.80, 'cat' => $catGiyim, 'date' => '2026-05-03', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'QUICK SİGORTA KASKO/POLİÇE', 'amount' => 7300.32, 'cat' => $catTaksit, 'date' => '2026-05-25', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'BAKIRKÖY 12. NOTERLİĞİ İŞLEM BEDELİ', 'amount' => 3064.10, 'cat' => $catVergi, 'date' => '2026-05-25', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'BAKIRKÖY 12. NOTERLİĞİ HARÇ BEDELİ', 'amount' => 2968.10, 'cat' => $catVergi, 'date' => '2026-05-25', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'ELMAS DENT DİŞ TEDAVİSİ', 'amount' => 3000.00, 'cat' => $catSaglik, 'date' => '2026-05-22', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'YAKUP SEVİM HİZMET BEDELİ', 'amount' => 10750.00, 'cat' => $catDiger, 'date' => '2026-05-26', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'VATAN BİLGİSAYAR (1/3 Taksit)', 'amount' => 2869.00, 'cat' => $catGiyim, 'date' => '2026-05-04', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'QNBpay / N0SH AUTO - Motor Bedeli (1/8 Taksit)', 'amount' => 6250.00, 'cat' => $catTaksit, 'date' => '2026-05-25', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],

            // Mayıs 2026 Ekstresi
            ['title' => 'BEZMİALEM VAKIF ÜNİ. TIP FAKÜLTESİ', 'amount' => 5200.00, 'cat' => $catSaglik, 'date' => '2026-04-13', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'BEZMİALEM VAKIF ÜNİ. TIP FAKÜLTESİ - 2', 'amount' => 4500.00, 'cat' => $catSaglik, 'date' => '2026-04-13', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'MAVİ JEANS (3/3 Taksit)', 'amount' => 718.30, 'cat' => $catGiyim, 'date' => '2026-04-15', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'LİTTLE CAESARS PİZZA', 'amount' => 2000.00, 'cat' => $catRestoran, 'date' => '2026-04-18', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'LİTTLE CAESARS PİZZA - 2', 'amount' => 2000.00, 'cat' => $catRestoran, 'date' => '2026-04-18', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'LİTTLE CAESARS PİZZA - 3', 'amount' => 2000.00, 'cat' => $catRestoran, 'date' => '2026-04-18', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'LİTTLE CAESARS PİZZA - 4', 'amount' => 400.00, 'cat' => $catRestoran, 'date' => '2026-04-18', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'IYZICO/AMAZON.COM.TR', 'amount' => 1416.00, 'cat' => $catGiyim, 'date' => '2026-04-12', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'OBİLET İSTANBUL SEYAHAT', 'amount' => 3740.61, 'cat' => $catUlasim, 'date' => '2026-04-05', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'OBİLET İSTANBUL SEYAHAT - 2', 'amount' => 2291.17, 'cat' => $catUlasim, 'date' => '2026-04-30', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'BORAKAY SMASH BURGER', 'amount' => 1120.00, 'cat' => $catRestoran, 'date' => '2026-04-05', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
            ['title' => 'MERTER MERKEZ KÖFTE', 'amount' => 1695.00, 'cat' => $catRestoran, 'date' => '2026-04-14', 'acc' => null, 'card' => $card->id, 'method' => 'credit_card'],
        ];

        foreach ($expensesData as $exp) {
            Expense::withoutGlobalScopes()->create([
                'user_id' => $user->id,
                'category_id' => $exp['cat'],
                'credit_card_id' => $exp['card'],
                'account_id' => $exp['acc'],
                'payment_method' => $exp['method'],
                'title' => $exp['title'],
                'amount' => $exp['amount'],
                'total_amount' => $exp['amount'],
                'installment_count' => 1,
                'current_installment' => 1,
                'expense_date' => $exp['date'],
                'is_recurring' => false,
                'created_at' => $exp['date'] . ' 12:00:00',
                'updated_at' => $exp['date'] . ' 12:00:00',
            ]);
        }

        echo "Enpara accurate synchronization completed! Incomes: " . count($incomesData) . ", Expenses: " . count($expensesData) . "\n";
    }
}
