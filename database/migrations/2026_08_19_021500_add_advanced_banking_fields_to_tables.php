<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('credit_cards', function (Blueprint $table) {
            $table->decimal('reward_balance', 10, 2)->default(0.00)->after('minimum_payment'); // Puan / Jest Lira / Chip Para
            $table->decimal('cash_advance_limit', 15, 2)->nullable()->after('credit_limit'); // Nakit avans limiti
            $table->boolean('is_cash_advance_blocked')->default(false)->after('cash_advance_limit'); // Asgari ödenmediği için kapalı mı?
            $table->date('statement_date')->nullable()->after('due_day'); // Son hesap kesim tam tarihi
            $table->date('next_statement_date')->nullable()->after('statement_date'); // Bir sonraki hesap kesim tarihi
            $table->date('next_due_date')->nullable()->after('next_statement_date'); // Bir sonraki son ödeme tarihi
        });

        Schema::table('accounts', function (Blueprint $table) {
            $table->string('branch_name', 150)->nullable()->after('branch_code'); // Şube adı (Örn: Osmangazi Cd. - Bağcılar)
        });

        Schema::table('debts', function (Blueprint $table) {
            $table->string('merchant_name', 150)->nullable()->after('title'); // Harcama yapılan üye işyeri
            $table->unsignedSmallInteger('current_installment')->nullable()->after('installment_count'); // Şu anki taksit sırası (örn: 4)
            $table->unsignedSmallInteger('total_installments')->nullable()->after('current_installment'); // Toplam taksit (örn: 9)
            $table->date('transaction_date')->nullable()->after('total_installments'); // İlk harcama tarihi
            $table->string('city', 60)->nullable()->after('transaction_date'); // Harcama şehri (örn: İstanbul)
        });
    }

    public function down(): void
    {
        Schema::table('credit_cards', function (Blueprint $table) {
            $table->dropColumn([
                'reward_balance',
                'cash_advance_limit',
                'is_cash_advance_blocked',
                'statement_date',
                'next_statement_date',
                'next_due_date',
            ]);
        });

        Schema::table('accounts', function (Blueprint $table) {
            $table->dropColumn(['branch_name']);
        });

        Schema::table('debts', function (Blueprint $table) {
            $table->dropColumn([
                'merchant_name',
                'current_installment',
                'total_installments',
                'transaction_date',
                'city',
            ]);
        });
    }
};
