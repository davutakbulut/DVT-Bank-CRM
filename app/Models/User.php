<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'plan_id',
        'status',
        'monthly_income',
        'onboarding_completed',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
            'monthly_income' => 'decimal:2',
            'onboarding_completed' => 'boolean',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() === 'super') {
            return $this->hasRole('super_admin');
        }

        if ($panel->getId() === 'admin') {
            return $this->hasRole('admin') || $this->hasRole('super_admin');
        }

        return true;
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function banks(): HasMany
    {
        return $this->hasMany(Bank::class);
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

    public function paymentLogs(): HasMany
    {
        return $this->hasMany(PaymentLog::class);
    }

    public function incomes(): HasMany
    {
        return $this->hasMany(Income::class);
    }

    public function expectedIncomes(): HasMany
    {
        return $this->hasMany(ExpectedIncome::class);
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    public function paymentPlans(): HasMany
    {
        return $this->hasMany(PaymentPlan::class);
    }

    public function reminders(): HasMany
    {
        return $this->hasMany(Reminder::class);
    }

    public function goals(): HasMany
    {
        return $this->hasMany(Goal::class);
    }

    public function aiAdvices(): HasMany
    {
        return $this->hasMany(AiAdvice::class);
    }

    public function aiChatMessages(): HasMany
    {
        return $this->hasMany(AiChatMessage::class);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function supportTickets(): HasMany
    {
        return $this->hasMany(SupportTicket::class);
    }

    public function currentPlan(): Plan
    {
        if ($this->relationLoaded('plan') && $this->plan) {
            return $this->plan;
        }

        if ($this->plan_id && $plan = Plan::find($this->plan_id)) {
            return $plan;
        }

        return Plan::where('slug', 'free')->first() ?? new Plan([
            'name' => 'Ücretsiz Plan',
            'slug' => 'free',
            'max_banks' => 2,
            'max_debts' => 5,
            'ai_frequency' => 'weekly',
            'features' => [],
        ]);
    }

    public function canCreateBank(): bool
    {
        if ($this->hasRole('super_admin') || $this->hasRole('admin')) {
            return true;
        }

        $plan = $this->currentPlan();
        if ($plan->max_banks === -1) {
            return true;
        }

        $userBankCount = $this->banks()->where('is_system', false)->count();
        return $userBankCount < $plan->max_banks;
    }

    public function canCreateDebt(): bool
    {
        if ($this->hasRole('super_admin') || $this->hasRole('admin')) {
            return true;
        }

        $plan = $this->currentPlan();
        if ($plan->max_debts === -1) {
            return true;
        }

        return $this->debts()->count() < $plan->max_debts;
    }

    public function canGenerateAiAdvice(): bool
    {
        if ($this->hasRole('super_admin') || $this->hasRole('admin')) {
            return true;
        }

        $plan = $this->currentPlan();
        $frequency = $plan->ai_frequency ?? 'weekly';

        if ($frequency === 'daily') {
            return !$this->aiAdvices()->whereDate('created_at', now()->today())->exists();
        }

        return !$this->aiAdvices()->where('created_at', '>=', now()->subDays(7))->exists();
    }

    public function hasFeature(string $featureKey): bool
    {
        if ($this->hasRole('super_admin') || $this->hasRole('admin')) {
            return true;
        }

        $plan = $this->currentPlan();
        if ($plan->slug === 'pro') {
            return true;
        }

        $features = $plan->features ?? [];
        return !empty($features[$featureKey]);
    }

    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new \App\Notifications\CustomResetPasswordNotification($token));
    }
}
