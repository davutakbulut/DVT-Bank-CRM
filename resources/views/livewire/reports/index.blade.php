<div class="py-2 sm:py-6 px-3 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-6">
    <!-- 1. Header & Dönem Seçici -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-gray-900 tracking-tight flex items-center gap-2">
                <span>📊</span>
                <span>Finansal Analiz & Derin Raporlama Merkezi</span>
            </h1>
            <p class="text-sm text-gray-600">Ne harcıyorum, nereye harcıyorum, ne zaman daha çok harcıyorum ve bankalara ne kadar faiz ödüyorum?</p>
        </div>

        <div class="flex items-center gap-2 flex-wrap">
            <!-- Excel İndir Butonu & Bilgi Kutucuğu -->
            <div class="relative inline-block group">
                <button wire:click="exportExcel" 
                        class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white text-xs font-black rounded-xl shadow-sm transition-all cursor-pointer">
                    <span>📗</span>
                    <span>Excel Raporu İndir</span>
                </button>
                <!-- Tooltip Popup -->
                <div class="absolute right-0 top-full mt-2 hidden group-hover:block z-50 w-72 p-3 bg-slate-900 text-white text-xs rounded-xl shadow-2xl border border-slate-700 pointer-events-none transition-all">
                    <p class="font-bold text-emerald-400 mb-1">📊 Kapsamlı Finansal Rapor (CSV/Excel)</p>
                    <p class="text-slate-300 text-[11px] leading-relaxed">
                        Tüm aktif borçlarınızı, kredi kartı limit/borç/jest lira/avans durumlarını, gelir ve gider kalemlerinizi tek bir Excel dosyasında UTF-8 formatında indirir.
                    </p>
                </div>
            </div>

            <!-- Dönem Filtresi Hapları -->
            <div class="inline-flex rounded-2xl bg-gray-100 p-1 border border-gray-200 shadow-2xs overflow-x-auto no-scrollbar max-w-full text-xs font-bold">
                <button wire:click="setPeriod('this_month')" class="px-3 py-1.5 rounded-xl transition-all whitespace-nowrap {{ $period === 'this_month' ? 'bg-indigo-600 text-white shadow-xs' : 'text-gray-600 hover:text-gray-900' }}">
                    Bu Ay
                </button>
                <button wire:click="setPeriod('last_30')" class="px-3 py-1.5 rounded-xl transition-all whitespace-nowrap {{ $period === 'last_30' ? 'bg-indigo-600 text-white shadow-xs' : 'text-gray-600 hover:text-gray-900' }}">
                    Son 30 Gün
                </button>
                <button wire:click="setPeriod('last_month')" class="px-3 py-1.5 rounded-xl transition-all whitespace-nowrap {{ $period === 'last_month' ? 'bg-indigo-600 text-white shadow-xs' : 'text-gray-600 hover:text-gray-900' }}">
                    Geçen Ay
                </button>
                <button wire:click="setPeriod('last_90')" class="px-3 py-1.5 rounded-xl transition-all whitespace-nowrap {{ $period === 'last_90' ? 'bg-indigo-600 text-white shadow-xs' : 'text-gray-600 hover:text-gray-900' }}">
                    Son 3 Ay (Çeyrek)
                </button>
                <button wire:click="setPeriod('this_year')" class="px-3 py-1.5 rounded-xl transition-all whitespace-nowrap {{ $period === 'this_year' ? 'bg-indigo-600 text-white shadow-xs' : 'text-gray-600 hover:text-gray-900' }}">
                    Bu Yıl
                </button>
                <button wire:click="setPeriod('all')" class="px-3 py-1.5 rounded-xl transition-all whitespace-nowrap {{ $period === 'all' ? 'bg-indigo-600 text-white shadow-xs' : 'text-gray-600 hover:text-gray-900' }}">
                    Tümü
                </button>
            </div>
        </div>
    </div>


    <!-- 2. FİNANSAL SAĞLIK & İNTEL SKOR PANOSU -->
    <div class="relative rounded-3xl bg-gradient-to-br from-slate-950 via-indigo-950 to-slate-900 border border-indigo-500/30 p-6 sm:p-8 text-white shadow-2xl overflow-hidden">
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-indigo-500/15 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 space-y-6">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 border-b border-indigo-800/50 pb-5">
                <div class="flex items-center gap-4">
                    <!-- Skor Dairesi -->
                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-3xl {{ $healthScore >= 70 ? 'bg-emerald-500/20 border-emerald-400 text-emerald-400' : ($healthScore >= 45 ? 'bg-amber-500/20 border-amber-400 text-amber-400' : 'bg-red-500/20 border-red-400 text-red-400') }} border-2 flex flex-col items-center justify-center shrink-0 shadow-lg backdrop-blur-md">
                        <span class="text-xl sm:text-2xl font-black">{{ $healthScore }}</span>
                        <span class="text-[9px] font-black uppercase tracking-wider">/ 100</span>
                    </div>

                    <div class="space-y-1">
                        <span class="inline-flex items-center gap-1.5 px-3 py-0.5 rounded-full {{ $healthScore >= 70 ? 'bg-emerald-500/20 border-emerald-400/40 text-emerald-300' : ($healthScore >= 45 ? 'bg-amber-500/20 border-amber-400/40 text-amber-300' : 'bg-red-500/20 border-red-400/40 text-red-300') }} border text-[11px] font-black uppercase tracking-wider">
                            {{ $healthScore >= 70 ? '🟢 Finansal Durum: Güçlü' : ($healthScore >= 45 ? '🟡 Finansal Durum: Dengede' : '🔴 Finansal Durum: Riskli') }}
                        </span>
                        <h2 class="text-lg sm:text-xl font-black text-white">
                            Aylık Net Borç Kapatma Kapasiteniz: <span class="text-emerald-400">₺{{ number_format($netSavings, 2, ',', '.') }}</span>
                        </h2>
                        <p class="text-xs text-slate-300">
                            Gelirinizin %{{ $savingsRate }}'si harcamalardan serbest kalıyor. Mevcut tempo ile borçlarınız <strong>~{{ $estimatedPayoffMonths }} ayda</strong> sıfırlanabilir.
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-2 text-left lg:text-right bg-white/5 border border-white/10 p-3.5 rounded-2xl backdrop-blur-md">
                    <div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase">AYLIK FAİZ KAYBI</span>
                        <span class="text-base sm:text-lg font-black text-amber-400 block">₺{{ number_format($totalMonthlyInterest, 0, ',', '.') }}</span>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase">YILLIK FAİZ YÜKÜ</span>
                        <span class="text-base sm:text-lg font-black text-red-400 block">₺{{ number_format($totalAnnualInterest, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- 4'lü Hızlı Özet Şeridi -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 text-xs">
                <div class="p-3.5 bg-white/5 rounded-2xl border border-white/10">
                    <span class="text-slate-400 block text-[10px] font-bold uppercase">Dönem Geliri</span>
                    <span class="text-lg sm:text-xl font-black text-emerald-400 mt-0.5 block">₺{{ number_format($totalIncome, 0, ',', '.') }}</span>
                </div>
                <div class="p-3.5 bg-white/5 rounded-2xl border border-white/10">
                    <span class="text-slate-400 block text-[10px] font-bold uppercase">Dönem Gideri</span>
                    <span class="text-lg sm:text-xl font-black text-red-400 mt-0.5 block">₺{{ number_format($totalExpense, 0, ',', '.') }}</span>
                </div>
                <div class="p-3.5 bg-white/5 rounded-2xl border border-white/10">
                    <span class="text-slate-400 block text-[10px] font-bold uppercase">Toplam Borç</span>
                    <span class="text-lg sm:text-xl font-black text-white mt-0.5 block">₺{{ number_format($totalDebt, 0, ',', '.') }}</span>
                </div>
                <div class="p-3.5 bg-white/5 rounded-2xl border border-white/10">
                    <span class="text-slate-400 block text-[10px] font-bold uppercase">Borç / Gelir Kaldıracı</span>
                    <span class="text-lg sm:text-xl font-black text-indigo-300 mt-0.5 block">{{ $debtToIncomeRatio }}x Katı</span>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. RAPOR MODÜL SEKMELERİ -->
    <div class="flex items-center gap-2 overflow-x-auto no-scrollbar border-b border-gray-200 pb-2">
        <button wire:click="setTab('overview')" class="px-4 py-2 rounded-xl text-xs sm:text-sm font-black transition-all whitespace-nowrap flex items-center gap-2 {{ $activeTab === 'overview' ? 'bg-indigo-600 text-white shadow-md' : 'text-gray-600 hover:bg-gray-100' }}">
            <span>🌟</span>
            <span>360° Genel Kokpit</span>
        </button>
        <button wire:click="setTab('categories')" class="px-4 py-2 rounded-xl text-xs sm:text-sm font-black transition-all whitespace-nowrap flex items-center gap-2 {{ $activeTab === 'categories' ? 'bg-indigo-600 text-white shadow-md' : 'text-gray-600 hover:bg-gray-100' }}">
            <span>🛒</span>
            <span>Nereye Harcıyorum?</span>
        </button>
        <button wire:click="setTab('timing')" class="px-4 py-2 rounded-xl text-xs sm:text-sm font-black transition-all whitespace-nowrap flex items-center gap-2 {{ $activeTab === 'timing' ? 'bg-indigo-600 text-white shadow-md' : 'text-gray-600 hover:bg-gray-100' }}">
            <span>⏳</span>
            <span>Ne Zaman Harcıyorum?</span>
        </button>
        <button wire:click="setTab('banks')" class="px-4 py-2 rounded-xl text-xs sm:text-sm font-black transition-all whitespace-nowrap flex items-center gap-2 {{ $activeTab === 'banks' ? 'bg-indigo-600 text-white shadow-md' : 'text-gray-600 hover:bg-gray-100' }}">
            <span>🏛️</span>
            <span>Bankalar & Faiz Yükü</span>
        </button>
        <button wire:click="setTab('limits')" class="px-4 py-2 rounded-xl text-xs sm:text-sm font-black transition-all whitespace-nowrap flex items-center gap-2 {{ $activeTab === 'limits' ? 'bg-indigo-600 text-white shadow-md' : 'text-gray-600 hover:bg-gray-100' }}">
            <span>💳</span>
            <span>Kart & Limit Risk Matrisi</span>
        </button>
    </div>

    <!-- 4. MODÜL İÇERİKLERİ -->

    <!-- MODÜL 1: 360° GENEL KOKPİT -->
    @if ($activeTab === 'overview')
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Sol: Gelir vs Gider Bütçe Akışı -->
            <div class="bg-white rounded-3xl p-6 border border-gray-200/90 shadow-sm space-y-4">
                <h3 class="font-black text-gray-900 text-base flex items-center gap-2 border-b border-gray-100 pb-3">
                    <span>⚖️</span>
                    <span>Nakit Giriş & Çıkış Dengesi</span>
                </h3>

                <div class="space-y-4 text-sm">
                    <div class="flex items-center justify-between p-3.5 bg-emerald-50/70 border border-emerald-100 rounded-2xl">
                        <div class="flex items-center gap-3">
                            <span class="text-xl">🟢</span>
                            <div>
                                <span class="font-bold text-gray-900 block">Dönem Toplam Gelirleri</span>
                                <span class="text-xs text-gray-500">Maaş, prim, ek gelirler</span>
                            </div>
                        </div>
                        <span class="text-base font-black text-emerald-700">₺{{ number_format($totalIncome, 2, ',', '.') }}</span>
                    </div>

                    <div class="flex items-center justify-between p-3.5 bg-red-50/70 border border-red-100 rounded-2xl">
                        <div class="flex items-center gap-3">
                            <span class="text-xl">🔴</span>
                            <div>
                                <span class="font-bold text-gray-900 block">Dönem Toplam Giderleri</span>
                                <span class="text-xs text-gray-500">Kira, faturalar, yaşam, kart harcamaları</span>
                            </div>
                        </div>
                        <span class="text-base font-black text-red-700">-₺{{ number_format($totalExpense, 2, ',', '.') }}</span>
                    </div>

                    <div class="flex items-center justify-between p-3.5 bg-indigo-50/70 border border-indigo-100 rounded-2xl">
                        <div class="flex items-center gap-3">
                            <span class="text-xl">✨</span>
                            <div>
                                <span class="font-bold text-gray-900 block">Borca Ayrılan Net Nakit</span>
                                <span class="text-xs text-gray-500">Gelir - Gider Farkı</span>
                            </div>
                        </div>
                        <span class="text-base font-black text-indigo-700">₺{{ number_format($netSavings, 2, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Sağ: En Büyük Harcama Kaçakları -->
            <div class="bg-white rounded-3xl p-6 border border-gray-200/90 shadow-sm space-y-4">
                <h3 class="font-black text-gray-900 text-base flex items-center gap-2 border-b border-gray-100 pb-3">
                    <span>🚨</span>
                    <span>En Çok Para Giden İlk 3 Kategori</span>
                </h3>

                <div class="space-y-3">
                    @forelse ($categoryBreakdown->take(3) as $cat)
                        <div class="p-3 bg-gray-50 rounded-2xl border border-gray-100 space-y-2">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span>{{ $cat['icon'] }}</span>
                                    <span class="font-bold text-sm text-gray-900">{{ $cat['name'] }}</span>
                                </div>
                                <div class="text-right">
                                    <span class="font-black text-sm text-gray-900">₺{{ number_format($cat['amount'], 2, ',', '.') }}</span>
                                    <span class="text-xs font-bold text-indigo-600 block">%{{ $cat['percentage'] }}</span>
                                </div>
                            </div>
                            <div class="w-full h-1.5 bg-gray-200 rounded-full overflow-hidden">
                                <div class="h-full bg-indigo-600 rounded-full" style="width: {{ $cat['percentage'] }}%;"></div>
                            </div>
                        </div>
                    @empty
                        <div class="py-8 text-center text-xs text-gray-400">Harcama kaydı bulunamadı.</div>
                    @endforelse
                </div>
            </div>
        </div>

    <!-- MODÜL 2: NEREYE HARCIYORUM? (KATEGORİLER) -->
    @elseif ($activeTab === 'categories')
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-200/90 shadow-sm space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-gray-100 pb-4">
                <div>
                    <h3 class="text-lg font-black text-gray-900 flex items-center gap-2">
                        <span>🛒</span>
                        <span>Kategori Bazlı Harcama Dağılımı</span>
                    </h3>
                    <p class="text-xs text-gray-500">Paranızın yüzde kaçı nereye akıyor? En büyük bütçe tüketim kalemleriniz</p>
                </div>
                <div class="text-right bg-gray-50 px-4 py-2 rounded-2xl border border-gray-100">
                    <span class="text-xs font-bold text-gray-500">Kategori Toplamı:</span>
                    <span class="text-sm font-black text-red-600 ml-1">₺{{ number_format($totalExpense, 2, ',', '.') }}</span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse ($categoryBreakdown as $cat)
                    <div class="p-4 rounded-2xl border border-gray-100 bg-gray-50/50 space-y-3 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <span class="w-10 h-10 rounded-xl flex items-center justify-center text-white text-base font-bold shadow-xs" style="background-color: {{ $cat['color'] }};">
                                    {{ $cat['icon'] }}
                                </span>
                                <div>
                                    <h4 class="font-bold text-sm text-gray-900">{{ $cat['name'] }}</h4>
                                    <span class="text-xs text-gray-500">{{ $cat['count'] }} İşlem · Ort. ₺{{ number_format($cat['avg'], 2, ',', '.') }}</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-base font-black text-gray-900 block">₺{{ number_format($cat['amount'], 2, ',', '.') }}</span>
                                <span class="text-xs font-bold px-2 py-0.5 rounded-full bg-indigo-100 text-indigo-800">
                                    %{{ $cat['percentage'] }}
                                </span>
                            </div>
                        </div>

                        <!-- Progress Bar -->
                        <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-full rounded-full transition-all duration-500" style="width: {{ $cat['percentage'] }}%; background-color: {{ $cat['color'] }};"></div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-2 py-12 text-center text-xs text-gray-400">
                        Bu döneme ait harcama kaydı bulunamadı.
                    </div>
                @endforelse
            </div>
        </div>

    <!-- MODÜL 3: NE ZAMAN HARCIYORUM? (ZAMAN ANALİZİ) -->
    @elseif ($activeTab === 'timing')
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- 1. Hafta İçi vs Hafta Sonu -->
            <div class="bg-white rounded-3xl p-6 sm:p-7 border border-gray-200/90 shadow-sm space-y-5">
                <div class="border-b border-gray-100 pb-3">
                    <h3 class="font-black text-gray-900 text-base flex items-center gap-2">
                        <span>📅</span>
                        <span>Hafta İçi vs Hafta Sonu Harcama Yoğunluğu</span>
                    </h3>
                    <p class="text-xs text-gray-500">Hafta sonu dışarıda yemek ve eğlence harcamaları bütçenizi ne kadar zorluyor?</p>
                </div>

                <div class="space-y-4">
                    <div class="p-4 rounded-2xl bg-blue-50/70 border border-blue-100 space-y-2">
                        <div class="flex justify-between items-center text-xs">
                            <span class="font-bold text-blue-950">💼 Hafta İçi (Pazartesi - Cuma)</span>
                            <span class="font-black text-blue-800 text-sm">₺{{ number_format($timingAnalysis['weekday_total'], 2, ',', '.') }} (%{{ $timingAnalysis['weekday_percent'] }})</span>
                        </div>
                        <div class="w-full h-2.5 bg-blue-200 rounded-full overflow-hidden">
                            <div class="h-full bg-blue-600 rounded-full" style="width: {{ $timingAnalysis['weekday_percent'] }}%;"></div>
                        </div>
                    </div>

                    <div class="p-4 rounded-2xl bg-amber-50/70 border border-amber-100 space-y-2">
                        <div class="flex justify-between items-center text-xs">
                            <span class="font-bold text-amber-950">🎉 Hafta Sonu (Cumartesi - Pazar)</span>
                            <span class="font-black text-amber-800 text-sm">₺{{ number_format($timingAnalysis['weekend_total'], 2, ',', '.') }} (%{{ $timingAnalysis['weekend_percent'] }})</span>
                        </div>
                        <div class="w-full h-2.5 bg-amber-200 rounded-full overflow-hidden">
                            <div class="h-full bg-amber-600 rounded-full" style="width: {{ $timingAnalysis['weekend_percent'] }}%;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. Ayın 3 Evresi -->
            <div class="bg-white rounded-3xl p-6 sm:p-7 border border-gray-200/90 shadow-sm space-y-5">
                <div class="border-b border-gray-100 pb-3">
                    <h3 class="font-black text-gray-900 text-base flex items-center gap-2">
                        <span>🗓️</span>
                        <span>Ayın Hangi Evresinde Para Tükeniyor?</span>
                    </h3>
                    <p class="text-xs text-gray-500">Maaşın ilk günleri mi yoksa ay sonu kart kullanımı mı yüksek?</p>
                </div>

                <div class="space-y-3 text-xs">
                    <!-- 1-10 -->
                    <div class="p-3.5 bg-gray-50 rounded-2xl border border-gray-100 space-y-1.5">
                        <div class="flex justify-between font-bold text-gray-800">
                            <span>1 - 10 Arası (Maaş, Kira & Faturalar)</span>
                            <span class="font-black text-indigo-700">₺{{ number_format($timingAnalysis['p1_10'], 2, ',', '.') }} (%{{ $timingAnalysis['p1_10_percent'] }})</span>
                        </div>
                        <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-full bg-indigo-600 rounded-full" style="width: {{ $timingAnalysis['p1_10_percent'] }}%;"></div>
                        </div>
                    </div>

                    <!-- 11-20 -->
                    <div class="p-3.5 bg-gray-50 rounded-2xl border border-gray-100 space-y-1.5">
                        <div class="flex justify-between font-bold text-gray-800">
                            <span>11 - 20 Arası (Standart Yaşam & Market)</span>
                            <span class="font-black text-indigo-700">₺{{ number_format($timingAnalysis['p11_20'], 2, ',', '.') }} (%{{ $timingAnalysis['p11_20_percent'] }})</span>
                        </div>
                        <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-full bg-indigo-600 rounded-full" style="width: {{ $timingAnalysis['p11_20_percent'] }}%;"></div>
                        </div>
                    </div>

                    <!-- 21-31 -->
                    <div class="p-3.5 bg-gray-50 rounded-2xl border border-gray-100 space-y-1.5">
                        <div class="flex justify-between font-bold text-gray-800">
                            <span>21 - 31 Arası (Ay Sonu Kapanış & Kart Yükü)</span>
                            <span class="font-black text-indigo-700">₺{{ number_format($timingAnalysis['p21_31'], 2, ',', '.') }} (%{{ $timingAnalysis['p21_31_percent'] }})</span>
                        </div>
                        <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-full bg-indigo-600 rounded-full" style="width: {{ $timingAnalysis['p21_31_percent'] }}%;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <!-- MODÜL 4: BANKALAR & FAİZ YÜKÜ -->
    @elseif ($activeTab === 'banks')
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-200/90 shadow-sm space-y-6">
            <div class="border-b border-gray-100 pb-3">
                <h3 class="text-lg font-black text-gray-900 flex items-center gap-2">
                    <span>🏛️</span>
                    <span>Banka Bazlı Borç & Yıllık Faiz Maliyeti Tablosu</span>
                </h3>
                <p class="text-xs text-gray-500">Hangi bankaya ne kadar borcunuz var ve her ay ne kadar faiz parası ödüyorsunuz?</p>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50 text-gray-500 font-bold text-xs text-left">
                        <tr>
                            <th class="px-6 py-3.5">Banka</th>
                            <th class="px-6 py-3.5">Toplam Borç</th>
                            <th class="px-6 py-3.5">Borç Payı (%)</th>
                            <th class="px-6 py-3.5">Ortalama Faiz</th>
                            <th class="px-6 py-3.5">Aylık Faiz Maliyeti</th>
                            <th class="px-6 py-3.5 text-right text-red-600">Yıllık Faiz Yükü</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse ($bankAnalysis as $b)
                            <tr class="hover:bg-gray-50/70 transition-colors">
                                <td class="px-6 py-4 font-bold text-gray-900 flex items-center gap-3">
                                    <span class="w-8 h-8 rounded-lg flex items-center justify-center text-white text-xs font-black shrink-0 shadow-xs" style="background-color: {{ $b['bank_color'] }};">
                                        {{ mb_substr($b['bank_name'], 0, 2) }}
                                    </span>
                                    <span>{{ $b['bank_name'] }}</span>
                                </td>
                                <td class="px-6 py-4 font-bold text-gray-900">
                                    ₺{{ number_format($b['total_debt'], 2, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-xs font-bold text-indigo-600">
                                    %{{ $b['debt_share'] }}
                                </td>
                                <td class="px-6 py-4 text-gray-600 font-semibold">
                                    %{{ number_format($b['avg_interest'], 2) }}
                                </td>
                                <td class="px-6 py-4 text-amber-700 font-bold">
                                    ₺{{ number_format($b['monthly_interest_cost'], 2, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 font-black text-right text-red-600">
                                    ₺{{ number_format($b['annual_interest_cost'], 2, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-400">Banka borç kaydı bulunamadı.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    <!-- MODÜL 5: KART & LİMİT RİSK MATRİSİ -->
    @elseif ($activeTab === 'limits')
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- 1. Kredi Kartı Limitleri -->
            <div class="bg-white rounded-3xl p-6 border border-gray-200/90 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <h4 class="font-black text-gray-900 text-sm flex items-center gap-2">
                        <span>💳</span>
                        <span>Kredi Kartı Limitleri</span>
                    </h4>
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-black {{ $limitAnalysis['card_utilization'] > 80 ? 'bg-red-100 text-red-800' : 'bg-indigo-100 text-indigo-800' }}">
                        %{{ $limitAnalysis['card_utilization'] }} Dolu
                    </span>
                </div>

                <div class="space-y-3 text-xs">
                    <div class="flex justify-between text-gray-600">
                        <span>Toplam Kart Limiti:</span>
                        <span class="font-bold text-gray-900">₺{{ number_format($limitAnalysis['card_limit'], 2, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Kullanılan Bakiye:</span>
                        <span class="font-black text-red-600">₺{{ number_format($limitAnalysis['card_debt'], 2, ',', '.') }}</span>
                    </div>
                    <div class="w-full h-2 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full {{ $limitAnalysis['card_utilization'] > 80 ? 'bg-red-600' : 'bg-indigo-600' }} rounded-full" style="width: {{ $limitAnalysis['card_utilization'] }}%;"></div>
                    </div>
                </div>
            </div>

            <!-- 2. KMH / Eksi Hesap Limitleri -->
            <div class="bg-white rounded-3xl p-6 border border-gray-200/90 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <h4 class="font-black text-gray-900 text-sm flex items-center gap-2">
                        <span>⚡</span>
                        <span>KMH / Eksi Bakiye</span>
                    </h4>
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-black {{ $limitAnalysis['kmh_utilization'] > 80 ? 'bg-red-100 text-red-800' : 'bg-indigo-100 text-indigo-800' }}">
                        %{{ $limitAnalysis['kmh_utilization'] }} Dolu
                    </span>
                </div>

                <div class="space-y-3 text-xs">
                    <div class="flex justify-between text-gray-600">
                        <span>Toplam KMH Limiti:</span>
                        <span class="font-bold text-gray-900">₺{{ number_format($limitAnalysis['kmh_limit'], 2, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Kullanılan KMH:</span>
                        <span class="font-black text-red-600">₺{{ number_format($limitAnalysis['kmh_used'], 2, ',', '.') }}</span>
                    </div>
                    <div class="w-full h-2 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full {{ $limitAnalysis['kmh_utilization'] > 80 ? 'bg-red-600' : 'bg-indigo-600' }} rounded-full" style="width: {{ $limitAnalysis['kmh_utilization'] }}%;"></div>
                    </div>
                </div>
            </div>

            <!-- 3. Toplam Finansal Kaldıraç -->
            <div class="bg-white rounded-3xl p-6 border border-gray-200/90 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <h4 class="font-black text-gray-900 text-sm flex items-center gap-2">
                        <span>🛡️</span>
                        <span>Genel Limit Yoğunluğu</span>
                    </h4>
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-black bg-indigo-100 text-indigo-800">
                        %{{ $limitAnalysis['total_utilization'] }} Toplam
                    </span>
                </div>

                <div class="space-y-3 text-xs">
                    <div class="flex justify-between text-gray-600">
                        <span>Tüm Açık Limitler:</span>
                        <span class="font-bold text-gray-900">₺{{ number_format($limitAnalysis['total_limit'], 2, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Toplam Borç Yükü:</span>
                        <span class="font-black text-red-600">₺{{ number_format($limitAnalysis['total_used'], 2, ',', '.') }}</span>
                    </div>
                    <div class="w-full h-2 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-indigo-600 rounded-full" style="width: {{ $limitAnalysis['total_utilization'] }}%;"></div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- 5. SON ÖDEME GEÇMİŞİ (PAYMENTS_LOG) -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-200/90 shadow-sm space-y-4">
        <h3 class="font-black text-gray-900 text-base flex items-center gap-2 border-b border-gray-100 pb-3">
            <span>📜</span>
            <span>Son Gerçekleşen Ödeme Geçmişi (MySQL Kayıtları)</span>
        </h3>
        <div class="divide-y divide-gray-100">
            @forelse ($paymentLogs as $log)
                <div class="py-3 flex items-center justify-between">
                    <div>
                        <span class="font-bold text-sm text-gray-900 block">{{ $log->note ?: 'Borç Ödemesi' }}</span>
                        <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($log->paid_at)->format('d.m.Y') }} · {{ $log->method === 'auto' ? 'Otomatik İşlem' : 'Manuel İşlem' }}</span>
                    </div>
                    <span class="text-base font-black text-emerald-600">₺{{ number_format($log->amount, 2, ',', '.') }}</span>
                </div>
            @empty
                <div class="py-6 text-center text-xs text-gray-400">Henüz kayıtlı ödeme geçmişi yok.</div>
            @endforelse
        </div>
    </div>
</div>
