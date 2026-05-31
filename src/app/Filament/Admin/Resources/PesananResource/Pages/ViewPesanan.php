<?php

namespace App\Filament\Admin\Resources\PesananResource\Pages;

use App\Filament\Admin\Resources\PesananResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPesanan extends ViewRecord
{
    protected static string $resource = PesananResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}