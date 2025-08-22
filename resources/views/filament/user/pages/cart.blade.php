<x-filament-panels::page>
    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900 text-center">Shopping Cart</h1>
            <p class="text-lg text-gray-600 text-center mt-2">Your selected items</p>
        </div>

        <style>
            body {
                font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif;
                background-color: #f9fafb; /* light */
                color: #1f2937;
            }

            .dark body {
                background-color: #1f2937; /* dark */
                color: #f9fafb;
            }
            .cart-card {
                position: relative;
                background: white;
                border-radius: 1rem;
                box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
                transition: all 0.5s ease;
                transform: translateY(0);
                overflow: hidden;
                display: flex;
                flex-direction: row;
                width: 100%;
                height: 120px;
            }
            .cart-card:hover {
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
                transform: translateY(-8px);
            }
            .cart-image {
                flex-shrink: 0;
                width: 120px;
                height: 120px;
                position: relative;
                overflow: hidden;
            }
            .cart-image img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                object-position: center;
            }
            .cart-content {
                flex: 1;
                padding: 1rem;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                text-align: justify;
            }
            .brand-name {
                font-size: 0.7rem;
                color: #6b7280;
                text-transform: uppercase;
                font-weight: 500;
                margin-bottom: 0.1rem;
            }
            .product-name {
                font-size: 1rem;
                font-weight: 700;
                color: #1f2937;
                margin-bottom: 0.25rem;
                line-height: 1.1;
            }
            .price-section {
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }
            .current-price {
                font-size: 1.25rem;
                font-weight: 700;
                color: #1f2937;
            }
            .cart-grid {
                display: grid;
                grid-template-columns: repeat(1, minmax(0, 1fr));
                gap: 1rem;
            }
            @media (min-width: 640px) {
                .cart-grid {
                    grid-template-columns: repeat(1, minmax(0, 1fr));
                }
            }
            @media (min-width: 1024px) {
                .cart-grid {
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                }
            }
            @media (min-width: 1280px) {
                .cart-grid {
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                }
            }
            .empty-cart {
                text-align: center;
                padding: 4rem 2rem;
                background: white;
                border-radius: 1rem;
                box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            }
            .empty-cart-icon {
                width: 4rem;
                height: 4rem;
                margin: 0 auto 1rem;
                color: #9ca3af;
            }
        </style>

                 <!-- Cart Items Grid -->
         @if($cart_items && $cart_items->count() > 0)

             <!-- Debug: Cart items count: {{ $cart_items->count() }} -->
             <!-- Debug: User ID: {{ Auth::id() }} -->
             <!-- Debug: Cart items: @foreach($cart_items as $item) {{ $item->product->name ?? 'No product' }}, @endforeach -->
             
             <!-- Simple Debug Display -->
             <div style="background: #f0f0f0; padding: 10px; margin: 10px 0; border-radius: 5px;">
                 <strong>Debug Info:</strong><br>
                 Cart Items Count: {{ $cart_items->count() }}<br>
                 User ID: {{ Auth::id() }}<br>
                 Cart Items: 
                 @foreach($cart_items as $item)
                     {{ $item->product->name ?? 'No product' }}{{ !$loop->last ? ', ' : '' }}
                 @endforeach
             </div>
             
             <x-filament::section collapsible>
                 <div class="cart-grid">
                     @foreach($cart_items as $cart_item)
                         <div class="cart-card group">
                             <!-- Image Container -->
                             <div class="cart-image">
                                 <img
                                     src="{{ $cart_item->product->image ? \Illuminate\Support\Facades\Storage::url($cart_item->product->image->path) : asset('images/placeholder-product.jpg') }}"
                                     alt="{{ $cart_item->product->name }}"
                                     loading="lazy"
                                 />
                             </div>

                             <!-- Content -->
                             <div class="cart-content">
                                 <!-- Top Section -->
                                 <div>
                                     <!-- Brand Name -->
                                     <div class="brand-name">{{ $cart_item->product->brand?->name ?? 'Brand' }}</div>

                                     <!-- Product Name -->
                                     <h3 class="product-name">{{ $cart_item->product->name }}</h3>
                                 </div>

                                 <!-- Bottom Section -->
                                 <div style="display: flex; align-items: center; justify-content: space-between;">
                                     <!-- Price Section -->
                                     <div class="price-section">
                                         <span class="current-price">IQD {{ number_format($cart_item->product->price, 2) }}</span>
                                     </div>

                                     <!-- Remove Button -->
                                     <x-filament::button
                                         type="button"
                                         icon="heroicon-o-trash"
                                         color="danger"
                                         size="sm"
                                         class="rounded-full w-10 h-10 p-0"
                                         wire:click="removeFromCart({{ $cart_item->id }})"
                                         title="Remove from Cart"
                                     >
                                     </x-filament::button>
                                 </div>
                             </div>
                         </div>
                     @endforeach
                 </div>
             </x-filament::section>
        <br> <br>

             <!-- Customer Information Form -->
             <x-filament::section>
                 <div class="mb-4">
                     <h3 class="text-lg font-semibold text-gray-900">Customer Information</h3>
                 </div>
                 <form wire:submit="placeOrder">
                     {{ $this->form }}
                     <br>
                     <!-- Place Order Button -->
                     <div class="mt-6 flex justify-center">
                         <x-filament::button
                             type="submit"
                             color="success"
                             size="lg"
                             icon="heroicon-o-shopping-cart"
                         >
                             Place Order
                         </x-filament::button>
                     </div>
                 </form>
             </x-filament::section>
        @else
            <!-- Empty Cart State -->
            <div class="empty-cart">
                <svg class="empty-cart-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                </svg>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Your cart is empty</h3>
                <p class="text-gray-600 mb-4">Add some products to your cart to get started</p>
                <x-filament::button
                    href="{{ route('filament.user.pages.products') }}"
                    color="primary"
                    size="lg"
                >
                    Continue Shopping
                </x-filament::button>
            </div>
        @endif
    </div>
</x-filament-panels::page>
