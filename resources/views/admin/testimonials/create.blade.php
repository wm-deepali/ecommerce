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
        --purple:        #6d28d9;
        --purple-bg:     #ede9fe;
        --radius-sm:     8px;
        --radius-md:     12px;
        --shadow-card:   0 1px 3px rgba(0,0,0,.08), 0 0 0 1px var(--border);
        --font:          'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }

    .test-create { background: var(--bg); padding: 24px 28px; min-height: 100vh; font-family: var(--font); color: var(--text-primary); }
    .test-create * { box-sizing: border-box; }

    .page-header { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 20px; }
    .page-header h1 { font-size: 20px; font-weight: 650; color: var(--text-primary); margin: 0; }
    .crumb { font-size: 12.5px; color: var(--text-hint); margin-top: 3px; }
    .crumb a { color: var(--accent); text-decoration: none; }
    .crumb a:hover { text-decoration: underline; }
    .crumb span { margin: 0 5px; }

    /* Layout */
    .create-layout { display: grid; grid-template-columns: 1fr 280px; gap: 20px; align-items: start; }
    @media(max-width:900px) { .create-layout { grid-template-columns: 1fr; } }

    /* Section card */
    .section-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-md); box-shadow: var(--shadow-card); overflow: hidden; margin-bottom: 16px; }
    .section-card:last-child { margin-bottom: 0; }
    .section-card-header { padding: 14px 20px; border-bottom: 1px solid var(--border); background: #fafafa; }
    .section-card-header h5 { font-size: 13px; font-weight: 650; color: var(--text-primary); margin: 0; }
    .section-card-body { padding: 20px; }

    /* Fields */
    .field-group { margin-bottom: 16px; }
    .field-group:last-child { margin-bottom: 0; }
    .field-label { display: block; font-size: 12px; font-weight: 600; color: var(--text-secondary); letter-spacing: .03em; text-transform: uppercase; margin-bottom: 6px; }
    .field-hint { font-size: 11.5px; color: var(--text-hint); margin-top: 4px; }

    .field-input, .field-select, .field-textarea {
        width: 100%; border: 1px solid var(--border);
        border-radius: var(--radius-sm); padding: 0 12px;
        font-size: 13.5px; color: var(--text-primary); background: var(--surface);
        outline: none; transition: border-color .15s, box-shadow .15s; font-family: var(--font);
    }
    .field-input, .field-select { height: 38px; }
    .field-textarea { padding: 10px 12px; resize: vertical; min-height: 110px; }
    .field-input:focus, .field-select:focus, .field-textarea:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(48,61,137,.12); }

    /* Two col grid */
    .two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
    @media(max-width:600px) { .two-col { grid-template-columns: 1fr; } }

    /* Type radio cards */
    .type-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
    .type-option { display: none; }
    .type-option + label {
        display: flex; flex-direction: column; align-items: center; gap: 8px;
        padding: 14px 10px; border: 1.5px solid var(--border); border-radius: var(--radius-sm);
        cursor: pointer; transition: all .15s; text-align: center; background: var(--surface);
    }
    .type-option + label .t-icon { font-size: 20px; color: var(--text-hint); }
    .type-option + label .t-name { font-size: 12.5px; font-weight: 600; color: var(--text-secondary); }
    .type-option:checked + label { border-color: var(--accent); background: var(--accent-light); }
    .type-option:checked + label .t-icon,
    .type-option:checked + label .t-name { color: var(--accent); }
    .type-option + label:hover { border-color: var(--accent); background: var(--accent-light); }

    /* Upload area */
    .upload-area { border: 2px dashed var(--border); border-radius: var(--radius-sm); padding: 20px; text-align: center; cursor: pointer; transition: border-color .15s, background .15s; position: relative; }
    .upload-area:hover { border-color: var(--accent); background: var(--accent-light); }
    .upload-area input[type=file] { position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%; }
    .upload-area .up-icon { font-size: 20px; color: var(--text-hint); margin-bottom: 5px; }
    .upload-area p { font-size: 13px; color: var(--text-secondary); margin: 0; }
    .upload-area small { font-size: 11.5px; color: var(--text-hint); }

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
        transition: border-color .15s;
    }
    .field-select-sm:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(48,61,137,.12); }

    /* Reel section */
    #reelSection { display: none; }

    /* Buttons */
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
        padding: 8px 18px; font-size: 13px; font-weight: 500; cursor: pointer;
        text-decoration: none !important; font-family: var(--font); transition: background .15s;
    }
    .btn-secondary-dash:hover { background: var(--bg); }

    /* Action bar */
    .action-bar { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-md); box-shadow: var(--shadow-card); padding: 14px 20px; display: flex; align-items: center; justify-content: flex-end; gap: 10px; margin-top: 20px; }

    @media(max-width:768px) { .test-create { padding: 16px; } }
    </style>

    <div class="app-content content container-fluid">
        <div class="test-create">

            <div class="page-header">
                <div>
                    <h1>Add Testimonial</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        <a href="{{ route('admin.testimonials.index') }}">Testimonials</a>
                        <span>›</span>
                        Add Testimonial
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.testimonials.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="create-layout">

                    <!-- LEFT -->
                    <div>

                        <!-- Type selector -->
                        <div class="section-card">
                            <div class="section-card-header"><h5>Testimonial Type</h5></div>
                            <div class="section-card-body">
                                <div class="type-grid">
                                    <input type="radio" name="type" id="type_text" value="text" class="type-option" checked>
                                    <label for="type_text">
                                        <span class="t-icon"><i class="fa fa-comment"></i></span>
                                        <span class="t-name">Text Review</span>
                                    </label>
                                    <input type="radio" name="type" id="type_reel" value="reel" class="type-option">
                                    <label for="type_reel">
                                        <span class="t-icon"><i class="fa fa-play-circle"></i></span>
                                        <span class="t-name">Video Reel</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Details -->
                        <div class="section-card">
                            <div class="section-card-header"><h5>Customer Details</h5></div>
                            <div class="section-card-body">

                                <div class="field-group">
                                    <label class="field-label">Customer Name</label>
                                    <input type="text" name="name" class="field-input" placeholder="e.g. Priya Sharma">
                                </div>

                                <!-- Text section -->
                                <div id="textSection">
                                    <div class="field-group">
                                        <label class="field-label">Feedback</label>
                                        <textarea name="feedback" class="field-textarea" placeholder="What did the customer say?"></textarea>
                                    </div>
                                    <div class="field-group">
                                        <label class="field-label">Rating</label>
                                        <select name="rating" class="field-select">
                                            <option value="">Select Rating</option>
                                            <option value="1">⭐ 1 — Poor</option>
                                            <option value="2">⭐⭐ 2 — Fair</option>
                                            <option value="3">⭐⭐⭐ 3 — Good</option>
                                            <option value="4">⭐⭐⭐⭐ 4 — Very Good</option>
                                            <option value="5">⭐⭐⭐⭐⭐ 5 — Excellent</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Reel section -->
                                <div id="reelSection">
                                    <div class="field-group">
                                        <label class="field-label">Reel URL</label>
                                        <input type="text" name="reel_url" class="field-input" placeholder="https://www.instagram.com/reel/...">
                                        <div class="field-hint">Paste an Instagram Reel or YouTube Shorts URL</div>
                                    </div>
                                    <div class="field-group">
                                        <label class="field-label">Or Upload Reel File</label>
                                        <div class="upload-area">
                                            <input type="file" name="reel_file" accept="video/*">
                                            <div class="up-icon"><i class="fa fa-video-camera"></i></div>
                                            <p>Click to upload video</p>
                                            <small>MP4, MOV — max 50 MB</small>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Photo -->
                      <!-- Photo -->
