<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <!-- Progress Indicator -->
    <div class="mb-8">
        <div class="flex items-center justify-between text-xs sm:text-sm font-medium text-gray-500">
            <span class="{{ $step >= 1 ? 'text-indigo-600 font-bold' : '' }}">1. Aylık Gelir</span>
            <span class="{{ $step >= 2 ? 'text-indigo-600 font-bold' : '' }}">2. Banka Seçimi</span>
            <span class="{{ $step >= 3 ? 'text-indigo-600 font-bold' : '' }}">3. Borç Girişi</span>
            <span class="{{ $step >= 4 ? 'text-indigo-600 font-bold' : '' }}">4. Risk Özeti</span>
        </div>
        <div class="w-full bg-gray-200 h-2 rounded-full mt-2 overflow-hidden">
            <div class="bg-indigo-600 h-full transition-all duration-300" style="width: {{ $step * 25 }}%;"></div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6 sm:p-10">
        <!-- STEP 1: AYLIK GELİR -->
        @if ($step === 1)
            <div class="space-y-6">
                <div>
                    <h2 class="text-2xl font-black text-gray-900 tracking-tight">Aylık Düzenli Geliriniz Ne Kadar?</h2>
                    <p class="text-sm text-gray-600 mt-1">Borç ödeme planınızı ve bütçenizi matematiksel olarak optimize edebilmemiz için aylık net elinize geçen ortalama geliri girin.</p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Aylık Net Gelir (TL)</label>
                    <div class="relative rounded-xl shadow-sm">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                            <span class="text-gray-500 sm:text-lg font-bold">₺</span>
                        </div>
                        <input type="number" step="100" wire:model="monthly_income" class="block w-full rounded-xl border-gray-300 pl-10 pr-4 py-3 text-lg font-bold text-gray-900 focus:border-indigo-500 focus:ring-indigo-500" placeholder="65000">
                    </div>
                    @error('monthly_income') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="pt-4 flex justify-end">
                    <button wire:click="nextStep" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-xl shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                        Devam Et: Bankalarımı Seç
                    </button>
                </div>
            </div>
        @endif

        <!-- STEP 2: BANKA SEÇİMİ -->
        @if ($step === 2)
            <div class="space-y-6">
                <div>
                    <h2 class="text-2xl font-black text-gray-900 tracking-tight">Hangi Bankalarda Borcunuz veya Hesabınız Var?</h2>
                    <p class="text-sm text-gray-600 mt-1">Çalıştığınız ve borcunuz bulunan tüm bankaları seçin (Birden fazla seçebilirsiniz).</p>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                    @foreach ($systemBanks as $bank)
                        @php $isSelected = in_array($bank->id, $selected_banks); @endphp
                        <button type="button" wire:click="toggleBank({{ $bank->id }})" class="flex flex-col items-center justify-center p-4 rounded-xl border-2 transition-all {{ $isSelected ? 'border-indigo-600 bg-indigo-50/50 shadow-sm ring-2 ring-indigo-500 ring-offset-1' : 'border-gray-200 hover:border-gray-300 bg-white' }}">
                            <span class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold mb-2 shadow-sm" style="background-color: {{ $bank->color ?? '#6366f1' }}">
                                {{ mb_substr($bank->name, 0, 2) }}
                            </span>
                            <span class="text-xs font-semibold text-gray-800 text-center leading-snug">{{ $bank->name }}</span>
                            @if ($isSelected)
                                <span class="mt-1 inline-flex items-center text-[10px] font-bold text-indigo-700">Seçildi ✓</span>
                            @endif
                        </button>
                    @endforeach
                </div>
                @error('selected_banks') <span class="text-red-500 text-xs block">{{ $message }}</span> @enderror

                <div class="pt-4 flex justify-between">
                    <button wire:click="previousStep" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl">
                        Geri
                    </button>
                    <button wire:click="nextStep" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-xl shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 transition-colors">
                        Devam Et: Borçlarımı Gir
                    </button>
                </div>
            </div>
        @endif

        <!-- STEP 3: HIZLI BORÇ GİRİŞİ -->
        @if ($step === 3)
            <div class="space-y-6">
                <div>
                    <h2 class="text-2xl font-black text-gray-900 tracking-tight">Banka Borç Detaylarınızı Girin</h2>
                    <p class="text-sm text-gray-600 mt-1">Seçtiğiniz her banka için kart, KMH (ek para) veya kredi borçlarınızı hızlıca tanımlayın.</p>
                </div>

                <div class="space-y-6 max-h-[60vh] overflow-y-auto pr-1">
                    @foreach ($selected_banks as $bankId)
                        @php $b = $systemBanks->firstWhere('id', $bankId); @endphp
                        <div class="border border-gray-200 rounded-xl p-5 bg-gray-50/50 space-y-4">
                            <div class="flex items-center gap-2 pb-2 border-b border-gray-200">
                                <span class="w-6 h-6 rounded-full flex items-center justify-center text-white text-xs font-bold" style="background-color: {{ $b->color ?? '#6366f1' }}">
                                    {{ mb_substr($b->name, 0, 1) }}
                                </span>
                                <h3 class="font-bold text-gray-900">{{ $b->name }}</h3>
                            </div>

                            <!-- 1. Kredi Kartı -->
                            <div class="bg-white p-3.5 rounded-lg border border-gray-200 space-y-3">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" wire:model.live="bank_data.{{ $bankId }}.has_card" class="rounded text-indigo-600 focus:ring-indigo-500">
                                    <span class="text-sm font-bold text-gray-800">Kredi Kartı Borcum Var</span>
                                </label>

                                @if (!empty($bank_data[$bankId]['has_card']))
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-2">
                                        <div>
                                            <label class="block text-xs font-semibold text-gray-600 mb-1">Dönem Borcu (TL)</label>
                                            <input type="number" wire:model="bank_data.{{ $bankId }}.card_debt" class="w-full text-sm rounded-lg border-gray-300" placeholder="45000">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-gray-600 mb-1">Asgari Tutar (TL)</label>
                                            <input type="number" wire:model="bank_data.{{ $bankId }}.card_min" class="w-full text-sm rounded-lg border-gray-300" placeholder="18000">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-gray-600 mb-1">Kaç Gündür Gecikmede?</label>
                                            <input type="number" wire:model="bank_data.{{ $bankId }}.card_overdue_days" class="w-full text-sm rounded-lg border-gray-300" placeholder="0">
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- 2. KMH (Ek Para / Eksi Hesap) -->
                            <div class="bg-white p-3.5 rounded-lg border border-gray-200 space-y-3">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" wire:model.live="bank_data.{{ $bankId }}.has_kmh" class="rounded text-indigo-600 focus:ring-indigo-500">
                                    <span class="text-sm font-bold text-gray-800">KMH / Eksi Hesap / Avans Borcum Var</span>
                                </label>

                                @if (!empty($bank_data[$bankId]['has_kmh']))
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
                                        <div>
                                            <label class="block text-xs font-semibold text-gray-600 mb-1">Eksi Bakiye Tutarı (TL)</label>
                                            <input type="number" wire:model="bank_data.{{ $bankId }}.kmh_balance" class="w-full text-sm rounded-lg border-gray-300" placeholder="50000">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-gray-600 mb-1">Toplam KMH Limiti (TL)</label>
                                            <input type="number" wire:model="bank_data.{{ $bankId }}.kmh_limit" class="w-full text-sm rounded-lg border-gray-300" placeholder="50000">
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- 3. Kredi -->
                            <div class="bg-white p-3.5 rounded-lg border border-gray-200 space-y-3">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" wire:model.live="bank_data.{{ $bankId }}.has_loan" class="rounded text-indigo-600 focus:ring-indigo-500">
                                    <span class="text-sm font-bold text-gray-800">İhtiyaç / Taşıt Kredim Var</span>
                                </label>

                                @if (!empty($bank_data[$bankId]['has_loan']))
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
                                        <div>
                                            <label class="block text-xs font-semibold text-gray-600 mb-1">Kalan Ana Borç (TL)</label>
                                            <input type="number" wire:model="bank_data.{{ $bankId }}.loan_remaining" class="w-full text-sm rounded-lg border-gray-300" placeholder="100000">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-gray-600 mb-1">Aylık Taksit Tutarı (TL)</label>
                                            <input type="number" wire:model="bank_data.{{ $bankId }}.loan_installment" class="w-full text-sm rounded-lg border-gray-300" placeholder="6500">
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="pt-4 flex justify-between">
                    <button wire:click="previousStep" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl">
                        Geri
                    </button>
                    <button wire:click="nextStep" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-xl shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 transition-colors">
                        Analizi Oluştur & Risk Durumumu Gör
                    </button>
                </div>
            </div>
        @endif

        <!-- STEP 4: RİSK ÖZETİ VE TAMAMLAMA -->
        @if ($step === 4 && $riskSummary)
            <div class="space-y-6">
                <div>
                    <h2 class="text-2xl font-black text-gray-900 tracking-tight">Finansal Risk Durumunuz Hesaptandı</h2>
                    <p class="text-sm text-gray-600 mt-1">90 günlük yasal takip süresi ve faiz yükünüze göre sistem durumunuzu çıkardı.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="p-4 bg-red-50 border border-red-200 rounded-xl">
                        <span class="text-xs font-bold text-red-600 block">TOPLAM BORÇ YÜKÜ</span>
                        <span class="text-2xl font-black text-red-700">₺{{ number_format($riskSummary['total_remaining'], 2, ',', '.') }}</span>
                    </div>

                    <div class="p-4 bg-amber-50 border border-amber-200 rounded-xl">
                        <span class="text-xs font-bold text-amber-600 block">AYLIK ASGARİ / TAKSİT YÜKÜ</span>
                        <span class="text-2xl font-black text-amber-700">₺{{ number_format($riskSummary['total_monthly_commitment'], 2, ',', '.') }}</span>
                    </div>

                    <div class="p-4 {{ $riskSummary['days_to_legal_minimum'] <= 25 ? 'bg-red-50 border-red-300' : 'bg-blue-50 border-blue-200' }} border rounded-xl">
                        <span class="text-xs font-bold {{ $riskSummary['days_to_legal_minimum'] <= 25 ? 'text-red-700' : 'text-blue-700' }} block">YASAL TAKİBE EN YAKIN BORÇ</span>
                        <span class="text-2xl font-black {{ $riskSummary['days_to_legal_minimum'] <= 25 ? 'text-red-800' : 'text-blue-800' }}">
                            {{ $riskSummary['days_to_legal_minimum'] }} Gün Kaldı
                        </span>
                    </div>
                </div>

                @if ($riskSummary['most_critical_item'])
                    <div class="p-4 bg-red-100/70 border border-red-300 rounded-xl flex items-start gap-3">
                        <div class="p-2 bg-red-200 text-red-800 rounded-lg font-bold text-lg">⚠️</div>
                        <div>
                            <h4 class="font-bold text-red-900 text-sm">En Acil Müdahale Edilmesi Gereken Borcunuz: {{ $riskSummary['most_critical_item']['bank'] }} - {{ $riskSummary['most_critical_item']['title'] }}</h4>
                            <p class="text-xs text-red-800 mt-1">Bu borç {{ $riskSummary['most_critical_item']['days_overdue'] }} gündür gecikmede. 90 günlük yasal takip süresine yalnızca <strong>{{ $riskSummary['most_critical_item']['days_left'] }} gün</strong> kaldı. Bankayla görüşülüp derhal yapılandırma masasına oturulmalıdır.</p>
                        </div>
                    </div>
                @endif

                <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 text-xs text-gray-500 leading-relaxed">
                    ⚖️ <strong>Yasal Bilgilendirme:</strong> Bu platform bir bilgilendirme ve borç yönetim takip aracıdır; 6362 sayılı Kanun kapsamında yatırım veya finansal danışmanlık hizmeti sunmaz.
                </div>

                <div class="pt-4 flex justify-end">
                    <button wire:click="completeOnboarding" class="inline-flex items-center px-8 py-3.5 border border-transparent text-base font-bold rounded-xl shadow-lg text-white bg-indigo-600 hover:bg-indigo-700 transition-all">
                        Kontrol Panelime Git ve Yönetimi Başlat →
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>
