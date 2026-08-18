<?php

namespace App\Services\AI;

interface AiProviderInterface
{
    public function complete(string $systemPrompt, string $userPrompt, int $maxTokens = 1200): AiResponse;
    public function isAvailable(): bool;
}
