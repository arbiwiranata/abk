<?php

namespace App\Filament\Resources\MJenisLayananResource\Pages;

use App\Filament\Resources\MJenisLayananResource;
use App\Models\MJenisLayanan;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageMJenisLayanans extends ManageRecords
{
    protected static string $resource = MJenisLayananResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->mutateFormDataUsing(function (array $data): array {
                    $data['urutan'] = MJenisLayanan::max('urutan') + 1;

                    return $data;
                }),
        ];
    }
}
