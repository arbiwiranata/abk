<?php

namespace App\Filament\Resources\MJenisAsesmenResource\Pages;

use App\Filament\Resources\MJenisAsesmenResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageMJenisAsesmens extends ManageRecords
{
    protected static string $resource = MJenisAsesmenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
