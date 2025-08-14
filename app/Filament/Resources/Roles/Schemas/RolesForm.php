<?php

namespace App\Filament\Resources\Roles\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class RolesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Role Name')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                TextInput::make('guard_name')
                    ->label('Guard Name')
                    ->required()
                    ->maxLength(255)
                    ->default('web'),
            ]);
    }
}
