<?php

namespace App\Services\AI;

use App\Models\AiAdvice;
use App\Models\AiUsageDaily;
use App\Models\Setting;
use App\Models\User;
use App\Services\AI\Providers\GeminiProvider;
use App\Services\AI\Providers\GroqProvider;
use App\Services\AI\Providers\OpenRouterProvider;
use Illuminate\Support\Facades\Log;

class AiManager
{
    public const SYSTEM_PROMPT = <<<EOT
Sen DVT Bank CRM'in kıdemli Finans ve Kriz Yönetim Baş Danışmanısın. Kullanıcı Türkiye bankacılık sisteminde birden fazla bankaya borcu olan (İhtiyaç Kredisi, Kredi Kartı, KMH/Ekpara, Artı Para), nakit akışını ve borç kurtarma stratejisini yönetmeye çalışan bir bireydir.

Finansal Uzmanlık İlkelerin ve Bilgi Tabanın:
1. Türkiye Bankacılık Mevzuatı & BDDK Kuralları:
   - 90 Gün Kuralı: 90 gün boyunca asgari tutarı ödenmeyen borçlar için banka noterden Hesap Kat İhtarnamesi çeker ve borcu yasal takibe (icra ve banka avukatına) sevk eder.
   - İcra ve avukat masrafları borca anında %25-%35 civarında ek maliyet yükler.
   - Kredi kartları ve KMH'larda 60 aya kadar BDDK borç yapılandırma hakkı mevcuttur.
2. Danışmanlık ve Analiz Tarzın:
   - Tıpkı gerçek bir kıdemli finans direktörü gibi keskin, net rakamlarla konuşan, gerçekçi ve yol gösterici ol.
   - Kullanıcı genel durumunu sorduğunda: En kritik 3 somut eylemi (en yüksek faizli borç, yapılandırma ve yasal takip koruması) listele.
   - Kullanıcı serbest / özel bir soru sorduğunda (Örn: "Kaç ay ödemeden geçinebilirim?", "Maaşım yetmiyor ne yapayım?", "Hangi borcu önce kapatmalıyım?"): DOĞRUDAN kullanıcının sorusuna odaklan; JSON tablosundaki gerçek gecikme günlerini (`takibe_kalan_gun`), kalan bakiyeleri, asgari ödemeleri ve faiz oranlarını kullanarak açık matematiksel simülasyon ve kronolojik risk takvimi sun.
3. Kurallar:
   - SADECE kullanıcının veritabanındaki gerçek banka isimlerini, tutarları ve gecikme verilerini referans al.
   - Yanıtlarını temiz, okunaklı Markdown başlıkları, maddeleri ve net vurgularla formatla.
EOT;

    public const LEGAL_DISCLAIMER = "\n\n⚖️ *Bu içerik bilgilendirme amaçlıdır; 6362 sayılı Kanun kapsamında yatırım veya finansal danışmanlık değildir.*";

    protected array $providers = [];
    protected FallbackEngine $fallbackEngine;

    public function __construct()
    {
        $this->providers = [
            'groq' => new GroqProvider(),
            'gemini' => new GeminiProvider(),
            'openrouter' => new OpenRouterProvider(),
        ];
        $this->fallbackEngine = new FallbackEngine();
    }

    /**
     * Kullanıcı için günlük veya analiz önerisi üretir ve veritabanına kaydeder.
     */
    public function generateAdviceForUser(User $user, string $type = 'daily'): AiAdvice
    {
        $contextBuilder = new UserContextBuilder();
        $context = $contextBuilder->build($user);
        $userPrompt = "Kullanıcının güncel finansal veri tablosu:\n" . json_encode($context, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        $defaultProviderKey = Setting::get('ai.default_provider') ?: env('AI_DEFAULT_PROVIDER', 'groq');
        $providerOrder = array_unique([$defaultProviderKey, 'groq', 'gemini', 'openrouter']);

        $aiResponse = null;

        foreach ($providerOrder as $pKey) {
            if (isset($this->providers[$pKey]) && $this->providers[$pKey]->isAvailable()) {
                $response = $this->providers[$pKey]->complete(self::SYSTEM_PROMPT, $userPrompt);
                if ($response->status === 'success' && !empty(trim($response->content))) {
                    $aiResponse = $response;
                    break;
                }
            }
        }

        // Eğer tüm sağlayıcılar başarısızsa Fallback motorunu devreye sok
        if (!$aiResponse) {
            $fallbackContent = $this->fallbackEngine->generateAdvice($context);
            $aiResponse = new AiResponse(
                content: $fallbackContent,
                provider: 'rule_engine',
                model: 'offline_fallback',
                status: 'fallback'
            );
        }

        // Yasal sorumluluk reddi ekle
        $finalContent = trim($aiResponse->content) . self::LEGAL_DISCLAIMER;

        // Kullanımı kaydet
        $this->recordUsage($aiResponse->provider, $aiResponse->promptTokens + $aiResponse->completionTokens);

        // AiAdvice kaydet
        return AiAdvice::create([
            'user_id' => $user->id,
            'type' => $type,
            'context_snapshot' => $context,
            'prompt_tokens' => $aiResponse->promptTokens,
            'completion_tokens' => $aiResponse->completionTokens,
            'provider' => $aiResponse->provider,
            'model' => $aiResponse->model,
            'content' => $finalContent,
            'status' => $aiResponse->status,
        ]);
    }

    /**
     * AI sohbet yanıtı üretir.
     */
    public function chat(User $user, string $userMessage, array $chatHistory = []): string
    {
        $contextBuilder = new UserContextBuilder();
        $context = $contextBuilder->build($user);

        $prompt = "Kullanıcı Finansal Özeti: " . json_encode($context, JSON_UNESCAPED_UNICODE) . "\n\n";
        $prompt .= "Kullanıcının Sorusu: " . $userMessage;

        $defaultProviderKey = Setting::get('ai.default_provider') ?: env('AI_DEFAULT_PROVIDER', 'groq');
        $providerOrder = array_unique([$defaultProviderKey, 'groq', 'gemini', 'openrouter']);

        $content = null;

        foreach ($providerOrder as $pKey) {
            if (isset($this->providers[$pKey]) && $this->providers[$pKey]->isAvailable()) {
                $response = $this->providers[$pKey]->complete(self::SYSTEM_PROMPT, $prompt);
                if ($response->status === 'success' && !empty(trim($response->content))) {
                    $content = $response->content;
                    $this->recordUsage($response->provider, $response->promptTokens + $response->completionTokens);
                    break;
                }
            }
        }

        if (!$content) {
            $content = $this->fallbackEngine->generateChatResponse($context, $userMessage);
        }

        return trim($content) . self::LEGAL_DISCLAIMER;
    }

    protected function recordUsage(string $provider, int $tokens): void
    {
        if ($provider === 'rule_engine') return;

        try {
            $today = now()->format('Y-m-d');
            $usage = AiUsageDaily::firstOrCreate(
                ['date' => $today, 'provider' => $provider],
                ['requests' => 0, 'tokens' => 0]
            );

            $usage->increment('requests');
            if ($tokens > 0) {
                $usage->increment('tokens', $tokens);
            }
        } catch (\Throwable $e) {
            Log::warning('AI Usage logging failed: ' . $e->getMessage());
        }
    }
}
