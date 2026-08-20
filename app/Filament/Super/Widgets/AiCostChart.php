<?php

namespace App\Filament\Super\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\AiUsageDaily;
use Illuminate\Support\Carbon;

class AiCostChart extends ChartWidget
{
    protected static ?string $heading = 'AI Token Harcama Trendi';

    protected function getData(): array
    {
        $data = AiUsageDaily::where('date', '>=', now()->subDays(14))
            ->orderBy('date')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Token Harcama',
                    'data' => $data->pluck('tokens')->toArray(),
                ],
            ],
            'labels' => $data->pluck('date')->map(fn ($date) => Carbon::parse($date)->format('d.m'))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
