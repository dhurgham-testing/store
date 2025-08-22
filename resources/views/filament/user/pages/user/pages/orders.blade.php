<x-filament-panels::page>
    {{-- Page Header --}}
    <div class="orders-header">
        <h1 class="orders-title">My Orders</h1>
        <p class="orders-subtitle">Track your order history and status</p>
    </div>

    <div class="orders-grid">
        @if($orders->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                <h3 class="empty-title">No Orders Yet</h3>
                <p class="empty-description">You haven't placed any orders yet. Start shopping to see your order history here.</p>
                <a href="{{ route('filament.user.pages.products') }}" class="empty-button">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    Browse Products
                </a>
            </div>
        @else
            @foreach($orders as $order)
                <div class="order-card">
                    {{-- Order Card Header --}}
                    <div class="order-header">
                        <div class="order-info">
                            <div class="order-icon">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                            </div>
                            <div class="order-details">
                                <h3 class="order-number">#{{ $order->order_number }}</h3>
                                <p class="order-date">{{ $order->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                        <span class="status-badge {{ $this->getStatusColor($order->status) }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>

                    {{-- Order Card Content --}}
                    <div class="order-content">
                        {{-- Items Count --}}
                        <div class="order-row">
                            <div class="order-label">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                <span>Items</span>
                            </div>
                            <span class="order-value">{{ $order->cartItems->count() }}</span>
                        </div>

                        {{-- Payment Status --}}
                        <div class="order-row">
                            <div class="order-label">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                                <span>Payment</span>
                            </div>
                            <span class="payment-badge {{ $this->getPaymentStatusColor($order->payment_status) }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </div>

                        {{-- Payment Method --}}
                        <div class="order-row">
                            <div class="order-label">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <span>Method</span>
                            </div>
                            <span class="order-value">{{ ucfirst($order->payment_method) }}</span>
                        </div>

                        {{-- Total Amount --}}
                        <div class="order-total">
                            <span class="total-label">Total</span>
                            <span class="total-amount">${{ number_format($order->total_amount, 2) }}</span>
                        </div>

                        {{-- Collapsible Order Items --}}
                        <x-filament::section 
                            heading="Order Items" 
                            collapsible 
                            class="order-items-section"
                        >
                                <div class="items-list">
                                    @foreach($order->groupedItems as $groupedItem)
                                        <div class="item-row">
                                            <div class="item-info">
                                                <div class="item-image">
                                                    @if($groupedItem->product && $groupedItem->product->image)
                                                        <img src="{{ \Illuminate\Support\Facades\Storage::url($groupedItem->product->image->path) }}"
                                                             alt="{{ $groupedItem->product->name }}"
                                                             class="item-img">
                                                    @else
                                                        <div class="item-placeholder">
                                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="item-details">
                                                    <h4 class="item-name">{{ $groupedItem->product->name ?? 'Product Not Found' }}</h4>
                                                    @if($groupedItem->product && $groupedItem->product->category)
                                                        <p class="item-category">{{ $groupedItem->product->category->name }}</p>
                                                    @endif
                                                    @if($groupedItem->quantity > 1)
                                                        <p class="item-unit-price">${{ number_format($groupedItem->unit_price, 2) }} each</p>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="item-price">
                                                <span class="price-amount">${{ number_format($groupedItem->total_price, 2) }}</span>
                                                <span class="quantity-badge">Qty: {{ $groupedItem->quantity }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                        </x-filament::section>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <style>
        /* Simple and Clean Orders Styling */
        .orders-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .orders-title {
            font-size: 2.25rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 1rem;
        }

        .orders-subtitle {
            font-size: 1.125rem;
            color: #6b7280;
        }

        .orders-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 1.5rem;
        }

        .order-card {
            background: white;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .order-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .order-header {
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            padding: 1.5rem;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .order-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .order-icon {
            background: #dbeafe;
            padding: 0.5rem;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .order-details {
            display: flex;
            flex-direction: column;
        }

        .order-number {
            font-size: 1.125rem;
            font-weight: 700;
            color: #111827;
            margin: 0;
        }

        .order-date {
            font-size: 0.875rem;
            color: #6b7280;
            margin: 0;
        }

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
            border: 1px solid;
            white-space: nowrap;
        }

        .order-content {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .order-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.5rem 0;
            border-bottom: 1px solid #f3f4f6;
        }

        .order-row:last-of-type {
            border-bottom: none;
        }

        .order-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #6b7280;
            font-size: 0.875rem;
        }

        .order-value {
            font-size: 0.875rem;
            font-weight: 600;
            color: #111827;
        }

        .payment-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
            border: 1px solid;
            white-space: nowrap;
        }

        .order-total {
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .total-label {
            font-size: 1.125rem;
            font-weight: 700;
            color: #111827;
        }

        .total-amount {
            font-size: 1.25rem;
            font-weight: 700;
            color: #2563eb;
        }

        .empty-state {
            grid-column: 1 / -1;
            text-align: center;
            padding: 3rem 1rem;
        }

        .empty-icon {
            width: 6rem;
            height: 6rem;
            background: #f3f4f6;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }

        .empty-title {
            font-size: 1.125rem;
            font-weight: 500;
            color: #111827;
            margin: 0 0 0.5rem;
        }

        .empty-description {
            color: #6b7280;
            margin: 0 0 1.5rem;
        }

        .empty-button {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            background: #2563eb;
            color: white;
            border-radius: 0.5rem;
            text-decoration: none;
            font-weight: 500;
            transition: background-color 0.2s ease;
        }

        .empty-button:hover {
            background: #1d4ed8;
        }

        /* Order Items Section */
        .order-items-section {
            margin-top: 1rem;
        }

        .items-list {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .item-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.75rem;
            background: white;
            border-radius: 0.5rem;
            border: 1px solid #e2e8f0;
        }

        .item-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            flex: 1;
        }

        .item-image {
            width: 3rem;
            height: 3rem;
            border-radius: 0.375rem;
            overflow: hidden;
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .item-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .item-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .item-details {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .item-name {
            font-size: 0.875rem;
            font-weight: 600;
            color: #111827;
            margin: 0;
        }

        .item-category {
            font-size: 0.75rem;
            color: #6b7280;
            margin: 0;
        }

        .item-unit-price {
            font-size: 0.75rem;
            color: #059669;
            margin: 0;
            font-weight: 500;
        }

        .item-price {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 0.25rem;
        }

        .price-amount {
            font-size: 0.875rem;
            font-weight: 600;
            color: #111827;
        }

        .quantity-badge {
            background: #e5e7eb;
            color: #374151;
            font-size: 0.75rem;
            font-weight: 500;
            padding: 0.125rem 0.5rem;
            border-radius: 0.25rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .orders-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .order-header {
                padding: 1rem;
            }

            .order-content {
                padding: 1rem;
            }
        }
    </style>


</x-filament-panels::page>
