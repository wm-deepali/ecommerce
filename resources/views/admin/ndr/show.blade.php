@include('admin.top-header')
<div class="main-section">
    @include('admin.header')

    <style>
        :root {
            --bg: #f1f2f4;
            --surface: #ffffff;
            --border: #e3e5e8;
            --text-primary: #202223;
            --text-secondary: #6d7175;
            --text-hint: #8c9196;
            --accent: #303d89;
            --accent-light: #f0f1fc;
            --green: #007a5e;
            --green-bg: #e3f1ec;
            --red: #b22222;
            --red-bg: #fce8e8;
            --amber: #916a00;
            --amber-bg: #fff5cc;
            --blue: #185fa5;
            --blue-bg: #e6f1fb;
            --radius-sm: 8px;
            --radius-md: 12px;
            --shadow-card: 0 1px 3px rgba(0, 0, 0, .08), 0 0 0 1px var(--border);
            --font: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        .detail-page {
            background: var(--bg);
            padding: 24px 28px;
            min-height: 100vh;
            font-family: var(--font);
            color: var(--text-primary);
        }

        .detail-page * {
            box-sizing: border-box;
        }

        .page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 20px;
        }

        .page-header h1 {
            font-size: 20px;
            font-weight: 650;
            margin: 0;
        }

        .crumb {
            font-size: 12.5px;
            color: var(--text-hint);
            margin-top: 3px;
        }

        .crumb a {
            color: var(--accent);
            text-decoration: none;
        }

        .crumb span {
            margin: 0 5px;
        }

        .btn-primary-dash {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--accent);
            color: #fff !important;
            border: none;
            border-radius: var(--radius-sm);
            padding: 8px 16px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none !important;
            font-family: var(--font);
        }

        .btn-secondary-dash {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--surface);
            color: var(--text-primary) !important;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 8px 16px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none !important;
            font-family: var(--font);
        }

        .btn-green-dash {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--green-bg);
            color: var(--green) !important;
            border: 1px solid #b0ddd0;
            border-radius: var(--radius-sm);
            padding: 8px 16px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none !important;
            font-family: var(--font);
        }

        .btn-amber-dash {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--amber-bg);
            color: var(--amber) !important;
            border: 1px solid #f0d060;
            border-radius: var(--radius-sm);
            padding: 8px 16px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none !important;
            font-family: var(--font);
        }

        .btn-red-dash {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--red-bg);
            color: var(--red) !important;
            border: 1px solid #f0c0c0;
            border-radius: var(--radius-sm);
            padding: 8px 16px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none !important;
            font-family: var(--font);
        }

        .detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 16px;
        }

        @media(max-width:760px) {
            .detail-grid {
                grid-template-columns: 1fr;
            }
        }

        .dcard {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            padding: 18px 20px;
            box-shadow: var(--shadow-card);
        }

        .dcard h3 {
            font-size: 11.5px;
            font-weight: 600;
            text-transform: uppercase;
            color: var(--text-hint);
            margin: 0 0 14px;
        }

        .drow {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid var(--border);
            font-size: 13px;
        }

        .drow:last-child {
            border-bottom: none;
        }

        .drow .dlabel {
            color: var(--text-secondary);
        }

        .drow .dval {
            font-weight: 500;
            text-align: right;
        }

        .pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .pill::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
        }

        .pill-pending {
            background: var(--amber-bg);
            color: var(--amber);
        }

        .pill-reattempt {
            background: var(--blue-bg);
            color: var(--blue);
        }

        .pill-rto {
            background: var(--red-bg);
            color: var(--red);
        }

        .pill-delivered {
            background: var(--green-bg);
            color: var(--green);
        }

        .pill-cancelled {
            background: #ececec;
            color: #666;
        }

        .timeline {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .tl-item {
            display: flex;
            gap: 12px;
            padding-bottom: 18px;
            position: relative;
        }

        .tl-item:last-child {
            padding-bottom: 0;
        }

        .tl-item:not(:last-child)::before {
            content: '';
            position: absolute;
            left: 4px;
            top: 14px;
            bottom: 0;
            width: 1px;
            background: var(--border);
        }

        .tl-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-top: 3px;
        }

        .tl-dot-gray {
            background: var(--text-hint);
        }

        .tl-dot-blue {
            background: var(--blue);
        }

        .tl-dot-green {
            background: var(--green);
        }

        .tl-dot-red {
            background: var(--red);
        }

        .tl-label {
            font-size: 13px;
            font-weight: 500;
        }

        .tl-time {
            font-size: 11.5px;
            color: var(--text-hint);
            margin-top: 2px;
        }

        .success-banner {
            display: flex;
            align-items: center;
            gap: 10px;
            background: var(--green-bg);
            border: 1px solid #b2dfd2;
            border-radius: var(--radius-sm);
            padding: 12px 16px;
            margin-bottom: 16px;
            font-size: 13px;
            font-weight: 500;
            color: var(--green);
        }

        .modal-content-box {
            border-radius: 12px;
            border: 1px solid #e3e5e8;
            overflow: hidden;
        }

        .mf-label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: #6d7175;
            text-transform: uppercase;
            letter-spacing: .03em;
            margin-bottom: 5px;
        }

        .mf-input {
            width: 100%;
            border: 1px solid #e3e5e8;
            border-radius: 8px;
            padding: 8px 10px;
            font-size: 13px;
            font-family: inherit;
            outline: none;
        }
    </style>

    <div class="app-content content container-fluid">
        <div class="detail-page">

            @if(session('success'))
                <div class="success-banner"><i class="fa fa-check-circle"></i> {{ session('success') }}</div>
            @endif

            <div class="page-header">
                <div>
                    <h1>NDR-{{ str_pad($ndr->id, 4, '0', STR_PAD_LEFT) }}</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a><span>›</span>
                        <a href="{{ route('admin.ndr.index') }}">NDR Management</a><span>›</span>
                        NDR-{{ str_pad($ndr->id, 4, '0', STR_PAD_LEFT) }}
                    </div>
                </div>
                <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap">
                    @php
                        $pillMap = ['pending' => 'pill-pending', 'reattempt' => 'pill-reattempt', 'rto' => 'pill-rto', 'delivered' => 'pill-delivered', 'cancelled' => 'pill-cancelled'];
                    @endphp
                    <span class="pill {{ $pillMap[$ndr->status] ?? '' }}">{{ ucfirst($ndr->status) }}</span>

                    @if(!in_array($ndr->status, ['delivered', 'rto', 'cancelled']))
                        <button class="btn-secondary-dash" style="color:var(--blue)!important;border-color:var(--blue)"
                            data-toggle="modal" data-target="#reattemptModal">
                            <i class="fa fa-rotate-right"></i> Reattempt
                        </button>
                        <button class="btn-green-dash" data-toggle="modal" data-target="#deliverModal">
                            <i class="fa fa-check"></i> Mark Delivered
                        </button>
                        <button class="btn-amber-dash" data-toggle="modal" data-target="#rtoModal">
                            <i class="fa fa-truck-ramp-box"></i> Mark RTO
                        </button>
                        <button class="btn-red-dash" data-toggle="modal" data-target="#cancelModal">
                            <i class="fa fa-ban"></i> Cancel Order
                        </button>
                    @endif

                    <a href="{{ route('admin.ndr.index') }}" class="btn-secondary-dash"><i class="fa fa-arrow-left"></i>
                        Back</a>
                </div>
            </div>

            <div class="detail-grid">
                <div class="dcard">
                    <h3>NDR Details</h3>
                    <div class="drow"><span class="dlabel">Order</span><span class="dval"
                            style="color:var(--accent)">#{{ $ndr->order->order_number }}</span></div>
                    <div class="drow"><span class="dlabel">Reason</span><span
                            class="dval">{{ $ndr->reason_label }}</span></div>
                    <div class="drow"><span class="dlabel">Attempts</span><span
                            class="dval">{{ $ndr->attempt_count }}</span></div>
                    <div class="drow"><span class="dlabel">Next Attempt</span><span
                            class="dval">{{ $ndr->next_attempt_date?->format('d M Y') ?? '—' }}</span></div>
                    <div class="drow"><span class="dlabel">Marked By</span><span
                            class="dval">{{ $ndr->marked_by ?? '—' }}</span></div>
                    <div class="drow"><span class="dlabel">Raised On</span><span
                            class="dval">{{ $ndr->created_at->format('d M Y, h:i A') }}</span></div>
                    @if($ndr->resolved_at)
                        <div class="drow"><span class="dlabel">Resolved On</span><span
                                class="dval">{{ $ndr->resolved_at->format('d M Y, h:i A') }}</span></div>
                    @endif
                    @if($ndr->remarks)
                        <div class="drow" style="align-items:flex-start"><span class="dlabel">Remarks</span><span
                                class="dval" style="max-width:260px">{{ $ndr->remarks }}</span></div>
                    @endif
                </div>

                <div class="dcard">
                    <h3>Customer & Delivery Address</h3>
                    <div class="drow"><span class="dlabel">Name</span><span
                            class="dval">{{ $ndr->order->customer_name }}</span></div>
                    <div class="drow"><span class="dlabel">Phone</span><span
                            class="dval">{{ $ndr->order->customer_phone }}</span></div>
                    <div class="drow" style="align-items:flex-start">
                        <span class="dlabel">Address</span>
                        <span class="dval" style="max-width:260px">
                            {{ $ndr->order->address_line_1 }}{{ $ndr->order->address_line_2 ? ', ' . $ndr->order->address_line_2 : '' }},
                            {{ $ndr->order->city?->name }}, {{ $ndr->order->state?->name }} - {{ $ndr->order->pincode }}
                        </span>
                    </div>
                    <div class="drow">
                        <span class="dlabel">Order</span>
                        <a href="{{ route('admin.orders.show', $ndr->order_id) }}"
                            style="color:var(--accent);font-size:13px">View Order →</a>
                    </div>
                </div>
            </div>

            <div class="detail-grid">
                <div class="dcard" style="grid-column:1/-1">
                    <h3>Timeline</h3>
                    <ul class="timeline">
                        <li class="tl-item">
                            <div class="tl-dot tl-dot-gray"></div>
                            <div>
                                <div class="tl-label">NDR raised — {{ $ndr->reason_label }}</div>
                                <div class="tl-time">{{ $ndr->created_at->format('d M Y, h:i A') }}</div>
                            </div>
                        </li>
                        @if($ndr->status === 'reattempt')
                            <li class="tl-item">
                                <div class="tl-dot tl-dot-blue"></div>
                                <div>
                                    <div class="tl-label">Redelivery attempt #{{ $ndr->attempt_count }} scheduled</div>
                                    <div class="tl-time">For {{ $ndr->next_attempt_date?->format('d M Y') }}</div>
                                </div>
                            </li>
                        @endif
                        @if($ndr->resolved_at)
                            <li class="tl-item">
                                <div class="tl-dot {{ $ndr->status === 'delivered' ? 'tl-dot-green' : 'tl-dot-red' }}">
                                </div>
                                <div>
                                    <div class="tl-label">
                                        @if($ndr->status === 'delivered') Delivered
                                        @elseif($ndr->status === 'rto') Returned to Origin — stock credited back
                                        @elseif($ndr->status === 'cancelled') Order Cancelled
                                        @endif
                                    </div>
                                    <div class="tl-time">{{ $ndr->resolved_at->format('d M Y, h:i A') }}</div>
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== Reattempt Modal ===== --}}
    <div class="modal fade" id="reattemptModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-box">
                <div class="modal-header" style="border-bottom:1px solid #e3e5e8;padding:18px 20px">
                    <h5 class="modal-title" style="font-size:15px;font-weight:600;margin:0">Schedule Redelivery</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form method="POST" action="{{ route('admin.ndr.reattempt', $ndr->id) }}">
                    @csrf @method('PATCH')
                    <div class="modal-body" style="padding:20px">
                        <div style="margin-bottom:14px">
                            <label class="mf-label">Next Attempt Date <span style="color:#b22222">*</span></label>
                            <input type="date" name="next_attempt_date" class="mf-input" required
                                min="{{ now()->format('Y-m-d') }}">
                        </div>
                        <div>
                            <label class="mf-label">Remarks</label>
                            <textarea name="remarks" rows="3" class="mf-input"
                                placeholder="Any note for this reattempt…"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer"
                        style="border-top:1px solid #e3e5e8;padding:14px 20px;display:flex;justify-content:flex-end;gap:8px">
                        <button type="button" class="btn-secondary-dash" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn-primary-dash"><i class="fa fa-rotate-right"></i> Schedule
                            Reattempt</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ===== Deliver Modal ===== --}}
    <div class="modal fade" id="deliverModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-box">
                <div class="modal-header" style="border-bottom:1px solid #e3e5e8;padding:18px 20px">
                    <h5 class="modal-title" style="font-size:15px;font-weight:600;margin:0">Mark as Delivered</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form method="POST" action="{{ route('admin.ndr.mark-delivered', $ndr->id) }}">
                    @csrf @method('PATCH')
                    <div class="modal-body" style="padding:20px;font-size:13px;color:#6d7175">
                        Confirm that order #{{ $ndr->order->order_number }} was successfully delivered to the customer.
                    </div>
                    <div class="modal-footer"
                        style="border-top:1px solid #e3e5e8;padding:14px 20px;display:flex;justify-content:flex-end;gap:8px">
                        <button type="button" class="btn-secondary-dash" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn-green-dash"><i class="fa fa-check"></i> Confirm
                            Delivered</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ===== RTO Modal ===== --}}
    <div class="modal fade" id="rtoModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered {{ $ndr->order->payment_status === 'paid' ? 'modal-lg' : '' }}"
            role="document">
            <div class="modal-content modal-content-box">
                <div class="modal-header" style="border-bottom:1px solid #e3e5e8;padding:18px 20px">
                    <h5 class="modal-title" style="font-size:15px;font-weight:600;margin:0">Mark as RTO</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form method="POST" action="{{ route('admin.ndr.mark-rto', $ndr->id) }}" enctype="multipart/form-data">
                    @csrf @method('PATCH')
                    <div class="modal-body" style="padding:20px">
                        <div
                            style="background:#fff5cc;border:1px solid #f0d060;border-radius:8px;padding:10px 12px;font-size:12.5px;color:#916a00;margin-bottom:14px">
                            <i class="fa fa-circle-info"></i> Marking RTO will credit stock back for all items in this
                            order automatically.
                            @if($ndr->order->payment_status === 'paid')
                                This order was paid online — you must record a refund below.
                            @endif
                        </div>

                        <div style="margin-bottom:14px">
                            <label class="mf-label">Remarks</label>
                            <textarea name="remarks" rows="3" class="mf-input" placeholder="Reason for RTO…"></textarea>
                        </div>

                        @if($ndr->order->payment_status === 'paid')
                            <div style="border-top:1px dashed #e3e5e8;margin-top:6px;padding-top:16px">
                                <div
                                    style="font-size:11.5px;font-weight:600;color:#8c9196;text-transform:uppercase;letter-spacing:.04em;margin-bottom:12px">
                                    Refund — ₹{{ number_format($ndr->order->grand_total, 2) }}
                                </div>

                                {{-- Payment Method Tabs --}}
                                <div style="margin-bottom:14px">
                                    <label class="mf-label">Payment Method <span style="color:#b22222">*</span></label>
                                    <div style="display:flex;gap:8px">
                                        <label id="rto-tab-neft_rtgs_imps" class="refund-tab"
                                            style="flex:1;border:1px solid #e3e5e8;border-radius:8px;padding:10px 12px;text-align:center;cursor:pointer;font-size:13px;font-weight:500;color:#202223;background:#fff">
                                            <input type="radio" name="refund_method" value="neft_rtgs_imps"
                                                style="display:none"
                                                onchange="ndrToggleRefundMethod('rto', 'neft_rtgs_imps')" required>
                                            NEFT / RTGS / IMPS
                                        </label>
                                        <label id="rto-tab-upi" class="refund-tab"
                                            style="flex:1;border:1px solid #e3e5e8;border-radius:8px;padding:10px 12px;text-align:center;cursor:pointer;font-size:13px;font-weight:500;color:#202223;background:#fff">
                                            <input type="radio" name="refund_method" value="upi" style="display:none"
                                                onchange="ndrToggleRefundMethod('rto', 'upi')">
                                            UPI
                                        </label>
                                    </div>
                                </div>

                                {{-- Bank fields --}}
                                <div id="rto-method-neft_rtgs_imps" style="display:none;margin-bottom:4px">
                                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
                                        <div style="margin-bottom:12px"><label class="mf-label">Bank Name</label><input
                                                type="text" name="bank_name" class="mf-input" placeholder="e.g. HDFC Bank">
                                        </div>
                                        <div style="margin-bottom:12px"><label class="mf-label">Account Holder
                                                Name</label><input type="text" name="account_name" class="mf-input"
                                                placeholder="Name on account"></div>
                                        <div style="margin-bottom:12px"><label class="mf-label">Account Number</label><input
                                                type="text" name="account_number" class="mf-input"
                                                placeholder="Account number"></div>
                                        <div style="margin-bottom:12px"><label class="mf-label">IFSC Code</label><input
                                                type="text" name="ifsc_code" class="mf-input" placeholder="HDFC0001234">
                                        </div>
                                        <div style="margin-bottom:12px"><label class="mf-label">Bank Branch</label><input
                                                type="text" name="bank_branch" class="mf-input" placeholder="Branch name">
                                        </div>
                                        <div style="margin-bottom:12px">
                                            <label class="mf-label">Account Type</label>
                                            <select name="account_type" class="mf-input">
                                                <option value="">Select…</option>
                                                <option value="savings">Savings</option>
                                                <option value="current">Current</option>
                                                <option value="salary">Salary</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                {{-- UPI field --}}
                                <div id="rto-method-upi" style="display:none;margin-bottom:14px">
                                    <label class="mf-label">UPI ID</label>
                                    <input type="text" name="upi_id" class="mf-input" placeholder="name@upi">
                                </div>

                                <div style="margin-bottom:14px">
                                    <label class="mf-label">Reference / UTR ID <span style="color:#b22222">*</span></label>
                                    <input type="text" name="utr_id" required class="mf-input"
                                        placeholder="Transaction reference number">
                                </div>

                                <div>
                                    <label class="mf-label">Payment Proof</label>
                                    <input type="file" name="payment_proof" accept="image/*,application/pdf"
                                        class="mf-input" style="padding:6px">
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer"
                        style="border-top:1px solid #e3e5e8;padding:14px 20px;display:flex;justify-content:flex-end;gap:8px">
                        <button type="button" class="btn-secondary-dash" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn-amber-dash"><i class="fa fa-truck-ramp-box"></i> Confirm
                            RTO</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ===== Cancel Modal ===== --}}
    {{-- ===== Cancel Modal ===== --}}
    <div class="modal fade" id="cancelModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered {{ $ndr->order->payment_status === 'paid' ? 'modal-lg' : '' }}"
            role="document">
            <div class="modal-content modal-content-box">
                <div class="modal-header" style="border-bottom:1px solid #e3e5e8;padding:18px 20px">
                    <h5 class="modal-title" style="font-size:15px;font-weight:600;margin:0">Cancel Order</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form method="POST" action="{{ route('admin.ndr.cancel', $ndr->id) }}" enctype="multipart/form-data">
                    @csrf @method('PATCH')
                    <div class="modal-body" style="padding:20px">
                        @if($ndr->order->payment_status === 'paid')
                            <div
                                style="background:#fce8e8;border:1px solid #f0c0c0;border-radius:8px;padding:10px 12px;font-size:12.5px;color:#b22222;margin-bottom:14px">
                                <i class="fa fa-circle-info"></i> This order was paid online — you must record a refund
                                below.
                            </div>
                        @endif

                        <div style="margin-bottom:14px">
                            <label class="mf-label">Reason for Cancellation</label>
                            <textarea name="remarks" rows="3" class="mf-input"
                                placeholder="Explain why this order is being cancelled…"></textarea>
                        </div>

                        @if($ndr->order->payment_status === 'paid')
                            <div style="border-top:1px dashed #e3e5e8;margin-top:6px;padding-top:16px">
                                <div
                                    style="font-size:11.5px;font-weight:600;color:#8c9196;text-transform:uppercase;letter-spacing:.04em;margin-bottom:12px">
                                    Refund — ₹{{ number_format($ndr->order->grand_total, 2) }}
                                </div>

                                <div style="margin-bottom:14px">
                                    <label class="mf-label">Payment Method <span style="color:#b22222">*</span></label>
                                    <div style="display:flex;gap:8px">
                                        <label id="cancel-tab-neft_rtgs_imps" class="refund-tab"
                                            style="flex:1;border:1px solid #e3e5e8;border-radius:8px;padding:10px 12px;text-align:center;cursor:pointer;font-size:13px;font-weight:500;color:#202223;background:#fff">
                                            <input type="radio" name="refund_method" value="neft_rtgs_imps"
                                                style="display:none"
                                                onchange="ndrToggleRefundMethod('cancel', 'neft_rtgs_imps')" required>
                                            NEFT / RTGS / IMPS
                                        </label>
                                        <label id="cancel-tab-upi" class="refund-tab"
                                            style="flex:1;border:1px solid #e3e5e8;border-radius:8px;padding:10px 12px;text-align:center;cursor:pointer;font-size:13px;font-weight:500;color:#202223;background:#fff">
                                            <input type="radio" name="refund_method" value="upi" style="display:none"
                                                onchange="ndrToggleRefundMethod('cancel', 'upi')">
                                            UPI
                                        </label>
                                    </div>
                                </div>

                                <div id="cancel-method-neft_rtgs_imps" style="display:none;margin-bottom:4px">
                                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
                                        <div style="margin-bottom:12px"><label class="mf-label">Bank Name</label><input
                                                type="text" name="bank_name" class="mf-input" placeholder="e.g. HDFC Bank">
                                        </div>
                                        <div style="margin-bottom:12px"><label class="mf-label">Account Holder
                                                Name</label><input type="text" name="account_name" class="mf-input"
                                                placeholder="Name on account"></div>
                                        <div style="margin-bottom:12px"><label class="mf-label">Account Number</label><input
                                                type="text" name="account_number" class="mf-input"
                                                placeholder="Account number"></div>
                                        <div style="margin-bottom:12px"><label class="mf-label">IFSC Code</label><input
                                                type="text" name="ifsc_code" class="mf-input" placeholder="HDFC0001234">
                                        </div>
                                        <div style="margin-bottom:12px"><label class="mf-label">Bank Branch</label><input
                                                type="text" name="bank_branch" class="mf-input" placeholder="Branch name">
                                        </div>
                                        <div style="margin-bottom:12px">
                                            <label class="mf-label">Account Type</label>
                                            <select name="account_type" class="mf-input">
                                                <option value="">Select…</option>
                                                <option value="savings">Savings</option>
                                                <option value="current">Current</option>
                                                <option value="salary">Salary</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div id="cancel-method-upi" style="display:none;margin-bottom:14px">
                                    <label class="mf-label">UPI ID</label>
                                    <input type="text" name="upi_id" class="mf-input" placeholder="name@upi">
                                </div>

                                <div style="margin-bottom:14px">
                                    <label class="mf-label">Reference / UTR ID <span style="color:#b22222">*</span></label>
                                    <input type="text" name="utr_id" required class="mf-input"
                                        placeholder="Transaction reference number">
                                </div>

                                <div>
                                    <label class="mf-label">Payment Proof</label>
                                    <input type="file" name="payment_proof" accept="image/*,application/pdf"
                                        class="mf-input" style="padding:6px">
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer"
                        style="border-top:1px solid #e3e5e8;padding:14px 20px;display:flex;justify-content:flex-end;gap:8px">
                        <button type="button" class="btn-secondary-dash" data-dismiss="modal">Back</button>
                        <button type="submit" class="btn-red-dash"><i class="fa fa-ban"></i> Cancel Order</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

@include('admin.footer')

<script>
function ndrToggleRefundMethod(context, selected) {
    ['neft_rtgs_imps', 'upi'].forEach(function (m) {
        var panel = document.getElementById(context + '-method-' + m);
        if (panel) panel.style.display = (m === selected) ? 'block' : 'none';

        var tab = document.getElementById(context + '-tab-' + m);
        if (!tab) return;

        if (m === selected) {
            tab.style.borderColor = '#303d89';
            tab.style.color = '#303d89';
            tab.style.background = '#f0f1fc';
        } else {
            tab.style.borderColor = '#e3e5e8';
            tab.style.color = '#202223';
            tab.style.background = '#fff';
        }
    });
}
</script>