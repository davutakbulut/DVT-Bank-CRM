<?php

namespace App\Services\AI\Providers;

use App\Models\Setting;
use App\Services\AI\AiProviderInterface;
use App\Services\AI\AiResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OpenRouterProvider implements AiProviderInterface
{
    protected ?string $apiKey;
    protected string $model;

    public function __construct()
    {
        $this->apiKey = Setting::get('ai.openrouter_api_key') ?: env('OPENROUTER_API_KEY');
        $this->model = Setting::get('ai.openrouter_model') ?: env('OPENROUTER_MODEL', 'meta-llama/llama-3.3-70b-instruct:free');
    }

    public function isAvailable(): bool
    {
        return !empty($this->apiKey);
    }

    public function complete(string $systemPrompt, string $userPrompt, int $maxTokens = 1200): AiResponse
    {
        if (!$this->isAvailable()) {
            return new AiResponse('', 'openrouter', $this->model, 0, 0, 'failed', 'OpenRouter API Key tanımlı değil.');
        }

        try {
            $response = Http::withToken($this->apiKey)
                ->withHeaders([
                    'HTTP-Referer' => 'https://dvt.portegu.com',
                    'X-Title' => 'DVT Bank CRM',
                ])
                ->timeout(15)
                ->post('https://openrouter.ai/api/v1/chat/completions', [
                    'model' => $this->model,
                    'messages' => [
                        ['role' => 'system', 'content' => $systemPrompt],
                        ['role' => 'user', 'content' => $userPrompt],
                    ],
                    'max_tokens' => $maxTokens,
                    'temperature' => 0.4,
                ]);

            if ($response->successful()) {
                $data = $response->json();
                $content = $data['choices'][0]['message']['content'] ?? '';
                $promptTokens = $data['usage']['prompt_tokens'] ?? 0;
                $completionTokens = $data['usage']['completion_tokens'] ?? 0;

                return new AiResponse($content, 'openrouter', $this->model, $promptTokens, $completionTokens, 'success');
            }

            Log::warning('OpenRouter API Error: ' . $response->body());
            return new AiResponse('', 'openrouter', $this->model, 0, 0, 'failed', $response->body());
        } catch (\Throwable $e) {
            Log::error('OpenRouter Exception: ' . $e->getMessage());
            return new AiResponse('', 'openrouter', $this->model, 0, 0, 'failed', $e->getMessage());
        }
    }
}
