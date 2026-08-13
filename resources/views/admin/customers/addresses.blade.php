@include('admin.top-header')
<div class="main-section">
    @include('admin.header')

    <style>
    :root {
        --bg: #f1f2f4; --surface: #ffffff; --border: #e3e5e8;
        --text-primary: #202223; --text-secondary:#6d7175; --text-hint: #8c9196;
        --accent: #303d89; --accent-light: #f0f1fc;
        --green: #007a5e; --green-bg: #e3f1ec;
        --red: #b22222; --red-bg: #fce8e8;
        --amber: #916a00; --amber-bg: #fff5cc;
        --radius-sm: 8px; --radius-md: 12px;
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
    .btn-primary-dash, .btn-secondary-dash { display: inline-flex; align-items: center; gap: 6px; border-radius: var(--radius-sm); padding: 8px 16px; font-size: 13px; font-weight: 600; cursor: pointer; text-decoration: none !important; font-family: var(--font); transition: background .15s; border: none; white-space: nowrap; }
    .btn-primary-dash { background: var(--accent); color: #fff !important; box-shadow: 0 1px 3px rgba(48,61,137,.25); }
    .btn-primary-dash:hover { background: #252f70; }
    .btn-secondary-dash { background: var(--surface); color: var(--text-primary) !important; border: 1px solid var(--border); font-weight: 500; }
    .btn-secondary-dash:hover { background: var(--bg); }
    .list-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-md); box-shadow: var(--shadow-card); overflow: hidden; }
    .filter-bar { padding: 16px 20px; border-bottom: 1px solid var(--border); }
    .filter-row { display: flex; flex-wrap: wrap; gap: 12px; align-items: flex-end; }
    .filter-group { display: flex; flex-direction: column; gap: 5px; }
    .filter-group label { font-size: 12px; font-weight: 600; color: var(--text-secondary); letter-spacing: .03em; text-transform: uppercase; }
    .filter-control { height: 36px; border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 0 11px; font-size: 13px; color: var(--text-primary); background: var(--surface); outline: none; transition: border-color .15s, box-shadow .15s; font-family: var(--font); min-width: 140px; }
    .filter-control:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(48,61,137,.12); }
    .filter-control-wide { min-width: 240px; }
    .filter-actions { display: flex; gap: 8px; }
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
    .cust-cell { display: flex; align-items: center; gap: 10px; }
    .cust-avatar { width: 34px; height: 34px; border-radius: 50%; flex-shrink: 0; background: var(--accent-light); border: 1px solid var(--border); display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; color: var(--accent); }
    .cust-avatar img { width: 34px; height: 34px; border-radius: 50%; object-fit: cover; display: block; }
    .cust-name { font-size: 13px; font-weight: 600; color: var(--text-primary); }
    .cust-email { font-size: 11.5px; color: var(--text-hint); margin-top: 1px; }
    .addr-primary { font-size: 13px; font-weight: 500; color: var(--text-primary); line-height: 1.5; }
    .addr-secondary { font-size: 12px; color: var(--text-secondary); margin-top: 2px; }
    .pill { display: inline-flex; align-items: center; gap: 5px; padding: 3px 10px; border-radius: 20px; font-size: 11.5px; font-weight: 600; }
    .pill::before { content: ''; width: 6px; height: 6px; border-radius: 50%; }
    .pill-default { background: var(--accent-light); color: var(--accent); } .pill-default::before { background: var(--accent); }
    .pill-home { background: var(--green-bg); color: var(--green); } .pill-home::before { background: var(--green); }
    .pill-office { background: var(--amber-bg); color: var(--amber); } .pill-work::before { background: var(--amber); }
    .pill-other { background: #f1f2f4; color: var(--text-secondary); } .pill-other::before { background: var(--text-secondary); }
    .action-btn { display: inline-flex; align-items: center; justify-content: center; width: 30px; height: 30px; border-radius: var(--radius-sm); border: 1px solid var(--border); background: var(--surface); color: var(--text-secondary); cursor: pointer; text-decoration: none; transition: all .15s; font-size: 12px; }
    .action-btn:hover { background: var(--bg); color: var(--text-primary); }
    .action-btn.view:hover { background: var(--accent-light); color: var(--accent); border-color: rgba(48,61,137,.25); }
    .action-btn.danger:hover { background: var(--red-bg); color: var(--red); border-color: #f5c0c0; }
    .empty-state { text-align: center; padding: 56px 24px; }
    .empty-icon-wrap { width: 56px; height: 56px; border-radius: 50%; background: var(--accent-light); margin: 0 auto 16px; display: flex; align-items: center; justify-content: center; color: var(--accent); font-size: 22px; }
    .empty-state h6 { font-size: 14px; font-weight: 650; color: var(--text-primary); margin: 0 0 6px; }
    .empty-state p { font-size: 13px; color: var(--text-hint); margin: 0; }
    .pagination-bar { padding: 14px 20px; border-top: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px; }
    .pagination-info { font-size: 12.5px; color: var(--text-hint); }
    .alert-success { background: var(--green-bg); color: var(--green); border: 1px solid #b2d8cd; border-radius: var(--radius-sm); padding: 10px 16px; font-size: 13px; font-weight: 500; margin-bottom: 16px; }
    @media(max-width:768px) { .list-page { padding: 16px; } }
    </style>

    <div class="app-content content container-fluid">
        <div class="list-page">

            {{-- Flash --}}
            @if(session('success'))
                <div class="alert-success">{{ session('success') }}</div>
            @endif

            {{-- Page header --}}
            <div class="list-page-header">
                <div>
                    <h1>Customer Address Book</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        <a href="{{ route('admin.customers.index') }}">Customers</a>
                        <span>›</span>
                        Address Book
                    </div>
                </div>
                <div style="display:flex;gap:10px;flex-wrap:wrap">
                    <a href="{{ route('admin.customers.addresses.export') }}" class="btn-secondary-dash">
                        <i class="fa fa-download"></i> Export CSV
                    </a>
                </div>
            </div>

            {{-- Stats strip --}}
            <div class="stat-strip">
                <div class="stat-card">
                    <div class="stat-label">Total Addresses</div>
                    <div class="stat-value">{{ number_format($totalAddresses) }}</div>
                    <div class="stat-sub">Across all customers</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Default Addresses</div>
                    <div class="stat-value" style="color:var(--accent)">{{ number_format($defaultAddresses) }}</div>
                    <div class="stat-sub">Primary per customer</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Unique Cities</div>
                    <div class="stat-value" style="color:var(--green)">{{ number_format($uniqueCities) }}</div>
                    <div class="stat-sub">Delivery locations</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Unique States</div>
                    <div class="stat-value" style="color:var(--amber)">{{ number_format($uniqueStates) }}</div>
                    <div class="stat-sub">Regions covered</div>
                </div>
            </div>

            {{-- Main card --}}
            <div class="list-card">

                {{-- Filter bar --}}
                <div class="filter-bar">
                    <form method="GET" action="{{ route('admin.customers.addresses.index') }}">
                        <div class="filter-row">
                            <div class="filter-group" style="flex:1;min-width:200px">
                                <label>Search</label>
                                <div class="search-wrap">
                                    <i class="fa fa-search search-ico"></i>
                                    <input
                                        type="text"
                                        name="search"
                                        class="filter-control filter-control-wide"
                                        placeholder="Customer name, city, pincode…"
                                        value="{{ request('search') }}"
                                    >
                                </div>
                            </div>
                            <div class="filter-group">
                                <label>Address Type</label>
                                <select name="address_type" class="filter-control">
                                    <option value="">All Types</option>
                                    <option value="home"  @selected(request('address_type') === 'home')>Home</option>
                                    <option value="office"  @selected(request('address_type') === 'office')>Work</option>
                                    <option value="other" @selected(request('address_type') === 'other')>Other</option>
                                </select>
                            </div>
                            <div class="filter-group">
                                <label>Default Only</label>
                                <select name="is_default" class="filter-control">
                                    <option value="">All Addresses</option>
                                    <option value="1" @selected(request('is_default') === '1')>Default Only</option>
                                    <option value="0" @selected(request('is_default') === '0')>Non-Default</option>
                                </select>
                            </div>
                            <div class="filter-group">
                                <label>State</label>
                                <select name="state_id" class="filter-control">
                                    <option value="">All States</option>
                                    @foreach($states as $state)
                                        <option value="{{ $state->id }}" @selected(request('state_id') == $state->id)>
                                            {{ $state->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="filter-actions">
                                <button type="submit" class="btn-primary-dash">
                                    <i class="fa fa-search"></i> Search
                                </button>
                                <a href="{{ route('admin.customers.addresses.index') }}" class="btn-secondary-dash">
                                    <i class="fa fa-refresh"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Table --}}
                <div style="overflow-x:auto">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th style="width:60px">ID</th>
                                <th style="min-width:180px">Customer</th>
                                <th style="min-width:260px">Address</th>
                                <th>City</th>
                                <th>State</th>
                                <th style="width:100px">Pincode</th>
                                <th style="width:100px">Type</th>
                                <th style="width:100px">Default</th>
                                <th style="width:80px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($addresses as $address)
                                <tr>
                                    <td><span class="id-chip">{{ $address->id }}</span></td>

                                    <td>
                                        <div class="cust-cell">
                                            <div class="cust-avatar">
                                                @if($address->customer?->avatar)
                                                    <img src="{{ asset('storage/' . $address->customer->avatar) }}"
                                                         alt="{{ $address->customer->name }}">
                                                @else
                                                    {{ strtoupper(substr($address->customer?->name ?? '?', 0, 2)) }}
                                                @endif
                                            </div>
                                            <div>
                                                <div class="cust-name">
                                                    {{ $address->customer?->name ?? '—' }}
                                                </div>
                                                <div class="cust-email">{{ $address->customer?->email }}</div>
                                                @if($address->customer?->mobile)
                                                    <div class="cust-email">{{ $address->customer->mobile }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="addr-primary">{{ $address->address_line_1 }}</div>
                                        @if($address->address_line_2)
                                            <div class="addr-secondary">{{ $address->address_line_2 }}</div>
                                        @endif
                                    </td>

                                    <td style="color:var(--text-secondary);font-size:13px">
                                        {{ optional($address->city)->name ?? '—' }}
                                    </td>

                                    <td style="color:var(--text-secondary);font-size:13px">
                                        {{ optional($address->state)->name ?? '—' }}
                                    </td>

                                    <td>
                                        <span class="id-chip" style="font-size:12px">{{ $address->pincode }}</span>
                                    </td>

                                    <td>
                                        @php $address_type = strtolower($address->address_type ?? 'other'); @endphp
                                        <span class="pill pill-{{ $address_type }}">
                                            @if($address_type === 'home')
                                                <i class="fa fa-home" style="font-size:10px"></i> Home
                                            @elseif($address_type === 'office')
                                                <i class="fa fa-briefcase" style="font-size:10px"></i> Work
                                            @else
                                                <i class="fa fa-map-marker" style="font-size:10px"></i> Other
                                            @endif
                                        </span>
                                    </td>

                                    <td>
                                        @if($address->is_default)
                                            <span class="pill pill-default">
                                                <i class="fa fa-check" style="font-size:10px"></i> Default
                                            </span>
                                        @else
                                            <span style="font-size:12px;color:var(--text-hint)">—</span>
                                        @endif
                                    </td>

                                    <td>
                                        <div style="display:flex;gap:6px">
                                            <a href="{{ route('admin.customers.show', $address->customer_id) }}"
                                               class="action-btn view" title="View Customer">
                                                <i class="fa fa-user"></i>
                                            </a>
                                            <form action="{{ route('admin.customers.addresses.destroy', $address->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Delete this address?')"
                                                  style="margin:0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="action-btn danger" title="Delete Address">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9">
                                        <div class="empty-state">
                                            <div class="empty-icon-wrap">
                                                <i class="fa fa-map-marker"></i>
                                            </div>
                                            <h6>No addresses found</h6>
                                            <p>Try adjusting your search or filter criteria.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="pagination-bar">
                    <div class="pagination-info">
                        @if($addresses->total())
                            Showing {{ $addresses->firstItem() }}–{{ $addresses->lastItem() }}
                            of {{ number_format($addresses->total()) }} addresses
                        @else
                            No addresses found
                        @endif
                    </div>
                    <div style="display:flex;gap:8px">
                        @if($addresses->onFirstPage())
                            <span class="btn-secondary-dash" style="opacity:.4;cursor:default">← Previous</span>
                        @else
                            <a href="{{ $addresses->previousPageUrl() }}" class="btn-secondary-dash">← Previous</a>
                        @endif

                        @if($addresses->hasMorePages())
                            <a href="{{ $addresses->nextPageUrl() }}" class="btn-secondary-dash">Next →</a>
                        @else
                            <span class="btn-secondary-dash" style="opacity:.4;cursor:default">Next →</span>
                        @endif
                    </div>
                </div>

            </div>{{-- /.list-card --}}
        </div>{{-- /.list-page --}}
    </div>
</div>

@include('admin.footer')