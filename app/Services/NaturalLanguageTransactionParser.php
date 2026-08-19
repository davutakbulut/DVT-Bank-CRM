<?php

namespace App\Services;

use App\Models\Bank;
use App\Models\Category;
use App\Models\CreditCard;
use App\Models\Setting;
use App\Models\User;
use App\Services\AI\Providers\GeminiProvider;
use App\Services\AI\Providers\GroqProvider;
use App\Services\AI\Providers\OpenRouterProvider;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NaturalLanguageTransactionParser
{
    /**
     * Çoklu veya tekli serbest Türkçe metni analiz edip bir veya birden fazla işlem listesi döner.
     */
    public function parseAll(string $text, ?User $user = null): array
    {
        $cleanText = trim($text);
        if (empty($cleanText)) {
            return [];
        }

        $user = $user ?? Auth::user();

        // 1. Temel ayrıştırıcılar (noktalama, satır başı, bağlaçlar)
        $rawSegments = preg_split('/(?:,\s*|\.\s*|\n|;\s*|\bve\b|\bayrıca\b|\bbir de\b|\bsonra da\b|\bhem de\b)/ui', $cleanText);
        $finalSegments = [];

        foreach ($rawSegments as $chunk) {
            $chunk = trim($chunk);
            if (empty($chunk)) continue;

            // Tek parçada birden fazla tutar ifadesi varsa akıllıca alt parçalara böl
            if (preg_match_all('/(?:[0-9]+(?:\.[0-9]{3})*(?:,[0-9]{1,2})?\s*(?:tl|₺|lira|bin|k)|(?:₺|tl)\s*[0-9]+)/ui', $chunk, $m) && count($m[0]) > 1) {
                $subparts = preg_split('/(?<=[0-9₺tlira]\s{0,8}(?:yattı|yatti|aldım|aldim|ödedim|odedim|çektim|cektim|harcadım|harcadim|geldi|gecti|yansıdı|yansidi))\s+/ui', $chunk);
                foreach ($subparts as $sp) {
                    if (!empty(trim($sp))) $finalSegments[] = trim($sp);
                }
            } else {
                $finalSegments[] = $chunk;
            }
        }

        $results = [];
        foreach ($finalSegments as $seg) {
            $seg = trim($seg);
            if (empty($seg) || mb_strlen($seg) < 3) continue;
            $parsed = $this->parse($seg, $user);
            if (!empty($parsed['amount']) && $parsed['amount'] > 0) {
                $results[] = $parsed;
            }
        }

        // Eğer parçalanamadıysa tekil olarak parse et
        if (empty($results)) {
            $single = $this->parse($cleanText, $user);
            if (!empty($single['amount']) && $single['amount'] > 0) {
                $results[] = $single;
            }
        }

        return $results;
    }

    /**
     * Serbest Türkçe metni analiz edip yapısal finansal işlem verisine dönüştürür.
     */
    public function parse(string $text, ?User $user = null): array
    {
        $cleanText = trim($text);
        if (empty($cleanText)) {
            return $this->getEmptyResult();
        }

        $user = $user ?? Auth::user();

        // 1. Önce hızlı ve hatasız yerel NLP motorunu çalıştır
        $localResult = $this->parseHeuristic($cleanText, $user);

        // 2. Eğer AI API sağlayıcıları (Groq / Gemini vb.) aktifse ve metin karmaşıksa AI ile zenginleştir
        if ($this->shouldUseAiLlm($cleanText)) {
            $aiResult = $this->parseWithLlm($cleanText, $user);
            if ($aiResult && $aiResult['amount'] > 0) {
                return $aiResult;
            }
        }

        return $localResult;
    }

    /**
     * Akıllı Yerel Türkçe NLP ve Kural Motoru
     */
    public function parseHeuristic(string $text, ?User $user = null): array
    {
        $cleanText = trim($text);
        $lower = mb_strtolower($cleanText, 'UTF-8');
        $ascii = str_replace(
            ['ı', 'ş', 'ğ', 'ü', 'ö', 'ç', 'İ', 'Ş', 'Ğ', 'Ü', 'Ö', 'Ç'],
            ['i', 's', 'g', 'u', 'o', 'c', 'i', 's', 'g', 'u', 'o', 'c'],
            $lower
        );

        $result = [
            'type' => 'expense', // expense, income, debt, card, payment
            'income_type' => 'other',
            'amount' => 0.0,
            'title' => '',
            'category_id' => null,
            'category_name' => '',
            'bank_id' => null,
            'bank_name' => '',
            'credit_card_id' => null,
            'payment_method' => 'cash', // cash, credit_card, bank_transfer
            'date' => Carbon::today()->format('Y-m-d'),
            'is_recurring' => false,
            'frequency' => 'one_time',
            'interest_rate' => 4.25,
            'installment_amount' => 0.0,
            'credit_limit' => 0.0,
            'confidence' => 'high',
            'summary' => '',
        ];

        // 1. TUTARI BUL (Örn: 45.000, 45000, 250₺, 1500 TL, 1.250,50 TL, 2 paket sigara aldım 250₺)
        $foundAmount = false;

        // A) 45 bin TL / 45k
        if (preg_match('/\b([0-9]+(?:[\.,][0-9]+)?)\s*(?:bin|k)\s*(?:tl|₺|lira|\b)/ui', $cleanText, $binMatches)) {
            $val = (float) str_replace(',', '.', $binMatches[1]);
            $result['amount'] = $val * 1000;
            $foundAmount = true;
        }
        // B) 250₺, 250 TL, 1.500 TL, ₺45.000 (Para birimi simgesi ile bitişik veya yan yana)
        elseif (preg_match('/(?:(?:₺|tl)\s*([0-9]{1,3}(?:\.[0-9]{3})*(?:,[0-9]{1,2})?|[0-9]+(?:[\.,][0-9]{1,2})?)|([0-9]{1,3}(?:\.[0-9]{3})*(?:,[0-9]{1,2})?|[0-9]+(?:[\.,][0-9]{1,2})?)\s*(?:₺|tl|lira))/ui', $cleanText, $currMatches)) {
            $raw = !empty($currMatches[1]) ? $currMatches[1] : $currMatches[2];
            $raw = str_replace([' ', 'TL', 'tl', '₺', 'lira'], '', $raw);
            if (str_contains($raw, '.') && str_contains($raw, ',')) {
                $raw = str_replace('.', '', $raw);
                $raw = str_replace(',', '.', $raw);
            } elseif (preg_match('/\.[0-9]{3}\b/', $raw)) {
                $raw = str_replace('.', '', $raw);
            } elseif (str_contains($raw, ',')) {
                $raw = str_replace(',', '.', $raw);
            }
            $result['amount'] = (float) $raw;
            $foundAmount = true;
        }
        // C) Eğer para birimi sembolü yoksa, adet/paket vb. kelimelerden arındırarak tutarı bul
        if (!$foundAmount) {
            if (preg_match_all('/\b([0-9]{1,3}(?:\.[0-9]{3})*(?:,[0-9]{1,2})?|[0-9]+)\b/u', $cleanText, $allNumbers)) {
                $candidates = [];
                foreach ($allNumbers[1] as $idx => $numStr) {
                    // Sayının hemen sonrasındaki kelime adet/paket/ay/gün ise atla
                    if (preg_match('/' . preg_quote($numStr, '/') . '\s*(?:paket|adet|tane|ay|gün|dakika|saat|koli|kg|gram|lt)/ui', $cleanText)) {
                        continue;
                    }
                    $cleaned = $numStr;
                    if (preg_match('/\.[0-9]{3}\b/', $cleaned)) {
                        $cleaned = str_replace('.', '', $cleaned);
                    }
                    $candidates[] = (float) str_replace(',', '.', $cleaned);
                }
                if (!empty($candidates)) {
                    $result['amount'] = end($candidates);
                    $foundAmount = true;
                }
            }
        }

        // 2. İŞLEM TÜRÜNÜ TESPİT ET (Income / Expense / Debt / Card / Payment)
        if (preg_match('/(maaş|maas|avans|prim|hakediş|hakedis|kira geliri|tahsilat|yattı|yatti|hesabıma geldi|hesabima geldi|hesabıma geçti|hesabima gecti|gelir|kazanç|kazanc|burs|harçlık|harclik)/u', $lower . ' ' . $ascii)) {
            $result['type'] = 'income';
            if (str_contains($ascii, 'maas')) {
                $result['income_type'] = 'salary';
                $result['is_recurring'] = true;
                $result['frequency'] = 'monthly';
            } elseif (str_contains($ascii, 'prim') || str_contains($ascii, 'hakedis')) {
                $result['income_type'] = 'freelance';
            } elseif (str_contains($ascii, 'kira')) {
                $result['income_type'] = 'rental';
                $result['is_recurring'] = true;
                $result['frequency'] = 'monthly';
            }
        } elseif (preg_match('/(kredi çektim|kredi cektim|borç aldım|borc aldim|kredi ekle|ihtiyaç kredisi|ihtiyac kredisi|konut kredisi|taşıt kredisi|tasit kredisi|kmh açtım|kmh actim)/u', $lower . ' ' . $ascii)) {
            $result['type'] = 'debt';
        } elseif (preg_match('/(kredi kartı ekle|kredi karti ekle|kart ekle|yeni kart|worldcard|bonus|maximum|axess|cardfinans|paraf|kartvizit)/u', $lower . ' ' . $ascii) && !str_contains($lower, 'kartıyla') && !str_contains($lower, 'kartımdan') && !str_contains($lower, 'ile aldım')) {
            $result['type'] = 'card';
        } elseif (preg_match('/(ödendi|odendi|borç ödedim|borc odedim|kart borcu ödedim|kart borcu odedim|taksit ödedim|taksit odedim|kredi ödedim|kredi odedim|kapatıldı|kapatildi)/u', $lower . ' ' . $ascii)) {
            $result['type'] = 'payment';
        } else {
            $result['type'] = 'expense';
        }

        // 3. BANKAYI BUL (Doğrudan + Akıllı Typo / Yazım Hatası Toleranslı Eşleme)
        $bankKeywords = [
            'garanti' => 'Garanti BBVA',
            'bbva' => 'Garanti BBVA',
            'enpara' => 'Enpara.com',
            'ziraat' => 'Ziraat Bankası',
            'akbank' => 'Akbank',
            'türkiye finans' => 'Türkiye Finans',
            'turkiye finans' => 'Türkiye Finans',
            'finansbank' => 'QNB Bank',
            'qnb' => 'QNB Bank',
            'iş bankası' => 'Türkiye İş Bankası',
            'is bankasi' => 'Türkiye İş Bankası',
            'işcep' => 'Türkiye İş Bankası',
            'yapı kredi' => 'Yapı Kredi',
            'yapi kredi' => 'Yapı Kredi',
            'vakıfbank' => 'VakıfBank',
            'vakifbank' => 'VakıfBank',
            'halkbank' => 'Halkbank',
            'teb' => 'Türk Ekonomi Bankası (TEB)',
            'denizbank' => 'DenizBank',
            'papara' => 'Papara',
        ];

        // A) Doğrudan substring eşleme
        foreach ($bankKeywords as $kw => $canonicalName) {
            if (str_contains($lower, $kw)) {
                $b = Bank::where('name', 'like', '%' . $canonicalName . '%')
                    ->orWhere('name', 'like', '%' . $kw . '%')
                    ->first();
                if ($b) {
                    $result['bank_id'] = $b->id;
                    $result['bank_name'] = $b->name;
                    break;
                }
            }
        }

        // B) Typo / Yazım Hatası Eşleme (Örn: ganranti, enpra, akbak, zirat vb.)
        if (!$result['bank_id']) {
            $words = preg_split('/[\s,\.\/\-_]+/u', $lower);
            $targetBanks = [
                'garanti' => 'Garanti BBVA',
                'enpara' => 'Enpara.com',
                'ziraat' => 'Ziraat Bankası',
                'akbank' => 'Akbank',
                'finans' => 'Türkiye Finans',
                'qnb' => 'QNB Bank',
                'yapikredi' => 'Yapı Kredi',
                'isbankasi' => 'Türkiye İş Bankası',
                'vakifbank' => 'VakıfBank',
            ];

            foreach ($words as $w) {
                if (mb_strlen($w) < 4) continue;
                foreach ($targetBanks as $canonWord => $bankName) {
                    $dist = levenshtein($w, $canonWord);
                    similar_text($w, $canonWord, $percent);
                    if ($dist <= 2 || $percent >= 75) {
                        $b = Bank::where('name', 'like', '%' . $bankName . '%')->first();
                        if ($b) {
                            $result['bank_id'] = $b->id;
                            $result['bank_name'] = $b->name;
                            break 2;
                        }
                    }
                }
            }
        }

        // Kullanıcının kartlarını kontrol et
        if ($user && $result['bank_id']) {
            $card = CreditCard::where('user_id', $user->id)->where('bank_id', $result['bank_id'])->first();
            if ($card) {
                $result['credit_card_id'] = $card->id;
            }
        }

        // 4. ÖDEME YÖNTEMİNİ TESPİT ET (Nakit, Kredi Kartı, Banka Transferi)
        if (preg_match('/(kart|kredi kartı|kartımla|kartımdan|bonus|axess|world|pos|temassız)/u', $lower)) {
            $result['payment_method'] = 'credit_card';
        } elseif (preg_match('/(havale|eft|fast|hesabımdan|virman|transfer)/u', $lower)) {
            $result['payment_method'] = 'bank_transfer';
        } elseif (preg_match('/(nakit|elden|cüzdandan|para çektim)/u', $lower)) {
            $result['payment_method'] = 'cash';
        } else {
            $result['payment_method'] = $result['credit_card_id'] ? 'credit_card' : 'cash';
        }

        // 5. KATEGORİYİ VE BAŞLIĞI TESPİT ET
        $categories = Category::all();

        if ($result['type'] === 'income') {
            $cat = $categories->first(fn($c) => $c->type === 'income' || str_contains(mb_strtolower($c->name), 'gelir') || str_contains(mb_strtolower($c->name), 'maaş'));
            $result['title'] = ($result['bank_name'] ? $result['bank_name'] . ' - ' : '') . ($result['income_type'] === 'salary' ? 'Maaş Geliri' : ($result['income_type'] === 'freelance' ? 'Prim / Hakediş Geliri' : 'Gelir Girişi'));
        } else {
            // Harcama türü analizi
            if (preg_match('/(sigara|bakkal|market|migros|bim|a101|şok|carrefour|gıda|manav|kasap|fırın|ekmek|tekel|su aldım|su aldim|meyve|sebze|içecek|icecek)/u', $lower)) {
                $cat = $categories->first(fn($c) => str_contains(mb_strtolower($c->name), 'market') || str_contains(mb_strtolower($c->name), 'gıda'));
                if (str_contains($lower, 'sigara')) {
                    $result['title'] = 'Bakkal / Tekel (Sigara Alışverişi)';
                } elseif (str_contains($lower, 'su aldım') || str_contains($lower, 'su aldim') || preg_match('/\bsu\b/u', $lower)) {
                    $result['title'] = 'Market / Büfe (Su & İçecek Alışverişi)';
                } elseif (str_contains($lower, 'bakkal')) {
                    $result['title'] = 'Bakkal Harcaması';
                } else {
                    $result['title'] = 'Market & Gıda Alışverişi';
                }
            } elseif (preg_match('/(benzin|yakıt|mazot|akaryakıt|shell|opet|bp|petrol|otopark|hgs|ogs|motorin)/u', $lower)) {
                $cat = $categories->first(fn($c) => str_contains(mb_strtolower($c->name), 'akaryakıt') || str_contains(mb_strtolower($c->name), 'ulaşım'));
                $result['title'] = 'Akaryakıt / Yakıt Harcaması';
            } elseif (preg_match('/(yemek|restoran|cafe|kahve|starbucks|kebap|lokanta|burger|pizza|döner|köfte)/u', $lower)) {
                $cat = $categories->first(fn($c) => str_contains(mb_strtolower($c->name), 'yeme') || str_contains(mb_strtolower($c->name), 'içme') || str_contains(mb_strtolower($c->name), 'restoran'));
                $result['title'] = 'Yeme & İçme Harcaması';
            } elseif (preg_match('/(kira|ev sahibi|aidat|apartman|bina)/u', $lower)) {
                $cat = $categories->first(fn($c) => str_contains(mb_strtolower($c->name), 'kira') || str_contains(mb_strtolower($c->name), 'konut'));
                $result['title'] = 'Kira & Konut Ödemesi';
            } elseif (preg_match('/(fatura|elektrik|su faturası|su faturasi|doğalgaz|dogalgaz|internet|turkcell|vodafone|türk telekom|turk telekom)/u', $lower)) {
                $cat = $categories->first(fn($c) => str_contains(mb_strtolower($c->name), 'fatura'));
                $result['title'] = 'Fatura Ödemesi';
            } elseif (preg_match('/(trendyol|hepsiburada|amazon|giyim|kıyafet|ayakkabı|zara|lcw|mango|boyner|beymen)/u', $lower)) {
                $cat = $categories->first(fn($c) => str_contains(mb_strtolower($c->name), 'giyim') || str_contains(mb_strtolower($c->name), 'alışveriş'));
                $result['title'] = 'Giyim & Alışveriş';
            } elseif (preg_match('/(eczane|sağlık|doktor|ilaç|hastane|muayene)/u', $lower)) {
                $cat = $categories->first(fn($c) => str_contains(mb_strtolower($c->name), 'sağlık') || str_contains(mb_strtolower($c->name), 'eczane'));
                $result['title'] = 'Sağlık & İlaç Harcaması';
            } else {
                $cat = $categories->where('type', 'expense')->first();
                $result['title'] = mb_convert_case($cleanText, MB_CASE_TITLE, "UTF-8");
            }
        }

        if ($cat) {
            $result['category_id'] = $cat->id;
            $result['category_name'] = $cat->name;
        }

        // 6. TARİHİ TESPİT ET
        if (str_contains($lower, 'dün')) {
            $result['date'] = Carbon::yesterday()->format('Y-m-d');
        } elseif (str_contains($lower, 'bugün')) {
            $result['date'] = Carbon::today()->format('Y-m-d');
        } elseif (preg_match('/([0-9]{1,2})[\.\/]([0-9]{1,2})[\.\/]([0-9]{4})/u', $cleanText, $dateMatches)) {
            $result['date'] = sprintf('%04d-%02d-%02d', $dateMatches[3], $dateMatches[2], $dateMatches[1]);
        }

        // 7. ÖZET METNİ ÜRET
        $result['summary'] = $this->buildSummaryText($result);

        return $result;
    }

    /**
     * LLM (Groq / Gemini / OpenRouter) kullanarak metin analizi
     */
    protected function parseWithLlm(string $text, ?User $user = null): ?array
    {
        try {
            $providers = [
                'groq' => new GroqProvider(),
                'gemini' => new GeminiProvider(),
                'openrouter' => new OpenRouterProvider(),
            ];

            $systemPrompt = <<<EOT
Sen bir finansal NLP ayrıştırıcısısın. Kullanıcının Türkçe serbest metnini analiz et ve SADECE saf geçerli bir JSON objesi döndür. Markdown veya ekstra açıklama yazma.

JSON Şeması:
{
  "type": "expense|income|debt|card|payment",
  "amount": float,
  "title": "Kısa ve net işlem başlığı",
  "category_name": "Market & Alışveriş|Akaryakıt & Ulaşım|Yeme & İçme|Maaş & Gelir|Fatura|Kira|Sağlık|Diğer",
  "bank_name": "Enpara|Garanti BBVA|Akbank|Ziraat Bankası|Türkiye Finans|QNB|İş Bankası|null",
  "payment_method": "cash|credit_card|bank_transfer",
  "is_recurring": boolean,
  "frequency": "one_time|monthly|weekly"
}
EOT;

            foreach ($providers as $p) {
                if ($p->isAvailable()) {
                    $response = $p->complete($systemPrompt, "İşlem Metni: " . $text);
                    if ($response->status === 'success' && !empty($response->content)) {
                        $jsonString = trim($response->content);
                        // Clean markdown ```json blocks if present
                        if (preg_match('/```(?:json)?(.*?)```/s', $jsonString, $matches)) {
                            $jsonString = trim($matches[1]);
                        }
                        $data = json_decode($jsonString, true);
                        if (is_array($data) && isset($data['amount']) && (float) $data['amount'] > 0) {
                            return $this->enrichLlmResult($data, $user);
                        }
                    }
                }
            }
        } catch (\Throwable $e) {
            Log::warning('AI Natural Language Parser LLM Exception: ' . $e->getMessage());
        }

        return null;
    }

    protected function enrichLlmResult(array $data, ?User $user = null): array
    {
        $result = [
            'type' => $data['type'] ?? 'expense',
            'income_type' => ($data['type'] ?? '') === 'income' ? 'salary' : 'other',
            'amount' => (float) ($data['amount'] ?? 0),
            'title' => $data['title'] ?? 'İşlem',
            'category_id' => null,
            'category_name' => $data['category_name'] ?? '',
            'bank_id' => null,
            'bank_name' => $data['bank_name'] ?? '',
            'credit_card_id' => null,
            'payment_method' => $data['payment_method'] ?? 'cash',
            'date' => Carbon::today()->format('Y-m-d'),
            'is_recurring' => (bool) ($data['is_recurring'] ?? false),
            'frequency' => $data['frequency'] ?? 'one_time',
            'interest_rate' => 4.25,
            'installment_amount' => 0.0,
            'credit_limit' => 0.0,
            'confidence' => 'ai_high',
            'summary' => '',
        ];

        // Banka Eşleme
        if (!empty($result['bank_name'])) {
            $b = Bank::where('name', 'like', '%' . $result['bank_name'] . '%')->first();
            if ($b) {
                $result['bank_id'] = $b->id;
                $result['bank_name'] = $b->name;
                if ($user) {
                    $card = CreditCard::where('user_id', $user->id)->where('bank_id', $b->id)->first();
                    if ($card) {
                        $result['credit_card_id'] = $card->id;
                    }
                }
            }
        }

        // Kategori Eşleme
        if (!empty($result['category_name'])) {
            $cat = Category::where('name', 'like', '%' . $result['category_name'] . '%')->first();
            if ($cat) {
                $result['category_id'] = $cat->id;
                $result['category_name'] = $cat->name;
            }
        }

        $result['summary'] = $this->buildSummaryText($result);
        return $result;
    }

    protected function buildSummaryText(array $res): string
    {
        $typeEmoji = match ($res['type']) {
            'income' => '🟢 Gelir Girişi',
            'expense' => '🔴 Harcama/Gider',
            'debt' => '🏦 Kredi Borcu',
            'card' => '💳 Kredi Kartı',
            'payment' => '✅ Borç Ödemesi',
            default => '⚡ İşlem',
        };

        $parts = [];
        $parts[] = $typeEmoji . ': ' . $res['title'];
        $parts[] = 'Tutar: ₺' . number_format($res['amount'], 2, ',', '.');
        if ($res['category_name']) {
            $parts[] = 'Kategori: ' . $res['category_name'];
        }
        if ($res['bank_name']) {
            $parts[] = 'Banka: ' . $res['bank_name'];
        }
        if ($res['payment_method']) {
            $parts[] = 'Yöntem: ' . ($res['payment_method'] === 'credit_card' ? 'Kredi Kartı' : ($res['payment_method'] === 'bank_transfer' ? 'Banka Transferi' : 'Nakit'));
        }

        return implode(' • ', $parts);
    }

    protected function shouldUseAiLlm(string $text): bool
    {
        return mb_strlen($text) > 15;
    }

    protected function getEmptyResult(): array
    {
        return [
            'type' => 'expense',
            'amount' => 0.0,
            'title' => '',
            'category_id' => null,
            'category_name' => '',
            'bank_id' => null,
            'bank_name' => '',
            'date' => Carbon::today()->format('Y-m-d'),
            'summary' => '',
        ];
    }
}
