<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Console\Command;

class GenerateDailyAiNotifications extends Command
{
    protected $signature = 'ai:generate-daily-notifications {--user= : Belirli bir kullanıcı ID} {--force : Zorla yeniden üret}';
    protected $description = 'Tüm aktif kullanıcılar için günlük Gemini AI finansal tavsiyesi ve risk bildirimleri üretir';

    public function handle(NotificationService $notificationService): int
    {
        $userId = $this->option('user');
        $force = (bool) $this->option('force');

        $users = $userId ? User::where('id', $userId)->get() : User::all();

        $this->info("{$users->count()} kullanıcı için bildirim üretimi başlatılıyor...");

        $aiCount = 0;
        $riskCount = 0;

        foreach ($users as $user) {
            // 1. Günlük AI Tavsiyesi
            $notif = $notificationService->generateDailyAiNotification($user, $force);
            if ($notif) {
                $aiCount++;
            }

            // 2. 90 Günlük Yasal Takip Uyarıları
            $risks = $notificationService->checkAndCreateRiskAlerts($user);
            $riskCount += count($risks);
        }

        $this->info("✓ Tamamlandı! {$aiCount} AI tavsiyesi ve {$riskCount} risk uyarısı oluşturuldu.");

        return Command::SUCCESS;
    }
}
