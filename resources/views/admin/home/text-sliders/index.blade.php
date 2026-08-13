@include('admin.top-header')
<div class="main-section">
    @include('admin.header')

    <style>
    :root {
        --bg:#f1f2f4; --surface:#ffffff; --border:#e3e5e8;
        --text-primary:#202223; --text-secondary:#6d7175; --text-hint:#8c9196;
        --accent:#303d89; --accent-light:#f0f1fc;
        --green:#007a5e; --green-bg:#e3f1ec;
        --red:#b22222; --red-bg:#fce8e8;
        --radius-sm:8px; --radius-md:12px;
        --shadow-card:0 1px 3px rgba(0,0,0,.08),0 0 0 1px var(--border);
        --font:'Inter',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
    }

    .list-page { background:var(--bg); padding:24px 28px; min-height:100vh; font-family:var(--font); color:var(--text-primary); }
    .list-page * { box-sizing:border-box; }

    .list-page-header { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; margin-bottom:20px; }
    .list-page-header h1 { font-size:20px; font-weight:650; color:var(--text-primary); margin:0; }
    .crumb { font-size:12.5px; color:var(--text-hint); margin-top:3px; }
    .crumb a { color:var(--accent); text-decoration:none; }
    .crumb a:hover { text-decoration:underline; }
    .crumb span { margin:0 5px; }

    .btn-primary-dash {
        display:inline-flex; align-items:center; gap:6px;
        background:var(--accent); color:#fff !important; border:none;
        border-radius:var(--radius-sm); padding:8px 16px;
        font-size:13px; font-weight:600; cursor:pointer;
        text-decoration:none !important; font-family:var(--font);
        transition:background .15s; box-shadow:0 1px 3px rgba(48,61,137,.25);
    }
    .btn-primary-dash:hover { background:#252f70; }

    .list-card { background:var(--surface); border:1px solid var(--border); border-radius:var(--radius-md); box-shadow:var(--shadow-card); overflow:hidden; }

    .data-table { width:100%; border-collapse:collapse; font-size:13px; font-family:var(--font); }
    .data-table thead th { font-size:11px; font-weight:600; letter-spacing:.06em; text-transform:uppercase; color:var(--text-hint); padding:10px 16px; border-bottom:1px solid var(--border); background:#fafafa; text-align:left; white-space:nowrap; }
    .data-table tbody tr { border-bottom:1px solid var(--border); transition:background .1s; }
    .data-table tbody tr:last-child { border-bottom:none; }
    .data-table tbody tr:hover { background:#fafbfc; }
    .data-table td { padding:13px 16px; color:var(--text-primary); vertical-align:middle; }

    .id-chip { display:inline-block; background:var(--bg); color:var(--text-secondary); font-size:11px; font-weight:700; padding:2px 7px; border-radius:6px; font-family:'SF Mono','Fira Code',monospace; }
    .sort-chip { display:inline-block; background:var(--bg); color:var(--text-secondary); font-size:12px; font-weight:600; padding:2px 8px; border-radius:6px; }

    .text-cell { font-size:13px; color:var(--text-primary); max-width:420px; line-height:1.5; }

    .pill { display:inline-flex; align-items:center; gap:4px; font-size:11.5px; font-weight:600; padding:3px 9px; border-radius:20px; }
    .pill::before { content:''; width:5px; height:5px; border-radius:50%; display:inline-block; }
    .pill-active   { background:var(--green-bg); color:var(--green); }
    .pill-active::before   { background:var(--green); }
    .pill-inactive { background:var(--red-bg);   color:var(--red); }
    .pill-inactive::before { background:var(--red); }

    .action-btn { display:inline-flex; align-items:center; justify-content:center; width:30px; height:30px; border-radius:var(--radius-sm); border:1px solid var(--border); background:var(--surface); color:var(--text-secondary); cursor:pointer; text-decoration:none; font-size:12px; transition:all .12s; }
    .action-btn:hover { background:var(--bg); color:var(--text-primary); }
    .action-btn-danger:hover { background:var(--red-bg); border-color:#f5c6c6; color:var(--red); }

    .empty-state { text-align:center; padding:64px 20px; }
    .empty-state .empty-icon { width:56px; height:56px; border-radius:50%; background:var(--bg); display:inline-flex; align-items:center; justify-content:center; font-size:22px; color:var(--text-hint); margin-bottom:14px; }
    .empty-state p { font-size:14px; color:var(--text-secondary); margin:6px 0 16px; }

    .pagination-bar { padding:14px 20px; border-top:1px solid var(--border); display:flex; justify-content:center; background:var(--surface); }

    @media(max-width:768px) { .list-page { padding:16px; } }
    </style>

    <div class="app-content content container-fluid">
        <div class="list-page">

            <div class="list-page-header">
                <div>
                    <h1>Text Sliders</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        <a href="{{ route('admin.home-page.index') }}">Manage Home Page</a>
                        <span>›</span>
                        Text Sliders
                    </div>
                </div>
                <a href="{{ route('admin.home.text-sliders.create') }}" class="btn-primary-dash">
                    <i class="fa fa-plus"></i> Add Text Slider
                </a>
            </div>

            <div class="list-card">
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th style="width:60px">ID</th>
                                <th>Text</th>
                                <th style="width:110px">Sort Order</th>
                                <th style="width:110px">Status</th>
                                <th style="width:90px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($items as $item)
                                <tr id="row{{ $item->id }}">

                                    <td><span class="id-chip">{{ $item->id }}</span></td>

                                    <td>
                                        <span class="text-cell">{{ $item->title }}</span>
                                    </td>

                                    <td><span class="sort-chip">{{ $item->sort_order }}</span></td>

                                    <td>
                                        @if($item->status)
                                            <span class="pill pill-active">Active</span>
                                        @else
                                            <span class="pill pill-inactive">Inactive</span>
                                        @endif
                                    </td>

                                    <td>
                                        <div style="display:flex;gap:6px">
                                            <a href="{{ route('admin.home.text-sliders.edit', $item->id) }}"
                                                class="action-btn" title="Edit">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <button class="action-btn action-btn-danger"
                                                onclick="deleteItem({{ $item->id }})" title="Delete">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">
                                        <div class="empty-state">
                                            <div class="empty-icon"><i class="fa fa-align-center"></i></div>
                                            <strong style="font-size:14px;color:var(--text-primary)">No text sliders found</strong>
                                            <p>Add scrolling announcement or promo text strips for the homepage.</p>
                                            <a href="{{ route('admin.home.text-sliders.create') }}" class="btn-primary-dash">
                                                <i class="fa fa-plus"></i> Add Text Slider
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="pagination-bar">
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
        title: 'Delete Text Slider?',
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#b22222',
        cancelButtonColor: '#6d7175',
        confirmButtonText: 'Yes, Delete'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ url('admin/home/text-sliders/delete') }}/" + id,
                type: 'DELETE',
                data: { _token: "{{ csrf_token() }}" },
                beforeSend: function () { Swal.showLoading(); },
                success: function (res) {
                    Swal.fire('Deleted!', res.message, 'success');
                    $("#row" + id).fadeOut(300, function () { $(this).remove(); });
                },
                error: function () {
                    Swal.fire('Error!', 'Something went wrong.', 'error');
                }
            });
        }
    });
}
</script>