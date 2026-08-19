<?php

namespace App\Services;

use App\Models\Debt;
use App\Models\FinancialNotification;
use App\Models\User;
use App\Services\AI\Providers\GeminiProvider;
use App\Services\AI\Providers\GroqProvider;
use App\Services\AI\UserContextBuilder;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    /**
     * Kullanıcı için günlük Gemini AI tavsiye bildirimi üretir.
     */
    public function generateDailyAiNotification(User $user, bool $force = false): ?FinancialNotification
    {
        $today = Carbon::today();

        $contextBuilder = new UserContextBuilder();
        $context = $contextBuilder->build($user);

        $prompt = "Kullanıcının güncel finansal veri tablosu:\n" . json_encode($context, JSON_UNESCAPED_UNICODE) . "\n\n";
        $prompt .= "Kullanıcıya bildirim merkezinde gösterilmek üzere samimi bir dost tavsiyesi, kritik bir gecikme uyarısı veya nokta atışı bir borç kapatma stratejisi üret.\n";
        $prompt .= "SADECE aşağıdaki formatta yanıt ver:\n";
        $prompt .= "BAŞLIK: [En fazla 5-6 kelimelik çarpıcı, emojili Türkçe başlık]\n";
        $prompt .= "MESAJ: [En fazla 2-3 cümlelik, kullanıcının gerçek banka ve rakamlarını kullanan, samimi, yol gösterici dostane tavsiye veya acil uyarı]\n";
        $prompt .= "SEVERITY: [info veya warning veya danger veya success]";

        $systemPrompt = "Sen kullanıcının kişisel yapay zeka finans koçu ve sadık bir dostusun. Kullanıcının canını yakacak faizleri durdurmak, onu 90 günlük yasal takipten korumak ve ona moral verip somut taktikler göstermek için konuşursun. Sayıları standart Türkçe (Örn: 49.000 TL) yaz, yabancı karakter kullanma.";

        $providersToRun = [
            'gemini' => [
                'provider' => new GeminiProvider(),
                'label' => 'Google Gemini',
                'badge' => '🤖 Google Gemini AI',
            ],
            'groq' => [
                'provider' => new GroqProvider(),
                'label' => 'Groq Llama',
                'badge' => '⚡ Groq Llama AI',
            ],
        ];

        $lastNotification = null;

        foreach ($providersToRun as $pKey => $pInfo) {
            /** @var \App\Services\AI\AiProviderInterface $p */
            $p = $pInfo['provider'];

            if (!$p->isAvailable()) {
                continue;
            }

            if (!$force) {
                $exists = FinancialNotification::where('user_id', $user->id)
                    ->where('type', 'ai_advice')
                    ->whereDate('created_at', $today)
                    ->where('data->provider', $pKey)
                    ->exists();

                if ($exists) {
                    continue;
                }
            }

            $resp = $p->complete($systemPrompt, $prompt, 1500);
            if ($resp->status === 'success' && !empty(trim($resp->content))) {
                $title = "💡 {$pInfo['label']} Tavsiyesi";
                $message = "En yüksek faizli borçlarınıza odaklanarak bu ayki faiz yükünüzü hafifletebilirsiniz.";
                $severity = "info";

                $cleanedAi = \App\Helpers\AiFormatter::cleanUnicodeAndGlitches($resp->content);
                if (preg_match('/(?:\*\*|\#\#)?\s*BAŞLIK\s*:\s*(?:\*\*)?\s*(.+)/iu', $cleanedAi, $m)) {
                    $title = trim(str_replace(['*', '#'], '', $m[1]));
                }
                if (preg_match('/(?:\*\*|\#\#)?\s*MESAJ\s*:\s*(?:\*\*)?\s*(.+?)(?=(?:\*\*|\#\#)?\s*SEVERITY|\Z)/isu', $cleanedAi, $m)) {
                    $message = trim($m[1]);
                }
                if (preg_match('/SEVERITY\s*:\s*(?:\*\*)?\s*(info|warning|danger|success)/iu', $cleanedAi, $m)) {
                    $severity = strtolower(trim(str_replace('*', '', $m[1])));
                }

                $lastNotification = FinancialNotification::create([
                    'user_id' => $user->id,
                    'type' => 'ai_advice',
                    'title' => $title,
                    'message' => $message,
                    'action_url' => route('ai.coach', [], false),
                    'severity' => $severity,
                    'data' => [
                        'provider' => $pKey,
                        'provider_label' => $pInfo['label'],
                        'model_badge' => $pInfo['badge'],
                        'context_snapshot' => [
                            'toplam_borc' => $context['toplam_borc'] ?? 0,
                            'aylik_yukumluluk' => $context['bu_ay_yukumluluk'] ?? 0,
                        ],
                    ],
                ]);
            }
        }

        // Eğer hiçbir sağlayıcıdan bildirim oluşturulamadıysa kural tabanlı üret
        if (!$lastNotification) {
            $exists = !$force && FinancialNotification::where('user_id', $user->id)
                ->where('type', 'ai_advice')
                ->whereDate('created_at', $today)
                ->exists();

            if (!$exists) {
                $maxInterest = $context['en_yuksek_faizli'] ?? 'yüksek faizli borcunuz';
                $lastNotification = FinancialNotification::create([
                    'user_id' => $user->id,
                    'type' => 'ai_advice',
                    'title' => "⚡ Faiz Tasarrufu Hamlesi",
                    'message' => "Bugün {$maxInterest} kaleminize asgarinin üzerinde ek ödeme yaparak faiz kartopunu yavaşlatın.",
                    'action_url' => route('ai.coach', [], false),
                    'severity' => "warning",
                    'data' => [
                        'provider' => 'offline_rule',
                        'provider_label' => 'Kural Motoru',
                        'model_badge' => '🛡️ Kural Tabanlı Motor',
                    ],
                ]);
            }
        }

        return $lastNotification;
    }

    /**
     * 90 günlük yasal takip veya yaklaşan ödemeleri tarar ve bildirim üretir.
     */
    public function checkAndCreateRiskAlerts(User $user): array
    {
        $created = [];
        $debts = Debt::where('user_id', $user->id)
            ->where('status', 'active')
            ->with('bank')
            ->get();

        foreach ($debts as $debt) {
            $daysOverdue = (int) $debt->days_overdue;
            $daysToLegal = max(0, 90 - $daysOverdue);
            $bankName = $debt->bank?->name ?? 'Banka';

            // 1. Kritik Yasal Takip Eşiği (Gecikme >= 15 gün veya Takibe <= 75 gün)
            if ($daysOverdue >= 15 || $daysToLegal <= 75) {
                $recentAlert = FinancialNotification::where('user_id', $user->id)
                    ->where('type', 'risk_alert')
                    ->where('data->debt_id', $debt->id)
                    ->whereDate('created_at', '>=', now()->subDays(3))
                    ->first();

                if (!$recentAlert) {
                    $created[] = FinancialNotification::create([
                        'user_id' => $user->id,
                        'type' => 'risk_alert',
                        'title' => "🚨 Yasal Takip Uyarısı: {$bankName}",
                        'message' => "{$debt->title} borcunuz {$daysOverdue} gündür gecikmede. 90 günlük yasal takibe yalnızca {$daysToLegal} gün kaldı!",
                        'action_url' => route('debts.index', [], false),
                        'severity' => 'danger',
                        'data' => [
                            'debt_id' => $debt->id,
                            'bank_name' => $bankName,
                            'days_overdue' => $daysOverdue,
                            'days_to_legal' => $daysToLegal,
                        ],
                    ]);
                }
            }
        }

        return $created;
    }

    /**
     * Nakit hareketi sonrasında akıllı bakiye/likidite bildirimi tetikler.
     */
    public function triggerCashflowAlert(User $user, string $type, float $amount, string $title = ''): ?FinancialNotification
    {
        $amountFmt = number_format($amount, 2, ',', '.');

        if ($type === 'expense' && $amount >= 5000) {
            return FinancialNotification::create([
                'user_id' => $user->id,
                'type' => 'cashflow_alert',
                'title' => "💸 Yüksek Tutar Gider Kaydedildi",
                'message' => "₺{$amountFmt} tutarında '{$title}' gideri işlendi. Borç ödeme bütçenizi korumak için nakit akışınızı gözden geçirin.",
                'action_url' => route('cashflow.index', [], false),
                'severity' => 'warning',
                'data' => ['amount' => $amount, 'title' => $title],
            ]);
        }

        if ($type === 'income') {
            return FinancialNotification::create([
                'user_id' => $user->id,
                'type' => 'cashflow_alert',
                'title' => "🟢 Yeni Gelir Girişi",
                'message' => "₺{$amountFmt} tutarında '{$title}' tahsil edildi. Bu tutarın bir kısmını en yüksek faizli borcunuza ayırabilirsiniz.",
                'action_url' => route('cashflow.index', [], false),
                'severity' => 'success',
                'data' => ['amount' => $amount, 'title' => $title],
            ]);
        }

        return null;
    }

    public function getUnreadCount(User $user): int
    {
        return FinancialNotification::where('user_id', $user->id)->unread()->count();
    }

    public function getRecent(User $user, int $limit = 5): Collection
    {
        return FinancialNotification::where('user_id', $user->id)
            ->latest()
            ->take($limit)
            ->get();
    }

    public function markAllAsRead(User $user): int
    {
        return FinancialNotification::where('user_id', $user->id)
            ->unread()
            ->update(['read_at' => now()]);
    }

    public function markAllAsUnread(User $user): int
    {
        return FinancialNotification::where('user_id', $user->id)
            ->read()
            ->update(['read_at' => null]);
    }

    public function toggleRead(User $user, int $id): ?FinancialNotification
    {
        $notif = FinancialNotification::where('user_id', $user->id)->find($id);
        if ($notif) {
            $notif->toggleRead();
        }
        return $notif;
    }

    public function deleteAll(User $user): int
    {
        return FinancialNotification::where('user_id', $user->id)->delete();
    }
}
