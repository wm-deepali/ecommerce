@include('admin.top-header')

<div class="main-section">
    @include('admin.header')

    <style>
        /* ── Design Tokens ──────────────────────────────────────── */
        :root {
            --bg: #f1f2f4;
            --surface: #ffffff;
            --border: #e3e5e8;
            --text-primary: #202223;
            --text-secondary: #6d7175;
            --text-hint: #8c9196;
            --accent: #303d89;
            --accent-light: #f0f1fc;
            --green: #007a5e;
            --green-bg: #e3f1ec;
            --red: #b22222;
            --radius-sm: 8px;
            --radius-md: 12px;
            --shadow-card: 0 1px 3px rgba(0, 0, 0, .08), 0 0 0 1px var(--border);
            --font: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        .create-page {
            background: var(--bg);
            padding: 24px 28px;
            min-height: 100vh;
            font-family: var(--font);
            color: var(--text-primary);
        }

        .create-page * {
            box-sizing: border-box;
        }

        /* ── Page header ────────────────────────────────────────── */
        .create-page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 20px;
        }

        .create-page-header h1 {
            font-size: 20px;
            font-weight: 650;
            color: var(--text-primary);
            margin: 0;
        }

        .crumb {
            font-size: 12.5px;
            color: var(--text-hint);
            margin-top: 3px;
        }

        .crumb a {
            color: var(--accent);
            text-decoration: none;
        }

        .crumb a:hover {
            text-decoration: underline;
        }

        .crumb span {
            margin: 0 5px;
        }

        /* ── Buttons ────────────────────────────────────────────── */
        .btn-primary-dash {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--accent);
            color: #fff !important;
            border: none;
            border-radius: var(--radius-sm);
            padding: 8px 18px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none !important;
            font-family: var(--font);
            transition: background .15s, box-shadow .15s;
            box-shadow: 0 1px 3px rgba(48, 61, 137, .25);
        }

        .btn-primary-dash:hover {
            background: #252f70;
        }

        .btn-secondary-dash {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--surface);
            color: var(--text-primary) !important;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 8px 18px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none !important;
            font-family: var(--font);
            transition: background .15s;
        }

        .btn-secondary-dash:hover {
            background: var(--bg);
        }

        /* ── Two-column layout ──────────────────────────────────── */
        .create-layout {
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 20px;
            align-items: start;
        }

        @media(max-width:900px) {
            .create-layout {
                grid-template-columns: 1fr;
            }
        }

        /* ── Section card ───────────────────────────────────────── */
        .section-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-card);
            overflow: hidden;
            margin-bottom: 16px;
        }

        .section-card:last-child {
            margin-bottom: 0;
        }

        .section-card-header {
            padding: 14px 20px;
            border-bottom: 1px solid var(--border);
            background: #fafafa;
        }

        .section-card-header h5 {
            font-size: 13px;
            font-weight: 650;
            color: var(--text-primary);
            margin: 0;
            letter-spacing: .01em;
        }

        .section-card-body {
            padding: 20px;
        }

        /* ── Form fields ────────────────────────────────────────── */
        .field-group {
            margin-bottom: 16px;
        }

        .field-group:last-child {
            margin-bottom: 0;
        }

        .field-label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-secondary);
            letter-spacing: .03em;
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        .field-label .req {
            color: var(--red);
            margin-left: 2px;
        }

        .field-input,
        .field-select,
        .field-textarea {
            width: 100%;
            height: 38px;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 0 12px;
            font-size: 13.5px;
            color: var(--text-primary);
            background: var(--surface);
            outline: none;
            transition: border-color .15s, box-shadow .15s;
            font-family: var(--font);
        }

        .field-input:focus,
        .field-select:focus,
        .field-textarea:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(48, 61, 137, .12);
        }

        .field-textarea {
            height: auto;
            padding: 10px 12px;
            resize: vertical;
            min-height: 80px;
        }

        .field-hint {
            font-size: 11.5px;
            color: var(--text-hint);
            margin-top: 4px;
        }

        /* ── Slug field ─────────────────────────────────────────── */
        .slug-wrap {
            position: relative;
        }

        .slug-prefix {
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            display: flex;
            align-items: center;
            padding: 0 10px;
            background: var(--bg);
            border: 1px solid var(--border);
            border-right: none;
            border-radius: var(--radius-sm) 0 0 var(--radius-sm);
            font-size: 12px;
            color: var(--text-hint);
            white-space: nowrap;
            pointer-events: none;
        }

        .slug-input {
            padding-left: 76px !important;
        }

        /* ── File upload ────────────────────────────────────────── */
        .file-upload-area {
            border: 2px dashed var(--border);
            border-radius: var(--radius-md);
            padding: 28px 20px;
            text-align: center;
            cursor: pointer;
            transition: border-color .15s, background .15s;
            position: relative;
        }

        .file-upload-area:hover {
            border-color: var(--accent);
            background: var(--accent-light);
        }

        .file-upload-area input[type=file] {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
            width: 100%;
            height: 100%;
        }

        .file-upload-area .upload-icon {
            font-size: 26px;
            color: var(--text-hint);
            margin-bottom: 8px;
        }

        .file-upload-area p {
            font-size: 13px;
            color: var(--text-secondary);
            margin: 0;
        }

        .file-upload-area small {
            font-size: 11.5px;
            color: var(--text-hint);
        }

        /* ── Toggle / select rows ───────────────────────────────── */
        .toggle-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid var(--bg);
        }

        .toggle-row:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .toggle-row:first-child {
            padding-top: 0;
        }

        .toggle-label {
            font-size: 13px;
            font-weight: 500;
            color: var(--text-primary);
        }

        .toggle-sub {
            font-size: 11.5px;
            color: var(--text-hint);
            margin-top: 2px;
        }

        .field-select-sm {
            height: 32px;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 0 28px 0 10px;
            font-size: 12.5px;
            color: var(--text-primary);
            background: var(--surface);
            outline: none;
            font-family: var(--font);
            transition: border-color .15s, box-shadow .15s;
            min-width: 90px;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%238c9196'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 9px center;
        }

        .field-select-sm:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(48, 61, 137, .12);
        }

        /* ── Action bar (sticky bottom) ─────────────────────────── */
        .action-bar {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-card);
            padding: 14px 20px;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }

        @media(max-width:768px) {
            .create-page {
                padding: 16px;
            }
        }
    </style>

    <div class="app-content content container-fluid">
        <div class="create-page">

            <!-- Page header -->
            <div class="create-page-header">
                <div>
                    <h1>Add Category</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        <a href="{{ route('admin.categories.index') }}">Categories</a>
                        <span>›</span>
                        Add Category
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="create-layout">

                    <!-- ── LEFT column ──────────────────────────────── -->
                    <div>

                        <!-- Basic Info -->
                        <div class="section-card">
                            <div class="section-card-header">
                                <h5>Basic Information</h5>
                            </div>
                            <div class="section-card-body">

                                <div class="field-group">
                                    <label class="field-label">Name <span class="req">*</span></label>
                                    <input type="text" name="name" id="name" class="field-input" required
                                        placeholder="e.g. Electronics">
                                </div>

                                <div class="field-group">
                                    <label class="field-label">Slug</label>
                                    <div class="slug-wrap">
                                        <span class="slug-prefix">/cat/</span>
                                        <input type="text" name="slug" id="slug" class="field-input slug-input"
                                            placeholder="auto-generated">
                                    </div>
                                    <div class="field-hint">Auto-filled from name. Edit to customise the URL.</div>
                                </div>

                                <div class="field-group">
                                    <label class="field-label">Sub Title</label>
                                    <input type="text" name="sub_title" class="field-input"
                                        placeholder="Short description shown below the title">
                                </div>

                                <div class="field-group">
                                    <label class="field-label">Parent Category</label>
                                    <select name="parent_id" class="field-select">
                                        <option value="">— None (top-level) —</option>
                                        @foreach($parents as $parent)
                                            <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="field-hint">Leave blank to create a top-level category.</div>
                                </div>

                                <div class="field-group">
                                    <label class="field-label">Sort Order</label>
                                    <input type="number" name="sort_order" class="field-input" placeholder="0"
                                        style="max-width:120px">
                                    <div class="field-hint">Lower numbers appear first.</div>
                                </div>

                            </div>
                        </div>

                        <!-- SEO -->
                        <div class="section-card">
                            <div class="section-card-header">
                                <h5>SEO</h5>
                            </div>
                            <div class="section-card-body">

                                <div class="field-group">
                                    <label class="field-label">Meta Title</label>
                                    <input type="text" name="meta_title" class="field-input"
                                        placeholder="Page title for search engines">
                                </div>

                                <div class="field-group">
                                    <label class="field-label">Meta Description</label>
                                    <textarea name="meta_description" class="field-textarea"
                                        placeholder="Brief description shown in search results (150–160 chars recommended)"></textarea>
                                </div>

                            </div>
                        </div>

                    </div>

                    <!-- ── RIGHT column ─────────────────────────────── -->
                    <div>

                        <!-- Media -->
                        <div class="section-card">
                            <div class="section-card-header">
                                <h5>Image</h5>
                            </div>
                            <div class="section-card-body">
                                <div class="file-upload-area" id="uploadArea">
                                    <input type="file" name="image" accept="image/*" id="imageInput">
                                    <div class="upload-icon"><i class="fa fa-cloud-upload"></i></div>
                                    <p>Click or drag an image here</p>
                                    <small>PNG, JPG, WEBP — max 2 MB</small>
                                </div>
                                <!-- Preview -->
                                <div id="imagePreview" style="display:none;margin-top:12px;text-align:center">
                                    <img id="previewImg" src="" alt="Preview"
                                        style="max-width:100%;border-radius:var(--radius-sm);border:1px solid var(--border);">
                                    <div style="margin-top:8px">
                                        <button type="button" onclick="clearImage()"
                                            style="font-size:12px;color:var(--red);background:none;border:none;cursor:pointer;padding:0">
                                            <i class="fa fa-times"></i> Remove
                                        </button>
                                    </div>
                                </div>

                                <div style="margin-top:20px;border-top:1px solid #e5e5e5;padding-top:20px">

                                    <label class="field-label">Size Chart Image</label>

                                    <div class="file-upload-area" id="sizeChartUploadArea">
                                        <input type="file" name="size_chart_image" accept="image/*" id="sizeChartInput">

                                        <div class="upload-icon">
                                            <i class="fa fa-table"></i>
                                        </div>

                                        <p>Upload Size Chart</p>
                                        <small>PNG, JPG, WEBP</small>
                                    </div>

                                    <div id="sizeChartPreview" style="display:none;margin-top:12px;text-align:center">

                                        <img id="sizeChartPreviewImg" src=""
                                            style="max-width:100%;border-radius:8px;border:1px solid #ddd;">

                                        <div style="margin-top:8px">
                                            <button type="button" onclick="clearSizeChart()"
                                                style="font-size:12px;color:red;background:none;border:none;cursor:pointer;">
                                                <i class="fa fa-times"></i> Remove
                                            </button>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>



                        <!-- Settings -->
                        <div class="section-card">
                            <div class="section-card-header">
                                <h5>Settings</h5>
                            </div>
                            <div class="section-card-body" style="padding:16px 20px">

                                <div class="toggle-row">
                                    <div>
                                        <div class="toggle-label">Status</div>
                                        <div class="toggle-sub">Visible to customers</div>
                                    </div>
                                    <select name="status" class="field-select-sm">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>

                                <div class="toggle-row">
                                    <div>
                                        <div class="toggle-label">Popular</div>
                                        <div class="toggle-sub">Show in popular list</div>
                                    </div>
                                    <select name="is_popular" class="field-select-sm">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>

                                <div class="toggle-row">
                                    <div>
                                        <div class="toggle-label">Featured</div>
                                        <div class="toggle-sub">Highlight on homepage</div>
                                    </div>
                                    <select name="is_featured" class="field-select-sm">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>

                                <div class="toggle-row">
                                    <div>
                                        <div class="toggle-label">Show In Navbar</div>
                                        <div class="toggle-sub">Display in top navigation</div>
                                    </div>
                                    <select name="show_in_navbar" class="field-select-sm">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>

                <!-- Action bar -->
                <div class="action-bar">
                    <a href="{{ route('admin.categories.index') }}" class="btn-secondary-dash">
                        Cancel
                    </a>
                    <button type="submit" class="btn-primary-dash">
                        <i class="fa fa-save"></i> Save Category
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

