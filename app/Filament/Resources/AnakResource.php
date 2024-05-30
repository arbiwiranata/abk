<?php

namespace App\Filament\Resources;

use App\Enums\JenisKelamin;
use App\Filament\Resources\AnakResource\Pages;
use App\Filament\Resources\AnakResource\RelationManagers;
use App\Filament\Resources\AnakResource\RelationManagers\TahunAjarsRelationManager;
use App\Models\Anak;
use App\Models\MHambatan;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AnakResource extends Resource
{
    protected static ?string $model = Anak::class;

    protected static ?string $navigationGroup = 'Intervensi';

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static ?string $modelLabel = 'Anak';

    protected static bool $hasTitleCaseModelLabel = true;

    protected static ?string $slug = 'intevensi/anak';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema(static::getDataAnakFormSchema())
                    ->columns(2),
                Section::make('Data Keluarga')
                    ->schema(static::getDataKeluargaFormSchema())
                    ->columns(2),
                Section::make('Hasil Asesmen')
                    ->schema([static::getJenisAsesmensRepeater()]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('foto')
                    ->circular(),
                Tables\Columns\TextColumn::make('nik')
                    ->searchable()
                    ->label('NIK'),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jenis_kelamin')
                    ->badge()
                    ->label('Jenis Kelamin'),
                Tables\Columns\TextColumn::make('nama_sekolah')
                    ->searchable()
                    ->label('Nama Sekolah'),
                Tables\Columns\TextColumn::make('kelas')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nomor_hp')
                    ->label('Nomor HP'),
                Tables\Columns\TextColumn::make('hambatans.nama')
                    ->badge()
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
            TahunAjarsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAnaks::route('/'),
            'create' => Pages\CreateAnak::route('/create'),
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
            Forms\Components\TextInput::make('nisn')
                ->required()
                ->length(10)
                ->unique(ignoreRecord: true)
                ->mask('9999999999')
                ->label('NISN')
                ->helperText('Nomor Induk Siswa Nasional'),
            Forms\Components\TextInput::make('nama_sekolah')
                ->required()
                ->maxLength(255)
                ->label('Nama Sekolah'),
            Forms\Components\TextInput::make('kelas')
                ->required()
                ->maxLength(255),
            Forms\Components\FileUpload::make('foto')
                ->required()
                ->directory('anak/foto')
                ->image()
                ->maxSize(1024)
                ->helperText('Foto harus berupa format jpg, jpeg, png (maks. 1 MB)'),
            Forms\Components\Select::make('hambatans')
                ->required()
                ->multiple()
                ->relationship(titleAttribute: 'nama')
                ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->mJenisHambatan->nama} - {$record->nama}")
                ->preload()
                ->label('Hambatan'),
            Forms\Components\Toggle::make('is_aktif')
                ->required()
                ->inline(false)
                ->default(true)
                ->label('Aktif')
                ->hiddenOn('create'),
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
                ->label('Alamat Domisili'),
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
                            ->schema(MJenisAsesmenResource::getFormSchema())
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
