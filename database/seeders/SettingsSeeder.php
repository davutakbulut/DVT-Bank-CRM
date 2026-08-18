<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'site.name', 'value' => 'DVT Bank CRM', 'type' => 'string', 'group' => 'general'],
            ['key' => 'site.maintenance', 'value' => '0', 'type' => 'bool', 'group' => 'general'],
            ['key' => 'site.legal_disclaimer', 'value' => 'Bu sistemdeki analiz ve öneriler yalnızca bilgilendirme amaçlıdır; 6362 sayılı Sermaye Piyasası Kanunu kapsamında yatırım veya finansal danışmanlık hizmeti niteliği taşımaz.', 'type' => 'string', 'group' => 'general'],

            ['key' => 'ai.default_provider', 'value' => 'groq', 'type' => 'string', 'group' => 'ai'],
            ['key' => 'ai.groq_model', 'value' => 'llama-3.3-70b-versatile', 'type' => 'string', 'group' => 'ai'],
            ['key' => 'ai.gemini_model', 'value' => 'gemini-1.5-flash', 'type' => 'string', 'group' => 'ai'],
            ['key' => 'ai.openrouter_model', 'value' => 'meta-llama/llama-3.3-70b-instruct:free', 'type' => 'string', 'group' => 'ai'],
            ['key' => 'ai.daily_token_limit', 'value' => '50000', 'type' => 'int', 'group' => 'ai'],
        ];

        foreach ($settings as $s) {
            Setting::updateOrCreate(['key' => $s['key']], $s);
        }
    }
}
