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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('surah_id')->nullable();
            $table->foreignId('ayat_id')->nullable();
            $table->string('title')->nullable();
            $table->longText('description')->nullable();
            $table->timestamp('scheduled_at')->nullable();
            $table->enum('recurrence_pattern', ['harian', 'mingguan', 'bulanan'])->default('harian');
            $table->enum('is_completed', ['true', 'false'])->default('false');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
