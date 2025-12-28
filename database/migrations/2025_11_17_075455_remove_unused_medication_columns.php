<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('medications', function (Blueprint $table) {
            if (Schema::hasColumn('medications', 'racikan_ke')) {
                $table->dropColumn('racikan_ke');
            }
            if (Schema::hasColumn('medications', 'kode_obat')) {
                $table->dropColumn('kode_obat');
            }
            if (Schema::hasColumn('medications', 'keterangan')) {
                $table->dropColumn('keterangan');
            }
        });
    }

    public function down(): void
    {
        Schema::table('medications', function (Blueprint $table) {
            if (!Schema::hasColumn('medications', 'racikan_ke')) {
                $table->integer('racikan_ke')->nullable();
            }
            if (!Schema::hasColumn('medications', 'kode_obat')) {
                $table->string('kode_obat')->nullable();
            }
            if (!Schema::hasColumn('medications', 'keterangan')) {
                $table->text('keterangan')->nullable();
            }
        });
    }
};
