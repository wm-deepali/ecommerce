{{--
    Partial: admin/order-returns/_modals.blade.php
    Include in index.blade.php and show.blade.php
--}}

{{-- ===== APPROVE MODAL ===== --}}
<div class="modal fade" id="approveModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius:12px;border:1px solid #e3e5e8;overflow:hidden">
            <div class="modal-header" style="border-bottom:1px solid #e3e5e8;padding:18px 20px">
                <h5 class="modal-title" style="font-size:15px;font-weight:600;margin:0">Approve Return Request</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
            </div>
            <form method="POST" id="approveForm">
                @csrf @method('PATCH')
                <div class="modal-body" style="padding:20px">
                    <div id="approve-info-box" style="background:#f1f2f4;border:1px solid #e3e5e8;border-radius:8px;padding:12px;margin-bottom:16px;font-size:13px"></div>
                    <div>
                        <label style="display:block;font-size:12px;font-weight:600;color:#6d7175;text-transform:uppercase;letter-spacing:.03em;margin-bottom:5px">
                            Admin Note <span style="font-weight:400;color:#8c9196">(optional)</span>
                        </label>
                        <textarea name="admin_note" rows="3"
                                  style="width:100%;border:1px solid #e3e5e8;border-radius:8px;padding:8px 10px;font-size:13px;font-family:inherit;resize:vertical;outline:none"
                                  placeholder="Add an internal note…"></textarea>
                    </div>
                </div>
                <div class="modal-footer" style="border-top:1px solid #e3e5e8;padding:14px 20px;display:flex;justify-content:flex-end;gap:8px">
                    <button type="button" data-dismiss="modal"
                            style="display:inline-flex;align-items:center;gap:6px;background:#fff;color:#202223;border:1px solid #e3e5e8;border-radius:8px;padding:8px 16px;font-size:13px;font-weight:500;cursor:pointer;font-family:inherit">
                        Cancel
                    </button>
                    <button type="submit"
                            style="display:inline-flex;align-items:center;gap:6px;background:#303d89;color:#fff;border:none;border-radius:8px;padding:8px 16px;font-size:13px;font-weight:600;cursor:pointer;font-family:inherit">
                        <i class="fa fa-check"></i> Approve Return
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ===== REJECT MODAL ===== --}}
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius:12px;border:1px solid #e3e5e8;overflow:hidden">
            <div class="modal-header" style="border-bottom:1px solid #e3e5e8;padding:18px 20px">
                <h5 class="modal-title" style="font-size:15px;font-weight:600;margin:0">Reject Return Request</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
            </div>
            <form method="POST" id="rejectForm">
                @csrf @method('PATCH')
                <div class="modal-body" style="padding:20px">
                    <div id="reject-info-box" style="background:#f1f2f4;border:1px solid #e3e5e8;border-radius:8px;padding:12px;margin-bottom:16px;font-size:13px"></div>
                    <div style="margin-bottom:14px">
                        <label style="display:block;font-size:12px;font-weight:600;color:#6d7175;text-transform:uppercase;letter-spacing:.03em;margin-bottom:5px">
                            Reason for Rejection
                        </label>
                        <select name="reject_reason"
                                style="width:100%;height:36px;border:1px solid #e3e5e8;border-radius:8px;padding:0 10px;font-size:13px;font-family:inherit;outline:none">
                            <option value="">Select reason…</option>
                            <option value="used_damaged">Item is used / damaged by customer</option>
                            <option value="window_expired">Return window expired</option>
                            <option value="non_returnable">Non-returnable item</option>
                            <option value="insufficient_proof">Insufficient proof provided</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div>
                        <label style="display:block;font-size:12px;font-weight:600;color:#6d7175;text-transform:uppercase;letter-spacing:.03em;margin-bottom:5px">
                            Admin Note
                        </label>
                        <textarea name="admin_note" rows="3"
                                  style="width:100%;border:1px solid #e3e5e8;border-radius:8px;padding:8px 10px;font-size:13px;font-family:inherit;resize:vertical;outline:none"
                                  placeholder="Explain rejection to customer…"></textarea>
                    </div>
                </div>
                <div class="modal-footer" style="border-top:1px solid #e3e5e8;padding:14px 20px;display:flex;justify-content:flex-end;gap:8px">
                    <button type="button" data-dismiss="modal"
                            style="display:inline-flex;align-items:center;gap:6px;background:#fff;color:#202223;border:1px solid #e3e5e8;border-radius:8px;padding:8px 16px;font-size:13px;font-weight:500;cursor:pointer;font-family:inherit">
                        Cancel
                    </button>
                    <button type="submit"
                            style="display:inline-flex;align-items:center;gap:6px;background:#b22222;color:#fff;border:none;border-radius:8px;padding:8px 16px;font-size:13px;font-weight:600;cursor:pointer;font-family:inherit">
                        <i class="fa fa-times"></i> Reject Return
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ===== REFUND MODAL ===== --}}
<div class="modal fade" id="refundModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content" style="border-radius:12px;border:1px solid #e3e5e8;overflow:hidden">
            <div class="modal-header" style="border-bottom:1px solid #e3e5e8;padding:18px 20px">
                <h5 class="modal-title" style="font-size:15px;font-weight:600;margin:0">Process Refund</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
            </div>
            <form method="POST" id="refundForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body" style="padding:20px">

                    {{-- Return summary + what the customer originally requested --}}
                    <div id="refund-info-box" style="background:#f1f2f4;border:1px solid #e3e5e8;border-radius:8px;padding:12px;margin-bottom:18px;font-size:13px"></div>

                    {{-- Payment Method Tabs --}}
                    <div style="margin-bottom:16px">
                        <label style="display:block;font-size:12px;font-weight:600;color:#6d7175;text-transform:uppercase;letter-spacing:.03em;margin-bottom:8px">
                            Payment Method <span style="color:#b22222">*</span>
                        </label>
                        <div style="display:flex;gap:8px">
                            <label id="tab-neft_rtgs_imps"
                                   style="flex:1;border:1px solid #e3e5e8;border-radius:8px;padding:10px 12px;text-align:center;cursor:pointer;font-size:13px;font-weight:500;color:#202223;background:#fff;transition:all .15s">
                                <input type="radio" name="refund_method" value="neft_rtgs_imps"
                                       style="display:none" onchange="toggleRefundMethod('neft_rtgs_imps')" required>
                                NEFT / RTGS / IMPS
                            </label>
                            <label id="tab-upi"
                                   style="flex:1;border:1px solid #e3e5e8;border-radius:8px;padding:10px 12px;text-align:center;cursor:pointer;font-size:13px;font-weight:500;color:#202223;background:#fff;transition:all .15s">
                                <input type="radio" name="refund_method" value="upi"
                                       style="display:none" onchange="toggleRefundMethod('upi')">
                                UPI
                            </label>
                        </div>
                    </div>

                    {{-- Bank Fields --}}
                    <div id="method-neft_rtgs_imps" style="display:none;margin-bottom:4px">
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
                            <div style="margin-bottom:12px">
                                <label style="display:block;font-size:12px;font-weight:600;color:#6d7175;text-transform:uppercase;letter-spacing:.03em;margin-bottom:5px">Bank Name</label>
                                <input type="text" name="bank_name" placeholder="e.g. HDFC Bank"
                                       style="width:100%;height:36px;border:1px solid #e3e5e8;border-radius:8px;padding:0 10px;font-size:13px;font-family:inherit;outline:none">
                            </div>
                            <div style="margin-bottom:12px">
                                <label style="display:block;font-size:12px;font-weight:600;color:#6d7175;text-transform:uppercase;letter-spacing:.03em;margin-bottom:5px">Account Holder Name</label>
                                <input type="text" name="account_name" placeholder="Name on account"
                                       style="width:100%;height:36px;border:1px solid #e3e5e8;border-radius:8px;padding:0 10px;font-size:13px;font-family:inherit;outline:none">
                            </div>
                            <div style="margin-bottom:12px">
                                <label style="display:block;font-size:12px;font-weight:600;color:#6d7175;text-transform:uppercase;letter-spacing:.03em;margin-bottom:5px">Account Number</label>
                                <input type="text" name="account_number" placeholder="Account number"
                                       style="width:100%;height:36px;border:1px solid #e3e5e8;border-radius:8px;padding:0 10px;font-size:13px;font-family:inherit;outline:none">
                            </div>
                            <div style="margin-bottom:12px">
                                <label style="display:block;font-size:12px;font-weight:600;color:#6d7175;text-transform:uppercase;letter-spacing:.03em;margin-bottom:5px">IFSC Code</label>
                                <input type="text" name="ifsc_code" placeholder="HDFC0001234"
                                       style="width:100%;height:36px;border:1px solid #e3e5e8;border-radius:8px;padding:0 10px;font-size:13px;font-family:inherit;outline:none">
                            </div>
                            <div style="margin-bottom:12px">
                                <label style="display:block;font-size:12px;font-weight:600;color:#6d7175;text-transform:uppercase;letter-spacing:.03em;margin-bottom:5px">Bank Branch</label>
                                <input type="text" name="bank_branch" placeholder="Branch name"
                                       style="width:100%;height:36px;border:1px solid #e3e5e8;border-radius:8px;padding:0 10px;font-size:13px;font-family:inherit;outline:none">
                            </div>
                            <div style="margin-bottom:12px">
                                <label style="display:block;font-size:12px;font-weight:600;color:#6d7175;text-transform:uppercase;letter-spacing:.03em;margin-bottom:5px">Account Type</label>
                                <select name="account_type"
                                        style="width:100%;height:36px;border:1px solid #e3e5e8;border-radius:8px;padding:0 10px;font-size:13px;font-family:inherit;outline:none">
                                    <option value="">Select…</option>
                                    <option value="savings">Savings</option>
                                    <option value="current">Current</option>
                                    <option value="salary">Salary</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- UPI Field --}}
                    <div id="method-upi" style="display:none;margin-bottom:16px">
                        <label style="display:block;font-size:12px;font-weight:600;color:#6d7175;text-transform:uppercase;letter-spacing:.03em;margin-bottom:5px">UPI ID</label>
                        <input type="text" name="upi_id" placeholder="name@upi"
                               style="width:100%;height:36px;border:1px solid #e3e5e8;border-radius:8px;padding:0 10px;font-size:13px;font-family:inherit;outline:none">
                    </div>

                    {{-- UTR ID --}}
                    <div style="margin-bottom:14px">
                        <label style="display:block;font-size:12px;font-weight:600;color:#6d7175;text-transform:uppercase;letter-spacing:.03em;margin-bottom:5px">
                            Reference / UTR ID <span style="color:#b22222">*</span>
                        </label>
                        <input type="text" name="utr_id" required placeholder="Transaction reference number"
                               style="width:100%;height:36px;border:1px solid #e3e5e8;border-radius:8px;padding:0 10px;font-size:13px;font-family:inherit;outline:none">
                        <p style="font-size:11px;color:#8c9196;margin-top:3px;margin-bottom:0">Enter the UTR or reference number from your bank</p>
                    </div>

                    {{-- Remarks --}}
                    <div style="margin-bottom:14px">
                        <label style="display:block;font-size:12px;font-weight:600;color:#6d7175;text-transform:uppercase;letter-spacing:.03em;margin-bottom:5px">Remarks</label>
                        <textarea name="remarks" rows="2"
                                  style="width:100%;border:1px solid #e3e5e8;border-radius:8px;padding:8px 10px;font-size:13px;font-family:inherit;resize:vertical;outline:none"
                                  placeholder="Optional note for this refund…"></textarea>
                    </div>

                    {{-- Upload Proof --}}
                    <div>
                        <label style="display:block;font-size:12px;font-weight:600;color:#6d7175;text-transform:uppercase;letter-spacing:.03em;margin-bottom:5px">Upload Payment Proof</label>
                        <label for="proof_upload" id="upload-area"
                               style="display:block;border:2px dashed #e3e5e8;border-radius:8px;padding:24px;text-align:center;cursor:pointer;transition:all .15s">
                            <i class="fa fa-cloud-upload" style="font-size:26px;color:#8c9196;display:block;margin-bottom:8px"></i>
                            <p style="font-size:13px;color:#6d7175;margin:0">Click to upload screenshot or receipt</p>
                            <p style="font-size:11px;color:#8c9196;margin-top:4px;margin-bottom:0">PNG, JPG, PDF — max 5MB</p>
                            <input type="file" name="payment_proof" id="proof_upload"
                                   accept="image/*,application/pdf" style="display:none"
                                   onchange="previewUploadedFile(this)">
                        </label>
                        <div id="file-preview" style="display:none;align-items:center;gap:8px;background:#f1f2f4;border-radius:8px;padding:8px 12px;margin-top:8px;font-size:12.5px;color:#6d7175">
                            <i class="fa fa-file-image-o"></i>
                            <span id="file-name-display"></span>
                            <span style="margin-left:auto;cursor:pointer;color:#b22222" onclick="clearUpload()"><i class="fa fa-times"></i></span>
                        </div>
                    </div>

                </div>
                <div class="modal-footer" style="border-top:1px solid #e3e5e8;padding:14px 20px;display:flex;justify-content:flex-end;gap:8px">
                    <button type="button" data-dismiss="modal"
                            style="display:inline-flex;align-items:center;gap:6px;background:#fff;color:#202223;border:1px solid #e3e5e8;border-radius:8px;padding:8px 16px;font-size:13px;font-weight:500;cursor:pointer;font-family:inherit">
                        Cancel
                    </button>
                    <button type="submit"
                            style="display:inline-flex;align-items:center;gap:6px;background:#303d89;color:#fff;border:none;border-radius:8px;padding:8px 16px;font-size:13px;font-weight:600;cursor:pointer;font-family:inherit">
                        <i class="fa fa-paper-plane"></i> Submit Refund
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function _infoRow(label, value) {
    return `<div style="display:flex;justify-content:space-between;padding:5px 0;border-bottom:1px solid #e3e5e8;font-size:13px">
        <span style="color:#8c9196">${label}</span>
        <span style="font-weight:600;color:#202223">${value}</span>
    </div>`;
}

