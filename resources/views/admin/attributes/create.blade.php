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
            --green: #007a5e;
            --red: #b22222;
            --radius-sm: 8px;
            --radius-md: 12px;
            --shadow-card: 0 1px 3px rgba(0, 0, 0, .08), 0 0 0 1px var(--border);
            --font: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        .create-attr-page {
            background: var(--bg);
            padding: 24px 28px;
            min-height: 100vh;
            font-family: var(--font);
            color: var(--text-primary);
        }

        .create-attr-page * {
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
        .attr-create-layout {
            display: grid;
            grid-template-columns: 1fr 300px;
            gap: 20px;
            align-items: start;
        }

        @media(max-width:860px) {
            .attr-create-layout {
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

        .field-input:focus,
        .field-select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(48, 61, 137, .12);
        }

        .field-hint {
            font-size: 11.5px;
            color: var(--text-hint);
            margin-top: 5px;
            line-height: 1.5;
        }

        .field-hint code {
            background: var(--bg);
            padding: 1px 5px;
            border-radius: 4px;
            font-size: 11px;
            color: var(--accent);
        }

        /* Type option cards */
        .type-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }

        .type-option {
            display: none;
        }

        .type-option+label {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
            padding: 12px 8px;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            cursor: pointer;
            transition: all .15s;
            text-align: center;
            background: var(--surface);
        }

        .type-option+label .type-icon {
            font-size: 18px;
            color: var(--text-hint);
            transition: color .15s;
        }

        .type-option+label .type-name {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-secondary);
            transition: color .15s;
        }

        .type-option:checked+label {
            border-color: var(--accent);
            background: var(--accent-light);
        }

        .type-option:checked+label .type-icon {
            color: var(--accent);
        }

        .type-option:checked+label .type-name {
            color: var(--accent);
        }

        .type-option+label:hover {
            border-color: var(--accent);
            background: var(--accent-light);
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

        /* Info callout */
        .info-callout {
            background: var(--accent-light);
            border: 1px solid #c7cdf5;
            border-radius: var(--radius-sm);
            padding: 12px 14px;
            font-size: 12.5px;
            color: #2a3580;
            line-height: 1.5;
            margin-top: 14px;
        }

        .info-callout i {
            margin-right: 5px;
        }

        @media(max-width:768px) {
            .create-attr-page {
                padding: 16px;
            }
        }
    </style>

    <div class="app-content content container-fluid">
        <div class="create-attr-page">

            <!-- Page header -->
            <div class="page-header">
                <div>
                    <h1>Add Attribute</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        <a href="{{ route('admin.attributes.index') }}">Attributes</a>
                        <span>›</span>
                        Add Attribute
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.attributes.store') }}" class="save-form">
                @csrf

                <div class="attr-create-layout">

                    <!-- ── LEFT column ──────────────────── -->
                    <div>

                        <!-- Basic Info -->
                        <div class="section-card">
                            <div class="section-card-header">
                                <h5>Basic Information</h5>
                            </div>
                            <div class="section-card-body">

                                <div class="field-group">
                                    <label class="field-label">Name <span class="req">*</span></label>
                                    <input type="text" name="name" class="field-input" required
                                        placeholder="e.g. Colour, Size, Material">
                                </div>

                                <div class="field-group">
                                    <label class="field-label">Type <span class="req">*</span></label>

                                    @php
                                        $attributeTypes = [
                                            'button' => [
                                                'icon' => 'fa-square-o',
                                                'label' => 'Button'
                                            ],
                                            'dropdown' => [
                                                'icon' => 'fa-caret-square-o-down',
                                                'label' => 'Dropdown'
                                            ],
                                            'image' => [
                                                'icon' => 'fa-image',
                                                'label' => 'Image'
                                            ],
                                            'color_swatch' => [
                                                'icon' => 'fa-paint-brush',
                                                'label' => 'Colour Swatch'
                                            ],
                                            'radio' => [
                                                'icon' => 'fa-dot-circle-o',
                                                'label' => 'Radio'
                                            ],
                                        ];
                                    @endphp

                                    <div class="type-grid">
                                        @foreach($attributeTypes as $value => $config)

                                            <input type="radio" name="type" id="type_{{ $value }}" value="{{ $value }}"
                                                class="type-option" {{ old('type', isset($attribute) ? $attribute->type : 'button') == $value ? 'checked' : '' }} required>

                                            <label for="type_{{ $value }}">
                                                <span class="type-icon">
                                                    <i class="fa {{ $config['icon'] }}"></i>
                                                </span>

                                                <span class="type-name">
                                                    {{ $config['label'] }}
                                                </span>
                                            </label>

                                        @endforeach
                                    </div>

                                    <div class="field-hint">
                                        Controls how this attribute will appear on the product page.
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

                    <!-- ── RIGHT column ─────────────────── -->
                    <div>

                        <!-- Settings -->
                        <div class="section-card">
                            <div class="section-card-header">
                                <h5>Settings</h5>
                            </div>
                            <div class="section-card-body" style="padding:16px 20px">

                                <div class="toggle-row">
                                    <div>
                                        <div class="toggle-label">Has Values</div>
                                        <div class="toggle-sub">Predefined options (e.g. Red, Blue)</div>
                                    </div>
                                    <select name="has_values" class="field-select-sm">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>

                                <div class="toggle-row">
                                    <div>
                                        <div class="toggle-label">Status</div>
                                        <div class="toggle-sub">Visible on products</div>
                                    </div>
                                    <select name="status" class="field-select-sm">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>

                                <div class="toggle-row">
                                    <div>
                                        <div class="toggle-label">Show in Navbar</div>
                                        <div class="toggle-sub">Display this attribute in the navbar menu</div>
                                    </div>
                                    <select name="show_in_navbar" class="field-select-sm">
                                        <option value="1">Yes</option>
                                        <option value="0" selected>No</option>
                                    </select>
                                </div>

                            </div>
                        </div>

                        <!-- Help card -->
                        <div class="section-card">
                            <div class="section-card-header">
                                <h5>Attribute Type Guide</h5>
                            </div>

                            <div class="section-card-body" style="padding:16px 20px">
                                <div style="font-size:12.5px;color:var(--text-secondary);line-height:1.8">

                                    <div style="margin-bottom:8px">
                                        <strong>Button</strong> —
                                        Size, Pack Size, Quantity
                                    </div>

                                    <div style="margin-bottom:8px">
                                        <strong>Dropdown</strong> —
                                        Material, Paper Type, Finish
                                    </div>

                                    <div style="margin-bottom:8px">
                                        <strong>Image</strong> —
                                        Design Selection, Pattern Selection
                                    </div>

                                    <div style="margin-bottom:8px">
                                        <strong>Colour Swatch</strong> —
                                        Color Selection
                                    </div>

                                    <div>
                                        <strong>Radio</strong> —
                                        Yes/No, Single Choice Options
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Action bar -->
                <div class="action-bar">
                    <a href="{{ route('admin.attributes.index') }}" class="btn-secondary-dash">
                        Cancel
                    </a>
                    <button type="submit" class="btn-primary-dash save-btn">
                        <i class="fa fa-save"></i> Save Attribute
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
</script>