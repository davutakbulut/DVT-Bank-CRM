<div class="py-1 sm:py-6 px-3 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-5 sm:space-y-6">
    @if (session()->has('message'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl flex items-center justify-between shadow-sm">
            <span class="text-xs sm:text-sm font-bold flex items-center gap-2">
                <span>✓</span>
                <span>{{ session('message') }}</span>
            </span>
        </div>
    @endif

    <!-- 1. HOŞ GELDİNİZ VE HIZLI EYLEM ÇUBUĞU -->
    <div class="bg-white p-4 sm:p-5 rounded-2xl border border-gray-200 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <h1 class="text-base sm:text-xl font-black text-gray-900 tracking-tight">
                    Hoş Geldiniz, {{ Auth::user()->name }} 👋
                </h1>
                <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-indigo-50 text-indigo-700 border border-indigo-200">
                    CANLI TAKİP
                </span>
            </div>
            <p class="text-xs text-gray-500 mt-0.5">
                {{ now()->isoFormat('D MMMM YYYY, dddd') }} • {{ $connectedBanksCount > 0 ? $connectedBanksCount . ' Tanımlı Banka' : 'Banka Tanımlanmadı' }}, {{ $activeDebtsCount }} Aktif Borç, {{ $activeCardsCount }} Kart Takipte
            </p>
        </div>

        <!-- Hızlı Aksiyon Butonları -->
        <div class="flex items-center gap-2 overflow-x-auto pb-1 sm:pb-0">
            <a href="{{ route('debts.index') }}" class="px-3 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold transition-all shrink-0 shadow-sm flex items-center gap-1.5">
                <span>+</span>
                <span>Borç Ekle</span>
            </a>
            <a href="{{ route('cards.index') }}" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-xl text-xs font-bold transition-all shrink-0 flex items-center gap-1.5">
                <span>💳</span>
                <span>Kart Ekle</span>
            </a>
            <a href="{{ route('cashflow.index') }}" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-xl text-xs font-bold transition-all shrink-0 flex items-center gap-1.5">
                <span>💵</span>
                <span>Gelir/Gider</span>
            </a>
            <a href="{{ route('ai.coach') }}" class="px-3 py-2 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200 rounded-xl text-xs font-bold transition-all shrink-0 flex items-center gap-1.5">
                <span>🤖</span>
                <span>AI Koç</span>
            </a>
        </div>
    </div>

    <!-- 2. ÜST 4 METRİK KARTI -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
        <!-- Toplam Borç -->
        <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm relative overflow-hidden">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">TOPLAM BORÇ YÜKÜ</span>
                <span class="w-8 h-8 rounded-xl bg-red-50 text-red-600 flex items-center justify-center font-bold text-sm">₺</span>
            </div>
            <div class="mt-3">
                <span class="text-2xl sm:text-3xl font-black text-red-600 tracking-tight">₺{{ number_format($riskSummary['total_remaining'], 2, ',', '.') }}</span>
                <p class="text-xs text-gray-500 mt-1">{{ $activeDebtsCount }} adet aktif borç ve kredi toplamı</p>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-red-500"></div>
        </div>

        <!-- Bu Ayki Asgari / Taksit -->
        <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm relative overflow-hidden">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">BU AYKİ ASGARİ / TAKSİT</span>
                <span class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold text-sm">⚡</span>
            </div>
            <div class="mt-3">
                <span class="text-2xl sm:text-3xl font-black text-amber-600 tracking-tight">₺{{ number_format($riskSummary['total_monthly_commitment'], 2, ',', '.') }}</span>
                <p class="text-xs text-gray-500 mt-1">Gecikmeye düşmemek için gereken asgari</p>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-amber-500"></div>
        </div>

        <!-- 90 Gün Yasal Takip Erken Uyarı Sayacı -->
        <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm relative overflow-hidden {{ $riskSummary['days_to_legal_minimum'] <= 30 && $riskSummary['total_remaining'] > 0 ? 'ring-2 ring-red-500/20' : '' }}">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">EN KRİTİK TAKİP SAYAÇ</span>
                <span class="w-8 h-8 rounded-xl {{ $riskSummary['days_to_legal_minimum'] <= 30 && $riskSummary['total_remaining'] > 0 ? 'bg-red-100 text-red-700 animate-pulse' : 'bg-blue-50 text-blue-600' }} flex items-center justify-center font-bold text-sm">⏳</span>
            </div>
            <div class="mt-3">
                <div class="flex items-baseline gap-2">
                    <span class="text-2xl sm:text-3xl font-black {{ $riskSummary['days_to_legal_minimum'] <= 30 && $riskSummary['total_remaining'] > 0 ? 'text-red-600' : 'text-gray-900' }}">
                        {{ $riskSummary['total_remaining'] > 0 ? $riskSummary['days_to_legal_minimum'] . ' Gün' : '0 Gün' }}
                    </span>
                    <span class="text-xs font-bold text-gray-500">Kaldı</span>
                </div>
                <p class="text-xs text-gray-600 mt-1 truncate">
                    {{ $riskSummary['most_critical_item']['bank'] ?? 'Tüm borçlar güncel' }}: {{ $riskSummary['most_critical_item']['title'] ?? '' }}
                </p>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 {{ $riskSummary['days_to_legal_minimum'] <= 30 && $riskSummary['total_remaining'] > 0 ? 'bg-red-600' : 'bg-indigo-600' }}"></div>
        </div>

        <!-- Borca Ayrılabilir Net Nakit -->
        <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm relative overflow-hidden">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">BORCA AYRILABİLİR NET</span>
                <span class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-sm">📈</span>
            </div>
            <div class="mt-3">
                <span class="text-2xl sm:text-3xl font-black text-emerald-600 tracking-tight">₺{{ number_format($availableForDebt, 2, ',', '.') }}</span>
                <p class="text-xs text-gray-500 mt-1">Gelir (₺{{ number_format($totalMonthlyIncome,0,',','.') }}) - Sabit (₺{{ number_format($totalMonthlyExpense,0,',','.') }})</p>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-emerald-500"></div>
        </div>
    </div>

    <!-- 3. FİNANSAL SAĞLIK VE BORÇ KARŞILAMA ORANI (DTI SAĞLIK BARI) -->
    <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm space-y-3">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
            <div>
                <h3 class="font-bold text-sm text-gray-900">Aylık Borç Yükü / Gelir Oranı (DTI Oranı)</h3>
                <p class="text-xs text-gray-500">Aylık toplam gelirinizin yüzde kaçı asgari borç ödemelerine gidiyor?</p>
            </div>
            <div class="flex items-center gap-2">
                @if ($debtToIncomeRatio <= 35)
                    <span class="px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 text-xs font-bold border border-emerald-200">
                        ✓ Güvenli Seviye (%{{ $debtToIncomeRatio }})
                    </span>
                @elseif ($debtToIncomeRatio <= 60)
                    <span class="px-2.5 py-1 rounded-lg bg-amber-50 text-amber-700 text-xs font-bold border border-amber-200">
                        ⚠️ Dikkat Seviyesi (%{{ $debtToIncomeRatio }})
                    </span>
                @else
                    <span class="px-2.5 py-1 rounded-lg bg-red-50 text-red-700 text-xs font-bold border border-red-200">
                        🚨 Kritik Kriz Seviyesi (%{{ $debtToIncomeRatio }})
                    </span>
                @endif
            </div>
        </div>

        <div class="w-full bg-gray-100 h-3 rounded-full overflow-hidden">
            <div class="h-full rounded-full transition-all duration-500 {{ $debtToIncomeRatio <= 35 ? 'bg-emerald-500' : ($debtToIncomeRatio <= 60 ? 'bg-amber-500' : 'bg-red-500') }}" style="width: {{ min(100, max(5, $debtToIncomeRatio)) }}%"></div>
        </div>
    </div>

    <!-- 4. AI FİNANSAL KOÇ BRİFİNGİ -->
    <div class="bg-white border-2 border-indigo-100 rounded-2xl p-5 sm:p-6 shadow-sm space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-gray-100 pb-3">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-indigo-50 border border-indigo-200 text-indigo-700 flex items-center justify-center font-bold text-lg shrink-0">
                    🤖
                </div>
                <div>
                    <h3 class="font-bold text-sm sm:text-base text-gray-900">AI Finansal Koçunuzun Günlük Durum Özeti</h3>
                    <p class="text-xs text-gray-500">Veritabanınızdaki borç ve vadeler taranarak oluşturuldu</p>
                </div>
            </div>
            <a href="{{ route('ai.coach') }}" class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-bold bg-indigo-600 hover:bg-indigo-700 text-white transition-colors self-start sm:self-auto">
                AI ile Soru-Cevap Yap →
            </a>
        </div>

        <div class="text-xs sm:text-sm text-gray-700 leading-relaxed space-y-2">
            @if ($latestAdvice)
                {!! nl2br(e($latestAdvice->content)) !!}
            @else
                <p>
                    <strong>Kriz Strateji Tavsiyesi:</strong> Borçlarınızı sıfırlamak için en yüksek faizli KMH ve kredi kartlarına odaklanın (Çığ Yöntemi). Diğer bankalara asgari tutarı ödeyerek yasal takip süresini güvenle yönetin.
                </p>
            @endif
        </div>

        <div class="pt-2 border-t border-gray-100 text-[10px] text-gray-400">
            ⚖️ <em>Bu öneriler bilgilendirme amaçlıdır; 6362 sayılı Kanun kapsamında yatırım ve finansal danışmanlık değildir.</em>
        </div>
    </div>

    <!-- 5. ORTA ALAN: ÖNCELİKLİ ÖDEMELER VE BANKA DAĞILIMI -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Yaklaşan & Geciken Ödemeler Listesi (2 Kolon) -->
        <div class="lg:col-span-2 bg-white rounded-2xl p-5 sm:p-6 border border-gray-200 shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                <div>
                    <h3 class="font-bold text-gray-900 text-sm sm:text-base">Öncelikli ve Yaklaşan Ödemeler</h3>
                    <p class="text-xs text-gray-500">Gecikme süresine ve vade tarihine göre sıralı</p>
                </div>
                <a href="{{ route('debts.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800">Tüm Borçlar →</a>
            </div>

            <div class="divide-y divide-gray-100">
                @forelse ($upcomingDebts as $debt)
                    @php
                        $daysLeft = max(0, 90 - $debt->days_overdue);
                    @endphp
                    <div class="py-3.5 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="flex items-center gap-3 min-w-0">
                            <span class="w-9 h-9 rounded-xl flex items-center justify-center text-white text-xs font-black shrink-0 shadow-sm" style="background-color: {{ $debt->bank?->color ?? '#6366f1' }}">
                                {{ mb_substr($debt->bank?->name ?? 'B', 0, 2) }}
                            </span>
                            <div class="min-w-0">
                                <h4 class="font-bold text-xs sm:text-sm text-gray-900 truncate">{{ $debt->title }}</h4>
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

                        <div class="flex items-center justify-between sm:justify-end gap-3 shrink-0">
                            <div class="text-left sm:text-right">
                                <span class="block font-black text-xs sm:text-sm text-gray-900">₺{{ number_format($debt->remaining, 2, ',', '.') }}</span>
                                <span class="text-[10px] sm:text-[11px] text-gray-500 font-medium">Takibe: {{ $daysLeft }} gün</span>
                            </div>
                            <button wire:click="openPaymentModal({{ $debt->id }})" class="px-3 py-1.5 bg-indigo-50 text-indigo-700 hover:bg-indigo-100 font-bold text-xs rounded-xl transition-colors">
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
        <div class="bg-white rounded-2xl p-5 sm:p-6 border border-gray-200 shadow-sm space-y-4">
            <div class="border-b border-gray-100 pb-3">
                <h3 class="font-bold text-gray-900 text-sm sm:text-base">Banka Borç Dağılımı</h3>
                <p class="text-xs text-gray-500">{{ count($bankDistribution) > 0 ? count($bankDistribution) . ' bankadaki borç portföy ağırlığı' : 'Aktif banka borcu bulunmuyor' }}</p>
            </div>

            <div class="space-y-3">
                @forelse ($bankDistribution as $bankName => $info)
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
                @empty
                    <p class="text-xs text-gray-500 text-center py-4">Banka borcu bulunmuyor.</p>
                @endforelse
            </div>

            <div class="pt-3 border-t border-gray-100 flex justify-between text-xs font-bold text-gray-900">
                <span>Toplam:</span>
                <span class="text-red-600">₺{{ number_format($riskSummary['total_remaining'], 2, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <!-- ÖDEME KAYDETME MODAL'I -->
    @if ($showPaymentModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-xs p-4">
            <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <h3 class="font-bold text-base sm:text-lg text-gray-900">Ödeme Kaydet</h3>
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
                    <button wire:click="$set('showPaymentModal', false)" class="px-4 py-2 text-xs font-bold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl">
                        Vazgeç
                    </button>
                    <button wire:click="recordPayment" class="px-5 py-2 text-xs font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-sm">
                        Ödemeyi Onayla ve Düş
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
