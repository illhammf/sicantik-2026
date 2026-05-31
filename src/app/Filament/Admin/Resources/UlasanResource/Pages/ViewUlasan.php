<?php

namespace App\Filament\Admin\Resources\UlasanResource\Pages;

use App\Filament\Admin\Resources\UlasanResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewUlasan extends ViewRecord
{
    protected static string $resource = UlasanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}