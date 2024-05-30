<?php

namespace App\Filament\Resources\MJenisHambatanResource\Pages;

use App\Filament\Resources\MJenisHambatanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMJenisHambatan extends EditRecord
{
    protected static string $resource = MJenisHambatanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
