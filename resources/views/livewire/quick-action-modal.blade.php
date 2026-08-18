<div>
    <!-- 1. FLOATING ACTION BUTTON (SABİT HIZLI EKLEME BUTONU) -->
    <div class="fixed bottom-6 right-6 z-40 flex flex-col items-end gap-2 group">
        <!-- İpucu Rozeti -->
        <span class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1 bg-slate-900 text-white text-[11px] font-black rounded-xl shadow-xl border border-indigo-500/40 translate-y-1 opacity-0 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300 pointer-events-none">
            <span>⚡ Tek Cümleyle veya Toplu Ekle</span>
        </span>

        <!-- Ana FAB Butonu -->
        <button wire:click="open" 
                class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl sm:rounded-3xl bg-gradient-to-tr from-indigo-600 via-indigo-500 to-sky-500 text-white shadow-2xl hover:shadow-indigo-500/50 hover:scale-105 active:scale-95 transition-all flex items-center justify-center relative border-2 border-white/20 group/btn">
            <span class="text-2xl sm:text-3xl transition-transform group-hover/btn:rotate-45">⚡</span>
            <!-- Canlı Titreşim Efekti -->
            <span class="absolute -top-1 -right-1 w-4 h-4 bg-emerald-400 rounded-full border-2 border-white animate-ping"></span>
            <span class="absolute -top-1 -right-1 w-4 h-4 bg-emerald-500 rounded-full border-2 border-white"></span>
        </button>
    </div>

    <!-- 2. HIZLI İŞLEM MERKEZİ MODALI -->
    @if ($isOpen)
        <div class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/75 backdrop-blur-sm flex items-center justify-center p-3 sm:p-6 animate-fade-in"
             wire:keydown.escape="close">
            <div class="bg-white rounded-3xl border border-gray-100 shadow-2xl w-full max-w-2xl overflow-hidden flex flex-col max-h-[90vh] transition-all transform animate-scale-up"
                 @click.away="$wire.close()">
                
                <!-- Modal Başlığı -->
                <div class="px-6 py-4 bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 text-white flex items-center justify-between border-b border-indigo-800/40 shrink-0">
                    <div class="flex items-center gap-3">
                        <span class="w-10 h-10 rounded-2xl bg-indigo-600/40 border border-indigo-400/40 text-indigo-300 flex items-center justify-center text-xl">
                            ⚡
                        </span>
                        <div>
                            <h3 class="text-base sm:text-lg font-black text-white">Hızlı Veri & İşlem Girişi</h3>
                            <p class="text-xs text-indigo-200">AI akıllı doğal dil, hazır şablonlar veya toplu ekstre yükleme</p>
                        </div>
                    </div>

                    <button wire:click="close" class="w-8 h-8 rounded-xl bg-white/10 hover:bg-white/20 text-slate-300 hover:text-white flex items-center justify-center text-sm font-black transition-colors">
                        ✕
                    </button>
                </div>

                <!-- Sekmeler -->
                <div class="px-6 pt-3 bg-gray-50 border-b border-gray-200 flex items-center gap-2 overflow-x-auto no-scrollbar shrink-0 text-xs font-bold">
                    <button wire:click="$set('activeTab', 'ai')" class="pb-2.5 px-3 border-b-2 transition-all flex items-center gap-1.5 whitespace-nowrap {{ $activeTab === 'ai' ? 'border-indigo-600 text-indigo-600 font-black' : 'border-transparent text-gray-500 hover:text-gray-900' }}">
                        <span>🤖</span>
                        <span>AI Akıllı Metin Girişi</span>
                    </button>
                    <button wire:click="$set('activeTab', 'expense')" class="pb-2.5 px-3 border-b-2 transition-all flex items-center gap-1.5 whitespace-nowrap {{ $activeTab === 'expense' ? 'border-indigo-600 text-indigo-600 font-black' : 'border-transparent text-gray-500 hover:text-gray-900' }}">
                        <span>💸</span>
                        <span>Hızlı Harcama / Gelir</span>
                    </button>
                    <button wire:click="$set('activeTab', 'debt')" class="pb-2.5 px-3 border-b-2 transition-all flex items-center gap-1.5 whitespace-nowrap {{ $activeTab === 'debt' ? 'border-indigo-600 text-indigo-600 font-black' : 'border-transparent text-gray-500 hover:text-gray-900' }}">
                        <span>💳</span>
                        <span>Hızlı Borç / Kart / Kredi</span>
                    </button>
                    <button wire:click="$set('activeTab', 'bulk')" class="pb-2.5 px-3 border-b-2 transition-all flex items-center gap-1.5 whitespace-nowrap {{ $activeTab === 'bulk' ? 'border-indigo-600 text-indigo-600 font-black' : 'border-transparent text-gray-500 hover:text-gray-900' }}">
                        <span>📄</span>
                        <span>Toplu Ekstre Yapıştır</span>
                    </button>
                </div>

                <!-- Modal İçeriği (Kaydırılabilir Alan) -->
                <div class="p-6 overflow-y-auto space-y-5 flex-1">

                    <!-- Bildirim Mesajları -->
                    @if (session()->has('error'))
                        <div class="p-3 bg-red-50 border border-red-200 text-red-700 text-xs font-bold rounded-xl flex items-center gap-2">
                            <span>⚠️</span>
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif

                    <!-- SEKME 1: AI AKILLI METİN GİRİŞİ (NLP) -->
                    @if ($activeTab === 'ai')
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1.5">
                                    Nasıl bir işlem yaptığınızı tek cümleyle yazın:
                                </label>
                                <div class="relative">
                                    <textarea wire:model.live.debounce.300ms="aiInputText" 
                                              rows="3" 
                                              placeholder="Örn: Bugün Migros'tan 650 TL market alışverişi yaptım Garanti kartıyla..." 
                                              class="w-full rounded-2xl border-gray-300 text-sm font-medium focus:ring-indigo-500 focus:border-indigo-500 p-3.5 leading-relaxed shadow-xs"></textarea>
                                    @if ($aiInputText)
                                        <button wire:click="$set('aiInputText', '')" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 text-xs font-black">
                                            Temizle ✕
                                        </button>
                                    @endif
                                </div>
                            </div>

                            <!-- Örnek Şablon Cümleleri -->
                            <div class="flex items-center gap-1.5 flex-wrap text-[11px]">
                                <span class="text-gray-400 font-semibold">Örnekler:</span>
                                <button type="button" wire:click="$set('aiInputText', 'Bugün Migros 850 TL market harcaması Garanti kartı')" class="px-2.5 py-1 bg-gray-100 hover:bg-indigo-50 hover:text-indigo-600 rounded-lg text-gray-600 font-medium transition-colors">
                                    🛒 Migros 850 TL
                                </button>
                                <button type="button" wire:click="$set('aiInputText', 'Shell 1500 TL benzin yakıt harcaması Akbank')" class="px-2.5 py-1 bg-gray-100 hover:bg-indigo-50 hover:text-indigo-600 rounded-lg text-gray-600 font-medium transition-colors">
                                    ⛽ Shell 1.500 TL
                                </button>
                                <button type="button" wire:click="$set('aiInputText', 'İş Bankası hesabıma 45.000 TL maaş yattı')" class="px-2.5 py-1 bg-gray-100 hover:bg-indigo-50 hover:text-indigo-600 rounded-lg text-gray-600 font-medium transition-colors">
                                    💰 Maaş 45.000 TL
                                </button>
                                <button type="button" wire:click="$set('aiInputText', 'Ziraat Bankası 50000 TL ihtiyaç kredisi çektim %3.99 faiz')" class="px-2.5 py-1 bg-gray-100 hover:bg-indigo-50 hover:text-indigo-600 rounded-lg text-gray-600 font-medium transition-colors">
                                    🏦 50.000 TL Kredi
                                </button>
                            </div>

                            <!-- Canlı Ayrıştırma Önizleme Kartı -->
                            @if ($parsedData && $parsedData['amount'] > 0)
                                <div class="p-4 rounded-2xl bg-indigo-50/70 border border-indigo-100 space-y-3 animate-fade-in">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs font-black text-indigo-900 flex items-center gap-1.5">
                                            <span>✨</span>
                                            <span>AI Tespit Edilen İşlem Detayı:</span>
                                        </span>
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider {{ $parsedData['type'] === 'income' ? 'bg-emerald-100 text-emerald-800' : ($parsedData['type'] === 'debt' ? 'bg-blue-100 text-blue-800' : ($parsedData['type'] === 'card' ? 'bg-amber-100 text-amber-800' : 'bg-red-100 text-red-800')) }}">
                                            {{ $parsedData['type'] === 'income' ? '🟢 Gelir' : ($parsedData['type'] === 'debt' ? '🏦 Kredi Borcu' : ($parsedData['type'] === 'card' ? '💳 Kredi Kartı' : '🔴 Gider / Harcama')) }}
                                        </span>
                                    </div>

                                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 text-xs">
                                        <div class="p-2.5 bg-white rounded-xl border border-indigo-100/60">
                                            <span class="text-[10px] text-gray-400 font-bold block uppercase">TUTAR</span>
                                            <span class="text-sm font-black text-gray-900">₺{{ number_format($parsedData['amount'], 2, ',', '.') }}</span>
                                        </div>
                                        <div class="p-2.5 bg-white rounded-xl border border-indigo-100/60">
                                            <span class="text-[10px] text-gray-400 font-bold block uppercase">KATEGORİ</span>
                                            <span class="text-xs font-bold text-gray-800 truncate block">{{ $parsedData['category_name'] ?: 'Genel' }}</span>
                                        </div>
                                        <div class="p-2.5 bg-white rounded-xl border border-indigo-100/60">
                                            <span class="text-[10px] text-gray-400 font-bold block uppercase">BANKA</span>
                                            <span class="text-xs font-bold text-gray-800 truncate block">{{ $parsedData['bank_name'] ?: 'Belirtilmedi' }}</span>
                                        </div>
                                        <div class="p-2.5 bg-white rounded-xl border border-indigo-100/60">
                                            <span class="text-[10px] text-gray-400 font-bold block uppercase">TARİH</span>
                                            <span class="text-xs font-bold text-gray-800 block">{{ \Carbon\Carbon::parse($parsedData['date'])->format('d.m.Y') }}</span>
                                        </div>
                                    </div>

                                    <div class="pt-2 flex justify-end">
                                        <button wire:click="saveParsedTransaction" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white font-black text-xs rounded-xl shadow-md transition-all flex items-center gap-2">
                                            <span>✓</span>
                                            <span>Doğrudan Veritabanına Kaydet</span>
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>

                    <!-- SEKME 2: HIZLI HARCAMA / GELİR FORMU -->
                    @elseif ($activeTab === 'expense')
                        <div class="space-y-4">
                            <!-- Tür Seçimi & Hızlı Şablonlar -->
                            <div class="flex items-center justify-between gap-2">
                                <div class="inline-flex rounded-xl bg-gray-100 p-1 border border-gray-200 text-xs font-bold">
                                    <button type="button" wire:click="$set('cashflowType', 'expense')" class="px-3.5 py-1.5 rounded-lg transition-all {{ $cashflowType === 'expense' ? 'bg-red-600 text-white shadow-xs' : 'text-gray-600' }}">
                                        🔴 Gider
                                    </button>
                                    <button type="button" wire:click="$set('cashflowType', 'income')" class="px-3.5 py-1.5 rounded-lg transition-all {{ $cashflowType === 'income' ? 'bg-emerald-600 text-white shadow-xs' : 'text-gray-600' }}">
                                        🟢 Gelir
                                    </button>
                                </div>

                                <span class="text-xs font-bold text-gray-400">Tek Tık Şablonlar:</span>
                            </div>

                            <!-- 6 Hızlı Şablon Butonu -->
                            <div class="grid grid-cols-3 sm:grid-cols-6 gap-2 text-xs">
                                <button type="button" wire:click="applyPreset('coffee')" class="p-2 bg-gray-50 hover:bg-indigo-50 hover:border-indigo-300 border border-gray-200 rounded-xl text-center font-bold text-gray-700 transition-all">
                                    <span class="block text-base">☕</span>
                                    <span class="text-[10px]">Kahve ₺150</span>
                                </button>
                                <button type="button" wire:click="applyPreset('market')" class="p-2 bg-gray-50 hover:bg-indigo-50 hover:border-indigo-300 border border-gray-200 rounded-xl text-center font-bold text-gray-700 transition-all">
                                    <span class="block text-base">🛒</span>
                                    <span class="text-[10px]">Market ₺750</span>
                                </button>
                                <button type="button" wire:click="applyPreset('fuel')" class="p-2 bg-gray-50 hover:bg-indigo-50 hover:border-indigo-300 border border-gray-200 rounded-xl text-center font-bold text-gray-700 transition-all">
                                    <span class="block text-base">⛽</span>
                                    <span class="text-[10px]">Yakıt ₺1.250</span>
                                </button>
                                <button type="button" wire:click="applyPreset('bill')" class="p-2 bg-gray-50 hover:bg-indigo-50 hover:border-indigo-300 border border-gray-200 rounded-xl text-center font-bold text-gray-700 transition-all">
                                    <span class="block text-base">💡</span>
                                    <span class="text-[10px]">Fatura ₺450</span>
                                </button>
                                <button type="button" wire:click="applyPreset('rent')" class="p-2 bg-gray-50 hover:bg-indigo-50 hover:border-indigo-300 border border-gray-200 rounded-xl text-center font-bold text-gray-700 transition-all">
                                    <span class="block text-base">🏠</span>
                                    <span class="text-[10px]">Kira ₺15k</span>
                                </button>
                                <button type="button" wire:click="applyPreset('salary')" class="p-2 bg-emerald-50 hover:bg-emerald-100 hover:border-emerald-300 border border-emerald-200 rounded-xl text-center font-bold text-emerald-800 transition-all">
                                    <span class="block text-base">💰</span>
                                    <span class="text-[10px]">Maaş ₺45k</span>
                                </button>
                            </div>

                            <!-- Tutar ve Hızlı Para Butonları -->
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">İşlem Tutarı (TL)</label>
                                <input type="number" step="10" wire:model="amount" class="w-full text-lg font-black rounded-xl border-gray-300 text-gray-900 focus:ring-indigo-500 focus:border-indigo-500" placeholder="0.00">
                                
                                <div class="flex items-center gap-1.5 mt-2 overflow-x-auto no-scrollbar text-xs font-bold">
                                    <span class="text-[10px] text-gray-400 font-semibold uppercase">HIZLI EKLE:</span>
                                    <button type="button" wire:click="addQuickAmount(50)" class="px-2.5 py-1 bg-gray-100 hover:bg-gray-200 rounded-lg text-gray-700">+₺50</button>
                                    <button type="button" wire:click="addQuickAmount(100)" class="px-2.5 py-1 bg-gray-100 hover:bg-gray-200 rounded-lg text-gray-700">+₺100</button>
                                    <button type="button" wire:click="addQuickAmount(250)" class="px-2.5 py-1 bg-gray-100 hover:bg-gray-200 rounded-lg text-gray-700">+₺250</button>
                                    <button type="button" wire:click="addQuickAmount(500)" class="px-2.5 py-1 bg-gray-100 hover:bg-gray-200 rounded-lg text-gray-700">+₺500</button>
                                    <button type="button" wire:click="addQuickAmount(1000)" class="px-2.5 py-1 bg-gray-100 hover:bg-gray-200 rounded-lg text-gray-700">+₺1.000</button>
                                </div>
                            </div>

                            <!-- Başlık & Kategori & Tarih -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1">Açıklama / Başlık</label>
                                    <input type="text" wire:model="title" class="w-full rounded-xl border-gray-300 text-xs font-medium focus:ring-indigo-500 focus:border-indigo-500" placeholder="Örn: Market harcaması">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1">Kategori</label>
                                    <select wire:model="category_id" class="w-full rounded-xl border-gray-300 text-xs font-medium focus:ring-indigo-500 focus:border-indigo-500">
                                        <option value="">Kategori Seçin</option>
                                        @foreach ($categories as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->icon }} {{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="flex items-center justify-between gap-3 pt-2">
                                <div class="w-1/2">
                                    <label class="block text-xs font-bold text-gray-700 mb-1">Tarih</label>
                                    <input type="date" wire:model="expense_date" class="w-full rounded-xl border-gray-300 text-xs font-medium focus:ring-indigo-500 focus:border-indigo-500">
                                </div>

                                <div class="pt-5">
                                    <button type="button" wire:click="saveManualCashflow" class="w-full px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-black text-xs rounded-xl shadow-md transition-all active:scale-95">
                                        Kaydet →
                                    </button>
                                </div>
                            </div>
                        </div>

                    <!-- SEKME 3: HIZLI BORÇ / KART / KREDİ FORMU -->
                    @elseif ($activeTab === 'debt')
                        <div class="space-y-4">
                            <!-- Tür Seçimi -->
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">Kayıt Türü</label>
                                <div class="grid grid-cols-3 gap-2 text-xs font-bold">
                                    <button type="button" wire:click="$set('debtType', 'credit_card')" class="p-2.5 rounded-xl border text-center transition-all {{ $debtType === 'credit_card' ? 'border-amber-500 bg-amber-50 text-amber-900 ring-1 ring-amber-400' : 'border-gray-200 text-gray-600' }}">
                                        💳 Kredi Kartı
                                    </button>
                                    <button type="button" wire:click="$set('debtType', 'loan')" class="p-2.5 rounded-xl border text-center transition-all {{ $debtType === 'loan' ? 'border-blue-500 bg-blue-50 text-blue-900 ring-1 ring-blue-400' : 'border-gray-200 text-gray-600' }}">
                                        🏦 Kredi Borcu
                                    </button>
                                    <button type="button" wire:click="$set('debtType', 'kmh')" class="p-2.5 rounded-xl border text-center transition-all {{ $debtType === 'kmh' ? 'border-red-500 bg-red-50 text-red-900 ring-1 ring-red-400' : 'border-gray-200 text-gray-600' }}">
                                        ⚡ KMH / Eksi Bakiye
                                    </button>
                                </div>
                            </div>

                            <!-- Banka Seçici -->
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">İlgili Banka</label>
                                <select wire:model="bank_id" class="w-full rounded-xl border-gray-300 text-xs font-medium focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">Banka Seçiniz</option>
                                    @foreach ($banks as $b)
                                        <option value="{{ $b->id }}">{{ $b->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Başlık & Tutar -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1">Borç / Kart Adı</label>
                                    <input type="text" wire:model="debtTitle" class="w-full rounded-xl border-gray-300 text-xs font-medium" placeholder="Örn: Garanti Bonus / İhtiyaç Kredisi">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1">Toplam Borç / Limit (TL)</label>
                                    <input type="number" step="100" wire:model="debtAmount" class="w-full rounded-xl border-gray-300 text-xs font-black text-gray-900" placeholder="50000">
                                </div>
                            </div>

                            <!-- Faiz Oranı & Taksit Tutarı -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1">Aylık Faiz Oranı (%)</label>
                                    <input type="number" step="0.01" wire:model="interestRate" class="w-full rounded-xl border-gray-300 text-xs font-medium" placeholder="4.25">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1">Aylık Taksit / Asgari (TL)</label>
                                    <input type="number" step="100" wire:model="installmentAmount" class="w-full rounded-xl border-gray-300 text-xs font-medium" placeholder="4500">
                                </div>
                            </div>

                            <div class="flex justify-end pt-2">
                                <button type="button" wire:click="saveManualDebt" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-black text-xs rounded-xl shadow-md transition-all active:scale-95">
                                    Borcu Kaydet →
                                </button>
                            </div>
                        </div>

                    <!-- SEKME 4: TOPLU EKSTRE YAPIŞTIR -->
                    @elseif ($activeTab === 'bulk')
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">
                                    Banka mobil şubesinden kopyaladığınız satırları buraya yapıştırın:
                                </label>
                                <textarea wire:model="bulkText" 
                                          rows="5" 
                                          placeholder="18.08.2026 Migros Market 650 TL&#10;17.08.2026 Shell Benzin 1200 TL&#10;16.08.2026 Netflix Abonelik 229 TL" 
                                          class="w-full rounded-2xl border-gray-300 font-mono text-xs p-3.5 focus:ring-indigo-500 focus:border-indigo-500 shadow-xs"></textarea>
                            </div>

                            <div class="flex justify-between items-center">
                                <span class="text-[11px] text-gray-500">Her satır bir harcama olarak ayrıştırılır</span>
                                <button type="button" wire:click="parseBulk" class="px-4 py-2 bg-indigo-50 text-indigo-700 hover:bg-indigo-600 hover:text-white font-black text-xs rounded-xl border border-indigo-200 transition-all">
                                    🔍 Satırları Ayrıştır
                                </button>
                            </div>

                            <!-- Ayrıştırılan Satırlar Tablosu -->
                            @if (count($bulkParsedList) > 0)
                                <div class="p-3 bg-gray-50 rounded-2xl border border-gray-200 space-y-3 animate-fade-in">
                                    <div class="flex items-center justify-between text-xs font-black text-gray-900">
                                        <span>Ayrıştırılan {{ count($bulkParsedList) }} İşlem Önizlemesi:</span>
                                        <span class="text-indigo-600">Toplam: ₺{{ number_format(collect($bulkParsedList)->sum('amount'), 2, ',', '.') }}</span>
                                    </div>

                                    <div class="max-h-48 overflow-y-auto divide-y divide-gray-200 text-xs">
                                        @foreach ($bulkParsedList as $idx => $item)
                                            <div class="py-2 flex items-center justify-between">
                                                <div>
                                                    <span class="font-bold text-gray-900 block">{{ $item['title'] }}</span>
                                                    <span class="text-[10px] text-gray-500">{{ \Carbon\Carbon::parse($item['date'])->format('d.m.Y') }} · {{ $item['category_name'] ?: 'Genel' }}</span>
                                                </div>
                                                <span class="font-black text-red-600">₺{{ number_format($item['amount'], 2, ',', '.') }}</span>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="pt-2 flex justify-end">
                                        <button type="button" wire:click="saveAllBulk" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs rounded-xl shadow-md transition-all active:scale-95">
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
