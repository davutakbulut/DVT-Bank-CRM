<!DOCTYPE html>
<html lang="tr" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DVT Bank CRM — 6 Banka, Tüm Borçlar, Matematiksel Kesin Çıkış Planı</title>
    <meta name="description" content="Kredi kartı, KMH eksi bakiyeleri ve kredilerinizi tek merkezden yönetin. 90 gün yasal takip sayacı, Çığ algoritması ve 7/24 AI finans koçu ile borç krizinden güvenle çıkın.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }
        
        /* 3D Perspective Container */
        .perspective-container {
            perspective: 1200px;
        }

        /* 3D Card Base with Smooth Physics */
        .card-3d {
            transform-style: preserve-3d;
            transition: transform 0.4s cubic-bezier(0.25, 1, 0.5, 1), box-shadow 0.4s ease;
            will-change: transform;
        }

        /* Ambient Glow Animations */
        @keyframes float-slow {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-12px) rotate(1.5deg); }
        }

        @keyframes pulse-glow {
            0%, 100% { opacity: 0.35; transform: scale(1); }
            50% { opacity: 0.65; transform: scale(1.08); }
        }

        .animate-float-1 { animation: float-slow 7s ease-in-out infinite; }
        .animate-float-2 { animation: float-slow 9s ease-in-out 1.5s infinite; }
        .animate-float-3 { animation: float-slow 8s ease-in-out 3s infinite; }
        .animate-glow { animation: pulse-glow 6s ease-in-out infinite; }

        /* Holographic Shimmer Effect */
        .hologram-card {
            background: linear-gradient(135deg, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0.02) 50%, rgba(255,255,255,0.1) 100%);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.12);
        }

        /* Scroll reveal class */
        .reveal-on-scroll {
            opacity: 0;
            transform: translateY(40px) scale(0.96);
            transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .reveal-on-scroll.is-revealed {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    </style>
</head>
<body class="bg-slate-950 text-slate-100 antialiased selection:bg-indigo-600 selection:text-white min-h-screen flex flex-col justify-between overflow-x-hidden">

    <!-- UNIFIED PUBLIC HEADER -->
    <x-public-header />

    <main class="flex-1">
        <!-- ========================================================================= -->
        <!-- 1. APPLE-STYLE HERO SECTION (3D ORBIT & FLOATING CARDS)                  -->
        <!-- ========================================================================= -->
        <section class="relative pt-24 pb-32 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto text-center perspective-container overflow-hidden">
            <!-- Background Glow Orbs -->
            <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[650px] h-[650px] bg-indigo-600/20 rounded-full blur-[140px] pointer-events-none animate-glow"></div>
            <div class="absolute top-1/3 left-1/4 w-[450px] h-[450px] bg-purple-600/15 rounded-full blur-[120px] pointer-events-none animate-glow" style="animation-delay: 2s;"></div>
            <div class="absolute top-1/3 right-1/4 w-[450px] h-[450px] bg-emerald-600/15 rounded-full blur-[120px] pointer-events-none animate-glow" style="animation-delay: 4s;"></div>

            <!-- Top Pill Badge -->
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-indigo-950/80 border border-indigo-500/30 text-indigo-300 text-xs font-bold mb-8 shadow-xl shadow-indigo-950/50 backdrop-blur-md">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span>TÜRKİYE BANKACILIK MEVZUATI & 90 GÜN KURALI MOTORU</span>
            </div>

            <!-- Massive Display Header -->
            <h1 class="text-5xl sm:text-7xl lg:text-8xl font-black tracking-tight text-white max-w-5xl mx-auto leading-[1.05]">
                Finansal Krizden<br>
                <span class="bg-gradient-to-r from-indigo-400 via-sky-300 to-emerald-300 bg-clip-text text-transparent">Matematiksel Çıkış.</span>
            </h1>

            <p class="mt-8 text-lg sm:text-2xl text-slate-300 max-w-3xl mx-auto font-normal leading-relaxed">
                6 bankanın kredi kartları, KMH eksi bakiyeleri ve kredi taksitleri arasında boğulmayın. Sıfır panik, doğrudan veritabanı ve 7/24 AI koç ile borçlarınızı adım adım sıfırlayın.
            </p>

            <!-- Call to Actions -->
            <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('register') }}" class="w-full sm:w-auto px-9 py-4 bg-indigo-600 hover:bg-indigo-500 text-white font-black text-base rounded-2xl shadow-2xl shadow-indigo-600/40 hover:scale-105 active:scale-95 transition-all flex items-center justify-center gap-2 group">
                    <span>Ücretsiz Borç Analizini Başlat</span>
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                </a>
                <a href="#nasil-calisir" class="w-full sm:w-auto px-8 py-4 bg-slate-900/90 hover:bg-slate-800 text-slate-300 hover:text-white font-bold text-base rounded-2xl border border-slate-800 shadow-lg backdrop-blur-md transition-all">
                    Stratejiyi İncele ↓
                </a>
            </div>

            <!-- ========================================================================= -->
            <!-- 3D FLOATING APPLE-STYLE CARD DECK (ROTATING & TILTING)                   -->
            <!-- ========================================================================= -->
            <div class="mt-20 relative max-w-5xl mx-auto min-h-[420px] sm:min-h-[480px] flex items-center justify-center">
                
                <!-- Card 1: Garanti BBVA (Sol Üst - Eğimli) -->
                <div id="card-garanti" class="card-3d absolute -left-2 sm:left-4 top-4 w-64 sm:w-80 p-5 sm:p-6 rounded-3xl bg-gradient-to-br from-emerald-950 via-slate-900 to-slate-950 border border-emerald-500/30 shadow-2xl text-left transform -rotate-6 sm:-rotate-12 -translate-y-4 hover:rotate-0 hover:scale-105 transition-all duration-500 z-20 animate-float-1">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-black uppercase tracking-wider text-emerald-400">Garanti BBVA</span>
                        <div class="w-8 h-5 rounded bg-amber-400/80 border border-amber-300 font-mono text-[9px] font-bold flex items-center justify-center text-amber-950">CHIP</div>
                    </div>
                    <div class="my-4">
                        <span class="font-mono text-sm tracking-widest text-slate-300">•••• •••• •••• 8412</span>
                        <div class="mt-2 inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30">
                            ⏳ 18 Gündür Gecikmede
                        </div>
                    </div>
                    <div class="pt-3 border-t border-slate-800 flex justify-between items-end">
                        <div>
                            <span class="text-[10px] text-slate-400 block font-semibold">DÖNEM BORCU</span>
                            <span class="text-xl font-black text-red-400">₺78.450</span>
                        </div>
                        <span class="text-xs font-bold text-slate-400">Asgari: ₺31.380</span>
                    </div>
                </div>

                <!-- Card 2: Yapı Kredi KMH (Sağ Üst - Eğimli) -->
                <div id="card-yapi-kredi" class="card-3d absolute -right-2 sm:right-4 top-8 w-64 sm:w-80 p-5 sm:p-6 rounded-3xl bg-gradient-to-br from-blue-950 via-slate-900 to-slate-950 border border-blue-500/30 shadow-2xl text-left transform rotate-6 sm:rotate-12 translate-y-2 hover:rotate-0 hover:scale-105 transition-all duration-500 z-20 animate-float-2">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-black uppercase tracking-wider text-blue-400">Yapı Kredi • Esnek Hesap</span>
                        <span class="px-2 py-0.5 rounded-md bg-red-500/20 text-red-300 border border-red-500/30 text-[10px] font-black">FAİZ: %5.00</span>
                    </div>
                    <div class="my-4">
                        <span class="text-xs text-slate-400 block font-semibold">EK HESAP / EKSİ BAKİYE</span>
                        <span class="text-2xl font-black text-red-500">-₺65.000</span>
                    </div>
                    <div class="pt-3 border-t border-slate-800 flex justify-between items-center text-xs">
                        <span class="text-slate-400">Aylık Faiz Yükü:</span>
                        <span class="font-bold text-red-400">₺3.250 / ay</span>
                    </div>
                </div>

                <!-- Card 3: Ana Dashboard Önizleme Paneli (Merkez & Geniş) -->
                <div id="card-center-dashboard" class="card-3d relative w-full max-w-xl p-6 sm:p-8 rounded-3xl bg-slate-900/90 border-2 border-indigo-500/40 shadow-2xl shadow-indigo-950/80 backdrop-blur-2xl text-left z-30 transform hover:scale-[1.02] transition-all duration-500">
                    <div class="flex items-center justify-between border-b border-slate-800 pb-4">
                        <div class="flex items-center gap-3">
                            <span class="w-3 h-3 rounded-full bg-red-500 animate-ping"></span>
                            <div>
                                <h3 class="font-bold text-sm text-white">Canlı Risk Analizi & Sayaç</h3>
                                <p class="text-[11px] text-slate-400">6 Banka Aktif Takipte</p>
                            </div>
                        </div>
                        <span class="px-2.5 py-1 rounded-lg bg-red-500/20 text-red-300 text-xs font-black border border-red-500/30">
                            🚨 Yasal Takibe 24 Gün Kaldı
                        </span>
                    </div>

                    <div class="grid grid-cols-2 gap-4 my-6">
                        <div class="p-4 rounded-2xl bg-slate-950/80 border border-slate-800">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">TOPLAM BORÇ YÜKÜ</span>
                            <span class="text-2xl font-black text-white mt-1 block">₺485.200</span>
                            <span class="text-[11px] text-emerald-400 font-semibold">↓ Çığ ile ₺62.000 Tasarruf</span>
                        </div>
                        <div class="p-4 rounded-2xl bg-slate-950/80 border border-slate-800">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">TAHMİNİ BORÇSUZLUK</span>
                            <span class="text-2xl font-black text-indigo-400 mt-1 block">14 Ay</span>
                            <span class="text-[11px] text-slate-400">Sabit Ödeme Disiplini</span>
                        </div>
                    </div>

                    <!-- AI Coach Insight Strip -->
                    <div class="p-3.5 rounded-xl bg-indigo-950/40 border border-indigo-500/30 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center text-sm shrink-0">🤖</div>
                        <p class="text-xs text-indigo-200 leading-snug">
                            <strong>AI Koç Önerisi:</strong> "Yapı Kredi KMH faizi en yüksek (%5.0). Bu ay fazladan ₺8.000 buraya aktarılırsa ₺4.800 faiz silinecektir."
                        </p>
                    </div>
                </div>

                <!-- Card 4: Ziraat Bankası Kredi (Sol Alt - Eğimli) -->
                <div id="card-ziraat" class="card-3d absolute -left-4 sm:left-12 -bottom-6 w-60 sm:w-72 p-4 sm:p-5 rounded-2xl bg-gradient-to-br from-red-950 via-slate-900 to-slate-950 border border-red-500/30 shadow-2xl text-left transform rotate-3 sm:rotate-6 z-10 animate-float-3 hidden md:block">
                    <span class="text-xs font-black uppercase text-red-400 block">Ziraat Bankası • İhtiyaç Kredisi</span>
                    <span class="text-lg font-black text-white mt-1 block">Kalan: ₺140.000</span>
                    <span class="text-[11px] text-slate-400">Taksit: ₺7.200 / ay (24 Taksit Kaldı)</span>
                </div>

                <!-- Card 5: Akbank Kart (Sağ Alt - Eğimli) -->
                <div id="card-akbank" class="card-3d absolute -right-4 sm:right-12 -bottom-6 w-60 sm:w-72 p-4 sm:p-5 rounded-2xl bg-gradient-to-br from-rose-950 via-slate-900 to-slate-950 border border-rose-500/30 shadow-2xl text-left transform -rotate-3 sm:-rotate-6 z-10 animate-float-1 hidden md:block">
                    <span class="text-xs font-black uppercase text-rose-400 block">Akbank • Wings Kart</span>
                    <span class="text-lg font-black text-white mt-1 block">Dönem Borcu: ₺52.000</span>
                    <span class="text-[11px] text-amber-400 font-bold">⚠️ Son Ödeme: 4 Gün Kaldı</span>
                </div>
            </div>
        </section>

        <!-- ========================================================================= -->
        <!-- 2. SCROLLYTELLING: 90 GÜN YASAL TAKİP ERKEN UYARI SİSTEMİ                -->
        <!-- ========================================================================= -->
        <section id="90-gun-kurali" class="py-24 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto border-t border-slate-800/80">
            <div class="text-center space-y-4 max-w-3xl mx-auto reveal-on-scroll">
                <span class="text-xs font-bold uppercase tracking-wider text-red-400 bg-red-950/60 border border-red-800/50 px-3 py-1 rounded-full">
                    🚨 BDDK MEVZUATI & YASAL TAKİP BARAJI
                </span>
                <h2 class="text-4xl sm:text-5xl font-black text-white tracking-tight">
                    90 Günlük Yasal Takip Sayacı:<br>
                    <span class="text-red-400">Gecikmeden Masaya Oturun.</span>
                </h2>
                <p class="text-base sm:text-lg text-slate-300 leading-relaxed">
                    Borç 90 gün ödenmediğinde banka alacağı yasal takibe aktarabilir ve avukata devredebilir. Öncesinde ihtarname ve genellikle 7 günlük ek süre vardır. DVT Bank CRM, her borcunuzun süresini anbean hesaplayarak sizi takibe düşmeden uyarır.
                </p>
            </div>

            <!-- 4 Aşamalı Risk Zaman Çizelgesi -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-16">
                <!-- 1. Evre -->
                <div class="p-6 rounded-3xl bg-slate-900 border border-slate-800 hover:border-slate-700 transition-all reveal-on-scroll space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-slate-800 text-slate-300 font-black text-sm flex items-center justify-center">
                        01
                    </div>
                    <h3 class="text-lg font-bold text-white">1 - 30. Gün: Akdi Faiz</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Son ödeme tarihi geçti. Banka gecikme faizi işletmeye başlar. Bu evrede asgari tutarı ödemek veya bankayı arayıp yapılandırma talep etmek en kolay dönemdir.
                    </p>
                    <span class="inline-block text-[11px] font-bold text-emerald-400">Durum: Düşük Risk</span>
                </div>

                <!-- 2. Evre -->
                <div class="p-6 rounded-3xl bg-slate-900 border border-slate-800 hover:border-slate-700 transition-all reveal-on-scroll space-y-3" style="transition-delay: 150ms;">
                    <div class="w-10 h-10 rounded-xl bg-amber-950 text-amber-400 border border-amber-800/50 font-black text-sm flex items-center justify-center">
                        02
                    </div>
                    <h3 class="text-lg font-bold text-white">31 - 60. Gün: İdari Takip</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Banka çağrı merkezi ve tahsilat birimi aramaya başlar. Kredi kartları kullanıma kapatılabilir. Henüz avukata devir yoktur; pazarlık şansı çok yüksektir.
                    </p>
                    <span class="inline-block text-[11px] font-bold text-amber-400">Durum: Orta Risk</span>
                </div>

                <!-- 3. Evre -->
                <div class="p-6 rounded-3xl bg-slate-900 border border-slate-800 hover:border-slate-700 transition-all reveal-on-scroll space-y-3" style="transition-delay: 300ms;">
                    <div class="w-10 h-10 rounded-xl bg-orange-950 text-orange-400 border border-orange-800/50 font-black text-sm flex items-center justify-center">
                        03
                    </div>
                    <h3 class="text-lg font-bold text-white">61 - 89. Gün: İhtarname</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Noter kanalıyla veya SMS/E-posta ile son ödeme ihtarı çekilir. 7 günlük ek süre tanınır. Bu evre yasal takipten önceki **son çıkış kapısıdır**.
                    </p>
                    <span class="inline-block text-[11px] font-bold text-orange-400">Durum: Yüksek Risk</span>
                </div>

                <!-- 4. Evre -->
                <div class="p-6 rounded-3xl bg-red-950/40 border border-red-600/50 hover:border-red-500 transition-all reveal-on-scroll space-y-3 shadow-xl" style="transition-delay: 450ms;">
                    <div class="w-10 h-10 rounded-xl bg-red-600 text-white font-black text-sm flex items-center justify-center animate-pulse">
                        90+
                    </div>
                    <h3 class="text-lg font-bold text-red-400">90. Gün: İcra & Avukat</h3>
                    <p class="text-xs text-slate-300 leading-relaxed">
                        Dosya bankanın hukuk birimine veya varlık yönetim şirketine devredilir. İcra takibi başlar ve avukatlık/vekalet ücretleri borca eklenir.
                    </p>
                    <span class="inline-block text-[11px] font-black text-red-400">DVT CRM Seni Buraya Bırakmaz!</span>
                </div>
            </div>
        </section>

        <!-- ========================================================================= -->
        <!-- 3. ALGORİTMİK ÇÖZÜM: ÇIĞ (AVALANCHE) & KARTOPU (SNOWBALL) MOTORU           -->
        <!-- ========================================================================= -->
        <section id="nasil-calisir" class="py-24 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto border-t border-slate-800/80">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="space-y-6 reveal-on-scroll">
                    <span class="text-xs font-bold uppercase tracking-wider text-indigo-400 bg-indigo-950/60 border border-indigo-800/50 px-3 py-1 rounded-full">
                        🏔️ MATEMATİKSEL KURTARMA STRATEJİSİ
                    </span>
                    <h2 class="text-4xl sm:text-5xl font-black text-white tracking-tight">
                        Asgari Ödeme Kısır Döngüsünü Kırın.
                    </h2>
                    <p class="text-base sm:text-lg text-slate-300 leading-relaxed">
                        Her ay sadece asgari tutarı ödemek borcu bitirmez; sadece faizi besler. DVT Bank CRM, gelirinizi ve sabit giderlerinizi düşerek kalan serbest bütçeyi **Çığ (Avalanche)** algoritmasıyla en yüksek faizli KMH ve kartlara odaklar.
                    </p>

                    <div class="space-y-4 pt-2">
                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-xs font-bold shrink-0 mt-0.5">✓</div>
                            <div>
                                <h4 class="font-bold text-white text-sm">Çığ (Avalanche) Yöntemi:</h4>
                                <p class="text-xs text-slate-400 mt-0.5">Faiz oranı en yüksek (%5.0 KMH veya %4.25 Kart) borcu önce sıfırlayarak toplamda en az faizi ödetir.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 rounded-full bg-indigo-500/20 text-indigo-400 flex items-center justify-center text-xs font-bold shrink-0 mt-0.5">✓</div>
                            <div>
                                <h4 class="font-bold text-white text-sm">Kartopu (Snowball) Yöntemi:</h4>
                                <p class="text-xs text-slate-400 mt-0.5">En küçük bakiyeli borcu ilk kapatıp banka sayısını 6'dan 3'e, 2'ye hızla indirerek psikolojik rahatlama sağlar.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Karşılaştırma Grafiği / Tablosu -->
                <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 sm:p-8 space-y-6 shadow-2xl reveal-on-scroll">
                    <h3 class="text-sm font-bold uppercase tracking-wider text-slate-400 border-b border-slate-800 pb-3">
                        Simülasyon: ₺400.000 Borç İçin 2 Farklı Senaryo
                    </h3>

                    <!-- Senaryo 1: Rastgele / Asgari -->
                    <div class="p-4 rounded-2xl bg-red-950/30 border border-red-900/40 space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="text-xs font-bold text-red-400">Rastgele / Sadece Asgari Ödeme</span>
                            <span class="text-xs font-bold text-red-400">42 Ay Sürer</span>
                        </div>
                        <div class="w-full bg-slate-800 h-3 rounded-full overflow-hidden">
                            <div class="bg-red-500 h-full w-[90%]"></div>
                        </div>
                        <p class="text-xs text-slate-400">Toplam Ödenen Faiz: <strong class="text-red-400">₺240.000+</strong></p>
                    </div>

                    <!-- Senaryo 2: DVT Bank CRM Çığ Algoritması -->
                    <div class="p-4 rounded-2xl bg-emerald-950/30 border border-emerald-900/40 space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="text-xs font-bold text-emerald-400">DVT Bank CRM Çığ Algoritması</span>
                            <span class="text-xs font-bold text-emerald-400">16 Ayda Biter</span>
                        </div>
                        <div class="w-full bg-slate-800 h-3 rounded-full overflow-hidden">
                            <div class="bg-emerald-500 h-full w-[38%]"></div>
                        </div>
                        <p class="text-xs text-slate-300">Toplam Ödenen Faiz: <strong class="text-emerald-400">₺82.000</strong> (₺158.000 Cepte Kalır!)</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ========================================================================= -->
        <!-- 4. 7/24 AI FİNANSAL KRİZ KOÇU                                             -->
        <!-- ========================================================================= -->
        <section id="ozellikler" class="py-24 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto border-t border-slate-800/80">
            <div class="text-center space-y-4 max-w-3xl mx-auto reveal-on-scroll">
                <span class="text-xs font-bold uppercase tracking-wider text-indigo-400 bg-indigo-950/60 border border-indigo-800/50 px-3 py-1 rounded-full">
                    🤖 YENİ NESİL ÇOKLU SAĞLAYICILI AI MOTORU
                </span>
                <h2 class="text-4xl sm:text-5xl font-black text-white tracking-tight">
                    Her Sabah 07:00'de<br>
                    <span class="text-indigo-400">Günün 3 Kritik Hamlesi Cebinizde.</span>
                </h2>
                <p class="text-base sm:text-lg text-slate-300 leading-relaxed">
                    Llama 3.3 (Groq), Gemini Flash ve OpenRouter modelleriyle güçlendirilmiş koçunuz, veritabanınızdaki borç ve vadeleri tarar; her gün panik yapmadan atacağınız en doğru finansal adımları listeler.
                </p>
            </div>

            <!-- AI Chat & Günlük Öneri Simülasyon Arayüzü -->
            <div class="mt-16 max-w-3xl mx-auto bg-slate-900 border border-slate-800 rounded-3xl p-6 sm:p-8 shadow-2xl space-y-6 reveal-on-scroll">
                <!-- AI Mesajı -->
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-2xl bg-indigo-600 flex items-center justify-center font-bold text-white text-lg shrink-0 shadow-lg shadow-indigo-600/30">
                        🤖
                    </div>
                    <div class="bg-slate-950 border border-slate-800 rounded-2xl p-5 text-sm space-y-3">
                        <div class="flex items-center justify-between border-b border-slate-800 pb-2">
                            <span class="font-bold text-indigo-300 text-xs uppercase tracking-wider">Günün 3 Kritik Hamlesi (Sabah Brifingi)</span>
                            <span class="text-[10px] text-slate-500 font-mono">07:00 • Otomatik Üretildi</span>
                        </div>
                        <ul class="space-y-2 text-slate-300 text-xs sm:text-sm">
                            <li class="flex items-start gap-2">
                                <span class="font-bold text-indigo-400">1.</span>
                                <span><strong>Akbank Wings Kartı:</strong> Asgari ödeme son gününe 4 gün kaldı. Gecikme faizine girmemek için en az ₺12.000 yatırın.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="font-bold text-indigo-400">2.</span>
                                <span><strong>Yapı Kredi KMH:</strong> Faiz oranı %5.0 ile en yüksek kaleminiz. Maaş yattığında ilk ₺6.000 fazlayı buraya aktarın.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="font-bold text-indigo-400">3.</span>
                                <span><strong>Garanti Yapılandırma Masası:</strong> 25 gündür gecikmede olan krediniz için şubeyi arayıp 36 ay yapılandırma teklifi isteyin.</span>
                            </li>
                        </ul>
                        <div class="pt-2 border-t border-slate-900 text-[11px] text-slate-500 italic">
                            ⚖️ Bu bir bilgilendirme ve stratejik takip tavsiyesidir; resmi finansal danışmanlık değildir.
                        </div>
                    </div>
                </div>

                <!-- Kullanıcı Sorusu -->
                <div class="flex items-start gap-4 justify-end">
                    <div class="bg-indigo-600 text-white rounded-2xl p-4 text-xs sm:text-sm max-w-lg">
                        "Elimde fazladan ₺15.000 var, 6 bankamdan hangisine yatırırsam en çok faizden tasarruf ederim?"
                    </div>
                    <div class="w-10 h-10 rounded-2xl bg-slate-800 text-slate-300 flex items-center justify-center font-bold text-sm shrink-0">
                        DA
                    </div>
                </div>
            </div>
        </section>

        <!-- ========================================================================= -->
        <!-- 5. 6 BANKA TAM ENTEGRASYON VE DOĞRUDAN VERİTABANI                         -->
        <!-- ========================================================================= -->
        <section class="py-24 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto border-t border-slate-800/80">
            <div class="text-center space-y-4 max-w-3xl mx-auto reveal-on-scroll">
                <span class="text-xs font-bold uppercase tracking-wider text-emerald-400 bg-emerald-950/60 border border-emerald-800/50 px-3 py-1 rounded-full">
                    🛡️ SIFIR SAHTE VERİ & DOĞRUDAN VERİTABANI
                </span>
                <h2 class="text-4xl sm:text-5xl font-black text-white tracking-tight">
                    Türkiye'deki Tüm Bankalarla Uyumlu.
                </h2>
                <p class="text-base sm:text-lg text-slate-300 leading-relaxed">
                    Sistemde hiçbir sahte veya mock veri yer almaz. Eklediğiniz her kart ve borç doğrudan MySQL veritabanına yazılır, matematiksel formüllerle anlık işlenir.
                </p>
            </div>

            <!-- 6 Banka Kartı Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 mt-16">
                <div class="p-5 rounded-2xl bg-slate-900 border border-slate-800 text-center space-y-2 hover:border-emerald-500 transition-all hover:scale-105">
                    <div class="w-10 h-10 rounded-xl bg-[#008543] text-white font-bold flex items-center justify-center mx-auto text-xs">GB</div>
                    <h4 class="font-bold text-white text-xs">Garanti BBVA</h4>
                    <span class="text-[10px] text-slate-400 block">Kart + KMH + Kredi</span>
                </div>

                <div class="p-5 rounded-2xl bg-slate-900 border border-slate-800 text-center space-y-2 hover:border-blue-500 transition-all hover:scale-105">
                    <div class="w-10 h-10 rounded-xl bg-[#0a2f6e] text-white font-bold flex items-center justify-center mx-auto text-xs">YK</div>
                    <h4 class="font-bold text-white text-xs">Yapı Kredi</h4>
                    <span class="text-[10px] text-slate-400 block">World + Esnek</span>
                </div>

                <div class="p-5 rounded-2xl bg-slate-900 border border-slate-800 text-center space-y-2 hover:border-red-500 transition-all hover:scale-105">
                    <div class="w-10 h-10 rounded-xl bg-[#e30613] text-white font-bold flex items-center justify-center mx-auto text-xs">ZB</div>
                    <h4 class="font-bold text-white text-xs">Ziraat Bankası</h4>
                    <span class="text-[10px] text-slate-400 block">Bankkart + Avans</span>
                </div>

                <div class="p-5 rounded-2xl bg-slate-900 border border-slate-800 text-center space-y-2 hover:border-blue-600 transition-all hover:scale-105">
                    <div class="w-10 h-10 rounded-xl bg-[#002855] text-white font-bold flex items-center justify-center mx-auto text-xs">İŞ</div>
                    <h4 class="font-bold text-white text-xs">İş Bankası</h4>
                    <span class="text-[10px] text-slate-400 block">Maximum + Ek</span>
                </div>

                <div class="p-5 rounded-2xl bg-slate-900 border border-slate-800 text-center space-y-2 hover:border-red-600 transition-all hover:scale-105">
                    <div class="w-10 h-10 rounded-xl bg-[#e31e24] text-white font-bold flex items-center justify-center mx-auto text-xs">AK</div>
                    <h4 class="font-bold text-white text-xs">Akbank</h4>
                    <span class="text-[10px] text-slate-400 block">Axess + Artı Para</span>
                </div>

                <div class="p-5 rounded-2xl bg-slate-900 border border-slate-800 text-center space-y-2 hover:border-purple-500 transition-all hover:scale-105">
                    <div class="w-10 h-10 rounded-xl bg-[#732582] text-white font-bold flex items-center justify-center mx-auto text-xs">EN</div>
                    <h4 class="font-bold text-white text-xs">Enpara / QNB</h4>
                    <span class="text-[10px] text-slate-400 block">Kredisiz Masrafsız</span>
                </div>
            </div>
        </section>

        <!-- ========================================================================= -->
        <!-- 6. BÜYÜK CALL TO ACTION BANNER (APPLE-STYLE)                               -->
        <!-- ========================================================================= -->
        <section class="py-24 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
            <div class="relative rounded-3xl bg-gradient-to-r from-indigo-900 via-indigo-950 to-slate-900 border-2 border-indigo-500/50 p-8 sm:p-16 text-center space-y-8 overflow-hidden shadow-2xl shadow-indigo-950">
                <div class="absolute top-0 right-0 w-96 h-96 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>

                <div class="space-y-4 max-w-2xl mx-auto relative z-10">
                    <span class="text-xs font-black uppercase tracking-widest text-indigo-300">İLK ADIMI ŞİMDİ ATIN</span>
                    <h2 class="text-4xl sm:text-5xl font-black text-white tracking-tight">
                        Borçlarınız Sizi Değil,<br>
                        Siz Borçlarınızı Yönetin.
                    </h2>
                    <p class="text-sm sm:text-base text-indigo-200 leading-relaxed">
                        Hemen ücretsiz kayıt olun, 4 adımlı sihirbazla bankalarınızı tanımlayın ve 90 günlük yasal takip sayacınızla krizden güvenle çıkın.
                    </p>
                </div>

                <div class="pt-2 relative z-10 flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('register') }}" class="px-10 py-4 bg-white hover:bg-slate-100 text-indigo-900 font-black text-base rounded-2xl shadow-xl hover:scale-105 active:scale-95 transition-all">
                        Hemen Ücretsiz Başla →
                    </a>
                </div>
            </div>
        </section>
    </main>

    <!-- UNIFIED PUBLIC FOOTER -->
    <x-public-footer />

    <!-- ========================================================================= -->
    <!-- JAVASCRIPT: 3D PERSPECTIVE SCROLL & TILT ENGINE (VANILLA JS)              -->
    <!-- ========================================================================= -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // 1. Scroll Reveal Observer
            const observerOptions = {
                threshold: 0.15,
                rootMargin: '0px 0px -50px 0px'
            };

            const revealObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-revealed');
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.reveal-on-scroll').forEach(el => {
                revealObserver.observe(el);
            });

            // 2. Parallax Scroll Tilt for Hero 3D Cards
            const cardGaranti = document.getElementById('card-garanti');
            const cardYapiKredi = document.getElementById('card-yapi-kredi');
            const cardCenter = document.getElementById('card-center-dashboard');

            window.addEventListener('scroll', () => {
                const scrolled = window.pageYOffset;
                const rate = scrolled * 0.15;

                if (cardGaranti) {
                    cardGaranti.style.transform = `translate3d(${-rate * 0.8}px, ${rate * 0.4}px, 0) rotate(${-6 - rate * 0.05}deg)`;
                }
                if (cardYapiKredi) {
                    cardYapiKredi.style.transform = `translate3d(${rate * 0.8}px, ${rate * 0.4}px, 0) rotate(${6 + rate * 0.05}deg)`;
                }
                if (cardCenter && scrolled < 600) {
                    cardCenter.style.transform = `translate3d(0, ${-rate * 0.3}px, 0) scale(${1 + scrolled * 0.0002})`;
                }
            }, { passive: true });

            // 3. Mouse Tilt Interaction on Center Card
            if (cardCenter) {
                cardCenter.addEventListener('mousemove', (e) => {
                    const rect = cardCenter.getBoundingClientRect();
                    const x = e.clientX - rect.left - rect.width / 2;
                    const y = e.clientY - rect.top - rect.height / 2;
                    const rotateX = (-y / 20).toFixed(2);
                    const rotateY = (x / 20).toFixed(2);
                    cardCenter.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(1.02)`;
                });

                cardCenter.addEventListener('mouseleave', () => {
                    cardCenter.style.transform = `perspective(1000px) rotateX(0deg) rotateY(0deg) scale(1)`;
                });
            }
        });
    </script>
</body>
</html>
