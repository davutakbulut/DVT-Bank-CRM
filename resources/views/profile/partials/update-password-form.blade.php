<section>
    <header>
        <h2 class="text-lg font-bold text-gray-900">
            Şifre Değiştir
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Hesabınızın güvenliğini korumak için uzun ve karmaşık bir şifre kullanın.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-4">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block text-xs font-semibold text-gray-700 mb-1">Mevcut Şifreniz</label>
            <input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full rounded-xl border-gray-300 text-sm font-medium focus:border-indigo-500 focus:ring-indigo-500" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-1" />
        </div>

        <div>
            <label for="update_password_password" class="block text-xs font-semibold text-gray-700 mb-1">Yeni Şifreniz</label>
            <input id="update_password_password" name="password" type="password" class="mt-1 block w-full rounded-xl border-gray-300 text-sm font-medium focus:border-indigo-500 focus:ring-indigo-500" autocomplete="new-password" placeholder="En az 8 karakter" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-1" />
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block text-xs font-semibold text-gray-700 mb-1">Yeni Şifre Tekrarı</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full rounded-xl border-gray-300 text-sm font-medium focus:border-indigo-500 focus:ring-indigo-500" autocomplete="new-password" placeholder="Yeni şifrenizi tekrar yazın" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-1" />
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm rounded-xl shadow-sm transition-colors">
                Şifreyi Güncelle
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-xs font-bold text-emerald-600 flex items-center gap-1"
                >
                    <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                    <span>Şifreniz Başarıyla Güncellendi.</span>
                </p>
            @endif
        </div>
    </form>
</section>
