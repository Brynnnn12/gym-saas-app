<?php

namespace App\Filament\Resources\Transactions\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TransactionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('member_id')
                    ->relationship('member', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->label('Member'),

                Select::make('plan_id')
                    ->relationship('plan', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->label('Paket'),

                TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->prefix('Rp')
                    ->label('Jumlah'),

                Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Berhasil',
                        'failed' => 'Gagal',
                        'cancelled' => 'Dibatalkan',
                    ])
                    ->default('pending')
                    ->required()
                    ->label('Status'),

                TextInput::make('midtrans_order_id')
                    ->maxLength(255)
                    ->label('Order ID Midtrans'),

                TextInput::make('midtrans_transaction_id')
                    ->maxLength(255)
                    ->label('Transaction ID Midtrans'),

                TextInput::make('payment_method')
                    ->maxLength(255)
                    ->label('Metode Pembayaran'),

                DateTimePicker::make('paid_at')
                    ->label('Tanggal Pembayaran')
                    ->native(false),

                DateTimePicker::make('expired_at')
                    ->label('Tanggal Kadaluarsa')
                    ->native(false),
            ]);
    }
}
