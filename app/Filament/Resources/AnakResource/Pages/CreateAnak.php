<?php

namespace App\Filament\Resources\AnakResource\Pages;

use App\Filament\Resources\AnakResource;
use Filament\Actions;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\CreateRecord\Concerns\HasWizard;

class CreateAnak extends CreateRecord
{
    use HasWizard;

    protected static string $resource = AnakResource::class;

    public function form(Form $form): Form
    {
        return parent::form($form)
            ->schema([
                Wizard::make($this->getSteps())
                    ->startOnStep($this->getStartStep())
                    ->cancelAction($this->getCancelFormAction())
                    ->submitAction($this->getSubmitFormAction())
                    ->skippable($this->hasSkippableSteps())
                    ->contained(false),
            ])
            ->columns(null);
    }

    protected function getSteps(): array
    {
        return [
            Step::make('Data Anak')
                ->schema([
                    Section::make()->schema(AnakResource::getDataAnakFormSchema())->columns(3),
                ]),
            Step::make('Data Sekolah')
                ->schema([
                    Section::make()->schema(AnakResource::getDataSekolahFormSchema())->columns(3),
                ]),
            Step::make('Data Keluarga')
                ->schema([
                    Section::make()->schema(AnakResource::getDataKeluargaFormSchema())->columns(3),
                ]),
            Step::make('Hasil Asesmen')
                ->schema([
                    Section::make()->schema([
                        AnakResource::getJenisAsesmensRepeater(),
                    ]),
                ]),
        ];
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        unset($data['jenjang_pendidikan']);
        
        return $data;
    }
}
