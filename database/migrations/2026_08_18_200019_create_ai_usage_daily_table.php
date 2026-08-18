<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ai_usage_daily', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('provider');
            $table->integer('requests')->default(0);
            $table->integer('tokens')->default(0);
            $table->timestamps();

            $table->unique(['date', 'provider']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_usage_daily');
    }
};
