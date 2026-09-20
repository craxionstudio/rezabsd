<?php

namespace App\Filament\Resources\Produks\RelationManagers;

use App\Models\Produk;
use App\Support\ImageUploadDefaults;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TipeUnitsRelationManager extends RelationManager
{
    protected static string $relationship = 'tipeUnits';

    protected static ?string $title = 'Tipe Unit';

    private function tipeSlug(): string
    {
        /** @var Produk $produk */
        $produk = $this->getOwnerRecord();

        return $produk->tipeProduk->slug;
    }

    public function form(Schema $schema): Schema
    {
        $tipe = $this->tipeSlug();

        return $schema
            ->columns(2)
            ->components([
                TextInput::make('nama_tipe')
                    ->label('Nama Tipe')
                    ->placeholder($tipe === 'apartment' ? 'Studio A / 1BR Tower A' : 'Tipe 45/90')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                TextInput::make('luas_tanah')
                    ->label('Luas tanah')
                    ->numeric()
                    ->suffix('m²')
                    ->visible(in_array($tipe, ['rumah', 'ruko', 'kavling', 'gudang'])),
                TextInput::make('luas_bangunan')
                    ->label($tipe === 'apartment' ? 'Luas unit' : 'Luas bangunan')
                    ->numeric()
                    ->suffix('m²')
                    ->visible(in_array($tipe, ['rumah', 'ruko', 'apartment'])),
                TextInput::make('kamar_tidur')
                    ->label($tipe === 'apartment' ? 'Tipe kamar (0=Studio, 1=1BR, dst.)' : 'Kamar tidur')
                    ->numeric()
                    ->visible(in_array($tipe, ['rumah', 'apartment'])),
                TextInput::make('kamar_mandi')
                    ->label($tipe === 'ruko' ? 'Jumlah toilet' : 'Kamar mandi')
                    ->numeric()
                    ->visible(in_array($tipe, ['rumah', 'ruko', 'apartment'])),
                TextInput::make('carport')
                    ->numeric()
                    ->helperText('Opsional — kosongkan kalau tidak ada.')
                    ->visible(in_array($tipe, ['rumah', 'ruko'])),
                TextInput::make('jumlah_lantai')
                    ->label('Jumlah lantai')
                    ->numeric()
                    ->required($tipe === 'ruko')
                    ->helperText($tipe === 'rumah' ? 'Opsional — isi kalau rumah 2 lantai.' : null)
                    ->visible(in_array($tipe, ['rumah', 'ruko'])),
                TextInput::make('urutan')
                    ->numeric()
                    ->default(0)
                    ->helperText('Tipe dengan urutan terkecil jadi spesifikasi yang tampil di halaman Detail Produk.'),
                ImageUploadDefaults::apply(
                    SpatieMediaLibraryFileUpload::make('galeri')
                        ->collection('galeri')
                        ->image()
                        ->multiple()
                        ->reorderable()
                        ->panelLayout('grid')
                        ->helperText('Opsional — override foto galeri umum produk kalau tipe ini beda fotonya.')
                        ->columnSpanFull()
                ),
            ]);
    }

    public function table(Table $table): Table
    {
        $tipe = $this->tipeSlug();

        $columns = [
            TextColumn::make('nama_tipe')
                ->label('Nama Tipe')
                ->searchable(),
        ];

        if (in_array($tipe, ['rumah', 'ruko', 'kavling', 'gudang'])) {
            $columns[] = TextColumn::make('luas_tanah')->label('LT')->suffix(' m²');
        }

        if (in_array($tipe, ['rumah', 'ruko', 'apartment'])) {
            $columns[] = TextColumn::make('luas_bangunan')->label($tipe === 'apartment' ? 'Luas unit' : 'LB')->suffix(' m²');
        }

        if (in_array($tipe, ['rumah', 'apartment'])) {
            $columns[] = TextColumn::make('kamar_tidur')->label($tipe === 'apartment' ? 'Tipe kamar' : 'KT');
        }

        if (in_array($tipe, ['rumah', 'ruko', 'apartment'])) {
            $columns[] = TextColumn::make('kamar_mandi')->label($tipe === 'ruko' ? 'Toilet' : 'KM');
        }

        if (in_array($tipe, ['rumah', 'ruko'])) {
            $columns[] = TextColumn::make('jumlah_lantai')->label('Lantai');
        }

        return $table
            ->recordTitleAttribute('nama_tipe')
            ->defaultSort('urutan')
            ->reorderable('urutan')
            ->columns($columns)
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
