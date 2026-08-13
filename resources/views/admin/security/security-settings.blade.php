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
        --purple:#6d28d9; --purple-bg:#ede9fe; --purple-border:#c4b5fd;
        --radius-sm:6px; --radius-md:8px; --radius-lg:12px;
        --shadow:0 1px 0 rgba(0,0,0,.05),0 0 0 1px rgba(0,0,0,.07);
        --font:'Inter',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
    }
    .ss-page { background:var(--bg); padding:24px 28px; min-height:100vh; font-family:var(--font); color:var(--text-primary); font-size:14px; }
    .ss-page * { box-sizing:border-box; }

    /* ── Page header ── */
    .ss-ph { display:flex; align-items:flex-start; justify-content:space-between; flex-wrap:wrap; gap:12px; margin-bottom:20px; }
    .ss-title { font-size:20px; font-weight:660; margin:0 0 4px; letter-spacing:-.2px; }
    .ss-crumb { font-size:12.5px; color:var(--text-hint); display:flex; align-items:center; gap:4px; flex-wrap:wrap; }
    .ss-crumb a { color:var(--navy); text-decoration:none; font-weight:500; }
    .ss-crumb a:hover { text-decoration:underline; }
    .ss-crumb-sep { color:var(--border-hover); }

    /* ── Tab shell ── */
    .ss-shell { background:var(--surface); border:1px solid var(--border); border-radius:var(--radius-lg); box-shadow:var(--shadow); overflow:hidden; }

    /* ── Top tab nav ── */
    .ss-tab-nav { display:flex; border-bottom:1px solid var(--border); background:#fafafa; overflow-x:auto; scrollbar-width:none; }
    .ss-tab-nav::-webkit-scrollbar { display:none; }
    .ss-tab-btn { display:inline-flex; align-items:center; gap:8px; padding:14px 22px; font-size:13px; font-weight:500; color:var(--text-secondary); border:none; background:none; cursor:pointer; border-bottom:2px solid transparent; white-space:nowrap; font-family:var(--font); transition:color .15s,border-color .15s; flex-shrink:0; margin-bottom:-1px; }
    .ss-tab-btn i { font-size:14px; color:var(--text-hint); transition:color .15s; }
    .ss-tab-btn:hover { color:var(--text-primary); }
    .ss-tab-btn.active { color:var(--navy); border-bottom-color:var(--navy); font-weight:650; }
    .ss-tab-btn.active i { color:var(--navy); }

    /* ── Tab panels ── */
    .ss-panel { display:none; padding:28px 32px; }
    .ss-panel.active { display:block; }
    @media(max-width:768px) { .ss-panel { padding:18px; } }

    /* ── Section ── */
    .ss-section { margin-bottom:32px; }
    .ss-section:last-child { margin-bottom:0; }
    .ss-section-title { font-size:14px; font-weight:660; color:var(--text-primary); margin:0 0 4px; display:flex; align-items:center; gap:8px; }
    .ss-section-title i { color:var(--navy); font-size:14px; }
    .ss-section-desc { font-size:12.5px; color:var(--text-hint); margin:0 0 20px; line-height:1.6; }
    .ss-divider { border:none; border-top:1px solid var(--border); margin:28px 0; }

    /* ── Grid ── */
    .ss-grid-2 { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
    .ss-grid-3 { display:grid; grid-template-columns:1fr 1fr 1fr; gap:14px; }
    .ss-col-full { grid-column:1/-1; }
    @media(max-width:640px) { .ss-grid-2,.ss-grid-3 { grid-template-columns:1fr; } .ss-col-full { grid-column:1; } }

    /* ── Fields ── */
    .ss-field { display:flex; flex-direction:column; gap:6px; margin-bottom:16px; }
    .ss-field:last-child { margin-bottom:0; }
    .ss-label { font-size:11.5px; font-weight:650; color:var(--text-secondary); letter-spacing:.04em; text-transform:uppercase; }
    .ss-req { color:var(--red); margin-left:2px; }
    .ss-hint { font-size:11.5px; color:var(--text-hint); line-height:1.5; }
    .ss-input, .ss-select {
        border:1px solid var(--border); border-radius:var(--radius-md);
        height:38px; padding:0 12px; font-size:13.5px; color:var(--text-primary);
        background:var(--surface); outline:none; font-family:var(--font);
        transition:border-color .15s,box-shadow .15s; width:100%;
    }
    .ss-input:focus, .ss-select:focus { border-color:var(--navy); box-shadow:0 0 0 3px rgba(48,61,137,.10); }
    .ss-input:hover:not(:focus), .ss-select:hover:not(:focus) { border-color:var(--border-hover); }
    .ss-input.mono { font-family:'SF Mono','Fira Code',monospace; font-size:13px; }
    .ss-select { appearance:none; -webkit-appearance:none; padding-right:32px; cursor:pointer;
        background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%238c9196'/%3E%3C/svg%3E");
        background-repeat:no-repeat; background-position:right 10px center; }
    .ss-input-wrap { display:flex; }
    .ss-input-prefix, .ss-input-suffix { display:inline-flex; align-items:center; padding:0 11px; background:var(--bg); border:1px solid var(--border); font-size:13px; color:var(--text-hint); white-space:nowrap; flex-shrink:0; }
    .ss-input-prefix { border-right:none; border-radius:var(--radius-md) 0 0 var(--radius-md); }
    .ss-input-suffix { border-left:none; border-radius:0 var(--radius-md) var(--radius-md) 0; }
    .ss-input-wrap .ss-input { border-radius:0; }
    .ss-input-wrap .ss-input:first-child { border-radius:var(--radius-md) 0 0 var(--radius-md); }
    .ss-input-wrap .ss-input:last-child  { border-radius:0 var(--radius-md) var(--radius-md) 0; }

    /* ── Toggle rows ── */
    .ss-toggle-card { background:var(--bg); border:1px solid var(--border); border-radius:var(--radius-md); overflow:hidden; margin-bottom:12px; }
    .ss-toggle-card:last-child { margin-bottom:0; }
    .ss-toggle-row { display:flex; align-items:center; justify-content:space-between; gap:12px; padding:14px 16px; transition:background .12s; }
    .ss-toggle-row:not(:last-child) { border-bottom:1px solid var(--border); }
    .ss-toggle-label { font-size:13.5px; font-weight:600; color:var(--text-primary); }
    .ss-toggle-sub   { font-size:12px; color:var(--text-hint); margin-top:3px; line-height:1.4; }
    .ss-switch { position:relative; width:40px; height:22px; flex-shrink:0; }
    .ss-switch input { opacity:0; width:0; height:0; position:absolute; }
    .ss-switch-track { position:absolute; inset:0; background:var(--border); border-radius:22px; cursor:pointer; transition:background .2s; }
    .ss-switch-track::after { content:''; position:absolute; left:3px; top:3px; width:16px; height:16px; background:#fff; border-radius:50%; transition:transform .2s; box-shadow:0 1px 3px rgba(0,0,0,.2); }
    .ss-switch input:checked + .ss-switch-track { background:var(--navy); }
    .ss-switch input:checked + .ss-switch-track::after { transform:translateX(18px); }

    /* ── Step / lockout visual ── */
    .ss-lockout-steps { display:flex; gap:0; align-items:stretch; margin:16px 0; }
    .ss-lockout-step { flex:1; background:var(--surface); border:1px solid var(--border); padding:14px 16px; position:relative; }
    .ss-lockout-step:first-child { border-radius:var(--radius-md) 0 0 var(--radius-md); }
    .ss-lockout-step:last-child  { border-radius:0 var(--radius-md) var(--radius-md) 0; }
    .ss-lockout-step:not(:last-child) { border-right:none; }
    .ss-lockout-step-num { width:22px; height:22px; border-radius:50%; background:var(--navy); color:#fff; font-size:11px; font-weight:700; display:flex; align-items:center; justify-content:center; margin-bottom:8px; }
    .ss-lockout-step-title { font-size:12px; font-weight:660; color:var(--text-primary); margin-bottom:4px; }
    .ss-lockout-step-desc  { font-size:11.5px; color:var(--text-hint); line-height:1.5; }
    .ss-lockout-arrow { display:flex; align-items:center; padding:0 4px; color:var(--text-disabled); font-size:14px; flex-shrink:0; }

    /* ── Password strength rules ── */
    .ss-rule-list { list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:8px; }
    .ss-rule-item { display:flex; align-items:center; gap:10px; padding:10px 14px; background:var(--bg); border:1px solid var(--border); border-radius:var(--radius-md); }
    .ss-rule-item-icon { width:26px; height:26px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:12px; flex-shrink:0; }
    .ss-rule-item-icon.on  { background:var(--green-bg); color:var(--green); }
    .ss-rule-item-icon.off { background:var(--bg); color:var(--text-disabled); }
    .ss-rule-text { flex:1; font-size:13px; font-weight:500; color:var(--text-primary); }
    .ss-rule-hint { font-size:11.5px; color:var(--text-hint); }

    /* ── Info callout ── */
    .ss-callout { display:flex; align-items:flex-start; gap:10px; padding:12px 14px; border-radius:var(--radius-md); font-size:13px; line-height:1.6; margin-bottom:20px; }
    .ss-callout i { flex-shrink:0; margin-top:1px; font-size:14px; }
    .ss-callout.blue   { background:var(--blue-bg);   border:1px solid var(--blue-border);   color:var(--blue); }
    .ss-callout.green  { background:var(--green-bg);  border:1px solid var(--green-border);  color:var(--green); }
    .ss-callout.amber  { background:var(--amber-bg);  border:1px solid var(--amber-border);  color:var(--amber); }
    .ss-callout.red    { background:var(--red-bg);    border:1px solid var(--red-border);    color:var(--red); }

    /* ── Backup card ── */
    .ss-backup-status { display:flex; align-items:center; gap:14px; background:var(--surface); border:1px solid var(--border); border-radius:var(--radius-md); padding:14px 16px; margin-bottom:16px; }
    .ss-backup-icon { width:42px; height:42px; border-radius:var(--radius-md); display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0; }
    .ss-backup-icon.connected    { background:var(--green-bg); color:var(--green); }
    .ss-backup-icon.disconnected { background:var(--bg); color:var(--text-disabled); }
    .ss-backup-name  { font-size:14px; font-weight:660; color:var(--text-primary); }
    .ss-backup-meta  { font-size:12px; color:var(--text-hint); margin-top:2px; }
    .ss-backup-actions { margin-left:auto; display:flex; gap:8px; align-items:center; }

    /* Backup history table */
    .ss-bk-table { width:100%; border-collapse:collapse; font-size:13px; }
    .ss-bk-table thead th { font-size:11px; font-weight:650; letter-spacing:.05em; text-transform:uppercase; color:var(--text-hint); padding:9px 12px; border-bottom:1px solid var(--border); background:#fafafa; text-align:left; white-space:nowrap; }
    .ss-bk-table tbody tr { border-bottom:1px solid var(--border); transition:background .1s; }
    .ss-bk-table tbody tr:last-child { border-bottom:none; }
    .ss-bk-table tbody tr:hover { background:#f7f8f9; }
    .ss-bk-table td { padding:10px 12px; vertical-align:middle; }

    /* Schedule grid */
    .ss-day-grid { display:flex; gap:6px; flex-wrap:wrap; }
    .ss-day-chip { display:inline-flex; align-items:center; justify-content:center; width:38px; height:34px; border-radius:var(--radius-sm); border:1px solid var(--border); background:var(--surface); font-size:12px; font-weight:600; color:var(--text-secondary); cursor:pointer; transition:all .12s; user-select:none; }
    .ss-day-chip:hover { border-color:var(--navy); color:var(--navy); background:var(--navy-light); }
    .ss-day-chip.sel { background:var(--navy); border-color:var(--navy); color:#fff; }

    /* Status badge */
    .ss-badge { display:inline-flex; align-items:center; gap:4px; font-size:11px; font-weight:700; padding:2px 8px; border-radius:20px; white-space:nowrap; }
    .ss-badge::before { content:''; width:5px; height:5px; border-radius:50%; flex-shrink:0; }
    .ss-badge.success { background:var(--green-bg); color:var(--green); } .ss-badge.success::before { background:var(--green); }
    .ss-badge.fail    { background:var(--red-bg);   color:var(--red);   } .ss-badge.fail::before    { background:var(--red); }
    .ss-badge.pending { background:var(--amber-bg); color:var(--amber); } .ss-badge.pending::before { background:var(--amber); }
    .ss-badge.info    { background:var(--blue-bg);  color:var(--blue);  } .ss-badge.info::before    { background:var(--blue); }

    /* recaptcha toggle visual */
    .ss-recaptcha-version { display:flex; gap:10px; margin-bottom:16px; }
    .ss-rv-opt { flex:1; border:2px solid var(--border); border-radius:var(--radius-md); padding:14px; cursor:pointer; transition:all .15s; text-align:center; user-select:none; }
    .ss-rv-opt:hover { border-color:var(--navy); background:var(--navy-light); }
    .ss-rv-opt.sel { border-color:var(--navy); background:var(--navy-light); }
    .ss-rv-opt-title { font-size:13px; font-weight:660; color:var(--text-primary); margin-bottom:3px; }
    .ss-rv-opt-desc  { font-size:11.5px; color:var(--text-hint); line-height:1.4; }
    .ss-rv-opt.sel .ss-rv-opt-title { color:var(--navy); }

    /* ── Action bar ── */
    .ss-action-bar { border-top:1px solid var(--border); background:#fafafa; padding:14px 32px; display:flex; align-items:center; justify-content:space-between; gap:10px; flex-wrap:wrap; }
    @media(max-width:768px) { .ss-action-bar { padding:14px 18px; } }
    .ss-btn { display:inline-flex; align-items:center; gap:6px; border-radius:var(--radius-md); padding:8px 18px; font-size:13px; font-weight:600; font-family:var(--font); cursor:pointer; border:1px solid; transition:all .15s; white-space:nowrap; }
    .ss-btn-primary { background:var(--navy); color:#fff; border-color:var(--navy-hover); box-shadow:0 1px 3px rgba(48,61,137,.2); }
    .ss-btn-primary:hover { background:var(--navy-hover); color:#fff; }
    .ss-btn-secondary { background:var(--surface); color:var(--text-primary); border-color:var(--border); }
    .ss-btn-secondary:hover { background:var(--bg); border-color:var(--border-hover); }
    .ss-btn-green { background:var(--green); color:#fff; border-color:#006a4e; }
    .ss-btn-green:hover { background:#006a4e; color:#fff; }
    .ss-btn-red { background:var(--red-bg); color:var(--red); border-color:var(--red-border); }
    .ss-btn-red:hover { background:#fad5d5; }
    .ss-btn-sm { height:30px; padding:0 12px; font-size:12px; }
    </style>

    <div class="app-content content container-fluid">
        <div class="ss-page">

            <!-- Page header -->
            <div class="ss-ph">
                <div>
                    <h1 class="ss-title">Security Settings</h1>
                    <div class="ss-crumb">
                        <a href="#">Dashboard</a>
                        <span class="ss-crumb-sep">›</span>
                        <a href="#">Admin Settings</a>
                        <span class="ss-crumb-sep">›</span>
                        <span>Security</span>
                    </div>
                </div>
                <button class="ss-btn ss-btn-primary" onclick="saveAll()">
                    <i class="fa fa-shield"></i> Save Security Settings
                </button>
            </div>

            <!-- Tab shell -->
            <div class="ss-shell">

                <!-- Tab nav -->
                <div class="ss-tab-nav">
                    <button class="ss-tab-btn active" onclick="switchTab('login',this)"><i class="fa fa-lock"></i> Login &amp; Attempts</button>
                    <button class="ss-tab-btn" onclick="switchTab('password',this)"><i class="fa fa-key"></i> Password Policy</button>
                    <button class="ss-tab-btn" onclick="switchTab('session',this)"><i class="fa fa-clock-o"></i> Session</button>
                    <button class="ss-tab-btn" onclick="switchTab('captcha',this)"><i class="fa fa-robot"></i> reCAPTCHA</button>
                    <button class="ss-tab-btn" onclick="switchTab('backup',this)"><i class="fa fa-cloud"></i> Backup</button>
                    <button class="ss-tab-btn" onclick="switchTab('misc',this)"><i class="fa fa-sliders-h"></i> Advanced</button>
                </div>

                <!-- ══════════════════════════════
                     TAB 1 — LOGIN & ATTEMPTS
                ══════════════════════════════ -->
                <div class="ss-panel active" id="tab-login">

                    <div class="ss-section">
                        <div class="ss-section-title"><i class="fa fa-lock"></i> Login Attempt Limit</div>
                        <p class="ss-section-desc">Control how many consecutive failed logins are allowed before the account is temporarily locked — and what happens at each lockout stage.</p>

                        <div class="ss-callout blue">
                            <i class="fa fa-info-circle"></i>
                            <div>The lockout escalates in stages. After the first lock expires, the user gets another window of attempts — if they fail again, the lock duration increases. After the final stage, the account requires manual admin unlock.</div>
                        </div>

                        <!-- Lockout steps visual -->
                        <div class="ss-lockout-steps">
                            <div class="ss-lockout-step">
                                <div class="ss-lockout-step-num">1</div>
                                <div class="ss-lockout-step-title">First Lockout</div>
                                <div class="ss-lockout-step-desc">After <strong>5</strong> failed attempts → lock for <strong>15 min</strong></div>
                            </div>
                            <div class="ss-lockout-arrow"><i class="fa fa-chevron-right"></i></div>
                            <div class="ss-lockout-step">
                                <div class="ss-lockout-step-num">2</div>
                                <div class="ss-lockout-step-title">Second Lockout</div>
                                <div class="ss-lockout-step-desc">After <strong>3</strong> more fails → lock for <strong>1 hour</strong></div>
                            </div>
                            <div class="ss-lockout-arrow"><i class="fa fa-chevron-right"></i></div>
                            <div class="ss-lockout-step">
                                <div class="ss-lockout-step-num">3</div>
                                <div class="ss-lockout-step-title">Final Lockout</div>
                                <div class="ss-lockout-step-desc">After <strong>2</strong> more fails → <strong>Admin unlock required</strong></div>
                            </div>
                        </div>

                        <!-- Stage 1 -->
                        <div style="border:1px solid var(--border);border-radius:var(--radius-md);overflow:hidden;margin-bottom:14px">
                            <div style="background:var(--navy-light);padding:10px 16px;border-bottom:1px solid var(--navy-border);display:flex;align-items:center;gap:8px">
                                <span style="width:20px;height:20px;border-radius:50%;background:var(--navy);color:#fff;font-size:10px;font-weight:700;display:inline-flex;align-items:center;justify-content:center">1</span>
                                <span style="font-size:13px;font-weight:660;color:var(--navy)">Stage 1 — Initial Lockout</span>
                            </div>
                            <div style="padding:16px 20px">
                                <div class="ss-grid-2">
                                    <div class="ss-field" style="margin:0">
                                        <label class="ss-label">Max Failed Attempts</label>
                                        <div class="ss-input-wrap"><span class="ss-input-prefix"><i class="fa fa-times"></i></span><input type="number" class="ss-input" value="5" min="1" max="20" oninput="updateStepPreview()"></div>
                                        <span class="ss-hint">How many failed logins trigger the first lock</span>
                                    </div>
                                    <div class="ss-field" style="margin:0">
                                        <label class="ss-label">Lock Duration</label>
                                        <div class="ss-input-wrap">
                                            <input type="number" class="ss-input" value="15" min="1" style="border-radius:var(--radius-md) 0 0 var(--radius-md)">
                                            <select class="ss-select" style="border-radius:0 var(--radius-md) var(--radius-md) 0;border-left:none;width:110px;flex-shrink:0"><option>Minutes</option><option>Hours</option></select>
                                        </div>
                                        <span class="ss-hint">How long the account stays locked</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Stage 2 -->
                        <div style="border:1px solid var(--border);border-radius:var(--radius-md);overflow:hidden;margin-bottom:14px">
                            <div style="background:var(--amber-bg);padding:10px 16px;border-bottom:1px solid var(--amber-border);display:flex;align-items:center;gap:8px">
                                <span style="width:20px;height:20px;border-radius:50%;background:var(--amber);color:#fff;font-size:10px;font-weight:700;display:inline-flex;align-items:center;justify-content:center">2</span>
                                <span style="font-size:13px;font-weight:660;color:var(--amber)">Stage 2 — Escalated Lockout</span>
                            </div>
                            <div style="padding:16px 20px">
                                <div class="ss-grid-2">
                                    <div class="ss-field" style="margin:0">
                                        <label class="ss-label">Failed Attempts After Unlock</label>
                                        <div class="ss-input-wrap"><span class="ss-input-prefix"><i class="fa fa-times"></i></span><input type="number" class="ss-input" value="3" min="1" max="10"></div>
                                        <span class="ss-hint">Failed attempts after stage 1 lock expires</span>
                                    </div>
                                    <div class="ss-field" style="margin:0">
                                        <label class="ss-label">Lock Duration</label>
                                        <div class="ss-input-wrap">
                                            <input type="number" class="ss-input" value="1" min="1" style="border-radius:var(--radius-md) 0 0 var(--radius-md)">
                                            <select class="ss-select" style="border-radius:0 var(--radius-md) var(--radius-md) 0;border-left:none;width:110px;flex-shrink:0"><option>Minutes</option><option selected>Hours</option><option>Days</option></select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Stage 3 -->
                        <div style="border:1px solid var(--red-border);border-radius:var(--radius-md);overflow:hidden;margin-bottom:20px">
                            <div style="background:var(--red-bg);padding:10px 16px;border-bottom:1px solid var(--red-border);display:flex;align-items:center;gap:8px">
                                <span style="width:20px;height:20px;border-radius:50%;background:var(--red);color:#fff;font-size:10px;font-weight:700;display:inline-flex;align-items:center;justify-content:center">3</span>
                                <span style="font-size:13px;font-weight:660;color:var(--red)">Stage 3 — Permanent Lock (Admin Unlock)</span>
                            </div>
                            <div style="padding:16px 20px">
                                <div class="ss-grid-2">
                                    <div class="ss-field" style="margin:0">
                                        <label class="ss-label">Trigger After</label>
                                        <div class="ss-input-wrap"><span class="ss-input-prefix"><i class="fa fa-times"></i></span><input type="number" class="ss-input" value="2" min="1" max="10"></div>
                                        <span class="ss-hint">More fails after stage 2 → permanent lock</span>
                                    </div>
                                    <div class="ss-field" style="margin:0">
                                        <label class="ss-label">Unlock Method</label>
                                        <select class="ss-select">
                                            <option>Admin Panel Manual Unlock</option>
                                            <option>Admin Approval + Email Link</option>
                                            <option>Email OTP to Registered Email</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="ss-field" style="margin-top:14px;margin-bottom:0">
                                    <div style="display:flex;align-items:center;justify-content:space-between;gap:12px">
                                        <div>
                                            <div class="ss-toggle-label" style="font-size:13px;font-weight:600">Notify Admin on Permanent Lock</div>
                                            <div class="ss-toggle-sub" style="font-size:11.5px;color:var(--text-hint);margin-top:2px">Send email alert to admin when an account is permanently locked</div>
                                        </div>
                                        <label class="ss-switch"><input type="checkbox" checked><span class="ss-switch-track"></span></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Additional login settings -->
                        <div class="ss-toggle-card">
                            <div class="ss-toggle-row">
                                <div><div class="ss-toggle-label">Reset Attempt Count After Successful Login</div><div class="ss-toggle-sub">Clears the failed attempt counter when the user logs in successfully</div></div>
                                <label class="ss-switch"><input type="checkbox" checked><span class="ss-switch-track"></span></label>
                            </div>
                            <div class="ss-toggle-row">
                                <div><div class="ss-toggle-label">Notify User on Account Lock</div><div class="ss-toggle-sub">Send email/SMS to user when their account gets locked</div></div>
                                <label class="ss-switch"><input type="checkbox" checked><span class="ss-switch-track"></span></label>
                            </div>
                            <div class="ss-toggle-row">
                                <div><div class="ss-toggle-label">Log All Failed Login Attempts</div><div class="ss-toggle-sub">Record IP, device, and timestamp of every failed attempt in Activity Log</div></div>
                                <label class="ss-switch"><input type="checkbox" checked><span class="ss-switch-track"></span></label>
                            </div>
                            <div class="ss-toggle-row">
                                <div><div class="ss-toggle-label">Block Suspicious IP After Multiple Account Locks</div><div class="ss-toggle-sub">Auto-block IP if 3+ different accounts are locked from the same IP within 30 minutes</div></div>
                                <label class="ss-switch"><input type="checkbox"><span class="ss-switch-track"></span></label>
                            </div>
                        </div>
                    </div>

                    <div class="ss-action-bar">
                        <span style="font-size:12px;color:var(--text-hint)"><i class="fa fa-info-circle"></i> Changes apply to all admin team members</span>
                        <div style="display:flex;gap:8px"><button class="ss-btn ss-btn-secondary">Discard</button><button class="ss-btn ss-btn-primary" onclick="saveTab('Login Settings')"><i class="fa fa-save"></i> Save</button></div>
                    </div>
                </div>

                <!-- ══════════════════════════════
                     TAB 2 — PASSWORD POLICY
                ══════════════════════════════ -->
                <div class="ss-panel" id="tab-password">

                    <!-- Force Strong Password -->
                    <div class="ss-section">
                        <div class="ss-section-title"><i class="fa fa-shield-alt"></i> Force Strong Password</div>
                        <p class="ss-section-desc">Define the minimum complexity requirements for all team member passwords. These rules are enforced at registration, password reset, and manual change.</p>

                        <div class="ss-grid-2" style="margin-bottom:20px">
                            <div class="ss-field">
                                <label class="ss-label">Minimum Password Length</label>
                                <div class="ss-input-wrap">
                                    <input type="number" class="ss-input" value="8" min="6" max="32" style="border-radius:var(--radius-md) 0 0 var(--radius-md)">
                                    <span class="ss-input-suffix">characters</span>
                                </div>
                                <span class="ss-hint">Recommended: 10–16 characters</span>
                            </div>
                            <div class="ss-field">
                                <label class="ss-label">Maximum Password Length</label>
                                <div class="ss-input-wrap">
                                    <input type="number" class="ss-input" value="64" min="20" max="128" style="border-radius:var(--radius-md) 0 0 var(--radius-md)">
                                    <span class="ss-input-suffix">characters</span>
                                </div>
                            </div>
                        </div>

                        <ul class="ss-rule-list">
                            <li class="ss-rule-item">
                                <div class="ss-rule-item-icon on"><i class="fa fa-check"></i></div>
                                <div class="ss-rule-text">At least one <strong>Uppercase letter</strong> (A–Z)</div>
                                <label class="ss-switch"><input type="checkbox" checked><span class="ss-switch-track"></span></label>
                            </li>
                            <li class="ss-rule-item">
                                <div class="ss-rule-item-icon on"><i class="fa fa-check"></i></div>
                                <div class="ss-rule-text">At least one <strong>Lowercase letter</strong> (a–z)</div>
                                <label class="ss-switch"><input type="checkbox" checked><span class="ss-switch-track"></span></label>
                            </li>
                            <li class="ss-rule-item">
                                <div class="ss-rule-item-icon on"><i class="fa fa-check"></i></div>
                                <div class="ss-rule-text">At least one <strong>Number</strong> (0–9)</div>
                                <label class="ss-switch"><input type="checkbox" checked><span class="ss-switch-track"></span></label>
                            </li>
                            <li class="ss-rule-item">
                                <div class="ss-rule-item-icon on"><i class="fa fa-check"></i></div>
                                <div class="ss-rule-text">At least one <strong>Special character</strong> (!@#$%^&amp;*)</div>
                                <label class="ss-switch"><input type="checkbox" checked><span class="ss-switch-track"></span></label>
                            </li>
                            <li class="ss-rule-item">
                                <div class="ss-rule-item-icon off"><i class="fa fa-times"></i></div>
                                <div class="ss-rule-text">Cannot contain <strong>username or email</strong></div>
                                <label class="ss-switch"><input type="checkbox"><span class="ss-switch-track"></span></label>
                            </li>
                            <li class="ss-rule-item">
                                <div class="ss-rule-item-icon off"><i class="fa fa-times"></i></div>
                                <div class="ss-rule-text">Cannot reuse last <strong>5 passwords</strong></div>
                                <label class="ss-switch"><input type="checkbox"><span class="ss-switch-track"></span></label>
                            </li>
                            <li class="ss-rule-item">
                                <div class="ss-rule-item-icon off"><i class="fa fa-times"></i></div>
                                <div class="ss-rule-text">Block <strong>common / breached passwords</strong> (HaveIBeenPwned check)</div>
                                <label class="ss-switch"><input type="checkbox"><span class="ss-switch-track"></span></label>
                            </li>
                        </ul>
                    </div>

                    <div class="ss-divider"></div>

                    <!-- Password Expiry -->
                    <div class="ss-section">
                        <div class="ss-section-title"><i class="fa fa-calendar-times"></i> Password Expiry <span style="font-size:11px;font-weight:500;background:var(--bg);color:var(--text-hint);border:1px solid var(--border);border-radius:20px;padding:2px 8px;margin-left:4px">Optional</span></div>
                        <p class="ss-section-desc">Force team members to change their password after a set number of days. Useful for compliance. Leave disabled if you prefer member-controlled rotation.</p>

                        <div class="ss-toggle-card" style="margin-bottom:16px">
                            <div class="ss-toggle-row">
                                <div><div class="ss-toggle-label">Enable Password Expiry</div><div class="ss-toggle-sub">Members will be prompted to set a new password after the expiry period</div></div>
                                <label class="ss-switch"><input type="checkbox" id="expiryToggle" onchange="toggleExpiryFields(this)"><span class="ss-switch-track"></span></label>
                            </div>
                        </div>

                        <div id="expiryFields" style="display:none">
                            <div class="ss-grid-3">
                                <div class="ss-field">
                                    <label class="ss-label">Password Expires After</label>
                                    <div class="ss-input-wrap">
                                        <input type="number" class="ss-input" value="90" min="1" max="365" style="border-radius:var(--radius-md) 0 0 var(--radius-md)">
                                        <span class="ss-input-suffix">days</span>
                                    </div>
                                    <span class="ss-hint">90 days is industry standard</span>
                                </div>
                                <div class="ss-field">
                                    <label class="ss-label">Reminder Before Expiry</label>
                                    <div class="ss-input-wrap">
                                        <input type="number" class="ss-input" value="7" min="1" max="30" style="border-radius:var(--radius-md) 0 0 var(--radius-md)">
                                        <span class="ss-input-suffix">days</span>
                                    </div>
                                    <span class="ss-hint">Days before expiry to show reminder</span>
                                </div>
                                <div class="ss-field">
                                    <label class="ss-label">Grace Period After Expiry</label>
                                    <div class="ss-input-wrap">
                                        <input type="number" class="ss-input" value="3" min="0" max="14" style="border-radius:var(--radius-md) 0 0 var(--radius-md)">
                                        <span class="ss-input-suffix">days</span>
                                    </div>
                                    <span class="ss-hint">Login still allowed but forced to change</span>
                                </div>
                            </div>

                            <div class="ss-toggle-card" style="margin-top:14px">
                                <div class="ss-toggle-row">
                                    <div><div class="ss-toggle-label">Send Email Reminder Before Expiry</div><div class="ss-toggle-sub">Notify member via email 7 days (configurable) before their password expires</div></div>
                                    <label class="ss-switch"><input type="checkbox" checked><span class="ss-switch-track"></span></label>
                                </div>
                                <div class="ss-toggle-row">
                                    <div><div class="ss-toggle-label">Block Login After Grace Period</div><div class="ss-toggle-sub">If password not changed within grace period, block login until changed</div></div>
                                    <label class="ss-switch"><input type="checkbox" checked><span class="ss-switch-track"></span></label>
                                </div>
                                <div class="ss-toggle-row">
                                    <div><div class="ss-toggle-label">Exempt Super Admin</div><div class="ss-toggle-sub">Super admin account is not subject to expiry rules</div></div>
                                    <label class="ss-switch"><input type="checkbox"><span class="ss-switch-track"></span></label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ss-action-bar">
                        <span style="font-size:12px;color:var(--text-hint)"><i class="fa fa-info-circle"></i> Policy applies to all team members on next login</span>
                        <div style="display:flex;gap:8px"><button class="ss-btn ss-btn-secondary">Discard</button><button class="ss-btn ss-btn-primary" onclick="saveTab('Password Policy')"><i class="fa fa-save"></i> Save</button></div>
                    </div>
                </div>

                <!-- ══════════════════════════════
                     TAB 3 — SESSION
                ══════════════════════════════ -->
                <div class="ss-panel" id="tab-session">

                    <div class="ss-section">
                        <div class="ss-section-title"><i class="fa fa-clock-o"></i> Session Timeout Settings</div>
                        <p class="ss-section-desc">Control how long an admin session stays active. Idle sessions are automatically expired to protect the panel if left unattended.</p>

                        <div class="ss-grid-2" style="margin-bottom:20px">
                            <div class="ss-field">
                                <label class="ss-label">Idle Session Timeout</label>
                                <div class="ss-input-wrap">
                                    <input type="number" class="ss-input" value="30" min="5" max="480" style="border-radius:var(--radius-md) 0 0 var(--radius-md)">
                                    <select class="ss-select" style="border-radius:0 var(--radius-md) var(--radius-md) 0;border-left:none;width:110px;flex-shrink:0"><option>Minutes</option><option>Hours</option></select>
                                </div>
                                <span class="ss-hint">Auto-logout after this much inactivity. Recommended: 15–30 min</span>
                            </div>
                            <div class="ss-field">
                                <label class="ss-label">Absolute Session Limit</label>
                                <div class="ss-input-wrap">
                                    <input type="number" class="ss-input" value="8" min="1" max="72" style="border-radius:var(--radius-md) 0 0 var(--radius-md)">
                                    <select class="ss-select" style="border-radius:0 var(--radius-md) var(--radius-md) 0;border-left:none;width:110px;flex-shrink:0"><option>Minutes</option><option selected>Hours</option><option>Days</option></select>
                                </div>
                                <span class="ss-hint">Force logout after this duration regardless of activity</span>
                            </div>
                            <div class="ss-field">
                                <label class="ss-label">Warning Before Timeout</label>
                                <div class="ss-input-wrap">
                                    <input type="number" class="ss-input" value="5" min="1" max="15" style="border-radius:var(--radius-md) 0 0 var(--radius-md)">
                                    <span class="ss-input-suffix">minutes before</span>
                                </div>
                                <span class="ss-hint">Show a countdown popup before auto-logout</span>
                            </div>
                            <div class="ss-field">
                                <label class="ss-label">Max Concurrent Sessions</label>
                                <select class="ss-select">
                                    <option>1 (Single session only)</option>
                                    <option selected>2</option>
                                    <option>3</option>
                                    <option>5</option>
                                    <option>Unlimited</option>
                                </select>
                                <span class="ss-hint">Limit how many devices can be logged in simultaneously</span>
                            </div>
                        </div>

                        <div class="ss-toggle-card">
                            <div class="ss-toggle-row">
                                <div><div class="ss-toggle-label">Remember Me Option on Login Page</div><div class="ss-toggle-sub">Allow team members to stay logged in for extended period (30 days)</div></div>
                                <label class="ss-switch"><input type="checkbox" checked><span class="ss-switch-track"></span></label>
                            </div>
                            <div class="ss-toggle-row">
                                <div><div class="ss-toggle-label">Invalidate All Sessions on Password Change</div><div class="ss-toggle-sub">Log out all active sessions when a member changes their password</div></div>
                                <label class="ss-switch"><input type="checkbox" checked><span class="ss-switch-track"></span></label>
                            </div>
                            <div class="ss-toggle-row">
                                <div><div class="ss-toggle-label">Show Timeout Warning Popup</div><div class="ss-toggle-sub">Display a warning dialog with a countdown before the session expires</div></div>
                                <label class="ss-switch"><input type="checkbox" checked><span class="ss-switch-track"></span></label>
                            </div>
                            <div class="ss-toggle-row">
                                <div><div class="ss-toggle-label">Secure Cookie (HTTPS Only)</div><div class="ss-toggle-sub">Session cookies are only transmitted over HTTPS connections</div></div>
                                <label class="ss-switch"><input type="checkbox" checked><span class="ss-switch-track"></span></label>
                            </div>
                            <div class="ss-toggle-row">
                                <div><div class="ss-toggle-label">HttpOnly Cookie</div><div class="ss-toggle-sub">Prevent JavaScript from accessing session cookies (XSS protection)</div></div>
                                <label class="ss-switch"><input type="checkbox" checked><span class="ss-switch-track"></span></label>
                            </div>
                            <div class="ss-toggle-row">
                                <div><div class="ss-toggle-label">Log Session Events</div><div class="ss-toggle-sub">Record login, logout, and timeout events in the Activity Log</div></div>
                                <label class="ss-switch"><input type="checkbox" checked><span class="ss-switch-track"></span></label>
                            </div>
                        </div>
                    </div>

                    <div class="ss-action-bar">
                        <span style="font-size:12px;color:var(--text-hint)"><i class="fa fa-info-circle"></i> Changes apply to new sessions only. Existing sessions are not affected.</span>
                        <div style="display:flex;gap:8px"><button class="ss-btn ss-btn-secondary">Discard</button><button class="ss-btn ss-btn-primary" onclick="saveTab('Session Settings')"><i class="fa fa-save"></i> Save</button></div>
                    </div>
                </div>

                <!-- ══════════════════════════════
                     TAB 4 — reCAPTCHA
                ══════════════════════════════ -->
                <div class="ss-panel" id="tab-captcha">

                    <div class="ss-section">
                        <div class="ss-section-title"><i class="fa fa-robot"></i> Google reCAPTCHA</div>
                        <p class="ss-section-desc">Protect the admin login page from bots and automated attacks using Google reCAPTCHA. Get your keys from <a href="https://www.google.com/recaptcha/admin" target="_blank" style="color:var(--navy);font-weight:600">Google reCAPTCHA Admin Console</a>.</p>

                        <div class="ss-toggle-card" style="margin-bottom:20px">
                            <div class="ss-toggle-row">
                                <div><div class="ss-toggle-label">Enable reCAPTCHA on Admin Login</div><div class="ss-toggle-sub">Show reCAPTCHA challenge on the admin login page</div></div>
                                <label class="ss-switch"><input type="checkbox" checked id="captchaToggle" onchange="toggleCaptchaFields(this)"><span class="ss-switch-track"></span></label>
                            </div>
                        </div>

                        <!-- Version selector -->
                        <label class="ss-label" style="margin-bottom:10px;display:block">reCAPTCHA Version</label>
                        <div class="ss-recaptcha-version">
                            <div class="ss-rv-opt sel" onclick="selectRv(this,'v2')">
                                <div class="ss-rv-opt-title">v2 — Checkbox</div>
                                <div class="ss-rv-opt-desc">"I'm not a robot" tick box. Visible to user. Good for simple protection.</div>
                            </div>
                            <div class="ss-rv-opt" onclick="selectRv(this,'v2i')">
                                <div class="ss-rv-opt-title">v2 — Invisible</div>
                                <div class="ss-rv-opt-desc">No visible widget. Challenge only appears if suspicious activity detected.</div>
                            </div>
                            <div class="ss-rv-opt" onclick="selectRv(this,'v3')">
                                <div class="ss-rv-opt-title">v3 — Score Based</div>
                                <div class="ss-rv-opt-desc">Returns a risk score (0.0–1.0). No user interaction needed. Most seamless.</div>
                            </div>
                        </div>

                        <div id="captchaFields">
                            <div class="ss-grid-2">
                                <div class="ss-field">
                                    <label class="ss-label">Site Key <span class="ss-req">*</span></label>
                                    <input type="text" class="ss-input mono" placeholder="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI" value="">
                                    <span class="ss-hint">Public key — used in frontend HTML</span>
                                </div>
                                <div class="ss-field">
                                    <label class="ss-label">Secret Key <span class="ss-req">*</span></label>
                                    <div style="position:relative">
                                        <input type="password" id="captchaSecret" class="ss-input mono" placeholder="••••••••••••••••••••••••••••••••••••••••" value="">
                                        <button type="button" onclick="toggleSecret('captchaSecret',this)" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--text-hint)"><i class="fa fa-eye"></i></button>
                                    </div>
                                    <span class="ss-hint">Private key — used only in server-side verification</span>
                                </div>
                            </div>

                            <!-- v3 score threshold -->
                            <div class="ss-field" style="margin-top:4px">
                                <label class="ss-label">v3 Minimum Score Threshold</label>
                                <div class="ss-grid-3">
                                    <div>
                                        <input type="range" min="0" max="10" value="5" step="1" oninput="updateScore(this)" style="width:100%;accent-color:var(--navy)">
                                        <div style="display:flex;justify-content:space-between;font-size:11px;color:var(--text-hint);margin-top:4px"><span>0.0 (allow all)</span><span id="scoreLabel">0.5</span><span>1.0 (block all)</span></div>
                                    </div>
                                    <div style="grid-column:2/-1">
                                        <div class="ss-callout blue" style="margin:0"><i class="fa fa-info-circle"></i><span>Requests with a score <strong>below</strong> this value will be blocked. 0.5 is a good starting point — increase if you see bot traffic, decrease if legitimate users are blocked.</span></div>
                                    </div>
                                </div>
                            </div>

                            <div class="ss-toggle-card" style="margin-top:16px">
                                <div class="ss-toggle-row">
                                    <div><div class="ss-toggle-label">Show reCAPTCHA Only After Failed Attempts</div><div class="ss-toggle-sub">Show CAPTCHA only after the first failed login attempt (less friction for normal users)</div></div>
                                    <label class="ss-switch"><input type="checkbox" checked><span class="ss-switch-track"></span></label>
                                </div>
                                <div class="ss-toggle-row">
                                    <div><div class="ss-toggle-label">Apply on Password Reset Page</div><div class="ss-toggle-sub">Also require CAPTCHA on the Forgot Password form</div></div>
                                    <label class="ss-switch"><input type="checkbox" checked><span class="ss-switch-track"></span></label>
                                </div>
                                <div class="ss-toggle-row">
                                    <div><div class="ss-toggle-label">Bypass reCAPTCHA for Known IPs</div><div class="ss-toggle-sub">Skip CAPTCHA for whitelisted office IP addresses</div></div>
                                    <label class="ss-switch"><input type="checkbox"><span class="ss-switch-track"></span></label>
                                </div>
                            </div>

                            <div class="ss-field" style="margin-top:16px">
                                <label class="ss-label">Whitelisted IPs (one per line, optional)</label>
                                <textarea class="ss-input" style="height:80px;padding:10px 12px;resize:vertical;font-family:'SF Mono','Fira Code',monospace;font-size:12.5px" placeholder="192.168.1.0/24&#10;103.21.45.8"></textarea>
                                <span class="ss-hint">These IPs will skip reCAPTCHA verification entirely</span>
                            </div>

                            <!-- Test connection -->
                            <div style="margin-top:16px;display:flex;gap:10px;align-items:center">
                                <button class="ss-btn ss-btn-secondary" onclick="testCaptcha()"><i class="fa fa-plug"></i> Test reCAPTCHA Connection</button>
                                <span style="font-size:12px;color:var(--text-hint)" id="captchaTestResult"></span>
                            </div>
                        </div>
                    </div>

                    <div class="ss-action-bar">
                        <span style="font-size:12px;color:var(--text-hint)"><i class="fa fa-info-circle"></i> Keys are stored encrypted. Never share your Secret Key publicly.</span>
                        <div style="display:flex;gap:8px"><button class="ss-btn ss-btn-secondary">Discard</button><button class="ss-btn ss-btn-primary" onclick="saveTab('reCAPTCHA Settings')"><i class="fa fa-save"></i> Save</button></div>
                    </div>
                </div>

                <!-- ══════════════════════════════
                     TAB 5 — BACKUP
                ══════════════════════════════ -->
                <div class="ss-panel" id="tab-backup">

                    <!-- Google Drive connection -->
                    <div class="ss-section">
                        <div class="ss-section-title"><i class="fa fa-cloud"></i> Backup Storage — Google Drive</div>
                        <p class="ss-section-desc">Connect your Google Drive account to automatically store encrypted backups. Backups include the database, uploaded files, and settings.</p>

                        <!-- Connection status card -->
                        <div class="ss-backup-status">
                            <div class="ss-backup-icon disconnected"><i class="fa fa-google"></i></div>
                            <div>
                                <div class="ss-backup-name">Google Drive</div>
                                <div class="ss-backup-meta" id="driveStatus">Not connected — click Connect to link your Google account</div>
                            </div>
                            <div class="ss-backup-actions">
                                <button class="ss-btn ss-btn-secondary ss-btn-sm" id="driveDisconnectBtn" style="display:none" onclick="disconnectDrive()"><i class="fa fa-unlink"></i> Disconnect</button>
                                <button class="ss-btn ss-btn-green ss-btn-sm" id="driveConnectBtn" onclick="connectDrive()"><i class="fa fa-google"></i> Connect Google Drive</button>
                            </div>
                        </div>

                        <div class="ss-grid-2">
                            <div class="ss-field">
                                <label class="ss-label">Backup Folder Name</label>
                                <input type="text" class="ss-input" value="Oudhyana_Admin_Backups" placeholder="Folder in Google Drive root">
                                <span class="ss-hint">This folder will be created in your Google Drive</span>
                            </div>
                            <div class="ss-field">
                                <label class="ss-label">Max Backups to Retain</label>
                                <select class="ss-select">
                                    <option>5 backups</option>
                                    <option>10 backups</option>
                                    <option selected>15 backups</option>
                                    <option>30 backups</option>
                                    <option>Unlimited</option>
                                </select>
                                <span class="ss-hint">Older backups are auto-deleted when limit is reached</span>
                            </div>
                        </div>
                    </div>

                    <div class="ss-divider"></div>

                    <!-- Backup schedule -->
                    <div class="ss-section">
                        <div class="ss-section-title"><i class="fa fa-calendar-check"></i> Backup Schedule</div>
                        <p class="ss-section-desc">Set when automatic backups should run. You can also trigger a manual backup at any time.</p>

                        <div class="ss-toggle-card" style="margin-bottom:16px">
                            <div class="ss-toggle-row">
                                <div><div class="ss-toggle-label">Enable Automatic Backup</div><div class="ss-toggle-sub">Backups run automatically on your chosen schedule</div></div>
                                <label class="ss-switch"><input type="checkbox" checked><span class="ss-switch-track"></span></label>
                            </div>
                        </div>

                        <div class="ss-grid-2" style="margin-bottom:16px">
                            <div class="ss-field">
                                <label class="ss-label">Backup Frequency</label>
                                <select class="ss-select" onchange="toggleDayPicker(this)">
                                    <option value="daily" selected>Daily</option>
                                    <option value="weekly">Weekly (choose days)</option>
                                    <option value="custom">Custom (choose days)</option>
                                </select>
                            </div>
                            <div class="ss-field">
                                <label class="ss-label">Backup Time</label>
                                <input type="time" class="ss-input" value="02:00">
                                <span class="ss-hint">Recommended: 2–4 AM (low traffic)</span>
                            </div>
                        </div>

                        <!-- Day picker (shown for weekly/custom) -->
                        <div class="ss-field" id="dayPickerWrap" style="display:none">
                            <label class="ss-label">Select Days</label>
                            <div class="ss-day-grid">
                                <span class="ss-day-chip" onclick="toggleDay(this)">Mon</span>
                                <span class="ss-day-chip sel" onclick="toggleDay(this)">Tue</span>
                                <span class="ss-day-chip" onclick="toggleDay(this)">Wed</span>
                                <span class="ss-day-chip sel" onclick="toggleDay(this)">Thu</span>
                                <span class="ss-day-chip" onclick="toggleDay(this)">Fri</span>
                                <span class="ss-day-chip" onclick="toggleDay(this)">Sat</span>
                                <span class="ss-day-chip" onclick="toggleDay(this)">Sun</span>
                            </div>
                        </div>

                        <div class="ss-grid-3" style="margin-top:4px">
                            <div class="ss-field">
                                <label class="ss-label">Backup Type</label>
                                <select class="ss-select">
                                    <option selected>Full (DB + Files)</option>
                                    <option>Database Only</option>
                                    <option>Files Only</option>
                                </select>
                            </div>
                            <div class="ss-field">
                                <label class="ss-label">Compression</label>
                                <select class="ss-select">
                                    <option selected>GZIP (.gz)</option>
                                    <option>ZIP (.zip)</option>
                                    <option>None (raw)</option>
                                </select>
                            </div>
                            <div class="ss-field">
                                <label class="ss-label">Encryption</label>
                                <select class="ss-select">
                                    <option selected>AES-256 Encrypted</option>
                                    <option>No Encryption</option>
                                </select>
                            </div>
                        </div>

                        <div class="ss-toggle-card" style="margin-top:14px">
                            <div class="ss-toggle-row">
                                <div><div class="ss-toggle-label">Email Notification on Backup Success</div><div class="ss-toggle-sub">Send a confirmation email to admin after each successful backup</div></div>
                                <label class="ss-switch"><input type="checkbox" checked><span class="ss-switch-track"></span></label>
                            </div>
                            <div class="ss-toggle-row">
                                <div><div class="ss-toggle-label">Alert on Backup Failure</div><div class="ss-toggle-sub">Immediately notify admin if a scheduled backup fails</div></div>
                                <label class="ss-switch"><input type="checkbox" checked><span class="ss-switch-track"></span></label>
                            </div>
                        </div>

                        <!-- Manual backup trigger -->
                        <div style="margin-top:20px;background:var(--bg);border:1px solid var(--border);border-radius:var(--radius-md);padding:16px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px">
                            <div>
                                <div style="font-size:13.5px;font-weight:650;color:var(--text-primary)">Run Backup Now</div>
                                <div style="font-size:12px;color:var(--text-hint);margin-top:2px">Trigger an immediate backup outside the schedule. Last backup: <strong style="color:var(--text-primary)">25 Jun 2026, 02:00 AM</strong></div>
                            </div>
                            <button class="ss-btn ss-btn-navy" onclick="runBackup()"><i class="fa fa-cloud-upload"></i> Backup Now</button>
                        </div>
                    </div>

                    <div class="ss-divider"></div>

                    <!-- Backup history -->
                    <div class="ss-section">
                        <div class="ss-section-title"><i class="fa fa-history"></i> Backup History</div>
                        <p class="ss-section-desc">Last 10 backup records. Click the download icon to restore a backup file from Google Drive.</p>

                        <div style="border:1px solid var(--border);border-radius:var(--radius-md);overflow:hidden">
                            <table class="ss-bk-table">
                                <thead>
                                    <tr>
                                        <th>Date &amp; Time</th>
                                        <th>Type</th>
                                        <th>Size</th>
                                        <th>Status</th>
                                        <th>Destination</th>
                                        <th style="text-align:center;width:80px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td style="font-size:13px;font-weight:500">25 Jun 2026, 02:00 AM</td><td><span style="font-size:12.5px;color:var(--text-secondary)">Full</span></td><td><span style="font-size:12.5px;font-weight:600">284 MB</span></td><td><span class="ss-badge success">Success</span></td><td><span style="font-size:12px;color:var(--text-hint)"><i class="fa fa-google" style="margin-right:5px"></i>Google Drive</span></td><td style="text-align:center"><button class="ss-btn ss-btn-secondary ss-btn-sm"><i class="fa fa-download"></i></button></td></tr>
                                    <tr><td style="font-size:13px;font-weight:500">24 Jun 2026, 02:00 AM</td><td><span style="font-size:12.5px;color:var(--text-secondary)">Full</span></td><td><span style="font-size:12.5px;font-weight:600">281 MB</span></td><td><span class="ss-badge success">Success</span></td><td><span style="font-size:12px;color:var(--text-hint)"><i class="fa fa-google" style="margin-right:5px"></i>Google Drive</span></td><td style="text-align:center"><button class="ss-btn ss-btn-secondary ss-btn-sm"><i class="fa fa-download"></i></button></td></tr>
                                    <tr><td style="font-size:13px;font-weight:500">23 Jun 2026, 02:00 AM</td><td><span style="font-size:12.5px;color:var(--text-secondary)">Full</span></td><td><span style="font-size:12.5px;font-weight:600">279 MB</span></td><td><span class="ss-badge fail">Failed</span></td><td><span style="font-size:12px;color:var(--text-hint)"><i class="fa fa-google" style="margin-right:5px"></i>Google Drive</span></td><td style="text-align:center"><button class="ss-btn ss-btn-secondary ss-btn-sm" disabled style="opacity:.4"><i class="fa fa-download"></i></button></td></tr>
                                    <tr><td style="font-size:13px;font-weight:500">22 Jun 2026, 02:00 AM</td><td><span style="font-size:12.5px;color:var(--text-secondary)">Full</span></td><td><span style="font-size:12.5px;font-weight:600">277 MB</span></td><td><span class="ss-badge success">Success</span></td><td><span style="font-size:12px;color:var(--text-hint)"><i class="fa fa-google" style="margin-right:5px"></i>Google Drive</span></td><td style="text-align:center"><button class="ss-btn ss-btn-secondary ss-btn-sm"><i class="fa fa-download"></i></button></td></tr>
                                    <tr><td style="font-size:13px;font-weight:500">21 Jun 2026, 02:00 AM</td><td><span style="font-size:12.5px;color:var(--text-secondary)">Full</span></td><td><span style="font-size:12.5px;font-weight:600">276 MB</span></td><td><span class="ss-badge success">Success</span></td><td><span style="font-size:12px;color:var(--text-hint)"><i class="fa fa-google" style="margin-right:5px"></i>Google Drive</span></td><td style="text-align:center"><button class="ss-btn ss-btn-secondary ss-btn-sm"><i class="fa fa-download"></i></button></td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="ss-action-bar">
                        <span style="font-size:12px;color:var(--text-hint)"><i class="fa fa-info-circle"></i> Backups are encrypted with AES-256 before upload</span>
                        <div style="display:flex;gap:8px"><button class="ss-btn ss-btn-secondary">Discard</button><button class="ss-btn ss-btn-primary" onclick="saveTab('Backup Settings')"><i class="fa fa-save"></i> Save</button></div>
                    </div>
                </div>

                <!-- ══════════════════════════════
                     TAB 6 — ADVANCED
                ══════════════════════════════ -->
                <div class="ss-panel" id="tab-misc">

                    <div class="ss-section">
                        <div class="ss-section-title"><i class="fa fa-shield-virus"></i> IP Restriction & Whitelisting</div>
                        <p class="ss-section-desc">Restrict admin panel access to specific IP addresses or ranges. Useful if your team works from fixed office IPs.</p>
                        <div class="ss-toggle-card" style="margin-bottom:14px">
                            <div class="ss-toggle-row">
                                <div><div class="ss-toggle-label">Enable IP Whitelist</div><div class="ss-toggle-sub">Only IPs listed below can access the admin panel. All others are blocked.</div></div>
                                <label class="ss-switch"><input type="checkbox"><span class="ss-switch-track"></span></label>
                            </div>
                        </div>
                        <div class="ss-field">
                            <label class="ss-label">Allowed IPs / CIDR Ranges</label>
                            <textarea class="ss-input" style="height:90px;padding:10px 12px;resize:vertical;font-family:'SF Mono','Fira Code',monospace;font-size:12.5px" placeholder="192.168.1.0/24&#10;103.21.45.8&#10;49.36.12.0/24"></textarea>
                            <span class="ss-hint">One IP or CIDR per line. Your current IP: <strong>103.21.45.8</strong></span>
                        </div>
                    </div>

                    <div class="ss-divider"></div>

                    <div class="ss-section">
                        <div class="ss-section-title"><i class="fa fa-sign-in-alt"></i> Two-Factor Authentication (2FA)</div>
                        <p class="ss-section-desc">Add an extra layer of security requiring a second verification step at login.</p>
                        <div class="ss-toggle-card">
                            <div class="ss-toggle-row">
                                <div><div class="ss-toggle-label">Enable 2FA for All Team Members</div><div class="ss-toggle-sub">Members must set up an authenticator app (Google Auth / Authy) on next login</div></div>
                                <label class="ss-switch"><input type="checkbox"><span class="ss-switch-track"></span></label>
                            </div>
                            <div class="ss-toggle-row">
                                <div><div class="ss-toggle-label">2FA via Email OTP (Fallback)</div><div class="ss-toggle-sub">Send OTP to registered email if authenticator app is unavailable</div></div>
                                <label class="ss-switch"><input type="checkbox" checked><span class="ss-switch-track"></span></label>
                            </div>
                            <div class="ss-toggle-row">
                                <div><div class="ss-toggle-label">Trust Device for 30 Days</div><div class="ss-toggle-sub">After 2FA, allow device to be trusted so it doesn't ask every login</div></div>
                                <label class="ss-switch"><input type="checkbox" checked><span class="ss-switch-track"></span></label>
                            </div>
                            <div class="ss-toggle-row">
                                <div><div class="ss-toggle-label">Mandatory 2FA for Super Admin</div><div class="ss-toggle-sub">Always require 2FA for the Super Admin account, regardless of global setting</div></div>
                                <label class="ss-switch"><input type="checkbox" checked><span class="ss-switch-track"></span></label>
                            </div>
                        </div>
                    </div>

                    <div class="ss-divider"></div>

                    <div class="ss-section">
                        <div class="ss-section-title"><i class="fa fa-eye-slash"></i> Content Security & Headers</div>
                        <p class="ss-section-desc">HTTP security headers protect against XSS, clickjacking, and other common attacks.</p>
                        <div class="ss-toggle-card">
                            <div class="ss-toggle-row">
                                <div><div class="ss-toggle-label">Force HTTPS (HSTS)</div><div class="ss-toggle-sub">Redirect all HTTP requests to HTTPS and send HSTS header</div></div>
                                <label class="ss-switch"><input type="checkbox" checked><span class="ss-switch-track"></span></label>
                            </div>
                            <div class="ss-toggle-row">
                                <div><div class="ss-toggle-label">X-Frame-Options: DENY</div><div class="ss-toggle-sub">Prevent the admin panel from being embedded in iframes (clickjacking protection)</div></div>
                                <label class="ss-switch"><input type="checkbox" checked><span class="ss-switch-track"></span></label>
                            </div>
                            <div class="ss-toggle-row">
                                <div><div class="ss-toggle-label">Content Security Policy (CSP)</div><div class="ss-toggle-sub">Restrict which resources can be loaded. Reduces XSS risk.</div></div>
                                <label class="ss-switch"><input type="checkbox"><span class="ss-switch-track"></span></label>
                            </div>
                            <div class="ss-toggle-row">
                                <div><div class="ss-toggle-label">X-Content-Type-Options: nosniff</div><div class="ss-toggle-sub">Prevent browsers from MIME-type sniffing</div></div>
                                <label class="ss-switch"><input type="checkbox" checked><span class="ss-switch-track"></span></label>
                            </div>
                        </div>
                    </div>

                    <div class="ss-divider"></div>

                    <div class="ss-section">
                        <div class="ss-section-title"><i class="fa fa-exclamation-triangle"></i> Danger Zone</div>
                        <p class="ss-section-desc">These actions are destructive. Use with caution.</p>
                        <div style="display:flex;flex-direction:column;gap:10px">
                            <div style="background:var(--red-bg);border:1px solid var(--red-border);border-radius:var(--radius-md);padding:14px 16px;display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap">
                                <div><div style="font-size:13px;font-weight:650;color:var(--red)">Force Logout All Sessions</div><div style="font-size:12px;color:var(--red);opacity:.75;margin-top:2px">Instantly terminate all active admin sessions across all devices</div></div>
                                <button class="ss-btn ss-btn-red" onclick="forceLogoutAll()"><i class="fa fa-sign-out"></i> Force Logout All</button>
                            </div>
                            <div style="background:var(--red-bg);border:1px solid var(--red-border);border-radius:var(--radius-md);padding:14px 16px;display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap">
                                <div><div style="font-size:13px;font-weight:650;color:var(--red)">Clear All Blocked IPs</div><div style="font-size:12px;color:var(--red);opacity:.75;margin-top:2px">Remove all auto-blocked IPs from the security blacklist</div></div>
                                <button class="ss-btn ss-btn-red" onclick="clearBlockedIPs()"><i class="fa fa-ban"></i> Clear Blocked IPs</button>
                            </div>
                        </div>
                    </div>

                    <div class="ss-action-bar">
                        <span style="font-size:12px;color:var(--text-hint)"><i class="fa fa-info-circle"></i> Security header changes may require server cache clear</span>
                        <div style="display:flex;gap:8px"><button class="ss-btn ss-btn-secondary">Discard</button><button class="ss-btn ss-btn-primary" onclick="saveTab('Advanced Security')"><i class="fa fa-save"></i> Save</button></div>
                    </div>
                </div>

            </div><!-- /.ss-shell -->
        </div>
    </div>
</div>

@include('admin.footer')

<script>
/* ── Tab switcher ── */
function switchTab(name, btn) {
    document.querySelectorAll('.ss-tab-btn').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.ss-panel').forEach(p => p.classList.remove('active'));
    btn.classList.add('active');
    document.getElementById('tab-' + name).classList.add('active');
}

/* ── Password expiry fields toggle ── */
function toggleExpiryFields(cb) {
    document.getElementById('expiryFields').style.display = cb.checked ? 'block' : 'none';
}

/* ── reCAPTCHA fields toggle ── */
function toggleCaptchaFields(cb) {
    document.getElementById('captchaFields').style.display = cb.checked ? 'block' : 'none';
}

/* ── reCAPTCHA version selector ── */
function selectRv(el, val) {
    document.querySelectorAll('.ss-rv-opt').forEach(o => o.classList.remove('sel'));
    el.classList.add('sel');
}

/* ── Score label ── */
function updateScore(inp) {
    document.getElementById('scoreLabel').textContent = (inp.value / 10).toFixed(1);
}

/* ── Secret key toggle ── */
function toggleSecret(id, btn) {
    const inp = document.getElementById(id);
    const isPass = inp.type === 'password';
    inp.type = isPass ? 'text' : 'password';
    btn.querySelector('i').className = isPass ? 'fa fa-eye-slash' : 'fa fa-eye';
}

/* ── Day picker ── */
function toggleDayPicker(sel) {
    document.getElementById('dayPickerWrap').style.display = sel.value !== 'daily' ? 'block' : 'none';
}
function toggleDay(el) { el.classList.toggle('sel'); }

/* ── reCAPTCHA test ── */
function testCaptcha() {
    const res = document.getElementById('captchaTestResult');
    res.textContent = 'Testing…';
    setTimeout(() => { res.innerHTML = '<span style="color:#007a5e"><i class="fa fa-check-circle"></i> Connection successful</span>'; }, 1200);
}

/* ── Google Drive connect/disconnect ── */
function connectDrive() {
    Swal.fire({ title:'Connecting to Google Drive…', text:'You will be redirected to Google OAuth.', timer:1800, showConfirmButton:false, didOpen:() => Swal.showLoading() })
    .then(() => {
        document.getElementById('driveStatus').innerHTML = '<span style="color:#007a5e"><i class="fa fa-check-circle" style="margin-right:5px"></i>Connected as <strong>admin@oudhyana.com</strong> &nbsp;·&nbsp; 12.4 GB free</span>';
        document.querySelector('.ss-backup-icon').className = 'ss-backup-icon connected';
        document.querySelector('.ss-backup-icon i').className = 'fa fa-google';
        document.getElementById('driveConnectBtn').style.display = 'none';
        document.getElementById('driveDisconnectBtn').style.display = '';
        Swal.fire({ icon:'success', title:'Google Drive Connected!', timer:1600, showConfirmButton:false });
    });
}
function disconnectDrive() {
    Swal.fire({ title:'Disconnect Google Drive?', text:'Scheduled backups will stop until reconnected.', icon:'warning', showCancelButton:true, confirmButtonColor:'#c0392b', confirmButtonText:'Disconnect' })
    .then(r => {
        if (r.isConfirmed) {
            document.getElementById('driveStatus').textContent = 'Not connected — click Connect to link your Google account';
            document.querySelector('.ss-backup-icon').className = 'ss-backup-icon disconnected';
            document.getElementById('driveConnectBtn').style.display = '';
            document.getElementById('driveDisconnectBtn').style.display = 'none';
        }
    });
}

/* ── Run backup now ── */
function runBackup() {
    Swal.fire({ title:'Starting Backup…', html:'Packaging database and files…', timer:3000, timerProgressBar:true, showConfirmButton:false, didOpen:() => Swal.showLoading() })
    .then(() => Swal.fire({ icon:'success', title:'Backup Complete!', text:'284 MB uploaded to Google Drive successfully.', timer:2000, showConfirmButton:false }));
}

/* ── Danger zone ── */
function forceLogoutAll() {
    Swal.fire({ title:'Force logout all sessions?', text:'All team members will be logged out immediately.', icon:'warning', showCancelButton:true, confirmButtonColor:'#c0392b', confirmButtonText:'Yes, Force Logout' })
    .then(r => { if (r.isConfirmed) Swal.fire({ icon:'success', title:'Done!', text:'All active sessions terminated.', timer:1600, showConfirmButton:false }); });
}
function clearBlockedIPs() {
    Swal.fire({ title:'Clear all blocked IPs?', icon:'warning', showCancelButton:true, confirmButtonColor:'#c0392b', confirmButtonText:'Clear All' })
    .then(r => { if (r.isConfirmed) Swal.fire({ icon:'success', title:'Cleared!', timer:1400, showConfirmButton:false }); });
}

/* ── Save ── */
function saveTab(name) {
    Swal.fire({ icon:'success', title:'Saved!', text: name + ' updated successfully.', timer:1800, showConfirmButton:false });
}
function saveAll() {
    Swal.fire({ icon:'success', title:'All Security Settings Saved!', timer:2000, showConfirmButton:false });
}
</script>