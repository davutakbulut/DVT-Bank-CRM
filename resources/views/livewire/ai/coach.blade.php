<div class="py-1 sm:py-6 px-3 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-6">
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
                    <div class="bg-indigo-50 border border-indigo-100 text-gray-800 p-4 rounded-xl text-xs leading-relaxed max-w-[85%]">
                        Merhaba! Ben senin yapay zeka finans koçunum. Veritabanındaki tüm kayıtlı bankalarınızın borç durumunu, KMH faiz oranlarını ve yaklaşan 90 günlük yasal takip sürelerini anbean biliyorum. Bana borç kapatma stratejileri, yapılandırma taktikleri veya bu ay hangi borcu öncelikli ödemeniz gerektiği hakkında sorularınızı sorabilirsiniz.
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
                            <div class="w-8 h-8 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold text-xs shrink-0 shadow-xs">
                                AI
                            </div>
                            <div class="bg-slate-50 border border-slate-200 text-slate-800 p-4 rounded-2xl text-xs leading-relaxed max-w-[85%] prose prose-sm max-w-none
                                [&_table]:w-full [&_table]:border-collapse [&_table]:my-2 [&_table]:text-[11px] [&_table]:rounded-lg [&_table]:overflow-hidden [&_table]:border [&_table]:border-slate-200
                                [&_th]:bg-slate-200/70 [&_th]:p-2 [&_th]:border [&_th]:border-slate-300 [&_th]:text-slate-900 [&_th]:font-bold [&_th]:text-left
                                [&_td]:p-2 [&_td]:border [&_td]:border-slate-200 [&_td]:text-slate-700
                                [&_tr:nth-child(even)]:bg-white
                                [&_h2]:text-xs [&_h2]:font-black [&_h2]:text-slate-900 [&_h2]:mt-2 [&_h2]:mb-1
                                [&_h3]:text-[11px] [&_h3]:font-black [&_h3]:text-slate-900 [&_h3]:mt-2 [&_h3]:mb-0.5
                                [&_ul]:list-disc [&_ul]:pl-4 [&_ul]:space-y-0.5 [&_ul]:my-1
                                [&_ol]:list-decimal [&_ol]:pl-4 [&_ol]:space-y-0.5 [&_ol]:my-1
                                [&_blockquote]:border-l-2 [&_blockquote]:border-indigo-500 [&_blockquote]:bg-indigo-50/50 [&_blockquote]:p-2 [&_blockquote]:rounded-r [&_blockquote]:my-1.5 [&_blockquote]:text-indigo-900">
                                {!! \App\Helpers\AiFormatter::format($msg->content) !!}
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
            <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                <h3 class="font-bold text-sm text-gray-900">Rapor & Analiz Geçmişi</h3>
                <button wire:click="generateFullAnalysis" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 cursor-pointer">
                    + Yeni Analiz
                </button>
            </div>

            <div class="flex-1 overflow-y-auto space-y-3">
                @forelse ($advices as $adv)
                    <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200/80 space-y-1.5">
                        <div class="flex items-center justify-between text-[11px]">
                            <span class="font-bold text-indigo-700 uppercase">{{ $adv->type === 'daily' ? 'Günlük Öneri' : 'Detaylı Analiz' }}</span>
                            <span class="text-gray-400">{{ $adv->created_at->translatedFormat('d M H:i') }}</span>
                        </div>
                        <div class="text-xs text-slate-700 leading-relaxed font-sans prose prose-sm max-w-none [&_table]:hidden [&_h2]:text-xs [&_h2]:font-bold [&_h3]:text-[11px] [&_h3]:font-bold">
                            {!! \App\Helpers\AiFormatter::format(mb_substr($adv->content, 0, 250), true) !!}...
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
