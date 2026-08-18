<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Ücretsiz Hesap Oluşturun</h2>
        <p class="text-sm text-gray-600 mt-1">Borçlarınızı kontrol altına alın, AI finansal koçunuzla tanışın.</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" value="Adınız ve Soyadınız" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Örn: Ahmet Yılmaz" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" value="E-posta Adresiniz" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="ornek@alanadi.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" value="Şifre" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" placeholder="En az 8 karakter" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" value="Şifre Tekrarı" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" placeholder="Şifrenizi yeniden yazın" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- KVKK & Terms Checkbox -->
        <div class="block mt-4">
            <label for="terms" class="inline-flex items-start">
                <input id="terms" type="checkbox" class="mt-1 rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="terms" required>
                <span class="ms-2 text-xs text-gray-600 leading-relaxed">
                    <a href="/kvkk" target="_blank" class="underline text-indigo-600 hover:text-indigo-800">KVKK Aydınlatma Metni</a>'ni, 
                    <a href="/gizlilik" target="_blank" class="underline text-indigo-600 hover:text-indigo-800">Gizlilik Politikası</a>'nı ve 
                    <a href="/sartlar" target="_blank" class="underline text-indigo-600 hover:text-indigo-800">Kullanım Şartları</a>'nı okudum, kabul ediyorum.
                </span>
            </label>
            <x-input-error :messages="$errors->get('terms')" class="mt-1" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                Zaten hesabınız var mı?
            </a>

            <x-primary-button class="ms-4">
                Kayıt Ol ve Başla
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
