<?php

namespace App\Filament\Admin\Resources\PesanKontakResource\Pages;

use App\Filament\Admin\Resources\PesanKontakResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPesanKontak extends ViewRecord
{
    protected static string $resource = PesanKontakResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}