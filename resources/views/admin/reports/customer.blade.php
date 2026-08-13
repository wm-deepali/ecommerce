@include('admin.top-header')

<div class="main-section">
    @include('admin.header')

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
    :root {
        --bg:            #f1f2f4;
        --surface:       #ffffff;
        --border:        #e3e5e8;
        --text-primary:  #202223;
        --text-secondary:#6d7175;
        --text-hint:     #8c9196;
        --accent:        #303d89;
        --accent-light:  #f0f1fc;
        --green:         #007a5e;
        --green-bg:      #e3f1ec;
        --red:           #b22222;
        --red-bg:        #fce8e8;
        --amber:         #916a00;
        --amber-bg:      #fff5cc;
        --blue:          #0069d9;
        --blue-bg:       #e8f2ff;
        --purple:        #6d28d9;
        --purple-bg:     #ede9fe;
        --radius-sm:     8px;
        --radius-md:     12px;
        --shadow-card:   0 1px 3px rgba(0,0,0,.08), 0 0 0 1px var(--border);
        --font:          'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }

    .creport-page { background: var(--bg); padding: 24px 28px; min-height: 100vh; font-family: var(--font); color: var(--text-primary); }
    .creport-page * { box-sizing: border-box; }

    .page-header { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 20px; }
    .page-header h1 { font-size: 20px; font-weight: 650; margin: 0; }
    .crumb { font-size: 12.5px; color: var(--text-hint); margin-top: 3px; }
    .crumb a { color: var(--accent); text-decoration: none; }
    .crumb a:hover { text-decoration: underline; }
    .crumb span { margin: 0 5px; }

    .btn-primary-dash {
        display: inline-flex; align-items: center; gap: 6px;
        background: var(--accent); color: #fff; border: none;
        border-radius: var(--radius-sm); padding: 8px 16px;
        font-size: 13px; font-weight: 600; cursor: pointer;
        text-decoration: none; font-family: var(--font);
        transition: background .15s; box-shadow: 0 1px 3px rgba(48,61,137,.25);
    }
    .btn-primary-dash:hover { background: #252f70; color: #fff; }

    .btn-secondary-dash {
        display: inline-flex; align-items: center; gap: 6px;
        background: var(--surface); color: var(--text-primary);
        border: 1px solid var(--border); border-radius: var(--radius-sm);
        padding: 8px 16px; font-size: 13px; font-weight: 500; cursor: pointer;
        text-decoration: none; font-family: var(--font);
        transition: background .15s; box-shadow: 0 1px 2px rgba(0,0,0,.04);
    }
    .btn-secondary-dash:hover { background: var(--bg); color: var(--text-primary); }

    .date-bar { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 14px 20px; margin-bottom: 20px; box-shadow: var(--shadow-card); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; }
    .date-bar-left { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
    .date-preset { display: inline-flex; align-items: center; padding: 6px 14px; border: 1px solid var(--border); border-radius: 20px; font-size: 12.5px; font-weight: 500; color: var(--text-secondary); cursor: pointer; transition: all .15s; background: var(--surface); }
    .date-preset:hover { border-color: var(--accent); color: var(--accent); background: var(--accent-light); }
    .date-preset.active { border-color: var(--accent); color: var(--accent); background: var(--accent-light); font-weight: 600; }
    .date-input { height: 34px; border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 0 10px; font-size: 13px; color: var(--text-primary); background: var(--surface); outline: none; font-family: var(--font); }
    .date-input:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(48,61,137,.12); }
    .btn-apply { height: 34px; display: inline-flex; align-items: center; gap: 5px; background: var(--accent); color: #fff; border: none; border-radius: var(--radius-sm); padding: 0 14px; font-size: 13px; font-weight: 600; cursor: pointer; }
    .btn-apply:hover { background: #252f70; }

    .kpi-strip { display: grid; grid-template-columns: repeat(5,1fr); gap: 14px; margin-bottom: 20px; }
    @media(max-width:1100px) { .kpi-strip { grid-template-columns: repeat(3,1fr); } }
    @media(max-width:650px)  { .kpi-strip { grid-template-columns: repeat(2,1fr); } }

    .kpi-tile { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 18px 18px 14px; box-shadow: var(--shadow-card); }
    .kpi-top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px; }
    .kpi-label { font-size: 11.5px; font-weight: 600; color: var(--text-hint); text-transform: uppercase; letter-spacing: .04em; }
    .kpi-icon { width: 34px; height: 34px; border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center; font-size: 14px; }
    .kpi-icon.green  { background: var(--green-bg);  color: var(--green); }
    .kpi-icon.blue   { background: var(--blue-bg);   color: var(--blue); }
    .kpi-icon.purple { background: var(--purple-bg); color: var(--purple); }
    .kpi-icon.amber  { background: var(--amber-bg);  color: var(--amber); }
    .kpi-icon.red    { background: var(--red-bg);    color: var(--red); }
    .kpi-value { font-size: 22px; font-weight: 750; color: var(--text-primary); line-height: 1; }
    .kpi-badge { display: inline-flex; align-items: center; gap: 3px; font-size: 11px; font-weight: 600; padding: 2px 7px; border-radius: 20px; margin-top: 7px; }
    .kpi-badge.up      { background: var(--green-bg); color: var(--green); }
    .kpi-badge.down    { background: var(--red-bg);   color: var(--red); }
    .kpi-badge.neutral { background: var(--bg);       color: var(--text-hint); }

    .sc { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-md); box-shadow: var(--shadow-card); overflow: hidden; }
    .sc-head { padding: 14px 20px; border-bottom: 1px solid var(--border); background: #fafafa; display: flex; align-items: center; justify-content: space-between; }
    .sc-head h5 { font-size: 13px; font-weight: 650; color: var(--text-primary); margin: 0; }
    .sc-body { padding: 20px; }
    .sc-sub { font-size: 12px; color: var(--text-hint); }

    .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px; }
    .grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; margin-bottom: 20px; }
    .grid-3-1 { display: grid; grid-template-columns: 2fr 1fr; gap: 16px; margin-bottom: 20px; }
    @media(max-width:960px) { .grid-2,.grid-3,.grid-3-1 { grid-template-columns: 1fr; } }

    .chart-lg { position: relative; height: 260px; }
    .chart-md { position: relative; height: 210px; }
    .chart-sm { position: relative; height: 175px; }

    .data-table { width: 100%; border-collapse: collapse; font-size: 13px; }
    .data-table thead th { font-size: 11px; font-weight: 600; letter-spacing: .06em; text-transform: uppercase; color: var(--text-hint); padding: 10px 16px; border-bottom: 1px solid var(--border); background: #fafafa; text-align: left; white-space: nowrap; }
    .data-table tbody tr { border-bottom: 1px solid var(--border); transition: background .1s; }
    .data-table tbody tr:last-child { border-bottom: none; }
    .data-table tbody tr:hover { background: #fafbfc; }
    .data-table tbody td { padding: 12px 16px; vertical-align: middle; }
    .data-table tfoot td { padding: 12px 16px; border-top: 2px solid var(--border); font-weight: 700; font-size: 13px; background: #fafafa; }

    .cust-av { width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; flex-shrink: 0; }
    .cust-name { font-size: 13px; font-weight: 600; color: var(--text-primary); }
    .cust-email { font-size: 11.5px; color: var(--text-hint); margin-top: 1px; }

    .rank { display: inline-flex; align-items: center; justify-content: center; width: 24px; height: 24px; border-radius: 50%; font-size: 11px; font-weight: 700; background: var(--bg); color: var(--text-secondary); }
    .rank.gold   { background: #fff8e1; color: #b8860b; }
    .rank.silver { background: #f5f5f5; color: #707070; }
    .rank.bronze { background: #fdf0e8; color: #9c5400; }

    .seg-pill { display: inline-flex; align-items: center; gap: 4px; font-size: 11.5px; font-weight: 600; padding: 3px 9px; border-radius: 20px; }
    .seg-vip      { background: #fff8e1; color: #b8860b; }
    .seg-loyal    { background: var(--green-bg);  color: var(--green); }
    .seg-new      { background: var(--blue-bg);   color: var(--blue); }
    .seg-at-risk  { background: var(--red-bg);    color: var(--red); }
    .seg-dormant  { background: var(--bg);         color: var(--text-hint); }
    .seg-promising{ background: var(--purple-bg); color: var(--purple); }

    .growth { display: inline-flex; align-items: center; gap: 3px; font-size: 11.5px; font-weight: 600; padding: 2px 7px; border-radius: 20px; }
    .growth.up   { background: var(--green-bg); color: var(--green); }
    .growth.down { background: var(--red-bg);   color: var(--red); }

    .prog-bar { height: 5px; border-radius: 10px; background: var(--bg); overflow: hidden; margin-top: 5px; }
    .prog-fill { height: 100%; border-radius: 10px; }

    .info-row { display: flex; justify-content: space-between; align-items: center; padding: 9px 0; border-bottom: 1px solid var(--bg); font-size: 13px; }
    .info-row:first-child { padding-top: 0; }
    .info-row:last-child  { border-bottom: none; padding-bottom: 0; }
    .info-label { color: var(--text-hint); font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: .03em; }
    .info-value { font-weight: 600; color: var(--text-primary); }

    .funnel-row { display: flex; align-items: center; gap: 12px; margin-bottom: 12px; }
    .funnel-row:last-child { margin-bottom: 0; }
    .funnel-label { font-size: 12.5px; font-weight: 500; color: var(--text-secondary); width: 140px; flex-shrink: 0; }
    .funnel-bar-wrap { flex: 1; }
    .funnel-bar { height: 28px; border-radius: var(--radius-sm); display: flex; align-items: center; padding: 0 10px; font-size: 12px; font-weight: 700; color: #fff; transition: width .3s; }
    .funnel-count { font-size: 12.5px; font-weight: 700; color: var(--text-primary); width: 60px; text-align: right; flex-shrink: 0; }
    .funnel-pct   { font-size: 11.5px; color: var(--text-hint); width: 40px; text-align: right; flex-shrink: 0; }

    .cohort-grid { display: grid; grid-template-columns: 130px repeat(6,1fr); gap: 1px; background: var(--border); border-radius: var(--radius-sm); overflow: hidden; font-size: 12px; }
    .cohort-cell { background: var(--surface); padding: 8px 10px; text-align: center; }
    .cohort-cell.header { background: #fafafa; font-weight: 650; color: var(--text-hint); font-size: 11px; text-transform: uppercase; letter-spacing: .04em; }
    .cohort-cell.label  { text-align: left; font-weight: 500; color: var(--text-primary); }
    .cohort-cell.heat-5  { background: #e3f1ec; color: var(--green); font-weight: 700; }
    .cohort-cell.heat-4  { background: #edf6f2; color: var(--green); font-weight: 600; }
    .cohort-cell.heat-3  { background: #f5fbf8; color: var(--text-secondary); }
    .cohort-cell.heat-2  { background: var(--surface); color: var(--text-hint); }
    .cohort-cell.heat-1  { background: var(--bg);      color: var(--text-hint); font-size: 11px; }

    .loc-row { display: flex; align-items: center; gap: 10px; padding: 10px 0; border-bottom: 1px solid var(--bg); }
    .loc-row:first-child { padding-top: 0; }
    .loc-row:last-child  { border-bottom: none; padding-bottom: 0; }
    .loc-flag { font-size: 18px; flex-shrink: 0; }
    .loc-name { flex: 1; font-size: 13px; font-weight: 500; color: var(--text-primary); }
    .loc-bar-wrap { width: 80px; }
    .loc-bar { height: 5px; border-radius: 10px; background: var(--bg); overflow: hidden; }
    .loc-fill { height: 100%; border-radius: 10px; background: var(--accent); }
    .loc-count { font-size: 13px; font-weight: 700; color: var(--text-primary); width: 40px; text-align: right; flex-shrink: 0; }
    .loc-pct   { font-size: 11.5px; color: var(--text-hint); width: 36px; text-align: right; flex-shrink: 0; }

    .device-row { display: flex; align-items: center; gap: 10px; padding: 10px 0; border-bottom: 1px solid var(--bg); }
    .device-row:first-child { padding-top: 0; }
    .device-row:last-child  { border-bottom: none; }
    .device-icon-wrap { width: 34px; height: 34px; border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center; font-size: 15px; flex-shrink: 0; }

    @media(max-width:768px) { .creport-page { padding: 16px; } }

    /* ── Print ───────────────────────────────────────────── */
    @media print {
        .no-print { display: none !important; }
        body, .creport-page { background: #fff !important; }
        .creport-page { padding: 0 !important; }
        .kpi-strip { grid-template-columns: repeat(3,1fr); }
        .grid-3-1, .grid-3, .grid-2 { grid-template-columns: 1fr 1fr; }
        .sc { box-shadow: none; border: 1px solid #ccc; break-inside: avoid; page-break-inside: avoid; margin-bottom: 14px; }
        .kpi-tile { break-inside: avoid; page-break-inside: avoid; box-shadow: none; }
        a[href]:after { content: ""; }
        * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
    }
    </style>

    <div class="app-content content container-fluid">
        <div class="creport-page">

            <!-- Page header -->
            <div class="page-header">
                <div>
                    <h1>Customer Report</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        Customer Report
                    </div>
                </div>
                <div class="no-print" style="display:flex;gap:8px;flex-wrap:wrap">
                    <a href="#" id="printReportBtn" class="btn-secondary-dash"><i class="fa fa-print"></i> Print</a>
                    <a href="{{ route('admin.reports.customers.export.excel', request()->query()) }}" class="btn-secondary-dash"><i class="fa fa-file-excel-o"></i> Export Excel</a>
                    <a href="{{ route('admin.reports.customers.export.pdf', request()->query()) }}" class="btn-primary-dash"><i class="fa fa-download"></i> Export PDF</a>
                </div>
            </div>

            <!-- Date bar -->
            <div class="date-bar no-print">
                <form method="GET" action="{{ route('admin.reports.customers') }}" id="rangeForm" style="display:contents">
                <div class="date-bar-left">
                    <span style="font-size:12.5px;font-weight:600;color:var(--text-secondary);margin-right:4px">Period:</span>
                    @php
                        $presets = ['today' => 'Today', 'this_week' => 'This Week', 'this_month' => 'This Month', 'last_month' => 'Last Month', 'this_year' => 'This Year', 'custom' => 'Custom'];
                    @endphp
                    @foreach($presets as $val => $label)
                        <span class="date-preset {{ $range === $val ? 'active' : '' }}" data-range="{{ $val }}">{{ $label }}</span>
                    @endforeach
                    <input type="hidden" name="range" id="rangeInput" value="{{ $range }}">
                </div>
                <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap">
                    <input type="date" name="start_date" class="date-input" value="{{ $start->toDateString() }}">
                    <span style="color:var(--text-hint)">→</span>
                    <input type="date" name="end_date" class="date-input" value="{{ $end->toDateString() }}">
                    <button type="submit" class="btn-apply"><i class="fa fa-check"></i> Apply</button>
                </div>
                </form>
            </div>

            <!-- Print-only header strip showing the selected period -->
            <div style="display:none" class="print-only-period">
                <strong>Period:</strong> {{ $start->format('d M Y') }} – {{ $end->format('d M Y') }}
            </div>

            <!-- KPI strip -->
            <div class="kpi-strip">

                <div class="kpi-tile">
                    <div class="kpi-top">
                        <span class="kpi-label">Total Customers</span>
                        <div class="kpi-icon blue"><i class="fa fa-users"></i></div>
                    </div>
                    <div class="kpi-value">{{ number_format($totalCustomers) }}</div>
                    <div class="kpi-badge {{ $totalGrowth >= 0 ? 'up' : 'down' }}">
                        <i class="fa fa-arrow-{{ $totalGrowth >= 0 ? 'up' : 'down' }}"></i> {{ abs($totalGrowth) }}% vs last month
                    </div>
                </div>

                <div class="kpi-tile">
                    <div class="kpi-top">
                        <span class="kpi-label">New Customers</span>
                        <div class="kpi-icon green"><i class="fa fa-user-plus"></i></div>
                    </div>
                    <div class="kpi-value">{{ number_format($newThis) }}</div>
                    <div class="kpi-badge {{ $newGrowth >= 0 ? 'up' : 'down' }}">
                        <i class="fa fa-arrow-{{ $newGrowth >= 0 ? 'up' : 'down' }}"></i> {{ abs($newGrowth) }}% vs last month
                    </div>
                </div>

                <div class="kpi-tile">
                    <div class="kpi-top">
                        <span class="kpi-label">Returning Rate</span>
                        <div class="kpi-icon purple"><i class="fa fa-repeat"></i></div>
                    </div>
                    <div class="kpi-value">{{ $returningRate }}%</div>
                    <div class="kpi-badge {{ $returningRateDelta >= 0 ? 'up' : 'down' }}">
                        <i class="fa fa-arrow-{{ $returningRateDelta >= 0 ? 'up' : 'down' }}"></i> {{ abs($returningRateDelta) }}% vs last month
                    </div>
                </div>

                <div class="kpi-tile">
                    <div class="kpi-top">
                        <span class="kpi-label">Avg. LTV</span>
                        <div class="kpi-icon amber"><i class="fa fa-dollar"></i></div>
                    </div>
                    <div class="kpi-value">₹{{ number_format($avgLtv) }}</div>
                    <div class="kpi-badge neutral"><i class="fa fa-minus"></i> across all customers</div>
                </div>

                <div class="kpi-tile">
                    <div class="kpi-top">
                        <span class="kpi-label">Churn Rate</span>
                        <div class="kpi-icon red"><i class="fa fa-user-times"></i></div>
                    </div>
                    <div class="kpi-value">{{ $churnRate }}%</div>
                    <div class="kpi-badge neutral"><i class="fa fa-info-circle"></i> no order in 90+ days</div>
                </div>

            </div>

            <!-- Row 1: Acquisition trend + New vs Returning donut -->
            <div class="grid-3-1">

                <div class="sc">
                    <div class="sc-head">
                        <h5>Customer Acquisition Over Time</h5>
                        <span class="sc-sub">{{ $start->format('d M') }} – {{ $end->format('d M Y') }}</span>
                    </div>
                    <div class="sc-body">
                        <div class="chart-lg">
                            <canvas id="acquisitionChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="sc">
                    <div class="sc-head">
                        <h5>New vs Returning</h5>
                        <span class="sc-sub">This period</span>
                    </div>
                    <div class="sc-body">
                        <div class="chart-sm">
                            <canvas id="newVsReturningChart"></canvas>
                        </div>
                        <div style="margin-top:16px">
                            <div class="info-row">
                                <span style="display:flex;align-items:center;gap:6px;font-size:13px;font-weight:500">
                                    <span style="width:10px;height:10px;border-radius:50%;background:var(--accent);display:inline-block"></span>
                                    New Customers
                                </span>
                                <span style="font-weight:700;color:var(--accent)">{{ $newPct }}% · {{ number_format($newOrderersCount) }}</span>
                            </div>
                            <div class="info-row">
                                <span style="display:flex;align-items:center;gap:6px;font-size:13px;font-weight:500">
                                    <span style="width:10px;height:10px;border-radius:50%;background:var(--green);display:inline-block"></span>
                                    Returning
                                </span>
                                <span style="font-weight:700;color:var(--green)">{{ $returningPct }}% · {{ number_format($returningOrderersCount) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Row 2: Segments + Funnel + Device (Device stays static) -->
            <div class="grid-3">

                <!-- Customer Segments -->
                <div class="sc">
                    <div class="sc-head">
                        <h5>Customer Segments</h5>
                        <span class="sc-sub">RFM-based</span>
                    </div>
                    <div class="sc-body">
                        <div class="chart-md">
                            <canvas id="segmentChart"></canvas>
                        </div>
                        <div style="margin-top:14px;display:flex;flex-direction:column;gap:8px">
                            <div style="display:flex;align-items:center;justify-content:space-between;font-size:12.5px">
                                <span style="display:flex;align-items:center;gap:6px"><span style="width:10px;height:10px;border-radius:2px;background:#b8860b;display:inline-block"></span> VIP</span>
                                <span style="font-weight:700;color:var(--text-primary)">{{ number_format($segments['vip']) }} &nbsp;<span style="color:var(--text-hint);font-weight:400">({{ $segmentPcts['vip'] }}%)</span></span>
                            </div>
                            <div style="display:flex;align-items:center;justify-content:space-between;font-size:12.5px">
                                <span style="display:flex;align-items:center;gap:6px"><span style="width:10px;height:10px;border-radius:2px;background:var(--green);display:inline-block"></span> Loyal</span>
                                <span style="font-weight:700">{{ number_format($segments['loyal']) }} &nbsp;<span style="color:var(--text-hint);font-weight:400">({{ $segmentPcts['loyal'] }}%)</span></span>
                            </div>
                            <div style="display:flex;align-items:center;justify-content:space-between;font-size:12.5px">
                                <span style="display:flex;align-items:center;gap:6px"><span style="width:10px;height:10px;border-radius:2px;background:var(--blue);display:inline-block"></span> New</span>
                                <span style="font-weight:700">{{ number_format($segments['new']) }} &nbsp;<span style="color:var(--text-hint);font-weight:400">({{ $segmentPcts['new'] }}%)</span></span>
                            </div>
                            <div style="display:flex;align-items:center;justify-content:space-between;font-size:12.5px">
                                <span style="display:flex;align-items:center;gap:6px"><span style="width:10px;height:10px;border-radius:2px;background:var(--purple);display:inline-block"></span> Promising</span>
                                <span style="font-weight:700">{{ number_format($segments['promising']) }} &nbsp;<span style="color:var(--text-hint);font-weight:400">({{ $segmentPcts['promising'] }}%)</span></span>
                            </div>
                            <div style="display:flex;align-items:center;justify-content:space-between;font-size:12.5px">
                                <span style="display:flex;align-items:center;gap:6px"><span style="width:10px;height:10px;border-radius:2px;background:var(--red);display:inline-block"></span> At Risk</span>
                                <span style="font-weight:700">{{ number_format($segments['at_risk']) }} &nbsp;<span style="color:var(--text-hint);font-weight:400">({{ $segmentPcts['at_risk'] }}%)</span></span>
                            </div>
                            <div style="display:flex;align-items:center;justify-content:space-between;font-size:12.5px">
                                <span style="display:flex;align-items:center;gap:6px"><span style="width:10px;height:10px;border-radius:2px;background:var(--text-hint);display:inline-block"></span> Dormant</span>
                                <span style="font-weight:700">{{ number_format($segments['dormant']) }} &nbsp;<span style="color:var(--text-hint);font-weight:400">({{ $segmentPcts['dormant'] }}%)</span></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Acquisition Funnel (4 real steps) -->
                <div class="sc">
                    <div class="sc-head">
                        <h5>Acquisition Funnel</h5>
                        <span class="sc-sub">All-time</span>
                    </div>
                    <div class="sc-body">
                        @php
                            $funnelColors = ['#4a5bbf', 'var(--purple)', 'var(--green)', 'var(--green)'];
                        @endphp
                        @foreach($funnel as $i => $step)
                            <div class="funnel-row" style="{{ $loop->last ? 'margin-bottom:0' : '' }}">
                                <span class="funnel-label">{{ $step['label'] }}</span>
                                <div class="funnel-bar-wrap">
                                    <div class="funnel-bar" style="width:{{ $step['pct'] }}%;background:{{ $funnelColors[$i] }}{{ $i === 3 ? ';opacity:.7' : '' }}">{{ $step['pct'] }}%</div>
                                </div>
                                <span class="funnel-count">{{ number_format($step['count']) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Device & Platform — STATIC (no tracking data available) -->
                <div class="sc">
                    <div class="sc-head">
                        <h5>Device & Platform</h5>
                        <span class="sc-sub">Sessions this month</span>
                    </div>
                    <div class="sc-body">
                        <div class="chart-sm" style="height:150px">
                            <canvas id="deviceChart"></canvas>
                        </div>
                        <div style="margin-top:16px">
                            <div class="device-row">
                                <div class="device-icon-wrap" style="background:var(--blue-bg);color:var(--blue)"><i class="fa fa-desktop"></i></div>
                                <div style="flex:1">
                                    <div style="display:flex;justify-content:space-between;font-size:13px;font-weight:500">
                                        <span>Desktop</span><span style="font-weight:700">52%</span>
                                    </div>
                                    <div class="prog-bar"><div class="prog-fill" style="width:52%;background:var(--blue)"></div></div>
                                </div>
                            </div>
                            <div class="device-row">
                                <div class="device-icon-wrap" style="background:var(--green-bg);color:var(--green)"><i class="fa fa-mobile"></i></div>
                                <div style="flex:1">
                                    <div style="display:flex;justify-content:space-between;font-size:13px;font-weight:500">
                                        <span>Mobile</span><span style="font-weight:700">38%</span>
                                    </div>
                                    <div class="prog-bar"><div class="prog-fill" style="width:38%;background:var(--green)"></div></div>
                                </div>
                            </div>
                            <div class="device-row">
                                <div class="device-icon-wrap" style="background:var(--purple-bg);color:var(--purple)"><i class="fa fa-tablet"></i></div>
                                <div style="flex:1">
                                    <div style="display:flex;justify-content:space-between;font-size:13px;font-weight:500">
                                        <span>Tablet</span><span style="font-weight:700">10%</span>
                                    </div>
                                    <div class="prog-bar"><div class="prog-fill" style="width:10%;background:var(--purple)"></div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Row 3: Retention Cohort -->
            <div class="sc" style="margin-bottom:20px">
                <div class="sc-head">
                    <h5>Retention Cohort Analysis</h5>
                    <span class="sc-sub">% of customers who returned each month after first purchase</span>
                </div>
                <div class="sc-body" style="overflow-x:auto;padding:0">
                    <div style="min-width:640px;padding:16px 20px">
                        <div class="cohort-grid">
                            <div class="cohort-cell header label">Cohort</div>
                            @for($m = 0; $m <= 5; $m++)
                                <div class="cohort-cell header">M+{{ $m }}</div>
                            @endfor

                            @foreach($cohorts as $row)
                                <div class="cohort-cell label">{{ $row['label'] }}</div>
                                @foreach($row['cells'] as $val)
                                    @php
                                        $heatClass = match(true) {
                                            $val === null => 'heat-1',
                                            $val >= 40 => 'heat-5',
                                            $val >= 35 => 'heat-4',
                                            $val >= 25 => 'heat-3',
                                            default => 'heat-2',
                                        };
                                    @endphp
                                    <div class="cohort-cell {{ $heatClass }}">{{ $val === null ? '—' : $val . '%' }}</div>
                                @endforeach
                            @endforeach
                        </div>
                        <div style="margin-top:14px;display:flex;gap:12px;align-items:center;font-size:12px;color:var(--text-hint)">
                            <span>Retention intensity:</span>
                            <span style="display:flex;align-items:center;gap:4px"><span style="width:14px;height:14px;background:#e3f1ec;border-radius:3px;display:inline-block"></span> High (40%+)</span>
                            <span style="display:flex;align-items:center;gap:4px"><span style="width:14px;height:14px;background:#f5fbf8;border-radius:3px;display:inline-block"></span> Mid (25–40%)</span>
                            <span style="display:flex;align-items:center;gap:4px"><span style="width:14px;height:14px;background:var(--surface);border:1px solid var(--border);border-radius:3px;display:inline-block"></span> Low (&lt;25%)</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Row 4: Top Customers + Location -->
            <div class="grid-3-1">

                <div class="sc">
                    <div class="sc-head">
                        <h5>Top Customers by Lifetime Value</h5>
                        <a href="#" style="font-size:12px;color:var(--accent);text-decoration:none;font-weight:500">View All →</a>
                    </div>
                    <div style="overflow-x:auto">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Customer</th>
                                    <th>Segment</th>
                                    <th>Orders</th>
                                    <th>Total Spent</th>
                                    <th>Avg. Order</th>
                                    <th>Last Order</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $rankClasses = ['gold', 'silver', 'bronze'];
                                @endphp
                                @forelse($topCustomersTable as $c)
                                    <tr>
                                        <td><span class="rank {{ $rankClasses[$c['rank'] - 1] ?? '' }}">{{ $c['rank'] }}</span></td>
                                        <td>
                                            <div style="display:flex;align-items:center;gap:9px">
                                                <div class="cust-av" style="background:var(--accent-light);color:var(--accent)">{{ $c['initials'] }}</div>
                                                <div>
                                                    <div class="cust-name">{{ $c['name'] }}</div>
                                                    <div class="cust-email">{{ $c['email'] }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="seg-pill {{ $c['segment']['class'] }}">{{ $c['segment']['label'] }}</span></td>
                                        <td style="font-weight:600">{{ $c['orders'] }}</td>
                                        <td style="font-weight:700;color:var(--text-primary)">₹{{ number_format($c['total_spent']) }}</td>
                                        <td style="color:var(--text-secondary)">₹{{ number_format($c['avg_order']) }}</td>
                                        <td style="color:var(--text-hint);font-size:12px">{{ $c['last_order'] }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="7" style="text-align:center;color:var(--text-hint);padding:24px 0">No customer order data yet.</td></tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3">Top {{ $topCustomersTable->count() }} Total</td>
                                    <td style="color:var(--text-secondary)">{{ number_format($top6Orders) }} orders</td>
                                    <td style="color:var(--accent)">₹{{ number_format($top6Revenue) }}</td>
                                    <td colspan="2"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="sc">
                    <div class="sc-head">
                        <h5>Customers by Location</h5>
                        <span class="sc-sub">Top cities (default address)</span>
                    </div>
                    <div class="sc-body">
                        @forelse($topLocations as $loc)
                            <div class="loc-row">
                                <span class="loc-flag">🏙️</span>
                                <span class="loc-name">{{ $loc->city_name }}</span>
                                <div class="loc-bar-wrap"><div class="loc-bar"><div class="loc-fill" style="width:{{ $maxLocationCount > 0 ? round(($loc->cnt / $maxLocationCount) * 100) : 0 }}%"></div></div></div>
                                <span class="loc-count">{{ number_format($loc->cnt) }}</span>
                                <span class="loc-pct">{{ round(($loc->cnt / $locationTotal) * 100, 1) }}%</span>
                            </div>
                        @empty
                            <div style="text-align:center;color:var(--text-hint);padding:16px 0">No address data yet.</div>
                        @endforelse
                        @if($othersLocationCount > 0)
                            <div class="loc-row">
                                <span class="loc-flag">🗺️</span>
                                <span class="loc-name">Others</span>
                                <div class="loc-bar-wrap"><div class="loc-bar"><div class="loc-fill" style="width:{{ round(($othersLocationCount / $maxLocationCount) * 100) }}%;background:var(--text-hint)"></div></div></div>
                                <span class="loc-count">{{ number_format($othersLocationCount) }}</span>
                                <span class="loc-pct">{{ round(($othersLocationCount / $locationTotal) * 100, 1) }}%</span>
                            </div>
                        @endif
                    </div>
                </div>

            </div>

            <!-- Row 5: Summary metrics -->
            <div class="grid-2">

                <div class="sc">
                    <div class="sc-head"><h5>Customer Health Metrics</h5><span class="sc-sub">{{ now()->format('M Y') }}</span></div>
                    <div class="sc-body">
                        <div class="info-row">
                            <span class="info-label">Total Registered</span>
                            <span class="info-value">{{ number_format($totalCustomers) }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Active This Month</span>
                            <span class="info-value">{{ number_format($activeThisMonth) }} <span style="font-size:11.5px;color:var(--text-hint)">({{ $activePct }}%)</span></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">New This Month</span>
                            <span class="info-value" style="color:var(--green)">+ {{ number_format($newThis) }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Churn Rate</span>
                            <span class="info-value" style="color:var(--red)">{{ $churnRate }}%</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Avg. Orders / Customer</span>
                            <span class="info-value">{{ $avgOrdersPerCustomer }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Avg. Lifetime Value</span>
                            <span class="info-value">₹{{ number_format($avgLtv) }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Avg. Days Between Orders</span>
                            <span class="info-value">{{ $avgDaysBetweenOrders }} days</span>
                        </div>
                        {{-- NPS — STATIC (no feedback/survey table exists) --}}
                        <div class="info-row">
                            <span class="info-label">Net Promoter Score</span>
                            <span class="info-value" style="color:var(--green)">+42 <span style="font-size:11.5px;color:var(--text-hint)">(Good)</span></span>
                        </div>
                        {{-- Session Duration — STATIC (no analytics tracking exists) --}}
                        <div class="info-row">
                            <span class="info-label">Avg. Session Duration</span>
                            <span class="info-value">4m 38s</span>
                        </div>
                        {{-- Cart Abandonment — STATIC (no cart-timestamp tracking confirmed) --}}
                        <div class="info-row">
                            <span class="info-label">Cart Abandonment Rate</span>
                            <span class="info-value" style="color:var(--amber)">28.4%</span>
                        </div>
                    </div>
                </div>

                <div class="sc">
                    <div class="sc-head"><h5>Churn vs Retention Trend</h5><span class="sc-sub">Last 6 months</span></div>
                    <div class="sc-body">
                        <div class="chart-lg" style="height:220px">
                            <canvas id="churnChart"></canvas>
                        </div>
                        <div style="display:flex;justify-content:center;gap:20px;margin-top:12px;font-size:12px">
                            <span style="display:flex;align-items:center;gap:5px;color:var(--text-secondary)"><span style="width:10px;height:10px;border-radius:50%;background:var(--green);display:inline-block"></span> Retained</span>
                            <span style="display:flex;align-items:center;gap:5px;color:var(--text-secondary)"><span style="width:10px;height:10px;border-radius:50%;background:var(--red);display:inline-block"></span> Churned</span>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

@include('admin.footer')

<script>
(function(){
    const ctx = document.getElementById('acquisitionChart');
    if(!ctx) return;
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($acqLabels),
            datasets: [
                {
                    label: 'New Customers',
                    data: @json($acqNewSeries),
                    fill: true, tension: 0.45,
                    borderColor: '#303d89', borderWidth: 2.5,
                    pointRadius: 3, pointHoverRadius: 6,
                    pointBackgroundColor: '#303d89',
                    backgroundColor: (ctx) => {
                        const chart = ctx.chart;
                        const { ctx: c, chartArea } = chart;
                        if (!chartArea) return 'transparent';
                        const g = c.createLinearGradient(0, chartArea.top, 0, chartArea.bottom);
                        g.addColorStop(0, 'rgba(48,61,137,.18)');
                        g.addColorStop(1, 'rgba(48,61,137,0)');
                        return g;
                    }
                },
                {
                    label: 'Returning',
                    data: @json($acqReturningSeries),
                    fill: false, tension: 0.45,
                    borderColor: '#007a5e', borderWidth: 2,
                    pointRadius: 2, pointHoverRadius: 5,
                    borderDash: [5,3]
                }
            ]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { font: { size: 11 }, boxWidth: 10, padding: 14 } },
                tooltip: { backgroundColor: '#202223', cornerRadius: 8, padding: 10 }
            },
            scales: {
                x: { grid: { display: false }, ticks: { color: '#8c9196', font: { size: 11 } }, border: { display: false } },
                y: { grid: { color: '#f1f2f4' }, border: { display: false }, ticks: { color: '#8c9196', font: { size: 11 } } }
            }
        }
    });
})();

(function(){
    const ctx = document.getElementById('newVsReturningChart');
    if(!ctx) return;
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['New','Returning'],
            datasets: [{ data: [{{ $newPct }}, {{ $returningPct }}], backgroundColor: ['#303d89','#007a5e'], borderWidth: 2, borderColor: '#fff', hoverOffset: 6 }]
        },
        options: { responsive: true, maintainAspectRatio: false, cutout: '70%', plugins: { legend: { display: false } } }
    });
})();

(function(){
    const ctx = document.getElementById('segmentChart');
    if(!ctx) return;
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['VIP','Loyal','New','Promising','At Risk','Dormant'],
            datasets: [{
                data: [{{ $segmentPcts['vip'] }}, {{ $segmentPcts['loyal'] }}, {{ $segmentPcts['new'] }}, {{ $segmentPcts['promising'] }}, {{ $segmentPcts['at_risk'] }}, {{ $segmentPcts['dormant'] }}],
                backgroundColor: ['#b8860b','#007a5e','#0069d9','#6d28d9','#b22222','#8c9196'], borderWidth: 2, borderColor: '#fff', hoverOffset: 5
            }]
        },
        options: { responsive: true, maintainAspectRatio: false, cutout: '65%', plugins: { legend: { display: false } } }
    });
})();

{{-- Device chart stays static — no real data --}}
(function(){
    const ctx = document.getElementById('deviceChart');
    if(!ctx) return;
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Desktop','Mobile','Tablet'],
            datasets: [{ data: [52,38,10], backgroundColor: ['#0069d9','#007a5e','#6d28d9'], borderWidth: 2, borderColor: '#fff', hoverOffset: 5 }]
        },
        options: { responsive: true, maintainAspectRatio: false, cutout: '68%', plugins: { legend: { display: false } } }
    });
})();

(function(){
    const ctx = document.getElementById('churnChart');
    if(!ctx) return;
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($churnTrendLabels),
            datasets: [
                { label: 'Retained', data: @json($retainedSeries), backgroundColor: '#007a5e', borderRadius: 5, borderSkipped: false },
                { label: 'Churned',  data: @json($churnedSeries),  backgroundColor: '#fce8e8', borderRadius: 5, borderSkipped: false }
            ]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: { backgroundColor: '#202223', cornerRadius: 8 }
            },
            scales: {
                x: { grid: { display: false }, ticks: { color: '#8c9196', font: { size: 11 } }, border: { display: false } },
                y: { grid: { color: '#f1f2f4' }, border: { display: false }, ticks: { color: '#8c9196', font: { size: 11 }, callback: v => v >= 1000 ? (v/1000).toFixed(0)+'k' : v } }
            }
        }
    });
})();

document.querySelectorAll('.date-bar .date-preset').forEach(el => {
    el.addEventListener('click', function(){
        document.getElementById('rangeInput').value = this.dataset.range;
        document.getElementById('rangeForm').submit();
    });
});

document.getElementById('printReportBtn')?.addEventListener('click', function(e){
    e.preventDefault();
    window.print();
});
</script>