<div class="py-2 sm:py-6 px-3 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-6">
    <!-- 1. Header & Aksiyonlar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-gray-900 tracking-tight flex items-center gap-2">
                <span>🎯</span>
                <span>Borç Kurtarma & Stratejik Ödeme Planı</span>
            </h1>
            <p class="text-sm text-gray-600">Matematiksel Çığ (Avalanche), Psikolojik Kartopu (Snowball) ve 90 Gün Yasal Takip Kalkanı Simülatörü</p>
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
                        <span>🎯</span>
                        <span>Ödeme Planı Excel Raporu</span>
                    </div>
                    <p class="text-[11px] text-slate-300 leading-relaxed">
                        Uyguladığınız borç kurtarma stratejisinin (Çığ veya Kartopu) tüm aylar boyunca hangi bankaya ne kadar asgari ve ekstra ödeme yapılması gerektiğini listeleyen <strong>eylem planı Excel tablosunu</strong> indirir.
                    </p>
                    <span class="block mt-2 text-[10px] font-bold text-emerald-400">✓ Excel & Google Sheets Uyumlu</span>
                </div>
            </div>

            <button wire:click="$toggle('isCreatingPlan')" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white font-black text-xs sm:text-sm rounded-xl shadow-md transition-all flex items-center gap-2">
                <span>{{ $isCreatingPlan ? '← Planı & Yol Haritasını Görüntüle' : '+ Yeni Plan Simülasyonu Başlat' }}</span>
            </button>
        </div>
    </div>


    @if (session()->has('message'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm font-bold flex items-center gap-2 shadow-xs">
            <span>✓</span>
            <span>{{ session('message') }}</span>
        </div>
    @endif

    <!-- 2. FİNANSAL ÖZGÜRLÜK & KURTULUŞ SKOR PANOSU -->
    <div class="relative rounded-3xl bg-gradient-to-br from-slate-950 via-indigo-950 to-slate-900 border border-indigo-500/30 p-6 sm:p-8 text-white shadow-2xl overflow-hidden">
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-indigo-500/15 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 space-y-6">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 border-b border-indigo-800/50 pb-5">
                <div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500/20 border border-emerald-400/40 text-emerald-300 text-[11px] font-black uppercase tracking-wider mb-2">
                        ✨ Matematiksel Çıkış Rotası
                    </span>
                    <h2 class="text-xl sm:text-2xl font-black text-white">
                        Tüm Borçlarınız <span class="bg-gradient-to-r from-emerald-300 via-sky-300 to-indigo-300 bg-clip-text text-transparent">{{ $freedomDate }}</span> Tarihinde Tamamen Bitiyor!
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-300 mt-1 max-w-2xl">
                        Aylık ₺{{ number_format($monthlyBudget, 0, ',', '.') }} bütçe ile en yüksek faizli borçları sırayla yok ederek <strong>{{ $freedomMonths }} ay sonra</strong> sıfır borçlu özgür bir hayata kavuşuyorsunuz.
                    </p>
                </div>

                <div class="text-left lg:text-right bg-white/5 border border-white/10 p-4 rounded-2xl backdrop-blur-md">
                    <span class="text-[10px] font-bold text-slate-400 block uppercase tracking-wider">TOPLAM FAİZ KAZANCI</span>
                    <span class="text-2xl font-black text-emerald-400 block">₺{{ number_format($comparison['savings_amount'] ?? 0, 0, ',', '.') }}</span>
                    <span class="text-[11px] text-emerald-200 font-semibold">Çığ yöntemiyle cebinizde kalan net tasarruf</span>
                </div>
            </div>

            <!-- 4'lü İstatistik Şeridi -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 text-xs">
                <div class="p-3.5 bg-white/5 rounded-2xl border border-white/10">
                    <span class="text-slate-400 block text-[10px] font-bold uppercase">Toplam Kapatılacak Borç</span>
                    <span class="text-lg sm:text-xl font-black text-white mt-0.5 block">₺{{ number_format($totalDebtSum, 0, ',', '.') }}</span>
                </div>
                <div class="p-3.5 bg-white/5 rounded-2xl border border-white/10">
                    <span class="text-slate-400 block text-[10px] font-bold uppercase">Aylık Borç Ödeme Bütçesi</span>
                    <span class="text-lg sm:text-xl font-black text-indigo-300 mt-0.5 block">₺{{ number_format($monthlyBudget, 0, ',', '.') }}</span>
                </div>
                <div class="p-3.5 bg-white/5 rounded-2xl border border-white/10">
                    <span class="text-slate-400 block text-[10px] font-bold uppercase">Çığ ile Kurtulma Süresi</span>
                    <span class="text-lg sm:text-xl font-black text-emerald-300 mt-0.5 block">{{ $comparison['avalanche']['months'] ?? 0 }} Ay</span>
                </div>
                <div class="p-3.5 bg-white/5 rounded-2xl border border-white/10">
                    <span class="text-slate-400 block text-[10px] font-bold uppercase">Kartopu ile Kurtulma</span>
                    <span class="text-lg sm:text-xl font-black text-amber-300 mt-0.5 block">{{ $comparison['snowball']['months'] ?? 0 }} Ay</span>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. STRATEJİ KARŞILAŞTIRMA & EĞİTİCİ REHBER LABORATUVARI -->
    <div class="bg-white rounded-3xl border border-gray-200/90 p-5 sm:p-7 shadow-sm space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-gray-100 pb-4">
            <div>
                <h3 class="text-lg font-black text-gray-900 flex items-center gap-2">
                    <span>🧠</span>
                    <span>Stratejiler Nasıl Çalışır? Hangisini Seçmeliyim?</span>
                </h3>
                <p class="text-xs text-gray-500">Borç kapatırken kullanılan 3 altın metodun akılda kalıcı çalışma mantığı</p>
            </div>

            <!-- Strateji Sekmeleri -->
            <div class="inline-flex rounded-xl bg-gray-100 p-1 border border-gray-200 text-xs font-bold">
                <button wire:click="$set('activeStrategyTab', 'avalanche')" class="px-3 py-1.5 rounded-lg transition-all {{ $activeStrategyTab === 'avalanche' ? 'bg-indigo-600 text-white shadow-xs' : 'text-gray-600 hover:text-gray-900' }}">
                    🏔️ Çığ (En Kârlı)
                </button>
                <button wire:click="$set('activeStrategyTab', 'snowball')" class="px-3 py-1.5 rounded-lg transition-all {{ $activeStrategyTab === 'snowball' ? 'bg-indigo-600 text-white shadow-xs' : 'text-gray-600 hover:text-gray-900' }}">
                    ⛄ Kartopu (Motivasyon)
                </button>
                <button wire:click="$set('activeStrategyTab', 'hybrid')" class="px-3 py-1.5 rounded-lg transition-all {{ $activeStrategyTab === 'hybrid' ? 'bg-indigo-600 text-white shadow-xs' : 'text-gray-600 hover:text-gray-900' }}">
                    🛡️ 90 Gün Hibrit
                </button>
            </div>
        </div>

        <!-- Seçili Stratejinin Açıklama Kartı -->
        @if ($activeStrategyTab === 'avalanche')
            <div class="p-5 rounded-2xl bg-indigo-50/70 border border-indigo-100 flex flex-col md:flex-row items-start gap-4">
                <div class="w-12 h-12 rounded-2xl bg-indigo-600 text-white text-2xl flex items-center justify-center shrink-0 shadow-md">
                    🏔️
                </div>
                <div class="space-y-2 text-xs text-gray-700 leading-relaxed">
                    <h4 class="font-black text-indigo-950 text-sm">Çığ (Debt Avalanche) Yöntemi — Matematiksel En Kârlı Yol</h4>
                    <p>
                        <strong>Mantık:</strong> Tüm borçların asgari tutarları ödenir. Geriye kalan tüm bütçe <strong>en yüksek faiz oranına sahip borca (örneğin %5.00 faizli KMH veya %4.25 faizli kredi kartı)</strong> yatırılır.
                    </p>
                    <p class="text-indigo-900 font-semibold">
                        💡 <strong>Neden En İyisi?</strong> Bankalara ödeyeceğiniz toplam faiz yükünü en aza indirir. Kartopu yöntemine kıyasla tam <strong>₺{{ number_format($comparison['savings_amount'] ?? 0, 0, ',', '.') }} tasarruf</strong> sağlar.
                    </p>
                </div>
            </div>
        @elseif ($activeStrategyTab === 'snowball')
            <div class="p-5 rounded-2xl bg-amber-50/70 border border-amber-100 flex flex-col md:flex-row items-start gap-4">
                <div class="w-12 h-12 rounded-2xl bg-amber-600 text-white text-2xl flex items-center justify-center shrink-0 shadow-md">
                    ⛄
                </div>
                <div class="space-y-2 text-xs text-gray-700 leading-relaxed">
                    <h4 class="font-black text-amber-950 text-sm">Kartopu (Debt Snowball) Yöntemi — Psikolojik Moral & Hızlı Zafer</h4>
                    <p>
                        <strong>Mantık:</strong> Faiz oranına bakılmaksızın <strong>en küçük bakiyeli borçtan (örneğin ₺8.000'lik kart borcu)</strong> başlanır. O borç kapandıkça serbest kalan bütçe bir sonraki küçük borca eklenir.
                    </p>
                    <p class="text-amber-900 font-semibold">
                        💡 <strong>Neden Tercih Edilir?</strong> Borç adetlerini çok hızlı azaltır (5 borçtan 3'e düşürür). Kullanıcıya hızlı başarı hissi ve borçtan kurtulma motivasyonu aşılar.
                    </p>
                </div>
            </div>
        @else
            <div class="p-5 rounded-2xl bg-red-50/70 border border-red-100 flex flex-col md:flex-row items-start gap-4">
                <div class="w-12 h-12 rounded-2xl bg-red-600 text-white text-2xl flex items-center justify-center shrink-0 shadow-md">
                    🛡️
                </div>
                <div class="space-y-2 text-xs text-gray-700 leading-relaxed">
                    <h4 class="font-black text-red-950 text-sm">DVT 90 Gün Hibrit Kalkanı — Yasal Takip Acil Koruma</h4>
                    <p>
                        <strong>Mantık:</strong> Türkiye Bankacılık Mevzuatı'ndaki 90 gün kuralına göre <strong>yasal takibe girmesine en az gün kalan (65+ gün gecikmiş)</strong> borçları acil kırmızı kalkan altına alır.
                    </p>
                    <p class="text-red-900 font-semibold">
                        💡 <strong>Neden Hayati?</strong> İcra ve avukat masrafları (%25-30 ek yük) başlamadan önce borcu kurtarır, yasal risk sıfırlandığı anda otomatik olarak Çığ yöntemine geçer.
                    </p>
                </div>
            </div>
        @endif

        <!-- 4. BORÇ KAPATMA SIRALAMASI & HEDEF YOL HARİTASI (ROADMAP) -->
        <div class="space-y-4 pt-2">
            <h4 class="font-black text-gray-900 text-sm flex items-center gap-2">
                <span>🎯</span>
                <span>Borç Kapatma Sıralaması & Tahmini Sıfırlanma Ayları</span>
            </h4>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse ($roadmap as $step)
                    @php
                        $d = $step['debt'];
                        $bankColor = $d->bank?->color ?? '#6366f1';
                    @endphp

                    <div class="relative p-4 rounded-2xl border {{ $step['is_current_target'] ? 'border-indigo-600 ring-2 ring-indigo-500/30 bg-indigo-50/30' : 'border-gray-200 bg-white' }} shadow-xs flex flex-col justify-between space-y-3">
                        @if ($step['is_current_target'])
                            <div class="absolute -top-2.5 right-3 px-2.5 py-0.5 rounded-full text-[10px] font-black bg-indigo-600 text-white shadow-sm flex items-center gap-1">
                                <span>🎯</span>
                                <span>1. ÖNCELİKLİ HEDEF BORÇ</span>
                            </div>
                        @endif

                        <div class="flex items-center gap-3 pt-1">
                            <span class="w-8 h-8 rounded-xl font-black text-white text-xs flex items-center justify-center shrink-0 shadow-xs" style="background-color: {{ $bankColor }};">
                                {{ $step['order'] }}
                            </span>
                            <div class="min-w-0">
                                <span class="font-bold text-gray-900 text-sm block truncate">{{ $d->title }}</span>
                                <span class="text-[11px] text-gray-500">{{ $d->bank?->name ?? 'Banka' }} · Aylık Faiz: %{{ number_format($d->interest_rate, 2) }}</span>
                            </div>
                        </div>

                        <div class="p-2.5 bg-gray-50 rounded-xl border border-gray-100 flex items-baseline justify-between text-xs">
                            <div>
                                <span class="text-[10px] font-bold text-gray-400 block uppercase">KALAN BAKİYE</span>
                                <span class="text-sm font-black text-red-600">₺{{ number_format($d->remaining, 2, ',', '.') }}</span>
                            </div>
                            <div class="text-right">
                                <span class="text-[10px] font-bold text-gray-400 block uppercase">TAHMİNİ BİTİŞ</span>
                                <span class="text-xs font-black text-indigo-700">{{ $step['target_month'] }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-6 text-center text-gray-400 text-xs">
                        Aktif borç kaydı bulunamadı.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- 5. YENİ PLAN SİHİRBAZI VEYA AKTİF PLAN ÇİZELGESİ -->
    @if ($isCreatingPlan)
        <!-- YENİ PLAN OLUŞTURMA FORMU -->
        <div class="bg-white p-6 sm:p-8 rounded-3xl border border-gray-200/90 shadow-sm space-y-6">
            <div class="border-b border-gray-100 pb-3">
                <h2 class="text-xl font-black text-gray-900">Yeni Borç Kurtarma Planı Oluştur</h2>
                <p class="text-xs text-gray-500">Aylık ayırabileceğiniz bütçeyi girin, sistem sizin için her ayın ödeme tablosunu oluştursun</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Plan Başlığı</label>
                    <input type="text" wire:model="planName" class="w-full rounded-xl border-gray-300 text-sm font-semibold focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Aylık Borç Kapatma Bütçesi (TL)</label>
                    <input type="number" step="500" wire:model.live="monthlyBudget" class="w-full rounded-xl border-gray-300 text-sm font-black text-indigo-600 focus:ring-indigo-500 focus:border-indigo-500" placeholder="15000">
                    <span class="text-[11px] text-gray-500 mt-1 block">Gelir ve giderlerinizden kalan net tutara göre hesaplanır</span>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-2">Uygulanacak Strateji</label>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <label class="p-4 border-2 rounded-2xl cursor-pointer transition-all flex items-start gap-3 {{ $strategy === 'avalanche' ? 'border-indigo-600 bg-indigo-50/40 ring-2 ring-indigo-500' : 'border-gray-200 hover:border-gray-300' }}">
                        <input type="radio" wire:model.live="strategy" value="avalanche" class="mt-1 text-indigo-600 focus:ring-indigo-500">
                        <div>
                            <span class="font-bold text-gray-900 text-sm block">🏔️ Çığ (Avalanche)</span>
                            <span class="text-xs text-gray-600 mt-0.5 block">En yüksek faizli KMH ve kartlara odaklanır, maksimum para kurtarır.</span>
                        </div>
                    </label>

                    <label class="p-4 border-2 rounded-2xl cursor-pointer transition-all flex items-start gap-3 {{ $strategy === 'snowball' ? 'border-indigo-600 bg-indigo-50/40 ring-2 ring-indigo-500' : 'border-gray-200 hover:border-gray-300' }}">
                        <input type="radio" wire:model.live="strategy" value="snowball" class="mt-1 text-indigo-600 focus:ring-indigo-500">
                        <div>
                            <span class="font-bold text-gray-900 text-sm block">⛄ Kartopu (Snowball)</span>
                            <span class="text-xs text-gray-600 mt-0.5 block">En küçük bakiyeden başlar, hızlı borç adetlerini yok eder.</span>
                        </div>
                    </label>

                    <label class="p-4 border-2 rounded-2xl cursor-pointer transition-all flex items-start gap-3 {{ $strategy === 'hybrid' ? 'border-indigo-600 bg-indigo-50/40 ring-2 ring-indigo-500' : 'border-gray-200 hover:border-gray-300' }}">
                        <input type="radio" wire:model.live="strategy" value="hybrid" class="mt-1 text-indigo-600 focus:ring-indigo-500">
                        <div>
                            <span class="font-bold text-gray-900 text-sm block">🛡️ 90 Gün Hibrit</span>
                            <span class="text-xs text-gray-600 mt-0.5 block">Yasal takibe yakın borçları acil kurtarır, ardından çığa döner.</span>
                        </div>
                    </label>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-3 border-t border-gray-100">
                <button wire:click="$set('isCreatingPlan', false)" class="px-5 py-2.5 text-sm font-bold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">
                    İptal
                </button>
                <button wire:click="generateNewPlan" class="px-6 py-2.5 text-sm font-black text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-md transition-all active:scale-95">
                    Planı Oluştur & Aktifleştir →
                </button>
            </div>
        </div>
    @else
        <!-- AKTİF PLAN VE AYLIK ÖDEME DÖKÜMÜ -->
        @if ($activePlan && count($monthlyGroups) > 0)
            <div class="bg-white rounded-3xl p-5 sm:p-7 border border-gray-200/90 shadow-sm space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-gray-100 pb-4">
                    <div>
                        <div class="flex items-center gap-2">
                            <h2 class="text-lg sm:text-xl font-black text-gray-900">{{ $activePlan->name }}</h2>
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-black bg-emerald-100 text-emerald-800">
                                Aktif Plan
                            </span>
                        </div>
                        <p class="text-xs text-gray-500 mt-0.5">
                            Strateji: <strong>{{ $activePlan->strategy === 'avalanche' ? 'Çığ (En Yüksek Faiz Öncelikli)' : ($activePlan->strategy === 'snowball' ? 'Kartopu' : '90 Gün Hibrit') }}</strong> · Aylık Bütçe: <strong>₺{{ number_format($activePlan->monthly_budget, 2, ',', '.') }}</strong>
                        </p>
                    </div>

                    <!-- Plan İlerleme Çubuğu -->
                    <div class="w-full sm:w-64 space-y-1">
                        <div class="flex justify-between text-xs font-bold text-gray-700">
                            <span>Plan İlerlemesi</span>
                            <span class="text-indigo-600 font-black">%{{ $planProgressPercent }}</span>
                        </div>
                        <div class="w-full h-2 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-indigo-600 transition-all duration-500" style="width: {{ $planProgressPercent }}%;"></div>
                        </div>
                    </div>
                </div>

                <!-- Aylık Ödeme Kartları -->
                <div class="space-y-4">
                    @foreach ($monthlyGroups as $month => $items)
                        <div class="border border-gray-200 rounded-2xl overflow-hidden shadow-2xs">
                            <div class="bg-gray-50 px-5 py-3 border-b border-gray-200 flex items-center justify-between">
                                <span class="font-bold text-gray-900 text-sm flex items-center gap-2">
                                    <span>🗓️</span>
                                    <span>{{ \Carbon\Carbon::parse($month . '-01')->translatedFormat('F Y') }}</span>
                                </span>
                                <span class="text-xs font-bold text-gray-700">
                                    Ay Toplamı: <strong class="text-indigo-700">₺{{ number_format($items->sum('allocated_amount'), 2, ',', '.') }}</strong>
                                </span>
                            </div>

                            <div class="divide-y divide-gray-100 p-2">
                                @foreach ($items as $item)
                                    <div class="p-3 flex items-center justify-between gap-4 hover:bg-gray-50/60 rounded-xl transition-colors">
                                        <div class="flex items-center gap-3 min-w-0">
                                            <span class="w-8 h-8 rounded-lg flex items-center justify-center text-white text-xs font-black shrink-0 shadow-xs" style="background-color: {{ $item->debt?->bank?->color ?? '#6366f1' }}">
                                                {{ mb_substr($item->debt?->bank?->name ?? 'B', 0, 2) }}
                                            </span>
                                            <div class="min-w-0">
                                                <span class="font-bold text-sm text-gray-900 block truncate">{{ $item->debt?->title ?? 'Borç' }}</span>
                                                <span class="text-xs text-gray-500">{{ $item->debt?->bank?->name ?? 'Banka' }} · Faiz: %{{ $item->debt?->interest_rate }}</span>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-3 shrink-0">
                                            <span class="font-black text-sm text-gray-900">₺{{ number_format($item->allocated_amount, 2, ',', '.') }}</span>
                                            @if ($item->status === 'paid')
                                                <span class="px-3 py-1 bg-emerald-100 text-emerald-800 font-black text-xs rounded-xl flex items-center gap-1">
                                                    <span>✓</span>
                                                    <span>Ödendi</span>
                                                </span>
                                            @else
                                                <button wire:click="markAsPaid({{ $item->id }})" class="px-3 py-1 bg-indigo-50 hover:bg-indigo-600 hover:text-white text-indigo-700 font-bold text-xs rounded-xl border border-indigo-200 transition-all active:scale-95">
                                                    Ödendi İşaretle
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="bg-white rounded-3xl p-12 text-center border-2 border-dashed border-gray-200 space-y-3">
                <span class="text-4xl block">📋</span>
                <h3 class="text-lg font-bold text-gray-900">Henüz Oluşturulmuş Bir Ödeme Planınız Yok</h3>
                <p class="text-xs text-gray-500 max-w-md mx-auto">Borçlarınızı matematiksel olarak en hızlı ve en az faizle kapatmak için hemen simülasyonu başlatın.</p>
                <button wire:click="$set('isCreatingPlan', true)" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs sm:text-sm rounded-xl shadow-md transition-all">
                    İlk Ödeme Planımı Oluştur →
                </button>
            </div>
        @endif
    @endif
</div>
