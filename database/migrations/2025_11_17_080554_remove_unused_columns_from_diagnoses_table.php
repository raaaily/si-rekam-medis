<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('diagnoses', function (Blueprint $table) {
            if (Schema::hasColumn('diagnoses', 'kode')) {
                $table->dropColumn('kode');
            }
            if (Schema::hasColumn('diagnoses', 'non_spesialis')) {
                $table->dropColumn('non_spesialis');
            }
            if (Schema::hasColumn('diagnoses', 'kasus')) {
                $table->dropColumn('kasus');
            }
        });
    }   

    public function down(): void
    {
        Schema::table('diagnoses', function (Blueprint $table) {
            if (!Schema::hasColumn('diagnoses', 'kode')) {
                $table->string('kode')->nullable();
            }
            if (!Schema::hasColumn('diagnoses', 'non_spesialis')) {
                $table->boolean('non_spesialis')->default(false);
            }
            if (!Schema::hasColumn('diagnoses', 'kasus')) {
                $table->enum('kasus', ['baru', 'lama'])->nullable();
            }
        });
    }
};
