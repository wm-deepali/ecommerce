<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Your Order Has Been Delivered – {{ $order->order_number }}</title>
  @include('emails.partials.order-email-base')
</head>

<body>

  <div class="wrapper">

    {{-- Header --}}
    <div class="email-header">
      @if(!empty($logoPath))
        <div style="
                  background:#fff;
                  display:inline-block;
                  padding:12px 20px;
                  border-radius:8px;
                  margin-bottom:10px;
              ">
          <img src="{{ $message->embed($logoPath) }}" alt="{{ $settings->site_name }}"
            style="max-height:70px;max-width:220px;">
        </div>
      @endif

      @if(empty($logoPath))
        <div class="brand">
          {{ $settings->site_name ?? config('app.name') }}
        </div>
      @endif

      @if(!empty($settings->tagline))
        <div class="tagline">
          {{ $settings->tagline }}
        </div>
      @endif

    </div>

    {{-- Hero --}}
    <div style="background: linear-gradient(135deg, #1a2f1a 0%, #2e4a2e 100%); padding: 40px; text-align: center;">
      <div
        style="width:54px;height:54px;background:#2e7d32;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;margin-bottom:14px;">
        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.5"
          stroke-linecap="round" stroke-linejoin="round">
          <polyline points="20 6 9 17 4 12"></polyline>
        </svg>
      </div>
      <h1
        style="font-family:'Playfair Display',Georgia,serif;font-size:24px;font-weight:600;color:#e8f5e9;margin-bottom:6px;">
        Your order has been delivered!
      </h1>
      <p style="font-size:13px;color:#81c784;">
        We hope you love your new piece.<br>
        Thank you for choosing {{ $settings->site_name }}.
      </p>
    </div>

    {{-- Meta Bar --}}
    <div class="meta-bar">
      <div class="meta-cell">
        <span class="meta-label">Order No.</span>
        <span class="meta-value">{{ $order->order_number }}</span>
      </div>
      <div class="meta-cell">
        <span class="meta-label">Delivered On</span>
        <span class="meta-value">{{ now()->format('d M Y') }}</span>
      </div>
      <div class="meta-cell">
        <span class="meta-label">Items</span>
        <span class="meta-value">{{ $order->items->count() }}</span>
      </div>
      <div class="meta-cell">
        <span class="meta-label">Order Total</span>
        <span class="meta-value">₹ {{ number_format($order->grand_total, 2) }}</span>
      </div>
    </div>

    {{-- Body --}}
    <div class="body">

      <p class="greeting">Dear {{ $order->customer_name }},</p>
      <p class="intro">
        Your {{ $settings->site_name }} order has been successfully delivered. We hope your new piece brings
        you joy and that you're delighted with the craftsmanship. Each item in our
        collection is handcrafted with care, and we're grateful you chose us.
      </p>

      {{-- Items --}}
      <div class="section-title">What You Received</div>

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

      {{-- Review Prompt --}}
      <div
        style="background:#fdf8f0;border:1px solid #ede0c8;border-radius:6px;padding:22px 24px;margin:28px 0;text-align:center;">
        <div style="font-size:22px;margin-bottom:8px;">⭐⭐⭐⭐⭐</div>
        <div
          style="font-family:'Playfair Display',Georgia,serif;font-size:16px;color:#1a1a1a;font-weight:600;margin-bottom:6px;">
          How was your experience?
        </div>
        <p style="font-size:12px;color:#888;margin-bottom:16px;line-height:1.6;">
          Your feedback helps our artisans and helps other customers discover beautiful pieces.
          It only takes a moment.
        </p>
        <a href="{{ url('/user/orders/' . $order->id) }}"
          style="display:inline-block;background:#b08d57;color:#ffffff !important;text-decoration:none;font-size:11px;font-weight:600;letter-spacing:0.1em;text-transform:uppercase;padding:12px 24px;border-radius:2px;">
          Write a Review
        </a>
      </div>

      {{-- Delivery + Payment --}}
      <div class="info-grid">
        <div class="info-col">
          <div class="section-title">Delivered To</div>
          <div class="info-box">
            <strong>{{ $order->customer_name }}</strong>
            <p>
              {{ $order->address_line_1 }}
              @if($order->address_line_2), {{ $order->address_line_2 }}@endif<br>
              {{ $order->city?->name }}, {{ $order->state?->name }} – {{ $order->pincode }}
            </p>
          </div>
        </div>
        <div class="info-col">
          <div class="section-title">Payment Summary</div>
          <div class="info-box">
            <strong style="font-size:18px;color:#b08d57;">₹ {{ number_format($order->grand_total, 2) }}</strong>
            <p style="margin-top:6px;">
              {{ ucwords(str_replace('_', ' ', $order->payment_method)) }}<br>
              <span style="color:#2e7d32;font-weight:600;">
                {{ $order->payment_status === 'cod' ? 'Collected on Delivery' : 'Paid' }}
              </span>
            </p>
          </div>
        </div>
      </div>

      {{-- Need Help / Return --}}
      <div style="background:#f9f7f4;border-radius:6px;padding:16px 20px;margin-top:24px;display:table;width:100%;">
        <div style="display:table-cell;vertical-align:middle;">
          <div style="font-size:13px;font-weight:600;color:#1a1a1a;margin-bottom:3px;">
            Something not right?
          </div>
          <div style="font-size:12px;color:#888;">
            We accept returns within 7 days of delivery for eligible items.
          </div>
        </div>
        <div style="display:table-cell;vertical-align:middle;text-align:right;white-space:nowrap;padding-left:16px;">
          <a href="{{ url('/user/orders/' . $order->id) }}"
            style="font-size:11px;font-weight:600;color:#b08d57;text-decoration:none;border:1px solid #d4af7a;padding:8px 14px;border-radius:2px;text-transform:uppercase;letter-spacing:0.06em;">
            Request Return
          </a>
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
        Questions about your delivery? We're here to help.<br>

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