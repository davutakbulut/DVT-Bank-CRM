<section class="space-y-6">
    <header>
        <h2 class="text-lg font-bold text-red-700">
            Hesabı ve Verileri Kalıcı Olarak Sil
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Hesabınızı sildiğinizde, kayıtlı tüm banka, kart, borç ve ödeme geçmişi verileriniz kalıcı olarak veritabanından silinecektir.
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >Hesabımı Sil</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-bold text-gray-900">
                Hesabınızı silmek istediğinize emin misiniz?
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Hesabınız silindiğinde tüm finansal kayıtlarınız ve kurtarma planlarınız geri getirilemez şekilde silinecektir. Lütfen işlemi onaylamak için mevcut şifrenizi girin.
            </p>

            <div class="mt-6">
                <label for="password" class="sr-only">Şifreniz</label>

                <input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4 rounded-xl border-gray-300 text-sm focus:border-red-500 focus:ring-red-500"
                    placeholder="Mevcut Şifreniz"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')">
                    Vazgeç
                </x-secondary-button>

                <x-danger-button>
                    Hesabımı Kalıcı Olarak Sil
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
