<x-filament-panels::page>
    <div class="space-y-6">
        <div class="p-6 bg-white rounded-xl shadow-sm border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Veritabanı Yedekleme</h3>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                Yedek almak için yukarıdaki "Yedek Al" butonunu kullanabilirsiniz.
                Yedekler <code>storage/app/backups/</code> dizinine kaydedilir.
            </p>
            <div class="mt-4 p-4 rounded-lg bg-amber-50 border border-amber-200 dark:bg-amber-900/20 dark:border-amber-700">
                <p class="text-sm font-medium text-amber-800 dark:text-amber-200">
                    ⚠️ Plesk sunucusunda disk izni yoksa, Plesk'in kendi yedekleme aracını kullanın.
                </p>
            </div>
        </div>

        <div class="p-6 bg-white rounded-xl shadow-sm border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Sistem Bilgileri</h3>
            <dl class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div class="p-3 rounded-lg bg-gray-50 dark:bg-gray-700">
                    <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">PHP Versiyonu</dt>
                    <dd class="mt-1 text-sm font-semibold text-gray-900 dark:text-white">{{ PHP_VERSION }}</dd>
                </div>
                <div class="p-3 rounded-lg bg-gray-50 dark:bg-gray-700">
                    <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">Laravel Versiyonu</dt>
                    <dd class="mt-1 text-sm font-semibold text-gray-900 dark:text-white">{{ app()->version() }}</dd>
                </div>
                <div class="p-3 rounded-lg bg-gray-50 dark:bg-gray-700">
                    <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">Veritabanı</dt>
                    <dd class="mt-1 text-sm font-semibold text-gray-900 dark:text-white">{{ config('database.default') }} — {{ config('database.connections.' . config('database.default') . '.database') }}</dd>
                </div>
                <div class="p-3 rounded-lg bg-gray-50 dark:bg-gray-700">
                    <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">Disk Boş Alan</dt>
                    <dd class="mt-1 text-sm font-semibold text-gray-900 dark:text-white">
                        @php
                            $free = disk_free_space(storage_path());
                            $formatted = $free > 1073741824 ? round($free / 1073741824, 2) . ' GB' : round($free / 1048576, 2) . ' MB';
                        @endphp
                        {{ $formatted }}
                    </dd>
                </div>
            </dl>
        </div>
    </div>
</x-filament-panels::page>
