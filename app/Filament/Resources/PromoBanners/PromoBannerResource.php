<?php

namespace App\Filament\Resources\PromoBanners;

use App\Filament\Resources\PromoBanners\Pages\ManagePromoBanners;
use App\Models\PromoBanner;
use App\Support\ImageUploadDefaults;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PromoBannerResource extends Resource
{
    protected static ?string $model = PromoBanner::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static ?string $navigationLabel = 'Promo Banner';

    protected static ?string $recordTitleAttribute = 'judul';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                ImageUploadDefaults::apply(
                    SpatieMediaLibraryFileUpload::make('gambar_desktop')
                        ->label('Gambar Desktop (16:6)')
                        ->collection('gambar_desktop')
                        ->image()
                        ->required()
                        ->helperText('Landscape, rasio 16:6 — ditampilkan di layar desktop/tablet.')
                        ->columnSpanFull()
                ),
                ImageUploadDefaults::apply(
                    SpatieMediaLibraryFileUpload::make('gambar_mobile')
                        ->label('Gambar Mobile (3:4)')
                        ->collection('gambar_mobile')
                        ->image()
                        ->required()
                        ->helperText('Potrait, rasio 3:4 — ditampilkan di layar HP.')
                        ->columnSpanFull()
                ),
                TextInput::make('judul')
                    ->helperText('Dipakai sebagai teks alt gambar, tidak ditampilkan di halaman.'),
                TextInput::make('link_url')
                    ->label('Link tujuan (opsional)')
                    ->url()
                    ->helperText('Kalau diisi, banner bisa diklik menuju link ini.'),
                TextInput::make('urutan')
                    ->numeric()
                    ->default(0),
                Select::make('status_tayang')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                    ])
                    ->default('draft')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('urutan')
            ->reorderable('urutan')
            ->columns([
                SpatieMediaLibraryImageColumn::make('gambar_desktop')
                    ->collection('gambar_desktop')
                    ->label('Gambar'),
                TextColumn::make('judul'),
                TextColumn::make('status_tayang')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'published' ? 'success' : 'gray'),
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
            'index' => ManagePromoBanners::route('/'),
        ];
    }
}
