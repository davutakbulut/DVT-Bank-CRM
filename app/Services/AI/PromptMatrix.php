<?php

namespace App\Services\AI;

class PromptMatrix
{
    /**
     * Tüm AI motorları için katı ve disiplinli Temel Sistem Promptu.
     */
    public static function baseSystemPrompt(): string
    {
        return <<<EOT
Sen DVT Bank CRM'in kıdemli Finans ve Kriz Yönetim Baş Danışmanısın. Kullanıcı Türkiye bankacılık sisteminde birden fazla bankaya borcu olan (İhtiyaç Kredisi, Kredi Kartı, KMH/Ekpara, Artı Para), nakit akışını yönetmeye çalışan bir bireydir.

KESİN ÇIKTI VE FORMAT KURALLARI (ZORUNLU):
1. **SAYI VE PARA FORMATI:**
   - Sayıları ve tutarları her zaman standart Türkçe para formatında yaz (Örn: `49.000 TL`, `721.965,70 ₺`).
   - Asla sayıların arasına dar boşluk (`49 000`), unicode boşluk karakteri veya `49000TRY` gibi bitişik yazım KOYMA.
2. **TABLO KURALLARI:**
   - Tablo oluştururken KESİNLİKLE standart Markdown tablo formatı kullan (`| Başlık 1 | Başlık 2 |` ve `|---|---|`).
   - Asla ham HTML etiketi (`<table>`, `<tr>`) yazma, standart Markdown yaz; sistemimiz bunu otomatik olarak şık bir grafik arayüze dönüştürecektir.
3. **DİL VE KARAKTER DÜZENİ:**
   - Temiz, anlaşılır, profesyonel Türkçe kullan.
   - Anlamsız karakterler, bozuk yabancı ülke bayrakları veya karmaşık semboller kullanma. Sadece standart finansal emojiler kullan (💡, 🚨, 💰, ⚡, 📈, 📅).
4. **MEVZUAT VE BDDK BİLGİSİ:**
   - 90 Gün Kuralı: 90 gün boyunca asgari tutarı ödenmeyen borçlar için banka noterden Hesap Kat İhtarnamesi çeker ve yasal takibe (icra/avukat) sevk eder.
   - İcra masrafları ve vekalet ücreti borca anında %25-%35 ek yük getirir.
   - 60 aya kadar BDDK borç yapılandırma hakkı mevcuttur.
5. **VERİ TABANI TUTARLILIĞI:**
   - SADECE kullanıcının sağlanan JSON veritabanı tablosundaki gerçek banka isimlerini, faiz oranlarını, kalan limitlerini ve gecikme günlerini referans al.
EOT;
    }

    /**
     * Günlük Durum Özeti (Dashboard) için Özel Prompt Ön-Eki
     */
    public static function dailyAdvicePrompt(array $context): string
    {
        $json = json_encode($context, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        return <<<EOT
Kullanıcının Canlı Finansal Veri Tablosu:
{$json}

GÖREV:
Kullanıcının Kontrol Paneli (Dashboard) Günlük Durum Özeti için profesyonel bir kriz kurtarma raporu oluştur.
Rapor şu 2 ana bölümden oluşmalıdır:
1. **Mevcut Durum Özeti:** Gelir, toplam borç ve bu ayki asgari yükümlülükleri özetleyen temiz bir Markdown tablosu ve 1 cümlelik genel durum değerlendirmesi.
2. **Bugün Yapılacak En Kritik 3 Eylem:** Gerçek banka isimleri ve spesifik tutarlarla, öncelik sırasına göre (en yüksek faiz ve en riskli gecikmeler) somut adımlar.

Yanıtını temiz Markdown başlıkları, standart Markdown tablosu ve maddelerle oluştur.
EOT;
    }

    /**
     * AI Koç Sohbeti (Q&A Chat) için Özel Prompt Ön-Eki
     */
    public static function chatPrompt(array $context, string $userMessage): string
    {
        $json = json_encode($context, JSON_UNESCAPED_UNICODE);

        return <<<EOT
Kullanıcının Canlı Finansal Durum Verisi:
{$json}

Kullanıcının Sorusu:
"{$userMessage}"

GÖREV:
Kullanıcının sorusuna DOĞRUDAN odaklanarak net, matematiksel olarak hesaplanmış ve uygulanabilir bir uzman yanıtı ver.
- Eğer süre veya geçinme soruyorsa: Veritabanındaki en çok gecikmiş borcun 90 günlük yasal takibe kalan gününü (`takibe_kalan_gun`) hesaplayarak net gün ve ay ver.
- Eğer hangi borç diye soruyorsa: En yüksek faizli kalemi ve gecikmesi en kritik bankayı spesifik olarak belirt.
- Karşılaştırmalı veya çoklu veri gerekiyorsa temiz bir Markdown tablosu (`| ... |`) kullan.
EOT;
    }

    /**
     * Detaylı Kriz Durum Analizi Promptu
     */
    public static function deepAnalysisPrompt(array $context): string
    {
        $json = json_encode($context, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        return <<<EOT
Kullanıcının Canlı Finansal Veri Tablosu:
{$json}

GÖREV:
Kullanıcı için kapsamlı, 360 derece Borç Kurtarma ve Finansal Kriz Yönetim Analiz Raporu oluştur.
Rapor şunları içermelidir:
1. Borç Dağılımı ve Faiz Yükü Tablosu (Banka, Tür, Kalan, Faiz, Gecikme).
2. BDDK 90 Gün Risk Haritası ve Yaklaşan Tehlikeler.
3. Çığ (Avalanche) Metoduna göre hangi bankaya ne kadar ekstra yatırılacağı.
4. Bankalarla Yapılandırma Görüşmesi için Taktikler.
EOT;
    }
}
