<!DOCTYPE html>
<html lang="tr" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>DVT Bank CRM — Tüm Bankalar, Tüm Borçlar, Matematiksel Kesin Çıkış Planı</title>
    <meta name="description" content="Kredi kartı, KMH eksi bakiyeleri ve kredilerinizi tek merkezden yönetin. 90 gün yasal takip sayacı, Çığ algoritması ve 7/24 AI finans koçu ile borç krizinden güvenle çıkın.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            -webkit-tap-highlight-color: transparent;
        }
        .font-mono { font-family: 'JetBrains Mono', monospace; }
        
        /* 3D Perspective Stage */
        .perspective-container {
            perspective: 1200px;
        }

        /* 3D Card Base with Smooth Hardware Transitions */
        .card-3d {
            transform-style: preserve-3d;
            transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.25s ease, z-index 0.2s ease, box-shadow 0.3s ease;
            will-change: transform, opacity;
            cursor: pointer;
        }

        /* Ambient Glow & Floating Animations */
        @keyframes float-slow-1 {
            0%, 100% { transform: translate3d(0, 0, 0) rotate(-12deg); }
            50% { transform: translate3d(0, -8px, 0) rotate(-10.5deg); }
        }
        @keyframes float-slow-2 {
            0%, 100% { transform: translate3d(0, 0, 0) rotate(12deg); }
            50% { transform: translate3d(0, -9px, 0) rotate(10.5deg); }
        }
        @keyframes float-slow-3 {
            0%, 100% { transform: translate3d(0, 0, 0) rotate(6deg); }
            50% { transform: translate3d(0, -6px, 0) rotate(7deg); }
        }
        @keyframes float-slow-4 {
            0%, 100% { transform: translate3d(0, 0, 0) rotate(-6deg); }
            50% { transform: translate3d(0, -7px, 0) rotate(-7deg); }
        }

        @keyframes pulse-glow {
            0%, 100% { opacity: 0.3; transform: scale(1); }
            50% { opacity: 0.6; transform: scale(1.06); }
        }

        @keyframes shimmer-sweep {
            0% { transform: translateX(-150%) skewX(-20deg); }
            100% { transform: translateX(250%) skewX(-20deg); }
        }

        .anim-float-1 { animation: float-slow-1 7s ease-in-out infinite; }
        .anim-float-2 { animation: float-slow-2 8s ease-in-out 1s infinite; }
        .anim-float-3 { animation: float-slow-3 6.5s ease-in-out 2s infinite; }
        .anim-float-4 { animation: float-slow-4 7.5s ease-in-out 1.5s infinite; }
        .animate-glow { animation: pulse-glow 5s ease-in-out infinite; }
        .animate-shimmer { animation: shimmer-sweep 3.5s ease-in-out infinite; }

        /* Scroll reveal */
        .reveal-on-scroll {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.7s cubic-bezier(0.16, 1, 0.3, 1), transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .reveal-on-scroll.is-revealed {
            opacity: 1;
            transform: translateY(0);
        }

        /* Range Slider */
        input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: #6366f1;
            border: 3px solid #ffffff;
            cursor: pointer;
            box-shadow: 0 0 12px rgba(99, 102, 241, 0.7);
        }
    </style>
