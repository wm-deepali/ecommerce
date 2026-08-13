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

    /* ── Two-column layout ── */
    .sp-create-layout {
        display: grid;
        grid-template-columns: 1fr 280px;
        gap: 20px;
        align-items: start;
    }
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
    .sp-field { margin-bottom: 18px; }
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
    .sp-hint { font-size: 11.5px; color: var(--sp-text-hint); margin-top: 5px; }

    .sp-input {
        width: 100%;
        border: 1px solid var(--sp-border);
        border-radius: var(--sp-radius-md);
        padding: 0 12px;
        height: 38px;
        font-size: 13.5px;
        color: var(--sp-text-primary);
        background: var(--sp-surface);
        outline: none;
        transition: border-color .15s, box-shadow .15s;
        font-family: var(--sp-font);
    }
    .sp-input:focus { border-color: var(--sp-accent); box-shadow: 0 0 0 3px rgba(48,61,137,.10); }
    .sp-input:hover:not(:focus) { border-color: var(--sp-border-hover); }

    /* ── Current image wrap ── */
    .sp-current-img {
        border: 1px solid var(--sp-border);
        border-radius: var(--sp-radius-md);
        padding: 10px;
        background: var(--sp-bg);
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .sp-current-img img {
        width: 120px;
        height: 75px;
        object-fit: cover;
        border-radius: var(--sp-radius-md);
        border: 1px solid var(--sp-border);
        flex-shrink: 0;
    }
    .sp-current-img-info strong { display: block; font-size: 13px; color: var(--sp-text-primary); margin-bottom: 2px; }
    .sp-current-img-info span { font-size: 12px; color: var(--sp-text-secondary); }

    /* ── Upload zone ── */
    .sp-upload-zone {
        border: 2px dashed var(--sp-border);
        border-radius: var(--sp-radius-md);
        padding: 20px;
        text-align: center;
        cursor: pointer;
        transition: border-color .15s, background .15s;
        position: relative;
    }
    .sp-upload-zone:hover { border-color: var(--sp-accent); background: var(--sp-accent-light); }
    .sp-upload-zone input[type=file] { position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%; }
    .sp-upload-zone .uz-icon { font-size: 22px; color: var(--sp-text-hint); margin-bottom: 6px; }
    .sp-upload-zone .uz-title { font-size: 13px; font-weight: 600; color: var(--sp-text-primary); }
    .sp-upload-zone .uz-sub { font-size: 11.5px; color: var(--sp-text-hint); margin-top: 3px; }

    #newImgPreview { display: none; margin-top: 10px; }
    #newImgPreview img { width: 100%; max-height: 140px; object-fit: cover; border-radius: var(--sp-radius-md); border: 1px solid var(--sp-border); }
    #newImgPreview button { font-size: 12px; color: var(--sp-red); background: none; border: none; cursor: pointer; padding: 0; margin-top: 6px; }

    /* ── Two-col field row ── */
    .sp-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    @media (max-width: 600px) { .sp-row { grid-template-columns: 1fr; } }

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

    /* ── Action bar ── */
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
                    <h1 class="sp-page-title">Edit Deal Banner</h1>
                    <div class="sp-crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span style="color:var(--sp-border-hover)">›</span>
                        <a href="{{ route('admin.home-page.index') }}">Manage Home Page</a>
                        <span style="color:var(--sp-border-hover)">›</span>
                        <a href="{{ route('admin.home-deal-banners.index') }}">Deal Banners</a>
                        <span style="color:var(--sp-border-hover)">›</span>
                        <span>Edit</span>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.home-deal-banners.update', $item->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="sp-create-layout">

                    <!-- LEFT -->
                    <div>
                        <div class="sp-card">
                            <div class="sp-card-header"><h5>Banner Details</h5></div>
                            <div class="sp-card-body">

                                <!-- Current image -->
                                <div class="sp-field">
                                    <label class="sp-label">Image</label>
                                    <div class="sp-current-img" id="currentImgWrap">
                                        <img src="{{ asset('storage/'.$item->image) }}" alt="Current Banner">
                                        <div class="sp-current-img-info">
                                            <strong>Current Image</strong>
                                            <span>Upload a new file below to replace it.</span>
                                        </div>
                                    </div>
                                    <div class="sp-upload-zone" id="uploadZone">
                                        <input type="file" name="image" id="imageInput" accept=".jpg,.jpeg,.png,.webp">
                                        <div class="uz-icon"><i class="fa fa-cloud-upload"></i></div>
                                        <div class="uz-title">Replace image</div>
                                        <div class="uz-sub">JPG, PNG, WEBP &nbsp;·&nbsp; Max 5 MB</div>
                                    </div>
                                    <div id="newImgPreview">
                                        <img id="previewImg" src="" alt="New preview">
                                        <div>
                                            <button type="button" onclick="clearPreview()">
                                                <i class="fa fa-times"></i> Remove
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="sp-row">
                                    <div class="sp-field">
                                        <label class="sp-label">Offer Text</label>
                                        <input type="text" name="offer_text" value="{{ old('offer_text', $item->offer_text) }}" class="sp-input">
                                    </div>
                                    <div class="sp-field">
                                        <label class="sp-label">Title</label>
                                        <input type="text" name="title" value="{{ old('title', $item->title) }}" class="sp-input">
                                    </div>
                                </div>

                                <div class="sp-field" style="margin-bottom:0">
                                    <label class="sp-label">Highlight Text</label>
                                    <input type="text" name="highlight_text" value="{{ old('highlight_text', $item->highlight_text) }}" class="sp-input">
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- RIGHT — settings sidebar -->
                    <div>

                        <!-- Settings -->
                        <div class="sp-card">
                            <div class="sp-card-header"><h5>Settings</h5></div>
                            <div class="sp-card-body-sm">

                                <div class="sp-toggle-row">
                                    <div>
                                        <div class="sp-toggle-label">Sort Order</div>
                                        <div class="sp-toggle-sub">Lower = appears first</div>
                                    </div>
                                    <input type="number" name="sort_order" value="{{ old('sort_order', $item->sort_order) }}" class="sp-sort-input">
                                </div>

                                <div class="sp-toggle-row">
                                    <div>
                                        <div class="sp-toggle-label">Status</div>
                                        <div class="sp-toggle-sub">Visible on homepage</div>
                                    </div>
                                    <select name="status" class="sp-select-sm">
                                        <option value="1" {{ $item->status ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ !$item->status ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>

                            </div>
                        </div>

                        <!-- Call to Action -->
                        <div class="sp-card">
                            <div class="sp-card-header"><h5>Call to Action</h5></div>
                            <div class="sp-card-body-sm">

                                <div class="sp-field">
                                    <label class="sp-label">Button Text</label>
                                    <input type="text" name="button_text" value="{{ old('button_text', $item->button_text) }}" class="sp-input" style="height:36px;font-size:13px;">
                                </div>

                                <div class="sp-field" style="margin-bottom:0">
                                    <label class="sp-label">Button Link</label>
                                    <input type="text" name="button_link" value="{{ old('button_link', $item->button_link) }}" class="sp-input" style="height:36px;font-size:13px;">
                                </div>

                            </div>
                        </div>

                    </div>

                </div>

                <!-- Action bar -->
                <div class="sp-action-bar">
                    <a href="{{ route('admin.home-deal-banners.index') }}" class="sp-btn-secondary">Cancel</a>
                    <button type="submit" class="sp-btn-primary">
                        <i class="fa fa-save"></i> Update Banner
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

@include('admin.footer')

<script>
document.getElementById('imageInput').addEventListener('change', function () {
    const file = this.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('previewImg').src = e.target.result;
        document.getElementById('newImgPreview').style.display = 'block';
        document.getElementById('uploadZone').style.display = 'none';
        const cur = document.getElementById('currentImgWrap');
        if (cur) cur.style.display = 'none';
    };
    reader.readAsDataURL(file);
});

function clearPreview() {
    document.getElementById('imageInput').value = '';
    document.getElementById('newImgPreview').style.display = 'none';
    document.getElementById('uploadZone').style.display = 'block';
    const cur = document.getElementById('currentImgWrap');
    if (cur) cur.style.display = 'flex';
}
</script>