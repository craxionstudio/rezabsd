<?php

namespace App\Filament\Resources\PromoBanners\Pages;

use App\Filament\Resources\PromoBanners\PromoBannerResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManagePromoBanners extends ManageRecords
{
    protected static string $resource = PromoBannerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
