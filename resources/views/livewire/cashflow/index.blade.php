<div class="py-2 sm:py-6 px-3 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-6">
    <!-- 1. Header & Aksiyonlar -->
    <div class="bg-white p-4 sm:p-5 rounded-2xl border border-gray-200/90 shadow-sm space-y-3.5 sm:space-y-4">
        <!-- Üst Satır: Başlık + Görünüm Seçici & Excel -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 sm:gap-4 border-b border-gray-100 pb-3">
            <div>
                <h1 class="text-lg sm:text-2xl font-black text-gray-900 tracking-tight flex items-center gap-2">
                    <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/></svg>
                    <span>Gelir & Gider Yönetimi (Nakit Akışı)</span>
                </h1>
                <p class="text-xs sm:text-sm text-gray-500 mt-0.5">Aylık net nakit akışınız, tekrarlayan sabit giderleriniz ve borç ödemelerine ayrılabilir bütçeniz</p>
            </div>

            <div class="flex items-center justify-between sm:justify-end gap-2 sm:gap-3 w-full md:w-auto pt-1 md:pt-0">
                <!-- Excel / CSV İndirme Butonu -->
                <div class="relative group/tooltip" x-data="{ show: false }">
                    <button wire:click="exportExcel" 
                            @mouseenter="show = true" 
                            @mouseleave="show = false"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-300 font-bold text-xs rounded-xl shadow-2xs transition-all active:scale-95 cursor-pointer">
                        <svg class="w-4 h-4 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                        <span>Excel</span>
                    </button>

                    <!-- Açıklayıcı Bilgi Popup (Tooltip) -->
                    <div x-show="show" 
                         x-cloak
                         class="absolute left-0 sm:left-auto sm:right-0 top-full mt-2 w-72 p-3 bg-slate-900 text-white rounded-2xl shadow-2xl border border-slate-700 text-xs z-50 pointer-events-none transition-all">
                        <div class="flex items-center gap-1.5 font-bold text-emerald-300 border-b border-slate-800 pb-1 mb-1">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 005.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941"/></svg>
                            <span>Nakit Akışı Excel Raporu</span>
                        </div>
                        <p class="text-[11px] text-slate-300 leading-relaxed">
                            Tüm gelir ve gider kalemlerinizi, kategorileri ve tarihleri içeren <strong>Excel tablosunu</strong> indirir.
                        </p>
                        <span class="block mt-1.5 text-[10px] font-bold text-emerald-400 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            <span>Excel & Google Sheets Uyumlu</span>
                        </span>
                    </div>
                </div>

                <!-- Görünüm Seçici -->
                <div class="inline-flex rounded-xl bg-gray-100 p-1 border border-gray-200">
                    <button wire:click="$set('viewMode', 'feed')" class="px-2.5 py-1 rounded-lg text-xs font-bold transition-all flex items-center gap-1 cursor-pointer {{ $viewMode === 'feed' ? 'bg-white text-indigo-700 shadow-xs' : 'text-gray-600 hover:text-gray-900' }}">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/></svg>
                        <span class="hidden sm:inline">Zaman Akışı</span>
                    </button>
                    <button wire:click="$set('viewMode', 'columns')" class="px-2.5 py-1 rounded-lg text-xs font-bold transition-all flex items-center gap-1 cursor-pointer {{ $viewMode === 'columns' ? 'bg-white text-indigo-700 shadow-xs' : 'text-gray-600 hover:text-gray-900' }}">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 4.5v15m6-15v15m-10.875 0h15.75c.621 0 1.125-.504 1.125-1.125V5.625c0-.621-.504-1.125-1.125-1.125H4.125C3.504 4.5 3 5.04 3 5.625v12.75c0 .621.504 1.125 1.125 1.125z"/></svg>
                        <span class="hidden sm:inline">Çift Kolon</span>
                    </button>
                    <button wire:click="$set('viewMode', 'table')" class="px-2.5 py-1 rounded-lg text-xs font-bold transition-all flex items-center gap-1 cursor-pointer {{ $viewMode === 'table' ? 'bg-white text-indigo-700 shadow-xs' : 'text-gray-600 hover:text-gray-900' }}">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M3.75 4.5h16.5M3.75 8.25h16.5"/></svg>
                        <span class="hidden sm:inline">Tablo</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Alt Satır: Eşit Grid Ekleme Butonları (Mobilde Tam Simetrik 3 Sütun) -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2.5 pt-0.5">
            <span class="text-xs font-bold text-gray-500 hidden sm:inline-flex items-center gap-1.5">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                <span>Hızlı Nakit Hareketi Ekle:</span>
            </span>

            <div class="grid grid-cols-3 gap-2 w-full sm:w-auto sm:flex sm:items-center">
                <button wire:click="openExpectedIncomeModal" class="h-10 sm:h-auto px-2.5 sm:px-4 py-2 bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white font-bold text-xs sm:text-sm rounded-lg shadow-xs transition-all flex items-center justify-center gap-1 cursor-pointer text-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                    <span class="truncate">Beklenen</span>
                </button>
                <button wire:click="openIncomeModal" class="h-10 sm:h-auto px-2.5 sm:px-4 py-2 bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white font-bold text-xs sm:text-sm rounded-lg shadow-xs transition-all flex items-center justify-center gap-1 cursor-pointer text-center">
                    <span>+</span>
                    <span class="truncate">Gelir</span>
                </button>
                <button wire:click="openExpenseModal" class="h-10 sm:h-auto px-2.5 sm:px-4 py-2 bg-rose-600 hover:bg-rose-700 active:scale-95 text-white font-bold text-xs sm:text-sm rounded-lg shadow-xs transition-all flex items-center justify-center gap-1 cursor-pointer text-center">
                    <span>+</span>
                    <span class="truncate">Gider</span>
                </button>
            </div>
        </div>
    </div>


    @if (session()->has('message'))
        <div class="p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-lg text-sm font-bold flex items-center gap-2 shadow-xs">
            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
            <span>{{ session('message') }}</span>
        </div>
    @endif

    <!-- 2. Finansal KPI Özet Kartları (Net ve Kesilmeyen Geometri) -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-2.5 sm:gap-3.5">
        <!-- Toplam Gelir -->
        <div class="bg-white p-3.5 sm:p-4 rounded-xl border border-slate-200/80 shadow-2xs flex items-center gap-2.5 sm:gap-3">
            <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-base sm:text-lg font-black shrink-0">
                ₺
            </div>
            <div class="min-w-0 flex-1">
                <span class="text-[10px] sm:text-[11px] font-bold text-gray-500 block uppercase tracking-wider truncate">Toplam Gelir</span>
                <span class="text-sm sm:text-xl font-black font-mono text-emerald-600 truncate block">₺{{ number_format($totalIncome, 2, ',', '.') }}</span>
            </div>
        </div>

        <!-- Sabit & Değişken Giderler -->
        <div class="bg-white p-3.5 sm:p-4 rounded-xl border border-slate-200/80 shadow-2xs flex items-center gap-2.5 sm:gap-3">
            <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center text-base sm:text-lg font-black shrink-0">
                ₺
            </div>
            <div class="min-w-0 flex-1">
                <span class="text-[10px] sm:text-[11px] font-bold text-gray-500 block uppercase tracking-wider truncate">Toplam Gider</span>
                <span class="text-sm sm:text-xl font-black font-mono text-rose-600 truncate block">₺{{ number_format($totalExpense, 2, ',', '.') }}</span>
            </div>
        </div>

        <!-- Borçlara Ayrılabilir Net Bütçe -->
        <div class="bg-white p-3.5 sm:p-4 rounded-xl border border-slate-200/80 shadow-2xs flex items-center gap-2.5 sm:gap-3">
            <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg {{ $netRemaining < 0 ? 'bg-red-50 text-red-600' : 'bg-indigo-50 text-indigo-600' }} flex items-center justify-center text-base sm:text-lg font-black shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/></svg>
            </div>
            <div class="min-w-0 flex-1">
                <span class="text-[10px] sm:text-[11px] font-bold text-gray-500 block uppercase tracking-wider truncate">Borca Kalan Net</span>
                <span class="text-sm sm:text-xl font-black font-mono {{ $netRemaining < 0 ? 'text-red-600' : 'text-indigo-700' }} truncate block">
                    ₺{{ number_format($netRemaining, 2, ',', '.') }}
                </span>
            </div>
        </div>

        <!-- Tasarruf Oranı -->
        <div class="bg-white p-3.5 sm:p-4 rounded-xl border border-slate-200/80 shadow-2xs flex items-center gap-2.5 sm:gap-3">
            <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center text-base sm:text-lg font-black shrink-0">
                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 005.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941"/></svg>
            </div>
            <div class="min-w-0 flex-1">
                <span class="text-[10px] sm:text-[11px] font-bold text-gray-500 block uppercase tracking-wider truncate">Tasarruf Oranı</span>
                <span class="text-sm sm:text-xl font-black font-mono text-gray-900 truncate block">%{{ $savingsRate }}</span>
            </div>
        </div>
    </div>

    <!-- 3. KAPSAMLI ÜST FİLTRE & ARAMA PANELİ (Segmented Control & Linear Inputs) -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-2xs p-3.5 sm:p-4 space-y-3">
        <!-- Üst Satır: Sekmeler + Arama -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-3 pb-3 border-b border-slate-100">
            <!-- Tür Sekmeleri (Segmented Bar) -->
            <div class="inline-flex p-1 bg-slate-100 rounded-lg border border-slate-200/80 overflow-x-auto no-scrollbar">
                <button wire:click="$set('activeTab', 'all')" class="px-3 py-1.5 text-xs font-bold rounded-md transition-all whitespace-nowrap shrink-0 {{ $activeTab === 'all' ? 'bg-white text-slate-900 shadow-2xs border border-slate-200/60' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-200/40' }}">
                    Tümü <span class="ml-1 text-[10px] font-mono px-1.5 py-0.5 rounded bg-slate-200/70 text-slate-700">({{ $stream->count() }})</span>
                </button>
                <button wire:click="$set('activeTab', 'expected')" class="px-3 py-1.5 text-xs font-bold rounded-md transition-all whitespace-nowrap shrink-0 {{ $activeTab === 'expected' ? 'bg-white text-slate-900 shadow-2xs border border-slate-200/60' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-200/40' }}">
                    Beklenen <span class="ml-1 text-[10px] font-mono px-1.5 py-0.5 rounded bg-slate-200/70 text-slate-700">({{ $expectedIncomes->count() }})</span>
                </button>
                <button wire:click="$set('activeTab', 'income')" class="px-3 py-1.5 text-xs font-bold rounded-md transition-all whitespace-nowrap shrink-0 {{ $activeTab === 'income' ? 'bg-white text-emerald-700 shadow-2xs border border-slate-200/60' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-200/40' }}">
                    Gelirler
                </button>
                <button wire:click="$set('activeTab', 'expense')" class="px-3 py-1.5 text-xs font-bold rounded-md transition-all whitespace-nowrap shrink-0 {{ $activeTab === 'expense' ? 'bg-white text-rose-700 shadow-2xs border border-slate-200/60' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-200/40' }}">
                    Giderler
                </button>
                <button wire:click="$set('activeTab', 'recurring')" class="px-3 py-1.5 text-xs font-bold rounded-md transition-all whitespace-nowrap shrink-0 {{ $activeTab === 'recurring' ? 'bg-white text-indigo-700 shadow-2xs border border-slate-200/60' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-200/40' }}">
                    Sabit & Tekrarlayan
                </button>
            </div>

            <!-- Canlı Arama Inputu -->
            <div class="relative w-full lg:w-72">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 text-xs">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                </span>
                <input type="text" 
                       wire:model.live.debounce.300ms="search" 
                       placeholder="Gelir, gider veya kategori ara..." 
                       class="w-full pl-9 pr-8 py-1.5 bg-slate-50 border border-slate-300 rounded-lg text-xs sm:text-sm font-medium focus:bg-white focus:ring-1 focus:ring-indigo-600 focus:border-indigo-600 transition-all">
                @if ($search)
                    <button wire:click="$set('search', '')" class="absolute inset-y-0 right-0 pr-2.5 flex items-center text-slate-400 hover:text-slate-600 text-xs font-bold cursor-pointer">
                        ✕
                    </button>
                @endif
            </div>
        </div>

        <!-- Alt Satır: Filtre Seçicileri (Kategori, Sıralama, Tarih Aralığı) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 items-center text-xs">
            <!-- 1. Kategori Seçimi -->
            <div>
                <label class="block font-bold text-gray-600 mb-1 text-[11px]">Kategori Filtresi</label>
                <select wire:model.live="selected_category_id" class="w-full rounded-lg border-slate-300 bg-slate-50 py-1.5 text-xs font-medium focus:bg-white focus:ring-1 focus:ring-indigo-600 focus:border-indigo-600">
                    <option value="">Tüm Kategoriler</option>
                    @foreach ($categories as $c)
                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- 2. Sıralama -->
            <div>
                <label class="block font-bold text-gray-600 mb-1 text-[11px]">Sıralama Algoritması</label>
                <select wire:model.live="sortBy" class="w-full rounded-lg border-slate-300 bg-slate-50 py-1.5 text-xs font-medium focus:bg-white focus:ring-1 focus:ring-indigo-600 focus:border-indigo-600">
                    <option value="date_desc">Tarihe Göre (En Yeni - İlk)</option>
                    <option value="date_asc">Tarihe Göre (En Eski)</option>
                    <option value="amount_desc">En Yüksek Tutar</option>
                    <option value="amount_asc">En Düşük Tutar</option>
                    <option value="title">Başlık (A-Z)</option>
                </select>
            </div>

            <!-- 3. Tarih Aralığı -->
            <div>
                <label class="block font-bold text-gray-600 mb-1 text-[11px]">Başlangıç Tarihi</label>
                <input type="date" wire:model.live="date_from" class="w-full rounded-lg border-slate-300 bg-slate-50 py-1.5 text-xs font-medium focus:bg-white focus:ring-1 focus:ring-indigo-600 focus:border-indigo-600">
            </div>

            <div>
                <label class="block font-bold text-gray-600 mb-1 text-[11px]">Bitiş Tarihi</label>
                <input type="date" wire:model.live="date_to" class="w-full rounded-lg border-slate-300 bg-slate-50 py-1.5 text-xs font-medium focus:bg-white focus:ring-1 focus:ring-indigo-600 focus:border-indigo-600">
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
                    $isExpected = $item->type === 'expected_income';
                    $isIncome = $item->type === 'income';
                @endphp
                <div class="bg-white rounded-2xl border border-gray-200/90 hover:border-gray-300 p-4 sm:p-5 shadow-xs hover:shadow-md transition-all flex flex-col sm:flex-row sm:items-center justify-between gap-3 relative overflow-hidden group">
                    <!-- Sol Renk Şeridi -->
                    <div class="absolute top-0 bottom-0 left-0 w-1.5 {{ $isExpected ? 'bg-teal-500' : ($isIncome ? 'bg-emerald-500' : 'bg-rose-500') }}"></div>

                    <!-- Sol Taraf: İkon + Başlık + Tarih & Kategori -->
                    <div class="flex items-center gap-3.5 pl-2 min-w-0">
                        <div class="w-10 h-10 rounded-xl {{ $isExpected ? 'bg-teal-50 text-teal-600' : ($isIncome ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600') }} flex items-center justify-center text-lg font-black shrink-0">
                            {{ $isExpected ? '🗓️' : ($isIncome ? '↓' : '↑') }}
                        </div>
                        <div class="min-w-0">
                            <div class="flex items-center gap-2 flex-wrap">
                                <h3 class="font-bold text-gray-900 text-sm sm:text-base truncate">{{ $item->title }}</h3>
                                <span class="px-2 py-0.5 rounded-md text-[10px] font-black {{ $isExpected ? 'bg-teal-100 text-teal-800' : ($isIncome ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800') }}">
                                    {{ $item->badge }}
                                </span>
                                @if (!empty($item->source_label))
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-lg text-[10.5px] font-black border shadow-xs" 
                                          style="background-color: {{ $item->source_color }}18; border-color: {{ $item->source_color }}60; color: {{ $item->source_color }};">
                                        <span class="w-1.5 h-1.5 rounded-full shrink-0" style="background-color: {{ $item->source_color }};"></span>
                                        <span>{{ $item->source_label }}</span>
                                    </span>
                                @endif

                                @if (!empty($item->installment_badge))
                                    <span class="px-2 py-0.5 rounded-md text-[10px] font-black bg-indigo-50 text-indigo-700 border border-indigo-200">
                                        {{ $item->installment_badge }}
                                    </span>
                                @endif
                                @if ($item->is_recurring && empty($item->installment_badge))
                                    <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-100">
                                        Tekrarlayan
                                    </span>
                                @endif
                            </div>
                            <p class="text-xs text-gray-500 mt-0.5 flex items-center gap-2">
                                <span>{{ \Carbon\Carbon::parse($item->date)->format('d.m.Y') }}</span>
                                <span>·</span>
                                <span>{{ $item->category_name }}</span>
                            </p>
                        </div>
                    </div>

                    <!-- Sağ Taraf: Tutar + Hızlı Aksiyonlar -->
                    <div class="flex items-center justify-between sm:justify-end gap-4 pl-2 sm:pl-0 border-t sm:border-t-0 pt-2 sm:pt-0 border-gray-100">
                        <div class="text-left sm:text-right">
                            <span class="text-lg sm:text-xl font-black block {{ $isExpected ? 'text-teal-600' : ($isIncome ? 'text-emerald-600' : 'text-rose-600') }}">
                                {{ $isExpected ? '₺' : ($isIncome ? '+' : '-') . '₺' }}{{ number_format($item->amount, 2, ',', '.') }}
                            </span>
                            <span class="text-[10px] text-gray-400 font-medium block">
                                {{ $isExpected ? 'Beklenen Gelir' : ($isIncome ? 'Nakit Girişi' : 'Harcama / Çıkış') }}
                            </span>
                        </div>

                        <div class="flex items-center gap-1.5">
                            @if ($isExpected)
                                <button wire:click="confirmExpectedIncome({{ $item->id }})" class="px-2.5 py-1 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-black text-xs shadow-xs" title="Hesaba Geçti Olarak Onayla">
                                    Geldi
                                </button>
                                <button wire:click="delayExpectedIncome({{ $item->id }}, 3)" class="px-2 py-1 bg-amber-50 hover:bg-amber-100 border border-amber-300 text-amber-900 rounded-lg font-bold text-xs" title="3 Gün Ertele">
                                    3G Ertele
                                </button>
                                <button wire:click="openEditExpectedIncome({{ $item->id }})" class="p-1.5 text-gray-400 hover:text-indigo-600 rounded-lg hover:bg-gray-100 transition-colors text-xs font-bold" title="Düzenle">
                                    Düzenle
                                </button>
                                <button wire:click="deleteExpectedIncome({{ $item->id }})" wire:confirm="Bu beklenen geliri silmek istediğinize emin misiniz?" class="p-1.5 text-gray-400 hover:text-red-600 rounded-lg hover:bg-gray-100 transition-colors text-xs font-bold" title="Sil">
                                    Sil
                                </button>
                            @elseif ($isIncome)
                                <button wire:click="openEditIncome({{ $item->id }})" class="p-1.5 text-gray-400 hover:text-indigo-600 rounded-lg hover:bg-gray-100 transition-colors text-xs font-bold">
                                    Düzenle
                                </button>
                                <button wire:click="deleteIncome({{ $item->id }})" wire:confirm="Bu gelir kaydını silmek istediğinize emin misiniz?" class="p-1.5 text-gray-400 hover:text-red-600 rounded-lg hover:bg-gray-100 transition-colors text-xs font-bold">
                                    Sil
                                </button>
                            @else
                                <button wire:click="openEditExpense({{ $item->id }})" class="p-1.5 text-gray-400 hover:text-indigo-600 rounded-lg hover:bg-gray-100 transition-colors text-xs font-bold">
                                    Düzenle
                                </button>
                                <button wire:click="deleteExpense({{ $item->id }})" wire:confirm="Bu gider kaydını silmek istediğinize emin misiniz?" class="p-1.5 text-gray-400 hover:text-red-600 rounded-lg hover:bg-gray-100 transition-colors text-xs font-bold">
                                    Sil
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-3xl p-12 text-center border-2 border-dashed border-gray-200 space-y-3">
                    <svg class="w-10 h-10 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
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
                                <span class="text-xs text-gray-500">{{ $inc->type === 'salary' ? 'Maaş' : 'Ek Gelir' }} · Her Ayın 1'i</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="font-black text-sm text-emerald-600">+₺{{ number_format($inc->amount, 2, ',', '.') }}</span>
                                <button wire:click="openEditIncome({{ $inc->id }})" class="text-gray-400 hover:text-indigo-600 text-xs">Düzenle</button>
                                <button wire:click="deleteIncome({{ $inc->id }})" wire:confirm="Bu geliri silmek istediğinize emin misiniz?" class="text-gray-400 hover:text-red-600 text-xs">Sil</button>
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
                                <div class="flex items-center gap-1.5 flex-wrap text-xs text-gray-500 mt-0.5">
                                    <span>{{ $exp->category?->name ?? 'Genel Gider' }} · {{ \Carbon\Carbon::parse($exp->expense_date)->format('d.m.Y') }}</span>
                                    @php
                                        $expColor = $exp->creditCard?->bank?->color ?? ($exp->account?->bank?->color ?? '#64748b');
                                    @endphp
                                    @if ($exp->payment_method === 'credit_card' && $exp->creditCard)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-black border shadow-xs" 
                                              style="background-color: {{ $expColor }}18; border-color: {{ $expColor }}60; color: {{ $expColor }};">
                                            <span class="w-1.5 h-1.5 rounded-full shrink-0" style="background-color: {{ $expColor }};"></span>
                                            <span>{{ $exp->creditCard->bank?->name ?? '' }} · {{ $exp->creditCard->name }}</span>
                                        </span>
                                    @elseif (in_array($exp->payment_method, ['account', 'kmh']) && $exp->account)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-black border shadow-xs" 
                                              style="background-color: {{ $expColor }}18; border-color: {{ $expColor }}60; color: {{ $expColor }};">
                                            <span class="w-1.5 h-1.5 rounded-full shrink-0" style="background-color: {{ $expColor }};"></span>
                                            <span>{{ $exp->account->bank?->name ?? '' }} · {{ $exp->account->name }}</span>
                                        </span>
                                    @elseif ($exp->payment_method === 'cash')
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-black bg-gray-100 text-gray-700 border border-gray-300">
                                            Nakit
                                        </span>
                                    @endif
                                    @if ($exp->installment_count > 1)
                                        <span class="px-1.5 py-0.5 rounded text-[10px] font-black bg-indigo-50 text-indigo-700 border border-indigo-200">
                                            {{ $exp->current_installment }}/{{ $exp->installment_count }} Taksit
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="font-black text-sm text-rose-600">-₺{{ number_format($exp->amount, 2, ',', '.') }}</span>
                                <button wire:click="openEditExpense({{ $exp->id }})" class="text-gray-400 hover:text-indigo-600 text-xs">Düzenle</button>
                                <button wire:click="deleteExpense({{ $exp->id }})" wire:confirm="Bu gideri silmek istediğinize emin misiniz?" class="text-gray-400 hover:text-red-600 text-xs">Sil</button>
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
                            <th class="px-6 py-3.5">Ödeme Kaynağı / Kart & Banka</th>
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
                                <td class="px-6 py-4">
                                    @if (!empty($item->source_label))
                                        <div class="flex items-center gap-1.5 flex-wrap">
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-black border shadow-xs" 
                                                  style="background-color: {{ $item->source_color }}18; border-color: {{ $item->source_color }}60; color: {{ $item->source_color }};">
                                                <span class="w-1.5 h-1.5 rounded-full shrink-0" style="background-color: {{ $item->source_color }};"></span>
                                                <span>{{ $item->source_label }}</span>
                                            </span>
                                            @if (!empty($item->installment_badge))
                                                <span class="px-1.5 py-0.5 rounded text-[10px] font-black bg-indigo-50 text-indigo-700 border border-indigo-200 shrink-0">
                                                    {{ $item->installment_badge }}
                                                </span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-xs text-gray-400">-</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-xs text-gray-600">
                                    {{ \Carbon\Carbon::parse($item->date)->format('d.m.Y') }}
                                </td>
                                <td class="px-6 py-4 text-xs text-gray-600">
                                    {{ $item->is_recurring ? 'Aylık Düzenli' : 'Tek Seferlik' }}
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
                                <td colspan="7" class="px-6 py-8 text-center text-gray-500">
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

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Gelir Tarihi</label>
                            <input type="date" wire:model="income_date" class="w-full rounded-xl border-gray-300 text-sm font-medium focus:ring-emerald-500 focus:border-emerald-500">
                            @error('income_date') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Net Tutar (TL)</label>
                            <input type="number" step="0.01" wire:model="income_amount" class="w-full rounded-xl border-gray-300 text-sm font-black text-emerald-600 focus:ring-emerald-500 focus:border-emerald-500" placeholder="65000">
                            @error('income_amount') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>
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
                        <label class="block text-xs font-bold text-gray-700 mb-1">Harcama Başlığı</label>
                        <input type="text" wire:model="expense_title" class="w-full rounded-xl border-gray-300 text-sm font-medium focus:ring-rose-500 focus:border-rose-500" placeholder="Örn: Market Alışverişi veya Sigorta Poliçesi">
                        @error('expense_title') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                    </div>

                    <!-- Ödeme Yöntemi & İlgili Kart/Hesap -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 p-3 bg-slate-50 rounded-xl border border-slate-200/80">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Nereden Ödendi?</label>
                            <select wire:model.live="payment_method" class="w-full rounded-xl border-gray-300 text-xs font-bold focus:ring-rose-500 focus:border-rose-500">
                                <option value="credit_card">Kredi Kartı</option>
                                <option value="kmh">KMH / Ek Para (Avans)</option>
                                <option value="account">Vadesiz Banka Hesabı</option>
                                <option value="cash">Nakit / Cüzdan</option>
                            </select>
                        </div>

                        <div>
                            @if ($payment_method === 'credit_card')
                                <label class="block text-xs font-bold text-gray-700 mb-1">Hangi Kredi Kartınız?</label>
                                <select wire:model="expense_credit_card_id" class="w-full rounded-xl border-gray-300 text-xs font-medium focus:ring-rose-500 focus:border-rose-500">
                                    <option value="">Kart Seçin</option>
                                    @foreach ($userCards as $uc)
                                        <option value="{{ $uc->id }}">{{ $uc->bank?->name }} - {{ $uc->name }} ({{ $uc->masked_card_number }})</option>
                                    @endforeach
                                </select>
                            @elseif (in_array($payment_method, ['account', 'kmh']))
                                <label class="block text-xs font-bold text-gray-700 mb-1">Hangi Banka Hesabı?</label>
                                <select wire:model="expense_account_id" class="w-full rounded-xl border-gray-300 text-xs font-medium focus:ring-rose-500 focus:border-rose-500">
                                    <option value="">Hesap Seçin</option>
                                    @foreach ($userAccounts as $ua)
                                        <option value="{{ $ua->id }}">{{ $ua->bank?->name }} - {{ $ua->name }} ({{ $ua->masked_iban }})</option>
                                    @endforeach
                                </select>
                            @else
                                <label class="block text-xs font-bold text-gray-700 mb-1">Ödeme Türü</label>
                                <div class="text-xs text-gray-500 font-bold py-2">Elden / Nakit Harcama</div>
                            @endif
                        </div>
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
                        <label class="block text-xs font-bold text-gray-700 mb-1">Toplam Tutar (TL)</label>
                        <input type="number" step="0.01" wire:model.live="expense_amount" class="w-full rounded-xl border-gray-300 text-sm font-black text-rose-600 focus:ring-rose-500 focus:border-rose-500" placeholder="1500.00">
                        @error('expense_amount') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                    </div>

                    <!-- Taksitli İşlem Seçeneği -->
                    <div class="p-3 bg-amber-50/70 rounded-xl border border-amber-200/80 space-y-2.5">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" wire:model.live="is_installment" class="rounded border-amber-400 text-amber-600 focus:ring-amber-500">
                            <span class="text-xs font-black text-amber-900">Taksitli İşlem (Gelecek Aylara Eşit Dağıt)</span>
                        </label>

                        @if ($is_installment)
                            <div class="grid grid-cols-2 gap-3 pt-1 border-amber-200/60 items-center">
                                <div>
                                    <label class="block text-[11px] font-bold text-amber-800 mb-1">Taksit Sayısı</label>
                                    <select wire:model.live="installment_count" class="w-full rounded-xl border-amber-300 text-xs font-bold bg-white focus:ring-amber-500 focus:border-amber-500">
                                        <option value="2">2 Taksit</option>
                                        <option value="3">3 Taksit</option>
                                        <option value="4">4 Taksit</option>
                                        <option value="6">6 Taksit</option>
                                        <option value="9">9 Taksit</option>
                                        <option value="12">12 Taksit</option>
                                        <option value="18">18 Taksit</option>
                                        <option value="24">24 Taksit</option>
                                    </select>
                                </div>
                                <div class="text-right">
                                    <span class="text-[10px] font-bold text-amber-700 block uppercase">Aylık Taksit</span>
                                    <span class="text-sm font-black text-amber-900">
                                        ₺{{ $installment_count > 0 && $expense_amount > 0 ? number_format($expense_amount / $installment_count, 2, ',', '.') : '0,00' }} / Ay
                                    </span>
                                </div>
                            </div>
                            <p class="text-[10px] text-amber-700">
                                {{ $installment_count }} ay boyunca her aya ₺{{ $installment_count > 0 && $expense_amount > 0 ? number_format($expense_amount / $installment_count, 2, ',', '.') : '0,00' }} taksit harcaması otomatik işlenir.
                            </p>
                        @endif
                    </div>

                    @if (!$is_installment)
                        <div class="flex items-center gap-2 pt-0.5">
                            <input type="checkbox" id="expense_recurring" wire:model="expense_is_recurring" class="rounded border-gray-300 text-rose-600 focus:ring-rose-500">
                            <label for="expense_recurring" class="text-xs font-bold text-gray-700 cursor-pointer">
                                Her ay tekrarlayan sabit gider (Kira, Fatura, Aidat vb.)
                            </label>
                        </div>
                    @endif

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

    <!-- BEKLENEN GELİR EKLEME / DÜZENLEME MODAL'I -->
    @if ($showExpectedIncomeModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-xs p-4">
            <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl space-y-4 max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                        <h3 class="font-bold text-base sm:text-lg text-gray-900">
                            {{ $expectedIncomeId ? 'Beklenen Geliri Düzenle' : 'Yeni Beklenen Gelir Tanımla' }}
                        </h3>
                    </div>
                    <button wire:click="$set('showExpectedIncomeModal', false)" class="text-gray-400 hover:text-gray-600 text-lg font-bold">✕</button>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Gelir Başlığı / Kaynağı *</label>
                        <input type="text" wire:model="expected_title" class="w-full rounded-xl border-gray-300 text-sm font-medium focus:ring-indigo-500 focus:border-indigo-500" placeholder="Örn: Melih Günal Hakediş, Maaş, Elden Tahsilat">
                        @error('expected_title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Beklenen Tutar (TL) *</label>
                            <input type="number" step="0.01" wire:model="expected_amount" class="w-full rounded-xl border-gray-300 text-sm font-bold text-gray-900 focus:ring-indigo-500 focus:border-indigo-500" placeholder="0.00">
                            @error('expected_amount') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Beklenen Vade / Tarih *</label>
                            <input type="date" wire:model="expected_date" class="w-full rounded-xl border-gray-300 text-sm font-bold text-gray-900 focus:ring-indigo-500 focus:border-indigo-500">
                            @error('expected_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Gelir Türü</label>
                            <select wire:model="expected_type" class="w-full rounded-xl border-gray-300 text-xs font-bold bg-white focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="salary">Maaş / Ana Gelir</option>
                                <option value="freelance">Freelance / Hakediş</option>
                                <option value="rental">Kira Geliri</option>
                                <option value="debt_collection">Borç Tahsilatı (Elden)</option>
                                <option value="investment">Yatırım / Temettü</option>
                                <option value="other">Diğer Gelir</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Tekrarlama Sıklığı</label>
                            <select wire:model="expected_frequency" class="w-full rounded-xl border-gray-300 text-xs font-bold bg-white focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="monthly">Her Ay Tekrarlayan</option>
                                <option value="once">Tek Seferlik</option>
                                <option value="weekly">Haftalık</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Not / Açıklama (İsteğe bağlı)</label>
                        <textarea wire:model="expected_notes" rows="2" class="w-full rounded-xl border-gray-300 text-xs font-medium focus:ring-indigo-500 focus:border-indigo-500" placeholder="Örn: Proje teslimi sonrası ödenecek"></textarea>
                    </div>

                    <div class="p-3 bg-indigo-50/70 rounded-xl border border-indigo-200/80">
                        <p class="text-[11px] text-indigo-900 leading-relaxed font-medium flex items-center gap-1">
                            <svg class="w-4 h-4 text-indigo-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.516 0c.85.493 1.508 1.333 1.508 2.316V18"/></svg>
                            <span><strong>Akıllı Takip:</strong> Bu tarihe gelindiğinde sistem Dashboard'da size <em>"Geldi mi / Gecikti mi?"</em> diye soracak ve onayladığınızda nakit akışınıza otomatik işlenecektir.</span>
                        </p>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-3 border-t border-gray-100">
                    <button wire:click="$set('showExpectedIncomeModal', false)" class="px-4 py-2 text-sm font-bold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors cursor-pointer">
                        İptal
                    </button>
                    <button wire:click="saveExpectedIncome" class="px-6 py-2 text-sm font-black text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-md transition-all active:scale-95 cursor-pointer">
                        Kaydet
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
