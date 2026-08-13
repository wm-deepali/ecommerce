@include('admin.top-header')
<div class="main-section">
    @include('admin.header')

    <style>
    :root {
        --bg: #f1f2f4;
        --surface: #ffffff;
        --border: #e3e5e8;
        --text-primary: #202223;
        --text-secondary:#6d7175;
        --text-hint: #8c9196;
        --accent: #303d89;
        --accent-light: #f0f1fc;
        --green: #007a5e;
        --green-bg: #e3f1ec;
        --red: #b22222;
        --red-bg: #fce8e8;
        --radius-sm: 8px;
        --radius-md: 12px;
        --shadow-card: 0 1px 3px rgba(0,0,0,.08), 0 0 0 1px var(--border);
        --font: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }
    .list-page {
        background: var(--bg);
        padding: 24px 28px;
        min-height: 100vh;
        font-family: var(--font);
        color: var(--text-primary);
    }
    .list-page * { box-sizing: border-box; }

    .list-page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 24px;
    }
    .list-page-header h1 {
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
    .crumb a { color: var(--accent); text-decoration: none; }
    .crumb a:hover { text-decoration: underline; }
    .crumb span { margin: 0 5px; }

    .list-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-card);
        overflow: hidden;
    }
    .data-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13.5px;
    }
    .data-table thead th {
        font-size: 11px;
        font-weight: 650;
        letter-spacing: .06em;
        text-transform: uppercase;
        color: var(--text-hint);
        padding: 14px 16px;
        border-bottom: 2px solid var(--border);
        background: #fafafa;
        text-align: left;
    }
    .data-table tbody tr {
        border-bottom: 1px solid var(--border);
        transition: background .1s;
    }
    .data-table tbody tr:hover { background: #fafbfc; }
    .data-table td {
        padding: 14px 16px;
        vertical-align: middle;
    }

    .gallery-img {
        width: 85px;
        height: 60px;
        object-fit: cover;
        border-radius: var(--radius-sm);
        border: 1px solid var(--border);
    }

    /* Sort Order Pill */
    .sort-pill {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #f1f3f5;
        color: #202223;
        font-weight: 600;
        font-size: 13px;
        min-width: 32px;
        height: 32px;
        padding: 0 10px;
        border-radius: 9999px;
        border: 1px solid #e3e5e8;
    }

    /* Status Pill */
    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 12px;
        border-radius: 9999px;
        font-size: 12.5px;
        font-weight: 600;
    }
    .status-active {
        background: var(--green-bg);
        color: var(--green);
    }

    /* Actions */
    .action-group {
        display: flex;
        gap: 8px;
    }
    .action-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        border: 1px solid var(--border);
        background: var(--surface);
        color: var(--text-secondary);
        border-radius: var(--radius-sm);
        cursor: pointer;
        transition: all 0.15s;
    }
    .action-btn:hover {
        background: #f8f9fa;
        color: var(--text-primary);
    }
    .action-btn.danger:hover {
        background: #fce8e8;
        color: var(--red);
        border-color: var(--red);
    }

    /* Compact Add Button */
    .btn-primary {
        background: var(--accent);
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: var(--radius-sm);
        font-weight: 600;
        font-size: 13.5px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        height: 38px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.1);
    }
    .btn-primary:hover {
        background: #252f70;
    }
    </style>

    <div class="app-content content container-fluid">
        <div class="list-page">
            <div class="list-page-header">
                <div>
                    <h1>Gallery Images</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        <a href="{{ route('admin.home-page.index') }}">Manage Home Page</a>
                        <span>›</span>
                        Gallery Images
                    </div>
                </div>
                <a href="{{ route('admin.gallery-images.create') }}" class="btn-primary">
                    <i class="fa fa-plus"></i> Add Gallery Image
                </a>
            </div>

            <div class="list-card">
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>IMAGE</th>
                                <th>TITLE</th>
                                <th>COLUMN</th>
                                <th>HEIGHT</th>
                                <th>SORT ORDER</th>
                                <th>STATUS</th>
                                <th>ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($galleryImages as $item)
                                <tr id="row{{ $item->id }}">
                                    <td>{{ $item->id }}</td>
                                    <td>
                                        @if($item->image)
                                            <img src="{{ asset('storage/' . $item->image) }}" 
                                                 class="gallery-img" alt="{{ $item->title }}">
                                        @else
                                            <span class="text-muted">No Image</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->title ?? '—' }}</td>
                                    <td>Column {{ $item->column_no ?? '—' }}</td>
                                    <td>{{ $item->height_class ?? '—' }}</td>
                                    <td>
                                        <span class="sort-pill">{{ $item->sort_order ?? 0 }}</span>
                                    </td>
                                    <td>
                                        @if($item->status)
                                            <span class="status-pill status-active">
                                                <span style="display:inline-block;width:6px;height:6px;background:var(--green);border-radius:50%;"></span>
                                                Active
                                            </span>
                                        @else
                                            <span class="pill pill-inactive">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-group">
                                            <a href="{{ route('admin.gallery-images.edit', $item->id) }}" 
                                               class="action-btn" title="Edit">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <button onclick="deleteItem({{ $item->id }})" 
                                                    class="action-btn danger" title="Delete">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5 text-muted">
                                        No Records Found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="pagination-bar">
                    {{ $galleryImages->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.footer')

<script>
function deleteItem(id) {
    Swal.fire({
        title: 'Delete Gallery Image?',
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#b22222',
        cancelButtonColor: '#6d7175',
        confirmButtonText: 'Yes, Delete'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ url('admin/gallery-images/delete') }}/" + id,
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