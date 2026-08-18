<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sıkça Sorulan Sorular — DVT Bank CRM</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="bg-slate-950 text-slate-100 antialiased min-h-screen flex flex-col justify-between">
    <x-public-header />

    <main class="max-w-4xl mx-auto py-16 px-6 space-y-8 flex-1">
        <div class="text-center space-y-3">
            <h1 class="text-3xl sm:text-4xl font-black text-white tracking-tight">Sıkça Sorulan Sorular</h1>
            <p class="text-slate-400 text-sm">Borç kriz yönetimi, 90 gün kuralı ve platform hakkında merak edilenler.</p>
        </div>

        <div class="space-y-4">
            <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 space-y-2">
                <h3 class="font-bold text-base text-white">90 Gün Kuralı Tam Olarak Nedir?</h3>
                <p class="text-sm text-slate-300 leading-relaxed">
                    Türkiye bankacılık mevzuatında kredi veya kart borcunuz art arda 90 gün boyunca asgari dahi ödenmezse, banka alacağını yasal takibe aktarabilir ve avukata devredebilir. DVT Bank CRM risk sayacı her gün bu süreyi geri sayarak takibe düşmeden bankayla anlaşmanızı sağlar.
                </p>
            </div>

            <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 space-y-2">
                <h3 class="font-bold text-base text-white">KMH (Eksi Hesap / Ek Para) Neden En Tehlikeli Borçtur?</h3>
                <p class="text-sm text-slate-300 leading-relaxed">
                    KMH hesapları genellikle en yüksek akdi faiz ve vergi (KKDF + BSMV) yükünü taşır. Yapılandırılmadığı takdirde anaparayı eritmek imkansızlaşır. Sistemimiz ilk olarak KMH'ları taksitli krediye çevirmenizi önerir.
                </p>
            </div>

            <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 space-y-2">
                <h3 class="font-bold text-base text-white">Çığ (Avalanche) vs Kartopu (Snowball) Arasındaki Fark Nedir?</h3>
                <p class="text-sm text-slate-300 leading-relaxed">
                    Çığ yöntemi en yüksek faiz oranına sahip borca odaklanarak toplamda en az faizi ödemenizi sağlar (matematiksel kazanç). Kartopu ise en küçük borçtan başlayarak hızla borç kalemlerini sıfırlamanıza odaklanır (psikolojik rahatlama).
                </p>
            </div>

            <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 space-y-2">
                <h3 class="font-bold text-base text-white">Bankalarla Anlaşırken Nelere Dikkat Etmeliyim?</h3>
                <p class="text-sm text-slate-300 leading-relaxed">
                    Bankadan kaçmamak en kritik kuraldır. Bankanın yapılandırma masasını arayarak 36 ila 60 ay vade talep edebilir, birden fazla borcunuzu tek bir taksitli kredide birleştirmeyi isteyebilirsiniz.
                </p>
            </div>
        </div>
    </main>

    <x-public-footer />
</body>
</html>
