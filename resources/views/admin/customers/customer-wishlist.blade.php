@include('admin.top-header')
<div class="main-section">
    @include('admin.header')

    <style>
    :root {
        --bg:#f1f2f4; --surface:#fff; --border:#e3e5e8; --border-hover:#c9cccf;
        --text-primary:#202223; --text-secondary:#6d7175; --text-hint:#8c9196; --text-disabled:#babec3;
        --navy:#303d89; --navy-hover:#252f70; --navy-light:#eef0fc; --navy-border:#c5c9ef;
        --green:#007a5e; --green-bg:#e3f1ec; --green-border:#9fcfc3;
        --red:#c0392b; --red-bg:#fce8e8; --red-border:#f5b8b8;
        --amber:#916a00; --amber-bg:#fff5cc; --amber-border:#e8d080;
        --blue:#0069d9; --blue-bg:#e8f2ff; --blue-border:#a8cdf5;
        --radius-sm:6px; --radius-md:8px; --radius-lg:12px;
        --shadow:0 1px 0 rgba(0,0,0,.05),0 0 0 1px rgba(0,0,0,.07);
        --font:'Inter',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
    }
    .sp-page { background:var(--bg); padding:24px 28px; min-height:100vh; font-family:var(--font); color:var(--text-primary); font-size:14px; }
    .sp-page * { box-sizing:border-box; }

    /* header */
    .sp-ph { display:flex; align-items:flex-start; justify-content:space-between; flex-wrap:wrap; gap:12px; margin-bottom:20px; }
    .sp-title { font-size:20px; font-weight:660; margin:0 0 4px; letter-spacing:-.2px; }
    .sp-crumb { font-size:12.5px; color:var(--text-hint); display:flex; align-items:center; gap:4px; flex-wrap:wrap; }
    .sp-crumb a { color:var(--navy); text-decoration:none; font-weight:500; }
    .sp-crumb a:hover { text-decoration:underline; }
    .sp-crumb-sep { color:var(--border-hover); }

    /* kpi */
    .sp-kpi-strip { display:grid; grid-template-columns:repeat(4,1fr); gap:14px; margin-bottom:20px; }
    @media(max-width:900px){.sp-kpi-strip{grid-template-columns:repeat(2,1fr);}}
    .sp-kpi { background:var(--surface); border:1px solid var(--border); border-radius:var(--radius-lg); padding:16px 18px 14px; box-shadow:var(--shadow); }
    .sp-kpi-top { display:flex; align-items:center; justify-content:space-between; margin-bottom:10px; }
    .sp-kpi-label { font-size:11px; font-weight:700; color:var(--text-hint); text-transform:uppercase; letter-spacing:.06em; }
    .sp-kpi-icon { width:34px; height:34px; border-radius:var(--radius-md); display:flex; align-items:center; justify-content:center; font-size:14px; }
    .ic-red{background:var(--red-bg);color:var(--red);}
    .ic-navy{background:var(--navy-light);color:var(--navy);}
    .ic-green{background:var(--green-bg);color:var(--green);}
    .ic-amber{background:var(--amber-bg);color:var(--amber);}
    .sp-kpi-value { font-size:26px; font-weight:760; color:var(--text-primary); line-height:1; margin-bottom:4px; }
    .sp-kpi-sub { font-size:11.5px; color:var(--text-hint); }

    /* main card */
    .sp-card { background:var(--surface); border:1px solid var(--border); border-radius:var(--radius-lg); box-shadow:var(--shadow); overflow:hidden; }

    /* toolbar */
    .sp-toolbar { padding:12px 16px; border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between; gap:10px; flex-wrap:wrap; background:#fafafa; }
    .sp-toolbar-left { display:flex; align-items:center; gap:8px; flex-wrap:wrap; }
    .sp-toolbar-right { display:flex; align-items:center; gap:8px; }
    .sp-search-wrap { position:relative; }
    .sp-search { height:34px; border:1px solid var(--border); border-radius:var(--radius-md); padding:0 12px 0 32px; font-size:12.5px; color:var(--text-primary); background:var(--surface); outline:none; font-family:var(--font); width:220px; transition:border-color .15s,box-shadow .15s; }
    .sp-search:focus { border-color:var(--navy); box-shadow:0 0 0 3px rgba(48,61,137,.1); }
    .sp-search-ico { position:absolute; left:10px; top:50%; transform:translateY(-50%); color:var(--text-hint); font-size:12px; pointer-events:none; }
    .sp-filter-sel { height:34px; border:1px solid var(--border); border-radius:var(--radius-md); padding:0 28px 0 10px; font-size:12.5px; color:var(--text-secondary); background:var(--surface); outline:none; font-family:var(--font); appearance:none;
        background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%238c9196'/%3E%3C/svg%3E");
        background-repeat:no-repeat; background-position:right 9px center; cursor:pointer; transition:border-color .15s; }
    .sp-filter-sel:focus { border-color:var(--navy); outline:none; }

    /* export btn */
    .sp-btn { display:inline-flex; align-items:center; gap:6px; border-radius:var(--radius-md); padding:7px 14px; font-size:13px; font-weight:600; font-family:var(--font); cursor:pointer; border:1px solid; transition:all .15s; white-space:nowrap; text-decoration:none; }
    .sp-btn-secondary { background:var(--surface); color:var(--text-primary); border-color:var(--border); }
    .sp-btn-secondary:hover { background:var(--bg); border-color:var(--border-hover); color:var(--text-primary); }
    .sp-btn-navy { background:var(--navy); color:#fff; border-color:var(--navy-hover); box-shadow:0 1px 3px rgba(48,61,137,.2); }
    .sp-btn-navy:hover { background:var(--navy-hover); color:#fff; }

    /* table */
    .sp-table { width:100%; border-collapse:collapse; font-size:13.5px; }
    .sp-table thead th { font-size:11px; font-weight:650; letter-spacing:.055em; text-transform:uppercase; color:var(--text-hint); padding:10px 16px; border-bottom:1px solid var(--border); background:#fafafa; text-align:left; white-space:nowrap; }
    .sp-table thead th.center { text-align:center; }
    .sp-table tbody tr { border-bottom:1px solid var(--border); transition:background .1s; }
    .sp-table tbody tr:last-child { border-bottom:none; }
    .sp-table tbody tr:hover { background:#f7f8fb; }
    .sp-table td { padding:13px 16px; vertical-align:middle; }

    /* avatar */
    .sp-av-wrap { display:flex; align-items:center; gap:10px; }
    .sp-av { width:38px; height:38px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:13px; font-weight:700; color:#fff; flex-shrink:0; }
    .sp-av-name  { font-size:13.5px; font-weight:600; color:var(--text-primary); }
    .sp-av-email { font-size:11.5px; color:var(--text-hint); margin-top:2px; }

    /* product thumbs strip */
    .sp-thumb-strip { display:flex; align-items:center; gap:4px; }
    .sp-thumb { width:36px; height:36px; border-radius:var(--radius-sm); object-fit:cover; border:1px solid var(--border); flex-shrink:0; background:var(--bg); display:flex; align-items:center; justify-content:center; font-size:10px; color:var(--text-disabled); overflow:hidden; }
    .sp-thumb img { width:100%; height:100%; object-fit:cover; border-radius:var(--radius-sm); }
    .sp-thumb-more { width:36px; height:36px; border-radius:var(--radius-sm); background:var(--navy-light); border:1px solid var(--navy-border); display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:700; color:var(--navy); flex-shrink:0; }

    /* count badge */
    .sp-count-badge { display:inline-flex; align-items:center; justify-content:center; min-width:28px; height:22px; padding:0 8px; background:var(--navy-light); border:1px solid var(--navy-border); border-radius:var(--radius-sm); font-size:12px; font-weight:700; color:var(--navy); }

    /* value badge */
    .sp-value { font-size:13px; font-weight:650; color:var(--text-primary); }
    .sp-value-sub { font-size:11.5px; color:var(--text-hint); margin-top:1px; }

    /* wishlist heat */
    .sp-heat { display:inline-flex; align-items:center; gap:5px; font-size:11.5px; font-weight:650; padding:3px 9px; border-radius:20px; white-space:nowrap; }
    .sp-heat-hot  { background:var(--red-bg);   color:var(--red);   border:1px solid var(--red-border); }
    .sp-heat-warm { background:var(--amber-bg);  color:var(--amber); border:1px solid var(--amber-border); }
    .sp-heat-cool { background:var(--bg);        color:var(--text-hint); border:1px solid var(--border); }

    /* last added */
    .sp-last-added { font-size:12.5px; color:var(--text-secondary); }
    .sp-last-added span { display:block; font-size:11px; color:var(--text-hint); margin-top:1px; }

    /* actions */
    .sp-actions { display:flex; align-items:center; gap:5px; justify-content:center; }
    .sp-act-btn { display:inline-flex; align-items:center; justify-content:center; width:30px; height:30px; border-radius:var(--radius-sm); border:1px solid var(--border); background:var(--surface); color:var(--text-secondary); cursor:pointer; text-decoration:none; transition:all .12s; font-size:12.5px; }
    .sp-act-btn:hover { background:var(--bg); border-color:var(--border-hover); color:var(--text-primary); text-decoration:none; }
    .sp-act-btn.view:hover { background:var(--navy-light); border-color:var(--navy-border); color:var(--navy); }
    .sp-act-btn.del:hover  { background:var(--red-bg);    border-color:var(--red-border);   color:var(--red); }

    /* pagination */
    .sp-pag { padding:13px 20px; border-top:1px solid var(--border); display:flex; align-items:center; justify-content:space-between; background:var(--surface); }
    .sp-pag-info { font-size:12.5px; color:var(--text-hint); }
    .sp-pag-btns { display:flex; gap:4px; }
    .sp-pag-btn { display:inline-flex; align-items:center; justify-content:center; min-width:32px; height:32px; padding:0 6px; border:1px solid var(--border); border-radius:var(--radius-md); background:var(--surface); color:var(--text-secondary); font-size:12.5px; font-weight:500; cursor:pointer; font-family:var(--font); transition:all .12s; }
    .sp-pag-btn:hover:not(:disabled) { background:var(--bg); border-color:var(--border-hover); color:var(--text-primary); }
    .sp-pag-btn.active { background:var(--navy); border-color:var(--navy); color:#fff; }
    .sp-pag-btn:disabled { opacity:.35; cursor:not-allowed; }

    @media(max-width:768px){.sp-page{padding:16px;}.sp-search{width:160px;}}
    </style>

    <div class="app-content content container-fluid">
        <div class="sp-page">

            <!-- header -->
            <div class="sp-ph">
                <div>
                    <h1 class="sp-title">Customer Wishlists</h1>
                    <div class="sp-crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a><span class="sp-crumb-sep">›</span>
                        <a href="{{ route('admin.customers.index') }}">Customers</a><span class="sp-crumb-sep">›</span>
                        <span>Wishlists</span>
                    </div>
                </div>
                <div style="display:flex;gap:8px;flex-wrap:wrap">
                    <a href="{{ route('admin.customers.customer-wishlist', array_merge(request()->query(), ['export' => 1])) }}" class="sp-btn sp-btn-secondary"><i class="fa fa-download"></i> Export CSV</a>
                </div>
            </div>

            <!-- kpi -->
            <div class="sp-kpi-strip">
                <div class="sp-kpi">
                    <div class="sp-kpi-top"><span class="sp-kpi-label">Customers with Wishlist</span><div class="sp-kpi-icon ic-navy"><i class="fa fa-heart"></i></div></div>
                    <div class="sp-kpi-value">{{ number_format($totalCustomersWithWishlist) }}</div>
                    <div class="sp-kpi-sub">Of {{ number_format($totalCustomers) }} total customers</div>
                </div>
                <div class="sp-kpi">
                    <div class="sp-kpi-top"><span class="sp-kpi-label">Total Wishlist Items</span><div class="sp-kpi-icon ic-red"><i class="fa fa-list"></i></div></div>
                    <div class="sp-kpi-value">{{ number_format($totalItems) }}</div>
                    <div class="sp-kpi-sub">Across all wishlists</div>
                </div>
                <div class="sp-kpi">
                    <div class="sp-kpi-top"><span class="sp-kpi-label">Avg. Items / Customer</span><div class="sp-kpi-icon ic-amber"><i class="fa fa-chart-bar"></i></div></div>
                    <div class="sp-kpi-value">{{ $avgItemsPerCustomer }}</div>
                    <div class="sp-kpi-sub">Items per wishlist</div>
                </div>
                <div class="sp-kpi">
                    <div class="sp-kpi-top"><span class="sp-kpi-label">Total Wishlist Value</span><div class="sp-kpi-icon ic-green"><i class="fa fa-rupee-sign"></i></div></div>
                    <div class="sp-kpi-value">₹{{ number_format($totalValue / 100000, 1) }}L</div>
                    <div class="sp-kpi-sub">Combined product value</div>
                </div>
            </div>

            <!-- main card -->
            <div class="sp-card">
                <div class="sp-toolbar">
                    <div class="sp-toolbar-left">
    <form method="GET" action="{{ route('admin.customers.customer-wishlist') }}" style="display:flex;gap:8px;flex-wrap:wrap" id="wlFilterForm">
        <div class="sp-search-wrap">
            <i class="fa fa-search sp-search-ico"></i>
            <input type="text" name="search" class="sp-search" placeholder="Search customer…" value="{{ request('search') }}">
        </div>
        <select class="sp-filter-sel" name="heat" onchange="this.form.submit()">
            <option value="">All Activity</option>
            <option value="hot" {{ request('heat') === 'hot' ? 'selected' : '' }}>Hot (10+ items)</option>
            <option value="warm" {{ request('heat') === 'warm' ? 'selected' : '' }}>Warm (4–9 items)</option>
            <option value="cool" {{ request('heat') === 'cool' ? 'selected' : '' }}>Cool (1–3 items)</option>
        </select>
        <select class="sp-filter-sel" name="sort" onchange="this.form.submit()">
            <option value="last_added" {{ request('sort', 'last_added') === 'last_added' ? 'selected' : '' }}>Sort: Last Added</option>
            <option value="most_items" {{ request('sort') === 'most_items' ? 'selected' : '' }}>Sort: Most Items</option>
            <option value="highest_value" {{ request('sort') === 'highest_value' ? 'selected' : '' }}>Sort: Highest Value</option>
            <option value="name_az" {{ request('sort') === 'name_az' ? 'selected' : '' }}>Sort: Name A–Z</option>
        </select>
    </form>
    @if(request()->filled('search') || request()->filled('heat') || (request()->filled('sort') && request('sort') !== 'last_added'))
        <a href="{{ route('admin.customers.customer-wishlist') }}" class="sp-btn sp-btn-secondary" style="height:34px;padding:0 12px;">
            <i class="fa fa-times"></i> Clear Filters
        </a>
    @endif
</div>
                    <div class="sp-toolbar-right">
                        <span style="font-size:12.5px;color:var(--text-hint)"><span id="rowCount">{{ $customers->total() }}</span> customers</span>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="sp-table" id="wishlistTable">
                        <thead>
                            <tr>
                                <th style="width:52px">#</th>
                                <th>Customer</th>
                                <th>Recent Items</th>
                                <th class="center">Items</th>
                                <th>Wishlist Value</th>
                                <th>Activity</th>
                                <th>Last Added</th>
                                <th class="center" style="width:100px">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="wlTbody">
                        @forelse($rows as $index => $row)
                            <tr data-name="{{ strtolower($row->customer->name) }}" data-heat="{{ $row->heat }}">
                                <td><span style="font-size:11.5px;font-weight:600;color:var(--text-hint);font-family:'SF Mono',monospace">#{{ str_pad($customers->firstItem() + $index, 2, '0', STR_PAD_LEFT) }}</span></td>
                                <td>
                                    <div class="sp-av-wrap">
                                        <div class="sp-av" style="background:{{ $row->color }}">{{ $row->initials }}</div>
                                        <div>
                                            <div class="sp-av-name">{{ $row->customer->name }}</div>
                                            <div class="sp-av-email">{{ $row->customer->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="sp-thumb-strip">
                                        @foreach($row->recent as $item)
                                            <div class="sp-thumb">
                                                @if(optional($item->product)->display_image)
                                                    <img src="{{ $item->product->display_image }}" alt="">
                                                @else
                                                    <i class="fa fa-image"></i>
                                                @endif
                                            </div>
                                        @endforeach
                                        @if($row->itemCount > 3)
                                            <div class="sp-thumb-more">+{{ $row->itemCount - 3 }}</div>
                                        @endif
                                    </div>
                                </td>
                                <td class="center"><span class="sp-count-badge">{{ $row->itemCount }}</span></td>
                                <td>
                                    <div class="sp-value">₹{{ number_format($row->totalValue) }}</div>
                                    <div class="sp-value-sub">avg ₹{{ number_format($row->avgValue) }}</div>
                                </td>
                                <td>
                                    @if($row->heat === 'hot')
                                        <span class="sp-heat sp-heat-hot"><i class="fa fa-fire" style="font-size:10px"></i> Hot</span>
                                    @elseif($row->heat === 'warm')
                                        <span class="sp-heat sp-heat-warm"><i class="fa fa-circle" style="font-size:8px"></i> Warm</span>
                                    @else
                                        <span class="sp-heat sp-heat-cool"><i class="fa fa-snowflake" style="font-size:9px"></i> Cool</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="sp-last-added">
                                        {{ $row->lastAdded ? $row->lastAdded->diffForHumans() : '—' }}
                                        <span>{{ $row->lastProduct ?? 'N/A' }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="sp-actions">
                                        <a href="{{ route('admin.customers.customer-wishlist-detail', ['customer' => $row->customer->id]) }}" class="sp-act-btn view" title="View Wishlist"><i class="fa fa-eye"></i></a>
                                        <button class="sp-act-btn del" title="Clear Wishlist" onclick="clearWishlist('{{ $row->customer->name }}', {{ $row->customer->id }})"><i class="fa fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" style="text-align:center;padding:40px;color:var(--text-hint)">No wishlists found.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="sp-pag">
                    <span class="sp-pag-info">Showing {{ $customers->firstItem() ?? 0 }} to {{ $customers->lastItem() ?? 0 }} of {{ $customers->total() }} customers</span>
                    <div class="sp-pag-btns">
                        @if ($customers->onFirstPage())
                            <button class="sp-pag-btn" disabled><i class="fa fa-chevron-left"></i></button>
                        @else
                            <a href="{{ $customers->previousPageUrl() }}" class="sp-pag-btn"><i class="fa fa-chevron-left"></i></a>
                        @endif

                        @foreach ($customers->getUrlRange(max(1, $customers->currentPage() - 2), min($customers->lastPage(), $customers->currentPage() + 2)) as $page => $url)
                            <a href="{{ $url }}" class="sp-pag-btn {{ $page == $customers->currentPage() ? 'active' : '' }}">{{ $page }}</a>
                        @endforeach

                        @if ($customers->hasMorePages())
                            <a href="{{ $customers->nextPageUrl() }}" class="sp-pag-btn"><i class="fa fa-chevron-right"></i></a>
                        @else
                            <button class="sp-pag-btn" disabled><i class="fa fa-chevron-right"></i></button>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@include('admin.footer')
<script>

function clearWishlist(name, customerId) {
    Swal.fire({
        title: 'Clear wishlist for ' + name + '?',
        text: 'All ' + name + "'s saved items will be removed.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#c0392b',
        cancelButtonColor: '#6d7175',
        confirmButtonText: 'Yes, Clear'
    }).then(r => {
        if (r.isConfirmed) {
            fetch(`{{ url('admin/customers') }}/${customerId}/wishlist/clear`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            }).then(res => res.json()).then(() => {
                Swal.fire({ icon: 'success', title: 'Cleared!', timer: 1500, showConfirmButton: false })
                    .then(() => location.reload());
            });
        }
    });
}
</script>