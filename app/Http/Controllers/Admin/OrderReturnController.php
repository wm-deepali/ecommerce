<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderReturn;
use App\Models\RefundTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OrderReturnController extends Controller
{
    /**
     * List all returns with filters + stats.
     */
    public function index(Request $request)
    {
        $query = OrderReturn::with(['order', 'orderItem.product', 'orderItem.addons', 'customer', 'returnReason'])
            ->latest();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('id', 'like', "%{$s}%")
                    ->orWhereHas('order', fn($o) => $o->where('id', 'like', "%{$s}%"))
                    ->orWhereHas('customer', fn($c) => $c->where('name', 'like', "%{$s}%")
                        ->orWhere('email', 'like', "%{$s}%"));
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $returns = $query->paginate(25);

        $stats = [
            'total' => OrderReturn::count(),
            'pending' => OrderReturn::where('status', 'pending')->count(),
            'approved' => OrderReturn::where('status', 'approved')->count(),
            'refunded_amount' => RefundTransaction::where('status', 'completed')->sum('amount'),
        ];

        return view('admin.order-returns.index', compact('returns', 'stats'));
    }

    /**
     * Show a single return in detail.
     */
    public function show(OrderReturn $orderReturn)
    {
        $orderReturn->load(['order', 'orderItem.product', 'orderItem.addons', 'customer', 'returnReason', 'refundTransaction']);

        return view('admin.order-returns.show', ['return' => $orderReturn]);
    }

    /**
     * Approve a pending return.
     */
    public function approve(Request $request, OrderReturn $orderReturn)
    {
        abort_if($orderReturn->status !== 'pending', 422, 'Return is not in pending state.');

        $request->validate([
            'admin_note' => 'nullable|string|max:1000',
        ]);

        $orderReturn->update([
            'status' => 'approved',
            'admin_note' => $request->admin_note,
        ]);

        \App\Models\Notification::create([
            'customer_id' => $orderReturn->customer_id,
            'title' => 'Return Request Approved',
            'message' => 'Your return request for Order #' . $orderReturn->order->order_number . ' has been approved.',
            'icon' => 'fa-solid fa-check-circle',
            'color' => 'success',
            'url' => route('user.orders.show', $orderReturn->order_id),
        ]);

        \App\Models\AdminNotification::notify([
            'type'      => 'return',
            'title'     => 'Return approved',
            'message'   => 'Return RET-' . str_pad($orderReturn->id, 4, '0', STR_PAD_LEFT) . ' approved for order #' . $orderReturn->order->order_number . '.',
            'reference' => '#RET-' . str_pad($orderReturn->id, 4, '0', STR_PAD_LEFT),
            'icon'      => 'fa-undo',
            'url'       => route('admin.order-returns.show', $orderReturn->id),
            'link_text' => 'View Return',
        ]);

        return redirect()
            ->back()
            ->with('success', 'Return RET-' . str_pad($orderReturn->id, 4, '0', STR_PAD_LEFT) . ' has been approved.');
    }

    /**
     * Reject a pending return.
     */
    public function reject(Request $request, OrderReturn $orderReturn)
    {
        abort_if($orderReturn->status !== 'pending', 422, 'Return is not in pending state.');

        $request->validate([
            'reject_reason' => 'nullable|string|max:255',
            'admin_note' => 'nullable|string|max:1000',
        ]);

        $note = trim(implode(' — ', array_filter([
            $request->reject_reason,
            $request->admin_note,
        ])));

        $orderReturn->update([
            'status' => 'rejected',
            'admin_note' => $note ?: null,
        ]);

        \App\Models\Notification::create([
            'customer_id' => $orderReturn->customer_id,
            'title' => 'Return Request Rejected',
            'message' => 'Your return request for Order #' . $orderReturn->order->order_number . ' has been rejected.',
            'icon' => 'fa-solid fa-times-circle',
            'color' => 'danger',
            'url' => route('user.orders.show', $orderReturn->order_id),
        ]);

        return redirect()
            ->back()
            ->with('success', 'Return RET-' . str_pad($orderReturn->id, 4, '0', STR_PAD_LEFT) . ' has been rejected.');
    }

    /**
     * Process refund for an approved return.
     *
     * IMPORTANT: this no longer writes refund_method / upi_id / bank_* back onto
     * the OrderReturn row. Those columns hold what the CUSTOMER originally
     * requested in submitReturn() and must stay untouched as an audit trail.
     * The admin's actual transaction details (which may legitimately differ
     * from the customer's request) are recorded only on RefundTransaction.
     *
     * Refund amount is computed via OrderReturn::refundable_amount, which
     * includes the item's line total, its addons, and a proportional share
     * of the order's tax — not just orderItem->price.
     */
    public function refund(Request $request, OrderReturn $orderReturn)
    {
        abort_if($orderReturn->status !== 'approved', 422, 'Return must be approved before processing refund.');

        $request->validate([
            'refund_method' => 'required|in:neft_rtgs_imps,upi',
            'utr_id' => 'required|string|max:100',
            'remarks' => 'nullable|string|max:500',
            'payment_proof' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',

            // Bank fields
            'bank_name' => 'required_if:refund_method,neft_rtgs_imps|nullable|string|max:100',
            'account_name' => 'required_if:refund_method,neft_rtgs_imps|nullable|string|max:100',
            'account_number' => 'required_if:refund_method,neft_rtgs_imps|nullable|string|max:30',
            'ifsc_code' => 'required_if:refund_method,neft_rtgs_imps|nullable|string|max:20',
            'bank_branch' => 'nullable|string|max:100',
            'account_type' => 'nullable|in:savings,current,salary',

            // UPI
            'upi_id' => 'required_if:refund_method,upi|nullable|string|max:100',
        ]);

        $proofPath = null;
        if ($request->hasFile('payment_proof')) {
            $proofPath = $request->file('payment_proof')
                ->store('order-returns/proofs', 'public');
        }

        DB::transaction(function () use ($request, $orderReturn, $proofPath) {
            // Only the status changes on the return itself. refund_method,
            // upi_id, bank_name, etc. on $orderReturn remain exactly as the
            // customer submitted them — they are not touched here.
            $orderReturn->update([
                'status' => 'completed',
            ]);

            $isUpi = $request->refund_method === 'upi';

            // The admin's actual transaction details live on RefundTransaction,
            // independently of the customer's originally requested details.
            $refund = RefundTransaction::create([
                'order_return_id' => $orderReturn->id,
                'order_id' => $orderReturn->order_id,
                'customer_id' => $orderReturn->customer_id,
                'status' => 'completed',
                'refund_method' => $request->refund_method,
                'utr_id' => $request->utr_id,
                'amount' => $orderReturn->refundable_amount,
                'remarks' => $request->remarks,
                'payment_proof' => $proofPath,

                'upi_id' => $isUpi ? $request->upi_id : null,
                'bank_name' => $isUpi ? null : $request->bank_name,
                'account_name' => $isUpi ? null : $request->account_name,
                'account_number' => $isUpi ? null : $request->account_number,
                'ifsc_code' => $isUpi ? null : $request->ifsc_code,
                'bank_branch' => $isUpi ? null : $request->bank_branch,
                'account_type' => $isUpi ? null : $request->account_type,
            ]);

            \App\Models\Notification::create([
                'customer_id' => $orderReturn->customer_id,
                'title' => 'Refund Completed',
                'message' => 'Your refund of ₹' .
                    number_format($refund->amount, 2) .
                    ' has been processed successfully. UTR: ' .
                    $refund->utr_id,
                'icon' => 'fa-solid fa-money-bill-transfer',
                'color' => 'success',
                'url' => route('user.orders.show', $orderReturn->order_id),
            ]);

            \App\Models\AdminNotification::notify([
                'type'      => 'return',
                'title'     => 'Refund processed',
                'message'   => 'Refund of ₹' . number_format($refund->amount, 2) . ' for return RET-' . str_pad($orderReturn->id, 4, '0', STR_PAD_LEFT) . ' has been successfully credited to the customer\'s account.',
                'reference' => '#RET-' . str_pad($orderReturn->id, 4, '0', STR_PAD_LEFT),
                'icon'      => 'fa-undo',
                'url'       => route('admin.order-returns.show', $orderReturn->id),
                'link_text' => 'View Return',
            ]);
        });

        return redirect()
            ->route('admin.order-returns.show', $orderReturn->id)
            ->with('refund_success', true)
            ->with('refund_utr', $request->utr_id);
    }

    /**
     * Mark a completed refund as failed (bank bounce / wrong UTR / reversed).
     * Reopens the return as 'approved' so the admin can retry via refund().
     */
    public function markRefundFailed(Request $request, OrderReturn $orderReturn)
    {
        abort_if($orderReturn->status !== 'completed', 422, 'Only a completed refund can be marked failed.');
        abort_if(!$orderReturn->refundTransaction, 422, 'No refund transaction found for this return.');

        $request->validate([
            'failure_reason' => 'nullable|string|max:500',
        ]);

        DB::transaction(function () use ($orderReturn, $request) {
            $orderReturn->refundTransaction->update(['status' => 'failed']);

            // Reopen the return so admin can process the refund again.
            $orderReturn->update([
                'status' => 'approved',
                'admin_note' => trim(($orderReturn->admin_note ?? '') . ' | Refund failed: ' . ($request->failure_reason ?? 'not specified')),
            ]);

            \App\Models\Notification::create([
                'customer_id' => $orderReturn->customer_id,
                'title' => 'Refund Failed — Retrying',
                'message' => 'Your refund attempt could not be completed. Our team is retrying it and will update you shortly.',
                'icon' => 'fa-solid fa-triangle-exclamation',
                'color' => 'danger',
                'url' => route('user.orders.show', $orderReturn->order_id),
            ]);

            \App\Models\AdminNotification::notify([
                'type'      => 'return',
                'title'     => 'Refund failed',
                'message'   => 'Refund for return RET-' . str_pad($orderReturn->id, 4, '0', STR_PAD_LEFT) . ' failed and needs retry.',
                'reference' => '#RET-' . str_pad($orderReturn->id, 4, '0', STR_PAD_LEFT),
                'icon'      => 'fa-triangle-exclamation',
                'url'       => route('admin.order-returns.show', $orderReturn->id),
                'link_text' => 'Retry Refund',
            ]);
        });

        return redirect()
            ->route('admin.order-returns.show', $orderReturn->id)
            ->with('success', 'Refund marked as failed. Return is reopened for retry.');
    }

    /**
     * Export returns as CSV.
     */
    public function export(Request $request)
    {
        $returns = OrderReturn::with(['order', 'orderItem.product', 'orderItem.addons', 'customer', 'returnReason', 'refundTransaction'])
            ->latest()
            ->get();

        $filename = 'order-returns-' . now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($returns) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'Return ID',
                'Order ID',
                'Customer',
                'Email',
                'Product',
                'Reason',
                'Amount',
                'Status',
                'UTR ID',
                'Refund Method',
                'Requested On',
            ]);

            foreach ($returns as $r) {
                fputcsv($handle, [
                    'RET-' . str_pad($r->id, 4, '0', STR_PAD_LEFT),
                    '#ORD-' . $r->order_id,
                    $r->customer->name ?? '',
                    $r->customer->email ?? '',
                    $r->orderItem->product->name ?? '',
                    $r->returnReason->name ?? $r->details ?? '',
                    $r->refundable_amount,
                    ucfirst($r->status),
                    $r->refundTransaction->utr_id ?? '',
                    $r->refundTransaction->refund_method ?? '',
                    $r->created_at->format('d M Y'),
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}