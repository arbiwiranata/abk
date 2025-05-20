<?php

namespace App\Filament\Resources\AnakTahunAjarResource\Pages;

use App\Filament\Resources\AnakTahunAjarResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAnakTahunAjar extends EditRecord
{
    protected static string $resource = AnakTahunAjarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getFormActions(): array
    {
        return [
            // Actions\EditAction::make(),
            // ...parent::getSubmitFormAction(),
            // Actions\Action::make('close')->action('createAndClose'),
        ];
    }
}
