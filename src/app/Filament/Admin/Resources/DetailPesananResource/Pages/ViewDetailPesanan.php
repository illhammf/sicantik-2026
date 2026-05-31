<?php

namespace App\Filament\Admin\Resources\DetailPesananResource\Pages;

use App\Filament\Admin\Resources\DetailPesananResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewDetailPesanan extends ViewRecord
{
    protected static string $resource = DetailPesananResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}