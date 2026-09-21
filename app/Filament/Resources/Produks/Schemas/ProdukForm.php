<?php

namespace App\Filament\Resources\Produks\Schemas;

use App\Support\ImageUploadDefaults;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Schemas\Components\Utilities\Get;
use Illuminate\Support\Str;

class ProdukForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Produk')
                    ->columns(2)
                    ->description('Spesifikasi LT/LB/kamar diisi per Tipe Unit di tab bawah setelah produk ini disimpan.')
                    ->schema([
                        TextInput::make('nama')
                            ->required()
                            ->live(onBlur: true)
                            ->maxLength(255)
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                        TextInput::make('nama_kawasan_induk')
                            ->label('Nama Kawasan Induk')
                            ->helperText('Opsional — misal "Vireya" kalau produk ini secara marketing berada di bawah nama kawasan tertentu. Kosongkan kalau produk langsung di bawah nama besar kawasan.')
                            ->maxLength(255),
                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->rules(['not_in:rumah,ruko,apartment,kavling'])
                            ->validationMessages([
                                'not_in' => 'Slug tidak boleh sama dengan kata kunci tipe (rumah/ruko/apartment/kavling) — itu dipakai untuk URL filter tipe produk.',
                            ]),
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
                        Select::make('mode_harga')
                            ->label('Mode Harga')
                            ->options([
                                'cicilan' => 'Cicilan',
                                'harga' => 'Harga jual',
                            ])
                            ->default('cicilan')
                            ->live()
                            ->required(),
                        TextInput::make('cicilan_mulai')
                            ->label('Cicilan mulai dari')
                            ->numeric()
                            ->prefix('Rp')
                            ->suffix('/bulan')
                            ->visible(fn (Get $get) => $get('mode_harga') === 'cicilan')
                            ->required(fn (Get $get) => $get('mode_harga') === 'cicilan'),
                        TextInput::make('harga_mulai')
                            ->label('Harga mulai dari')
                            ->numeric()
                            ->prefix('Rp')
                            ->visible(fn (Get $get) => $get('mode_harga') === 'harga')
                            ->required(fn (Get $get) => $get('mode_harga') === 'harga'),
                        TagsInput::make('promo')
                            ->label('Promo')
                            ->placeholder('DP 0%, Free biaya KPR & AJB, dll.')
                            ->helperText('Tekan enter tiap selesai satu poin promo. Opsional.')
                            ->columnSpanFull(),
                        TextInput::make('lokasi')
                            ->maxLength(255),
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
                        ImageUploadDefaults::apply(
                            SpatieMediaLibraryFileUpload::make('galeri')
                                ->collection('galeri')
                                ->image()
                                ->multiple()
                                ->reorderable()
                                ->panelLayout('grid')
                                ->columnSpanFull()
                        ),
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
