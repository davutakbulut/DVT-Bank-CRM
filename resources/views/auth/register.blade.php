<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-black text-white tracking-tight">Ücretsiz Hesap Oluşturun</h2>
        <p class="text-xs text-slate-400 mt-1">Borçlarınızı kontrol altına alın, AI finansal koçunuzla tanışın.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-xs font-semibold text-slate-300 mb-1">Adınız ve Soyadınız</label>
            <input id="name" class="block w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-white text-sm focus:border-indigo-500 focus:ring-indigo-500" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Örn: Ahmet Yılmaz" />
            <x-input-error :messages="$errors->get('name')" class="mt-1" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-semibold text-slate-300 mb-1">E-posta Adresiniz</label>
            <input id="email" class="block w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-white text-sm focus:border-indigo-500 focus:ring-indigo-500" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="ahmet@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-semibold text-slate-300 mb-1">Şifreniz</label>
            <input id="password" class="block w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-white text-sm focus:border-indigo-500 focus:ring-indigo-500"
                            type="password"
                            name="password"
                            required autocomplete="new-password" placeholder="En az 8 karakter" />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-xs font-semibold text-slate-300 mb-1">Şifre Tekrarı</label>
            <input id="password_confirmation" class="block w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-white text-sm focus:border-indigo-500 focus:ring-indigo-500"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" placeholder="Şifrenizi tekrar girin" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <!-- KVKK & Terms Checkbox -->
        <div class="pt-1">
            <label for="terms" class="inline-flex items-start cursor-pointer">
                <input id="terms" type="checkbox" class="mt-0.5 rounded border-slate-800 bg-slate-950 text-indigo-600 shadow-sm focus:ring-indigo-500" name="terms" required>
                <span class="ms-2 text-[11px] text-slate-400 leading-relaxed">
                    <a href="/kvkk" target="_blank" class="underline text-indigo-400 hover:text-indigo-300">KVKK Aydınlatma</a>, 
                    <a href="/gizlilik" target="_blank" class="underline text-indigo-400 hover:text-indigo-300">Gizlilik</a> ve 
                    <a href="/sartlar" target="_blank" class="underline text-indigo-400 hover:text-indigo-300">Kullanım Şartları</a>'nı okudum, kabul ediyorum.
                </span>
            </label>
            <x-input-error :messages="$errors->get('terms')" class="mt-1" />
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-sm rounded-xl shadow-lg shadow-indigo-600/30 transition-all flex items-center justify-center gap-2">
                <span>Kayıt Ol ve Başla</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </button>
        </div>

        <div class="pt-4 border-t border-slate-800/80 text-center text-xs text-slate-400">
            <span>Zaten bir hesabınız var mı?</span>
            <a href="{{ route('login') }}" class="text-indigo-400 hover:text-indigo-300 font-bold ms-1">Giriş Yapın →</a>
        </div>
    </form>
</x-guest-layout>
