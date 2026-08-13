@include('admin.top-header')
<div class="main-section">
    @include('admin.header')

    <style>
    :root {
        --bg: #f1f2f4;
        --surface: #ffffff;
        --border: #e3e5e8;
        --text-primary: #202223;
        --text-secondary:#6d7175;
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
        --shadow-card: 0 1px 3px rgba(0,0,0,.08), 0 0 0 1px var(--border);
        --font: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }
    .pay-page { background: var(--bg); padding: 24px 28px; min-height: 100vh; font-family: var(--font); color: var(--text-primary); }
    .pay-page * { box-sizing: border-box; }

    .pay-page-header { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 20px; }
    .pay-page-header h1 { font-size: 20px; font-weight: 650; color: var(--text-primary); margin: 0; }
    .crumb { font-size: 12.5px; color: var(--text-hint); margin-top: 3px; }
    .crumb a { color: var(--accent); text-decoration: none; }
    .crumb a:hover { text-decoration: underline; }
    .crumb span { margin: 0 5px; }

    .btn-secondary-dash {
        display: inline-flex; align-items: center; gap: 6px;
        background: var(--surface); color: var(--text-primary) !important;
        border: 1px solid var(--border); border-radius: var(--radius-sm);
        padding: 8px 16px; font-size: 13px; font-weight: 500; cursor: pointer;
        text-decoration: none !important; font-family: var(--font); transition: background .15s;
        box-shadow: 0 1px 2px rgba(0,0,0,.04);
    }
    .btn-secondary-dash:hover { background: var(--bg); }

    /* ── KPI ── */
    .kpi-strip { display: grid; grid-template-columns: repeat(4,1fr); gap: 14px; margin-bottom: 20px; }
    @media(max-width:900px) { .kpi-strip { grid-template-columns: repeat(2,1fr); } }
    @media(max-width:480px) { .kpi-strip { grid-template-columns: 1fr; } }
    .kpi-tile { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 18px 20px; box-shadow: var(--shadow-card); }
    .kpi-tile-top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px; }
    .kpi-tile-label { font-size: 12px; font-weight: 600; color: var(--text-hint); text-transform: uppercase; letter-spacing: .04em; }
    .kpi-tile-icon { width: 36px; height: 36px; border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center; font-size: 15px; }
    .kpi-tile-icon.green  { background: var(--green-bg);  color: var(--green); }
    .kpi-tile-icon.amber  { background: var(--amber-bg);  color: var(--amber); }
    .kpi-tile-icon.red    { background: var(--red-bg);    color: var(--red); }
    .kpi-tile-icon.purple { background: var(--purple-bg); color: var(--purple); }
    .kpi-tile-value { font-size: 26px; font-weight: 750; color: var(--text-primary); line-height: 1; }
    .kpi-tile-sub { font-size: 12px; color: var(--text-hint); margin-top: 5px; }

    /* ── Charts ── */
    .charts-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px; }
    @media(max-width:768px) { .charts-row { grid-template-columns: 1fr; } }
    .section-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-md); box-shadow: var(--shadow-card); overflow: hidden; }
    .section-card-header { padding: 14px 20px; border-bottom: 1px solid var(--border); background: #fafafa; display: flex; align-items: center; justify-content: space-between; }
    .section-card-header h5 { font-size: 13px; font-weight: 650; color: var(--text-primary); margin: 0; }
    .section-card-body { padding: 20px; }
    .chart-wrap { position: relative; height: 200px; }

    /* ── Method breakdown ── */
    .method-row { display: flex; align-items: center; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid var(--bg); }
    .method-row:last-child { border-bottom: none; }
    .method-row-left { display: flex; align-items: center; gap: 10px; }
    .method-label { font-size: 13px; font-weight: 500; color: var(--text-primary); }
    .method-pct { font-size: 11.5px; color: var(--text-hint); margin-top: 1px; }
    .method-amount { font-size: 13px; font-weight: 700; color: var(--text-primary); }
    .progress-mini { height: 4px; border-radius: 10px; background: var(--bg); margin-top: 4px; overflow: hidden; width: 120px; }
    .progress-mini-bar { height: 100%; border-radius: 10px; }

    /* ── Method badges ── */
    .method-badge { display: inline-flex; align-items: center; gap: 5px; font-size: 12px; font-weight: 600; padding: 4px 10px; border-radius: 6px; background: var(--bg); color: var(--text-secondary); white-space: nowrap; }
    .method-upi        { background: #fff0f6; color: #c2185b; }
    .method-card       { background: var(--blue-bg); color: var(--blue); }
    .method-netbanking { background: var(--purple-bg); color: var(--purple); }
    .method-cod        { background: var(--amber-bg); color: var(--amber); }
    .method-wallet     { background: var(--green-bg); color: var(--green); }
    .method-razorpay   { background: #e8f5ff; color: #0062cc; }
    .method-default    { background: var(--bg); color: var(--text-secondary); }

    /* ── Table card ── */
    .pay-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-md); box-shadow: var(--shadow-card); overflow: hidden; }
    .status-tabs { display: flex; gap: 0; border-bottom: 1px solid var(--border); background: var(--surface); padding: 0 20px; overflow-x: auto; }
    .status-tab { display: inline-flex; align-items: center; gap: 6px; padding: 12px 16px; font-size: 13px; font-weight: 500; color: var(--text-secondary); text-decoration: none; border-bottom: 2px solid transparent; white-space: nowrap; transition: color .15s; }
    .status-tab:hover { color: var(--text-primary); }
    .status-tab.active { color: var(--accent); border-bottom-color: var(--accent); font-weight: 600; }
    .tab-count { background: var(--bg); color: var(--text-hint); font-size: 11px; font-weight: 700; padding: 2px 6px; border-radius: 20px; }
    .status-tab.active .tab-count { background: var(--accent-light); color: var(--accent); }

    .filter-bar { padding: 16px 20px; border-bottom: 1px solid var(--border); background: var(--surface); }
    .filter-row { display: flex; flex-wrap: wrap; gap: 12px; align-items: flex-end; }
    .filter-group { display: flex; flex-direction: column; gap: 5px; }
    .filter-group label { font-size: 12px; font-weight: 600; color: var(--text-secondary); letter-spacing: .03em; text-transform: uppercase; }
    .filter-control { height: 36px; border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 0 11px; font-size: 13px; color: var(--text-primary); background: var(--surface); outline: none; transition: border-color .15s, box-shadow .15s; font-family: var(--font); min-width: 150px; }
    .filter-control:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(48,61,137,.12); }
    .filter-actions { display: flex; gap: 8px; align-items: center; }
    .btn-filter-search { height: 36px; display: inline-flex; align-items: center; gap: 6px; background: var(--accent); color: #fff; border: none; border-radius: var(--radius-sm); padding: 0 16px; font-size: 13px; font-weight: 600; cursor: pointer; font-family: var(--font); transition: background .15s; }
    .btn-filter-search:hover { background: #252f70; }
    .btn-filter-reset { height: 36px; display: inline-flex; align-items: center; gap: 6px; background: var(--surface); color: var(--text-primary); border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 0 14px; font-size: 13px; font-weight: 500; cursor: pointer; text-decoration: none; font-family: var(--font); transition: background .15s; }
    .btn-filter-reset:hover { background: var(--bg); }

    .pay-table-wrap { overflow-x: auto; }
    .pay-table { width: 100%; border-collapse: collapse; font-size: 13px; font-family: var(--font); }
    .pay-table thead th { font-size: 11px; font-weight: 600; letter-spacing: .06em; text-transform: uppercase; color: var(--text-hint); padding: 10px 16px; border-bottom: 1px solid var(--border); background: #fafafa; text-align: left; white-space: nowrap; }
    .pay-table tbody tr { border-bottom: 1px solid var(--border); transition: background .1s; }
    .pay-table tbody tr:last-child { border-bottom: none; }
    .pay-table tbody tr:hover { background: #fafbfc; }
    .pay-table tbody td { padding: 13px 16px; vertical-align: middle; }

    .txn-id   { font-family: 'SF Mono','Fira Code',monospace; font-size: 12px; font-weight: 700; color: var(--accent); }
    .order-ref { font-size: 12px; color: var(--text-hint); margin-top: 2px; font-family: 'SF Mono','Fira Code',monospace; }
    .cust-avatar { width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700; background: var(--accent-light); color: var(--accent); flex-shrink: 0; }
    .cust-name  { font-size: 13px; font-weight: 600; color: var(--text-primary); }
    .cust-email { font-size: 11.5px; color: var(--text-hint); margin-top: 1px; }
    .amount-pos { font-size: 14px; font-weight: 700; color: var(--text-primary); }
    .amount-ref { font-size: 14px; font-weight: 700; color: var(--purple); }
    .amount-neg { font-size: 14px; font-weight: 700; color: var(--red); }

    .pill { display: inline-flex; align-items: center; gap: 4px; font-size: 11.5px; font-weight: 600; padding: 3px 9px; border-radius: 20px; }
    .pill::before { content:''; width: 5px; height: 5px; border-radius: 50%; display: inline-block; }
    .pill-success  { background: var(--green-bg);  color: var(--green); }
    .pill-success::before  { background: var(--green); }
    .pill-pending  { background: var(--amber-bg);  color: var(--amber); }
    .pill-pending::before  { background: var(--amber); }
    .pill-failed   { background: var(--red-bg);    color: var(--red); }
    .pill-failed::before   { background: var(--red); }
    .pill-refunded { background: var(--purple-bg); color: var(--purple); }
    .pill-refunded::before { background: var(--purple); }

    .date-primary   { font-size: 12.5px; color: var(--text-secondary); font-weight: 500; }
    .date-secondary { font-size: 11.5px; color: var(--text-hint); margin-top: 1px; }

    .action-btn { display: inline-flex; align-items: center; justify-content: center; width: 30px; height: 30px; border-radius: var(--radius-sm); border: 1px solid var(--border); background: var(--surface); color: var(--text-secondary); font-size: 12px; cursor: pointer; transition: all .12s; text-decoration: none; }
    .action-btn:hover { background: var(--bg); color: var(--text-primary); }
    .action-btn-view:hover { background: var(--blue-bg); border-color: #b8d4f5; color: var(--blue); }
    .action-wrap { position: relative; display: inline-flex; }
    .action-wrap .tooltip-label { position: absolute; bottom: calc(100% + 6px); left: 50%; transform: translateX(-50%); background: #202223; color: #fff; font-size: 11px; white-space: nowrap; padding: 3px 8px; border-radius: 5px; pointer-events: none; opacity: 0; transition: opacity .15s; z-index: 10; }
    .action-wrap:hover .tooltip-label { opacity: 1; }

    .empty-state { text-align: center; padding: 64px 20px; }
    .empty-state .empty-icon { width: 56px; height: 56px; border-radius: 50%; background: var(--bg); display: inline-flex; align-items: center; justify-content: center; font-size: 22px; color: var(--text-hint); margin-bottom: 14px; }

    .pay-pagination { padding: 14px 20px; border-top: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; background: var(--surface); flex-wrap: wrap; gap: 10px; }
    .pagination-info { font-size: 12.5px; color: var(--text-hint); }

    @media(max-width:768px) { .pay-page { padding: 16px; } .filter-row { flex-direction: column; } .filter-control { min-width: 100%; } }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="app-content content container-fluid">
        <div class="pay-page">

            {{-- ── Page header ── --}}
            <div class="pay-page-header">
                <div>
                    <h1>Payments &amp; Transactions</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        Payments &amp; Transactions
                    </div>
                </div>
                <div style="display:flex;gap:8px;flex-wrap:wrap">
                    <a href="{{ route('admin.payments.export', request()->query()) }}" class="btn-secondary-dash">
                        <i class="fa fa-download"></i> Export CSV
                    </a>
                </div>
            </div>

            {{-- ── KPI strip ── --}}
            <div class="kpi-strip">
                <div class="kpi-tile">
                    <div class="kpi-tile-top">
                        <span class="kpi-tile-label">Total Collected</span>
                        <div class="kpi-tile-icon green"><i class="fa fa-inr"></i></div>
                    </div>
                    <div class="kpi-tile-value">₹{{ number_format($kpi['collected'], 0) }}</div>
                    <div class="kpi-tile-sub">Successful payments</div>
                </div>
                <div class="kpi-tile">
                    <div class="kpi-tile-top">
                        <span class="kpi-tile-label">Pending</span>
                        <div class="kpi-tile-icon amber"><i class="fa fa-clock-o"></i></div>
                    </div>
                    <div class="kpi-tile-value">₹{{ number_format($kpi['pending'], 0) }}</div>
                    <div class="kpi-tile-sub">{{ number_format($kpi['pending_count']) }} transactions</div>
                </div>
                <div class="kpi-tile">
                    <div class="kpi-tile-top">
                        <span class="kpi-tile-label">Refunded</span>
                        <div class="kpi-tile-icon purple"><i class="fa fa-reply"></i></div>
                    </div>
                    <div class="kpi-tile-value">₹{{ number_format($kpi['refunded'], 0) }}</div>
                    <div class="kpi-tile-sub">{{ number_format($kpi['refunded_count']) }} refunds</div>
                </div>
                <div class="kpi-tile">
                    <div class="kpi-tile-top">
                        <span class="kpi-tile-label">Failed</span>
                        <div class="kpi-tile-icon red"><i class="fa fa-times-circle"></i></div>
                    </div>
                    <div class="kpi-tile-value">{{ number_format($kpi['failed_count']) }}</div>
                    <div class="kpi-tile-sub">Failed transactions</div>
                </div>
            </div>

            {{-- ── Charts row ── --}}
            <div class="charts-row">

                {{-- Revenue trend --}}
                <div class="section-card">
                    <div class="section-card-header">
                        <h5>Revenue Trend</h5>
                        <span style="font-size:12px;color:var(--text-hint)">Last 7 days</span>
                    </div>
                    <div class="section-card-body">
                        <div class="chart-wrap">
                            <canvas id="revenueChart"></canvas>
                        </div>
                    </div>
                </div>

                {{-- Payment methods breakdown --}}
                <div class="section-card">
                    <div class="section-card-header">
                        <h5>Payment Methods</h5>
                        <span style="font-size:12px;color:var(--text-hint)">All time (paid only)</span>
                    </div>
                    <div class="section-card-body" style="padding:12px 20px">
                        @forelse($methodBreakdown as $m)
                            @php
                                $pct      = $methodTotal > 0 ? round(($m->total / $methodTotal) * 100) : 0;
                                $key      = strtolower(str_replace([' ', '_', '-'], '', $m->payment_method));
                                $colorMap = [
                                    'upi'        => ['class' => 'method-upi',        'bar' => '#c2185b', 'icon' => 'fa-mobile'],
                                    'card'       => ['class' => 'method-card',       'bar' => '#0069d9', 'icon' => 'fa-credit-card'],
                                    'creditcard' => ['class' => 'method-card',       'bar' => '#0069d9', 'icon' => 'fa-credit-card'],
                                    'debitcard'  => ['class' => 'method-card',       'bar' => '#0069d9', 'icon' => 'fa-credit-card'],
                                    'netbanking' => ['class' => 'method-netbanking', 'bar' => '#6d28d9', 'icon' => 'fa-university'],
                                    'cod'        => ['class' => 'method-cod',        'bar' => '#916a00', 'icon' => 'fa-money'],
                                    'wallet'     => ['class' => 'method-wallet',     'bar' => '#007a5e', 'icon' => 'fa-google-wallet'],
                                    'razorpay'   => ['class' => 'method-razorpay',   'bar' => '#0062cc', 'icon' => 'fa-bolt'],
                                ];
                                $style = $colorMap[$key] ?? ['class' => 'method-default', 'bar' => '#8c9196', 'icon' => 'fa-money'];
                            @endphp
                            <div class="method-row">
                                <div class="method-row-left">
                                    <span class="method-badge {{ $style['class'] }}">
                                        <i class="fa {{ $style['icon'] }}"></i>
                                        {{ ucfirst($m->payment_method) }}
                                    </span>
                                    <div>
                                        <div class="method-label">{{ ucfirst(str_replace('_', ' ', $m->payment_method)) }}</div>
                                        <div class="progress-mini">
                                            <div class="progress-mini-bar"
                                                 style="width:{{ $pct }}%;background:{{ $style['bar'] }}"></div>
                                        </div>
                                    </div>
                                </div>
                                <div style="text-align:right">
                                    <div class="method-amount">₹{{ number_format($m->total, 0) }}</div>
                                    <div style="font-size:11.5px;color:var(--text-hint)">{{ $pct }}%</div>
                                </div>
                            </div>
                        @empty
                            <div style="text-align:center;padding:32px 0;color:var(--text-hint);font-size:13px">
                                No payment data yet.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- ── Transactions table card ── --}}
            <div class="pay-card">

                {{-- Status tabs --}}
                <div class="status-tabs">
                    @php
                        $tabs = ['all' => 'All', 'paid' => 'Paid', 'pending' => 'Pending', 'failed' => 'Failed', 'refunded' => 'Refunded'];
                    @endphp
                    @foreach($tabs as $key => $label)
                        <a href="{{ route('admin.payments.index', array_merge(request()->except('tab','page'), ['tab' => $key])) }}"
                           class="status-tab {{ $activeTab === $key ? 'active' : '' }}">
                            {{ $label }}
                            <span class="tab-count">{{ number_format($tabCounts[$key] ?? 0) }}</span>
                        </a>
                    @endforeach
                </div>

                {{-- Filter bar --}}
                <div class="filter-bar">
                    <form method="GET" action="{{ route('admin.payments.index') }}">
                        <input type="hidden" name="tab" value="{{ $activeTab }}">
                        <div class="filter-row">
                            <div class="filter-group" style="flex:1">
                                <label>Search</label>
                                <input type="text" name="search" value="{{ request('search') }}"
                                       class="filter-control" style="min-width:220px"
                                       placeholder="Transaction ID, order #, customer…">
                            </div>
                            <div class="filter-group">
                                <label>Method</label>
                                <select name="method" class="filter-control">
                                    <option value="">All Methods</option>
                                    @foreach(['upi' => 'UPI', 'card' => 'Card', 'netbanking' => 'Net Banking', 'cod' => 'COD', 'wallet' => 'Wallet', 'razorpay' => 'Razorpay'] as $val => $label)
                                        <option value="{{ $val }}" {{ request('method') === $val ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="filter-group">
                                <label>From</label>
                                <input type="date" name="from_date" value="{{ request('from_date') }}"
                                       class="filter-control" style="min-width:140px">
                            </div>
                            <div class="filter-group">
                                <label>To</label>
                                <input type="date" name="to_date" value="{{ request('to_date') }}"
                                       class="filter-control" style="min-width:140px">
                            </div>
                            <div class="filter-actions">
                                <button type="submit" class="btn-filter-search">
                                    <i class="fa fa-search"></i> Search
                                </button>
                                <a href="{{ route('admin.payments.index') }}" class="btn-filter-reset">
                                    <i class="fa fa-refresh"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Table --}}
                <div class="pay-table-wrap">
                    <table class="pay-table">
                        <thead>
                            <tr>
                                <th>Transaction</th>
                                <th>Customer</th>
                                <th>Method</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th style="width:80px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                @php
                                    // Avatar initials
                                    $words    = explode(' ', trim($order->customer_name));
                                    $initials = strtoupper(substr($words[0] ?? '', 0, 1) . substr($words[1] ?? '', 0, 1));

                                    // Transaction ID display: prefer razorpay_payment_id > transaction_id > —
                                    $txnId = $order->razorpay_payment_id
                                           ?: ($order->transaction_id ?: null);

                                    // Method badge class
                                    $methodKey = strtolower(str_replace([' ', '_', '-'], '', $order->payment_method ?? ''));
                                    $methodMap = [
                                        'upi'        => ['class' => 'method-upi',        'icon' => 'fa-mobile',      'label' => 'UPI'],
                                        'card'       => ['class' => 'method-card',       'icon' => 'fa-credit-card', 'label' => 'Card'],
                                        'creditcard' => ['class' => 'method-card',       'icon' => 'fa-credit-card', 'label' => 'Card'],
                                        'debitcard'  => ['class' => 'method-card',       'icon' => 'fa-credit-card', 'label' => 'Card'],
                                        'netbanking' => ['class' => 'method-netbanking', 'icon' => 'fa-university',  'label' => 'Net Banking'],
                                        'cod'        => ['class' => 'method-cod',        'icon' => 'fa-money',       'label' => 'COD'],
                                        'wallet'     => ['class' => 'method-wallet',     'icon' => 'fa-google-wallet','label' => 'Wallet'],
                                        'razorpay'   => ['class' => 'method-razorpay',   'icon' => 'fa-bolt',        'label' => 'Razorpay'],
                                    ];
                                    $mStyle = $methodMap[$methodKey] ?? ['class' => 'method-default', 'icon' => 'fa-money', 'label' => ucfirst($order->payment_method ?? '—')];

                                    // Amount class
                                    $amtClass = match($order->payment_status) {
                                        'refunded' => 'amount-ref',
                                        'failed'   => 'amount-neg',
                                        default    => 'amount-pos',
                                    };

                                    // Pill class
                                    $pillClass = match($order->payment_status) {
                                        'paid'     => 'pill-success',
                                        'pending'  => 'pill-pending',
                                        'failed'   => 'pill-failed',
                                        'refunded' => 'pill-refunded',
                                        default    => 'pill-pending',
                                    };
                                @endphp
                                <tr>
                                    <td>
                                        @if($txnId)
                                            <div class="txn-id">{{ $txnId }}</div>
                                        @else
                                            <div class="txn-id" style="color:var(--text-hint)">—</div>
                                        @endif
                                        <div class="order-ref">Order #{{ $order->order_number }}</div>
                                    </td>
                                    <td>
                                        <div style="display:flex;align-items:center;gap:9px">
                                            <div class="cust-avatar">{{ $initials }}</div>
                                            <div>
                                                <div class="cust-name">{{ $order->customer_name }}</div>
                                                <div class="cust-email">{{ $order->customer_email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="method-badge {{ $mStyle['class'] }}">
                                            <i class="fa {{ $mStyle['icon'] }}"></i>
                                            {{ $mStyle['label'] }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="{{ $amtClass }}">₹{{ number_format($order->grand_total, 2) }}</span>
                                    </td>
                                    <td>
                                        <span class="pill {{ $pillClass }}">
                                            {{ ucfirst($order->payment_status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="date-primary">{{ $order->created_at->format('d M Y') }}</div>
                                        <div class="date-secondary">{{ $order->created_at->format('h:i A') }}</div>
                                    </td>
                                    <td>
                                        <div style="display:flex;gap:5px">
                                            <div class="action-wrap">
                                                <a href="{{ route('admin.orders.show', $order) }}"
                                                   class="action-btn action-btn-view">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <span class="tooltip-label">View Order</span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">
                                        <div class="empty-state">
                                            <div class="empty-icon"><i class="fa fa-credit-card"></i></div>
                                            <p>No transactions found</p>
                                            <p style="font-size:13px;color:var(--text-hint)">
                                                Try adjusting your filters or search query.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="pay-pagination">
                    <div class="pagination-info">
                        @if($orders->total() > 0)
                            Showing {{ $orders->firstItem() }}–{{ $orders->lastItem() }}
                            of {{ number_format($orders->total()) }} transactions
                        @else
                            No transactions found
                        @endif
                    </div>
                    <div style="display:flex;gap:6px">
                        @if($orders->onFirstPage())
                            <span class="btn-secondary-dash" style="opacity:.4;pointer-events:none">← Previous</span>
                        @else
                            <a href="{{ $orders->previousPageUrl() }}" class="btn-secondary-dash">← Previous</a>
                        @endif
                        @if($orders->hasMorePages())
                            <a href="{{ $orders->nextPageUrl() }}" class="btn-secondary-dash">Next →</a>
                        @else
                            <span class="btn-secondary-dash" style="opacity:.4;pointer-events:none">Next →</span>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@include('admin.footer')

<script>
(function () {
    const ctx = document.getElementById('revenueChart');
    if (!ctx) return;

    // Data injected from controller via Blade
    const labels = @json($trendLabels);
    const values = @json($trendValues);

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Revenue (₹)',
                data: values,
                backgroundColor: 'rgba(48,61,137,0.75)',
                borderRadius: 6,
                hoverBackgroundColor: 'rgba(48,61,137,1)',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { color: '#8c9196', font: { size: 11 } }
                },
                y: {
                    grid: { color: '#f1f2f4' },
                    beginAtZero: true,
                    ticks: {
                        color: '#8c9196',
                        font: { size: 11 },
                        callback: v => v >= 1000 ? '₹' + (v / 1000).toFixed(0) + 'k' : '₹' + v
                    }
                }
            }
        }
    });
})();
</script>