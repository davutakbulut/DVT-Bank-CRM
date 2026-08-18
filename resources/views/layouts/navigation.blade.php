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

                <!-- Core Navigation Links (Single-Line, No Wrap, No Jitter) -->
                <div class="hidden xl:flex items-center space-x-1 sm:space-x-2 text-sm font-bold whitespace-nowrap">
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

                <!-- Mid-Screen View Links (Tablet / Medium Screens) -->
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

            <!-- Right Side: User Profile & Dedicated Role Panels Menu -->
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
                                        <span class="text-[9px] px-1.5 py-0.5 rounded bg-red-100 text-red-700">SUPER</span>
                                    </x-dropdown-link>
                                @endif
                                @if (Auth::user()->hasRole('admin'))
                                    <x-dropdown-link href="/admin" target="_blank" class="flex items-center justify-between text-purple-600 font-bold hover:bg-purple-50">
                                        <span>🛡️ Yönetim Paneli</span>
                                        <span class="text-[9px] px-1.5 py-0.5 rounded bg-purple-100 text-purple-700">ADMIN</span>
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
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-gray-500 hover:text-gray-700 hover:bg-gray-100 focus:outline-none transition duration-150">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Mobile Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden border-t border-gray-100 bg-white">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                Kontrol Paneli
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('debts.index')" :active="request()->routeIs('debts.*')">
                Borçlarım
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('cards.index')" :active="request()->routeIs('cards.*')">
                Kartlarım
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('accounts.index')" :active="request()->routeIs('accounts.*')">
                Hesaplarım & KMH
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('cashflow.index')" :active="request()->routeIs('cashflow.*')">
                Gelir/Gider
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('planner.index')" :active="request()->routeIs('planner.*')">
                🎯 Ödeme Planı
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('calendar.index')" :active="request()->routeIs('calendar.*')">
                📅 Takvim & Vadeler
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.*')">
                📊 Finansal Raporlar
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('ai.coach')" :active="request()->routeIs('ai.*')" class="text-indigo-600 font-bold">
                🤖 AI Finans Koçu
            </x-responsive-nav-link>
        </div>

        <!-- Mobile Admin Panels & User Profile -->
        <div class="pt-4 pb-3 border-t border-gray-100 bg-gray-50/50">
            <div class="px-4 mb-3">
                <div class="font-bold text-sm text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-xs text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            @if (Auth::user()->hasRole('super_admin') || Auth::user()->hasRole('admin'))
                <div class="px-4 py-2 mb-2 bg-indigo-50/50 border-y border-indigo-100/50 space-y-1">
                    <span class="text-[10px] font-black uppercase text-indigo-500 block">Yetkili Yönetim Panelleri</span>
                    @if (Auth::user()->hasRole('super_admin'))
                        <a href="/super" target="_blank" class="block text-xs font-bold text-red-600 py-1">
                            ⚙️ Süper Admin Paneli →
                        </a>
                    @endif
                    @if (Auth::user()->hasRole('admin'))
                        <a href="/admin" target="_blank" class="block text-xs font-bold text-purple-600 py-1">
                            🛡️ Yönetim Paneli →
                        </a>
                    @endif
                </div>
            @endif

            <div class="space-y-1">
                <x-responsive-nav-link :href="route('banks.index')">
                    🏛️ Bankalarım
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('profile.edit')">
                    👤 Profil & Güvenlik
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();" class="text-red-600 font-bold">
                        🚪 Çıkış Yap
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
