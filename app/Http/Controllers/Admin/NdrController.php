<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ndr;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\RefundTransaction;

class NdrController extends Controller
{
    public function __construct(protected \App\Services\StockService $stockService)
    {
    }

    /**
     * List all NDR cases with filters + stats.
     */
    public function index(Request $request)
    {
        $query = Ndr::with(['order'])->latest();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->whereHas('order', fn($o) => $o->where('order_number', 'like', "%{$s}%")
                ->orWhere('customer_name', 'like', "%{$s}%")
                ->orWhere('customer_phone', 'like', "%{$s}%"));
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

        $ndrs = $query->paginate(25)->withQueryString();

        $stats = [
            'pending' => Ndr::where('status', 'pending')->count(),
            'reattempt' => Ndr::where('status', 'reattempt')->count(),
            'rto' => Ndr::where('status', 'rto')->count(),
            'resolved' => Ndr::where('status', 'delivered')
                ->whereMonth('resolved_at', now()->month)
                ->whereYear('resolved_at', now()->year)
                ->count(),
        ];

        return view('admin.ndr.index', compact('ndrs', 'stats'));
    }

    public function show(Ndr $ndr)
    {
        $ndr->load(['order.items.product', 'order.customer']);

        return view('admin.ndr.show', ['ndr' => $ndr]);
    }

    /**
     * Raise a new NDR against an order (called from order detail/list).
     */
    public function markNdr(Request $request, Order $order)
    {
        $request->validate([
            'reason' => 'required|in:customer_unavailable,wrong_address,refused_cod,address_unserviceable,requested_reschedule,other',
            'remarks' => 'nullable|string|max:1000',
            'next_attempt_date' => 'nullable|date|after_or_equal:today',
        ]);

        abort_if(in_array($order->status, ['delivered', 'cancelled', 'rto']), 422, 'Order is already in a final state.');

        $ndr = Ndr::create([
            'order_id' => $order->id,
            'reason' => $request->reason,
            'remarks' => $request->remarks,
            'status' => 'pending',
            'attempt_count' => 1,
            'next_attempt_date' => $request->next_attempt_date,
            'marked_by' => Auth::user()->name ?? 'Admin',
        ]);

        $previousStatus = $order->status; // capture BEFORE update() — Eloquent syncs originals on save()
        $order->update(['status' => 'ndr']);

        $order->statusHistory()->create([
            'status' => 'ndr',
            'previous_status' => $previousStatus,
            'remarks' => 'NDR raised: ' . $ndr->reason_label . ($request->remarks ? " — {$request->remarks}" : ''),
            'triggered_by' => 'Admin',
        ]);

        \App\Models\Notification::create([
            'customer_id' => $order->customer_id,
            'title' => 'Delivery Attempt Failed',
            'message' => "We couldn't deliver order {$order->order_number}. Reason: {$ndr->reason_label}. We'll retry soon.",
            'icon' => 'fa-solid fa-truck-ramp-box',
            'color' => 'danger',
            'url' => route('user.orders.show', $order->id),
        ]);

        \App\Models\AdminNotification::notify([
            'type' => 'order',
            'title' => 'NDR raised',
            'message' => "Delivery failed for order #{$order->order_number}. Reason: {$ndr->reason_label}.",
            'reference' => '#' . $order->order_number,
            'icon' => 'fa-truck-ramp-box',
            'url' => route('admin.ndr.show', $ndr->id),
            'link_text' => 'View NDR',
        ]);

        return redirect()
            ->route('admin.ndr.show', $ndr->id)
            ->with('success', 'NDR raised for order #' . $order->order_number . '.');
    }

    /**
     * Schedule a redelivery attempt.
     */
    public function reattempt(Request $request, Ndr $ndr)
    {
        abort_if(!in_array($ndr->status, ['pending', 'reattempt']), 422, 'This NDR cannot be reattempted from its current state.');

        $request->validate([
            'next_attempt_date' => 'required|date|after_or_equal:today',
            'remarks' => 'nullable|string|max:500',
        ]);

        $ndr->update([
            'status' => 'reattempt',
            'attempt_count' => $ndr->attempt_count + 1,
            'next_attempt_date' => $request->next_attempt_date,
            'remarks' => trim(($ndr->remarks ?? '') . ' | Reattempt scheduled: ' . ($request->remarks ?? 'no note')),
        ]);

        $ndr->order->update(['status' => 'processing']);

        $ndr->order->statusHistory()->create([
            'status' => 'processing',
            'previous_status' => 'ndr',
            'remarks' => 'Redelivery attempt #' . $ndr->attempt_count . ' scheduled for ' . $request->next_attempt_date,
            'triggered_by' => 'Admin',
        ]);

        \App\Models\Notification::create([
            'customer_id' => $ndr->order->customer_id,
            'title' => 'Redelivery Scheduled',
            'message' => "We'll attempt to deliver order {$ndr->order->order_number} again on " . \Carbon\Carbon::parse($request->next_attempt_date)->format('d M Y') . '.',
            'icon' => 'fa-solid fa-truck',
            'color' => 'success',
            'url' => route('user.orders.show', $ndr->order_id),
        ]);

        return redirect()
            ->route('admin.ndr.show', $ndr->id)
            ->with('success', 'Redelivery attempt scheduled.');
    }

