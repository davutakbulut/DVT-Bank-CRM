<?php

namespace App\Models;

use App\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Reminder extends Model
{
    use HasFactory, BelongsToUser;

    protected $fillable = [
        'user_id',
        'remindable_type',
        'remindable_id',
        'title',
        'message',
        'remind_at',
        'channel',
        'is_sent',
        'is_read',
    ];

    protected function casts(): array
    {
        return [
            'remind_at' => 'datetime',
            'is_sent' => 'boolean',
            'is_read' => 'boolean',
        ];
    }

    public function remindable(): MorphTo
    {
        return $this->morphTo();
    }
}
