@include('admin.top-header')

<div class="main-section">

    @include('admin.header')

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --bg: #f1f2f4;
            --surface: #ffffff;
            --border: #e3e5e8;
            --text-primary: #202223;
            --text-secondary: #6d7175;
            --text-hint: #8c9196;
            --accent: #303d89;
            --accent-light: #f0f1fc;
            --green: #007a5e;
            --green-bg: #e3f1ec;
            --red: #b22222;
            --red-bg: #fce8e8;
            --amber: #916a00;
            --amber-bg: #fff5cc;
            --blue: #0069d9;
            --blue-bg: #e8f2ff;
            --purple: #6d28d9;
            --purple-bg: #ede9fe;
            --radius-sm: 8px;
            --radius-md: 12px;
            --shadow-card: 0 1px 3px rgba(0, 0, 0, .08), 0 0 0 1px var(--border);
            --font: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        .report-page {
            background: var(--bg);
            padding: 24px 28px;
            min-height: 100vh;
            font-family: var(--font);
            color: var(--text-primary);
        }

        .report-page * {
            box-sizing: border-box;
        }

        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 20px;
        }

        .page-header h1 {
            font-size: 20px;
            font-weight: 650;
            margin: 0;
        }

        .crumb {
            font-size: 12.5px;
            color: var(--text-hint);
            margin-top: 3px;
        }

        .crumb a {
            color: var(--accent);
            text-decoration: none;
        }

        .crumb a:hover {
            text-decoration: underline;
        }

        .crumb span {
            margin: 0 5px;
        }

        .btn-primary-dash {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--accent);
            color: #fff;
            border: none;
            border-radius: var(--radius-sm);
            padding: 8px 16px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            font-family: var(--font);
            transition: background .15s;
            box-shadow: 0 1px 3px rgba(48, 61, 137, .25);
        }

        .btn-primary-dash:hover {
            background: #252f70;
            color: #fff;
        }

        .btn-secondary-dash {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--surface);
            color: var(--text-primary);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 8px 16px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            font-family: var(--font);
            transition: background .15s;
        }

        .btn-secondary-dash:hover {
            background: var(--bg);
            color: var(--text-primary);
        }

        /* date bar */
        .date-bar {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            padding: 14px 20px;
            margin-bottom: 20px;
            box-shadow: var(--shadow-card);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }

        .date-bar-left {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .date-preset {
            display: inline-flex;
            align-items: center;
            padding: 6px 14px;
            border: 1px solid var(--border);
            border-radius: 20px;
            font-size: 12.5px;
            font-weight: 500;
            color: var(--text-secondary);
            cursor: pointer;
            transition: all .15s;
            background: var(--surface);
            text-decoration: none;
            user-select: none;
        }

        .date-preset:hover {
            border-color: var(--accent);
            color: var(--accent);
            background: var(--accent-light);
        }

        .date-preset.active {
            border-color: var(--accent);
            color: var(--accent);
            background: var(--accent-light);
            font-weight: 600;
        }

        .date-input {
            height: 34px;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 0 10px;
            font-size: 13px;
            color: var(--text-primary);
            background: var(--surface);
            outline: none;
            font-family: var(--font);
        }

        .date-input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(48, 61, 137, .12);
        }

        .btn-apply {
            height: 34px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: var(--accent);
            color: #fff;
            border: none;
            border-radius: var(--radius-sm);
            padding: 0 14px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-apply:hover {
            background: #252f70;
        }

        /* kpi */
        .kpi-strip {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 14px;
            margin-bottom: 20px;
        }

        @media(max-width:1100px) {
            .kpi-strip {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media(max-width:700px) {
            .kpi-strip {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .kpi-tile {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            padding: 18px 18px 14px;
            box-shadow: var(--shadow-card);
        }

        .kpi-tile-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .kpi-tile-label {
            font-size: 11.5px;
            font-weight: 600;
            color: var(--text-hint);
            text-transform: uppercase;
            letter-spacing: .04em;
        }

        .kpi-tile-icon {
            width: 34px;
            height: 34px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            flex-shrink: 0;
        }

        .kpi-tile-icon.green {
            background: var(--green-bg);
            color: var(--green);
        }

        .kpi-tile-icon.blue {
            background: var(--blue-bg);
            color: var(--blue);
        }

        .kpi-tile-icon.amber {
            background: var(--amber-bg);
            color: var(--amber);
        }

        .kpi-tile-icon.purple {
            background: var(--purple-bg);
            color: var(--purple);
        }

        .kpi-tile-icon.red {
            background: var(--red-bg);
            color: var(--red);
        }

        .kpi-value {
            font-size: 22px;
            font-weight: 750;
            color: var(--text-primary);
            line-height: 1;
        }

        .kpi-badge {
            display: inline-flex;
            align-items: center;
            gap: 3px;
            font-size: 11px;
            font-weight: 600;
            padding: 2px 7px;
            border-radius: 20px;
            margin-top: 7px;
        }

        .kpi-badge.up {
            background: var(--green-bg);
            color: var(--green);
        }

        .kpi-badge.down {
            background: var(--red-bg);
            color: var(--red);
        }

        .kpi-badge.neutral {
            background: var(--bg);
            color: var(--text-hint);
        }

        /* layout */
        .charts-2col {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 16px;
            margin-bottom: 20px;
        }

        .charts-equal {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 20px;
        }

        @media(max-width:900px) {

            .charts-2col,
            .charts-equal {
                grid-template-columns: 1fr;
            }
        }

        /* section card */
        .sc {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-card);
            overflow: hidden;
        }

        .sc-head {
            padding: 14px 20px;
            border-bottom: 1px solid var(--border);
            background: #fafafa;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .sc-head h5 {
            font-size: 13px;
            font-weight: 650;
            color: var(--text-primary);
            margin: 0;
        }

        .sc-body {
            padding: 20px;
        }

        .sc-head-sub {
            font-size: 12px;
            color: var(--text-hint);
        }

        .chart-wrap-lg {
            position: relative;
            height: 260px;
        }

        .chart-wrap-md {
            position: relative;
            height: 220px;
        }

        .chart-wrap-sm {
            position: relative;
            height: 180px;
        }

        /* tables */
        .sum-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        .sum-table thead th {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: var(--text-hint);
            padding: 9px 14px;
            border-bottom: 1px solid var(--border);
            background: #fafafa;
            text-align: left;
            white-space: nowrap;
        }

        .sum-table tbody tr {
            border-bottom: 1px solid var(--border);
            transition: background .1s;
        }

        .sum-table tbody tr:last-child {
            border-bottom: none;
        }

        .sum-table tbody tr:hover {
            background: #fafbfc;
        }

        .sum-table tbody td {
            padding: 12px 14px;
            vertical-align: middle;
        }

        .sum-table tfoot td {
            padding: 12px 14px;
            border-top: 2px solid var(--border);
            font-weight: 700;
            font-size: 13px;
            background: #fafafa;
        }

        .rev-cell {
            font-size: 13.5px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .units-cell {
            font-size: 13px;
            color: var(--text-secondary);
            font-weight: 600;
        }

        /* pills & badges */
        .growth {
            display: inline-flex;
            align-items: center;
            gap: 3px;
            font-size: 11.5px;
            font-weight: 600;
            padding: 2px 7px;
            border-radius: 20px;
        }

        .growth.up {
            background: var(--green-bg);
            color: var(--green);
        }

        .growth.down {
            background: var(--red-bg);
            color: var(--red);
        }

        .growth.neutral {
            background: var(--bg);
            color: var(--text-hint);
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11.5px;
            font-weight: 600;
            padding: 3px 9px;
            border-radius: 20px;
            white-space: nowrap;
        }

        .status-pill::before {
            content: '';
            width: 5px;
            height: 5px;
            border-radius: 50%;
            display: inline-block;
            flex-shrink: 0;
        }

        .sp-delivered {
            background: var(--green-bg);
            color: var(--green);
        }

        .sp-delivered::before {
            background: var(--green);
        }

        .sp-processing {
            background: var(--blue-bg);
            color: var(--blue);
        }

        .sp-processing::before {
            background: var(--blue);
        }

        .sp-pending {
            background: var(--amber-bg);
            color: var(--amber);
        }

        .sp-pending::before {
            background: var(--amber);
        }

        .sp-cancelled {
            background: var(--red-bg);
            color: var(--red);
        }

        .sp-cancelled::before {
            background: var(--red);
        }

        .sp-shipped {
            background: var(--purple-bg);
            color: var(--purple);
        }

        .sp-shipped::before {
            background: var(--purple);
        }

        .sp-returned {
            background: var(--purple-bg);
            color: var(--purple);
        }

        .sp-returned::before {
            background: var(--purple);
        }

        /* misc */
        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 9px 0;
            border-bottom: 1px solid var(--bg);
            font-size: 13px;
        }

        .info-row:first-child {
            padding-top: 0;
        }

        .info-row:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .info-label {
            color: var(--text-hint);
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .03em;
        }

        .info-value {
            font-weight: 600;
            color: var(--text-primary);
        }

        .compare-strip {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1px;
            background: var(--border);
            border-radius: var(--radius-sm);
            overflow: hidden;
            margin-bottom: 14px;
        }

        .compare-cell {
            background: var(--surface);
            padding: 12px 16px;
        }

        .compare-cell-label {
            font-size: 11px;
            font-weight: 600;
            color: var(--text-hint);
            text-transform: uppercase;
            letter-spacing: .04em;
        }

        .compare-cell-value {
            font-size: 20px;
            font-weight: 750;
            color: var(--text-primary);
            margin-top: 3px;
        }

        .compare-cell-sub {
            font-size: 11.5px;
            color: var(--text-hint);
            margin-top: 2px;
        }

        .cat-row {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 0;
            border-bottom: 1px solid var(--bg);
        }

        .cat-row:first-child {
            padding-top: 0;
        }

        .cat-row:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .cat-color-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .cat-row-name {
            flex: 1;
            font-size: 13px;
            font-weight: 500;
        }

        .cat-row-count {
            font-size: 13px;
            font-weight: 700;
        }

        .cat-row-pct {
            font-size: 11.5px;
            color: var(--text-hint);
        }

        .prog-bar {
            height: 5px;
            border-radius: 10px;
            background: var(--bg);
            overflow: hidden;
            width: 100px;
        }

        .prog-fill {
            height: 100%;
            border-radius: 10px;
        }

        @media(max-width:768px) {
            .report-page {
                padding: 16px;
            }
        }
    </style>

    <div class="app-content content container-fluid">
        <div class="report-page">

            <!-- Page header -->
            <div class="page-header">
                <div>
                    <h1>Order Report</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        Order Report
                    </div>
                </div>
                <div style="display:flex;gap:8px;flex-wrap:wrap">
                    <button class="btn-secondary-dash" onclick="window.print()"><i class="fa fa-print"></i>
                        Print</button>
                    <a href="{{ route('admin.reports.order-reports.export-excel', request()->query()) }}"
                        class="btn-secondary-dash"><i class="fa fa-file-excel-o"></i> Export Excel</a>
                    <a href="{{ route('admin.reports.order-reports.export-pdf', request()->query()) }}"
                        class="btn-primary-dash"><i class="fa fa-download"></i> Export PDF</a>
                </div>
            </div>

            <!-- Date range bar -->
            <div class="date-bar">
                <div class="date-bar-left">
                    <span
                        style="font-size:12.5px;font-weight:600;color:var(--text-secondary);margin-right:4px">Period:</span>
                    <a href="{{ route('admin.reports.order-reports', ['preset' => 'today']) }}"
                        class="date-preset {{ $preset === 'today' ? 'active' : '' }}">Today</a>
                    <a href="{{ route('admin.reports.order-reports', ['preset' => 'yesterday']) }}"
                        class="date-preset {{ $preset === 'yesterday' ? 'active' : '' }}">Yesterday</a>
                    <a href="{{ route('admin.reports.order-reports', ['preset' => 'this_month']) }}"
                        class="date-preset {{ $preset === 'this_month' ? 'active' : '' }}">This Month</a>
                    <a href="{{ route('admin.reports.order-reports', ['preset' => 'last_month']) }}"
                        class="date-preset {{ $preset === 'last_month' ? 'active' : '' }}">Last Month</a>
                    <a href="{{ route('admin.reports.order-reports', ['preset' => 'this_year']) }}"
                        class="date-preset {{ $preset === 'this_year' ? 'active' : '' }}">This Year</a>
                    <span class="date-preset {{ $preset === 'custom' ? 'active' : '' }}" id="customToggle"
                        onclick="toggleCustom()">Custom</span>
                </div>
                <form method="GET" action="{{ route('admin.reports.order-reports') }}"
                    style="display:flex;align-items:center;gap:8px;flex-wrap:wrap" id="customInputs">
                    <input type="hidden" name="preset" value="custom">
                    <input type="date" class="date-input" name="start_date" value="{{ $from->format('Y-m-d') }}"
                        id="startDate">
                    <span style="color:var(--text-hint);font-size:13px">→</span>
                    <input type="date" class="date-input" name="end_date" value="{{ $to->format('Y-m-d') }}"
                        id="endDate">
                    <button type="submit" class="btn-apply"><i class="fa fa-check"></i> Apply</button>
                </form>
            </div>

            <!-- KPI Strip -->
            <div class="kpi-strip">
                <div class="kpi-tile">
                    <div class="kpi-tile-top">
                        <span class="kpi-tile-label">Total Orders</span>
                        <div class="kpi-tile-icon blue"><i class="fa fa-shopping-bag"></i></div>
                    </div>
                    <div class="kpi-value">{{ number_format($totalOrders) }}</div>
                    @if($ordersGrowth !== null)
                        <div class="kpi-badge {{ $ordersGrowth >= 0 ? 'up' : 'down' }}"><i
                                class="fa fa-arrow-{{ $ordersGrowth >= 0 ? 'up' : 'down' }}"></i> {{ abs($ordersGrowth) }}%
                            vs prev</div>
                    @else
                        <div class="kpi-badge neutral">No prior data</div>
                    @endif
                </div>
                <div class="kpi-tile">
                    <div class="kpi-tile-top">
                        <span class="kpi-tile-label">Delivered</span>
                        <div class="kpi-tile-icon green"><i class="fa fa-check-circle"></i></div>
                    </div>
                    <div class="kpi-value">{{ number_format($delivered) }}</div>
                    <div class="kpi-badge up">{{ $deliveryRate }}% delivery rate</div>
                </div>
                <div class="kpi-tile">
                    <div class="kpi-tile-top">
                        <span class="kpi-tile-label">Cancelled</span>
                        <div class="kpi-tile-icon red"><i class="fa fa-times-circle"></i></div>
                    </div>
                    <div class="kpi-value">{{ number_format($cancelled) }}</div>
                    @if($cancelledGrowth !== null)
                        <div class="kpi-badge {{ $cancelledGrowth <= 0 ? 'up' : 'down' }}"><i
                                class="fa fa-arrow-{{ $cancelledGrowth >= 0 ? 'up' : 'down' }}"></i>
                            {{ abs($cancelledGrowth) }}% vs prev
                        </div>
                    @else
                        <div class="kpi-badge neutral">No prior data</div>
                    @endif
                </div>
                <div class="kpi-tile">
                    <div class="kpi-tile-top">
                        <span class="kpi-tile-label">Avg. Fulfilment</span>
                        <div class="kpi-tile-icon amber"><i class="fa fa-clock-o"></i></div>
                    </div>
                    <div class="kpi-value">{{ $avgFulfilment }}d</div>
                    <div class="kpi-badge neutral">Order → Delivered</div>
                </div>
                <div class="kpi-tile">
                    <div class="kpi-tile-top">
                        <span class="kpi-tile-label">Return Rate</span>
                        <div class="kpi-tile-icon purple"><i class="fa fa-reply"></i></div>
                    </div>
                    <div class="kpi-value">{{ $returnRate }}%</div>
                    <div class="kpi-badge neutral">{{ $returnedCount }} returns</div>
                </div>

                <div class="kpi-tile">
                    <div class="kpi-tile-top">
                        <span class="kpi-tile-label">RTO Rate</span>
                        <div class="kpi-tile-icon purple"><i class="fa fa-truck-ramp-box"></i></div>
                    </div>
                    <div class="kpi-value">{{ $rtoRate }}%</div>
                    <div class="kpi-badge neutral">{{ $rtoCount }} RTOs</div>
                </div>
            </div>

            <!-- Order Trend + Status Donut -->
            <div class="charts-2col">
                <div class="sc">
                    <div class="sc-head">
                        <h5>Order Volume Over Time</h5>
                        <span class="sc-head-sub">Daily · {{ $from->format('d M Y') }} –
                            {{ $to->format('d M Y') }}</span>
                    </div>
                    <div class="sc-body">
                        <div style="font-size:12px;color:var(--text-hint);margin-bottom:10px">
                            📦 Busiest day: <strong style="color:var(--text-primary)">{{ $busiestDay ?? '—' }}</strong>
                            — {{ $busiestCount }} orders
                        </div>
                        <div class="chart-wrap-lg">
                            <canvas id="orderTrendChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="sc">
                    <div class="sc-head">
                        <h5>Orders by Status</h5>
                        <span class="sc-head-sub">{{ $from->format('d M Y') }} – {{ $to->format('d M Y') }}</span>
                    </div>
                    <div class="sc-body">
                        <div class="chart-wrap-md" style="height:180px">
                            <canvas id="statusDonut"></canvas>
                        </div>
                        <div style="margin-top:14px">
                            @foreach($statusBreakdown as $s)
                                <div class="cat-row">
                                    <div class="cat-color-dot" style="background:{{ $s['color'] }}"></div>
                                    <span class="cat-row-name">{{ $s['label'] }}</span>
                                    <span class="cat-row-pct">{{ $s['pct'] }}%</span>
                                    <span class="cat-row-count">{{ number_format($s['count']) }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- City + Fulfilment -->
            <div class="charts-2col">
                <div class="sc">
                    <div class="sc-head">
                        <h5>Orders by Delivery City</h5>
                        <span class="sc-head-sub">Top 7 cities</span>
                    </div>
                    <div class="sc-body">
                        <div class="chart-wrap-sm"><canvas id="cityChart"></canvas></div>
                    </div>
                </div>
                <div class="sc">
                    <div class="sc-head">
                        <h5>Fulfilment Time Distribution</h5>
                        <span class="sc-head-sub">Days from order to delivery</span>
                    </div>
                    <div class="sc-body">
                        <div class="chart-wrap-sm"><canvas id="fulfilmentChart"></canvas></div>
                    </div>
                </div>
            </div>

            <!-- Period Comparison + Daily Breakdown -->
            <div class="charts-equal">
                <div class="sc">
                    <div class="sc-head">
                        <h5>Period Comparison</h5>
                        <span class="sc-head-sub">This period vs previous period</span>
                    </div>
                    <div class="sc-body">
                        <div class="compare-strip">
                            <div class="compare-cell">
                                <div class="compare-cell-label">This Period</div>
                                <div class="compare-cell-value">{{ number_format($totalOrders) }}</div>
                                <div class="compare-cell-sub">{{ $from->format('d M Y') }} – {{ $to->format('d M Y') }}
                                </div>
                            </div>
                            <div class="compare-cell" style="background:#fafafa">
                                <div class="compare-cell-label">Last Period</div>
                                <div class="compare-cell-value" style="color:var(--text-secondary)">
                                    {{ number_format($firstHalfPrev + $secondHalfPrev) }}
                                </div>
                                <div class="compare-cell-sub">Previous equal-length period</div>
                            </div>
                        </div>
                        <div class="chart-wrap-sm"><canvas id="compareChart"></canvas></div>
                    </div>
                </div>
                <div class="sc">
                    <div class="sc-head">
                        <h5>Daily Order Breakdown</h5>
                        <span class="sc-head-sub">Last 7 days</span>
                    </div>
                    <div style="overflow-x:auto">
                        <table class="sum-table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Orders</th>
                                    <th>Delivered</th>
                                    <th>Cancelled</th>
                                    <th>vs Yesterday</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($dailyBreakdown as $row)
                                    <tr>
                                        <td style="font-weight:500">{{ $row['date']->format('d M, D') }}</td>
                                        <td class="units-cell">{{ $row['orders'] }}</td>
                                        <td style="color:var(--green);font-weight:600">{{ $row['delivered'] }}</td>
                                        <td style="color:var(--red);font-weight:600">{{ $row['cancelled'] }}</td>
                                        <td>
                                            @if($row['vs_yesterday'] === null)
                                                <span class="growth neutral"><i class="fa fa-minus"></i> —</span>
                                            @else
                                                <span
                                                    class="growth {{ $row['vs_yesterday'] > 0 ? 'up' : ($row['vs_yesterday'] < 0 ? 'down' : 'neutral') }}">
                                                    <i class="fa fa-arrow-{{ $row['vs_yesterday'] >= 0 ? 'up' : 'down' }}"></i>
                                                    {{ abs($row['vs_yesterday']) }}%
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" style="text-align:center;padding:20px;color:var(--text-hint)">No
                                            data.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>7-Day Total</td>
                                    <td style="color:var(--text-secondary)">{{ $sevenDayTotals['orders'] }}</td>
                                    <td style="color:var(--green)">{{ $sevenDayTotals['delivered'] }}</td>
                                    <td style="color:var(--red)">{{ $sevenDayTotals['cancelled'] }}</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>



            <!-- Order List Table -->
            <div class="sc" style="margin-bottom:20px">
                <div class="sc-head">
                    <h5>Order Details</h5>
                    <div style="display:flex;gap:8px;align-items:center">
                        <span class="sc-head-sub">{{ $from->format('d M Y') }} – {{ $to->format('d M Y') }}</span>
                        <a href="{{ route('admin.orders.index') }}"
                            style="font-size:12px;color:var(--accent);text-decoration:none;font-weight:500">View All
                            →</a>
                    </div>
                </div>
                <div style="overflow-x:auto">
                    <table class="sum-table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Date</th>
                                <th>Items</th>
                                <th>Amount</th>
                                <th>Payment</th>
                                <th>Courier</th>
                                <th>Status</th>
                                <th>Fulfilment</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $o)
                                <tr>
                                    <td><a href="{{ route('admin.orders.show', $o->id) }}"
                                            style="font-size:12.5px;font-family:'SF Mono','Fira Code',monospace;color:var(--accent);text-decoration:none;font-weight:600">#{{ $o->order_number }}</a>
                                    </td>
                                    <td>
                                        <div style="font-weight:560;font-size:13px">{{ $o->customer_name }}</div>
                                        <div style="font-size:11.5px;color:var(--text-hint)">{{ $o->city?->name }}</div>
                                    </td>
                                    <td style="font-size:13px;color:var(--text-secondary)">
                                        {{ $o->created_at->format('d M Y') }}<br><span
                                            style="font-size:11.5px;color:var(--text-hint)">{{ $o->created_at->format('h:i A') }}</span>
                                    </td>
                                    <td class="units-cell">{{ $o->items->count() }}</td>
                                    <td class="rev-cell">₹{{ number_format($o->grand_total, 0) }}</td>
                                    <td><span
                                            style="font-size:12.5px;color:var(--text-secondary)">{{ strtoupper($o->payment_method) }}</span>
                                    </td>
                                    <td>
                                        <span
                                            style="font-size:12.5px;color:var(--text-secondary)">{{ $o->courier?->name ?? '—' }}</span>
                                        @if($o->tracking_number)
                                            <div style="font-size:11px;font-family:'SF Mono',monospace;color:var(--text-hint)">
                                                {{ $o->tracking_number }}
                                            </div>
                                        @endif
                                    </td>
                                    <td><span class="status-pill sp-{{ $o->status }}">{{ ucfirst($o->status) }}</span></td>
                                    <td>
                                        @if($o->status === 'delivered')
                                            @php $deliveredEntry = $o->statusHistory->where('status', 'delivered')->last(); @endphp
                                            @if($deliveredEntry)
                                                <span
                                                    style="font-size:13px;font-weight:600;color:var(--green)">{{ $o->created_at->diffInDays($deliveredEntry->created_at) }}d</span>
                                            @else
                                                <span style="font-size:13px;color:var(--text-hint)">—</span>
                                            @endif
                                        @else
                                            <span style="font-size:13px;color:var(--text-hint)">—</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" style="text-align:center;padding:30px;color:var(--text-hint)">No orders
                                        found for this period.</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3">Period Total ({{ $orders->count() }} shown)</td>
                                <td style="color:var(--text-secondary)">{{ $periodItemsTotal }} items</td>
                                <td style="color:var(--accent)">₹{{ number_format($periodAmountTotal, 0) }}</td>
                                <td colspan="4"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- Pagination -->
                <div
                    style="padding:14px 20px;border-top:1px solid var(--border);display:flex;align-items:center;justify-content:space-between">
                    <span style="font-size:12.5px;color:var(--text-hint)">Showing
                        {{ $orders->firstItem() ?? 0 }}–{{ $orders->lastItem() ?? 0 }} of {{ $orders->total() }}
                        orders</span>
                    <div style="display:flex;gap:4px">
                        {{ $orders->onEachSide(1)->links() }}
                    </div>
                </div>
            </div>

            <!-- Cancellation Reasons + Key Metrics -->
            <div class="charts-equal">
                <div class="sc">
                    <div class="sc-head">
                        <h5>Top Cancellation Reasons</h5>
                        <span class="sc-head-sub">{{ $from->format('d M Y') }} – {{ $to->format('d M Y') }}</span>
                    </div>
                    <div style="overflow-x:auto">
                        <table class="sum-table">
                            <thead>
                                <tr>
                                    <th>Reason</th>
                                    <th>Orders</th>
                                    <th>Share</th>
                                    <th>Trend</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($cancelReasons as $reason)
                                    @php $pct = $cancelReasonsTotal > 0 ? round($reason->c / $cancelReasonsTotal * 100) : 0; @endphp
                                    <tr>
                                        <td style="font-size:13px;font-weight:500">
                                            {{ $reason->remarks ?: 'No reason given' }}
                                        </td>
                                        <td class="units-cell">{{ $reason->c }}</td>
                                        <td>
                                            <div style="display:flex;align-items:center;gap:8px">
                                                <div class="prog-bar">
                                                    <div class="prog-fill" style="width:{{ $pct }}%;background:var(--red)">
                                                    </div>
                                                </div><span style="font-size:12px;color:var(--text-hint)">{{ $pct }}%</span>
                                            </div>
                                        </td>
                                        <td><span class="growth neutral">—</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" style="text-align:center;padding:20px;color:var(--text-hint)">No
                                            cancellations in this period.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="sc">
                    <div class="sc-head">
                        <h5>Key Order Metrics</h5>
                        <span class="sc-head-sub">{{ $from->format('d M Y') }} – {{ $to->format('d M Y') }}</span>
                    </div>
                    <div class="sc-body">
                        <div class="info-row"><span class="info-label">Total Orders</span><span
                                class="info-value">{{ number_format($totalOrders) }}</span></div>
                        <div class="info-row"><span class="info-label">Delivered</span><span class="info-value"
                                style="color:var(--green)">{{ $delivered }} ({{ $deliveryRate }}%)</span></div>
                        <div class="info-row"><span class="info-label">Processing / Shipped</span><span
                                class="info-value" style="color:var(--blue)">{{ $processingShipped }}</span></div>
                        <div class="info-row"><span class="info-label">Pending</span><span class="info-value"
                                style="color:var(--amber)">{{ $pending }}</span></div>
                        <div class="info-row"><span class="info-label">Cancelled</span><span class="info-value"
                                style="color:var(--red)">{{ $cancelled }}
                                ({{ $totalOrders > 0 ? round($cancelled / $totalOrders * 100, 1) : 0 }}%)</span></div>
                        <div class="info-row"><span class="info-label">Returned</span><span class="info-value"
                                style="color:var(--purple)">{{ $returnedCount }} ({{ $returnRate }}%)</span></div>
                        <div class="info-row"><span class="info-label">Avg. Fulfilment Time</span><span
                                class="info-value">{{ $avgFulfilment }} days</span></div>
                        <div class="info-row"><span class="info-label">Peak Order Hour</span><span
                                class="info-value">{{ $peakHour ? \Carbon\Carbon::createFromTime($peakHour->h)->format('g A') . ' – ' . \Carbon\Carbon::createFromTime($peakHour->h)->addHour()->format('g A') : '—' }}</span>
                        </div>
                        <div class="info-row"><span class="info-label">Orders via COD</span><span
                                class="info-value">{{ $codCount }}
                                ({{ $totalOrders > 0 ? round($codCount / $totalOrders * 100) : 0 }}%)</span></div>
                        <div class="info-row"
                            style="border-top:2px solid var(--border);margin-top:4px;padding-top:12px">
                            <span style="font-size:14px;font-weight:650;color:var(--text-primary)">Avg. Order
                                Value</span>
                            <span
                                style="font-size:18px;font-weight:750;color:var(--accent)">₹{{ number_format($avgOrderValue) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="sc" style="margin-bottom:20px">
                <div class="sc-head">
                    <h5>Top RTO Reasons & Refund Status</h5>
                    <div style="display:flex;gap:8px;align-items:center">
                        <span class="sc-head-sub">{{ $from->format('d M Y') }} – {{ $to->format('d M Y') }}</span>
                        <a href="{{ route('admin.reports.ndr') }}"
                            style="font-size:12px;color:var(--accent);text-decoration:none;font-weight:500">View NDR
                            Report →</a>
                    </div>
                </div>
                <div class="sc-body" style="display:grid;grid-template-columns:1.4fr 1fr;gap:20px">

                    <div>
                        <table class="sum-table">
                            <thead>
                                <tr>
                                    <th>Reason</th>
                                    <th>Orders</th>
                                    <th>Share</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rtoReasons as $r)
                                    @php $pct = $rtoReasonsTotal > 0 ? round($r['count'] / $rtoReasonsTotal * 100) : 0; @endphp
                                    <tr>
                                        <td style="font-size:13px;font-weight:500">{{ $r['label'] }}</td>
                                        <td class="units-cell">{{ $r['count'] }}</td>
                                        <td>
                                            <div style="display:flex;align-items:center;gap:8px">
                                                <div class="prog-bar">
                                                    <div class="prog-fill"
                                                        style="width:{{ $pct }}%;background:var(--purple)"></div>
                                                </div>
                                                <span style="font-size:12px;color:var(--text-hint)">{{ $pct }}%</span>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" style="text-align:center;padding:20px;color:var(--text-hint)">No
                                            RTOs in this period.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div>
                        <div class="info-row">
                            <span class="info-label">Prepaid RTOs</span>
                            <span class="info-value">{{ $rtoPrepaidCount }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Refunded</span>
                            <span class="info-value" style="color:var(--green)">{{ $rtoRefundedCount }}</span>
                        </div>
                        <div class="info-row"
                            style="{{ $rtoPendingRefundCount > 0 ? 'border-top:2px solid var(--border);margin-top:4px;padding-top:12px' : '' }}">
                            <span
                                style="font-size:13px;font-weight:650;{{ $rtoPendingRefundCount > 0 ? 'color:var(--red)' : 'color:var(--text-hint)' }}">
                                Refund Pending
                            </span>
                            <span
                                style="font-size:16px;font-weight:750;{{ $rtoPendingRefundCount > 0 ? 'color:var(--red)' : 'color:var(--text-hint)' }}">
                                {{ $rtoPendingRefundCount }}
                            </span>
                        </div>
                        @if($rtoPendingRefundCount > 0)
                            <div style="font-size:11.5px;color:var(--text-hint);margin-top:8px">
                                ⚠️ These prepaid orders are RTO'd but have no recorded refund — check the NDR report.
                            </div>
                        @endif
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

@include('admin.footer')

<script>
    /* ── Server data ── */
    const trendLabels = @json($trendLabels);
    const trendData = @json($trendData);

    const statusLabels = @json(array_column($statusBreakdown, 'label'));
    const statusData = @json(array_column($statusBreakdown, 'count'));
    const statusColors = @json(array_column($statusBreakdown, 'color'));

    const cityLabels = @json($cityData->pluck('name'));
    const cityCounts = @json($cityData->pluck('count'));

    const bucketLabels = @json(array_keys($buckets));
    const bucketData = @json(array_values($buckets));

    const compareThis = [{{ $firstHalfCurrent }}, {{ $secondHalfCurrent }}];
    const comparePrev = [{{ $firstHalfPrev }}, {{ $secondHalfPrev }}];

    /* Order trend */
    (function () {
        const ctx = document.getElementById('orderTrendChart');
        if (!ctx) return;
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: trendLabels,
                datasets: [{
                    label: 'Orders', data: trendData, fill: true, tension: 0.45,
                    borderColor: '#303d89', borderWidth: 2.5,
                    pointRadius: 3, pointHoverRadius: 6, pointBackgroundColor: '#303d89',
                    backgroundColor: (c) => {
                        const { ctx: ct, chartArea } = c.chart;
                        if (!chartArea) return 'transparent';
                        const g = ct.createLinearGradient(0, chartArea.top, 0, chartArea.bottom);
                        g.addColorStop(0, 'rgba(48,61,137,.18)');
                        g.addColorStop(1, 'rgba(48,61,137,0)');
                        return g;
                    }
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false }, tooltip: { backgroundColor: '#202223', cornerRadius: 8, padding: 10, callbacks: { label: v => ' ' + v.parsed.y + ' orders' } } },
                scales: {
                    x: { grid: { display: false }, ticks: { color: '#8c9196', font: { size: 11 }, maxTicksLimit: 12 }, border: { display: false } },
                    y: { grid: { color: '#f1f2f4' }, border: { display: false }, ticks: { color: '#8c9196', font: { size: 11 } } }
                }
            }
        });
    })();

    /* Status donut */
    (function () {
        const ctx = document.getElementById('statusDonut'); if (!ctx) return;
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: statusLabels,
                datasets: [{ data: statusData, backgroundColor: statusColors, borderWidth: 2, borderColor: '#fff', hoverOffset: 6 }]
            },
            options: { responsive: true, maintainAspectRatio: false, cutout: '70%', plugins: { legend: { display: false } } }
        });
    })();

    /* City bar */
    (function () {
        const ctx = document.getElementById('cityChart'); if (!ctx) return;
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: cityLabels,
                datasets: [{ label: 'Orders', data: cityCounts, backgroundColor: '#303d89', borderRadius: 5, borderSkipped: false }]
            },
            options: {
                indexAxis: 'y', responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false }, tooltip: { backgroundColor: '#202223', cornerRadius: 8 } },
                scales: {
                    x: { grid: { color: '#f1f2f4' }, border: { display: false }, ticks: { color: '#8c9196', font: { size: 11 } } },
                    y: { grid: { display: false }, border: { display: false }, ticks: { color: '#8c9196', font: { size: 11 } } }
                }
            }
        });
    })();

    /* Fulfilment distribution */
    (function () {
        const ctx = document.getElementById('fulfilmentChart'); if (!ctx) return;
        const maxVal = Math.max(...bucketData, 0);
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: bucketLabels,
                datasets: [{
                    label: 'Orders', data: bucketData,
                    backgroundColor: bucketData.map(v => v === maxVal && v > 0 ? '#303d89' : '#c5c9ed'),
                    borderRadius: 5, borderSkipped: false
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false }, tooltip: { backgroundColor: '#202223', cornerRadius: 8 } },
                scales: {
                    x: { grid: { display: false }, border: { display: false }, ticks: { color: '#8c9196', font: { size: 11 } } },
                    y: { grid: { color: '#f1f2f4' }, border: { display: false }, ticks: { color: '#8c9196', font: { size: 11 } } }
                }
            }
        });
    })();

    /* Period comparison */
    (function () {
        const ctx = document.getElementById('compareChart'); if (!ctx) return;
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['First Half', 'Second Half'],
                datasets: [
                    { label: 'This Period', data: compareThis, backgroundColor: '#303d89', borderRadius: 6, borderSkipped: false },
                    { label: 'Last Period', data: comparePrev, backgroundColor: '#e3e5e8', borderRadius: 6, borderSkipped: false }
                ]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom', labels: { font: { size: 11 }, boxWidth: 10, padding: 10 } }, tooltip: { backgroundColor: '#202223', cornerRadius: 8 } },
                scales: {
                    x: { grid: { display: false }, ticks: { font: { size: 11 }, color: '#8c9196' }, border: { display: false } },
                    y: { grid: { color: '#f1f2f4' }, border: { display: false }, ticks: { font: { size: 11 }, color: '#8c9196' } }
                }
            }
        });
    })();

    /* Custom date toggle */
    function toggleCustom() {
        const inputs = document.getElementById('customInputs');
        inputs.style.display = inputs.style.display === 'none' ? 'flex' : 'none';
    }
    @if($preset !== 'custom')
        document.getElementById('customInputs').style.display = 'none';
    @endif
</script>