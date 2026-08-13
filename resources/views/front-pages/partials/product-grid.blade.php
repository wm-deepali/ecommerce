    @forelse($products as $product)

                                <div class="aq-product-card" data-category="onboarding" data-price="1899">
                                    <div class="aq-product-card-top">
                                         <a href="{{ route('product.details', $product->slug) }}">
                                        <div class="aq-product-media-wrapper">

                                            @php 
                                                $otherImages = $product->images
                                                ->where('is_default', 0)
                                                ->values();
                                            @endphp

                                            <img src="{{ $product->display_image }}" class="aq-product-card-img primary-img"
                                                alt="{{ $product->name }}" />

                                           <img src="{{ isset($otherImages[0]) ? asset('storage/' . ($otherImages[0]->thumb ?? $otherImages[0]->image)) : $product->display_image }}"
    class="secondary-img" alt="{{ $product->name }}" />

<img src="{{ isset($otherImages[1]) ? asset('storage/' . ($otherImages[1]->thumb ?? $otherImages[1]->image)) : $product->display_image }}"
    class="tertiary-img" alt="{{ $product->name }}" />

                                            <!--<video src="assets/img/corporate/reals_video.mp4" class="aq-product-card-video"-->
                                            <!--    muted loop playsinline></video>-->

                                            <div class="aq-product-media-indicator">
                                                <span class="aq-media-dot active"></span>
                                                <span class="aq-media-dot"></span>
                                                <span class="aq-media-dot"></span>
                                                <span class="aq-media-dot"></span>
                                            </div>
                                        </div>
                                        </a>
                                        @if($product->collections->isNotEmpty())
    <div class="aq-product-badges">
        <span class="aq-product-badge bestseller">
            {{ $product->collections->first()->name }}
        </span>
    </div>
@endif
                                        <div class="aq-product-brand-badge">
                                            <img src="{{ $product->display_image }}" alt="{{ $product->name }}" />
                                        </div>
                                        <!--<div class="aq-product-actions">-->
                                        <!--    <button class="aq-product-action-btn" title="Quick Consultation"-->
                                        <!--         onclick="openGlobalDrawer('products')">-->
                                        <!--        <i class="fa-regular fa-envelope"></i>-->
                                        <!--    </button>-->
                                        <!--</div>-->
                                        
                                        <div class="aq-product-actions">
    <!-- Quick Consultation -->
   <button class="aq-product-action-btn"
        title="Chat on WhatsApp"
        onclick="window.open('https://wa.me/917905015386', '_blank')">
    <i class="fa-brands fa-whatsapp"></i>
</button>

</div>
 <div class="aq-product-actions2">
    <!-- Wishlist -->
    <button class="aq-product-action-btn {{ in_array($product->id, $wishlistIds ?? []) ? 'wishlist-active' : '' }}"
            title="Add to Wishlist"
            onclick="addToWishlist({{ $product->id }})">
        <i class="fa-regular fa-heart"></i>
    </button>
</div>
                                    </div>
                                   <div class="aq-product-card-info">
                                        <span class="aq-product-card-brand-name">
                                            {{ $product->subcategory->name ?? $product->category->name ?? '' }}
                                        </span>
                                        <h4 class="aq-product-card-title">
                                            <a href="{{ route('product.details', $product->slug) }}">
                                                {{ $product->name }}
                                            </a>
                                        </h4>
                                        <p
                                            style="font-family: Inter, sans-serif; font-size:12px; color:#777; margin-bottom:12px;">
                                            {{ Str::limit(strip_tags($product->short_description), 80) }}
                                        </p>

                                        @php
                                            $availableStock = $product->variants->where('type', 'stock')->count()
                                                ? $product->variants->where('type', 'stock')->sum('stock')
                                                : $product->stock;
                                        @endphp

                                        @if($availableStock >= $product->min_qty)
                                        <div class="aq-product-card-price-group">
                                            <span class="aq-product-card-price">
                                                ₹{{ number_format($product->price, 0) }}
                                            </span>
                                            @if($product->mrp > $product->price)
                                                <span class="aq-product-card-old-price">
                                                    ₹{{ number_format($product->mrp, 0) }}
                                                </span>
                                            @endif
                                            @if($product->mrp > $product->price)
                                                <span class="aq-product-card-discount">
                                                    ({{ round((($product->mrp - $product->price) / $product->mrp) * 100) }}% OFF)
                                                </span>
                                            @endif
                                        </div>
                                        @endif

                                       @php
                                            $listingAttributes = \App\Models\CategoryAttribute::where('category_id', $product->category_id)
                                                ->where('show_on_listing', 1)
                                                ->pluck('attribute_id')
                                                ->toArray();

                                            $listingValues = $product->attributeValues
                                                ->whereIn('attribute_id', $listingAttributes);

                                            $groupedValues = $listingValues->groupBy('attribute_id');
                                        @endphp

@if($groupedValues->count())
    @foreach($groupedValues as $attributeValues)
        <a href="{{ route('product.details', $product->slug) }}"
           style="text-decoration:none;color:inherit;">
            <div class="aq-product-card-sizes">
                @foreach($attributeValues as $attributeValue)
                    <span class="aq-size-badge">
                        {{ $attributeValue->value->value }}
                    </span>
                @endforeach
            </div>
        </a>
    @endforeach
@endif
<div class="aq-product-card-bottom">
    @if($availableStock >= $product->min_qty)
        <button class="aq-product-card-cta"
            onclick="addToCart({{ $product->id }}, {{ $product->min_qty }}, this)">
        <i class="fa-solid fa-cart-shopping"></i>
        Add to Cart
    </button>
   @else
    <button class="aq-product-card-cta"
            disabled
            style="background:#999;cursor:not-allowed;">
        <i class="fa-solid fa-ban"></i>
        Sold Out
    </button>
@endif
</div>

                                    </div>
                                </div>
                            @empty

                                <div class="col-12 text-center">
                                    <h5>No products found.</h5>
                                </div>

                            @endforelse