<div class="section-card">
    <div class="section-card-header">
        <h5>Customer Photo</h5>
    </div>

    <div class="section-card-body">
        <div class="upload-area">

            <input type="file"
                   name="photo"
                   accept="image/*"
                   id="photoInput">

            <div id="photoPlaceholder">
                <div class="up-icon">
                    <i class="fa fa-user-circle-o"></i>
                </div>

                <p id="photoText">Upload customer photo (optional)</p>
                <small>PNG, JPG, JPEG, WEBP — max 2 MB</small>
            </div>

            <img id="photoPreview"
                 src=""
                 alt="Preview"
                 style="
                    display:none;
                    width:150px;
                    height:150px;
                    object-fit:cover;
                    border-radius:10px;
                    margin:10px auto;
                    border:1px solid #ddd;
                 ">
        </div>
    </div>
</div>

                    </div>

                    <!-- RIGHT -->
                    <div>
                        <div class="section-card">
                            <div class="section-card-header"><h5>Settings</h5></div>
                            <div class="section-card-body" style="padding:14px 20px">
                                <div class="toggle-row" style="padding:0;border:none">
                                    <div>
                                        <div class="toggle-label">Status</div>
                                        <div class="toggle-sub">Show on store</div>
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

                <div class="action-bar">
                    <a href="{{ route('admin.testimonials.index') }}" class="btn-secondary-dash">Cancel</a>
                    <button type="submit" id="saveBtn" class="btn-primary-dash">
                        <i class="fa-solid fa-save"></i> Save Testimonial
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

@include('admin.footer')

<script>
// Type toggle — preserves original logic
function handleTypeChange() {
    var type = $('input[name="type"]:checked').val();
    if (type === 'reel') {
        $('#reelSection').show();
        $('#textSection').hide();
    } else {
        $('#reelSection').hide();
        $('#textSection').show();
    }
}

$('input[name="type"]').on('change', handleTypeChange);
handleTypeChange();

// Submit spinner
document.getElementById('saveBtn').closest('form').addEventListener('submit', function () {
    var btn = document.getElementById('saveBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Saving...';
});

// Photo Preview
document.getElementById('photoInput').addEventListener('change', function (e) {

    const file = e.target.files[0];

    if (!file) {
        return;
    }

    document.getElementById('photoText').innerText = file.name;

    const reader = new FileReader();

    reader.onload = function (event) {

        document.getElementById('photoPreview').src = event.target.result;
        document.getElementById('photoPreview').style.display = 'block';

        document.getElementById('photoPlaceholder').style.display = 'none';
    };

    reader.readAsDataURL(file);
});
</script>