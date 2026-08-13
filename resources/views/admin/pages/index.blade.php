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
        --amber:         #916a00;
        --amber-bg:      #fff5cc;
        --radius-sm:     8px;
        --radius-md:     12px;
        --shadow-card:   0 1px 3px rgba(0,0,0,.08), 0 0 0 1px var(--border);
        --font:          'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }

    .pages-page { background: var(--bg); padding: 24px 28px; min-height: 100vh; font-family: var(--font); color: var(--text-primary); }
    .pages-page * { box-sizing: border-box; }

    .page-header { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 20px; }
    .page-header h1 { font-size: 20px; font-weight: 650; color: var(--text-primary); margin: 0; }
    .crumb { font-size: 12.5px; color: var(--text-hint); margin-top: 3px; }
    .crumb a { color: var(--accent); text-decoration: none; }
    .crumb a:hover { text-decoration: underline; }
    .crumb span { margin: 0 5px; }

    .btn-primary-dash {
        display: inline-flex; align-items: center; gap: 6px;
        background: var(--accent); color: #fff !important; border: none;
        border-radius: var(--radius-sm); padding: 8px 16px;
        font-size: 13px; font-weight: 600; cursor: pointer;
        text-decoration: none !important; font-family: var(--font);
        transition: background .15s; box-shadow: 0 1px 3px rgba(48,61,137,.25);
    }
    .btn-primary-dash:hover { background: #252f70; }

    .pages-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-md); box-shadow: var(--shadow-card); overflow: hidden; }

    .pages-table-wrap { overflow-x: auto; }
    .pages-table { width: 100%; border-collapse: collapse; font-size: 13px; font-family: var(--font); }
    .pages-table thead th { font-size: 11px; font-weight: 600; letter-spacing: .06em; text-transform: uppercase; color: var(--text-hint); padding: 10px 16px; border-bottom: 1px solid var(--border); background: #fafafa; text-align: left; white-space: nowrap; }
    .pages-table tbody tr { border-bottom: 1px solid var(--border); transition: background .1s; }
    .pages-table tbody tr:last-child { border-bottom: none; }
    .pages-table tbody tr:hover { background: #fafbfc; }
    .pages-table tbody td { padding: 13px 16px; vertical-align: middle; color: var(--text-primary); }

    .id-chip { display: inline-block; background: var(--bg); color: var(--text-secondary); font-size: 11px; font-weight: 700; padding: 2px 7px; border-radius: 6px; font-family: 'SF Mono','Fira Code',monospace; }

    .slug-code { display: inline-flex; align-items: center; gap: 4px; background: var(--bg); color: var(--accent); font-size: 12px; padding: 3px 8px; border-radius: 6px; font-family: 'SF Mono','Fira Code',monospace; }

    .page-name-cell { font-weight: 600; font-size: 13px; color: var(--text-primary); }
    .page-heading-cell { font-size: 13px; color: var(--text-secondary); }

    .pill { display: inline-flex; align-items: center; gap: 4px; font-size: 11.5px; font-weight: 600; padding: 3px 9px; border-radius: 20px; }
    .pill::before { content: ''; width: 5px; height: 5px; border-radius: 50%; display: inline-block; }
    .pill-active   { background: var(--green-bg); color: var(--green); }
    .pill-active::before   { background: var(--green); }
    .pill-block    { background: var(--red-bg);   color: var(--red); }
    .pill-block::before    { background: var(--red); }

    .action-btn { display: inline-flex; align-items: center; justify-content: center; width: 30px; height: 30px; border-radius: var(--radius-sm); border: 1px solid var(--border); background: var(--surface); color: var(--text-secondary); font-size: 12px; cursor: pointer; transition: all .12s; text-decoration: none; }
    .action-btn:hover { background: var(--bg); color: var(--text-primary); }
    .action-btn-danger:hover { background: var(--red-bg); border-color: #f5c6c6; color: var(--red); }

    .empty-state { text-align: center; padding: 64px 20px; }
    .empty-state .empty-icon { width: 56px; height: 56px; border-radius: 50%; background: var(--bg); display: inline-flex; align-items: center; justify-content: center; font-size: 22px; color: var(--text-hint); margin-bottom: 14px; }
    .empty-state p { font-size: 14px; color: var(--text-secondary); margin: 6px 0 16px; }

    @media(max-width:768px) { .pages-page { padding: 16px; } }
    </style>

    <div class="app-content content container-fluid">
        <div class="pages-page">

            <div class="page-header">
                <div>
                    <h1>Dynamic Pages</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        Manage Dynamic Pages
                    </div>
                </div>
                <a href="{{ route('admin.pages.create') }}" class="btn-primary-dash">
                    <i class="fa fa-plus"></i> Add Dynamic Page
                </a>
            </div>

            <div class="pages-card">
                <div class="pages-table-wrap">
                    <table class="pages-table">
                        <thead>
                            <tr>
                                <th style="width:60px">ID</th>
                                <th>Page Slug</th>
                                <th>Heading</th>
                                <th style="width:110px">Status</th>
                                <th style="width:90px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pages as $page)
                                <tr id="row{{ $page->id }}">

                                    <td><span class="id-chip">{{ $page->id }}</span></td>

                                    <td>
                                        <span class="slug-code">
                                            <i class="fa fa-link" style="font-size:10px"></i>
                                            {{ $page->page_name }}
                                        </span>
                                    </td>

                                    <td>
                                        <span class="page-heading-cell">{{ $page->heading }}</span>
                                    </td>

                                    <td>
                                        @if($page->status === 'active')
                                            <span class="pill pill-active">Active</span>
                                        @else
                                            <span class="pill pill-block">Blocked</span>
                                        @endif
                                    </td>

                                    <td>
                                        <div style="display:flex;gap:6px">
                                            <a href="{{ route('admin.pages.edit', $page->id) }}"
                                                class="action-btn" title="Edit">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <button class="action-btn action-btn-danger"
                                                onclick="deletePage({{ $page->id }})" title="Delete">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">
                                        <div class="empty-state">
                                            <div class="empty-icon"><i class="fa fa-file-text-o"></i></div>
                                            <strong style="font-size:14px;color:var(--text-primary)">No dynamic pages found</strong>
                                            <p>Create pages like About Us, Privacy Policy, Terms &amp; Conditions.</p>
                                            <a href="{{ route('admin.pages.create') }}" class="btn-primary-dash">
                                                <i class="fa fa-plus"></i> Add Dynamic Page
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
function deletePage(id) {
    Swal.fire({
        title: 'Delete Page?',
        text: "This action cannot be undone.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#b22222',
        cancelButtonColor: '#6d7175',
        confirmButtonText: 'Yes, Delete'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ url('admin/pages') }}/" + id,
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