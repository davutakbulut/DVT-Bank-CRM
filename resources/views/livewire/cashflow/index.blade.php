<div class="py-2 sm:py-6 px-3 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-6">
    <!-- 1. Header & Aksiyonlar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-gray-900 tracking-tight flex items-center gap-2">
                <span>⚡</span>
                <span>Gelir & Gider Yönetimi (Nakit Akışı)</span>
            </h1>
            <p class="text-sm text-gray-600">Aylık net nakit akışınız, tekrarlayan sabit giderleriniz ve borç ödemelerine ayrılabilir bütçeniz</p>
        </div>
        <div class="flex items-center gap-2 sm:gap-3 flex-wrap">
            <!-- Görünüm Seçici -->
            <div class="inline-flex rounded-xl bg-gray-100 p-1 border border-gray-200 shadow-2xs">
                <button wire:click="$set('viewMode', 'feed')" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all flex items-center gap-1.5 {{ $viewMode === 'feed' ? 'bg-white text-indigo-700 shadow-xs' : 'text-gray-600 hover:text-gray-900' }}">
                    <span>⚡</span>
                    <span class="hidden sm:inline">Zaman Akışı</span>
                </button>
                <button wire:click="$set('viewMode', 'columns')" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all flex items-center gap-1.5 {{ $viewMode === 'columns' ? 'bg-white text-indigo-700 shadow-xs' : 'text-gray-600 hover:text-gray-900' }}">
                    <span>📑</span>
                    <span class="hidden sm:inline">Çift Kolon</span>
                </button>
                <button wire:click="$set('viewMode', 'table')" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all flex items-center gap-1.5 {{ $viewMode === 'table' ? 'bg-white text-indigo-700 shadow-xs' : 'text-gray-600 hover:text-gray-900' }}">
                    <span>📊</span>
                    <span class="hidden sm:inline">Tablo</span>
                </button>
            </div>

            <button wire:click="openIncomeModal" class="px-3.5 sm:px-4 py-2 bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white font-black text-xs sm:text-sm rounded-xl shadow-md transition-all flex items-center gap-1.5">
                <span>+ Gelir Ekle</span>
            </button>
            <button wire:click="openExpenseModal" class="px-3.5 sm:px-4 py-2 bg-rose-600 hover:bg-rose-700 active:scale-95 text-white font-black text-xs sm:text-sm rounded-xl shadow-md transition-all flex items-center gap-1.5">
                <span>+ Gider Ekle</span>
            </button>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm font-bold flex items-center gap-2 shadow-xs">
            <span>✓</span>
            <span>{{ session('message') }}</span>
        </div>
    @endif

    <!-- 2. Finansal KPI Özet Kartları -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
        <!-- Toplam Gelir -->
        <div class="bg-white p-4 rounded-2xl border border-gray-200/80 shadow-xs flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg font-black shrink-0">
                💰
            </div>
            <div class="min-w-0">
                <span class="text-[11px] font-bold text-gray-500 block uppercase tracking-wider truncate">Toplam Gelir</span>
                <span class="text-lg sm:text-xl font-black text-emerald-600 truncate block">₺{{ number_format($totalIncome, 2, ',', '.') }}</span>
            </div>
        </div>

        <!-- Sabit & Değişken Giderler -->
        <div class="bg-white p-4 rounded-2xl border border-gray-200/80 shadow-xs flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-lg font-black shrink-0">
                💸
            </div>
            <div class="min-w-0">
                <span class="text-[11px] font-bold text-gray-500 block uppercase tracking-wider truncate">Toplam Giderler</span>
                <span class="text-lg sm:text-xl font-black text-rose-600 truncate block">₺{{ number_format($totalExpense, 2, ',', '.') }}</span>
            </div>
        </div>

        <!-- Borçlara Ayrılabilir Net Bütçe -->
        <div class="bg-white p-4 rounded-2xl border border-gray-200/80 shadow-xs flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl {{ $netRemaining < 0 ? 'bg-red-50 text-red-600' : 'bg-indigo-50 text-indigo-600' }} flex items-center justify-center text-lg font-black shrink-0">
                ⚡
            </div>
            <div class="min-w-0">
                <span class="text-[11px] font-bold text-gray-500 block uppercase tracking-wider truncate">Borca Ayrılabilir Net</span>
                <span class="text-lg sm:text-xl font-black {{ $netRemaining < 0 ? 'text-red-600' : 'text-indigo-700' }} truncate block">
                    ₺{{ number_format($netRemaining, 2, ',', '.') }}
                </span>
            </div>
        </div>

        <!-- Tasarruf Oranı -->
        <div class="bg-white p-4 rounded-2xl border border-gray-200/80 shadow-xs flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg font-black shrink-0">
                📈
            </div>
            <div class="min-w-0">
                <span class="text-[11px] font-bold text-gray-500 block uppercase tracking-wider truncate">Tasarruf Oranı</span>
                <span class="text-lg sm:text-xl font-black text-gray-900 truncate block">%{{ $savingsRate }}</span>
            </div>
        </div>
    </div>

    <!-- 3. KAPSAMLI ÜST FİLTRE & ARAMA PANELİ -->
    <div class="bg-white rounded-2xl border border-gray-200/90 shadow-sm p-4 sm:p-5 space-y-4">
        <!-- Üst Satır: Sekmeler + Arama -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-3 pb-3 border-b border-gray-100">
            <!-- Tür Sekmeleri -->
            <div class="flex items-center gap-1.5 overflow-x-auto no-scrollbar pb-1">
                <button wire:click="$set('activeTab', 'all')" class="px-3.5 py-1.5 text-xs font-bold rounded-xl transition-all whitespace-nowrap {{ $activeTab === 'all' ? 'bg-indigo-600 text-white shadow-xs' : 'text-gray-600 hover:bg-gray-100' }}">
                    Tümü ({{ $stream->count() }})
                </button>
                <button wire:click="$set('activeTab', 'income')" class="px-3.5 py-1.5 text-xs font-bold rounded-xl transition-all whitespace-nowrap {{ $activeTab === 'income' ? 'bg-emerald-600 text-white shadow-xs' : 'text-gray-600 hover:bg-gray-100' }}">
                    🟢 Gelirler
                </button>
                <button wire:click="$set('activeTab', 'expense')" class="px-3.5 py-1.5 text-xs font-bold rounded-xl transition-all whitespace-nowrap {{ $activeTab === 'expense' ? 'bg-rose-600 text-white shadow-xs' : 'text-gray-600 hover:bg-gray-100' }}">
                    🔴 Giderler
                </button>
                <button wire:click="$set('activeTab', 'recurring')" class="px-3.5 py-1.5 text-xs font-bold rounded-xl transition-all whitespace-nowrap {{ $activeTab === 'recurring' ? 'bg-indigo-600 text-white shadow-xs' : 'text-gray-600 hover:bg-gray-100' }}">
                    🔄 Sabit & Tekrarlayan
                </button>
            </div>

            <!-- Canlı Arama Inputu -->
            <div class="relative w-full lg:w-72">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 text-xs">
                    🔍
                </span>
                <input type="text" 
                       wire:model.live.debounce.300ms="search" 
                       placeholder="Gelir, gider veya kategori ara..." 
                       class="w-full pl-9 pr-8 py-1.5 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm font-medium focus:bg-white focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                @if ($search)
                    <button wire:click="$set('search', '')" class="absolute inset-y-0 right-0 pr-2.5 flex items-center text-gray-400 hover:text-gray-600 text-xs font-bold">
                        ✕
                    </button>
                @endif
            </div>
        </div>

        <!-- Alt Satır: Filtre Seçicileri (Kategori, Sıralama, Tarih Aralığı) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 items-center text-xs">
            <!-- 1. Kategori Seçimi -->
            <div>
                <label class="block font-bold text-gray-600 mb-1 text-[11px]">📁 Kategori Filtresi</label>
                <select wire:model.live="selected_category_id" class="w-full rounded-xl border-gray-200 bg-gray-50/80 py-1.5 text-xs font-medium focus:bg-white focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Tüm Kategoriler</option>
                    @foreach ($categories as $c)
                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- 2. Sıralama -->
            <div>
                <label class="block font-bold text-gray-600 mb-1 text-[11px]">🔄 Sıralama Algoritması</label>
                <select wire:model.live="sortBy" class="w-full rounded-xl border-gray-200 bg-gray-50/80 py-1.5 text-xs font-medium focus:bg-white focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="date_desc">📅 Tarihe Göre (En Yeni - İlk)</option>
                    <option value="date_asc">📅 Tarihe Göre (En Eski)</option>
                    <option value="amount_desc">💰 En Yüksek Tutar</option>
                    <option value="amount_asc">📉 En Düşük Tutar</option>
                    <option value="title">🔤 Başlık (A-Z)</option>
                </select>
            </div>

            <!-- 3. Tarih Aralığı -->
            <div>
                <label class="block font-bold text-gray-600 mb-1 text-[11px]">📅 Başlangıç Tarihi</label>
                <input type="date" wire:model.live="date_from" class="w-full rounded-xl border-gray-200 bg-gray-50/80 py-1.5 text-xs font-medium focus:bg-white focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div>
                <label class="block font-bold text-gray-600 mb-1 text-[11px]">📅 Bitiş Tarihi</label>
                <input type="date" wire:model.live="date_to" class="w-full rounded-xl border-gray-200 bg-gray-50/80 py-1.5 text-xs font-medium focus:bg-white focus:ring-indigo-500 focus:border-indigo-500">
            </div>
        </div>

        <!-- Hızlı Tarih Hapları & Filtreleri Sıfırla -->
        <div class="flex flex-wrap items-center justify-between gap-2 pt-2 border-t border-gray-100 text-xs">
            <div class="flex flex-wrap items-center gap-1.5">
                <span class="text-[11px] font-bold text-gray-400">Dönem Seçimi:</span>
                <button wire:click="setDatePreset('this_month')" class="px-2.5 py-1 rounded-lg font-bold text-[11px] transition-all {{ $date_preset === 'this_month' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    Bu Ay
                </button>
                <button wire:click="setDatePreset('last_30')" class="px-2.5 py-1 rounded-lg font-bold text-[11px] transition-all {{ $date_preset === 'last_30' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    Son 30 Gün
                </button>
                <button wire:click="setDatePreset('last_month')" class="px-2.5 py-1 rounded-lg font-bold text-[11px] transition-all {{ $date_preset === 'last_month' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    Geçen Ay
                </button>
                <button wire:click="setDatePreset('this_year')" class="px-2.5 py-1 rounded-lg font-bold text-[11px] transition-all {{ $date_preset === 'this_year' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    Bu Yıl
                </button>
                <button wire:click="setDatePreset('all')" class="px-2.5 py-1 rounded-lg font-bold text-[11px] transition-all {{ $date_preset === 'all' ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    Tüm Zamanlar
                </button>
            </div>

            @if ($search || $selected_category_id || $date_preset !== 'this_month' || $sortBy !== 'date_desc' || $activeTab !== 'all')
                <button wire:click="resetFilters" class="text-indigo-600 hover:text-indigo-800 font-black text-xs flex items-center gap-1">
                    <span>↺ Filtreleri Sıfırla</span>
                </button>
            @endif
        </div>
    </div>

    <!-- 4. GÖRÜNÜM 1: ZAMAN AKIŞI (TIMELINE FEED) -->
    @if ($viewMode === 'feed')
        <div class="space-y-3">
            @forelse ($stream as $item)
                @php
                    $isIncome = $item->type === 'income';
                @endphp
                <div class="bg-white rounded-2xl border border-gray-200/90 hover:border-gray-300 p-4 sm:p-5 shadow-xs hover:shadow-md transition-all flex flex-col sm:flex-row sm:items-center justify-between gap-3 relative overflow-hidden group">
                    <!-- Sol Renk Şeridi -->
                    <div class="absolute top-0 bottom-0 left-0 w-1.5 {{ $isIncome ? 'bg-emerald-500' : 'bg-rose-500' }}"></div>

                    <!-- Sol Taraf: İkon + Başlık + Tarih & Kategori -->
                    <div class="flex items-center gap-3.5 pl-2 min-w-0">
                        <div class="w-10 h-10 rounded-xl {{ $isIncome ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }} flex items-center justify-center text-lg font-black shrink-0">
                            {{ $isIncome ? '↓' : '↑' }}
                        </div>
                        <div class="min-w-0">
                            <div class="flex items-center gap-2 flex-wrap">
                                <h3 class="font-bold text-gray-900 text-sm sm:text-base truncate">{{ $item->title }}</h3>
                                <span class="px-2 py-0.5 rounded-md text-[10px] font-black {{ $isIncome ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                    {{ $item->badge }}
                                </span>
                                @if ($item->is_recurring)
                                    <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-100">
                                        🔄 Tekrarlayan
                                    </span>
                                @endif
                            </div>
                            <p class="text-xs text-gray-500 mt-0.5 flex items-center gap-2">
                                <span>📅 {{ \Carbon\Carbon::parse($item->date)->format('d.m.Y') }}</span>
                                <span>·</span>
                                <span>{{ $item->category_name }}</span>
                            </p>
                        </div>
                    </div>

                    <!-- Sağ Taraf: Tutar + Hızlı Aksiyonlar -->
                    <div class="flex items-center justify-between sm:justify-end gap-4 pl-2 sm:pl-0 border-t sm:border-t-0 pt-2 sm:pt-0 border-gray-100">
                        <div class="text-left sm:text-right">
                            <span class="text-lg sm:text-xl font-black block {{ $isIncome ? 'text-emerald-600' : 'text-rose-600' }}">
                                {{ $isIncome ? '+' : '-' }}₺{{ number_format($item->amount, 2, ',', '.') }}
                            </span>
                            <span class="text-[10px] text-gray-400 font-medium block">
                                {{ $isIncome ? 'Nakit Girişi' : 'Harcama / Çıkış' }}
                            </span>
                        </div>

                        <div class="flex items-center gap-1.5">
                            @if ($isIncome)
                                <button wire:click="openEditIncome({{ $item->id }})" class="p-1.5 text-gray-400 hover:text-indigo-600 rounded-lg hover:bg-gray-100 transition-colors text-xs font-bold">
                                    ✎
                                </button>
                                <button wire:click="deleteIncome({{ $item->id }})" wire:confirm="Bu gelir kaydını silmek istediğinize emin misiniz?" class="p-1.5 text-gray-400 hover:text-red-600 rounded-lg hover:bg-gray-100 transition-colors text-xs font-bold">
                                    🗑
                                </button>
                            @else
                                <button wire:click="openEditExpense({{ $item->id }})" class="p-1.5 text-gray-400 hover:text-indigo-600 rounded-lg hover:bg-gray-100 transition-colors text-xs font-bold">
                                    ✎
                                </button>
                                <button wire:click="deleteExpense({{ $item->id }})" wire:confirm="Bu gider kaydını silmek istediğinize emin misiniz?" class="p-1.5 text-gray-400 hover:text-red-600 rounded-lg hover:bg-gray-100 transition-colors text-xs font-bold">
                                    🗑
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-3xl p-12 text-center border-2 border-dashed border-gray-200 space-y-3">
                    <div class="text-3xl">🔍</div>
                    <h3 class="font-bold text-gray-900 text-base">Filtre kriterlerine uygun nakit hareketi bulunamadı</h3>
                    <p class="text-xs text-gray-500">Seçili tarih aralığını veya filtreleri değiştirerek tekrar deneyin.</p>
                    <button wire:click="resetFilters" class="px-4 py-2 bg-indigo-50 text-indigo-700 rounded-xl text-xs font-bold hover:bg-indigo-100 transition-colors">
                        Filtreleri Temizle
                    </button>
                </div>
            @endforelse
        </div>
    @elseif ($viewMode === 'columns')
        <!-- 5. GÖRÜNÜM 2: ÇİFT KOLONLU GELİR & GİDER LİSTESİ -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Gelirler Kolonu -->
            <div class="bg-white rounded-2xl p-5 sm:p-6 border border-gray-200/90 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <div class="flex items-center gap-2">
                        <span class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs font-bold">↓</span>
                        <h3 class="font-bold text-gray-900 text-base">Aylık Gelir Kalemleri</h3>
                    </div>
                    <span class="text-sm font-black text-emerald-600">₺{{ number_format($totalIncome, 2, ',', '.') }}</span>
                </div>

                <div class="divide-y divide-gray-100">
                    @forelse ($incomes as $inc)
                        <div class="py-3 flex items-center justify-between hover:bg-gray-50/60 rounded-xl px-2 transition-colors">
                            <div>
                                <span class="font-bold text-sm text-gray-900 block">{{ $inc->title }}</span>
                                <span class="text-xs text-gray-500">{{ $inc->type === 'salary' ? 'Maaş / Düzenli' : 'Ek Gelir' }} · {{ $inc->frequency === 'monthly' ? 'Aylık' : 'Tek Seferlik' }}</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="font-black text-sm text-emerald-600">+₺{{ number_format($inc->amount, 2, ',', '.') }}</span>
                                <button wire:click="openEditIncome({{ $inc->id }})" class="text-gray-400 hover:text-indigo-600 text-xs">✎</button>
                                <button wire:click="deleteIncome({{ $inc->id }})" wire:confirm="Bu geliri silmek istediğinize emin misiniz?" class="text-gray-400 hover:text-red-600 text-xs">🗑</button>
                            </div>
                        </div>
                    @empty
                        <div class="py-6 text-center text-gray-400 text-xs">Kayıtlı gelir kalemi yok.</div>
                    @endforelse
                </div>
            </div>

            <!-- Giderler Kolonu -->
            <div class="bg-white rounded-2xl p-5 sm:p-6 border border-gray-200/90 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <div class="flex items-center gap-2">
                        <span class="w-7 h-7 rounded-lg bg-rose-100 text-rose-700 flex items-center justify-center text-xs font-bold">↑</span>
                        <h3 class="font-bold text-gray-900 text-base">Aylık Sabit & Değişken Giderler</h3>
                    </div>
                    <span class="text-sm font-black text-rose-600">₺{{ number_format($totalExpense, 2, ',', '.') }}</span>
                </div>

                <div class="divide-y divide-gray-100 max-h-[500px] overflow-y-auto">
                    @forelse ($expenses as $exp)
                        <div class="py-3 flex items-center justify-between hover:bg-gray-50/60 rounded-xl px-2 transition-colors">
                            <div>
                                <span class="font-bold text-sm text-gray-900 block">{{ $exp->title }}</span>
                                <span class="text-xs text-gray-500">{{ $exp->category?->name ?? 'Genel Gider' }} · {{ \Carbon\Carbon::parse($exp->expense_date)->format('d.m.Y') }}</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="font-black text-sm text-rose-600">-₺{{ number_format($exp->amount, 2, ',', '.') }}</span>
                                <button wire:click="openEditExpense({{ $exp->id }})" class="text-gray-400 hover:text-indigo-600 text-xs">✎</button>
                                <button wire:click="deleteExpense({{ $exp->id }})" wire:confirm="Bu gideri silmek istediğinize emin misiniz?" class="text-gray-400 hover:text-red-600 text-xs">🗑</button>
                            </div>
                        </div>
                    @empty
                        <div class="py-6 text-center text-gray-400 text-xs">Kayıtlı gider kalemi yok.</div>
                    @endforelse
                </div>
            </div>
        </div>
    @else
        <!-- 6. GÖRÜNÜM 3: DETAYLI İŞLEMLER TABLOSU -->
        <div class="bg-white rounded-2xl border border-gray-200/90 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50 text-gray-500 font-bold text-xs text-left">
                        <tr>
                            <th class="px-6 py-3.5">İşlem Başlığı</th>
                            <th class="px-6 py-3.5">Tür & Kategori</th>
                            <th class="px-6 py-3.5">Tarih</th>
                            <th class="px-6 py-3.5">Tekrarlama</th>
                            <th class="px-6 py-3.5 text-right">Tutar</th>
                            <th class="px-6 py-3.5 text-right">İşlemler</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse ($stream as $item)
                            @php
                                $isIncome = $item->type === 'income';
                            @endphp
                            <tr class="hover:bg-gray-50/70 transition-colors">
                                <td class="px-6 py-4 font-bold text-gray-900">
                                    {{ $item->title }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-black {{ $isIncome ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                        {{ $item->badge }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-xs text-gray-600">
                                    {{ \Carbon\Carbon::parse($item->date)->format('d.m.Y') }}
                                </td>
                                <td class="px-6 py-4 text-xs text-gray-600">
                                    {{ $item->is_recurring ? '🔄 Aylık Düzenli' : 'Tek Seferlik' }}
                                </td>
                                <td class="px-6 py-4 font-black text-right {{ $isIncome ? 'text-emerald-600' : 'text-rose-600' }}">
                                    {{ $isIncome ? '+' : '-' }}₺{{ number_format($item->amount, 2, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    @if ($isIncome)
                                        <button wire:click="openEditIncome({{ $item->id }})" class="text-indigo-600 hover:text-indigo-900 font-bold text-xs">Düzenle</button>
                                        <button wire:click="deleteIncome({{ $item->id }})" wire:confirm="Bu geliri silmek istediğinize emin misiniz?" class="text-red-600 hover:text-red-900 font-bold text-xs">Sil</button>
                                    @else
                                        <button wire:click="openEditExpense({{ $item->id }})" class="text-indigo-600 hover:text-indigo-900 font-bold text-xs">Düzenle</button>
                                        <button wire:click="deleteExpense({{ $item->id }})" wire:confirm="Bu gideri silmek istediğinize emin misiniz?" class="text-red-600 hover:text-red-900 font-bold text-xs">Sil</button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                    Kayıtlı işlem bulunmamaktadır.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- 7. GELİR MODAL -->
    @if ($showIncomeModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-xs p-4 overflow-y-auto">
            <div class="bg-white rounded-2xl max-w-md w-full p-5 sm:p-6 shadow-2xl space-y-4 my-8">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <h3 class="font-bold text-lg text-gray-900">{{ $incomeId ? 'Gelir Kaydını Düzenle' : 'Yeni Gelir Kalemi Tanımla' }}</h3>
                    <button wire:click="$set('showIncomeModal', false)" class="text-gray-400 hover:text-gray-600 font-bold text-lg">✕</button>
                </div>

                <div class="space-y-3.5">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Gelir Başlığı</label>
                        <input type="text" wire:model="income_title" class="w-full rounded-xl border-gray-300 text-sm font-medium focus:ring-emerald-500 focus:border-emerald-500" placeholder="Örn: Net Aylık Maaş veya Kira Geliri">
                        @error('income_title') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Gelir Türü</label>
                            <select wire:model="income_type" class="w-full rounded-xl border-gray-300 text-sm font-medium focus:ring-emerald-500 focus:border-emerald-500">
                                <option value="salary">Aylık Maaş</option>
                                <option value="freelance">Ek İş / Serbest Gelir</option>
                                <option value="rental">Kira Geliri</option>
                                <option value="investment">Yatırım / Temettü</option>
                                <option value="other">Diğer Gelir</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Tekrarlama Sıklığı</label>
                            <select wire:model="income_frequency" class="w-full rounded-xl border-gray-300 text-sm font-medium focus:ring-emerald-500 focus:border-emerald-500">
                                <option value="monthly">Her Ay (Aylık)</option>
                                <option value="one_time">Tek Seferlik</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Net Tutar (TL)</label>
                        <input type="number" step="0.01" wire:model="income_amount" class="w-full rounded-xl border-gray-300 text-sm font-black text-emerald-600 focus:ring-emerald-500 focus:border-emerald-500" placeholder="65000">
                        @error('income_amount') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-3 border-t border-gray-100">
                    <button wire:click="$set('showIncomeModal', false)" class="px-4 py-2 text-sm font-bold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">
                        İptal
                    </button>
                    <button wire:click="saveIncome" class="px-6 py-2 text-sm font-black text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-md transition-all active:scale-95">
                        Kaydet
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- 8. GİDER MODAL -->
    @if ($showExpenseModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-xs p-4 overflow-y-auto">
            <div class="bg-white rounded-2xl max-w-md w-full p-5 sm:p-6 shadow-2xl space-y-4 my-8">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <h3 class="font-bold text-lg text-gray-900">{{ $expenseId ? 'Gider Kaydını Düzenle' : 'Yeni Gider Kalemi Tanımla' }}</h3>
                    <button wire:click="$set('showExpenseModal', false)" class="text-gray-400 hover:text-gray-600 font-bold text-lg">✕</button>
                </div>

                <div class="space-y-3.5">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Gider Başlığı</label>
                        <input type="text" wire:model="expense_title" class="w-full rounded-xl border-gray-300 text-sm font-medium focus:ring-rose-500 focus:border-rose-500" placeholder="Örn: Ev Kirası, Doğalgaz veya Market">
                        @error('expense_title') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Kategori</label>
                            <select wire:model="expense_category_id" class="w-full rounded-xl border-gray-300 text-sm font-medium focus:ring-rose-500 focus:border-rose-500">
                                <option value="">Genel Gider</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Harcama Tarihi</label>
                            <input type="date" wire:model="expense_date" class="w-full rounded-xl border-gray-300 text-sm font-medium focus:ring-rose-500 focus:border-rose-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Tutar (TL)</label>
                        <input type="number" step="0.01" wire:model="expense_amount" class="w-full rounded-xl border-gray-300 text-sm font-black text-rose-600 focus:ring-rose-500 focus:border-rose-500" placeholder="18500">
                        @error('expense_amount') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center gap-2 pt-1">
                        <input type="checkbox" id="expense_recurring" wire:model="expense_is_recurring" class="rounded border-gray-300 text-rose-600 focus:ring-rose-500">
                        <label for="expense_recurring" class="text-xs font-bold text-gray-700 cursor-pointer">
                            Her ay tekrarlayan sabit gider (Kira, Fatura, Aidat vb.)
                        </label>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-3 border-t border-gray-100">
                    <button wire:click="$set('showExpenseModal', false)" class="px-4 py-2 text-sm font-bold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">
                        İptal
                    </button>
                    <button wire:click="saveExpense" class="px-6 py-2 text-sm font-black text-white bg-rose-600 hover:bg-rose-700 rounded-xl shadow-md transition-all active:scale-95">
                        Kaydet
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
