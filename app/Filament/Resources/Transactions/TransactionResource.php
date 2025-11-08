<?php

namespace App\Filament\Resources\Transactions;

use App\Filament\Resources\Transactions\Pages\CreateTransaction;
use App\Filament\Resources\Transactions\Pages\EditTransaction;
use App\Filament\Resources\Transactions\Pages\ListTransactions;
use App\Filament\Resources\Transactions\Schemas\TransactionForm;
use App\Filament\Resources\Transactions\Tables\TransactionsTable;
use App\Models\Transaction;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'midtrans_order_id';

    protected static ?string $navigationLabel = 'Transaksi';

    protected static ?string $modelLabel = 'Transaksi';

    protected static ?string $pluralModelLabel = 'Transaksi';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return TransactionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TransactionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTransactions::route('/'),
            'create' => CreateTransaction::route('/create'),
            'edit' => EditTransaction::route('/{record}/edit'),
        ];
    }

    // Authorization Methods
    public static function canViewAny(): bool
    {
        $user = Auth::user();
        return $user->can('manage_all_transactions') || $user->can('view_all_transactions');
    }

    // Filter data berdasarkan role
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = Auth::user();

        // Super admin bisa lihat semua
        if ($user->hasRole('super_admin')) {
            return $query;
        }

        // Gym owner hanya bisa lihat transaction dari plan gym mereka
        if ($user->hasRole('gym_owner')) {
            $gymIds = $user->gyms()->pluck('id');

            return $query->whereHas('plan', function ($q) use ($gymIds) {
                $q->whereIn('gym_id', $gymIds);
            });
        }

        // Role lain tidak bisa lihat data
        return $query->whereRaw('1 = 0');
    }
}
