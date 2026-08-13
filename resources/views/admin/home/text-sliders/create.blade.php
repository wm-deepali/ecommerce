@include('admin.top-header')
<div class="main-section">
    @include('admin.header')

    <style>
    :root {
        --sp-bg: #f1f2f4;
        --sp-surface: #ffffff;
        --sp-border: #e3e5e8;
        --sp-border-hover: #c9cccf;
        --sp-text-primary: #202223;
        --sp-text-secondary: #6d7175;
        --sp-text-hint: #8c9196;
        --sp-accent: #303d89;
        --sp-accent-hover: #2a3579;
        --sp-accent-light: #eef0fc;
        --sp-red: #c0392b;
        --sp-red-bg: #fce8e8;
        --sp-radius-sm: 6px;
        --sp-radius-md: 8px;
        --sp-radius-lg: 12px;
        --sp-shadow-card: 0 1px 0 rgba(0,0,0,.05), 0 0 0 1px rgba(0,0,0,.07);
        --sp-font: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }

    .sp-page {
        background: var(--sp-bg);
        padding: 24px 28px;
        min-height: 100vh;
        font-family: var(--sp-font);
        color: var(--sp-text-primary);
        font-size: 14px;
    }
    .sp-page * { box-sizing: border-box; }

    .sp-page-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 20px;
    }
    .sp-page-title {
        font-size: 20px;
        font-weight: 660;
        color: var(--sp-text-primary);
        margin: 0 0 4px;
        letter-spacing: -.2px;
    }
    .sp-crumb {
        font-size: 12.5px;
        color: var(--sp-text-hint);
        display: flex;
        align-items: center;
        gap: 4px;
        flex-wrap: wrap;
    }
    .sp-crumb a { color: var(--sp-accent); text-decoration: none; }
    .sp-crumb a:hover { text-decoration: underline; }

    /* ── Layout ── */
    .sp-create-layout {
        display: grid;
        grid-template-columns: 1fr 280px;
        gap: 20px;
        align-items: stretch;
    }
    .sp-create-layout > div { display: flex; flex-direction: column; }
    .sp-create-layout > div .sp-card { flex: 1; }
    @media (max-width: 900px) { .sp-create-layout { grid-template-columns: 1fr; } }

    /* ── Cards ── */
    .sp-card {
        background: var(--sp-surface);
        border-radius: var(--sp-radius-lg);
        box-shadow: var(--sp-shadow-card);
        border: 1px solid var(--sp-border);
        overflow: hidden;
        margin-bottom: 16px;
    }
    .sp-card:last-child { margin-bottom: 0; }
    .sp-card-header {
        padding: 13px 20px;
        border-bottom: 1px solid var(--sp-border);
        background: #fafafa;
        display: flex;
        align-items: center;
    }
    .sp-card-header h5 {
        font-size: 13px;
        font-weight: 650;
        color: var(--sp-text-primary);
        margin: 0;
    }
    .sp-card-body { padding: 20px 24px; }
    .sp-card-body-sm { padding: 14px 20px; }

    /* ── Fields ── */
    .sp-field { margin-bottom: 16px; }
    .sp-field:last-child { margin-bottom: 0; }
    .sp-label {
        display: block;
        font-size: 12px;
        font-weight: 620;
        color: var(--sp-text-secondary);
        letter-spacing: .04em;
        text-transform: uppercase;
        margin-bottom: 6px;
    }
    .sp-req { color: var(--sp-red); margin-left: 2px; }
    .sp-hint { font-size: 11.5px; color: var(--sp-text-hint); margin-top: 5px; line-height: 1.6; }

    .sp-textarea {
        width: 100%;
        border: 1px solid var(--sp-border);
        border-radius: var(--sp-radius-md);
        padding: 10px 12px;
        font-size: 13.5px;
        color: var(--sp-text-primary);
        background: var(--sp-surface);
        outline: none;
        transition: border-color .15s, box-shadow .15s;
        font-family: var(--sp-font);
        resize: vertical;
        min-height: 110px;
        line-height: 1.6;
    }
    .sp-textarea:focus {
        border-color: var(--sp-accent);
        box-shadow: 0 0 0 3px rgba(48,61,137,.10);
    }
    .sp-textarea:hover:not(:focus) { border-color: var(--sp-border-hover); }

    /* ── Settings sidebar rows ── */
    .sp-toggle-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid var(--sp-bg);
    }
    .sp-toggle-row:first-child { padding-top: 0; }
    .sp-toggle-row:last-child { border-bottom: none; padding-bottom: 0; }
    .sp-toggle-label { font-size: 13px; font-weight: 500; color: var(--sp-text-primary); }
    .sp-toggle-sub { font-size: 11.5px; color: var(--sp-text-hint); margin-top: 1px; }

    .sp-select-sm {
        height: 32px;
        border: 1px solid var(--sp-border);
        border-radius: var(--sp-radius-md);
        padding: 0 28px 0 10px;
        font-size: 12.5px;
        color: var(--sp-text-primary);
        background: var(--sp-surface);
        outline: none;
        font-family: var(--sp-font);
        min-width: 100px;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%238c9196'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 9px center;
        transition: border-color .15s, box-shadow .15s;
    }
    .sp-select-sm:focus { border-color: var(--sp-accent); box-shadow: 0 0 0 3px rgba(48,61,137,.10); }

    .sp-sort-input {
        width: 64px; height: 32px;
        border: 1px solid var(--sp-border);
        border-radius: var(--sp-radius-md);
        padding: 0 8px;
        font-size: 13px;
        font-weight: 600;
        text-align: center;
        font-family: var(--sp-font);
        outline: none;
        transition: border-color .15s, box-shadow .15s;
    }
    .sp-sort-input:focus { border-color: var(--sp-accent); box-shadow: 0 0 0 3px rgba(48,61,137,.10); }

    /* ── Error box ── */
    .sp-err-box {
        background: var(--sp-red-bg);
        color: var(--sp-red);
        border: 1px solid #f5c6c6;
        border-radius: var(--sp-radius-md);
        padding: 12px 16px;
        margin-bottom: 18px;
        font-size: 13px;
    }
    .sp-err-box ul { margin: 0; padding-left: 18px; }

    /* ── Action bar — full width card at bottom ── */
    .sp-action-bar {
        background: var(--sp-surface);
        border: 1px solid var(--sp-border);
        border-radius: var(--sp-radius-lg);
        box-shadow: var(--sp-shadow-card);
        padding: 14px 20px;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 20px;
    }
    .sp-btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: var(--sp-accent);
        color: #fff;
        border: 1px solid transparent;
        border-radius: var(--sp-radius-md);
        padding: 8px 16px;
        font-size: 13.5px;
        font-weight: 580;
        font-family: var(--sp-font);
        cursor: pointer;
        text-decoration: none;
        line-height: 1.4;
        transition: background .15s;
        white-space: nowrap;
    }
    .sp-btn-primary:hover { background: var(--sp-accent-hover); color: #fff; }
    .sp-btn-secondary {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: var(--sp-surface);
        color: var(--sp-text-primary);
        border: 1px solid var(--sp-border);
        border-radius: var(--sp-radius-md);
        padding: 8px 16px;
        font-size: 13.5px;
        font-weight: 540;
        font-family: var(--sp-font);
        cursor: pointer;
        text-decoration: none;
        line-height: 1.4;
        transition: background .15s, border-color .15s;
        white-space: nowrap;
    }
    .sp-btn-secondary:hover { background: var(--sp-bg); border-color: var(--sp-border-hover); color: var(--sp-text-primary); }

    @media (max-width: 768px) { .sp-page { padding: 16px; } }
    </style>

    <div class="app-content content container-fluid">
        <div class="sp-page">

            <!-- Page header -->
            <div class="sp-page-header">
                <div>
                    <h1 class="sp-page-title">Add Text Slider</h1>
                    <div class="sp-crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span style="color:var(--sp-border-hover)">›</span>
                        <a href="{{ route('admin.home-page.index') }}">Manage Home Page</a>
                        <span style="color:var(--sp-border-hover)">›</span>
                        <a href="{{ route('admin.home.text-sliders.index') }}">Text Sliders</a>
                        <span style="color:var(--sp-border-hover)">›</span>
                        <span>Add New</span>
                    </div>
                </div>
            </div>

            @if ($errors->any())
                <div class="sp-err-box">
                    <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.home.text-sliders.store') }}">
                @csrf

                <div class="sp-create-layout">

                    <!-- LEFT -->
                    <div>
                        <div class="sp-card">
                            <div class="sp-card-header"><h5>Slider Content</h5></div>
                            <div class="sp-card-body">
                                <div class="sp-field" style="margin:0">
                                    <label class="sp-label">Slider Text <span class="sp-req">*</span></label>
                                    <textarea name="title" rows="4" class="sp-textarea" required>{{ old('title') }}</textarea>
                                    <div class="sp-hint">This text will appear in the scrolling slider on homepage.</div>
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
                                        <div class="sp-toggle-sub">Lower number appears first</div>
                                    </div>
                                    <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" class="sp-sort-input">
                                </div>
                                <div class="sp-toggle-row">
                                    <div>
                                        <div class="sp-toggle-label">Status</div>
                                        <div class="sp-toggle-sub">Visible on homepage</div>
                                    </div>
                                    <select name="status" class="sp-select-sm">
                                        <option value="1" selected>Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Action bar — full width below the grid -->
                <div class="sp-action-bar">
                    <a href="{{ route('admin.home.text-sliders.index') }}" class="sp-btn-secondary">Cancel</a>
                    <button type="submit" class="sp-btn-primary">
                        <i class="fa fa-save"></i> Save Text Slider
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

@include('admin.footer')