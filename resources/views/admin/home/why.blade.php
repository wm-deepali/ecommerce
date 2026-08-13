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

    .detail-page { background: var(--bg); padding: 24px 28px; min-height: 100vh; font-family: var(--font); color: var(--text-primary); }
    .detail-page * { box-sizing: border-box; }

    /* ── Page header ── */
    .detail-page-header { display: flex; align-items: flex-start; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 20px; }
    .detail-page-header h1 { font-size: 20px; font-weight: 650; color: var(--text-primary); margin: 0; }
    .crumb { font-size: 12.5px; color: var(--text-hint); margin-top: 3px; }
    .crumb a { color: var(--accent); text-decoration: none; }
    .crumb a:hover { text-decoration: underline; }
    .crumb span { margin: 0 5px; }

    /* ── Buttons ── */
    .btn-primary-dash {
        display: inline-flex; align-items: center; gap: 6px;
        background: var(--accent); color: #fff !important; border: none;
        border-radius: var(--radius-sm); padding: 9px 18px;
        font-size: 13px; font-weight: 600; cursor: pointer;
        text-decoration: none !important; font-family: var(--font);
        transition: background .15s; box-shadow: 0 1px 3px rgba(48,61,137,.25);
    }
    .btn-primary-dash:hover { background: #252f70; }

    .btn-secondary-dash {
        display: inline-flex; align-items: center; gap: 6px;
        background: var(--surface); color: var(--text-primary) !important;
        border: 1px solid var(--border); border-radius: var(--radius-sm);
        padding: 9px 18px; font-size: 13px; font-weight: 500; cursor: pointer;
        text-decoration: none !important; font-family: var(--font);
        transition: background .15s;
    }
    .btn-secondary-dash:hover { background: var(--bg); }

    /* ── Section card ── */
    .section-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-md); box-shadow: var(--shadow-card); overflow: hidden; margin-bottom: 20px; }
    .section-card:last-child { margin-bottom: 0; }
    .section-card-header { padding: 14px 20px; border-bottom: 1px solid var(--border); background: #fafafa; display: flex; align-items: center; justify-content: space-between; }
    .section-card-header h5 { font-size: 13px; font-weight: 650; color: var(--text-primary); margin: 0; letter-spacing: .01em; }
    .section-card-body { padding: 20px; }

    /* ── Form fields ── */
    .field-group { margin-bottom: 16px; }
    .field-group:last-child { margin-bottom: 0; }
    .field-label { display: block; font-size: 12px; font-weight: 600; color: var(--text-secondary); letter-spacing: .03em; text-transform: uppercase; margin-bottom: 6px; }

    .field-input, .field-textarea {
        width: 100%; border: 1px solid var(--border);
        border-radius: var(--radius-sm); padding: 0 12px;
        font-size: 13.5px; color: var(--text-primary);
        background: var(--surface); outline: none;
        transition: border-color .15s, box-shadow .15s;
        font-family: var(--font);
    }
    .field-input { height: 38px; }
    .field-textarea { padding: 10px 12px; resize: vertical; min-height: 80px; }
    .field-input:focus, .field-textarea:focus {
        border-color: var(--accent); box-shadow: 0 0 0 3px rgba(48,61,137,.12);
    }

    /* ── Add card grid ── */
    .add-card-grid { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; margin-bottom: 16px; }
    @media(max-width:700px) { .add-card-grid { grid-template-columns: 1fr; } }

    /* ── Icon preview inline ── */
    .icon-preview-row { display: flex; align-items: center; gap: 10px; margin-top: 8px; }
    .icon-preview-box {
        width: 36px; height: 36px; border-radius: var(--radius-sm);
        background: var(--accent-light); border: 1px solid var(--border);
        display: flex; align-items: center; justify-content: center;
        color: var(--accent); font-size: 16px; flex-shrink: 0;
    }

    /* ── ID chip ── */
    .id-chip { display: inline-block; background: var(--bg); border: 1px solid var(--border); border-radius: 6px; padding: 2px 8px; font-size: 11.5px; font-family: 'SF Mono','Fira Mono',monospace; color: var(--text-secondary); }

    /* ── Data table ── */
    .data-table { width: 100%; border-collapse: collapse; font-size: 13px; }
    .data-table thead th { font-size: 11px; font-weight: 650; letter-spacing: .06em; text-transform: uppercase; color: var(--text-hint); padding: 10px 16px; border-bottom: 1px solid var(--border); background: #fafafa; text-align: left; white-space: nowrap; }
    .data-table tbody tr { border-bottom: 1px solid var(--border); transition: background .1s; }
    .data-table tbody tr:last-child { border-bottom: none; }
    .data-table tbody tr:hover { background: #fafbfc; }
    .data-table td { padding: 13px 16px; vertical-align: middle; }

    /* ── Icon cell ── */
    .icon-cell { display: flex; align-items: center; gap: 10px; }
    .icon-cell-box { width: 36px; height: 36px; border-radius: var(--radius-sm); background: var(--accent-light); border: 1px solid var(--border); display: flex; align-items: center; justify-content: center; color: var(--accent); font-size: 15px; flex-shrink: 0; }
    .icon-cell-name { font-size: 11.5px; color: var(--text-hint); font-family: monospace; }

    /* ── Card title/content in table ── */
    .card-title   { font-size: 13.5px; font-weight: 600; color: var(--text-primary); }
    .card-content { font-size: 12.5px; color: var(--text-secondary); margin-top: 2px; }

    /* ── Action buttons ── */
    .action-btn {
        display: inline-flex; align-items: center; justify-content: center;
        width: 30px; height: 30px; border-radius: var(--radius-sm);
        border: 1px solid var(--border); background: var(--surface);
        color: var(--text-secondary); cursor: pointer; text-decoration: none;
        transition: all .15s; font-size: 12px;
    }
    .action-btn:hover        { background: var(--bg); color: var(--text-primary); }
    .action-btn.edit:hover   { background: var(--accent-light); color: var(--accent); border-color: rgba(48,61,137,.25); }
    .action-btn.danger:hover { background: var(--red-bg); color: var(--red); border-color: #f5c0c0; }

    /* ── Empty state ── */
    .empty-mini { text-align: center; padding: 40px 20px; color: var(--text-hint); font-size: 13px; }
    .empty-mini i { font-size: 28px; display: block; margin-bottom: 10px; color: var(--text-hint); }

    /* ── Modal overrides ── */
    .modal-content { border: 1px solid var(--border); border-radius: var(--radius-md); box-shadow: 0 12px 40px rgba(0,0,0,.15); font-family: var(--font); }
    .modal-header { background: #fafafa; border-bottom: 1px solid var(--border); border-radius: var(--radius-md) var(--radius-md) 0 0; padding: 16px 20px; }
    .modal-header h5 { font-size: 14px; font-weight: 650; color: var(--text-primary); margin: 0; }
    .modal-header .close { color: var(--text-hint); font-size: 20px; opacity: 1; }
    .modal-header .close:hover { color: var(--red); }
    .modal-body   { padding: 20px; }
    .modal-footer { padding: 14px 20px; border-top: 1px solid var(--border); background: #fafafa; border-radius: 0 0 var(--radius-md) var(--radius-md); gap: 10px; }

    /* ── Modal icon preview ── */
    .modal-icon-preview {
        display: flex; align-items: center; gap: 12px;
        padding: 12px 14px; background: var(--accent-light);
        border: 1px solid rgba(48,61,137,.15); border-radius: var(--radius-sm);
        margin-top: 10px;
    }
    .modal-icon-preview i { font-size: 28px; color: var(--accent); }
    .modal-icon-preview span { font-size: 12.5px; color: var(--accent); font-family: monospace; font-weight: 600; }

    /* ── Alert ── */
    .alert { border-radius: var(--radius-sm); font-size: 13.5px; padding: 12px 16px; margin-bottom: 16px; border: none; }
    .alert-success { background: var(--green-bg); color: var(--green); border-left: 3px solid var(--green); }
    .alert-danger  { background: var(--red-bg);   color: var(--red);   border-left: 3px solid var(--red); }

    @media(max-width:768px) { .detail-page { padding: 16px; } }
    </style>

    <div class="app-content content container-fluid">
        <div class="detail-page">

            <!-- Page header -->
            <div class="detail-page-header">
                <div>
                    <h1>Why Choose Us</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        <a href="{{ route('admin.home-page.index') }}">Manage Home Page</a>
                        <span>›</span>
                        Why Choose Us
                    </div>
                </div>
            </div>

            {{-- Flash messages --}}
            @if(session('success'))
                <div class="alert alert-success"><i class="fa fa-check-circle"></i> {{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0" style="padding-left:16px">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- ── Section Heading ── -->
            <div class="section-card">
                <div class="section-card-header">
                    <h5><i class="fa-solid fa-heading" style="color:var(--accent);margin-right:6px"></i> Section Content</h5>
                </div>
                <div class="section-card-body">
                    <form method="POST" action="{{ route('admin.home.why.update') }}">
                        @csrf
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px">
                            <div class="field-group" style="margin:0">
                                <label class="field-label">Heading <span style="color:var(--red)">*</span></label>
                                <input type="text" name="heading"
                                       value="{{ old('heading', $why->heading ?? '') }}"
                                       class="field-input" required>
                            </div>
                            <div class="field-group" style="margin:0">
                                <label class="field-label">Sub Heading <span style="color:var(--red)">*</span></label>
                                <input type="text" name="sub_heading"
                                       value="{{ old('sub_heading', $why->sub_heading ?? '') }}"
                                       class="field-input" required>
                            </div>
                        </div>
                        <button type="submit" class="btn-primary-dash">
                            <i class="fa fa-save"></i> Update Section
                        </button>
                    </form>
                </div>
            </div>

            <!-- ── Add New Card ── -->
            <div class="section-card">
                <div class="section-card-header">
                    <h5><i class="fa-solid fa-plus-circle" style="color:var(--accent);margin-right:6px"></i> Add New Card</h5>
                </div>
                <div class="section-card-body">
                    <form method="POST" action="{{ route('admin.home.why.card.store') }}">
                        @csrf
                        <div class="add-card-grid">
                            <div class="field-group" style="margin:0">
                                <label class="field-label">Title <span style="color:var(--red)">*</span></label>
                                <input type="text" name="title" value="{{ old('title') }}"
                                       class="field-input" required placeholder="e.g. Quality Assured">
                            </div>
                            <div class="field-group" style="margin:0">
                                <label class="field-label">Icon Class <span style="color:var(--red)">*</span></label>
                                <input type="text" name="icon" id="addIconInput" value="{{ old('icon') }}"
                                       class="field-input" required placeholder="e.g. fa-solid fa-award">
                                <div class="icon-preview-row">
                                    <div class="icon-preview-box" id="addIconPreview">
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                    <span style="font-size:11.5px;color:var(--text-hint)">Live preview</span>
                                </div>
                            </div>
                            <div class="field-group" style="margin:0">
                                <label class="field-label">Content</label>
                                <input type="text" name="content" value="{{ old('content') }}"
                                       class="field-input" placeholder="Short description…">
                            </div>
                        </div>
                        <button type="submit" class="btn-primary-dash">
                            <i class="fa fa-plus"></i> Add Card
                        </button>
                    </form>
                </div>
            </div>

            <!-- ── Cards List ── -->
            <div class="section-card">
                <div class="section-card-header">
                    <h5><i class="fa-solid fa-table-cells" style="color:var(--accent);margin-right:6px"></i> Cards List</h5>
                    <span style="font-size:12px;color:var(--text-hint)">{{ $cards->count() }} card(s)</span>
                </div>
                <div style="overflow-x:auto">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th style="width:70px">ID</th>
                                <th style="width:160px">Icon</th>
                                <th>Title</th>
                                <th>Content</th>
                                <th style="width:90px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cards as $card)
                                <tr id="row{{ $card->id }}">

                                    <td><span class="id-chip">{{ $card->id }}</span></td>

                                    <td>
                                        <div class="icon-cell">
                                            <div class="icon-cell-box">
                                                <i class="{{ $card->icon }}"></i>
                                            </div>
                                            <span class="icon-cell-name">{{ $card->icon }}</span>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="card-title">{{ $card->title }}</div>
                                    </td>

                                    <td>
                                        <div class="card-content">{{ $card->content ?? '—' }}</div>
                                    </td>

                                    <td>
                                        <div style="display:flex;gap:6px">
                                            <button class="action-btn edit" title="Edit"
                                                    onclick="editCard({{ $card->id }})">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                            <button class="action-btn danger" title="Delete"
                                                    onclick="deleteCard({{ $card->id }})">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">
                                        <div class="empty-mini">
                                            <i class="fa-solid fa-table-cells"></i>
                                            No cards yet. Add your first card above.
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

<!-- ── Edit Card Modal ── -->
<div class="modal fade" id="editCardModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="editCardForm" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5><i class="fa fa-pencil" style="color:var(--accent);margin-right:6px"></i> Edit Card</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">

                    <div class="field-group">
                        <label class="field-label">Title</label>
                        <input type="text" name="title" id="editTitle" class="field-input">
                    </div>

                    <div class="field-group">
                        <label class="field-label">Icon Class</label>
                        <input type="text" name="icon" id="editIcon" class="field-input"
                               placeholder="e.g. fa-solid fa-award"
                               oninput="updateModalPreview(this.value)">
                        <div id="currentIconPreview"></div>
                    </div>

                    <div class="field-group">
                        <label class="field-label">Content</label>
                        <input type="text" name="content" id="editContent" class="field-input">
                    </div>

                </div>
                <div class="modal-footer" style="display:flex;justify-content:flex-end">
                    <button type="button" class="btn-secondary-dash" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-primary-dash">
                        <i class="fa fa-save"></i> Update Card
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@include('admin.footer')

<script>
// ── Add card icon live preview ──
document.getElementById('addIconInput').addEventListener('input', function () {
    const box = document.getElementById('addIconPreview');
    box.innerHTML = this.value.trim()
        ? `<i class="${this.value.trim()}"></i>`
        : `<i class="fa-solid fa-star"></i>`;
});

// ── Modal icon preview ──
function updateModalPreview(val) {
    const wrap = document.getElementById('currentIconPreview');
    if (val.trim()) {
        wrap.innerHTML = `
            <div class="modal-icon-preview">
                <i class="${val.trim()}"></i>
                <span>${val.trim()}</span>
            </div>`;
    } else {
        wrap.innerHTML = '';
    }
}

// ── Edit card ──
function editCard(id) {
    $.get("{{ url('admin/home-why/card') }}/" + id, function (data) {
        $('#editTitle').val(data.title);
        $('#editContent').val(data.content);
        $('#editIcon').val(data.icon);
        $('#editCardForm').attr('action', "{{ url('admin/home-why/card') }}/" + id);
        updateModalPreview(data.icon || '');
        $('#editCardModal').modal('show');
    });
}

// ── Delete card ──
function deleteCard(id) {
    Swal.fire({
        title: 'Delete Card?',
        text: "This action cannot be undone.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#b22222',
        cancelButtonColor: '#6d7175',
        confirmButtonText: 'Yes, Delete'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ url('admin/home-why/card') }}/" + id,
                type: "DELETE",
                data: { _token: "{{ csrf_token() }}" },
                success: function (res) {
                    Swal.fire('Deleted!', res.message || 'Card removed successfully', 'success');
                    $("#row" + id).fadeOut(300, function () { $(this).remove(); });
                }
            });
        }
    });
}
</script>