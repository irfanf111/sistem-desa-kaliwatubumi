<?php

namespace App\Filament\Widgets;

use App\Models\Penduduk;
use App\Models\SuratKeluar;
use App\Models\SuratMasuk; // <--- JANGAN LUPA IMPORT INI
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            // KARTU 1: SURAT KELUAR (Pelayanan)
            Stat::make('Surat Keluar (Bulan Ini)', SuratKeluar::whereMonth('tanggal_surat', now()->month)->count())
                ->description('Layanan warga bulan ini')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),

            // KARTU 2: SURAT MASUK (Arsip) - BARU
            Stat::make('Surat Masuk (Total)', SuratMasuk::count())
                ->description('Total arsip dari dinas luar')
                ->descriptionIcon('heroicon-m-inbox-arrow-down')
                ->color('primary'),

            // KARTU 3: TOTAL PENDUDUK
            Stat::make('Total Penduduk', Penduduk::count())
                ->description('Data warga terdaftar')
                ->descriptionIcon('heroicon-m-users')
                ->color('warning'),
        ];
    }
}