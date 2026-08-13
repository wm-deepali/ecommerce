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
        --red: #b22222;
        --red-bg: #fce8e8;
        --amber: #916a00;
        --amber-bg: #fff5cc;
        --blue: #185fa5;
        --blue-bg: #e6f1fb;
        --radius-sm: 8px;
        --radius-md: 12px;
        --shadow-card: 0 1px 3px rgba(0,0,0,.08), 0 0 0 1px var(--border);
        --font: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }
    .list-page { background: var(--bg); padding: 24px 28px; min-height: 100vh; font-family: var(--font); color: var(--text-primary); }
    .list-page * { box-sizing: border-box; }

    .list-page-header { display: flex; align-items: flex-start; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 20px; }
    .list-page-header h1 { font-size: 20px; font-weight: 650; color: var(--text-primary); margin: 0; }
    .crumb { font-size: 12.5px; color: var(--text-hint); margin-top: 3px; }
    .crumb a { color: var(--accent); text-decoration: none; }
    .crumb a:hover { text-decoration: underline; }
    .crumb span { margin: 0 5px; }

    .stat-strip { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 20px; }
    @media(max-width:800px) { .stat-strip { grid-template-columns: repeat(2,1fr); } }
    .stat-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 16px 18px; box-shadow: var(--shadow-card); }
    .stat-label { font-size: 11.5px; font-weight: 600; text-transform: uppercase; letter-spacing: .04em; color: var(--text-hint); margin-bottom: 6px; }
    .stat-value { font-size: 22px; font-weight: 700; color: var(--text-primary); line-height: 1; }
    .stat-sub { font-size: 11.5px; color: var(--text-hint); margin-top: 4px; }

    .btn-primary-dash { display: inline-flex; align-items: center; gap: 6px; background: var(--accent); color: #fff !important; border: none; border-radius: var(--radius-sm); padding: 8px 16px; font-size: 13px; font-weight: 600; cursor: pointer; text-decoration: none !important; font-family: var(--font); transition: background .15s; box-shadow: 0 1px 3px rgba(48,61,137,.25); }
    .btn-primary-dash:hover { background: #252f70; }
    .btn-secondary-dash { display: inline-flex; align-items: center; gap: 6px; background: var(--surface); color: var(--text-primary) !important; border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 8px 16px; font-size: 13px; font-weight: 500; cursor: pointer; text-decoration: none !important; font-family: var(--font); transition: background .15s; }
    .btn-secondary-dash:hover { background: var(--bg); }

    .list-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-md); box-shadow: var(--shadow-card); overflow: hidden; }

    .filter-bar { padding: 16px 20px; border-bottom: 1px solid var(--border); }
    .filter-row { display: flex; flex-wrap: wrap; gap: 12px; align-items: flex-end; }
    .filter-group { display: flex; flex-direction: column; gap: 5px; }
    .filter-group label { font-size: 12px; font-weight: 600; color: var(--text-secondary); letter-spacing: .03em; text-transform: uppercase; }
    .filter-control { height: 36px; border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 0 11px; font-size: 13px; color: var(--text-primary); background: var(--surface); outline: none; transition: border-color .15s, box-shadow .15s; font-family: var(--font); min-width: 140px; }
    .filter-control:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(48,61,137,.12); }
    .filter-control-wide { min-width: 220px; }
    .search-wrap { position: relative; }
    .search-wrap .filter-control { padding-left: 32px; }
    .search-wrap .search-ico { position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--text-hint); font-size: 12px; pointer-events: none; }

    .data-table { width: 100%; border-collapse: collapse; }
    .data-table thead tr { background: #fafafa; border-bottom: 1px solid var(--border); }
    .data-table thead th { padding: 10px 16px; font-size: 11px; font-weight: 650; text-transform: uppercase; letter-spacing: .05em; color: var(--text-secondary); white-space: nowrap; text-align: left; }
    .data-table tbody tr { border-bottom: 1px solid var(--border); transition: background .12s; }
    .data-table tbody tr:last-child { border-bottom: none; }
    .data-table tbody tr:hover { background: #fafbfc; }
    .data-table td { padding: 13px 16px; font-size: 13px; color: var(--text-primary); vertical-align: middle; }

    .id-chip { display: inline-block; background: var(--bg); border: 1px solid var(--border); border-radius: 6px; padding: 2px 8px; font-size: 11.5px; font-family: 'SF Mono','Fira Mono',monospace; color: var(--text-secondary); }
    .order-id { color: var(--accent); font-weight: 700; font-family: 'SF Mono','Fira Mono',monospace; }
    .cust-cell { display: flex; align-items: center; gap: 9px; }
    .cust-avatar { width: 32px; height: 32px; border-radius: 50%; background: var(--accent-light); display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 600; color: var(--accent); flex-shrink: 0; }
    .cust-name { font-size: 13px; font-weight: 500; }
    .cust-email { font-size: 11.5px; color: var(--text-hint); }

    .pill { display: inline-flex; align-items: center; gap: 5px; padding: 3px 10px; border-radius: 20px; font-size: 11.5px; font-weight: 600; white-space: nowrap; }
    .pill::before { content: ''; width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
    .pill-pending { background: var(--amber-bg); color: var(--amber); }
    .pill-approved { background: var(--blue-bg); color: var(--blue); }
    .pill-rejected { background: var(--red-bg); color: var(--red); }
    .pill-refunded { background: var(--green-bg); color: var(--green); }

    .action-btn { display: inline-flex; align-items: center; justify-content: center; width: 30px; height: 30px; border-radius: var(--radius-sm); border: 1px solid var(--border); background: var(--surface); color: var(--text-secondary); cursor: pointer; text-decoration: none; transition: all .15s; font-size: 12px; }
    .action-btn:hover { background: var(--bg); color: var(--text-primary); }
    .action-btn.view:hover { background: var(--accent-light); color: var(--accent); }
    .action-btn.approve:hover { background: var(--green-bg); color: var(--green); border-color: var(--green); }
    .action-btn.reject:hover { background: var(--red-bg); color: var(--red); border-color: var(--red); }
    .action-btn.refund { background: var(--accent); color: #fff; border-color: var(--accent); width: auto; padding: 0 10px; gap: 5px; font-size: 12px; font-weight: 600; }
    .action-btn.refund:hover { background: #252f70; }

    .empty-state { text-align: center; padding: 56px 24px; }
    .empty-icon-wrap { width: 56px; height: 56px; border-radius: 50%; background: var(--accent-light); margin: 0 auto 16px; display: flex; align-items: center; justify-content: center; color: var(--accent); font-size: 22px; }

    .pagination-bar { padding: 14px 20px; border-top: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px; }
    .pagination-info { font-size: 12.5px; color: var(--text-hint); }

    @media(max-width:768px) { .list-page { padding: 16px; } }
    </style>

    <div class="app-content content container-fluid">
        <div class="list-page">

            <div class="list-page-header">
                <div>
                    <h1>Order Returns</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span> Order Returns
                    </div>
                </div>
                <div style="display:flex;gap:10px;flex-wrap:wrap">
                    <a href="{{ route('admin.order-returns.export') }}" class="btn-secondary-dash">
                        <i class="fa fa-download"></i> Export CSV
                    </a>
                </div>
            </div>

            <div class="stat-strip">
                <div class="stat-card">
                    <div class="stat-label">Total Returns</div>
                    <div class="stat-value">{{ $stats['total'] }}</div>
                    <div class="stat-sub">All time</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Pending</div>
                    <div class="stat-value" style="color:var(--amber)">{{ $stats['pending'] }}</div>
                    <div class="stat-sub">Awaiting approval</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Approved</div>
                    <div class="stat-value" style="color:var(--blue)">{{ $stats['approved'] }}</div>
                    <div class="stat-sub">Ready for refund</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Refunded</div>
                    <div class="stat-value" style="color:var(--green)">₹{{ number_format($stats['refunded_amount'], 0) }}</div>
                    <div class="stat-sub">Total refunded</div>
                </div>
            </div>

            <div class="list-card">
                <div class="filter-bar">
                    <form method="GET" action="{{ route('admin.order-returns.index') }}">
                        <div class="filter-row">
                            <div class="filter-group" style="flex:1;min-width:200px">
                                <label>Search</label>
                                <div class="search-wrap">
                                    <i class="fa fa-search search-ico"></i>
                                    <input type="text" name="search" value="{{ request('search') }}"
                                           class="filter-control filter-control-wide"
                                           placeholder="Return ID, Order ID, Customer...">
                                </div>
                            </div>
                            <div class="filter-group">
                                <label>Status</label>
                                <select name="status" class="filter-control">
                                    <option value="">All Status</option>
                                    <option value="pending"   {{ request('status')=='pending'   ? 'selected':'' }}>Pending</option>
                                    <option value="approved"  {{ request('status')=='approved'  ? 'selected':'' }}>Approved</option>
                                    <option value="rejected"  {{ request('status')=='rejected'  ? 'selected':'' }}>Rejected</option>
                                    <option value="completed" {{ request('status')=='completed' ? 'selected':'' }}>Refunded</option>
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
                            <div style="display:flex;gap:8px;align-items:flex-end">
                                <button type="submit" class="btn-primary-dash">
                                    <i class="fa fa-search"></i> Search
                                </button>
                                <a href="{{ route('admin.order-returns.index') }}" class="btn-secondary-dash">
                                    <i class="fa fa-refresh"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

                <div style="overflow-x:auto">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Return ID</th>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Product</th>
                                <th>Reason</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Requested On</th>
                                <th style="width:120px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($returns as $return)
                            <tr>
                                <td><span class="id-chip">RET-{{ str_pad($return->id, 4, '0', STR_PAD_LEFT) }}</span></td>
                                <td><span class="order-id">#ORD-{{ $return->order->id }}</span></td>
                                <td>
                                    <div class="cust-cell">
                                        <div class="cust-avatar">
                                            {{ strtoupper(substr($return->customer->name, 0, 1)) }}{{ strtoupper(substr(strstr($return->customer->name, ' '), 1, 1)) }}
                                        </div>
                                        <div>
                                            <div class="cust-name">{{ $return->customer->name }}</div>
                                            <div class="cust-email">{{ $return->customer->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td style="font-size:13px;max-width:160px">{{ $return->orderItem->product->name ?? '—' }}</td>
                                <td style="color:var(--text-secondary);font-size:12.5px">{{ $return->returnReason->title ?? $return->details ?? '—' }}</td>
                                <td style="font-weight:700">₹{{ number_format($return->orderItem->price ?? 0, 0) }}</td>
                                <td>
                                    @php
                                        $pillMap = ['pending'=>'pill-pending','approved'=>'pill-approved','rejected'=>'pill-rejected','completed'=>'pill-refunded'];
                                        $labelMap = ['pending'=>'Pending','approved'=>'Approved','rejected'=>'Rejected','completed'=>'Refunded'];
                                    @endphp
                                    <span class="pill {{ $pillMap[$return->status] ?? '' }}">
                                        {{ $labelMap[$return->status] ?? ucfirst($return->status) }}
                                    </span>
                                </td>
                                <td style="color:var(--text-secondary);font-size:12.5px">{{ $return->created_at->format('d M Y') }}</td>
                                <td>
                                    <div style="display:flex;gap:6px;align-items:center">
                                        <a href="{{ route('admin.order-returns.show', $return->id) }}"
                                           class="action-btn view" title="View Details">
                                            <i class="fa fa-eye"></i>
                                        </a>

                                        @if($return->status === 'pending')
                                            <button class="action-btn approve"
                                                    title="Approve"
                                                    onclick="openApproveModal({{ $return->id }}, '{{ addslashes($return->customer->name) }}', '{{ addslashes($return->orderItem->product->name ?? '') }}')">
                                                <i class="fa fa-check"></i>
                                            </button>
                                            <button class="action-btn reject"
                                                    title="Reject"
                                                    onclick="openRejectModal({{ $return->id }}, '{{ addslashes($return->customer->name) }}', '{{ addslashes($return->orderItem->product->name ?? '') }}')">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        @endif

                                        @if($return->status === 'approved')
                                            {{--
                                                The 5th argument is the customer's originally-requested
                                                refund destination (order_returns columns, never touched
                                                by the admin refund() action). Js::from() escapes it safely
                                                for embedding inside an inline onclick handler.
                                            --}}
                                            <button class="action-btn refund"
                                                    onclick="openRefundModal({{ $return->id }}, '{{ addslashes($return->customer->name) }}', '{{ addslashes($return->orderItem->product->name ?? '') }}', {{ $return->orderItem->price ?? 0 }}, {{ \Illuminate\Support\Js::from([
                                                        'method' => $return->refund_method,
                                                        'upi_id' => $return->upi_id,
                                                        'bank_name' => $return->bank_name,
                                                        'account_name' => $return->account_name,
                                                        'account_number' => $return->account_number,
                                                        'ifsc_code' => $return->ifsc_code,
                                                        'bank_branch' => $return->bank_branch,
                                                        'account_type' => $return->account_type,
                                                        'qr_image_url' => $return->qr_image ? asset('storage/'.$return->qr_image) : null,
                                                    ]) }})">
                                                <i class="fa fa-credit-card"></i> Refund
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9">
                                    <div class="empty-state">
                                        <div class="empty-icon-wrap"><i class="fa fa-undo"></i></div>
                                        <p style="font-weight:600;margin-bottom:4px">No returns found</p>
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
                        @if($returns->total() > 0)
                            Showing {{ $returns->firstItem() }}–{{ $returns->lastItem() }}
                            of {{ number_format($returns->total()) }} returns
                        @else
                            No returns found
                        @endif
                    </div>
                    <div style="display:flex;gap:6px">
                        @if($returns->onFirstPage())
                            <span class="btn-secondary-dash" style="opacity:.4;pointer-events:none">← Previous</span>
                        @else
                            <a href="{{ $returns->previousPageUrl() }}" class="btn-secondary-dash">← Previous</a>
                        @endif

                        @if($returns->hasMorePages())
                            <a href="{{ $returns->nextPageUrl() }}" class="btn-secondary-dash">Next →</a>
                        @else
                            <span class="btn-secondary-dash" style="opacity:.4;pointer-events:none">Next →</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.order-returns._modals')


</div>

<script>
function infoRow(label, value) {
    return `<div style="display:flex;justify-content:space-between;padding:4px 0;border-bottom:1px solid #e3e5e8"><span style="color:#8c9196">${label}</span><span style="font-weight:600">${value}</span></div>`;
}
</script>

@include('admin.footer')