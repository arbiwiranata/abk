<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MJabatanResource\Pages;
use App\Filament\Resources\MJabatanResource\RelationManagers;
use App\Models\MJabatan;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MJabatanResource extends Resource
{
    protected static ?string $model = MJabatan::class;

    protected static ?string $navigationGroup = 'Master';

    protected static ?string $navigationIcon = 'far-sitemap';

    protected static ?string $modelLabel = 'Jabatan';

    protected static bool $hasTitleCaseModelLabel = true;

    protected static ?string $slug = 'master/jabatan';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('kode')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Forms\Components\TextInput::make('nama')
                            ->required()
                            ->maxLength(255),
                    ])
                    ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode')
                    ->searchable()
                    ->sortable(),
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
            'index' => Pages\ManageMJabatans::route('/'),
        ];
    }

    // public static function canViewAny(): bool
    // {
    //     return false;
    // }
}
