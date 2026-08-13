@include('admin.top-header')

<div class="main-section">
    
    @include('admin.header')

    <style>
    :root {
        --bg: #f1f2f4;
        --surface: #ffffff;
        --border: #e3e5e8;
        --text-primary: #202223;
        --text-secondary:#6d7175;
        --text-hint: #8c9196;
        --accent: #303d89;
        --accent-light: #f0f1fc;
        --green: #007a5e;
        --red: #b22222;
        --red-bg: #fce8e8;
        --radius-sm: 8px;
        --radius-md: 12px;
        --shadow-card: 0 1px 3px rgba(0,0,0,.08), 0 0 0 1px var(--border);
        --font: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }
    .detail-page { background: var(--bg); padding: 24px 28px; min-height: 100vh; font-family: var(--font); color: var(--text-primary); }
    .detail-page * { box-sizing: border-box; }

    .detail-page-header { display: flex; align-items: flex-start; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 20px; }
    .detail-page-header h1 { font-size: 20px; font-weight: 650; color: var(--text-primary); margin: 0; }
    .crumb { font-size: 12.5px; color: var(--text-hint); margin-top: 3px; }
    .crumb a { color: var(--accent); text-decoration: none; }
    .crumb a:hover { text-decoration: underline; }
    .crumb span { margin: 0 5px; }

    .create-layout { display: grid; grid-template-columns: 1fr 340px; gap: 20px; align-items: start; }
    @media(max-width:900px) { .create-layout { grid-template-columns: 1fr; } }

    .section-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-md); box-shadow: var(--shadow-card); overflow: hidden; margin-bottom: 16px; }
    .section-card-header { padding: 14px 20px; border-bottom: 1px solid var(--border); background: #fafafa; }
    .section-card-header h5 { font-size: 13px; font-weight: 650; color: var(--text-primary); margin: 0; }
    .section-card-body { padding: 20px; }

    .field-group { margin-bottom: 16px; }
    .field-group:last-child { margin-bottom: 0; }
    .field-label { display: block; font-size: 12px; font-weight: 600; color: var(--text-secondary); letter-spacing: .03em; text-transform: uppercase; margin-bottom: 6px; }
    .field-input, .field-textarea, .field-select {
        width: 100%; border: 1px solid var(--border);
        border-radius: var(--radius-sm); padding: 0 12px;
        font-size: 13.5px; color: var(--text-primary); background: var(--surface);
        outline: none; transition: border-color .15s, box-shadow .15s; font-family: var(--font);
    }
    .field-input, .field-select { height: 38px; }
    .field-textarea { padding: 10px 12px; resize: vertical; min-height: 90px; }
    .field-input:focus, .field-textarea:focus, .field-select:focus {
        border-color: var(--accent); box-shadow: 0 0 0 3px rgba(48,61,137,.12);
    }

    /* Upload Zone - Left Side Full Width */
    .upload-zone { 
        border: 2px dashed var(--border); 
        border-radius: var(--radius-md); 
        padding: 40px 20px; 
        text-align: center; 
        cursor: pointer; 
        transition: all .15s; 
        position: relative;
    }
    .upload-zone:hover { border-color: var(--accent); background: var(--accent-light); }
    .upload-zone input[type=file] { 
        position: absolute; 
        inset: 0; 
        opacity: 0; 
        cursor: pointer; 
        z-index: 10;
    }

    /* Preview - Right Side */
    .preview-wrap { 
        border: 1px solid var(--border); 
        border-radius: var(--radius-sm); 
        padding: 8px; 
        background: var(--bg); 
    }
    .preview-wrap img { 
        width: 100%; 
        max-height: 190px; 
        object-fit: contain; 
        border-radius: var(--radius-sm); 
    }

    #newImgPreview { 
        display: none; 
        margin-top: 12px; 
        position: relative; 
    }
    #newImgPreview img { 
        width: 100%; 
        max-height: 170px; 
        object-fit: contain; 
        border-radius: var(--radius-sm); 
        border: 1px solid var(--border); 
    }
    #newImgPreview .remove-btn {
        position: absolute; top: 8px; right: 8px;
        background: var(--red); color: white; border: none;
        width: 28px; height: 28px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
    }

    .btn-primary-dash { display: inline-flex; align-items: center; gap: 6px; background: var(--accent); color: #fff !important; border: none; border-radius: var(--radius-sm); padding: 8px 18px; font-size: 13px; font-weight: 600; cursor: pointer; text-decoration: none !important; }
    .btn-primary-dash:hover { background: #252f70; }
    .btn-secondary-dash { display: inline-flex; align-items: center; gap: 6px; background: var(--surface); color: var(--text-primary) !important; border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 8px 18px; font-size: 13px; font-weight: 500; cursor: pointer; text-decoration: none !important; }

    .action-bar { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-md); box-shadow: var(--shadow-card); padding: 14px 20px; display: flex; align-items: center; justify-content: flex-end; gap: 10px; margin-top: 20px; }
    </style>

    <div class="app-content content container-fluid">
        <div class="detail-page">
            <div class="detail-page-header">
                <div>
                    <h1>Brand Promotion Section</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        <a href="{{ route('admin.home-page.index') }}">Manage Home Page</a>
                        <span>›</span>
                        Brand Promotion Section
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.home.brand-section.update') }}" enctype="multipart/form-data">
                @csrf

                <div class="create-layout">
                    <!-- LEFT: Upload Image -->
                    <div>
                        <div class="section-card">
                            <div class="section-card-header"><h5>Main Image</h5></div>
                            <div class="section-card-body">
                                <div class="upload-zone" id="uploadZone">
                                    <input type="file" name="main_image" id="imageInput" accept=".jpg,.jpeg,.png,.webp">
                                    <div style="font-size:36px;margin-bottom:12px;color:var(--text-hint)">☁️</div>
                                    <div style="font-weight:600">Click to upload new image</div>
                                    <small style="color:var(--text-hint)">JPG, PNG, WEBP recommended</small>
                                </div>

                                <div id="newImgPreview">
                                    <img id="previewImg" src="" alt="New Preview">
                                    <button type="button" class="remove-btn" onclick="clearPreview()">✕</button>
                                </div>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="section-card">
                            <div class="section-card-header"><h5>Section Content</h5></div>
                            <div class="section-card-body">
                                <div class="field-group">
                                    <label class="field-label">Subtitle</label>
                                    <input type="text" name="subtitle" value="{{ old('subtitle', $item->subtitle ?? '') }}" class="field-input">
                                </div>
                                <div class="field-group">
                                    <label class="field-label">Title</label>
                                    <input type="text" name="title" value="{{ old('title', $item->title ?? '') }}" class="field-input">
                                </div>
                                <div class="field-group">
                                    <label class="field-label">Description</label>
                                    <textarea name="description" rows="5" class="field-textarea">{{ old('description', $item->description ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- RIGHT: Current Preview + Button & Display -->
                    <div>
                        @if(!empty($item->main_image))
                        <div class="section-card">
                            <div class="section-card-header"><h5>Current Preview</h5></div>
                            <div class="section-card-body">
                                <div class="preview-wrap">
                                    <img src="{{ asset('storage/'.$item->main_image) }}" alt="Current Image">
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="section-card">
                            <div class="section-card-header"><h5>Button & Display</h5></div>
                            <div class="section-card-body">
                                <div class="field-group">
                                    <label class="field-label">Button Text</label>
                                    <input type="text" name="button_text" value="{{ old('button_text', $item->button_text ?? '') }}" class="field-input">
                                </div>
                                <div class="field-group">
                                    <label class="field-label">Button Link</label>
                                    <input type="text" name="button_link" value="{{ old('button_link', $item->button_link ?? '') }}" class="field-input" placeholder="https://">
                                </div>
                                <div class="field-group">
                                    <label class="field-label">Status</label>
                                    <select name="status" class="field-input">
                                        <option value="1" {{ ($item->status ?? 1) == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ ($item->status ?? 1) == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="action-bar">
                    <a href="{{ route('admin.home-page.index') }}" class="btn-secondary-dash">Cancel</a>
                    <button type="submit" class="btn-primary-dash">
                        <i class="fa fa-save"></i> Save Section
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
    };
    reader.readAsDataURL(file);
});

function clearPreview() {
    document.getElementById('imageInput').value = '';
    document.getElementById('newImgPreview').style.display = 'none';
}
</script>