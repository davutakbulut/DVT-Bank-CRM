<div class="space-y-6">
    <!-- 1. Üst Başlık & Eylem Butonları -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="text-2xl sm:text-3xl">🔔</span>
                <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">Finansal Bildirim Merkezi</h1>
            </div>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Gemini AI günlük tavsiyeleri, 90 günlük yasal takip risk uyarıları ve nakit akışı bildirimleri
            </p>
        </div>

        <div class="flex items-center gap-2">
            <button wire:click="generateAiAdvice" 
                    class="px-3.5 py-2 bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white font-bold text-xs sm:text-sm rounded-lg shadow-xs transition-all flex items-center gap-1.5 cursor-pointer">
                <span>✨</span>
                <span>Yeni AI Tavsiyesi Üret</span>
            </button>

            @if ($counts['unread'] > 0)
                <button wire:click="markAllAsRead" 
                        class="px-3.5 py-2 bg-slate-100 hover:bg-slate-200 active:scale-95 text-slate-700 font-bold text-xs sm:text-sm rounded-lg border border-slate-200/80 transition-all flex items-center gap-1.5 cursor-pointer">
                    <span>✓</span>
                    <span>Tümünü Okundu Say</span>
                </button>
            @endif

            @if ($counts['all'] > 0)
                <button wire:click="deleteAll" 
                        wire:confirm="Tüm bildirim geçmişini silmek istediğinize emin misiniz?"
                        class="px-3 py-2 bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold text-xs rounded-lg border border-rose-200 transition-all cursor-pointer">
                    <span>🗑️</span>
                </button>
            @endif
        </div>
    </div>

    @if (session()->has('message'))
        <div class="p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-lg text-sm font-bold flex items-center gap-2 shadow-xs">
            <span>✓</span>
            <span>{{ session('message') }}</span>
        </div>
    @endif

    <!-- 2. Filtre Çubuğu (Segmented Control & Arama) -->
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
                    🔴 Okunmamış <span class="ml-1 text-[10px] font-mono px-1.5 py-0.5 rounded bg-rose-100 text-rose-700 font-bold">({{ $counts['unread'] }})</span>
                </button>
                <button wire:click="$set('activeTab', 'ai_advice')" 
                        class="px-3 py-1.5 text-xs font-bold rounded-md transition-all whitespace-nowrap shrink-0 cursor-pointer {{ $activeTab === 'ai_advice' ? 'bg-white text-indigo-700 shadow-2xs border border-slate-200/60 font-black' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-200/40' }}">
                    💡 AI Tavsiyeleri <span class="ml-1 text-[10px] font-mono px-1.5 py-0.5 rounded bg-indigo-100 text-indigo-700 font-bold">({{ $counts['ai_advice'] }})</span>
                </button>
                <button wire:click="$set('activeTab', 'risk_alert')" 
                        class="px-3 py-1.5 text-xs font-bold rounded-md transition-all whitespace-nowrap shrink-0 cursor-pointer {{ $activeTab === 'risk_alert' ? 'bg-white text-rose-700 shadow-2xs border border-slate-200/60 font-black' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-200/40' }}">
                    🚨 Yasal Takip Uyarıları <span class="ml-1 text-[10px] font-mono px-1.5 py-0.5 rounded bg-rose-100 text-rose-700 font-bold">({{ $counts['risk_alert'] }})</span>
                </button>
                <button wire:click="$set('activeTab', 'cashflow_alert')" 
                        class="px-3 py-1.5 text-xs font-bold rounded-md transition-all whitespace-nowrap shrink-0 cursor-pointer {{ $activeTab === 'cashflow_alert' ? 'bg-white text-emerald-700 shadow-2xs border border-slate-200/60 font-black' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-200/40' }}">
                    💰 Nakit Akışı <span class="ml-1 text-[10px] font-mono px-1.5 py-0.5 rounded bg-emerald-100 text-emerald-700 font-bold">({{ $counts['cashflow_alert'] }})</span>
                </button>
            </div>

            <!-- Canlı Arama Inputu -->
            <div class="relative w-full lg:w-72">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 text-xs">
                    🔍
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

    <!-- 3. Bildirim Listesi -->
    <div class="space-y-3">
        @forelse ($notifications as $n)
            <div class="bg-white rounded-xl border {{ is_null($n->read_at) ? 'border-indigo-200 bg-indigo-50/20 shadow-xs' : 'border-slate-200 shadow-2xs' }} p-4 sm:p-5 transition-all flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-start gap-3.5 min-w-0 flex-1">
                    <!-- Tip / Severity İkonu -->
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 text-lg font-bold
                        {{ $n->severity === 'danger' ? 'bg-rose-100 text-rose-700 border border-rose-200' : '' }}
                        {{ $n->severity === 'warning' ? 'bg-amber-100 text-amber-700 border border-amber-200' : '' }}
                        {{ $n->severity === 'success' ? 'bg-emerald-100 text-emerald-700 border border-emerald-200' : '' }}
                        {{ $n->severity === 'info' ? 'bg-indigo-100 text-indigo-700 border border-indigo-200' : '' }}">
                        @if ($n->type === 'ai_advice')
                            💡
                        @elseif ($n->type === 'risk_alert')
                            🚨
                        @elseif ($n->type === 'cashflow_alert')
                            💰
                        @else
                            🔔
                        @endif
                    </div>

                    <div class="space-y-1 min-w-0 flex-1">
                        <div class="flex flex-wrap items-center gap-2">
                            <h3 class="text-sm font-black text-slate-900 {{ is_null($n->read_at) ? 'text-indigo-950' : '' }}">
                                {{ $n->title }}
                            </h3>

                            @if (is_null($n->read_at))
                                <span class="px-2 py-0.5 text-[10px] font-black rounded-md bg-indigo-600 text-white uppercase tracking-wider">
                                    Yeni
                                </span>
                            @endif

                            <span class="text-[11px] text-slate-400 font-medium">
                                • {{ $n->created_at->translatedFormat('d F Y, H:i') }} ({{ $n->created_at->diffForHumans() }})
                            </span>
                        </div>

                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            {{ $n->message }}
                        </p>
                    </div>
                </div>

                <!-- Aksiyonlar -->
                <div class="flex items-center gap-2 self-end sm:self-center shrink-0">
                    @if ($n->action_url)
                        <button wire:click="markAsRead({{ $n->id }})" 
                                class="px-3.5 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-bold text-xs rounded-lg border border-indigo-200 transition-all flex items-center gap-1 cursor-pointer">
                            <span>İncele</span>
                            <span>→</span>
                        </button>
                    @endif

                    @if (is_null($n->read_at))
                        <button wire:click="markAsRead({{ $n->id }})" 
                                title="Okundu Olarak İşaretle"
                                class="p-1.5 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg border border-slate-200 transition-all cursor-pointer">
                            ✓
                        </button>
                    @endif

                    <button wire:click="deleteNotification({{ $n->id }})" 
                            title="Bildirimi Sil"
                            class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg border border-slate-200 transition-all cursor-pointer">
                        ✕
                    </button>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center text-slate-500 space-y-2">
                <span class="text-4xl block">🎉</span>
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
</div>