function openApproveModal(id, customer, product) {
    document.getElementById('approve-info-box').innerHTML =
        _infoRow('Customer', customer) + _infoRow('Product', product);
    document.getElementById('approveForm').action = `/admin/order-returns/${id}/approve`;
    $('#approveModal').modal('show');
}

function openRejectModal(id, customer, product) {
    document.getElementById('reject-info-box').innerHTML =
        _infoRow('Customer', customer) + _infoRow('Product', product);
    document.getElementById('rejectForm').action = `/admin/order-returns/${id}/reject`;
    $('#rejectModal').modal('show');
}

/**
 * requested = {
 *   method: 'upi' | 'bank' | 'qr',
 *   upi_id, bank_name, account_name, account_number, ifsc_code,
 *   bank_branch, account_type, qr_image_url
 * }
 * — this is what the CUSTOMER asked for in their return request. It is shown
 * here for reference only; it is never assumed to be what the admin actually
 * sent, since the admin may correct a typo or use a different method.
 */
function openRefundModal(id, customer, product, amount, requested) {
    const fmt = parseInt(amount).toLocaleString('en-IN');

    let html = _infoRow('Customer', customer) +
        _infoRow('Product', product) +
        _infoRow('Refund Amount', '₹' + fmt);

    if (requested && requested.method) {
        html += `<div style="margin-top:10px;padding-top:10px;border-top:1px dashed #e3e5e8">
            <div style="font-size:11px;font-weight:600;color:#8c9196;text-transform:uppercase;letter-spacing:.04em;margin-bottom:6px">
                Customer requested
            </div>`;

        if (requested.method === 'upi') {
            html += _infoRow('UPI ID', requested.upi_id || '—');
        } else if (requested.method === 'bank') {
            html += _infoRow('Bank', requested.bank_name || '—');
            html += _infoRow('Account No.', requested.account_number || '—');
            html += _infoRow('IFSC', requested.ifsc_code || '—');
        } else if (requested.method === 'qr' && requested.qr_image_url) {
            html += `<div style="font-size:13px;color:#202223;margin-top:4px">
                Customer uploaded a QR code —
                <a href="${requested.qr_image_url}" target="_blank" style="color:#303d89">view it</a>
            </div>`;
        }

        if (requested.method === 'upi' || requested.method === 'bank') {
            html += `<button type="button" onclick='_applyRequestedToRefundForm(${JSON.stringify(requested)})'
                style="margin-top:8px;font-size:12px;color:#303d89;background:none;border:none;cursor:pointer;padding:0;text-decoration:underline">
                Copy these details into the form below
            </button>`;
        }

        html += `</div>`;
    }

    document.getElementById('refund-info-box').innerHTML = html;
    document.getElementById('refundForm').action = `/admin/order-returns/${id}/refund`;

    // Clear out any values left over from a previously opened return.
    document.getElementById('refundForm').reset();
    document.getElementById('file-preview').style.display = 'none';

    // Reset method tab styling (form.reset() unchecks radios but doesn't touch our custom styles)
    ['neft_rtgs_imps', 'upi'].forEach(m => {
        document.getElementById('method-' + m).style.display = 'none';
        const lbl = document.getElementById('tab-' + m);
        lbl.style.borderColor = '#e3e5e8';
        lbl.style.color = '#202223';
        lbl.style.background = '#fff';
    });
    document.getElementById('upload-area').style.borderColor = '#e3e5e8';

    $('#refundModal').modal('show');
}

