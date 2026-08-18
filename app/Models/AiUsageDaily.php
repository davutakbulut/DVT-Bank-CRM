<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiUsageDaily extends Model
{
    use HasFactory;

    protected $table = 'ai_usage_daily';

    protected $fillable = [
        'date',
        'provider',
        'requests',
        'tokens',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'requests' => 'integer',
            'tokens' => 'integer',
        ];
    }
}
