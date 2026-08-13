@extends('layouts.app')
@section('content')

    <main class="aq-cart-page">

        <!-- 1. Luxury Inner Banner / Hero Section -->
        <section class="aq-catpage-hero aq-apparel-hero">
            <div class="aq-hero-glow"></div>
            <div class="aq-floating-gift-box aq-floating-shape-1">
                <i class="fa-solid fa-wand-magic-sparkles"></i>
            </div>
            <div class="aq-floating-gift-box aq-floating-shape-2">
                <i class="fa-regular fa-star"></i>
            </div>
            <div class="aq-catpage-hero-content">
                <h1 class="aq-catpage-title">Cart </h1>
                <div class="aq-catpage-breadcrumbs">
                    <a href="{{ route('home') }}">Home</a>
                    <span>/</span>
                    <span>Cart</span>
                </div>
            </div>
        </section>
        <!-- Breadcrumb Bar -->

        <section class="aq-cart-wrapper" id="aqCartMainSection">
            <div class="container">
                <div class="row">
                    <!-- Left: Your Cart -->
                    <div class="col-xl-8 col-lg-8 col-12 mb-40">
                        <h1 class="aq-cart-title">Your Cart</h1>
                        <div class="aq-cart-items-list" id="aqCartItemsList">

                            <!-- Cart Row 1: Bespoke Welcome Kit -->
                            @if($cart && $cart->items->count())

                                @foreach($cart->items as $item)

                                    <div class="aq-cart-item-row" id="cart-row-{{ $item->id }}">
                                        <div class="aq-cart-item-thumb">
                                            <img src="{{ $item->product->display_image }}" alt="{{ $item->product->name }}">
                                        </div>
                                        <div class="aq-cart-item-details">
                                            <span class="aq-cart-item-category"> {{ $item->product->category->name ?? '' }}</span>
                                            <h4 class="aq-cart-item-title">
                                                <a href="{{ route('product.details', $item->product->slug) }}">
                                                    {{ $item->product->name }}
                                                </a>
                                            </h4>

                                            @if(!empty($item->selected_attributes))

                                                <div class="aq-cart-customization-badges">

                                                    @foreach($item->selected_attributes as $attr)

                                                        <span class="aq-cart-badge">
                                                            {{ $attr['attribute'] }} : {{ $attr['value'] }}
                                                        </span>

                                                    @endforeach

                                                </div>

                                            @endif

                                            @if($item->addons->count())

                                                <div class="aq-cart-addon-badges mt-1">

                                                    @foreach($item->addons as $addon)

                                                        <span class="aq-cart-badge aq-cart-addon-badge">
                                                            <i class="fa-solid fa-plus"></i>
                                                            {{ $addon->detail }}
                                                            (+₹{{ number_format($addon->price, 2) }})
                                                        </span>

                                                    @endforeach

                                                </div>

                                            @endif
                                        </div>
                                        <div class="aq-cart-item-price-qty">
                                            <!-- Qty Selector -->
                                            <div class="aq-cart-qty-selector">
                                                <button class="aq-cart-qty-btn qty-minus" aria-label="Decrease quantity"
                                                    data-id="{{ $item->id }}">
                                                    <i class="fa-solid fa-minus"></i>
                                                </button>
                                                <input type="text" class="aq-cart-qty-input" value="{{ $item->quantity }}" readonly
                                                    data-id="{{ $item->id }}">
                                                <button class="aq-cart-qty-btn qty-plus" data-id="{{ $item->id }}"
                                                    aria-label="Increase quantity"><i class="fa-solid fa-plus"></i></button>
                                            </div>

                                            @php
                                                // Addons carry no MRP/discount of their own — their price counts
                                                // toward both the "MRP" (strikethrough) and the actual total, so
                                                // only the base product/variant portion ever shows a discount.
                                                $addonUnitTotal = $item->addons->sum('price');
                                                $baseMrp = $item->priceVariant->mrp ?? $item->product->mrp;
                                                $totalMrp = ($baseMrp + $addonUnitTotal) * $item->quantity;

                                                $discountPercentage = 0;

                                                if ($totalMrp > 0 && $item->total < $totalMrp) {
                                                    $discountPercentage = round(
                                                        (($totalMrp - $item->total) / $totalMrp) * 100
                                                    );
                                                }
                                            @endphp

                                            <!-- Price & Actions -->
                                            <div class="aq-cart-price-block d-flex flex-column align-items-start align-items-md-end text-start text-md-end"
                                                style="gap: 4px;">

                                                @if($discountPercentage > 0)
                                                    <span class="aq-cart-discount-tag"
                                                        style="background: #eef6ee; color: #2e8b57; padding: 3px 8px; border-radius: 4px; font-size: 11px;">
                                                        {{ $discountPercentage }}% OFF
                                                    </span>
                                                @endif

                                                <div class="aq-cart-mrp-row" style="display: flex; align-items: center; gap: 10px;">
                                                    <span class="aq-cart-mrp" id="mrp-{{ $item->id }}"
                                                        style="font-size: 13px; color: #999; text-decoration: line-through;">
                                                        ₹{{ number_format($totalMrp) }}
                                                    </span>
                                                    <button class="aq-cart-item-remove remove-cart-item" data-id="{{ $item->id }}"
                                                        aria-label="Remove item"
                                                        style="color: #d9534f; border: none; background: transparent; padding: 0;"><i
                                                            class="fa-regular fa-trash-can"></i></button>
                                                </div>
                                                <span class="aq-cart-price" id="total-{{ $item->id }}"
                                                    style="font-size: 20px; font-weight: 700; color: #C98F9D;">₹{{ number_format($item->total) }}</span>
                                            </div>
                                        </div>
                                    </div>

                                @endforeach

                            @else

                                <div class="text-center py-5">
                                    <h4>Your cart is empty.</h4>
                                </div>

                            @endif
                        </div>
                    </div>

                    <!-- Right: Order Summary sticky card -->
                    <div class="col-xl-4 col-lg-4 col-12">
                        <div class="aq-summary-card">
                            <h3 class="aq-summary-title">Order Summary</h3>

                            @if($cart && $cart->items->count())

                                <div class="mb-3" id="couponFormBlock" style="{{ $cart->coupon_code ? 'display:none;' : '' }}">

                                    <label class="mb-2 fw-bold">
                                        Coupon Code
                                    </label>

                                    <div class="d-flex gap-2">

                                        <input type="text" id="coupon_code" class="form-control"
                                            placeholder="Enter coupon code">

                                        <button type="button" id="applyCouponBtn" class="btn btn-dark">
                                            Apply
                                        </button>

                                    </div>

                                </div>

                                <div id="couponAppliedBox" class="alert alert-success d-flex justify-content-between align-items-center"
                                    style="{{ $cart->coupon_code ? '' : 'display:none!important;' }}">

                                    <span>
                                        Coupon Applied:
                                        <strong id="couponAppliedCode">{{ $cart->coupon_code }}</strong>
                                    </span>

                                    <button type="button" id="removeCouponBtn" class="btn btn-sm btn-danger">
                                        Remove
                                    </button>

                                </div>

                            @endif

                            <div class="aq-summary-row">
                                <span>Cart Subtotal</span>
                                <span id="summarySubtotal">
                                    ₹{{ number_format($cart->subtotal ?? 0, 2) }}
                                </span>
                            </div>
                            <div class="aq-summary-row">
                                <span>Coupon Discount</span>
                                <span id="summaryDiscount" style="color:green">
                                    - ₹{{ number_format($cart->discount ?? 0, 2) }}
                                </span>
                            </div>


                            <div class="aq-summary-row">
                                <span>Shipping & Handling</span>
                                <span class="text-success font-weight-bold">Free</span>
                            </div>
                            @if($cart && $cart->tax_amount > 0)

                                @if($cart->gst_type == 'cgst_sgst')

                                    <div class="aq-summary-row">
                                        <span>CGST ({{ $cart->cgst_rate }}%)</span>
                                        <span>
                                            ₹{{ number_format($cart->cgst_amount, 2) }}
                                        </span>
                                    </div>

                                    <div class="aq-summary-row">
                                        <span>SGST ({{ $cart->sgst_rate }}%)</span>
                                        <span>
                                            ₹{{ number_format($cart->sgst_amount, 2) }}
                                        </span>
                                    </div>

                                @elseif($cart->gst_type == 'igst')

                                    <div class="aq-summary-row">
                                        <span>IGST ({{ $cart->igst_rate }}%)</span>
                                        <span>
                                            ₹{{ number_format($cart->igst_amount, 2) }}
                                        </span>
                                    </div>

                                @endif

                            @endif
                            <div class="aq-summary-row total-row">
                                <span>Total Amount</span>
                                <span id="summaryTotal">
                                    ₹{{ number_format($cart->grand_total ?? 0, 2) }}
                                </span>
                            </div>

                            @if(auth('customer')->check())

                                <a href="{{ route('checkout') }}" class="aq-btn-final-quote"
                                    style="background:#C98F9D;border-color:#C98F9D;text-decoration:none;">
                                    <span>Proceed to Checkout</span>
                                    <i class="fa-solid fa-arrow-right-long"></i>
                                </a>

                            @else

                                <a href="{{ route('user.login', ['redirect' => route('checkout')]) }}"
                                    class="aq-btn-final-quote"
                                    style="background:#C98F9D;border-color:#C98F9D;text-decoration:none;">
                                    <span>Login To Checkout</span>
                                    <i class="fa-solid fa-arrow-right-long"></i>
                                </a>

                            @endif

                            <div class="aq-summary-perks">
                                <div class="aq-summary-perk-item">
                                    <i class="fa-solid fa-circle-check"></i>
                                    <span>Secure Checkout with SSL Encryption</span>
                                </div>
                                <div class="aq-summary-perk-item">
                                    <i class="fa-solid fa-circle-check"></i>
                                    <span>Free Shipping on Pre-paid Orders</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>


    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>

        // Fallback if layouts.app doesn't already define this globally —
        // wires Pixel/GA/Meta CAPI events returned by the cart endpoints.
        // If layout already defines window.fireTrackingEvents, this is skipped.
        if (typeof window.fireTrackingEvents !== 'function') {
            window.fireTrackingEvents = function (events) {
                if (!events || !Array.isArray(events)) return;

                events.forEach(function (evt) {
                    try {
                        if (evt.type === 'gtag' && typeof gtag === 'function') {
                            gtag('event', evt.name, evt.params || {});
                        } else if (evt.type === 'fbq' && typeof fbq === 'function') {
                            fbq('track', evt.name, evt.params || {});
                        }
                    } catch (e) {
                        console.warn('Tracking event failed:', evt, e);
                    }
                });
            };
        }

        // Shared helper: reflect a coupon that got auto-removed by the
        // backend (revalidateCoupon) after an add/remove/quantity change.
        function handleCouponRevalidation(response) {

            if (!response.coupon_removed) {
                return;
            }

          document.getElementById('couponAppliedBox')
    .style.setProperty('display', 'none', 'important');
            $('#couponFormBlock').show();
            $('#couponAppliedCode').text('');

            if (response.coupon_message) {

                Swal.fire({
                    icon: 'info',
                    title: 'Coupon Removed',
                    text: response.coupon_message,
                    confirmButtonColor: '#C98F9D'
                });

            }
        }

        $(document).on('click', '.remove-cart-item', function () {

            if (!confirm('Remove this item from cart?')) {
                return;
            }

            let itemId = $(this).data('id');

            $.ajax({
               url: '{{ url("/cart/remove") }}/' + itemId,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {

                    if (response.status) {

                        fireTrackingEvents(response.tracking_events);

                        $('#cart-row-' + itemId).remove();

                        $('#summarySubtotal').text(
                            '₹' + Number(response.cart_total).toLocaleString()
                        );

                        $('#summaryDiscount').text(
                            '- ₹' + Number(response.discount).toLocaleString()
                        );

                        $('#summaryTotal').text(
                            '₹' + Number(response.cart_total).toLocaleString()
                        );

                        $('.cart-count').text(
                            response.cart_count
                        );

                        handleCouponRevalidation(response);

                        if ($('.aq-cart-item-row').length === 0) {

                            $('#aqCartItemsList').html(`
                                                                                    <div class="text-center py-5">
                                                                                        <h4>Your cart is empty.</h4>
                                                                                    </div>
                                                                                `);
                        }
                    }
                },
                error: function () {
                    alert('Unable to remove item.');
                }
            });

        });

      $(document).on('click', '.qty-plus, .qty-minus', function () {

    let itemId = $(this).data('id');

    let action = $(this).hasClass('qty-plus')
        ? 'plus'
        : 'minus';

    $.ajax({
        url: "{{ route('cart.update.quantity') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            item_id: itemId,
            action: action
        },
        success: function (response) {

            if (response.status) {

                fireTrackingEvents(response.tracking_events);

                $('.aq-cart-qty-input[data-id="' + itemId + '"]')
                    .val(response.quantity);

                $('#total-' + itemId).text(
                    '₹' + Number(response.item_total).toLocaleString()
                );

                $('#mrp-' + itemId).text(
                    '₹' + Number(response.total_mrp).toLocaleString()
                );

                $('#summarySubtotal').text(
                    '₹' + Number(response.cart_total).toLocaleString()
                );

                $('#summaryDiscount').text(
                    '- ₹' + Number(response.discount).toLocaleString()
                );

                $('#summaryTotal').text(
                    '₹' + Number(response.cart_total).toLocaleString()
                );

                handleCouponRevalidation(response);

            } else {

                // stock limit ya koi aur reason — customer ko batao
                Swal.fire({
                    icon: 'warning',
                    title: 'Cannot Update Quantity',
                    text: response.message || 'Unable to update quantity.',
                    confirmButtonColor: '#C98F9D'
                });

            }
        },
        error: function (xhr) {

            // agar controller 422/500 status ke saath json bhejta hai
            let message = 'Unable to update quantity.';

            if (xhr.responseJSON && xhr.responseJSON.message) {
                message = xhr.responseJSON.message;
            }

            Swal.fire({
                icon: 'warning',
                title: 'Cannot Update Quantity',
                text: message,
                confirmButtonColor: '#C98F9D'
            });

        }
    });

});

        $('#applyCouponBtn').on('click', function () {

            $.ajax({

                url: "{{ route('cart.apply.coupon') }}",

                type: "POST",

                data: {
                    _token: "{{ csrf_token() }}",
                    coupon_code: $('#coupon_code').val()
                },

                success: function (response) {

                    if (response.status) {

                        Swal.fire({
                            icon: 'success',
                            title: 'Coupon Applied',
                            text: response.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {

                            location.reload();

                        });

                    } else {

                        Swal.fire({
                            icon: 'error',
                            title: 'Coupon Error',
                            text: response.message,
                            confirmButtonColor: '#C98F9D'
                        });

                    }
                }
            });

        });

        $(document).on('click', '#removeCouponBtn', function () {

            $.ajax({

                url: "{{ route('cart.remove.coupon') }}",

                type: "POST",

                data: {
                    _token: "{{ csrf_token() }}"
                },

                success: function () {

                    Swal.fire({
                        icon: 'success',
                        title: 'Coupon Removed',
                        timer: 1200,
                        showConfirmButton: false
                    }).then(() => {

                        location.reload();

                    });

                }
            });

        });

    </script>

@endsection