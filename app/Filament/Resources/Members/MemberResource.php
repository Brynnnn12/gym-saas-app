<?php

namespace App\Filament\Resources\Members;

use BackedEnum;
use App\Models\Member;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\Members\Pages\EditMember;
use App\Filament\Resources\Members\Pages\ListMembers;
use App\Filament\Resources\Members\Pages\CreateMember;
use App\Filament\Resources\Members\Schemas\MemberForm;
use App\Filament\Resources\Members\Tables\MembersTable;

class MemberResource extends Resource
{
    protected static ?string $model = Member::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationLabel = 'Member';

    protected static ?string $modelLabel = 'Member';

    protected static ?string $pluralModelLabel = 'Members';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return MemberForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MembersTable::configure($table);
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
            'index' => ListMembers::route('/'),
            'create' => CreateMember::route('/create'),
            'edit' => EditMember::route('/{record}/edit'),
        ];
    }

    // Authorization Methods
    public static function canViewAny(): bool
    {
        $user = Auth::user();
        return $user->can('manage_all_members') || $user->can('view_all_members');
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

        // Gym owner hanya bisa lihat member yang punya subscription di gym mereka
        if ($user->hasRole('gym_owner')) {
            $gymIds = $user->gyms()->pluck('id');

            return $query->whereHas('subscriptions.plan', function ($q) use ($gymIds) {
                $q->whereIn('gym_id', $gymIds);
            });
        }

        // Role lain tidak bisa lihat data
        return $query->whereRaw('1 = 0');
    }
}
