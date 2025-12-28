<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Procedure extends Model
{
    use HasFactory;

    protected $fillable = [
        'assessment_id',
        'tindakan',
        'jumlah',
        'pembayaran',
        'harga',
    ];

    protected $casts = [
        'jumlah' => 'integer',
        'harga' => 'integer',
        // 'total' => 'decimal:2',
    ];

    /**
     * Boot model: otomatis hitung total kalau kosong
     */
    // protected static function booted()
    // {
    //     static::saving(function ($procedure) {
    //         if (empty($procedure->total) && $procedure->harga && $procedure->jumlah) {
    //             $procedure->total = $procedure->jumlah * $procedure->harga;
    //         }
    //     });
    // }

    /**
     * Relasi: 1 tindakan milik 1 assessment
     */
    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }

    /**
     * Relasi: petugas (user) yang melakukan tindakan
     */
    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    /**
     * Accessor untuk format total dalam Rupiah
     */
    // public function getTotalRupiahAttribute()
    // {
    //     return 'Rp ' . number_format($this->total ?? 0, 0, ',', '.');
    // }
}
