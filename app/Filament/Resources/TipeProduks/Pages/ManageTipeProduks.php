<?php

namespace App\Filament\Resources\TipeProduks\Pages;

use App\Filament\Resources\TipeProduks\TipeProdukResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageTipeProduks extends ManageRecords
{
    protected static string $resource = TipeProdukResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
