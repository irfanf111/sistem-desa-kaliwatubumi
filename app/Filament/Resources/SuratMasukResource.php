<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SuratMasukResource\Pages;
use App\Models\SuratMasuk;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
// Import komponen form
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload; // Komponen Upload
use Filament\Forms\Components\Section;
// Import komponen tabel
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

class SuratMasukResource extends Resource
{
    protected static ?string $model = SuratMasuk::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox-arrow-down'; // Ikon Kotak Masuk
    protected static ?string $navigationLabel = 'Arsip Surat Masuk';
    protected static ?string $navigationGroup = 'Manajemen Surat'; // Kelompokkan menu
    protected static ?int $navigationSort = 1; // Urutan paling atas

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Data Surat Masuk')
                    ->description('Masukan detail surat dari instansi lain')
                    ->schema([
                        TextInput::make('asal_surat')
                            ->label('Pengirim / Instansi')
                            ->placeholder('Contoh: Kantor Kecamatan Butuh')
                            ->required(),

                        TextInput::make('no_surat')
                            ->label('Nomor Surat')
                            ->required(),

                        DatePicker::make('tanggal_surat')
                            ->label('Tanggal Tertulis di Surat')
                            ->required(),

                        DatePicker::make('tanggal_terima')
                            ->label('Tanggal Diterima di Desa')
                            ->default(now())
                            ->required(),

                        Textarea::make('perihal')
                            ->rows(3)
                            ->columnSpanFull()
                            ->required(),

                        // === BAGIAN UPLOAD FILE ===
                        FileUpload::make('file_lampiran')
                            ->label('Scan/Foto Surat')
                            ->directory('surat-masuk') // Disimpan di folder "surat-masuk"
                            ->acceptedFileTypes(['application/pdf', 'image/*']) // Hanya PDF atau Gambar
                            ->maxSize(5120) // Maksimal 5MB
                            ->downloadable() // Bisa didownload lagi
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tanggal_terima')
                    ->date('d M Y')
                    ->sortable()
                    ->label('Tgl Terima'),

                TextColumn::make('asal_surat')
                    ->searchable()
                    ->weight('bold')
                    ->label('Pengirim'),

                TextColumn::make('perihal')
                    ->limit(30)
                    ->tooltip(fn($record) => $record->perihal),

                TextColumn::make('file_lampiran')
                    ->formatStateUsing(fn($state) => $state ? 'Lihat File' : '-')
                    ->icon(fn($state) => $state ? 'heroicon-o-paper-clip' : '')
                    ->color('primary')
                    ->openUrlInNewTab(fn($record) => $record->file_lampiran ? asset('storage/' . $record->file_lampiran) : null)
                    ->label('File'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('tanggal_terima', 'desc');
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
            'index' => Pages\ListSuratMasuks::route('/'),
            'create' => Pages\CreateSuratMasuk::route('/create'),
            'edit' => Pages\EditSuratMasuk::route('/{record}/edit'),
        ];
    }
}