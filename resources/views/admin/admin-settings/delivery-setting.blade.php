@php
    $couriers = null;
    $rules = null;
@endphp

<div class="main-section">

<style>
:root {
    --sp-bg:#f1f2f4; --sp-surface:#fff; --sp-border:#e3e5e8; --sp-border-hover:#c9cccf;
    --sp-text-primary:#202223; --sp-text-secondary:#6d7175; --sp-text-hint:#8c9196;
    --sp-accent:#303d89; --sp-accent-hover:#2a3579; --sp-accent-light:#eef0fc;
    --sp-green:#007a5e; --sp-green-bg:#e3f1ec; --sp-green-border:#9fcfc3;
    --sp-red:#c0392b; --sp-red-bg:#fce8e8; --sp-red-border:#f5b8b8;
    --sp-amber:#916a00; --sp-amber-bg:#fff5cc; --sp-amber-border:#e8d080;
    --sp-radius-sm:6px; --sp-radius-md:8px; --sp-radius-lg:12px;
    --sp-shadow:0 1px 0 rgba(0,0,0,.05),0 0 0 1px rgba(0,0,0,.07);
    --sp-font:'Inter',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
}

/* ── Outer page wrapper ── */
.ds-page { background:var(--sp-bg); padding:24px 28px; min-height:100vh; font-family:var(--sp-font); color:var(--sp-text-primary); font-size:14px; }
.ds-page * { box-sizing:border-box; }

/* ── Main 2-column shell ── */
.ds-shell {
    display:grid;
    grid-template-columns:220px 1fr;
    background:var(--sp-surface);
    border:1px solid var(--sp-border);
    border-radius:var(--sp-radius-lg);
    box-shadow:var(--sp-shadow);
    overflow:hidden;
    min-height:600px;
}
@media(max-width:860px){.ds-shell{grid-template-columns:1fr;}}

/* ════════════════════════════════
   LEFT SIDEBAR
   ════════════════════════════════ */
.ds-sidebar {
    border-right:1px solid var(--sp-border);
    background:#fafafa;
    display:flex;
    flex-direction:column;
}

.ds-sidebar-header {
    padding:16px 18px 12px;
    border-bottom:1px solid var(--sp-border);
}
.ds-sidebar-title {
    font-size:11px; font-weight:750; text-transform:uppercase;
    letter-spacing:.08em; color:var(--sp-text-hint);
}

/* Main nav items (Delivery Rules / Courier Charges) */
.ds-main-nav { padding:8px 0; border-bottom:1px solid var(--sp-border); }
.ds-main-nav-item {
    display:flex; align-items:center; gap:9px;
    padding:10px 18px; font-size:13px; font-weight:600;
    color:var(--sp-text-secondary); cursor:pointer;
    border-left:3px solid transparent;
    transition:all .13s; user-select:none;
}
.ds-main-nav-item i { font-size:13px; color:var(--sp-text-hint); width:16px; text-align:center; flex-shrink:0; }
.ds-main-nav-item:hover { color:var(--sp-text-primary); background:rgba(48,61,137,.04); }
.ds-main-nav-item.active {
    color:var(--sp-accent); border-left-color:var(--sp-accent);
    background:var(--sp-accent-light); font-weight:650;
}
.ds-main-nav-item.active i { color:var(--sp-accent); }

/* Sub-section links (shown below active main item) */
.ds-sub-nav { padding:6px 0 8px; }
.ds-sub-label {
    font-size:9.5px; font-weight:750; text-transform:uppercase;
    letter-spacing:.08em; color:var(--sp-text-hint);
    padding:4px 18px 6px; display:block;
}
.ds-sub-nav-item {
    display:flex; align-items:center; gap:8px;
    padding:7px 18px 7px 32px; font-size:12.5px; font-weight:500;
    color:var(--sp-text-secondary); cursor:pointer;
    border-left:2px solid transparent;
    transition:all .12s; text-decoration:none;
}
.ds-sub-nav-item i { font-size:11px; color:var(--sp-text-hint); width:13px; text-align:center; flex-shrink:0; }
.ds-sub-nav-item:hover { color:var(--sp-accent); background:rgba(48,61,137,.04); }
.ds-sub-nav-item.active {
    color:var(--sp-accent); font-weight:650;
    border-left-color:var(--sp-accent);
    background:rgba(48,61,137,.06);
}
.ds-sub-nav-item.active i { color:var(--sp-accent); }

/* Courier sub-items */
.ds-courier-item {
    display:flex; align-items:center; gap:8px;
    padding:7px 18px 7px 32px; font-size:12.5px; font-weight:500;
    color:var(--sp-text-secondary); cursor:pointer;
    border-left:2px solid transparent;
    transition:all .12s;
}
.ds-courier-item:hover { color:var(--sp-accent); background:rgba(48,61,137,.04); }
.ds-courier-item.active { color:var(--sp-accent); font-weight:650; border-left-color:var(--sp-accent); background:rgba(48,61,137,.06); }
.ds-courier-badge {
    margin-left:auto; font-size:10px; font-weight:700;
    padding:1px 6px; border-radius:10px;
}
.ds-courier-badge.on  { background:var(--sp-green-bg); color:var(--sp-green); border:1px solid var(--sp-green-border); }
.ds-courier-badge.off { background:var(--sp-bg); color:var(--sp-text-hint); border:1px solid var(--sp-border); }

/* ════════════════════════════════
   RIGHT CONTENT AREA
   ════════════════════════════════ */
.ds-content { display:flex; flex-direction:column; min-height:600px; }

/* Sub-tab bar (anchor tabs at top of content) */
.ds-subtab-bar {
    display:flex; align-items:center; gap:2px;
    padding:10px 16px 0;
    border-bottom:1px solid var(--sp-border);
    background:#fafafa;
    overflow-x:auto; scrollbar-width:none;
}
.ds-subtab-bar::-webkit-scrollbar { display:none; }
.ds-subtab-btn {
    display:inline-flex; align-items:center; gap:6px;
    padding:8px 16px; font-size:12.5px; font-weight:500;
    color:var(--sp-text-secondary); border:none; background:none;
    cursor:pointer; border-bottom:2px solid transparent;
    white-space:nowrap; font-family:var(--sp-font);
    transition:color .13s,border-color .13s; margin-bottom:-1px;
}
.ds-subtab-btn i { font-size:12px; }
.ds-subtab-btn:hover { color:var(--sp-text-primary); }
.ds-subtab-btn.active { color:var(--sp-accent); border-bottom-color:var(--sp-accent); font-weight:650; }

/* Panels */
.ds-panel { display:none; flex:1; }
.ds-panel.active { display:block; }

/* Section panels within courier tab */
.ds-courier-panel { display:none; }
.ds-courier-panel.active { display:block; }

.ds-section-wrap { padding:24px 28px; }
@media(max-width:860px){.ds-section-wrap{padding:16px;}}

/* Section title */
.ds-section-title { font-size:14px; font-weight:660; color:var(--sp-text-primary); margin:0 0 4px; display:flex; align-items:center; gap:8px; }
.ds-section-title i { color:var(--sp-accent); }
.ds-section-desc { font-size:12.5px; color:var(--sp-text-hint); margin:0 0 20px; line-height:1.5; }
.ds-divider { border:none; border-top:1px solid var(--sp-border); margin:24px 0; }

/* ── Form elements ── */
.sp-form-grid   { display:grid; grid-template-columns:1fr 1fr;     gap:16px; }
.sp-form-grid-3 { display:grid; grid-template-columns:1fr 1fr 1fr; gap:14px; }
.sp-col-full    { grid-column:1/-1; }
@media(max-width:640px){.sp-form-grid,.sp-form-grid-3{grid-template-columns:1fr;}.sp-col-full{grid-column:1;}}

.sp-field { display:flex; flex-direction:column; gap:6px; }
.sp-label { font-size:11.5px; font-weight:650; color:var(--sp-text-secondary); letter-spacing:.03em; text-transform:uppercase; }
.sp-req { color:var(--sp-red); margin-left:2px; }
.sp-hint { font-size:11.5px; color:var(--sp-text-hint); margin-top:1px; line-height:1.5; }

.sp-input,.sp-select,.sp-textarea {
    width:100%; border:1px solid var(--sp-border); border-radius:var(--sp-radius-md);
    padding:0 12px; font-size:13.5px; color:var(--sp-text-primary);
    background:var(--sp-surface); outline:none;
    transition:border-color .15s,box-shadow .15s; font-family:var(--sp-font);
}
.sp-input,.sp-select { height:38px; }
.sp-textarea { padding:10px 12px; resize:vertical; min-height:80px; }
.sp-input:focus,.sp-select:focus,.sp-textarea:focus { border-color:var(--sp-accent); box-shadow:0 0 0 3px rgba(48,61,137,.10); }
.sp-input:hover:not(:focus),.sp-select:hover:not(:focus) { border-color:var(--sp-border-hover); }
.sp-input[readonly] { background:var(--sp-bg); color:var(--sp-text-secondary); cursor:not-allowed; }
.sp-input.mono { font-family:'SF Mono','Fira Code',monospace; font-size:13px; }

.sp-select-wrap { position:relative; }
.sp-select-wrap::after { content:''; pointer-events:none; position:absolute; right:12px; top:50%; transform:translateY(-50%); width:0; height:0; border-left:4px solid transparent; border-right:4px solid transparent; border-top:5px solid var(--sp-text-hint); }
.sp-select-wrap .sp-select { appearance:none; -webkit-appearance:none; }

.sp-input-wrap { display:flex; }
.sp-input-prefix,.sp-input-suffix { display:inline-flex; align-items:center; padding:0 11px; background:var(--sp-bg); border:1px solid var(--sp-border); font-size:13px; color:var(--sp-text-hint); white-space:nowrap; flex-shrink:0; }
.sp-input-prefix { border-right:none; border-radius:var(--sp-radius-md) 0 0 var(--sp-radius-md); }
.sp-input-suffix { border-left:none; border-radius:0 var(--sp-radius-md) var(--sp-radius-md) 0; }
.sp-input-wrap .sp-input { border-radius:0; }
.sp-input-wrap .sp-input:first-child { border-radius:var(--sp-radius-md) 0 0 var(--sp-radius-md); }
.sp-input-wrap .sp-input:last-child  { border-radius:0 var(--sp-radius-md) var(--sp-radius-md) 0; }

