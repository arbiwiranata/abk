<?php

namespace App\Filament\Resources\AnakResource\Pages;

use App\Filament\Resources\AnakResource;
use App\Models\MSekolah;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAnak extends EditRecord
{
    protected static string $resource = AnakResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['jenjang_pendidikan'] = MSekolah::find($data['sekolah_id'])->jenjang_pendidikan_id;

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        unset($data['jenjang_pendidikan']);

        return $data;
    }
}
