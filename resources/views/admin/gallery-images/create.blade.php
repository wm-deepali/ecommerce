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
    .section-card:last-child { margin-bottom: 0; }
    .section-card-header { padding: 14px 20px; border-bottom: 1px solid var(--border); background: #fafafa; }
    .section-card-header h5 { font-size: 13px; font-weight: 650; color: var(--text-primary); margin: 0; }
    .section-card-body { padding: 20px; }

    .field-group { margin-bottom: 16px; }
    .field-group:last-child { margin-bottom: 0; }
    .field-label { display: block; font-size: 12px; font-weight: 600; color: var(--text-secondary); letter-spacing: .03em; text-transform: uppercase; margin-bottom: 6px; }
    .field-input, .field-select {
        width: 100%; border: 1px solid var(--border);
        border-radius: var(--radius-sm); padding: 0 12px;
        font-size: 13.5px; color: var(--text-primary); background: var(--surface);
        outline: none; transition: border-color .15s, box-shadow .15s; font-family: var(--font);
    }
    .field-input, .field-select { height: 38px; }
    .field-input:focus, .field-select:focus {
        border-color: var(--accent); box-shadow: 0 0 0 3px rgba(48,61,137,.12);
    }

    /* Upload Zone */
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

    #newImgPreview { display: none; margin-top: 12px; position: relative; }
    #newImgPreview img { width: 100%; max-height: 180px; object-fit: cover; border-radius: var(--radius-sm); border: 1px solid var(--border); }
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
                    <h1>Add Gallery Image</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        <a href="{{ route('admin.home-page.index') }}">Manage Home Page</a>
                        <span>›</span>
                        <a href="{{ route('admin.gallery-images.index') }}">Gallery Images</a>
                        <span>›</span>
                        Add New
                    </div>
                </div>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.gallery-images.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="create-layout">
                    <!-- LEFT: Image + Title -->
                    <div>
                        <div class="section-card">
                            <div class="section-card-header"><h5>Gallery Image</h5></div>
                            <div class="section-card-body">
                                <div class="field-group">
                                    <label class="field-label">Title</label>
                                    <input type="text" name="title" value="{{ old('title') }}" class="field-input">
                                </div>

                                <div class="field-group">
                                    <label class="field-label">Image <span style="color:var(--red)">*</span></label>
                                    <div class="upload-zone" id="uploadZone">
                                        <input type="file" name="image" id="imageInput" accept=".jpg,.jpeg,.png,.webp" required>
                                        <div style="font-size:36px;margin-bottom:12px;color:var(--text-hint)">☁️</div>
                                        <div style="font-weight:600">Click to upload image</div>
                                        <small style="color:var(--text-hint)">JPG, PNG, WEBP recommended</small>
                                    </div>

                                    <div id="newImgPreview">
                                        <img id="previewImg" src="" alt="Preview">
                                        <button type="button" class="remove-btn" onclick="clearPreview()">✕</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- RIGHT: Settings -->
                    <div>
                        <div class="section-card">
                            <div class="section-card-header"><h5>Display Settings</h5></div>
                            <div class="section-card-body">
                                <div class="field-group">
                                    <label class="field-label">Column</label>
                                    <select name="column_no" class="field-input">
                                        <option value="1">Column 1</option>
                                        <option value="2">Column 2</option>
                                        <option value="3">Column 3</option>
                                    </select>
                                </div>

                                <div class="field-group">
                                    <label class="field-label">Height Class</label>
                                    <select name="height_class" class="field-input">
                                        <option value="h-sm">Small</option>
                                        <option value="h-md" selected>Medium</option>
                                        <option value="h-lg">Large</option>
                                        <option value="h-xl">Extra Large</option>
                                    </select>
                                </div>

                                <div class="field-group">
                                    <label class="field-label">Sort Order</label>
                                    <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" class="field-input">
                                </div>

                                <div class="field-group">
                                    <label class="field-label">Status</label>
                                    <select name="status" class="field-input">
                                        <option value="1" selected>Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="action-bar">
                    <a href="{{ route('admin.gallery-images.index') }}" class="btn-secondary-dash">Cancel</a>
                    <button type="submit" class="btn-primary-dash">
                        <i class="fa fa-save"></i> Save Gallery Image
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