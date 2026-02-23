<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),

                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),

                DateTimePicker::make('email_verified_at'),

                TextInput::make('password')
                    ->password()
                    ->required(),

                Select::make('calendars')
                    ->label('Calendars')
                    ->relationship(name: 'calendars', titleAttribute: 'name')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->native(false),

                Select::make('country_id')
                    ->label('Country')
                    ->options(Country::all()->pluck('name', 'id'))
                    ->reactive()
                    ->afterStateUpdated(function ($state, $set) {
                        $set('state_id', null);
                        $set('city_id', null);
                    })
                    ->searchable()
                    ->required(),

                Select::make('state_id')
                    ->label('State')
                    ->options(function (callable $get) {
                        $countryId = $get('country_id');

                        return $countryId ? State::where('country_id', $countryId)->pluck('name', 'id') : [];
                    })
                    ->reactive()
                    ->afterStateUpdated(fn ($state, $set) => $set('city_id', null))
                    ->searchable()
                    ->required(),

                Select::make('city_id')
                    ->label('City')
                    ->options(function (callable $get) {
                        $stateId = $get('state_id');

                        return $stateId ? City::where('state_id', $stateId)->pluck('name', 'id') : [];
                    })
                    ->searchable()
                    ->required(),

                TextInput::make('address')
                    ->label('Address')
                    ->maxLength(255),

                TextInput::make('postal_code')
                    ->label('Postal Code')
                    ->maxLength(20),
            ]);
    }
}
