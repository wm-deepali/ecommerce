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
            --amber: #916a00;
            --amber-bg: #fff5cc;
            --star: #f59e0b;
            --radius-sm: 8px;
            --radius-md: 12px;
            --shadow-card: 0 1px 3px rgba(0, 0, 0, .08), 0 0 0 1px var(--border);
            --font: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        .list-page {
            background: var(--bg);
            padding: 24px 28px;
            min-height: 100vh;
            font-family: var(--font);
            color: var(--text-primary);
        }

        .list-page * {
            box-sizing: border-box;
        }

        /* ── Page header ── */
        .list-page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 20px;
        }

        .list-page-header h1 {
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

        /* ── Buttons ── */
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
            white-space: nowrap;
        }

        .btn-primary-dash:hover {
            background: #252f70;
        }

        /* ── Main card ── */
        .list-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-card);
            overflow: hidden;
        }

        /* ── Table ── */
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table thead tr {
            background: #fafafa;
            border-bottom: 1px solid var(--border);
        }

        .data-table thead th {
            padding: 10px 16px;
            font-size: 11px;
            font-weight: 650;
            text-transform: uppercase;
            letter-spacing: .05em;
            color: var(--text-secondary);
            white-space: nowrap;
            text-align: left;
        }

        .data-table tbody tr {
            border-bottom: 1px solid var(--border);
            transition: background .12s;
        }

        .data-table tbody tr:last-child {
            border-bottom: none;
        }

        .data-table tbody tr:hover {
            background: #fafbfc;
        }

        .data-table td {
            padding: 13px 16px;
            font-size: 13px;
            color: var(--text-primary);
            vertical-align: middle;
        }

        /* ── ID chip ── */
        .id-chip {
            display: inline-block;
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 2px 8px;
            font-size: 11.5px;
            font-family: 'SF Mono', 'Fira Mono', monospace;
            color: var(--text-secondary);
        }

        /* ── Customer cell ── */
        .cust-cell {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .cust-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            flex-shrink: 0;
            background: var(--accent-light);
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
            color: var(--accent);
            text-transform: uppercase;
        }

        .cust-avatar img {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            display: block;
        }

        .cust-name {
            font-size: 13.5px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .cust-meta {
            font-size: 12px;
            color: var(--text-hint);
            margin-top: 1px;
        }

        /* ── Type pill ── */
        .type-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
        }

        .type-text {
            background: var(--accent-light);
            color: var(--accent);
        }

        .type-video {
            background: var(--red-bg);
            color: var(--red);
        }

        .type-other {
            background: var(--bg);
            color: var(--text-secondary);
            border: 1px solid var(--border);
        }

        /* ── Star rating ── */
        .star-wrap {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .stars {
            display: flex;
            gap: 2px;
        }

        .stars i {
            font-size: 12px;
            color: #e5e7eb;
        }

        .stars i.filled {
            color: var(--star);
        }

        .star-num {
            font-size: 12.5px;
            font-weight: 700;
            color: var(--text-primary);
        }

        /* ── Status pills ── */
        .pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11.5px;
            font-weight: 600;
            white-space: nowrap;
        }

        .pill::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            flex-shrink: 0;
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

        /* ── Action buttons ── */
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
            cursor: pointer;
            text-decoration: none;
            transition: all .15s;
            font-size: 12px;
        }

        .action-btn:hover {
            background: var(--bg);
            color: var(--text-primary);
        }

        .action-btn.edit:hover {
            background: var(--accent-light);
            color: var(--accent);
            border-color: rgba(48, 61, 137, .25);
        }

        .action-btn.danger:hover {
            background: var(--red-bg);
            color: var(--red);
            border-color: #f5c0c0;
        }

        /* ── Empty state ── */
        .empty-state {
            text-align: center;
            padding: 56px 24px;
        }

        .empty-icon-wrap {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: var(--accent-light);
            margin: 0 auto 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent);
            font-size: 22px;
        }

        .empty-state h6 {
            font-size: 14px;
            font-weight: 650;
            color: var(--text-primary);
            margin: 0 0 6px;
        }

        .empty-state p {
            font-size: 13px;
            color: var(--text-hint);
            margin: 0 0 20px;
        }

        /* ── Pagination ── */
        .pagination-bar {
            padding: 14px 20px;
            border-top: 1px solid var(--border);
        }

        .pagination-bar .pagination {
            margin: 0;
        }

        .pagination-bar .page-link {
            border-color: var(--border);
            color: var(--accent);
            font-size: 13px;
            border-radius: var(--radius-sm) !important;
            margin: 0 2px;
        }

        .pagination-bar .page-item.active .page-link {
            background: var(--accent);
            border-color: var(--accent);
            color: #fff;
        }

        .pagination-bar .page-item.disabled .page-link {
            color: var(--text-hint);
        }

        @media(max-width:768px) {
            .list-page {
                padding: 16px;
            }
        }
    </style>

    <div class="app-content content container-fluid">
        <div class="list-page">

            <!-- Page header -->
            <div class="list-page-header">
                <div>
                    <h1>Testimonials</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        Testimonials
                    </div>
                </div>
                <a href="{{ route('admin.testimonials.create') }}" class="btn-primary-dash">
                    <i class="fa fa-plus"></i> Add Testimonial
                </a>
            </div>

            <!-- Main card -->
            <div class="list-card">
                <div style="overflow-x:auto">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th style="width:60px">ID</th>
                                <th style="min-width:180px">Customer</th>
                                <th style="width:110px">Type</th>
                                <th style="width:130px">Rating</th>
                                <th style="width:110px">Status</th>
                                <th style="width:90px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse($testimonials as $t)

                                <tr id="row{{ $t->id }}">

                                    <td><span class="id-chip">{{ $t->id }}</span></td>

                                    <td>
                                        <div class="cust-cell">
                                            <div class="cust-avatar">
                                                @if($t->photo)
                                                    <img src="{{ asset('storage/' . $t->photo) }}" alt="{{ $t->name }}">
                                                @else
                                                    {{ strtoupper(substr($t->name, 0, 1)) }}
                                                @endif
                                            </div>
                                            <div>
                                                <div class="cust-name">{{ $t->name }}</div>
                                                @if($t->designation ?? null)
                                                    <div class="cust-meta">{{ $t->designation }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        @php $type = strtolower($t->type ?? 'text'); @endphp
                                        @if($type === 'video')
                                            <span class="type-pill type-video">
                                                <i class="fa fa-play-circle" style="font-size:11px"></i> Video
                                            </span>
                                        @elseif($type === 'text')
                                            <span class="type-pill type-text">
                                                <i class="fa fa-quote-left" style="font-size:10px"></i> Text
                                            </span>
                                        @else
                                            <span class="type-pill type-other">{{ ucfirst($t->type) }}</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if($t->rating)
                                            <div class="star-wrap">
                                                <div class="stars">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="fa-solid fa-star {{ $i <= $t->rating ? 'filled' : '' }}"></i>
                                                    @endfor
                                                </div>
                                                <span class="star-num">{{ number_format($t->rating, 1) }}</span>
                                            </div>
                                        @else
                                            <span style="font-size:12.5px;color:var(--text-hint)">— No rating</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if($t->status)
                                            <span class="pill pill-active">Active</span>
                                        @else
                                            <span class="pill pill-inactive">Inactive</span>
                                        @endif
                                    </td>

                                    <td>
                                        <div style="display:flex;gap:6px">
                                            <a href="{{ route('admin.testimonials.edit', $t->id) }}" class="action-btn edit"
                                                title="Edit">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <button class="action-btn danger" title="Delete"
                                                onclick="deleteTestimonial({{ $t->id }})">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="6">
                                        <div class="empty-state">
                                            <div class="empty-icon-wrap">
                                                <i class="fa fa-star"></i>
                                            </div>
                                            <h6>No Testimonials Found</h6>
                                            <p>Add your first customer testimonial to build social proof.</p>
                                            <a href="{{ route('admin.testimonials.create') }}" class="btn-primary-dash">
                                                <i class="fa fa-plus"></i> Add Testimonial
                                            </a>
                                        </div>
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>
                    </table>
                </div>

                @if(isset($testimonials) && method_exists($testimonials, 'hasPages') && $testimonials->hasPages())
                    <div class="pagination-bar">
                        {{ $testimonials->links('pagination::bootstrap-4') }}
                    </div>
                @endif

            </div>

        </div>
    </div>
</div>

@include('admin.footer')

<script>
    function deleteTestimonial(id) {
        Swal.fire({
            title: 'Delete Testimonial?',
            text: "This action cannot be undone.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Yes, Delete'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('admin/testimonials') }}/" + id,
                    type: "DELETE",
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