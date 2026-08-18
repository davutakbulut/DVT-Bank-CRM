<div class="py-1 sm:py-6 px-3 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-6">
    <div>
        <h1 class="text-2xl font-black text-gray-900 tracking-tight">📊 Finansal Analiz & Faiz Yükü Raporları</h1>
        <p class="text-sm text-gray-600">Banka bazlı faiz maliyetleri, borç kapanış projeksiyonu ve ödeme geçmişiniz</p>
    </div>

    <!-- ÜST PROJEKSİYON KARTLARI -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-1">
            <span class="text-xs font-bold text-gray-500 block">TOPLAM BORÇ BAKİYESİ</span>
            <span class="text-3xl font-black text-red-600">₺{{ number_format($totalRemaining, 2, ',', '.') }}</span>
            <p class="text-xs text-gray-400 mt-1">Tüm bankalar dahil</p>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-1">
            <span class="text-xs font-bold text-gray-500 block">BORCA AYRILAN AYLIK NET BÜTÇE</span>
            <span class="text-3xl font-black text-emerald-600">₺{{ number_format($netMonthlySavings, 2, ',', '.') }}</span>
            <p class="text-xs text-gray-400 mt-1">Gelir - Sabit Gider farkı</p>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-1">
            <span class="text-xs font-bold text-gray-500 block">TAHMİNİ TAM KAPANMA SÜRESİ</span>
            <span class="text-3xl font-black text-indigo-600">~{{ $estimatedPayoffMonths }} Ay</span>
            <p class="text-xs text-gray-400 mt-1">Mevcut nakit akışı temposuyla</p>
        </div>
    </div>

    <!-- BANKA BAZLI FAİZ YÜKÜ TABLOSU -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-sm space-y-4">
        <h3 class="font-bold text-gray-900 text-lg border-b border-gray-100 pb-3">Banka Bazlı Yıllık Faiz Maliyeti</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50 text-gray-500 text-xs text-left">
                    <tr>
                        <th class="px-6 py-3 font-bold">Banka</th>
                        <th class="px-6 py-3 font-bold">Toplam Borç</th>
                        <th class="px-6 py-3 font-bold">Ortalama Aylık Faiz</th>
                        <th class="px-6 py-3 font-bold">Aylık Faiz Maliyeti</th>
                        <th class="px-6 py-3 font-bold text-red-600">Yıllık Faiz Yükü (TL)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($bankCostSummary as $bankName => $cost)
                        <tr>
                            <td class="px-6 py-4 font-bold text-gray-900">{{ $bankName }}</td>
                            <td class="px-6 py-4 font-semibold text-gray-700">₺{{ number_format($cost['total_debt'], 2, ',', '.') }}</td>
                            <td class="px-6 py-4 text-gray-600">%{{ number_format($cost['avg_interest'], 2) }}</td>
                            <td class="px-6 py-4 text-amber-700 font-bold">₺{{ number_format($cost['monthly_interest_cost'], 2, ',', '.') }}</td>
                            <td class="px-6 py-4 font-black text-red-600">₺{{ number_format($cost['annual_interest_cost'], 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- SON ÖDEME GEÇMİŞİ (PAYMENTS_LOG) -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-sm space-y-4">
        <h3 class="font-bold text-gray-900 text-lg border-b border-gray-100 pb-3">Son Yapılan Ödeme Kayıtları</h3>
        <div class="divide-y divide-gray-100">
            @forelse ($paymentLogs as $log)
                <div class="py-3.5 flex items-center justify-between">
                    <div>
                        <span class="font-bold text-sm text-gray-900 block">{{ $log->note ?: 'Borç Ödemesi' }}</span>
                        <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($log->paid_at)->format('d.m.Y') }} · {{ $log->method === 'auto' ? 'Otomatik' : 'Manuel' }}</span>
                    </div>
                    <span class="text-base font-black text-emerald-600">₺{{ number_format($log->amount, 2, ',', '.') }}</span>
                </div>
            @empty
                <div class="py-6 text-center text-xs text-gray-400">Henüz kayıtlı ödeme geçmişi yok.</div>
            @endforelse
        </div>
    </div>
</div>
