<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Filament\Imports\EducationSupportImporter;
use App\Filament\Impot\StudentImporter;
use App\Filament\Resources\StudentResource;
use Filament\Actions;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;

class ListStudents extends ListRecords
{
    protected static string $resource = StudentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ImportAction::make()
                ->label('CSV Import')
                ->modalHeading('Import Donations from CSV')
                ->importer(StudentImporter::class),
            Actions\CreateAction::make(),
        ];
    }


}
