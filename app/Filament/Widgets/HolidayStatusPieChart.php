<?php

namespace App\Filament\Widgets;

use App\Models\Holiday;
use Filament\Widgets\ChartWidget;

class HolidayStatusPieChart extends ChartWidget
{
    protected static ?int $sort = 2;

    protected ?string $heading = 'Holidays by Status';

    protected ?string $description = 'Pending vs approved vs declined requests.';

    protected ?string $pollingInterval = '60s';

    protected int | string | array $columnSpan = 1;

    protected ?string $maxHeight = '320px';

    protected function getData(): array
    {
        $counts = Holiday::query()
            ->selectRaw('type, COUNT(*) as total')
            ->groupBy('type')
            ->pluck('total', 'type');

        return [
            'datasets' => [
                [
                    'label' => 'Requests',
                    'data' => [
                        (int) ($counts['pending'] ?? 0),
                        (int) ($counts['aproved'] ?? 0),
                        (int) ($counts['rejected'] ?? 0),
                    ],
                    'backgroundColor' => [
                        'rgba(107, 114, 128, 0.9)',
                        'rgba(22, 163, 74, 0.9)',
                        'rgba(220, 38, 38, 0.9)',
                    ],
                    'borderColor' => [
                        'rgb(75, 85, 99)',
                        'rgb(21, 128, 61)',
                        'rgb(185, 28, 28)',
                    ],
                    'borderWidth' => 1,
                ],
            ],
            'labels' => ['Pending', 'Aproved', 'Decline'],
        ];
    }

    protected function getOptions(): array
    {
        return [
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                    'labels' => [
                        'usePointStyle' => true,
                        'pointStyle' => 'circle',
                    ],
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
