<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Filament\Resources\StudentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateStudent extends CreateRecord
{
    protected static string $resource = StudentResource::class;


    protected function getRedirectUrl(): string
    {
        // Oluşturma işleminden sonra yönlendirilmek istediğiniz URL'yi buraya yazın
        return $this->getResource()::getUrl('index'); // Liste sayfasına geri döner
    }
}
