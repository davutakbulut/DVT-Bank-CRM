<?php

namespace App\Services\AI;

class FallbackEngine
{
    /**
     * Kullanıcının sorduğu soruya göre akıllı ve hesaplamalı offline yanıt üretir.
     */
    public function generateChatResponse(array $context, string $userMessage): string
    {
        $lowerMsg = mb_strtolower($userMessage);
        $toplamBorc = number_format($context['toplam_borc'] ?? 0, 2, ',', '.');
        $aylikYuk = number_format($context['bu_ay_yukumluluk'] ?? 0, 2, ',', '.');
        $aylikGelir = number_format($context['aylik_gelir'] ?? 0, 2, ',', '.');
        $borclar = $context['borclar'] ?? [];

        // 1. Durum: "Kaç ay geçinebilirim / ödemeden dayanabilirim"
        if (str_contains($lowerMsg, 'kaç ay') || str_contains($lowerMsg, 'ödemeden') || str_contains($lowerMsg, 'geçin') || str_contains($lowerMsg, 'dayan')) {
            // En çok geciken borcu bul
            $maxOverdue = 0;
            $mostCriticalDebt = null;
            foreach ($borclar as $b) {
                if (($b['gun_gecikmede'] ?? 0) > $maxOverdue) {
                    $maxOverdue = $b['gun_gecikmede'];
                    $mostCriticalDebt = $b;
                }
            }

            $minDaysLeft = 90 - $maxOverdue;
            $critBank = $mostCriticalDebt ? "{$mostCriticalDebt['banka']} ({$mostCriticalDebt['baslik']})" : 'En çok geciken borcunuz';

            $out = "### ⏱️ Borç Ödemeden Geçinme & Yasal Takip Süresi Analizi\n\n";
            $out .= "Mevcut verilerinize göre bankalara **hiçbir ödeme yapmadan** yasal takibe (icra/avukat) girmeden geçinebileceğiniz süre **en fazla ~" . max(10, $minDaysLeft) . " gün (yaklaşık " . round($minDaysLeft / 30, 1) . " ay)** seviyesindedir.\n\n";
            $out .= "#### 🔍 Neden Bu Süre?\n";
            $out .= "- **BDDK 90 Gün Kuralı:** Türkiye'de bir kredi veya kredi kartı borcu 90 gün boyunca asgari tutarda dahi ödenmezse banka noterden Hesap Kat İhtarnamesi gönderir ve dosyayı icraya devreder.\n";
            if ($mostCriticalDebt && $maxOverdue > 0) {
                $out .= "- **Mevcut En Riskli Borcunuz:** `{$critBank}` borcunuz zaten **{$maxOverdue} gündür gecikmededir**. Bu borcun 90. güne ulaşmasına yalnızca **{$minDaysLeft} gün** kalmıştır.\n";
            }
            $out .= "\n#### 🚨 Hiç Ödeme Yapmazsanız Ne Olur?\n";
            $out .= "1. **1-30 Gün İçinde:** Kartlarınız ve KMH limitleriniz kullanıma kapatılır, kredi notunuz düşer.\n";
            $out .= "2. **30-60 Gün İçinde:** İdari takip aramaları sıklaşır; hesabınıza yatan maaş/nakitler KMH eksi bakiyelerini kapatmak için otomatik kesilebilir.\n";
            $out .= "3. **90. Günde:** Banka avukatları devreye girer. ₺{$toplamBorc} tutarındaki borcunuza yaklaşık **%25-%35 icra/vekalet masrafı** eklenir ve maaşınızın 1/4'üne haciz başlatılabilir.\n\n";
            $out .= "#### 💡 En Akıllı Kurtarma Hamlesi:\n";
            $out .= "- **Zaman Satın Alın:** En riskli borcunuzun asgari veya kısmi tutarını ödeyerek 90 günlük sayacı sıfırlayın.\n";
            $out .= "- **60 Ay Yapılandırma:** Aylık ₺{$aylikYuk} tutarındaki yükümlülüğünüzü bankalarla görüşüp 60 aya yayarak aylık ~25.000-30.000 TL bandına çekin.";

            return $out;
        }

        // 2. Durum: "Hangi borcu önce kapatayım / ödeyeyim"
        if (str_contains($lowerMsg, 'hangi') || str_contains($lowerMsg, 'önce') || str_contains($lowerMsg, 'kapat')) {
            $enYuksekFaiz = $context['en_yuksek_faizli'] ?? 'En yüksek faizli KMH/Kart';
            $out = "### 🎯 Stratejik Borç Kapatma Sıralaması (Çığ Metodu)\n\n";
            $out .= "Toplam borcunuz **₺{$toplamBorc}** olup matematiksel olarak en az faiz ödeyerek kurtulmak için izlemeniz gereken rota şudur:\n\n";
            $out .= "1. **Öncelik (En Yüksek Faiz):** `{$enYuksekFaiz}` borcunuza asgarinin üzerinde tüm fazla bütçeyi yatırın.\n";
            $out .= "2. **Diğer Tüm Borçlar:** Sadece asgari tutarlarını ödeyerek gecikme faizi ve takibi engelleyin.\n";
            $out .= "3. **Kartopu Etkisi:** En yüksek faizli borç bittiğinde oradan boşa çıkan bütçeyi ikinci sıradaki borca aktarın.";
            return $out;
        }

        // Genel Fallback
        return $this->generateAdvice($context);
    }

