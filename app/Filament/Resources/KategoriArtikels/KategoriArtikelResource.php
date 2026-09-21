<?php

namespace App\Filament\Resources\KategoriArtikels;

use App\Filament\Resources\KategoriArtikels\Pages\ManageKategoriArtikels;
use App\Models\KategoriArtikel;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class KategoriArtikelResource extends Resource
{
    protected static ?string $model = KategoriArtikel::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;

    protected static ?string $navigationLabel = 'Kategori Artikel';

    protected static ?string $recordTitleAttribute = 'nama';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->required()
                    ->live(onBlur: true)
                    ->maxLength(255)
                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                TextInput::make('deskripsi_singkat')
                    ->label('Deskripsi Singkat')
                    ->helperText('Opsional — ditampilkan di header halaman /artikel/kategori/{slug}.')
                    ->maxLength(255),
                TextInput::make('urutan')
                    ->numeric()
                    ->default(0)
                    ->helperText('Menentukan urutan tampil di pills kategori halaman Artikel.'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('urutan')
            ->reorderable('urutan')
            ->columns([
                TextColumn::make('nama')->searchable(),
                TextColumn::make('slug'),
                TextColumn::make('artikels_count')->counts('artikels')->label('Jumlah Artikel'),
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

    public static function getPages(): array
    {
        return [
            'index' => ManageKategoriArtikels::route('/'),
        ];
    }
}
