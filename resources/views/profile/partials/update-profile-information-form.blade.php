<section>
    <header>
        <h2 class="text-lg font-bold text-gray-900">
            Profil Bilgileri
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Hesabınızın ad soyad ve iletişim e-posta adresini güncelleyin.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-4">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="block text-xs font-semibold text-gray-700 mb-1">Adınız Soyadınız</label>
            <input id="name" name="name" type="text" class="mt-1 block w-full rounded-xl border-gray-300 text-sm font-medium focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
            <x-input-error class="mt-1" :messages="$errors->get('name')" />
        </div>

        <div>
            <label for="email" class="block text-xs font-semibold text-gray-700 mb-1">E-posta Adresiniz</label>
            <input id="email" name="email" type="email" class="mt-1 block w-full rounded-xl border-gray-300 text-sm font-medium focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('email', $user->email) }}" required autocomplete="username" />
            <x-input-error class="mt-1" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-xs text-amber-700">
                        E-posta adresiniz henüz doğrulanmadı.

                        <button form="send-verification" class="underline text-xs text-indigo-600 hover:text-indigo-900 font-bold ms-1">
                            Doğrulama e-postasını tekrar göndermek için tıklayın.
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-xs text-emerald-600">
                            E-posta adresinize yeni bir doğrulama bağlantısı gönderildi.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm rounded-xl shadow-sm transition-colors">
                Değişiklikleri Kaydet
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-xs font-bold text-emerald-600 flex items-center gap-1"
                >
                    <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                    <span>Başarıyla Kaydedildi.</span>
                </p>
            @endif
        </div>
    </form>
</section>
