<?php

namespace App\Models;

use App\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiAdvice extends Model
{
    use HasFactory, BelongsToUser;

    protected $table = 'ai_advices';

    protected $fillable = [
        'user_id',
        'type',
        'context_snapshot',
        'prompt_tokens',
        'completion_tokens',
        'provider',
        'model',
        'content',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'context_snapshot' => 'array',
            'prompt_tokens' => 'integer',
            'completion_tokens' => 'integer',
        ];
    }
}
