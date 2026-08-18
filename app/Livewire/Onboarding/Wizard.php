<?php

namespace App\Livewire\Onboarding;

use App\Models\Account;
use App\Models\Bank;
use App\Models\CreditCard;
use App\Models\Debt;
use App\Services\RiskCounter;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Wizard extends Component
{
    public int $step = 1;
    public float $monthly_income = 0.0;
    
    // Seçilen sistem banka id'leri
    public array $selected_banks = [];

    // Hızlı borç giriş form verileri: [bank_id => ['has_card' => true, 'card_debt' => ..., 'has_kmh' => true, ...]]
    public array $bank_data = [];

    public function mount(): void
    {
        $user = Auth::user();
        if ($user->onboarding_completed) {
            redirect()->route('dashboard');
        }

        $this->monthly_income = (float) ($user->monthly_income ?? 0);
    }

    public function nextStep(): void
    {
        if ($this->step === 1) {
            $this->validate([
                'monthly_income' => 'required|numeric|min:0',
            ], [
                'monthly_income.required' => 'Lütfen tahmini aylık net gelirinizi girin.',
            ]);

            Auth::user()->update([
                'monthly_income' => $this->monthly_income,
            ]);

            $this->step = 2;
        } elseif ($this->step === 2) {
            $this->validate([
                'selected_banks' => 'required|array|min:1',
            ], [
                'selected_banks.min' => 'Lütfen borcunuzun veya hesabınızın bulunduğu en az bir banka seçin.',
            ]);

            // Form alanlarını initialize et
            foreach ($this->selected_banks as $bankId) {
                if (!isset($this->bank_data[$bankId])) {
                    $this->bank_data[$bankId] = [
                        'has_card' => false,
                        'card_name' => 'Kredi Kartı',
                        'card_debt' => 0,
                        'card_min' => 0,
                        'card_overdue_days' => 0,
                        'has_kmh' => false,
                        'kmh_balance' => 0,
                        'kmh_limit' => 0,
                        'has_loan' => false,
                        'loan_remaining' => 0,
                        'loan_installment' => 0,
                    ];
                }
            }

            $this->step = 3;
        } elseif ($this->step === 3) {
            $this->saveDebts();
            $this->step = 4;
        }
    }

    public function previousStep(): void
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }

    public function toggleBank(int $bankId): void
    {
        if (in_array($bankId, $this->selected_banks)) {
            $this->selected_banks = array_diff($this->selected_banks, [$bankId]);
        } else {
            $this->selected_banks[] = $bankId;
        }
    }

    public function saveDebts(): void
    {
        $user = Auth::user();

        foreach ($this->selected_banks as $bankId) {
            $data = $this->bank_data[$bankId] ?? null;
            if (!$data) continue;

            $bank = Bank::find($bankId);
            if (!$bank) continue;

            // 1. Kredi Kartı
            if (!empty($data['has_card']) && (float) $data['card_debt'] > 0) {
                $card = CreditCard::create([
                    'user_id' => $user->id,
                    'bank_id' => $bankId,
                    'name' => $bank->name . ' Kartı',
                    'current_debt' => (float) $data['card_debt'],
                    'minimum_payment' => (float) ($data['card_min'] ?: ($data['card_debt'] * 0.40)),
                    'credit_limit' => (float) ($data['card_debt'] * 1.2),
                    'last_payment_date' => Carbon::now()->subDays((int) ($data['card_overdue_days'] ?? 0)),
                ]);

                Debt::create([
                    'user_id' => $user->id,
                    'bank_id' => $bankId,
                    'credit_card_id' => $card->id,
                    'type' => 'credit_card',
                    'title' => $bank->name . ' Kart Borcu',
                    'principal' => (float) $data['card_debt'],
                    'remaining' => (float) $data['card_debt'],
                    'interest_rate' => 4.2500,
                    'last_payment_date' => Carbon::now()->subDays((int) ($data['card_overdue_days'] ?? 0)),
                    'days_overdue' => (int) ($data['card_overdue_days'] ?? 0),
                    'next_due_date' => Carbon::now()->addDays(7),
                ]);
            }

            // 2. KMH / Ek Hesap
            if (!empty($data['has_kmh']) && (float) $data['kmh_balance'] > 0) {
                $account = Account::create([
                    'user_id' => $user->id,
                    'bank_id' => $bankId,
                    'name' => $bank->name . ' KMH / Ek Hesap',
                    'type' => 'kmh',
                    'balance' => -1 * abs((float) $data['kmh_balance']),
                    'kmh_limit' => (float) ($data['kmh_limit'] ?: $data['kmh_balance']),
                    'kmh_interest_rate' => 5.0000,
                ]);

                Debt::create([
                    'user_id' => $user->id,
                    'bank_id' => $bankId,
                    'account_id' => $account->id,
                    'type' => 'kmh',
                    'title' => $bank->name . ' KMH Borcu',
                    'principal' => (float) $data['kmh_balance'],
                    'remaining' => (float) $data['kmh_balance'],
                    'interest_rate' => 5.0000,
                    'next_due_date' => Carbon::now()->addDays(5),
                ]);
            }

            // 3. İhtiyaç Kredisi
            if (!empty($data['has_loan']) && (float) $data['loan_remaining'] > 0) {
                Debt::create([
                    'user_id' => $user->id,
                    'bank_id' => $bankId,
                    'type' => 'loan',
                    'title' => $bank->name . ' Kredi',
                    'principal' => (float) $data['loan_remaining'],
                    'remaining' => (float) $data['loan_remaining'],
                    'installment_amount' => (float) ($data['loan_installment'] ?: ($data['loan_remaining'] / 12)),
                    'interest_rate' => 3.9000,
                    'next_due_date' => Carbon::now()->addDays(10),
                ]);
            }
        }
    }

    public function completeOnboarding(): void
    {
        $user = Auth::user();
        $user->update(['onboarding_completed' => true]);

        session()->flash('success', 'Tebrikler! Finansal kurtarma ve takip kontrol paneliniz hazırlandı.');
        redirect()->route('dashboard');
    }

    public function render()
    {
        $systemBanks = Bank::where('is_system', true)->get();
        $riskSummary = null;

        if ($this->step === 4) {
            $riskSummary = (new RiskCounter())->calculateUserRiskSummary(Auth::user());
        }

        return view('livewire.onboarding.wizard', [
            'systemBanks' => $systemBanks,
            'riskSummary' => $riskSummary,
        ])->layout('layouts.app');
    }
}
