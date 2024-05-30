<?php

namespace App\Filament\Resources\MJabatanResource\Pages;

use App\Filament\Resources\MJabatanResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageMJabatans extends ManageRecords
{
    protected static string $resource = MJabatanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
