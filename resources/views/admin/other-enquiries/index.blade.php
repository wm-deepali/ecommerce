@include('admin.top-header')

<div class="main-section">
    @include('admin.header')

    <style>
    :root {
        --bg:#f1f2f4;--surface:#ffffff;--border:#e3e5e8;--text-primary:#202223;
        --text-secondary:#6d7175;--text-hint:#8c9196;--accent:#303d89;
        --accent-light:#f0f1fc;--green:#007a5e;--green-bg:#e3f1ec;
        --red:#b22222;--red-bg:#fce8e8;--amber:#916a00;--amber-bg:#fff5cc;
        --blue:#0069d9;--blue-bg:#e8f2ff;
        --radius-sm:8px;--radius-md:12px;
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
    .btn-secondary-dash{display:inline-flex;align-items:center;gap:6px;background:var(--surface);color:var(--text-primary) !important;border:1px solid var(--border);border-radius:var(--radius-sm);padding:8px 16px;font-size:13px;font-weight:500;cursor:pointer;text-decoration:none !important;font-family:var(--font);transition:background .15s;white-space:nowrap;}
    .btn-secondary-dash:hover{background:var(--bg);}
    .btn-green{display:inline-flex;align-items:center;gap:6px;background:var(--green);color:#fff !important;border:1px solid var(--green);border-radius:var(--radius-sm);padding:8px 16px;font-size:13px;font-weight:500;cursor:pointer;text-decoration:none !important;font-family:var(--font);transition:opacity .15s;white-space:nowrap;}
    .btn-green:hover{opacity:.88;}
    .btn-danger-dash{display:inline-flex;align-items:center;gap:6px;background:var(--red);color:#fff !important;border:1px solid var(--red);border-radius:var(--radius-sm);padding:8px 16px;font-size:13px;font-weight:500;cursor:pointer;text-decoration:none !important;font-family:var(--font);transition:opacity .15s;white-space:nowrap;}
    .btn-danger-dash:hover{opacity:.88;}
    .list-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius-md);box-shadow:var(--shadow-card);overflow:hidden;}
    .data-table{width:100%;border-collapse:collapse;}
    .data-table thead tr{background:#fafafa;border-bottom:1px solid var(--border);}
    .data-table thead th{padding:10px 16px;font-size:11px;font-weight:650;text-transform:uppercase;letter-spacing:.05em;color:var(--text-secondary);white-space:nowrap;text-align:left;}
    .data-table tbody tr{border-bottom:1px solid var(--border);transition:background .12s;}
    .data-table tbody tr:last-child{border-bottom:none;}
    .data-table tbody tr:hover{background:#fafbfc;}
    .data-table tbody tr.row-selected{background:#f0f1fc;}
    .data-table td{padding:13px 16px;font-size:13px;color:var(--text-primary);vertical-align:middle;}
    .id-chip{display:inline-block;background:var(--bg);border:1px solid var(--border);border-radius:6px;padding:2px 8px;font-size:11.5px;font-family:'SF Mono','Fira Mono',monospace;color:var(--text-secondary);}
    .cust-cell{display:flex;align-items:center;gap:9px;}
    .cust-avatar{width:34px;height:34px;border-radius:50%;flex-shrink:0;background:var(--accent-light);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:var(--accent);text-transform:uppercase;}
    .cust-name{font-size:13px;font-weight:600;color:var(--text-primary);}
    .cust-email{font-size:11.5px;color:var(--text-hint);}
    .inq-tag{display:inline-flex;align-items:center;padding:3px 10px;border-radius:6px;font-size:12px;font-weight:600;background:var(--amber-bg);color:var(--amber);border:1px solid rgba(145,106,0,.15);}
    .date-cell{font-size:12.5px;color:var(--text-secondary);white-space:nowrap;}
    .action-btn{display:inline-flex;align-items:center;justify-content:center;width:30px;height:30px;border-radius:var(--radius-sm);border:1px solid var(--border);background:var(--surface);color:var(--text-secondary);cursor:pointer;text-decoration:none;transition:all .15s;font-size:12px;}
    .action-btn:hover{background:var(--bg);color:var(--text-primary);}
    .action-btn.view:hover{background:var(--blue-bg);color:var(--blue);border-color:rgba(0,105,217,.25);}
    .action-btn.danger:hover{background:var(--red-bg);color:var(--red);border-color:#f5c0c0;}
    .empty-state{text-align:center;padding:56px 24px;}
    .empty-icon-wrap{width:56px;height:56px;border-radius:50%;background:var(--accent-light);margin:0 auto 16px;display:flex;align-items:center;justify-content:center;color:var(--accent);font-size:22px;}
    .empty-state h6{font-size:14px;font-weight:650;color:var(--text-primary);margin:0 0 6px;}
    .empty-state p{font-size:13px;color:var(--text-hint);margin:0;}
    .pagination-bar{padding:14px 20px;border-top:1px solid var(--border);}
    .pagination-bar .pagination{margin:0;}
    .pagination-bar .page-link{border-color:var(--border);color:var(--accent);font-size:13px;border-radius:var(--radius-sm) !important;margin:0 2px;}
    .pagination-bar .page-item.active .page-link{background:var(--accent);border-color:var(--accent);color:#fff;}
    .pagination-bar .page-item.disabled .page-link{color:var(--text-hint);}
    .bulk-bar{display:none;align-items:center;gap:10px;padding:10px 16px;background:var(--accent-light);border-bottom:1px solid rgba(48,61,137,.15);}
    .bulk-bar.visible{display:flex;}
    .bulk-bar-label{font-size:13px;font-weight:600;color:var(--accent);flex:1;}
    .row-check,.check-all{width:16px;height:16px;accent-color:var(--accent);cursor:pointer;}
    @media(max-width:768px){.list-page{padding:16px;}}
    </style>

    <div class="app-content content container-fluid">
        <div class="list-page">

            <!-- Page header -->
            <div class="list-page-header">
                <div>
                    <h1>Manage Enquiries</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        Manage Enquiries
                    </div>
                </div>

                <div style="display:flex;gap:8px;flex-wrap:wrap;align-items:center;">
                    <a href="{{ route('admin.other-enquiries.export') }}" class="btn-green">
                        <i class="fa fa-file-excel-o"></i> Export Excel
                    </a>
                </div>
            </div>

            <!-- Main card -->
            <div class="list-card">

                <!-- Bulk action bar -->
                <div class="bulk-bar" id="bulkBar">
                    <span class="bulk-bar-label"><span id="selectedCount">0</span> enquiries selected</span>
                    <button class="btn-danger-dash" onclick="bulkDelete()">
                        <i class="fa fa-trash"></i> Delete Selected
                    </button>
                    <button class="btn-secondary-dash" onclick="clearSelection()">
                        Cancel
                    </button>
                </div>

                <div style="overflow-x:auto">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th style="width:40px">
                                    <input type="checkbox" class="check-all" id="checkAll" title="Select all">
                                </th>
                                <th style="width:60px">#</th>
                                <th style="min-width:180px">Customer</th>
                                <th style="width:130px">Mobile</th>
                                <th style="width:150px">Company</th>
                                <th style="width:150px">Page</th>
                                <th style="width:120px">Date</th>
                                <th style="width:90px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse($enquiries as $key => $item)

                                <tr id="row{{ $item->id }}">

                                    <td>
                                        <input type="checkbox" class="row-check" value="{{ $item->id }}" onchange="onRowCheck(event)">
                                    </td>

                                    <td><span class="id-chip">{{ $key + 1 }}</span></td>

                                    <td>
                                        <div class="cust-cell">
                                            <div class="cust-avatar">
                                                {{ strtoupper(substr($item->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="cust-name">{{ $item->name }}</div>
                                                <div class="cust-email">{{ $item->email }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <td style="color:var(--text-secondary);font-size:13px">
                                        {{ $item->phone ?? '—' }}
                                    </td>

                                    <td style="color:var(--text-secondary);font-size:13px">
                                        {{ $item->company ?? '—' }}
                                    </td>

                                    <td>
                                        @if($item->source)
                                            <span class="inq-tag">{{ $item->source }}</span>
                                        @else
                                            <span style="color:var(--text-hint);font-size:12.5px">—</span>
                                        @endif
                                    </td>

                                    <td class="date-cell">
                                        {{ $item->created_at->format('d M Y') }}
                                        <div style="font-size:11.5px;color:var(--text-hint)">
                                            {{ $item->created_at->format('h:i A') }}
                                        </div>
                                    </td>

                                    <td>
                                        <div style="display:flex;gap:6px">
                                            <a href="{{ route('admin.other-enquiries.show', $item->id) }}"
                                               class="action-btn view" title="View Details">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <button class="action-btn danger" title="Delete"
                                                    onclick="deleteEnquiry({{ $item->id }})">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="8">
                                        <div class="empty-state">
                                            <div class="empty-icon-wrap"><i class="fa fa-envelope"></i></div>
                                            <h6>No Enquiries Found</h6>
                                            <p>Sidebar form submissions will appear here.</p>
                                        </div>
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>
                    </table>
                </div>

                @if(isset($enquiries) && method_exists($enquiries, 'hasPages') && $enquiries->hasPages())
                    <div class="pagination-bar">
                        {{ $enquiries->links('pagination::bootstrap-4') }}
                    </div>
                @endif

            </div>

        </div>
    </div>
</div>

@include('admin.footer')

<script>
/* ── Checkbox logic ── */
const checkAll = document.getElementById('checkAll');

checkAll.addEventListener('change', function () {
    document.querySelectorAll('.row-check').forEach(cb => {
        cb.checked = this.checked;
        cb.closest('tr').classList.toggle('row-selected', this.checked);
    });
    updateBulkBar();
});

function onRowCheck(event) {
    const all     = document.querySelectorAll('.row-check');
    const checked = document.querySelectorAll('.row-check:checked');
    checkAll.indeterminate = checked.length > 0 && checked.length < all.length;
    checkAll.checked = checked.length === all.length && all.length > 0;
    event.target.closest('tr').classList.toggle('row-selected', event.target.checked);
    updateBulkBar();
}

function updateBulkBar() {
    const count = document.querySelectorAll('.row-check:checked').length;
    document.getElementById('selectedCount').textContent = count;
    document.getElementById('bulkBar').classList.toggle('visible', count > 0);
}

function clearSelection() {
    document.querySelectorAll('.row-check').forEach(cb => {
        cb.checked = false;
        cb.closest('tr').classList.remove('row-selected');
    });
    checkAll.checked = false;
    checkAll.indeterminate = false;
    updateBulkBar();
}

function getSelectedIds() {
    return Array.from(document.querySelectorAll('.row-check:checked')).map(cb => cb.value);
}

/* ── Single delete ── */
function deleteEnquiry(id) {
    Swal.fire({
        title: 'Delete Enquiry?',
        text: "This action cannot be undone.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Yes, Delete'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/admin/other-enquiries/${id}`,
                type: "DELETE",
                data: { _token: "{{ csrf_token() }}" },
                success: function (res) {
                    Swal.fire('Deleted!', res.message, 'success');
                    $("#row" + id).fadeOut(400, function () { $(this).remove(); });
                },
                error: function () {
                    Swal.fire('Error', 'Something went wrong', 'error');
                }
            });
        }
    });
}

/* ── Bulk delete ── */
function bulkDelete() {
    const ids = getSelectedIds();
    if (!ids.length) return;

    Swal.fire({
        title: `Delete ${ids.length} Enquiries?`,
        text: "This action cannot be undone.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Yes, Delete All'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ route('admin.other-enquiries.bulk-delete') }}",
                type: "DELETE",
                data: { _token: "{{ csrf_token() }}", ids: ids },
                success: function (res) {
                    Swal.fire('Deleted!', res.message, 'success');
                    ids.forEach(id => {
                        $("#row" + id).fadeOut(400, function () { $(this).remove(); });
                    });
                    clearSelection();
                },
                error: function () {
                    Swal.fire('Error', 'Something went wrong', 'error');
                }
            });
        }
    });
}
</script>