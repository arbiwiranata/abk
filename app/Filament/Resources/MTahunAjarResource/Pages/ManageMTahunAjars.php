<?php

namespace App\Filament\Resources\MTahunAjarResource\Pages;

use App\Filament\Resources\MTahunAjarResource;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Contracts\View\View;


class ManageMTahunAjars extends ManageRecords
{
    protected static string $resource = MTahunAjarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
