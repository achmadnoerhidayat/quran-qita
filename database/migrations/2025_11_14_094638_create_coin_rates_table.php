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
        Schema::create('coin_rates', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['purchase', 'withdraw']);
            $table->bigInteger('coin_unit')->default(0);
            $table->bigInteger('unit_value')->default(0);
            $table->boolean('active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coin_rates');
    }
};
