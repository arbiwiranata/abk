<?php

namespace App\Filament\Resources\MJenjangPendidikanResource\Pages;

use App\Filament\Resources\MJenjangPendidikanResource;
use App\Models\MJenjangPendidikan;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMJenjangPendidikan extends CreateRecord
{
    protected static string $resource = MJenjangPendidikanResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['urutan'] = MJenjangPendidikan::max('urutan') + 1;

        return $data;
    }
}
