<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credit_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('bank_id')->constrained('banks')->cascadeOnDelete();
            $table->string('name'); // örn: Bonus Kart, Maximum Kart
            $table->char('last_four', 4)->nullable();
            $table->decimal('credit_limit', 15, 2)->default(0.00);
            $table->decimal('current_debt', 15, 2)->default(0.00); // dönem borcu
            $table->decimal('minimum_payment', 15, 2)->default(0.00); // asgari tutar
            $table->unsignedTinyInteger('statement_day')->default(1); // hesap kesim günü (1-31)
            $table->unsignedTinyInteger('due_day')->default(10); // son ödeme günü (1-31)
            $table->decimal('interest_rate', 6, 4)->default(5.0000); // aylık akdi faiz %
            $table->decimal('overdue_interest_rate', 6, 4)->nullable(); // aylık gecikme faizi %
            $table->date('last_payment_date')->nullable(); // son ödeme yapılan tarih (risk sayacı için kritik)
            $table->boolean('is_restructured')->default(false); // yapılandırıldı mı?
            $table->enum('status', ['active', 'closed', 'restructured'])->default('active');
            $table->softDeletes();
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index('bank_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('credit_cards');
    }
};
