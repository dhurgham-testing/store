<?php

namespace App\Filament\User\Pages;

use App\Models\Product;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Infolists\Components\TextEntry;
use Filament\Pages\Page;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Filament\Schemas\Concerns\InteractsWithSchemas;

class Products extends Page implements HasActions, HasSchemas
{
    use InteractsWithActions,InteractsWithSchemas;

    protected static string|null|\BackedEnum $navigationIcon = 'heroicon-o-shopping-bag';

    protected string $view = 'filament.user.pages.products';

    protected static ?string $navigationLabel = 'Products';

    protected static ?string $title = 'Products';

    protected static ?string $slug = 'products';

    protected static ?int $navigationSort = 2;

    /**
     * @throws \Exception
     */
    public function productSchema(Schema $schema): Schema
    {
        return $schema
            ->state([
                'placeholder' => "Discover Our Products, Find the perfect items for your need",
            ])
            ->components([
                TextEntry::make('placeholder')
                    ->size('lg')
                    ->weight('bold')
                    ->color('primary')
                    ->alignment('center')
            ]);
    }

    public function addToCart($product_id): void
    {
        send_success_notification('item has been added to cart');
    }

    public function getViewData(): array
    {
        return [
            'products' => Product::with(['category', 'brand', 'image'])
                ->where('status', 'published')
                ->orderBy('stock', 'desc')
                ->get(),
        ];
    }
}
