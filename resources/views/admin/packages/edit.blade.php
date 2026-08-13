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
                        Edit Package
                    </li>

                </ol>
            </div>

        </div>

        <div class="content-wrapper pb-4">

            <div class="card shadow-sm">

                <div class="card-header">
                    <strong>Edit Package</strong>
                </div>

                <div class="card-body">

                    <form method="POST" action="{{ route('admin.packages.update', $package->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>Package Name *</label>
                            <input type="text" name="name" class="form-control"
                                value="{{ $package->name }}" required>
                        </div>

                        <div class="form-group mt-3">
                            <label>Sub Title</label>
                            <input type="text" name="sub_title" class="form-control"
                                value="{{ $package->sub_title }}">
                        </div>

                        <div class="form-group mt-3">
                            <label>Package Cost *</label>
                            <input type="number" name="cost" class="form-control"
                                value="{{ $package->cost }}" required>
                        </div>

                        <div class="form-group mt-3">
                            <label>Duration *</label>
                            <input type="text" name="duration" class="form-control"
                                value="{{ $package->duration }}" required>
                        </div>

                        <div class="form-group mt-3">
                            <label>Button Text</label>
                            <input type="text" name="button_text" class="form-control"
                                value="{{ $package->button_text }}">
                        </div>

                        <div class="form-group mt-3">
                            <label>Features</label>

                            <div id="features-wrapper">
                                @foreach($package->features as $feature)
                                    <input type="text" name="features[]"
                                        class="form-control mb-2"
                                        value="{{ $feature->feature_name }}">
                                @endforeach
                            </div>

                            <button type="button" class="btn btn-sm btn-primary mt-2" onclick="addFeature()">
                                + Add More
                            </button>
                        </div>

                        <div class="form-group mt-3">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="is_popular" id="is_popular"
                                    class="custom-control-input"
                                    {{ $package->is_popular ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_popular">
                                    Set as Popular
                                </label>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" id="saveBtn" class="btn btn-success">
                                <i class="fa-solid fa-save"></i> Update Package
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
    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Updating...';
});
</script>