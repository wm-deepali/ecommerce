@include('admin.top-header')
<div class="main-section">
    @include('admin.header')

    <style>
    :root {
        --sp-bg: #f1f2f4; --sp-surface: #ffffff; --sp-border: #e3e5e8; --sp-border-hover: #c9cccf;
        --sp-text-primary: #202223; --sp-text-secondary: #6d7175; --sp-text-hint: #8c9196;
        --sp-accent: #303d89; --sp-accent-hover: #2a3579; --sp-accent-light: #eef0fc;
        --sp-green: #007a5e; --sp-green-bg: #e3f1ec; --sp-green-border: #9fcfc3;
        --sp-red: #c0392b; --sp-red-bg: #fce8e8; --sp-red-border: #f5c6c6;
        --sp-amber: #916a00; --sp-amber-bg: #fff5cc; --sp-amber-border: #e8d080;
        --sp-blue: #0069d9; --sp-blue-bg: #e8f2ff;
        --sp-radius-sm: 6px; --sp-radius-md: 8px; --sp-radius-lg: 12px;
        --sp-shadow-card: 0 1px 0 rgba(0,0,0,.05), 0 0 0 1px rgba(0,0,0,.07);
        --sp-font: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }

    .sp-page { background: var(--sp-bg); padding: 24px 28px; min-height: 100vh; font-family: var(--sp-font); color: var(--sp-text-primary); font-size: 14px; }
    .sp-page * { box-sizing: border-box; }

    .sp-page-header { display: flex; align-items: flex-start; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 20px; }
    .sp-page-title  { font-size: 20px; font-weight: 660; margin: 0 0 4px; letter-spacing: -.2px; }
    .sp-crumb { font-size: 12.5px; color: var(--sp-text-hint); display: flex; align-items: center; gap: 4px; flex-wrap: wrap; }
    .sp-crumb a { color: var(--sp-accent); text-decoration: none; }
    .sp-crumb a:hover { text-decoration: underline; }

    .sp-btn-primary { display: inline-flex; align-items: center; gap: 6px; background: var(--sp-accent); color: #fff; border: 1px solid transparent; border-radius: var(--sp-radius-md); padding: 8px 16px; font-size: 13.5px; font-weight: 580; font-family: var(--sp-font); cursor: pointer; text-decoration: none; line-height: 1.4; transition: background .15s; white-space: nowrap; }
    .sp-btn-primary:hover { background: var(--sp-accent-hover); color: #fff; }
    .sp-btn-secondary { display: inline-flex; align-items: center; gap: 6px; background: var(--sp-surface); color: var(--sp-text-primary); border: 1px solid var(--sp-border); border-radius: var(--sp-radius-md); padding: 8px 14px; font-size: 13px; font-weight: 540; font-family: var(--sp-font); cursor: pointer; text-decoration: none; line-height: 1.4; transition: all .15s; white-space: nowrap; }
    .sp-btn-secondary:hover { background: var(--sp-bg); border-color: var(--sp-border-hover); }
    .sp-btn-danger { display: inline-flex; align-items: center; gap: 6px; background: var(--sp-surface); color: var(--sp-red); border: 1px solid var(--sp-red-border); border-radius: var(--sp-radius-md); padding: 8px 14px; font-size: 13px; font-weight: 540; font-family: var(--sp-font); cursor: pointer; transition: all .15s; white-space: nowrap; }
    .sp-btn-danger:hover { background: var(--sp-red-bg); }

    .sp-banner { display: flex; align-items: flex-start; gap: 12px; padding: 14px 16px; border-radius: var(--sp-radius-md); margin-bottom: 20px; font-size: 13px; }
    .sp-banner i { font-size: 15px; flex-shrink: 0; margin-top: 1px; }
    .sp-banner.blue  { background: var(--sp-blue-bg);   border: 1px solid #b8d4f5; color: var(--sp-blue); }
    .sp-banner.amber { background: var(--sp-amber-bg);  border: 1px solid var(--sp-amber-border); color: var(--sp-amber); }

    .sp-layout { display: grid; grid-template-columns: 1fr 280px; gap: 20px; align-items: start; }
    @media(max-width:960px) { .sp-layout { grid-template-columns: 1fr; } }

    .sp-card { background: var(--sp-surface); border-radius: var(--sp-radius-lg); box-shadow: var(--sp-shadow-card); border: 1px solid var(--sp-border); overflow: hidden; margin-bottom: 16px; }
    .sp-card:last-child { margin-bottom: 0; }
    .sp-card-header { padding: 13px 20px; border-bottom: 1px solid var(--sp-border); background: #fafafa; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px; }
    .sp-card-header h5 { font-size: 13px; font-weight: 650; color: var(--sp-text-primary); margin: 0; }
    .sp-card-body { padding: 20px 24px; }
    .sp-card-body-sm { padding: 14px 20px; }

    .sp-redirect-form { display: grid; grid-template-columns: 1fr 1fr 130px 44px; gap: 10px; align-items: end; padding: 16px 20px; border-bottom: 1px solid var(--sp-border); background: #f9fafb; }
    @media(max-width:700px) { .sp-redirect-form { grid-template-columns: 1fr 1fr; } }
    .sp-field { display: flex; flex-direction: column; gap: 5px; }
    .sp-label { font-size: 11px; font-weight: 650; text-transform: uppercase; letter-spacing: .05em; color: var(--sp-text-hint); }
    .sp-input, .sp-select { width: 100%; border: 1px solid var(--sp-border); border-radius: var(--sp-radius-md); padding: 0 10px; height: 36px; font-size: 13px; color: var(--sp-text-primary); background: var(--sp-surface); outline: none; font-family: var(--sp-font); transition: border-color .15s, box-shadow .15s; appearance: none; }
    .sp-input:focus, .sp-select:focus { border-color: var(--sp-accent); box-shadow: 0 0 0 3px rgba(48,61,137,.10); }
    .sp-input:hover:not(:focus), .sp-select:hover:not(:focus) { border-color: var(--sp-border-hover); }
    .sp-select-wrap { position: relative; }
    .sp-select-wrap::after { content:''; pointer-events:none; position:absolute; right:10px; top:50%; transform:translateY(-50%); width:0; height:0; border-left:4px solid transparent; border-right:4px solid transparent; border-top:5px solid var(--sp-text-hint); }
    .sp-add-btn { display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; background: var(--sp-accent); color: #fff; border: none; border-radius: var(--sp-radius-md); cursor: pointer; font-size: 14px; transition: background .15s; flex-shrink: 0; }
    .sp-add-btn:hover { background: var(--sp-accent-hover); }
    .sp-add-btn:disabled { opacity:.6; cursor:not-allowed; }

    .sp-filter-bar { padding: 10px 20px; border-bottom: 1px solid var(--sp-border); background: #fafafa; display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
    .sp-search-wrap { position: relative; flex: 1; min-width: 180px; }
    .sp-search { width: 100%; height: 32px; border: 1px solid var(--sp-border); border-radius: var(--sp-radius-md); padding: 0 10px 0 30px; font-size: 12.5px; font-family: var(--sp-font); color: var(--sp-text-primary); background: var(--sp-surface); outline: none; transition: border-color .15s; }
    .sp-search:focus { border-color: var(--sp-accent); box-shadow: 0 0 0 3px rgba(48,61,137,.10); }
    .sp-search-icon { position: absolute; left: 9px; top: 50%; transform: translateY(-50%); color: var(--sp-text-hint); font-size: 11px; pointer-events: none; }
    .sp-filter-select { height: 32px; border: 1px solid var(--sp-border); border-radius: var(--sp-radius-md); padding: 0 26px 0 10px; font-size: 12.5px; color: var(--sp-text-primary); background: var(--sp-surface); outline: none; font-family: var(--sp-font); appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%238c9196'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 8px center; }
    .sp-count-badge { font-size: 12px; color: var(--sp-text-hint); white-space: nowrap; }

    .sp-table { width: 100%; border-collapse: collapse; font-size: 13px; font-family: var(--sp-font); }
    .sp-table thead th { padding: 10px 16px; background: #fafafa; border-bottom: 1px solid var(--sp-border); font-size: 11px; font-weight: 650; letter-spacing: .055em; text-transform: uppercase; color: var(--sp-text-hint); text-align: left; white-space: nowrap; }
    .sp-table tbody tr { border-bottom: 1px solid var(--sp-border); transition: background .1s; }
    .sp-table tbody tr:last-child { border-bottom: none; }
    .sp-table tbody tr:hover { background: #f7f8f9; }
    .sp-table td { padding: 12px 16px; vertical-align: middle; }

    .sp-url { font-family: 'SF Mono','Fira Code',monospace; font-size: 12.5px; color: var(--sp-text-secondary); max-width: 260px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; display: block; }
    .sp-url-from { color: var(--sp-red); }
    .sp-url-to   { color: var(--sp-green); }
    .sp-url-arrow { color: var(--sp-text-hint); font-size: 11px; margin: 0 4px; }

    .sp-type-pill { display: inline-flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700; padding: 3px 9px; border-radius: 5px; letter-spacing: .04em; white-space: nowrap; }
    .sp-301 { background: #eef0fc; color: var(--sp-accent); border: 1px solid #c5c9f0; }
    .sp-302 { background: var(--sp-amber-bg); color: var(--sp-amber); border: 1px solid var(--sp-amber-border); }
    .sp-410 { background: var(--sp-red-bg); color: var(--sp-red); border: 1px solid var(--sp-red-border); }

    .sp-status-pill { display: inline-flex; align-items: center; gap: 4px; font-size: 11.5px; font-weight: 620; padding: 3px 9px; border-radius: 20px; white-space: nowrap; }
    .sp-status-pill::before { content:''; width:5px; height:5px; border-radius:50%; display:inline-block; flex-shrink:0; }
    .sp-active   { background: var(--sp-green-bg); color: var(--sp-green); }
    .sp-active::before   { background: var(--sp-green); }
    .sp-inactive { background: #f3f4f6; color: var(--sp-text-hint); }
    .sp-inactive::before { background: var(--sp-text-hint); }

    .sp-hits { display: inline-flex; align-items: center; gap: 4px; font-size: 12px; font-weight: 600; color: var(--sp-text-secondary); }
    .sp-hits i { font-size: 10px; color: var(--sp-text-hint); }

    .sp-actions { display: flex; gap: 5px; }
    .sp-action-btn { display: inline-flex; align-items: center; justify-content: center; width: 30px; height: 30px; border-radius: var(--sp-radius-sm); border: 1px solid var(--sp-border); background: var(--sp-surface); color: var(--sp-text-secondary); cursor: pointer; font-size: 12px; transition: all .15s; }
    .sp-action-btn:hover { background: var(--sp-bg); border-color: var(--sp-border-hover); color: var(--sp-text-primary); }
    .sp-action-btn.danger:hover { background: var(--sp-red-bg); border-color: var(--sp-red-border); color: var(--sp-red); }

    .sp-empty { padding: 48px 24px; text-align: center; color: var(--sp-text-hint); font-size: 14px; }
    .sp-empty i { font-size: 36px; color: var(--sp-border); display: block; margin-bottom: 12px; }

    .sp-info-row { display: flex; justify-content: space-between; align-items: center; padding: 9px 0; border-bottom: 1px solid var(--sp-bg); font-size: 13px; }
    .sp-info-row:first-child { padding-top: 0; }
    .sp-info-row:last-child { border-bottom: none; padding-bottom: 0; }
    .sp-info-label { color: var(--sp-text-hint); font-size: 11.5px; font-weight: 620; text-transform: uppercase; letter-spacing: .03em; }
    .sp-info-value { font-weight: 650; color: var(--sp-text-primary); }

    .sp-pagination { padding: 13px 20px; border-top: 1px solid var(--sp-border); display: flex; align-items: center; justify-content: space-between; background: var(--sp-surface); font-size: 12.5px; color: var(--sp-text-hint); flex-wrap: wrap; gap: 8px; }

    .sp-switch { position: relative; width: 36px; height: 20px; flex-shrink: 0; }
    .sp-switch input { opacity: 0; width: 0; height: 0; position: absolute; }
    .sp-switch-track { position: absolute; inset: 0; background: var(--sp-border); border-radius: 20px; cursor: pointer; transition: background .2s; }
    .sp-switch-track::after { content:''; position:absolute; left:2px; top:2px; width:16px; height:16px; background:#fff; border-radius:50%; transition:transform .2s; box-shadow:0 1px 3px rgba(0,0,0,.2); }
    .sp-switch input:checked + .sp-switch-track { background: var(--sp-accent); }
    .sp-switch input:checked + .sp-switch-track::after { transform: translateX(16px); }

    .sp-import-zone { border: 2px dashed var(--sp-border); border-radius: var(--sp-radius-md); padding: 20px; text-align: center; cursor: pointer; transition: all .15s; position: relative; }
    .sp-import-zone:hover { border-color: var(--sp-accent); background: var(--sp-accent-light); }
    .sp-import-zone input { position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%; }
    .sp-import-zone .iz-icon { font-size: 22px; color: var(--sp-text-hint); margin-bottom: 6px; }
    .sp-import-zone .iz-title { font-size: 13px; font-weight: 600; color: var(--sp-text-primary); }
    .sp-import-zone .iz-sub { font-size: 11.5px; color: var(--sp-text-hint); margin-top: 3px; }

    @media(max-width:768px) { .sp-page { padding: 16px; } }
    </style>

    <div class="app-content content container-fluid">
        <div class="sp-page">

            <!-- Page header -->
            <div class="sp-page-header">
                <div>
                    <h1 class="sp-page-title">Redirect Settings</h1>
                    <div class="sp-crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span style="color:var(--sp-border-hover)">›</span>
                        <span>Redirect Settings</span>
                    </div>
                </div>
                <div style="display:flex;gap:8px;flex-wrap:wrap">
                    <button class="sp-btn-secondary" onclick="exportCSV()">
                        <i class="fa fa-download"></i> Export CSV
                    </button>
                    <button class="sp-btn-primary" onclick="document.getElementById('addRowForm').scrollIntoView({behavior:'smooth'})">
                        <i class="fa fa-plus"></i> Add Redirect
                    </button>
                </div>
            </div>

            <!-- Info banner -->
            <div class="sp-banner blue">
                <i class="fa fa-circle-info"></i>
                <div>
                    <strong>What are redirects?</strong> When you rename a product, change a URL slug, or remove a page, the old URL becomes a dead link (404). Setting a redirect tells Google and browsers to automatically send visitors from the old URL to the new one — protecting your SEO rankings and customer experience.
                    <div style="margin-top:6px;display:flex;gap:16px;font-size:12px;flex-wrap:wrap">
                        <span><strong>301 Permanent</strong> — Page moved forever. Google transfers full SEO value to the new URL.</span>
                        <span><strong>302 Temporary</strong> — Page moved short-term. Google keeps the old URL indexed.</span>
                        <span><strong>410 Gone</strong> — Page deleted permanently. No destination needed.</span>
                    </div>
                </div>
            </div>

            <div class="sp-layout">

                <!-- LEFT — main redirect table + add form -->
                <div>

                    <!-- Main card -->
                    <div class="sp-card">

                        <div class="sp-card-header">
                            <h5><i class="fa fa-route" style="color:var(--sp-accent);margin-right:6px"></i> All Redirects</h5>
                            <div id="bulkActions" style="display:none;gap:8px">
                                <span style="font-size:12.5px;color:var(--sp-text-secondary)" id="bulkCount">0 selected</span>
                                <button class="sp-btn-danger" onclick="bulkDelete()" style="height:28px;padding:0 10px;font-size:12px"><i class="fa fa-trash"></i> Delete Selected</button>
                                <button class="sp-btn-secondary" onclick="bulkToggle('enable')" style="height:28px;padding:0 10px;font-size:12px"><i class="fa fa-check"></i> Enable</button>
                                <button class="sp-btn-secondary" onclick="bulkToggle('disable')" style="height:28px;padding:0 10px;font-size:12px"><i class="fa fa-ban"></i> Disable</button>
                            </div>
                        </div>

                        <!-- Add redirect inline form -->
                        <div class="sp-redirect-form" id="addRowForm">
                            <div class="sp-field">
                                <label class="sp-label">From URL (Old) <span style="color:var(--sp-red)">*</span></label>
                                <input type="text" id="newFrom" class="sp-input" placeholder="/old-product-name">
                            </div>
                            <div class="sp-field">
                                <label class="sp-label">To URL (New)</label>
                                <input type="text" id="newTo" class="sp-input" placeholder="/new-product-name">
                            </div>
                            <div class="sp-field">
                                <label class="sp-label">Type</label>
                                <div class="sp-select-wrap">
                                    <select id="newType" class="sp-select" onchange="toggleToUrlRequirement()">
                                        <option value="301">301 — Permanent</option>
                                        <option value="302">302 — Temporary</option>
                                        <option value="410">410 — Gone</option>
                                    </select>
                                </div>
                            </div>
                            <button type="button" class="sp-add-btn" id="addBtn" onclick="addRedirect()" title="Add Redirect">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>

                        <!-- Filter bar (GET form so filters are shareable / bookmarkable) -->
                        <form method="GET" action="{{ route('admin.redirect-settings.index') }}" id="filterForm">
                            <div class="sp-filter-bar">
                                <div class="sp-search-wrap">
                                    <i class="fa fa-search sp-search-icon"></i>
                                    <input type="text" name="search" class="sp-search" placeholder="Search URLs…" value="{{ request('search') }}" id="searchInput">
                                </div>
                                <select class="sp-filter-select" name="type" id="typeFilter" onchange="document.getElementById('filterForm').submit()">
                                    <option value="">All Types</option>
                                    <option value="301" @selected(request('type') === '301')>301</option>
                                    <option value="302" @selected(request('type') === '302')>302</option>
                                    <option value="410" @selected(request('type') === '410')>410</option>
                                </select>
                                <select class="sp-filter-select" name="status" id="statusFilter" onchange="document.getElementById('filterForm').submit()">
                                    <option value="">All Status</option>
                                    <option value="active" @selected(request('status') === 'active')>Active</option>
                                    <option value="inactive" @selected(request('status') === 'inactive')>Inactive</option>
                                </select>
                                <button type="submit" class="sp-btn-secondary" style="height:32px;padding:0 12px;font-size:12.5px"><i class="fa fa-filter"></i> Filter</button>
                                @if(request()->hasAny(['search', 'type', 'status']))
                                    <a href="{{ route('admin.redirect-settings.index') }}" class="sp-btn-secondary" style="height:32px;padding:0 12px;font-size:12.5px">Reset</a>
                                @endif
                                <span class="sp-count-badge">
                                    Showing {{ $redirects->firstItem() ?? 0 }}–{{ $redirects->lastItem() ?? 0 }} of {{ number_format($redirects->total()) }} redirects
                                </span>
                            </div>
                        </form>

                        <!-- Table -->
                        <div style="overflow-x:auto">
                            <table class="sp-table" id="redirectTable">
                                <thead>
                                    <tr>
                                        <th style="width:36px">
                                            <input type="checkbox" id="selectAll" onchange="toggleSelectAll(this)" style="cursor:pointer">
                                        </th>
                                        <th>From URL (Old)</th>
                                        <th>To URL (New)</th>
                                        <th style="width:110px">Type</th>
                                        <th style="width:90px">Hits</th>
                                        <th style="width:100px">Status</th>
                                        <th style="width:130px">Added On</th>
                                        <th style="width:90px">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="redirectBody">
                                    @forelse($redirects as $r)
                                    <tr data-id="{{ $r->id }}" data-type="{{ $r->type }}" data-status="{{ $r->is_active ? 'active' : 'inactive' }}">
                                        <td><input type="checkbox" class="row-check" value="{{ $r->id }}" onchange="updateBulk()"></td>
                                        <td>
                                            <span class="sp-url sp-url-from" title="{{ $r->from_url }}">{{ $r->from_url }}</span>
                                            @if($r->note)
                                                <span style="font-size:11px;color:var(--sp-text-hint);margin-top:2px;display:block">{{ $r->note }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($r->type === '410' || !$r->to_url)
                                                <span style="font-size:12px;color:var(--sp-text-hint);font-style:italic">None (Gone — 410)</span>
                                            @else
                                                <span class="sp-url sp-url-to" title="{{ $r->to_url }}">{{ $r->to_url }}</span>
                                            @endif
                                        </td>
                                        <td><span class="sp-type-pill sp-{{ $r->type }}">{{ $r->type }}</span></td>
                                        <td><span class="sp-hits"><i class="fa fa-mouse-pointer"></i> {{ number_format($r->hits) }}</span></td>
                                        <td>
                                            <label class="sp-switch">
                                                <input type="checkbox" {{ $r->is_active ? 'checked' : '' }} onchange="toggleStatus(this, {{ $r->id }})">
                                                <span class="sp-switch-track"></span>
                                            </label>
                                        </td>
                                        <td style="font-size:12.5px;color:var(--sp-text-hint)">{{ $r->created_at->format('d M Y') }}</td>
                                        <td>
                                            <div class="sp-actions">
                                                <button class="sp-action-btn" title="Edit" onclick="editRow(this, {{ $r->id }})"><i class="fa fa-pencil"></i></button>
                                                <button class="sp-action-btn danger" title="Delete" onclick="deleteRow(this, {{ $r->id }})"><i class="fa fa-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr id="emptyRow">
                                        <td colspan="8">
                                            <div class="sp-empty">
                                                <i class="fa fa-route"></i>
                                                No redirects found. Add one above or import a CSV below.
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="sp-pagination">
                            <span>Showing {{ $redirects->firstItem() ?? 0 }}–{{ $redirects->lastItem() ?? 0 }} of {{ number_format($redirects->total()) }} redirects</span>
                            <div>{{ $redirects->appends(request()->query())->links('pagination::bootstrap-4') }}</div>
                        </div>

                    </div>

                    <!-- Bulk Import card -->
                    <div class="sp-card">
                        <div class="sp-card-header"><h5><i class="fa fa-file-csv" style="color:var(--sp-accent);margin-right:6px"></i> Bulk Import via CSV</h5></div>
                        <div class="sp-card-body">
                            <div class="sp-banner amber" style="margin-bottom:16px">
                                <i class="fa fa-triangle-exclamation"></i>
                                <div>CSV must have 3 columns: <strong>from_url, to_url, type</strong> (301 / 302 / 410). First row should be the header. Max 1,000 rows per import.</div>
                            </div>
                            <div class="sp-import-zone" id="importZone">
                                <input type="file" accept=".csv" id="csvInput" onchange="handleCSV(this)">
                                <div class="iz-icon"><i class="fa fa-file-csv"></i></div>
                                <div class="iz-title">Click or drop CSV file here</div>
                                <div class="iz-sub">Columns: from_url, to_url, type · Max 1,000 rows</div>
                            </div>
                            <div style="margin-top:12px;display:flex;gap:8px;justify-content:flex-end">
                                <a href="{{ route('admin.redirect-settings.template') }}" class="sp-btn-secondary" style="font-size:12.5px">
                                    <i class="fa fa-download"></i> Download Template
                                </a>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- RIGHT — sidebar -->
                <div>

                    <!-- Summary -->
                    <div class="sp-card">
                        <div class="sp-card-header"><h5>Summary</h5></div>
                        <div class="sp-card-body-sm">
                            <div class="sp-info-row">
                                <span class="sp-info-label">Total Rules</span>
                                <span class="sp-info-value" id="totalCount">{{ number_format($stats['total']) }}</span>
                            </div>
                            <div class="sp-info-row">
                                <span class="sp-info-label">Active</span>
                                <span class="sp-info-value" style="color:var(--sp-green)" id="activeCount">{{ number_format($stats['active']) }}</span>
                            </div>
                            <div class="sp-info-row">
                                <span class="sp-info-label">Inactive</span>
                                <span class="sp-info-value" style="color:var(--sp-text-hint)" id="inactiveCount">{{ number_format($stats['inactive']) }}</span>
                            </div>
                            <div class="sp-info-row">
                                <span class="sp-info-label">301 Rules</span>
                                <span class="sp-info-value">{{ number_format($stats['301']) }}</span>
                            </div>
                            <div class="sp-info-row">
                                <span class="sp-info-label">302 Rules</span>
                                <span class="sp-info-value">{{ number_format($stats['302']) }}</span>
                            </div>
                            <div class="sp-info-row">
                                <span class="sp-info-label">410 Rules</span>
                                <span class="sp-info-value">{{ number_format($stats['410']) }}</span>
                            </div>
                            <div class="sp-info-row">
                                <span class="sp-info-label">Total Hits</span>
                                <span class="sp-info-value">{{ number_format($stats['hits']) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- When to use -->
                    <div class="sp-card">
                        <div class="sp-card-header"><h5>When to Use</h5></div>
                        <div class="sp-card-body-sm" style="font-size:12.5px;line-height:1.7;color:var(--sp-text-secondary)">

                            <div style="margin-bottom:12px">
                                <div style="display:inline-flex;align-items:center;gap:6px;margin-bottom:4px">
                                    <span class="sp-type-pill sp-301" style="font-size:10px">301</span>
                                    <strong style="color:var(--sp-text-primary);font-size:13px">Permanent Move</strong>
                                </div>
                                <ul style="margin:0;padding-left:16px;color:var(--sp-text-secondary)">
                                    <li>Product URL / slug changed</li>
                                    <li>Category restructured</li>
                                    <li>Old blog post URL updated</li>
                                    <li>Domain migration</li>
                                </ul>
                            </div>

                            <div style="margin-bottom:12px">
                                <div style="display:inline-flex;align-items:center;gap:6px;margin-bottom:4px">
                                    <span class="sp-type-pill sp-302" style="font-size:10px">302</span>
                                    <strong style="color:var(--sp-text-primary);font-size:13px">Temporary Move</strong>
                                </div>
                                <ul style="margin:0;padding-left:16px;color:var(--sp-text-secondary)">
                                    <li>Seasonal sale page</li>
                                    <li>A/B test landing page</li>
                                    <li>Maintenance redirect</li>
                                </ul>
                            </div>

                            <div>
                                <div style="display:inline-flex;align-items:center;gap:6px;margin-bottom:4px">
                                    <span class="sp-type-pill sp-410" style="font-size:10px">410</span>
                                    <strong style="color:var(--sp-text-primary);font-size:13px">Gone (Deleted)</strong>
                                </div>
                                <ul style="margin:0;padding-left:16px;color:var(--sp-text-secondary)">
                                    <li>Product discontinued</li>
                                    <li>Page permanently removed</li>
                                    <li>Tells Google to deindex fast</li>
                                </ul>
                            </div>

                        </div>
                    </div>

                    <!-- SEO Tips -->
                    <div class="sp-card">
                        <div class="sp-card-header"><h5>SEO Tips</h5></div>
                        <div class="sp-card-body-sm" style="font-size:12.5px;line-height:1.8;color:var(--sp-text-secondary)">
                            <div style="display:flex;gap:7px;margin-bottom:8px">
                                <i class="fa fa-circle-check" style="color:var(--sp-green);margin-top:2px;flex-shrink:0"></i>
                                <span>Use <strong style="color:var(--sp-text-primary)">301</strong> for all permanent URL changes — Google passes ~99% link equity.</span>
                            </div>
                            <div style="display:flex;gap:7px;margin-bottom:8px">
                                <i class="fa fa-circle-check" style="color:var(--sp-green);margin-top:2px;flex-shrink:0"></i>
                                <span>Avoid <strong style="color:var(--sp-text-primary)">redirect chains</strong> — A→B→C hurts crawl speed. Always go A→C directly.</span>
                            </div>
                            <div style="display:flex;gap:7px;margin-bottom:8px">
                                <i class="fa fa-circle-check" style="color:var(--sp-green);margin-top:2px;flex-shrink:0"></i>
                                <span>Add redirects <strong style="color:var(--sp-text-primary)">before</strong> changing URLs in your product/page settings.</span>
                            </div>
                            <div style="display:flex;gap:7px">
                                <i class="fa fa-circle-check" style="color:var(--sp-green);margin-top:2px;flex-shrink:0"></i>
                                <span>Submit an updated sitemap to <a href="https://search.google.com/search-console" target="_blank" style="color:var(--sp-accent);font-weight:600">Google Search Console</a> after major changes.</span>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
</div>

@include('admin.footer')

<script>
const CSRF_TOKEN = '{{ csrf_token() }}';
const ROUTES = {
    store:      '{{ route("admin.redirect-settings.store") }}',
    update:     id => `{{ url("admin/redirect-settings") }}/${id}`,
    destroy:    id => `{{ url("admin/redirect-settings") }}/${id}`,
    bulkDelete: '{{ route("admin.redirect-settings.bulk-delete") }}',
    bulkToggle: '{{ route("admin.redirect-settings.bulk-toggle") }}',
    toggle:     id => `{{ url("admin/redirect-settings") }}/${id}/toggle`,
    export:     '{{ route("admin.redirect-settings.export") }}',
    template:   '{{ route("admin.redirect-settings.template") }}',
    import:     '{{ route("admin.redirect-settings.import") }}',
};

function toggleToUrlRequirement() {
    const type = document.getElementById('newType').value;
    const toInput = document.getElementById('newTo');
    toInput.placeholder = type === '410' ? 'Not needed for 410' : '/new-product-name';
}

/* ── Add new redirect (real POST) ── */
function addRedirect() {
    const from = document.getElementById('newFrom').value.trim();
    const to   = document.getElementById('newTo').value.trim();
    const type = document.getElementById('newType').value;
    const btn  = document.getElementById('addBtn');

    if (!from) {
        Swal.fire({ icon:'warning', title:'From URL required', text:'Please enter the old URL to redirect from.', timer:2000, showConfirmButton:false });
        return;
    }
    if (type !== '410' && !to) {
        Swal.fire({ icon:'warning', title:'To URL required', text:'Please enter the destination URL (not needed for 410 Gone).', timer:2000, showConfirmButton:false });
        return;
    }

    btn.disabled = true;
    fetch(ROUTES.store, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN, 'Accept': 'application/json' },
        body: JSON.stringify({ from_url: from, to_url: to, type })
    })
    .then(r => r.json())
    .then(data => {
        btn.disabled = false;
        if (data.success) {
            document.getElementById('newFrom').value = '';
            document.getElementById('newTo').value   = '';
            Swal.fire({ icon:'success', title:'Redirect Added', text:`${from} → ${type === '410' ? '(Gone)' : to} [${type}]`, timer:1800, showConfirmButton:false })
                .then(() => window.location.reload());
        } else {
            const msg = data.errors ? Object.values(data.errors).flat().join(', ') : 'Something went wrong.';
            Swal.fire({ icon:'error', title:'Could not add redirect', text: msg });
        }
    })
    .catch(() => {
        btn.disabled = false;
        Swal.fire({ icon:'error', title:'Network error', text:'Could not reach the server.' });
    });
}

/* ── Delete row (real DELETE) ── */
function deleteRow(btn, id) {
    Swal.fire({
        title:'Delete Redirect?',
        text:'This will permanently remove this redirect rule.',
        icon:'warning', showCancelButton:true,
        confirmButtonColor:'#c0392b', cancelButtonColor:'#6d7175',
        confirmButtonText:'Yes, Delete'
    }).then(r => {
        if (!r.isConfirmed) return;
        fetch(ROUTES.destroy(id), {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': CSRF_TOKEN, 'Accept': 'application/json' }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                const row = btn.closest('tr');
                row.style.transition = 'opacity .2s';
                row.style.opacity = '0';
                setTimeout(() => window.location.reload(), 250);
            } else {
                Swal.fire({ icon:'error', title:'Delete failed' });
            }
        });
    });
}

/* ── Edit row (real PUT) ── */
function editRow(btn, id) {
    const row   = btn.closest('tr');
    const fromEl = row.querySelector('.sp-url-from');
    const toEl   = row.querySelector('.sp-url-to');
    const typeEl = row.querySelector('.sp-type-pill');
    if (!fromEl) return;

    const oldFrom = fromEl.textContent.trim();
    const oldTo   = toEl ? toEl.textContent.trim() : '';
    const oldType = typeEl ? typeEl.textContent.trim() : '301';

    Swal.fire({
        title:'Edit Redirect',
        html:`
            <div style="text-align:left;margin-bottom:8px">
                <label style="font-size:11px;font-weight:700;text-transform:uppercase;color:#8c9196;letter-spacing:.05em;display:block;margin-bottom:4px">From URL</label>
                <input id="swal-from" class="swal2-input" style="margin:0;width:100%" value="${oldFrom}">
            </div>
            <div style="text-align:left;margin-bottom:8px">
                <label style="font-size:11px;font-weight:700;text-transform:uppercase;color:#8c9196;letter-spacing:.05em;display:block;margin-bottom:4px">To URL</label>
                <input id="swal-to" class="swal2-input" style="margin:0;width:100%" value="${oldTo === 'None (Gone — 410)' ? '' : oldTo}">
            </div>
            <div style="text-align:left">
                <label style="font-size:11px;font-weight:700;text-transform:uppercase;color:#8c9196;letter-spacing:.05em;display:block;margin-bottom:4px">Type</label>
                <select id="swal-type" class="swal2-input" style="margin:0;width:100%;height:38px">
                    <option value="301" ${oldType==='301'?'selected':''}>301 — Permanent</option>
                    <option value="302" ${oldType==='302'?'selected':''}>302 — Temporary</option>
                    <option value="410" ${oldType==='410'?'selected':''}>410 — Gone</option>
                </select>
            </div>`,
        showCancelButton:true,
        confirmButtonColor:'#303d89',
        confirmButtonText:'Save',
        focusConfirm:false,
        preConfirm:() => ({
            from: document.getElementById('swal-from').value.trim(),
            to:   document.getElementById('swal-to').value.trim(),
            type: document.getElementById('swal-type').value
        })
    }).then(r => {
        if (!r.isConfirmed) return;
        const { from, to, type } = r.value;
        if (!from) return;

        fetch(ROUTES.update(id), {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN, 'Accept': 'application/json' },
            body: JSON.stringify({ from_url: from, to_url: to, type })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                Swal.fire({ icon:'success', title:'Updated!', timer:1200, showConfirmButton:false })
                    .then(() => window.location.reload());
            } else {
                const msg = data.errors ? Object.values(data.errors).flat().join(', ') : 'Something went wrong.';
                Swal.fire({ icon:'error', title:'Update failed', text: msg });
            }
        });
    });
}

/* ── Toggle enable/disable (real POST) ── */
function toggleStatus(chk, id) {
    const row = chk.closest('tr');
    const prevChecked = !chk.checked; // state before this click

    fetch(ROUTES.toggle(id), {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': CSRF_TOKEN, 'Accept': 'application/json' }
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            row.setAttribute('data-status', data.is_active ? 'active' : 'inactive');
            chk.checked = data.is_active;
            updateCountsFromDom();
        } else {
            chk.checked = prevChecked; // revert on failure
            Swal.fire({ icon:'error', title:'Could not update status' });
        }
    })
    .catch(() => { chk.checked = prevChecked; });
}

/* ── Bulk selection ── */
function toggleSelectAll(chk) {
    document.querySelectorAll('.row-check').forEach(c => {
        if (c.closest('tr').style.display !== 'none') c.checked = chk.checked;
    });
    updateBulk();
}
function updateBulk() {
    const checked = document.querySelectorAll('.row-check:checked').length;
    const bar = document.getElementById('bulkActions');
    bar.style.display = checked > 0 ? 'flex' : 'none';
    document.getElementById('bulkCount').textContent = checked + ' selected';
}
function getSelectedIds() {
    return [...document.querySelectorAll('.row-check:checked')].map(c => c.value);
}

/* ── Bulk delete (real POST) ── */
function bulkDelete() {
    const ids = getSelectedIds();
    if (!ids.length) return;
    Swal.fire({
        title:`Delete ${ids.length} redirect(s)?`, icon:'warning',
        showCancelButton:true, confirmButtonColor:'#c0392b', confirmButtonText:'Yes, Delete All'
    }).then(r => {
        if (!r.isConfirmed) return;
        fetch(ROUTES.bulkDelete, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN, 'Accept': 'application/json' },
            body: JSON.stringify({ ids })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                Swal.fire({ icon:'success', title:'Deleted!', timer:1200, showConfirmButton:false })
                    .then(() => window.location.reload());
            } else {
                Swal.fire({ icon:'error', title:'Bulk delete failed' });
            }
        });
    });
}

/* ── Bulk enable/disable (real POST) ── */
function bulkToggle(action) {
    const ids = getSelectedIds();
    if (!ids.length) return;
    fetch(ROUTES.bulkToggle, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN, 'Accept': 'application/json' },
        body: JSON.stringify({ ids, action })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            window.location.reload();
        } else {
            Swal.fire({ icon:'error', title:'Bulk update failed' });
        }
    });
}

/* ── Client-side row count (used only for the status toggle's instant UI feedback) ── */
function updateCountsFromDom() {
    const total    = document.querySelectorAll('#redirectBody tr[data-id]').length;
    const active   = document.querySelectorAll('#redirectBody tr[data-status="active"]').length;
    document.getElementById('totalCount').textContent    = total;
    document.getElementById('activeCount').textContent   = active;
    document.getElementById('inactiveCount').textContent = total - active;
}

/* ── CSV export (server-generated, real data) ── */
function exportCSV() {
    window.location.href = ROUTES.export;
}

/* ── Download template ── */
function downloadTemplate() {
    window.location.href = ROUTES.template;
}

/* ── CSV import (real upload) ── */
function handleCSV(input) {
    const file = input.files[0];
    if (!file) return;

    const formData = new FormData();
    formData.append('csv_file', file);

    Swal.fire({
        title: 'Importing…',
        text: `Uploading "${file.name}"`,
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading()
    });

    fetch(ROUTES.import, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': CSRF_TOKEN, 'Accept': 'application/json' },
        body: formData
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Import Complete',
                html: `Imported <strong>${data.imported}</strong> redirects.${data.skipped ? ` Skipped <strong>${data.skipped}</strong> invalid rows.` : ''}`,
                confirmButtonColor: '#303d89'
            }).then(() => window.location.reload());
        } else {
            Swal.fire({ icon:'error', title:'Import failed', text: data.message || 'Please check your CSV format.' });
        }
    })
    .catch(() => {
        Swal.fire({ icon:'error', title:'Network error', text:'Could not reach the server.' });
    });

    input.value = ''; // reset file input
}

document.addEventListener('DOMContentLoaded', updateBulk);
</script>