/* Toggle */
.sp-toggle-row { display:flex; align-items:center; justify-content:space-between; padding:12px 0; border-bottom:1px solid var(--sp-bg); }
.sp-toggle-row:first-child { padding-top:0; }
.sp-toggle-row:last-child  { border-bottom:none; padding-bottom:0; }
.sp-toggle-label { font-size:13px; font-weight:500; color:var(--sp-text-primary); }
.sp-toggle-sub   { font-size:12px; color:var(--sp-text-hint); margin-top:2px; }
.sp-switch { position:relative; width:38px; height:22px; flex-shrink:0; }
.sp-switch input { opacity:0; width:0; height:0; }
.sp-switch-track { position:absolute; inset:0; background:var(--sp-border); border-radius:22px; cursor:pointer; transition:background .2s; }
.sp-switch-track::after { content:''; position:absolute; left:3px; top:3px; width:16px; height:16px; background:#fff; border-radius:50%; transition:transform .2s; box-shadow:0 1px 3px rgba(0,0,0,.2); }
.sp-switch input:checked + .sp-switch-track { background:var(--sp-accent); }
.sp-switch input:checked + .sp-switch-track::after { transform:translateX(16px); }

/* Info banner */
.sp-banner { display:flex; align-items:flex-start; gap:12px; padding:12px 16px; border-radius:var(--sp-radius-md); margin-bottom:20px; font-size:13px; line-height:1.6; }
.sp-banner i { font-size:14px; flex-shrink:0; margin-top:1px; }
.sp-banner.blue  { background:#e8f2ff; border:1px solid #b8d4f5; color:#0069d9; }
.sp-banner.amber { background:var(--sp-amber-bg); border:1px solid var(--sp-amber-border); color:var(--sp-amber); }
.sp-banner.green { background:var(--sp-green-bg); border:1px solid var(--sp-green-border); color:var(--sp-green); }

/* Rule rows */
.sp-rule-row {
    display:grid; grid-template-columns:160px 1fr 1fr 1fr 38px;
    gap:10px; align-items:center; padding:12px 14px;
    background:var(--sp-surface); border:1px solid var(--sp-border);
    border-radius:var(--sp-radius-md); margin-bottom:10px;
    transition:box-shadow .15s;
}
.sp-rule-row:hover { box-shadow:0 2px 8px rgba(0,0,0,.06); }
.sp-rule-del-btn {
    display:inline-flex; align-items:center; justify-content:center;
    width:32px; height:32px; border-radius:var(--sp-radius-sm);
    border:1px solid var(--sp-border); background:var(--sp-surface);
    color:var(--sp-text-hint); cursor:pointer; transition:all .15s; flex-shrink:0;
}
.sp-rule-del-btn:hover { background:var(--sp-red-bg); border-color:var(--sp-red-border); color:var(--sp-red); }
.sp-add-rule-btn {
    display:inline-flex; align-items:center; gap:8px;
    width:100%; justify-content:center;
    border:2px dashed var(--sp-border); border-radius:var(--sp-radius-md);
    background:transparent; color:var(--sp-text-secondary);
    font-size:13px; font-weight:580; padding:11px;
    cursor:pointer; font-family:var(--sp-font); transition:all .15s; margin-top:4px;
}
.sp-add-rule-btn:hover { border-color:var(--sp-accent); background:var(--sp-accent-light); color:var(--sp-accent); }

/* Rate table */
.sp-rate-table { width:100%; border-collapse:collapse; font-size:13px; }
.sp-rate-table thead th { padding:8px 10px; background:var(--sp-bg); border:1px solid var(--sp-border); font-size:10.5px; font-weight:700; text-transform:uppercase; letter-spacing:.04em; color:var(--sp-text-hint); text-align:left; }
.sp-rate-table tbody td { padding:8px 10px; border:1px solid var(--sp-border); vertical-align:middle; }
.sp-rate-table tbody tr:hover { background:#f7f8f9; }
.sp-rate-input { width:100%; border:1px solid var(--sp-border); border-radius:var(--sp-radius-sm); padding:5px 8px; font-size:12.5px; font-family:var(--sp-font); color:var(--sp-text-primary); outline:none; transition:border-color .15s; }
.sp-rate-input:focus { border-color:var(--sp-accent); box-shadow:0 0 0 2px rgba(48,61,137,.10); }

/* Courier header card */
.ds-courier-header-card {
    display:flex; align-items:center; justify-content:space-between;
    flex-wrap:wrap; gap:12px;
    padding:16px 0; margin-bottom:20px;
    border-bottom:1px solid var(--sp-border);
}
.ds-courier-header-left { display:flex; align-items:center; gap:12px; }
.ds-courier-logo { width:42px; height:42px; border-radius:var(--sp-radius-md); display:flex; align-items:center; justify-content:center; font-size:17px; flex-shrink:0; }
.ds-courier-name { font-size:16px; font-weight:660; color:var(--sp-text-primary); }
.ds-courier-meta { font-size:12px; color:var(--sp-text-hint); margin-top:2px; }

/* API credentials box */
.sp-api-section { background:var(--sp-bg); border:1px solid var(--sp-border); border-radius:var(--sp-radius-md); padding:16px 18px; margin-top:20px; }
.sp-api-section-title { font-size:11.5px; font-weight:700; text-transform:uppercase; letter-spacing:.05em; color:var(--sp-text-hint); margin-bottom:14px; display:flex; align-items:center; gap:6px; }
.sp-api-section-title i { color:var(--sp-accent); }

/* Status pill */
.sp-pill { display:inline-flex; align-items:center; gap:4px; font-size:11.5px; font-weight:650; padding:3px 9px; border-radius:20px; white-space:nowrap; }
.sp-pill::before { content:''; width:5px; height:5px; border-radius:50%; display:inline-block; flex-shrink:0; }
.sp-pill-active   { background:var(--sp-green-bg); color:var(--sp-green); }
.sp-pill-active::before { background:var(--sp-green); }
.sp-pill-inactive { background:#f3f4f6; color:var(--sp-text-hint); }
.sp-pill-inactive::before { background:var(--sp-text-hint); }

/* Action bar */
.ds-action-bar {
    display:flex; align-items:center; justify-content:flex-end; gap:10px;
    padding:16px 28px; border-top:1px solid var(--sp-border);
    background:#fafafa; margin-top:auto;
}
.sp-btn-primary { display:inline-flex; align-items:center; gap:6px; background:var(--sp-accent); color:#fff; border:1px solid transparent; border-radius:var(--sp-radius-md); padding:9px 20px; font-size:13px; font-weight:600; cursor:pointer; font-family:var(--sp-font); transition:background .15s; white-space:nowrap; }
.sp-btn-primary:hover { background:var(--sp-accent-hover); }
.sp-btn-primary:disabled { opacity:.65; cursor:not-allowed; }
.sp-btn-secondary { display:inline-flex; align-items:center; gap:6px; background:var(--sp-surface); color:var(--sp-text-primary); border:1px solid var(--sp-border); border-radius:var(--sp-radius-md); padding:9px 20px; font-size:13px; font-weight:500; cursor:pointer; font-family:var(--sp-font); transition:all .15s; white-space:nowrap; }
.sp-btn-secondary:hover { background:var(--sp-bg); border-color:var(--sp-border-hover); }
.sp-btn-test { display:inline-flex; align-items:center; gap:6px; background:var(--sp-amber-bg); color:var(--sp-amber); border:1px solid var(--sp-amber-border); border-radius:var(--sp-radius-md); padding:9px 18px; font-size:13px; font-weight:600; cursor:pointer; font-family:var(--sp-font); transition:all .15s; white-space:nowrap; }
.sp-btn-test:hover { background:var(--sp-amber); color:#fff; }

@media(max-width:768px){ .ds-page{padding:14px;} }
</style>

<div class="app-content content container-fluid">
<div class="ds-page">

    <div class="ds-shell">

        <!-- ════════════════ LEFT SIDEBAR ════════════════ -->
        <div class="ds-sidebar">
            <div class="ds-sidebar-header">
                <span class="ds-sidebar-title">Shipping Settings</span>
            </div>

            <!-- Main nav -->
            <div class="ds-main-nav">
                <div class="ds-main-nav-item active" id="main-nav-rules" onclick="switchMain('rules')">
                    <i class="fa fa-list-check"></i> Delivery Rules
                </div>
                <div class="ds-main-nav-item" id="main-nav-couriers" onclick="switchMain('couriers')">
                    <i class="fa fa-truck"></i> Courier Charges
                </div>
            </div>

            <!-- Sub nav — Delivery Rules sections -->
            <div class="ds-sub-nav" id="subnav-rules">
                <span class="ds-sub-label">Sections</span>
                <a class="ds-sub-nav-item active" onclick="switchSubtab('rules-general',this)"><i class="fa fa-sliders"></i> General</a>
                <a class="ds-sub-nav-item" onclick="switchSubtab('rules-free',this)"><i class="fa fa-gift"></i> Free Shipping</a>
                <a class="ds-sub-nav-item" onclick="switchSubtab('rules-flat',this)"><i class="fa fa-tag"></i> Flat Rate Rules</a>
                <a class="ds-sub-nav-item" onclick="switchSubtab('rules-cod',this)"><i class="fa fa-money-bill-wave"></i> COD Charges</a>
                <a class="ds-sub-nav-item" onclick="switchSubtab('rules-pincode',this)"><i class="fa fa-map-pin"></i> Pincode Rules</a>
                <a class="ds-sub-nav-item" onclick="switchSubtab('rules-weight',this)"><i class="fa fa-weight-hanging"></i> Weight Slabs</a>
            </div>

            <!-- Sub nav — Courier items -->
            <div class="ds-sub-nav" id="subnav-couriers" style="display:none">
                <span class="ds-sub-label">Couriers</span>
                <div class="ds-courier-item active" onclick="switchCourier('delhivery',this)"><i class="fa fa-truck"></i> Delhivery<span class="ds-courier-badge on">On</span></div>
                <div class="ds-courier-item" onclick="switchCourier('shiprocket',this)"><i class="fa fa-rocket"></i> Shiprocket<span class="ds-courier-badge on">On</span></div>
                <div class="ds-courier-item" onclick="switchCourier('bluedart',this)"><i class="fa fa-box"></i> Blue Dart<span class="ds-courier-badge off">Off</span></div>
                <div class="ds-courier-item" onclick="switchCourier('fedex',this)"><i class="fa fa-plane"></i> FedEx<span class="ds-courier-badge off">Off</span></div>
                <div class="ds-courier-item" onclick="switchCourier('dtdc',this)"><i class="fa fa-car"></i> DTDC<span class="ds-courier-badge off">Off</span></div>
                <div class="ds-courier-item" onclick="switchCourier('ekart',this)"><i class="fa fa-shopping-cart"></i> Ekart<span class="ds-courier-badge off">Off</span></div>
                <div class="ds-courier-item" onclick="switchCourier('xpressbees',this)"><i class="fa fa-bolt"></i> XpressBees<span class="ds-courier-badge off">Off</span></div>
            </div>
        </div>

        <!-- ════════════════ RIGHT CONTENT ════════════════ -->
        <div class="ds-content">

            <!-- ══ DELIVERY RULES PANEL ══ -->
            <div class="ds-panel active" id="panel-rules">
                <form action="{{ route('admin.admin-setting.delivery-setting') }}" method="POST">
                @csrf

                <!-- Quick-jump sub-tab bar -->
                <div class="ds-subtab-bar" id="subtab-bar-rules">
                    <button type="button" class="ds-subtab-btn active" data-target="rules-general" onclick="switchSubtab('rules-general',null,this)"><i class="fa fa-sliders"></i> General</button>
                    <button type="button" class="ds-subtab-btn" data-target="rules-free"    onclick="switchSubtab('rules-free',null,this)"><i class="fa fa-gift"></i> Free Shipping</button>
                    <button type="button" class="ds-subtab-btn" data-target="rules-flat"    onclick="switchSubtab('rules-flat',null,this)"><i class="fa fa-tag"></i> Flat Rate</button>
                    <button type="button" class="ds-subtab-btn" data-target="rules-cod"     onclick="switchSubtab('rules-cod',null,this)"><i class="fa fa-money-bill-wave"></i> COD</button>
                    <button type="button" class="ds-subtab-btn" data-target="rules-pincode" onclick="switchSubtab('rules-pincode',null,this)"><i class="fa fa-map-pin"></i> Pincode</button>
                    <button type="button" class="ds-subtab-btn" data-target="rules-weight"  onclick="switchSubtab('rules-weight',null,this)"><i class="fa fa-weight-hanging"></i> Weight</button>
                </div>

                <!-- General -->
                <div class="ds-panel active" id="rules-general">
                    <div class="ds-section-wrap">
                        <div class="ds-section-title"><i class="fa fa-sliders"></i> General Delivery Settings</div>
                        <p class="ds-section-desc">Default behaviour when no specific rule matches an order.</p>
                        <div class="sp-form-grid">
                            <div class="sp-field">
                                <label class="sp-label">Default Delivery Charge <span class="sp-req">*</span></label>
                                <div class="sp-input-wrap">
                                    <span class="sp-input-prefix">₹</span>
                                    <input type="number" name="default_charge" class="sp-input" value="{{ old('default_charge',$rules?->default_charge??50) }}" placeholder="50" min="0">
                                </div>
                                <span class="sp-hint">Applied when no other rule matches.</span>
                            </div>
                            <div class="sp-field">
                                <label class="sp-label">Estimated Delivery Days</label>
                                <div class="sp-input-wrap">
                                    <input type="number" name="min_days" class="sp-input" value="{{ old('min_days',$rules?->min_days??3) }}" placeholder="3" min="1" style="border-radius:var(--sp-radius-md) 0 0 var(--sp-radius-md)">
                                    <span class="sp-input-suffix" style="border-left:none;border-right:none">–</span>
                                    <input type="number" name="max_days" class="sp-input" value="{{ old('max_days',$rules?->max_days??7) }}" placeholder="7" min="1" style="border-radius:0 var(--sp-radius-md) var(--sp-radius-md) 0">
                                    <span class="sp-input-suffix">days</span>
                                </div>
                            </div>
                            <div class="sp-field sp-col-full">
                                <label class="sp-label">Charge Calculation Based On</label>
                                <div class="sp-select-wrap">
                                    <select name="charge_basis" class="sp-select">
                                        <option value="order_amount" {{ old('charge_basis',$rules?->charge_basis)=='order_amount'?'selected':'' }}>Order Amount</option>
                                        <option value="weight"       {{ old('charge_basis',$rules?->charge_basis)=='weight'?'selected':'' }}>Weight</option>
                                        <option value="quantity"     {{ old('charge_basis',$rules?->charge_basis)=='quantity'?'selected':'' }}>Item Quantity</option>
                                        <option value="courier"      {{ old('charge_basis',$rules?->charge_basis)=='courier'?'selected':'' }}>Courier API (Live Rates)</option>
                                    </select>
                                </div>
                                <span class="sp-hint">Rules below will use this as the matching criteria.</span>
                            </div>
                        </div>
                    </div>
                    <div class="ds-action-bar">
                        <button type="button" class="sp-btn-secondary">Discard</button>
                        <button type="submit" class="sp-btn-primary" onclick="saveSettings(this)"><i class="fa fa-save"></i> Save</button>
                    </div>
                </div>

                <!-- Free Shipping -->
                <div class="ds-panel" id="rules-free">
                    <div class="ds-section-wrap">
                        <div class="ds-section-title"><i class="fa fa-gift"></i> Free Shipping Rules</div>
                        <p class="ds-section-desc">Define conditions under which shipping is free. First match wins.</p>
                        <div id="freeRulesWrap">
                            <div class="sp-rule-row">
                                <div class="sp-field"><label class="sp-label" style="text-transform:none;font-size:11px">Condition</label><div class="sp-select-wrap"><select name="free_rules[0][condition]" class="sp-select" style="height:34px;font-size:13px"><option value="above_amount">Order Amount ≥</option><option value="promo_code">Promo Code</option><option value="first_order">First Order</option></select></div></div>
                                <div class="sp-field"><label class="sp-label" style="text-transform:none;font-size:11px">Value (₹ or Code)</label><div class="sp-input-wrap"><span class="sp-input-prefix">₹</span><input type="text" name="free_rules[0][value]" class="sp-input" value="999" style="height:34px;font-size:13px"></div></div>
                                <div class="sp-field"><label class="sp-label" style="text-transform:none;font-size:11px">Applies To</label><div class="sp-select-wrap"><select name="free_rules[0][applies_to]" class="sp-select" style="height:34px;font-size:13px"><option value="all">All Products</option><option value="selected_categories">Selected Categories</option></select></div></div>
                                <div class="sp-field"><label class="sp-label" style="text-transform:none;font-size:11px">Label (shown to customer)</label><input type="text" name="free_rules[0][label]" class="sp-input" value="Free Delivery above ₹999" style="height:34px;font-size:13px"></div>
                                <button type="button" class="sp-rule-del-btn" onclick="removeRule(this)"><i class="fa fa-trash"></i></button>
                            </div>
                        </div>
                        <button type="button" class="sp-add-rule-btn" onclick="addFreeRule()"><i class="fa fa-plus"></i> Add Free Shipping Rule</button>
                    </div>
                    <div class="ds-action-bar"><button type="button" class="sp-btn-secondary">Discard</button><button type="submit" class="sp-btn-primary" onclick="saveSettings(this)"><i class="fa fa-save"></i> Save</button></div>
                </div>

                <!-- Flat Rate -->
                <div class="ds-panel" id="rules-flat">
                    <div class="ds-section-wrap">
                        <div class="ds-section-title"><i class="fa fa-tag"></i> Flat Rate Delivery Rules</div>
                        <p class="ds-section-desc">Fixed delivery charges for specific order amount ranges.</p>
                        <div id="flatRulesWrap">
                            <div class="sp-rule-row">
                                <div class="sp-field"><label class="sp-label" style="text-transform:none;font-size:11px">Amount From (₹)</label><div class="sp-input-wrap"><span class="sp-input-prefix">₹</span><input type="number" name="flat_rules[0][amount_from]" class="sp-input" value="0" style="height:34px;font-size:13px"></div></div>
                                <div class="sp-field"><label class="sp-label" style="text-transform:none;font-size:11px">Amount To (₹)</label><div class="sp-input-wrap"><span class="sp-input-prefix">₹</span><input type="number" name="flat_rules[0][amount_to]" class="sp-input" value="499" style="height:34px;font-size:13px"></div></div>
                                <div class="sp-field"><label class="sp-label" style="text-transform:none;font-size:11px">Delivery Charge (₹)</label><div class="sp-input-wrap"><span class="sp-input-prefix">₹</span><input type="number" name="flat_rules[0][charge]" class="sp-input" value="99" style="height:34px;font-size:13px"></div></div>
                                <div class="sp-field"><label class="sp-label" style="text-transform:none;font-size:11px">Label</label><input type="text" name="flat_rules[0][label]" class="sp-input" value="Standard Delivery" style="height:34px;font-size:13px"></div>
                                <button type="button" class="sp-rule-del-btn" onclick="removeRule(this)"><i class="fa fa-trash"></i></button>
                            </div>
                            <div class="sp-rule-row">
                                <div class="sp-field"><label class="sp-label" style="text-transform:none;font-size:11px">Amount From (₹)</label><div class="sp-input-wrap"><span class="sp-input-prefix">₹</span><input type="number" name="flat_rules[1][amount_from]" class="sp-input" value="500" style="height:34px;font-size:13px"></div></div>
                                <div class="sp-field"><label class="sp-label" style="text-transform:none;font-size:11px">Amount To (₹)</label><div class="sp-input-wrap"><span class="sp-input-prefix">₹</span><input type="number" name="flat_rules[1][amount_to]" class="sp-input" value="998" style="height:34px;font-size:13px"></div></div>
                                <div class="sp-field"><label class="sp-label" style="text-transform:none;font-size:11px">Delivery Charge (₹)</label><div class="sp-input-wrap"><span class="sp-input-prefix">₹</span><input type="number" name="flat_rules[1][charge]" class="sp-input" value="50" style="height:34px;font-size:13px"></div></div>
                                <div class="sp-field"><label class="sp-label" style="text-transform:none;font-size:11px">Label</label><input type="text" name="flat_rules[1][label]" class="sp-input" value="Reduced Delivery" style="height:34px;font-size:13px"></div>
                                <button type="button" class="sp-rule-del-btn" onclick="removeRule(this)"><i class="fa fa-trash"></i></button>
                            </div>
                        </div>
                        <button type="button" class="sp-add-rule-btn" onclick="addFlatRule()"><i class="fa fa-plus"></i> Add Flat Rate Rule</button>
                    </div>
                    <div class="ds-action-bar"><button type="button" class="sp-btn-secondary">Discard</button><button type="submit" class="sp-btn-primary" onclick="saveSettings(this)"><i class="fa fa-save"></i> Save</button></div>
                </div>

                <!-- COD -->
                <div class="ds-panel" id="rules-cod">
                    <div class="ds-section-wrap">
                        <div class="ds-section-title"><i class="fa fa-money-bill-wave"></i> Cash on Delivery (COD) Charges</div>
                        <p class="ds-section-desc">Extra fee charged for COD orders.</p>
                        <div class="sp-toggle-row" style="margin-bottom:16px">
                            <div><div class="sp-toggle-label">Enable COD</div><div class="sp-toggle-sub">Allow Cash on Delivery as a payment option.</div></div>
                            <label class="sp-switch"><input type="checkbox" name="cod_enabled" {{ old('cod_enabled',$rules?->cod_enabled)?'checked':'' }}><span class="sp-switch-track"></span></label>
                        </div>
                        <div class="sp-form-grid">
                            <div class="sp-field">
                                <label class="sp-label">COD Charge Type</label>
                                <div class="sp-select-wrap"><select name="cod_charge_type" class="sp-select"><option value="flat" {{ old('cod_charge_type',$rules?->cod_charge_type)=='flat'?'selected':'' }}>Flat Amount</option><option value="percent" {{ old('cod_charge_type',$rules?->cod_charge_type)=='percent'?'selected':'' }}>Percentage of Order</option></select></div>
                            </div>
                            <div class="sp-field">
                                <label class="sp-label">COD Charge Value</label>
                                <div class="sp-input-wrap"><span class="sp-input-prefix">₹ / %</span><input type="number" name="cod_charge_value" class="sp-input" value="{{ old('cod_charge_value',$rules?->cod_charge_value??30) }}" placeholder="30" min="0"></div>
                            </div>
                            <div class="sp-field">
                                <label class="sp-label">Free COD Above (₹)</label>
                                <div class="sp-input-wrap"><span class="sp-input-prefix">₹</span><input type="number" name="cod_free_above" class="sp-input" value="{{ old('cod_free_above',$rules?->cod_free_above??2000) }}" placeholder="2000" min="0"></div>
                                <span class="sp-hint">No COD charge if order is above this amount.</span>
                            </div>
                            <div class="sp-field">
                                <label class="sp-label">Max COD Order Value (₹)</label>
                                <div class="sp-input-wrap"><span class="sp-input-prefix">₹</span><input type="number" name="cod_max_order" class="sp-input" value="{{ old('cod_max_order',$rules?->cod_max_order??10000) }}" placeholder="10000" min="0"></div>
                                <span class="sp-hint">COD not allowed above this value. 0 = no limit.</span>
                            </div>
                        </div>
                    </div>
                    <div class="ds-action-bar"><button type="button" class="sp-btn-secondary">Discard</button><button type="submit" class="sp-btn-primary" onclick="saveSettings(this)"><i class="fa fa-save"></i> Save</button></div>
                </div>

                <!-- Pincode -->
                <div class="ds-panel" id="rules-pincode">
                    <div class="ds-section-wrap">
                        <div class="ds-section-title"><i class="fa fa-map-pin"></i> Pincode-Based Rules</div>
                        <p class="ds-section-desc">Override delivery charges or block delivery for specific pincodes.</p>
                        <div id="pincodeRulesWrap">
                            <div class="sp-rule-row" style="grid-template-columns:140px 1fr 1fr 38px">
                                <div class="sp-field"><label class="sp-label" style="text-transform:none;font-size:11px">Rule Type</label><div class="sp-select-wrap"><select name="pincode_rules[0][type]" class="sp-select" style="height:34px;font-size:13px"><option value="flat">Flat Charge</option><option value="free">Free Delivery</option><option value="blocked">Block Delivery</option></select></div></div>
                                <div class="sp-field"><label class="sp-label" style="text-transform:none;font-size:11px">Pincodes (comma / range)</label><input type="text" name="pincode_rules[0][pincodes]" class="sp-input" value="110001, 110002" style="height:34px;font-size:13px"></div>
                                <div class="sp-field"><label class="sp-label" style="text-transform:none;font-size:11px">Charge (₹)</label><div class="sp-input-wrap"><span class="sp-input-prefix">₹</span><input type="text" name="pincode_rules[0][charge]" class="sp-input" value="0" style="height:34px;font-size:13px"></div></div>
                                <button type="button" class="sp-rule-del-btn" onclick="removeRule(this)"><i class="fa fa-trash"></i></button>
                            </div>
                        </div>
                        <button type="button" class="sp-add-rule-btn" onclick="addPincodeRule()"><i class="fa fa-plus"></i> Add Pincode Rule</button>
                    </div>
                    <div class="ds-action-bar"><button type="button" class="sp-btn-secondary">Discard</button><button type="submit" class="sp-btn-primary" onclick="saveSettings(this)"><i class="fa fa-save"></i> Save</button></div>
                </div>

                <!-- Weight -->
                <div class="ds-panel" id="rules-weight">
                    <div class="ds-section-wrap">
                        <div class="ds-section-title"><i class="fa fa-weight-hanging"></i> Weight-Based Slabs</div>
                        <p class="ds-section-desc">Charge based on package weight. Used when calculation basis is set to Weight.</p>
                        <div id="weightRulesWrap">
                            <div class="sp-rule-row" style="grid-template-columns:1fr 1fr 1fr 1fr 38px">
                                <div class="sp-field"><label class="sp-label" style="text-transform:none;font-size:11px">From (kg)</label><input type="number" name="weight_rules[0][from]" class="sp-input" value="0" step="0.5" style="height:34px;font-size:13px"></div>
                                <div class="sp-field"><label class="sp-label" style="text-transform:none;font-size:11px">To (kg)</label><input type="number" name="weight_rules[0][to]" class="sp-input" value="0.5" step="0.5" style="height:34px;font-size:13px"></div>
                                <div class="sp-field"><label class="sp-label" style="text-transform:none;font-size:11px">Base Charge (₹)</label><div class="sp-input-wrap"><span class="sp-input-prefix">₹</span><input type="number" name="weight_rules[0][charge]" class="sp-input" value="40" style="height:34px;font-size:13px"></div></div>
                                <div class="sp-field"><label class="sp-label" style="text-transform:none;font-size:11px">Extra per 500g (₹)</label><div class="sp-input-wrap"><span class="sp-input-prefix">₹</span><input type="number" name="weight_rules[0][extra]" class="sp-input" value="0" style="height:34px;font-size:13px"></div></div>
                                <button type="button" class="sp-rule-del-btn" onclick="removeRule(this)"><i class="fa fa-trash"></i></button>
                            </div>
                            <div class="sp-rule-row" style="grid-template-columns:1fr 1fr 1fr 1fr 38px">
                                <div class="sp-field"><label class="sp-label" style="text-transform:none;font-size:11px">From (kg)</label><input type="number" name="weight_rules[1][from]" class="sp-input" value="0.5" step="0.5" style="height:34px;font-size:13px"></div>
                                <div class="sp-field"><label class="sp-label" style="text-transform:none;font-size:11px">To (kg)</label><input type="number" name="weight_rules[1][to]" class="sp-input" value="2" step="0.5" style="height:34px;font-size:13px"></div>
                                <div class="sp-field"><label class="sp-label" style="text-transform:none;font-size:11px">Base Charge (₹)</label><div class="sp-input-wrap"><span class="sp-input-prefix">₹</span><input type="number" name="weight_rules[1][charge]" class="sp-input" value="80" style="height:34px;font-size:13px"></div></div>
                                <div class="sp-field"><label class="sp-label" style="text-transform:none;font-size:11px">Extra per 500g (₹)</label><div class="sp-input-wrap"><span class="sp-input-prefix">₹</span><input type="number" name="weight_rules[1][extra]" class="sp-input" value="20" style="height:34px;font-size:13px"></div></div>
                                <button type="button" class="sp-rule-del-btn" onclick="removeRule(this)"><i class="fa fa-trash"></i></button>
                            </div>
                        </div>
                        <button type="button" class="sp-add-rule-btn" onclick="addWeightRule()"><i class="fa fa-plus"></i> Add Weight Slab</button>
                    </div>
                    <div class="ds-action-bar"><button type="button" class="sp-btn-secondary">Discard</button><button type="submit" class="sp-btn-primary" onclick="saveSettings(this)"><i class="fa fa-save"></i> Save</button></div>
                </div>

                </form>
            </div><!-- /panel-rules -->

            <!-- ══ COURIER CHARGES PANEL ══ -->
            <div class="ds-panel" id="panel-couriers">
                <form action="{{ route('admin.admin-setting.delivery-setting') }}" method="POST">
                @csrf

                <!-- Sub-tab bar for courier sections -->
                <div class="ds-subtab-bar" id="subtab-bar-couriers">
                    <button type="button" class="ds-subtab-btn active" onclick="switchCourier('delhivery',null,this)"><i class="fa fa-truck"></i> Delhivery</button>
                    <button type="button" class="ds-subtab-btn" onclick="switchCourier('shiprocket',null,this)"><i class="fa fa-rocket"></i> Shiprocket</button>
                    <button type="button" class="ds-subtab-btn" onclick="switchCourier('bluedart',null,this)"><i class="fa fa-box"></i> Blue Dart</button>
                    <button type="button" class="ds-subtab-btn" onclick="switchCourier('fedex',null,this)"><i class="fa fa-plane"></i> FedEx</button>
                    <button type="button" class="ds-subtab-btn" onclick="switchCourier('dtdc',null,this)"><i class="fa fa-car"></i> DTDC</button>
                    <button type="button" class="ds-subtab-btn" onclick="switchCourier('ekart',null,this)"><i class="fa fa-shopping-cart"></i> Ekart</button>
                    <button type="button" class="ds-subtab-btn" onclick="switchCourier('xpressbees',null,this)"><i class="fa fa-bolt"></i> XpressBees</button>
                </div>

                <!-- DELHIVERY -->
                <div class="ds-courier-panel active" id="courier-delhivery">
                    <div class="ds-section-wrap">
                        <div class="ds-courier-header-card">
                            <div class="ds-courier-header-left">
                                <div class="ds-courier-logo" style="background:var(--sp-accent-light);color:var(--sp-accent)"><i class="fa fa-truck"></i></div>
                                <div><div class="ds-courier-name">Delhivery</div><div class="ds-courier-meta">Pan-India · Surface + Express · API available</div></div>
                            </div>
                            <div style="display:flex;align-items:center;gap:10px">
                                <label class="sp-switch"><input type="checkbox" name="delhivery_enabled" checked><span class="sp-switch-track"></span></label>
                                <span class="sp-pill sp-pill-active">Active</span>
                            </div>
                        </div>
                        <div class="sp-banner blue"><i class="fa fa-circle-info"></i><div>Enter your negotiated rates per zone below, or switch to <strong>Live API Rates</strong> to fetch real-time pricing from Delhivery's rate API.</div></div>
                        <div class="sp-form-grid" style="margin-bottom:20px">
                            <div class="sp-field"><label class="sp-label">Service Type</label><div class="sp-select-wrap"><select name="delhivery_service" class="sp-select"><option value="surface">Surface (3–7 days)</option><option value="express">Express (1–3 days)</option><option value="both" selected>Both</option></select></div></div>
                            <div class="sp-field"><label class="sp-label">Rate Fetch Mode</label><div class="sp-select-wrap"><select name="delhivery_rate_mode" class="sp-select"><option value="manual" selected>Manual (enter below)</option><option value="api">Live API Rates</option></select></div></div>
                        </div>
                        <table class="sp-rate-table">
                            <thead><tr><th>Zone</th><th>Base (≤500g) ₹</th><th>Per add. 500g ₹</th><th>COD Fee ₹</th><th>COD % (min)</th><th>Fuel %</th><th>Est. Days</th></tr></thead>
                            <tbody>
                                <tr><td style="font-weight:600;color:var(--sp-accent)">Local</td><td><input type="number" name="delhivery[local][base]" class="sp-rate-input" value="35"></td><td><input type="number" name="delhivery[local][extra]" class="sp-rate-input" value="15"></td><td><input type="number" name="delhivery[local][cod_flat]" class="sp-rate-input" value="30"></td><td><input type="number" name="delhivery[local][cod_pct]" class="sp-rate-input" value="1.5" step="0.1"></td><td><input type="number" name="delhivery[local][fuel_pct]" class="sp-rate-input" value="3.5" step="0.1"></td><td><input type="text" name="delhivery[local][days]" class="sp-rate-input" value="1–2"></td></tr>
                                <tr><td style="font-weight:600;color:var(--sp-green)">Zonal</td><td><input type="number" name="delhivery[zonal][base]" class="sp-rate-input" value="50"></td><td><input type="number" name="delhivery[zonal][extra]" class="sp-rate-input" value="20"></td><td><input type="number" name="delhivery[zonal][cod_flat]" class="sp-rate-input" value="30"></td><td><input type="number" name="delhivery[zonal][cod_pct]" class="sp-rate-input" value="1.5" step="0.1"></td><td><input type="number" name="delhivery[zonal][fuel_pct]" class="sp-rate-input" value="3.5" step="0.1"></td><td><input type="text" name="delhivery[zonal][days]" class="sp-rate-input" value="2–4"></td></tr>
                                <tr><td style="font-weight:600;color:var(--sp-amber)">National</td><td><input type="number" name="delhivery[national][base]" class="sp-rate-input" value="65"></td><td><input type="number" name="delhivery[national][extra]" class="sp-rate-input" value="25"></td><td><input type="number" name="delhivery[national][cod_flat]" class="sp-rate-input" value="30"></td><td><input type="number" name="delhivery[national][cod_pct]" class="sp-rate-input" value="2" step="0.1"></td><td><input type="number" name="delhivery[national][fuel_pct]" class="sp-rate-input" value="3.5" step="0.1"></td><td><input type="text" name="delhivery[national][days]" class="sp-rate-input" value="3–5"></td></tr>
                                <tr><td style="font-weight:600;color:var(--sp-red)">Remote / J&amp;K / NE</td><td><input type="number" name="delhivery[remote][base]" class="sp-rate-input" value="100"></td><td><input type="number" name="delhivery[remote][extra]" class="sp-rate-input" value="40"></td><td><input type="number" name="delhivery[remote][cod_flat]" class="sp-rate-input" value="50"></td><td><input type="number" name="delhivery[remote][cod_pct]" class="sp-rate-input" value="2" step="0.1"></td><td><input type="number" name="delhivery[remote][fuel_pct]" class="sp-rate-input" value="5" step="0.1"></td><td><input type="text" name="delhivery[remote][days]" class="sp-rate-input" value="5–8"></td></tr>
                            </tbody>
                        </table>
                        <div class="sp-api-section">
                            <div class="sp-api-section-title"><i class="fa fa-key"></i> API Credentials</div>
                            <div class="sp-form-grid">
                                <div class="sp-field"><label class="sp-label">API Token</label><div style="position:relative"><input type="password" id="delhiveryToken" name="delhivery_api_token" class="sp-input mono" value="{{ old('delhivery_api_token',$couriers?->delhivery_api_token) }}" placeholder="••••••••••••••••"><button type="button" onclick="togglePass('delhiveryToken',this)" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--sp-text-hint)"><i class="fa fa-eye"></i></button></div></div>
                                <div class="sp-field"><label class="sp-label">Warehouse / Client Name</label><input type="text" name="delhivery_warehouse" class="sp-input" value="{{ old('delhivery_warehouse',$couriers?->delhivery_warehouse) }}" placeholder="Registered warehouse name"></div>
                                <div class="sp-field"><label class="sp-label">Environment</label><div class="sp-select-wrap"><select name="delhivery_env" class="sp-select"><option value="sandbox">Sandbox (Testing)</option><option value="production" selected>Production</option></select></div></div>
                                <div class="sp-field" style="align-self:end"><button type="button" class="sp-btn-test" onclick="testCourier('Delhivery')"><i class="fa fa-plug"></i> Test Connection</button></div>
                            </div>
                        </div>
                    </div>
                    <div class="ds-action-bar"><button type="button" class="sp-btn-secondary">Discard</button><button type="submit" class="sp-btn-primary" onclick="saveSettings(this)"><i class="fa fa-save"></i> Save</button></div>
                </div>

                <!-- SHIPROCKET -->
                <div class="ds-courier-panel" id="courier-shiprocket">
                    <div class="ds-section-wrap">
                        <div class="ds-courier-header-card">
                            <div class="ds-courier-header-left"><div class="ds-courier-logo" style="background:#fff3e0;color:#e65100"><i class="fa fa-rocket"></i></div><div><div class="ds-courier-name">Shiprocket</div><div class="ds-courier-meta">Multi-courier aggregator · Automatic rate comparison</div></div></div>
                            <div style="display:flex;align-items:center;gap:10px"><label class="sp-switch"><input type="checkbox" name="shiprocket_enabled" checked><span class="sp-switch-track"></span></label><span class="sp-pill sp-pill-active">Active</span></div>
                        </div>
                        <div class="sp-banner blue"><i class="fa fa-circle-info"></i><div>Shiprocket routes through multiple couriers. Rates are fetched live via API — no manual rate table needed.</div></div>
                        <div class="sp-api-section">
                            <div class="sp-api-section-title"><i class="fa fa-key"></i> API Credentials</div>
                            <div class="sp-form-grid">
                                <div class="sp-field"><label class="sp-label">Email (Login)</label><input type="email" name="shiprocket_email" class="sp-input" value="{{ old('shiprocket_email',$couriers?->shiprocket_email) }}" placeholder="your@email.com"></div>
                                <div class="sp-field"><label class="sp-label">Password</label><div style="position:relative"><input type="password" id="shiprocketPass" name="shiprocket_password" class="sp-input" placeholder="••••••••••••"><button type="button" onclick="togglePass('shiprocketPass',this)" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--sp-text-hint)"><i class="fa fa-eye"></i></button></div></div>
                                <div class="sp-field"><label class="sp-label">Channel ID</label><input type="text" name="shiprocket_channel_id" class="sp-input mono" value="{{ old('shiprocket_channel_id',$couriers?->shiprocket_channel_id) }}" placeholder="123456"></div>
                                <div class="sp-field" style="align-self:end"><button type="button" class="sp-btn-test" onclick="testCourier('Shiprocket')"><i class="fa fa-plug"></i> Test Connection</button></div>
                            </div>
                        </div>
                        <div class="sp-form-grid" style="margin-top:16px">
                            <div class="sp-field"><label class="sp-label">Preferred Courier</label><div class="sp-select-wrap"><select name="shiprocket_preferred_courier" class="sp-select"><option value="">Auto (cheapest / fastest)</option><option value="delhivery">Delhivery</option><option value="bluedart">Blue Dart</option><option value="ekart">Ekart</option><option value="xpressbees">XpressBees</option></select></div></div>
                            <div class="sp-field"><label class="sp-label">Pickup Warehouse</label><input type="text" name="shiprocket_warehouse" class="sp-input" value="{{ old('shiprocket_warehouse',$couriers?->shiprocket_warehouse) }}" placeholder="Primary Warehouse"></div>
                        </div>
                    </div>
                    <div class="ds-action-bar"><button type="button" class="sp-btn-secondary">Discard</button><button type="submit" class="sp-btn-primary" onclick="saveSettings(this)"><i class="fa fa-save"></i> Save</button></div>
                </div>

                <!-- BLUE DART -->
                <div class="ds-courier-panel" id="courier-bluedart">
                    <div class="ds-section-wrap">
                        <div class="ds-courier-header-card">
                            <div class="ds-courier-header-left"><div class="ds-courier-logo" style="background:#fff9e6;color:#e6a800"><i class="fa fa-box"></i></div><div><div class="ds-courier-name">Blue Dart</div><div class="ds-courier-meta">Premium express · Guaranteed delivery</div></div></div>
                            <div style="display:flex;align-items:center;gap:10px"><label class="sp-switch"><input type="checkbox" name="bluedart_enabled"><span class="sp-switch-track"></span></label><span class="sp-pill sp-pill-inactive">Inactive</span></div>
                        </div>
                        <table class="sp-rate-table" style="margin-bottom:16px">
                            <thead><tr><th>Zone</th><th>Base (≤500g) ₹</th><th>Per add. 500g ₹</th><th>COD Fee ₹</th><th>Fuel %</th><th>Docket Fee ₹</th><th>Est. Days</th></tr></thead>
                            <tbody>
                                <tr><td style="font-weight:600;color:var(--sp-accent)">Local</td><td><input type="number" name="bluedart[local][base]" class="sp-rate-input" value="60"></td><td><input type="number" name="bluedart[local][extra]" class="sp-rate-input" value="20"></td><td><input type="number" name="bluedart[local][cod_flat]" class="sp-rate-input" value="40"></td><td><input type="number" name="bluedart[local][fuel_pct]" class="sp-rate-input" value="5" step="0.1"></td><td><input type="number" name="bluedart[local][docket]" class="sp-rate-input" value="20"></td><td><input type="text" name="bluedart[local][days]" class="sp-rate-input" value="1–2"></td></tr>
                                <tr><td style="font-weight:600;color:var(--sp-green)">Zonal</td><td><input type="number" name="bluedart[zonal][base]" class="sp-rate-input" value="85"></td><td><input type="number" name="bluedart[zonal][extra]" class="sp-rate-input" value="30"></td><td><input type="number" name="bluedart[zonal][cod_flat]" class="sp-rate-input" value="40"></td><td><input type="number" name="bluedart[zonal][fuel_pct]" class="sp-rate-input" value="5" step="0.1"></td><td><input type="number" name="bluedart[zonal][docket]" class="sp-rate-input" value="20"></td><td><input type="text" name="bluedart[zonal][days]" class="sp-rate-input" value="2–3"></td></tr>
                                <tr><td style="font-weight:600;color:var(--sp-amber)">National</td><td><input type="number" name="bluedart[national][base]" class="sp-rate-input" value="110"></td><td><input type="number" name="bluedart[national][extra]" class="sp-rate-input" value="40"></td><td><input type="number" name="bluedart[national][cod_flat]" class="sp-rate-input" value="50"></td><td><input type="number" name="bluedart[national][fuel_pct]" class="sp-rate-input" value="5" step="0.1"></td><td><input type="number" name="bluedart[national][docket]" class="sp-rate-input" value="20"></td><td><input type="text" name="bluedart[national][days]" class="sp-rate-input" value="3–4"></td></tr>
                            </tbody>
                        </table>
                        <div class="sp-api-section">
                            <div class="sp-api-section-title"><i class="fa fa-key"></i> API Credentials</div>
                            <div class="sp-form-grid">
                                <div class="sp-field"><label class="sp-label">License Key</label><div style="position:relative"><input type="password" id="bluedartKey" name="bluedart_license_key" class="sp-input mono" placeholder="••••••••••••••••"><button type="button" onclick="togglePass('bluedartKey',this)" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--sp-text-hint)"><i class="fa fa-eye"></i></button></div></div>
                                <div class="sp-field"><label class="sp-label">Login ID</label><input type="text" name="bluedart_login_id" class="sp-input" placeholder="BDLoginID"></div>
                                <div class="sp-field"><label class="sp-label">Account Number</label><input type="text" name="bluedart_account" class="sp-input mono" placeholder="12345678"></div>
                                <div class="sp-field" style="align-self:end"><button type="button" class="sp-btn-test" onclick="testCourier('Blue Dart')"><i class="fa fa-plug"></i> Test Connection</button></div>
                            </div>
                        </div>
                    </div>
                    <div class="ds-action-bar"><button type="button" class="sp-btn-secondary">Discard</button><button type="submit" class="sp-btn-primary" onclick="saveSettings(this)"><i class="fa fa-save"></i> Save</button></div>
                </div>

                <!-- FEDEX -->
                <div class="ds-courier-panel" id="courier-fedex">
                    <div class="ds-section-wrap">
                        <div class="ds-courier-header-card">
                            <div class="ds-courier-header-left"><div class="ds-courier-logo" style="background:#e8f2ff;color:#4d148c"><i class="fa fa-plane"></i></div><div><div class="ds-courier-name">FedEx</div><div class="ds-courier-meta">International + Domestic · Priority / Economy / Freight</div></div></div>
                            <div style="display:flex;align-items:center;gap:10px"><label class="sp-switch"><input type="checkbox" name="fedex_enabled"><span class="sp-switch-track"></span></label><span class="sp-pill sp-pill-inactive">Inactive</span></div>
                        </div>
                        <table class="sp-rate-table" style="margin-bottom:16px">
                            <thead><tr><th>Service</th><th>Base (≤500g) ₹</th><th>Per add. 500g ₹</th><th>Fuel %</th><th>Remote Area ₹</th><th>Est. Days</th></tr></thead>
                            <tbody>
                                <tr><td style="font-weight:600;color:var(--sp-accent)">FedEx Priority</td><td><input type="number" name="fedex[priority][base]" class="sp-rate-input" value="150"></td><td><input type="number" name="fedex[priority][extra]" class="sp-rate-input" value="60"></td><td><input type="number" name="fedex[priority][fuel_pct]" class="sp-rate-input" value="6" step="0.1"></td><td><input type="number" name="fedex[priority][remote]" class="sp-rate-input" value="200"></td><td><input type="text" name="fedex[priority][days]" class="sp-rate-input" value="1–2"></td></tr>
                                <tr><td style="font-weight:600;color:var(--sp-green)">FedEx Economy</td><td><input type="number" name="fedex[economy][base]" class="sp-rate-input" value="90"></td><td><input type="number" name="fedex[economy][extra]" class="sp-rate-input" value="35"></td><td><input type="number" name="fedex[economy][fuel_pct]" class="sp-rate-input" value="6" step="0.1"></td><td><input type="number" name="fedex[economy][remote]" class="sp-rate-input" value="150"></td><td><input type="text" name="fedex[economy][days]" class="sp-rate-input" value="3–5"></td></tr>
                            </tbody>
                        </table>
                        <div class="sp-api-section">
                            <div class="sp-api-section-title"><i class="fa fa-key"></i> API Credentials</div>
                            <div class="sp-form-grid">
                                <div class="sp-field"><label class="sp-label">API Key</label><div style="position:relative"><input type="password" id="fedexKey" name="fedex_api_key" class="sp-input mono" placeholder="••••••••••••••••"><button type="button" onclick="togglePass('fedexKey',this)" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--sp-text-hint)"><i class="fa fa-eye"></i></button></div></div>
                                <div class="sp-field"><label class="sp-label">Secret Key</label><div style="position:relative"><input type="password" id="fedexSecret" name="fedex_secret_key" class="sp-input mono" placeholder="••••••••••••••••"><button type="button" onclick="togglePass('fedexSecret',this)" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--sp-text-hint)"><i class="fa fa-eye"></i></button></div></div>
                                <div class="sp-field"><label class="sp-label">Account Number</label><input type="text" name="fedex_account_number" class="sp-input mono" placeholder="740000000"></div>
                                <div class="sp-field" style="align-self:end"><button type="button" class="sp-btn-test" onclick="testCourier('FedEx')"><i class="fa fa-plug"></i> Test Connection</button></div>
                            </div>
                        </div>
                    </div>
                    <div class="ds-action-bar"><button type="button" class="sp-btn-secondary">Discard</button><button type="submit" class="sp-btn-primary" onclick="saveSettings(this)"><i class="fa fa-save"></i> Save</button></div>
                </div>

                <!-- DTDC -->
                <div class="ds-courier-panel" id="courier-dtdc">
                    <div class="ds-section-wrap">
                        <div class="ds-courier-header-card">
                            <div class="ds-courier-header-left"><div class="ds-courier-logo" style="background:#fff0f0;color:#c0392b"><i class="fa fa-car"></i></div><div><div class="ds-courier-name">DTDC</div><div class="ds-courier-meta">Economy surface · Wide pincode coverage · COD available</div></div></div>
                            <div style="display:flex;align-items:center;gap:10px"><label class="sp-switch"><input type="checkbox" name="dtdc_enabled"><span class="sp-switch-track"></span></label><span class="sp-pill sp-pill-inactive">Inactive</span></div>
                        </div>
                        <table class="sp-rate-table" style="margin-bottom:16px">
                            <thead><tr><th>Zone</th><th>Base (≤500g) ₹</th><th>Per add. 500g ₹</th><th>COD Fee ₹</th><th>Fuel %</th><th>Est. Days</th></tr></thead>
                            <tbody>
                                <tr><td style="font-weight:600;color:var(--sp-accent)">Local</td><td><input type="number" name="dtdc[local][base]" class="sp-rate-input" value="30"></td><td><input type="number" name="dtdc[local][extra]" class="sp-rate-input" value="12"></td><td><input type="number" name="dtdc[local][cod_flat]" class="sp-rate-input" value="25"></td><td><input type="number" name="dtdc[local][fuel_pct]" class="sp-rate-input" value="4" step="0.1"></td><td><input type="text" name="dtdc[local][days]" class="sp-rate-input" value="1–2"></td></tr>
                                <tr><td style="font-weight:600;color:var(--sp-green)">Zonal</td><td><input type="number" name="dtdc[zonal][base]" class="sp-rate-input" value="45"></td><td><input type="number" name="dtdc[zonal][extra]" class="sp-rate-input" value="18"></td><td><input type="number" name="dtdc[zonal][cod_flat]" class="sp-rate-input" value="25"></td><td><input type="number" name="dtdc[zonal][fuel_pct]" class="sp-rate-input" value="4" step="0.1"></td><td><input type="text" name="dtdc[zonal][days]" class="sp-rate-input" value="3–5"></td></tr>
                                <tr><td style="font-weight:600;color:var(--sp-amber)">National</td><td><input type="number" name="dtdc[national][base]" class="sp-rate-input" value="60"></td><td><input type="number" name="dtdc[national][extra]" class="sp-rate-input" value="22"></td><td><input type="number" name="dtdc[national][cod_flat]" class="sp-rate-input" value="35"></td><td><input type="number" name="dtdc[national][fuel_pct]" class="sp-rate-input" value="4" step="0.1"></td><td><input type="text" name="dtdc[national][days]" class="sp-rate-input" value="5–7"></td></tr>
                            </tbody>
                        </table>
                        <div class="sp-api-section">
                            <div class="sp-api-section-title"><i class="fa fa-key"></i> API Credentials</div>
                            <div class="sp-form-grid">
                                <div class="sp-field"><label class="sp-label">Customer Code</label><input type="text" name="dtdc_customer_code" class="sp-input mono" placeholder="B12345"></div>
                                <div class="sp-field"><label class="sp-label">API Key</label><div style="position:relative"><input type="password" id="dtdcKey" name="dtdc_api_key" class="sp-input mono" placeholder="••••••••••••••••"><button type="button" onclick="togglePass('dtdcKey',this)" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--sp-text-hint)"><i class="fa fa-eye"></i></button></div></div>
                                <div class="sp-field" style="align-self:end"><button type="button" class="sp-btn-test" onclick="testCourier('DTDC')"><i class="fa fa-plug"></i> Test Connection</button></div>
                            </div>
                        </div>
                    </div>
                    <div class="ds-action-bar"><button type="button" class="sp-btn-secondary">Discard</button><button type="submit" class="sp-btn-primary" onclick="saveSettings(this)"><i class="fa fa-save"></i> Save</button></div>
                </div>

                <!-- EKART -->
                <div class="ds-courier-panel" id="courier-ekart">
                    <div class="ds-section-wrap">
                        <div class="ds-courier-header-card">
                            <div class="ds-courier-header-left"><div class="ds-courier-logo" style="background:#e3f1ec;color:#007a5e"><i class="fa fa-shopping-cart"></i></div><div><div class="ds-courier-name">Ekart Logistics</div><div class="ds-courier-meta">Flipkart's logistics arm · Economy surface · Budget rates</div></div></div>
                            <div style="display:flex;align-items:center;gap:10px"><label class="sp-switch"><input type="checkbox" name="ekart_enabled"><span class="sp-switch-track"></span></label><span class="sp-pill sp-pill-inactive">Inactive</span></div>
                        </div>
                        <table class="sp-rate-table" style="margin-bottom:16px">
                            <thead><tr><th>Zone</th><th>Base (≤500g) ₹</th><th>Per add. 500g ₹</th><th>COD Fee ₹</th><th>Fuel %</th><th>Est. Days</th></tr></thead>
                            <tbody>
                                <tr><td style="font-weight:600;color:var(--sp-accent)">Local</td><td><input type="number" name="ekart[local][base]" class="sp-rate-input" value="28"></td><td><input type="number" name="ekart[local][extra]" class="sp-rate-input" value="10"></td><td><input type="number" name="ekart[local][cod_flat]" class="sp-rate-input" value="25"></td><td><input type="number" name="ekart[local][fuel_pct]" class="sp-rate-input" value="3.5" step="0.1"></td><td><input type="text" name="ekart[local][days]" class="sp-rate-input" value="2–3"></td></tr>
                                <tr><td style="font-weight:600;color:var(--sp-green)">National</td><td><input type="number" name="ekart[national][base]" class="sp-rate-input" value="50"></td><td><input type="number" name="ekart[national][extra]" class="sp-rate-input" value="18"></td><td><input type="number" name="ekart[national][cod_flat]" class="sp-rate-input" value="30"></td><td><input type="number" name="ekart[national][fuel_pct]" class="sp-rate-input" value="3.5" step="0.1"></td><td><input type="text" name="ekart[national][days]" class="sp-rate-input" value="4–6"></td></tr>
                            </tbody>
                        </table>
                        <div class="sp-api-section">
                            <div class="sp-api-section-title"><i class="fa fa-key"></i> API Credentials</div>
                            <div class="sp-form-grid">
                                <div class="sp-field"><label class="sp-label">Client ID</label><input type="text" name="ekart_client_id" class="sp-input mono" placeholder="EKART_CLIENT_ID"></div>
                                <div class="sp-field"><label class="sp-label">Client Secret</label><div style="position:relative"><input type="password" id="ekartSecret" name="ekart_client_secret" class="sp-input mono" placeholder="••••••••••••••••"><button type="button" onclick="togglePass('ekartSecret',this)" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--sp-text-hint)"><i class="fa fa-eye"></i></button></div></div>
                                <div class="sp-field" style="align-self:end"><button type="button" class="sp-btn-test" onclick="testCourier('Ekart')"><i class="fa fa-plug"></i> Test Connection</button></div>
                            </div>
                        </div>
                    </div>
                    <div class="ds-action-bar"><button type="button" class="sp-btn-secondary">Discard</button><button type="submit" class="sp-btn-primary" onclick="saveSettings(this)"><i class="fa fa-save"></i> Save</button></div>
                </div>

                <!-- XPRESSBEES -->
                <div class="ds-courier-panel" id="courier-xpressbees">
                    <div class="ds-section-wrap">
                        <div class="ds-courier-header-card">
                            <div class="ds-courier-header-left"><div class="ds-courier-logo" style="background:#fdf4ff;color:#9333ea"><i class="fa fa-bolt"></i></div><div><div class="ds-courier-name">XpressBees</div><div class="ds-courier-meta">Fast growing · B2B + B2C · Reverse logistics support</div></div></div>
                            <div style="display:flex;align-items:center;gap:10px"><label class="sp-switch"><input type="checkbox" name="xpressbees_enabled"><span class="sp-switch-track"></span></label><span class="sp-pill sp-pill-inactive">Inactive</span></div>
                        </div>
                        <table class="sp-rate-table" style="margin-bottom:16px">
                            <thead><tr><th>Zone</th><th>Base (≤500g) ₹</th><th>Per add. 500g ₹</th><th>COD Fee ₹</th><th>Fuel %</th><th>Est. Days</th></tr></thead>
                            <tbody>
                                <tr><td style="font-weight:600;color:var(--sp-accent)">Local</td><td><input type="number" name="xpressbees[local][base]" class="sp-rate-input" value="32"></td><td><input type="number" name="xpressbees[local][extra]" class="sp-rate-input" value="14"></td><td><input type="number" name="xpressbees[local][cod_flat]" class="sp-rate-input" value="28"></td><td><input type="number" name="xpressbees[local][fuel_pct]" class="sp-rate-input" value="4" step="0.1"></td><td><input type="text" name="xpressbees[local][days]" class="sp-rate-input" value="1–2"></td></tr>
                                <tr><td style="font-weight:600;color:var(--sp-green)">Zonal</td><td><input type="number" name="xpressbees[zonal][base]" class="sp-rate-input" value="48"></td><td><input type="number" name="xpressbees[zonal][extra]" class="sp-rate-input" value="18"></td><td><input type="number" name="xpressbees[zonal][cod_flat]" class="sp-rate-input" value="28"></td><td><input type="number" name="xpressbees[zonal][fuel_pct]" class="sp-rate-input" value="4" step="0.1"></td><td><input type="text" name="xpressbees[zonal][days]" class="sp-rate-input" value="2–4"></td></tr>
                                <tr><td style="font-weight:600;color:var(--sp-amber)">National</td><td><input type="number" name="xpressbees[national][base]" class="sp-rate-input" value="65"></td><td><input type="number" name="xpressbees[national][extra]" class="sp-rate-input" value="24"></td><td><input type="number" name="xpressbees[national][cod_flat]" class="sp-rate-input" value="35"></td><td><input type="number" name="xpressbees[national][fuel_pct]" class="sp-rate-input" value="4" step="0.1"></td><td><input type="text" name="xpressbees[national][days]" class="sp-rate-input" value="3–5"></td></tr>
                            </tbody>
                        </table>
                        <div class="sp-api-section">
                            <div class="sp-api-section-title"><i class="fa fa-key"></i> API Credentials</div>
                            <div class="sp-form-grid">
                                <div class="sp-field"><label class="sp-label">Username</label><input type="text" name="xpressbees_username" class="sp-input" placeholder="your@email.com"></div>
                                <div class="sp-field"><label class="sp-label">Password</label><div style="position:relative"><input type="password" id="xpressbeesPass" name="xpressbees_password" class="sp-input" placeholder="••••••••••••"><button type="button" onclick="togglePass('xpressbeesPass',this)" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--sp-text-hint)"><i class="fa fa-eye"></i></button></div></div>
                                <div class="sp-field"><label class="sp-label">Company ID</label><input type="text" name="xpressbees_company_id" class="sp-input mono" placeholder="12345"></div>
                                <div class="sp-field" style="align-self:end"><button type="button" class="sp-btn-test" onclick="testCourier('XpressBees')"><i class="fa fa-plug"></i> Test Connection</button></div>
                            </div>
                        </div>
                    </div>
                    <div class="ds-action-bar"><button type="button" class="sp-btn-secondary">Discard</button><button type="submit" class="sp-btn-primary" onclick="saveSettings(this)"><i class="fa fa-save"></i> Save</button></div>
                </div>

                </form>
            </div><!-- /panel-couriers -->

        </div><!-- /ds-content -->

    </div><!-- /ds-shell -->

