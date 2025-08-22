<?php

namespace App\Filament\Resources\Admin\Products\Pages;

use App\Filament\Resources\Admin\Products\ProductResource;
use Filament\Resources\Pages\ListRecords;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;
}
