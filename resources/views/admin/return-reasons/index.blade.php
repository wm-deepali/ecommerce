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
        --radius-sm:     8px;
        --radius-md:     12px;
        --shadow-card:   0 1px 3px rgba(0,0,0,.08), 0 0 0 1px var(--border);
        --font:          'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }

    .list-page { background: var(--bg); padding: 24px 28px; min-height: 100vh; font-family: var(--font); color: var(--text-primary); }
    .list-page * { box-sizing: border-box; }

    .list-page-header { display: flex; align-items: flex-start; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 20px; }
    .list-page-header h1 { font-size: 20px; font-weight: 650; margin: 0; }
    .crumb { font-size: 12.5px; color: var(--text-hint); margin-top: 3px; }
    .crumb a { color: var(--accent); text-decoration: none; }
    .crumb a:hover { text-decoration: underline; }
    .crumb span { margin: 0 5px; }

    .btn-primary-dash {
        display: inline-flex; align-items: center; gap: 6px;
        background: var(--accent); color: #fff !important; border: none;
        border-radius: var(--radius-sm); padding: 8px 18px;
        font-size: 13px; font-weight: 600; cursor: pointer;
        text-decoration: none !important; font-family: var(--font);
        transition: background .15s; box-shadow: 0 1px 3px rgba(48,61,137,.25);
    }
    .btn-primary-dash:hover { background: #252f70; }

    /* Alert */
    .dash-alert { border-radius: var(--radius-sm); padding: 10px 16px; font-size: 13px; margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }
    .dash-alert-success { background: var(--green-bg); color: var(--green); border: 1px solid #b6ddd3; }
    .dash-alert-error   { background: var(--red-bg);   color: var(--red);   border: 1px solid #f0c0c0; }

    /* Table card */
    .table-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-md); box-shadow: var(--shadow-card); overflow: hidden; }
    .table-card table { width: 100%; border-collapse: collapse; }
    .table-card thead th { padding: 11px 16px; font-size: 11.5px; font-weight: 650; color: var(--text-secondary); text-transform: uppercase; letter-spacing: .04em; background: #fafafa; border-bottom: 1px solid var(--border); text-align: left; }
    .table-card tbody tr { border-bottom: 1px solid var(--border); transition: background .1s; }
    .table-card tbody tr:last-child { border-bottom: none; }
    .table-card tbody tr:hover { background: #fafbff; }
    .table-card td { padding: 12px 16px; font-size: 13px; color: var(--text-primary); vertical-align: middle; }

    .badge { display: inline-flex; align-items: center; gap: 4px; font-size: 11.5px; font-weight: 600; padding: 3px 9px; border-radius: 99px; }
    .badge-active   { background: var(--green-bg); color: var(--green); }
    .badge-inactive { background: var(--bg);        color: var(--text-hint); border: 1px solid var(--border); }

    .tbl-actions { display: flex; align-items: center; gap: 8px; }
    .btn-icon {
        display: inline-flex; align-items: center; justify-content: center;
        width: 30px; height: 30px; border-radius: var(--radius-sm);
        border: 1px solid var(--border); background: var(--surface);
        color: var(--text-secondary); cursor: pointer; text-decoration: none;
        transition: background .12s, color .12s;
    }
    .btn-icon:hover { background: var(--accent-light); color: var(--accent); }
    .btn-icon.del:hover { background: var(--red-bg); color: var(--red); border-color: #f0c0c0; }

    .empty-state { text-align: center; padding: 56px 24px; color: var(--text-hint); }
    .empty-state i { font-size: 32px; margin-bottom: 12px; display: block; }
    .empty-state p { margin: 0; font-size: 14px; }

    .pagination-wrap { padding: 12px 20px; border-top: 1px solid var(--border); background: #fafafa; }
    .pagination-wrap .pagination { margin: 0; }

    @media(max-width:768px) { .list-page { padding: 16px; } }
    </style>

    <div class="app-content content container-fluid">
        <div class="list-page">

            <div class="list-page-header">
                <div>
                    <h1>Return Reasons</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        Return Reasons
                    </div>
                </div>
                <a href="{{ route('admin.return-reasons.create') }}" class="btn-primary-dash">
                    <i class="fa fa-plus"></i> Add Reason
                </a>
            </div>

            @if(session('success'))
                <div class="dash-alert dash-alert-success">
                    <i class="fa fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div class="dash-alert dash-alert-error">
                    <i class="fa fa-exclamation-circle"></i> {{ $errors->first() }}
                </div>
            @endif

            <div class="table-card">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Sort Order</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reasons as $reason)
                            <tr>
                                <td style="color:var(--text-hint);width:48px">{{ $reason->id }}</td>
                                <td style="font-weight:500">{{ $reason->title }}</td>
                                <td>{{ $reason->sort_order }}</td>
                                <td>
                                    @if($reason->is_active)
                                        <span class="badge badge-active"><i class="fa fa-circle" style="font-size:7px"></i> Active</span>
                                    @else
                                        <span class="badge badge-inactive">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="tbl-actions">
                                        <a href="{{ route('admin.return-reasons.edit', $reason) }}" class="btn-icon" title="Edit">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.return-reasons.destroy', $reason) }}"
                                            onsubmit="return confirm('Delete this return reason?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn-icon del" title="Delete">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="empty-state">
                                        <i class="fa fa-inbox"></i>
                                        <p>No return reasons yet. <a href="{{ route('admin.return-reasons.create') }}" style="color:var(--accent)">Add one</a>.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                @if($reasons->hasPages())
                    <div class="pagination-wrap">
                        {{ $reasons->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>

@include('admin.footer')