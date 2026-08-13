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
                        Manage Vendor Types
                    </li>

                </ol>
            </div>

            <div class="ml-auto mr-2">
                <a href="{{ route('admin.vendor-types.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> Add Vendor Type
                </a>
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
                                    <th width="150">Type</th>
                                    <th width="120">Status</th>
                                    <th width="120">Action</th>
                                </tr>

                            </thead>

                            <tbody>

                                @forelse($types as $item)

                                    <tr id="row{{ $item->id }}">

                                        <td>{{ $item->id }}</td>

                                        <td>
                                            <strong>{{ $item->name }}</strong>
                                        </td>

                                        <td>{{ $item->type }}</td>

                                        <td>
                                            @if($item->status)
                                                <span class="badge badge-primary">Active</span>
                                            @else
                                                <span class="badge badge-danger">Inactive</span>
                                            @endif
                                        </td>

                                        <td>

                                            <a href="{{ route('admin.vendor-types.edit', $item->id) }}"
                                                class="btn btn-sm btn-outline-dark">
                                                <i class="fa fa-pencil"></i>
                                            </a>

                                            <button class="btn btn-sm btn-outline-danger"
                                                onclick="deleteType({{ $item->id }})">
                                                <i class="fa fa-trash"></i>
                                            </button>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            No Vendor Types Found
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
function deleteType(id) {
    Swal.fire({
        title: 'Delete Vendor Type?',
        text: "This action cannot be undone.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Yes, Delete'
    })
    .then((result) => {

        if (result.isConfirmed) {

            $.ajax({
                url: "{{ url('admin/vendor-types') }}/" + id,
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