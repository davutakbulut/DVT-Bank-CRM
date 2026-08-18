<div class="py-2 sm:py-6 px-3 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-6">
    <!-- 1. Header & Aksiyonlar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-gray-900 tracking-tight flex items-center gap-2">
                <span>🏦</span>
                <span>Hesaplarım & KMH (Ek Para)</span>
            </h1>
            <p class="text-sm text-gray-600">Banka temalı vadesiz hesap kartları, kredili mevduat (KMH) limitleri ve net likidite takibi</p>
        </div>
        <div class="flex items-center gap-2.5 flex-wrap">
            <!-- Excel / CSV İndirme Butonu (Tooltip Popup ile) -->
            <div class="relative group/tooltip" x-data="{ show: false }">
                <button wire:click="exportExcel" 
                        @mouseenter="show = true" 
                        @mouseleave="show = false"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-300 font-black text-xs sm:text-sm rounded-xl shadow-2xs transition-all active:scale-95">
                    <span>📥</span>
                    <span>Excel'e Aktar</span>
                </button>

                <!-- Açıklayıcı Bilgi Popup (Tooltip) -->
                <div x-show="show" 
                     x-cloak
                     class="absolute right-0 top-full mt-2 w-72 p-3 bg-slate-900 text-white rounded-2xl shadow-2xl border border-slate-700 text-xs z-50 pointer-events-none transition-all">
                    <div class="flex items-center gap-1.5 font-bold text-emerald-300 border-b border-slate-800 pb-1.5 mb-1.5">
                        <span>🏦</span>
                        <span>Banka Hesapları Excel Raporu</span>
                    </div>
                    <p class="text-[11px] text-slate-300 leading-relaxed">
                        Tüm vadesiz ve vadeli mevduat hesaplarınızın güncel bakiyelerini, IBAN numaralarını, tanımlı KMH (ek para) limitlerini ve kullanılan eksi bakiyeleri içeren <strong>Excel tablosunu</strong> indirir.
                    </p>
                    <span class="block mt-2 text-[10px] font-bold text-emerald-400">✓ Excel & Google Sheets Uyumlu</span>
                </div>
            </div>

            <!-- Görünüm Seçici -->
            <div class="inline-flex rounded-xl bg-gray-100 p-1 border border-gray-200 shadow-2xs">
                <button wire:click="$set('viewMode', 'stacked')" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all flex items-center gap-1.5 {{ $viewMode === 'stacked' ? 'bg-white text-indigo-700 shadow-xs' : 'text-gray-600 hover:text-gray-900' }}">
                    <span>🎴</span>
                    <span class="hidden sm:inline">Banka Yığını</span>
                </button>
                <button wire:click="$set('viewMode', 'grid')" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all flex items-center gap-1.5 {{ $viewMode === 'grid' ? 'bg-white text-indigo-700 shadow-xs' : 'text-gray-600 hover:text-gray-900' }}">
                    <span>▦</span>
                    <span class="hidden sm:inline">Kart Izgarası</span>
                </button>
                <button wire:click="$set('viewMode', 'table')" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all flex items-center gap-1.5 {{ $viewMode === 'table' ? 'bg-white text-indigo-700 shadow-xs' : 'text-gray-600 hover:text-gray-900' }}">
                    <span>📑</span>
                    <span class="hidden sm:inline">Tablo</span>
                </button>
            </div>

            <button wire:click="openCreateModal" class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white font-black text-sm rounded-xl shadow-md transition-all">
                <span>+ Yeni Hesap Ekle</span>
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
        <!-- Pozitif Varlıklar -->
        <div class="bg-white p-4 rounded-2xl border border-gray-200/80 shadow-xs flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg font-black shrink-0">
                ₺
            </div>
            <div class="min-w-0">
                <span class="text-[11px] font-bold text-gray-500 block uppercase tracking-wider truncate">Kullanılabilir Bakiye</span>
                <span class="text-lg sm:text-xl font-black text-emerald-600 truncate block">₺{{ number_format($totalPositive, 2, ',', '.') }}</span>
            </div>
        </div>

        <!-- Kullanılan KMH Borcu -->
        <div class="bg-white p-4 rounded-2xl border border-gray-200/80 shadow-xs flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-red-50 text-red-600 flex items-center justify-center text-lg font-black shrink-0">
                ⚡
            </div>
            <div class="min-w-0">
                <span class="text-[11px] font-bold text-gray-500 block uppercase tracking-wider truncate">Kullanılan KMH (Eksi)</span>
                <span class="text-lg sm:text-xl font-black text-red-600 truncate block">₺{{ number_format($totalKmhDebt, 2, ',', '.') }}</span>
            </div>
        </div>

        <!-- Toplam KMH Limiti -->
        <div class="bg-white p-4 rounded-2xl border border-gray-200/80 shadow-xs flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-lg font-black shrink-0">
                🛡️
            </div>
            <div class="min-w-0">
                <span class="text-[11px] font-bold text-gray-500 block uppercase tracking-wider truncate">Tanımlı KMH Limiti</span>
                <span class="text-lg sm:text-xl font-black text-indigo-700 truncate block">₺{{ number_format($totalKmhLimit, 2, ',', '.') }}</span>
            </div>
        </div>

        <!-- Net Likidite -->
        <div class="bg-white p-4 rounded-2xl border border-gray-200/80 shadow-xs flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl {{ $netLiquidity < 0 ? 'bg-red-50 text-red-600' : 'bg-blue-50 text-blue-600' }} flex items-center justify-center text-lg font-black shrink-0">
                📊
            </div>
            <div class="min-w-0">
                <span class="text-[11px] font-bold text-gray-500 block uppercase tracking-wider truncate">Net Nakit / Borç Durumu</span>
                <span class="text-lg sm:text-xl font-black {{ $netLiquidity < 0 ? 'text-red-600' : 'text-gray-900' }} truncate block">
                    ₺{{ number_format($netLiquidity, 2, ',', '.') }}
                </span>
            </div>
        </div>
    </div>

    <!-- 3. ÜST FİLTRE & ARAMA BAR -->
    <div class="bg-white rounded-2xl border border-gray-200/90 shadow-sm p-4 space-y-3">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-3">
            <!-- Tür Sekmeleri -->
            <div class="flex items-center gap-1.5 overflow-x-auto no-scrollbar pb-1">
                <button wire:click="$set('activeType', 'all')" class="px-3.5 py-1.5 text-xs font-bold rounded-xl transition-all whitespace-nowrap {{ $activeType === 'all' ? 'bg-indigo-600 text-white shadow-xs' : 'text-gray-600 hover:bg-gray-100' }}">
                    Tümü ({{ $accounts->count() }})
                </button>
                <button wire:click="$set('activeType', 'checking')" class="px-3.5 py-1.5 text-xs font-bold rounded-xl transition-all whitespace-nowrap {{ $activeType === 'checking' ? 'bg-indigo-600 text-white shadow-xs' : 'text-gray-600 hover:bg-gray-100' }}">
                    💳 Vadesiz Hesaplar
                </button>
                <button wire:click="$set('activeType', 'kmh')" class="px-3.5 py-1.5 text-xs font-bold rounded-xl transition-all whitespace-nowrap {{ $activeType === 'kmh' ? 'bg-indigo-600 text-white shadow-xs' : 'text-gray-600 hover:bg-gray-100' }}">
                    ⚡ KMH / Eksi Bakiye
                </button>
                <button wire:click="$set('activeType', 'savings')" class="px-3.5 py-1.5 text-xs font-bold rounded-xl transition-all whitespace-nowrap {{ $activeType === 'savings' ? 'bg-indigo-600 text-white shadow-xs' : 'text-gray-600 hover:bg-gray-100' }}">
                    📈 Vadeli Mevduat
                </button>
            </div>

            <!-- Banka Seçimi & Canlı Arama -->
            <div class="flex items-center gap-2">
                <select wire:model.live="selected_bank_id" class="rounded-xl border-gray-200 bg-gray-50 py-1.5 text-xs font-medium focus:bg-white focus:ring-indigo-500">
                    <option value="">Tüm Bankalar</option>
                    @foreach ($banks as $b)
                        <option value="{{ $b->id }}">{{ $b->name }}</option>
                    @endforeach
                </select>

                <div class="relative w-48 sm:w-60">
                    <input type="text" 
                           wire:model.live.debounce.300ms="search" 
                           placeholder="Hesap veya IBAN ara..." 
                           class="w-full pl-8 pr-7 py-1.5 bg-gray-50 border border-gray-200 rounded-xl text-xs font-medium focus:bg-white focus:ring-indigo-500">
                    <span class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none text-gray-400 text-xs">
                        🔍
                    </span>
                    @if ($search)
                        <button wire:click="$set('search', '')" class="absolute inset-y-0 right-0 pr-2 flex items-center text-gray-400 hover:text-gray-600 text-xs font-bold">
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
                        $themeLabel = 'QNB / Enpara • Vadesiz';
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
                                $kmhUsed = $isNegative ? abs($acc->balance) : 0;
                                $kmhPercent = (float)$acc->kmh_limit > 0 ? min(100, round(($kmhUsed / (float)$acc->kmh_limit) * 100)) : 0;
                            @endphp

                            <!-- Banka Temalı Hesap Kartı -->
                            <div class="relative rounded-2xl bg-gradient-to-br {{ $bankGradient }} border {{ $accentBorder }} shadow-xl p-5 text-white flex flex-col justify-between min-h-[220px] overflow-hidden group hover:scale-[1.02] hover:-translate-y-1 transition-all duration-300">
                                <!-- Lüks Işık Parıltısı -->
                                <div class="absolute -right-12 -bottom-12 w-36 h-36 {{ $glowColor }} rounded-full blur-2xl pointer-events-none"></div>

                                <!-- Üst Satır: Hesap Türü + Çip / Amblem -->
                                <div>
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider {{ $acc->type === 'kmh' ? 'bg-red-500/20 text-red-300 border border-red-500/40' : ($acc->type === 'savings' ? 'bg-amber-500/20 text-amber-300 border border-amber-500/40' : 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/40') }}">
                                                {{ $acc->type === 'kmh' ? '⚡ KMH / Ek Hesap' : ($acc->type === 'savings' ? '📈 Vadeli Mevduat' : '💳 Vadesiz TL') }}
                                            </span>
                                            <h3 class="text-base font-black text-white mt-1.5 truncate">{{ $acc->name }}</h3>
                                        </div>

                                        <!-- Çip / NFC Simgesi -->
                                        <div class="w-8 h-6 rounded-md bg-amber-300/90 border border-amber-200/80 font-mono text-[8px] font-bold flex items-center justify-center text-amber-950 shadow-inner">
                                            CHIP
                                        </div>
                                    </div>

                                    <!-- IBAN Gösterimi -->
                                    <div class="mt-2.5">
                                        <span class="font-mono text-xs tracking-wider text-slate-300/90">
                                            {{ $acc->iban ? chunk_split(str_replace(' ', '', $acc->iban), 4, ' ') : 'TR•• •••• •••• •••• •••• •••• ••' }}
                                        </span>
                                    </div>
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

                                        @if ($acc->type === 'kmh' && $acc->kmh_limit)
                                            <div class="text-right">
                                                <span class="text-[10px] font-bold text-slate-400 block uppercase tracking-wider">KMH LİMİTİ</span>
                                                <span class="text-xs font-bold text-slate-200">₺{{ number_format($acc->kmh_limit, 2, ',', '.') }}</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- KMH Doluluk Çubuğu -->
                                    @if ($acc->type === 'kmh' && $acc->kmh_limit > 0)
                                        <div class="space-y-1">
                                            <div class="flex justify-between text-[10px] font-bold text-slate-300">
                                                <span>KMH Kullanımı (%{{ $kmhPercent }})</span>
                                                <span>Faiz: %{{ number_format($acc->kmh_interest_rate, 2) }}</span>
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
                                            <button wire:click="openEditModal({{ $acc->id }})" class="px-2.5 py-1 bg-white/10 hover:bg-white/20 text-white rounded-lg text-xs font-bold transition-colors">
                                                Düzenle
                                            </button>
                                            <button wire:click="delete({{ $acc->id }})" wire:confirm="Bu hesabı silmek istediğinize emin misiniz?" class="px-2.5 py-1 bg-red-500/20 hover:bg-red-500/30 text-red-300 rounded-lg text-xs font-bold transition-colors">
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
                    <div class="text-3xl">🏦</div>
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
                    $kmhUsed = $isNegative ? abs($acc->balance) : 0;
                    $kmhPercent = (float)$acc->kmh_limit > 0 ? min(100, round(($kmhUsed / (float)$acc->kmh_limit) * 100)) : 0;

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

                <div class="relative rounded-2xl bg-gradient-to-br {{ $bankGradient }} border {{ $accentBorder }} shadow-xl p-5 text-white flex flex-col justify-between min-h-[220px] overflow-hidden group hover:scale-[1.02] transition-all">
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
                            <span class="font-mono text-xs tracking-wider text-slate-300/90">
                                {{ $acc->iban ? chunk_split(str_replace(' ', '', $acc->iban), 4, ' ') : 'TR•• •••• •••• •••• •••• •••• ••' }}
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
                            @if ($acc->type === 'kmh' && $acc->kmh_limit)
                                <div class="text-right">
                                    <span class="text-[10px] font-bold text-slate-400 block uppercase">LİMİT</span>
                                    <span class="text-xs font-bold text-slate-200">₺{{ number_format($acc->kmh_limit, 2, ',', '.') }}</span>
                                </div>
                            @endif
                        </div>

                        <div class="flex items-center justify-between pt-1">
                            <span class="text-[9px] text-slate-400 font-mono">#{{ $acc->id }}</span>
                            <div class="flex items-center gap-2">
                                <button wire:click="openEditModal({{ $acc->id }})" class="px-2.5 py-1 bg-white/10 hover:bg-white/20 text-white rounded-lg text-xs font-bold transition-colors">
                                    Düzenle
                                </button>
                                <button wire:click="delete({{ $acc->id }})" wire:confirm="Bu hesabı silmek istediğinize emin misiniz?" class="px-2.5 py-1 bg-red-500/20 hover:bg-red-500/30 text-red-300 rounded-lg text-xs font-bold transition-colors">
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
                                        <span class="w-8 h-8 rounded-lg flex items-center justify-center text-white text-xs font-black shadow-xs" style="background-color: {{ $acc->bank?->color ?? '#6366f1' }}">
                                            {{ mb_substr($acc->bank?->name ?? 'B', 0, 2) }}
                                        </span>
                                        <div>
                                            <span class="font-bold text-gray-900 block">{{ $acc->name }}</span>
                                            <span class="text-xs text-gray-500">{{ $acc->bank?->name }}</span>
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
                                <td class="px-6 py-4 text-gray-700 font-bold">
                                    {{ $acc->kmh_limit ? '₺' . number_format($acc->kmh_limit, 2, ',', '.') : '-' }}
                                </td>
                                <td class="px-6 py-4 text-gray-700 font-semibold">
                                    {{ $acc->kmh_interest_rate ? '%' . number_format($acc->kmh_interest_rate, 2) : '-' }}
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <button wire:click="openEditModal({{ $acc->id }})" class="text-indigo-600 hover:text-indigo-900 font-bold text-xs">Düzenle</button>
                                    <button wire:click="delete({{ $acc->id }})" wire:confirm="Bu hesabı silmek istediğinize emin misiniz?" class="text-red-600 hover:text-red-900 font-bold text-xs">Sil</button>
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
    @endif

    <!-- 7. HESAP EKLEME / DÜZENLEME MODALI -->
    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-xs p-4 overflow-y-auto">
            <div class="bg-white rounded-2xl max-w-lg w-full p-5 sm:p-6 shadow-2xl space-y-4 my-8 max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <h3 class="font-bold text-lg text-gray-900">{{ $accountId ? 'Hesabı Düzenle' : 'Yeni Banka Hesabı Tanımla' }}</h3>
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
                        <label class="block text-xs font-bold text-gray-700 mb-1">IBAN Numarası (İsteğe Bağlı)</label>
                        <input type="text" wire:model="iban" class="w-full rounded-xl border-gray-300 text-sm font-mono focus:ring-indigo-500 focus:border-indigo-500" placeholder="TR00 0000 0000 0000 0000 0000 00">
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
