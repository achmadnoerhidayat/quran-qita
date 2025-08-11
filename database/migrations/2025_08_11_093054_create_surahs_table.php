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
        Schema::create('surahs', function (Blueprint $table) {
            $table->id();
            $table->integer('nomor')->default(0);
            $table->string('nama')->nullable();
            $table->string('nama_latin')->nullable();
            $table->integer('jumlah_ayat')->default(0);
            $table->string('tempat_turun')->nullable();
            $table->string('arti')->nullable();
            $table->longText('deskripsi')->nullable();
            $table->json('audio_full')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surahs');
    }
};
