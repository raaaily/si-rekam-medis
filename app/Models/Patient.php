<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon; 

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'nik',
        'no_asuransi',
        'no_rm',
        'nama_lengkap',
        'kepala_keluarga',
        'no_kk',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'telepon',
        'alamat',
        'rt',
        'rw',
        'provinsi',
        'kabupaten',
        'kecamatan',
        'desa',
        'dusun',
        'agama',
        'hubungan_dalam_keluarga',
        'pendidikan',
        'pekerjaan',
    ];

    public function assessments()
    {
        return $this->hasMany(Assessment::class);
    }

     // ✅ Umur otomatis berdasarkan tanggal_lahir
    public function getUmurAttribute()
    {
        if (!$this->tanggal_lahir) {
            return null;
        }

        return Carbon::parse($this->tanggal_lahir)->age;
    }
}
