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
    .sp-page-title  { font-size: 20px; font-weight: 660; margin: 0 0 4px; letter-spacing: -.2px; }
    .sp-crumb { font-size: 12.5px; color: var(--text-hint); display: flex; align-items: center; gap: 4px; flex-wrap: wrap; }
    .sp-crumb a { color: var(--navy); text-decoration: none; font-weight: 500; }
    .sp-crumb a:hover { text-decoration: underline; }
    .sp-crumb-sep { color: var(--border-hover); }

    /* ── Member identity chip (edit-only) ── */
    .sp-member-chip { display: flex; align-items: center; gap: 12px; background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 10px 16px; box-shadow: var(--shadow); }
    .sp-chip-av { width: 42px; height: 42px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 15px; font-weight: 700; color: #fff; flex-shrink: 0; }
    .sp-chip-name  { font-size: 14px; font-weight: 660; color: var(--text-primary); }
    .sp-chip-meta  { font-size: 12px; color: var(--text-hint); margin-top: 2px; }
    .sp-chip-pill  { display: inline-flex; align-items: center; gap: 4px; font-size: 11px; font-weight: 650; padding: 2px 8px; border-radius: 20px; margin-top: 4px; }
    .sp-chip-pill.active   { background: var(--green-bg); color: var(--green); border: 1px solid var(--green-border); }
    .sp-chip-pill.inactive { background: var(--red-bg);   color: var(--red);   border: 1px solid var(--red-border); }

    /* ── Layout ── */
    .sp-layout { display: grid; grid-template-columns: 320px 1fr; gap: 20px; align-items: start; }
    @media(max-width:1100px) { .sp-layout { grid-template-columns: 1fr; } }

    /* ── Cards ── */
    .sp-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-lg); box-shadow: var(--shadow); overflow: hidden; margin-bottom: 16px; }
    .sp-card:last-child { margin-bottom: 0; }
    .sp-card-header { padding: 13px 20px; border-bottom: 1px solid var(--border); background: #fafafa; display: flex; align-items: center; justify-content: space-between; gap: 10px; }
    .sp-card-header h5 { font-size: 13px; font-weight: 650; color: var(--text-primary); margin: 0; }
    .sp-card-body    { padding: 20px; }
    .sp-card-body-sm { padding: 14px 20px; }

    /* ── Avatar block ── */
    .sp-av-block { display: flex; flex-direction: column; align-items: center; padding: 20px 20px 16px; border-bottom: 1px solid var(--border); background: linear-gradient(135deg, var(--navy-light) 0%, var(--surface) 100%); position: relative; }
    .sp-av-circle { width: 72px; height: 72px; border-radius: 50%; background: var(--navy); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 24px; font-weight: 700; margin-bottom: 10px; border: 3px solid #fff; box-shadow: 0 2px 12px rgba(48,61,137,.2); }
    .sp-av-name-lbl { font-size: 14px; font-weight: 660; color: var(--text-primary); }
    .sp-av-role-lbl { font-size: 12px; color: var(--text-hint); margin-top: 3px; }
    .sp-member-id-badge { position: absolute; top: 12px; right: 14px; font-size: 11px; font-weight: 650; color: var(--navy); background: var(--navy-light); border: 1px solid var(--navy-border); border-radius: 20px; padding: 2px 9px; font-family: 'SF Mono','Fira Code',monospace; }

    /* ── Record info rows ── */
    .sp-info-row { display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px solid var(--bg); font-size: 12.5px; }
    .sp-info-row:first-child { padding-top: 0; }
    .sp-info-row:last-child  { border-bottom: none; padding-bottom: 0; }
    .sp-info-lbl { font-size: 11.5px; font-weight: 650; color: var(--text-hint); text-transform: uppercase; letter-spacing: .04em; }
    .sp-info-val { font-weight: 600; color: var(--text-primary); font-size: 12.5px; }

    /* ── Form fields ── */
    .sp-field { margin-bottom: 16px; }
    .sp-field:last-child { margin-bottom: 0; }
    .sp-label { display: block; font-size: 11.5px; font-weight: 650; color: var(--text-secondary); letter-spacing: .04em; text-transform: uppercase; margin-bottom: 6px; }
    .sp-req { color: var(--red); margin-left: 2px; }
    .sp-input, .sp-select, .sp-textarea {
        width: 100%; border: 1px solid var(--border); border-radius: var(--radius-md);
        padding: 0 12px; height: 38px; font-size: 13.5px; color: var(--text-primary);
        background: var(--surface); outline: none; font-family: var(--font);
        transition: border-color .15s, box-shadow .15s;
    }
    .sp-input:focus, .sp-select:focus, .sp-textarea:focus { border-color: var(--navy); box-shadow: 0 0 0 3px rgba(48,61,137,.10); }
    .sp-input::placeholder { color: var(--text-disabled); }
    .sp-select { appearance: none; -webkit-appearance: none; padding-right: 32px;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%238c9196'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right 10px center; cursor: pointer; }
    .sp-textarea { height: auto; padding: 10px 12px; resize: vertical; min-height: 80px; }
    .sp-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
    @media(max-width:600px) { .sp-grid-2 { grid-template-columns: 1fr; } }

    /* ── Changed indicator on field ── */
    .sp-input.changed, .sp-select.changed { border-color: var(--amber); box-shadow: 0 0 0 3px rgba(145,106,0,.10); }

    /* ── Role cards ── */
    .sp-role-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
    .sp-role-opt { border: 2px solid var(--border); border-radius: var(--radius-md); padding: 12px 14px; cursor: pointer; transition: all .15s; position: relative; }
    .sp-role-opt:hover { border-color: var(--navy); background: var(--navy-light); }
    .sp-role-opt.selected { border-color: var(--navy); background: var(--navy-light); }
    .sp-role-opt input[type=radio] { position: absolute; opacity: 0; width: 0; height: 0; }
    .sp-role-opt-icon { width: 30px; height: 30px; border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center; font-size: 13px; margin-bottom: 8px; }
    .sp-role-opt-name { font-size: 12.5px; font-weight: 650; color: var(--text-primary); }
    .sp-role-opt-desc { font-size: 11px; color: var(--text-hint); margin-top: 2px; line-height: 1.4; }
    .sp-role-opt-check { position: absolute; top: 8px; right: 8px; width: 16px; height: 16px; border-radius: 50%; border: 2px solid var(--border); background: var(--surface); display: flex; align-items: center; justify-content: center; transition: all .15s; }
    .sp-role-opt.selected .sp-role-opt-check { background: var(--navy); border-color: var(--navy); }
    .sp-role-opt.selected .sp-role-opt-check::after { content: ''; display: block; width: 5px; height: 5px; border-radius: 50%; background: #fff; }

    /* ── Toggle switch ── */
    .sp-toggle-row { display: flex; align-items: center; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid var(--bg); }
    .sp-toggle-row:first-child { padding-top: 0; }
    .sp-toggle-row:last-child  { border-bottom: none; padding-bottom: 0; }
    .sp-toggle-label { font-size: 13px; font-weight: 500; color: var(--text-primary); }
    .sp-toggle-sub   { font-size: 11.5px; color: var(--text-hint); margin-top: 2px; }
    .sp-switch { position: relative; width: 38px; height: 22px; flex-shrink: 0; }
    .sp-switch input { opacity: 0; width: 0; height: 0; position: absolute; }
    .sp-switch-track { position: absolute; inset: 0; background: var(--border); border-radius: 22px; cursor: pointer; transition: background .2s; }
    .sp-switch-track::after { content: ''; position: absolute; left: 3px; top: 3px; width: 16px; height: 16px; background: #fff; border-radius: 50%; transition: transform .2s; box-shadow: 0 1px 3px rgba(0,0,0,.2); }
    .sp-switch input:checked + .sp-switch-track { background: var(--navy); }
    .sp-switch input:checked + .sp-switch-track::after { transform: translateX(16px); }

    /* ── Unsaved changes badge ── */
    .sp-unsaved { display: none; align-items: center; gap: 5px; font-size: 11.5px; font-weight: 650; padding: 3px 10px; border-radius: 20px; background: var(--amber-bg); color: var(--amber); border: 1px solid var(--amber-border); }
    .sp-unsaved.show { display: inline-flex; }

    /* ── Permission section (right) ── */
    .sp-perm-notice { display: flex; align-items: flex-start; gap: 10px; background: var(--blue-bg); border: 1px solid var(--blue-border); border-radius: var(--radius-md); padding: 11px 14px; font-size: 12.5px; color: var(--blue); line-height: 1.6; margin-bottom: 16px; }

    .sp-custom-perm-toggle { display: flex; align-items: center; justify-content: space-between; padding: 12px 14px; background: var(--amber-bg); border: 1px solid var(--amber-border); border-radius: var(--radius-md); margin-bottom: 16px; }
    .sp-custom-perm-label { font-size: 13px; font-weight: 650; color: var(--amber); }
    .sp-custom-perm-sub   { font-size: 11.5px; color: var(--amber); opacity: .8; margin-top: 2px; }

    .sp-matrix-wrap { }
    .sp-matrix-wrap.hidden { display: none; }

    /* Legend & quick actions */
    .sp-legend { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 14px; }
    .sp-legend-item { display: flex; align-items: center; gap: 5px; font-size: 12px; color: var(--text-secondary); }
    .sp-legend-dot  { width: 10px; height: 10px; border-radius: 3px; }
    .sp-quick-btns { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 16px; }
    .sp-quick-btn { display: inline-flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 600; padding: 5px 12px; border-radius: 20px; cursor: pointer; border: 1px solid; font-family: var(--font); transition: opacity .15s; }
    .sp-quick-btn:hover { opacity: .82; }
    .sp-quick-btn.all      { background: var(--green-bg);  color: var(--green);  border-color: var(--green-border); }
    .sp-quick-btn.clear    { background: var(--red-bg);    color: var(--red);    border-color: var(--red-border); }
    .sp-quick-btn.viewonly { background: var(--blue-bg);   color: var(--blue);   border-color: var(--blue-border); }
    .sp-quick-btn.reset    { background: var(--amber-bg);  color: var(--amber);  border-color: var(--amber-border); }

    /* Matrix table */
    .sp-matrix-table { width: 100%; border-collapse: collapse; }
    .sp-matrix-table thead th { font-size: 11px; font-weight: 650; letter-spacing: .05em; text-transform: uppercase; color: var(--text-hint); padding: 8px 10px; border-bottom: 1px solid var(--border); background: #fafafa; text-align: center; }
    .sp-matrix-table thead th:first-child { text-align: left; width: 40%; }
    .sp-matrix-table tbody tr { border-bottom: 1px solid var(--border); transition: background .1s; }
    .sp-matrix-table tbody tr:last-child { border-bottom: none; }
    .sp-matrix-table tbody tr:hover { background: #f7f8f9; }
    .sp-matrix-table td { padding: 9px 10px; vertical-align: middle; text-align: center; }
    .sp-matrix-table td:first-child { text-align: left; font-size: 13px; color: var(--text-primary); font-weight: 500; }
    .sp-grp-row td { background: #f5f6fe; font-size: 11.5px; font-weight: 650; color: var(--navy); padding: 7px 10px; border-bottom: 1px solid var(--border); }
    .sp-sec-btn { font-size: 11px; color: var(--navy); background: none; border: none; cursor: pointer; font-weight: 650; font-family: var(--font); margin-left: 8px; }
    .sp-sec-btn:hover { text-decoration: underline; }
    .sp-sec-btn.clear { color: var(--red); }

    /* Checkboxes */
    .cb-wrap { display: inline-flex; align-items: center; justify-content: center; }
    .cb-wrap input[type=checkbox] { display: none; }
    .cb-wrap label { width: 19px; height: 19px; border: 2px solid var(--border); border-radius: 4px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all .15s; background: var(--surface); }
    .cb-wrap label::after { content: ''; display: none; width: 4px; height: 8px; border: 2px solid #fff; border-top: none; border-left: none; transform: rotate(45deg) translateY(-1px); }
    .cb-wrap input:checked + label { background: var(--navy); border-color: var(--navy); }
    .cb-wrap input:checked + label::after { display: block; }
    .cb-wrap.view   input:checked + label { background: var(--blue);   border-color: var(--blue); }
    .cb-wrap.create input:checked + label { background: var(--green);  border-color: var(--green); }
    .cb-wrap.edit   input:checked + label { background: var(--amber);  border-color: var(--amber); }
    .cb-wrap.delete input:checked + label { background: var(--red);    border-color: var(--red); }

    /* Summary bar */
    .sp-summary-bar { display: flex; align-items: center; justify-content: space-between; background: var(--navy-light); border: 1px solid var(--navy-border); border-radius: var(--radius-md); padding: 10px 16px; margin-top: 16px; }
    .sp-summary-bar-text { font-size: 12.5px; color: var(--navy); font-weight: 600; }
    .sp-summary-count { font-size: 18px; font-weight: 760; color: var(--navy); }
    .sp-changes-count { font-size: 12px; color: var(--amber); font-weight: 600; margin-left: 12px; }

    /* ── Danger zone ── */
    .sp-danger-zone { background: var(--red-bg); border: 1px solid var(--red-border); border-radius: var(--radius-md); padding: 14px 16px; display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; }
    .sp-danger-title { font-size: 13px; font-weight: 650; color: var(--red); margin-bottom: 2px; }
    .sp-danger-desc  { font-size: 12px; color: var(--red); opacity: .75; }
    .sp-btn-danger { display: inline-flex; align-items: center; gap: 6px; background: var(--red); color: #fff; border: 1px solid #a93226; border-radius: var(--radius-md); padding: 7px 14px; font-size: 12.5px; font-weight: 650; font-family: var(--font); cursor: pointer; transition: background .15s; white-space: nowrap; }
    .sp-btn-danger:hover { background: #a93226; }

    /* ── Action bar ── */
    .sp-action-bar { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-lg); box-shadow: var(--shadow); padding: 14px 20px; display: flex; align-items: center; justify-content: space-between; gap: 10px; margin-top: 20px; }
    .sp-action-bar-left  { font-size: 12.5px; color: var(--text-hint); display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
    .sp-action-bar-right { display: flex; align-items: center; gap: 10px; }
    .sp-btn-primary { display: inline-flex; align-items: center; gap: 6px; background: var(--navy); color: #fff; border: 1px solid var(--navy-hover); border-radius: var(--radius-md); padding: 8px 18px; font-size: 13.5px; font-weight: 600; font-family: var(--font); cursor: pointer; text-decoration: none; transition: background .15s; white-space: nowrap; }
    .sp-btn-primary:hover { background: var(--navy-hover); color: #fff; }
    .sp-btn-secondary { display: inline-flex; align-items: center; gap: 6px; background: var(--surface); color: var(--text-primary); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 8px 16px; font-size: 13.5px; font-weight: 500; font-family: var(--font); cursor: pointer; text-decoration: none; transition: all .15s; white-space: nowrap; }
    .sp-btn-secondary:hover { background: var(--bg); border-color: var(--border-hover); color: var(--text-primary); }
    .sp-btn-reset { display: inline-flex; align-items: center; gap: 6px; background: var(--amber-bg); color: var(--amber); border: 1px solid var(--amber-border); border-radius: var(--radius-md); padding: 8px 14px; font-size: 13px; font-weight: 600; font-family: var(--font); cursor: pointer; transition: background .15s; white-space: nowrap; }
    .sp-btn-reset:hover { background: #fff0b3; }

    @media(max-width:768px) { .sp-page { padding: 16px; } }
    </style>

    <div class="app-content content container-fluid">
        <div class="sp-page">

            <!-- Page header -->
            <div class="sp-page-header">
                <div>
                    <h1 class="sp-page-title">
                        Edit Team Member
                        <span class="sp-unsaved" id="unsavedBadge"><i class="fa fa-circle" style="font-size:7px"></i> Unsaved changes</span>
                    </h1>
                    <div class="sp-crumb">
                        <a href="#">Dashboard</a>
                        <span class="sp-crumb-sep">›</span>
                        <a href="#">Roles &amp; Settings</a>
                        <span class="sp-crumb-sep">›</span>
                        <a href="#">Team Members</a>
                        <span class="sp-crumb-sep">›</span>
                        <span>Edit — Priya Verma</span>
                    </div>
                </div>

                <!-- Member identity chip -->
                <div class="sp-member-chip">
                    <div class="sp-chip-av" style="background:#0069d9">PV</div>
                    <div>
                        <div class="sp-chip-name">Priya Verma</div>
                        <div class="sp-chip-meta">ID #02 &nbsp;·&nbsp; Manager</div>
                        <div class="sp-chip-pill active"><i class="fa fa-circle" style="font-size:6px"></i> Active</div>
                    </div>
                </div>
            </div>

            <div class="sp-layout">

                <!-- ══ LEFT ══ -->
                <div>

                    <!-- Avatar + record info -->
                    <div class="sp-card">
                        <div class="sp-av-block">
                            <span class="sp-member-id-badge">#02</span>
                            <div class="sp-av-circle" id="avCircle">PV</div>
                            <div class="sp-av-name-lbl" id="avName">Priya Verma</div>
                            <div class="sp-av-role-lbl" id="avRole">Manager</div>
                        </div>
                        <div class="sp-card-body-sm">
                            <div class="sp-info-row">
                                <span class="sp-info-lbl">Member Since</span>
                                <span class="sp-info-val">12 Jan 2025</span>
                            </div>
                            <div class="sp-info-row">
                                <span class="sp-info-lbl">Last Login</span>
                                <span class="sp-info-val">Today, 9:15 AM</span>
                            </div>
                            <div class="sp-info-row">
                                <span class="sp-info-lbl">Last Login IP</span>
                                <span class="sp-info-val" style="font-family:'SF Mono','Fira Code',monospace;font-size:12px">103.21.45.8</span>
                            </div>
                            <div class="sp-info-row">
                                <span class="sp-info-lbl">Login Device</span>
                                <span class="sp-info-val">Firefox / Mac</span>
                            </div>
                            <div class="sp-info-row">
                                <span class="sp-info-lbl">Total Logins</span>
                                <span class="sp-info-val">147</span>
                            </div>
                            <div class="sp-info-row">
                                <span class="sp-info-lbl">Custom Perms</span>
                                <span class="sp-info-val" style="color:var(--amber)"><i class="fa fa-star" style="font-size:10px;margin-right:4px"></i>Active</span>
                            </div>
                        </div>
                    </div>

                    <!-- Basic details -->
                    <div class="sp-card">
                        <div class="sp-card-header"><h5><i class="fa fa-user" style="margin-right:7px;color:var(--text-hint)"></i>Basic Details</h5></div>
                        <div class="sp-card-body">
                            <div class="sp-grid-2">
                                <div class="sp-field">
                                    <label class="sp-label">First Name <span class="sp-req">*</span></label>
                                    <input type="text" class="sp-input" id="firstName" value="Priya" oninput="updatePreview();markChanged(this)">
                                </div>
                                <div class="sp-field">
                                    <label class="sp-label">Last Name <span class="sp-req">*</span></label>
                                    <input type="text" class="sp-input" id="lastName" value="Verma" oninput="updatePreview();markChanged(this)">
                                </div>
                            </div>
                            <div class="sp-field">
                                <label class="sp-label">Email Address <span class="sp-req">*</span></label>
                                <input type="email" class="sp-input" value="priya.verma@store.com" oninput="markChanged(this)">
                            </div>
                            <div class="sp-field">
                                <label class="sp-label">Phone Number</label>
                                <input type="text" class="sp-input" value="+91 91234 56789" oninput="markChanged(this)">
                            </div>
                        </div>
                    </div>

                    <!-- Role assignment -->
                    <div class="sp-card">
                        <div class="sp-card-header"><h5><i class="fa fa-shield" style="margin-right:7px;color:var(--navy)"></i>Role Category</h5></div>
                        <div class="sp-card-body">
                            <div class="sp-role-grid" id="roleGrid">
                                <div class="sp-role-opt" onclick="selectRole(this,'Super Admin')">
                                    <input type="radio" name="role" value="super-admin">
                                    <div class="sp-role-opt-icon" style="background:var(--navy-light);color:var(--navy)"><i class="fa fa-crown"></i></div>
                                    <div class="sp-role-opt-name">Super Admin</div>
                                    <div class="sp-role-opt-desc">Full access to all modules</div>
                                    <div class="sp-role-opt-check"></div>
                                </div>
                                <div class="sp-role-opt selected" onclick="selectRole(this,'Manager')">
                                    <input type="radio" name="role" value="manager" checked>
                                    <div class="sp-role-opt-icon" style="background:var(--blue-bg);color:var(--blue)"><i class="fa fa-user-tie"></i></div>
                                    <div class="sp-role-opt-name">Manager</div>
                                    <div class="sp-role-opt-desc">Orders, products &amp; customers</div>
                                    <div class="sp-role-opt-check"></div>
                                </div>
                                <div class="sp-role-opt" onclick="selectRole(this,'Content Editor')">
                                    <input type="radio" name="role" value="editor">
                                    <div class="sp-role-opt-icon" style="background:var(--purple-bg);color:var(--purple)"><i class="fa fa-pen"></i></div>
                                    <div class="sp-role-opt-name">Content Editor</div>
                                    <div class="sp-role-opt-desc">CMS, blogs &amp; pages only</div>
                                    <div class="sp-role-opt-check"></div>
                                </div>
                                <div class="sp-role-opt" onclick="selectRole(this,'Support Agent')">
                                    <input type="radio" name="role" value="support">
                                    <div class="sp-role-opt-icon" style="background:var(--green-bg);color:var(--green)"><i class="fa fa-headset"></i></div>
                                    <div class="sp-role-opt-name">Support Agent</div>
                                    <div class="sp-role-opt-desc">Orders &amp; customer queries</div>
                                    <div class="sp-role-opt-check"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Settings -->
                    <div class="sp-card">
                        <div class="sp-card-header"><h5><i class="fa fa-cog" style="margin-right:7px;color:var(--text-hint)"></i>Settings</h5></div>
                        <div class="sp-card-body-sm">
                            <div class="sp-toggle-row">
                                <div>
                                    <div class="sp-toggle-label">Status</div>
                                    <div class="sp-toggle-sub">Allow this member to log in</div>
                                </div>
                                <label class="sp-switch"><input type="checkbox" checked onchange="flagChange()"><span class="sp-switch-track"></span></label>
                            </div>
                            <div class="sp-toggle-row">
                                <div>
                                    <div class="sp-toggle-label">Email Notifications</div>
                                    <div class="sp-toggle-sub">Receive admin alerts via email</div>
                                </div>
                                <label class="sp-switch"><input type="checkbox" checked onchange="flagChange()"><span class="sp-switch-track"></span></label>
                            </div>
                            <div class="sp-toggle-row">
                                <div>
                                    <div class="sp-toggle-label">Two-Factor Auth</div>
                                    <div class="sp-toggle-sub">Require OTP on login</div>
                                </div>
                                <label class="sp-switch"><input type="checkbox" onchange="flagChange()"><span class="sp-switch-track"></span></label>
                            </div>
                        </div>
                    </div>

                    <!-- Danger zone -->
                    <div class="sp-card">
                        <div class="sp-card-header" style="background:var(--red-bg)">
                            <h5 style="color:var(--red)"><i class="fa fa-exclamation-triangle" style="margin-right:7px"></i>Danger Zone</h5>
                        </div>
                        <div class="sp-card-body-sm" style="display:flex;flex-direction:column;gap:10px">
                            <div class="sp-danger-zone">
                                <div>
                                    <div class="sp-danger-title">Delete Member</div>
                                    <div class="sp-danger-desc">Permanently remove this member and all data.</div>
                                </div>
                                <button class="sp-btn-danger" onclick="confirmDelete()">
                                    <i class="fa fa-trash"></i> Delete
                                </button>
                            </div>
                            <div class="sp-danger-zone" style="background:var(--amber-bg);border-color:var(--amber-border)">
                                <div>
                                    <div class="sp-danger-title" style="color:var(--amber)">Suspend Account</div>
                                    <div class="sp-danger-desc" style="color:var(--amber)">Block login without deleting the account.</div>
                                </div>
                                <button class="sp-btn-danger" style="background:var(--amber);border-color:#7a5900" onclick="confirmSuspend()">
                                    <i class="fa fa-ban"></i> Suspend
                                </button>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- ══ RIGHT — permissions ══ -->
                <div>
                    <div class="sp-card">
                        <div class="sp-card-header">
                            <h5><i class="fa fa-sliders-h" style="margin-right:7px;color:var(--amber)"></i>Permission Settings</h5>
                            <span style="font-size:11.5px;color:var(--text-hint)" id="permCountHeader">24 / 38 selected</span>
                        </div>
                        <div class="sp-card-body">

                            <div class="sp-perm-notice">
                                <i class="fa fa-info-circle" style="flex-shrink:0;margin-top:2px"></i>
                                <span>This member has <strong>custom permissions</strong> active. Changes here will override the Manager role defaults for this member only.</span>
                            </div>

                            <!-- Custom perm toggle — pre-enabled since this member already has custom perms -->
                            <div class="sp-custom-perm-toggle">
                                <div>
                                    <div class="sp-custom-perm-label"><i class="fa fa-star" style="margin-right:6px"></i>Custom Permissions Enabled</div>
                                    <div class="sp-custom-perm-sub">This member has individual permission overrides</div>
                                </div>
                                <label class="sp-switch">
                                    <input type="checkbox" id="customPermToggle" checked onchange="toggleCustomPerm(this)">
                                    <span class="sp-switch-track"></span>
                                </label>
                            </div>

                            <!-- Matrix -->
                            <div class="sp-matrix-wrap" id="matrixWrap">

                                <div class="sp-legend">
                                    <div class="sp-legend-item"><span class="sp-legend-dot" style="background:var(--blue)"></span>View</div>
                                    <div class="sp-legend-item"><span class="sp-legend-dot" style="background:var(--green)"></span>Create</div>
                                    <div class="sp-legend-item"><span class="sp-legend-dot" style="background:var(--amber)"></span>Edit</div>
                                    <div class="sp-legend-item"><span class="sp-legend-dot" style="background:var(--red)"></span>Delete</div>
                                </div>

                                <div class="sp-quick-btns">
                                    <button class="sp-quick-btn all"      onclick="selectAll()"><i class="fa fa-check-square"></i> Select All</button>
                                    <button class="sp-quick-btn viewonly" onclick="viewOnly()"><i class="fa fa-eye"></i> View Only</button>
                                    <button class="sp-quick-btn clear"    onclick="clearAll()"><i class="fa fa-square"></i> Clear All</button>
                                    <button class="sp-quick-btn reset"    onclick="resetToSaved()"><i class="fa fa-history"></i> Reset to Saved</button>
                                </div>

                                <table class="sp-matrix-table">
                                    <thead>
                                        <tr>
                                            <th>Module</th>
                                            <th style="color:var(--blue)">View</th>
                                            <th style="color:var(--green)">Create</th>
                                            <th style="color:var(--amber)">Edit</th>
                                            <th style="color:var(--red)">Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <!-- MASTER -->
                                        <tr class="sp-grp-row"><td colspan="5"><i class="fa fa-database" style="margin-right:6px"></i>Master<button class="sp-sec-btn" onclick="selSec('m')">All</button><button class="sp-sec-btn clear" onclick="clrSec('m')">Clear</button></td></tr>
                                        <tr><td>Categories &amp; Sub Categories</td><td><div class="cb-wrap view"><input type="checkbox" id="m1v" checked><label for="m1v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="m1c" checked><label for="m1c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="m1e" checked><label for="m1e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="m1d"><label for="m1d"></label></div></td></tr>
                                        <tr><td>Attributes</td><td><div class="cb-wrap view"><input type="checkbox" id="m2v" checked><label for="m2v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="m2c" checked><label for="m2c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="m2e" checked><label for="m2e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="m2d"><label for="m2d"></label></div></td></tr>
                                        <tr><td>Attributes Value</td><td><div class="cb-wrap view"><input type="checkbox" id="m3v" checked><label for="m3v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="m3c"><label for="m3c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="m3e" checked><label for="m3e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="m3d"><label for="m3d"></label></div></td></tr>
                                        <tr><td>Category &amp; Attributes Mapping</td><td><div class="cb-wrap view"><input type="checkbox" id="m4v" checked><label for="m4v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="m4c"><label for="m4c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="m4e"><label for="m4e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="m4d"><label for="m4d"></label></div></td></tr>
                                        <tr><td>Manage Occasions</td><td><div class="cb-wrap view"><input type="checkbox" id="m5v" checked><label for="m5v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="m5c" checked><label for="m5c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="m5e" checked><label for="m5e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="m5d"><label for="m5d"></label></div></td></tr>
                                        <tr><td>Manage Collections</td><td><div class="cb-wrap view"><input type="checkbox" id="m6v" checked><label for="m6v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="m6c" checked><label for="m6c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="m6e" checked><label for="m6e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="m6d"><label for="m6d"></label></div></td></tr>
                                        <tr><td>Manage Brands</td><td><div class="cb-wrap view"><input type="checkbox" id="m7v" checked><label for="m7v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="m7c" checked><label for="m7c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="m7e" checked><label for="m7e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="m7d"><label for="m7d"></label></div></td></tr>

                                        <!-- PRODUCTS -->
                                        <tr class="sp-grp-row"><td colspan="5"><i class="fa fa-box" style="margin-right:6px"></i>Products &amp; Inventories<button class="sp-sec-btn" onclick="selSec('p')">All</button><button class="sp-sec-btn clear" onclick="clrSec('p')">Clear</button></td></tr>
                                        <tr><td>Manage Products</td><td><div class="cb-wrap view"><input type="checkbox" id="p1v" checked><label for="p1v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="p1c" checked><label for="p1c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="p1e" checked><label for="p1e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="p1d"><label for="p1d"></label></div></td></tr>
                                        <tr><td>Stock Management</td><td><div class="cb-wrap view"><input type="checkbox" id="p2v" checked><label for="p2v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="p2c"><label for="p2c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="p2e" checked><label for="p2e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="p2d"><label for="p2d"></label></div></td></tr>
                                        <tr><td>Stock Alerts</td><td><div class="cb-wrap view"><input type="checkbox" id="p3v" checked><label for="p3v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="p3c"><label for="p3c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="p3e"><label for="p3e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="p3d"><label for="p3d"></label></div></td></tr>
                                        <tr><td>Product Reviews</td><td><div class="cb-wrap view"><input type="checkbox" id="p4v" checked><label for="p4v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="p4c"><label for="p4c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="p4e"><label for="p4e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="p4d"><label for="p4d"></label></div></td></tr>

                                        <!-- ORDERS -->
                                        <tr class="sp-grp-row"><td colspan="5"><i class="fa fa-shopping-cart" style="margin-right:6px"></i>Customer &amp; Orders<button class="sp-sec-btn" onclick="selSec('o')">All</button><button class="sp-sec-btn clear" onclick="clrSec('o')">Clear</button></td></tr>
                                        <tr><td>Manage Orders</td><td><div class="cb-wrap view"><input type="checkbox" id="o1v" checked><label for="o1v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="o1c"><label for="o1c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="o1e" checked><label for="o1e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="o1d"><label for="o1d"></label></div></td></tr>
                                        <tr><td>Payments &amp; Transactions</td><td><div class="cb-wrap view"><input type="checkbox" id="o2v" checked><label for="o2v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="o2c"><label for="o2c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="o2e"><label for="o2e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="o2d"><label for="o2d"></label></div></td></tr>
                                        <tr><td>Manage Return Reasons</td><td><div class="cb-wrap view"><input type="checkbox" id="o3v" checked><label for="o3v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="o3c" checked><label for="o3c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="o3e" checked><label for="o3e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="o3d"><label for="o3d"></label></div></td></tr>
                                        <tr><td>Return Orders</td><td><div class="cb-wrap view"><input type="checkbox" id="o4v" checked><label for="o4v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="o4c"><label for="o4c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="o4e" checked><label for="o4e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="o4d"><label for="o4d"></label></div></td></tr>
                                        <tr><td>Refund Management</td><td><div class="cb-wrap view"><input type="checkbox" id="o5v" checked><label for="o5v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="o5c"><label for="o5c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="o5e"><label for="o5e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="o5d"><label for="o5d"></label></div></td></tr>
                                        <tr><td>Manage Customers</td><td><div class="cb-wrap view"><input type="checkbox" id="o6v" checked><label for="o6v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="o6c"><label for="o6c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="o6e" checked><label for="o6e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="o6d"><label for="o6d"></label></div></td></tr>
                                        <tr><td>Customer Address Book</td><td><div class="cb-wrap view"><input type="checkbox" id="o7v" checked><label for="o7v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="o7c"><label for="o7c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="o7e"><label for="o7e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="o7d"><label for="o7d"></label></div></td></tr>
                                        <tr><td>Customer WishList</td><td><div class="cb-wrap view"><input type="checkbox" id="o8v" checked><label for="o8v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="o8c"><label for="o8c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="o8e"><label for="o8e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="o8d"><label for="o8d"></label></div></td></tr>
                                        <tr><td>Abandoned Carts</td><td><div class="cb-wrap view"><input type="checkbox" id="o9v" checked><label for="o9v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="o9c"><label for="o9c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="o9e"><label for="o9e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="o9d"><label for="o9d"></label></div></td></tr>

                                        <!-- CONTENT -->
                                        <tr class="sp-grp-row"><td colspan="5"><i class="fa fa-file-alt" style="margin-right:6px"></i>Content Management<button class="sp-sec-btn" onclick="selSec('c')">All</button><button class="sp-sec-btn clear" onclick="clrSec('c')">Clear</button></td></tr>
                                        <tr><td>Home Page Widgets</td><td><div class="cb-wrap view"><input type="checkbox" id="c1v" checked><label for="c1v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="c1c" checked><label for="c1c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="c1e" checked><label for="c1e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="c1d"><label for="c1d"></label></div></td></tr>
                                        <tr><td>Manage About Us</td><td><div class="cb-wrap view"><input type="checkbox" id="c2v" checked><label for="c2v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="c2c" checked><label for="c2c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="c2e" checked><label for="c2e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="c2d"><label for="c2d"></label></div></td></tr>
                                        <tr><td>Manage Contact Us</td><td><div class="cb-wrap view"><input type="checkbox" id="c3v" checked><label for="c3v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="c3c" checked><label for="c3c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="c3e" checked><label for="c3e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="c3d"><label for="c3d"></label></div></td></tr>
                                        <tr><td>Manage FAQ</td><td><div class="cb-wrap view"><input type="checkbox" id="c4v" checked><label for="c4v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="c4c"><label for="c4c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="c4e" checked><label for="c4e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="c4d"><label for="c4d"></label></div></td></tr>
                                        <tr><td>Manage Blogs</td><td><div class="cb-wrap view"><input type="checkbox" id="c5v" checked><label for="c5v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="c5c" checked><label for="c5c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="c5e" checked><label for="c5e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="c5d"><label for="c5d"></label></div></td></tr>
                                        <tr><td>Manage Dynamic Pages</td><td><div class="cb-wrap view"><input type="checkbox" id="c6v" checked><label for="c6v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="c6c" checked><label for="c6c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="c6e" checked><label for="c6e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="c6d"><label for="c6d"></label></div></td></tr>
                                        <tr><td>Manage Announcements</td><td><div class="cb-wrap view"><input type="checkbox" id="c7v" checked><label for="c7v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="c7c" checked><label for="c7c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="c7e" checked><label for="c7e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="c7d"><label for="c7d"></label></div></td></tr>
                                        <tr><td>Testimonial &amp; Feedbacks</td><td><div class="cb-wrap view"><input type="checkbox" id="c8v" checked><label for="c8v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="c8c" checked><label for="c8c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="c8e" checked><label for="c8e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="c8d"><label for="c8d"></label></div></td></tr>

                                        <!-- ENQUIRIES -->
                                        <tr class="sp-grp-row"><td colspan="5"><i class="fa fa-envelope" style="margin-right:6px"></i>Enquiries<button class="sp-sec-btn" onclick="selSec('e')">All</button><button class="sp-sec-btn clear" onclick="clrSec('e')">Clear</button></td></tr>
                                        <tr><td>Contact Us Enquiries</td><td><div class="cb-wrap view"><input type="checkbox" id="e1v" checked><label for="e1v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="e1c"><label for="e1c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="e1e"><label for="e1e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="e1d"><label for="e1d"></label></div></td></tr>
                                        <tr><td>Get a Callback Enquiries</td><td><div class="cb-wrap view"><input type="checkbox" id="e2v" checked><label for="e2v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="e2c"><label for="e2c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="e2e"><label for="e2e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="e2d"><label for="e2d"></label></div></td></tr>
                                        <tr><td>Bulk Order Enquiries</td><td><div class="cb-wrap view"><input type="checkbox" id="e3v" checked><label for="e3v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="e3c"><label for="e3c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="e3e"><label for="e3e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="e3d"><label for="e3d"></label></div></td></tr>
                                        <tr><td>Sellers / Vendors Enquiries</td><td><div class="cb-wrap view"><input type="checkbox" id="e4v" checked><label for="e4v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="e4c"><label for="e4c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="e4e"><label for="e4e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="e4d"><label for="e4d"></label></div></td></tr>

                                        <!-- MARKETING -->
                                        <tr class="sp-grp-row"><td colspan="5"><i class="fa fa-chart-line" style="margin-right:6px"></i>Marketing &amp; SEO<button class="sp-sec-btn" onclick="selSec('mk')">All</button><button class="sp-sec-btn clear" onclick="clrSec('mk')">Clear</button></td></tr>
                                        <tr><td>Coupon Management</td><td><div class="cb-wrap view"><input type="checkbox" id="mk1v" checked><label for="mk1v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="mk1c" checked><label for="mk1c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="mk1e" checked><label for="mk1e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="mk1d"><label for="mk1d"></label></div></td></tr>
                                        <tr><td>SEO Settings</td><td><div class="cb-wrap view"><input type="checkbox" id="mk2v" checked><label for="mk2v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="mk2c"><label for="mk2c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="mk2e" checked><label for="mk2e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="mk2d"><label for="mk2d"></label></div></td></tr>
                                        <tr><td>Email Subscribers</td><td><div class="cb-wrap view"><input type="checkbox" id="mk3v" checked><label for="mk3v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="mk3c"><label for="mk3c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="mk3e"><label for="mk3e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="mk3d"><label for="mk3d"></label></div></td></tr>

                                        <!-- ADMIN SETTINGS -->
                                        <tr class="sp-grp-row"><td colspan="5"><i class="fa fa-cog" style="margin-right:6px"></i>Admin Settings<button class="sp-sec-btn" onclick="selSec('s')">All</button><button class="sp-sec-btn clear" onclick="clrSec('s')">Clear</button></td></tr>
                                        <tr><td>General Setting</td><td><div class="cb-wrap view"><input type="checkbox" id="s1v" checked><label for="s1v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="s1c"><label for="s1c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="s1e"><label for="s1e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="s1d"><label for="s1d"></label></div></td></tr>
                                        <tr><td>SMTP Setting</td><td><div class="cb-wrap view"><input type="checkbox" id="s2v" checked><label for="s2v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="s2c"><label for="s2c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="s2e"><label for="s2e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="s2d"><label for="s2d"></label></div></td></tr>
                                        <tr><td>Payment Gateway Setting</td><td><div class="cb-wrap view"><input type="checkbox" id="s3v"><label for="s3v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="s3c"><label for="s3c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="s3e"><label for="s3e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="s3d"><label for="s3d"></label></div></td></tr>
                                        <tr><td>SMS Setting</td><td><div class="cb-wrap view"><input type="checkbox" id="s4v"><label for="s4v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="s4c"><label for="s4c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="s4e"><label for="s4e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="s4d"><label for="s4d"></label></div></td></tr>
                                        <tr><td>Tax &amp; Invoice Setting</td><td><div class="cb-wrap view"><input type="checkbox" id="s5v"><label for="s5v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="s5c"><label for="s5c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="s5e"><label for="s5e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="s5d"><label for="s5d"></label></div></td></tr>
                                        <tr><td>Courier Management</td><td><div class="cb-wrap view"><input type="checkbox" id="s6v"><label for="s6v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="s6c"><label for="s6c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="s6e"><label for="s6e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="s6d"><label for="s6d"></label></div></td></tr>
                                        <tr><td>Social Media Setting</td><td><div class="cb-wrap view"><input type="checkbox" id="s7v"><label for="s7v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="s7c"><label for="s7c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="s7e"><label for="s7e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="s7d"><label for="s7d"></label></div></td></tr>

                                        <!-- REPORTS -->
                                        <tr class="sp-grp-row"><td colspan="5"><i class="fa fa-chart-bar" style="margin-right:6px"></i>Reports<button class="sp-sec-btn" onclick="selSec('r')">All</button><button class="sp-sec-btn clear" onclick="clrSec('r')">Clear</button></td></tr>
                                        <tr><td>Sales Report</td><td><div class="cb-wrap view"><input type="checkbox" id="r1v" checked><label for="r1v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="r1c"><label for="r1c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="r1e"><label for="r1e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="r1d"><label for="r1d"></label></div></td></tr>
                                        <tr><td>Customer Report</td><td><div class="cb-wrap view"><input type="checkbox" id="r2v" checked><label for="r2v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="r2c"><label for="r2c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="r2e"><label for="r2e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="r2d"><label for="r2d"></label></div></td></tr>
                                        <tr><td>Stock Reports</td><td><div class="cb-wrap view"><input type="checkbox" id="r3v" checked><label for="r3v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="r3c"><label for="r3c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="r3e"><label for="r3e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="r3d"><label for="r3d"></label></div></td></tr>

                                        <!-- NOTIFICATIONS -->
                                        <tr class="sp-grp-row"><td colspan="5"><i class="fa fa-bell" style="margin-right:6px"></i>Notifications<button class="sp-sec-btn" onclick="selSec('n')">All</button><button class="sp-sec-btn clear" onclick="clrSec('n')">Clear</button></td></tr>
                                        <tr><td>Notifications</td><td><div class="cb-wrap view"><input type="checkbox" id="n1v" checked><label for="n1v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="n1c"><label for="n1c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="n1e"><label for="n1e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="n1d"><label for="n1d"></label></div></td></tr>

                                    </tbody>
                                </table>

                                <!-- Summary bar -->
                                <div class="sp-summary-bar">
                                    <span class="sp-summary-bar-text">Permissions selected</span>
                                    <div style="display:flex;align-items:center">
                                        <span class="sp-summary-count" id="permCount">24</span>
                                        <span class="sp-changes-count" id="changesCount"></span>
                                    </div>
                                </div>

                            </div><!-- /.sp-matrix-wrap -->

                        </div>
                    </div>

                </div>
            </div>

            <!-- Action bar -->
            <div class="sp-action-bar">
                <div class="sp-action-bar-left">
                    <i class="fa fa-info-circle"></i>
                    Changes affect <strong style="color:var(--text-primary);margin:0 3px">Priya Verma</strong> only — not the Manager role.
                    <span class="sp-unsaved" id="unsavedBadge2"><i class="fa fa-circle" style="font-size:7px"></i> Unsaved</span>
                </div>
                <div class="sp-action-bar-right">
                    <button class="sp-btn-reset" onclick="resetAll()"><i class="fa fa-history"></i> Reset</button>
                    <a href="#" class="sp-btn-secondary">Discard</a>
                    <button class="sp-btn-primary" onclick="saveChanges()">
                        <i class="fa fa-save"></i> Save Changes
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

@include('admin.footer')

<script>