<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SekolahResource\Pages;
use App\Filament\Resources\SekolahResource\RelationManagers;
use App\Models\Sekolah;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;

class SekolahResource extends Resource
{
    protected static ?string $model = Sekolah::class;

    // Override the navigation label for singular form
    protected static ?string $navigationLabel = 'Sekolah'; // Singular form

    // Grouping
    protected static ?string $navigationGroup = 'Data Sekolah';

    protected static ?string $navigationIcon = 'heroicon-m-building-library';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\Select::make('bentuk_pendidikan')
                    ->options([
                        'TK' => 'TK',
                        'SD' => 'SD',
                        'SMP' => 'SMP',
                    ]),
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('npsn')
                    ->label("NPSN")
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('kecamatan')
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('desa')
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('rt')
                    ->label("RT")
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('rw')
                    ->label("RW")
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('alamat_lengkap')
                    ->required()
                    ->maxLength(100)
                    ->afterStateUpdated(fn ($state) => strtoupper($state))
                    ->mutateDehydratedStateUsing(fn ($state) => strtoupper($state)),
                Forms\Components\TextInput::make('lon')
                    ->label("Longitude (Lon)")
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('lat')
                    ->label("Latitude (Lat)")
                    ->numeric()
                    ->required(),
                Forms\Components\Select::make('status_data')
                    ->options([
                        'ENTRI' => 'ENTRI',
                        'PERBAIKAN' => 'PERBAIKAN',
                        'CLEAN' => 'CLEAN',
                        'DIPERBAIKI' => 'DIPERBAIKI'
                    ])
                    ->default('ENTRI'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(null)
            ->columns([
                //
                TextColumn::make('No') -> rowIndex(),
                TextColumn::make('bentuk_pendidikan') -> wrap() -> label("Bentuk") ->searchable() ->size(TextColumn\TextColumnSize::ExtraSmall),
                TextColumn::make('nama') ->wrap()->searchable() ->size(TextColumn\TextColumnSize::ExtraSmall),
                TextColumn::make('npsn') -> label("NPSN")->searchable() ->size(TextColumn\TextColumnSize::ExtraSmall),
                TextColumn::make('kecamatan')->searchable() ->size(TextColumn\TextColumnSize::ExtraSmall),
                TextColumn::make('desa')->searchable() ->size(TextColumn\TextColumnSize::ExtraSmall),
                TextColumn::make('rw')-> label("RW")->searchable() ->size(TextColumn\TextColumnSize::ExtraSmall),
                TextColumn::make('rt')-> label("RT")->searchable() ->size(TextColumn\TextColumnSize::ExtraSmall),
                TextColumn::make('alamat_lengkap') -> wrap()->searchable() ->size(TextColumn\TextColumnSize::ExtraSmall),
                TextColumn::make('koordinat')
                    ->state(fn ($record) => "{$record->lon}, {$record->lat}")
                    ->size(TextColumn\TextColumnSize::ExtraSmall)
                    ->copyable() -> copyMessage('Koordinat copied'),
                TextColumn::make('status_data')
                    ->label('Status')
                    ->searchable()
                    ->size(TextColumn\TextColumnSize::ExtraSmall)
                    ->colors(['warning' => 'ENTRI',
                              'danger' => 'PERBAIKAN',
                              'success' => 'CLEAN',
                              'blue' => 'DIPERBAIKI'])
                    ->formatStateUsing(fn (string $state) => "<span class='border border-gray-500 p-1 rounded'>$state</span>")
                    ->html()
            ])
            ->filters([
                //
                Tables\Filters\SelectFilter::make('status_data')
                ->options([
                    'ENTRI' => 'ENTRI',
                    'PEMERIKSAAN' => 'PEMERIKSAAN',
                    'CLEAN' => 'CLEAN',
                ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->striped();
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
            'index' => Pages\ListSekolahs::route('/'),
            'create' => Pages\CreateSekolah::route('/create'),
            'edit' => Pages\EditSekolah::route('/{record}/edit'),
        ];
    }


}
