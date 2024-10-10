<?php

namespace App\Filament\Resources\KurbanResource\Pages;

use Filament\Imports\KurbanImport;
use App\Filament\Resources\KurbanResource;
use App\Filament\Resources\KurbanResource\Widgets\KurbanStatsOverview;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\ImportAction;

class ListKurbans extends ListRecords
{
    protected static string $resource = KurbanResource::class;
    protected function getActions(): array
    {
        return [
            ImportAction::make()
                ->label('CSV Import')
                ->modalHeading('Import Kurban Donations from CSV')
                ->importer(KurbanImport::class),
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            KurbanStatsOverview::class,
        ];
    }

}
