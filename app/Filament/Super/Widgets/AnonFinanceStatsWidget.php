<?php

namespace App\Filament\Super\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Debt;
use App\Models\User;
use App\Models\PaymentPlan;

class AnonFinanceStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $avgDebt = Debt::withoutGlobalScopes()->where('status', 'active')->avg('remaining');
        $onboardingTotal = User::count();
        $onboardingCompleted = User::where('onboarding_completed', true)->count();
        $onboardingPercentage = $onboardingTotal > 0 ? round(($onboardingCompleted / $onboardingTotal) * 100, 2) : 0;

        return [
            Stat::make('Ortalama Borç', number_format($avgDebt ?? 0, 2, ',', '.') . ' ₺'),
            Stat::make('Toplam Aktif Borç Sayısı', Debt::withoutGlobalScopes()->where('status', 'active')->count()),
            Stat::make('Onboarding Tamamlama', $onboardingPercentage . '%'),
            Stat::make('Aktif Ödeme Planı', PaymentPlan::withoutGlobalScopes()->where('status', 'active')->count()),
        ];
    }
}
