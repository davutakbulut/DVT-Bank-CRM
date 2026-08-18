<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Sadece zorunlu sistem şablon ve yapılandırma verilerini yükler.
     * KESİN KURAL: Hiçbir sahte veya demo kullanıcı/borç verisi eklenmez.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            PlanSeeder::class,
            BankSeeder::class,
            CategorySeeder::class,
            SettingsSeeder::class,
            SuperAdminSeeder::class,
        ]);
    }
}
