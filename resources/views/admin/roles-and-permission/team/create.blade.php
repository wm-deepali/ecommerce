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

    /* ── Step indicator ── */
    .sp-steps { display: flex; align-items: center; gap: 0; margin-bottom: 24px; background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 16px 24px; box-shadow: var(--shadow); }
    .sp-step { display: flex; align-items: center; gap: 10px; flex: 1; }
    .sp-step-num { width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; flex-shrink: 0; border: 2px solid var(--border); color: var(--text-hint); background: var(--surface); }
    .sp-step.active .sp-step-num  { background: var(--navy); border-color: var(--navy); color: #fff; }
    .sp-step.done .sp-step-num    { background: var(--green); border-color: var(--green); color: #fff; }
    .sp-step-label { font-size: 12.5px; font-weight: 600; color: var(--text-hint); }
    .sp-step.active .sp-step-label { color: var(--navy); }
    .sp-step.done .sp-step-label   { color: var(--green); }
    .sp-step-line { flex: 1; height: 1px; background: var(--border); margin: 0 12px; }
    .sp-step-line.done { background: var(--green); }

    /* ── Layout: left info + right permission ── */
    .sp-layout { display: grid; grid-template-columns: 320px 1fr; gap: 20px; align-items: start; }
    @media(max-width:1100px) { .sp-layout { grid-template-columns: 1fr; } }

    /* ── Cards ── */
    .sp-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-lg); box-shadow: var(--shadow); overflow: hidden; margin-bottom: 16px; }
    .sp-card:last-child { margin-bottom: 0; }
    .sp-card-header { padding: 13px 20px; border-bottom: 1px solid var(--border); background: #fafafa; display: flex; align-items: center; justify-content: space-between; gap: 10px; }
    .sp-card-header h5 { font-size: 13px; font-weight: 650; color: var(--text-primary); margin: 0; }
    .sp-card-body    { padding: 20px; }
    .sp-card-body-sm { padding: 14px 20px; }

    /* ── Avatar preview ── */
    .sp-av-preview { display: flex; flex-direction: column; align-items: center; padding: 20px 20px 16px; border-bottom: 1px solid var(--border); background: linear-gradient(135deg, var(--navy-light) 0%, var(--surface) 100%); }
    .sp-av-circle { width: 72px; height: 72px; border-radius: 50%; background: var(--navy); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 24px; font-weight: 700; margin-bottom: 10px; border: 3px solid #fff; box-shadow: 0 2px 12px rgba(48,61,137,.2); }
    .sp-av-name-preview { font-size: 14px; font-weight: 660; color: var(--text-primary); }
    .sp-av-role-preview { font-size: 12px; color: var(--text-hint); margin-top: 3px; }

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
    .sp-input:focus, .sp-select:focus, .sp-textarea:focus {
        border-color: var(--navy); box-shadow: 0 0 0 3px rgba(48,61,137,.10);
    }
    .sp-input::placeholder, .sp-textarea::placeholder { color: var(--text-disabled); }
    .sp-select { appearance: none; -webkit-appearance: none; padding-right: 32px;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%238c9196'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right 10px center; cursor: pointer; }
    .sp-textarea { height: auto; padding: 10px 12px; resize: vertical; min-height: 80px; }
    .sp-input-icon-wrap { position: relative; }
    .sp-input-icon-wrap .sp-input { padding-right: 38px; }
    .sp-input-toggle { position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--text-hint); cursor: pointer; font-size: 13px; }
    .sp-help-text { font-size: 11.5px; color: var(--text-hint); margin-top: 5px; line-height: 1.5; }

    /* two col grid */
    .sp-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
    @media(max-width:600px) { .sp-grid-2 { grid-template-columns: 1fr; } }

    /* ── Role card selector ── */
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

    /* ── Permission section (right column) ── */
    .sp-perm-notice { display: flex; align-items: flex-start; gap: 10px; background: var(--blue-bg); border: 1px solid var(--blue-border); border-radius: var(--radius-md); padding: 11px 14px; font-size: 12.5px; color: var(--blue); line-height: 1.6; margin-bottom: 16px; }
    .sp-perm-notice i { flex-shrink: 0; margin-top: 2px; }

    /* Custom perm toggle */
    .sp-custom-perm-toggle { display: flex; align-items: center; justify-content: space-between; padding: 12px 14px; background: var(--amber-bg); border: 1px solid var(--amber-border); border-radius: var(--radius-md); margin-bottom: 16px; }
    .sp-custom-perm-label { font-size: 13px; font-weight: 650; color: var(--amber); }
    .sp-custom-perm-sub   { font-size: 11.5px; color: var(--amber); opacity: .8; margin-top: 2px; }

    /* Matrix */
    .sp-matrix-wrap { display: none; }
    .sp-matrix-wrap.visible { display: block; }

    .sp-section-head { font-size: 11px; font-weight: 700; letter-spacing: .07em; text-transform: uppercase; color: var(--navy); padding: 7px 0 10px; display: flex; align-items: center; gap: 8px; }
    .sp-section-head::after { content: ''; flex: 1; height: 1px; background: var(--navy-light); }
    .sp-section-btns { display: flex; gap: 6px; }
    .sp-sec-btn { font-size: 11px; color: var(--navy); background: none; border: none; cursor: pointer; font-weight: 650; font-family: var(--font); }
    .sp-sec-btn:hover { text-decoration: underline; }
    .sp-sec-btn.clear { color: var(--red); }

    .sp-matrix-table { width: 100%; border-collapse: collapse; }
    .sp-matrix-table thead th { font-size: 11px; font-weight: 650; letter-spacing: .05em; text-transform: uppercase; color: var(--text-hint); padding: 8px 10px; border-bottom: 1px solid var(--border); background: #fafafa; text-align: center; }
    .sp-matrix-table thead th:first-child { text-align: left; width: 40%; }
    .sp-matrix-table tbody tr { border-bottom: 1px solid var(--border); transition: background .1s; }
    .sp-matrix-table tbody tr:last-child { border-bottom: none; }
    .sp-matrix-table tbody tr:hover { background: #f7f8f9; }
    .sp-matrix-table td { padding: 9px 10px; vertical-align: middle; text-align: center; }
    .sp-matrix-table td:first-child { text-align: left; font-size: 13px; color: var(--text-primary); font-weight: 500; }

    /* Section group row */
    .sp-grp-row td { background: #f5f6fe; font-size: 11.5px; font-weight: 650; color: var(--navy); padding: 7px 10px; border-bottom: 1px solid var(--border); }

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

    /* Legend + quick actions */
    .sp-legend { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 14px; }
    .sp-legend-item { display: flex; align-items: center; gap: 5px; font-size: 12px; color: var(--text-secondary); }
    .sp-legend-dot  { width: 10px; height: 10px; border-radius: 3px; }
    .sp-quick-btns  { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 16px; }
    .sp-quick-btn { display: inline-flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 600; padding: 5px 12px; border-radius: 20px; cursor: pointer; border: 1px solid; font-family: var(--font); transition: opacity .15s; }
    .sp-quick-btn:hover { opacity: .82; }
    .sp-quick-btn.all      { background: var(--green-bg);  color: var(--green);  border-color: var(--green-border); }
    .sp-quick-btn.clear    { background: var(--red-bg);    color: var(--red);    border-color: var(--red-border); }
    .sp-quick-btn.viewonly { background: var(--blue-bg);   color: var(--blue);   border-color: var(--blue-border); }

    /* Summary bar */
    .sp-summary-bar { display: flex; align-items: center; justify-content: space-between; background: var(--navy-light); border: 1px solid var(--navy-border); border-radius: var(--radius-md); padding: 10px 16px; margin-top: 16px; }
    .sp-summary-bar-text { font-size: 12.5px; color: var(--navy); font-weight: 600; }
    .sp-summary-count { font-size: 18px; font-weight: 760; color: var(--navy); }

    /* ── Action bar ── */
    .sp-action-bar { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-lg); box-shadow: var(--shadow); padding: 14px 20px; display: flex; align-items: center; justify-content: space-between; gap: 10px; margin-top: 20px; }
    .sp-action-bar-left  { font-size: 12.5px; color: var(--text-hint); display: flex; align-items: center; gap: 6px; }
    .sp-action-bar-right { display: flex; align-items: center; gap: 10px; }
    .sp-btn-primary { display: inline-flex; align-items: center; gap: 6px; background: var(--navy); color: #fff; border: 1px solid var(--navy-hover); border-radius: var(--radius-md); padding: 8px 18px; font-size: 13.5px; font-weight: 600; font-family: var(--font); cursor: pointer; text-decoration: none; transition: background .15s; white-space: nowrap; }
    .sp-btn-primary:hover { background: var(--navy-hover); color: #fff; }
    .sp-btn-secondary { display: inline-flex; align-items: center; gap: 6px; background: var(--surface); color: var(--text-primary); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 8px 16px; font-size: 13.5px; font-weight: 500; font-family: var(--font); cursor: pointer; text-decoration: none; transition: all .15s; white-space: nowrap; }
    .sp-btn-secondary:hover { background: var(--bg); border-color: var(--border-hover); color: var(--text-primary); }

    /* pw strength */
    .sp-pw-strength { height: 4px; border-radius: 4px; background: var(--border); overflow: hidden; margin-top: 6px; }
    .sp-pw-fill { height: 100%; border-radius: 4px; transition: width .3s, background .3s; width: 0%; background: var(--red); }
    .sp-pw-hint { font-size: 11px; color: var(--text-hint); margin-top: 4px; }

    @media(max-width:768px) { .sp-page { padding: 16px; } }
    </style>

    <div class="app-content content container-fluid">
        <div class="sp-page">

            <!-- Page header -->
            <div class="sp-page-header">
                <div>
                    <h1 class="sp-page-title">Add Team Member</h1>
                    <div class="sp-crumb">
                        <a href="#">Dashboard</a>
                        <span class="sp-crumb-sep">›</span>
                        <a href="#">Roles &amp; Settings</a>
                        <span class="sp-crumb-sep">›</span>
                        <a href="#">Team Members</a>
                        <span class="sp-crumb-sep">›</span>
                        <span>Add New</span>
                    </div>
                </div>
            </div>

            <!-- Step indicator -->
            <div class="sp-steps">
                <div class="sp-step active">
                    <div class="sp-step-num">1</div>
                    <div class="sp-step-label">Basic Details</div>
                </div>
                <div class="sp-step-line"></div>
                <div class="sp-step active">
                    <div class="sp-step-num">2</div>
                    <div class="sp-step-label">Role Assignment</div>
                </div>
                <div class="sp-step-line"></div>
                <div class="sp-step active">
                    <div class="sp-step-num">3</div>
                    <div class="sp-step-label">Permissions</div>
                </div>
            </div>

            <div class="sp-layout">

                <!-- ══ LEFT — details + role + settings ══ -->
                <div>

                    <!-- Avatar preview -->
                    <div class="sp-card">
                        <div class="sp-av-preview">
                            <div class="sp-av-circle" id="avCircle">?</div>
                            <div class="sp-av-name-preview" id="avName">Full Name</div>
                            <div class="sp-av-role-preview" id="avRole">No role selected</div>
                        </div>

                        <div class="sp-card-body">
                            <!-- Name -->
                            <div class="sp-grid-2">
                                <div class="sp-field">
                                    <label class="sp-label">First Name <span class="sp-req">*</span></label>
                                    <input type="text" class="sp-input" id="firstName" placeholder="e.g. Rahul" oninput="updatePreview()">
                                </div>
                                <div class="sp-field">
                                    <label class="sp-label">Last Name <span class="sp-req">*</span></label>
                                    <input type="text" class="sp-input" id="lastName" placeholder="e.g. Sharma" oninput="updatePreview()">
                                </div>
                            </div>

                            <!-- Email & Phone -->
                            <div class="sp-field">
                                <label class="sp-label">Email Address <span class="sp-req">*</span></label>
                                <input type="email" class="sp-input" placeholder="e.g. rahul@store.com">
                            </div>
                            <div class="sp-field">
                                <label class="sp-label">Phone Number</label>
                                <input type="text" class="sp-input" placeholder="+91 98765 43210">
                            </div>

                            <!-- Password -->
                            <div class="sp-field">
                                <label class="sp-label">Password <span class="sp-req">*</span></label>
                                <div class="sp-input-icon-wrap">
                                    <input type="password" class="sp-input" id="pwField" placeholder="Set a password" oninput="checkStrength(this.value)">
                                    <button class="sp-input-toggle" type="button" onclick="togglePw()"><i class="fa fa-eye" id="pwEyeIco"></i></button>
                                </div>
                                <div class="sp-pw-strength"><div class="sp-pw-fill" id="pwBar"></div></div>
                                <div class="sp-pw-hint" id="pwHint">Min. 8 characters with letters &amp; numbers</div>
                            </div>

                            <div class="sp-field">
                                <label class="sp-label">Confirm Password <span class="sp-req">*</span></label>
                                <div class="sp-input-icon-wrap">
                                    <input type="password" class="sp-input" placeholder="Confirm password">
                                    <button class="sp-input-toggle" type="button" onclick="togglePw2()"><i class="fa fa-eye" id="pwEye2"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Role assignment -->
                    <div class="sp-card">
                        <div class="sp-card-header"><h5><i class="fa fa-shield" style="margin-right:7px;color:var(--navy)"></i>Assign Role Category</h5></div>
                        <div class="sp-card-body">
                            <div class="sp-role-grid" id="roleGrid">

                                <div class="sp-role-opt" onclick="selectRole(this,'Super Admin','super-admin')">
                                    <input type="radio" name="role" value="super-admin">
                                    <div class="sp-role-opt-icon" style="background:var(--navy-light);color:var(--navy)"><i class="fa fa-crown"></i></div>
                                    <div class="sp-role-opt-name">Super Admin</div>
                                    <div class="sp-role-opt-desc">Full access to all modules</div>
                                    <div class="sp-role-opt-check"></div>
                                </div>

                                <div class="sp-role-opt" onclick="selectRole(this,'Manager','manager')">
                                    <input type="radio" name="role" value="manager">
                                    <div class="sp-role-opt-icon" style="background:var(--blue-bg);color:var(--blue)"><i class="fa fa-user-tie"></i></div>
                                    <div class="sp-role-opt-name">Manager</div>
                                    <div class="sp-role-opt-desc">Orders, products & customers</div>
                                    <div class="sp-role-opt-check"></div>
                                </div>

                                <div class="sp-role-opt" onclick="selectRole(this,'Content Editor','editor')">
                                    <input type="radio" name="role" value="editor">
                                    <div class="sp-role-opt-icon" style="background:var(--purple-bg);color:var(--purple)"><i class="fa fa-pen"></i></div>
                                    <div class="sp-role-opt-name">Content Editor</div>
                                    <div class="sp-role-opt-desc">CMS, blogs & pages only</div>
                                    <div class="sp-role-opt-check"></div>
                                </div>

                                <div class="sp-role-opt" onclick="selectRole(this,'Support Agent','support')">
                                    <input type="radio" name="role" value="support">
                                    <div class="sp-role-opt-icon" style="background:var(--green-bg);color:var(--green)"><i class="fa fa-headset"></i></div>
                                    <div class="sp-role-opt-name">Support Agent</div>
                                    <div class="sp-role-opt-desc">Orders & customer queries</div>
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
                                <label class="sp-switch"><input type="checkbox" checked><span class="sp-switch-track"></span></label>
                            </div>
                            <div class="sp-toggle-row">
                                <div>
                                    <div class="sp-toggle-label">Email Notifications</div>
                                    <div class="sp-toggle-sub">Receive admin alerts via email</div>
                                </div>
                                <label class="sp-switch"><input type="checkbox" checked><span class="sp-switch-track"></span></label>
                            </div>
                            <div class="sp-toggle-row">
                                <div>
                                    <div class="sp-toggle-label">Two-Factor Auth</div>
                                    <div class="sp-toggle-sub">Require OTP on login</div>
                                </div>
                                <label class="sp-switch"><input type="checkbox"><span class="sp-switch-track"></span></label>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- ══ RIGHT — permission matrix ══ -->
                <div>
                    <div class="sp-card">
                        <div class="sp-card-header">
                            <h5><i class="fa fa-sliders-h" style="margin-right:7px;color:var(--amber)"></i>Permission Settings</h5>
                            <span style="font-size:11.5px;color:var(--text-hint)" id="permCountHeader">0 / 38 selected</span>
                        </div>
                        <div class="sp-card-body">

                            <!-- Role notice -->
                            <div class="sp-perm-notice">
                                <i class="fa fa-info-circle"></i>
                                <span>By default, the selected role's permissions will apply. Enable <strong>Custom Permissions</strong> below to override specific modules for this member only.</span>
                            </div>

                            <!-- Custom perm toggle -->
                            <div class="sp-custom-perm-toggle">
                                <div>
                                    <div class="sp-custom-perm-label"><i class="fa fa-star" style="margin-right:6px"></i>Enable Custom Permissions</div>
                                    <div class="sp-custom-perm-sub">Override role defaults for this member</div>
                                </div>
                                <label class="sp-switch">
                                    <input type="checkbox" id="customPermToggle" onchange="toggleCustomPerm(this)">
                                    <span class="sp-switch-track"></span>
                                </label>
                            </div>

                            <!-- Matrix (shown only when custom perm enabled) -->
                            <div class="sp-matrix-wrap" id="matrixWrap">

                                <!-- Legend -->
                                <div class="sp-legend">
                                    <div class="sp-legend-item"><span class="sp-legend-dot" style="background:var(--blue)"></span>View</div>
                                    <div class="sp-legend-item"><span class="sp-legend-dot" style="background:var(--green)"></span>Create</div>
                                    <div class="sp-legend-item"><span class="sp-legend-dot" style="background:var(--amber)"></span>Edit</div>
                                    <div class="sp-legend-item"><span class="sp-legend-dot" style="background:var(--red)"></span>Delete</div>
                                </div>

                                <!-- Quick actions -->
                                <div class="sp-quick-btns">
                                    <button class="sp-quick-btn all"      onclick="selectAll()"><i class="fa fa-check-square"></i> Select All</button>
                                    <button class="sp-quick-btn viewonly" onclick="viewOnly()"><i class="fa fa-eye"></i> View Only</button>
                                    <button class="sp-quick-btn clear"    onclick="clearAll()"><i class="fa fa-square"></i> Clear All</button>
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
                                        <tr class="sp-grp-row"><td colspan="5"><i class="fa fa-database" style="margin-right:6px"></i>Master <button class="sp-sec-btn" style="margin-left:8px" onclick="selSec('m')">All</button><button class="sp-sec-btn clear" onclick="clrSec('m')">Clear</button></td></tr>
                                        <tr><td>Categories &amp; Sub Categories</td><td><div class="cb-wrap view"><input type="checkbox" id="m1v"><label for="m1v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="m1c"><label for="m1c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="m1e"><label for="m1e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="m1d"><label for="m1d"></label></div></td></tr>
                                        <tr><td>Attributes</td><td><div class="cb-wrap view"><input type="checkbox" id="m2v"><label for="m2v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="m2c"><label for="m2c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="m2e"><label for="m2e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="m2d"><label for="m2d"></label></div></td></tr>
                                        <tr><td>Attributes Value</td><td><div class="cb-wrap view"><input type="checkbox" id="m3v"><label for="m3v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="m3c"><label for="m3c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="m3e"><label for="m3e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="m3d"><label for="m3d"></label></div></td></tr>
                                        <tr><td>Category &amp; Attributes Mapping</td><td><div class="cb-wrap view"><input type="checkbox" id="m4v"><label for="m4v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="m4c"><label for="m4c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="m4e"><label for="m4e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="m4d"><label for="m4d"></label></div></td></tr>
                                        <tr><td>Manage Occasions</td><td><div class="cb-wrap view"><input type="checkbox" id="m5v"><label for="m5v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="m5c"><label for="m5c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="m5e"><label for="m5e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="m5d"><label for="m5d"></label></div></td></tr>
                                        <tr><td>Manage Collections</td><td><div class="cb-wrap view"><input type="checkbox" id="m6v"><label for="m6v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="m6c"><label for="m6c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="m6e"><label for="m6e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="m6d"><label for="m6d"></label></div></td></tr>
                                        <tr><td>Manage Brands</td><td><div class="cb-wrap view"><input type="checkbox" id="m7v"><label for="m7v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="m7c"><label for="m7c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="m7e"><label for="m7e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="m7d"><label for="m7d"></label></div></td></tr>

                                        <!-- PRODUCTS -->
                                        <tr class="sp-grp-row"><td colspan="5"><i class="fa fa-box" style="margin-right:6px"></i>Products &amp; Inventories <button class="sp-sec-btn" style="margin-left:8px" onclick="selSec('p')">All</button><button class="sp-sec-btn clear" onclick="clrSec('p')">Clear</button></td></tr>
                                        <tr><td>Manage Products</td><td><div class="cb-wrap view"><input type="checkbox" id="p1v"><label for="p1v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="p1c"><label for="p1c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="p1e"><label for="p1e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="p1d"><label for="p1d"></label></div></td></tr>
                                        <tr><td>Stock Management</td><td><div class="cb-wrap view"><input type="checkbox" id="p2v"><label for="p2v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="p2c"><label for="p2c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="p2e"><label for="p2e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="p2d"><label for="p2d"></label></div></td></tr>
                                        <tr><td>Stock Alerts</td><td><div class="cb-wrap view"><input type="checkbox" id="p3v"><label for="p3v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="p3c"><label for="p3c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="p3e"><label for="p3e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="p3d"><label for="p3d"></label></div></td></tr>
                                        <tr><td>Product Reviews</td><td><div class="cb-wrap view"><input type="checkbox" id="p4v"><label for="p4v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="p4c"><label for="p4c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="p4e"><label for="p4e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="p4d"><label for="p4d"></label></div></td></tr>

                                        <!-- ORDERS -->
                                        <tr class="sp-grp-row"><td colspan="5"><i class="fa fa-shopping-cart" style="margin-right:6px"></i>Customer &amp; Orders <button class="sp-sec-btn" style="margin-left:8px" onclick="selSec('o')">All</button><button class="sp-sec-btn clear" onclick="clrSec('o')">Clear</button></td></tr>
                                        <tr><td>Manage Orders</td><td><div class="cb-wrap view"><input type="checkbox" id="o1v"><label for="o1v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="o1c"><label for="o1c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="o1e"><label for="o1e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="o1d"><label for="o1d"></label></div></td></tr>
                                        <tr><td>Payments &amp; Transactions</td><td><div class="cb-wrap view"><input type="checkbox" id="o2v"><label for="o2v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="o2c"><label for="o2c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="o2e"><label for="o2e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="o2d"><label for="o2d"></label></div></td></tr>
                                        <tr><td>Manage Return Reasons</td><td><div class="cb-wrap view"><input type="checkbox" id="o3v"><label for="o3v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="o3c"><label for="o3c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="o3e"><label for="o3e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="o3d"><label for="o3d"></label></div></td></tr>
                                        <tr><td>Return Orders</td><td><div class="cb-wrap view"><input type="checkbox" id="o4v"><label for="o4v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="o4c"><label for="o4c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="o4e"><label for="o4e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="o4d"><label for="o4d"></label></div></td></tr>
                                        <tr><td>Refund Management</td><td><div class="cb-wrap view"><input type="checkbox" id="o5v"><label for="o5v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="o5c"><label for="o5c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="o5e"><label for="o5e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="o5d"><label for="o5d"></label></div></td></tr>
                                        <tr><td>Manage Customers</td><td><div class="cb-wrap view"><input type="checkbox" id="o6v"><label for="o6v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="o6c"><label for="o6c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="o6e"><label for="o6e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="o6d"><label for="o6d"></label></div></td></tr>
                                        <tr><td>Customer Address Book</td><td><div class="cb-wrap view"><input type="checkbox" id="o7v"><label for="o7v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="o7c"><label for="o7c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="o7e"><label for="o7e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="o7d"><label for="o7d"></label></div></td></tr>
                                        <tr><td>Customer WishList</td><td><div class="cb-wrap view"><input type="checkbox" id="o8v"><label for="o8v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="o8c"><label for="o8c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="o8e"><label for="o8e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="o8d"><label for="o8d"></label></div></td></tr>
                                        <tr><td>Abandoned Carts</td><td><div class="cb-wrap view"><input type="checkbox" id="o9v"><label for="o9v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="o9c"><label for="o9c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="o9e"><label for="o9e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="o9d"><label for="o9d"></label></div></td></tr>

                                        <!-- CONTENT -->
                                        <tr class="sp-grp-row"><td colspan="5"><i class="fa fa-file-alt" style="margin-right:6px"></i>Content Management <button class="sp-sec-btn" style="margin-left:8px" onclick="selSec('c')">All</button><button class="sp-sec-btn clear" onclick="clrSec('c')">Clear</button></td></tr>
                                        <tr><td>Home Page Widgets</td><td><div class="cb-wrap view"><input type="checkbox" id="c1v"><label for="c1v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="c1c"><label for="c1c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="c1e"><label for="c1e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="c1d"><label for="c1d"></label></div></td></tr>
                                        <tr><td>Manage About Us</td><td><div class="cb-wrap view"><input type="checkbox" id="c2v"><label for="c2v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="c2c"><label for="c2c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="c2e"><label for="c2e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="c2d"><label for="c2d"></label></div></td></tr>
                                        <tr><td>Manage Contact Us</td><td><div class="cb-wrap view"><input type="checkbox" id="c3v"><label for="c3v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="c3c"><label for="c3c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="c3e"><label for="c3e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="c3d"><label for="c3d"></label></div></td></tr>
                                        <tr><td>Manage FAQ</td><td><div class="cb-wrap view"><input type="checkbox" id="c4v"><label for="c4v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="c4c"><label for="c4c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="c4e"><label for="c4e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="c4d"><label for="c4d"></label></div></td></tr>
                                        <tr><td>Manage Blogs</td><td><div class="cb-wrap view"><input type="checkbox" id="c5v"><label for="c5v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="c5c"><label for="c5c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="c5e"><label for="c5e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="c5d"><label for="c5d"></label></div></td></tr>
                                        <tr><td>Manage Dynamic Pages</td><td><div class="cb-wrap view"><input type="checkbox" id="c6v"><label for="c6v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="c6c"><label for="c6c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="c6e"><label for="c6e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="c6d"><label for="c6d"></label></div></td></tr>
                                        <tr><td>Manage Announcements</td><td><div class="cb-wrap view"><input type="checkbox" id="c7v"><label for="c7v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="c7c"><label for="c7c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="c7e"><label for="c7e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="c7d"><label for="c7d"></label></div></td></tr>
                                        <tr><td>Testimonial &amp; Feedbacks</td><td><div class="cb-wrap view"><input type="checkbox" id="c8v"><label for="c8v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="c8c"><label for="c8c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="c8e"><label for="c8e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="c8d"><label for="c8d"></label></div></td></tr>

                                        <!-- ENQUIRIES -->
                                        <tr class="sp-grp-row"><td colspan="5"><i class="fa fa-envelope" style="margin-right:6px"></i>Enquiries <button class="sp-sec-btn" style="margin-left:8px" onclick="selSec('e')">All</button><button class="sp-sec-btn clear" onclick="clrSec('e')">Clear</button></td></tr>
                                        <tr><td>Contact Us Enquiries</td><td><div class="cb-wrap view"><input type="checkbox" id="e1v"><label for="e1v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="e1c"><label for="e1c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="e1e"><label for="e1e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="e1d"><label for="e1d"></label></div></td></tr>
                                        <tr><td>Get a Callback Enquiries</td><td><div class="cb-wrap view"><input type="checkbox" id="e2v"><label for="e2v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="e2c"><label for="e2c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="e2e"><label for="e2e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="e2d"><label for="e2d"></label></div></td></tr>
                                        <tr><td>Bulk Order Enquiries</td><td><div class="cb-wrap view"><input type="checkbox" id="e3v"><label for="e3v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="e3c"><label for="e3c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="e3e"><label for="e3e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="e3d"><label for="e3d"></label></div></td></tr>
                                        <tr><td>Sellers / Vendors Enquiries</td><td><div class="cb-wrap view"><input type="checkbox" id="e4v"><label for="e4v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="e4c"><label for="e4c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="e4e"><label for="e4e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="e4d"><label for="e4d"></label></div></td></tr>

                                        <!-- MARKETING -->
                                        <tr class="sp-grp-row"><td colspan="5"><i class="fa fa-chart-line" style="margin-right:6px"></i>Marketing &amp; SEO <button class="sp-sec-btn" style="margin-left:8px" onclick="selSec('mk')">All</button><button class="sp-sec-btn clear" onclick="clrSec('mk')">Clear</button></td></tr>
                                        <tr><td>Coupon Management</td><td><div class="cb-wrap view"><input type="checkbox" id="mk1v"><label for="mk1v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="mk1c"><label for="mk1c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="mk1e"><label for="mk1e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="mk1d"><label for="mk1d"></label></div></td></tr>
                                        <tr><td>SEO Settings</td><td><div class="cb-wrap view"><input type="checkbox" id="mk2v"><label for="mk2v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="mk2c"><label for="mk2c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="mk2e"><label for="mk2e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="mk2d"><label for="mk2d"></label></div></td></tr>
                                        <tr><td>Email Subscribers</td><td><div class="cb-wrap view"><input type="checkbox" id="mk3v"><label for="mk3v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="mk3c"><label for="mk3c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="mk3e"><label for="mk3e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="mk3d"><label for="mk3d"></label></div></td></tr>

                                        <!-- ADMIN SETTINGS -->
                                        <tr class="sp-grp-row"><td colspan="5"><i class="fa fa-cog" style="margin-right:6px"></i>Admin Settings <button class="sp-sec-btn" style="margin-left:8px" onclick="selSec('s')">All</button><button class="sp-sec-btn clear" onclick="clrSec('s')">Clear</button></td></tr>
                                        <tr><td>General Setting</td><td><div class="cb-wrap view"><input type="checkbox" id="s1v"><label for="s1v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="s1c"><label for="s1c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="s1e"><label for="s1e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="s1d"><label for="s1d"></label></div></td></tr>
                                        <tr><td>SMTP Setting</td><td><div class="cb-wrap view"><input type="checkbox" id="s2v"><label for="s2v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="s2c"><label for="s2c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="s2e"><label for="s2e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="s2d"><label for="s2d"></label></div></td></tr>
                                        <tr><td>Payment Gateway Setting</td><td><div class="cb-wrap view"><input type="checkbox" id="s3v"><label for="s3v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="s3c"><label for="s3c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="s3e"><label for="s3e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="s3d"><label for="s3d"></label></div></td></tr>
                                        <tr><td>SMS Setting</td><td><div class="cb-wrap view"><input type="checkbox" id="s4v"><label for="s4v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="s4c"><label for="s4c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="s4e"><label for="s4e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="s4d"><label for="s4d"></label></div></td></tr>
                                        <tr><td>Tax &amp; Invoice Setting</td><td><div class="cb-wrap view"><input type="checkbox" id="s5v"><label for="s5v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="s5c"><label for="s5c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="s5e"><label for="s5e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="s5d"><label for="s5d"></label></div></td></tr>
                                        <tr><td>Courier Management</td><td><div class="cb-wrap view"><input type="checkbox" id="s6v"><label for="s6v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="s6c"><label for="s6c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="s6e"><label for="s6e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="s6d"><label for="s6d"></label></div></td></tr>
                                        <tr><td>Social Media Setting</td><td><div class="cb-wrap view"><input type="checkbox" id="s7v"><label for="s7v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="s7c"><label for="s7c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="s7e"><label for="s7e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="s7d"><label for="s7d"></label></div></td></tr>

                                        <!-- REPORTS -->
                                        <tr class="sp-grp-row"><td colspan="5"><i class="fa fa-chart-bar" style="margin-right:6px"></i>Reports <button class="sp-sec-btn" style="margin-left:8px" onclick="selSec('r')">All</button><button class="sp-sec-btn clear" onclick="clrSec('r')">Clear</button></td></tr>
                                        <tr><td>Sales Report</td><td><div class="cb-wrap view"><input type="checkbox" id="r1v"><label for="r1v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="r1c"><label for="r1c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="r1e"><label for="r1e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="r1d"><label for="r1d"></label></div></td></tr>
                                        <tr><td>Customer Report</td><td><div class="cb-wrap view"><input type="checkbox" id="r2v"><label for="r2v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="r2c"><label for="r2c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="r2e"><label for="r2e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="r2d"><label for="r2d"></label></div></td></tr>
                                        <tr><td>Stock Reports</td><td><div class="cb-wrap view"><input type="checkbox" id="r3v"><label for="r3v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="r3c"><label for="r3c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="r3e"><label for="r3e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="r3d"><label for="r3d"></label></div></td></tr>

                                        <!-- NOTIFICATIONS -->
                                        <tr class="sp-grp-row"><td colspan="5"><i class="fa fa-bell" style="margin-right:6px"></i>Notifications <button class="sp-sec-btn" style="margin-left:8px" onclick="selSec('n')">All</button><button class="sp-sec-btn clear" onclick="clrSec('n')">Clear</button></td></tr>
                                        <tr><td>Notifications</td><td><div class="cb-wrap view"><input type="checkbox" id="n1v"><label for="n1v"></label></div></td><td><div class="cb-wrap create"><input type="checkbox" id="n1c"><label for="n1c"></label></div></td><td><div class="cb-wrap edit"><input type="checkbox" id="n1e"><label for="n1e"></label></div></td><td><div class="cb-wrap delete"><input type="checkbox" id="n1d"><label for="n1d"></label></div></td></tr>

                                    </tbody>
                                </table>

                                <!-- Summary bar -->
                                <div class="sp-summary-bar">
                                    <span class="sp-summary-bar-text">Total permissions selected</span>
                                    <span class="sp-summary-count" id="permCount">0</span>
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
                    All fields marked <strong style="color:var(--red);margin:0 3px">*</strong> are required
                </div>
                <div class="sp-action-bar-right">
                    <a href="#" class="sp-btn-secondary">Cancel</a>
                    <button class="sp-btn-primary" onclick="submitForm()">
                        <i class="fa fa-user-plus"></i> Create Team Member
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

@include('admin.footer')

<script>
/* ── Avatar preview ── */
function updatePreview() {
    const fn = (document.getElementById('firstName').value || '').trim();
    const ln = (document.getElementById('lastName').value  || '').trim();
    const full = [fn, ln].filter(Boolean).join(' ') || 'Full Name';
    const initials = [(fn[0]||''), (ln[0]||'')].join('').toUpperCase() || '?';
    document.getElementById('avName').textContent    = full;
    document.getElementById('avCircle').textContent  = initials;
}

/* ── Role selection ── */
let selectedRole = '';
function selectRole(el, name, key) {
    document.querySelectorAll('.sp-role-opt').forEach(o => o.classList.remove('selected'));
    el.classList.add('selected');
    el.querySelector('input[type=radio]').checked = true;
    selectedRole = key;
    document.getElementById('avRole').textContent = name;
}

/* ── Custom permission toggle ── */
function toggleCustomPerm(cb) {
    const wrap = document.getElementById('matrixWrap');
    if (cb.checked) { wrap.classList.add('visible'); updatePermCount(); }
    else            { wrap.classList.remove('visible'); }
}

/* ── Permission helpers ── */
function getAllCb()  { return document.querySelectorAll('#matrixWrap .cb-wrap input[type=checkbox]'); }
function updatePermCount() {
    const c = document.querySelectorAll('#matrixWrap .cb-wrap input:checked').length;
    document.getElementById('permCount').textContent       = c;
    document.getElementById('permCountHeader').textContent = c + ' / 38 selected';
}
function selectAll()  { getAllCb().forEach(cb => cb.checked = true);  updatePermCount(); }
function clearAll()   { getAllCb().forEach(cb => cb.checked = false); updatePermCount(); }
function viewOnly()   {
    getAllCb().forEach(cb => cb.checked = false);
    document.querySelectorAll('#matrixWrap .cb-wrap.view input').forEach(cb => cb.checked = true);
    updatePermCount();
}
function selSec(p) {
    document.querySelectorAll(`#matrixWrap input[id^="${p}"]`).forEach(cb => { if (cb.closest('.cb-wrap')) cb.checked = true; });
    updatePermCount();
}
function clrSec(p) {
    document.querySelectorAll(`#matrixWrap input[id^="${p}"]`).forEach(cb => { if (cb.closest('.cb-wrap')) cb.checked = false; });
    updatePermCount();
}
getAllCb().forEach(cb => cb.addEventListener('change', updatePermCount));

/* ── Password strength ── */
function checkStrength(v) {
    let score = 0;
    if (v.length >= 8)          score++;
    if (/[A-Z]/.test(v))        score++;
    if (/[0-9]/.test(v))        score++;
    if (/[^A-Za-z0-9]/.test(v)) score++;
    const map = [
        {w:'0%',   c:'var(--red)',   t:'Too short'},
        {w:'25%',  c:'var(--red)',   t:'Weak'},
        {w:'50%',  c:'var(--amber)', t:'Fair'},
        {w:'75%',  c:'var(--blue)',  t:'Good'},
        {w:'100%', c:'var(--green)', t:'Strong — great password!'},
    ];
    document.getElementById('pwBar').style.width      = map[score].w;
    document.getElementById('pwBar').style.background = map[score].c;
    document.getElementById('pwHint').textContent     = map[score].t;
}

function togglePw() {
    const f = document.getElementById('pwField');
    const i = document.getElementById('pwEyeIco');
    if (f.type === 'password') { f.type = 'text';     i.className = 'fa fa-eye-slash'; }
    else                        { f.type = 'password'; i.className = 'fa fa-eye'; }
}
function togglePw2() {
    const f = document.querySelector('[placeholder="Confirm password"]');
    const i = document.getElementById('pwEye2');
    if (f.type === 'password') { f.type = 'text';     i.className = 'fa fa-eye-slash'; }
    else                        { f.type = 'password'; i.className = 'fa fa-eye'; }
}

/* ── Submit ── */
function submitForm() {
    const fn = document.getElementById('firstName').value.trim();
    const ln = document.getElementById('lastName').value.trim();
    if (!fn || !ln) { Swal.fire({ icon:'warning', title:'Missing fields', text:'Please enter first and last name.', confirmButtonColor:'var(--navy)' }); return; }
    if (!selectedRole) { Swal.fire({ icon:'warning', title:'No role selected', text:'Please select a role category for this member.', confirmButtonColor:'var(--navy)' }); return; }
    Swal.fire({ icon:'success', title:'Member Created!', text: fn + ' ' + ln + ' has been added to the team.', timer: 2000, showConfirmButton: false });
}
</script>