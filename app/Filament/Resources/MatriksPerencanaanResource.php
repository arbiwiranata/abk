<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MatriksPerencanaanResource\Pages;
use App\Filament\Resources\MatriksPerencanaanResource\RelationManagers;
use App\Models\MatriksPerencanaan;
use App\Models\MHambatan;
use App\Models\MJenisHambatan;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;

class MatriksPerencanaanResource extends Resource
{
    protected static ?string $model = MatriksPerencanaan::class;

    protected static ?string $navigationGroup = 'Master';

    protected static ?string $navigationIcon = 'far-list-tree';

    protected static ?string $modelLabel = 'Matriks Perencanaan';

    protected static bool $hasTitleCaseModelLabel = true;

    protected static ?string $slug = 'master/matriks-perencanaan';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('nama')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->columnSpan([
                                'md' => 5,
                            ]),
                        Forms\Components\Select::make('hambatan_id')
                            ->options(MHambatan::groupHambatans())
                            ->required()
                            ->searchable()
                            ->preload()
                            ->label('Hambatan')
                            ->columnSpan([
                                'md' => 5,
                            ]),
                        Forms\Components\Toggle::make('is_aktif')
                            ->required()
                            ->inline(false)
                            ->default(true)
                            ->onColor('success')
                            ->label('Aktif'),
                    ])
                    ->columns([
                        'md' => 12,
                    ]),
                Section::make(new HtmlString('Aspek<sup class="text-danger-600 dark:text-danger-400 font-medium">*</sup>'))
                    ->schema([
                        Forms\Components\Repeater::make('matriksPerencanaanAspeks')
                            ->relationship()
                            ->required()
                            ->schema(
                                static::getAspeksFormSchema()
                            )
                            ->columns(2)
                            ->orderColumn('urutan')
                            ->label('Aspek')
                            ->hiddenLabel()
                            ->itemLabel(fn (array $state): ?string => $state['nama'] ?? null)
                            ->collapsed()
                            ->cloneable()
                            ->live()
                            ->deleteAction(
                                fn (Action $action) => $action->requiresConfirmation(),
                            )
                            ->addAction(
                                fn (Action $action) => $action
                                    ->label('Tambahkan Aspek')
                                    ->color('success')
                            )
                            ->collapseAllAction(
                                fn (Action $action) => $action
                                    ->hidden()
                            )
                            ->expandAllAction(
                                fn (Action $action) => $action
                                    ->hidden()
                            ),
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
                Tables\Columns\TextColumn::make('mHambatan.nama')
                    ->numeric()
                    ->sortable()
                    ->label('Hambatan'),
                Tables\Columns\IconColumn::make('is_aktif')
                    ->boolean()
                    ->label('Aktif'),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMatriksPerencanaans::route('/'),
            'create' => Pages\CreateMatriksPerencanaan::route('/create'),
            'edit' => Pages\EditMatriksPerencanaan::route('/{record}/edit'),
        ];
    }

    public static function getAspeksFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('nama')
                ->required()
                ->label('Nama Aspek')
                ->maxLength(255)
                ->distinct(),
            Forms\Components\Repeater::make('matriksPerencanaanItems')
                ->relationship()
                ->required()
                ->schema(
                    static::getItemsFormSchema()
                )
                ->orderColumn('urutan')
                ->label('Item')
                ->itemLabel(fn (array $state): ?string => $state['nama'] ?? null)
                ->collapsed()
                ->cloneable()
                ->live()
                ->deleteAction(
                    fn (Action $action) => $action->requiresConfirmation(),
                )
                ->addAction(
                    fn (Action $action) => $action
                        ->label('Tambahkan Item')
                        ->color('success')
                )
                ->collapseAllAction(
                    fn (Action $action) => $action
                        ->hidden()
                )
                ->expandAllAction(
                    fn (Action $action) => $action
                        ->hidden()
                ),
        ];
    }

    public static function getItemsFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('nama')
                ->required()
                ->label('Nama Item')
                ->distinct(),
            Forms\Components\Repeater::make('matriksPerencanaanSubitems')
                ->relationship()
                ->required()
                ->simple(
                    static::getSubitemsFormSchema()
                )
                ->orderColumn('urutan')
                ->label('Subitem')
                ->cloneable()
                ->addAction(
                    fn (Action $action) => $action
                        ->label('Tambahkan Subitem')
                        ->color('success')
                )
        ];
    }

    public static function getSubitemsFormSchema(): Component
    {
        return Forms\Components\TextArea::make('nama')
            ->required()
            ->label('Nama Subitem')
            ->placeholder('Nama Subitem')
            ->autosize()
            ->distinct();
    }
}
