<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('incomes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('title'); // örn: Aylık Maaş, Freelance Gelir
            $table->decimal('amount', 15, 2)->default(0.00);
            $table->enum('type', ['salary', 'freelance', 'rental', 'other'])->default('salary');
            $table->enum('frequency', ['once', 'monthly'])->default('monthly');
            $table->unsignedTinyInteger('received_day')->nullable(); // ayın kaçıncı günü (1-31)
            $table->boolean('is_recurring')->default(true);
            $table->softDeletes();
            $table->timestamps();

            $table->index(['user_id', 'frequency']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('incomes');
    }
};
