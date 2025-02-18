<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KurikulumResource\Pages;
use App\Filament\Resources\KurikulumResource\RelationManagers;
use App\Models\Kurikulum;
use App\Models\MHambatan;
use App\Models\MJenisHambatan;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Forms\FormsComponent;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;

class KurikulumResource extends Resource
{
    protected static ?string $model = Kurikulum::class;

    protected static ?string $navigationGroup = 'Master';

    protected static ?string $navigationIcon = 'far-book-user';

    protected static ?string $modelLabel = 'Kurikulum';

    protected static bool $hasTitleCaseModelLabel = true;

    protected static ?string $slug = 'master/kurikulum';

    protected static ?int $navigationSort = 1;

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
                        Forms\Components\Repeater::make('kurikulumAspeks')
                            ->relationship()
                            ->required()
                            ->schema(
                                static::getAspeksFormSchema()
                            )
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
            'index' => Pages\ListKurikulums::route('/'),
            'create' => Pages\CreateKurikulum::route('/create'),
            'edit' => Pages\EditKurikulum::route('/{record}/edit'),
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
            Forms\Components\Repeater::make('kurikulumTargets')
                ->relationship()
                ->required()
                ->schema(
                    static::getTargetsFormSchema()
                )
                ->columns(2)
                ->orderColumn('urutan')
                ->label('Target')
                ->itemLabel(fn (array $state): ?string => $state['nama'] ?? null)
                ->collapsed()
                ->cloneable()
                ->live()
                ->deleteAction(
                    fn (Action $action) => $action->requiresConfirmation(),
                )
                ->addAction(
                    fn (Action $action) => $action
                        ->label('Tambahkan Target')
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

    public static function getTargetsFormSchema(): array
    {
        return [
            Forms\Components\Group::make()
                ->schema([
                    Forms\Components\TextInput::make('nama')
                        ->required()
                        ->label('Nama Target')
                        ->maxLength(255)
                        ->distinct(),
                    Forms\Components\RichEditor::make('deskripsi')
                        ->toolbarButtons([
                            'redo',
                            'undo',
                            'bulletList',
                            'orderedList',
                        ]),
                ]),
            Forms\Components\Repeater::make('kurikulumKegiatans')
                ->relationship()
                ->required()
                ->schema(
                    static::getKegiatansFormSchema()
                )
                ->orderColumn('urutan')
                ->label('Kegiatan')
                ->itemLabel(fn (array $state): ?string => $state['nama'] ?? null)
                ->collapsed()
                ->cloneable()
                ->live()
                ->deleteAction(
                    fn (Action $action) => $action->requiresConfirmation(),
                )
                ->addAction(
                    fn (Action $action) => $action
                        ->label('Tambahkan Kegiatan')
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

    public static function getKegiatansFormSchema(): array
    {
        return [
            Forms\Components\TextArea::make('nama')
                ->required()
                ->label('Nama Kegiatan')
                ->autosize()
                ->distinct(),
            Forms\Components\Repeater::make('kurikulumIndikators')
                ->relationship()
                ->required()
                ->simple(
                    static::getIndikatorsFormSchema()
                )
                ->orderColumn('urutan')
                ->label('Indikator')
                ->cloneable()
                ->addAction(
                    fn (Action $action) => $action
                        ->label('Tambahkan Indikator')
                        ->color('success')
                )
        ];
    }

    public static function getIndikatorsFormSchema(): Component
    {
        return Forms\Components\TextArea::make('nama')
            ->required()
            ->label('Nama Indikator')
            ->placeholder('Nama Indikator')
            ->autosize()
            ->distinct();
    }
}
