<?php

namespace App\Filament\Admin\Resources\PengaturanWebsiteResource\Pages;

use App\Filament\Admin\Resources\PengaturanWebsiteResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPengaturanWebsite extends ViewRecord
{
    protected static string $resource = PengaturanWebsiteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}