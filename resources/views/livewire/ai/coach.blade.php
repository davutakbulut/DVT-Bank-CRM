<div class="py-1 sm:py-6 px-3 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-gray-900 tracking-tight flex items-center gap-2">
                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z"/></svg>
                <span>AI Finansal Kurtarma Koçu</span>
            </h1>
            <p class="text-sm text-gray-600 mt-1">Groq & Gemini hibrit yapay zeka ile 7/24 kişiselleştirilmiş borç yönetimi desteği</p>
        </div>
        <button wire:click="generateFullAnalysis" class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm rounded-xl shadow-sm transition-colors cursor-pointer">
            <svg class="w-4 h-4 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/></svg>
            <span>Yeni Durum Analizi Üret</span>
        </button>
    </div>

    @if (session()->has('message'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm font-bold flex items-center gap-2">
            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
            <span>{{ session('message') }}</span>
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
                <div class="flex items-center gap-3">
                    <span class="text-[11px] text-gray-400 font-medium hidden sm:inline">Groq Llama / Gemini Flash</span>
                    @if (count($chatMessages) > 0)
                        <button wire:click="clearChat" 
                                wire:confirm="Sohbet geçmişinizi temizlemek istediğinize emin misiniz?"
                                class="text-[11px] font-bold text-rose-600 hover:text-rose-800 bg-rose-50 hover:bg-rose-100 px-2.5 py-1 rounded-lg border border-rose-200 transition-colors cursor-pointer flex items-center gap-1"
                                title="Sohbet Geçmişini Temizle">
                            <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                            <span>Temizle</span>
                        </button>
                    @endif
                </div>
            </div>

            <!-- Mesaj Alanı (Otomatik Kaydırma Destekli) -->
            <div class="flex-1 p-5 overflow-y-auto space-y-4"
                 x-data
                 x-init="$el.scrollTop = $el.scrollHeight"
                 x-effect="$nextTick(() => { $el.scrollTop = $el.scrollHeight })">
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

            <!-- Mesaj Gönderme Formu (Yükleniyor Animasyonu İle) -->
            <div class="p-3 border-t border-gray-100 bg-white">
                <form wire:submit="sendMessage" class="flex gap-2">
                    <input type="text" 
                           wire:model="message" 
                           wire:loading.attr="disabled"
                           class="flex-1 text-xs rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 disabled:bg-slate-100" 
                           placeholder="Örn: Bu ay en acil hangi bankayı aramalıyım?">
                    <button type="submit" 
                            wire:loading.attr="disabled" 
                            class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white text-xs font-bold rounded-xl shadow-sm transition-all flex items-center gap-1.5 cursor-pointer disabled:opacity-60">
                        <span wire:loading.remove wire:target="sendMessage">Gönder →</span>
                        <span wire:loading wire:target="sendMessage" class="animate-spin text-xs">Yanıtlanıyor...</span>
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
                    <div wire:key="advice-item-{{ $adv->id }}"
                         wire:click="viewAdvice({{ $adv->id }})" 
                         class="p-3.5 bg-slate-50 hover:bg-indigo-50/50 rounded-xl border border-slate-200/80 hover:border-indigo-300 space-y-1.5 cursor-pointer transition-all group">
                        <div class="flex items-center justify-between text-[11px]">
                            <div class="flex items-center gap-1.5">
                                <span class="font-bold text-indigo-700 uppercase">{{ $adv->type === 'daily' ? 'Günlük Öneri' : 'Detaylı Analiz' }}</span>
                                @if ($adv->provider === 'groq')
                                    <span class="px-1.5 py-0.2 text-[9px] font-black rounded bg-amber-100 text-amber-800 border border-amber-200 flex items-center gap-0.5">
                                        <svg class="w-2.5 h-2.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/></svg>
                                        <span>GROQ</span>
                                    </span>
                                @elseif ($adv->provider === 'gemini')
                                    <span class="px-1.5 py-0.2 text-[9px] font-black rounded bg-purple-100 text-purple-700 border border-purple-200 flex items-center gap-0.5">
                                        <svg class="w-2.5 h-2.5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/></svg>
                                        <span>GEMINI</span>
                                    </span>
                                @endif
                            </div>
                            <span class="text-gray-400 group-hover:text-indigo-600 font-medium text-[10px] transition-colors flex items-center gap-1">
                                <span>{{ $adv->created_at->translatedFormat('d M H:i') }}</span>
                                <svg class="w-3 h-3 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                            </span>
                        </div>
                        <div class="text-xs text-slate-600 line-clamp-2 leading-relaxed font-sans">
                            {{ Str::limit(strip_tags(str_replace(['#', '*'], '', $adv->content)), 160) }}
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-xs text-gray-400">
                        Henüz oluşturulmuş rapor yok.
                    </div>
                @endforelse
            </div>

            <div class="pt-3 border-t border-gray-100 text-[10px] text-gray-400 text-center leading-relaxed flex items-center justify-center gap-1">
                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v17.25m0 0c-1.472 0-2.882.265-4.185.75M12 20.25c1.472 0 2.882.265 4.185.75M18.75 4.5l-6.75 3-6.75-3m13.5 0v4.5c0 1.243-3.022 2.25-6.75 2.25S5.25 10.243 5.25 9V4.5m13.5 0H5.25"/></svg>
                <em>Bu sistem bilgilendirme amaçlıdır; 6362 sayılı Kanun kapsamında yatırım veya finansal danışmanlık hizmeti içermez.</em>
            </div>
        </div>
    </div>

    <!-- Rapor & Analiz Detay Modalı -->
    @if ($showAdviceModal && $selectedAdvice)
        <div wire:key="coach-advice-detail-modal"
             class="fixed inset-0 z-50 flex items-center justify-center p-2 sm:p-4 bg-slate-900/60 backdrop-blur-xs transition-opacity animate-in fade-in duration-200"
             x-data
             @keydown.escape.window="$wire.closeAdviceModal()">
            <div class="bg-white rounded-2xl sm:rounded-3xl shadow-2xl border border-slate-200 max-w-4xl w-full max-h-[92vh] flex flex-col overflow-hidden animate-in zoom-in-95 duration-150">
                
                <!-- Modal Başlık Çubuğu -->
                <div class="px-4 sm:px-6 py-3.5 sm:py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/80">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-10 h-10 rounded-xl bg-indigo-50 border border-indigo-200 text-indigo-700 flex items-center justify-center font-bold text-xl shrink-0">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
                        </div>
                        <div class="min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <h3 class="text-sm sm:text-base font-black text-slate-900 truncate">
                                    {{ $selectedAdvice->type === 'daily' ? 'Günlük AI Durum Özeti & Tavsiyesi' : 'Detaylı Kriz Durum Analiz Raporu' }}
                                </h3>
                                @if ($selectedAdvice->provider === 'groq')
                                    <span class="px-2 py-0.5 text-[10px] font-black rounded-md bg-amber-100 text-amber-800 border border-amber-200 shrink-0 flex items-center gap-1">
                                        <svg class="w-3 h-3 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/></svg>
                                        <span>Groq Llama AI</span>
                                    </span>
                                @elseif ($selectedAdvice->provider === 'gemini')
                                    <span class="px-2 py-0.5 text-[10px] font-black rounded-md bg-purple-100 text-purple-700 border border-purple-200 shrink-0 flex items-center gap-1">
                                        <svg class="w-3 h-3 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/></svg>
                                        <span>Google Gemini AI</span>
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 text-[10px] font-bold rounded-md bg-slate-100 text-slate-700 border border-slate-200 shrink-0 flex items-center gap-1">
                                        <svg class="w-3 h-3 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751A11.959 11.959 0 0112 2.714z"/></svg>
                                        <span>Kural Motoru</span>
                                    </span>
                                @endif
                            </div>
                            <p class="text-xs text-slate-400 mt-0.5">
                                {{ $selectedAdvice->created_at->translatedFormat('d F Y, H:i') }} ({{ $selectedAdvice->created_at->diffForHumans() }})
                            </p>
                        </div>
                    </div>

                    <button wire:click="closeAdviceModal" class="p-2 text-slate-400 hover:text-slate-700 hover:bg-slate-200/60 rounded-xl transition-all cursor-pointer">
                        ✕
                    </button>
                </div>

                <!-- Modal Gövdesi (Duyarlı Tablolar ve Temiz Tipografi) -->
                <div class="p-4 sm:p-6 overflow-y-auto space-y-4">
                    <div class="p-4 sm:p-5 rounded-2xl bg-slate-50/70 border border-slate-200/80 text-slate-800 text-xs sm:text-sm leading-relaxed prose prose-sm max-w-none
                        [&_table]:w-full [&_table]:border-collapse [&_table]:my-3 [&_table]:text-xs [&_table]:rounded-xl [&_table]:border [&_table]:border-slate-200
                        [&_th]:bg-slate-100 [&_th]:px-3.5 [&_th]:py-2.5 [&_th]:border [&_th]:border-slate-200 [&_th]:text-slate-900 [&_th]:font-bold [&_th]:text-left [&_th]:whitespace-nowrap
                        [&_td]:px-3.5 [&_td]:py-2.5 [&_td]:border [&_td]:border-slate-200 [&_td]:text-slate-800 [&_td]:whitespace-nowrap
                        [&_tr:nth-child(even)]:bg-slate-50/80
                        [&_h1]:text-base [&_h1]:font-black [&_h1]:text-indigo-950 [&_h1]:mt-4 [&_h1]:mb-2
                        [&_h2]:text-sm [&_h2]:font-black [&_h2]:text-slate-900 [&_h2]:mt-3.5 [&_h2]:mb-1.5
                        [&_h3]:text-xs [&_h3]:font-black [&_h3]:text-slate-900 [&_h3]:mt-2.5 [&_h3]:mb-1
                        [&_ul]:list-disc [&_ul]:pl-5 [&_ul]:space-y-1 [&_ul]:my-2
                        [&_ol]:list-decimal [&_ol]:pl-5 [&_ol]:space-y-1 [&_ol]:my-2">
                        {!! \App\Helpers\AiFormatter::format($selectedAdvice->content, true) !!}
                    </div>
                </div>

                <!-- Modal Alt Bar -->
                <div class="px-6 py-3.5 border-t border-slate-100 bg-slate-50 flex items-center justify-between">
                    <div class="text-[11px] text-slate-400 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v17.25m0 0c-1.472 0-2.882.265-4.185.75M12 20.25c1.472 0 2.882.265 4.185.75M18.75 4.5l-6.75 3-6.75-3m13.5 0v4.5c0 1.243-3.022 2.25-6.75 2.25S5.25 10.243 5.25 9V4.5m13.5 0H5.25"/></svg>
                        <span>6362 sayılı Kanun kapsamında yatırım veya finansal danışmanlık değildir.</span>
                    </div>
                    <button wire:click="closeAdviceModal" class="px-5 py-2 bg-slate-200 hover:bg-slate-300 text-slate-800 font-bold text-xs rounded-xl transition-all cursor-pointer">
                        Kapat
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
