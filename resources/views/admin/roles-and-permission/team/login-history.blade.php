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

    .sp-page-header { display: flex; align-items: flex-start; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 20px; }
    .sp-page-title { font-size: 20px; font-weight: 660; margin: 0 0 4px; letter-spacing: -.2px; }
    .sp-crumb { font-size: 12.5px; color: var(--sp-text-hint); display: flex; align-items: center; gap: 4px; flex-wrap: wrap; }
    .sp-crumb a { color: var(--sp-accent); text-decoration: none; }
    .sp-crumb a:hover { text-decoration: underline; }

    /* ── Member profile card ── */
    .sp-profile-card {
        background: var(--sp-surface); border: 1px solid var(--sp-border);
        border-radius: var(--sp-radius-lg); box-shadow: var(--sp-shadow-card);
        padding: 20px 24px; display: flex; align-items: center;
        justify-content: space-between; flex-wrap: wrap; gap: 16px;
        margin-bottom: 20px;
    }
    .sp-profile-left { display: flex; align-items: center; gap: 16px; }
    .sp-avatar-lg {
        width: 56px; height: 56px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 20px; font-weight: 700; color: #fff; flex-shrink: 0;
        position: relative;
    }
    .sp-online-badge {
        position: absolute; bottom: 2px; right: 2px;
        width: 12px; height: 12px; border-radius: 50%;
        background: var(--sp-green); border: 2px solid var(--sp-surface);
        animation: pulse 1.5s infinite;
    }
    @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.4} }
    .sp-profile-name { font-size: 17px; font-weight: 660; color: var(--sp-text-primary); margin-bottom: 2px; }
    .sp-profile-email { font-size: 13px; color: var(--sp-text-hint); margin-bottom: 6px; }
    .sp-role-tag { display: inline-flex; font-size: 11.5px; font-weight: 620; padding: 3px 10px; border-radius: 20px; background: var(--sp-accent-light); color: var(--sp-accent); }
    .sp-profile-stats { display: flex; gap: 24px; flex-wrap: wrap; }
    .sp-stat { text-align: center; }
    .sp-stat-value { font-size: 20px; font-weight: 750; color: var(--sp-text-primary); }
    .sp-stat-label { font-size: 11.5px; color: var(--sp-text-hint); margin-top: 2px; }

    /* ── Layout ── */
    .sp-detail-layout { display: grid; grid-template-columns: 1fr 260px; gap: 20px; align-items: start; }
    @media(max-width:960px) { .sp-detail-layout { grid-template-columns: 1fr; } }

    /* ── Cards ── */
    .sp-card { background: var(--sp-surface); border-radius: var(--sp-radius-lg); box-shadow: var(--sp-shadow-card); border: 1px solid var(--sp-border); overflow: hidden; margin-bottom: 16px; }
    .sp-card:last-child { margin-bottom: 0; }
    .sp-card-header { padding: 13px 20px; border-bottom: 1px solid var(--sp-border); background: #fafafa; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px; }
    .sp-card-header h5 { font-size: 13px; font-weight: 650; color: var(--sp-text-primary); margin: 0; }
    .sp-card-body-sm { padding: 14px 20px; }

    /* ── Toolbar ── */
    .sp-toolbar { padding: 11px 16px; border-bottom: 1px solid var(--sp-border); background: #fafafa; display: flex; align-items: center; justify-content: space-between; gap: 10px; flex-wrap: wrap; }
    .sp-select-sm { height: 32px; border: 1px solid var(--sp-border); border-radius: var(--sp-radius-md); padding: 0 28px 0 10px; font-size: 12.5px; color: var(--sp-text-primary); background: var(--sp-surface); outline: none; font-family: var(--sp-font); appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%238c9196'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 9px center; }

    /* ── History timeline table ── */
    .sp-table { width: 100%; border-collapse: collapse; font-size: 13.5px; font-family: var(--sp-font); }
    .sp-table thead th { padding: 10px 16px; background: #fafafa; border-bottom: 1px solid var(--sp-border); font-size: 11px; font-weight: 650; letter-spacing: .055em; text-transform: uppercase; color: var(--sp-text-hint); text-align: left; white-space: nowrap; }
    .sp-table tbody tr { border-bottom: 1px solid var(--sp-border); transition: background .1s; }
    .sp-table tbody tr:last-child { border-bottom: none; }
    .sp-table tbody tr:hover { background: #f7f8f9; }
    .sp-table td { padding: 12px 16px; vertical-align: middle; }

    /* row number */
    .sp-row-num { display: inline-flex; align-items: center; justify-content: center; min-width: 24px; height: 22px; padding: 0 6px; background: var(--sp-bg); border: 1px solid var(--sp-border); border-radius: 5px; font-size: 11.5px; font-weight: 600; color: var(--sp-text-secondary); }

    /* ── Session status pills ── */
    .sp-pill { display: inline-flex; align-items: center; gap: 5px; font-size: 11.5px; font-weight: 620; padding: 3px 9px; border-radius: 20px; white-space: nowrap; }
    .sp-pill::before { content:''; width:5px; height:5px; border-radius:50%; display:inline-block; flex-shrink:0; }
    .sp-pill-success { background: var(--sp-green-bg); color: var(--sp-green); }
    .sp-pill-success::before { background: var(--sp-green); }
    .sp-pill-logout  { background: #f3f4f6; color: var(--sp-text-hint); }
    .sp-pill-logout::before { background: var(--sp-text-hint); }
    .sp-pill-suspicious { background: var(--sp-amber-bg); color: var(--sp-amber); border: 1px solid var(--sp-amber-border); }
    .sp-pill-suspicious::before { background: var(--sp-amber); }
    .sp-pill-failed  { background: var(--sp-red-bg); color: var(--sp-red); }
    .sp-pill-failed::before  { background: var(--sp-red); }

    /* ── IP cell ── */
    .sp-ip { font-family: 'SF Mono','Fira Code',monospace; font-size: 12.5px; color: var(--sp-text-secondary); }
    .sp-ip.warn { color: var(--sp-amber); }

    /* ── Location ── */
    .sp-location { display: flex; align-items: center; gap: 5px; font-size: 13px; }
    .sp-location i { color: var(--sp-text-hint); font-size: 11px; }
    .sp-location.warn { color: var(--sp-amber); }

    /* ── Device cell ── */
    .sp-device { display: flex; align-items: center; gap: 7px; }
    .sp-device-icon { width: 26px; height: 26px; border-radius: var(--sp-radius-sm); background: var(--sp-bg); border: 1px solid var(--sp-border); display: flex; align-items: center; justify-content: center; font-size: 12px; color: var(--sp-text-secondary); flex-shrink: 0; }

    /* ── Duration chip ── */
    .sp-duration { display: inline-flex; align-items: center; gap: 4px; font-size: 12px; color: var(--sp-text-secondary); background: var(--sp-bg); border: 1px solid var(--sp-border); padding: 2px 8px; border-radius: 5px; font-weight: 560; }

    /* ── Warning row ── */
    .sp-warn-row { background: #fffbf0 !important; }

    /* ── Suspicious alert box ── */
    .sp-alert-box { display: flex; align-items: flex-start; gap: 12px; background: var(--sp-amber-bg); border: 1px solid var(--sp-amber-border); border-radius: var(--sp-radius-md); padding: 14px 16px; margin-bottom: 20px; font-size: 13px; color: var(--sp-amber); }
    .sp-alert-box i { font-size: 16px; flex-shrink: 0; margin-top: 1px; }
    .sp-alert-box strong { display: block; font-weight: 650; margin-bottom: 3px; }

    /* ── Sidebar info rows ── */
    .sp-info-row { display: flex; justify-content: space-between; align-items: flex-start; padding: 9px 0; border-bottom: 1px solid var(--sp-bg); font-size: 13px; gap: 8px; }
    .sp-info-row:first-child { padding-top: 0; }
    .sp-info-row:last-child { border-bottom: none; padding-bottom: 0; }
    .sp-info-label { color: var(--sp-text-hint); font-size: 11.5px; font-weight: 620; text-transform: uppercase; letter-spacing: .03em; flex-shrink: 0; }
    .sp-info-value { font-weight: 560; color: var(--sp-text-primary); text-align: right; }

    /* ── Device breakdown ── */
    .sp-device-row { display: flex; align-items: center; gap: 10px; padding: 8px 0; border-bottom: 1px solid var(--sp-bg); }
    .sp-device-row:last-child { border-bottom: none; }
    .sp-device-bar-wrap { flex: 1; }
    .sp-device-bar-label { display: flex; justify-content: space-between; font-size: 12px; color: var(--sp-text-secondary); margin-bottom: 4px; }
    .sp-device-bar-bg { background: var(--sp-bg); border-radius: 20px; height: 5px; overflow: hidden; }
    .sp-device-bar-fill { height: 100%; border-radius: 20px; }

    /* ── Pagination ── */
    .sp-pagination { padding: 13px 20px; border-top: 1px solid var(--sp-border); display: flex; align-items: center; justify-content: space-between; background: var(--sp-surface); font-size: 12.5px; color: var(--sp-text-hint); }
    .sp-pag-btns { display: flex; gap: 4px; }
    .sp-pag-btn { display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border: 1px solid var(--sp-border); border-radius: var(--sp-radius-sm); background: var(--sp-surface); color: var(--sp-text-secondary); font-size: 12.5px; cursor: pointer; transition: all .12s; font-family: var(--sp-font); }
    .sp-pag-btn:hover { background: var(--sp-bg); }
    .sp-pag-btn.active { background: var(--sp-accent); border-color: var(--sp-accent); color: #fff; }

    .sp-btn-secondary { display: inline-flex; align-items: center; gap: 6px; background: var(--sp-surface); color: var(--sp-text-primary); border: 1px solid var(--sp-border); border-radius: var(--sp-radius-md); padding: 7px 14px; font-size: 13px; font-weight: 540; font-family: var(--sp-font); cursor: pointer; text-decoration: none; line-height: 1.4; transition: all .15s; white-space: nowrap; }
    .sp-btn-secondary:hover { background: var(--sp-bg); border-color: var(--sp-border-hover); }

    @media(max-width:768px) { .sp-page { padding: 16px; } }
    </style>

    <div class="app-content content container-fluid">
        <div class="sp-page">

            <!-- Page header -->
            <div class="sp-page-header">
                <div>
                    <h1 class="sp-page-title">Login History — Arjun Sharma</h1>
                    <div class="sp-crumb">
                        <a href="#">Dashboard</a>
                        <span style="color:var(--sp-border-hover)">›</span>
                        <a href="#">Roles & Settings</a>
                        <span style="color:var(--sp-border-hover)">›</span>
                        <a href="login-history-index.html">Login History</a>
                        <span style="color:var(--sp-border-hover)">›</span>
                        <span>Arjun Sharma</span>
                    </div>
                </div>
                <div style="display:flex;gap:8px">
                    <a href="login-history-index.html" class="sp-btn-secondary">
                        <i class="fa fa-arrow-left"></i> Back
                    </a>
                    <button class="sp-btn-secondary">
                        <i class="fa fa-download"></i> Export
                    </button>
                </div>
            </div>

            <!-- Member profile card -->
            <div class="sp-profile-card">
                <div class="sp-profile-left">
                    <div class="sp-avatar-lg" style="background:#303d89">
                        AS
                        <span class="sp-online-badge"></span>
                    </div>
                    <div>
                        <div class="sp-profile-name">Arjun Sharma</div>
                        <div class="sp-profile-email">arjun@store.com</div>
                        <span class="sp-role-tag">Super Admin</span>
                    </div>
                </div>
                <div class="sp-profile-stats">
                    <div class="sp-stat">
                        <div class="sp-stat-value">412</div>
                        <div class="sp-stat-label">Total Logins</div>
                    </div>
                    <div class="sp-stat">
                        <div class="sp-stat-value" style="color:var(--sp-green)">3</div>
                        <div class="sp-stat-label">This Week</div>
                    </div>
                    <div class="sp-stat">
                        <div class="sp-stat-value" style="color:var(--sp-amber)">1</div>
                        <div class="sp-stat-label">Suspicious</div>
                    </div>
                    <div class="sp-stat">
                        <div class="sp-stat-value" style="color:var(--sp-red)">2</div>
                        <div class="sp-stat-label">Failed</div>
                    </div>
                </div>
            </div>

            <!-- Suspicious alert -->
            <div class="sp-alert-box">
                <i class="fa fa-exclamation-triangle"></i>
                <div>
                    <strong>Suspicious Login Detected</strong>
                    A login from Frankfurt, Germany (IP: 185.220.101.8) was detected on 18 Jun 2025 at 3:42 AM — outside the member's usual location (New Delhi, India). Please review and take action if needed.
                </div>
            </div>

            <div class="sp-detail-layout">

                <!-- LEFT — history table -->
                <div>
                    <div class="sp-card">
                        <div class="sp-card-header">
                            <h5>Full Login History</h5>
                            <div style="display:flex;gap:8px">
                                <select class="sp-select-sm">
                                    <option>All Status</option>
                                    <option>Success</option>
                                    <option>Failed</option>
                                    <option>Suspicious</option>
                                </select>
                                <select class="sp-select-sm">
                                    <option>Last 30 Days</option>
                                    <option>Last 7 Days</option>
                                    <option>Last 3 Months</option>
                                    <option>All Time</option>
                                </select>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="sp-table">
                                <thead>
                                    <tr>
                                        <th style="width:40px">#</th>
                                        <th>Date & Time</th>
                                        <th>IP Address</th>
                                        <th>Location</th>
                                        <th>Device</th>
                                        <th>Browser / OS</th>
                                        <th>Duration</th>
                                        <th style="width:120px">Status</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <td><span class="sp-row-num">1</span></td>
                                        <td>
                                            <div style="font-weight:560">23 Jun 2025</div>
                                            <div style="font-size:11.5px;color:var(--sp-text-hint)">9:14 AM</div>
                                        </td>
                                        <td><span class="sp-ip">103.21.58.9</span></td>
                                        <td>
                                            <div class="sp-location"><i class="fa fa-map-marker-alt"></i> New Delhi, India</div>
                                            <div style="font-size:11px;color:var(--sp-text-hint);margin-top:2px">IN · Airtel</div>
                                        </td>
                                        <td><div class="sp-device"><div class="sp-device-icon"><i class="fa fa-desktop"></i></div><span style="font-size:13px">Desktop</span></div></td>
                                        <td>
                                            <div style="font-size:13px">Chrome 124</div>
                                            <div style="font-size:11.5px;color:var(--sp-text-hint)">Windows 11</div>
                                        </td>
                                        <td><span class="sp-duration"><i class="fa fa-clock"></i> Active</span></td>
                                        <td><span class="sp-pill sp-pill-success">Success</span></td>
                                    </tr>

                                    <tr>
                                        <td><span class="sp-row-num">2</span></td>
                                        <td>
                                            <div style="font-weight:560">22 Jun 2025</div>
                                            <div style="font-size:11.5px;color:var(--sp-text-hint)">11:30 AM</div>
                                        </td>
                                        <td><span class="sp-ip">103.21.58.9</span></td>
                                        <td>
                                            <div class="sp-location"><i class="fa fa-map-marker-alt"></i> New Delhi, India</div>
                                            <div style="font-size:11px;color:var(--sp-text-hint);margin-top:2px">IN · Airtel</div>
                                        </td>
                                        <td><div class="sp-device"><div class="sp-device-icon"><i class="fa fa-desktop"></i></div><span style="font-size:13px">Desktop</span></div></td>
                                        <td>
                                            <div style="font-size:13px">Chrome 124</div>
                                            <div style="font-size:11.5px;color:var(--sp-text-hint)">Windows 11</div>
                                        </td>
                                        <td><span class="sp-duration"><i class="fa fa-clock"></i> 6h 48m</span></td>
                                        <td><span class="sp-pill sp-pill-logout">Logged Out</span></td>
                                    </tr>

                                    <tr>
                                        <td><span class="sp-row-num">3</span></td>
                                        <td>
                                            <div style="font-weight:560">20 Jun 2025</div>
                                            <div style="font-size:11.5px;color:var(--sp-text-hint)">9:05 AM</div>
                                        </td>
                                        <td><span class="sp-ip">103.21.58.9</span></td>
                                        <td>
                                            <div class="sp-location"><i class="fa fa-map-marker-alt"></i> New Delhi, India</div>
                                            <div style="font-size:11px;color:var(--sp-text-hint);margin-top:2px">IN · Airtel</div>
                                        </td>
                                        <td><div class="sp-device"><div class="sp-device-icon"><i class="fa fa-mobile-alt"></i></div><span style="font-size:13px">Mobile</span></div></td>
                                        <td>
                                            <div style="font-size:13px">Safari 17</div>
                                            <div style="font-size:11.5px;color:var(--sp-text-hint)">iPhone iOS 17.4</div>
                                        </td>
                                        <td><span class="sp-duration"><i class="fa fa-clock"></i> 2h 12m</span></td>
                                        <td><span class="sp-pill sp-pill-logout">Logged Out</span></td>
                                    </tr>

                                    <!-- Suspicious row -->
                                    <tr class="sp-warn-row">
                                        <td><span class="sp-row-num">4</span></td>
                                        <td>
                                            <div style="font-weight:560;color:var(--sp-amber)">18 Jun 2025</div>
                                            <div style="font-size:11.5px;color:var(--sp-amber)">3:42 AM <i class="fa fa-exclamation-triangle" style="font-size:10px;margin-left:2px"></i></div>
                                        </td>
                                        <td>
                                            <span class="sp-ip warn">185.220.101.8</span>
                                            <div style="font-size:11px;color:var(--sp-amber);margin-top:2px">New IP detected</div>
                                        </td>
                                        <td>
                                            <div class="sp-location warn"><i class="fa fa-map-marker-alt"></i> Frankfurt, Germany</div>
                                            <div style="font-size:11px;color:var(--sp-amber);margin-top:2px">DE · Hetzner Online GmbH</div>
                                        </td>
                                        <td><div class="sp-device"><div class="sp-device-icon"><i class="fa fa-desktop"></i></div><span style="font-size:13px">Desktop</span></div></td>
                                        <td>
                                            <div style="font-size:13px">Firefox 126</div>
                                            <div style="font-size:11.5px;color:var(--sp-text-hint)">Ubuntu Linux</div>
                                        </td>
                                        <td><span class="sp-duration"><i class="fa fa-clock"></i> 14m</span></td>
                                        <td><span class="sp-pill sp-pill-suspicious">Suspicious</span></td>
                                    </tr>

                                    <tr>
                                        <td><span class="sp-row-num">5</span></td>
                                        <td>
                                            <div style="font-weight:560">17 Jun 2025</div>
                                            <div style="font-size:11.5px;color:var(--sp-text-hint)">9:00 AM</div>
                                        </td>
                                        <td><span class="sp-ip">103.21.58.9</span></td>
                                        <td>
                                            <div class="sp-location"><i class="fa fa-map-marker-alt"></i> New Delhi, India</div>
                                            <div style="font-size:11px;color:var(--sp-text-hint);margin-top:2px">IN · Airtel</div>
                                        </td>
                                        <td><div class="sp-device"><div class="sp-device-icon"><i class="fa fa-desktop"></i></div><span style="font-size:13px">Desktop</span></div></td>
                                        <td>
                                            <div style="font-size:13px">Chrome 124</div>
                                            <div style="font-size:11.5px;color:var(--sp-text-hint)">Windows 11</div>
                                        </td>
                                        <td><span class="sp-duration"><i class="fa fa-clock"></i> 7h 02m</span></td>
                                        <td><span class="sp-pill sp-pill-logout">Logged Out</span></td>
                                    </tr>

                                    <!-- Failed login -->
                                    <tr>
                                        <td><span class="sp-row-num">6</span></td>
                                        <td>
                                            <div style="font-weight:560">15 Jun 2025</div>
                                            <div style="font-size:11.5px;color:var(--sp-text-hint)">8:55 AM</div>
                                        </td>
                                        <td><span class="sp-ip">103.21.58.9</span></td>
                                        <td>
                                            <div class="sp-location"><i class="fa fa-map-marker-alt"></i> New Delhi, India</div>
                                            <div style="font-size:11px;color:var(--sp-text-hint);margin-top:2px">IN · Airtel</div>
                                        </td>
                                        <td><div class="sp-device"><div class="sp-device-icon"><i class="fa fa-desktop"></i></div><span style="font-size:13px">Desktop</span></div></td>
                                        <td>
                                            <div style="font-size:13px">Chrome 124</div>
                                            <div style="font-size:11.5px;color:var(--sp-text-hint)">Windows 11</div>
                                        </td>
                                        <td><span class="sp-duration">—</span></td>
                                        <td><span class="sp-pill sp-pill-failed">Failed</span></td>
                                    </tr>

                                    <tr>
                                        <td><span class="sp-row-num">7</span></td>
                                        <td>
                                            <div style="font-weight:560">13 Jun 2025</div>
                                            <div style="font-size:11.5px;color:var(--sp-text-hint)">10:18 AM</div>
                                        </td>
                                        <td><span class="sp-ip">103.21.58.9</span></td>
                                        <td>
                                            <div class="sp-location"><i class="fa fa-map-marker-alt"></i> New Delhi, India</div>
                                            <div style="font-size:11px;color:var(--sp-text-hint);margin-top:2px">IN · Airtel</div>
                                        </td>
                                        <td><div class="sp-device"><div class="sp-device-icon"><i class="fa fa-laptop"></i></div><span style="font-size:13px">Laptop</span></div></td>
                                        <td>
                                            <div style="font-size:13px">Chrome 123</div>
                                            <div style="font-size:11.5px;color:var(--sp-text-hint)">macOS Sonoma</div>
                                        </td>
                                        <td><span class="sp-duration"><i class="fa fa-clock"></i> 4h 30m</span></td>
                                        <td><span class="sp-pill sp-pill-logout">Logged Out</span></td>
                                    </tr>

                                    <tr>
                                        <td><span class="sp-row-num">8</span></td>
                                        <td>
                                            <div style="font-weight:560">10 Jun 2025</div>
                                            <div style="font-size:11.5px;color:var(--sp-text-hint)">9:02 AM</div>
                                        </td>
                                        <td><span class="sp-ip">103.21.58.9</span></td>
                                        <td>
                                            <div class="sp-location"><i class="fa fa-map-marker-alt"></i> New Delhi, India</div>
                                            <div style="font-size:11px;color:var(--sp-text-hint);margin-top:2px">IN · Airtel</div>
                                        </td>
                                        <td><div class="sp-device"><div class="sp-device-icon"><i class="fa fa-desktop"></i></div><span style="font-size:13px">Desktop</span></div></td>
                                        <td>
                                            <div style="font-size:13px">Chrome 123</div>
                                            <div style="font-size:11.5px;color:var(--sp-text-hint)">Windows 11</div>
                                        </td>
                                        <td><span class="sp-duration"><i class="fa fa-clock"></i> 8h 11m</span></td>
                                        <td><span class="sp-pill sp-pill-logout">Logged Out</span></td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="sp-pagination">
                            <span>Showing 8 of 412 records</span>
                            <div class="sp-pag-btns">
                                <button class="sp-pag-btn" disabled><i class="fa fa-chevron-left"></i></button>
                                <button class="sp-pag-btn active">1</button>
                                <button class="sp-pag-btn">2</button>
                                <button class="sp-pag-btn">3</button>
                                <span style="padding:0 6px;color:var(--sp-text-hint)">…</span>
                                <button class="sp-pag-btn">52</button>
                                <button class="sp-pag-btn"><i class="fa fa-chevron-right"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RIGHT — sidebar -->
                <div>

                    <!-- Last login summary -->
                    <div class="sp-card">
                        <div class="sp-card-header"><h5>Last Login</h5></div>
                        <div class="sp-card-body-sm">
                            <div class="sp-info-row">
                                <span class="sp-info-label">Date & Time</span>
                                <span class="sp-info-value">23 Jun 2025, 9:14 AM</span>
                            </div>
                            <div class="sp-info-row">
                                <span class="sp-info-label">IP Address</span>
                                <span class="sp-info-value" style="font-family:'SF Mono',monospace;font-size:12px">103.21.58.9</span>
                            </div>
                            <div class="sp-info-row">
                                <span class="sp-info-label">Location</span>
                                <span class="sp-info-value">New Delhi, India</span>
                            </div>
                            <div class="sp-info-row">
                                <span class="sp-info-label">Device</span>
                                <span class="sp-info-value">Desktop</span>
                            </div>
                            <div class="sp-info-row">
                                <span class="sp-info-label">Browser</span>
                                <span class="sp-info-value">Chrome 124</span>
                            </div>
                            <div class="sp-info-row">
                                <span class="sp-info-label">OS</span>
                                <span class="sp-info-value">Windows 11</span>
                            </div>
                            <div class="sp-info-row">
                                <span class="sp-info-label">ISP</span>
                                <span class="sp-info-value">Airtel India</span>
                            </div>
                            <div class="sp-info-row">
                                <span class="sp-info-label">Status</span>
                                <span class="sp-pill sp-pill-success" style="font-size:11px;padding:2px 7px">Success</span>
                            </div>
                        </div>
                    </div>

                    <!-- Device breakdown -->
                    <div class="sp-card">
                        <div class="sp-card-header"><h5>Device Breakdown</h5></div>
                        <div class="sp-card-body-sm">
                            <div class="sp-device-row">
                                <div class="sp-device-icon"><i class="fa fa-desktop"></i></div>
                                <div class="sp-device-bar-wrap">
                                    <div class="sp-device-bar-label"><span>Desktop</span><span style="font-weight:650;color:var(--sp-text-primary)">62%</span></div>
                                    <div class="sp-device-bar-bg"><div class="sp-device-bar-fill" style="width:62%;background:var(--sp-accent)"></div></div>
                                </div>
                            </div>
                            <div class="sp-device-row">
                                <div class="sp-device-icon"><i class="fa fa-mobile-alt"></i></div>
                                <div class="sp-device-bar-wrap">
                                    <div class="sp-device-bar-label"><span>Mobile</span><span style="font-weight:650;color:var(--sp-text-primary)">28%</span></div>
                                    <div class="sp-device-bar-bg"><div class="sp-device-bar-fill" style="width:28%;background:var(--sp-green)"></div></div>
                                </div>
                            </div>
                            <div class="sp-device-row">
                                <div class="sp-device-icon"><i class="fa fa-laptop"></i></div>
                                <div class="sp-device-bar-wrap">
                                    <div class="sp-device-bar-label"><span>Laptop</span><span style="font-weight:650;color:var(--sp-text-primary)">10%</span></div>
                                    <div class="sp-device-bar-bg"><div class="sp-device-bar-fill" style="width:10%;background:#0069d9"></div></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Security summary -->
                    <div class="sp-card">
                        <div class="sp-card-header"><h5>Security Summary</h5></div>
                        <div class="sp-card-body-sm">
                            <div class="sp-info-row">
                                <span class="sp-info-label">Total Logins</span>
                                <span class="sp-info-value">412</span>
                            </div>
                            <div class="sp-info-row">
                                <span class="sp-info-label">Successful</span>
                                <span class="sp-info-value" style="color:var(--sp-green)">409</span>
                            </div>
                            <div class="sp-info-row">
                                <span class="sp-info-label">Failed</span>
                                <span class="sp-info-value" style="color:var(--sp-red)">2</span>
                            </div>
                            <div class="sp-info-row">
                                <span class="sp-info-label">Suspicious</span>
                                <span class="sp-info-value" style="color:var(--sp-amber)">1</span>
                            </div>
                            <div class="sp-info-row">
                                <span class="sp-info-label">Unique IPs</span>
                                <span class="sp-info-value">3</span>
                            </div>
                            <div class="sp-info-row">
                                <span class="sp-info-label">Avg. Session</span>
                                <span class="sp-info-value">5h 14m</span>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
</div>

@include('admin.footer')