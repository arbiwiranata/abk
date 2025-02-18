<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MTahunAjarResource\Pages;
use App\Filament\Resources\MTahunAjarResource\RelationManagers;
use App\Models\MTahunAjar;
use Doctrine\DBAL\Schema\View;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MTahunAjarResource extends Resource
{
    protected static ?string $model = MTahunAjar::class;

    protected static ?string $navigationGroup = 'Master';

    protected static ?string $navigationIcon = 'far-calendar-star';

    protected static ?string $modelLabel = 'Tahun Ajar';

    protected static bool $hasTitleCaseModelLabel = true;

    protected static ?string $slug = 'master/tahun-ajar';

    protected static ?int $navigationSort = 3;

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
                        Grid::make(2)
                            ->schema([
                                Forms\Components\DatePicker::make('periode_mulai')
                                    ->required()
                                    ->native(false)
                                    ->closeOnDateSelection()
                                    ->displayFormat('d-m-Y')
                                    ->label('Periode Mulai')
                                    ->suffixIcon('heroicon-m-calendar-days'),
                                Forms\Components\DatePicker::make('periode_berakhir')
                                    ->required()
                                    ->afterOrEqual('periode_mulai')
                                    ->native(false)
                                    ->closeOnDateSelection()
                                    ->displayFormat('d-m-Y')
                                    ->label('Periode Berakhir')
                                    ->suffixIcon('heroicon-m-calendar-days'),
                            ])
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
                Tables\Columns\TextColumn::make('periode_mulai')
                    ->date('d F Y')
                    ->sortable()
                    ->label('Periode Mulai'),
                Tables\Columns\TextColumn::make('periode_berakhir')
                    ->date('d F Y')
                    ->sortable()
                    ->label('Periode Berakhir'),
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
            ->defaultSort('periode_mulai', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageMTahunAjars::route('/'),
        ];
    }
}
