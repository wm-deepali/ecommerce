@include('admin.top-header')
<div class="main-section">
    @include('admin.header')

    <style>
    :root {
        --sp-bg: #f1f2f4;
        --sp-surface: #ffffff;
        --sp-border: #e3e5e8;
        --sp-border-hover: #c9cccf;
        --sp-text-primary: #202223;
        --sp-text-secondary: #6d7175;
        --sp-text-hint: #8c9196;
        --sp-accent: #303d89;
        --sp-accent-hover: #2a3579;
        --sp-accent-light: #eef0fc;
        --sp-green: #007a5e;
        --sp-green-bg: #e3f1ec;
        --sp-red: #c0392b;
        --sp-red-bg: #fce8e8;
        --sp-radius-sm: 6px;
        --sp-radius-md: 8px;
        --sp-radius-lg: 12px;
        --sp-shadow-card: 0 1px 0 rgba(0,0,0,.05), 0 0 0 1px rgba(0,0,0,.07);
        --sp-font: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }

    .sp-page {
        background: var(--sp-bg);
        padding: 24px 28px;
        min-height: 100vh;
        font-family: var(--sp-font);
        color: var(--sp-text-primary);
        font-size: 14px;
    }
    .sp-page * { box-sizing: border-box; }

    /* ── Page header ── */
    .sp-page-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 20px;
    }
    .sp-page-title {
        font-size: 20px;
        font-weight: 660;
        color: var(--sp-text-primary);
        margin: 0 0 4px;
        letter-spacing: -.2px;
    }
    .sp-crumb {
        font-size: 12.5px;
        color: var(--sp-text-hint);
        display: flex;
        align-items: center;
        gap: 4px;
        flex-wrap: wrap;
    }
    .sp-crumb a { color: var(--sp-accent); text-decoration: none; }
    .sp-crumb a:hover { text-decoration: underline; }

    /* ── Primary button ── */
    .sp-btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: var(--sp-accent);
        color: #fff;
        border: 1px solid transparent;
        border-radius: var(--sp-radius-md);
        padding: 8px 16px;
        font-size: 13.5px;
        font-weight: 580;
        font-family: var(--sp-font);
        cursor: pointer;
        text-decoration: none;
        line-height: 1.4;
        transition: background .15s;
        white-space: nowrap;
    }
    .sp-btn-primary:hover { background: var(--sp-accent-hover); color: #fff; }

    /* ── Table card ── */
    .sp-card {
        background: var(--sp-surface);
        border-radius: var(--sp-radius-lg);
        box-shadow: var(--sp-shadow-card);
        border: 1px solid var(--sp-border);
        overflow: hidden;
    }

    /* ── Table ── */
    .sp-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13.5px;
        font-family: var(--sp-font);
    }
    .sp-table thead th {
        padding: 11px 16px;
        background: #fafafa;
        border-bottom: 1px solid var(--sp-border);
        font-size: 11px;
        font-weight: 650;
        letter-spacing: .055em;
        text-transform: uppercase;
        color: var(--sp-text-hint);
        text-align: left;
        white-space: nowrap;
    }
    .sp-table tbody tr {
        border-bottom: 1px solid var(--sp-border);
        transition: background .1s;
    }
    .sp-table tbody tr:last-child { border-bottom: none; }
    .sp-table tbody tr:hover { background: #f7f8f9; }
    .sp-table td {
        padding: 13px 16px;
        color: var(--sp-text-primary);
        vertical-align: middle;
    }

    /* ── ID chip ── */
    .sp-id {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 28px;
        height: 22px;
        padding: 0 7px;
        background: var(--sp-bg);
        border: 1px solid var(--sp-border);
        border-radius: 5px;
        font-size: 11.5px;
        font-weight: 600;
        color: var(--sp-text-secondary);
    }

    /* ── Brand image ── */
    .sp-brand-img {
        width: 90px;
        height: 56px;
        object-fit: cover;
        border-radius: var(--sp-radius-md);
        border: 1px solid var(--sp-border);
        display: block;
    }

    /* ── Sort badge ── */
    .sp-sort {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 26px;
        height: 22px;
        background: var(--sp-accent-light);
        border-radius: 5px;
        font-size: 12px;
        font-weight: 650;
        color: var(--sp-accent);
    }

    /* ── Status pills ── */
    .sp-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 11.5px;
        font-weight: 620;
        padding: 3px 9px;
        border-radius: 20px;
        white-space: nowrap;
    }
    .sp-pill::before {
        content: '';
        width: 5px;
        height: 5px;
        border-radius: 50%;
        display: inline-block;
        flex-shrink: 0;
    }
    .sp-pill-active  { background: var(--sp-green-bg); color: var(--sp-green); }
    .sp-pill-active::before  { background: var(--sp-green); }
    .sp-pill-inactive { background: var(--sp-red-bg); color: var(--sp-red); }
    .sp-pill-inactive::before { background: var(--sp-red); }

    /* ── Action buttons ── */
    .sp-actions { display: flex; gap: 6px; }
    .sp-action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        border-radius: var(--sp-radius-sm);
        border: 1px solid var(--sp-border);
        background: var(--sp-surface);
        color: var(--sp-text-secondary);
        cursor: pointer;
        text-decoration: none;
        transition: all .15s;
        font-size: 13px;
    }
    .sp-action-btn:hover { background: var(--sp-bg); border-color: var(--sp-border-hover); color: var(--sp-text-primary); }
    .sp-action-btn.sp-danger:hover { background: var(--sp-red-bg); border-color: #f5b8b8; color: var(--sp-red); }

    /* ── Empty state ── */
    .sp-empty {
        padding: 56px 24px;
        text-align: center;
        color: var(--sp-text-hint);
        font-size: 14px;
    }
    .sp-empty i { font-size: 36px; color: var(--sp-border); display: block; margin-bottom: 12px; }

    /* ── Pagination ── */
    .sp-pagination {
        padding: 14px 20px;
        border-top: 1px solid var(--sp-border);
        display: flex;
        justify-content: center;
        background: var(--sp-surface);
    }

    @media (max-width: 768px) { .sp-page { padding: 16px; } }
    </style>

    <div class="app-content content container-fluid">
        <div class="sp-page">

            <!-- Page header -->
            <div class="sp-page-header">
                <div>
                    <h1 class="sp-page-title">Brand Section Slider Images</h1>
                    <div class="sp-crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span style="color:var(--sp-border-hover)">›</span>
                        <a href="{{ route('admin.home-page.index') }}">Manage Home Page</a>
                        <span style="color:var(--sp-border-hover)">›</span>
                        <span>Brand Section Slider Images</span>
                    </div>
                </div>
                <a href="{{ route('admin.home-brand-section-images.create') }}" class="sp-btn-primary">
                    <i class="fa fa-plus"></i> Add Slider Image
                </a>
            </div>

            <!-- Table card -->
            <div class="sp-card">
                <div class="table-responsive">
                    <table class="sp-table">
                        <thead>
                            <tr>
                                <th style="width:56px">ID</th>
                                <th style="width:120px">Image</th>
                                <th style="width:120px">Sort Order</th>
                                <th style="width:110px">Status</th>
                                <th style="width:90px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($items as $item)
                                <tr id="row{{ $item->id }}">
                                    <td><span class="sp-id">{{ $item->id }}</span></td>
                                    <td>
                                        <img src="{{ asset('storage/'.$item->image) }}"
                                             class="sp-brand-img" alt="Brand Image">
                                    </td>
                                    <td><span class="sp-sort">{{ $item->sort_order }}</span></td>
                                    <td>
                                        @if($item->status)
                                            <span class="sp-pill sp-pill-active">Active</span>
                                        @else
                                            <span class="sp-pill sp-pill-inactive">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="sp-actions">
                                            <a href="{{ route('admin.home-brand-section-images.edit', $item->id) }}"
                                               class="sp-action-btn" title="Edit">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <button class="sp-action-btn sp-danger"
                                                    onclick="deleteItem({{ $item->id }})" title="Delete">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">
                                        <div class="sp-empty">
                                            <i class="fa fa-image"></i>
                                            No Records Found
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="sp-pagination">
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
        title: 'Delete Image?',
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#c0392b',
        cancelButtonColor: '#6d7175',
        confirmButtonText: 'Yes, Delete'
    })
    .then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ url('admin/home-brand-section-images/delete') }}/" + id,
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