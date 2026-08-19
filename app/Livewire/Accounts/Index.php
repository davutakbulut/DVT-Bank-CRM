<?php

namespace App\Livewire\Accounts;

use App\Models\Account;
use App\Models\Bank;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    // Filtreleme & Arama
    public string $search = '';
    public ?int $selected_bank_id = null;
    public string $activeType = 'all'; // all, checking, kmh, savings
    public string $viewMode = 'stacked'; // stacked (banka bazlı yığın kartlar), grid (kart ızgarası), table (tablo)

    // Modal & Form
    public bool $showModal = false;
    public ?int $accountId = null;
    public ?int $bank_id = null;
    public string $name = '';
    public string $type = 'checking';
    public string $iban = '';
    public string $account_number = '';
    public string $branch_code = '';
    public string $branch_name = '';
    public float $balance = 0.0;
    public float $kmh_limit = 0.0;
    public float $kmh_interest_rate = 5.0;

    protected $rules = [
        'bank_id' => 'required|exists:banks,id',
        'name' => 'required|string|max:100',
        'type' => 'required|in:checking,savings,kmh',
        'iban' => 'nullable|string|max:34',
        'account_number' => 'nullable|string|max:30',
        'branch_code' => 'nullable|string|max:20',
        'branch_name' => 'nullable|string|max:150',
        'balance' => 'required|numeric',
        'kmh_limit' => 'nullable|numeric|min:0',
        'kmh_interest_rate' => 'nullable|numeric|min:0',
    ];

    public function resetFilters(): void
    {
        $this->reset(['search', 'selected_bank_id', 'activeType']);
    }

    public function openCreateModal(): void
    {
        $this->reset(['accountId', 'bank_id', 'name', 'type', 'iban', 'account_number', 'branch_code', 'branch_name', 'balance', 'kmh_limit']);
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
        $this->account_number = $account->account_number ?? '';
        $this->branch_code = $account->branch_code ?? '';
        $this->branch_name = $account->branch_name ?? '';
        $this->balance = (float) $account->balance;
        $this->kmh_limit = (float) ($account->kmh_limit ?? 0);
        $this->kmh_interest_rate = (float) ($account->kmh_interest_rate ?? 5.0);
        $this->showModal = true;
    }

    public function save(): void
    {
        $this->validate();

        // IBAN temizleme ve formatlama
        $cleanIban = $this->iban ? strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $this->iban)) : null;

        $data = [
            'user_id' => Auth::id(),
            'bank_id' => $this->bank_id,
            'name' => $this->name,
            'type' => $this->type,
            'iban' => $cleanIban,
            'account_number' => $this->account_number ?: null,
            'branch_code' => $this->branch_code ?: null,
            'branch_name' => $this->branch_name ?: null,
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
        $this->reset(['accountId', 'bank_id', 'name', 'type', 'iban', 'account_number', 'branch_code', 'branch_name', 'balance', 'kmh_limit']);
        session()->flash('message', 'Hesap başarıyla kaydedildi.');
    }



    public function delete(int $id): void
    {
        Account::where('user_id', Auth::id())->findOrFail($id)->delete();
        session()->flash('message', 'Hesap silindi.');
    }

    public function exportExcel()
    {
        $accounts = Account::where('user_id', Auth::id())->with('bank')->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="dvt_bank_hesaplar_' . date('Y-m-d_His') . '.csv"',
        ];

        $callback = function () use ($accounts) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($file, [
                'Banka Adı',
                'Hesap Adı',
                'Hesap Türü',
                'IBAN No',
                'Bakiye (TL)',
                'KMH Limiti (TL)',
                'Kullanılan KMH (Eksi Bakiye) (TL)',
                'Kullanılabilir Kalan Limit (TL)',
                'Aylık KMH Faiz Oranı (%)',
                'Hesap Durumu',
            ], ';');

            foreach ($accounts as $acc) {
                $isNegative = $acc->balance < 0;
                $usedKmh = $isNegative ? abs($acc->balance) : 0;
                $availableLimit = max(0, ($acc->kmh_limit ?? 0) - $usedKmh);

                $typeLabel = match($acc->type) {
                    'checking' => 'Vadesiz Mevduat Hesabı',
                    'savings' => 'Vadeli / Birikim Hesabı',
                    'kmh' => 'KMH / Eksi Bakiye Hesabı',
                    default => 'Banka Hesabı',
                };

                fputcsv($file, [
                    $acc->bank?->name ?? 'Banka',
                    $acc->name,
                    $typeLabel,
                    $acc->iban ? 'TR' . $acc->iban : '-',
                    number_format($acc->balance, 2, ',', ''),
                    number_format($acc->kmh_limit ?: 0, 2, ',', ''),
                    number_format($usedKmh, 2, ',', ''),
                    number_format($availableLimit, 2, ',', ''),
                    '%' . number_format($acc->kmh_interest_rate ?: 5.0, 2, ',', ''),
                    $isNegative ? 'Eksi Bakiyede (KMH Devrede)' : 'Artı Bakiyede (Pozitif Likidite)',
                ], ';');
            }

            fclose($file);
        };

        return response()->streamDownload($callback, 'dvt_bank_hesaplar_' . date('Y-m-d') . '.csv', $headers);
    }

    public function render()
    {
        $userId = Auth::id();
        $query = Account::where('user_id', $userId)->with('bank');

        // 1. Tür Filtresi
        if ($this->activeType !== 'all') {
            $query->where('type', $this->activeType);
        }

        // 2. Banka Filtresi
        if (!empty($this->selected_bank_id)) {
            $query->where('bank_id', $this->selected_bank_id);
        }

        // 3. Metin Arama
        if (!empty($this->search)) {
            $search = '%' . trim($this->search) . '%';
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', $search)
                  ->orWhere('iban', 'like', $search)
                  ->orWhereHas('bank', function ($bq) use ($search) {
                      $bq->where('name', 'like', $search);
                  });
            });
        }

        $accounts = $query->orderBy('balance', 'asc')->get();
        $banks = Bank::all();

        // Bankalara Göre Gruplandırılmış Hesaplar
        $groupedByBank = $accounts->groupBy('bank_id');

        // Finansal KPI Özetleri
        $totalPositive = (float) $accounts->where('balance', '>', 0)->sum('balance');
        $totalKmhDebt = (float) abs($accounts->where('balance', '<', 0)->sum('balance'));
        $totalKmhLimit = (float) $accounts->sum('kmh_limit');

        // Her bir hesaptaki kullanılabilir kalan ek hesap (KMH / Artı Para) limiti
        $totalAvailableKmh = (float) $accounts->sum(function ($acc) {
            $limit = (float) ($acc->kmh_limit ?? 0);
            if ($limit > 0) {
                return max(0, $limit + (float) $acc->balance);
            }
            return 0;
        });

        // Toplam harcanabilir / çekilebilir hazır likidite (Vadesiz Pozitif Nakit + Kalan Kullanılabilir KMH Limitleri)
        $totalAvailableLiquidity = $totalPositive + $totalAvailableKmh;
        $netLiquidity = (float) $accounts->sum('balance');

        return view('livewire.accounts.index', [
            'accounts' => $accounts,
            'groupedByBank' => $groupedByBank,
            'banks' => $banks,
            'totalPositive' => $totalPositive,
            'totalKmhDebt' => $totalKmhDebt,
            'totalKmhLimit' => $totalKmhLimit,
            'totalAvailableKmh' => $totalAvailableKmh,
            'totalAvailableLiquidity' => $totalAvailableLiquidity,
            'netLiquidity' => $netLiquidity,
        ])->layout('layouts.app');
    }
}

