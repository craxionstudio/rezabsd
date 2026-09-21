<?php

namespace App\Filament\Resources\KategoriArtikels\Pages;

use App\Filament\Resources\KategoriArtikels\KategoriArtikelResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageKategoriArtikels extends ManageRecords
{
    protected static string $resource = KategoriArtikelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
