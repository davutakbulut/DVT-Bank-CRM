<?php

namespace App\Models;

use App\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use HasFactory, SoftDeletes, BelongsToUser;

    protected $fillable = [
        'user_id',
        'bank_id',
        'name',
        'type',
        'iban',
        'balance',
        'kmh_limit',
        'kmh_interest_rate',
        'currency',
    ];

    protected function casts(): array
    {
        return [
            'iban' => 'encrypted',
            'balance' => 'decimal:2',
            'kmh_limit' => 'decimal:2',
            'kmh_interest_rate' => 'decimal:4',
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
