<div class="py-1 sm:py-6 px-3 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-gray-900 tracking-tight">🎯 Borç Kurtarma & Ödeme Planı</h1>
            <p class="text-sm text-gray-600">Matematiksel Çığ (Avalanche) ve Psikolojik Kartopu (Snowball) planlama motoru</p>
        </div>
        <button wire:click="$toggle('isCreatingPlan')" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm rounded-xl shadow-sm transition-colors">
            {{ $isCreatingPlan ? 'Planı Görüntüle' : '+ Yeni Plan Simülasyonu Yap' }}
        </button>
    </div>

    @if (session()->has('message'))
        <div class="p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl text-sm font-medium">
            ✓ {{ session('message') }}
        </div>
    @endif

    <!-- STRATEJİ KARŞILAŞTIRMA KARTI (ÇIĞ vs KARTOPU) -->
    <div class="bg-gradient-to-br from-indigo-950 via-slate-900 to-indigo-900 text-white p-6 rounded-3xl shadow-xl space-y-4">
        <div class="flex items-center gap-2 border-b border-indigo-800/60 pb-3">
            <span class="text-xl">⚖️</span>
            <h3 class="font-bold text-base">Strateji Karşılaştırma & Faiz Tasarruf Analizi</h3>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 text-sm">
            <div class="p-4 bg-white/10 rounded-2xl border border-white/10 space-y-1">
                <span class="text-xs font-bold text-indigo-300 block">ÇIĞ (AVALANCHE) YÖNTEMİ</span>
                <span class="text-xl font-black text-white">{{ $comparison['avalanche']['months'] ?? 0 }} Ayda Biter</span>
                <p class="text-xs text-slate-300">Toplam Ödenecek Faiz: ₺{{ number_format($comparison['avalanche']['total_interest'] ?? 0, 0, ',', '.') }}</p>
            </div>

            <div class="p-4 bg-white/10 rounded-2xl border border-white/10 space-y-1">
                <span class="text-xs font-bold text-amber-300 block">KARTOPU (SNOWBALL) YÖNTEMİ</span>
                <span class="text-xl font-black text-white">{{ $comparison['snowball']['months'] ?? 0 }} Ayda Biter</span>
                <p class="text-xs text-slate-300">Toplam Ödenecek Faiz: ₺{{ number_format($comparison['snowball']['total_interest'] ?? 0, 0, ',', '.') }}</p>
            </div>

            <div class="p-4 bg-emerald-500/20 rounded-2xl border border-emerald-400/30 space-y-1 sm:col-span-2 lg:col-span-1">
                <span class="text-xs font-bold text-emerald-300 block">ÇIĞ İLE CEPTE KALAN KAZANÇ</span>
                <span class="text-xl font-black text-emerald-400">₺{{ number_format($comparison['savings_amount'] ?? 0, 0, ',', '.') }} Faiz Tasarrufu</span>
                <p class="text-xs text-emerald-200">En yüksek faizli KMH ve Kartlara odaklanarak kazanılır.</p>
            </div>
        </div>
    </div>

    @if ($isCreatingPlan)
        <!-- YENİ PLAN SİHİRBAZI -->
        <div class="bg-white p-6 sm:p-8 rounded-2xl border border-gray-100 shadow-sm space-y-6">
            <h2 class="text-xl font-black text-gray-900 border-b border-gray-100 pb-3">Yeni Ödeme Planı Ayarları</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Plan Adı</label>
                    <input type="text" wire:model="planName" class="w-full rounded-xl border-gray-300 text-sm font-semibold">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Borçlara Aylık Ayrılacak Toplam Bütçe (TL)</label>
                    <input type="number" step="100" wire:model.live="monthlyBudget" class="w-full rounded-xl border-gray-300 text-sm font-bold text-indigo-600">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-2">Uygulamak İstediğiniz Strateji</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <label class="p-4 border-2 rounded-2xl cursor-pointer transition-all flex items-start gap-3 {{ $strategy === 'avalanche' ? 'border-indigo-600 bg-indigo-50/40 ring-2 ring-indigo-500' : 'border-gray-200' }}">
                        <input type="radio" wire:model.live="strategy" value="avalanche" class="mt-1 text-indigo-600 focus:ring-indigo-500">
                        <div>
                            <span class="font-bold text-gray-900 text-sm block">🏔️ Çığ Stratejisi (Matematiksel En Kârlı)</span>
                            <span class="text-xs text-gray-600">En yüksek faiz oranına sahip KMH ve kart borçlarına öncelik verilir. Toplam faiz yükünüzü minimize eder.</span>
                        </div>
                    </label>

                    <label class="p-4 border-2 rounded-2xl cursor-pointer transition-all flex items-start gap-3 {{ $strategy === 'snowball' ? 'border-indigo-600 bg-indigo-50/40 ring-2 ring-indigo-500' : 'border-gray-200' }}">
                        <input type="radio" wire:model.live="strategy" value="snowball" class="mt-1 text-indigo-600 focus:ring-indigo-500">
                        <div>
                            <span class="font-bold text-gray-900 text-sm block">⛄ Kartopu Stratejisi (Psikolojik En Rahat)</span>
                            <span class="text-xs text-gray-600">Tutar olarak en küçük borçtan başlanarak hızla borç kalemleri sıfırlanır. Hızlı moral ve motivasyon sağlar.</span>
                        </div>
                    </label>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <button wire:click="$set('isCreatingPlan', false)" class="px-5 py-2.5 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl">İptal</button>
                <button wire:click="generateNewPlan" class="px-6 py-2.5 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-md">
                    Planı Oluştur ve Aktifleştir →
                </button>
            </div>
        </div>
    @else
        <!-- AKTİF PLAN ZAMAN ÇİZELGESİ -->
        @if ($activePlan && count($monthlyGroups) > 0)
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-sm space-y-6">
                <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                    <div>
                        <h2 class="text-xl font-black text-gray-900">{{ $activePlan->name }}</h2>
                        <span class="text-xs font-semibold text-indigo-600">
                            Strateji: {{ $activePlan->strategy === 'avalanche' ? 'Çığ (En Yüksek Faiz Öncelikli)' : 'Kartopu (En Küçük Borç Öncelikli)' }} · Aylık Bütçe: ₺{{ number_format($activePlan->monthly_budget, 2, ',', '.') }}
                        </span>
                    </div>
                </div>

                <div class="space-y-6">
                    @foreach ($monthlyGroups as $month => $items)
                        <div class="border border-gray-200 rounded-2xl overflow-hidden">
                            <div class="bg-gray-50 px-5 py-3 border-b border-gray-200 flex items-center justify-between">
                                <span class="font-bold text-gray-900 text-sm">🗓️ {{ \Carbon\Carbon::parse($month . '-01')->translatedFormat('F Y') }}</span>
                                <span class="text-xs font-bold text-gray-600">Ay Toplamı: ₺{{ number_format($items->sum('allocated_amount'), 2, ',', '.') }}</span>
                            </div>

                            <div class="divide-y divide-gray-100 p-2">
                                @foreach ($items as $item)
                                    <div class="p-3 flex items-center justify-between gap-4">
                                        <div class="flex items-center gap-3">
                                            <span class="w-8 h-8 rounded-lg flex items-center justify-center text-white text-xs font-bold shrink-0" style="background-color: {{ $item->debt?->bank?->color ?? '#6366f1' }}">
                                                {{ mb_substr($item->debt?->bank?->name ?? 'B', 0, 2) }}
                                            </span>
                                            <div>
                                                <span class="font-bold text-sm text-gray-900 block">{{ $item->debt?->title ?? 'Borç' }}</span>
                                                <span class="text-xs text-gray-500">{{ $item->debt?->bank?->name }} · Faiz: %{{ $item->debt?->interest_rate }}</span>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-4">
                                            <span class="font-black text-sm text-gray-900">₺{{ number_format($item->allocated_amount, 2, ',', '.') }}</span>
                                            @if ($item->status === 'paid')
                                                <span class="px-3 py-1 bg-green-100 text-green-800 font-bold text-xs rounded-lg">Ödendi ✓</span>
                                            @else
                                                <button wire:click="markAsPaid({{ $item->id }})" class="px-3 py-1 bg-indigo-50 text-indigo-700 hover:bg-indigo-600 hover:text-white font-bold text-xs rounded-lg transition-colors">
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
            <div class="bg-white rounded-3xl p-12 text-center border border-gray-100 shadow-sm space-y-4">
                <span class="text-4xl block">📋</span>
                <h3 class="text-lg font-bold text-gray-900">Henüz Oluşturulmuş Bir Ödeme Planınız Yok</h3>
                <p class="text-sm text-gray-500 max-w-md mx-auto">Borçlarınızı matematiksel olarak en hızlı ve en az faizle kapatmak için hemen simülasyonu başlatın.</p>
                <button wire:click="$set('isCreatingPlan', true)" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm rounded-xl shadow-sm">
                    İlk Ödeme Planımı Oluştur →
                </button>
            </div>
        @endif
    @endif
</div>
