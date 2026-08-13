@include('admin.top-header')

<div class="main-section">
    @include('admin.header')

    <style>
    :root {
        --bg:#f1f2f4;--surface:#ffffff;--border:#e3e5e8;--text-primary:#202223;
        --text-secondary:#6d7175;--text-hint:#8c9196;--accent:#303d89;
        --accent-light:#f0f1fc;--red:#b22222;--radius-sm:8px;--radius-md:12px;
        --shadow-card:0 1px 3px rgba(0,0,0,.08),0 0 0 1px var(--border);
        --font:'Inter',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
    }
    .create-page{background:var(--bg);padding:24px 28px;min-height:100vh;font-family:var(--font);color:var(--text-primary);}
    .create-page *{box-sizing:border-box;}
    .create-page-header{display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:12px;margin-bottom:20px;}
    .create-page-header h1{font-size:20px;font-weight:650;color:var(--text-primary);margin:0;}
    .crumb{font-size:12.5px;color:var(--text-hint);margin-top:3px;}
    .crumb a{color:var(--accent);text-decoration:none;}
    .crumb a:hover{text-decoration:underline;}
    .crumb span{margin:0 5px;}
    .btn-primary-dash{display:inline-flex;align-items:center;gap:6px;background:var(--accent);color:#fff !important;border:none;border-radius:var(--radius-sm);padding:8px 18px;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none !important;font-family:var(--font);transition:background .15s;box-shadow:0 1px 3px rgba(48,61,137,.25);}
    .btn-primary-dash:hover:not(:disabled){background:#252f70;}
    .btn-primary-dash:disabled{opacity:.65;cursor:not-allowed;}
    .btn-secondary-dash{display:inline-flex;align-items:center;gap:6px;background:var(--surface);color:var(--text-primary) !important;border:1px solid var(--border);border-radius:var(--radius-sm);padding:8px 18px;font-size:13px;font-weight:500;text-decoration:none !important;font-family:var(--font);transition:background .15s;cursor:pointer;}
    .btn-secondary-dash:hover{background:var(--bg);}
    .create-layout{display:grid;grid-template-columns:1fr 280px;gap:20px;align-items:start;}
    @media(max-width:860px){.create-layout{grid-template-columns:1fr;}}
    .section-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius-md);box-shadow:var(--shadow-card);overflow:hidden;margin-bottom:16px;}
    .section-card:last-child{margin-bottom:0;}
    .section-card-header{padding:14px 20px;border-bottom:1px solid var(--border);background:#fafafa;}
    .section-card-header h5{font-size:13px;font-weight:650;color:var(--text-primary);margin:0;letter-spacing:.01em;}
    .section-card-body{padding:20px;}
    .field-group{margin-bottom:16px;}
    .field-group:last-child{margin-bottom:0;}
    .field-label{display:block;font-size:12px;font-weight:600;color:var(--text-secondary);letter-spacing:.03em;text-transform:uppercase;margin-bottom:6px;}
    .field-label .req{color:var(--red);margin-left:2px;}
    .field-input{width:100%;height:38px;border:1px solid var(--border);border-radius:var(--radius-sm);padding:0 12px;font-size:13.5px;color:var(--text-primary);background:var(--surface);outline:none;transition:border-color .15s,box-shadow .15s;font-family:var(--font);}
    .field-input:focus{border-color:var(--accent);box-shadow:0 0 0 3px rgba(48,61,137,.12);}
    .field-hint{font-size:11.5px;color:var(--text-hint);margin-top:4px;}
    .toggle-row{display:flex;align-items:center;justify-content:space-between;padding:12px 0;border-bottom:1px solid var(--bg);}
    .toggle-row:last-child{border-bottom:none;padding-bottom:0;}
    .toggle-row:first-child{padding-top:0;}
    .toggle-label{font-size:13px;font-weight:500;color:var(--text-primary);}
    .toggle-sub{font-size:11.5px;color:var(--text-hint);margin-top:2px;}
    .toggle-switch{position:relative;width:38px;height:22px;flex-shrink:0;}
    .toggle-switch input{opacity:0;width:0;height:0;position:absolute;}
    .toggle-track{position:absolute;inset:0;background:var(--border);border-radius:22px;cursor:pointer;transition:background .2s;}
    .toggle-track::after{content:'';position:absolute;left:3px;top:3px;width:16px;height:16px;background:#fff;border-radius:50%;transition:transform .2s;box-shadow:0 1px 3px rgba(0,0,0,.2);}
    .toggle-switch input:checked+.toggle-track{background:var(--accent);}
    .toggle-switch input:checked+.toggle-track::after{transform:translateX(16px);}
    .action-bar{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius-md);box-shadow:var(--shadow-card);padding:14px 20px;display:flex;align-items:center;justify-content:flex-end;gap:10px;margin-top:20px;}
    @media(max-width:768px){.create-page{padding:16px;}}
    </style>

    <div class="app-content content container-fluid">
        <div class="create-page">

            <div class="create-page-header">
                <div>
                    <h1>Add Announcement</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        <a href="{{ route('admin.announcements.index') }}">Announcement Bar</a>
                        <span>›</span>
                        Add
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.announcements.store') }}" id="announcementForm">
                @csrf

                <div class="create-layout">

                    <!-- LEFT -->
                    <div>
                        <div class="section-card">
                            <div class="section-card-header"><h5>Announcement Details</h5></div>
                            <div class="section-card-body">

                                <div class="field-group">
                                    <label class="field-label">Title <span class="req">*</span></label>
                                    <input type="text" name="title" class="field-input" required
                                           placeholder="e.g. Free shipping on orders above ₹999">
                                </div>

                                <div class="field-group">
                                    <label class="field-label">Link <span style="font-weight:400;text-transform:none;font-size:11px">(optional)</span></label>
                                    <input type="text" name="link" class="field-input"
                                           placeholder="https://…">
                                    <div class="field-hint">Where should users go when they click the announcement?</div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- RIGHT -->
                    <div>
                        <div class="section-card">
                            <div class="section-card-header"><h5>Settings</h5></div>
                            <div class="section-card-body" style="padding:16px 20px">
                                <div class="toggle-row">
                                    <div>
                                        <div class="toggle-label">Status</div>
                                        <div class="toggle-sub">Show on storefront bar</div>
                                    </div>
                                    <label class="toggle-switch">
                                        <input type="checkbox" name="status" value="1" id="status" checked>
                                        <span class="toggle-track"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="action-bar">
                    <a href="{{ route('admin.announcements.index') }}" class="btn-secondary-dash">Cancel</a>
                    <button type="submit" id="saveBtn" class="btn-primary-dash">
                        <i class="fa fa-save"></i> Save Announcement
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

@include('admin.footer')

<script>
document.getElementById('announcementForm').addEventListener('submit', function () {
    const btn = document.getElementById('saveBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Saving...';
});
</script>