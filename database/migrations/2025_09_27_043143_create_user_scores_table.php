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
        Schema::create('user_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attempt_id')->nullable();
            $table->bigInteger('score')->default(0);
            $table->decimal('percentage', 5, 2)->default(0.0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_scores');
    }
};
