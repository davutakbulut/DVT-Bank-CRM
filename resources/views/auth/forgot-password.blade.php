<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-black text-white tracking-tight">Şifrenizi mi Unuttunuz?</h2>
        <p class="text-xs text-slate-400 mt-2 leading-relaxed">
            Sorun değil. Kayıtlı e-posta adresinizi girin, size yeni bir şifre belirlemenizi sağlayacak güvenli bir sıfırlama bağlantısı gönderelim.
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-semibold text-slate-300 mb-1">E-posta Adresiniz</label>
            <input id="email" class="block w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-white text-sm focus:border-indigo-500 focus:ring-indigo-500" type="email" name="email" :value="old('email')" required autofocus placeholder="dvtakblt@gmail.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-sm rounded-xl shadow-lg shadow-indigo-600/30 transition-all flex items-center justify-center gap-2">
                <span>Şifre Sıfırlama Bağlantısı Gönder</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </button>
        </div>

        <div class="pt-4 border-t border-slate-800/80 text-center text-xs text-slate-400">
            <a href="{{ route('login') }}" class="text-indigo-400 hover:text-indigo-300 font-bold">← Giriş Sayfasına Dön</a>
        </div>
    </form>
</x-guest-layout>
