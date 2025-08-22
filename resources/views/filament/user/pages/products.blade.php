<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Page Header -->
    <div class="text-center space-y-2 mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Discover Our Products</h1>
        <p class="text-gray-600">Find the perfect items for your needs</p>
    </div>

         <style>
         body {
             font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif;
             background-color: #f9fafb;
             color: #1f2937;
         }
         .product-card {
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
         .product-card:hover {
             box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
             transform: translateY(-8px);
         }
         .product-image {
             flex-shrink: 0;
             width: 120px;
             height: 120px;
             position: relative;
             overflow: hidden;
         }
         .product-image img {
             width: 100%;
             height: 100%;
             object-fit: cover;
             object-position: center;
         }
         .product-content {
             flex: 1;
             padding: 1rem;
             display: flex;
             flex-direction: column;
             justify-content: space-between;
             text-align: justify;
         }
         .sale-badge {
             position: absolute;
             top: 0.5rem;
             left: 0.5rem;
             background: #ef4444;
             color: white;
             font-size: 0.65rem;
             font-weight: 700;
             padding: 0.2rem 0.4rem;
             border-radius: 0.25rem;
             text-transform: uppercase;
         }
         .wishlist-icon {
             position: absolute;
             top: 0.5rem;
             right: 0.5rem;
             width: 1.5rem;
             height: 1.5rem;
             background: white;
             border-radius: 50%;
             display: flex;
             align-items: center;
             justify-content: center;
             box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
             cursor: pointer;
             transition: all 0.2s ease;
         }
         .wishlist-icon:hover {
             transform: scale(1.1);
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
         .original-price {
             font-size: 1rem;
             color: #9ca3af;
             text-decoration: line-through;
         }

         .products-grid {
             display: grid;
             grid-template-columns: repeat(1, minmax(0, 1fr));
             gap: 1rem;
         }
         @media (min-width: 640px) {
             .products-grid {
                 grid-template-columns: repeat(1, minmax(0, 1fr));
             }
         }
         @media (min-width: 1024px) {
             .products-grid {
                 grid-template-columns: repeat(2, minmax(0, 1fr));
             }
         }
         @media (min-width: 1280px) {
             .products-grid {
                 grid-template-columns: repeat(2, minmax(0, 1fr));
             }
         }
     </style>

    <!-- Products Grid -->
    <div class="products-grid">
        <!-- Product Card 1 -->
                 @foreach($products as $product)
             <div class="product-card group">
                 <!-- Image Container -->
                 <div class="product-image">
                     <img
                         src="{{ $product->image?->url ?? asset('images/placeholder-product.jpg') }}"
                         alt="{{ $product->name }}"
                         loading="lazy"
                     />

                                           <!-- Wishlist Icon -->
{{--                      <div class="wishlist-icon">--}}
{{--                          <svg class="w-3 h-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">--}}
{{--                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />--}}
{{--                          </svg>--}}
{{--                      </div>--}}
                 </div>

                                  <!-- Content -->
                 <div class="product-content">
                     <!-- Top Section -->
                     <div>
                         <!-- Brand Name -->
                         <div class="brand-name">{{ $product->brand?->name ?? 'Brand' }}</div>

                         <!-- Product Name -->
                         <h3 class="product-name">{{ $product->name }}</h3>
                     </div>

                     <!-- Bottom Section -->
                     <div style="display: flex; align-items: center; justify-content: space-between;">
                         <!-- Price Section -->
                         <div class="price-section">
                             <span class="current-price">${{ number_format($product->price, 2) }}</span>
                             @if(isset($product->original_price) && $product->original_price > $product->price)
                                 <span class="original-price">${{ number_format($product->original_price, 2) }}</span>
                             @endif
                         </div>

                         <x-filament::button
                             type="button"
                             icon="heroicon-o-shopping-cart"
                             color="primary"
                             size="sm"
                             class="rounded-full w-10 h-10 p-0"
                             wire:click="addToCart({{ $product->id }})"
                             :disabled="$product->stock <= 0"
                             :title="$product->stock > 0 ? 'Add to Cart' : 'Out of Stock'"
                         >
                         </x-filament::button>

                     </div>
                 </div>
             </div>
         @endforeach

    </div>
        </div>
    </div>
</div>
