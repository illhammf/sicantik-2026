<?php

namespace App\Filament\Admin\Resources\UlasanResource\Pages;

use App\Filament\Admin\Resources\UlasanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUlasans extends ListRecords
{
    protected static string $resource = UlasanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
