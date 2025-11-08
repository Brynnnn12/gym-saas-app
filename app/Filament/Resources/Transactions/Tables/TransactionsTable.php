<?php

namespace App\Filament\Resources\Transactions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class TransactionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('midtrans_order_id')
                    ->searchable()
                    ->label('Order ID'),

                TextColumn::make('member.name')
                    ->searchable()
                    ->label('Member'),

                TextColumn::make('plan.name')
                    ->label('Paket'),

                TextColumn::make('amount')
                    ->money('IDR')
                    ->sortable()
                    ->label('Jumlah'),

                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'pending' => 'Pending',
                        'paid' => 'Berhasil',
                        'failed' => 'Gagal',
                        'cancelled' => 'Dibatalkan',
                        default => $state,
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'warning',
                        'paid' => 'success',
                        'failed' => 'danger',
                        'cancelled' => 'gray',
                        default => 'info',
                    })
                    ->label('Status'),

                TextColumn::make('payment_method')
                    ->searchable()
                    ->label('Metode Pembayaran')
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->label('Tanggal'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Berhasil',
                        'failed' => 'Gagal',
                        'cancelled' => 'Dibatalkan',
                    ])
                    ->label('Filter Status'),
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
