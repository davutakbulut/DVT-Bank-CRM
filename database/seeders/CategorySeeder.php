<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Kira & Barınma', 'type' => 'expense', 'icon' => 'home'],
            ['name' => 'Faturalar (Elektrik, Su, Doğalgaz)', 'type' => 'expense', 'icon' => 'bolt'],
            ['name' => 'Market & Gıda', 'type' => 'expense', 'icon' => 'shopping-cart'],
            ['name' => 'Ulaşım & Yakıt', 'type' => 'expense', 'icon' => 'truck'],
            ['name' => 'Sağlık & İlaç', 'type' => 'expense', 'icon' => 'heart'],
            ['name' => 'Eğitim & Çocuk', 'type' => 'expense', 'icon' => 'academic-cap'],
            ['name' => 'Abonelikler & Dijital', 'type' => 'expense', 'icon' => 'globe'],
            ['name' => 'Eğlence & Sosyal', 'type' => 'expense', 'icon' => 'sparkles'],
            ['name' => 'Diğer Giderler', 'type' => 'expense', 'icon' => 'tag'],

            ['name' => 'Aylık Maaş', 'type' => 'income', 'icon' => 'banknotes'],
            ['name' => 'Freelance / Ek Gelir', 'type' => 'income', 'icon' => 'briefcase'],
            ['name' => 'Kira Geliri', 'type' => 'income', 'icon' => 'building-office'],
            ['name' => 'Diğer Gelirler', 'type' => 'income', 'icon' => 'currency-dollar'],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(
                ['name' => $cat['name'], 'user_id' => null],
                $cat
            );
        }
    }
}
