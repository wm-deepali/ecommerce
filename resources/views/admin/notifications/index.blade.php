@include('admin.top-header')
<div class="main-section">
    @include('admin.header')

    <style>
    :root {
        --sp-bg: #f1f2f4;
        --sp-surface: #ffffff;
        --sp-border: #e3e5e8;
        --sp-border-hover: #c9cccf;
        --sp-text-primary: #202223;
        --sp-text-secondary: #6d7175;
        --sp-text-hint: #8c9196;
        --sp-accent: #303d89;
        --sp-accent-hover: #2a3579;
        --sp-accent-light: #eef0fc;
        --sp-green: #007a5e;
        --sp-green-bg: #e3f1ec;
        --sp-green-border: #9fcfc3;
        --sp-red: #c0392b;
        --sp-red-bg: #fce8e8;
        --sp-red-border: #f5c6c6;
        --sp-amber: #916a00;
        --sp-amber-bg: #fff5cc;
        --sp-amber-border: #e8d080;
        --sp-blue: #0069d9;
        --sp-blue-bg: #e8f2ff;
        --sp-blue-border: #a8cdf5;
        --sp-purple: #6d28d9;
        --sp-purple-bg: #ede9fe;
        --sp-purple-border: #c4b5fd;
        --sp-radius-sm: 6px;
        --sp-radius-md: 8px;
        --sp-radius-lg: 12px;
        --sp-shadow-card: 0 1px 0 rgba(0,0,0,.05), 0 0 0 1px rgba(0,0,0,.07);
        --sp-font: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }
    .sp-page {
        background: var(--sp-bg);
        padding: 24px 28px;
        min-height: 100vh;
        font-family: var(--sp-font);
        color: var(--sp-text-primary);
        font-size: 14px;
    }
    .sp-page * { box-sizing: border-box; }
    .sp-page-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 20px;
    }
    .sp-page-title {
        font-size: 20px;
        font-weight: 660;
        color: var(--sp-text-primary);
        margin: 0 0 4px;
        letter-spacing: -.2px;
    }
    .sp-crumb {
        font-size: 12.5px;
        color: var(--sp-text-hint);
        display: flex;
        align-items: center;
        gap: 4px;
        flex-wrap: wrap;
    }
    .sp-crumb a { color: var(--sp-accent); text-decoration: none; }
    .sp-crumb a:hover { text-decoration: underline; }
    .sp-header-actions { display: flex; gap: 8px; flex-wrap: wrap; align-items: center; }
    .sp-btn-secondary {
        display: inline-flex; align-items: center; gap: 6px;
        background: var(--sp-surface); color: var(--sp-text-primary);
        border: 1px solid var(--sp-border); border-radius: var(--sp-radius-md);
        padding: 7px 14px; font-size: 13px; font-weight: 540;
        font-family: var(--sp-font); cursor: pointer; text-decoration: none;
        line-height: 1.4; transition: all .15s; white-space: nowrap;
    }
    .sp-btn-secondary:hover { background: var(--sp-bg); border-color: var(--sp-border-hover); color: var(--sp-text-primary); }
    .sp-btn-danger {
        display: inline-flex; align-items: center; gap: 6px;
        background: var(--sp-surface); color: var(--sp-red);
        border: 1px solid var(--sp-red-border); border-radius: var(--sp-radius-md);
        padding: 7px 14px; font-size: 13px; font-weight: 540;
        font-family: var(--sp-font); cursor: pointer; text-decoration: none;
        line-height: 1.4; transition: all .15s; white-space: nowrap;
    }
    .sp-btn-danger:hover { background: var(--sp-red-bg); }
    .sp-kpi-strip {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 14px;
        margin-bottom: 20px;
    }
    @media (max-width: 1100px) { .sp-kpi-strip { grid-template-columns: repeat(3,1fr); } }
    @media (max-width: 650px)  { .sp-kpi-strip { grid-template-columns: repeat(2,1fr); } }
    .sp-kpi {
        background: var(--sp-surface);
        border: 1px solid var(--sp-border);
        border-radius: var(--sp-radius-lg);
        padding: 16px 18px 14px;
        box-shadow: var(--sp-shadow-card);
        cursor: pointer;
        transition: border-color .15s, box-shadow .15s;
    }
    .sp-kpi:hover { border-color: var(--sp-accent); box-shadow: 0 2px 8px rgba(48,61,137,.10), 0 0 0 1px var(--sp-accent); }
    .sp-kpi.active { border-color: var(--sp-accent); box-shadow: 0 0 0 2px var(--sp-accent); background: var(--sp-accent-light); }
    .sp-kpi-top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px; }
    .sp-kpi-label { font-size: 11.5px; font-weight: 620; color: var(--sp-text-hint); text-transform: uppercase; letter-spacing: .04em; }
    .sp-kpi-icon {
        width: 32px; height: 32px;
        border-radius: var(--sp-radius-md);
        display: flex; align-items: center; justify-content: center;
        font-size: 13px; flex-shrink: 0;
    }
    .sp-kpi-icon.blue   { background: var(--sp-blue-bg);   color: var(--sp-blue); }
    .sp-kpi-icon.amber  { background: var(--sp-amber-bg);  color: var(--sp-amber); }
    .sp-kpi-icon.red    { background: var(--sp-red-bg);    color: var(--sp-red); }
    .sp-kpi-icon.purple { background: var(--sp-purple-bg); color: var(--sp-purple); }
    .sp-kpi-icon.green  { background: var(--sp-green-bg);  color: var(--sp-green); }
    .sp-kpi-value { font-size: 26px; font-weight: 750; color: var(--sp-text-primary); line-height: 1; }
    .sp-kpi-sub { font-size: 11.5px; color: var(--sp-text-hint); margin-top: 5px; display: flex; align-items: center; gap: 5px; }
    .sp-kpi-dot { width: 6px; height: 6px; border-radius: 50%; background: var(--sp-red); flex-shrink: 0; }
    .sp-card {
        background: var(--sp-surface);
        border-radius: var(--sp-radius-lg);
        box-shadow: var(--sp-shadow-card);
        border: 1px solid var(--sp-border);
        overflow: hidden;
    }
    .sp-toolbar {
        padding: 12px 16px;
        border-bottom: 1px solid var(--sp-border);
        background: #fafafa;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        flex-wrap: wrap;
    }
    .sp-toolbar-left { display: flex; align-items: center; gap: 6px; flex-wrap: wrap; }
    .sp-toolbar-right { display: flex; align-items: center; gap: 8px; }
    .sp-filter-pill {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 4px 12px; border: 1px solid var(--sp-border);
        border-radius: 20px; font-size: 12.5px; font-weight: 520;
        color: var(--sp-text-secondary); cursor: pointer;
        transition: all .15s; background: var(--sp-surface);
        user-select: none; font-family: var(--sp-font);
    }
    .sp-filter-pill:hover { border-color: var(--sp-accent); color: var(--sp-accent); background: var(--sp-accent-light); }
    .sp-filter-pill.active { border-color: var(--sp-accent); color: var(--sp-accent); background: var(--sp-accent-light); font-weight: 620; }
    .sp-pill-count {
        display: inline-flex; align-items: center; justify-content: center;
        min-width: 18px; height: 18px; padding: 0 5px;
        background: var(--sp-accent); color: #fff;
        border-radius: 10px; font-size: 10px; font-weight: 700;
    }
    .sp-pill-count.red { background: var(--sp-red); }
    .sp-search-wrap { position: relative; }
    .sp-search {
        height: 32px; border: 1px solid var(--sp-border);
        border-radius: var(--sp-radius-md); padding: 0 10px 0 30px;
        font-size: 12.5px; color: var(--sp-text-primary);
        background: var(--sp-surface); outline: none;
        font-family: var(--sp-font); width: 200px;
        transition: border-color .15s, box-shadow .15s;
    }
    .sp-search:focus { border-color: var(--sp-accent); box-shadow: 0 0 0 3px rgba(48,61,137,.10); }
    .sp-search-icon { position: absolute; left: 9px; top: 50%; transform: translateY(-50%); color: var(--sp-text-hint); font-size: 11px; pointer-events: none; }
    .sp-mark-all-btn {
        display: inline-flex; align-items: center; gap: 5px;
        font-size: 12.5px; font-weight: 540; color: var(--sp-accent);
        background: none; border: none; cursor: pointer;
        font-family: var(--sp-font); padding: 5px 10px;
        border-radius: var(--sp-radius-sm); transition: background .15s;
    }
    .sp-mark-all-btn:hover { background: var(--sp-accent-light); }
    .sp-date-group {
        padding: 7px 18px;
        font-size: 11px; font-weight: 700;
        letter-spacing: .06em; text-transform: uppercase;
        color: var(--sp-text-hint);
        background: #fafafa;
        border-bottom: 1px solid var(--sp-border);
    }
    .sp-notif-item {
        display: flex; align-items: flex-start; gap: 14px;
        padding: 14px 18px;
        border-bottom: 1px solid var(--sp-border);
        transition: background .12s; cursor: pointer; position: relative;
    }
    .sp-notif-item:last-of-type { border-bottom: none; }
    .sp-notif-item:hover { background: #f7f8f9; }
    .sp-notif-item.unread { background: #fafbff; }
    .sp-notif-item.unread:hover { background: #f3f4fd; }
    .sp-notif-item.unread::before {
        content: ''; position: absolute; left: 0; top: 0; bottom: 0;
        width: 3px; background: var(--sp-accent); border-radius: 0 2px 2px 0;
    }
    .sp-notif-icon {
        width: 38px; height: 38px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 14px; flex-shrink: 0; margin-top: 2px;
    }
    .sp-notif-icon.order    { background: var(--sp-blue-bg);   color: var(--sp-blue); }
    .sp-notif-icon.stock    { background: var(--sp-amber-bg);  color: var(--sp-amber); }
    .sp-notif-icon.customer { background: var(--sp-green-bg);  color: var(--sp-green); }
    .sp-notif-icon.payment  { background: var(--sp-red-bg);    color: var(--sp-red); }
    .sp-notif-icon.cancel   { background: var(--sp-red-bg);    color: var(--sp-red); }
    .sp-notif-icon.return   { background: var(--sp-purple-bg); color: var(--sp-purple); }
    .sp-notif-icon.system   { background: var(--sp-bg);        color: var(--sp-text-hint); }
    .sp-notif-body { flex: 1; min-width: 0; }
    .sp-notif-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 10px; }
    .sp-notif-title { font-size: 13.5px; font-weight: 600; color: var(--sp-text-primary); line-height: 1.4; }
    .sp-notif-item.unread .sp-notif-title { color: var(--sp-accent); }
    .sp-notif-meta { display: flex; align-items: center; gap: 7px; margin-top: 4px; flex-wrap: wrap; }
    .sp-notif-msg { font-size: 12.5px; color: var(--sp-text-secondary); line-height: 1.55; margin-top: 6px; }
    .sp-notif-link {
        display: inline-flex; align-items: center; gap: 4px;
        margin-top: 7px; font-size: 12px; font-weight: 600;
        color: var(--sp-accent); text-decoration: none;
    }
    .sp-notif-link:hover { text-decoration: underline; }
    .sp-notif-right { display: flex; align-items: center; gap: 8px; flex-shrink: 0; margin-top: 2px; }
    .sp-notif-time { font-size: 11.5px; color: var(--sp-text-hint); white-space: nowrap; }
    .sp-unread-dot { width: 7px; height: 7px; border-radius: 50%; background: var(--sp-accent); flex-shrink: 0; }
    .sp-type-pill {
        display: inline-flex; align-items: center; gap: 4px;
        font-size: 11px; font-weight: 620;
        padding: 2px 8px; border-radius: 20px; white-space: nowrap;
    }
    .sp-type-pill.order    { background: var(--sp-blue-bg);   color: var(--sp-blue);   border: 1px solid var(--sp-blue-border); }
    .sp-type-pill.stock    { background: var(--sp-amber-bg);  color: var(--sp-amber);  border: 1px solid var(--sp-amber-border); }
    .sp-type-pill.customer { background: var(--sp-green-bg);  color: var(--sp-green);  border: 1px solid var(--sp-green-border); }
    .sp-type-pill.payment  { background: var(--sp-red-bg);    color: var(--sp-red);    border: 1px solid var(--sp-red-border); }
    .sp-type-pill.cancel   { background: var(--sp-red-bg);    color: var(--sp-red);    border: 1px solid var(--sp-red-border); }
    .sp-type-pill.return   { background: var(--sp-purple-bg); color: var(--sp-purple); border: 1px solid var(--sp-purple-border); }
    .sp-type-pill.system   { background: var(--sp-bg);        color: var(--sp-text-hint); border: 1px solid var(--sp-border); }
    .sp-ref {
        font-size: 11.5px; color: var(--sp-text-hint);
        font-family: 'SF Mono','Fira Code',monospace;
        background: var(--sp-bg); border: 1px solid var(--sp-border);
        border-radius: 4px; padding: 1px 6px;
    }
    .sp-notif-actions { display: flex; align-items: center; gap: 4px; flex-shrink: 0; margin-top: 2px; }
    .sp-notif-btn {
        display: inline-flex; align-items: center; justify-content: center;
        width: 28px; height: 28px;
        border-radius: var(--sp-radius-sm);
        border: 1px solid transparent; background: transparent;
        color: var(--sp-text-hint); cursor: pointer; font-size: 12px;
        transition: all .12s;
    }
    .sp-notif-btn:hover { background: var(--sp-bg); border-color: var(--sp-border); color: var(--sp-text-secondary); }
    .sp-notif-btn.del:hover { background: var(--sp-red-bg); border-color: var(--sp-red-border); color: var(--sp-red); }
    .sp-pagination {
        padding: 13px 18px;
        border-top: 1px solid var(--sp-border);
        display: flex; align-items: center; justify-content: space-between;
        background: var(--sp-surface);
        font-size: 12.5px; color: var(--sp-text-hint);
    }
    .sp-pag-btns { display: flex; gap: 4px; }
    .sp-pag-btn {
        display: inline-flex; align-items: center; justify-content: center;
        width: 32px; height: 32px;
        border: 1px solid var(--sp-border); border-radius: var(--sp-radius-sm);
        background: var(--sp-surface); color: var(--sp-text-secondary);
        font-size: 12.5px; font-weight: 500; cursor: pointer;
        text-decoration: none; transition: all .12s; font-family: var(--sp-font);
    }
    .sp-pag-btn:hover { background: var(--sp-bg); color: var(--sp-text-primary); }
    .sp-pag-btn.active { background: var(--sp-accent); border-color: var(--sp-accent); color: #fff; }
    .sp-pag-btn:disabled { opacity: .4; cursor: not-allowed; }
    @media (max-width: 768px) {
        .sp-page { padding: 16px; }
        .sp-search { width: 140px; }
    }
    </style>

    <div class="app-content content container-fluid">
        <div class="sp-page">

            <div class="sp-page-header">
                <div>
                    <h1 class="sp-page-title">Notifications</h1>
                    <div class="sp-crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span style="color:var(--sp-border-hover)">›</span>
                        <span>Notifications</span>
                    </div>
                </div>
                <div class="sp-header-actions">
                    <button class="sp-btn-secondary" onclick="markAllRead()">
                        <i class="fa fa-check"></i> Mark All Read
                    </button>
                    <button class="sp-btn-danger" onclick="clearRead()">
                        <i class="fa fa-trash"></i> Clear Read
                    </button>
                </div>
            </div>

            <div class="sp-kpi-strip">
                <div class="sp-kpi {{ $filter === 'all' ? 'active' : '' }}" onclick="filterKpi(this,'all')">
                    <div class="sp-kpi-top">
                        <span class="sp-kpi-label">All</span>
                        <div class="sp-kpi-icon blue"><i class="fa fa-bell"></i></div>
                    </div>
                    <div class="sp-kpi-value">{{ $counts['all'] }}</div>
                    <div class="sp-kpi-sub"><span class="sp-kpi-dot"></span> {{ $counts['unread'] }} unread</div>
                </div>
                <div class="sp-kpi {{ $filter === 'order' ? 'active' : '' }}" onclick="filterKpi(this,'order')">
                    <div class="sp-kpi-top">
                        <span class="sp-kpi-label">Orders</span>
                        <div class="sp-kpi-icon blue"><i class="fa fa-shopping-bag"></i></div>
                    </div>
                    <div class="sp-kpi-value">{{ $counts['order'] }}</div>
                    <div class="sp-kpi-sub">New &amp; updated</div>
                </div>
                <div class="sp-kpi {{ $filter === 'stock' ? 'active' : '' }}" onclick="filterKpi(this,'stock')">
                    <div class="sp-kpi-top">
                        <span class="sp-kpi-label">Low Stock</span>
                        <div class="sp-kpi-icon amber"><i class="fa fa-exclamation-triangle"></i></div>
                    </div>
                    <div class="sp-kpi-value">{{ $counts['stock'] }}</div>
                    <div class="sp-kpi-sub">Need restocking</div>
                </div>
                <div class="sp-kpi {{ $filter === 'payment' ? 'active' : '' }}" onclick="filterKpi(this,'payment')">
                    <div class="sp-kpi-top">
                        <span class="sp-kpi-label">Payments</span>
                        <div class="sp-kpi-icon red"><i class="fa fa-credit-card"></i></div>
                    </div>
                    <div class="sp-kpi-value">{{ $counts['payment'] }}</div>
                    <div class="sp-kpi-sub">Failures &amp; alerts</div>
                </div>
                <div class="sp-kpi {{ $filter === 'return' ? 'active' : '' }}" onclick="filterKpi(this,'return')">
                    <div class="sp-kpi-top">
                        <span class="sp-kpi-label">Returns</span>
                        <div class="sp-kpi-icon purple"><i class="fa fa-undo"></i></div>
                    </div>
                    <div class="sp-kpi-value">{{ $counts['return'] }}</div>
                    <div class="sp-kpi-sub">Cancels &amp; refunds</div>
                </div>
            </div>

            <div class="sp-card">

                <div class="sp-toolbar">
                    <div class="sp-toolbar-left">
                        <span class="sp-filter-pill {{ $filter === 'all' ? 'active' : '' }}" onclick="setTab(this,'all')">All <span class="sp-pill-count">{{ $counts['all'] }}</span></span>
                        <span class="sp-filter-pill {{ $filter === 'unread' ? 'active' : '' }}" onclick="setTab(this,'unread')">Unread <span class="sp-pill-count red">{{ $counts['unread'] }}</span></span>
                        <span class="sp-filter-pill {{ $filter === 'order' ? 'active' : '' }}" onclick="setTab(this,'order')">Orders</span>
                        <span class="sp-filter-pill {{ $filter === 'stock' ? 'active' : '' }}" onclick="setTab(this,'stock')">Stock</span>
                        <span class="sp-filter-pill {{ $filter === 'customer' ? 'active' : '' }}" onclick="setTab(this,'customer')">Customers</span>
                        <span class="sp-filter-pill {{ $filter === 'payment' ? 'active' : '' }}" onclick="setTab(this,'payment')">Payments</span>
                        <span class="sp-filter-pill {{ $filter === 'return' ? 'active' : '' }}" onclick="setTab(this,'return')">Returns</span>
                    </div>
                    <div class="sp-toolbar-right">
                        <div class="sp-search-wrap">
                            <i class="fa fa-search sp-search-icon"></i>
                            <input type="text" class="sp-search" placeholder="Search notifications…" value="{{ $search }}" oninput="searchNotifs(this.value)">
                        </div>
                        <button class="sp-mark-all-btn" onclick="markAllRead()">
                            <i class="fa fa-check"></i> Mark all read
                        </button>
                    </div>
                </div>

                @php $lastGroup = null; @endphp

                @forelse($notifications as $notification)
                    @php
                        $group = $notification->created_at->isToday() ? 'Today'
                               : ($notification->created_at->isYesterday() ? 'Yesterday' : 'Earlier');
                    @endphp

                    @if($group !== $lastGroup)
                        @php $lastGroup = $group; @endphp
                        <div class="sp-date-group">{{ $group }}</div>
                    @endif

                    <div class="sp-notif-item {{ $notification->is_read ? '' : 'unread' }}"
                         data-type="{{ $notification->type }}"
                         data-title="{{ strtolower($notification->title) }}"
                         data-id="{{ $notification->id }}">

                        <div class="sp-notif-icon {{ $notification->type }}">
                            <i class="fa {{ $notification->icon ?? 'fa-bell' }}"></i>
                        </div>

                        <div class="sp-notif-body">
                            <div class="sp-notif-header">
                                <div>
                                    <div class="sp-notif-title">{{ $notification->title }}</div>
                                    <div class="sp-notif-meta">
                                        <span class="sp-type-pill {{ $notification->type }}">{{ ucfirst($notification->type) }}</span>
                                        @if($notification->reference)
                                            <span class="sp-ref">{{ $notification->reference }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="sp-notif-right">
                                    <span class="sp-notif-time">
                                        <i class="fa fa-clock" style="font-size:10px;margin-right:3px"></i>
                                        {{ $notification->created_at->diffForHumans() }}
                                    </span>
                                    @if(!$notification->is_read)
                                        <span class="sp-unread-dot"></span>
                                    @endif
                                </div>
                            </div>
                            <div class="sp-notif-msg">{{ $notification->message }}</div>
                            @if($notification->url)
                                <a href="{{ $notification->url }}" class="sp-notif-link">
                                    {{ $notification->link_text ?? 'View Details' }} <i class="fa fa-arrow-right" style="font-size:10px"></i>
                                </a>
                            @endif
                        </div>

                        <div class="sp-notif-actions">
                            @if(!$notification->is_read)
                                <button class="sp-notif-btn" title="Mark as read" onclick="markOneRead(this, {{ $notification->id }})"><i class="fa fa-check"></i></button>
                            @endif
                            <button class="sp-notif-btn del" title="Delete" onclick="deleteOne(this, {{ $notification->id }})"><i class="fa fa-trash"></i></button>
                        </div>
                    </div>
                @empty
                    <div style="padding:40px;text-align:center;color:var(--sp-text-hint)">No notifications found.</div>
                @endforelse

                <div class="sp-pagination">
                    <span>Showing {{ $notifications->firstItem() ?? 0 }}–{{ $notifications->lastItem() ?? 0 }} of {{ $notifications->total() }} notifications</span>
                    <div class="sp-pag-btns">
                        {{ $notifications->onEachSide(1)->links() }}
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

@include('admin.footer')

<script>
let currentTab = "{{ $filter }}";
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

function setTab(el, filter) {
    window.location.href = "{{ route('admin.notifications.index') }}?filter=" + filter;
}

function filterKpi(el, type) { setTab(el, type); }

function searchNotifs(val) {
    clearTimeout(window._searchTimer);
    window._searchTimer = setTimeout(() => {
        window.location.href = "{{ route('admin.notifications.index') }}?filter=" + currentTab + "&search=" + encodeURIComponent(val);
    }, 400);
}

function markOneRead(btn, id) {
    fetch(`{{ url('admin/notifications') }}/${id}/read`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
    }).then(res => res.json()).then(data => {
        if (data.success) {
            const item = btn.closest('.sp-notif-item');
            item.classList.remove('unread');
            item.querySelector('.sp-unread-dot')?.remove();
            btn.remove();
        }
    });
}

function markAllRead() {
    fetch("{{ route('admin.notifications.read-all') }}", {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
    }).then(res => res.json()).then(data => {
        if (data.success) window.location.reload();
    });
}

function deleteOne(btn, id) {
    fetch(`{{ url('admin/notifications') }}/${id}`, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
    }).then(res => res.json()).then(data => {
        if (data.success) {
            const item = btn.closest('.sp-notif-item');
            item.style.transition = 'opacity .25s';
            item.style.opacity = '0';
            setTimeout(() => item.remove(), 250);
        }
    });
}

function clearRead() {
    fetch("{{ route('admin.notifications.clear-read') }}", {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
    }).then(res => res.json()).then(data => {
        if (data.success) window.location.reload();
    });
}
</script>