    /**
     * AI sağlayıcıları kullanılamadığında deterministik kural tabanlı genel tavsiye üretir.
     */
    public function generateAdvice(array $context): string
    {
        $toplamBorc = number_format($context['toplam_borc'] ?? 0, 2, ',', '.');
        $aylikYuk = number_format($context['bu_ay_yukumluluk'] ?? 0, 2, ',', '.');
        $enYuksekFaiz = $context['en_yuksek_faizli'] ?? 'KMH / Kredi Kartı';
        $legalRisks = $context['yasal_takip_riski'] ?? [];

        $markdown = "### 🛡️ Kural Tabanlı Finansal Kurtarma Raporu\n\n";
        $markdown .= "Mevcut kayıtlı toplam borcunuz **₺{$toplamBorc}**, bu ayki asgari/taksit yükümlülüğünüz ise **₺{$aylikYuk}** seviyesindedir.\n\n";

        $markdown .= "#### ⚡ Bugün Yapılacak 3 Kritik Hamle:\n";

        if (!empty($legalRisks)) {
            $firstRisk = $legalRisks[0];
            $markdown .= "1. **🚨 ACİL YASAL TAKİP UYARISI:** `{$firstRisk['banka']}` borcunuz {$firstRisk['gecikme']} gündür gecikmede olup 90 günlük yasal takibe yalnızca **{$firstRisk['kalan_gun']} gün** kalmıştır. Bugün derhal ilgili bankanın yapılandırma servisi aranmalıdır.\n";
        } else {
            $markdown .= "1. **En Yüksek Faizli Borca Odaklanın:** En yüksek maliyetli borcunuz olan `{$enYuksekFaiz}` için asgari tutarın üzerinde ek ödeme yaparak faiz kartopunu durdurun.\n";
        }

        $markdown .= "2. **KMH ve Kart Yapılandırması Talep Edin:** Bankanızdan kredili mevduat (ek para) ve kart dönem borçlarınızı 36-60 ay vadeli taksitli ihtiyaç kredisine dönüştürmesini (borç transferi) talep edin.\n";
        $markdown .= "3. **Asgari Ödeme Köprüsü:** Nakit akışınız sıkıştığında asgari ödemeleri borcu büyütmeden takibi durdurucu bir tampon olarak kullanın; ana hedef yapılandırma olmalıdır.\n\n";

        $markdown .= "> 💡 **Not:** Planlı ve disiplinli adımlarla her ay en yüksek faizli kalemi eriterek borç sarmalından güvenle çıkabilirsiniz.";

        return $markdown;
    }
}
