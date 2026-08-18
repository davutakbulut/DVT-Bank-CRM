<?php

namespace App\Services\AI;

class FallbackEngine
{
    /**
     * AI sağlayıcıları kullanılamadığında deterministik kural tabanlı öneri üretir.
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
