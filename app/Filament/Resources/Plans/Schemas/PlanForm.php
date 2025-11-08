<?php

namespace App\Filament\Resources\Plans\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class PlanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('gym_id')
                    ->relationship('gym', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->label('Gym'),

                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label('Nama Paket'),

                Textarea::make('description')
                    ->rows(3)
                    ->columnSpanFull()
                    ->label('Deskripsi Paket'),

                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('Rp')
                    ->label('Harga')
                    ->helperText('Harga dalam Rupiah'),

                TextInput::make('duration_months')
                    ->required()
                    ->numeric()
                    ->suffix('bulan')
                    ->label('Durasi')
                    ->minValue(1)
                    ->maxValue(24),

                Toggle::make('is_active')
                    ->label('Status Aktif')
                    ->default(true),
            ]);
    }
}
