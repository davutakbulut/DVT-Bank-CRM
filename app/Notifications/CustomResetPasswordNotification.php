<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class CustomResetPasswordNotification extends ResetPassword
{
    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject('DVT Bank CRM — Şifre Sıfırlama Talebi')
            ->greeting('Merhaba ' . ($notifiable->name ?? 'Kullanıcımız') . ',')
            ->line('DVT Bank CRM hesabınız için şifre sıfırlama talebi aldık.')
            ->action('Şifrenizi Sıfırlayın', $url)
            ->line('Bu şifre sıfırlama bağlantısının geçerlilik süresi 60 dakikadır.')
            ->line('Eğer bu talebi siz yapmadıysanız, herhangi bir işlem yapmanıza gerek yoktur. Hesabınız güvendedir.')
            ->salutation('Saygılarımızla, DVT Bank CRM Ekibi');
    }
}
