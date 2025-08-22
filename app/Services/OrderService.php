<?php

namespace App\Services;

use App\Models\Order;
use App\Models\User;

class OrderService
{
    public function createOrder(User $user, array $orderData): Order
    {
        return Order::create([
            'user_id' => $user->id,
            'total_amount' => $orderData['total_amount'],
            'billing_address' => $orderData['billing_address'],
            'payment_status' => 'pending',
            'payment_method' => $orderData['payment_method'],
            'notes' => $orderData['notes'] ?? null,
        ]);
    }

    public function calculateTotalAmount(array $cartItems): float
    {
        return collect($cartItems)->sum(function ($item) {
            return $item['product']['price'];
        });
    }
}
