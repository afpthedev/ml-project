<?php

namespace App\Filament\Resources\WaterWellResource\Widgets;

use App\Models\Kurban;
use App\Models\WaterWell;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestWaterWell extends BaseWidget
{
    protected static ?string $heading = 'Su Kuyusu İstatistikleri';

    protected function getTableQuery(): Builder
    {
        return WaterWell::query()->latest()->limit(5); // Son 5 kaydı getir
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('sponsor_name'),
            Tables\Columns\TextColumn::make('amount')
                ->label('sponsor_name')->searchable()->columnSpanFull(),
        ];
    }
}
