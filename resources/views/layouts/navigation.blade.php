<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 sticky top-0 z-40 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Left Side: Logo & Main App Links -->
            <div class="flex items-center gap-6 xl:gap-8 min-w-0">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                        <x-application-logo class="h-8 w-auto text-indigo-700" />
                    </a>
                </div>

                <!-- Core Navigation Links (Desktop: Single-Line, No Wrap) -->
                <div class="hidden xl:flex items-center space-x-1 text-sm font-bold whitespace-nowrap">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="px-3 py-2 text-xs xl:text-sm">
                        Kontrol Paneli
                    </x-nav-link>
                    <x-nav-link :href="route('debts.index')" :active="request()->routeIs('debts.*')" class="px-3 py-2 text-xs xl:text-sm">
                        Borçlarım
                    </x-nav-link>
                    <x-nav-link :href="route('cards.index')" :active="request()->routeIs('cards.*')" class="px-3 py-2 text-xs xl:text-sm">
                        Kartlarım
                    </x-nav-link>
                    <x-nav-link :href="route('accounts.index')" :active="request()->routeIs('accounts.*')" class="px-3 py-2 text-xs xl:text-sm">
                        Hesaplarım
                    </x-nav-link>
                    <x-nav-link :href="route('cashflow.index')" :active="request()->routeIs('cashflow.*')" class="px-3 py-2 text-xs xl:text-sm">
                        Gelir/Gider
                    </x-nav-link>
                    <x-nav-link :href="route('planner.index')" :active="request()->routeIs('planner.*')" class="px-3 py-2 text-xs xl:text-sm">
                        Plan
                    </x-nav-link>
                    <x-nav-link :href="route('calendar.index')" :active="request()->routeIs('calendar.*')" class="px-3 py-2 text-xs xl:text-sm">
                        Takvim
                    </x-nav-link>
                    <x-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.*')" class="px-3 py-2 text-xs xl:text-sm">
                        Raporlar
                    </x-nav-link>
                    <x-nav-link :href="route('ai.coach')" :active="request()->routeIs('ai.*')" class="px-3 py-2 text-xs xl:text-sm text-indigo-600 font-extrabold flex items-center gap-1">
                        <span>🤖 AI Koç</span>
                    </x-nav-link>
                </div>

                <!-- Mid-Screen View Links (Tablet) -->
                <div class="hidden md:flex xl:hidden items-center space-x-1 text-xs font-bold whitespace-nowrap">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="px-2 py-2">
                        Panel
                    </x-nav-link>
                    <x-nav-link :href="route('debts.index')" :active="request()->routeIs('debts.*')" class="px-2 py-2">
                        Borçlar
                    </x-nav-link>
                    <x-nav-link :href="route('cards.index')" :active="request()->routeIs('cards.*')" class="px-2 py-2">
                        Kartlar
                    </x-nav-link>
                    <x-nav-link :href="route('accounts.index')" :active="request()->routeIs('accounts.*')" class="px-2 py-2">
                        Hesaplar
                    </x-nav-link>
                    <x-nav-link :href="route('cashflow.index')" :active="request()->routeIs('cashflow.*')" class="px-2 py-2">
                        Nakit
                    </x-nav-link>
                    <x-nav-link :href="route('planner.index')" :active="request()->routeIs('planner.*')" class="px-2 py-2">
                        Plan
                    </x-nav-link>
                    <x-nav-link :href="route('ai.coach')" :active="request()->routeIs('ai.*')" class="px-2 py-2 text-indigo-600 font-extrabold">
                        AI Koç
                    </x-nav-link>
                </div>
            </div>

            <!-- Right Side: User Profile & Dedicated Role Panels Menu (Desktop) -->
            <div class="hidden md:flex items-center gap-3 shrink-0">
                <x-dropdown align="right" width="56">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2 px-3.5 py-2 border border-gray-200 text-xs sm:text-sm font-bold rounded-xl text-gray-800 bg-gray-50 hover:bg-gray-100 hover:border-gray-300 focus:outline-none transition-all duration-150 shadow-sm">
                            <div class="w-6 h-6 rounded-full bg-indigo-600 text-white flex items-center justify-center text-xs font-black">
                                {{ mb_substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div class="max-w-[120px] truncate">{{ Auth::user()->name }}</div>

                            <svg class="fill-current h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- User Info Header -->
                        <div class="px-4 py-2.5 border-b border-gray-100 bg-gray-50/70">
                            <p class="text-xs font-bold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                            <p class="text-[11px] text-gray-500 truncate">{{ Auth::user()->email }}</p>
                        </div>

                        <!-- Management & Admin Roles Section -->
                        @if (Auth::user()->hasRole('super_admin') || Auth::user()->hasRole('admin'))
                            <div class="py-1 border-b border-gray-100 bg-indigo-50/30">
                                <span class="px-4 py-1 text-[10px] font-black uppercase tracking-wider text-indigo-500 block">Yönetim Panelleri</span>
                                @if (Auth::user()->hasRole('super_admin'))
                                    <x-dropdown-link href="/super" target="_blank" class="flex items-center justify-between text-red-600 font-bold hover:bg-red-50">
                                        <span>⚙️ Süper Admin Paneli</span>
                                        <span class="text-[9px] px-1.5 py-0.5 rounded bg-red-100 text-red-700 font-black">SUPER</span>
                                    </x-dropdown-link>
                                @endif
                                @if (Auth::user()->hasRole('admin'))
                                    <x-dropdown-link href="/admin" target="_blank" class="flex items-center justify-between text-purple-600 font-bold hover:bg-purple-50">
                                        <span>🛡️ Yönetim Paneli</span>
                                        <span class="text-[9px] px-1.5 py-0.5 rounded bg-purple-100 text-purple-700 font-black">ADMIN</span>
                                    </x-dropdown-link>
                                @endif
                            </div>
                        @endif

                        <!-- General App Links -->
                        <div class="py-1">
                            <x-dropdown-link :href="route('banks.index')" class="flex items-center gap-2">
                                <span>🏛️ Bankalarım</span>
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('calendar.index')" class="flex items-center gap-2">
                                <span>📅 Ödeme Takvimi</span>
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('reports.index')" class="flex items-center gap-2">
                                <span>📊 Finansal Raporlar</span>
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('profile.edit')" class="flex items-center gap-2">
                                <span>👤 Profil & Güvenlik</span>
                            </x-dropdown-link>
                        </div>

                        <!-- Logout -->
                        <div class="pt-1 border-t border-gray-100">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();" class="text-red-600 font-bold flex items-center gap-2 hover:bg-red-50">
                                    <span>🚪 Güvenli Çıkış Yap</span>
                                </x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile Hamburger Button -->
            <div class="flex items-center md:hidden">
                <button @click="open = true" class="inline-flex items-center justify-center p-2 rounded-xl text-gray-700 bg-gray-50 hover:bg-gray-100 border border-gray-200 focus:outline-none transition-colors shadow-sm" aria-label="Menüyü Aç">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- ========================================================================= -->
    <!-- 📱 MOBILE SLIDE-OVER DRAWER (SAĞDAN AÇILAN MODERN ÇEKMECE MENÜ)             -->
    <!-- ========================================================================= -->
    <div x-show="open" 
         x-cloak
         @keydown.escape.window="open = false" 
         class="fixed inset-0 z-50 md:hidden" 
         style="display: none;">
        
        <!-- Dimmed Backdrop Overlay (Sayfayı etkilemez, üstünde kalır) -->
        <div x-show="open"
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="open = false"
             class="fixed inset-0 bg-slate-950/70 backdrop-blur-sm transition-opacity">
        </div>

        <!-- Right Slide-Over Panel -->
        <div x-show="open"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="translate-x-full"
             class="fixed inset-y-0 right-0 w-full max-w-xs bg-slate-900 border-l border-slate-800 shadow-2xl flex flex-col justify-between overflow-hidden z-50 text-slate-100">
            
            <!-- Drawer Header & Navigation (Scrollable) -->
            <div class="flex-1 overflow-y-auto px-5 py-6 space-y-6">
                <!-- Top Brand & Close Button Bar -->
                <div class="flex items-center justify-between border-b border-slate-800 pb-4">
                    <div class="flex items-center gap-2">
                        <x-application-logo class="h-7 w-auto text-indigo-400" />
                        <span class="font-black text-sm text-white tracking-tight">DVT CRM</span>
                    </div>
                    <button @click="open = false" class="p-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-white transition-colors">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- User Profile Card -->
                <div class="p-3.5 rounded-2xl bg-slate-950 border border-slate-800 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center font-black text-sm shadow-md">
                        {{ mb_substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="font-bold text-sm text-white truncate">{{ Auth::user()->name }}</p>
                        <p class="text-[11px] text-slate-400 truncate">{{ Auth::user()->email }}</p>
                    </div>
                </div>

                <!-- Management Panels (If Super Admin / Admin) -->
                @if (Auth::user()->hasRole('super_admin') || Auth::user()->hasRole('admin'))
                    <div class="space-y-2">
                        <span class="text-[10px] font-black uppercase tracking-wider text-indigo-400 px-1 block">Yetkili Panelleri</span>
                        <div class="grid grid-cols-1 gap-2">
                            @if (Auth::user()->hasRole('super_admin'))
                                <a href="/super" target="_blank" class="flex items-center justify-between p-3 rounded-xl bg-red-950/40 border border-red-800/50 text-red-300 font-bold text-xs hover:bg-red-900/50 transition-colors">
                                    <span class="flex items-center gap-2">
                                        <span>⚙️</span>
                                        <span>Süper Admin Paneli</span>
                                    </span>
                                    <span class="text-[9px] px-1.5 py-0.5 rounded bg-red-500/20 text-red-400 font-black">SUPER</span>
                                </a>
                            @endif
                            @if (Auth::user()->hasRole('admin'))
                                <a href="/admin" target="_blank" class="flex items-center justify-between p-3 rounded-xl bg-purple-950/40 border border-purple-800/50 text-purple-300 font-bold text-xs hover:bg-purple-900/50 transition-colors">
                                    <span class="flex items-center gap-2">
                                        <span>🛡️</span>
                                        <span>Yönetim Paneli</span>
                                    </span>
                                    <span class="text-[9px] px-1.5 py-0.5 rounded bg-purple-500/20 text-purple-400 font-black">ADMIN</span>
                                </a>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Core Navigation Links -->
                <div class="space-y-1.5">
                    <span class="text-[10px] font-black uppercase tracking-wider text-slate-500 px-1 block">Finansal Menü</span>
                    
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <span>📊</span>
                        <span>Kontrol Paneli</span>
                    </a>

                    <a href="{{ route('debts.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('debts.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <span>💳</span>
                        <span>Borçlarım</span>
                    </a>

                    <a href="{{ route('cards.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('cards.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <span>💳</span>
                        <span>Kartlarım</span>
                    </a>

                    <a href="{{ route('accounts.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('accounts.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <span>🏦</span>
                        <span>Hesaplarım & KMH</span>
                    </a>

                    <a href="{{ route('cashflow.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('cashflow.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <span>📈</span>
                        <span>Gelir / Gider</span>
                    </a>

                    <a href="{{ route('planner.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('planner.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <span>🎯</span>
                        <span>Ödeme Planı (Çığ / Kartopu)</span>
                    </a>

                    <a href="{{ route('calendar.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('calendar.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <span>📅</span>
                        <span>Ödeme Takvimi & Vadeler</span>
                    </a>

                    <a href="{{ route('reports.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('reports.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <span>📑</span>
                        <span>Finansal Raporlar</span>
                    </a>

                    <!-- AI Coach Highlight Link -->
                    <a href="{{ route('ai.coach') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-black transition-all bg-indigo-950/80 border border-indigo-500/40 text-indigo-300 hover:bg-indigo-900 shadow-md">
                        <span class="flex items-center gap-2">
                            <span>🤖</span>
                            <span>AI Finans Koçu</span>
                        </span>
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                    </a>

                    <a href="{{ route('banks.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('banks.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <span>🏛️</span>
                        <span>Bankalarım</span>
                    </a>
                </div>
            </div>

            <!-- Drawer Bottom Actions (Pinned) -->
            <div class="p-5 border-t border-slate-800 bg-slate-950 space-y-2">
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 w-full px-3 py-2 rounded-xl text-xs font-bold text-slate-300 hover:bg-slate-800 hover:text-white transition-colors">
                    <span>👤</span>
                    <span>Profil & Güvenlik Ayarları</span>
                </a>

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 w-full px-3 py-2 rounded-xl text-xs font-bold text-red-400 hover:bg-red-950/40 hover:text-red-300 transition-colors text-left">
                        <span>🚪</span>
                        <span>Güvenli Çıkış Yap</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
