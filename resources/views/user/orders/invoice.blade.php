<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $invoice->invoice_number }}</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'DejaVu Sans', 'Helvetica Neue', Arial, sans-serif;
            font-size: 13px;
            color: #202223;
            background: #f1f2f4;
            padding: 32px 20px;
        }

        /* ── Wrapper ── */
        .invoice-wrap {
            max-width: 780px;
            margin: 0 auto;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(0, 0, 0, .10);
        }

        /* ── Header band ── */
        .inv-header {
            background: #303d89;
            color: #fff;
            padding: 32px 40px;
            display: flex;
            /* dompdf ignores flex but it's fine for browser */
        }

        .inv-header-left {
            flex: 1;
        }

        .inv-header-right {
            text-align: right;
        }

        .brand-name {
            font-size: 22px;
            font-weight: 700;
            letter-spacing: -.3px;
            color: #fff;
        }

        .brand-tagline {
            font-size: 12px;
            color: rgba(255, 255, 255, .65);
            margin-top: 3px;
        }

        .brand-address {
            font-size: 11.5px;
            color: rgba(255, 255, 255, .75);
            margin-top: 12px;
            line-height: 1.7;
        }

        .inv-label {
            font-size: 28px;
            font-weight: 700;
            color: rgba(255, 255, 255, .2);
            letter-spacing: 4px;
            text-transform: uppercase;
        }

        .inv-number {
            font-size: 16px;
            font-weight: 700;
            color: #fff;
            margin-top: 4px;
            font-family: 'Courier New', monospace;
        }

        .inv-date {
            font-size: 12px;
            color: rgba(255, 255, 255, .7);
            margin-top: 5px;
        }

        .inv-status-badge {
            display: inline-block;
            margin-top: 10px;
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .badge-paid {
            background: #e3f1ec;
            color: #007a5e;
        }

        .badge-pending {
            background: #fff5cc;
            color: #916a00;
        }

        .badge-failed {
            background: #fce8e8;
            color: #b22222;
        }

        .badge-refunded {
            background: #ede9fe;
            color: #6d28d9;
        }

        /* ── Body padding ── */
        .inv-body {
            padding: 32px 40px;
        }

        /* ── Bill To / Order Info row ── */
        .meta-row {
            display: table;
            width: 100%;
            margin-bottom: 28px;
        }

        .meta-col {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }

        .meta-col:last-child {
            text-align: right;
        }

        .meta-heading {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #8c9196;
            margin-bottom: 8px;
            padding-bottom: 6px;
            border-bottom: 1px solid #e3e5e8;
        }

        .meta-name {
            font-size: 14px;
            font-weight: 700;
            color: #202223;
            margin-bottom: 3px;
        }

        .meta-detail {
            font-size: 12px;
            color: #6d7175;
            line-height: 1.7;
        }

        .meta-info-row {
            display: table;
            width: 100%;
            margin-bottom: 4px;
        }

        .meta-info-label {
            display: table-cell;
            font-size: 11px;
            color: #8c9196;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .04em;
            width: 110px;
            padding-bottom: 4px;
        }

        .meta-info-value {
            display: table-cell;
            font-size: 12px;
            font-weight: 600;
            color: #202223;
        }

        /* ── Items table ── */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
            font-size: 13px;
        }

        .items-table thead tr {
            background: #f8f9fa;
        }

        .items-table thead th {
            font-size: 10.5px;
            font-weight: 700;
            letter-spacing: .07em;
            text-transform: uppercase;
            color: #8c9196;
            padding: 10px 14px;
            border-top: 1px solid #e3e5e8;
            border-bottom: 1px solid #e3e5e8;
            text-align: left;
        }

        .items-table thead th.right {
            text-align: right;
        }

        .items-table thead th.center {
            text-align: center;
        }

        .items-table tbody tr {
            border-bottom: 1px solid #f1f2f4;
        }

        .items-table tbody tr:last-child {
            border-bottom: 1px solid #e3e5e8;
        }

        .items-table tbody td {
            padding: 13px 14px;
            vertical-align: top;
        }

        .items-table tbody td.right {
            text-align: right;
        }

        .items-table tbody td.center {
            text-align: center;
        }

        .item-name {
            font-weight: 600;
            color: #202223;
            margin-bottom: 2px;
        }

        .item-variant {
            font-size: 11px;
            color: #8c9196;
            margin-top: 2px;
        }

        .item-sku {
            font-size: 10.5px;
            color: #adb5bd;
            font-family: 'Courier New', monospace;
            margin-top: 1px;
        }

        /* ── Totals block ── */
        .totals-wrap {
            display: table;
            width: 100%;
            margin-top: 0;
        }

        .totals-left {
            display: table-cell;
            width: 52%;
            vertical-align: bottom;
            padding-right: 20px;
        }

        .totals-right {
            display: table-cell;
            width: 48%;
            vertical-align: top;
        }

        .totals-table {
            width: 100%;
            border-collapse: collapse;
        }

        .totals-table td {
            padding: 7px 14px;
            font-size: 12.5px;
        }

        .totals-table .t-label {
            color: #6d7175;
        }

        .totals-table .t-value {
            text-align: right;
            font-weight: 600;
            color: #202223;
        }

        .totals-table .t-discount .t-value {
            color: #007a5e;
        }

        .totals-table .t-total td {
            border-top: 2px solid #303d89;
            padding-top: 10px;
            font-size: 15px;
            font-weight: 700;
            color: #202223;
        }

        .totals-table .t-total .t-value {
            color: #303d89;
            font-size: 17px;
        }

        /* ── Notes / Thank you ── */
        .inv-notes {
            margin-top: 28px;
            padding: 16px 20px;
            background: #f8f9fa;
            border-radius: 8px;
            border-left: 4px solid #303d89;
        }

        .inv-notes p {
            font-size: 12px;
            color: #6d7175;
            line-height: 1.6;
        }

        .inv-notes strong {
            color: #202223;
        }

        /* ── GST Summary ── */
        .gst-summary {
            margin-bottom: 4px;
        }

        .gst-pill {
            display: inline-block;
            background: #f0f1fc;
            color: #303d89;
            font-size: 10.5px;
            font-weight: 700;
            padding: 2px 9px;
            border-radius: 20px;
            margin-bottom: 4px;
            letter-spacing: .03em;
        }

        /* ── Footer band ── */
        .inv-footer {
            background: #f8f9fa;
            border-top: 1px solid #e3e5e8;
            padding: 16px 40px;
            text-align: center;
        }

        .inv-footer p {
            font-size: 11.5px;
            color: #8c9196;
            line-height: 1.6;
        }

        .inv-footer strong {
            color: #202223;
        }

        /* ── Print / Download bar (browser only) ── */
        .print-bar {
            max-width: 780px;
            margin: 0 auto 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #fff;
            color: #202223;
            border: 1px solid #e3e5e8;
            border-radius: 8px;
            padding: 8px 16px;
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .06);
        }

        .btn-pdf {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #303d89;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 8px 18px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            box-shadow: 0 2px 6px rgba(48, 61, 137, .3);
        }

        .btn-print {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #fff;
            color: #202223;
            border: 1px solid #e3e5e8;
            border-radius: 8px;
            padding: 8px 16px;
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .06);
        }

        @media print {
            body {
                background: #fff;
                padding: 0;
            }

            .print-bar {
                display: none;
            }

            .invoice-wrap {
                box-shadow: none;
                border-radius: 0;
            }
        }
    </style>
