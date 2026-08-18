<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>İletişim — DVT Bank CRM</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="bg-slate-950 text-slate-100 antialiased">
    <header class="h-20 border-b border-slate-800 flex items-center justify-between px-6 max-w-7xl mx-auto">
        <a href="/" class="font-black text-xl text-white">DVT<span class="text-indigo-400">BANK</span> CRM</a>
        <a href="{{ route('login') }}" class="text-sm font-bold text-slate-300 hover:text-white">Giriş Yap</a>
    </header>

    <main class="max-w-xl mx-auto py-16 px-6 space-y-6">
        <div class="text-center space-y-2">
            <h1 class="text-3xl font-black text-white tracking-tight">Bizimle İletişime Geçin</h1>
            <p class="text-slate-400 text-sm">Geri bildirim, teknik destek ve sorularınız için mesaj gönderin.</p>
        </div>

        @if (session('success'))
            <div class="p-4 bg-emerald-950/80 border border-emerald-500/40 text-emerald-300 text-sm rounded-2xl">
                ✓ {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('contact.send') }}" class="bg-slate-900 border border-slate-800 rounded-3xl p-6 sm:p-8 space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1">Adınız Soyadınız</label>
                <input type="text" name="name" required class="w-full bg-slate-950 rounded-xl border-slate-800 text-white text-sm focus:border-indigo-500">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1">E-posta Adresiniz</label>
                <input type="email" name="email" required class="w-full bg-slate-950 rounded-xl border-slate-800 text-white text-sm focus:border-indigo-500">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1">Konu</label>
                <input type="text" name="subject" required class="w-full bg-slate-950 rounded-xl border-slate-800 text-white text-sm focus:border-indigo-500">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1">Mesajınız</label>
                <textarea name="message" rows="4" required class="w-full bg-slate-950 rounded-xl border-slate-800 text-white text-sm focus:border-indigo-500"></textarea>
            </div>

            <button type="submit" class="w-full py-3.5 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-xl text-sm transition-colors shadow-lg shadow-indigo-600/30">
                Mesajı Gönder
            </button>
        </form>
    </main>
</body>
</html>
