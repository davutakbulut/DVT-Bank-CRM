<footer class="bg-slate-950 border-t border-slate-800/80 py-12 mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-6">
        <div class="flex items-center justify-center gap-2">
            <span class="font-black text-xl text-white">DVT<span class="text-indigo-400">BANK</span> CRM</span>
        </div>

        <div class="flex flex-wrap justify-center gap-6 text-xs text-slate-400 font-medium">
            <a href="{{ route('features') }}" class="hover:text-white transition-colors">Özellikler</a>
            <a href="{{ route('how-it-works') }}" class="hover:text-white transition-colors">Nasıl Çalışır?</a>
            <a href="{{ route('pricing') }}" class="hover:text-white transition-colors">Fiyatlandırma</a>
            <a href="{{ route('faq') }}" class="hover:text-white transition-colors">S.S.S.</a>
            <a href="{{ route('legal.privacy') }}" class="hover:text-white transition-colors">Gizlilik Politikası</a>
            <a href="{{ route('legal.kvkk') }}" class="hover:text-white transition-colors">KVKK Aydınlatma</a>
            <a href="{{ route('legal.terms') }}" class="hover:text-white transition-colors">Kullanım Şartları</a>
            <a href="{{ route('legal.disclaimer') }}" class="hover:text-white transition-colors">Sorumluluk Reddi</a>
            <a href="{{ route('contact') }}" class="hover:text-white transition-colors">İletişim</a>
        </div>

        <div class="text-slate-500 text-xs max-w-2xl mx-auto leading-relaxed flex items-start justify-center gap-1.5">
            <svg class="w-4 h-4 text-slate-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v17.25m0 0c-1.472 0-2.882.265-4.185.75M12 20.25c1.472 0 2.882.265 4.185.75M18.75 4.5H5.25A2.25 2.25 0 003 6.75v10.5a2.25 2.25 0 002.25 2.25h13.5A2.25 2.25 0 0021 17.25V6.75A2.25 2.25 0 0018.75 4.5z"/></svg>
            <span><strong>Yasal Uyarı:</strong> DVT Bank CRM bir kişisel finans ve borç takip aracıdır. 6362 sayılı Sermaye Piyasası Kanunu kapsamında yatırım, kredi veya finansal danışmanlık hizmeti sunmaz.</span>
        </div>

        <div class="text-slate-600 text-xs pt-4 border-t border-slate-900">
            © {{ date('Y') }} DVT Bank CRM (dvt.portegu.com). Tüm hakları saklıdır.
        </div>
    </div>
</footer>
