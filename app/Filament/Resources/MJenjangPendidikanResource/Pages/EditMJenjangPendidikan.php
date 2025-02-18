<?php

namespace App\Filament\Resources\MJenjangPendidikanResource\Pages;

use App\Filament\Resources\MJenjangPendidikanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMJenjangPendidikan extends EditRecord
{
    protected static string $resource = MJenjangPendidikanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
