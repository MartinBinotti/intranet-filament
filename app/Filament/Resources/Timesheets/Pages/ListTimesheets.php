<?php

namespace App\Filament\Resources\Timesheets\Pages;

use App\Filament\Resources\Timesheets\TimesheetResource;
use App\Models\Timesheet;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListTimesheets extends ListRecords
{
    protected static string $resource = TimesheetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('startWorking')
                ->label('Start working')
                ->icon('heroicon-m-play')
                ->color('success')
                ->disabled(fn (): bool => ! Auth::user()?->calendars()->exists())
                ->tooltip('Assign a calendar in Employers > Edit user first.')
                ->modalHeading('Start working')
                ->modalSubmitActionLabel('Start')
                ->form($this->getQuickStartForm())
                ->action(fn (array $data) => $this->createQuickTimesheet('Work', $data['calendar_id'] ?? null)),
            Action::make('startPause')
                ->label('Start pause')
                ->icon('heroicon-m-pause')
                ->color('info')
                ->disabled(fn (): bool => ! Auth::user()?->calendars()->exists())
                ->tooltip('Assign a calendar in Employers > Edit user first.')
                ->modalHeading('Start pause')
                ->modalSubmitActionLabel('Start')
                ->form($this->getQuickStartForm())
                ->action(fn (array $data) => $this->createQuickTimesheet('Pause', $data['calendar_id'] ?? null)),
            CreateAction::make()
                ->label('New timesheet'),
        ];
    }

    protected function getQuickStartForm(): array
    {
        return [
            Select::make('calendar_id')
                ->label('Calendar')
                ->native(false)
                ->options(fn (): array => Auth::user()?->calendars()->pluck('name', 'calendars.id')->all() ?? [])
                ->helperText('Only calendars assigned to your user are listed.')
                ->searchable()
                ->required(),
        ];
    }

    protected function createQuickTimesheet(string $type, mixed $calendarId): void
    {
        $user = Auth::user();

        if (! $user) {
            Notification::make()
                ->title('No authenticated user was found.')
                ->danger()
                ->send();

            return;
        }

        if (! is_numeric($calendarId)) {
            Notification::make()
                ->title('Please select a valid calendar.')
                ->danger()
                ->send();

            return;
        }

        $calendarId = (int) $calendarId;

        if (! $user->calendars()->whereKey($calendarId)->exists()) {
            Notification::make()
                ->title('The selected calendar is not assigned to the authenticated user.')
                ->danger()
                ->send();

            return;
        }

        $now = now();

        Timesheet::create([
            'calendar_id' => $calendarId,
            'user_id' => $user->id,
            'type' => $type,
            'day_in' => $now,
            'day_out' => $now,
        ]);

        Notification::make()
            ->title($type === 'Work' ? 'Working started.' : 'Pause started.')
            ->success()
            ->send();
    }
}
