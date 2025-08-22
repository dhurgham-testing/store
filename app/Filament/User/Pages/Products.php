<?php

namespace App\Filament\User\Pages;

use App\Models\Product;
use App\Models\CartList;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Infolists\Components\TextEntry;
use Filament\Pages\Page;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Illuminate\Support\Facades\Auth;

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
        $user = Auth::user();

        if (!$user) {
            send_success_notification('Please login to add items to cart');
            return;
        }

        $product = Product::query()->find($product_id);

        if (!$product) {
            send_success_notification('Product not found');
            return;
        }

        if ($product->status->value !== 'published') {
            send_success_notification('This product is not available');
            return;
        }

        CartList::query()->create([
            'user_id' => $user->id,
            'product_id' => $product_id,
        ]);

        send_success_notification('Product added to cart successfully');
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
