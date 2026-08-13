@include('admin.top-header')

<div class="main-section">

    @include('admin.header')

    <div class="app-content content container-fluid">

        <div class="breadcrumbs-top bg-light mb-3">
            <ol class="breadcrumb bg-transparent mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.awards.index') }}">Manage Awards</a>
                </li>
                <li class="breadcrumb-item active">Edit Award</li>
            </ol>
        </div>

        <div class="content-wrapper pb-4">

            <div class="card shadow-sm">

                <div class="card-header">
                    <strong>Edit Award</strong>
                </div>

                <div class="card-body">

                    {{-- ✅ GLOBAL ERRORS --}}
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" enctype="multipart/form-data"
                        action="{{ route('admin.awards.update', $award->id) }}">

                        @csrf
                        @method('PUT')

                        {{-- TITLE --}}
                        <div class="form-group">
                            <label>Title *</label>
                            <input type="text" name="title"
                                class="form-control @error('title') is-invalid @enderror"
                                value="{{ old('title', $award->title) }}" required>

                            @error('title')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- YEAR --}}
                        <div class="form-group mt-3">
                            <label>Year *</label>
                            <input type="number" name="year"
                                class="form-control @error('year') is-invalid @enderror"
                                value="{{ old('year', $award->year) }}" required>

                            @error('year')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- IMAGE --}}
                        <div class="form-group mt-3">
                            <label>Image</label>
                            <input type="file" name="image"
                                class="form-control @error('image') is-invalid @enderror">

                            @error('image')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

                            {{-- EXISTING IMAGE --}}
                            @if($award->image)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $award->image) }}"
                                        width="120" class="border rounded">
                                </div>
                            @endif
                        </div>

                        {{-- DESCRIPTION --}}
                        <div class="form-group mt-3">
                            <label>Description</label>
                            <textarea name="description"
                                class="form-control @error('description') is-invalid @enderror"
                                rows="4">{{ old('description', $award->description) }}</textarea>

                            @error('description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- STATUS --}}
                        <div class="form-group mt-3">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="status" id="status"
                                    class="custom-control-input"
                                    {{ old('status', $award->status) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="status">
                                    Active
                                </label>
                            </div>
                        </div>

                        {{-- BUTTONS --}}
                        <div class="mt-4">
                            <button type="submit" class="btn btn-success">
                                <i class="fa-solid fa-save"></i> Update Award
                            </button>

                            <a href="{{ route('admin.awards.index') }}" class="btn btn-secondary">
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