<?php

namespace App\Filament\Resources\AnakResource\RelationManagers;

use App\Models\AnakTahunAjar;
use Carbon\Carbon;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Validation\Rules\Unique;

class TahunAjarsRelationManager extends RelationManager
{
    protected static string $relationship = 'tahunAjars';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Forms\Components\Select::make('tahun_ajar_id')
                            ->required()
                            ->relationship(
                                name: 'mTahunAjar',
                                titleAttribute: 'nama',
                                modifyQueryUsing: fn (Builder $query) => $query
                                    ->where('periode_berakhir', '>=', Carbon::now())->orderBy('periode_mulai')->orderBy('periode_berakhir')
                            )
                            ->getOptionLabelFromRecordUsing(fn (Model $record): ?string => "{$record->nama} [{$record->periode_mulai?->translatedFormat('d F Y')} - {$record->periode_berakhir?->translatedFormat('d F Y')}]")
                            ->unique(ignoreRecord: true, modifyRuleUsing: function (Unique $rule) {
                                return $rule->where('anak_id', $this->getOwnerRecord()->id);
                            })
                            ->label('Tahun Ajar'),
                        Forms\Components\Select::make('jenis_layanan_id')
                            ->required()
                            ->relationship(
                                name: 'mJenisLayanan',
                                titleAttribute: 'nama',
                                modifyQueryUsing: fn (Builder $query) => $query
                                    ->orderBy('urutan')
                            )
                            ->label('Jenis Layanan'),
                        Forms\Components\Select::make('kurikulum_id')
                            ->relationship('kurikulum', 'nama')
                            ->hidden(),
                        Forms\Components\Select::make('terapis_id')
                            ->relationship('terapis', 'nama')
                            ->hidden(),
                        Forms\Components\Select::make('key_terapis_id')
                            ->relationship('keyTerapis', 'nama')
                            ->label('Key Terapis')
                            ->hidden(),
                        Forms\Components\RichEditor::make('kesimpulan')
                            ->hidden(),
                        Forms\Components\RichEditor::make('saran')
                            ->hidden(),
                        Forms\Components\Repeater::make('matriksPerencanaans')
                            ->relationship()
                            ->schema([
                                Forms\Components\Select::make('pegawai_id')
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->distinct()
                                    ->relationship('pegawai', 'nama'),
                                Forms\Components\Select::make('jabatan_id')
                                    ->required()
                                    ->relationship('jabatan', 'nama')
                                    ->live()
                                    ->afterStateUpdated(function (Set $set, ?string $state) {
                                        if (!in_array($state, ['5', '6'])) {
                                            $set('matriks_perencanaan_id', null);
                                        }
                                    }),
                                Forms\Components\Select::make('matriks_perencanaan_id')
                                    ->relationship('matriksPerencanaan', 'nama')
                                    ->searchable()
                                    ->preload()
                                    ->required(fn (Get $get): bool => in_array($get('jabatan_id'), ['5', '6']))
                                    ->disabled(fn (Get $get): bool => !in_array($get('jabatan_id'), ['5', '6']))
                                    ->label('Matriks Perencanaan'),
                            ])
                            ->label('Matriks Perencanaan')
                            ->columns(3)
                            ->columnSpanFull()
                            ->required()
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
                    ->columns(2)
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading('Tahun Ajar')
            ->recordTitle(fn (AnakTahunAjar $record): string => "{$record->mTahunAjar->nama}")
            ->columns([
                Tables\Columns\TextColumn::make('mTahunAjar.nama')
                    ->label('Tahun Ajar'),
                Tables\Columns\TextColumn::make('mJenisLayanan.nama')
                    ->label('Jenis Layanan'),
                Tables\Columns\TextColumn::make('kurikulum.nama'),
                Tables\Columns\TextColumn::make('terapis.nama'),
                Tables\Columns\TextColumn::make('keyTerapis.nama')
                    ->label('Key Terapis'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->modalHeading('Tambah Tahun Ajar')
                    ->modalWidth(MaxWidth::SixExtraLarge),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalWidth(MaxWidth::SixExtraLarge),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateDescription(null);
    }
}
