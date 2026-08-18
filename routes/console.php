<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// DVT Bank CRM - Zamanlanmış Görevler (docs/07 Tablosu)
Schedule::command('queue:work database --stop-when-empty --tries=3')->everyMinute();
Schedule::command('dvt:update-risk-counters')->dailyAt('00:30');
Schedule::command('dvt:send-reminders')->everyFifteenMinutes();
Schedule::command('dvt:generate-daily-advice')->dailyAt('07:00');
Schedule::command('dvt:purge-closed-accounts')->weekly();

