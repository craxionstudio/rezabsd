<?php

namespace App\Filament\Resources\Produks\RelationManagers;

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

class TipeRumahsRelationManager extends RelationManager
{
    protected static string $relationship = 'tipeRumahs';

    protected static ?string $title = 'Tipe Rumah';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('nama_tipe')
                    ->label('Nama Tipe')
                    ->placeholder('Tipe 45/90')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                TextInput::make('luas_tanah')
                    ->numeric()
                    ->suffix('m²'),
                TextInput::make('luas_bangunan')
                    ->numeric()
                    ->suffix('m²'),
                TextInput::make('kamar_tidur')
                    ->numeric(),
                TextInput::make('kamar_mandi')
                    ->numeric(),
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
        return $table
            ->recordTitleAttribute('nama_tipe')
            ->defaultSort('urutan')
            ->reorderable('urutan')
            ->columns([
                TextColumn::make('nama_tipe')
                    ->label('Nama Tipe')
                    ->searchable(),
                TextColumn::make('luas_tanah')->label('LT')->suffix(' m²'),
                TextColumn::make('luas_bangunan')->label('LB')->suffix(' m²'),
                TextColumn::make('kamar_tidur')->label('KT'),
                TextColumn::make('kamar_mandi')->label('KM'),
            ])
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
