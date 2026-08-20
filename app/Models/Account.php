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

class Account extends Model
{
    use HasFactory, SoftDeletes, BelongsToUser;

    protected $fillable = [
        'user_id',
        'bank_id',
        'name',
        'type',
        'iban',
        'account_number',
        'branch_code',
        'branch_name',
        'balance',
        'kmh_limit',
        'kmh_interest_rate',
        'currency',
    ];

    protected function casts(): array
    {
        return [
            'balance' => 'decimal:2',
            'kmh_limit' => 'decimal:2',
            'kmh_interest_rate' => 'decimal:4',
        ];
    }

    /**
     * Güvenli Şifrelenmiş IBAN (Key değişimi veya bozuk MAC durumunda DecryptException fırlatmaz)
     */
    protected function iban(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if (empty($value)) {
                    return null;
                }
                try {
                    return Crypt::decryptString($value);
                } catch (\Throwable $e) {
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

    /**
     * Güvenli Maskeli IBAN (Örn: TR•• •••• •••• •••• •••• ••34 56)
     */
    public function getMaskedIbanAttribute(): string
    {
        $rawIban = $this->iban;
        if (empty($rawIban)) {
            return '-';
        }

        $clean = strtoupper(preg_replace('/[^A-Za-z0-9]/', '', (string) $rawIban));
        if (str_starts_with($clean, 'TR')) {
            $clean = substr($clean, 2);
        }

        $length = strlen($clean);
        if ($length < 4) {
            return 'TR•••• ' . $clean;
        }

        $last4 = substr($clean, -4);
        return 'TR•• •••• •••• •••• •••• ••' . substr($last4, 0, 2) . ' ' . substr($last4, 2, 2);
    }

    /**
     * Tam Formatlanmış IBAN (Örn: TR12 3456 7890 1234 5678 9012 34)
     */
    public function getFormattedIbanAttribute(): string
    {
        $rawIban = $this->iban;
        if (empty($rawIban)) {
            return '-';
        }

        $clean = strtoupper(preg_replace('/[^A-Za-z0-9]/', '', (string) $rawIban));
        if (!str_starts_with($clean, 'TR')) {
            $clean = 'TR' . $clean;
        }

        return trim(chunk_split($clean, 4, ' '));
    }

    /**
     * Güvenli Maskeli Hesap No (Örn: •••• 5678)
     */
    public function getMaskedAccountNumberAttribute(): string
    {
        if (empty($this->account_number)) {
            return '-';
        }

        $digits = preg_replace('/\D/', '', (string) $this->account_number);
        $last4 = substr($digits, -4);
        return '•••• ' . $last4;
    }

    /**
     * Kullanılan KMH Tutarı (Bakiye eksi ise pozitif tutarı döner)
     */
    public function getKmhUsedAttribute(): float
    {
        return $this->balance < 0 ? abs((float) $this->balance) : 0.0;
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
