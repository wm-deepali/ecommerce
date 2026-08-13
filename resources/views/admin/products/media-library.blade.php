@php
    $media = null;
@endphp

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
            --green-bg: #e3f1ec;
            --amber: #916a00;
            --amber-bg: #fff5cc;
            --blue: #0069d9;
            --blue-bg: #e8f2ff;
            --red: #b22222;
            --red-bg: #fce8e8;
            --radius-sm: 8px;
            --radius-md: 12px;
            --shadow-card: 0 1px 3px rgba(0,0,0,.08), 0 0 0 1px var(--border);
            --font: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        .ml-page {
            background: var(--bg);
            padding: 24px 28px;
            min-height: 100vh;
            font-family: var(--font);
            color: var(--text-primary);
            box-sizing: border-box;
        }

        .ml-page * { box-sizing: border-box; }

        /* ── Page header ── */
        .ml-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 20px;
        }

        .ml-header h1 {
            font-size: 20px;
            font-weight: 650;
            color: var(--text-primary);
            margin: 0;
        }

        .crumb { font-size: 12.5px; color: var(--text-hint); margin-top: 3px; }
        .crumb a { color: var(--accent); text-decoration: none; }
        .crumb a:hover { text-decoration: underline; }
        .crumb span { margin: 0 5px; }

        /* ── Buttons ── */
        .btn-primary-dash {
            display: inline-flex; align-items: center; gap: 6px;
            background: var(--accent); color: #fff !important;
            border: none; border-radius: var(--radius-sm);
            padding: 8px 16px; font-size: 13px; font-weight: 600;
            cursor: pointer; text-decoration: none !important;
            font-family: var(--font); transition: background .15s;
            box-shadow: 0 1px 3px rgba(48,61,137,.25);
        }
        .btn-primary-dash:hover { background: #252f70; }

        .btn-secondary-dash {
            display: inline-flex; align-items: center; gap: 6px;
            background: var(--surface); color: var(--text-primary) !important;
            border: 1px solid var(--border); border-radius: var(--radius-sm);
            padding: 8px 16px; font-size: 13px; font-weight: 500;
            cursor: pointer; text-decoration: none !important;
            font-family: var(--font); transition: background .15s;
        }
        .btn-secondary-dash:hover { background: var(--bg); }

        .btn-danger-soft {
            display: inline-flex; align-items: center; gap: 6px;
            background: var(--red-bg); color: var(--red) !important;
            border: 1px solid #f5c0c0; border-radius: var(--radius-sm);
            padding: 8px 16px; font-size: 13px; font-weight: 600;
            cursor: pointer; text-decoration: none !important;
            font-family: var(--font); transition: all .15s;
        }
        .btn-danger-soft:hover { background: var(--red); color: #fff !important; }

        /* ── Storage banner ── */
        .storage-banner {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-card);
            padding: 16px 22px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 28px;
            flex-wrap: wrap;
        }

        .storage-main { flex: 1; min-width: 220px; }

        .storage-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .storage-title {
            font-size: 13px;
            font-weight: 650;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .storage-title i { color: var(--accent); }

        .storage-used {
            font-size: 13px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .storage-used span {
            font-weight: 400;
            color: var(--text-hint);
            font-size: 12px;
        }

        .storage-bar-bg {
            height: 8px;
            background: var(--border);
            border-radius: 99px;
            overflow: hidden;
        }

        .storage-bar-fill {
            height: 100%;
            border-radius: 99px;
            background: linear-gradient(90deg, var(--accent) 0%, #5a67d8 100%);
            transition: width .4s;
        }

        .storage-bar-fill.warn { background: linear-gradient(90deg, var(--amber) 0%, #e6a817 100%); }
        .storage-bar-fill.danger { background: linear-gradient(90deg, var(--red) 0%, #e05252 100%); }

        .storage-sub {
            font-size: 11.5px;
            color: var(--text-hint);
            margin-top: 5px;
        }

        .storage-stats {
            display: flex;
            gap: 24px;
            flex-wrap: wrap;
        }

        .storage-stat-item {
            text-align: center;
        }

        .storage-stat-val {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-primary);
            line-height: 1;
        }

        .storage-stat-lbl {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .04em;
            color: var(--text-hint);
            margin-top: 3px;
        }

        /* ── Filter toolbar ── */
        .ml-toolbar {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-card);
            padding: 12px 16px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .ml-search-wrap {
            position: relative;
            flex: 1;
            min-width: 200px;
        }

        .ml-search-wrap i {
            position: absolute;
            left: 11px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-hint);
            font-size: 13px;
            pointer-events: none;
        }

        .ml-search {
            width: 100%;
            height: 36px;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 0 12px 0 34px;
            font-size: 13px;
            color: var(--text-primary);
            background: var(--surface);
            outline: none;
            font-family: var(--font);
            transition: border-color .15s, box-shadow .15s;
        }

        .ml-search:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(48,61,137,.12);
        }

        .ml-filter-select {
            height: 36px;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 0 11px;
            font-size: 13px;
            color: var(--text-primary);
            background: var(--surface);
            outline: none;
            font-family: var(--font);
            transition: border-color .15s;
            cursor: pointer;
        }

        .ml-filter-select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(48,61,137,.12);
        }

        .toolbar-divider {
            width: 1px;
            height: 28px;
            background: var(--border);
        }

        /* View toggle */
        .view-toggle {
            display: flex;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            overflow: hidden;
        }

        .view-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            border: none;
            background: var(--surface);
            color: var(--text-hint);
            cursor: pointer;
            font-size: 13px;
            transition: all .12s;
            font-family: var(--font);
        }

        .view-btn:first-child { border-right: 1px solid var(--border); }

        .view-btn.active {
            background: var(--accent-light);
            color: var(--accent);
        }

        .view-btn:hover:not(.active) { background: var(--bg); color: var(--text-secondary); }

        /* Bulk actions bar */
        .bulk-bar {
            background: var(--accent-light);
            border: 1px solid rgba(48,61,137,.2);
            border-radius: var(--radius-sm);
            padding: 9px 14px;
            display: none;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 12px;
        }

        .bulk-bar.show { display: flex; }

        .bulk-count {
            font-size: 13px;
            font-weight: 600;
            color: var(--accent);
        }

        /* ── Grid view ── */
        .ml-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 12px;
            margin-bottom: 20px;
        }

        .ml-item {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            overflow: hidden;
            cursor: pointer;
            transition: border-color .15s, box-shadow .15s;
            position: relative;
        }

        .ml-item:hover {
            border-color: var(--accent);
            box-shadow: 0 0 0 2px rgba(48,61,137,.12);
        }

        .ml-item.selected {
            border-color: var(--accent);
            box-shadow: 0 0 0 2px var(--accent);
        }

        .ml-item-check {
            position: absolute;
            top: 8px;
            left: 8px;
            width: 20px;
            height: 20px;
            border-radius: 5px;
            border: 2px solid rgba(255,255,255,.9);
            background: rgba(0,0,0,.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            color: #fff;
            opacity: 0;
            transition: opacity .15s;
            z-index: 2;
            cursor: pointer;
        }

        .ml-item:hover .ml-item-check,
        .ml-item.selected .ml-item-check { opacity: 1; }

        .ml-item.selected .ml-item-check {
            background: var(--accent);
            border-color: var(--accent);
        }

        .ml-item-img-wrap {
            width: 100%;
            aspect-ratio: 1;
            background: var(--bg);
            overflow: hidden;
            position: relative;
        }

        .ml-item-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform .2s;
        }

        .ml-item:hover .ml-item-img-wrap img { transform: scale(1.04); }

        .ml-item-info {
            padding: 8px 10px;
            border-top: 1px solid var(--border);
        }

        .ml-item-name {
            font-size: 12px;
            font-weight: 500;
            color: var(--text-primary);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .ml-item-meta {
            font-size: 11px;
            color: var(--text-hint);
            margin-top: 2px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .ml-item-usage {
            display: inline-flex;
            align-items: center;
            gap: 3px;
            font-size: 10.5px;
            font-weight: 600;
            padding: 1px 6px;
            border-radius: 10px;
        }

        .ml-item-usage.used { background: var(--green-bg); color: var(--green); }
        .ml-item-usage.unused { background: var(--red-bg); color: var(--red); }

        .ml-item-overlay {
            position: absolute;
            inset: 0;
            background: rgba(48,61,137,.0);
            transition: background .15s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            opacity: 0;
            transition: opacity .15s;
        }

        .ml-item:hover .ml-item-overlay { opacity: 1; background: rgba(48,61,137,.08); }

        /* ── List view ── */
        .ml-list { display: none; margin-bottom: 20px; }

        .ml-list.show { display: block; }
        .ml-grid.hide { display: none; }

        .ml-list-table {
            width: 100%;
            border-collapse: collapse;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            overflow: hidden;
            font-size: 13px;
            font-family: var(--font);
        }

        .ml-list-table thead th {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: var(--text-hint);
            padding: 10px 14px;
            border-bottom: 1px solid var(--border);
            background: #fafafa;
            text-align: left;
            white-space: nowrap;
        }

        .ml-list-table tbody tr {
            border-bottom: 1px solid var(--border);
            transition: background .1s;
            cursor: pointer;
        }

        .ml-list-table tbody tr:last-child { border-bottom: none; }
        .ml-list-table tbody tr:hover { background: #fafbfc; }

        .ml-list-table tbody td {
            padding: 10px 14px;
            vertical-align: middle;
        }

        .ml-thumb {
            width: 46px;
            height: 46px;
            border-radius: var(--radius-sm);
            object-fit: cover;
            border: 1px solid var(--border);
            display: block;
        }

        /* ── Detail panel (slide-in) ── */
        .ml-detail-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.35);
            z-index: 1040;
            display: none;
            align-items: stretch;
        }

        .ml-detail-overlay.open { display: flex; }

        .ml-detail-panel {
            width: 360px;
            background: var(--surface);
            margin-left: auto;
            height: 100%;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            box-shadow: -4px 0 24px rgba(0,0,0,.12);
        }

        .ml-detail-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fafafa;
            position: sticky;
            top: 0;
            z-index: 2;
        }

        .ml-detail-header h5 {
            font-size: 14px;
            font-weight: 650;
            margin: 0;
            color: var(--text-primary);
        }

        .ml-close-btn {
            width: 30px; height: 30px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
            background: var(--surface);
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; font-size: 13px; color: var(--text-secondary);
            transition: all .12s;
        }

        .ml-close-btn:hover { background: var(--red-bg); color: var(--red); border-color: #f5c0c0; }

        .ml-detail-img {
            width: 100%;
            aspect-ratio: 4/3;
            object-fit: contain;
            background: var(--bg);
            border-bottom: 1px solid var(--border);
        }

        .ml-detail-body { padding: 20px; flex: 1; }

        .ml-detail-field { margin-bottom: 16px; }
        .ml-detail-field:last-child { margin-bottom: 0; }

        .ml-detail-label {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .04em;
            color: var(--text-hint);
            margin-bottom: 5px;
        }

        .ml-detail-value {
            font-size: 13px;
            color: var(--text-primary);
        }

        .ml-detail-input {
            width: 100%;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 8px 10px;
            font-size: 13px;
            color: var(--text-primary);
            background: var(--surface);
            outline: none;
            font-family: var(--font);
            transition: border-color .15s, box-shadow .15s;
            resize: vertical;
        }

        .ml-detail-input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(48,61,137,.12);
        }

        .ml-detail-footer {
            padding: 14px 20px;
            border-top: 1px solid var(--border);
            display: flex;
            gap: 8px;
            background: #fafafa;
            position: sticky;
            bottom: 0;
        }

        .usage-tag {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: var(--accent-light);
            color: var(--accent);
            border: 1px solid rgba(48,61,137,.15);
            border-radius: 6px;
            padding: 3px 9px;
            font-size: 12px;
            font-weight: 500;
            margin: 2px 3px 2px 0;
            text-decoration: none;
        }

        .usage-tag:hover { background: var(--accent); color: #fff; }

        /* ── Upload drop zone ── */
        .upload-dropzone {
            border: 2px dashed var(--border);
            border-radius: var(--radius-md);
            padding: 28px 20px;
            text-align: center;
            cursor: pointer;
            transition: border-color .15s, background .15s;
            position: relative;
            background: var(--surface);
            margin-bottom: 16px;
        }

        .upload-dropzone:hover,
        .upload-dropzone.dragover {
            border-color: var(--accent);
            background: var(--accent-light);
        }

        .upload-dropzone input[type=file] {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
            width: 100%;
            height: 100%;
        }

        .upload-dropzone i { font-size: 28px; color: var(--text-hint); display: block; margin-bottom: 8px; }

        .upload-dropzone p {
            font-size: 13.5px;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0 0 4px;
        }

        .upload-dropzone small {
            font-size: 12px;
            color: var(--text-hint);
        }

        /* ── Pagination ── */
        .ml-pagination {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 0;
            flex-wrap: wrap;
            gap: 8px;
        }

        .ml-pagination-info { font-size: 12.5px; color: var(--text-hint); }

        /* ── Pills ── */
        .pill {
            display: inline-flex; align-items: center; gap: 4px;
            font-size: 11px; font-weight: 600;
            padding: 2px 8px; border-radius: 20px; white-space: nowrap;
        }

        .pill-green { background: var(--green-bg); color: var(--green); }
        .pill-red   { background: var(--red-bg);   color: var(--red); }
        .pill-amber { background: var(--amber-bg);  color: var(--amber); }

        /* action btn */
        .action-btn {
            display: inline-flex; align-items: center; justify-content: center;
            width: 30px; height: 30px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
            background: var(--surface);
            color: var(--text-secondary);
            font-size: 12px; cursor: pointer;
            transition: all .12s; text-decoration: none;
        }

        .action-btn:hover { background: var(--bg); color: var(--text-primary); }
        .action-btn.danger:hover { background: var(--red-bg); border-color: #f5c0c0; color: var(--red); }

        @media(max-width:768px) {
            .ml-page { padding: 16px; }
            .ml-grid { grid-template-columns: repeat(auto-fill, minmax(130px, 1fr)); }
            .ml-detail-panel { width: 100%; }
        }
    </style>

    <div class="app-content content container-fluid">
        <div class="ml-page">

            <!-- Page header -->
            <div class="ml-header">
                <div>
                    <h1>Media Library</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        Media Library
                    </div>
                </div>
                <div style="display:flex;gap:8px;flex-wrap:wrap">
                    <button class="btn-secondary-dash" onclick="document.getElementById('bulkCompressInput').click()">
                        <i class="fa fa-compress"></i> Bulk Compress
                    </button>
                    <label class="btn-primary-dash" style="cursor:pointer">
                        <i class="fa fa-upload"></i> Upload Files
                        <input type="file" multiple accept="image/*" style="display:none" id="bulkCompressInput">
                    </label>
                </div>
            </div>

            <!-- Storage banner -->
            <div class="storage-banner">
                <div class="storage-main">
                    <div class="storage-top">
                        <div class="storage-title">
                            <i class="fa fa-hard-drive"></i> Storage Usage
                        </div>
                        <div class="storage-used">2.4 GB <span>of 5 GB used</span></div>
                    </div>
                    <div class="storage-bar-bg">
                        <div class="storage-bar-fill warn" style="width:48%"></div>
                    </div>
                    <div class="storage-sub">48% used &nbsp;·&nbsp; 2.6 GB remaining &nbsp;·&nbsp; Last upload: Today, 11:42 AM</div>
                </div>

                <div class="storage-stats">
                    <div class="storage-stat-item">
                        <div class="storage-stat-val">842</div>
                        <div class="storage-stat-lbl">Total Files</div>
                    </div>
                    <div class="storage-stat-item">
                        <div class="storage-stat-val">714</div>
                        <div class="storage-stat-lbl">Images</div>
                    </div>
                    <div class="storage-stat-item">
                        <div class="storage-stat-val" style="color:var(--red)">68</div>
                        <div class="storage-stat-lbl">Unused</div>
                    </div>
                    <div class="storage-stat-item">
                        <div class="storage-stat-val">128</div>
                        <div class="storage-stat-lbl">PDFs / Docs</div>
                    </div>
                </div>
            </div>

            <!-- Upload drop zone -->
            <div class="upload-dropzone" id="dropzone">
                <input type="file" multiple accept="image/*,application/pdf">
                <i class="fa fa-cloud-arrow-up"></i>
                <p>Drag & drop files here, or click to browse</p>
                <small>Supports JPG, PNG, WebP, SVG, PDF &nbsp;·&nbsp; Max 10 MB per file &nbsp;·&nbsp; Multiple files allowed</small>
            </div>

            <!-- Bulk action bar -->
            <div class="bulk-bar" id="bulkBar">
                <i class="fa fa-check-square" style="color:var(--accent)"></i>
                <span class="bulk-count" id="bulkCount">0 files selected</span>
                <div style="display:flex;gap:6px;flex-wrap:wrap">
                    <button class="btn-secondary-dash" style="padding:6px 12px;font-size:12px">
                        <i class="fa fa-compress"></i> Compress
                    </button>
                    <button class="btn-secondary-dash" style="padding:6px 12px;font-size:12px">
                        <i class="fa fa-download"></i> Download
                    </button>
                    <button class="btn-danger-soft" style="padding:6px 12px;font-size:12px" onclick="confirmBulkDelete()">
                        <i class="fa fa-trash"></i> Delete Selected
                    </button>
                </div>
                <button onclick="clearSelection()" style="margin-left:auto;background:none;border:none;cursor:pointer;color:var(--text-hint);font-size:12px;font-family:var(--font)">
                    <i class="fa fa-xmark"></i> Clear
                </button>
            </div>

            <!-- Toolbar -->
            <div class="ml-toolbar">
                <div class="ml-search-wrap">
                    <i class="fa fa-search"></i>
                    <input type="text" class="ml-search" id="mlSearch" placeholder="Search by filename or alt text…" oninput="filterGrid()">
                </div>

                <select class="ml-filter-select" id="filterType" onchange="filterGrid()">
                    <option value="">All Types</option>
                    <option value="image">Images</option>
                    <option value="pdf">PDFs</option>
                    <option value="video">Videos</option>
                </select>

                <select class="ml-filter-select" id="filterUsage" onchange="filterGrid()">
                    <option value="">All Files</option>
                    <option value="used">In Use</option>
                    <option value="unused">Unused / Orphaned</option>
                </select>

                <select class="ml-filter-select" id="filterSort" onchange="filterGrid()">
                    <option value="newest">Newest First</option>
                    <option value="oldest">Oldest First</option>
                    <option value="largest">Largest Size</option>
                    <option value="smallest">Smallest Size</option>
                    <option value="name">Name A–Z</option>
                </select>

                <div class="toolbar-divider"></div>

                <div class="view-toggle">
                    <button class="view-btn active" id="btnGrid" onclick="setView('grid')" title="Grid view">
                        <i class="fa fa-grip"></i>
                    </button>
                    <button class="view-btn" id="btnList" onclick="setView('list')" title="List view">
                        <i class="fa fa-list"></i>
                    </button>
                </div>
            </div>

            <!-- ── GRID VIEW ── -->
            <div class="ml-grid" id="mlGrid">

                <!-- Item 1 -->
                <div class="ml-item" data-id="1" data-type="image" data-usage="used" data-name="product-red-shoes.jpg" onclick="openDetail(1)">
                    <div class="ml-item-check" onclick="event.stopPropagation();toggleSelect(this.closest('.ml-item'))">
                        <i class="fa fa-check"></i>
                    </div>
                    <div class="ml-item-img-wrap">
                        <img src="https://placehold.co/300x300/f0f1fc/303d89?text=IMG" loading="lazy" alt="product-red-shoes">
                        <div class="ml-item-overlay"></div>
                    </div>
                    <div class="ml-item-info">
                        <div class="ml-item-name">product-red-shoes.jpg</div>
                        <div class="ml-item-meta">
                            <span>148 KB · 800×800</span>
                            <span class="ml-item-usage used"><i class="fa fa-link" style="font-size:9px"></i> 4</span>
                        </div>
                    </div>
                </div>

                <!-- Item 2 -->
                <div class="ml-item" data-id="2" data-type="image" data-usage="unused" data-name="banner-summer.jpg" onclick="openDetail(2)">
                    <div class="ml-item-check" onclick="event.stopPropagation();toggleSelect(this.closest('.ml-item'))">
                        <i class="fa fa-check"></i>
                    </div>
                    <div class="ml-item-img-wrap">
                        <img src="https://placehold.co/300x300/fff5cc/916a00?text=IMG" loading="lazy" alt="banner-summer">
                        <div class="ml-item-overlay"></div>
                    </div>
                    <div class="ml-item-info">
                        <div class="ml-item-name">banner-summer.jpg</div>
                        <div class="ml-item-meta">
                            <span>2.1 MB · 1920×600</span>
                            <span class="ml-item-usage unused"><i class="fa fa-unlink" style="font-size:9px"></i> 0</span>
                        </div>
                    </div>
                </div>

                <!-- Item 3 -->
                <div class="ml-item" data-id="3" data-type="image" data-usage="used" data-name="category-electronics.png" onclick="openDetail(3)">
                    <div class="ml-item-check" onclick="event.stopPropagation();toggleSelect(this.closest('.ml-item'))">
                        <i class="fa fa-check"></i>
                    </div>
                    <div class="ml-item-img-wrap">
                        <img src="https://placehold.co/300x300/e3f1ec/007a5e?text=IMG" loading="lazy" alt="category-electronics">
                        <div class="ml-item-overlay"></div>
                    </div>
                    <div class="ml-item-info">
                        <div class="ml-item-name">category-electronics.png</div>
                        <div class="ml-item-meta">
                            <span>320 KB · 600×600</span>
                            <span class="ml-item-usage used"><i class="fa fa-link" style="font-size:9px"></i> 2</span>
                        </div>
                    </div>
                </div>

                <!-- Item 4 -->
                <div class="ml-item" data-id="4" data-type="image" data-usage="used" data-name="blog-hero-fashion.jpg" onclick="openDetail(4)">
                    <div class="ml-item-check" onclick="event.stopPropagation();toggleSelect(this.closest('.ml-item'))">
                        <i class="fa fa-check"></i>
                    </div>
                    <div class="ml-item-img-wrap">
                        <img src="https://placehold.co/300x300/e8f2ff/0069d9?text=IMG" loading="lazy" alt="blog-hero-fashion">
                        <div class="ml-item-overlay"></div>
                    </div>
                    <div class="ml-item-info">
                        <div class="ml-item-name">blog-hero-fashion.jpg</div>
                        <div class="ml-item-meta">
                            <span>890 KB · 1200×628</span>
                            <span class="ml-item-usage used"><i class="fa fa-link" style="font-size:9px"></i> 1</span>
                        </div>
                    </div>
                </div>

                <!-- Item 5 -->
                <div class="ml-item" data-id="5" data-type="image" data-usage="unused" data-name="old-logo-2022.png" onclick="openDetail(5)">
                    <div class="ml-item-check" onclick="event.stopPropagation();toggleSelect(this.closest('.ml-item'))">
                        <i class="fa fa-check"></i>
                    </div>
                    <div class="ml-item-img-wrap">
                        <img src="https://placehold.co/300x300/fce8e8/b22222?text=IMG" loading="lazy" alt="old-logo-2022">
                        <div class="ml-item-overlay"></div>
                    </div>
                    <div class="ml-item-info">
                        <div class="ml-item-name">old-logo-2022.png</div>
                        <div class="ml-item-meta">
                            <span>44 KB · 400×200</span>
                            <span class="ml-item-usage unused"><i class="fa fa-unlink" style="font-size:9px"></i> 0</span>
                        </div>
                    </div>
                </div>

                <!-- Item 6 -->
                <div class="ml-item" data-id="6" data-type="image" data-usage="used" data-name="product-blue-jeans.jpg" onclick="openDetail(6)">
                    <div class="ml-item-check" onclick="event.stopPropagation();toggleSelect(this.closest('.ml-item'))">
                        <i class="fa fa-check"></i>
                    </div>
                    <div class="ml-item-img-wrap">
                        <img src="https://placehold.co/300x300/f0f1fc/303d89?text=IMG" loading="lazy" alt="product-blue-jeans">
                        <div class="ml-item-overlay"></div>
                    </div>
                    <div class="ml-item-info">
                        <div class="ml-item-name">product-blue-jeans.jpg</div>
                        <div class="ml-item-meta">
                            <span>210 KB · 800×800</span>
                            <span class="ml-item-usage used"><i class="fa fa-link" style="font-size:9px"></i> 3</span>
                        </div>
                    </div>
                </div>

                <!-- Item 7 -->
                <div class="ml-item" data-id="7" data-type="pdf" data-usage="used" data-name="size-guide.pdf" onclick="openDetail(7)">
                    <div class="ml-item-check" onclick="event.stopPropagation();toggleSelect(this.closest('.ml-item'))">
                        <i class="fa fa-check"></i>
                    </div>
                    <div class="ml-item-img-wrap" style="display:flex;align-items:center;justify-content:center;background:#fff5f5">
                        <i class="fa fa-file-pdf" style="font-size:48px;color:#b22222"></i>
                        <div class="ml-item-overlay"></div>
                    </div>
                    <div class="ml-item-info">
                        <div class="ml-item-name">size-guide.pdf</div>
                        <div class="ml-item-meta">
                            <span>1.2 MB · PDF</span>
                            <span class="ml-item-usage used"><i class="fa fa-link" style="font-size:9px"></i> 6</span>
                        </div>
                    </div>
                </div>

                <!-- Item 8 -->
                <div class="ml-item" data-id="8" data-type="image" data-usage="unused" data-name="test-upload-draft.jpg" onclick="openDetail(8)">
                    <div class="ml-item-check" onclick="event.stopPropagation();toggleSelect(this.closest('.ml-item'))">
                        <i class="fa fa-check"></i>
                    </div>
                    <div class="ml-item-img-wrap">
                        <img src="https://placehold.co/300x300/f1f2f4/8c9196?text=IMG" loading="lazy" alt="test-upload-draft">
                        <div class="ml-item-overlay"></div>
                    </div>
                    <div class="ml-item-info">
                        <div class="ml-item-name">test-upload-draft.jpg</div>
                        <div class="ml-item-meta">
                            <span>56 KB · 400×400</span>
                            <span class="ml-item-usage unused"><i class="fa fa-unlink" style="font-size:9px"></i> 0</span>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /ml-grid -->

            <!-- ── LIST VIEW ── -->
            <div class="ml-list" id="mlList">
                <table class="ml-list-table">
                    <thead>
                        <tr>
                            <th style="width:30px"><input type="checkbox" id="checkAll" onchange="selectAll(this)"></th>
                            <th>Preview</th>
                            <th>Filename</th>
                            <th>Type</th>
                            <th>Dimensions</th>
                            <th>Size</th>
                            <th>Alt Text</th>
                            <th>Used In</th>
                            <th>Uploaded</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr onclick="openDetail(1)">
                            <td onclick="event.stopPropagation()"><input type="checkbox" class="row-check"></td>
                            <td><img src="https://placehold.co/46x46/f0f1fc/303d89?text=I" class="ml-thumb" alt=""></td>
                            <td><strong style="font-size:13px">product-red-shoes.jpg</strong></td>
                            <td><span class="pill pill-green">Image</span></td>
                            <td style="color:var(--text-hint);font-size:12.5px">800 × 800</td>
                            <td style="font-size:12.5px">148 KB</td>
                            <td style="font-size:12.5px;color:var(--text-secondary)">Red sports shoes product</td>
                            <td><span class="pill pill-green">4 places</span></td>
                            <td style="font-size:12px;color:var(--text-hint)">12 Jun 2025</td>
                            <td>
                                <div style="display:flex;gap:5px">
                                    <a href="#" class="action-btn" title="Edit"><i class="fa fa-pencil"></i></a>
                                    <a href="#" class="action-btn" title="Download"><i class="fa fa-download"></i></a>
                                    <button class="action-btn danger" title="Delete" onclick="event.stopPropagation()"><i class="fa fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr onclick="openDetail(2)">
                            <td onclick="event.stopPropagation()"><input type="checkbox" class="row-check"></td>
                            <td><img src="https://placehold.co/46x46/fff5cc/916a00?text=I" class="ml-thumb" alt=""></td>
                            <td><strong style="font-size:13px">banner-summer.jpg</strong></td>
                            <td><span class="pill pill-green">Image</span></td>
                            <td style="color:var(--text-hint);font-size:12.5px">1920 × 600</td>
                            <td style="font-size:12.5px">2.1 MB</td>
                            <td style="font-size:12.5px;color:var(--red)">— No alt text</td>
                            <td><span class="pill pill-red">Unused</span></td>
                            <td style="font-size:12px;color:var(--text-hint)">08 Jun 2025</td>
                            <td>
                                <div style="display:flex;gap:5px">
                                    <a href="#" class="action-btn" title="Edit"><i class="fa fa-pencil"></i></a>
                                    <a href="#" class="action-btn" title="Download"><i class="fa fa-download"></i></a>
                                    <button class="action-btn danger" title="Delete" onclick="event.stopPropagation()"><i class="fa fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr onclick="openDetail(7)">
                            <td onclick="event.stopPropagation()"><input type="checkbox" class="row-check"></td>
                            <td style="background:#fff5f5;text-align:center"><i class="fa fa-file-pdf" style="font-size:24px;color:#b22222"></i></td>
                            <td><strong style="font-size:13px">size-guide.pdf</strong></td>
                            <td><span class="pill pill-amber">PDF</span></td>
                            <td style="color:var(--text-hint);font-size:12.5px">—</td>
                            <td style="font-size:12.5px">1.2 MB</td>
                            <td style="font-size:12.5px;color:var(--text-secondary)">Size guide document</td>
                            <td><span class="pill pill-green">6 places</span></td>
                            <td style="font-size:12px;color:var(--text-hint)">01 Jun 2025</td>
                            <td>
                                <div style="display:flex;gap:5px">
                                    <a href="#" class="action-btn" title="Edit"><i class="fa fa-pencil"></i></a>
                                    <a href="#" class="action-btn" title="Download"><i class="fa fa-download"></i></a>
                                    <button class="action-btn danger" title="Delete" onclick="event.stopPropagation()"><i class="fa fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="ml-pagination">
    <span class="ml-pagination-info">Showing 1–20 of 842 files</span>
    <div>
        @if($media)
            {{ $media->links('pagination::bootstrap-4') }}
        @endif
    </div>
</div>

        </div><!-- /ml-page -->
    </div>

    <!-- ══════════════════════════════════
         DETAIL SLIDE PANEL
    ══════════════════════════════════ -->
    <div class="ml-detail-overlay" id="detailOverlay" onclick="closeDetail(event)">
        <div class="ml-detail-panel" onclick="event.stopPropagation()">
            <div class="ml-detail-header">
                <h5>File Details</h5>
                <button class="ml-close-btn" onclick="closeDetailPanel()"><i class="fa fa-xmark"></i></button>
            </div>

            <img src="https://placehold.co/360x270/f0f1fc/303d89?text=Preview" class="ml-detail-img" id="detailImg" alt="preview">

            <div class="ml-detail-body">

                <div class="ml-detail-field">
                    <div class="ml-detail-label">Filename</div>
                    <div class="ml-detail-value" id="detailName" style="font-weight:600">product-red-shoes.jpg</div>
                </div>

                <div class="ml-detail-field">
                    <div class="ml-detail-label">File Info</div>
                    <div class="ml-detail-value" style="display:flex;gap:16px;flex-wrap:wrap">
                        <span><i class="fa fa-weight-hanging" style="color:var(--text-hint);margin-right:4px"></i><span id="detailSize">148 KB</span></span>
                        <span><i class="fa fa-expand" style="color:var(--text-hint);margin-right:4px"></i><span id="detailDims">800 × 800 px</span></span>
                        <span><i class="fa fa-calendar" style="color:var(--text-hint);margin-right:4px"></i><span id="detailDate">12 Jun 2025</span></span>
                    </div>
                </div>

                <div class="ml-detail-field">
                    <div class="ml-detail-label">Alt Text <span style="color:var(--red);margin-left:2px">*</span></div>
                    <textarea class="ml-detail-input" rows="2" id="detailAlt" placeholder="Describe the image for screen readers and SEO…">Red sports shoes product image</textarea>
                    <div style="font-size:11.5px;color:var(--text-hint);margin-top:4px">Important for SEO and accessibility.</div>
                </div>

                <div class="ml-detail-field">
                    <div class="ml-detail-label">Title / Caption</div>
                    <input type="text" class="ml-detail-input" id="detailTitle" placeholder="Image title or caption" value="Red Sports Shoes">
                </div>

                <div class="ml-detail-field">
                    <div class="ml-detail-label">File URL</div>
                    <div style="display:flex;gap:6px">
                        <input type="text" class="ml-detail-input" id="detailUrl" value="/storage/media/product-red-shoes.jpg" readonly style="background:var(--bg);font-family:'SF Mono','Fira Code',monospace;font-size:12px">
                        <button onclick="copyUrl()" style="flex-shrink:0;height:36px;width:36px;border:1px solid var(--border);border-radius:var(--radius-sm);background:var(--surface);cursor:pointer;color:var(--text-secondary);display:flex;align-items:center;justify-content:center;font-size:13px" title="Copy URL">
                            <i class="fa fa-copy"></i>
                        </button>
                    </div>
                </div>

                <div class="ml-detail-field">
                    <div class="ml-detail-label">Used In</div>
                    <div id="detailUsage">
                        <a href="#" class="usage-tag"><i class="fa fa-box" style="font-size:10px"></i> Product #142</a>
                        <a href="#" class="usage-tag"><i class="fa fa-box" style="font-size:10px"></i> Product #198</a>
                        <a href="#" class="usage-tag"><i class="fa fa-tag" style="font-size:10px"></i> Category: Shoes</a>
                        <a href="#" class="usage-tag"><i class="fa fa-newspaper" style="font-size:10px"></i> Blog: Summer Sale</a>
                    </div>
                </div>

            </div>

            <div class="ml-detail-footer">
                <button class="btn-primary-dash" style="flex:1" onclick="saveDetails()">
                    <i class="fa fa-save"></i> Save Changes
                </button>
                <button class="btn-secondary-dash" onclick="downloadFile()">
                    <i class="fa fa-download"></i>
                </button>
                <button class="btn-danger-soft" onclick="deleteFile()">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
        </div>
    </div>

</div>

@include('admin.footer')

<script>
    // ── View toggle ──
    function setView(v) {
        document.getElementById('mlGrid').classList.toggle('hide', v === 'list');
        document.getElementById('mlList').classList.toggle('show', v === 'list');
        document.getElementById('btnGrid').classList.toggle('active', v === 'grid');
        document.getElementById('btnList').classList.toggle('active', v === 'list');
    }

    // ── Selection ──
    let selectedIds = new Set();

    function toggleSelect(item) {
        const id = item.dataset.id;
        if (selectedIds.has(id)) {
            selectedIds.delete(id);
            item.classList.remove('selected');
        } else {
            selectedIds.add(id);
            item.classList.add('selected');
        }
        updateBulkBar();
    }

    function updateBulkBar() {
        const bar = document.getElementById('bulkBar');
        document.getElementById('bulkCount').textContent = selectedIds.size + ' file' + (selectedIds.size !== 1 ? 's' : '') + ' selected';
        bar.classList.toggle('show', selectedIds.size > 0);
    }

    function clearSelection() {
        selectedIds.clear();
        document.querySelectorAll('.ml-item.selected').forEach(el => el.classList.remove('selected'));
        document.querySelectorAll('.row-check').forEach(cb => cb.checked = false);
        updateBulkBar();
    }

    function selectAll(cb) {
        document.querySelectorAll('.row-check').forEach(c => {
            c.checked = cb.checked;
        });
    }

    // ── Filter ──
    function filterGrid() {
        const q     = document.getElementById('mlSearch').value.toLowerCase();
        const type  = document.getElementById('filterType').value;
        const usage = document.getElementById('filterUsage').value;

        document.querySelectorAll('.ml-item').forEach(item => {
            const nameMatch  = item.dataset.name.toLowerCase().includes(q);
            const typeMatch  = !type  || item.dataset.type  === type;
            const usageMatch = !usage || item.dataset.usage === usage;
            item.style.display = (nameMatch && typeMatch && usageMatch) ? '' : 'none';
        });
    }

    // ── Detail panel ──
    function openDetail(id) {
        document.getElementById('detailOverlay').classList.add('open');
    }

    function closeDetail(e) {
        if (e.target === document.getElementById('detailOverlay')) closeDetailPanel();
    }

    function closeDetailPanel() {
        document.getElementById('detailOverlay').classList.remove('open');
    }

    function copyUrl() {
        const url = document.getElementById('detailUrl').value;
        navigator.clipboard.writeText(url).then(() => {
            Swal.fire({ icon:'success', title:'Copied!', text:'URL copied to clipboard.', timer:1400, showConfirmButton:false });
        });
    }

    function saveDetails() {
        Swal.fire({ icon:'success', title:'Saved!', text:'File details updated successfully.', timer:1600, showConfirmButton:false });
    }

    function downloadFile() {
        Swal.fire({ icon:'info', title:'Downloading…', text:'Your file download will begin shortly.', timer:1600, showConfirmButton:false });
    }

    function deleteFile() {
        Swal.fire({
            title: 'Delete File?',
            text: 'This will remove the file permanently. All links to this file will break.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#b22222',
            cancelButtonColor: '#6d7175',
            confirmButtonText: 'Yes, Delete'
        }).then(r => {
            if (r.isConfirmed) {
                closeDetailPanel();
                Swal.fire({ icon:'success', title:'Deleted!', text:'File removed from media library.', timer:1600, showConfirmButton:false });
            }
        });
    }

    function confirmBulkDelete() {
        Swal.fire({
            title: 'Delete ' + selectedIds.size + ' files?',
            text: 'This cannot be undone. All selected files will be permanently removed.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#b22222',
            cancelButtonColor: '#6d7175',
            confirmButtonText: 'Yes, Delete All'
        }).then(r => {
            if (r.isConfirmed) {
                clearSelection();
                Swal.fire({ icon:'success', title:'Deleted!', text:'Selected files removed.', timer:1600, showConfirmButton:false });
            }
        });
    }

    // ── Drag & drop highlight ──
    const dz = document.getElementById('dropzone');
    dz.addEventListener('dragover', e => { e.preventDefault(); dz.classList.add('dragover'); });
    dz.addEventListener('dragleave', () => dz.classList.remove('dragover'));
    dz.addEventListener('drop', e => { e.preventDefault(); dz.classList.remove('dragover'); });
</script>