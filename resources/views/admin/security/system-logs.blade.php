@include('admin.top-header')

<div class="main-section">
    @include('admin.header')

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
            --amber: #916a00;
            --amber-bg: #fff5cc;
            --blue: #0069d9;
            --blue-bg: #e8f2ff;
            --red: #b22222;
            --red-bg: #fce8e8;
            --purple: #6b21a8;
            --purple-bg: #f3e8ff;
            --radius-sm: 8px;
            --radius-md: 12px;
            --shadow-card: 0 1px 3px rgba(0,0,0,.08), 0 0 0 1px var(--border);
            --font: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        .log-page {
            background: var(--bg);
            padding: 24px 28px;
            min-height: 100vh;
            font-family: var(--font);
            color: var(--text-primary);
            box-sizing: border-box;
        }

        .log-page * { box-sizing: border-box; }

        /* ── Page header ── */
        .log-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 20px;
        }

        .log-header h1 {
            font-size: 20px;
            font-weight: 650;
            color: var(--text-primary);
            margin: 0;
        }

        .crumb { font-size: 12.5px; color: var(--text-hint); margin-top: 3px; }
        .crumb a { color: var(--accent); text-decoration: none; }
        .crumb a:hover { text-decoration: underline; }
        .crumb span { margin: 0 5px; }

        /* ── Buttons ── */
        .btn-primary-dash {
            display: inline-flex; align-items: center; gap: 6px;
            background: var(--accent); color: #fff !important;
            border: none; border-radius: var(--radius-sm);
            padding: 8px 16px; font-size: 13px; font-weight: 600;
            cursor: pointer; text-decoration: none !important;
            font-family: var(--font); transition: background .15s;
            box-shadow: 0 1px 3px rgba(48,61,137,.25);
        }
        .btn-primary-dash:hover { background: #252f70; }

        .btn-secondary-dash {
            display: inline-flex; align-items: center; gap: 6px;
            background: var(--surface); color: var(--text-primary) !important;
            border: 1px solid var(--border); border-radius: var(--radius-sm);
            padding: 8px 16px; font-size: 13px; font-weight: 500;
            cursor: pointer; text-decoration: none !important;
            font-family: var(--font); transition: background .15s;
        }
        .btn-secondary-dash:hover { background: var(--bg); }

        .btn-danger-soft {
            display: inline-flex; align-items: center; gap: 6px;
            background: var(--red-bg); color: var(--red) !important;
            border: 1px solid #f5c0c0; border-radius: var(--radius-sm);
            padding: 8px 16px; font-size: 13px; font-weight: 600;
            cursor: pointer; text-decoration: none !important;
            font-family: var(--font); transition: all .15s;
        }
        .btn-danger-soft:hover { background: var(--red); color: #fff !important; }

        /* ── Stat cards ── */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 12px;
            margin-bottom: 20px;
        }

        @media(max-width:1100px) { .stat-grid { grid-template-columns: repeat(3,1fr); } }
        @media(max-width:600px)  { .stat-grid { grid-template-columns: repeat(2,1fr); } }

        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-card);
            padding: 14px 16px;
            cursor: pointer;
            transition: border-color .15s, box-shadow .15s;
        }

        .stat-card:hover { border-color: var(--accent); box-shadow: 0 0 0 2px rgba(48,61,137,.1); }
        .stat-card.active { border-color: var(--accent); box-shadow: 0 0 0 2px var(--accent); }

        .stat-card-top {
            display: flex; align-items: center;
            justify-content: space-between; margin-bottom: 10px;
        }

        .stat-label {
            font-size: 11px; font-weight: 600;
            text-transform: uppercase; letter-spacing: .04em;
            color: var(--text-hint);
        }

        .stat-icon {
            width: 30px; height: 30px;
            border-radius: 7px;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px;
        }

        .stat-icon.purple { background: var(--accent-light); color: var(--accent); }
        .stat-icon.green  { background: var(--green-bg);     color: var(--green); }
        .stat-icon.blue   { background: var(--blue-bg);      color: var(--blue); }
        .stat-icon.amber  { background: var(--amber-bg);     color: var(--amber); }
        .stat-icon.red    { background: var(--red-bg);       color: var(--red); }
        .stat-icon.pink   { background: var(--purple-bg);    color: var(--purple); }

        .stat-value {
            font-size: 20px; font-weight: 700;
            color: var(--text-primary); line-height: 1;
        }

        .stat-sub { font-size: 11px; color: var(--text-hint); margin-top: 3px; }

        /* ── Tab shell ── */
        .tab-shell {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-card);
            overflow: hidden;
        }

        .tab-nav {
            display: flex;
            border-bottom: 1px solid var(--border);
            background: #fafafa;
            overflow-x: auto;
            scrollbar-width: none;
        }

        .tab-nav::-webkit-scrollbar { display: none; }

        .tab-btn {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 13px 20px;
            font-size: 13px; font-weight: 500;
            color: var(--text-secondary);
            border: none; background: none; cursor: pointer;
            border-bottom: 2px solid transparent;
            white-space: nowrap; font-family: var(--font);
            transition: color .15s, border-color .15s;
        }

        .tab-btn i { font-size: 13px; color: var(--text-hint); }

        .tab-btn:hover { color: var(--text-primary); }

        .tab-btn.active {
            color: var(--accent);
            border-bottom-color: var(--accent);
            font-weight: 650;
        }

        .tab-btn.active i { color: var(--accent); }

        .tab-count {
            background: #f0f1fc;
            color: var(--accent);
            padding: 1px 7px;
            border-radius: 10px;
            font-size: 11px;
            font-weight: 700;
        }

        .tab-count.red { background: var(--red-bg); color: var(--red); }

        .tab-panel { display: none; }
        .tab-panel.active { display: block; }

        /* ── Filter bar ── */
        .filter-bar {
            padding: 14px 18px;
            border-bottom: 1px solid var(--border);
            background: #fafafa;
        }

        .filter-row {
            display: flex; flex-wrap: wrap;
            gap: 10px; align-items: flex-end;
        }

        .filter-group { display: flex; flex-direction: column; gap: 4px; }

        .filter-group label {
            font-size: 11px; font-weight: 600;
            color: var(--text-secondary);
            letter-spacing: .03em; text-transform: uppercase;
        }

        .filter-control {
            height: 34px;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 0 10px;
            font-size: 13px; color: var(--text-primary);
            background: var(--surface); outline: none;
            font-family: var(--font);
            transition: border-color .15s, box-shadow .15s;
            min-width: 130px;
        }

        .filter-control:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(48,61,137,.12);
        }

        .filter-search-wrap { position: relative; flex: 1; min-width: 200px; }
        .filter-search-wrap i {
            position: absolute; left: 10px; top: 50%;
            transform: translateY(-50%);
            color: var(--text-hint); font-size: 12px; pointer-events: none;
        }

        .filter-search-wrap .filter-control { padding-left: 30px; width: 100%; }

        .filter-actions { display: flex; gap: 7px; align-items: center; }

        /* ── Log table ── */
        .log-table-wrap { overflow-x: auto; }

        .log-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            font-family: var(--font);
        }

        .log-table thead th {
            font-size: 11px; font-weight: 600;
            letter-spacing: .06em; text-transform: uppercase;
            color: var(--text-hint);
            padding: 10px 14px;
            border-bottom: 1px solid var(--border);
            background: #fafafa;
            text-align: left; white-space: nowrap;
        }

        .log-table tbody tr {
            border-bottom: 1px solid var(--border);
            transition: background .1s;
        }

        .log-table tbody tr:last-child { border-bottom: none; }
        .log-table tbody tr:hover { background: #fafbfc; }

        .log-table tbody td {
            padding: 11px 14px;
            color: var(--text-primary);
            vertical-align: middle;
        }

        /* ── Status badges ── */
        .badge {
            display: inline-flex; align-items: center; gap: 4px;
            font-size: 11.5px; font-weight: 600;
            padding: 3px 9px; border-radius: 20px; white-space: nowrap;
        }

        .badge::before {
            content: ''; width: 5px; height: 5px;
            border-radius: 50%; display: inline-block;
        }

        .badge-success  { background: var(--green-bg);   color: var(--green); }
        .badge-success::before { background: var(--green); }
        .badge-failed   { background: var(--red-bg);     color: var(--red); }
        .badge-failed::before { background: var(--red); }
        .badge-pending  { background: var(--amber-bg);   color: var(--amber); }
        .badge-pending::before { background: var(--amber); }
        .badge-info     { background: var(--blue-bg);    color: var(--blue); }
        .badge-info::before { background: var(--blue); }
        .badge-warning  { background: var(--amber-bg);   color: var(--amber); }
        .badge-warning::before { background: var(--amber); }

        /* ── ID chip ── */
        .id-chip {
            display: inline-block;
            background: var(--bg); color: var(--text-secondary);
            font-size: 11px; font-weight: 700;
            padding: 2px 7px; border-radius: 6px;
            font-family: 'SF Mono','Fira Code',monospace;
        }

        /* ── Log message cell ── */
        .log-msg { font-size: 13px; color: var(--text-primary); max-width: 320px; }
        .log-msg small { display: block; font-size: 11.5px; color: var(--text-hint); margin-top: 2px; }

        /* ── Code mono ── */
        .mono {
            font-family: 'SF Mono','Fira Code',monospace;
            font-size: 12px; color: var(--text-secondary);
        }

        /* ── Action btn ── */
        .action-btn {
            display: inline-flex; align-items: center; justify-content: center;
            width: 28px; height: 28px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
            background: var(--surface);
            color: var(--text-secondary);
            font-size: 12px; cursor: pointer;
            transition: all .12s; text-decoration: none;
        }

        .action-btn:hover { background: var(--bg); color: var(--text-primary); }

        /* ── Detail modal ── */
        .log-modal-overlay {
            position: fixed; inset: 0;
            background: rgba(0,0,0,.45);
            z-index: 1060;
            display: none; align-items: center; justify-content: center;
            padding: 20px;
            font-family: var(--font);
        }

        .log-modal-overlay.open { display: flex; }

        .log-modal {
            background: var(--surface);
            border-radius: var(--radius-md);
            box-shadow: 0 20px 60px rgba(0,0,0,.2);
            width: 100%; max-width: 680px;
            max-height: 88vh;
            display: flex; flex-direction: column;
            overflow: hidden;
        }

        .log-modal-header {
            padding: 15px 20px;
            border-bottom: 1px solid var(--border);
            background: #fafafa;
            display: flex; align-items: center;
            justify-content: space-between;
        }

        .log-modal-header h5 {
            font-size: 14px; font-weight: 650;
            color: var(--text-primary); margin: 0;
        }

        .log-modal-close {
            width: 30px; height: 30px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
            background: var(--surface);
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; font-size: 13px; color: var(--text-secondary);
            transition: all .12s;
        }

        .log-modal-close:hover { background: var(--red-bg); color: var(--red); border-color: #f5c0c0; }

        .log-modal-body {
            padding: 20px;
            overflow-y: auto;
            flex: 1;
        }

        .log-detail-row {
            display: flex; gap: 12px;
            padding: 10px 0;
            border-bottom: 1px solid var(--border);
            font-size: 13px;
        }

        .log-detail-row:last-child { border-bottom: none; }

        .log-detail-key {
            width: 140px; flex-shrink: 0;
            font-size: 11.5px; font-weight: 600;
            text-transform: uppercase; letter-spacing: .04em;
            color: var(--text-hint);
            padding-top: 1px;
        }

        .log-detail-val { flex: 1; color: var(--text-primary); word-break: break-all; }

        .log-payload {
            background: #1e1e2e;
            color: #a6e3a1;
            border-radius: var(--radius-sm);
            padding: 14px 16px;
            font-family: 'SF Mono','Fira Code',monospace;
            font-size: 12px;
            line-height: 1.7;
            overflow-x: auto;
            margin-top: 4px;
            white-space: pre-wrap;
            word-break: break-all;
        }

        /* ── Pagination ── */
        .log-pagination {
            padding: 13px 18px;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
            background: var(--surface);
        }

        .pag-info { font-size: 12.5px; color: var(--text-hint); }

        /* ── Export dropdown ── */
        .export-wrap { position: relative; display: inline-block; }

        .export-menu {
            display: none;
            position: absolute; right: 0;
            top: calc(100% + 6px);
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            box-shadow: 0 4px 16px rgba(0,0,0,.1);
            min-width: 170px; z-index: 200; overflow: hidden;
        }

        .export-menu.open { display: block; }

        .export-menu a {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 15px; font-size: 13px; font-weight: 500;
            color: var(--text-primary); text-decoration: none;
            transition: background .1s;
            border-bottom: 1px solid var(--border);
        }

        .export-menu a:last-child { border-bottom: none; }
        .export-menu a:hover { background: var(--bg); }
        .export-menu a i { width: 15px; text-align: center; color: var(--text-hint); }

        @media(max-width: 768px) {
            .log-page { padding: 16px; }
            .filter-row { flex-direction: column; }
            .filter-control { min-width: 100%; }
        }
    </style>

    <div class="app-content content container-fluid">
        <div class="log-page">

            <!-- Page header -->
            <div class="log-header">
                <div>
                    <h1>System Logs</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        System Logs
                    </div>
                </div>
                <div style="display:flex;gap:8px;flex-wrap:wrap;align-items:center">
                    <button class="btn-danger-soft" onclick="confirmPurge()">
                        <i class="fa fa-broom"></i> Purge Old Logs
                    </button>
                    <div class="export-wrap" id="exportWrap">
                        <button class="btn-secondary-dash" onclick="toggleExport()">
                            <i class="fa fa-download"></i> Export <i class="fa fa-chevron-down" style="font-size:10px"></i>
                        </button>
                        <div class="export-menu" id="exportMenu">
                            <a href="#"><i class="fa fa-file-csv"></i> Export CSV</a>
                            <a href="#"><i class="fa fa-file-excel"></i> Export Excel</a>
                            <a href="#" onclick="window.print();return false"><i class="fa fa-print"></i> Print</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ── Summary stat cards ── -->
            <div class="stat-grid">


<div class="stat-card active" onclick="switchLogTab('all', this)">
    <div class="stat-card-top">
        <div class="stat-label">All Logs</div>
        <div class="stat-icon purple"><i class="fa fa-layer-group"></i></div>
    </div>
    <div class="stat-value">{{ number_format($allLogsTotal) }}</div>
    <div class="stat-sub">Across all channels</div>
</div>

              <!-- stat card -->
<div class="stat-card" onclick="switchLogTab('payment', this)">
    <div class="stat-card-top">
        <div class="stat-label">Payment</div>
        <div class="stat-icon green"><i class="fa fa-credit-card"></i></div>
    </div>
    <div class="stat-value">{{ number_format($paymentStats['total']) }}</div>
    <div class="stat-sub"><span style="color:var(--red)">{{ $paymentStats['failed'] }} failed</span></div>
</div>

                {{-- Delivery — commented out for now, no delivery/courier integration wired up yet
                <div class="stat-card" onclick="switchLogTab('delivery', this)">
                    <div class="stat-card-top">
                        <div class="stat-label">Delivery</div>
                        <div class="stat-icon blue"><i class="fa fa-truck"></i></div>
                    </div>
                    <div class="stat-value">2,108</div>
                    <div class="stat-sub"><span style="color:var(--amber)">34 warnings</span></div>
                </div>
                --}}

                {{-- SMS — commented out for now, no SMS provider wired up yet
                <div class="stat-card" onclick="switchLogTab('sms', this)">
                    <div class="stat-card-top">
                        <div class="stat-label">SMS</div>
                        <div class="stat-icon amber"><i class="fa fa-message"></i></div>
                    </div>
                    <div class="stat-value">4,560</div>
                    <div class="stat-sub"><span style="color:var(--red)">12 failed</span></div>
                </div>
                --}}

                <div class="stat-card" onclick="switchLogTab('email', this)">
                    <div class="stat-card-top">
                        <div class="stat-label">Email</div>
                        <div class="stat-icon red"><i class="fa fa-envelope"></i></div>
                    </div>
                    <div class="stat-value">{{ number_format($emailStats['total']) }}</div>
                    <div class="stat-sub"><span style="color:var(--red)">{{ $emailStats['failed'] }} failed</span> · <span style="color:var(--amber)">{{ $emailStats['blocked'] }} blocked</span></div>
                </div>

                {{-- WhatsApp — commented out for now, no WhatsApp integration wired up yet
                <div class="stat-card" onclick="switchLogTab('whatsapp', this)">
                    <div class="stat-card-top">
                        <div class="stat-label">WhatsApp</div>
                        <div class="stat-icon pink"><i class="fa-brands fa-whatsapp"></i></div>
                    </div>
                    <div class="stat-value">1,021</div>
                    <div class="stat-sub"><span style="color:var(--red)">3 failed</span></div>
                </div>
                --}}

                <div class="stat-card" onclick="switchLogTab('api', this)">
                    <div class="stat-card-top">
                        <div class="stat-label">API</div>
                        <div class="stat-icon pink"><i class="fa fa-code"></i></div>
                    </div>
                    <div class="stat-value">{{ number_format($apiStats['total']) }}</div>
                    <div class="stat-sub"><span style="color:var(--red)">{{ $apiStats['failed'] }} failed</span></div>
                </div>

            </div>

            <!-- ── Tab shell ── -->
            <div class="tab-shell">

                <div class="tab-nav" id="logTabNav">
                   <button class="tab-btn active" onclick="switchTab('all', this)">
    <i class="fa fa-layer-group"></i> All Logs
    <span class="tab-count">{{ number_format($allLogsTotal) }}</span>
</button>
                   <!-- tab-nav button -->
<button class="tab-btn" onclick="switchTab('payment', this)">
    <i class="fa fa-credit-card"></i> Payment
    <span class="tab-count red">{{ $paymentStats['failed'] }}</span>
</button>
                    {{-- Delivery — commented out for now
                    <button class="tab-btn" onclick="switchTab('delivery', this)">
                        <i class="fa fa-truck"></i> Delivery
                        <span class="tab-count">2,108</span>
                    </button>
                    --}}
                    {{-- SMS — commented out for now
                    <button class="tab-btn" onclick="switchTab('sms', this)">
                        <i class="fa fa-message"></i> SMS
                        <span class="tab-count red">12</span>
                    </button>
                    --}}
                    <button class="tab-btn" onclick="switchTab('email', this)">
                        <i class="fa fa-envelope"></i> Email
                        <span class="tab-count red">{{ $emailStats['failed'] }}</span>
                    </button>
                    {{-- WhatsApp — commented out for now
                    <button class="tab-btn" onclick="switchTab('whatsapp', this)">
                        <i class="fa-brands fa-whatsapp"></i> WhatsApp
                        <span class="tab-count red">3</span>
                    </button>
                    --}}
                    <button class="tab-btn" onclick="switchTab('api', this)">
                        <i class="fa fa-code"></i> API
                        <span class="tab-count red">{{ $apiStats['failed'] }}</span>
                    </button>
                    <button class="tab-btn" onclick="switchTab('order', this)">
    <i class="fa fa-box"></i> Order Events
    <span class="tab-count">{{ number_format($orderEventStats['total']) }}</span>
</button>
                    <button class="tab-btn" onclick="switchTab('auth', this)">
    <i class="fa fa-shield-halved"></i> Auth / Login
    <span class="tab-count red">{{ $authStats['failed'] }}</span>
</button>
                </div>

               <!-- ════════════════════════════
     ALL LOGS TAB (DYNAMIC)
════════════════════════════ -->
<div class="tab-panel active" id="tab-all">
    <form method="GET" action="{{ route('admin.security.system-logs') }}#tab-all">
        <div class="filter-bar">
            <div class="filter-row">
                <div class="filter-group">
                    <label>Level</label>
                    <select class="filter-control" name="all_level">
                        <option value="">All Levels</option>
                        <option value="Success" @selected(request('all_level') === 'Success')>Success</option>
                        <option value="Info" @selected(request('all_level') === 'Info')>Info</option>
                        <option value="Warning" @selected(request('all_level') === 'Warning')>Warning</option>
                        <option value="Error" @selected(request('all_level') === 'Error')>Error</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>Channel</label>
                    <select class="filter-control" name="all_channel">
                        <option value="">All Channels</option>
                        <option value="Payment" @selected(request('all_channel') === 'Payment')>Payment</option>
                        <option value="Email" @selected(request('all_channel') === 'Email')>Email</option>
                        <option value="API" @selected(request('all_channel') === 'API')>API</option>
                        <option value="Order" @selected(request('all_channel') === 'Order')>Order</option>
                        <option value="Auth" @selected(request('all_channel') === 'Auth')>Auth</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>Date From</label>
                    <input type="date" class="filter-control" name="all_date_from" value="{{ request('all_date_from') }}">
                </div>
                <div class="filter-group">
                    <label>Date To</label>
                    <input type="date" class="filter-control" name="all_date_to" value="{{ request('all_date_to') }}">
                </div>
                <div class="filter-search-wrap">
                    <i class="fa fa-search"></i>
                    <input type="text" class="filter-control" name="all_search" value="{{ request('all_search') }}" placeholder="Search message, order ID, user…">
                </div>
                <div class="filter-actions">
                    <button type="submit" class="btn-primary-dash"><i class="fa fa-search"></i> Filter</button>
                    <a href="{{ route('admin.security.system-logs') }}#tab-all" class="btn-secondary-dash">Reset</a>
                </div>
            </div>
        </div>
    </form>

    <div class="log-table-wrap">
        <table class="log-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Timestamp</th>
                    <th>Channel</th>
                    <th>Level</th>
                    <th>Message</th>
                    <th>Reference</th>
                    <th>IP / User</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($allLogs as $log)
                @php
                    $levelBadge = [
                        'Success' => 'badge-success',
                        'Info'    => 'badge-info',
                        'Warning' => 'badge-warning',
                        'Error'   => 'badge-failed',
                    ][$log->level] ?? 'badge-info';

                    $idPrefix = [
                        'email'   => 'E',
                        'payment' => 'P',
                        'auth'    => 'A',
                        'order'   => 'O',
                        'api'     => 'A',
                    ][$log->log_type] ?? '#';
                @endphp
                <tr>
                    <td><span class="id-chip">{{ $idPrefix }}{{ $log->id }}</span></td>
                    <td style="font-size:12px;white-space:nowrap">
                        {{ \Carbon\Carbon::parse($log->created_at)->format('d M Y') }}<br>
                        <span style="color:var(--text-hint)">{{ \Carbon\Carbon::parse($log->created_at)->format('H:i:s') }}</span>
                    </td>
                    <td><span class="badge badge-info">{{ $log->channel }}</span></td>
                    <td><span class="badge {{ $levelBadge }}">{{ $log->level }}</span></td>
                    <td class="log-msg">{{ $log->message }}</td>
                    <td><span class="mono">{{ $log->reference }}</span></td>
                    <td style="font-size:12px;color:var(--text-hint)">{{ $log->ip_or_user }}</td>
                    <td>
                        <button class="action-btn" onclick="openLogDetail('{{ $log->log_type }}', {{ $log->id }})" title="View Details">
                            <i class="fa fa-eye"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center;padding:24px;color:var(--text-hint)">No logs yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="log-pagination">
        <span class="pag-info">
            Showing {{ $allLogs->firstItem() ?? 0 }}–{{ $allLogs->lastItem() ?? 0 }} of {{ number_format($allLogs->total()) }} logs
        </span>
        <div>{{ $allLogs->links('pagination::bootstrap-4') }}</div>
    </div>
</div>

                <!-- ════════════════════════════
                     PAYMENT LOGS TAB
                ════════════════════════════ -->
              <!-- ════════════════════════════
     PAYMENT LOGS TAB (DYNAMIC)
════════════════════════════ -->
<div class="tab-panel" id="tab-payment">
    <form method="GET" action="{{ route('admin.security.system-logs') }}#tab-payment">
        <div class="filter-bar">
            <div class="filter-row">
                <div class="filter-group">
                    <label>Status</label>
                    <select class="filter-control" name="payment_status">
                        <option value="">All</option>
                        <option value="captured" @selected(request('payment_status') === 'captured')>Captured</option>
                        <option value="failed" @selected(request('payment_status') === 'failed')>Failed</option>
                        <option value="refunded" @selected(request('payment_status') === 'refunded')>Refunded</option>
                        <option value="pending" @selected(request('payment_status') === 'pending')>Pending</option>
                        <option value="created" @selected(request('payment_status') === 'created')>Created</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>Gateway</label>
                    <select class="filter-control" name="payment_gateway">
                        <option value="">All</option>
                        <option value="razorpay" @selected(request('payment_gateway') === 'razorpay')>Razorpay</option>
                        <option value="cod" @selected(request('payment_gateway') === 'cod')>COD</option>
                    </select>
                </div>
                <div class="filter-search-wrap">
                    <i class="fa fa-search"></i>
                    <input type="text" class="filter-control" name="payment_search" value="{{ request('payment_search') }}" placeholder="Search order #, payment ID, email…">
                </div>
                <div class="filter-actions">
                    <button type="submit" class="btn-primary-dash"><i class="fa fa-search"></i> Filter</button>
                    <a href="{{ route('admin.security.system-logs') }}#tab-payment" class="btn-secondary-dash">Reset</a>
                </div>
            </div>
        </div>
    </form>

    <div class="log-table-wrap">
        <table class="log-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Timestamp</th>
                    <th>Order ID</th>
                    <th>Payment ID</th>
                    <th>Gateway</th>
                    <th>Amount</th>
                    <th>Method</th>
                    <th>Status</th>
                    <th>Customer</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($paymentLogs as $log)
                <tr>
                    <td><span class="id-chip">P{{ $log->id }}</span></td>
                    <td style="font-size:12px;white-space:nowrap">{{ $log->created_at->format('d M Y') }}<br><span style="color:var(--text-hint)">{{ $log->created_at->format('H:i:s') }}</span></td>
                    <td>
                        @if($log->order_id)
                            <a href="{{ route('admin.orders.show', $log->order_id) }}" style="color:var(--accent);font-weight:600;font-size:13px">{{ $log->order_number ?? ('#' . $log->order_id) }}</a>
                        @else
                            <span style="color:var(--text-hint)">—</span>
                        @endif
                    </td>
                    <td><span class="mono">{{ $log->payment_id ?? '—' }}</span></td>
                    <td>{{ ucfirst($log->gateway) }}</td>
                    <td style="font-weight:700">₹{{ number_format($log->amount, 2) }}</td>
                    <td>{{ $log->method ? ucfirst($log->method) : '—' }}</td>
                    <td>
                        @php
                            $payBadge = [
                                'captured' => 'badge-success',
                                'failed'   => 'badge-failed',
                                'refunded' => 'badge-info',
                                'pending'  => 'badge-pending',
                                'created'  => 'badge-pending',
                            ][$log->status] ?? 'badge-info';
                        @endphp
                        <span class="badge {{ $payBadge }}">{{ ucfirst($log->status) }}</span>
                    </td>
                    <td style="font-size:12.5px">{{ $log->customer_name ?? '—' }}</td>
                    <td><button class="action-btn" onclick="openLogDetail('payment', {{ $log->id }})" title="View"><i class="fa fa-eye"></i></button></td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" style="text-align:center;padding:24px;color:var(--text-hint)">No payment logs yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="log-pagination">
        <span class="pag-info">
            Showing {{ $paymentLogs->firstItem() ?? 0 }}–{{ $paymentLogs->lastItem() ?? 0 }} of {{ number_format($paymentLogs->total()) }} logs
            &nbsp;·&nbsp; <span style="color:var(--red);font-weight:600">{{ $paymentStats['failed'] }} failed</span>
        </span>
        <div>{{ $paymentLogs->links('pagination::bootstrap-4') }}</div>
    </div>
</div>

                {{--
                ════════════════════════════
                DELIVERY LOGS TAB — commented out for now, no delivery/courier
                integration wired up yet
                ════════════════════════════

                <div class="tab-panel" id="tab-delivery">
                    <div class="filter-bar">
                        <div class="filter-row">
                            <div class="filter-group">
                                <label>Status</label>
                                <select class="filter-control">
                                    <option>All</option>
                                    <option>AWB Assigned</option>
                                    <option>Picked Up</option>
                                    <option>In Transit</option>
                                    <option>Out for Delivery</option>
                                    <option>Delivered</option>
                                    <option>Failed</option>
                                    <option>RTO</option>
                                </select>
                            </div>
                            <div class="filter-group">
                                <label>Courier</label>
                                <select class="filter-control">
                                    <option>All</option>
                                    <option>Shiprocket</option>
                                    <option>Delhivery</option>
                                    <option>BlueDart</option>
                                    <option>DTDC</option>
                                </select>
                            </div>
                            <div class="filter-group">
                                <label>Date From</label>
                                <input type="date" class="filter-control">
                            </div>
                            <div class="filter-search-wrap">
                                <i class="fa fa-search"></i>
                                <input type="text" class="filter-control" placeholder="Search AWB, order ID…">
                            </div>
                            <div class="filter-actions">
                                <button class="btn-primary-dash"><i class="fa fa-search"></i> Filter</button>
                                <button class="btn-secondary-dash">Reset</button>
                            </div>
                        </div>
                    </div>
                    <div class="log-table-wrap">
                        <table class="log-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Timestamp</th>
                                    <th>Order ID</th>
                                    <th>AWB Number</th>
                                    <th>Courier</th>
                                    <th>Event</th>
                                    <th>Status</th>
                                    <th>Location</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span class="id-chip">D2108</span></td>
                                    <td style="font-size:12px;white-space:nowrap">25 Jun 2025<br><span style="color:var(--text-hint)">11:38:12</span></td>
                                    <td><a href="#" style="color:var(--accent);font-weight:600">#10481</a></td>
                                    <td><span class="mono">1234567890</span></td>
                                    <td>Shiprocket</td>
                                    <td class="log-msg">AWB Generated &amp; Assigned<small>Shipment created via Shiprocket API</small></td>
                                    <td><span class="badge badge-success">AWB Assigned</span></td>
                                    <td style="font-size:12.5px;color:var(--text-hint)">Mumbai Hub</td>
                                    <td><button class="action-btn" onclick="openLogDetail('delivery')" title="View"><i class="fa fa-eye"></i></button></td>
                                </tr>
                                <tr>
                                    <td><span class="id-chip">D2107</span></td>
                                    <td style="font-size:12px;white-space:nowrap">25 Jun 2025<br><span style="color:var(--text-hint)">09:12:04</span></td>
                                    <td><a href="#" style="color:var(--accent);font-weight:600">#10472</a></td>
                                    <td><span class="mono">9876543210</span></td>
                                    <td>Delhivery</td>
                                    <td class="log-msg">Delivered successfully<small>Received by: Karan (neighbour)</small></td>
                                    <td><span class="badge badge-success">Delivered</span></td>
                                    <td style="font-size:12.5px;color:var(--text-hint)">Pune, MH</td>
                                    <td><button class="action-btn" onclick="openLogDetail('delivery')" title="View"><i class="fa fa-eye"></i></button></td>
                                </tr>
                                <tr>
                                    <td><span class="id-chip">D2106</span></td>
                                    <td style="font-size:12px;white-space:nowrap">24 Jun 2025<br><span style="color:var(--text-hint)">17:44:30</span></td>
                                    <td><a href="#" style="color:var(--accent);font-weight:600">#10468</a></td>
                                    <td><span class="mono">1122334455</span></td>
                                    <td>BlueDart</td>
                                    <td class="log-msg">Delivery attempt failed — address not found<small>RTO initiated</small></td>
                                    <td><span class="badge badge-failed">RTO Initiated</span></td>
                                    <td style="font-size:12.5px;color:var(--text-hint)">Delhi, DL</td>
                                    <td><button class="action-btn" onclick="openLogDetail('delivery')" title="View"><i class="fa fa-eye"></i></button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="log-pagination">
                        <span class="pag-info">Showing 1–20 of 2,108 logs</span>
                        <div></div>
                    </div>
                </div>
                --}}

                {{--
                ════════════════════════════
                SMS LOGS TAB — commented out for now, no SMS provider wired up yet
                ════════════════════════════

                <div class="tab-panel" id="tab-sms">
                    <div class="filter-bar">
                        <div class="filter-row">
                            <div class="filter-group">
                                <label>Status</label>
                                <select class="filter-control">
                                    <option>All</option>
                                    <option>Delivered</option>
                                    <option>Failed</option>
                                    <option>Pending</option>
                                </select>
                            </div>
                            <div class="filter-group">
                                <label>Provider</label>
                                <select class="filter-control">
                                    <option>All</option>
                                    <option>MSG91</option>
                                    <option>Twilio</option>
                                    <option>Fast2SMS</option>
                                </select>
                            </div>
                            <div class="filter-group">
                                <label>Event Type</label>
                                <select class="filter-control">
                                    <option>All Events</option>
                                    <option>OTP</option>
                                    <option>Order Confirmed</option>
                                    <option>Shipped</option>
                                    <option>Delivered</option>
                                    <option>Promotional</option>
                                </select>
                            </div>
                            <div class="filter-search-wrap">
                                <i class="fa fa-search"></i>
                                <input type="text" class="filter-control" placeholder="Search mobile, order ID…">
                            </div>
                            <div class="filter-actions">
                                <button class="btn-primary-dash"><i class="fa fa-search"></i> Filter</button>
                                <button class="btn-secondary-dash">Reset</button>
                            </div>
                        </div>
                    </div>
                    <div class="log-table-wrap">
                        <table class="log-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Timestamp</th>
                                    <th>Mobile</th>
                                    <th>Event</th>
                                    <th>Provider</th>
                                    <th>Message Preview</th>
                                    <th>Ref ID</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span class="id-chip">S4560</span></td>
                                    <td style="font-size:12px;white-space:nowrap">25 Jun 2025<br><span style="color:var(--text-hint)">11:43:01</span></td>
                                    <td class="mono">+91 98765 43210</td>
                                    <td><span class="badge badge-info">Order Confirmed</span></td>
                                    <td>MSG91</td>
                                    <td class="log-msg">Your order #10482 has been confirmed. Estimated delivery…<small>DLT Template: tmpl_8822</small></td>
                                    <td><span class="mono">91_MSG_442211</span></td>
                                    <td><span class="badge badge-success">Delivered</span></td>
                                    <td><button class="action-btn" onclick="openLogDetail('sms')" title="View"><i class="fa fa-eye"></i></button></td>
                                </tr>
                                <tr>
                                    <td><span class="id-chip">S4559</span></td>
                                    <td style="font-size:12px;white-space:nowrap">25 Jun 2025<br><span style="color:var(--text-hint)">11:40:55</span></td>
                                    <td class="mono">+91 98765 43210</td>
                                    <td><span class="badge badge-warning">OTP</span></td>
                                    <td>MSG91</td>
                                    <td class="log-msg">Your OTP for order verification is 842917…<small>DLT Template: tmpl_OTP_01</small></td>
                                    <td><span class="mono">sms_ERR_4421</span></td>
                                    <td><span class="badge badge-failed">Failed</span></td>
                                    <td><button class="action-btn" onclick="openLogDetail('sms')" title="View"><i class="fa fa-eye"></i></button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="log-pagination">
                        <span class="pag-info">Showing 1–20 of 4,560 logs &nbsp;·&nbsp; <span style="color:var(--red);font-weight:600">12 failed</span></span>
                        <div></div>
                    </div>
                </div>
                --}}

                <!-- ════════════════════════════
                     EMAIL LOGS TAB (DYNAMIC)
                ════════════════════════════ -->
                <div class="tab-panel" id="tab-email">
                    <form method="GET" action="{{ route('admin.security.system-logs') }}#tab-email">
                        <div class="filter-bar">
                            <div class="filter-row">
                                <div class="filter-group">
                                    <label>Status</label>
                                    <select class="filter-control" name="email_status">
                                        <option value="">All</option>
                                        <option value="sent" @selected(request('email_status') === 'sent')>Sent</option>
                                        <option value="failed" @selected(request('email_status') === 'failed')>Failed</option>
                                        <option value="blocked" @selected(request('email_status') === 'blocked')>Blocked</option>
                                    </select>
                                </div>
                                <div class="filter-group">
                                    <label>Event</label>
                                    <select class="filter-control" name="email_event">
                                        <option value="">All Events</option>
                                        <option value="order-confirmed" @selected(request('email_event') === 'order-confirmed')>Order Confirmed</option>
                                        <option value="order-shipped" @selected(request('email_event') === 'order-shipped')>Order Shipped</option>
                                        <option value="order-delivered" @selected(request('email_event') === 'order-delivered')>Order Delivered</option>
                                        <option value="order-cancelled" @selected(request('email_event') === 'order-cancelled')>Order Cancelled</option>
                                        <option value="payment-received" @selected(request('email_event') === 'payment-received')>Payment Received</option>
                                        <option value="password-reset" @selected(request('email_event') === 'password-reset')>Password Reset</option>
                                        <option value="welcome" @selected(request('email_event') === 'welcome')>Welcome</option>
                                        <option value="coupon" @selected(request('email_event') === 'coupon')>Coupon</option>
                                        <option value="new-order-alert" @selected(request('email_event') === 'new-order-alert')>New Order Alert (Admin)</option>
                                        <option value="low-stock-alert" @selected(request('email_event') === 'low-stock-alert')>Low Stock Alert (Admin)</option>
                                    </select>
                                </div>
                                <div class="filter-search-wrap">
                                    <i class="fa fa-search"></i>
                                    <input type="text" class="filter-control" name="email_search" value="{{ request('email_search') }}" placeholder="Search email address, subject, reference…">
                                </div>
                                <div class="filter-actions">
                                    <button type="submit" class="btn-primary-dash"><i class="fa fa-search"></i> Filter</button>
                                    <a href="{{ route('admin.security.system-logs') }}#tab-email" class="btn-secondary-dash">Reset</a>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="log-table-wrap">
                        <table class="log-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Timestamp</th>
                                    <th>To</th>
                                    <th>Subject</th>
                                    <th>Event</th>
                                    <th>Reference</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($emailLogs as $log)
                                <tr>
                                    <td><span class="id-chip">E{{ $log->id }}</span></td>
                                    <td style="font-size:12px;white-space:nowrap">{{ $log->created_at->format('d M Y') }}<br><span style="color:var(--text-hint)">{{ $log->created_at->format('H:i:s') }}</span></td>
                                    <td style="font-size:12.5px">{{ $log->to_email }}</td>
                                    <td class="log-msg">{{ $log->subject ?? '—' }}<small>{{ Str::headline($log->event_key) }}</small></td>
                                    <td>{{ Str::headline($log->event_key) }}</td>
                                    <td><span class="mono">{{ $log->reference ?? '—' }}</span></td>
                                    <td>
                                        @php
                                            $statusBadge = ['sent' => 'badge-success', 'failed' => 'badge-failed', 'blocked' => 'badge-warning'][$log->status] ?? 'badge-info';
                                        @endphp
                                        <span class="badge {{ $statusBadge }}">{{ ucfirst($log->status) }}</span>
                                    </td>
                                    <td><button class="action-btn" onclick="openLogDetail('email', {{ $log->id }})" title="View"><i class="fa fa-eye"></i></button></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" style="text-align:center;padding:24px;color:var(--text-hint)">No email logs yet.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="log-pagination">
                        <span class="pag-info">
                            Showing {{ $emailLogs->firstItem() ?? 0 }}–{{ $emailLogs->lastItem() ?? 0 }} of {{ number_format($emailLogs->total()) }} logs
                            &nbsp;·&nbsp; <span style="color:var(--red);font-weight:600">{{ $emailStats['failed'] }} failed</span>
                            &nbsp;·&nbsp; <span style="color:var(--amber);font-weight:600">{{ $emailStats['blocked'] }} blocked</span>
                        </span>
                        <div>{{ $emailLogs->links('pagination::bootstrap-4') }}</div>
                    </div>
                </div>

                {{--
                ════════════════════════════
                WHATSAPP LOGS TAB — commented out for now, no WhatsApp integration
                wired up yet
                ════════════════════════════

                <div class="tab-panel" id="tab-whatsapp">
                    <div class="filter-bar">
                        <div class="filter-row">
                            <div class="filter-group">
                                <label>Status</label>
                                <select class="filter-control">
                                    <option>All</option>
                                    <option>Sent</option>
                                    <option>Delivered</option>
                                    <option>Read</option>
                                    <option>Failed</option>
                                </select>
                            </div>
                            <div class="filter-group">
                                <label>Template</label>
                                <select class="filter-control">
                                    <option>All</option>
                                    <option>Order Confirmation</option>
                                    <option>Shipped</option>
                                    <option>Delivered</option>
                                    <option>COD OTP</option>
                                    <option>Abandoned Cart</option>
                                </select>
                            </div>
                            <div class="filter-search-wrap">
                                <i class="fa fa-search"></i>
                                <input type="text" class="filter-control" placeholder="Search mobile, WAMID…">
                            </div>
                            <div class="filter-actions">
                                <button class="btn-primary-dash"><i class="fa fa-search"></i> Filter</button>
                                <button class="btn-secondary-dash">Reset</button>
                            </div>
                        </div>
                    </div>
                    <div class="log-table-wrap">
                        <table class="log-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Timestamp</th>
                                    <th>Mobile</th>
                                    <th>Template</th>
                                    <th>Provider</th>
                                    <th>WAMID</th>
                                    <th>Delivered At</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span class="id-chip">W1021</span></td>
                                    <td style="font-size:12px;white-space:nowrap">25 Jun 2025<br><span style="color:var(--text-hint)">11:43:10</span></td>
                                    <td class="mono">+91 91234 56789</td>
                                    <td>Order Confirmation</td>
                                    <td>Meta Cloud API</td>
                                    <td><span class="mono">wamid.HBg_8K2mX</span></td>
                                    <td style="font-size:12px;color:var(--text-hint)">11:43:18</td>
                                    <td><span class="badge badge-success">Read</span></td>
                                    <td><button class="action-btn" onclick="openLogDetail('whatsapp')" title="View"><i class="fa fa-eye"></i></button></td>
                                </tr>
                                <tr>
                                    <td><span class="id-chip">W1020</span></td>
                                    <td style="font-size:12px;white-space:nowrap">25 Jun 2025<br><span style="color:var(--text-hint)">10:22:44</span></td>
                                    <td class="mono">+91 87654 32109</td>
                                    <td>COD OTP</td>
                                    <td>Meta Cloud API</td>
                                    <td><span class="mono">wamid.ERR_9xKp</span></td>
                                    <td style="font-size:12px;color:var(--text-hint)">—</td>
                                    <td><span class="badge badge-failed">Failed</span></td>
                                    <td><button class="action-btn" onclick="openLogDetail('whatsapp')" title="View"><i class="fa fa-eye"></i></button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="log-pagination">
                        <span class="pag-info">Showing 1–20 of 1,021 logs &nbsp;·&nbsp; <span style="color:var(--red);font-weight:600">3 failed</span></span>
                        <div></div>
                    </div>
                </div>
                --}}

                <!-- ════════════════════════════
                     API LOGS TAB (DYNAMIC)
                ════════════════════════════ -->
                <div class="tab-panel" id="tab-api">
                    <form method="GET" action="{{ route('admin.security.system-logs') }}#tab-api">
                        <div class="filter-bar">
                            <div class="filter-row">
                                <div class="filter-group">
                                    <label>Method</label>
                                    <select class="filter-control" name="api_method">
                                        <option value="">All</option>
                                        <option value="GET" @selected(request('api_method') === 'GET')>GET</option>
                                        <option value="POST" @selected(request('api_method') === 'POST')>POST</option>
                                        <option value="PUT" @selected(request('api_method') === 'PUT')>PUT</option>
                                        <option value="DELETE" @selected(request('api_method') === 'DELETE')>DELETE</option>
                                    </select>
                                </div>
                                <div class="filter-group">
                                    <label>HTTP Status</label>
                                    <select class="filter-control" name="api_status">
                                        <option value="">All</option>
                                        <option value="2xx" @selected(request('api_status') === '2xx')>2xx Success</option>
                                        <option value="4xx" @selected(request('api_status') === '4xx')>4xx Client Error</option>
                                        <option value="5xx" @selected(request('api_status') === '5xx')>5xx Server Error</option>
                                    </select>
                                </div>
                                <div class="filter-group">
                                    <label>Service</label>
                                    <select class="filter-control" name="api_service">
                                        <option value="">All</option>
                                        @foreach($apiServices as $service)
                                            <option value="{{ $service }}" @selected(request('api_service') === $service)>{{ $service }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="filter-search-wrap">
                                    <i class="fa fa-search"></i>
                                    <input type="text" class="filter-control" name="api_search" value="{{ request('api_search') }}" placeholder="Search endpoint, service, IP…">
                                </div>
                                <div class="filter-actions">
                                    <button type="submit" class="btn-primary-dash"><i class="fa fa-search"></i> Filter</button>
                                    <a href="{{ route('admin.security.system-logs') }}#tab-api" class="btn-secondary-dash">Reset</a>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="log-table-wrap">
                        <table class="log-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Timestamp</th>
                                    <th>Method</th>
                                    <th>Endpoint</th>
                                    <th>Service</th>
                                    <th>Status</th>
                                    <th>Response Time</th>
                                    <th>IP</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($apiLogs as $log)
                                <tr>
                                    <td><span class="id-chip">A{{ $log->id }}</span></td>
                                    <td style="font-size:12px;white-space:nowrap">{{ $log->created_at->format('d M Y') }}<br><span style="color:var(--text-hint)">{{ $log->created_at->format('H:i:s') }}</span></td>
                                    <td>
                                        @php
                                            $methodColors = [
                                                'GET' => ['#e8f2ff', '#0069d9'],
                                                'POST' => ['#e3f1ec', '#007a5e'],
                                                'PUT' => ['#fff5cc', '#916a00'],
                                                'DELETE' => ['#fce8e8', '#b22222'],
                                            ];
                                            [$mBg, $mFg] = $methodColors[$log->method] ?? ['#f0f1fc', '#303d89'];
                                        @endphp
                                        <span style="background:{{ $mBg }};color:{{ $mFg }};padding:2px 8px;border-radius:5px;font-size:11.5px;font-weight:700">{{ $log->method }}</span>
                                    </td>
                                    <td><span class="mono">{{ $log->endpoint }}</span></td>
                                    <td>{{ $log->service }}</td>
                                    <td>
                                        @php
                                            $code = $log->status_code;
                                            if (is_null($code)) {
                                                $sBg = '#fce8e8'; $sFg = '#b22222'; $sLabel = 'ERR';
                                            } elseif ($code < 300) {
                                                $sBg = '#e3f1ec'; $sFg = '#007a5e'; $sLabel = $code;
                                            } elseif ($code < 500) {
                                                $sBg = '#fff5cc'; $sFg = '#916a00'; $sLabel = $code;
                                            } else {
                                                $sBg = '#fce8e8'; $sFg = '#b22222'; $sLabel = $code;
                                            }
                                        @endphp
                                        <span style="background:{{ $sBg }};color:{{ $sFg }};padding:2px 8px;border-radius:5px;font-size:12px;font-weight:700">{{ $sLabel }}</span>
                                    </td>
                                    <td style="font-size:12.5px;color:var(--text-hint)">{{ $log->response_time_ms !== null ? $log->response_time_ms . ' ms' : '—' }}</td>
                                    <td class="mono">{{ $log->ip_address ?? '—' }}</td>
                                    <td><button class="action-btn" onclick="openLogDetail('api', {{ $log->id }})" title="View"><i class="fa fa-eye"></i></button></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" style="text-align:center;padding:24px;color:var(--text-hint)">No API logs yet.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="log-pagination">
                        <span class="pag-info">
                            Showing {{ $apiLogs->firstItem() ?? 0 }}–{{ $apiLogs->lastItem() ?? 0 }} of {{ number_format($apiLogs->total()) }} logs
                            &nbsp;·&nbsp; <span style="color:var(--red);font-weight:600">{{ $apiStats['failed'] }} failed</span>
                        </span>
                        <div>{{ $apiLogs->links('pagination::bootstrap-4') }}</div>
                    </div>
                </div>

               <!-- ════════════════════════════
     ORDER EVENTS TAB (DYNAMIC)
════════════════════════════ -->
<div class="tab-panel" id="tab-order">
    <form method="GET" action="{{ route('admin.security.system-logs') }}#tab-order">
        <div class="filter-bar">
            <div class="filter-row">
                <div class="filter-group">
                    <label>Status</label>
                    <select class="filter-control" name="order_status">
                        <option value="">All Events</option>
                        <option value="pending" @selected(request('order_status') === 'pending')>Order Placed (Pending)</option>
                        <option value="processing" @selected(request('order_status') === 'processing')>Processing</option>
                        <option value="shipped" @selected(request('order_status') === 'shipped')>Shipped</option>
                        <option value="delivered" @selected(request('order_status') === 'delivered')>Delivered</option>
                        <option value="cancelled" @selected(request('order_status') === 'cancelled')>Cancelled</option>
                        <option value="refunded" @selected(request('order_status') === 'refunded')>Refunded</option>
                    </select>
                </div>
                <div class="filter-search-wrap">
                    <i class="fa fa-search"></i>
                    <input type="text" class="filter-control" name="order_search" value="{{ request('order_search') }}" placeholder="Search order ID, customer…">
                </div>
                <div class="filter-actions">
                    <button type="submit" class="btn-primary-dash"><i class="fa fa-search"></i> Filter</button>
                    <a href="{{ route('admin.security.system-logs') }}#tab-order" class="btn-secondary-dash">Reset</a>
                </div>
            </div>
        </div>
    </form>

    <div class="log-table-wrap">
        <table class="log-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Timestamp</th>
                    <th>Order ID</th>
                    <th>Event</th>
                    <th>Previous Status</th>
                    <th>New Status</th>
                    <th>Triggered By</th>
                    <th>Note</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orderEvents as $log)
                <tr>
                    <td><span class="id-chip">O{{ $log->id }}</span></td>
                    <td style="font-size:12px;white-space:nowrap">{{ $log->created_at->format('d M Y') }}<br><span style="color:var(--text-hint)">{{ $log->created_at->format('H:i:s') }}</span></td>
                    <td>
                        @if($log->order)
                            <a href="{{ route('admin.orders.show', $log->order_id) }}" style="color:var(--accent);font-weight:600">{{ $log->order->order_number }}</a>
                        @else
                            <span style="color:var(--text-hint)">—</span>
                        @endif
                    </td>
                    <td>
                        @php
                            $eventBadge = [
                                'pending'    => 'badge-info',
                                'processing' => 'badge-success',
                                'shipped'    => 'badge-info',
                                'delivered'  => 'badge-success',
                                'cancelled'  => 'badge-failed',
                                'refunded'   => 'badge-warning',
                            ][$log->status] ?? 'badge-info';
                        @endphp
                        <span class="badge {{ $eventBadge }}">{{ Str::headline($log->status) }}</span>
                    </td>
                    <td style="color:var(--text-hint);font-size:12.5px">{{ $log->previous_status ? Str::headline($log->previous_status) : '—' }}</td>
                    <td style="font-weight:600;font-size:12.5px">{{ Str::headline($log->status) }}</td>
                    <td style="font-size:12.5px">{{ $log->triggered_by ?? 'System' }}</td>
                    <td style="font-size:12.5px;color:var(--text-hint)">{{ $log->remarks ?? '—' }}</td>
                    <td><button class="action-btn" onclick="openLogDetail('order', {{ $log->id }})" title="View"><i class="fa fa-eye"></i></button></td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" style="text-align:center;padding:24px;color:var(--text-hint)">No order events yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="log-pagination">
        <span class="pag-info">
            Showing {{ $orderEvents->firstItem() ?? 0 }}–{{ $orderEvents->lastItem() ?? 0 }} of {{ number_format($orderEvents->total()) }} logs
        </span>
        <div>{{ $orderEvents->links('pagination::bootstrap-4') }}</div>
    </div>
</div>

           
              <!-- ════════════════════════════
     AUTH / LOGIN LOGS TAB (DYNAMIC)
════════════════════════════ -->
<div class="tab-panel" id="tab-auth">
    <form method="GET" action="{{ route('admin.security.system-logs') }}#tab-auth">
        <div class="filter-bar">
            <div class="filter-row">
                <div class="filter-group">
                    <label>Event</label>
                    <select class="filter-control" name="auth_event">
                        <option value="">All</option>
                        <option value="login" @selected(request('auth_event') === 'login')>Login Success</option>
                        <option value="login_failed" @selected(request('auth_event') === 'login_failed')>Login Failed</option>
                        <option value="logout" @selected(request('auth_event') === 'logout')>Logout</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>User Type</label>
                    <select class="filter-control" name="auth_user_type">
                        <option value="">All</option>
                        <option value="admin" @selected(request('auth_user_type') === 'admin')>Admin</option>
                        <option value="customer" @selected(request('auth_user_type') === 'customer')>Customer</option>
                    </select>
                </div>
                <div class="filter-search-wrap">
                    <i class="fa fa-search"></i>
                    <input type="text" class="filter-control" name="auth_search" value="{{ request('auth_search') }}" placeholder="Search IP, email…">
                </div>
                <div class="filter-actions">
                    <button type="submit" class="btn-primary-dash"><i class="fa fa-search"></i> Filter</button>
                    <a href="{{ route('admin.security.system-logs') }}#tab-auth" class="btn-secondary-dash">Reset</a>
                </div>
            </div>
        </div>
    </form>

    <div class="log-table-wrap">
        <table class="log-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Timestamp</th>
                    <th>User</th>
                    <th>Type</th>
                    <th>Event</th>
                    <th>IP Address</th>
                    <th>Device / Browser</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($authLogs as $log)
                <tr>
                    <td><span class="id-chip">A{{ $log->id }}</span></td>
                    <td style="font-size:12px;white-space:nowrap">{{ $log->created_at->format('d M Y') }}<br><span style="color:var(--text-hint)">{{ $log->created_at->format('H:i:s') }}</span></td>
                    <td style="font-size:12.5px">{{ $log->email ?? '—' }}</td>
                    <td><span class="badge badge-info">{{ ucfirst($log->user_type) }}</span></td>
                    <td>{{ Str::headline($log->event) }}</td>
                    <td class="mono">{{ $log->ip_address ?? '—' }}</td>
                    <td style="font-size:12px;color:var(--text-hint)">{{ $log->user_agent ? Str::limit($log->user_agent, 30) : '—' }}</td>
                    <td>
                        <span class="badge {{ $log->status === 'success' ? 'badge-success' : 'badge-failed' }}">{{ ucfirst($log->status) }}</span>
                    </td>
                    <td><button class="action-btn" onclick="openLogDetail('auth', {{ $log->id }})" title="View"><i class="fa fa-eye"></i></button></td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" style="text-align:center;padding:24px;color:var(--text-hint)">No auth logs yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="log-pagination">
        <span class="pag-info">
            Showing {{ $authLogs->firstItem() ?? 0 }}–{{ $authLogs->lastItem() ?? 0 }} of {{ number_format($authLogs->total()) }} logs
            &nbsp;·&nbsp; <span style="color:var(--red);font-weight:600">{{ $authStats['failed'] }} failed</span>
        </span>
        <div>{{ $authLogs->links('pagination::bootstrap-4') }}</div>
    </div>
</div>

            </div><!-- /tab-shell -->

        </div><!-- /log-page -->
    </div>

    <!-- ══════════════════════════════════
         LOG DETAIL MODAL
    ══════════════════════════════════ -->
    <div class="log-modal-overlay" id="logModalOverlay" onclick="closeLogDetail(event)">
        <div class="log-modal">
            <div class="log-modal-header">
                <h5 id="logModalTitle"><i class="fa fa-circle-info" style="color:var(--accent);margin-right:6px"></i> Log Detail</h5>
                <button class="log-modal-close" onclick="document.getElementById('logModalOverlay').classList.remove('open')">
                    <i class="fa fa-xmark"></i>
                </button>
            </div>
            <div class="log-modal-body" id="logModalBody">
                <!-- Populated by JS -->
            </div>
        </div>
    </div>

</div>

@include('admin.footer')

@php
    $emailLogDetailData = [];
    foreach ($emailLogs as $log) {
        $emailLogDetailData[$log->id] = [
            'title' => 'Email Log — ' . Str::headline($log->event_key),
            'rows' => [
                ['key' => 'Log ID', 'val' => 'E' . $log->id],
                ['key' => 'Timestamp', 'val' => $log->created_at->format('d M Y, h:i:s A')],
                ['key' => 'To', 'val' => e($log->to_email) . ($log->to_name ? ' (' . e($log->to_name) . ')' : '')],
                ['key' => 'Subject', 'val' => e($log->subject ?? '—')],
                ['key' => 'Event', 'val' => e(Str::headline($log->event_key))],
                ['key' => 'Reference', 'val' => e($log->reference ?? '—')],
                ['key' => 'Status', 'val' => '<span class="badge ' . (['sent' => 'badge-success', 'failed' => 'badge-failed', 'blocked' => 'badge-warning'][$log->status] ?? 'badge-info') . '">' . ucfirst($log->status) . '</span>'],
                ['key' => 'Error', 'val' => e($log->error_message ?? '—')],
            ],
            'payload' => json_encode($log->meta, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
        ];
    }
@endphp

@php
    $paymentLogDetailData = [];
    foreach ($paymentLogs as $log) {
        $paymentLogDetailData[$log->id] = [
            'title' => 'Payment Log — ' . ($log->payment_id ?? $log->order_number ?? ('P' . $log->id)),
            'rows' => [
                ['key' => 'Log ID', 'val' => 'P' . $log->id],
                ['key' => 'Timestamp', 'val' => $log->created_at->format('d M Y, h:i:s A')],
                ['key' => 'Order', 'val' => e($log->order_number ?? '—')],
                ['key' => 'Payment ID', 'val' => e($log->payment_id ?? '—')],
                ['key' => 'Gateway', 'val' => e(ucfirst($log->gateway))],
                ['key' => 'Amount', 'val' => '₹' . number_format($log->amount, 2)],
                ['key' => 'Method', 'val' => e($log->method ? ucfirst($log->method) : '—')],
                ['key' => 'Status', 'val' => '<span class="badge ' . (['captured' => 'badge-success', 'failed' => 'badge-failed', 'refunded' => 'badge-info', 'pending' => 'badge-pending', 'created' => 'badge-pending'][$log->status] ?? 'badge-info') . '">' . ucfirst($log->status) . '</span>'],
                ['key' => 'Customer', 'val' => e(($log->customer_name ?? '—') . ($log->customer_email ? ' <' . $log->customer_email . '>' : ''))],
                ['key' => 'Error', 'val' => e($log->error_message ?? '—')],
            ],
            'payload' => json_encode($log->meta, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
        ];
    }
@endphp

@php
    $authLogDetailData = [];
    foreach ($authLogs as $log) {
        $authLogDetailData[$log->id] = [
            'title' => 'Auth Log — ' . Str::headline($log->event),
            'rows' => [
                ['key' => 'Log ID', 'val' => 'A' . $log->id],
                ['key' => 'Timestamp', 'val' => $log->created_at->format('d M Y, h:i:s A')],
                ['key' => 'Email', 'val' => e($log->email ?? '—')],
                ['key' => 'User Type', 'val' => e(ucfirst($log->user_type))],
                ['key' => 'Event', 'val' => e(Str::headline($log->event))],
                ['key' => 'IP Address', 'val' => e($log->ip_address ?? '—')],
                ['key' => 'User Agent', 'val' => e($log->user_agent ?? '—')],
                ['key' => 'Status', 'val' => '<span class="badge ' . ($log->status === 'success' ? 'badge-success' : 'badge-failed') . '">' . ucfirst($log->status) . '</span>'],
                ['key' => 'Error', 'val' => e($log->error_message ?? '—')],
            ],
            'payload' => json_encode($log->meta, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
        ];
    }
@endphp

@php
    $orderEventDetailData = [];
    foreach ($orderEvents as $log) {
        $orderEventDetailData[$log->id] = [
            'title' => 'Order Event — ' . ($log->order->order_number ?? '#' . $log->order_id) . ' Status Change',
            'rows' => [
                ['key' => 'Log ID', 'val' => 'O' . $log->id],
                ['key' => 'Timestamp', 'val' => $log->created_at->format('d M Y, h:i:s A')],
                ['key' => 'Order ID', 'val' => e($log->order->order_number ?? '—')],
                ['key' => 'Event', 'val' => e(Str::headline($log->status))],
                ['key' => 'Previous Status', 'val' => e($log->previous_status ? Str::headline($log->previous_status) : '—')],
                ['key' => 'New Status', 'val' => e(Str::headline($log->status))],
                ['key' => 'Triggered By', 'val' => e($log->triggered_by ?? 'System')],
                ['key' => 'Note', 'val' => e($log->remarks ?? '—')],
            ],
            'payload' => json_encode([
                'event'           => 'order.status_changed',
                'order_id'        => $log->order_id,
                'previous_status' => $log->previous_status,
                'new_status'      => $log->status,
                'triggered_by'    => $log->triggered_by,
                'timestamp'       => $log->created_at->toIso8601String(),
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
        ];
    }
@endphp

@php
    $apiLogDetailData = [];
    foreach ($apiLogs as $log) {
        $apiLogDetailData[$log->id] = [
            'title' => 'API Log — ' . $log->method . ' ' . $log->endpoint,
            'rows' => [
                ['key' => 'Log ID', 'val' => 'A' . $log->id],
                ['key' => 'Timestamp', 'val' => $log->created_at->format('d M Y, h:i:s A')],
                ['key' => 'Method', 'val' => e($log->method)],
                ['key' => 'Endpoint', 'val' => e($log->endpoint)],
                ['key' => 'Service', 'val' => e($log->service)],
                ['key' => 'HTTP Status', 'val' => e($log->status_code ?? '—')],
                ['key' => 'Response Time', 'val' => $log->response_time_ms !== null ? $log->response_time_ms . ' ms' : '—'],
                ['key' => 'IP', 'val' => e($log->ip_address ?? '—')],
                ['key' => 'Error', 'val' => e($log->error_message ?? '—')],
            ],
            'payload' => "// REQUEST\n" . json_encode($log->request_payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
                . "\n\n// RESPONSE\n" . json_encode($log->response_payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
        ];
    }
@endphp

<script>
    const emailLogDetailData = @json($emailLogDetailData);
    const paymentLogDetailData = @json($paymentLogDetailData);
    const authLogDetailData = @json($authLogDetailData);
    const orderEventDetailData = @json($orderEventDetailData);
    const apiLogDetailData = @json($apiLogDetailData);
</script>

<script>
    // ── Tab switching ──
    function switchTab(name, btn) {
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
        btn.classList.add('active');
        document.getElementById('tab-' + name).classList.add('active');
    }

    function switchLogTab(name, card) {
        document.querySelectorAll('.stat-card').forEach(c => c.classList.remove('active'));
        card.classList.add('active');
        const tabBtn = [...document.querySelectorAll('.tab-btn')].find(b =>
            b.getAttribute('onclick')?.includes("'" + name + "'")
        );
        if (tabBtn) switchTab(name, tabBtn);
    }

    // Auto-open the relevant tab if filtering it (page reload from the filter form)
document.addEventListener('DOMContentLoaded', function () {
    const params = new URLSearchParams(window.location.search);
    let hasEmailParam = false, hasPaymentParam = false, hasAuthParam = false, hasOrderParam = false, hasApiParam = false, hasAllParam = false;
for (const key of params.keys()) {
    if (key.startsWith('email_')) hasEmailParam = true;
    if (key.startsWith('payment_')) hasPaymentParam = true;
    if (key.startsWith('auth_')) hasAuthParam = true;
    if (key.startsWith('order_')) hasOrderParam = true;
    if (key.startsWith('api_')) hasApiParam = true;
    if (key.startsWith('all_')) hasAllParam = true;
}
if (hasAllParam || window.location.hash === '#tab-all') {
    const btn = [...document.querySelectorAll('.tab-btn')].find(b => b.getAttribute('onclick')?.includes("'all'"));
    if (btn) switchTab('all', btn);
}
   
    if (hasEmailParam || window.location.hash === '#tab-email') {
        const btn = [...document.querySelectorAll('.tab-btn')].find(b => b.getAttribute('onclick')?.includes("'email'"));
        if (btn) switchTab('email', btn);
    }
    if (hasPaymentParam || window.location.hash === '#tab-payment') {
        const btn = [...document.querySelectorAll('.tab-btn')].find(b => b.getAttribute('onclick')?.includes("'payment'"));
        if (btn) switchTab('payment', btn);
    }
    if (hasAuthParam || window.location.hash === '#tab-auth') {
        const btn = [...document.querySelectorAll('.tab-btn')].find(b => b.getAttribute('onclick')?.includes("'auth'"));
        if (btn) switchTab('auth', btn);
    }
    if (hasOrderParam || window.location.hash === '#tab-order') {
        const btn = [...document.querySelectorAll('.tab-btn')].find(b => b.getAttribute('onclick')?.includes("'order'"));
        if (btn) switchTab('order', btn);
    }
    if (hasApiParam || window.location.hash === '#tab-api') {
        const btn = [...document.querySelectorAll('.tab-btn')].find(b => b.getAttribute('onclick')?.includes("'api'"));
        if (btn) switchTab('api', btn);
    }
});

    // ── Export dropdown ──
    function toggleExport() {
        document.getElementById('exportMenu').classList.toggle('open');
    }

    document.addEventListener('click', function(e) {
        if (!document.getElementById('exportWrap')?.contains(e.target)) {
            document.getElementById('exportMenu')?.classList.remove('open');
        }
    });

    // ── Purge logs ──
    function confirmPurge() {
        Swal.fire({
            title: 'Purge Old Logs?',
            html: `<div style="text-align:left;font-size:13.5px;color:#6d7175">
                       Select how old logs should be purged:<br><br>
                       <select id="purgeAge" style="width:100%;height:36px;border:1px solid #e3e5e8;border-radius:8px;padding:0 10px;font-size:13px;outline:none">
                           <option value="30">Older than 30 days</option>
                           <option value="60">Older than 60 days</option>
                           <option value="90">Older than 90 days</option>
                           <option value="180">Older than 6 months</option>
                       </select>
                   </div>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#b22222',
            cancelButtonColor: '#6d7175',
            confirmButtonText: 'Yes, Purge',
        }).then(r => {
            if (r.isConfirmed) {
                Swal.fire({ icon:'success', title:'Logs Purged', text:'Old logs have been removed successfully.', timer:2000, showConfirmButton:false });
            }
        });
    }

    // ── Log detail modal ──
    const logDetailData = {
        // SMS / Delivery / WhatsApp demo entries removed along with their tabs
        // (commented out above) — re-add here if those integrations come back.
    };

function openLogDetail(type, id) {
    let data;

    if (type === 'email') {
        data = id && emailLogDetailData[id] ? emailLogDetailData[id] : null;
    } else if (type === 'payment') {
        data = id && paymentLogDetailData[id] ? paymentLogDetailData[id] : null;
    } else if (type === 'auth') {
        data = id && authLogDetailData[id] ? authLogDetailData[id] : null;
    } else if (type === 'order') {
        data = id && orderEventDetailData[id] ? orderEventDetailData[id] : null;
    } else if (type === 'api') {
        data = id && apiLogDetailData[id] ? apiLogDetailData[id] : null;
    } else {
        data = logDetailData[type];
    }
    if (!data) return;

        document.getElementById('logModalTitle').innerHTML =
            `<i class="fa fa-circle-info" style="color:var(--accent);margin-right:6px"></i> ${data.title}`;

        let html = data.rows.map(r => `
            <div class="log-detail-row">
                <div class="log-detail-key">${r.key}</div>
                <div class="log-detail-val">${r.val}</div>
            </div>
        `).join('');

        html += `
            <div style="margin-top:16px">
                <div style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.04em;color:var(--text-hint);margin-bottom:8px">
                    Request / Response Payload
                </div>
                <div class="log-payload">${escapeHtml(data.payload)}</div>
            </div>
        `;

        document.getElementById('logModalBody').innerHTML = html;
        document.getElementById('logModalOverlay').classList.add('open');
    }

    function closeLogDetail(e) {
        if (e.target === document.getElementById('logModalOverlay')) {
            document.getElementById('logModalOverlay').classList.remove('open');
        }
    }

    function escapeHtml(str) {
        return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
    }
</script>