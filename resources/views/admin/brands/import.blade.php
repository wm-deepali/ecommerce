@include('admin.top-header')

<style>
    .import-card {
        border: 0;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, .08);
    }

    .upload-box {
        border: 2px dashed #d6d6d6;
        border-radius: 15px;
        padding: 50px 20px;
        text-align: center;
        background: #fafafa;
    }

    .upload-icon {
        font-size: 55px;
        color: #003108;
        margin-bottom: 15px;
    }

    .btn-import {
        background: linear-gradient(90deg, #f97316, #fb923c);
        border: 0;
        color: #fff;
        padding: 10px 25px;
        border-radius: 10px;
        font-weight: 600;
    }

    .btn-import:hover {
        color: #fff;
    }
</style>

<div class="main-section">

    @include('admin.header')

    <div class="app-content content container-fluid">

        <div class="card import-card mb-4">
            <div class="card-body text-center">

                <h2>
                    Bulk Import Brands
                </h2>

                <p class="text-muted mb-0">
                    Import Brands using Excel or CSV
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
                    <li>Download the sample file.</li>
                    <li>Prepare brand logos and create ZIP file.</li>
                    <li>Upload Brand Logos ZIP.</li>
                    <li>Fill Excel using sample format.</li>
                    <li>Categories must already exist.</li>
                    <li>Import Excel/CSV file.</li>
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

                <p class="text-muted">
                    Download the sample sheet and use the same format.
                </p>

                <a href="{{ route('admin.brands.import.sample') }}" class="btn btn-primary">
                    Download Sample
                </a>

                <a href="{{ route('admin.brands.category.reference') }}" class="btn btn-info ml-2">
                    Download Category Reference
                </a>

                <p class="text-muted mt-3 mb-0">
                    Sample includes logo_name,
                    categories and status fields.
                </p>

            </div>
        </div>

        <!-- Upload Logos -->

        <div class="card import-card mt-4">
            <div class="card-body">

                <h4>
                    <i class="fa fa-file-archive-o text-warning"></i>
                    Upload Brand Logos
                </h4>

                <form action="{{ route('admin.brands.images.upload') }}" method="POST" enctype="multipart/form-data">

                    @csrf

                    <div class="upload-box">

                        <div class="upload-icon">
                            <i class="fa fa-file-archive-o"></i>
                        </div>

                        <h5>Select ZIP File</h5>

                        <p class="text-muted">
                            Upload ZIP containing brand logos
                        </p>

                        <input type="file" name="zip_file" class="form-control mt-3" accept=".zip" required>

                    </div>

                    <button type="submit" class="btn btn-warning mt-4">
                        Upload Logos ZIP
                    </button>

                    <p class="text-muted mt-3 mb-0">
                        Example:
                        parker.jpg,
                        cello.jpg,
                        cross.jpg
                    </p>

                </form>

            </div>
        </div>

        <!-- Import Excel -->

        <div class="card import-card mt-4">
            <div class="card-body">

                <h4>
                    <i class="fa fa-file-excel-o text-success"></i>
                    Import Brands
                </h4>

                <form action="{{ route('admin.brands.import.store') }}" method="POST" enctype="multipart/form-data">

                    @csrf

                    <div class="upload-box">

                        <div class="upload-icon">
                            <i class="fa fa-cloud-upload"></i>
                        </div>

                        <h5>Select Excel File</h5>

                        <p class="text-muted">
                            Supported Formats: XLSX, XLS, CSV
                        </p>

                        <input type="file" name="file" class="form-control mt-3" accept=".xlsx,.xls,.csv" required>

                    </div>

                    <button type="submit" class="btn btn-import mt-4">
                        Import Brands
                    </button>

                </form>

            </div>
        </div>

        <div class="text-center mt-4 mb-4">

            <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary">
                Back To Brands
            </a>

        </div>

    </div>

</div>

@include('admin.footer')