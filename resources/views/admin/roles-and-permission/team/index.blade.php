@include('admin.top-header')
<div class="main-section">
    @include('admin.header')

    <style>
    :root {
        --bg: #f1f2f4; --surface: #ffffff; --border: #e3e5e8; --border-hover: #c9cccf;
        --text-primary: #202223; --text-secondary: #6d7175; --text-hint: #8c9196; --text-disabled: #babec3;
        --navy: #303d89; --navy-hover: #252f70; --navy-light: #eef0fc; --navy-border: #c5c9ef;
        --green: #007a5e; --green-bg: #e3f1ec; --green-border: #9fcfc3;
        --red: #c0392b; --red-bg: #fce8e8; --red-border: #f5b8b8;
        --amber: #916a00; --amber-bg: #fff5cc; --amber-border: #e8d080;
        --blue: #0069d9; --blue-bg: #e8f2ff; --blue-border: #a8cdf5;
        --purple: #6d28d9; --purple-bg: #ede9fe; --purple-border: #c4b5fd;
        --radius-sm: 6px; --radius-md: 8px; --radius-lg: 12px;
        --shadow: 0 1px 0 rgba(0,0,0,.05), 0 0 0 1px rgba(0,0,0,.07);
        --font: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }
    .sp-page { background: var(--bg); padding: 24px 28px; min-height: 100vh; font-family: var(--font); color: var(--text-primary); font-size: 14px; }
    .sp-page * { box-sizing: border-box; }

    /* ── Page header ── */
    .sp-page-header { display: flex; align-items: flex-start; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 20px; }
    .sp-page-title { font-size: 20px; font-weight: 660; margin: 0 0 4px; letter-spacing: -.2px; }
    .sp-crumb { font-size: 12.5px; color: var(--text-hint); display: flex; align-items: center; gap: 4px; flex-wrap: wrap; }
    .sp-crumb a { color: var(--navy); text-decoration: none; font-weight: 500; }
    .sp-crumb a:hover { text-decoration: underline; }
    .sp-crumb-sep { color: var(--border-hover); }

    /* ── KPI strip ── */
    .sp-kpi-strip { display: grid; grid-template-columns: repeat(4,1fr); gap: 14px; margin-bottom: 20px; }
    @media(max-width:900px) { .sp-kpi-strip { grid-template-columns: repeat(2,1fr); } }
    .sp-kpi { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 16px 18px 14px; box-shadow: var(--shadow); }
    .sp-kpi-top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px; }
    .sp-kpi-label { font-size: 11px; font-weight: 700; color: var(--text-hint); text-transform: uppercase; letter-spacing: .06em; }
    .sp-kpi-icon { width: 34px; height: 34px; border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center; font-size: 14px; }
    .sp-kpi-icon.blue   { background: var(--blue-bg);   color: var(--blue); }
    .sp-kpi-icon.green  { background: var(--green-bg);  color: var(--green); }
    .sp-kpi-icon.amber  { background: var(--amber-bg);  color: var(--amber); }
    .sp-kpi-icon.purple { background: var(--purple-bg); color: var(--purple); }
    .sp-kpi-value { font-size: 26px; font-weight: 760; color: var(--text-primary); line-height: 1; margin-bottom: 4px; }
    .sp-kpi-sub { font-size: 11.5px; color: var(--text-hint); }

    /* ── Main card ── */
    .sp-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-lg); box-shadow: var(--shadow); overflow: hidden; }

    /* ── Toolbar ── */
    .sp-toolbar { padding: 12px 16px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; gap: 10px; flex-wrap: wrap; background: #fafafa; }
    .sp-toolbar-left  { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
    .sp-toolbar-right { display: flex; align-items: center; gap: 8px; }

    /* Search */
    .sp-search-wrap { position: relative; }
    .sp-search { height: 34px; border: 1px solid var(--border); border-radius: var(--radius-md); padding: 0 12px 0 32px; font-size: 12.5px; color: var(--text-primary); background: var(--surface); outline: none; font-family: var(--font); width: 220px; transition: border-color .15s, box-shadow .15s; }
    .sp-search:focus { border-color: var(--navy); box-shadow: 0 0 0 3px rgba(48,61,137,.1); }
    .sp-search-ico { position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--text-hint); font-size: 12px; pointer-events: none; }

    /* Filter select */
    .sp-filter-sel { height: 34px; border: 1px solid var(--border); border-radius: var(--radius-md); padding: 0 28px 0 10px; font-size: 12.5px; color: var(--text-secondary); background: var(--surface); outline: none; font-family: var(--font); appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%238c9196'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right 9px center; cursor: pointer; transition: border-color .15s; }
    .sp-filter-sel:focus { border-color: var(--navy); outline: none; }

    /* Buttons */
    .sp-btn { display: inline-flex; align-items: center; gap: 6px; border-radius: var(--radius-md); padding: 8px 16px; font-size: 13px; font-weight: 580; font-family: var(--font); cursor: pointer; text-decoration: none; line-height: 1.4; transition: background .15s; white-space: nowrap; border: 1px solid transparent; }
    .sp-btn-primary { background: var(--navy); color: #fff !important; border-color: var(--navy-hover); box-shadow: 0 1px 3px rgba(48,61,137,.25); }
    .sp-btn-primary:hover { background: var(--navy-hover); color: #fff; }
    .sp-btn-sm { height: 30px; padding: 0 10px; font-size: 12px; display: inline-flex; align-items: center; gap: 5px; border-radius: var(--radius-sm); border: 1px solid var(--border); background: var(--surface); color: var(--text-secondary); cursor: pointer; font-family: var(--font); font-weight: 500; transition: all .12s; text-decoration: none; white-space: nowrap; }
    .sp-btn-sm:hover { background: var(--bg); border-color: var(--border-hover); color: var(--text-primary); text-decoration: none; }
    .sp-btn-sm svg { width: 13px; height: 13px; flex-shrink: 0; }

    /* ── Table ── */
    .sp-table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
    .sp-table thead th { font-size: 11px; font-weight: 650; letter-spacing: .055em; text-transform: uppercase; color: var(--text-hint); padding: 10px 16px; border-bottom: 1px solid var(--border); background: #fafafa; text-align: left; white-space: nowrap; }
    .sp-table tbody tr { border-bottom: 1px solid var(--border); transition: background .1s; }
    .sp-table tbody tr:last-child { border-bottom: none; }
    .sp-table tbody tr:hover { background: #f7f8fb; }
    .sp-table td { padding: 13px 16px; vertical-align: middle; color: var(--text-primary); }

    /* Avatar */
    .sp-av { width: 38px; height: 38px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 700; flex-shrink: 0; color: #fff; }
    .sp-av-wrap { display: flex; align-items: center; gap: 10px; }
    .sp-av-name  { font-size: 13.5px; font-weight: 600; color: var(--text-primary); line-height: 1.3; }
    .sp-av-email { font-size: 11.5px; color: var(--text-hint); margin-top: 2px; }

    /* ID chip */
    .sp-id { display: inline-flex; align-items: center; justify-content: center; min-width: 28px; height: 22px; padding: 0 7px; background: var(--bg); border: 1px solid var(--border); border-radius: 5px; font-size: 11.5px; font-weight: 600; color: var(--text-secondary); font-family: 'SF Mono','Fira Code',monospace; }

    /* Role badge */
    .sp-role-badge { display: inline-flex; align-items: center; gap: 5px; font-size: 11.5px; font-weight: 620; padding: 3px 9px; border-radius: 20px; white-space: nowrap; }
    .sp-role-badge.super-admin { background: var(--navy-light); color: var(--navy); border: 1px solid var(--navy-border); }
    .sp-role-badge.manager     { background: var(--blue-bg);    color: var(--blue);  border: 1px solid var(--blue-border); }
    .sp-role-badge.editor      { background: var(--purple-bg);  color: var(--purple);border: 1px solid var(--purple-border); }
    .sp-role-badge.support     { background: var(--green-bg);   color: var(--green); border: 1px solid var(--green-border); }
    .sp-role-badge.custom      { background: var(--amber-bg);   color: var(--amber); border: 1px solid var(--amber-border); }

    /* Status pill */
    .sp-pill { display: inline-flex; align-items: center; gap: 5px; font-size: 11.5px; font-weight: 620; padding: 3px 9px; border-radius: 20px; white-space: nowrap; }
    .sp-pill::before { content: ''; width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
    .sp-pill-active   { background: var(--green-bg);  color: var(--green); } .sp-pill-active::before   { background: var(--green); }
    .sp-pill-inactive { background: var(--red-bg);    color: var(--red);   } .sp-pill-inactive::before { background: var(--red); }

    /* Custom perm badge */
    .sp-custom-badge { display: inline-flex; align-items: center; gap: 4px; font-size: 10.5px; font-weight: 700; padding: 2px 7px; border-radius: 20px; background: var(--amber-bg); color: var(--amber); border: 1px solid var(--amber-border); }

    /* Last login */
    .sp-login-info { font-size: 12px; color: var(--text-secondary); line-height: 1.5; }
    .sp-login-info span { display: block; color: var(--text-hint); font-size: 11px; }

    /* ── Actions column ── */
    .sp-actions { display: flex; align-items: center; gap: 5px; }
    .sp-act-btn { display: inline-flex; align-items: center; justify-content: center; width: 30px; height: 30px; border-radius: var(--radius-sm); border: 1px solid var(--border); background: var(--surface); color: var(--text-secondary); cursor: pointer; text-decoration: none; transition: all .12s; font-size: 12.5px; flex-shrink: 0; }
    .sp-act-btn:hover { background: var(--bg); border-color: var(--border-hover); color: var(--text-primary); text-decoration: none; }
    .sp-act-btn.edit:hover     { background: var(--navy-light); border-color: var(--navy-border); color: var(--navy); }
    .sp-act-btn.perm:hover     { background: var(--amber-bg);   border-color: var(--amber-border); color: var(--amber); }
    .sp-act-btn.password:hover { background: var(--blue-bg);    border-color: var(--blue-border);  color: var(--blue); }
    .sp-act-btn.danger:hover   { background: var(--red-bg);     border-color: var(--red-border);   color: var(--red); }

    /* Tooltip */
    .sp-act-btn { position: relative; }
    .sp-act-btn[title]:hover::after { content: attr(title); position: absolute; bottom: calc(100% + 6px); left: 50%; transform: translateX(-50%); background: #202223; color: #fff; font-size: 11px; font-weight: 500; white-space: nowrap; padding: 4px 8px; border-radius: 5px; pointer-events: none; z-index: 10; font-family: var(--font); }

    /* Divider in actions */
    .sp-act-divider { width: 1px; height: 20px; background: var(--border); flex-shrink: 0; }

    /* ── Empty state ── */
    .sp-empty { padding: 56px 24px; text-align: center; }
    .sp-empty-icon { width: 52px; height: 52px; background: var(--bg); border: 1px solid var(--border); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 14px; font-size: 20px; color: var(--text-disabled); }
    .sp-empty-title { font-size: 14px; font-weight: 650; margin: 0 0 4px; }
    .sp-empty-sub   { font-size: 13px; color: var(--text-secondary); margin: 0 0 16px; }

    /* ── Pagination ── */
    .sp-pagination { padding: 13px 20px; border-top: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; background: var(--surface); }
    .sp-pag-info { font-size: 12.5px; color: var(--text-hint); }
    .sp-pag-btns { display: flex; gap: 4px; }
    .sp-pag-btn { display: inline-flex; align-items: center; justify-content: center; min-width: 32px; height: 32px; padding: 0 6px; border: 1px solid var(--border); border-radius: var(--radius-md); background: var(--surface); color: var(--text-secondary); font-size: 12.5px; font-weight: 500; cursor: pointer; font-family: var(--font); transition: all .12s; }
    .sp-pag-btn:hover:not(:disabled) { background: var(--bg); border-color: var(--border-hover); color: var(--text-primary); }
    .sp-pag-btn.active { background: var(--navy); border-color: var(--navy); color: #fff; }
    .sp-pag-btn:disabled { opacity: .35; cursor: not-allowed; }

    /* ── Modal overlay ── */
    .sp-modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.45); z-index: 1000; align-items: center; justify-content: center; padding: 20px; }
    .sp-modal-overlay.open { display: flex; }
    .sp-modal { background: var(--surface); border-radius: var(--radius-lg); box-shadow: 0 20px 60px rgba(0,0,0,.2); width: 100%; max-width: 420px; overflow: hidden; animation: modalIn .2s ease; }
    @keyframes modalIn { from { opacity:0; transform:translateY(-12px); } to { opacity:1; transform:none; } }
    .sp-modal-header { padding: 16px 20px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
    .sp-modal-title { font-size: 15px; font-weight: 660; color: var(--text-primary); margin: 0; }
    .sp-modal-close { width: 28px; height: 28px; border-radius: var(--radius-sm); border: none; background: var(--bg); color: var(--text-hint); cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 14px; transition: background .12s; }
    .sp-modal-close:hover { background: var(--border); }
    .sp-modal-body { padding: 20px; }
    .sp-modal-footer { padding: 14px 20px; border-top: 1px solid var(--border); display: flex; justify-content: flex-end; gap: 8px; }

    /* Modal field */
    .sp-field { margin-bottom: 16px; }
    .sp-field:last-child { margin-bottom: 0; }
    .sp-label { display: block; font-size: 11.5px; font-weight: 650; color: var(--text-secondary); letter-spacing: .04em; text-transform: uppercase; margin-bottom: 6px; }
    .sp-input { width: 100%; height: 38px; border: 1px solid var(--border); border-radius: var(--radius-md); padding: 0 12px; font-size: 13.5px; color: var(--text-primary); background: var(--surface); outline: none; font-family: var(--font); transition: border-color .15s, box-shadow .15s; }
    .sp-input:focus { border-color: var(--navy); box-shadow: 0 0 0 3px rgba(48,61,137,.1); }
    .sp-input-icon-wrap { position: relative; }
    .sp-input-icon-wrap .sp-input { padding-right: 38px; }
    .sp-input-toggle { position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--text-hint); cursor: pointer; font-size: 13px; }

    /* Modal member info */
    .sp-member-info { display: flex; align-items: center; gap: 12px; background: var(--bg); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 10px 14px; margin-bottom: 20px; }
    .sp-member-info .sp-av { width: 40px; height: 40px; font-size: 14px; flex-shrink: 0; }
    .sp-member-info-name  { font-size: 13.5px; font-weight: 650; color: var(--text-primary); }
    .sp-member-info-email { font-size: 12px; color: var(--text-hint); margin-top: 2px; }

    .sp-btn-modal-primary { display: inline-flex; align-items: center; gap: 6px; background: var(--navy); color: #fff; border: none; border-radius: var(--radius-md); padding: 8px 16px; font-size: 13px; font-weight: 600; cursor: pointer; font-family: var(--font); transition: background .15s; }
    .sp-btn-modal-primary:hover { background: var(--navy-hover); }
    .sp-btn-modal-primary.danger { background: var(--red); }
    .sp-btn-modal-primary.danger:hover { background: #a93226; }
    .sp-btn-modal-secondary { display: inline-flex; align-items: center; gap: 6px; background: var(--surface); color: var(--text-primary); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 8px 16px; font-size: 13px; font-weight: 500; cursor: pointer; font-family: var(--font); transition: all .15s; }
    .sp-btn-modal-secondary:hover { background: var(--bg); border-color: var(--border-hover); }

    .sp-pw-strength { height: 4px; border-radius: 4px; margin-top: 8px; background: var(--border); overflow: hidden; }
    .sp-pw-strength-fill { height: 100%; border-radius: 4px; transition: width .3s, background .3s; }
    .sp-pw-hint { font-size: 11.5px; color: var(--text-hint); margin-top: 5px; }

    @media(max-width:768px) { .sp-page { padding: 16px; } .sp-search { width: 160px; } }
    </style>

    <div class="app-content content container-fluid">
        <div class="sp-page">

            <!-- Page header -->
            <div class="sp-page-header">
                <div>
                    <h1 class="sp-page-title">Team Members</h1>
                    <div class="sp-crumb">
                        <a href="#">Dashboard</a>
                        <span class="sp-crumb-sep">›</span>
                        <a href="#">Roles &amp; Settings</a>
                        <span class="sp-crumb-sep">›</span>
                        <span>Team Members</span>
                    </div>
                </div>
                <a href="#" class="sp-btn sp-btn-primary">
                    <i class="fa fa-plus"></i> Add Team Member
                </a>
            </div>

            <!-- KPI strip -->
            <div class="sp-kpi-strip">
                <div class="sp-kpi">
                    <div class="sp-kpi-top">
                        <span class="sp-kpi-label">Total Members</span>
                        <div class="sp-kpi-icon blue"><i class="fa fa-users"></i></div>
                    </div>
                    <div class="sp-kpi-value">12</div>
                    <div class="sp-kpi-sub">Across all roles</div>
                </div>
                <div class="sp-kpi">
                    <div class="sp-kpi-top">
                        <span class="sp-kpi-label">Active</span>
                        <div class="sp-kpi-icon green"><i class="fa fa-user-check"></i></div>
                    </div>
                    <div class="sp-kpi-value">10</div>
                    <div class="sp-kpi-sub">Currently active</div>
                </div>
                <div class="sp-kpi">
                    <div class="sp-kpi-top">
                        <span class="sp-kpi-label">Role Categories</span>
                        <div class="sp-kpi-icon purple"><i class="fa fa-shield"></i></div>
                    </div>
                    <div class="sp-kpi-value">4</div>
                    <div class="sp-kpi-sub">Defined roles</div>
                </div>
                <div class="sp-kpi">
                    <div class="sp-kpi-top">
                        <span class="sp-kpi-label">Custom Permissions</span>
                        <div class="sp-kpi-icon amber"><i class="fa fa-sliders-h"></i></div>
                    </div>
                    <div class="sp-kpi-value">3</div>
                    <div class="sp-kpi-sub">Members with overrides</div>
                </div>
            </div>

            <!-- Main card -->
            <div class="sp-card">

                <!-- Toolbar -->
                <div class="sp-toolbar">
                    <div class="sp-toolbar-left">
                        <div class="sp-search-wrap">
                            <i class="fa fa-search sp-search-ico"></i>
                            <input type="text" class="sp-search" placeholder="Search members…" oninput="searchTable(this.value)">
                        </div>
                        <select class="sp-filter-sel" onchange="filterRole(this.value)">
                            <option value="">All Roles</option>
                            <option value="super-admin">Super Admin</option>
                            <option value="manager">Manager</option>
                            <option value="editor">Content Editor</option>
                            <option value="support">Support Agent</option>
                        </select>
                        <select class="sp-filter-sel" onchange="filterStatus(this.value)">
                            <option value="">All Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="sp-toolbar-right">
                        <span style="font-size:12.5px;color:var(--text-hint)"><span id="visibleCount">12</span> members</span>
                    </div>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="sp-table" id="teamTable">
                        <thead>
                            <tr>
                                <th style="width:52px">ID</th>
                                <th>Member</th>
                                <th>Role</th>
                                <th>Phone</th>
                                <th style="width:110px">Status</th>
                                <th>Last Login</th>
                                <th style="width:180px; text-align:center">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="teamTbody">

                            <!-- Row 1 -->
                            <tr data-name="rahul sharma" data-role="super-admin" data-status="active">
                                <td><span class="sp-id">#01</span></td>
                                <td>
                                    <div class="sp-av-wrap">
                                        <div class="sp-av" style="background:#303d89">RS</div>
                                        <div>
                                            <div class="sp-av-name">Rahul Sharma</div>
                                            <div class="sp-av-email">rahul.sharma@store.com</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="sp-role-badge super-admin"><i class="fa fa-shield" style="font-size:9px"></i> Super Admin</span>
                                </td>
                                <td style="color:var(--text-secondary);font-size:13px">+91 98765 43210</td>
                                <td><span class="sp-pill sp-pill-active">Active</span></td>
                                <td>
                                    <div class="sp-login-info">
                                        Today, 10:42 AM
                                        <span>192.168.1.1 · Chrome / Windows</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="sp-actions" style="justify-content:center">
                                        <a href="#" class="sp-act-btn edit" title="Edit Member"><i class="fa fa-pencil"></i></a>
                                        <a href="#" class="sp-act-btn perm" title="Custom Permissions" onclick="openPermModal('Rahul Sharma','#303d89','RS');return false"><i class="fa fa-sliders-h"></i></a>
                                        <button class="sp-act-btn password" title="Change Password" onclick="openPasswordModal('Rahul Sharma','#303d89','RS')"><i class="fa fa-key"></i></button>
                                        <span class="sp-act-divider"></span>
                                        <button class="sp-act-btn danger" title="Delete Member" onclick="confirmDelete('Rahul Sharma')"><i class="fa fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Row 2 -->
                            <tr data-name="priya verma" data-role="manager" data-status="active">
                                <td><span class="sp-id">#02</span></td>
                                <td>
                                    <div class="sp-av-wrap">
                                        <div class="sp-av" style="background:#0069d9">PV</div>
                                        <div>
                                            <div class="sp-av-name">
                                                Priya Verma
                                                <span class="sp-custom-badge" style="margin-left:6px"><i class="fa fa-star" style="font-size:8px"></i> Custom</span>
                                            </div>
                                            <div class="sp-av-email">priya.verma@store.com</div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="sp-role-badge manager"><i class="fa fa-user-tie" style="font-size:9px"></i> Manager</span></td>
                                <td style="color:var(--text-secondary);font-size:13px">+91 91234 56789</td>
                                <td><span class="sp-pill sp-pill-active">Active</span></td>
                                <td>
                                    <div class="sp-login-info">
                                        Today, 9:15 AM
                                        <span>103.21.45.8 · Firefox / Mac</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="sp-actions" style="justify-content:center">
                                        <a href="#" class="sp-act-btn edit" title="Edit Member"><i class="fa fa-pencil"></i></a>
                                        <a href="#" class="sp-act-btn perm" title="Custom Permissions" onclick="openPermModal('Priya Verma','#0069d9','PV');return false"><i class="fa fa-sliders-h"></i></a>
                                        <button class="sp-act-btn password" title="Change Password" onclick="openPasswordModal('Priya Verma','#0069d9','PV')"><i class="fa fa-key"></i></button>
                                        <span class="sp-act-divider"></span>
                                        <button class="sp-act-btn danger" title="Delete Member" onclick="confirmDelete('Priya Verma')"><i class="fa fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Row 3 -->
                            <tr data-name="anjali mehta" data-role="editor" data-status="active">
                                <td><span class="sp-id">#03</span></td>
                                <td>
                                    <div class="sp-av-wrap">
                                        <div class="sp-av" style="background:#6d28d9">AM</div>
                                        <div>
                                            <div class="sp-av-name">Anjali Mehta</div>
                                            <div class="sp-av-email">anjali.mehta@store.com</div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="sp-role-badge editor"><i class="fa fa-pen" style="font-size:9px"></i> Content Editor</span></td>
                                <td style="color:var(--text-secondary);font-size:13px">+91 87654 32109</td>
                                <td><span class="sp-pill sp-pill-active">Active</span></td>
                                <td>
                                    <div class="sp-login-info">
                                        Yesterday, 6:30 PM
                                        <span>49.36.12.77 · Safari / iPhone</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="sp-actions" style="justify-content:center">
                                        <a href="#" class="sp-act-btn edit" title="Edit Member"><i class="fa fa-pencil"></i></a>
                                        <a href="#" class="sp-act-btn perm" title="Custom Permissions" onclick="openPermModal('Anjali Mehta','#6d28d9','AM');return false"><i class="fa fa-sliders-h"></i></a>
                                        <button class="sp-act-btn password" title="Change Password" onclick="openPasswordModal('Anjali Mehta','#6d28d9','AM')"><i class="fa fa-key"></i></button>
                                        <span class="sp-act-divider"></span>
                                        <button class="sp-act-btn danger" title="Delete Member" onclick="confirmDelete('Anjali Mehta')"><i class="fa fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Row 4 -->
                            <tr data-name="deepak gupta" data-role="support" data-status="active">
                                <td><span class="sp-id">#04</span></td>
                                <td>
                                    <div class="sp-av-wrap">
                                        <div class="sp-av" style="background:#007a5e">DG</div>
                                        <div>
                                            <div class="sp-av-name">
                                                Deepak Gupta
                                                <span class="sp-custom-badge" style="margin-left:6px"><i class="fa fa-star" style="font-size:8px"></i> Custom</span>
                                            </div>
                                            <div class="sp-av-email">deepak.gupta@store.com</div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="sp-role-badge support"><i class="fa fa-headset" style="font-size:9px"></i> Support Agent</span></td>
                                <td style="color:var(--text-secondary);font-size:13px">+91 76543 21098</td>
                                <td><span class="sp-pill sp-pill-active">Active</span></td>
                                <td>
                                    <div class="sp-login-info">
                                        Yesterday, 4:00 PM
                                        <span>122.176.45.9 · Chrome / Android</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="sp-actions" style="justify-content:center">
                                        <a href="#" class="sp-act-btn edit" title="Edit Member"><i class="fa fa-pencil"></i></a>
                                        <a href="#" class="sp-act-btn perm" title="Custom Permissions" onclick="openPermModal('Deepak Gupta','#007a5e','DG');return false"><i class="fa fa-sliders-h"></i></a>
                                        <button class="sp-act-btn password" title="Change Password" onclick="openPasswordModal('Deepak Gupta','#007a5e','DG')"><i class="fa fa-key"></i></button>
                                        <span class="sp-act-divider"></span>
                                        <button class="sp-act-btn danger" title="Delete Member" onclick="confirmDelete('Deepak Gupta')"><i class="fa fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Row 5 -->
                            <tr data-name="sneha patel" data-role="manager" data-status="active">
                                <td><span class="sp-id">#05</span></td>
                                <td>
                                    <div class="sp-av-wrap">
                                        <div class="sp-av" style="background:#c0392b">SP</div>
                                        <div>
                                            <div class="sp-av-name">Sneha Patel</div>
                                            <div class="sp-av-email">sneha.patel@store.com</div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="sp-role-badge manager"><i class="fa fa-user-tie" style="font-size:9px"></i> Manager</span></td>
                                <td style="color:var(--text-secondary);font-size:13px">+91 65432 10987</td>
                                <td><span class="sp-pill sp-pill-active">Active</span></td>
                                <td>
                                    <div class="sp-login-info">
                                        2 days ago
                                        <span>117.200.11.5 · Edge / Windows</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="sp-actions" style="justify-content:center">
                                        <a href="#" class="sp-act-btn edit" title="Edit Member"><i class="fa fa-pencil"></i></a>
                                        <a href="#" class="sp-act-btn perm" title="Custom Permissions" onclick="openPermModal('Sneha Patel','#c0392b','SP');return false"><i class="fa fa-sliders-h"></i></a>
                                        <button class="sp-act-btn password" title="Change Password" onclick="openPasswordModal('Sneha Patel','#c0392b','SP')"><i class="fa fa-key"></i></button>
                                        <span class="sp-act-divider"></span>
                                        <button class="sp-act-btn danger" title="Delete Member" onclick="confirmDelete('Sneha Patel')"><i class="fa fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Row 6 -->
                            <tr data-name="vikram singh" data-role="editor" data-status="inactive">
                                <td><span class="sp-id">#06</span></td>
                                <td>
                                    <div class="sp-av-wrap">
                                        <div class="sp-av" style="background:#916a00">VS</div>
                                        <div>
                                            <div class="sp-av-name">Vikram Singh</div>
                                            <div class="sp-av-email">vikram.singh@store.com</div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="sp-role-badge editor"><i class="fa fa-pen" style="font-size:9px"></i> Content Editor</span></td>
                                <td style="color:var(--text-secondary);font-size:13px">+91 54321 09876</td>
                                <td><span class="sp-pill sp-pill-inactive">Inactive</span></td>
                                <td>
                                    <div class="sp-login-info" style="color:var(--text-hint)">
                                        15 Jun 2025
                                        <span>103.45.67.8 · Chrome / Windows</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="sp-actions" style="justify-content:center">
                                        <a href="#" class="sp-act-btn edit" title="Edit Member"><i class="fa fa-pencil"></i></a>
                                        <a href="#" class="sp-act-btn perm" title="Custom Permissions" onclick="openPermModal('Vikram Singh','#916a00','VS');return false"><i class="fa fa-sliders-h"></i></a>
                                        <button class="sp-act-btn password" title="Change Password" onclick="openPasswordModal('Vikram Singh','#916a00','VS')"><i class="fa fa-key"></i></button>
                                        <span class="sp-act-divider"></span>
                                        <button class="sp-act-btn danger" title="Delete Member" onclick="confirmDelete('Vikram Singh')"><i class="fa fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Row 7 -->
                            <tr data-name="meera agarwal" data-role="support" data-status="active">
                                <td><span class="sp-id">#07</span></td>
                                <td>
                                    <div class="sp-av-wrap">
                                        <div class="sp-av" style="background:#2980b9">MA</div>
                                        <div>
                                            <div class="sp-av-name">
                                                Meera Agarwal
                                                <span class="sp-custom-badge" style="margin-left:6px"><i class="fa fa-star" style="font-size:8px"></i> Custom</span>
                                            </div>
                                            <div class="sp-av-email">meera.agarwal@store.com</div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="sp-role-badge support"><i class="fa fa-headset" style="font-size:9px"></i> Support Agent</span></td>
                                <td style="color:var(--text-secondary);font-size:13px">+91 43210 98765</td>
                                <td><span class="sp-pill sp-pill-active">Active</span></td>
                                <td>
                                    <div class="sp-login-info">
                                        Today, 8:00 AM
                                        <span>59.180.22.14 · Chrome / Mac</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="sp-actions" style="justify-content:center">
                                        <a href="#" class="sp-act-btn edit" title="Edit Member"><i class="fa fa-pencil"></i></a>
                                        <a href="#" class="sp-act-btn perm" title="Custom Permissions" onclick="openPermModal('Meera Agarwal','#2980b9','MA');return false"><i class="fa fa-sliders-h"></i></a>
                                        <button class="sp-act-btn password" title="Change Password" onclick="openPasswordModal('Meera Agarwal','#2980b9','MA')"><i class="fa fa-key"></i></button>
                                        <span class="sp-act-divider"></span>
                                        <button class="sp-act-btn danger" title="Delete Member" onclick="confirmDelete('Meera Agarwal')"><i class="fa fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Row 8 — Inactive -->
                            <tr data-name="karan malhotra" data-role="support" data-status="inactive">
                                <td><span class="sp-id">#08</span></td>
                                <td>
                                    <div class="sp-av-wrap">
                                        <div class="sp-av" style="background:#7f8c8d">KM</div>
                                        <div>
                                            <div class="sp-av-name">Karan Malhotra</div>
                                            <div class="sp-av-email">karan.m@store.com</div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="sp-role-badge support"><i class="fa fa-headset" style="font-size:9px"></i> Support Agent</span></td>
                                <td style="color:var(--text-secondary);font-size:13px">+91 32109 87654</td>
                                <td><span class="sp-pill sp-pill-inactive">Inactive</span></td>
                                <td>
                                    <div class="sp-login-info" style="color:var(--text-hint)">
                                        10 Jun 2025
                                        <span>106.51.14.88 · Safari / iPad</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="sp-actions" style="justify-content:center">
                                        <a href="#" class="sp-act-btn edit" title="Edit Member"><i class="fa fa-pencil"></i></a>
                                        <a href="#" class="sp-act-btn perm" title="Custom Permissions" onclick="openPermModal('Karan Malhotra','#7f8c8d','KM');return false"><i class="fa fa-sliders-h"></i></a>
                                        <button class="sp-act-btn password" title="Change Password" onclick="openPasswordModal('Karan Malhotra','#7f8c8d','KM')"><i class="fa fa-key"></i></button>
                                        <span class="sp-act-divider"></span>
                                        <button class="sp-act-btn danger" title="Delete Member" onclick="confirmDelete('Karan Malhotra')"><i class="fa fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="sp-pagination">
                    <span class="sp-pag-info">Showing 8 of 12 members</span>
                    <div class="sp-pag-btns">
                        <button class="sp-pag-btn" disabled><i class="fa fa-chevron-left"></i></button>
                        <button class="sp-pag-btn active">1</button>
                        <button class="sp-pag-btn">2</button>
                        <button class="sp-pag-btn"><i class="fa fa-chevron-right"></i></button>
                    </div>
                </div>

            </div><!-- /.sp-card -->

        </div>
    </div>
</div>

<!-- ══ Change Password Modal ══ -->
<div class="sp-modal-overlay" id="passwordModal">
    <div class="sp-modal">
        <div class="sp-modal-header">
            <h5 class="sp-modal-title"><i class="fa fa-key" style="margin-right:8px;color:var(--blue)"></i>Change Password</h5>
            <button class="sp-modal-close" onclick="closeModal('passwordModal')"><i class="fa fa-times"></i></button>
        </div>
        <div class="sp-modal-body">
            <div class="sp-member-info">
                <div class="sp-av" id="pwAv" style="background:#303d89;width:40px;height:40px;font-size:14px">RS</div>
                <div>
                    <div class="sp-member-info-name" id="pwName">Rahul Sharma</div>
                    <div class="sp-member-info-email">Admin Member</div>
                </div>
            </div>
            <div class="sp-field">
                <label class="sp-label">New Password <span style="color:var(--red)">*</span></label>
                <div class="sp-input-icon-wrap">
                    <input type="password" class="sp-input" id="newPassword" placeholder="Enter new password" oninput="checkStrength(this.value)">
                    <button class="sp-input-toggle" type="button" onclick="togglePw('newPassword',this)"><i class="fa fa-eye"></i></button>
                </div>
                <div class="sp-pw-strength"><div class="sp-pw-strength-fill" id="pwStrengthBar" style="width:0%;background:var(--red)"></div></div>
                <div class="sp-pw-hint" id="pwHint">Min. 8 characters with letters &amp; numbers</div>
            </div>
            <div class="sp-field">
                <label class="sp-label">Confirm Password <span style="color:var(--red)">*</span></label>
                <div class="sp-input-icon-wrap">
                    <input type="password" class="sp-input" id="confirmPassword" placeholder="Confirm new password">
                    <button class="sp-input-toggle" type="button" onclick="togglePw('confirmPassword',this)"><i class="fa fa-eye"></i></button>
                </div>
            </div>
        </div>
        <div class="sp-modal-footer">
            <button class="sp-btn-modal-secondary" onclick="closeModal('passwordModal')">Cancel</button>
            <button class="sp-btn-modal-primary" onclick="savePassword()"><i class="fa fa-save"></i> Update Password</button>
        </div>
    </div>
</div>

<!-- ══ Custom Permission Info Modal ══ -->
<div class="sp-modal-overlay" id="permModal">
    <div class="sp-modal">
        <div class="sp-modal-header">
            <h5 class="sp-modal-title"><i class="fa fa-sliders-h" style="margin-right:8px;color:var(--amber)"></i>Custom Permissions</h5>
            <button class="sp-modal-close" onclick="closeModal('permModal')"><i class="fa fa-times"></i></button>
        </div>
        <div class="sp-modal-body">
            <div class="sp-member-info">
                <div class="sp-av" id="permAv" style="background:#303d89;width:40px;height:40px;font-size:14px">RS</div>
                <div>
                    <div class="sp-member-info-name" id="permName">Rahul Sharma</div>
                    <div class="sp-member-info-email">Custom permission overrides active</div>
                </div>
            </div>
            <div style="background:var(--amber-bg);border:1px solid var(--amber-border);border-radius:var(--radius-md);padding:12px 14px;font-size:13px;color:var(--amber);line-height:1.6">
                <i class="fa fa-info-circle" style="margin-right:6px"></i>
                This member has custom permission overrides on top of their assigned role. You can manage these from the full permission editor.
            </div>
        </div>
        <div class="sp-modal-footer">
            <button class="sp-btn-modal-secondary" onclick="closeModal('permModal')">Cancel</button>
            <a href="#" class="sp-btn-modal-primary"><i class="fa fa-sliders-h"></i> Open Permission Editor</a>
        </div>
    </div>
</div>

@include('admin.footer')

<script>
/* ── Search & Filter ── */
function applyFilters() {
    const search = (document.querySelector('.sp-search').value || '').toLowerCase();
    const role   = document.querySelector('.sp-filter-sel').value;
    const status = document.querySelectorAll('.sp-filter-sel')[1].value;
    let visible  = 0;

    document.querySelectorAll('#teamTbody tr').forEach(row => {
        const name   = row.dataset.name   || '';
        const rRole  = row.dataset.role   || '';
        const rStat  = row.dataset.status || '';
        let show = true;
        if (search && !name.includes(search)) show = false;
        if (role   && rRole   !== role)       show = false;
        if (status && rStat   !== status)     show = false;
        row.style.display = show ? '' : 'none';
        if (show) visible++;
    });
    document.getElementById('visibleCount').textContent = visible;
}
function searchTable(v) { applyFilters(); }
function filterRole(v)   { applyFilters(); }
function filterStatus(v) { applyFilters(); }

/* ── Password modal ── */
function openPasswordModal(name, color, initials) {
    document.getElementById('pwName').textContent = name;
    document.getElementById('pwAv').textContent   = initials;
    document.getElementById('pwAv').style.background = color;
    document.getElementById('newPassword').value  = '';
    document.getElementById('confirmPassword').value = '';
    document.getElementById('pwStrengthBar').style.width = '0%';
    document.getElementById('pwHint').textContent = 'Min. 8 characters with letters & numbers';
    document.getElementById('passwordModal').classList.add('open');
}

function checkStrength(v) {
    const bar  = document.getElementById('pwStrengthBar');
    const hint = document.getElementById('pwHint');
    let score  = 0;
    if (v.length >= 8) score++;
    if (/[A-Z]/.test(v)) score++;
    if (/[0-9]/.test(v)) score++;
    if (/[^A-Za-z0-9]/.test(v)) score++;
    const map = [
        {w:'0%',  c:'var(--red)',   t:'Too short'},
        {w:'25%', c:'var(--red)',   t:'Weak'},
        {w:'50%', c:'var(--amber)', t:'Fair'},
        {w:'75%', c:'var(--blue)',  t:'Good'},
        {w:'100%',c:'var(--green)', t:'Strong'},
    ];
    bar.style.width      = map[score].w;
    bar.style.background = map[score].c;
    hint.textContent     = map[score].t;
}

function togglePw(id, btn) {
    const inp = document.getElementById(id);
    if (inp.type === 'password') { inp.type = 'text';     btn.innerHTML = '<i class="fa fa-eye-slash"></i>'; }
    else                         { inp.type = 'password'; btn.innerHTML = '<i class="fa fa-eye"></i>'; }
}

function savePassword() {
    const np = document.getElementById('newPassword').value;
    const cp = document.getElementById('confirmPassword').value;
    if (!np) { alert('Please enter a new password.'); return; }
    if (np !== cp) { alert('Passwords do not match.'); return; }
    closeModal('passwordModal');
    Swal.fire({ icon:'success', title:'Password Updated!', text:'The password has been changed successfully.', timer:1800, showConfirmButton:false });
}

/* ── Perm modal ── */
function openPermModal(name, color, initials) {
    document.getElementById('permName').textContent = name;
    document.getElementById('permAv').textContent   = initials;
    document.getElementById('permAv').style.background = color;
    document.getElementById('permModal').classList.add('open');
}

/* ── Delete ── */
function confirmDelete(name) {
    Swal.fire({
        title: 'Delete ' + name + '?',
        text: 'This will permanently remove the member and all their data.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#c0392b',
        cancelButtonColor: '#6d7175',
        confirmButtonText: 'Yes, Delete'
    }).then(r => {
        if (r.isConfirmed) Swal.fire({ icon:'success', title:'Deleted!', text: name + ' has been removed.', timer:1600, showConfirmButton:false });
    });
}

/* ── Close modal ── */
function closeModal(id) { document.getElementById(id).classList.remove('open'); }
document.querySelectorAll('.sp-modal-overlay').forEach(m => {
    m.addEventListener('click', e => { if (e.target === m) m.classList.remove('open'); });
});
</script>