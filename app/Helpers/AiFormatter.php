<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class AiFormatter
{
    /**
     * AI'dan gelen ham Markdown metnini temizler, sanitize eder ve zengin HTML'e çevirir.
     */
    public static function format(?string $content, bool $stripDisclaimer = false): string
    {
        if (empty($content)) {
            return '';
        }

        // 1. Unicode & Bozuk Karakter Temizliği
        $cleaned = self::cleanUnicodeAndGlitches($content);

        // 2. Mükerrer Yasal Uyarıları Temizle (Gerekirse)
        if ($stripDisclaimer) {
            $cleaned = preg_replace('/⚖️\s*\*?Bu\s+içerik\s+bilgilendirme.*?değildir\.?\*?/is', '', $cleaned);
            $cleaned = preg_replace('/⚖️\s*\*?Bu\s+öneriler\s+bilgilendirme.*?değildir\.?\*?/is', '', $cleaned);
            $cleaned = preg_replace('/⚖️\s*\*?Bu\s+sistem\s+bilgilendirme.*?değildir\.?\*?/is', '', $cleaned);
        }

        // 3. GitHub Flavored Markdown (Tablolar, listeler, kalın yazılar dahil)
        $html = Str::markdown($cleaned, [
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);

        return trim($html);
    }

    /**
     * Unicode dar boşlukları, anlamsız karakterleri ve bozuk sayı formatlarını düzeltir.
     */
    public static function cleanUnicodeAndGlitches(string $text): string
    {
        // 1. Dar boşluk (Narrow No-Break Space U+202F, Non-Breaking Space U+00A0, Zero Width U+200B)
        $text = str_replace(
            ["\u{202F}", "\u{00A0}", "\u{200B}", "\u{FEFF}", "\u{200E}", "\u{200F}"],
            ' ',
            $text
        );

        // 2. Sayı formatı düzeltmeleri: 49 000 veya 49000TRY -> 49.000 TL
        $text = preg_replace('/(\d+)\s+(\d{3})/u', '$1.$2', $text); // 49 000 -> 49.000
        $text = preg_replace('/(\d+)\s*TRY\b/ui', '$1 TL', $text); // 5000TRY -> 5000 TL

        // 3. Garip bayrak ve bozuk harf emojilerini temizle
        $text = preg_replace('/[\x{1F1E6}-\x{1F1FF}]{2}/u', '', $text); // Yabancı bayrak kodları

        // 4. Fazla boş satırları toparla
        $text = preg_replace("/\n{3,}/", "\n\n", $text);

        return $text;
    }
}
