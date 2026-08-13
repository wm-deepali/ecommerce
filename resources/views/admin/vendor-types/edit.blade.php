@include('admin.top-header')

<div class="main-section">

    @include('admin.header')

    <div class="app-content content container-fluid">

        <div class="breadcrumbs-top d-flex align-items-center bg-light mb-3">

            <div class="breadcrumb-wrapper">
                <ol class="breadcrumb bg-transparent mb-0">

                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                    </li>

                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.vendor-types.index') }}">Vendor Types</a>
                    </li>

                    <li class="breadcrumb-item active">
                        Edit Vendor Type
                    </li>

                </ol>
            </div>

        </div>

        <div class="content-wrapper pb-4">

            <div class="card shadow-sm">

                <div class="card-header">
                    <strong>Edit Vendor Type</strong>
                </div>

                <div class="card-body">

                    <form id="typeForm" method="POST"
                        action="{{ route('admin.vendor-types.update', $type->id) }}">

                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>Name *</label>
                            <input type="text" name="name" value="{{ $type->name }}" class="form-control" required>
                        </div>

                        <div class="form-group mt-3">
                            <label>Type *</label>
                            <input type="text" name="type" value="{{ $type->type }}" class="form-control" required>
                        </div>

                        <div class="form-group mt-3">

                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="status" id="status"
                                    class="custom-control-input"
                                    {{ $type->status ? 'checked' : '' }}>
                                <label class="custom-control-label" for="status">
                                    Active
                                </label>
                            </div>

                        </div>

                        <div class="mt-4">

                            <button type="submit" id="saveBtn" class="btn btn-success">
                                <i class="fa-solid fa-save"></i> Update Vendor Type
                            </button>

                            <a href="{{ route('admin.vendor-types.index') }}" class="btn btn-secondary">
                                Cancel
                            </a>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@include('admin.footer')

<script>
document.getElementById('typeForm').addEventListener('submit', function () {
    let btn = document.getElementById('saveBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Updating...';
});
</script>