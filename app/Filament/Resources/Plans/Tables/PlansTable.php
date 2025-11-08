<?php

namespace App\Filament\Resources\Plans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class PlansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('gym.name')
                    ->searchable()
                    ->sortable()
                    ->label('Gym'),

                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label('Nama Paket'),

                TextColumn::make('price')
                    ->money('IDR')
                    ->sortable()
                    ->label('Harga'),

                TextColumn::make('duration_months')
                    ->suffix(' bulan')
                    ->sortable()
                    ->label('Durasi'),

                IconColumn::make('is_active')
                    ->boolean()
                    ->label('Status'),

                TextColumn::make('subscriptions_count')
                    ->counts('subscriptions')
                    ->label('Total Member')
                    ->badge()
                    ->color('info'),

                TextColumn::make('created_at')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->label('Dibuat')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('gym_id')
                    ->relationship('gym', 'name')
                    ->label('Filter Gym'),

                TernaryFilter::make('is_active')
                    ->label('Status Aktif'),
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