</div><!-- /ds-page -->
</div><!-- /main-section -->

@include('admin.footer')

<script>
/* ══ Switch main section (Delivery Rules ↔ Courier Charges) ══ */
function switchMain(key) {
    // Update left main nav
    document.querySelectorAll('.ds-main-nav-item').forEach(el => el.classList.remove('active'));
    document.getElementById('main-nav-' + key).classList.add('active');

    // Show/hide sub navs
    document.getElementById('subnav-rules').style.display    = key === 'rules'    ? '' : 'none';
    document.getElementById('subnav-couriers').style.display = key === 'couriers' ? '' : 'none';

    // Show/hide right panels
    document.querySelectorAll('.ds-panel[id^="panel-"]').forEach(p => p.classList.remove('active'));
    document.getElementById('panel-' + key).classList.add('active');

    // Reset sub-selections on switch
    if (key === 'rules')    switchSubtab('rules-general', null, document.querySelector('#subtab-bar-rules .ds-subtab-btn'));
    if (key === 'couriers') switchCourier('delhivery', null, document.querySelector('#subtab-bar-couriers .ds-subtab-btn'));
}

/* ══ Switch delivery rule sub-section ══ */
function switchSubtab(targetId, sidenavEl, subtabEl) {
    // Right panels (rules-*)
    document.querySelectorAll('#panel-rules .ds-panel').forEach(p => p.classList.remove('active'));
    document.getElementById(targetId).classList.add('active');

    // Sidenav sync
    if (sidenavEl) {
        document.querySelectorAll('#subnav-rules .ds-sub-nav-item').forEach(a => a.classList.remove('active'));
        sidenavEl.classList.add('active');
    }
    // Subtab bar sync
    if (subtabEl) {
        document.querySelectorAll('#subtab-bar-rules .ds-subtab-btn').forEach(b => b.classList.remove('active'));
        subtabEl.classList.add('active');
    }
    // Auto-sync subtab bar if triggered from sidenav
    if (sidenavEl && !subtabEl) {
        document.querySelectorAll('#subtab-bar-rules .ds-subtab-btn').forEach(b => {
            if (b.dataset.target === targetId) b.classList.add('active');
            else b.classList.remove('active');
        });
    }
}

