<?php

namespace App\Services\AI;

class AiResponse
{
    public function __construct(
        public string $content,
        public string $provider,
        public string $model,
        public int $promptTokens = 0,
        public int $completionTokens = 0,
        public string $status = 'success', // success, fallback, failed
        public ?string $errorMessage = null,
    ) {}
}
