<?php

namespace App\Filament\Super\Widgets;

use App\Models\User;
use App\Models\AiUsageDaily;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class SuperStatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Toplam Kullanıcı', User::count()),
            Stat::make('Pro Aboneler', User::whereHas('plan', fn($q) => $q->where('slug','pro'))->count()),
            Stat::make('Bugünkü AI Kullanım', AiUsageDaily::where('date', today())->sum('requests')),
            Stat::make('Hatalı İşler', DB::table('failed_jobs')->count()),
            Stat::make('Toplam Token Harcama (Bugün)', AiUsageDaily::where('date', today())->sum('tokens')),
        ];
    }
}