    /**
     * Mark eventually delivered after NDR.
     */
    public function markDelivered(Ndr $ndr)
    {
        abort_if(in_array($ndr->status, ['delivered', 'rto', 'cancelled']), 422, 'This NDR is already resolved.');

        $ndr->update([
            'status' => 'delivered',
            'resolved_at' => now(),
        ]);

        $ndr->order->update(['status' => 'delivered']);

        $ndr->order->statusHistory()->create([
            'status' => 'delivered',
            'previous_status' => 'processing',
            'remarks' => 'Delivered after NDR resolution.',
            'triggered_by' => 'Admin',
        ]);

        \App\Models\Notification::create([
            'customer_id' => $ndr->order->customer_id,
            'title' => 'Order Delivered',
            'message' => "Your order {$ndr->order->order_number} has been delivered.",
            'icon' => 'fa-solid fa-box-open',
            'color' => 'success',
            'url' => route('user.orders.show', $ndr->order_id),
        ]);

        return redirect()
            ->route('admin.ndr.show', $ndr->id)
            ->with('success', 'Order marked as delivered.');
    }

    /**
     * Mark RTO (Return to Origin) — order returns to warehouse, stock is
     * credited back via StockService for every item on the order. If the
     * order was prepaid, a refund is recorded via RefundTransaction in the
     * same transaction — COD orders skip the refund step entirely since
     * nothing was collected.
     */
    public function markRto(Request $request, Ndr $ndr)
    {
        abort_if(in_array($ndr->status, ['delivered', 'rto', 'cancelled']), 422, 'This NDR is already resolved.');

        $order = $ndr->order;
        $requiresRefund = $order->payment_status === 'paid';

        $rules = ['remarks' => 'nullable|string|max:500'];

        if ($requiresRefund) {
            $rules = array_merge($rules, [
                'refund_method' => 'required|in:neft_rtgs_imps,upi',
                'utr_id' => 'required|string|max:100',
                'payment_proof' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
                'bank_name' => 'required_if:refund_method,neft_rtgs_imps|nullable|string|max:100',
                'account_name' => 'required_if:refund_method,neft_rtgs_imps|nullable|string|max:100',
                'account_number' => 'required_if:refund_method,neft_rtgs_imps|nullable|string|max:30',
                'ifsc_code' => 'required_if:refund_method,neft_rtgs_imps|nullable|string|max:20',
                'bank_branch' => 'nullable|string|max:100',
                'account_type' => 'nullable|in:savings,current,salary',
                'upi_id' => 'required_if:refund_method,upi|nullable|string|max:100',
            ]);
        }

        $request->validate($rules);

        $proofPath = null;
        if ($requiresRefund && $request->hasFile('payment_proof')) {
            $proofPath = $request->file('payment_proof')->store('ndr/refund-proofs', 'public');
        }

        DB::transaction(function () use ($ndr, $request, $order, $requiresRefund, $proofPath) {
            $ndr->update([
                'status' => 'rto',
                'resolved_at' => now(),
                'remarks' => trim(($ndr->remarks ?? '') . ' | RTO: ' . ($request->remarks ?? 'no note')),
            ]);

            $order->update(['status' => 'rto']);

            $order->statusHistory()->create([
                'status' => 'rto',
                'previous_status' => 'ndr',
                'remarks' => 'Order returned to origin. Stock credited back.' . ($requiresRefund ? ' Refund initiated.' : ''),
                'triggered_by' => 'Admin',
            ]);

            $order->loadMissing(['items.product', 'items.stockVariant']);

            foreach ($order->items as $item) {
                $product = $item->product;

                if (!$product) {
                    continue;
                }

                try {
                    $this->stockService->credit(
                        $product,
                        $item->quantity,
                        'rto',
                        $order,
                        Auth::user()->id(),
                        'Stock reversed — RTO for order ' . $order->order_number,
                        $item->stockVariant
                    );
                } catch (\Exception $e) {
                    \Log::warning("Stock credit failed for product {$product->id} on RTO order {$order->id}: " . $e->getMessage());
                }
            }

            if ($requiresRefund) {
                $isUpi = $request->refund_method === 'upi';

                RefundTransaction::create([
                    'ndr_id' => $ndr->id,
                    'order_id' => $order->id,
                    'customer_id' => $order->customer_id,
                    'status' => 'completed',
                    'refund_method' => $request->refund_method,
                    'utr_id' => $request->utr_id,
                    'amount' => $order->grand_total,
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
            }

            \App\Models\Notification::create([
                'customer_id' => $order->customer_id,
                'title' => 'Order Returned',
                'message' => $requiresRefund
                    ? "Order {$order->order_number} could not be delivered and has been returned. Your payment has been refunded."
                    : "Order {$order->order_number} could not be delivered and has been returned.",
                'icon' => 'fa-solid fa-rotate-left',
                'color' => 'danger',
                'url' => route('user.orders.show', $order->id),
            ]);
        });

        return redirect()
            ->route('admin.ndr.show', $ndr->id)
            ->with('success', 'Order marked as RTO.' . ($requiresRefund ? ' Refund recorded and stock credited back.' : ' Stock has been credited back.'));
    }

    /**
     * Cancel the order outright from an NDR. If the order was prepaid, a
     * refund is recorded via RefundTransaction — COD orders skip the
     * refund step entirely since nothing was collected.
     */
    public function cancel(Request $request, Ndr $ndr)
    {
        abort_if(in_array($ndr->status, ['delivered', 'rto', 'cancelled']), 422, 'This NDR is already resolved.');

        $order = $ndr->order;
        $requiresRefund = $order->payment_status === 'paid';

        $rules = ['remarks' => 'nullable|string|max:500'];

        if ($requiresRefund) {
            $rules = array_merge($rules, [
                'refund_method' => 'required|in:neft_rtgs_imps,upi',
                'utr_id' => 'required|string|max:100',
                'payment_proof' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
                'bank_name' => 'required_if:refund_method,neft_rtgs_imps|nullable|string|max:100',
                'account_name' => 'required_if:refund_method,neft_rtgs_imps|nullable|string|max:100',
                'account_number' => 'required_if:refund_method,neft_rtgs_imps|nullable|string|max:30',
                'ifsc_code' => 'required_if:refund_method,neft_rtgs_imps|nullable|string|max:20',
                'bank_branch' => 'nullable|string|max:100',
                'account_type' => 'nullable|in:savings,current,salary',
                'upi_id' => 'required_if:refund_method,upi|nullable|string|max:100',
            ]);
        }

        $request->validate($rules);

        $proofPath = null;
        if ($requiresRefund && $request->hasFile('payment_proof')) {
            $proofPath = $request->file('payment_proof')->store('ndr/refund-proofs', 'public');
        }

        DB::transaction(function () use ($ndr, $request, $order, $requiresRefund, $proofPath) {
            $ndr->update([
                'status' => 'cancelled',
                'resolved_at' => now(),
                'remarks' => trim(($ndr->remarks ?? '') . ' | Cancelled: ' . ($request->remarks ?? 'no note')),
            ]);

            $order->update(['status' => 'cancelled']);

            $order->statusHistory()->create([
                'status' => 'cancelled',
                'previous_status' => 'ndr',
                'remarks' => 'Order cancelled after failed delivery.' . ($request->remarks ? " {$request->remarks}" : '') . ($requiresRefund ? ' Refund initiated.' : ''),
                'triggered_by' => 'Admin',
            ]);

            if ($requiresRefund) {
                $isUpi = $request->refund_method === 'upi';

                RefundTransaction::create([
                    'ndr_id' => $ndr->id,
                    'order_id' => $order->id,
                    'customer_id' => $order->customer_id,
                    'status' => 'completed',
                    'refund_method' => $request->refund_method,
                    'utr_id' => $request->utr_id,
                    'amount' => $order->grand_total,
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
            }

            \App\Models\Notification::create([
                'customer_id' => $order->customer_id,
                'title' => 'Order Cancelled',
                'message' => $requiresRefund
                    ? "Order {$order->order_number} has been cancelled after a failed delivery attempt. Your payment has been refunded."
                    : "Order {$order->order_number} has been cancelled after a failed delivery attempt.",
                'icon' => 'fa-solid fa-ban',
                'color' => 'danger',
                'url' => route('user.orders.show', $ndr->order_id),
            ]);
        });

        return redirect()
            ->route('admin.ndr.show', $ndr->id)
            ->with('success', 'Order cancelled.' . ($requiresRefund ? ' Refund recorded.' : ''));
    }

    public function export(Request $request)
    {
        $ndrs = Ndr::with('order')->latest()->get();

        $filename = 'ndr-report-' . now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($ndrs) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'NDR ID',
                'Order',
                'Customer',
                'Reason',
                'Status',
                'Attempts',
                'Next Attempt',
                'Marked By',
                'Raised On',
                'Resolved On',
            ]);

            foreach ($ndrs as $n) {
                fputcsv($handle, [
                    'NDR-' . str_pad($n->id, 4, '0', STR_PAD_LEFT),
                    '#' . ($n->order->order_number ?? ''),
                    $n->order->customer_name ?? '',
                    $n->reason_label,
                    ucfirst($n->status),
                    $n->attempt_count,
                    optional($n->next_attempt_date)->format('d M Y'),
                    $n->marked_by,
                    $n->created_at->format('d M Y'),
                    optional($n->resolved_at)->format('d M Y'),
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}