/* ══ Switch courier ══ */
function switchCourier(key, sidenavEl, subtabEl) {
    // Courier panels
    document.querySelectorAll('.ds-courier-panel').forEach(p => p.classList.remove('active'));
    document.getElementById('courier-' + key).classList.add('active');

    // Sidenav
    if (sidenavEl) {
        document.querySelectorAll('.ds-courier-item').forEach(a => a.classList.remove('active'));
        sidenavEl.classList.add('active');
    }
    // Subtab bar
    if (subtabEl) {
        document.querySelectorAll('#subtab-bar-couriers .ds-subtab-btn').forEach(b => b.classList.remove('active'));
        subtabEl.classList.add('active');
    }
    // Auto-sync sidenav if triggered from subtab
    if (subtabEl && !sidenavEl) {
        document.querySelectorAll('.ds-courier-item').forEach(el => {
            const onclick = el.getAttribute('onclick') || '';
            if (onclick.includes("'" + key + "'")) el.classList.add('active');
            else el.classList.remove('active');
        });
    }
}

/* ══ Password toggle ══ */
function togglePass(id, btn) {
    const inp = document.getElementById(id);
    const isPass = inp.type === 'password';
    inp.type = isPass ? 'text' : 'password';
    btn.querySelector('i').className = isPass ? 'fa fa-eye-slash' : 'fa fa-eye';
}

