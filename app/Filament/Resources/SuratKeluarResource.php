<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SuratKeluarResource\Pages;
use App\Models\SuratKeluar;
use App\Models\JenisSurat; // Import Model Jenis Surat
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
// Import komponen form
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Placeholder; // Untuk menampilkan teks syarat
use Filament\Forms\Get; // Untuk mengambil data inputan live
use Illuminate\Support\HtmlString; // Agar HTML dari RichEditor terbaca
use Illuminate\Support\Facades\Auth;
// Import komponen tabel
use Filament\Tables\Columns\TextColumn;

class SuratKeluarResource extends Resource
{
    protected static ?string $model = SuratKeluar::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Pelayanan Surat';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Detail Surat')
                    ->schema([
                        Select::make('penduduk_nik')
                            ->label('Nama Penduduk')
                            ->relationship('penduduk', 'nama_lengkap')
                            ->searchable()
                            ->preload()
                            ->required(),

                        // --- MODIFIKASI LIVE DISPLAY ---
                        Select::make('jenis_surat_id')
                            ->label('Jenis Surat')
                            ->options(JenisSurat::all()->pluck('nama_surat', 'id')) // Load manual biar lebih kontrol
                            ->searchable()
                            ->live() // KUNCI: Agar form bereaksi saat ini diganti
                            ->required(),

                        // Komponen untuk menampilkan Syarat secara dinamis
                        Placeholder::make('persyaratan_display')
                            ->label('Dokumen Persyaratan (Info Database)')
                            ->content(function (Get $get) {
                                $suratId = $get('jenis_surat_id');

                                if (!$suratId) {
                                    return new HtmlString('<span class="text-gray-400 italic">-- Pilih jenis surat untuk melihat syarat --</span>');
                                }

                                $persyaratan = JenisSurat::find($suratId)?->persyaratan;

                                // Tampilkan HTML dari RichEditor, atau pesan default jika kosong
                                return new HtmlString($persyaratan ?? '<span class="text-red-500">Belum ada info syarat untuk surat ini.</span>');
                            })
                            ->columnSpanFull() // Lebar penuh
                            ->hidden(fn(Get $get) => !$get('jenis_surat_id')), // Sembunyi jika belum pilih surat
                        // -------------------------------

                        TextInput::make('no_surat')
                            ->default('470/   /' . date('Y'))
                            ->required(),

                        DatePicker::make('tanggal_surat')
                            ->default(now())
                            ->required(),

                        Textarea::make('keterangan')
                            ->label('Keperluan / Keterangan')
                            ->columnSpanFull(),

                        Hidden::make('user_id')
                            ->default(fn() => Auth::id())
                            ->required(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('no_surat')->sortable()->searchable(),

                TextColumn::make('penduduk.nama_lengkap')
                    ->label('Pemohon')
                    ->searchable(),

                TextColumn::make('jenis_surat.nama_surat')
                    ->label('Jenis Surat')
                    ->badge()
                    ->color('success'),

                TextColumn::make('tanggal_surat')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('user.name')
                    ->label('Petugas'),
            ])
            ->filters([
                //
            ])
            ->actions([
                // === TOMBOL CETAK PDF ===
                Tables\Actions\Action::make('cetak')
                    ->label('Cetak PDF')
                    ->icon('heroicon-o-printer')
                    ->url(fn(SuratKeluar $record) => route('cetak_surat', $record))
                    ->openUrlInNewTab()
                    ->color('success'),
                // ========================

                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSuratKeluars::route('/'),
            'create' => Pages\CreateSuratKeluar::route('/create'),
            'edit' => Pages\EditSuratKeluar::route('/{record}/edit'),
        ];
    }
}