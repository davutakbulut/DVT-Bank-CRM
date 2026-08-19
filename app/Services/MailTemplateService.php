<?php

namespace App\Services;

use App\Models\MailTemplate;
use Illuminate\Support\Facades\Mail;

class MailTemplateService
{
    /**
     * Compile template subject and body by replacing placeholders.
     */
    public function render(string $code, array $placeholders = []): ?array
    {
        $template = MailTemplate::where('code', $code)->where('is_active', true)->first();
        if (!$template) {
            return null;
        }

        $subject = $template->subject;
        $body = $template->body;

        foreach ($placeholders as $key => $value) {
            $subject = str_replace('{' . $key . '}', $value, $subject);
            $body = str_replace('{' . $key . '}', $value, $body);
        }

        return [
            'subject' => $subject,
            'body' => $body,
        ];
    }

    /**
     * Send a test email to the given recipient.
     */
    public function sendTestMail(string $recipientEmail): bool
    {
        $rendered = $this->render('test_mail', [
            'user_email' => $recipientEmail,
            'test_time' => now()->format('d.m.Y H:i:s'),
        ]);

        $subject = $rendered['subject'] ?? 'DVT Bank CRM — Sistem Test E-postası';
        $body = $rendered['body'] ?? '✅ SMTP Mail Testi Başarılı!';

        Mail::html($body, function ($message) use ($recipientEmail, $subject) {
            $message->to($recipientEmail)
                    ->subject($subject);
        });

        return true;
    }
}