/* ══ Save feedback ══ */
function saveSettings(btn) {
    const orig = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Saving…';
    setTimeout(() => {
        btn.innerHTML = '<i class="fa fa-check"></i> Saved!';
        btn.style.background = 'var(--sp-green)';
        setTimeout(() => { btn.innerHTML = orig; btn.style.background = ''; btn.disabled = false; }, 2000);
    }, 800);
}

/* ══ Test courier ══ */
function testCourier(name) {
    Swal.fire({ title:'Testing ' + name + '…', text:'Sending a test API ping.', timer:1500, timerProgressBar:true, showConfirmButton:false, didOpen:() => Swal.showLoading() })
    .then(() => Swal.fire({ icon:'success', title:'Connected!', text:name + ' API responded successfully.', timer:2000, showConfirmButton:false }));
}

/* ══ Remove rule row ══ */
function removeRule(btn) {
    const row = btn.closest('.sp-rule-row');
    row.style.transition = 'opacity .2s'; row.style.opacity = '0';
    setTimeout(() => row.remove(), 200);
}

/* ══ Add rule helpers ══ */
let freeIdx = 1, flatIdx = 2, pinIdx = 1, wgtIdx = 2;

function addFreeRule() {
    const i = freeIdx++;
    document.getElementById('freeRulesWrap').insertAdjacentHTML('beforeend', `
    <div class="sp-rule-row">
        <div class="sp-field"><label class="sp-label" style="text-transform:none;font-size:11px">Condition</label><div class="sp-select-wrap"><select name="free_rules[${i}][condition]" class="sp-select" style="height:34px;font-size:13px"><option value="above_amount">Order Amount ≥</option><option value="promo_code">Promo Code</option><option value="first_order">First Order</option></select></div></div>
        <div class="sp-field"><label class="sp-label" style="text-transform:none;font-size:11px">Value (₹ or Code)</label><div class="sp-input-wrap"><span class="sp-input-prefix">₹</span><input type="text" name="free_rules[${i}][value]" class="sp-input" placeholder="value" style="height:34px;font-size:13px"></div></div>
        <div class="sp-field"><label class="sp-label" style="text-transform:none;font-size:11px">Applies To</label><div class="sp-select-wrap"><select name="free_rules[${i}][applies_to]" class="sp-select" style="height:34px;font-size:13px"><option value="all">All Products</option><option value="selected_categories">Selected Categories</option></select></div></div>
        <div class="sp-field"><label class="sp-label" style="text-transform:none;font-size:11px">Label</label><input type="text" name="free_rules[${i}][label]" class="sp-input" placeholder="Free delivery label" style="height:34px;font-size:13px"></div>
        <button type="button" class="sp-rule-del-btn" onclick="removeRule(this)"><i class="fa fa-trash"></i></button>
    </div>`);
}

