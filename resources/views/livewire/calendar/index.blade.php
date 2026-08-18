<div class="py-2 sm:py-6 px-3 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-6">
    <!-- 1. Header & Görünüm Seçici -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-gray-900 tracking-tight flex items-center gap-2">
                <span>🗓️</span>
                <span>Ödeme & Vade Takvimi</span>
            </h1>
            <p class="text-sm text-gray-600">Aylık kredi kartı ekstreleri, KMH kesintileri, kredi taksitleri ve aynı güne denk gelen banka ödeme çakışmaları</p>
        </div>

        <div class="flex items-center gap-2.5 flex-wrap">
            <!-- Görünüm Seçici -->
            <div class="inline-flex rounded-xl bg-gray-100 p-1 border border-gray-200 shadow-2xs">
                <button wire:click="$set('viewMode', 'grid')" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all flex items-center gap-1.5 {{ $viewMode === 'grid' ? 'bg-white text-indigo-700 shadow-xs' : 'text-gray-600 hover:text-gray-900' }}">
                    <span>📅</span>
                    <span class="hidden sm:inline">Aylık Izgara</span>
                </button>
                <button wire:click="$set('viewMode', 'feed')" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all flex items-center gap-1.5 {{ $viewMode === 'feed' ? 'bg-white text-indigo-700 shadow-xs' : 'text-gray-600 hover:text-gray-900' }}">
                    <span>🚨</span>
                    <span class="hidden sm:inline">Çakışma & Akış</span>
                </button>
                <button wire:click="$set('viewMode', 'table')" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all flex items-center gap-1.5 {{ $viewMode === 'table' ? 'bg-white text-indigo-700 shadow-xs' : 'text-gray-600 hover:text-gray-900' }}">
                    <span>📊</span>
                    <span class="hidden sm:inline">Tablo</span>
                </button>
            </div>

            <!-- Ay Navigasyonu -->
            <div class="inline-flex items-center gap-1 bg-white border border-gray-200 rounded-xl p-1 shadow-2xs">
                <button wire:click="previousMonth" class="px-2.5 py-1 text-gray-700 hover:bg-gray-100 rounded-lg font-black text-xs transition-colors">
                    ←
                </button>
                <span class="px-3 py-1 text-indigo-950 font-black text-xs capitalize whitespace-nowrap">
                    {{ $monthTitle }}
                </span>
                <button wire:click="nextMonth" class="px-2.5 py-1 text-gray-700 hover:bg-gray-100 rounded-lg font-black text-xs transition-colors">
                    →
                </button>
            </div>
        </div>
    </div>

    <!-- 2. ÖDEME ÇAKIŞMASI UYARI RADARI -->
    @if (count($collisionDays) > 0)
        <div class="bg-gradient-to-r from-red-950 via-slate-900 to-rose-950 border border-red-500/40 rounded-3xl p-5 sm:p-6 text-white shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-4 relative overflow-hidden">
            <div class="flex items-start gap-3.5 z-10">
                <div class="w-11 h-11 rounded-2xl bg-red-600/30 border border-red-500 text-red-300 text-2xl flex items-center justify-center shrink-0 animate-pulse">
                    🚨
                </div>
                <div class="space-y-1">
                    <h3 class="font-black text-base text-red-200">
                        Bu Ay {{ count($collisionDays) }} Farklı Günde Banka Ödeme Çakışması Tespit Edildi!
                    </h3>
                    <p class="text-xs text-slate-300 max-w-2xl leading-relaxed">
                        Aynı güne birden fazla bankanın kredi kartı veya taksiti denk geliyor. Nakit sıkışıklığı yaşamamak için çakışan günleri önceden planlayın.
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-3 self-start md:self-center z-10">
                <div class="text-left md:text-right bg-white/10 px-4 py-2 rounded-2xl border border-white/10">
                    <span class="text-[10px] text-slate-400 font-bold block uppercase">ÇAKIŞAN GÜNLERİN YÜKÜ</span>
                    <span class="text-lg sm:text-xl font-black text-red-400 block">₺{{ number_format($totalCollisionAmount, 2, ',', '.') }}</span>
                </div>
                <button wire:click="$toggle('collision_only')" class="px-4 py-2.5 rounded-xl font-black text-xs transition-all {{ $collision_only ? 'bg-red-600 text-white shadow-lg ring-2 ring-white/50' : 'bg-white/15 hover:bg-white/25 text-white' }}">
                    {{ $collision_only ? '✓ Sadece Çakışmalar Gösteriliyor' : 'Çakışan Günleri Filtrele' }}
                </button>
            </div>
        </div>
    @endif

    <!-- 3. KAPSAMLI ÜST FİLTRE PANELİ -->
    <div class="bg-white rounded-2xl border border-gray-200/90 shadow-sm p-4 sm:p-5 space-y-4">
        <!-- Üst Satır: Tür Sekmeleri + Arama -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-3 pb-3 border-b border-gray-100">
            <div class="flex items-center gap-1.5 overflow-x-auto no-scrollbar pb-1">
                <button wire:click="$set('payment_type', 'all')" class="px-3.5 py-1.5 text-xs font-bold rounded-xl transition-all whitespace-nowrap {{ $payment_type === 'all' ? 'bg-indigo-600 text-white shadow-xs' : 'text-gray-600 hover:bg-gray-100' }}">
                    Tümü ({{ $events->count() }})
                </button>
                <button wire:click="$set('payment_type', 'credit_card')" class="px-3.5 py-1.5 text-xs font-bold rounded-xl transition-all whitespace-nowrap {{ $payment_type === 'credit_card' ? 'bg-amber-600 text-white shadow-xs' : 'text-gray-600 hover:bg-gray-100' }}">
                    💳 Kredi Kartı Ekstreleri
                </button>
                <button wire:click="$set('payment_type', 'loan')" class="px-3.5 py-1.5 text-xs font-bold rounded-xl transition-all whitespace-nowrap {{ $payment_type === 'loan' ? 'bg-blue-600 text-white shadow-xs' : 'text-gray-600 hover:bg-gray-100' }}">
                    🏦 Kredi Taksitleri
                </button>
                <button wire:click="$set('payment_type', 'kmh')" class="px-3.5 py-1.5 text-xs font-bold rounded-xl transition-all whitespace-nowrap {{ $payment_type === 'kmh' ? 'bg-red-600 text-white shadow-xs' : 'text-gray-600 hover:bg-gray-100' }}">
                    ⚡ KMH Kesintileri
                </button>
                <button wire:click="$set('payment_type', 'plan')" class="px-3.5 py-1.5 text-xs font-bold rounded-xl transition-all whitespace-nowrap {{ $payment_type === 'plan' ? 'bg-indigo-600 text-white shadow-xs' : 'text-gray-600 hover:bg-gray-100' }}">
                    🎯 Ödeme Planı
                </button>
            </div>

            <!-- Canlı Arama Inputu -->
            <div class="relative w-full lg:w-72">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 text-xs">
                    🔍
                </span>
                <input type="text" 
                       wire:model.live.debounce.300ms="search" 
                       placeholder="Ödeme veya banka ara..." 
                       class="w-full pl-9 pr-8 py-1.5 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm font-medium focus:bg-white focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                @if ($search)
                    <button wire:click="$set('search', '')" class="absolute inset-y-0 right-0 pr-2.5 flex items-center text-gray-400 hover:text-gray-600 text-xs font-bold">
                        ✕
                    </button>
                @endif
            </div>
        </div>

        <!-- Alt Satır: Banka & Gün Seçici -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 items-center text-xs">
            <!-- 1. Banka Filtresi -->
            <div>
                <label class="block font-bold text-gray-600 mb-1 text-[11px]">🏛️ Banka Seçimi</label>
                <select wire:model.live="selected_bank_id" class="w-full rounded-xl border-gray-200 bg-gray-50/80 py-1.5 text-xs font-medium focus:bg-white focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Tüm Bankalar</option>
                    @foreach ($banks as $b)
                        <option value="{{ $b->id }}">{{ $b->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- 2. Gün Filtresi -->
            <div>
                <label class="block font-bold text-gray-600 mb-1 text-[11px]">📆 Gün Seçimi (Ayın Günü)</label>
                <select wire:model.live="selectedDay" class="w-full rounded-xl border-gray-200 bg-gray-50/80 py-1.5 text-xs font-medium focus:bg-white focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="all">Tüm Ay (1 - {{ $daysInMonth }})</option>
                    @for ($i = 1; $i <= $daysInMonth; $i++)
                        <option value="{{ $i }}">Ayın {{ $i }}. Günü</option>
                    @endfor
                </select>
            </div>

            <!-- 3. Toplam Bütçe Göstergesi -->
            <div class="p-2.5 bg-gray-50 rounded-xl border border-gray-200/80 flex items-center justify-between">
                <div>
                    <span class="text-[10px] font-bold text-gray-500 block uppercase">BU AYIN TOPLAM YÜKÜ</span>
                    <span class="text-sm font-black text-gray-900">₺{{ number_format($totalMonthAmount, 2, ',', '.') }}</span>
                </div>
                @if ($search || $selected_bank_id || $payment_type !== 'all' || $selectedDay !== 'all' || $collision_only)
                    <button wire:click="resetFilters" class="text-indigo-600 hover:text-indigo-800 font-black text-xs">
                        ↺ Sıfırla
                    </button>
                @endif
            </div>
        </div>
    </div>

    <!-- 4. GÖRÜNÜM 1: AY LIK TAKVİM IZGARASI (7x6 GRID) -->
    @if ($viewMode === 'grid')
        <div class="bg-white rounded-3xl border border-gray-200/90 shadow-sm overflow-hidden p-4 sm:p-6 space-y-4">
            <!-- Gün Başlıkları (Pzt -> Paz) -->
            <div class="grid grid-cols-7 gap-2 text-center text-xs font-black text-gray-500 uppercase tracking-wider pb-2 border-b border-gray-100">
                <span class="py-1">Pzt</span>
                <span class="py-1">Sal</span>
                <span class="py-1">Çar</span>
                <span class="py-1">Per</span>
                <span class="py-1">Cum</span>
                <span class="py-1 text-indigo-600">Cmt</span>
                <span class="py-1 text-indigo-600">Paz</span>
            </div>

            <!-- Takvim Günleri -->
            <div class="grid grid-cols-7 gap-2 sm:gap-3">
                <!-- Boş Başlangıç Hücreleri -->
                @for ($k = 0; $k < $startOfWeek; $k++)
                    <div class="min-h-[90px] sm:min-h-[120px] rounded-2xl bg-gray-50/50 border border-dashed border-gray-100"></div>
                @endfor

                <!-- Ayın Günleri -->
                @for ($day = 1; $day <= $daysInMonth; $day++)
                    @php
                        $dayEvents = $eventsByDay[$day] ?? collect();
                        $hasCollision = $dayEvents->count() > 1;
                        $dayTotal = $dayEvents->sum('amount');
                        $isToday = $currentDate->isCurrentMonth() && now()->day === $day;
                    @endphp

                    <div class="min-h-[90px] sm:min-h-[120px] rounded-2xl p-2 sm:p-2.5 border {{ $hasCollision ? 'border-red-400 bg-red-50/30 ring-1 ring-red-400/40' : ($isToday ? 'border-indigo-500 bg-indigo-50/30 ring-2 ring-indigo-500/30' : 'border-gray-200 bg-white hover:bg-gray-50/60') }} flex flex-col justify-between transition-all group relative overflow-hidden">
                        <!-- Üst Bar: Gün Numarası + Çakışma Rozeti -->
                        <div class="flex items-center justify-between">
                            <span class="w-6 h-6 rounded-lg text-xs font-black flex items-center justify-center {{ $isToday ? 'bg-indigo-600 text-white' : ($hasCollision ? 'bg-red-600 text-white' : 'text-gray-700 bg-gray-100') }}">
                                {{ $day }}
                            </span>

                            @if ($hasCollision)
                                <span class="px-1.5 py-0.5 rounded text-[9px] font-black bg-red-600 text-white animate-pulse">
                                    🚨 Çakışma ({{ $dayEvents->count() }})
                                </span>
                            @elseif ($dayEvents->count() > 0)
                                <span class="text-[9px] font-bold text-gray-400">
                                    {{ $dayEvents->count() }} Ödeme
                                </span>
                            @endif
                        </div>

                        <!-- Mini Kart Badge Listesi -->
                        <div class="space-y-1.5 my-1.5 max-h-[80px] overflow-y-auto no-scrollbar">
                            @foreach ($dayEvents as $ev)
                                <div class="p-1 sm:p-1.5 rounded-lg text-[10px] text-white font-bold flex items-center justify-between gap-1 shadow-2xs group/badge hover:scale-[1.02] transition-transform" style="background-color: {{ $ev->bank_color }};">
                                    <div class="flex items-center gap-1 min-w-0">
                                        <span class="text-[9px]">{{ $ev->type_icon }}</span>
                                        <span class="truncate leading-none">{{ $ev->title }}</span>
                                    </div>
                                    <span class="font-black text-[9px] shrink-0">₺{{ number_format($ev->amount, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>

                        <!-- Alt Satır: Gün Toplamı -->
                        @if ($dayTotal > 0)
                            <div class="pt-1 border-t border-gray-100/80 flex items-center justify-between text-[10px]">
                                <span class="text-gray-400 font-medium">Toplam:</span>
                                <span class="font-black {{ $hasCollision ? 'text-red-600' : 'text-gray-900' }}">
                                    ₺{{ number_format($dayTotal, 0, ',', '.') }}
                                </span>
                            </div>
                        @else
                            <div></div>
                        @endif
                    </div>
                @endfor
            </div>
        </div>
    @elseif ($viewMode === 'feed')
        <!-- 5. GÖRÜNÜM 2: ÇAKIŞMA VE GÜN AKIŞI (FEED) -->
        <div class="space-y-4">
            @forelse ($eventsByDay as $dayNum => $dayEvs)
                @if ($dayEvs->count() > 0)
                    @php
                        $hasCollision = $dayEvs->count() > 1;
                        $dayTotal = $dayEvs->sum('amount');
                    @endphp

                    <div class="bg-white rounded-3xl border {{ $hasCollision ? 'border-red-400 ring-2 ring-red-400/20' : 'border-gray-200/90' }} p-5 sm:p-6 shadow-sm space-y-4">
                        <!-- Gün Başlığı & Çakışma Durumu -->
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-3 border-b border-gray-100">
                            <div class="flex items-center gap-3">
                                <span class="w-10 h-10 rounded-2xl text-white font-black text-sm flex items-center justify-center shadow-xs {{ $hasCollision ? 'bg-red-600 animate-pulse' : 'bg-indigo-600' }}">
                                    {{ $dayNum }}
                                </span>
                                <div>
                                    <h3 class="font-black text-gray-900 text-base">
                                        {{ \Carbon\Carbon::parse($currentMonth . '-' . sprintf('%02d', $dayNum))->translatedFormat('d F Y, l') }}
                                    </h3>
                                    <span class="text-xs {{ $hasCollision ? 'text-red-600 font-bold' : 'text-gray-500' }}">
                                        {{ $hasCollision ? '🚨 Farklı bankaların ' . $dayEvs->count() . ' ödemesi aynı gün çakışıyor!' : $dayEvs->count() . ' ödeme planlandı' }}
                                    </span>
                                </div>
                            </div>

                            <div class="bg-gray-50 px-4 py-2 rounded-2xl border border-gray-100 self-start sm:self-center">
                                <span class="text-xs font-bold text-gray-500">Günlük Toplam Yük:</span>
                                <span class="text-base font-black {{ $hasCollision ? 'text-red-600' : 'text-gray-900' }} ml-1">
                                    ₺{{ number_format($dayTotal, 2, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        <!-- Günün İçindeki Mini Kartlar -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                            @foreach ($dayEvs as $ev)
                                <div class="p-4 rounded-2xl text-white flex flex-col justify-between space-y-3 shadow-md relative overflow-hidden" style="background-color: {{ $ev->bank_color }};">
                                    <div class="flex items-start justify-between gap-2">
                                        <div>
                                            <span class="text-[10px] font-black uppercase tracking-wider text-white/80 block">{{ $ev->bank_name }}</span>
                                            <h4 class="font-bold text-sm text-white mt-0.5">{{ $ev->title }}</h4>
                                        </div>
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-white/20 text-white shrink-0">
                                            {{ $ev->type_icon }} {{ $ev->type_label }}
                                        </span>
                                    </div>

                                    <div class="pt-2 border-t border-white/20 flex items-baseline justify-between">
                                        <span class="text-[10px] text-white/80 uppercase font-semibold">Ödenecek Tutar</span>
                                        <span class="text-lg font-black text-white">₺{{ number_format($ev->amount, 2, ',', '.') }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @empty
                <div class="bg-white rounded-3xl p-12 text-center border-2 border-dashed border-gray-200 space-y-3">
                    <div class="text-3xl">📅</div>
                    <h3 class="font-bold text-gray-900 text-base">Bu ay için ödeme kaydı bulunamadı</h3>
                    <p class="text-xs text-gray-500">Farklı bir ay seçebilir veya filtreleri temizleyebilirsiniz.</p>
                </div>
            @endforelse
        </div>
    @else
        <!-- 6. GÖRÜNÜM 3: TABLO GÖRÜNÜMÜ -->
        <div class="bg-white rounded-2xl border border-gray-200/90 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50 text-gray-500 font-bold text-xs text-left">
                        <tr>
                            <th class="px-6 py-3.5">Vade / Gün</th>
                            <th class="px-6 py-3.5">Banka & Ödeme Başlığı</th>
                            <th class="px-6 py-3.5">Ödeme Türü</th>
                            <th class="px-6 py-3.5">Toplam Bakiye</th>
                            <th class="px-6 py-3.5 text-right">Ödenecek Tutar</th>
                            <th class="px-6 py-3.5 text-center">Çakışma Durumu</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse ($events as $ev)
                            @php
                                $hasCollision = isset($collisionDays[$ev->day]);
                            @endphp
                            <tr class="hover:bg-gray-50/70 transition-colors {{ $hasCollision ? 'bg-red-50/30' : '' }}">
                                <td class="px-6 py-4 font-black text-gray-900">
                                    {{ \Carbon\Carbon::parse($ev->due_date)->format('d.m.Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <span class="w-8 h-8 rounded-lg flex items-center justify-center text-white text-xs font-black shrink-0 shadow-xs" style="background-color: {{ $ev->bank_color }};">
                                            {{ mb_substr($ev->bank_name, 0, 2) }}
                                        </span>
                                        <div>
                                            <span class="font-bold text-gray-900 block">{{ $ev->title }}</span>
                                            <span class="text-xs text-gray-500">{{ $ev->bank_name }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold {{ $ev->badge_style }}">
                                        {{ $ev->type_icon }} {{ $ev->type_label }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 font-semibold text-gray-600">
                                    ₺{{ number_format($ev->total_debt, 2, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 font-black text-right text-gray-900">
                                    ₺{{ number_format($ev->amount, 2, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if ($hasCollision)
                                        <span class="px-2 py-0.5 rounded-md text-xs font-black bg-red-600 text-white animate-pulse">
                                            🚨 Çakışma Var
                                        </span>
                                    @else
                                        <span class="text-xs text-emerald-600 font-bold">Tek Ödeme</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                    Kayıtlı ödeme bulunmamaktadır.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
