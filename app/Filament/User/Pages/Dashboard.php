<?php

namespace App\Filament\User\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Page
{
    protected static string|null|\BackedEnum $navigationIcon = 'heroicon-o-home';

    protected string $view = 'filament.user.pages.dashboard';

    protected static ?string $navigationLabel = 'Dashboard';

    protected static ?string $title = 'Dashboard';

    protected static ?string $slug = 'dashboard';

    protected static ?int $navigationSort = 1;

    public function getViewData(): array
    {
        $user = Auth::user();

        if (!$user) {
            return [
                'user' => null,
                'stats' => [
                    'orders' => 0,
                    'total_spent' => 0,
                    'products' => 0,
                ]
            ];
        }

        // Get user stats
        $orders = $user->orders()->count();
        $totalSpent = $user->orders()->sum('total_amount');
        $products = \App\Models\Product::count();

        return [
            'user' => $user,
            'stats' => [
                'orders' => $orders,
                'total_spent' => $totalSpent,
                'products' => $products,
            ]
        ];
    }
}
