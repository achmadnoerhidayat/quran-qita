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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('rekening_bank_id')->nullable();
            $table->bigInteger('jumlah_donasi')->default(0);
            $table->string('metode_pembayaran')->nullable();
            $table->string('nama_rekening')->nullable();
            $table->string('nomer_rekening')->nullable();
            $table->string('bukti_transfer')->nullable();
            $table->enum('status', ['Menunggu Konfirmasi', 'Dikonfirmasi', 'Ditolak'])->default('Menunggu Konfirmasi');
            $table->longText('keterangan_admin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
