<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-gray-900 tracking-tight">🗓️ Ödeme ve Vade Takvimi</h1>
            <p class="text-sm text-gray-600">Ay bazında yaklaşan ekstre son günleri, kredi vadeleri ve plan ödemeleri</p>
        </div>
        <div class="flex items-center gap-2">
            <button wire:click="previousMonth" class="p-2.5 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 text-gray-700 font-bold text-sm">
                ← Önceki Ay
            </button>
            <span class="px-4 py-2 bg-indigo-50 text-indigo-700 font-black rounded-xl text-sm capitalize">
                {{ $monthTitle }}
            </span>
            <button wire:click="nextMonth" class="p-2.5 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 text-gray-700 font-bold text-sm">
                Sonraki Ay →
            </button>
        </div>
    </div>

    <!-- Bu Ayın Ödemeleri -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse ($debts as $d)
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm space-y-3 relative overflow-hidden">
                <div class="flex items-center justify-between">
                    <span class="px-2.5 py-1 rounded-md text-xs font-bold text-white shadow-sm" style="background-color: {{ $d->bank?->color ?? '#6366f1' }}">
                        {{ $d->bank?->name ?? 'Banka' }}
                    </span>
                    <span class="text-xs font-bold text-gray-500">
                        Vade: {{ \Carbon\Carbon::parse($d->next_due_date)->format('d.m.Y') }}
                    </span>
                </div>

                <div>
                    <h4 class="font-bold text-sm text-gray-900">{{ $d->title }}</h4>
                    <div class="flex items-baseline justify-between mt-2">
                        <span class="text-xs text-gray-500">Aylık Taksit / Asgari:</span>
                        <span class="text-lg font-black text-gray-900">
                            ₺{{ number_format($d->installment_amount ?: ($d->remaining * 0.40), 2, ',', '.') }}
                        </span>
                    </div>
                </div>

                <div class="pt-2 border-t border-gray-100 flex items-center justify-between text-xs">
                    <span class="text-gray-500">Kalan Borç: ₺{{ number_format($d->remaining, 0, ',', '.') }}</span>
                    @if ($d->days_overdue > 0)
                        <span class="text-red-600 font-bold">{{ $d->days_overdue }} Gün Gecikmede</span>
                    @else
                        <span class="text-emerald-600 font-bold">Zamanında</span>
                    @endif
                </div>

                <div class="absolute top-0 left-0 bottom-0 w-1" style="background-color: {{ $d->bank?->color ?? '#6366f1' }}"></div>
            </div>
        @empty
            <div class="col-span-3 bg-white p-12 text-center rounded-2xl text-gray-500 text-sm">
                Bu aya ait planlanmış ödeme kaydı bulunmamaktadır.
            </div>
        @endforelse
    </div>
</div>
