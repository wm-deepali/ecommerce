@include('admin.top-header')

<div class="main-section">
    @include('admin.header')

    <style>
        :root {
            --bg: #f1f2f4;
            --surface: #ffffff;
            --border: #e3e5e8;
            --text-primary: #202223;
            --text-secondary: #6d7175;
            --text-hint: #8c9196;
            --accent: #303d89;
            --accent-light: #f0f1fc;
            --red: #b22222;
            --red-bg: #fce8e8;
            --green: #007a5e;
            --green-bg: #e3f1ec;
            --radius-sm: 8px;
            --radius-md: 12px;
            --shadow-card: 0 1px 3px rgba(0, 0, 0, .08), 0 0 0 1px var(--border);
            --font: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        .edit-page {
            background: var(--bg);
            padding: 24px 28px;
            min-height: 100vh;
            font-family: var(--font);
            color: var(--text-primary);
        }

        .edit-page * {
            box-sizing: border-box;
        }

        /* ── Page header ── */
        .edit-page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 20px;
        }

        .edit-page-header h1 {
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

        /* ── Identity chip ── */
        .col-identity {
            display: flex;
            align-items: center;
            gap: 12px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            padding: 10px 14px;
            box-shadow: var(--shadow-card);
        }

        .col-identity-icon {
            width: 44px;
            height: 44px;
            border-radius: var(--radius-sm);
            background: var(--accent-light);
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent);
            font-size: 18px;
            flex-shrink: 0;
        }

        .col-identity-name {
            font-size: 14px;
            font-weight: 650;
            color: var(--text-primary);
            max-width: 200px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .col-identity-id {
            font-size: 12px;
            color: var(--text-hint);
            margin-top: 2px;
        }

        /* ── Pills ── */
        .pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11.5px;
            font-weight: 600;
        }

        .pill::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .pill-active {
            background: var(--green-bg);
            color: var(--green);
        }

        .pill-active::before {
            background: var(--green);
        }

        .pill-inactive {
            background: var(--red-bg);
            color: var(--red);
        }

        .pill-inactive::before {
            background: var(--red);
        }

        /* ── Buttons ── */
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
            transition: background .15s;
            box-shadow: 0 1px 3px rgba(48, 61, 137, .25);
        }

        .btn-primary-dash:hover:not(:disabled) {
            background: #252f70;
        }

        .btn-primary-dash:disabled {
            opacity: .65;
            cursor: not-allowed;
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
            text-decoration: none !important;
            font-family: var(--font);
            transition: background .15s;
            cursor: pointer;
        }

        .btn-secondary-dash:hover {
            background: var(--bg);
        }

        /* ── Two-column layout ── */
        .edit-layout {
            display: grid;
            grid-template-columns: 1fr 300px;
            gap: 20px;
            align-items: start;
        }

        @media(max-width:900px) {
            .edit-layout {
                grid-template-columns: 1fr;
            }
        }

        /* ── Section card ── */
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

        /* ── Form fields ── */
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
        .field-select {
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

        .field-input,
        .field-textarea {
            width: 100%;
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
        .field-select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(48, 61, 137, .12);
        }

        .field-input:focus,
        .field-textarea:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(48, 61, 137, .12);
        }

        .field-hint {
            font-size: 11.5px;
            color: var(--text-hint);
            margin-top: 4px;
        }

        /* ── Slug prefix ── */
        .slug-wrap {
            display: flex;
        }

        .slug-prefix {
            display: inline-flex;
            align-items: center;
            padding: 0 10px;
            background: var(--bg);
            border: 1px solid var(--border);
            border-right: none;
            border-radius: var(--radius-sm) 0 0 var(--radius-sm);
            font-size: 12px;
            color: var(--text-hint);
            white-space: nowrap;
        }

        .slug-wrap .field-input {
            border-radius: 0 var(--radius-sm) var(--radius-sm) 0;
        }

        /* ── Toggle rows (right column) ── */
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
            min-width: 100px;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%238c9196'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 9px center;
        }

        .field-select-sm:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(48, 61, 137, .12);
        }

        /* ── Action bar ── */
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
            .edit-page {
                padding: 16px;
            }
        }
    </style>

    <div class="app-content content container-fluid">
        <div class="edit-page">

            <!-- Page header -->
            <div class="edit-page-header">
                <div>
                    <h1>Edit Collection</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        <a href="{{ route('admin.collections.index') }}">Manage Collections</a>
                        <span>›</span>
                        Edit Collection
                    </div>
                </div>

                <!-- Identity chip -->
                <div class="col-identity">
                    <div class="col-identity-icon">
                        <i class="fa fa-layer-group"></i>
                    </div>
                    <div>
                        <div class="col-identity-name">{{ $collection->name }}</div>
                        <div class="col-identity-id">
                            ID #{{ $collection->id }} &middot;
                            @if(old('status', $collection->status) == 1)
                                <span class="pill pill-active">Active</span>
                            @else
                                <span class="pill pill-inactive">Inactive</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <form id="editForm" method="POST" action="{{ route('admin.collections.update', $collection->id) }}">
                @csrf
                @method('PUT')

                <div class="edit-layout">

                    <!-- ── LEFT column ── -->
                    <div>
                        <div class="section-card">
                            <div class="section-card-header">
                                <h5>Collection Details</h5>
                            </div>
                            <div class="section-card-body">

                                <div class="field-group">
                                    <label class="field-label">Name <span class="req">*</span></label>
                                    <input type="text" name="name" id="name" class="field-input"
                                        value="{{ old('name', $collection->name) }}" required>
                                </div>

                                <div class="field-group">
                                    <label class="field-label">Slug</label>
                                    <div class="slug-wrap">
                                        <span class="slug-prefix">collection/</span>
                                        <input type="text" name="slug" id="slug" class="field-input"
                                            value="{{ old('slug', $collection->slug) }}">
                                    </div>
                                    <div class="field-hint">Auto-generated from name. You can edit manually.</div>
                                </div>

                                <div class="field-group">
                                    <label class="field-label">Sort Order</label>
                                    <input type="number" name="sort_order" class="field-input"
                                        value="{{ old('sort_order', $collection->sort_order) }}"
                                        style="max-width:120px">
                                    <div class="field-hint">Lower numbers appear first.</div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- ── RIGHT column ── -->
                    <div>
                        <div class="section-card">
                            <div class="section-card-header">
                                <h5>SEO Settings</h5>
                            </div>

                            <div class="section-card-body">

                                <div class="field-group">
                                    <label class="field-label">Meta Title</label>
                                    <input type="text" name="meta_title" class="field-input"
                                        value="{{ old('meta_title', $collection->meta_title ?? '') }}"
                                        placeholder="Enter meta title">
                                </div>

                                <div class="field-group">
                                    <label class="field-label">Meta Description</label>
                                    <textarea name="meta_description" class="field-textarea" rows="4"
                                        placeholder="Enter meta description">{{ old('meta_description', $collection->meta_description ?? '') }}</textarea>
                                </div>

                            </div>
                        </div>
                        <div class="section-card">
                            <div class="section-card-header">
                                <h5>Settings</h5>
                            </div>
                            <div class="section-card-body" style="padding:16px 20px">
                                <div class="toggle-row">
                                    <div>
                                        <div class="toggle-label">Status</div>
                                        <div class="toggle-sub">Visibility on storefront</div>
                                    </div>
                                    <select name="status" class="field-select-sm">
                                        <option value="1" {{ old('status', $collection->status) == 1 ? 'selected' : '' }}>
                                            Active</option>
                                        <option value="0" {{ old('status', $collection->status) == 0 ? 'selected' : '' }}>
                                            Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Action bar -->
                <div class="action-bar">
                    <a href="{{ route('admin.collections.index') }}" class="btn-secondary-dash">Cancel</a>
                    <button type="submit" id="updateBtn" class="btn-primary-dash">
                        <i class="fa fa-save"></i> Update Collection
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

@include('admin.footer')

<script>
    let manualSlug = false;

    $('#slug').on('keyup', function () {
        manualSlug = true;
    });

    $('#name').on('keyup', function () {
        if (!manualSlug) {
            let slug = $(this).val()
                .toLowerCase()
                .replace(/ /g, '-')
                .replace(/[^\w-]+/g, '');
            $('#slug').val(slug);
        }
    });

    document.getElementById('editForm').addEventListener('submit', function () {
        const btn = document.getElementById('updateBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Updating...';
    });
</script>