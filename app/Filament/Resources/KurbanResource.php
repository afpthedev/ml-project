<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KurbanResource\Pages;
use App\Models\Kurban;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;

class KurbanResource extends Resource
{
    protected static ?string $model = Kurban::class;

    protected static ?string $navigationGroup = 'Bağış İşlemleri';
    protected static ?string $navigationIcon = 'heroicon-o-bolt';
    protected static ?string $navigationLabel = 'Kurban Bağışları';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('donor_name')->label('Bağışçı Adı')->required(),
                TextInput::make('animal_type')->label('Kurban Türü')->required(),
                DatePicker::make('sacrifice_date')->label('Kurban Kesim Tarihi')->required(),
                TextInput::make('amount')
                    ->label('Bağış Miktarı')
                    ->default(50) // Varsayılan değer 50
                    ->disabled(), // Kullanıcı bu alanı değiştiremesin
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('donor_name')->label('Bağışçı Adı')->sortable()->searchable(),
                TextColumn::make('animal_type')->label('Kurban Türü')->sortable(),
                TextColumn::make('sacrifice_date')->label('Kurban Kesim Tarihi')->sortable(),
                TextColumn::make('amount')->label('Bağış Miktarı')->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'Ödendi' => 'Ödendi',
                        'Ödenmedi' => 'Ödenmedi',
                    ])], layout: FiltersLayout::Modal)
            ->actions([Tables\Actions\ViewAction::make(), Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }



    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKurbans::route('/'),
            'create' => Pages\CreateKurban::route('/create'),
            'edit' => Pages\EditKurban::route('/{record}/edit'),
        ];
    }
}
