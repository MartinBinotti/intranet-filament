<?php

namespace App\Filament\Resources\Countries\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class CountriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('iso2')
                    ->searchable(),
                TextColumn::make('iso3')
                    ->searchable(),
                TextColumn::make('numeric_code')
                    ->searchable(),
                TextColumn::make('phonecode')
                    ->searchable(),
                TextColumn::make('capital')
                    ->searchable(),
                TextColumn::make('currency')
                    ->searchable(),
                TextColumn::make('currency_name')
                    ->searchable(),
                TextColumn::make('currency_symbol')
                    ->searchable(),
                TextColumn::make('tld')
                    ->searchable(),
                TextColumn::make('native')
                    ->searchable(),
                TextColumn::make('region')
                    ->searchable(),
                TextColumn::make('subregion')
                    ->searchable(),
                TextColumn::make('latitude')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('longitude')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('emoji')
                    ->searchable(),
                TextColumn::make('emojiU')
                    ->searchable(),
                IconColumn::make('flag')
                    ->boolean(),
                IconColumn::make('is_active')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
