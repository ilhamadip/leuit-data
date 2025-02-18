<?php

namespace App\Filament\Resources\SekolahResource\Pages;

use App\Filament\Resources\SekolahResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSekolahs extends ListRecords
{
    protected static string $resource = SekolahResource::class;
    protected static ?string $title = 'Data Sekolah';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label("Buat Baru")
        ];
    }
}
