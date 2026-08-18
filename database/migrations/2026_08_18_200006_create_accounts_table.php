<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('bank_id')->constrained('banks')->cascadeOnDelete();
            $table->string('name'); // örn: Maaş Hesabı, KMH / Ek Hesap
            $table->enum('type', ['checking', 'savings', 'kmh'])->default('checking');
            $table->text('iban')->nullable(); // Encrypted cast
            $table->decimal('balance', 15, 2)->default(0.00); // eksi bakiye olabilir (KMH kullanımı)
            $table->decimal('kmh_limit', 15, 2)->nullable();
            $table->decimal('kmh_interest_rate', 6, 4)->nullable(); // aylık akdi faiz % (örn: 5.0000)
            $table->char('currency', 3)->default('TRY');
            $table->softDeletes();
            $table->timestamps();

            $table->index(['user_id', 'type']);
            $table->index('bank_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
