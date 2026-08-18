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
            'iban' => 'encrypted',
            'balance' => 'decimal:2',
            'kmh_limit' => 'decimal:2',
            'kmh_interest_rate' => 'decimal:4',
        ];
    }

    /**
     * Güvenli Maskeli IBAN (Örn: TR•• •••• •••• •••• •••• ••34 56)
     */
    public function getMaskedIbanAttribute(): string
    {
        if (empty($this->iban)) {
            return '-';
        }

        $clean = strtoupper(preg_replace('/[^A-Za-z0-9]/', '', (string) $this->iban));
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
        if (empty($this->iban)) {
            return '-';
        }

        $clean = strtoupper(preg_replace('/[^A-Za-z0-9]/', '', (string) $this->iban));
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

    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class);
    }

    public function debts(): HasMany
    {
        return $this->hasMany(Debt::class);
    }
}

