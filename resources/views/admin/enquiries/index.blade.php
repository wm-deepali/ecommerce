@include('admin.top-header')

<div class="main-section">
    @include('admin.header')

    <style>
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
        --blue:          #0069d9;
        --blue-bg:       #e8f2ff;
        --radius-sm:     8px;
        --radius-md:     12px;
        --shadow-card:   0 1px 3px rgba(0,0,0,.08), 0 0 0 1px var(--border);
        --font:          'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }

    .enq-page { background: var(--bg); padding: 24px 28px; min-height: 100vh; font-family: var(--font); color: var(--text-primary); }
    .enq-page * { box-sizing: border-box; }

    /* Page header */
    .page-header { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 20px; }
    .page-header h1 { font-size: 20px; font-weight: 650; color: var(--text-primary); margin: 0; }
    .crumb { font-size: 12.5px; color: var(--text-hint); margin-top: 3px; }
    .crumb a { color: var(--accent); text-decoration: none; }
    .crumb a:hover { text-decoration: underline; }
    .crumb span { margin: 0 5px; }

    /* Card */
    .enq-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-md); box-shadow: var(--shadow-card); overflow: hidden; }

    /* Table */
    .enq-table-wrap { overflow-x: auto; }
    .enq-table { width: 100%; border-collapse: collapse; font-size: 13px; font-family: var(--font); }
    .enq-table thead th {
        font-size: 11px; font-weight: 600; letter-spacing: .06em; text-transform: uppercase;
        color: var(--text-hint); padding: 10px 14px; border-bottom: 1px solid var(--border);
        background: #fafafa; text-align: left; white-space: nowrap;
    }
    .enq-table tbody tr { border-bottom: 1px solid var(--border); transition: background .1s; }
    .enq-table tbody tr:last-child { border-bottom: none; }
    .enq-table tbody tr:hover { background: #fafbfc; }
    .enq-table tbody td { padding: 13px 14px; vertical-align: middle; color: var(--text-primary); }

    /* ID chip */
    .id-chip { display: inline-block; background: var(--bg); color: var(--text-secondary); font-size: 11px; font-weight: 700; padding: 2px 7px; border-radius: 6px; font-family: 'SF Mono','Fira Code',monospace; }

    /* Business cell */
    .biz-avatar { width: 34px; height: 34px; border-radius: var(--radius-sm); background: var(--accent-light); display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 700; color: var(--accent); flex-shrink: 0; }
    .biz-name { font-size: 13px; font-weight: 650; color: var(--text-primary); }
    .biz-owner { font-size: 11.5px; color: var(--text-hint); margin-top: 2px; }

    /* Contact cells */
    .contact-email { font-size: 12.5px; color: var(--text-secondary); }
    .contact-phone { font-size: 12.5px; font-weight: 600; color: var(--text-primary); font-family: 'SF Mono','Fira Code',monospace; }

    /* Location cell */
    .loc-cell { font-size: 12.5px; color: var(--text-secondary); }
    .loc-state { font-weight: 600; color: var(--text-primary); }

    /* Date cell */
    .date-cell { font-size: 12.5px; color: var(--text-secondary); white-space: nowrap; }

    /* Action buttons */
    .action-btn { display: inline-flex; align-items: center; justify-content: center; width: 30px; height: 30px; border-radius: var(--radius-sm); border: 1px solid var(--border); background: var(--surface); color: var(--text-secondary); font-size: 12px; cursor: pointer; transition: all .12s; text-decoration: none; }
    .action-btn:hover { background: var(--bg); color: var(--text-primary); }
    .action-btn-view:hover   { background: var(--blue-bg); border-color: #b8d4f5; color: var(--blue); }
    .action-btn-danger:hover { background: var(--red-bg);  border-color: #f5c6c6; color: var(--red); }

    /* Tooltip wrapper */
    .action-wrap { position: relative; display: inline-flex; }
    .action-wrap .tooltip-label { position: absolute; bottom: calc(100% + 6px); left: 50%; transform: translateX(-50%); background: #202223; color: #fff; font-size: 11px; white-space: nowrap; padding: 3px 8px; border-radius: 5px; pointer-events: none; opacity: 0; transition: opacity .15s; z-index: 10; }
    .action-wrap:hover .tooltip-label { opacity: 1; }

    /* Empty state */
    .empty-state { text-align: center; padding: 64px 20px; }
    .empty-state .empty-icon { width: 56px; height: 56px; border-radius: 50%; background: var(--bg); display: inline-flex; align-items: center; justify-content: center; font-size: 22px; color: var(--text-hint); margin-bottom: 14px; }
    .empty-state p { font-size: 14px; color: var(--text-secondary); margin: 6px 0 8px; }

    /* Pagination */
    .enq-pagination { padding: 14px 20px; border-top: 1px solid var(--border); display: flex; justify-content: center; background: var(--surface); }

    @media(max-width:768px) { .enq-page { padding: 16px; } }
    </style>

    <div class="app-content content container-fluid">
        <div class="enq-page">

            <!-- Page header -->
            <div class="page-header">
                <div>
                    <h1>Manage Enquiries</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        Manage Enquiries
                    </div>
                </div>
            </div>

            <!-- Main card -->
            <div class="enq-card">
                <div class="enq-table-wrap">
                    <table class="enq-table">
                        <thead>
                            <tr>
                                <th style="width:55px">ID</th>
                                <th>Business / Owner</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>State</th>
                                <th>City</th>
                                <th style="width:110px">Date</th>
                                <th style="width:90px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse($enquiries as $enquiry)
                                <tr id="row{{ $enquiry->id }}">

                                    <td><span class="id-chip">{{ $enquiry->id }}</span></td>

                                    <td>
                                        <div style="display:flex;align-items:center;gap:10px">
                                            <div class="biz-avatar">
                                                {{ strtoupper(substr($enquiry->business_name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="biz-name">{{ $enquiry->business_name }}</div>
                                                <div class="biz-owner">{{ $enquiry->owner_name }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <a href="mailto:{{ $enquiry->email }}"
                                            class="contact-email"
                                            style="text-decoration:none;color:var(--text-secondary)">
                                            {{ $enquiry->email }}
                                        </a>
                                    </td>

                                    <td>
                                        <a href="tel:{{ $enquiry->mobile }}"
                                            class="contact-phone"
                                            style="text-decoration:none;color:inherit">
                                            {{ $enquiry->mobile }}
                                        </a>
                                    </td>

                                    <td>
                                        <span class="loc-state">{{ $enquiry->state->name ?? '—' }}</span>
                                    </td>

                                    <td>
                                        <span class="loc-cell">{{ $enquiry->city->name ?? '—' }}</span>
                                    </td>

                                    <td>
                                        <span class="date-cell">
                                            {{ $enquiry->created_at->format('d M Y') }}
                                        </span>
                                    </td>

                                    <td>
                                        <div style="display:flex;gap:6px">
                                            <div class="action-wrap">
                                                <a href="{{ route('admin.enquiries.show', $enquiry->id) }}"
                                                    class="action-btn action-btn-view">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <span class="tooltip-label">View Details</span>
                                            </div>
                                            <div class="action-wrap">
                                                <button class="action-btn action-btn-danger"
                                                    onclick="deleteEnquiry({{ $enquiry->id }})">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                                <span class="tooltip-label">Delete</span>
                                            </div>
                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">
                                        <div class="empty-state">
                                            <div class="empty-icon"><i class="fa fa-envelope-o"></i></div>
                                            <strong style="font-size:14px;color:var(--text-primary)">No enquiries found</strong>
                                            <p>Business enquiries submitted through your store will appear here.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>

                @if(method_exists($enquiries, 'links'))
                <div class="enq-pagination">
                    {{ $enquiries->links('pagination::bootstrap-4') }}
                </div>
                @endif

            </div>

        </div>
    </div>
</div>

@include('admin.footer')

<script>
function deleteEnquiry(id) {
    Swal.fire({
        title: 'Delete Enquiry?',
        text: "This action cannot be undone.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#b22222',
        cancelButtonColor: '#6d7175',
        confirmButtonText: 'Yes, Delete'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ url('admin/enquiries') }}/" + id,
                type: "DELETE",
                data: { _token: "{{ csrf_token() }}" },
                beforeSend: function () { Swal.showLoading(); },
                success: function (res) {
                    Swal.fire('Deleted!', res.message, 'success');
                    $("#row" + id).fadeOut(400, function () { $(this).remove(); });
                },
                error: function () {
                    Swal.fire('Error!', 'Something went wrong.', 'error');
                }
            });
        }
    });
}
</script>