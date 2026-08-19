<div class="py-1 sm:py-6 px-3 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-5 sm:space-y-6">
    <!-- 1. Üst Başlık & Eylem Butonları -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-xl bg-indigo-50 border border-indigo-200 text-indigo-700 flex items-center justify-center font-bold text-xl shrink-0 shadow-2xs">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/></svg>
                </div>
                <div>
                    <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">Finansal Bildirim Merkezi</h1>
                    <p class="text-xs text-slate-500 mt-0.5">
                        Gemini AI günlük tavsiyeleri, 90 günlük yasal takip risk uyarıları ve nakit akışı bildirimleri
                    </p>
                </div>
            </div>
        </div>

        <!-- Üst Aksiyon Butonları -->
        <div class="flex flex-wrap items-center gap-2">
            <button wire:click="generateAiAdvice" 
                    wire:loading.attr="disabled"
                    class="px-3.5 py-2 bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white font-bold text-xs sm:text-sm rounded-lg shadow-xs transition-all flex items-center gap-1.5 cursor-pointer disabled:opacity-50">
                <span wire:loading.remove wire:target="generateAiAdvice">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z"/></svg>
                </span>
                <span wire:loading wire:target="generateAiAdvice" class="animate-spin text-xs">...</span>
                <span>Yeni AI Tavsiyesi Üret</span>
            </button>

            @if ($counts['unread'] > 0)
                <button wire:click="markAllAsRead" 
                        class="px-3 py-2 bg-slate-100 hover:bg-slate-200 active:scale-95 text-slate-700 font-bold text-xs rounded-lg border border-slate-200 transition-all flex items-center gap-1 cursor-pointer"
                        title="Tümünü Okundu Olarak İşaretle">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                    <span>Tümünü Okundu Say</span>
                </button>
            @endif

            @if ($counts['read'] > 0)
                <button wire:click="markAllAsUnread" 
                        class="px-3 py-2 bg-slate-100 hover:bg-slate-200 active:scale-95 text-slate-700 font-bold text-xs rounded-lg border border-slate-200 transition-all flex items-center gap-1 cursor-pointer"
                        title="Tümünü Okunmadı Olarak İşaretle">
                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3"/></svg>
                    <span>Tümünü Okunmadı Yap</span>
                </button>
            @endif

            @if ($counts['all'] > 0)
                <button wire:click="deleteAll" 
                        wire:confirm="Tüm bildirim geçmişinizi silmek istediğinize emin misiniz? Bu işlem geri alınamaz."
                        class="px-2.5 py-2 bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold text-xs rounded-lg border border-rose-200 transition-all cursor-pointer"
                        title="Tüm Bildirimleri Temizle">
                    <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                </button>
            @endif
        </div>
    </div>

    @if (session()->has('message'))
        <div class="p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-lg text-sm font-bold flex items-center gap-2 shadow-xs">
            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
            <span>{{ session('message') }}</span>
        </div>
    @endif

    <!-- 2. 4'lü KPI İstatistik Şeridi -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-2.5 sm:gap-3.5">
        <div class="bg-white p-3.5 sm:p-4 rounded-xl border border-slate-200/80 shadow-2xs flex items-center gap-2.5 sm:gap-3">
            <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center text-base sm:text-lg font-black shrink-0">
                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/></svg>
            </div>
            <div class="min-w-0 flex-1">
                <span class="text-[10px] sm:text-[11px] font-bold text-slate-500 block uppercase tracking-wider truncate">Toplam Bildirim</span>
                <span class="text-sm sm:text-xl font-black font-mono text-slate-900 truncate block">{{ $counts['all'] }}</span>
            </div>
        </div>

        <div class="bg-white p-3.5 sm:p-4 rounded-xl border border-slate-200/80 shadow-2xs flex items-center gap-2.5 sm:gap-3">
            <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center text-base sm:text-lg font-black shrink-0">
                <span class="w-2.5 h-2.5 rounded-full bg-rose-600"></span>
            </div>
            <div class="min-w-0 flex-1">
                <span class="text-[10px] sm:text-[11px] font-bold text-slate-500 block uppercase tracking-wider truncate">Okunmamış</span>
                <span class="text-sm sm:text-xl font-black font-mono text-rose-600 truncate block">{{ $counts['unread'] }}</span>
            </div>
        </div>

        <div class="bg-white p-3.5 sm:p-4 rounded-xl border border-slate-200/80 shadow-2xs flex items-center gap-2.5 sm:gap-3">
            <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center text-base sm:text-lg font-black shrink-0">
                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.516 0c.85.493 1.508 1.333 1.508 2.316V18"/></svg>
            </div>
            <div class="min-w-0 flex-1">
                <span class="text-[10px] sm:text-[11px] font-bold text-slate-500 block uppercase tracking-wider truncate">AI Tavsiyeleri</span>
                <span class="text-sm sm:text-xl font-black font-mono text-indigo-700 truncate block">{{ $counts['ai_advice'] }}</span>
            </div>
        </div>

        <div class="bg-white p-3.5 sm:p-4 rounded-xl border border-slate-200/80 shadow-2xs flex items-center gap-2.5 sm:gap-3">
            <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center text-base sm:text-lg font-black shrink-0">
                <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
            </div>
            <div class="min-w-0 flex-1">
                <span class="text-[10px] sm:text-[11px] font-bold text-slate-500 block uppercase tracking-wider truncate">Risk & Gecikmeler</span>
                <span class="text-sm sm:text-xl font-black font-mono text-amber-700 truncate block">{{ $counts['risk_alert'] }}</span>
            </div>
        </div>
    </div>

    <!-- 3. Filtre Çubuğu (Segmented Control & Arama) -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-2xs p-3.5 sm:p-4 space-y-3">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-3">
            <!-- Segmented Sekmeler -->
            <div class="inline-flex p-1 bg-slate-100 rounded-lg border border-slate-200/80 overflow-x-auto no-scrollbar">
                <button wire:click="$set('activeTab', 'all')" 
                        class="px-3 py-1.5 text-xs font-bold rounded-md transition-all whitespace-nowrap shrink-0 cursor-pointer {{ $activeTab === 'all' ? 'bg-white text-slate-900 shadow-2xs border border-slate-200/60 font-black' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-200/40' }}">
                    Tümü <span class="ml-1 text-[10px] font-mono px-1.5 py-0.5 rounded bg-slate-200/70 text-slate-700">({{ $counts['all'] }})</span>
                </button>
                <button wire:click="$set('activeTab', 'unread')" 
                        class="px-3 py-1.5 text-xs font-bold rounded-md transition-all whitespace-nowrap shrink-0 cursor-pointer {{ $activeTab === 'unread' ? 'bg-white text-rose-700 shadow-2xs border border-slate-200/60 font-black' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-200/40' }}">
                    Okunmamış <span class="ml-1 text-[10px] font-mono px-1.5 py-0.5 rounded bg-rose-100 text-rose-700 font-bold">({{ $counts['unread'] }})</span>
                </button>
                <button wire:click="$set('activeTab', 'ai_advice')" 
                        class="px-3 py-1.5 text-xs font-bold rounded-md transition-all whitespace-nowrap shrink-0 cursor-pointer {{ $activeTab === 'ai_advice' ? 'bg-white text-indigo-700 shadow-2xs border border-slate-200/60 font-black' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-200/40' }}">
                    AI Tavsiyeleri <span class="ml-1 text-[10px] font-mono px-1.5 py-0.5 rounded bg-indigo-100 text-indigo-700 font-bold">({{ $counts['ai_advice'] }})</span>
                </button>
                <button wire:click="$set('activeTab', 'risk_alert')" 
                        class="px-3 py-1.5 text-xs font-bold rounded-md transition-all whitespace-nowrap shrink-0 cursor-pointer {{ $activeTab === 'risk_alert' ? 'bg-white text-rose-700 shadow-2xs border border-slate-200/60 font-black' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-200/40' }}">
                    Yasal Takip Uyarıları <span class="ml-1 text-[10px] font-mono px-1.5 py-0.5 rounded bg-rose-100 text-rose-700 font-bold">({{ $counts['risk_alert'] }})</span>
                </button>
                <button wire:click="$set('activeTab', 'cashflow_alert')" 
                        class="px-3 py-1.5 text-xs font-bold rounded-md transition-all whitespace-nowrap shrink-0 cursor-pointer {{ $activeTab === 'cashflow_alert' ? 'bg-white text-emerald-700 shadow-2xs border border-slate-200/60 font-black' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-200/40' }}">
                    Nakit Akışı <span class="ml-1 text-[10px] font-mono px-1.5 py-0.5 rounded bg-emerald-100 text-emerald-700 font-bold">({{ $counts['cashflow_alert'] }})</span>
                </button>
            </div>

            <!-- Canlı Arama Inputu -->
            <div class="relative w-full lg:w-72">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 text-xs">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                </span>
                <input type="text" 
                       wire:model.live.debounce.300ms="search" 
                       placeholder="Bildirimlerde ara..." 
                       class="w-full pl-9 pr-8 py-1.5 bg-slate-50 border border-slate-300 rounded-lg text-xs sm:text-sm font-medium focus:bg-white focus:ring-1 focus:ring-indigo-600 focus:border-indigo-600 transition-all">
                @if ($search)
                    <button wire:click="$set('search', '')" class="absolute inset-y-0 right-0 pr-2.5 flex items-center text-slate-400 hover:text-slate-600 text-xs font-bold cursor-pointer">
                        ✕
                    </button>
                @endif
            </div>
        </div>
    </div>

    <!-- 4. Bildirim Listesi -->
    <div class="space-y-3">
        @forelse ($notifications as $n)
            <div wire:key="notif-card-{{ $n->id }}" class="bg-white rounded-xl border {{ is_null($n->read_at) ? 'border-indigo-300 bg-indigo-50/20 border-l-4 border-l-indigo-600 shadow-xs' : 'border-slate-200 shadow-2xs' }} p-4 sm:p-5 transition-all flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                <div class="flex items-start gap-3.5 min-w-0 flex-1">
                    <!-- Tip / Severity İkonu -->
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 text-lg font-bold
                        {{ $n->severity === 'danger' ? 'bg-rose-100 text-rose-700 border border-rose-200' : '' }}
                        {{ $n->severity === 'warning' ? 'bg-amber-100 text-amber-700 border border-amber-200' : '' }}
                        {{ $n->severity === 'success' ? 'bg-emerald-100 text-emerald-700 border border-emerald-200' : '' }}
                        {{ $n->severity === 'info' ? 'bg-indigo-100 text-indigo-700 border border-indigo-200' : '' }}">
                        @if ($n->type === 'ai_advice')
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.516 0c.85.493 1.508 1.333 1.508 2.316V18"/></svg>
                        @elseif ($n->type === 'risk_alert')
                            <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                        @elseif ($n->type === 'cashflow_alert')
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5h16.5a1.5 1.5 0 011.5 1.5v9a1.5 1.5 0 01-1.5 1.5H3.75a1.5 1.5 0 01-1.5-1.5v-9a1.5 1.5 0 011.5-1.5zM12 12.75a2.25 2.25 0 100-4.5 2.25 2.25 0 000 4.5z"/></svg>
                        @else
                            <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/></svg>
                        @endif
                    </div>

                    <div class="space-y-1.5 min-w-0 flex-1">
                        <div class="flex flex-wrap items-center gap-2">
                            <h3 class="text-sm font-black text-slate-900 {{ is_null($n->read_at) ? 'text-indigo-950' : '' }}">
                                {{ $n->title }}
                            </h3>

                            @if (is_null($n->read_at))
                                <span class="px-2 py-0.5 text-[10px] font-black rounded-md bg-rose-600 text-white uppercase tracking-wider">
                                    Okunmadı
                                </span>
                            @else
                                <span class="px-2 py-0.5 text-[10px] font-bold rounded-md bg-slate-100 text-slate-600 border border-slate-200">
                                    Okundu
                                </span>
                            @endif

                            @if (isset($n->data['provider']) && $n->data['provider'] === 'gemini')
                                <span class="px-2 py-0.5 text-[10px] font-extrabold rounded-md bg-purple-50 text-purple-700 border border-purple-200 flex items-center gap-1">
                                    <svg class="w-3 h-3 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/></svg>
                                    <span>Google Gemini</span>
                                </span>
                            @elseif (isset($n->data['provider']) && $n->data['provider'] === 'groq')
                                <span class="px-2 py-0.5 text-[10px] font-extrabold rounded-md bg-amber-50 text-amber-800 border border-amber-200 flex items-center gap-1">
                                    <svg class="w-3 h-3 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/></svg>
                                    <span>Groq Llama</span>
                                </span>
                            @endif

                            <span class="text-[11px] text-slate-400 font-medium">
                                • {{ $n->created_at->translatedFormat('d F Y, H:i') }} ({{ $n->created_at->diffForHumans() }})
                            </span>
                        </div>

                        <div class="text-xs sm:text-sm text-slate-700 leading-relaxed font-sans prose prose-sm max-w-none">
                            {!! \App\Helpers\AiFormatter::format($n->message, true) !!}
                        </div>
                    </div>
                </div>

                <!-- Aksiyon Butonları -->
                <div class="flex items-center gap-2 self-end sm:self-center shrink-0 pt-2 sm:pt-0 border-t sm:border-t-0 border-slate-100 w-full sm:w-auto justify-end">
                    <button wire:click="viewNotification({{ $n->id }})" 
                            class="px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-bold text-xs rounded-lg border border-indigo-200 transition-all flex items-center gap-1 cursor-pointer"
                            title="Bildirim İçeriğini ve Analizini Gör">
                        <svg class="w-3.5 h-3.5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                        <span>İncele</span>
                    </button>

                    <!-- Okundu / Okunmadı Durumu Değiştirici -->
                    <button wire:click="toggleRead({{ $n->id }})" 
                            title="{{ is_null($n->read_at) ? 'Okundu Olarak İşaretle' : 'Okunmadı Olarak İşaretle' }}"
                            class="px-2.5 py-1.5 text-xs font-bold rounded-lg border transition-all cursor-pointer flex items-center gap-1
                            {{ is_null($n->read_at) ? 'text-slate-600 hover:text-emerald-700 hover:bg-emerald-50 border-slate-200' : 'text-indigo-600 hover:bg-indigo-50 border-indigo-200 bg-indigo-50/50' }}">
                        <span>{{ is_null($n->read_at) ? 'Okundu Say' : 'Okunmadı Yap' }}</span>
                    </button>

                    <!-- Silme Butonu -->
                    <button wire:click="deleteNotification({{ $n->id }})" 
                            title="Bildirimi Sil"
                            class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg border border-slate-200 transition-all cursor-pointer">
                        ✕
                    </button>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center text-slate-500 space-y-2">
                <svg class="w-12 h-12 mx-auto text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <h3 class="text-base font-bold text-slate-800">Hiç bildirim bulunamadı</h3>
                <p class="text-xs text-slate-500 max-w-sm mx-auto">
                    Şu anda seçili filtreye ait kayıtlı bir bildiriminiz bulunmuyor. Yeni bir tavsiye oluşturmak için üstteki butona tıklayabilirsiniz.
                </p>
            </div>
        @endforelse

        <div class="pt-4">
            {{ $notifications->links() }}
        </div>
    </div>

    <!-- 5. Bildirim İçerik & Analiz Detay Modalı -->
    @if ($showDetailModal && $selectedNotification)
        <div wire:key="notification-detail-modal"
             class="fixed inset-0 z-50 flex items-center justify-center p-2 sm:p-4 bg-slate-900/60 backdrop-blur-xs transition-opacity animate-in fade-in duration-200"
             x-data
             @keydown.escape.window="$wire.closeDetailModal()">
            <div class="bg-white rounded-2xl sm:rounded-3xl shadow-2xl border border-slate-200 max-w-4xl w-full max-h-[92vh] flex flex-col overflow-hidden animate-in zoom-in-95 duration-150">
                
                <!-- Modal Başlık Çubuğu -->
                <div class="px-5 sm:px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/70">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-xl shrink-0 font-bold
                            {{ $selectedNotification->severity === 'danger' ? 'bg-rose-100 text-rose-700' : '' }}
                            {{ $selectedNotification->severity === 'warning' ? 'bg-amber-100 text-amber-700' : '' }}
                            {{ $selectedNotification->severity === 'success' ? 'bg-emerald-100 text-emerald-700' : '' }}
                            {{ $selectedNotification->severity === 'info' ? 'bg-indigo-100 text-indigo-700' : '' }}">
                            @if ($selectedNotification->type === 'ai_advice')
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.516 0c.85.493 1.508 1.333 1.508 2.316V18"/></svg>
                            @elseif ($selectedNotification->type === 'risk_alert')
                                <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                            @elseif ($selectedNotification->type === 'cashflow_alert')
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5h16.5a1.5 1.5 0 011.5 1.5v9a1.5 1.5 0 01-1.5 1.5H3.75a1.5 1.5 0 01-1.5-1.5v-9a1.5 1.5 0 011.5-1.5zM12 12.75a2.25 2.25 0 000 4.5z"/></svg>
                            @else
                                <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/></svg>
                            @endif
                        </div>
                        <div class="min-w-0">
                            <span class="text-[11px] font-black uppercase tracking-wider block
                                {{ $selectedNotification->severity === 'danger' ? 'text-rose-600' : '' }}
                                {{ $selectedNotification->severity === 'warning' ? 'text-amber-600' : '' }}
                                {{ $selectedNotification->severity === 'success' ? 'text-emerald-600' : '' }}
                                {{ $selectedNotification->severity === 'info' ? 'text-indigo-600' : '' }}">
                                @if ($selectedNotification->type === 'ai_advice')
                                    @if (isset($selectedNotification->data['provider']) && $selectedNotification->data['provider'] === 'groq')
                                        Groq Llama • AI Finans Koçu
                                    @elseif (isset($selectedNotification->data['provider']) && $selectedNotification->data['provider'] === 'gemini')
                                        Google Gemini • AI Finans Koçu
                                    @else
                                        AI Finans Koçu
                                    @endif
                                @elseif ($selectedNotification->type === 'risk_alert')
                                    Kritik Risk & Yasal Takip Alarmı
                                @elseif ($selectedNotification->type === 'cashflow_alert')
                                    Nakit Akışı Uyarısı
                                @else
                                    Sistem Bildirimi
                                @endif
                            </span>
                            <span class="text-xs text-slate-400 font-medium">
                                {{ $selectedNotification->created_at->translatedFormat('d F Y, H:i') }} ({{ $selectedNotification->created_at->diffForHumans() }})
                            </span>
                        </div>
                    </div>

                    <!-- Kapat Butonu -->
                    <button wire:click="closeDetailModal" 
                            class="p-2 text-slate-400 hover:text-slate-700 hover:bg-slate-200/60 rounded-xl transition-all cursor-pointer">
                        ✕
                    </button>
                </div>

                <!-- Modal Gövde / Bildirim İçeriği -->
                <div class="p-5 sm:p-6 overflow-y-auto space-y-4">
                    <!-- Bildirim Ana Başlığı -->
                    <h2 class="text-lg sm:text-xl font-black text-slate-900 tracking-tight leading-snug">
                        {{ $selectedNotification->title }}
                    </h2>

                    <!-- Tam Mesaj & Markdown Tablo/Tipografi -->
                    <div class="p-4 sm:p-5 rounded-2xl bg-slate-50 border border-slate-200 text-slate-800 text-sm leading-relaxed prose prose-sm max-w-none">
                        {!! \App\Helpers\AiFormatter::format($selectedNotification->message, true) !!}
                    </div>

                    <!-- Varsa Snapshot Veriler (Banka, Gecikme, Tutar vb.) -->
                    @if (!empty($selectedNotification->data))
                        <div class="p-4 rounded-xl bg-indigo-50/50 border border-indigo-100 space-y-2">
                            <h4 class="text-xs font-bold text-indigo-900 flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
                                <span>Bildirime Esas Finansal Parametreler:</span>
                            </h4>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 text-xs">
                                @if (isset($selectedNotification->data['provider']))
                                    <div class="p-2 bg-white rounded-lg border border-indigo-100">
                                        <span class="text-slate-400 block text-[10px]">Motor:</span>
                                        <span class="font-bold text-indigo-700 uppercase">{{ $selectedNotification->data['provider'] }}</span>
                                    </div>
                                @endif
                                @if (isset($selectedNotification->data['overdue_days']))
                                    <div class="p-2 bg-white rounded-lg border border-rose-100">
                                        <span class="text-slate-400 block text-[10px]">Gecikme:</span>
                                        <span class="font-bold text-rose-600">{{ $selectedNotification->data['overdue_days'] }} Gün</span>
                                    </div>
                                @endif
                                @if (isset($selectedNotification->data['bank_name']))
                                    <div class="p-2 bg-white rounded-lg border border-indigo-100">
                                        <span class="text-slate-400 block text-[10px]">İlgili Banka:</span>
                                        <span class="font-bold text-slate-800">{{ $selectedNotification->data['bank_name'] }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Modal Alt Bar & Aksiyonlar -->
                <div class="px-5 sm:px-6 py-3.5 border-t border-slate-100 bg-slate-50 flex flex-wrap items-center justify-between gap-3">
                    <div class="flex items-center gap-2">
                        <button wire:click="toggleRead({{ $selectedNotification->id }})"
                                class="px-3 py-1.5 text-xs font-bold rounded-lg border transition-all cursor-pointer flex items-center gap-1
                                {{ is_null($selectedNotification->read_at) ? 'bg-white text-slate-700 border-slate-200 hover:bg-slate-100' : 'bg-indigo-50 text-indigo-700 border-indigo-200' }}">
                            <span>{{ is_null($selectedNotification->read_at) ? 'Okundu Yap' : 'Okunmadı Yap' }}</span>
                        </button>

                        <button wire:click="deleteNotification({{ $selectedNotification->id }})"
                                class="px-3 py-1.5 text-xs font-bold text-rose-600 hover:bg-rose-50 rounded-lg border border-rose-200 transition-all cursor-pointer">
                            Sil
                        </button>
                    </div>

                    <div class="flex items-center gap-2">
                        @if ($selectedNotification->action_url)
                            <a href="{{ $selectedNotification->action_url }}" 
                               class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white font-bold text-xs rounded-xl shadow-xs transition-all flex items-center gap-1.5 cursor-pointer">
                                <span>İlgili Sayfaya Git</span>
                                <span>→</span>
                            </a>
                        @endif

                        <button wire:click="closeDetailModal" 
                                class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold text-xs rounded-xl transition-all cursor-pointer">
                            Kapat
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
