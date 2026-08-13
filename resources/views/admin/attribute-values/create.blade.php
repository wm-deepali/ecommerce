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
            --radius-sm: 8px;
            --radius-md: 12px;
            --shadow-card: 0 1px 3px rgba(0, 0, 0, .08), 0 0 0 1px var(--border);
            --font: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        .cav-page {
            background: var(--bg);
            padding: 24px 28px;
            min-height: 100vh;
            font-family: var(--font);
            color: var(--text-primary);
        }

        .cav-page * {
            box-sizing: border-box;
        }

        /* Header */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 20px;
        }

        .page-header h1 {
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

        /* Layout */
        .cav-layout {
            display: grid;
            grid-template-columns: 1fr 300px;
            gap: 20px;
            align-items: start;
        }

        @media(max-width:860px) {
            .cav-layout {
                grid-template-columns: 1fr;
            }
        }

        /* Section card */
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
        }

        .section-card-body {
            padding: 20px;
        }

        /* Fields */
        .field-group {
            margin-bottom: 18px;
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
            margin-top: 5px;
            line-height: 1.5;
        }

        /* Settings toggle rows */
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
            min-width: 90px;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%238c9196'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 9px center;
            transition: border-color .15s, box-shadow .15s;
        }

        .field-select-sm:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(48, 61, 137, .12);
        }

        /* Buttons */
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
            cursor: pointer;
            text-decoration: none !important;
            font-family: var(--font);
            transition: background .15s;
        }

        .btn-secondary-dash:hover {
            background: var(--bg);
        }

        /* Action bar */
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
            .cav-page {
                padding: 16px;
            }
        }
    </style>

    <div class="app-content content container-fluid">
        <div class="cav-page">

            <!-- Page header -->
            <div class="page-header">
                <div>
                    <h1>Add Attribute Value</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        <a href="{{ route('admin.attribute-values.index') }}">Attribute Values</a>
                        <span>›</span>
                        Add Attribute Value
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.attribute-values.store') }}" enctype="multipart/form-data"
                class="save-form">
                @csrf

                <div class="cav-layout">

                    <!-- ── LEFT column ──────────────────── -->
                    <div>
                        <div class="section-card">
                            <div class="section-card-header">
                                <h5>Value Details</h5>
                            </div>
                            <div class="section-card-body">

                                <div class="field-group">
                                    <label class="field-label">Attribute <span class="req">*</span></label>

                                    <select name="attribute_id" class="field-select" required id="attributeSelect">
                                        <option value="">— Select an attribute —</option>

                                        @foreach($attributes as $attribute)
                                            <option value="{{ $attribute->id }}" data-type="{{ $attribute->type }}">
                                                {{ $attribute->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <div class="field-hint">
                                        The attribute this value belongs to.
                                    </div>
                                </div>

                                <div class="field-group">
                                    <label class="field-label">Value <span class="req">*</span></label>
                                    <input type="text" name="value" class="field-input" required
                                        placeholder="e.g. Red, XL, Cotton">
                                </div>

                                <div class="field-group" id="imageWrapper" style="display:none;">
                                    <label class="field-label">Image</label>

                                    <input type="file" name="image" class="field-input" accept="image/*">

                                    <div class="field-hint">
                                        Upload image for Image type attributes.
                                    </div>
                                </div>

                                <div class="field-group" id="hexCodeWrapper" style="display:none;">
                                    <label class="field-label">
                                        Hexa Code <span class="req">*</span>
                                    </label>

                                    <input type="color" name="hex_code" value="#000000" class="field-input"
                                        style="padding:4px;height:45px;">

                                    <div class="field-hint">
                                        Required for Colour Swatch attributes.
                                    </div>
                                </div>

                                <div class="field-group">
                                    <label class="field-label">Sort Order</label>
                                    <input type="number" name="sort_order" class="field-input" value="0"
                                        style="max-width:120px">
                                    <div class="field-hint">Lower numbers appear first in the list.</div>
                                </div>

                            </div>
                        </div>

                        <!-- Help card -->
                        <div class="section-card">
                            <div class="section-card-header">
                                <h5>Examples</h5>
                            </div>
                            <div class="section-card-body" style="padding:16px 20px">
                                <div style="font-size:12.5px;color:var(--text-secondary);line-height:1.8">
                                    <div style="display:flex;align-items:center;gap:8px;margin-bottom:6px">
                                        <span
                                            style="background:var(--accent-light);color:var(--accent);font-size:11px;font-weight:600;padding:2px 8px;border-radius:6px">Colour</span>
                                        <span style="color:var(--text-hint)">→</span>
                                        <span>Red, Blue, Green</span>
                                    </div>
                                    <div style="display:flex;align-items:center;gap:8px;margin-bottom:6px">
                                        <span
                                            style="background:var(--accent-light);color:var(--accent);font-size:11px;font-weight:600;padding:2px 8px;border-radius:6px">Size</span>
                                        <span style="color:var(--text-hint)">→</span>
                                        <span>XS, S, M, L, XL</span>
                                    </div>
                                    <div style="display:flex;align-items:center;gap:8px">
                                        <span
                                            style="background:var(--accent-light);color:var(--accent);font-size:11px;font-weight:600;padding:2px 8px;border-radius:6px">Material</span>
                                        <span style="color:var(--text-hint)">→</span>
                                        <span>Cotton, Polyester</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ── RIGHT column ─────────────────── -->
                    <div>
                        <div class="section-card">
                            <div class="section-card-header">
                                <h5>SEO Settings</h5>
                            </div>

                            <div class="section-card-body">

                                <div class="field-group">
                                    <label class="field-label">Meta Title</label>
                                    <input type="text" name="meta_title" class="field-input"
                                        value="{{ old('meta_title' ?? '') }}" placeholder="Enter meta title">
                                </div>

                                <div class="field-group">
                                    <label class="field-label">Meta Description</label>
                                    <textarea name="meta_description" class="field-textarea" rows="4"
                                        placeholder="Enter meta description">{{ old('meta_description' ?? '') }}</textarea>
                                </div>

                            </div>
                        </div>

                        <div class="section-card">
                            <div class="section-card-header">
                                <h5>Settings</h5>
                            </div>
                            <div class="section-card-body" style="padding:16px 20px">
                                <div class="toggle-row" style="padding-top:0;padding-bottom:0;border:none">
                                    <div>
                                        <div class="toggle-label">Status</div>
                                        <div class="toggle-sub">Visible on products</div>
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
                    <a href="{{ route('admin.attribute-values.index') }}" class="btn-secondary-dash">
                        Cancel
                    </a>
                    <button type="submit" class="btn-primary-dash save-btn">
                        <i class="fa fa-save"></i> Save Value
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

@include('admin.footer')

<script>
$(document).on('submit', '.save-form', function () {
    const btn = $(this).find('.save-btn');
    btn.prop('disabled', true);
    btn.html('<i class="fa fa-spinner fa-spin"></i> Processing…');
});

function handleAttributeType() {

    let type = $('#attributeSelect option:selected').data('type');

    $('#imageWrapper').hide();
    $('#hexCodeWrapper').hide();

    if (type === 'image') {
        $('#imageWrapper').show();
    }

    if (type === 'color_swatch') {
        $('#hexCodeWrapper').show();
    }
}

$(document).ready(function () {

    $('#attributeSelect').on('change', function () {
        handleAttributeType();
    });

    handleAttributeType();
});
</script>