<!DOCTYPE html>
<html lang="tr" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DVT Bank CRM — 6 Banka, Tek Ekran, Kesin Çıkış Planı</title>
    <meta name="description" content="Kredi kartı, KMH ve kredi borçlarınızı tek merkezden yönetin. 90 gün yasal takip risk sayacı ve AI finansal koçunuzla krizden güvenle çıkın.">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-950 text-slate-100 antialiased selection:bg-indigo-600 selection:text-white">

    <!-- HEADER / NAVIGATION -->
    <header class="fixed top-0 left-0 right-0 z-50 bg-slate-950/80 backdrop-blur-md border-b border-slate-800/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="/" class="flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center font-black text-white text-xl shadow-lg shadow-indigo-600/30">
                    🏛️
                </div>
                <span class="font-black text-xl tracking-tight text-white">DVT<span class="text-indigo-400">BANK</span><span class="text-xs ml-1 px-1.5 py-0.5 rounded bg-indigo-950 border border-indigo-700 text-indigo-300">CRM</span></span>
            </a>

            <nav class="hidden md:flex items-center gap-8 text-sm font-semibold text-slate-300">
                <a href="#nasil-calisir" class="hover:text-white transition-colors">Nasıl Çalışır?</a>
                <a href="#ozellikler" class="hover:text-white transition-colors">Özellikler</a>
                <a href="#90-gun-kurali" class="hover:text-white transition-colors">90 Gün Kuralı</a>
                <a href="{{ route('pricing') }}" class="hover:text-white transition-colors">Fiyatlandırma</a>
                <a href="{{ route('faq') }}" class="hover:text-white transition-colors">SSS</a>
            </nav>

            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-sm rounded-xl shadow-lg shadow-indigo-600/30 transition-all">
                        Kontrol Panelim →
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 text-slate-300 hover:text-white font-bold text-sm transition-colors">
                        Giriş Yap
                    </a>
                    <a href="{{ route('register') }}" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-sm rounded-xl shadow-lg shadow-indigo-600/30 transition-all">
                        Ücretsiz Başla
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- HERO SECTION -->
    <section class="pt-36 pb-20 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto text-center relative overflow-hidden">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-indigo-950/80 border border-indigo-500/30 text-indigo-300 text-xs font-bold mb-6">
            <span>🛡️ Finansal Kriz ve Borç Yönetim Motoru</span>
        </div>

        <h1 class="text-4xl sm:text-6xl lg:text-7xl font-black tracking-tight text-white max-w-5xl mx-auto leading-[1.1]">
            6 Banka, Tüm Kartlar ve KMH’lar.<br>
            <span class="bg-gradient-to-r from-indigo-400 via-sky-300 to-indigo-200 bg-clip-text text-transparent">Tek Ekran, Kesin Çıkış Planı.</span>
        </h1>

        <p class="mt-6 text-base sm:text-xl text-slate-400 max-w-3xl mx-auto leading-relaxed">
            Kredi kartı dönem borçları, eksi hesaplar ve kredi taksitleri arasında kaybolmayın. 90 günlük yasal takip sayacı, matematiksel Çığ simülasyonu ve 7/24 AI Finans Koçu ile borçlarınızı adım adım sıfırlayın.
        </p>

        <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-4 bg-indigo-600 hover:bg-indigo-500 text-white font-black text-base rounded-2xl shadow-xl shadow-indigo-600/30 hover:scale-105 transition-all">
                Ücretsiz Borç Analizini Başlat →
            </a>
            <a href="#nasil-calisir" class="w-full sm:w-auto px-8 py-4 bg-slate-900 hover:bg-slate-800 text-slate-300 font-bold text-base rounded-2xl border border-slate-800 transition-all">
                Nasıl Çalıştığını İncele
            </a>
        </div>

        <!-- 6 BANKA SAYAÇ ÖNİZLEMESİ MOCKUP -->
        <div class="mt-16 bg-gradient-to-b from-slate-900 to-slate-950 border border-slate-800 rounded-3xl p-6 sm:p-10 shadow-2xl text-left max-w-5xl mx-auto relative">
            <div class="flex items-center justify-between border-b border-slate-800 pb-5">
                <div class="flex items-center gap-3">
                    <span class="w-3 h-3 rounded-full bg-red-500 animate-ping"></span>
                    <span class="font-bold text-sm text-slate-200">Kişisel Kriz Risk Göstergesi (Canlı Simülasyon)</span>
                </div>
                <span class="text-xs font-mono text-slate-500">BDDK & 90 Gün Kuralı Motoru</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-6">
                <div class="p-5 bg-slate-950/60 rounded-2xl border border-red-900/30">
                    <span class="text-xs font-bold text-red-400 block mb-1">TOPLAM RİSKTEKİ BORÇ</span>
                    <span class="text-3xl font-black text-red-500">₺545.000</span>
                    <p class="text-xs text-slate-400 mt-1">6 Banka · KMH + Kart + Kredi</p>
                </div>
                <div class="p-5 bg-slate-950/60 rounded-2xl border border-amber-900/30">
                    <span class="text-xs font-bold text-amber-400 block mb-1">BU AY ASGARİ / TAKSİT</span>
                    <span class="text-3xl font-black text-amber-400">₺118.500</span>
                    <p class="text-xs text-slate-400 mt-1">Aylık Asgari Yük</p>
                </div>
                <div class="p-5 bg-slate-950/60 rounded-2xl border border-indigo-900/30">
                    <span class="text-xs font-bold text-indigo-400 block mb-1">EN KRİTİK TAKİP SAYAÇ</span>
                    <span class="text-3xl font-black text-indigo-300">22 Gün Kaldı</span>
                    <p class="text-xs text-slate-400 mt-1">Yapı Kredi (68 gündür gecikmede)</p>
                </div>
            </div>
        </div>
    </section>

    <!-- NASIL ÇALIŞIR -->
    <section id="nasil-calisir" class="py-24 bg-slate-900/50 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl sm:text-4xl font-black text-white tracking-tight">3 Adımda Borç Sıkışmasından Çıkış</h2>
                <p class="mt-3 text-slate-400 text-base">Panik yok, matematik var. Sistemi adım adım çalıştırın.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="p-8 bg-slate-950 rounded-3xl border border-slate-800 space-y-4">
                    <span class="w-12 h-12 rounded-2xl bg-indigo-900/50 text-indigo-400 border border-indigo-700/40 flex items-center justify-center font-black text-lg">1</span>
                    <h3 class="font-bold text-xl text-white">Tüm Borçları Tek Listede Toplayın</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        Ziraat, Garanti, İş Bankası, Yapı Kredi, Akbank, Enpara... Tüm kart dönem borçlarını ve eksi KMH bakiyelerini saniyeler içinde girin.
                    </p>
                </div>

                <div class="p-8 bg-slate-950 rounded-3xl border border-slate-800 space-y-4">
                    <span class="w-12 h-12 rounded-2xl bg-indigo-900/50 text-indigo-400 border border-indigo-700/40 flex items-center justify-center font-black text-lg">2</span>
                    <h3 class="font-bold text-xl text-white">Çığ (Avalanche) Planınızı Alın</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        Aylık net bütçenizi belirleyin. Sistem en yüksek faizli ve yasal takibe en yakın borcu ilk hedef yaparak binlerce TL faiz tasarrufu sağlar.
                    </p>
                </div>

                <div class="p-8 bg-slate-950 rounded-3xl border border-slate-800 space-y-4">
                    <span class="w-12 h-12 rounded-2xl bg-indigo-900/50 text-indigo-400 border border-indigo-700/40 flex items-center justify-center font-black text-lg">3</span>
                    <h3 class="font-bold text-xl text-white">AI Koç ile Her Gün Yönetin</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        Her sabah yapay zeka koçunuz günün en kritik 3 aksiyonunu belirler, banka yapılandırma taktikleri ve vade uyarıları verir.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- 90 GÜN KURALI & HUKUKİ SAVUNMA HATTI -->
    <section id="90-gun-kurali" class="py-24 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="space-y-6">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-950/80 border border-red-500/30 text-red-300 text-xs font-bold">
                        ⚠️ Yasal Takip Eşiği
                    </div>
                    <h2 class="text-3xl sm:text-4xl font-black text-white tracking-tight leading-tight">
                        90 Gün Kuralını Bilin,<br>
                        Takibe Düşmeden Masaya Oturun.
                    </h2>
                    <p class="text-slate-400 text-base leading-relaxed">
                        Türkiye bankacılık mevzuatında borç 90 gün ödenmediğinde yasal takip ve icra süreci başlar. Öncesinde bankalar ihtarname çeker ve 7 günlük ek süre tanır. Bu süreyi asla kaçırmayın.
                    </p>
                    <ul class="space-y-3 text-sm text-slate-300 font-medium">
                        <li class="flex items-center gap-2">✓ <strong>Bankadan kaçmayın:</strong> Arayan borçlu ile bankalar 36-60 ay yapılandırma masasına oturur.</li>
                        <li class="flex items-center gap-2">✓ <strong>KMH'yı krediye çevirin:</strong> En yüksek faiz ek hesaplardadır; taksitli krediye aktarın.</li>
                        <li class="flex items-center gap-2">✓ <strong>Asgari ödemeyi köprü yapın:</strong> Asgari takibi öteler ama çözüm değildir, ana hedef borç kapamadır.</li>
                    </ul>
                </div>

                <div class="bg-slate-900 p-8 rounded-3xl border border-slate-800 space-y-4">
                    <h3 class="font-bold text-lg text-white">Yasal Takip Risk Algoritması</h3>
                    <div class="space-y-3 text-xs text-slate-300 font-mono">
                        <div class="p-3 bg-slate-950 rounded-xl border border-slate-800 flex justify-between items-center">
                            <span>0 - 45 Gün Gecikme</span>
                            <span class="text-emerald-400 font-bold">Normal / Uyarı Alanı</span>
                        </div>
                        <div class="p-3 bg-slate-950 rounded-xl border border-amber-800/40 flex justify-between items-center">
                            <span>46 - 65 Gün Gecikme</span>
                            <span class="text-amber-400 font-bold">İhtarname Eşiği</span>
                        </div>
                        <div class="p-3 bg-slate-950 rounded-xl border border-red-800/40 flex justify-between items-center">
                            <span>66 - 90 Gün Gecikme</span>
                            <span class="text-red-400 font-bold">ACİL KRİTİK YASAL TAKİP</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-slate-950 border-t border-slate-800/80 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-6">
            <div class="flex items-center justify-center gap-2">
                <span class="font-black text-xl text-white">DVT<span class="text-indigo-400">BANK</span> CRM</span>
            </div>

            <div class="flex flex-wrap justify-center gap-6 text-xs text-slate-400 font-medium">
                <a href="{{ route('legal.privacy') }}" class="hover:text-white">Gizlilik Politikası</a>
                <a href="{{ route('legal.kvkk') }}" class="hover:text-white">KVKK Aydınlatma Metni</a>
                <a href="{{ route('legal.terms') }}" class="hover:text-white">Kullanım Şartları</a>
                <a href="{{ route('legal.disclaimer') }}" class="hover:text-white">Sorumluluk Reddi</a>
                <a href="{{ route('contact') }}" class="hover:text-white">İletişim</a>
            </div>

            <div class="text-slate-500 text-xs max-w-2xl mx-auto leading-relaxed">
                ⚖️ <strong>Yasal Uyarı:</strong> DVT Bank CRM bir kişisel finans ve borç takip aracıdır. 6362 sayılı Sermaye Piyasası Kanunu kapsamında yatırım, kredi veya finansal danışmanlık hizmeti sunmaz.
            </div>

            <div class="text-slate-600 text-xs pt-4 border-t border-slate-900">
                © {{ date('Y') }} DVT Bank CRM (dvt.portegu.com). Tüm hakları saklıdır.
            </div>
        </div>
    </footer>
</body>
</html>
