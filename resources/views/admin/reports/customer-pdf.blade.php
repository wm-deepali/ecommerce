<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Customer Report</title>
<style>
    @page { margin: 28px 32px; }
    body { font-family: 'DejaVu Sans', sans-serif; color: #202223; font-size: 11px; }
    h1 { font-size: 18px; margin: 0 0 2px; }
    .crumb { font-size: 10px; color: #8c9196; margin-bottom: 14px; }

    .section-title { font-size: 12px; font-weight: bold; margin: 18px 0 8px; padding-bottom: 4px; border-bottom: 1px solid #e3e5e8; }

    table.kpi-table { width: 100%; border-collapse: collapse; margin-bottom: 4px; }
    table.kpi-table td { width: 20%; border: 1px solid #e3e5e8; padding: 8px 10px; vertical-align: top; }
    .kpi-label { font-size: 8.5px; text-transform: uppercase; color: #8c9196; font-weight: bold; }
    .kpi-value { font-size: 15px; font-weight: bold; margin-top: 3px; }

    table.data-table { width: 100%; border-collapse: collapse; }
    table.data-table th { background: #fafafa; border: 1px solid #e3e5e8; padding: 6px 8px; text-align: left; font-size: 9.5px; text-transform: uppercase; color: #6d7175; }
    table.data-table td { border: 1px solid #e3e5e8; padding: 6px 8px; font-size: 10.5px; }
    table.data-table tfoot td { font-weight: bold; background: #fafafa; }

    .bar-track { background: #f1f2f4; height: 10px; border-radius: 2px; }
    .bar-fill { height: 10px; border-radius: 2px; }

    .two-col { width: 100%; }
    .two-col td { vertical-align: top; width: 50%; padding-right: 10px; }

    .seg-vip      { color: #b8860b; font-weight: bold; }
    .seg-loyal    { color: #007a5e; font-weight: bold; }
    .seg-new      { color: #0069d9; font-weight: bold; }
    .seg-at-risk  { color: #b22222; font-weight: bold; }
    .seg-dormant  { color: #8c9196; font-weight: bold; }
    .seg-promising{ color: #6d28d9; font-weight: bold; }

    .text-muted { color: #8c9196; }
    .text-right { text-align: right; }
</style>
</head>
<body>

    <h1>Customer Report</h1>
    <div class="crumb">{{ $start->format('d M Y') }} &ndash; {{ $end->format('d M Y') }} &middot; Generated {{ now()->format('d M Y, H:i') }}</div>

    <!-- KPIs -->
    <table class="kpi-table">
        <tr>
            <td>
                <div class="kpi-label">Total Customers</div>
                <div class="kpi-value">{{ number_format($totalCustomers) }}</div>
            </td>
            <td>
                <div class="kpi-label">New Customers</div>
                <div class="kpi-value">{{ number_format($newThis) }}</div>
            </td>
            <td>
                <div class="kpi-label">Returning Rate</div>
                <div class="kpi-value">{{ $returningRate }}%</div>
            </td>
            <td>
                <div class="kpi-label">Avg. LTV</div>
                <div class="kpi-value">Rs. {{ number_format($avgLtv) }}</div>
            </td>
            <td>
                <div class="kpi-label">Churn Rate</div>
                <div class="kpi-value">{{ $churnRate }}%</div>
            </td>
        </tr>
    </table>

    <!-- Segments + Funnel -->
    <div class="section-title">Customer Segments &amp; Acquisition Funnel</div>
    <table class="two-col">
        <tr>
            <td>
                <table class="data-table">
                    <thead><tr><th>Segment</th><th class="text-right">Customers</th><th class="text-right">%</th></tr></thead>
                    <tbody>
                        <tr><td class="seg-vip">VIP</td><td class="text-right">{{ number_format($segments['vip']) }}</td><td class="text-right">{{ $segmentPcts['vip'] }}%</td></tr>
                        <tr><td class="seg-loyal">Loyal</td><td class="text-right">{{ number_format($segments['loyal']) }}</td><td class="text-right">{{ $segmentPcts['loyal'] }}%</td></tr>
                        <tr><td class="seg-new">New</td><td class="text-right">{{ number_format($segments['new']) }}</td><td class="text-right">{{ $segmentPcts['new'] }}%</td></tr>
                        <tr><td class="seg-promising">Promising</td><td class="text-right">{{ number_format($segments['promising']) }}</td><td class="text-right">{{ $segmentPcts['promising'] }}%</td></tr>
                        <tr><td class="seg-at-risk">At Risk</td><td class="text-right">{{ number_format($segments['at_risk']) }}</td><td class="text-right">{{ $segmentPcts['at_risk'] }}%</td></tr>
                        <tr><td class="seg-dormant">Dormant</td><td class="text-right">{{ number_format($segments['dormant']) }}</td><td class="text-right">{{ $segmentPcts['dormant'] }}%</td></tr>
                    </tbody>
                </table>
            </td>
            <td>
                <table class="data-table">
                    <thead><tr><th>Step</th><th class="text-right">Count</th><th class="text-right">%</th></tr></thead>
                    <tbody>
                        @foreach($funnel as $step)
                            <tr>
                                <td>{{ $step['label'] }}</td>
                                <td class="text-right">{{ number_format($step['count']) }}</td>
                                <td class="text-right">{{ $step['pct'] }}%</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </td>
        </tr>
    </table>

    <!-- Retention Cohort -->
    <div class="section-title">Retention Cohort Analysis (% returning after first purchase)</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Cohort</th>
                @for($m = 0; $m <= 5; $m++)<th class="text-right">M+{{ $m }}</th>@endfor
            </tr>
        </thead>
        <tbody>
            @foreach($cohorts as $row)
                <tr>
                    <td>{{ $row['label'] }}</td>
                    @foreach($row['cells'] as $val)
                        <td class="text-right">{{ $val === null ? '&mdash;' : $val . '%' }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Top Customers -->
    <div class="section-title">Customers by Lifetime Value</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>#</th><th>Name</th><th>Email</th><th>Segment</th>
                <th class="text-right">Orders</th><th class="text-right">Total Spent</th>
                <th class="text-right">Avg Order</th><th>Last Order</th>
            </tr>
        </thead>
        <tbody>
            @forelse($allCustomersTable as $c)
                <tr>
                    <td>{{ $c['rank'] }}</td>
                    <td>{{ $c['name'] }}</td>
                    <td>{{ $c['email'] }}</td>
                    <td class="{{ $c['segment']['class'] }}">{{ $c['segment']['label'] }}</td>
                    <td class="text-right">{{ $c['orders'] }}</td>
                    <td class="text-right">Rs. {{ number_format($c['total_spent']) }}</td>
                    <td class="text-right">Rs. {{ number_format($c['avg_order']) }}</td>
                    <td>{{ $c['last_order'] }}</td>
                </tr>
            @empty
                <tr><td colspan="8" class="text-muted">No customer order data yet.</td></tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4">Total ({{ $allCustomersTable->count() }} customers)</td>
                <td class="text-right">{{ number_format($allCustomersTable->sum('orders')) }} orders</td>
                <td class="text-right">Rs. {{ number_format($allCustomersTable->sum('total_spent')) }}</td>
                <td colspan="2"></td>
            </tr>
        </tfoot>
    </table>

    <!-- Locations -->
    <div class="section-title">Customers by Location</div>
    <table class="data-table">
        <thead><tr><th>City</th><th class="text-right">Customers</th><th class="text-right">%</th></tr></thead>
        <tbody>
            @forelse($topLocations as $loc)
                <tr>
                    <td>{{ $loc->city_name }}</td>
                    <td class="text-right">{{ number_format($loc->cnt) }}</td>
                    <td class="text-right">{{ round(($loc->cnt / $locationTotal) * 100, 1) }}%</td>
                </tr>
            @empty
                <tr><td colspan="3" class="text-muted">No address data yet.</td></tr>
            @endforelse
            @if($othersLocationCount > 0)
                <tr>
                    <td>Others</td>
                    <td class="text-right">{{ number_format($othersLocationCount) }}</td>
                    <td class="text-right">{{ round(($othersLocationCount / $locationTotal) * 100, 1) }}%</td>
                </tr>
            @endif
        </tbody>
    </table>

    <!-- Health metrics -->
    <div class="section-title">Customer Health Metrics</div>
    <table class="two-col">
        <tr>
            <td>
                <table class="data-table">
                    <tbody>
                        <tr><td>Total Registered</td><td class="text-right">{{ number_format($totalCustomers) }}</td></tr>
                        <tr><td>Active This Month</td><td class="text-right">{{ number_format($activeThisMonth) }} ({{ $activePct }}%)</td></tr>
                        <tr><td>New This Month</td><td class="text-right">+{{ number_format($newThis) }}</td></tr>
                        <tr><td>Churn Rate</td><td class="text-right">{{ $churnRate }}%</td></tr>
                    </tbody>
                </table>
            </td>
            <td>
                <table class="data-table">
                    <tbody>
                        <tr><td>Avg. Orders / Customer</td><td class="text-right">{{ $avgOrdersPerCustomer }}</td></tr>
                        <tr><td>Avg. Lifetime Value</td><td class="text-right">Rs. {{ number_format($avgLtv) }}</td></tr>
                        <tr><td>Avg. Days Between Orders</td><td class="text-right">{{ $avgDaysBetweenOrders }} days</td></tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </table>

</body>
</html>