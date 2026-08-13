@extends('layouts.app')
@section('content')

    <style>
        .saved-address-card {
            border: 1px solid #e5e5e5;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 15px;
            cursor: pointer;
            transition: .3s;
        }

        .saved-address-card:hover {
            border-color: #d49aa7;
        }

        .saved-address-card.active {
            border: 2px solid #d49aa7;
            background: #fff8fa;
        }

        .saved-address-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .saved-address-radio {
            width: 18px !important;
            height: 18px !important;
            margin-right: 10px;
            position: static !important;
        }



        .saved-address-card input:checked+.saved-address-content {
            color: #000;
        }

        .saved-address-card:has(input:checked) {
            border: 2px solid #d49aa7;
            background: #fff8fa;
        }

        .saved-address-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .saved-address-title {
            font-weight: 600;
            color: #d49aa7;
        }
    </style>


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
                <h1 class="aq-catpage-title">Checkout</h1>
                <div class="aq-catpage-breadcrumbs">
                    <a href="{{ route('home') }}">Home</a>
                    <span>/</span>
                    <a href="{{ route('cart') }}">Cart</a>
                    <span>/</span>
                    <span>Checkout</span>
                </div>
            </div>
        </section>

        <!-- Breadcrumb Bar -->




        <section class="aq-cart-wrapper" id="aqCartMainSection">
            <div class="container">

                <form id="checkoutForm">
                    @csrf

                    <div class="row">

                        <!-- Left: Billing & Shipping -->
                        <div class="col-xl-8 col-lg-8 col-12 mb-40">
                            <h1 class="aq-cart-title font-family-heading mb-4">Billing & Shipping Details</h1>

                            <div class="aq-checkout-container aq-contact-page">

                                <input type="hidden" id="selectedAddressId" name="address_id"
                                    value="{{ $defaultAddress->id ?? '' }}">

                                @if($addresses->count())

                                    <div class="mb-4">

                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="mb-0">Saved Addresses</h6>
                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#newAddressModal">
                                                + Add New Address
                                            </button>

                                        </div>

                                        @foreach($addresses as $address)

                                            <label class="saved-address-card">

                                                <input type="radio" name="address_option" value="{{ $address->id }}"
                                                    class="saved-address-radio" {{ $address->is_default ? 'checked' : '' }}>
                                                <div class="saved-address-content">

                                                    <div class="saved-address-header">
                                                        <span class="saved-address-title">
                                                            {{ $address->address_type ?? 'Address' }}
                                                        </span>

                                                        @if($address->is_default)
                                                            <span class="badge bg-success">
                                                                Default
                                                            </span>
                                                        @endif
                                                    </div>

                                                    <strong>{{ $address->name }}</strong>

                                                    <div>{{ $address->phone }}</div>

                                                    <div>{{ $address->email }}</div>

                                                    <div>{{ $address->address_line_1 }}</div>

                                                    @if($address->address_line_2)
                                                        <div>{{ $address->address_line_2 }}</div>
                                                    @endif

                                                    <div>
                                                        {{ $address->city?->name }},
                                                        {{ $address->state?->name }}
                                                        - {{ $address->pincode }}
                                                    </div>

                                                </div>

                                            </label>

                                        @endforeach

                                    </div>

                                @endif
                                <!-- Contact Information -->
                                <h4 class="aq-checkout-section-title font-family-heading my-4 pb-2">
                                    1. Contact Information
                                </h4>

                                <div class="row g-3 mb-5">

                                    <div class="col-md-12">
                                        <div class="position-relative">
                                            <i class="fa-regular fa-user position-absolute aq-contact-input-icon"></i>

                                            <input type="text" id="customer_name" name="name"
                                                class="form-control aq-contact-input" value="{{ $customer->name }}"
                                                placeholder="Full Name *" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="position-relative">
                                            <i class="fa-regular fa-envelope position-absolute aq-contact-input-icon"></i>

                                            <input type="email" id="customer_email" name="email"
                                                class="form-control aq-contact-input" value="{{ $customer->email }}"
                                                placeholder="Email Address *" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="position-relative">
                                            <i class="fa-solid fa-phone position-absolute aq-contact-input-icon"></i>

                                            <input type="tel" id="customer_phone" name="phone"
                                                class="form-control aq-contact-input" value="{{ $customer->mobile }}"
                                                placeholder="Phone Number *" required>
                                        </div>
                                    </div>

                                </div>

                                <!-- Shipping Address -->
                                <h4 class="aq-checkout-section-title font-family-heading my-4 pb-2">2. Shipping Address</h4>

                                <div id="newAddressSection" class="row g-3 mb-5">

                                    <div class="col-12">
                                        <div class="position-relative">
                                            <i class="fa-solid fa-house position-absolute aq-contact-input-icon"></i>

                                            <input type="text" id="address_line_1" name="address_line_1"
                                                class="form-control aq-contact-input"
                                                value="{{ $defaultAddress->address_line_1 ?? '' }}"
                                                placeholder="Address Line 1 (House No., Building, Street) *" required>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="position-relative">
                                            <i class="fa-solid fa-map-pin position-absolute aq-contact-input-icon"></i>

                                            <input type="text" id="address_line_2" name="address_line_2"
                                                class="form-control aq-contact-input"
                                                value="{{ $defaultAddress->address_line_2 ?? '' }}"
                                                placeholder="Address Line 2 (Area, Landmark)">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="position-relative">
                                            <i
                                                class="fa-solid fa-earth-americas position-absolute aq-contact-input-icon"></i>

                                            <select name="country" class="form-control aq-contact-input">
                                                <option value="India" selected>India</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="position-relative">
                                            <i class="fa-solid fa-map position-absolute aq-contact-input-icon"></i>

                                            <select name="state_id" id="state_id" class="form-control aq-contact-input"
                                                required>

                                                <option value="">Select State</option>

                                                @foreach($states as $state)
                                                    <option value="{{ $state->id }}" {{ ($defaultAddress->state_id ?? '') == $state->id ? 'selected' : '' }}>
                                                        {{ $state->name }}
                                                    </option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="position-relative">
                                            <i class="fa-solid fa-city position-absolute aq-contact-input-icon"></i>

                                            <select name="city_id" id="city_id" class="form-control aq-contact-input"
                                                required>

                                                <option value="">Select City</option>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="position-relative">
                                            <i class="fa-solid fa-location-dot position-absolute aq-contact-input-icon"></i>

                                            <input type="text" id="pincode" name="pincode"
                                                value="{{ $defaultAddress->pincode ?? '' }}"
                                                class="form-control aq-contact-input" placeholder="Postal Code / PIN Code *"
                                                required>
                                        </div>
                                    </div>

                                </div>

                                <!-- Payment Method -->
                                <h4 class="aq-checkout-section-title font-family-heading my-4 pb-2">3. Payment Method</h4>
                               <div class="checkout-payment-methods">
    <div class="payment-method-box active">
        <label class="aq-custom-radio-container">
            <input type="radio" name="payment_method" value="razorpay" checked>
            <span class="checkmark-radio"></span>
            Pay Online
        </label>
    </div>
    @if($general && $general->cod_enabled)
        <div class="payment-method-box">
            <label class="aq-custom-radio-container">
                <input type="radio" name="payment_method" value="cod">
                <span class="checkmark-radio"></span>
                Cash on Delivery (COD)
            </label>
        </div>
    @endif
