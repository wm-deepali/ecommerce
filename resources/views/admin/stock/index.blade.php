@include('admin.top-header')
<div class="main-section">
    @include('admin.header')

    <style>
        /*
 ═══════════════════════════════════════════════════════════════
  SIDEBAR LAYOUT PROTECTION
 ═══════════════════════════════════════════════════════════════
*/
        .main-section {
            display: flex !important;
            flex-direction: row !important;
            align-items: stretch !important;
            min-height: 100vh !important;
            overflow: hidden !important;
        }

        .main-section #cssmenu {
            flex-shrink: 0 !important;
            flex-grow: 0 !important;
            width: 280px !important;
            min-width: 280px !important;
            max-width: 280px !important;
            overflow-y: auto !important;
            overflow-x: hidden !important;
            position: sticky !important;
            top: 0 !important;
            height: 100vh !important;
            align-self: flex-start !important;
        }

        .main-section .app-content,
        .main-section .app-content.content.container-fluid {
            flex: 1 1 0% !important;
            min-width: 0 !important;
            max-width: 100% !important;
            overflow-x: auto !important;
            box-sizing: border-box !important;
        }

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

        .stock-page {
            background: var(--bg);
            padding: 24px 28px;
            min-height: 100vh;
            font-family: var(--font);
            color: var(--text-primary);
        }

        .stock-page * {
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
            color: var(--text-primary);
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
            box-shadow: 0 1px 2px rgba(0, 0, 0, .04);
        }

        .btn-secondary-dash:hover {
            background: var(--bg);
            color: var(--text-primary);
        }

        .kpi-strip {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            margin-bottom: 20px;
        }

        @media(max-width:900px) {
            .kpi-strip {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .kpi-tile {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            padding: 18px 20px;
            box-shadow: var(--shadow-card);
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .kpi-icon {
            width: 42px;
            height: 42px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .kpi-icon.green {
            background: var(--green-bg);
            color: var(--green);
        }

        .kpi-icon.red {
            background: var(--red-bg);
            color: var(--red);
        }

        .kpi-icon.amber {
            background: var(--amber-bg);
            color: var(--amber);
        }

        .kpi-icon.blue {
            background: var(--blue-bg);
            color: var(--blue);
        }

        .kpi-label {
            font-size: 11.5px;
            font-weight: 600;
            color: var(--text-hint);
            text-transform: uppercase;
            letter-spacing: .04em;
        }

        .kpi-value {
            font-size: 24px;
            font-weight: 750;
            color: var(--text-primary);
            line-height: 1.1;
            margin-top: 3px;
        }

        .kpi-sub {
            font-size: 11.5px;
            color: var(--text-hint);
            margin-top: 4px;
        }

        .stock-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-card);
            overflow: hidden;
        }

        .alert-banner {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 20px;
            border-bottom: 1px solid var(--border);
            background: var(--amber-bg);
            font-size: 13px;
            color: var(--amber);
            font-weight: 500;
        }

        .alert-banner i {
            font-size: 15px;
            flex-shrink: 0;
        }

        .alert-banner a {
            color: var(--amber);
            font-weight: 700;
            text-decoration: underline;
            cursor: pointer;
        }

        .status-tabs {
            display: flex;
            border-bottom: 1px solid var(--border);
            background: var(--surface);
            padding: 0 20px;
            overflow-x: auto;
        }

        .status-tab {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 12px 16px;
            font-size: 13px;
            font-weight: 500;
            color: var(--text-secondary);
            text-decoration: none;
            border-bottom: 2px solid transparent;
            white-space: nowrap;
            transition: color .15s;
            cursor: pointer;
        }

        .status-tab:hover {
            color: var(--text-primary);
        }

        .status-tab.active {
            color: var(--accent);
            border-bottom-color: var(--accent);
            font-weight: 600;
        }

        .tab-count {
            background: var(--bg);
            color: var(--text-hint);
            font-size: 11px;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 20px;
        }

        .status-tab.active .tab-count {
            background: var(--accent-light);
            color: var(--accent);
        }

        .filter-bar {
            padding: 14px 20px;
            border-bottom: 1px solid var(--border);
        }

        .filter-row {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            align-items: flex-end;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .filter-group label {
            font-size: 11.5px;
            font-weight: 600;
            color: var(--text-secondary);
            letter-spacing: .03em;
            text-transform: uppercase;
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
            transition: border-color .15s;
            font-family: var(--font);
            min-width: 160px;
        }

        .filter-control:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(48, 61, 137, .12);
        }

        .btn-filter {
            height: 36px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--accent);
            color: #fff;
            border: none;
            border-radius: var(--radius-sm);
            padding: 0 16px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            font-family: var(--font);
            transition: background .15s;
        }

        .btn-filter:hover {
            background: #252f70;
        }

        .btn-filter-reset {
            height: 36px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--surface);
            color: var(--text-primary);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 0 14px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            font-family: var(--font);
            transition: background .15s;
        }

        .btn-filter-reset:hover {
            background: var(--bg);
        }

        .table-wrap {
            overflow-x: auto;
        }

        .stock-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            font-family: var(--font);
        }

        .stock-table thead th {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: var(--text-hint);
            padding: 10px 16px;
            border-bottom: 1px solid var(--border);
            background: #fafafa;
            text-align: left;
            white-space: nowrap;
        }

        .stock-table tbody tr {
            border-bottom: 1px solid var(--border);
            transition: background .1s;
        }

        .stock-table tbody tr:last-child {
            border-bottom: none;
        }

        .stock-table tbody tr:hover {
            background: #fafbfc;
        }

        .stock-table tbody td {
            padding: 13px 16px;
            vertical-align: middle;
        }

        .id-chip {
            display: inline-block;
            background: var(--bg);
            color: var(--text-secondary);
            font-size: 11px;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 6px;
            font-family: 'SF Mono', 'Fira Code', monospace;
        }

        .prod-thumb {
            width: 48px;
            height: 48px;
            border-radius: var(--radius-sm);
            object-fit: cover;
            border: 1px solid var(--border);
            flex-shrink: 0;
        }

        .prod-name {
            font-weight: 600;
            font-size: 13px;
            color: var(--text-primary);
        }

        .prod-sku {
            font-size: 11.5px;
            color: var(--text-hint);
            font-family: 'SF Mono', 'Fira Code', monospace;
            margin-top: 2px;
        }

        .cat-tag {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: var(--accent-light);
            color: var(--accent);
            font-size: 11.5px;
            font-weight: 600;
            padding: 3px 8px;
            border-radius: 6px;
        }

        .stock-bar-wrap {
            width: 90px;
        }

        .stock-bar {
            height: 5px;
            border-radius: 10px;
            background: var(--bg);
            overflow: hidden;
            margin-top: 5px;
        }

        .stock-bar-fill {
            height: 100%;
            border-radius: 10px;
            transition: width .3s;
        }

        .stock-qty {
            font-size: 15px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .stock-min {
            font-size: 11px;
            color: var(--text-hint);
            margin-top: 1px;
        }

        .pill {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11.5px;
            font-weight: 600;
            padding: 3px 9px;
            border-radius: 20px;
            white-space: nowrap;
        }

        .pill::before {
            content: '';
            width: 5px;
            height: 5px;
            border-radius: 50%;
        }

        .pill-in {
            background: var(--green-bg);
            color: var(--green);
        }

        .pill-in::before {
            background: var(--green);
        }

        .pill-low {
            background: var(--amber-bg);
            color: var(--amber);
        }

        .pill-low::before {
            background: var(--amber);
        }

        .pill-out {
            background: var(--red-bg);
            color: var(--red);
        }

        .pill-out::before {
            background: var(--red);
        }

        .pill-active {
            background: var(--green-bg);
            color: var(--green);
        }

        .pill-active::before {
            background: var(--green);
        }

        .pill-inactive {
            background: var(--red-bg);
            color: var(--red);
        }

        .pill-inactive::before {
            background: var(--red);
        }

        .stock-input {
            width: 80px;
            height: 32px;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 0 10px;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
            background: var(--surface);
            outline: none;
            font-family: var(--font);
            text-align: center;
            transition: border-color .15s, box-shadow .15s;
        }

        .stock-input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(48, 61, 137, .12);
        }

        .btn-update {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            height: 30px;
            background: var(--accent-light);
            color: var(--accent);
            border: 1px solid #c7cdf5;
            border-radius: var(--radius-sm);
            padding: 0 10px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            font-family: var(--font);
            transition: all .15s;
            white-space: nowrap;
        }

        .btn-update:hover {
            background: var(--accent);
            color: #fff;
            border-color: var(--accent);
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
            background: var(--surface);
            color: var(--text-secondary);
            font-size: 12px;
            cursor: pointer;
            transition: all .12s;
            text-decoration: none;
        }

        .action-btn:hover {
            background: var(--bg);
            color: var(--text-primary);
        }

        .action-btn-view:hover {
            background: var(--blue-bg);
            border-color: #b8d4f5;
            color: var(--blue);
        }

        .action-btn-hist:hover {
            background: var(--purple-bg);
            border-color: #c8b7f5;
            color: var(--purple);
        }

        .action-wrap {
            position: relative;
            display: inline-flex;
        }

        .action-wrap .tooltip-label {
            position: absolute;
            bottom: calc(100% + 6px);
            left: 50%;
            transform: translateX(-50%);
            background: #202223;
            color: #fff;
            font-size: 11px;
            white-space: nowrap;
            padding: 3px 8px;
            border-radius: 5px;
            pointer-events: none;
            opacity: 0;
            transition: opacity .15s;
            z-index: 10;
        }

        .action-wrap:hover .tooltip-label {
            opacity: 1;
        }

        .stock-table tbody tr.row-low {
            background: #fffcf2;
        }

        .stock-table tbody tr.row-out {
            background: #fff8f8;
        }

        .stock-table tbody tr.row-low:hover {
            background: #fff9e6;
        }

        .stock-table tbody tr.row-out:hover {
            background: #fff0f0;
        }

        .pag-row {
            padding: 14px 20px;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        .pag-info {
            font-size: 12.5px;
            color: var(--text-hint);
        }

        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .45);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal-overlay.open {
            display: flex;
        }

        .modal-box {
            background: var(--surface);
            border-radius: var(--radius-md);
            box-shadow: 0 20px 60px rgba(0, 0, 0, .2);
            width: 560px;
            max-width: 95vw;
            max-height: 85vh;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .modal-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fafafa;
        }

        .modal-header h5 {
            font-size: 14px;
            font-weight: 650;
            margin: 0;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 18px;
            color: var(--text-hint);
            cursor: pointer;
            padding: 0;
            line-height: 1;
        }

        .modal-close:hover {
            color: var(--text-primary);
        }

        .modal-body {
            padding: 20px;
            overflow-y: auto;
            flex: 1;
        }

        .hist-timeline {
            position: relative;
            padding-left: 24px;
        }

        .hist-timeline::before {
            content: '';
            position: absolute;
            left: 7px;
            top: 6px;
            bottom: 6px;
            width: 2px;
            background: var(--border);
            border-radius: 2px;
        }

        .hist-item {
            position: relative;
            margin-bottom: 18px;
        }

        .hist-item:last-child {
            margin-bottom: 0;
        }

        .hist-dot {
            position: absolute;
            left: -21px;
            top: 3px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            border: 2px solid var(--surface);
        }

        .hist-dot.add {
            background: var(--green);
        }

        .hist-dot.remove {
            background: var(--red);
        }

        .hist-dot.adjust {
            background: var(--amber);
        }

        .hist-title {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .hist-meta {
            font-size: 11.5px;
            color: var(--text-hint);
            margin-top: 3px;
        }

        .hist-qty {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 12px;
            font-weight: 700;
            margin-top: 4px;
            padding: 2px 8px;
            border-radius: 6px;
        }

        .hist-qty.add {
            background: var(--green-bg);
            color: var(--green);
        }

        .hist-qty.remove {
            background: var(--red-bg);
            color: var(--red);
        }

        .hist-qty.adjust {
            background: var(--amber-bg);
            color: var(--amber);
        }

        @media(max-width:768px) {
            .stock-page {
                padding: 16px;
            }

            .filter-row {
                flex-direction: column;
            }

            .filter-control {
                min-width: 100%;
            }
        }
    </style>

    @php
        /** @var \App\Services\StockService $stockService */
        $stockService = app(\App\Services\StockService::class);
    @endphp

    <div class="app-content content container-fluid">
        <div class="stock-page">

            <!-- Page header -->
            <div class="page-header">
                <div>
                    <h1>Stock Management</h1>
                    <div class="crumb">
                        <a href="#">Dashboard</a>
                        <span>›</span>
                        Stock Management
                    </div>
                </div>
                <div style="display:flex;gap:8px;flex-wrap:wrap">

                    {{-- Export CSV (respects current filters) --}}
                    <a href="{{ route('admin.stock.export', request()->query()) }}" class="btn-secondary-dash">
                        <i class="fa fa-download"></i> Export CSV
                    </a>

                    {{-- Bulk Update trigger --}}
                    <button type="button" class="btn-secondary-dash"
                        onclick="document.getElementById('bulkModal').classList.add('open')">
                        <i class="fa fa-upload"></i> Bulk Update
                    </button>

                    {{-- Add Stock Entry trigger --}}
                    <button type="button" class="btn-primary-dash"
                        onclick="document.getElementById('addEntryModal').classList.add('open')">
                        <i class="fa fa-plus"></i> Add Stock Entry
                    </button>
                </div>
            </div>

            <!-- KPI strip -->
            <div class="kpi-strip">
                <div class="kpi-tile">
                    <div class="kpi-icon green"><i class="fa fa-cubes"></i></div>
                    <div>
                        <div class="kpi-label">Total Products</div>
                        <div class="kpi-value">{{ number_format($stats['total']) }}</div>
                        <div class="kpi-sub">In inventory</div>
                    </div>
                </div>
                <div class="kpi-tile">
                    <div class="kpi-icon amber"><i class="fa fa-exclamation-triangle"></i></div>
                    <div>
                        <div class="kpi-label">Low Stock</div>
                        <div class="kpi-value">{{ number_format($stats['low']) }}</div>
                        <div class="kpi-sub">Below threshold</div>
                    </div>
                </div>
                <div class="kpi-tile">
                    <div class="kpi-icon red"><i class="fa fa-times-circle"></i></div>
                    <div>
                        <div class="kpi-label">Out of Stock</div>
                        <div class="kpi-value">{{ number_format($stats['out']) }}</div>
                        <div class="kpi-sub">Need restocking</div>
                    </div>
                </div>
                <div class="kpi-tile">
                    <div class="kpi-icon blue"><i class="fa fa-boxes"></i></div>
                    <div>
                        <div class="kpi-label">Total Units</div>
                        <div class="kpi-value">{{ number_format($stats['units']) }}</div>
                        <div class="kpi-sub">Across all products</div>
                    </div>
                </div>
            </div>

            <!-- Main card -->
            <div class="stock-card">

                <!-- Alert banner -->
                @if($stats['out'] > 0 || $stats['low'] > 0)
                    <div class="alert-banner">
                        <i class="fa fa-exclamation-triangle"></i>
                        <span>
                            {{ $stats['out'] }} products are <strong>out of stock</strong> and {{ $stats['low'] }} are
                            running low.
                            <a href="{{ route('admin.stock.index', ['stock_status' => 'out']) }}">View critical items →</a>
                        </span>
                    </div>
                @endif

                <!-- Status tabs -->
                <div class="status-tabs">
                    <a href="{{ route('admin.stock.index', request()->except(['stock_status', 'page'])) }}"
                        class="status-tab {{ !request('stock_status') ? 'active' : '' }}">
                        All <span class="tab-count">{{ number_format($stats['total']) }}</span>
                    </a>
                    <a href="{{ route('admin.stock.index', array_merge(request()->except('page'), ['stock_status' => 'in'])) }}"
                        class="status-tab {{ request('stock_status') === 'in' ? 'active' : '' }}">
                        In Stock <span class="tab-count">{{ number_format($stats['in_stock']) }}</span>
                    </a>
                    <a href="{{ route('admin.stock.index', array_merge(request()->except('page'), ['stock_status' => 'low'])) }}"
                        class="status-tab {{ request('stock_status') === 'low' ? 'active' : '' }}">
                        Low Stock <span class="tab-count">{{ number_format($stats['low']) }}</span>
                    </a>
                    <a href="{{ route('admin.stock.index', array_merge(request()->except('page'), ['stock_status' => 'out'])) }}"
                        class="status-tab {{ request('stock_status') === 'out' ? 'active' : '' }}">
                        Out of Stock <span class="tab-count">{{ number_format($stats['out']) }}</span>
                    </a>
                </div>

                <!-- Filter bar -->
                <form method="GET" action="{{ route('admin.stock.index') }}" class="filter-bar">
                    <div class="filter-row">
                        <div class="filter-group" style="flex:1">
                            <label>Search</label>
                            <input type="text" name="search" class="filter-control" style="min-width:220px"
                                placeholder="Product name, SKU, or code…" value="{{ request('search') }}">
                        </div>
                        <div class="filter-group">
                            <label>Category</label>
                            <select name="category_id" class="filter-control">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ (string) request('category_id') === (string) $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="filter-group">
                            <label>Stock Status</label>
                            <select name="stock_status" class="filter-control">
                                <option value="">All</option>
                                <option value="in" {{ request('stock_status') === 'in' ? 'selected' : '' }}>In Stock
                                </option>
                                <option value="low" {{ request('stock_status') === 'low' ? 'selected' : '' }}>Low Stock
                                </option>
                                <option value="out" {{ request('stock_status') === 'out' ? 'selected' : '' }}>Out of Stock
                                </option>
                            </select>
                        </div>
                        <div class="filter-group">
                            <label>Sort By</label>
                            <select name="sort" class="filter-control">
                                <option value="stock_asc" {{ request('sort', 'stock_asc') === 'stock_asc' ? 'selected' : '' }}>Stock: Low to High</option>
                                <option value="stock_desc" {{ request('sort') === 'stock_desc' ? 'selected' : '' }}>Stock:
                                    High to Low</option>
                                <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Product
                                    Name A–Z</option>
                                <option value="recent" {{ request('sort') === 'recent' ? 'selected' : '' }}>Last Updated
                                </option>
                            </select>
                        </div>
                        <div style="display:flex;gap:8px;align-items:flex-end">
                            <button type="submit" class="btn-filter"><i class="fa fa-search"></i> Search</button>
                            <a href="{{ route('admin.stock.index') }}" class="btn-filter-reset"><i
                                    class="fa fa-refresh"></i> Reset</a>
                        </div>
                    </div>
                </form>

                <!-- Table -->
                <div class="table-wrap">
                    <table class="stock-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Product</th>
                                <th>Category</th>
                                <th>SKU</th>
                                <th>Current Stock</th>
                                <th>Min Threshold</th>
                                <th>Stock Status</th>
                                <th>Visibility</th>
                                <th>Update Stock</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $line)
                                @php
                                    $isVariant = $line['kind'] === 'variant';
                                    $state = $line['status']; // 'out' | 'low' | 'in'
                                    $rowClass = match ($state) { 'out' => 'row-out', 'low' => 'row-low', default => ''};
                                    $pillClass = match ($state) { 'out' => 'pill-out', 'low' => 'pill-low', default => 'pill-in'};
                                    $pillLabel = match ($state) { 'out' => 'Out of Stock', 'low' => 'Low Stock', default => 'In Stock'};
                                    $barColor = match ($state) { 'out' => 'var(--red)', 'low' => 'var(--amber)', default => 'var(--green)'};
                                    $lowThreshold = $stockService->thresholds()[1];
                                    $barWidth = match ($state) {
                                        'out' => 0,
                                        'low' => $lowThreshold > 0 ? min(100, round(($line['stock'] / $lowThreshold) * 100)) : 0,
                                        default => 100,
                                    };

                                    $updateUrl = $isVariant
                                        ? route('admin.stock.variant.update', $line['variant'])
                                        : route('admin.stock.update', $line['product']);

                                    $historyId = $isVariant ? 'v' . $line['id'] : $line['id'];
                                @endphp
                                <tr class="{{ $rowClass }}" data-product-row="{{ $historyId }}">
                                    <td><span class="id-chip">{{ $line['id'] }}</span></td>
                                    <td>
                                        <div style="display:flex;align-items:center;gap:10px">
                                            <img src="{{ $line['image'] ?? 'https://placehold.co/48x48/e8f2ff/0069d9?text=P' }}"
                                                class="prod-thumb" alt="">
                                            <div>
                                                <div class="prod-name">
                                                    {{ $line['display_name'] }}
                                                    @if($isVariant)
                                                        <span style="font-weight:500;color:var(--text-hint)"> — {{ $line['sub_label'] }}</span>
                                                    @endif
                                                </div>
                                                <div class="prod-sku">CODE: {{ $line['product_code'] }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="cat-tag"><i class="fa fa-folder-o" style="font-size:10px"></i>
                                            {{ $line['category']->name ?? 'Uncategorized' }}</span></td>
                                    <td><span
                                            style="font-family:'SF Mono','Fira Code',monospace;font-size:12px;color:var(--text-secondary)">{{ $line['sku'] }}</span>
                                    </td>
                                    <td>
                                        <div class="stock-qty" data-stock-value {{ $state !== 'in' ? 'style=color:' . $barColor : '' }}>{{ $line['stock'] }}</div>
                                        <div class="stock-bar-wrap">
                                            <div class="stock-bar">
                                                <div class="stock-bar-fill" data-stock-bar
                                                    style="width:{{ $barWidth }}%;background:{{ $barColor }}"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span
                                            style="font-size:13px;color:var(--text-secondary)">{{ $line['min_qty'] }}</span>
                                    </td>
                                    <td><span class="pill {{ $pillClass }}" data-stock-pill>{{ $pillLabel }}</span></td>
                                    <td><span class="pill {{ $line['active'] ? 'pill-active' : 'pill-inactive' }}"
                                            data-visibility-pill>{{ $line['active'] ? 'Active' : 'Inactive' }}</span></td>
                                    <td>
                                        <form class="stock-update-form" data-action="{{ $updateUrl }}">
                                            @csrf
                                            <div style="display:flex;gap:6px;align-items:center">
                                                <input type="number" min="0" name="stock" class="stock-input"
                                                    value="{{ $line['stock'] }}" {{ $state !== 'in' ? 'style=border-color:' . $barColor : '' }}>
                                                <button type="submit" class="btn-update"><i class="fa fa-check"></i>
                                                    Save</button>
                                            </div>
                                        </form>
                                    </td>
                                    <td>
                                        <div style="display:flex;gap:5px">
                                            <div class="action-wrap">
                                                <a href="{{ route('admin.products.edit', $line['product']->id) }}"
                                                    class="action-btn action-btn-view"><i class="fa fa-eye"></i></a>
                                                <span class="tooltip-label">View Product</span>
                                            </div>
                                            <div class="action-wrap">
                                                <button type="button" class="action-btn action-btn-hist"
                                                    onclick="openHistory({{ $line['id'] }}, {{ \Illuminate\Support\Js::from($isVariant ? $line['display_name'] . ' — ' . $line['sub_label'] : $line['display_name']) }}, {{ $isVariant ? 'true' : 'false' }})">
                                                    <i class="fa fa-history"></i>
                                                </button>
                                                <span class="tooltip-label">Stock History</span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" style="text-align:center;padding:40px;color:var(--text-hint)">
                                        No products match these filters.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="pag-row">
                    <div class="pag-info">
                        Showing {{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }} of
                        {{ number_format($products->total()) }} products
                    </div>
                    <nav>
                        {{ $products->onEachSide(1)->links() }}
                    </nav>
                </div>

            </div><!-- /stock-card -->

        </div>
    </div>

    <!-- ── Stock History Modal ───────────────────────────────── -->
    <div class="modal-overlay" id="historyModal">
        <div class="modal-box">
            <div class="modal-header">
                <h5><i class="fa fa-history" style="color:var(--accent);margin-right:8px"></i> Stock History — <span
                        id="modalProductName"></span></h5>
                <button class="modal-close" onclick="closeHistory()">×</button>
            </div>
            <div class="modal-body">

                <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;margin-bottom:20px">
                    <div
                        style="background:var(--green-bg);border-radius:var(--radius-sm);padding:12px 14px;text-align:center">
                        <div
                            style="font-size:11px;font-weight:600;color:var(--green);text-transform:uppercase;letter-spacing:.04em">
                            Total Added</div>
                        <div id="histAdded" style="font-size:22px;font-weight:750;color:var(--green);margin-top:4px">+0
                        </div>
                    </div>
                    <div
                        style="background:var(--red-bg);border-radius:var(--radius-sm);padding:12px 14px;text-align:center">
                        <div
                            style="font-size:11px;font-weight:600;color:var(--red);text-transform:uppercase;letter-spacing:.04em">
                            Total Sold</div>
                        <div id="histRemoved" style="font-size:22px;font-weight:750;color:var(--red);margin-top:4px">−0
                        </div>
                    </div>
                    <div
                        style="background:var(--accent-light);border-radius:var(--radius-sm);padding:12px 14px;text-align:center">
                        <div
                            style="font-size:11px;font-weight:600;color:var(--accent);text-transform:uppercase;letter-spacing:.04em">
                            Current</div>
                        <div id="histCurrent" style="font-size:22px;font-weight:750;color:var(--accent);margin-top:4px">
                            0</div>
                    </div>
                </div>

                <div class="hist-timeline" id="histTimeline"></div>
            </div>
        </div>
    </div>

</div>


<div class="modal-overlay" id="bulkModal">
    <div class="modal-box" style="width:480px">
        <div class="modal-header">
            <h5><i class="fa fa-upload" style="color:var(--accent);margin-right:8px"></i> Bulk Update Stock</h5>
            <button class="modal-close"
                onclick="document.getElementById('bulkModal').classList.remove('open')">×</button>
        </div>
        <div class="modal-body">

            {{-- Step 1: Download template --}}
            <div style="background:var(--bg);border-radius:var(--radius-sm);padding:14px 16px;margin-bottom:16px">
                <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap">
                    <div>
                        <div style="font-size:13px;font-weight:600;color:var(--text-primary);margin-bottom:3px">
                            <i class="fa fa-file-text-o" style="color:var(--accent);margin-right:6px"></i>
                            Step 1 — Download the template
                        </div>
                        <div style="font-size:12px;color:var(--text-hint)">
                            Fill in the <strong>Stock</strong> column (col 6) and leave everything else unchanged.
                            <br>
                            <em>Note: bulk update currently applies to plain products only, not variant stock rows.</em>
                        </div>
                    </div>
                    <a href="{{ route('admin.stock.bulk-update.template') }}" class="btn-secondary-dash"
                        style="flex-shrink:0;white-space:nowrap">
                        <i class="fa fa-download"></i> Download Template
                    </a>
                </div>
            </div>

            {{-- CSV format reference --}}
            <div
                style="border:1px solid var(--border);border-radius:var(--radius-sm);overflow:hidden;margin-bottom:16px;font-size:12px">
                <div
                    style="background:#fafafa;padding:8px 12px;font-size:11px;font-weight:600;color:var(--text-hint);text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid var(--border)">
                    Expected CSV Format
                </div>
                <div style="overflow-x:auto">
                    <table
                        style="width:100%;border-collapse:collapse;font-family:'SF Mono','Fira Code',monospace;font-size:11.5px">
                        <thead>
                            <tr>
                                @foreach(['ID', 'Name', 'SKU', 'Code', 'Category', 'Stock ✏️', 'Min Qty'] as $col)
                                    <th style="padding:6px 10px;border-bottom:1px solid var(--border);background:#fafafa;
                                            color:{{ $col === 'Stock ✏️' ? 'var(--accent)' : 'var(--text-hint)' }};
                                            font-weight:{{ $col === 'Stock ✏️' ? '700' : '500' }};
                                            white-space:nowrap;text-align:left">
                                        {{ $col }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="padding:6px 10px;color:var(--text-hint)">1</td>
                                <td style="padding:6px 10px;color:var(--text-hint)">Product A</td>
                                <td style="padding:6px 10px;color:var(--text-hint)">SKU-001</td>
                                <td style="padding:6px 10px;color:var(--text-hint)">CODE-001</td>
                                <td style="padding:6px 10px;color:var(--text-hint)">Electronics</td>
                                <td
                                    style="padding:6px 10px;color:var(--accent);font-weight:700;background:var(--accent-light)">
                                    50</td>
                                <td style="padding:6px 10px;color:var(--text-hint)">5</td>
                            </tr>
                            <tr style="background:#fafafa">
                                <td style="padding:6px 10px;color:var(--text-hint)">2</td>
                                <td style="padding:6px 10px;color:var(--text-hint)">Product B</td>
                                <td style="padding:6px 10px;color:var(--text-hint)">SKU-002</td>
                                <td style="padding:6px 10px;color:var(--text-hint)">CODE-002</td>
                                <td style="padding:6px 10px;color:var(--text-hint)">Clothing</td>
                                <td
                                    style="padding:6px 10px;color:var(--accent);font-weight:700;background:var(--accent-light)">
                                    100</td>
                                <td style="padding:6px 10px;color:var(--text-hint)">10</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div
                    style="padding:8px 12px;font-size:11.5px;color:var(--text-hint);border-top:1px solid var(--border)">
                    ✏️ Only the <strong style="color:var(--accent)">Stock</strong> column is updated. ID must match an
                    existing product. Other columns are ignored.
                </div>
            </div>

            {{-- Step 2: Upload --}}
            <div style="font-size:13px;font-weight:600;color:var(--text-primary);margin-bottom:10px">
                <i class="fa fa-upload" style="color:var(--accent);margin-right:6px"></i>
                Step 2 — Upload your filled CSV
            </div>

            <form method="POST" action="{{ route('admin.stock.bulk-update') }}" enctype="multipart/form-data">
                @csrf
                <div style="margin-bottom:14px">
                    <label
                        style="font-size:11.5px;font-weight:600;color:var(--text-secondary);text-transform:uppercase;letter-spacing:.03em;display:block;margin-bottom:6px">
                        CSV File
                    </label>
                    <input type="file" name="csv_file" accept=".csv,.txt" required
                        style="font-size:13px;color:var(--text-primary);width:100%">
                </div>

                @if(session('bulk_errors'))
                    <div
                        style="background:var(--red-bg);border-radius:var(--radius-sm);padding:10px 14px;font-size:12.5px;color:var(--red);margin-bottom:14px">
                        <div style="font-weight:600;margin-bottom:4px"><i class="fa fa-exclamation-triangle"></i> Some rows
                            were skipped:</div>
                        @foreach(session('bulk_errors') as $err)
                            <div style="margin-top:2px">• {{ $err }}</div>
                        @endforeach
                    </div>
                @endif

                @if(session('success') && session('reopen_modal') === 'bulk')
                    <div
                        style="background:var(--green-bg);border-radius:var(--radius-sm);padding:10px 14px;font-size:12.5px;color:var(--green);margin-bottom:14px">
                        <i class="fa fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif

                <div style="display:flex;gap:8px;justify-content:flex-end">
                    <button type="button" class="btn-secondary-dash"
                        onclick="document.getElementById('bulkModal').classList.remove('open')">
                        Cancel
                    </button>
                    <button type="submit" class="btn-primary-dash">
                        <i class="fa fa-upload"></i> Import & Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal-overlay" id="addEntryModal">
    <div class="modal-box" style="width:500px">
        <div class="modal-header">
            <h5><i class="fa fa-plus" style="color:var(--accent);margin-right:8px"></i> Add Stock Entry</h5>
            <button class="modal-close"
                onclick="document.getElementById('addEntryModal').classList.remove('open')">×</button>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{ route('admin.stock.add-entry') }}">
                @csrf
                <div style="display:flex;flex-direction:column;gap:14px">

                    <div>
                        <label
                            style="font-size:11.5px;font-weight:600;color:var(--text-secondary);text-transform:uppercase;letter-spacing:.03em;display:block;margin-bottom:6px">
                            Product <span style="font-weight:400;text-transform:none">(plain products only for now)</span>
                        </label>
                        <select name="product_id" required
                            style="width:100%;height:36px;border:1px solid var(--border);border-radius:var(--radius-sm);padding:0 11px;font-size:13px;font-family:var(--font);color:var(--text-primary);background:var(--surface);outline:none">
                            <option value="">— Select a product —</option>
                            @foreach($categories as $category)
                                <optgroup label="{{ $category->name }}">
                                    @foreach($category->products as $p)
                                        <option value="{{ $p->id }}">{{ $p->name }} ({{ $p->sku }}) — {{ $p->stock }} in stock
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
                        <div>
                            <label
                                style="font-size:11.5px;font-weight:600;color:var(--text-secondary);text-transform:uppercase;letter-spacing:.03em;display:block;margin-bottom:6px">
                                Type
                            </label>
                            <select name="type" required
                                style="width:100%;height:36px;border:1px solid var(--border);border-radius:var(--radius-sm);padding:0 11px;font-size:13px;font-family:var(--font);color:var(--text-primary);background:var(--surface);outline:none">
                                <option value="credit">➕ Add Stock</option>
                                <option value="debit">➖ Remove Stock</option>
                            </select>
                        </div>
                        <div>
                            <label
                                style="font-size:11.5px;font-weight:600;color:var(--text-secondary);text-transform:uppercase;letter-spacing:.03em;display:block;margin-bottom:6px">
                                Quantity
                            </label>
                            <input type="number" name="quantity" min="1" required placeholder="e.g. 50"
                                style="width:100%;height:36px;border:1px solid var(--border);border-radius:var(--radius-sm);padding:0 11px;font-size:13px;font-family:var(--font);color:var(--text-primary);background:var(--surface);outline:none;text-align:center;font-weight:600">
                        </div>
                    </div>

                    <div>
                        <label
                            style="font-size:11.5px;font-weight:600;color:var(--text-secondary);text-transform:uppercase;letter-spacing:.03em;display:block;margin-bottom:6px">
                            Reason
                        </label>
                        <select name="reason" required
                            style="width:100%;height:36px;border:1px solid var(--border);border-radius:var(--radius-sm);padding:0 11px;font-size:13px;font-family:var(--font);color:var(--text-primary);background:var(--surface);outline:none">
                            <option value="restock">Restock</option>
                            <option value="admin_adjustment">Manual Adjustment</option>
                            <option value="return">Customer Return</option>
                            <option value="damage">Damage Write-off</option>
                            <option value="initial_stock">Initial Stock</option>
                            <option value="bulk_import">Bulk Import</option>
                        </select>
                    </div>

                    <div>
                        <label
                            style="font-size:11.5px;font-weight:600;color:var(--text-secondary);text-transform:uppercase;letter-spacing:.03em;display:block;margin-bottom:6px">
                            Note <span style="font-weight:400;text-transform:none">(optional)</span>
                        </label>
                        <input type="text" name="note" maxlength="255" placeholder="e.g. Supplier delivery batch #42"
                            style="width:100%;height:36px;border:1px solid var(--border);border-radius:var(--radius-sm);padding:0 11px;font-size:13px;font-family:var(--font);color:var(--text-primary);background:var(--surface);outline:none">
                    </div>

                    <div style="display:flex;gap:8px;justify-content:flex-end;padding-top:4px">
                        <button type="button" class="btn-secondary-dash"
                            onclick="document.getElementById('addEntryModal').classList.remove('open')">
                            Cancel
                        </button>
                        <button type="submit" class="btn-primary-dash">
                            <i class="fa fa-check"></i> Record Entry
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


@include('admin.footer')

@if($errors->any() || session('bulk_errors'))
    <script>
        // Reopen the relevant modal on validation error
        @if(session('reopen_modal') === 'bulk')
            document.getElementById('bulkModal').classList.add('open');
        @elseif(session('reopen_modal') === 'entry')
            document.getElementById('addEntryModal').classList.add('open');
        @endif
    </script>
@endif

<script>
    const STOCK_HISTORY_URL_TEMPLATE = "{{ route('admin.stock.history', ['product' => '__ID__']) }}";
    const STOCK_VARIANT_HISTORY_URL_TEMPLATE = "{{ route('admin.stock.variant.history', ['variant' => '__ID__']) }}";

    function openHistory(id, productName, isVariant) {
        document.getElementById('modalProductName').textContent = productName;
        document.getElementById('historyModal').classList.add('open');
        loadHistory(id, isVariant);
    }

    function closeHistory() {
        document.getElementById('historyModal').classList.remove('open');
    }

    document.getElementById('historyModal').addEventListener('click', function (e) {
        if (e.target === this) closeHistory();
    });

    const REASON_LABELS = {
        order: 'Stock Deducted — Order',
        admin_adjustment: 'Stock Adjusted — Manual Update',
        restock: 'Stock Added — Restock',
        bulk_import: 'Stock Added — Bulk Import',
        damage: 'Stock Adjusted — Damage Write-off',
        return: 'Stock Added — Customer Return',
        initial_stock: 'Initial Stock Set',
    };

    async function loadHistory(id, isVariant = false) {
        const timeline = document.getElementById('histTimeline');
        timeline.innerHTML = '<div style="padding:20px;text-align:center;color:var(--text-hint)">Loading…</div>';

        try {
            const template = isVariant ? STOCK_VARIANT_HISTORY_URL_TEMPLATE : STOCK_HISTORY_URL_TEMPLATE;
            const url = template.replace('__ID__', id);
            const res = await fetch(url, { headers: { Accept: 'application/json' } });
            if (!res.ok) throw new Error('Request failed');
            const data = await res.json();

            document.getElementById('histAdded').textContent = `+${data.summary.added}`;
            document.getElementById('histRemoved').textContent = `−${data.summary.removed}`;
            document.getElementById('histCurrent').textContent = data.summary.current;

            if (!data.history.length) {
                timeline.innerHTML = '<div style="padding:20px;text-align:center;color:var(--text-hint)">No stock movements yet.</div>';
                return;
            }

            timeline.innerHTML = data.history.map(h => {
                const dotClass = h.reason === 'admin_adjustment' ? 'adjust' : (h.type === 'credit' ? 'add' : 'remove');
                const sign = h.type === 'credit' ? '+' : '−';
                const title = REASON_LABELS[h.reason] || (h.type === 'credit' ? 'Stock Added' : 'Stock Deducted');
                const meta = h.creator ? `By ${h.creator}` : 'Automatic';
                const note = h.note ? ` · ${h.note}` : '';

                return `
                <div class="hist-item">
                    <div class="hist-dot ${dotClass}"></div>
                    <div class="hist-title">${title}</div>
                    <div class="hist-meta">${meta} &nbsp;·&nbsp; ${h.created_at}${note}</div>
                    <span class="hist-qty ${dotClass}"><i class="fa fa-arrow-${h.type === 'credit' ? 'up' : 'down'}"></i> ${sign}${h.quantity} units</span>
                </div>
            `;
            }).join('');
        } catch (e) {
            timeline.innerHTML = '<div style="padding:20px;text-align:center;color:var(--red)">Couldn\'t load history.</div>';
        }
    }

    // Inline "Update Stock" — submits via fetch so the row updates without a full reload.
    document.querySelectorAll('.stock-update-form').forEach(form => {
        form.addEventListener('submit', async function (e) {
            e.preventDefault();

            const btn = this.querySelector('.btn-update');
            const input = this.querySelector('.stock-input');
            const row = this.closest('tr');
            const orig = btn.innerHTML;

            btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Saving…';
            btn.disabled = true;

            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
                const res = await fetch(this.dataset.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        Accept: 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({ stock: input.value }),
                });

                if (!res.ok) throw new Error('Request failed');
                const data = await res.json();

                row.querySelector('[data-stock-value]').textContent = data.stock;

                const pillMap = {
                    out: ['pill-out', 'Out of Stock'],
                    low: ['pill-low', 'Low Stock'],
                    in: ['pill-in', 'In Stock'],
                };
                const pill = row.querySelector('[data-stock-pill]');
                pill.className = 'pill ' + pillMap[data.status][0];
                pill.textContent = pillMap[data.status][1];

                const visPill = row.querySelector('[data-visibility-pill]');
                visPill.className = 'pill ' + (data.active ? 'pill-active' : 'pill-inactive');
                visPill.textContent = data.active ? 'Active' : 'Inactive';

                btn.innerHTML = '<i class="fa fa-check"></i> Saved!';
                btn.style.background = 'var(--green-bg)';
                btn.style.color = 'var(--green)';
                btn.style.borderColor = 'var(--green)';
            } catch (err) {
                btn.innerHTML = '<i class="fa fa-times"></i> Failed';
                btn.style.background = 'var(--red-bg)';
                btn.style.color = 'var(--red)';
                btn.style.borderColor = 'var(--red)';
            }

            setTimeout(() => {
                btn.innerHTML = orig;
                btn.style.background = '';
                btn.style.color = '';
                btn.style.borderColor = '';
                btn.disabled = false;
            }, 1500);
        });
    });
</script>