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

        <div class="text-slate-500 text-xs max-w-2xl mx-auto leading-relaxed">
            ⚖️ <strong>Yasal Uyarı:</strong> DVT Bank CRM bir kişisel finans ve borç takip aracıdır. 6362 sayılı Sermaye Piyasası Kanunu kapsamında yatırım, kredi veya finansal danışmanlık hizmeti sunmaz.
        </div>

        <div class="text-slate-600 text-xs pt-4 border-t border-slate-900">
            © {{ date('Y') }} DVT Bank CRM (dvt.portegu.com). Tüm hakları saklıdır.
        </div>
    </div>
</footer>
