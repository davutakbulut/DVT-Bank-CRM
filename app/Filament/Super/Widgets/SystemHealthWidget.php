<?php

namespace App\Filament\Super\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;
use App\Models\ImportJob;

class SystemHealthWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $free = disk_free_space(storage_path());
        $formattedDisk = $free > 1073741824 ? round($free / 1073741824, 2) . ' GB' : round($free / 1048576, 2) . ' MB';

        return [
            Stat::make('Hatalı İşler (Failed Jobs)', DB::table('failed_jobs')->count()),
            Stat::make('Bekleyen İşler (Queue)', DB::table('jobs')->count()),
            Stat::make('Son İmport', ImportJob::withoutGlobalScopes()->latest()->first()?->status ?? 'Yok'),
            Stat::make('Disk Kullanımı (Boş)', $formattedDisk),
        ];
    }
}
