@include('admin.top-header')

<style>
    .import-card{
        border:0;
        border-radius:15px;
        box-shadow:0 4px 15px rgba(0,0,0,.08);
    }

    .upload-box{
        border:2px dashed #d6d6d6;
        border-radius:15px;
        padding:50px 20px;
        text-align:center;
        background:#fafafa;
    }

    .upload-icon{
        font-size:55px;
        color:#003108;
        margin-bottom:15px;
    }

    .btn-import{
        background:linear-gradient(90deg,#f97316,#fb923c);
        border:0;
        color:#fff;
        padding:10px 25px;
        border-radius:10px;
        font-weight:600;
    }

    .btn-import:hover{
        color:#fff;
    }
</style>

<div class="main-section">

    @include('admin.header')

    <div class="app-content content container-fluid">

        <div class="card import-card mb-4">
            <div class="card-body text-center">

                <h2>
                    Bulk Import Gifting Occasions
                </h2>

                <p class="text-muted mb-0">
                    Import occasions using Excel or CSV
                </p>

            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <!-- Instructions -->

        <div class="card import-card">
            <div class="card-body">

                <h4>
                    <i class="fa fa-info-circle text-info"></i>
                    Instructions
                </h4>

                <ol class="mb-0">
                    <li>Download sample file.</li>
                    <li>Prepare occasion images ZIP.</li>
                    <li>Upload Images ZIP.</li>
                    <li>Fill Excel using sample format.</li>
                    <li>Import Excel file.</li>
                </ol>

            </div>
        </div>

        <!-- Sample File -->

        <div class="card import-card mt-4">
            <div class="card-body">

                <h4>
                    <i class="fa fa-download text-primary"></i>
                    Download Sample File
                </h4>

                <a href="{{ route('admin.gifting-occasions.import.sample') }}"
                   class="btn btn-primary">
                    Download Sample
                </a>

                <p class="text-muted mt-3 mb-0">
                    Sample includes image_name, icon,
                    SEO fields and status.
                </p>

            </div>
        </div>

        <!-- Upload Images -->

        <div class="card import-card mt-4">
            <div class="card-body">

                <h4>
                    <i class="fa fa-file-archive-o text-warning"></i>
                    Upload Occasion Images
                </h4>

                <form action="{{ route('admin.gifting-occasions.images.upload') }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf

                    <div class="upload-box">

                        <div class="upload-icon">
                            <i class="fa fa-file-archive-o"></i>
                        </div>

                        <h5>Select ZIP File</h5>

                        <input type="file"
                               name="zip_file"
                               class="form-control mt-3"
                               accept=".zip"
                               required>

                    </div>

                    <button type="submit"
                            class="btn btn-warning mt-4">
                        Upload Images ZIP
                    </button>

                </form>

            </div>
        </div>

        <!-- Import Excel -->

        <div class="card import-card mt-4">
            <div class="card-body">

                <h4>
                    <i class="fa fa-file-excel-o text-success"></i>
                    Import Occasions
                </h4>

                <form action="{{ route('admin.gifting-occasions.import.store') }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf

                    <div class="upload-box">

                        <div class="upload-icon">
                            <i class="fa fa-cloud-upload"></i>
                        </div>

                        <h5>Select Excel File</h5>

                        <input type="file"
                               name="file"
                               class="form-control mt-3"
                               accept=".xlsx,.xls,.csv"
                               required>

                    </div>

                    <button type="submit"
                            class="btn btn-import mt-4">
                        Import Occasions
                    </button>

                </form>

            </div>
        </div>

        <div class="text-center mt-4 mb-4">

            <a href="{{ route('admin.gifting-occasions.index') }}"
               class="btn btn-secondary">
                Back To Occasions
            </a>

        </div>

    </div>

</div>

@include('admin.footer')