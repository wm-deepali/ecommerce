<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Order Confirmation – {{ $order->order_number }}</title>
@include('emails.partials.order-email-base')
</head>
<body>

<div class="wrapper">

  {{-- ── Header ── --}}
  <div class="email-header">

    @if(!empty($logoPath))
      <div style="background:#ffffff;display:inline-block;padding:12px 20px;border-radius:8px;margin-bottom:15px;">
        <img src="{{ $message->embed($logoPath) }}"
             alt="{{ $settings->site_name }}"
             style="max-height:70px;max-width:220px;">
      </div>
    @endif

    <div class="brand">
      {{ $settings->site_name ?? config('app.name') }}
    </div>

    @if(!empty($settings->tagline))
      <div class="tagline">{{ $settings->tagline }}</div>
    @endif

  </div>

  {{-- ── Hero ── --}}
  <div style="background: linear-gradient(135deg, #2c1f14 0%, #4a3728 100%); padding: 40px; text-align: center;">
    <div style="width:54px;height:54px;background:#d4af7a;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;margin-bottom:14px;">
      <svg width="26" height="26" viewBox="0 0 24 24" fill="none"
           stroke="#1a1a1a" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="20 6 9 17 4 12"></polyline>
      </svg>
    </div>
    <h1 style="font-family:'Playfair Display',Georgia,serif;font-size:26px;font-weight:600;color:#f5f0e8;margin-bottom:6px;">
      Your order is confirmed!
    </h1>
    <p style="font-size:13px;color:#c4b49a;line-height:1.6;">
      Thank you, {{ $order->customer_name }}. We've received your order and<br>
      our artisans are preparing your piece with care.
    </p>
  </div>

  {{-- ── Meta Bar ── --}}
  <div class="meta-bar">
    <div class="meta-cell">
      <span class="meta-label">Order No.</span>
      <span class="meta-value">{{ $order->order_number }}</span>
    </div>
    <div class="meta-cell">
      <span class="meta-label">Order Date</span>
      <span class="meta-value">{{ $order->created_at->format('d M Y') }}</span>
    </div>
    <div class="meta-cell">
      <span class="meta-label">Payment</span>
      <span class="meta-value">{{ ucwords(str_replace('_', ' ', $order->payment_method)) }}</span>
    </div>
    <div class="meta-cell">
      <span class="meta-label">Items</span>
      <span class="meta-value">{{ $order->items->count() }}</span>
    </div>
  </div>

  {{-- ── Body ── --}}
  <div class="body">

    <p class="greeting">Dear {{ $order->customer_name }},</p>
    <p class="intro">
      We're delighted to confirm your order at
      {{ $settings->site_name ?? config('app.name') }}.
      Each piece in our collection is crafted by skilled artisans and will be
      carefully packaged to reach you in perfect condition. You'll receive a
      shipping notification as soon as your order is dispatched.
    </p>

    {{-- ── Order Items ── --}}
    <div class="section-title">Order Summary</div>

    @foreach($order->items as $item)
      @php
        $variantLabel = '';
        if ($item->variant) {
          $variantLabel = $item->variant->values
            ->map(fn($v) => $v->attributeValue->attribute->name . ': ' . $v->attributeValue->value)
            ->join(', ');
        }
      @endphp
      <div class="item-row">
        <div class="item-img-cell">
          @if(isset($productImages[$item->id]))
            <img src="{{ $message->embed($productImages[$item->id]) }}"
                 alt="{{ $item->product_name }}"
                 class="item-img">
          @else
            <span class="item-img-placeholder"></span>
          @endif
        </div>
        <div class="item-detail-cell">
          <div class="item-name">{{ $item->product_name }}</div>
          @if($variantLabel)
            <div class="item-meta">{{ $variantLabel }}</div>
          @endif
          <div class="item-meta">Qty: {{ $item->quantity }}</div>
        </div>
        <div class="item-price-cell">₹ {{ number_format($item->total, 2) }}</div>
      </div>
    @endforeach

    {{-- ── Totals ── --}}
    <div style="margin-top:16px;">

      <div style="display:table;width:100%;padding:5px 0;">
        <span style="display:table-cell;font-size:13px;color:#666;">Subtotal</span>
        <span style="display:table-cell;text-align:right;font-size:13px;color:#333;">
          ₹ {{ number_format($order->subtotal, 2) }}
        </span>
      </div>

      @if($order->discount > 0)
        <div style="display:table;width:100%;padding:5px 0;">
          <span style="display:table-cell;font-size:13px;color:#2e7d32;font-weight:500;">
            Discount @if($order->coupon_code)({{ $order->coupon_code }})@endif
          </span>
          <span style="display:table-cell;text-align:right;font-size:13px;color:#2e7d32;font-weight:500;">
            − ₹ {{ number_format($order->discount, 2) }}
          </span>
        </div>
      @endif

      @if($order->tax_amount > 0)
        @if($order->gst_type === 'igst')
          <div style="display:table;width:100%;padding:5px 0;">
            <span style="display:table-cell;font-size:13px;color:#666;">IGST ({{ $order->igst_rate }}%)</span>
            <span style="display:table-cell;text-align:right;font-size:13px;color:#333;">
              ₹ {{ number_format($order->igst_amount, 2) }}
            </span>
          </div>
        @else
          @if($order->cgst_amount > 0)
            <div style="display:table;width:100%;padding:5px 0;">
              <span style="display:table-cell;font-size:13px;color:#666;">CGST ({{ $order->cgst_rate }}%)</span>
              <span style="display:table-cell;text-align:right;font-size:13px;color:#333;">
                ₹ {{ number_format($order->cgst_amount, 2) }}
              </span>
            </div>
          @endif
          @if($order->sgst_amount > 0)
            <div style="display:table;width:100%;padding:5px 0;">
              <span style="display:table-cell;font-size:13px;color:#666;">SGST ({{ $order->sgst_rate }}%)</span>
              <span style="display:table-cell;text-align:right;font-size:13px;color:#333;">
                ₹ {{ number_format($order->sgst_amount, 2) }}
              </span>
            </div>
          @endif
        @endif
      @endif

      <hr style="border:none;border-top:1px solid #ede8e0;margin:10px 0;">

      <div style="display:table;width:100%;padding:5px 0;">
        <span style="display:table-cell;font-size:15px;font-weight:600;color:#1a1a1a;">Grand Total</span>
        <span style="display:table-cell;text-align:right;font-size:16px;font-weight:700;color:#b08d57;">
          ₹ {{ number_format($order->grand_total, 2) }}
        </span>
      </div>

    </div>

    {{-- ── Delivery Address + Payment ── --}}
    <div class="info-grid">
      <div class="info-col">
        <div class="section-title" style="margin-top:24px;">Delivery Address</div>
        <div class="info-box">
          <strong>{{ $order->customer_name }}</strong>
          <p>
            {{ $order->address_line_1 }}
            @if($order->address_line_2), {{ $order->address_line_2 }}@endif<br>
            {{ $order->city?->name }}, {{ $order->state?->name }} – {{ $order->pincode }}<br>
            📞 {{ $order->customer_phone }}
          </p>
        </div>
      </div>

      <div class="info-col">
        <div class="section-title" style="margin-top:24px;">Payment Info</div>
        <div class="info-box">
          <strong>{{ ucwords(str_replace('_', ' ', $order->payment_method)) }}</strong>
          <p>
            Status:
            @php
              $badges = [
                'paid'    => ['label' => 'Paid',            'color' => '#2e7d32'],
                'pending' => ['label' => 'Pending',         'color' => '#f57f17'],
                'cod'     => ['label' => 'Pay on Delivery', 'color' => '#1565c0'],
                'failed'  => ['label' => 'Failed',          'color' => '#c62828'],
              ];
              $badge = $badges[$order->payment_status] ?? ['label' => ucfirst($order->payment_status), 'color' => '#f57f17'];
            @endphp
            <span style="font-weight:600;color:{{ $badge['color'] }};">
              {{ $badge['label'] }}
            </span>
          </p>
          @if($order->transaction_id)
            <p style="margin-top:6px;font-size:11px;color:#aaa;">
              Txn: {{ $order->transaction_id }}
            </p>
          @endif
        </div>
      </div>
    </div>

    {{-- ── CTA ── --}}
    <div class="cta-section">
      <a href="{{ url('/user/orders/' . $order->id) }}" class="cta-btn">
        View Order Details
      </a>
    </div>

  </div>

  {{-- ── Help Strip ── --}}
  <div class="help-strip">
    <p>
      Questions about your order? We're happy to help.<br>

      @if($settings?->support_email)
        Email us at
        <a href="mailto:{{ $settings->support_email }}">{{ $settings->support_email }}</a>
      @endif

      @if($settings?->phone)
        <br>Call us at
        <a href="tel:{{ $settings->phone }}">{{ $settings->phone }}</a>
      @endif
    </p>
  </div>

  {{-- ── Footer ── --}}
  <div class="email-footer">
    <span class="brand-footer">{{ $settings->site_name ?? config('app.name') }}</span>
    <p>
      <a href="{{ url('/unsubscribe') }}">Unsubscribe</a> &nbsp;·&nbsp;
      <a href="{{ url('/privacy') }}">Privacy Policy</a>
    </p>
    <p style="margin-top:8px;">
      © {{ date('Y') }} {{ $settings->site_name ?? config('app.name') }}. All rights reserved.
    </p>
  </div>

</div>

</body>
</html>