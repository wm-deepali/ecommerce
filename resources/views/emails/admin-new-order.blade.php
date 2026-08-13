<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>New Order – {{ $order->order_number }}</title>
@include('emails.partials.order-email-base')
<style>
  .items-table { width:100%; border-collapse:collapse; margin-bottom:4px; }
  .items-table thead tr { background:#f5f5f5; border-bottom:1px solid #e8e8e8; }
  .items-table thead th { font-size:10px; text-transform:uppercase; letter-spacing:0.08em; color:#888; font-weight:600; padding:8px 10px; text-align:left; }
  .items-table thead th:last-child { text-align:right; }
  .items-table tbody tr { border-bottom:1px solid #f0f0f0; }
  .items-table tbody tr:last-child { border-bottom:none; }
  .items-table tbody td { padding:12px 10px; vertical-align:top; font-size:13px; color:#333; }
  .items-table tbody td:last-child { text-align:right; font-weight:600; }
  .totals-table { width:100%; border-collapse:collapse; margin-top:8px; }
  .totals-table td { padding:5px 10px; font-size:13px; }
  .totals-table .t-label { color:#666; }
  .totals-table .t-value { text-align:right; color:#333; }
  .totals-table .discount .t-label,
  .totals-table .discount .t-value { color:#2e7d32; font-weight:500; }
  .totals-table .grand-row td { padding-top:10px; border-top:2px solid #111; font-size:15px; font-weight:700; }
  .totals-table .grand-row .t-value { color:#b08d57; }
  .gst-block { background:#fafafa; border:1px solid #eeeeee; border-radius:4px; padding:12px 16px; margin-top:4px; }
  .gst-row { display:table; width:100%; font-size:12px; padding:3px 0; }
  .gst-row span { display:table-cell; color:#666; }
  .gst-row span:last-child { text-align:right; color:#333; font-weight:500; }
  .payment-badge { display:inline-block; padding:2px 9px; border-radius:20px; font-size:11px; font-weight:600; }
  .badge-paid    { background:#e8f5e9; color:#2e7d32; }
  .badge-pending { background:#fff8e1; color:#f57f17; }
  .badge-cod     { background:#e8eaf6; color:#3949ab; }
  .badge-failed  { background:#ffebee; color:#c62828; }
  .status-badge  { display:inline-block; padding:2px 9px; border-radius:20px; font-size:11px; font-weight:600; background:#fff3e0; color:#e65100; }
  .cta-btn.outline { background:transparent; border:1px solid #ccc; color:#555 !important; }
</style>
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

    <div style="margin-top:10px;">
      <span style="display:inline-block;background:#d4af7a;color:#111;font-size:10px;font-weight:600;letter-spacing:0.1em;text-transform:uppercase;padding:4px 10px;border-radius:2px;">
        Admin Notification
      </span>
    </div>

  </div>

  {{-- ── Alert Banner ── --}}
  <div style="background:#1e3a2f;padding:36px 40px;text-align:center;">
    <div style="width:50px;height:50px;background:#2e7d32;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;margin-bottom:14px;">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
           stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
        <line x1="3" y1="6" x2="21" y2="6"></line>
        <path d="M16 10a4 4 0 0 1-8 0"></path>
      </svg>
    </div>
    <h1 style="font-family:'Playfair Display',Georgia,serif;font-size:22px;font-weight:600;color:#e8f5e9;margin-bottom:6px;">
      New order received
    </h1>
    <p style="font-size:13px;color:#81c784;">
      {{ $order->order_number }} &nbsp;·&nbsp; {{ $order->created_at->format('d M Y, h:i A') }}
    </p>
  </div>

  {{-- ── Meta Strip ── --}}
  <div class="meta-bar">
    <div class="meta-cell">
      <span class="meta-label">Order No.</span>
      <span class="meta-value">{{ $order->order_number }}</span>
    </div>
    <div class="meta-cell">
      <span class="meta-label">Customer</span>
      <span class="meta-value">{{ $order->customer_name }}</span>
    </div>
    <div class="meta-cell">
      <span class="meta-label">Items</span>
      <span class="meta-value">{{ $order->items->count() }}</span>
    </div>
    <div class="meta-cell">
      <span class="meta-label">Grand Total</span>
      <span class="meta-value">₹ {{ number_format($order->grand_total, 2) }}</span>
    </div>
    <div class="meta-cell">
      <span class="meta-label">Status</span>
      <span class="meta-value">
        <span class="status-badge">{{ ucfirst($order->status) }}</span>
      </span>
    </div>
  </div>

  {{-- ── Body ── --}}
  <div class="body">

    {{-- ── Order Items ── --}}
    <div class="section-title">Order Items</div>

    <table class="items-table">
      <thead>
        <tr>
          <th style="width:40px;"></th>
          <th style="width:38%">Product</th>
          <th>SKU</th>
          <th>Qty</th>
          <th>Unit Price</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
        @foreach($order->items as $item)
          @php
            $variantLabel = '';
            if ($item->variant) {
              $variantLabel = $item->variant->values
                ->map(fn($v) => $v->attributeValue->attribute->name . ': ' . $v->attributeValue->value)
                ->join(', ');
            }
          @endphp
          <tr>
            <td style="padding:10px 10px 10px 0;width:40px;vertical-align:top;">
              @if(isset($productImages[$item->id]))
                <img src="{{ $message->embed($productImages[$item->id]) }}"
                     alt="{{ $item->product_name }}"
                     style="width:40px;height:50px;object-fit:cover;border-radius:3px;display:block;">
              @else
                <span style="display:block;width:40px;height:50px;background:#f0ece5;border-radius:3px;"></span>
              @endif
            </td>
            <td>
              <div style="font-weight:500;color:#111;margin-bottom:2px;">{{ $item->product_name }}</div>
              @if($variantLabel)
                <div style="font-size:11px;color:#999;">{{ $variantLabel }}</div>
              @endif
            </td>
            <td style="font-size:11px;color:#999;">{{ $item->product?->sku ?? '—' }}</td>
            <td>{{ $item->quantity }}</td>
            <td>₹ {{ number_format($item->price, 2) }}</td>
            <td>₹ {{ number_format($item->total, 2) }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>

    {{-- ── Totals ── --}}
    <table class="totals-table">
      <tr>
        <td class="t-label">Subtotal</td>
        <td class="t-value">₹ {{ number_format($order->subtotal, 2) }}</td>
      </tr>

      @if($order->discount > 0)
        <tr class="discount">
          <td class="t-label">
            Discount
            @if($order->coupon_code)({{ $order->coupon_code }})@endif
          </td>
          <td class="t-value">− ₹ {{ number_format($order->discount, 2) }}</td>
        </tr>
      @endif

      @if($order->tax_amount > 0)
        <tr>
          <td colspan="2" class="t-label">
            <div class="gst-block">
              @if($order->gst_type === 'igst')
                <div class="gst-row">
                  <span>IGST ({{ $order->igst_rate }}%)</span>
                  <span>₹ {{ number_format($order->igst_amount, 2) }}</span>
                </div>
              @else
                @if($order->cgst_amount > 0)
                  <div class="gst-row">
                    <span>CGST ({{ $order->cgst_rate }}%)</span>
                    <span>₹ {{ number_format($order->cgst_amount, 2) }}</span>
                  </div>
                @endif
                @if($order->sgst_amount > 0)
                  <div class="gst-row">
                    <span>SGST ({{ $order->sgst_rate }}%)</span>
                    <span>₹ {{ number_format($order->sgst_amount, 2) }}</span>
                  </div>
                @endif
              @endif
              <div class="gst-row" style="border-top:1px solid #e8e8e8;margin-top:4px;padding-top:4px;">
                <span style="font-weight:600;color:#333;">Total Tax</span>
                <span style="font-weight:600;color:#333;">₹ {{ number_format($order->tax_amount, 2) }}</span>
              </div>
            </div>
          </td>
        </tr>
      @endif

      <tr class="grand-row">
        <td class="t-label">Grand Total</td>
        <td class="t-value">₹ {{ number_format($order->grand_total, 2) }}</td>
      </tr>
    </table>

    {{-- ── Customer + Payment ── --}}
    <div class="info-grid">
      <div class="info-col">
        <div class="section-title" style="margin-top:24px;">Customer Details</div>
        <div class="info-box">
          <strong>{{ $order->customer_name }}</strong>
          <p>
            📧 {{ $order->customer_email }}<br>
            📞 {{ $order->customer_phone }}
          </p>
        </div>
      </div>

      <div class="info-col">
        <div class="section-title" style="margin-top:24px;">Payment</div>
        <div class="info-box">
          <strong>{{ ucwords(str_replace('_', ' ', $order->payment_method)) }}</strong>
          <p>
            @php
              $badges = [
                'paid'    => ['label' => 'Paid',            'class' => 'badge-paid'],
                'pending' => ['label' => 'Pending',         'class' => 'badge-pending'],
                'cod'     => ['label' => 'Pay on Delivery', 'class' => 'badge-cod'],
                'failed'  => ['label' => 'Failed',          'class' => 'badge-failed'],
              ];
              $badge = $badges[$order->payment_status] ?? ['label' => ucfirst($order->payment_status), 'class' => 'badge-pending'];
            @endphp
            <span class="payment-badge {{ $badge['class'] }}">{{ $badge['label'] }}</span>
          </p>
          @if($order->transaction_id)
            <p style="margin-top:6px;font-size:11px;color:#aaa;">
              Txn: {{ $order->transaction_id }}
            </p>
          @endif
          @if($order->razorpay_payment_id)
            <p style="font-size:11px;color:#aaa;">
              Razorpay: {{ $order->razorpay_payment_id }}
            </p>
          @endif
        </div>
      </div>
    </div>

    {{-- ── Delivery Address ── --}}
    <div class="section-title" style="margin-top:24px;">Delivery Address</div>
    <div class="info-box">
      <strong>{{ $order->customer_name }}</strong>
      <p>
        {{ $order->address_line_1 }}
        @if($order->address_line_2), {{ $order->address_line_2 }}@endif<br>
        {{ $order->city?->name }}, {{ $order->state?->name }} – {{ $order->pincode }}
      </p>
    </div>

    {{-- ── CTA ── --}}
    <div class="cta-section">
      <a href="{{ url('/admin/orders/' . $order->id) }}" class="cta-btn">
        View Order in Admin
      </a>
      &nbsp;
      <a href="{{ url('/admin/orders/' . $order->id . '/invoice') }}" class="cta-btn outline">
        Download Invoice
      </a>
    </div>

  </div>

  {{-- ── Footer ── --}}
  <div class="email-footer">
    <span class="brand-footer">{{ $settings->site_name ?? config('app.name') }}</span>
    <p>This is an automated notification from the admin system. Do not reply directly.</p>
    <p style="margin-top:8px;">
      © {{ date('Y') }} {{ $settings->site_name ?? config('app.name') }}. All rights reserved.
    </p>
  </div>

</div>

</body>
</html>