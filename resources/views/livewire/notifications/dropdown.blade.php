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
                <a href="{{ $n->action_url ?: url('/app/bildirimler') }}" 
                   wire:click="markAsRead({{ $n->id }})" 
                   class="p-3.5 hover:bg-slate-50 transition-colors cursor-pointer flex items-start gap-3 {{ is_null($n->read_at) ? 'bg-indigo-50/30' : '' }}">
                    
                    <!-- İkon -->
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 text-sm font-bold
                        {{ $n->severity === 'danger' ? 'bg-rose-100 text-rose-700' : '' }}
                        {{ $n->severity === 'warning' ? 'bg-amber-100 text-amber-700' : '' }}
                        {{ $n->severity === 'success' ? 'bg-emerald-100 text-emerald-700' : '' }}
                        {{ $n->severity === 'info' ? 'bg-indigo-100 text-indigo-700' : '' }}">
                        @if ($n->type === 'ai_advice')
                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.516 0c.85.493 1.508 1.333 1.508 2.316V18"/></svg>
                        @elseif ($n->type === 'risk_alert')
                            <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                        @elseif ($n->type === 'cashflow_alert')
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5h16.5a1.5 1.5 0 011.5 1.5v9a1.5 1.5 0 01-1.5 1.5H3.75a1.5 1.5 0 01-1.5-1.5v-9a1.5 1.5 0 011.5-1.5zM12 12.75a2.25 2.25 0 100-4.5 2.25 2.25 0 000 4.5z"/></svg>
                        @else
                            <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/></svg>
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
                </a>
            @empty
                <div class="p-8 text-center text-slate-400 text-xs">
                    <svg class="w-8 h-8 mx-auto text-emerald-500 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Henüz yeni bir bildiriminiz yok.</span>
                </div>
            @endforelse
        </div>

        <!-- Alt Bağlantı -->
        <div class="px-4 py-2 bg-slate-50 border-t border-slate-100 text-center">
            <a href="{{ url('/app/bildirimler') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 transition-colors inline-flex items-center gap-1">
                <span>Tüm Bildirimleri Görüntüle</span>
                <span>→</span>
            </a>
        </div>
    </div>
</div>
