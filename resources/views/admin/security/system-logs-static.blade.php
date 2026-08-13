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
                    <div class="stat-value">14,820</div>
                    <div class="stat-sub">Last 30 days</div>
                </div>

                <div class="stat-card" onclick="switchLogTab('payment', this)">
                    <div class="stat-card-top">
                        <div class="stat-label">Payment</div>
                        <div class="stat-icon green"><i class="fa fa-credit-card"></i></div>
                    </div>
                    <div class="stat-value">3,241</div>
                    <div class="stat-sub"><span style="color:var(--red)">18 failed</span></div>
                </div>

                <div class="stat-card" onclick="switchLogTab('delivery', this)">
                    <div class="stat-card-top">
                        <div class="stat-label">Delivery</div>
                        <div class="stat-icon blue"><i class="fa fa-truck"></i></div>
                    </div>
                    <div class="stat-value">2,108</div>
                    <div class="stat-sub"><span style="color:var(--amber)">34 warnings</span></div>
                </div>

                <div class="stat-card" onclick="switchLogTab('sms', this)">
                    <div class="stat-card-top">
                        <div class="stat-label">SMS</div>
                        <div class="stat-icon amber"><i class="fa fa-message"></i></div>
                    </div>
                    <div class="stat-value">4,560</div>
                    <div class="stat-sub"><span style="color:var(--red)">12 failed</span></div>
                </div>

                <div class="stat-card" onclick="switchLogTab('email', this)">
                    <div class="stat-card-top">
                        <div class="stat-label">Email</div>
                        <div class="stat-icon red"><i class="fa fa-envelope"></i></div>
                    </div>
                    <div class="stat-value">3,890</div>
                    <div class="stat-sub"><span style="color:var(--red)">7 bounced</span></div>
                </div>

                <div class="stat-card" onclick="switchLogTab('whatsapp', this)">
                    <div class="stat-card-top">
                        <div class="stat-label">WhatsApp</div>
                        <div class="stat-icon pink"><i class="fa-brands fa-whatsapp"></i></div>
                    </div>
                    <div class="stat-value">1,021</div>
                    <div class="stat-sub"><span style="color:var(--red)">3 failed</span></div>
                </div>

            </div>

            <!-- ── Tab shell ── -->
            <div class="tab-shell">

                <div class="tab-nav" id="logTabNav">
                    <button class="tab-btn active" onclick="switchTab('all', this)">
                        <i class="fa fa-layer-group"></i> All Logs
                        <span class="tab-count">14,820</span>
                    </button>
                    <button class="tab-btn" onclick="switchTab('payment', this)">
                        <i class="fa fa-credit-card"></i> Payment
                        <span class="tab-count red">18</span>
                    </button>
                    <button class="tab-btn" onclick="switchTab('delivery', this)">
                        <i class="fa fa-truck"></i> Delivery
                        <span class="tab-count">2,108</span>
                    </button>
                    <button class="tab-btn" onclick="switchTab('sms', this)">
                        <i class="fa fa-message"></i> SMS
                        <span class="tab-count red">12</span>
                    </button>
                    <button class="tab-btn" onclick="switchTab('email', this)">
                        <i class="fa fa-envelope"></i> Email
                        <span class="tab-count red">7</span>
                    </button>
                    <button class="tab-btn" onclick="switchTab('whatsapp', this)">
                        <i class="fa-brands fa-whatsapp"></i> WhatsApp
                        <span class="tab-count red">3</span>
                    </button>
                    <button class="tab-btn" onclick="switchTab('api', this)">
                        <i class="fa fa-code"></i> API
                        <span class="tab-count">892</span>
                    </button>
                    <button class="tab-btn" onclick="switchTab('order', this)">
                        <i class="fa fa-box"></i> Order Events
                        <span class="tab-count">1,340</span>
                    </button>
                    <button class="tab-btn" onclick="switchTab('auth', this)">
                        <i class="fa fa-shield-halved"></i> Auth / Login
                        <span class="tab-count">668</span>
                    </button>
                </div>

                <!-- ════════════════════════════
                     ALL LOGS TAB
                ════════════════════════════ -->
                <div class="tab-panel active" id="tab-all">
                    <div class="filter-bar">
                        <div class="filter-row">
                            <div class="filter-group">
                                <label>Level</label>
                                <select class="filter-control">
                                    <option value="">All Levels</option>
                                    <option>Success</option>
                                    <option>Info</option>
                                    <option>Warning</option>
                                    <option>Error</option>
                                </select>
                            </div>
                            <div class="filter-group">
                                <label>Channel</label>
                                <select class="filter-control">
                                    <option value="">All Channels</option>
                                    <option>Payment</option>
                                    <option>Delivery</option>
                                    <option>SMS</option>
                                    <option>Email</option>
                                    <option>WhatsApp</option>
                                    <option>API</option>
                                    <option>Order</option>
                                    <option>Auth</option>
                                </select>
                            </div>
                            <div class="filter-group">
                                <label>Date From</label>
                                <input type="date" class="filter-control">
                            </div>
                            <div class="filter-group">
                                <label>Date To</label>
                                <input type="date" class="filter-control">
                            </div>
                            <div class="filter-search-wrap">
                                <i class="fa fa-search"></i>
                                <input type="text" class="filter-control" placeholder="Search message, order ID, user…">
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
                                    <th>Channel</th>
                                    <th>Level</th>
                                    <th>Message</th>
                                    <th>Reference</th>
                                    <th>IP / User</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span class="id-chip">10821</span></td>
                                    <td style="font-size:12px;white-space:nowrap">25 Jun 2025<br><span style="color:var(--text-hint)">11:42:08</span></td>
                                    <td><span class="badge badge-info">Payment</span></td>
                                    <td><span class="badge badge-success">Success</span></td>
                                    <td class="log-msg">Razorpay payment captured<small>Order #10482 · ₹2,450.00</small></td>
                                    <td><span class="mono">pay_QxZ8k2mN9</span></td>
                                    <td style="font-size:12px;color:var(--text-hint)">103.21.x.x<br>Rahul Sharma</td>
                                    <td><button class="action-btn" onclick="openLogDetail('payment')" title="View Details"><i class="fa fa-eye"></i></button></td>
                                </tr>
                                <tr>
                                    <td><span class="id-chip">10820</span></td>
                                    <td style="font-size:12px;white-space:nowrap">25 Jun 2025<br><span style="color:var(--text-hint)">11:40:55</span></td>
                                    <td><span class="badge badge-info">SMS</span></td>
                                    <td><span class="badge badge-failed">Error</span></td>
                                    <td class="log-msg">MSG91 delivery failed — DLT template mismatch<small>To: +91 98765 43210</small></td>
                                    <td><span class="mono">sms_ERR_4421</span></td>
                                    <td style="font-size:12px;color:var(--text-hint)">System<br>Auto</td>
                                    <td><button class="action-btn" onclick="openLogDetail('sms')" title="View Details"><i class="fa fa-eye"></i></button></td>
                                </tr>
                                <tr>
                                    <td><span class="id-chip">10819</span></td>
                                    <td style="font-size:12px;white-space:nowrap">25 Jun 2025<br><span style="color:var(--text-hint)">11:38:12</span></td>
                                    <td><span class="badge badge-info">Delivery</span></td>
                                    <td><span class="badge badge-success">Success</span></td>
                                    <td class="log-msg">Shiprocket AWB assigned<small>Order #10481 · AWB: 1234567890</small></td>
                                    <td><span class="mono">AWB_1234567890</span></td>
                                    <td style="font-size:12px;color:var(--text-hint)">System<br>Auto</td>
                                    <td><button class="action-btn" onclick="openLogDetail('delivery')" title="View Details"><i class="fa fa-eye"></i></button></td>
                                </tr>
                                <tr>
                                    <td><span class="id-chip">10818</span></td>
                                    <td style="font-size:12px;white-space:nowrap">25 Jun 2025<br><span style="color:var(--text-hint)">11:35:04</span></td>
                                    <td><span class="badge badge-info">Email</span></td>
                                    <td><span class="badge badge-warning">Warning</span></td>
                                    <td class="log-msg">SMTP soft bounce — mailbox full<small>To: priya@example.com</small></td>
                                    <td><span class="mono">msg_7X9KpQ2</span></td>
                                    <td style="font-size:12px;color:var(--text-hint)">System<br>Auto</td>
                                    <td><button class="action-btn" onclick="openLogDetail('email')" title="View Details"><i class="fa fa-eye"></i></button></td>
                                </tr>
                                <tr>
                                    <td><span class="id-chip">10817</span></td>
                                    <td style="font-size:12px;white-space:nowrap">25 Jun 2025<br><span style="color:var(--text-hint)">11:32:48</span></td>
                                    <td><span class="badge badge-info">WhatsApp</span></td>
                                    <td><span class="badge badge-success">Success</span></td>
                                    <td class="log-msg">Order confirmation sent via Meta Cloud API<small>To: +91 91234 56789 · Order #10480</small></td>
                                    <td><span class="mono">wamid.HBg_8K</span></td>
                                    <td style="font-size:12px;color:var(--text-hint)">System<br>Auto</td>
                                    <td><button class="action-btn" onclick="openLogDetail('whatsapp')" title="View Details"><i class="fa fa-eye"></i></button></td>
                                </tr>
                                <tr>
                                    <td><span class="id-chip">10816</span></td>
                                    <td style="font-size:12px;white-space:nowrap">25 Jun 2025<br><span style="color:var(--text-hint)">11:29:11</span></td>
                                    <td><span class="badge badge-info">Auth</span></td>
                                    <td><span class="badge badge-failed">Error</span></td>
                                    <td class="log-msg">Admin login failed — invalid password<small>3 consecutive failed attempts</small></td>
                                    <td><span class="mono">auth_FAIL_292</span></td>
                                    <td style="font-size:12px;color:var(--text-hint)">185.22.x.x<br>Unknown</td>
                                    <td><button class="action-btn" onclick="openLogDetail('auth')" title="View Details"><i class="fa fa-eye"></i></button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="log-pagination">
    <span class="pag-info">Showing 1–20 of 14,820 logs</span>
    <div>
        @isset($logs)
            {{ $logs->links('pagination::bootstrap-4') }}
        @endisset
    </div>
