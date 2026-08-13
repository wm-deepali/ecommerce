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
        --amber:         #916a00;
        --amber-bg:      #fff5cc;
        --blue:          #0069d9;
        --blue-bg:       #e8f2ff;
        --radius-sm:     8px;
        --radius-md:     12px;
        --shadow-card:   0 1px 3px rgba(0,0,0,.08), 0 0 0 1px var(--border);
        --font:          'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }

    .attr-page { background: var(--bg); padding: 24px 28px; min-height: 100vh; font-family: var(--font); color: var(--text-primary); }
    .attr-page * { box-sizing: border-box; }

    /* ── Page header ────────────────────────────────────────── */
    .attr-page-header { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 20px; }
    .attr-page-header h1 { font-size: 20px; font-weight: 650; color: var(--text-primary); margin: 0; }
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
    }
    .btn-primary-dash:hover { background: #252f70; }

    /* ── Main card ──────────────────────────────────────────── */
    .attr-card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius-md); box-shadow: var(--shadow-card); overflow: hidden;
    }

    /* ── Table ──────────────────────────────────────────────── */
    .attr-table-wrap { overflow-x: auto; }

    .attr-table { width: 100%; border-collapse: collapse; font-size: 13px; font-family: var(--font); }

    .attr-table thead th {
        font-size: 11px; font-weight: 600; letter-spacing: .06em;
        text-transform: uppercase; color: var(--text-hint);
        padding: 10px 16px; border-bottom: 1px solid var(--border);
        background: #fafafa; text-align: left; white-space: nowrap;
    }

    .attr-table tbody tr { border-bottom: 1px solid var(--border); transition: background .1s; }
    .attr-table tbody tr:last-child { border-bottom: none; }
    .attr-table tbody tr:hover { background: #fafbfc; }
    .attr-table tbody td { padding: 12px 16px; color: var(--text-primary); vertical-align: middle; }

    /* ── ID chip ────────────────────────────────────────────── */
    .id-chip {
        display: inline-block; background: var(--bg); color: var(--text-secondary);
        font-size: 11px; font-weight: 700; padding: 2px 7px; border-radius: 6px;
        font-family: 'SF Mono', 'Fira Code', monospace;
    }

    /* ── Slug code ──────────────────────────────────────────── */
    .slug-code {
        display: inline-block; background: var(--bg); color: var(--accent);
        font-size: 12px; font-weight: 500; padding: 3px 8px; border-radius: 6px;
        font-family: 'SF Mono', 'Fira Code', monospace; letter-spacing: .01em;
    }

    /* ── Type badge ─────────────────────────────────────────── */
    .type-badge {
        display: inline-flex; align-items: center; gap: 5px;
        font-size: 12px; font-weight: 500; padding: 3px 9px;
        border-radius: 6px; background: var(--bg); color: var(--text-secondary);
    }

    /* ── Pills ──────────────────────────────────────────────── */
    .pill {
        display: inline-flex; align-items: center; gap: 4px;
        font-size: 11.5px; font-weight: 600; padding: 3px 9px; border-radius: 20px;
    }
    .pill::before { content: ''; width: 5px; height: 5px; border-radius: 50%; display: inline-block; }

    .pill-active   { background: var(--green-bg); color: var(--green); }
    .pill-active::before   { background: var(--green); }

    .pill-inactive { background: var(--red-bg); color: var(--red); }
    .pill-inactive::before { background: var(--red); }

    .pill-yes      { background: var(--accent-light); color: var(--accent); }
    .pill-yes::before      { background: var(--accent); }

    .pill-no       { background: var(--bg); color: var(--text-hint); }
    .pill-no::before       { background: var(--text-hint); }

    /* ── Action buttons ─────────────────────────────────────── */
    .action-btn {
        display: inline-flex; align-items: center; justify-content: center;
        width: 30px; height: 30px; border-radius: var(--radius-sm);
        border: 1px solid var(--border); background: var(--surface);
        color: var(--text-secondary); font-size: 12px; cursor: pointer;
        transition: all .12s; text-decoration: none;
    }
    .action-btn:hover { background: var(--bg); color: var(--text-primary); }
    .action-btn-danger:hover { background: var(--red-bg); border-color: #f5c6c6; color: var(--red); }

    /* ── Empty state ────────────────────────────────────────── */
    .empty-state { text-align: center; padding: 64px 20px; }
    .empty-state .empty-icon {
        width: 56px; height: 56px; border-radius: 50%; background: var(--bg);
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 22px; color: var(--text-hint); margin-bottom: 14px;
    }
    .empty-state p { font-size: 14px; color: var(--text-secondary); margin: 6px 0 16px; }

    /* ── Pagination ─────────────────────────────────────────── */
    .attr-pagination {
        padding: 14px 20px; border-top: 1px solid var(--border);
        display: flex; justify-content: center; background: var(--surface);
    }

    @media(max-width:768px) { .attr-page { padding: 16px; } }
    </style>

    <div class="app-content content container-fluid">
        <div class="attr-page">

            <!-- Page header -->
            <div class="attr-page-header">
                <div>
                    <h1>Attributes</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        Manage Attributes
                    </div>
                </div>
                <a href="{{ route('admin.attributes.create') }}" class="btn-primary-dash">
                    <i class="fa fa-plus"></i> Add Attribute
                </a>
            </div>

            <!-- Main card -->
            <div class="attr-card">
                <div class="attr-table-wrap">
                    <table class="attr-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Type</th>
                                <th>Has Values</th>
                                <th>Status</th>
                                <th>Show in Navbar</th>
                                <th style="width:90px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($attributes as $attribute)
                                <tr id="row{{ $attribute->id }}">

                                    <td><span class="id-chip">{{ $attribute->id }}</span></td>

                                    <td>
                                        <span style="font-weight:600;color:var(--text-primary)">
                                            {{ $attribute->name }}
                                        </span>
                                    </td>

                                    <td><span class="slug-code">{{ $attribute->slug }}</span></td>

                                    <td>
                                        <span class="type-badge">
                                            @php
                                                $typeIcons = [
                                                    'text'   => 'fa-font',
                                                    'color'  => 'fa-paint-brush',
                                                    'select' => 'fa-list',
                                                    'radio'  => 'fa-dot-circle-o',
                                                    'checkbox' => 'fa-check-square-o',
                                                ];
                                                $icon = $typeIcons[$attribute->type] ?? 'fa-tag';
                                            @endphp
                                            <i class="fa {{ $icon }}"></i>
                                            {{ ucfirst($attribute->type) }}
                                        </span>
                                    </td>

                                    <td>
                                        {!! $attribute->has_values
                                            ? '<span class="pill pill-yes">Yes</span>'
                                            : '<span class="pill pill-no">No</span>' !!}
                                    </td>

                                    <td>
                                        {!! $attribute->status
                                            ? '<span class="pill pill-active">Active</span>'
                                            : '<span class="pill pill-inactive">Inactive</span>' !!}
                                    </td>

                                    <td>
    {!! $attribute->show_in_navbar
        ? '<span class="pill pill-yes">Yes</span>'
        : '<span class="pill pill-no">No</span>' !!}
</td>

                                    <td>
                                        <div style="display:flex;gap:6px">
                                            <a href="{{ route('admin.attributes.edit', $attribute->id) }}"
                                                class="action-btn" title="Edit">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <button class="action-btn action-btn-danger"
                                                onclick="deleteAttribute({{ $attribute->id }})" title="Delete">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">
                                        <div class="empty-state">
                                            <div class="empty-icon"><i class="fa fa-tags"></i></div>
                                            <strong style="font-size:14px;color:var(--text-primary)">No attributes found</strong>
                                            <p>Attributes define product properties like size, colour, or material.</p>
                                            <a href="{{ route('admin.attributes.create') }}" class="btn-primary-dash">
                                                <i class="fa fa-plus"></i> Add Attribute
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="attr-pagination">
                    {{ $attributes->links('pagination::bootstrap-4') }}
                </div>
            </div>

        </div>
    </div>
</div>

@include('admin.footer')

<script>
function deleteAttribute(id) {
    Swal.fire({
        title: 'Delete Attribute?',
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#b22222',
        cancelButtonColor: '#6d7175',
        confirmButtonText: 'Yes, Delete'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ url('admin/attributes') }}/" + id,
                type: 'DELETE',
                data: { _token: "{{ csrf_token() }}" },
                beforeSend: function () { Swal.showLoading(); },
                success: function (res) {
                    Swal.fire('Deleted!', res.message, 'success');
                    $('#row' + id).fadeOut(300, function () { $(this).remove(); });
                },
                error: function () {
                    Swal.fire('Error!', 'Something went wrong.', 'error');
                }
            });
        }
    });
}
</script>