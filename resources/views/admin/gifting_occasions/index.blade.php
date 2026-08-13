@include('admin.top-header')

<div class="main-section">
    @include('admin.header')

    <style>
    /* ── Design Tokens ──────────────────────────────────────── */
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

    .list-page { background: var(--bg); padding: 24px 28px; min-height: 100vh; font-family: var(--font); color: var(--text-primary); }
    .list-page * { box-sizing: border-box; }

    /* ── Page header ────────────────────────────────────────── */
    .list-page-header { display: flex; align-items: flex-start; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 20px; }
    .list-page-header h1 { font-size: 20px; font-weight: 650; color: var(--text-primary); margin: 0; }
    .crumb { font-size: 12.5px; color: var(--text-hint); margin-top: 3px; }
    .crumb a { color: var(--accent); text-decoration: none; }
    .crumb a:hover { text-decoration: underline; }
    .crumb span { margin: 0 5px; }

    /* ── Buttons ────────────────────────────────────────────── */
    .btn-primary-dash {
        display: inline-flex; align-items: center; gap: 6px;
        background: var(--accent); color: #fff !important; border: none;
        border-radius: var(--radius-sm); padding: 8px 16px;
        font-size: 13px; font-weight: 600; cursor: pointer;
        text-decoration: none !important; font-family: var(--font);
        transition: background .15s; box-shadow: 0 1px 3px rgba(48,61,137,.25);
        white-space: nowrap;
    }
    .btn-primary-dash:hover { background: #252f70; }

    .btn-secondary-dash {
        display: inline-flex; align-items: center; gap: 6px;
        background: var(--surface); color: var(--text-primary) !important;
        border: 1px solid var(--border); border-radius: var(--radius-sm);
        padding: 8px 16px; font-size: 13px; font-weight: 500; cursor: pointer;
        text-decoration: none !important; font-family: var(--font);
        transition: background .15s; white-space: nowrap;
    }
    .btn-secondary-dash:hover { background: var(--bg); }

    /* ── Main card ──────────────────────────────────────────── */
    .list-card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius-md); box-shadow: var(--shadow-card);
        overflow: hidden;
    }

    /* ── Table ──────────────────────────────────────────────── */
    .data-table { width: 100%; border-collapse: collapse; }

    .data-table thead tr { background: #fafafa; border-bottom: 1px solid var(--border); }
    .data-table thead th {
        padding: 10px 16px; font-size: 11px; font-weight: 650;
        text-transform: uppercase; letter-spacing: .05em;
        color: var(--text-secondary); white-space: nowrap;
    }

    .data-table tbody tr { border-bottom: 1px solid var(--border); transition: background .12s; }
    .data-table tbody tr:last-child { border-bottom: none; }
    .data-table tbody tr:hover { background: #fafbfc; }
    .data-table td { padding: 12px 16px; font-size: 13px; color: var(--text-primary); vertical-align: middle; }

    /* ── ID chip ────────────────────────────────────────────── */
    .id-chip {
        display: inline-block; background: var(--bg); border: 1px solid var(--border);
        border-radius: 6px; padding: 2px 8px; font-size: 11.5px;
        font-family: 'SF Mono', 'Fira Mono', monospace; color: var(--text-secondary);
    }

    /* ── Thumbnail ──────────────────────────────────────────── */
    .occ-img {
        width: 48px; height: 48px; border-radius: var(--radius-sm);
        object-fit: cover; border: 1px solid var(--border); display: block;
    }
    .occ-img-placeholder {
        width: 48px; height: 48px; border-radius: var(--radius-sm);
        background: var(--bg); border: 1px solid var(--border);
        display: flex; align-items: center; justify-content: center;
        color: var(--text-hint); font-size: 16px;
    }

    /* ── Item title ─────────────────────────────────────────── */
    .item-title { font-size: 13.5px; font-weight: 600; color: var(--text-primary); }

    /* ── Status pills ───────────────────────────────────────── */
    .pill {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 3px 10px; border-radius: 20px; font-size: 11.5px; font-weight: 600;
    }
    .pill::before { content: ''; width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
    .pill-active   { background: var(--green-bg); color: var(--green); }
    .pill-active::before   { background: var(--green); }
    .pill-inactive { background: var(--red-bg);   color: var(--red);   }
    .pill-inactive::before { background: var(--red); }

    /* ── Action buttons ─────────────────────────────────────── */
    .action-btn {
        display: inline-flex; align-items: center; justify-content: center;
        width: 30px; height: 30px; border-radius: var(--radius-sm);
        border: 1px solid var(--border); background: var(--surface);
        color: var(--text-secondary); cursor: pointer; text-decoration: none;
        transition: all .15s; font-size: 12px;
    }
    .action-btn:hover         { background: var(--bg); color: var(--text-primary); border-color: #c9cccf; }
    .action-btn.danger:hover  { background: var(--red-bg); color: var(--red); border-color: #f5c0c0; }

    /* ── Empty state ────────────────────────────────────────── */
    .empty-state { text-align: center; padding: 56px 24px; }
    .empty-icon-wrap {
        width: 56px; height: 56px; border-radius: 50%;
        background: var(--accent-light); margin: 0 auto 16px;
        display: flex; align-items: center; justify-content: center;
        color: var(--accent); font-size: 22px;
    }
    .empty-state h6   { font-size: 14px; font-weight: 650; color: var(--text-primary); margin: 0 0 6px; }
    .empty-state p    { font-size: 13px; color: var(--text-hint); margin: 0 0 20px; }

    /* ── Pagination ─────────────────────────────────────────── */
    .pagination-bar { padding: 14px 20px; border-top: 1px solid var(--border); }
    .pagination-bar .pagination { margin: 0; }
    .pagination-bar .page-link  { border-color: var(--border); color: var(--accent); font-size: 13px; border-radius: var(--radius-sm) !important; margin: 0 2px; }
    .pagination-bar .page-item.active .page-link { background: var(--accent); border-color: var(--accent); color: #fff; }
    .pagination-bar .page-item.disabled .page-link { color: var(--text-hint); }

    @media(max-width:768px) { .list-page { padding: 16px; } }
    </style>

    <div class="app-content content container-fluid">
        <div class="list-page">

            <!-- Page header -->
            <div class="list-page-header">
                <div>
                    <h1>Gifting Occasions</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        Gifting Occasions
                    </div>
                </div>
                <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap">
                    <a href="{{ route('admin.gifting-occasions.import') }}" class="btn-secondary-dash">
                        <i class="fa fa-upload"></i> Bulk Import
                    </a>
                    <a href="{{ route('admin.gifting-occasions.create') }}" class="btn-primary-dash">
                        <i class="fa fa-plus"></i> Add Occasion
                    </a>
                </div>
            </div>

            <!-- Main card -->
            <div class="list-card">

                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th style="width:60px">ID</th>
                                <th style="width:80px">Image</th>
                                <th>Title</th>
                                <th style="width:120px">Status</th>
                                <th style="width:100px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse($occasions as $item)
                                <tr id="row{{ $item->id }}">

                                    <td><span class="id-chip">{{ $item->id }}</span></td>

                                    <td>
                                        @if($item->image)
                                            <img src="{{ asset('storage/' . $item->image) }}" class="occ-img" alt="{{ $item->title }}">
                                        @else
                                            <div class="occ-img-placeholder"><i class="fa fa-image"></i></div>
                                        @endif
                                    </td>

                                    <td>
                                        <span class="item-title">{{ $item->title }}</span>
                                    </td>

                                    <td>
                                        @if($item->status)
                                            <span class="pill pill-active">Active</span>
                                        @else
                                            <span class="pill pill-inactive">Inactive</span>
                                        @endif
                                    </td>

                                    <td>
                                        <div style="display:flex;gap:6px">
                                            <a href="{{ route('admin.gifting-occasions.edit', $item->id) }}"
                                               class="action-btn" title="Edit">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <button class="action-btn danger" title="Delete"
                                                onclick="deleteItem({{ $item->id }})">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>

                                </tr>

                            @empty
                                <tr>
                                    <td colspan="5">
                                        <div class="empty-state">
                                            <div class="empty-icon-wrap">
                                                <i class="fa fa-gift"></i>
                                            </div>
                                            <h6>No Occasions Found</h6>
                                            <p>Get started by adding your first gifting occasion.</p>
                                            <a href="{{ route('admin.gifting-occasions.create') }}" class="btn-primary-dash">
                                                <i class="fa fa-plus"></i> Add Occasion
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>

                @if($occasions->hasPages())
                    <div class="pagination-bar">
                        {{ $occasions->links('pagination::bootstrap-4') }}
                    </div>
                @endif

            </div>

        </div>
    </div>
</div>

@include('admin.footer')

<script>
function deleteItem(id) {
    Swal.fire({
        title: 'Delete Occasion?',
        text: "This action cannot be undone.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Yes, Delete'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ url('admin/gifting-occasions') }}/" + id,
                type: "DELETE",
                data: { _token: "{{ csrf_token() }}" },
                success: function (res) {
                    Swal.fire('Deleted!', res.message, 'success');
                    $("#row" + id).fadeOut(400, function () { $(this).remove(); });
                }
            });
        }
    });
}
</script>