<?php

namespace App\Filament\Admin\Resources\PesanKontakResource\Pages;

use App\Filament\Admin\Resources\PesanKontakResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPesanKontaks extends ListRecords
{
    protected static string $resource = PesanKontakResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
