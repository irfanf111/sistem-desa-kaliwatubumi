<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratKeluar extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Casting agar tanggal otomatis jadi object Carbon (bisa diformat tgl-bln-thn)
    protected $casts = [
        'tanggal_surat' => 'date',
    ];

    // Relasi Kebalikan (Belongs To)
    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class, 'penduduk_nik', 'nik');
    }

    public function jenis_surat()
    {
        return $this->belongsTo(JenisSurat::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}