</head>

<body>

    {{-- ── Action bar (browser preview only, hidden in PDF) ── --}}
    @if(!isset($isPdf) || !$isPdf)
        <div class="print-bar">
            <a href="{{ route('admin.orders.show', $order) }}" class="btn-back">
                ← Back to Order
            </a>
            <div style="display:flex;gap:8px">
                <button onclick="window.print()" class="btn-print">
                    🖨 Print
                </button>
                <a href="{{ route('admin.orders.invoice.download', $order) }}" class="btn-pdf">
                    ⬇ Download PDF
                </a>
            </div>
        </div>
    @endif

    <div class="invoice-wrap">

        {{-- ── Header ── --}}
        <div class="inv-header">
            <div class="inv-header-left">
                @if($logo_64)
                    <div style="margin-bottom:12px;">
                        <img src="{{ $logo_64 }}" style="max-height:60px;">
                    </div>
                @endif
                <div class="brand-name">
                    {{ $setting->company_name ?? config('app.name') }}
                </div>
                <div class="brand-tagline">Tax Invoice</div>
                <div class="brand-address">

                    @if($setting?->company_address)
                        {{ $setting->company_address }}<br>
                    @endif

                    @if($setting?->city || $setting?->state || $setting?->company_pincode)

                        {{ optional($setting->city)->name ?? '' }}

                        @if($setting?->city && $setting?->state)
                            ,
                        @endif

                        {{ optional($setting->state)->name ?? '' }}

                        @if($setting?->company_pincode)
                            - {{ $setting->company_pincode }}
                        @endif

                        <br>

                    @endif

                    @if($setting?->company_gstin)
                        GSTIN: {{ $setting->company_gstin }}<br>
                    @endif

                    @if($setting?->company_pan)
                        PAN: {{ $setting->company_pan }}<br>
                    @endif

                    @if($setting?->company_phone)
                        Phone: {{ $setting->company_phone }}<br>
                    @endif

                    @if($setting?->company_email)
                        {{ $setting->company_email }}
                    @endif

                </div>
            </div>
            <div class="inv-header-right">
                <div class="inv-label">Invoice</div>
                <div class="inv-number">#{{ $invoice->invoice_number }}</div>
                <div class="inv-date">
                    Date: {{ optional($invoice->invoice_date)->format(
    $setting->invoice_date_format ?? 'd M Y'
) }}
                </div>
                @php
                    $badgeClass = match ($order->payment_status) {
                        'paid' => 'badge-paid',
                        'pending' => 'badge-pending',
                        'failed' => 'badge-failed',
                        'refunded' => 'badge-refunded',
                        default => 'badge-pending',
                    };
                @endphp
                <div>
                    <span class="inv-status-badge {{ $badgeClass }}">
                        {{ ucfirst($order->payment_status) }}
                    </span>
                </div>
            </div>
        </div>

        {{-- ── Body ── --}}
        <div class="inv-body">

            {{-- Bill To + Order Info --}}
            <div class="meta-row">
                <div class="meta-col">
                    <div class="meta-heading">Bill To</div>
                    <div class="meta-name">{{ $invoice->customer_name }}</div>
                    <div class="meta-detail">
                        {{ $invoice->billing_address }}<br>
                        {{ $invoice->customer_email }}<br>
                        @if($invoice->customer_phone) {{ $invoice->customer_phone }} @endif
                    </div>
                </div>
                <div class="meta-col">
                    <div class="meta-heading" style="text-align:right">Order Details</div>

                    <div class="meta-info-row">
                        <div class="meta-info-label" style="text-align:right;padding-right:10px">Order #</div>
                        <div class="meta-info-value"
                            style="text-align:right;font-family:'Courier New',monospace;color:#303d89">
                            {{ $order->order_number }}
                        </div>
                    </div>
                    <div class="meta-info-row">
                        <div class="meta-info-label" style="text-align:right;padding-right:10px">Order Date</div>
                        <div class="meta-info-value" style="text-align:right">
                            {{ $order->created_at->format('d M Y') }}
                        </div>
                    </div>
                    @if($order->payment_method)
                        <div class="meta-info-row">
                            <div class="meta-info-label" style="text-align:right;padding-right:10px">Payment</div>
                            <div class="meta-info-value" style="text-align:right">
                                {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}
                            </div>
                        </div>
                    @endif
                    @if($order->transaction_id)
                        <div class="meta-info-row">
                            <div class="meta-info-label" style="text-align:right;padding-right:10px">Txn ID</div>
                            <div class="meta-info-value"
                                style="text-align:right;font-family:'Courier New',monospace;font-size:11px">
                                {{ $order->transaction_id }}
                            </div>
                        </div>
                    @endif
                    @if($order->coupon_code)
                        <div class="meta-info-row">
                            <div class="meta-info-label" style="text-align:right;padding-right:10px">Coupon</div>
                            <div class="meta-info-value"
                                style="text-align:right;color:#007a5e;font-family:'Courier New',monospace">
                                {{ $order->coupon_code }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- GST type badge --}}
            @if($invoice->gst_type)
                <div class="gst-summary" style="margin-bottom:16px">
                    <span class="gst-pill">{{ strtoupper($invoice->gst_type) }} Applied</span>
                </div>
            @endif

            {{-- Items table --}}
            <table class="items-table">
                <thead>
                    <tr>
                        <th style="width:40px">#</th>
                        <th>Item Description</th>
                        <th class="center" style="width:70px">Qty</th>
                        <th class="right" style="width:110px">Unit Price</th>
                        <th class="right" style="width:110px">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $i => $item)
                        @php
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
                                    ->join(' · ');
                            }

                            $sku = optional($item->skuVariant)->sku ?? ($item->sku ?? optional($item->product)->sku);

                            $addonsTotal = $item->addons->sum('price');
                            $lineTotal = ($item->price * $item->quantity) + $addonsTotal;
                        @endphp
                        <tr>
                            <td style="color:#8c9196;font-size:12px">{{ $i + 1 }}</td>
                            <td>
                                <div class="item-name">
                                    {{ $item->product_name ?? ($item->product->name ?? 'Product') }}
                                </div>
                                @if($variantLabel)
                                    <div class="item-variant">{{ $variantLabel }}</div>
                                @endif
                                @if($sku)
                                    <div class="item-sku">SKU: {{ $sku }}</div>
                                @endif
                                @if($item->addons->isNotEmpty())
                                    <div class="item-variant" style="margin-top:3px">
                                        @foreach($item->addons as $addon)
                                            + {{ $addon->detail }} (&#8377;{{ number_format($addon->price, 2) }})<br>
                                        @endforeach
                                    </div>
                                @endif
                            </td>
                            <td class="center">{{ $item->quantity }}</td>
                            <td class="right">&#8377;{{ number_format($item->price, 2) }}</td>
                            <td class="right">&#8377;{{ number_format($lineTotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Totals --}}
            <div class="totals-wrap">
                <div class="totals-left">
                    {{-- Space for notes or bank details --}}
                    @if($order->coupon_code)
                        <div class="inv-notes" style="margin-top:20px">
                            <p>
                                <strong>Discount Applied:</strong> Coupon
                                <strong>{{ $order->coupon_code }}</strong>
                                saved you &#8377;{{ number_format($invoice->discount, 2) }} on this order.
                            </p>
                        </div>
                    @endif
                </div>

                <div class="totals-right">
                    <table class="totals-table" style="margin-top:16px">
                        <tr>
                            <td class="t-label">Subtotal</td>
                            <td class="t-value">&#8377;{{ number_format($invoice->subtotal, 2) }}</td>
                        </tr>

                        @if($invoice->discount > 0)
                            <tr class="t-discount">
                                <td class="t-label">Discount</td>
                                <td class="t-value">− &#8377;{{ number_format($invoice->discount, 2) }}</td>
                            </tr>
                        @endif

                        {{-- GST rows --}}
                        @if($setting?->show_gst_breakup)

                            @if($invoice->tax_amount > 0)

                                @if($invoice->gst_type === 'igst' && $invoice->igst_amount > 0)

                                    <tr>
                                        <td class="t-label">
                                            IGST ({{ $invoice->igst_rate }}%)
                                        </td>
                                        <td class="t-value">
                                            ₹{{ number_format($invoice->igst_amount, 2) }}
                                        </td>
                                    </tr>

                                @else

                                    @if($invoice->cgst_amount > 0)
                                        <tr>
                                            <td class="t-label">
                                                CGST ({{ $invoice->cgst_rate }}%)
                                            </td>
                                            <td class="t-value">
                                                ₹{{ number_format($invoice->cgst_amount, 2) }}
                                            </td>
                                        </tr>
                                    @endif

                                    @if($invoice->sgst_amount > 0)
                                        <tr>
                                            <td class="t-label">
                                                SGST ({{ $invoice->sgst_rate }}%)
                                            </td>
                                            <td class="t-value">
                                                ₹{{ number_format($invoice->sgst_amount, 2) }}
                                            </td>
                                        </tr>
                                    @endif

                                @endif

                            @endif

                        @else

                            @if($invoice->tax_amount > 0)

                                <tr>
                                    <td class="t-label">GST</td>
                                    <td class="t-value">
                                        ₹{{ number_format($invoice->tax_amount, 2) }}
                                    </td>
                                </tr>

                            @endif

                        @endif
                        <tr class="t-total">
                            <td class="t-label">Grand Total</td>
                            <td class="t-value">&#8377;{{ number_format($invoice->grand_total, 2) }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            {{-- Thank you note --}}
            @if($setting?->terms_conditions)

                <div class="inv-notes" style="margin-top:28px">

                    <p>
                        <strong>Terms & Conditions</strong>
                    </p>

                    <div style="margin-top:10px;">
                        {!! nl2br(e($setting->terms_conditions)) !!}
                    </div>

                </div>

            @endif

        </div>{{-- /inv-body --}}

        {{-- ── Footer ── --}}
        <div class="inv-footer">
            <p>

                <strong>
                    {{ $setting->company_name ?? config('app.name') }}
                </strong>

                @if($setting?->company_gstin)
                    &nbsp;·&nbsp;
                    GSTIN: {{ $setting->company_gstin }}
                @endif

                @if($setting?->company_email)
                    &nbsp;·&nbsp;
                    {{ $setting->company_email }}
                @endif

                @if($setting?->company_phone)
                    &nbsp;·&nbsp;
                    {{ $setting->company_phone }}
                @endif

                &nbsp;·&nbsp;

                Invoice #{{ $invoice->invoice_number }}

            </p>
            <p style="margin-top:4px;font-size:11px">
                This invoice was generated on {{ now()->format('d M Y, h:i A') }}
            </p>
        </div>

    </div>{{-- /invoice-wrap --}}

</body>

</html>