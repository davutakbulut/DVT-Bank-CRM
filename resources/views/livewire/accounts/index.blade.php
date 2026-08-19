<div class="py-2 sm:py-6 px-3 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-6">
    <!-- 1. Header & Yeni Hesap Ekle -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight flex items-center gap-2">
                <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.5M4.5 21V10.5"/></svg>
                <span>Banka Hesaplarım & KMH</span>
            </h1>
            <p class="text-xs sm:text-sm text-gray-600 mt-0.5">Vadesiz, vadeli ve ek hesap (KMH) bakiyelerinizin anlık net durumu</p>
        </div>
        <div class="flex items-center justify-between sm:justify-end gap-2 sm:gap-2.5 w-full sm:w-auto">
            <!-- Excel / CSV İndirme Butonu -->
            <div class="relative group/tooltip" x-data="{ show: false }">
                <button wire:click="exportExcel" 
                        @mouseenter="show = true" 
                        @mouseleave="show = false"
                        class="inline-flex items-center gap-1 px-3 py-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-300 font-bold text-xs rounded-lg shadow-2xs transition-all active:scale-95 cursor-pointer">
                    <svg class="w-4 h-4 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                    <span>Excel</span>
                </button>

                <!-- Açıklayıcı Bilgi Popup (Tooltip) -->
                <div x-show="show" 
                     x-cloak
                     class="absolute left-0 sm:left-auto sm:right-0 top-full mt-2 w-72 p-3 bg-slate-900 text-white rounded-xl shadow-2xl border border-slate-700 text-xs z-50 pointer-events-none transition-all">
                    <div class="flex items-center gap-1.5 font-bold text-emerald-300 border-b border-slate-800 pb-1.5 mb-1.5">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.5M4.5 21V10.5"/></svg>
                        <span>Banka Hesapları Excel Raporu</span>
                    </div>
                    <p class="text-[11px] text-slate-300 leading-relaxed">
                        Tüm vadesiz ve vadeli mevduat hesaplarınızın güncel bakiyelerini, IBAN numaralarını, tanımlı KMH (ek para) limitlerini ve kullanılan eksi bakiyeleri içeren <strong>Excel tablosunu</strong> indirir.
                    </p>
                    <span class="block mt-2 text-[10px] font-bold text-emerald-400 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        <span>Excel & Google Sheets Uyumlu</span>
                    </span>
                </div>
            </div>

            <!-- Görünüm Seçici -->
            <div class="inline-flex rounded-lg bg-slate-100 p-1 border border-slate-200/80 shadow-2xs">
                <button wire:click="$set('viewMode', 'stacked')" class="px-2.5 py-1 rounded-md text-xs font-bold transition-all flex items-center gap-1 cursor-pointer {{ $viewMode === 'stacked' ? 'bg-white text-indigo-700 shadow-2xs border border-slate-200/60' : 'text-slate-600 hover:text-slate-900' }}">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.429 9.75L2.25 12l4.179 2.25m0-4.5l4.179 2.25m-4.179-2.25l4.179-2.25m4.179 6.75l4.179-2.25m-4.179 2.25l-4.179-2.25m4.179 2.25L21.75 12l-4.179-2.25m0 0l-4.179 2.25m4.179-2.25l-4.179-2.25"/></svg>
                    <span class="hidden sm:inline">Banka Yığını</span>
                </button>
                <button wire:click="$set('viewMode', 'grid')" class="px-2.5 py-1 rounded-md text-xs font-bold transition-all flex items-center gap-1 cursor-pointer {{ $viewMode === 'grid' ? 'bg-white text-indigo-700 shadow-2xs border border-slate-200/60' : 'text-slate-600 hover:text-slate-900' }}">
                    <span>▦</span>
                    <span class="hidden sm:inline">Izgara</span>
                </button>
                <button wire:click="$set('viewMode', 'table')" class="px-2.5 py-1 rounded-md text-xs font-bold transition-all flex items-center gap-1 cursor-pointer {{ $viewMode === 'table' ? 'bg-white text-indigo-700 shadow-2xs border border-slate-200/60' : 'text-slate-600 hover:text-slate-900' }}">
                    <span>📑</span>
                    <span class="hidden sm:inline">Tablo</span>
                </button>
            </div>

            <button wire:click="openCreateModal" class="inline-flex items-center gap-1.5 px-3.5 sm:px-4 py-2 bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white font-black text-xs sm:text-sm rounded-lg shadow-xs transition-all whitespace-nowrap cursor-pointer">
                <span>+ Yeni Hesap</span>
            </button>
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
        <!-- Kullanılabilir Toplam Likidite (Vadesiz + Kalan KMH) -->
        <div class="bg-white p-3.5 sm:p-4 rounded-xl border border-slate-200/80 shadow-2xs flex items-center gap-2.5 sm:gap-3">
            <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-base sm:text-lg font-black shrink-0">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-6h6"/></svg>
            </div>
            <div class="min-w-0 flex-1">
                <span class="text-[10px] sm:text-[11px] font-bold text-gray-500 block uppercase tracking-wider truncate">Kullanılabilir Likidite</span>
                <span class="text-[13px] sm:text-lg lg:text-xl font-black font-mono text-emerald-600 tracking-tight block">₺{{ number_format($totalAvailableLiquidity, 2, ',', '.') }}</span>
                <span class="text-[9px] text-gray-400 block truncate font-medium">Kalan Ek Hesap + Nakit</span>
            </div>
        </div>

        <!-- Kullanılan KMH Borcu -->
        <div class="bg-white p-3.5 sm:p-4 rounded-xl border border-slate-200/80 shadow-2xs flex items-center gap-2.5 sm:gap-3">
            <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg bg-red-50 text-red-600 flex items-center justify-center text-base sm:text-lg font-black shrink-0">
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/></svg>
            </div>
            <div class="min-w-0 flex-1">
                <span class="text-[10px] sm:text-[11px] font-bold text-gray-500 block uppercase tracking-wider truncate">Kullanılan KMH</span>
                <span class="text-[13px] sm:text-lg lg:text-xl font-black font-mono text-red-600 tracking-tight block">₺{{ number_format($totalKmhDebt, 2, ',', '.') }}</span>
                <span class="text-[9px] text-gray-400 block truncate font-medium">Toplam Eksi Bakiye</span>
            </div>
        </div>

        <!-- Toplam KMH Limiti -->
        <div class="bg-white p-3.5 sm:p-4 rounded-xl border border-slate-200/80 shadow-2xs flex items-center gap-2.5 sm:gap-3">
            <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center text-base sm:text-lg font-black shrink-0">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
            </div>
            <div class="min-w-0 flex-1">
                <span class="text-[10px] sm:text-[11px] font-bold text-gray-500 block uppercase tracking-wider truncate">Tanımlı KMH Limiti</span>
                <span class="text-[13px] sm:text-lg lg:text-xl font-black font-mono text-indigo-700 tracking-tight block">₺{{ number_format($totalKmhLimit, 2, ',', '.') }}</span>
                <span class="text-[9px] text-gray-400 block truncate font-medium">Toplam Banka Limitleri</span>
            </div>
        </div>

        <!-- Net Likidite -->
        <div class="bg-white p-3.5 sm:p-4 rounded-xl border border-slate-200/80 shadow-2xs flex items-center gap-2.5 sm:gap-3">
            <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg {{ $netLiquidity < 0 ? 'bg-red-50 text-red-600' : 'bg-blue-50 text-blue-600' }} flex items-center justify-center text-base sm:text-lg font-black shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
            </div>
            <div class="min-w-0 flex-1">
                <span class="text-[10px] sm:text-[11px] font-bold text-gray-500 block uppercase tracking-wider truncate">Net Nakit Durumu</span>
                <span class="text-[13px] sm:text-lg lg:text-xl font-black font-mono {{ $netLiquidity < 0 ? 'text-red-600' : 'text-gray-900' }} tracking-tight block truncate">
                    ₺{{ number_format($netLiquidity, 2, ',', '.') }}
                </span>
                <span class="text-[9px] text-gray-400 block truncate font-medium">Nakit eksi KMH Borcu</span>
            </div>
        </div>
    </div>

    <!-- 3. ÜST FİLTRE & ARAMA BAR (Segmented Control & Linear Inputs) -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-2xs p-3.5 sm:p-4 space-y-3">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-3">
            <!-- Tür Sekmeleri (Segmented Bar) -->
            <div class="inline-flex p-1 bg-slate-100 rounded-lg border border-slate-200/80 overflow-x-auto no-scrollbar">
                <button wire:click="$set('activeType', 'all')" class="px-3 py-1.5 text-xs font-bold rounded-md transition-all whitespace-nowrap shrink-0 {{ $activeType === 'all' ? 'bg-white text-slate-900 shadow-2xs border border-slate-200/60' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-200/40' }}">
                    Tümü <span class="ml-1 text-[10px] font-mono px-1.5 py-0.5 rounded bg-slate-200/70 text-slate-700">({{ $accounts->count() }})</span>
                </button>
                <button wire:click="$set('activeType', 'checking')" class="px-3 py-1.5 text-xs font-bold rounded-md transition-all whitespace-nowrap shrink-0 {{ $activeType === 'checking' ? 'bg-white text-slate-900 shadow-2xs border border-slate-200/60' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-200/40' }}">
                    Vadesiz
                </button>
                <button wire:click="$set('activeType', 'kmh')" class="px-3 py-1.5 text-xs font-bold rounded-md transition-all whitespace-nowrap shrink-0 {{ $activeType === 'kmh' ? 'bg-white text-slate-900 shadow-2xs border border-slate-200/60' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-200/40' }}">
                    KMH / Eksi
                </button>
                <button wire:click="$set('activeType', 'savings')" class="px-3 py-1.5 text-xs font-bold rounded-md transition-all whitespace-nowrap shrink-0 {{ $activeType === 'savings' ? 'bg-white text-slate-900 shadow-2xs border border-slate-200/60' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-200/40' }}">
                    Vadeli Mevduat
                </button>
            </div>

            <!-- Banka Seçimi & Canlı Arama -->
            <div class="flex items-center gap-2">
                <select wire:model.live="selected_bank_id" class="rounded-lg border-slate-300 bg-slate-50 py-1.5 text-xs font-medium focus:bg-white focus:ring-1 focus:ring-indigo-600 focus:border-indigo-600">
                    <option value="">Tüm Bankalar</option>
                    @foreach ($banks as $b)
                        <option value="{{ $b->id }}">{{ $b->name }}</option>
                    @endforeach
                </select>

                <div class="relative w-48 sm:w-60">
                    <input type="text" 
                           wire:model.live.debounce.300ms="search" 
                           placeholder="Hesap veya IBAN ara..." 
                           class="w-full pl-8 pr-7 py-1.5 bg-slate-50 border border-slate-300 rounded-lg text-xs font-medium focus:bg-white focus:ring-1 focus:ring-indigo-600 focus:border-indigo-600">
                    <span class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none text-slate-400 text-xs">
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                    </span>
                    @if ($search)
                        <button wire:click="$set('search', '')" class="absolute inset-y-0 right-0 pr-2 flex items-center text-slate-400 hover:text-slate-600 text-xs font-bold cursor-pointer">
                            ✕
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- 4. GÖRÜNÜM 1: BANKA BAZLI YIĞIN KARTLAR (STACKED DECK VIEW) -->
    @if ($viewMode === 'stacked')
        <div class="space-y-8">
            @forelse ($groupedByBank as $bankId => $bankAccounts)
                @php
                    $firstAcc = $bankAccounts->first();
                    $bankName = $firstAcc->bank?->name ?? 'Diğer Banka';
                    $bankNameLower = mb_strtolower($bankName);
                    $bankColor = $firstAcc->bank?->color ?? '#6366f1';
                    $bankTotal = $bankAccounts->sum('balance');
                    $accCount = $bankAccounts->count();

                    // Banka Teması & Gradyan Eşleştirmesi
                    if (str_contains($bankNameLower, 'garanti')) {
                        $bankGradient = 'from-[#004d25] via-[#023318] to-[#011409]';
                        $accentBorder = 'border-emerald-500/40';
                        $glowColor = 'bg-emerald-500/20';
                        $themeLabel = 'Garanti BBVA • Dijital Hesap';
                    } elseif (str_contains($bankNameLower, 'akbank')) {
                        $bankGradient = 'from-[#990000] via-[#660000] to-[#260000]';
                        $accentBorder = 'border-red-500/40';
                        $glowColor = 'bg-red-500/20';
                        $themeLabel = 'Akbank • Artı Para & Vadesiz';
                    } elseif (str_contains($bankNameLower, 'iş') || str_contains($bankNameLower, 'is bankasi')) {
                        $bankGradient = 'from-[#003366] via-[#001f3f] to-[#000d1a]';
                        $accentBorder = 'border-blue-500/40';
                        $glowColor = 'bg-blue-500/20';
                        $themeLabel = 'İş Bankası • Mevduat & Ek Hesap';
                    } elseif (str_contains($bankNameLower, 'yapı') || str_contains($bankNameLower, 'yapi')) {
                        $bankGradient = 'from-[#004b87] via-[#002d52] to-[#001324]';
                        $accentBorder = 'border-sky-500/40';
                        $glowColor = 'bg-sky-500/20';
                        $themeLabel = 'Yapı Kredi • Esnek Hesap';
                    } elseif (str_contains($bankNameLower, 'ziraat')) {
                        $bankGradient = 'from-[#8a0010] via-[#54000a] to-[#240004]';
                        $accentBorder = 'border-rose-500/40';
                        $glowColor = 'bg-rose-500/20';
                        $themeLabel = 'Ziraat Bankası • Başak Hesap';
                    } elseif (str_contains($bankNameLower, 'vakıf') || str_contains($bankNameLower, 'vakif')) {
                        $bankGradient = 'from-[#a36f00] via-[#664600] to-[#291c00]';
                        $accentBorder = 'border-amber-500/40';
                        $glowColor = 'bg-amber-500/20';
                        $themeLabel = 'VakıfBank • Kredili Mevduat';
                    } elseif (str_contains($bankNameLower, 'halk')) {
                        $bankGradient = 'from-[#004d80] via-[#002b47] to-[#00101a]';
                        $accentBorder = 'border-cyan-500/40';
                        $glowColor = 'bg-cyan-500/20';
                        $themeLabel = 'Halkbank • Açık Hesap';
                    } elseif (str_contains($bankNameLower, 'qnb') || str_contains($bankNameLower, 'enpara')) {
                        $bankGradient = 'from-[#4a154b] via-[#2d0d2e] to-[#120512]';
                        $accentBorder = 'border-purple-500/40';
                        $glowColor = 'bg-purple-500/20';
                        $themeLabel = 'QNB / Enpara • Vadesiz & Ekpara';
                    } else {
                        $bankGradient = 'from-slate-900 via-indigo-950 to-slate-950';
                        $accentBorder = 'border-indigo-500/30';
                        $glowColor = 'bg-indigo-500/15';
                        $themeLabel = 'Banka Hesabı';
                    }
                @endphp

                <div class="bg-white rounded-3xl border border-gray-200/90 p-5 sm:p-6 shadow-sm space-y-5">
                    <!-- Banka Başlığı ve Toplam Bakiye Rozeti -->
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-gray-100">
                        <div class="flex items-center gap-3">
                            <span class="w-10 h-10 rounded-2xl flex items-center justify-center text-white text-sm font-black shadow-md shrink-0" style="background-color: {{ $bankColor }};">
                                {{ mb_substr($bankName, 0, 2) }}
                            </span>
                            <div>
                                <div class="flex items-center gap-2">
                                    <h2 class="text-base sm:text-lg font-black text-gray-900">{{ $bankName }}</h2>
                                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-black bg-indigo-50 text-indigo-700 border border-indigo-100">
                                        {{ $accCount }} Hesap
                                    </span>
                                </div>
                                <span class="text-xs text-gray-500 font-medium">{{ $themeLabel }}</span>
                            </div>
                        </div>

                        <div class="flex items-baseline gap-2 bg-gray-50 px-4 py-2 rounded-2xl border border-gray-100 sm:self-center">
                            <span class="text-xs font-bold text-gray-500">Bankadaki Net Bakiye:</span>
                            <span class="text-base sm:text-lg font-black {{ $bankTotal < 0 ? 'text-red-600' : 'text-emerald-600' }}">
                                ₺{{ number_format($bankTotal, 2, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <!-- Kademeli / Yığılı Kartlar veya Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                        @foreach ($bankAccounts as $index => $acc)
                            @php
                                $isNegative = $acc->balance < 0;
                                $hasKmh = (float)($acc->kmh_limit ?? 0) > 0;
                                $kmhUsed = $isNegative ? abs($acc->balance) : 0;
                                $availableLimit = $hasKmh ? max(0, (float)$acc->kmh_limit + (float)$acc->balance) : max(0, (float)$acc->balance);
                                $kmhPercent = $hasKmh ? min(100, round(($kmhUsed / (float)$acc->kmh_limit) * 100)) : 0;
                            @endphp

                            <!-- Banka Temalı Hesap Kartı -->
                            <div x-data="{ showFullIban: false, copied: false }" class="relative rounded-2xl bg-gradient-to-br {{ $bankGradient }} border {{ $accentBorder }} shadow-xl p-5 text-white flex flex-col justify-between min-h-[230px] overflow-hidden group hover:scale-[1.02] hover:-translate-y-1 transition-all duration-300">
                                <!-- Lüks Işık Parıltısı -->
                                <div class="absolute -right-12 -bottom-12 w-36 h-36 {{ $glowColor }} rounded-full blur-2xl pointer-events-none"></div>

                                <!-- Üst Satır: Hesap Türü + Çip / Amblem -->
                                <div>
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider {{ $acc->type === 'kmh' ? 'bg-red-500/20 text-red-300 border border-red-500/40' : ($acc->type === 'savings' ? 'bg-amber-500/20 text-amber-300 border border-amber-500/40' : 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/40') }}">
                                                {{ $acc->type === 'kmh' ? 'KMH / Ek Hesap' : ($acc->type === 'savings' ? 'Vadeli Mevduat' : 'Vadesiz TL') }}
                                            </span>
                                            <h3 class="text-base font-black text-white mt-1.5 truncate">{{ $acc->name }}</h3>
                                        </div>

                                        <!-- Çip / NFC Simgesi -->
                                        <div class="w-8 h-6 rounded-md bg-amber-300/90 border border-amber-200/80 font-mono text-[8px] font-bold flex items-center justify-center text-amber-950 shadow-inner">
                                            CHIP
                                        </div>
                                    </div>

                                    <!-- Güvenli Maskeli IBAN Gösterimi -->
                                    <div class="mt-2.5 flex items-center justify-between gap-1.5 bg-black/20 px-2.5 py-1.5 rounded-xl border border-white/10">
                                        <span x-show="!showFullIban" class="font-mono text-[11px] tracking-wider text-slate-200 truncate">
                                            {{ $acc->masked_iban }}
                                        </span>
                                        <span x-show="showFullIban" x-cloak class="font-mono text-[11px] tracking-wider text-amber-300 truncate">
                                            {{ $acc->formatted_iban }}
                                        </span>

                                        @if (!empty($acc->iban))
                                            <div class="flex items-center gap-1 shrink-0">
                                                <button type="button" @click="showFullIban = !showFullIban" class="p-1 rounded bg-white/10 hover:bg-white/20 text-slate-300 text-xs transition-colors" title="IBAN Göster / Gizle">
                                                    <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                                </button>
                                                <button type="button" @click="navigator.clipboard.writeText('{{ $acc->formatted_iban }}'); copied = true; setTimeout(() => copied = false, 2000)" class="p-1 rounded bg-white/10 hover:bg-white/20 text-slate-300 text-xs transition-colors" title="IBAN Kopyala">
                                                    <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.757c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184"/></svg>
                                                </button>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Şube & Hesap No Bilgisi -->
                                    @if ($acc->branch_name || $acc->account_number)
                                        <div class="mt-1.5 flex items-center justify-between text-[10px] text-slate-300 px-0.5">
                                            <span class="truncate max-w-[200px] flex items-center gap-1" title="{{ $acc->branch_name }}">
                                                <svg class="w-3.5 h-3.5 text-slate-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.5M4.5 21V10.5"/></svg>
                                                <span>{{ $acc->branch_name ?: 'Şube Kodu: ' . $acc->branch_code }}</span>
                                            </span>
                                            @if ($acc->account_number)
                                                <span class="font-mono text-slate-400">No: {{ $acc->account_number }}</span>
                                            @endif
                                        </div>
                                    @endif
                                </div>



                                <!-- Alt Kısım: Bakiye + KMH Limiti + Aksiyonlar -->
                                <div class="mt-4 pt-3 border-t border-white/10 space-y-2.5">
                                    <div class="flex items-baseline justify-between">
                                        <div>
                                            <span class="text-[10px] font-bold text-slate-400 block uppercase tracking-wider">GÜNCEL BAKİYE</span>
                                            <span class="text-xl font-black {{ $isNegative ? 'text-red-400' : 'text-emerald-300' }}">
                                                ₺{{ number_format($acc->balance, 2, ',', '.') }}
                                            </span>
                                        </div>

                                        @if ($hasKmh)
                                            <div class="text-right">
                                                <span class="text-[10px] font-bold text-slate-400 block uppercase tracking-wider">KULLANILABİLİR LİMİT</span>
                                                <span class="text-sm font-black font-mono {{ $availableLimit > 0 ? 'text-emerald-300' : 'text-slate-400' }}">
                                                    +₺{{ number_format($availableLimit, 2, ',', '.') }}
                                                </span>
                                                <span class="text-[9px] text-slate-400 block">Limit: ₺{{ number_format($acc->kmh_limit, 2, ',', '.') }}</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- KMH Doluluk Çubuğu -->
                                    @if ($hasKmh)
                                        <div class="space-y-1">
                                            <div class="flex justify-between text-[10px] font-bold text-slate-300">
                                                <span>Ek Hesap / KMH (%{{ $kmhPercent }} Dolu)</span>
                                                <span>Faiz: %{{ number_format($acc->kmh_interest_rate ?: 5.0, 2) }}</span>
                                            </div>
                                            <div class="w-full h-1.5 bg-black/40 rounded-full overflow-hidden">
                                                <div class="h-full {{ $kmhPercent > 80 ? 'bg-red-500' : ($kmhPercent > 40 ? 'bg-amber-400' : 'bg-emerald-400') }}" style="width: {{ $kmhPercent }}%;"></div>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Kart Aksiyonları -->
                                    <div class="flex items-center justify-between pt-1">
                                        <span class="text-[9px] text-slate-400 font-mono">#{{ $acc->id }}</span>
                                        <div class="flex items-center gap-2">
                                            <button wire:click="openEditModal({{ $acc->id }})" class="px-2.5 py-1 bg-white/10 hover:bg-white/20 text-white rounded-lg text-xs font-bold transition-colors cursor-pointer">
                                                Düzenle
                                            </button>
                                            <button wire:click="delete({{ $acc->id }})" wire:confirm="Bu hesabı silmek istediğinize emin misiniz?" class="px-2.5 py-1 bg-red-500/20 hover:bg-red-500/30 text-red-300 rounded-lg text-xs font-bold transition-colors cursor-pointer">
                                                Sil
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-3xl p-12 text-center border-2 border-dashed border-gray-200 space-y-3">
                    <svg class="w-12 h-12 mx-auto text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.5M4.5 21V10.5"/></svg>
                    <h3 class="font-bold text-gray-900 text-base">Kayıtlı hesap bulunamadı</h3>
                    <p class="text-xs text-gray-500">Banka hesaplarınızı ve KMH eksi bakiyelerinizi ekleyerek başlayabilirsiniz.</p>
                    <button wire:click="openCreateModal" class="px-4 py-2 bg-indigo-600 text-white rounded-xl text-xs font-bold hover:bg-indigo-700 transition-colors">
                        + İlk Hesabını Ekle
                    </button>
                </div>
            @endforelse
        </div>
    @elseif ($viewMode === 'grid')
        <!-- 5. GÖRÜNÜM 2: TEKİL KART IZGARASI -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($accounts as $acc)
                @php
                    $bankName = $acc->bank?->name ?? 'Diğer Banka';
                    $bankNameLower = mb_strtolower($bankName);
                    $bankColor = $acc->bank?->color ?? '#6366f1';
                    $isNegative = $acc->balance < 0;
                    $hasKmh = (float)($acc->kmh_limit ?? 0) > 0;
                    $kmhUsed = $isNegative ? abs($acc->balance) : 0;
                    $availableLimit = $hasKmh ? max(0, (float)$acc->kmh_limit + (float)$acc->balance) : max(0, (float)$acc->balance);
                    $kmhPercent = $hasKmh ? min(100, round(($kmhUsed / (float)$acc->kmh_limit) * 100)) : 0;

                    if (str_contains($bankNameLower, 'garanti')) {
                        $bankGradient = 'from-[#004d25] via-[#023318] to-[#011409]';
                        $accentBorder = 'border-emerald-500/40';
                        $glowColor = 'bg-emerald-500/20';
                    } elseif (str_contains($bankNameLower, 'akbank')) {
                        $bankGradient = 'from-[#990000] via-[#660000] to-[#260000]';
                        $accentBorder = 'border-red-500/40';
                        $glowColor = 'bg-red-500/20';
                    } elseif (str_contains($bankNameLower, 'iş') || str_contains($bankNameLower, 'is bankasi')) {
                        $bankGradient = 'from-[#003366] via-[#001f3f] to-[#000d1a]';
                        $accentBorder = 'border-blue-500/40';
                        $glowColor = 'bg-blue-500/20';
                    } elseif (str_contains($bankNameLower, 'yapı') || str_contains($bankNameLower, 'yapi')) {
                        $bankGradient = 'from-[#004b87] via-[#002d52] to-[#001324]';
                        $accentBorder = 'border-sky-500/40';
                        $glowColor = 'bg-sky-500/20';
                    } elseif (str_contains($bankNameLower, 'ziraat')) {
                        $bankGradient = 'from-[#8a0010] via-[#54000a] to-[#240004]';
                        $accentBorder = 'border-rose-500/40';
                        $glowColor = 'bg-rose-500/20';
                    } elseif (str_contains($bankNameLower, 'vakıf') || str_contains($bankNameLower, 'vakif')) {
                        $bankGradient = 'from-[#a36f00] via-[#664600] to-[#291c00]';
                        $accentBorder = 'border-amber-500/40';
                        $glowColor = 'bg-amber-500/20';
                    } else {
                        $bankGradient = 'from-slate-900 via-indigo-950 to-slate-950';
                        $accentBorder = 'border-indigo-500/30';
                        $glowColor = 'bg-indigo-500/15';
                    }
                @endphp

                <div class="relative rounded-2xl bg-gradient-to-br {{ $bankGradient }} border {{ $accentBorder }} shadow-xl p-5 text-white flex flex-col justify-between min-h-[230px] overflow-hidden group hover:scale-[1.02] transition-all">
                    <div class="absolute -right-12 -bottom-12 w-36 h-36 {{ $glowColor }} rounded-full blur-2xl pointer-events-none"></div>

                    <div>
                        <div class="flex items-start justify-between">
                            <div>
                                <span class="text-[10px] font-black uppercase tracking-wider text-slate-300 block">{{ $bankName }}</span>
                                <h3 class="text-base font-black text-white mt-0.5 truncate">{{ $acc->name }}</h3>
                            </div>
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider {{ $acc->type === 'kmh' ? 'bg-red-500/20 text-red-300 border border-red-500/40' : 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/40' }}">
                                {{ $acc->type === 'kmh' ? 'KMH' : ($acc->type === 'savings' ? 'Vadeli' : 'Vadesiz') }}
                            </span>
                        </div>

                        <div class="mt-2.5">
                            <span class="font-mono text-xs tracking-wider text-slate-200">
                                {{ $acc->masked_iban }}
                            </span>
                        </div>
                    </div>


                    <div class="mt-4 pt-3 border-t border-white/10 space-y-2">
                        <div class="flex items-baseline justify-between">
                            <div>
                                <span class="text-[10px] font-bold text-slate-400 block uppercase">BAKİYE</span>
                                <span class="text-xl font-black {{ $isNegative ? 'text-red-400' : 'text-emerald-300' }}">
                                    ₺{{ number_format($acc->balance, 2, ',', '.') }}
                                </span>
                            </div>
                            @if ($hasKmh)
                                <div class="text-right">
                                    <span class="text-[10px] font-bold text-slate-400 block uppercase">KULLANILABİLİR</span>
                                    <span class="text-xs font-bold {{ $availableLimit > 0 ? 'text-emerald-300' : 'text-slate-400' }}">
                                        +₺{{ number_format($availableLimit, 2, ',', '.') }}
                                    </span>
                                    <span class="text-[9px] text-slate-400 block">Limit: ₺{{ number_format($acc->kmh_limit, 2, ',', '.') }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- KMH Doluluk Çubuğu -->
                        @if ($hasKmh)
                            <div class="space-y-1 pt-1">
                                <div class="flex justify-between text-[10px] font-bold text-slate-300">
                                    <span>Ek Hesap (%{{ $kmhPercent }} Dolu)</span>
                                    <span>Faiz: %{{ number_format($acc->kmh_interest_rate ?: 5.0, 2) }}</span>
                                </div>
                                <div class="w-full h-1.5 bg-black/40 rounded-full overflow-hidden">
                                    <div class="h-full {{ $kmhPercent > 80 ? 'bg-red-500' : ($kmhPercent > 40 ? 'bg-amber-400' : 'bg-emerald-400') }}" style="width: {{ $kmhPercent }}%;"></div>
                                </div>
                            </div>
                        @endif

                        <div class="flex items-center justify-between pt-1">
                            <span class="text-[9px] text-slate-400 font-mono">#{{ $acc->id }}</span>
                            <div class="flex items-center gap-2">
                                <button wire:click="openEditModal({{ $acc->id }})" class="px-2.5 py-1 bg-white/10 hover:bg-white/20 text-white rounded-lg text-xs font-bold transition-colors cursor-pointer">
                                    Düzenle
                                </button>
                                <button wire:click="delete({{ $acc->id }})" wire:confirm="Bu hesabı silmek istediğinize emin misiniz?" class="px-2.5 py-1 bg-red-500/20 hover:bg-red-500/30 text-red-300 rounded-lg text-xs font-bold transition-colors cursor-pointer">
                                    Sil
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-3xl p-12 text-center border-2 border-dashed border-gray-200 space-y-3">
                    <p class="text-sm font-bold text-gray-700">Filtre kriterlerine uygun hesap bulunamadı.</p>
                </div>
            @endforelse
        </div>
    @else
        <!-- 6. GÖRÜNÜM 3: DETAYLI TABLO -->
        <div class="bg-white rounded-2xl border border-gray-200/90 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50 text-gray-500 font-bold text-xs text-left">
                        <tr>
                            <th class="px-6 py-3.5">Banka & Hesap Adı</th>
                            <th class="px-6 py-3.5">Hesap Türü</th>
                            <th class="px-6 py-3.5">Güncel Bakiye</th>
                            <th class="px-6 py-3.5">Kullanılabilir Ek Limit</th>
                            <th class="px-6 py-3.5">Tanımlı Limit</th>
                            <th class="px-6 py-3.5">Faiz Oranı</th>
                            <th class="px-6 py-3.5 text-right">İşlemler</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse ($accounts as $acc)
                            @php
                                $hasKmh = (float)($acc->kmh_limit ?? 0) > 0;
                                $availableLimit = $hasKmh ? max(0, (float)$acc->kmh_limit + (float)$acc->balance) : max(0, (float)$acc->balance);
                            @endphp
                            <tr class="hover:bg-gray-50/70 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <span class="w-8 h-8 rounded-lg flex items-center justify-center text-white text-xs font-black shadow-xs" style="background-color: {{ $acc->bank?->color ?? '#6366f1' }}">
                                            {{ mb_substr($acc->bank?->name ?? 'B', 0, 2) }}
                                        </span>
                                        <div>
                                            <span class="font-bold text-gray-900 block">{{ $acc->name }}</span>
                                            <div class="flex items-center gap-2 text-xs text-gray-500">
                                                <span>{{ $acc->bank?->name }}</span>
                                                @if (!empty($acc->iban))
                                                    <span class="text-gray-300">•</span>
                                                    <span class="font-mono text-[11px] text-gray-600">{{ $acc->masked_iban }}</span>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-black {{ $acc->type === 'kmh' ? 'bg-red-100 text-red-700' : 'bg-blue-50 text-blue-700' }}">
                                        {{ $acc->type === 'kmh' ? 'KMH / Ek Hesap' : ($acc->type === 'savings' ? 'Vadeli' : 'Vadesiz') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 font-black {{ $acc->balance < 0 ? 'text-red-600' : 'text-emerald-600' }}">
                                    ₺{{ number_format($acc->balance, 2, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 font-bold {{ $availableLimit > 0 ? 'text-emerald-600' : 'text-gray-400' }}">
                                    {{ $hasKmh ? '+₺' . number_format($availableLimit, 2, ',', '.') : '-' }}
                                </td>
                                <td class="px-6 py-4 text-gray-700 font-medium">
                                    {{ $acc->kmh_limit ? '₺' . number_format($acc->kmh_limit, 2, ',', '.') : '-' }}
                                </td>
                                <td class="px-6 py-4 text-gray-700 font-semibold">
                                    {{ $acc->kmh_interest_rate ? '%' . number_format($acc->kmh_interest_rate, 2) : '-' }}
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <button wire:click="openEditModal({{ $acc->id }})" class="text-indigo-600 hover:text-indigo-900 font-bold text-xs cursor-pointer">Düzenle</button>
                                    <button wire:click="delete({{ $acc->id }})" wire:confirm="Bu hesabı silmek istediğinize emin misiniz?" class="text-red-600 hover:text-red-900 font-bold text-xs cursor-pointer">Sil</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                    Kayıtlı hesap bulunmamaktadır.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- 7. HESAP EKLEME / DÜZENLEME MODALI -->
    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-xs p-4 overflow-y-auto">
            <div class="bg-white rounded-2xl max-w-lg w-full p-5 sm:p-6 shadow-2xl space-y-4 my-8 max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <div>
                        <h3 class="font-bold text-lg text-gray-900">{{ $accountId ? 'Hesabı Düzenle' : 'Yeni Banka Hesabı Tanımla' }}</h3>
                        <p class="text-xs text-gray-500">IBAN ve hesap bilgileri şifrelenir, kartlarda ve tablolarda güvenli maskeli gösterilir.</p>
                    </div>
                    <button wire:click="$set('showModal', false)" class="text-gray-400 hover:text-gray-600 font-bold text-lg">✕</button>
                </div>

                <div class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Banka</label>
                            <select wire:model="bank_id" class="w-full rounded-xl border-gray-300 text-sm font-medium focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Banka Seçin</option>
                                @foreach ($banks as $b)
                                    <option value="{{ $b->id }}">{{ $b->name }}</option>
                                @endforeach
                            </select>
                            @error('bank_id') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Hesap Türü</label>
                            <select wire:model.live="type" class="w-full rounded-xl border-gray-300 text-sm font-medium focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="checking">Vadesiz Mevduat</option>
                                <option value="kmh">KMH / Ek Hesap (Eksi Bakiye)</option>
                                <option value="savings">Vadeli Mevduat</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Hesap Adı / Etiketi</label>
                        <input type="text" wire:model="name" class="w-full rounded-xl border-gray-300 text-sm font-medium focus:ring-indigo-500 focus:border-indigo-500" placeholder="Örn: Maaş Hesabı veya Artı Para">
                        @error('name') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">IBAN Numarası (26 Karakter TR...)</label>
                        <input type="text" wire:model="iban" maxlength="32" class="w-full rounded-xl border-gray-300 text-sm font-mono focus:ring-indigo-500 focus:border-indigo-500 uppercase tracking-wide" placeholder="TR00 0000 0000 0000 0000 0000 00">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Hesap No (İsteğe Bağlı)</label>
                            <input type="text" wire:model="account_number" class="w-full rounded-xl border-gray-300 text-sm font-mono focus:ring-indigo-500 focus:border-indigo-500" placeholder="83242619-5001">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Şube Kodu</label>
                            <input type="text" wire:model="branch_code" class="w-full rounded-xl border-gray-300 text-sm font-mono focus:ring-indigo-500 focus:border-indigo-500" placeholder="2724">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Şube Adı</label>
                            <input type="text" wire:model="branch_name" class="w-full rounded-xl border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Örn: Osmangazi Cd. - Bağcılar">
                        </div>
                    </div>


                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Güncel Bakiye (Eksi ise eksi olarak girin, örn: -50000)</label>
                        <input type="number" step="0.01" wire:model="balance" class="w-full rounded-xl border-gray-300 text-sm font-black focus:ring-indigo-500 focus:border-indigo-500" placeholder="0.00">
                        @error('balance') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                    </div>

                    @if ($type === 'kmh')
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 p-3.5 bg-red-50/70 rounded-xl border border-red-100">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">KMH Limiti (TL)</label>
                                <input type="number" step="0.01" wire:model="kmh_limit" class="w-full rounded-xl border-gray-300 text-sm font-bold focus:ring-indigo-500 focus:border-indigo-500" placeholder="50000">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">Aylık KMH Akdi Faizi (%)</label>
                                <input type="number" step="0.01" wire:model="kmh_interest_rate" class="w-full rounded-xl border-gray-300 text-sm font-bold focus:ring-indigo-500 focus:border-indigo-500" placeholder="5.00">
                            </div>
                        </div>
                    @endif
                </div>


                <div class="flex justify-end gap-3 pt-3 border-t border-gray-100">
                    <button wire:click="$set('showModal', false)" class="px-4 py-2 text-sm font-bold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">
                        İptal
                    </button>
                    <button wire:click="save" class="px-6 py-2 text-sm font-black text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-md transition-all active:scale-95">
                        Kaydet
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
