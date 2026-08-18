<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Bank extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'logo',
        'color',
        'is_system',
    ];

    protected function casts(): array
    {
        return [
            'is_system' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function ($bank) {
            if (Auth::check() && empty($bank->user_id) && !$bank->is_system) {
                $bank->user_id = Auth::id();
            }
        });

        // Kullanıcılar sistem bankalarını + kendi tanımladıkları bankaları görür
        static::addGlobalScope('user_and_system', function (Builder $builder) {
            if (Auth::check()) {
                $builder->where(function ($query) {
                    $query->where('user_id', Auth::id())
                          ->orWhere('is_system', true);
                });
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function accounts(): HasMany
    {
        return $this->hasMany(Account::class);
    }

    public function creditCards(): HasMany
    {
        return $this->hasMany(CreditCard::class);
    }

    public function debts(): HasMany
    {
        return $this->hasMany(Debt::class);
    }
}
