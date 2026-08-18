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
                <span class="text-2xl">⚡</span>
                <h3 class="font-bold text-white text-lg">90 Gün Yasal Takip Sayacı</h3>
                <p class="text-sm text-slate-400 leading-relaxed">Her borcun gecikme gününü takip eder ve takibe kalan süreyi geri sayarak erken uyarı verir.</p>
            </div>

            <div class="p-6 bg-slate-900 border border-slate-800 rounded-3xl space-y-2">
                <span class="text-2xl">🏔️</span>
                <h3 class="font-bold text-white text-lg">Çığ (Avalanche) Motoru</h3>
                <p class="text-sm text-slate-400 leading-relaxed">En yüksek faiz oranına sahip KMH ve kartları önce eriten matematiksel planlama servisi.</p>
            </div>

            <div class="p-6 bg-slate-900 border border-slate-800 rounded-3xl space-y-2">
                <span class="text-2xl">🤖</span>
                <h3 class="font-bold text-white text-lg">7/24 AI Finans Koçu</h3>
                <p class="text-sm text-slate-400 leading-relaxed">Groq & Gemini modelleriyle her sabah günün en kritik 3 hamlesini belirler.</p>
            </div>

            <div class="p-6 bg-slate-900 border border-slate-800 rounded-3xl space-y-2">
                <span class="text-2xl">💳</span>
                <h3 class="font-bold text-white text-lg">Kart & KMH Mockup Görünümü</h3>
                <p class="text-sm text-slate-400 leading-relaxed">Tüm banka kartlarınızın dönem borçları ve limitlerini gerçekçi kart arayüzünde görün.</p>
            </div>

            <div class="p-6 bg-slate-900 border border-slate-800 rounded-3xl space-y-2">
                <span class="text-2xl">🗓️</span>
                <h3 class="font-bold text-white text-lg">Vade & Ödeme Takvimi</h3>
                <p class="text-sm text-slate-400 leading-relaxed">Ay bazında yaklaşan tüm ekstre, taksit ve plan ödemelerinizi tek takvimde inceleyin.</p>
            </div>

            <div class="p-6 bg-slate-900 border border-slate-800 rounded-3xl space-y-2">
                <span class="text-2xl">📊</span>
                <h3 class="font-bold text-white text-lg">Faiz Maliyeti & Projeksiyon</h3>
                <p class="text-sm text-slate-400 leading-relaxed">Bankalara yıllık ödediğiniz toplam faiz yükünü ve borçlarınızın ne zaman biteceğini hesaplar.</p>
            </div>
        </div>
    </main>

    <x-public-footer />
</body>
</html>
