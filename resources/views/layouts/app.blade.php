<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-100 min-h-screen">
        <div class="min-h-screen flex flex-col justify-between">
            <div class="flex-1 flex flex-col">
                @include('layouts.navigation')

                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-white shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main class="py-6 flex-1">
                    {{ $slot }}
                </main>
            </div>

            <!-- Application Footer -->
            <footer class="bg-white border-t border-gray-200 mt-auto text-gray-600 text-sm shrink-0">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                        <!-- Brand Column -->
                        <div class="space-y-3">
                            <div class="flex items-center gap-2">
                                <span class="text-xl font-black text-indigo-700 tracking-tight">🏛️ DVT Bank CRM</span>
                            </div>
                            <p class="text-xs text-gray-500 leading-relaxed">
                                Matematiksel borç kurtarma stratejileri (Çığ & Kartopu), 90 günlük yasal takip erken uyarı sistemi ve 7/24 AI finansal kriz koçu.
                            </p>
                            <div class="flex items-center gap-2 text-xs font-semibold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-lg w-fit">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                <span>Canlı DB Aktif</span>
                            </div>
                        </div>

                        <!-- Core Navigation -->
                        <div>
                            <h4 class="text-xs font-bold uppercase tracking-wider text-gray-900 mb-3">Yönetim Modülleri</h4>
                            <ul class="space-y-2 text-xs font-medium">
                                <li><a href="{{ route('dashboard') }}" class="hover:text-indigo-600 transition-colors">📊 Kontrol Paneli</a></li>
                                <li><a href="{{ route('debts.index') }}" class="hover:text-indigo-600 transition-colors">💳 Borçlarım & Krediler</a></li>
                                <li><a href="{{ route('cards.index') }}" class="hover:text-indigo-600 transition-colors">💳 Kredi Kartlarım</a></li>
                                <li><a href="{{ route('accounts.index') }}" class="hover:text-indigo-600 transition-colors">🏦 Hesap & KMH / Eksi Bakiye</a></li>
                                <li><a href="{{ route('cashflow.index') }}" class="hover:text-indigo-600 transition-colors">📈 Gelir & Gider Akışı</a></li>
                            </ul>
                        </div>

                        <!-- Planning & AI -->
                        <div>
                            <h4 class="text-xs font-bold uppercase tracking-wider text-gray-900 mb-3">Kurtarma & Zeka</h4>
                            <ul class="space-y-2 text-xs font-medium">
                                <li><a href="{{ route('planner.index') }}" class="hover:text-indigo-600 transition-colors">🎯 Çığ vs Kartopu Planlayıcı</a></li>
                                <li><a href="{{ route('ai.coach') }}" class="hover:text-indigo-600 transition-colors font-bold text-indigo-600">🤖 7/24 AI Finans Koçu</a></li>
                                <li><a href="{{ route('calendar.index') }}" class="hover:text-indigo-600 transition-colors">📅 Ödeme & Vade Takvimi</a></li>
                                <li><a href="{{ route('reports.index') }}" class="hover:text-indigo-600 transition-colors">📑 Banka Maliyet Raporları</a></li>
                                <li><a href="{{ route('banks.index') }}" class="hover:text-indigo-600 transition-colors">🏛️ Banka Listem</a></li>
                            </ul>
                        </div>

                        <!-- System & Legal -->
                        <div>
                            <h4 class="text-xs font-bold uppercase tracking-wider text-gray-900 mb-3">Güvenlik & Yasal</h4>
                            <ul class="space-y-2 text-xs font-medium">
                                <li><a href="{{ route('profile.edit') }}" class="hover:text-indigo-600 transition-colors">🔒 Profil & Güvenlik</a></li>
                                <li><a href="{{ route('legal.kvkk') }}" class="hover:text-indigo-600 transition-colors">📜 KVKK Aydınlatma</a></li>
                                <li><a href="{{ route('legal.privacy') }}" class="hover:text-indigo-600 transition-colors">🛡️ Gizlilik Politikası</a></li>
                                <li><a href="{{ route('legal.disclaimer') }}" class="hover:text-indigo-600 transition-colors">⚖️ Yasal Sorumluluk Reddi</a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Bottom Bar & Legal Notice -->
                    <div class="pt-6 border-t border-gray-100 flex flex-col md:flex-row items-center justify-between gap-4 text-xs text-gray-500">
                        <p>© {{ date('Y') }} DVT Bank CRM. Tüm hakları saklıdır.</p>
                        <p class="text-center md:text-right max-w-2xl text-[11px] text-gray-400">
                            <strong>Önemli Uyarı:</strong> Bu platformdaki hesaplamalar ve AI koç analizleri kullanıcı tarafından girilen verilere dayalı bir simülasyon ve takip desteğidir; yatırım danışmanlığı veya resmi finansal müşavirlik hizmeti niteliği taşımaz.
                        </p>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
