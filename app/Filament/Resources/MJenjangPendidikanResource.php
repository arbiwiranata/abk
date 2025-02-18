<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MJenjangPendidikanResource\Pages;
use App\Filament\Resources\MJenjangPendidikanResource\RelationManagers;
use App\Filament\Resources\MJenjangPendidikanResource\RelationManagers\MKelasRelationManager;
use App\Filament\Resources\MJenjangPendidikanResource\RelationManagers\MSekolahRelationManager;
use App\Models\MJenjangPendidikan;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MJenjangPendidikanResource extends Resource
{
    protected static ?string $model = MJenjangPendidikan::class;

    protected static ?string $navigationGroup = 'Master';

    protected static ?string $navigationIcon = 'far-school';

    protected static ?string $modelLabel = 'Jenjang Pendidikan';

    protected static bool $hasTitleCaseModelLabel = true;

    protected static ?string $slug = 'master/jenjang-pendidikan';

    protected static ?int $navigationSort = 7;

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
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // 
            ])
            ->defaultSort('urutan')
            ->reorderable('urutan');
    }

    public static function getRelations(): array
    {
        return [
            MKelasRelationManager::class,
            MSekolahRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMJenjangPendidikans::route('/'),
            'create' => Pages\CreateMJenjangPendidikan::route('/create'),
            'edit' => Pages\EditMJenjangPendidikan::route('/{record}/edit'),
        ];
    }
}
