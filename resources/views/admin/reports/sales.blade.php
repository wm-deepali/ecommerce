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

    .report-page { background: var(--bg); padding: 24px 28px; min-height: 100vh; font-family: var(--font); color: var(--text-primary); }
    .report-page * { box-sizing: border-box; }

    .page-header { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 20px; }
    .page-header h1 { font-size: 20px; font-weight: 650; color: var(--text-primary); margin: 0; }
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

    .date-bar {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius-md); padding: 14px 20px;
        margin-bottom: 20px; box-shadow: var(--shadow-card);
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 12px;
    }
    .date-bar-left { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
    .date-preset { display: inline-flex; align-items: center; padding: 6px 14px; border: 1px solid var(--border); border-radius: 20px; font-size: 12.5px; font-weight: 500; color: var(--text-secondary); cursor: pointer; transition: all .15s; background: var(--surface); text-decoration: none; }
    .date-preset:hover { border-color: var(--accent); color: var(--accent); background: var(--accent-light); }
    .date-preset.active { border-color: var(--accent); color: var(--accent); background: var(--accent-light); font-weight: 600; }
    .date-separator { color: var(--text-hint); font-size: 13px; }
    .date-input { height: 34px; border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 0 10px; font-size: 13px; color: var(--text-primary); background: var(--surface); outline: none; font-family: var(--font); }
    .date-input:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(48,61,137,.12); }
    .btn-apply { height: 34px; display: inline-flex; align-items: center; gap: 5px; background: var(--accent); color: #fff; border: none; border-radius: var(--radius-sm); padding: 0 14px; font-size: 13px; font-weight: 600; cursor: pointer; font-family: var(--font); }
    .btn-apply:hover { background: #252f70; }

    .kpi-strip { display: grid; grid-template-columns: repeat(5,1fr); gap: 14px; margin-bottom: 20px; }
    @media(max-width:1100px) { .kpi-strip { grid-template-columns: repeat(3,1fr); } }
    @media(max-width:700px)  { .kpi-strip { grid-template-columns: repeat(2,1fr); } }

    .kpi-tile { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 18px 18px 14px; box-shadow: var(--shadow-card); }
    .kpi-tile-top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px; }
    .kpi-tile-label { font-size: 11.5px; font-weight: 600; color: var(--text-hint); text-transform: uppercase; letter-spacing: .04em; }
    .kpi-tile-icon { width: 34px; height: 34px; border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center; font-size: 14px; flex-shrink: 0; }
    .kpi-tile-icon.green  { background: var(--green-bg);  color: var(--green); }
    .kpi-tile-icon.blue   { background: var(--blue-bg);   color: var(--blue); }
    .kpi-tile-icon.amber  { background: var(--amber-bg);  color: var(--amber); }
    .kpi-tile-icon.purple { background: var(--purple-bg); color: var(--purple); }
    .kpi-tile-icon.red    { background: var(--red-bg);    color: var(--red); }
    .kpi-value { font-size: 22px; font-weight: 750; color: var(--text-primary); line-height: 1; }
    .kpi-badge { display: inline-flex; align-items: center; gap: 3px; font-size: 11px; font-weight: 600; padding: 2px 7px; border-radius: 20px; margin-top: 7px; }
    .kpi-badge.up   { background: var(--green-bg); color: var(--green); }
    .kpi-badge.down { background: var(--red-bg);   color: var(--red); }
    .kpi-badge.neutral { background: var(--bg); color: var(--text-hint); }

    .charts-2col { display: grid; grid-template-columns: 2fr 1fr; gap: 16px; margin-bottom: 20px; }
    @media(max-width:900px) { .charts-2col { grid-template-columns: 1fr; } }

    .charts-3col { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; margin-bottom: 20px; }
    @media(max-width:900px) { .charts-3col { grid-template-columns: 1fr; } }

    .sc { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-md); box-shadow: var(--shadow-card); overflow: hidden; }
    .sc-head { padding: 14px 20px; border-bottom: 1px solid var(--border); background: #fafafa; display: flex; align-items: center; justify-content: space-between; }
    .sc-head h5 { font-size: 13px; font-weight: 650; color: var(--text-primary); margin: 0; }
    .sc-body { padding: 20px; }
    .sc-head-sub { font-size: 12px; color: var(--text-hint); }

    .chart-wrap-lg { position: relative; height: 260px; }
    .chart-wrap-md { position: relative; height: 220px; }
    .chart-wrap-sm { position: relative; height: 180px; }

    .sum-table { width: 100%; border-collapse: collapse; font-size: 13px; }
    .sum-table thead th { font-size: 11px; font-weight: 600; letter-spacing: .06em; text-transform: uppercase; color: var(--text-hint); padding: 9px 14px; border-bottom: 1px solid var(--border); background: #fafafa; text-align: left; white-space: nowrap; }
    .sum-table tbody tr { border-bottom: 1px solid var(--border); transition: background .1s; }
    .sum-table tbody tr:last-child { border-bottom: none; }
    .sum-table tbody tr:hover { background: #fafbfc; }
    .sum-table tbody td { padding: 12px 14px; vertical-align: middle; color: var(--text-primary); }
    .sum-table tfoot td { padding: 12px 14px; border-top: 2px solid var(--border); font-weight: 700; font-size: 13px; background: #fafafa; }

    .rank-num { display: inline-flex; align-items: center; justify-content: center; width: 24px; height: 24px; border-radius: 50%; font-size: 11px; font-weight: 700; background: var(--bg); color: var(--text-secondary); flex-shrink: 0; }
    .rank-num.gold   { background: #fff8e1; color: #b8860b; }
    .rank-num.silver { background: #f5f5f5; color: #707070; }
    .rank-num.bronze { background: #fdf0e8; color: #9c5400; }

    .prod-thumb { width: 40px; height: 40px; border-radius: var(--radius-sm); object-fit: cover; border: 1px solid var(--border); flex-shrink: 0; }
    .prod-name-sm { font-size: 13px; font-weight: 600; color: var(--text-primary); }
    .prod-cat-sm  { font-size: 11.5px; color: var(--text-hint); margin-top: 1px; }

    .prog-bar { height: 5px; border-radius: 10px; background: var(--bg); overflow: hidden; margin-top: 5px; width: 100px; }
    .prog-fill { height: 100%; border-radius: 10px; }

    .rev-cell { font-size: 13.5px; font-weight: 700; color: var(--text-primary); }
    .units-cell { font-size: 13px; color: var(--text-secondary); font-weight: 600; }

    .growth { display: inline-flex; align-items: center; gap: 3px; font-size: 11.5px; font-weight: 600; padding: 2px 7px; border-radius: 20px; }
    .growth.up   { background: var(--green-bg); color: var(--green); }
    .growth.down { background: var(--red-bg);   color: var(--red); }
    .growth.neutral { background: var(--bg); color: var(--text-hint); }

    .cat-row { display: flex; align-items: center; gap: 10px; padding: 10px 0; border-bottom: 1px solid var(--bg); }
    .cat-row:first-child { padding-top: 0; }
    .cat-row:last-child  { border-bottom: none; padding-bottom: 0; }
    .cat-color-dot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }
    .cat-row-name  { flex: 1; font-size: 13px; font-weight: 500; color: var(--text-primary); }
    .cat-row-rev   { font-size: 13px; font-weight: 700; color: var(--text-primary); }
    .cat-row-pct   { font-size: 11.5px; color: var(--text-hint); }

    .info-row { display: flex; justify-content: space-between; align-items: center; padding: 9px 0; border-bottom: 1px solid var(--bg); font-size: 13px; }
    .info-row:first-child { padding-top: 0; }
    .info-row:last-child  { border-bottom: none; padding-bottom: 0; }
    .info-label { color: var(--text-hint); font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: .03em; }
    .info-value { font-weight: 600; color: var(--text-primary); }

    .channel-pill { display: inline-flex; align-items: center; gap: 5px; font-size: 12px; font-weight: 600; padding: 3px 10px; border-radius: 20px; }
    .ch-online  { background: var(--accent-light); color: var(--accent); }
    .ch-mobile  { background: var(--purple-bg);    color: var(--purple); }
    .ch-offline { background: var(--amber-bg);     color: var(--amber); }

    .trend-dot { display: inline-block; width: 8px; height: 8px; border-radius: 50%; margin-right: 4px; }

    .compare-strip { display: grid; grid-template-columns: 1fr 1fr; gap: 1px; background: var(--border); border-radius: var(--radius-sm); overflow: hidden; margin-bottom: 14px; }
    .compare-cell { background: var(--surface); padding: 12px 16px; }
    .compare-cell-label { font-size: 11px; font-weight: 600; color: var(--text-hint); text-transform: uppercase; letter-spacing: .04em; }
    .compare-cell-value { font-size: 20px; font-weight: 750; color: var(--text-primary); margin-top: 3px; }
    .compare-cell-sub   { font-size: 11.5px; color: var(--text-hint); margin-top: 2px; }

    @media(max-width:768px) { .report-page { padding: 16px; } }
    </style>

    <div class="app-content content container-fluid">
        <div class="report-page">

            {{-- ── Page Header ── --}}
            <div class="page-header">
                <div>
                    <h1>Sales Report</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        Sales Report
                    </div>
                </div>
                <div style="display:flex;gap:8px;flex-wrap:wrap">
                    <a href="javascript:window.print()" class="btn-secondary-dash"><i class="fa fa-print"></i> Print</a>
                    <a href="{{ route('admin.reports.sales.export', ['format'=>'excel', 'start_date'=>$start->toDateString(), 'end_date'=>$end->toDateString()]) }}" class="btn-secondary-dash">
                        <i class="fa fa-file-excel-o"></i> Export Excel
                    </a>
                    <a href="{{ route('admin.reports.sales.export', ['format'=>'pdf', 'start_date'=>$start->toDateString(), 'end_date'=>$end->toDateString()]) }}" class="btn-primary-dash">
                        <i class="fa fa-download"></i> Export PDF
                    </a>
                </div>
            </div>

            {{-- ── Date Range Bar ── --}}
            <form method="GET" action="{{ route('admin.reports.sales') }}" id="dateForm">
                <div class="date-bar">
                    <div class="date-bar-left">
                        <span style="font-size:12.5px;font-weight:600;color:var(--text-secondary);margin-right:4px">Period:</span>
                        @php
                            $presets = [
                                'today'      => ['label' => 'Today',      'start' => now()->toDateString(),                          'end' => now()->toDateString()],
                                'yesterday'  => ['label' => 'Yesterday',  'start' => now()->subDay()->toDateString(),                 'end' => now()->subDay()->toDateString()],
                                'this_month' => ['label' => 'This Month', 'start' => now()->startOfMonth()->toDateString(),           'end' => now()->toDateString()],
                                'last_month' => ['label' => 'Last Month', 'start' => now()->subMonth()->startOfMonth()->toDateString(),'end' => now()->subMonth()->endOfMonth()->toDateString()],
                                'this_year'  => ['label' => 'This Year',  'start' => now()->startOfYear()->toDateString(),            'end' => now()->toDateString()],
                            ];
                        @endphp
                        @foreach($presets as $key => $preset)
                            <a href="{{ route('admin.reports.sales', ['start_date' => $preset['start'], 'end_date' => $preset['end']]) }}"
                               class="date-preset {{ $activePreset === $key ? 'active' : '' }}">
                                {{ $preset['label'] }}
                            </a>
                        @endforeach
                        <span class="date-preset {{ $activePreset === 'custom' ? 'active' : '' }}" id="customToggle">Custom</span>
                    </div>
                    <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap" id="customInputs" style="{{ $activePreset !== 'custom' ? 'display:none' : '' }}">
                        <input type="date" name="start_date" class="date-input" value="{{ $start->toDateString() }}">
                        <span style="color:var(--text-hint);font-size:13px">→</span>
                        <input type="date" name="end_date" class="date-input" value="{{ $end->toDateString() }}">
                        <button type="submit" class="btn-apply"><i class="fa fa-check"></i> Apply</button>
                    </div>
                </div>
            </form>

            {{-- ── KPI Strip ── --}}
            <div class="kpi-strip">

                {{-- Revenue --}}
                <div class="kpi-tile">
                    <div class="kpi-tile-top">
                        <span class="kpi-tile-label">Total Revenue</span>
                        <div class="kpi-tile-icon green"><i class="fa fa-inr"></i></div>
                    </div>
                    <div class="kpi-value">₹{{ number_format($revenueThis) }}</div>
                    @if($revenueGrowth > 0)
                        <div class="kpi-badge up"><i class="fa fa-arrow-up"></i> {{ $revenueGrowth }}% vs prev period</div>
                    @elseif($revenueGrowth < 0)
                        <div class="kpi-badge down"><i class="fa fa-arrow-down"></i> {{ abs($revenueGrowth) }}% vs prev period</div>
                    @else
                        <div class="kpi-badge neutral"><i class="fa fa-minus"></i> No change</div>
                    @endif
                </div>

                {{-- Orders --}}
                <div class="kpi-tile">
                    <div class="kpi-tile-top">
                        <span class="kpi-tile-label">Total Orders</span>
                        <div class="kpi-tile-icon blue"><i class="fa fa-shopping-bag"></i></div>
                    </div>
                    <div class="kpi-value">{{ number_format($ordersThis) }}</div>
                    @if($orderGrowth > 0)
                        <div class="kpi-badge up"><i class="fa fa-arrow-up"></i> {{ $orderGrowth }}% vs prev period</div>
                    @elseif($orderGrowth < 0)
                        <div class="kpi-badge down"><i class="fa fa-arrow-down"></i> {{ abs($orderGrowth) }}% vs prev period</div>
                    @else
                        <div class="kpi-badge neutral"><i class="fa fa-minus"></i> No change</div>
                    @endif
                </div>

                {{-- AOV --}}
                <div class="kpi-tile">
                    <div class="kpi-tile-top">
                        <span class="kpi-tile-label">Avg. Order Value</span>
                        <div class="kpi-tile-icon purple"><i class="fa fa-bar-chart"></i></div>
                    </div>
                    <div class="kpi-value">₹{{ number_format($aovThis) }}</div>
                    @if($aovGrowth > 0)
                        <div class="kpi-badge up"><i class="fa fa-arrow-up"></i> {{ $aovGrowth }}% vs prev period</div>
                    @elseif($aovGrowth < 0)
                        <div class="kpi-badge down"><i class="fa fa-arrow-down"></i> {{ abs($aovGrowth) }}% vs prev period</div>
                    @else
                        <div class="kpi-badge neutral"><i class="fa fa-minus"></i> No change</div>
                    @endif
                </div>

                {{-- Units --}}
                <div class="kpi-tile">
                    <div class="kpi-tile-top">
                        <span class="kpi-tile-label">Units Sold</span>
                        <div class="kpi-tile-icon amber"><i class="fa fa-cube"></i></div>
                    </div>
                    <div class="kpi-value">{{ number_format($unitsThis) }}</div>
                    @if($unitsGrowth > 0)
                        <div class="kpi-badge up"><i class="fa fa-arrow-up"></i> {{ $unitsGrowth }}% vs prev period</div>
                    @elseif($unitsGrowth < 0)
                        <div class="kpi-badge down"><i class="fa fa-arrow-down"></i> {{ abs($unitsGrowth) }}% vs prev period</div>
                    @else
                        <div class="kpi-badge neutral"><i class="fa fa-minus"></i> No change</div>
                    @endif
                </div>

                {{-- Return Rate --}}
                <div class="kpi-tile">
                    <div class="kpi-tile-top">
                        <span class="kpi-tile-label">Return Rate</span>
                        <div class="kpi-tile-icon red"><i class="fa fa-reply"></i></div>
                    </div>
                    <div class="kpi-value">{{ $returnRateThis }}%</div>
                    @if($returnRateImproved)
                        <div class="kpi-badge up"><i class="fa fa-arrow-down"></i> {{ abs($returnRateDelta) }}pp improved</div>
                    @elseif($returnRateWorsened)
                        <div class="kpi-badge down"><i class="fa fa-arrow-up"></i> {{ $returnRateDelta }}pp higher</div>
                    @else
                        <div class="kpi-badge neutral"><i class="fa fa-minus"></i> No change</div>
                    @endif
                </div>

            </div>

            {{-- ── Revenue Trend + Donut ── --}}
            <div class="charts-2col">

                <div class="sc">
                    <div class="sc-head">
                        <h5>Revenue Over Time</h5>
                        <span class="sc-head-sub">{{ ucfirst($granularity) }} · {{ $start->format('d M Y') }} – {{ $end->format('d M Y') }}</span>
                    </div>
                    <div class="sc-body">
                        @if($bestSalesDay)
                            <div style="font-size:12px;color:var(--text-hint);margin-bottom:10px">
                                📈 Best day: <strong style="color:var(--text-primary)">{{ \Carbon\Carbon::parse($bestSalesDay)->format('d M Y') }}</strong>
                                — ₹{{ number_format($bestSalesAmount) }}
                            </div>
                        @endif
                        <div class="chart-wrap-lg">
                            <canvas id="revenueChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="sc">
                    <div class="sc-head">
                        <h5>Revenue by Category</h5>
                        <span class="sc-head-sub">{{ $start->format('d M') }} – {{ $end->format('d M Y') }}</span>
                    </div>
                    <div class="sc-body">
                        @if($categoryBreakdown->isEmpty())
                            <div style="text-align:center;color:var(--text-hint);padding:40px 0">No category data for this period.</div>
                        @else
                            <div class="chart-wrap-md" style="height:180px">
                                <canvas id="categoryDonut"></canvas>
                            </div>
                            <div style="margin-top:14px">
                                @foreach($categoryBreakdown as $cat)
                                    <div class="cat-row">
                                        <div class="cat-color-dot" style="background:{{ $cat['color'] }}"></div>
                                        <span class="cat-row-name">{{ $cat['name'] }}</span>
                                        <span class="cat-row-pct">{{ $cat['pct'] }}%</span>
                                        <span class="cat-row-rev">₹{{ number_format($cat['revenue']) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

            </div>

            {{-- ── Orders / Customers / Channel ── --}}
            <div class="charts-2col">

                {{-- Orders vs Returns --}}
                <div class="sc">
                    <div class="sc-head">
                        <h5>Orders vs Returns</h5>
                        <span class="sc-head-sub">Last 7 days</span>
                    </div>
                    <div class="sc-body">
                        <div class="chart-wrap-sm">
                            <canvas id="ordersChart"></canvas>
                        </div>
                    </div>
                </div>

                {{-- New vs Returning Customers --}}
                <div class="sc">
                    <div class="sc-head">
                        <h5>Customer Breakdown</h5>
                        <span class="sc-head-sub">{{ $start->format('d M') }} – {{ $end->format('d M Y') }}</span>
                    </div>
                    <div class="sc-body">
                        @if($newCustomersCount + $returningCustomersCount === 0)
                            <div style="text-align:center;color:var(--text-hint);padding:40px 0">No customer data for this period.</div>
                        @else
                            <div class="chart-wrap-sm">
                                <canvas id="customerChart"></canvas>
                            </div>
                            <div style="display:flex;justify-content:center;gap:20px;margin-top:12px;font-size:12px">
                                <span style="display:flex;align-items:center;gap:5px;color:var(--text-secondary)">
                                    <span style="width:10px;height:10px;border-radius:50%;background:var(--accent);display:inline-block"></span>
                                    New ({{ $newCustomerPct }}%) · {{ number_format($newCustomersCount) }}
                                </span>
                                <span style="display:flex;align-items:center;gap:5px;color:var(--text-secondary)">
                                    <span style="width:10px;height:10px;border-radius:50%;background:var(--green);display:inline-block"></span>
                                    Returning ({{ $returningCustomerPct }}%) · {{ number_format($returningCustomersCount) }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>


            </div>

            {{-- ── Period Comparison + Daily Breakdown ── --}}
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px">

                <div class="sc">
                    <div class="sc-head">
                        <h5>Period Comparison</h5>
                        <span class="sc-head-sub">{{ $start->format('M Y') }} vs prev period</span>
                    </div>
                    <div class="sc-body">
                        <div class="compare-strip">
                            <div class="compare-cell">
                                <div class="compare-cell-label">This Period</div>
                                <div class="compare-cell-value">₹{{ number_format($revenueThis) }}</div>
                                <div class="compare-cell-sub">{{ $start->format('d M') }} – {{ $end->format('d M Y') }}</div>
                            </div>
                            <div class="compare-cell" style="background:#fafafa">
                                <div class="compare-cell-label">Last Period</div>
                                <div class="compare-cell-value" style="color:var(--text-secondary)">₹{{ number_format($revenuePrev) }}</div>
                                <div class="compare-cell-sub">Previous {{ $start->diffInDays($end) + 1 }} days</div>
                            </div>
                        </div>
                        <div class="chart-wrap-sm">
                            <canvas id="compareChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="sc">
                    <div class="sc-head">
                        <h5>Daily Revenue Breakdown</h5>
                        <span class="sc-head-sub">Last 7 days</span>
                    </div>
                    <div class="sc-body" style="padding:0">
                        <table class="sum-table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Orders</th>
                                    <th>Revenue</th>
                                    <th>vs Yesterday</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dailyBreakdown as $row)
                                    <tr>
                                        <td style="font-weight:500">{{ $row['date']->format('d M, D') }}</td>
                                        <td class="units-cell">{{ number_format($row['orders']) }}</td>
                                        <td class="rev-cell">₹{{ number_format($row['revenue']) }}</td>
                                        <td>
                                            @if($row['growth'] > 0)
                                                <span class="growth up"><i class="fa fa-arrow-up"></i> {{ $row['growth'] }}%</span>
                                            @elseif($row['growth'] < 0)
                                                <span class="growth down"><i class="fa fa-arrow-down"></i> {{ abs($row['growth']) }}%</span>
                                            @else
                                                <span class="growth neutral"><i class="fa fa-minus"></i> 0%</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>7-Day Total</td>
                                    <td style="color:var(--text-secondary)">{{ number_format($weekTotalOrders) }}</td>
                                    <td style="color:var(--accent)">₹{{ number_format($weekTotalRevenue) }}</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

            </div>

            {{-- ── Top Selling Products ── --}}
            <div class="sc" style="margin-bottom:20px">
                <div class="sc-head">
                    <h5>Top Selling Products</h5>
                    <div style="display:flex;gap:8px;align-items:center">
                        <span class="sc-head-sub">By revenue · {{ $start->format('d M') }} – {{ $end->format('d M Y') }}</span>
                        <a href="{{ route('admin.products.index') }}" style="font-size:12px;color:var(--accent);text-decoration:none;font-weight:500">View All →</a>
                    </div>
                </div>
                <div style="overflow-x:auto">
                    <table class="sum-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Units Sold</th>
                                <th>Revenue</th>
                                <th>Avg. Price</th>
                                <th>Share of Sales</th>
                                <th>Growth</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topProducts as $i => $product)
                                @php
                                    $rankClass = match($i) { 0 => 'gold', 1 => 'silver', 2 => 'bronze', default => '' };
                                    $barColors = ['var(--accent)', 'var(--green)', 'var(--purple)', 'var(--amber)', 'var(--red)'];
                                    $barColor  = $barColors[$i % count($barColors)];
                                @endphp
                                <tr>
                                    <td><span class="rank-num {{ $rankClass }}">{{ $i + 1 }}</span></td>
                                    <td>
                                        <div style="display:flex;align-items:center;gap:10px">
                                            <img src="{{ $product['thumb'] }}" class="prod-thumb" alt="{{ $product['name'] }}">
                                            <div>
                                                <div class="prod-name-sm">{{ $product['name'] }}</div>
                                                <div class="prod-cat-sm">{{ $product['sku'] }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span style="font-size:12.5px;color:var(--text-secondary)">{{ $product['category'] }}</span></td>
                                    <td><span class="units-cell">{{ number_format($product['units']) }}</span></td>
                                    <td><span class="rev-cell">₹{{ number_format($product['revenue']) }}</span></td>
                                    <td><span style="font-size:13px;color:var(--text-secondary)">₹{{ number_format($product['avg_price']) }}</span></td>
                                    <td>
                                        <div style="display:flex;align-items:center;gap:8px">
                                            <div class="prog-bar" style="width:120px">
                                                <div class="prog-fill" style="width:{{ $product['share'] }}%;background:{{ $barColor }}"></div>
                                            </div>
                                            <span style="font-size:12px;color:var(--text-hint)">{{ $product['share'] }}%</span>
                                        </div>
                                    </td>
                                    <td>
                                        @if($product['growth'] > 0)
                                            <span class="growth up"><i class="fa fa-arrow-up"></i> {{ $product['growth'] }}%</span>
                                        @elseif($product['growth'] < 0)
                                            <span class="growth down"><i class="fa fa-arrow-down"></i> {{ abs($product['growth']) }}%</span>
                                        @else
                                            <span class="growth neutral"><i class="fa fa-minus"></i> 0%</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" style="text-align:center;color:var(--text-hint);padding:32px">No product sales data for this period.</td>
                                </tr>
                            @endforelse
                        </tbody>
                        @if($topProducts->isNotEmpty())
                            <tfoot>
                                <tr>
                                    <td colspan="3">Top {{ $topProducts->count() }} Total</td>
                                    <td style="color:var(--text-secondary)">{{ number_format($top5UnitsTotal) }} units</td>
                                    <td style="color:var(--accent)">₹{{ number_format($top5RevenueTotal) }}</td>
                                    <td colspan="3"></td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>

            {{-- ── Payment Methods + Key Metrics ── --}}
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px">

                <div class="sc">
                    <div class="sc-head">
                        <h5>Revenue by Payment Method</h5>
                        <span class="sc-head-sub">{{ $start->format('d M') }} – {{ $end->format('d M Y') }}</span>
                    </div>
                    <div class="sc-body" style="padding:0">
                        <table class="sum-table">
                            <thead>
                                <tr>
                                    <th>Method</th>
                                    <th>Transactions</th>
                                    <th>Revenue</th>
                                    <th>Share</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($paymentMethods as $pm)
                                    <tr>
                                        <td><span style="font-size:13px;font-weight:500;color:{{ $pm['color'] }}">{{ $pm['label'] }}</span></td>
                                        <td class="units-cell">{{ number_format($pm['txns']) }}</td>
                                        <td class="rev-cell">₹{{ number_format($pm['revenue']) }}</td>
                                        <td><span style="font-size:12px;font-weight:600;color:var(--text-primary)">{{ $pm['share'] }}%</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" style="text-align:center;color:var(--text-hint);padding:24px">No transactions for this period.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            @if($paymentMethods->isNotEmpty())
                                <tfoot>
                                    <tr>
                                        <td>Total</td>
                                        <td style="color:var(--text-secondary)">{{ number_format($paymentMethods->sum('txns')) }}</td>
                                        <td style="color:var(--accent)">₹{{ number_format($revenueThis) }}</td>
                                        <td style="color:var(--text-secondary)">100%</td>
                                    </tr>
                                </tfoot>
                            @endif
                        </table>
                    </div>
                </div>

                <div class="sc">
                    <div class="sc-head">
                        <h5>Key Metrics Summary</h5>
                        <span class="sc-head-sub">{{ $start->format('d M') }} – {{ $end->format('d M Y') }}</span>
                    </div>
                    <div class="sc-body">
                        <div class="info-row">
                            <span class="info-label">Gross Revenue</span>
                            <span class="info-value">₹{{ number_format($grossRevenue) }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Discounts Given</span>
                            <span class="info-value" style="color:var(--red)">− ₹{{ number_format($discountsGiven) }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Returns / Refunds</span>
                            <span class="info-value" style="color:var(--red)">− ₹{{ number_format($refundsTotal) }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Tax Collected (GST)</span>
                            <span class="info-value">₹{{ number_format($taxCollected) }}</span>
                        </div>
                        <div class="info-row" style="border-top:2px solid var(--border);margin-top:4px;padding-top:12px">
                            <span style="font-size:14px;font-weight:650;color:var(--text-primary)">Net Revenue</span>
                            <span style="font-size:18px;font-weight:750;color:var(--accent)">₹{{ number_format($revenueThis) }}</span>
                        </div>
                        @if($bestSalesDay)
                            <div class="info-row">
                                <span class="info-label">Best Sales Day</span>
                                <span class="info-value">
                                    {{ \Carbon\Carbon::parse($bestSalesDay)->format('D d M') }} — ₹{{ number_format($bestSalesAmount) }}
                                </span>
                            </div>
                        @endif
                        @if($peakHourLabel)
                            <div class="info-row">
                                <span class="info-label">Peak Order Hour</span>
                                <span class="info-value">{{ $peakHourLabel }}</span>
                            </div>
                        @endif
                        <div class="info-row">
                            <span class="info-label">Repeat Purchase Rate</span>
                            <span class="info-value">{{ $repeatPurchaseRate }}%</span>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

@include('admin.footer')

<script>
/* ── Revenue over time ── */
(function(){
    const ctx = document.getElementById('revenueChart');
    if (!ctx) return;
    const labels  = @json($revenueLabels);
    const series  = @json($revenueSeries);
    new Chart(ctx, {
        type: 'line',
        data: {
            labels,
            datasets: [{
                label: 'Revenue (₹)',
                data: series,
                fill: true,
                tension: 0.45,
                borderColor: '#303d89',
                borderWidth: 2.5,
                pointRadius: series.length > 60 ? 0 : 3,
                pointHoverRadius: 6,
                pointBackgroundColor: '#303d89',
                backgroundColor: (ctx) => {
                    const { ctx: c, chartArea } = ctx.chart;
                    if (!chartArea) return 'transparent';
                    const g = c.createLinearGradient(0, chartArea.top, 0, chartArea.bottom);
                    g.addColorStop(0, 'rgba(48,61,137,.18)');
                    g.addColorStop(1, 'rgba(48,61,137,0)');
                    return g;
                }
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#202223', cornerRadius: 8, padding: 10,
                    callbacks: { label: v => ' ₹' + v.parsed.y.toLocaleString('en-IN') }
                }
            },
            scales: {
                x: { grid: { display: false }, ticks: { color: '#8c9196', font: { size: 11 }, maxTicksLimit: 15 }, border: { display: false } },
                y: {
                    grid: { color: '#f1f2f4' }, border: { display: false },
                    ticks: { color: '#8c9196', font: { size: 11 }, callback: v => '₹' + (v >= 1000 ? (v/1000).toFixed(0)+'k' : v) }
                }
            }
        }
    });
})();

/* ── Category donut ── */
(function(){
    const ctx = document.getElementById('categoryDonut');
    if (!ctx) return;
    const cats = @json($categoryBreakdown);
    if (!cats.length) return;
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: cats.map(c => c.name),
            datasets: [{
                data: cats.map(c => c.pct),
                backgroundColor: cats.map(c => c.color),
                borderWidth: 2, borderColor: '#fff', hoverOffset: 6
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false, cutout: '70%',
            plugins: {
                legend: { display: false },
                tooltip: { callbacks: { label: v => v.label + ': ' + v.parsed + '%' } }
            }
        }
    });
})();

/* ── Orders vs Returns bar ── */
(function(){
    const ctx = document.getElementById('ordersChart');
    if (!ctx) return;
    const data = @json($ordersVsReturns);
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: data.labels,
            datasets: [
                { label: 'Orders',  data: data.orders,  backgroundColor: '#303d89', borderRadius: 5, borderSkipped: false },
                { label: 'Returns', data: data.returns, backgroundColor: '#fce8e8', borderRadius: 5, borderSkipped: false }
            ]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { font: { size: 11 }, boxWidth: 10, padding: 12 } },
                tooltip: { backgroundColor: '#202223', cornerRadius: 8 }
            },
            scales: {
                x: { grid: { display: false }, ticks: { font: { size: 11 }, color: '#8c9196' }, border: { display: false } },
                y: { grid: { color: '#f1f2f4' }, ticks: { font: { size: 11 }, color: '#8c9196' }, border: { display: false } }
            }
        }
    });
})();

/* ── Customer doughnut ── */
(function(){
    const ctx = document.getElementById('customerChart');
    if (!ctx) return;
    const newPct       = {{ $newCustomerPct }};
    const returningPct = {{ $returningCustomerPct }};
    if (newPct + returningPct === 0) return;
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['New Customers', 'Returning Customers'],
            datasets: [{
                data: [newPct, returningPct],
                backgroundColor: ['#303d89', '#007a5e'],
                borderWidth: 2, borderColor: '#fff', hoverOffset: 6
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false, cutout: '68%',
            plugins: {
                legend: { display: false },
                tooltip: { callbacks: { label: v => v.label + ': ' + v.parsed + '%' } }
            }
        }
    });
})();

/* ── Period comparison (first half vs second half) ── */
(function(){
    const ctx = document.getElementById('compareChart');
    if (!ctx) return;
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['First Half', 'Second Half'],
            datasets: [
                { label: 'This Period', data: [{{ $thisHalf1 }}, {{ $thisHalf2 }}], backgroundColor: '#303d89', borderRadius: 6, borderSkipped: false },
                { label: 'Last Period', data: [{{ $prevHalf1 }}, {{ $prevHalf2 }}], backgroundColor: '#e3e5e8', borderRadius: 6, borderSkipped: false }
            ]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { font: { size: 11 }, boxWidth: 10, padding: 10 } },
                tooltip: {
                    backgroundColor: '#202223', cornerRadius: 8,
                    callbacks: { label: v => ' ₹' + v.parsed.y.toLocaleString('en-IN') }
                }
            },
            scales: {
                x: { grid: { display: false }, ticks: { font: { size: 11 }, color: '#8c9196' }, border: { display: false } },
                y: {
                    grid: { color: '#f1f2f4' }, border: { display: false },
                    ticks: { font: { size: 11 }, color: '#8c9196', callback: v => '₹' + (v >= 1000 ? (v/1000).toFixed(0)+'k' : v) }
                }
            }
        }
    });
})();

/* ── Custom date range toggle ── */
document.getElementById('customToggle')?.addEventListener('click', function () {
    const inputs = document.getElementById('customInputs');
    inputs.style.display = inputs.style.display === 'none' ? 'flex' : 'none';
    document.querySelectorAll('.date-bar-left .date-preset').forEach(e => e.classList.remove('active'));
    this.classList.add('active');
});
</script>