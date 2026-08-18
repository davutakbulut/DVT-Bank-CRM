<?php

namespace App\Models;

use App\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiChatMessage extends Model
{
    use HasFactory, BelongsToUser;

    protected $fillable = [
        'user_id',
        'role',
        'content',
        'tokens',
    ];

    protected function casts(): array
    {
        return [
            'tokens' => 'integer',
        ];
    }
}
