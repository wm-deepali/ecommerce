@include('admin.top-header')
<div class="main-section">
    @include('admin.header')

    <style>
    :root {
        --sp-bg: #f1f2f4; --sp-surface: #ffffff; --sp-border: #e3e5e8; --sp-border-hover: #c9cccf;
        --sp-text-primary: #202223; --sp-text-secondary: #6d7175; --sp-text-hint: #8c9196;
        --sp-accent: #303d89; --sp-accent-hover: #2a3579; --sp-accent-light: #eef0fc;
        --sp-red: #c0392b; --sp-red-bg: #fce8e8;
        --sp-radius-sm: 6px; --sp-radius-md: 8px; --sp-radius-lg: 12px;
        --sp-shadow-card: 0 1px 0 rgba(0,0,0,.05), 0 0 0 1px rgba(0,0,0,.07);
        --sp-font: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }
    .sp-page { background: var(--sp-bg); padding: 24px 28px; min-height: 100vh; font-family: var(--sp-font); color: var(--sp-text-primary); font-size: 14px; }
    .sp-page * { box-sizing: border-box; }
    .sp-page-header { display: flex; align-items: flex-start; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 20px; }
    .sp-page-title { font-size: 20px; font-weight: 660; color: var(--sp-text-primary); margin: 0 0 4px; letter-spacing: -.2px; }
    .sp-crumb { font-size: 12.5px; color: var(--sp-text-hint); display: flex; align-items: center; gap: 4px; flex-wrap: wrap; }
    .sp-crumb a { color: var(--sp-accent); text-decoration: none; }
    .sp-crumb a:hover { text-decoration: underline; }
    .sp-create-layout { display: grid; grid-template-columns: 1fr 260px; gap: 20px; align-items: start; }
    @media (max-width: 900px) { .sp-create-layout { grid-template-columns: 1fr; } }
    .sp-card { background: var(--sp-surface); border-radius: var(--sp-radius-lg); box-shadow: var(--sp-shadow-card); border: 1px solid var(--sp-border); overflow: hidden; margin-bottom: 16px; }
    .sp-card:last-child { margin-bottom: 0; }
    .sp-card-header { padding: 13px 20px; border-bottom: 1px solid var(--sp-border); background: #fafafa; display: flex; align-items: center; }
    .sp-card-header h5 { font-size: 13px; font-weight: 650; color: var(--sp-text-primary); margin: 0; }
    .sp-card-body { padding: 20px 24px; }
    .sp-card-body-sm { padding: 14px 20px; }
    .sp-field { margin-bottom: 18px; }
    .sp-field:last-child { margin-bottom: 0; }
    .sp-label { display: block; font-size: 12px; font-weight: 620; color: var(--sp-text-secondary); letter-spacing: .04em; text-transform: uppercase; margin-bottom: 6px; }
    .sp-req { color: var(--sp-red); margin-left: 2px; }
    .sp-hint { font-size: 11.5px; color: var(--sp-text-hint); margin-top: 5px; }
    .sp-input, .sp-textarea { width: 100%; border: 1px solid var(--sp-border); border-radius: var(--sp-radius-md); padding: 0 12px; font-size: 13.5px; color: var(--sp-text-primary); background: var(--sp-surface); outline: none; transition: border-color .15s, box-shadow .15s; font-family: var(--sp-font); }
    .sp-input { height: 38px; }
    .sp-textarea { padding: 10px 12px; resize: vertical; min-height: 90px; line-height: 1.6; }
    .sp-input:focus, .sp-textarea:focus { border-color: var(--sp-accent); box-shadow: 0 0 0 3px rgba(48,61,137,.10); }
    .sp-input:hover:not(:focus), .sp-textarea:hover:not(:focus) { border-color: var(--sp-border-hover); }
    .sp-toggle-row { display: flex; align-items: center; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid var(--sp-bg); }
    .sp-toggle-row:first-child { padding-top: 0; }
    .sp-toggle-row:last-child { border-bottom: none; padding-bottom: 0; }
    .sp-toggle-label { font-size: 13px; font-weight: 500; color: var(--sp-text-primary); }
    .sp-toggle-sub { font-size: 11.5px; color: var(--sp-text-hint); margin-top: 1px; }
    .sp-sort-input { width: 64px; height: 32px; border: 1px solid var(--sp-border); border-radius: var(--sp-radius-md); padding: 0 8px; font-size: 13px; font-weight: 600; text-align: center; font-family: var(--sp-font); outline: none; transition: border-color .15s; }
    .sp-sort-input:focus { border-color: var(--sp-accent); box-shadow: 0 0 0 3px rgba(48,61,137,.10); }
    .sp-switch { position: relative; width: 38px; height: 22px; flex-shrink: 0; }
    .sp-switch input { opacity: 0; width: 0; height: 0; position: absolute; }
    .sp-switch-track { position: absolute; inset: 0; background: var(--sp-border); border-radius: 22px; cursor: pointer; transition: background .2s; }
    .sp-switch-track::after { content: ''; position: absolute; left: 3px; top: 3px; width: 16px; height: 16px; background: #fff; border-radius: 50%; transition: transform .2s; box-shadow: 0 1px 3px rgba(0,0,0,.2); }
    .sp-switch input:checked + .sp-switch-track { background: var(--sp-accent); }
    .sp-switch input:checked + .sp-switch-track::after { transform: translateX(16px); }
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
                    <h1 class="sp-page-title">Add Role Category</h1>
                    <div class="sp-crumb">
                        <a href="#">Dashboard</a>
                        <span style="color:var(--sp-border-hover)">›</span>
                        <a href="#">Roles & Settings</a>
                        <span style="color:var(--sp-border-hover)">›</span>
                        <a href="#">Role Categories</a>
                        <span style="color:var(--sp-border-hover)">›</span>
                        <span>Add New</span>
                    </div>
                </div>
            </div>

            <form>
                <div class="sp-create-layout">
                    <!-- LEFT -->
                    <div>
                        <div class="sp-card">
                            <div class="sp-card-header"><h5>Category Details</h5></div>
                            <div class="sp-card-body">
                                <div class="sp-field">
                                    <label class="sp-label">Category Name <span class="sp-req">*</span></label>
                                    <input type="text" class="sp-input" placeholder="e.g. Super Admin, Manager, Editor" value="Super Admin">
                                </div>
                                <div class="sp-field" style="margin-bottom:0">
                                    <label class="sp-label">Description</label>
                                    <textarea class="sp-textarea" placeholder="Brief description of what this role category can do…">Complete access to all system modules and settings. Can manage everything.</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- RIGHT -->
                    <div>
                        <div class="sp-card">
                            <div class="sp-card-header"><h5>Settings</h5></div>
                            <div class="sp-card-body-sm">
                                <div class="sp-toggle-row">
                                    <div>
                                        <div class="sp-toggle-label">Sort Order</div>
                                        <div class="sp-toggle-sub">Lower = appears first</div>
                                    </div>
                                    <input type="number" value="1" class="sp-sort-input">
                                </div>
                                <div class="sp-toggle-row">
                                    <div>
                                        <div class="sp-toggle-label">Status</div>
                                        <div class="sp-toggle-sub">Enable this role category</div>
                                    </div>
                                    <label class="sp-switch">
                                        <input type="checkbox" checked>
                                        <span class="sp-switch-track"></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="sp-card">
                            <div class="sp-card-header"><h5>Note</h5></div>
                            <div class="sp-card-body-sm" style="font-size:12.5px;color:var(--sp-text-secondary);line-height:1.7">
                                <div style="display:flex;gap:8px;margin-bottom:8px">
                                    <i class="fa fa-circle-info" style="color:var(--sp-accent);margin-top:2px;flex-shrink:0"></i>
                                    <span>After creating the category, assign module permissions from the <strong>Role Permissions</strong> section.</span>
                                </div>
                                <div style="display:flex;gap:8px">
                                    <i class="fa fa-users" style="color:var(--sp-accent);margin-top:2px;flex-shrink:0"></i>
                                    <span>Team members can be assigned this category from the <strong>Team</strong> section.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="sp-action-bar">
                    <a href="#" class="sp-btn-secondary">Cancel</a>
                    <button type="button" class="sp-btn-primary">
                        <i class="fa fa-save"></i> Save Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@include('admin.footer')