<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'icon',
        'type',
    ];

    protected static function booted(): void
    {
        static::creating(function ($cat) {
            if (Auth::check() && empty($cat->user_id)) {
                $cat->user_id = Auth::id();
            }
        });

        static::addGlobalScope('user_and_system', function (Builder $builder) {
            if (Auth::check()) {
                $builder->where(function ($query) {
                    $query->where('user_id', Auth::id())
                          ->orWhereNull('user_id');
                });
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function incomes(): HasMany
    {
        return $this->hasMany(Income::class);
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }
}
