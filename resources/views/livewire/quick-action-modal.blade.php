<div>
    <!-- 1. FLOATING ACTION BUTTON (SABİT HIZLI EKLEME BUTONU) -->
    <div class="fixed bottom-6 right-6 z-40 flex flex-col items-end gap-2 group">
        <!-- İpucu Rozeti -->
        <span class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1 bg-slate-900/90 backdrop-blur-md text-white text-[11px] font-bold rounded-xl shadow-xl border border-indigo-500/30 translate-y-1 opacity-0 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300 pointer-events-none">
            <span>⚡ Tek Cümleyle veya Toplu Ekle</span>
        </span>

        <!-- Ana FAB Butonu -->
        <button wire:click="open" 
                class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl sm:rounded-3xl bg-gradient-to-tr from-indigo-600 via-indigo-500 to-sky-500 text-white shadow-[0_10px_30px_rgba(79,70,229,0.4)] hover:shadow-[0_15px_35px_rgba(79,70,229,0.6)] hover:scale-105 active:scale-95 transition-all flex items-center justify-center relative border-2 border-white/30 group/btn cursor-pointer">
            <span class="text-2xl sm:text-3xl transition-transform duration-300 group-hover/btn:rotate-45">⚡</span>
            <!-- Canlı Titreşim Efekti -->
            <span class="absolute -top-1 -right-1 w-3.5 h-3.5 bg-emerald-400 rounded-full border-2 border-white animate-ping"></span>
            <span class="absolute -top-1 -right-1 w-3.5 h-3.5 bg-emerald-500 rounded-full border-2 border-white"></span>
        </button>
    </div>

    <!-- 2. HIZLI İŞLEM MERKEZİ MODALI -->
    @if ($isOpen)
        <div class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/65 backdrop-blur-md flex items-center justify-center p-3 sm:p-6 animate-fade-in"
             wire:keydown.escape="close">
            <div class="bg-white/95 backdrop-blur-xl rounded-[28px] border border-slate-200/80 shadow-[0_25px_70px_rgba(15,23,42,0.25)] w-full max-w-2xl overflow-hidden flex flex-col max-h-[92vh] transition-all transform animate-scale-up ring-1 ring-black/5"
                 @click.away="$wire.close()">
                
                <!-- Modal Başlığı (Modern Gradient Bar) -->
                <div class="px-6 py-4 bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 text-white flex items-center justify-between border-b border-indigo-900/50 shrink-0">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-indigo-500 to-sky-400 p-0.5 shadow-md flex items-center justify-center">
                            <div class="w-full h-full bg-slate-900 rounded-[14px] flex items-center justify-center text-lg text-indigo-300">
                                ⚡
                            </div>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="text-base sm:text-lg font-black tracking-tight text-white">Hızlı İşlem Merkezi</h3>
                                <span class="px-2 py-0.5 rounded-full bg-indigo-500/20 border border-indigo-400/30 text-[10px] font-extrabold text-indigo-300">
                                    AI & NLP
                                </span>
                            </div>
                            <p class="text-xs text-slate-300">Serbest cümleyle yapay zeka girişi, tek tık şablonlar veya toplu ekstre</p>
                        </div>
                    </div>

                    <button wire:click="close" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-slate-300 hover:text-white flex items-center justify-center text-xs font-black transition-all cursor-pointer">
                        ✕
                    </button>
                </div>

                <!-- Modern Segmented Tab Bar -->
                <div class="px-6 pt-3 pb-1 bg-slate-50 border-b border-slate-200/80 shrink-0">
                    <div class="bg-slate-200/70 p-1 rounded-2xl flex items-center gap-1 overflow-x-auto no-scrollbar shadow-inner text-xs font-bold">
                        <button wire:click="$set('activeTab', 'ai')" 
                                class="flex-1 py-2 px-3 rounded-xl transition-all flex items-center justify-center gap-1.5 whitespace-nowrap cursor-pointer {{ $activeTab === 'ai' ? 'bg-white text-indigo-700 shadow-sm font-black' : 'text-slate-600 hover:text-slate-900 hover:bg-white/40' }}">
                            <span>🤖</span>
                            <span>AI Doğal Dil</span>
                        </button>
                        <button wire:click="$set('activeTab', 'expense')" 
                                class="flex-1 py-2 px-3 rounded-xl transition-all flex items-center justify-center gap-1.5 whitespace-nowrap cursor-pointer {{ $activeTab === 'expense' ? 'bg-white text-indigo-700 shadow-sm font-black' : 'text-slate-600 hover:text-slate-900 hover:bg-white/40' }}">
                            <span>💸</span>
                            <span>Harcama / Gelir</span>
                        </button>
                        <button wire:click="$set('activeTab', 'debt')" 
                                class="flex-1 py-2 px-3 rounded-xl transition-all flex items-center justify-center gap-1.5 whitespace-nowrap cursor-pointer {{ $activeTab === 'debt' ? 'bg-white text-indigo-700 shadow-sm font-black' : 'text-slate-600 hover:text-slate-900 hover:bg-white/40' }}">
                            <span>💳</span>
                            <span>Borç / Kredi</span>
                        </button>
                        <button wire:click="$set('activeTab', 'bulk')" 
                                class="flex-1 py-2 px-3 rounded-xl transition-all flex items-center justify-center gap-1.5 whitespace-nowrap cursor-pointer {{ $activeTab === 'bulk' ? 'bg-white text-indigo-700 shadow-sm font-black' : 'text-slate-600 hover:text-slate-900 hover:bg-white/40' }}">
                            <span>📄</span>
                            <span>Toplu Ekstre</span>
                        </button>
                    </div>
                </div>

                <!-- Modal İçeriği (Kaydırılabilir Alan) -->
                <div class="p-6 overflow-y-auto space-y-5 flex-1 bg-white/50">

                    <!-- Hata & Başarı Bildirimleri -->
                    @if (session()->has('error'))
                        <div class="p-3.5 bg-rose-50 border border-rose-200 text-rose-700 text-xs font-bold rounded-2xl flex items-center gap-2.5 animate-shake">
                            <span class="text-base">⚠️</span>
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif

                    @if (session()->has('success'))
                        <div class="p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold rounded-2xl flex items-center gap-2.5 animate-fade-in">
                            <span class="text-base">✅</span>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    <!-- ========================================== -->
                    <!-- SEKME 1: AI AKILLI METİN GİRİŞİ (NLP)      -->
                    <!-- ========================================== -->
                    @if ($activeTab === 'ai')
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5 flex items-center justify-between">
                                    <span class="flex items-center gap-1.5">
                                        <span>✍️</span>
                                        <span>Yaptığınız işlemi tek bir serbest Türkçe cümleyle yazın:</span>
                                    </span>
                                    <span class="inline-flex items-center gap-1 text-[10px] font-black text-indigo-600 bg-indigo-50 border border-indigo-200/60 px-2 py-0.5 rounded-lg">
                                        <span class="w-1.5 h-1.5 rounded-full bg-indigo-600 animate-pulse"></span>
                                        Canlı NLP Ayrıştırıcı
                                    </span>
                                </label>
                                
                                <div class="relative group/input">
                                    <textarea wire:model.live.debounce.250ms="aiInputText" 
                                              wire:keydown.enter.prevent="saveParsedTransaction"
                                              rows="3" 
                                              placeholder="Örn: Enpara hesabıma 45.000 maaş yattı veya bakkaldan 2 paket sigara aldım 250₺..." 
                                              class="w-full rounded-2xl border-slate-300 text-sm font-medium focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 p-3.5 leading-relaxed shadow-xs transition-all placeholder:text-slate-400"></textarea>
                                    @if ($aiInputText)
                                        <button wire:click="$set('aiInputText', '')" class="absolute top-3 right-3 px-2 py-1 bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-800 text-xs font-bold rounded-lg transition-colors cursor-pointer">
                                            Temizle ✕
                                        </button>
                                    @endif
                                </div>
                            </div>

                            <!-- Örnek Şablon Cümleleri (Tıklanabilir Çipler) -->
                            <div class="space-y-1.5">
                                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Örnek Cümle Şablonları (Dene):</span>
                                <div class="flex items-center gap-1.5 flex-wrap text-xs">
                                    <button type="button" wire:click="$set('aiInputText', 'Enpara Bankası hesabıma 45.000 maaş yattı')" class="px-3 py-1.5 bg-slate-100 hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-200 border border-transparent rounded-xl text-slate-600 font-semibold transition-all cursor-pointer">
                                        💰 Enpara 45.000 Maaş
                                    </button>
                                    <button type="button" wire:click="$set('aiInputText', 'bakkaldan 2 paket sigara aldım 250₺')" class="px-3 py-1.5 bg-slate-100 hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-200 border border-transparent rounded-xl text-slate-600 font-semibold transition-all cursor-pointer">
                                        🚬 Bakkal Sigara 250₺
                                    </button>
                                    <button type="button" wire:click="$set('aiInputText', 'enpara hesabıma 5000₺ yattı garanti kartımdan da su aldım 10₺')" class="px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200/60 rounded-xl font-bold transition-all cursor-pointer">
                                        ⚡ 2'li İşlem Girişi
                                    </button>
                                    <button type="button" wire:click="$set('aiInputText', 'Shell 1500 TL benzin yakıt harcaması Akbank')" class="px-3 py-1.5 bg-slate-100 hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-200 border border-transparent rounded-xl text-slate-600 font-semibold transition-all cursor-pointer">
                                        ⛽ Shell 1.500 TL
                                    </button>
                                </div>
                            </div>

                            <!-- CANLI AYRIŞTIRMA ÖNİZLEMESİ (Çoklu İşlem Kartları) -->
                            @if (!empty($parsedTransactions) && count($parsedTransactions) > 1)
                                <div class="p-4 rounded-2xl bg-gradient-to-br from-indigo-50/90 via-sky-50/50 to-white border border-indigo-100 shadow-sm space-y-3 animate-fade-in">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs font-black text-indigo-950 flex items-center gap-1.5">
                                            <span>✨</span>
                                            <span>AI Tespit Edilen <strong>{{ count($parsedTransactions) }} Ayrı İşlem</strong> Bulundu:</span>
                                        </span>
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-indigo-600 text-white shadow-xs">
                                            ⚡ Çoklu Ayrıştırma
                                        </span>
                                    </div>

                                    <div class="space-y-2">
                                        @foreach ($parsedTransactions as $idx => $item)
                                            <div class="p-3 bg-white rounded-xl border border-slate-200/80 hover:border-indigo-300 flex flex-col sm:flex-row sm:items-center justify-between gap-3 shadow-xs transition-all">
                                                <div class="flex items-start sm:items-center gap-3">
                                                    <span class="w-9 h-9 rounded-xl flex items-center justify-center text-lg shrink-0 {{ $item['type'] === 'income' ? 'bg-emerald-100 text-emerald-700 border border-emerald-200' : 'bg-rose-100 text-rose-700 border border-rose-200' }}">
                                                        {{ $item['type'] === 'income' ? '💰' : '🛒' }}
                                                    </span>
                                                    <div>
                                                        <div class="flex items-center gap-2 flex-wrap">
                                                            <span class="text-xs font-black text-slate-900">{{ $item['title'] }}</span>
                                                            <span class="px-2 py-0.5 rounded-md text-[10px] font-extrabold {{ $item['type'] === 'income' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/60' : 'bg-rose-50 text-rose-700 border border-rose-200/60' }}">
                                                                {{ $item['type'] === 'income' ? 'Gelir' : 'Gider' }}
                                                            </span>
                                                        </div>
                                                        <div class="text-[11px] text-slate-500 flex items-center gap-2 mt-0.5 font-medium">
                                                            <span>🏷️ {{ $item['category_name'] ?: 'Genel' }}</span>
                                                            @if ($item['bank_name'])
                                                                <span>• 🏦 {{ $item['bank_name'] }}</span>
                                                            @endif
                                                            <span>• {{ ($item['payment_method'] ?? 'cash') === 'credit_card' ? '💳 Kart' : '💵 Nakit' }}</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="flex items-center justify-between sm:justify-end gap-3 shrink-0 pt-2 sm:pt-0 border-t sm:border-t-0 border-slate-100">
                                                    <span class="text-sm font-black font-mono {{ $item['type'] === 'income' ? 'text-emerald-600' : 'text-slate-900' }}">
                                                        {{ $item['type'] === 'income' ? '+' : '-' }}₺{{ number_format($item['amount'], 2, ',', '.') }}
                                                    </span>
                                                    <button type="button" wire:click="saveSingleTransaction({{ $idx }})" class="px-3 py-1.5 bg-slate-100 hover:bg-indigo-600 hover:text-white text-slate-700 font-bold text-xs rounded-xl transition-colors cursor-pointer">
                                                        ✓ Kaydet
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="pt-2 flex flex-col sm:flex-row items-center justify-between gap-2 border-t border-indigo-100/60">
                                        <span class="text-[11px] text-slate-500">Tümünü tek hamlede veritabanına ekleyebilirsiniz</span>
                                        <button type="button" wire:click="saveAllTransactions" class="w-full sm:w-auto px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-sky-600 hover:from-indigo-700 hover:to-sky-700 active:scale-95 text-white font-black text-xs rounded-xl shadow-md transition-all flex items-center justify-center gap-2 cursor-pointer">
                                            <span>✓</span>
                                            <span>Tümünü Birden Kaydet ({{ count($parsedTransactions) }} İşlem)</span>
                                        </button>
                                    </div>
                                </div>

                            <!-- CANLI AYRIŞTIRMA ÖNİZLEMESİ (Tekil İşlem Kartı) -->
                            @elseif ($parsedData && $parsedData['amount'] > 0)
                                <div class="p-4 rounded-2xl bg-gradient-to-br from-indigo-50/90 via-sky-50/40 to-white border border-indigo-100 shadow-sm space-y-3 animate-fade-in">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs font-black text-indigo-950 flex items-center gap-1.5">
                                            <span>✨</span>
                                            <span>AI Tespit Edilen İşlem: <strong>{{ $parsedData['title'] }}</strong></span>
                                        </span>
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider {{ $parsedData['type'] === 'income' ? 'bg-emerald-100 text-emerald-800' : ($parsedData['type'] === 'debt' ? 'bg-blue-100 text-blue-800' : ($parsedData['type'] === 'card' ? 'bg-amber-100 text-amber-800' : 'bg-rose-100 text-rose-800')) }}">
                                            {{ $parsedData['type'] === 'income' ? '🟢 Gelir' : ($parsedData['type'] === 'debt' ? '🏦 Kredi Borcu' : ($parsedData['type'] === 'card' ? '💳 Kredi Kartı' : '🔴 Gider / Harcama')) }}
                                        </span>
                                    </div>

                                    <div class="grid grid-cols-2 sm:grid-cols-5 gap-2 text-xs">
                                        <div class="p-2.5 bg-white rounded-xl border border-slate-200/80 shadow-2xs">
                                            <span class="text-[10px] text-slate-400 font-bold block uppercase">TUTAR</span>
                                            <span class="text-sm font-black font-mono text-slate-900">₺{{ number_format($parsedData['amount'], 2, ',', '.') }}</span>
                                        </div>
                                        <div class="p-2.5 bg-white rounded-xl border border-slate-200/80 shadow-2xs">
                                            <span class="text-[10px] text-slate-400 font-bold block uppercase">KATEGORİ</span>
                                            <span class="text-xs font-bold text-slate-800 truncate block">{{ $parsedData['category_name'] ?: 'Genel' }}</span>
                                        </div>
                                        <div class="p-2.5 bg-white rounded-xl border border-slate-200/80 shadow-2xs">
                                            <span class="text-[10px] text-slate-400 font-bold block uppercase">BANKA</span>
                                            <span class="text-xs font-bold text-slate-800 truncate block">{{ $parsedData['bank_name'] ?: 'Belirtilmedi' }}</span>
                                        </div>
                                        <div class="p-2.5 bg-white rounded-xl border border-slate-200/80 shadow-2xs">
                                            <span class="text-[10px] text-slate-400 font-bold block uppercase">ÖDEME KANALI</span>
                                            <span class="text-xs font-bold text-slate-800 block">{{ ($parsedData['payment_method'] ?? 'cash') === 'credit_card' ? '💳 Kredi Kartı' : (($parsedData['payment_method'] ?? 'cash') === 'bank_transfer' ? '🏦 Banka Hesabı' : '💵 Nakit') }}</span>
                                        </div>
                                        <div class="p-2.5 bg-white rounded-xl border border-slate-200/80 shadow-2xs col-span-2 sm:col-span-1">
                                            <span class="text-[10px] text-slate-400 font-bold block uppercase">TARİH</span>
                                            <span class="text-xs font-bold text-slate-800 block">{{ \Carbon\Carbon::parse($parsedData['date'])->format('d.m.Y') }}</span>
                                        </div>
                                    </div>

                                    <div class="pt-2 flex flex-col sm:flex-row items-center justify-between gap-2 border-t border-indigo-100/60">
                                        <span class="text-[11px] text-slate-500">Enter'a basarak da doğrudan kaydedebilirsiniz ⏎</span>
                                        <button wire:click="saveParsedTransaction" class="w-full sm:w-auto px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-sky-600 hover:from-indigo-700 hover:to-sky-700 active:scale-95 text-white font-black text-xs rounded-xl shadow-md transition-all flex items-center justify-center gap-2 cursor-pointer">
                                            <span>✓</span>
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
                        <div class="space-y-4">
                            <!-- Tür Seçimi (Gider vs Gelir) -->
                            <div class="flex items-center justify-between gap-2">
                                <div class="inline-flex rounded-xl bg-slate-100 p-1 border border-slate-200 text-xs font-bold">
                                    <button type="button" wire:click="$set('cashflowType', 'expense')" class="px-4 py-1.5 rounded-lg transition-all cursor-pointer {{ $cashflowType === 'expense' ? 'bg-rose-600 text-white shadow-sm font-black' : 'text-slate-600 hover:text-slate-900' }}">
                                        🔴 Gider / Harcama
                                    </button>
                                    <button type="button" wire:click="$set('cashflowType', 'income')" class="px-4 py-1.5 rounded-lg transition-all cursor-pointer {{ $cashflowType === 'income' ? 'bg-emerald-600 text-white shadow-sm font-black' : 'text-slate-600 hover:text-slate-900' }}">
                                        🟢 Gelir Girişi
                                    </button>
                                </div>

                                <span class="text-xs font-bold text-slate-400">Tek Tık Şablonlar:</span>
                            </div>

                            <!-- 6 Hızlı Şablon Butonu -->
                            <div class="grid grid-cols-3 sm:grid-cols-6 gap-2 text-xs">
                                <button type="button" wire:click="applyPreset('coffee')" class="p-2.5 bg-slate-50 hover:bg-indigo-50 hover:border-indigo-300 border border-slate-200 rounded-xl text-center font-bold text-slate-700 transition-all cursor-pointer">
                                    <span class="block text-base">☕</span>
                                    <span class="text-[10px]">Kahve ₺150</span>
                                </button>
                                <button type="button" wire:click="applyPreset('market')" class="p-2.5 bg-slate-50 hover:bg-indigo-50 hover:border-indigo-300 border border-slate-200 rounded-xl text-center font-bold text-slate-700 transition-all cursor-pointer">
                                    <span class="block text-base">🛒</span>
                                    <span class="text-[10px]">Market ₺750</span>
                                </button>
                                <button type="button" wire:click="applyPreset('fuel')" class="p-2.5 bg-slate-50 hover:bg-indigo-50 hover:border-indigo-300 border border-slate-200 rounded-xl text-center font-bold text-slate-700 transition-all cursor-pointer">
                                    <span class="block text-base">⛽</span>
                                    <span class="text-[10px]">Yakıt ₺1.250</span>
                                </button>
                                <button type="button" wire:click="applyPreset('bill')" class="p-2.5 bg-slate-50 hover:bg-indigo-50 hover:border-indigo-300 border border-slate-200 rounded-xl text-center font-bold text-slate-700 transition-all cursor-pointer">
                                    <span class="block text-base">💡</span>
                                    <span class="text-[10px]">Fatura ₺450</span>
                                </button>
                                <button type="button" wire:click="applyPreset('rent')" class="p-2.5 bg-slate-50 hover:bg-indigo-50 hover:border-indigo-300 border border-slate-200 rounded-xl text-center font-bold text-slate-700 transition-all cursor-pointer">
                                    <span class="block text-base">🏠</span>
                                    <span class="text-[10px]">Kira ₺15k</span>
                                </button>
                                <button type="button" wire:click="applyPreset('salary')" class="p-2.5 bg-emerald-50 hover:bg-emerald-100 hover:border-emerald-300 border border-emerald-200 rounded-xl text-center font-bold text-emerald-800 transition-all cursor-pointer">
                                    <span class="block text-base">💰</span>
                                    <span class="text-[10px]">Maaş ₺45k</span>
                                </button>
                            </div>

                            <!-- Tutar ve Hızlı Para Butonları -->
                            <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-200/80 space-y-2">
                                <label class="block text-xs font-bold text-slate-700">İşlem Tutarı (TL)</label>
                                <div class="relative">
                                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 font-bold text-base">₺</span>
                                    <input type="number" step="10" wire:model="amount" class="w-full text-xl font-black font-mono pl-8 rounded-xl border-slate-300 text-slate-900 focus:ring-indigo-500 focus:border-indigo-500 shadow-xs" placeholder="0.00">
                                </div>
                                
                                <div class="flex items-center gap-1.5 pt-1 overflow-x-auto no-scrollbar text-xs font-bold">
                                    <span class="text-[10px] text-slate-400 font-semibold uppercase">HIZLI EKLE:</span>
                                    <button type="button" wire:click="addQuickAmount(50)" class="px-2.5 py-1 bg-white hover:bg-indigo-50 hover:text-indigo-600 border border-slate-200 rounded-lg text-slate-700 transition-all cursor-pointer">+₺50</button>
                                    <button type="button" wire:click="addQuickAmount(100)" class="px-2.5 py-1 bg-white hover:bg-indigo-50 hover:text-indigo-600 border border-slate-200 rounded-lg text-slate-700 transition-all cursor-pointer">+₺100</button>
                                    <button type="button" wire:click="addQuickAmount(250)" class="px-2.5 py-1 bg-white hover:bg-indigo-50 hover:text-indigo-600 border border-slate-200 rounded-lg text-slate-700 transition-all cursor-pointer">+₺250</button>
                                    <button type="button" wire:click="addQuickAmount(500)" class="px-2.5 py-1 bg-white hover:bg-indigo-50 hover:text-indigo-600 border border-slate-200 rounded-lg text-slate-700 transition-all cursor-pointer">+₺500</button>
                                    <button type="button" wire:click="addQuickAmount(1000)" class="px-2.5 py-1 bg-white hover:bg-indigo-50 hover:text-indigo-600 border border-slate-200 rounded-lg text-slate-700 transition-all cursor-pointer">+₺1.000</button>
                                </div>
                            </div>

                            <!-- Başlık & Kategori & Tarih -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Açıklama / Başlık</label>
                                    <input type="text" wire:model="title" class="w-full rounded-xl border-slate-300 text-xs font-medium focus:ring-indigo-500 focus:border-indigo-500 shadow-xs" placeholder="Örn: Market harcaması">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Kategori</label>
                                    <select wire:model="category_id" class="w-full rounded-xl border-slate-300 text-xs font-medium focus:ring-indigo-500 focus:border-indigo-500 shadow-xs">
                                        <option value="">Kategori Seçin</option>
                                        @foreach ($categories as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->icon }} {{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="flex items-center justify-between gap-3 pt-2">
                                <div class="w-1/2">
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Tarih</label>
                                    <input type="date" wire:model="expense_date" class="w-full rounded-xl border-slate-300 text-xs font-medium focus:ring-indigo-500 focus:border-indigo-500 shadow-xs">
                                </div>

                                <div class="pt-5 w-1/2">
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
                        <div class="space-y-4">
                            <!-- Tür Seçimi -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Kayıt Türü</label>
                                <div class="grid grid-cols-3 gap-2 text-xs font-bold">
                                    <button type="button" wire:click="$set('debtType', 'credit_card')" class="p-2.5 rounded-xl border text-center transition-all cursor-pointer {{ $debtType === 'credit_card' ? 'border-amber-500 bg-amber-50 text-amber-900 ring-2 ring-amber-400/40 font-black' : 'border-slate-200 text-slate-600 hover:bg-slate-50' }}">
                                        💳 Kredi Kartı
                                    </button>
                                    <button type="button" wire:click="$set('debtType', 'loan')" class="p-2.5 rounded-xl border text-center transition-all cursor-pointer {{ $debtType === 'loan' ? 'border-blue-500 bg-blue-50 text-blue-900 ring-2 ring-blue-400/40 font-black' : 'border-slate-200 text-slate-600 hover:bg-slate-50' }}">
                                        🏦 Kredi Borcu
                                    </button>
                                    <button type="button" wire:click="$set('debtType', 'kmh')" class="p-2.5 rounded-xl border text-center transition-all cursor-pointer {{ $debtType === 'kmh' ? 'border-rose-500 bg-rose-50 text-rose-900 ring-2 ring-rose-400/40 font-black' : 'border-slate-200 text-slate-600 hover:bg-slate-50' }}">
                                        ⚡ KMH / Eksi Bakiye
                                    </button>
                                </div>
                            </div>

                            <!-- Banka Seçici -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">İlgili Banka</label>
                                <select wire:model="bank_id" class="w-full rounded-xl border-slate-300 text-xs font-medium focus:ring-indigo-500 focus:border-indigo-500 shadow-xs">
                                    <option value="">Banka Seçiniz</option>
                                    @foreach ($banks as $b)
                                        <option value="{{ $b->id }}">{{ $b->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Başlık & Tutar -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Borç / Kart Adı</label>
                                    <input type="text" wire:model="debtTitle" class="w-full rounded-xl border-slate-300 text-xs font-medium focus:ring-indigo-500 focus:border-indigo-500 shadow-xs" placeholder="Örn: Garanti Bonus / İhtiyaç Kredisi">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Toplam Borç / Limit (TL)</label>
                                    <input type="number" step="100" wire:model="debtAmount" class="w-full rounded-xl border-slate-300 text-xs font-black font-mono text-slate-900 focus:ring-indigo-500 focus:border-indigo-500 shadow-xs" placeholder="50000">
                                </div>
                            </div>

                            <!-- Faiz Oranı & Taksit Tutarı -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Aylık Faiz Oranı (%)</label>
                                    <input type="number" step="0.01" wire:model="interestRate" class="w-full rounded-xl border-slate-300 text-xs font-medium focus:ring-indigo-500 focus:border-indigo-500 shadow-xs" placeholder="4.25">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Aylık Taksit / Asgari (TL)</label>
                                    <input type="number" step="100" wire:model="installmentAmount" class="w-full rounded-xl border-slate-300 text-xs font-medium focus:ring-indigo-500 focus:border-indigo-500 shadow-xs" placeholder="4500">
                                </div>
                            </div>

                            <div class="flex justify-end pt-2">
                                <button type="button" wire:click="saveManualDebt" class="px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-sky-600 hover:from-indigo-700 hover:to-sky-700 text-white font-black text-xs rounded-xl shadow-md transition-all active:scale-95 cursor-pointer">
                                    Borcu Kaydet →
                                </button>
                            </div>
                        </div>

                    <!-- ========================================== -->
                    <!-- SEKME 4: TOPLU EKSTRE YAPIŞTIR             -->
                    <!-- ========================================== -->
                    @elseif ($activeTab === 'bulk')
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">
                                    Banka mobil şubesinden veya PDF ekstreden kopyaladığınız satırları yapıştırın:
                                </label>
                                <textarea wire:model="bulkText" 
                                          rows="5" 
                                          placeholder="18.08.2026 Migros Market 650 TL&#10;17.08.2026 Shell Benzin 1200 TL&#10;16.08.2026 Netflix Abonelik 229 TL" 
                                          class="w-full rounded-2xl border-slate-300 font-mono text-xs p-3.5 focus:ring-indigo-500 focus:border-indigo-500 shadow-xs placeholder:text-slate-400"></textarea>
                            </div>

                            <div class="flex justify-between items-center">
                                <span class="text-[11px] text-slate-500">Her satır akıllı NLP ile otomatik ayrıştırılır</span>
                                <button type="button" wire:click="parseBulk" class="px-4 py-2 bg-indigo-50 text-indigo-700 hover:bg-indigo-600 hover:text-white font-black text-xs rounded-xl border border-indigo-200 transition-all cursor-pointer">
                                    🔍 Satırları Ayrıştır
                                </button>
                            </div>

                            <!-- Ayrıştırılan Satırlar Tablosu -->
                            @if (count($bulkParsedList) > 0)
                                <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-200/80 space-y-3 animate-fade-in">
                                    <div class="flex items-center justify-between text-xs font-black text-slate-900">
                                        <span>Ayrıştırılan {{ count($bulkParsedList) }} İşlem Önizlemesi:</span>
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
                                        <button type="button" wire:click="saveAllBulk" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs rounded-xl shadow-md transition-all active:scale-95 cursor-pointer">
                                            ✓ Tümünü Topluca Veritabanına Aktar ({{ count($bulkParsedList) }} Kayıt)
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
