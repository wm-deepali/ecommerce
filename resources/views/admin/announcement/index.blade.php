@include('admin.top-header')

<div class="main-section">
    @include('admin.header')

    <style>
    :root {
        --bg:#f1f2f4;--surface:#ffffff;--border:#e3e5e8;--text-primary:#202223;
        --text-secondary:#6d7175;--text-hint:#8c9196;--accent:#303d89;
        --accent-light:#f0f1fc;--green:#007a5e;--green-bg:#e3f1ec;
        --red:#b22222;--red-bg:#fce8e8;--radius-sm:8px;--radius-md:12px;
        --shadow-card:0 1px 3px rgba(0,0,0,.08),0 0 0 1px var(--border);
        --font:'Inter',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
    }
    .list-page{background:var(--bg);padding:24px 28px;min-height:100vh;font-family:var(--font);color:var(--text-primary);}
    .list-page *{box-sizing:border-box;}
    .list-page-header{display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:12px;margin-bottom:20px;}
    .list-page-header h1{font-size:20px;font-weight:650;color:var(--text-primary);margin:0;}
    .crumb{font-size:12.5px;color:var(--text-hint);margin-top:3px;}
    .crumb a{color:var(--accent);text-decoration:none;}
    .crumb a:hover{text-decoration:underline;}
    .crumb span{margin:0 5px;}
    .btn-primary-dash{display:inline-flex;align-items:center;gap:6px;background:var(--accent);color:#fff !important;border:none;border-radius:var(--radius-sm);padding:8px 16px;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none !important;font-family:var(--font);transition:background .15s;box-shadow:0 1px 3px rgba(48,61,137,.25);white-space:nowrap;}
    .btn-primary-dash:hover{background:#252f70;}
    .list-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius-md);box-shadow:var(--shadow-card);overflow:hidden;}
    .data-table{width:100%;border-collapse:collapse;}
    .data-table thead tr{background:#fafafa;border-bottom:1px solid var(--border);}
    .data-table thead th{padding:10px 16px;font-size:11px;font-weight:650;text-transform:uppercase;letter-spacing:.05em;color:var(--text-secondary);white-space:nowrap;text-align:left;}
    .data-table tbody tr{border-bottom:1px solid var(--border);transition:background .12s;}
    .data-table tbody tr:last-child{border-bottom:none;}
    .data-table tbody tr:hover{background:#fafbfc;}
    .data-table td{padding:13px 16px;font-size:13px;color:var(--text-primary);vertical-align:middle;}
    .id-chip{display:inline-block;background:var(--bg);border:1px solid var(--border);border-radius:6px;padding:2px 8px;font-size:11.5px;font-family:'SF Mono','Fira Mono',monospace;color:var(--text-secondary);}
    .item-title{font-size:13.5px;font-weight:600;color:var(--text-primary);}
    .link-chip{display:inline-flex;align-items:center;gap:5px;font-size:12.5px;color:var(--accent);text-decoration:none;background:var(--accent-light);border:1px solid rgba(48,61,137,.15);border-radius:6px;padding:3px 10px;transition:background .12s;}
    .link-chip:hover{background:#e3e5f7;}
    .no-link{font-size:12.5px;color:var(--text-hint);}
    .pill{display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:20px;font-size:11.5px;font-weight:600;white-space:nowrap;}
    .pill::before{content:'';width:6px;height:6px;border-radius:50%;flex-shrink:0;}
    .pill-active{background:var(--green-bg);color:var(--green);}
    .pill-active::before{background:var(--green);}
    .pill-inactive{background:var(--red-bg);color:var(--red);}
    .pill-inactive::before{background:var(--red);}
    .action-btn{display:inline-flex;align-items:center;justify-content:center;width:30px;height:30px;border-radius:var(--radius-sm);border:1px solid var(--border);background:var(--surface);color:var(--text-secondary);cursor:pointer;text-decoration:none;transition:all .15s;font-size:12px;}
    .action-btn:hover{background:var(--bg);color:var(--text-primary);border-color:#c9cccf;}
    .action-btn.edit:hover{background:var(--accent-light);color:var(--accent);border-color:rgba(48,61,137,.25);}
    .action-btn.danger:hover{background:var(--red-bg);color:var(--red);border-color:#f5c0c0;}
    .empty-state{text-align:center;padding:56px 24px;}
    .empty-icon-wrap{width:56px;height:56px;border-radius:50%;background:var(--accent-light);margin:0 auto 16px;display:flex;align-items:center;justify-content:center;color:var(--accent);font-size:22px;}
    .empty-state h6{font-size:14px;font-weight:650;color:var(--text-primary);margin:0 0 6px;}
    .empty-state p{font-size:13px;color:var(--text-hint);margin:0 0 20px;}
    @media(max-width:768px){.list-page{padding:16px;}}
    </style>

    <div class="app-content content container-fluid">
        <div class="list-page">

            <div class="list-page-header">
                <div>
                    <h1>Announcement Bar</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        Announcement Bar
                    </div>
                </div>
                <a href="{{ route('admin.announcements.create') }}" class="btn-primary-dash">
                    <i class="fa fa-plus"></i> Add Announcement
                </a>
            </div>

            <div class="list-card">
                <div style="overflow-x:auto">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th style="width:60px">ID</th>
                                <th>Title</th>
                                <th style="width:160px">Link</th>
                                <th style="width:110px">Status</th>
                                <th style="width:90px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($announcements as $item)
                                <tr id="row{{ $item->id }}">
                                    <td><span class="id-chip">{{ $item->id }}</span></td>
                                    <td><span class="item-title">{{ $item->title }}</span></td>
                                    <td>
                                        @if($item->link)
                                            <a href="{{ $item->link }}" target="_blank" class="link-chip">
                                                <i class="fa fa-external-link" style="font-size:10px"></i> View Link
                                            </a>
                                        @else
                                            <span class="no-link">— No link</span>
                                        @endif
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
                                            <a href="{{ route('admin.announcements.edit', $item->id) }}"
                                               class="action-btn edit" title="Edit">
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
                                            <div class="empty-icon-wrap"><i class="fa fa-bullhorn"></i></div>
                                            <h6>No Announcements Found</h6>
                                            <p>Add your first announcement to display on the storefront bar.</p>
                                            <a href="{{ route('admin.announcements.create') }}" class="btn-primary-dash">
                                                <i class="fa fa-plus"></i> Add Announcement
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

@include('admin.footer')

<script>
function deleteItem(id) {
    Swal.fire({
        title: 'Delete Announcement?',
        text: "This action cannot be undone.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Yes, Delete'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ url('admin/announcements') }}/" + id,
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