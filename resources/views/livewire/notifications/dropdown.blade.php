<div class="relative" x-data="{ open: @entangle('isOpen') }" @click.outside="open = false">
    <!-- Bildirim Zili Butonu -->
    <button @click="open = !open" 
            type="button"
            class="relative p-2 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-all focus:outline-none cursor-pointer flex items-center justify-center">
        <span class="sr-only">Bildirimler</span>
        <!-- Zil İkonu -->
        <svg class="w-5 h-5 text-slate-600 hover:text-indigo-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
        </svg>

        <!-- Okunmamış Sayacı (Kırmızı Rozet) -->
        @if ($unreadCount > 0)
            <span class="absolute top-1 right-1 flex h-4 w-4">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-4 w-4 bg-rose-600 text-[10px] font-black text-white items-center justify-center">
                    {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                </span>
            </span>
        @endif
    </button>

    <!-- Bildirim Dropdown Penceresi -->
    <div x-show="open" 
         x-cloak
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute right-0 mt-2 w-80 sm:w-96 bg-white rounded-2xl shadow-2xl border border-slate-200/90 py-2 z-50 overflow-hidden">
        
        <!-- Üst Başlık -->
        <div class="px-4 py-2.5 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="font-bold text-slate-900 text-sm">Bildirimler</span>
                @if ($unreadCount > 0)
                    <span class="px-2 py-0.5 text-[11px] font-bold rounded-full bg-rose-50 text-rose-600 border border-rose-200">
                        {{ $unreadCount }} yeni
                    </span>
                @endif
            </div>

            @if ($unreadCount > 0)
                <button wire:click="markAllAsRead" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 transition-colors cursor-pointer">
                    Tümünü Okundu Say
                </button>
            @endif
        </div>

        <!-- Bildirim Listesi -->
        <div class="max-h-80 overflow-y-auto divide-y divide-slate-100">
            @forelse ($notifications as $n)
                <a href="{{ $n->action_url ?: route('notifications.index') }}" 
                   wire:click="markAsRead({{ $n->id }})" 
                   class="p-3.5 hover:bg-slate-50 transition-colors cursor-pointer flex items-start gap-3 {{ is_null($n->read_at) ? 'bg-indigo-50/30' : '' }}">
                    
                    <!-- İkon -->
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 text-sm font-bold
                        {{ $n->severity === 'danger' ? 'bg-rose-100 text-rose-700' : '' }}
                        {{ $n->severity === 'warning' ? 'bg-amber-100 text-amber-700' : '' }}
                        {{ $n->severity === 'success' ? 'bg-emerald-100 text-emerald-700' : '' }}
                        {{ $n->severity === 'info' ? 'bg-indigo-100 text-indigo-700' : '' }}">
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

                    <!-- İçerik -->
                    <div class="min-w-0 flex-1">
                        <div class="flex items-center justify-between gap-1 mb-0.5">
                            <h4 class="text-xs font-bold text-slate-900 truncate {{ is_null($n->read_at) ? 'font-black' : '' }}">
                                {{ $n->title }}
                            </h4>
                            <span class="text-[10px] text-slate-400 shrink-0">
                                {{ $n->created_at->diffForHumans() }}
                            </span>
                        </div>
                        <p class="text-[11px] text-slate-600 line-clamp-2 leading-relaxed">
                            {{ $n->message }}
                        </p>
                    </div>

                    <!-- Okunmadı Noktası -->
                    @if (is_null($n->read_at))
                        <span class="w-2 h-2 rounded-full bg-indigo-600 shrink-0 self-center"></span>
                    @endif
                </div>
            @empty
                <div class="p-8 text-center text-slate-400 text-xs">
                    <span class="text-2xl block mb-1">🎉</span>
                    <span>Henüz yeni bir bildiriminiz yok.</span>
                </div>
            @endforelse
        </div>

        <!-- Alt Bağlantı -->
        <div class="px-4 py-2 bg-slate-50 border-t border-slate-100 text-center">
            <a href="{{ route('notifications.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 transition-colors inline-flex items-center gap-1">
                <span>Tüm Bildirimleri Görüntüle</span>
                <span>→</span>
            </a>
        </div>
    </div>
</div>
