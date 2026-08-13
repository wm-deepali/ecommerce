@include('admin.top-header')
<div class="main-section">
    @include('admin.header')

    <style>
    :root {
        --sp-bg: #f1f2f4; --sp-surface: #ffffff; --sp-border: #e3e5e8; --sp-border-hover: #c9cccf;
        --sp-text-primary: #202223; --sp-text-secondary: #6d7175; --sp-text-hint: #8c9196;
        --sp-accent: #303d89; --sp-accent-hover: #2a3579; --sp-accent-light: #eef0fc;
        --sp-green: #007a5e; --sp-green-bg: #e3f1ec; --sp-green-border: #9fcfc3;
        --sp-red: #c0392b; --sp-red-bg: #fce8e8;
        --sp-amber: #916a00; --sp-amber-bg: #fff5cc; --sp-amber-border: #e8d080;
        --sp-blue: #0069d9; --sp-blue-bg: #e8f2ff; --sp-blue-border: #a8cdf5;
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
    .sp-crumb-sep { color: var(--sp-border-hover); }

    /* ── Role identity chip (edit-only) ── */
    .sp-role-chip {
        display: flex; align-items: center; gap: 10px;
        background: var(--sp-surface); border: 1px solid var(--sp-border);
        border-radius: var(--sp-radius-lg); padding: 10px 16px;
        box-shadow: var(--sp-shadow-card); flex-shrink: 0;
    }
    .sp-role-chip-icon { width: 36px; height: 36px; border-radius: var(--sp-radius-md); background: var(--sp-accent-light); color: var(--sp-accent); display: flex; align-items: center; justify-content: center; font-size: 15px; flex-shrink: 0; }
    .sp-role-chip-name { font-size: 13.5px; font-weight: 660; color: var(--sp-text-primary); }
    .sp-role-chip-sub  { font-size: 11.5px; color: var(--sp-text-hint); margin-top: 1px; }
    .sp-role-pill { display: inline-flex; align-items: center; gap: 4px; font-size: 11px; font-weight: 650; padding: 2px 8px; border-radius: 20px; background: var(--sp-green-bg); color: var(--sp-green); border: 1px solid var(--sp-green-border); margin-top: 4px; }

    /* ── Layout ── */
    .sp-perm-layout { display: grid; grid-template-columns: 1fr 240px; gap: 20px; align-items: start; }
    @media (max-width: 960px) { .sp-perm-layout { grid-template-columns: 1fr; } }

    /* ── Cards ── */
    .sp-card { background: var(--sp-surface); border-radius: var(--sp-radius-lg); box-shadow: var(--sp-shadow-card); border: 1px solid var(--sp-border); overflow: hidden; margin-bottom: 16px; }
    .sp-card:last-child { margin-bottom: 0; }
    .sp-card-header { padding: 13px 20px; border-bottom: 1px solid var(--sp-border); background: #fafafa; display: flex; align-items: center; justify-content: space-between; gap: 10px; }
    .sp-card-header h5 { font-size: 13px; font-weight: 650; color: var(--sp-text-primary); margin: 0; }
    .sp-card-body { padding: 20px 24px; }
    .sp-card-body-sm { padding: 14px 20px; }

    /* ── Role info row (read-only, inside card) ── */
    .sp-role-info-bar {
        display: flex; align-items: center; justify-content: space-between;
        gap: 12px; flex-wrap: wrap;
        background: var(--sp-accent-light); border: 1px solid var(--sp-accent);
        border-radius: var(--sp-radius-md); padding: 12px 16px; margin-bottom: 0;
    }
    .sp-role-info-left { display: flex; align-items: center; gap: 10px; }
    .sp-role-info-icon { width: 34px; height: 34px; background: var(--sp-accent); color: #fff; border-radius: var(--sp-radius-md); display: flex; align-items: center; justify-content: center; font-size: 14px; flex-shrink: 0; }
    .sp-role-info-name { font-size: 13.5px; font-weight: 660; color: var(--sp-accent); }
    .sp-role-info-id   { font-size: 11.5px; color: var(--sp-accent); opacity: .7; margin-top: 1px; }
    .sp-role-info-badge { font-size: 11px; font-weight: 650; padding: 3px 10px; border-radius: 20px; background: var(--sp-accent); color: #fff; white-space: nowrap; }

    /* ── Permission matrix ── */
    .sp-matrix-table { width: 100%; border-collapse: collapse; }
    .sp-matrix-table thead th {
        font-size: 11px; font-weight: 650; letter-spacing: .05em; text-transform: uppercase;
        color: var(--sp-text-hint); padding: 8px 12px; border-bottom: 1px solid var(--sp-border);
        background: #fafafa; text-align: center;
    }
    .sp-matrix-table thead th:first-child { text-align: left; width: 38%; }
    .sp-matrix-table tbody tr { border-bottom: 1px solid var(--sp-border); transition: background .1s; }
    .sp-matrix-table tbody tr:last-child { border-bottom: none; }
    .sp-matrix-table tbody tr:hover { background: #f7f8f9; }
    .sp-matrix-table td { padding: 10px 12px; vertical-align: middle; text-align: center; }
    .sp-matrix-table td:first-child { text-align: left; font-size: 13.5px; color: var(--sp-text-primary); font-weight: 500; }

    /* Custom checkbox */
    .sp-check-wrap { display: inline-flex; align-items: center; justify-content: center; }
    .sp-check-wrap input[type=checkbox] { display: none; }
    .sp-check-wrap label { width: 20px; height: 20px; border: 2px solid var(--sp-border); border-radius: 5px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all .15s; background: var(--sp-surface); position: relative; }
    .sp-check-wrap label::after { content: ''; display: none; width: 5px; height: 9px; border: 2px solid #fff; border-top: none; border-left: none; transform: rotate(45deg) translateY(-1px); }
    .sp-check-wrap input:checked + label { background: var(--sp-accent); border-color: var(--sp-accent); }
    .sp-check-wrap input:checked + label::after { display: block; }
    .sp-check-wrap.view   input:checked + label { background: var(--sp-blue);   border-color: var(--sp-blue); }
    .sp-check-wrap.create input:checked + label { background: var(--sp-green);  border-color: var(--sp-green); }
    .sp-check-wrap.edit   input:checked + label { background: var(--sp-amber);  border-color: var(--sp-amber); }
    .sp-check-wrap.delete input:checked + label { background: var(--sp-red);    border-color: var(--sp-red); }

    /* Section header row */
    .sp-select-all-row td { background: #f5f6fe; font-size: 12px; font-weight: 650; color: var(--sp-accent); padding: 7px 12px; border-bottom: 1px solid var(--sp-border); }
    .sp-sec-btn { margin-left: 10px; font-size: 11px; color: var(--sp-accent); background: none; border: none; cursor: pointer; font-weight: 650; font-family: var(--sp-font); }
    .sp-sec-btn:hover { text-decoration: underline; }

    /* Changes indicator */
    .sp-changed-badge { display: none; font-size: 10.5px; font-weight: 700; padding: 2px 7px; border-radius: 20px; background: var(--sp-amber-bg); color: var(--sp-amber); border: 1px solid var(--sp-amber-border); margin-left: 8px; }
    .sp-changed-badge.visible { display: inline-flex; align-items: center; gap: 3px; }

    /* ── Settings sidebar ── */
    .sp-toggle-row { display: flex; align-items: center; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid var(--sp-bg); }
    .sp-toggle-row:first-child { padding-top: 0; }
    .sp-toggle-row:last-child  { border-bottom: none; padding-bottom: 0; }
    .sp-toggle-label { font-size: 13px; font-weight: 500; color: var(--sp-text-primary); }
    .sp-toggle-sub   { font-size: 11.5px; color: var(--sp-text-hint); margin-top: 1px; }
    .sp-switch { position: relative; width: 38px; height: 22px; flex-shrink: 0; }
    .sp-switch input { opacity: 0; width: 0; height: 0; position: absolute; }
    .sp-switch-track { position: absolute; inset: 0; background: var(--sp-border); border-radius: 22px; cursor: pointer; transition: background .2s; }
    .sp-switch-track::after { content: ''; position: absolute; left: 3px; top: 3px; width: 16px; height: 16px; background: #fff; border-radius: 50%; transition: transform .2s; box-shadow: 0 1px 3px rgba(0,0,0,.2); }
    .sp-switch input:checked + .sp-switch-track { background: var(--sp-accent); }
    .sp-switch input:checked + .sp-switch-track::after { transform: translateX(16px); }

    /* ── Info rows (sidebar) ── */
    .sp-info-row { display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px solid var(--sp-bg); font-size: 12.5px; }
    .sp-info-row:first-child { padding-top: 0; }
    .sp-info-row:last-child  { border-bottom: none; padding-bottom: 0; }
    .sp-info-label { color: var(--sp-text-hint); font-size: 11.5px; font-weight: 600; text-transform: uppercase; letter-spacing: .04em; }
    .sp-info-value { font-weight: 600; color: var(--sp-text-primary); font-size: 12.5px; }

    /* ── Legend ── */
    .sp-legend { display: flex; flex-wrap: wrap; gap: 10px; }
    .sp-legend-item { display: flex; align-items: center; gap: 6px; font-size: 12px; color: var(--sp-text-secondary); }
    .sp-legend-dot { width: 10px; height: 10px; border-radius: 3px; flex-shrink: 0; }

    /* ── Action bar ── */
    .sp-action-bar { background: var(--sp-surface); border: 1px solid var(--sp-border); border-radius: var(--sp-radius-lg); box-shadow: var(--sp-shadow-card); padding: 14px 20px; display: flex; align-items: center; justify-content: space-between; gap: 10px; margin-top: 20px; }
    .sp-action-bar-left { font-size: 12.5px; color: var(--sp-text-hint); display: flex; align-items: center; gap: 6px; }
    .sp-action-bar-right { display: flex; align-items: center; gap: 10px; }
    .sp-btn-primary { display: inline-flex; align-items: center; gap: 6px; background: var(--sp-accent); color: #fff; border: 1px solid transparent; border-radius: var(--sp-radius-md); padding: 8px 16px; font-size: 13.5px; font-weight: 580; font-family: var(--sp-font); cursor: pointer; text-decoration: none; line-height: 1.4; transition: background .15s; white-space: nowrap; }
    .sp-btn-primary:hover { background: var(--sp-accent-hover); color: #fff; text-decoration: none; }
    .sp-btn-secondary { display: inline-flex; align-items: center; gap: 6px; background: var(--sp-surface); color: var(--sp-text-primary); border: 1px solid var(--sp-border); border-radius: var(--sp-radius-md); padding: 8px 16px; font-size: 13.5px; font-weight: 540; font-family: var(--sp-font); cursor: pointer; text-decoration: none; line-height: 1.4; transition: all .15s; white-space: nowrap; }
    .sp-btn-secondary:hover { background: var(--sp-bg); border-color: var(--sp-border-hover); color: var(--sp-text-primary); text-decoration: none; }
    .sp-btn-reset { display: inline-flex; align-items: center; gap: 6px; background: var(--sp-amber-bg); color: var(--sp-amber); border: 1px solid var(--sp-amber-border); border-radius: var(--sp-radius-md); padding: 8px 14px; font-size: 13px; font-weight: 580; font-family: var(--sp-font); cursor: pointer; line-height: 1.4; transition: all .15s; white-space: nowrap; }
    .sp-btn-reset:hover { background: #fff0b3; }

    @media (max-width: 768px) { .sp-page { padding: 16px; } }
    </style>

    <div class="app-content content container-fluid">
        <div class="sp-page">

            <!-- Page header -->
            <div class="sp-page-header">
                <div>
                    <h1 class="sp-page-title">
                        Edit Role Permissions
                        <span class="sp-changed-badge" id="changedBadge"><i class="fa fa-circle" style="font-size:7px"></i> Unsaved changes</span>
                    </h1>
                    <div class="sp-crumb">
                        <a href="#">Dashboard</a>
                        <span class="sp-crumb-sep">›</span>
                        <a href="#">Roles & Settings</a>
                        <span class="sp-crumb-sep">›</span>
                        <a href="#">Role Permissions</a>
                        <span class="sp-crumb-sep">›</span>
                        <span>Edit — Manager</span>
                    </div>
                </div>
                <!-- Role identity chip -->
                <div class="sp-role-chip">
                    <div class="sp-role-chip-icon"><i class="fa fa-shield"></i></div>
                    <div>
                        <div class="sp-role-chip-name">Manager</div>
                        <div class="sp-role-chip-sub">Role Category ID #2</div>
                        <div class="sp-role-pill"><i class="fa fa-circle" style="font-size:6px"></i> Active</div>
                    </div>
                </div>
            </div>

            <div class="sp-perm-layout">

                <!-- ══ LEFT — permission matrix ══ -->
                <div>

                    <!-- Role info bar (read-only) -->
                    <div class="sp-card">
                        <div class="sp-card-header"><h5>Role Category</h5></div>
                        <div class="sp-card-body">
                            <div class="sp-role-info-bar">
                                <div class="sp-role-info-left">
                                    <div class="sp-role-info-icon"><i class="fa fa-shield"></i></div>
                                    <div>
                                        <div class="sp-role-info-name">Manager</div>
                                        <div class="sp-role-info-id">ID #2 &nbsp;·&nbsp; 4 team members assigned</div>
                                    </div>
                                </div>
                                <span class="sp-role-info-badge"><i class="fa fa-lock" style="margin-right:4px"></i> Editing permissions for this role</span>
                            </div>
                        </div>
                    </div>

                    <!-- Permission Matrix -->
                    <div class="sp-card">
                        <div class="sp-card-header">
                            <h5>Module Permissions</h5>
                            <div style="display:flex;align-items:center;gap:10px">
                                <span style="font-size:11.5px;color:var(--sp-text-hint)">
                                    <span id="selectedCount">24</span> / 38 selected
                                </span>
                                <button type="button" onclick="selectAll()" style="font-size:12px;color:var(--sp-accent);background:none;border:none;cursor:pointer;font-weight:600;font-family:var(--sp-font)">
                                    <i class="fa fa-check-square"></i> Select All
                                </button>
                            </div>
                        </div>
                        <div class="sp-card-body">

                            <table class="sp-matrix-table">
                                <thead>
                                    <tr>
                                        <th>Module</th>
                                        <th style="color:var(--sp-blue)">View</th>
                                        <th style="color:var(--sp-green)">Create</th>
                                        <th style="color:var(--sp-amber)">Edit</th>
                                        <th style="color:var(--sp-red)">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <!-- ── MASTER ── -->
                                    <tr class="sp-select-all-row">
                                        <td colspan="5">
                                            <i class="fa fa-database" style="margin-right:6px"></i> Master
                                            <button type="button" class="sp-sec-btn" onclick="selectSection('m')">Select All</button>
                                            <button type="button" class="sp-sec-btn" onclick="clearSection('m')" style="color:var(--sp-red)">Clear</button>
                                        </td>
                                    </tr>
                                    <tr><td>Categories &amp; Sub Categories</td><td><div class="sp-check-wrap view"><input type="checkbox" id="m1v" checked><label for="m1v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="m1c" checked><label for="m1c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="m1e" checked><label for="m1e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="m1d"><label for="m1d"></label></div></td></tr>
                                    <tr><td>Attributes</td><td><div class="sp-check-wrap view"><input type="checkbox" id="m2v" checked><label for="m2v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="m2c" checked><label for="m2c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="m2e" checked><label for="m2e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="m2d"><label for="m2d"></label></div></td></tr>
                                    <tr><td>Attributes Value</td><td><div class="sp-check-wrap view"><input type="checkbox" id="m3v" checked><label for="m3v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="m3c" checked><label for="m3c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="m3e" checked><label for="m3e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="m3d"><label for="m3d"></label></div></td></tr>
                                    <tr><td>Category &amp; Attributes Mapping</td><td><div class="sp-check-wrap view"><input type="checkbox" id="m4v" checked><label for="m4v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="m4c"><label for="m4c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="m4e" checked><label for="m4e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="m4d"><label for="m4d"></label></div></td></tr>
                                    <tr><td>Manage Occasions</td><td><div class="sp-check-wrap view"><input type="checkbox" id="m5v" checked><label for="m5v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="m5c" checked><label for="m5c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="m5e" checked><label for="m5e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="m5d"><label for="m5d"></label></div></td></tr>
                                    <tr><td>Manage Collections</td><td><div class="sp-check-wrap view"><input type="checkbox" id="m6v" checked><label for="m6v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="m6c" checked><label for="m6c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="m6e" checked><label for="m6e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="m6d"><label for="m6d"></label></div></td></tr>
                                    <tr><td>Manage Brands</td><td><div class="sp-check-wrap view"><input type="checkbox" id="m7v" checked><label for="m7v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="m7c" checked><label for="m7c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="m7e" checked><label for="m7e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="m7d"><label for="m7d"></label></div></td></tr>

                                    <!-- ── PRODUCTS & INVENTORIES ── -->
                                    <tr class="sp-select-all-row">
                                        <td colspan="5">
                                            <i class="fa fa-box" style="margin-right:6px"></i> Products &amp; Inventories
                                            <button type="button" class="sp-sec-btn" onclick="selectSection('p')">Select All</button>
                                            <button type="button" class="sp-sec-btn" onclick="clearSection('p')" style="color:var(--sp-red)">Clear</button>
                                        </td>
                                    </tr>
                                    <tr><td>Manage Products</td><td><div class="sp-check-wrap view"><input type="checkbox" id="p1v" checked><label for="p1v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="p1c" checked><label for="p1c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="p1e" checked><label for="p1e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="p1d"><label for="p1d"></label></div></td></tr>
                                    <tr><td>Stock Management</td><td><div class="sp-check-wrap view"><input type="checkbox" id="p2v" checked><label for="p2v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="p2c"><label for="p2c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="p2e" checked><label for="p2e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="p2d"><label for="p2d"></label></div></td></tr>
                                    <tr><td>Stock Alerts</td><td><div class="sp-check-wrap view"><input type="checkbox" id="p3v" checked><label for="p3v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="p3c"><label for="p3c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="p3e"><label for="p3e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="p3d"><label for="p3d"></label></div></td></tr>
                                    <tr><td>Product Reviews</td><td><div class="sp-check-wrap view"><input type="checkbox" id="p4v" checked><label for="p4v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="p4c"><label for="p4c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="p4e"><label for="p4e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="p4d"><label for="p4d"></label></div></td></tr>

                                    <!-- ── CUSTOMER & ORDERS ── -->
                                    <tr class="sp-select-all-row">
                                        <td colspan="5">
                                            <i class="fa fa-shopping-cart" style="margin-right:6px"></i> Customer &amp; Orders
                                            <button type="button" class="sp-sec-btn" onclick="selectSection('o')">Select All</button>
                                            <button type="button" class="sp-sec-btn" onclick="clearSection('o')" style="color:var(--sp-red)">Clear</button>
                                        </td>
                                    </tr>
                                    <tr><td>Manage Orders</td><td><div class="sp-check-wrap view"><input type="checkbox" id="o1v" checked><label for="o1v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="o1c"><label for="o1c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="o1e" checked><label for="o1e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="o1d"><label for="o1d"></label></div></td></tr>
                                    <tr><td>Payments &amp; Transactions</td><td><div class="sp-check-wrap view"><input type="checkbox" id="o2v" checked><label for="o2v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="o2c"><label for="o2c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="o2e"><label for="o2e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="o2d"><label for="o2d"></label></div></td></tr>
                                    <tr><td>Manage Return Reasons</td><td><div class="sp-check-wrap view"><input type="checkbox" id="o3v" checked><label for="o3v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="o3c" checked><label for="o3c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="o3e" checked><label for="o3e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="o3d"><label for="o3d"></label></div></td></tr>
                                    <tr><td>Return Orders</td><td><div class="sp-check-wrap view"><input type="checkbox" id="o4v" checked><label for="o4v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="o4c"><label for="o4c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="o4e" checked><label for="o4e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="o4d"><label for="o4d"></label></div></td></tr>
                                    <tr><td>Refund Management</td><td><div class="sp-check-wrap view"><input type="checkbox" id="o5v" checked><label for="o5v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="o5c"><label for="o5c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="o5e" checked><label for="o5e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="o5d"><label for="o5d"></label></div></td></tr>
                                    <tr><td>Manage Customers</td><td><div class="sp-check-wrap view"><input type="checkbox" id="o6v" checked><label for="o6v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="o6c"><label for="o6c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="o6e" checked><label for="o6e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="o6d"><label for="o6d"></label></div></td></tr>
                                    <tr><td>Customer Address Book</td><td><div class="sp-check-wrap view"><input type="checkbox" id="o7v" checked><label for="o7v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="o7c"><label for="o7c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="o7e"><label for="o7e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="o7d"><label for="o7d"></label></div></td></tr>
                                    <tr><td>Customer WishList</td><td><div class="sp-check-wrap view"><input type="checkbox" id="o8v" checked><label for="o8v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="o8c"><label for="o8c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="o8e"><label for="o8e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="o8d"><label for="o8d"></label></div></td></tr>
                                    <tr><td>Abandoned Carts</td><td><div class="sp-check-wrap view"><input type="checkbox" id="o9v" checked><label for="o9v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="o9c"><label for="o9c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="o9e"><label for="o9e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="o9d"><label for="o9d"></label></div></td></tr>

                                    <!-- ── CONTENT MANAGEMENT ── -->
                                    <tr class="sp-select-all-row">
                                        <td colspan="5">
                                            <i class="fa fa-file-alt" style="margin-right:6px"></i> Content Management
                                            <button type="button" class="sp-sec-btn" onclick="selectSection('c')">Select All</button>
                                            <button type="button" class="sp-sec-btn" onclick="clearSection('c')" style="color:var(--sp-red)">Clear</button>
                                        </td>
                                    </tr>
                                    <tr><td>Home Page Widgets</td><td><div class="sp-check-wrap view"><input type="checkbox" id="c1v" checked><label for="c1v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="c1c" checked><label for="c1c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="c1e" checked><label for="c1e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="c1d"><label for="c1d"></label></div></td></tr>
                                    <tr><td>Manage About Us</td><td><div class="sp-check-wrap view"><input type="checkbox" id="c2v" checked><label for="c2v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="c2c" checked><label for="c2c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="c2e" checked><label for="c2e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="c2d"><label for="c2d"></label></div></td></tr>
                                    <tr><td>Manage Contact Us</td><td><div class="sp-check-wrap view"><input type="checkbox" id="c3v" checked><label for="c3v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="c3c" checked><label for="c3c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="c3e" checked><label for="c3e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="c3d"><label for="c3d"></label></div></td></tr>
                                    <tr><td>Manage FAQ</td><td><div class="sp-check-wrap view"><input type="checkbox" id="c4v" checked><label for="c4v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="c4c" checked><label for="c4c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="c4e" checked><label for="c4e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="c4d"><label for="c4d"></label></div></td></tr>
                                    <tr><td>Manage Blogs</td><td><div class="sp-check-wrap view"><input type="checkbox" id="c5v" checked><label for="c5v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="c5c" checked><label for="c5c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="c5e" checked><label for="c5e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="c5d"><label for="c5d"></label></div></td></tr>
                                    <tr><td>Manage Dynamic Pages</td><td><div class="sp-check-wrap view"><input type="checkbox" id="c6v" checked><label for="c6v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="c6c" checked><label for="c6c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="c6e" checked><label for="c6e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="c6d"><label for="c6d"></label></div></td></tr>
                                    <tr><td>Manage Announcements</td><td><div class="sp-check-wrap view"><input type="checkbox" id="c7v" checked><label for="c7v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="c7c" checked><label for="c7c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="c7e" checked><label for="c7e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="c7d"><label for="c7d"></label></div></td></tr>
                                    <tr><td>Testimonial &amp; Feedbacks</td><td><div class="sp-check-wrap view"><input type="checkbox" id="c8v" checked><label for="c8v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="c8c" checked><label for="c8c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="c8e" checked><label for="c8e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="c8d"><label for="c8d"></label></div></td></tr>

                                    <!-- ── ENQUIRIES ── -->
                                    <tr class="sp-select-all-row">
                                        <td colspan="5">
                                            <i class="fa fa-envelope" style="margin-right:6px"></i> Enquiries
                                            <button type="button" class="sp-sec-btn" onclick="selectSection('e')">Select All</button>
                                            <button type="button" class="sp-sec-btn" onclick="clearSection('e')" style="color:var(--sp-red)">Clear</button>
                                        </td>
                                    </tr>
                                    <tr><td>Contact Us Enquiries</td><td><div class="sp-check-wrap view"><input type="checkbox" id="e1v" checked><label for="e1v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="e1c"><label for="e1c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="e1e"><label for="e1e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="e1d"><label for="e1d"></label></div></td></tr>
                                    <tr><td>Get a Callback Enquiries</td><td><div class="sp-check-wrap view"><input type="checkbox" id="e2v" checked><label for="e2v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="e2c"><label for="e2c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="e2e"><label for="e2e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="e2d"><label for="e2d"></label></div></td></tr>
                                    <tr><td>Bulk Order Enquiries</td><td><div class="sp-check-wrap view"><input type="checkbox" id="e3v" checked><label for="e3v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="e3c"><label for="e3c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="e3e"><label for="e3e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="e3d"><label for="e3d"></label></div></td></tr>
                                    <tr><td>Sellers / Vendors Enquiries</td><td><div class="sp-check-wrap view"><input type="checkbox" id="e4v" checked><label for="e4v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="e4c"><label for="e4c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="e4e"><label for="e4e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="e4d"><label for="e4d"></label></div></td></tr>

                                    <!-- ── MARKETING & SEO ── -->
                                    <tr class="sp-select-all-row">
                                        <td colspan="5">
                                            <i class="fa fa-chart-line" style="margin-right:6px"></i> Marketing &amp; SEO
                                            <button type="button" class="sp-sec-btn" onclick="selectSection('mk')">Select All</button>
                                            <button type="button" class="sp-sec-btn" onclick="clearSection('mk')" style="color:var(--sp-red)">Clear</button>
                                        </td>
                                    </tr>
                                    <tr><td>Coupon Management</td><td><div class="sp-check-wrap view"><input type="checkbox" id="mk1v" checked><label for="mk1v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="mk1c" checked><label for="mk1c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="mk1e" checked><label for="mk1e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="mk1d"><label for="mk1d"></label></div></td></tr>
                                    <tr><td>SEO Settings</td><td><div class="sp-check-wrap view"><input type="checkbox" id="mk2v" checked><label for="mk2v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="mk2c"><label for="mk2c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="mk2e" checked><label for="mk2e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="mk2d"><label for="mk2d"></label></div></td></tr>
                                    <tr><td>Email Subscribers</td><td><div class="sp-check-wrap view"><input type="checkbox" id="mk3v" checked><label for="mk3v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="mk3c"><label for="mk3c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="mk3e"><label for="mk3e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="mk3d"><label for="mk3d"></label></div></td></tr>

                                    <!-- ── ADMIN SETTINGS ── -->
                                    <tr class="sp-select-all-row">
                                        <td colspan="5">
                                            <i class="fa fa-cog" style="margin-right:6px"></i> Admin Settings
                                            <button type="button" class="sp-sec-btn" onclick="selectSection('s')">Select All</button>
                                            <button type="button" class="sp-sec-btn" onclick="clearSection('s')" style="color:var(--sp-red)">Clear</button>
                                        </td>
                                    </tr>
                                    <tr><td>General Setting</td><td><div class="sp-check-wrap view"><input type="checkbox" id="s1v" checked><label for="s1v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="s1c"><label for="s1c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="s1e"><label for="s1e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="s1d"><label for="s1d"></label></div></td></tr>
                                    <tr><td>SMTP Setting</td><td><div class="sp-check-wrap view"><input type="checkbox" id="s2v" checked><label for="s2v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="s2c"><label for="s2c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="s2e"><label for="s2e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="s2d"><label for="s2d"></label></div></td></tr>
                                    <tr><td>Payment Gateway Setting</td><td><div class="sp-check-wrap view"><input type="checkbox" id="s3v" checked><label for="s3v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="s3c"><label for="s3c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="s3e"><label for="s3e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="s3d"><label for="s3d"></label></div></td></tr>
                                    <tr><td>SMS Setting</td><td><div class="sp-check-wrap view"><input type="checkbox" id="s4v" checked><label for="s4v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="s4c"><label for="s4c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="s4e"><label for="s4e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="s4d"><label for="s4d"></label></div></td></tr>
                                    <tr><td>Tax &amp; Invoice Setting</td><td><div class="sp-check-wrap view"><input type="checkbox" id="s5v" checked><label for="s5v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="s5c"><label for="s5c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="s5e"><label for="s5e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="s5d"><label for="s5d"></label></div></td></tr>
                                    <tr><td>Courier Management</td><td><div class="sp-check-wrap view"><input type="checkbox" id="s6v" checked><label for="s6v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="s6c"><label for="s6c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="s6e"><label for="s6e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="s6d"><label for="s6d"></label></div></td></tr>
                                    <tr><td>Social Media Setting</td><td><div class="sp-check-wrap view"><input type="checkbox" id="s7v" checked><label for="s7v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="s7c"><label for="s7c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="s7e"><label for="s7e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="s7d"><label for="s7d"></label></div></td></tr>

                                    <!-- ── REPORTS ── -->
                                    <tr class="sp-select-all-row">
                                        <td colspan="5">
                                            <i class="fa fa-chart-bar" style="margin-right:6px"></i> Reports
                                            <button type="button" class="sp-sec-btn" onclick="selectSection('r')">Select All</button>
                                            <button type="button" class="sp-sec-btn" onclick="clearSection('r')" style="color:var(--sp-red)">Clear</button>
                                        </td>
                                    </tr>
                                    <tr><td>Sales Report</td><td><div class="sp-check-wrap view"><input type="checkbox" id="r1v" checked><label for="r1v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="r1c"><label for="r1c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="r1e"><label for="r1e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="r1d"><label for="r1d"></label></div></td></tr>
                                    <tr><td>Customer Report</td><td><div class="sp-check-wrap view"><input type="checkbox" id="r2v" checked><label for="r2v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="r2c"><label for="r2c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="r2e"><label for="r2e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="r2d"><label for="r2d"></label></div></td></tr>
                                    <tr><td>Stock Reports</td><td><div class="sp-check-wrap view"><input type="checkbox" id="r3v" checked><label for="r3v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="r3c"><label for="r3c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="r3e"><label for="r3e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="r3d"><label for="r3d"></label></div></td></tr>

                                    <!-- ── NOTIFICATIONS ── -->
                                    <tr class="sp-select-all-row">
                                        <td colspan="5">
                                            <i class="fa fa-bell" style="margin-right:6px"></i> Notifications
                                            <button type="button" class="sp-sec-btn" onclick="selectSection('n')">Select All</button>
                                            <button type="button" class="sp-sec-btn" onclick="clearSection('n')" style="color:var(--sp-red)">Clear</button>
                                        </td>
                                    </tr>
                                    <tr><td>Notifications</td><td><div class="sp-check-wrap view"><input type="checkbox" id="n1v" checked><label for="n1v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="n1c"><label for="n1c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="n1e"><label for="n1e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="n1d"><label for="n1d"></label></div></td></tr>

                                </tbody>
                            </table>

                        </div>
                    </div>

                </div>

                <!-- ══ RIGHT — sidebar ══ -->
                <div>

                    <!-- Status -->
                    <div class="sp-card">
                        <div class="sp-card-header"><h5>Settings</h5></div>
                        <div class="sp-card-body-sm">
                            <div class="sp-toggle-row">
                                <div>
                                    <div class="sp-toggle-label">Status</div>
                                    <div class="sp-toggle-sub">Enable this permission set</div>
                                </div>
                                <label class="sp-switch">
                                    <input type="checkbox" checked>
                                    <span class="sp-switch-track"></span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Record info -->
                    <div class="sp-card">
                        <div class="sp-card-header"><h5>Record Info</h5></div>
                        <div class="sp-card-body-sm">
                            <div class="sp-info-row">
                                <span class="sp-info-label">Permission ID</span>
                                <span class="sp-info-value" style="font-family:'SF Mono','Fira Code',monospace;font-size:12px;color:var(--sp-accent)">#PERM-002</span>
                            </div>
                            <div class="sp-info-row">
                                <span class="sp-info-label">Role</span>
                                <span class="sp-info-value">Manager</span>
                            </div>
                            <div class="sp-info-row">
                                <span class="sp-info-label">Members</span>
                                <span class="sp-info-value">4 assigned</span>
                            </div>
                            <div class="sp-info-row">
                                <span class="sp-info-label">Created</span>
                                <span class="sp-info-value">12 Jan 2025</span>
                            </div>
                            <div class="sp-info-row">
                                <span class="sp-info-label">Last Updated</span>
                                <span class="sp-info-value">18 Jun 2025</span>
                            </div>
                            <div class="sp-info-row">
                                <span class="sp-info-label">Updated By</span>
                                <span class="sp-info-value">Super Admin</span>
                            </div>
                        </div>
                    </div>

                    <!-- Legend -->
                    <div class="sp-card">
                        <div class="sp-card-header"><h5>Legend</h5></div>
                        <div class="sp-card-body-sm">
                            <div class="sp-legend">
                                <div class="sp-legend-item"><span class="sp-legend-dot" style="background:var(--sp-blue)"></span> View</div>
                                <div class="sp-legend-item"><span class="sp-legend-dot" style="background:var(--sp-green)"></span> Create</div>
                                <div class="sp-legend-item"><span class="sp-legend-dot" style="background:var(--sp-amber)"></span> Edit</div>
                                <div class="sp-legend-item"><span class="sp-legend-dot" style="background:var(--sp-red)"></span> Delete</div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick actions -->
                    <div class="sp-card">
                        <div class="sp-card-header"><h5>Quick Actions</h5></div>
                        <div class="sp-card-body-sm" style="display:flex;flex-direction:column;gap:8px">
                            <button onclick="selectAll()" style="display:inline-flex;align-items:center;gap:8px;font-size:13px;color:var(--sp-green);background:var(--sp-green-bg);border:1px solid var(--sp-green-border);border-radius:var(--sp-radius-md);padding:7px 12px;cursor:pointer;font-family:var(--sp-font);font-weight:560;width:100%">
                                <i class="fa fa-check-square"></i> Select All Permissions
                            </button>
                            <button onclick="clearAll()" style="display:inline-flex;align-items:center;gap:8px;font-size:13px;color:var(--sp-red);background:var(--sp-red-bg);border:1px solid #f5b8b8;border-radius:var(--sp-radius-md);padding:7px 12px;cursor:pointer;font-family:var(--sp-font);font-weight:560;width:100%">
                                <i class="fa fa-square"></i> Clear All Permissions
                            </button>
                            <button onclick="selectViewOnly()" style="display:inline-flex;align-items:center;gap:8px;font-size:13px;color:var(--sp-blue);background:var(--sp-blue-bg);border:1px solid var(--sp-blue-border);border-radius:var(--sp-radius-md);padding:7px 12px;cursor:pointer;font-family:var(--sp-font);font-weight:560;width:100%">
                                <i class="fa fa-eye"></i> View Only
                            </button>
                            <button onclick="resetToSaved()" style="display:inline-flex;align-items:center;gap:8px;font-size:13px;color:var(--sp-amber);background:var(--sp-amber-bg);border:1px solid var(--sp-amber-border);border-radius:var(--sp-radius-md);padding:7px 12px;cursor:pointer;font-family:var(--sp-font);font-weight:560;width:100%">
                                <i class="fa fa-history"></i> Reset to Saved
                            </button>
                        </div>
                    </div>

                    <!-- Summary -->
                    <div class="sp-card">
                        <div class="sp-card-header"><h5>Summary</h5></div>
                        <div class="sp-card-body-sm">
                            <div style="font-size:13px;color:var(--sp-text-secondary);line-height:2">
                                <div style="display:flex;justify-content:space-between">
                                    <span>Total Modules</span>
                                    <strong style="color:var(--sp-text-primary)">38</strong>
                                </div>
                                <div style="display:flex;justify-content:space-between">
                                    <span>Selected</span>
                                    <strong style="color:var(--sp-accent)" id="selectedCount">24</strong>
                                </div>
                                <div style="display:flex;justify-content:space-between">
                                    <span>Changes</span>
                                    <strong style="color:var(--sp-amber)" id="changesCount">0</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <!-- Action bar -->
            <div class="sp-action-bar">
                <div class="sp-action-bar-left">
                    <i class="fa fa-info-circle"></i>
                    Changes will apply to all <strong style="color:var(--sp-text-primary);margin:0 3px">4 members</strong> in the Manager role.
                </div>
                <div class="sp-action-bar-right">
                    <button class="sp-btn-reset" onclick="resetToSaved()">
                        <i class="fa fa-history"></i> Reset
                    </button>
                    <a href="#" class="sp-btn-secondary">Cancel</a>
                    <button class="sp-btn-primary" onclick="savePermissions()">
                        <i class="fa fa-save"></i> Update Permissions
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

@include('admin.footer')

<script>
/* ── Snapshot of initial state (to track changes & reset) ── */
const initialState = {};

function snapshot() {
    document.querySelectorAll('.sp-check-wrap input[type=checkbox]').forEach(cb => {
        initialState[cb.id] = cb.checked;
    });
}

function getAll() { return document.querySelectorAll('.sp-check-wrap input[type=checkbox]'); }

function updateCount() {
    const total   = document.querySelectorAll('.sp-check-wrap input').length;
    const checked = document.querySelectorAll('.sp-check-wrap input:checked').length;
    let changed = 0;
    document.querySelectorAll('.sp-check-wrap input').forEach(cb => {
        if (cb.checked !== initialState[cb.id]) changed++;
    });

    document.getElementById('selectedCount').textContent = checked;
    document.getElementById('changesCount').textContent  = changed;

    const badge = document.getElementById('changedBadge');
    if (changed > 0) badge.classList.add('visible');
    else badge.classList.remove('visible');
}

function selectAll()      { getAll().forEach(cb => cb.checked = true);  updateCount(); }
function clearAll()       { getAll().forEach(cb => cb.checked = false); updateCount(); }
function selectViewOnly() {
    getAll().forEach(cb => cb.checked = false);
    document.querySelectorAll('.sp-check-wrap.view input').forEach(cb => cb.checked = true);
    updateCount();
}

function selectSection(prefix) {
    document.querySelectorAll(`input[id^="${prefix}"]`).forEach(cb => {
        if (cb.closest('.sp-check-wrap')) cb.checked = true;
    });
    updateCount();
}
function clearSection(prefix) {
    document.querySelectorAll(`input[id^="${prefix}"]`).forEach(cb => {
        if (cb.closest('.sp-check-wrap')) cb.checked = false;
    });
    updateCount();
}

function resetToSaved() {
    document.querySelectorAll('.sp-check-wrap input').forEach(cb => {
        cb.checked = initialState[cb.id] ?? false;
    });
    updateCount();
}

function savePermissions() {
    Swal.fire({
        icon: 'success',
        title: 'Permissions Updated!',
        text: 'The permission changes for Manager role have been saved successfully.',
        timer: 2000,
        showConfirmButton: false
    }).then(() => { snapshot(); updateCount(); });
}

/* Init */
document.addEventListener('DOMContentLoaded', function () {
    snapshot();
    updateCount();
    getAll().forEach(cb => cb.addEventListener('change', updateCount));
});
</script>