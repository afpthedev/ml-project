<?php

namespace App\Filament\Resources\OrphanSupportResource\Pages;

use App\Filament\Resources\OrphanSupportResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOrphanSupport extends EditRecord
{
    protected static string $resource = OrphanSupportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
