<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Holidays\HolidayResource;
use App\Models\Holiday;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class PendingHolidaysTable extends TableWidget
{
    protected static ?int $sort = 4;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Pending Holidays')
            ->description('Holiday requests waiting for review.')
            ->query(fn (): Builder => Holiday::query()
                ->with(['calendar', 'user'])
                ->where('type', 'pending')
                ->orderBy('day'))
            ->columns([
                TextColumn::make('day')
                    ->label('Start Day')
                    ->date()
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('calendar.name')
                    ->label('Calendar')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('type')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => $state === 'pending' ? 'Pending' : $state)
                    ->color('gray'),
            ])
            ->defaultSort('day')
            ->recordUrl(fn (Holiday $record): string => HolidayResource::getUrl('edit', ['record' => $record]))
            ->emptyStateHeading('No pending holidays')
            ->emptyStateDescription('Everything is approved or declined.');
    }
}
