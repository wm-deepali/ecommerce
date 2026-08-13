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
        --sp-amber: #916a00; --sp-amber-bg: #fff5cc; --sp-amber-border: #e8d080;
        --sp-blue: #0069d9; --sp-blue-bg: #e8f2ff;
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
    .sp-kpi-strip { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 20px; }
    @media(max-width:900px) { .sp-kpi-strip { grid-template-columns: repeat(2,1fr); } }
    .sp-kpi { background: var(--sp-surface); border: 1px solid var(--sp-border); border-radius: var(--sp-radius-lg); padding: 16px 18px 14px; box-shadow: var(--sp-shadow-card); }
    .sp-kpi-top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px; }
    .sp-kpi-label { font-size: 11.5px; font-weight: 620; color: var(--sp-text-hint); text-transform: uppercase; letter-spacing: .04em; }
    .sp-kpi-icon { width: 32px; height: 32px; border-radius: var(--sp-radius-md); display: flex; align-items: center; justify-content: center; font-size: 13px; }
    .sp-kpi-value { font-size: 26px; font-weight: 750; color: var(--sp-text-primary); line-height: 1; }
    .sp-kpi-sub { font-size: 11.5px; color: var(--sp-text-hint); margin-top: 5px; display: flex; align-items: center; gap: 5px; }
    .sp-online-blink { width: 7px; height: 7px; border-radius: 50%; background: var(--sp-green); flex-shrink: 0; animation: blink 1.5s infinite; }
    @keyframes blink { 0%,100%{opacity:1} 50%{opacity:.35} }

    /* ── Card ── */
    .sp-card { background: var(--sp-surface); border-radius: var(--sp-radius-lg); box-shadow: var(--sp-shadow-card); border: 1px solid var(--sp-border); overflow: hidden; }

    /* ── Toolbar ── */
    .sp-toolbar { padding: 12px 16px; border-bottom: 1px solid var(--sp-border); background: #fafafa; display: flex; align-items: center; justify-content: space-between; gap: 10px; flex-wrap: wrap; }
    .sp-toolbar-left { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
    .sp-toolbar-right { display: flex; align-items: center; gap: 8px; }
    .sp-search-wrap { position: relative; }
    .sp-search { height: 32px; border: 1px solid var(--sp-border); border-radius: var(--sp-radius-md); padding: 0 10px 0 30px; font-size: 12.5px; color: var(--sp-text-primary); background: var(--sp-surface); outline: none; font-family: var(--sp-font); width: 220px; transition: border-color .15s, box-shadow .15s; }
    .sp-search:focus { border-color: var(--sp-accent); box-shadow: 0 0 0 3px rgba(48,61,137,.10); }
    .sp-search-icon { position: absolute; left: 9px; top: 50%; transform: translateY(-50%); color: var(--sp-text-hint); font-size: 11px; pointer-events: none; }
    .sp-select-sm { height: 32px; border: 1px solid var(--sp-border); border-radius: var(--sp-radius-md); padding: 0 28px 0 10px; font-size: 12.5px; color: var(--sp-text-primary); background: var(--sp-surface); outline: none; font-family: var(--sp-font); appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%238c9196'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 9px center; }

    /* ── Table ── */
    .sp-table { width: 100%; border-collapse: collapse; font-size: 13.5px; font-family: var(--sp-font); }
    .sp-table thead th { padding: 11px 16px; background: #fafafa; border-bottom: 1px solid var(--sp-border); font-size: 11px; font-weight: 650; letter-spacing: .055em; text-transform: uppercase; color: var(--sp-text-hint); text-align: left; white-space: nowrap; }
    .sp-table tbody tr { border-bottom: 1px solid var(--sp-border); transition: background .1s; }
    .sp-table tbody tr:last-child { border-bottom: none; }
    .sp-table tbody tr:hover { background: #f7f8f9; }
    .sp-table tbody tr.sp-warn-row { background: #fffbf0; }
    .sp-table tbody tr.sp-warn-row:hover { background: #fff5e0; }
    .sp-table td { padding: 14px 16px; vertical-align: middle; }

    /* ── Member cell ── */
    .sp-member-cell { display: flex; align-items: center; gap: 11px; }
    .sp-avatar { width: 38px; height: 38px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 700; color: #fff; flex-shrink: 0; position: relative; }
    .sp-status-dot { position: absolute; bottom: 1px; right: 1px; width: 10px; height: 10px; border-radius: 50%; border: 2px solid var(--sp-surface); }
    .sp-status-dot.online  { background: var(--sp-green); animation: blink 1.5s infinite; }
    .sp-status-dot.offline { background: #c9cccf; }
    .sp-member-name { font-size: 13.5px; font-weight: 580; color: var(--sp-text-primary); margin-bottom: 2px; }
    .sp-member-email { font-size: 11.5px; color: var(--sp-text-hint); }
    .sp-role-tag { display: inline-flex; font-size: 11px; font-weight: 620; padding: 2px 8px; border-radius: 4px; background: var(--sp-accent-light); color: var(--sp-accent); margin-top: 3px; }

    /* ── Last login cell ── */
    .sp-login-time { font-size: 13px; font-weight: 560; color: var(--sp-text-primary); }
    .sp-login-date { font-size: 11.5px; color: var(--sp-text-hint); margin-top: 2px; }

    /* ── IP cell ── */
    .sp-ip { font-family: 'SF Mono','Fira Code',monospace; font-size: 12.5px; color: var(--sp-text-secondary); }
    .sp-ip.warn { color: var(--sp-amber); }
    .sp-ip-flag { font-size: 11px; color: var(--sp-amber); margin-top: 2px; display: flex; align-items: center; gap: 3px; }

    /* ── Location cell ── */
    .sp-loc { display: flex; align-items: center; gap: 5px; font-size: 13px; color: var(--sp-text-primary); }
    .sp-loc i { color: var(--sp-text-hint); font-size: 11px; }
    .sp-loc.warn { color: var(--sp-amber); }
    .sp-loc-isp { font-size: 11.5px; color: var(--sp-text-hint); margin-top: 2px; }

    /* ── Device cell ── */
    .sp-device-wrap { display: flex; align-items: center; gap: 7px; }
    .sp-device-icon { width: 28px; height: 28px; border-radius: var(--sp-radius-sm); background: var(--sp-bg); border: 1px solid var(--sp-border); display: flex; align-items: center; justify-content: center; font-size: 12px; color: var(--sp-text-secondary); flex-shrink: 0; }
    .sp-device-name { font-size: 13px; color: var(--sp-text-primary); }
    .sp-device-os   { font-size: 11.5px; color: var(--sp-text-hint); margin-top: 1px; }

    /* ── Session duration ── */
    .sp-duration { display: inline-flex; align-items: center; gap: 4px; font-size: 12px; color: var(--sp-text-secondary); background: var(--sp-bg); border: 1px solid var(--sp-border); padding: 2px 8px; border-radius: 5px; font-weight: 560; white-space: nowrap; }
    .sp-duration.active { background: var(--sp-green-bg); border-color: #9fcfc3; color: var(--sp-green); }

    /* ── Login count chip ── */
    .sp-count-chip { display: inline-flex; align-items: center; justify-content: center; min-width: 28px; height: 22px; padding: 0 8px; background: var(--sp-accent-light); color: var(--sp-accent); border-radius: 5px; font-size: 12px; font-weight: 650; }

    /* ── Status pills ── */
    .sp-pill { display: inline-flex; align-items: center; gap: 5px; font-size: 11.5px; font-weight: 620; padding: 3px 9px; border-radius: 20px; white-space: nowrap; }
    .sp-pill::before { content: ''; width: 5px; height: 5px; border-radius: 50%; display: inline-block; flex-shrink: 0; }
    .sp-pill-online      { background: var(--sp-green-bg); color: var(--sp-green); }
    .sp-pill-online::before { background: var(--sp-green); animation: blink 1.5s infinite; }
    .sp-pill-offline     { background: #f3f4f6; color: var(--sp-text-hint); }
    .sp-pill-offline::before { background: #c9cccf; }
    .sp-pill-suspicious  { background: var(--sp-amber-bg); color: var(--sp-amber); border: 1px solid var(--sp-amber-border); }
    .sp-pill-suspicious::before { background: var(--sp-amber); }

    /* ── Actions ── */
    .sp-actions { display: flex; gap: 6px; align-items: center; }
    .sp-action-btn { display: inline-flex; align-items: center; justify-content: center; gap: 5px; height: 30px; padding: 0 11px; border-radius: var(--sp-radius-sm); border: 1px solid var(--sp-border); background: var(--sp-surface); color: var(--sp-text-secondary); cursor: pointer; text-decoration: none; transition: all .15s; font-size: 12.5px; font-family: var(--sp-font); font-weight: 540; white-space: nowrap; }
    .sp-action-btn:hover { background: var(--sp-accent-light); border-color: var(--sp-accent); color: var(--sp-accent); }
    .sp-action-btn.danger:hover { background: var(--sp-red-bg); border-color: #f5b8b8; color: var(--sp-red); }

    /* ── Alert notice ── */
    .sp-notice { display: flex; align-items: center; gap: 10px; background: var(--sp-amber-bg); border: 1px solid var(--sp-amber-border); border-radius: var(--sp-radius-md); padding: 12px 16px; margin-bottom: 16px; font-size: 13px; color: var(--sp-amber); }
    .sp-notice i { font-size: 15px; flex-shrink: 0; }
    .sp-notice a { color: var(--sp-amber); font-weight: 650; text-decoration: underline; }

    /* ── Pagination ── */
    .sp-pagination { padding: 13px 20px; border-top: 1px solid var(--sp-border); display: flex; align-items: center; justify-content: space-between; background: var(--sp-surface); font-size: 12.5px; color: var(--sp-text-hint); }
    .sp-pag-btns { display: flex; gap: 4px; }
    .sp-pag-btn { display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border: 1px solid var(--sp-border); border-radius: var(--sp-radius-sm); background: var(--sp-surface); color: var(--sp-text-secondary); font-size: 12.5px; cursor: pointer; transition: all .12s; font-family: var(--sp-font); }
    .sp-pag-btn:hover { background: var(--sp-bg); }
    .sp-pag-btn.active { background: var(--sp-accent); border-color: var(--sp-accent); color: #fff; }
    .sp-pag-btn:disabled { opacity:.4; cursor:not-allowed; }

    .sp-btn-secondary { display: inline-flex; align-items: center; gap: 6px; background: var(--sp-surface); color: var(--sp-text-primary); border: 1px solid var(--sp-border); border-radius: var(--sp-radius-md); padding: 7px 14px; font-size: 13px; font-weight: 540; font-family: var(--sp-font); cursor: pointer; text-decoration: none; line-height: 1.4; transition: all .15s; white-space: nowrap; }
    .sp-btn-secondary:hover { background: var(--sp-bg); border-color: var(--sp-border-hover); }

    @media(max-width:768px) { .sp-page { padding: 16px; } .sp-search { width: 150px; } }
    </style>

    <div class="app-content content container-fluid">
        <div class="sp-page">

            <!-- Page header -->
            <div class="sp-page-header">
                <div>
                    <h1 class="sp-page-title">Login Summary</h1>
                    <div class="sp-crumb">
                        <a href="#">Dashboard</a>
                        <span style="color:var(--sp-border-hover)">›</span>
                        <a href="#">Roles & Settings</a>
                        <span style="color:var(--sp-border-hover)">›</span>
                        <span>Login Summary</span>
                    </div>
                </div>
                <button class="sp-btn-secondary">
                    <i class="fa fa-download"></i> Export
                </button>
            </div>

            <!-- KPI strip -->
            <div class="sp-kpi-strip">
                <div class="sp-kpi">
                    <div class="sp-kpi-top">
                        <span class="sp-kpi-label">Total Members</span>
                        <div class="sp-kpi-icon" style="background:var(--sp-accent-light);color:var(--sp-accent)"><i class="fa fa-users"></i></div>
                    </div>
                    <div class="sp-kpi-value">8</div>
                    <div class="sp-kpi-sub">Admin team</div>
                </div>
                <div class="sp-kpi">
                    <div class="sp-kpi-top">
                        <span class="sp-kpi-label">Currently Online</span>
                        <div class="sp-kpi-icon" style="background:var(--sp-green-bg);color:var(--sp-green)"><i class="fa fa-circle"></i></div>
                    </div>
                    <div class="sp-kpi-value">3</div>
                    <div class="sp-kpi-sub"><span class="sp-online-blink"></span> Active right now</div>
                </div>
                <div class="sp-kpi">
                    <div class="sp-kpi-top">
                        <span class="sp-kpi-label">Logins Today</span>
                        <div class="sp-kpi-icon" style="background:var(--sp-blue-bg);color:var(--sp-blue)"><i class="fa fa-sign-in-alt"></i></div>
                    </div>
                    <div class="sp-kpi-value">12</div>
                    <div class="sp-kpi-sub">Across all members</div>
                </div>
                <div class="sp-kpi">
                    <div class="sp-kpi-top">
                        <span class="sp-kpi-label">Suspicious</span>
                        <div class="sp-kpi-icon" style="background:var(--sp-amber-bg);color:var(--sp-amber)"><i class="fa fa-exclamation-triangle"></i></div>
                    </div>
                    <div class="sp-kpi-value">1</div>
                    <div class="sp-kpi-sub">Needs review</div>
                </div>
            </div>

            <!-- Suspicious notice -->
            <div class="sp-notice">
                <i class="fa fa-exclamation-triangle"></i>
                <span><strong>Suspicious login detected</strong> for <strong>Rahul Singh</strong> — login from Frankfurt, Germany at 3:42 AM (usual location: Jaipur, India).
                <a href="login-history-detail.html">Review now →</a></span>
            </div>

            <!-- Main card -->
            <div class="sp-card">

                <!-- Toolbar -->
                <div class="sp-toolbar">
                    <div class="sp-toolbar-left">
                        <div class="sp-search-wrap">
                            <i class="fa fa-search sp-search-icon"></i>
                            <input type="text" class="sp-search" placeholder="Search member name or email…" oninput="filterTable(this.value)">
                        </div>
                        <select class="sp-select-sm" onchange="filterStatus(this.value)">
                            <option value="">All Status</option>
                            <option value="online">Online</option>
                            <option value="offline">Offline</option>
                            <option value="suspicious">Suspicious</option>
                        </select>
                        <select class="sp-select-sm">
                            <option>All Roles</option>
                            <option>Super Admin</option>
                            <option>Manager</option>
                            <option>Content Editor</option>
                            <option>Support Agent</option>
                        </select>
                    </div>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="sp-table" id="loginTable">
                        <thead>
                            <tr>
                                <th>Member</th>
                                <th>Last Login</th>
                                <th>IP Address</th>
                                <th>Location</th>
                                <th>Device / Browser</th>
                                <th>Session</th>
                                <th style="width:80px">Total</th>
                                <th style="width:110px">Status</th>
                                <th style="width:100px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            <!-- 1. Arjun Sharma — Online -->
                            <tr data-status="online" data-name="arjun sharma arjun@store.com">
                                <td>
                                    <div class="sp-member-cell">
                                        <div class="sp-avatar" style="background:#303d89">
                                            AS
                                            <span class="sp-status-dot online"></span>
                                        </div>
                                        <div>
                                            <div class="sp-member-name">Arjun Sharma</div>
                                            <div class="sp-member-email">arjun@store.com</div>
                                            <span class="sp-role-tag">Super Admin</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="sp-login-time">Today, 9:14 AM</div>
                                    <div class="sp-login-date">23 Jun 2025</div>
                                </td>
                                <td>
                                    <div class="sp-ip">103.21.58.9</div>
                                    <div style="font-size:11px;color:var(--sp-text-hint);margin-top:2px">IN · Airtel</div>
                                </td>
                                <td>
                                    <div class="sp-loc"><i class="fa fa-map-marker-alt"></i> New Delhi, India</div>
                                    <div class="sp-loc-isp">Asia/Kolkata</div>
                                </td>
                                <td>
                                    <div class="sp-device-wrap">
                                        <div class="sp-device-icon"><i class="fa fa-desktop"></i></div>
                                        <div>
                                            <div class="sp-device-name">Chrome 124</div>
                                            <div class="sp-device-os">Windows 11</div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="sp-duration active"><i class="fa fa-circle" style="font-size:7px"></i> Active</span></td>
                                <td><span class="sp-count-chip">412</span></td>
                                <td><span class="sp-pill sp-pill-online">Online</span></td>
                                <td>
                                    <div class="sp-actions">
                                        <a href="login-history-detail.html" class="sp-action-btn" title="View History">
                                            <i class="fa fa-history"></i> History
                                        </a>
                                    </div>
                                </td>
                            </tr>

                            <!-- 2. Priya Verma — Online -->
                            <tr data-status="online" data-name="priya verma priya@store.com">
                                <td>
                                    <div class="sp-member-cell">
                                        <div class="sp-avatar" style="background:#007a5e">
                                            PV
                                            <span class="sp-status-dot online"></span>
                                        </div>
                                        <div>
                                            <div class="sp-member-name">Priya Verma</div>
                                            <div class="sp-member-email">priya@store.com</div>
                                            <span class="sp-role-tag">Manager</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="sp-login-time">Today, 10:02 AM</div>
                                    <div class="sp-login-date">23 Jun 2025</div>
                                </td>
                                <td>
                                    <div class="sp-ip">49.36.112.44</div>
                                    <div style="font-size:11px;color:var(--sp-text-hint);margin-top:2px">IN · Jio</div>
                                </td>
                                <td>
                                    <div class="sp-loc"><i class="fa fa-map-marker-alt"></i> Mumbai, India</div>
                                    <div class="sp-loc-isp">Asia/Kolkata</div>
                                </td>
                                <td>
                                    <div class="sp-device-wrap">
                                        <div class="sp-device-icon"><i class="fa fa-mobile-alt"></i></div>
                                        <div>
                                            <div class="sp-device-name">Safari 17</div>
                                            <div class="sp-device-os">iPhone iOS 17.4</div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="sp-duration active"><i class="fa fa-circle" style="font-size:7px"></i> Active</span></td>
                                <td><span class="sp-count-chip">287</span></td>
                                <td><span class="sp-pill sp-pill-online">Online</span></td>
                                <td>
                                    <div class="sp-actions">
                                        <a href="login-history-detail.html" class="sp-action-btn">
                                            <i class="fa fa-history"></i> History
                                        </a>
                                    </div>
                                </td>
                            </tr>

                            <!-- 3. Rahul Singh — Suspicious + Online -->
                            <tr data-status="suspicious" data-name="rahul singh rahul@store.com" class="sp-warn-row">
                                <td>
                                    <div class="sp-member-cell">
                                        <div class="sp-avatar" style="background:#c0392b">
                                            RS
                                            <span class="sp-status-dot online"></span>
                                        </div>
                                        <div>
                                            <div class="sp-member-name">Rahul Singh</div>
                                            <div class="sp-member-email">rahul@store.com</div>
                                            <span class="sp-role-tag">Manager</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="sp-login-time" style="color:var(--sp-amber)">Today, 8:47 AM</div>
                                    <div class="sp-login-date">23 Jun 2025</div>
                                </td>
                                <td>
                                    <div class="sp-ip warn">185.220.101.8</div>
                                    <div class="sp-ip-flag"><i class="fa fa-exclamation-triangle"></i> New IP · DE</div>
                                </td>
                                <td>
                                    <div class="sp-loc warn"><i class="fa fa-map-marker-alt"></i> Frankfurt, Germany</div>
                                    <div class="sp-loc-isp" style="color:var(--sp-amber)">Usual: Jaipur, India</div>
                                </td>
                                <td>
                                    <div class="sp-device-wrap">
                                        <div class="sp-device-icon"><i class="fa fa-desktop"></i></div>
                                        <div>
                                            <div class="sp-device-name">Firefox 126</div>
                                            <div class="sp-device-os">Ubuntu Linux</div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="sp-duration active"><i class="fa fa-circle" style="font-size:7px"></i> Active</span></td>
                                <td><span class="sp-count-chip">198</span></td>
                                <td><span class="sp-pill sp-pill-suspicious">Suspicious</span></td>
                                <td>
                                    <div class="sp-actions" style="flex-direction:column;gap:4px">
                                        <a href="login-history-detail.html" class="sp-action-btn">
                                            <i class="fa fa-history"></i> History
                                        </a>
                                        <button class="sp-action-btn danger" onclick="blockSession('Rahul Singh')">
                                            <i class="fa fa-ban"></i> Block
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- 4. Sneha Patel — Offline -->
                            <tr data-status="offline" data-name="sneha patel sneha@store.com">
                                <td>
                                    <div class="sp-member-cell">
                                        <div class="sp-avatar" style="background:#6d28d9">
                                            SP
                                            <span class="sp-status-dot offline"></span>
                                        </div>
                                        <div>
                                            <div class="sp-member-name">Sneha Patel</div>
                                            <div class="sp-member-email">sneha@store.com</div>
                                            <span class="sp-role-tag">Content Editor</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="sp-login-time">Yesterday, 6:58 PM</div>
                                    <div class="sp-login-date">22 Jun 2025</div>
                                </td>
                                <td>
                                    <div class="sp-ip">117.55.241.10</div>
                                    <div style="font-size:11px;color:var(--sp-text-hint);margin-top:2px">IN · BSNL</div>
                                </td>
                                <td>
                                    <div class="sp-loc"><i class="fa fa-map-marker-alt"></i> Bangalore, India</div>
                                    <div class="sp-loc-isp">Asia/Kolkata</div>
                                </td>
                                <td>
                                    <div class="sp-device-wrap">
                                        <div class="sp-device-icon"><i class="fa fa-laptop"></i></div>
                                        <div>
                                            <div class="sp-device-name">Chrome 124</div>
                                            <div class="sp-device-os">macOS Sonoma</div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="sp-duration"><i class="fa fa-clock"></i> 5h 22m</span></td>
                                <td><span class="sp-count-chip">224</span></td>
                                <td><span class="sp-pill sp-pill-offline">Offline</span></td>
                                <td>
                                    <div class="sp-actions">
                                        <a href="login-history-detail.html" class="sp-action-btn">
                                            <i class="fa fa-history"></i> History
                                        </a>
                                    </div>
                                </td>
                            </tr>

                            <!-- 5. Deepak Kumar — Offline -->
                            <tr data-status="offline" data-name="deepak kumar deepak@store.com">
                                <td>
                                    <div class="sp-member-cell">
                                        <div class="sp-avatar" style="background:#0069d9">
                                            DK
                                            <span class="sp-status-dot offline"></span>
                                        </div>
                                        <div>
                                            <div class="sp-member-name">Deepak Kumar</div>
                                            <div class="sp-member-email">deepak@store.com</div>
                                            <span class="sp-role-tag">Content Editor</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="sp-login-time">Yesterday, 3:20 PM</div>
                                    <div class="sp-login-date">22 Jun 2025</div>
                                </td>
                                <td>
                                    <div class="sp-ip">122.161.48.92</div>
                                    <div style="font-size:11px;color:var(--sp-text-hint);margin-top:2px">IN · Vodafone</div>
                                </td>
                                <td>
                                    <div class="sp-loc"><i class="fa fa-map-marker-alt"></i> Pune, India</div>
                                    <div class="sp-loc-isp">Asia/Kolkata</div>
                                </td>
                                <td>
                                    <div class="sp-device-wrap">
                                        <div class="sp-device-icon"><i class="fa fa-desktop"></i></div>
                                        <div>
                                            <div class="sp-device-name">Edge 124</div>
                                            <div class="sp-device-os">Windows 10</div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="sp-duration"><i class="fa fa-clock"></i> 3h 05m</span></td>
                                <td><span class="sp-count-chip">163</span></td>
                                <td><span class="sp-pill sp-pill-offline">Offline</span></td>
                                <td>
                                    <div class="sp-actions">
                                        <a href="login-history-detail.html" class="sp-action-btn">
                                            <i class="fa fa-history"></i> History
                                        </a>
                                    </div>
                                </td>
                            </tr>

                            <!-- 6. Meera Kapoor — Offline -->
                            <tr data-status="offline" data-name="meera kapoor meera@store.com">
                                <td>
                                    <div class="sp-member-cell">
                                        <div class="sp-avatar" style="background:#916a00">
                                            MK
                                            <span class="sp-status-dot offline"></span>
                                        </div>
                                        <div>
                                            <div class="sp-member-name">Meera Kapoor</div>
                                            <div class="sp-member-email">meera@store.com</div>
                                            <span class="sp-role-tag">Support Agent</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="sp-login-time">21 Jun 2025, 11:45 AM</div>
                                    <div class="sp-login-date">2 days ago</div>
                                </td>
                                <td>
                                    <div class="sp-ip">59.95.220.18</div>
                                    <div style="font-size:11px;color:var(--sp-text-hint);margin-top:2px">IN · ACT Fibernet</div>
                                </td>
                                <td>
                                    <div class="sp-loc"><i class="fa fa-map-marker-alt"></i> Hyderabad, India</div>
                                    <div class="sp-loc-isp">Asia/Kolkata</div>
                                </td>
                                <td>
                                    <div class="sp-device-wrap">
                                        <div class="sp-device-icon"><i class="fa fa-mobile-alt"></i></div>
                                        <div>
                                            <div class="sp-device-name">Chrome 124</div>
                                            <div class="sp-device-os">Android 14</div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="sp-duration"><i class="fa fa-clock"></i> 1h 48m</span></td>
                                <td><span class="sp-count-chip">91</span></td>
                                <td><span class="sp-pill sp-pill-offline">Offline</span></td>
                                <td>
                                    <div class="sp-actions">
                                        <a href="login-history-detail.html" class="sp-action-btn">
                                            <i class="fa fa-history"></i> History
                                        </a>
                                    </div>
                                </td>
                            </tr>

                            <!-- 7. Vikram Nair — Offline -->
                            <tr data-status="offline" data-name="vikram nair vikram@store.com">
                                <td>
                                    <div class="sp-member-cell">
                                        <div class="sp-avatar" style="background:#0e7490">
                                            VN
                                            <span class="sp-status-dot offline"></span>
                                        </div>
                                        <div>
                                            <div class="sp-member-name">Vikram Nair</div>
                                            <div class="sp-member-email">vikram@store.com</div>
                                            <span class="sp-role-tag">Support Agent</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="sp-login-time">19 Jun 2025, 9:00 AM</div>
                                    <div class="sp-login-date">4 days ago</div>
                                </td>
                                <td>
                                    <div class="sp-ip">182.64.112.7</div>
                                    <div style="font-size:11px;color:var(--sp-text-hint);margin-top:2px">IN · Airtel</div>
                                </td>
                                <td>
                                    <div class="sp-loc"><i class="fa fa-map-marker-alt"></i> Chennai, India</div>
                                    <div class="sp-loc-isp">Asia/Kolkata</div>
                                </td>
                                <td>
                                    <div class="sp-device-wrap">
                                        <div class="sp-device-icon"><i class="fa fa-desktop"></i></div>
                                        <div>
                                            <div class="sp-device-name">Chrome 123</div>
                                            <div class="sp-device-os">Windows 10</div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="sp-duration"><i class="fa fa-clock"></i> 4h 10m</span></td>
                                <td><span class="sp-count-chip">74</span></td>
                                <td><span class="sp-pill sp-pill-offline">Offline</span></td>
                                <td>
                                    <div class="sp-actions">
                                        <a href="login-history-detail.html" class="sp-action-btn">
                                            <i class="fa fa-history"></i> History
                                        </a>
                                    </div>
                                </td>
                            </tr>

                            <!-- 8. Ananya Roy — Offline -->
                            <tr data-status="offline" data-name="ananya roy ananya@store.com">
                                <td>
                                    <div class="sp-member-cell">
                                        <div class="sp-avatar" style="background:#be185d">
                                            AR
                                            <span class="sp-status-dot offline"></span>
                                        </div>
                                        <div>
                                            <div class="sp-member-name">Ananya Roy</div>
                                            <div class="sp-member-email">ananya@store.com</div>
                                            <span class="sp-role-tag">Content Editor</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="sp-login-time">16 Jun 2025, 2:30 PM</div>
                                    <div class="sp-login-date">7 days ago</div>
                                </td>
                                <td>
                                    <div class="sp-ip">203.110.88.44</div>
                                    <div style="font-size:11px;color:var(--sp-text-hint);margin-top:2px">IN · BSNL</div>
                                </td>
                                <td>
                                    <div class="sp-loc"><i class="fa fa-map-marker-alt"></i> Kolkata, India</div>
                                    <div class="sp-loc-isp">Asia/Kolkata</div>
                                </td>
                                <td>
                                    <div class="sp-device-wrap">
                                        <div class="sp-device-icon"><i class="fa fa-laptop"></i></div>
                                        <div>
                                            <div class="sp-device-name">Firefox 125</div>
                                            <div class="sp-device-os">macOS Ventura</div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="sp-duration"><i class="fa fa-clock"></i> 2h 55m</span></td>
                                <td><span class="sp-count-chip">58</span></td>
                                <td><span class="sp-pill sp-pill-offline">Offline</span></td>
                                <td>
                                    <div class="sp-actions">
                                        <a href="login-history-detail.html" class="sp-action-btn">
                                            <i class="fa fa-history"></i> History
                                        </a>
                                    </div>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="sp-pagination">
                    <span>Showing 8 of 8 members</span>
                    <div class="sp-pag-btns">
                        <button class="sp-pag-btn" disabled><i class="fa fa-chevron-left"></i></button>
                        <button class="sp-pag-btn active">1</button>
                        <button class="sp-pag-btn" disabled><i class="fa fa-chevron-right"></i></button>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

@include('admin.footer')

<script>
function filterTable(val) {
    val = val.toLowerCase();
    document.querySelectorAll('#loginTable tbody tr').forEach(row => {
        row.style.display = row.dataset.name.includes(val) ? '' : 'none';
    });
}

function filterStatus(val) {
    document.querySelectorAll('#loginTable tbody tr').forEach(row => {
        row.style.display = (!val || row.dataset.status === val) ? '' : 'none';
    });
}

function blockSession(name) {
    Swal.fire({
        title: 'Block Session?',
        text: `This will immediately log out ${name} and flag the suspicious IP.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#c0392b',
        cancelButtonColor: '#6d7175',
        confirmButtonText: 'Yes, Block'
    }).then(r => {
        if (r.isConfirmed) Swal.fire('Blocked!', 'Session terminated and IP flagged.', 'success');
    });
}
</script>