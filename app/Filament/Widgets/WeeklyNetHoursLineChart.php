<?php

namespace App\Filament\Widgets;

use App\Models\Timesheet;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class WeeklyNetHoursLineChart extends ChartWidget
{
    protected static ?int $sort = 3;

    protected ?string $heading = 'Weekly Net Hours - Last 8 Weeks';

    protected ?string $description = 'Net hours = Work - Pause.';

    protected ?string $pollingInterval = '60s';

    protected int | string | array $columnSpan = 1;

    protected ?string $maxHeight = '320px';

    protected function getData(): array
    {
        $weekStart = now()->startOfWeek()->subWeeks(7)->startOfDay();
        $weekEnd = now()->endOfDay();

        $rows = Timesheet::query()
            ->select(['type', 'day_in', 'day_out'])
            ->whereBetween('day_in', [$weekStart, $weekEnd])
            ->get();

        $minutesByWeek = [];

        foreach ($rows as $row) {
            if (! $row->day_in || ! $row->day_out) {
                continue;
            }

            $in = Carbon::parse($row->day_in);
            $out = Carbon::parse($row->day_out);
            $minutes = max(0, $in->diffInMinutes($out, false));
            $sign = match ($row->type) {
                'Work' => 1,
                'Pause' => -1,
                default => 0,
            };

            $key = $in->copy()->startOfWeek()->toDateString();
            $minutesByWeek[$key] = ($minutesByWeek[$key] ?? 0) + ($minutes * $sign);
        }

        $labels = [];
        $hours = [];

        for ($i = 0; $i < 8; $i++) {
            $start = $weekStart->copy()->addWeeks($i)->startOfWeek();
            $key = $start->toDateString();

            $labels[] = sprintf(
                'W%s (%s)',
                $start->format('W'),
                $start->format('d M')
            );
            $hours[] = round((($minutesByWeek[$key] ?? 0) / 60), 2);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Net hours',
                    'data' => $hours,
                    'borderColor' => 'rgb(14, 165, 233)',
                    'backgroundColor' => 'rgba(14, 165, 233, 0.18)',
                    'fill' => true,
                    'tension' => 0.35,
                    'pointRadius' => 3,
                    'pointHoverRadius' => 5,
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
        return 'line';
    }
}
