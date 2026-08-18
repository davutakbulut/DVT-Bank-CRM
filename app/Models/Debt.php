<?php

namespace App\Models;

use App\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Debt extends Model
{
    use HasFactory, SoftDeletes, BelongsToUser;

    protected $fillable = [
        'user_id',
        'bank_id',
        'account_id',
        'credit_card_id',
        'type',
        'title',
        'principal',
        'remaining',
        'interest_rate',
        'installment_count',
        'installment_amount',
        'start_date',
        'end_date',
        'next_due_date',
        'last_payment_date',
        'days_overdue',
        'is_restructured',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'principal' => 'decimal:2',
            'remaining' => 'decimal:2',
            'interest_rate' => 'decimal:4',
            'installment_count' => 'integer',
            'installment_amount' => 'decimal:2',
            'start_date' => 'date',
            'end_date' => 'date',
            'next_due_date' => 'date',
            'last_payment_date' => 'date',
            'days_overdue' => 'integer',
            'is_restructured' => 'boolean',
        ];
    }

    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function creditCard(): BelongsTo
    {
        return $this->belongsTo(CreditCard::class);
    }

    public function payments(): MorphMany
    {
        return $this->morphMany(PaymentLog::class, 'payable');
    }
}
