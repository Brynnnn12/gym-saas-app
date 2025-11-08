<?php

namespace App\Filament\Resources\Subscriptions\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SubscriptionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('member_id')
                    ->required()
                    ->numeric(),
                TextInput::make('plan_id')
                    ->required()
                    ->numeric(),
                TextInput::make('transaction_id')
                    ->numeric(),
                DateTimePicker::make('started_at'),
                DateTimePicker::make('active_until'),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
