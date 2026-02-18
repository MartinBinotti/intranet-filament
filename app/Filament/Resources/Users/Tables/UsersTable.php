<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('country.name')
                    ->label('Country')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('state.name')
                    ->label('State')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('city.name')
                    ->label('City')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('address')
                    ->label('Address')
                    ->searchable()
                    ->toggleable()
                    ->limit(30),
                TextColumn::make('postal_code')
                    ->label('Postal Code')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
