<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'kunjungan_ke',
        'keluhan',
        'anamnesa',
        'terapi_non_obat',
        'prognosa',
        'kesadaran',
        'tinggi_badan',
        'berat_badan',
        'imt',
        'lila',
        'lingkar_perut',
        'lingkar_kepala',
        'tekanan_sistolik',
        'tekanan_diastolik',
        'rr',
        'hr',
        'suhu',
        'gds',
        'alergi_makanan',
        'alergi_udara',
        'alergi_obat',
        'soap_subjektif',
        'soap_objektif',
        'soap_assesmen',
        'soap_perencanaan',
        'petugas_id',
        'kategori_kunjungan',
        'tindak_lanjut',
        'catatan',
    ];

    // 🔗 RELASI
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    public function diagnoses()
    {
        return $this->hasMany(Diagnosis::class);
    }

    public function procedures()
    {
        return $this->hasMany(Procedure::class);
    }

    public function medications()
    {
        return $this->hasMany(Medication::class);
    }

    // 🧮 Accessor tambahan (opsional, tapi berguna)
    public function getLabelKunjunganAttribute()
    {
        return $this->kunjungan_ke ? "Kunjungan ke-" . $this->kunjungan_ke : '-';
    }

    public function getImtLabelAttribute()
    {
        if (!$this->imt) return '-';
        if ($this->imt < 18.5) return 'Kurus';
        if ($this->imt < 25) return 'Normal';
        if ($this->imt < 30) return 'Gemuk';
        return 'Obesitas';
    }
}
