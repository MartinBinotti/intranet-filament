<?php

namespace App\Filament\Resources\Holidays\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class HolidayForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('calendar_id')
                    ->label('Calendar')
                    ->relationship(name: 'calendar', titleAttribute: 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('user_id')
                    ->label('User')
                    ->relationship(name: 'user', titleAttribute: 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                DatePicker::make('day')
                    ->label('Vacation Start Day')
                    ->required(),
                Select::make('type')
                    ->native(false)
                    ->options([
                        'rejected' => 'Decline',
                        'pending' => 'Pending',
                        'aproved' => 'Aproved',
                    ])
                    ->default('pending')
                    ->required(),
            ]);
    }
}
