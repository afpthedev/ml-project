<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Filament\Resources\StudentResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Grid;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class EditStudent extends EditRecord
{
    protected static string $resource = StudentResource::class;

    protected function getFormSchema(): array
    {
        return [
            Grid::make(2)
                ->schema([
                    // Mevcut Profil Resmini Gösterme
                    Placeholder::make('Mevcut Profil Resmi')
                        ->content(function () {
                            $record = $this->record;
                            if ($record && $record->profile_pictures) {
                                return '<img src="data:image/jpeg;base64,' . $record->profile_pictures . '" style="max-width: 200px; height: auto;">';
                            }
                            return 'Profil resmi yok.';
                        })
                        ->disableLabel()
                        ->columnSpan('full'),

                    // Yeni Profil Resmi Yükleme
                    FileUpload::make('new_profile_picture')
                        ->label('Yeni Profil Resmi')
                        ->image()
                        ->imageCropAspectRatio('1:1') // İsteğe bağlı: Resmi kare olarak kırpma
                        ->imageResizeTargetWidth('500') // İsteğe bağlı: Resmi yeniden boyutlandırma
                        ->imageResizeTargetHeight('500') // İsteğe bağlı
                        ->saveUploadedFileUsing(function (TemporaryUploadedFile $file) {
                            return base64_encode(file_get_contents($file->getRealPath()));
                        })
                        ->dehydrated()
                        ->columnSpan('full'),

                    // Diğer Form Alanları
                    TextInput::make('first_name')
                        ->label('Ad')
                        ->required(),
                    TextInput::make('last_name')
                        ->label('Soyad')
                        ->required(),
                    TextInput::make('email')
                        ->label('E-posta')
                        ->email()
                        ->unique(ignoreRecord: true)
                        ->required(),
                    TextInput::make('student_number')
                        ->label('Öğrenci Numarası')
                        ->unique(ignoreRecord: true)
                        ->required(),
                    TextInput::make('mother_name')
                        ->label('Anne Adı')
                        ->nullable(),
                    TextInput::make('father_name')
                        ->label('Baba Adı')
                        ->nullable(),
                    TextInput::make('city')
                        ->label('Şehir')
                        ->required(),
                    TextInput::make('district')
                        ->label('İlçe')
                        ->required(),
                    TextInput::make('school_name')
                        ->label('Okul Adı')
                        ->required(),
                ]),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Eğer yeni bir profil resmi yüklenmişse
        if ($this->form->getState()['profile_pictures'] instanceof TemporaryUploadedFile) {
            $data['profile_picture'] = base64_encode(file_get_contents($this->form->getState()['profile_pictures']->getRealPath()));
        }

        return $data;
    }

}
