<?php

namespace App\Filament\Admin\Resources\PesanKontakResource\Pages;

use App\Filament\Admin\Resources\PesanKontakResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPesanKontak extends EditRecord
{
    protected static string $resource = PesanKontakResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
