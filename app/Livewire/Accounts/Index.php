<?php

namespace App\Livewire\Accounts;

use App\Models\Account;
use App\Models\Bank;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public bool $showModal = false;
    public ?int $accountId = null;
    public ?int $bank_id = null;
    public string $name = '';
    public string $type = 'checking';
    public string $iban = '';
    public float $balance = 0.0;
    public float $kmh_limit = 0.0;
    public float $kmh_interest_rate = 5.0;

    protected $rules = [
        'bank_id' => 'required|exists:banks,id',
        'name' => 'required|string|max:100',
        'type' => 'required|in:checking,savings,kmh',
        'iban' => 'nullable|string|max:34',
        'balance' => 'required|numeric',
        'kmh_limit' => 'nullable|numeric|min:0',
        'kmh_interest_rate' => 'nullable|numeric|min:0',
    ];

    public function openCreateModal(): void
    {
        $this->reset(['accountId', 'bank_id', 'name', 'type', 'iban', 'balance', 'kmh_limit']);
        $this->kmh_interest_rate = 5.0;
        $this->type = 'checking';
        $this->showModal = true;
    }

    public function openEditModal(int $id): void
    {
        $account = Account::where('user_id', Auth::id())->findOrFail($id);
        $this->accountId = $account->id;
        $this->bank_id = $account->bank_id;
        $this->name = $account->name;
        $this->type = $account->type;
        $this->iban = $account->iban ?? '';
        $this->balance = (float) $account->balance;
        $this->kmh_limit = (float) ($account->kmh_limit ?? 0);
        $this->kmh_interest_rate = (float) ($account->kmh_interest_rate ?? 5.0);
        $this->showModal = true;
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'user_id' => Auth::id(),
            'bank_id' => $this->bank_id,
            'name' => $this->name,
            'type' => $this->type,
            'iban' => $this->iban ?: null,
            'balance' => $this->balance,
            'kmh_limit' => $this->type === 'kmh' ? $this->kmh_limit : null,
            'kmh_interest_rate' => $this->type === 'kmh' ? $this->kmh_interest_rate : null,
        ];

        if ($this->accountId) {
            Account::where('user_id', Auth::id())->findOrFail($this->accountId)->update($data);
        } else {
            Account::create($data);
        }

        $this->showModal = false;
        $this->reset(['accountId', 'bank_id', 'name', 'type', 'iban', 'balance', 'kmh_limit']);
        session()->flash('message', 'Hesap başarıyla kaydedildi.');
    }

    public function delete(int $id): void
    {
        Account::where('user_id', Auth::id())->findOrFail($id)->delete();
        session()->flash('message', 'Hesap silindi.');
    }

    public function render()
    {
        $accounts = Account::where('user_id', Auth::id())->with('bank')->get();
        $banks = Bank::all();

        return view('livewire.accounts.index', [
            'accounts' => $accounts,
            'banks' => $banks,
        ])->layout('layouts.app');
    }
}
