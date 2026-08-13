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
        --blue:          #0069d9;
        --blue-bg:       #e8f2ff;
        --radius-sm:     8px;
        --radius-md:     12px;
        --shadow-card:   0 1px 3px rgba(0,0,0,.08), 0 0 0 1px var(--border);
        --font:          'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }

    .cam-page { background: var(--bg); padding: 24px 28px; min-height: 100vh; font-family: var(--font); color: var(--text-primary); }
    .cam-page * { box-sizing: border-box; }

    /* Header */
    .cam-page-header { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 20px; }
    .cam-page-header h1 { font-size: 20px; font-weight: 650; color: var(--text-primary); margin: 0; }
    .crumb { font-size: 12.5px; color: var(--text-hint); margin-top: 3px; }
    .crumb a { color: var(--accent); text-decoration: none; }
    .crumb a:hover { text-decoration: underline; }
    .crumb span { margin: 0 5px; }

    /* Button */
    .btn-primary-dash {
        display: inline-flex; align-items: center; gap: 6px;
        background: var(--accent); color: #fff !important; border: none;
        border-radius: var(--radius-sm); padding: 8px 16px;
        font-size: 13px; font-weight: 600; cursor: pointer;
        text-decoration: none !important; font-family: var(--font);
        transition: background .15s; box-shadow: 0 1px 3px rgba(48,61,137,.25);
    }
    .btn-primary-dash:hover { background: #252f70; }

    /* Card */
    .cam-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-md); box-shadow: var(--shadow-card); overflow: hidden; }

    /* Table */
    .cam-table-wrap { overflow-x: auto; }
    .cam-table { width: 100%; border-collapse: collapse; font-size: 13px; font-family: var(--font); }
    .cam-table thead th {
        font-size: 11px; font-weight: 600; letter-spacing: .06em; text-transform: uppercase;
        color: var(--text-hint); padding: 10px 14px; border-bottom: 1px solid var(--border);
        background: #fafafa; text-align: left; white-space: nowrap;
    }
    .cam-table tbody tr { border-bottom: 1px solid var(--border); transition: background .1s; }
    .cam-table tbody tr:last-child { border-bottom: none; }
    .cam-table tbody tr:hover { background: #fafbfc; }
    .cam-table tbody td { padding: 11px 14px; color: var(--text-primary); vertical-align: middle; }

    /* ID chip */
    .id-chip { display: inline-block; background: var(--bg); color: var(--text-secondary); font-size: 11px; font-weight: 700; padding: 2px 7px; border-radius: 6px; font-family: 'SF Mono','Fira Code',monospace; }

    /* Name tags */
    .cat-tag { display: inline-flex; align-items: center; gap: 5px; background: #f3f4f9; color: #3d4a8a; font-size: 12px; font-weight: 600; padding: 3px 9px; border-radius: 6px; }
    .attr-tag { display: inline-flex; align-items: center; gap: 5px; background: var(--accent-light); color: var(--accent); font-size: 12px; font-weight: 600; padding: 3px 9px; border-radius: 6px; }

    /* Boolean mini pills */
    .bool-yes { display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 20px; background: var(--green-bg); color: var(--green); font-size: 10px; font-weight: 700; border-radius: 4px; letter-spacing: .02em; }
    .bool-no  { display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 20px; background: var(--bg); color: var(--text-hint); font-size: 10px; font-weight: 700; border-radius: 4px; letter-spacing: .02em; }

    /* Sort chip */
    .sort-chip { display: inline-block; background: var(--bg); color: var(--text-secondary); font-size: 12px; font-weight: 600; padding: 2px 8px; border-radius: 6px; }

    /* Dependents chip (list of active dependency fields) */
    .deps-chip { display: inline-block; background: var(--blue-bg); color: var(--blue); font-size: 11.5px; font-weight: 600; padding: 2px 8px; border-radius: 6px; }
    .deps-none { display: inline-block; color: var(--text-hint); font-size: 12px; }

    /* Status pills */
    .pill { display: inline-flex; align-items: center; gap: 4px; font-size: 11.5px; font-weight: 600; padding: 3px 9px; border-radius: 20px; }
    .pill::before { content: ''; width: 5px; height: 5px; border-radius: 50%; display: inline-block; }
    .pill-active   { background: var(--green-bg); color: var(--green); }
    .pill-active::before { background: var(--green); }
    .pill-inactive { background: var(--red-bg); color: var(--red); }
    .pill-inactive::before { background: var(--red); }

    /* Column group header */
    .col-group-label {
        font-size: 10px; font-weight: 700; letter-spacing: .08em; text-transform: uppercase;
        color: var(--text-hint); padding: 6px 14px 0; border-bottom: none !important;
        background: #fafafa;
    }

    /* Action buttons */
    .action-btn { display: inline-flex; align-items: center; justify-content: center; width: 30px; height: 30px; border-radius: var(--radius-sm); border: 1px solid var(--border); background: var(--surface); color: var(--text-secondary); font-size: 12px; cursor: pointer; transition: all .12s; text-decoration: none; }
    .action-btn:hover { background: var(--bg); color: var(--text-primary); }
    .action-btn-danger:hover { background: var(--red-bg); border-color: #f5c6c6; color: var(--red); }

    /* Empty state */
    .empty-state { text-align: center; padding: 64px 20px; }
    .empty-state .empty-icon { width: 56px; height: 56px; border-radius: 50%; background: var(--bg); display: inline-flex; align-items: center; justify-content: center; font-size: 22px; color: var(--text-hint); margin-bottom: 14px; }
    .empty-state p { font-size: 14px; color: var(--text-secondary); margin: 6px 0 16px; }

    /* Pagination */
    .cam-pagination { padding: 14px 20px; border-top: 1px solid var(--border); display: flex; justify-content: center; background: var(--surface); }

    @media(max-width:768px) { .cam-page { padding: 16px; } }
    </style>

    <div class="app-content content container-fluid">
        <div class="cam-page">

            <!-- Page header -->
            <div class="cam-page-header">
                <div>
                    <h1>Category Attributes</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        Category Attributes
                    </div>
                </div>
                <a href="{{ route('admin.category-attributes.create') }}" class="btn-primary-dash">
                    <i class="fa fa-plus"></i> Add Mapping
                </a>
            </div>

            <!-- Main card -->
            <div class="cam-card">
                <div class="cam-table-wrap">
                    <table class="cam-table">
                   <thead>
    <tr>
        <th>ID</th>
        <th>Category</th>
        <th>Attribute</th>
        <th>Required</th>
        <th>Variant</th>
        <th>Price</th>
        <th>Stock</th>
        <th>Image</th>
        <th>SKU</th>
        <th>Filter</th>
        <th>Listing</th>
        <th>Sort</th>
        <th>Status</th>
        <th style="width:90px">Actions</th>
    </tr>
</thead>

<tbody>
    @forelse($categoryAttributes as $item)
        <tr id="row{{ $item->id }}">

            <td>
                <span class="id-chip">{{ $item->id }}</span>
            </td>

            <td>
                <span class="cat-tag">
                    <i class="fa fa-folder-o"></i>
                    {{ $item->category->name ?? '—' }}
                </span>
            </td>

            <td>
                <span class="attr-tag">
                    <i class="fa fa-tag"></i>
                    {{ $item->attribute->name ?? '—' }}
                </span>
            </td>

            <td>
                {!! $item->is_required
                    ? '<span class="bool-yes">Yes</span>'
                    : '<span class="bool-no">No</span>' !!}
            </td>

            <td>
                {!! $item->used_for_variant
                    ? '<span class="bool-yes">Yes</span>'
                    : '<span class="bool-no">No</span>' !!}
            </td>

            <td>
                {!! $item->price_dependent
                    ? '<span class="bool-yes">Yes</span>'
                    : '<span class="bool-no">No</span>' !!}
            </td>

            <td>
                {!! $item->stock_dependent
                    ? '<span class="bool-yes">Yes</span>'
                    : '<span class="bool-no">No</span>' !!}
            </td>

            <td>
                {!! $item->image_dependent
                    ? '<span class="bool-yes">Yes</span>'
                    : '<span class="bool-no">No</span>' !!}
            </td>

            <td>
                {!! $item->sku_dependent
                    ? '<span class="bool-yes">Yes</span>'
                    : '<span class="bool-no">No</span>' !!}
            </td>

            <td>
                {!! $item->show_in_filter
                    ? '<span class="bool-yes">Yes</span>'
                    : '<span class="bool-no">No</span>' !!}
            </td>

            <td>
                {!! $item->show_on_listing
                    ? '<span class="bool-yes">Yes</span>'
                    : '<span class="bool-no">No</span>' !!}
            </td>

            <td>
                <span class="sort-chip">{{ $item->sort_order }}</span>
            </td>

            <td>
                {!! $item->status
                    ? '<span class="pill pill-active">Active</span>'
                    : '<span class="pill pill-inactive">Inactive</span>' !!}
            </td>

            <td>
                <div style="display:flex;gap:6px">
                    <a href="{{ route('admin.category-attributes.edit', $item->id) }}"
                        class="action-btn"
                        title="Edit">
                        <i class="fa fa-pencil"></i>
                    </a>

                    <button type="button"
                        class="action-btn action-btn-danger"
                        onclick="deleteMapping({{ $item->id }})"
                        title="Delete">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            </td>

        </tr>
    @empty
        <tr>
            <td colspan="14">
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fa fa-sitemap"></i>
                    </div>

                    <strong style="font-size:14px;color:var(--text-primary)">
                        No mappings found
                    </strong>

                    <p>
                        Map attributes to categories to control variants,
                        pricing, stock, images and SKU behaviour.
                    </p>

                    <a href="{{ route('admin.category-attributes.create') }}"
                        class="btn-primary-dash">
                        <i class="fa fa-plus"></i>
                        Add Mapping
                    </a>
                </div>
            </td>
        </tr>
    @endforelse
</tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="cam-pagination">
                    {{ $categoryAttributes->links('pagination::bootstrap-4') }}
                </div>
            </div>

        </div>
    </div>
</div>

@include('admin.footer')

<script>
function deleteMapping(id) {
    Swal.fire({
        title: 'Delete Mapping?',
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#b22222',
        cancelButtonColor: '#6d7175',
        confirmButtonText: 'Yes, Delete'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ url('admin/category-attributes') }}/" + id,
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