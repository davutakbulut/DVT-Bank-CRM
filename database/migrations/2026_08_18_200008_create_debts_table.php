<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('debts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('bank_id')->nullable()->constrained('banks')->nullOnDelete();
            $table->foreignId('account_id')->nullable()->constrained('accounts')->nullOnDelete();
            $table->foreignId('credit_card_id')->nullable()->constrained('credit_cards')->nullOnDelete();
            $table->enum('type', ['loan', 'kmh', 'credit_card', 'personal', 'other'])->default('loan');
            $table->string('title'); // örn: İhtiyaç Kredisi, KMH Borcu
            $table->decimal('principal', 15, 2)->default(0.00); // anapara
            $table->decimal('remaining', 15, 2)->default(0.00); // kalan borç
            $table->decimal('interest_rate', 6, 4)->default(0.0000); // aylık faiz %
            $table->integer('installment_count')->nullable(); // toplam taksit sayısı
            $table->decimal('installment_amount', 15, 2)->nullable(); // aylık taksit tutarı
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->date('next_due_date')->nullable()->index(); // hatırlatıcılar ve takvim
            $table->date('last_payment_date')->nullable(); // 90 gün risk sayacı için kritik
            $table->integer('days_overdue')->default(0); // gecikme gün sayısı (scheduled job günceller)
            $table->boolean('is_restructured')->default(false);
            $table->enum('status', ['active', 'paid', 'defaulted', 'restructured'])->default('active')->index();
            $table->text('notes')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index(['user_id', 'days_overdue']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('debts');
    }
};
