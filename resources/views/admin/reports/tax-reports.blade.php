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
            --radius-sm: 8px;
            --radius-md: 12px;
            --shadow-card: 0 1px 3px rgba(0,0,0,.08), 0 0 0 1px var(--border);
            --font: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        .tax-page {
            background: var(--bg);
            padding: 24px 28px;
            min-height: 100vh;
            font-family: var(--font);
            color: var(--text-primary);
            box-sizing: border-box;
        }

        .tax-page * { box-sizing: border-box; }

        /* ── Page header ── */
        .rp-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 20px;
        }

        .rp-header h1 {
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

        .btn-green {
            display: inline-flex; align-items: center; gap: 6px;
            background: var(--green-bg); color: var(--green) !important;
            border: 1px solid #b0ddd0; border-radius: var(--radius-sm);
            padding: 8px 16px; font-size: 13px; font-weight: 600;
            cursor: pointer; text-decoration: none !important;
            font-family: var(--font); transition: all .15s;
        }
        .btn-green:hover { background: var(--green); color: #fff !important; }

        .btn-amber {
            display: inline-flex; align-items: center; gap: 6px;
            background: var(--amber-bg); color: var(--amber) !important;
            border: 1px solid #f0d060; border-radius: var(--radius-sm);
            padding: 8px 16px; font-size: 13px; font-weight: 600;
            cursor: pointer; text-decoration: none !important;
            font-family: var(--font); transition: all .15s;
        }
        .btn-amber:hover { background: var(--amber); color: #fff !important; }

        /* ── Date range quick pills ── */
        .date-range-bar {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-card);
            padding: 16px 20px;
            margin-bottom: 20px;
            display: flex;
            flex-wrap: wrap;
            align-items: flex-end;
            gap: 16px;
        }

        .range-pills {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }

        .range-pill {
            display: inline-flex;
            align-items: center;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12.5px;
            font-weight: 600;
            border: 1px solid var(--border);
            background: var(--surface);
            color: var(--text-secondary);
            cursor: pointer;
            transition: all .15s;
            font-family: var(--font);
            white-space: nowrap;
        }

        .range-pill:hover {
            border-color: var(--accent);
            color: var(--accent);
            background: var(--accent-light);
        }

        .range-pill.active {
            background: var(--accent);
            color: #fff;
            border-color: var(--accent);
        }

        .range-divider {
            width: 1px;
            height: 36px;
            background: var(--border);
            align-self: center;
        }

        .custom-range-group {
            display: flex;
            align-items: flex-end;
            gap: 8px;
            flex-wrap: wrap;
        }

        .custom-range-group label {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .04em;
            color: var(--text-hint);
            display: block;
            margin-bottom: 4px;
        }

        .filter-control {
            height: 36px;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 0 11px;
            font-size: 13px;
            color: var(--text-primary);
            background: var(--surface);
            outline: none;
            transition: border-color .15s, box-shadow .15s;
            font-family: var(--font);
        }

        .filter-control:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(48,61,137,.12);
        }

        /* ── Stat grid ── */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 14px;
            margin-bottom: 20px;
        }

        @media(max-width:1100px) { .stat-grid { grid-template-columns: repeat(3,1fr); } }
        @media(max-width:640px)  { .stat-grid { grid-template-columns: repeat(2,1fr); } }

        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-card);
            padding: 16px 18px;
        }

        .stat-card-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .stat-label {
            font-size: 11.5px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .04em;
            color: var(--text-hint);
        }

        .stat-icon {
            width: 34px; height: 34px;
            border-radius: var(--radius-sm);
            display: flex; align-items: center; justify-content: center;
            font-size: 14px;
        }

        .stat-icon.purple { background: var(--accent-light); color: var(--accent); }
        .stat-icon.green  { background: var(--green-bg);     color: var(--green); }
        .stat-icon.blue   { background: var(--blue-bg);      color: var(--blue); }
        .stat-icon.amber  { background: var(--amber-bg);     color: var(--amber); }
        .stat-icon.red    { background: var(--red-bg);       color: var(--red); }

        .stat-value {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-primary);
            line-height: 1.1;
        }

        .stat-sub {
            font-size: 11.5px;
            color: var(--text-hint);
            margin-top: 3px;
        }

        /* ── GST breakup band ── */
        .gst-band {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-card);
            padding: 18px 22px;
            margin-bottom: 20px;
        }

        .gst-band-title {
            font-size: 13px;
            font-weight: 650;
            color: var(--text-primary);
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .gst-band-title i { color: var(--accent); font-size: 14px; }

        .gst-slab-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 10px;
        }

        @media(max-width:960px) { .gst-slab-grid { grid-template-columns: repeat(3,1fr); } }
        @media(max-width:540px) { .gst-slab-grid { grid-template-columns: repeat(2,1fr); } }

        .gst-slab-card {
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 12px 14px;
            text-align: center;
            background: #fafafa;
        }

        .gst-slab-rate {
            font-size: 18px;
            font-weight: 750;
            color: var(--accent);
            line-height: 1;
        }

        .gst-slab-label {
            font-size: 10.5px;
            text-transform: uppercase;
            letter-spacing: .05em;
            color: var(--text-hint);
            margin: 4px 0 8px;
        }

        .gst-slab-taxable {
            font-size: 12.5px;
            font-weight: 600;
            color: var(--text-secondary);
        }

        .gst-slab-tax {
            font-size: 13px;
            font-weight: 700;
            color: var(--green);
            margin-top: 2px;
        }

        .gst-slab-sub {
            font-size: 10.5px;
            color: var(--text-hint);
            margin-top: 2px;
        }

        /* ── CGST/SGST/IGST split ── */
        .tax-split-bar {
            display: flex;
            gap: 10px;
            margin-top: 14px;
            flex-wrap: wrap;
        }

        .tax-split-chip {
            flex: 1;
            min-width: 120px;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 10px 14px;
            background: var(--surface);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .split-dot {
            width: 10px; height: 10px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .split-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-secondary);
        }

        .split-value {
            font-size: 15px;
            font-weight: 700;
            color: var(--text-primary);
            margin-left: auto;
        }

        /* ── Main card ── */
        .cat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-card);
            overflow: hidden;
            margin-bottom: 20px;
        }

        /* ── Filter bar inside card ── */
        .filter-bar {
            padding: 14px 20px;
            border-bottom: 1px solid var(--border);
            background: #fafafa;
        }

        .filter-row {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            align-items: flex-end;
        }

        .filter-group { display: flex; flex-direction: column; gap: 5px; }

        .filter-group label {
            font-size: 11px;
            font-weight: 600;
            color: var(--text-secondary);
            letter-spacing: .03em;
            text-transform: uppercase;
        }

        .filter-actions { display: flex; gap: 8px; align-items: center; }

        /* ── Table ── */
        .cat-table-wrap { overflow-x: auto; }

        .cat-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            font-family: var(--font);
        }

        .cat-table thead th {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: var(--text-hint);
            padding: 10px 14px;
            border-bottom: 1px solid var(--border);
            background: #fafafa;
            text-align: left;
            white-space: nowrap;
        }

        .cat-table tbody tr {
            border-bottom: 1px solid var(--border);
            transition: background .1s;
        }

        .cat-table tbody tr:last-child { border-bottom: none; }
        .cat-table tbody tr:hover { background: #fafbfc; }

        .cat-table tbody td {
            padding: 11px 14px;
            color: var(--text-primary);
            vertical-align: middle;
        }

        .cat-table tfoot tr {
            background: #f4f5f8;
            border-top: 2px solid var(--border);
        }

        .cat-table tfoot td {
            padding: 12px 14px;
            font-size: 13px;
            font-weight: 700;
            color: var(--text-primary);
        }

        /* ── Pills ── */
        .pill {
            display: inline-flex; align-items: center; gap: 4px;
            font-size: 11.5px; font-weight: 600;
            padding: 3px 9px; border-radius: 20px; white-space: nowrap;
        }

        .pill::before {
            content: ''; width: 5px; height: 5px;
            border-radius: 50%; display: inline-block;
        }

        .pill-active   { background: var(--green-bg); color: var(--green); }
        .pill-active::before { background: var(--green); }
        .pill-igst     { background: var(--blue-bg);  color: var(--blue); }
        .pill-igst::before { background: var(--blue); }
        .pill-cgst     { background: var(--accent-light); color: var(--accent); }
        .pill-cgst::before { background: var(--accent); }

        /* ── ID chip ── */
        .id-chip {
            display: inline-block;
            background: var(--bg); color: var(--text-secondary);
            font-size: 11px; font-weight: 700;
            padding: 2px 7px; border-radius: 6px;
            font-family: 'SF Mono','Fira Code',monospace;
        }

        /* ── Order link ── */
        .order-link {
            color: var(--accent);
            font-weight: 600;
            text-decoration: none;
            font-size: 13px;
        }

        .order-link:hover { text-decoration: underline; }

        /* ── Amount cells ── */
        .amt-green { font-weight: 700; color: var(--green); }
        .amt-muted { color: var(--text-secondary); }

        /* ── Export dropdown ── */
        .export-wrap { position: relative; display: inline-block; }

        .export-menu {
            display: none;
            position: absolute;
            right: 0;
            top: calc(100% + 6px);
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            box-shadow: 0 4px 16px rgba(0,0,0,.1);
            min-width: 180px;
            z-index: 100;
            overflow: hidden;
        }

        .export-menu.open { display: block; }

        .export-menu a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 16px;
            font-size: 13px;
            font-weight: 500;
            color: var(--text-primary);
            text-decoration: none;
            transition: background .1s;
            border-bottom: 1px solid var(--border);
        }

        .export-menu a:last-child { border-bottom: none; }
        .export-menu a:hover { background: var(--bg); }

        .export-menu a i {
            width: 16px;
            text-align: center;
            font-size: 13px;
            color: var(--text-hint);
        }

        /* ── Pagination ── */
        .cat-pagination {
            padding: 14px 20px;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--surface);
            flex-wrap: wrap;
            gap: 8px;
        }

        .pagination-info { font-size: 12.5px; color: var(--text-hint); }

        /* ── Period badge ── */
        .period-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--accent-light);
            border: 1px solid rgba(48,61,137,.18);
            border-radius: 20px;
            padding: 5px 14px;
            font-size: 12.5px;
            font-weight: 600;
            color: var(--accent);
        }

        /* ── CA note banner ── */
        .ca-banner {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 13px 16px;
            background: var(--blue-bg);
            border: 1px solid #b8d4f5;
            border-radius: var(--radius-sm);
            font-size: 13px;
            color: var(--blue);
            margin-bottom: 20px;
        }

        .ca-banner i { font-size: 15px; flex-shrink: 0; margin-top: 1px; }

        @media(max-width:768px) {
            .tax-page { padding: 16px; }
            .filter-row { flex-direction: column; }
            .filter-control { min-width: 100%; }
        }

        @media print {
            .rp-header > div:last-child,
            .date-range-bar,
            .filter-bar,
            .cat-pagination { display: none !important; }
            .tax-page { padding: 0; }
            .cat-card { box-shadow: none; border: 1px solid #ccc; }
        }
    </style>

    <div class="app-content content container-fluid">
        <div class="tax-page">

            <!-- Page header -->
            <div class="rp-header">
                <div>
                    <h1>GST Tax Report</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        GST Tax Report
                    </div>
                </div>

                <div style="display:flex;gap:8px;flex-wrap:wrap;align-items:center">
                    <span class="period-badge">
                        <i class="fa fa-calendar-days"></i>
                        {{ $from->format('d M Y') }} — {{ $to->format('d M Y') }}
                    </span>

                    <div class="export-wrap" id="exportWrap">
                        <button class="btn-amber" onclick="toggleExport()">
                            <i class="fa fa-download"></i> Export <i class="fa fa-chevron-down" style="font-size:10px"></i>
                        </button>
                        <div class="export-menu" id="exportMenu">
                            <a href="#" onclick="window.print();return false">
                                <i class="fa fa-print"></i> Print / PDF
                            </a>
                            <a href="{{ route('admin.reports.tax-reports.export-csv', request()->query()) }}">
                                <i class="fa fa-file-csv"></i> Export CSV
                            </a>
                        </div>
                    </div>

                    <button class="btn-green" onclick="window.print()">
                        <i class="fa fa-share-nodes"></i> Share with CA
                    </button>
                </div>
            </div>

            <!-- ── CA info banner ── -->
            <div class="ca-banner">
                <i class="fa fa-circle-info"></i>
                <div>
                    This report contains order-wise GST breakup including taxable value, CGST, SGST, IGST, and invoice-level totals.
                    Use the date range selector below to generate reports for any filing period (monthly, quarterly, or custom). Export as PDF or CSV to share directly with your Chartered Accountant.
                </div>
            </div>

            <!-- ── Date range bar ── -->
            <div class="date-range-bar">
                <form method="GET" id="rangeForm" style="display:contents">
                    <div>
                        <div style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.04em;color:var(--text-hint);margin-bottom:8px">Quick Range</div>
                        <div class="range-pills">
                            <button type="button" class="range-pill" onclick="setRange(this, 7)">Last 7 Days</button>
                            <button type="button" class="range-pill" onclick="setRange(this, 15)">Last 15 Days</button>
                            <button type="button" class="range-pill" onclick="setRange(this, 30)">Last 30 Days</button>
                            <button type="button" class="range-pill" onclick="setRange(this, 90)">Last 3 Months</button>
                            <button type="button" class="range-pill" onclick="setRange(this, 'month')">This Month</button>
                            <button type="button" class="range-pill" onclick="setRange(this, 'quarter')">This Quarter</button>
                            <button type="button" class="range-pill" onclick="setRange(this, 'fy')">Financial Year</button>
                        </div>
                    </div>

                    <div class="range-divider"></div>

                    <div class="custom-range-group">
                        <div>
                            <label>From Date</label>
                            <input type="date" id="dateFrom" name="date_from" class="filter-control" value="{{ $from->format('Y-m-d') }}">
                        </div>
                        <div>
                            <label>To Date</label>
                            <input type="date" id="dateTo" name="date_to" class="filter-control" value="{{ $to->format('Y-m-d') }}">
                        </div>
                        <button type="submit" class="btn-primary-dash">
                            <i class="fa fa-rotate-right"></i> Apply
                        </button>
                    </div>
                </form>
            </div>

            <!-- ── Summary Stat Cards ── -->
            <div class="stat-grid">

                <div class="stat-card">
                    <div class="stat-card-top">
                        <div class="stat-label">Taxable Value</div>
                        <div class="stat-icon blue"><i class="fa fa-indian-rupee-sign"></i></div>
                    </div>
                    <div class="stat-value">₹{{ number_format($summary->taxable_value ?? 0, 0) }}</div>
                    <div class="stat-sub">Total order value excl. tax</div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-top">
                        <div class="stat-label">Total Tax Collected</div>
                        <div class="stat-icon purple"><i class="fa fa-landmark"></i></div>
                    </div>
                    <div class="stat-value">₹{{ number_format($summary->total_tax ?? 0, 0) }}</div>
                    <div class="stat-sub">CGST + SGST + IGST</div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-top">
                        <div class="stat-label">CGST</div>
                        <div class="stat-icon green"><i class="fa fa-building-columns"></i></div>
                    </div>
                    <div class="stat-value">₹{{ number_format($summary->cgst_total ?? 0, 0) }}</div>
                    <div class="stat-sub">Central GST (intra-state)</div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-top">
                        <div class="stat-label">SGST</div>
                        <div class="stat-icon amber"><i class="fa fa-building"></i></div>
                    </div>
                    <div class="stat-value">₹{{ number_format($summary->sgst_total ?? 0, 0) }}</div>
                    <div class="stat-sub">State GST (intra-state)</div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-top">
                        <div class="stat-label">IGST</div>
                        <div class="stat-icon red"><i class="fa fa-arrows-left-right"></i></div>
                    </div>
                    <div class="stat-value">₹{{ number_format($summary->igst_total ?? 0, 0) }}</div>
                    <div class="stat-sub">Integrated GST (inter-state)</div>
                </div>

            </div>

            <!-- ── GST Slab Breakup ── -->
            <div class="gst-band">
                <div class="gst-band-title">
                    <i class="fa fa-chart-pie"></i>
                    Tax Collection by GST Slab
                </div>

                <div class="gst-slab-grid">

                    @foreach($slabBreakup as $slab => $data)
                        <div class="gst-slab-card">
                            <div class="gst-slab-rate">{{ $slab }}%</div>
                            <div class="gst-slab-label">{{ $slab == 0 ? 'Exempt' : 'GST Slab' }}</div>
                            <div class="gst-slab-taxable">₹{{ number_format($data['taxable'], 0) }}</div>
                            <div class="gst-slab-tax">₹{{ number_format($data['tax'], 0) }}</div>
                            <div class="gst-slab-sub">Tax collected</div>
                        </div>
                    @endforeach

                    <div class="gst-slab-card" style="background:var(--accent-light);border-color:rgba(48,61,137,.2)">
                        <div class="gst-slab-rate">All</div>
                        <div class="gst-slab-label">Total</div>
                        <div class="gst-slab-taxable" style="color:var(--accent)">₹{{ number_format($summary->taxable_value ?? 0, 0) }}</div>
                        <div class="gst-slab-tax">₹{{ number_format($summary->total_tax ?? 0, 0) }}</div>
                        <div class="gst-slab-sub">Grand total</div>
                    </div>

                </div>

                <!-- CGST / SGST / IGST split -->
                <div class="tax-split-bar">
                    <div class="tax-split-chip">
                        <div class="split-dot" style="background:#303d89"></div>
                        <div>
                            <div class="split-label">CGST (Central)</div>
                            <div style="font-size:11px;color:var(--text-hint)">Intra-state, 50% share</div>
                        </div>
                        <div class="split-value">₹{{ number_format($summary->cgst_total ?? 0, 0) }}</div>
                    </div>
                    <div class="tax-split-chip">
                        <div class="split-dot" style="background:#916a00"></div>
                        <div>
                            <div class="split-label">SGST (State)</div>
                            <div style="font-size:11px;color:var(--text-hint)">Intra-state, 50% share</div>
                        </div>
                        <div class="split-value">₹{{ number_format($summary->sgst_total ?? 0, 0) }}</div>
                    </div>
                    <div class="tax-split-chip">
                        <div class="split-dot" style="background:#0069d9"></div>
                        <div>
                            <div class="split-label">IGST (Integrated)</div>
                            <div style="font-size:11px;color:var(--text-hint)">Inter-state orders</div>
                        </div>
                        <div class="split-value">₹{{ number_format($summary->igst_total ?? 0, 0) }}</div>
                    </div>
                    <div class="tax-split-chip" style="background:#f4f5f8">
                        <div class="split-dot" style="background:#007a5e"></div>
                        <div>
                            <div class="split-label">Total Tax</div>
                            <div style="font-size:11px;color:var(--text-hint)">All components</div>
                        </div>
                        <div class="split-value" style="color:var(--green)">₹{{ number_format($summary->total_tax ?? 0, 0) }}</div>
                    </div>
                </div>
            </div>

            <!-- ── Order-wise Tax Detail Table ── -->
            <div class="cat-card">

                <div class="filter-bar">
                    <form method="GET">
                        <input type="hidden" name="date_from" value="{{ $from->format('Y-m-d') }}">
                        <input type="hidden" name="date_to" value="{{ $to->format('Y-m-d') }}">
                        <div class="filter-row">

                            <div class="filter-group">
                                <label>Tax Type</label>
                                <select name="tax_type" class="filter-control">
                                    <option value="">CGST + SGST + IGST</option>
                                    <option value="cgst_sgst" {{ request('tax_type') === 'cgst_sgst' ? 'selected' : '' }}>CGST + SGST (Intra-state)</option>
                                    <option value="igst" {{ request('tax_type') === 'igst' ? 'selected' : '' }}>IGST (Inter-state)</option>
                                </select>
                            </div>

                            <div class="filter-group">
                                <label>Payment Status</label>
                                <select name="payment_status" class="filter-control">
                                    <option value="">All</option>
                                    <option value="paid" {{ request('payment_status') === 'paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="pending" {{ request('payment_status') === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="refunded" {{ request('payment_status') === 'refunded' ? 'selected' : '' }}>Refunded</option>
                                </select>
                            </div>

                            <div class="filter-group" style="flex:1">
                                <label>Search Order / Invoice</label>
                                <input type="text" name="search" class="filter-control" placeholder="Order ID or Invoice No." style="min-width:200px" value="{{ request('search') }}">
                            </div>

                            <div class="filter-actions">
                                <button type="submit" class="btn-primary-dash">
                                    <i class="fa fa-search"></i> Filter
                                </button>
                                <a href="{{ route('admin.reports.tax-reports') }}" class="btn-secondary-dash">Reset</a>
                            </div>

                        </div>
                    </form>
                </div>

                <div class="cat-table-wrap">
                    <table class="cat-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Invoice No.</th>
                                <th>Order ID</th>
                                <th>Invoice Date</th>
                                <th>Customer</th>
                                <th>State</th>
                                <th>Tax Type</th>
                                <th>GST Slab</th>
                                <th>Taxable Amt</th>
                                <th>CGST</th>
                                <th>SGST</th>
                                <th>IGST</th>
                                <th>Total Tax</th>
                                <th>Invoice Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                @php
                                    $isIntra = $order->gst_type === 'intra';
                                    $slabRate = $isIntra ? $order->cgst_rate + $order->sgst_rate : $order->igst_rate;
                                @endphp
                                <tr>
                                    <td><span class="id-chip">{{ $loop->iteration + ($orders->currentPage() - 1) * $orders->perPage() }}</span></td>
                                    <td><a href="#" class="order-link">{{ optional($order->invoice)->invoice_number ?? '—' }}</a></td>
                                    <td><a href="#" class="order-link">#{{ $order->order_number }}</a></td>
                                    <td>
                                        {{ optional($order->invoice)->invoice_date?->format('d M Y') ?? $order->created_at->format('d M Y') }}<br>
                                        <small style="color:var(--text-hint)">{{ $order->created_at->format('h:i A') }}</small>
                                    </td>
                                    <td>
                                        <strong style="font-size:13px">{{ $order->customer_name }}</strong><br>
                                        <small style="color:var(--text-hint)">{{ $order->customer_phone }}</small>
                                    </td>
                                    <td>{{ optional($order->state)->name ?? '—' }}</td>
                                    <td>
                                        @if($isIntra)
                                            <span class="pill pill-cgst">CGST+SGST</span>
                                        @else
                                            <span class="pill pill-igst">IGST</span>
                                        @endif
                                    </td>
                                    <td><span style="font-weight:700;color:var(--accent)">{{ round($slabRate) }}%</span></td>
                                    <td>₹{{ number_format($order->subtotal, 2) }}</td>
                                    <td class="{{ $isIntra ? 'amt-green' : 'amt-muted' }}">{{ $isIntra ? '₹'.number_format($order->cgst_amount, 2) : '—' }}</td>
                                    <td class="{{ $isIntra ? 'amt-green' : 'amt-muted' }}">{{ $isIntra ? '₹'.number_format($order->sgst_amount, 2) : '—' }}</td>
                                    <td class="{{ !$isIntra ? 'amt-green' : 'amt-muted' }}">{{ !$isIntra ? '₹'.number_format($order->igst_amount, 2) : '—' }}</td>
                                    <td style="font-weight:700">₹{{ number_format($order->tax_amount, 2) }}</td>
                                    <td style="font-weight:700">₹{{ number_format($order->grand_total, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="14" style="text-align:center;padding:40px;color:var(--text-hint)">No orders found for this period.</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="8" style="text-align:right;color:var(--text-hint);font-size:12px;font-weight:600;letter-spacing:.03em;text-transform:uppercase">
                                    Page Total
                                </td>
                                <td>₹{{ number_format($pageTotals['taxable'], 2) }}</td>
                                <td style="color:var(--green)">₹{{ number_format($pageTotals['cgst'], 2) }}</td>
                                <td style="color:var(--green)">₹{{ number_format($pageTotals['sgst'], 2) }}</td>
                                <td style="color:var(--blue)">₹{{ number_format($pageTotals['igst'], 2) }}</td>
                                <td style="color:var(--accent)">₹{{ number_format($pageTotals['tax'], 2) }}</td>
                                <td>₹{{ number_format($pageTotals['total'], 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="cat-pagination">
                    <span class="pagination-info">
                        Showing {{ $orders->firstItem() ?? 0 }}–{{ $orders->lastItem() ?? 0 }} of {{ $totalCount }} invoices &nbsp;·&nbsp; Period: {{ $from->format('d M Y') }} – {{ $to->format('d M Y') }}
                    </span>
                    <div>
                        {{ $orders->links() }}
                    </div>
                </div>

            </div>

        </div><!-- /tax-page -->
    </div>
    
</div>

@include('admin.footer')

<script>
    function toggleExport() {
        document.getElementById('exportMenu').classList.toggle('open');
    }

    document.addEventListener('click', function(e) {
        if (!document.getElementById('exportWrap').contains(e.target)) {
            document.getElementById('exportMenu').classList.remove('open');
        }
    });

    function setRange(btn, days) {
        document.querySelectorAll('.range-pill').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        const today = new Date();
        let from = new Date();

        if (days === 'month') {
            from = new Date(today.getFullYear(), today.getMonth(), 1);
        } else if (days === 'quarter') {
            const q = Math.floor(today.getMonth() / 3);
            from = new Date(today.getFullYear(), q * 3, 1);
        } else if (days === 'fy') {
            const y = today.getMonth() >= 3 ? today.getFullYear() : today.getFullYear() - 1;
            from = new Date(y, 3, 1);
        } else {
            from.setDate(today.getDate() - (days - 1));
        }

        document.getElementById('dateFrom').value = from.toISOString().slice(0, 10);
        document.getElementById('dateTo').value   = today.toISOString().slice(0, 10);
    }
</script>
