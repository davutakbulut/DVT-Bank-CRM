<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-8">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-gray-900 tracking-tight">🤖 AI Finansal Kurtarma Koçu</h1>
            <p class="text-sm text-gray-600">Groq & Gemini hibrit yapay zeka ile 7/24 kişiselleştirilmiş borç yönetimi desteği</p>
        </div>
        <button wire:click="generateFullAnalysis" class="inline-flex items-center px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm rounded-xl shadow-sm transition-colors">
            ⚡ Yeni Durum Analizi Üret
        </button>
    </div>

    @if (session()->has('message'))
        <div class="p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl text-sm font-medium">
            ✓ {{ session('message') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- SOL: SOHBET EKRANI (2 KOLON) -->
        <div class="lg:col-span-2 bg-white rounded-3xl border border-gray-100 shadow-sm flex flex-col h-[650px] overflow-hidden">
            <div class="p-4 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-emerald-500 animate-ping"></span>
                    <h3 class="font-bold text-sm text-gray-800">DVT Akıllı Koç Sohbeti</h3>
                </div>
                <span class="text-[11px] text-gray-400 font-medium">Groq Llama 3.3 / Gemini Flash</span>
            </div>

            <!-- Mesaj Alanı -->
            <div class="flex-1 p-5 overflow-y-auto space-y-4">
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold text-xs shrink-0">
                        AI
                    </div>
                    <div class="bg-indigo-50 border border-indigo-100 text-gray-800 p-4 rounded-2xl text-xs leading-relaxed max-w-[85%]">
                        Merhaba! Ben senin yapay zeka finans koçunum. 6 bankadaki borç durumunu, KMH faizlerini ve yaklaşan yasal takip sürelerini biliyorum. Bana borç kapatma stratejileri, yapılandırma taktikleri veya bu ay hangi kartı önce ödemen gerektiği hakkında soru sorabilirsin.
                    </div>
                </div>

                @foreach ($chatMessages as $msg)
                    @if ($msg->role === 'user')
                        <div class="flex items-start justify-end gap-3">
                            <div class="bg-indigo-600 text-white p-3.5 rounded-2xl text-xs leading-relaxed max-w-[85%] shadow-sm">
                                {{ $msg->content }}
                            </div>
                            <div class="w-8 h-8 rounded-full bg-slate-200 text-slate-700 flex items-center justify-center font-bold text-xs shrink-0">
                                SEN
                            </div>
                        </div>
                    @else
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold text-xs shrink-0">
                                AI
                            </div>
                            <div class="bg-gray-50 border border-gray-200 text-gray-800 p-4 rounded-2xl text-xs leading-relaxed max-w-[85%]">
                                {!! nl2br(e($msg->content)) !!}
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- Mesaj Gönderme Formu -->
            <div class="p-3 border-t border-gray-100 bg-white">
                <form wire:submit="sendMessage" class="flex gap-2">
                    <input type="text" wire:model="message" class="flex-1 text-xs rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" placeholder="Örn: Bu ay en acil hangi bankayı aramalıyım?">
                    <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl shadow-sm">
                        Gönder
                    </button>
                </form>
            </div>
        </div>

        <!-- SAĞ: SON ÖNERİ GEÇMİŞİ (1 KOLON) -->
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 space-y-4 flex flex-col h-[650px] overflow-hidden">
            <h3 class="font-bold text-gray-900 text-base border-b border-gray-100 pb-3">Kişisel Öneri Geçmişi</h3>

            <div class="flex-1 overflow-y-auto space-y-4 pr-1">
                @forelse ($advices as $adv)
                    <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100 space-y-2">
                        <div class="flex items-center justify-between text-[11px]">
                            <span class="font-bold text-indigo-700 uppercase">{{ $adv->type === 'daily' ? 'Günlük Öneri' : 'Detaylı Analiz' }}</span>
                            <span class="text-gray-400">{{ $adv->created_at->translatedFormat('d M H:i') }}</span>
                        </div>
                        <div class="text-xs text-gray-700 leading-relaxed font-sans">
                            {!! nl2br(e(mb_substr($adv->content, 0, 300))) !!}...
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-xs text-gray-400">
                        Henüz oluşturulmuş rapor yok.
                    </div>
                @endforelse
            </div>

            <div class="pt-3 border-t border-gray-100 text-[10px] text-gray-400 text-center leading-relaxed">
                ⚖️ <em>Bu sistem bilgilendirme amaçlıdır; 6362 sayılı Kanun kapsamında yatırım veya finansal danışmanlık hizmeti içermez.</em>
            </div>
        </div>
    </div>
</div>
