<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->unsignedInteger('kunjungan_ke')->default(1);

            // A. Anamnesa
            $table->text('keluhan')->nullable();
            $table->text('anamnesa')->nullable();
            $table->text('terapi_non_obat')->nullable();
            // $table->text('bmhp')->nullable();
            $table->string('prognosa')->nullable();
            $table->string('kesadaran')->nullable();

            // B. Pemeriksaan Fisik
            $table->float('tinggi_badan')->nullable();
            $table->float('berat_badan')->nullable();
            $table->float('imt')->nullable();
            $table->float('lila')->nullable();
            $table->float('lingkar_perut')->nullable();
            $table->float('lingkar_kepala')->nullable();

            // C. Tanda Vital
            $table->integer('tekanan_sistolik')->nullable();
            $table->integer('tekanan_diastolik')->nullable();
            $table->integer('rr')->nullable();
            $table->integer('hr')->nullable();
            $table->float('suhu')->nullable();
            $table->integer('gds')->nullable();

            // D. Riwayat Alergi
            $table->text('alergi_makanan')->nullable();
            $table->text('alergi_udara')->nullable();
            $table->text('alergi_obat')->nullable();

            // E. SOAP Dokter
            $table->text('soap_subjektif')->nullable(); 
            $table->text('soap_objektif')->nullable();
            $table->text('soap_assesmen')->nullable();
            $table->text('soap_perencanaan')->nullable();

            // F. Lain-lain
            $table->foreignId('petugas_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('kategori_kunjungan')->nullable();
            $table->string('tindak_lanjut')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('assessments');
    }
};
