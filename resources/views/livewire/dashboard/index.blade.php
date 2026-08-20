<div class="py-1 sm:py-6 px-3 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-5 sm:space-y-6">
    @if (session()->has('message'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl flex items-center justify-between shadow-sm">
            <span class="text-xs sm:text-sm font-bold flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                <span>{{ session('message') }}</span>
            </span>
        </div>
    @endif

    @if (!Auth::user()->onboarding_completed)
        <div class="bg-gradient-to-r from-amber-50 via-indigo-50 to-purple-50 border border-amber-200/90 p-4 rounded-2xl flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 shadow-xs">
            <div class="flex items-center gap-3">
                <div class="p-2.5 bg-amber-500/20 text-amber-700 rounded-xl shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <div>
                    <h4 class="font-heading font-black text-xs sm:text-sm text-gray-900">İlk Kurulum Sihirbazını Henüz Tamamlamadınız!</h4>
                    <p class="text-[11px] sm:text-xs text-gray-600">Gelir ve borç bilgilerinizi hızlıca aktararak borç kapatma simülasyonunu ve AI önerilerini tam kapasiteye çıkarın.</p>
                </div>
            </div>
            <a href="{{ route('onboarding.index') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-xl shadow-md transition-all shrink-0 flex items-center gap-1.5 whitespace-nowrap">
                <span>Sihirbazı Tamamla</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>
    @endif

    <!-- 1. HOŞ GELDİNİZ VE HIZLI EYLEM ÇUBUĞU -->
    <div class="bg-white p-4 sm:p-5 rounded-2xl border border-gray-200 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <h1 class="text-base sm:text-xl font-black text-gray-900 tracking-tight">
                    Hoş Geldiniz, {{ Auth::user()->name }}
                </h1>
                <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-indigo-50 text-indigo-700 border border-indigo-200 flex items-center gap-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-ping"></span>
                    <span>CANLI TAKİP</span>
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
                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/></svg>
                <span>Kart Ekle</span>
            </a>
            <a href="{{ route('cashflow.index') }}" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-xl text-xs font-bold transition-all shrink-0 flex items-center gap-1.5">
                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5h16.5a1.5 1.5 0 011.5 1.5v9a1.5 1.5 0 01-1.5 1.5H3.75a1.5 1.5 0 01-1.5-1.5v-9a1.5 1.5 0 011.5-1.5zM12 12.75a2.25 2.25 0 100-4.5 2.25 2.25 0 000 4.5z"/></svg>
                <span>Gelir/Gider</span>
            </a>
            <a href="{{ route('ai.coach') }}" class="px-3 py-2 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200 rounded-xl text-xs font-bold transition-all shrink-0 flex items-center gap-1.5">
                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z"/></svg>
                <span>AI Koç</span>
            </a>
        </div>
    </div>

    <!-- GELİR GERÇEKLEŞME & ONAY AKSİYON BİLDİRİMİ (KOMPAKT & GÖZE BATMAYAN İNCE ŞERİT) -->
    @if ($dueExpectedIncomes->count() > 0)
        <div class="space-y-2">
            @foreach ($dueExpectedIncomes as $ei)
                <div class="bg-emerald-950/50 border border-emerald-500/40 rounded-xl p-3 sm:px-4 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-2.5">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <span class="px-2 py-0.5 rounded-md text-[10px] font-black uppercase tracking-wide shrink-0
                            {{ $ei->status === 'delayed' ? 'bg-rose-500/20 text-rose-300 border border-rose-500/30' : 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' }}">
                            {{ $ei->status === 'delayed' ? 'GECİKMELİ GELİR' : 'VADESİ GELEN GELİR' }}
                        </span>
                        <div class="text-xs font-bold text-white truncate">
                            <span>{{ $ei->title }}</span>
                            <span class="text-emerald-400 font-mono ml-1">₺{{ number_format($ei->amount, 2, ',', '.') }}</span>
                            <span class="text-[11px] text-slate-400 font-normal ml-1">({{ $ei->expected_date?->format('d.m.Y') }})</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 shrink-0">
                        <button wire:click="confirmExpectedIncome({{ $ei->id }})" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-500 active:scale-95 text-white font-bold text-xs rounded-lg shadow transition-all cursor-pointer flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            <span>Hesaba Geçti</span>
                        </button>
                        <button wire:click="delayExpectedIncome({{ $ei->id }}, 3)" class="px-2.5 py-1.5 bg-slate-800 hover:bg-slate-700 text-amber-300 border border-amber-500/30 font-bold text-xs rounded-lg transition-all cursor-pointer" title="3 Gün Ertele">
                            ⏱️ 3G Ertele
                        </button>
                        <button wire:click="cancelExpectedIncome({{ $ei->id }})" wire:confirm="Bu geliri iptal etmek istediğinize emin misiniz?" class="p-1.5 text-slate-400 hover:text-rose-400 transition-colors cursor-pointer" title="İptal Et">
                            ✕
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @elseif ($upcomingExpectedIncomes->count() > 0)
        <!-- YAKLAŞAN BEKLENEN GELİR BİLGİ ŞERİDİ (KOMPAKT & GÖZE BATMAYAN İNCE ŞERİT) -->
        <div class="space-y-2">
            @foreach ($upcomingExpectedIncomes->take(1) as $uei)
                @php
                    $daysLeft = (int) now()->startOfDay()->diffInDays($uei->expected_date?->startOfDay(), false);
                @endphp
                <div class="bg-slate-900 text-white border border-slate-800 rounded-xl p-3 sm:px-4 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-2.5">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <span class="px-2 py-0.5 rounded-md text-[10px] font-black bg-indigo-500/20 text-indigo-300 border border-indigo-500/30 shrink-0">
                            {{ $daysLeft }} GÜN SONRA
                        </span>
                        <div class="text-xs font-bold text-slate-200 truncate">
                            <span>{{ $uei->title }}</span>
                            <span class="text-emerald-400 font-mono ml-1">₺{{ number_format($uei->amount, 2, ',', '.') }}</span>
                            <span class="text-[11px] text-slate-400 font-normal ml-1">({{ $uei->expected_date?->format('d.m.Y') }})</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 shrink-0">
                        <button wire:click="confirmExpectedIncome({{ $uei->id }})" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-500 active:scale-95 text-white font-bold text-xs rounded-lg transition-all cursor-pointer flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            <span>Hesaba Geçti</span>
                        </button>
                        <a href="{{ route('cashflow.index') }}" class="px-2.5 py-1.5 bg-slate-800 hover:bg-slate-700 border border-slate-700 text-slate-300 font-bold text-xs rounded-lg transition-all">
                            Nakit Akışı
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

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
                <span class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold text-sm">
                    <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/></svg>
                </span>
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
                <span class="w-8 h-8 rounded-xl {{ $riskSummary['days_to_legal_minimum'] <= 30 && $riskSummary['total_remaining'] > 0 ? 'bg-red-100 text-red-700 animate-pulse' : 'bg-blue-50 text-blue-600' }} flex items-center justify-center font-bold text-sm">
                    <svg class="w-4 h-4 {{ $riskSummary['days_to_legal_minimum'] <= 30 && $riskSummary['total_remaining'] > 0 ? 'text-red-600' : 'text-blue-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </span>
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
                <span class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-sm">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 005.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941"/></svg>
                </span>
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
                    <span class="px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 text-xs font-bold border border-emerald-200 flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        <span>Güvenli Seviye (%{{ $debtToIncomeRatio }})</span>
                    </span>
                @elseif ($debtToIncomeRatio <= 60)
                    <span class="px-2.5 py-1 rounded-lg bg-amber-50 text-amber-700 text-xs font-bold border border-amber-200 flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                        <span>Dikkat Seviyesi (%{{ $debtToIncomeRatio }})</span>
                    </span>
                @else
                    <span class="px-2.5 py-1 rounded-lg bg-red-50 text-red-700 text-xs font-bold border border-red-200 flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                        <span>Kritik Kriz Seviyesi (%{{ $debtToIncomeRatio }})</span>
                    </span>
                @endif
            </div>
        </div>

        <div class="w-full bg-gray-100 h-3 rounded-full overflow-hidden">
            <div class="h-full rounded-full transition-all duration-500 {{ $debtToIncomeRatio <= 35 ? 'bg-emerald-500' : ($debtToIncomeRatio <= 60 ? 'bg-amber-500' : 'bg-red-500') }}" style="width: {{ min(100, max(5, $debtToIncomeRatio)) }}%"></div>
        </div>
    </div>

    <!-- 📊 ETKİLEŞİMLİ FİNANSAL GRAFİKLER (DASHBOARD CHARTS) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <!-- Grafik 1: Bankalara Göre Borç Dağılımı (Doughnut Chart) -->
        <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between border-b border-gray-100 pb-3 mb-3">
                <div>
                    <h3 class="font-heading font-bold text-sm text-gray-900">Bankalara Göre Borç Oranları</h3>
                    <p class="text-[11px] text-gray-500">Aktif borçların banka bazlı yüzdesel yükü</p>
                </div>
                <span class="text-[10px] font-black px-2 py-0.5 rounded-full bg-indigo-50 text-indigo-700 border border-indigo-200">ORANLAR</span>
            </div>
            <div class="relative w-full h-56 flex items-center justify-center">
                <canvas id="dashboardBankChart"></canvas>
            </div>
        </div>

        <!-- Grafik 2: 6 Aylık Borç Ödeme & Erime Projeksiyonu (Combo Chart - 2 Kolon) -->
        <div class="lg:col-span-2 bg-white p-5 rounded-2xl border border-gray-200 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between border-b border-gray-100 pb-3 mb-3">
                <div>
                    <h3 class="font-heading font-bold text-sm text-gray-900">6 Aylık Borç Ödeme & Erime Eğrisi</h3>
                    <p class="text-[11px] text-gray-500">Aktif ödeme planınıza göre aylık bütçe ödemeleri ve kalan borç projeksiyonu</p>
                </div>
                <span class="text-[10px] font-black px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">TREND</span>
            </div>
            <div class="relative w-full h-56">
                <canvas id="dashboardProjectionChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Chart.js Scripts Initialization -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof Chart === 'undefined') return;

            // Chart 1: Doughnut
            const bankCtx = document.getElementById('dashboardBankChart');
            if (bankCtx) {
                new Chart(bankCtx, {
                    type: 'doughnut',
                    data: {
                        labels: {!! json_encode($chartBankLabels) !!},
                        datasets: [{
                            data: {!! json_encode($chartBankValues) !!},
                            backgroundColor: {!! json_encode($chartBankColors) !!},
                            borderWidth: 2,
                            borderColor: '#ffffff',
                            hoverOffset: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    boxWidth: 10,
                                    font: { family: "'Plus Jakarta Sans', sans-serif", size: 11, weight: '600' },
                                    padding: 12
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(ctx) {
                                        let value = ctx.raw || 0;
                                        return ' ' + ctx.label + ': ₺' + value.toLocaleString('tr-TR', {minimumFractionDigits: 2});
                                    }
                                }
                            }
                        },
                        cutout: '68%'
                    }
                });
            }

            // Chart 2: Projection Bar + Line Combo
            const projCtx = document.getElementById('dashboardProjectionChart');
            if (projCtx) {
                new Chart(projCtx, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($projectionLabels) !!},
                        datasets: [
                            {
                                label: 'Aylık Ödeme (₺)',
                                data: {!! json_encode($projectionPayments) !!},
                                backgroundColor: 'rgba(99, 102, 241, 0.85)',
                                borderRadius: 8,
                                yAxisID: 'y'
                            },
                            {
                                label: 'Kalan Toplam Borç (₺)',
                                data: {!! json_encode($projectionBalances) !!},
                                type: 'line',
                                borderColor: '#ef4444',
                                backgroundColor: 'rgba(239, 68, 68, 0.08)',
                                fill: true,
                                tension: 0.35,
                                pointRadius: 4,
                                pointBackgroundColor: '#ef4444',
                                yAxisID: 'y1'
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: {
                                grid: { display: false },
                                ticks: { font: { family: "'Plus Jakarta Sans', sans-serif", size: 11, weight: '600' } }
                            },
                            y: {
                                type: 'linear',
                                display: true,
                                position: 'left',
                                grid: { color: 'rgba(226, 232, 240, 0.6)' },
                                ticks: {
                                    font: { family: "'Plus Jakarta Sans', sans-serif", size: 10 },
                                    callback: v => '₺' + (v / 1000).toFixed(0) + 'k'
                                }
                            },
                            y1: {
                                type: 'linear',
                                display: true,
                                position: 'right',
                                grid: { drawOnChartArea: false },
                                ticks: {
                                    font: { family: "'Plus Jakarta Sans', sans-serif", size: 10 },
                                    callback: v => '₺' + (v / 1000).toFixed(0) + 'k'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: { font: { family: "'Plus Jakarta Sans', sans-serif", size: 11, weight: '600' }, boxWidth: 12 }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(ctx) {
                                        return ' ' + ctx.dataset.label + ': ₺' + ctx.raw.toLocaleString('tr-TR', {minimumFractionDigits: 2});
                                    }
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>

    <!-- 4. AI FİNANSAL KOÇ BRİFİNGİ (AÇILIR-KAPANIR, VARSAYILAN: KAPALI) -->
    <div x-data="{ showBriefing: false }" class="bg-white border-2 border-indigo-100 rounded-2xl p-4 sm:p-5 shadow-sm transition-all">
        <div @click="showBriefing = !showBriefing" class="flex items-center justify-between gap-3 cursor-pointer select-none">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-indigo-50 border border-indigo-200 text-indigo-700 flex items-center justify-center font-bold text-lg shrink-0">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z"/></svg>
                </div>
                <div>
                    <h3 class="font-bold text-sm sm:text-base text-gray-900 flex items-center gap-2">
                        <span>AI Finansal Koçunuzun Günlük Durum Özeti</span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-indigo-50 text-indigo-700 border border-indigo-200">AI TAVSİYESİ</span>
                    </h3>
                    <p class="text-xs text-gray-500">Tıklayarak güncel tavsiye ve durum analizini <span x-text="showBriefing ? 'gizleyebilirsiniz' : 'görüntüleyebilirsiniz'"></span></p>
                </div>
            </div>

            <div class="flex items-center gap-2 shrink-0">
                <a href="{{ route('ai.coach') }}" @click.stop class="hidden sm:inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-bold bg-indigo-600 hover:bg-indigo-700 text-white transition-colors gap-1">
                    <span>Soru-Cevap</span>
                    <span>→</span>
                </a>
                <button type="button" class="p-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-600 transition-colors flex items-center justify-center">
                    <svg class="w-5 h-5 text-gray-600 transition-transform duration-200" :class="{ 'rotate-180': showBriefing }" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
            </div>
        </div>

        <div x-show="showBriefing" x-cloak x-collapse class="space-y-4 pt-3 border-t border-gray-100">
            <div class="text-xs sm:text-sm text-slate-700 leading-relaxed space-y-2 prose prose-sm max-w-none
                [&_table]:w-full [&_table]:border-collapse [&_table]:my-3 [&_table]:text-xs [&_table]:rounded-xl [&_table]:overflow-hidden [&_table]:border [&_table]:border-slate-200
                [&_th]:bg-slate-100 [&_th]:p-2.5 [&_th]:border [&_th]:border-slate-200 [&_th]:text-slate-900 [&_th]:font-bold [&_th]:text-left
                [&_td]:p-2.5 [&_td]:border [&_td]:border-slate-200 [&_td]:text-slate-700
                [&_tr:nth-child(even)]:bg-slate-50/60
                [&_h2]:text-sm [&_h2]:font-black [&_h2]:text-slate-900 [&_h2]:mt-3.5 [&_h2]:mb-1.5
                [&_h3]:text-xs [&_h3]:font-black [&_h3]:text-slate-900 [&_h3]:mt-2.5 [&_h3]:mb-1
                [&_ul]:list-disc [&_ul]:pl-5 [&_ul]:space-y-1 [&_ul]:my-2
                [&_ol]:list-decimal [&_ol]:pl-5 [&_ol]:space-y-1 [&_ol]:my-2
                [&_blockquote]:border-l-4 [&_blockquote]:border-indigo-500 [&_blockquote]:bg-indigo-50/40 [&_blockquote]:p-3 [&_blockquote]:rounded-r-lg [&_blockquote]:my-2 [&_blockquote]:text-indigo-900 [&_blockquote]:font-medium
                [&_hr]:border-slate-100 [&_hr]:my-3">
                @if ($latestAdvice)
                    {!! \App\Helpers\AiFormatter::format($latestAdvice->content, true) !!}
                @else
                    <p>
                        <strong>Kriz Strateji Tavsiyesi:</strong> Borçlarınızı sıfırlamak için en yüksek faizli KMH ve kredi kartlarına odaklanın (Çığ Yöntemi). Diğer bankalara asgari tutarı ödeyerek yasal takip süresini güvenle yönetin.
                    </p>
                @endif
            </div>

            <div class="pt-2 border-t border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-[10px] text-gray-400">
                <div class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v17.25m0 0c-1.472 0-2.882.265-4.185.75M12 20.25c1.472 0 2.882.265 4.185.75M18.75 4.5l-6.75 3-6.75-3m13.5 0v4.5c0 1.243-3.022 2.25-6.75 2.25S5.25 10.243 5.25 9V4.5m13.5 0H5.25"/></svg>
                    <em>Bu öneriler bilgilendirme amaçlıdır; 6362 sayılı Kanun kapsamında yatırım ve finansal danışmanlık değildir.</em>
                </div>
                <a href="{{ route('ai.coach') }}" class="sm:hidden text-indigo-600 font-bold text-xs">AI Koç ile Soru-Cevap →</a>
            </div>
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
