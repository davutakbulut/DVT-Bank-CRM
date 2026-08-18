<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $proPlan = Plan::where('slug', 'pro')->first();

        // 1. Sistem Super Admin
        $systemAdmin = User::updateOrCreate(
            ['email' => 'superadmin@dvt.portegu.com'],
            [
                'name' => 'DVT Sistem Yöneticisi',
                'password' => Hash::make('SuperAdmin2026!*Secure'),
                'plan_id' => $proPlan?->id ?? 1,
                'status' => 'active',
                'onboarding_completed' => true,
                'email_verified_at' => now(),
            ]
        );
        $systemAdmin->syncRoles(['super_admin', 'admin', 'user']);

        // 2. Davut Akbulut (Kurucu & Super Admin)
        $davut = User::updateOrCreate(
            ['email' => 'dvtakblt@gmail.com'],
            [
                'name' => 'Davut Akbulut',
                'phone' => '+90 537 882 68 58',
                'password' => Hash::make('a'),
                'plan_id' => $proPlan?->id ?? 1,
                'status' => 'active',
                'onboarding_completed' => false,
                'email_verified_at' => now(),
            ]
        );
        $davut->syncRoles(['super_admin', 'admin', 'user']);
    }
}
