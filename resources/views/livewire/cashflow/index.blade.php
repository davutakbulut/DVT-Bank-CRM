<div class="py-1 sm:py-6 px-3 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-gray-900 tracking-tight">Gelir & Gider Yönetimi</h1>
            <p class="text-sm text-gray-600">Aylık net nakit akışınız ve borç ödemelerine ayrılabilir bütçeniz</p>
        </div>
        <div class="flex items-center gap-2">
            <button wire:click="openIncomeModal" class="px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl shadow-sm transition-colors">
                + Gelir Ekle
            </button>
            <button wire:click="openExpenseModal" class="px-4 py-2.5 bg-rose-600 hover:bg-rose-700 text-white font-bold text-sm rounded-xl shadow-sm transition-colors">
                + Gider Ekle
            </button>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl text-sm font-medium">
            ✓ {{ session('message') }}
        </div>
    @endif

    <!-- ÖZET KARTLARI -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
            <span class="text-xs font-bold text-gray-500 block mb-1">TOPLAM AYLIK GELİR</span>
            <span class="text-2xl font-black text-emerald-600">₺{{ number_format($totalIncome, 2, ',', '.') }}</span>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
            <span class="text-xs font-bold text-gray-500 block mb-1">SABİT & AYLIK GİDERLER</span>
            <span class="text-2xl font-black text-rose-600">₺{{ number_format($totalExpense, 2, ',', '.') }}</span>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
            <span class="text-xs font-bold text-gray-500 block mb-1">BORÇLARA AYRILABİLİR NET</span>
            <span class="text-2xl font-black text-indigo-600">₺{{ number_format($netRemaining, 2, ',', '.') }}</span>
        </div>
    </div>

    <!-- 2 KOLONLU LİSTE: GELİRLER & GİDERLER -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Gelirler -->
        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm space-y-4">
            <h3 class="font-bold text-gray-900 text-base border-b border-gray-100 pb-3 flex items-center justify-between">
                <span>Aylık Gelirler</span>
                <span class="text-xs text-emerald-600 font-semibold">₺{{ number_format($totalIncome, 2, ',', '.') }}</span>
            </h3>
            <div class="divide-y divide-gray-100">
                @forelse ($incomes as $inc)
                    <div class="py-3 flex items-center justify-between">
                        <div>
                            <span class="font-bold text-sm text-gray-900 block">{{ $inc->title }}</span>
                            <span class="text-xs text-gray-500">{{ $inc->type === 'salary' ? 'Maaş' : 'Ek Gelir' }}</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="font-black text-sm text-emerald-600">₺{{ number_format($inc->amount, 2, ',', '.') }}</span>
                            <button wire:click="deleteIncome({{ $inc->id }})" class="text-gray-400 hover:text-red-600 text-xs">🗑</button>
                        </div>
                    </div>
                @empty
                    <div class="py-4 text-center text-gray-400 text-xs">Kayıtlı gelir yok.</div>
                @endforelse
            </div>
        </div>

        <!-- Giderler -->
        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm space-y-4">
            <h3 class="font-bold text-gray-900 text-base border-b border-gray-100 pb-3 flex items-center justify-between">
                <span>Aylık Sabit & Değişken Giderler</span>
                <span class="text-xs text-rose-600 font-semibold">₺{{ number_format($totalExpense, 2, ',', '.') }}</span>
            </h3>
            <div class="divide-y divide-gray-100">
                @forelse ($expenses as $exp)
                    <div class="py-3 flex items-center justify-between">
                        <div>
                            <span class="font-bold text-sm text-gray-900 block">{{ $exp->title }}</span>
                            <span class="text-xs text-gray-500">{{ $exp->category?->name ?? 'Genel Gider' }} · {{ \Carbon\Carbon::parse($exp->expense_date)->format('d.m.Y') }}</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="font-black text-sm text-rose-600">₺{{ number_format($exp->amount, 2, ',', '.') }}</span>
                            <button wire:click="deleteExpense({{ $exp->id }})" class="text-gray-400 hover:text-red-600 text-xs">🗑</button>
                        </div>
                    </div>
                @empty
                    <div class="py-4 text-center text-gray-400 text-xs">Kayıtlı gider yok.</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- GELİR MODAL -->
    @if ($showIncomeModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
            <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4">
                <h3 class="font-bold text-lg text-gray-900 border-b border-gray-100 pb-2">Yeni Gelir Ekle</h3>
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Gelir Başlığı</label>
                        <input type="text" wire:model="income_title" class="w-full rounded-xl border-gray-300 text-sm" placeholder="Örn: Aylık Net Maaş">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Tutar (TL)</label>
                        <input type="number" step="0.01" wire:model="income_amount" class="w-full rounded-xl border-gray-300 text-sm font-bold text-emerald-600" placeholder="65000">
                    </div>
                </div>
                <div class="flex justify-end gap-3 pt-3">
                    <button wire:click="$set('showIncomeModal', false)" class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl">İptal</button>
                    <button wire:click="saveIncome" class="px-5 py-2 text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl">Kaydet</button>
                </div>
            </div>
        </div>
    @endif

    <!-- GİDER MODAL -->
    @if ($showExpenseModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
            <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4">
                <h3 class="font-bold text-lg text-gray-900 border-b border-gray-100 pb-2">Yeni Gider Ekle</h3>
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Gider Başlığı</label>
                        <input type="text" wire:model="expense_title" class="w-full rounded-xl border-gray-300 text-sm" placeholder="Örn: Ev Kirası">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Kategori</label>
                        <select wire:model="expense_category_id" class="w-full rounded-xl border-gray-300 text-sm">
                            <option value="">Kategori Seçin</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Tutar (TL)</label>
                        <input type="number" step="0.01" wire:model="expense_amount" class="w-full rounded-xl border-gray-300 text-sm font-bold text-rose-600">
                    </div>
                </div>
                <div class="flex justify-end gap-3 pt-3">
                    <button wire:click="$set('showExpenseModal', false)" class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl">İptal</button>
                    <button wire:click="saveExpense" class="px-5 py-2 text-sm font-bold text-white bg-rose-600 hover:bg-rose-700 rounded-xl">Kaydet</button>
                </div>
            </div>
        </div>
    @endif
</div>
