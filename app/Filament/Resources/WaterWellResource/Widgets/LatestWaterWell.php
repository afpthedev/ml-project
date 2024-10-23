<?php

namespace App\Filament\Resources\WaterWellResource\Widgets;

use App\Models\Kurban;
use App\Models\WaterWell;
use Filament\Widgets\ChartWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestWaterWell extends ChartWidget
{
    protected static ?string $heading = 'Kurban Bağış Oranları';

    protected function getData(): array
    {
        // Kurban verilerini çekiyoruz, banka ve nakit yüzdeleri hesaplanacak
        $totalKurbanCount = Kurban::count();
        $bankPaymentsCount = Kurban::where('payment_type', 'Banka')->count();
        $cashPaymentsCount = Kurban::where('payment_type', 'Nakit')->count();

        // Su Kuyusu bağış verilerini çekiyoruz
        $latestWaterWells = WaterWell::latest()->limit(5)->get();

        return [
            'datasets' => [
                [
                    'label' => 'Bağış Türleri Yüzde',
                    'data' => [
                        $bankPaymentsCount / $totalKurbanCount * 100, // Banka oranı
                        $cashPaymentsCount / $totalKurbanCount * 100, // Nakit oranı
                    ],
                    'backgroundColor' => ['rgba(54, 162, 235, 0.2)', 'rgba(255, 99, 132, 0.2)'],
                    'borderColor' => ['rgba(54, 162, 235, 1)', 'rgba(255, 99, 132, 1)'],
                    'borderWidth' => 1,
                ],
            ],
            'labels' => ['Banka Ödeme', 'Nakit Ödeme'],
        ];
    }

    protected function getType(): string
    {
        return 'line'; // Pie chart kullanıyoruz
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => true, // Grafik boyutlarını serbest bırakıyoruz

        ];
    }
}
