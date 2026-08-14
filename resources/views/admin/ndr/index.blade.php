@include('admin.top-header')
<div class="main-section">
    @include('admin.header')

    <style>
    :root {
        --bg: #f1f2f4; --surface: #ffffff; --border: #e3e5e8;
        --text-primary: #202223; --text-secondary: #6d7175; --text-hint: #8c9196;
        --accent: #303d89; --accent-light: #f0f1fc;
        --green: #007a5e; --green-bg: #e3f1ec;
        --red: #b22222; --red-bg: #fce8e8;
        --amber: #916a00; --amber-bg: #fff5cc;
        --blue: #185fa5; --blue-bg: #e6f1fb;
        --radius-sm: 8px; --radius-md: 12px;
        --shadow-card: 0 1px 3px rgba(0,0,0,.08), 0 0 0 1px var(--border);
        --font: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }
    .list-page { background: var(--bg); padding: 24px 28px; min-height: 100vh; font-family: var(--font); color: var(--text-primary); }
    .list-page * { box-sizing: border-box; }
    .list-page-header { display: flex; align-items: flex-start; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 20px; }
    .list-page-header h1 { font-size: 20px; font-weight: 650; margin: 0; }
    .crumb { font-size: 12.5px; color: var(--text-hint); margin-top: 3px; }
    .crumb a { color: var(--accent); text-decoration: none; }
    .crumb span { margin: 0 5px; }

    .stat-strip { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 20px; }
    @media(max-width:800px) { .stat-strip { grid-template-columns: repeat(2,1fr); } }
    .stat-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 16px 18px; box-shadow: var(--shadow-card); }
    .stat-label { font-size: 11.5px; font-weight: 600; text-transform: uppercase; letter-spacing: .04em; color: var(--text-hint); margin-bottom: 6px; }
    .stat-value { font-size: 22px; font-weight: 700; line-height: 1; }
    .stat-sub { font-size: 11.5px; color: var(--text-hint); margin-top: 4px; }

    .btn-primary-dash { display: inline-flex; align-items: center; gap: 6px; background: var(--accent); color: #fff !important; border: none; border-radius: var(--radius-sm); padding: 8px 16px; font-size: 13px; font-weight: 600; cursor: pointer; text-decoration: none !important; font-family: var(--font); }
    .btn-primary-dash:hover { background: #252f70; }
    .btn-secondary-dash { display: inline-flex; align-items: center; gap: 6px; background: var(--surface); color: var(--text-primary) !important; border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 8px 16px; font-size: 13px; font-weight: 500; cursor: pointer; text-decoration: none !important; font-family: var(--font); }
    .btn-secondary-dash:hover { background: var(--bg); }

    .list-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-md); box-shadow: var(--shadow-card); overflow: hidden; }
    .filter-bar { padding: 16px 20px; border-bottom: 1px solid var(--border); }
    .filter-row { display: flex; flex-wrap: wrap; gap: 12px; align-items: flex-end; }
    .filter-group { display: flex; flex-direction: column; gap: 5px; }
    .filter-group label { font-size: 12px; font-weight: 600; color: var(--text-secondary); text-transform: uppercase; }
    .filter-control { height: 36px; border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 0 11px; font-size: 13px; background: var(--surface); outline: none; font-family: var(--font); min-width: 140px; }
    .filter-control-wide { min-width: 220px; }
    .search-wrap { position: relative; }
    .search-wrap .filter-control { padding-left: 32px; }
    .search-wrap .search-ico { position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--text-hint); font-size: 12px; }

    .data-table { width: 100%; border-collapse: collapse; }
    .data-table thead tr { background: #fafafa; border-bottom: 1px solid var(--border); }
    .data-table thead th { padding: 10px 16px; font-size: 11px; font-weight: 650; text-transform: uppercase; color: var(--text-secondary); white-space: nowrap; text-align: left; }
    .data-table tbody tr { border-bottom: 1px solid var(--border); }
    .data-table tbody tr:hover { background: #fafbfc; }
    .data-table td { padding: 13px 16px; font-size: 13px; vertical-align: middle; }

    .id-chip { display: inline-block; background: var(--bg); border: 1px solid var(--border); border-radius: 6px; padding: 2px 8px; font-size: 11.5px; font-family: monospace; color: var(--text-secondary); }
    .order-id { color: var(--accent); font-weight: 700; font-family: monospace; }

    .pill { display: inline-flex; align-items: center; gap: 5px; padding: 3px 10px; border-radius: 20px; font-size: 11.5px; font-weight: 600; white-space: nowrap; }
    .pill::before { content: ''; width: 6px; height: 6px; border-radius: 50%; }
    .pill-pending { background: var(--amber-bg); color: var(--amber); }
    .pill-reattempt { background: var(--blue-bg); color: var(--blue); }
    .pill-rto { background: var(--red-bg); color: var(--red); }
    .pill-delivered { background: var(--green-bg); color: var(--green); }
    .pill-cancelled { background: #ececec; color: #666; }

    .action-btn { display: inline-flex; align-items: center; justify-content: center; width: 30px; height: 30px; border-radius: var(--radius-sm); border: 1px solid var(--border); background: var(--surface); color: var(--text-secondary); cursor: pointer; text-decoration: none; font-size: 12px; }
    .action-btn:hover { background: var(--bg); color: var(--text-primary); }
    .action-btn.view:hover { background: var(--accent-light); color: var(--accent); }

    .empty-state { text-align: center; padding: 56px 24px; }
    .empty-icon-wrap { width: 56px; height: 56px; border-radius: 50%; background: var(--accent-light); margin: 0 auto 16px; display: flex; align-items: center; justify-content: center; color: var(--accent); font-size: 22px; }

    .pagination-bar { padding: 14px 20px; border-top: 1px solid var(--border); display: flex; justify-content: space-between; flex-wrap: wrap; gap: 8px; }
    .pagination-info { font-size: 12.5px; color: var(--text-hint); }

    @media(max-width:768px) { .list-page { padding: 16px; } }
    </style>

    <div class="app-content content container-fluid">
        <div class="list-page">
            <div class="list-page-header">
                <div>
                    <h1>NDR Management</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a><span>›</span> NDR Management
                    </div>
                </div>
                <div style="display:flex;gap:10px;flex-wrap:wrap">
                    <a href="{{ route('admin.ndr.export') }}" class="btn-secondary-dash">
                        <i class="fa fa-download"></i> Export CSV
                    </a>
                </div>
            </div>

            <div class="stat-strip">
                <div class="stat-card">
                    <div class="stat-label">Pending</div>
                    <div class="stat-value" style="color:var(--amber)">{{ $stats['pending'] }}</div>
                    <div class="stat-sub">Awaiting action</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Reattempt Scheduled</div>
                    <div class="stat-value" style="color:var(--blue)">{{ $stats['reattempt'] }}</div>
                    <div class="stat-sub">Redelivery in progress</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">RTO</div>
                    <div class="stat-value" style="color:var(--red)">{{ $stats['rto'] }}</div>
                    <div class="stat-sub">Returned to origin</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Resolved This Month</div>
                    <div class="stat-value" style="color:var(--green)">{{ $stats['resolved'] }}</div>
                    <div class="stat-sub">Delivered after NDR</div>
                </div>
            </div>

            <div class="list-card">
                <div class="filter-bar">
                    <form method="GET" action="{{ route('admin.ndr.index') }}">
                        <div class="filter-row">
                            <div class="filter-group" style="flex:1;min-width:200px">
                                <label>Search</label>
                                <div class="search-wrap">
                                    <i class="fa fa-search search-ico"></i>
                                    <input type="text" name="search" value="{{ request('search') }}"
                                           class="filter-control filter-control-wide"
                                           placeholder="Order number, customer, phone...">
                                </div>
                            </div>
                            <div class="filter-group">
                                <label>Status</label>
                                <select name="status" class="filter-control">
                                    <option value="">All Status</option>
                                    <option value="pending"    {{ request('status')=='pending'    ? 'selected':'' }}>Pending</option>
                                    <option value="reattempt"  {{ request('status')=='reattempt'  ? 'selected':'' }}>Reattempt</option>
                                    <option value="rto"        {{ request('status')=='rto'        ? 'selected':'' }}>RTO</option>
                                    <option value="delivered"  {{ request('status')=='delivered'  ? 'selected':'' }}>Delivered</option>
                                    <option value="cancelled"  {{ request('status')=='cancelled'  ? 'selected':'' }}>Cancelled</option>
                                </select>
                            </div>
                            <div class="filter-group">
                                <label>From Date</label>
                                <input type="date" name="from_date" value="{{ request('from_date') }}" class="filter-control">
                            </div>
                            <div class="filter-group">
                                <label>To Date</label>
                                <input type="date" name="to_date" value="{{ request('to_date') }}" class="filter-control">
                            </div>
                            <div style="display:flex;gap:8px">
                                <button type="submit" class="btn-primary-dash"><i class="fa fa-search"></i> Search</button>
                                <a href="{{ route('admin.ndr.index') }}" class="btn-secondary-dash"><i class="fa fa-refresh"></i> Reset</a>
                            </div>
                        </div>
                    </form>
                </div>

                <div style="overflow-x:auto">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>NDR ID</th>
                                <th>Order</th>
                                <th>Customer</th>
                                <th>Reason</th>
                                <th>Attempts</th>
                                <th>Next Attempt</th>
                                <th>Status</th>
                                <th>Raised On</th>
                                <th style="width:60px">View</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ndrs as $ndr)
                            <tr>
                                <td><span class="id-chip">NDR-{{ str_pad($ndr->id, 4, '0', STR_PAD_LEFT) }}</span></td>
                                <td><span class="order-id">#{{ $ndr->order->order_number }}</span></td>
                                <td>
                                    <div style="font-weight:500">{{ $ndr->order->customer_name }}</div>
                                    <div style="font-size:11.5px;color:var(--text-hint)">{{ $ndr->order->customer_phone }}</div>
                                </td>
                                <td style="font-size:12.5px;color:var(--text-secondary)">{{ $ndr->reason_label }}</td>
                                <td style="text-align:center;font-weight:600">{{ $ndr->attempt_count }}</td>
                                <td style="font-size:12.5px">{{ $ndr->next_attempt_date?->format('d M Y') ?? '—' }}</td>
                                <td>
                                    @php
                                        $pillMap = ['pending'=>'pill-pending','reattempt'=>'pill-reattempt','rto'=>'pill-rto','delivered'=>'pill-delivered','cancelled'=>'pill-cancelled'];
                                    @endphp
                                    <span class="pill {{ $pillMap[$ndr->status] ?? '' }}">{{ ucfirst($ndr->status) }}</span>
                                </td>
                                <td style="font-size:12.5px;color:var(--text-secondary)">{{ $ndr->created_at->format('d M Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.ndr.show', $ndr->id) }}" class="action-btn view" title="View">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9">
                                    <div class="empty-state">
                                        <div class="empty-icon-wrap"><i class="fa fa-truck-ramp-box"></i></div>
                                        <p style="font-weight:600;margin-bottom:4px">No NDR cases found</p>
                                        <p style="color:var(--text-hint);font-size:13px">Try adjusting your filters</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="pagination-bar">
                    <div class="pagination-info">
                        @if($ndrs->total() > 0)
                            Showing {{ $ndrs->firstItem() }}–{{ $ndrs->lastItem() }} of {{ number_format($ndrs->total()) }} NDR cases
                        @else
                            No NDR cases found
                        @endif
                    </div>
                    <div style="display:flex;gap:6px">
                        @if($ndrs->onFirstPage())
                            <span class="btn-secondary-dash" style="opacity:.4;pointer-events:none">← Previous</span>
                        @else
                            <a href="{{ $ndrs->previousPageUrl() }}" class="btn-secondary-dash">← Previous</a>
                        @endif
                        @if($ndrs->hasMorePages())
                            <a href="{{ $ndrs->nextPageUrl() }}" class="btn-secondary-dash">Next →</a>
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