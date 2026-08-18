<?php

namespace App\Services;

use App\Models\Bank;
use App\Models\Category;
use Carbon\Carbon;

class NaturalLanguageTransactionParser
{
    /**
     * Serbest Türkçe metni analiz edip yapısal işlem verisine dönüştürür.
     */
    public function parse(string $text): array
    {
        $cleanText = trim($text);
        $lower = mb_strtolower($cleanText, 'UTF-8');

        $result = [
            'type' => 'expense', // expense, income, debt, card, payment
            'amount' => 0.0,
            'title' => '',
            'category_id' => null,
            'category_name' => '',
            'bank_id' => null,
            'bank_name' => '',
            'date' => Carbon::now()->format('Y-m-d'),
            'is_recurring' => false,
            'interest_rate' => 4.25,
            'installment_amount' => 0.0,
            'credit_limit' => 0.0,
            'confidence' => 'high',
        ];

        // 1. İŞLEM TÜRÜNÜ TESPİT ET
        if (preg_match('/(maaş|avans|prim|gelir|yattı|tahsilat|kazanç|burs|harçlık)/u', $lower)) {
            $result['type'] = 'income';
        } elseif (preg_match('/(kredi çektim|borç aldım|kredi ekle|ihtiyaç kredisi|konut kredisi|taşıt kredisi)/u', $lower)) {
            $result['type'] = 'debt';
        } elseif (preg_match('/(kredi kartı ekle|kart ekle|worldcard|bonus|maximum|kartvizit|axess|cardfinans|paraf)/u', $lower)) {
            $result['type'] = 'card';
        } elseif (preg_match('/(ödendi|borç ödedim|taksit ödedim|kredi ödedim|kapatıldı)/u', $lower)) {
            $result['type'] = 'payment';
        } else {
            $result['type'] = 'expense';
        }

        // 2. TUTARI BUL (Örn: 850 TL, 1.500 TL, 45000, 150.50 vb.)
        if (preg_match('/(?:₺\s*|tl\s*|\b)([0-9]+(?:[\.,][0-9]{2,3})*(?:[\.,][0-9]{2})?)\s*(?:tl|₺|lira|\b)/ui', $cleanText, $matches)) {
            $rawAmount = str_replace([' ', 'TL', 'tl', '₺', 'lira'], '', $matches[1]);
            // Format 1.500,50 veya 1500.50
            if (str_contains($rawAmount, '.') && str_contains($rawAmount, ',')) {
                $rawAmount = str_replace('.', '', $rawAmount);
                $rawAmount = str_replace(',', '.', $rawAmount);
            } elseif (str_contains($rawAmount, ',')) {
                $rawAmount = str_replace(',', '.', $rawAmount);
            }
            $result['amount'] = (float) $rawAmount;
        } elseif (preg_match('/\b([0-9]{2,8})\b/u', $cleanText, $matches)) {
            $result['amount'] = (float) $matches[1];
        }

        // 3. BANKAYI BUL
        $banks = Bank::all();
        foreach ($banks as $b) {
            $bankNameLower = mb_strtolower($b->name, 'UTF-8');
            $keywords = explode(' ', $bankNameLower);
            foreach ($keywords as $kw) {
                if (mb_strlen($kw) >= 4 && str_contains($lower, $kw)) {
                    $result['bank_id'] = $b->id;
                    $result['bank_name'] = $b->name;
                    break 2;
                }
            }
        }

        // 4. KATEGORİYİ TESPİT ET
        $categories = Category::all();
        if ($result['type'] === 'income') {
            $cat = $categories->where('type', 'income')->first();
            if ($cat) {
                $result['category_id'] = $cat->id;
                $result['category_name'] = $cat->name;
            }
        } else {
            if (preg_match('/(migros|bim|a101|şok|carrefour|market|gıda|manav|kasap|bakkal|fırın|ekmek)/u', $lower)) {
                $cat = $categories->first(fn($c) => str_contains(mb_strtolower($c->name), 'market') || str_contains(mb_strtolower($c->name), 'gıda'));
                $result['title'] = 'Market & Gıda Alışverişi';
            } elseif (preg_match('/(benzin|yakıt|mazot|akaryakıt|shell|opet|bp|petrol|otopark|hgs|ogs)/u', $lower)) {
                $cat = $categories->first(fn($c) => str_contains(mb_strtolower($c->name), 'ulaşım') || str_contains(mb_strtolower($c->name), 'yakıt'));
                $result['title'] = 'Akaryakıt & Ulaşım';
            } elseif (preg_match('/(kira|ev sahibi|aidat|apartman)/u', $lower)) {
                $cat = $categories->first(fn($c) => str_contains(mb_strtolower($c->name), 'kira') || str_contains(mb_strtolower($c->name), 'konut'));
                $result['title'] = 'Kira & Aidat Ödemesi';
            } elseif (preg_match('/(fatura|elektrik|su|doğalgaz|internet|turkcell|vodafone|türk telekom)/u', $lower)) {
                $cat = $categories->first(fn($c) => str_contains(mb_strtolower($c->name), 'fatura'));
                $result['title'] = 'Fatura Ödemesi';
            } elseif (preg_match('/(yemek|restoran|cafe|kahve|starbucks|kebap|lokanta|burger|pizza)/u', $lower)) {
                $cat = $categories->first(fn($c) => str_contains(mb_strtolower($c->name), 'yemek') || str_contains(mb_strtolower($c->name), 'dışarı'));
                $result['title'] = 'Yeme & İçme';
            } elseif (preg_match('/(trendyol|hepsiburada|amazon|giyim|kıyafet|ayakkabı|zara|lcw)/u', $lower)) {
                $cat = $categories->first(fn($c) => str_contains(mb_strtolower($c->name), 'giyim') || str_contains(mb_strtolower($c->name), 'alışveriş'));
                $result['title'] = 'Giyim & Alışveriş';
            } else {
                $cat = $categories->where('type', 'expense')->first();
                $result['title'] = mb_convert_case($cleanText, MB_CASE_TITLE, "UTF-8");
            }

            if ($cat) {
                $result['category_id'] = $cat->id;
                $result['category_name'] = $cat->name;
            }
        }

        if (empty($result['title'])) {
            $result['title'] = $result['category_name'] ?: 'Harcama';
        }

        // 5. TARİHİ TESPİT ET
        if (str_contains($lower, 'dün')) {
            $result['date'] = Carbon::yesterday()->format('Y-m-d');
        } elseif (str_contains($lower, 'bugün')) {
            $result['date'] = Carbon::today()->format('Y-m-d');
        } elseif (preg_match('/([0-9]{1,2})[\.\/]([0-9]{1,2})[\.\/]([0-9]{4})/u', $cleanText, $dateMatches)) {
            $result['date'] = sprintf('%04d-%02d-%02d', $dateMatches[3], $dateMatches[2], $dateMatches[1]);
        }

        // 6. FAİZ ORANI & KREDİ/KART PARAMETRELERİ
        if (preg_match('/%?\s*([0-9]+(?:[\.,][0-9]+)?)\s*faiz/ui', $cleanText, $interestMatches)) {
            $result['interest_rate'] = (float) str_replace(',', '.', $interestMatches[1]);
        }

        if ($result['type'] === 'debt' && $result['amount'] > 0) {
            $result['installment_amount'] = round($result['amount'] / 12, 2);
        }

        if ($result['type'] === 'card' && $result['amount'] > 0) {
            $result['credit_limit'] = $result['amount'];
        }

        return $result;
    }

    /**
     * Çoklu satırdan oluşan ekstre metnini satır satır ayrıştırır.
     */
    public function parseBulkLines(string $bulkText): array
    {
        $lines = explode("\n", $bulkText);
        $parsedList = [];

        foreach ($lines as $line) {
            $trimmed = trim($line);
            if (empty($trimmed) || mb_strlen($trimmed) < 4) {
                continue;
            }

            $parsed = $this->parse($trimmed);
            if ($parsed['amount'] > 0) {
                $parsedList[] = $parsed;
            }
        }

        return $parsedList;
    }
}
