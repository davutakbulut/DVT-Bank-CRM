<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\User;
use App\Models\Plan;

class PlanDistributionChart extends ChartWidget
{
    protected static ?string $heading = 'Plan Dağılımı';

    protected function getData(): array
    {
        $distribution = User::selectRaw('plan_id, COUNT(*) as cnt')
            ->groupBy('plan_id')
            ->get();
            
        $plans = Plan::all()->keyBy('id');
        
        $labels = [];
        $data = [];
        
        foreach ($distribution as $item) {
            $plan = $plans->get($item->plan_id);
            $labels[] = $plan ? $plan->name : 'Bilinmeyen';
            $data[] = $item->cnt;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Kullanıcı Sayısı',
                    'data' => $data,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
