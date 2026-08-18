<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-gray-900 tracking-tight">Hesaplarım & KMH (Ek Para)</h1>
            <p class="text-sm text-gray-600">Vadesiz hesaplarınız, kredili mevduat (KMH) ve ek para bakiyeleriniz</p>
        </div>
        <button wire:click="openCreateModal" class="inline-flex items-center px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm rounded-xl shadow-sm transition-colors">
            + Yeni Hesap Ekle
        </button>
    </div>

    @if (session()->has('message'))
        <div class="p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl text-sm font-medium">
            ✓ {{ session('message') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50 text-gray-500 font-semibold text-xs text-left">
                    <tr>
                        <th class="px-6 py-3.5">Banka & Hesap Adı</th>
                        <th class="px-6 py-3.5">Hesap Türü</th>
                        <th class="px-6 py-3.5">Bakiye</th>
                        <th class="px-6 py-3.5">KMH Limiti</th>
                        <th class="px-6 py-3.5">KMH Faizi</th>
                        <th class="px-6 py-3.5 text-right">İşlemler</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse ($accounts as $acc)
                        <tr class="hover:bg-gray-50/70 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <span class="w-8 h-8 rounded-lg flex items-center justify-center text-white text-xs font-bold shadow-sm" style="background-color: {{ $acc->bank?->color ?? '#6366f1' }}">
                                        {{ mb_substr($acc->bank?->name ?? 'B', 0, 2) }}
                                    </span>
                                    <div>
                                        <span class="font-bold text-gray-900 block">{{ $acc->name }}</span>
                                        <span class="text-xs text-gray-500">{{ $acc->bank?->name }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $acc->type === 'kmh' ? 'bg-red-100 text-red-700' : 'bg-blue-50 text-blue-700' }}">
                                    {{ $acc->type === 'kmh' ? 'KMH / Ek Hesap' : ($acc->type === 'savings' ? 'Vadeli' : 'Vadesiz') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 font-black {{ $acc->balance < 0 ? 'text-red-600' : 'text-emerald-600' }}">
                                ₺{{ number_format($acc->balance, 2, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-gray-700 font-semibold">
                                {{ $acc->kmh_limit ? '₺' . number_format($acc->kmh_limit, 2, ',', '.') : '-' }}
                            </td>
                            <td class="px-6 py-4 text-gray-700">
                                {{ $acc->kmh_interest_rate ? '%' . number_format($acc->kmh_interest_rate, 2) : '-' }}
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <button wire:click="openEditModal({{ $acc->id }})" class="text-indigo-600 hover:text-indigo-900 font-semibold text-xs">Düzenle</button>
                                <button wire:click="delete({{ $acc->id }})" wire:confirm="Bu hesabı silmek istediğinize emin misiniz?" class="text-red-600 hover:text-red-900 font-semibold text-xs">Sil</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                Kayıtlı hesap bulunmamaktadır.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL -->
    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
            <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl space-y-4">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <h3 class="font-bold text-lg text-gray-900">{{ $accountId ? 'Hesabı Düzenle' : 'Yeni Hesap Ekle' }}</h3>
                    <button wire:click="$set('showModal', false)" class="text-gray-400 hover:text-gray-600 font-bold">✕</button>
                </div>

                <div class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Banka</label>
                            <select wire:model="bank_id" class="w-full rounded-xl border-gray-300 text-sm font-medium">
                                <option value="">Banka Seçin</option>
                                @foreach ($banks as $b)
                                    <option value="{{ $b->id }}">{{ $b->name }}</option>
                                @endforeach
                            </select>
                            @error('bank_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Hesap Türü</label>
                            <select wire:model.live="type" class="w-full rounded-xl border-gray-300 text-sm font-medium">
                                <option value="checking">Vadesiz Mevduat</option>
                                <option value="kmh">KMH / Ek Hesap (Eksi Bakiye)</option>
                                <option value="savings">Vadeli Mevduat</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Hesap Adı / Etiketi</label>
                        <input type="text" wire:model="name" class="w-full rounded-xl border-gray-300 text-sm font-medium" placeholder="Örn: Maaş Hesabı veya Artı Para">
                        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Güncel Bakiye (Eksi ise eksi olarak girin, örn: -50000)</label>
                        <input type="number" step="0.01" wire:model="balance" class="w-full rounded-xl border-gray-300 text-sm font-bold">
                        @error('balance') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    @if ($type === 'kmh')
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 p-3 bg-red-50/50 rounded-xl border border-red-100">
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">KMH Limiti (TL)</label>
                                <input type="number" step="0.01" wire:model="kmh_limit" class="w-full rounded-xl border-gray-300 text-sm font-semibold" placeholder="50000">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">Aylık KMH Akdi Faizi (%)</label>
                                <input type="number" step="0.01" wire:model="kmh_interest_rate" class="w-full rounded-xl border-gray-300 text-sm font-semibold" placeholder="5.00">
                            </div>
                        </div>
                    @endif
                </div>

                <div class="flex justify-end gap-3 pt-3">
                    <button wire:click="$set('showModal', false)" class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl">
                        İptal
                    </button>
                    <button wire:click="save" class="px-5 py-2 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-sm">
                        Kaydet
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
