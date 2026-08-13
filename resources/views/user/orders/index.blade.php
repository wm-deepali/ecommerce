@extends('layouts.user-app')

@section('title', 'My Orders')

@section('content')

    @php
        $customer = Auth::guard('customer')->user();
        $allOrders = $customer->orders()->with(['items.product.images'])->latest()->get();

        $counts = [
            'all' => $allOrders->count(),
            'processing' => $allOrders->where('status', 'processing')->count(),
            'delivered' => $allOrders->where('status', 'delivered')->count(),
            'shipped' => $allOrders->where('status', 'shipped')->count(),
            'cancelled' => $allOrders->where('status', 'cancelled')->count(),
        ];

        // Tracker steps definition
        $trackerSteps = [
            'pending' => ['Pending', 'Processing', 'Shipped', 'Delivered'],
            'processing' => ['Pending', 'Processing', 'Shipped', 'Delivered'],
            'shipped' => ['Pending', 'Processing', 'Shipped', 'Delivered'],
            'delivered' => ['Pending', 'Processing', 'Shipped', 'Delivered'],
            'cancelled' => [],
        ];

        $trackerIcons = [
            'Pending' => 'fa-solid fa-clock',
            'Processing' => 'fa-solid fa-box-open',
            'Shipped' => 'fa-solid fa-truck-fast',
            'Delivered' => 'fa-solid fa-house',
        ];

        // Which step index is "active" for each status
        $activeStepMap = [
            'pending' => 0,
            'processing' => 1,
            'shipped' => 2,
            'delivered' => 3,
        ];

        $paymentIcons = [
            'razorpay' => 'fa-solid fa-credit-card',
            'upi' => 'fa-solid fa-building-columns',
            'cod' => 'fa-solid fa-money-bill-wave',
            'netbanking' => 'fa-solid fa-building-columns',
            'card' => 'fa-solid fa-credit-card',
        ];

        $paymentLabels = [
            'razorpay' => 'Paid via Razorpay',
            'upi' => 'UPI / NetBanking',
            'cod' => 'Cash on Delivery',
            'netbanking' => 'Net Banking',
            'card' => 'Card Payment',
        ];

        $statusBadge = [
            'pending' => 'status-processing',
            'processing' => 'status-processing',
            'shipped' => 'status-shipped',
            'delivered' => 'status-delivered',
            'cancelled' => 'status-cancelled',
        ];
    @endphp

    <div class="aq-modern-content aq-orders-page">
        <div class="aq-page-header">
            <h2>My Orders & Payments</h2>
            <p>View your order history, track deliveries, and download invoices.</p>
        </div>

        <!-- Tabs -->
        <div class="aq-order-tabs">
            <button class="active" onclick="filterOrders('all', this)">
                All Orders ({{ $counts['all'] }})
            </button>
            <button onclick="filterOrders('processing', this)">
                Processing ({{ $counts['processing'] }})
            </button>
            <button onclick="filterOrders('shipped', this)">
                Shipped ({{ $counts['shipped'] }})
            </button>
            <button onclick="filterOrders('delivered', this)">
                Completed ({{ $counts['delivered'] }})
            </button>
            <button onclick="filterOrders('cancelled', this)">
                Cancelled ({{ $counts['cancelled'] }})
            </button>
        </div>

        <div class="row">
            <div class="col-lg-12">

                @forelse ($allOrders as $order)
                    @php
                        $status = strtolower($order->status);
                        $activeStep = $activeStepMap[$status] ?? -1;
                        $steps = $trackerSteps[$status] ?? [];
                        $paymentKey = strtolower($order->payment_method ?? 'cod');
                        $paymentIcon = $paymentIcons[$paymentKey] ?? 'fa-solid fa-credit-card';
                        $paymentLbl = $paymentLabels[$paymentKey] ?? ucfirst($order->payment_method ?? 'N/A');
                        $isCancelled = $status === 'cancelled';
                        $isDelivered = $status === 'delivered';
                    @endphp

                    <div class="aq-order-card"
                        data-status="{{ $isCancelled ? 'cancelled' : ($isDelivered ? 'delivered' : $status) }}">

                        <!-- Order Header -->
                        <div class="aq-order-header">
                            <div>
                                <span class="aq-order-id">#{{ $order->order_number }}</span>
                                <span class="aq-order-date">Placed on {{ $order->created_at->format('M d, Y') }}</span>
                            </div>
                            <span class="aq-order-status {{ $statusBadge[$status] ?? '' }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>

                        <!-- Tracker (hidden for cancelled) -->
                        @if (!$isCancelled && count($steps))
                            <div class="aq-order-tracker">
                                @foreach ($steps as $i => $step)
                                    @php
                                        $isCompleted = $i < $activeStep;
                                        $isActive = $i === $activeStep;
                                        $stepClass = $isCompleted ? 'completed' : ($isActive ? 'active' : '');
                                    @endphp
                                    <div class="aq-order-tracker-step {{ $stepClass }}">
                                        <div class="aq-order-tracker-icon">
                                            <i
                                                class="{{ $isCompleted ? 'fa-solid fa-check' : ($trackerIcons[$step] ?? 'fa-solid fa-circle') }}"></i>
                                        </div>
                                        <span class="aq-order-tracker-label">{{ $step }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <!-- Order Items -->
                        <div class="aq-order-items">
                            @foreach ($order->items as $item)
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
                                                    $attrVal = $value['value'] ?? $value['label'] ?? reset($value);
                                                    return $attrName . ': ' . $attrVal;
                                                }
                                                return $key . ': ' . $value;
                                            })
                                            ->join(' | ');
                                    }
                                @endphp
                                <div class="aq-order-item">
                                    <img src="{{ $thumb }}" alt="{{ $item->product_name }}">
                                    <div class="aq-order-item-details">
                                        <h4>{{ $item->product_name }}</h4>
                                        <p>
                                            @if($variantLabel)
                                                {{ $variantLabel }} |
                                            @endif

                                            @if($item->addons->isNotEmpty())
                                                {{ $item->addons->pluck('detail')->implode(', ') }} |
                                            @endif

                                            Qty: {{ $item->quantity }}
                                        </p>
                                    </div>
                                    <div class="aq-order-item-price">
                                        ₹ {{ number_format($item->price * $item->quantity) }}
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Footer -->
                        <div class="aq-order-footer">
                            <div class="aq-order-payment-info">
                                <div class="aq-payment-method {{ $isCancelled ? 'text-danger' : '' }}">
                                    @if ($isCancelled)
                                        <i class="fa-solid fa-money-bill-transfer"></i>
                                        @if ($order->payment_status === 'refunded')
                                            Refund Initiated (3–5 days)
                                        @else
                                            Payment Cancelled
                                        @endif
                                    @else
                                        <i class="{{ $paymentIcon }}"></i> {{ $paymentLbl }}
                                    @endif
                                </div>
                                <span class="aq-order-total-price">
                                    Total: ₹ {{ number_format($order->grand_total) }}
                                </span>
                            </div>

                            <div class="aq-order-actions">
                                <!-- View Details -->
                                <a href="{{ route('user.orders.show', $order->id) }}" class="aq-btn-invoice">
                                    <i class="fa-solid fa-eye"></i> View Details
                                </a>

                                @if ($isCancelled)
                                    {{-- Reorder --}}
                                    <a href="{{ route('user.orders.reorder', $order->id) }}" class="aq-btn-invoice">
                                        <i class="fa-solid fa-cart-shopping"></i> Reorder
                                    </a>
                                @else
                                    {{-- Invoice --}}
                                    @if ($order->invoice)
                                        <a href="{{ route('user.orders.invoice', $order->id) }}" class="aq-btn-invoice" target="_blank">
                                            <i class="fa-solid fa-file-invoice"></i> Download Invoice
                                        </a>
                                    @else
                                        <span class="aq-btn-invoice" style="opacity:0.5; pointer-events:none; cursor:not-allowed;">
                                            <i class="fa-solid fa-file-invoice"></i> No Invoice
                                        </span>
                                    @endif

                                    {{-- Track --}}
                                    @if (in_array($status, ['processing', 'shipped']))
                                        <a href="#" class="aq-btn-track" data-bs-toggle="modal" data-bs-target="#trackOrderModal"
                                            data-order-id="{{ $order->id }}" data-order-number="{{ $order->order_number }}"
                                            data-order-status="{{ $order->status }}"
                                            data-order-date="{{ $order->created_at->format('M d, Y') }}"
                                            data-tracking-number="{{ $order->tracking_number }}" data-status-history='@json(
                                                $order->statusHistory->map(fn($h) => [
                                                    "status" => $h->status,
                                                    "time" => $h->created_at->format("d M Y h:i A"),
                                                ])
                                            )'>
                                            <i class="fa-solid fa-location-crosshairs"></i> Track Order
                                        </a>
                                    @endif


                                    {{-- ══════════════════════════════════════════════════════════════
                                    1. RETURN BUTTON — replace @if ($isDelivered ...) block
                                    ══════════════════════════════════════════════════════════════ --}}
                                    @if ($isDelivered && $order->created_at->diffInDays(now()) <= 7)
                                        @php
                                            $existingReturn = $order->returns()
                                                ->whereIn('status', ['pending', 'approved', 'completed'])
                                                ->first();
                                        @endphp

                                        @if ($existingReturn)
                                            <span class="aq-btn-invoice" style="opacity:.55;cursor:not-allowed;">
                                                <i class="fa-solid fa-arrow-rotate-left"></i>
                                                Return {{ ucfirst($existingReturn->status) }}
                                            </span>
                                        @else
                                            <a href="#" class="aq-btn-invoice" data-bs-toggle="modal" data-bs-target="#returnModal"
                                                data-order-id="{{ $order->id }}" data-order-number="{{ $order->order_number }}"
                                                data-order-items="{{ $order->items->pluck('product_name', 'id')->toJson() }}">
                                                <i class="fa-solid fa-arrow-rotate-left"></i> Return
                                            </a>
                                        @endif
                                    @endif


                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="aq-empty-state text-center py-5">
                        <i class="fa-solid fa-bag-shopping fa-3x mb-3" style="color: var(--aq-color-maroon); opacity:.4;"></i>
                        <p class="mb-3">You haven't placed any orders yet.</p>
                        <a href="{{ route('home') }}" class="aq-btn-track">Start Shopping</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Track Order Modal -->
    <div class="modal fade aq-premium-modal track-order-modal" id="trackOrderModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
            <div class="modal-content">
                <button type="button" class="btn-close position-absolute" style="top:20px;right:20px;z-index:10;"
                    data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="p-4">
                    <h3 class="font-family-heading mb-1">Track Your Order</h3>
                    <p class="text-muted mb-4" id="trackOrderMeta"></p>
                    <div id="trackingInfo" class="mb-3"
                        style="display:none;padding:10px 12px;background:#f8f9fa;border-radius:8px;">
                        <strong>Tracking Number:</strong>
                        <span id="trackingNumber"></span>
                    </div>

                    <div class="aq-order-tracker"
                        style="flex-direction:column;align-items:flex-start;gap:20px;padding-left:20px;margin:20px 0;">
                        @php
                            $modalSteps = [
                                ['label' => 'Pending', 'icon' => 'fa-solid fa-clock'],
                                ['label' => 'Processing', 'icon' => 'fa-solid fa-box-open'],
                                ['label' => 'Shipped', 'icon' => 'fa-solid fa-truck-fast'],
                                ['label' => 'Delivered', 'icon' => 'fa-solid fa-house'],
                            ];
                        @endphp
                        @foreach ($modalSteps as $ms)
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


    {{-- ══════════════════════════════════════════════════════════════
    2. RETURN MODAL — replace the entire #returnModal div
    NOTE: form has enctype because QR upload is a file
    ══════════════════════════════════════════════════════════════ --}}
    <div class="modal fade aq-premium-modal return-modal" id="returnModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width:460px;">
            <div class="modal-content">
                <button type="button" class="btn-close position-absolute" style="top:20px;right:20px;z-index:10;"
                    data-bs-dismiss="modal" aria-label="Close"></button>

                <div class="p-4" style="max-height:88vh;overflow-y:auto;">
                    <h3 class="font-family-heading mb-1">Return or Exchange</h3>
                    <p class="text-muted mb-4" id="returnOrderMeta"></p>

                    <form action="{{ route('user.orders.return') }}" method="POST" enctype="multipart/form-data"
                        id="returnForm">
                        @csrf
                        <input type="hidden" name="order_id" id="returnOrderId">

                        {{-- ── Item ── --}}
                        <div class="rtn-field-group">
                            <label class="rtn-label">Select Item <span class="rtn-req">*</span></label>
                            <select class="rtn-select" name="order_item_id" id="returnItemSelect" required>
                                <option value="" disabled selected>Select an item</option>
                            </select>
                        </div>

                        {{-- ── Type toggle ── --}}
                        <div class="rtn-field-group">
                            <label class="rtn-label">Request Type <span class="rtn-req">*</span></label>
                            <div class="rtn-type-row">
                                <label class="rtn-type-opt">
                                    <input type="radio" name="type" value="return" checked>
                                    <span class="rtn-type-btn">
                                        <i class="fa-solid fa-arrow-rotate-left"></i> Return
                                    </span>
                                </label>
                            </div>
                        </div>

                        {{-- ── Reason ── --}}
                        <div class="rtn-field-group">
                            <label class="rtn-label">Reason <span class="rtn-req">*</span></label>
                            <select class="rtn-select" name="return_reason_id" required>
                                <option value="" disabled selected>Select a reason</option>
                                @foreach ($returnReasons as $reason)
                                    <option value="{{ $reason->id }}">{{ $reason->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- ── Details ── --}}
                        <div class="rtn-field-group">
                            <label class="rtn-label">Additional Details</label>
                            <textarea class="rtn-textarea" name="details" rows="2"
                                placeholder="Describe the issue…"></textarea>
                        </div>

                        {{-- ════════════════════════════════════════════════════
                        REFUND INFO SECTION
                        ════════════════════════════════════════════════════ --}}
                        <div class="rtn-divider">
                            <span>Refund Information</span>
                        </div>

                        {{-- ── Refund method dropdown ── --}}
                        <div class="rtn-field-group">
                            <label class="rtn-label">Refund Via <span class="rtn-req">*</span></label>
                            <select class="rtn-select" name="refund_method" id="refundMethod" required
                                onchange="switchRefundMethod(this.value)">
                                <option value="" disabled selected>Select bank info type</option>
                                <option value="upi">UPI ID</option>
                                <option value="qr">QR Code</option>
                                <option value="bank">Bank Details</option>
                            </select>
                        </div>

                        {{-- ── UPI panel ── --}}
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

                        {{-- ── QR panel ── --}}
                        <div id="rtnPanelQr" class="rtn-panel" style="display:none;">
                            <div class="rtn-field-group">
                                <label class="rtn-label">Upload QR Code <span class="rtn-req">*</span></label>
                                <div class="rtn-upload-area" id="qrUploadArea"
                                    onclick="document.getElementById('qrFile').click()">
                                    <input type="file" name="qr_image" id="qrFile" accept="image/*" style="display:none"
                                        onchange="previewQr(this)">
                                    <div id="qrPlaceholder">
                                        <i class="fa-solid fa-qrcode" style="font-size:26px;color:#8c9196;"></i>
                                        <p style="margin:6px 0 0;font-size:13px;color:#6d7175;">Click to upload your UPI QR
                                        </p>
                                        <small style="color:#8c9196;">PNG, JPG — max 2 MB</small>
                                    </div>
                                    <div id="qrPreview" style="display:none;text-align:center;">
                                        <img id="qrPreviewImg" src=""
                                            style="max-width:130px;border-radius:8px;border:1px solid #e3e5e8;">
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

                        {{-- ── Bank Details panel ── --}}
                        <div id="rtnPanelBank" class="rtn-panel" style="display:none;">

                            <div class="rtn-field-group">
                                <label class="rtn-label">Bank Name <span class="rtn-req">*</span></label>
                                <input type="text" class="rtn-input" name="bank_name"
                                    placeholder="e.g. State Bank of India">
                            </div>

                            <div class="rtn-field-group">
                                <label class="rtn-label">Account Holder Name <span class="rtn-req">*</span></label>
                                <input type="text" class="rtn-input" name="account_name"
                                    placeholder="Name as on bank account">
                            </div>

                            <div class="rtn-2col">
                                <div class="rtn-field-group">
                                    <label class="rtn-label">Account Number <span class="rtn-req">*</span></label>
                                    <input type="text" class="rtn-input" name="account_number"
                                        placeholder="XXXXXXXXXXXXXXXXXX" inputmode="numeric">
                                </div>
                                <div class="rtn-field-group">
                                    <label class="rtn-label">IFSC Code <span class="rtn-req">*</span></label>
                                    <input type="text" class="rtn-input" name="ifsc_code" placeholder="e.g. SBIN0001234"
                                        style="text-transform:uppercase" oninput="this.value=this.value.toUpperCase()">
                                </div>
                            </div>

                            <div class="rtn-2col">
                                <div class="rtn-field-group">
                                    <label class="rtn-label">Branch</label>
                                    <input type="text" class="rtn-input" name="bank_branch"
                                        placeholder="e.g. Connaught Place">
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
                        {{-- ─────────────────────────────────────────────────── --}}

                        <button type="submit" class="rtn-submit-btn">
                            <i class="fa-solid fa-paper-plane"></i> Submit Return Request
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection



