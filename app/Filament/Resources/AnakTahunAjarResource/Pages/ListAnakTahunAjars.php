<?php

namespace App\Filament\Resources\AnakTahunAjarResource\Pages;

use App\Filament\Resources\AnakTahunAjarResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAnakTahunAjars extends ListRecords
{
    protected static string $resource = AnakTahunAjarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
