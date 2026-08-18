<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    public function run(): void
    {
        $banks = [
            ['name' => 'Ziraat Bankası', 'color' => '#E10514', 'is_system' => true],
            ['name' => 'Türkiye İş Bankası', 'color' => '#0C3875', 'is_system' => true],
            ['name' => 'Garanti BBVA', 'color' => '#008542', 'is_system' => true],
            ['name' => 'Yapı Kredi', 'color' => '#0A2972', 'is_system' => true],
            ['name' => 'Akbank', 'color' => '#E30613', 'is_system' => true],
            ['name' => 'Halkbank', 'color' => '#0054A6', 'is_system' => true],
            ['name' => 'VakıfBank', 'color' => '#FFB81C', 'is_system' => true],
            ['name' => 'QNB', 'color' => '#6A1A41', 'is_system' => true],
            ['name' => 'Enpara.com', 'color' => '#5E2750', 'is_system' => true],
            ['name' => 'DenizBank', 'color' => '#005B94', 'is_system' => true],
            ['name' => 'TEB (Türk Ekonomi Bankası)', 'color' => '#008A49', 'is_system' => true],
            ['name' => 'Şekerbank', 'color' => '#009540', 'is_system' => true],
            ['name' => 'Diğer Banka / Kurum', 'color' => '#64748B', 'is_system' => true],
        ];

        foreach ($banks as $bank) {
            Bank::updateOrCreate(
                ['name' => $bank['name'], 'is_system' => true],
                $bank
            );
        }
    }
}
