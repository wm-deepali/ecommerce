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

                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.enquiries.index') }}">Enquiries</a>
                    </li>

                    <li class="breadcrumb-item active">
                        View Enquiry
                    </li>

                </ol>
            </div>

        </div>

        <div class="content-wrapper pb-4">

            <div class="row">

               <div class="row g-4">

    <!-- LEFT: CUSTOMER DETAILS -->
    <div class="col-lg-4">
        <div class="card shadow-sm border-0 h-100">
            
            <div class="card-header bg-light">
                <h5 class="mb-0">Customer Details</h5>
            </div>

            <div class="card-body">

                <div class="row g-2 small">

                    <div class="col-6"><strong>Business</strong></div>
                    <div class="col-6 text-end">{{ $enquiry->business_name }}</div>

                    <div class="col-6"><strong>Owner</strong></div>
                    <div class="col-6 text-end">{{ $enquiry->owner_name }}</div>

                    <div class="col-6"><strong>Email</strong></div>
                    <div class="col-6 text-end">{{ $enquiry->email }}</div>

                    <div class="col-6"><strong>Mobile</strong></div>
                    <div class="col-6 text-end">{{ $enquiry->mobile }}</div>

                    

                    <div class="col-12 mt-2">
                        <strong>Address</strong><br>
                        <span class="text-muted">{{ $enquiry->address }}</span>
                    </div>
                    <div class="col-6"><strong>State</strong></div>
                    <div class="col-6 text-end">{{ $enquiry->state->name ?? '-' }}</div>

                    <div class="col-6"><strong>City</strong></div>
                    <div class="col-6 text-end">{{ $enquiry->city->name ?? '-' }}</div>

                    <div class="col-12 mt-2">
                        <strong>Date</strong><br>
                        <span class="text-muted">{{ $enquiry->created_at->format('d M Y h:i A') }}</span>
                    </div>

                </div>

            </div>
        </div>
    </div>


    <!-- RIGHT: PRODUCTS -->
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Enquiry Products</h5>

                <span class="badge bg-primary">
                    {{ $enquiry->items->count() }} Items
                </span>
            </div>

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">
                            <tr>
                                <th style="width:50%">Product</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Price</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>

                        <tbody>

                        @foreach($enquiry->items as $item)
                            <tr>

                                <td>
                                    <div class="d-flex align-items-center gap-3">

                                        <!-- PRODUCT IMAGE -->
                                        

                                        <!-- PRODUCT NAME -->
                                        <div>
                                            <div class="fw-semibold">
                                                {{ $item->product->name ?? '-' }}
                                            </div>

                                            <small class="text-muted">
                                                SKU: {{ $item->product->sku ?? 'N/A' }}
                                            </small>
                                        </div>

                                    </div>
                                </td>

                                <td class="text-center">
                                    <span class="badge bg-light text-dark">
                                        {{ $item->quantity }}
                                    </span>
                                </td>

                                <td class="text-end">
                                    ₹{{ number_format($item->price) }}
                                </td>

                                <td class="text-end fw-semibold">
                                    ₹{{ number_format($item->total) }}
                                </td>

                            </tr>
                        @endforeach

                        </tbody>

                        <tfoot class="table-light">

                            <tr>
                                <td colspan="2" class="fw-semibold">
                                    Total Qty: {{ $enquiry->items->sum('quantity') }}
                                </td>

                                <td class="text-end fw-bold">
                                    Grand Total
                                </td>

                                <td class="text-end fw-bold text-success">
                                    ₹{{ number_format($enquiry->items->sum('total')) }}
                                </td>
                            </tr>

                        </tfoot>

                    </table>

                </div>

            </div>
        </div>
    </div>

</div>
                
                
                
                
                
                
                
                
                
                

            </div>

        </div>

    </div>

</div>

@include('admin.footer')