<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JenisSuratResource\Pages;
use App\Filament\Resources\JenisSuratResource\RelationManagers;
use App\Models\JenisSurat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
// Import RichEditor
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;

class JenisSuratResource extends Resource
{
    protected static ?string $model = JenisSurat::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Master Jenis Surat';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Info Surat')
                    ->schema([
                        Forms\Components\TextInput::make('kode_surat')
                            ->label('Kode Klasifikasi')
                            ->required()
                            ->maxLength(10),
                        Forms\Components\TextInput::make('nama_surat')
                            ->label('Nama Layanan Surat')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('kop_surat')
                            ->required()
                            ->maxLength(255)
                            ->default('default'),
                    ])->columns(3),

                // === BAGIAN BARU: INPUT SYARAT ===
                Section::make('Persyaratan Layanan')
                    ->description('Isi syarat sesuai info Instagram Desa Kaliwatubumi')
                    ->schema([
                        RichEditor::make('persyaratan')
                            ->label('Daftar Syarat & Dokumen')
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'bulletList', // Penting buat poin-poin
                                'orderedList',
                                'redo',
                                'undo',
                            ])
                            ->columnSpanFull(), // Agar lebar penuh
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode_surat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_surat')
                    ->searchable(),
                // Menampilkan potongan syarat di tabel (opsional, biar kelihatan ada isinya/tidak)
                Tables\Columns\TextColumn::make('persyaratan')
                    ->html()
                    ->limit(50)
                    ->label('Preview Syarat'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            ]);
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
            'index' => Pages\ListJenisSurats::route('/'),
            'create' => Pages\CreateJenisSurat::route('/create'),
            'edit' => Pages\EditJenisSurat::route('/{record}/edit'),
        ];
    }
}