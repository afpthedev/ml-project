<?php

namespace App\Filament\Resources\KirveResource\Pages;

use App\Filament\Resources\KirveResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKirves extends ListRecords
{
    protected static string $resource = KirveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
