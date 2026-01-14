<?php

namespace App\Filament\Widgets;

use App\Models\Penduduk;
use App\Models\SuratKeluar;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            // Kotak 1: Total Penduduk
            Stat::make('Total Penduduk', Penduduk::count())
                ->description('Warga terdaftar di sistem')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'), // Warna biru

            // Kotak 2: Surat Keluar Bulan Ini
            Stat::make('Surat Keluar (Bulan Ini)', SuratKeluar::whereMonth('tanggal_surat', now()->month)->count())
                ->description('Peningkatan layanan')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17]) // Hiasan grafik garis kecil
                ->color('success'), // Warna hijau

            // Kotak 3: Total Semua Surat
            Stat::make('Total Arsip Surat', SuratKeluar::count())
                ->description('Total surat yang pernah dicetak')
                ->descriptionIcon('heroicon-m-document-duplicate')
                ->color('warning'), // Warna kuning
        ];
    }
}