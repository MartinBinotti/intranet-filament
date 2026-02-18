<?php

namespace App\Filament\Resources\Countries\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CountryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('iso2')
                    ->required(),
                TextInput::make('iso3')
                    ->required(),
                TextInput::make('numeric_code')
                    ->default(null),
                TextInput::make('phonecode')
                    ->tel()
                    ->default(null),
                TextInput::make('capital')
                    ->default(null),
                TextInput::make('currency')
                    ->default(null),
                TextInput::make('currency_name')
                    ->default(null),
                TextInput::make('currency_symbol')
                    ->default(null),
                TextInput::make('tld')
                    ->default(null),
                TextInput::make('native')
                    ->default(null),
                TextInput::make('region')
                    ->default(null),
                TextInput::make('subregion')
                    ->default(null),
                Textarea::make('timezones')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('translations')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('latitude')
                    ->numeric()
                    ->default(null),
                TextInput::make('longitude')
                    ->numeric()
                    ->default(null),
                TextInput::make('emoji')
                    ->default(null),
                TextInput::make('emojiU')
                    ->default(null),
                Toggle::make('flag')
                    ->required(),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
