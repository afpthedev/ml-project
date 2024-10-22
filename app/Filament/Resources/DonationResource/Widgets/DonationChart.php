<?php

namespace App\Filament\Resources\DonationResource\Widgets;

use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;
use App\Models\Donation;
use App\Models\Kurban;

class DonationChart extends ChartWidget
{
    protected static ?string $heading = 'Tüm Bağış İstatistikleri';

    protected function getData(): array
    {
        // Donation verilerini çekiyoruz
        $donationData = Trend::model(Donation::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->sum('amount');

        // Kurban verilerini çekiyoruz
        $kurbanData = Trend::model(Kurban::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->sum('amount');

        // Örnek olarak başka bir tablodan ürün verilerini çekiyoruz


        return [
            'datasets' => [
                [
                    'label' => 'Monthly Donations',
                    'data' => $donationData->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'borderWidth' => 1,
                ],
                [
                    'label' => 'Kurban Donations',
                    'data' => $kurbanData->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                    'borderColor' => 'rgba(255, 99, 132, 1)',
                    'borderWidth' => 1,
                ],

            ],
            'labels' => $donationData->map(fn (TrendValue $value) => $value->date), // Ayları göstermek için
        ];
    }

    protected function getType(): string
    {
        return 'bar'; // Sütun grafiği olarak ayarlıyoruz
    }
}
