<?php

namespace App\Filament\Resources\MatriksPerencanaanResource\Pages;

use App\Filament\Resources\MatriksPerencanaanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMatriksPerencanaan extends EditRecord
{
    protected static string $resource = MatriksPerencanaanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
