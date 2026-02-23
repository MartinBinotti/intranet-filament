<?php

namespace App\Filament\Resources\Timesheets;

use App\Filament\Resources\Timesheets\Pages\CreateTimesheet;
use App\Filament\Resources\Timesheets\Pages\EditTimesheet;
use App\Filament\Resources\Timesheets\Pages\ListTimesheets;
use App\Filament\Resources\Timesheets\Schemas\TimesheetForm;
use App\Filament\Resources\Timesheets\Tables\TimesheetsTable;
use App\Models\Timesheet;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DateTimePicker;
use UnitEnum;

class TimesheetResource extends Resource
{
    protected static ?string $model = Timesheet::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-s-table-cells';
    protected static string|UnitEnum|null $navigationGroup = 'Employees Management';
    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return TimesheetForm::configure($schema)
            ->schema([
                Select::make('calendar_id')
                    ->relationship(name: 'calendar', titleAttribute: 'name')
                    ->required(),

                Select::make('user_id')
                    ->relationship(name: 'user', titleAttribute: 'name')
                    ->required(),

                Select::make('type')
                    ->options([
                        'Work' => 'Work',
                        'Pause' => 'Pause',
                    ])
                    ->required(),

                DateTimePicker::make('day_in')
                    ->required(),

                DateTimePicker::make('day_out')
                    ->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return TimesheetsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTimesheets::route('/'),
            'create' => CreateTimesheet::route('/create'),
            'edit' => EditTimesheet::route('/{record}/edit'),
        ];
    }
}
