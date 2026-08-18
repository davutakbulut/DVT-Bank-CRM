<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nasıl Çalışır? — DVT Bank CRM</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="bg-slate-950 text-slate-100 antialiased">
    <header class="h-20 border-b border-slate-800 flex items-center justify-between px-6 max-w-7xl mx-auto">
        <a href="/" class="font-black text-xl text-white">DVT<span class="text-indigo-400">BANK</span> CRM</a>
        <a href="{{ route('register') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-sm rounded-xl">Ücretsiz Başla</a>
    </header>

    <main class="max-w-4xl mx-auto py-16 px-6 space-y-12">
        <div class="text-center space-y-3">
            <h1 class="text-4xl font-black text-white tracking-tight">DVT Bank CRM Nasıl Çalışır?</h1>
            <p class="text-slate-400 text-base">Borçları tek merkezde toplayıp adım adım eritmenin formülü.</p>
        </div>

        <div class="space-y-8">
            <div class="p-8 bg-slate-900 border border-slate-800 rounded-3xl space-y-3">
                <span class="text-xs font-bold text-indigo-400 uppercase">Adım 1</span>
                <h2 class="text-xl font-bold text-white">Onboarding ile 6 Bankanın Envanterini Çıkarın</h2>
                <p class="text-sm text-slate-300 leading-relaxed">
                    Sisteme kayıt olduğunuzda 4 adımlı sihirbaz sizi karşılar. Bankalarınızı, kart dönem borçlarınızı, KMH eksi bakiyelerinizi ve kredi taksitlerinizi tanımlarsınız.
                </p>
            </div>

            <div class="p-8 bg-slate-900 border border-slate-800 rounded-3xl space-y-3">
                <span class="text-xs font-bold text-indigo-400 uppercase">Adım 2</span>
                <h2 class="text-xl font-bold text-white">90 Günlük Yasal Takip Sayacıyla Acil Riskleri Önleyin</h2>
                <p class="text-sm text-slate-300 leading-relaxed">
                    Sistem her borç için takibe kalan gün sayısını hesaplar. 90 güne en yakın borç en üstte alarm vererek yasal takibe düşmeden bankayla yapılandırma yapmanızı sağlar.
                </p>
            </div>

            <div class="p-8 bg-slate-900 border border-slate-800 rounded-3xl space-y-3">
                <span class="text-xs font-bold text-indigo-400 uppercase">Adım 3</span>
                <h2 class="text-xl font-bold text-white">Çığ (Avalanche) Algoritması ile Faiz Yükünü Azaltın</h2>
                <p class="text-sm text-slate-300 leading-relaxed">
                    Aylık gelir ve sabit giderlerinizin ardından kalan bütçe, en yüksek faizli KMH ve kartlara aktarılır. Bu yöntemle gereksiz faiz ödemekten kurtulursunuz.
                </p>
            </div>

            <div class="p-8 bg-slate-900 border border-slate-800 rounded-3xl space-y-3">
                <span class="text-xs font-bold text-indigo-400 uppercase">Adım 4</span>
                <h2 class="text-xl font-bold text-white">AI Koç ile Her Gün Durumunuzu Takip Edin</h2>
                <p class="text-sm text-slate-300 leading-relaxed">
                    Her sabah saat 07:00'de çalışan yapay zeka motoru durumunuzu analiz eder, günün en önemli 3 aksiyonunu belirler ve 7/24 sorularınızı yanıtlar.
                </p>
            </div>
        </div>
    </main>
</body>
</html>
