<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>İletişim & Destek — DVT Bank CRM</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="bg-slate-950 text-slate-100 antialiased min-h-screen flex flex-col justify-between">
    <x-public-header />

    <main class="max-w-xl mx-auto py-16 px-6 space-y-8 flex-1">
        <div class="text-center space-y-3">
            <h1 class="text-3xl font-black text-white tracking-tight">İletişim & Destek Talebi</h1>
            <p class="text-slate-400 text-sm">Geri bildirimleriniz, sorularınız ve teknik destek için bize yazın.</p>
        </div>

        @if (session()->has('success'))
            <div class="p-4 bg-emerald-500/20 border border-emerald-500/40 text-emerald-300 rounded-xl text-sm font-bold text-center">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('contact.submit') }}" method="POST" class="bg-slate-900 border border-slate-800 rounded-2xl p-6 sm:p-8 space-y-4 shadow-xl">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1">Adınız Soyadınız</label>
                <input type="text" name="name" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-white text-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Ahmet Yılmaz">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1">E-posta Adresiniz</label>
                <input type="email" name="email" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-white text-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="ahmet@example.com">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1">Konu</label>
                <input type="text" name="subject" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-white text-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Örn: Genel soru / Üyelik hakkında">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1">Mesajınız</label>
                <textarea name="message" rows="4" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-white text-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Sorunuz veya geri bildiriminiz..."></textarea>
            </div>

            <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-sm rounded-xl transition-colors shadow-lg cursor-pointer">
                Mesajı Gönder
            </button>
        </form>
    </main>

    <x-public-footer />
</body>
</html>
