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
                        <a href="{{ route('admin.packages.index') }}">Manage Packages</a>
                    </li>

                    <li class="breadcrumb-item active">
                        Add Package
                    </li>

                </ol>
            </div>

        </div>

        <div class="content-wrapper pb-4">

            <div class="card shadow-sm">

                <div class="card-header">
                    <strong>Add Package</strong>
                </div>

                <div class="card-body">

                    <form method="POST" action="{{ route('admin.packages.store') }}">
                        @csrf

                        <div class="form-group">
                            <label>Package Name *</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="form-group mt-3">
                            <label>Sub Title</label>
                            <input type="text" name="sub_title" class="form-control">
                        </div>

                        <div class="form-group mt-3">
                            <label>Package Cost *</label>
                            <input type="number" name="cost" class="form-control" required>
                        </div>

                        <div class="form-group mt-3">
                            <label>Duration *</label>
                            <input type="text" name="duration" class="form-control" required>
                        </div>

                        <div class="form-group mt-3">
                            <label>Button Text</label>
                            <input type="text" name="button_text" class="form-control">
                        </div>

                        <div class="form-group mt-3">
                            <label>Features</label>

                            <div id="features-wrapper">
                                <input type="text" name="features[]" class="form-control mb-2" placeholder="Feature">
                            </div>

                            <button type="button" class="btn btn-sm btn-primary mt-2" onclick="addFeature()">
                                + Add More
                            </button>
                        </div>

                        <div class="form-group mt-3">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="is_popular" id="is_popular"
                                    class="custom-control-input">
                                <label class="custom-control-label" for="is_popular">
                                    Set as Popular
                                </label>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" id="saveBtn" class="btn btn-success">
                                <i class="fa-solid fa-save"></i> Save Package
                            </button>

                            <a href="{{ route('admin.packages.index') }}" class="btn btn-secondary">
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
function addFeature() {
    let div = document.createElement('div');
    div.innerHTML = `<input type="text" name="features[]" class="form-control mb-2" placeholder="Feature">`;
    document.getElementById('features-wrapper').appendChild(div);
}

document.querySelector('form').addEventListener('submit', function () {
    let btn = document.getElementById('saveBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Saving...';
});
</script>