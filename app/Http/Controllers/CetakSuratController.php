<?php

namespace App\Http\Controllers;

use App\Models\SuratKeluar;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; // Import library PDF

class CetakSuratController extends Controller
{
    public function cetak($id)
    {
        // 1. Ambil data surat berdasarkan ID
        $surat = SuratKeluar::with(['penduduk', 'jenis_surat'])->findOrFail($id);

        // 2. Load view (template surat) dan kirim datanya
        $pdf = Pdf::loadView('surat.cetak', ['surat' => $surat]);

        // 3. Set ukuran kertas (F4/A4) dan orientasi
        $pdf->setPaper('A4', 'portrait');

        // 4. Download / Stream PDF di browser
        return $pdf->stream('Surat-' . $surat->penduduk->nama_lengkap . '.pdf');
    }
}