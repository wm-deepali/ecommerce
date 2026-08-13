@include('admin.top-header')
<div class="main-section">
    @include('admin.header')

    <style>
    :root {
        --bg: #f1f2f4;
        --surface: #ffffff;
        --surface-subdued: #fafafa;
        --border: #e3e5e8;
        --border-subdued: #eeeff1;
        --text-primary: #202223;
        --text-secondary: #6d7175;
        --text-hint: #8c9196;
        --text-disabled: #babec3;
        --navy: #303d89;
        --navy-hovered: #252f70;
        --navy-pressed: #1c245a;
        --navy-subdued: #f0f1fc;
        --green: #007a5e;
        --green-bg: #e3f1ec;
        --green-border: #9fcfc3;
        --red: #b22222;
        --red-bg: #fce8e8;
        --red-border: #f5c6c6;
        --red-hovered: #961c1c;
        --amber: #916a00;
        --amber-bg: #fff5cc;
        --radius-sm: 8px;
        --radius-md: 12px;
        --shadow-card: 0 1px 3px rgba(0,0,0,.08), 0 0 0 1px var(--border);
        --shadow-sm: 0 1px 2px rgba(0,0,0,.06);
        --font: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }

    .sp-page { background: var(--bg); padding: 24px 28px; min-height: 100vh; font-family: var(--font); color: var(--text-primary); font-size: 14px; line-height: 1.5; }
    .sp-page * { box-sizing: border-box; }

    /* ── Page header ── */
    .sp-page-header { display: flex; align-items: flex-start; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 20px; }
    .sp-page-title { font-size: 20px; font-weight: 650; color: var(--text-primary); margin: 0 0 3px; }
    .sp-breadcrumb { display: flex; align-items: center; gap: 4px; font-size: 12.5px; color: var(--text-hint); flex-wrap: wrap; }
    .sp-breadcrumb a { color: var(--navy); text-decoration: none; font-weight: 500; }
    .sp-breadcrumb a:hover { text-decoration: underline; }
    .sp-breadcrumb-sep { color: var(--text-disabled); }

    /* ── Primary button (navy) ── */
    .sp-btn { display: inline-flex; align-items: center; justify-content: center; gap: 6px; height: 36px; padding: 0 16px; border-radius: var(--radius-sm); font-family: var(--font); font-size: 13px; font-weight: 600; line-height: 1; cursor: pointer; border: 1px solid transparent; text-decoration: none; transition: background .12s ease, box-shadow .12s ease; white-space: nowrap; user-select: none; }
    .sp-btn svg { width: 14px; height: 14px; flex-shrink: 0; }
    .sp-btn-navy { background: var(--navy); border-color: var(--navy-pressed); color: #ffffff; box-shadow: 0 1px 3px rgba(48,61,137,.30); }
    .sp-btn-navy:hover { background: var(--navy-hovered); color: #ffffff; text-decoration: none; box-shadow: 0 2px 5px rgba(48,61,137,.35); }
    .sp-btn-navy:active { background: var(--navy-pressed); box-shadow: none; }

    /* ── Alert ── */
    .sp-alert { display: flex; gap: 10px; padding: 11px 14px; border-radius: var(--radius-sm); margin-bottom: 16px; font-size: 13px; line-height: 1.5; }
    .sp-alert-success { background: var(--green-bg); border: 1px solid var(--green-border); color: var(--green); }
    .sp-alert-icon { flex-shrink: 0; margin-top: 1px; }

    /* ── Main card ── */
    .sp-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-md); box-shadow: var(--shadow-card); overflow: hidden; }

    /* ── Table ── */
    .sp-table { width: 100%; border-collapse: collapse; font-size: 13px; font-family: var(--font); }
    .sp-table thead th { font-size: 11px; font-weight: 650; letter-spacing: .06em; text-transform: uppercase; color: var(--text-hint); padding: 11px 16px; border-bottom: 1px solid var(--border); background: var(--surface-subdued); text-align: left; white-space: nowrap; }
    .sp-table tbody tr { border-bottom: 1px solid var(--border-subdued); transition: background .1s; }
    .sp-table tbody tr:last-child { border-bottom: none; }
    .sp-table tbody tr:hover { background: #f8f9fb; }
    .sp-table td { padding: 13px 16px; color: var(--text-primary); vertical-align: middle; }

    /* ── ID chip ── */
    .sp-id-chip { display: inline-flex; align-items: center; justify-content: center; min-width: 28px; height: 26px; padding: 0 8px; background: var(--navy-subdued); border: 1px solid rgba(48,61,137,.15); border-radius: var(--radius-sm); font-size: 12px; font-weight: 650; color: var(--navy); font-family: 'SF Mono','Fira Code',monospace; }

    /* ── Thumbnail ── */
    .sp-thumb { width: 88px; height: 54px; object-fit: cover; border-radius: var(--radius-sm); border: 1px solid var(--border); display: block; background: var(--bg); }
    .sp-thumb-empty { width: 88px; height: 54px; border-radius: var(--radius-sm); border: 1px dashed var(--border); background: var(--bg); display: flex; align-items: center; justify-content: center; }
    .sp-thumb-empty svg { width: 18px; height: 18px; fill: var(--text-disabled); }

    /* ── Cell text ── */
    .sp-cell-title { font-weight: 600; color: var(--text-primary); max-width: 200px; }
    .sp-cell-text { color: var(--text-secondary); max-width: 160px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .sp-cell-muted { color: var(--text-disabled); }

    /* ── Sort badge ── */
    .sp-sort-badge { display: inline-flex; align-items: center; justify-content: center; min-width: 28px; height: 24px; padding: 0 8px; background: var(--navy-subdued); border: 1px solid rgba(48,61,137,.15); border-radius: var(--radius-sm); font-size: 12px; font-weight: 650; color: var(--navy); font-family: 'SF Mono','Fira Code',monospace; }

    /* ── Status pill ── */
    .sp-pill { display: inline-flex; align-items: center; gap: 5px; font-size: 11.5px; font-weight: 600; padding: 3px 10px; border-radius: 20px; white-space: nowrap; }
    .sp-pill-dot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
    .sp-pill-active { background: var(--green-bg); color: var(--green); border: 1px solid var(--green-border); }
    .sp-pill-active .sp-pill-dot { background: var(--green); }
    .sp-pill-inactive { background: var(--amber-bg); color: var(--amber); border: 1px solid #e8d080; }
    .sp-pill-inactive .sp-pill-dot { background: var(--amber); }

    /* ── Row actions ── */
    .sp-row-actions { display: flex; align-items: center; gap: 5px; justify-content: center; }
    .sp-action-btn { display: inline-flex; align-items: center; justify-content: center; width: 30px; height: 30px; border-radius: var(--radius-sm); border: 1px solid var(--border); background: var(--surface); color: var(--text-secondary); cursor: pointer; text-decoration: none; transition: all .12s; flex-shrink: 0; box-shadow: var(--shadow-sm); }
    .sp-action-btn svg { width: 13px; height: 13px; }
    .sp-action-btn:hover { background: var(--bg); color: var(--text-primary); text-decoration: none; border-color: #c8cacf; }
    .sp-action-btn-danger:hover { background: var(--red-bg); border-color: var(--red-border); color: var(--red-hovered); }

    /* ── Empty state ── */
    .sp-empty { padding: 52px 24px; text-align: center; }
    .sp-empty-icon { width: 48px; height: 48px; background: var(--bg); border: 1px solid var(--border); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 14px; }
    .sp-empty-icon svg { width: 20px; height: 20px; fill: var(--text-disabled); }
    .sp-empty-title { font-size: 14px; font-weight: 650; color: var(--text-primary); margin: 0 0 4px; }
    .sp-empty-sub { font-size: 13px; color: var(--text-secondary); margin: 0 0 16px; }

    /* ── Pagination ── */
    .sp-pagination-bar { padding: 13px 20px; border-top: 1px solid var(--border); display: flex; justify-content: center; background: var(--surface); }

    @media (max-width: 768px) {
        .sp-page { padding: 16px; }
        .sp-table thead th, .sp-table td { padding: 10px 12px; }
    }
    </style>

    <div class="app-content content container-fluid">
        <div class="sp-page">

            <!-- Page header -->
            <div class="sp-page-header">
                <div>
                    <h1 class="sp-page-title">Hero Side Banners</h1>
                    <nav class="sp-breadcrumb" aria-label="Breadcrumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span class="sp-breadcrumb-sep">›</span>
                        <a href="{{ route('admin.home-page.index') }}">Home Page</a>
                        <span class="sp-breadcrumb-sep">›</span>
                        <span>Hero Side Banners</span>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('admin.home-hero-banners.create') }}" class="sp-btn sp-btn-navy">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z"/>
                        </svg>
                        Add Hero Banner
                    </a>
                </div>
            </div>

            <!-- Success alert -->
            @if(session('success'))
                <div class="sp-alert sp-alert-success" role="alert">
                    <span class="sp-alert-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd"/>
                        </svg>
                    </span>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Main card -->
            <div class="sp-card">
                <div class="table-responsive">
                    <table class="sp-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Small Text</th>
                                <th>Title</th>
                                <th>Button Text</th>
                                <th style="text-align:center">Sort Order</th>
                                <th>Status</th>
                                <th style="text-align:center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($items as $item)
                                <tr id="row{{ $item->id }}">

                                    <td><span class="sp-id-chip">{{ $item->id }}</span></td>

                                    <td>
                                        @if($item->image)
                                            <img src="{{ asset('storage/'.$item->image) }}"
                                                 class="sp-thumb" alt="Banner #{{ $item->id }}">
                                        @else
                                            <div class="sp-thumb-empty">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                    <path d="M2.5 4A1.5 1.5 0 0 0 1 5.5v9A1.5 1.5 0 0 0 2.5 16h15a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 17.5 4h-15ZM13 9a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm-8.5 6 3.22-3.22a.75.75 0 0 1 1.06 0L10 12.94l1.72-1.72a.75.75 0 0 1 1.06 0L15.5 14H4.5Z"/>
                                                </svg>
                                            </div>
                                        @endif
                                    </td>

                                    <td>
                                        @if($item->small_text)
                                            <span class="sp-cell-text">{{ $item->small_text }}</span>
                                        @else
                                            <span class="sp-cell-muted">—</span>
                                        @endif
                                    </td>

                                    <td><span class="sp-cell-title">{{ $item->title }}</span></td>

                                    <td><span class="sp-cell-text">{{ $item->button_text }}</span></td>

                                    <td style="text-align:center">
                                        <span class="sp-sort-badge">{{ $item->sort_order }}</span>
                                    </td>

                                    <td>
                                        @if($item->status)
                                            <span class="sp-pill sp-pill-active"><span class="sp-pill-dot"></span>Active</span>
                                        @else
                                            <span class="sp-pill sp-pill-inactive"><span class="sp-pill-dot"></span>Inactive</span>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="sp-row-actions">
                                            <a href="{{ route('admin.home-hero-banners.edit', $item->id) }}"
                                               class="sp-action-btn" title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M5.433 13.917l1.262-3.155A4 4 0 0 1 7.58 9.42l6.92-6.918a2.121 2.121 0 0 1 3 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 0 1-.65-.65Z"/>
                                                    <path d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0 0 10 3H4.75A2.75 2.75 0 0 0 2 5.75v9.5A2.75 2.75 0 0 0 4.75 18h9.5A2.75 2.75 0 0 0 17 15.25V10a.75.75 0 0 0-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5Z"/>
                                                </svg>
                                            </a>
                                            <button class="sp-action-btn sp-action-btn-danger"
                                                onclick="deleteItem({{ $item->id }})" title="Delete">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z" clip-rule="evenodd"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">
                                        <div class="sp-empty">
                                            <div class="sp-empty-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                    <path d="M2.5 4A1.5 1.5 0 0 0 1 5.5v9A1.5 1.5 0 0 0 2.5 16h15a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 17.5 4h-15ZM13 9a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm-8.5 6 3.22-3.22a.75.75 0 0 1 1.06 0L10 12.94l1.72-1.72a.75.75 0 0 1 1.06 0L15.5 14H4.5Z"/>
                                                </svg>
                                            </div>
                                            <p class="sp-empty-title">No hero banners yet</p>
                                            <p class="sp-empty-sub">Add your first hero banner to get started.</p>
                                            <a href="{{ route('admin.home-hero-banners.create') }}" class="sp-btn sp-btn-navy">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z"/>
                                                </svg>
                                                Add Hero Banner
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="sp-pagination-bar">
                    {{ $items->links('pagination::bootstrap-4') }}
                </div>
            </div>

        </div>
    </div>
</div>

@include('admin.footer')

<script>
function deleteItem(id) {
    Swal.fire({
        title: 'Delete Hero Banner?',
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#b22222',
        cancelButtonColor: '#6d7175',
        confirmButtonText: 'Yes, Delete'
    })
    .then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                               url: "{{ url('admin/home-hero-banners') }}/" + id,

                type: 'DELETE',
                data: { _token: "{{ csrf_token() }}" },
                success: function(res) {
                    Swal.fire('Deleted!', res.message, 'success');
                    $("#row" + id).fadeOut(300, function () { $(this).remove(); });
                }
            });
        }
    });
}
</script>