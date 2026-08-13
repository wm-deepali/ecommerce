@include('admin.top-header')

<div class="main-section">
    @include('admin.header')

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

    /* ── Page header ── */
    .page-header { display: flex; align-items: flex-start; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 20px; }
    .page-header h1 { font-size: 20px; font-weight: 650; color: var(--text-primary); margin: 0; }
    .crumb { font-size: 12.5px; color: var(--text-hint); margin-top: 3px; }
    .crumb a { color: var(--accent); text-decoration: none; }
    .crumb a:hover { text-decoration: underline; }
    .crumb span { margin: 0 5px; }

    /* ── Buttons ── */
    .btn-primary-dash {
        display: inline-flex; align-items: center; gap: 6px;
        background: var(--accent); color: #fff !important; border: none;
        border-radius: var(--radius-sm); padding: 8px 16px;
        font-size: 13px; font-weight: 600; cursor: pointer;
        text-decoration: none !important; font-family: var(--font);
        transition: background .15s; box-shadow: 0 1px 3px rgba(48,61,137,.25);
        white-space: nowrap;
    }
    .btn-primary-dash:hover { background: #252f70; }

    .btn-secondary-dash {
        display: inline-flex; align-items: center; gap: 6px;
        background: var(--surface); color: var(--text-primary) !important;
        border: 1px solid var(--border); border-radius: var(--radius-sm);
        padding: 8px 16px; font-size: 13px; font-weight: 500; cursor: pointer;
        text-decoration: none !important; font-family: var(--font);
        transition: background .15s; white-space: nowrap;
    }
    .btn-secondary-dash:hover { background: var(--bg); }

    /* ── KPI strip ── */
    .kpi-strip { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 20px; }
    @media(max-width:900px) { .kpi-strip { grid-template-columns: repeat(2,1fr); } }
    @media(max-width:500px) { .kpi-strip { grid-template-columns: 1fr; } }

    .kpi-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 18px 20px; box-shadow: var(--shadow-card); }
    .kpi-label { font-size: 11.5px; font-weight: 600; text-transform: uppercase; letter-spacing: .05em; color: var(--text-hint); margin-bottom: 8px; }
    .kpi-value { font-size: 26px; font-weight: 750; color: var(--text-primary); line-height: 1; }
    .kpi-trend { display: inline-flex; align-items: center; gap: 4px; font-size: 12px; font-weight: 600; margin-top: 8px; padding: 3px 8px; border-radius: 20px; }
    .kpi-trend.up   { background: var(--green-bg); color: var(--green); }
    .kpi-trend.down { background: var(--red-bg);   color: var(--red); }
    .kpi-sub { font-size: 11.5px; color: var(--text-hint); margin-top: 4px; }

    /* ── Filter bar ── */
    .filter-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-md); box-shadow: var(--shadow-card); padding: 16px 20px; margin-bottom: 20px; }
    .filter-row { display: flex; flex-wrap: wrap; gap: 12px; align-items: flex-end; }
    .filter-group { display: flex; flex-direction: column; gap: 5px; }
    .filter-label { font-size: 11.5px; font-weight: 600; text-transform: uppercase; letter-spacing: .04em; color: var(--text-secondary); }
    .filter-control {
        height: 36px; border: 1px solid var(--border); border-radius: var(--radius-sm);
        padding: 0 11px; font-size: 13px; color: var(--text-primary);
        background: var(--surface); outline: none; font-family: var(--font); min-width: 140px;
        transition: border-color .15s, box-shadow .15s;
    }
    .filter-control:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(48,61,137,.12); }

    /* ── Two-column main layout ── */
    .report-layout { display: grid; grid-template-columns: 1fr 300px; gap: 20px; align-items: start; }
    @media(max-width:1080px) { .report-layout { grid-template-columns: 1fr; } }

    /* ── Section card ── */
    .section-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-md); box-shadow: var(--shadow-card); overflow: hidden; margin-bottom: 16px; }
    .section-card:last-child { margin-bottom: 0; }
    .section-card-header { padding: 14px 20px; border-bottom: 1px solid var(--border); background: #fafafa; display: flex; align-items: center; justify-content: space-between; }
    .section-card-header h5 { font-size: 13px; font-weight: 650; color: var(--text-primary); margin: 0; }
    .section-card-body { padding: 20px; }

    /* ── Chart placeholder ── */
    .chart-area { width: 100%; height: 240px; position: relative; display: flex; align-items: flex-end; gap: 6px; padding: 0 0 28px; border-bottom: 2px solid var(--border); }
    .chart-bar-wrap { flex: 1; display: flex; flex-direction: column; align-items: center; gap: 5px; height: 100%; justify-content: flex-end; }
    .chart-bar { width: 100%; border-radius: 4px 4px 0 0; transition: opacity .15s; cursor: pointer; min-height: 4px; }
    .chart-bar:hover { opacity: .8; }
    .chart-label { font-size: 10px; color: var(--text-hint); white-space: nowrap; text-align: center; }
    .chart-value { font-size: 10px; font-weight: 700; color: var(--text-secondary); }
    .chart-y-axis { position: absolute; left: 0; top: 0; bottom: 28px; width: 36px; display: flex; flex-direction: column; justify-content: space-between; }
    .chart-y-label { font-size: 10px; color: var(--text-hint); text-align: right; }

    /* ── Donut chart (CSS) ── */
    .donut-wrap { display: flex; align-items: center; gap: 24px; }
    .donut-svg { flex-shrink: 0; }
    .donut-legend { display: flex; flex-direction: column; gap: 10px; }
    .legend-item { display: flex; align-items: center; gap: 8px; }
    .legend-dot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }
    .legend-name  { font-size: 12.5px; color: var(--text-secondary); }
    .legend-value { font-size: 12.5px; font-weight: 700; color: var(--text-primary); margin-left: auto; padding-left: 12px; }

    /* ── Product table ── */
    .data-table { width: 100%; border-collapse: collapse; }
    .data-table thead tr { background: #fafafa; border-bottom: 1px solid var(--border); }
    .data-table thead th { padding: 10px 14px; font-size: 11px; font-weight: 650; text-transform: uppercase; letter-spacing: .05em; color: var(--text-secondary); text-align: left; white-space: nowrap; }
    .data-table thead th.right { text-align: right; }
    .data-table tbody tr { border-bottom: 1px solid var(--border); transition: background .12s; }
    .data-table tbody tr:last-child { border-bottom: none; }
    .data-table tbody tr:hover { background: #fafbfc; }
    .data-table td { padding: 12px 14px; font-size: 13px; color: var(--text-primary); vertical-align: middle; }
    .data-table td.right { text-align: right; }
    .data-table td.muted { color: var(--text-secondary); }

    /* ── Product cell ── */
    .prod-cell { display: flex; align-items: center; gap: 10px; }
    .prod-thumb { width: 40px; height: 40px; border-radius: var(--radius-sm); object-fit: cover; border: 1px solid var(--border); flex-shrink: 0; background: var(--bg); display: flex; align-items: center; justify-content: center; color: var(--text-hint); font-size: 14px; overflow:hidden; }
    .prod-name { font-size: 13px; font-weight: 600; color: var(--text-primary); }
    .prod-sku  { font-size: 11.5px; color: var(--text-hint); margin-top: 1px; }

    /* ── ID chip ── */
    .id-chip { display: inline-block; background: var(--bg); border: 1px solid var(--border); border-radius: 6px; padding: 2px 7px; font-size: 11px; font-family: 'SF Mono','Fira Mono',monospace; color: var(--text-secondary); }

    /* ── Rank badge ── */
    .rank-badge { width: 24px; height: 24px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 750; flex-shrink: 0; }
    .rank-1 { background: #ffd700; color: #7a5c00; }
    .rank-2 { background: #c0c0c0; color: #4a4a4a; }
    .rank-3 { background: #cd7f32; color: #fff; }
    .rank-n { background: var(--bg); color: var(--text-hint); border: 1px solid var(--border); }

    /* ── Pills ── */
    .pill { display: inline-flex; align-items: center; gap: 4px; padding: 3px 9px; border-radius: 20px; font-size: 11.5px; font-weight: 600; white-space: nowrap; }
    .pill::before { content:''; width:5px; height:5px; border-radius:50%; flex-shrink:0; }
    .pill-active   { background: var(--green-bg); color: var(--green); }
    .pill-active::before { background: var(--green); }
    .pill-inactive { background: var(--red-bg);   color: var(--red); }
    .pill-inactive::before { background: var(--red); }
    .pill-low      { background: var(--amber-bg); color: var(--amber); }
    .pill-low::before { background: var(--amber); }

    /* ── Mini bar (in table) ── */
    .mini-bar-wrap { display: flex; align-items: center; gap: 8px; }
    .mini-bar-bg   { flex: 1; height: 6px; background: var(--bg); border-radius: 10px; overflow: hidden; min-width: 60px; }
    .mini-bar-fill { height: 100%; border-radius: 10px; }

    /* ── Growth indicator ── */
    .growth { font-size: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 3px; }
    .growth.up   { color: var(--green); }
    .growth.down { color: var(--red); }
    .growth.neutral { color: var(--text-hint); }

    /* ── Right sidebar ── */
    .sidebar-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-md); box-shadow: var(--shadow-card); overflow: hidden; margin-bottom: 16px; }
    .sidebar-card:last-child { margin-bottom: 0; }
    .sidebar-header { padding: 13px 18px; border-bottom: 1px solid var(--border); background: #fafafa; }
    .sidebar-header h5 { font-size: 13px; font-weight: 650; color: var(--text-primary); margin: 0; }
    .sidebar-body { padding: 16px 18px; }

    /* ── Sidebar metric row ── */
    .metric-row { display: flex; align-items: center; justify-content: space-between; padding: 9px 0; border-bottom: 1px solid var(--bg); }
    .metric-row:first-child { padding-top: 0; }
    .metric-row:last-child  { border-bottom: none; padding-bottom: 0; }
    .metric-label { font-size: 12.5px; color: var(--text-secondary); }
    .metric-value { font-size: 13px; font-weight: 700; color: var(--text-primary); }

    /* ── Category list in sidebar ── */
    .cat-row { display: flex; align-items: center; justify-content: space-between; padding: 9px 0; border-bottom: 1px solid var(--bg); }
    .cat-row:first-child { padding-top: 0; }
    .cat-row:last-child  { border-bottom: none; padding-bottom: 0; }
    .cat-name  { font-size: 12.5px; color: var(--text-primary); font-weight: 500; }
    .cat-count { font-size: 12.5px; font-weight: 700; color: var(--text-primary); }
    .cat-bar { height: 4px; border-radius: 10px; margin-top: 5px; }

    /* ── Pagination ── */
    .pagination-bar { padding: 13px 20px; border-top: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px; }
    .pagination-info { font-size: 12.5px; color: var(--text-hint); }
    .pagination-bar .pagination { margin: 0; }
    .pagination-bar .page-link { border-color: var(--border); color: var(--accent); font-size: 13px; border-radius: var(--radius-sm) !important; margin: 0 2px; }
    .pagination-bar .page-item.active .page-link { background: var(--accent); border-color: var(--accent); color: #fff; }
    .pagination-bar .page-item.disabled .page-link { color: var(--text-hint); }

    /* ── Empty ── */
    .empty-state { text-align: center; padding: 40px 20px; }
    .empty-icon-wrap { width: 52px; height: 52px; border-radius: 50%; background: var(--accent-light); margin: 0 auto 12px; display: flex; align-items: center; justify-content: center; color: var(--accent); font-size: 20px; }

    @media(max-width:768px) { .report-page { padding: 16px; } }
    </style>

    <div class="app-content content container-fluid">
        <div class="report-page">

            <!-- Page header -->
            <div class="page-header">
                <div>
                    <h1>Product Report</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        Reports
                        <span>›</span>
                        Product Report
                    </div>
                </div>
                <div style="display:flex;gap:10px;flex-wrap:wrap">
                    <a href="{{ route('admin.reports.products.export.csv', request()->query()) }}" class="btn-secondary-dash">
                        <i class="fa fa-download"></i> Export CSV
                    </a>
                    <a href="{{ route('admin.reports.products.export.pdf', request()->query()) }}" class="btn-secondary-dash">
                        <i class="fa fa-file-pdf-o"></i> Export PDF
                    </a>
                    <a href="{{ route('admin.reports.products') }}" class="btn-primary-dash">
                        <i class="fa fa-refresh"></i> Refresh
                    </a>
                </div>
            </div>

            <!-- KPI strip -->
            <div class="kpi-strip">
                <div class="kpi-card">
                    <div class="kpi-label">Total Products</div>
                    <div class="kpi-value">{{ number_format($totalProducts) }}</div>
                    <div style="display:flex;align-items:center;gap:8px;margin-top:8px">
                        <span class="kpi-trend up"><i class="fa fa-plus" style="font-size:10px"></i> {{ $newProductsCount }} new</span>
                        <span class="kpi-sub">this period</span>
                    </div>
                </div>
                <div class="kpi-card">
                    <div class="kpi-label">Total Units Sold</div>
                    <div class="kpi-value" style="color:var(--accent)">{{ number_format($unitsThis) }}</div>
                    <div style="display:flex;align-items:center;gap:8px;margin-top:8px">
                        @if($unitsGrowth > 0)
                            <span class="kpi-trend up"><i class="fa fa-arrow-up" style="font-size:10px"></i> {{ $unitsGrowth }}%</span>
                        @elseif($unitsGrowth < 0)
                            <span class="kpi-trend down"><i class="fa fa-arrow-down" style="font-size:10px"></i> {{ abs($unitsGrowth) }}%</span>
                        @else
                            <span class="kpi-trend" style="background:var(--bg);color:var(--text-hint)"><i class="fa fa-minus" style="font-size:10px"></i> 0%</span>
                        @endif
                        <span class="kpi-sub">vs prev period</span>
                    </div>
                </div>
                <div class="kpi-card">
                    <div class="kpi-label">Total Revenue</div>
                    <div class="kpi-value" style="color:var(--green)">
                        @if($revenueThis >= 100000)
                            ₹{{ number_format($revenueThis / 100000, 1) }}L
                        @else
                            ₹{{ number_format($revenueThis) }}
                        @endif
                    </div>
                    <div style="display:flex;align-items:center;gap:8px;margin-top:8px">
                        @if($revenueGrowth > 0)
                            <span class="kpi-trend up"><i class="fa fa-arrow-up" style="font-size:10px"></i> {{ $revenueGrowth }}%</span>
                        @elseif($revenueGrowth < 0)
                            <span class="kpi-trend down"><i class="fa fa-arrow-down" style="font-size:10px"></i> {{ abs($revenueGrowth) }}%</span>
                        @else
                            <span class="kpi-trend" style="background:var(--bg);color:var(--text-hint)"><i class="fa fa-minus" style="font-size:10px"></i> 0%</span>
                        @endif
                        <span class="kpi-sub">vs prev period</span>
                    </div>
                </div>
                <div class="kpi-card">
                    <div class="kpi-label">Out of Stock</div>
                    <div class="kpi-value" style="color:var(--red)">{{ number_format($outOfStockNow) }}</div>
                    <div style="display:flex;align-items:center;gap:8px;margin-top:8px">
                        @if($outOfStockDelta > 0)
                            <span class="kpi-trend down"><i class="fa fa-arrow-up" style="font-size:10px"></i> {{ $outOfStockDelta }}</span>
                        @elseif($outOfStockDelta < 0)
                            <span class="kpi-trend up"><i class="fa fa-arrow-down" style="font-size:10px"></i> {{ abs($outOfStockDelta) }}</span>
                        @else
                            <span class="kpi-trend" style="background:var(--bg);color:var(--text-hint)"><i class="fa fa-minus" style="font-size:10px"></i> 0</span>
                        @endif
                        <span class="kpi-sub">from last period</span>
                    </div>
                </div>
            </div>

            <!-- Filter bar -->
            <div class="filter-card">
                <form method="GET" action="{{ route('admin.reports.products') }}" id="filterForm">
                    <div class="filter-row">
                        <div class="filter-group" style="flex:1;min-width:180px">
                            <span class="filter-label">Search Product</span>
                            <div style="position:relative">
                                <i class="fa fa-search" style="position:absolute;left:10px;top:50%;transform:translateY(-50%);color:var(--text-hint);font-size:12px;pointer-events:none"></i>
                                <input type="text" name="search" class="filter-control" style="padding-left:30px;min-width:200px" placeholder="Product name, SKU…" value="{{ $search }}">
                            </div>
                        </div>
                        <div class="filter-group">
                            <span class="filter-label">Category</span>
                            <select name="category_id" class="filter-control">
                                <option value="">All Categories</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ $categoryId == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="filter-group">
                            <span class="filter-label">Status</span>
                            <select name="status" class="filter-control">
                                <option value="">All Status</option>
                                <option value="active" {{ $status === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ $status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="out_of_stock" {{ $status === 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                                <option value="low_stock" {{ $status === 'low_stock' ? 'selected' : '' }}>Low Stock</option>
                            </select>
                        </div>
                        <div class="filter-group">
                            <span class="filter-label">Sort By</span>
                            <select name="sort_by" class="filter-control">
                                <option value="revenue" {{ $sortBy === 'revenue' ? 'selected' : '' }}>Revenue: High to Low</option>
                                <option value="units" {{ $sortBy === 'units' ? 'selected' : '' }}>Units Sold: High to Low</option>
                                <option value="orders" {{ $sortBy === 'orders' ? 'selected' : '' }}>Orders: High to Low</option>
                                <option value="stock" {{ $sortBy === 'stock' ? 'selected' : '' }}>Stock: Low to High</option>
                                <option value="rating" {{ $sortBy === 'rating' ? 'selected' : '' }}>Avg Rating: High to Low</option>
                                <option value="newest" {{ $sortBy === 'newest' ? 'selected' : '' }}>Recently Added</option>
                            </select>
                        </div>
                        <div class="filter-group">
                            <span class="filter-label">Date Range</span>
                            <select name="range" class="filter-control" id="dateRange">
                                <option value="7days" {{ $range === '7days' ? 'selected' : '' }}>Last 7 Days</option>
                                <option value="30days" {{ $range === '30days' ? 'selected' : '' }}>Last 30 Days</option>
                                <option value="3months" {{ $range === '3months' ? 'selected' : '' }}>Last 3 Months</option>
                                <option value="6months" {{ $range === '6months' ? 'selected' : '' }}>Last 6 Months</option>
                                <option value="year" {{ $range === 'year' ? 'selected' : '' }}>This Year</option>
                                <option value="custom" {{ $range === 'custom' ? 'selected' : '' }}>Custom</option>
                            </select>
                        </div>
                        <div style="display:flex;gap:8px;align-items:flex-end;padding-top:2px">
                            <button type="submit" class="btn-primary-dash"><i class="fa fa-search"></i> Apply</button>
                            <a href="{{ route('admin.reports.products') }}" class="btn-secondary-dash"><i class="fa fa-refresh"></i> Reset</a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Main two-column layout -->
            <div class="report-layout">

                <!-- ══ LEFT COLUMN ══ -->
                <div style="overflow:hidden;">

                    <!-- Sales by Product (bar chart) -->
                    <div class="section-card">
                        <div class="section-card-header">
                            <h5><i class="fa-solid fa-chart-bar" style="color:var(--accent);margin-right:6px"></i> Units Sold — Top Products ({{ $start->format('d M') }} – {{ $end->format('d M Y') }})</h5>
                            <span style="font-size:12px;color:var(--text-hint)">By units sold</span>
                        </div>
                        <div class="section-card-body">
                            @if($topBarProducts->isEmpty())
                                <div class="empty-state">No sales data for this period.</div>
                            @else
                                <div style="position:relative;padding-left:40px">
                                    <!-- Y axis labels -->
                                    <div style="position:absolute;left:0;top:0;bottom:28px;width:36px;display:flex;flex-direction:column;justify-content:space-between">
                                        @php $yMax = $topBarProducts->max('units'); @endphp
                                        @for($yi = 4; $yi >= 0; $yi--)
                                            @php $yVal = round($yMax * ($yi / 4)); @endphp
                                            <span style="font-size:10px;color:var(--text-hint);text-align:right">{{ $yVal >= 1000 ? round($yVal / 1000, 1) . 'k' : $yVal }}</span>
                                        @endfor
                                    </div>
                                    <!-- Grid lines -->
                                    <div style="position:relative">
                                        <div style="position:absolute;inset:0 0 28px 0;display:flex;flex-direction:column;justify-content:space-between;pointer-events:none">
                                            <div style="border-top:1px dashed var(--border)"></div>
                                            <div style="border-top:1px dashed var(--border)"></div>
                                            <div style="border-top:1px dashed var(--border)"></div>
                                            <div style="border-top:1px dashed var(--border)"></div>
                                            <div style="border-top:2px solid var(--border)"></div>
                                        </div>
                                        <div class="chart-area" style="padding-left:0">
                                            @foreach($topBarProducts as $bp)
                                                @php
                                                    $barPct = $maxUnits > 0 ? round(($bp->units / $maxUnits) * 100) : 0;
                                                    $barColor = $barPct >= 70 ? 'var(--accent)' : ($barPct >= 40 ? 'var(--blue)' : 'var(--text-hint)');
                                                @endphp
                                                <div class="chart-bar-wrap">
                                                    <span class="chart-value">{{ number_format($bp->units) }}</span>
                                                    <div class="chart-bar" style="height:{{ $barPct }}%;background:{{ $barColor }}"></div>
                                                    <span class="chart-label" title="{{ $bp->product_name }}">{{ \Illuminate\Support\Str::limit($bp->product_name, 12) }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <!-- Legend -->
                                <div style="display:flex;gap:16px;margin-top:12px;flex-wrap:wrap">
                                    <span style="display:flex;align-items:center;gap:5px;font-size:12px;color:var(--text-secondary)"><span style="width:10px;height:10px;border-radius:2px;background:var(--accent);display:inline-block"></span> Top performers</span>
                                    <span style="display:flex;align-items:center;gap:5px;font-size:12px;color:var(--text-secondary)"><span style="width:10px;height:10px;border-radius:2px;background:var(--blue);display:inline-block"></span> Mid tier</span>
                                    <span style="display:flex;align-items:center;gap:5px;font-size:12px;color:var(--text-secondary)"><span style="width:10px;height:10px;border-radius:2px;background:var(--text-hint);display:inline-block"></span> Lower tier</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Revenue Trend (simple line-style chart) -->
                    <div class="section-card">
                        <div class="section-card-header">
                            <h5><i class="fa-solid fa-chart-line" style="color:var(--green);margin-right:6px"></i> Product Revenue Trend</h5>
                            <span style="font-size:12px;color:var(--text-hint)">Monthly revenue from products</span>
                        </div>
                        <div class="section-card-body">
                            <div style="display:flex;align-items:flex-end;gap:0;height:160px;border-bottom:2px solid var(--border);padding-bottom:0;position:relative">
                                <svg viewBox="0 0 700 140" style="width:100%;height:140px;overflow:visible" preserveAspectRatio="none">
                                    <line x1="0" y1="0"   x2="700" y2="0"   stroke="var(--border)" stroke-dasharray="4,4"/>
                                    <line x1="0" y1="35"  x2="700" y2="35"  stroke="var(--border)" stroke-dasharray="4,4"/>
                                    <line x1="0" y1="70"  x2="700" y2="70"  stroke="var(--border)" stroke-dasharray="4,4"/>
                                    <line x1="0" y1="105" x2="700" y2="105" stroke="var(--border)" stroke-dasharray="4,4"/>

                                    <defs>
                                        <linearGradient id="revGrad" x1="0" y1="0" x2="0" y2="1">
                                            <stop offset="0%"   stop-color="#303d89" stop-opacity=".18"/>
                                            <stop offset="100%" stop-color="#303d89" stop-opacity="0"/>
                                        </linearGradient>
                                    </defs>

                                    @if($trendPoints)
                                        <polygon points="{{ $trendPoints }} 700,140 0,140" fill="url(#revGrad)"/>
                                        <polyline points="{{ $trendPoints }}" fill="none" stroke="#303d89" stroke-width="2.5" stroke-linejoin="round" stroke-linecap="round"/>

                                        @foreach($trendCoords as $i => $pt)
                                            @if($i === count($trendCoords) - 1)
                                                <circle cx="{{ $pt['x'] }}" cy="{{ $pt['y'] }}" r="4" fill="#303d89" stroke="#303d89" stroke-width="2"/>
                                            @else
                                                <circle cx="{{ $pt['x'] }}" cy="{{ $pt['y'] }}" r="4" fill="#fff" stroke="#303d89" stroke-width="2"/>
                                            @endif
                                        @endforeach
                                    @else
                                        <text x="350" y="75" text-anchor="middle" font-size="12" fill="#8c9196">No data</text>
                                    @endif
                                </svg>
                            </div>
                            <!-- Month labels -->
                            <div style="display:flex;justify-content:space-between;margin-top:8px;padding:0 2px">
                                @foreach($trendLabels as $label)
                                    <span style="font-size:11px;color:var(--text-hint)">{{ $label }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Product Performance Table -->
                    <div class="section-card">
                        <div class="section-card-header">
                            <h5><i class="fa-solid fa-table" style="color:var(--accent);margin-right:6px"></i> Product Performance</h5>
                            <span style="font-size:12px;color:var(--text-hint)">{{ number_format($products->total()) }} products ranked by {{ str_replace('_', ' ', $sortBy) }}</span>
                        </div>

                        <div style="overflow-x:auto">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th style="width:44px">#</th>
                                        <th>Product</th>
                                        <th class="right">Units Sold</th>
                                        <th class="right">Revenue</th>
                                        <th class="right">Avg Price</th>
                                        <th class="right">Orders</th>
                                        <th style="min-width:120px">Stock</th>
                                        <th class="right">Rating</th>
                                        <th class="right">Growth</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($products as $p)
                                        @php
                                            $rankClass = match(true) {
                                                $p->rank === 1 => 'rank-1',
                                                $p->rank === 2 => 'rank-2',
                                                $p->rank === 3 => 'rank-3',
                                                default        => 'rank-n',
                                            };
                                            $miniBarColor = match($p->stock_status) {
                                                'out_of_stock' => 'var(--red)',
                                                'low_stock'    => 'var(--amber)',
                                                default        => 'var(--green)',
                                            };
                                            $miniBarTextColor = match($p->stock_status) {
                                                'out_of_stock' => 'var(--red)',
                                                'low_stock'    => 'var(--amber)',
                                                default        => 'var(--text-primary)',
                                            };
                                            $pillClass = match($p->stock_status) {
                                                'out_of_stock' => 'pill-inactive',
                                                'low_stock'    => 'pill-low',
                                                'inactive'     => 'pill-inactive',
                                                default        => 'pill-active',
                                            };
                                            $pillLabel = match($p->stock_status) {
                                                'out_of_stock' => 'Out of Stock',
                                                'low_stock'    => 'Low Stock',
                                                'inactive'     => 'Inactive',
                                                default        => 'Active',
                                            };
                                            $rating = round($p->reviews_avg_rating ?? 0, 1);
                                        @endphp
                                        <tr>
                                            <td><span class="rank-badge {{ $rankClass }}">{{ $p->rank }}</span></td>
                                            <td>
                                                <div class="prod-cell">
                                                    <div class="prod-thumb">
                                                        @if($p->image)
                                                            <img src="{{ asset('storage/' . $p->image) }}" style="width:100%;height:100%;object-fit:cover" alt="{{ $p->name }}">
                                                        @else
                                                            <i class="fa fa-image"></i>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <div class="prod-name">{{ $p->name }}</div>
                                                        <div class="prod-sku">SKU: {{ $p->sku }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="right" style="font-weight:700">{{ number_format($p->units_sold) }}</td>
                                            <td class="right" style="font-weight:700;color:var(--green)">₹{{ number_format($p->revenue) }}</td>
                                            <td class="right muted">₹{{ number_format($p->avg_price) }}</td>
                                            <td class="right muted">{{ number_format($p->order_count) }}</td>
                                            <td>
                                                <div class="mini-bar-wrap">
                                                    <div class="mini-bar-bg"><div class="mini-bar-fill" style="width:{{ $p->stock_pct }}%;background:{{ $miniBarColor }}"></div></div>
                                                    <span style="font-size:12px;font-weight:700;color:{{ $miniBarTextColor }};min-width:28px">{{ number_format($p->stock) }}</span>
                                                </div>
                                            </td>
                                            <td class="right">
                                                @if($rating > 0)
                                                    <span style="color:#f59e0b;font-size:12px">★</span>
                                                    <span style="font-size:12.5px;font-weight:700">{{ $rating }}</span>
                                                @else
                                                    <span style="color:var(--text-hint);font-size:12px">—</span>
                                                @endif
                                            </td>
                                            <td class="right">
                                                @if($p->growth > 0)
                                                    <span class="growth up"><i class="fa fa-arrow-up" style="font-size:9px"></i> {{ $p->growth }}%</span>
                                                @elseif($p->growth < 0)
                                                    <span class="growth down"><i class="fa fa-arrow-down" style="font-size:9px"></i> {{ abs($p->growth) }}%</span>
                                                @else
                                                    <span class="growth neutral"><i class="fa fa-minus" style="font-size:9px"></i> 0%</span>
                                                @endif
                                            </td>
                                            <td><span class="pill {{ $pillClass }}">{{ $pillLabel }}</span></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10">
                                                <div class="empty-state">No products found matching your filters.</div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="pagination-bar">
                            <div class="pagination-info">Showing {{ $products->firstItem() }}–{{ $products->lastItem() }} of {{ number_format($products->total()) }} products</div>
                            {{ $products->links() }}
                        </div>
                    </div>

                </div><!-- /left -->

                <!-- ══ RIGHT SIDEBAR ══ -->
                <div>

                    <!-- Revenue by Category (donut) -->
                    <div class="sidebar-card">
                        <div class="sidebar-header"><h5>Revenue by Category</h5></div>
                        <div class="sidebar-body">
                            @if($donutCategories->isEmpty())
                                <div class="empty-state" style="padding:20px 0">No data.</div>
                            @else
                                <div class="donut-wrap">
                                    <svg width="110" height="110" viewBox="0 0 110 110" class="donut-svg">
                                        <circle cx="55" cy="55" r="40" fill="none" stroke="#e3e5e8" stroke-width="18"/>
                                        @foreach($donutSegments as $seg)
                                            <circle cx="55" cy="55" r="40" fill="none" stroke="{{ $seg['color'] }}" stroke-width="18"
                                                    stroke-dasharray="{{ $seg['dash'] }}" stroke-dashoffset="{{ $seg['offset'] }}"
                                                    transform="rotate(-90 55 55)"/>
                                        @endforeach
                                        <text x="55" y="50" text-anchor="middle" font-size="12" font-weight="700" fill="#202223">
                                            @if($totalCatRevenue >= 100000)
                                                ₹{{ number_format($totalCatRevenue / 100000, 1) }}L
                                            @else
                                                ₹{{ number_format($totalCatRevenue) }}
                                            @endif
                                        </text>
                                        <text x="55" y="64" text-anchor="middle" font-size="9" fill="#8c9196">Total</text>
                                    </svg>
                                    <div class="donut-legend">
                                        @foreach($donutCategories as $cat)
                                            <div class="legend-item">
                                                <span class="legend-dot" style="background:{{ $cat['color'] }}"></span>
                                                <span class="legend-name">{{ $cat['name'] }}</span>
                                                <span class="legend-value">{{ $cat['pct'] }}%</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Key metrics -->
                    <div class="sidebar-card">
                        <div class="sidebar-header"><h5>Key Metrics</h5></div>
                        <div class="sidebar-body">
                            <div class="metric-row">
                                <span class="metric-label">Avg Revenue / Product</span>
                                <span class="metric-value">₹{{ number_format($avgRevenuePerProduct) }}</span>
                            </div>
                            <div class="metric-row">
                                <span class="metric-label">Avg Units / Product</span>
                                <span class="metric-value">{{ $avgUnitsPerProduct }}</span>
                            </div>
                            <div class="metric-row">
                                <span class="metric-label">Avg Rating (all)</span>
                                <span class="metric-value" style="color:#f59e0b">{{ $avgRating > 0 ? '★ ' . $avgRating : '—' }}</span>
                            </div>
                            <div class="metric-row">
                                <span class="metric-label">Return Rate</span>
                                <span class="metric-value" style="color:var(--red)">{{ $returnRate }}%</span>
                            </div>
                            <div class="metric-row">
                                <span class="metric-label">Products with Reviews</span>
                                <span class="metric-value">{{ $reviewedPct }}%</span>
                            </div>
                            <div class="metric-row">
                                <span class="metric-label">New Products (period)</span>
                                <span class="metric-value" style="color:var(--accent)">{{ $newProductsCount }}</span>
                            </div>
                            <div class="metric-row">
                                <span class="metric-label">Conversion Rate</span>
                                <span class="metric-value" style="color:var(--green)">{{ $conversionRate }}%</span>
                            </div>
                        </div>
                    </div>

                    <!-- Category breakdown -->
                    <div class="sidebar-card">
                        <div class="sidebar-header"><h5>Products by Category</h5></div>
                        <div class="sidebar-body">
                            @php $catBarColors = ['var(--accent)', 'var(--blue)', 'var(--green)', 'var(--amber)', 'var(--purple)']; @endphp
                            @forelse($categoryProductCounts as $i => $cat)
                                <div class="cat-row">
                                    <div style="flex:1">
                                        <div class="cat-name">{{ $cat->name }}</div>
                                        <div class="cat-bar" style="width:{{ $maxCatCount > 0 ? round(($cat->products_count / $maxCatCount) * 100) : 0 }}%;background:{{ $catBarColors[$i % 5] }}"></div>
                                    </div>
                                    <span class="cat-count">{{ number_format($cat->products_count) }}</span>
                                </div>
                            @empty
                                <div class="empty-state" style="padding:16px 0">No categories found.</div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Top rated -->
                    <div class="sidebar-card">
                        <div class="sidebar-header"><h5>⭐ Highest Rated</h5></div>
                        <div class="sidebar-body">
                            @forelse($topRated as $p)
                                <div class="metric-row">
                                    <div>
                                        <div style="font-size:13px;font-weight:600;color:var(--text-primary)">{{ \Illuminate\Support\Str::limit($p->name, 22) }}</div>
                                        <div style="font-size:11.5px;color:var(--text-hint)">{{ number_format($p->reviews_count) }} reviews</div>
                                    </div>
                                    <span class="metric-value" style="color:#f59e0b">★ {{ round($p->reviews_avg_rating, 1) }}</span>
                                </div>
                            @empty
                                <div class="empty-state" style="padding:16px 0">No reviews yet.</div>
                            @endforelse
                        </div>
                    </div>

                </div><!-- /right sidebar -->

            </div><!-- /report-layout -->

        </div>
    </div>
</div>

@include('admin.footer')

<script>
document.getElementById('dateRange')?.addEventListener('change', function () {
    document.getElementById('filterForm').submit();
});

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.chart-bar').forEach(bar => {
        const target = bar.style.height;
        bar.style.height = '0';
        setTimeout(() => { bar.style.transition = 'height .6s ease'; bar.style.height = target; }, 100);
    });
    document.querySelectorAll('.mini-bar-fill').forEach(fill => {
        const target = fill.style.width;
        fill.style.width = '0';
        setTimeout(() => { fill.style.transition = 'width .8s ease'; fill.style.width = target; }, 200);
    });
    document.querySelectorAll('.cat-bar').forEach(bar => {
        const target = bar.style.width;
        bar.style.width = '0';
        setTimeout(() => { bar.style.transition = 'width .7s ease'; bar.style.width = target; }, 300);
    });
});
</script>