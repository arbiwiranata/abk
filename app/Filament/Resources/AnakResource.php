<?php

namespace App\Filament\Resources;

use App\Enums\JenisKelamin;
use App\Filament\Resources\AnakResource\Pages;
use App\Filament\Resources\AnakResource\RelationManagers\TahunAjarsRelationManager;
use App\Filament\Resources\MJenjangPendidikanResource\RelationManagers\MSekolahRelationManager;
use App\Models\Anak;
use App\Models\MHambatan;
use App\Models\MJenjangPendidikan;
use App\Models\MKelas;
use App\Models\MSekolah;
use Carbon\Carbon;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section as ComponentsSection;
use Filament\Infolists\Components\Split;
use Filament\Infolists\Infolist;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class AnakResource extends Resource
{
    protected static ?string $model = Anak::class;

    protected static ?string $navigationGroup = 'Intervensi';

    protected static ?string $navigationIcon = 'far-children';

    protected static ?string $modelLabel = 'Anak';

    protected static bool $hasTitleCaseModelLabel = true;

    protected static ?string $slug = 'intervensi/anak';

    protected static ?int $navigationSort = 1;

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema(static::getDataAnakFormSchema())
                    ->columns(3),
                Section::make('Data Sekolah')
                    ->schema(static::getDataSekolahFormSchema())
                    ->columns(3),
                Section::make('Data Keluarga')
                    ->schema(static::getDataKeluargaFormSchema())
                    ->columns(3),
                Section::make('Hasil Asesmen')
                    ->schema([static::getJenisAsesmensRepeater()]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\Layout\Stack::make([
                    Tables\Columns\ImageColumn::make('foto')
                        ->square()
                        ->height('12rem')
                        ->width('12rem')
                        ->alignment(Alignment::Center),
                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('nama')
                            ->searchable()
                            ->weight(FontWeight::Bold)
                            ->size(TextColumnSize::Large)
                            ->alignment(Alignment::Center)
                            ->lineClamp(1)
                            ->tooltip(fn (Model $record): string => "{$record->nama}"),
                        Tables\Columns\TextColumn::make('hambatans.nama')
                            ->badge()
                            ->alignment(Alignment::Center),
                    ]),
                ])->space(3)
            ])
            ->contentGrid([
                'sm' => 2,
                'md' => 3,
                'lg' => 4,
                'xl' => 5,
            ])
            ->paginated([
                60,
                120,
                'all',
            ])
            ->filters([
                //
            ])
            ->actions([
                // 
            ])
            ->bulkActions([
                // 
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                ComponentsSection::make()
                    ->schema([
                        Split::make([
                            ImageEntry::make('foto')
                                ->hiddenLabel()
                                ->height(150)
                                ->grow(false)
                                ->square(),
                            Group::make([
                                TextEntry::make('nama')
                                    ->hiddenLabel()
                                    ->size('text-3xl')
                                    ->weight(FontWeight::ExtraBold)
                                    ->color('info'),
                                TextEntry::make('hambatans.nama')
                                    ->hiddenLabel()
                                    ->badge()
                                    ->icon('fas-heart')
                                    ->color('danger'),
                                TextEntry::make('tanggal_lahir')
                                    ->hiddenLabel()
                                    ->date('d F Y')
                                    ->icon('fal-cake-candles')
                                    ->iconColor('primary')
                                    ->size(TextEntry\TextEntrySize::Medium)
                                    ->formatStateUsing(fn (string $state, Anak $record): string => $record->tempat_lahir . ', ' . Carbon::parse($state)->translatedFormat('d F Y') . ' - ' . $record->age . ' Tahun'),
                            ]),
                        ])->from('lg'),
                    ])
            ]);
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            Pages\ViewAnak::class,
            Pages\EditAnak::class
        ]);
    }

    public static function getRelations(): array
    {
        return [
            TahunAjarsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAnaks::route('/'),
            'create' => Pages\CreateAnak::route('/create'),
            'view' => Pages\ViewAnak::route('/{record}'),
            'edit' => Pages\EditAnak::route('/{record}/edit'),
        ];
    }

    public static function getDataAnakFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('nik')
                ->required()
                ->length(16)
                ->unique(ignoreRecord: true)
                ->mask('9999999999999999')
                ->label('NIK')
                ->helperText('Nomor Induk Kependudukan'),
            Forms\Components\TextInput::make('nama')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('tempat_lahir')
                ->required()
                ->maxLength(255)
                ->label('Tempat Lahir'),
            Forms\Components\DatePicker::make('tanggal_lahir')
                ->required()
                ->native(false)
                ->closeOnDateSelection()
                ->maxDate(now())
                ->displayFormat('d-m-Y')
                ->placeholder('dd-mm-yyyy')
                ->label('Tanggal Lahir')
                ->suffixIcon('heroicon-m-calendar-days'),
            Forms\Components\Select::make('agama_id')
                ->required()
                ->relationship('mAgama', 'nama')
                ->searchable(['nama'])
                ->preload()
                ->label('Agama'),
            Forms\Components\ToggleButtons::make('jenis_kelamin')
                ->required()
                ->label('Jenis Kelamin')
                ->inline()
                ->options(JenisKelamin::class),
            Forms\Components\FileUpload::make('foto')
                ->required()
                ->directory('anak/foto')
                ->image()
                ->maxSize(1024)
                ->helperText('Foto harus berupa format jpg, jpeg, png (maks. 1 MB)'),
            Forms\Components\Select::make('mHambatans')
                ->required()
                ->multiple()
                ->relationship(titleAttribute: 'nama')
                ->options(MHambatan::groupHambatans())
                ->preload()
                ->label('Hambatan'),
            Forms\Components\Toggle::make('is_aktif')
                ->required()
                ->inline(false)
                ->default(true)
                ->label('Aktif')
                ->onColor('success')
                ->hiddenOn('create'),
        ];
    }

    public static function getDataSekolahFormSchema(): array
    {
        return [
            Forms\Components\ToggleButtons::make('is_sekolah')
                ->boolean()
                ->live()
                ->afterStateUpdated(function (Set $set, ?string $state) {
                    if (!$state) {
                        $set('jenjang_pendidikan', null);
                        $set('sekolah_id', null);
                        $set('kelas_id', null);
                        $set('nisn', null);
                    }
                })
                ->inline()
                ->default(true)
                ->label('Apakah Sudah Bersekolah?')
                ->options([
                    true => 'Ya, Sudah Bersekolah',
                    false => 'Belum Bersekolah',
                ]),
            Forms\Components\ToggleButtons::make('jenjang_pendidikan')
                ->required(fn (Get $get): bool => $get('is_sekolah'))
                ->disabled(fn (Get $get): bool => !$get('is_sekolah'))
                ->afterStateUpdated(function (Set $set, ?string $state) {
                    if ($state) {
                        $set('sekolah_id', null);
                        $set('kelas_id', null);
                    }
                    if (!in_array($state, [2, 3, 4])) {
                        $set('nisn', null);
                    }
                })
                ->live()
                ->inline()
                ->label('Jenjang Pendidikan')
                ->options(fn () => MJenjangPendidikan::get()->sortBy('urutan')->pluck('nama', 'id')),
            Forms\Components\Select::make('sekolah_label')
                ->disabled()
                ->hidden(fn (Get $get): bool => $get('is_sekolah') && $get('jenjang_pendidikan'))
                ->label('Nama Sekolah'),
            Forms\Components\Select::make('sekolah_id')
                ->required(fn (Get $get): bool => $get('is_sekolah') && $get('jenjang_pendidikan'))
                ->hidden(fn (Get $get): bool => !$get('is_sekolah') || !$get('jenjang_pendidikan'))
                ->relationship(
                    name: 'mSekolah',
                    titleAttribute: 'nama',
                    modifyQueryUsing: fn (Builder $query, Get $get) => $query->where('jenjang_pendidikan_id', $get('jenjang_pendidikan'))
                )
                ->searchable(['nama'])
                ->preload()
                ->label('Nama Sekolah')
                ->createOptionForm(fn (Get $get) => [
                    Section::make()
                        ->schema(
                            array_merge(
                                [
                                    Forms\Components\Select::make('jenjang_pendidikan_id')
                                        ->relationship('MJenjangPendidikan', 'nama')
                                        ->default($get('jenjang_pendidikan'))
                                        ->label('Jenjang Pendidikan')
                                        ->disabled()
                                ],
                                MSekolahRelationManager::getFormSchemaCustom()
                            )
                        )
                        ->columns(2)
                ])
                ->createOptionUsing(function (array $data, Get $get): int {
                    $data['jenjang_pendidikan_id'] = $get('jenjang_pendidikan');
                    return MSekolah::create($data)->getKey();
                })
                ->createOptionModalHeading('Buat Sekolah'),
            Forms\Components\Select::make('kelas_id')
                ->required(fn (Get $get): bool => $get('is_sekolah') && $get('jenjang_pendidikan'))
                ->disabled(fn (Get $get): bool => !$get('is_sekolah') || !$get('jenjang_pendidikan'))
                ->relationship(
                    name: 'mKelas',
                    titleAttribute: 'nama',
                    modifyQueryUsing: fn (Builder $query, Get $get) => $query
                        ->where('jenjang_pendidikan_id', $get('jenjang_pendidikan'))
                        ->orderBy('urutan')
                )
                ->label('Kelas'),
            Forms\Components\TextInput::make('nisn')
                ->required(fn (Get $get): bool => $get('is_sekolah') && in_array($get('jenjang_pendidikan'), [2, 3, 4]))
                ->disabled(fn (Get $get): bool => !$get('is_sekolah') || !in_array($get('jenjang_pendidikan'), [2, 3, 4]))
                ->length(10)
                ->unique(ignoreRecord: true)
                ->mask('9999999999')
                ->label('NISN')
                ->helperText('Nomor Induk Siswa Nasional'),
        ];
    }

    public static function getDataKeluargaFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('nomor_kk')
                ->required()
                ->length(16)
                ->unique(ignoreRecord: true)
                ->mask('9999999999999999')
                ->label('Nomor KK')
                ->helperText('Nomor Kartu Keluarga'),
            Forms\Components\TextInput::make('nama_ayah')
                ->required()
                ->maxLength(255)
                ->label('Nama Ayah'),
            Forms\Components\TextInput::make('nama_ibu')
                ->required()
                ->maxLength(255)
                ->label('Nama Ibu'),
            Forms\Components\Textarea::make('alamat_rumah')
                ->required()
                ->label('Alamat Rumah'),
            Forms\Components\Textarea::make('alamat_domisili')
                ->label('Alamat Domisili')
                ->live(),
            Forms\Components\TextInput::make('nomor_hp')
                ->required()
                ->minLength(10)
                ->maxLength(13)
                ->mask('0999999999999')
                ->label('Nomor HP'),
            Forms\Components\TextInput::make('email')
                ->email()
                ->required()
                ->maxLength(255),
            Forms\Components\FileUpload::make('file_kk')
                ->required()
                ->directory('anak/kk')
                ->acceptedFileTypes(['application/pdf'])
                ->maxSize(1024)
                ->downloadable()
                ->label('File KK')
                ->helperText('File harus berupa format PDF (maks. 1 MB)'),
            Forms\Components\FileUpload::make('file_ktp_orang_tua')
                ->required()
                ->directory('anak/ktp_ortu')
                ->acceptedFileTypes(['application/pdf'])
                ->maxSize(1024)
                ->downloadable()
                ->label('File KTP Orang Tua')
                ->helperText('File harus berupa format PDF (maks. 1 MB)'),
            Forms\Components\FileUpload::make('file_surat_domisili')
                ->required(fn (Get $get): bool => !!$get('alamat_domisili'))
                ->directory('anak/domisili')
                ->acceptedFileTypes(['application/pdf'])
                ->maxSize(1024)
                ->downloadable()
                ->label('File Surat Domisili')
                ->helperText('File harus berupa format PDF (maks. 1 MB)'),
        ];
    }

    public static function getJenisAsesmensRepeater(): Repeater
    {
        return Repeater::make('jenisAsesmens')
            ->relationship()
            ->schema([
                Forms\Components\Select::make('jenis_asesmen_id')
                    ->required()
                    ->relationship('jenisAsesmen', 'nama')
                    ->createOptionForm([
                        Section::make()
                            ->schema(MJenisAsesmenResource::getFormSchemaCustom())
                    ])
                    ->createOptionModalHeading('Buat Jenis Asesmen')
                    ->searchable()
                    ->preload()
                    ->distinct()
                    ->label('Jenis Asesmen'),
                Forms\Components\FileUpload::make('file')
                    ->required()
                    ->directory('anak/asesmen')
                    ->acceptedFileTypes(['application/pdf'])
                    ->maxSize(1024)
                    ->downloadable()
                    ->label('File Asesmen')
                    ->helperText('File harus berupa format PDF (maks. 1 MB)'),
                Forms\Components\RichEditor::make('keterangan')
                    ->columnSpanFull(),
            ])
            ->orderColumn('urutan')
            ->hiddenLabel()
            ->itemLabel(fn (array $state): ?string => $state['jenisAsesmen.nama'] ?? null)
            ->cloneable()
            ->live()
            ->deleteAction(
                fn (Action $action) => $action->requiresConfirmation(),
            )
            ->addAction(
                fn (Action $action) => $action
                    ->label('Tambahkan Hasil Asesmen')
                    ->color('success')
            )
            ->columns(2);
    }
}
