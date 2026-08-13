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

    /* ── Page header ── */
    .list-page-header { display: flex; align-items: flex-start; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 20px; }
    .list-page-header h1 { font-size: 20px; font-weight: 650; color: var(--text-primary); margin: 0; }
    .crumb { font-size: 12.5px; color: var(--text-hint); margin-top: 3px; }
    .crumb a { color: var(--accent); text-decoration: none; }
    .crumb a:hover { text-decoration: underline; }
    .crumb span { margin: 0 5px; }

    /* ── Buttons ── */
    .btn-primary-dash {
        display: inline-flex; align-items: center; gap: 6px;
        background: var(--accent); color: #fff !important; border: none;
        border-radius: var(--radius-sm); padding: 8px 16px;
        font-size: 13px; font-weight: 600; cursor: pointer;
        text-decoration: none !important; font-family: var(--font);
        transition: background .15s; box-shadow: 0 1px 3px rgba(48,61,137,.25);
        white-space: nowrap;
    }
    .btn-primary-dash:hover { background: #252f70; color: #fff !important; }

    /* ── Alert banner ── */
    .alert-banner { display: flex; align-items: center; gap: 8px; padding: 11px 16px; border-radius: var(--radius-sm); font-size: 13px; font-weight: 500; margin-bottom: 16px; }
    .alert-success { background: var(--green-bg); color: var(--green); border: 1px solid rgba(0,122,94,.18); }

    /* ── Main card ── */
    .list-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-md); box-shadow: var(--shadow-card); overflow: hidden; }

    /* ── Table ── */
    .data-table { width: 100%; border-collapse: collapse; }
    .data-table thead tr { background: #fafafa; border-bottom: 1px solid var(--border); }
    .data-table thead th { padding: 10px 16px; font-size: 11px; font-weight: 650; text-transform: uppercase; letter-spacing: .05em; color: var(--text-secondary); white-space: nowrap; text-align: left; }
    .data-table tbody tr { border-bottom: 1px solid var(--border); transition: background .12s; }
    .data-table tbody tr:last-child { border-bottom: none; }
    .data-table tbody tr:hover { background: #fafbfc; }
    .data-table td { padding: 13px 16px; font-size: 13px; color: var(--text-primary); vertical-align: middle; }

    /* ── ID chip / order chip ── */
    .id-chip { display: inline-block; background: var(--bg); border: 1px solid var(--border); border-radius: 6px; padding: 2px 8px; font-size: 11.5px; font-family: 'SF Mono','Fira Mono',monospace; color: var(--text-secondary); }
    .order-chip { display: inline-flex; align-items: center; justify-content: center; min-width: 26px; height: 22px; padding: 0 6px; border-radius: 6px; background: var(--accent-light); color: var(--accent); font-size: 11.5px; font-weight: 700; }

    /* ── Slide thumbnail ── */
    .slide-thumb { width: 70px; height: 44px; border-radius: var(--radius-sm); object-fit: cover; border: 1px solid var(--border); display: block; }
    .slide-thumb-ph { width: 70px; height: 44px; border-radius: var(--radius-sm); background: var(--bg); border: 1px solid var(--border); display: flex; align-items: center; justify-content: center; color: var(--text-hint); font-size: 16px; }

    /* ── Text cells ── */
    .slide-title { font-size: 13.5px; font-weight: 600; color: var(--text-primary); line-height: 1.4; }
    .slide-subtitle { font-size: 12.5px; color: var(--text-secondary); }
    .text-empty { color: var(--text-hint); }

    /* ── Pills ── */
    .pill { display: inline-flex; align-items: center; gap: 5px; padding: 3px 10px; border-radius: 20px; font-size: 11.5px; font-weight: 600; white-space: nowrap; }
    .pill::before { content:''; width:6px; height:6px; border-radius:50%; flex-shrink:0; }
    .pill-active   { background: var(--green-bg); color: var(--green); }
    .pill-active::before   { background: var(--green); }
    .pill-inactive { background: var(--red-bg);   color: var(--red); }
    .pill-inactive::before { background: var(--red); }

    /* ── Action buttons ── */
    .action-btn {
        display: inline-flex; align-items: center; justify-content: center;
        width: 30px; height: 30px; border-radius: var(--radius-sm);
        border: 1px solid var(--border); background: var(--surface);
        color: var(--text-secondary); cursor: pointer; text-decoration: none;
        transition: all .15s; font-size: 12px;
    }
    .action-btn:hover        { background: var(--bg); color: var(--text-primary); border-color: #c9cccf; }
    .action-btn.edit:hover   { background: var(--accent-light); color: var(--accent); border-color: rgba(48,61,137,.25); }
    .action-btn.danger:hover { background: var(--red-bg); color: var(--red); border-color: #f5c0c0; }

    /* ── Empty state ── */
    .empty-state { text-align: center; padding: 56px 24px; }
    .empty-icon-wrap { width: 56px; height: 56px; border-radius: 50%; background: var(--accent-light); margin: 0 auto 16px; display: flex; align-items: center; justify-content: center; color: var(--accent); font-size: 22px; }
    .empty-state h6 { font-size: 14px; font-weight: 650; color: var(--text-primary); margin: 0 0 6px; }
    .empty-state p  { font-size: 13px; color: var(--text-hint); margin: 0 0 20px; }

    /* ── Pagination ── */
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
                    <h1>Hero Slides</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        <a href="{{ route('admin.home-page.index') }}">Home Page</a>
                        <span>›</span>
                        Hero Slides
                    </div>
                </div>
                <a href="{{ route('admin.home-hero-slides.create') }}" class="btn-primary-dash">
                    <i class="fa fa-plus"></i> Add Hero Slide
                </a>
            </div>

            @if(session('success'))
                <div class="alert-banner alert-success">
                    <i class="fa fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <!-- Main card -->
            <div class="list-card">
                <div style="overflow-x:auto">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th style="width:60px">ID</th>
                                <th style="width:100px">Image</th>
                                <th>Subtitle</th>
                                <th>Title</th>
                                <th style="width:100px">Sort Order</th>
                                <th style="width:110px">Status</th>
                                <th style="width:90px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse($items as $item)

                                <tr id="row{{ $item->id }}">

                                    <td><span class="id-chip">{{ $item->id }}</span></td>

                                    <td>
                                        @if($item->image)
                                            <img src="{{ asset('storage/'.$item->image) }}" class="slide-thumb" alt="{{ $item->title }}">
                                        @else
                                            <div class="slide-thumb-ph"><i class="fa fa-image"></i></div>
                                        @endif
                                    </td>

                                    <td>
                                        @if($item->subtitle)
                                            <span class="slide-subtitle">{{ $item->subtitle }}</span>
                                        @else
                                            <span class="slide-subtitle text-empty">—</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if($item->title)
                                            <span class="slide-title">{{ $item->title }}</span>
                                        @else
                                            <span class="slide-title text-empty">—</span>
                                        @endif
                                    </td>

                                    <td><span class="order-chip">{{ $item->sort_order }}</span></td>

                                    <td>
                                        @if($item->status)
                                            <span class="pill pill-active">Active</span>
                                        @else
                                            <span class="pill pill-inactive">Inactive</span>
                                        @endif
                                    </td>

                                    <td>
                                        <div style="display:flex;gap:6px">
                                            <a href="{{ route('admin.home-hero-slides.edit', $item->id) }}"
                                               class="action-btn edit" title="Edit">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <button type="button" class="action-btn danger" title="Delete"
                                                onclick="deleteItem({{ $item->id }})">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="7">
                                        <div class="empty-state">
                                            <div class="empty-icon-wrap">
                                                <i class="fa fa-images"></i>
                                            </div>
                                            <h6>No Hero Slides Found</h6>
                                            <p>Add your first slide to populate the homepage hero banner.</p>
                                            <a href="{{ route('admin.home-hero-slides.create') }}" class="btn-primary-dash">
                                                <i class="fa fa-plus"></i> Add Hero Slide
                                            </a>
                                        </div>
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>
                    </table>
                </div>

                @if(isset($items) && method_exists($items, 'hasPages') && $items->hasPages())
                    <div class="pagination-bar">
                        {{ $items->links('pagination::bootstrap-4') }}
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
        title: 'Delete Hero Slide?',
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Yes, Delete'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ url('admin/home-hero-slides/delete') }}/" + id,
                type: 'DELETE',
                data: { _token: "{{ csrf_token() }}" },
                success: function (res) {
                    Swal.fire('Deleted!', res.message, 'success');
                    $("#row" + id).fadeOut(400, function () {
                        $(this).remove();
                    });
                }
            });
        }
    });
}
</script>