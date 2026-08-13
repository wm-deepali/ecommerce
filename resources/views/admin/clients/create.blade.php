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
                        <a href="{{ route('admin.clients.index') }}">Manage Clients</a>
                    </li>

                    <li class="breadcrumb-item active">
                        Add Client
                    </li>

                </ol>
            </div>

        </div>

        <div class="content-wrapper pb-4">

            <div class="card shadow-sm">

                <div class="card-header">
                    <strong>Add Client</strong>
                </div>

                <div class="card-body">

                    <form method="POST" action="{{ route('admin.clients.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-body">

                            <div class="form-group row">

                                <div class="col-sm-4">
                                    <label>Client Name *</label>
                                    <input type="text" name="name" class="form-control">
                                </div>

                                <div class="col-sm-4">
                                    <label>Logo</label>
                                    <input type="file" name="logo" class="form-control">
                                </div>

                                <div class="col-sm-4">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>

                            </div>

                            <div class="mt-4">

                                <button type="submit" id="saveBtn" class="btn btn-success">

                                    <i class="fa-solid fa-save"></i>
                                    Save

                                </button>


                                <a href="{{ route('admin.clients.index') }}" class="btn btn-secondary">

                                    Cancel

                                </a>

                            </div>


                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@include('admin.footer')