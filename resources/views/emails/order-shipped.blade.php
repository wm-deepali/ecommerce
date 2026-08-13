<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Your Order Has Been Shipped – {{ $order->order_number }}</title>
  @include('emails.partials.order-email-base')
</head>

<body>

  <div class="wrapper">

    {{-- Header --}}
    <div class="email-header">

      @if(!empty($logoPath))
    <div style="
        background:#ffffff;
        display:inline-block;
        padding:12px 20px;
        border-radius:8px;
        margin-bottom:15px;
    ">
        <img src="{{ $message->embed($logoPath) }}"
             alt="{{ $settings->site_name }}"
             style="max-height:70px;max-width:220px;">
    </div>
@endif

      <div class="brand">
        {{ $settings->site_name ?? config('app.name') }}
      </div>

      @if(!empty($settings->tagline))
        <div class="tagline">
          {{ $settings->tagline }}
        </div>
      @endif

    </div>

    {{-- Hero --}}
    <div style="background: linear-gradient(135deg, #0d2137 0%, #1a3a5c 100%); padding: 40px; text-align: center;">
      <div
        style="width:54px;height:54px;background:#1565c0;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;margin-bottom:14px;">
        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.2"
          stroke-linecap="round" stroke-linejoin="round">
          <rect x="1" y="3" width="15" height="13" rx="1"></rect>
          <path d="M16 8h4l3 5v3h-7V8z"></path>
          <circle cx="5.5" cy="18.5" r="2.5"></circle>
          <circle cx="18.5" cy="18.5" r="2.5"></circle>
        </svg>
      </div>
      <h1
        style="font-family:'Playfair Display',Georgia,serif;font-size:24px;font-weight:600;color:#e8f1fb;margin-bottom:6px;">
        Your order is on its way!
      </h1>
      <p style="font-size:13px;color:#90b4d4;">
        Your package has been handed over to the courier<br>and is heading to you now.
      </p>
    </div>

    {{-- Meta Bar --}}
    <div class="meta-bar">
      <div class="meta-cell">
        <span class="meta-label">Order No.</span>
        <span class="meta-value">{{ $order->order_number }}</span>
      </div>
      <div class="meta-cell">
        <span class="meta-label">Shipped On</span>
        <span class="meta-value">{{ now()->format('d M Y') }}</span>
      </div>
      @if($order->courier)
        <div class="meta-cell">
          <span class="meta-label">Courier</span>
          <span class="meta-value">{{ $order->courier->name }}</span>
        </div>
      @endif
      @if($order->tracking_number)
        <div class="meta-cell">
          <span class="meta-label">Tracking No.</span>
          <span class="meta-value">{{ $order->tracking_number }}</span>
        </div>
      @endif
    </div>

    {{-- Body --}}
    <div class="body">

      <p class="greeting">Dear {{ $order->customer_name }},</p>
      <p class="intro">
        Great news! Your {{ $settings->site_name }} order has been dispatched and is on its way to you.
        Our artisans have carefully packaged your piece to ensure it arrives in
        perfect condition. Please allow the estimated delivery time as per your
        location before reaching out to us.
      </p>

      {{-- Tracking Box --}}
      @if($order->tracking_number)
        <div style="background:#eef4fb;border:1px solid #c5d9f0;border-radius:6px;padding:18px 20px;margin-bottom:28px;">
          <div
            style="font-size:10px;text-transform:uppercase;letter-spacing:0.12em;color:#1565c0;font-weight:600;margin-bottom:8px;">
            Tracking Information
          </div>
          <div style="display:table;width:100%">
            <div style="display:table-cell;vertical-align:middle">
              @if($order->courier)
                <div style="font-size:13px;font-weight:600;color:#1a1a1a;">{{ $order->courier->name }}</div>
              @endif
              <div style="font-size:13px;color:#1565c0;font-weight:500;margin-top:2px;">
                {{ $order->tracking_number }}
              </div>
            </div>
            @if($order->courier?->website_url)
              <div style="display:table-cell;vertical-align:middle;text-align:right;">
                <a href="{{ $order->courier->website_url }}" target="_blank"
                  style="display:inline-block;background:#1565c0;color:#ffffff !important;text-decoration:none;font-size:11px;font-weight:600;letter-spacing:0.08em;text-transform:uppercase;padding:9px 18px;border-radius:2px;">
                  Track Package
                </a>
              </div>
            @endif
          </div>
        </div>
      @endif

      {{-- Order Items --}}
      <div class="section-title">Items In Your Shipment</div>

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
              <img src="{{ $message->embed($productImages[$item->id]) }}" alt="{{ $item->product_name }}" class="item-img">
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

      {{-- Delivery Address --}}
      <div class="info-grid">
        <div class="info-col">
          <div class="section-title" style="margin-top:20px;">Delivering To</div>
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
          <div class="section-title" style="margin-top:20px;">Order Total</div>
          <div class="info-box">
            <strong style="font-size:20px;color:#b08d57;">₹ {{ number_format($order->grand_total, 2) }}</strong>
            <p style="margin-top:6px;">
              Payment: {{ ucwords(str_replace('_', ' ', $order->payment_method)) }}<br>
              Status:
              @if($order->payment_status === 'paid')
                <span style="color:#2e7d32;font-weight:600;">Paid</span>
              @elseif($order->payment_status === 'cod')
                <span style="color:#1565c0;font-weight:600;">Pay on Delivery</span>
              @else
                <span style="color:#f57f17;font-weight:600;">{{ ucfirst($order->payment_status) }}</span>
              @endif
            </p>
          </div>
        </div>
      </div>

      {{-- CTA --}}
      <div class="cta-section">
        <a href="{{ url('/user/orders/' . $order->id) }}" class="cta-btn">
          View Order Details
        </a>
      </div>

    </div>

    {{-- Help --}}
    <div class="help-strip">
      <p>
        Need help with your shipment?<br>

        @if($settings?->support_email)
          Email us at
          <a href="mailto:{{ $settings->support_email }}">
            {{ $settings->support_email }}
          </a>
        @endif

        @if($settings?->phone)
          <br>
          Call us at
          <a href="tel:{{ $settings->phone }}">
            {{ $settings->phone }}
          </a>
        @endif
      </p>
    </div>

    {{-- Footer --}}
    <div class="email-footer">

      <span class="brand-footer">
        {{ $settings->site_name }}
      </span>

      <p style="margin-top:8px;">
        © {{ date('Y') }}
        {{ $settings->site_name }}.
        All rights reserved.
      </p>

    </div>

  </div>

</body>

</html>