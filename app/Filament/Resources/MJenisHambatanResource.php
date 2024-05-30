<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MJenisHambatanResource\Pages;
use App\Filament\Resources\MJenisHambatanResource\RelationManagers;
use App\Filament\Resources\MJenisHambatanResource\RelationManagers\MHambatansRelationManager;
use App\Models\MJenisHambatan;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MJenisHambatanResource extends Resource
{
    protected static ?string $model = MJenisHambatan::class;

    protected static ?string $navigationGroup = 'Master';

    protected static ?string $navigationIcon = 'heroicon-o-bookmark-square';

    protected static ?string $modelLabel = 'Jenis Hambatan';

    protected static bool $hasTitleCaseModelLabel = true;

    protected static ?string $slug = 'master/jenis-hambatan';

    protected static ?int $navigationSort = 4;

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
                Tables\Columns\TextColumn::make('mHambatans.nama')
                    ->badge()
                    ->separator(',')
                    ->label('Hambatan'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            MHambatansRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMJenisHambatans::route('/'),
            'create' => Pages\CreateMJenisHambatan::route('/create'),
            'edit' => Pages\EditMJenisHambatan::route('/{record}/edit'),
        ];
    }
}
