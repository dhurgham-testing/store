<?php

namespace App\Services;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\User;

class OrderItemService
{
    public function createOrderItems(Order $order, User $user, array $cartItems): void
    {
        foreach ($cartItems as $cartItem) {
            CartItem::create([
                'order_id' => $order->id,
                'user_id' => $user->id,
                'product_id' => $cartItem['product_id'],
                'cost' => $cartItem['product']['cost'],
                'price' => $cartItem['product']['price'],
            ]);
        }
    }

    public function clearUserCart(User $user): void
    {
        // Clear cart_list items for the user
        $user->cartList()->delete();
    }
}
