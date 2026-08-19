<?php

namespace App\Services\AI\Providers;

use App\Models\Setting;
use App\Services\AI\AiProviderInterface;
use App\Services\AI\AiResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiProvider implements AiProviderInterface
{
    protected ?string $apiKey;
    protected string $model;

    public function __construct()
    {
        $this->apiKey = Setting::get('ai.gemini_api_key') ?: env('GEMINI_API_KEY');
        $this->model = Setting::get('ai.gemini_model') ?: env('GEMINI_MODEL', 'gemini-3.7-flash');
    }

    public function isAvailable(): bool
    {
        return !empty($this->apiKey);
    }

    public function complete(string $systemPrompt, string $userPrompt, int $maxTokens = 1200): AiResponse
    {
        if (!$this->isAvailable()) {
            return new AiResponse('', 'gemini', $this->model, 0, 0, 'failed', 'Gemini API Key tanımlı değil.');
        }

        try {
            $url = "https://generativelanguage.googleapis.com/v1beta/models/{$this->model}:generateContent?key={$this->apiKey}";

            $response = Http::timeout(15)->post($url, [
                'system_instruction' => [
                    'parts' => [
                        ['text' => $systemPrompt],
                    ],
                ],
                'contents' => [
                    [
                        'role' => 'user',
                        'parts' => [
                            ['text' => $userPrompt],
                        ],
                    ],
                ],
                'generationConfig' => [
                    'maxOutputTokens' => $maxTokens,
                    'temperature' => 0.4,
                ],
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $content = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';
                $promptTokens = $data['usageMetadata']['promptTokenCount'] ?? 0;
                $completionTokens = $data['usageMetadata']['candidatesTokenCount'] ?? 0;

                return new AiResponse($content, 'gemini', $this->model, $promptTokens, $completionTokens, 'success');
            }

            Log::warning('Gemini API Error: ' . $response->body());
            return new AiResponse('', 'gemini', $this->model, 0, 0, 'failed', $response->body());
        } catch (\Throwable $e) {
            Log::error('Gemini Exception: ' . $e->getMessage());
            return new AiResponse('', 'gemini', $this->model, 0, 0, 'failed', $e->getMessage());
        }
    }
}
