<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentPlanItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_plan_id',
        'debt_id',
        'credit_card_id',
        'priority',
        'allocated_amount',
        'month',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'priority' => 'integer',
            'allocated_amount' => 'decimal:2',
            'month' => 'date',
        ];
    }

    public function paymentPlan(): BelongsTo
    {
        return $this->belongsTo(PaymentPlan::class);
    }

    public function debt(): BelongsTo
    {
        return $this->belongsTo(Debt::class);
    }

    public function creditCard(): BelongsTo
    {
        return $this->belongsTo(CreditCard::class);
    }
}
