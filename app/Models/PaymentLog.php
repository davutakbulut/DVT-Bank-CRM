<?php

namespace App\Models;

use App\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class PaymentLog extends Model
{
    use HasFactory, BelongsToUser;

    protected $table = 'payments_log';

    protected $fillable = [
        'user_id',
        'payable_type',
        'payable_id',
        'amount',
        'paid_at',
        'method',
        'note',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'paid_at' => 'date',
        ];
    }

    public function payable(): MorphTo
    {
        return $this->morphTo();
    }
}
