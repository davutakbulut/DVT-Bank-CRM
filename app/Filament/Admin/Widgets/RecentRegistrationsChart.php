<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\User;
use Carbon\Carbon;

class RecentRegistrationsChart extends ChartWidget
{
    protected static ?string $heading = 'Son 7 Günlük Kayıtlar';

    protected function getData(): array
    {
        $days = [];
        $data = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $days[] = Carbon::now()->subDays($i)->format('d.m');
            $data[] = User::whereDate('created_at', $date)->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Kayıt Sayısı',
                    'data' => $data,
                ],
            ],
            'labels' => $days,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
