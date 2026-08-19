<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 sticky top-0 z-40 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Left Side: Logo (with 'Siteye dön' subline) & Main App Links -->
            <div class="flex items-center gap-4 lg:gap-6 min-w-0">
                <!-- Logo & Siteye Dön Link -->
                <div class="shrink-0 flex flex-col justify-center py-1">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                        <x-application-logo class="h-7 w-auto text-indigo-700" />
                    </a>
                    <a href="{{ route('home') }}" 
                       target="_blank" 
                       title="Tanıtım ve Ana Sayfaya Git"
                       class="text-[10px] font-bold text-slate-400 hover:text-indigo-600 flex items-center gap-0.5 transition-colors group mt-0.5 whitespace-nowrap">
                        <span class="group-hover:-translate-x-0.5 transition-transform text-[9px]">←</span>
                        <span>Siteye dön</span>
                    </a>
                </div>

                <!-- Complete Core Navigation Links (All 9 items: Single-Line, Responsive) -->
                <div class="hidden md:flex items-center space-x-0.5 lg:space-x-1 font-bold whitespace-nowrap overflow-x-auto no-scrollbar py-1">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="px-2 lg:px-2.5 xl:px-3 py-2 text-xs lg:text-sm">
                        Kontrol Paneli
                    </x-nav-link>
                    <x-nav-link :href="route('debts.index')" :active="request()->routeIs('debts.*')" class="px-2 lg:px-2.5 xl:px-3 py-2 text-xs lg:text-sm">
                        Borçlarım
                    </x-nav-link>
                    <x-nav-link :href="route('cards.index')" :active="request()->routeIs('cards.*')" class="px-2 lg:px-2.5 xl:px-3 py-2 text-xs lg:text-sm">
                        Kartlarım
                    </x-nav-link>
                    <x-nav-link :href="route('accounts.index')" :active="request()->routeIs('accounts.*')" class="px-2 lg:px-2.5 xl:px-3 py-2 text-xs lg:text-sm">
                        Hesaplarım
                    </x-nav-link>
                    <x-nav-link :href="route('cashflow.index')" :active="request()->routeIs('cashflow.*')" class="px-2 lg:px-2.5 xl:px-3 py-2 text-xs lg:text-sm">
                        Gelir/Gider
                    </x-nav-link>
                    <x-nav-link :href="route('planner.index')" :active="request()->routeIs('planner.*')" class="px-2 lg:px-2.5 xl:px-3 py-2 text-xs lg:text-sm">
                        Plan
                    </x-nav-link>
                    <x-nav-link :href="route('calendar.index')" :active="request()->routeIs('calendar.*')" class="px-2 lg:px-2.5 xl:px-3 py-2 text-xs lg:text-sm">
                        Takvim
                    </x-nav-link>
                    <x-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.*')" class="px-2 lg:px-2.5 xl:px-3 py-2 text-xs lg:text-sm">
                        Raporlar
                    </x-nav-link>
                    <x-nav-link :href="route('ai.coach')" :active="request()->routeIs('ai.*')" class="px-2 lg:px-2.5 xl:px-3 py-2 text-xs lg:text-sm text-indigo-600 font-extrabold flex items-center gap-1">
                        <span>🤖 AI Koç</span>
                    </x-nav-link>
                </div>
            </div>

            <!-- Right Side: User Profile Dropdown (Desktop) -->
            <div class="hidden md:flex items-center gap-2.5 shrink-0">
                <!-- User Profile & Role Panels Menu -->
                <x-dropdown align="right" width="72">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2.5 px-3 py-1.5 border border-gray-200/90 text-xs sm:text-sm font-bold rounded-xl text-gray-800 bg-gray-50/90 hover:bg-gray-100 hover:border-gray-300 focus:outline-none transition-all shadow-2xs">
                            <div class="w-6 h-6 rounded-lg bg-indigo-600 text-white flex items-center justify-center text-xs font-black shadow-xs">
                                {{ mb_substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div class="max-w-[110px] truncate text-xs font-bold">{{ Auth::user()->name }}</div>

                            <svg class="fill-current h-3.5 w-3.5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- User Info Card Header -->
                        <div class="p-3.5 border-b border-gray-100 bg-gradient-to-br from-gray-50 to-indigo-50/30 flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center font-black text-sm shadow-md shrink-0">
                                {{ mb_substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center gap-1.5">
                                    <p class="text-xs font-black text-gray-900 truncate">{{ Auth::user()->name }}</p>
                                </div>
                                <p class="text-[11px] text-gray-500 truncate">{{ Auth::user()->email }}</p>
                                
                                @if (Auth::user()->hasRole('super_admin'))
                                    <span class="inline-block mt-1 px-2 py-0.5 rounded-md bg-red-100 text-red-700 text-[9px] font-black border border-red-200">
                                        👑 SÜPER ADMİN
                                    </span>
                                @elseif (Auth::user()->hasRole('admin'))
                                    <span class="inline-block mt-1 px-2 py-0.5 rounded-md bg-indigo-100 text-indigo-700 text-[9px] font-black border border-indigo-200">
                                        🛡️ YÖNETİCİ
                                    </span>
                                @else
                                    <span class="inline-block mt-1 px-2 py-0.5 rounded-md bg-emerald-100 text-emerald-700 text-[9px] font-black border border-emerald-200">
                                        🟢 BİREYSEL HESAP
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Management & Admin Roles Section (If Applicable) -->
                        @if (Auth::user()->hasRole('super_admin') || Auth::user()->hasRole('admin'))
                            <div class="p-2 border-b border-gray-100 bg-slate-50/50 space-y-1">
                                <span class="px-2 py-0.5 text-[10px] font-black uppercase tracking-wider text-slate-500 block">Yönetim Panelleri</span>
                                
                                @if (Auth::user()->hasRole('super_admin'))
                                    <a href="/super" target="_blank" class="flex items-center justify-between p-2 rounded-lg bg-red-50/70 border border-red-200 text-red-700 font-bold text-xs hover:bg-red-100 transition-colors">
                                        <span class="flex items-center gap-2">
                                            <span>⚙️</span>
                                            <span>Süper Admin Paneli</span>
                                        </span>
                                        <span class="text-[9px] px-1.5 py-0.5 rounded bg-red-200 text-red-800 font-black">SUPER</span>
                                    </a>
                                @endif

                                @if (Auth::user()->hasRole('admin'))
                                    <a href="/admin" target="_blank" class="flex items-center justify-between p-2 rounded-lg bg-indigo-50/70 border border-indigo-200 text-indigo-700 font-bold text-xs hover:bg-indigo-100 transition-colors">
                                        <span class="flex items-center gap-2">
                                            <span>🛡️</span>
                                            <span>Yönetim Paneli</span>
                                        </span>
                                        <span class="text-[9px] px-1.5 py-0.5 rounded bg-indigo-200 text-indigo-800 font-black">ADMIN</span>
                                    </a>
                                @endif
                            </div>
                        @endif

                        <!-- General App Links -->
                        <div class="py-1 px-1 text-xs space-y-0.5">
                            <span class="px-2.5 py-1 text-[10px] font-bold text-gray-400 block uppercase tracking-wider">Hızlı Erişim</span>

                            <x-dropdown-link :href="route('banks.index')" class="flex items-center gap-2.5 px-2.5 py-2 rounded-lg hover:bg-gray-100 text-gray-700 font-bold">
                                <span>🏛️</span>
                                <span>Bankalarım & Kartlar</span>
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('calendar.index')" class="flex items-center gap-2.5 px-2.5 py-2 rounded-lg hover:bg-gray-100 text-gray-700 font-bold">
                                <span>📅</span>
                                <span>Ödeme Takvimi & Vadeler</span>
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('reports.index')" class="flex items-center gap-2.5 px-2.5 py-2 rounded-lg hover:bg-gray-100 text-gray-700 font-bold">
                                <span>📊</span>
                                <span>Finansal Raporlarım</span>
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('profile.edit')" class="flex items-center gap-2.5 px-2.5 py-2 rounded-lg hover:bg-gray-100 text-gray-700 font-bold">
                                <span>👤</span>
                                <span>Profil & Hesap Güvenliği</span>
                            </x-dropdown-link>
                        </div>

                        <!-- Logout -->
                        <div class="p-1 border-t border-gray-100 bg-gray-50/50">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-2.5 px-2.5 py-2 rounded-lg text-red-600 font-bold text-xs hover:bg-red-50 transition-colors text-left">
                                    <span>🚪</span>
                                    <span>Güvenli Çıkış Yap</span>
                                </button>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile Hamburger Button -->
            <div class="flex items-center md:hidden">
                <button @click="open = true" class="inline-flex items-center justify-center p-2 rounded-lg text-gray-700 bg-gray-50 hover:bg-gray-100 border border-gray-200 focus:outline-none transition-colors shadow-xs" aria-label="Menüyü Aç">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- ========================================================================= -->
    <!-- 📱 MOBILE SLIDE-OVER DRAWER (TEMA İLE %100 UYUMLU BEYAZ/AÇIK DÜZEN)       -->
    <!-- ========================================================================= -->
    <div x-show="open" 
         x-cloak
         @keydown.escape.window="open = false" 
         class="fixed inset-0 z-50 md:hidden" 
         style="display: none;">
        
        <!-- Dimmed Backdrop Overlay -->
        <div x-show="open"
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="open = false"
             class="fixed inset-0 bg-gray-900/50 backdrop-blur-xs transition-opacity">
        </div>

        <!-- Right Slide-Over Panel (Light Theme: White background & Gray borders) -->
        <div x-show="open"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="translate-x-full"
             class="fixed inset-y-0 right-0 w-full max-w-xs bg-white border-l border-gray-200 shadow-2xl flex flex-col justify-between overflow-hidden z-50 text-gray-900">
            
            <!-- Drawer Header & Navigation (Scrollable) -->
            <div class="flex-1 overflow-y-auto px-5 py-5 space-y-4">
                <!-- Top Brand & Close Button Bar -->
                <div class="flex items-center justify-between border-b border-gray-100 pb-3.5">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                        <x-application-logo class="h-7 w-auto text-indigo-700" />
                    </a>
                    <button @click="open = false" class="p-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-600 hover:text-gray-900 transition-colors cursor-pointer">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Core Navigation Links (Clean Light Theme) -->
                <div class="space-y-1">
                    <span class="text-[10px] font-black uppercase tracking-wider text-gray-400 px-1 block mb-1">Finansal Menü</span>
                    
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs font-bold transition-all {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-700 border-l-4 border-indigo-600' : 'text-gray-700 hover:bg-gray-50 hover:text-indigo-600' }}">
                        <span>📊</span>
                        <span>Kontrol Paneli</span>
                    </a>

                    <a href="{{ route('debts.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs font-bold transition-all {{ request()->routeIs('debts.*') ? 'bg-indigo-50 text-indigo-700 border-l-4 border-indigo-600' : 'text-gray-700 hover:bg-gray-50 hover:text-indigo-600' }}">
                        <span>💳</span>
                        <span>Borçlarım</span>
                    </a>

                    <a href="{{ route('cards.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs font-bold transition-all {{ request()->routeIs('cards.*') ? 'bg-indigo-50 text-indigo-700 border-l-4 border-indigo-600' : 'text-gray-700 hover:bg-gray-50 hover:text-indigo-600' }}">
                        <span>💳</span>
                        <span>Kartlarım</span>
                    </a>

                    <a href="{{ route('accounts.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs font-bold transition-all {{ request()->routeIs('accounts.*') ? 'bg-indigo-50 text-indigo-700 border-l-4 border-indigo-600' : 'text-gray-700 hover:bg-gray-50 hover:text-indigo-600' }}">
                        <span>🏦</span>
                        <span>Hesaplarım & KMH</span>
                    </a>

                    <a href="{{ route('cashflow.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs font-bold transition-all {{ request()->routeIs('cashflow.*') ? 'bg-indigo-50 text-indigo-700 border-l-4 border-indigo-600' : 'text-gray-700 hover:bg-gray-50 hover:text-indigo-600' }}">
                        <span>📈</span>
                        <span>Gelir / Gider</span>
                    </a>

                    <a href="{{ route('planner.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs font-bold transition-all {{ request()->routeIs('planner.*') ? 'bg-indigo-50 text-indigo-700 border-l-4 border-indigo-600' : 'text-gray-700 hover:bg-gray-50 hover:text-indigo-600' }}">
                        <span>🎯</span>
                        <span>Ödeme Planı (Çığ / Kartopu)</span>
                    </a>

                    <a href="{{ route('calendar.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs font-bold transition-all {{ request()->routeIs('calendar.*') ? 'bg-indigo-50 text-indigo-700 border-l-4 border-indigo-600' : 'text-gray-700 hover:bg-gray-50 hover:text-indigo-600' }}">
                        <span>📅</span>
                        <span>Ödeme Takvimi & Vadeler</span>
                    </a>

                    <a href="{{ route('reports.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs font-bold transition-all {{ request()->routeIs('reports.*') ? 'bg-indigo-50 text-indigo-700 border-l-4 border-indigo-600' : 'text-gray-700 hover:bg-gray-50 hover:text-indigo-600' }}">
                        <span>📑</span>
                        <span>Finansal Raporlar</span>
                    </a>

                    <!-- AI Coach Highlight Link -->
                    <a href="{{ route('ai.coach') }}" class="flex items-center justify-between px-3 py-2 rounded-lg text-xs font-bold transition-all {{ request()->routeIs('ai.*') ? 'bg-indigo-100 text-indigo-800 border-l-4 border-indigo-600' : 'bg-indigo-50/80 border border-indigo-100 text-indigo-700 hover:bg-indigo-100' }}">
                        <span class="flex items-center gap-2">
                            <span>🤖</span>
                            <span>AI Finans Koçu</span>
                        </span>
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    </a>

                    <a href="{{ route('banks.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs font-bold transition-all {{ request()->routeIs('banks.*') ? 'bg-indigo-50 text-indigo-700 border-l-4 border-indigo-600' : 'text-gray-700 hover:bg-gray-50 hover:text-indigo-600' }}">
                        <span>🏛️</span>
                        <span>Bankalarım</span>
                    </a>
                </div>

                <!-- Yetkili Panelleri & Alt Bilgiler -->
                @if (Auth::user()->hasRole('super_admin') || Auth::user()->hasRole('admin'))
                    <div class="space-y-1.5 pt-3 border-t border-gray-100">
                        <span class="text-[10px] font-black uppercase tracking-wider text-indigo-600 px-1 block">Yetkili Panelleri</span>
                        <div class="grid grid-cols-1 gap-1.5">
                            @if (Auth::user()->hasRole('super_admin'))
                                <a href="/super" target="_blank" class="flex items-center justify-between p-2.5 rounded-lg bg-red-50 border border-red-200 text-red-700 font-bold text-xs hover:bg-red-100 transition-colors">
                                    <span class="flex items-center gap-2">
                                        <span>⚙️</span>
                                        <span>Süper Admin Paneli</span>
                                    </span>
                                    <span class="text-[9px] px-1.5 py-0.5 rounded bg-red-200 text-red-800 font-black">SUPER</span>
                                </a>
                            @endif
                            @if (Auth::user()->hasRole('admin'))
                                <a href="/admin" target="_blank" class="flex items-center justify-between p-2.5 rounded-lg bg-indigo-50 border border-indigo-200 text-indigo-700 font-bold text-xs hover:bg-indigo-100 transition-colors">
                                    <span class="flex items-center gap-2">
                                        <span>🛡️</span>
                                        <span>Yönetim Paneli</span>
                                    </span>
                                    <span class="text-[9px] px-1.5 py-0.5 rounded bg-indigo-200 text-indigo-800 font-black">ADMIN</span>
                                </a>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            <!-- Drawer Bottom Actions (User Profile & Account Settings Pinned to Bottom) -->
            <div class="p-4 border-t border-gray-100 bg-gray-50 space-y-2">
                <!-- User Profile Card -->
                <div class="p-2.5 rounded-xl bg-white border border-gray-200 shadow-2xs flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-indigo-600 text-white flex items-center justify-center font-black text-xs shadow-xs shrink-0">
                        {{ mb_substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="font-bold text-xs text-gray-900 truncate">{{ Auth::user()->name }}</p>
                        <p class="text-[10px] text-gray-500 truncate">{{ Auth::user()->email }}</p>
                    </div>
                </div>

                <div class="space-y-1">
                    <a href="{{ route('home') }}" class="flex items-center justify-between px-3 py-1.5 rounded-lg text-xs font-bold text-indigo-700 bg-indigo-50/70 border border-indigo-100 hover:bg-indigo-100 transition-colors">
                        <span class="flex items-center gap-2">
                            <span>🌐</span>
                            <span>DVT Bank Ana Sayfası</span>
                        </span>
                        <span>→</span>
                    </a>

                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5 w-full px-3 py-1.5 rounded-lg text-xs font-bold text-gray-700 hover:bg-white hover:text-indigo-600 transition-all">
                        <span>👤</span>
                        <span>Profil & Güvenlik Ayarları</span>
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit" class="flex items-center gap-2.5 w-full px-3 py-1.5 rounded-lg text-xs font-bold text-red-600 hover:bg-red-50 transition-colors text-left cursor-pointer">
                            <span>🚪</span>
                            <span>Güvenli Çıkış Yap</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>