function toggleRefundMethod(selected) {
    ['neft_rtgs_imps','upi'].forEach(function(m) {
        document.getElementById('method-' + m).style.display = m === selected ? 'block' : 'none';
        var lbl = document.getElementById('tab-' + m);
        if (m === selected) {
            lbl.style.borderColor = '#303d89';
            lbl.style.color = '#303d89';
            lbl.style.background = '#f0f1fc';
        } else {
            lbl.style.borderColor = '#e3e5e8';
            lbl.style.color = '#202223';
            lbl.style.background = '#fff';
        }
    });
}

/**
 * One-click helper: copies the customer's originally-requested UPI/bank
 * details into the actual refund form fields. The admin can still edit
 * them before submitting — this just saves re-typing when the admin is
 * in fact sending the refund the way the customer asked.
 */
function _applyRequestedToRefundForm(requested) {
    if (requested.method === 'upi') {
        document.querySelector('#refundModal input[name=refund_method][value=upi]').checked = true;
        toggleRefundMethod('upi');
        document.querySelector('#refundModal input[name=upi_id]').value = requested.upi_id || '';
    } else if (requested.method === 'bank') {
        document.querySelector('#refundModal input[name=refund_method][value=neft_rtgs_imps]').checked = true;
        toggleRefundMethod('neft_rtgs_imps');
        document.querySelector('#refundModal input[name=bank_name]').value = requested.bank_name || '';
        document.querySelector('#refundModal input[name=account_name]').value = requested.account_name || '';
        document.querySelector('#refundModal input[name=account_number]').value = requested.account_number || '';
        document.querySelector('#refundModal input[name=ifsc_code]').value = requested.ifsc_code || '';
        document.querySelector('#refundModal input[name=bank_branch]').value = requested.bank_branch || '';
        if (requested.account_type) {
            document.querySelector('#refundModal select[name=account_type]').value = requested.account_type;
        }
    }
}

function previewUploadedFile(input) {
    if (input.files && input.files[0]) {
        document.getElementById('file-preview').style.display = 'flex';
        document.getElementById('file-name-display').textContent = input.files[0].name;
        document.getElementById('upload-area').style.borderColor = '#303d89';
    }
}

function clearUpload() {
    document.getElementById('proof_upload').value = '';
    document.getElementById('file-preview').style.display = 'none';
    document.getElementById('upload-area').style.borderColor = '#e3e5e8';
}
</script>