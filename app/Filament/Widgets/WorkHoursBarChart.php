<?php

namespace App\Filament\Widgets;

use App\Models\Timesheet;
use Filament\Widgets\ChartWidget;

class WorkHoursBarChart extends ChartWidget
{
    protected static ?int $sort = 1;

    protected ?string $heading = 'Working Hours - Last 14 Days';

    protected ?string $description = 'Daily total hours logged as Work.';

    protected ?string $pollingInterval = '60s';

    protected int | string | array $columnSpan = 'full';

    protected ?string $maxHeight = '320px';

    protected function getData(): array
    {
        $startDate = now()->startOfDay()->subDays(13);
        $endDate = now()->endOfDay();

        $minutesByDay = Timesheet::query()
            ->selectRaw('DATE(day_in) as day, SUM(GREATEST(TIMESTAMPDIFF(MINUTE, day_in, day_out), 0)) as minutes')
            ->where('type', 'Work')
            ->whereBetween('day_in', [$startDate, $endDate])
            ->groupBy('day')
            ->orderBy('day')
            ->pluck('minutes', 'day');

        $labels = [];
        $hours = [];

        for ($i = 0; $i < 14; $i++) {
            $day = $startDate->copy()->addDays($i);
            $dayKey = $day->toDateString();

            $labels[] = $day->format('d M');
            $hours[] = round(((int) ($minutesByDay[$dayKey] ?? 0)) / 60, 2);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Hours',
                    'data' => $hours,
                    'backgroundColor' => 'rgba(22, 163, 74, 0.75)',
                    'borderColor' => 'rgb(22, 163, 74)',
                    'borderWidth' => 1,
                    'borderRadius' => 6,
                    'borderSkipped' => false,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getOptions(): array
    {
        return [
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                ],
                'x' => [
                    'grid' => [
                        'display' => false,
                    ],
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
