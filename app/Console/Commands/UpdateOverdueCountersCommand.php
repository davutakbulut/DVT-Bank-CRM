<?php

namespace App\Console\Commands;

use App\Models\Debt;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateOverdueCountersCommand extends Command
{
    protected $signature = 'dvt:update-risk-counters';
    protected $description = 'Borçların gecikme gün sayılarını ve yasal takip risk sayaçlarını günceller';

    public function handle(): int
    {
        $this->info('Risk sayaçları güncelleniyor...');

        $debts = Debt::where('status', 'active')->get();
        $updatedCount = 0;

        foreach ($debts as $debt) {
            if ($debt->last_payment_date) {
                $days = (int) Carbon::parse($debt->last_payment_date)->diffInDays(now());
                $debt->days_overdue = $days;
                $debt->saveQuietly();
                $updatedCount++;
            }
        }

        $this->info("Toplam {$updatedCount} borcun risk sayacı güncellendi.");

        return Command::SUCCESS;
    }
}
