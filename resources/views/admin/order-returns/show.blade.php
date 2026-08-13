@include('admin.top-header')
<div class="main-section">
    @include('admin.header')

    <style>
    :root {
        --bg: #f1f2f4; --surface: #ffffff; --border: #e3e5e8;
        --text-primary: #202223; --text-secondary: #6d7175; --text-hint: #8c9196;
        --accent: #303d89; --accent-light: #f0f1fc;
        --green: #007a5e; --green-bg: #e3f1ec;
        --red: #b22222; --red-bg: #fce8e8;
        --amber: #916a00; --amber-bg: #fff5cc;
        --blue: #185fa5; --blue-bg: #e6f1fb;
        --radius-sm: 8px; --radius-md: 12px;
        --shadow-card: 0 1px 3px rgba(0,0,0,.08), 0 0 0 1px var(--border);
        --font: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }
    .detail-page { background: var(--bg); padding: 24px 28px; min-height: 100vh; font-family: var(--font); color: var(--text-primary); }
    .detail-page * { box-sizing: border-box; }

    .page-header { display: flex; align-items: flex-start; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 20px; }
    .page-header h1 { font-size: 20px; font-weight: 650; margin: 0; }
    .crumb { font-size: 12.5px; color: var(--text-hint); margin-top: 3px; }
    .crumb a { color: var(--accent); text-decoration: none; }
    .crumb a:hover { text-decoration: underline; }
    .crumb span { margin: 0 5px; }

    .btn-primary-dash { display: inline-flex; align-items: center; gap: 6px; background: var(--accent); color: #fff !important; border: none; border-radius: var(--radius-sm); padding: 8px 16px; font-size: 13px; font-weight: 600; cursor: pointer; text-decoration: none !important; font-family: var(--font); transition: background .15s; }
    .btn-primary-dash:hover { background: #252f70; }
    .btn-secondary-dash { display: inline-flex; align-items: center; gap: 6px; background: var(--surface); color: var(--text-primary) !important; border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 8px 16px; font-size: 13px; font-weight: 500; cursor: pointer; text-decoration: none !important; font-family: var(--font); transition: background .15s; }
    .btn-secondary-dash:hover { background: var(--bg); }

    .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px; }
    @media(max-width:760px) { .detail-grid { grid-template-columns: 1fr; } }

    .dcard { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 18px 20px; box-shadow: var(--shadow-card); }
    .dcard h3 { font-size: 11.5px; font-weight: 600; text-transform: uppercase; letter-spacing: .04em; color: var(--text-hint); margin: 0 0 14px; }
    .drow { display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px solid var(--border); font-size: 13px; }
    .drow:last-child { border-bottom: none; padding-bottom: 0; }
    .drow .dlabel { color: var(--text-secondary); }
    .drow .dval { font-weight: 500; color: var(--text-primary); text-align: right; }

    .pill { display: inline-flex; align-items: center; gap: 5px; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; white-space: nowrap; }
    .pill::before { content: ''; width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
    .pill-pending { background: var(--amber-bg); color: var(--amber); }
    .pill-approved { background: var(--blue-bg); color: var(--blue); }
    .pill-rejected { background: var(--red-bg); color: var(--red); }
    .pill-refunded { background: var(--green-bg); color: var(--green); }

    .cust-avatar { width: 42px; height: 42px; border-radius: 50%; background: var(--accent-light); display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 600; color: var(--accent); flex-shrink: 0; }

    /* Timeline */
    .timeline { list-style: none; padding: 0; margin: 0; }
    .tl-item { display: flex; gap: 12px; padding-bottom: 18px; position: relative; }
    .tl-item:last-child { padding-bottom: 0; }
    .tl-item:not(:last-child)::before { content: ''; position: absolute; left: 4px; top: 14px; bottom: 0; width: 1px; background: var(--border); }
    .tl-dot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; margin-top: 3px; }
    .tl-dot-default { background: var(--accent); }
    .tl-dot-gray { background: var(--text-hint); }
    .tl-dot-green { background: var(--green); }
    .tl-dot-red { background: var(--red); }
    .tl-label { font-size: 13px; font-weight: 500; color: var(--text-primary); }
    .tl-time { font-size: 11.5px; color: var(--text-hint); margin-top: 2px; }

    /* Success banner */
    .success-banner { display: flex; align-items: center; gap: 10px; background: var(--green-bg); border: 1px solid #b2dfd2; border-radius: var(--radius-sm); padding: 12px 16px; margin-bottom: 16px; font-size: 13px; font-weight: 500; color: var(--green); }

    /* Proof image */
    .proof-preview { max-width: 100%; max-height: 220px; border-radius: 8px; border: 1px solid var(--border); margin-top: 10px; display: block; }
    </style>

    <div class="app-content content container-fluid">
        <div class="detail-page">

            @if(session('refund_success'))
            <div class="success-banner">
                <i class="fa fa-check-circle"></i> Refund submitted successfully — UTR: <strong>{{ session('refund_utr') }}</strong>
            </div>
            @endif

            <div class="page-header">
                <div>
                    <h1>Return RET-{{ str_pad($return->id, 4, '0', STR_PAD_LEFT) }}</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a><span>›</span>
                        <a href="{{ route('admin.order-returns.index') }}">Order Returns</a><span>›</span>
                        RET-{{ str_pad($return->id, 4, '0', STR_PAD_LEFT) }}
                    </div>
                </div>
                <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap">
                    @php
                        $pillMap = ['pending'=>'pill-pending','approved'=>'pill-approved','rejected'=>'pill-rejected','completed'=>'pill-refunded'];
                        $labelMap = ['pending'=>'Pending','approved'=>'Approved','rejected'=>'Rejected','completed'=>'Refunded'];
                    @endphp
                    <span class="pill {{ $pillMap[$return->status] ?? '' }}">{{ $labelMap[$return->status] ?? ucfirst($return->status) }}</span>

                    @if($return->status === 'pending')
                        <button class="btn-secondary-dash" style="color:var(--green)!important;border-color:var(--green)"
                                onclick="openApproveModal({{ $return->id }}, '{{ addslashes($return->customer->name) }}', '{{ addslashes($return->orderItem->product->name ?? '') }}')">
                            <i class="fa fa-check"></i> Approve
                        </button>
                        <button class="btn-secondary-dash" style="color:var(--red)!important;border-color:var(--red)"
                                onclick="openRejectModal({{ $return->id }}, '{{ addslashes($return->customer->name) }}', '{{ addslashes($return->orderItem->product->name ?? '') }}')">
                            <i class="fa fa-times"></i> Reject
                        </button>
                    @endif

                    @if($return->status === 'approved')
                        <button class="btn-primary-dash"
                                onclick="openRefundModal({{ $return->id }}, '{{ addslashes($return->customer->name) }}', '{{ addslashes($return->orderItem->product->name ?? '') }}', {{ $return->orderItem->price ?? 0 }}, {{ \Illuminate\Support\Js::from([
                                    'method' => $return->refund_method,
                                    'upi_id' => $return->upi_id,
                                    'bank_name' => $return->bank_name,
                                    'account_name' => $return->account_name,
                                    'account_number' => $return->account_number,
                                    'ifsc_code' => $return->ifsc_code,
                                    'bank_branch' => $return->bank_branch,
                                    'account_type' => $return->account_type,
                                    'qr_image_url' => $return->qr_image ? asset('storage/'.$return->qr_image) : null,
                                ]) }})">
                            <i class="fa fa-credit-card"></i> Process Refund
                        </button>
                    @endif

                    <a href="{{ route('admin.order-returns.index') }}" class="btn-secondary-dash">
                        <i class="fa fa-arrow-left"></i> Back
                    </a>
                </div>
            </div>

            <div class="detail-grid">
                {{-- Return Info --}}
                <div class="dcard">
                    <h3>Return Details</h3>
                    <div class="drow"><span class="dlabel">Return ID</span><span class="dval">RET-{{ str_pad($return->id, 4, '0', STR_PAD_LEFT) }}</span></div>
                    <div class="drow"><span class="dlabel">Order</span><span class="dval" style="color:var(--accent)">#ORD-{{ $return->order->id }}</span></div>
                    <div class="drow"><span class="dlabel">Product</span><span class="dval">{{ $return->orderItem->product->name ?? '—' }}</span></div>
                    <div class="drow"><span class="dlabel">Reason</span><span class="dval">{{ $return->returnReason->title ?? $return->details ?? '—' }}</span></div>
                    <div class="drow"><span class="dlabel">Type</span><span class="dval">{{ ucfirst($return->type) }}</span></div>
                    <div class="drow"><span class="dlabel">Amount</span><span class="dval" style="color:var(--accent);font-size:15px">₹{{ number_format($return->orderItem->price ?? 0, 0) }}</span></div>
                    <div class="drow"><span class="dlabel">Requested On</span><span class="dval">{{ $return->created_at->format('d M Y, h:i A') }}</span></div>
                    @if($return->details)
                    <div class="drow"><span class="dlabel">Details</span><span class="dval" style="max-width:240px;text-align:right">{{ $return->details }}</span></div>
                    @endif
                    @if($return->admin_note)
                    <div class="drow"><span class="dlabel">Admin Note</span><span class="dval" style="max-width:240px;text-align:right">{{ $return->admin_note }}</span></div>
                    @endif
                </div>

                {{-- Customer Info --}}
                <div class="dcard">
                    <h3>Customer</h3>
                    <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px">
                        <div class="cust-avatar">
                            {{ strtoupper(substr($return->customer->name, 0, 1)) }}{{ strtoupper(substr(strstr($return->customer->name, ' '), 1, 1)) }}
                        </div>
                        <div>
                            <div style="font-size:15px;font-weight:600">{{ $return->customer->name }}</div>
                            <div style="font-size:12.5px;color:var(--text-hint)">{{ $return->customer->email }}</div>
                        </div>
                    </div>
                    <div class="drow"><span class="dlabel">Phone</span><span class="dval">{{ $return->customer->mobile ?? '—' }}</span></div>
                    <div class="drow"><span class="dlabel">Customer ID</span><span class="dval">#{{ $return->customer->id }}</span></div>
                    <div class="drow">
                        <span class="dlabel">Profile</span>
                        <a href="{{ route('admin.customers.show', $return->customer->id) }}" style="color:var(--accent);font-size:13px">View Customer →</a>
                    </div>
                    <div class="drow">
                        <span class="dlabel">Order</span>
                        <a href="{{ route('admin.orders.show', $return->order->id) }}" style="color:var(--accent);font-size:13px">View Order →</a>
                    </div>
                </div>
            </div>

            <div class="detail-grid">
                {{--
                    Customer's Requested Refund Method.
                    This reads order_returns.refund_method / upi_id / bank_* / qr_image,
                    which is what the customer submitted in submitReturn(). The admin
                    refund() action never writes to these columns, so this stays an
                    accurate record of the original request even after the refund
                    has been processed.
                --}}
                <div class="dcard" style="{{ $return->status === 'completed' ? '' : 'grid-column:1/-1' }}">
                    <h3>Customer's Requested Refund Method</h3>
                    <div class="drow"><span class="dlabel">Method</span><span class="dval">{{ strtoupper($return->refund_method) }}</span></div>

                    @if($return->refund_method === 'upi')
                        <div class="drow"><span class="dlabel">UPI ID</span><span class="dval">{{ $return->upi_id ?? '—' }}</span></div>
                    @elseif($return->refund_method === 'bank')
                        <div class="drow"><span class="dlabel">Bank</span><span class="dval">{{ $return->bank_name ?? '—' }}</span></div>
                        <div class="drow"><span class="dlabel">Account Holder</span><span class="dval">{{ $return->account_name ?? '—' }}</span></div>
                        <div class="drow"><span class="dlabel">Account No.</span><span class="dval" style="font-family:monospace">{{ $return->account_number ?? '—' }}</span></div>
                        <div class="drow"><span class="dlabel">IFSC</span><span class="dval">{{ $return->ifsc_code ?? '—' }}</span></div>
                        @if($return->bank_branch)
                        <div class="drow"><span class="dlabel">Branch</span><span class="dval">{{ $return->bank_branch }}</span></div>
                        @endif
                        @if($return->account_type)
                        <div class="drow"><span class="dlabel">Account Type</span><span class="dval">{{ ucfirst($return->account_type) }}</span></div>
                        @endif
                    @elseif($return->refund_method === 'qr')
                        <div style="margin-top:8px">
                            <div style="font-size:12px;color:var(--text-hint);margin-bottom:6px">Customer-provided QR code</div>
                            @if($return->qr_image)
                            <a href="{{ asset('storage/'.$return->qr_image) }}" target="_blank">
                                <img src="{{ asset('storage/'.$return->qr_image) }}" class="proof-preview" alt="Customer-provided QR code">
                            </a>
                            @else
                            <span class="dval">—</span>
                            @endif
                        </div>
                    @endif
                </div>

                {{--
                    Refund Information (Processed) — the ADMIN's actual transaction
                    details, now read from refund_transactions instead of order_returns,
                    so they no longer collide with the card above.
                --}}
                @if($return->status === 'completed' && $return->refundTransaction)
                <div class="dcard">
                    <h3>Refund Information (Processed)</h3>
                    <div class="drow"><span class="dlabel">Method</span><span class="dval">{{ strtoupper($return->refundTransaction->refund_method) }}</span></div>
                    @if($return->refundTransaction->utr_id)
                    <div class="drow"><span class="dlabel">UTR / Reference</span><span class="dval" style="font-family:monospace">{{ $return->refundTransaction->utr_id }}</span></div>
                    @endif
                    @if($return->refundTransaction->refund_method === 'upi')
                    <div class="drow"><span class="dlabel">UPI ID</span><span class="dval">{{ $return->refundTransaction->upi_id ?? '—' }}</span></div>
                    @else
                    <div class="drow"><span class="dlabel">Bank</span><span class="dval">{{ $return->refundTransaction->bank_name ?? '—' }}</span></div>
                    <div class="drow"><span class="dlabel">Account Holder</span><span class="dval">{{ $return->refundTransaction->account_name ?? '—' }}</span></div>
                    <div class="drow"><span class="dlabel">Account No.</span><span class="dval" style="font-family:monospace">{{ $return->refundTransaction->account_number ?? '—' }}</span></div>
                    <div class="drow"><span class="dlabel">IFSC</span><span class="dval">{{ $return->refundTransaction->ifsc_code ?? '—' }}</span></div>
                    @endif
                    @if($return->refundTransaction->remarks)
                    <div class="drow"><span class="dlabel">Remarks</span><span class="dval">{{ $return->refundTransaction->remarks }}</span></div>
                    @endif
                    <div class="drow"><span class="dlabel">Refunded On</span><span class="dval">{{ $return->refundTransaction->created_at->format('d M Y, h:i A') }}</span></div>
                    @if($return->refundTransaction->payment_proof)
                    <div style="margin-top:10px">
                        <div style="font-size:12px;font-weight:600;color:var(--text-hint);text-transform:uppercase;letter-spacing:.04em;margin-bottom:6px">Payment Proof</div>
                        <a href="{{ asset('storage/'.$return->refundTransaction->payment_proof) }}" target="_blank">
                            <img src="{{ asset('storage/'.$return->refundTransaction->payment_proof) }}" class="proof-preview" alt="Payment proof">
                        </a>
                    </div>
                    @endif
                </div>
                @endif
            </div>

            <div class="detail-grid">
                {{-- Timeline --}}
                <div class="dcard" style="grid-column:1/-1">
                    <h3>Timeline</h3>
                    <ul class="timeline">
                        <li class="tl-item">
                            <div class="tl-dot tl-dot-gray"></div>
                            <div>
                                <div class="tl-label">Return requested</div>
                                <div class="tl-time">{{ $return->created_at->format('d M Y, h:i A') }}</div>
                            </div>
                        </li>
                        @if(in_array($return->status, ['approved','rejected','completed']))
                        <li class="tl-item">
                            <div class="tl-dot {{ $return->status === 'rejected' ? 'tl-dot-red' : 'tl-dot-default' }}"></div>
                            <div>
                                <div class="tl-label">{{ $return->status === 'rejected' ? 'Rejected by admin' : 'Approved by admin' }}</div>
                                @if($return->admin_note)
                                <div class="tl-time">{{ $return->admin_note }}</div>
                                @endif
                                <div class="tl-time">{{ $return->updated_at->format('d M Y, h:i A') }}</div>
                            </div>
                        </li>
                        @endif
                        @if($return->status === 'completed' && $return->refundTransaction)
                        <li class="tl-item">
                            <div class="tl-dot tl-dot-green"></div>
                            <div>
                                <div class="tl-label">Refund processed via {{ strtoupper($return->refundTransaction->refund_method) }}</div>
                                <div class="tl-time">UTR: {{ $return->refundTransaction->utr_id }}</div>
                                <div class="tl-time">{{ $return->refundTransaction->created_at->format('d M Y, h:i A') }}</div>
                            </div>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>

        </div>
    </div>

    {{-- ===== Modals (same as index) ===== --}}
    @include('admin.order-returns._modals')

</div>

@include('admin.footer')