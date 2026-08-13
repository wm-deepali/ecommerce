@include('admin.top-header')

<div class="main-section">
    @include('admin.header')

    <style>
        :root {
            --bg: #f1f2f4;
            --surface: #ffffff;
            --border: #e3e5e8;
            --text-primary: #202223;
            --text-secondary: #6d7175;
            --text-hint: #8c9196;
            --accent: #303d89;
            --accent-light: #f0f1fc;
            --green: #007a5e;
            --green-bg: #e3f1ec;
            --red: #b22222;
            --red-bg: #fce8e8;
            --radius-sm: 8px;
            --radius-md: 12px;
            --shadow-card: 0 1px 3px rgba(0, 0, 0, .08), 0 0 0 1px var(--border);
            --font: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        .av-page {
            background: var(--bg);
            padding: 24px 28px;
            min-height: 100vh;
            font-family: var(--font);
            color: var(--text-primary);
        }

        .av-page * {
            box-sizing: border-box;
        }

        .av-page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 20px;
        }

        .av-page-header h1 {
            font-size: 20px;
            font-weight: 650;
            color: var(--text-primary);
            margin: 0;
        }

        .crumb {
            font-size: 12.5px;
            color: var(--text-hint);
            margin-top: 3px;
        }

        .crumb a {
            color: var(--accent);
            text-decoration: none;
        }

        .crumb a:hover {
            text-decoration: underline;
        }

        .crumb span {
            margin: 0 5px;
        }

        /* Button */
        .btn-primary-dash {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--accent);
            color: #fff !important;
            border: none;
            border-radius: var(--radius-sm);
            padding: 8px 16px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none !important;
            font-family: var(--font);
            transition: background .15s;
            box-shadow: 0 1px 3px rgba(48, 61, 137, .25);
        }

        .btn-primary-dash:hover {
            background: #252f70;
        }

        /* Card */
        .av-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-card);
            overflow: hidden;
        }

        /* Table */
        .av-table-wrap {
            overflow-x: auto;
        }

        .av-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            font-family: var(--font);
        }

        .av-table thead th {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: var(--text-hint);
            padding: 10px 16px;
            border-bottom: 1px solid var(--border);
            background: #fafafa;
            text-align: left;
            white-space: nowrap;
        }

        .av-table tbody tr {
            border-bottom: 1px solid var(--border);
            transition: background .1s;
        }

        .av-table tbody tr:last-child {
            border-bottom: none;
        }

        .av-table tbody tr:hover {
            background: #fafbfc;
        }

        .av-table tbody td {
            padding: 12px 16px;
            color: var(--text-primary);
            vertical-align: middle;
        }

        /* ID chip */
        .id-chip {
            display: inline-block;
            background: var(--bg);
            color: var(--text-secondary);
            font-size: 11px;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 6px;
            font-family: 'SF Mono', 'Fira Code', monospace;
        }

        /* Attribute tag */
        .attr-tag {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: var(--accent-light);
            color: var(--accent);
            font-size: 12px;
            font-weight: 600;
            padding: 3px 9px;
            border-radius: 6px;
        }

        /* Value display */
        .value-cell {
            font-weight: 600;
            color: var(--text-primary);
            font-size: 13px;
        }

        /* Sort chip */
        .sort-chip {
            display: inline-block;
            background: var(--bg);
            color: var(--text-secondary);
            font-size: 12px;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 6px;
        }

        /* Pills */
        .pill {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11.5px;
            font-weight: 600;
            padding: 3px 9px;
            border-radius: 20px;
        }

        .pill::before {
            content: '';
            width: 5px;
            height: 5px;
            border-radius: 50%;
            display: inline-block;
        }

        .pill-active {
            background: var(--green-bg);
            color: var(--green);
        }

        .pill-active::before {
            background: var(--green);
        }

        .pill-inactive {
            background: var(--red-bg);
            color: var(--red);
        }

        .pill-inactive::before {
            background: var(--red);
        }

        /* Action buttons */
        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
            background: var(--surface);
            color: var(--text-secondary);
            font-size: 12px;
            cursor: pointer;
            transition: all .12s;
            text-decoration: none;
        }

        .action-btn:hover {
            background: var(--bg);
            color: var(--text-primary);
        }

        .action-btn-danger:hover {
            background: var(--red-bg);
            border-color: #f5c6c6;
            color: var(--red);
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 64px 20px;
        }

        .empty-state .empty-icon {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: var(--bg);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: var(--text-hint);
            margin-bottom: 14px;
        }

        .empty-state p {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 6px 0 16px;
        }

        /* Pagination */
        .av-pagination {
            padding: 14px 20px;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: center;
            background: var(--surface);
        }

        @media(max-width:768px) {
            .av-page {
                padding: 16px;
            }
        }
    </style>

    <div class="app-content content container-fluid">
        <div class="av-page">

            <!-- Page header -->
            <div class="av-page-header">
                <div>
                    <h1>Attribute Values</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        Manage Attribute Values
                    </div>
                </div>
                <a href="{{ route('admin.attribute-values.create') }}" class="btn-primary-dash">
                    <i class="fa fa-plus"></i> Add Attribute Value
                </a>
            </div>

            <!-- Main card -->
            <div class="av-card">
                <div class="av-table-wrap">
                    <table class="av-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Attribute</th>
                                <th>Value</th>
                                <th>Preview</th>
                                <th>Hex Code</th>
                                <th>Sort Order</th>
                                <th>Status</th>
                                <th style="width:90px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($attributeValues as $value)
                                                    <tr id="row{{ $value->id }}">

                                                        <td><span class="id-chip">{{ $value->id }}</span></td>

                                                        <td>
                                                            <span class="attr-tag">
                                                                <i class="fa fa-tag"></i>
                                                                {{ $value->attribute->name ?? '—' }}
                                                            </span>
                                                        </td>

                                                        <td>
                                                            <span class="value-cell">
                                                                {{ $value->value }}
                                                            </span>
                                                        </td>

                                                        <td>
                                                            @if($value->image)
                                                                <img src="{{ asset('storage/' . $value->image) }}"
                                                                    style="width:40px;height:40px;object-fit:cover;border-radius:6px;border:1px solid #ddd;">
                                                            @else
                                                                —
                                                            @endif
                                                        </td>

                                                        <td>
                                                            @if($value->hex_code)
                                                                                        <div style="display:flex;align-items:center;gap:8px;">
                                                                                            <span style="
                                                                    width:18px;
                                                                    height:18px;
                                                                    border-radius:50%;
                                                                    border:1px solid #ddd;
                                                                    background:{{ $value->hex_code }};
                                                                    display:inline-block;
                                                                "></span>

                                                                                            <small>{{ $value->hex_code }}</small>
                                                                                        </div>
                                                            @else
                                                                —
                                                            @endif
                                                        </td>

                                                        <td>
                                                            <span class="sort-chip">
                                                                {{ $value->sort_order }}
                                                            </span>
                                                        </td>

                                                        <td>
                                                            {!! $value->status
                                ? '<span class="pill pill-active">Active</span>'
                                : '<span class="pill pill-inactive">Inactive</span>' !!}
                                                        </td>

                                                        <td>
                                                            <div style="display:flex;gap:6px">
                                                                <a href="{{ route('admin.attribute-values.edit', $value->id) }}"
                                                                    class="action-btn" title="Edit">
                                                                    <i class="fa fa-pencil"></i>
                                                                </a>
                                                                <button class="action-btn action-btn-danger"
                                                                    onclick="deleteValue({{ $value->id }})" title="Delete">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </div>
                                                        </td>

                                                    </tr>
                            @empty
                                <tr>
                                    <td colspan="6">
                                        <div class="empty-state">
                                            <div class="empty-icon"><i class="fa fa-list-ul"></i></div>
                                            <strong style="font-size:14px;color:var(--text-primary)">No attribute values
                                                found</strong>
                                            <p>Add values to your attributes, such as Red, Blue, Small, Large.</p>
                                            <a href="{{ route('admin.attribute-values.create') }}" class="btn-primary-dash">
                                                <i class="fa fa-plus"></i> Add Attribute Value
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="av-pagination">
                    {{ $attributeValues->links('pagination::bootstrap-4') }}
                </div>
            </div>

        </div>
    </div>
</div>

@include('admin.footer')

<script>
    function deleteValue(id) {
        Swal.fire({
            title: 'Delete Value?',
            text: 'This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#b22222',
            cancelButtonColor: '#6d7175',
            confirmButtonText: 'Yes, Delete'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('admin/attribute-values') }}/" + id,
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