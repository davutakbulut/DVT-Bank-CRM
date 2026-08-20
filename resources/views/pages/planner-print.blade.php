<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DVT Bank CRM — Yapay Zeka Kişiye Özel Borç Kurtarma Raporu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; color: black !important; }
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 p-8 min-h-screen font-sans">
    <div class="max-w-4xl mx-auto bg-white p-8 sm:p-12 rounded-2xl shadow-xl border border-slate-200">
        <!-- Header -->
        <div class="flex items-center justify-between border-b border-slate-200 pb-6">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-xl bg-indigo-600 text-white flex items-center justify-center font-black text-2xl shadow-lg">
                    DVT
                </div>
                <div>
                    <h1 class="text-xl font-black text-slate-900">DVT BANK CRM — KİŞİSEL BORÇ KURTARMA RAPORU</h1>
                    <p class="text-xs text-slate-500">Oluşturulma Tarihi: {{ now()->format('d.m.Y H:i') }} | Müşteri: {{ $user->name }}</p>
                </div>
            </div>
            <div class="no-print flex items-center gap-2">
                <button onclick="window.print()" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-xl shadow transition-all cursor-pointer">
                    🖨️ PDF Olarak Yazdır / İndir
                </button>
            </div>
        </div>

        <!-- Aktif Plan Özeti -->
        @if ($activePlan)
            <div class="my-6 p-4 rounded-xl bg-slate-100 border border-slate-200 grid grid-cols-3 gap-4 text-center">
                <div>
                    <span class="text-xs text-slate-500 block">Plan Adı</span>
                    <strong class="text-sm font-black text-indigo-900">{{ $activePlan->name }}</strong>
                </div>
                <div>
                    <span class="text-xs text-slate-500 block">Aylık Ödeme Bütçesi</span>
                    <strong class="text-sm font-black text-emerald-600">₺{{ number_format($activePlan->monthly_budget, 2, ',', '.') }}</strong>
                </div>
                <div>
                    <span class="text-xs text-slate-500 block">Strateji</span>
                    <strong class="text-sm font-black uppercase text-indigo-700">{{ $activePlan->strategy }}</strong>
                </div>
            </div>
        @endif

        <!-- AI Analiz Çıktısı -->
        <div class="prose max-w-none text-slate-800 text-sm leading-relaxed my-6 border-b border-slate-200 pb-6">
            <h2 class="text-base font-black text-indigo-950 uppercase tracking-wide mb-3">🤖 Gemini AI Finansal Teşhis ve Adım Adım Kurtarma Planı</h2>
            @if ($latestAdvice)
                <div class="bg-slate-50 p-6 rounded-xl border border-slate-200 whitespace-pre-line font-sans text-xs">
                    {!! nl2br(e($latestAdvice->content)) !!}
                </div>
            @else
                <p class="text-slate-500 italic">Henüz kaydedilmiş bir AI analiz raporu bulunmamaktadır.</p>
            @endif
        </div>

        <!-- Borçlar Tablosu -->
        <div class="my-6">
            <h3 class="text-sm font-black text-slate-900 mb-3 uppercase">📋 Mevcut Aktif Borçlar Detay Listesi</h3>
            <table class="w-full text-left text-xs border-collapse border border-slate-200">
                <thead>
                    <tr class="bg-slate-100 text-slate-700 font-bold border-b border-slate-200">
                        <th class="p-2 border-r border-slate-200">Banka / Kurum</th>
                        <th class="p-2 border-r border-slate-200">Borç Başlığı</th>
                        <th class="p-2 border-r border-slate-200">Tür</th>
                        <th class="p-2 border-r border-slate-200">Aylık Faiz</th>
                        <th class="p-2 border-r border-slate-200">Kalan Borç</th>
                        <th class="p-2">Asgari / Taksit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($debts as $d)
                        <tr class="border-b border-slate-200">
                            <td class="p-2 border-r border-slate-200 font-bold">{{ $d->bank?->name ?? 'Diğer' }}</td>
                            <td class="p-2 border-r border-slate-200">{{ $d->title }}</td>
                            <td class="p-2 border-r border-slate-200 uppercase">{{ $d->type }}</td>
                            <td class="p-2 border-r border-slate-200">%{{ number_format($d->interest_rate, 2) }}</td>
                            <td class="p-2 border-r border-slate-200 font-bold text-rose-700">₺{{ number_format($d->remaining, 2, ',', '.') }}</td>
                            <td class="p-2 font-bold">₺{{ number_format($d->installment_amount ?: ($d->remaining * 0.05), 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Disclaimer -->
        <div class="mt-8 pt-4 border-t border-slate-200 text-[10px] text-slate-400 text-center">
            ⚖️ Bu rapor DVT Bank CRM Yapay Zeka Sistemi tarafından oluşturulmuştur. Bilgilendirme amaçlıdır; 6362 sayılı Kanun kapsamında yatırım veya finansal danışmanlık değildir.
        </div>
    </div>

    <script>
        window.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => { window.print(); }, 600);
        });
    </script>
</body>
</html>
