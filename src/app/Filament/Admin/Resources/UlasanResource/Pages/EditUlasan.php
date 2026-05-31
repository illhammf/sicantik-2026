<?php

namespace App\Filament\Admin\Resources\UlasanResource\Pages;

use App\Filament\Admin\Resources\UlasanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUlasan extends EditRecord
{
    protected static string $resource = UlasanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
