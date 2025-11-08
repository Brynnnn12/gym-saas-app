<?php

namespace App\Filament\Resources\Gyms;

use App\Filament\Resources\Gyms\Pages\CreateGym;
use App\Filament\Resources\Gyms\Pages\EditGym;
use App\Filament\Resources\Gyms\Pages\ListGyms;
use App\Filament\Resources\Gyms\Schemas\GymForm;
use App\Filament\Resources\Gyms\Tables\GymsTable;
use App\Models\Gym;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class GymResource extends Resource
{
    protected static ?string $model = Gym::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationLabel = 'Gym';

    protected static ?string $modelLabel = 'Gym';

    protected static ?string $pluralModelLabel = 'Gyms';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return GymForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GymsTable::configure($table);
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
            'index' => ListGyms::route('/'),
            'create' => CreateGym::route('/create'),
            'edit' => EditGym::route('/{record}/edit'),
        ];
    }

    // Authorization Methods
    public static function canViewAny(): bool
    {
        $user = Auth::user();
        return $user->can('manage_all_gyms') || $user->can('manage_own_gym');
    }

    public static function canView(Model $record): bool
    {
        $user = Auth::user();

        if ($user->can('manage_all_gyms')) {
            return true;
        }

        if ($user->can('manage_own_gym')) {
            return $record->user_id === $user->id;
        }

        return false;
    }

    public static function canCreate(): bool
    {
        $user = Auth::user();
        return $user->can('manage_all_gyms') || $user->can('manage_own_gym');
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

        // Gym owner hanya bisa lihat gym mereka
        if ($user->hasRole('gym_owner')) {
            return $query->where('user_id', $user->id);
        }

        // Role lain tidak bisa lihat data
        return $query->whereRaw('1 = 0');
    }
}
