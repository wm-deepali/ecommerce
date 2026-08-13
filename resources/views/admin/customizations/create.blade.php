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
                        <a href="{{ route('admin.customizations.index') }}">Customizations</a>
                    </li>

                    <li class="breadcrumb-item active">
                        Add Customization
                    </li>

                </ol>
            </div>

        </div>

        <div class="content-wrapper pb-4">

            <div class="card shadow-sm">

                <div class="card-header">
                    <strong>Add Customization</strong>
                </div>

                <div class="card-body">

                    <form id="form" method="POST" action="{{ route('admin.customizations.store') }}">

                        @csrf

                        <!-- Name -->
                        <div class="form-group">
                            <label>Customization Name *</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <!-- Short Description -->
                        <div class="form-group mt-3">
                            <label>Short Description</label>
                            <textarea name="short_description" class="form-control"></textarea>
                        </div>

                        <!-- Font Awesome Icon -->
                        <div class="form-group mt-3">
                            <label>Font Awesome Icon</label>

                            <input type="text" name="icon" id="iconInput" class="form-control"
                                placeholder="fa-solid fa-palette">

                            <small class="text-muted d-block mt-1">
                                Example: fa-solid fa-palette, fa-solid fa-image, fa-solid fa-pen, fa-solid fa-brush
                            </small>

                            <div class="mt-2">
                                Preview:
                                <i id="iconPreview" class="fa-solid fa-palette" style="font-size:30px;"></i>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="form-group mt-3">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                        <!-- Buttons -->
                        <div class="mt-4">

                            <button type="submit" id="saveBtn" class="btn btn-success">
                                <i class="fa-solid fa-save"></i> Save Customization
                            </button>

                            <a href="{{ route('admin.customizations.index') }}" class="btn btn-secondary">
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
    document.getElementById('form').addEventListener('submit', function () {

        let btn = document.getElementById('saveBtn');

        btn.disabled = true;
        btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Saving...';

    });
</script>