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
        Schema::create('asmaul_husnas', function (Blueprint $table) {
            $table->id();
            $table->string('arab')->nullable();
            $table->string('latin')->nullable();
            $table->string('indo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asmaul_husnas');
    }
};
