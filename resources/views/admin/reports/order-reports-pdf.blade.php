<!DOCTYPE html>
<html>
    
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #202223; }
        h1 { font-size: 16px; margin-bottom: 2px; }
        .sub { font-size: 11px; color: #6d7175; margin-bottom: 16px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 18px; }
        th, td { padding: 6px 8px; border-bottom: 1px solid #e3e5e8; text-align: left; }
        th { background: #fafafa; font-size: 10px; text-transform: uppercase; color: #6d7175; }
        .kpi-strip { display: flex; gap: 10px; margin-bottom: 18px; }
        .kpi-box { border: 1px solid #e3e5e8; border-radius: 6px; padding: 8px 12px; flex: 1; }
        .kpi-label { font-size: 9px; text-transform: uppercase; color: #8c9196; }
        .kpi-value { font-size: 16px; font-weight: 700; margin-top: 3px; }
        .section-title { font-size: 12px; font-weight: 700; margin: 14px 0 6px; }
    </style>
</head>

<body>
    <h1>Order Report</h1>
    <div class="sub">{{ $from->format('d M Y') }} – {{ $to->format('d M Y') }}</div>

    <div class="kpi-strip">
        <div class="kpi-box"><div class="kpi-label">Total Orders</div><div class="kpi-value">{{ number_format($totalOrders) }}</div></div>
        <div class="kpi-box"><div class="kpi-label">Delivered</div><div class="kpi-value">{{ number_format($delivered) }} ({{ $deliveryRate }}%)</div></div>
        <div class="kpi-box"><div class="kpi-label">Cancelled</div><div class="kpi-value">{{ number_format($cancelled) }}</div></div>
        <div class="kpi-box"><div class="kpi-label">Avg. Fulfilment</div><div class="kpi-value">{{ $avgFulfilment }}d</div></div>
        <div class="kpi-box"><div class="kpi-label">Return Rate</div><div class="kpi-value">{{ $returnRate }}%</div></div>
    </div>

    <div class="section-title">Orders by Status</div>
    <table>
        <thead><tr><th>Status</th><th>Count</th><th>Share</th></tr></thead>
        <tbody>
        @foreach($statusBreakdown as $s)
            <tr><td>{{ $s['label'] }}</td><td>{{ $s['count'] }}</td><td>{{ $s['pct'] }}%</td></tr>
        @endforeach
        </tbody>
    </table>

    <div class="section-title">Order Details</div>
    <table>
        <thead>
            <tr>
                <th>Order #</th><th>Customer</th><th>Date</th><th>Items</th>
                <th>Amount</th><th>Payment</th><th>Status</th>
            </tr>
        </thead>
        <tbody>
        @foreach($orders as $o)
            <tr>
                <td>#{{ $o->order_number }}</td>
                <td>{{ $o->customer_name }}</td>
                <td>{{ $o->created_at->format('d M Y') }}</td>
                <td>{{ $o->items->count() }}</td>
                <td>₹{{ number_format($o->grand_total, 0) }}</td>
                <td>{{ strtoupper($o->payment_method) }}</td>
                <td>{{ ucfirst($o->status) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="section-title">Key Metrics</div>
    <table>
        <tbody>
            <tr><td>Total Orders</td><td>{{ number_format($totalOrders) }}</td></tr>
            <tr><td>Delivered</td><td>{{ $delivered }} ({{ $deliveryRate }}%)</td></tr>
            <tr><td>Processing / Shipped</td><td>{{ $processingShipped }}</td></tr>
            <tr><td>Pending</td><td>{{ $pending }}</td></tr>
            <tr><td>Cancelled</td><td>{{ $cancelled }}</td></tr>
            <tr><td>Returned</td><td>{{ $returnedCount }} ({{ $returnRate }}%)</td></tr>
            <tr><td>Avg. Fulfilment Time</td><td>{{ $avgFulfilment }} days</td></tr>
            <tr><td>Orders via COD</td><td>{{ $codCount }}</td></tr>
            <tr><td><strong>Avg. Order Value</strong></td><td><strong>₹{{ number_format($avgOrderValue) }}</strong></td></tr>
        </tbody>
    </table>
</body>
</html>