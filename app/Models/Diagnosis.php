<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnosis extends Model
{
    use HasFactory;

    protected $fillable = [
        'assessment_id',
        'diagnosa',
        'kategori',
    ];

    protected $casts = [
        'non_spesialis' => 'boolean',
    ];

    /**
     * Relasi ke Assessment
     */
    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }

    /**
     * Accessor opsional untuk label kategori diagnosis
     */
    // public function getKategoriLabelAttribute()
    // {
    //     return match ($this->kategori) {
    //         'primer' => 'Diagnosis Primer',
    //         'sekunder' => 'Diagnosis Sekunder',
    //         default => '-',
    //     };
    // }

    public function getKategoriLabelAttribute()
    {
        return match ($this->kategori) {
            'primer'   => 'Diagnosis Primer',
            'sekunder' => 'Diagnosis Sekunder',
            default    => ucfirst($this->kategori),
        };
    }


    /**
     * Accessor label kasus
     */
    public function getKasusLabelAttribute()
    {
        return $this->kasus ? ucfirst($this->kasus) : '-';
    }
}
