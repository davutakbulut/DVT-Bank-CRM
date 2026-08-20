<header class="h-20 border-b border-slate-800/80 bg-slate-950/80 backdrop-blur-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto h-full px-4 sm:px-6 lg:px-8 flex items-center justify-between">
        <a href="/" class="flex items-center gap-2">
            <span class="text-2xl font-black text-white tracking-tight">DVT<span class="text-indigo-400">BANK</span> <span class="text-xs px-2 py-0.5 rounded-full bg-indigo-500/20 text-indigo-300 font-bold border border-indigo-500/30">CRM</span></span>
        </a>

        <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-slate-300">
            <a href="{{ route('features') }}" wire:navigate class="hover:text-white transition-colors {{ request()->routeIs('features') ? 'text-indigo-400 font-bold' : '' }}">Özellikler</a>
            <a href="{{ route('how-it-works') }}" wire:navigate class="hover:text-white transition-colors {{ request()->routeIs('how-it-works') ? 'text-indigo-400 font-bold' : '' }}">Nasıl Çalışır?</a>
            <a href="{{ route('pricing') }}" wire:navigate class="hover:text-white transition-colors {{ request()->routeIs('pricing') ? 'text-indigo-400 font-bold' : '' }}">Fiyatlandırma</a>
            <a href="{{ route('faq') }}" wire:navigate class="hover:text-white transition-colors {{ request()->routeIs('faq') ? 'text-indigo-400 font-bold' : '' }}">S.S.S.</a>
            <a href="{{ route('contact') }}" wire:navigate class="hover:text-white transition-colors {{ request()->routeIs('contact') ? 'text-indigo-400 font-bold' : '' }}">İletişim</a>
        </nav>

        <div class="flex items-center gap-3">
            @auth
                <a href="{{ route('dashboard') }}" wire:navigate class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-sm shadow-md transition-all">
                    Kontrol Paneli →
                </a>
            @else
                <a href="{{ route('login') }}" wire:navigate class="px-4 py-2 rounded-xl text-sm font-bold text-slate-300 hover:text-white transition-colors">
                    Giriş Yap
                </a>
                <a href="{{ route('register') }}" wire:navigate class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-sm shadow-md transition-all">
                    Ücretsiz Başla
                </a>
            @endauth
        </div>
    </div>
</header>
