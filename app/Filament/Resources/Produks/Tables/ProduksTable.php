<?php

namespace App\Filament\Resources\Produks\Tables;

use App\Models\TipeProduk;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ProduksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('galeri')
                    ->collection('galeri')
                    ->label('Foto')
                    ->limit(1),
                TextColumn::make('nama')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('tipeProduk.nama')
                    ->label('Tipe')
                    ->badge()
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->sortable(),
                TextColumn::make('listing_type')
                    ->label('Jual/Sewa')
                    ->badge()
                    ->sortable(),
                TextColumn::make('harga')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('lokasi')
                    ->toggleable(),
                TextColumn::make('status_tayang')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'published' ? 'success' : 'gray')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('tipe_produk_id')
                    ->label('Tipe')
                    ->options(fn () => TipeProduk::query()->orderBy('urutan')->pluck('nama', 'id')->all()),
                SelectFilter::make('status')
                    ->options([
                        'primary' => 'Primary',
                        'secondary' => 'Secondary',
                    ]),
                SelectFilter::make('listing_type')
                    ->label('Jual/Sewa')
                    ->options([
                        'jual' => 'Jual',
                        'sewa' => 'Sewa',
                    ]),
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
