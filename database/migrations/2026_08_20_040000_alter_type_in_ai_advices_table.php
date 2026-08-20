<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE ai_advices MODIFY COLUMN type VARCHAR(50) NOT NULL DEFAULT 'daily'");
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE ai_advices MODIFY COLUMN type ENUM('daily', 'analysis', 'chat') NOT NULL DEFAULT 'daily'");
        }
    }
};
