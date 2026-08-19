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

                <!-- Complete Core Navigation Links (All items: Single-Line, Responsive) -->
                <div class="hidden md:flex items-center space-x-0.5 lg:space-x-1 font-bold whitespace-nowrap overflow-x-auto no-scrollbar py-1">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="px-2 lg:px-2.5 xl:px-3 py-2 text-xs lg:text-sm">
                        Kontrol Paneli
                    </x-nav-link>
                    <x-nav-link :href="route('banks.index')" :active="request()->routeIs('banks.*')" class="px-2 lg:px-2.5 xl:px-3 py-2 text-xs lg:text-sm">
                        Bankalarım
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
                    <x-nav-link :href="route('ai.coach')" :active="request()->routeIs('ai.*')" class="px-2 lg:px-2.5 xl:px-3 py-2 text-xs lg:text-sm text-indigo-600 font-extrabold flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z"/></svg>
                        <span>AI Koç</span>
                    </x-nav-link>
                </div>
            </div>

            <!-- Right Side: User Profile Dropdown & Notifications (Desktop) -->
            <div class="hidden md:flex items-center gap-2.5 shrink-0">
                @if (!Auth::user()->onboarding_completed)
                    <a href="{{ route('onboarding.index') }}" 
                       title="İlk Kurulum Sihirbazını Tamamlayın"
                       class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-amber-50 hover:bg-amber-100 border border-amber-200 text-amber-800 text-xs font-bold rounded-xl transition-all shadow-2xs shrink-0">
                        <svg class="w-3.5 h-3.5 text-amber-600 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        <span>Sihirbazı Tamamla</span>
                    </a>
                @endif

                <!-- Bildirim Zili Dropdown -->
                @livewire('notifications.dropdown', key('notifications-dropdown-desktop'))

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
                                    <span class="inline-flex items-center gap-1 mt-1 px-2 py-0.5 rounded-md bg-red-100 text-red-700 text-[9px] font-black border border-red-200">
                                        <svg class="w-3 h-3 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751A11.959 11.959 0 0112 2.714z"/></svg>
                                        <span>SÜPER ADMİN</span>
                                    </span>
                                @elseif (Auth::user()->hasRole('admin'))
                                    <span class="inline-flex items-center gap-1 mt-1 px-2 py-0.5 rounded-md bg-indigo-100 text-indigo-700 text-[9px] font-black border border-indigo-200">
                                        <svg class="w-3 h-3 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751A11.959 11.959 0 0112 2.714z"/></svg>
                                        <span>YÖNETİCİ</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 mt-1 px-2 py-0.5 rounded-md bg-emerald-100 text-emerald-700 text-[9px] font-black border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                        <span>BİREYSEL HESAP</span>
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
                                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.343 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.28z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            <span>Süper Admin Paneli</span>
                                        </span>
                                        <span class="text-[9px] px-1.5 py-0.5 rounded bg-red-200 text-red-800 font-black">SUPER</span>
                                    </a>
                                @endif

                                @if (Auth::user()->hasRole('admin'))
                                    <a href="/admin" target="_blank" class="flex items-center justify-between p-2 rounded-lg bg-indigo-50/70 border border-indigo-200 text-indigo-700 font-bold text-xs hover:bg-indigo-100 transition-colors">
                                        <span class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751A11.959 11.959 0 0112 2.714z"/></svg>
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
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.5M4.5 21V10.5M3 21h18M3 9h18"/></svg>
                                <span>Bankalarım & Kartlar</span>
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('calendar.index')" class="flex items-center gap-2.5 px-2.5 py-2 rounded-lg hover:bg-gray-100 text-gray-700 font-bold">
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                                <span>Ödeme Takvimi & Vadeler</span>
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('reports.index')" class="flex items-center gap-2.5 px-2.5 py-2 rounded-lg hover:bg-gray-100 text-gray-700 font-bold">
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
                                <span>Finansal Raporlarım</span>
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('profile.edit')" class="flex items-center gap-2.5 px-2.5 py-2 rounded-lg hover:bg-gray-100 text-gray-700 font-bold">
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                                <span>Profil & Hesap Güvenliği</span>
                            </x-dropdown-link>
                        </div>

                        <!-- Logout -->
                        <div class="p-1 border-t border-gray-100 bg-gray-50/50">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-2.5 px-2.5 py-2 rounded-lg text-red-600 font-bold text-xs hover:bg-red-50 transition-colors text-left cursor-pointer">
                                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l3 3m0 0l-3 3m3-3H2.25"/></svg>
                                    <span>Güvenli Çıkış Yap</span>
                                </button>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile Hamburger Button & Notifications -->
            <div class="flex items-center gap-1.5 md:hidden">
                @php
                    $mobileUnreadCount = Auth::user() ? \App\Models\FinancialNotification::where('user_id', Auth::id())->unread()->count() : 0;
                @endphp
                <a href="{{ route('notifications.index') }}" 
                   title="Bildirimler"
                   class="relative p-2 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-all flex items-center justify-center">
                    <svg class="w-5 h-5 text-slate-600" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                    </svg>
                    @if ($mobileUnreadCount > 0)
                        <span class="absolute top-1 right-1 flex h-4 w-4">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-4 w-4 bg-rose-600 text-[10px] font-black text-white items-center justify-center">
                                {{ $mobileUnreadCount > 9 ? '9+' : $mobileUnreadCount }}
                            </span>
                        </span>
                    @endif
                </a>

                <button @click="open = true" class="inline-flex items-center justify-center p-2 rounded-lg text-gray-700 bg-gray-50 hover:bg-gray-100 border border-gray-200 focus:outline-none transition-colors shadow-xs cursor-pointer" aria-label="Menüyü Aç">
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
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
                        <span>Kontrol Paneli</span>
                    </a>

                    <a href="{{ route('debts.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs font-bold transition-all {{ request()->routeIs('debts.*') ? 'bg-indigo-50 text-indigo-700 border-l-4 border-indigo-600' : 'text-gray-700 hover:bg-gray-50 hover:text-indigo-600' }}">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/></svg>
                        <span>Borçlarım</span>
                    </a>

                    <a href="{{ route('cards.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs font-bold transition-all {{ request()->routeIs('cards.*') ? 'bg-indigo-50 text-indigo-700 border-l-4 border-indigo-600' : 'text-gray-700 hover:bg-gray-50 hover:text-indigo-600' }}">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/></svg>
                        <span>Kartlarım</span>
                    </a>

                    <a href="{{ route('accounts.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs font-bold transition-all {{ request()->routeIs('accounts.*') ? 'bg-indigo-50 text-indigo-700 border-l-4 border-indigo-600' : 'text-gray-700 hover:bg-gray-50 hover:text-indigo-600' }}">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.5M4.5 21V10.5M3 21h18M3 9h18"/></svg>
                        <span>Hesaplarım & KMH</span>
                    </a>

                    <a href="{{ route('cashflow.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs font-bold transition-all {{ request()->routeIs('cashflow.*') ? 'bg-indigo-50 text-indigo-700 border-l-4 border-indigo-600' : 'text-gray-700 hover:bg-gray-50 hover:text-indigo-600' }}">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5h16.5a1.5 1.5 0 011.5 1.5v9a1.5 1.5 0 01-1.5 1.5H3.75a1.5 1.5 0 01-1.5-1.5v-9a1.5 1.5 0 011.5-1.5zM12 12.75a2.25 2.25 0 100-4.5 2.25 2.25 0 000 4.5z"/></svg>
                        <span>Gelir / Gider</span>
                    </a>

                    <a href="{{ route('planner.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs font-bold transition-all {{ request()->routeIs('planner.*') ? 'bg-indigo-50 text-indigo-700 border-l-4 border-indigo-600' : 'text-gray-700 hover:bg-gray-50 hover:text-indigo-600' }}">
                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.59 14.37a6 6 0 01-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 006.16-12.12A14.98 14.98 0 009.631 8.41m5.96 5.96a14.926 14.926 0 01-5.841 2.58m-.119-8.54a6 6 0 00-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 00-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 01-2.448-2.448 14.9 14.9 0 01.06-.312m-2.24 2.24a6 6 0 00-2.392 4.092m0 0a6 6 0 004.092-2.392m-4.092 2.392l2.392-2.392"/></svg>
                        <span>Ödeme Planı (Çığ / Kartopu)</span>
                    </a>

                    <a href="{{ route('calendar.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs font-bold transition-all {{ request()->routeIs('calendar.*') ? 'bg-indigo-50 text-indigo-700 border-l-4 border-indigo-600' : 'text-gray-700 hover:bg-gray-50 hover:text-indigo-600' }}">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                        <span>Ödeme Takvimi & Vadeler</span>
                    </a>

                    <a href="{{ route('reports.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs font-bold transition-all {{ request()->routeIs('reports.*') ? 'bg-indigo-50 text-indigo-700 border-l-4 border-indigo-600' : 'text-gray-700 hover:bg-gray-50 hover:text-indigo-600' }}">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                        <span>Finansal Raporlar</span>
                    </a>

                    <a href="{{ route('notifications.index') }}" class="flex items-center justify-between px-3 py-2 rounded-lg text-xs font-bold transition-all {{ request()->routeIs('notifications.*') ? 'bg-indigo-50 text-indigo-700 border-l-4 border-indigo-600' : 'text-gray-700 hover:bg-gray-50 hover:text-indigo-600' }}">
                        <span class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/></svg>
                            <span>Bildirimler</span>
                        </span>
                        @php
                            $unreadNotifs = \App\Models\FinancialNotification::where('user_id', Auth::id())->unread()->count();
                        @endphp
                        @if ($unreadNotifs > 0)
                            <span class="px-2 py-0.5 text-[10px] font-black rounded-full bg-rose-50 text-rose-600 border border-rose-200">
                                {{ $unreadNotifs }}
                            </span>
                        @endif
                    </a>

                    <!-- AI Coach Highlight Link -->
                    <a href="{{ route('ai.coach') }}" class="flex items-center justify-between px-3 py-2 rounded-lg text-xs font-bold transition-all {{ request()->routeIs('ai.*') ? 'bg-indigo-100 text-indigo-800 border-l-4 border-indigo-600' : 'bg-indigo-50/80 border border-indigo-100 text-indigo-700 hover:bg-indigo-100' }}">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z"/></svg>
                            <span>AI Finans Koçu</span>
                        </span>
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    </a>

                    <a href="{{ route('banks.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs font-bold transition-all {{ request()->routeIs('banks.*') ? 'bg-indigo-50 text-indigo-700 border-l-4 border-indigo-600' : 'text-gray-700 hover:bg-gray-50 hover:text-indigo-600' }}">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.5M4.5 21V10.5M3 21h18M3 9h18"/></svg>
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
                                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.343 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.28z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        <span>Süper Admin Paneli</span>
                                    </span>
                                    <span class="text-[9px] px-1.5 py-0.5 rounded bg-red-200 text-red-800 font-black">SUPER</span>
                                </a>
                            @endif
                            @if (Auth::user()->hasRole('admin'))
                                <a href="/admin" target="_blank" class="flex items-center justify-between p-2.5 rounded-lg bg-indigo-50 border border-indigo-200 text-indigo-700 font-bold text-xs hover:bg-indigo-100 transition-colors">
                                    <span class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751A11.959 11.959 0 0112 2.714z"/></svg>
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
                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.5M4.5 21V10.5M3 21h18M3 9h18"/></svg>
                            <span>DVT Bank Ana Sayfası</span>
                        </span>
                        <span>→</span>
                    </a>

                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5 w-full px-3 py-1.5 rounded-lg text-xs font-bold text-gray-700 hover:bg-white hover:text-indigo-600 transition-all">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                        <span>Profil & Güvenlik Ayarları</span>
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit" class="flex items-center gap-2.5 w-full px-3 py-1.5 rounded-lg text-xs font-bold text-red-600 hover:bg-red-50 transition-colors text-left cursor-pointer">
                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l3 3m0 0l-3 3m3-3H2.25"/></svg>
                            <span>Güvenli Çıkış Yap</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>
