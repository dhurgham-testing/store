<?php

namespace App\Filament\Resources\Admin\Permissions\Pages;

use App\Filament\Resources\Admin\Permissions\PermissionsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPermissions extends ListRecords
{
    protected static string $resource = PermissionsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
