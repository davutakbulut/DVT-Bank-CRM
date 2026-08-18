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
        
        /* 3D Perspective Containers */
        .perspective-container {
            perspective: 1200px;
        }

        /* 3D Card Base with Hardware Acceleration */
        .card-3d {
            transform-style: preserve-3d;
            backface-visibility: hidden;
            transition: transform 0.4s cubic-bezier(0.25, 1, 0.5, 1), box-shadow 0.4s ease, opacity 0.3s ease;
            will-change: transform, opacity;
        }

        /* 3D Flip Card System */
        .flip-card {
            perspective: 1200px;
        }
        .flip-card-inner {
            position: relative;
            width: 100%;
            height: 100%;
            text-align: left;
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
            transform-style: preserve-3d;
        }
        .flip-card.flipped .flip-card-inner {
            transform: rotateY(180deg);
        }
        .flip-card-front, .flip-card-back {
            position: absolute;
            inset: 0;
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
            border-radius: inherit;
        }
        .flip-card-back {
            transform: rotateY(180deg);
        }

        /* Ambient Glow Animations */
        @keyframes float-slow {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-10px) rotate(1.5deg); }
        }

        @keyframes pulse-glow {
            0%, 100% { opacity: 0.35; transform: scale(1); }
            50% { opacity: 0.65; transform: scale(1.08); }
        }

        @keyframes shimmer-sweep {
            0% { transform: translateX(-150%) skewX(-25deg); }
            100% { transform: translateX(250%) skewX(-25deg); }
        }

        .animate-float-1 { animation: float-slow 7s ease-in-out infinite; }
        .animate-float-2 { animation: float-slow 9s ease-in-out 1.5s infinite; }
        .animate-float-3 { animation: float-slow 8s ease-in-out 3s infinite; }
        .animate-glow { animation: pulse-glow 6s ease-in-out infinite; }
        .animate-shimmer { animation: shimmer-sweep 3s ease-in-out infinite; }

        /* Scroll reveal class */
        .reveal-on-scroll {
            opacity: 0;
            transform: translateY(35px) scale(0.96);
            transition: all 0.7s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .reveal-on-scroll.is-revealed {
            opacity: 1;
            transform: translateY(0) scale(1);
        }

        /* Custom Slider Thumb Styling */
        input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #6366f1;
            border: 3px solid #ffffff;
            cursor: pointer;
            box-shadow: 0 0 15px rgba(99, 102, 241, 0.8);
            transition: transform 0.15s ease, background 0.15s ease;
        }
        input[type="range"]::-webkit-slider-thumb:active {
            transform: scale(1.2);
            background: #4f46e5;
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
        <section class="relative pt-16 sm:pt-24 pb-20 sm:pb-32 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto text-center perspective-container overflow-hidden">
            <!-- Background Glow Orbs -->
            <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[350px] sm:w-[650px] h-[350px] sm:h-[650px] bg-indigo-600/25 rounded-full blur-[90px] sm:blur-[140px] pointer-events-none animate-glow"></div>
            <div class="absolute top-1/3 left-1/4 w-[250px] sm:w-[450px] h-[250px] sm:h-[450px] bg-purple-600/20 rounded-full blur-[80px] sm:blur-[120px] pointer-events-none animate-glow" style="animation-delay: 2s;"></div>
            <div class="absolute top-1/3 right-1/4 w-[250px] sm:w-[450px] h-[250px] sm:h-[450px] bg-emerald-600/20 rounded-full blur-[80px] sm:blur-[120px] pointer-events-none animate-glow" style="animation-delay: 4s;"></div>

            <!-- Top Pill Badge -->
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-indigo-950/80 border border-indigo-500/30 text-indigo-300 text-[11px] sm:text-xs font-bold mb-6 sm:mb-8 shadow-xl shadow-indigo-950/50 backdrop-blur-md">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span>TÜRKİYE BANKACILIK MEVZUATI & 90 GÜN KURALI MOTORU</span>
            </div>

            <!-- Massive Display Header -->
            <h1 class="text-4xl sm:text-7xl lg:text-8xl font-black tracking-tight text-white max-w-5xl mx-auto leading-[1.08] sm:leading-[1.05]">
                Finansal Krizden<br>
                <span class="bg-gradient-to-r from-indigo-400 via-sky-300 to-emerald-300 bg-clip-text text-transparent">Matematiksel Çıkış.</span>
            </h1>

            <p class="mt-6 sm:mt-8 text-base sm:text-2xl text-slate-300 max-w-3xl mx-auto font-normal leading-relaxed px-2">
                Tüm bankalarınızın kredi kartları, KMH eksi bakiyeleri ve kredi taksitleri arasında boğulmayın. Sıfır panik, doğrudan veritabanı ve 7/24 AI koç ile borçlarınızı adım adım sıfırlayın.
            </p>

            <!-- Quick Trust Badges Strip -->
            <div class="mt-6 flex flex-wrap items-center justify-center gap-2.5 text-xs font-bold text-slate-300">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-900/90 border border-slate-800">
                    <span class="text-indigo-400">⚡</span> Çığ & Kartopu Algoritması
                </span>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-900/90 border border-slate-800">
                    <span class="text-red-400">🚨</span> 90 Gün Yasal Takip Sayacı
                </span>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-900/90 border border-slate-800">
                    <span class="text-emerald-400">🤖</span> 7/24 AI Finans Koçu
                </span>
            </div>

            <!-- Call to Actions -->
            <div class="mt-8 sm:mt-10 flex flex-col sm:flex-row items-center justify-center gap-3 sm:gap-4 px-4">
                <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 sm:px-9 py-3.5 sm:py-4 bg-indigo-600 hover:bg-indigo-500 text-white font-black text-sm sm:text-base rounded-xl shadow-2xl shadow-indigo-600/40 hover:scale-105 active:scale-95 transition-all flex items-center justify-center gap-2 group">
                    <span>Ücretsiz Borç Analizini Başlat</span>
                    <svg class="w-4 sm:w-5 h-4 sm:h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                </a>
                <a href="#nasil-calisir" class="w-full sm:w-auto px-6 sm:px-8 py-3.5 sm:py-4 bg-slate-900/90 hover:bg-slate-800 text-slate-300 hover:text-white font-bold text-sm sm:text-base rounded-xl border border-slate-800 shadow-lg backdrop-blur-md transition-all">
                    Stratejiyi İncele ↓
                </a>
            </div>

            <!-- ========================================================================= -->
            <!-- 📱 MOBİL ÖZEL: DİNAMİK 3D DÖNEN KART SAHNESİ (KAYDIRMA & 3D ROTATION)    -->
            <!-- ========================================================================= -->
            <div class="block md:hidden mt-10 px-2">
                <!-- Bank Selector Tabs -->
                <div class="flex items-center justify-center gap-1.5 p-1 bg-slate-900/90 border border-slate-800 rounded-xl mb-4 max-w-sm mx-auto shadow-lg">
                    <button class="mobile-bank-tab flex-1 py-1.5 px-2 rounded-lg text-[11px] font-bold transition-all bg-indigo-600 text-white shadow-md" data-target="m-card-garanti">
                        Garanti
                    </button>
                    <button class="mobile-bank-tab flex-1 py-1.5 px-2 rounded-lg text-[11px] font-bold transition-all text-slate-400 hover:text-white" data-target="m-card-yapi-kredi">
                        Yapı Kredi
                    </button>
                    <button class="mobile-bank-tab flex-1 py-1.5 px-2 rounded-lg text-[11px] font-bold transition-all text-slate-400 hover:text-white" data-target="m-card-akbank">
                        Akbank
                    </button>
                    <button class="mobile-bank-tab flex-1 py-1.5 px-2 rounded-lg text-[11px] font-bold transition-all text-slate-400 hover:text-white" data-target="m-card-ziraat">
                        Ziraat
                    </button>
                </div>

                <!-- 3D Mobile Interactive Card Stage with dynamic scroll tilt & flip -->
                <div id="mobile-3d-stage" class="relative w-full max-w-sm mx-auto min-h-[250px] transition-transform duration-300 ease-out">
                    
                    <!-- Card 1: Garanti BBVA Bonus (3D Flip Supported) -->
                    <div id="m-card-garanti" class="flip-card mobile-card-slide w-full h-[240px] block transition-all duration-300">
                        <div class="flip-card-inner rounded-2xl">
                            <!-- Ön Yüz -->
                            <div class="flip-card-front p-5 rounded-2xl bg-gradient-to-br from-emerald-950 via-slate-900 to-slate-950 border-2 border-emerald-500/50 shadow-2xl flex flex-col justify-between overflow-hidden relative">
                                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/5 to-transparent -translate-x-full animate-shimmer pointer-events-none"></div>
                                <div class="flex items-center justify-between relative z-10">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-md bg-emerald-600 text-white font-black text-[10px] flex items-center justify-center">GB</div>
                                        <span class="text-xs font-black uppercase tracking-wider text-emerald-400">Garanti • Bonus</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-[10px] text-slate-400">NFC 📶</span>
                                        <div class="w-7 h-5 rounded bg-amber-400 border border-amber-300 font-mono text-[8px] font-bold flex items-center justify-center text-amber-950 shadow-xs">CHIP</div>
                                    </div>
                                </div>
                                <div class="my-2 relative z-10">
                                    <span class="font-mono text-sm tracking-widest text-slate-300">•••• •••• •••• 8412</span>
                                    <div class="mt-1 flex items-center gap-1.5 text-[11px] font-bold text-amber-400">
                                        <span class="w-2 h-2 rounded-full bg-amber-400 animate-ping"></span>
                                        <span>18 Gündür Ödeme Yok (72 Gün Kaldı)</span>
                                    </div>
                                </div>
                                <div class="pt-2.5 border-t border-slate-800 flex justify-between items-end relative z-10">
                                    <div>
                                        <span class="text-[9px] text-slate-400 font-bold block uppercase">Dönem Borcu</span>
                                        <span class="text-lg font-black text-red-400">₺78.450</span>
                                    </div>
                                    <button type="button" class="btn-flip-card px-2.5 py-1 rounded-md bg-slate-800/90 text-[10px] font-bold text-slate-300 border border-slate-700 hover:text-white flex items-center gap-1">
                                        <span>🔄 Detayı Gör</span>
                                    </button>
                                </div>
                            </div>
                            <!-- Arka Yüz (Detay & Faiz Analizi) -->
                            <div class="flip-card-back p-5 rounded-2xl bg-slate-900 border-2 border-emerald-500/50 shadow-2xl flex flex-col justify-between text-xs">
                                <div class="flex justify-between items-center border-b border-slate-800 pb-2">
                                    <span class="font-bold text-emerald-400">Garanti Bonus Detayı</span>
                                    <button type="button" class="btn-flip-card px-2 py-0.5 rounded bg-slate-800 text-[10px] text-slate-300">↩ Geri Dön</button>
                                </div>
                                <div class="space-y-1.5 my-2">
                                    <div class="flex justify-between text-slate-300"><span>Aylık Asgari Ödeme:</span><strong class="text-white">₺31.380</strong></div>
                                    <div class="flex justify-between text-slate-300"><span>Gecikme Faizi Oranı:</span><strong class="text-red-400">%5.30 / ay</strong></div>
                                    <div class="flex justify-between text-slate-300"><span>Çığ Algoritması Sırası:</span><strong class="text-indigo-400">#1 Öncelikli</strong></div>
                                </div>
                                <div class="p-2 rounded bg-slate-950/80 text-[10px] text-emerald-300 border border-emerald-800/40">
                                    💡 Bu kart kapatıldığında aylık ₺3.900 faiz tasarrufu sağlanır.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2: Yapı Kredi KMH -->
                    <div id="m-card-yapi-kredi" class="flip-card mobile-card-slide w-full h-[240px] hidden transition-all duration-300">
                        <div class="flip-card-inner rounded-2xl">
                            <div class="flip-card-front p-5 rounded-2xl bg-gradient-to-br from-blue-950 via-slate-900 to-slate-950 border-2 border-blue-500/50 shadow-2xl flex flex-col justify-between overflow-hidden relative">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-md bg-blue-600 text-white font-black text-[10px] flex items-center justify-center">YK</div>
                                        <span class="text-xs font-black uppercase tracking-wider text-blue-400">Yapı Kredi • Esnek KMH</span>
                                    </div>
                                    <span class="px-2 py-0.5 rounded bg-red-500/20 text-red-300 text-[9px] font-black border border-red-500/30">FAİZ: %5.00</span>
                                </div>
                                <div class="my-2">
                                    <span class="text-[10px] text-slate-400 font-semibold block uppercase">Ek Hesap Eksi Bakiye</span>
                                    <span class="text-2xl font-black text-red-500">-₺65.000</span>
                                </div>
                                <div class="pt-2.5 border-t border-slate-800 flex justify-between items-end">
                                    <div>
                                        <span class="text-[9px] text-slate-400 font-bold block">AYLIK FAİZ YÜKÜ</span>
                                        <span class="text-sm font-bold text-red-400">₺3.250 / ay</span>
                                    </div>
                                    <button type="button" class="btn-flip-card px-2.5 py-1 rounded-md bg-slate-800/90 text-[10px] font-bold text-slate-300 border border-slate-700 hover:text-white flex items-center gap-1">
                                        <span>🔄 Detayı Gör</span>
                                    </button>
                                </div>
                            </div>
                            <div class="flip-card-back p-5 rounded-2xl bg-slate-900 border-2 border-blue-500/50 shadow-2xl flex flex-col justify-between text-xs">
                                <div class="flex justify-between items-center border-b border-slate-800 pb-2">
                                    <span class="font-bold text-blue-400">Yapı Kredi KMH Detayı</span>
                                    <button type="button" class="btn-flip-card px-2 py-0.5 rounded bg-slate-800 text-[10px] text-slate-300">↩ Geri Dön</button>
                                </div>
                                <div class="space-y-1.5 my-2">
                                    <div class="flex justify-between text-slate-300"><span>Günlük Faiz Maliyeti:</span><strong class="text-white">₺108.33 / gün</strong></div>
                                    <div class="flex justify-between text-slate-300"><span>Gecikme Durumu:</span><strong class="text-emerald-400">Düzenli Ödeniyor</strong></div>
                                </div>
                                <div class="p-2 rounded bg-slate-950/80 text-[10px] text-indigo-300 border border-indigo-800/40">
                                    💡 KMH borçları günlük faiz işlettiği için öncelikli kapatılmalıdır.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3: Akbank Axess -->
                    <div id="m-card-akbank" class="flip-card mobile-card-slide w-full h-[240px] hidden transition-all duration-300">
                        <div class="flip-card-inner rounded-2xl">
                            <div class="flip-card-front p-5 rounded-2xl bg-gradient-to-br from-rose-950 via-slate-900 to-slate-950 border-2 border-rose-500/50 shadow-2xl flex flex-col justify-between overflow-hidden relative">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-md bg-rose-600 text-white font-black text-[10px] flex items-center justify-center">AK</div>
                                        <span class="text-xs font-black uppercase tracking-wider text-rose-400">Akbank • Axess</span>
                                    </div>
                                    <div class="w-7 h-5 rounded bg-amber-400 border border-amber-300 font-mono text-[8px] font-bold flex items-center justify-center text-amber-950 shadow-xs">CHIP</div>
                                </div>
                                <div class="my-2">
                                    <span class="font-mono text-sm tracking-widest text-slate-300">•••• •••• •••• 1907</span>
                                    <span class="text-[11px] text-amber-400 font-bold block mt-1">⚠️ Son Ödeme: 4 Gün Kaldı</span>
                                </div>
                                <div class="pt-2.5 border-t border-slate-800 flex justify-between items-end">
                                    <div>
                                        <span class="text-[9px] text-slate-400 font-bold block uppercase">Dönem Borcu</span>
                                        <span class="text-lg font-black text-red-400">₺52.000</span>
                                    </div>
                                    <button type="button" class="btn-flip-card px-2.5 py-1 rounded-md bg-slate-800/90 text-[10px] font-bold text-slate-300 border border-slate-700 hover:text-white flex items-center gap-1">
                                        <span>🔄 Detayı Gör</span>
                                    </button>
                                </div>
                            </div>
                            <div class="flip-card-back p-5 rounded-2xl bg-slate-900 border-2 border-rose-500/50 shadow-2xl flex flex-col justify-between text-xs">
                                <div class="flex justify-between items-center border-b border-slate-800 pb-2">
                                    <span class="font-bold text-rose-400">Akbank Axess Detayı</span>
                                    <button type="button" class="btn-flip-card px-2 py-0.5 rounded bg-slate-800 text-[10px] text-slate-300">↩ Geri Dön</button>
                                </div>
                                <div class="space-y-1.5 my-2">
                                    <div class="flex justify-between text-slate-300"><span>Asgari Tutar:</span><strong class="text-white">₺20.800</strong></div>
                                    <div class="flex justify-between text-slate-300"><span>Akdi Faiz:</span><strong class="text-amber-400">%4.25</strong></div>
                                </div>
                                <div class="p-2 rounded bg-slate-950/80 text-[10px] text-amber-300 border border-amber-800/40">
                                    💡 4 gün içinde asgari ödeme yapılmazsa gecikme faizi devreye girer.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 4: Ziraat Kredi -->
                    <div id="m-card-ziraat" class="flip-card mobile-card-slide w-full h-[240px] hidden transition-all duration-300">
                        <div class="flip-card-inner rounded-2xl">
                            <div class="flip-card-front p-5 rounded-2xl bg-gradient-to-br from-red-950 via-slate-900 to-slate-950 border-2 border-red-500/50 shadow-2xl flex flex-col justify-between overflow-hidden relative">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-md bg-red-600 text-white font-black text-[10px] flex items-center justify-center">ZB</div>
                                        <span class="text-xs font-black uppercase tracking-wider text-red-400">Ziraat Bankası • Kredi</span>
                                    </div>
                                    <span class="text-[10px] text-emerald-400 font-bold bg-emerald-950/60 px-2 py-0.5 rounded">24 Taksit Kaldı</span>
                                </div>
                                <div class="my-2">
                                    <span class="text-[10px] text-slate-400 font-semibold block uppercase">Kalan Anapara</span>
                                    <span class="text-2xl font-black text-white">₺140.000</span>
                                </div>
                                <div class="pt-2.5 border-t border-slate-800 flex justify-between items-end">
                                    <div>
                                        <span class="text-[9px] text-slate-400 font-bold block">AYLIK TAKSİT</span>
                                        <span class="text-sm font-bold text-white">₺7.200 / ay</span>
                                    </div>
                                    <button type="button" class="btn-flip-card px-2.5 py-1 rounded-md bg-slate-800/90 text-[10px] font-bold text-slate-300 border border-slate-700 hover:text-white flex items-center gap-1">
                                        <span>🔄 Detayı Gör</span>
                                    </button>
                                </div>
                            </div>
                            <div class="flip-card-back p-5 rounded-2xl bg-slate-900 border-2 border-red-500/50 shadow-2xl flex flex-col justify-between text-xs">
                                <div class="flex justify-between items-center border-b border-slate-800 pb-2">
                                    <span class="font-bold text-red-400">Ziraat Kredi Detayı</span>
                                    <button type="button" class="btn-flip-card px-2 py-0.5 rounded bg-slate-800 text-[10px] text-slate-300">↩ Geri Dön</button>
                                </div>
                                <div class="space-y-1.5 my-2">
                                    <div class="flex justify-between text-slate-300"><span>Kalan Süre:</span><strong class="text-white">24 Ay</strong></div>
                                    <div class="flex justify-between text-slate-300"><span>Sabit Faiz Oranı:</span><strong class="text-slate-300">%3.89</strong></div>
                                </div>
                                <div class="p-2 rounded bg-slate-950/80 text-[10px] text-slate-300 border border-slate-800">
                                    💡 Krediler sabit faizli olduğundan erken kapatma yerine yüksek faizli kartlara öncelik verilmelidir.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <p class="text-[11px] text-slate-400 mt-3 flex items-center justify-center gap-1">
                    <span>👆 Kartları incelemek için yukarıdaki bankalara dokunun veya kartı çevirin</span>
                </p>
            </div>

            <!-- ========================================================================= -->
            <!-- 🖥️ MASAÜSTÜ 3D FLOATING APPLE-STYLE CARD DECK (EĞİMLİ & DÖNEN KARTLAR)  -->
            <!-- ========================================================================= -->
            <div class="hidden md:flex mt-20 relative max-w-5xl mx-auto min-h-[480px] items-center justify-center">
                
                <!-- Card 1: Garanti BBVA (Sol Üst - Eğimli) -->
                <div id="card-garanti" class="card-3d absolute -left-2 sm:left-4 top-4 w-64 sm:w-80 p-5 sm:p-6 rounded-2xl bg-gradient-to-br from-emerald-950 via-slate-900 to-slate-950 border border-emerald-500/30 shadow-2xl text-left transform -rotate-12 -translate-y-4 hover:rotate-0 hover:scale-105 transition-all duration-500 z-20 animate-float-1">
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
                <div id="card-yapi-kredi" class="card-3d absolute -right-2 sm:right-4 top-8 w-64 sm:w-80 p-5 sm:p-6 rounded-2xl bg-gradient-to-br from-blue-950 via-slate-900 to-slate-950 border border-blue-500/30 shadow-2xl text-left transform rotate-12 translate-y-2 hover:rotate-0 hover:scale-105 transition-all duration-500 z-20 animate-float-2">
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
                <div id="card-center-dashboard" class="card-3d relative w-full max-w-xl p-6 sm:p-8 rounded-2xl bg-slate-900/90 border-2 border-indigo-500/40 shadow-2xl shadow-indigo-950/80 backdrop-blur-2xl text-left z-30 transform hover:scale-[1.02] transition-all duration-500">
                    <div class="flex items-center justify-between border-b border-slate-800 pb-4">
                        <div class="flex items-center gap-3">
                            <span class="w-3 h-3 rounded-full bg-red-500 animate-ping"></span>
                            <div>
                                <h3 class="font-bold text-sm text-white">Canlı Risk Analizi & Sayaç</h3>
                                <p class="text-[11px] text-slate-400">Tüm Bankalar Aktif Takipte</p>
                            </div>
                        </div>
                        <span class="px-2.5 py-1 rounded-lg bg-red-500/20 text-red-300 text-xs font-black border border-red-500/30">
                            🚨 Yasal Takibe 24 Gün Kaldı
                        </span>
                    </div>

                    <div class="grid grid-cols-2 gap-4 my-6">
                        <div class="p-4 rounded-xl bg-slate-950/80 border border-slate-800">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">TOPLAM BORÇ YÜKÜ</span>
                            <span class="text-2xl font-black text-white mt-1 block">₺485.200</span>
                            <span class="text-[11px] text-emerald-400 font-semibold">↓ Çığ ile ₺62.000 Tasarruf</span>
                        </div>
                        <div class="p-4 rounded-xl bg-slate-950/80 border border-slate-800">
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
                <div id="card-ziraat" class="card-3d absolute -left-4 sm:left-12 -bottom-6 w-60 sm:w-72 p-4 sm:p-5 rounded-2xl bg-gradient-to-br from-red-950 via-slate-900 to-slate-950 border border-red-500/30 shadow-2xl text-left transform rotate-6 z-10 animate-float-3">
                    <span class="text-xs font-black uppercase text-red-400 block">Ziraat Bankası • İhtiyaç Kredisi</span>
                    <span class="text-lg font-black text-white mt-1 block">Kalan: ₺140.000</span>
                    <span class="text-[11px] text-slate-400">Taksit: ₺7.200 / ay (24 Taksit Kaldı)</span>
                </div>

                <!-- Card 5: Akbank Kart (Sağ Alt - Eğimli) -->
                <div id="card-akbank" class="card-3d absolute -right-4 sm:right-12 -bottom-6 w-60 sm:w-72 p-4 sm:p-5 rounded-2xl bg-gradient-to-br from-rose-950 via-slate-900 to-slate-950 border border-rose-500/30 shadow-2xl text-left transform -rotate-6 z-10 animate-float-1">
                    <span class="text-xs font-black uppercase text-rose-400 block">Akbank • Wings Kart</span>
                    <span class="text-lg font-black text-white mt-1 block">Dönem Borcu: ₺52.000</span>
                    <span class="text-[11px] text-amber-400 font-bold">⚠️ Son Ödeme: 4 Gün Kaldı</span>
                </div>
            </div>
        </section>

        <!-- ========================================================================= -->
        <!-- 2. SCROLLYTELLING: 90 GÜN YASAL TAKİP ERKEN UYARI SİSTEMİ                -->
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
                    Türkiye mevzuatında üst üste 3 asgari ödeme yapılmadığında (90 gün) bankalar yasal takip ve maaş haczi başlatır. DVT CRM, her borcunuz için takibe kalan günü anlık hesaplar ve kırmızı alarma geçirir.
                </p>
            </div>

            <!-- 4 Aşamalı Scrollytelling Adımları -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6 mt-12 sm:mt-16">
                <!-- Faz 1 -->
                <div class="p-6 rounded-2xl bg-slate-900 border border-slate-800 hover:border-slate-700 transition-all reveal-on-scroll space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-600/20 text-emerald-400 font-black text-sm flex items-center justify-center border border-emerald-500/30">
                        1-30
                    </div>
                    <h3 class="text-lg font-bold text-white">1 - 30. Gün: Gecikme</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        İlk son ödeme tarihi kaçırıldı. Sadece günlük gecikme faizi işler. KKB puanı hafif etkilenir.
                    </p>
                    <span class="inline-block text-[10px] font-bold text-emerald-400">Durum: Kontrol Altında</span>
                </div>

                <!-- Faz 2 -->
                <div class="p-6 rounded-2xl bg-slate-900 border border-slate-800 hover:border-slate-700 transition-all reveal-on-scroll space-y-3" style="transition-delay: 150ms;">
                    <div class="w-10 h-10 rounded-xl bg-amber-600/20 text-amber-400 font-black text-sm flex items-center justify-center border border-amber-500/30">
                        31-60
                    </div>
                    <h3 class="text-lg font-bold text-white">31 - 60. Gün: İdari Takip</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        İkinci asgari ödenmedi. Banka çağrı merkezi aramaları sıklaşır, kart kullanıma kapatılabilir.
                    </p>
                    <span class="inline-block text-[10px] font-bold text-amber-400">Durum: Uyarı Veriliyor</span>
                </div>

                <!-- Faz 3 -->
                <div class="p-6 rounded-2xl bg-slate-900 border border-slate-800 hover:border-slate-700 transition-all reveal-on-scroll space-y-3" style="transition-delay: 300ms;">
                    <div class="w-10 h-10 rounded-xl bg-orange-600/20 text-orange-400 font-black text-sm flex items-center justify-center border border-orange-500/30">
                        61-89
                    </div>
                    <h3 class="text-lg font-bold text-white">61 - 89. Gün: İhtarname</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Noter aracılığıyla yasal ihtar çekilir. Borcun tamamı muaccel hale gelir. 7 gün süre tanınır.
                    </p>
                    <span class="inline-block text-[10px] font-bold text-orange-400">Durum: Son Yapılandırma Şansı</span>
                </div>

                <!-- Faz 4 -->
                <div class="p-6 rounded-2xl bg-red-950/40 border border-red-600/50 hover:border-red-500 transition-all reveal-on-scroll space-y-3 shadow-xl" style="transition-delay: 450ms;">
                    <div class="w-10 h-10 rounded-xl bg-red-600 text-white font-black text-sm flex items-center justify-center animate-pulse">
                        90+
                    </div>
                    <h3 class="text-lg font-bold text-red-300">90. Gün+: Yasal Takip</h3>
                    <p class="text-xs text-red-200/80 leading-relaxed">
                        Dosya avukata devredilir, icra takibi ve maaş haczi başlar. Vekalet ücreti ve harçlar eklenir.
                    </p>
                    <span class="inline-block text-[10px] font-black text-red-400 animate-pulse">🚨 DVT Erken Uyarı ile Önlenir!</span>
                </div>
            </div>
        </section>

        <!-- ========================================================================= -->
        <!-- 3. MATEMATİKSEL KURTARMA ALGORİTMALARI: ÇIĞ (AVALANCHE) & KARTOPU        -->
        <!-- ========================================================================= -->
        <section id="nasil-calisir" class="py-16 sm:py-24 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto border-t border-slate-800/80">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="space-y-4 sm:space-y-6 reveal-on-scroll">
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

                    <div class="p-5 sm:p-6 bg-slate-900 border border-indigo-500/40 rounded-2xl space-y-4 shadow-xl">
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
                <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 sm:p-8 space-y-6 shadow-2xl reveal-on-scroll">
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
                        <div class="p-4 rounded-xl bg-slate-950 border border-slate-800">
                            <span class="text-[10px] font-bold text-slate-400 uppercase block">Kapanış Süresi</span>
                            <span id="sim-months-text" class="text-xl font-black text-emerald-400 mt-1 block">16 Ayda Biter</span>
                            <span class="text-[10px] text-slate-500">Asgari ödemeyle 48 ay sürer</span>
                        </div>
                        <div class="p-4 rounded-xl bg-slate-950 border border-slate-800">
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
        <!-- 4. 7/24 AI FİNANSAL KRİZ KOÇU & DESTEK SİSTEMİ                             -->
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
                    Yapay zeka finans koçunuz, veritabanınızdaki tüm faiz oranlarını ve vadeleri tarar. Banka aramalarında nasıl pazarlık yapacağınızı ve hangi borcu önce kapatmanız gerektiğini söyler.
                </p>
            </div>

            <!-- AI Soru-Cevap Simülatörü -->
            <div class="max-w-3xl mx-auto mt-12 bg-slate-900 border border-slate-800 rounded-2xl p-6 sm:p-8 space-y-6 shadow-2xl reveal-on-scroll">
                <!-- AI Mesajı -->
                <div class="flex items-start gap-3 sm:gap-4">
                    <div class="w-9 sm:w-10 h-9 sm:h-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center font-bold text-sm shrink-0 shadow-lg shadow-indigo-600/30">
                        AI
                    </div>
                    <div class="bg-slate-950 border border-slate-800 text-slate-200 rounded-xl p-4 text-xs sm:text-sm leading-relaxed space-y-2">
                        <p>
                            "Veritabanınızı taradım. <strong>Garanti Bonus</strong> kartınız 18 gündür gecikmede ve yasal takibe <strong>72 gün kaldı</strong>. Ayrıca <strong>Yapı Kredi KMH</strong> hesabınız %5.00 faiz işletiyor."
                        </p>
                        <p class="text-emerald-400 font-semibold">
                            → Tavsiye: Bu ay Yapı Kredi'ye ek ₺5.000 yatırarak faiz çığından kurtulun. Garanti için de en geç 10 gün içinde asgari tutarı yatırın.
                        </p>
                    </div>
                </div>

                <!-- Kullanıcı Sorusu -->
                <div class="flex items-start gap-3 sm:gap-4 justify-end">
                    <div class="bg-indigo-600 text-white rounded-xl p-3.5 sm:p-4 text-xs sm:text-sm max-w-xs sm:max-w-lg">
                        "Elimde fazladan ₺15.000 var, bankalarımdan hangisine yatırırsam en çok faizden tasarruf ederim?"
                    </div>
                    <div class="w-9 sm:w-10 h-9 sm:h-10 rounded-xl bg-slate-800 text-slate-300 flex items-center justify-center font-bold text-xs sm:text-sm shrink-0">
                        DA
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
                    <div class="p-4 sm:p-5 rounded-xl bg-slate-900 border border-slate-800 text-center space-y-2 hover:border-indigo-500 transition-all hover:scale-105">
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
            <div class="relative rounded-2xl bg-gradient-to-r from-indigo-900 via-indigo-950 to-slate-900 border-2 border-indigo-500/50 p-6 sm:p-16 text-center space-y-6 sm:space-y-8 overflow-hidden shadow-2xl shadow-indigo-950">
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
    <!-- INTERACTIVE SCRIPTS: 3D ROTATION, SCROLL-DRIVEN PHYSICS & FLIP            -->
    <!-- ========================================================================= -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // 1. Mobile Bank Tab Switching
            const tabs = document.querySelectorAll('.mobile-bank-tab');
            const slides = document.querySelectorAll('.mobile-card-slide');

            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    tabs.forEach(t => {
                        t.classList.remove('bg-indigo-600', 'text-white', 'shadow-md');
                        t.classList.add('text-slate-400');
                    });
                    tab.classList.add('bg-indigo-600', 'text-white', 'shadow-md');
                    tab.classList.remove('text-slate-400');

                    const targetId = tab.getAttribute('data-target');
                    slides.forEach(slide => {
                        if (slide.id === targetId) {
                            slide.classList.remove('hidden');
                            slide.classList.add('block');
                            slide.classList.remove('flipped'); // reset flip
                        } else {
                            slide.classList.add('hidden');
                            slide.classList.remove('block');
                        }
                    });
                });
            });

            // 2. Mobile 3D Flip Card Action
            const flipButtons = document.querySelectorAll('.btn-flip-card');
            flipButtons.forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const flipCard = btn.closest('.flip-card');
                    if (flipCard) {
                        flipCard.classList.toggle('flipped');
                    }
                });
            });

            // 3. Scroll Reveal Intersection Observer
            const revealElements = document.querySelectorAll('.reveal-on-scroll');
            if ('IntersectionObserver' in window) {
                const revealObserver = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('is-revealed');
                            observer.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.15 });

                revealElements.forEach(el => revealObserver.observe(el));
            } else {
                revealElements.forEach(el => el.classList.add('is-revealed'));
            }

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

            // 5. Scroll-Driven 3D Card Rotation Physics (Mobile & Desktop)
            const mobileStage = document.getElementById('mobile-3d-stage');
            const cardGaranti = document.getElementById('card-garanti');
            const cardYapiKredi = document.getElementById('card-yapi-kredi');
            const cardCenter = document.getElementById('card-center-dashboard');
            const cardZiraat = document.getElementById('card-ziraat');
            const cardAkbank = document.getElementById('card-akbank');
            const mobilePill = document.getElementById('mobile-floating-pill');

            window.addEventListener('scroll', () => {
                const scrolled = window.pageYOffset;
                const rate = scrolled * 0.12;

                // Mobile Frame-by-Frame 3D Scroll Rotation
                if (mobileStage && scrolled < 700) {
                    const rotX = (scrolled * 0.04).toFixed(1);
                    const rotY = (Math.sin(scrolled * 0.008) * 8).toFixed(1);
                    const rotZ = (-Math.cos(scrolled * 0.008) * 3).toFixed(1);
                    mobileStage.style.transform = `perspective(1000px) rotateX(${rotX}deg) rotateY(${rotY}deg) rotateZ(${rotZ}deg)`;
                }

                // Desktop 3D Cascading Parallax Floating
                if (cardGaranti) {
                    cardGaranti.style.transform = `translate3d(${-rate * 0.8}px, ${rate * 0.4}px, 0) rotate(${-12 - rate * 0.04}deg)`;
                }
                if (cardYapiKredi) {
                    cardYapiKredi.style.transform = `translate3d(${rate * 0.8}px, ${rate * 0.4}px, 0) rotate(${12 + rate * 0.04}deg)`;
                }
                if (cardZiraat) {
                    cardZiraat.style.transform = `translate3d(${-rate * 0.5}px, ${-rate * 0.2}px, 0) rotate(${6 + rate * 0.02}deg)`;
                }
                if (cardAkbank) {
                    cardAkbank.style.transform = `translate3d(${rate * 0.5}px, ${-rate * 0.2}px, 0) rotate(${-6 - rate * 0.02}deg)`;
                }
                if (cardCenter && scrolled < 600) {
                    cardCenter.style.transform = `translate3d(0, ${-rate * 0.25}px, 0) scale(${1 + scrolled * 0.00015})`;
                }

                // Show mobile floating pill after scrolling 300px
                if (mobilePill) {
                    if (scrolled > 350) {
                        mobilePill.classList.remove('translate-y-24', 'opacity-0', 'pointer-events-none');
                        mobilePill.classList.add('translate-y-0', 'opacity-100');
                        mobilePill.style.pointerEvents = 'auto';
                    } else {
                        mobilePill.classList.add('translate-y-24', 'opacity-0', 'pointer-events-none');
                        mobilePill.classList.remove('translate-y-0', 'opacity-100');
                    }
                }
            }, { passive: true });

            // 6. Desktop Mouse Tilt Interaction on Center Card
            if (cardCenter) {
                cardCenter.addEventListener('mousemove', (e) => {
                    const rect = cardCenter.getBoundingClientRect();
                    const x = e.clientX - rect.left - rect.width / 2;
                    const y = e.clientY - rect.top - rect.height / 2;
                    const rotateX = (-y / 25).toFixed(2);
                    const rotateY = (x / 25).toFixed(2);
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
