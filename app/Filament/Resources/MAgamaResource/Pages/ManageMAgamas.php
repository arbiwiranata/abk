<?php

namespace App\Filament\Resources\MAgamaResource\Pages;

use App\Filament\Resources\MAgamaResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageMAgamas extends ManageRecords
{
    protected static string $resource = MAgamaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