<style>
    /* Return modal fields */
    .rtn-field-group {
        margin-bottom: 14px;
    }

    .rtn-field-group:last-child {
        margin-bottom: 0;
    }

    .rtn-label {
        display: block;
        font-size: 11.5px;
        font-weight: 600;
        color: #6d7175;
        text-transform: uppercase;
        letter-spacing: .03em;
        margin-bottom: 5px;
    }

    .rtn-req {
        color: #b22222;
        margin-left: 2px;
    }

    .rtn-hint {
        font-size: 11px;
        color: #8c9196;
        margin-top: 3px;
    }

    .rtn-input,
    .rtn-select,
    .rtn-textarea {
        width: 100%;
        border: 1px solid #e3e5e8;
        border-radius: 8px;
        padding: 0 12px;
        height: 38px;
        font-size: 13px;
        color: #202223;
        background: #fff;
        outline: none;
        font-family: inherit;
        transition: border-color .15s, box-shadow .15s;
    }

    .rtn-input:focus,
    .rtn-select:focus,
    .rtn-textarea:focus {
        border-color: var(--aq-color-maroon, #7b1010);
        box-shadow: 0 0 0 3px rgba(123, 16, 16, .1);
    }

    .rtn-textarea {
        height: auto;
        padding: 9px 12px;
        resize: none;
    }

    /* Icon-prefixed input */
    .rtn-input-icon-wrap {
        position: relative;
    }

    .rtn-input-icon {
        position: absolute;
        left: 11px;
        top: 50%;
        transform: translateY(-50%);
        color: #8c9196;
        font-size: 13px;
        pointer-events: none;
    }

    .rtn-input-icon-pad {
        padding-left: 32px !important;
    }

    /* 2-column grid */
    .rtn-2col {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    @media(max-width: 480px) {
        .rtn-2col {
            grid-template-columns: 1fr;
        }
    }

    /* Type toggle */
    .rtn-type-row {
        display: flex;
        gap: 8px;
    }

    .rtn-type-opt {
        flex: 1;
        cursor: pointer;
    }

    .rtn-type-opt input[type=radio] {
        display: none;
    }

    .rtn-type-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 9px 12px;
        border: 1.5px solid #e3e5e8;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 500;
        color: #6d7175;
        transition: border-color .15s, color .15s, background .15s;
    }

    .rtn-type-opt input[type=radio]:checked+.rtn-type-btn {
        border-color: var(--aq-color-maroon, #7b1010);
        color: var(--aq-color-maroon, #7b1010);
        background: rgba(123, 16, 16, .04);
    }

    /* Divider */
    .rtn-divider {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 18px 0 16px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .06em;
        color: #8c9196;
    }

    .rtn-divider::before,
    .rtn-divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #e3e5e8;
    }

    /* QR upload area */
    .rtn-upload-area {
        border: 2px dashed #e3e5e8;
        border-radius: 10px;
        padding: 20px 16px;
        text-align: center;
        cursor: pointer;
        transition: border-color .15s, background .15s;
    }

    .rtn-upload-area:hover {
        border-color: var(--aq-color-maroon, #7b1010);
        background: rgba(123, 16, 16, .03);
    }

    /* Submit */
    .rtn-submit-btn {
        width: 100%;
        margin-top: 18px;
        padding: 12px;
        background: var(--aq-color-maroon, #7b1010);
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: opacity .15s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .rtn-submit-btn:hover {
        opacity: .9;
    }
</style>



@push('scripts')
    <script>
        // ── Tab Filter ──────────────────────────────────────────────────────────
        function filterOrders(status, btn) {
            document.querySelectorAll('.aq-order-tabs button').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            document.querySelectorAll('.aq-order-card').forEach(card => {
                const match = status === 'all' || card.dataset.status === status;
                card.style.display = match ? '' : 'none';
            });
        }

        // ── Track Order Modal ───────────────────────────────────────────────────
        document.getElementById('trackOrderModal').addEventListener('show.bs.modal', function (e) {
            const trigger = e.relatedTarget;
            const number = trigger.dataset.orderNumber;
            const status = trigger.dataset.orderStatus;
            const date = trigger.dataset.orderDate;

            document.getElementById('trackOrderMeta').textContent =
                `Order #${number} • Placed ${date}`;

            const steps = this.querySelectorAll('.track-modal-step');
            const statusMap = { pending: 0, processing: 1, shipped: 2, delivered: 3 };
            const active = statusMap[status.toLowerCase()] ?? 0;

            steps.forEach((step, i) => {
                step.classList.remove('completed', 'active');
                if (i < active) step.classList.add('completed');
                else if (i === active) step.classList.add('active');
            });

            const trackingNo = trigger.dataset.trackingNumber;

            if (trackingNo) {
                document.getElementById('trackingInfo').style.display = 'block';
                document.getElementById('trackingNumber').textContent = trackingNo;
            } else {
                document.getElementById('trackingInfo').style.display = 'none';
            }

            const history = JSON.parse(
                trigger.dataset.statusHistory || '[]'
            );

            const times = this.querySelectorAll('.track-modal-time');

            times.forEach(el => el.textContent = '—');

            const map = {
                pending: 0,
                processing: 1,
                shipped: 2,
                delivered: 3
            };

            history.forEach(item => {
                const idx = map[item.status];

                if (idx !== undefined && times[idx]) {
                    times[idx].textContent = item.time;
                }
            });

        });


    </script>

    <script>
        // ── Return Modal open ────────────────────────────────────────────
        document.getElementById('returnModal').addEventListener('show.bs.modal', function (e) {
            const trigger = e.relatedTarget;
            const orderId = trigger.dataset.orderId;
            const number = trigger.dataset.orderNumber;
            const items = JSON.parse(trigger.dataset.orderItems || '{}');

            document.getElementById('returnOrderId').value = orderId;
            document.getElementById('returnOrderMeta').textContent =
                `Requesting a return for Order #${number}.`;

            // Populate item select
            const select = document.getElementById('returnItemSelect');
            select.innerHTML = '<option value="" disabled selected>Select an item</option>';
            Object.entries(items).forEach(([id, name]) => {
                const opt = document.createElement('option');
                opt.value = id;
                opt.textContent = name;
                select.appendChild(opt);
            });

            // Reset type toggle
            document.querySelectorAll('.rtn-type-opt input[type=radio]').forEach(r => {
                r.checked = r.value === 'return';
            });

            // Reset refund section
            document.getElementById('refundMethod').value = '';
            switchRefundMethod('');

            // Clear QR
            clearQr();
        });

        // ── Refund method switcher ──────────────────────────────────────
        function switchRefundMethod(val) {
            ['upi', 'qr', 'bank'].forEach(k => {
                const panel = document.getElementById('rtnPanel' + k.charAt(0).toUpperCase() + k.slice(1));
                if (panel) panel.style.display = val === k ? 'block' : 'none';
            });
            // Toggle required on UPI input
            const upiField = document.getElementById('upiIdField');
            if (upiField) upiField.required = val === 'upi';
            // Toggle required on QR file
            const qrFile = document.getElementById('qrFile');
            if (qrFile) qrFile.required = val === 'qr';
        }

        // ── QR preview ─────────────────────────────────────────────────
        function previewQr(input) {
            if (!input.files || !input.files[0]) return;
            const reader = new FileReader();
            reader.onload = e => {
                document.getElementById('qrPreviewImg').src = e.target.result;
                document.getElementById('qrPreview').style.display = 'block';
                document.getElementById('qrPlaceholder').style.display = 'none';
            };
            reader.readAsDataURL(input.files[0]);
        }

        function clearQr(e) {
            if (e) e.stopPropagation();
            const qrFile = document.getElementById('qrFile');
            if (qrFile) qrFile.value = '';
            const preview = document.getElementById('qrPreview');
            const placeholder = document.getElementById('qrPlaceholder');
            if (preview) preview.style.display = 'none';
            if (placeholder) placeholder.style.display = 'block';
        }
    </script>


@endpush