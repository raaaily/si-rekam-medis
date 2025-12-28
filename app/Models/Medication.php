<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medication extends Model
{
    use HasFactory;

    protected $fillable = [
        'assessment_id',
        'nama_obat',
        'jenis',         // non_racikan / racikan
        'dosis',
        'jumlah',
    ];

    protected $casts = [
        'jumlah' => 'integer',
        // 'racikan_ke' => 'integer',
    ];

    /**
     * Relasi ke assessment
     */
    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }

    /**
     * Accessor untuk label jenis obat
     */
    public function getJenisLabelAttribute()
    {
        return $this->jenis === 'racikan' ? 'Obat Racikan' : 'Obat Non-Racikan';
    }

    /**
     * Accessor untuk menampilkan nama lengkap obat
     * (contoh: “Paracetamol 500mg (3 tablet)”)
     */
    public function getNamaLengkapAttribute()
    {
        $jumlah = $this->jumlah ? " ({$this->jumlah} unit)" : '';
        return "{$this->nama_obat} {$this->dosis}{$jumlah}";
    }
}
