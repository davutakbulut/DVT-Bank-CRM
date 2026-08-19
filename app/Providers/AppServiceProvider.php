<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
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
    }
}
