<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MJenisAsesmenResource\Pages;
use App\Filament\Resources\MJenisAsesmenResource\RelationManagers;
use App\Models\MJenisAsesmen;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MJenisAsesmenResource extends Resource
{
    protected static ?string $model = MJenisAsesmen::class;

    protected static ?string $navigationGroup = 'Master';

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $modelLabel = 'Jenis Asesmen';

    protected static bool $hasTitleCaseModelLabel = true;

    protected static ?string $slug = 'master/jenis-asesmen';

    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema(static::getFormSchema())
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageMJenisAsesmens::route('/'),
        ];
    }

    public static function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('nama')
                ->required()
                ->maxLength(255)
                ->unique(ignoreRecord: true),
        ];
    }
}
