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
        Schema::table('surahs', function (Blueprint $table) {
            $table->longText('arti_english')->after('arti')->nullable();
        });

        Schema::table('ayats', function (Blueprint $table) {
            $table->longText('teks_english')->after('teks_indo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surahs', function (Blueprint $table) {
            $table->dropColumn('arti_english');
        });

        Schema::table('ayats', function (Blueprint $table) {
            $table->dropColumn('teks_english');
        });
    }
};
