<?php

namespace App\Filament\Resources\Admin\Roles\Pages;

use App\Filament\Resources\Admin\Roles\RolesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRoles extends ListRecords
{
    protected static string $resource = RolesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
