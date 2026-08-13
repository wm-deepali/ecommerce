@include('admin.top-header')
<div class="main-section">
    @include('admin.header')

    <style>
    :root {
        --sp-bg: #f1f2f4; --sp-surface: #ffffff; --sp-border: #e3e5e8; --sp-border-hover: #c9cccf;
        --sp-text-primary: #202223; --sp-text-secondary: #6d7175; --sp-text-hint: #8c9196;
        --sp-accent: #303d89; --sp-accent-hover: #2a3579; --sp-accent-light: #eef0fc;
        --sp-green: #007a5e; --sp-green-bg: #e3f1ec;
        --sp-red: #c0392b; --sp-red-bg: #fce8e8;
        --sp-amber: #916a00; --sp-amber-bg: #fff5cc;
        --sp-blue: #0069d9; --sp-blue-bg: #e8f2ff;
        --sp-purple: #6d28d9; --sp-purple-bg: #ede9fe;
        --sp-radius-sm: 6px; --sp-radius-md: 8px; --sp-radius-lg: 12px;
        --sp-shadow-card: 0 1px 0 rgba(0,0,0,.05), 0 0 0 1px rgba(0,0,0,.07);
        --sp-font: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }
    .sp-page { background: var(--sp-bg); padding: 24px 28px; min-height: 100vh; font-family: var(--sp-font); color: var(--sp-text-primary); font-size: 14px; }
    .sp-page * { box-sizing: border-box; }

    /* ── Page header ── */
    .sp-page-header { display: flex; align-items: flex-start; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 20px; }
    .sp-page-title { font-size: 20px; font-weight: 660; margin: 0 0 4px; letter-spacing: -.2px; }
    .sp-crumb { font-size: 12.5px; color: var(--sp-text-hint); display: flex; align-items: center; gap: 4px; flex-wrap: wrap; }
    .sp-crumb a { color: var(--sp-accent); text-decoration: none; }
    .sp-crumb a:hover { text-decoration: underline; }

    /* ── KPI strip ── */
    .sp-kpi-strip { display: grid; grid-template-columns: repeat(5,1fr); gap: 14px; margin-bottom: 20px; }
    @media(max-width:1100px) { .sp-kpi-strip { grid-template-columns: repeat(3,1fr); } }
    @media(max-width:650px)  { .sp-kpi-strip { grid-template-columns: repeat(2,1fr); } }
    .sp-kpi { background: var(--sp-surface); border: 1px solid var(--sp-border); border-radius: var(--sp-radius-lg); padding: 16px 18px 14px; box-shadow: var(--sp-shadow-card); }
    .sp-kpi-top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px; }
    .sp-kpi-label { font-size: 11.5px; font-weight: 620; color: var(--sp-text-hint); text-transform: uppercase; letter-spacing: .04em; }
    .sp-kpi-icon { width: 32px; height: 32px; border-radius: var(--sp-radius-md); display: flex; align-items: center; justify-content: center; font-size: 13px; flex-shrink: 0; }
    .sp-kpi-value { font-size: 24px; font-weight: 750; color: var(--sp-text-primary); line-height: 1; }
    .sp-kpi-sub { font-size: 11.5px; color: var(--sp-text-hint); margin-top: 5px; }

    /* ── Layout ── */
    .sp-log-layout { display: grid; grid-template-columns: 1fr 260px; gap: 20px; align-items: start; }
    @media(max-width:960px) { .sp-log-layout { grid-template-columns: 1fr; } }

    /* ── Cards ── */
    .sp-card { background: var(--sp-surface); border-radius: var(--sp-radius-lg); box-shadow: var(--sp-shadow-card); border: 1px solid var(--sp-border); overflow: hidden; margin-bottom: 16px; }
    .sp-card:last-child { margin-bottom: 0; }
    .sp-card-header { padding: 13px 20px; border-bottom: 1px solid var(--sp-border); background: #fafafa; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px; }
    .sp-card-header h5 { font-size: 13px; font-weight: 650; color: var(--sp-text-primary); margin: 0; }
    .sp-card-body-sm { padding: 14px 20px; }

    /* ── Toolbar ── */
    .sp-toolbar { padding: 12px 16px; border-bottom: 1px solid var(--sp-border); background: #fafafa; display: flex; align-items: center; justify-content: space-between; gap: 10px; flex-wrap: wrap; }
    .sp-toolbar-left { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
    .sp-toolbar-right { display: flex; align-items: center; gap: 8px; }

    .sp-filter-pill { display: inline-flex; align-items: center; gap: 5px; padding: 4px 12px; border: 1px solid var(--sp-border); border-radius: 20px; font-size: 12.5px; font-weight: 520; color: var(--sp-text-secondary); cursor: pointer; transition: all .15s; background: var(--sp-surface); user-select: none; font-family: var(--sp-font); }
    .sp-filter-pill:hover { border-color: var(--sp-accent); color: var(--sp-accent); background: var(--sp-accent-light); }
    .sp-filter-pill.active { border-color: var(--sp-accent); color: var(--sp-accent); background: var(--sp-accent-light); font-weight: 620; }

    .sp-search-wrap { position: relative; }
    .sp-search { height: 32px; border: 1px solid var(--sp-border); border-radius: var(--sp-radius-md); padding: 0 10px 0 30px; font-size: 12.5px; color: var(--sp-text-primary); background: var(--sp-surface); outline: none; font-family: var(--sp-font); width: 210px; transition: border-color .15s, box-shadow .15s; }
    .sp-search:focus { border-color: var(--sp-accent); box-shadow: 0 0 0 3px rgba(48,61,137,.10); }
    .sp-search-icon { position: absolute; left: 9px; top: 50%; transform: translateY(-50%); color: var(--sp-text-hint); font-size: 11px; pointer-events: none; }

    .sp-select-sm { height: 32px; border: 1px solid var(--sp-border); border-radius: var(--sp-radius-md); padding: 0 28px 0 10px; font-size: 12.5px; color: var(--sp-text-primary); background: var(--sp-surface); outline: none; font-family: var(--sp-font); appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%238c9196'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 9px center; }

    /* ── Date group ── */
    .sp-date-group { padding: 7px 20px; font-size: 11px; font-weight: 700; letter-spacing: .06em; text-transform: uppercase; color: var(--sp-text-hint); background: #fafafa; border-bottom: 1px solid var(--sp-border); }

    /* ── Activity item ── */
    .sp-activity-item { display: flex; align-items: flex-start; gap: 14px; padding: 14px 20px; border-bottom: 1px solid var(--sp-border); transition: background .1s; }
    .sp-activity-item:last-child { border-bottom: none; }
    .sp-activity-item:hover { background: #f7f8f9; }

    /* Avatar */
    .sp-avatar { width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 700; color: #fff; flex-shrink: 0; }

    /* Activity icon */
    .sp-act-icon { width: 30px; height: 30px; border-radius: var(--sp-radius-md); display: flex; align-items: center; justify-content: center; font-size: 12px; flex-shrink: 0; margin-top: 3px; }
    .sp-act-icon.create { background: var(--sp-green-bg); color: var(--sp-green); }
    .sp-act-icon.edit   { background: var(--sp-amber-bg); color: var(--sp-amber); }
    .sp-act-icon.delete { background: var(--sp-red-bg);   color: var(--sp-red); }
    .sp-act-icon.view   { background: var(--sp-blue-bg);  color: var(--sp-blue); }
    .sp-act-icon.login  { background: var(--sp-accent-light); color: var(--sp-accent); }
    .sp-act-icon.logout { background: #f3f4f6; color: var(--sp-text-hint); }
    .sp-act-icon.export { background: var(--sp-purple-bg); color: var(--sp-purple); }

    /* Content */
    .sp-act-body { flex: 1; min-width: 0; }
    .sp-act-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 10px; }
    .sp-act-title { font-size: 13.5px; font-weight: 580; color: var(--sp-text-primary); }
    .sp-act-title strong { font-weight: 700; }
    .sp-act-meta { display: flex; align-items: center; gap: 8px; margin-top: 4px; flex-wrap: wrap; }
    .sp-act-detail { font-size: 12.5px; color: var(--sp-text-secondary); margin-top: 4px; line-height: 1.5; }
    .sp-act-time { font-size: 11.5px; color: var(--sp-text-hint); white-space: nowrap; flex-shrink: 0; }

    /* Module tag */
    .sp-module-tag { display: inline-flex; align-items: center; font-size: 11px; font-weight: 620; padding: 2px 8px; border-radius: 4px; white-space: nowrap; }
    .sp-module-tag.master    { background: var(--sp-accent-light); color: var(--sp-accent); }
    .sp-module-tag.products  { background: var(--sp-blue-bg);    color: var(--sp-blue); }
    .sp-module-tag.orders    { background: var(--sp-green-bg);   color: var(--sp-green); }
    .sp-module-tag.content   { background: var(--sp-amber-bg);   color: var(--sp-amber); }
    .sp-module-tag.marketing { background: var(--sp-purple-bg);  color: var(--sp-purple); }
    .sp-module-tag.settings  { background: #f3f4f6;              color: var(--sp-text-secondary); }
    .sp-module-tag.reports   { background: var(--sp-blue-bg);    color: var(--sp-blue); }
    .sp-module-tag.auth      { background: var(--sp-accent-light); color: var(--sp-accent); }

    /* Action pill */
    .sp-act-pill { display: inline-flex; align-items: center; gap: 4px; font-size: 11px; font-weight: 650; padding: 2px 8px; border-radius: 20px; white-space: nowrap; }
    .sp-act-pill.create { background: var(--sp-green-bg); color: var(--sp-green); }
    .sp-act-pill.edit   { background: var(--sp-amber-bg); color: var(--sp-amber); }
    .sp-act-pill.delete { background: var(--sp-red-bg);   color: var(--sp-red); }
    .sp-act-pill.view   { background: var(--sp-blue-bg);  color: var(--sp-blue); }
    .sp-act-pill.login  { background: var(--sp-accent-light); color: var(--sp-accent); }
    .sp-act-pill.logout { background: #f3f4f6; color: var(--sp-text-hint); }
    .sp-act-pill.export { background: var(--sp-purple-bg); color: var(--sp-purple); }

    /* ── Sidebar member list ── */
    .sp-member-item { display: flex; align-items: center; gap: 10px; padding: 8px 0; border-bottom: 1px solid var(--sp-bg); cursor: pointer; border-radius: var(--sp-radius-sm); transition: background .1s; }
    .sp-member-item:last-child { border-bottom: none; }
    .sp-member-item:hover { background: var(--sp-bg); }
    .sp-member-item.active { background: var(--sp-accent-light); }
    .sp-member-name { font-size: 13px; font-weight: 560; color: var(--sp-text-primary); }
    .sp-member-role { font-size: 11.5px; color: var(--sp-text-hint); margin-top: 1px; }
    .sp-member-count { margin-left: auto; font-size: 11.5px; font-weight: 650; color: var(--sp-accent); background: var(--sp-accent-light); padding: 2px 7px; border-radius: 10px; }

    /* ── Pagination ── */
    .sp-pagination { padding: 13px 20px; border-top: 1px solid var(--sp-border); display: flex; align-items: center; justify-content: space-between; background: var(--sp-surface); font-size: 12.5px; color: var(--sp-text-hint); }
    .sp-pag-btns { display: flex; gap: 4px; }
    .sp-pag-btn { display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border: 1px solid var(--sp-border); border-radius: var(--sp-radius-sm); background: var(--sp-surface); color: var(--sp-text-secondary); font-size: 12.5px; font-weight: 500; cursor: pointer; text-decoration: none; transition: all .12s; font-family: var(--sp-font); }
    .sp-pag-btn:hover { background: var(--sp-bg); color: var(--sp-text-primary); }
    .sp-pag-btn.active { background: var(--sp-accent); border-color: var(--sp-accent); color: #fff; }
    .sp-pag-btn:disabled { opacity: .4; cursor: not-allowed; }

    .sp-btn-secondary { display: inline-flex; align-items: center; gap: 6px; background: var(--sp-surface); color: var(--sp-text-primary); border: 1px solid var(--sp-border); border-radius: var(--sp-radius-md); padding: 7px 14px; font-size: 13px; font-weight: 540; font-family: var(--sp-font); cursor: pointer; text-decoration: none; line-height: 1.4; transition: all .15s; white-space: nowrap; }
    .sp-btn-secondary:hover { background: var(--sp-bg); border-color: var(--sp-border-hover); }

    @media(max-width:768px) { .sp-page { padding: 16px; } .sp-search { width: 150px; } }
    </style>

    <div class="app-content content container-fluid">
        <div class="sp-page">

            <!-- Page header -->
            <div class="sp-page-header">
                <div>
                    <h1 class="sp-page-title">Activity Log</h1>
                    <div class="sp-crumb">
                        <a href="#">Dashboard</a>
                        <span style="color:var(--sp-border-hover)">›</span>
                        <a href="#">Roles & Settings</a>
                        <span style="color:var(--sp-border-hover)">›</span>
                        <span>Activity Log</span>
                    </div>
                </div>
                <button class="sp-btn-secondary">
                    <i class="fa fa-download"></i> Export Log
                </button>
            </div>

            <!-- KPI strip -->
            <div class="sp-kpi-strip">
                <div class="sp-kpi">
                    <div class="sp-kpi-top">
                        <span class="sp-kpi-label">Total Actions</span>
                        <div class="sp-kpi-icon" style="background:var(--sp-accent-light);color:var(--sp-accent)"><i class="fa fa-bolt"></i></div>
                    </div>
                    <div class="sp-kpi-value">1,284</div>
                    <div class="sp-kpi-sub">All time</div>
                </div>
                <div class="sp-kpi">
                    <div class="sp-kpi-top">
                        <span class="sp-kpi-label">Today</span>
                        <div class="sp-kpi-icon" style="background:var(--sp-green-bg);color:var(--sp-green)"><i class="fa fa-calendar-day"></i></div>
                    </div>
                    <div class="sp-kpi-value">47</div>
                    <div class="sp-kpi-sub">Actions today</div>
                </div>
                <div class="sp-kpi">
                    <div class="sp-kpi-top">
                        <span class="sp-kpi-label">Created</span>
                        <div class="sp-kpi-icon" style="background:var(--sp-green-bg);color:var(--sp-green)"><i class="fa fa-plus-circle"></i></div>
                    </div>
                    <div class="sp-kpi-value">312</div>
                    <div class="sp-kpi-sub">New records</div>
                </div>
                <div class="sp-kpi">
                    <div class="sp-kpi-top">
                        <span class="sp-kpi-label">Deleted</span>
                        <div class="sp-kpi-icon" style="background:var(--sp-red-bg);color:var(--sp-red)"><i class="fa fa-trash"></i></div>
                    </div>
                    <div class="sp-kpi-value">89</div>
                    <div class="sp-kpi-sub">Records removed</div>
                </div>
                <div class="sp-kpi">
                    <div class="sp-kpi-top">
                        <span class="sp-kpi-label">Active Members</span>
                        <div class="sp-kpi-icon" style="background:var(--sp-blue-bg);color:var(--sp-blue)"><i class="fa fa-users"></i></div>
                    </div>
                    <div class="sp-kpi-value">6</div>
                    <div class="sp-kpi-sub">Out of 8 total</div>
                </div>
            </div>

            <div class="sp-log-layout">

                <!-- LEFT — activity feed -->
                <div>
                    <div class="sp-card">

                        <!-- Toolbar -->
                        <div class="sp-toolbar">
                            <div class="sp-toolbar-left">
                                <span class="sp-filter-pill active" onclick="setFilter(this,'all')">All</span>
                                <span class="sp-filter-pill" onclick="setFilter(this,'create')">Created</span>
                                <span class="sp-filter-pill" onclick="setFilter(this,'edit')">Edited</span>
                                <span class="sp-filter-pill" onclick="setFilter(this,'delete')">Deleted</span>
                                <span class="sp-filter-pill" onclick="setFilter(this,'login')">Login/Logout</span>
                                <span class="sp-filter-pill" onclick="setFilter(this,'export')">Exports</span>
                            </div>
                            <div class="sp-toolbar-right">
                                <div class="sp-search-wrap">
                                    <i class="fa fa-search sp-search-icon"></i>
                                    <input type="text" class="sp-search" placeholder="Search activities…">
                                </div>
                                <select class="sp-select-sm">
                                    <option>All Members</option>
                                    <option>Arjun Sharma</option>
                                    <option>Priya Verma</option>
                                    <option>Rahul Singh</option>
                                    <option>Sneha Patel</option>
                                </select>
                                <select class="sp-select-sm">
                                    <option>All Modules</option>
                                    <option>Master</option>
                                    <option>Products</option>
                                    <option>Orders</option>
                                    <option>Content</option>
                                    <option>Marketing</option>
                                    <option>Settings</option>
                                </select>
                            </div>
                        </div>

                        <!-- TODAY -->
                        <div class="sp-date-group">Today — 23 Jun 2025</div>

                        <div class="sp-activity-item" data-action="create">
                            <div class="sp-avatar" style="background:#303d89">AS</div>
                            <div class="sp-act-icon create"><i class="fa fa-plus"></i></div>
                            <div class="sp-act-body">
                                <div class="sp-act-header">
                                    <div class="sp-act-title"><strong>Arjun Sharma</strong> created a new product</div>
                                    <span class="sp-act-time"><i class="fa fa-clock" style="font-size:10px;margin-right:3px"></i>2 min ago</span>
                                </div>
                                <div class="sp-act-meta">
                                    <span class="sp-act-pill create"><i class="fa fa-plus"></i> Create</span>
                                    <span class="sp-module-tag products">Products</span>
                                    <span style="font-size:11.5px;color:var(--sp-text-hint)">Record ID: #PRD-4821</span>
                                </div>
                                <div class="sp-act-detail">Added "Chikankari Kurta Set (XL, White)" to the product catalogue with 50 units stock.</div>
                            </div>
                        </div>

                        <div class="sp-activity-item" data-action="edit">
                            <div class="sp-avatar" style="background:#007a5e">PV</div>
                            <div class="sp-act-icon edit"><i class="fa fa-pencil"></i></div>
                            <div class="sp-act-body">
                                <div class="sp-act-header">
                                    <div class="sp-act-title"><strong>Priya Verma</strong> updated an order status</div>
                                    <span class="sp-act-time"><i class="fa fa-clock" style="font-size:10px;margin-right:3px"></i>14 min ago</span>
                                </div>
                                <div class="sp-act-meta">
                                    <span class="sp-act-pill edit"><i class="fa fa-pencil"></i> Edit</span>
                                    <span class="sp-module-tag orders">Orders</span>
                                    <span style="font-size:11.5px;color:var(--sp-text-hint)">Order #ORD-1089</span>
                                </div>
                                <div class="sp-act-detail">Changed status from <strong>Processing</strong> → <strong>Shipped</strong>. Tracking added: BD8842019.</div>
                            </div>
                        </div>

                        <div class="sp-activity-item" data-action="delete">
                            <div class="sp-avatar" style="background:#c0392b">RS</div>
                            <div class="sp-act-icon delete"><i class="fa fa-trash"></i></div>
                            <div class="sp-act-body">
                                <div class="sp-act-header">
                                    <div class="sp-act-title"><strong>Rahul Singh</strong> deleted a coupon</div>
                                    <span class="sp-act-time"><i class="fa fa-clock" style="font-size:10px;margin-right:3px"></i>38 min ago</span>
                                </div>
                                <div class="sp-act-meta">
                                    <span class="sp-act-pill delete"><i class="fa fa-trash"></i> Delete</span>
                                    <span class="sp-module-tag marketing">Marketing</span>
                                    <span style="font-size:11.5px;color:var(--sp-text-hint)">Coupon: SAVE20</span>
                                </div>
                                <div class="sp-act-detail">Deleted expired coupon "SAVE20" (20% off, expired 21 Jun 2025).</div>
                            </div>
                        </div>

                        <div class="sp-activity-item" data-action="create">
                            <div class="sp-avatar" style="background:#6d28d9">SP</div>
                            <div class="sp-act-icon create"><i class="fa fa-plus"></i></div>
                            <div class="sp-act-body">
                                <div class="sp-act-header">
                                    <div class="sp-act-title"><strong>Sneha Patel</strong> published a new blog post</div>
                                    <span class="sp-act-time"><i class="fa fa-clock" style="font-size:10px;margin-right:3px"></i>1 hour ago</span>
                                </div>
                                <div class="sp-act-meta">
                                    <span class="sp-act-pill create"><i class="fa fa-plus"></i> Create</span>
                                    <span class="sp-module-tag content">Content</span>
                                    <span style="font-size:11.5px;color:var(--sp-text-hint)">Blog ID: #BLG-112</span>
                                </div>
                                <div class="sp-act-detail">Published "Top 10 Wedding Outfit Ideas for 2025" — 1,240 words, 4 images.</div>
                            </div>
                        </div>

                        <div class="sp-activity-item" data-action="login">
                            <div class="sp-avatar" style="background:#303d89">AS</div>
                            <div class="sp-act-icon login"><i class="fa fa-sign-in-alt"></i></div>
                            <div class="sp-act-body">
                                <div class="sp-act-header">
                                    <div class="sp-act-title"><strong>Arjun Sharma</strong> logged in</div>
                                    <span class="sp-act-time"><i class="fa fa-clock" style="font-size:10px;margin-right:3px"></i>2 hours ago</span>
                                </div>
                                <div class="sp-act-meta">
                                    <span class="sp-act-pill login"><i class="fa fa-sign-in-alt"></i> Login</span>
                                    <span class="sp-module-tag auth">Auth</span>
                                    <span style="font-size:11.5px;color:var(--sp-text-hint)">IP: 103.21.58.9 &nbsp;·&nbsp; Chrome / Windows</span>
                                </div>
                                <div class="sp-act-detail">New Delhi, India</div>
                            </div>
                        </div>

                        <div class="sp-activity-item" data-action="edit">
                            <div class="sp-avatar" style="background:#007a5e">PV</div>
                            <div class="sp-act-icon edit"><i class="fa fa-pencil"></i></div>
                            <div class="sp-act-body">
                                <div class="sp-act-header">
                                    <div class="sp-act-title"><strong>Priya Verma</strong> updated general settings</div>
                                    <span class="sp-act-time"><i class="fa fa-clock" style="font-size:10px;margin-right:3px"></i>3 hours ago</span>
                                </div>
                                <div class="sp-act-meta">
                                    <span class="sp-act-pill edit"><i class="fa fa-pencil"></i> Edit</span>
                                    <span class="sp-module-tag settings">Settings</span>
                                </div>
                                <div class="sp-act-detail">Updated store contact email and WhatsApp number in General Settings.</div>
                            </div>
                        </div>

                        <div class="sp-activity-item" data-action="export">
                            <div class="sp-avatar" style="background:#6d28d9">SP</div>
                            <div class="sp-act-icon export"><i class="fa fa-file-export"></i></div>
                            <div class="sp-act-body">
                                <div class="sp-act-header">
                                    <div class="sp-act-title"><strong>Sneha Patel</strong> exported sales report</div>
                                    <span class="sp-act-time"><i class="fa fa-clock" style="font-size:10px;margin-right:3px"></i>4 hours ago</span>
                                </div>
                                <div class="sp-act-meta">
                                    <span class="sp-act-pill export"><i class="fa fa-download"></i> Export</span>
                                    <span class="sp-module-tag reports">Reports</span>
                                </div>
                                <div class="sp-act-detail">Exported Sales Report (May 2025 — Jun 2025) as CSV. 342 rows.</div>
                            </div>
                        </div>

                        <!-- YESTERDAY -->
                        <div class="sp-date-group">Yesterday — 22 Jun 2025</div>

                        <div class="sp-activity-item" data-action="create">
                            <div class="sp-avatar" style="background:#0069d9">DK</div>
                            <div class="sp-act-icon create"><i class="fa fa-plus"></i></div>
                            <div class="sp-act-body">
                                <div class="sp-act-header">
                                    <div class="sp-act-title"><strong>Deepak Kumar</strong> added a new brand</div>
                                    <span class="sp-act-time"><i class="fa fa-clock" style="font-size:10px;margin-right:3px"></i>Yesterday, 5:40 PM</span>
                                </div>
                                <div class="sp-act-meta">
                                    <span class="sp-act-pill create"><i class="fa fa-plus"></i> Create</span>
                                    <span class="sp-module-tag master">Master</span>
                                    <span style="font-size:11.5px;color:var(--sp-text-hint)">Brand ID: #BRN-28</span>
                                </div>
                                <div class="sp-act-detail">Created brand "Anokhi" with logo, description and 3 linked categories.</div>
                            </div>
                        </div>

                        <div class="sp-activity-item" data-action="edit">
                            <div class="sp-avatar" style="background:#303d89">AS</div>
                            <div class="sp-act-icon edit"><i class="fa fa-pencil"></i></div>
                            <div class="sp-act-body">
                                <div class="sp-act-header">
                                    <div class="sp-act-title"><strong>Arjun Sharma</strong> updated product stock</div>
                                    <span class="sp-act-time"><i class="fa fa-clock" style="font-size:10px;margin-right:3px"></i>Yesterday, 2:15 PM</span>
                                </div>
                                <div class="sp-act-meta">
                                    <span class="sp-act-pill edit"><i class="fa fa-pencil"></i> Edit</span>
                                    <span class="sp-module-tag products">Products</span>
                                    <span style="font-size:11.5px;color:var(--sp-text-hint)">SKU-4421</span>
                                </div>
                                <div class="sp-act-detail">Updated stock from <strong>2 units</strong> → <strong>120 units</strong> for Bakhiya Shadow Work Dupatta (Red, M).</div>
                            </div>
                        </div>

                        <div class="sp-activity-item" data-action="delete">
                            <div class="sp-avatar" style="background:#c0392b">RS</div>
                            <div class="sp-act-icon delete"><i class="fa fa-trash"></i></div>
                            <div class="sp-act-body">
                                <div class="sp-act-header">
                                    <div class="sp-act-title"><strong>Rahul Singh</strong> deleted a customer review</div>
                                    <span class="sp-act-time"><i class="fa fa-clock" style="font-size:10px;margin-right:3px"></i>Yesterday, 10:30 AM</span>
                                </div>
                                <div class="sp-act-meta">
                                    <span class="sp-act-pill delete"><i class="fa fa-trash"></i> Delete</span>
                                    <span class="sp-module-tag products">Products</span>
                                    <span style="font-size:11.5px;color:var(--sp-text-hint)">Review #RVW-88</span>
                                </div>
                                <div class="sp-act-detail">Removed spam review on "Lucknowi Kurta (White, L)". Reason: Irrelevant content.</div>
                            </div>
                        </div>

                        <div class="sp-activity-item" data-action="login">
                            <div class="sp-avatar" style="background:#007a5e">PV</div>
                            <div class="sp-act-icon logout"><i class="fa fa-sign-out-alt"></i></div>
                            <div class="sp-act-body">
                                <div class="sp-act-header">
                                    <div class="sp-act-title"><strong>Priya Verma</strong> logged out</div>
                                    <span class="sp-act-time"><i class="fa fa-clock" style="font-size:10px;margin-right:3px"></i>Yesterday, 7:00 PM</span>
                                </div>
                                <div class="sp-act-meta">
                                    <span class="sp-act-pill logout"><i class="fa fa-sign-out-alt"></i> Logout</span>
                                    <span class="sp-module-tag auth">Auth</span>
                                    <span style="font-size:11.5px;color:var(--sp-text-hint)">Session: 6h 42m</span>
                                </div>
                            </div>
                        </div>

                        <!-- Pagination -->
                        <div class="sp-pagination">
                            <span>Showing 12 of 1,284 activities</span>
                            <div class="sp-pag-btns">
                                <button class="sp-pag-btn" disabled><i class="fa fa-chevron-left"></i></button>
                                <button class="sp-pag-btn active">1</button>
                                <button class="sp-pag-btn">2</button>
                                <button class="sp-pag-btn">3</button>
                                <span style="padding:0 6px;color:var(--sp-text-hint)">…</span>
                                <button class="sp-pag-btn">107</button>
                                <button class="sp-pag-btn"><i class="fa fa-chevron-right"></i></button>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- RIGHT — sidebar -->
                <div>

                    <!-- Team member filter -->
                    <div class="sp-card">
                        <div class="sp-card-header"><h5>Filter by Member</h5></div>
                        <div class="sp-card-body-sm">

                            <div class="sp-member-item active" onclick="filterMember(this)">
                                <div class="sp-avatar" style="width:32px;height:32px;font-size:12px;background:#303d89">AS</div>
                                <div>
                                    <div class="sp-member-name">Arjun Sharma</div>
                                    <div class="sp-member-role">Super Admin</div>
                                </div>
                                <span class="sp-member-count">412</span>
                            </div>

                            <div class="sp-member-item" onclick="filterMember(this)">
                                <div class="sp-avatar" style="width:32px;height:32px;font-size:12px;background:#007a5e">PV</div>
                                <div>
                                    <div class="sp-member-name">Priya Verma</div>
                                    <div class="sp-member-role">Manager</div>
                                </div>
                                <span class="sp-member-count">287</span>
                            </div>

                            <div class="sp-member-item" onclick="filterMember(this)">
                                <div class="sp-avatar" style="width:32px;height:32px;font-size:12px;background:#c0392b">RS</div>
                                <div>
                                    <div class="sp-member-name">Rahul Singh</div>
                                    <div class="sp-member-role">Manager</div>
                                </div>
                                <span class="sp-member-count">198</span>
                            </div>

                            <div class="sp-member-item" onclick="filterMember(this)">
                                <div class="sp-avatar" style="width:32px;height:32px;font-size:12px;background:#6d28d9">SP</div>
                                <div>
                                    <div class="sp-member-name">Sneha Patel</div>
                                    <div class="sp-member-role">Content Editor</div>
                                </div>
                                <span class="sp-member-count">224</span>
                            </div>

                            <div class="sp-member-item" onclick="filterMember(this)">
                                <div class="sp-avatar" style="width:32px;height:32px;font-size:12px;background:#0069d9">DK</div>
                                <div>
                                    <div class="sp-member-name">Deepak Kumar</div>
                                    <div class="sp-member-role">Content Editor</div>
                                </div>
                                <span class="sp-member-count">163</span>
                            </div>

                        </div>
                    </div>

                    <!-- Action breakdown -->
                    <div class="sp-card">
                        <div class="sp-card-header"><h5>Action Breakdown</h5></div>
                        <div class="sp-card-body-sm">
                            <div style="display:flex;flex-direction:column;gap:10px">

                                <div>
                                    <div style="display:flex;justify-content:space-between;font-size:12.5px;margin-bottom:4px">
                                        <span style="color:var(--sp-green);font-weight:600"><i class="fa fa-plus-circle"></i> Create</span>
                                        <span style="font-weight:650;color:var(--sp-text-primary)">312</span>
                                    </div>
                                    <div style="background:var(--sp-bg);border-radius:20px;height:5px;overflow:hidden">
                                        <div style="width:24%;height:100%;background:var(--sp-green);border-radius:20px"></div>
                                    </div>
                                </div>

                                <div>
                                    <div style="display:flex;justify-content:space-between;font-size:12.5px;margin-bottom:4px">
                                        <span style="color:#916a00;font-weight:600"><i class="fa fa-pencil"></i> Edit</span>
                                        <span style="font-weight:650;color:var(--sp-text-primary)">598</span>
                                    </div>
                                    <div style="background:var(--sp-bg);border-radius:20px;height:5px;overflow:hidden">
                                        <div style="width:47%;height:100%;background:#916a00;border-radius:20px"></div>
                                    </div>
                                </div>

                                <div>
                                    <div style="display:flex;justify-content:space-between;font-size:12.5px;margin-bottom:4px">
                                        <span style="color:var(--sp-red);font-weight:600"><i class="fa fa-trash"></i> Delete</span>
                                        <span style="font-weight:650;color:var(--sp-text-primary)">89</span>
                                    </div>
                                    <div style="background:var(--sp-bg);border-radius:20px;height:5px;overflow:hidden">
                                        <div style="width:7%;height:100%;background:var(--sp-red);border-radius:20px"></div>
                                    </div>
                                </div>

                                <div>
                                    <div style="display:flex;justify-content:space-between;font-size:12.5px;margin-bottom:4px">
                                        <span style="color:#0069d9;font-weight:600"><i class="fa fa-eye"></i> View</span>
                                        <span style="font-weight:650;color:var(--sp-text-primary)">221</span>
                                    </div>
                                    <div style="background:var(--sp-bg);border-radius:20px;height:5px;overflow:hidden">
                                        <div style="width:17%;height:100%;background:#0069d9;border-radius:20px"></div>
                                    </div>
                                </div>

                                <div>
                                    <div style="display:flex;justify-content:space-between;font-size:12.5px;margin-bottom:4px">
                                        <span style="color:var(--sp-accent);font-weight:600"><i class="fa fa-sign-in-alt"></i> Login/Logout</span>
                                        <span style="font-weight:650;color:var(--sp-text-primary)">64</span>
                                    </div>
                                    <div style="background:var(--sp-bg);border-radius:20px;height:5px;overflow:hidden">
                                        <div style="width:5%;height:100%;background:var(--sp-accent);border-radius:20px"></div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
</div>

@include('admin.footer')

<script>
let currentFilter = 'all';
function setFilter(el, type) {
    document.querySelectorAll('.sp-filter-pill').forEach(p => p.classList.remove('active'));
    el.classList.add('active');
    currentFilter = type;
    document.querySelectorAll('.sp-activity-item').forEach(item => {
        item.style.display = (type === 'all' || item.dataset.action === type) ? '' : 'none';
    });
}
function filterMember(el) {
    document.querySelectorAll('.sp-member-item').forEach(m => m.classList.remove('active'));
    el.classList.add('active');
}
</script>