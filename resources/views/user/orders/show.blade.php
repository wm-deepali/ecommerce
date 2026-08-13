@extends('layouts.user-app')

@section('title', 'Order #' . $order->order_number)

@section('content')

@php
$status = strtolower($order->status);

$trackerSteps = ['Order Placed', 'Processing', 'Shipped', 'Delivered'];
$trackerIcons = [
    'Order Placed' => 'fa-solid fa-check',
    'Processing'   => 'fa-solid fa-box-open',
    'Shipped'      => 'fa-solid fa-truck-fast',
    'Delivered'    => 'fa-solid fa-house',
];
$activeStepMap = ['pending' => 0, 'processing' => 1, 'shipped' => 2, 'delivered' => 3];
$activeStep    = $activeStepMap[$status] ?? -1;
$isCancelled   = $status === 'cancelled';
$isDelivered   = $status === 'delivered';

$statusBadge = [
    'pending'    => 'status-processing',
    'processing' => 'status-processing',
    'shipped'    => 'status-shipped',
    'delivered'  => 'status-delivered',
    'cancelled'  => 'status-cancelled',
];

$paymentIcons = [
    'razorpay'   => 'fa-solid fa-credit-card',
    'upi'        => 'fa-solid fa-building-columns',
    'cod'        => 'fa-solid fa-money-bill-wave',
    'netbanking' => 'fa-solid fa-building-columns',
    'card'       => 'fa-solid fa-credit-card',
];
$paymentKey  = strtolower($order->payment_method ?? 'cod');
$paymentIcon = $paymentIcons[$paymentKey] ?? 'fa-solid fa-credit-card';
@endphp

<style>
/* ══════════════════════════════════════════════════════════
   REVIEW ZONE — item card bottom strip
══════════════════════════════════════════════════════════ */
.aq-review-zone {
    border-top: 1px solid var(--aq-border);
    padding: 14px 16px;
    background: #fafafa;
}

/* "Write review" prompt row */
.aq-review-prompt {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
}
.aq-review-prompt-text {
    font-size: 13px;
    color: #6d7175;
}

