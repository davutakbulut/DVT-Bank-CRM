<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-8">
    @if (session()->has('message'))
        <div class="p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl flex items-center justify-between shadow-sm">
            <span>✓ {{ session('message') }}</span>
        </div>
    @endif

    <!-- 1. ÜST 4 METRİK KARTI -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Toplam Borç -->
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm relative overflow-hidden">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-gray-500 tracking-wider">TOPLAM BORÇ YÜKÜ</span>
                <span class="w-8 h-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center font-bold text-sm">₺</span>
            </div>
            <div class="mt-3">
                <span class="text-3xl font-black text-red-600 tracking-tight">₺{{ number_format($riskSummary['total_remaining'], 2, ',', '.') }}</span>
                <p class="text-xs text-gray-500 mt-1">Kart, KMH ve Krediler toplamı</p>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-red-500"></div>
        </div>

        <!-- Bu Ayki Yükümlülük -->
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm relative overflow-hidden">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-gray-500 tracking-wider">BU AYKİ ASGARİ / TAKSİT</span>
                <span class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center font-bold text-sm">⚡</span>
            </div>
            <div class="mt-3">
                <span class="text-3xl font-black text-amber-600 tracking-tight">₺{{ number_format($riskSummary['total_monthly_commitment'], 2, ',', '.') }}</span>
                <p class="text-xs text-gray-500 mt-1">Gecikmeye düşmemek için gereken</p>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-amber-500"></div>
        </div>

        <!-- En Kritik Borç (90 Gün Yasal Takip Sayacı) -->
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm relative overflow-hidden {{ $riskSummary['days_to_legal_minimum'] <= 25 ? 'ring-2 ring-red-500/20' : '' }}">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-gray-500 tracking-wider">EN KRİTİK TAKİP SAYAÇ</span>
                <span class="w-8 h-8 rounded-lg {{ $riskSummary['days_to_legal_minimum'] <= 25 ? 'bg-red-100 text-red-700 animate-pulse' : 'bg-blue-50 text-blue-600' }} flex items-center justify-center font-bold text-sm">⏳</span>
            </div>
            <div class="mt-3">
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-black {{ $riskSummary['days_to_legal_minimum'] <= 25 ? 'text-red-700' : 'text-gray-900' }}">
                        {{ $riskSummary['days_to_legal_minimum'] }} Gün
                    </span>
                    <span class="text-xs font-bold {{ $riskSummary['days_to_legal_minimum'] <= 25 ? 'text-red-600' : 'text-gray-500' }}">Kaldı</span>
                </div>
                <p class="text-xs text-gray-600 mt-1 truncate">
                    {{ $riskSummary['most_critical_item']['bank'] ?? 'Banka' }}: {{ $riskSummary['most_critical_item']['title'] ?? 'Yok' }}
                </p>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 {{ $riskSummary['days_to_legal_minimum'] <= 25 ? 'bg-red-600' : 'bg-blue-500' }}"></div>
        </div>

        <!-- Borca Ayrılabilir Net Bütçe -->
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm relative overflow-hidden">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-gray-500 tracking-wider">BORCA AYRILABİLİR NET</span>
                <span class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-sm">📈</span>
            </div>
            <div class="mt-3">
                <span class="text-3xl font-black text-emerald-600 tracking-tight">₺{{ number_format($availableForDebt, 2, ',', '.') }}</span>
                <p class="text-xs text-gray-500 mt-1">Gelir (₺{{ number_format($totalMonthlyIncome,0,',','.') }}) - Sabit Gider (₺{{ number_format($totalMonthlyExpense,0,',','.') }})</p>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-emerald-500"></div>
        </div>
    </div>

    <!-- 2. AI GÜNLÜK ÖNERİ KARTI -->
    <div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 text-white rounded-2xl p-6 shadow-xl relative overflow-hidden">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-800 pb-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-indigo-500/20 border border-indigo-400/30 flex items-center justify-center text-xl">
                    🤖
                </div>
                <div>
                    <h3 class="font-bold text-base text-white">AI Finansal Koçunuzun Günlük Durum Özeti</h3>
                    <p class="text-xs text-slate-400">Groq / Gemini çoklu model mimarisiyle anlık hesaplandı</p>
                </div>
            </div>
            <a href="{{ route('ai.coach') }}" class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-bold bg-indigo-600 hover:bg-indigo-500 text-white transition-colors">
                AI ile Sohbet Et →
            </a>
        </div>

        <div class="mt-4 text-sm text-slate-200 leading-relaxed font-sans">
            @if ($latestAdvice)
                {!! nl2br(e($latestAdvice->content)) !!}
            @else
                <strong>Kriz Strateji Tavsiyesi:</strong> 90 günlük yasal takip süresine 22 gün kalan <em>Yapı Kredi</em> borcunuz için derhal banka yapılandırma servisi aranmalıdır. Kredi kartı ve KMH faizleri en yüksek borç grubunuz olduğundan, asgari ödemeleri köprü olarak kullanarak yapılandırılmamış KMH'ları taksitli ihtiyaç kredisine çevirmeyi talep edin.
            @endif
        </div>

        <div class="mt-4 pt-3 border-t border-slate-800/80 text-[11px] text-slate-400">
            ⚖️ <em>Bu öneriler bilgilendirme amaçlıdır; 6362 sayılı Kanun kapsamında yatırım/finansal danışmanlık değildir.</em>
        </div>
    </div>

    <!-- 3. ORTA ALAN: YAKLAŞAN ÖDEMELER VE GRAFİKLER -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Yaklaşan & Geciken Ödemeler Listesi (2 Kolon) -->
        <div class="lg:col-span-2 bg-white rounded-2xl p-6 border border-gray-100 shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                <div>
                    <h3 class="font-bold text-gray-900 text-lg">Öncelikli ve Yaklaşan Ödemeler</h3>
                    <p class="text-xs text-gray-500">Gecikme süresine ve vade tarihine göre sıralı</p>
                </div>
                <a href="{{ route('debts.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800">Tüm Borçları Gör →</a>
            </div>

            <div class="divide-y divide-gray-100">
                @forelse ($upcomingDebts as $debt)
                    @php
                        $daysLeft = max(0, 90 - $debt->days_overdue);
                    @endphp
                    <div class="py-3.5 flex items-center justify-between gap-4">
                        <div class="flex items-center gap-3 min-w-0">
                            <span class="w-9 h-9 rounded-xl flex items-center justify-center text-white text-xs font-bold shrink-0 shadow-sm" style="background-color: {{ $debt->bank?->color ?? '#6366f1' }}">
                                {{ mb_substr($debt->bank?->name ?? 'B', 0, 2) }}
                            </span>
                            <div class="min-w-0">
                                <h4 class="font-bold text-sm text-gray-900 truncate">{{ $debt->title }}</h4>
                                <div class="flex items-center gap-2 mt-0.5">
                                    <span class="text-xs text-gray-500">{{ $debt->bank?->name }}</span>
                                    @if ($debt->days_overdue > 0)
                                        <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-red-100 text-red-700">
                                            {{ $debt->days_overdue }} Gün Gecikmede
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 shrink-0">
                            <div class="text-right">
                                <span class="block font-black text-sm text-gray-900">₺{{ number_format($debt->remaining, 2, ',', '.') }}</span>
                                <span class="text-[11px] text-gray-500 font-medium">Takibe: {{ $daysLeft }} gün</span>
                            </div>
                            <button wire:click="openPaymentModal({{ $debt->id }})" class="px-3 py-1.5 bg-indigo-50 text-indigo-700 hover:bg-indigo-100 font-bold text-xs rounded-lg transition-colors">
                                Ödeme Kaydet
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="py-8 text-center text-gray-500 text-sm">
                        Kayıtlı aktif borç bulunmamaktadır.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Banka Dağılımı (1 Kolon) -->
        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm space-y-4">
            <div class="border-b border-gray-100 pb-4">
                <h3 class="font-bold text-gray-900 text-lg">Banka Borç Dağılımı</h3>
                <p class="text-xs text-gray-500">6 bankadaki borç ağırlığı</p>
            </div>

            <div class="space-y-3">
                @foreach ($bankDistribution as $bankName => $info)
                    @php
                        $percentage = $riskSummary['total_remaining'] > 0 ? ($info['total'] / $riskSummary['total_remaining']) * 100 : 0;
                    @endphp
                    <div>
                        <div class="flex justify-between text-xs font-semibold text-gray-700 mb-1">
                            <span>{{ $bankName }}</span>
                            <span>₺{{ number_format($info['total'], 0, ',', '.') }} (%{{ round($percentage, 1) }})</span>
                        </div>
                        <div class="w-full bg-gray-100 h-2 rounded-full overflow-hidden">
                            <div class="h-full rounded-full" style="width: {{ $percentage }}%; background-color: {{ $info['color'] }};"></div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="pt-4 border-t border-gray-100 flex justify-between text-xs font-bold text-gray-900">
                <span>Toplam:</span>
                <span class="text-red-600">₺{{ number_format($riskSummary['total_remaining'], 2, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <!-- 4. HIZLI AKSİYON BUTONLARI -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <a href="{{ route('debts.index') }}" class="p-4 bg-white rounded-xl border border-gray-200 hover:border-indigo-500 hover:shadow-md transition-all flex items-center gap-3">
            <span class="text-2xl">💳</span>
            <div>
                <span class="block font-bold text-sm text-gray-900">Borçlarım</span>
                <span class="text-[11px] text-gray-500">Listele ve Yönet</span>
            </div>
        </a>

        <a href="{{ route('cards.index') }}" class="p-4 bg-white rounded-xl border border-gray-200 hover:border-indigo-500 hover:shadow-md transition-all flex items-center gap-3">
            <span class="text-2xl">🏦</span>
            <div>
                <span class="block font-bold text-sm text-gray-900">Kartlarım & KMH</span>
                <span class="text-[11px] text-gray-500">Limit & Faiz Oranları</span>
            </div>
        </a>

        <a href="{{ route('planner.index') }}" class="p-4 bg-white rounded-xl border border-gray-200 hover:border-indigo-500 hover:shadow-md transition-all flex items-center gap-3">
            <span class="text-2xl">🎯</span>
            <div>
                <span class="block font-bold text-sm text-gray-900">Ödeme Planı</span>
                <span class="text-[11px] text-gray-500">Kartopu & Çığ Simülatörü</span>
            </div>
        </a>

        <a href="{{ route('cashflow.index') }}" class="p-4 bg-white rounded-xl border border-gray-200 hover:border-indigo-500 hover:shadow-md transition-all flex items-center gap-3">
            <span class="text-2xl">💵</span>
            <div>
                <span class="block font-bold text-sm text-gray-900">Gelir & Gider</span>
                <span class="text-[11px] text-gray-500">Aylık Nakit Akışı</span>
            </div>
        </a>
    </div>

    <!-- ÖDEME KAYDETME MODAL'I -->
    @if ($showPaymentModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
            <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <h3 class="font-bold text-lg text-gray-900">Ödeme Kaydet</h3>
                    <button wire:click="$set('showPaymentModal', false)" class="text-gray-400 hover:text-gray-600 text-lg font-bold">✕</button>
                </div>

                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Ödenen Tutar (TL)</label>
                        <input type="number" step="0.01" wire:model="paymentAmount" class="w-full rounded-xl border-gray-300 font-bold text-gray-900">
                        @error('paymentAmount') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Not / Açıklama (İsteğe bağlı)</label>
                        <input type="text" wire:model="paymentNote" class="w-full rounded-xl border-gray-300 text-sm" placeholder="Örn: Asgari ödeme yapıldı">
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-3">
                    <button wire:click="$set('showPaymentModal', false)" class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl">
                        Vazgeç
                    </button>
                    <button wire:click="recordPayment" class="px-5 py-2 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-sm">
                        Ödemeyi Onayla ve Düş
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
