<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->foreignId('credit_card_id')->nullable()->after('category_id')->constrained('credit_cards')->nullOnDelete();
            $table->foreignId('account_id')->nullable()->after('credit_card_id')->constrained('accounts')->nullOnDelete();
            $table->string('payment_method', 30)->default('credit_card')->after('account_id'); // credit_card, account, kmh, cash
            $table->unsignedSmallInteger('installment_count')->nullable()->after('amount'); // Taksit sayısı (örn: 6)
            $table->unsignedSmallInteger('current_installment')->nullable()->after('installment_count'); // Şu anki taksit (örn: 1)
            $table->decimal('total_amount', 15, 2)->nullable()->after('amount'); // Taksitli ise toplam işlem tutarı
        });
    }

    public function down(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropForeign(['credit_card_id']);
            $table->dropForeign(['account_id']);
            $table->dropColumn([
                'credit_card_id',
                'account_id',
                'payment_method',
                'installment_count',
                'current_installment',
                'total_amount',
            ]);
        });
    }
};
