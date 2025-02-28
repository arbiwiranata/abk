<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AnakTahunAjarResource\Pages;
use App\Filament\Resources\AnakTahunAjarResource\RelationManagers;
use App\Models\AnakTahunAjar;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Indicator;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

class AnakTahunAjarResource extends Resource
{
    protected static ?string $model = AnakTahunAjar::class;

    protected static ?string $navigationGroup = 'Intervensi';

    protected static ?string $navigationIcon = 'far-calendar-users';

    protected static ?string $modelLabel = 'Tahun Ajar';

    protected static bool $hasTitleCaseModelLabel = true;

    protected static ?string $slug = 'intervensi/tahun-ajar';

    protected static ?int $navigationSort = 1;

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Forms\Components\Select::make('tahun_ajar_id')
                            ->required()
                            // ->hiddenOn('edit')
                            ->live()
                            ->relationship(
                                name: 'mTahunAjar',
                                titleAttribute: 'nama',
                                modifyQueryUsing: fn (Builder $query) => $query
                                    ->where('periode_berakhir', '>=', Carbon::now())
                                    ->orderBy('periode_berakhir', 'desc')    
                                    ->orderBy('periode_mulai', 'desc')
                            )
                            ->default(fn () => \App\Models\MTahunAjar::whereDate('periode_mulai', '<=', Carbon::today())
                                ->whereDate('periode_berakhir', '>=', Carbon::today())
                                ->value('id')
                            )
                            ->getOptionLabelFromRecordUsing(fn (Model $record): ?string => "{$record->nama} [{$record->periode_mulai?->translatedFormat('d F Y')} - {$record->periode_berakhir?->translatedFormat('d F Y')}]")
                            ->afterStateUpdated(function (Set $set, ?string $state) {
                                if (!$state) {
                                    $set('anak_id', null);
                                }
                            })
                            ->preload()
                            ->native(false)
                            ->label('Tahun Ajar'),
                        // Forms\Components\TextInput::make('tahun_ajar_nama')
                        //     ->hiddenOn('create')
                        //     ->label('Tahun Ajar')
                        //     ->disabled()
                        //     ->dehydrated(false)
                        //     ->formatStateUsing(fn ($record) => " {$record?->mTahunAjar?->nama} [{$record?->mTahunAjar?->periode_mulai?->translatedFormat('d F Y')} - {$record?->mTahunAjar?->periode_berakhir?->translatedFormat('d F Y')}]"),
                        Forms\Components\Select::make('anak_id')
                            ->disabled(fn (Get $get): bool => !$get('tahun_ajar_id'))
                            ->relationship(
                                name: 'anak',
                                titleAttribute: 'nama',
                                modifyQueryUsing: function (Builder $query, Get $get) {
                                    $tahunAjarId = $get('tahun_ajar_id');
                                    $editingAnakId = $get('anak_id');

                                    if ($tahunAjarId) {
                                        $query->whereNotIn('anak.id', function ($subquery) use ($tahunAjarId, $editingAnakId) {
                                            $subquery->select('anak_id')
                                                ->from('anak_tahun_ajar')
                                                ->where('tahun_ajar_id', $tahunAjarId);

                                            if ($editingAnakId) {
                                                $subquery->where('anak_id', '!=', $editingAnakId);
                                            }
                                        });
                                    }
                                }
                            )
                            ->required()
                            ->searchable(['nama', 'nik'])
                            ->searchPrompt('Cari anak berdasarkan nama atau NIK')
                            ->preload()
                            ->native(false)
                            ->unique(ignoreRecord: true, modifyRuleUsing: function (Unique $rule, Get $get) {
                                return $rule->where('tahun_ajar_id', $get('tahun_ajar_id'));
                            }),
                        Forms\Components\Select::make('jenis_layanan_id')
                            ->required()
                            ->relationship(
                                name: 'mJenisLayanan',
                                titleAttribute: 'nama',
                                modifyQueryUsing: fn (Builder $query) => $query
                                    ->orderBy('urutan')
                            )
                            ->preload()
                            ->native(false)
                            ->label('Jenis Layanan'),
                        Forms\Components\Select::make('key_terapis_id')
                            ->relationship(
                                name: 'keyTerapis',
                                titleAttribute: 'nama',
                                modifyQueryUsing: fn (Builder $query) => $query
                                    ->whereHas('jabatans', fn (Builder $jabatanQuery) => 
                                        $jabatanQuery->where('kode', 'KT')
                                    )
                            )
                            ->live()
                            ->searchable(['nama', 'nip', 'nik'])
                            ->searchPrompt('Cari pegawai berdasarkan nama, NIP, atau NIK')
                            ->preload()
                            ->native(false)
                            ->label('Key Terapis'),
                        Forms\Components\Select::make('terapis_id')
                            ->relationship(
                                name: 'terapis',
                                titleAttribute: 'nama',
                                modifyQueryUsing: fn (Builder $query) => $query
                                    ->whereHas('jabatans', fn (Builder $jabatanQuery) => 
                                        $jabatanQuery->where('kode', 'T')
                                    )
                            )
                            ->searchable(['nama', 'nip', 'nik'])
                            ->searchPrompt('Cari pegawai berdasarkan nama, NIP, atau NIK')
                            ->preload()
                            ->native(false),
                        // Forms\Components\Select::make('kurikulum_id')
                        //     ->relationship('kurikulum', 'id'),
                        // Forms\Components\Textarea::make('kesimpulan')
                        //     ->columnSpanFull(),
                        // Forms\Components\Textarea::make('saran')
                        //     ->columnSpanFull(),
                        // Forms\Components\TextInput::make('status')
                        //     ->required()
                        //     ->maxLength(255)
                        //     ->default('MP'),
                        Forms\Components\Toggle::make('is_aktif')
                            ->inline(false)
                            ->default(true)
                            ->onIcon('fas-check')
                            ->offIcon('fas-xmark')
                            ->onColor('success')
                            ->offColor('danger')
                            ->label('Aktif')
                            ->hiddenOn('create'),
                    ])
                    ->columns(2),
                    Section::make('Setting Matriks Perencanaan')
                        ->schema([
                            Forms\Components\Repeater::make('matriksPerencanaans')
                                ->relationship()
                                ->schema([
                                    Forms\Components\Select::make('pegawai_id')
                                        ->required()
                                        ->searchable(['nama', 'nip', 'nik'])
                                        ->searchPrompt('Cari pegawai berdasarkan nama, NIP, atau NIK')
                                        ->preload()
                                        ->distinct()
                                        ->native(false)
                                        ->relationship('pegawai', 'nama'),
                                    Forms\Components\Select::make('jabatan_id')
                                        ->required()
                                        ->relationship('jabatan', 'nama')
                                        ->preload()
                                        ->live()
                                        ->native(false)
                                        ->afterStateUpdated(function (Set $set, ?string $state) {
                                            if (!in_array($state, ['5', '6'])) {
                                                $set('matriks_perencanaan_id', null);
                                            }
                                        }),
                                    Forms\Components\Select::make('matriks_perencanaan_id')
                                        ->relationship('matriksPerencanaan', 'nama')
                                        ->searchable()
                                        ->preload()
                                        ->native(false)
                                        ->required()
                                        ->disabled(fn (Get $get): bool => !in_array($get('jabatan_id'), ['5', '6']))
                                        ->label('Matriks Perencanaan'),
                                ])
                                ->hiddenLabel()
                                ->columns(3)
                                ->columnSpanFull()
                                ->cloneable()
                                ->live()
                                ->deleteAction(
                                    fn (Action $action) => $action->requiresConfirmation(),
                                )
                                ->addAction(
                                    fn (Action $action) => $action
                                        ->label('Tambahkan Matriks Perencanaan')
                                        ->color('success')
                                ),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('anak.foto')
                    ->circular()
                    ->label(false),
                Tables\Columns\TextColumn::make('anak.nama')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('mJenisLayanan.nama')
                    ->sortable()
                    ->label('Jenis Layanan'),
                Tables\Columns\TextColumn::make('kurikulum.nama')
                    ->sortable(),
                Tables\Columns\TextColumn::make('keyTerapis.nama')
                    ->sortable()
                    ->searchable()
                    ->label('Key Terapis'),
                Tables\Columns\TextColumn::make('terapis.nama')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable()
                    ->hidden(),
                Tables\Columns\IconColumn::make('is_aktif')
                    ->boolean()
                    ->label('Aktif'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('tahun_ajar_id')
                    ->relationship(
                        name: 'mTahunAjar',
                        titleAttribute: 'nama',
                        modifyQueryUsing: fn (Builder $query) => $query
                            ->orderBy('periode_berakhir', 'desc')    
                            ->orderBy('periode_mulai', 'desc')
                    )
                    // ->getOptionLabelFromRecordUsing(fn (Model $record): ?string => "{$record->nama} [{$record->periode_mulai?->translatedFormat('d F Y')} - {$record->periode_berakhir?->translatedFormat('d F Y')}]")
                    ->searchable()
                    ->preload()
                    ->default(fn () => \App\Models\MTahunAjar::whereDate('periode_mulai', '<=', Carbon::today())
                        ->whereDate('periode_berakhir', '>=', Carbon::today())
                        ->value('id')
                    )
                    ->native(false)
                    ->selectablePlaceholder(false)
                    // ->indicateUsing(function (array $data): ?Indicator {
                    //     return $data['value'] ? 
                    //         Indicator::make('Tahun Ajar: ' . \App\Models\MTahunAjar::find($data['value'])?->nama)
                    //             ->removable(false) :
                    //         null;
                    // })
                    ->label('Tahun Ajar'),
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
            'index' => Pages\ListAnakTahunAjars::route('/'),
            'create' => Pages\CreateAnakTahunAjar::route('/create'),
            'edit' => Pages\EditAnakTahunAjar::route('/{record}/edit'),
        ];
    }
}
