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

    /* ── Layout ── */
    .sp-perm-layout { display: grid; grid-template-columns: 1fr 240px; gap: 20px; align-items: start; }
    @media (max-width: 960px) { .sp-perm-layout { grid-template-columns: 1fr; } }

    /* ── Cards ── */
    .sp-card { background: var(--sp-surface); border-radius: var(--sp-radius-lg); box-shadow: var(--sp-shadow-card); border: 1px solid var(--sp-border); overflow: hidden; margin-bottom: 16px; }
    .sp-card:last-child { margin-bottom: 0; }
    .sp-card-header { padding: 13px 20px; border-bottom: 1px solid var(--sp-border); background: #fafafa; display: flex; align-items: center; justify-content: space-between; }
    .sp-card-header h5 { font-size: 13px; font-weight: 650; color: var(--sp-text-primary); margin: 0; }
    .sp-card-body { padding: 20px 24px; }
    .sp-card-body-sm { padding: 14px 20px; }

    /* ── Form fields ── */
    .sp-field { margin-bottom: 18px; }
    .sp-field:last-child { margin-bottom: 0; }
    .sp-label { display: block; font-size: 12px; font-weight: 620; color: var(--sp-text-secondary); letter-spacing: .04em; text-transform: uppercase; margin-bottom: 6px; }
    .sp-req { color: var(--sp-red); margin-left: 2px; }
    .sp-select-wrap { position: relative; }
    .sp-select-wrap::after { content: ''; pointer-events: none; position: absolute; right: 12px; top: 50%; transform: translateY(-50%); width: 0; height: 0; border-left: 4px solid transparent; border-right: 4px solid transparent; border-top: 5px solid var(--sp-text-hint); }
    .sp-select { width: 100%; border: 1px solid var(--sp-border); border-radius: var(--sp-radius-md); padding: 0 12px; height: 38px; font-size: 13.5px; color: var(--sp-text-primary); background: var(--sp-surface); outline: none; appearance: none; font-family: var(--sp-font); transition: border-color .15s, box-shadow .15s; }
    .sp-select:focus { border-color: var(--sp-accent); box-shadow: 0 0 0 3px rgba(48,61,137,.10); }

    /* ── Permission matrix ── */
    .sp-matrix-section { margin-bottom: 24px; }
    .sp-matrix-section:last-child { margin-bottom: 0; }
    .sp-section-label {
        font-size: 11px; font-weight: 700; letter-spacing: .07em; text-transform: uppercase;
        color: var(--sp-accent); padding: 6px 0 10px;
        display: flex; align-items: center; gap: 8px;
    }
    .sp-section-label::after { content: ''; flex: 1; height: 1px; background: var(--sp-accent-light); }

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
    .sp-check-wrap label {
        width: 20px; height: 20px; border: 2px solid var(--sp-border);
        border-radius: 5px; cursor: pointer; display: flex; align-items: center;
        justify-content: center; transition: all .15s; background: var(--sp-surface);
        position: relative;
    }
    .sp-check-wrap label::after { content: ''; display: none; width: 5px; height: 9px; border: 2px solid #fff; border-top: none; border-left: none; transform: rotate(45deg) translateY(-1px); }
    .sp-check-wrap input:checked + label { background: var(--sp-accent); border-color: var(--sp-accent); }
    .sp-check-wrap input:checked + label::after { display: block; }
    .sp-check-wrap.view   input:checked + label { background: #0069d9; border-color: #0069d9; }
    .sp-check-wrap.create input:checked + label { background: var(--sp-green); border-color: var(--sp-green); }
    .sp-check-wrap.edit   input:checked + label { background: #916a00; border-color: #916a00; }
    .sp-check-wrap.delete input:checked + label { background: var(--sp-red); border-color: var(--sp-red); }

    /* Select-all row */
    .sp-select-all-row td { background: #f5f6fe; font-size: 12px; font-weight: 650; color: var(--sp-accent); padding: 7px 12px; border-bottom: 1px solid var(--sp-border); }
    .sp-select-all-row td:first-child { border-radius: 0; }

    /* ── Settings sidebar ── */
    .sp-toggle-row { display: flex; align-items: center; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid var(--sp-bg); }
    .sp-toggle-row:first-child { padding-top: 0; }
    .sp-toggle-row:last-child { border-bottom: none; padding-bottom: 0; }
    .sp-toggle-label { font-size: 13px; font-weight: 500; color: var(--sp-text-primary); }
    .sp-toggle-sub { font-size: 11.5px; color: var(--sp-text-hint); margin-top: 1px; }
    .sp-switch { position: relative; width: 38px; height: 22px; flex-shrink: 0; }
    .sp-switch input { opacity: 0; width: 0; height: 0; position: absolute; }
    .sp-switch-track { position: absolute; inset: 0; background: var(--sp-border); border-radius: 22px; cursor: pointer; transition: background .2s; }
    .sp-switch-track::after { content: ''; position: absolute; left: 3px; top: 3px; width: 16px; height: 16px; background: #fff; border-radius: 50%; transition: transform .2s; box-shadow: 0 1px 3px rgba(0,0,0,.2); }
    .sp-switch input:checked + .sp-switch-track { background: var(--sp-accent); }
    .sp-switch input:checked + .sp-switch-track::after { transform: translateX(16px); }

    /* ── Legend ── */
    .sp-legend { display: flex; flex-wrap: wrap; gap: 10px; }
    .sp-legend-item { display: flex; align-items: center; gap: 6px; font-size: 12px; color: var(--sp-text-secondary); }
    .sp-legend-dot { width: 10px; height: 10px; border-radius: 3px; flex-shrink: 0; }

    /* ── Action bar ── */
    .sp-action-bar { background: var(--sp-surface); border: 1px solid var(--sp-border); border-radius: var(--sp-radius-lg); box-shadow: var(--sp-shadow-card); padding: 14px 20px; display: flex; align-items: center; justify-content: flex-end; gap: 10px; margin-top: 20px; }
    .sp-btn-primary { display: inline-flex; align-items: center; gap: 6px; background: var(--sp-accent); color: #fff; border: 1px solid transparent; border-radius: var(--sp-radius-md); padding: 8px 16px; font-size: 13.5px; font-weight: 580; font-family: var(--sp-font); cursor: pointer; text-decoration: none; line-height: 1.4; transition: background .15s; white-space: nowrap; }
    .sp-btn-primary:hover { background: var(--sp-accent-hover); color: #fff; }
    .sp-btn-secondary { display: inline-flex; align-items: center; gap: 6px; background: var(--sp-surface); color: var(--sp-text-primary); border: 1px solid var(--sp-border); border-radius: var(--sp-radius-md); padding: 8px 16px; font-size: 13.5px; font-weight: 540; font-family: var(--sp-font); cursor: pointer; text-decoration: none; line-height: 1.4; transition: all .15s; white-space: nowrap; }
    .sp-btn-secondary:hover { background: var(--sp-bg); border-color: var(--sp-border-hover); }
    @media (max-width: 768px) { .sp-page { padding: 16px; } }
    </style>

    <div class="app-content content container-fluid">
        <div class="sp-page">

            <div class="sp-page-header">
                <div>
                    <h1 class="sp-page-title">Create Role Permissions</h1>
                    <div class="sp-crumb">
                        <a href="dashboard.html">Dashboard</a>
                        <span style="color:var(--sp-border-hover)">›</span>
                        <a href="#">Roles & Settings</a>
                        <span style="color:var(--sp-border-hover)">›</span>
                        <a href="role-permissions-index.html">Role Permissions</a>
                        <span style="color:var(--sp-border-hover)">›</span>
                        <span>Create</span>
                    </div>
                </div>
            </div>

            <div class="sp-perm-layout">

                <!-- LEFT — permission matrix -->
                <div>

                    <!-- Role selector -->
                    <div class="sp-card">
                        <div class="sp-card-header"><h5>Select Role Category</h5></div>
                        <div class="sp-card-body">
                            <div class="sp-field" style="margin:0">
                                <label class="sp-label">Role Category <span class="sp-req">*</span></label>
                                <div class="sp-select-wrap">
                                    <select class="sp-select" id="roleSelect">
                                        <option value="">— Choose a role category —</option>
                                        <option value="1">Super Admin</option>
                                        <option value="2">Manager</option>
                                        <option value="3">Content Editor</option>
                                        <option value="4">Support Agent</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Permission Matrix -->
                    <div class="sp-card">
                        <div class="sp-card-header">
                            <h5>Module Permissions</h5>
                            <button type="button" onclick="selectAll()" style="font-size:12px;color:var(--sp-accent);background:none;border:none;cursor:pointer;font-weight:600;font-family:var(--sp-font)">
                                <i class="fa fa-check-square"></i> Select All
                            </button>
                        </div>
                        <div class="sp-card-body">

                            <table class="sp-matrix-table">
                                <thead>
                                    <tr>
                                        <th>Module</th>
                                        <th style="color:#0069d9">View</th>
                                        <th style="color:var(--sp-green)">Create</th>
                                        <th style="color:#916a00">Edit</th>
                                        <th style="color:var(--sp-red)">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <!-- MASTER -->
                                    <tr class="sp-select-all-row">
                                        <td colspan="5">
                                            <i class="fa fa-database" style="margin-right:6px"></i> Master
                                            <button type="button" onclick="selectSection('master')" style="margin-left:10px;font-size:11px;color:var(--sp-accent);background:none;border:none;cursor:pointer;font-weight:600;font-family:var(--sp-font)">Select All</button>
                                        </td>
                                    </tr>
                                    <tr><td>Categories & Sub Categories</td><td><div class="sp-check-wrap view"><input type="checkbox" id="m1v"><label for="m1v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="m1c"><label for="m1c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="m1e"><label for="m1e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="m1d"><label for="m1d"></label></div></td></tr>
                                    <tr><td>Attributes</td><td><div class="sp-check-wrap view"><input type="checkbox" id="m2v"><label for="m2v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="m2c"><label for="m2c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="m2e"><label for="m2e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="m2d"><label for="m2d"></label></div></td></tr>
                                    <tr><td>Attributes Value</td><td><div class="sp-check-wrap view"><input type="checkbox" id="m3v"><label for="m3v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="m3c"><label for="m3c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="m3e"><label for="m3e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="m3d"><label for="m3d"></label></div></td></tr>
                                    <tr><td>Category & Attributes Mapping</td><td><div class="sp-check-wrap view"><input type="checkbox" id="m4v"><label for="m4v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="m4c"><label for="m4c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="m4e"><label for="m4e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="m4d"><label for="m4d"></label></div></td></tr>
                                    <tr><td>Manage Occasions</td><td><div class="sp-check-wrap view"><input type="checkbox" id="m5v"><label for="m5v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="m5c"><label for="m5c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="m5e"><label for="m5e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="m5d"><label for="m5d"></label></div></td></tr>
                                    <tr><td>Manage Collections</td><td><div class="sp-check-wrap view"><input type="checkbox" id="m6v"><label for="m6v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="m6c"><label for="m6c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="m6e"><label for="m6e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="m6d"><label for="m6d"></label></div></td></tr>
                                    <tr><td>Manage Brands</td><td><div class="sp-check-wrap view"><input type="checkbox" id="m7v"><label for="m7v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="m7c"><label for="m7c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="m7e"><label for="m7e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="m7d"><label for="m7d"></label></div></td></tr>

                                    <!-- PRODUCTS & INVENTORIES -->
                                    <tr class="sp-select-all-row">
                                        <td colspan="5">
                                            <i class="fa fa-box" style="margin-right:6px"></i> Products & Inventories
                                            <button type="button" onclick="selectSection('products')" style="margin-left:10px;font-size:11px;color:var(--sp-accent);background:none;border:none;cursor:pointer;font-weight:600;font-family:var(--sp-font)">Select All</button>
                                        </td>
                                    </tr>
                                    <tr><td>Manage Products</td><td><div class="sp-check-wrap view"><input type="checkbox" id="p1v"><label for="p1v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="p1c"><label for="p1c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="p1e"><label for="p1e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="p1d"><label for="p1d"></label></div></td></tr>
                                    <tr><td>Stock Management</td><td><div class="sp-check-wrap view"><input type="checkbox" id="p2v"><label for="p2v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="p2c"><label for="p2c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="p2e"><label for="p2e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="p2d"><label for="p2d"></label></div></td></tr>
                                    <tr><td>Stock Alerts</td><td><div class="sp-check-wrap view"><input type="checkbox" id="p3v"><label for="p3v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="p3c"><label for="p3c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="p3e"><label for="p3e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="p3d"><label for="p3d"></label></div></td></tr>
                                    <tr><td>Product Reviews</td><td><div class="sp-check-wrap view"><input type="checkbox" id="p4v"><label for="p4v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="p4c"><label for="p4c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="p4e"><label for="p4e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="p4d"><label for="p4d"></label></div></td></tr>

                                    <!-- CUSTOMERS & ORDERS -->
                                    <tr class="sp-select-all-row">
                                        <td colspan="5">
                                            <i class="fa fa-shopping-cart" style="margin-right:6px"></i> Customer & Orders
                                            <button type="button" onclick="selectSection('orders')" style="margin-left:10px;font-size:11px;color:var(--sp-accent);background:none;border:none;cursor:pointer;font-weight:600;font-family:var(--sp-font)">Select All</button>
                                        </td>
                                    </tr>
                                    <tr><td>Manage Orders</td><td><div class="sp-check-wrap view"><input type="checkbox" id="o1v"><label for="o1v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="o1c"><label for="o1c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="o1e"><label for="o1e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="o1d"><label for="o1d"></label></div></td></tr>
                                    <tr><td>Payments & Transactions</td><td><div class="sp-check-wrap view"><input type="checkbox" id="o2v"><label for="o2v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="o2c"><label for="o2c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="o2e"><label for="o2e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="o2d"><label for="o2d"></label></div></td></tr>
                                    <tr><td>Manage Return Reasons</td><td><div class="sp-check-wrap view"><input type="checkbox" id="o3v"><label for="o3v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="o3c"><label for="o3c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="o3e"><label for="o3e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="o3d"><label for="o3d"></label></div></td></tr>
                                    <tr><td>Return Orders</td><td><div class="sp-check-wrap view"><input type="checkbox" id="o4v"><label for="o4v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="o4c"><label for="o4c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="o4e"><label for="o4e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="o4d"><label for="o4d"></label></div></td></tr>
                                    <tr><td>Refund Management</td><td><div class="sp-check-wrap view"><input type="checkbox" id="o5v"><label for="o5v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="o5c"><label for="o5c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="o5e"><label for="o5e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="o5d"><label for="o5d"></label></div></td></tr>
                                    <tr><td>Manage Customers</td><td><div class="sp-check-wrap view"><input type="checkbox" id="o6v"><label for="o6v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="o6c"><label for="o6c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="o6e"><label for="o6e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="o6d"><label for="o6d"></label></div></td></tr>
                                    <tr><td>Customer Address Book</td><td><div class="sp-check-wrap view"><input type="checkbox" id="o7v"><label for="o7v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="o7c"><label for="o7c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="o7e"><label for="o7e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="o7d"><label for="o7d"></label></div></td></tr>
                                    <tr><td>Customer WishList</td><td><div class="sp-check-wrap view"><input type="checkbox" id="o8v"><label for="o8v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="o8c"><label for="o8c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="o8e"><label for="o8e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="o8d"><label for="o8d"></label></div></td></tr>
                                    <tr><td>Abandoned Carts</td><td><div class="sp-check-wrap view"><input type="checkbox" id="o9v"><label for="o9v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="o9c"><label for="o9c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="o9e"><label for="o9e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="o9d"><label for="o9d"></label></div></td></tr>

                                    <!-- CONTENT MANAGEMENT -->
                                    <tr class="sp-select-all-row">
                                        <td colspan="5">
                                            <i class="fa fa-file-alt" style="margin-right:6px"></i> Content Management
                                            <button type="button" onclick="selectSection('content')" style="margin-left:10px;font-size:11px;color:var(--sp-accent);background:none;border:none;cursor:pointer;font-weight:600;font-family:var(--sp-font)">Select All</button>
                                        </td>
                                    </tr>
                                    <tr><td>Home Page Widgets</td><td><div class="sp-check-wrap view"><input type="checkbox" id="c1v"><label for="c1v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="c1c"><label for="c1c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="c1e"><label for="c1e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="c1d"><label for="c1d"></label></div></td></tr>
                                    <tr><td>Manage About Us</td><td><div class="sp-check-wrap view"><input type="checkbox" id="c2v"><label for="c2v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="c2c"><label for="c2c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="c2e"><label for="c2e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="c2d"><label for="c2d"></label></div></td></tr>
                                    <tr><td>Manage Contact Us</td><td><div class="sp-check-wrap view"><input type="checkbox" id="c3v"><label for="c3v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="c3c"><label for="c3c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="c3e"><label for="c3e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="c3d"><label for="c3d"></label></div></td></tr>
                                    <tr><td>Manage FAQ</td><td><div class="sp-check-wrap view"><input type="checkbox" id="c4v"><label for="c4v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="c4c"><label for="c4c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="c4e"><label for="c4e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="c4d"><label for="c4d"></label></div></td></tr>
                                    <tr><td>Manage Blogs</td><td><div class="sp-check-wrap view"><input type="checkbox" id="c5v"><label for="c5v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="c5c"><label for="c5c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="c5e"><label for="c5e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="c5d"><label for="c5d"></label></div></td></tr>
                                    <tr><td>Manage Dynamic Pages</td><td><div class="sp-check-wrap view"><input type="checkbox" id="c6v"><label for="c6v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="c6c"><label for="c6c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="c6e"><label for="c6e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="c6d"><label for="c6d"></label></div></td></tr>
                                    <tr><td>Manage Announcements</td><td><div class="sp-check-wrap view"><input type="checkbox" id="c7v"><label for="c7v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="c7c"><label for="c7c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="c7e"><label for="c7e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="c7d"><label for="c7d"></label></div></td></tr>
                                    <tr><td>Testimonial & Feedbacks</td><td><div class="sp-check-wrap view"><input type="checkbox" id="c8v"><label for="c8v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="c8c"><label for="c8c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="c8e"><label for="c8e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="c8d"><label for="c8d"></label></div></td></tr>

                                    <!-- ENQUIRIES -->
                                    <tr class="sp-select-all-row">
                                        <td colspan="5">
                                            <i class="fa fa-envelope" style="margin-right:6px"></i> Enquiries
                                            <button type="button" onclick="selectSection('enquiries')" style="margin-left:10px;font-size:11px;color:var(--sp-accent);background:none;border:none;cursor:pointer;font-weight:600;font-family:var(--sp-font)">Select All</button>
                                        </td>
                                    </tr>
                                    <tr><td>Contact Us Enquiries</td><td><div class="sp-check-wrap view"><input type="checkbox" id="e1v"><label for="e1v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="e1c"><label for="e1c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="e1e"><label for="e1e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="e1d"><label for="e1d"></label></div></td></tr>
                                    <tr><td>Get a Callback Enquiries</td><td><div class="sp-check-wrap view"><input type="checkbox" id="e2v"><label for="e2v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="e2c"><label for="e2c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="e2e"><label for="e2e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="e2d"><label for="e2d"></label></div></td></tr>
                                    <tr><td>Bulk Order Enquiries</td><td><div class="sp-check-wrap view"><input type="checkbox" id="e3v"><label for="e3v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="e3c"><label for="e3c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="e3e"><label for="e3e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="e3d"><label for="e3d"></label></div></td></tr>
                                    <tr><td>Sellers / Vendors Enquiries</td><td><div class="sp-check-wrap view"><input type="checkbox" id="e4v"><label for="e4v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="e4c"><label for="e4c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="e4e"><label for="e4e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="e4d"><label for="e4d"></label></div></td></tr>

                                    <!-- MARKETING & SEO -->
                                    <tr class="sp-select-all-row">
                                        <td colspan="5">
                                            <i class="fa fa-chart-line" style="margin-right:6px"></i> Marketing & SEO
                                            <button type="button" onclick="selectSection('marketing')" style="margin-left:10px;font-size:11px;color:var(--sp-accent);background:none;border:none;cursor:pointer;font-weight:600;font-family:var(--sp-font)">Select All</button>
                                        </td>
                                    </tr>
                                    <tr><td>Coupon Management</td><td><div class="sp-check-wrap view"><input type="checkbox" id="mk1v"><label for="mk1v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="mk1c"><label for="mk1c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="mk1e"><label for="mk1e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="mk1d"><label for="mk1d"></label></div></td></tr>
                                    <tr><td>SEO Settings</td><td><div class="sp-check-wrap view"><input type="checkbox" id="mk2v"><label for="mk2v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="mk2c"><label for="mk2c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="mk2e"><label for="mk2e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="mk2d"><label for="mk2d"></label></div></td></tr>
                                    <tr><td>Email Subscribers</td><td><div class="sp-check-wrap view"><input type="checkbox" id="mk3v"><label for="mk3v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="mk3c"><label for="mk3c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="mk3e"><label for="mk3e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="mk3d"><label for="mk3d"></label></div></td></tr>

                                    <!-- ADMIN SETTINGS -->
                                    <tr class="sp-select-all-row">
                                        <td colspan="5">
                                            <i class="fa fa-cog" style="margin-right:6px"></i> Admin Settings
                                            <button type="button" onclick="selectSection('settings')" style="margin-left:10px;font-size:11px;color:var(--sp-accent);background:none;border:none;cursor:pointer;font-weight:600;font-family:var(--sp-font)">Select All</button>
                                        </td>
                                    </tr>
                                    <tr><td>General Setting</td><td><div class="sp-check-wrap view"><input type="checkbox" id="s1v"><label for="s1v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="s1c"><label for="s1c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="s1e"><label for="s1e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="s1d"><label for="s1d"></label></div></td></tr>
                                    <tr><td>SMTP Setting</td><td><div class="sp-check-wrap view"><input type="checkbox" id="s2v"><label for="s2v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="s2c"><label for="s2c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="s2e"><label for="s2e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="s2d"><label for="s2d"></label></div></td></tr>
                                    <tr><td>Payment Gateway Setting</td><td><div class="sp-check-wrap view"><input type="checkbox" id="s3v"><label for="s3v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="s3c"><label for="s3c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="s3e"><label for="s3e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="s3d"><label for="s3d"></label></div></td></tr>
                                    <tr><td>SMS Setting</td><td><div class="sp-check-wrap view"><input type="checkbox" id="s4v"><label for="s4v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="s4c"><label for="s4c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="s4e"><label for="s4e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="s4d"><label for="s4d"></label></div></td></tr>
                                    <tr><td>Tax & Invoice Setting</td><td><div class="sp-check-wrap view"><input type="checkbox" id="s5v"><label for="s5v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="s5c"><label for="s5c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="s5e"><label for="s5e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="s5d"><label for="s5d"></label></div></td></tr>
                                    <tr><td>Courier Management</td><td><div class="sp-check-wrap view"><input type="checkbox" id="s6v"><label for="s6v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="s6c"><label for="s6c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="s6e"><label for="s6e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="s6d"><label for="s6d"></label></div></td></tr>
                                    <tr><td>Social Media Setting</td><td><div class="sp-check-wrap view"><input type="checkbox" id="s7v"><label for="s7v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="s7c"><label for="s7c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="s7e"><label for="s7e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="s7d"><label for="s7d"></label></div></td></tr>

                                    <!-- REPORTS -->
                                    <tr class="sp-select-all-row">
                                        <td colspan="5">
                                            <i class="fa fa-chart-bar" style="margin-right:6px"></i> Reports
                                            <button type="button" onclick="selectSection('reports')" style="margin-left:10px;font-size:11px;color:var(--sp-accent);background:none;border:none;cursor:pointer;font-weight:600;font-family:var(--sp-font)">Select All</button>
                                        </td>
                                    </tr>
                                    <tr><td>Sales Report</td><td><div class="sp-check-wrap view"><input type="checkbox" id="r1v"><label for="r1v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="r1c"><label for="r1c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="r1e"><label for="r1e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="r1d"><label for="r1d"></label></div></td></tr>
                                    <tr><td>Customer Report</td><td><div class="sp-check-wrap view"><input type="checkbox" id="r2v"><label for="r2v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="r2c"><label for="r2c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="r2e"><label for="r2e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="r2d"><label for="r2d"></label></div></td></tr>
                                    <tr><td>Stock Reports</td><td><div class="sp-check-wrap view"><input type="checkbox" id="r3v"><label for="r3v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="r3c"><label for="r3c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="r3e"><label for="r3e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="r3d"><label for="r3d"></label></div></td></tr>

                                    <!-- NOTIFICATIONS -->
                                    <tr class="sp-select-all-row">
                                        <td colspan="5">
                                            <i class="fa fa-bell" style="margin-right:6px"></i> Notifications
                                            <button type="button" onclick="selectSection('notif')" style="margin-left:10px;font-size:11px;color:var(--sp-accent);background:none;border:none;cursor:pointer;font-weight:600;font-family:var(--sp-font)">Select All</button>
                                        </td>
                                    </tr>
                                    <tr><td>Notifications</td><td><div class="sp-check-wrap view"><input type="checkbox" id="n1v"><label for="n1v"></label></div></td><td><div class="sp-check-wrap create"><input type="checkbox" id="n1c"><label for="n1c"></label></div></td><td><div class="sp-check-wrap edit"><input type="checkbox" id="n1e"><label for="n1e"></label></div></td><td><div class="sp-check-wrap delete"><input type="checkbox" id="n1d"><label for="n1d"></label></div></td></tr>

                                </tbody>
                            </table>

                        </div>
                    </div>

                </div>

                <!-- RIGHT — sidebar -->
                <div>

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

                    <div class="sp-card">
                        <div class="sp-card-header"><h5>Legend</h5></div>
                        <div class="sp-card-body-sm">
                            <div class="sp-legend">
                                <div class="sp-legend-item"><span class="sp-legend-dot" style="background:#0069d9"></span> View</div>
                                <div class="sp-legend-item"><span class="sp-legend-dot" style="background:var(--sp-green)"></span> Create</div>
                                <div class="sp-legend-item"><span class="sp-legend-dot" style="background:#916a00"></span> Edit</div>
                                <div class="sp-legend-item"><span class="sp-legend-dot" style="background:var(--sp-red)"></span> Delete</div>
                            </div>
                        </div>
                    </div>

                    <div class="sp-card">
                        <div class="sp-card-header"><h5>Quick Actions</h5></div>
                        <div class="sp-card-body-sm" style="display:flex;flex-direction:column;gap:8px">
                            <button onclick="selectAll()" style="display:inline-flex;align-items:center;gap:8px;font-size:13px;color:var(--sp-green);background:var(--sp-green-bg);border:1px solid var(--sp-green-border,#9fcfc3);border-radius:var(--sp-radius-md);padding:7px 12px;cursor:pointer;font-family:var(--sp-font);font-weight:560;width:100%">
                                <i class="fa fa-check-square"></i> Select All Permissions
                            </button>
                            <button onclick="clearAll()" style="display:inline-flex;align-items:center;gap:8px;font-size:13px;color:var(--sp-red);background:var(--sp-red-bg);border:1px solid #f5b8b8;border-radius:var(--sp-radius-md);padding:7px 12px;cursor:pointer;font-family:var(--sp-font);font-weight:560;width:100%">
                                <i class="fa fa-square"></i> Clear All Permissions
                            </button>
                            <button onclick="selectViewOnly()" style="display:inline-flex;align-items:center;gap:8px;font-size:13px;color:#0069d9;background:#e8f2ff;border:1px solid #a8cdf5;border-radius:var(--sp-radius-md);padding:7px 12px;cursor:pointer;font-family:var(--sp-font);font-weight:560;width:100%">
                                <i class="fa fa-eye"></i> View Only
                            </button>
                        </div>
                    </div>

                    <div class="sp-card">
                        <div class="sp-card-header"><h5>Summary</h5></div>
                        <div class="sp-card-body-sm">
                            <div style="font-size:13px;color:var(--sp-text-secondary);line-height:1.8">
                                <div style="display:flex;justify-content:space-between">
                                    <span>Total Modules</span>
                                    <strong style="color:var(--sp-text-primary)">38</strong>
                                </div>
                                <div style="display:flex;justify-content:space-between">
                                    <span>Selected</span>
                                    <strong style="color:var(--sp-accent)" id="selectedCount">0</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <div class="sp-action-bar">
                <a href="role-permissions-index.html" class="sp-btn-secondary">Cancel</a>
                <button class="sp-btn-primary" onclick="savePermissions()">
                    <i class="fa fa-save"></i> Save Permissions
                </button>
            </div>

        </div>
    </div>
</div>

@include('admin.footer')

<script>
function getAll() { return document.querySelectorAll('.sp-check-wrap input[type=checkbox]'); }

function updateCount() {
    const checked = document.querySelectorAll('.sp-check-wrap input:checked').length;
    document.getElementById('selectedCount').textContent = checked;
}

function selectAll() { getAll().forEach(cb => cb.checked = true); updateCount(); }
function clearAll()  { getAll().forEach(cb => cb.checked = false); updateCount(); }
function selectViewOnly() {
    getAll().forEach(cb => cb.checked = false);
    document.querySelectorAll('.sp-check-wrap.view input').forEach(cb => cb.checked = true);
    updateCount();
}

function selectSection(section) {
    const map = {
        master:'m', products:'p', orders:'o', content:'c',
        enquiries:'e', marketing:'mk', settings:'s', reports:'r', notif:'n'
    };
    const prefix = map[section];
    document.querySelectorAll(`input[id^="${prefix}"]`).forEach(cb => {
        if (cb.closest('.sp-check-wrap')) cb.checked = true;
    });
    updateCount();
}

document.querySelectorAll('.sp-check-wrap input').forEach(cb => {
    cb.addEventListener('change', updateCount);
});

function savePermissions() {
    const role = document.getElementById('roleSelect').value;
    if (!role) { alert('Please select a role category first.'); return; }
    Swal.fire({ icon: 'success', title: 'Saved!', text: 'Permissions have been saved successfully.', timer: 1800, showConfirmButton: false });
}
</script>