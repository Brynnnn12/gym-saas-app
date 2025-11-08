<?php

namespace App\Filament\Resources\Plans;

use App\Filament\Resources\Plans\Pages\CreatePlan;
use App\Filament\Resources\Plans\Pages\EditPlan;
use App\Filament\Resources\Plans\Pages\ListPlans;
use App\Filament\Resources\Plans\Schemas\PlanForm;
use App\Filament\Resources\Plans\Tables\PlansTable;
use App\Models\Plan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PlanResource extends Resource
{
    protected static ?string $model = Plan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationLabel = 'Paket';

    protected static ?string $modelLabel = 'Paket';

    protected static ?string $pluralModelLabel = 'Paket Membership';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return PlanForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PlansTable::configure($table);
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
            'index' => ListPlans::route('/'),
            'create' => CreatePlan::route('/create'),
            'edit' => EditPlan::route('/{record}/edit'),
        ];
    }

    // Authorization Methods
    public static function canViewAny(): bool
    {
        $user = Auth::user();
        return $user->can('manage_all_plans') || $user->can('manage_own_plans');
    }

    public static function canView(Model $record): bool
    {
        $user = Auth::user();

        if ($user->can('manage_all_plans')) {
            return true;
        }

        if ($user->can('manage_own_plans')) {
            return $record->gym->user_id === $user->id;
        }

        return false;
    }

    public static function canCreate(): bool
    {
        $user = Auth::user();
        return $user->can('manage_all_plans') || $user->can('manage_own_plans');
    }

    public static function canEdit(Model $record): bool
    {
        return static::canView($record);
    }

    public static function canDelete(Model $record): bool
    {
        return static::canView($record);
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

        // Gym owner hanya bisa lihat plan dari gym mereka
        if ($user->hasRole('gym_owner')) {
            $gymIds = $user->gyms()->pluck('id');
            return $query->whereIn('gym_id', $gymIds);
        }

        // Role lain tidak bisa lihat data
        return $query->whereRaw('1 = 0');
    }
}
