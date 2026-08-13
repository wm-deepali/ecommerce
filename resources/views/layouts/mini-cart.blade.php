@if($miniCart && $miniCart->items->count())

    @foreach($miniCart->items as $item)
        @php
            $thumb = null;
            if ($item->imageVariant && $item->imageVariant->image) {
                $thumb = asset('storage/' . $item->imageVariant->image);
            } elseif ($item->product) {
                $thumb = $item->product->display_image;
            }

            $variantLabel = null;
            if (!empty($item->selected_attributes)) {
                $variantLabel = collect($item->selected_attributes)
                    ->map(function ($value, $key) {
                        if (is_array($value)) {
                            $attrName = $value['attribute'] ?? $value['name'] ?? $key;
                            $attrVal = $value['value'] ?? $value['label'] ?? reset($value);
                            return $attrName . ': ' . $attrVal;
                        }
                        return $key . ': ' . $value;
                    })
                    ->join(' | ');
            }
            $addonUnitTotal = $item->addons->sum('price');
            $baseMrp = $item->priceVariant->mrp ?? $item->product->mrp;
            $totalMrp = ($baseMrp + $addonUnitTotal) * $item->quantity;

        @endphp

        <div class="aq-cartmini-product-item mb-15 item-delete d-flex align-items-center">
            <div class="aq-cartmini-product-thumbnail">
                <a href="{{ route('product.details', $item->product->slug) }}">
                    <img src="{{ $thumb }}" alt="{{ $item->product->name }}">
                </a>
            </div>
            <div class="aq-cartmini-product-summary">
                <h4 class="aq-product-title">
                    <a href="{{ route('product.details', $item->product->slug) }}">
                        {{ $item->product->name }}
                    </a>
                </h4>
                @if($variantLabel)
                    <span class="aq-cartmini-product-size">{{ $variantLabel }}</span>
                @endif
                @if($item->addons->isNotEmpty())
                    <span class="aq-cartmini-product-size">
                        {{ $item->addons->pluck('detail')->implode(', ') }}
                    </span>
                @endif

                <span class="aq-cartmini-product-price" id="mini-cart-price-{{ $item->id }}">
                    ₹{{ number_format($item->total, 2) }}
                    @if($totalMrp > $item->total)
                        <span id="mini-cart-mrp-{{ $item->id }}" style="text-decoration: line-through; color:#999; font-size: 12px; margin-left: 6px;">
                            ₹{{ number_format($totalMrp, 2) }}
                        </span>
                    @endif
                </span>

                <div class="aq-product-details-quantity d-flex align-items-center">
                    <div class="aq-product-quantity">
                        <span class="aq-cart-minus update-cart-qty" data-id="{{ $item->id }}" data-action="minus">
                            <svg width="11" height="2" viewBox="0 0 11 2" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 1H10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                            </svg>
                        </span>
                        <input class="aq-cart-input" type="text" value="{{ $item->quantity }}" readonly>
                        <span class="aq-cart-plus update-cart-qty" data-id="{{ $item->id }}" data-action="plus">
                            <svg width="11" height="12" viewBox="0 0 11 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 6H10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                                <path d="M5.5 10.5V1.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                            </svg>
                        </span>
                    </div>
                    <button class="aq-line-anim aq-cartmini-remove remove-cart-item" data-id="{{ $item->id }}">
                        Remove
                    </button>
                </div>
            </div>
        </div>
    @endforeach

@else

    <div class="cartmini-empty text-center">
        <img src="{{ asset('assets/img/corporate/empty-cart.svg') }}" alt="Empty Cart" loading="lazy">
        <p>Your Cart is empty</p>
        <a href="{{ route('categories') }}" class="aq-btn-black border-btn">Continue Shopping</a>
    </div>

@endif