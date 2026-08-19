<div class="py-1 sm:py-6 px-3 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-gray-900 tracking-tight">Bankalarım</h1>
            <p class="text-sm text-gray-600">Sistem bankaları ve tanımladığınız özel finansal kurumlar</p>
        </div>
        <button wire:click="openCreateModal" class="inline-flex items-center px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm rounded-xl shadow-sm transition-colors">
            + Özel Banka / Kurum Ekle
        </button>
    </div>

    @if (session()->has('message'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm font-bold flex items-center gap-2">
            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
            <span>{{ session('message') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach ($banks as $bank)
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm relative overflow-hidden flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="w-10 h-10 rounded-xl flex items-center justify-center text-white font-bold text-sm shadow-sm" style="background-color: {{ $bank->color ?? '#6366f1' }}">
                                {{ mb_substr($bank->name, 0, 2) }}
                            </span>
                            <div>
                                <h3 class="font-bold text-gray-900 text-base">{{ $bank->name }}</h3>
                                <span class="text-[11px] font-semibold {{ $bank->is_system ? 'text-gray-400' : 'text-indigo-600' }}">
                                    {{ $bank->is_system ? 'Sistem Bankası' : 'Özel Tanımlı' }}
                                </span>
                            </div>
                        </div>

                        @if (!$bank->is_system && $bank->user_id === auth()->id())
                            <div class="flex items-center gap-1">
                                <button wire:click="openEditModal({{ $bank->id }})" class="p-1.5 text-gray-400 hover:text-indigo-600 rounded-lg">✎</button>
                                <button wire:click="delete({{ $bank->id }})" wire:confirm="Bu bankayı silmek istediğinizden emin misiniz?" class="p-1.5 text-gray-400 hover:text-red-600 rounded-lg">🗑</button>
                            </div>
                        @endif
                    </div>

                    <div class="grid grid-cols-3 gap-2 mt-4 pt-3 border-t border-gray-100 text-center">
                        <div class="bg-gray-50 p-2 rounded-lg">
                            <span class="block text-xs text-gray-500 font-medium">Hesap</span>
                            <span class="font-bold text-gray-900 text-sm">{{ $bank->accounts_count }}</span>
                        </div>
                        <div class="bg-gray-50 p-2 rounded-lg">
                            <span class="block text-xs text-gray-500 font-medium">Kart</span>
                            <span class="font-bold text-gray-900 text-sm">{{ $bank->credit_cards_count }}</span>
                        </div>
                        <div class="bg-gray-50 p-2 rounded-lg">
                            <span class="block text-xs text-gray-500 font-medium">Borç</span>
                            <span class="font-bold text-gray-900 text-sm">{{ $bank->debts_count }}</span>
                        </div>
                    </div>
                </div>

                <div class="absolute top-0 left-0 bottom-0 w-1.5" style="background-color: {{ $bank->color ?? '#6366f1' }}"></div>
            </div>
        @endforeach
    </div>

    <!-- MODAL -->
    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
            <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <h3 class="font-bold text-lg text-gray-900">{{ $bankId ? 'Bankayı Düzenle' : 'Yeni Banka Ekle' }}</h3>
                    <button wire:click="$set('showModal', false)" class="text-gray-400 hover:text-gray-600 font-bold">✕</button>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Banka / Kurum Adı</label>
                        <input type="text" wire:model="name" class="w-full rounded-xl border-gray-300 text-sm font-medium" placeholder="Örn: Fibabanka">
                        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Renk Kodu (Hex)</label>
                        <div class="flex items-center gap-3">
                            <input type="color" wire:model="color" class="h-10 w-14 rounded-lg border border-gray-300 cursor-pointer">
                            <input type="text" wire:model="color" class="w-full rounded-xl border-gray-300 text-sm" placeholder="#6366f1">
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
