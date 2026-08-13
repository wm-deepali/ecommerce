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

    .edit-brand-page { background: var(--bg); padding: 24px 28px; min-height: 100vh; font-family: var(--font); color: var(--text-primary); }
    .edit-brand-page * { box-sizing: border-box; }

    /* Header */
    .page-header { display: flex; align-items: flex-start; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 20px; }
    .page-header h1 { font-size: 20px; font-weight: 650; color: var(--text-primary); margin: 0; }
    .crumb { font-size: 12.5px; color: var(--text-hint); margin-top: 3px; }
    .crumb a { color: var(--accent); text-decoration: none; }
    .crumb a:hover { text-decoration: underline; }
    .crumb span { margin: 0 5px; }

    /* Identity chip */
    .brand-identity {
        display: flex; align-items: center; gap: 12px;
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius-md); padding: 10px 16px;
        box-shadow: var(--shadow-card);
    }
    .brand-identity-logo { width: 44px; height: 44px; border-radius: var(--radius-sm); object-fit: cover; border: 1px solid var(--border); flex-shrink: 0; }
    .brand-identity-placeholder { width: 44px; height: 44px; border-radius: var(--radius-sm); background: var(--bg); border: 1px solid var(--border); display: flex; align-items: center; justify-content: center; color: var(--text-hint); font-size: 18px; flex-shrink: 0; }
    .brand-identity-name { font-size: 14px; font-weight: 650; color: var(--text-primary); }
    .brand-identity-id   { font-size: 12px; color: var(--text-hint); margin-top: 1px; }

    /* Layout */
    .brand-layout { display: grid; grid-template-columns: 1fr 300px; gap: 20px; align-items: start; }
    @media(max-width:860px) { .brand-layout { grid-template-columns: 1fr; } }

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
    .field-input, .field-select {
        width: 100%; height: 38px; border: 1px solid var(--border);
        border-radius: var(--radius-sm); padding: 0 12px;
        font-size: 13.5px; color: var(--text-primary); background: var(--surface);
        outline: none; transition: border-color .15s, box-shadow .15s; font-family: var(--font);
    }
    .field-input:focus, .field-select:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(48,61,137,.12); }
    .field-hint { font-size: 11.5px; color: var(--text-hint); margin-top: 5px; }

    /* Category checkbox list */
    .category-scroll { max-height: 240px; overflow-y: auto; border: 1px solid var(--border); border-radius: var(--radius-sm); }
    .category-scroll::-webkit-scrollbar { width: 5px; }
    .category-scroll::-webkit-scrollbar-thumb { background: var(--border); border-radius: 10px; }

    .check-toggle { display: flex; align-items: center; gap: 10px; padding: 10px 14px; border-bottom: 1px solid var(--bg); cursor: pointer; transition: background .12s; background: var(--surface); }
    .check-toggle:last-child { border-bottom: none; }
    .check-toggle:hover { background: var(--bg); }
    .check-toggle input[type="checkbox"] { accent-color: var(--accent); width: 15px; height: 15px; flex-shrink: 0; cursor: pointer; margin: 0; }
    .check-toggle:has(input:checked) { background: var(--accent-light); }
    .check-toggle:has(input:checked) span { font-weight: 600; color: var(--accent); }
    .check-toggle span { font-size: 13px; color: var(--text-primary); }

    /* Settings toggle rows */
    .toggle-row { display: flex; align-items: center; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid var(--bg); }
    .toggle-row:last-child { border-bottom: none; padding-bottom: 0; }
    .toggle-row:first-child { padding-top: 0; }
    .toggle-label { font-size: 13px; font-weight: 500; color: var(--text-primary); }
    .toggle-sub { font-size: 11.5px; color: var(--text-hint); margin-top: 2px; }
    .field-select-sm {
        height: 32px; border: 1px solid var(--border); border-radius: var(--radius-sm);
        padding: 0 28px 0 10px; font-size: 12.5px; color: var(--text-primary);
        background: var(--surface); outline: none; font-family: var(--font);
        min-width: 90px; appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%238c9196'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right 9px center;
        transition: border-color .15s, box-shadow .15s;
    }
    .field-select-sm:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(48,61,137,.12); }

    /* Image upload */
    .current-image-wrap { border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 12px; background: var(--bg); margin-bottom: 14px; display: flex; align-items: center; gap: 12px; }
    .current-image-wrap img { width: 64px; height: 64px; border-radius: var(--radius-sm); object-fit: cover; border: 1px solid var(--border); }
    .current-image-info strong { display: block; font-size: 13px; color: var(--text-primary); margin-bottom: 2px; }
    .current-image-info span { font-size: 12px; color: var(--text-secondary); }

    .file-upload-area { border: 2px dashed var(--border); border-radius: var(--radius-md); padding: 22px 20px; text-align: center; cursor: pointer; transition: border-color .15s, background .15s; position: relative; }
    .file-upload-area:hover { border-color: var(--accent); background: var(--accent-light); }
    .file-upload-area input[type=file] { position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%; }
    .file-upload-area .upload-icon { font-size: 22px; color: var(--text-hint); margin-bottom: 6px; }
    .file-upload-area p { font-size: 13px; color: var(--text-secondary); margin: 0; }
    .file-upload-area small { font-size: 11.5px; color: var(--text-hint); }

    #newPreviewWrap { display: none; margin-top: 12px; text-align: center; }
    #newPreviewWrap img { max-width: 100%; max-height: 120px; border-radius: var(--radius-sm); border: 1px solid var(--border); }
    #newPreviewWrap button { font-size: 12px; color: var(--red); background: none; border: none; cursor: pointer; padding: 0; margin-top: 6px; }

    /* Buttons */
    .btn-primary-dash {
        display: inline-flex; align-items: center; gap: 6px;
        background: var(--accent); color: #fff !important; border: none;
        border-radius: var(--radius-sm); padding: 8px 18px;
        font-size: 13px; font-weight: 600; cursor: pointer;
        text-decoration: none !important; font-family: var(--font);
        transition: background .15s; box-shadow: 0 1px 3px rgba(48,61,137,.25);
    }
    .btn-primary-dash:hover { background: #252f70; }
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

    @media(max-width:768px) { .edit-brand-page { padding: 16px; } }
    </style>

    <div class="app-content content container-fluid">
        <div class="edit-brand-page">

            <!-- Page header -->
            <div class="page-header">
                <div>
                    <h1>Edit Brand</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        <a href="{{ route('admin.brands.index') }}">Brands</a>
                        <span>›</span>
                        Edit Brand
                    </div>
                </div>

                <!-- Identity chip -->
                <div class="brand-identity">
                    @if($brand->logo)
                        <img src="{{ asset('storage/' . $brand->logo) }}" class="brand-identity-logo" alt="{{ $brand->name }}">
                    @else
                        <div class="brand-identity-placeholder"><i class="fa fa-building"></i></div>
                    @endif
                    <div>
                        <div class="brand-identity-name">{{ $brand->name }}</div>
                        <div class="brand-identity-id">ID #{{ $brand->id }}</div>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.brands.update', $brand->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="brand-layout">

                    <!-- ── LEFT column ──────────────────── -->
                    <div>

                        <!-- Brand Details -->
                        <div class="section-card">
                            <div class="section-card-header"><h5>Brand Details</h5></div>
                            <div class="section-card-body">

                                <div class="field-group">
                                    <label class="field-label">Brand Name <span class="req">*</span></label>
                                    <input type="text" name="name" class="field-input"
                                        value="{{ old('name', $brand->name) }}" required>
                                </div>

                                <div class="field-group">
                                    <label class="field-label">Categories <span class="req">*</span></label>
                                    <div class="category-scroll">
                                        @foreach($categories as $category)
                                            <label class="check-toggle" for="category_{{ $category->id }}">
                                                <input type="checkbox"
                                                    id="category_{{ $category->id }}"
                                                    name="categories[]"
                                                    value="{{ $category->id }}"
                                                    {{ in_array($category->id, $selectedCategories) ? 'checked' : '' }}>
                                                <span>{{ $category->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                    <div class="field-hint">Select all categories this brand belongs to.</div>
                                </div>

                            </div>
                        </div>

                    </div>

                    <!-- ── RIGHT column ─────────────────── -->
                    <div>

                        <!-- Settings -->
                        <div class="section-card">
                            <div class="section-card-header"><h5>Settings</h5></div>
                            <div class="section-card-body" style="padding:16px 20px">
                                <div class="toggle-row" style="padding:0;border:none">
                                    <div>
                                        <div class="toggle-label">Status</div>
                                        <div class="toggle-sub">Visible on store</div>
                                    </div>
                                    <select name="status" class="field-select-sm">
                                        <option value="1" {{ $brand->status == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ $brand->status == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Logo -->
                        <div class="section-card">
                            <div class="section-card-header"><h5>Brand Logo</h5></div>
                            <div class="section-card-body">

                                @if($brand->logo)
                                    <div class="current-image-wrap" id="currentLogoWrap">
                                        <img src="{{ asset('storage/' . $brand->logo) }}" alt="{{ $brand->name }}">
                                        <div class="current-image-info">
                                            <strong>Current logo</strong>
                                            <span>Upload a new file to replace it.</span>
                                        </div>
                                    </div>
                                @endif

                                <div class="file-upload-area" id="uploadArea">
                                    <input type="file" name="logo" accept="image/*" id="logoInput">
                                    <div class="upload-icon"><i class="fa fa-cloud-upload"></i></div>
                                    <p>{{ $brand->logo ? 'Replace logo' : 'Upload logo' }}</p>
                                    <small>PNG, JPG, SVG — max 2 MB</small>
                                </div>

                                <div id="newPreviewWrap">
                                    <img id="previewImg" src="" alt="New logo preview">
                                    <div>
                                        <button type="button" onclick="clearNewLogo()">
                                            <i class="fa fa-times"></i> Remove
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Record info -->
                        <div class="section-card">
                            <div class="section-card-header"><h5>Record Info</h5></div>
                            <div class="section-card-body" style="padding:16px 20px">
                                <div style="font-size:12.5px;color:var(--text-secondary);line-height:2">
                                    <div style="display:flex;justify-content:space-between">
                                        <span style="color:var(--text-hint)">Brand ID</span>
                                        <span style="font-weight:700;color:var(--text-primary);font-family:'SF Mono','Fira Code',monospace;font-size:12px">#{{ $brand->id }}</span>
                                    </div>
                                    <div style="display:flex;justify-content:space-between">
                                        <span style="color:var(--text-hint)">Categories</span>
                                        <span style="font-weight:600;color:var(--accent)">{{ count($selectedCategories) }} linked</span>
                                    </div>
                                    @if($brand->created_at)
                                    <div style="display:flex;justify-content:space-between">
                                        <span style="color:var(--text-hint)">Created</span>
                                        <span style="font-weight:500;color:var(--text-primary)">{{ $brand->created_at->format('d M Y') }}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Action bar -->
                <div class="action-bar">
                    <a href="{{ route('admin.brands.index') }}" class="btn-secondary-dash">Cancel</a>
                    <button type="submit" class="btn-primary-dash">
                        <i class="fa fa-save"></i> Update Brand
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
        document.getElementById('previewImg').src = e.target.result;
        document.getElementById('newPreviewWrap').style.display = 'block';
        document.getElementById('uploadArea').style.display = 'none';
        const cur = document.getElementById('currentLogoWrap');
        if (cur) cur.style.display = 'none';
    };
    reader.readAsDataURL(file);
});

function clearNewLogo() {
    document.getElementById('logoInput').value = '';
    document.getElementById('newPreviewWrap').style.display = 'none';
    document.getElementById('uploadArea').style.display = 'block';
    const cur = document.getElementById('currentLogoWrap');
    if (cur) cur.style.display = 'flex';
}
</script>