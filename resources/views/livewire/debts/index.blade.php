<div class="py-2 sm:py-6 px-3 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-6">
    <!-- 1. Header & Yeni Borç Ekle -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4">
        <div>
            <div class="flex items-center gap-2 flex-wrap">
                <h1 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight flex items-center gap-2">
                    <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.25-2.142V9M6 12h.008v.008H6V12zm0 3h.008v.008H6V15zm0 3h.008v.008H6V18z"/></svg>
                    <span>Borçlarım & Kredilerim</span>
                </h1>
                <span class="px-2.5 py-0.5 rounded-full text-xs font-black {{ $canCreateDebt ? 'bg-indigo-50 text-indigo-700 border border-indigo-200' : 'bg-amber-100 text-amber-900 border border-amber-300' }}">
                    {{ $userDebtCount }} / {{ $maxDebts === -1 ? 'Sınırsız' : $maxDebts }} Borç
                </span>
            </div>
            <p class="text-xs sm:text-sm text-gray-600 mt-0.5">Tüm banka kredileri, KMH eksi bakiyeleri, şahıs borçları ve 90 günlük yasal takip sayaçları</p>
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
                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
                        <span>Borç Verisi Excel Raporu</span>
                    </div>
                    <p class="text-[11px] text-slate-300 leading-relaxed">
                        Tüm banka borçlarınızı, kalan ana para bakiyelerini, aylık taksit yüklerini, faiz oranlarını ve 90 günlük yasal takip gecikme sayaçlarını içeren <strong>UTF-8 uyumlu Excel tablosunu</strong> indirir.
                    </p>
                    <span class="block mt-2 text-[10px] font-bold text-emerald-400 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        <span>Excel & Google Sheets Uyumlu</span>
                    </span>
                </div>
            </div>

            <!-- Görünüm Modu Değiştirici -->
            <div class="inline-flex rounded-lg bg-slate-100 p-1 border border-slate-200/80 shadow-2xs">
                <button wire:click="$set('viewMode', 'flow')" class="px-2.5 py-1 rounded-md text-xs font-bold transition-all flex items-center gap-1 cursor-pointer {{ $viewMode === 'flow' ? 'bg-white text-indigo-700 shadow-2xs border border-slate-200/60' : 'text-slate-600 hover:text-slate-900' }}">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.429 9.75L2.25 12l4.179 2.25m0-4.5l4.179 2.25m-4.179-2.25l4.179-2.25m4.179 6.75l4.179-2.25m-4.179 2.25l-4.179-2.25m4.179 2.25L21.75 12l-4.179-2.25m0 0l-4.179 2.25m4.179-2.25l-4.179-2.25"/></svg>
                    <span class="hidden sm:inline">Kart</span>
                </button>
                <button wire:click="$set('viewMode', 'table')" class="px-2.5 py-1 rounded-md text-xs font-bold transition-all flex items-center gap-1 cursor-pointer {{ $viewMode === 'table' ? 'bg-white text-indigo-700 shadow-2xs border border-slate-200/60' : 'text-slate-600 hover:text-slate-900' }}">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M3.75 4.5h16.5M3.75 8.25h16.5"/></svg>
                    <span class="hidden sm:inline">Tablo</span>
                </button>
            </div>

            <button wire:click="openCreateModal" class="inline-flex items-center gap-1.5 px-3.5 sm:px-4 py-2 bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white font-black text-xs sm:text-sm rounded-lg shadow-xs transition-all whitespace-nowrap cursor-pointer">
                <span>+ Yeni Borç</span>
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
        <!-- Toplam Kalan Borç -->
        <div class="bg-white p-3.5 sm:p-4 rounded-xl border border-slate-200/80 shadow-2xs flex items-center gap-2.5 sm:gap-3">
            <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg bg-red-50 text-red-600 flex items-center justify-center text-base sm:text-lg font-black shrink-0">
                ₺
            </div>
            <div class="min-w-0 flex-1">
                <span class="text-[10px] sm:text-[11px] font-bold text-gray-500 block uppercase tracking-wider truncate">Kalan Toplam</span>
                <span class="text-[13px] sm:text-lg lg:text-xl font-black font-mono text-gray-900 tracking-tight block">₺{{ number_format($totalRemaining, 2, ',', '.') }}</span>
            </div>
        </div>

        <!-- Aylık Taksit Yükü -->
        <div class="bg-white p-3.5 sm:p-4 rounded-xl border border-slate-200/80 shadow-2xs flex items-center gap-2.5 sm:gap-3">
            <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center text-base sm:text-lg font-black shrink-0">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
            </div>
            <div class="min-w-0 flex-1">
                <span class="text-[10px] sm:text-[11px] font-bold text-gray-500 block uppercase tracking-wider truncate">Aylık Taksit</span>
                <span class="text-[13px] sm:text-lg lg:text-xl font-black font-mono text-indigo-700 tracking-tight block">₺{{ number_format($totalMonthly, 2, ',', '.') }}</span>
            </div>
        </div>

        <!-- Ortalama Faiz Oranı -->
        <div class="bg-white p-3.5 sm:p-4 rounded-xl border border-slate-200/80 shadow-2xs flex items-center gap-2.5 sm:gap-3">
            <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center text-base sm:text-lg font-black shrink-0">
                %
            </div>
            <div class="min-w-0 flex-1">
                <span class="text-[10px] sm:text-[11px] font-bold text-gray-500 block uppercase tracking-wider truncate">Ort. Faiz</span>
                <span class="text-[13px] sm:text-lg lg:text-xl font-black font-mono text-gray-900 tracking-tight block">%{{ number_format($avgInterest, 2) }}</span>
            </div>
        </div>

        <!-- Kritik Risk Sayacı -->
        <div class="bg-white p-3.5 sm:p-4 rounded-xl border border-slate-200/80 shadow-2xs flex items-center gap-2.5 sm:gap-3">
            <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg {{ $criticalCount > 0 ? 'bg-red-600 text-white animate-pulse' : 'bg-emerald-50 text-emerald-600' }} flex items-center justify-center text-base sm:text-lg font-black shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
            </div>
            <div class="min-w-0 flex-1">
                <span class="text-[10px] sm:text-[11px] font-bold text-gray-500 block uppercase tracking-wider truncate">Yasal Takip</span>
                <span class="text-[13px] sm:text-lg lg:text-xl font-black tracking-tight {{ $criticalCount > 0 ? 'text-red-600' : 'text-emerald-600' }} block truncate">
                    {{ $criticalCount > 0 ? $criticalCount . ' Borç Kritik' : 'Güvende' }}
                </span>
            </div>
        </div>
    </div>

    <!-- 3. KAPSAMLI ÜST FİLTRE & ARAMA PANELİ (Segmented Control & Linear Inputs) -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-2xs p-3.5 sm:p-4 space-y-3">
        <!-- Üst Satır: Sekmeler + Arama + Sıralama -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-3 pb-3 border-b border-slate-100">
            <!-- Tür Sekmeleri (Segmented Bar) -->
            <div class="inline-flex p-1 bg-slate-100 rounded-lg border border-slate-200/80 overflow-x-auto no-scrollbar">
                <button wire:click="$set('activeTab', 'all')" class="px-3 py-1.5 text-xs font-bold rounded-md transition-all whitespace-nowrap shrink-0 {{ $activeTab === 'all' ? 'bg-white text-slate-900 shadow-2xs border border-slate-200/60' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-200/40' }}">
                    Tümü <span class="ml-1 text-[10px] font-mono px-1.5 py-0.5 rounded bg-slate-200/70 text-slate-700">({{ $debts->count() }})</span>
                </button>
                <button wire:click="$set('activeTab', 'loan')" class="px-3 py-1.5 text-xs font-bold rounded-md transition-all whitespace-nowrap shrink-0 {{ $activeTab === 'loan' ? 'bg-white text-slate-900 shadow-2xs border border-slate-200/60' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-200/40' }}">
                    Krediler
                </button>
                <button wire:click="$set('activeTab', 'kmh')" class="px-3 py-1.5 text-xs font-bold rounded-md transition-all whitespace-nowrap shrink-0 {{ $activeTab === 'kmh' ? 'bg-white text-slate-900 shadow-2xs border border-slate-200/60' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-200/40' }}">
                    KMH / Eksi
                </button>
                <button wire:click="$set('activeTab', 'credit_card')" class="px-3 py-1.5 text-xs font-bold rounded-md transition-all whitespace-nowrap shrink-0 {{ $activeTab === 'credit_card' ? 'bg-white text-slate-900 shadow-2xs border border-slate-200/60' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-200/40' }}">
                    Kartlar
                </button>
                <button wire:click="$set('activeTab', 'personal')" class="px-3 py-1.5 text-xs font-bold rounded-md transition-all whitespace-nowrap shrink-0 {{ $activeTab === 'personal' ? 'bg-white text-slate-900 shadow-2xs border border-slate-200/60' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-200/40' }}">
                    Şahıs / Diğer
                </button>
            </div>

            <!-- Canlı Arama Inputu -->
            <div class="relative w-full lg:w-72">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 text-xs">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                </span>
                <input type="text" 
                       wire:model.live.debounce.300ms="search" 
                       placeholder="Borç veya banka ara..." 
                       class="w-full pl-9 pr-8 py-1.5 bg-slate-50 border border-slate-300 rounded-lg text-xs sm:text-sm font-medium focus:bg-white focus:ring-1 focus:ring-indigo-600 focus:border-indigo-600 transition-all">
                @if ($search)
                    <button wire:click="$set('search', '')" class="absolute inset-y-0 right-0 pr-2.5 flex items-center text-slate-400 hover:text-slate-600 text-xs font-bold cursor-pointer">
                        ✕
                    </button>
                @endif
            </div>
        </div>

        <!-- Alt Satır: Filtre Seçicileri (Banka, Risk, Tarih, Sıralama, Sıfırla) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-3 items-center text-xs">
            <!-- 1. Banka Filtresi -->
            <div>
                <label class="block font-bold text-gray-600 mb-1 text-[11px]">Banka Seçimi</label>
                <select wire:model.live="selected_bank_id" class="w-full rounded-lg border-slate-300 bg-slate-50 py-1.5 text-xs font-medium focus:bg-white focus:ring-1 focus:ring-indigo-600 focus:border-indigo-600">
                    <option value="">Tüm Bankalar</option>
                    @foreach ($banks as $b)
                        <option value="{{ $b->id }}">{{ $b->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- 2. Risk / Gecikme Durumu -->
            <div>
                <label class="block font-bold text-gray-600 mb-1 text-[11px]">Risk & Takip Durumu</label>
                <select wire:model.live="risk_status" class="w-full rounded-lg border-slate-300 bg-slate-50 py-1.5 text-xs font-medium focus:bg-white focus:ring-1 focus:ring-indigo-600 focus:border-indigo-600">
                    <option value="all">Tüm Durumlar</option>
                    <option value="critical">Kritik Takip (65+ Gün Gecikme)</option>
                    <option value="overdue">Gecikmede (1-64 Gün)</option>
                    <option value="regular">Düzenli / Gecikmesiz</option>
                    <option value="paid">Tamamı Ödenmiş</option>
                </select>
            </div>

            <!-- 3. Sıralama Algoritması -->
            <div>
                <label class="block font-bold text-gray-600 mb-1 text-[11px]">Stratejik Sıralama</label>
                <select wire:model.live="sortBy" class="w-full rounded-lg border-slate-300 bg-slate-50 py-1.5 text-xs font-medium focus:bg-white focus:ring-1 focus:ring-indigo-600 focus:border-indigo-600">
                    <option value="risk">Yasal Takip Risk Önceliği</option>
                    <option value="interest_desc">En Yüksek Faiz % (Çığ Stratejisi)</option>
                    <option value="remaining_asc">En Düşük Bakiye (Kartopu Stratejisi)</option>
                    <option value="remaining_desc">En Yüksek Bakiye</option>
                    <option value="next_due">En Yakın Vade / Son Ödeme</option>
                    <option value="title">Borç Başlığı (A-Z)</option>
                </select>
            </div>

            <!-- 4. Tarih Aralığı (Başlangıç - Bitiş) -->
            <div>
                <label class="block font-bold text-gray-600 mb-1 text-[11px]">Vade Başlangıç</label>
                <input type="date" wire:model.live="date_from" class="w-full rounded-lg border-slate-300 bg-slate-50 py-1.5 text-xs font-medium focus:bg-white focus:ring-1 focus:ring-indigo-600 focus:border-indigo-600">
            </div>

            <div>
                <label class="block font-bold text-gray-600 mb-1 text-[11px]">Vade Bitiş</label>
                <input type="date" wire:model.live="date_to" class="w-full rounded-lg border-slate-300 bg-slate-50 py-1.5 text-xs font-medium focus:bg-white focus:ring-1 focus:ring-indigo-600 focus:border-indigo-600">
            </div>
        </div>

        <!-- Hızlı Tarih Hapları & Filtreleri Sıfırla -->
        <div class="flex flex-wrap items-center justify-between gap-2 pt-2 border-t border-gray-100 text-xs">
            <div class="flex flex-wrap items-center gap-1.5">
                <span class="text-[11px] font-bold text-gray-400">Hızlı Tarih:</span>
                <button wire:click="setDatePreset('all')" class="px-2.5 py-1 rounded-lg font-bold text-[11px] transition-all {{ $date_preset === 'all' ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    Tümü
                </button>
                <button wire:click="setDatePreset('this_month')" class="px-2.5 py-1 rounded-lg font-bold text-[11px] transition-all {{ $date_preset === 'this_month' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    Bu Ay Vadesi Gelenler
                </button>
                <button wire:click="setDatePreset('next_30')" class="px-2.5 py-1 rounded-lg font-bold text-[11px] transition-all {{ $date_preset === 'next_30' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    Gelecek 30 Gün
                </button>
                <button wire:click="setDatePreset('past_due')" class="px-2.5 py-1 rounded-lg font-bold text-[11px] transition-all {{ $date_preset === 'past_due' ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    Geçmiş Vadeliler
                </button>
            </div>

            @if ($search || $selected_bank_id || $risk_status !== 'all' || $date_from || $date_to || $sortBy !== 'risk' || $activeTab !== 'all')
                <button wire:click="resetFilters" class="text-indigo-600 hover:text-indigo-800 font-black text-xs flex items-center gap-1">
                    <span>↺ Filtreleri Sıfırla</span>
                </button>
            @endif
        </div>
    </div>

    <!-- 4. GÖRÜNÜM 1: AKIŞ KARTLARI (KART AKIŞI GÖRÜNÜMÜ) -->
    @if ($viewMode === 'flow')
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse ($debts as $debt)
                @php
                    $daysLeft = max(0, 90 - $debt->days_overdue);
                    $isCritical = $daysLeft <= 25 && $debt->days_overdue > 0;
                    $paidAmount = max(0, (float)$debt->principal - (float)$debt->remaining);
                    $paidPercent = (float)$debt->principal > 0 ? min(100, round(($paidAmount / (float)$debt->principal) * 100)) : 0;
                    $bankColor = $debt->bank?->color ?? '#6366f1';
                @endphp

                <div class="bg-white rounded-2xl border {{ $isCritical ? 'border-red-400 ring-2 ring-red-400/30' : 'border-gray-200/90' }} shadow-sm hover:shadow-md transition-all p-5 space-y-4 relative overflow-hidden flex flex-col justify-between group">
                    <!-- Banka Renk Vurgu Çizgisi -->
                    <div class="absolute top-0 left-0 right-0 h-1" style="background-color: {{ $bankColor }};"></div>

                    <!-- Üst Satır: Banka Logosu + Başlık + Tür Rozeti -->
                    <div class="flex items-start justify-between gap-2 pt-1">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <div class="w-9 h-9 rounded-xl text-white font-black flex items-center justify-center text-xs shadow-xs shrink-0" style="background-color: {{ $bankColor }};">
                                {{ mb_substr($debt->bank?->name ?? 'DB', 0, 2) }}
                            </div>
                            <div class="min-w-0">
                                <span class="text-[10px] font-black uppercase tracking-wider text-gray-400 block truncate">{{ $debt->bank?->name ?? 'Şahıs / Diğer' }}</span>
                                <h3 class="font-bold text-gray-900 text-sm truncate leading-tight mt-0.5">{{ $debt->title }}</h3>
                                @if ($debt->merchant_name)
                                    <span class="text-[10px] text-indigo-600 font-medium truncate block">{{ $debt->merchant_name }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="flex flex-col items-end gap-1 shrink-0">
                            <span class="px-2.5 py-0.5 rounded-full text-[11px] font-black {{ $debt->type === 'kmh' ? 'bg-red-100 text-red-700' : ($debt->type === 'credit_card' ? 'bg-amber-100 text-amber-700' : ($debt->type === 'personal' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700')) }}">
                                {{ $debt->type === 'kmh' ? 'KMH' : ($debt->type === 'credit_card' ? 'Kredi Kartı' : ($debt->type === 'personal' ? 'Şahıs' : 'Kredi')) }}
                            </span>
                            @if ($debt->current_installment && $debt->total_installments)
                                <span class="px-2 py-0.5 rounded-md bg-indigo-50 border border-indigo-200 text-indigo-700 font-black text-[10px]">
                                    {{ $debt->current_installment }}/{{ $debt->total_installments }} Taksit
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Orta Kısım: Finansal Rakamlar, Toplam Tutar & İlerleme -->
                    <div class="p-3 bg-gray-50/90 rounded-xl border border-gray-100 space-y-2">
                        <div class="flex items-baseline justify-between">
                            <span class="text-[11px] font-bold text-gray-500">Kalan Borç:</span>
                            <span class="text-xl font-black text-red-600">₺{{ number_format($debt->remaining, 2, ',', '.') }}</span>
                        </div>

                        @if ($debt->principal > 0 && ($debt->total_installments > 1 || $debt->type === 'loan'))
                            @php
                                $paidAmount = max(0, (float)$debt->principal - (float)$debt->remaining);
                                $progressPercent = $debt->principal > 0 ? min(100, round(($paidAmount / (float)$debt->principal) * 100)) : 0;
                            @endphp

                            <div class="space-y-1 pt-1.5 border-t border-gray-200/60">
                                <div class="flex items-center justify-between text-[10.5px] font-bold">
                                    <span class="text-gray-500">Toplam İşlem: <strong class="text-gray-900">₺{{ number_format($debt->principal, 2, ',', '.') }}</strong></span>
                                    <span class="text-emerald-700">Ödenen: ₺{{ number_format($paidAmount, 2, ',', '.') }} (%{{ $progressPercent }})</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-1.5 overflow-hidden">
                                    <div class="bg-emerald-500 h-1.5 rounded-full transition-all" style="width: {{ $progressPercent }}%;"></div>
                                </div>
                            </div>
                        @endif

                        <div class="grid grid-cols-2 gap-2 pt-1.5 border-t border-gray-200/60 text-[11px]">
                            <div>
                                <span class="text-gray-400 block font-semibold">Aylık Faiz:</span>
                                @if ($debt->interest_rate > 0)
                                    <span class="font-black text-gray-800">%{{ number_format($debt->interest_rate, 2) }}</span>
                                @else
                                    <span class="inline-block px-1.5 py-0.5 rounded text-[10px] font-black bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        Faizsiz (%0)
                                    </span>
                                @endif
                            </div>
                            <div class="text-right">
                                <span class="text-gray-400 block font-semibold">Aylık Taksit:</span>
                                <span class="font-black text-indigo-700">{{ $debt->installment_amount ? '₺' . number_format($debt->installment_amount, 2, ',', '.') : '-' }}</span>
                            </div>
                        </div>

                    </div>



                    <!-- Vade & Gecikme Çubuğu -->
                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between text-[11px]">
                            <span class="text-gray-500 font-medium">
                                @if ($debt->next_due_date)
                                    Vade: {{ \Carbon\Carbon::parse($debt->next_due_date)->format('d.m.Y') }}
                                @else
                                    Vade Tanımsız
                                @endif
                            </span>
                            
                            <span class="px-2 py-0.5 rounded-md font-black text-[10px] {{ $isCritical ? 'bg-red-600 text-white animate-pulse' : ($debt->days_overdue > 0 ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-emerald-800') }}">
                                @if ($debt->days_overdue > 0)
                                    {{ $debt->days_overdue }} Gün Gecikme ({{ $daysLeft }} Gün Kaldı)
                                @else
                                    Düzenli Ödeniyor
                                @endif
                            </span>
                        </div>

                        @if ($debt->notes)
                            <p class="text-[10px] text-gray-500 italic bg-gray-50 p-2 rounded-lg border border-gray-100 truncate">
                                {{ $debt->notes }}
                            </p>
                        @endif
                    </div>

                    <!-- Alt Satır: Aksiyon Butonları -->
                    <div class="pt-2 border-t border-gray-100 flex items-center justify-between">
                        <span class="text-[10px] text-gray-400">ID: #{{ $debt->id }}</span>
                        <div class="flex items-center gap-1.5">
                            <button wire:click="openEditModal({{ $debt->id }})" class="px-2.5 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-xs font-bold transition-colors">
                                Düzenle
                            </button>
                            <button wire:click="delete({{ $debt->id }})" wire:confirm="Bu borç kaydını silmek istediğinize emin misiniz?" class="px-2.5 py-1 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg text-xs font-bold transition-colors">
                                Sil
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-2xl p-12 text-center border-2 border-dashed border-gray-200 space-y-3">
                    <svg class="w-10 h-10 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                    <h3 class="font-bold text-gray-900 text-base">Filtre kriterlerine uygun borç kaydı bulunamadı</h3>
                    <p class="text-xs text-gray-500">Arama kelimesini veya seçili filtreleri değiştirerek tekrar deneyin.</p>
                    <button wire:click="resetFilters" class="px-4 py-2 bg-indigo-50 text-indigo-700 rounded-xl text-xs font-bold hover:bg-indigo-100 transition-colors">
                        Filtreleri Temizle
                    </button>
                </div>
            @endforelse
        </div>
    @else
        <!-- 5. GÖRÜNÜM 2: DETAYLI TABLO GÖRÜNÜMÜ -->
        <div class="bg-white rounded-2xl border border-gray-200/90 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50 text-gray-500 font-bold text-xs text-left">
                        <tr>
                            <th class="px-6 py-3.5">Banka & Borç Başlığı</th>
                            <th class="px-6 py-3.5">Tür</th>
                            <th class="px-6 py-3.5">Kalan Borç</th>
                            <th class="px-6 py-3.5">Aylık Faiz %</th>
                            <th class="px-6 py-3.5">Aylık Taksit</th>
                            <th class="px-6 py-3.5">Sonraki Vade</th>
                            <th class="px-6 py-3.5">90 Gün Takip Durumu</th>
                            <th class="px-6 py-3.5 text-right">İşlemler</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse ($debts as $debt)
                            @php
                                $daysLeft = max(0, 90 - $debt->days_overdue);
                                $isCritical = $daysLeft <= 25 && $debt->days_overdue > 0;
                            @endphp
                            <tr class="hover:bg-gray-50/70 transition-colors {{ $isCritical ? 'bg-red-50/40' : '' }}">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <span class="w-8 h-8 rounded-lg flex items-center justify-center text-white text-xs font-black shadow-xs shrink-0" style="background-color: {{ $debt->bank?->color ?? '#6366f1' }}">
                                            {{ mb_substr($debt->bank?->name ?? 'B', 0, 2) }}
                                        </span>
                                        <div class="min-w-0">
                                            <span class="font-bold text-gray-900 block truncate">{{ $debt->title }}</span>
                                            <span class="text-xs text-gray-500">{{ $debt->bank?->name ?? 'Şahıs / Diğer' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-black {{ $debt->type === 'kmh' ? 'bg-red-100 text-red-700' : ($debt->type === 'credit_card' ? 'bg-amber-100 text-amber-700' : ($debt->type === 'personal' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700')) }}">
                                        {{ $debt->type === 'kmh' ? 'KMH' : ($debt->type === 'credit_card' ? 'Kredi Kartı' : ($debt->type === 'personal' ? 'Şahıs' : 'Kredi')) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                     <span class="font-black text-red-600 block">₺{{ number_format($debt->remaining, 2, ',', '.') }}</span>
                                     @if ($debt->principal > 0 && ($debt->total_installments > 1 || $debt->type === 'loan'))
                                         <span class="text-[10px] text-gray-500 font-bold block">Toplam: ₺{{ number_format($debt->principal, 2, ',', '.') }}</span>
                                     @endif

                                 </td>
                                <td class="px-6 py-4">
                                     @if ($debt->interest_rate > 0)
                                         <span class="font-bold text-gray-800">%{{ number_format($debt->interest_rate, 2) }}</span>
                                     @else
                                         <span class="inline-block px-2 py-0.5 rounded text-xs font-black bg-emerald-50 text-emerald-700 border border-emerald-200">
                                             Faizsiz (%0)
                                         </span>
                                     @endif
                                 </td>
                                <td class="px-6 py-4 text-indigo-700 font-bold">
                                    {{ $debt->installment_amount ? '₺' . number_format($debt->installment_amount, 2, ',', '.') : '-' }}
                                </td>
                                <td class="px-6 py-4 text-gray-600 text-xs font-medium">
                                    {{ $debt->next_due_date ? \Carbon\Carbon::parse($debt->next_due_date)->format('d.m.Y') : '-' }}
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
                                    <button wire:click="openEditModal({{ $debt->id }})" class="text-indigo-600 hover:text-indigo-900 font-bold text-xs">Düzenle</button>
                                    <button wire:click="delete({{ $debt->id }})" wire:confirm="Bu borcu silmek istediğinize emin misiniz?" class="text-red-600 hover:text-red-900 font-bold text-xs">Sil</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center text-gray-500 space-y-2">
                                    <p class="text-sm font-bold">Seçili filtrelerle eşleşen borç bulunamadı.</p>
                                    <button wire:click="resetFilters" class="text-xs text-indigo-600 font-bold hover:underline">
                                        Filtreleri Temizle
                                    </button>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- 6. BORÇ EKLEME & DÜZENLEME MODALI -->
    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-xs p-4 overflow-y-auto">
            <div class="bg-white rounded-2xl max-w-lg w-full p-5 sm:p-6 shadow-2xl space-y-4 my-8 max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <h3 class="font-bold text-lg text-gray-900">{{ $debtId ? 'Borç Kaydını Düzenle' : 'Yeni Borç / Kredi Tanımla' }}</h3>
                    <button wire:click="$set('showModal', false)" class="text-gray-400 hover:text-gray-600 font-bold text-lg">✕</button>
                </div>

                <div class="space-y-3.5">
                    <!-- 1. Adım: Borç Türü & Senaryo Seçimi -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Borç Türü & Senaryosu</label>
                            <select wire:model.live="type" class="w-full rounded-xl border-gray-300 text-sm font-bold focus:ring-indigo-500 focus:border-indigo-500 bg-indigo-50/50">
                                <option value="loan">Banka Kredisi (İhtiyaç/Konut/Taşıt)</option>
                                <option value="credit_card">Kredi Kartı Dönem / Asgari Borcu</option>
                                <option value="kmh">KMH / Eksi Bakiye (Artı Para/Avans)</option>
                                <option value="personal">Şahıs / Elden / Senetli Borç</option>
                                <option value="other">Diğer / Ticari Borç</option>
                            </select>
                        </div>

                        <!-- Senaryoya Göre Dinamik Seçim -->
                        @if ($type === 'credit_card')
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">Hangi Kredi Kartınız?</label>
                                <select wire:model.live="credit_card_id" class="w-full rounded-xl border-gray-300 text-sm font-medium focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">Kayıtlı Kart Seçin (veya elle girin)</option>
                                    @foreach ($userCards as $uc)
                                        <option value="{{ $uc->id }}">
                                            {{ $uc->bank?->name }} - {{ $uc->name }} ({{ $uc->masked_card_number }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @elseif ($type === 'kmh')
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">Hangi Banka Hesabı / KMH?</label>
                                <select wire:model.live="account_id" class="w-full rounded-xl border-gray-300 text-sm font-medium focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">Kayıtlı Hesap Seçin (veya elle girin)</option>
                                    @foreach ($userAccounts as $ua)
                                        <option value="{{ $ua->id }}">
                                            {{ $ua->bank?->name }} - {{ $ua->name }} ({{ $ua->masked_iban }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @elseif ($type === 'loan')
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">Kredi Kategorisi</label>
                                <select wire:model.live="loan_category" class="w-full rounded-xl border-gray-300 text-sm font-medium focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="consumer">İhtiyaç Kredisi</option>
                                    <option value="vehicle">Taşıt Kredisi</option>
                                    <option value="housing">Konut Kredisi</option>
                                    <option value="commercial">Ticari / KOBİ Kredisi</option>
                                </select>
                            </div>
                        @elseif ($type === 'personal')
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">Alacaklı Kişi / Kurum</label>
                                <input type="text" wire:model.live="creditor_name" class="w-full rounded-xl border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Örn: Ahmet Bey, Ev Sahibi">
                            </div>
                        @endif
                    </div>

                    <!-- 2. Banka Seçimi (Şahıs borcu değilse) -->
                    @if ($type !== 'personal')
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">İlgili Banka</label>
                                <select wire:model.live="bank_id" class="w-full rounded-xl border-gray-300 text-sm font-medium focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">Banka Seçin</option>
                                    @foreach ($banks as $b)
                                        <option value="{{ $b->id }}">{{ $b->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">Borç Başlığı</label>
                                <input type="text" wire:model="title" class="w-full rounded-xl border-gray-300 text-sm font-medium focus:ring-indigo-500 focus:border-indigo-500" placeholder="Örn: Garanti İhtiyaç Kredisi">
                                @error('title') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    @else
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Borç Başlığı / Tanımı</label>
                            <input type="text" wire:model="title" class="w-full rounded-xl border-gray-300 text-sm font-medium focus:ring-indigo-500 focus:border-indigo-500" placeholder="Örn: Ahmet Bey'e Elden Borç">
                            @error('title') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>
                    @endif


                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Kalan Ana Borç (TL)</label>
                            <input type="number" step="0.01" wire:model="remaining" class="w-full rounded-xl border-gray-300 text-sm font-bold text-red-600 focus:ring-indigo-500 focus:border-indigo-500" placeholder="120000">
                            @error('remaining') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Aylık Faiz Oranı (%)</label>
                            <input type="number" step="0.01" wire:model="interest_rate" class="w-full rounded-xl border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="3.90">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Aylık Taksit Tutarı (TL)</label>
                            <input type="number" step="0.01" wire:model="installment_amount" class="w-full rounded-xl border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="6500">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Kaç Gündür Gecikmede?</label>
                            <input type="number" wire:model="days_overdue" class="w-full rounded-xl border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="0">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Sonraki Vade Tarihi</label>
                            <input type="date" wire:model="next_due_date" class="w-full rounded-xl border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">En Son Ödeme Tarihi</label>
                            <input type="date" wire:model="last_payment_date" class="w-full rounded-xl border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Strateji & Takip Notu</label>
                        <textarea wire:model="notes" rows="2" class="w-full rounded-xl border-gray-300 text-xs focus:ring-indigo-500 focus:border-indigo-500" placeholder="Örn: 24 ay yapılandırma teklifi istendi, faiz indirimi bekleniyor"></textarea>
                    </div>
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
</div>600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">
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
