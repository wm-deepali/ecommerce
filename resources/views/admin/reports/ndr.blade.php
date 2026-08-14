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

    .status-pill { display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 20px; font-size: 11.5px; font-weight: 600; }
    .st-pending   { background: var(--amber-bg); color: var(--amber); }
    .st-reattempt { background: var(--blue-bg);  color: var(--blue); }
    .st-delivered { background: var(--green-bg); color: var(--green); }
    .st-rto       { background: var(--red-bg);   color: var(--red); }
    .st-cancelled { background: var(--bg);       color: var(--text-hint); }

    .units-cell { font-size: 13px; color: var(--text-secondary); font-weight: 600; }
    .rev-cell    { font-size: 13.5px; font-weight: 700; color: var(--text-primary); }

    @media(max-width:768px) { .report-page { padding: 16px; } }
    </style>

    <div class="app-content content container-fluid">
        <div class="report-page">

            {{-- ── Page Header ── --}}
            <div class="page-header">
                <div>
                    <h1>NDR Report</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        NDR Report
                    </div>
                </div>
                <div style="display:flex;gap:8px;flex-wrap:wrap">
                    <a href="javascript:window.print()" class="btn-secondary-dash"><i class="fa fa-print"></i> Print</a>
                    <a href="{{ route('admin.reports.ndr.export', ['start_date'=>$start->toDateString(), 'end_date'=>$end->toDateString()]) }}" class="btn-primary-dash">
                        <i class="fa fa-download"></i> Export CSV
                    </a>
                </div>
            </div>

            {{-- ── Date Range Bar ── --}}
            <form method="GET" action="{{ route('admin.reports.ndr') }}" id="dateForm">
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
                            <a href="{{ route('admin.reports.ndr', ['start_date' => $preset['start'], 'end_date' => $preset['end']]) }}"
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

                <div class="kpi-tile">
                    <div class="kpi-tile-top">
                        <span class="kpi-tile-label">NDRs Raised</span>
                        <div class="kpi-tile-icon red"><i class="fa fa-truck-ramp-box"></i></div>
                    </div>
                    <div class="kpi-value">{{ number_format($ndrsThis) }}</div>
                    @if($ndrImproved)
                        <div class="kpi-badge up"><i class="fa fa-arrow-down"></i> {{ abs($ndrGrowth) }}% vs prev period</div>
                    @elseif($ndrWorsened)
                        <div class="kpi-badge down"><i class="fa fa-arrow-up"></i> {{ $ndrGrowth }}% vs prev period</div>
                    @else
                        <div class="kpi-badge neutral"><i class="fa fa-minus"></i> No change</div>
                    @endif
                </div>

                <div class="kpi-tile">
                    <div class="kpi-tile-top">
                        <span class="kpi-tile-label">Delivery Recovery Rate</span>
                        <div class="kpi-tile-icon green"><i class="fa fa-box-open"></i></div>
                    </div>
                    <div class="kpi-value">{{ $deliveryRecoveryRate }}%</div>
                    @if($recoveryImproved)
                        <div class="kpi-badge up"><i class="fa fa-arrow-up"></i> {{ abs($recoveryDelta) }}pp vs prev period</div>
                    @elseif($recoveryWorsened)
                        <div class="kpi-badge down"><i class="fa fa-arrow-down"></i> {{ abs($recoveryDelta) }}pp vs prev period</div>
                    @else
                        <div class="kpi-badge neutral"><i class="fa fa-minus"></i> No change</div>
                    @endif
                </div>

                <div class="kpi-tile">
                    <div class="kpi-tile-top">
                        <span class="kpi-tile-label">RTO Rate</span>
                        <div class="kpi-tile-icon amber"><i class="fa fa-rotate-left"></i></div>
                    </div>
                    <div class="kpi-value">{{ $rtoRate }}%</div>
                    <div class="kpi-badge neutral">{{ number_format($rtoThis) }} of {{ number_format($resolvedThis) }} resolved</div>
                </div>

                <div class="kpi-tile">
                    <div class="kpi-tile-top">
                        <span class="kpi-tile-label">Currently Open</span>
                        <div class="kpi-tile-icon blue"><i class="fa fa-hourglass-half"></i></div>
                    </div>
                    <div class="kpi-value">{{ number_format($openThis) }}</div>
                    <div class="kpi-badge neutral">Pending + reattempt</div>
                </div>

                <div class="kpi-tile">
                    <div class="kpi-tile-top">
                        <span class="kpi-tile-label">Avg. Resolution Time</span>
                        <div class="kpi-tile-icon purple"><i class="fa fa-clock"></i></div>
                    </div>
                    <div class="kpi-value">{{ $avgResolutionDays !== null ? $avgResolutionDays . ' d' : '—' }}</div>
                    <div class="kpi-badge neutral">Created → resolved</div>
                </div>

            </div>

            {{-- ── Trend + Reason Breakdown ── --}}
            <div class="charts-2col">

                <div class="sc">
                    <div class="sc-head">
                        <h5>NDRs Raised Over Time</h5>
                        <span class="sc-head-sub">{{ ucfirst($granularity) }} · {{ $start->format('d M Y') }} – {{ $end->format('d M Y') }}</span>
                    </div>
                    <div class="sc-body">
                        @if($worstDay)
                            <div style="font-size:12px;color:var(--text-hint);margin-bottom:10px">
                                ⚠️ Worst day: <strong style="color:var(--text-primary)">{{ \Carbon\Carbon::parse($worstDay)->format('d M Y') }}</strong>
                                — {{ $worstDayCount }} NDR{{ $worstDayCount == 1 ? '' : 's' }}
                            </div>
                        @endif
                        <div class="chart-wrap-lg">
                            <canvas id="trendChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="sc">
                    <div class="sc-head">
                        <h5>NDRs by Reason</h5>
                        <span class="sc-head-sub">{{ $start->format('d M') }} – {{ $end->format('d M Y') }}</span>
                    </div>
                    <div class="sc-body">
                        @if($reasonBreakdown->isEmpty())
                            <div style="text-align:center;color:var(--text-hint);padding:40px 0">No NDR data for this period.</div>
                        @else
                            <div class="chart-wrap-md" style="height:180px">
                                <canvas id="reasonDonut"></canvas>
                            </div>
                            <div style="margin-top:14px">
                                @foreach($reasonBreakdown as $r)
                                    <div class="cat-row">
                                        <div class="cat-color-dot" style="background:{{ $r['color'] }}"></div>
                                        <span class="cat-row-name">{{ $r['name'] }}</span>
                                        <span class="cat-row-pct">{{ $r['pct'] }}%</span>
                                        <span class="cat-row-rev">{{ $r['count'] }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

            </div>

            {{-- ── Status Breakdown + Key Metrics ── --}}
            <div class="charts-2col">

                <div class="sc">
                    <div class="sc-head">
                        <h5>Status Outcome Breakdown</h5>
                        <span class="sc-head-sub">{{ $start->format('d M') }} – {{ $end->format('d M Y') }}</span>
                    </div>
                    <div class="sc-body">
                        <div class="chart-wrap-sm">
                            <canvas id="statusBarChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="sc">
                    <div class="sc-head">
                        <h5>Key Metrics Summary</h5>
                        <span class="sc-head-sub">{{ $start->format('d M') }} – {{ $end->format('d M Y') }}</span>
                    </div>
                    <div class="sc-body">
                        <div class="info-row">
                            <span class="info-label">Delivered</span>
                            <span class="info-value" style="color:var(--green)">{{ number_format($deliveredThis) }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">RTO</span>
                            <span class="info-value" style="color:var(--red)">{{ number_format($rtoThis) }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Cancelled</span>
                            <span class="info-value">{{ number_format($cancelledThis) }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Avg. Reattempts</span>
                            <span class="info-value">{{ $avgAttempts }}</span>
                        </div>
                        @if($worstDay)
                            <div class="info-row">
                                <span class="info-label">Worst Day</span>
                                <span class="info-value">{{ \Carbon\Carbon::parse($worstDay)->format('D d M') }} — {{ $worstDayCount }}</span>
                            </div>
                        @endif
                        <div class="info-row" style="border-top:2px solid var(--border);margin-top:4px;padding-top:12px">
                            <span style="font-size:14px;font-weight:650;color:var(--text-primary)">Total Resolved</span>
                            <span style="font-size:18px;font-weight:750;color:var(--accent)">{{ number_format($resolvedThis) }}</span>
                        </div>
                    </div>
                </div>

            </div>

            {{-- ── Daily Breakdown + Worst Affected Orders ── --}}
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px">

                <div class="sc">
                    <div class="sc-head">
                        <h5>Daily NDR Breakdown</h5>
                        <span class="sc-head-sub">Last 7 days</span>
                    </div>
                    <div class="sc-body" style="padding:0">
                        <table class="sum-table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Raised</th>
                                    <th>Delivered</th>
                                    <th>RTO</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dailyBreakdown as $row)
                                    <tr>
                                        <td style="font-weight:500">{{ $row['date']->format('d M, D') }}</td>
                                        <td class="units-cell">{{ number_format($row['raised']) }}</td>
                                        <td style="color:var(--green);font-weight:600">{{ number_format($row['delivered']) }}</td>
                                        <td style="color:var(--red);font-weight:600">{{ number_format($row['rto']) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>7-Day Total</td>
                                    <td style="color:var(--text-secondary)">{{ number_format($weekTotalRaised) }}</td>
                                    <td style="color:var(--green)">{{ number_format($weekTotalDelivered) }}</td>
                                    <td style="color:var(--red)">{{ number_format($weekTotalRto) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="sc">
                    <div class="sc-head">
                        <h5>Worst Affected Orders</h5>
                        <div style="display:flex;gap:8px;align-items:center">
                            <span class="sc-head-sub">Open, highest attempts</span>
                            <a href="{{ route('admin.ndr.index') }}" style="font-size:12px;color:var(--accent);text-decoration:none;font-weight:500">View All →</a>
                        </div>
                    </div>
                    <div class="sc-body" style="padding:0">
                        <table class="sum-table">
                            <thead>
                                <tr>
                                    <th>Order</th>
                                    <th>Reason</th>
                                    <th>Attempts</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($worstOrders as $o)
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin.ndr.show', $o['ndr_id']) }}" style="color:var(--accent);text-decoration:none;font-weight:600">
                                                #{{ $o['order_number'] }}
                                            </a>
                                            <div style="font-size:11.5px;color:var(--text-hint)">{{ $o['customer'] }}</div>
                                        </td>
                                        <td style="font-size:12.5px;color:var(--text-secondary)">{{ $o['reason'] }}</td>
                                        <td class="units-cell">{{ $o['attempts'] }}</td>
                                        <td>
                                            <span class="status-pill st-{{ strtolower($o['status']) }}">{{ $o['status'] }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" style="text-align:center;color:var(--text-hint);padding:24px">No open NDRs in this period.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

@include('admin.footer')

<script>
/* ── NDR trend over time ── */
(function(){
    const ctx = document.getElementById('trendChart');
    if (!ctx) return;
    const labels = @json($trendLabels);
    const series = @json($trendSeries);
    new Chart(ctx, {
        type: 'line',
        data: {
            labels,
            datasets: [{
                label: 'NDRs Raised',
                data: series,
                fill: true,
                tension: 0.45,
                borderColor: '#b22222',
                borderWidth: 2.5,
                pointRadius: series.length > 60 ? 0 : 3,
                pointHoverRadius: 6,
                pointBackgroundColor: '#b22222',
                backgroundColor: (ctx) => {
                    const { ctx: c, chartArea } = ctx.chart;
                    if (!chartArea) return 'transparent';
                    const g = c.createLinearGradient(0, chartArea.top, 0, chartArea.bottom);
                    g.addColorStop(0, 'rgba(178,34,34,.16)');
                    g.addColorStop(1, 'rgba(178,34,34,0)');
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
                    callbacks: { label: v => ' ' + v.parsed.y + ' NDR' + (v.parsed.y === 1 ? '' : 's') }
                }
            },
            scales: {
                x: { grid: { display: false }, ticks: { color: '#8c9196', font: { size: 11 }, maxTicksLimit: 15 }, border: { display: false } },
                y: { grid: { color: '#f1f2f4' }, border: { display: false }, ticks: { color: '#8c9196', font: { size: 11 }, precision: 0 } }
            }
        }
    });
})();

/* ── Reason donut ── */
(function(){
    const ctx = document.getElementById('reasonDonut');
    if (!ctx) return;
    const reasons = @json($reasonBreakdown);
    if (!reasons.length) return;
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: reasons.map(r => r.name),
            datasets: [{
                data: reasons.map(r => r.pct),
                backgroundColor: reasons.map(r => r.color),
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

/* ── Status outcome bar ── */
(function(){
    const ctx = document.getElementById('statusBarChart');
    if (!ctx) return;
    const bar = @json($statusBar);
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: bar.labels,
            datasets: [{
                label: 'NDRs',
                data: bar.data,
                backgroundColor: bar.colors,
                borderRadius: 5,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: { backgroundColor: '#202223', cornerRadius: 8 }
            },
            scales: {
                x: { grid: { display: false }, ticks: { font: { size: 11 }, color: '#8c9196' }, border: { display: false } },
                y: { grid: { color: '#f1f2f4' }, ticks: { font: { size: 11 }, color: '#8c9196', precision: 0 }, border: { display: false } }
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