</head>
<body class="bg-slate-950 text-slate-100 antialiased selection:bg-indigo-600 selection:text-white min-h-screen flex flex-col justify-between overflow-x-hidden">

    <!-- UNIFIED PUBLIC HEADER -->
    <x-public-header />

    <main class="flex-1">
        <!-- ========================================================================= -->
        <!-- 1. APPLE-STYLE HERO SECTION (DİNAMİK 3D DAĞINIK FAN & GEÇİŞ DÖNGÜSÜ)     -->
        <!-- ========================================================================= -->
        <section class="relative pt-14 sm:pt-20 pb-16 sm:pb-28 px-3 sm:px-6 lg:px-8 max-w-7xl mx-auto text-center perspective-container overflow-hidden">
            <!-- Ambient Lighting Glows -->
            <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[300px] sm:w-[600px] h-[300px] sm:h-[600px] bg-indigo-600/20 rounded-full blur-[80px] sm:blur-[130px] pointer-events-none animate-glow"></div>
            <div class="absolute top-1/3 left-1/4 w-[200px] sm:w-[400px] h-[200px] sm:h-[400px] bg-purple-600/15 rounded-full blur-[70px] sm:blur-[110px] pointer-events-none animate-glow" style="animation-delay: 2s;"></div>
            <div class="absolute top-1/3 right-1/4 w-[200px] sm:w-[400px] h-[200px] sm:h-[400px] bg-emerald-600/15 rounded-full blur-[70px] sm:blur-[110px] pointer-events-none animate-glow" style="animation-delay: 4s;"></div>

            <!-- Top Pill Badge -->
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-indigo-950/80 border border-indigo-500/30 text-indigo-300 text-[11px] sm:text-xs font-bold mb-6 shadow-xl backdrop-blur-md">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span>TÜRKİYE BANKACILIK MEVZUATI & 90 GÜN KURALI MOTORU</span>
            </div>

            <!-- Display Header -->
            <h1 class="text-3xl sm:text-6xl lg:text-7xl font-black tracking-tight text-white max-w-5xl mx-auto leading-[1.1] sm:leading-[1.05]">
                Finansal Krizden<br>
                <span class="bg-gradient-to-r from-indigo-400 via-sky-300 to-emerald-300 bg-clip-text text-transparent">Matematiksel Çıkış.</span>
            </h1>

            <p class="mt-5 sm:mt-7 text-sm sm:text-xl text-slate-300 max-w-3xl mx-auto font-normal leading-relaxed px-2">
                Tüm bankalarınızın kredi kartları, KMH eksi bakiyeleri ve kredi taksitleri arasında boğulmayın. Sıfır panik, doğrudan veritabanı ve 7/24 AI koç ile borçlarınızı adım adım sıfırlayın.
            </p>

            <!-- Trust Badges -->
            <div class="mt-5 flex flex-wrap items-center justify-center gap-2 text-xs font-bold text-slate-300">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-slate-900/90 border border-slate-800">
                    <span class="text-indigo-400">⚡</span> Çığ & Kartopu Algoritması
                </span>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-slate-900/90 border border-slate-800">
                    <span class="text-red-400">🚨</span> 90 Gün Yasal Takip Sayacı
                </span>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-slate-900/90 border border-slate-800">
                    <span class="text-emerald-400">🤖</span> 7/24 AI Finans Koçu
                </span>
            </div>

            <!-- Call to Actions -->
            <div class="mt-7 sm:mt-9 flex flex-col sm:flex-row items-center justify-center gap-3 sm:gap-4 px-4">
                <a href="{{ route('register') }}" class="w-full sm:w-auto px-7 sm:px-8 py-3.5 sm:py-4 bg-indigo-600 hover:bg-indigo-500 text-white font-black text-sm sm:text-base rounded-xl shadow-xl shadow-indigo-600/30 hover:scale-105 active:scale-95 transition-all flex items-center justify-center gap-2 group">
                    <span>Ücretsiz Borç Analizini Başlat</span>
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                </a>
                <a href="#nasil-calisir" class="w-full sm:w-auto px-6 sm:px-7 py-3.5 sm:py-4 bg-slate-900/90 hover:bg-slate-800 text-slate-300 hover:text-white font-bold text-sm sm:text-base rounded-xl border border-slate-800 shadow-md backdrop-blur-md transition-all">
                    Stratejiyi İncele ↓
                </a>
            </div>

            <!-- ========================================================================= -->
            <!-- 🌟 3D GEÇİŞLİ DAĞINIK DESTE (KAYDIKÇA SIRAYLA DEĞİŞEN & KAYBOLAN KARTLAR)  -->
            <!-- ========================================================================= -->
            <div id="hero-scattered-deck" class="mt-12 sm:mt-20 relative w-full max-w-sm sm:max-w-5xl mx-auto min-h-[390px] sm:min-h-[490px] flex items-center justify-center perspective-container">
                
                <!-- Card 1: Garanti BBVA (Sol Üst - İlk Sahneden Uçarak Çıkacak) -->
                <div id="card-garanti" class="card-3d absolute -left-3 sm:left-4 -top-2 sm:top-4 w-56 sm:w-80 p-4 sm:p-6 rounded-xl bg-gradient-to-br from-emerald-950 via-slate-900 to-slate-950 border border-emerald-500/40 shadow-2xl text-left z-30" style="transform: rotate(-12deg);">
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] sm:text-xs font-black uppercase tracking-wider text-emerald-400">Garanti BBVA</span>
                        <div class="w-7 h-4.5 sm:w-8 sm:h-5 rounded bg-amber-400/90 border border-amber-300 font-mono text-[8px] sm:text-[9px] font-bold flex items-center justify-center text-amber-950">CHIP</div>
                    </div>
                    <div class="my-2 sm:my-4">
                        <span class="font-mono text-xs sm:text-sm tracking-widest text-slate-300">•••• •••• •••• 8412</span>
                        <div class="mt-1.5 inline-flex items-center px-2 py-0.5 rounded-md text-[9px] sm:text-[10px] font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30">
                            ⏳ 18 Gündür Gecikmede
                        </div>
                    </div>
                    <div class="pt-2 sm:pt-3 border-t border-slate-800 flex justify-between items-end">
                        <div>
                            <span class="text-[8px] sm:text-[10px] text-slate-400 block font-semibold">DÖNEM BORCU</span>
                            <span class="text-base sm:text-xl font-black text-red-400">₺78.450</span>
                        </div>
                        <span class="text-[10px] sm:text-xs font-bold text-slate-400">Asgari: ₺31.380</span>
                    </div>
                </div>

                <!-- Card 2: Yapı Kredi KMH (Sağ Üst - 2. Sırada Öne Gelip Uçacak) -->
                <div id="card-yapi-kredi" class="card-3d absolute -right-3 sm:right-4 top-2 sm:top-8 w-56 sm:w-80 p-4 sm:p-6 rounded-xl bg-gradient-to-br from-blue-950 via-slate-900 to-slate-950 border border-blue-500/40 shadow-2xl text-left z-25" style="transform: rotate(12deg);">
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] sm:text-xs font-black uppercase tracking-wider text-blue-400">Yapı Kredi • KMH</span>
                        <span class="px-1.5 py-0.5 rounded-md bg-red-500/20 text-red-300 border border-red-500/30 text-[9px] sm:text-[10px] font-black">FAİZ: %5.00</span>
                    </div>
                    <div class="my-2 sm:my-4">
                        <span class="text-[10px] sm:text-xs text-slate-400 block font-semibold">EK HESAP EKSİ BAKİYE</span>
                        <span class="text-lg sm:text-2xl font-black text-red-500">-₺65.000</span>
                    </div>
                    <div class="pt-2 sm:pt-3 border-t border-slate-800 flex justify-between items-center text-[10px] sm:text-xs">
                        <span class="text-slate-400">Aylık Faiz:</span>
                        <span class="font-bold text-red-400">₺3.250 / ay</span>
                    </div>
                </div>

                <!-- Card 3: Akbank Kart (Sağ Alt - 3. Sırada Öne Gelecek) -->
                <div id="card-akbank" class="card-3d absolute -right-5 sm:right-12 -bottom-4 sm:-bottom-6 w-52 sm:w-72 p-3.5 sm:p-5 rounded-xl bg-gradient-to-br from-rose-950 via-slate-900 to-slate-950 border border-rose-500/30 shadow-2xl text-left z-20" style="transform: rotate(-6deg);">
                    <span class="text-[10px] sm:text-xs font-black uppercase text-rose-400 block">Akbank • Wings Kart</span>
                    <span class="text-base sm:text-lg font-black text-white mt-0.5 sm:mt-1 block">Dönem Borcu: ₺52.000</span>
                    <span class="text-[10px] sm:text-[11px] text-amber-400 font-bold">⚠️ Son Ödeme: 4 Gün Kaldı</span>
                </div>

                <!-- Card 4: Ziraat Bankası Kredi (Sol Alt) -->
                <div id="card-ziraat" class="card-3d absolute -left-5 sm:left-12 -bottom-4 sm:-bottom-6 w-52 sm:w-72 p-3.5 sm:p-5 rounded-xl bg-gradient-to-br from-red-950 via-slate-900 to-slate-950 border border-red-500/30 shadow-2xl text-left z-15" style="transform: rotate(6deg);">
                    <span class="text-[10px] sm:text-xs font-black uppercase text-red-400 block">Ziraat Bankası • Kredi</span>
                    <span class="text-base sm:text-lg font-black text-white mt-0.5 sm:mt-1 block">Kalan: ₺140.000</span>
                    <span class="text-[10px] sm:text-[11px] text-slate-400">Taksit: ₺7.200 / ay (24 Taksit Kaldı)</span>
                </div>

                <!-- Card 5: Ana Dashboard Önizleme Paneli (EN SON ÜSTTE VE SABİT KALACAK KART) -->
                <div id="card-center-dashboard" class="card-3d relative w-full max-w-[340px] sm:max-w-xl p-5 sm:p-8 rounded-xl bg-slate-900/95 border-2 border-indigo-500/40 shadow-2xl shadow-indigo-950/80 backdrop-blur-2xl text-left z-10">
                    <div class="flex items-center justify-between border-b border-slate-800 pb-3 sm:pb-4">
                        <div class="flex items-center gap-2.5 sm:gap-3">
                            <span class="w-2.5 sm:w-3 h-2.5 sm:h-3 rounded-full bg-red-500 animate-ping"></span>
                            <div>
                                <h3 class="font-bold text-xs sm:text-sm text-white">Canlı Risk Analizi & Sayaç</h3>
                                <p class="text-[10px] sm:text-[11px] text-slate-400">Tüm Bankalar Aktif Takipte</p>
                            </div>
                        </div>
                        <span class="px-2 sm:px-2.5 py-1 rounded-md bg-red-500/20 text-red-300 text-[10px] sm:text-xs font-black border border-red-500/30">
                            🚨 Yasal Takibe 24 Gün Kaldı
                        </span>
                    </div>

                    <div class="grid grid-cols-2 gap-3 sm:gap-4 my-4 sm:my-6">
                        <div class="p-3 sm:p-4 rounded-lg bg-slate-950/80 border border-slate-800">
                            <span class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-wider block">TOPLAM BORÇ YÜKÜ</span>
                            <span class="text-lg sm:text-2xl font-black text-white mt-0.5 sm:mt-1 block">₺485.200</span>
                            <span class="text-[10px] sm:text-[11px] text-emerald-400 font-semibold">↓ Çığ ile ₺62.000 Tasarruf</span>
                        </div>
                        <div class="p-3 sm:p-4 rounded-lg bg-slate-950/80 border border-slate-800">
                            <span class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-wider block">TAHMİNİ BORÇSUZLUK</span>
                            <span class="text-lg sm:text-2xl font-black text-indigo-400 mt-0.5 sm:mt-1 block">14 Ay</span>
                            <span class="text-[10px] sm:text-[11px] text-slate-400">Sabit Ödeme Disiplini</span>
                        </div>
                    </div>

                    <!-- AI Coach Insight Strip -->
                    <div class="p-3 sm:p-3.5 rounded-lg bg-indigo-950/40 border border-indigo-500/30 flex items-center gap-2.5 sm:gap-3">
                        <div class="w-7 sm:w-8 h-7 sm:h-8 rounded-md bg-indigo-600 flex items-center justify-center text-xs sm:text-sm shrink-0">🤖</div>
                        <p class="text-[11px] sm:text-xs text-indigo-200 leading-snug">
                            <strong>AI Koç Önerisi:</strong> "Yapı Kredi KMH faizi en yüksek (%5.0). Bu ay fazladan ₺8.000 buraya aktarılırsa ₺4.800 faiz silinecektir."
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ========================================================================= -->
        <!-- 2. İNTERAKTİF 90 GÜN YASAL TAKİP TİMELINE SİSTEMİ                         -->
        <!-- ========================================================================= -->
        <section id="90-gun-kurali" class="py-16 sm:py-24 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto border-t border-slate-800/80">
            <div class="text-center space-y-3 sm:space-y-4 max-w-3xl mx-auto reveal-on-scroll">
                <span class="text-[10px] sm:text-xs font-bold uppercase tracking-wider text-red-400 bg-red-950/60 border border-red-800/50 px-3 py-1 rounded-full">
                    🚨 KRİTİK YASAL SÜREÇ YÖNETİMİ
                </span>
                <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight">
                    90 Günlük Yasal Takip Sayacı ile İcrayı Önleyin.
                </h2>
                <p class="text-sm sm:text-lg text-slate-300 leading-relaxed">
                    Türkiye mevzuatında üst üste 3 asgari ödeme yapılmadığında (90 gün) bankalar yasal takip ve maaş haczi başlatır. Aşağıdaki fazlara tıklayarak risk durumunu inceleyin:
                </p>
            </div>

            <!-- İnteraktif Faz Seçici Butonlar -->
            <div class="flex justify-center gap-2 mt-8 max-w-2xl mx-auto overflow-x-auto pb-2">
                <button type="button" class="phase-tab px-3.5 py-2 rounded-lg text-xs font-bold transition-all bg-indigo-600 text-white shadow-md" data-phase="1">
                    1-30. Gün (Gecikme)
                </button>
                <button type="button" class="phase-tab px-3.5 py-2 rounded-lg text-xs font-bold transition-all bg-slate-900 border border-slate-800 text-slate-400 hover:text-white" data-phase="2">
                    31-60. Gün (İdari Takip)
                </button>
                <button type="button" class="phase-tab px-3.5 py-2 rounded-lg text-xs font-bold transition-all bg-slate-900 border border-slate-800 text-slate-400 hover:text-white" data-phase="3">
                    61-89. Gün (İhtarname)
                </button>
                <button type="button" class="phase-tab px-3.5 py-2 rounded-lg text-xs font-bold transition-all bg-slate-900 border border-slate-800 text-slate-400 hover:text-white" data-phase="4">
                    90+ Gün (Yasal Takip)
                </button>
            </div>

            <!-- İnteraktif Faz Bilgi Paneli -->
            <div id="phase-detail-card" class="max-w-3xl mx-auto mt-6 p-6 sm:p-8 rounded-xl bg-slate-900 border border-slate-800 shadow-2xl transition-all duration-300 text-left space-y-4 reveal-on-scroll">
                <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                    <div class="flex items-center gap-3">
                        <span id="phase-badge" class="w-8 h-8 rounded-lg bg-emerald-600/20 text-emerald-400 font-black text-sm flex items-center justify-center border border-emerald-500/30">1</span>
                        <h3 id="phase-title" class="text-lg font-bold text-white">1 - 30. Gün: İlk Gecikme Evresi</h3>
                    </div>
                    <span id="phase-status" class="px-2.5 py-1 rounded-md bg-emerald-950 text-emerald-300 text-xs font-bold border border-emerald-800">Kontrol Altında</span>
                </div>
                <p id="phase-desc" class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                    İlk son ödeme tarihi kaçırıldı. Henüz idari veya yasal takip yoktur. Sadece günlük gecikme faizi işlemeye başlar. KKB (Findeks) kredi notunuz hafif etkilenir. Bu evrede yapılacak bir asgari ödeme süreci anında sıfırlar.
                </p>
                <div id="phase-action" class="p-3.5 rounded-lg bg-slate-950 border border-slate-800 text-xs text-indigo-300 flex items-center gap-2">
                    <span>💡 <strong>DVT CRM Aksiyonu:</strong> Asgari tutarı yatırmanız için otomatik hatırlatıcı kurulur.</span>
                </div>
            </div>
        </section>

        <!-- ========================================================================= -->
        <!-- 3. MATEMATİKSEL KURTARMA ALGORİTMALARI: ÇIĞ (AVALANCHE) & KARTOPU        -->
        <!-- ========================================================================= -->
        <section id="nasil-calisir" class="py-16 sm:py-24 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto border-t border-slate-800/80">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="space-y-4 sm:space-y-6 reveal-on-scroll text-left">
                    <span class="text-[10px] sm:text-xs font-bold uppercase tracking-wider text-indigo-400 bg-indigo-950/60 border border-indigo-800/50 px-3 py-1 rounded-full">
                        🎯 STRATEJİK BORÇ ERİTME SİMÜLATÖRÜ
                    </span>
                    <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight">
                        Çığ vs Kartopu:<br>
                        Hangi Yöntem Size Uygun?
                    </h2>
                    <p class="text-sm sm:text-base text-slate-300 leading-relaxed">
                        Rastgele borç ödemek faiz batağını büyütür. DVT CRM, iki kanıtlanmış matematiksel algoritmayı karşılaştırır ve size en az faiz ödetecek kesin ödeme sırasını üretir.
                    </p>

                    <div class="p-5 sm:p-6 bg-slate-900 border border-indigo-500/40 rounded-xl space-y-3 shadow-xl">
                        <div class="flex items-start gap-3">
                            <span class="text-2xl">⚡</span>
                            <div>
                                <h4 class="font-bold text-sm text-white">Çığ (Avalanche) — En Yüksek Faizden Başla</h4>
                                <p class="text-xs text-slate-400 mt-1">
                                    En yüksek faizli KMH ve kredi kartına ekstra ödeme yaparak toplam faiz yükünü minimuma indirir. Matematiksel olarak en karlı yöntemdir.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- İnteraktif Simülatör Kartı -->
                <div class="bg-slate-900 border border-slate-800 rounded-xl p-6 sm:p-8 space-y-6 shadow-2xl reveal-on-scroll text-left">
                    <div class="flex items-center justify-between border-b border-slate-800 pb-4">
                        <h3 class="font-bold text-base text-white">Canlı Çığ Tasarruf Simülatörü</h3>
                        <span class="text-xs font-black text-emerald-400 bg-emerald-950/60 px-2.5 py-1 rounded-md border border-emerald-800/50">CANLI HESAPLAMA</span>
                    </div>

                    <div class="space-y-3">
                        <div class="flex justify-between text-xs font-bold">
                            <span class="text-slate-400">Aylık Borca Ayrılan Ekstra Bütçe:</span>
                            <span id="sim-extra-budget-label" class="text-indigo-400 text-sm font-black">₺10.000</span>
                        </div>
                        <input id="sim-slider" type="range" min="2000" max="30000" step="1000" value="10000" class="w-full h-2.5 bg-slate-950 rounded-lg appearance-none cursor-pointer">
                        <div class="flex justify-between text-[10px] text-slate-500">
                            <span>₺2.000</span>
                            <span>₺15.000</span>
                            <span>₺30.000</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 pt-2">
                        <div class="p-4 rounded-lg bg-slate-950 border border-slate-800">
                            <span class="text-[10px] font-bold text-slate-400 uppercase block">Kapanış Süresi</span>
                            <span id="sim-months-text" class="text-xl font-black text-emerald-400 mt-1 block">16 Ayda Biter</span>
                            <span class="text-[10px] text-slate-500">Asgari ödemeyle 48 ay sürer</span>
                        </div>
                        <div class="p-4 rounded-lg bg-slate-950 border border-slate-800">
                            <span class="text-[10px] font-bold text-slate-400 uppercase block">Toplam Faiz Tasarrufu</span>
                            <span id="sim-saved-text" class="text-xl font-black text-indigo-300 mt-1 block">₺74.200 Cepte!</span>
                            <span class="text-[10px] text-slate-500">Bankaya ödenmekten kurtarıldı</span>
                        </div>
                    </div>

                    <div class="pt-2">
                        <div class="h-2 w-full bg-slate-950 rounded-full overflow-hidden">
                            <div id="sim-progress-bar" class="h-full bg-gradient-to-r from-emerald-500 to-indigo-500 rounded-full transition-all duration-300" style="width: 65%;"></div>
                        </div>
                        <div class="flex justify-between text-[11px] text-slate-400 mt-2">
                            <span>Toplam Borç: ₺485.200</span>
                            <span id="sim-interest-text" class="font-bold text-white">Faiz: ₺88.000</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ========================================================================= -->
        <!-- 4. İNTERAKTİF 7/24 AI FİNANSAL KRİZ KOÇU TERMİNALİ                       -->
        <!-- ========================================================================= -->
        <section id="ozellikler" class="py-16 sm:py-24 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto border-t border-slate-800/80">
            <div class="text-center space-y-3 sm:space-y-4 max-w-3xl mx-auto reveal-on-scroll">
                <span class="text-[10px] sm:text-xs font-bold uppercase tracking-wider text-indigo-400 bg-indigo-950/60 border border-indigo-800/50 px-3 py-1 rounded-full">
                    🤖 GROQ & GEMINI HİBRİT AI MOTORU
                </span>
                <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight">
                    7/24 AI Finansal Kriz Koçu Yanınızda.
                </h2>
                <p class="text-sm sm:text-lg text-slate-300 leading-relaxed">
                    Aşağıdaki hazır sorulardan birine tıklayarak AI koçun anlık strateji ve analiz üretmesini test edin:
                </p>
            </div>

            <!-- Hızlı Soru Hapları -->
            <div class="flex flex-wrap justify-center gap-2 mt-8 max-w-3xl mx-auto">
                <button type="button" class="ai-prompt-chip px-3 py-1.5 rounded-lg bg-indigo-950/80 hover:bg-indigo-900 border border-indigo-500/40 text-xs font-bold text-indigo-200 transition-all" data-answer="Yapı Kredi KMH faizi %5.00 ile en yüksek maliyetli borcunuzdur. Elinizdeki ₺15.000'i buraya yatırırsanız aylık ₺750, yıllık ₺9.000 doğrudan faiz tasarrufu sağlarsınız.">
                    💬 "Elimdeki ₺15.000'i hangi borca yatırayım?"
                </button>
                <button type="button" class="ai-prompt-chip px-3 py-1.5 rounded-lg bg-slate-900 hover:bg-slate-800 border border-slate-800 text-xs font-bold text-slate-300 transition-all" data-answer="Garanti Bonus kartınız 18 gündür gecikmede. Yasal takibe 72 gününüz var. 60. güne kadar asgari tutarı yatırmanız durumunda dosyanız avukata devredilmez.">
                    💬 "Garanti kartım gecikmede, icra ne zaman gelir?"
                </button>
                <button type="button" class="ai-prompt-chip px-3 py-1.5 rounded-lg bg-slate-900 hover:bg-slate-800 border border-slate-800 text-xs font-bold text-slate-300 transition-all" data-answer="Sadece asgari tutarı ödemek borcun anaparasını eritmez ve kalan bakiyeye her ay bileşik faiz biner. Çığ stratejisiyle asgari üstü ₺3.000 ek ödeme yaparak borcunuzu 3 yıl erken bitirebilirsiniz.">
                    💬 "Sadece asgariyi ödersem ne olur?"
                </button>
            </div>

            <!-- Canlı AI Terminal Kutusu -->
            <div class="max-w-3xl mx-auto mt-6 bg-slate-900 border border-slate-800 rounded-xl p-6 sm:p-8 space-y-6 shadow-2xl text-left reveal-on-scroll">
                <!-- AI Cevap Alanı -->
                <div class="flex items-start gap-3 sm:gap-4">
                    <div class="w-9 h-9 rounded-lg bg-indigo-600 text-white flex items-center justify-center font-bold text-sm shrink-0 shadow-lg shadow-indigo-600/30">
                        AI
                    </div>
                    <div class="bg-slate-950 border border-slate-800 text-slate-200 rounded-xl p-4 text-xs sm:text-sm leading-relaxed space-y-2 flex-1">
                        <p id="ai-response-text">
                            "Veritabanınızı taradım. <strong>Yapı Kredi KMH</strong> hesabınız %5.00 faiz işletiyor. Elinizdeki fazladan ₺15.000 bütçeyi buraya aktarmanız durumunda yıllık <strong>₺9.000 faiz tasarrufu</strong> elde edeceksiniz."
                        </p>
                        <p class="text-emerald-400 font-semibold text-xs">
                            → Strateji: Çığ Algoritması #1 Öncelik Onaylandı.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ========================================================================= -->
        <!-- 5. TÜM BANKALAR TAM ENTEGRASYON VE DOĞRUDAN VERİTABANI                   -->
        <!-- ========================================================================= -->
        <section class="py-16 sm:py-24 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto border-t border-slate-800/80">
            <div class="text-center space-y-3 sm:space-y-4 max-w-3xl mx-auto reveal-on-scroll">
                <span class="text-[10px] sm:text-xs font-bold uppercase tracking-wider text-emerald-400 bg-emerald-950/60 border border-emerald-800/50 px-3 py-1 rounded-full">
                    🛡️ SIFIR SAHTE VERİ & DOĞRUDAN VERİTABANI
                </span>
                <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight">
                    Türkiye'deki Tüm Bankalarla Uyumlu.
                </h2>
                <p class="text-sm sm:text-lg text-slate-300 leading-relaxed">
                    Sistemde hiçbir sahte veya mock veri yer almaz. Eklediğiniz her kart ve borç doğrudan MySQL veritabanına yazılır, matematiksel formüllerle anlık işlenir.
                </p>
            </div>

            @php
                $databaseBanks = \App\Models\Bank::where('is_system', true)->get();
            @endphp

            <!-- Banka Kartları - Doğrudan MySQL Veritabanından Dinamik -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3 sm:gap-4 mt-12 sm:mt-16">
                @foreach ($databaseBanks as $dbBank)
                    <div class="p-4 sm:p-5 rounded-xl bg-slate-900 border border-slate-800 text-center space-y-2 hover:border-indigo-500 transition-all hover:scale-105 reveal-on-scroll">
                        <div class="w-10 h-10 rounded-lg text-white font-black flex items-center justify-center mx-auto text-xs shadow-md" style="background-color: {{ $dbBank->color ?? '#6366f1' }};">
                            {{ mb_substr($dbBank->name, 0, 2) }}
                        </div>
                        <h4 class="font-bold text-white text-xs truncate" title="{{ $dbBank->name }}">{{ $dbBank->name }}</h4>
                        <span class="text-[10px] text-slate-400 block">Kart + KMH + Kredi</span>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- ========================================================================= -->
        <!-- 6. BÜYÜK CALL TO ACTION BANNER (APPLE-STYLE)                               -->
        <!-- ========================================================================= -->
        <section class="py-16 sm:py-24 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
            <div class="relative rounded-xl bg-gradient-to-r from-indigo-900 via-indigo-950 to-slate-900 border-2 border-indigo-500/50 p-6 sm:p-16 text-center space-y-6 sm:space-y-8 overflow-hidden shadow-2xl shadow-indigo-950 reveal-on-scroll">
                <div class="absolute top-0 right-0 w-72 sm:w-96 h-72 sm:h-96 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>

                <div class="space-y-3 sm:space-y-4 max-w-2xl mx-auto relative z-10">
                    <span class="text-[10px] sm:text-xs font-black uppercase tracking-widest text-indigo-300">İLK ADIMI ŞİMDİ ATIN</span>
                    <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight">
                        Borçlarınız Sizi Değil,<br>
                        Siz Borçlarınızı Yönetin.
                    </h2>
                    <p class="text-xs sm:text-base text-indigo-200 leading-relaxed">
                        Hemen ücretsiz kayıt olun, 4 adımlı sihirbazla bankalarınızı tanımlayın ve 90 günlük yasal takip sayacınızla krizden güvenle çıkın.
                    </p>
                </div>

                <div class="relative z-10 flex flex-col sm:flex-row items-center justify-center gap-3">
                    <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 sm:px-10 py-4 bg-white text-indigo-950 font-black text-sm sm:text-base rounded-xl hover:bg-slate-100 shadow-xl hover:scale-105 active:scale-95 transition-all">
                        🚀 Ücretsiz Kayıt Ol & Başla
                    </a>
                    <a href="{{ route('login') }}" class="w-full sm:w-auto px-6 py-4 bg-indigo-950/80 hover:bg-indigo-900 text-white font-bold text-sm sm:text-base rounded-xl border border-indigo-400/30 transition-all">
                        Giriş Yap →
                    </a>
                </div>
            </div>
        </section>
    </main>

    <!-- UNIFIED PUBLIC FOOTER -->
    <x-public-footer />

    <!-- MOBİL İÇİN YÜZEN HIZLI AKSİYON ÇUBUĞU (FLOATING ACTION PILL) -->
    <div id="mobile-floating-pill" class="fixed bottom-4 left-4 right-4 z-40 md:hidden transform transition-all duration-300 translate-y-24 opacity-0 pointer-events-none">
        <a href="{{ route('register') }}" class="w-full py-3.5 px-5 rounded-xl bg-indigo-600 text-white font-black text-sm flex items-center justify-between shadow-2xl shadow-indigo-600/60 border border-indigo-400/40">
            <span class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                <span>Borç Analizini Başlat</span>
            </span>
            <span>Ücretsiz →</span>
        </a>
    </div>

    <!-- ========================================================================= -->
    <!-- JAVASCRIPT: AKICI 3D KART DEĞİŞİM & KAYBOLUŞ DÖNGÜSÜ (SCROLL SHUFFLE)     -->
    <!-- ========================================================================= -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // 1. Scroll Reveal for Sections
            const revealElements = document.querySelectorAll('.reveal-on-scroll');
            if ('IntersectionObserver' in window) {
                const revealObserver = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('is-revealed');
                            observer.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.12 });
                revealElements.forEach(el => revealObserver.observe(el));
            } else {
                revealElements.forEach(el => el.classList.add('is-revealed'));
            }

            // 2. Interactive 90-Day Legal Timeline Phase Tabs
            const phaseTabs = document.querySelectorAll('.phase-tab');
            const phaseBadge = document.getElementById('phase-badge');
            const phaseTitle = document.getElementById('phase-title');
            const phaseStatus = document.getElementById('phase-status');
            const phaseDesc = document.getElementById('phase-desc');
            const phaseAction = document.getElementById('phase-action');

            const phaseData = {
                1: {
                    badge: '1',
                    title: '1 - 30. Gün: İlk Gecikme Evresi',
                    status: 'Kontrol Altında',
                    desc: 'İlk son ödeme tarihi kaçırıldı. Henüz idari veya yasal takip yoktur. Sadece günlük gecikme faizi işlemeye başlar. KKB (Findeks) kredi notunuz hafif etkilenir. Bu evrede yapılacak bir asgari ödeme süreci anında sıfırlar.',
                    action: '💡 <strong>DVT CRM Aksiyonu:</strong> Asgari tutarı yatırmanız için otomatik hatırlatıcı kurulur.'
                },
                2: {
                    badge: '2',
                    title: '31 - 60. Gün: İdari Takip & Çağrı Evresi',
                    status: 'Uyarı Veriliyor',
                    desc: 'İkinci dönem asgari tutarı da ödenmediğinde bankanın iç tahsilat servisi devreye girer. Telefonla arama ve SMS bilgilendirmeleri başlar. Kartınız geçici olarak nakit avansa kapatılabilir.',
                    action: '💡 <strong>DVT CRM Aksiyonu:</strong> Bankanın çağrı merkeziyle pazarlık yapmanız için AI koç konuşma rehberi hazırlar.'
                },
                3: {
                    badge: '3',
                    title: '61 - 89. Gün: Noter İhtarnamesi Evresi',
                    status: 'Son Yapılandırma Şansı',
                    desc: 'Noter kanalıyla resmi ihtarname çekilir. Borcun tamamı (tüm taksitler) muaccel hale gelir. Yasal takipten önceki son 7-10 günlük kritik süredir. Bu evrede bankayla yapılandırma protokolü imzalanmalıdır.',
                    action: '🚨 <strong>DVT CRM Aksiyonu:</strong> Sistem kırmızı alarma geçer ve acil borç yapılandırma simülasyonu üretir.'
                },
                4: {
                    badge: '4',
                    title: '90+ Gün: Resmi Yasal Takip & İcra',
                    status: 'Kritik Yasal Takip',
                    desc: 'Dosya banka avukatına devredilir, icra dairesi üzerinden ödeme emri gönderilir. %20+ vekalet ücreti, harç ve masraflar eklenir. Maaş haczi ve bloke riskleri doğar.',
                    action: '🛡️ <strong>DVT CRM Aksiyonu:</strong> 90 gün sayacı sayesinde kullanıcı bu aşamaya düşmeden önce kurtarılır.'
                }
            };

            phaseTabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    const phase = tab.getAttribute('data-phase');
                    phaseTabs.forEach(t => {
                        t.classList.remove('bg-indigo-600', 'text-white', 'shadow-md');
                        t.classList.add('bg-slate-900', 'text-slate-400');
                    });
                    tab.classList.remove('bg-slate-900', 'text-slate-400');
                    tab.classList.add('bg-indigo-600', 'text-white', 'shadow-md');

                    const data = phaseData[phase];
                    if (data && phaseBadge && phaseTitle && phaseStatus && phaseDesc && phaseAction) {
                        phaseBadge.textContent = data.badge;
                        phaseTitle.textContent = data.title;
                        phaseStatus.textContent = data.status;
                        phaseDesc.innerHTML = data.desc;
                        phaseAction.innerHTML = data.action;
                    }
                });
            });

            // 3. Interactive AI Koç Prompt Chips
            const promptChips = document.querySelectorAll('.ai-prompt-chip');
            const aiResponseText = document.getElementById('ai-response-text');

            promptChips.forEach(chip => {
                chip.addEventListener('click', () => {
                    promptChips.forEach(c => {
                        c.classList.remove('bg-indigo-950/80', 'border-indigo-500/40', 'text-indigo-200');
                        c.classList.add('bg-slate-900', 'border-slate-800', 'text-slate-300');
                    });
                    chip.classList.add('bg-indigo-950/80', 'border-indigo-500/40', 'text-indigo-200');
                    chip.classList.remove('bg-slate-900', 'border-slate-800', 'text-slate-300');

                    const newAnswer = chip.getAttribute('data-answer');
                    if (aiResponseText && newAnswer) {
                        aiResponseText.style.opacity = '0';
                        setTimeout(() => {
                            aiResponseText.innerHTML = `"${newAnswer}"`;
                            aiResponseText.style.opacity = '1';
                        }, 150);
                    }
                });
            });

            // 4. Interactive Avalanche Calculator Slider
            const slider = document.getElementById('sim-slider');
            const extraLabel = document.getElementById('sim-extra-budget-label');
            const monthsText = document.getElementById('sim-months-text');
            const interestText = document.getElementById('sim-interest-text');
            const savedText = document.getElementById('sim-saved-text');
            const simBar = document.getElementById('sim-progress-bar');

            if (slider && extraLabel) {
                slider.addEventListener('input', (e) => {
                    const extra = parseInt(e.target.value);
                    extraLabel.textContent = `₺${extra.toLocaleString('tr-TR')}`;

                    const baseMonths = 36;
                    const minMonths = 8;
                    const calculatedMonths = Math.max(minMonths, Math.round(baseMonths - (extra / 30000) * 26));

                    const baseInterest = 142000;
                    const minInterest = 22000;
                    const calculatedInterest = Math.max(minInterest, Math.round(baseInterest - (extra / 25000) * 190000));
                    const saved = baseInterest - calculatedInterest;

                    monthsText.textContent = `${calculatedMonths} Ayda Biter`;
                    interestText.textContent = `Faiz: ₺${calculatedInterest.toLocaleString('tr-TR')}`;
                    savedText.textContent = `₺${saved.toLocaleString('tr-TR')} Cepte!`;

                    const barPercent = Math.max(15, Math.round((calculatedMonths / baseMonths) * 90));
                    simBar.style.width = `${barPercent}%`;
                });
            }

            // =========================================================================
            // 5. AKICI VE KUSURSUZ 3D KART DEĞİŞİM & KAYBOLUŞ DÖNGÜSÜ (SCROLL PROGRESS)
            // =========================================================================
            const cGaranti = document.getElementById('card-garanti');
            const cYK = document.getElementById('card-yapi-kredi');
            const cAkbank = document.getElementById('card-akbank');
            const cZiraat = document.getElementById('card-ziraat');
            const cCenter = document.getElementById('card-center-dashboard');
            const mobilePill = document.getElementById('mobile-floating-pill');

            // Helper clamp function
            const clamp = (val, min, max) => Math.min(Math.max(val, min), max);

            window.addEventListener('scroll', () => {
                const scrolled = window.pageYOffset;

                if (cGaranti && cYK && cAkbank && cZiraat && cCenter) {
                    if (scrolled === 0) {
                        // Tam en tepede: 2. Görseldeki ilk dağınık yelpaze konumu
                        cGaranti.style.transform = 'translate3d(0, 0, 0) rotate(-12deg)';
                        cGaranti.style.opacity = '1';
                        cGaranti.style.zIndex = '30';

                        cYK.style.transform = 'translate3d(0, 0, 0) rotate(12deg)';
                        cYK.style.opacity = '1';
                        cYK.style.zIndex = '25';

                        cAkbank.style.transform = 'translate3d(0, 0, 0) rotate(-6deg)';
                        cAkbank.style.opacity = '1';
                        cAkbank.style.zIndex = '20';

                        cZiraat.style.transform = 'translate3d(0, 0, 0) rotate(6deg)';
                        cZiraat.style.opacity = '1';
                        cZiraat.style.zIndex = '15';

                        cCenter.style.transform = 'translate3d(0, 0, 0) scale(1)';
                        cCenter.style.opacity = '1';
                        cCenter.style.zIndex = '10';
                    } else if (scrolled < 750) {
                        // KART 1: Garanti BBVA (0 - 240px arası öne gelir, sonra sola/yukarı uçarak kaybolur)
                        const p1 = clamp(scrolled / 240, 0, 1);
                        if (p1 < 0.4) {
                            const sub = p1 / 0.4;
                            cGaranti.style.transform = `translate3d(${sub * 15}px, ${sub * 10}px, ${sub * 40}px) rotate(${ -12 + sub * 8 }deg) scale(${1 + sub * 0.04})`;
                            cGaranti.style.opacity = '1';
                            cGaranti.style.zIndex = '35';
                        } else {
                            const sub = (p1 - 0.4) / 0.6;
                            cGaranti.style.transform = `translate3d(${ 15 - sub * 180 }px, ${ 10 - sub * 120 }px, ${ 40 - sub * 100 }px) rotate(${ -4 - sub * 22 }deg) scale(${ 1.04 - sub * 0.25 })`;
                            cGaranti.style.opacity = `${ 1 - sub * 1.1 }`;
                            cGaranti.style.zIndex = '5';
                        }

                        // KART 2: Yapı Kredi KMH (180 - 440px arası öne fırlar, sonra sağa/yukarı uçarak kaybolur)
                        const p2 = clamp((scrolled - 160) / 260, 0, 1);
                        if (p2 === 0) {
                            cYK.style.transform = 'translate3d(0, 0, 0) rotate(12deg)';
                            cYK.style.opacity = '1';
                            cYK.style.zIndex = '25';
                        } else if (p2 < 0.45) {
                            const sub = p2 / 0.45;
                            cYK.style.transform = `translate3d(${ -sub * 25 }px, ${ -sub * 10 }px, ${ sub * 60 }px) rotate(${ 12 - sub * 12 }deg) scale(${ 1 + sub * 0.06 })`;
                            cYK.style.opacity = '1';
                            cYK.style.zIndex = '40';
                        } else {
                            const sub = (p2 - 0.45) / 0.55;
                            cYK.style.transform = `translate3d(${ -25 + sub * 190 }px, ${ -10 - sub * 130 }px, ${ 60 - sub * 110 }px) rotate(${ sub * 24 }deg) scale(${ 1.06 - sub * 0.25 })`;
                            cYK.style.opacity = `${ 1 - sub * 1.1 }`;
                            cYK.style.zIndex = '5';
                        }

                        // KART 3: Akbank Axess (360 - 620px arası alttan öne sahneye çıkar, sonra kaybolur)
                        const p3 = clamp((scrolled - 340) / 260, 0, 1);
                        if (p3 === 0) {
                            cAkbank.style.transform = 'translate3d(0, 0, 0) rotate(-6deg)';
                            cAkbank.style.opacity = '1';
                            cAkbank.style.zIndex = '20';
                        } else if (p3 < 0.5) {
                            const sub = p3 / 0.5;
                            cAkbank.style.transform = `translate3d(${ -sub * 30 }px, ${ -sub * 50 }px, ${ sub * 70 }px) rotate(${ -6 + sub * 6 }deg) scale(${ 1 + sub * 0.08 })`;
                            cAkbank.style.opacity = '1';
                            cAkbank.style.zIndex = '45';
                        } else {
                            const sub = (p3 - 0.5) / 0.5;
                            cAkbank.style.transform = `translate3d(${ -30 - sub * 150 }px, ${ -50 - sub * 100 }px, ${ 70 - sub * 100 }px) rotate(${ -sub * 18 }deg) scale(${ 1.08 - sub * 0.3 })`;
                            cAkbank.style.opacity = `${ 1 - sub * 1.1 }`;
                            cAkbank.style.zIndex = '5';
                        }

                        // KART 4: Ziraat Kredi (Arka planda hafifçe içeri toplanır)
                        const pZ = clamp(scrolled / 500, 0, 1);
                        cZiraat.style.transform = `translate3d(${ pZ * 20 }px, ${ -pZ * 30 }px, 0) rotate(${ 6 - pZ * 4 }deg)`;
                        cZiraat.style.opacity = `${ 1 - pZ * 0.6 }`;

                        // KART 5: Canlı Dashboard (EN SON EN ÜSTTE VE SABİT MERKEZDE PARILTIYLA KALIR)
                        const pCenter = clamp((scrolled - 400) / 220, 0, 1);
                        cCenter.style.transform = `translate3d(0, ${ -pCenter * 15 }px, ${ pCenter * 50 }px) scale(${ 0.98 + pCenter * 0.06 })`;
                        cCenter.style.opacity = '1';
                        cCenter.style.zIndex = `${ 10 + Math.round(pCenter * 45) }`;
                    }
                }

                // Show mobile floating pill after scrolling 300px
                if (mobilePill) {
                    if (scrolled > 300) {
                        mobilePill.classList.remove('translate-y-24', 'opacity-0', 'pointer-events-none');
                        mobilePill.classList.add('translate-y-0', 'opacity-100');
                        mobilePill.style.pointerEvents = 'auto';
                    } else {
                        mobilePill.classList.add('translate-y-24', 'opacity-0', 'pointer-events-none');
                        mobilePill.classList.remove('translate-y-0', 'opacity-100');
                    }
                }
            }, { passive: true });
        });
    </script>
</body>
</html>
