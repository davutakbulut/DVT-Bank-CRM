<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expected_incomes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('title'); // örn: Maaş, Melih Günal Hakediş, Elden Tahsilat
            $table->decimal('amount', 15, 2)->default(0.00);
            $table->enum('type', ['salary', 'freelance', 'rental', 'investment', 'debt_collection', 'other'])->default('salary');
            $table->enum('frequency', ['once', 'monthly', 'weekly'])->default('monthly');
            $table->unsignedTinyInteger('expected_day')->nullable(); // Ayın kaçıncı günü (1-31)
            $table->date('expected_date')->nullable(); // Tam beklenen tarih
            $table->enum('status', ['pending', 'received', 'delayed', 'cancelled'])->default('pending');
            $table->date('last_confirmed_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['user_id', 'status', 'expected_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expected_incomes');
    }
};
