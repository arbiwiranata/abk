<?php

namespace App\Filament\Resources\AnakResource\Pages;

use App\Filament\Resources\AnakResource;
use App\Models\MSekolah;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;

class ViewAnak extends ViewRecord
{
    protected static string $resource = AnakResource::class;

    public static function getNavigationLabel(): string
    {
        return 'Lihat ' . AnakResource::getModelLabel();
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['jenjang_pendidikan'] = MSekolah::find($data['sekolah_id'])->jenjang_pendidikan_id;

        return $data;
    }
}
