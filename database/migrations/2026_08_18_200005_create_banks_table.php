<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('banks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete(); // NULL = Sistem bankası
            $table->string('name');
            $table->string('logo')->nullable();
            $table->string('color', 7)->nullable(); // Hex color örn: #0056b3
            $table->boolean('is_system')->default(false);
            $table->softDeletes();
            $table->timestamps();

            $table->index(['user_id', 'is_system']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('banks');
    }
};
