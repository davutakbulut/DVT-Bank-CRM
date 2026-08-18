<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-black text-white tracking-tight">Yeni Şifre Belirleyin</h2>
        <p class="text-xs text-slate-400 mt-1">Lütfen hesabınız için güçlü bir yeni şifre oluşturun.</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-semibold text-slate-300 mb-1">E-posta Adresiniz</label>
            <input id="email" class="block w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-white text-sm focus:border-indigo-500 focus:ring-indigo-500" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-semibold text-slate-300 mb-1">Yeni Şifreniz</label>
            <input id="password" class="block w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-white text-sm focus:border-indigo-500 focus:ring-indigo-500" type="password" name="password" required autocomplete="new-password" placeholder="En az 8 karakter" />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-xs font-semibold text-slate-300 mb-1">Yeni Şifre Tekrarı</label>
            <input id="password_confirmation" class="block w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-white text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" placeholder="Yeni şifrenizi tekrar yazın" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-sm rounded-xl shadow-lg shadow-indigo-600/30 transition-all flex items-center justify-center gap-2">
                <span>Şifreyi Güncelle ve Giriş Yap</span>
            </button>
        </div>
    </form>
</x-guest-layout>
