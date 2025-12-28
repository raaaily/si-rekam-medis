<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('medications', function (Blueprint $table) {
            $table->dropColumn([
                'racikan_ke',
                'kode_obat',
                'keterangan'
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('medications', function (Blueprint $table) {
            $table->integer('racikan_ke')->nullable();
            $table->string('kode_obat')->nullable();
            $table->text('keterangan')->nullable();
        });
    }
};
