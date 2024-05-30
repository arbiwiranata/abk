<?php

namespace App\Filament\Resources\MJenisLayananResource\Pages;

use App\Filament\Resources\MJenisLayananResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageMJenisLayanans extends ManageRecords
{
    protected static string $resource = MJenisLayananResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
