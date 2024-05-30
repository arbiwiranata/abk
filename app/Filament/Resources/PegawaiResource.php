<?php

namespace App\Filament\Resources;

use App\Enums\JenisKelamin;
use App\Enums\StatusPegawai;
use App\Filament\Resources\PegawaiResource\Pages;
use App\Filament\Resources\PegawaiResource\RelationManagers;
use App\Models\Pegawai;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Support\RawJs;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PegawaiResource extends Resource
{
    protected static ?string $model = Pegawai::class;

    protected static ?string $navigationGroup = 'User';

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $modelLabel = 'Pegawai';

    protected static bool $hasTitleCaseModelLabel = true;

    protected static ?string $slug = 'user/pegawai';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
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
                        Forms\Components\ToggleButtons::make('status_pegawai')
                            ->required()
                            ->live()
                            ->afterStateUpdated(function (Set $set, ?string $state) {
                                if (!in_array($state, ['cpns', 'pns', 'pppk'])) {
                                    $set('nip', null);
                                }
                            })
                            ->label('Status Pegawai')
                            ->inline()
                            ->options(StatusPegawai::class),
                        Forms\Components\TextInput::make('nip')
                            ->length(18)
                            ->required(fn (Get $get): bool => in_array($get('status_pegawai'), ['cpns', 'pns', 'pppk']))
                            ->disabled(fn (Get $get): bool => !in_array($get('status_pegawai'), ['cpns', 'pns', 'pppk']))
                            ->mask('999999999999999999')
                            ->label('NIP')
                            ->helperText('Nomor Identitas Pegawai Negeri Sipil'),
                        Forms\Components\DatePicker::make('tmt_masuk')
                            ->native(false)
                            ->closeOnDateSelection()
                            ->maxDate(now())
                            ->displayFormat('d-m-Y')
                            ->placeholder('dd-mm-yyyy')
                            ->label('TMT Masuk')
                            ->suffixIcon('heroicon-m-calendar-days'),
                        Forms\Components\Select::make('jabatans')
                            ->required()
                            ->multiple()
                            ->relationship(titleAttribute: 'nama')
                            ->searchable()
                            ->preload()
                            ->label('Jabatan'),
                        Forms\Components\Select::make('atasan_id')
                            ->relationship(name: 'atasan', titleAttribute: 'nama', ignoreRecord: true)
                            ->searchable(['nama', 'nip', 'nik'])
                            ->searchPrompt('Cari pegawai berdasarkan nama, NIP, atau NIK')
                            ->preload()
                            ->label('Atasan'),
                        Forms\Components\ToggleButtons::make('jenis_kelamin')
                            ->required()
                            ->label('Jenis Kelamin')
                            ->inline()
                            ->options(JenisKelamin::class),
                        Forms\Components\TextInput::make('tempat_lahir')
                            ->maxLength(255)
                            ->label('Tempat Lahir'),
                        Forms\Components\DatePicker::make('tanggal_lahir')
                            ->native(false)
                            ->closeOnDateSelection()
                            ->maxDate(now())
                            ->displayFormat('d-m-Y')
                            ->placeholder('dd-mm-yyyy')
                            ->label('Tanggal Lahir')
                            ->suffixIcon('heroicon-m-calendar-days'),
                        Forms\Components\TextInput::make('nomor_hp')
                            ->minLength(10)
                            ->maxLength(13)
                            ->mask('0999999999999')
                            ->label('Nomor HP'),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->maxLength(255),
                        Forms\Components\FileUpload::make('foto')
                            ->directory('pegawai/foto')
                            ->image()
                            ->maxSize(1024)
                            ->helperText('Foto harus berupa format jpg, jpeg, png (maks. 1 MB)'),
                        Forms\Components\Group::make()
                            ->schema([
                                Forms\Components\Toggle::make('is_admin')
                                    ->required()
                                    ->inline(false)
                                    ->default(false)
                                    ->label('Admin'),
                                Forms\Components\Toggle::make('is_aktif')
                                    ->required()
                                    ->inline(false)
                                    ->default(true)
                                    ->label('Aktif')
                                    ->hiddenOn('create'),
                            ])
                            ->columns(2)
                    ])
                    ->columns(2)
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
                Tables\Columns\TextColumn::make('status_pegawai')
                    ->badge()
                    ->label('Status Pegawai'),
                Tables\Columns\TextColumn::make('jabatans.nama')
                    ->badge()
                    ->label('Jabatan'),
                Tables\Columns\TextColumn::make('atasan.nama'),
                Tables\Columns\IconColumn::make('is_admin')
                    ->boolean()
                    ->label('Admin'),
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
            'index' => Pages\ListPegawais::route('/'),
            'create' => Pages\CreatePegawai::route('/create'),
            'edit' => Pages\EditPegawai::route('/{record}/edit'),
        ];
    }
}
