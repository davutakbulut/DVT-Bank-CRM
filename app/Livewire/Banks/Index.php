<?php

namespace App\Livewire\Banks;

use App\Models\Bank;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public bool $showModal = false;
    public ?int $bankId = null;
    public string $name = '';
    public string $color = '#6366f1';

    protected $rules = [
        'name' => 'required|string|max:100',
        'color' => 'nullable|string|max:7',
    ];

    public function openCreateModal(): void
    {
        if (!Auth::user()->canCreateBank()) {
            session()->flash('error', 'Ücretsiz planınız maksimum 2 banka eklemenize izin vermektedir. Sınırsız banka eklemek için Pro Plana geçin.');
            return;
        }

        $this->reset(['bankId', 'name', 'color']);
        $this->color = '#6366f1';
        $this->showModal = true;
    }

    public function openEditModal(int $id): void
    {
        $bank = Bank::where('user_id', Auth::id())->findOrFail($id);
        $this->bankId = $bank->id;
        $this->name = $bank->name;
        $this->color = $bank->color ?? '#6366f1';
        $this->showModal = true;
    }

    public function save(): void
    {
        $this->validate();

        if ($this->bankId) {
            $bank = Bank::where('user_id', Auth::id())->findOrFail($this->bankId);
            $bank->update([
                'name' => $this->name,
                'color' => $this->color,
            ]);
        } else {
            if (!Auth::user()->canCreateBank()) {
                $this->addError('name', 'Ücretsiz planınız maksimum 2 banka eklemenize izin vermektedir. Sınırsız banka eklemek için Pro Plana geçin.');
                return;
            }

            Bank::create([
                'user_id' => Auth::id(),
                'name' => $this->name,
                'color' => $this->color,
                'is_system' => false,
            ]);
        }

        $this->showModal = false;
        $this->reset(['bankId', 'name', 'color']);
        session()->flash('message', 'Banka başarıyla kaydedildi.');
    }

    public function delete(int $id): void
    {
        $bank = Bank::where('user_id', Auth::id())->findOrFail($id);
        $bank->delete();
        session()->flash('message', 'Özel banka silindi.');
    }

    public function render()
    {
        $user = Auth::user();
        $banks = Bank::withCount(['accounts', 'creditCards', 'debts'])->get();
        $userBankCount = $user->banks()->where('is_system', false)->count();
        $maxBanks = $user->currentPlan()->max_banks;

        return view('livewire.banks.index', [
            'banks' => $banks,
            'userBankCount' => $userBankCount,
            'maxBanks' => $maxBanks,
            'canCreateBank' => $user->canCreateBank(),
        ])->layout('layouts.app');
    }
}
