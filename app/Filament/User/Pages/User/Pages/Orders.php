<?php

namespace App\Filament\User\Pages\User\Pages;

use App\Models\Order;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class Orders extends Page
{
    protected static string|null|\BackedEnum $navigationIcon = 'heroicon-o-shopping-bag';

    protected string $view = 'filament.user.pages.user.pages.orders';

    protected static ?string $navigationLabel = 'My Orders';

    protected static ?string $title = 'My Orders';

    protected static ?string $slug = 'orders';

    protected static ?int $navigationSort = 3;

    public function getViewData(): array
    {
        $user = Auth::user();

        if (!$user) {
            return ['orders' => collect()];
        }

        $orders = Order::with(['cartItems.product'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $orders->each(function ($order) {
            $groupedItems = $order->cartItems->groupBy('product_id')->map(function ($items) {
                $firstItem = $items->first();
                $totalQuantity = $items->count();
                $totalPrice = $items->sum('price');

                return (object) [
                    'product' => $firstItem->product,
                    'quantity' => $totalQuantity,
                    'total_price' => $totalPrice,
                    'unit_price' => $firstItem->price,
                ];
            });

            $order->groupedItems = $groupedItems;
        });

        return [
            'orders' => $orders,
        ];
    }

    public function getStatusColor(string $status): string
    {
        return match ($status) {
            'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
            'processing' => 'bg-blue-100 text-blue-800 border-blue-200',
            'delivered' => 'bg-green-100 text-green-800 border-green-200',
            'cancelled' => 'bg-red-100 text-red-800 border-red-200',
            default => 'bg-gray-100 text-gray-800 border-gray-200',
        };
    }

    public function getPaymentStatusColor(string $status): string
    {
        return match ($status) {
            'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
            'paid' => 'bg-green-100 text-green-800 border-green-200',
            'failed' => 'bg-red-100 text-red-800 border-red-200',
            default => 'bg-gray-100 text-gray-800 border-gray-200',
        };
    }
}
