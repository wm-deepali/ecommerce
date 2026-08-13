<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: sans-serif; font-size: 11px; color: #202223; background: #fff; padding: 24px; }

    .header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 20px; border-bottom: 2px solid #303d89; padding-bottom: 12px; }
    .header h1 { font-size: 18px; font-weight: 700; color: #303d89; }
    .header .period { font-size: 11px; color: #6d7175; margin-top: 3px; }
    .header .generated { font-size: 10px; color: #8c9196; text-align: right; }

    h2 { font-size: 12px; font-weight: 700; color: #303d89; margin: 18px 0 8px; border-left: 3px solid #303d89; padding-left: 8px; }

    /* KPI grid */
    .kpi-grid { display: table; width: 100%; border-collapse: collapse; margin-bottom: 4px; }
    .kpi-cell { display: table-cell; width: 20%; border: 1px solid #e3e5e8; padding: 10px 12px; vertical-align: top; }
    .kpi-label { font-size: 9px; text-transform: uppercase; letter-spacing: .05em; color: #8c9196; font-weight: 600; }
    .kpi-value { font-size: 15px; font-weight: 700; color: #202223; margin-top: 4px; }
    .kpi-badge { font-size: 9px; font-weight: 600; margin-top: 4px; }
    .kpi-badge.up   { color: #007a5e; }
    .kpi-badge.down { color: #b22222; }

    /* Tables */
    table { width: 100%; border-collapse: collapse; margin-bottom: 16px; font-size: 10.5px; }
    thead th { background: #303d89; color: #fff; padding: 7px 10px; text-align: left; font-size: 9.5px; font-weight: 600; letter-spacing: .04em; white-space: nowrap; }
    tbody tr:nth-child(even) { background: #f8f9fa; }
    tbody td { padding: 7px 10px; border-bottom: 1px solid #e3e5e8; color: #202223; }
    tfoot td { padding: 7px 10px; border-top: 2px solid #303d89; font-weight: 700; background: #f0f1fc; color: #303d89; }

    .two-col { display: table; width: 100%; border-collapse: collapse; }
    .col-half { display: table-cell; width: 50%; vertical-align: top; padding-right: 10px; }
    .col-half:last-child { padding-right: 0; padding-left: 10px; }

    .metric-row { display: flex; justify-content: space-between; padding: 5px 0; border-bottom: 1px solid #f1f2f4; }
    .metric-label { color: #6d7175; font-size: 10px; }
    .metric-value { font-weight: 600; color: #202223; }

    .footer { margin-top: 24px; border-top: 1px solid #e3e5e8; padding-top: 8px; font-size: 9px; color: #8c9196; text-align: center; }
</style>
</head>
<body>

{{-- ── Header ── --}}
<div class="header">
    <div>
        <h1>Sales Report</h1>
        <div class="period">{{ $start->format('d M Y') }} – {{ $end->format('d M Y') }}</div>
    </div>
    <div class="generated">
        Generated: {{ now()->format('d M Y, g:i A') }}<br>
        Period: {{ $start->diffInDays($end) + 1 }} days
    </div>
</div>

{{-- ── KPI Strip ── --}}
<h2>Key Performance Indicators</h2>
<div class="kpi-grid">
    <div class="kpi-cell">
        <div class="kpi-label">Total Revenue</div>
        <div class="kpi-value">₹{{ number_format($revenueThis) }}</div>
        @if($revenueGrowth > 0)
            <div class="kpi-badge up">▲ {{ $revenueGrowth }}% vs prev</div>
        @elseif($revenueGrowth < 0)
            <div class="kpi-badge down">▼ {{ abs($revenueGrowth) }}% vs prev</div>
        @endif
    </div>
    <div class="kpi-cell">
        <div class="kpi-label">Total Orders</div>
        <div class="kpi-value">{{ number_format($ordersThis) }}</div>
        @if($orderGrowth > 0)
            <div class="kpi-badge up">▲ {{ $orderGrowth }}% vs prev</div>
        @elseif($orderGrowth < 0)
            <div class="kpi-badge down">▼ {{ abs($orderGrowth) }}% vs prev</div>
        @endif
    </div>
    <div class="kpi-cell">
        <div class="kpi-label">Avg. Order Value</div>
        <div class="kpi-value">₹{{ number_format($aovThis) }}</div>
        @if($aovGrowth > 0)
            <div class="kpi-badge up">▲ {{ $aovGrowth }}% vs prev</div>
        @elseif($aovGrowth < 0)
            <div class="kpi-badge down">▼ {{ abs($aovGrowth) }}% vs prev</div>
        @endif
    </div>
    <div class="kpi-cell">
        <div class="kpi-label">Units Sold</div>
        <div class="kpi-value">{{ number_format($unitsThis) }}</div>
        @if($unitsGrowth > 0)
            <div class="kpi-badge up">▲ {{ $unitsGrowth }}% vs prev</div>
        @elseif($unitsGrowth < 0)
            <div class="kpi-badge down">▼ {{ abs($unitsGrowth) }}% vs prev</div>
        @endif
    </div>
    <div class="kpi-cell">
        <div class="kpi-label">Return Rate</div>
        <div class="kpi-value">{{ $returnRateThis }}%</div>
        @if($returnRateDelta < -0.05)
            <div class="kpi-badge up">▼ {{ abs($returnRateDelta) }}pp improved</div>
        @elseif($returnRateDelta > 0.05)
            <div class="kpi-badge down">▲ {{ $returnRateDelta }}pp higher</div>
        @endif
    </div>
</div>

{{-- ── Top Products ── --}}
<h2>Top Selling Products</h2>
<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Product</th>
            <th>SKU</th>
            <th>Category</th>
            <th>Units</th>
            <th>Revenue (₹)</th>
            <th>Avg. Price (₹)</th>
            <th>Share</th>
        </tr>
    </thead>
    <tbody>
        @forelse($topProducts as $i => $p)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $p['name'] }}</td>
                <td>{{ $p['sku'] }}</td>
                <td>{{ $p['category'] }}</td>
                <td>{{ number_format($p['units']) }}</td>
                <td>₹{{ number_format($p['revenue']) }}</td>
                <td>₹{{ number_format($p['avg_price']) }}</td>
                <td>{{ $p['share'] ?? 0 }}%</td>
            </tr>
        @empty
            <tr><td colspan="8" style="text-align:center;color:#8c9196">No data for this period.</td></tr>
        @endforelse
    </tbody>
</table>

{{-- ── Payment Methods + Key Metrics (two-col) ── --}}
<div class="two-col">
    <div class="col-half">
        <h2>Payment Methods</h2>
        <table>
            <thead>
                <tr>
                    <th>Method</th>
                    <th>Txns</th>
                    <th>Revenue (₹)</th>
                    <th>Share</th>
                </tr>
            </thead>
            <tbody>
                @forelse($paymentMethods as $pm)
                    <tr>
                        <td>{{ $pm['label'] }}</td>
                        <td>{{ number_format($pm['txns']) }}</td>
                        <td>₹{{ number_format($pm['revenue']) }}</td>
                        <td>{{ $pm['share'] }}%</td>
                    </tr>
                @empty
                    <tr><td colspan="4" style="text-align:center;color:#8c9196">No data.</td></tr>
                @endforelse
            </tbody>
            @if(count($paymentMethods))
                <tfoot>
                    <tr>
                        <td>Total</td>
                        <td>{{ number_format(collect($paymentMethods)->sum('txns')) }}</td>
                        <td>₹{{ number_format($revenueThis) }}</td>
                        <td>100%</td>
                    </tr>
                </tfoot>
            @endif
        </table>
    </div>

    <div class="col-half">
        <h2>Revenue Summary</h2>
        <div class="metric-row">
            <span class="metric-label">Gross Revenue</span>
            <span class="metric-value">₹{{ number_format($grossRevenue) }}</span>
        </div>
        <div class="metric-row">
            <span class="metric-label">Discounts Given</span>
            <span class="metric-value" style="color:#b22222">− ₹{{ number_format($discountsGiven) }}</span>
        </div>
        <div class="metric-row">
            <span class="metric-label">Returns / Refunds</span>
            <span class="metric-value" style="color:#b22222">− ₹{{ number_format($refundsTotal) }}</span>
        </div>
        <div class="metric-row">
            <span class="metric-label">Tax Collected (GST)</span>
            <span class="metric-value">₹{{ number_format($taxCollected) }}</span>
        </div>
        <div class="metric-row" style="border-top:2px solid #303d89;margin-top:6px;padding-top:8px">
            <span style="font-weight:700;font-size:11px;color:#303d89">Net Revenue</span>
            <span style="font-weight:700;font-size:13px;color:#303d89">₹{{ number_format($revenueThis) }}</span>
        </div>
    </div>
</div>

<div class="footer">
    This report was automatically generated by the Admin Sales Report system.
    Data reflects orders between {{ $start->format('d M Y') }} and {{ $end->format('d M Y') }}.
</div>

</body>
</html>