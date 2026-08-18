<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-gray-900 tracking-tight">Borçlarım & Kredilerim</h1>
            <p class="text-sm text-gray-600">Tüm banka kredileri, KMH borçları ve yasal takip sayaçları</p>
        </div>
        <button wire:click="openCreateModal" class="inline-flex items-center px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm rounded-xl shadow-sm transition-colors">
            + Yeni Borç Ekle
        </button>
    </div>

    @if (session()->has('message'))
        <div class="p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl text-sm font-medium">
            ✓ {{ session('message') }}
        </div>
    @endif

    <!-- Sekmeler -->
    <div class="flex items-center gap-2 border-b border-gray-200 overflow-x-auto pb-1">
        <button wire:click="$set('activeTab', 'all')" class="px-4 py-2 text-sm font-bold rounded-xl transition-colors {{ $activeTab === 'all' ? 'bg-indigo-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
            Tümü ({{ $debts->count() }})
        </button>
        <button wire:click="$set('activeTab', 'loan')" class="px-4 py-2 text-sm font-bold rounded-xl transition-colors {{ $activeTab === 'loan' ? 'bg-indigo-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
            Krediler
        </button>
        <button wire:click="$set('activeTab', 'credit_card')" class="px-4 py-2 text-sm font-bold rounded-xl transition-colors {{ $activeTab === 'credit_card' ? 'bg-indigo-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
            Kart Borçları
        </button>
        <button wire:click="$set('activeTab', 'kmh')" class="px-4 py-2 text-sm font-bold rounded-xl transition-colors {{ $activeTab === 'kmh' ? 'bg-indigo-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
            KMH / Ek Hesap
        </button>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50 text-gray-500 font-semibold text-xs text-left">
                    <tr>
                        <th class="px-6 py-3.5">Banka & Borç Başlığı</th>
                        <th class="px-6 py-3.5">Tür</th>
                        <th class="px-6 py-3.5">Kalan Borç</th>
                        <th class="px-6 py-3.5">Aylık Faiz %</th>
                        <th class="px-6 py-3.5">Aylık Taksit</th>
                        <th class="px-6 py-3.5">90 Gün Takip Durumu</th>
                        <th class="px-6 py-3.5 text-right">İşlemler</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse ($debts as $debt)
                        @php
                            $daysLeft = max(0, 90 - $debt->days_overdue);
                            $isCritical = $daysLeft <= 25;
                        @endphp
                        <tr class="hover:bg-gray-50/70 transition-colors {{ $isCritical ? 'bg-red-50/30' : '' }}">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <span class="w-8 h-8 rounded-lg flex items-center justify-center text-white text-xs font-bold shadow-sm" style="background-color: {{ $debt->bank?->color ?? '#6366f1' }}">
                                        {{ mb_substr($debt->bank?->name ?? 'B', 0, 2) }}
                                    </span>
                                    <div>
                                        <span class="font-bold text-gray-900 block">{{ $debt->title }}</span>
                                        <span class="text-xs text-gray-500">{{ $debt->bank?->name ?? 'Diğer' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-0.5 rounded-full text-xs font-bold {{ $debt->type === 'kmh' ? 'bg-red-100 text-red-700' : ($debt->type === 'credit_card' ? 'bg-amber-100 text-amber-700' : 'bg-blue-50 text-blue-700') }}">
                                    {{ $debt->type === 'kmh' ? 'KMH' : ($debt->type === 'credit_card' ? 'Kredi Kartı' : 'Kredi') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 font-black text-red-600">
                                ₺{{ number_format($debt->remaining, 2, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-700">
                                %{{ number_format($debt->interest_rate, 2) }}
                            </td>
                            <td class="px-6 py-4 text-gray-900 font-semibold">
                                {{ $debt->installment_amount ? '₺' . number_format($debt->installment_amount, 2, ',', '.') : '-' }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <span class="px-2.5 py-1 rounded-md text-xs font-black {{ $isCritical ? 'bg-red-600 text-white animate-pulse' : ($debt->days_overdue > 0 ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-emerald-800') }}">
                                        {{ $daysLeft }} Gün Kaldı
                                    </span>
                                    @if ($debt->days_overdue > 0)
                                        <span class="text-[11px] text-gray-500">({{ $debt->days_overdue }} gün gecikme)</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <button wire:click="openEditModal({{ $debt->id }})" class="text-indigo-600 hover:text-indigo-900 font-semibold text-xs">Düzenle</button>
                                <button wire:click="delete({{ $debt->id }})" wire:confirm="Bu borcu silmek istediğinize emin misiniz?" class="text-red-600 hover:text-red-900 font-semibold text-xs">Sil</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                Bu kategoride borç bulunmamaktadır.
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
            <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl space-y-4 max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <h3 class="font-bold text-lg text-gray-900">{{ $debtId ? 'Borcu Düzenle' : 'Yeni Borç Ekle' }}</h3>
                    <button wire:click="$set('showModal', false)" class="text-gray-400 hover:text-gray-600 font-bold">✕</button>
                </div>

                <div class="space-y-3">
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Banka</label>
                            <select wire:model="bank_id" class="w-full rounded-xl border-gray-300 text-sm font-medium">
                                <option value="">Banka Seçin</option>
                                @foreach ($banks as $b)
                                    <option value="{{ $b->id }}">{{ $b->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Borç Türü</label>
                            <select wire:model="type" class="w-full rounded-xl border-gray-300 text-sm font-medium">
                                <option value="loan">İhtiyaç / Taşıt Kredisi</option>
                                <option value="kmh">KMH (Ek Hesap / Avans)</option>
                                <option value="credit_card">Kredi Kartı Borcu</option>
                                <option value="personal">Şahıs / Diğer Borç</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Borç Başlığı / Açıklama</label>
                        <input type="text" wire:model="title" class="w-full rounded-xl border-gray-300 text-sm font-medium" placeholder="Örn: Garanti İhtiyaç Kredisi">
                        @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Kalan Ana Borç (TL)</label>
                            <input type="number" step="0.01" wire:model="remaining" class="w-full rounded-xl border-gray-300 text-sm font-bold text-red-600">
                            @error('remaining') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Aylık Faiz Oranı (%)</label>
                            <input type="number" step="0.01" wire:model="interest_rate" class="w-full rounded-xl border-gray-300 text-sm">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Aylık Taksit Tutarı (TL)</label>
                            <input type="number" step="0.01" wire:model="installment_amount" class="w-full rounded-xl border-gray-300 text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Kaç Gündür Gecikmede?</label>
                            <input type="number" wire:model="days_overdue" class="w-full rounded-xl border-gray-300 text-sm" placeholder="0">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Strateji / Takip Notu</label>
                        <textarea wire:model="notes" rows="2" class="w-full rounded-xl border-gray-300 text-xs" placeholder="Örn: Banka arandı, 36 ay yapılandırma istendi"></textarea>
                    </div>
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
