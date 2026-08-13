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
        --red:           #b22222;
        --green:         #007a5e;
        --green-bg:      #e3f1ec;
        --radius-sm:     8px;
        --radius-md:     12px;
        --shadow-card:   0 1px 3px rgba(0,0,0,.08), 0 0 0 1px var(--border);
        --font:          'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }

    .create-page { background: var(--bg); padding: 24px 28px; min-height: 100vh; font-family: var(--font); color: var(--text-primary); }
    .create-page * { box-sizing: border-box; }

    /* ── Page header ── */
    .create-page-header { display: flex; align-items: flex-start; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 20px; }
    .create-page-header h1 { font-size: 20px; font-weight: 650; color: var(--text-primary); margin: 0; }
    .crumb { font-size: 12.5px; color: var(--text-hint); margin-top: 3px; }
    .crumb a { color: var(--accent); text-decoration: none; }
    .crumb a:hover { text-decoration: underline; }
    .crumb span { margin: 0 5px; }

    /* ── Buttons ── */
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
        padding: 8px 18px; font-size: 13px; font-weight: 500;
        text-decoration: none !important; font-family: var(--font);
        transition: background .15s; cursor: pointer;
    }
    .btn-secondary-dash:hover { background: var(--bg); }

    /* ── Two-column layout ── */
    .create-layout { display: grid; grid-template-columns: 1fr 320px; gap: 20px; align-items: start; }
    @media(max-width:900px) { .create-layout { grid-template-columns: 1fr; } }

    /* ── Section card ── */
    .section-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-md); box-shadow: var(--shadow-card); overflow: hidden; margin-bottom: 16px; }
    .section-card:last-child { margin-bottom: 0; }
    .section-card-header { padding: 14px 20px; border-bottom: 1px solid var(--border); background: #fafafa; }
    .section-card-header h5 { font-size: 13px; font-weight: 650; color: var(--text-primary); margin: 0; letter-spacing: .01em; }
    .section-card-body { padding: 20px; }

    /* ── Form fields ── */
    .field-group { margin-bottom: 16px; }
    .field-group:last-child { margin-bottom: 0; }
    .field-label { display: block; font-size: 12px; font-weight: 600; color: var(--text-secondary); letter-spacing: .03em; text-transform: uppercase; margin-bottom: 6px; }
    .field-label .req { color: var(--red); margin-left: 2px; }

    .field-input, .field-select {
        width: 100%; height: 38px; border: 1px solid var(--border);
        border-radius: var(--radius-sm); padding: 0 12px;
        font-size: 13.5px; color: var(--text-primary);
        background: var(--surface); outline: none;
        transition: border-color .15s, box-shadow .15s;
        font-family: var(--font);
    }
    .field-input:focus, .field-select:focus {
        border-color: var(--accent); box-shadow: 0 0 0 3px rgba(48,61,137,.12);
    }
    .field-hint { font-size: 11.5px; color: var(--text-hint); margin-top: 4px; }

    /* ── Category checklist ── */
    .cat-checklist {
        border: 1px solid var(--border); border-radius: var(--radius-sm);
        max-height: 240px; overflow-y: auto; background: var(--bg);
    }
    .cat-checklist::-webkit-scrollbar { width: 5px; }
    .cat-checklist::-webkit-scrollbar-track { background: transparent; }
    .cat-checklist::-webkit-scrollbar-thumb { background: var(--border); border-radius: 10px; }

    .check-pill {
        display: flex; align-items: center; gap: 8px;
        padding: 9px 14px; border-bottom: 1px solid var(--border);
        cursor: pointer; transition: background .12s;
        font-size: 13px; color: var(--text-primary); user-select: none; margin: 0;
    }
    .check-pill:last-child { border-bottom: none; }
    .check-pill:hover { background: var(--accent-light); }
    .check-pill input[type="checkbox"] { accent-color: var(--accent); width: 15px; height: 15px; flex-shrink: 0; cursor: pointer; margin: 0; }
    .check-pill input[type="checkbox"]:checked ~ span { font-weight: 600; color: var(--accent); }

    /* ── Image upload ── */
    .upload-area {
        border: 2px dashed var(--border); border-radius: var(--radius-sm);
        padding: 28px 20px; text-align: center; cursor: pointer;
        transition: border-color .15s, background .15s; position: relative;
    }
    .upload-area:hover { border-color: var(--accent); background: var(--accent-light); }
    .upload-area input[type="file"] { position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%; }
    .upload-icon  { font-size: 24px; color: var(--text-hint); margin-bottom: 8px; }
    .upload-label { font-size: 13px; font-weight: 600; color: var(--text-primary); margin-bottom: 2px; }
    .upload-sub   { font-size: 11.5px; color: var(--text-hint); }

    /* logo preview */
    .logo-preview-wrap { display: none; flex-direction: column; align-items: center; gap: 8px; margin-top: 12px; }
    .logo-preview-wrap img { width: 80px; height: 80px; object-fit: contain; border-radius: var(--radius-sm); border: 1px solid var(--border); background: var(--bg); }
    .logo-preview-wrap span { font-size: 11.5px; color: var(--text-hint); }

    /* ── Toggle rows (right column) ── */
    .toggle-row { display: flex; align-items: center; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid var(--bg); }
    .toggle-row:last-child { border-bottom: none; padding-bottom: 0; }
    .toggle-row:first-child { padding-top: 0; }
    .toggle-label { font-size: 13px; font-weight: 500; color: var(--text-primary); }
    .toggle-sub   { font-size: 11.5px; color: var(--text-hint); margin-top: 2px; }

    .field-select-sm {
        height: 32px; border: 1px solid var(--border); border-radius: var(--radius-sm);
        padding: 0 28px 0 10px; font-size: 12.5px; color: var(--text-primary);
        background: var(--surface); outline: none; font-family: var(--font);
        transition: border-color .15s, box-shadow .15s; min-width: 100px;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%238c9196'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right 9px center;
    }
    .field-select-sm:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(48,61,137,.12); }

    /* ── Action bar ── */
    .action-bar {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius-md); box-shadow: var(--shadow-card);
        padding: 14px 20px; display: flex; align-items: center;
        justify-content: flex-end; gap: 10px; margin-top: 20px;
    }

    @media(max-width:768px) { .create-page { padding: 16px; } }
    </style>

    <div class="app-content content container-fluid">
        <div class="create-page">

            <!-- Page header -->
            <div class="create-page-header">
                <div>
                    <h1>Add Brand</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        <a href="{{ route('admin.brands.index') }}">Brands</a>
                        <span>›</span>
                        Add Brand
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.brands.store') }}" enctype="multipart/form-data" id="brandForm">
                @csrf

                <div class="create-layout">

                    <!-- ── LEFT column ── -->
                    <div>

                        <!-- Brand Details -->
                        <div class="section-card">
                            <div class="section-card-header"><h5>Brand Details</h5></div>
                            <div class="section-card-body">

                                <div class="field-group">
                                    <label class="field-label">Brand Name <span class="req">*</span></label>
                                    <input type="text" name="name" class="field-input" required>
                                </div>

                            </div>
                        </div>

                        <!-- Categories -->
                        <div class="section-card">
                            <div class="section-card-header"><h5>Categories <span style="font-weight:400;color:var(--text-hint);font-size:12px">(select all that apply)</span></h5></div>
                            <div class="section-card-body" style="padding:0">
                                <div class="cat-checklist">
                                    @foreach($categories as $category)
                                        <label class="check-pill" for="category_{{ $category->id }}">
                                            <input type="checkbox" id="category_{{ $category->id }}"
                                                   name="categories[]" value="{{ $category->id }}">
                                            <span>{{ $category->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- ── RIGHT column ── -->
                    <div>

                        <!-- Logo upload -->
                        <div class="section-card">
                            <div class="section-card-header"><h5>Brand Logo</h5></div>
                            <div class="section-card-body">
                                <div class="upload-area" id="uploadArea">
                                    <input type="file" name="logo" id="logoInput" accept="image/*">
                                    <div id="uploadPlaceholder">
                                        <div class="upload-icon"><i class="fa fa-cloud-upload"></i></div>
                                        <div class="upload-label">Click to upload logo</div>
                                        <div class="upload-sub">PNG, JPG, SVG, WEBP</div>
                                    </div>
                                </div>
                                <div class="logo-preview-wrap" id="logoPreview">
                                    <img id="logoPreviewImg" src="" alt="Logo preview">
                                    <span id="logoPreviewName"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Settings -->
                        <div class="section-card">
                            <div class="section-card-header"><h5>Settings</h5></div>
                            <div class="section-card-body" style="padding:16px 20px">
                                <div class="toggle-row">
                                    <div>
                                        <div class="toggle-label">Status</div>
                                        <div class="toggle-sub">Visibility on storefront</div>
                                    </div>
                                    <select name="status" class="field-select-sm">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Action bar -->
                <div class="action-bar">
                    <a href="{{ route('admin.brands.index') }}" class="btn-secondary-dash">Cancel</a>
                    <button type="submit" id="saveBtn" class="btn-primary-dash">
                        <i class="fa-solid fa-save"></i> Save Brand
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

@include('admin.footer')

<script>
// Logo preview
document.getElementById('logoInput').addEventListener('change', function () {
    const file = this.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('logoPreviewImg').src = e.target.result;
        document.getElementById('logoPreviewName').textContent = file.name;
        document.getElementById('uploadPlaceholder').style.display = 'none';
        document.getElementById('logoPreview').style.display = 'flex';
    };
    reader.readAsDataURL(file);
});

// Submit spinner
document.getElementById('brandForm').addEventListener('submit', function () {
    const btn = document.getElementById('saveBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Saving...';
});
</script>