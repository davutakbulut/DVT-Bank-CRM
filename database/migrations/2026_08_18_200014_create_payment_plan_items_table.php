<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_plan_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_plan_id')->constrained('payment_plans')->cascadeOnDelete();
            $table->foreignId('debt_id')->nullable()->constrained('debts')->nullOnDelete();
            $table->foreignId('credit_card_id')->nullable()->constrained('credit_cards')->nullOnDelete();
            $table->integer('priority')->default(1);
            $table->decimal('allocated_amount', 15, 2)->default(0.00);
            $table->date('month')->index(); // hangi aya ait (örn: 2026-09-01)
            $table->enum('status', ['pending', 'paid', 'skipped'])->default('pending');
            $table->timestamps();

            $table->index(['payment_plan_id', 'month']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_plan_items');
    }
};
