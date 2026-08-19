<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Özellikler — DVT Bank CRM</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="bg-slate-950 text-slate-100 antialiased min-h-screen flex flex-col justify-between">
    <x-public-header />

    <main class="max-w-6xl mx-auto py-16 px-6 space-y-12 flex-1">
        <div class="text-center space-y-3">
            <h1 class="text-4xl font-black text-white tracking-tight">Tüm Güçlü Modüller Tek Platformda</h1>
            <p class="text-slate-400 text-base">Borç batağından güvenle çıkabilmeniz için tasarlanmış profesyonel araç seti.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="p-6 bg-slate-900 border border-slate-800 rounded-3xl space-y-2">
                <svg class="w-8 h-8 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/></svg>
                <h3 class="font-bold text-white text-lg">90 Gün Yasal Takip Sayacı</h3>
                <p class="text-sm text-slate-400 leading-relaxed">Her borcun gecikme gününü takip eder ve takibe kalan süreyi geri sayarak erken uyarı verir.</p>
            </div>

            <div class="p-6 bg-slate-900 border border-slate-800 rounded-3xl space-y-2">
                <svg class="w-8 h-8 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a.5.5 0 00.71 0L21.75 8M21.75 8H16.5m5.25 0v5.25"/></svg>
                <h3 class="font-bold text-white text-lg">Çığ (Avalanche) Motoru</h3>
                <p class="text-sm text-slate-400 leading-relaxed">En yüksek faiz oranına sahip KMH ve kartları önce eriten matematiksel planlama servisi.</p>
            </div>

            <div class="p-6 bg-slate-900 border border-slate-800 rounded-3xl space-y-2">
                <svg class="w-8 h-8 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/></svg>
                <h3 class="font-bold text-white text-lg">7/24 AI Finans Koçu</h3>
                <p class="text-sm text-slate-400 leading-relaxed">Groq & Gemini modelleriyle her sabah günün en kritik 3 hamlesini belirler.</p>
            </div>

            <div class="p-6 bg-slate-900 border border-slate-800 rounded-3xl space-y-2">
                <svg class="w-8 h-8 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 3h6m-6 3h6m-6 3h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5z"/></svg>
                <h3 class="font-bold text-white text-lg">Kart & KMH Mockup Görünümü</h3>
                <p class="text-sm text-slate-400 leading-relaxed">Tüm banka kartlarınızın dönem borçları ve limitlerini gerçekçi kart arayüzünde görün.</p>
            </div>

            <div class="p-6 bg-slate-900 border border-slate-800 rounded-3xl space-y-2">
                <svg class="w-8 h-8 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                <h3 class="font-bold text-white text-lg">Vade & Ödeme Takvimi</h3>
                <p class="text-sm text-slate-400 leading-relaxed">Ay bazında yaklaşan tüm ekstre, taksit ve plan ödemelerinizi tek takvimde inceleyin.</p>
            </div>

            <div class="p-6 bg-slate-900 border border-slate-800 rounded-3xl space-y-2">
                <svg class="w-8 h-8 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
                <h3 class="font-bold text-white text-lg">Faiz Maliyeti & Projeksiyon</h3>
                <p class="text-sm text-slate-400 leading-relaxed">Bankalara yıllık ödediğiniz toplam faiz yükünü ve borçlarınızın ne zaman biteceğini hesaplar.</p>
            </div>
        </div>
    </main>

    <x-public-footer />
</body>
</html>
