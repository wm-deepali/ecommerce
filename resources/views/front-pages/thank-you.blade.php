@extends('layouts.app')
@section('content')

    <main class="aq-thankyou-page">
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
                <h1 class="aq-catpage-title">Thank You</h1>
                <div class="aq-catpage-breadcrumbs">
                    <a href="{{ route('home') }}">Home</a>
                    <span>/</span>
                    <span>Thank You</span>
                </div>
            </div>
        </section>


        <!-- Dynamic Success Thank You Section (Dashboard Layout) -->
        <section class="aq-thankyou-wrapper" id="aqThankYouSection">
            <div class="container">
                <div class="aq-thankyou-card">
                    <div class="aq-thankyou-icon">
                        <i class="fa-solid fa-check"></i>
                    </div>
                    <h2 class="aq-thankyou-title">

                        @if($order->payment_status == 'paid')
                            Order Confirmed!
                        @else
                            Order Placed Successfully!
                        @endif

                    </h2>
                    <p class="aq-thankyou-subtitle">

                        @if($order->payment_status == 'paid')

                            Thank you for your purchase. Your payment has been received successfully and your order is now being
                            processed.

                        @else

                            Thank you for your order. We have received your request and will process it shortly.

                        @endif

                    </p>

                    <!-- Tracker -->
                    <div class="aq-thankyou-tracker">
                        <div class="aq-tracker-progress-bar"></div>

                        <div class="aq-tracker-step completed">
                            <span class="aq-tracker-dot"><i class="fa-solid fa-box"></i></span>
                            <span class="aq-tracker-label">Order Placed</span>
                        </div>
                        <div class="aq-tracker-step active">
                            <span class="aq-tracker-dot"><i class="fa-solid fa-spinner"></i></span>
                            <span class="aq-tracker-label">Processing</span>
                        </div>

                        <div class="aq-tracker-step">
                            <span class="aq-tracker-dot"><i class="fa-solid fa-truck-fast"></i></span>
                            <span class="aq-tracker-label">Shipped</span>
                        </div>
                    </div>

                    <!-- Meta details summary -->
                    <div class="aq-thankyou-summary-box">
                        <div class="aq-summary-meta-item">
                            <span class="aq-meta-label">Order ID</span>
                            <span class="aq-meta-val">
                                {{ $order->order_number }}
                            </span>
                        </div>

                        <div class="aq-summary-meta-item">
                            <span class="aq-meta-label">Customer Name</span>
                            <span class="aq-meta-val">
                                {{ $order->customer_name }}
                            </span>
                        </div>

                        <div class="aq-summary-meta-item">
                            <span class="aq-meta-label">Mobile Number</span>
                            <span class="aq-meta-val">
                                {{ $order->customer_phone }}
                            </span>
                        </div>

                        <div class="aq-summary-meta-item">
                            <span class="aq-meta-label">Email Id</span>
                            <span class="aq-meta-val">
                                {{ $order->customer_email }}
                            </span>
                        </div>

                        <div class="aq-summary-meta-item">
                            <span class="aq-meta-label">Payment Method</span>
                            <span class="aq-meta-val">
                                {{ strtoupper($order->payment_method) }}
                            </span>
                        </div>

                        <div class="aq-summary-meta-item">
                            <span class="aq-meta-label">Payment Status</span>
                            <span class="aq-meta-val">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </div>

                        <div class="aq-summary-meta-item">
                            <span class="aq-meta-label">Order Status</span>
                            <span class="aq-meta-val">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>

                        <div class="aq-summary-meta-item">
                            <span class="aq-meta-label">Grand Total</span>
                            <span class="aq-meta-val">
                                ₹{{ number_format($order->grand_total, 2) }}
                            </span>
                        </div>

                        <div class="aq-summary-meta-item">
                            <span class="aq-meta-label">State / City</span>
                            <span class="aq-meta-val">
                                {{ $order->state?->name }}
                                /
                                {{ $order->city?->name }}
                            </span>
                        </div>

                        <div class="aq-summary-meta-item" style="grid-column: span 2;">
                            <span class="aq-meta-label">Delivery Address</span>
                            <span class="aq-meta-val">

                                {{ $order->address_line_1 }}

                                @if($order->address_line_2)
                                    , {{ $order->address_line_2 }}
                                @endif

                                ,

                                {{ $order->city?->name }},
                                {{ $order->state?->name }}

                                - {{ $order->pincode }}

                            </span>
                        </div>

                    </div>

                    <a href="{{ route('home') }}" class="aq-thankyou-btn">
                        <i class="fa-solid fa-house"></i>
                        <span>Return to Home</span>
                    </a>
                </div>
            </div>
        </section>
    </main>
    
    @if(!empty($purchaseScript))
<script>
    {!! $purchaseScript !!}
</script>
@endif

@endsection