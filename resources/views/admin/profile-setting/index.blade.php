@include('admin.top-header')

<div class="main-section">

@include('admin.header')

<div class="app-content content container-fluid">

<div class="breadcrumbs-top d-flex align-items-center bg-light mb-3">
    <div class="breadcrumb-wrapper">
        <ol class="breadcrumb bg-transparent mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Pages</li>
            <li class="breadcrumb-item active">Profile Setting</li>
        </ol>
    </div>
</div>

<div class="content-wrapper pb-4">

    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">Account Setting</a>
        </li>
    </ul>

    <div class="tab-content border px-3">
        <div class="tab-pane active" id="tabs-1" role="tabpanel">

            <form class="py-5" action="{{ route('admin.reset.password') }}" method="POST">
                @csrf

                {{-- SUCCESS MESSAGE --}}
                @if(Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                    </div>
                @endif

                {{-- ERROR MESSAGE --}}
                @if(Session::has('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                    </div>
                @endif

                <div class="row">

                    {{-- New Password --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>New Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" 
                                   placeholder="Enter new password" 
                                   name="password">
                            @error('password')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- CONFIRM --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Confirm Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control"
                                   placeholder="Confirm new password"
                                   name="password_confirmation">
                            @error('password_confirmation')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12">
                        <button class="btn bg-dark text-white" type="submit">
                            Submit
                        </button>
                    </div>

                </div>

            </form>

        </div>
    </div>
</div>

</div>

@include('admin.footer')
