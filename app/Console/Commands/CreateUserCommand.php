<?php

namespace App\Console\Commands;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateUserCommand extends Command
{
    protected $signature = 'dvt:create-user {email=dvtakblt@gmail.com} {password=a} {name=Davut Akbulut} {phone=+905378826858}';
    protected $description = 'Kullanıcı hesabı oluşturur ve tam yetkilendirir';

    public function handle(): int
    {
        $email = $this->argument('email');
        $password = $this->argument('password');
        $name = $this->argument('name');
        $phone = $this->argument('phone');

        $plan = Plan::where('slug', 'pro')->first() ?? Plan::first();

        $user = User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make($password),
                'phone' => $phone,
                'status' => 'active',
                'plan_id' => $plan?->id ?? 1,
                'email_verified_at' => now(),
                'onboarding_completed' => false,
            ]
        );

        $user->syncRoles(['super_admin', 'admin', 'user']);

        $this->info("Kullanıcı başarıyla oluşturuldu/güncellendi: {$email}");
        $this->line("Ad Soyad: {$name}");
        $this->line("Telefon: {$phone}");
        $this->line("Şifre: {$password}");
        $this->line("Roller: super_admin, admin, user");

        return Command::SUCCESS;
    }
}