function addFlatRule() {
    const i = flatIdx++;
    document.getElementById('flatRulesWrap').insertAdjacentHTML('beforeend', `
    <div class="sp-rule-row">
        <div class="sp-field"><label class="sp-label" style="text-transform:none;font-size:11px">Amount From (₹)</label><div class="sp-input-wrap"><span class="sp-input-prefix">₹</span><input type="number" name="flat_rules[${i}][amount_from]" class="sp-input" placeholder="0" style="height:34px;font-size:13px"></div></div>
        <div class="sp-field"><label class="sp-label" style="text-transform:none;font-size:11px">Amount To (₹)</label><div class="sp-input-wrap"><span class="sp-input-prefix">₹</span><input type="number" name="flat_rules[${i}][amount_to]" class="sp-input" placeholder="999" style="height:34px;font-size:13px"></div></div>
        <div class="sp-field"><label class="sp-label" style="text-transform:none;font-size:11px">Delivery Charge (₹)</label><div class="sp-input-wrap"><span class="sp-input-prefix">₹</span><input type="number" name="flat_rules[${i}][charge]" class="sp-input" placeholder="50" style="height:34px;font-size:13px"></div></div>
        <div class="sp-field"><label class="sp-label" style="text-transform:none;font-size:11px">Label</label><input type="text" name="flat_rules[${i}][label]" class="sp-input" placeholder="Delivery label" style="height:34px;font-size:13px"></div>
        <button type="button" class="sp-rule-del-btn" onclick="removeRule(this)"><i class="fa fa-trash"></i></button>
    </div>`);
}

