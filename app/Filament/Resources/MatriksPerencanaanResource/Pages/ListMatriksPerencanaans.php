<?php

namespace App\Filament\Resources\MatriksPerencanaanResource\Pages;

use App\Filament\Resources\MatriksPerencanaanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMatriksPerencanaans extends ListRecords
{
    protected static string $resource = MatriksPerencanaanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
