<?php

namespace App\Filament\Resources\Artikels\Tables;

use App\Models\KategoriArtikel;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ArtikelsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('featured_image')
                    ->collection('featured_image')
                    ->label('Gambar'),
                TextColumn::make('judul')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('kategori.nama')
                    ->label('Kategori')
                    ->badge()
                    ->sortable(),
                TextColumn::make('tanggal_publish')
                    ->dateTime('d M Y')
                    ->sortable(),
                TextColumn::make('status_tayang')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'published' ? 'success' : 'gray')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('kategori_id')
                    ->label('Kategori')
                    ->options(fn () => KategoriArtikel::query()->orderBy('urutan')->pluck('nama', 'id')->all()),
                SelectFilter::make('status_tayang')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
