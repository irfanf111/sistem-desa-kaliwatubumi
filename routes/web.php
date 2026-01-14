<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CetakSuratController;

Route::get('/', function () {
    return view('welcome');
});


// Route untuk cetak surat
Route::get('/cetak-surat/{id}', [CetakSuratController::class, 'cetak'])->name('cetak_surat');