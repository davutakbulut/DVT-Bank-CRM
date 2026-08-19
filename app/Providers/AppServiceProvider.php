<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('files', function () {
            return new \App\Services\WindowsSafeFilesystem;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /*
         * Filament notifications paketi, Livewire::component('notifications', ...)
         * ile kendi toast-bildirim bileşenini kaydediyor. Bu bileşen bizim
         * app/Livewire/Notifications/ altındaki Index ve Dropdown bileşenleriyle
         * çakışarak "MethodNotFoundException: markAllAsRead not found" hatasına
         * neden oluyordu. Biz Filament toast bildirimlerini kullanmıyoruz,
         * bu yüzden burada kendi bildirim bileşenlerimizi explicit olarak
         * kaydediyoruz ve Filament'in 'notifications' kaydını eziyoruz.
         */
        Livewire::component('notifications.index', \App\Livewire\Notifications\Index::class);
        Livewire::component('notifications.dropdown', \App\Livewire\Notifications\Dropdown::class);
        Livewire::component('notifications', \App\Livewire\Notifications\Index::class);

        // Plan Limiti Gate Tanımları
        Gate::define('create-bank', fn (User $user) => $user->canCreateBank());
        Gate::define('create-debt', fn (User $user) => $user->canCreateDebt());
        Gate::define('generate-ai-advice', fn (User $user) => $user->canGenerateAiAdvice());
        Gate::define('access-feature', fn (User $user, string $feature) => $user->hasFeature($feature));

        // Türkçe Şifre Sıfırlama E-postası Şablonu
        \Illuminate\Auth\Notifications\ResetPassword::toMailUsing(function (object $notifiable, string $token) {
            $url = url(route('password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));

            return (new \Illuminate\Notifications\Messages\MailMessage)
                ->subject('DVT Bank CRM — Şifre Sıfırlama Talebi')
                ->greeting('Merhaba ' . ($notifiable->name ?? 'Kullanıcımız') . ',')
                ->line('DVT Bank CRM hesabınız için şifre sıfırlama talebi aldık.')
                ->action('Şifrenizi Sıfırlayın', $url)
                ->line('Bu şifre sıfırlama bağlantısının geçerlilik süresi 60 dakikadır.')
                ->line('Eğer bu talebi siz yapmadıysanız, herhangi bir işlem yapmanıza gerek yoktur. Hesabınız güvendedir.')
                ->salutation('Saygılarımızla, DVT Bank CRM Ekibi');
        });
    }
}
