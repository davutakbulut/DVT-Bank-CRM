<div class="py-1 sm:py-6 px-3 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-5 sm:space-y-6">
    <!-- 1. Üst Başlık & Eylem Butonları -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-xl bg-indigo-50 border border-indigo-200 text-indigo-700 flex items-center justify-center font-bold text-xl shrink-0 shadow-2xs">
                    🔔
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
                <span wire:loading.remove wire:target="generateAiAdvice">✨</span>
                <span wire:loading wire:target="generateAiAdvice" class="animate-spin text-xs">⏳</span>
                <span>Yeni AI Tavsiyesi Üret</span>
            </button>

            @if ($counts['unread'] > 0)
                <button wire:click="markAllAsRead" 
                        class="px-3 py-2 bg-slate-100 hover:bg-slate-200 active:scale-95 text-slate-700 font-bold text-xs rounded-lg border border-slate-200 transition-all flex items-center gap-1 cursor-pointer"
                        title="Tümünü Okundu Olarak İşaretle">
                    <span>✓</span>
                    <span>Tümünü Okundu Say</span>
                </button>
            @endif

            @if ($counts['read'] > 0)
                <button wire:click="markAllAsUnread" 
                        class="px-3 py-2 bg-slate-100 hover:bg-slate-200 active:scale-95 text-slate-700 font-bold text-xs rounded-lg border border-slate-200 transition-all flex items-center gap-1 cursor-pointer"
                        title="Tümünü Okunmadı Olarak İşaretle">
                    <span>↩️</span>
                    <span>Tümünü Okunmadı Yap</span>
                </button>
            @endif

            @if ($counts['all'] > 0)
                <button wire:click="deleteAll" 
                        wire:confirm="Tüm bildirim geçmişinizi silmek istediğinize emin misiniz? Bu işlem geri alınamaz."
                        class="px-2.5 py-2 bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold text-xs rounded-lg border border-rose-200 transition-all cursor-pointer"
                        title="Tüm Bildirimleri Temizle">
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

    <!-- 2. 4'lü KPI İstatistik Şeridi -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-2.5 sm:gap-3.5">
        <div class="bg-white p-3.5 sm:p-4 rounded-xl border border-slate-200/80 shadow-2xs flex items-center gap-2.5 sm:gap-3">
            <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center text-base sm:text-lg font-black shrink-0">
                🔔
            </div>
            <div class="min-w-0 flex-1">
                <span class="text-[10px] sm:text-[11px] font-bold text-slate-500 block uppercase tracking-wider truncate">Toplam Bildirim</span>
                <span class="text-sm sm:text-xl font-black font-mono text-slate-900 truncate block">{{ $counts['all'] }}</span>
            </div>
        </div>

        <div class="bg-white p-3.5 sm:p-4 rounded-xl border border-slate-200/80 shadow-2xs flex items-center gap-2.5 sm:gap-3">
            <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center text-base sm:text-lg font-black shrink-0">
                🔴
            </div>
            <div class="min-w-0 flex-1">
                <span class="text-[10px] sm:text-[11px] font-bold text-slate-500 block uppercase tracking-wider truncate">Okunmamış</span>
                <span class="text-sm sm:text-xl font-black font-mono text-rose-600 truncate block">{{ $counts['unread'] }}</span>
            </div>
        </div>

        <div class="bg-white p-3.5 sm:p-4 rounded-xl border border-slate-200/80 shadow-2xs flex items-center gap-2.5 sm:gap-3">
            <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center text-base sm:text-lg font-black shrink-0">
                💡
            </div>
            <div class="min-w-0 flex-1">
                <span class="text-[10px] sm:text-[11px] font-bold text-slate-500 block uppercase tracking-wider truncate">AI Tavsiyeleri</span>
                <span class="text-sm sm:text-xl font-black font-mono text-indigo-700 truncate block">{{ $counts['ai_advice'] }}</span>
            </div>
        </div>

        <div class="bg-white p-3.5 sm:p-4 rounded-xl border border-slate-200/80 shadow-2xs flex items-center gap-2.5 sm:gap-3">
            <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center text-base sm:text-lg font-black shrink-0">
                🚨
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
                            💡
                        @elseif ($n->type === 'risk_alert')
                            🚨
                        @elseif ($n->type === 'cashflow_alert')
                            💰
                        @else
                            🔔
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
                        <span>🔍 İncele</span>
                    </button>

                    <!-- Okundu / Okunmadı Durumu Değiştirici -->
                    <button wire:click="toggleRead({{ $n->id }})" 
                            title="{{ is_null($n->read_at) ? 'Okundu Olarak İşaretle' : 'Okunmadı Olarak İşaretle' }}"
                            class="px-2.5 py-1.5 text-xs font-bold rounded-lg border transition-all cursor-pointer flex items-center gap-1
                            {{ is_null($n->read_at) ? 'text-slate-600 hover:text-emerald-700 hover:bg-emerald-50 border-slate-200' : 'text-indigo-600 hover:bg-indigo-50 border-indigo-200 bg-indigo-50/50' }}">
                        <span>{{ is_null($n->read_at) ? '✓ Okundu Say' : '↩️ Okunmadı Yap' }}</span>
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

    <!-- 5. Bildirim İçerik & Analiz Detay Modalı -->
    @if ($showDetailModal && $selectedNotification)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs transition-opacity animate-in fade-in duration-200"
             x-data
             @keydown.escape.window="$wire.closeDetailModal()">
            <div class="bg-white rounded-2xl sm:rounded-3xl shadow-2xl border border-slate-200 max-w-2xl w-full max-h-[90vh] flex flex-col overflow-hidden animate-in zoom-in-95 duration-150">
                
                <!-- Modal Başlık Çubuğu -->
                <div class="px-5 sm:px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/70">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-xl shrink-0 font-bold
                            {{ $selectedNotification->severity === 'danger' ? 'bg-rose-100 text-rose-700' : '' }}
                            {{ $selectedNotification->severity === 'warning' ? 'bg-amber-100 text-amber-700' : '' }}
                            {{ $selectedNotification->severity === 'success' ? 'bg-emerald-100 text-emerald-700' : '' }}
                            {{ $selectedNotification->severity === 'info' ? 'bg-indigo-100 text-indigo-700' : '' }}">
                            @if ($selectedNotification->type === 'ai_advice')
                                💡
                            @elseif ($selectedNotification->type === 'risk_alert')
                                🚨
                            @elseif ($selectedNotification->type === 'cashflow_alert')
                                💰
                            @else
                                🔔
                            @endif
                        </div>
                        <div class="min-w-0">
                            <span class="text-[11px] font-black uppercase tracking-wider block
                                {{ $selectedNotification->severity === 'danger' ? 'text-rose-600' : '' }}
                                {{ $selectedNotification->severity === 'warning' ? 'text-amber-600' : '' }}
                                {{ $selectedNotification->severity === 'success' ? 'text-emerald-600' : '' }}
                                {{ $selectedNotification->severity === 'info' ? 'text-indigo-600' : '' }}">
                                @if ($selectedNotification->type === 'ai_advice')
                                    Google Gemini • AI Finans Koçu
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
                                <span>📊</span>
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
                            <span>{{ is_null($selectedNotification->read_at) ? '✓ Okundu Yap' : '↩️ Okunmadı Yap' }}</span>
                        </button>

                        <button wire:click="deleteNotification({{ $selectedNotification->id }})"
                                class="px-3 py-1.5 text-xs font-bold text-rose-600 hover:bg-rose-50 rounded-lg border border-rose-200 transition-all cursor-pointer">
                            🗑️ Sil
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

