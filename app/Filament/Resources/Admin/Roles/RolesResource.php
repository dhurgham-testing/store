<?php

namespace App\Filament\Resources\Admin\Roles;

use App\Filament\Resources\Admin\Roles\Pages\EditRoles;
use App\Filament\Resources\Admin\Roles\Pages\ListRoles;
use App\Filament\Resources\Admin\Roles\RelationManagers\PermissionsRelationManager;
use App\Filament\Resources\Admin\Roles\Schemas\RolesForm;
use App\Filament\Resources\Admin\Roles\Tables\RolesTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Models\Role;

class RolesResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShieldCheck;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return RolesForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RolesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            PermissionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRoles::route('/'),
            'edit' => EditRoles::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where(function ($query) {
            if (!auth()->user()->hasRole('super-admin')) {
                $query->whereRaw('1 = 0');
            }
        });
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Management';
    }
}
