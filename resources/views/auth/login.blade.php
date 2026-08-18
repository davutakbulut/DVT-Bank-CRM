<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-6 text-center">
        <h2 class="text-2xl font-black text-white tracking-tight">Tekrar Hoş Geldiniz</h2>
        <p class="text-xs text-slate-400 mt-1">DVT Bank CRM finansal kurtarma ve takip panelinize giriş yapın.</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-semibold text-slate-300 mb-1">E-posta Adresiniz</label>
            <input id="email" class="block w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-white text-sm focus:border-indigo-500 focus:ring-indigo-500" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="dvtakblt@gmail.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-semibold text-slate-300 mb-1">Şifreniz</label>
            <input id="password" class="block w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-white text-sm focus:border-indigo-500 focus:ring-indigo-500"
                            type="password"
                            name="password"
                            required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between pt-1">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-slate-800 bg-slate-950 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-xs text-slate-400">Beni Hatırla</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-xs text-indigo-400 hover:text-indigo-300 transition-colors" href="{{ route('password.request') }}">
                    Şifremi Unuttum?
                </a>
            @endif
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-sm rounded-xl shadow-lg shadow-indigo-600/30 transition-all flex items-center justify-center gap-2">
                <span>Giriş Yap</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </button>
        </div>

        <div class="pt-4 border-t border-slate-800/80 text-center text-xs text-slate-400">
            <span>Henüz hesabınız yok mu?</span>
            <a href="{{ route('register') }}" class="text-indigo-400 hover:text-indigo-300 font-bold ms-1">Ücretsiz Hesap Açın →</a>
        </div>
    </form>
</x-guest-layout>