function addPincodeRule() {
    const i = pinIdx++;
    document.getElementById('pincodeRulesWrap').insertAdjacentHTML('beforeend', `
    <div class="sp-rule-row" style="grid-template-columns:140px 1fr 1fr 38px">
        <div class="sp-field"><label class="sp-label" style="text-transform:none;font-size:11px">Rule Type</label><div class="sp-select-wrap"><select name="pincode_rules[${i}][type]" class="sp-select" style="height:34px;font-size:13px"><option value="flat">Flat Charge</option><option value="free">Free Delivery</option><option value="blocked">Block Delivery</option></select></div></div>
        <div class="sp-field"><label class="sp-label" style="text-transform:none;font-size:11px">Pincodes</label><input type="text" name="pincode_rules[${i}][pincodes]" class="sp-input" placeholder="110001, 110002-110020" style="height:34px;font-size:13px"></div>
        <div class="sp-field"><label class="sp-label" style="text-transform:none;font-size:11px">Charge (₹)</label><div class="sp-input-wrap"><span class="sp-input-prefix">₹</span><input type="text" name="pincode_rules[${i}][charge]" class="sp-input" placeholder="0" style="height:34px;font-size:13px"></div></div>
        <button type="button" class="sp-rule-del-btn" onclick="removeRule(this)"><i class="fa fa-trash"></i></button>
    </div>`);
}

