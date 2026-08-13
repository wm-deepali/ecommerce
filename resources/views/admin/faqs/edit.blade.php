@include('admin.top-header')

<div class="main-section">
    @include('admin.header')

    <style>
    :root {
        --bg:            #f1f2f4;
        --surface:       #ffffff;
        --border:        #e3e5e8;
        --text-primary:  #202223;
        --text-secondary:#6d7175;
        --text-hint:     #8c9196;
        --accent:        #303d89;
        --accent-light:  #f0f1fc;
        --green:         #007a5e;
        --red:           #b22222;
        --radius-sm:     8px;
        --radius-md:     12px;
        --shadow-card:   0 1px 3px rgba(0,0,0,.08), 0 0 0 1px var(--border);
        --font:          'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }

    .faq-edit-page { background: var(--bg); padding: 24px 28px; min-height: 100vh; font-family: var(--font); color: var(--text-primary); }
    .faq-edit-page * { box-sizing: border-box; }

    /* Page header */
    .page-header { display: flex; align-items: flex-start; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 20px; }
    .page-header h1 { font-size: 20px; font-weight: 650; color: var(--text-primary); margin: 0; }
    .crumb { font-size: 12.5px; color: var(--text-hint); margin-top: 3px; }
    .crumb a { color: var(--accent); text-decoration: none; }
    .crumb a:hover { text-decoration: underline; }
    .crumb span { margin: 0 5px; }

    /* Identity chip */
    .faq-identity {
        display: flex; align-items: center; gap: 10px;
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius-md); padding: 10px 16px;
        box-shadow: var(--shadow-card); max-width: 380px;
    }
    .faq-identity-icon { width: 36px; height: 36px; border-radius: var(--radius-sm); background: var(--accent-light); display: flex; align-items: center; justify-content: center; font-size: 15px; color: var(--accent); flex-shrink: 0; }
    .faq-identity-id   { font-size: 12px; color: var(--text-hint); }

    /* Layout */
    .faq-layout { display: grid; grid-template-columns: 1fr 280px; gap: 20px; align-items: start; }
    @media(max-width:860px) { .faq-layout { grid-template-columns: 1fr; } }

    /* Section card */
    .section-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-md); box-shadow: var(--shadow-card); overflow: hidden; margin-bottom: 16px; }
    .section-card:last-child { margin-bottom: 0; }
    .section-card-header { padding: 14px 20px; border-bottom: 1px solid var(--border); background: #fafafa; }
    .section-card-header h5 { font-size: 13px; font-weight: 650; color: var(--text-primary); margin: 0; }
    .section-card-body { padding: 20px; }

    /* Fields */
    .field-group { margin-bottom: 18px; }
    .field-group:last-child { margin-bottom: 0; }
    .field-label { display: block; font-size: 12px; font-weight: 600; color: var(--text-secondary); letter-spacing: .03em; text-transform: uppercase; margin-bottom: 6px; }
    .field-label .req { color: var(--red); margin-left: 2px; }
    .field-input, .field-textarea {
        width: 100%; border: 1px solid var(--border);
        border-radius: var(--radius-sm); padding: 0 12px;
        font-size: 13.5px; color: var(--text-primary); background: var(--surface);
        outline: none; transition: border-color .15s, box-shadow .15s; font-family: var(--font);
    }
    .field-input { height: 38px; }
    .field-input:focus, .field-textarea:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(48,61,137,.12); }
    .field-textarea { padding: 10px 12px; resize: vertical; min-height: 140px; }

    /* Toggle rows */
    .toggle-row { display: flex; align-items: center; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid var(--bg); }
    .toggle-row:first-child { padding-top: 0; }
    .toggle-row:last-child { border-bottom: none; padding-bottom: 0; }
    .toggle-label { font-size: 13px; font-weight: 500; color: var(--text-primary); }
    .toggle-sub   { font-size: 11.5px; color: var(--text-hint); margin-top: 2px; }

    /* Toggle switch */
    .toggle-switch { position: relative; width: 36px; height: 20px; flex-shrink: 0; }
    .toggle-switch input { opacity: 0; width: 0; height: 0; position: absolute; }
    .toggle-track { position: absolute; inset: 0; background: var(--border); border-radius: 20px; cursor: pointer; transition: background .2s; }
    .toggle-track::after { content: ''; position: absolute; left: 3px; top: 3px; width: 14px; height: 14px; background: #fff; border-radius: 50%; transition: transform .2s; box-shadow: 0 1px 3px rgba(0,0,0,.15); }
    .toggle-switch input:checked + .toggle-track { background: var(--accent); }
    .toggle-switch input:checked + .toggle-track::after { transform: translateX(16px); }

    /* Record info */
    .info-row { display: flex; justify-content: space-between; align-items: center; padding: 9px 0; border-bottom: 1px solid var(--bg); font-size: 13px; }
    .info-row:first-child { padding-top: 0; }
    .info-row:last-child { border-bottom: none; padding-bottom: 0; }
    .info-label { color: var(--text-hint); font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: .03em; }
    .info-value { font-weight: 600; color: var(--text-primary); }

    /* Buttons */
    .btn-primary-dash {
        display: inline-flex; align-items: center; gap: 6px;
        background: var(--accent); color: #fff !important; border: none;
        border-radius: var(--radius-sm); padding: 8px 18px;
        font-size: 13px; font-weight: 600; cursor: pointer;
        text-decoration: none !important; font-family: var(--font);
        transition: background .15s; box-shadow: 0 1px 3px rgba(48,61,137,.25);
    }
    .btn-primary-dash:hover:not(:disabled) { background: #252f70; }
    .btn-primary-dash:disabled { opacity: .65; cursor: not-allowed; }
    .btn-secondary-dash {
        display: inline-flex; align-items: center; gap: 6px;
        background: var(--surface); color: var(--text-primary) !important;
        border: 1px solid var(--border); border-radius: var(--radius-sm);
        padding: 8px 18px; font-size: 13px; font-weight: 500; cursor: pointer;
        text-decoration: none !important; font-family: var(--font); transition: background .15s;
    }
    .btn-secondary-dash:hover { background: var(--bg); }

    /* Action bar */
    .action-bar { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-md); box-shadow: var(--shadow-card); padding: 14px 20px; display: flex; align-items: center; justify-content: flex-end; gap: 10px; margin-top: 20px; }

    @media(max-width:768px) { .faq-edit-page { padding: 16px; } }
    </style>

    <div class="app-content content container-fluid">
        <div class="faq-edit-page">

            <!-- Page header -->
            <div class="page-header">
                <div>
                    <h1>Edit FAQ</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        <a href="{{ route('admin.faqs.index') }}">Manage FAQ</a>
                        <span>›</span>
                        Edit FAQ
                    </div>
                </div>

                <!-- Identity chip -->
                <div class="faq-identity">
                    <div class="faq-identity-icon"><i class="fa fa-question"></i></div>
                    <div>
                        <div style="font-size:13px;font-weight:600;color:var(--text-primary);max-width:260px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                            {{ $faq->question }}
                        </div>
                        <div class="faq-identity-id">ID #{{ $faq->id }}</div>
                    </div>
                </div>
            </div>

            <form id="faqForm" method="POST" action="{{ route('admin.faqs.update', $faq->id) }}">
                @csrf
                @method('PUT')

                <div class="faq-layout">

                    <!-- LEFT: Content -->
                    <div>
                        <div class="section-card">
                            <div class="section-card-header">
                                <h5>FAQ Content</h5>
                            </div>
                            <div class="section-card-body">

                                <div class="field-group">
                                    <label class="field-label">Question <span class="req">*</span></label>
                                    <input type="text" name="question" class="field-input"
                                        value="{{ $faq->question }}" required>
                                </div>

                                <div class="field-group">
                                    <label class="field-label">Answer <span class="req">*</span></label>
                                    <textarea name="answer" class="field-textarea" required>{{ $faq->answer }}</textarea>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- RIGHT: Settings + Record Info -->
                    <div>

                        <div class="section-card">
                            <div class="section-card-header">
                                <h5>Settings</h5>
                            </div>
                            <div class="section-card-body" style="padding:16px 20px">

                                <div class="toggle-row">
                                    <div>
                                        <div class="toggle-label">Show on Home Page</div>
                                        <div class="toggle-sub">Display in homepage FAQ section</div>
                                    </div>
                                    <label class="toggle-switch">
                                        <input type="checkbox" name="show_home" id="show_home"
                                            {{ $faq->show_home ? 'checked' : '' }}>
                                        <span class="toggle-track"></span>
                                    </label>
                                </div>

                                <div class="toggle-row">
                                    <div>
                                        <div class="toggle-label">Active</div>
                                        <div class="toggle-sub">Visible to customers</div>
                                    </div>
                                    <label class="toggle-switch">
                                        <input type="checkbox" name="status" id="status"
                                            {{ $faq->status ? 'checked' : '' }}>
                                        <span class="toggle-track"></span>
                                    </label>
                                </div>

                            </div>
                        </div>

                        <!-- Record info -->
                        <div class="section-card">
                            <div class="section-card-header">
                                <h5>Record Info</h5>
                            </div>
                            <div class="section-card-body" style="padding:14px 20px">
                                <div class="info-row">
                                    <span class="info-label">FAQ ID</span>
                                    <span class="info-value" style="font-family:'SF Mono','Fira Code',monospace;font-size:12px;color:var(--accent)">#{{ $faq->id }}</span>
                                </div>
                                @if($faq->created_at)
                                <div class="info-row">
                                    <span class="info-label">Created</span>
                                    <span class="info-value">{{ $faq->created_at->format('d M Y') }}</span>
                                </div>
                                @endif
                                @if($faq->updated_at)
                                <div class="info-row">
                                    <span class="info-label">Last Updated</span>
                                    <span class="info-value">{{ $faq->updated_at->format('d M Y') }}</span>
                                </div>
                                @endif
                            </div>
                        </div>

                    </div>

                </div>

                <!-- Action bar -->
                <div class="action-bar">
                    <a href="{{ route('admin.faqs.index') }}" class="btn-secondary-dash">Cancel</a>
                    <button type="submit" id="saveBtn" class="btn-primary-dash">
                        <i class="fa-solid fa-save"></i> Update FAQ
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

@include('admin.footer')

<script>
document.getElementById('faqForm').addEventListener('submit', function () {
    let btn = document.getElementById('saveBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Updating...';
});
</script>