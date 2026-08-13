@extends('layouts.user-app')

@section('title', 'Dashboard')

@section('content')

@php
    $customer = Auth::guard('customer')->user();
    $recentOrders = $customer->orders()->with('items.product')->latest()->take(5)->get();
    $totalOrders  = $customer->orders()->count();
    $wishlistCount = $customer->wishlists()->count();
@endphp

<div class="aq-modern-content">
    <div class="aq-dashboard-header">
        <h2>Welcome back, {{ $customer->name }}</h2>
        <p>Here is what's happening with your luxury curations today.</p>
    </div>

    <!-- Stats -->
    <div class="aq-modern-stats">
        <div class="aq-stat-card">
            <div class="aq-stat-icon" style="background: rgba(201,143,157,0.15); color: #c98f9d;">
                <i class="fa-solid fa-bag-shopping"></i>
            </div>
            <div class="aq-stat-details">
                <p>Total Orders</p>
                <h3>{{ $totalOrders }}</h3>
            </div>
        </div>

        <div class="aq-stat-card">
            <div class="aq-stat-icon" style="background: rgba(243,156,18,0.15); color: #f39c12;">
                <i class="fa-solid fa-star"></i>
            </div>
            <div class="aq-stat-details">
                <p>Reward Points</p>
                <h3>{{ number_format($customer->reward_points ?? 0) }}</h3>
            </div>
        </div>

        <div class="aq-stat-card">
            <div class="aq-stat-icon" style="background: rgba(46,204,113,0.15); color: #2ecc71;">
                <i class="fa-solid fa-wallet"></i>
            </div>
            <div class="aq-stat-details">
                <p>Wallet Balance</p>
                <h3>₹ {{ number_format($customer->wallet_balance ?? 0) }}</h3>
            </div>
        </div>

        <div class="aq-stat-card">
            <div class="aq-stat-icon" style="background: rgba(155,89,182,0.15); color: #9b59b6;">
                <i class="fa-regular fa-heart"></i>
            </div>
            <div class="aq-stat-details">
                <p>Wishlist</p>
                <h3>{{ $wishlistCount }} {{ Str::plural('Item', $wishlistCount) }}</h3>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Recent Orders -->
        <div class="col-xl-12 col-lg-12">
            <div class="aq-modern-card">
                <div class="aq-card-header">
                    <h3>Recent Orders</h3>
                    <a href="{{ route('user.orders.index') }}" class="aq-btn-link">
                        View All <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
                <div class="aq-card-body p-0">

                    @if ($recentOrders->isEmpty())
                        <div class="aq-empty-state">
                            <i class="fa-solid fa-bag-shopping"></i>
                            <p>You haven't placed any orders yet.</p>
                            <a href="{{ route('home') }}" class="aq-btn-link">Start Shopping</a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="aq-modern-table" style="min-width: 600px;">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Date</th>
                                        <th>Items</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recentOrders as $order)
                                        @php
                                            $statusMap = [
                                                'delivered'  => 'aq-badge-success',
                                                'processing' => 'aq-badge-warning',
                                                'shipped'    => 'aq-badge-info',
                                                'cancelled'  => 'aq-badge-danger',
                                                'pending'    => 'aq-badge-secondary',
                                            ];
                                            $badgeClass = $statusMap[strtolower($order->status)] ?? 'aq-badge-secondary';
                                        @endphp
                                        <tr>
                                            <td><strong>#{{ $order->order_number ?? 'ORD-' . $order->id }}</strong></td>
                                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <div class="aq-order-items-imgs">
                                                    @foreach ($order->items->take(3) as $item)
                                                        <img
                                                            src="{{ $item->product->display_image
                                                                ? asset($item->product->display_image)
                                                                : asset('assets/img/corporate/placeholder.png') }}"
                                                            alt="{{ $item->product->name }}"
                                                            title="{{ $item->product->name }}"
                                                        >
                                                    @endforeach
                                                    @if ($order->items->count() > 3)
                                                        <span class="aq-items-overflow">
                                                            +{{ $order->items->count() - 3 }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td><strong>₹ {{ number_format($order->grand_total) }}</strong></td>
                                            <td>
                                                <span class="aq-badge {{ $badgeClass }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('user.orders.show', $order->id) }}" class="aq-btn-icon-only" title="View Order">
                                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>

@endsection