/* CTA button */
.aq-review-cta {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 8px 16px;
    background: #fdf3f3;
    color: var(--aq-color-maroon, #7b1010);
    border: 1px solid #f0caca;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
    text-decoration: none;
    white-space: nowrap;
    transition: background .15s;
}
.aq-review-cta:hover { background: #f9e5e5; color: var(--aq-color-maroon, #7b1010); }

/* ── Written review card ── */
.aq-review-card {
    background: #fff;
    border: 1px solid #ececec;
    border-radius: 12px;
    padding: 14px 16px;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.aq-review-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 8px;
}

/* Stars */
.aq-review-stars { display: flex; gap: 3px; align-items: center; }
.aq-review-stars i { font-size: 14px; color: #e5e7eb; }
.aq-review-stars i.filled { color: #f59e0b; }
.aq-review-stars .aq-star-num {
    font-size: 12px;
    color: #6d7175;
    margin-left: 6px;
    font-weight: 500;
}

/* Action row */
.aq-review-actions { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }

.aq-review-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: #ecfdf3;
    color: #067647;
    border: 1px solid #b4ddc8;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    padding: 3px 10px;
}

.aq-review-edit {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 12px;
    font-weight: 500;
    color: var(--aq-color-maroon, #7b1010);
    background: #fdf3f3;
    border: 1px solid #f0caca;
    border-radius: 8px;
    padding: 4px 10px;
    cursor: pointer;
    text-decoration: none;
    transition: background .15s;
}
.aq-review-edit:hover { background: #f9e5e5; color: var(--aq-color-maroon, #7b1010); }

.aq-review-delete {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 12px;
    font-weight: 500;
    color: #b22222;
    background: none;
    border: none;
    padding: 4px 2px;
    cursor: pointer;
    transition: color .15s;
}
.aq-review-delete:hover { color: #8b0000; }

/* Review text */
.aq-review-title { font-size: 13px; font-weight: 600; color: #202223; }
.aq-review-body  { font-size: 13px; color: #6d7175; line-height: 1.7; }

/* Photo thumbnails */
.aq-review-images { display: flex; gap: 8px; flex-wrap: wrap; }
.aq-review-images a {
    display: block;
    width: 60px;
    height: 60px;
    border-radius: 8px;
    overflow: hidden;
    border: 1px solid #ececec;
    flex-shrink: 0;
}
.aq-review-images img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .2s;
}
.aq-review-images a:hover img { transform: scale(1.06); }

/* ══════════════════════════════════════════════════════════
   REVIEW MODAL
══════════════════════════════════════════════════════════ */
.aq-review-modal .modal-content {
    border: none;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0,0,0,.18);
}

/* Header */
.aq-review-modal .rvm-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 18px 20px;
    border-bottom: 1px solid #f0f0f0;
    background: #fff;
}
.aq-review-modal .rvm-header h4 {
    font-size: 16px;
    font-weight: 600;
    margin: 0;
    color: #202223;
}
.aq-review-modal .rvm-close {
    width: 30px;
    height: 30px;
    border-radius: 8px;
    border: 1px solid #e3e5e8;
    background: #f5f5f5;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: #6d7175;
    font-size: 14px;
    line-height: 1;
    transition: background .15s;
}
.aq-review-modal .rvm-close:hover { background: #fce8e8; color: #b22222; }

/* Product strip */
.aq-review-modal .rvm-product {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 20px;
    background: #fafafa;
    border-bottom: 1px solid #f0f0f0;
}
.aq-review-modal .rvm-product img {
    width: 52px;
    height: 52px;
    border-radius: 8px;
    object-fit: cover;
    border: 1px solid #ececec;
    flex-shrink: 0;
}
.aq-review-modal .rvm-product-ph {
    width: 52px;
    height: 52px;
    border-radius: 8px;
    background: #f0f0f0;
    border: 1px solid #ececec;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #aaa;
    font-size: 20px;
    flex-shrink: 0;
}
.aq-review-modal .rvm-product-name { font-size: 14px; font-weight: 600; color: #202223; line-height: 1.4; }
.aq-review-modal .rvm-product-sku  { font-size: 12px; color: #8c9196; margin-top: 2px; }

/* Body */
.aq-review-modal .rvm-body { padding: 20px; display: flex; flex-direction: column; gap: 16px; }

/* Field */
.aq-review-modal .rvm-field { display: flex; flex-direction: column; gap: 6px; }
.aq-review-modal .rvm-label {
    font-size: 11px;
    font-weight: 600;
    color: #6d7175;
    text-transform: uppercase;
    letter-spacing: .04em;
}
.aq-review-modal .rvm-req { color: #b22222; margin-left: 2px; }

/* Star picker */
.aq-review-modal .rvm-stars {
    display: flex;
    gap: 6px;
    align-items: center;
}
.aq-review-modal .rvm-star-btn {
    width: 38px;
    height: 38px;
    border-radius: 8px;
    border: 1px solid #e3e5e8;
    background: #fafafa;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 20px;
    color: #d0d0d0;
    transition: background .12s, border-color .12s, color .12s;
    padding: 0;
}
.aq-review-modal .rvm-star-btn.on { background: #fff8e6; border-color: #f5d87a; color: #f59e0b; }
.aq-review-modal .rvm-star-hint { font-size: 12px; color: #6d7175; }

/* Inputs */
.aq-review-modal .rvm-input,
.aq-review-modal .rvm-textarea {
    width: 100%;
    border: 1px solid #e3e5e8;
    border-radius: 8px;
    padding: 9px 12px;
    font-size: 13px;
    color: #202223;
    background: #fff;
    outline: none;
    font-family: inherit;
    resize: none;
    transition: border-color .15s, box-shadow .15s;
    box-sizing: border-box;
}
.aq-review-modal .rvm-input:focus,
.aq-review-modal .rvm-textarea:focus {
    border-color: var(--aq-color-maroon, #7b1010);
    box-shadow: 0 0 0 3px rgba(123,16,16,.1);
}

/* Upload zone */
.aq-review-modal .rvm-upload {
    border: 2px dashed #e3e5e8;
    border-radius: 10px;
    padding: 18px 16px;
    text-align: center;
    cursor: pointer;
    background: #fafafa;
    color: #8c9196;
    font-size: 12px;
    transition: border-color .15s, background .15s;
    position: relative;
}
.aq-review-modal .rvm-upload:hover { border-color: var(--aq-color-maroon, #7b1010); background: #fdf3f3; }
.aq-review-modal .rvm-upload i { font-size: 24px; display: block; margin-bottom: 6px; color: #aaa; }
.aq-review-modal .rvm-upload input[type=file] {
    position: absolute;
    inset: 0;
    opacity: 0;
    cursor: pointer;
    width: 100%;
    height: 100%;
}

/* Image preview strip */
.aq-review-modal .rvm-preview-strip { display: flex; gap: 8px; flex-wrap: wrap; }
.aq-review-modal .rvm-preview-item {
    position: relative;
    width: 60px;
    height: 60px;
    border-radius: 8px;
    overflow: hidden;
    border: 1px solid #ececec;
}
.aq-review-modal .rvm-preview-item img { width: 100%; height: 100%; object-fit: cover; }
.aq-review-modal .rvm-preview-item .rvm-remove {
    position: absolute;
    top: 2px;
    right: 2px;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    background: rgba(0,0,0,.55);
    border: none;
    color: #fff;
    font-size: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    padding: 0;
    line-height: 1;
}

/* Footer */
.aq-review-modal .rvm-footer {
    display: flex;
    gap: 10px;
    padding: 14px 20px;
    border-top: 1px solid #f0f0f0;
    background: #fafafa;
    justify-content: flex-end;
}
.aq-review-modal .rvm-btn-cancel {
    padding: 9px 18px;
    font-size: 13px;
    font-weight: 500;
    border-radius: 8px;
    border: 1px solid #e3e5e8;
    background: #fff;
    color: #6d7175;
    cursor: pointer;
    transition: background .15s;
}
.aq-review-modal .rvm-btn-cancel:hover { background: #f5f5f5; }
.aq-review-modal .rvm-btn-submit {
    padding: 9px 22px;
    font-size: 13px;
    font-weight: 600;
    border-radius: 8px;
    border: none;
    background: var(--aq-color-maroon, #7b1010);
    color: #fff;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 7px;
    transition: opacity .15s;
}
.aq-review-modal .rvm-btn-submit:hover { opacity: .88; }
.aq-review-modal .rvm-btn-submit:disabled { opacity: .5; cursor: not-allowed; }

/* ══════════════════════════════════════════════════════════
   RETURN MODAL FIELDS
══════════════════════════════════════════════════════════ */
.rtn-field-group { margin-bottom: 14px; }
.rtn-field-group:last-child { margin-bottom: 0; }
.rtn-label { display:block; font-size:11.5px; font-weight:600; color:#6d7175; text-transform:uppercase; letter-spacing:.03em; margin-bottom:5px; }
.rtn-req { color:#b22222; margin-left:2px; }
.rtn-hint { font-size:11px; color:#8c9196; margin-top:3px; }
.rtn-input,.rtn-select,.rtn-textarea { width:100%; border:1px solid #e3e5e8; border-radius:8px; padding:0 12px; height:38px; font-size:13px; color:#202223; background:#fff; outline:none; font-family:inherit; transition:border-color .15s,box-shadow .15s; }
.rtn-input:focus,.rtn-select:focus,.rtn-textarea:focus { border-color:var(--aq-color-maroon,#7b1010); box-shadow:0 0 0 3px rgba(123,16,16,.1); }
.rtn-textarea { height:auto; padding:9px 12px; resize:none; }
.rtn-input-icon-wrap { position:relative; }
.rtn-input-icon { position:absolute; left:11px; top:50%; transform:translateY(-50%); color:#8c9196; font-size:13px; pointer-events:none; }
.rtn-input-icon-pad { padding-left:32px !important; }
.rtn-2col { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
@media(max-width:480px){ .rtn-2col { grid-template-columns:1fr; } }
.rtn-type-row { display:flex; gap:8px; }
.rtn-type-opt { flex:1; cursor:pointer; }
.rtn-type-opt input[type=radio] { display:none; }
.rtn-type-btn { display:flex; align-items:center; justify-content:center; gap:6px; padding:9px 12px; border:1.5px solid #e3e5e8; border-radius:8px; font-size:13px; font-weight:500; color:#6d7175; transition:border-color .15s,color .15s,background .15s; }
.rtn-type-opt input[type=radio]:checked + .rtn-type-btn { border-color:var(--aq-color-maroon,#7b1010); color:var(--aq-color-maroon,#7b1010); background:rgba(123,16,16,.04); }
.rtn-divider { display:flex; align-items:center; gap:10px; margin:18px 0 16px; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:#8c9196; }
.rtn-divider::before,.rtn-divider::after { content:''; flex:1; height:1px; background:#e3e5e8; }
.rtn-upload-area { border:2px dashed #e3e5e8; border-radius:10px; padding:20px 16px; text-align:center; cursor:pointer; transition:border-color .15s,background .15s; }
.rtn-upload-area:hover { border-color:var(--aq-color-maroon,#7b1010); background:rgba(123,16,16,.03); }
.rtn-submit-btn { width:100%; margin-top:18px; padding:12px; background:var(--aq-color-maroon,#7b1010); color:#fff; border:none; border-radius:8px; font-size:14px; font-weight:600; cursor:pointer; transition:opacity .15s; display:flex; align-items:center; justify-content:center; gap:8px; }
.rtn-submit-btn:hover { opacity:.9; }
</style>

<div class="aq-modern-content aq-orders-page">

    {{-- ── Back + Header ── --}}
    <div class="aq-page-header d-flex align-items-center gap-3 flex-wrap">
        <a href="{{ route('user.orders.index') }}" class="aq-btn-invoice" style="padding:8px 16px;">
            <i class="fa-solid fa-arrow-left"></i> Back to Orders
        </a>
        <div>
            <h2 class="mb-0">Order #{{ $order->order_number }}</h2>
            <p class="mb-0">Placed on {{ $order->created_at->format('M d, Y \a\t h:i A') }}</p>
        </div>
        <span class="aq-order-status {{ $statusBadge[$status] ?? '' }} ms-auto">
            {{ ucfirst($order->status) }}
        </span>
    </div>

    <div class="row g-4 mt-1">

        {{-- ════════════════════════════════════════════════
             LEFT COLUMN
        ════════════════════════════════════════════════ --}}
        <div class="col-lg-8">

            {{-- Order tracker --}}
            @if(!$isCancelled)
            <div class="aq-modern-card mb-4" style="height:auto;">
                <div class="aq-card-header"><h3>Order Progress</h3></div>
                <div class="aq-card-body">
                    <div class="aq-order-tracker">
                        @foreach($trackerSteps as $i => $step)
                            @php
                                $isCompleted = $i < $activeStep;
                                $isActive    = $i === $activeStep;
                                $stepClass   = $isCompleted ? 'completed' : ($isActive ? 'active' : '');
                            @endphp
                            <div class="aq-order-tracker-step {{ $stepClass }}">
                                <div class="aq-order-tracker-icon">
                                    <i class="{{ $isCompleted ? 'fa-solid fa-check' : $trackerIcons[$step] }}"></i>
                                </div>
                                <span class="aq-order-tracker-label">{{ $step }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            {{-- Items --}}
            <div class="aq-modern-card mb-4" style="height:auto;">
                <div class="aq-card-header">
                    <h3>Items Ordered</h3>
                    <span class="text-muted" style="font-size:13px;">
                        {{ $order->items->count() }} {{ Str::plural('item', $order->items->count()) }}
                    </span>
                </div>
                <div class="aq-card-body p-0">

                  @foreach($order->items as $item)
    @php
        $thumb = null;
        if ($item->imageVariant && $item->imageVariant->image) {
            $thumb = asset('storage/' . $item->imageVariant->image);
        } elseif ($item->product) {
            $thumb = $item->product->display_image;
        } else {
            $thumb = asset('assets/img/corporate/placeholder.png');
        }

        $variantLabel = null;
        if (!empty($item->selected_attributes)) {
            $variantLabel = collect($item->selected_attributes)
                ->map(function ($value, $key) {
                    if (is_array($value)) {
                        $attrName = $value['attribute'] ?? $value['name'] ?? $key;
                        $attrVal  = $value['value'] ?? $value['label'] ?? reset($value);
                        return $attrName . ': ' . $attrVal;
                    }
                    return $key . ': ' . $value;
                })
                ->join(' | ');
        }

        $sku = optional($item->skuVariant)->sku ?? $item->sku ?? optional($item->product)->sku;
    @endphp

    <div style="border-bottom:1px solid var(--aq-border);">

        <div class="aq-order-item" style="padding:16px 20px;">
            <img src="{{ $thumb }}" alt="{{ $item->product_name }}"
                style="width:72px;height:72px;object-fit:cover;border-radius:8px;flex-shrink:0;">
            <div class="aq-order-item-details" style="flex:1;">
                <h4 style="margin-bottom:4px;">{{ $item->product_name }}</h4>
                <p style="color:#888;font-size:13px;margin:0;">
                    @if($variantLabel){{ $variantLabel }} | @endif
                    Qty: {{ $item->quantity }}
                </p>
                @if($sku)
                    <p style="color:#aaa;font-size:12px;margin:2px 0 0;">SKU: {{ $sku }}</p>
                @endif
                @if($item->addons->isNotEmpty())
                    <p style="color:#aaa;font-size:12px;margin:2px 0 0;">
                        {{ $item->addons->pluck('detail')->implode(', ') }}
                    </p>
                @endif
            </div>
            <div style="text-align:right;flex-shrink:0;">
                <div class="aq-order-item-price">₹ {{ number_format($item->price) }}</div>
                @if($item->quantity > 1)
                    <small style="color:#aaa;">
                        × {{ $item->quantity }} = ₹ {{ number_format($item->price * $item->quantity) }}
                    </small>
                @endif
            </div>
        </div>

                            {{-- ── Review zone (delivered orders only) ── --}}
                            @if($isDelivered)
                            <div class="aq-review-zone">

                                @if($item->review)
                                    {{-- ── Already reviewed ── --}}
                                    <div class="aq-review-card">

                                        <div class="aq-review-header">
                                            <div class="aq-review-stars">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fa-solid fa-star {{ $i <= $item->review->rating ? 'filled' : '' }}"></i>
                                                @endfor
                                                <span class="aq-star-num">{{ $item->review->rating }}.0</span>
                                            </div>
                                            <div class="aq-review-actions">
                                                <span class="aq-review-badge">
                                                    <i class="fa-solid fa-circle-check" style="font-size:10px;"></i>
                                                    Reviewed
                                                </span>
                                                <a href="#"
                                                   class="aq-review-edit"
                                                   data-bs-toggle="modal"
                                                   data-bs-target="#reviewModal"
                                                   data-review-id="{{ $item->review->id }}"
                                                   data-order-item-id="{{ $item->id }}"
                                                   data-rating="{{ $item->review->rating }}"
                                                   data-title="{{ $item->review->title }}"
                                                   data-review="{{ $item->review->review }}"
                                                   data-product-name="{{ $item->product_name }}"
                                                   data-product-image="{{ $item->product?->display_image }}">
                                                    <i class="fa-solid fa-pen"></i> Edit
                                                </a>
                                                <form action="{{ route('user.reviews.destroy', $item->review->id) }}"
                                                      method="POST"
                                                      class="d-inline"
                                                      onsubmit="return confirm('Delete this review?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="aq-review-delete">
                                                        <i class="fa-solid fa-trash"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>

                                        @if($item->review->title)
                                            <div class="aq-review-title">{{ $item->review->title }}</div>
                                        @endif

                                        @if($item->review->review)
                                            <div class="aq-review-body">{{ $item->review->review }}</div>
                                        @endif

                                        @if($item->review->images->count())
                                            <div class="aq-review-images">
                                                @foreach($item->review->images as $image)
                                                    <a href="{{ asset('storage/' . $image->image) }}" target="_blank">
                                                        <img src="{{ asset('storage/' . $image->image) }}" alt="">
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endif

                                    </div>

                                @else
                                    {{-- ── Not reviewed yet ── --}}
                                    <div class="aq-review-prompt">
                                        <span class="aq-review-prompt-text">
                                            Share your experience with this product
                                        </span>
                                        <a href="#"
                                           class="aq-review-cta"
                                           data-bs-toggle="modal"
                                           data-bs-target="#reviewModal"
                                           data-order-item-id="{{ $item->id }}"
                                           data-product-name="{{ $item->product_name }}"
                                           data-product-image="{{ $item->product?->display_image }}">
                                            <i class="fa-solid fa-star"></i> Write review
                                        </a>
                                    </div>
                                @endif

                            </div>
                            @endif
                            {{-- /review zone --}}

                        </div>
                    @endforeach

                </div>
            </div>

            {{-- Delivery Address --}}
            <div class="aq-modern-card" style="height:auto;">
                <div class="aq-card-header"><h3>Delivery Address</h3></div>
                <div class="aq-card-body">
                    <p style="font-weight:600;margin-bottom:4px;">{{ $order->customer_name }}</p>
                    <p style="color:#666;margin:0;line-height:1.7;">
                        {{ $order->address_line_1 }}
                        @if($order->address_line_2), {{ $order->address_line_2 }}@endif<br>
                        {{ $order->city?->name }}, {{ $order->state?->name }} – {{ $order->pincode }}<br>
                        <i class="fa-solid fa-phone" style="font-size:12px;"></i> {{ $order->customer_phone }}
                    </p>
                </div>
            </div>

        </div>

        {{-- ════════════════════════════════════════════════
             RIGHT COLUMN
        ════════════════════════════════════════════════ --}}
        <div class="col-lg-4">

            {{-- Price Breakdown --}}
            <div class="aq-modern-card mb-4" style="height:auto;">
                <div class="aq-card-header"><h3>Price Summary</h3></div>
                <div class="aq-card-body">
                    <table style="width:100%;font-size:14px;border-collapse:collapse;">
                        <tr>
                            <td style="padding:6px 0;color:#666;">Subtotal</td>
                            <td style="padding:6px 0;text-align:right;">₹ {{ number_format($order->subtotal) }}</td>
                        </tr>
                        @if($order->discount > 0)
                        <tr>
                            <td style="padding:6px 0;color:#2ecc71;">
                                Discount
                                @if($order->coupon_code)
                                    <span style="font-size:11px;">({{ $order->coupon_code }})</span>
                                @endif
                            </td>
                            <td style="padding:6px 0;text-align:right;color:#2ecc71;">
                                − ₹ {{ number_format($order->discount) }}
                            </td>
                        </tr>
                        @endif
                        @if($order->tax_amount > 0)
                        <tr>
                            <td style="padding:6px 0;color:#666;">
                                Tax
                                @if($order->gst_type === 'igst')
                                    <span style="font-size:11px;">(IGST {{ $order->igst_rate }}%)</span>
                                @else
                                    <span style="font-size:11px;">(CGST {{ $order->cgst_rate }}% + SGST {{ $order->sgst_rate }}%)</span>
                                @endif
                            </td>
                            <td style="padding:6px 0;text-align:right;">₹ {{ number_format($order->tax_amount) }}</td>
                        </tr>
                        @endif
                        <tr style="border-top:1px solid var(--aq-border);">
                            <td style="padding:10px 0 0;font-weight:700;font-size:16px;">Grand Total</td>
                            <td style="padding:10px 0 0;text-align:right;font-weight:700;font-size:16px;">
                                ₹ {{ number_format($order->grand_total) }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            {{-- Payment Info --}}
            <div class="aq-modern-card mb-4" style="height:auto;">
                <div class="aq-card-header"><h3>Payment</h3></div>
                <div class="aq-card-body">
                    <p style="margin:0 0 6px;">
                        <i class="{{ $paymentIcon }}"></i>
                        {{ ucfirst(str_replace('_', ' ', $order->payment_method ?? 'N/A')) }}
                    </p>
                    <p style="margin:0;font-size:13px;color:#666;">
                        Status:
                        <span style="font-weight:600;color:{{ $order->payment_status === 'paid' ? '#2ecc71' : ($order->payment_status === 'refunded' ? '#f39c12' : '#ff4757') }};">
                            {{ ucfirst($order->payment_status ?? 'N/A') }}
                        </span>
                    </p>
                    @if($order->transaction_id)
                        <p style="margin:4px 0 0;font-size:12px;color:#aaa;">
                            Txn ID: {{ $order->transaction_id }}
                        </p>
                    @endif
                </div>
            </div>

            {{-- Return Request info --}}
            @php
                $returnRequest = $order->returns()
                    ->with(['returnReason', 'refundTransaction', 'orderItem.product'])
                    ->latest()
                    ->first();
            @endphp

            @if($returnRequest)
            <div class="aq-modern-card mb-4" style="height:auto;">
                <div class="aq-card-header"><h3>Return Request</h3></div>
                <div class="aq-card-body">
                    <div class="mb-3">
                        <strong>Status:</strong>
                        <span class="badge bg-secondary">{{ ucfirst($returnRequest->status) }}</span>
                    </div>
                    <div class="mb-2">
                        <strong>Product:</strong><br>
                        {{ $returnRequest->orderItem?->product?->name ?? $returnRequest->orderItem?->product_name }}
                    </div>
                    <div class="mb-2">
                        <strong>Reason:</strong><br>
                        {{ $returnRequest->returnReason?->title ?? '-' }}
                    </div>
                    @if($returnRequest->details)
                    <div class="mb-2">
                        <strong>Customer Notes:</strong><br>{{ $returnRequest->details }}
                    </div>
                    @endif
                    <div class="mb-2">
                        <strong>Requested On:</strong><br>
                        {{ $returnRequest->created_at->format('d M Y h:i A') }}
                    </div>
                </div>
            </div>

            <div class="aq-modern-card mb-4" style="height:auto;">
                <div class="aq-card-header"><h3>Refund Destination</h3></div>
                <div class="aq-card-body">
                    <p><strong>Method:</strong> {{ strtoupper($returnRequest->refund_method ?? '-') }}</p>
                    @if($returnRequest->refund_method === 'upi')
                        <p><strong>UPI ID:</strong> {{ $returnRequest->upi_id }}</p>
                    @elseif($returnRequest->refund_method === 'bank')
                        <p><strong>Bank:</strong> {{ $returnRequest->bank_name }}</p>
                        <p><strong>Account Holder:</strong> {{ $returnRequest->account_name }}</p>
                        <p><strong>Account Number:</strong> {{ $returnRequest->account_number }}</p>
                        <p><strong>IFSC:</strong> {{ $returnRequest->ifsc_code }}</p>
                    @elseif($returnRequest->refund_method === 'qr')
                        @if($returnRequest->qr_image)
                            <a href="{{ asset('storage/' . $returnRequest->qr_image) }}" target="_blank" class="aq-btn-track">
                                View QR Code
                            </a>
                        @endif
                    @endif
                </div>
            </div>

            @if($returnRequest->refundTransaction)
            <div class="aq-modern-card mb-4" style="height:auto;">
                <div class="aq-card-header"><h3>Refund Information</h3></div>
                <div class="aq-card-body">
                    <div class="mb-2"><strong>Refund Amount:</strong><br>₹{{ number_format($returnRequest->refundTransaction->amount, 2) }}</div>
                    <div class="mb-2"><strong>UTR Number:</strong><br>{{ $returnRequest->refundTransaction->utr_id }}</div>
                    <div class="mb-2"><strong>Refund Method:</strong><br>{{ strtoupper($returnRequest->refundTransaction->refund_method) }}</div>
                    <div class="mb-2"><strong>Refund Date:</strong><br>{{ $returnRequest->refundTransaction->created_at->format('d M Y h:i A') }}</div>
                    @if($returnRequest->refundTransaction->remarks)
                        <div class="mb-2"><strong>Remarks:</strong><br>{{ $returnRequest->refundTransaction->remarks }}</div>
                    @endif
                    @if($returnRequest->refundTransaction->payment_proof)
                        <a href="{{ asset('storage/' . $returnRequest->refundTransaction->payment_proof) }}" target="_blank" class="aq-btn-track">
                            View Refund Proof
                        </a>
                    @endif
                </div>
            </div>
            @endif
            @endif

            {{-- Actions --}}
            <div class="aq-modern-card" style="height:auto;">
                <div class="aq-card-header"><h3>Actions</h3></div>
                <div class="aq-card-body d-flex flex-column gap-2">

                    @if($order->invoice)
                        <a href="{{ route('user.orders.invoice', $order->id) }}" class="aq-btn-track text-center" target="_blank">
                            <i class="fa-solid fa-file-invoice"></i> Download Invoice
                        </a>
                    @endif

                    @if(in_array($status, ['processing', 'shipped']))
                        <a href="#"
                           class="aq-btn-track text-center"
                           data-bs-toggle="modal"
                           data-bs-target="#trackOrderModal"
                           data-order-number="{{ $order->order_number }}"
                           data-order-status="{{ $order->status }}"
                           data-order-date="{{ $order->created_at->format('M d, Y') }}"
                           data-tracking-number="{{ $order->tracking_number }}"
                           data-status-history='@json(
                               $order->statusHistory->map(fn($h) => [
                                   "status" => $h->status,
                                   "time"   => $h->created_at->format("d M Y h:i A"),
                               ])
                           )'>
                            <i class="fa-solid fa-location-crosshairs"></i> Track Order
                        </a>
                    @endif

                    @if($isDelivered && $order->created_at->diffInDays(now()) <= 7)
                        @php
                            $existingReturn = $order->returns()
                                ->whereIn('status', ['pending', 'approved', 'completed'])
                                ->first();
                        @endphp
                        @if($existingReturn)
                            <span class="aq-btn-invoice text-center" style="opacity:.55;cursor:not-allowed;">
                                <i class="fa-solid fa-arrow-rotate-left"></i>
                                Return {{ ucfirst($existingReturn->status) }}
                            </span>
                        @else
                            <a href="#"
                               class="aq-btn-invoice text-center"
                               data-bs-toggle="modal"
                               data-bs-target="#returnModal"
                               data-order-id="{{ $order->id }}"
                               data-order-number="{{ $order->order_number }}"
                               data-order-items="{{ $order->items->pluck('product_name', 'id')->toJson() }}">
                                <i class="fa-solid fa-arrow-rotate-left"></i> Return
                            </a>
                        @endif
                    @endif

                    @if($isCancelled)
                        <a href="{{ route('user.orders.reorder', $order->id) }}" class="aq-btn-invoice text-center">
                            <i class="fa-solid fa-cart-shopping"></i> Reorder
                        </a>
                    @endif

                </div>
            </div>

        </div>
    </div>
</div>


{{-- ════════════════════════════════════════════════════════
     TRACK ORDER MODAL
════════════════════════════════════════════════════════ --}}
<div class="modal fade aq-premium-modal track-order-modal" id="trackOrderModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:400px;">
        <div class="modal-content">
            <button type="button" class="btn-close position-absolute" style="top:20px;right:20px;z-index:10;"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="p-4">
                <h3 class="font-family-heading mb-1">Track Your Order</h3>
                <p class="text-muted mb-4" id="trackOrderMeta"></p>
                <div id="trackingInfo" class="mb-3" style="display:none;padding:10px 12px;background:#f8f9fa;border-radius:8px;">
                    <strong>Tracking Number:</strong> <span id="trackingNumber"></span>
                </div>
                <div class="aq-order-tracker" style="flex-direction:column;align-items:flex-start;gap:20px;padding-left:20px;margin:20px 0;">
                    @foreach([
                        ['label' => 'Pending',    'icon' => 'fa-solid fa-clock'],
                        ['label' => 'Processing', 'icon' => 'fa-solid fa-box-open'],
                        ['label' => 'Shipped',    'icon' => 'fa-solid fa-truck-fast'],
                        ['label' => 'Delivered',  'icon' => 'fa-solid fa-house'],
                    ] as $ms)
                    <div class="aq-order-tracker-step track-modal-step" style="flex-direction:row;gap:15px;padding:0;">
                        <div class="aq-order-tracker-icon" style="width:35px;height:35px;min-width:35px;">
                            <i class="{{ $ms['icon'] }}"></i>
                        </div>
                        <div>
                            <span class="aq-order-tracker-label d-block text-dark">{{ $ms['label'] }}</span>
                            <small class="text-muted track-modal-time">—</small>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>


{{-- ════════════════════════════════════════════════════════
     RETURN MODAL
════════════════════════════════════════════════════════ --}}
<div class="modal fade aq-premium-modal return-modal" id="returnModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:460px;">
        <div class="modal-content">
            <button type="button" class="btn-close position-absolute" style="top:20px;right:20px;z-index:10;"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="p-4" style="max-height:88vh;overflow-y:auto;">
                <h3 class="font-family-heading mb-1">Return or Exchange</h3>
                <p class="text-muted mb-4" id="returnOrderMeta"></p>

                <form action="{{ route('user.orders.return') }}" method="POST" enctype="multipart/form-data" id="returnForm">
                    @csrf
                    <input type="hidden" name="order_id" id="returnOrderId">

                    <div class="rtn-field-group">
                        <label class="rtn-label">Select Item <span class="rtn-req">*</span></label>
                        <select class="rtn-select" name="order_item_id" id="returnItemSelect" required>
                            <option value="" disabled selected>Select an item</option>
                        </select>
                    </div>

                    <div class="rtn-field-group">
                        <label class="rtn-label">Request Type <span class="rtn-req">*</span></label>
                        <div class="rtn-type-row">
                            <label class="rtn-type-opt">
                                <input type="radio" name="type" value="return" checked>
                                <span class="rtn-type-btn"><i class="fa-solid fa-arrow-rotate-left"></i> Return</span>
                            </label>
                        </div>
                    </div>

                    <div class="rtn-field-group">
                        <label class="rtn-label">Reason <span class="rtn-req">*</span></label>
                        <select class="rtn-select" name="return_reason_id" required>
                            <option value="" disabled selected>Select a reason</option>
                            @foreach($returnReasons as $reason)
                                <option value="{{ $reason->id }}">{{ $reason->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="rtn-field-group">
                        <label class="rtn-label">Additional Details</label>
                        <textarea class="rtn-textarea" name="details" rows="2" placeholder="Describe the issue…"></textarea>
                    </div>

                    <div class="rtn-divider"><span>Refund Information</span></div>

                    <div class="rtn-field-group">
                        <label class="rtn-label">Refund Via <span class="rtn-req">*</span></label>
                        <select class="rtn-select" name="refund_method" id="refundMethod" required
                                onchange="switchRefundMethod(this.value)">
                            <option value="" disabled selected>Select refund method</option>
                            <option value="upi">UPI ID</option>
                            <option value="qr">QR Code</option>
                            <option value="bank">Bank Details</option>
                        </select>
                    </div>

                    {{-- UPI --}}
                    <div id="rtnPanelUpi" class="rtn-panel" style="display:none;">
                        <div class="rtn-field-group">
                            <label class="rtn-label">UPI ID <span class="rtn-req">*</span></label>
                            <div class="rtn-input-icon-wrap">
                                <i class="fa-solid fa-building-columns rtn-input-icon"></i>
                                <input type="text" class="rtn-input rtn-input-icon-pad" name="upi_id"
                                       placeholder="yourname@upi" id="upiIdField">
                            </div>
                            <div class="rtn-hint">e.g. 9876543210@paytm, name@okaxis</div>
                        </div>
                    </div>

                    {{-- QR --}}
                    <div id="rtnPanelQr" class="rtn-panel" style="display:none;">
                        <div class="rtn-field-group">
                            <label class="rtn-label">Upload QR Code <span class="rtn-req">*</span></label>
                            <div class="rtn-upload-area" id="qrUploadArea" onclick="document.getElementById('qrFile').click()">
                                <input type="file" name="qr_image" id="qrFile" accept="image/*" style="display:none"
                                       onchange="previewQr(this)">
                                <div id="qrPlaceholder">
                                    <i class="fa-solid fa-qrcode" style="font-size:26px;color:#8c9196;"></i>
                                    <p style="margin:6px 0 0;font-size:13px;color:#6d7175;">Click to upload your UPI QR</p>
                                    <small style="color:#8c9196;">PNG, JPG — max 2 MB</small>
                                </div>
                                <div id="qrPreview" style="display:none;text-align:center;">
                                    <img id="qrPreviewImg" src="" style="max-width:130px;border-radius:8px;border:1px solid #e3e5e8;">
                                    <div style="margin-top:6px;">
                                        <button type="button" onclick="clearQr(event)"
                                                style="font-size:12px;color:#b22222;background:none;border:none;cursor:pointer;padding:0;">
                                            <i class="fa-solid fa-times"></i> Remove
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Bank --}}
                    <div id="rtnPanelBank" class="rtn-panel" style="display:none;">
                        <div class="rtn-field-group">
                            <label class="rtn-label">Bank Name <span class="rtn-req">*</span></label>
                            <input type="text" class="rtn-input" name="bank_name" placeholder="e.g. State Bank of India">
                        </div>
                        <div class="rtn-field-group">
                            <label class="rtn-label">Account Holder Name <span class="rtn-req">*</span></label>
                            <input type="text" class="rtn-input" name="account_name" placeholder="Name as on bank account">
                        </div>
                        <div class="rtn-2col">
                            <div class="rtn-field-group">
                                <label class="rtn-label">Account Number <span class="rtn-req">*</span></label>
                                <input type="text" class="rtn-input" name="account_number"
                                       placeholder="XXXXXXXXXXXXXXXXXX" inputmode="numeric">
                            </div>
                            <div class="rtn-field-group">
                                <label class="rtn-label">IFSC Code <span class="rtn-req">*</span></label>
                                <input type="text" class="rtn-input" name="ifsc_code" placeholder="SBIN0001234"
                                       style="text-transform:uppercase" oninput="this.value=this.value.toUpperCase()">
                            </div>
                        </div>
                        <div class="rtn-2col">
                            <div class="rtn-field-group">
                                <label class="rtn-label">Branch</label>
                                <input type="text" class="rtn-input" name="bank_branch" placeholder="e.g. Connaught Place">
                            </div>
                            <div class="rtn-field-group">
                                <label class="rtn-label">Account Type <span class="rtn-req">*</span></label>
                                <select class="rtn-select" name="account_type">
                                    <option value="" disabled selected>Select</option>
                                    <option value="savings">Savings</option>
                                    <option value="current">Current</option>
                                    <option value="salary">Salary</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="rtn-submit-btn">
                        <i class="fa-solid fa-paper-plane"></i> Submit Return Request
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>


{{-- ════════════════════════════════════════════════════════
     REVIEW MODAL  (write / edit)
════════════════════════════════════════════════════════ --}}
<div class="modal fade aq-premium-modal aq-review-modal" id="reviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:460px;">
        <div class="modal-content">

            {{-- Header --}}
            <div class="rvm-header">
                <h4 id="reviewModalTitle">Write a review</h4>
                <button type="button" class="rvm-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-times"></i>
                </button>
            </div>

            {{-- Product strip --}}
            <div class="rvm-product">
                <img id="rvm-product-img" src="" alt=""
                     style="display:none;width:52px;height:52px;border-radius:8px;object-fit:cover;border:1px solid #ececec;flex-shrink:0;">
                <div class="rvm-product-ph" id="rvm-product-ph" style="display:flex;">
                    <i class="fa-solid fa-image"></i>
                </div>
                <div>
                    <div class="rvm-product-name" id="rvm-product-name"></div>
                    <div class="rvm-product-sku" id="rvm-product-sku"></div>
                </div>
            </div>

            {{-- Form --}}
            <form action="{{ route('user.reviews.store') }}" method="POST"
                  enctype="multipart/form-data" id="reviewForm">
                @csrf
                <input type="hidden" name="review_id"      id="reviewId">
                <input type="hidden" name="order_item_id"  id="reviewOrderItemId">
                <input type="hidden" name="rating"         id="ratingHidden" value="0">

                <div class="rvm-body">

                    {{-- Star picker --}}
                    <div class="rvm-field">
                        <label class="rvm-label">Your rating <span class="rvm-req">*</span></label>
                        <div class="rvm-stars" id="rvmStarRow">
                            @for($s = 1; $s <= 5; $s++)
                                <button type="button" class="rvm-star-btn" data-v="{{ $s }}" aria-label="{{ $s }} star">
                                    <i class="fa-solid fa-star"></i>
                                </button>
                            @endfor
                        </div>
                        <span class="rvm-star-hint" id="rvmStarHint">Tap to rate</span>
                    </div>

                    {{-- Title --}}
                    <div class="rvm-field">
                        <label class="rvm-label">Review title</label>
                        <input type="text" name="title" id="rvm-title"
                               class="rvm-input" placeholder="Summarise your experience">
                    </div>

                    {{-- Body --}}
                    <div class="rvm-field">
                        <label class="rvm-label">Your review <span class="rvm-req">*</span></label>
                        <textarea name="review" id="rvm-body"
                                  class="rvm-textarea" rows="4"
                                  placeholder="What did you like or dislike?" required></textarea>
                    </div>

                    {{-- Photo upload --}}
                    <div class="rvm-field">
                        <label class="rvm-label">Add photos</label>
                        <div class="rvm-upload" id="rvmUploadZone">
                            <input type="file" name="images[]" id="rvmFileInput"
                                   multiple accept="image/*" onchange="handleReviewImages(this)">
                            <i class="fa-solid fa-camera"></i>
                            <span style="font-size:13px;color:#6d7175;">Tap to add photos</span>
                            <small style="display:block;margin-top:3px;color:#aaa;">JPG or PNG, up to 5 MB each</small>
                        </div>
                        <div class="rvm-preview-strip mt-2" id="rvmPreviewStrip"></div>
                    </div>

                </div>

                {{-- Footer --}}
                <div class="rvm-footer">
                    <button type="button" class="rvm-btn-cancel" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="rvm-btn-submit" id="rvmSubmitBtn">
                        <i class="fa-solid fa-paper-plane"></i>
                        <span id="rvmSubmitLabel">Submit review</span>
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>


@endsection

@push('scripts')
<script>
/* ══════════════════════════════════════════════════════════
   TRACK ORDER MODAL
══════════════════════════════════════════════════════════ */
document.getElementById('trackOrderModal')?.addEventListener('show.bs.modal', function(e) {
    const t = e.relatedTarget;
    document.getElementById('trackOrderMeta').textContent =
        `Order #${t.dataset.orderNumber} • Placed ${t.dataset.orderDate}`;

    const trackingNo = t.dataset.trackingNumber;
    if (trackingNo) {
        document.getElementById('trackingInfo').style.display  = 'block';
        document.getElementById('trackingNumber').textContent  = trackingNo;
    } else {
        document.getElementById('trackingInfo').style.display  = 'none';
    }

    const statusMap = { pending: 0, processing: 1, shipped: 2, delivered: 3 };
    const active    = statusMap[t.dataset.orderStatus?.toLowerCase()] ?? 0;
    this.querySelectorAll('.track-modal-step').forEach((step, i) => {
        step.classList.remove('completed', 'active');
        if      (i < active)  step.classList.add('completed');
        else if (i === active) step.classList.add('active');
    });

    const history = JSON.parse(t.dataset.statusHistory || '[]');
    const times   = this.querySelectorAll('.track-modal-time');
    times.forEach(el => el.textContent = '—');
    const map = { pending: 0, processing: 1, shipped: 2, delivered: 3 };
    history.forEach(item => {
        const idx = map[item.status];
        if (idx !== undefined && times[idx]) times[idx].textContent = item.time;
    });
});


/* ══════════════════════════════════════════════════════════
   RETURN MODAL
══════════════════════════════════════════════════════════ */
document.getElementById('returnModal')?.addEventListener('show.bs.modal', function(e) {
    const trigger = e.relatedTarget;
    document.getElementById('returnOrderId').value      = trigger.dataset.orderId;
    document.getElementById('returnOrderMeta').textContent =
        `Requesting a return for Order #${trigger.dataset.orderNumber}.`;

    const items  = JSON.parse(trigger.dataset.orderItems || '{}');
    const select = document.getElementById('returnItemSelect');
    select.innerHTML = '<option value="" disabled selected>Select an item</option>';
    Object.entries(items).forEach(([id, name]) => {
        const opt      = document.createElement('option');
        opt.value      = id;
        opt.textContent = name;
        select.appendChild(opt);
    });

    document.querySelectorAll('.rtn-type-opt input[type=radio]').forEach(r => {
        r.checked = r.value === 'return';
    });
    document.getElementById('refundMethod').value = '';
    switchRefundMethod('');
    clearQr();
});

function switchRefundMethod(val) {
    ['upi', 'qr', 'bank'].forEach(k => {
        const key   = k.charAt(0).toUpperCase() + k.slice(1);
        const panel = document.getElementById('rtnPanel' + key);
        if (panel) panel.style.display = val === k ? 'block' : 'none';
    });
    const upiField = document.getElementById('upiIdField');
    const qrFile   = document.getElementById('qrFile');
    if (upiField) upiField.required = val === 'upi';
    if (qrFile)   qrFile.required   = val === 'qr';
}

function previewQr(input) {
    if (!input.files?.[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('qrPreviewImg').src               = e.target.result;
        document.getElementById('qrPreview').style.display        = 'block';
        document.getElementById('qrPlaceholder').style.display    = 'none';
    };
    reader.readAsDataURL(input.files[0]);
}

function clearQr(e) {
    if (e) e.stopPropagation();
    const f = document.getElementById('qrFile');
    if (f) f.value = '';
    const p = document.getElementById('qrPreview');
    const ph = document.getElementById('qrPlaceholder');
    if (p)  p.style.display  = 'none';
    if (ph) ph.style.display = 'block';
}


/* ══════════════════════════════════════════════════════════
   REVIEW MODAL
══════════════════════════════════════════════════════════ */
const starLabels = ['', '1 — Poor', '2 — Fair', '3 — Good', '4 — Very good', '5 — Excellent'];
let selectedRating = 0;

function renderStars(v) {
    document.querySelectorAll('#rvmStarRow .rvm-star-btn').forEach(btn => {
        btn.classList.toggle('on', parseInt(btn.dataset.v) <= v);
    });
    document.getElementById('rvmStarHint').textContent = v > 0 ? starLabels[v] : 'Tap to rate';
    document.getElementById('ratingHidden').value = v;
}

document.querySelectorAll('#rvmStarRow .rvm-star-btn').forEach(btn => {
    btn.addEventListener('click',       () => { selectedRating = parseInt(btn.dataset.v); renderStars(selectedRating); });
    btn.addEventListener('mouseenter',  () => renderStars(parseInt(btn.dataset.v)));
    btn.addEventListener('mouseleave',  () => renderStars(selectedRating));
});

document.getElementById('reviewModal').addEventListener('show.bs.modal', function(e) {
    const btn = e.relatedTarget;

    // Reset
    selectedRating = 0;
    renderStars(0);
    document.getElementById('rvm-title').value     = '';
    document.getElementById('rvm-body').value      = '';
    document.getElementById('reviewId').value      = '';
    document.getElementById('rvmPreviewStrip').innerHTML = '';
    document.getElementById('rvmFileInput').value  = '';

    // Product info
    const name  = btn.dataset.productName  || '';
    const image = btn.dataset.productImage || '';
    document.getElementById('rvm-product-name').textContent = name;
    document.getElementById('rvm-product-sku').textContent  = '';

    const imgEl = document.getElementById('rvm-product-img');
    const phEl  = document.getElementById('rvm-product-ph');
    if (image) {
        imgEl.src          = image;
        imgEl.style.display = 'block';
        phEl.style.display  = 'none';
    } else {
        imgEl.style.display = 'none';
        phEl.style.display  = 'flex';
    }

    document.getElementById('reviewOrderItemId').value = btn.dataset.orderItemId || '';

    // Edit mode
    if (btn.dataset.reviewId) {
        document.getElementById('reviewId').value     = btn.dataset.reviewId;
        document.getElementById('reviewModalTitle').textContent = 'Edit your review';
        document.getElementById('rvmSubmitLabel').textContent   = 'Update review';
        selectedRating = parseInt(btn.dataset.rating) || 0;
        renderStars(selectedRating);
        document.getElementById('rvm-title').value = btn.dataset.title  || '';
        document.getElementById('rvm-body').value  = btn.dataset.review || '';
    } else {
        document.getElementById('reviewModalTitle').textContent = 'Write a review';
        document.getElementById('rvmSubmitLabel').textContent   = 'Submit review';
    }
});

// Image preview
function handleReviewImages(input) {
    const strip = document.getElementById('rvmPreviewStrip');
    strip.innerHTML = '';
    Array.from(input.files).forEach((file, idx) => {
        const reader = new FileReader();
        reader.onload = e => {
            const wrap   = document.createElement('div');
            wrap.className = 'rvm-preview-item';
            wrap.innerHTML = `
                <img src="${e.target.result}" alt="">
                <button type="button" class="rvm-remove" onclick="removePreview(this)" data-idx="${idx}"
                        aria-label="Remove photo">×</button>`;
            strip.appendChild(wrap);
        };
        reader.readAsDataURL(file);
    });
}

function removePreview(btn) {
    btn.closest('.rvm-preview-item').remove();
}

// Submit feedback
document.getElementById('reviewForm').addEventListener('submit', function() {
    const submitBtn = document.getElementById('rvmSubmitBtn');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Submitting…';
});
</script>
@endpush