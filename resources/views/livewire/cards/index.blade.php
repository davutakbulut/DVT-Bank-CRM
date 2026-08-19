<div class="py-2 sm:py-6 px-3 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-gray-900 tracking-tight flex items-center gap-2">
                <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 3h6m-6 3h6m-6 3h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5z"/></svg>
                <span>Kredi Kartlarım</span>
            </h1>
            <p class="text-sm text-gray-600">Bankalarınıza özel gerçek kart temaları, dönem borçları, limit doluluk oranları ve 90 gün yasal takip kalkanı</p>
        </div>
        <div class="flex items-center gap-2.5 flex-wrap">
            <!-- Excel / CSV İndirme Butonu (Tooltip Popup ile) -->
            <div class="relative group/tooltip" x-data="{ show: false }">
                <button wire:click="exportExcel" 
                        @mouseenter="show = true" 
                        @mouseleave="show = false"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-300 font-black text-xs sm:text-sm rounded-xl shadow-2xs transition-all active:scale-95">
                    <svg class="w-4 h-4 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                    <span>Excel'e Aktar</span>
                </button>

                <!-- Açıklayıcı Bilgi Popup (Tooltip) -->
                <div x-show="show" 
                     x-cloak
                     class="absolute right-0 top-full mt-2 w-72 p-3 bg-slate-900 text-white rounded-2xl shadow-2xl border border-slate-700 text-xs z-50 pointer-events-none transition-all">
                    <div class="flex items-center gap-1.5 font-bold text-emerald-300 border-b border-slate-800 pb-1.5 mb-1.5">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 3h6m-6 3h6m-6 3h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5z"/></svg>
                        <span>Kredi Kartları Excel Raporu</span>
                    </div>
                    <p class="text-[11px] text-slate-300 leading-relaxed">
                        Tüm banka kredi kartlarınızın toplam limitlerini, güncel ekstre borçlarını, kullanılabilir limitlerini, asgari ödeme tutarlarını ve hesap kesim günlerini içeren <strong>Excel tablosunu</strong> indirir.
                    </p>
                    <span class="block mt-2 text-[10px] font-bold text-emerald-400 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        <span>Excel & Google Sheets Uyumlu</span>
                    </span>
                </div>
            </div>

            <button wire:click="openCreateModal" class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white font-black text-sm rounded-xl shadow-md transition-all">
                <span>+ Yeni Kart Ekle</span>
            </button>
        </div>
    </div>


    @if (session()->has('message'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm font-bold flex items-center gap-2 shadow-xs">
            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
            <span>{{ session('message') }}</span>
        </div>
    @endif

    <!-- 🔍 DETAYLI FİLTRE & ARAMA BAR (Segmented Control & Grid/Table Toggle) -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-2xs p-3.5 sm:p-4 space-y-3">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-3">
            <!-- Durum Sekmeleri (Segmented Bar) -->
            <div class="inline-flex p-1 bg-slate-100 rounded-lg border border-slate-200/80 overflow-x-auto no-scrollbar">
                <button wire:click="$set('statusFilter', 'all')" class="px-3 py-1.5 text-xs font-bold rounded-md transition-all whitespace-nowrap shrink-0 {{ $statusFilter === 'all' ? 'bg-white text-slate-900 shadow-2xs border border-slate-200/60' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-200/40' }}">
                    Tümü <span class="ml-1 text-[10px] font-mono px-1.5 py-0.5 rounded bg-slate-200/70 text-slate-700">({{ $cards->count() }})</span>
                </button>
                <button wire:click="$set('statusFilter', 'high_utilization')" class="px-3 py-1.5 text-xs font-bold rounded-md transition-all whitespace-nowrap shrink-0 {{ $statusFilter === 'high_utilization' ? 'bg-white text-red-700 shadow-2xs border border-slate-200/60' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-200/40' }}">
                    🔥 Yüksek Doluluk (%80+)
                </button>
                <button wire:click="$set('statusFilter', 'cash_advance')" class="px-3 py-1.5 text-xs font-bold rounded-md transition-all whitespace-nowrap shrink-0 {{ $statusFilter === 'cash_advance' ? 'bg-white text-indigo-700 shadow-2xs border border-slate-200/60' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-200/40' }}">
                    ⚡ Avans Açık
                </button>
                <button wire:click="$set('statusFilter', 'rewards')" class="px-3 py-1.5 text-xs font-bold rounded-md transition-all whitespace-nowrap shrink-0 {{ $statusFilter === 'rewards' ? 'bg-white text-amber-700 shadow-2xs border border-slate-200/60' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-200/40' }}">
                    🎁 Puanlı Kartlar
                </button>
                <button wire:click="$set('statusFilter', 'restructured')" class="px-3 py-1.5 text-xs font-bold rounded-md transition-all whitespace-nowrap shrink-0 {{ $statusFilter === 'restructured' ? 'bg-white text-emerald-700 shadow-2xs border border-slate-200/60' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-200/40' }}">
                    🔄 Yapılandırılmış
                </button>
            </div>

            <!-- Görünüm Seçici (Kart vs Tablo) -->
            <div class="flex items-center gap-1.5 shrink-0 bg-slate-100 p-1 rounded-lg border border-slate-200/80">
                <button wire:click="$set('viewMode', 'grid')" class="px-2.5 py-1 rounded-md text-xs font-bold transition-all flex items-center gap-1 cursor-pointer {{ $viewMode === 'grid' ? 'bg-white text-indigo-700 shadow-2xs border border-slate-200/60' : 'text-slate-600 hover:text-slate-900' }}">
                    <span>💳</span>
                    <span class="hidden sm:inline">Kart Akışı</span>
                </button>
                <button wire:click="$set('viewMode', 'table')" class="px-2.5 py-1 rounded-md text-xs font-bold transition-all flex items-center gap-1 cursor-pointer {{ $viewMode === 'table' ? 'bg-white text-indigo-700 shadow-2xs border border-slate-200/60' : 'text-slate-600 hover:text-slate-900' }}">
                    <span>📑</span>
                    <span class="hidden sm:inline">Tablo</span>
                </button>
            </div>
        </div>

        <!-- Arama, Banka & Sıralama Barı -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5 pt-1 border-t border-slate-100">
            <!-- Arama Kutusu -->
            <div class="relative">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Kart adı, son 4 hane veya banka ara..." class="w-full pl-9 pr-3 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-xs font-medium text-slate-800 placeholder-slate-400 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
            </div>

            <!-- Banka Seçimi -->
            <div>
                <select wire:model.live="selected_bank_id" class="w-full py-1.5 px-3 bg-slate-50 border border-slate-200 rounded-lg text-xs font-semibold text-slate-800 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                    <option value="">Tüm Bankalar</option>
                    @foreach ($banks as $b)
                        <option value="{{ $b->id }}">{{ $b->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Sıralama -->
            <div>
                <select wire:model.live="sortBy" class="w-full py-1.5 px-3 bg-slate-50 border border-slate-200 rounded-lg text-xs font-semibold text-slate-800 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                    <option value="utilization_desc">Doluluk Oranına Göre (Yüksek -> Düşük)</option>
                    <option value="debt_desc">Borç Tutarına Göre (En Çok Borçlu)</option>
                    <option value="available_desc">Kullanılabilir Limite Göre (En Yüksek)</option>
                    <option value="limit_desc">Toplam Limite Göre</option>
                    <option value="name_asc">Kart Adına Göre (A-Z)</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Kartlar Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($cards as $card)
            @php
                $bankName = mb_strtolower($card->bank?->name ?? '');
                $baseColor = $card->bank?->color ?? '#6366f1';
                
                // Bankaya Özel Lüks Gradyan & Kart Teması
                if (str_contains($bankName, 'garanti')) {
                    $cardGradient = 'from-[#005a2b] via-[#023d1d] to-[#011c0d]';
                    $accentBorder = 'border-emerald-500/40';
                    $glowColor = 'bg-emerald-500/20';
                    $cardType = 'Bonus & Miles&Smiles';
                } elseif (str_contains($bankName, 'akbank')) {
                    $cardGradient = 'from-[#a80000] via-[#700000] to-[#380000]';
                    $accentBorder = 'border-red-500/40';
                    $glowColor = 'bg-red-500/20';
                    $cardType = 'Axess & Wings';
                } elseif (str_contains($bankName, 'iş') || str_contains($bankName, 'is bankasi')) {
                    $cardGradient = 'from-[#003875] via-[#00224b] to-[#001026]';
                    $accentBorder = 'border-blue-500/40';
                    $glowColor = 'bg-blue-500/20';
                    $cardType = 'Maximum Kart';
                } elseif (str_contains($bankName, 'yapı') || str_contains($bankName, 'yapi')) {
                    $cardGradient = 'from-[#00529b] via-[#003366] to-[#001833]';
                    $accentBorder = 'border-sky-500/40';
                    $glowColor = 'bg-sky-500/20';
                    $cardType = 'Worldcard';
                } elseif (str_contains($bankName, 'ziraat')) {
                    $cardGradient = 'from-[#990012] via-[#66000c] to-[#330006]';
                    $accentBorder = 'border-rose-500/40';
                    $glowColor = 'bg-rose-500/20';
                    $cardType = 'Bankkart';
                } elseif (str_contains($bankName, 'vakıf') || str_contains($bankName, 'vakif')) {
                    $cardGradient = 'from-[#b87d00] via-[#7a5300] to-[#3d2900]';
                    $accentBorder = 'border-amber-500/40';
                    $glowColor = 'bg-amber-500/20';
                    $cardType = 'VakıfBank Platinum';
                } elseif (str_contains($bankName, 'halk')) {
                    $cardGradient = 'from-[#00609c] via-[#003b61] to-[#001d30]';
                    $accentBorder = 'border-cyan-500/40';
                    $glowColor = 'bg-cyan-500/20';
                    $cardType = 'Paraf Kart';
                } elseif (str_contains($bankName, 'qnb') || str_contains($bankName, 'finans')) {
                    $cardGradient = 'from-[#521350] via-[#330932] to-[#170317]';
                    $accentBorder = 'border-purple-500/40';
                    $glowColor = 'bg-purple-500/20';
                    $cardType = 'CardFinans';
                } elseif (str_contains($bankName, 'enpara')) {
                    $cardGradient = 'from-[#4a1f68] via-[#2d1140] to-[#14061f]';
                    $accentBorder = 'border-violet-500/40';
                    $glowColor = 'bg-violet-500/20';
                    $cardType = 'Enpara.com Kredi Kartı';
                } elseif (str_contains($bankName, 'deniz')) {
                    $cardGradient = 'from-[#00638a] via-[#003d57] to-[#001c29]';
                    $accentBorder = 'border-teal-500/40';
                    $glowColor = 'bg-teal-500/20';
                    $cardType = 'Bonus Deniz';
                } elseif (str_contains($bankName, 'teb')) {
                    $cardGradient = 'from-[#005f30] via-[#003d1f] to-[#001a0d]';
                    $accentBorder = 'border-emerald-500/40';
                    $glowColor = 'bg-emerald-500/20';
                    $cardType = 'TEB Bonus';
                } else {
                    $cardGradient = 'from-slate-800 via-slate-900 to-slate-950';
                    $accentBorder = 'border-slate-700';
                    $glowColor = 'bg-indigo-500/10';
                    $cardType = 'Kredi Kartı';
                }

                $limit = (float) $card->credit_limit;
                $debt = (float) $card->current_debt;
                $usagePercent = $limit > 0 ? min(100, round(($debt / $limit) * 100)) : 0;
                $availableLimit = max(0, $limit - $debt);

                $daysOverdue = 0;
                if ($card->last_payment_date) {
                    $daysOverdue = (int) \Carbon\Carbon::parse($card->last_payment_date)->diffInDays(now());
                }
                $daysToLegal = max(0, 90 - $daysOverdue);
                $isNearLegal = $daysToLegal <= 25;
            @endphp

            <!-- Lüks Fiziksel Banka Kartı Görünümü -->
            <div x-data="{ revealed: false }" class="bg-gradient-to-br {{ $cardGradient }} text-white p-5 sm:p-6 rounded-2xl shadow-xl relative overflow-hidden flex flex-col justify-between min-h-[250px] border {{ $accentBorder }} transition-all duration-300 hover:scale-[1.02] hover:shadow-2xl group">
                <!-- Ambient Ambient Glow -->
                <div class="absolute -top-12 -right-12 w-40 h-40 {{ $glowColor }} rounded-full blur-3xl pointer-events-none"></div>

                <!-- 1. Satır: Banka Logosu, Kart Başlığı & Çip -->
                <div class="relative z-10 flex items-start justify-between gap-2">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg text-white font-black flex items-center justify-center text-xs shadow-md border border-white/20" style="background-color: {{ $baseColor }};">
                            {{ mb_substr($card->bank?->name ?? 'BK', 0, 2) }}
                        </div>
                        <div>
                            <span class="text-[11px] font-black uppercase tracking-wider text-slate-300 block leading-tight">{{ $card->bank?->name }}</span>
                            <h3 class="text-sm font-bold text-white leading-tight mt-0.5">{{ $card->name }}</h3>
                        </div>
                    </div>

                    <!-- EMV Çip & Temassız NFC Simgesi -->
                    <div class="flex items-center gap-2 shrink-0">
                        <!-- NFC Waves -->
                        <span class="text-slate-300 text-xs font-mono tracking-tighter opacity-80 rotate-90">))))</span>
                        <!-- Gold Metallic EMV Chip -->
                        <div class="w-9 h-6.5 rounded-md bg-gradient-to-br from-amber-300 via-amber-400 to-amber-500 border border-amber-200/80 shadow-md flex items-center justify-center relative overflow-hidden">
                            <div class="absolute inset-0 border border-amber-600/40 rounded-sm m-0.5"></div>
                            <div class="w-4 h-full border-x border-amber-600/30"></div>
                        </div>
                    </div>
                </div>

                <!-- 2. Satır: Güvenli Maskeli Kart Numarası & Vade Günleri -->
                <div class="relative z-10 my-3 space-y-1.5">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span x-show="!revealed" class="font-mono text-base tracking-widest text-slate-200 drop-shadow-sm font-bold">
                                {{ $card->masked_card_number }}
                            </span>
                            <span x-show="revealed" x-cloak class="font-mono text-base tracking-widest text-amber-300 drop-shadow-sm font-bold">
                                {{ $card->formatted_card_number }}
                            </span>
                            @if (!empty($card->card_number))
                                <button type="button" @click="revealed = !revealed" class="p-1 rounded-md bg-white/10 hover:bg-white/20 text-slate-300 text-xs transition-colors" title="Numarayı Göster / Gizle">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </button>
                            @endif
                        </div>
                        <span class="text-[10px] font-mono text-slate-300/90 tracking-wider">
                            SKT: {{ $card->expiry_date ?: (str_pad($card->due_day ?? 15, 2, '0', STR_PAD_LEFT) . '/' . date('y', strtotime('+3 years'))) }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between text-[10px] text-slate-300">
                        <span class="uppercase tracking-wider font-medium text-slate-300/90">{{ $card->card_holder ?: Auth::user()->name }}</span>
                        <span class="font-bold text-amber-300">Son Ödeme: Ayın {{ $card->due_day }}. günü</span>
                    </div>
                </div>

                <!-- 3. Satır: Limit Doluluk Oranı Barı -->
                <div class="relative z-10 my-1 space-y-1">
                    <div class="flex items-center justify-between text-[10px] font-bold">
                        <span class="text-slate-300">Limit Kullanımı</span>
                        <span class="{{ $usagePercent > 85 ? 'text-red-400 font-black' : ($usagePercent > 50 ? 'text-amber-300' : 'text-emerald-400') }}">
                            %{{ $usagePercent }} (Kalan: ₺{{ number_format($availableLimit, 0, ',', '.') }})
                        </span>
                    </div>
                    <div class="w-full h-1.5 bg-black/40 rounded-full overflow-hidden border border-white/10">
                        <div class="h-full rounded-full transition-all duration-500 {{ $usagePercent > 85 ? 'bg-red-500' : ($usagePercent > 50 ? 'bg-amber-400' : 'bg-emerald-400') }}" style="width: {{ $usagePercent }}%;"></div>
                    </div>
                </div>

                <!-- 3.5. Satır: Puan / Jest Lira & Nakit Avans Rozetleri -->
                <div class="relative z-10 my-1 flex items-center justify-between text-[10px] gap-2 pt-1">
                    @if ((float)$card->reward_balance > 0)
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-amber-400/20 border border-amber-300/40 text-amber-200 font-bold text-[10px]">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>₺{{ number_format($card->reward_balance, 2, ',', '.') }} Puan/Jest Lira</span>
                        </span>
                    @else
                        <span></span>
                    @endif

                    @if ($card->cash_advance_limit)
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md {{ $card->is_cash_advance_blocked ? 'bg-red-500/25 border border-red-400/40 text-red-200' : 'bg-sky-500/20 border border-sky-400/40 text-sky-200' }} font-bold text-[10px]">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                            <span>Avans: ₺{{ number_format($card->cash_advance_limit, 0, ',', '.') }} {{ $card->is_cash_advance_blocked ? '(Kapalı 🚫)' : '' }}</span>
                        </span>
                    @endif
                </div>

                <!-- 4. Satır: Dönem Borcu / Asgari / Aksiyonlar -->
                <div class="relative z-10 pt-2 border-t border-white/15 flex items-end justify-between">
                    <div>
                        <span class="text-[9px] font-black tracking-wider text-slate-300/80 block uppercase">DÖNEM BORCU / ASGARİ</span>
                        <div class="flex items-baseline gap-1.5">
                            <span class="text-lg font-black text-white drop-shadow">₺{{ number_format($card->current_debt, 2, ',', '.') }}</span>
                            <span class="text-xs font-semibold text-slate-300">/ ₺{{ number_format($card->minimum_payment, 2, ',', '.') }}</span>
                        </div>
                    </div>


                    <!-- Hologram Mastercard/Visa & Butonlar -->
                    <div class="flex items-center gap-2">
                        <!-- Hologram Çift Daire -->
                        <div class="flex -space-x-2 opacity-85">
                            <div class="w-4.5 h-4.5 rounded-full bg-red-500/80 shadow-xs"></div>
                            <div class="w-4.5 h-4.5 rounded-full bg-amber-400/80 shadow-xs"></div>
                        </div>

                        <!-- Düzenle / Sil -->
                            </div>

                            <!-- Siyah Manyetik Bant Simülasyonu -->
                            <div class="-mx-5 sm:-mx-6 h-9 bg-slate-950 border-y border-slate-800 flex items-center justify-end px-4">
                                <span class="text-[10px] font-mono text-slate-500 tracking-widest">MAGNETIC STRIPE SECURITY</span>
                            </div>

                            <!-- Ekstra Metrikler Grid -->
                            <div class="grid grid-cols-2 gap-3 text-xs">
                                <div class="p-2 bg-white/5 rounded-xl border border-white/10">
                                    <span class="text-[9px] text-slate-400 uppercase block font-bold">Nakit Avans Limiti</span>
                                    @if ($card->is_cash_advance_blocked)
                                        <span class="font-bold text-red-400 text-xs">⛔ Nakit Avansa Kapalı</span>
                                    @else
                                        <span class="font-mono font-bold text-emerald-300 text-sm">₺{{ number_format($card->cash_advance_limit ?: $available, 2, ',', '.') }}</span>
                                    @endif
                                </div>

                                <div class="p-2 bg-white/5 rounded-xl border border-white/10">
                                    <span class="text-[9px] text-slate-400 uppercase block font-bold">Biriken Puan / Jest Lira</span>
                                    <span class="font-mono font-bold text-amber-300 text-sm">₺{{ number_format($card->reward_balance ?: 0, 2, ',', '.') }}</span>
                                </div>

                                <div class="p-2 bg-white/5 rounded-xl border border-white/10">
                                    <span class="text-[9px] text-slate-400 uppercase block font-bold">Aylık Akdi Faiz Oranı</span>
                                    <span class="font-mono font-bold text-white text-sm">%{{ number_format($card->interest_rate, 2) }}</span>
                                </div>

                                <div class="p-2 bg-white/5 rounded-xl border border-white/10">
                                    <span class="text-[9px] text-slate-400 uppercase block font-bold">Yapılandırma Durumu</span>
                                    <span class="font-bold text-xs {{ $card->is_restructured ? 'text-amber-300' : 'text-slate-300' }}">
                                        {{ $card->is_restructured ? '🔄 Yapılandırılmış' : 'Standart Sezon' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Risk Sayacı Uyarısı (Eğer Gecikme Varsa) -->
                    @if ($daysOverdue > 0)
                        <div class="mt-2.5 -mx-5 sm:-mx-6 -mb-5 sm:-mb-6 p-2 text-center text-[10px] font-black tracking-wide {{ $isNearLegal ? 'bg-red-600 text-white animate-pulse' : 'bg-amber-500 text-slate-950' }}">
                            {{ $daysOverdue }} Gündür Ödeme Yok • Yasal Takibe {{ $daysToLegal }} Gün Kaldı!
                        </div>
                    @endif
                </div>
            @empty
                <div class="col-span-full bg-white rounded-3xl p-12 text-center border-2 border-dashed border-gray-200 space-y-4 shadow-sm">
                    <div class="w-16 h-16 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center mx-auto text-3xl shadow-xs">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 3h6m-6 3h6m-6 3h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Henüz Kayıtlı Kredi Kartınız Yok</h3>
                        <p class="text-sm text-gray-500 max-w-md mx-auto mt-1">
                            Bankalardaki kredi kartlarınızı, limitlerini ve güncel dönem borçlarını ekleyerek banka temalı gerçek kart görselleriyle takip edin.
                        </p>
                    </div>
                    <button wire:click="openCreateModal" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm rounded-xl shadow-md transition-all">
                        + İlk Kredi Kartınızı Ekleyin
                    </button>
                </div>
            @endforelse
        </div>

    @elseif ($viewMode === 'table')
        <!-- TABLO GÖRÜNÜMÜ -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 border-b border-slate-200 text-slate-700 font-bold uppercase tracking-wider">
                        <tr>
                            <th class="px-4 py-3">Banka & Kart</th>
                            <th class="px-4 py-3 text-right">Kart Limiti</th>
                            <th class="px-4 py-3 text-right">Güncel Borç</th>
                            <th class="px-4 py-3 text-right">Serbest Limit</th>
                            <th class="px-4 py-3 text-right">Asgari Ödeme</th>
                            <th class="px-4 py-3 text-center">Doluluk %</th>
                            <th class="px-4 py-3 text-center">Kesim / Son Vade</th>
                            <th class="px-4 py-3 text-center">Avans Durumu</th>
                            <th class="px-4 py-3 text-right">İşlemler</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium text-slate-800">
                        @forelse ($cards as $c)
                            @php
                                $limit = (float) $c->credit_limit;
                                $debt = (float) $c->current_debt;
                                $avail = max(0, $limit - $debt);
                                $util = $limit > 0 ? min(100, round(($debt / $limit) * 100)) : 0;
                                $minPay = (float) ($c->minimum_payment ?: ($debt * 0.40));
                            @endphp
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2.5">
                                        <span class="w-7 h-7 rounded-lg flex items-center justify-center text-white text-[10px] font-black shrink-0" style="background-color: {{ $c->bank?->color ?? '#6366f1' }}">
                                            {{ mb_substr($c->bank?->name ?? 'K', 0, 2) }}
                                        </span>
                                        <div>
                                            <span class="font-bold text-slate-900 block">{{ $c->name }}</span>
                                            <span class="text-[10px] text-slate-500">{{ $c->bank?->name ?? 'Banka' }} · •••• {{ $c->last_four ?: '----' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-right font-mono font-bold text-slate-900">₺{{ number_format($limit, 2, ',', '.') }}</td>
                                <td class="px-4 py-3 text-right font-mono font-bold text-red-600">₺{{ number_format($debt, 2, ',', '.') }}</td>
                                <td class="px-4 py-3 text-right font-mono font-bold text-emerald-600">₺{{ number_format($avail, 2, ',', '.') }}</td>
                                <td class="px-4 py-3 text-right font-mono font-bold text-amber-600">₺{{ number_format($minPay, 2, ',', '.') }}</td>
                                <td class="px-4 py-3 text-center font-mono">
                                    <span class="px-2 py-0.5 rounded-md font-bold text-[10px] {{ $util >= 80 ? 'bg-red-100 text-red-800' : 'bg-slate-100 text-slate-800' }}">
                                        %{{ $util }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center text-slate-600">
                                    Ayın {{ $c->statement_day }}'i / {{ $c->due_day }}'u
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @if ($c->is_cash_advance_blocked)
                                        <span class="px-2 py-0.5 bg-red-100 text-red-700 font-bold text-[10px] rounded">Kapalı</span>
                                    @else
                                        <span class="px-2 py-0.5 bg-emerald-100 text-emerald-700 font-bold text-[10px] rounded">Açık</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <button wire:click="openEditModal({{ $c->id }})" class="p-1 text-slate-500 hover:text-indigo-600 transition-colors">
                                            Düzenle
                                        </button>
                                        <button wire:click="delete({{ $c->id }})" wire:confirm="Bu kartı silmek istediğinize emin misiniz?" class="p-1 text-red-500 hover:text-red-700 transition-colors">
                                            Sil
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-4 py-8 text-center text-slate-400">
                                    Kayıtlı kredi kartı bulunamadı.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- KART EKLEME / DÜZENLEME MODALI (CANLI KART ÖNİZLEMELİ) -->
    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-xs p-4 overflow-y-auto">
            <div class="bg-white rounded-2xl max-w-lg w-full p-5 sm:p-6 shadow-2xl space-y-4 my-8">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <div>
                        <h3 class="font-bold text-lg text-gray-900">{{ $cardId ? 'Kredi Kartını Düzenle' : 'Yeni Kredi Kartı Tanımla' }}</h3>
                        <p class="text-xs text-gray-500">Kart numarası güvenli şekilde şifrelenir ve ekranda sadece son 4 hanesi maskeli gösterilir.</p>
                    </div>
                    <button wire:click="$set('showModal', false)" class="text-gray-400 hover:text-gray-600 font-bold text-lg">✕</button>
                </div>

                <div class="space-y-3.5">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Banka Seçin</label>
                            <select wire:model.live="bank_id" class="w-full rounded-xl border-gray-300 text-sm font-medium focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Banka Seçin</option>
                                @foreach ($banks as $b)
                                    <option value="{{ $b->id }}">{{ $b->name }}</option>
                                @endforeach
                            </select>
                            @error('bank_id') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Kart Adı / Markası</label>
                            <input type="text" wire:model.live="name" class="w-full rounded-xl border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Örn: Maximum Kart, Bonus">
                            @error('name') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- 16 Haneli Tam Kart Numarası & Kart Sahibi -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Kart Numarası (Tam veya Son 4 Hane)</label>
                            <input type="text" 
                                   wire:model.live="card_number" 
                                   maxlength="19" 
                                   class="w-full rounded-xl border-gray-300 text-sm font-mono tracking-wider focus:ring-indigo-500 focus:border-indigo-500" 
                                   placeholder="5400 1234 5678 9012">
                            <p class="text-[10px] text-gray-400 mt-0.5">Tam 16 hane veya sadece 4 hane girebilirsiniz.</p>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Kart Üzerindeki İsim</label>
                            <input type="text" wire:model="card_holder" class="w-full rounded-xl border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500 uppercase" placeholder="AHMET YILMAZ">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Son Kullanma Tarihi (AA/YY)</label>
                            <input type="text" maxlength="5" wire:model="expiry_date" class="w-full rounded-xl border-gray-300 text-sm font-mono focus:ring-indigo-500 focus:border-indigo-500" placeholder="12/28">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Toplam Kart Limiti (TL)</label>
                            <input type="number" step="0.01" wire:model.live="credit_limit" class="w-full rounded-xl border-gray-300 text-sm font-bold focus:ring-indigo-500 focus:border-indigo-500" placeholder="60000">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Güncel Dönem Borcu (TL)</label>
                            <input type="number" step="0.01" wire:model.live="current_debt" class="w-full rounded-xl border-gray-300 text-sm font-bold text-red-600 focus:ring-indigo-500 focus:border-indigo-500" placeholder="45000">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Asgari Ödeme Tutarı (TL)</label>
                            <input type="number" step="0.01" wire:model="minimum_payment" class="w-full rounded-xl border-gray-300 text-sm font-bold text-amber-600 focus:ring-indigo-500 focus:border-indigo-500" placeholder="18000">
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Hesap Kesim</label>
                            <input type="number" min="1" max="31" wire:model="statement_day" class="w-full rounded-xl border-gray-300 text-sm" placeholder="1">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Son Ödeme Günü</label>
                            <input type="number" min="1" max="31" wire:model="due_day" class="w-full rounded-xl border-gray-300 text-sm" placeholder="10">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Aylık Akdi Faiz %</label>
                            <input type="number" step="0.01" wire:model="interest_rate" class="w-full rounded-xl border-gray-300 text-sm" placeholder="4.25">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Puan / Jest Lira (TL)</label>
                            <input type="number" step="0.01" wire:model="reward_balance" class="w-full rounded-xl border-gray-300 text-sm font-bold text-amber-600 focus:ring-indigo-500 focus:border-indigo-500" placeholder="150.16">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Nakit Avans Limiti (TL)</label>
                            <input type="number" step="0.01" wire:model="cash_advance_limit" class="w-full rounded-xl border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="12500">
                        </div>

                        <div class="flex items-center pt-5">
                            <label class="inline-flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" wire:model="is_cash_advance_blocked" class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                                <span class="text-xs font-bold text-red-600">Nakit Avansa Kapalı</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">En Son Ödeme Yapılan Tarih</label>
                        <input type="date" wire:model="last_payment_date" class="w-full rounded-xl border-gray-300 text-sm">
                        <p class="text-[10px] text-gray-500 mt-0.5">90 Günlük Yasal Takip kalkanı bu tarihe göre geriye sayım yapar.</p>
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
</div>
