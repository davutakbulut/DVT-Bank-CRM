<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;
use App\Models\SupportTicket;
use App\Models\ContactMessage;

class StatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Toplam Kullanıcı', User::count()),
            Stat::make('Bugünkü Kayıtlar', User::whereDate('created_at', today())->count()),
            Stat::make('Açık Destek Talepleri', SupportTicket::where('status', 'open')->count()),
            Stat::make('Okunmamış Mesajlar', ContactMessage::where('is_read', false)->count()),
        ];
    }
}
