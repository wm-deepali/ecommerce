<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RefundTransaction;
use Illuminate\Http\Request;

class RefundController extends Controller
{
    public function index(Request $request)
    {
        $query = RefundTransaction::with([
            'customer',
            'order',
            'orderReturn.returnReason',
        ])->latest();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                    ->orWhere('order_id', 'like', "%{$search}%")
                    ->orWhere('utr_id', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($customer) use ($search) {
                        $customer->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }


        // Date Filters
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $refunds = $query->paginate(20)->withQueryString();

        $stats = [
            'total' => RefundTransaction::count(),

            'total_amount' => RefundTransaction::sum('amount'),

            'this_month' => RefundTransaction::whereMonth(
                'created_at',
                now()->month
            )->whereYear(
                'created_at',
                now()->year
            )->count(),

            'failed' => 0,
        ];

        $methodLabels = [
            'upi' => 'UPI',
            'bank' => 'Bank Transfer',
            'neft_rtgs_imps' => 'NEFT / RTGS / IMPS',
        ];

        return view('admin.refunds.index', compact(
            'refunds',
            'stats',
            'methodLabels'
        ));
    }

    public function export()
    {
        $refunds = RefundTransaction::with([
            'customer',
            'order',
            'orderReturn.returnReason',
        ])->latest()->get();

        $filename = 'refunds-' . now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $callback = function () use ($refunds) {

            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'Refund ID',
                'Order ID',
                'Customer',
                'Email',
                'Amount',
                'Method',
                'UTR',
                'Status',
                'Date',
            ]);

            foreach ($refunds as $refund) {
                fputcsv($handle, [
                    'REF-' . str_pad($refund->id, 4, '0', STR_PAD_LEFT),
                    $refund->order_id,
                    $refund->customer->name ?? '',
                    $refund->customer->email ?? '',
                    $refund->amount,
                    $refund->refund_method,
                    $refund->utr_id,
                    'refunded',
                    $refund->created_at->format('d M Y'),
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}