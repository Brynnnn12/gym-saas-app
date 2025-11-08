<?php

namespace App\Filament\Resources\Gyms\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use App\Models\Gym;

class GymsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label('Nama Gym'),

                TextColumn::make('owner.name')
                    ->searchable()
                    ->sortable()
                    ->label('Pemilik')
                    ->toggleable(),

                TextColumn::make('city')
                    ->searchable()
                    ->sortable()
                    ->label('Kota'),

                TextColumn::make('phone')
                    ->label('Telepon')
                    ->toggleable(),

                ImageColumn::make('image')
                    ->label('Foto')
                    ->circular(),

                TextColumn::make('plans_count')
                    ->counts('plans')
                    ->label('Jumlah Paket')
                    ->badge()
                    ->color('success'),

                TextColumn::make('created_at')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->label('Dibuat')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('city')
                    ->options(fn() => Gym::distinct()->pluck('city', 'city')->toArray())
                    ->label('Filter Kota'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
