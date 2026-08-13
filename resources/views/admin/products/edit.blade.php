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

        /* ── Page header ────────────────────────────────────────── */
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

        /* ── Identity chip ─────────────────────────────────────── */
        .prod-identity {
            display: flex;
            align-items: center;
            gap: 12px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            padding: 10px 14px;
            box-shadow: var(--shadow-card);
        }

        .prod-identity-thumb {
            width: 44px;
            height: 44px;
            border-radius: var(--radius-sm);
            object-fit: cover;
            border: 1px solid var(--border);
            flex-shrink: 0;
        }

        .prod-identity-icon {
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

        .prod-identity-name {
            font-size: 14px;
            font-weight: 650;
            color: var(--text-primary);
            max-width: 220px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .prod-identity-id {
            font-size: 12px;
            color: var(--text-hint);
            margin-top: 2px;
            display: flex;
            align-items: center;
            gap: 6px;
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

        .btn-accent-outline {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--accent-light);
            color: var(--accent) !important;
            border: 1px solid rgba(48, 61, 137, .25);
            border-radius: var(--radius-sm);
            padding: 8px 16px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none !important;
            font-family: var(--font);
            transition: background .15s;
        }

        .btn-accent-outline:hover {
            background: #e3e5f7;
        }

        /* ── Layout ─────────────────────────────────────────────── */
        .edit-layout {
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 20px;
            align-items: start;
        }

        @media(max-width:960px) {
            .edit-layout {
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
        .field-select {
            height: 38px;
        }

        .field-textarea {
            padding: 10px 12px;
            resize: vertical;
            min-height: 90px;
        }

        .field-input:focus,
        .field-select:focus,
        .field-textarea:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(48, 61, 137, .12);
        }

        .field-input[readonly] {
            background: var(--bg);
            color: var(--text-secondary);
            cursor: not-allowed;
        }

        .field-hint {
            font-size: 11.5px;
            color: var(--text-hint);
            margin-top: 4px;
        }

        /* ── Slug prefix ────────────────────────────────────────── */
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

        /* ── Price grid ─────────────────────────────────────────── */
        .price-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 12px;
        }

        @media(max-width:600px) {
            .price-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        .final-price-box {
            background: var(--accent-light);
            border: 1px solid #c7cdf5;
            border-radius: var(--radius-sm);
            padding: 12px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 14px;
        }

        .final-price-box .fp-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--accent);
            text-transform: uppercase;
            letter-spacing: .04em;
        }

        .final-price-box .fp-value {
            font-size: 20px;
            font-weight: 700;
            color: var(--accent);
        }

        /* ── Inventory grid ─────────────────────────────────────── */
        .inv-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        /* ── Checkbox pill ──────────────────────────────────────── */
        .check-pill {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 9px 12px;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            background: var(--surface);
            cursor: pointer;
            transition: border-color .15s, background .15s;
            font-size: 13px;
            color: var(--text-primary);
            margin-bottom: 8px;
            user-select: none;
        }

        .check-pill:last-child {
            margin-bottom: 0;
        }

        .check-pill:hover {
            border-color: var(--accent);
            background: var(--accent-light);
        }

        .check-pill input[type="checkbox"] {
            accent-color: var(--accent);
            width: 15px;
            height: 15px;
            flex-shrink: 0;
            cursor: pointer;
        }

        .check-pill input[type="checkbox"]:checked~span {
            font-weight: 600;
            color: var(--accent);
        }

        .check-pill:has(input:checked) {
            border-color: var(--accent);
            background: var(--accent-light);
        }

        .check-pill-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0 12px;
        }

        @media(max-width:600px) {
            .check-pill-grid {
                grid-template-columns: 1fr;
            }
        }

        /* ── Media thumbnails ───────────────────────────────────── */
        .media-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 4px;
        }

        .thumb-box {
            position: relative;
        }

        .thumb-box img {
            width: 80px;
            height: 80px;
            border-radius: var(--radius-sm);
            object-fit: cover;
            border: 1px solid var(--border);
            display: block;
        }

        .thumb-box video {
            width: 130px;
            height: 80px;
            border-radius: var(--radius-sm);
            object-fit: cover;
            border: 1px solid var(--border);
            display: block;
            background: #000;
        }

        .thumb-remove {
            position: absolute;
            top: -6px;
            right: -6px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: var(--red);
            color: #fff;
            border: 2px solid #fff;
            font-size: 11px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
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

        /* ── Upload area ────────────────────────────────────────── */
        .upload-area {
            border: 2px dashed var(--border);
            border-radius: var(--radius-sm);
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: border-color .15s, background .15s;
            position: relative;
        }

        .upload-area:hover {
            border-color: var(--accent);
            background: var(--accent-light);
        }

        .upload-area input[type="file"] {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
            width: 100%;
            height: 100%;
        }

        .upload-icon {
            font-size: 20px;
            color: var(--text-hint);
            margin-bottom: 4px;
        }

        .upload-label {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .upload-sub {
            font-size: 11.5px;
            color: var(--text-hint);
            margin-top: 2px;
        }

        /* ── Toggle rows (right sidebar) ────────────────────────── */
        .toggle-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 0;
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

        /* ── Status pills ───────────────────────────────────────── */
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

        /* ── Attributes (dynamic) ───────────────────────────────── */
        #attribute-container .section-card,
        #variant-container .section-card {
            margin-bottom: 16px;
        }

        #variant-container table {
            font-size: 12.5px;
        }

        #variant-container table th {
            background: #fafafa;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .04em;
            color: var(--text-secondary);
            font-weight: 650;
            padding: 10px;
        }

        #variant-container table td {
            padding: 8px 10px;
            vertical-align: middle;
        }

        #variant-container .form-control,
        #attribute-container .form-control {
            height: 34px;
            border-radius: var(--radius-sm);
            font-size: 12.5px;
            border: 1px solid var(--border);
            background: var(--surface);
            font-family: var(--font);
            padding: 0 10px;
            outline: none;
            transition: border-color .15s, box-shadow .15s;
        }

        #variant-container .form-control:focus,
        #attribute-container .form-control:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(48, 61, 137, .12);
        }

        .variant-name-cell {
            font-weight: 600;
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

        #attribute-container .attr-check-wrap {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 6px;
        }

        #attribute-container .attr-check-item {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 10px;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            background: var(--surface);
            font-size: 12.5px;
            cursor: pointer;
            transition: border-color .12s, background .12s;
        }

        #attribute-container .attr-check-item:hover {
            border-color: var(--accent);
            background: var(--accent-light);
        }

        #attribute-container .attr-check-item input {
            accent-color: var(--accent);
        }

        #attribute-container .attr-check-item:has(input:checked) {
            border-color: var(--accent);
            background: var(--accent-light);
            font-weight: 600;
            color: var(--accent);
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

        /* ── Content tabs (Description / Fabric Care / Shipping & Delivery / Exchange Policy / Customization / Delivery & Returns) ── */
        .content-tabs {
            display: flex;
            flex-wrap: wrap;
            gap: 2px;
            padding: 10px 20px 0;
            border-bottom: 1px solid var(--border);
            background: #fafafa;
            margin: -20px -20px 20px;
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

        /* ── Addon Options table (reuses the same look as variants table) ── */
        .addon-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        .addon-table thead th {
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

        .addon-table tbody tr {
            border-bottom: 1px solid var(--border);
        }

        .addon-table tbody tr:last-child {
            border-bottom: none;
        }

        .addon-table tbody td {
            padding: 10px 12px;
            vertical-align: middle;
        }

        .addon-table .field-input {
            height: 34px;
            font-size: 13px;
        }

        /* ── CKEditor ───────────────────────────────────────────── */
        .cke {
            border-radius: var(--radius-sm) !important;
            border: 1px solid var(--border) !important;
            overflow: hidden;
        }

        .cke_top {
            background: #fafafa !important;
            border-bottom: 1px solid var(--border) !important;
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

        @media(max-width:768px) {
            .edit-page {
                padding: 16px;
            }

            .price-grid {
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
        <div class="edit-page">

            <!-- Page header -->
            <div class="edit-page-header">
                <div>
                    <h1>Edit Product</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        <a href="{{ route('admin.products.index') }}">Products</a>
                        <span>›</span>
                        Edit Product
                    </div>
                </div>

                <!-- Identity chip -->
                <div class="prod-identity">
                    @php $defaultImg = $product->images->firstWhere('is_default', true) ?? $product->images->first(); @endphp
                    @if($defaultImg)
                        <img src="{{ asset('storage/' . $defaultImg->image) }}" class="prod-identity-thumb"
                            alt="{{ $product->name }}">
                    @else
                        <div class="prod-identity-icon"><i class="fa fa-box"></i></div>
                    @endif
                    <div>
                        <div class="prod-identity-name">{{ $product->name }}</div>
                        <div class="prod-identity-id">
                            ID #{{ $product->id }}
                            &middot;
                            @if($product->status)
                                <span class="pill pill-active">Active</span>
                            @else
                                <span class="pill pill-inactive">Inactive</span>
                            @endif
                        </div>
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

            <form method="POST" action="{{ route('admin.products.update', $product->id) }}"
                enctype="multipart/form-data" class="save-form" id="productForm">
                @csrf
                @method('PUT')

                <div class="edit-layout">

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
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="field-group" id="subcategory-wrapper"
                                    style="{{ $product->category_id ? '' : 'display:none' }}">
                                    <label class="field-label">Sub Category</label>
                                    <select name="subcategory_id" id="subcategory_id" class="field-select">
                                        <option value="">Select Sub Category</option>
                                        @foreach($subcategories as $subcategory)
                                            <option value="{{ $subcategory->id }}" {{ old('subcategory_id', $product->subcategory_id) == $subcategory->id ? 'selected' : '' }}>
                                                {{ $subcategory->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="field-group">
                                    <label class="field-label">Product Name <span class="req">*</span></label>
                                    <input type="text" name="name" id="product_name" class="field-input"
                                        value="{{ old('name', $product->name) }}" required>
                                </div>

                                <div class="field-group">
                                    <label class="field-label">Slug</label>
                                    <div class="slug-wrap">
                                        <span class="slug-prefix">product/</span>
                                        <input type="text" name="slug" id="slug" class="field-input"
                                            value="{{ old('slug', $product->slug) }}">
                                    </div>
                                    <div class="field-hint">Optional — auto-generated from product name if left blank
                                    </div>
                                </div>

                                <div class="field-group">
                                    <label class="field-label">Short Description</label>
                                    <textarea name="short_description" class="field-textarea"
                                        rows="3">{{ old('short_description', $product->short_description) }}</textarea>
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
                                    <textarea name="description" id="description" class="field-textarea"
                                        style="min-height:140px">{{ old('description', $product->description) }}</textarea>
                                </div>

                                <div class="content-tab-panel" data-panel="fabric_care">
                                    <textarea name="fabric_care" id="fabric_care" class="field-textarea"
                                        style="min-height:100px">{{ old('fabric_care', $product->fabric_care) }}</textarea>
                                </div>

                                <div class="content-tab-panel" data-panel="shipping_delivery">
                                    <textarea name="shipping_delivery" id="shipping_delivery" class="field-textarea"
                                        style="min-height:100px">{{ old('shipping_delivery', $product->shipping_delivery) }}</textarea>
                                </div>

                                <div class="content-tab-panel" data-panel="exchange_policy">
                                    <textarea name="exchange_policy" id="exchange_policy" class="field-textarea"
                                        style="min-height:100px">{{ old('exchange_policy', $product->exchange_policy) }}</textarea>
                                </div>

                                <div class="content-tab-panel" data-panel="customization_assistance">
                                    <textarea name="customization_assistance" id="customization_assistance"
                                        class="field-textarea"
                                        style="min-height:100px">{{ old('customization_assistance', $product->customization_assistance) }}</textarea>
                                </div>

                                <div class="content-tab-panel" data-panel="delivery_returns">
                                    <textarea name="delivery_returns" id="delivery_returns" class="field-textarea"
                                        style="min-height:100px">{{ old('delivery_returns', $product->delivery_returns) }}</textarea>
                                    <div class="field-hint">Legacy field, kept for products that already have this
                                        filled in — new content should go under Shipping &amp; Delivery / Exchange
                                        Policy above.</div>
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
                                    blank).</div>

                                <div class="price-grid">
                                    <div class="field-group" style="margin:0">
                                        <label class="field-label">MRP</label>
                                        <input type="number" step="0.01" name="mrp" id="mrp" class="field-input"
                                            value="{{ old('mrp', $product->mrp) }}">
                                    </div>
                                    <div class="field-group" style="margin:0">
                                        <label class="field-label">Discount Type</label>
                                        <select name="discount_type" id="discount_type" class="field-select">
                                            <option value="amount" {{ old('discount_type', $product->discount_type) == 'amount' ? 'selected' : '' }}>Amount (₹)
                                            </option>
                                            <option value="percentage" {{ old('discount_type', $product->discount_type) == 'percentage' ? 'selected' : '' }}>Percentage
                                                (%)</option>
                                        </select>
                                    </div>
                                    <div class="field-group" style="margin:0">
                                        <label class="field-label">Discount</label>
                                        <input type="number" step="0.01" name="discount" id="discount"
                                            class="field-input" value="{{ old('discount', $product->discount) }}">
                                    </div>
                                </div>

                                <div class="final-price-box">
                                    <span class="fp-label">Final Price</span>
                                    <span class="fp-value">₹<span
                                            id="price-display">{{ old('price', $product->price) }}</span></span>
                                    <input type="hidden" name="price" id="price"
                                        value="{{ old('price', $product->price) }}">
                                </div>

                            </div>
                        </div>

                        <!-- Media -->
                        <div class="section-card">
                            <div class="section-card-header">
                                <h5>Media</h5>
                            </div>
                            <div class="section-card-body">

                                @if($product->images->count())
                                    <div class="field-group">
                                        <label class="field-label">Current Images</label>
                                        <div class="media-grid" id="existingMedia">
                                            @foreach($product->images as $img)
                                                <div class="thumb-box" id="img_{{ $img->id }}">
                                                    <img src="{{ asset('storage/' . $img->image) }}" alt="">
                                                    <button type="button" class="thumb-remove"
                                                        onclick="removeExistingImage({{ $img->id }})">×</button>
                                                    <div class="thumb-default">
                                                        <input type="radio" name="default_type" value="old_{{ $img->id }}" {{ $img->is_default ? 'checked' : '' }}>
                                                        Default
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <div class="field-group" style="margin-bottom:20px">
                                    <label class="field-label">Upload New Images <span
                                            style="font-weight:400;text-transform:none;font-size:11px">(max 6
                                            total)</span></label>
                                    <div class="upload-area">
                                        <input type="file" id="images" name="images[]" multiple accept="image/*">
                                        <div class="upload-icon"><i class="fa fa-cloud-upload"></i></div>
                                        <div class="upload-label">Click or drag to upload</div>
                                        <div class="upload-sub">PNG, JPG, WEBP &middot; max 6 images</div>
                                    </div>
                                    <div id="previewContainer" class="media-grid"></div>
                                </div>

                                @if($product->videos->count())
                                    <div class="field-group">
                                        <label class="field-label">Current Videos</label>
                                        <div class="media-grid" id="existingVideoMedia">
                                            @foreach($product->videos as $vid)
                                                <div class="thumb-box" id="video_{{ $vid->id }}">
                                                    <video src="{{ asset('storage/' . $vid->video) }}" muted></video>
                                                    <button type="button" class="thumb-remove"
                                                        onclick="removeExistingVideo({{ $vid->id }})">×</button>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <div class="field-group" style="margin:0">
                                    <label class="field-label">Upload New Video <span
                                            style="font-weight:400;text-transform:none;font-size:11px">(max 3
                                            total)</span></label>
                                    <div class="upload-area">
                                        <input type="file" id="videos" name="videos[]" multiple accept="video/*">
                                        <div class="upload-icon"><i class="fa fa-video-camera"></i></div>
                                        <div class="upload-label">Click or drag to upload</div>
                                        <div class="upload-sub">MP4, WEBM &middot; max 3 videos, 20 MB each</div>
                                    </div>
                                    <div id="videoPreviewContainer" class="media-grid"></div>
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
                                <table class="addon-table" id="addon-table"
                                    style="{{ $product->addons->count() ? '' : 'display:none' }}">
                                    <thead>
                                        <tr>
                                            <th>Detail</th>
                                            <th>Price</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="addon-table-body">
                                        @foreach($product->addons as $i => $addon)
                                            <tr id="addon-row-{{ $i }}">
                                                <td><input type="text" name="addons[{{ $i }}][detail]" class="field-input"
                                                        value="{{ $addon->detail }}" placeholder="e.g. Gift Wrapping"></td>
                                                <td><input type="number" step="0.01" name="addons[{{ $i }}][price]"
                                                        class="field-input" value="{{ $addon->price }}" placeholder="0.00">
                                                </td>
                                                <td><button type="button" class="thumb-remove" style="position:static"
                                                        onclick="removeAddonRow({{ $i }})">×</button></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="field-hint" id="addon-empty-hint"
                                    style="padding:16px 20px;{{ $product->addons->count() ? 'display:none' : '' }}">
                                    No addon options yet. An addon is an optional extra — a detail/label plus its own
                                    price — that a customer can choose to add alongside this product.
                                </div>
                            </div>
                        </div>

                        <!-- ── Attributes & Variants (full width below grid) ── -->
                        <div id="attribute-container"></div>

                        <div id="variant-btn-wrapper" style="display:none; margin: 16px 0;">
                            <button type="button" id="generate-variants" class="btn-accent-outline">
                                <i class="fa fa-cogs"></i> Generate / Refresh Variants
                            </button>
                            <span class="field-hint" style="margin-left:8px;">Existing variant data (SKU, price, stock,
                                image)
                                is kept for combinations that are still selected.</span>
                        </div>

                        <div id="variant-container"></div>

                    </div><!-- /left column -->

                    <!-- ══════════ RIGHT COLUMN ══════════ -->
                    <div>

                        <!-- Status -->
                        <div class="section-card">
                            <div class="section-card-header">
                                <h5>Status</h5>
                            </div>
                            <div class="section-card-body" style="padding:14px 20px">
                                <div class="toggle-row" style="padding:0;border:none">
                                    <div>
                                        <div class="toggle-label">Visibility</div>
                                        <div class="toggle-sub">Shown on storefront</div>
                                    </div>
                                    <select name="status" class="field-select-sm">
                                        <option value="1" {{ old('status', $product->status) == 1 ? 'selected' : '' }}>
                                            Active</option>
                                        <option value="0" {{ old('status', $product->status) == 0 ? 'selected' : '' }}>
                                            Inactive</option>
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

                                <div class="inv-grid" style="margin-bottom:14px">
                                    <div class="field-group" style="margin:0">
                                        <label class="field-label">SKU</label>
                                        <input type="text" name="sku" class="field-input"
                                            value="{{ old('sku', $product->sku) }}">
                                    </div>
                                    <div class="field-group" style="margin:0">
                                        <label class="field-label">Product Code</label>
                                        <input type="text" name="product_code" class="field-input"
                                            value="{{ old('product_code', $product->product_code) }}">
                                    </div>
                                    <div class="field-group" style="margin:0">
                                        <label class="field-label">Stock</label>
                                        <input type="number" name="stock" class="field-input"
                                            value="{{ old('stock', $product->stock) }}">
                                    </div>
                                    <div class="field-group" style="margin:0">
                                        <label class="field-label">Min Qty</label>
                                        <input type="number" name="min_qty" class="field-input"
                                            value="{{ old('min_qty', $product->min_qty) }}">
                                    </div>
                                </div>

                                <div class="field-group">
                                    <label class="field-label">Delivery Time</label>
                                    <input type="text" name="delivery_time" class="field-input"
                                        value="{{ old('delivery_time', $product->delivery_time) }}"
                                        placeholder="e.g. 3–5 business days">
                                </div>

                                <div>
                                    <label class="check-pill">
                                        <input type="checkbox" name="quality" {{ old('quality', $product->quality) ? 'checked' : '' }}>
                                        <span>Quality Assurance</span>
                                    </label>
                                    <label class="check-pill">
                                        <input type="checkbox" name="pan_india" {{ old('pan_india', $product->pan_india) ? 'checked' : '' }}>
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
                                    <label class="check-pill">
                                        <input type="checkbox" name="occasions[]" value="{{ $o->id }}" {{ in_array($o->id, old('occasions', $selectedOccasions)) ? 'checked' : '' }}>
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
                                    <label class="check-pill">
                                        <input type="checkbox" name="collections[]" value="{{ $collection->id }}" {{ in_array($collection->id, old('collections', $product->collections->pluck('id')->toArray())) ? 'checked' : '' }}>
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
                                        value="{{ old('meta_title', $product->meta_title) }}">
                                </div>

                                <div class="field-group">
                                    <label class="field-label">Meta Description</label>
                                    <textarea name="meta_description"
                                        class="field-textarea">{{ old('meta_description', $product->meta_description) }}</textarea>
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

                    </div><!-- /right column -->

                </div><!-- /edit-layout -->



                <!-- Action bar -->
                <div class="action-bar">
                    <a href="{{ route('admin.products.index') }}" class="btn-secondary-dash">Cancel</a>
                    <button type="submit" id="saveBtn" class="btn-primary-dash save-btn">
                        <i class="fa fa-save"></i> Update Product
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

<script>
    /*
    |--------------------------------------------------------------------------
    | State handed down from the controller
    |--------------------------------------------------------------------------
    | selectedAttributeValues  → flat array of attribute_value_id already on
    |                            this product (used to pre-check boxes)
    | existingVariantsByType   → { price: [...], image: [...], stock: [...], sku: [...] }
    |                            each entry: { id, sku, mrp, discount_type,
    |                            discount, price, stock, image, variant_name,
    |                            attribute_value_ids: [...] }
    |                            Matches ProductController@edit's
    |                            $existingVariantsByType — NOT a flat
    |                            "existingVariants" (that key doesn't exist).
    */
    let selectedAttributeValues = @json($selectedAttributeValues);
    let existingVariantsByType = @json($existingVariantsByType);
    let storageBaseUrl = "{{ asset('storage') }}"; // ✅ matches main image asset() pattern
    let initialSuggestions = @json($existingKeywords ?? []);

    CKEDITOR.config.versionCheck = false;
    CKEDITOR.replace('description');
    CKEDITOR.replace('fabric_care');
    CKEDITOR.replace('shipping_delivery');
    CKEDITOR.replace('exchange_policy');
    CKEDITOR.replace('customization_assistance');
    CKEDITOR.replace('delivery_returns');

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

    /*
    |--------------------------------------------------------------------------
    | variantDataByType — the persistence layer
    |--------------------------------------------------------------------------
    | Keyed by type, then by a stable "combo key" (sorted attribute_value_ids
    | joined with commas). Seeded from existingVariantsByType on load. Before
    | every re-render (regenerate click) we re-capture whatever is currently
    | sitting in the DOM back into this map, so nothing typed by the admin —
    | or previously saved — is lost just because the set of checked attribute
    | values changed. Combinations that are no longer checked simply stop
    | being rendered (and will be deleted server-side on save, same as
    | before); combinations that are still checked keep their data.
    */
    let variantDataByType = { price: {}, image: {}, stock: {}, sku: {} };

    ['price', 'image', 'stock', 'sku'].forEach(function (type) {
        (existingVariantsByType[type] || []).forEach(function (variant) {
            let key = comboKey(variant.attribute_value_ids);
            variantDataByType[type][key] = variant;
        });
    });

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
                <div class="thumb-box" style="width:50px;height:50px;">
                    <img src="${e.target.result}" style="width:50px;height:50px;object-fit:cover;border-radius:6px;">
                    <button type="button" class="thumb-remove" style="width:16px;height:16px;font-size:9px;" onclick="removeVariantImage('${prefix}', ${index})">×</button>
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

    function removeExistingVariantImage(id) {
        if (confirm('Remove this variant image?')) {
            $('#variant-img-' + id).remove();
            $('<input>').attr({ type: 'hidden', name: 'delete_variant_images[]', value: id }).appendTo('form');
        }
    }

    function comboKey(ids) {
        return ids.map(String).slice().sort(function (a, b) { return Number(a) - Number(b); }).join(',');
    }

    $(document).ready(function () {
        let categoryId = $('#category_id').val();
        if (categoryId) {
            loadAttributes(categoryId, true); // true = initial load, auto-render existing variants after
        }
        calcPrice(); // ✅ keep hidden #price + display in sync on load, in case product had no MRP/discount saved
        toggleAddonTable();
    });

    // Slug auto-gen
    $(document).on('keyup', '#product_name', function () {
        $('#slug').val($(this).val().toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, ''));
    });

    // Price calc — also updates the visible display span
    function calcPrice() {
        let m = +$('#mrp').val() || 0;
        let d = +$('#discount').val() || 0;
        let t = $('#discount_type').val();
        let p = t == 'percentage' ? m - (m * d / 100) : m - d;
        if (p < 0) p = 0;
        $('#price').val(p.toFixed(2));
        $('#price-display').text(p.toFixed(2));
    }
    $('#mrp,#discount,#discount_type').on('keyup change', calcPrice);

    // Submit spinner
    $(document).on('submit', '.save-form', function () {
        let btn = $(this).find('.save-btn');
        btn.prop('disabled', true);
        btn.html('<i class="fa fa-spinner fa-spin"></i> Updating...');
    });

    // ── Image handling ────────────────────────────────────────────
    let selectedFiles = [];

    $('#images').on('change', function (e) {
        let files = Array.from(e.target.files);
        if ((selectedFiles.length + files.length) > 6) { alert('Max 6 images allowed'); return; }
        files.forEach(file => selectedFiles.push(file));
        renderPreview();
    });

    function renderPreview() {
        $('#previewContainer').html('');
        selectedFiles.forEach((file, index) => {
            let reader = new FileReader();
            reader.onload = function (e) {
                $('#previewContainer').append(`
                <div class="thumb-box">
                    <img src="${e.target.result}">
                    <button type="button" class="thumb-remove" onclick="removeImage(${index})">×</button>
                    <div class="thumb-default">
                        <input type="radio" name="default_type" value="new_${index}" ${index === 0 ? 'checked' : ''}> Default
                    </div>
                </div>
            `);
            };
            reader.readAsDataURL(file);
        });
    }

    function removeImage(index) { selectedFiles.splice(index, 1); renderPreview(); }

    function removeExistingImage(id) {
        if (confirm('Remove this image?')) {
            $('#img_' + id).remove();
            $('<input>').attr({ type: 'hidden', name: 'delete_images[]', value: id }).appendTo('form');
        }
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

    // ── Video handling ─────────────────────────────────────────────
    let selectedVideos = [];

    $('#videos').on('change', function (e) {
        let files = Array.from(e.target.files);
        if ((selectedVideos.length + files.length) > 3) { alert('Max 3 videos allowed'); return; }
        files.forEach(file => selectedVideos.push(file));
        renderVideoPreview();
    });

    function renderVideoPreview() {
        $('#videoPreviewContainer').html('');
        selectedVideos.forEach((file, index) => {
            let url = URL.createObjectURL(file);
            $('#videoPreviewContainer').append(`
            <div class="thumb-box">
                <video src="${url}" muted></video>
                <button type="button" class="thumb-remove" onclick="removeVideo(${index})">×</button>
            </div>
        `);
        });
    }

    function removeVideo(index) { selectedVideos.splice(index, 1); renderVideoPreview(); }

    function removeExistingVideo(id) {
        if (confirm('Remove this video?')) {
            $('#video_' + id).remove();
            $('<input>').attr({ type: 'hidden', name: 'delete_videos[]', value: id }).appendTo('form');
        }
    }

    // ── Addon Options (dynamic rows, pre-filled from existing) ─────
    // Field index must not collide with the rows already rendered server-side
    // for the product's existing addons, so we start counting after them.
    let addonIndex = {{ $product->addons->count() }};

    $(document).on('click', '#add-addon-row', function () {
        let row = `
        <tr id="addon-row-${addonIndex}">
            <td><input type="text" name="addons[${addonIndex}][detail]" class="field-input" placeholder="e.g. Gift Wrapping"></td>
            <td><input type="number" step="0.01" name="addons[${addonIndex}][price]" class="field-input" placeholder="0.00"></td>
            <td><button type="button" class="thumb-remove" style="position:static" onclick="removeAddonRow(${addonIndex})">×</button></td>
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

    // ── Category → sub + attributes ──────────────────────────────
    $('#category_id').on('change', function () {
        let categoryId = $(this).val();
        $('#variant-container').html('');
        $('#variant-btn-wrapper').hide();
        $('#subcategory_id').html('<option value="">Loading...</option>');

        // Switching category means the attribute set is different, so the
        // saved combination map for the OLD category no longer applies.
        variantDataByType = { price: {}, image: {}, stock: {}, sku: {} };

        if (!categoryId) { $('#subcategory-wrapper').hide(); $('#attribute-container').html(''); return; }

        loadAttributes(categoryId, false); // false = not initial load, don't auto-render old variants

        window.subCategoryUrl = "{{ url('admin/products/subcategories') }}";
        $.get(window.subCategoryUrl + '/' + categoryId, function (response) {
            if (response.length > 0) {
                let html = '<option value="">Select Sub Category</option>';
                $.each(response, function (i, item) { html += `<option value="${item.id}">${item.name}</option>`; });
                $('#subcategory_id').html(html);
                $('#subcategory-wrapper').show();
            } else {
                $('#subcategory-wrapper').hide();
            }
        });
    });

    /*
    |--------------------------------------------------------------------------
    | Load attributes — accordion UI, all category attributes shown
    |--------------------------------------------------------------------------
    | is_selectable is a FRONTEND-ONLY (customer-facing) flag and is not
    | filtered out here — the admin needs to see every attribute regardless.
    | Each checkbox carries the dependency flags needed by the type-aware
    | variant generator below.
    */
    function loadAttributes(categoryId, isInitialLoad) {
        $('#attribute-container').html('');
        window.attributeUrl = "{{ url('admin/products/category-attributes') }}";

        $.get(window.attributeUrl + '/' + categoryId, function (response) {
            if (response.length > 0) {
                let html = `
                <div class="section-card">
                    <div class="section-card-header">
                        <h5>Attributes</h5>
                        <div style="display:flex;gap:6px;">
                            <button type="button" class="btn-secondary-dash" id="attr-expand-all" style="padding:5px 12px;font-size:11.5px;">Expand All</button>
                            <button type="button" class="btn-secondary-dash" id="attr-collapse-all" style="padding:5px 12px;font-size:11.5px;">Collapse All</button>
                        </div>
                    </div>
                    <div class="section-card-body">
            `;

                response.forEach(function (item, i) {
                    let isVariant = item.used_for_variant ? 1 : 0;
                    let valueCount = (item.attribute.has_values && item.attribute.values) ? item.attribute.values.length : 0;

                    // Auto-open an attribute that already has a selected value, so the
                    // admin immediately sees what's driving the existing variants.
                    let hasSelection = item.attribute.has_values && item.attribute.values.some(v => selectedAttributeValues.includes(v.id));

                    html += `
                    <div class="attr-accordion${hasSelection ? ' open' : ''}" data-attr-index="${i}">
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
                        html += `<div class="attr-check-wrap">`;
                        item.attribute.values.forEach(function (value) {
                            let checked = selectedAttributeValues.includes(value.id) ? 'checked' : '';
                            html += `
                            <label class="attr-check-item">
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
                                    value="${value.id}" ${checked}>
                                ${value.value}
                            </label>`;
                        });
                        html += `</div>`;
                    } else {
                        html += `<div class="field-hint">No values configured for this attribute.</div>`;
                    }

                    html += `</div></div>`;
                });

                html += `</div></div>`;
                $('#attribute-container').html(html);
                $('#variant-btn-wrapper').show();

                // Expand accordions that were flagged open, and set their max-height.
                $('.attr-accordion.open').each(function () {
                    let $body = $(this).find('.attr-accordion-body');
                    $body.css('max-height', $body[0].scrollHeight + 'px');
                });

                // Initialize the "N selected" badges.
                $('.attr-accordion').each(function () { refreshAttrSelectedCount($(this)); });

                // On the very first page load, rebuild the saved variant tables from
                // whatever is already checked (i.e. the product's existing attribute
                // values), so existing variants show up immediately without needing
                // to click Generate.
                if (isInitialLoad) {
                    renderAllVariantTypes();
                }
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

    function refreshAttrSelectedCount($accordion) {
        let count = $accordion.find('.attribute-value:checked').length;
        let $badge = $accordion.find('.attr-selected-count');
        $badge.text(count + ' selected').toggleClass('show', count > 0);
    }

    $(document).on('change', '.attribute-value', function () {
        refreshAttrSelectedCount($(this).closest('.attr-accordion'));
    });

    /*
    |--------------------------------------------------------------------------
    | Type-aware variant generation (matches controller's 4 independent arrays)
    |--------------------------------------------------------------------------
    | The controller reads FOUR separate arrays: variants_price, variants_image,
    | variants_stock, variants_sku — each an independent combination set built
    | ONLY from attribute values whose category-attribute has that specific
    | *_dependent flag turned on. So we build up to 4 separate tables here.
    */
    $(document).on('click', '#generate-variants', function () {
        renderAllVariantTypes();
    });

    function renderAllVariantTypes() {
        ['price', 'image', 'stock', 'sku'].forEach(function (type) {
            renderVariantsForType(type);
        });
    }

    /**
     * Rebuilds the table for a single type from the currently-checked,
     * type-dependent attribute values — while preserving any data already
     * captured (existing DB rows, or values typed in during this session)
     * for combinations that are still selected.
     */
    function renderVariantsForType(type) {
        captureVariantType(type);

        let groups = {};
        $('.attribute-value:checked').each(function () {
            if ($(this).data('variant') != 1) return;
            if ($(this).data(type + '-dependent') != 1) return;

            let attributeId = $(this).data('attribute-id');
            if (!groups[attributeId]) groups[attributeId] = [];
            groups[attributeId].push({ id: $(this).val(), name: $(this).data('value-name') });
        });

        let groupArr = Object.values(groups);
        let $existingCard = $('#variant-table-' + type).closest('.section-card');

        if (groupArr.length === 0) {
            if ($existingCard.length) $existingCard.remove();
            return;
        }

        let combinations = cartesian(groupArr);
        let rows = '';

        combinations.forEach(function (combo, index) {
            if (!Array.isArray(combo)) combo = [combo];
            let ids = combo.map(c => c.id);
            let names = combo.map(c => c.name).join(' / ');
            let key = comboKey(ids);
            let data = variantDataByType[type][key] || {};
            rows += buildVariantRow(type, index, key, names, ids, data);
        });

        let wrap = variantTableWrap(type, headColsForType(type), rows);

        if ($existingCard.length) {
            $existingCard.replaceWith(wrap);
        } else {
            $('#variant-container').append(wrap);
        }
    }

    function variantTableWrap(type, headHtml, rows) {
        let titleMap = { price: 'Price Variants', image: 'Image Variants', stock: 'Stock Variants', sku: 'SKU Variants' };

        return `<div class="section-card" style="margin-bottom:16px">
        <div class="section-card-header"><h5>${titleMap[type]}</h5></div>
        <div class="section-card-body" style="padding:0;overflow-x:auto">
            <table class="table table-bordered" style="margin:0" id="variant-table-${type}">
                <thead><tr>${headHtml}</tr></thead>
                <tbody>${rows}</tbody>
            </table>
        </div>
        <div class="variant-note">Tick "Not offered" for a combination that doesn't exist (e.g. Red isn't available in Small) — it stays saved but hidden from customers. Leave it unchecked with Stock = 0 for a combination that's temporarily sold out.</div>
    </div>`;
    }


    /**
     * Reads whatever is currently rendered for a type back into
     * variantDataByType, keyed by each row's data-key. Skips file inputs
     * (browsers won't let us read a real value from them, and we don't want
     * to overwrite an in-progress file selection with a blank).
     */
    function captureVariantType(type) {
        $(`.variant-row[data-type="${type}"]`).each(function () {
            let $row = $(this);
            let key = $row.data('key');
            if (!key) return;

            let data = variantDataByType[type][key] || {};

            $row.find('[data-field]').each(function () {
                if ($(this).attr('type') === 'file') return;
                let field = $(this).data('field');

                // ✅ checkboxes need their checked state, not .val()
                if ($(this).attr('type') === 'checkbox') {
                    if (field === 'excluded') {
                        data.is_available = !$(this).is(':checked');
                    }
                    return;
                }

                data[field] = $(this).val();
            });

            variantDataByType[type][key] = data;
        });
    }

    function cartesian(arr) {
        if (arr.length === 1) return arr[0].map(item => [item]);
        return arr.reduce((a, b) => a.flatMap(d => b.map(e => [].concat(d, e))));
    }

    function headColsForType(type) {
        let head = '<th>Variant</th>';
        if (type === 'sku') head += '<th>SKU</th>';
        if (type === 'price') head += '<th>MRP</th><th>Discount Type</th><th>Discount</th><th>Final Price</th>';
        if (type === 'stock') head += '<th>Stock</th>';
        if (type === 'image') head += '<th>Image</th>';
        head += '<th>Available</th>'; // ✅ replaces the remove-button column
        return head;
    }

    function buildVariantRow(type, index, key, names, comboIds, data) {
        data = data || {};
        let prefix = `variants_${type}[${index}]`;
        let isExcluded = data.is_available === false;

        let row = `<tr class="variant-row${isExcluded ? ' variant-row-excluded' : ''}" data-type="${type}" data-key="${key}">
    <td>
        <span class="variant-name-cell">${names}</span>
        <input type="hidden" data-field="id" name="${prefix}[id]" value="${data.id || ''}">
    </td>`;

        if (type === 'sku') {
            row += `<td><input type="text" data-field="sku" name="${prefix}[sku]" class="form-control" value="${data.sku || ''}"></td>`;
        }

        if (type === 'price') {
            row += `
        <td><input type="number" step="0.01" data-field="mrp" name="${prefix}[mrp]" class="form-control" value="${data.mrp || ''}"></td>
        <td>
            <select data-field="discount_type" name="${prefix}[discount_type]" class="form-control">
                <option value="amount"     ${(data.discount_type || 'amount') === 'amount' ? 'selected' : ''}>Amount</option>
                <option value="percentage" ${(data.discount_type || '') === 'percentage' ? 'selected' : ''}>%</option>
            </select>
        </td>
        <td><input type="number" step="0.01" data-field="discount" name="${prefix}[discount]" class="form-control" value="${data.discount || ''}"></td>
        <td><input type="number" step="0.01" data-field="price" name="${prefix}[price]" class="form-control" value="${data.price || ''}" readonly></td>`;
        }

        if (type === 'stock') {
            row += `<td><input type="number" data-field="stock" name="${prefix}[stock]" class="form-control" value="${data.stock || ''}"></td>`;
        }

        if (type === 'image') {
            let existingImagesHtml = '';
            (data.images || []).forEach(function (img) {
                existingImagesHtml += `
                <div class="thumb-box" id="variant-img-${img.id}" style="width:50px;height:50px;">
                    <img src="${storageBaseUrl}/${img.image}" style="width:50px;height:50px;object-fit:cover;border-radius:6px;border:1px solid var(--border);">
                    <button type="button" class="thumb-remove" style="width:16px;height:16px;font-size:9px;" onclick="removeExistingVariantImage(${img.id})">×</button>
                </div>`;
            });

            row += `<td style="min-width:220px">
            <div class="media-grid" style="margin-bottom:6px;">${existingImagesHtml}</div>
            <div class="upload-area variant-image-upload" style="padding:10px;">
                <input type="file" class="variant-image-input" data-prefix="${prefix}" multiple accept="image/*">
                <div class="upload-icon" style="font-size:14px;margin-bottom:2px;"><i class="fa fa-cloud-upload"></i></div>
                <div class="upload-sub">Click or drag images</div>
            </div>
            <div class="variant-image-preview media-grid" data-prefix="${prefix}" style="margin-top:6px;"></div>
        </td>`;
        }

        comboIds.forEach(function (id) {
            row += `<input type="hidden" data-field="values" name="${prefix}[values][]" value="${id}">`;
        });

        // ✅ "Not offered" checkbox — pre-checked if this variant was previously
        // saved with is_available = false, so the exclusion survives reload
        // (this fixes the original bug: nothing here depends on in-memory state)
        row += `<td style="text-align:center">
        <label style="display:flex;align-items:center;gap:5px;font-size:11.5px;white-space:nowrap;justify-content:center;">
            <input type="checkbox" data-field="excluded" name="${prefix}[excluded]"
                ${isExcluded ? 'checked' : ''} onchange="toggleVariantRowStyle(this)">
            Not offered
        </label>
    </td>`;

        row += `</tr>`;
        return row;
    }

    // ✅ visually grey out a row when marked "Not offered"
    function toggleVariantRowStyle(checkbox) {
        $(checkbox).closest('tr').toggleClass('variant-row-excluded', checkbox.checked);
    }


    // Variant price calc — matches on the suffix so it works regardless of
    // which variants_{type}[index] prefix the field belongs to.
    $(document).on('keyup change',
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