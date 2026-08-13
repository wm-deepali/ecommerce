@include('admin.top-header')

<div class="main-section">
    @include('admin.header')

    <style>
        .main-section{display:flex !important;flex-direction:row !important;align-items:stretch !important;min-height:100vh !important;overflow:hidden !important}
        .main-section #cssmenu{flex-shrink:0 !important;flex-grow:0 !important;width:280px !important;min-width:280px !important;max-width:280px !important;overflow-y:auto !important;overflow-x:hidden !important;position:sticky !important;top:0 !important;height:100vh !important;align-self:flex-start !important}
        .main-section .app-content,.main-section .app-content.content.container-fluid{flex:1 1 0% !important;min-width:0 !important;max-width:100% !important;overflow-x:auto !important;box-sizing:border-box !important}

        :root{
            --bg:#f1f2f4;--surface:#ffffff;--border:#e3e5e8;
            --text-primary:#202223;--text-secondary:#6d7175;--text-hint:#8c9196;
            --accent:#303d89;--accent-light:#f0f1fc;
            --green:#007a5e;--green-bg:#e3f1ec;
            --red:#b22222;--red-bg:#fce8e8;
            --amber:#916a00;--amber-bg:#fff5cc;
            --star:#f59e0b;
            --radius-sm:8px;--radius-md:12px;
            --shadow-card:0 1px 3px rgba(0,0,0,.08),0 0 0 1px var(--border);
            --font:'Inter',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
        }

        .list-page{background:var(--bg);padding:24px 28px;min-height:100vh;font-family:var(--font);color:var(--text-primary)}.list-page *{box-sizing:border-box}.list-page-header{display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:12px;margin-bottom:20px}.list-page-header h1{font-size:20px;font-weight:650;color:var(--text-primary);margin:0}.crumb{font-size:12.5px;color:var(--text-hint);margin-top:3px}.crumb a{color:var(--accent);text-decoration:none}.crumb a:hover{text-decoration:underline}.crumb span{margin:0 5px}.stat-strip{display:grid;grid-template-columns:repeat(5,1fr);gap:14px;margin-bottom:20px}@media(max-width:900px){.stat-strip{grid-template-columns:repeat(3,1fr)}}@media(max-width:600px){.stat-strip{grid-template-columns:repeat(2,1fr)}}.stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius-md);padding:16px 18px;box-shadow:var(--shadow-card)}.stat-label{font-size:11.5px;font-weight:600;text-transform:uppercase;letter-spacing:.04em;color:var(--text-hint);margin-bottom:6px}.stat-value{font-size:22px;font-weight:700;color:var(--text-primary);line-height:1}.stat-sub{font-size:11.5px;color:var(--text-hint);margin-top:4px}.btn-primary-dash{display:inline-flex;align-items:center;gap:6px;background:var(--accent);color:#fff !important;border:none;border-radius:var(--radius-sm);padding:8px 16px;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none !important;font-family:var(--font);transition:background .15s;box-shadow:0 1px 3px rgba(48,61,137,.25);white-space:nowrap}.btn-primary-dash:hover{background:#252f70}.btn-secondary-dash{display:inline-flex;align-items:center;gap:6px;background:var(--surface);color:var(--text-primary) !important;border:1px solid var(--border);border-radius:var(--radius-sm);padding:8px 16px;font-size:13px;font-weight:500;cursor:pointer;text-decoration:none !important;font-family:var(--font);transition:background .15s;white-space:nowrap}.btn-secondary-dash:hover{background:var(--bg)}.list-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius-md);box-shadow:var(--shadow-card);overflow:hidden}.filter-bar{padding:16px 20px;border-bottom:1px solid var(--border)}.filter-row{display:flex;flex-wrap:wrap;gap:12px;align-items:flex-end}.filter-group{display:flex;flex-direction:column;gap:5px}.filter-group label{font-size:12px;font-weight:600;color:var(--text-secondary);letter-spacing:.03em;text-transform:uppercase}.filter-control{height:36px;border:1px solid var(--border);border-radius:var(--radius-sm);padding:0 11px;font-size:13px;color:var(--text-primary);background:var(--surface);outline:none;transition:border-color .15s,box-shadow .15s;font-family:var(--font);min-width:140px}.filter-control:focus{border-color:var(--accent);box-shadow:0 0 0 3px rgba(48,61,137,.12)}.filter-actions{display:flex;gap:8px}.search-wrap{position:relative}.search-wrap .filter-control{padding-left:32px;min-width:220px}.search-wrap .search-ico{position:absolute;left:10px;top:50%;transform:translateY(-50%);color:var(--text-hint);font-size:12px;pointer-events:none}.data-table{width:100%;border-collapse:collapse}.data-table thead tr{background:#fafafa;border-bottom:1px solid var(--border)}.data-table thead th{padding:10px 16px;font-size:11px;font-weight:650;text-transform:uppercase;letter-spacing:.05em;color:var(--text-secondary);white-space:nowrap;text-align:left}.data-table tbody tr{border-bottom:1px solid var(--border);transition:background .12s}.data-table tbody tr:last-child{border-bottom:none}.data-table tbody tr:hover{background:#fafbfc}.data-table td{padding:14px 16px;font-size:13px;color:var(--text-primary);vertical-align:middle}.id-chip{display:inline-block;background:var(--bg);border:1px solid var(--border);border-radius:6px;padding:2px 8px;font-size:11.5px;font-family:'SF Mono','Fira Mono',monospace;color:var(--text-secondary)}.product-cell{display:flex;align-items:center;gap:10px}.product-thumb{width:44px;height:44px;border-radius:var(--radius-sm);object-fit:cover;border:1px solid var(--border);flex-shrink:0}.product-thumb-ph{width:44px;height:44px;border-radius:var(--radius-sm);background:var(--bg);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;color:var(--text-hint);font-size:16px;flex-shrink:0}.product-name{font-size:13px;font-weight:600;color:var(--text-primary);line-height:1.4}.product-sku{font-size:11.5px;color:var(--text-hint);margin-top:2px}.cust-cell{display:flex;align-items:center;gap:9px}.cust-avatar{width:30px;height:30px;border-radius:50%;background:var(--accent-light);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:var(--accent);flex-shrink:0;text-transform:uppercase}.cust-name{font-size:13px;font-weight:500;color:var(--text-primary)}.cust-email{font-size:11.5px;color:var(--text-hint)}.star-row{display:flex;align-items:center;gap:6px}.stars{display:flex;gap:2px}.stars i{font-size:13px;color:#e5e7eb}.stars i.filled{color:var(--star)}.star-num{font-size:12.5px;font-weight:700;color:var(--text-primary)}.review-title{font-size:13px;font-weight:600;color:var(--text-primary);margin-bottom:3px}.review-body{font-size:12.5px;color:var(--text-secondary);line-height:1.5;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;max-width:300px}.review-imgs{display:flex;gap:4px;margin-top:6px}.review-img-thumb{width:32px;height:32px;border-radius:5px;object-fit:cover;border:1px solid var(--border);cursor:pointer;transition:opacity .15s}.review-img-thumb:hover{opacity:.8}.review-img-more{width:32px;height:32px;border-radius:5px;background:var(--bg);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:700;color:var(--text-hint)}.pill{display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:20px;font-size:11.5px;font-weight:600;white-space:nowrap}.pill::before{content:'';width:6px;height:6px;border-radius:50%;flex-shrink:0}.pill-approved{background:var(--green-bg);color:var(--green)}.pill-approved::before{background:var(--green)}.pill-pending{background:var(--amber-bg);color:var(--amber)}.pill-pending::before{background:var(--amber)}.pill-rejected{background:var(--red-bg);color:var(--red)}.pill-rejected::before{background:var(--red)}.rating-tabs{display:flex;gap:6px;flex-wrap:wrap;padding:12px 20px;border-bottom:1px solid var(--border);background:#fafafa}.rating-tab{display:inline-flex;align-items:center;gap:5px;padding:5px 12px;border-radius:20px;font-size:12.5px;font-weight:500;border:1px solid var(--border);background:var(--surface);color:var(--text-secondary);cursor:pointer;text-decoration:none;transition:all .15s}.rating-tab:hover{border-color:var(--accent);color:var(--accent);background:var(--accent-light)}.rating-tab.active{background:var(--accent);border-color:var(--accent);color:#fff}.rating-tab .tab-count{font-size:11px;font-weight:700;opacity:.8}.action-btn{display:inline-flex;align-items:center;justify-content:center;width:30px;height:30px;border-radius:var(--radius-sm);border:1px solid var(--border);background:var(--surface);color:var(--text-secondary);cursor:pointer;text-decoration:none;transition:all .15s;font-size:12px}.action-btn:hover{background:var(--bg);color:var(--text-primary)}.action-btn.approve:hover{background:var(--green-bg);color:var(--green);border-color:#b0ddd0}.action-btn.reject:hover{background:var(--red-bg);color:var(--red);border-color:#f5c0c0}.action-btn.danger:hover{background:var(--red-bg);color:var(--red);border-color:#f5c0c0}.action-btn.view:hover{background:var(--accent-light);color:var(--accent);border-color:rgba(48,61,137,.25)}.verified-badge{display:inline-flex;align-items:center;gap:4px;font-size:11px;font-weight:600;color:var(--green);background:var(--green-bg);border-radius:10px;padding:2px 7px}.empty-state{text-align:center;padding:56px 24px}.empty-icon-wrap{width:56px;height:56px;border-radius:50%;background:var(--accent-light);margin:0 auto 16px;display:flex;align-items:center;justify-content:center;color:var(--accent);font-size:22px}.empty-state h6{font-size:14px;font-weight:650;color:var(--text-primary);margin:0 0 6px}.empty-state p{font-size:13px;color:var(--text-hint);margin:0}.pagination-bar{padding:14px 20px;border-top:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px}.pagination-info{font-size:12.5px;color:var(--text-hint)}.pagination-bar .pagination{margin:0}.pagination-bar .page-link{border-color:var(--border);color:var(--accent);font-size:13px;border-radius:var(--radius-sm) !important;margin:0 2px}.pagination-bar .page-item.active .page-link{background:var(--accent);border-color:var(--accent);color:#fff}.pagination-bar .page-item.disabled .page-link{color:var(--text-hint)}.modal-overlay{position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:9999;display:none;align-items:center;justify-content:center;padding:20px}.modal-overlay.open{display:flex}.modal-box{background:var(--surface);border-radius:var(--radius-md);box-shadow:0 20px 60px rgba(0,0,0,.3);width:100%;max-width:600px;max-height:90vh;overflow-y:auto}.modal-header{padding:18px 24px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between}.modal-header h4{font-size:15px;font-weight:650;margin:0;color:var(--text-primary)}.modal-close{width:30px;height:30px;border-radius:var(--radius-sm);border:1px solid var(--border);background:var(--bg);display:flex;align-items:center;justify-content:center;cursor:pointer;color:var(--text-secondary);font-size:14px;transition:background .15s}.modal-close:hover{background:var(--red-bg);color:var(--red)}.modal-body{padding:24px}.modal-section{margin-bottom:20px}.modal-section:last-child{margin-bottom:0}.modal-label{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:var(--text-hint);margin-bottom:6px}.modal-value{font-size:13.5px;color:var(--text-primary);line-height:1.6}.modal-product-row{display:flex;align-items:center;gap:12px;padding:12px;background:var(--bg);border-radius:var(--radius-sm);border:1px solid var(--border)}.modal-actions{display:flex;gap:10px;padding:16px 24px;border-top:1px solid var(--border);background:#fafafa;border-radius:0 0 var(--radius-md) var(--radius-md)}.btn-approve{display:inline-flex;align-items:center;gap:6px;background:var(--green-bg);color:var(--green) !important;border:1px solid #b0ddd0;border-radius:var(--radius-sm);padding:8px 16px;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none !important;font-family:var(--font);transition:background .15s}.btn-approve:hover{background:#c8ede3}.btn-reject{display:inline-flex;align-items:center;gap:6px;background:var(--red-bg);color:var(--red) !important;border:1px solid #f5c0c0;border-radius:var(--radius-sm);padding:8px 16px;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none !important;font-family:var(--font);transition:background .15s}.btn-reject:hover{background:#f8d0d0}.btn-delete{display:inline-flex;align-items:center;gap:6px;background:var(--surface);color:var(--red) !important;border:1px solid var(--border);border-radius:var(--radius-sm);padding:8px 16px;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none !important;font-family:var(--font);transition:background .15s;margin-left:auto}.btn-delete:hover{background:var(--red-bg);border-color:#f5c0c0}.fa-star.filled,.fa-solid.fa-star.filled{color:#f59e0b !important}
        @media(max-width:768px){.list-page{padding:16px}}
    </style>

    <div class="app-content content container-fluid">
        <div class="list-page">

            {{-- Page header --}}
            <div class="list-page-header">
                <div>
                    <h1>Product Reviews</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span> Product Reviews
                    </div>
                </div>
                <div style="display:flex;gap:10px;flex-wrap:wrap">
                    <a href="{{ route('admin.reviews.export') }}" class="btn-secondary-dash">
                        <i class="fa fa-download"></i> Export CSV
                    </a>
                </div>
            </div>

            {{-- Stats strip --}}
            <div class="stat-strip">
                <div class="stat-card">
                    <div class="stat-label">Total Reviews</div>
                    <div class="stat-value">{{ number_format($totalReviews) }}</div>
                    <div class="stat-sub">All time</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Avg Rating</div>
                    <div class="stat-value" style="color:var(--star);display:flex;align-items:center;gap:6px">
                        {{ $avgRating }}
                        <i class="fa-solid fa-star" style="font-size:18px"></i>
                    </div>
                    <div class="stat-sub">Out of 5.0</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Pending</div>
                    <div class="stat-value" style="color:var(--amber)">{{ $pendingCount }}</div>
                    <div class="stat-sub">Awaiting approval</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Approved</div>
                    <div class="stat-value" style="color:var(--green)">{{ number_format($approvedCount) }}</div>
                    <div class="stat-sub">Published</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Rejected</div>
                    <div class="stat-value" style="color:var(--red)">{{ $rejectedCount }}</div>
                    <div class="stat-sub">Hidden from store</div>
                </div>
            </div>

            {{-- Main card --}}
            <div class="list-card">

                {{-- Filter bar --}}
                <div class="filter-bar">
                    <form method="GET" action="{{ route('admin.reviews.index') }}">
                        <div class="filter-row">

                            <div class="filter-group" style="flex:1;min-width:200px">
                                <label>Search</label>
                                <div class="search-wrap">
                                    <i class="fa fa-search search-ico"></i>
                                    <input type="text" name="search" class="filter-control"
                                           placeholder="Product, customer, keyword…"
                                           value="{{ request('search') }}">
                                </div>
                            </div>

                            <div class="filter-group">
                                <label>Status</label>
                                <select name="status" class="filter-control">
                                    <option value="">All Status</option>
                                    @foreach(['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected'] as $val => $label)
                                        <option value="{{ $val }}" {{ request('status') === $val ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="filter-group">
                                <label>Rating</label>
                                <select name="rating" class="filter-control">
                                    <option value="">All Ratings</option>
                                    @foreach([5 => '★★★★★ 5 Star', 4 => '★★★★☆ 4 Star', 3 => '★★★☆☆ 3 Star', 2 => '★★☆☆☆ 2 Star', 1 => '★☆☆☆☆ 1 Star'] as $val => $label)
                                        <option value="{{ $val }}" {{ request('rating') == $val ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="filter-group">
                                <label>Verified</label>
                                <select name="verified" class="filter-control">
                                    <option value="">All</option>
                                    <option value="1" {{ request('verified') === '1' ? 'selected' : '' }}>Verified Purchase</option>
                                    <option value="0" {{ request('verified') === '0' ? 'selected' : '' }}>Unverified</option>
                                </select>
                            </div>

                            <div class="filter-group">
                                <label>Date</label>
                                <select name="period" class="filter-control">
                                    <option value="">All Time</option>
                                    @foreach(['today' => 'Today', 'week' => 'This Week', 'month' => 'This Month'] as $val => $label)
                                        <option value="{{ $val }}" {{ request('period') === $val ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="filter-actions">
                                <button type="submit" class="btn-primary-dash">
                                    <i class="fa fa-search"></i> Filter
                                </button>
                                <a href="{{ route('admin.reviews.index') }}" class="btn-secondary-dash">
                                    <i class="fa fa-refresh"></i> Reset
                                </a>
                            </div>

                        </div>
                    </form>
                </div>

                {{-- Rating tabs --}}
                <div class="rating-tabs">
                    <a href="{{ route('admin.reviews.index', array_merge(request()->except('rating'), [])) }}"
                       class="rating-tab {{ !request('rating') ? 'active' : '' }}">
                        All <span class="tab-count">({{ number_format($totalReviews) }})</span>
                    </a>
                    @foreach([5,4,3,2,1] as $star)
                        <a href="{{ route('admin.reviews.index', array_merge(request()->except('rating'), ['rating' => $star])) }}"
                           class="rating-tab {{ request('rating') == $star ? 'active' : '' }}">
                            <i class="fa-solid fa-star" style="color:var(--star);font-size:11px"></i>
                            {{ $star }} Star
                            <span class="tab-count">({{ number_format($ratingCounts[$star] ?? 0) }})</span>
                        </a>
                    @endforeach
                </div>

                {{-- Table --}}
                <div style="overflow-x:auto">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th style="width:60px">ID</th>
                                <th style="min-width:200px">Product</th>
                                <th style="min-width:160px">Customer</th>
                                <th style="width:120px">Rating</th>
                                <th style="min-width:280px">Review</th>
                                <th style="width:110px">Verified</th>
                                <th style="width:110px">Status</th>
                                <th style="width:120px">Date</th>
                                <th style="width:120px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                        @forelse($reviews as $review)
                            <tr id="review_row_{{ $review->id }}">

                                {{-- ID --}}
                                <td><span class="id-chip">{{ str_pad($review->id, 3, '0', STR_PAD_LEFT) }}</span></td>

                                {{-- Product --}}
                                <td>
                                    <div class="product-cell">
                                        @if($review->product?->display_image)
                                            <img src="{{ $review->product->display_image }}"
                                                 class="product-thumb" alt="{{ $review->product->name }}">
                                        @else
                                            <div class="product-thumb-ph"><i class="fa fa-image"></i></div>
                                        @endif
                                        <div>
                                            <div class="product-name">{{ $review->product?->name ?? '—' }}</div>
                                            <div class="product-sku">SKU: {{ $review->product?->sku ?? '—' }}</div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Customer --}}
                                <td>
                                    <div class="cust-cell">
                                        <div class="cust-avatar">
                                            {{ strtoupper(substr($review->customer?->name ?? '?', 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="cust-name">{{ $review->customer?->name ?? '—' }}</div>
                                            <div class="cust-email">{{ $review->customer?->email ?? '' }}</div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Rating --}}
                                <td>
                                    <div class="star-row">
                                        <div class="stars">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fa-solid fa-star {{ $i <= $review->rating ? 'filled' : '' }}"></i>
                                            @endfor
                                        </div>
                                        <span class="star-num">{{ $review->rating }}.0</span>
                                    </div>
                                </td>

                                {{-- Review text + images --}}
                                <td>
                                    @if($review->title)
                                        <div class="review-title">{{ $review->title }}</div>
                                    @endif
                                    @if($review->review)
                                        <div class="review-body">{{ $review->review }}</div>
                                    @endif
                                    @if($review->images->count())
                                        <div class="review-imgs">
                                            @foreach($review->images->take(3) as $img)
                                                <img src="{{ $img->url }}" class="review-img-thumb" alt="">
                                            @endforeach
                                            @if($review->images->count() > 3)
                                                <div class="review-img-more">+{{ $review->images->count() - 3 }}</div>
                                            @endif
                                        </div>
                                    @endif
                                </td>

                                {{-- Verified --}}
                                <td>
                                    @if($review->verified_purchase)
                                        <span class="verified-badge">
                                            <i class="fa-solid fa-circle-check" style="font-size:10px"></i> Verified
                                        </span>
                                    @else
                                        <span style="color:var(--text-hint);font-size:12px">Unverified</span>
                                    @endif
                                </td>

                                {{-- Status --}}
                                <td>
                                    <span class="pill {{ $review->pill_class }} js-status-pill">
                                        {{ $review->status_label }}
                                    </span>
                                </td>

                                {{-- Date --}}
                                <td style="color:var(--text-secondary);font-size:12.5px;white-space:nowrap">
                                    {{ $review->created_at->format('d M Y') }}
                                </td>

                                {{-- Actions --}}
                                <td>
                                    <div style="display:flex;gap:5px;flex-wrap:wrap">
                                        {{-- View modal --}}
                                        <button class="action-btn view"
                                                title="View"
                                                data-view-url="{{ route('admin.reviews.show', $review) }}"
                                                onclick="openModal(this)">
                                            <i class="fa fa-eye"></i>
                                        </button>

                                        {{-- Approve (hide if already approved) --}}
                                        @if($review->status !== 'approved')
                                            <button class="action-btn approve js-approve"
                                                    title="Approve"
                                                    data-url="{{ route('admin.reviews.approve', $review) }}">
                                                <i class="fa fa-check"></i>
                                            </button>
                                        @endif

                                        {{-- Reject (hide if already rejected) --}}
                                        @if($review->status !== 'rejected')
                                            <button class="action-btn reject js-reject"
                                                    title="Reject"
                                                    data-url="{{ route('admin.reviews.reject', $review) }}">
                                                <i class="fa fa-ban"></i>
                                            </button>
                                        @endif

                                        {{-- Delete --}}
                                        <button class="action-btn danger js-delete"
                                                title="Delete"
                                                data-url="{{ route('admin.reviews.destroy', $review) }}"
                                                data-id="{{ $review->id }}">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="9">
                                    <div class="empty-state">
                                        <div class="empty-icon-wrap"><i class="fa-solid fa-star"></i></div>
                                        <h6>No reviews found</h6>
                                        <p>Try adjusting your filters or search term.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="pagination-bar">
                    <div class="pagination-info">
                        Showing {{ $reviews->firstItem() ?? 0 }}–{{ $reviews->lastItem() ?? 0 }}
                        of {{ number_format($reviews->total()) }} reviews
                    </div>
                    {{ $reviews->withQueryString()->links() }}
                </div>

            </div>{{-- /list-card --}}

        </div>
    </div>
</div>

{{-- Review Detail Modal --}}
<div class="modal-overlay" id="reviewModal">
    <div class="modal-box">
        <div class="modal-header">
            <h4><i class="fa-solid fa-star" style="color:var(--star);margin-right:6px"></i> Review Detail</h4>
            <div class="modal-close" onclick="closeModal()"><i class="fa fa-times"></i></div>
        </div>
        <div class="modal-body" id="modalBody">
            <div style="text-align:center;padding:30px;color:var(--text-hint)">
                <i class="fa fa-spinner fa-spin" style="font-size:24px"></i>
            </div>
        </div>
        <div class="modal-actions" id="modalActions" style="display:none">
            <button class="btn-approve" id="modalApproveBtn"><i class="fa fa-check"></i> Approve</button>
            <button class="btn-reject"  id="modalRejectBtn"><i class="fa fa-ban"></i> Reject</button>
            <button class="btn-delete"  id="modalDeleteBtn"><i class="fa fa-trash"></i> Delete</button>
        </div>
    </div>
</div>

@include('admin.footer')

<script>
const CSRF = '{{ csrf_token() }}';
let currentReviewId = null;

/* ── Helpers ───────────────────────────────────────────── */
function starsHTML(n) {
    let h = '<div class="stars">';
    for (let i = 1; i <= 5; i++) h += `<i class="fa-solid fa-star ${i <= n ? 'filled' : ''}"></i>`;
    return h + `</div><span class="star-num">${n}.0</span>`;
}

function pillHTML(cls, label) {
    return `<span class="pill ${cls}">${label}</span>`;
}

function esc(s) {
    return String(s ?? '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
}

/* ── Open modal ────────────────────────────────────────── */
async function openModal(btn) {
    const url = btn.dataset.viewUrl;
    document.getElementById('reviewModal').classList.add('open');
    document.getElementById('modalActions').style.display = 'none';
    document.getElementById('modalBody').innerHTML =
        '<div style="text-align:center;padding:30px;color:var(--text-hint)"><i class="fa fa-spinner fa-spin" style="font-size:24px"></i></div>';

    try {
        const res  = await fetch(url, { headers: { Accept: 'application/json' } });
        const r    = await res.json();
        currentReviewId = r.id;

        const imagesHTML = r.images.length
            ? `<div class="review-imgs">${r.images.map(i => `<img src="${esc(i.url)}" class="review-img-thumb" alt="">`).join('')}</div>`
            : '';

        document.getElementById('modalBody').innerHTML = `
            <div class="modal-section">
                <div class="modal-label">Product</div>
                <div class="modal-product-row">
                    ${r.product_image
                        ? `<img src="${esc(r.product_image)}" style="width:48px;height:48px;border-radius:8px;object-fit:cover;border:1px solid var(--border);flex-shrink:0" alt="">`
                        : `<div style="width:48px;height:48px;border-radius:8px;background:var(--bg);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;color:var(--text-hint);flex-shrink:0"><i class="fa fa-image"></i></div>`}
                    <div>
                        <div style="font-size:13.5px;font-weight:600;color:var(--text-primary)">${esc(r.product_name)}</div>
                        <div style="font-size:12px;color:var(--text-hint)">SKU: ${esc(r.product_sku)}</div>
                    </div>
                </div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px" class="modal-section">
                <div>
                    <div class="modal-label">Customer</div>
                    <div class="modal-value">${esc(r.customer_name)}</div>
                    <div style="font-size:12px;color:var(--text-hint)">${esc(r.customer_email)}</div>
                </div>
                <div>
                    <div class="modal-label">Rating</div>
                    <div class="star-row" style="margin-top:4px">${starsHTML(r.rating)}</div>
                </div>
            </div>
            ${r.title ? `<div class="modal-section"><div class="modal-label">Review Title</div><div class="modal-value" style="font-weight:600">${esc(r.title)}</div></div>` : ''}
            ${r.review ? `<div class="modal-section"><div class="modal-label">Review</div><div class="modal-value">${esc(r.review)}</div></div>` : ''}
            ${imagesHTML ? `<div class="modal-section"><div class="modal-label">Photos</div>${imagesHTML}</div>` : ''}
            <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px" class="modal-section">
                <div><div class="modal-label">Status</div><div id="modal-status-pill">${pillHTML(r.pill_class, r.status_label)}</div></div>
                <div><div class="modal-label">Verified</div><div>${r.verified_purchase
                    ? '<span class="verified-badge"><i class="fa-solid fa-circle-check" style="font-size:10px"></i> Verified</span>'
                    : '<span style="color:var(--text-hint);font-size:12.5px">Unverified</span>'}</div></div>
                <div><div class="modal-label">Date</div><div class="modal-value">${esc(r.created_at)}</div></div>
            </div>`;

        // Wire modal action buttons
        const approveBtnEl = document.getElementById('modalApproveBtn');
        const rejectBtnEl  = document.getElementById('modalRejectBtn');
        const deleteBtnEl  = document.getElementById('modalDeleteBtn');

        approveBtnEl.style.display = r.status !== 'approved' ? '' : 'none';
        rejectBtnEl.style.display  = r.status !== 'rejected' ? '' : 'none';

        approveBtnEl.onclick = () => doStatusChange('{{ url("admin/reviews") }}/' + r.id + '/approve', 'PATCH');
        rejectBtnEl.onclick  = () => doStatusChange('{{ url("admin/reviews") }}/' + r.id + '/reject',  'PATCH');
        deleteBtnEl.onclick  = () => doDelete('{{ url("admin/reviews") }}/' + r.id, r.id);

        document.getElementById('modalActions').style.display = 'flex';

    } catch(e) {
        document.getElementById('modalBody').innerHTML =
            '<div style="color:var(--red);padding:20px">Failed to load review.</div>';
    }
}

function closeModal() {
    document.getElementById('reviewModal').classList.remove('open');
    currentReviewId = null;
}
document.getElementById('reviewModal').addEventListener('click', e => { if (e.target.id === 'reviewModal') closeModal(); });

/* ── Approve / Reject (table row buttons) ──────────────── */
document.querySelectorAll('.js-approve, .js-reject').forEach(btn => {
    btn.addEventListener('click', function() {
        doStatusChange(this.dataset.url, 'PATCH', this.closest('tr'));
    });
});

async function doStatusChange(url, method, row) {
    try {
        const res  = await fetch(url, {
            method,
            headers: { 'X-CSRF-TOKEN': CSRF, Accept: 'application/json' },
        });
        const data = await res.json();

        if (!data.success) return;

        // Update pill in table row
        if (row) {
            const pill = row.querySelector('.js-status-pill');
            if (pill) { pill.className = `pill ${data.pill_class} js-status-pill`; pill.textContent = data.status_label; }

            // Swap action buttons
            const actions = row.querySelector('div[style]');
            if (data.status === 'approved') {
                row.querySelectorAll('.js-approve').forEach(b => b.remove());
            } else if (data.status === 'rejected') {
                row.querySelectorAll('.js-reject').forEach(b => b.remove());
            }
        }

        // Update modal pill if open
        const modalPill = document.getElementById('modal-status-pill');
        if (modalPill) modalPill.innerHTML = pillHTML(data.pill_class, data.status_label);

        // Update modal buttons
        const appBtnEl = document.getElementById('modalApproveBtn');
        const rejBtnEl = document.getElementById('modalRejectBtn');
        if (appBtnEl) appBtnEl.style.display = data.status !== 'approved' ? '' : 'none';
        if (rejBtnEl) rejBtnEl.style.display  = data.status !== 'rejected' ? '' : 'none';

    } catch(e) { console.error(e); }
}

/* ── Delete ────────────────────────────────────────────── */
document.querySelectorAll('.js-delete').forEach(btn => {
    btn.addEventListener('click', function() {
        doDelete(this.dataset.url, this.dataset.id);
    });
});

function doDelete(url, id) {
    const confirmed = typeof Swal !== 'undefined'
        ? Swal.fire({ title:'Delete Review?', text:'This cannot be undone.', icon:'warning', showCancelButton:true, confirmButtonColor:'#b22222', confirmButtonText:'Yes, Delete' })
        : Promise.resolve({ isConfirmed: confirm('Delete this review permanently?') });

    confirmed.then(result => {
        if (!result.isConfirmed) return;

        fetch(url, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': CSRF, Accept: 'application/json' },
        })
        .then(r => r.json())
        .then(data => {
            if (!data.success) return;
            const row = document.getElementById('review_row_' + id);
            if (row) { row.style.transition = 'opacity .3s'; row.style.opacity = 0; setTimeout(() => row.remove(), 300); }
            closeModal();
            if (typeof Swal !== 'undefined') Swal.fire('Deleted!', 'The review has been removed.', 'success');
        });
    });
}

/* ── Rating tabs (client-side highlight, server-side filter) ─ */
document.querySelectorAll('.rating-tab').forEach(tab => {
    tab.addEventListener('click', function() {
        document.querySelectorAll('.rating-tab').forEach(t => t.classList.remove('active'));
        this.classList.add('active');
    });
});
</script>