function addWeightRule() {
    const i = wgtIdx++;
    document.getElementById('weightRulesWrap').insertAdjacentHTML('beforeend', `
    <div class="sp-rule-row" style="grid-template-columns:1fr 1fr 1fr 1fr 38px">
        <div class="sp-field"><label class="sp-label" style="text-transform:none;font-size:11px">From (kg)</label><input type="number" name="weight_rules[${i}][from]" class="sp-input" placeholder="0" step="0.5" style="height:34px;font-size:13px"></div>
        <div class="sp-field"><label class="sp-label" style="text-transform:none;font-size:11px">To (kg)</label><input type="number" name="weight_rules[${i}][to]" class="sp-input" placeholder="1" step="0.5" style="height:34px;font-size:13px"></div>
        <div class="sp-field"><label class="sp-label" style="text-transform:none;font-size:11px">Base Charge (₹)</label><div class="sp-input-wrap"><span class="sp-input-prefix">₹</span><input type="number" name="weight_rules[${i}][charge]" class="sp-input" placeholder="60" style="height:34px;font-size:13px"></div></div>
        <div class="sp-field"><label class="sp-label" style="text-transform:none;font-size:11px">Extra per 500g (₹)</label><div class="sp-input-wrap"><span class="sp-input-prefix">₹</span><input type="number" name="weight_rules[${i}][extra]" class="sp-input" placeholder="20" style="height:34px;font-size:13px"></div></div>
        <button type="button" class="sp-rule-del-btn" onclick="removeRule(this)"><i class="fa fa-trash"></i></button>
    </div>`);
}
</script>