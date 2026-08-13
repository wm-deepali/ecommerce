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

                    <li class="breadcrumb-item active">
                        Manage Packages
                    </li>

                </ol>
            </div>

            {{-- ✅ Hide button if 3 packages exist --}}
            <div class="ml-auto mr-2">
                @if($packages->count() < 3)
                    <a href="{{ route('admin.packages.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Add Package
                    </a>
                @endif
            </div>

        </div>

        <div class="content-wrapper pb-4">

            <div class="card">
                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-striped table-hover">

                            <thead class="thead-light">

                                <tr>
                                    <th width="60">ID</th>
                                    <th>Name</th>
                                    <th width="120">Cost</th>
                                    <th width="150">Duration</th>
                                    <th width="120">Popular</th>
                                    <th width="150">Features</th>
                                    <th width="120">Action</th>
                                </tr>

                            </thead>

                            <tbody>

                                @forelse($packages as $pkg)

                                    <tr id="row{{ $pkg->id }}">

                                        <td>{{ $pkg->id }}</td>

                                        <td>
                                            <strong>{{ $pkg->name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $pkg->sub_title }}</small>
                                        </td>

                                        <td>₹{{ $pkg->cost }}</td>

                                        <td>{{ $pkg->duration }}</td>

                                        <td>
                                            @if($pkg->is_popular)
                                                <span class="badge badge-success">Popular</span>
                                            @else
                                                <span class="badge badge-secondary">No</span>
                                            @endif
                                        </td>

                                        <td>
                                            <ul class="mb-0 pl-3">
                                                @foreach($pkg->features as $f)
                                                    <li>{{ $f->feature_name }}</li>
                                                @endforeach
                                            </ul>
                                        </td>

                                        <td>

                                            <a href="{{ route('admin.packages.edit', $pkg->id) }}"
                                                class="btn btn-sm btn-outline-dark">

                                                <i class="fa fa-pencil"></i>

                                            </a>

                                            <button class="btn btn-sm btn-outline-danger"
                                                onclick="deletePackage({{ $pkg->id }})">

                                                <i class="fa fa-trash"></i>

                                            </button>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">
                                            No Packages Found
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

</div>

@include('admin.footer')


<script>

function deletePackage(id) {
    Swal.fire({
        title: 'Delete Package?',
        text: "This action cannot be undone.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Yes, Delete'
    })
    .then((result) => {

        if (result.isConfirmed) {

            $.ajax({

                url: "{{ url('admin/packages') }}/" + id,

                type: "DELETE",

                data: {
                    _token: "{{ csrf_token() }}"
                },

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