</div>
                </div>

                <!-- ════════════════════════════
                     PAYMENT LOGS TAB
                ════════════════════════════ -->
                <div class="tab-panel" id="tab-payment">
                    <div class="filter-bar">
                        <div class="filter-row">
                            <div class="filter-group">
                                <label>Status</label>
                                <select class="filter-control">
                                    <option value="">All</option>
                                    <option>Captured</option>
                                    <option>Failed</option>
                                    <option>Refunded</option>
                                    <option>Pending</option>
                                </select>
                            </div>
                            <div class="filter-group">
                                <label>Gateway</label>
                                <select class="filter-control">
                                    <option value="">All</option>
                                    <option>Razorpay</option>
                                    <option>Stripe</option>
                                    <option>COD</option>
                                </select>
                            </div>
                            <div class="filter-group">
                                <label>Date From</label>
                                <input type="date" class="filter-control">
                            </div>
                            <div class="filter-group">
                                <label>Date To</label>
                                <input type="date" class="filter-control">
                            </div>
                            <div class="filter-search-wrap">
                                <i class="fa fa-search"></i>
                                <input type="text" class="filter-control" placeholder="Search order ID, payment ID…">
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
                                <tr>
                                    <td><span class="id-chip">P4821</span></td>
                                    <td style="font-size:12px;white-space:nowrap">25 Jun 2025<br><span style="color:var(--text-hint)">11:42:08</span></td>
                                    <td><a href="#" style="color:var(--accent);font-weight:600;font-size:13px">#10482</a></td>
                                    <td><span class="mono">pay_QxZ8k2mN9</span></td>
                                    <td>Razorpay</td>
                                    <td style="font-weight:700">₹2,450.00</td>
                                    <td>UPI</td>
                                    <td><span class="badge badge-success">Captured</span></td>
                                    <td style="font-size:12.5px">Rahul Sharma</td>
                                    <td><button class="action-btn" onclick="openLogDetail('payment')" title="View"><i class="fa fa-eye"></i></button></td>
                                </tr>
                                <tr>
                                    <td><span class="id-chip">P4820</span></td>
                                    <td style="font-size:12px;white-space:nowrap">25 Jun 2025<br><span style="color:var(--text-hint)">11:28:33</span></td>
                                    <td><a href="#" style="color:var(--accent);font-weight:600;font-size:13px">#10479</a></td>
                                    <td><span class="mono">pay_ERR_9912</span></td>
                                    <td>Razorpay</td>
                                    <td style="font-weight:700">₹1,200.00</td>
                                    <td>Card</td>
                                    <td><span class="badge badge-failed">Failed</span></td>
                                    <td style="font-size:12.5px">Priya Nair</td>
                                    <td><button class="action-btn" onclick="openLogDetail('payment')" title="View"><i class="fa fa-eye"></i></button></td>
                                </tr>
                                <tr>
                                    <td><span class="id-chip">P4819</span></td>
                                    <td style="font-size:12px;white-space:nowrap">25 Jun 2025<br><span style="color:var(--text-hint)">10:54:17</span></td>
                                    <td><a href="#" style="color:var(--accent);font-weight:600;font-size:13px">#10476</a></td>
                                    <td><span class="mono">rfnd_7KLm3xP</span></td>
                                    <td>Razorpay</td>
                                    <td style="font-weight:700">₹800.00</td>
                                    <td>Refund</td>
                                    <td><span class="badge badge-info">Refunded</span></td>
                                    <td style="font-size:12.5px">Amit Verma</td>
                                    <td><button class="action-btn" onclick="openLogDetail('payment')" title="View"><i class="fa fa-eye"></i></button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="log-pagination">
                        <span class="pag-info">Showing 1–20 of 3,241 logs &nbsp;·&nbsp; <span style="color:var(--red);font-weight:600">18 failed</span></span>
                        <div></div>
                    </div>
                </div>

                <!-- ════════════════════════════
                     DELIVERY LOGS TAB
                ════════════════════════════ -->
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

                <!-- ════════════════════════════
                     SMS LOGS TAB
                ════════════════════════════ -->
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

                <!-- ════════════════════════════
                     EMAIL LOGS TAB
                ════════════════════════════ -->
                <div class="tab-panel" id="tab-email">
                    <div class="filter-bar">
                        <div class="filter-row">
                            <div class="filter-group">
                                <label>Status</label>
                                <select class="filter-control">
                                    <option>All</option>
                                    <option>Sent</option>
                                    <option>Delivered</option>
                                    <option>Bounced</option>
                                    <option>Failed</option>
                                    <option>Opened</option>
                                </select>
                            </div>
                            <div class="filter-group">
                                <label>Template</label>
                                <select class="filter-control">
                                    <option>All Templates</option>
                                    <option>Order Confirmation</option>
                                    <option>Invoice</option>
                                    <option>Shipping Update</option>
                                    <option>Password Reset</option>
                                    <option>Welcome</option>
                                </select>
                            </div>
                            <div class="filter-search-wrap">
                                <i class="fa fa-search"></i>
                                <input type="text" class="filter-control" placeholder="Search email address, subject…">
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
                                    <th>To</th>
                                    <th>Subject</th>
                                    <th>Template</th>
                                    <th>SMTP</th>
                                    <th>Message ID</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span class="id-chip">E3890</span></td>
                                    <td style="font-size:12px;white-space:nowrap">25 Jun 2025<br><span style="color:var(--text-hint)">11:43:05</span></td>
                                    <td style="font-size:12.5px">rahul@example.com</td>
                                    <td class="log-msg">Order Confirmed — #10482<small>With invoice attached</small></td>
                                    <td>Order Confirmation</td>
                                    <td style="font-size:12.5px">Mailgun</td>
                                    <td><span class="mono">&lt;msg_8Xk2@mg&gt;</span></td>
                                    <td><span class="badge badge-success">Delivered</span></td>
                                    <td><button class="action-btn" onclick="openLogDetail('email')" title="View"><i class="fa fa-eye"></i></button></td>
                                </tr>
                                <tr>
                                    <td><span class="id-chip">E3889</span></td>
                                    <td style="font-size:12px;white-space:nowrap">25 Jun 2025<br><span style="color:var(--text-hint)">11:35:04</span></td>
                                    <td style="font-size:12.5px">priya@example.com</td>
                                    <td class="log-msg">Your order has been shipped!<small>Tracking link included</small></td>
                                    <td>Shipping Update</td>
                                    <td style="font-size:12.5px">Mailgun</td>
                                    <td><span class="mono">&lt;msg_7X9KpQ2@mg&gt;</span></td>
                                    <td><span class="badge badge-warning">Bounced</span></td>
                                    <td><button class="action-btn" onclick="openLogDetail('email')" title="View"><i class="fa fa-eye"></i></button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="log-pagination">
                        <span class="pag-info">Showing 1–20 of 3,890 logs &nbsp;·&nbsp; <span style="color:var(--red);font-weight:600">7 bounced</span></span>
                        <div></div>
                    </div>
                </div>

                <!-- ════════════════════════════
                     WHATSAPP LOGS TAB
                ════════════════════════════ -->
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

                <!-- ════════════════════════════
                     API LOGS TAB
                ════════════════════════════ -->
                <div class="tab-panel" id="tab-api">
                    <div class="filter-bar">
                        <div class="filter-row">
                            <div class="filter-group">
                                <label>Method</label>
                                <select class="filter-control">
                                    <option>All</option>
                                    <option>GET</option>
                                    <option>POST</option>
                                    <option>PUT</option>
                                    <option>DELETE</option>
                                </select>
                            </div>
                            <div class="filter-group">
                                <label>HTTP Status</label>
                                <select class="filter-control">
                                    <option>All</option>
                                    <option>2xx Success</option>
                                    <option>4xx Client Error</option>
                                    <option>5xx Server Error</option>
                                </select>
                            </div>
                            <div class="filter-group">
                                <label>Service</label>
                                <select class="filter-control">
                                    <option>All</option>
                                    <option>Razorpay</option>
                                    <option>Shiprocket</option>
                                    <option>MSG91</option>
                                    <option>Meta WhatsApp</option>
                                    <option>Internal API</option>
                                </select>
                            </div>
                            <div class="filter-search-wrap">
                                <i class="fa fa-search"></i>
                                <input type="text" class="filter-control" placeholder="Search endpoint, IP…">
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
                                <tr>
                                    <td><span class="id-chip">A892</span></td>
                                    <td style="font-size:12px;white-space:nowrap">25 Jun 2025<br><span style="color:var(--text-hint)">11:42:06</span></td>
                                    <td><span style="background:#e3f1ec;color:#007a5e;padding:2px 8px;border-radius:5px;font-size:11.5px;font-weight:700">POST</span></td>
                                    <td><span class="mono">/v1/payments/capture</span></td>
                                    <td>Razorpay</td>
                                    <td><span style="background:#e3f1ec;color:#007a5e;padding:2px 8px;border-radius:5px;font-size:12px;font-weight:700">200</span></td>
                                    <td style="font-size:12.5px;color:var(--text-hint)">342 ms</td>
                                    <td class="mono">103.21.x.x</td>
                                    <td><button class="action-btn" onclick="openLogDetail('api')" title="View"><i class="fa fa-eye"></i></button></td>
                                </tr>
                                <tr>
                                    <td><span class="id-chip">A891</span></td>
                                    <td style="font-size:12px;white-space:nowrap">25 Jun 2025<br><span style="color:var(--text-hint)">11:38:10</span></td>
                                    <td><span style="background:#e3f1ec;color:#007a5e;padding:2px 8px;border-radius:5px;font-size:11.5px;font-weight:700">POST</span></td>
                                    <td><span class="mono">/v1/orders/create</span></td>
                                    <td>Shiprocket</td>
                                    <td><span style="background:#e3f1ec;color:#007a5e;padding:2px 8px;border-radius:5px;font-size:12px;font-weight:700">201</span></td>
                                    <td style="font-size:12.5px;color:var(--text-hint)">518 ms</td>
                                    <td class="mono">System</td>
                                    <td><button class="action-btn" onclick="openLogDetail('api')" title="View"><i class="fa fa-eye"></i></button></td>
                                </tr>
                                <tr>
                                    <td><span class="id-chip">A890</span></td>
                                    <td style="font-size:12px;white-space:nowrap">25 Jun 2025<br><span style="color:var(--text-hint)">11:29:08</span></td>
                                    <td><span style="background:#e8f2ff;color:#0069d9;padding:2px 8px;border-radius:5px;font-size:11.5px;font-weight:700">GET</span></td>
                                    <td><span class="mono">/api/products?page=2</span></td>
                                    <td>Internal API</td>
                                    <td><span style="background:#fce8e8;color:#b22222;padding:2px 8px;border-radius:5px;font-size:12px;font-weight:700">429</span></td>
                                    <td style="font-size:12.5px;color:var(--text-hint)">12 ms</td>
                                    <td class="mono">185.22.x.x</td>
                                    <td><button class="action-btn" onclick="openLogDetail('api')" title="View"><i class="fa fa-eye"></i></button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="log-pagination">
                        <span class="pag-info">Showing 1–20 of 892 logs</span>
                        <div></div>
                    </div>
                </div>

                <!-- ════════════════════════════
                     ORDER EVENTS TAB
                ════════════════════════════ -->
                <div class="tab-panel" id="tab-order">
                    <div class="filter-bar">
                        <div class="filter-row">
                            <div class="filter-group">
                                <label>Event</label>
                                <select class="filter-control">
                                    <option>All Events</option>
                                    <option>Order Placed</option>
                                    <option>Payment Received</option>
                                    <option>Processing</option>
                                    <option>Shipped</option>
                                    <option>Delivered</option>
                                    <option>Cancelled</option>
                                    <option>Refunded</option>
                                </select>
                            </div>
                            <div class="filter-search-wrap">
                                <i class="fa fa-search"></i>
                                <input type="text" class="filter-control" placeholder="Search order ID, customer…">
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
                                    <th>Event</th>
                                    <th>Previous Status</th>
                                    <th>New Status</th>
                                    <th>Triggered By</th>
                                    <th>Note</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span class="id-chip">O1340</span></td>
                                    <td style="font-size:12px;white-space:nowrap">25 Jun 2025<br><span style="color:var(--text-hint)">11:42:10</span></td>
                                    <td><a href="#" style="color:var(--accent);font-weight:600">#10482</a></td>
                                    <td><span class="badge badge-success">Payment Received</span></td>
                                    <td style="color:var(--text-hint);font-size:12.5px">Pending</td>
                                    <td style="font-weight:600;font-size:12.5px">Processing</td>
                                    <td style="font-size:12.5px">Razorpay Webhook</td>
                                    <td style="font-size:12.5px;color:var(--text-hint)">Auto</td>
                                    <td><button class="action-btn" onclick="openLogDetail('order')" title="View"><i class="fa fa-eye"></i></button></td>
                                </tr>
                                <tr>
                                    <td><span class="id-chip">O1339</span></td>
                                    <td style="font-size:12px;white-space:nowrap">25 Jun 2025<br><span style="color:var(--text-hint)">10:15:22</span></td>
                                    <td><a href="#" style="color:var(--accent);font-weight:600">#10478</a></td>
                                    <td><span class="badge badge-failed">Cancelled</span></td>
                                    <td style="color:var(--text-hint);font-size:12.5px">Processing</td>
                                    <td style="font-weight:600;font-size:12.5px;color:var(--red)">Cancelled</td>
                                    <td style="font-size:12.5px">Admin (You)</td>
                                    <td style="font-size:12.5px;color:var(--text-hint)">Customer request</td>
                                    <td><button class="action-btn" onclick="openLogDetail('order')" title="View"><i class="fa fa-eye"></i></button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="log-pagination">
                        <span class="pag-info">Showing 1–20 of 1,340 logs</span>
                        <div></div>
                    </div>
                </div>

                <!-- ════════════════════════════
                     AUTH / LOGIN LOGS TAB
                ════════════════════════════ -->
                <div class="tab-panel" id="tab-auth">
                    <div class="filter-bar">
                        <div class="filter-row">
                            <div class="filter-group">
                                <label>Event</label>
                                <select class="filter-control">
                                    <option>All</option>
                                    <option>Login Success</option>
                                    <option>Login Failed</option>
                                    <option>Logout</option>
                                    <option>Password Reset</option>
                                    <option>2FA</option>
                                </select>
                            </div>
                            <div class="filter-group">
                                <label>User Type</label>
                                <select class="filter-control">
                                    <option>All</option>
                                    <option>Admin</option>
                                    <option>Customer</option>
                                </select>
                            </div>
                            <div class="filter-search-wrap">
                                <i class="fa fa-search"></i>
                                <input type="text" class="filter-control" placeholder="Search IP, email, user…">
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
                                <tr>
                                    <td><span class="id-chip">A668</span></td>
                                    <td style="font-size:12px;white-space:nowrap">25 Jun 2025<br><span style="color:var(--text-hint)">11:30:00</span></td>
                                    <td style="font-size:12.5px">admin@mystore.com</td>
                                    <td><span class="badge badge-info">Admin</span></td>
                                    <td>Login</td>
                                    <td class="mono">103.21.44.x</td>
                                    <td style="font-size:12px;color:var(--text-hint)">Chrome 124 · Windows</td>
                                    <td><span class="badge badge-success">Success</span></td>
                                    <td><button class="action-btn" onclick="openLogDetail('auth')" title="View"><i class="fa fa-eye"></i></button></td>
                                </tr>
                                <tr>
                                    <td><span class="id-chip">A667</span></td>
                                    <td style="font-size:12px;white-space:nowrap">25 Jun 2025<br><span style="color:var(--text-hint)">11:29:11</span></td>
                                    <td style="font-size:12.5px">admin@mystore.com</td>
                                    <td><span class="badge badge-info">Admin</span></td>
                                    <td>Login Attempt</td>
                                    <td class="mono">185.22.11.x</td>
                                    <td style="font-size:12px;color:var(--text-hint)">Unknown · Unknown</td>
                                    <td><span class="badge badge-failed">Failed ×3</span></td>
                                    <td><button class="action-btn" onclick="openLogDetail('auth')" title="View"><i class="fa fa-eye"></i></button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="log-pagination">
                        <span class="pag-info">Showing 1–20 of 668 logs</span>
                        <div></div>
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
        payment: {
            title: 'Payment Log — pay_QxZ8k2mN9',
            rows: [
                { key:'Log ID',       val:'P4821' },
                { key:'Timestamp',    val:'25 Jun 2025, 11:42:08 AM' },
                { key:'Order ID',     val:'#10482' },
                { key:'Payment ID',   val:'pay_QxZ8k2mN9' },
                { key:'Gateway',      val:'Razorpay' },
                { key:'Amount',       val:'₹2,450.00' },
                { key:'Method',       val:'UPI — Google Pay' },
                { key:'Status',       val:'<span class="badge badge-success">Captured</span>' },
                { key:'Customer',     val:'Rahul Sharma &lt;rahul@example.com&gt;' },
                { key:'IP Address',   val:'103.21.44.182' },
            ],
            payload: `{
  "entity": "payment",
  "id": "pay_QxZ8k2mN9",
  "amount": 245000,
  "currency": "INR",
  "status": "captured",
  "order_id": "order_QxZ7hNm2K",
  "method": "upi",
  "vpa": "rahul@okaxis",
  "email": "rahul@example.com",
  "contact": "+919876543210",
  "fee": 2499,
  "tax": 382,
  "created_at": 1750847528
}`
        },
        sms: {
            title: 'SMS Log — sms_ERR_4421',
            rows: [
                { key:'Log ID',       val:'S4559' },
                { key:'Timestamp',    val:'25 Jun 2025, 11:40:55 AM' },
                { key:'Provider',     val:'MSG91' },
                { key:'Mobile',       val:'+91 98765 43210' },
                { key:'Event',        val:'OTP Verification' },
                { key:'DLT Template', val:'tmpl_OTP_01' },
                { key:'Status',       val:'<span class="badge badge-failed">Failed</span>' },
                { key:'Error',        val:'DLT template mismatch — template not registered on TRAI portal' },
                { key:'Reference',    val:'sms_ERR_4421' },
            ],
            payload: `{
  "provider": "msg91",
  "mobile": "919876543210",
  "template_id": "tmpl_OTP_01",
  "route": "4",
  "error_code": "E_DLT_MISMATCH",
  "error_message": "DLT template not found or content mismatch",
  "request_time": "2025-06-25T11:40:55Z",
  "response_code": 400
}`
        },
        delivery: {
            title: 'Delivery Log — AWB 1234567890',
            rows: [
                { key:'Log ID',      val:'D2108' },
                { key:'Timestamp',   val:'25 Jun 2025, 11:38:12 AM' },
                { key:'Order ID',    val:'#10481' },
                { key:'AWB',         val:'1234567890' },
                { key:'Courier',     val:'Shiprocket → Delhivery' },
                { key:'Event',       val:'AWB Assigned' },
                { key:'Status',      val:'<span class="badge badge-success">AWB Assigned</span>' },
                { key:'Pickup City', val:'Mumbai, Maharashtra' },
                { key:'Dest. City',  val:'Pune, Maharashtra' },
            ],
            payload: `{
  "shipment_id": 482901,
  "awb_code": "1234567890",
  "courier_company_id": 3,
  "courier_name": "Delhivery",
  "order_id": "10481",
  "pickup_scheduled_date": "2025-06-26",
  "estimated_delivery_date": "2025-06-28",
  "status": "AWB Assigned",
  "others": { "pickrr_status": "AWB_ASSIGNED" }
}`
        },
        email: {
            title: 'Email Log — Bounced',
            rows: [
                { key:'Log ID',     val:'E3889' },
                { key:'Timestamp',  val:'25 Jun 2025, 11:35:04 AM' },
                { key:'To',         val:'priya@example.com' },
                { key:'Subject',    val:'Your order has been shipped!' },
                { key:'Template',   val:'Shipping Update' },
                { key:'SMTP',       val:'Mailgun' },
                { key:'Message ID', val:'&lt;msg_7X9KpQ2@mg.mystore.com&gt;' },
                { key:'Status',     val:'<span class="badge badge-warning">Soft Bounce</span>' },
                { key:'Reason',     val:'Mailbox full — recipient storage quota exceeded' },
            ],
            payload: `{
  "event": "soft_bounce",
  "recipient": "priya@example.com",
  "message-id": "msg_7X9KpQ2@mg.mystore.com",
  "timestamp": 1750846504,
  "reason": "Mailbox Full",
  "code": 452,
  "description": "4.2.2 The recipient mailbox has exceeded its storage limit"
}`
        },
        whatsapp: {
            title: 'WhatsApp Log — wamid.HBg_8K2mX',
            rows: [
                { key:'Log ID',      val:'W1021' },
                { key:'Timestamp',   val:'25 Jun 2025, 11:43:10 AM' },
                { key:'Provider',    val:'Meta Cloud API' },
                { key:'Mobile',      val:'+91 91234 56789' },
                { key:'Template',    val:'order_confirmation_v2' },
                { key:'WAMID',       val:'wamid.HBg_8K2mXxxxxxxxxxxxxxxxxxx==' },
                { key:'Delivered At',val:'11:43:18 AM' },
                { key:'Read At',     val:'11:44:02 AM' },
                { key:'Status',      val:'<span class="badge badge-success">Read</span>' },
            ],
            payload: `{
  "messaging_product": "whatsapp",
  "to": "919123456789",
  "type": "template",
  "template": {
    "name": "order_confirmation_v2",
    "language": { "code": "en" },
    "components": [
      { "type": "body", "parameters": [
          { "type": "text", "text": "#10480" },
          { "type": "text", "text": "₹1,850.00" }
      ]}
    ]
  },
  "response_wamid": "wamid.HBg_8K2mXxxxxxxxxxxxxxxxxxx=="
}`
        },
        api: {
            title: 'API Log — POST /v1/payments/capture',
            rows: [
                { key:'Log ID',        val:'A892' },
                { key:'Timestamp',     val:'25 Jun 2025, 11:42:06 AM' },
                { key:'Method',        val:'POST' },
                { key:'Endpoint',      val:'/v1/payments/capture' },
                { key:'Service',       val:'Razorpay' },
                { key:'HTTP Status',   val:'200 OK' },
                { key:'Response Time', val:'342 ms' },
                { key:'IP',            val:'103.21.44.182' },
                { key:'User Agent',    val:'GuzzleHttp/7.0 PHP/8.2' },
            ],
            payload: `// REQUEST
POST https://api.razorpay.com/v1/payments/pay_QxZ8k2mN9/capture
Authorization: Basic <base64>
Content-Type: application/json
{ "amount": 245000, "currency": "INR" }

// RESPONSE  200 OK  (342ms)
{
  "id": "pay_QxZ8k2mN9",
  "entity": "payment",
  "status": "captured",
  "amount": 245000,
  "currency": "INR"
}`
        },
        order: {
            title: 'Order Event — #10482 Status Change',
            rows: [
                { key:'Log ID',         val:'O1340' },
                { key:'Timestamp',      val:'25 Jun 2025, 11:42:10 AM' },
                { key:'Order ID',       val:'#10482' },
                { key:'Event',          val:'Payment Received' },
                { key:'Previous Status',val:'Pending' },
                { key:'New Status',     val:'Processing' },
                { key:'Triggered By',   val:'Razorpay Webhook' },
                { key:'Note',           val:'Automatic status update on payment capture' },
            ],
            payload: `{
  "event": "order.status_changed",
  "order_id": 10482,
  "previous_status": "pending",
  "new_status": "processing",
  "triggered_by": "razorpay_webhook",
  "payment_id": "pay_QxZ8k2mN9",
  "timestamp": "2025-06-25T11:42:10Z"
}`
        },
        auth: {
            title: 'Auth Log — Failed Login',
            rows: [
                { key:'Log ID',     val:'A667' },
                { key:'Timestamp',  val:'25 Jun 2025, 11:29:11 AM' },
                { key:'User',       val:'admin@mystore.com' },
                { key:'User Type',  val:'Admin' },
                { key:'Event',      val:'Login Attempt' },
                { key:'IP Address', val:'185.22.11.47' },
                { key:'Country',    val:'Unknown (VPN suspected)' },
                { key:'Browser',    val:'Unknown' },
                { key:'Status',     val:'<span class="badge badge-failed">Failed ×3 — Account flagged</span>' },
            ],
            payload: `{
  "event": "auth.login_failed",
  "email": "admin@mystore.com",
  "ip": "185.22.11.47",
  "user_agent": "curl/7.88.1",
  "attempt_count": 3,
  "lockout_triggered": false,
  "timestamp": "2025-06-25T11:29:11Z",
  "geo": { "country": "Unknown", "isp": "Datacamp Limited" }
}`
        }
    };

    function openLogDetail(type) {
        const data = logDetailData[type];
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
            </div>sh
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