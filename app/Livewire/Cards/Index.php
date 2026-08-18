<?php

namespace App\Livewire\Cards;

use App\Models\Bank;
use App\Models\CreditCard;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public bool $showModal = false;
    public ?int $cardId = null;
    public ?int $bank_id = null;
    public string $name = '';
    public string $last_four = '';
    public float $credit_limit = 0.0;
    public float $current_debt = 0.0;
    public float $minimum_payment = 0.0;
    public int $statement_day = 1;
    public int $due_day = 10;
    public float $interest_rate = 4.25;
    public ?string $last_payment_date = null;
    public bool $is_restructured = false;

    protected $rules = [
        'bank_id' => 'required|exists:banks,id',
        'name' => 'required|string|max:100',
        'last_four' => 'nullable|string|size:4',
        'credit_limit' => 'required|numeric|min:0',
        'current_debt' => 'required|numeric|min:0',
        'minimum_payment' => 'required|numeric|min:0',
        'statement_day' => 'required|integer|between:1,31',
        'due_day' => 'required|integer|between:1,31',
        'interest_rate' => 'required|numeric|min:0',
    ];

    public function openCreateModal(): void
    {
        $this->reset(['cardId', 'bank_id', 'name', 'last_four', 'credit_limit', 'current_debt', 'minimum_payment', 'last_payment_date']);
        $this->interest_rate = 4.25;
        $this->statement_day = 1;
        $this->due_day = 10;
        $this->is_restructured = false;
        $this->showModal = true;
    }

    public function openEditModal(int $id): void
    {
        $card = CreditCard::where('user_id', Auth::id())->findOrFail($id);
        $this->cardId = $card->id;
        $this->bank_id = $card->bank_id;
        $this->name = $card->name;
        $this->last_four = $card->last_four ?? '';
        $this->credit_limit = (float) $card->credit_limit;
        $this->current_debt = (float) $card->current_debt;
        $this->minimum_payment = (float) $card->minimum_payment;
        $this->statement_day = (int) $card->statement_day;
        $this->due_day = (int) $card->due_day;
        $this->interest_rate = (float) $card->interest_rate;
        $this->last_payment_date = $card->last_payment_date ? Carbon::parse($card->last_payment_date)->format('Y-m-d') : null;
        $this->is_restructured = (bool) $card->is_restructured;
        $this->showModal = true;
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'user_id' => Auth::id(),
            'bank_id' => $this->bank_id,
            'name' => $this->name,
            'last_four' => $this->last_four ?: null,
            'credit_limit' => $this->credit_limit,
            'current_debt' => $this->current_debt,
            'minimum_payment' => $this->minimum_payment ?: ($this->current_debt * 0.40),
            'statement_day' => $this->statement_day,
            'due_day' => $this->due_day,
            'interest_rate' => $this->interest_rate,
            'last_payment_date' => $this->last_payment_date ?: null,
            'is_restructured' => $this->is_restructured,
        ];

        if ($this->cardId) {
            CreditCard::where('user_id', Auth::id())->findOrFail($this->cardId)->update($data);
        } else {
            CreditCard::create($data);
        }

        $this->showModal = false;
        $this->reset(['cardId', 'bank_id', 'name', 'last_four', 'credit_limit', 'current_debt', 'minimum_payment']);
        session()->flash('message', 'Kredi kartı başarıyla kaydedildi.');
    }

    public function delete(int $id): void
    {
        CreditCard::where('user_id', Auth::id())->findOrFail($id)->delete();
        session()->flash('message', 'Kart silindi.');
    }

    public function exportExcel()
    {
        $cards = CreditCard::where('user_id', Auth::id())->with('bank')->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="dvt_bank_kredi_kartlari_' . date('Y-m-d_His') . '.csv"',
        ];

        $callback = function () use ($cards) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($file, [
                'Banka Adı',
                'Kart Adı',
                'Son 4 Hane',
                'Kart Limiti (TL)',
                'Güncel Borç (TL)',
                'Kullanılabilir Limit (TL)',
                'Asgari Ödeme (TL)',
                'Doluluk Oranı (%)',
                'Hesap Kesim Günü',
                'Son Ödeme Günü',
                'Aylık Akdi Faiz (%)',
                'Yapılandırma Durumu',
            ], ';');

            foreach ($cards as $c) {
                $available = max(0, $c->credit_limit - $c->current_debt);
                $util = $c->credit_limit > 0 ? round(($c->current_debt / $c->credit_limit) * 100, 1) : 0;

                fputcsv($file, [
                    $c->bank?->name ?? 'Banka',
                    $c->name,
                    $c->last_four ? '•••• ' . $c->last_four : '-',
                    number_format($c->credit_limit, 2, ',', ''),
                    number_format($c->current_debt, 2, ',', ''),
                    number_format($available, 2, ',', ''),
                    number_format($c->minimum_payment ?: ($c->current_debt * 0.40), 2, ',', ''),
                    '%' . $util,
                    'Ayın ' . $c->statement_day . '. Günü',
                    'Ayın ' . $c->due_day . '. Günü',
                    '%' . number_format($c->interest_rate, 2, ',', ''),
                    $c->is_restructured ? 'Yapılandırılmış' : 'Standart',
                ], ';');
            }

            fclose($file);
        };

        return response()->streamDownload($callback, 'dvt_bank_kredi_kartlari_' . date('Y-m-d') . '.csv', $headers);
    }

    public function render()
    {
        $cards = CreditCard::where('user_id', Auth::id())->with('bank')->get();
        $banks = Bank::all();

        return view('livewire.cards.index', [
            'cards' => $cards,
            'banks' => $banks,
        ])->layout('layouts.app');
    }
}
