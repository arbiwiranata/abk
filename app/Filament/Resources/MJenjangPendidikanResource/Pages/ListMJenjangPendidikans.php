<?php

namespace App\Filament\Resources\MJenjangPendidikanResource\Pages;

use App\Filament\Resources\MJenjangPendidikanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMJenjangPendidikans extends ListRecords
{
    protected static string $resource = MJenjangPendidikanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
