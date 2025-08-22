<?php

namespace App\Filament\User\Pages;

use App\Models\CartList;
use App\Services\OrderService;
use App\Services\OrderItemService;
use Filament\Actions\Contracts\HasActions;
use Filament\Pages\Page;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class Cart extends Page implements HasActions, HasForms
{
    use InteractsWithActions, InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    protected static string|null|\BackedEnum $navigationIcon = 'heroicon-o-shopping-cart';

    protected string $view = 'filament.user.pages.cart';

    protected static ?string $navigationLabel = 'Cart';

    protected static ?string $title = 'Shopping Cart';

    protected static ?string $slug = 'cart';

    protected static ?int $navigationSort = 3;



    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('phone')
                    ->label('Phone Number')
                    ->prefix('964')
                    ->tel()
                    ->required()
                    ->placeholder('Enter your phone number'),

                Select::make('payment_method')
                    ->label('Payment Method')
                    ->options([
                        'cash' => 'Cash',
//                        'card' => 'Credit/Debit Card',
                    ])
                    ->default('cash')
                    ->placeholder('Select payment method'),

                Textarea::make('billing_address')
                    ->label('Billing Address')
                    ->hidden(fn($get)=>$get('payment_method') == 'cash')
                    ->required()
                    ->placeholder('Enter your billing address')
                    ->rows(3),
            ])
            ->statePath('data');
    }

         public function placeOrder(): void
    {
        $user = Auth::user();
        
        if (!$user) {
            send_success_notification('Please login to place an order');
            return;
        }

        $formData = $this->form->getState();

        // Validate form data
        if (empty($formData['phone']) || empty($formData['payment_method'])) {
            send_success_notification('Please fill in all required fields');
            return;
        }

        // Check if billing address is required (not cash payment)
        if ($formData['payment_method'] !== 'cash' && empty($formData['billing_address'])) {
            send_success_notification('Billing address is required for non-cash payments');
            return;
        }

        // Get cart items
        $cartItems = CartList::with('product')
            ->where('user_id', $user->id)
            ->get();

        if ($cartItems->isEmpty()) {
            send_success_notification('Your cart is empty');
            return;
        }

        // Calculate total amount
        $orderService = new OrderService();
        $totalAmount = $orderService->calculateTotalAmount($cartItems->toArray());

        // Create order
        $order = $orderService->createOrder($user, [
            'total_amount' => $totalAmount,
            'billing_address' => $formData['billing_address'] ?? 'Cash payment - no address required',
            'payment_method' => $formData['payment_method'],
            'notes' => "Phone: {$formData['phone']}",
        ]);

        // Create order items
        $orderItemService = new OrderItemService();
        $orderItemService->createOrderItems($order, $user, $cartItems->toArray());

        // Clear user cart
        $orderItemService->clearUserCart($user);

        // Reset form
        $this->data = [];

        send_success_notification("Order placed successfully! Order #{$order->order_number}");
    }

    public function getViewData(): array
    {
        $user = Auth::user();

        if (!$user) {
            return ['cart_items' => collect()];
        }

        return [
            'cart_items' => CartList::with(['product.category', 'product.brand', 'product.image'])
                ->where('user_id', $user->id)
                ->get(),
        ];
    }

    public function removeFromCart($cart_item_id): void
    {
        $user = Auth::user();

        if (!$user) {
            send_success_notification('Please login to manage your cart');
            return;
        }

        $cartItem = CartList::query()->where('id', $cart_item_id)
            ->where('user_id', $user->id)
            ->first();

        if (!$cartItem) {
            send_success_notification('Cart item not found');
            return;
        }

        $cartItem->delete();
        send_success_notification('Item removed from cart successfully');
    }
}
