<?php

namespace App\Models;

use App\Traits\BelongsToUser;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpectedIncome extends Model
{
    use HasFactory, SoftDeletes, BelongsToUser;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'amount',
        'type',
        'frequency',
        'expected_day',
        'expected_date',
        'status',
        'last_confirmed_date',
        'is_active',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'expected_day' => 'integer',
            'expected_date' => 'date',
            'last_confirmed_date' => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeDueForConfirmation(Builder $query): Builder
    {
        return $query->where('is_active', true)
            ->whereIn('status', ['pending', 'delayed'])
            ->where('expected_date', '<=', Carbon::now()->format('Y-m-d'));
    }

    public function scopeUpcoming(Builder $query, int $days = 15): Builder
    {
        $today = Carbon::now()->format('Y-m-d');
        $future = Carbon::now()->addDays($days)->format('Y-m-d');

        return $query->where('is_active', true)
            ->where('expected_date', '>=', $today)
            ->where('expected_date', '<=', $future)
            ->orderBy('expected_date', 'asc');
    }

    /**
     * Gelirin hesaba geçtiğini onaylar, gerçek Income kaydı üretir ve tekrarlayan ise tarihi ilerletir.
     */
    public function confirmReceived(?string $receivedDate = null): Income
    {
        $date = $receivedDate ?: Carbon::now()->format('Y-m-d');

        // 1. Gerçek Incomes tablosuna kayıt oluştur
        $income = Income::create([
            'user_id' => $this->user_id,
            'category_id' => $this->category_id,
            'title' => $this->title,
            'amount' => $this->amount,
            'income_date' => $date,
            'type' => in_array($this->type, ['salary', 'freelance', 'rental', 'other']) ? $this->type : 'other',
            'frequency' => $this->frequency === 'monthly' ? 'monthly' : 'once',
            'received_day' => $this->expected_day,
            'is_recurring' => $this->frequency === 'monthly',
        ]);

        // 2. Beklenen Gelir Durumunu Güncelle
        $this->last_confirmed_date = $date;

        if ($this->frequency === 'monthly') {
            $currentDate = $this->expected_date ? Carbon::parse($this->expected_date) : Carbon::now();
            $this->expected_date = $currentDate->copy()->addMonthNoOverflow()->format('Y-m-d');
            $this->status = 'pending';
        } elseif ($this->frequency === 'weekly') {
            $currentDate = $this->expected_date ? Carbon::parse($this->expected_date) : Carbon::now();
            $this->expected_date = $currentDate->copy()->addWeek()->format('Y-m-d');
            $this->status = 'pending';
        } else {
            $this->status = 'received';
        }

        $this->save();

        return $income;
    }

    /**
     * Gelirin geciktiğini işaretler ve tarihi öteler.
     */
    public function markDelayed(int $delayDays = 3): void
    {
        $currentDate = $this->expected_date ? Carbon::parse($this->expected_date) : Carbon::now();
        $this->expected_date = $currentDate->copy()->addDays($delayDays)->format('Y-m-d');
        $this->status = 'delayed';
        $this->save();
    }

    /**
     * Gelirin iptal edildiğini işaretler.
     */
    public function markCancelled(): void
    {
        $this->status = 'cancelled';
        $this->save();
    }
}
