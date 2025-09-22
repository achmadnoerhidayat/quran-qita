<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reminders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->string('title')->nullable();
            $table->enum('reminder_type', ['sholat', 'dzikir', 'tahajud', 'puasa', 'lainnya'])->default('sholat');
            $table->timestamp('scheduled_at')->nullable();
            $table->enum('recurrence_pattern', ['harian', 'mingguan', 'bulanan'])->default('harian');
            $table->enum('is_active', ['true', 'false'])->default('true');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reminders');
    }
};
