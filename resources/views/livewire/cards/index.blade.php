<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-gray-900 tracking-tight">Kredi Kartlarım</h1>
            <p class="text-sm text-gray-600">Kart limitleri, dönem borçları, asgari ödemeler ve gecikme sayaçları</p>
        </div>
        <button wire:click="openCreateModal" class="inline-flex items-center px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm rounded-xl shadow-sm transition-colors">
            + Yeni Kart Ekle
        </button>
    </div>

    @if (session()->has('message'))
        <div class="p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl text-sm font-medium">
            ✓ {{ session('message') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($cards as $card)
            @php
                $daysOverdue = 0;
                if ($card->last_payment_date) {
                    $daysOverdue = (int) \Carbon\Carbon::parse($card->last_payment_date)->diffInDays(now());
                }
                $daysToLegal = max(0, 90 - $daysOverdue);
                $isNearLegal = $daysToLegal <= 25;
            @endphp
            <div class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-950 text-white p-6 rounded-3xl shadow-xl relative overflow-hidden flex flex-col justify-between min-h-[220px]">
                <!-- Üst: Banka & Çip -->
                <div class="flex items-start justify-between">
                    <div>
                        <span class="text-xs font-black uppercase tracking-widest text-slate-400 block">{{ $card->bank?->name }}</span>
                        <h3 class="text-lg font-bold text-white mt-0.5">{{ $card->name }}</h3>
                    </div>
                    <div class="w-10 h-7 rounded-md bg-amber-400/80 border border-amber-300 flex items-center justify-center text-[10px] font-mono text-amber-950 font-bold shadow-inner">
                        CHIP
                    </div>
                </div>

                <!-- Orta: Kart Numarası & Risk Rozeti -->
                <div class="my-4 space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="font-mono text-base tracking-widest text-slate-300">•••• •••• •••• {{ $card->last_four ?: '0000' }}</span>
                        @if ($daysOverdue > 0)
                            <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold {{ $isNearLegal ? 'bg-red-500/90 text-white animate-pulse' : 'bg-amber-500/80 text-black' }}">
                                {{ $daysOverdue }} Gündür Ödeme Yok ({{ $daysToLegal }} Gün Kaldı)
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Alt: Borç ve Limit Bilgileri -->
                <div class="pt-3 border-t border-slate-700/60 flex items-end justify-between">
                    <div>
                        <span class="text-[10px] font-bold text-slate-400 block">DÖNEM BORCU / ASGARİ</span>
                        <div class="flex items-baseline gap-2">
                            <span class="text-xl font-black text-red-400">₺{{ number_format($card->current_debt, 2, ',', '.') }}</span>
                            <span class="text-xs font-semibold text-slate-300">/ ₺{{ number_format($card->minimum_payment, 2, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-1">
                        <button wire:click="openEditModal({{ $card->id }})" class="p-1.5 bg-slate-700/60 hover:bg-slate-700 text-slate-300 hover:text-white rounded-lg text-xs font-bold">✎</button>
                        <button wire:click="delete({{ $card->id }})" wire:confirm="Bu kartı silmek istediğinize emin misiniz?" class="p-1.5 bg-red-900/40 hover:bg-red-800 text-red-300 rounded-lg text-xs font-bold">🗑</button>
                    </div>
                </div>

                <!-- Banka Vurgu Çizgisi -->
                <div class="absolute top-0 right-0 left-0 h-1" style="background-color: {{ $card->bank?->color ?? '#6366f1' }}"></div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-3xl p-12 text-center border-2 border-dashed border-gray-200 space-y-4">
                <div class="w-16 h-16 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center mx-auto text-3xl">
                    💳
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Henüz Kayıtlı Kredi Kartınız Yok</h3>
                    <p class="text-sm text-gray-500 max-w-md mx-auto mt-1">
                        Bankalardaki kredi kartlarınızı, güncel dönem borçlarını ve asgari tutarlarını ekleyerek faiz ve yasal takip sayaçlarınızı başlatın.
                    </p>
                </div>
                <button wire:click="openCreateModal" class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm rounded-xl shadow-md transition-colors">
                    <span>+ İlk Kredi Kartınızı Ekleyin</span>
                </button>
            </div>
        @endforelse
    </div>

    <!-- MODAL -->
    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
            <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl space-y-4">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <h3 class="font-bold text-lg text-gray-900">{{ $cardId ? 'Kartı Düzenle' : 'Yeni Kredi Kartı Ekle' }}</h3>
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
                            @error('bank_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Kart Adı</label>
                            <input type="text" wire:model="name" class="w-full rounded-xl border-gray-300 text-sm" placeholder="Örn: Maximum Kart">
                            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Toplam Limit (TL)</label>
                            <input type="number" step="0.01" wire:model="credit_limit" class="w-full rounded-xl border-gray-300 text-sm" placeholder="60000">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Güncel Dönem Borcu (TL)</label>
                            <input type="number" step="0.01" wire:model="current_debt" class="w-full rounded-xl border-gray-300 text-sm font-bold text-red-600" placeholder="45000">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Asgari Ödeme Tutarı (TL)</label>
                            <input type="number" step="0.01" wire:model="minimum_payment" class="w-full rounded-xl border-gray-300 text-sm" placeholder="18000">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Son Ödeme Yapılan Tarih</label>
                            <input type="date" wire:model="last_payment_date" class="w-full rounded-xl border-gray-300 text-sm">
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Hesap Kesim Günü</label>
                            <input type="number" min="1" max="31" wire:model="statement_day" class="w-full rounded-xl border-gray-300 text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Son Ödeme Günü</label>
                            <input type="number" min="1" max="31" wire:model="due_day" class="w-full rounded-xl border-gray-300 text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Aylık Faiz %</label>
                            <input type="number" step="0.01" wire:model="interest_rate" class="w-full rounded-xl border-gray-300 text-sm">
                        </div>
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
