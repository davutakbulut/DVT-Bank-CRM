<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\AI\AiManager;
use Illuminate\Console\Command;

class GenerateDailyAdviceCommand extends Command
{
    protected $signature = 'dvt:generate-daily-advice';
    protected $description = 'Aktif kullanıcılar için günlük finansal koçluk önerilerini üretir';

    public function handle(): int
    {
        $this->info('Günlük AI önerileri üretiliyor...');

        $users = User::where('status', 'active')->where('onboarding_completed', true)->get();
        $aiManager = new AiManager();
        $count = 0;

        foreach ($users as $user) {
            if (!$user->canGenerateAiAdvice()) {
                continue;
            }

            try {
                $aiManager->generateAdviceForUser($user, 'daily');
                $count++;
            } catch (\Throwable $e) {
                $this->error("Kullanıcı #{$user->id} için öneri üretilemedi: " . $e->getMessage());
            }
        }

        $this->info("Toplam {$count} kullanıcı için günlük AI önerisi oluşturuldu.");

        return Command::SUCCESS;
    }
}
