<div>
    <!-- 1. FLOATING ACTION BUTTON (SABİT HIZLI EKLEME BUTONU) -->
    <div class="fixed bottom-5 right-5 sm:bottom-6 sm:right-6 z-40 flex flex-col items-end gap-2 group">
        <!-- İpucu Rozeti (Desktop) -->
        <span class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1 bg-slate-900/90 backdrop-blur-md text-white text-[11px] font-bold rounded-xl shadow-xl border border-indigo-500/30 translate-y-1 opacity-0 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300 pointer-events-none">
            <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/></svg>
            <span>Tek Cümleyle veya Toplu Ekle</span>
        </span>

        <!-- Ana FAB Butonu -->
        <button wire:click="open" 
                aria-label="Hızlı İşlem Ekle"
                class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl sm:rounded-3xl bg-gradient-to-tr from-indigo-600 via-indigo-500 to-sky-500 text-white shadow-[0_10px_30px_rgba(79,70,229,0.45)] hover:shadow-[0_15px_35px_rgba(79,70,229,0.65)] hover:scale-105 active:scale-95 transition-all flex items-center justify-center relative border-2 border-white/30 group/btn cursor-pointer">
            <svg class="w-7 h-7 text-white transition-transform duration-300 group-hover/btn:rotate-45" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            <!-- Canlı Titreşim Efekti -->
            <span class="absolute -top-1 -right-1 w-3.5 h-3.5 bg-emerald-400 rounded-full border-2 border-white animate-ping"></span>
            <span class="absolute -top-1 -right-1 w-3.5 h-3.5 bg-emerald-500 rounded-full border-2 border-white"></span>
        </button>
    </div>

    <!-- 2. HIZLI İŞLEM MERKEZİ MODALI (Mobil Uyumlu Tam Ekran / Desktop Modal) -->
    @if ($isOpen)
        <div class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/70 backdrop-blur-md flex flex-col sm:items-center sm:justify-center p-0 sm:p-4 lg:p-6 animate-fade-in"
             wire:keydown.escape="close">
            
            <div class="bg-white sm:backdrop-blur-xl w-full h-full sm:h-auto sm:max-h-[90vh] sm:max-w-2xl sm:rounded-[28px] rounded-none border-0 sm:border border-slate-200/80 shadow-2xl flex flex-col overflow-hidden transition-all transform animate-scale-up ring-0 sm:ring-1 sm:ring-black/5"
                 @click.away="$wire.close()">
                
                <!-- Modal Başlığı (Kompakt ve Şık) -->
                <div class="px-4 sm:px-6 py-3.5 sm:py-4 bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 text-white flex items-center justify-between border-b border-indigo-900/50 shrink-0">
                    <div class="flex items-center gap-2.5 sm:gap-3">
                        <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl sm:rounded-2xl bg-gradient-to-tr from-indigo-500 to-sky-400 p-0.5 shadow-md flex items-center justify-center shrink-0">
                            <div class="w-full h-full bg-slate-900 rounded-[10px] sm:rounded-[14px] flex items-center justify-center text-base sm:text-lg text-indigo-300">
                                <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/></svg>
                            </div>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="text-sm sm:text-lg font-black tracking-tight text-white">Hızlı İşlem Merkezi</h3>
                                <span class="px-1.5 sm:px-2 py-0.5 rounded-md sm:rounded-full bg-indigo-500/20 border border-indigo-400/30 text-[9px] sm:text-[10px] font-extrabold text-indigo-300">
                                    AI & NLP
                                </span>
                            </div>
                            <p class="hidden sm:block text-xs text-slate-300 mt-0.5">Serbest Türkçe cümle, hazır şablonlar veya toplu ekstre girişi</p>
                        </div>
                    </div>

                    <button wire:click="close" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 active:scale-95 text-slate-300 hover:text-white flex items-center justify-center text-xs font-black transition-all cursor-pointer">
                        ✕
                    </button>
                </div>

                <!-- Modern 4'lü Sekme Çubuğu (Mobilde Tam Oturan Grid) -->
                <div class="px-3 sm:px-6 pt-2.5 pb-2 bg-slate-50 border-b border-slate-200/80 shrink-0">
                    <div class="bg-slate-200/80 p-1 rounded-xl sm:rounded-2xl grid grid-cols-4 gap-1 shadow-inner text-xs font-bold">
                        <button wire:click="$set('activeTab', 'ai')" 
                                class="py-2 sm:py-2.5 px-1 sm:px-3 rounded-lg sm:rounded-xl transition-all flex items-center justify-center gap-1 sm:gap-1.5 text-center cursor-pointer {{ $activeTab === 'ai' ? 'bg-white text-indigo-700 shadow-sm font-black' : 'text-slate-600 hover:text-slate-900' }}">
                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/></svg>
                            <span class="text-[11px] sm:text-xs truncate">AI Giriş</span>
                        </button>
                        <button wire:click="$set('activeTab', 'expense')" 
                                class="py-2 sm:py-2.5 px-1 sm:px-3 rounded-lg sm:rounded-xl transition-all flex items-center justify-center gap-1 sm:gap-1.5 text-center cursor-pointer {{ $activeTab === 'expense' ? 'bg-white text-indigo-700 shadow-sm font-black' : 'text-slate-600 hover:text-slate-900' }}">
                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-6h6"/></svg>
                            <span class="text-[11px] sm:text-xs truncate">Gelir/Gider</span>
                        </button>
                        <button wire:click="$set('activeTab', 'debt')" 
                                class="py-2 sm:py-2.5 px-1 sm:px-3 rounded-lg sm:rounded-xl transition-all flex items-center justify-center gap-1 sm:gap-1.5 text-center cursor-pointer {{ $activeTab === 'debt' ? 'bg-white text-indigo-700 shadow-sm font-black' : 'text-slate-600 hover:text-slate-900' }}">
                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 3h6m-6 3h6m-6 3h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5z"/></svg>
                            <span class="text-[11px] sm:text-xs truncate">Borç/Kart</span>
                        </button>
                        <button wire:click="$set('activeTab', 'bulk')" 
                                class="py-2 sm:py-2.5 px-1 sm:px-3 rounded-lg sm:rounded-xl transition-all flex items-center justify-center gap-1 sm:gap-1.5 text-center cursor-pointer {{ $activeTab === 'bulk' ? 'bg-white text-indigo-700 shadow-sm font-black' : 'text-slate-600 hover:text-slate-900' }}">
                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m.75 12l3 3m0 0l3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                            <span class="text-[11px] sm:text-xs truncate">Ekstre</span>
                        </button>
                    </div>
                </div>

                <!-- Modal İçeriği (Kaydırılabilir Alan) -->
                <div class="p-4 sm:p-6 overflow-y-auto space-y-4 sm:space-y-5 flex-1 bg-white">

                    <!-- Hata & Başarı Bildirimleri -->
                    @if (session()->has('error'))
                        <div class="p-3 bg-rose-50 border border-rose-200 text-rose-700 text-xs font-bold rounded-xl flex items-center gap-2.5 animate-shake">
                            <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif

                    @if (session()->has('success'))
                        <div class="p-3 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold rounded-xl flex items-center gap-2.5 animate-fade-in">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    <!-- ========================================== -->
                    <!-- SEKME 1: AI AKILLI METİN GİRİŞİ (NLP)      -->
                    <!-- ========================================== -->
                    @if ($activeTab === 'ai')
                        <div class="space-y-3.5 sm:space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5 flex items-center justify-between">
                                    <span class="flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
                                        <span>Yaptığınız işlemi tek bir cümleyle yazın:</span>
                                    </span>
                                    <span class="inline-flex items-center gap-1 text-[10px] font-black text-indigo-600 bg-indigo-50 border border-indigo-200/60 px-2 py-0.5 rounded-md">
                                        <span class="w-1.5 h-1.5 rounded-full bg-indigo-600 animate-pulse"></span>
                                        Canlı NLP
                                    </span>
                                </label>
                                
                                <div class="relative group/input">
                                    <textarea wire:model.live.debounce.250ms="aiInputText" 
                                              wire:keydown.enter.prevent="saveParsedTransaction"
                                              rows="3" 
                                              placeholder="Örn: Enpara hesabıma 45.000 maaş yattı veya bakkaldan 2 paket sigara aldım 250₺..." 
                                              class="w-full rounded-xl sm:rounded-2xl border-slate-300 text-xs sm:text-sm font-medium focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 p-3 sm:p-3.5 leading-relaxed shadow-2xs transition-all placeholder:text-slate-400"></textarea>
                                    @if ($aiInputText)
                                        <button wire:click="$set('aiInputText', '')" class="absolute top-2.5 right-2.5 px-2 py-1 bg-slate-100 hover:bg-slate-200 text-slate-600 text-[10px] sm:text-xs font-bold rounded-lg transition-colors cursor-pointer">
                                            Temizle ✕
                                        </button>
                                    @endif
                                </div>
                            </div>

                            <!-- Örnek Şablon Cümleleri (Tıklanabilir Çipler) -->
                            <div class="space-y-1.5">
                                <span class="text-[10px] sm:text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Örnek Kalıplar (Dene):</span>
                                <div class="flex items-center gap-1.5 flex-wrap text-xs">
                                    <button type="button" wire:click="$set('aiInputText', 'Enpara Bankası hesabıma 45.000 maaş yattı')" class="px-2.5 sm:px-3 py-1 bg-slate-100 hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-200 border border-transparent rounded-lg sm:rounded-xl text-slate-600 text-[11px] sm:text-xs font-medium transition-all cursor-pointer">
                                        Enpara 45k Maaş
                                    </button>
                                    <button type="button" wire:click="$set('aiInputText', 'bakkaldan 2 paket sigara aldım 250₺')" class="px-2.5 sm:px-3 py-1 bg-slate-100 hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-200 border border-transparent rounded-lg sm:rounded-xl text-slate-600 text-[11px] sm:text-xs font-medium transition-all cursor-pointer">
                                        Sigara 250₺
                                    </button>
                                    <button type="button" wire:click="$set('aiInputText', 'enpara hesabıma 5000₺ yattı garanti kartımdan da su aldım 10₺')" class="px-2.5 sm:px-3 py-1 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200/60 rounded-lg sm:rounded-xl text-[11px] sm:text-xs font-bold transition-all cursor-pointer">
                                        2'li İşlem Girişi
                                    </button>
                                    <button type="button" wire:click="$set('aiInputText', 'Shell 1500 TL benzin yakıt harcaması Akbank')" class="px-2.5 sm:px-3 py-1 bg-slate-100 hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-200 border border-transparent rounded-lg sm:rounded-xl text-slate-600 text-[11px] sm:text-xs font-medium transition-all cursor-pointer">
                                        Shell 1.500 TL
                                    </button>
                                </div>
                            </div>

                            <!-- CANLI AYRIŞTIRMA ÖNİZLEMESİ (Çoklu İşlem Kartları) -->
                            @if (!empty($parsedTransactions) && count($parsedTransactions) > 1)
                                <div class="p-3 sm:p-4 rounded-xl sm:rounded-2xl bg-gradient-to-br from-indigo-50/90 via-sky-50/50 to-white border border-indigo-100 shadow-sm space-y-2.5 sm:space-y-3 animate-fade-in">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs font-black text-indigo-950 flex items-center gap-1">
                                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/></svg>
                                            <span>AI: <strong>{{ count($parsedTransactions) }} Ayrı İşlem</strong> Bulundu</span>
                                        </span>
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-indigo-600 text-white shadow-2xs">
                                            Çoklu
                                        </span>
                                    </div>

                                    <div class="space-y-2">
                                        @foreach ($parsedTransactions as $idx => $item)
                                            <div class="p-2.5 sm:p-3 bg-white rounded-xl border border-slate-200/80 hover:border-indigo-300 flex flex-col sm:flex-row sm:items-center justify-between gap-2 sm:gap-3 shadow-2xs transition-all">
                                                <div class="flex items-start sm:items-center gap-2.5">
                                                    <span class="w-8 h-8 rounded-lg flex items-center justify-center text-base shrink-0 {{ $item['type'] === 'income' ? 'bg-emerald-100 text-emerald-700 border border-emerald-200' : 'bg-rose-100 text-rose-700 border border-rose-200' }}">
                                                        <span class="w-2.5 h-2.5 rounded-full {{ $item['type'] === 'income' ? 'bg-emerald-600' : 'bg-rose-600' }}"></span>
                                                    </span>
                                                    <div>
                                                        <div class="flex items-center gap-1.5 flex-wrap">
                                                            <span class="text-xs font-black text-slate-900">{{ $item['title'] }}</span>
                                                            <span class="px-1.5 py-0.2 rounded text-[9px] font-extrabold {{ $item['type'] === 'income' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/60' : 'bg-rose-50 text-rose-700 border border-rose-200/60' }}">
                                                                {{ $item['type'] === 'income' ? 'Gelir' : 'Gider' }}
                                                            </span>
                                                        </div>
                                                        <div class="text-[10px] sm:text-[11px] text-slate-500 flex items-center gap-1.5 mt-0.5 font-medium">
                                                            <span>{{ $item['category_name'] ?: 'Genel' }}</span>
                                                            @if ($item['bank_name'])
                                                                <span>• {{ $item['bank_name'] }}</span>
                                                            @endif
                                                            <span>• {{ ($item['payment_method'] ?? 'cash') === 'credit_card' ? 'Kart' : 'Nakit' }}</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="flex items-center justify-between sm:justify-end gap-2 shrink-0 pt-1.5 sm:pt-0 border-t sm:border-t-0 border-slate-100">
                                                    <span class="text-xs sm:text-sm font-black font-mono {{ $item['type'] === 'income' ? 'text-emerald-600' : 'text-slate-900' }}">
                                                        {{ $item['type'] === 'income' ? '+' : '-' }}₺{{ number_format($item['amount'], 2, ',', '.') }}
                                                    </span>
                                                    <button type="button" wire:click="saveSingleTransaction({{ $idx }})" class="px-2.5 py-1 bg-slate-100 hover:bg-indigo-600 hover:text-white text-slate-700 font-bold text-xs rounded-lg transition-colors cursor-pointer">
                                                        Kaydet
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="pt-2 flex flex-col sm:flex-row items-center justify-between gap-2 border-t border-indigo-100/60">
                                        <span class="text-[10px] sm:text-[11px] text-slate-500 hidden sm:block">Tümünü tek hamlede kaydedebilirsiniz</span>
                                        <button type="button" wire:click="saveAllTransactions" class="w-full sm:w-auto px-4 py-2.5 bg-gradient-to-r from-indigo-600 to-sky-600 hover:from-indigo-700 hover:to-sky-700 active:scale-95 text-white font-black text-xs rounded-xl shadow-md transition-all flex items-center justify-center gap-2 cursor-pointer">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                            <span>Tümünü Birden Kaydet ({{ count($parsedTransactions) }} İşlem)</span>
                                        </button>
                                    </div>
                                </div>

                            <!-- CANLI AYRIŞTIRMA ÖNİZLEMESİ (Tekil İşlem Kartı) -->
                            @elseif ($parsedData && $parsedData['amount'] > 0)
                                <div class="p-3 sm:p-4 rounded-xl sm:rounded-2xl bg-gradient-to-br from-indigo-50/90 via-sky-50/40 to-white border border-indigo-100 shadow-sm space-y-2.5 sm:space-y-3 animate-fade-in">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs font-black text-indigo-950 flex items-center gap-1">
                                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/></svg>
                                            <span class="truncate max-w-[200px] sm:max-w-none">AI: <strong>{{ $parsedData['title'] }}</strong></span>
                                        </span>
                                        <span class="px-2 py-0.5 rounded-full text-[9px] sm:text-[10px] font-black uppercase tracking-wider shrink-0 {{ $parsedData['type'] === 'income' ? 'bg-emerald-100 text-emerald-800' : ($parsedData['type'] === 'debt' ? 'bg-blue-100 text-blue-800' : ($parsedData['type'] === 'card' ? 'bg-amber-100 text-amber-800' : 'bg-rose-100 text-rose-800')) }}">
                                            {{ $parsedData['type'] === 'income' ? 'Gelir' : ($parsedData['type'] === 'debt' ? 'Borç' : ($parsedData['type'] === 'card' ? 'Kart' : 'Gider')) }}
                                        </span>
                                    </div>

                                    <div class="grid grid-cols-2 sm:grid-cols-5 gap-1.5 sm:gap-2 text-xs">
                                        <div class="p-2 sm:p-2.5 bg-white rounded-lg sm:rounded-xl border border-slate-200/80 shadow-2xs">
                                            <span class="text-[9px] sm:text-[10px] text-slate-400 font-bold block uppercase">TUTAR</span>
                                            <span class="text-xs sm:text-sm font-black font-mono text-slate-900">₺{{ number_format($parsedData['amount'], 2, ',', '.') }}</span>
                                        </div>
                                        <div class="p-2 sm:p-2.5 bg-white rounded-lg sm:rounded-xl border border-slate-200/80 shadow-2xs">
                                            <span class="text-[9px] sm:text-[10px] text-slate-400 font-bold block uppercase">KATEGORİ</span>
                                            <span class="text-[11px] sm:text-xs font-bold text-slate-800 truncate block">{{ $parsedData['category_name'] ?: 'Genel' }}</span>
                                        </div>
                                        <div class="p-2 sm:p-2.5 bg-white rounded-lg sm:rounded-xl border border-slate-200/80 shadow-2xs">
                                            <span class="text-[9px] sm:text-[10px] text-slate-400 font-bold block uppercase">BANKA</span>
                                            <span class="text-[11px] sm:text-xs font-bold text-slate-800 truncate block">{{ $parsedData['bank_name'] ?: 'Belirtilmedi' }}</span>
                                        </div>
                                        <div class="p-2 sm:p-2.5 bg-white rounded-lg sm:rounded-xl border border-slate-200/80 shadow-2xs">
                                            <span class="text-[9px] sm:text-[10px] text-slate-400 font-bold block uppercase">KANAL</span>
                                            <span class="text-[11px] sm:text-xs font-bold text-slate-800 truncate block">{{ ($parsedData['payment_method'] ?? 'cash') === 'credit_card' ? 'Kart' : (($parsedData['payment_method'] ?? 'cash') === 'bank_transfer' ? 'Hesap' : 'Nakit') }}</span>
                                        </div>
                                        <div class="p-2 sm:p-2.5 bg-white rounded-lg sm:rounded-xl border border-slate-200/80 shadow-2xs col-span-2 sm:col-span-1">
                                            <span class="text-[9px] sm:text-[10px] text-slate-400 font-bold block uppercase">TARİH</span>
                                            <span class="text-[11px] sm:text-xs font-bold text-slate-800 block">{{ \Carbon\Carbon::parse($parsedData['date'])->format('d.m.Y') }}</span>
                                        </div>
                                    </div>

                                    <div class="pt-1.5 flex flex-col sm:flex-row items-center justify-between gap-2 border-t border-indigo-100/60">
                                        <span class="text-[10px] sm:text-[11px] text-slate-500 hidden sm:block">Enter'a basarak da kaydedebilirsiniz ⏎</span>
                                        <button wire:click="saveParsedTransaction" class="w-full sm:w-auto px-4 py-2.5 bg-gradient-to-r from-indigo-600 to-sky-600 hover:from-indigo-700 hover:to-sky-700 active:scale-95 text-white font-black text-xs rounded-xl shadow-md transition-all flex items-center justify-center gap-2 cursor-pointer">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                            <span>Doğrudan Veritabanına Kaydet</span>
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>

                    <!-- ========================================== -->
                    <!-- SEKME 2: HIZLI HARCAMA / GELİR FORMU       -->
                    <!-- ========================================== -->
                    @elseif ($activeTab === 'expense')
                        <div class="space-y-3.5 sm:space-y-4">
                            <!-- Tür Seçimi (Gider vs Gelir) -->
                            <div class="flex items-center justify-between gap-2">
                                <div class="inline-flex rounded-xl bg-slate-100 p-1 border border-slate-200 text-xs font-bold w-full sm:w-auto">
                                    <button type="button" wire:click="$set('cashflowType', 'expense')" class="flex-1 sm:flex-initial px-3 sm:px-4 py-1.5 rounded-lg transition-all cursor-pointer {{ $cashflowType === 'expense' ? 'bg-rose-600 text-white shadow-sm font-black' : 'text-slate-600 hover:text-slate-900' }}">
                                        Gider
                                    </button>
                                    <button type="button" wire:click="$set('cashflowType', 'income')" class="flex-1 sm:flex-initial px-3 sm:px-4 py-1.5 rounded-lg transition-all cursor-pointer {{ $cashflowType === 'income' ? 'bg-emerald-600 text-white shadow-sm font-black' : 'text-slate-600 hover:text-slate-900' }}">
                                        Gelir
                                    </button>
                                </div>

                                <span class="hidden sm:inline text-xs font-bold text-slate-400">Tek Tık Şablonlar:</span>
                            </div>

                            <!-- 6 Hızlı Şablon Butonu -->
                            <div class="grid grid-cols-3 sm:grid-cols-6 gap-1.5 sm:gap-2 text-xs">
                                <button type="button" wire:click="applyPreset('coffee')" class="p-2 sm:p-2.5 bg-slate-50 hover:bg-indigo-50 hover:border-indigo-300 border border-slate-200 rounded-xl text-center font-bold text-slate-700 transition-all cursor-pointer">
                                    <span class="block text-[10px]">Kahve ₺150</span>
                                </button>
                                <button type="button" wire:click="applyPreset('market')" class="p-2 sm:p-2.5 bg-slate-50 hover:bg-indigo-50 hover:border-indigo-300 border border-slate-200 rounded-xl text-center font-bold text-slate-700 transition-all cursor-pointer">
                                    <span class="block text-[10px]">Market ₺750</span>
                                </button>
                                <button type="button" wire:click="applyPreset('fuel')" class="p-2 sm:p-2.5 bg-slate-50 hover:bg-indigo-50 hover:border-indigo-300 border border-slate-200 rounded-xl text-center font-bold text-slate-700 transition-all cursor-pointer">
                                    <span class="block text-[10px]">Yakıt ₺1.250</span>
                                </button>
                                <button type="button" wire:click="applyPreset('bill')" class="p-2 sm:p-2.5 bg-slate-50 hover:bg-indigo-50 hover:border-indigo-300 border border-slate-200 rounded-xl text-center font-bold text-slate-700 transition-all cursor-pointer">
                                    <span class="block text-[10px]">Fatura ₺450</span>
                                </button>
                                <button type="button" wire:click="applyPreset('rent')" class="p-2 sm:p-2.5 bg-slate-50 hover:bg-indigo-50 hover:border-indigo-300 border border-slate-200 rounded-xl text-center font-bold text-slate-700 transition-all cursor-pointer">
                                    <span class="block text-[10px]">Kira ₺15k</span>
                                </button>
                                <button type="button" wire:click="applyPreset('salary')" class="p-2 sm:p-2.5 bg-emerald-50 hover:bg-emerald-100 hover:border-emerald-300 border border-emerald-200 rounded-xl text-center font-bold text-emerald-800 transition-all cursor-pointer">
                                    <span class="block text-[10px]">Maaş ₺45k</span>
                                </button>
                            </div>

                            <!-- Tutar ve Hızlı Para Butonları -->
                            <div class="p-3 sm:p-3.5 bg-slate-50 rounded-xl sm:rounded-2xl border border-slate-200/80 space-y-2">
                                <label class="block text-xs font-bold text-slate-700">İşlem Tutarı (TL)</label>
                                <div class="relative">
                                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 font-bold text-base">₺</span>
                                    <input type="number" step="10" wire:model="amount" class="w-full text-lg sm:text-xl font-black font-mono pl-8 rounded-xl border-slate-300 text-slate-900 focus:ring-indigo-500 focus:border-indigo-500 shadow-2xs" placeholder="0.00">
                                </div>
                                
                                <div class="flex items-center gap-1.5 pt-1 overflow-x-auto no-scrollbar text-xs font-bold">
                                    <span class="text-[10px] text-slate-400 font-semibold uppercase shrink-0">HIZLI:</span>
                                    <button type="button" wire:click="addQuickAmount(50)" class="px-2 sm:px-2.5 py-1 bg-white hover:bg-indigo-50 hover:text-indigo-600 border border-slate-200 rounded-lg text-slate-700 text-xs transition-all cursor-pointer shrink-0">+₺50</button>
                                    <button type="button" wire:click="addQuickAmount(100)" class="px-2 sm:px-2.5 py-1 bg-white hover:bg-indigo-50 hover:text-indigo-600 border border-slate-200 rounded-lg text-slate-700 text-xs transition-all cursor-pointer shrink-0">+₺100</button>
                                    <button type="button" wire:click="addQuickAmount(250)" class="px-2 sm:px-2.5 py-1 bg-white hover:bg-indigo-50 hover:text-indigo-600 border border-slate-200 rounded-lg text-slate-700 text-xs transition-all cursor-pointer shrink-0">+₺250</button>
                                    <button type="button" wire:click="addQuickAmount(500)" class="px-2 sm:px-2.5 py-1 bg-white hover:bg-indigo-50 hover:text-indigo-600 border border-slate-200 rounded-lg text-slate-700 text-xs transition-all cursor-pointer shrink-0">+₺500</button>
                                    <button type="button" wire:click="addQuickAmount(1000)" class="px-2 sm:px-2.5 py-1 bg-white hover:bg-indigo-50 hover:text-indigo-600 border border-slate-200 rounded-lg text-slate-700 text-xs transition-all cursor-pointer shrink-0">+₺1.000</button>
                                </div>
                            </div>

                            <!-- Başlık & Kategori & Tarih -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 sm:gap-3">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Açıklama / Başlık</label>
                                    <input type="text" wire:model="title" class="w-full rounded-xl border-slate-300 text-xs font-medium focus:ring-indigo-500 focus:border-indigo-500 shadow-2xs" placeholder="Örn: Market harcaması">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Kategori</label>
                                    <select wire:model="category_id" class="w-full rounded-xl border-slate-300 text-xs font-medium focus:ring-indigo-500 focus:border-indigo-500 shadow-2xs">
                                        <option value="">Kategori Seçin</option>
                                        @foreach ($categories as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-2.5 sm:gap-3 pt-2">
                                <div class="w-full sm:w-1/2">
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Tarih</label>
                                    <input type="date" wire:model="expense_date" class="w-full rounded-xl border-slate-300 text-xs font-medium focus:ring-indigo-500 focus:border-indigo-500 shadow-2xs">
                                </div>

                                <div class="w-full sm:w-1/2 sm:pt-5">
                                    <button type="button" wire:click="saveManualCashflow" class="w-full px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-sky-600 hover:from-indigo-700 hover:to-sky-700 text-white font-black text-xs rounded-xl shadow-md transition-all active:scale-95 cursor-pointer">
                                        Kaydet →
                                    </button>
                                </div>
                            </div>
                        </div>

                    <!-- ========================================== -->
                    <!-- SEKME 3: HIZLI BORÇ / KART / KREDİ FORMU   -->
                    <!-- ========================================== -->
                    @elseif ($activeTab === 'debt')
                        <div class="space-y-3.5 sm:space-y-4">
                            <!-- Tür Seçimi -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Kayıt Türü</label>
                                <div class="grid grid-cols-3 gap-1.5 sm:gap-2 text-xs font-bold">
                                    <button type="button" wire:click="$set('debtType', 'credit_card')" class="p-2 sm:p-2.5 rounded-xl border text-center transition-all cursor-pointer {{ $debtType === 'credit_card' ? 'border-amber-500 bg-amber-50 text-amber-900 ring-2 ring-amber-400/40 font-black' : 'border-slate-200 text-slate-600 hover:bg-slate-50' }}">
                                        Kart
                                    </button>
                                    <button type="button" wire:click="$set('debtType', 'loan')" class="p-2 sm:p-2.5 rounded-xl border text-center transition-all cursor-pointer {{ $debtType === 'loan' ? 'border-blue-500 bg-blue-50 text-blue-900 ring-2 ring-blue-400/40 font-black' : 'border-slate-200 text-slate-600 hover:bg-slate-50' }}">
                                        Kredi
                                    </button>
                                    <button type="button" wire:click="$set('debtType', 'kmh')" class="p-2 sm:p-2.5 rounded-xl border text-center transition-all cursor-pointer {{ $debtType === 'kmh' ? 'border-rose-500 bg-rose-50 text-rose-900 ring-2 ring-rose-400/40 font-black' : 'border-slate-200 text-slate-600 hover:bg-slate-50' }}">
                                        KMH
                                    </button>
                                </div>
                            </div>

                            <!-- Banka Seçici -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">İlgili Banka</label>
                                <select wire:model="bank_id" class="w-full rounded-xl border-slate-300 text-xs font-medium focus:ring-indigo-500 focus:border-indigo-500 shadow-2xs">
                                    <option value="">Banka Seçiniz</option>
                                    @foreach ($banks as $b)
                                        <option value="{{ $b->id }}">{{ $b->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Başlık & Tutar -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 sm:gap-3">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Borç / Kart Adı</label>
                                    <input type="text" wire:model="debtTitle" class="w-full rounded-xl border-slate-300 text-xs font-medium focus:ring-indigo-500 focus:border-indigo-500 shadow-2xs" placeholder="Örn: Garanti Bonus / Kredi">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Toplam Borç / Limit (TL)</label>
                                    <input type="number" step="100" wire:model="debtAmount" class="w-full rounded-xl border-slate-300 text-xs font-black font-mono text-slate-900 focus:ring-indigo-500 focus:border-indigo-500 shadow-2xs" placeholder="50000">
                                </div>
                            </div>

                            <!-- Faiz Oranı & Taksit Tutarı -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 sm:gap-3">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Aylık Faiz Oranı (%)</label>
                                    <input type="number" step="0.01" wire:model="interestRate" class="w-full rounded-xl border-slate-300 text-xs font-medium focus:ring-indigo-500 focus:border-indigo-500 shadow-2xs" placeholder="4.25">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Aylık Taksit / Asgari (TL)</label>
                                    <input type="number" step="100" wire:model="installmentAmount" class="w-full rounded-xl border-slate-300 text-xs font-medium focus:ring-indigo-500 focus:border-indigo-500 shadow-2xs" placeholder="4500">
                                </div>
                            </div>

                            <div class="flex justify-end pt-2">
                                <button type="button" wire:click="saveManualDebt" class="w-full sm:w-auto px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-sky-600 hover:from-indigo-700 hover:to-sky-700 text-white font-black text-xs rounded-xl shadow-md transition-all active:scale-95 cursor-pointer">
                                    Borcu Kaydet →
                                </button>
                            </div>
                        </div>

                    <!-- ========================================== -->
                    <!-- SEKME 4: TOPLU EKSTRE YAPIŞTIR             -->
                    <!-- ========================================== -->
                    @elseif ($activeTab === 'bulk')
                        <div class="space-y-3.5 sm:space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">
                                    Banka mobil şubesinden kopyaladığınız satırları yapıştırın:
                                </label>
                                <textarea wire:model="bulkText" 
                                          rows="5" 
                                          placeholder="18.08.2026 Migros Market 650 TL&#10;17.08.2026 Shell Benzin 1200 TL&#10;16.08.2026 Netflix Abonelik 229 TL" 
                                          class="w-full rounded-xl sm:rounded-2xl border-slate-300 font-mono text-xs p-3 focus:ring-indigo-500 focus:border-indigo-500 shadow-2xs placeholder:text-slate-400"></textarea>
                            </div>

                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                                <span class="text-[10px] sm:text-[11px] text-slate-500">Her satır otomatik NLP ile ayrıştırılır</span>
                                <button type="button" wire:click="parseBulk" class="w-full sm:w-auto px-4 py-2 bg-indigo-50 text-indigo-700 hover:bg-indigo-600 hover:text-white font-black text-xs rounded-xl border border-indigo-200 transition-all cursor-pointer text-center flex items-center justify-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                                    <span>Satırları Ayrıştır</span>
                                </button>
                            </div>

                            <!-- Ayrıştırılan Satırlar Tablosu -->
                            @if (count($bulkParsedList) > 0)
                                <div class="p-3 sm:p-3.5 bg-slate-50 rounded-xl sm:rounded-2xl border border-slate-200/80 space-y-2.5 sm:space-y-3 animate-fade-in">
                                    <div class="flex items-center justify-between text-xs font-black text-slate-900">
                                        <span>Ayrıştırılan {{ count($bulkParsedList) }} İşlem:</span>
                                        <span class="text-indigo-600 font-mono">Toplam: ₺{{ number_format(collect($bulkParsedList)->sum('amount'), 2, ',', '.') }}</span>
                                    </div>

                                    <div class="max-h-48 overflow-y-auto divide-y divide-slate-200 text-xs">
                                        @foreach ($bulkParsedList as $idx => $item)
                                            <div class="py-2 flex items-center justify-between">
                                                <div>
                                                    <span class="font-bold text-slate-900 block">{{ $item['title'] }}</span>
                                                    <span class="text-[10px] text-slate-500">{{ \Carbon\Carbon::parse($item['date'])->format('d.m.Y') }} · {{ $item['category_name'] ?: 'Genel' }}</span>
                                                </div>
                                                <span class="font-black font-mono text-rose-600">₺{{ number_format($item['amount'], 2, ',', '.') }}</span>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="pt-2 flex justify-end">
                                        <button type="button" wire:click="saveAllBulk" class="w-full sm:w-auto px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs rounded-xl shadow-md transition-all active:scale-95 cursor-pointer flex items-center justify-center gap-1.5">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                            <span>Tümünü Kaydet ({{ count($bulkParsedList) }} Kayıt)</span>
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif

                </div>
            </div>
        </div>
    @endif
</div>
