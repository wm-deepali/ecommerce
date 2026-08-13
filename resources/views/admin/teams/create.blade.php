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
        --green-bg:      #e3f1ec;
        --red:           #b22222;
        --red-bg:        #fce8e8;
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

    /* ── Alert banner ── */
    .alert-banner { padding: 14px 16px; border-radius: var(--radius-sm); font-size: 13px; margin-bottom: 16px; }
    .alert-danger { background: var(--red-bg); color: var(--red); border: 1px solid #f5c0c0; }
    .alert-banner ul { margin: 0; padding-left: 18px; }
    .alert-banner li { margin-bottom: 2px; }
    .alert-banner li:last-child { margin-bottom: 0; }
    .alert-banner-title { display: flex; align-items: center; gap: 8px; font-weight: 650; margin-bottom: 6px; }

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
    .create-layout { display: grid; grid-template-columns: 1fr 300px; gap: 20px; align-items: start; }
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

    .field-input, .field-textarea {
        width: 100%; border: 1px solid var(--border);
        border-radius: var(--radius-sm); padding: 0 12px;
        font-size: 13.5px; color: var(--text-primary);
        background: var(--surface); outline: none;
        transition: border-color .15s, box-shadow .15s;
        font-family: var(--font);
    }
    .field-input { height: 38px; }
    .field-textarea { padding: 10px 12px; resize: vertical; }
    .field-input:focus, .field-textarea:focus {
        border-color: var(--accent); box-shadow: 0 0 0 3px rgba(48,61,137,.12);
    }
    .field-hint  { font-size: 11.5px; color: var(--text-hint); margin-top: 4px; }
    .field-error { font-size: 11.5px; color: var(--red); margin-top: 4px; }

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
    .upload-preview { display: none; flex-direction: column; align-items: center; gap: 8px; }
    .upload-preview img { width: 90px; height: 90px; object-fit: cover; border-radius: 50%; border: 1px solid var(--border); }
    .upload-preview span { font-size: 12px; color: var(--text-hint); }

    /* ── Toggle rows (right column) ── */
    .toggle-row { display: flex; align-items: center; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid var(--bg); }
    .toggle-row:last-child { border-bottom: none; padding-bottom: 0; }
    .toggle-row:first-child { padding-top: 0; }
    .toggle-label { font-size: 13px; font-weight: 500; color: var(--text-primary); }
    .toggle-sub   { font-size: 11.5px; color: var(--text-hint); margin-top: 2px; }

    /* Toggle switch */
    .toggle-switch { position: relative; width: 38px; height: 22px; flex-shrink: 0; }
    .toggle-switch input { opacity: 0; width: 0; height: 0; position: absolute; }
    .toggle-track { position: absolute; inset: 0; background: var(--border); border-radius: 22px; cursor: pointer; transition: background .2s; }
    .toggle-track::after { content:''; position:absolute; left:3px; top:3px; width:16px; height:16px; background:#fff; border-radius:50%; transition:transform .2s; box-shadow:0 1px 3px rgba(0,0,0,.2); }
    .toggle-switch input:checked + .toggle-track { background: var(--accent); }
    .toggle-switch input:checked + .toggle-track::after { transform: translateX(16px); }

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
                    <h1>Add Team Member</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        <a href="{{ route('admin.teams.index') }}">Manage Team</a>
                        <span>›</span>
                        Add Team
                    </div>
                </div>
            </div>

            @if($errors->any())
                <div class="alert-banner alert-danger">
                    <div class="alert-banner-title"><i class="fa fa-triangle-exclamation"></i> Please fix the following:</div>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="teamForm" method="POST" enctype="multipart/form-data"
                  action="{{ route('admin.teams.store') }}">
                @csrf

                <div class="create-layout">

                    <!-- ── LEFT column ── -->
                    <div>

                        <!-- Team Member Details -->
                        <div class="section-card">
                            <div class="section-card-header"><h5>Team Member Details</h5></div>
                            <div class="section-card-body">

                                <div class="field-group">
                                    <label class="field-label">Name <span class="req">*</span></label>
                                    <input type="text" name="name" class="field-input" value="{{ old('name') }}">
                                    @error('name') <div class="field-error">{{ $message }}</div> @enderror
                                </div>

                                <div class="field-group">
                                    <label class="field-label">Designation <span class="req">*</span></label>
                                    <input type="text" name="designation" class="field-input" value="{{ old('designation') }}">
                                    @error('designation') <div class="field-error">{{ $message }}</div> @enderror
                                </div>

                                <div class="field-group">
                                    <label class="field-label">Description</label>
                                    <textarea name="description" class="field-textarea" rows="5"
                                              placeholder="A short bio shown on the team profile…">{{ old('description') }}</textarea>
                                </div>

                            </div>
                        </div>

                    </div>

                    <!-- ── RIGHT column ── -->
                    <div>

                        <!-- Photo upload -->
                        <div class="section-card">
                            <div class="section-card-header"><h5>Photo</h5></div>
                            <div class="section-card-body">
                                <div class="upload-area" id="uploadArea">
                                    <input type="file" name="image" id="imageInput" accept="image/*">
                                    <div id="uploadPlaceholder">
                                        <div class="upload-icon"><i class="fa fa-cloud-upload"></i></div>
                                        <div class="upload-label">Click to upload photo</div>
                                        <div class="upload-sub">PNG, JPG · square image recommended</div>
                                    </div>
                                    <div class="upload-preview" id="uploadPreview">
                                        <img id="previewImg" src="" alt="Preview">
                                        <span id="previewName"></span>
                                    </div>
                                </div>
                                @error('image') <div class="field-error">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <!-- Settings -->
                        <div class="section-card">
                            <div class="section-card-header"><h5>Settings</h5></div>
                            <div class="section-card-body">

                                <div class="toggle-row">
                                    <div>
                                        <div class="toggle-label">Status</div>
                                        <div class="toggle-sub">Show this member on the team page</div>
                                    </div>
                                    <label class="toggle-switch">
                                        <input type="hidden" name="status" value="0">
                                        <input type="checkbox" name="status" id="status" value="1"
                                               {{ old('status', true) ? 'checked' : '' }}>
                                        <span class="toggle-track"></span>
                                    </label>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>

                <!-- Action bar -->
                <div class="action-bar">
                    <a href="{{ route('admin.teams.index') }}" class="btn-secondary-dash">Cancel</a>
                    <button type="submit" id="saveBtn" class="btn-primary-dash">
                        <i class="fa-solid fa-save"></i> Save Team Member
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

@include('admin.footer')

<script>
// Image preview
document.getElementById('imageInput').addEventListener('change', function () {
    const file = this.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('previewImg').src = e.target.result;
        document.getElementById('previewName').textContent = file.name;
        document.getElementById('uploadPlaceholder').style.display = 'none';
        document.getElementById('uploadPreview').style.display = 'flex';
    };
    reader.readAsDataURL(file);
});

// Submit spinner
document.getElementById('teamForm').addEventListener('submit', function () {
    const btn = document.getElementById('saveBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Saving...';
});
</script>