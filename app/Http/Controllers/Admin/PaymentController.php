<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        // ── KPI cards ─────────────────────────────────────────
        $kpi = [
            'collected' => Order::where('payment_status', 'paid')->sum('grand_total'),
            'pending'   => Order::where('payment_status', 'pending')->sum('grand_total'),
            'pending_count' => Order::where('payment_status', 'pending')->count(),
            'refunded'  => Order::where('payment_status', 'refunded')->sum('grand_total'),
            'refunded_count' => Order::where('payment_status', 'refunded')->count(),
            'failed_count'   => Order::where('payment_status', 'failed')->count(),
        ];

        // ── Revenue trend – last 7 days ───────────────────────
        $trend = Order::where('payment_status', 'paid')
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(grand_total) as total')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date');

        // Fill missing days with 0
        $trendLabels = [];
        $trendValues = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = now()->subDays($i)->toDateString();
            $trendLabels[] = now()->subDays($i)->format('D'); // Mon, Tue…
            $trendValues[] = (float) ($trend[$day] ?? 0);
        }

        // ── Payment method breakdown ──────────────────────────
        $methodBreakdown = Order::where('payment_status', 'paid')
            ->whereNotNull('payment_method')
            ->select('payment_method', DB::raw('SUM(grand_total) as total'), DB::raw('COUNT(*) as count'))
            ->groupBy('payment_method')
            ->orderByDesc('total')
            ->get();

        $methodTotal = $methodBreakdown->sum('total') ?: 1; // avoid /0

        // ── Tab counts ────────────────────────────────────────
        $tabCounts = [
            'all'      => Order::count(),
            'paid'     => Order::where('payment_status', 'paid')->count(),
            'pending'  => Order::where('payment_status', 'pending')->count(),
            'failed'   => Order::where('payment_status', 'failed')->count(),
            'refunded' => Order::where('payment_status', 'refunded')->count(),
        ];

        // ── Base query ────────────────────────────────────────
        $query = Order::with('customer')->latest();

        // Tab filter
        $activeTab = $request->input('tab', 'all');
        if ($activeTab !== 'all') {
            $query->where('payment_status', $activeTab);
        }

        // Search: transaction id, order number, customer name/email
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('transaction_id', 'like', "%{$search}%")
                  ->orWhere('razorpay_payment_id', 'like', "%{$search}%")
                  ->orWhere('order_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%");
            });
        }

        // Payment method filter
        if ($method = $request->input('method')) {
            $query->where('payment_method', $method);
        }

        // Date range
        if ($from = $request->input('from_date')) {
            $query->whereDate('created_at', '>=', $from);
        }
        if ($to = $request->input('to_date')) {
            $query->whereDate('created_at', '<=', $to);
        }

        $orders = $query->paginate(25)->withQueryString();

        return view('admin.payments.index', compact(
            'kpi',
            'trendLabels',
            'trendValues',
            'methodBreakdown',
            'methodTotal',
            'tabCounts',
            'activeTab',
            'orders'
        ));
    }

    // ── CSV export ────────────────────────────────────────────
    public function export(Request $request)
    {
        $query = Order::latest();

        $activeTab = $request->input('tab', 'all');
        if ($activeTab !== 'all') {
            $query->where('payment_status', $activeTab);
        }
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('transaction_id', 'like', "%{$search}%")
                  ->orWhere('order_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%");
            });
        }
        if ($method = $request->input('method')) {
            $query->where('payment_method', $method);
        }
        if ($from = $request->input('from_date')) {
            $query->whereDate('created_at', '>=', $from);
        }
        if ($to = $request->input('to_date')) {
            $query->whereDate('created_at', '<=', $to);
        }

        $orders   = $query->get();
        $filename = 'payments_' . now()->format('Y_m_d_His') . '.csv';

        return response()->stream(function () use ($orders) {
            $fh = fopen('php://output', 'w');
            fputcsv($fh, [
                'Transaction ID', 'Razorpay Payment ID', 'Order #',
                'Customer', 'Email', 'Phone',
                'Payment Method', 'Payment Status',
                'Grand Total', 'Date',
            ]);
            foreach ($orders as $o) {
                fputcsv($fh, [
                    $o->transaction_id,
                    $o->razorpay_payment_id,
                    $o->order_number,
                    $o->customer_name,
                    $o->customer_email,
                    $o->customer_phone,
                    $o->payment_method,
                    $o->payment_status,
                    $o->grand_total,
                    $o->created_at->format('d M Y h:i A'),
                ]);
            }
            fclose($fh);
        }, 200, [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }
}