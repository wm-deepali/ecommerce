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

        .edit-attr-page {
            background: var(--bg);
            padding: 24px 28px;
            min-height: 100vh;
            font-family: var(--font);
            color: var(--text-primary);
        }

        .edit-attr-page * {
            box-sizing: border-box;
        }

        /* Header */
        .page-header {
            display: flex;
            align-items: flex-start;
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

        /* Identity chip */
        .attr-identity {
            display: flex;
            align-items: center;
            gap: 10px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            padding: 10px 16px;
            box-shadow: var(--shadow-card);
        }

        .attr-identity-icon {
            width: 40px;
            height: 40px;
            border-radius: var(--radius-sm);
            background: var(--accent-light);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            color: var(--accent);
            flex-shrink: 0;
        }

        .attr-identity-name {
            font-size: 14px;
            font-weight: 650;
            color: var(--text-primary);
        }

        .attr-identity-id {
            font-size: 12px;
            color: var(--text-hint);
            margin-top: 1px;
        }

        /* Layout */
        .attr-edit-layout {
            display: grid;
            grid-template-columns: 1fr 300px;
            gap: 20px;
            align-items: start;
        }

        @media(max-width:860px) {
            .attr-edit-layout {
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

        .field-input {
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

        .field-input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(48, 61, 137, .12);
        }

        /* Type radio cards */
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

        .type-option:checked+label .type-icon,
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

        @media(max-width:768px) {
            .edit-attr-page {
                padding: 16px;
            }
        }
    </style>

    <div class="app-content content container-fluid">
        <div class="edit-attr-page">

            <!-- Page header -->
            <div class="page-header">
                <div>
                    <h1>Edit Attribute</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        <a href="{{ route('admin.attributes.index') }}">Attributes</a>
                        <span>›</span>
                        Edit Attribute
                    </div>
                </div>

                <!-- Identity chip -->
                <div class="attr-identity">
                    @php
                        $typeIcons = [
                            'button' => 'fa-square-o',
                            'dropdown' => 'fa-caret-square-o-down',
                            'image' => 'fa-image',
                            'color_swatch' => 'fa-paint-brush',
                            'radio' => 'fa-dot-circle-o',
                        ];
                        $currentIcon = $typeIcons[$attribute->type] ?? 'fa-tag';
                    @endphp
                    <div class="attr-identity-icon">
                        <i class="fa {{ $currentIcon }}"></i>
                    </div>
                    <div>
                        <div class="attr-identity-name">{{ $attribute->name }}</div>
                        <div class="attr-identity-id">ID #{{ $attribute->id }} &nbsp;·&nbsp;
                            {{ ucfirst($attribute->type) }}</div>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.attributes.update', $attribute->id) }}" class="save-form">
                @csrf
                @method('PUT')

                <div class="attr-edit-layout">

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
                                    <input type="text" name="name" class="field-input"
                                        value="{{ old('name', $attribute->name) }}" required>
                                </div>

                                <div class="field-group">
                                    <label class="field-label">Type <span class="req">*</span></label>
                                    <div class="type-grid">
                                        @foreach($types as $type)
                                            @php $icon = $typeIcons[$type] ?? 'fa-tag'; @endphp
                                            <input type="radio" name="type" id="type_{{ $type }}" value="{{ $type }}"
                                                class="type-option" {{ old('type', $attribute->type) == $type ? 'checked' : '' }} required>
                                            <label for="type_{{ $type }}">
                                                <span class="type-icon"><i class="fa {{ $icon }}"></i></span>
                                                <span class="type-name">{{ ucfirst(str_replace('_', ' ', $type)) }}</span>
                                            </label>
                                        @endforeach
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
                                        <option value="1" {{ old('has_values', $attribute->has_values) ? 'selected' : '' }}>Yes</option>
                                        <option value="0" {{ !old('has_values', $attribute->has_values) ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>

                                <div class="toggle-row">
                                    <div>
                                        <div class="toggle-label">Status</div>
                                        <div class="toggle-sub">Visible on products</div>
                                    </div>
                                    <select name="status" class="field-select-sm">
                                        <option value="1" {{ old('status', $attribute->status) ? 'selected' : '' }}>
                                            Active</option>
                                        <option value="0" {{ !old('status', $attribute->status) ? 'selected' : '' }}>
                                            Inactive</option>
                                    </select>
                                </div>

                                <div class="toggle-row">
                                    <div>
                                        <div class="toggle-label">Show in Navbar</div>
                                        <div class="toggle-sub">Display this attribute in the navbar menu</div>
                                    </div>
                                    <select name="show_in_navbar" class="field-select-sm">
                                        <option value="1" {{ old('show_in_navbar', $attribute->show_in_navbar) ? 'selected' : '' }}>
                                            Yes
                                        </option>
                                        <option value="0" {{ !old('show_in_navbar', $attribute->show_in_navbar) ? 'selected' : '' }}>
                                            No
                                        </option>
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
                                        Best for Size, Pack Size, Quantity etc.
                                    </div>

                                    <div style="margin-bottom:8px">
                                        <strong>Dropdown</strong> —
                                        Best for Material, Paper Type, Finish etc.
                                    </div>

                                    <div style="margin-bottom:8px">
                                        <strong>Image</strong> —
                                        Best for Design, Pattern or Style selection.
                                    </div>

                                    <div style="margin-bottom:8px">
                                        <strong>Colour Swatch</strong> —
                                        Best for Colour selection.
                                    </div>

                                    <div>
                                        <strong>Radio</strong> —
                                        Best for simple single-choice options.
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
                        <i class="fa fa-save"></i> Update Attribute
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