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
        Schema::create('comunities', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('logo')->nullable();
            $table->longText('description')->nullable();
            $table->timestamps();
        });

        Schema::table('forums', function (Blueprint $table) {
            $table->foreignId('comunity_id')->after('user_id')->nullable();
            $table->string('image')->after('content')->nullable();
            $table->enum('status', ['active', 'hidden', 'block'])->after('image')->default('active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comunities');

        Schema::table('forums', function (Blueprint $table) {
            $table->dropColumn('comunity_id');
            $table->dropColumn('image');
            $table->dropColumn('status');
        });
    }
};
