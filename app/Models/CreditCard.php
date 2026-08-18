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
        'card_number',
        'card_holder',
        'expiry_date',
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
            'card_number' => 'encrypted',
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

    protected static function booted(): void
    {
        static::saving(function (CreditCard $card) {
            if (!empty($card->card_number)) {
                $digits = preg_replace('/\D/', '', (string) $card->card_number);
                if (strlen($digits) >= 4) {
                    $card->last_four = substr($digits, -4);
                }
            }
        });
    }

    /**
     * Güvenli Maskeli Kart Numarası (Örn: •••• •••• •••• 4589)
     */
    public function getMaskedCardNumberAttribute(): string
    {
        $last4 = $this->last_four;
        if (empty($last4) && !empty($this->card_number)) {
            $digits = preg_replace('/\D/', '', (string) $this->card_number);
            $last4 = substr($digits, -4);
        }

        return $last4 ? '•••• •••• •••• ' . $last4 : '•••• •••• •••• ••••';
    }

    /**
     * Formatlanmış 16 Haneli Kart Numarası (Örn: 5400 1234 5678 9012)
     */
    public function getFormattedCardNumberAttribute(): string
    {
        if (empty($this->card_number)) {
            return $this->masked_card_number;
        }

        $digits = preg_replace('/\D/', '', (string) $this->card_number);
        return trim(chunk_split($digits, 4, ' '));
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