</div>

                                <div class="aq-checkout-disclaimer">
                                    <i class="fa-solid fa-lock mr-5"></i> Your personal data will be used to process your
                                    order, support your experience throughout this website, and for other purposes described
                                    in our privacy policy.
                                </div>

                            </div>
                        </div>

                        <!-- Right: Order Summary sticky card -->
                        <div class="col-xl-4 col-lg-4 col-12">
                            <div class="aq-summary-card">

                                <h3 class="aq-summary-title">Order Summary</h3>

                                @if($cart && $cart->items->count())

                                    <div class="mb-3">

                                        @foreach($cart->items as $item)

                                            <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">

                                                <div>

                                                    <div style="font-size:14px;font-weight:600;">
                                                        {{ $item->product->name }}
                                                    </div>

                                                    <small class="text-muted">
                                                        Qty : {{ $item->quantity }}
                                                    </small>

                                                    @if(!empty($item->selected_attributes))

                                                        <div class="mt-1">

                                                            @foreach($item->selected_attributes as $attr)

                                                                <small class="d-block text-muted">
                                                                    {{ $attr['attribute'] }} : {{ $attr['value'] }}
                                                                </small>

                                                            @endforeach

                                                        </div>

                                                    @endif

                                                    @if($item->addons->count())

                                                        <div class="mt-1">

                                                            @foreach($item->addons as $addon)

                                                                <small class="d-block text-muted">
                                                                    <i class="fa-solid fa-plus"></i>
                                                                    {{ $addon->detail }}
                                                                    (+₹{{ number_format($addon->price, 2) }})
                                                                </small>

                                                            @endforeach

                                                        </div>

                                                    @endif

                                                </div>

                                                <div style="font-weight:600;">
                                                    ₹{{ number_format($item->total) }}
                                                </div>

                                            </div>

                                        @endforeach

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
                                    <span id="summaryDiscount" style="color:green;">
                                        - ₹{{ number_format($cart->discount ?? 0, 2) }}
                                    </span>
                                </div>


                                <div class="aq-summary-row">
                                    <span>Shipping & Handling</span>
                                    <span class="text-success font-weight-bold">
                                        Free
                                    </span>
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

                                <button type="button" id="placeOrderBtn" class="aq-btn-final-quote aq-checkout-btn-submit">

                                    <span>Place Order Now</span>
                                    <i class="fa-solid fa-check-circle ml-10"></i>

                                </button>

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

                </form>

            </div>
        </section>


        <div class="modal fade aq-premium-modal address-modal" id="newAddressModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="max-width: 550px;">
                <div class="modal-content">

                    <button type="button" class="btn-close position-absolute" style="top: 20px; right: 20px; z-index: 10;"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="p-4">
                        <h3 class="font-family-heading mb-4">Add New Address</h3>


                        <form id="newAddressForm">

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="aq-form-label">Full Name *</label>
                                    <input type="text" id="modal_name" class="form-control" required
                                        value="{{ $customer->name ?? '' }}" placeholder="John Doe">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="aq-form-label">Mobile Number *</label>
                                    <input type="tel" id="modal_phone" class="form-control" required
                                        value="{{ $customer->mobile ?? '' }}" placeholder="+91 00000 00000">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="aq-form-label">Email Address *</label>
                                <input type="email" id="modal_email" class="form-control" required
                                    value="{{ $customer->email ?? '' }}" placeholder="example@email.com">
                            </div>

                            <div class="mb-3">
                                <label class="aq-form-label">Address Line 1 *</label>
                                <input type="text" id="modal_address_line_1" class="form-control" required
                                    placeholder="House/Flat No., Building Name">
                            </div>

                            <div class="mb-3">
                                <label class="aq-form-label">Address Line 2 (Optional)</label>
                                <input type="text" id="modal_address_line_2" class="form-control"
                                    placeholder="Street, Sector, Area">
                            </div>

                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label class="aq-form-label">State *</label>

                                    <select id="modal_state_id" class="form-select" required>

                                        <option value="">Select State</option>

                                        @foreach($states as $state)
                                            <option value="{{ $state->id }}">
                                                {{ $state->name }}
                                            </option>
                                        @endforeach

                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="aq-form-label">City *</label>

                                    <select id="modal_city_id" class="form-select" required>

                                        <option value="">Select City</option>

                                    </select>
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-6 mb-4">
                                    <label class="aq-form-label">Pincode *</label>

                                    <input type="text" id="modal_pincode" class="form-control" required
                                        placeholder="122002">
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="aq-form-label">Address Type *</label>

                                    <div class="d-flex gap-4 mt-2">

                                        <label class="d-flex align-items-center gap-2"
                                            style="cursor:pointer;font-size:14px;color:#555;">

                                            <input type="radio" name="address_type" value="home" checked
                                                style="width:16px;height:16px;margin:0;appearance:auto !important;">

                                            Home
                                        </label>

                                        <label class="d-flex align-items-center gap-2"
                                            style="cursor:pointer;font-size:14px;color:#555;">

                                            <input type="radio" name="address_type" value="office"
                                                style="width:16px;height:16px;margin:0;appearance:auto !important;">

                                            Office
                                        </label>

                                    </div>
                                </div>

                            </div>

                            <button type="button" id="saveAddressBtn" class="aq-btn-submit w-100"
                                style="background: var(--aq-color-maroon); color:#fff; padding:12px; border:none; border-radius:8px;">

                                Save Address

                            </button>

                        </form>


                    </div>
                </div>
            </div>
        </div>
        </div>

    </main>


     <div id="payment-overlay" style="display:none;">
        <div class="payment-loader">
            <div class="spinner-border text-light" role="status"></div>
            <p>Please wait, processing your payment...</p>
        </div>
    </div>

    <style>
        #payment-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .6);
            backdrop-filter: blur(5px);
            z-index: 99999;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .payment-loader {
            text-align: center;
            color: #fff;
            font-size: 18px;
        }

        .payment-loader p {
            margin-top: 15px;
            margin-bottom: 0;
        }
    </style>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>


        $(document).ready(function () {

            function loadCities(stateId, citySelector, selectedCityId = '') {
                if (!stateId) {

                    $(citySelector).html(
                        '<option value="">Select City</option>'
                    );

                    return;
                }

                $(citySelector).html(
                    '<option value="">Loading...</option>'
                );

                $.ajax({
                    url: "{{ route('get-cities') }}",
                    type: "GET",
                    data: {
                        state_id: stateId
                    },
                    success: function (response) {

                        let options =
                            '<option value="">Select City</option>';

                        $.each(response, function (key, city) {

                            let selected =
                                city.id == selectedCityId
                                    ? 'selected'
                                    : '';

                            options += `
                                        <option value="${city.id}" ${selected}>
                                            ${city.name}
                                        </option>
                                    `;
                        });

                        $(citySelector).html(options);
                    }
                });
            }


            let defaultCityId =
                "{{ $defaultAddress->city_id ?? '' }}";

            loadCities(
                $('#state_id').val(),
                '#city_id',
                defaultCityId
            );

            $('#state_id').on('change', function () {

                loadCities(
                    $(this).val(),
                    '#city_id'
                );

            });

            $('#modal_state_id').on('change', function () {

                loadCities(
                    $(this).val(),
                    '#modal_city_id'
                );

            });



            $('.saved-address-radio').on('change', function () {

                let addressId = $(this).val();

                $.ajax({
                    url: "{{ route('checkout.change-default-address') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        address_id: addressId
                    },
                    success: function (response) {

                        if (response.success) {
                            location.reload();
                        }
                    }
                });
            });


            $('#saveAddressBtn').on('click', function () {

                $.ajax({
                    url: "{{ route('address.store') }}",
                    type: "POST",

                    data: {
                        _token: "{{ csrf_token() }}",

                        name: $('#modal_name').val(),
                        email: $('#modal_email').val(),
                        phone: $('#modal_phone').val(),

                        address_line_1: $('#modal_address_line_1').val(),
                        address_line_2: $('#modal_address_line_2').val(),

                        state_id: $('#modal_state_id').val(),
                        city_id: $('#modal_city_id').val(),

                        pincode: $('#modal_pincode').val(),

                        address_type: $('input[name="address_type"]:checked').val()
                    },

                    success: function (response) {

                        if (response.success) {

                            location.reload();
                        }
                    }
                });

            });

        });


        $('#placeOrderBtn').on('click', function () {

            let btn = $(this);

            btn.prop('disabled', true);

            $.ajax({

                url: "{{ route('checkout.place-order') }}",

                type: "POST",

                data: $('#checkoutForm').serialize(),

                success: function (response) {

                    btn.prop('disabled', false);

                    if (!response.success) {

                        alert(response.message);
                        return;
                    }

                    let paymentMethod = $(
                        'input[name="payment_method"]:checked'
                    ).val();

                    // COD
                    if (paymentMethod === 'cod') {

                        window.location.href = response.redirect_url;
                        return;
                    }

                    // Razorpay
                    if (paymentMethod === 'razorpay') {

                        let localOrderId = response.order_id;

                        let options = {

                            key: response.key,

                            amount: response.amount,

                            currency: "INR",

                            name: "{{ config('app.name') }}",

                            description: "Order Payment",

                            order_id: response.razorpay_order_id,

                            prefill: {

                                name: response.customer_name,

                                email: response.customer_email,

                                contact: response.customer_phone
                            },

                            handler: function (razorpayResponse) {

                              document.getElementById('payment-overlay').style.display = 'flex';
                              
                                $.ajax({
                                    url: "{{ route('checkout.razorpay.success') }}",
                                    type: "POST",
                                    data: {

                                        _token: "{{ csrf_token() }}",

                                        order_id: localOrderId,

                                        razorpay_payment_id:
                                            razorpayResponse.razorpay_payment_id,

                                        razorpay_order_id:
                                            razorpayResponse.razorpay_order_id,

                                        razorpay_signature:
                                            razorpayResponse.razorpay_signature
                                    },

                                    success: function (res) {

                                        if (res.success) {
                                            window.location.href =
                                                res.redirect_url;
                                        }
                                    }
                                });

                            }
                        };

                        let rzp = new Razorpay(options);
                        rzp.open();
                    }

                },
               error: function (xhr) {

    btn.prop('disabled', false);

    let message = 'Something went wrong.';

    if (xhr.status === 422) {

        let errors = xhr.responseJSON.errors;

        message = Object.values(errors)
            .map(error => error[0])
            .join('<br>');
    }

    Swal.fire({
        icon: 'error',
        title: 'Validation Error',
        html: message,
        confirmButtonColor: '#d49aa7'
    });
}
            });

        });

    </script>
@if(!empty($beginCheckoutScript))
<script>
    {!! $beginCheckoutScript !!}
</script>
@endif

@endsection