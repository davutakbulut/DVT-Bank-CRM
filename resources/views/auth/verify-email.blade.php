<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-black text-white tracking-tight">E-posta Doğrulaması</h2>
        <p class="text-xs text-slate-400 mt-2 leading-relaxed">
            Kayıt olduğunuz için teşekkürler! Başlamadan önce, size az önce gönderdiğimiz bağlantıya tıklayarak e-posta adresinizi doğrulayabilir misiniz? E-postayı almadıysanız memnuniyetle bir tane daha gönderebiliriz.
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-semibold text-xs text-emerald-400 bg-emerald-950/60 border border-emerald-800 p-3 rounded-xl">
            ✓ Kayıt sırasında belirttiğiniz e-posta adresine yeni bir doğrulama bağlantısı gönderildi.
        </div>
    @endif

    <div class="mt-4 flex flex-col sm:flex-row items-center justify-between gap-4">
        <form method="POST" action="{{ route('verification.send') }}" class="w-full sm:w-auto">
            @csrf
            <button type="submit" class="w-full px-5 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-xs rounded-xl shadow-md transition-colors">
                Doğrulama E-postasını Tekrar Gönder
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="underline text-xs text-slate-400 hover:text-white transition-colors">
                Çıkış Yap
            </button>
        </form>
    </div>
</x-guest-layout>
