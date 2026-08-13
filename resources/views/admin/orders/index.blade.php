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
    .orders-page { background: var(--bg); padding: 24px 28px; min-height: 100vh; font-family: var(--font); color: var(--text-primary); }
    .orders-page * { box-sizing: border-box; }

    .orders-page-header { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 20px; }
    .orders-page-header h1 { font-size: 20px; font-weight: 650; color: var(--text-primary); margin: 0; }
    .crumb { font-size: 12.5px; color: var(--text-hint); margin-top: 3px; }
    .crumb a { color: var(--accent); text-decoration: none; }
    .crumb a:hover { text-decoration: underline; }
    .crumb span { margin: 0 5px; }

    .kpi-strip { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 20px; }
    @media(max-width:900px) { .kpi-strip { grid-template-columns: repeat(2,1fr); } }
    @media(max-width:500px) { .kpi-strip { grid-template-columns: 1fr; } }
    .kpi-tile { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 16px 18px; box-shadow: var(--shadow-card); display: flex; align-items: center; gap: 14px; }
    .kpi-tile-icon { width: 40px; height: 40px; border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0; }
    .kpi-tile-icon.blue   { background: var(--blue-bg);   color: var(--blue); }
    .kpi-tile-icon.green  { background: var(--green-bg);  color: var(--green); }
    .kpi-tile-icon.amber  { background: var(--amber-bg);  color: var(--amber); }
    .kpi-tile-icon.purple { background: var(--purple-bg); color: var(--purple); }
    .kpi-tile-label { font-size: 11.5px; font-weight: 600; color: var(--text-hint); text-transform: uppercase; letter-spacing: .04em; }
    .kpi-tile-value { font-size: 22px; font-weight: 700; color: var(--text-primary); line-height: 1.1; margin-top: 2px; }

    .btn-primary-dash, .btn-secondary-dash, .btn-filter-search, .btn-filter-reset {
        display: inline-flex; align-items: center; gap: 6px;
        border-radius: var(--radius-sm); padding: 8px 16px;
        font-size: 13px; font-weight: 600; cursor: pointer;
        text-decoration: none !important; font-family: var(--font);
        transition: background .15s;
    }
    .btn-primary-dash  { background: var(--accent); color: #fff !important; border: none; }
    .btn-primary-dash:hover { background: #252f70; }
    .btn-secondary-dash { background: var(--surface); color: var(--text-primary) !important; border: 1px solid var(--border); font-weight: 500; }
    .btn-secondary-dash:hover { background: var(--bg); }
    .btn-filter-search { background: var(--accent); color: #fff; border: none; height: 36px; }
    .btn-filter-reset  { background: var(--surface); color: var(--text-primary); border: 1px solid var(--border); height: 36px; font-weight: 500; }

    .orders-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-md); box-shadow: var(--shadow-card); overflow: hidden; }
    .filter-bar { padding: 16px 20px; border-bottom: 1px solid var(--border); background: var(--surface); }
    .filter-row { display: flex; flex-wrap: wrap; gap: 12px; align-items: flex-end; }
    .filter-group { display: flex; flex-direction: column; gap: 5px; }
    .filter-group label { font-size: 12px; font-weight: 600; color: var(--text-secondary); letter-spacing: .03em; text-transform: uppercase; }
    .filter-control {
        height: 36px; border: 1px solid var(--border); border-radius: var(--radius-sm);
        padding: 0 11px; font-size: 13px; color: var(--text-primary); background: var(--surface);
        outline: none; transition: border-color .15s, box-shadow .15s; font-family: var(--font); min-width: 150px;
    }
    .filter-control:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(48,61,137,.12); }
    .filter-control-wide { min-width: 220px; }
    .filter-actions { display: flex; gap: 8px; align-items: center; }

    .status-tabs { display: flex; gap: 0; border-bottom: 1px solid var(--border); background: var(--surface); padding: 0 20px; overflow-x: auto; }
    .status-tab { display: inline-flex; align-items: center; gap: 6px; padding: 12px 16px; font-size: 13px; font-weight: 500; color: var(--text-secondary); text-decoration: none; border-bottom: 2px solid transparent; white-space: nowrap; transition: color .15s; }
    .status-tab:hover { color: var(--text-primary); }
    .status-tab.active { color: var(--accent); border-bottom-color: var(--accent); font-weight: 600; }
    .tab-count { background: var(--bg); color: var(--text-hint); font-size: 11px; font-weight: 700; padding: 2px 6px; border-radius: 20px; }

    .orders-table-wrap { overflow-x: auto; }
    .orders-table { width: 100%; border-collapse: collapse; font-size: 13px; font-family: var(--font); }
    .orders-table thead th {
        font-size: 11px; font-weight: 600; letter-spacing: .06em; text-transform: uppercase;
        color: var(--text-hint); padding: 10px 16px; border-bottom: 1px solid var(--border);
        background: #fafafa; text-align: left; white-space: nowrap;
    }
    .orders-table tbody tr { border-bottom: 1px solid var(--border); transition: background .1s; }
    .orders-table tbody tr:last-child { border-bottom: none; }
    .orders-table tbody tr:hover { background: #fafbfc; }
    .orders-table tbody td { padding: 13px 16px; color: var(--text-primary); vertical-align: middle; }

    .order-id { font-size: 13px; font-weight: 700; color: var(--accent); font-family: 'SF Mono','Fira Code',monospace; }
    .customer-avatar { width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; flex-shrink: 0; }
    .customer-name  { font-size: 13px; font-weight: 600; color: var(--text-primary); }
    .customer-email { font-size: 11.5px; color: var(--text-hint); margin-top: 1px; }
    .amount-cell { font-size: 14px; font-weight: 700; color: var(--text-primary); }
    .items-chip { display: inline-flex; align-items: center; gap: 4px; background: var(--bg); color: var(--text-secondary); font-size: 12px; font-weight: 600; padding: 2px 8px; border-radius: 6px; }
    .date-cell { font-size: 12.5px; color: var(--text-secondary); }
    .date-cell small { display: block; color: var(--text-hint); font-size: 11.5px; margin-top: 1px; }

    .pay-pill, .order-pill { display: inline-flex; align-items: center; gap: 4px; font-size: 11.5px; font-weight: 600; padding: 3px 9px; border-radius: 20px; }
    .pay-pill::before, .order-pill::before { content:''; width: 5px; height: 5px; border-radius: 50%; display: inline-block; }
    .pay-paid      { background: var(--green-bg);  color: var(--green); }
    .pay-pending   { background: var(--amber-bg);  color: var(--amber); }
    .pay-failed    { background: var(--red-bg);    color: var(--red); }
    .pay-refunded  { background: var(--purple-bg); color: var(--purple); }
    .order-new        { background: var(--blue-bg);   color: var(--blue); }
    .order-processing { background: var(--amber-bg);  color: var(--amber); }
    .order-shipped    { background: var(--purple-bg); color: var(--purple); }
    .order-delivered  { background: var(--green-bg);  color: var(--green); }
    .order-cancelled  { background: var(--red-bg);    color: var(--red); }

    .action-btn {
        display: inline-flex; align-items: center; justify-content: center;
        width: 30px; height: 30px; border-radius: var(--radius-sm);
        border: 1px solid var(--border); background: var(--surface);
        color: var(--text-secondary); font-size: 12px; cursor: pointer;
        transition: all .12s; text-decoration: none;
    }
    .action-btn:hover { background: var(--bg); color: var(--text-primary); }

    .empty-state { text-align: center; padding: 64px 20px; }
    .empty-state .empty-icon { width: 56px; height: 56px; border-radius: 50%; background: var(--bg); display: inline-flex; align-items: center; justify-content: center; font-size: 22px; color: var(--text-hint); margin-bottom: 14px; }

    .orders-pagination { padding: 14px 20px; border-top: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; background: var(--surface); flex-wrap: wrap; gap: 10px; }
    .pagination-info { font-size: 12.5px; color: var(--text-hint); }

    @media(max-width:768px) {
        .orders-page { padding: 16px; }
        .filter-row { flex-direction: column; }
        .filter-control { min-width: 100%; }
    }
    </style>

    <div class="app-content content container-fluid">
        <div class="orders-page">

            {{-- ── Page header ── --}}
            <div class="orders-page-header">
                <div>
                    <h1>Orders</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        Manage Orders
                    </div>
                </div>
                <div style="display:flex;gap:8px;flex-wrap:wrap">
                    <a href="{{ route('admin.orders.export', request()->query()) }}" class="btn-secondary-dash">
                        <i class="fa fa-download"></i> Export CSV
                    </a>
                </div>
            </div>

            {{-- ── KPI strip ── --}}
            <div class="kpi-strip">
                <div class="kpi-tile">
                    <div class="kpi-tile-icon blue"><i class="fa fa-shopping-bag"></i></div>
                    <div>
                        <div class="kpi-tile-label">Total Orders</div>
                        <div class="kpi-tile-value">{{ number_format($kpi['total']) }}</div>
                    </div>
                </div>
                <div class="kpi-tile">
                    <div class="kpi-tile-icon amber"><i class="fa fa-clock-o"></i></div>
                    <div>
                        <div class="kpi-tile-label">Pending</div>
                        <div class="kpi-tile-value">{{ number_format($kpi['pending']) }}</div>
                    </div>
                </div>
                <div class="kpi-tile">
                    <div class="kpi-tile-icon purple"><i class="fa fa-truck"></i></div>
                    <div>
                        <div class="kpi-tile-label">Shipped</div>
                        <div class="kpi-tile-value">{{ number_format($kpi['shipped']) }}</div>
                    </div>
                </div>
                <div class="kpi-tile">
                    <div class="kpi-tile-icon green"><i class="fa fa-check-circle"></i></div>
                    <div>
                        <div class="kpi-tile-label">Delivered</div>
                        <div class="kpi-tile-value">{{ number_format($kpi['delivered']) }}</div>
                    </div>
                </div>
            </div>

            {{-- ── Customer filter banner ── --}}
            @if(request('customer'))
                @php $filteredCustomer = \App\Models\Customer::find(request('customer')); @endphp
                @if($filteredCustomer)
                    <div style="background:var(--accent-light);border:1px solid var(--border);border-radius:var(--radius-sm);padding:10px 16px;margin-bottom:14px;display:flex;align-items:center;justify-content:space-between;font-size:13px;color:var(--text-primary)">
                        <span>Showing orders for <strong>{{ $filteredCustomer->name }}</strong></span>
                        <a href="{{ route('admin.orders.index') }}" style="color:var(--accent);font-weight:600;text-decoration:none">Clear filter ✕</a>
                    </div>
                @endif
            @endif

            {{-- ── Main card ── --}}
            <div class="orders-card">

                {{-- Status tabs --}}
                <div class="status-tabs">
                    @php
                        $tabs = [
                            'all'        => 'All',
                            'new'        => 'New',
                            'processing' => 'Processing',
                            'shipped'    => 'Shipped',
                            'delivered'  => 'Delivered',
                            'cancelled'  => 'Cancelled',
                        ];
                    @endphp
                    @foreach($tabs as $key => $label)
                        <a href="{{ route('admin.orders.index', array_merge(request()->except('tab','page'), ['tab' => $key])) }}"
                           class="status-tab {{ $activeTab === $key ? 'active' : '' }}">
                            {{ $label }}
                            <span class="tab-count">{{ number_format($tabCounts[$key] ?? 0) }}</span>
                        </a>
                    @endforeach
                </div>

                {{-- Filter bar --}}
                <div class="filter-bar">
                    <form method="GET" action="{{ route('admin.orders.index') }}">
                      <input type="hidden" name="tab" value="{{ $activeTab }}">
<input type="hidden" name="customer" value="{{ request('customer') }}">
                        <div class="filter-row">
                            <div class="filter-group" style="flex:1">
                                <label>Search</label>
                                <input type="text" name="search" value="{{ request('search') }}"
                                       class="filter-control filter-control-wide"
                                       placeholder="Order ID, customer name or email…">
                            </div>
                            <div class="filter-group">
                                <label>Payment</label>
                                <select name="payment" class="filter-control">
                                    <option value="">All</option>
                                    @foreach(['paid','pending','failed','refunded'] as $ps)
                                        <option value="{{ $ps }}" {{ request('payment') === $ps ? 'selected' : '' }}>
                                            {{ ucfirst($ps) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="filter-group">
                                <label>From Date</label>
                                <input type="date" name="from_date" value="{{ request('from_date') }}"
                                       class="filter-control" style="min-width:140px">
                            </div>
                            <div class="filter-group">
                                <label>To Date</label>
                                <input type="date" name="to_date" value="{{ request('to_date') }}"
                                       class="filter-control" style="min-width:140px">
                            </div>
                            <div class="filter-actions">
                                <button type="submit" class="btn-filter-search">
                                    <i class="fa fa-search"></i> Search
                                </button>
                                <a href="{{ route('admin.orders.index') }}" class="btn-filter-reset">
                                    <i class="fa fa-refresh"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Table --}}
                <div class="orders-table-wrap">
                    <table class="orders-table">
                        <thead>
                            <tr>
                                <th>Order</th>
                                <th>Customer</th>
                                <th>Items</th>
                                <th>Amount</th>
                                <th>Payment</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th style="width:110px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                @php
                                    // Avatar initials from customer name
                                    $words    = explode(' ', trim($order->customer_name));
                                    $initials = strtoupper(
                                        substr($words[0] ?? '', 0, 1) .
                                        substr($words[1] ?? '', 0, 1)
                                    );

                                    // Cycle avatar colours by order id
                                    $avatarPalette = [
                                        ['#e8f2ff','#0069d9'],
                                        ['#fff5cc','#916a00'],
                                        ['#ede9fe','#6d28d9'],
                                        ['#e3f1ec','#007a5e'],
                                        ['#fce8e8','#b22222'],
                                    ];
                                    [$avBg, $avColor] = $avatarPalette[$order->id % count($avatarPalette)];

                                    // Payment pill CSS class
                                    $payClass = match($order->payment_status) {
                                        'paid'     => 'pay-paid',
                                        'pending'  => 'pay-pending',
                                        'failed'   => 'pay-failed',
                                        'refunded' => 'pay-refunded',
                                        default    => 'pay-pending',
                                    };

                                    // Order status pill CSS class
                                    $orderClass = match($order->status) {
                                        'new'        => 'order-new',
                                        'processing' => 'order-processing',
                                        'shipped'    => 'order-shipped',
                                        'delivered'  => 'order-delivered',
                                        'cancelled'  => 'order-cancelled',
                                        default      => 'order-new',
                                    };
                                @endphp
                                <tr>
                                    <td>
                                        <span class="order-id">#{{ $order->order_number }}</span>
                                    </td>
                                    <td>
                                        <div style="display:flex;align-items:center;gap:10px">
                                            <div class="customer-avatar"
                                                 style="background:{{ $avBg }};color:{{ $avColor }}">
                                                {{ $initials }}
                                            </div>
                                            <div>
                                                <div class="customer-name">{{ $order->customer_name }}</div>
                                                <div class="customer-email">{{ $order->customer_email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="items-chip">
                                            <i class="fa fa-cube" style="font-size:10px"></i>
                                            {{ $order->items->count() }}
                                            {{ Str::plural('item', $order->items->count()) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="amount-cell">₹{{ number_format($order->grand_total, 2) }}</span>
                                    </td>
                                    <td>
                                        <span class="pay-pill {{ $payClass }}">
                                            {{ ucfirst($order->payment_status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="order-pill {{ $orderClass }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="date-cell">
                                            {{ $order->created_at->format('d M Y') }}
                                            <small>{{ $order->created_at->format('h:i A') }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="display:flex;gap:5px">
                                            {{-- View order --}}
                                            <a href="{{ route('admin.orders.show', $order) }}"
                                               class="action-btn" title="View Order">
                                                <i class="fa fa-eye"></i>
                                            </a>

                                            {{-- Invoice PDF (only if invoice exists) --}}
                                            @if($order->invoice)
                                                <a href="{{ route('admin.orders.invoice', $order) }}"
                                                   class="action-btn" title="Download Invoice" target="_blank">
                                                   <i class="fa-solid fa-file-pdf"></i>
                                                </a>
                                            @endif

                                            {{-- Customer profile --}}
                                            @if($order->customer_id)
                                                <a href="{{ route('admin.customers.show', $order->customer_id) }}"
                                                   class="action-btn" title="View Customer">
                                                    <i class="fa fa-user"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">
                                        <div class="empty-state">
                                            <div class="empty-icon"><i class="fa fa-shopping-bag"></i></div>
                                            <p style="font-size:15px;font-weight:600;color:var(--text-primary);margin:0 0 6px">
                                                No orders found
                                            </p>
                                            <p style="font-size:13px;color:var(--text-hint);margin:0">
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
                <div class="orders-pagination">
                    <div class="pagination-info">
                        @if($orders->total() > 0)
                            Showing {{ $orders->firstItem() }}–{{ $orders->lastItem() }}
                            of {{ number_format($orders->total()) }} orders
                        @else
                            No orders found
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

            </div>{{-- /.orders-card --}}
        </div>{{-- /.orders-page --}}
    </div>
</div>

@include('admin.footer')