<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('procedures', function (Blueprint $table) {
            // Drop foreign key jika ada
            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            $doctrineTable = $sm->listTableDetails('procedures');

            if ($doctrineTable->hasForeignKey('procedures_petugas_id_foreign')) {
                $table->dropForeign(['petugas_id']);
            }

            // Drop kolom jika ada
            $columnsToRemove = ['total', 'petugas_id'];
            foreach ($columnsToRemove as $column) {
                if (Schema::hasColumn('procedures', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }

    public function down(): void
    {
        Schema::table('procedures', function (Blueprint $table) {
            if (!Schema::hasColumn('procedures', 'total')) {
                $table->decimal('total', 12, 2)->nullable();
            }
            if (!Schema::hasColumn('procedures', 'petugas_id')) {
                $table->foreignId('petugas_id')
                      ->nullable()
                      ->constrained('users')
                      ->onDelete('set null');
            }
        });
    }
};
