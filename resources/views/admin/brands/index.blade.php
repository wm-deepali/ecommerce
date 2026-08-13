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

    .brands-page { background: var(--bg); padding: 24px 28px; min-height: 100vh; font-family: var(--font); color: var(--text-primary); }
    .brands-page * { box-sizing: border-box; }

    /* Header */
    .brands-page-header { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 20px; }
    .brands-page-header h1 { font-size: 20px; font-weight: 650; color: var(--text-primary); margin: 0; }
    .crumb { font-size: 12.5px; color: var(--text-hint); margin-top: 3px; }
    .crumb a { color: var(--accent); text-decoration: none; }
    .crumb a:hover { text-decoration: underline; }
    .crumb span { margin: 0 5px; }

    /* Buttons */
    .btn-primary-dash {
        display: inline-flex; align-items: center; gap: 6px;
        background: var(--accent); color: #fff !important; border: none;
        border-radius: var(--radius-sm); padding: 8px 16px;
        font-size: 13px; font-weight: 600; cursor: pointer;
        text-decoration: none !important; font-family: var(--font);
        transition: background .15s; box-shadow: 0 1px 3px rgba(48,61,137,.25);
    }
    .btn-primary-dash:hover { background: #252f70; }
    .btn-secondary-dash {
        display: inline-flex; align-items: center; gap: 6px;
        background: var(--surface); color: var(--text-primary) !important;
        border: 1px solid var(--border); border-radius: var(--radius-sm);
        padding: 8px 16px; font-size: 13px; font-weight: 500; cursor: pointer;
        text-decoration: none !important; font-family: var(--font); transition: background .15s;
        box-shadow: 0 1px 2px rgba(0,0,0,.04);
    }
    .btn-secondary-dash:hover { background: var(--bg); }

    /* Card */
    .brands-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-md); box-shadow: var(--shadow-card); overflow: hidden; }

    /* Table */
    .brands-table-wrap { overflow-x: auto; }
    .brands-table { width: 100%; border-collapse: collapse; font-size: 13px; font-family: var(--font); }
    .brands-table thead th {
        font-size: 11px; font-weight: 600; letter-spacing: .06em; text-transform: uppercase;
        color: var(--text-hint); padding: 10px 16px; border-bottom: 1px solid var(--border);
        background: #fafafa; text-align: left; white-space: nowrap;
    }
    .brands-table tbody tr { border-bottom: 1px solid var(--border); transition: background .1s; }
    .brands-table tbody tr:last-child { border-bottom: none; }
    .brands-table tbody tr:hover { background: #fafbfc; }
    .brands-table tbody td { padding: 12px 16px; color: var(--text-primary); vertical-align: middle; }

    /* ID chip */
    .id-chip { display: inline-block; background: var(--bg); color: var(--text-secondary); font-size: 11px; font-weight: 700; padding: 2px 7px; border-radius: 6px; font-family: 'SF Mono','Fira Code',monospace; }

    /* Brand logo */
    .brand-logo { width: 48px; height: 48px; border-radius: var(--radius-sm); object-fit: cover; border: 1px solid var(--border); background: var(--bg); }
    .brand-logo-placeholder { width: 48px; height: 48px; border-radius: var(--radius-sm); background: var(--bg); border: 1px solid var(--border); display: flex; align-items: center; justify-content: center; color: var(--text-hint); font-size: 18px; }

    /* Brand name */
    .brand-name { font-weight: 600; font-size: 13px; color: var(--text-primary); }

    /* Category tags */
    .cat-tags { display: flex; flex-wrap: wrap; gap: 5px; }
    .cat-tag { display: inline-flex; align-items: center; background: var(--accent-light); color: var(--accent); font-size: 11.5px; font-weight: 600; padding: 2px 9px; border-radius: 20px; }
    .cat-tag-empty { font-size: 12px; color: var(--text-hint); font-style: italic; }

    /* Pills */
    .pill { display: inline-flex; align-items: center; gap: 4px; font-size: 11.5px; font-weight: 600; padding: 3px 9px; border-radius: 20px; }
    .pill::before { content: ''; width: 5px; height: 5px; border-radius: 50%; display: inline-block; }
    .pill-active   { background: var(--green-bg); color: var(--green); }
    .pill-active::before { background: var(--green); }
    .pill-inactive { background: var(--red-bg); color: var(--red); }
    .pill-inactive::before { background: var(--red); }

    /* Action buttons */
    .action-btn { display: inline-flex; align-items: center; justify-content: center; width: 30px; height: 30px; border-radius: var(--radius-sm); border: 1px solid var(--border); background: var(--surface); color: var(--text-secondary); font-size: 12px; cursor: pointer; transition: all .12s; text-decoration: none; }
    .action-btn:hover { background: var(--bg); color: var(--text-primary); }
    .action-btn-danger:hover { background: var(--red-bg); border-color: #f5c6c6; color: var(--red); }

    /* Empty state */
    .empty-state { text-align: center; padding: 64px 20px; }
    .empty-state .empty-icon { width: 56px; height: 56px; border-radius: 50%; background: var(--bg); display: inline-flex; align-items: center; justify-content: center; font-size: 22px; color: var(--text-hint); margin-bottom: 14px; }
    .empty-state p { font-size: 14px; color: var(--text-secondary); margin: 6px 0 16px; }

    /* Pagination */
    .brands-pagination { padding: 14px 20px; border-top: 1px solid var(--border); display: flex; justify-content: center; background: var(--surface); }

    @media(max-width:768px) { .brands-page { padding: 16px; } }
    </style>

    <div class="app-content content container-fluid">
        <div class="brands-page">

            <!-- Page header -->
            <div class="brands-page-header">
                <div>
                    <h1>Brands</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        Manage Brands
                    </div>
                </div>
                <div style="display:flex;gap:8px;flex-wrap:wrap">
                    <a href="{{ route('admin.brands.import') }}" class="btn-secondary-dash">
                        <i class="fa fa-upload"></i> Bulk Import
                    </a>
                    <a href="{{ route('admin.brands.create') }}" class="btn-primary-dash">
                        <i class="fa fa-plus"></i> Add Brand
                    </a>
                </div>
            </div>

            <!-- Main card -->
            <div class="brands-card">
                <div class="brands-table-wrap">
                    <table class="brands-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Logo</th>
                                <th>Brand Name</th>
                                <th>Categories</th>
                                <th>Status</th>
                                <th style="width:90px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($brands as $brand)
                                <tr id="row{{ $brand->id }}">

                                    <td><span class="id-chip">{{ $brand->id }}</span></td>

                                    <td>
                                        @if($brand->logo)
                                            <img src="{{ asset('storage/' . $brand->logo) }}" class="brand-logo" alt="{{ $brand->name }}">
                                        @else
                                            <div class="brand-logo-placeholder">
                                                <i class="fa fa-building"></i>
                                            </div>
                                        @endif
                                    </td>

                                    <td>
                                        <span class="brand-name">{{ $brand->name }}</span>
                                    </td>

                                    <td>
                                        <div class="cat-tags">
                                            @forelse($brand->categories as $category)
                                                <span class="cat-tag">{{ $category->name }}</span>
                                            @empty
                                                <span class="cat-tag-empty">No categories</span>
                                            @endforelse
                                        </div>
                                    </td>

                                    <td>
                                        @if($brand->status)
                                            <span class="pill pill-active">Active</span>
                                        @else
                                            <span class="pill pill-inactive">Inactive</span>
                                        @endif
                                    </td>

                                    <td>
                                        <div style="display:flex;gap:6px">
                                            <a href="{{ route('admin.brands.edit', $brand->id) }}"
                                                class="action-btn" title="Edit">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <button class="action-btn action-btn-danger"
                                                onclick="deleteBrand({{ $brand->id }})" title="Delete">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">
                                        <div class="empty-state">
                                            <div class="empty-icon"><i class="fa fa-building-o"></i></div>
                                            <strong style="font-size:14px;color:var(--text-primary)">No brands found</strong>
                                            <p>Add brands and link them to categories to display on your store.</p>
                                            <a href="{{ route('admin.brands.create') }}" class="btn-primary-dash">
                                                <i class="fa fa-plus"></i> Add Brand
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="brands-pagination">
                    {{ $brands->links('pagination::bootstrap-4') }}
                </div>
            </div>

        </div>
    </div>
</div>

@include('admin.footer')

<script>
function deleteBrand(id) {
    Swal.fire({
        title: 'Delete Brand?',
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#b22222',
        cancelButtonColor: '#6d7175',
        confirmButtonText: 'Yes, Delete'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ url('admin/brands') }}/" + id,
                type: 'DELETE',
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