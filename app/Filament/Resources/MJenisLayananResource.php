<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MJenisLayananResource\Pages;
use App\Filament\Resources\MJenisLayananResource\RelationManagers;
use App\Models\MJenisLayanan;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MJenisLayananResource extends Resource
{
    protected static ?string $model = MJenisLayanan::class;

    protected static ?string $navigationGroup = 'Master';

    protected static ?string $navigationIcon = 'far-globe-pointer';

    protected static ?string $modelLabel = 'Jenis Layanan';

    protected static bool $hasTitleCaseModelLabel = true;

    protected static ?string $slug = 'master/jenis-layanan';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('nama')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                    ])
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
            ])
            ->defaultSort('urutan')
            ->reorderable('urutan');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageMJenisLayanans::route('/'),
        ];
    }
}
