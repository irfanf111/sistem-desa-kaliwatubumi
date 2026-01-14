<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penduduk extends Model
{
    use HasFactory;

    // Setting Primary Key Custom (NIK)
    protected $primaryKey = 'nik';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $guarded = []; // Biar bisa create data pakai array
    protected $casts = [
        'tanggal_lahir' => 'date',
    ];
    // Relasi: Satu Penduduk bisa punya banyak Surat Keluar
    public function surat_keluars()
    {
        return $this->hasMany(SuratKeluar::class, 'penduduk_nik', 'nik');
    }
}