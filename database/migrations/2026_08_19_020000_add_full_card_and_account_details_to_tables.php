<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('credit_cards', function (Blueprint $table) {
            $table->text('card_number')->nullable()->after('name'); // 16 haneli tam kart numarası
            $table->string('card_holder')->nullable()->after('card_number'); // Kart üzerindeki isim
            $table->string('expiry_date', 7)->nullable()->after('card_holder'); // MM/YY
        });

        Schema::table('accounts', function (Blueprint $table) {
            $table->string('account_number', 30)->nullable()->after('iban'); // Hesap No
            $table->string('branch_code', 20)->nullable()->after('account_number'); // Şube Kodu
        });
    }

    public function down(): void
    {
        Schema::table('credit_cards', function (Blueprint $table) {
            $table->dropColumn(['card_number', 'card_holder', 'expiry_date']);
        });

        Schema::table('accounts', function (Blueprint $table) {
            $table->dropColumn(['account_number', 'branch_code']);
        });
    }
};
