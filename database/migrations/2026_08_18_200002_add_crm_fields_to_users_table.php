<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->foreignId('plan_id')->nullable()->after('phone')->constrained('plans')->nullOnDelete();
            $table->enum('status', ['active', 'suspended', 'closed'])->default('active')->after('plan_id');
            $table->decimal('monthly_income', 15, 2)->nullable()->after('status');
            $table->boolean('onboarding_completed')->default(false)->after('monthly_income');
            $table->timestamp('last_login_at')->nullable()->after('onboarding_completed');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['plan_id']);
            $table->dropColumn([
                'phone',
                'plan_id',
                'status',
                'monthly_income',
                'onboarding_completed',
                'last_login_at',
            ]);
        });
    }
};
