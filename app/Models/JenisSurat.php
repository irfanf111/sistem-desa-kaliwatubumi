<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisSurat extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Relasi: Satu Jenis Surat bisa dipakai di banyak Transaksi
    public function surat_keluars()
    {
        return $this->hasMany(SuratKeluar::class);
    }
}