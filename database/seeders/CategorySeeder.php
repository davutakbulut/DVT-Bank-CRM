<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Kira & Barınma', 'type' => 'expense', 'icon' => '🏠'],
            ['name' => 'Faturalar (Elektrik, Su, Doğalgaz)', 'type' => 'expense', 'icon' => '💡'],
            ['name' => 'Market & Gıda', 'type' => 'expense', 'icon' => '🛒'],
            ['name' => 'Ulaşım & Yakıt', 'type' => 'expense', 'icon' => '🚗'],
            ['name' => 'Sağlık & İlaç', 'type' => 'expense', 'icon' => '💊'],
            ['name' => 'Eğitim & Çocuk', 'type' => 'expense', 'icon' => '🎓'],
            ['name' => 'Abonelikler & Dijital', 'type' => 'expense', 'icon' => '🌐'],
            ['name' => 'Eğlence & Sosyal', 'type' => 'expense', 'icon' => '✨'],
            ['name' => 'Diğer Giderler', 'type' => 'expense', 'icon' => '🏷️'],

            ['name' => 'Aylık Maaş', 'type' => 'income', 'icon' => '💰'],
            ['name' => 'Freelance / Ek Gelir', 'type' => 'income', 'icon' => '💼'],
            ['name' => 'Kira Geliri', 'type' => 'income', 'icon' => '🏢'],
            ['name' => 'Diğer Gelirler', 'type' => 'income', 'icon' => '💵'],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(
                ['name' => $cat['name'], 'user_id' => null],
                $cat
            );
        }
    }
}
