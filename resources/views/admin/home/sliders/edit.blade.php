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
        --red-bg:        #fce8e8;
        --radius-sm:     8px;
        --radius-md:     12px;
        --shadow-card:   0 1px 3px rgba(0,0,0,.08), 0 0 0 1px var(--border);
        --font:          'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }

    .detail-page { background: var(--bg); padding: 24px 28px; min-height: 100vh; font-family: var(--font); color: var(--text-primary); }
    .detail-page * { box-sizing: border-box; }

    .detail-page-header { display: flex; align-items: flex-start; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 20px; }
    .detail-page-header h1 { font-size: 20px; font-weight: 650; color: var(--text-primary); margin: 0; }
    .crumb { font-size: 12.5px; color: var(--text-hint); margin-top: 3px; }
    .crumb a { color: var(--accent); text-decoration: none; }
    .crumb a:hover { text-decoration: underline; }
    .crumb span { margin: 0 5px; }

    /* Identity chip */
    .slider-identity { display: flex; align-items: center; gap: 10px; background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 8px 14px; box-shadow: var(--shadow-card); }
    .slider-identity img { width: 64px; height: 40px; border-radius: var(--radius-sm); object-fit: cover; border: 1px solid var(--border); flex-shrink: 0; }
    .slider-identity-info .name { font-size: 13px; font-weight: 650; color: var(--text-primary); }
    .slider-identity-info .meta { font-size: 12px; color: var(--text-hint); margin-top: 1px; }

    /* Layout */
    .create-layout { display: grid; grid-template-columns: 1fr 280px; gap: 20px; align-items: start; }
    @media(max-width:900px) { .create-layout { grid-template-columns: 1fr; } }

    /* Section card */
    .section-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-md); box-shadow: var(--shadow-card); overflow: hidden; margin-bottom: 16px; }
    .section-card:last-child { margin-bottom: 0; }
    .section-card-header { padding: 14px 20px; border-bottom: 1px solid var(--border); background: #fafafa; display: flex; align-items: center; justify-content: space-between; }
    .section-card-header h5 { font-size: 13px; font-weight: 650; color: var(--text-primary); margin: 0; }
    .section-card-body { padding: 20px; }

    /* Fields */
    .field-group { margin-bottom: 16px; }
    .field-group:last-child { margin-bottom: 0; }
    .field-label { display: block; font-size: 12px; font-weight: 600; color: var(--text-secondary); letter-spacing: .03em; text-transform: uppercase; margin-bottom: 6px; }
    .field-hint { font-size: 11.5px; color: var(--text-hint); margin-top: 4px; line-height: 1.6; }

    .field-input, .field-select {
        width: 100%; border: 1px solid var(--border);
        border-radius: var(--radius-sm); padding: 0 12px; height: 38px;
        font-size: 13.5px; color: var(--text-primary); background: var(--surface);
        outline: none; transition: border-color .15s, box-shadow .15s; font-family: var(--font);
    }
    .field-input:focus, .field-select:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(48,61,137,.12); }

    /* Current image wrap */
    .current-img-wrap { border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 10px; background: var(--bg); margin-bottom: 14px; display: flex; align-items: center; gap: 12px; }
    .current-img-wrap img { width: 120px; height: 75px; object-fit: cover; border-radius: var(--radius-sm); border: 1px solid var(--border); flex-shrink: 0; }
    .current-img-info strong { display: block; font-size: 13px; color: var(--text-primary); margin-bottom: 2px; }
    .current-img-info span { font-size: 12px; color: var(--text-secondary); }

    /* Upload zone */
    .upload-zone { border: 2px dashed var(--border); border-radius: var(--radius-md); padding: 22px 20px; text-align: center; cursor: pointer; transition: border-color .15s, background .15s; position: relative; }
    .upload-zone:hover { border-color: var(--accent); background: var(--accent-light); }
    .upload-zone input[type=file] { position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%; }
    .upload-zone .uz-icon { font-size: 22px; color: var(--text-hint); margin-bottom: 6px; }
    .upload-zone .uz-title { font-size: 13px; font-weight: 600; color: var(--text-primary); }
    .upload-zone .uz-sub { font-size: 11.5px; color: var(--text-hint); margin-top: 3px; }

    /* New preview */
    #newImgPreview { display: none; margin-top: 12px; }
    #newImgPreview img { width: 100%; max-height: 160px; object-fit: cover; border-radius: var(--radius-sm); border: 1px solid var(--border); }
    #newImgPreview button { font-size: 12px; color: var(--red); background: none; border: none; cursor: pointer; padding: 0; margin-top: 6px; }

    /* Settings sidebar */
    .toggle-row { display: flex; align-items: center; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid var(--bg); }
    .toggle-row:first-child { padding-top: 0; }
    .toggle-row:last-child { border-bottom: none; padding-bottom: 0; }
    .toggle-label { font-size: 13px; font-weight: 500; color: var(--text-primary); }
    .toggle-sub   { font-size: 11.5px; color: var(--text-hint); margin-top: 1px; }
    .field-select-sm {
        height: 32px; border: 1px solid var(--border); border-radius: var(--radius-sm);
        padding: 0 28px 0 10px; font-size: 12.5px; color: var(--text-primary);
        background: var(--surface); outline: none; font-family: var(--font);
        min-width: 100px; appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%238c9196'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right 9px center;
    }
    .field-select-sm:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(48,61,137,.12); }

    /* Info rows */
    .info-row { display: flex; justify-content: space-between; align-items: center; padding: 9px 0; border-bottom: 1px solid var(--bg); font-size: 13px; }
    .info-row:first-child { padding-top: 0; }
    .info-row:last-child { border-bottom: none; padding-bottom: 0; }
    .info-label { color: var(--text-hint); font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: .03em; }
    .info-value { font-weight: 600; color: var(--text-primary); }

    /* Validation errors */
    .err-box { background: var(--red-bg); color: var(--red); border: 1px solid #f5c6c6; border-radius: var(--radius-sm); padding: 12px 16px; margin-bottom: 18px; font-size: 13px; }
    .err-box ul { margin: 0; padding-left: 18px; }

    /* Buttons */
    .btn-primary-dash { display: inline-flex; align-items: center; gap: 6px; background: var(--accent); color: #fff !important; border: none; border-radius: var(--radius-sm); padding: 8px 18px; font-size: 13px; font-weight: 600; cursor: pointer; text-decoration: none !important; font-family: var(--font); transition: background .15s; box-shadow: 0 1px 3px rgba(48,61,137,.25); }
    .btn-primary-dash:hover { background: #252f70; }
    .btn-secondary-dash { display: inline-flex; align-items: center; gap: 6px; background: var(--surface); color: var(--text-primary) !important; border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 8px 18px; font-size: 13px; font-weight: 500; cursor: pointer; text-decoration: none !important; font-family: var(--font); transition: background .15s; }
    .btn-secondary-dash:hover { background: var(--bg); }

    .action-bar { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-md); box-shadow: var(--shadow-card); padding: 14px 20px; display: flex; align-items: center; justify-content: flex-end; gap: 10px; margin-top: 20px; }

    @media(max-width:768px) { .detail-page { padding: 16px; } }
    </style>

    <div class="app-content content container-fluid">
        <div class="detail-page">

            <div class="detail-page-header">
                <div>
                    <h1>Edit Slider</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        <a href="{{ route('admin.home-page.index') }}">Manage Home Page</a>
                        <span>›</span>
                        <a href="{{ route('admin.home.sliders.index') }}">Home Sliders</a>
                        <span>›</span>
                        Edit
                    </div>
                </div>

                <!-- Identity chip -->
                @if($slider->image)
                <div class="slider-identity">
                    <img src="{{ asset('storage/'.$slider->image) }}" alt="Slider #{{ $slider->id }}">
                    <div class="slider-identity-info">
                        <div class="name">Slider #{{ $slider->id }}</div>
                        <div class="meta">Sort: {{ $slider->sort_order }} &nbsp;·&nbsp; {{ $slider->status ? 'Active' : 'Inactive' }}</div>
                    </div>
                </div>
                @endif
            </div>

            @if ($errors->any())
                <div class="err-box"><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
            @endif

            <form method="POST" action="{{ route('admin.home.sliders.update', $slider->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="create-layout">

                    <!-- LEFT -->
                    <div>

                        <!-- Image -->
                        <div class="section-card">
                            <div class="section-card-header"><h5>Slider Image</h5></div>
                            <div class="section-card-body">

                                @if($slider->image)
                                    <div class="current-img-wrap" id="currentImgWrap">
                                        <img src="{{ asset('storage/'.$slider->image) }}" alt="Current slider">
                                        <div class="current-img-info">
                                            <strong>Current Image</strong>
                                            <span>Upload a new file below to replace it.</span>
                                        </div>
                                    </div>
                                @endif

                                <div class="upload-zone" id="uploadZone">
                                    <input type="file" name="image" id="imageInput" accept=".jpg,.jpeg,.png,.webp">
                                    <div class="uz-icon"><i class="fa fa-cloud-upload"></i></div>
                                    <div class="uz-title">{{ $slider->image ? 'Replace image' : 'Upload image' }}</div>
                                    <div class="uz-sub">JPG, PNG, WEBP &nbsp;·&nbsp; 2048 × 730 px recommended &nbsp;·&nbsp; Max 5 MB</div>
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
                        </div>

                        <!-- Link -->
                        <div class="section-card">
                            <div class="section-card-header"><h5>Redirect Link</h5></div>
                            <div class="section-card-body">
                                <div class="field-group" style="margin:0">
                                    <input type="url" name="link"
                                        value="{{ old('link', $slider->link) }}"
                                        class="field-input"
                                        placeholder="https://yourstore.com/collection/new-arrivals">
                                    <div class="field-hint">Optional — clicking the slider redirects users here.</div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- RIGHT -->
                    <div>

                        <div class="section-card">
                            <div class="section-card-header"><h5>Settings</h5></div>
                            <div class="section-card-body" style="padding:14px 20px">

                                <div class="toggle-row">
                                    <div>
                                        <div class="toggle-label">Sort Order</div>
                                        <div class="toggle-sub">Lower = appears first</div>
                                    </div>
                                    <input type="number" name="sort_order"
                                        value="{{ old('sort_order', $slider->sort_order) }}"
                                        style="width:64px;height:32px;border:1px solid var(--border);border-radius:var(--radius-sm);padding:0 8px;font-size:13px;font-weight:600;text-align:center;font-family:var(--font);outline:none;">
                                </div>

                                <div class="toggle-row">
                                    <div>
                                        <div class="toggle-label">Status</div>
                                        <div class="toggle-sub">Visible on homepage</div>
                                    </div>
                                    <select name="status" class="field-select-sm">
                                        <option value="1" {{ old('status', $slider->status) == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('status', $slider->status) == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>

                            </div>
                        </div>

                        <!-- Record info -->
                        <div class="section-card">
                            <div class="section-card-header"><h5>Record Info</h5></div>
                            <div class="section-card-body" style="padding:14px 20px">
                                <div class="info-row">
                                    <span class="info-label">Slider ID</span>
                                    <span class="info-value" style="font-family:'SF Mono','Fira Code',monospace;font-size:12px;color:var(--accent)">#{{ $slider->id }}</span>
                                </div>
                                @if($slider->created_at)
                                <div class="info-row">
                                    <span class="info-label">Created</span>
                                    <span class="info-value">{{ $slider->created_at->format('d M Y') }}</span>
                                </div>
                                @endif
                                @if($slider->updated_at)
                                <div class="info-row">
                                    <span class="info-label">Updated</span>
                                    <span class="info-value">{{ $slider->updated_at->format('d M Y') }}</span>
                                </div>
                                @endif
                            </div>
                        </div>

                    </div>

                </div>

                <div class="action-bar">
                    <a href="{{ route('admin.home.sliders.index') }}" class="btn-secondary-dash">Cancel</a>
                    <button type="submit" class="btn-primary-dash">
                        <i class="fa fa-save"></i> Update Slider
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