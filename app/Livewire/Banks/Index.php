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
        $banks = Bank::withCount(['accounts', 'creditCards', 'debts'])->get();

        return view('livewire.banks.index', [
            'banks' => $banks,
        ])->layout('layouts.app');
    }
}
