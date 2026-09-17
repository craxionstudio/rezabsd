<?php

namespace App\Filament\Resources\Produks\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Illuminate\Support\Str;

class ProdukForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Produk')
                    ->columns(2)
                    ->schema([
                        TextInput::make('nama')
                            ->required()
                            ->live(onBlur: true)
                            ->maxLength(255)
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Select::make('tipe_produk_id')
                            ->label('Tipe Properti')
                            ->relationship('tipeProduk', 'nama')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('status')
                            ->options([
                                'primary' => 'Primary',
                                'secondary' => 'Secondary',
                            ])
                            ->required(),
                        Select::make('listing_type')
                            ->label('Jual / Sewa')
                            ->options([
                                'jual' => 'Jual',
                                'sewa' => 'Sewa',
                            ])
                            ->default('jual')
                            ->required(),
                        TextInput::make('harga')
                            ->required()
                            ->numeric()
                            ->prefix('Rp'),
                        TextInput::make('lokasi')
                            ->maxLength(255),
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
                        Select::make('status_tayang')
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Published',
                            ])
                            ->default('draft')
                            ->required(),
                    ]),
                Section::make('Deskripsi & Galeri')
                    ->schema([
                        RichEditor::make('deskripsi')
                            ->columnSpanFull(),
                        SpatieMediaLibraryFileUpload::make('galeri')
                            ->collection('galeri')
                            ->image()
                            ->multiple()
                            ->reorderable()
                            ->panelLayout('grid')
                            ->columnSpanFull(),
                    ]),
                Section::make('SEO')
                    ->schema([
                        TextInput::make('meta_title')
                            ->maxLength(255),
                        TextInput::make('meta_description')
                            ->maxLength(255),
                    ]),
            ]);
    }
}
