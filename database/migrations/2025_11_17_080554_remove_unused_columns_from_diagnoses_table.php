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
        Schema::table('diagnoses', function (Blueprint $table) {
            $table->dropColumn(['kode', 'non_spesialis', 'kasus']);
        });
    }   

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('diagnoses', function (Blueprint $table) {
            $table->string('kode')->nullable();
            $table->boolean('non_spesialis')->default(false);
            $table->enum('kasus', ['baru', 'lama'])->nullable();
        });
    }
};
