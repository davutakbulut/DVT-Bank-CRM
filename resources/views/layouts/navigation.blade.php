<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 sticky top-0 z-40 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="h-8 w-auto text-indigo-700" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-4 lg:space-x-6 sm:-my-px sm:ms-8 md:flex text-sm font-semibold">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        Kontrol Paneli
                    </x-nav-link>
                    <x-nav-link :href="route('debts.index')" :active="request()->routeIs('debts.*')">
                        Borçlarım
                    </x-nav-link>
                    <x-nav-link :href="route('cards.index')" :active="request()->routeIs('cards.*')">
                        Kartlarım
                    </x-nav-link>
                    <x-nav-link :href="route('accounts.index')" :active="request()->routeIs('accounts.*')">
                        Hesap & KMH
                    </x-nav-link>
                    <x-nav-link :href="route('cashflow.index')" :active="request()->routeIs('cashflow.*')">
                        Gelir/Gider
                    </x-nav-link>
                    <x-nav-link :href="route('planner.index')" :active="request()->routeIs('planner.*')">
                        🎯 Ödeme Planı
                    </x-nav-link>
                    <x-nav-link :href="route('ai.coach')" :active="request()->routeIs('ai.*')" class="text-indigo-600 font-bold">
                        🤖 AI Koç
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings & Roles -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-3">
                @if (Auth::user()->hasRole('super_admin'))
                    <a href="/super" target="_blank" class="px-2.5 py-1 bg-red-100 text-red-700 rounded-lg text-xs font-bold hover:bg-red-200 transition-colors">
                        ⚙️ Süper Admin
                    </a>
                @endif
                @if (Auth::user()->hasRole('admin'))
                    <a href="/admin" target="_blank" class="px-2.5 py-1 bg-purple-100 text-purple-700 rounded-lg text-xs font-bold hover:bg-purple-200 transition-colors">
                        🛡️ Yönetim Paneli
                    </a>
                @endif

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-bold rounded-xl text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1 text-gray-400">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('banks.index')">
                            Bankalarım
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('calendar.index')">
                            Takvim & Vadeler
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('reports.index')">
                            Raporlar & Projeksiyon
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('profile.edit')">
                            Hesap & Güvenlik
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();" class="text-red-600 font-semibold">
                                Çıkış Yap
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile Hamburger -->
            <div class="-me-2 flex items-center md:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
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
            <x-responsive-nav-link :href="route('ai.coach')" :active="request()->routeIs('ai.*')">
                🤖 AI Koç
            </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-2 border-t border-gray-100">
            <div class="px-4">
                <div class="font-bold text-sm text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-xs text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    Profil & Ayarlar
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();" class="text-red-600">
                        Çıkış Yap
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
