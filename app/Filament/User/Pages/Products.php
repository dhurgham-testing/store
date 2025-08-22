<?php

namespace App\Filament\User\Pages;

use App\Models\Product;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\View\View;

class Products extends Page implements HasActions
{
    use InteractsWithActions;

    protected static string|null|\BackedEnum $navigationIcon = 'heroicon-o-shopping-bag';

    protected string $view = 'filament.user.pages.products';

    protected static ?string $navigationLabel = 'Products';

    protected static ?string $title = 'Products';

    protected static ?string $slug = 'products';

    protected static ?int $navigationSort = 2;

    public function addToCart($product_id): void
    {
        send_success_notification('item add to cart');
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
