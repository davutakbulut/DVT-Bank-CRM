<?php

namespace App\Models;

use App\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Crypt;

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
        'cash_advance_limit',
        'is_cash_advance_blocked',
        'current_debt',
        'minimum_payment',
        'reward_balance',
        'statement_day',
        'due_day',
        'statement_date',
        'next_statement_date',
        'next_due_date',
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
            'cash_advance_limit' => 'decimal:2',
            'is_cash_advance_blocked' => 'boolean',
            'current_debt' => 'decimal:2',
            'minimum_payment' => 'decimal:2',
            'reward_balance' => 'decimal:2',
            'interest_rate' => 'decimal:4',
            'overdue_interest_rate' => 'decimal:4',
            'statement_date' => 'date',
            'next_statement_date' => 'date',
            'next_due_date' => 'date',
            'last_payment_date' => 'date',
            'is_restructured' => 'boolean',
            'statement_day' => 'integer',
            'due_day' => 'integer',
        ];
    }

    /**
     * Güvenli Şifrelenmiş Kart Numarası (Key değişimi veya bozuk MAC durumunda DecryptException fırlatmaz)
     */
    protected function cardNumber(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if (empty($value)) {
                    return null;
                }
                try {
                    return Crypt::decryptString($value);
                } catch (\Throwable $e) {
                    // Eğer şifreli formatta (base64 JSON vb.) ise ve decrypt edilemiyorsa null dön
                    if (is_string($value) && (str_starts_with($value, 'eyJ') || str_contains($value, '"iv":') || str_contains($value, '"mac":'))) {
                        return null;
                    }
                    return $value;
                }
            },
            set: function ($value) {
                if (empty($value)) {
                    return null;
                }
                try {
                    return Crypt::encryptString((string) $value);
                } catch (\Throwable $e) {
                    return $value;
                }
            }
        );
    }

    protected static function booted(): void
    {
        static::saving(function (CreditCard $card) {
            $rawNumber = $card->card_number;
            if (!empty($rawNumber)) {
                $digits = preg_replace('/\D/', '', (string) $rawNumber);
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
            if (!empty($digits)) {
                $last4 = substr($digits, -4);
            }
        }

        return $last4 ? '•••• •••• •••• ' . $last4 : '•••• •••• •••• ••••';
    }

    /**
     * Formatlanmış 16 Haneli Kart Numarası (Örn: 5400 1234 5678 9012)
     */
    public function getFormattedCardNumberAttribute(): string
    {
        $num = $this->card_number;
        if (empty($num)) {
            return $this->masked_card_number;
        }

        $digits = preg_replace('/\D/', '', (string) $num);
        if (empty($digits)) {
            return $this->masked_card_number;
        }
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

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }
}
