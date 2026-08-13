@include('admin.top-header')

<div class="main-section">
    @include('admin.header')

    <style>
        .cke_notifications_area,
        .cke_notification,
        .cke_notification_warning {
            display: none !important;
        }

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
            --red-bg: #fce8e8;
            --amber: #916a00;
            --amber-bg: #fff5cc;
            --radius-sm: 8px;
            --radius-md: 12px;
            --shadow-card: 0 1px 3px rgba(0, 0, 0, .08), 0 0 0 1px var(--border);
            --font: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        .product-create-page {
            background: var(--bg);
            padding: 24px 28px;
            min-height: 100vh;
            font-family: var(--font);
            color: var(--text-primary);
        }

        .product-create-page * {
            box-sizing: border-box;
        }

        /* ── Page header ────────────────────────────────────────── */
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

        /* ── Layout ─────────────────────────────────────────────── */
        .product-layout {
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 20px;
            align-items: start;
        }

        @media(max-width:960px) {
            .product-layout {
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
            display: flex;
            align-items: center;
            justify-content: space-between;
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

        .field-input[readonly] {
            background: var(--bg);
            color: var(--text-secondary);
            cursor: default;
        }

        .field-hint {
            font-size: 11.5px;
            color: var(--text-hint);
            margin-top: 4px;
        }

        /* ── Slug prefix ────────────────────────────────────────── */
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
            padding-left: 68px !important;
        }

        /* ── Pricing row ────────────────────────────────────────── */
        .pricing-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 12px;
        }

        @media(max-width:640px) {
            .pricing-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        .final-price-box {
            background: var(--accent-light);
            border: 1px solid #c7cdf5;
            border-radius: var(--radius-sm);
            padding: 14px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 16px;
        }

        .final-price-box .label {
            font-size: 12px;
            font-weight: 600;
            color: var(--accent);
            text-transform: uppercase;
            letter-spacing: .04em;
        }

        .final-price-box .value {
            font-size: 22px;
            font-weight: 700;
            color: var(--accent);
        }

        /* ── Inventory grid ─────────────────────────────────────── */
        .inv-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        /* ── Checkbox toggles ───────────────────────────────────── */
        .check-toggle {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            cursor: pointer;
            transition: all .15s;
            background: var(--surface);
            margin-bottom: 8px;
        }

        .check-toggle:hover {
            border-color: var(--accent);
            background: var(--accent-light);
        }

        .check-toggle input[type="checkbox"] {
            accent-color: var(--accent);
            width: 15px;
            height: 15px;
            flex-shrink: 0;
            cursor: pointer;
            margin: 0;
        }

        .check-toggle input[type="checkbox"]:checked~span {
            font-weight: 600;
            color: var(--accent);
        }

        .check-toggle:has(input:checked) {
            border-color: var(--accent);
            background: var(--accent-light);
        }

        .check-toggle span {
            font-size: 13px;
            color: var(--text-primary);
        }

        /* ── Image / video upload ───────────────────────────────── */
        .file-upload-area {
            border: 2px dashed var(--border);
            border-radius: var(--radius-md);
            padding: 24px 20px;
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
            font-size: 24px;
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

        /* Thumb previews */
        #previewContainer,
        #videoPreviewContainer {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 14px;
        }

        .thumb-box {
            position: relative;
        }

        .thumb-box img {
            width: 76px;
            height: 76px;
            border-radius: var(--radius-sm);
            object-fit: cover;
            border: 1.5px solid var(--border);
            display: block;
        }

        .thumb-box video {
            width: 120px;
            height: 76px;
            border-radius: var(--radius-sm);
            object-fit: cover;
            border: 1.5px solid var(--border);
            display: block;
            background: #000;
        }

        .remove-btn {
            position: absolute;
            top: -6px;
            right: -6px;
            background: var(--red);
            color: #fff;
            border: 2px solid #fff;
            border-radius: 50%;
            font-size: 11px;
            width: 20px;
            height: 20px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
            padding: 0;
        }

        .thumb-default {
            text-align: center;
            margin-top: 4px;
            font-size: 11px;
            color: var(--text-hint);
        }

        .thumb-default input {
            accent-color: var(--accent);
        }

        /* ── Settings toggle rows ───────────────────────────────── */
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

        /* ── Attributes (dynamic) ───────────────────────────────── */
        #attribute-container .section-card-body label {
            font-size: 13px;
            font-weight: 500;
            color: var(--text-primary);
        }

        #attribute-container .check-toggle {
            margin-bottom: 6px;
        }

        .attr-badge {
            display: inline-block;
            font-size: 10px;
            font-weight: 650;
            letter-spacing: .03em;
            text-transform: uppercase;
            padding: 2px 7px;
            border-radius: 20px;
            background: var(--accent-light);
            color: var(--accent);
            margin-left: 6px;
        }

        /* ── Attribute accordion ─────────────────────────────────── */
        .attr-accordion {
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            margin-bottom: 10px;
            overflow: hidden;
        }

        .attr-accordion:last-child {
            margin-bottom: 0;
        }

        .attr-accordion-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 14px;
            cursor: pointer;
            background: #fafafa;
            transition: background .15s;
            user-select: none;
        }

        .attr-accordion-header:hover {
            background: var(--accent-light);
        }

        .attr-accordion.open .attr-accordion-header {
            background: var(--accent-light);
            border-bottom: 1px solid var(--border);
        }

        .attr-accordion-title {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .attr-accordion-meta {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .attr-selected-count {
            font-size: 11px;
            font-weight: 650;
            color: var(--accent);
            background: var(--accent-light);
            border: 1px solid #c7cdf5;
            padding: 1px 8px;
            border-radius: 20px;
            display: none;
        }

        .attr-selected-count.show {
            display: inline-block;
        }

        .attr-accordion-chevron {
            font-size: 12px;
            color: var(--text-hint);
            transition: transform .18s;
        }

        .attr-accordion.open .attr-accordion-chevron {
            transform: rotate(180deg);
        }

        .attr-accordion-body {
            max-height: 0;
            overflow: hidden;
            transition: max-height .2s ease;
            padding: 0 14px;
            background: var(--surface);
        }

        .attr-accordion.open .attr-accordion-body {
            padding: 14px;
        }

        .attr-accordion-body .check-toggle {
            margin-bottom: 6px;
        }

        .attr-accordion-body .check-toggle:last-child {
            margin-bottom: 0;
        }

        /* ── Variants table (dynamic) — also reused for Addon Options ── */
        .variants-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        .variants-table thead th {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: .05em;
            text-transform: uppercase;
            color: var(--text-hint);
            padding: 10px 12px;
            border-bottom: 1px solid var(--border);
            background: #fafafa;
            white-space: nowrap;
            text-align: left;
        }

        .variants-table tbody tr {
            border-bottom: 1px solid var(--border);
        }

        .variants-table tbody tr:last-child {
            border-bottom: none;
        }

        .variants-table tbody td {
            padding: 10px 12px;
            vertical-align: middle;
        }

        .variants-table .field-input {
            height: 34px;
            font-size: 13px;
        }

        .variants-table .field-select {
            height: 34px;
            font-size: 13px;
        }

        .variant-name-cell {
            font-weight: 600;
            font-size: 13px;
            color: var(--text-primary);
            white-space: nowrap;
        }

        .variant-note {
            font-size: 11.5px;
            color: var(--text-hint);
            padding: 10px 20px;
            border-top: 1px solid var(--border);
            background: #fafafa;
        }

        /* ── Content tabs (Description / Fabric Care / Shipping & Delivery / Exchange Policy / Customization) ── */
        .content-tabs {
            display: flex;
            flex-wrap: wrap;
            gap: 2px;
            padding: 10px 20px 0;
            border-bottom: 1px solid var(--border);
            background: #fafafa;
        }

        .content-tab-btn {
            background: transparent;
            border: none;
            border-bottom: 2px solid transparent;
            padding: 9px 12px;
            font-size: 12.5px;
            font-weight: 600;
            color: var(--text-secondary);
            cursor: pointer;
            font-family: var(--font);
            margin-bottom: -1px;
            white-space: nowrap;
        }

        .content-tab-btn:hover {
            color: var(--accent);
        }

        .content-tab-btn.active {
            color: var(--accent);
            border-bottom-color: var(--accent);
        }

        .content-tab-panel {
            display: none;
        }

        .content-tab-panel.active {
            display: block;
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
            padding: 9px 20px;
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
            padding: 9px 20px;
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

        .btn-outline-accent {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--accent-light);
            color: var(--accent) !important;
            border: 1.5px solid #c7cdf5;
            border-radius: var(--radius-sm);
            padding: 8px 16px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none !important;
            font-family: var(--font);
            transition: all .15s;
        }

        .btn-outline-accent:hover {
            background: var(--accent);
            color: #fff !important;
            border-color: var(--accent);
        }

        /* ── Action bar ─────────────────────────────────────────── */
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

        /* CKEditor override */
        .cke {
            border-radius: var(--radius-sm) !important;
            border: 1px solid var(--border) !important;
            overflow: hidden;
        }

        .cke_top {
            background: #fafafa !important;
            border-bottom: 1px solid var(--border) !important;
        }

        @media(max-width:768px) {
            .product-create-page {
                padding: 16px;
            }

            .pricing-grid {
                grid-template-columns: 1fr 1fr;
            }

            .inv-grid {
                grid-template-columns: 1fr;
            }
        }

        .variant-row-excluded {
            opacity: 0.55;
            background: #fafafa;
        }

        .variant-row-excluded input,
        .variant-row-excluded select {
            background: #f1f2f4;
        }

        /* ── Tag input (Search Suggestions) ─────────────────────────── */
        .tag-input-wrap {
            position: relative;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 8px 10px;
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            align-items: center;
            background: var(--surface);
            transition: border-color .15s, box-shadow .15s;
        }

        .tag-input-wrap:focus-within {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(48, 61, 137, .12);
        }

        .tag-list {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .tag-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--accent-light);
            color: var(--accent);
            border: 1px solid #c7cdf5;
            border-radius: 20px;
            padding: 4px 6px 4px 12px;
            font-size: 12.5px;
            font-weight: 600;
            white-space: nowrap;
        }

        .tag-remove {
            background: transparent;
            border: none;
            color: var(--accent);
            cursor: pointer;
            font-size: 14px;
            line-height: 1;
            padding: 2px 4px;
            border-radius: 50%;
        }

        .tag-remove:hover {
            background: var(--accent);
            color: #fff;
        }

        .tag-input-field {
            flex: 1;
            min-width: 140px;
            border: none;
            outline: none;
            font-size: 13.5px;
            font-family: var(--font);
            padding: 4px 0;
            background: transparent;
        }

        .tag-suggestions-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            margin-top: 4px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            box-shadow: 0 4px 14px rgba(0, 0, 0, .1);
            max-height: 200px;
            overflow-y: auto;
            z-index: 50;
            display: none;
        }

        .tag-suggestion-item {
            padding: 8px 12px;
            font-size: 13px;
            cursor: pointer;
        }

        .tag-suggestion-item:hover {
            background: var(--accent-light);
            color: var(--accent);
        }
    </style>

    <div class="app-content content container-fluid">
        <div class="product-create-page">

            <!-- Page header -->
            <div class="page-header">
                <div>
                    <h1>Add Product</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        <a href="{{ route('admin.products.index') }}">Products</a>
                        <span>›</span>
                        Add Product
                    </div>
                </div>
            </div>

            {{-- Validation errors summary --}}
            @if ($errors->any())
                <div class="section-card" style="border-color:#f3b9b9;">
                    <div class="section-card-body" style="padding:14px 20px;">
                        <strong style="color:var(--red);font-size:13px;">Please fix the following:</strong>
                        <ul style="margin:8px 0 0 18px; padding:0; font-size:13px; color:var(--red);">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data"
                class="save-form">
                @csrf

                <div class="product-layout">

                    <!-- ══════════ LEFT COLUMN ══════════ -->
                    <div>

                        <!-- Basic Info -->
                        <div class="section-card">
                            <div class="section-card-header">
                                <h5>Basic Information</h5>
                            </div>
                            <div class="section-card-body">

                                <div class="field-group">
                                    <label class="field-label">Category <span class="req">*</span></label>
                                    <select name="category_id" id="category_id" class="field-select" required>
                                        <option value="">— Select Category —</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="field-group" id="subcategory-wrapper" style="display:none;">
                                    <label class="field-label">Sub Category</label>
                                    <select name="subcategory_id" id="subcategory_id" class="field-select">
                                        <option value="">Select Sub Category</option>
                                    </select>
                                </div>

                                <div class="field-group">
                                    <label class="field-label">Product Name <span class="req">*</span></label>
                                    <input type="text" name="name" id="product_name" class="field-input" required
                                        value="{{ old('name') }}" placeholder="e.g. Hand-Knotted Wool Rug">
                                </div>

                                <div class="field-group">
                                    <label class="field-label">Slug</label>
                                    <div class="slug-wrap">
                                        <span class="slug-prefix">/p/</span>
                                        <input type="text" name="slug" id="slug" class="field-input slug-input"
                                            value="{{ old('slug') }}" placeholder="auto-generated">
                                    </div>
                                    <div class="field-hint">Optional — auto-generated from product name if left blank
                                    </div>
                                </div>

                                <div class="field-group">
                                    <label class="field-label">Short Description</label>
                                    <textarea name="short_description" class="field-textarea" rows="3"
                                        placeholder="Brief summary shown on listing pages…">{{ old('short_description') }}</textarea>
                                </div>

                            </div>
                        </div>

                        <!-- Content -->
                        <div class="section-card">
                            <div class="section-card-header">
                                <h5>Content</h5>
                            </div>

                            <div class="content-tabs">
                                <button type="button" class="content-tab-btn active"
                                    data-tab="description">Description</button>
                                <button type="button" class="content-tab-btn" data-tab="fabric_care">Fabric
                                    Care</button>
                                <button type="button" class="content-tab-btn" data-tab="shipping_delivery">Shipping
                                    &amp; Delivery</button>
                                <button type="button" class="content-tab-btn" data-tab="exchange_policy">Exchange
                                    Policy</button>
                                <button type="button" class="content-tab-btn"
                                    data-tab="customization_assistance">Customization/Assistance</button>
                            </div>

                            <div class="section-card-body">

                                <div class="content-tab-panel active" data-panel="description">
                                    <textarea name="description" id="description"
                                        class="field-textarea">{{ old('description') }}</textarea>
                                </div>

                                <div class="content-tab-panel" data-panel="fabric_care">
                                    <textarea name="fabric_care" id="fabric_care"
                                        class="field-textarea">{{ old('fabric_care') }}</textarea>
                                </div>

                                <div class="content-tab-panel" data-panel="shipping_delivery">
                                    <textarea name="shipping_delivery" id="shipping_delivery"
                                        class="field-textarea">{{ old('shipping_delivery') }}</textarea>
                                </div>

                                <div class="content-tab-panel" data-panel="exchange_policy">
                                    <textarea name="exchange_policy" id="exchange_policy"
                                        class="field-textarea">{{ old('exchange_policy') }}</textarea>
                                </div>

                                <div class="content-tab-panel" data-panel="customization_assistance">
                                    <textarea name="customization_assistance" id="customization_assistance"
                                        class="field-textarea">{{ old('customization_assistance') }}</textarea>
                                </div>

                            </div>
                        </div>

                        <!-- Pricing -->
                        <div class="section-card">
                            <div class="section-card-header">
                                <h5>Pricing</h5>
                            </div>
                            <div class="section-card-body">

                                <div class="field-hint" style="margin-bottom:14px;">MRP and Discount are optional. Leave
                                    blank if not applicable — Final Price will simply equal MRP (or 0 if MRP is also
                                    blank). If none of the selected variant attributes are marked Price Dependent, this
                                    product-level price is what customers pay regardless of variant chosen.</div>

                                <div class="pricing-grid">
                                    <div class="field-group" style="margin:0">
                                        <label class="field-label">MRP</label>
                                        <input type="number" step="0.01" name="mrp" id="mrp" class="field-input"
                                            value="{{ old('mrp') }}" placeholder="0.00">
                                    </div>
                                    <div class="field-group" style="margin:0">
                                        <label class="field-label">Discount Type</label>
                                        <select name="discount_type" id="discount_type" class="field-select">
                                            <option value="amount" {{ old('discount_type') == 'amount' ? 'selected' : '' }}>Amount (₹)</option>
                                            <option value="percentage" {{ old('discount_type') == 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                                        </select>
                                    </div>
                                    <div class="field-group" style="margin:0">
                                        <label class="field-label">Discount</label>
                                        <input type="number" step="0.01" name="discount" id="discount"
                                            class="field-input" value="{{ old('discount') }}" placeholder="0">
                                    </div>
                                </div>

                                <div class="final-price-box">
                                    <span class="label">Final Price</span>
                                    <span class="value" id="price-display">₹0.00</span>
                                    <input type="hidden" name="price" id="price" value="0">
                                </div>

                            </div>
                        </div>

                        <!-- Media -->
                        <div class="section-card">
                            <div class="section-card-header">
                                <h5>Media</h5>
                            </div>
                            <div class="section-card-body">

                                <div class="field-group" style="margin:0 0 20px">
                                    <label class="field-label">Images</label>
                                    <div class="file-upload-area">
                                        <input type="file" id="images" name="images[]" multiple accept="image/*">
                                        <div class="upload-icon"><i class="fa fa-cloud-upload"></i></div>
                                        <p>Click or drag images here</p>
                                        <small>PNG, JPG, WEBP — max 6 images, 2 MB each</small>
                                    </div>
                                    <div id="previewContainer"></div>
                                </div>

                                <div class="field-group" style="margin:0">
                                    <label class="field-label">Video</label>
                                    <div class="file-upload-area">
                                        <input type="file" id="videos" name="videos[]" multiple accept="video/*">
                                        <div class="upload-icon"><i class="fa fa-video-camera"></i></div>
                                        <p>Click or drag video here</p>
                                        <small>MP4, WEBM — max 3 videos, 20 MB each</small>
                                    </div>
                                    <div id="videoPreviewContainer"></div>
                                </div>

                            </div>
                        </div>

                        <!-- Addon Options -->
                        <div class="section-card">
                            <div class="section-card-header">
                                <h5>Addon Options</h5>
                                <button type="button" class="btn-secondary-dash" id="add-addon-row"
                                    style="padding:5px 12px;font-size:11.5px;">
                                    <i class="fa fa-plus"></i> Add Option
                                </button>
                            </div>
                            <div class="section-card-body" style="padding:0;overflow-x:auto">
                                <table class="variants-table" id="addon-table" style="display:none">
                                    <thead>
                                        <tr>
                                            <th>Detail</th>
                                            <th>Price</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="addon-table-body"></tbody>
                                </table>
                                <div class="field-hint" id="addon-empty-hint" style="padding:16px 20px">
                                    No addon options yet. An addon is an optional extra — a detail/label plus its own
                                    price — that a customer can choose to add alongside this product.
                                </div>
                            </div>
                        </div>

                        <!-- Attributes (dynamic) -->
                        <div id="attribute-container"></div>

                        <!-- Generate Variants button -->
                        <div class="mb-3" id="variant-btn-wrapper" style="display:none;">
                            <button type="button" id="generate-variants" class="btn-outline-accent">
                                <i class="fa fa-cogs"></i> Generate Variants
                            </button>
                        </div>

                        <!-- Variants (dynamic) -->
                        <div id="variant-container"></div>

                    </div>

                    <!-- ══════════ RIGHT COLUMN ══════════ -->
                    <div>

                        <!-- Status -->
                        <div class="section-card">
                            <div class="section-card-header">
                                <h5>Status</h5>
                            </div>
                            <div class="section-card-body" style="padding:16px 20px">
                                <div class="toggle-row" style="padding:0;border:none">
                                    <div>
                                        <div class="toggle-label">Visibility</div>
                                        <div class="toggle-sub">Visible to customers</div>
                                    </div>
                                    <select name="status" class="field-select-sm">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Inventory -->
                        <div class="section-card">
                            <div class="section-card-header">
                                <h5>Inventory</h5>
                            </div>
                            <div class="section-card-body">

                                <div class="inv-grid">
                                    <div class="field-group">
                                        <label class="field-label">SKU</label>
                                        <input type="text" name="sku" class="field-input" value="{{ old('sku') }}"
                                            placeholder="SKU-001">
                                    </div>
                                    <div class="field-group">
                                        <label class="field-label">Product Code</label>
                                        <input type="text" name="product_code" class="field-input"
                                            value="{{ old('product_code') }}">
                                    </div>
                                    <div class="field-group">
                                        <label class="field-label">Stock</label>
                                        <input type="number" name="stock" class="field-input" value="{{ old('stock') }}"
                                            placeholder="0">
                                    </div>
                                    <div class="field-group">
                                        <label class="field-label">Min Qty</label>
                                        <input type="number" name="min_qty" class="field-input"
                                            value="{{ old('min_qty') }}" placeholder="1">
                                    </div>
                                </div>

                                <div class="field-group">
                                    <label class="field-label">Delivery Time</label>
                                    <input type="text" name="delivery_time" class="field-input"
                                        value="{{ old('delivery_time') }}" placeholder="e.g. 3–5 business days">
                                </div>

                                <div style="margin-top:4px">
                                    <label class="check-toggle">
                                        <input type="checkbox" name="quality" {{ old('quality') ? 'checked' : '' }}>
                                        <span>Quality Assurance</span>
                                    </label>
                                    <label class="check-toggle">
                                        <input type="checkbox" name="pan_india" {{ old('pan_india') ? 'checked' : '' }}>
                                        <span>PAN India Delivery</span>
                                    </label>
                                </div>

                            </div>
                        </div>

                        <!-- Occasions -->
                        <div class="section-card">
                            <div class="section-card-header">
                                <h5>Occasions</h5>
                            </div>
                            <div class="section-card-body">
                                @foreach($occasions as $o)
                                    <label class="check-toggle">
                                        <input type="checkbox" name="occasions[]" value="{{ $o->id }}" {{ in_array($o->id, old('occasions', [])) ? 'checked' : '' }}>
                                        <span>{{ $o->title }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Collections -->
                        <div class="section-card">
                            <div class="section-card-header">
                                <h5>Collections</h5>
                            </div>
                            <div class="section-card-body">
                                @foreach($collections as $collection)
                                    <label class="check-toggle">
                                        <input type="checkbox" name="collections[]" value="{{ $collection->id }}" {{ in_array($collection->id, old('collections', [])) ? 'checked' : '' }}>
                                        <span>{{ $collection->name }}</span>
                                    </label>
                                @endforeach
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
                                        value="{{ old('meta_title') }}">
                                </div>
                                <div class="field-group">
                                    <label class="field-label">Meta Description</label>
                                    <textarea name="meta_description"
                                        class="field-textarea">{{ old('meta_description') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Search Suggestions -->
                        <div class="section-card">
                            <div class="section-card-header">
                                <h5>Search Suggestions</h5>
                            </div>
                            <div class="section-card-body">
                                <div class="field-group" style="margin:0">
                                    <label class="field-label">Enter Suggestions</label>
                                    <div class="tag-input-wrap" id="suggestionsWrap">
                                        <div class="tag-list" id="suggestionsTagList"></div>
                                        <input type="text" id="suggestionsInput" class="tag-input-field"
                                            placeholder="Type a keyword and press space…" autocomplete="off">
                                        <div class="tag-suggestions-dropdown" id="suggestionsDropdown"></div>
                                    </div>
                                    <div id="suggestionsHidden"></div>
                                    <div class="field-hint">Press spacebar after typing a keyword to add it as a tag.
                                        These power the header search suggestions.</div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Action bar -->
                <div class="action-bar">
                    <a href="{{ route('admin.products.index') }}" class="btn-secondary-dash">Cancel</a>
                    <button type="submit" class="btn-primary-dash save-btn">
                        <i class="fa fa-save"></i> Save Product
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

<script>
    /* ── CKEditor ───────────────────────────────────────────────── */
    /* Content section now has 5 independently-named fields, each its own
     * editor, switched between via tabs (see .content-tab-* handler below).
     * All 5 are initialized up front so their values are always present
     * in the POST regardless of which tab was last open. */
    CKEDITOR.config.versionCheck = false;
    CKEDITOR.replace('description');
    CKEDITOR.replace('fabric_care');
    CKEDITOR.replace('shipping_delivery');
    CKEDITOR.replace('exchange_policy');
    CKEDITOR.replace('customization_assistance');

    let initialSuggestions = [];

    /* ── Content tabs ────────────────────────────────────────────── */
    $(document).on('click', '.content-tab-btn', function () {
        let tab = $(this).data('tab');

        $('.content-tab-btn').removeClass('active');
        $(this).addClass('active');

        $('.content-tab-panel').removeClass('active');
        $('.content-tab-panel[data-panel="' + tab + '"]').addClass('active');

        // A CKEditor instance built while its panel was hidden can render at
        // 0 height — force a resize the first time its tab is opened.
        let editor = CKEDITOR.instances[tab];
        if (editor) {
            setTimeout(function () { editor.resize('100%', 200); }, 0);
        }
    });

    /* ── Slug auto-generate ─────────────────────────────────────── */
    $(document).on('keyup', '#product_name', function () {
        let slug = $(this).val().toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
        $('#slug').val(slug);
    });

    /* ── Pricing calculator ─────────────────────────────────────── */
    function calcPrice() {
        let m = +$('#mrp').val() || 0;
        let d = +$('#discount').val() || 0;
        let t = $('#discount_type').val();
        let p = t === 'percentage' ? m - (m * d / 100) : m - d;
        if (p < 0) p = 0;
        $('#price').val(p.toFixed(2));
        $('#price-display').text('₹' + p.toFixed(2));
    }
    $('#mrp, #discount, #discount_type').on('keyup change', calcPrice);
    calcPrice(); // ✅ run once on load — keeps hidden #price populated even if MRP/Discount are never touched

    /* ── Submit spinner ─────────────────────────────────────────── */
    $(document).on('submit', '.save-form', function () {
        let btn = $(this).find('.save-btn');
        btn.prop('disabled', true);
        btn.html('<i class="fa fa-spinner fa-spin"></i> Processing...');
    });

    /* ── Image preview ──────────────────────────────────────────── */
    let selectedFiles = [];

    $('#images').on('change', function (e) {
        let files = Array.from(e.target.files);
        if ((selectedFiles.length + files.length) > 6) {
            alert('Maximum 6 images allowed');
            return;
        }
        files.forEach(file => selectedFiles.push(file));
        renderPreview();
    });

    function renderPreview() {
        $('#previewContainer').html('');
        selectedFiles.forEach((file, index) => {
            let reader = new FileReader();
            reader.onload = function (e) {
                let html = `
                <div class="thumb-box">
                    <img src="${e.target.result}" alt="Preview">
                    <button type="button" class="remove-btn" onclick="removeImage(${index})">×</button>
                    <div class="thumb-default">
                        <input type="radio" name="default_image" value="${index}" ${index === 0 ? 'checked' : ''}> Default
                    </div>
                </div>`;
                $('#previewContainer').append(html);
            };
            reader.readAsDataURL(file);
        });
    }

    function removeImage(index) {
        selectedFiles.splice(index, 1);
        renderPreview();
    }

    /* ── Video preview ───────────────────────────────────────────── */
    let selectedVideos = [];

    $('#videos').on('change', function (e) {
        let files = Array.from(e.target.files);
        if ((selectedVideos.length + files.length) > 3) {
            alert('Maximum 3 videos allowed');
            return;
        }
        files.forEach(file => selectedVideos.push(file));
        renderVideoPreview();
    });

    function renderVideoPreview() {
        $('#videoPreviewContainer').html('');
        selectedVideos.forEach((file, index) => {
            let url = URL.createObjectURL(file);
            let html = `
            <div class="thumb-box">
                <video src="${url}" muted></video>
                <button type="button" class="remove-btn" onclick="removeVideo(${index})">×</button>
            </div>`;
            $('#videoPreviewContainer').append(html);
        });
    }

    function removeVideo(index) {
        selectedVideos.splice(index, 1);
        renderVideoPreview();
    }

    $('form').on('submit', function () {
        let dataTransfer = new DataTransfer();
        selectedFiles.forEach(file => dataTransfer.items.add(file));
        document.getElementById('images').files = dataTransfer.files;

        let videoTransfer = new DataTransfer();
        selectedVideos.forEach(file => videoTransfer.items.add(file));
        document.getElementById('videos').files = videoTransfer.files;

        $('.variant-image-input').each(function () {
            const prefix = $(this).data('prefix');
            const dt = new DataTransfer();
            (variantImageFiles[prefix] || []).forEach(file => dt.items.add(file));
            this.files = dt.files;
            this.name = prefix + '[images][]';
        });

    });


    /* ── Variant image uploads (multiple, per variant row) ──────────
 * Keyed by the row's own prefix string (e.g. "variants_image[2]")
 * since that's already unique per row. Posted as {prefix}[images][].
 */
    let variantImageFiles = {};

    $(document).on('change', '.variant-image-input', function (e) {
        const prefix = $(this).data('prefix');
        if (!variantImageFiles[prefix]) variantImageFiles[prefix] = [];

        const files = Array.from(e.target.files);
        if ((variantImageFiles[prefix].length + files.length) > 6) {
            alert('Maximum 6 images allowed per variant');
            return;
        }

        files.forEach(file => variantImageFiles[prefix].push(file));
        renderVariantImagePreview(prefix);
    });

    function renderVariantImagePreview(prefix) {
        const $container = $('.variant-image-preview[data-prefix="' + prefix + '"]');
        $container.html('');

        (variantImageFiles[prefix] || []).forEach(function (file, index) {
            const reader = new FileReader();
            reader.onload = function (e) {
                $container.append(`
                <div class="thumb-box">
                    <img src="${e.target.result}" style="width:50px;height:50px;">
                    <button type="button" class="remove-btn" onclick="removeVariantImage('${prefix}', ${index})">×</button>
                </div>
            `);
            };
            reader.readAsDataURL(file);
        });
    }

    function removeVariantImage(prefix, index) {
        variantImageFiles[prefix].splice(index, 1);
        renderVariantImagePreview(prefix);
    }


    /* ── Addon Options (dynamic rows) ──────────────────────────────
     * Posted as addons[index][detail] / addons[index][price] — an
     * independent array the controller can loop over to create/sync
     * a product_addons (or similar) table. */
    let addonIndex = 0;

    $(document).on('click', '#add-addon-row', function () {
        let row = `
        <tr id="addon-row-${addonIndex}">
            <td><input type="text" name="addons[${addonIndex}][detail]" class="field-input" placeholder="e.g. Gift Wrapping"></td>
            <td><input type="number" step="0.01" name="addons[${addonIndex}][price]" class="field-input" placeholder="0.00"></td>
            <td><button type="button" class="remove-btn" style="position:static" onclick="removeAddonRow(${addonIndex})">×</button></td>
        </tr>`;
        $('#addon-table-body').append(row);
        addonIndex++;
        toggleAddonTable();
    });

    function removeAddonRow(index) {
        $('#addon-row-' + index).remove();
        toggleAddonTable();
    }

    function toggleAddonTable() {
        let hasRows = $('#addon-table-body tr').length > 0;
        $('#addon-table').toggle(hasRows);
        $('#addon-empty-hint').toggle(!hasRows);
    }

    /* ── Category → subcategories & attributes ──────────────────── */
    $('#category_id').on('change', function () {
        let categoryId = $(this).val();
        $('#variant-container').html('');
        $('#variant-btn-wrapper').hide();
        $('#subcategory_id').html('<option value="">Loading...</option>');

        if (!categoryId) {
            $('#subcategory-wrapper').hide();
            $('#attribute-container').html('');
            return;
        }

        loadAttributes(categoryId);

        window.subCategoryUrl = "{{ url('admin/products/subcategories') }}";
        $.get(window.subCategoryUrl + '/' + categoryId, function (response) {
            if (response.length > 0) {
                let html = '<option value="">Select Sub Category</option>';
                $.each(response, function (i, item) {
                    html += `<option value="${item.id}">${item.name}</option>`;
                });
                $('#subcategory_id').html(html);
                $('#subcategory-wrapper').show();
            } else {
                $('#subcategory-wrapper').hide();
            }
        });
    });

    /* ── Load attributes ────────────────────────────────────────── */
    /*
     * Every category attribute is rendered here — is_selectable is a
     * FRONTEND-ONLY flag (customer-facing product page) and has no bearing
     * on what the admin sees while creating a product, so it is NOT filtered
     * out in this form.
     *
     * Each attribute value checkbox carries its category-attribute's
     * dependency flags as data-* attributes:
     *   data-variant           → used_for_variant (participates in variant generation at all)
     *   data-price-dependent   → selecting this value changes variant price
     *   data-image-dependent   → selecting this value changes variant image
     *   data-stock-dependent   → selecting this value tracks its own stock
     *   data-sku-dependent     → selecting this value changes variant SKU
     *
     * These are read by the Generate Variants handler below to build one
     * independent variant table PER dependency type.
     */
    function loadAttributes(categoryId) {
        $('#attribute-container').html('');
        window.attributeUrl = "{{ url('admin/products/category-attributes') }}";

        $.get(window.attributeUrl + '/' + categoryId, function (response) {
            if (response.length > 0) {
                let html = `
                <div class="section-card" style="margin-bottom:16px">
                    <div class="section-card-header">
                        <h5>Attributes</h5>
                        <div style="display:flex;gap:6px;">
                            <button type="button" class="btn-secondary-dash" id="attr-expand-all" style="padding:5px 12px;font-size:11.5px;">Expand All</button>
                            <button type="button" class="btn-secondary-dash" id="attr-collapse-all" style="padding:5px 12px;font-size:11.5px;">Collapse All</button>
                        </div>
                    </div>
                    <div class="section-card-body">`;

                response.forEach(function (item, i) {
                    let isVariant = item.used_for_variant ? 1 : 0;
                    let valueCount = (item.attribute.has_values && item.attribute.values) ? item.attribute.values.length : 0;

                    html += `
                    <div class="attr-accordion" data-attr-index="${i}">
                        <div class="attr-accordion-header">
                            <div class="attr-accordion-title">
                                ${item.attribute.name}${isVariant ? '<span class="attr-badge">Variant</span>' : ''}
                            </div>
                            <div class="attr-accordion-meta">
                                <span class="attr-selected-count">0 selected</span>
                                <i class="fa fa-chevron-down attr-accordion-chevron"></i>
                            </div>
                        </div>
                        <div class="attr-accordion-body">`;

                    if (valueCount > 0) {
                        item.attribute.values.forEach(function (value) {
                            html += `
                            <label class="check-toggle">
                                <input type="checkbox"
                                    class="attribute-value"
                                    data-attribute-id="${item.attribute.id}"
                                    data-attribute-name="${item.attribute.name}"
                                    data-value-name="${value.value}"
                                    data-variant="${isVariant}"
                                    data-price-dependent="${item.price_dependent ? 1 : 0}"
                                    data-image-dependent="${item.image_dependent ? 1 : 0}"
                                    data-stock-dependent="${item.stock_dependent ? 1 : 0}"
                                    data-sku-dependent="${item.sku_dependent ? 1 : 0}"
                                    name="attribute_values[${item.attribute.id}][]"
                                    value="${value.id}">
                                <span>${value.value}</span>
                            </label>`;
                        });
                    } else {
                        html += `<div class="field-hint">No values configured for this attribute.</div>`;
                    }

                    html += `</div></div>`;
                });

                html += `</div></div>`;
                $('#attribute-container').html(html);

                let hasVariantAttribute = response.some(item => item.used_for_variant);
                $('#variant-btn-wrapper').toggle(hasVariantAttribute);

                // Open the first attribute by default so the panel isn't fully collapsed on load.
                let $first = $('.attr-accordion').first();
                $first.addClass('open');
                $first.find('.attr-accordion-body').css('max-height', $first.find('.attr-accordion-body')[0].scrollHeight + 'px');

                // Initialize the "N selected" badges (0 for a fresh load).
                $('.attr-accordion').each(function () {
                    refreshAttrSelectedCount($(this));
                });
            } else {
                $('#attribute-container').html('');
                $('#variant-btn-wrapper').hide();
            }
        });
    }

    /* ── Expand all / Collapse all ──────────────────────────────── */
    $(document).on('click', '#attr-expand-all', function () {
        $('.attr-accordion').each(function () {
            $(this).addClass('open');
            let $body = $(this).find('.attr-accordion-body');
            $body.css('max-height', $body[0].scrollHeight + 'px');
        });
    });

    $(document).on('click', '#attr-collapse-all', function () {
        $('.attr-accordion').removeClass('open');
        $('.attr-accordion-body').css('max-height', 0);
    });

    /* ── Attribute accordion toggle ─────────────────────────────── */
    $(document).on('click', '.attr-accordion-header', function () {
        let $accordion = $(this).closest('.attr-accordion');
        let $body = $accordion.find('.attr-accordion-body');

        $accordion.toggleClass('open');

        if ($accordion.hasClass('open')) {
            $body.css('max-height', $body[0].scrollHeight + 'px');
        } else {
            $body.css('max-height', 0);
        }
    });

    /* ── Keep "N selected" badge live + auto-expand accordions that already have a selection restored (e.g. old()) ── */
    function refreshAttrSelectedCount($accordion) {
        let count = $accordion.find('.attribute-value:checked').length;
        let $badge = $accordion.find('.attr-selected-count');
        $badge.text(count + ' selected').toggleClass('show', count > 0);
    }

    $(document).on('change', '.attribute-value', function () {
        refreshAttrSelectedCount($(this).closest('.attr-accordion'));
    });

    /* recalculates max-height for an already-open accordion after its content changes size */
    function reflowOpenAccordion($accordion) {
        if ($accordion.hasClass('open')) {
            $accordion.find('.attr-accordion-body').css('max-height', $accordion.find('.attr-accordion-body')[0].scrollHeight + 'px');
        }
    }

    /* ── Generate variants (type-aware, matches controller's 4 independent arrays) ── */
    /*
     * The controller (ProductController@store / createVariantsForType) reads
     * FOUR separate arrays from the request: variants_price, variants_image,
     * variants_stock, variants_sku — each an independent set of combinations
     * built ONLY from attribute values whose category-attribute has that
     * specific *_dependent flag turned on.
     *
     * So instead of one combined table, we build up to 4 separate tables here,
     * one per type, each posted under its matching array name.
     */
    $(document).on('click', '#generate-variants', function () {
        const types = ['price', 'image', 'stock', 'sku'];
        let html = '';
        let anyGenerated = false;

        types.forEach(function (type) {
            let attributeGroups = {};

            $('.attribute-value:checked').each(function () {
                if ($(this).data('variant') != 1) return;
                if ($(this).data(type + '-dependent') != 1) return;

                let attributeId = $(this).data('attribute-id');
                if (!attributeGroups[attributeId]) attributeGroups[attributeId] = [];
                attributeGroups[attributeId].push({ id: $(this).val(), name: $(this).data('value-name') });
            });

            let groups = Object.values(attributeGroups);
            if (groups.length === 0) return; // no checked attribute is dependent for this type

            let combinations = cartesian(groups);
            html += renderVariantTable(type, combinations);
            anyGenerated = true;
        });

        if (!anyGenerated) {
            alert('Please select at least one value from an attribute marked Price / Image / Stock / SKU Dependent.');
            return;
        }

        $('#variant-container').html(html);
    });

    function cartesian(arr) {
        if (arr.length === 1) return arr[0].map(item => [item]);
        return arr.reduce(function (a, b) {
            return a.flatMap(function (d) {
                return b.map(function (e) { return [].concat(d, e); });
            });
        });
    }

    /*
     * Renders ONE independent table for a single dependency type.
     * Field names use variants_{type}[index][...] to match the controller's
     * createVariantsForType() / syncVariantsForType(), which read
     * $request->variants_price / variants_image / variants_stock / variants_sku
     * as four separate, independent arrays.
     *
     *   - Variant name column always shown
     *   - price  → MRP / Discount Type / Discount / Final Price
     *   - image  → file upload
     *   - stock  → stock qty
     *   - sku    → sku text
     *
     * Hidden inputs for the attribute value ids are always written so the
     * combination itself is preserved and posted back to the server.
     */
    function renderVariantTable(type, combinations) {
        let titleMap = {
            price: 'Price Variants',
            image: 'Image Variants',
            stock: 'Stock Variants',
            sku: 'SKU Variants'
        };

        let headCols = '<th>Variant</th>';
        if (type === 'sku') headCols += '<th>SKU</th>';
        if (type === 'price') headCols += '<th>MRP</th><th>Discount Type</th><th>Discount</th><th>Final Price</th>';
        if (type === 'stock') headCols += '<th>Stock</th>';
        if (type === 'image') headCols += '<th>Image</th>';
        headCols += '<th>Available</th>'; // ✅ replaces the remove-button column

        let rows = '';

        combinations.forEach(function (combo, index) {
            if (!Array.isArray(combo)) combo = [combo];
            let names = combo.map(x => x.name);
            let prefix = `variants_${type}[${index}]`;
            let rowId = `variant-row-${type}-${index}`;

            rows += `<tr id="${rowId}"><td><span class="variant-name-cell">${names.join(' / ')}</span></td>`;

            if (type === 'sku') {
                rows += `<td><input type="text" name="${prefix}[sku]" class="field-input"></td>`;
            }

            if (type === 'price') {
                rows += `
            <td><input type="number" step="0.01" name="${prefix}[mrp]" class="field-input"></td>
            <td>
                <select name="${prefix}[discount_type]" class="field-select">
                    <option value="amount">Amount</option>
                    <option value="percentage">%</option>
                </select>
            </td>
            <td><input type="number" step="0.01" name="${prefix}[discount]" class="field-input"></td>
            <td><input type="number" step="0.01" name="${prefix}[price]" class="field-input" readonly></td>`;
            }

            if (type === 'stock') {
                rows += `<td><input type="number" name="${prefix}[stock]" class="field-input"></td>`;
            }

            if (type === 'image') {
                rows += `<td style="min-width:220px">
                <div class="file-upload-area variant-image-upload" style="padding:14px 10px;">
                    <input type="file" class="variant-image-input" data-prefix="${prefix}" multiple accept="image/*">
                    <div class="upload-icon" style="font-size:16px;margin-bottom:4px;"><i class="fa fa-cloud-upload"></i></div>
                    <p style="font-size:11.5px;margin:0;">Click or drag images</p>
                </div>
                <div class="variant-image-preview" data-prefix="${prefix}" style="display:flex;flex-wrap:wrap;gap:6px;margin-top:8px;"></div>
            </td>`;
            }

            // ✅ "Not offered" checkbox instead of a delete button — the row
            // (and its stock/price/etc data) is always submitted, but
            // checking this tells the controller to save it as is_available=0,
            // so it stays out of customer-facing stock matching without
            // losing whatever the admin already typed into the row.
            rows += `<td style="text-align:center">
            <label style="display:flex;align-items:center;gap:5px;font-size:11.5px;white-space:nowrap;justify-content:center;">
                <input type="checkbox" name="${prefix}[excluded]" onchange="toggleVariantRowStyle(this)">
                Not offered
            </label>
        </td>`;

            rows += `</tr>`;

            combo.forEach(function (item) {
                rows += `<input type="hidden" name="${prefix}[values][]" value="${item.id}">`;
            });
        });

        return `
    <div class="section-card" style="margin-bottom:16px">
        <div class="section-card-header"><h5>${titleMap[type]}</h5></div>
        <div class="section-card-body" style="padding:0;overflow-x:auto">
            <table class="variants-table">
                <thead><tr>${headCols}</tr></thead>
                <tbody>${rows}</tbody>
            </table>
        </div>
        <div class="variant-note">Tick "Not offered" for a combination that doesn't actually exist (e.g. Red isn't available in Small) — it'll be saved but hidden from customers. Leave it unchecked with Stock = 0 if the combination exists but is temporarily out of stock.</div>
    </div>`;
    }

    // ✅ visually grey out a row when marked "Not offered"
    function toggleVariantRowStyle(checkbox) {
        $(checkbox).closest('tr').toggleClass('variant-row-excluded', checkbox.checked);
    }

    /* ── Variant price calculator ───────────────────────────────── */
    $(document).on(
        'keyup change',
        'input[name$="[mrp]"], input[name$="[discount]"], select[name$="[discount_type]"]',
        function () {
            let row = $(this).closest('tr');
            let mrp = parseFloat(row.find('input[name$="[mrp]"]').val()) || 0;
            let discount = parseFloat(row.find('input[name$="[discount]"]').val()) || 0;
            let discountType = row.find('select[name$="[discount_type]"]').val();
            let finalPrice = discountType === 'percentage' ? mrp - (mrp * discount / 100) : mrp - discount;
            if (finalPrice < 0) finalPrice = 0;
            row.find('input[name$="[price]"]').val(finalPrice.toFixed(2));
        }
    );

    /* ── Search Suggestions (tag input, spacebar-to-add, with autocomplete) ── */
    (function () {
        const input = document.getElementById('suggestionsInput');
        const tagList = document.getElementById('suggestionsTagList');
        const hiddenWrap = document.getElementById('suggestionsHidden');
        const dropdown = document.getElementById('suggestionsDropdown');
        const wrap = document.getElementById('suggestionsWrap');

        let tags = Array.isArray(initialSuggestions) ? initialSuggestions.slice() : [];
        let fetchTimer = null;

        function renderTags() {
            tagList.innerHTML = '';
            hiddenWrap.innerHTML = '';
            tags.forEach(function (tag, i) {
                tagList.insertAdjacentHTML('beforeend',
                    `<span class="tag-chip">${tag}<button type="button" class="tag-remove" data-index="${i}">×</button></span>`);
                hiddenWrap.insertAdjacentHTML('beforeend',
                    `<input type="hidden" name="suggestions[]" value="${tag.replace(/"/g, '&quot;')}">`);
            });
        }

        function addTag(value) {
            value = value.trim();
            if (!value) return;
            if (tags.some(t => t.toLowerCase() === value.toLowerCase())) {
                input.value = '';
                dropdown.style.display = 'none';
                return;
            }
            tags.push(value);
            renderTags();
            input.value = '';
            dropdown.style.display = 'none';
        }

        input.addEventListener('keydown', function (e) {
            if (e.key === ' ' || e.code === 'Space') {
                e.preventDefault();
                addTag(input.value);
            } else if (e.key === 'Enter') {
                e.preventDefault();
                addTag(input.value);
            } else if (e.key === 'Backspace' && input.value === '' && tags.length) {
                tags.pop();
                renderTags();
            }
        });

        tagList.addEventListener('click', function (e) {
            if (e.target.classList.contains('tag-remove')) {
                let idx = +e.target.dataset.index;
                tags.splice(idx, 1);
                renderTags();
            }
        });

        input.addEventListener('input', function () {
            clearTimeout(fetchTimer);
            let q = input.value.trim();

            if (!q) {
                dropdown.style.display = 'none';
                return;
            }

            fetchTimer = setTimeout(function () {
                $.get("{{ route('admin.products.suggestion-keywords') }}", { q: q }, function (res) {
                    let matches = res.filter(k => !tags.some(t => t.toLowerCase() === k.toLowerCase()));

                    if (matches.length) {
                        dropdown.innerHTML = matches.map(k => `<div class="tag-suggestion-item">${k}</div>`).join('');
                        dropdown.style.display = 'block';
                    } else {
                        dropdown.style.display = 'none';
                    }
                });
            }, 200);
        });

        dropdown.addEventListener('click', function (e) {
            if (e.target.classList.contains('tag-suggestion-item')) {
                addTag(e.target.textContent);
            }
        });

        document.addEventListener('click', function (e) {
            if (!wrap.contains(e.target)) {
                dropdown.style.display = 'none';
            }
        });

        renderTags();
    })();
</script>

@include('admin.footer')