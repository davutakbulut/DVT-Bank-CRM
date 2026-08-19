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

class EnparaFullHistorySeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'dvtakblt@gmail.com')->first() ?? User::find(2);
        if (!$user) {
            echo "User not found!\n";
            return;
        }

        $bank = Bank::where('name', 'Enpara.com')->first();
        $account = Account::withoutGlobalScopes()->where('user_id', $user->id)->where('bank_id', $bank->id)->first();
        $card = CreditCard::withoutGlobalScopes()->where('user_id', $user->id)->where('bank_id', $bank->id)->first();

        // Kategori ID'leri
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
        $catEgitim = Category::where('name', 'Eğitim & Spor')->first()?->id ?? Category::where('name', 'Eğitim & Çocuk')->first()?->id ?? 6;
        $catDiger = Category::where('name', 'Diğer Giderler')->first()?->id ?? 9;

        // GELİRLER (Hakedişler, İadeler ve Düzenli Girişler)
        $incomes = [
            ['title' => 'Melih Günal - Hakediş Geliri (Mart)', 'amount' => 50000.00, 'type' => 'freelance', 'frequency' => 'monthly', 'is_recurring' => true],
            ['title' => 'Melih Günal - Hakediş Geliri (Şubat)', 'amount' => 50000.00, 'type' => 'freelance', 'frequency' => 'monthly', 'is_recurring' => true],
            ['title' => 'Mücahit Kara - Transfer Girişi', 'amount' => 50000.00, 'type' => 'other', 'frequency' => 'once', 'is_recurring' => false],
            ['title' => 'Mustafa Beyazyüz - Transfer Girişi', 'amount' => 100000.00, 'type' => 'other', 'frequency' => 'once', 'is_recurring' => false],
            ['title' => 'Sayit Sayıcı - Transfer Girişi', 'amount' => 100000.00, 'type' => 'other', 'frequency' => 'once', 'is_recurring' => false],
            ['title' => 'Yasin Can Gör - Transfer Girişi', 'amount' => 50000.00, 'type' => 'other', 'frequency' => 'once', 'is_recurring' => false],
            ['title' => 'Batuhan Sağlam - Transfer Girişi', 'amount' => 57500.00, 'type' => 'other', 'frequency' => 'once', 'is_recurring' => false],
            ['title' => 'Meral Yılmaz - Transfer Girişi', 'amount' => 27000.00, 'type' => 'other', 'frequency' => 'once', 'is_recurring' => false],
        ];

        foreach ($incomes as $inc) {
            Income::withoutGlobalScopes()->updateOrCreate(
                ['user_id' => $user->id, 'title' => $inc['title']],
                $inc
            );
        }

        // GEÇMİŞ DÖNEM TÜM EKSTRE HARCAMALARI & EKPARA İŞLEMLERİ (6 Aylık Tam Döküm)
        $historicalExpenses = [
            // --- MAYIS 2026 EKSTRESİ & DÖNEMİ ---
            ['title' => 'BEZMİALEM VAKIF ÜNİ. TIP FAKÜLTESİ', 'amount' => 5200.00, 'category_id' => $catSaglik, 'date' => '2026-04-13', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'BEZMİALEM VAKIF ÜNİ. TIP FAKÜLTESİ - 2', 'amount' => 4500.00, 'category_id' => $catSaglik, 'date' => '2026-04-13', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'MAVİ JEANS (3/3 Taksit - Bitti)', 'amount' => 718.30, 'category_id' => $catGiyim, 'date' => '2026-04-15', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'LİTTLE CAESARS PİZZA', 'amount' => 2000.00, 'category_id' => $catRestoran, 'date' => '2026-04-18', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'LİTTLE CAESARS PİZZA - 2', 'amount' => 2000.00, 'category_id' => $catRestoran, 'date' => '2026-04-18', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'LİTTLE CAESARS PİZZA - 3', 'amount' => 2000.00, 'category_id' => $catRestoran, 'date' => '2026-04-18', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'LİTTLE CAESARS PİZZA - 4', 'amount' => 400.00, 'category_id' => $catRestoran, 'date' => '2026-04-18', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'IYZICO/AMAZON.COM.TR', 'amount' => 1416.00, 'category_id' => $catGiyim, 'date' => '2026-04-12', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'OBİLET İSTANBUL SEYAHAT', 'amount' => 3740.61, 'category_id' => $catUlasim, 'date' => '2026-04-05', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'OBİLET İSTANBUL SEYAHAT - 2', 'amount' => 2291.17, 'category_id' => $catUlasim, 'date' => '2026-04-30', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'BORAKAY SMASH BURGER', 'amount' => 1120.00, 'category_id' => $catRestoran, 'date' => '2026-04-05', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'MERTER MERKEZ KÖFTE', 'amount' => 1695.00, 'category_id' => $catRestoran, 'date' => '2026-04-14', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'HALKÖDE POAŞ AKARYAKIT', 'amount' => 1564.00, 'category_id' => $catUlasim, 'date' => '2026-04-22', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'HALKÖDE POAŞ AKARYAKIT - 2', 'amount' => 1600.00, 'category_id' => $catUlasim, 'date' => '2026-04-30', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'POAŞ BAŞAK PETROL', 'amount' => 1203.84, 'category_id' => $catUlasim, 'date' => '2026-04-27', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'SURNAME RESTORAN', 'amount' => 1410.00, 'category_id' => $catRestoran, 'date' => '2026-05-01', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'Nisan 2026 dönemi Ekpara kullanım faizi', 'amount' => 1314.86, 'category_id' => $catBanka, 'date' => '2026-05-04', 'method' => 'kmh', 'card' => null, 'acc' => $account->id],
            ['title' => 'Nisan 2026 dönemi Ekpara faizi KKDF', 'amount' => 197.23, 'category_id' => $catBanka, 'date' => '2026-05-04', 'method' => 'kmh', 'card' => null, 'acc' => $account->id],
            ['title' => 'Nisan 2026 dönemi Ekpara faizi BSMV', 'amount' => 197.23, 'category_id' => $catBanka, 'date' => '2026-05-04', 'method' => 'kmh', 'card' => null, 'acc' => $account->id],

            // --- HAZİRAN 2026 EKSTRESİ & DÖNEMİ ---
            ['title' => 'DECATHLON MAĞAZASI', 'amount' => 5955.00, 'category_id' => $catGiyim, 'date' => '2026-05-03', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'DECATHLON BAYRAMPAŞA', 'amount' => 1545.00, 'category_id' => $catGiyim, 'date' => '2026-05-25', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'TRENDYOL.COM ALIŞVERİŞ', 'amount' => 3088.80, 'category_id' => $catGiyim, 'date' => '2026-05-03', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'TRENDYOL.COM ALIŞVERİŞ - 2', 'amount' => 1229.40, 'category_id' => $catGiyim, 'date' => '2026-05-02', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'SURNAME RESTORAN', 'amount' => 1470.00, 'category_id' => $catRestoran, 'date' => '2026-05-09', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'SURNAME RESTORAN - 2', 'amount' => 1490.00, 'category_id' => $catRestoran, 'date' => '2026-05-19', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'OBİLET SEYAHAT BİLETİ', 'amount' => 1860.42, 'category_id' => $catUlasim, 'date' => '2026-05-10', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'KAMPET PETROL AKARYAKIT', 'amount' => 1745.79, 'category_id' => $catUlasim, 'date' => '2026-05-15', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'OPET KAMPET PETROL', 'amount' => 1050.00, 'category_id' => $catUlasim, 'date' => '2026-05-15', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'QUICK SİGORTA KASKO/POLİÇE', 'amount' => 7300.32, 'category_id' => $catTaksit, 'date' => '2026-05-25', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'BAKIRKÖY 12. NOTERLİĞİ İŞLEM BEDELİ', 'amount' => 3064.10, 'category_id' => $catVergi, 'date' => '2026-05-25', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'BAKIRKÖY 12. NOTERLİĞİ HARÇ BEDELİ', 'amount' => 2968.10, 'category_id' => $catVergi, 'date' => '2026-05-25', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'ELMAS DENT DİŞ TEDAVİSİ', 'amount' => 3000.00, 'category_id' => $catSaglik, 'date' => '2026-05-22', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'YAKUP SEVİM HİZMET BEDELİ', 'amount' => 10750.00, 'category_id' => $catDiger, 'date' => '2026-05-26', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'Mayıs 2026 dönemi Ekpara kullanım faizi', 'amount' => 1415.46, 'category_id' => $catBanka, 'date' => '2026-06-01', 'method' => 'kmh', 'card' => null, 'acc' => $account->id],
            ['title' => 'Mayıs 2026 dönemi Ekpara faizi KKDF', 'amount' => 212.32, 'category_id' => $catBanka, 'date' => '2026-06-01', 'method' => 'kmh', 'card' => null, 'acc' => $account->id],
            ['title' => 'Mayıs 2026 dönemi Ekpara faizi BSMV', 'amount' => 212.32, 'category_id' => $catBanka, 'date' => '2026-06-01', 'method' => 'kmh', 'card' => null, 'acc' => $account->id],

            // --- TEMMUZ 2026 EKSTRESİ & DÖNEMİ ---
            ['title' => 'AIRBNB KONAKLAMA (103 USD)', 'amount' => 4834.77, 'category_id' => $catUlasim, 'date' => '2026-06-06', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'OBİLET SEYAHAT', 'amount' => 3884.10, 'category_id' => $catUlasim, 'date' => '2026-06-06', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'SHELL OTOGAR İSTANBUL', 'amount' => 1500.00, 'category_id' => $catUlasim, 'date' => '2026-06-06', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'SALTBAE GALATAPORT', 'amount' => 1380.00, 'category_id' => $catRestoran, 'date' => '2026-06-21', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'TRENDYOL.COM ALIŞVERİŞ', 'amount' => 1814.59, 'category_id' => $catGiyim, 'date' => '2026-06-02', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'IYZICO/AMAZON.COM.TR', 'amount' => 1079.21, 'category_id' => $catGiyim, 'date' => '2026-06-02', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'HEPSİBURADA ALIŞVERİŞ', 'amount' => 861.00, 'category_id' => $catGiyim, 'date' => '2026-06-02', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'ÇİÇEKSEPETİ ALIŞVERİŞ', 'amount' => 779.99, 'category_id' => $catDiger, 'date' => '2026-06-13', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'DAGYOLU PETROL AKARYAKIT', 'amount' => 700.02, 'category_id' => $catUlasim, 'date' => '2026-06-23', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'YUCEL ANASAL ÇİKOLATA', 'amount' => 690.00, 'category_id' => $catGida, 'date' => '2026-06-23', 'method' => 'credit_card', 'card' => $card->id, 'acc' => null],
            ['title' => 'Haziran 2026 dönemi Ekpara kullanım faizi', 'amount' => 2099.38, 'category_id' => $catBanka, 'date' => '2026-07-01', 'method' => 'kmh', 'card' => null, 'acc' => $account->id],
            ['title' => 'Haziran 2026 dönemi Ekpara faizi KKDF', 'amount' => 314.91, 'category_id' => $catBanka, 'date' => '2026-07-01', 'method' => 'kmh', 'card' => null, 'acc' => $account->id],
            ['title' => 'Haziran 2026 dönemi Ekpara faizi BSMV', 'amount' => 314.91, 'category_id' => $catBanka, 'date' => '2026-07-01', 'method' => 'kmh', 'card' => null, 'acc' => $account->id],

            // --- VADESİZ TL BÜYÜK FAST / MOTOR PEŞİNATI ---
            ['title' => 'NİSH AUTO - ADV 350 MOTOR PEŞİNATI', 'amount' => 348000.00, 'category_id' => $catTaksit, 'date' => '2026-05-25', 'method' => 'bank_account', 'card' => null, 'acc' => $account->id],
        ];

        foreach ($historicalExpenses as $exp) {
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

        echo "Enpara full 6-month history successfully seeded! Total records processed.\n";
    }
}
