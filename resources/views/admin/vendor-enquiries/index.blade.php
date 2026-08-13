@include('admin.top-header')

<div class="main-section">

    @include('admin.header')

    <div class="app-content content container-fluid">

        <!-- Breadcrumb -->
        <div class="breadcrumbs-top d-flex align-items-center bg-light mb-3">
            <div class="breadcrumb-wrapper">
                <ol class="breadcrumb bg-transparent mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active">
                        Vendor Enquiries
                    </li>
                </ol>
            </div>
        </div>

        <div class="content-wrapper pb-4">

            <div class="card">
                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-striped table-hover">

                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Vendor Type</th>
                                    <th>City</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach($enquiries as $key => $item)

                                <tr id="row{{ $item->id }}">
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->phone }}</td>
                                    <td>{{ $item->type->name ?? '-' }}</td>
                                    <td>{{ $item->city }}</td>
                                    <td>{{ $item->created_at->format('d M Y') }}</td>

                                   <td>
    <!-- VIEW -->
    <a href="{{ route('admin.vendor-enquiries.show', $item->id) }}"
       class="btn btn-info btn-sm">
        View
    </a>

    <!-- DELETE (AJAX) -->
    <button onclick="deleteEnquiry({{ $item->id }})"
            class="btn btn-danger btn-sm">
        Delete
    </button>
</td>
                                </tr>

                                @endforeach

                            </tbody>

                        </table>

                        <!-- Pagination -->
                        <div class="mt-3">
                            {{ $enquiries->links() }}
                        </div>

                    </div>

                </div>
            </div>

        </div>

    </div>

</div>

@include('admin.footer')
<script>
function deleteEnquiry(id) {
    Swal.fire({
        title: 'Delete Enquiry?',
        text: "This action cannot be undone.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Yes, Delete'
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({
                url: `/admin/vendor-enquiries/${id}`, // ✅ correct route
                type: "DELETE",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function (res) {

                    Swal.fire('Deleted!', res.message, 'success');

                    $("#row" + id).fadeOut(400, function () {
                        $(this).remove();
                    });

                },
                error: function () {
                    Swal.fire('Error', 'Something went wrong', 'error');
                }
            });

        }

    });
}
</script>