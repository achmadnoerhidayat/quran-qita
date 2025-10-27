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
        Schema::create('dzikirs', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->longText('arab')->nullable();
            $table->longText('indo')->nullable();
            $table->string('ulang')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dzikirs');
    }
};
