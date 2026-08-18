<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ai_advices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['daily', 'analysis', 'chat'])->default('daily');
            $table->json('context_snapshot')->nullable(); // AI prompt verisi
            $table->integer('prompt_tokens')->nullable();
            $table->integer('completion_tokens')->nullable();
            $table->string('provider')->default('groq'); // groq, gemini, openrouter, fallback
            $table->string('model')->nullable();
            $table->longText('content'); // AI yanıtı (Markdown)
            $table->enum('status', ['success', 'failed', 'fallback'])->default('success');
            $table->timestamps();

            $table->index(['user_id', 'type', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_advices');
    }
};
