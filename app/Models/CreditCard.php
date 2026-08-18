<?php

namespace App\Models;

use App\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CreditCard extends Model
{
    use HasFactory, SoftDeletes, BelongsToUser;

    protected $fillable = [
        'user_id',
        'bank_id',
        'name',
        'last_four',
        'credit_limit',
        'current_debt',
        'minimum_payment',
        'statement_day',
        'due_day',
        'interest_rate',
        'overdue_interest_rate',
        'last_payment_date',
        'is_restructured',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'credit_limit' => 'decimal:2',
            'current_debt' => 'decimal:2',
            'minimum_payment' => 'decimal:2',
            'interest_rate' => 'decimal:4',
            'overdue_interest_rate' => 'decimal:4',
            'last_payment_date' => 'date',
            'is_restructured' => 'boolean',
            'statement_day' => 'integer',
            'due_day' => 'integer',
        ];
    }

    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class);
    }

    public function debts(): HasMany
    {
        return $this->hasMany(Debt::class);
    }
}
