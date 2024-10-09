<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationGroup = 'Öğrenci İşlemleri -1 ';
    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2)
                    ->schema([
                        FileUpload::make('profile_pictures')
                            ->label('Profil Resmi')
                            ->image()
                            ->required()
                            ->saveUploadedFileUsing(function (TemporaryUploadedFile $file, $set) {
                                $set('profile_picture', base64_encode(file_get_contents($file->getRealPath())));
                            })
                            ->dehydrated(false),
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
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('profile_picture')
                    ->label('Profil Resmi')
                    ->circular(),
                TextColumn::make('first_name')
                    ->label('Ad')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('last_name')
                    ->label('Soyad')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('E-posta')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('student_number')
                    ->label('Öğrenci No')
                    ->sortable(),
                TextColumn::make('city')
                    ->label('Şehir')
                    ->sortable(),
                TextColumn::make('district')
                    ->label('İlçe')
                    ->sortable(),
                TextColumn::make('school_name')
                    ->label('Okul Adı')
                    ->sortable(),
            ])
            ->filters([
                // İsteğe bağlı filtreler ekleyebilirsiniz
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            DonationStatsOverview::class,
        ];
    }

}
