<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->enum('strategy', ['avalanche', 'snowball', 'custom'])->default('avalanche');
            $table->decimal('monthly_budget', 15, 2)->default(0.00); // borçlara ayrılan aylık toplam tutar
            $table->enum('status', ['draft', 'active', 'completed'])->default('draft');
            $table->enum('created_via', ['manual', 'wizard', 'ai'])->default('wizard');
            $table->timestamps();

            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_plans');
    }
};
