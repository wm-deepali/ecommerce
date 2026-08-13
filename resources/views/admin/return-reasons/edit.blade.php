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

    .edit-page { background: var(--bg); padding: 24px 28px; min-height: 100vh; font-family: var(--font); color: var(--text-primary); }
    .edit-page * { box-sizing: border-box; }

    .edit-page-header { display: flex; align-items: flex-start; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 20px; }
    .edit-page-header h1 { font-size: 20px; font-weight: 650; margin: 0; }
    .crumb { font-size: 12.5px; color: var(--text-hint); margin-top: 3px; }
    .crumb a { color: var(--accent); text-decoration: none; }
    .crumb a:hover { text-decoration: underline; }
    .crumb span { margin: 0 5px; }

    /* Identity chip */
    .cat-identity { display: flex; align-items: center; gap: 12px; background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 12px 16px; box-shadow: var(--shadow-card); }
    .cat-identity-placeholder { width: 40px; height: 40px; border-radius: var(--radius-sm); background: var(--accent-light); display: flex; align-items: center; justify-content: center; color: var(--accent); font-size: 16px; flex-shrink: 0; }
    .cat-identity-name { font-size: 14px; font-weight: 650; color: var(--text-primary); }
    .cat-identity-id   { font-size: 12px; color: var(--text-hint); margin-top: 2px; }

    .btn-primary-dash {
        display: inline-flex; align-items: center; gap: 6px;
        background: var(--accent); color: #fff !important; border: none;
        border-radius: var(--radius-sm); padding: 8px 18px;
        font-size: 13px; font-weight: 600; cursor: pointer;
        text-decoration: none !important; font-family: var(--font);
        transition: background .15s; box-shadow: 0 1px 3px rgba(48,61,137,.25);
    }
    .btn-primary-dash:hover:not(:disabled) { background: #252f70; }
    .btn-primary-dash:disabled { opacity: .65; cursor: not-allowed; }

    .btn-secondary-dash {
        display: inline-flex; align-items: center; gap: 6px;
        background: var(--surface); color: var(--text-primary) !important;
        border: 1px solid var(--border); border-radius: var(--radius-sm);
        padding: 8px 18px; font-size: 13px; font-weight: 500; cursor: pointer;
        text-decoration: none !important; font-family: var(--font); transition: background .15s;
    }
    .btn-secondary-dash:hover { background: var(--bg); }

    .section-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-md); box-shadow: var(--shadow-card); overflow: hidden; max-width: 600px; }
    .section-card-header { padding: 14px 20px; border-bottom: 1px solid var(--border); background: #fafafa; }
    .section-card-header h5 { font-size: 13px; font-weight: 650; margin: 0; letter-spacing: .01em; }
    .section-card-body { padding: 20px; }

    .field-group { margin-bottom: 16px; }
    .field-group:last-child { margin-bottom: 0; }
    .field-label { display: block; font-size: 12px; font-weight: 600; color: var(--text-secondary); letter-spacing: .03em; text-transform: uppercase; margin-bottom: 6px; }
    .field-label .req { color: var(--red); margin-left: 2px; }

    .field-input, .field-select {
        width: 100%; height: 38px; border: 1px solid var(--border);
        border-radius: var(--radius-sm); padding: 0 12px;
        font-size: 13.5px; color: var(--text-primary);
        background: var(--surface); outline: none;
        transition: border-color .15s, box-shadow .15s; font-family: var(--font);
    }
    .field-input:focus, .field-select:focus {
        border-color: var(--accent); box-shadow: 0 0 0 3px rgba(48,61,137,.12);
    }
    .field-hint { font-size: 11.5px; color: var(--text-hint); margin-top: 4px; }

    .dash-alert { border-radius: var(--radius-sm); padding: 10px 16px; font-size: 13px; margin-bottom: 16px; display: flex; align-items: flex-start; gap: 8px; }
    .dash-alert-error { background: var(--red-bg); color: var(--red); border: 1px solid #f0c0c0; }
    .dash-alert-error ul { margin: 4px 0 0 16px; padding: 0; }

    .action-bar { max-width: 600px; background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-md); box-shadow: var(--shadow-card); padding: 14px 20px; display: flex; align-items: center; justify-content: flex-end; gap: 10px; margin-top: 20px; }

    @media(max-width:768px) { .edit-page { padding: 16px; } }
    </style>

    <div class="app-content content container-fluid">
        <div class="edit-page">

            <div class="edit-page-header">
                <div>
                    <h1>Edit Return Reason</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        <a href="{{ route('admin.return-reasons.index') }}">Return Reasons</a>
                        <span>›</span>
                        Edit
                    </div>
                </div>

                <!-- Identity chip -->
                <div class="cat-identity">
                    <div class="cat-identity-placeholder"><i class="fa fa-undo"></i></div>
                    <div>
                        <div class="cat-identity-name">{{ $returnReason->title }}</div>
                        <div class="cat-identity-id">ID #{{ $returnReason->id }}</div>
                    </div>
                </div>
            </div>

            @if($errors->any())
                <div class="dash-alert dash-alert-error">
                    <i class="fa fa-exclamation-circle" style="margin-top:1px"></i>
                    <div>
                        Please fix the following errors:
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.return-reasons.update', $returnReason->id) }}">
                @csrf
                @method('PUT')

                <div class="section-card">
                    <div class="section-card-header">
                        <h5>Return Reason Details</h5>
                    </div>
                    <div class="section-card-body">

                        <div class="field-group">
                            <label class="field-label">Title <span class="req">*</span></label>
                            <input type="text" name="title" id="title"
                                value="{{ old('title', $returnReason->title) }}"
                                class="field-input" required autofocus>
                        </div>

                        <div class="field-group">
                            <label class="field-label">Status <span class="req">*</span></label>
                            <select name="is_active" class="field-select" style="max-width:180px">
                                <option value="1" {{ old('is_active', $returnReason->is_active) ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ !old('is_active', $returnReason->is_active) ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <div class="field-group">
                            <label class="field-label">Sort Order</label>
                            <input type="number" name="sort_order"
                                value="{{ old('sort_order', $returnReason->sort_order) }}"
                                class="field-input" style="max-width:120px" min="0">
                            <div class="field-hint">Lower numbers appear first.</div>
                        </div>

                    </div>
                </div>

                <!-- Hidden redirect field -->
                <input type="hidden" name="redirect" value="{{ $redirect ?? url()->previous() }}">

                <div class="action-bar">
                    <a href="{{ route('admin.return-reasons.index') }}" class="btn-secondary-dash">Cancel</a>
                    <button type="submit" id="updateBtn" class="btn-primary-dash">
                        <i class="fa fa-save"></i> Update Reason
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

@include('admin.footer')

<script>
document.querySelector('form').addEventListener('submit', function () {
    const btn = document.getElementById('updateBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Updating…';
});
</script>