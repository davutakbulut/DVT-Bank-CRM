<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fiyatlandırma — DVT Bank CRM</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="bg-slate-950 text-slate-100 antialiased min-h-screen flex flex-col justify-between">
    <x-public-header />

    <main class="max-w-6xl mx-auto py-20 px-6 space-y-12 text-center flex-1">
        <div class="space-y-4 max-w-2xl mx-auto">
            <h1 class="text-4xl font-black text-white tracking-tight">Şeffaf, Basit ve Erişilebilir Fiyatlar</h1>
            <p class="text-slate-400 text-base">Borçlarınızı sıfırlarken ek maliyet yaratmayan planlar.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto text-left">
            <!-- Free Plan -->
            <div class="p-8 bg-slate-900 rounded-3xl border border-slate-800 flex flex-col justify-between space-y-6">
                <div>
                    <span class="text-xs font-bold text-slate-400 block uppercase">Başlangıç</span>
                    <h3 class="text-2xl font-black text-white mt-1">Ücretsiz Plan</h3>
                    <div class="mt-4 flex items-baseline gap-1">
                        <span class="text-4xl font-black text-white">₺0</span>
                        <span class="text-slate-400 text-sm">/ sonsuza dek</span>
                    </div>
                    <ul class="mt-6 space-y-3 text-sm text-slate-300">
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            <span>2 Banka Entegrasyonu</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            <span>5 Borç & Kart Kalemi</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            <span>90 Gün Yasal Takip Sayacı</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            <span>Haftalık AI Finansal Tavsiye</span>
                        </li>
                    </ul>
                </div>
                <a href="{{ route('register') }}" class="w-full py-3 text-center bg-slate-800 hover:bg-slate-700 text-white font-bold rounded-xl text-sm transition-colors">
                    Ücretsiz Başla
                </a>
            </div>

            <!-- Pro Plan -->
            <div class="p-8 bg-gradient-to-b from-indigo-950/80 to-slate-900 rounded-3xl border-2 border-indigo-500 flex flex-col justify-between space-y-6 shadow-2xl relative">
                <span class="absolute -top-3 right-6 px-3 py-0.5 rounded-full bg-indigo-600 text-white text-[11px] font-black uppercase">Tavsiye Edilen</span>
                <div>
                    <span class="text-xs font-bold text-indigo-400 block uppercase">Sınırsız Özgürlük</span>
                    <h3 class="text-2xl font-black text-white mt-1">Pro Plan</h3>
                    <div class="mt-4 flex items-baseline gap-1">
                        <span class="text-4xl font-black text-white">₺149</span>
                        <span class="text-slate-400 text-sm">/ ay</span>
                    </div>
                    <ul class="mt-6 space-y-3 text-sm text-slate-200">
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            <span><strong>Sınırsız</strong> Banka ve Borç Girişi</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            <span><strong>Çığ ve Kartopu</strong> Ödeme Planı Sihirbazı</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            <span><strong>Günlük AI Koçluk</strong> ve 7/24 Chat Desteği</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            <span>Detaylı Faiz Maliyeti & Projeksiyon Raporları</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            <span>Özel Vade Hatırlatıcı Bildirimler</span>
                        </li>
                    </ul>
                </div>
                <a href="{{ route('register') }}" class="w-full py-3.5 text-center bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-xl text-sm shadow-lg shadow-indigo-600/30 transition-all">
                    Pro Plan ile Hemen Başla →
                </a>
            </div>
        </div>
    </main>

    <x-public-footer />
</body>
</html>