@include('admin.footer')

<script>
    // Auto-generate slug from name
    let manualSlug = false;

    $('#slug').on('keyup', function () { manualSlug = true; });

    $('#name').on('keyup', function () {
        if (!manualSlug) {
            let slug = $(this).val()
                .toLowerCase()
                .replace(/ /g, '-')
                .replace(/[^\w-]+/g, '');
            $('#slug').val(slug);
        }
    });

    // Image preview
    document.getElementById('imageInput').addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('imagePreview').style.display = 'block';
            document.getElementById('uploadArea').style.display = 'none';
        };
        reader.readAsDataURL(file);
    });

    function clearImage() {
        document.getElementById('imageInput').value = '';
        document.getElementById('imagePreview').style.display = 'none';
        document.getElementById('uploadArea').style.display = 'block';
    }

    document.getElementById('sizeChartInput').addEventListener('change', function () {

        const file = this.files[0];

        if (!file) return;

        const reader = new FileReader();

        reader.onload = function (e) {

            document.getElementById('sizeChartPreviewImg').src = e.target.result;

            document.getElementById('sizeChartPreview').style.display = 'block';

            document.getElementById('sizeChartUploadArea').style.display = 'none';
        };

        reader.readAsDataURL(file);
    });

    function clearSizeChart() {

        document.getElementById('sizeChartInput').value = '';

        document.getElementById('sizeChartPreview').style.display = 'none';

        document.getElementById('sizeChartUploadArea').style.display = 'block';
    }

</script>