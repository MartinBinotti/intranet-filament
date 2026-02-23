<?php

namespace App\Filament\Widgets;

use App\Models\Holiday;
use App\Models\Timesheet;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class DashboardStatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 0;

    protected ?string $heading = 'Daily Snapshot';

    protected ?string $description = 'Quick indicators for today.';

    protected ?string $pollingInterval = '60s';

    protected function getStats(): array
    {
        $todayStart = now()->startOfDay();
        $todayEnd = now()->endOfDay();
        $yesterdayStart = now()->subDay()->startOfDay();
        $yesterdayEnd = now()->subDay()->endOfDay();

        $todayWorkMinutes = $this->getWorkMinutesBetween($todayStart, $todayEnd);
        $yesterdayWorkMinutes = $this->getWorkMinutesBetween($yesterdayStart, $yesterdayEnd);

        $todayTimesheets = Timesheet::query()
            ->whereBetween('day_in', [$todayStart, $todayEnd])
            ->count();

        $yesterdayTimesheets = Timesheet::query()
            ->whereBetween('day_in', [$yesterdayStart, $yesterdayEnd])
            ->count();

        $pendingHolidays = Holiday::query()
            ->where('type', 'pending')
            ->count();

        return [
            Stat::make('Work Hours Today', number_format($todayWorkMinutes / 60, 2) . ' h')
                ->description('Yesterday: ' . number_format($yesterdayWorkMinutes / 60, 2) . ' h')
                ->descriptionIcon('heroicon-m-clock')
                ->color('success')
                ->chart($this->getWorkHoursTrend(7)),
            Stat::make('Timesheets Today', (string) $todayTimesheets)
                ->description("Yesterday: {$yesterdayTimesheets}")
                ->descriptionIcon('heroicon-m-document-text')
                ->color('info')
                ->chart($this->getTimesheetTrend(7)),
            Stat::make('Pending Holidays', (string) $pendingHolidays)
                ->description('Starts in next 7 days')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('warning')
                ->chart($this->getUpcomingPendingTrend(7)),
        ];
    }

    protected function getWorkMinutesBetween(Carbon $start, Carbon $end): int
    {
        return (int) Timesheet::query()
            ->where('type', 'Work')
            ->whereBetween('day_in', [$start, $end])
            ->selectRaw('SUM(GREATEST(TIMESTAMPDIFF(MINUTE, day_in, day_out), 0)) as minutes')
            ->value('minutes');
    }

    /**
     * @return array<float>
     */
    protected function getWorkHoursTrend(int $days): array
    {
        $startDate = now()->startOfDay()->subDays($days - 1);
        $endDate = now()->endOfDay();

        $minutesByDay = Timesheet::query()
            ->where('type', 'Work')
            ->whereBetween('day_in', [$startDate, $endDate])
            ->selectRaw('DATE(day_in) as day, SUM(GREATEST(TIMESTAMPDIFF(MINUTE, day_in, day_out), 0)) as minutes')
            ->groupBy('day')
            ->pluck('minutes', 'day');

        $series = [];

        for ($i = 0; $i < $days; $i++) {
            $dayKey = $startDate->copy()->addDays($i)->toDateString();
            $series[] = round(((int) ($minutesByDay[$dayKey] ?? 0)) / 60, 2);
        }

        return $series;
    }

    /**
     * @return array<float>
     */
    protected function getTimesheetTrend(int $days): array
    {
        $startDate = now()->startOfDay()->subDays($days - 1);
        $endDate = now()->endOfDay();

        $countsByDay = Timesheet::query()
            ->whereBetween('day_in', [$startDate, $endDate])
            ->selectRaw('DATE(day_in) as day, COUNT(*) as total')
            ->groupBy('day')
            ->pluck('total', 'day');

        $series = [];

        for ($i = 0; $i < $days; $i++) {
            $dayKey = $startDate->copy()->addDays($i)->toDateString();
            $series[] = (float) ((int) ($countsByDay[$dayKey] ?? 0));
        }

        return $series;
    }

    /**
     * @return array<float>
     */
    protected function getUpcomingPendingTrend(int $days): array
    {
        $startDate = now()->startOfDay();
        $endDate = now()->endOfDay()->addDays($days - 1);

        $countsByDay = Holiday::query()
            ->where('type', 'pending')
            ->whereBetween('day', [$startDate->toDateString(), $endDate->toDateString()])
            ->selectRaw('DATE(day) as day, COUNT(*) as total')
            ->groupBy('day')
            ->pluck('total', 'day');

        $series = [];

        for ($i = 0; $i < $days; $i++) {
            $dayKey = $startDate->copy()->addDays($i)->toDateString();
            $series[] = (float) ((int) ($countsByDay[$dayKey] ?? 0));
        }

        return $series;
    }
}
