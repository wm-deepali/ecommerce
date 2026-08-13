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
            --orange: #c84b00;
            --orange-bg: #fff0e6;
            --radius-sm: 8px;
            --radius-md: 12px;
            --shadow-card: 0 1px 3px rgba(0, 0, 0, .08), 0 0 0 1px var(--border);
            --font: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        .list-page {
            background: var(--bg);
            padding: 24px 28px;
            min-height: 100vh;
            font-family: var(--font);
            color: var(--text-primary);
        }

        .list-page * {
            box-sizing: border-box;
        }

        .list-page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 20px;
        }

        .list-page-header h1 {
            font-size: 20px;
            font-weight: 650;
            color: var(--text-primary);
            margin: 0;
        }

        .page-title-row {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .page-title-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: var(--orange-bg);
            color: var(--orange);
            border: 1px solid rgba(200, 75, 0, .2);
            border-radius: 20px;
            font-size: 11.5px;
            font-weight: 700;
            padding: 3px 10px;
            letter-spacing: .02em;
        }

        .page-title-badge::before {
            content: '';
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--orange);
            animation: blink 1.6s ease-in-out infinite;
        }

        @keyframes blink {

            0%,
            100% {
                opacity: 1
            }

            50% {
                opacity: .3
            }
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

        .stat-strip {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            margin-bottom: 20px;
        }

        @media(max-width:800px) {
            .stat-strip {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            padding: 16px 18px;
            box-shadow: var(--shadow-card);
        }

        .stat-label {
            font-size: 11.5px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .04em;
            color: var(--text-hint);
            margin-bottom: 6px;
        }

        .stat-value {
            font-size: 22px;
            font-weight: 700;
            color: var(--text-primary);
            line-height: 1;
        }

        .stat-sub {
            font-size: 11.5px;
            color: var(--text-hint);
            margin-top: 4px;
        }

        .btn-primary-dash {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--accent);
            color: #fff !important;
            border: none;
            border-radius: var(--radius-sm);
            padding: 8px 16px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none !important;
            font-family: var(--font);
            transition: background .15s;
            box-shadow: 0 1px 3px rgba(48, 61, 137, .25);
            white-space: nowrap;
        }

        .btn-primary-dash:hover {
            background: #252f70;
        }

        .btn-secondary-dash {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--surface);
            color: var(--text-primary) !important;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 8px 16px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none !important;
            font-family: var(--font);
            transition: background .15s;
            white-space: nowrap;
        }

        .btn-secondary-dash:hover {
            background: var(--bg);
        }

        .list-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-card);
            overflow: hidden;
        }

        .filter-bar {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
        }

        .filter-row {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            align-items: flex-end;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .filter-group label {
            font-size: 12px;
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
            transition: border-color .15s, box-shadow .15s;
            font-family: var(--font);
            min-width: 140px;
        }

        .filter-control:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(48, 61, 137, .12);
        }

        .filter-control-wide {
            min-width: 240px;
        }

        .filter-actions {
            display: flex;
            gap: 8px;
        }

        .search-wrap {
            position: relative;
        }

        .search-wrap .filter-control {
            padding-left: 32px;
        }

        .search-wrap .search-ico {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-hint);
            font-size: 12px;
            pointer-events: none;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table thead tr {
            background: #fafafa;
            border-bottom: 1px solid var(--border);
        }

        .data-table thead th {
            padding: 10px 16px;
            font-size: 11px;
            font-weight: 650;
            text-transform: uppercase;
            letter-spacing: .05em;
            color: var(--text-secondary);
            white-space: nowrap;
            text-align: left;
        }

        .data-table tbody tr {
            border-bottom: 1px solid var(--border);
            transition: background .12s;
        }

        .data-table tbody tr:last-child {
            border-bottom: none;
        }

        .data-table tbody tr:hover {
            background: #fafbfc;
        }

        .data-table td {
            padding: 13px 16px;
            font-size: 13px;
            color: var(--text-primary);
            vertical-align: middle;
        }

        /* expanded row */
        .expanded-row {
            display: none;
            background: #fafbfc;
        }

        .expanded-row.open {
            display: table-row;
        }

        .expanded-inner {
            padding: 12px 20px 16px 72px;
        }

        .expanded-items-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 8px;
        }

        .expanded-item {
            display: flex;
            align-items: center;
            gap: 10px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 8px 12px;
            min-width: 220px;
            flex: 1;
        }

        .expanded-item-thumb {
            width: 40px;
            height: 40px;
            border-radius: 6px;
            object-fit: cover;
            border: 1px solid var(--border);
            flex-shrink: 0;
        }

        .expanded-item-thumb-ph {
            width: 40px;
            height: 40px;
            border-radius: 6px;
            background: var(--bg);
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-hint);
            flex-shrink: 0;
        }

        .expanded-item-name {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .expanded-item-meta {
            font-size: 11.5px;
            color: var(--text-hint);
            margin-top: 2px;
        }

        .expanded-item-price {
            font-size: 13px;
            font-weight: 700;
            color: var(--text-primary);
            margin-left: auto;
            white-space: nowrap;
        }

        .id-chip {
            display: inline-block;
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 2px 8px;
            font-size: 11.5px;
            font-family: 'SF Mono', 'Fira Mono', monospace;
            color: var(--text-secondary);
        }

        .cust-cell {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .cust-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            flex-shrink: 0;
            background: var(--accent-light);
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
            color: var(--accent);
            text-transform: uppercase;
        }

        .cust-avatar img {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            object-fit: cover;
            display: block;
        }

        .cust-name {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .cust-email {
            font-size: 11.5px;
            color: var(--text-hint);
            margin-top: 1px;
        }

        .cart-items-preview {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
        }

        .cart-thumb {
            width: 36px;
            height: 36px;
            border-radius: var(--radius-sm);
            object-fit: cover;
            border: 1px solid var(--border);
            flex-shrink: 0;
        }

        .cart-thumb-placeholder {
            width: 36px;
            height: 36px;
            border-radius: var(--radius-sm);
            background: var(--bg);
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-hint);
            font-size: 13px;
            flex-shrink: 0;
        }

        .cart-more-badge {
            width: 36px;
            height: 36px;
            border-radius: var(--radius-sm);
            background: var(--accent-light);
            border: 1px solid rgba(48, 61, 137, .2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            color: var(--accent);
            flex-shrink: 0;
        }

        .cart-item-names {
            font-size: 12px;
            color: var(--text-secondary);
            margin-top: 4px;
            line-height: 1.5;
        }

        .cart-value {
            font-size: 14px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .cart-value-sub {
            font-size: 11.5px;
            color: var(--text-hint);
            margin-top: 2px;
        }

        .age-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11.5px;
            font-weight: 600;
        }

        .age-fresh {
            background: var(--green-bg);
            color: var(--green);
        }

        .age-warm {
            background: var(--amber-bg);
            color: var(--amber);
        }

        .age-cold {
            background: var(--orange-bg);
            color: var(--orange);
        }

        .age-dead {
            background: var(--red-bg);
            color: var(--red);
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
            cursor: pointer;
            text-decoration: none;
            transition: all .15s;
            font-size: 12px;
        }

        .action-btn:hover {
            background: var(--bg);
            color: var(--text-primary);
        }

        .action-btn.view:hover {
            background: var(--accent-light);
            color: var(--accent);
            border-color: rgba(48, 61, 137, .25);
        }

        .action-btn.danger:hover {
            background: var(--red-bg);
            color: var(--red);
            border-color: #f5c0c0;
        }

        .toggle-btn.open {
            background: var(--accent-light);
            color: var(--accent);
            border-color: rgba(48, 61, 137, .25);
        }

        .toggle-btn.open .fa {
            transform: rotate(90deg);
        }

        .fa {
            transition: transform .2s;
        }

        .empty-state {
            text-align: center;
            padding: 56px 24px;
        }

        .empty-icon-wrap {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: var(--accent-light);
            margin: 0 auto 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent);
            font-size: 22px;
        }

        .empty-state h6 {
            font-size: 14px;
            font-weight: 650;
            color: var(--text-primary);
            margin: 0 0 6px;
        }

        .empty-state p {
            font-size: 13px;
            color: var(--text-hint);
            margin: 0;
        }

        .pagination-bar {
            padding: 14px 20px;
            border-top: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px;
        }

        .pagination-info {
            font-size: 12.5px;
            color: var(--text-hint);
        }

        .alert-success {
            background: var(--green-bg);
            color: var(--green);
            border: 1px solid #b2d8cd;
            border-radius: var(--radius-sm);
            padding: 10px 16px;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 16px;
        }

        @media(max-width:768px) {
            .list-page {
                padding: 16px;
            }
        }
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
                    <div class="page-title-row">
                        <h1>Stored Carts</h1>
                        <span class="page-title-badge">Abandoned</span>
                    </div>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        Stored Carts
                    </div>
                </div>
                <div style="display:flex;gap:10px;flex-wrap:wrap">
                    <a href="{{ route('admin.stored-carts.export') }}" class="btn-secondary-dash">
                        <i class="fa fa-download"></i> Export CSV
                    </a>
                </div>
            </div>

            {{-- Stats strip --}}
            <div class="stat-strip">
                <div class="stat-card">
                    <div class="stat-label">Total Stored Carts</div>
                    <div class="stat-value">{{ number_format($totalCarts) }}</div>
                    <div class="stat-sub">Customers with items saved</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Total Cart Value</div>
                    <div class="stat-value" style="color:var(--orange)">₹{{ number_format($totalCartValue, 0) }}</div>
                    <div class="stat-sub">Potential revenue</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Avg Cart Value</div>
                    <div class="stat-value" style="color:var(--accent)">₹{{ number_format($avgCartValue, 0) }}</div>
                    <div class="stat-sub">Per stored cart</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Abandoned Today</div>
                    <div class="stat-value" style="color:var(--red)">{{ number_format($abandonedToday) }}</div>
                    <div class="stat-sub">New today</div>
                </div>
            </div>

            {{-- Main card --}}
            <div class="list-card">

                {{-- Filter bar --}}
                <div class="filter-bar">
                    <form method="GET" action="{{ route('admin.stored-carts.index') }}">
                        <div class="filter-row">
                            <div class="filter-group" style="flex:1;min-width:200px">
                                <label>Search</label>
                                <div class="search-wrap">
                                    <i class="fa fa-search search-ico"></i>
                                    <input type="text" name="search" class="filter-control filter-control-wide"
                                        placeholder="Customer name or email…" value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="filter-group">
                                <label>Cart Age</label>
                                <select name="cart_age" class="filter-control">
                                    <option value="">All Time</option>
                                    <option value="today" @selected(request('cart_age') === 'today')>Today</option>
                                    <option value="2days" @selected(request('cart_age') === '2days')>Last 2 Days</option>
                                    <option value="week" @selected(request('cart_age') === 'week')>Last 7 Days</option>
                                </select>
                            </div>
                            <div class="filter-group">
                                <label>Min Cart Value</label>
                                <input type="number" name="min_value" class="filter-control" placeholder="e.g. 500"
                                    value="{{ request('min_value') }}" style="min-width:120px">
                            </div>
                            <div class="filter-group">
                                <label>Sort By</label>
                                <select name="sort_by" class="filter-control">
                                    <option value="updated_at"
                                        @selected(request('sort_by', 'updated_at') === 'updated_at')>Last Updated</option>
                                    <option value="grand_total" @selected(request('sort_by') === 'grand_total')>Cart Value
                                        ↓</option>
                                </select>
                            </div>
                            <div class="filter-actions">
                                <button type="submit" class="btn-primary-dash">
                                    <i class="fa fa-search"></i> Search
                                </button>
                                <a href="{{ route('admin.stored-carts.index') }}" class="btn-secondary-dash">
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
                                <th style="width:50px"></th>
                                <th style="width:60px">ID</th>
                                <th style="min-width:180px">Customer</th>
                                <th style="min-width:200px">Items in Cart</th>
                                <th style="width:80px">Qty</th>
                                <th style="width:130px">Cart Value</th>
                                <th style="width:120px">Last Updated</th>
                                <th style="width:120px">Cart Age</th>
                                <th style="width:80px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($carts as $cart)
                                @php
                                    $items = $cart->items;
                                    $totalQty = $items->sum('quantity');
                                    $previewItems = $items->take(2);
                                    $moreCount = max(0, $items->count() - 2);
                                    $itemNames = $items->map(fn($i) => optional($i->product)->name ?? 'Unknown')->implode(', ');

                                    // Cart age label
                                    $diffMins = $cart->updated_at->diffInMinutes(now());
                                    $diffHours = $cart->updated_at->diffInHours(now());
                                    $diffDays = $cart->updated_at->diffInDays(now());
                                    if ($diffMins < 60) {
                                        $ageClass = 'age-fresh';
                                        $ageLabel = $diffMins . 'm ago';
                                    } elseif ($diffHours < 24) {
                                        $ageClass = 'age-fresh';
                                        $ageLabel = $diffHours . 'h ago';
                                    } elseif ($diffDays <= 2) {
                                        $ageClass = 'age-warm';
                                        $ageLabel = $diffDays . 'd ago';
                                    } elseif ($diffDays <= 7) {
                                        $ageClass = 'age-cold';
                                        $ageLabel = $diffDays . 'd ago';
                                    } else {
                                        $ageClass = 'age-dead';
                                        $ageLabel = $diffDays . 'd ago';
                                    }
                                @endphp

                                {{-- Main row --}}
                                <tr>
                                    <td style="text-align:center">
                                        <button class="action-btn toggle-btn"
                                            onclick="toggleCart(this, 'expand-{{ $cart->id }}')" title="Expand items">
                                            <i class="fa fa-chevron-right" style="font-size:11px"></i>
                                        </button>
                                    </td>

                                    <td><span class="id-chip">{{ $cart->id }}</span></td>

                                    <td>
                                        <div class="cust-cell">
                                            <div class="cust-avatar">
                                                @if($cart->user?->avatar)
                                                    <img src="{{ asset('storage/' . $cart->user->avatar) }}"
                                                        alt="{{ $cart->user->name }}">
                                                @else
                                                    {{ strtoupper(substr($cart->user?->name ?? '?', 0, 2)) }}
                                                @endif
                                            </div>
                                            <div>
                                                <div class="cust-name">{{ $cart->user?->name ?? '—' }}</div>
                                                <div class="cust-email">{{ $cart->user?->email }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="cart-items-preview">
                                            <td>
    <div class="cart-items-preview">
        @foreach($previewItems as $item)
            @php
                // Thumbnail: image variant > product thumbnail > null
                $previewThumb = null;
                if ($item->imageVariant && $item->imageVariant->image) {
                    $previewThumb = $item->imageVariant->image;
                } elseif ($item->product) {
                    $previewThumb = $item->product->thumbnail;
                }
            @endphp
            @if($previewThumb)
                <img src="{{ asset('storage/' . $previewThumb) }}" class="cart-thumb"
                    alt="{{ optional($item->product)->name }}">
            @else
                <div class="cart-thumb-placeholder">
                    <i class="fa fa-image"></i>
                </div>
            @endif
        @endforeach
        @if($moreCount > 0)
            <div class="cart-more-badge">+{{ $moreCount }}</div>
        @endif
    </div>
    @if($itemNames)
        <div class="cart-item-names">
            {{ \Illuminate\Support\Str::limit($itemNames, 50) }}
        </div>
    @endif
</td>

                                    <td>
                                        <span style="font-weight:700;color:var(--text-primary)">{{ $totalQty }}</span>
                                    </td>

                                    <td>
                                        <div class="cart-value">₹{{ number_format($cart->grand_total, 0) }}</div>
                                        <div class="cart-value-sub">incl. taxes</div>
                                    </td>

                                    <td style="color:var(--text-secondary);font-size:12.5px">
                                        {{ $cart->updated_at->format('d M Y') }}<br>
                                        <span style="font-size:11px">{{ $cart->updated_at->format('h:i A') }}</span>
                                    </td>

                                    <td>
                                        <span class="age-pill {{ $ageClass }}">
                                            <i class="fa fa-clock-o"></i> {{ $ageLabel }}
                                        </span>
                                    </td>

                                    <td>
                                        <div style="display:flex;gap:6px">
                                            @if($cart->user_id)
                                                <a href="{{ route('admin.customers.show', $cart->user_id) }}"
                                                    class="action-btn view" title="View Customer">
                                                    <i class="fa fa-user"></i>
                                                </a>
                                            @endif
                                            <form action="{{ route('admin.stored-carts.destroy', $cart->id) }}"
                                                method="POST" onsubmit="return confirm('Clear this cart?')"
                                                style="margin:0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="action-btn danger" title="Clear Cart">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                {{-- Expanded items row --}}
                                <tr class="expanded-row" id="expand-{{ $cart->id }}">
                                    <td colspan="9" style="padding:0">
                                        <div class="expanded-inner">
                                            <div
                                                style="font-size:11.5px;font-weight:600;text-transform:uppercase;letter-spacing:.04em;color:var(--text-hint);margin-bottom:8px">
                                                Cart Items
                                            </div>
                                            <div class="expanded-items-grid">
                                                @foreach($items as $item)
                                                    @php
                                                        $product = $item->product;

                                                        // Thumbnail: image variant > product thumbnail > null
                                                        $thumb = null;
                                                        if ($item->imageVariant && $item->imageVariant->image) {
                                                            $thumb = $item->imageVariant->image;
                                                        } elseif ($product) {
                                                            $thumb = $product->thumbnail;
                                                        }

                                                        // Variant label from selected_attributes snapshot
                                                        $variantLabel = null;
                                                        if (!empty($item->selected_attributes)) {
                                                            $variantLabel = collect($item->selected_attributes)
                                                                ->map(function ($value, $key) {
                                                                    if (is_array($value)) {
                                                                        $attrName = $value['attribute'] ?? $value['name'] ?? $key;
                                                                        $attrVal = $value['value'] ?? $value['label'] ?? reset($value);
                                                                        return $attrName . ': ' . $attrVal;
                                                                    }
                                                                    return $key . ': ' . $value;
                                                                })
                                                                ->join(' · ');
                                                        }

                                                        $sku = optional($item->skuVariant)->sku;
                                                    @endphp
                                                    <div class="expanded-item">
                                                        @if($thumb)
                                                            <img src="{{ asset('storage/' . $thumb) }}" class="expanded-item-thumb"
                                                                alt="{{ optional($product)->name }}">
                                                        @else
                                                            <div class="expanded-item-thumb-ph">
                                                                <i class="fa fa-image"></i>
                                                            </div>
                                                        @endif
                                                        <div style="flex:1;min-width:0">
                                                            <div class="expanded-item-name">
                                                                {{ optional($product)->name ?? 'Unknown Product' }}
                                                            </div>
                                                            <div class="expanded-item-meta">
                                                                @if($variantLabel)
                                                                    {{ $variantLabel }}
                                                                @endif
                                                                @if($sku)
                                                                    · SKU: {{ $sku }}
                                                                @endif
                                                                @if($item->addons->isNotEmpty())
                                                                    · {{ $item->addons->pluck('detail')->implode(', ') }}
                                                                @endif
                                                                <br>Qty: {{ $item->quantity }}
                                                            </div>
                                                        </div>
                                                        <div class="expanded-item-price">
                                                            ₹{{ number_format($item->total, 0) }}
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            @if($cart->coupon_code)
                                                <div style="margin-top:10px;font-size:12.5px;color:var(--green)">
                                                    <i class="fa fa-tag"></i>
                                                    Coupon applied: <strong>{{ $cart->coupon_code }}</strong>
                                                    — Discount: ₹{{ number_format($cart->discount, 0) }}
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="9">
                                        <div class="empty-state">
                                            <div class="empty-icon-wrap">
                                                <i class="fa fa-shopping-cart"></i>
                                            </div>
                                            <h6>No stored carts found</h6>
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
                        @if($carts->total())
                            Showing {{ $carts->firstItem() }}–{{ $carts->lastItem() }}
                            of {{ number_format($carts->total()) }} stored carts
                        @else
                            No stored carts found
                        @endif
                    </div>
                    <div style="display:flex;gap:8px">
                        @if($carts->onFirstPage())
                            <span class="btn-secondary-dash" style="opacity:.4;cursor:default">← Previous</span>
                        @else
                            <a href="{{ $carts->previousPageUrl() }}" class="btn-secondary-dash">← Previous</a>
                        @endif
                        @if($carts->hasMorePages())
                            <a href="{{ $carts->nextPageUrl() }}" class="btn-secondary-dash">Next →</a>
                        @else
                            <span class="btn-secondary-dash" style="opacity:.4;cursor:default">Next →</span>
                        @endif
                    </div>
                </div>

            </div>{{-- /.list-card --}}
        </div>{{-- /.list-page --}}
    </div>
</div>

<script>
    function toggleCart(btn, rowId) {
        const row = document.getElementById(rowId);
        const isOpen = row.classList.toggle('open');
        btn.classList.toggle('open', isOpen);
    }
</script>

@include('admin.footer')