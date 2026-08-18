<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-50 min-h-screen flex flex-col justify-between">
        <div class="flex-1 flex flex-col sm:justify-center items-center pt-8 sm:pt-12 px-4">
            <div class="mb-6">
                <a href="/" class="flex flex-col items-center gap-1 group">
                    <span class="text-2xl font-black text-indigo-700 tracking-tight">🏛️ DVT Bank CRM</span>
                    <span class="text-xs text-gray-500 font-medium">Finansal Kriz ve Borç Yönetim Platformu</span>
                </a>
            </div>

            <div class="w-full sm:max-w-md px-6 py-6 bg-white shadow-xl border border-gray-100 rounded-2xl">
                {{ $slot }}
            </div>
        </div>

        <!-- Guest Footer -->
        <footer class="py-6 text-center text-xs text-gray-400 border-t border-gray-100 bg-white mt-12">
            <div class="max-w-md mx-auto px-4 space-y-2">
                <div class="flex items-center justify-center gap-4 text-gray-500 font-medium">
                    <a href="{{ route('features') }}" class="hover:text-indigo-600">Özellikler</a>
                    <a href="{{ route('pricing') }}" class="hover:text-indigo-600">Fiyatlandırma</a>
                    <a href="{{ route('faq') }}" class="hover:text-indigo-600">S.S.S.</a>
                    <a href="{{ route('legal.privacy') }}" class="hover:text-indigo-600">Gizlilik</a>
                    <a href="{{ route('legal.disclaimer') }}" class="hover:text-indigo-600">Yasal Uyarı</a>
                </div>
                <p>© {{ date('Y') }} DVT Bank CRM. Tüm hakları saklıdır.</p>
            </div>
        </footer>
    </body>
</html>
