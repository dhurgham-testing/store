<?php

namespace App\Filament\Resources\Permissions\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PermissionsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Permission Name')
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
