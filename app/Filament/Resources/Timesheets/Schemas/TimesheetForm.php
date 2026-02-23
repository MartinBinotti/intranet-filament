<?php

namespace App\Filament\Resources\Timesheets\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TimesheetForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('calendar_id')
                    ->required()
                    ->numeric(),
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                Select::make('type')
                    ->options(['Work' => 'Work', 'pause' => 'Pause'])
                    ->default('Work')
                    ->required(),
                DatePicker::make('day_in')
                    ->required(),
                DatePicker::make('day_out')
                    ->required(),
            ]);
    }
}
