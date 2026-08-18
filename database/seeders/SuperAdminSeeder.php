<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('SUPER_ADMIN_EMAIL', 'superadmin@dvt.portegu.com');
        $name = env('SUPER_ADMIN_NAME', 'DVT Sistem Yöneticisi');
        $proPlan = Plan::where('slug', 'pro')->first();

        $admin = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make('SuperAdmin2026!*Secure'),
                'plan_id' => $proPlan?->id,
                'status' => 'active',
                'onboarding_completed' => true,
                'email_verified_at' => now(),
            ]
        );

        $admin->syncRoles(['super_admin', 'admin', 'user']);
    }
}
