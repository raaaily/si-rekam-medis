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
        Schema::table('procedures', function (Blueprint $table) {
            // 1. Drop foreign key (nama otomatis: procedures_petugas_id_foreign)
            $table->dropForeign(['petugas_id']);

            // 2. Baru drop kolom
            $table->dropColumn(['total', 'petugas_id']);
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('procedures', function (Blueprint $table) {
            $table->decimal('total', 12, 2)->nullable();
            $table->foreignId('petugas_id')->nullable()->constrained('users')->onDelete('set null');
        });
    }
};
