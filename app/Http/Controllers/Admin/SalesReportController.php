<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderReturn;
use App\Models\RefundTransaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SalesReportExport;

class SalesReportController extends Controller
{
    public function index(Request $request)
    {
        // ── Date range resolution ────────────────────────────
        $end = $request->filled('end_date')
            ? Carbon::parse($request->end_date)->endOfDay()
            : now()->endOfDay();

        $start = $request->filled('start_date')
            ? Carbon::parse($request->start_date)->startOfDay()
            : now()->startOfMonth()->startOfDay();

        if ($start->gt($end)) {
            [$start, $end] = [$end->copy()->startOfDay(), $start->copy()->endOfDay()];
        }

        $days = $start->diffInDays($end) + 1;

        $prevEnd = $start->copy()->subSecond();
        $prevStart = $prevEnd->copy()->subDays($days - 1)->startOfDay();

        $activePreset = $this->detectPreset($start, $end);

        // ── KPI: Revenue ─────────────────────────────────────
        $revenueThis = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$start, $end])->sum('grand_total');
        $revenuePrev = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$prevStart, $prevEnd])->sum('grand_total');
        $revenueGrowth = $this->percentChange($revenuePrev, $revenueThis);

        // ── KPI: Orders ───────────────────────────────────────
        $ordersThis = Order::whereBetween('created_at', [$start, $end])->count();
        $ordersPrev = Order::whereBetween('created_at', [$prevStart, $prevEnd])->count();
        $orderGrowth = $this->percentChange($ordersPrev, $ordersThis);

        // ── KPI: Avg Order Value ─────────────────────────────
        $aovThis = $ordersThis > 0 ? round($revenueThis / $ordersThis) : 0;
        $aovPrev = $ordersPrev > 0 ? round($revenuePrev / $ordersPrev) : 0;
        $aovGrowth = $this->percentChange($aovPrev, $aovThis);

        // ── KPI: Units Sold ───────────────────────────────────
        $unitsThis = OrderItem::join('orders', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.payment_status', 'paid')
            ->whereBetween('orders.created_at', [$start, $end])
            ->sum('order_items.quantity');

        $unitsPrev = OrderItem::join('orders', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.payment_status', 'paid')
            ->whereBetween('orders.created_at', [$prevStart, $prevEnd])
            ->sum('order_items.quantity');

        $unitsGrowth = $this->percentChange($unitsPrev, $unitsThis);

        // ── KPI: Return Rate ─────────────────────────────────
        $returnsThis = OrderReturn::whereBetween('created_at', [$start, $end])->count();
        $returnRateThis = $ordersThis > 0 ? round(($returnsThis / $ordersThis) * 100, 1) : 0;

        $returnsPrev = OrderReturn::whereBetween('created_at', [$prevStart, $prevEnd])->count();
        $returnRatePrev = $ordersPrev > 0 ? round(($returnsPrev / $ordersPrev) * 100, 1) : 0;

        $returnRateDelta = round($returnRateThis - $returnRatePrev, 1);
        $returnRateImproved = $returnRateDelta < -0.05;
        $returnRateWorsened = $returnRateDelta > 0.05;

        // ── Revenue Over Time ────────────────────────────────
        $dailyTotals = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$start, $end])
            ->select(DB::raw('DATE(created_at) as d'), DB::raw('SUM(grand_total) as total'))
            ->groupBy('d')
            ->pluck('total', 'd');

        [$revenueLabels, $revenueSeries, $granularity] = $this->bucketSeries($dailyTotals, $start, $end, $days);

        $bestSalesDay = null;
        $bestSalesAmount = 0;
        if ($dailyTotals->isNotEmpty()) {
            $bestSalesAmount = (float) $dailyTotals->max();
            $bestSalesDay = $dailyTotals->search($bestSalesAmount);
        }

        // ── Revenue by Category ──────────────────────────────
        $categoryRevenueRaw = OrderItem::join('orders', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
            ->where('orders.payment_status', 'paid')
            ->whereBetween('orders.created_at', [$start, $end])
            ->select('categories.id as category_id', 'categories.name as category_name', DB::raw('SUM(order_items.total) as revenue'))
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('revenue')
            ->get();

        $totalItemsRevenue = (float) $categoryRevenueRaw->sum('revenue');

        $palette = ['#303d89', '#007a5e', '#6d28d9', '#916a00', '#8c9196'];
        $categoryBreakdown = collect();

        if ($totalItemsRevenue > 0) {
            $top4 = $categoryRevenueRaw->take(4);
            $othersRevenue = $categoryRevenueRaw->skip(4)->sum('revenue');

            foreach ($top4 as $i => $row) {
                $categoryBreakdown->push([
                    'name'    => $row->category_name ?: 'Uncategorized',
                    'revenue' => (float) $row->revenue,
                    'pct'     => round(($row->revenue / $totalItemsRevenue) * 100),
                    'color'   => $palette[$i],
                ]);
            }

            if ($othersRevenue > 0) {
                $categoryBreakdown->push([
                    'name'    => 'Others',
                    'revenue' => (float) $othersRevenue,
                    'pct'     => round(($othersRevenue / $totalItemsRevenue) * 100),
                    'color'   => $palette[4],
                ]);
            }
        }

        // ── Orders vs Returns (last 7 days) ──────────────────
        $last7End   = $end->lessThan(now()) ? $end->copy()->endOfDay() : now()->endOfDay();
        $last7Start = $last7End->copy()->subDays(6)->startOfDay();

        $ordersVsReturns = $this->dailyOrdersAndReturns($last7Start, $last7End);

        // ── Customer Breakdown ───────────────────────────────
        $totalCustomersInPeriod = Order::whereBetween('created_at', [$start, $end])
            ->whereNotNull('customer_id')
            ->select('customer_id')->distinct()->get()->count();

        $newCustomerIds = Order::select('customer_id')
            ->whereNotNull('customer_id')
            ->groupBy('customer_id')
            ->havingRaw('MIN(created_at) >= ?', [$start])
            ->havingRaw('MIN(created_at) <= ?', [$end])
            ->pluck('customer_id');

        $newCustomersCount      = $newCustomerIds->count();
        $returningCustomersCount = max($totalCustomersInPeriod - $newCustomersCount, 0);

        $newCustomerPct       = $totalCustomersInPeriod > 0 ? round(($newCustomersCount / $totalCustomersInPeriod) * 100) : 0;
        $returningCustomerPct = $totalCustomersInPeriod > 0 ? 100 - $newCustomerPct : 0;

        // ── Period Comparison ────────────────────────────────
        $midThis   = $start->copy()->addDays(intdiv($days, 2));
        $thisHalf1 = Order::where('payment_status', 'paid')->whereBetween('created_at', [$start, $midThis->copy()->subSecond()])->sum('grand_total');
        $thisHalf2 = Order::where('payment_status', 'paid')->whereBetween('created_at', [$midThis, $end])->sum('grand_total');

        $midPrev   = $prevStart->copy()->addDays(intdiv($days, 2));
        $prevHalf1 = Order::where('payment_status', 'paid')->whereBetween('created_at', [$prevStart, $midPrev->copy()->subSecond()])->sum('grand_total');
        $prevHalf2 = Order::where('payment_status', 'paid')->whereBetween('created_at', [$midPrev, $prevEnd])->sum('grand_total');

        // ── Daily Revenue Breakdown (last 7 days) ────────────
        $breakdownEnd   = $last7End;
        $breakdownStart = $last7Start;
        $lookbackStart  = $breakdownStart->copy()->subDay();

        $rawDaily = Order::whereBetween('created_at', [$lookbackStart, $breakdownEnd])
            ->select(
                DB::raw('DATE(created_at) as d'),
                DB::raw('COUNT(*) as cnt'),
                DB::raw("SUM(CASE WHEN payment_status = 'paid' THEN grand_total ELSE 0 END) as rev")
            )
            ->groupBy('d')
            ->get()
            ->keyBy('d');

        $dailyBreakdown = [];
        for ($d = $breakdownStart->copy(); $d->lte($breakdownEnd); $d->addDay()) {
            $key     = $d->format('Y-m-d');
            $prevKey = $d->copy()->subDay()->format('Y-m-d');

            $todayRev = (float) ($rawDaily[$key]->rev ?? 0);
            $prevRev  = (float) ($rawDaily[$prevKey]->rev ?? 0);

            $dailyBreakdown[] = [
                'date'    => $d->copy(),
                'orders'  => (int) ($rawDaily[$key]->cnt ?? 0),
                'revenue' => $todayRev,
                'growth'  => $this->percentChange($prevRev, $todayRev),
            ];
        }
        $dailyBreakdown   = array_reverse($dailyBreakdown);
        $weekTotalOrders  = array_sum(array_column($dailyBreakdown, 'orders'));
        $weekTotalRevenue = array_sum(array_column($dailyBreakdown, 'revenue'));

        // ── Top Selling Products ─────────────────────────────
        $topProducts = OrderItem::join('orders', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
            ->where('orders.payment_status', 'paid')
            ->whereBetween('orders.created_at', [$start, $end])
            ->select(
                'order_items.product_id',
                'order_items.product_name',
                'products.sku',
                'categories.name as category_name',
                DB::raw('SUM(order_items.quantity) as units'),
                DB::raw('SUM(order_items.total) as revenue')
            )
            ->groupBy('order_items.product_id', 'order_items.product_name', 'products.sku', 'categories.name')
            ->orderByDesc('revenue')
            ->take(5)
            ->get();

        $topProductIds = $topProducts->pluck('product_id');

        $prevProductRevenue = OrderItem::join('orders', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.payment_status', 'paid')
            ->whereBetween('orders.created_at', [$prevStart, $prevEnd])
            ->whereIn('order_items.product_id', $topProductIds)
            ->select('order_items.product_id', DB::raw('SUM(order_items.total) as revenue'))
            ->groupBy('order_items.product_id')
            ->pluck('revenue', 'product_id');

        $thumbColors = ['e8f2ff/0069d9', 'e3f1ec/007a5e', 'ede9fe/6d28d9', 'fff5cc/916a00', 'fce8e8/b22222'];

        $topProducts = $topProducts->map(function ($p, $i) use ($prevProductRevenue, $totalItemsRevenue, $thumbColors) {
            $prevRev = (float) ($prevProductRevenue[$p->product_id] ?? 0);
            return [
                'name'      => $p->product_name,
                'sku'       => $p->sku,
                'category'  => $p->category_name ?: 'Uncategorized',
                'units'     => (int) $p->units,
                'revenue'   => (float) $p->revenue,
                'avg_price' => $p->units > 0 ? round($p->revenue / $p->units) : 0,
                'share'     => $totalItemsRevenue > 0 ? round(($p->revenue / $totalItemsRevenue) * 100) : 0,
                'growth'    => $this->percentChange($prevRev, (float) $p->revenue),
                'thumb'     => 'https://placehold.co/40x40/' . $thumbColors[$i % count($thumbColors)] . '?text=' . substr($p->product_name, 0, 1),
            ];
        });

        $top5UnitsTotal   = $topProducts->sum('units');
        $top5RevenueTotal = $topProducts->sum('revenue');

        // ── Payment Methods ──────────────────────────────────
        $paymentMethods = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$start, $end])
            ->select('payment_method', DB::raw('COUNT(*) as txns'), DB::raw('SUM(grand_total) as revenue'))
            ->groupBy('payment_method')
            ->get()
            ->map(function ($row) use ($revenueThis) {
                $labels = ['razorpay' => '💳 Razorpay', 'cod' => '💵 Cash on Delivery'];
                $colors = ['razorpay' => 'var(--blue)', 'cod' => 'var(--amber)'];
                return [
                    'method'  => $row->payment_method,
                    'label'   => $labels[$row->payment_method] ?? ucfirst($row->payment_method),
                    'color'   => $colors[$row->payment_method] ?? 'var(--text-secondary)',
                    'txns'    => $row->txns,
                    'revenue' => (float) $row->revenue,
                    'share'   => $revenueThis > 0 ? round(($row->revenue / $revenueThis) * 100) : 0,
                ];
            });

        // ── Key Metrics ──────────────────────────────────────
        $grossRevenue   = Order::where('payment_status', 'paid')->whereBetween('created_at', [$start, $end])->sum('subtotal');
        $discountsGiven = Order::where('payment_status', 'paid')->whereBetween('created_at', [$start, $end])->sum('discount');
        $refundsTotal   = RefundTransaction::whereBetween('created_at', [$start, $end])->sum('amount');
        $taxCollected   = Order::where('payment_status', 'paid')->whereBetween('created_at', [$start, $end])->sum('tax_amount');

        $peakHourRow = Order::whereBetween('created_at', [$start, $end])
            ->select(DB::raw('HOUR(created_at) as hr'), DB::raw('COUNT(*) as cnt'))
            ->groupBy('hr')
            ->orderByDesc('cnt')
            ->first();

        $peakHourLabel = null;
        if ($peakHourRow) {
            $peakHourLabel = Carbon::createFromTime((int) $peakHourRow->hr)->format('g A')
                . ' – ' . Carbon::createFromTime(((int) $peakHourRow->hr + 1) % 24)->format('g A');
        }

        $repeatPurchaseRate = $returningCustomerPct;

        $viewData = compact(
            'start', 'end', 'activePreset',
            'revenueThis', 'revenueGrowth',
            'ordersThis', 'orderGrowth',
            'aovThis', 'aovGrowth',
            'unitsThis', 'unitsGrowth',
            'returnRateThis', 'returnRateDelta', 'returnRateImproved', 'returnRateWorsened',
            'revenueLabels', 'revenueSeries', 'granularity',
            'bestSalesDay', 'bestSalesAmount',
            'categoryBreakdown',
            'ordersVsReturns',
            'newCustomerPct', 'returningCustomerPct', 'newCustomersCount', 'returningCustomersCount',
            'thisHalf1', 'thisHalf2', 'prevHalf1', 'prevHalf2', 'revenuePrev',
            'dailyBreakdown', 'weekTotalOrders', 'weekTotalRevenue',
            'topProducts', 'top5UnitsTotal', 'top5RevenueTotal',
            'paymentMethods',
            'grossRevenue', 'discountsGiven', 'refundsTotal', 'taxCollected',
            'peakHourLabel', 'repeatPurchaseRate'
        );

        return view('admin.reports.sales', $viewData);
    }

    // ────────────────────────────────────────────────────────────────────────
    // Export  (PDF + Excel)
    // ────────────────────────────────────────────────────────────────────────

    public function export(Request $request)
    {
        $request->validate([
            'format'     => 'required|in:pdf,excel',
            'start_date' => 'nullable|date',
            'end_date'   => 'nullable|date',
        ]);

        $format = $request->input('format');

        $end = $request->filled('end_date')
            ? Carbon::parse($request->end_date)->endOfDay()
            : now()->endOfDay();

        $start = $request->filled('start_date')
            ? Carbon::parse($request->start_date)->startOfDay()
            : now()->startOfMonth()->startOfDay();

        if ($start->gt($end)) {
            [$start, $end] = [$end->copy()->startOfDay(), $start->copy()->endOfDay()];
        }

        $filename = 'sales-report_' . $start->format('Y-m-d') . '_to_' . $end->format('Y-m-d');

        // ── Excel ────────────────────────────────────────────
        if ($format === 'excel') {
            return Excel::download(
                new SalesReportExport($start, $end),
                $filename . '.xlsx'
            );
        }

        // ── PDF ──────────────────────────────────────────────
        $data = $this->buildReportData($start, $end);

        $pdf = Pdf::loadView('admin.reports.sales-pdf', $data)
            ->setPaper('a4', 'landscape')
            ->setOptions([
                'defaultFont'     => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => false,
            ]);

        return $pdf->download($filename . '.pdf');
    }

    // ────────────────────────────────────────────────────────────────────────
    // Shared data builder (used by both index and PDF export)
    // ────────────────────────────────────────────────────────────────────────

    private function buildReportData(Carbon $start, Carbon $end): array
    {
        $days = $start->diffInDays($end) + 1;

        $prevEnd   = $start->copy()->subSecond();
        $prevStart = $prevEnd->copy()->subDays($days - 1)->startOfDay();

        $revenueThis = Order::where('payment_status', 'paid')->whereBetween('created_at', [$start, $end])->sum('grand_total');
        $revenuePrev = Order::where('payment_status', 'paid')->whereBetween('created_at', [$prevStart, $prevEnd])->sum('grand_total');
        $revenueGrowth = $this->percentChange($revenuePrev, $revenueThis);

        $ordersThis  = Order::whereBetween('created_at', [$start, $end])->count();
        $ordersPrev  = Order::whereBetween('created_at', [$prevStart, $prevEnd])->count();
        $orderGrowth = $this->percentChange($ordersPrev, $ordersThis);

        $aovThis   = $ordersThis > 0 ? round($revenueThis / $ordersThis) : 0;
        $aovPrev   = $ordersPrev > 0 ? round($revenuePrev / $ordersPrev) : 0;
        $aovGrowth = $this->percentChange($aovPrev, $aovThis);

        $unitsThis   = OrderItem::join('orders', 'orders.id', '=', 'order_items.order_id')->where('orders.payment_status', 'paid')->whereBetween('orders.created_at', [$start, $end])->sum('order_items.quantity');
        $unitsPrev   = OrderItem::join('orders', 'orders.id', '=', 'order_items.order_id')->where('orders.payment_status', 'paid')->whereBetween('orders.created_at', [$prevStart, $prevEnd])->sum('order_items.quantity');
        $unitsGrowth = $this->percentChange($unitsPrev, $unitsThis);

        $returnsThis     = OrderReturn::whereBetween('created_at', [$start, $end])->count();
        $returnRateThis  = $ordersThis > 0 ? round(($returnsThis / $ordersThis) * 100, 1) : 0;
        $returnsPrev     = OrderReturn::whereBetween('created_at', [$prevStart, $prevEnd])->count();
        $returnRatePrev  = $ordersPrev > 0 ? round(($returnsPrev / $ordersPrev) * 100, 1) : 0;
        $returnRateDelta = round($returnRateThis - $returnRatePrev, 1);

        $topProducts = OrderItem::join('orders', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
            ->where('orders.payment_status', 'paid')
            ->whereBetween('orders.created_at', [$start, $end])
            ->select(
                'order_items.product_name', 'products.sku',
                'categories.name as category_name',
                DB::raw('SUM(order_items.quantity) as units'),
                DB::raw('SUM(order_items.total) as revenue')
            )
            ->groupBy('order_items.product_id', 'order_items.product_name', 'products.sku', 'categories.name')
            ->orderByDesc('revenue')
            ->take(5)
            ->get()
            ->map(fn($p) => [
                'name'      => $p->product_name,
                'sku'       => $p->sku,
                'category'  => $p->category_name ?: 'Uncategorized',
                'units'     => (int) $p->units,
                'revenue'   => (float) $p->revenue,
                'avg_price' => $p->units > 0 ? round($p->revenue / $p->units) : 0,
            ]);

        $paymentMethods = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$start, $end])
            ->select('payment_method', DB::raw('COUNT(*) as txns'), DB::raw('SUM(grand_total) as revenue'))
            ->groupBy('payment_method')
            ->get()
            ->map(fn($row) => [
                'label'   => ['razorpay' => 'Razorpay', 'cod' => 'Cash on Delivery'][$row->payment_method] ?? ucfirst($row->payment_method),
                'txns'    => $row->txns,
                'revenue' => (float) $row->revenue,
                'share'   => $revenueThis > 0 ? round(($row->revenue / $revenueThis) * 100) : 0,
            ]);

        $grossRevenue   = Order::where('payment_status', 'paid')->whereBetween('created_at', [$start, $end])->sum('subtotal');
        $discountsGiven = Order::where('payment_status', 'paid')->whereBetween('created_at', [$start, $end])->sum('discount');
        $refundsTotal   = RefundTransaction::whereBetween('created_at', [$start, $end])->sum('amount');
        $taxCollected   = Order::where('payment_status', 'paid')->whereBetween('created_at', [$start, $end])->sum('tax_amount');

        return compact(
            'start', 'end',
            'revenueThis', 'revenueGrowth', 'revenuePrev',
            'ordersThis', 'orderGrowth',
            'aovThis', 'aovGrowth',
            'unitsThis', 'unitsGrowth',
            'returnRateThis', 'returnRateDelta',
            'topProducts', 'paymentMethods',
            'grossRevenue', 'discountsGiven', 'refundsTotal', 'taxCollected'
        );
    }

    // ────────────────────────────────────────────────────────────────────────
    // Private helpers
    // ────────────────────────────────────────────────────────────────────────

    private function percentChange($old, $new): float
    {
        if ($old <= 0) {
            return $new > 0 ? 100.0 : 0.0;
        }
        return round((($new - $old) / $old) * 100, 1);
    }

    private function detectPreset(Carbon $start, Carbon $end): string
    {
        $today = now();

        if ($start->isSameDay($today) && $end->isSameDay($today))                                                                                    return 'today';
        if ($start->isSameDay($today->copy()->subDay()) && $end->isSameDay($today->copy()->subDay()))                                                 return 'yesterday';
        if ($start->isSameDay($today->copy()->startOfMonth()) && $end->isSameDay($today))                                                            return 'this_month';
        if ($start->isSameDay($today->copy()->subMonth()->startOfMonth()) && $end->isSameDay($today->copy()->subMonth()->endOfMonth()))               return 'last_month';
        if ($start->isSameDay($today->copy()->startOfYear()) && $end->isSameDay($today))                                                             return 'this_year';

        return 'custom';
    }

    private function bucketSeries($dailyTotals, Carbon $start, Carbon $end, int $days): array
    {
        $granularity = $days <= 35 ? 'day' : ($days <= 180 ? 'week' : 'month');
        $labels = [];
        $data   = [];

        if ($granularity === 'day') {
            for ($d = $start->copy(); $d->lte($end); $d->addDay()) {
                $labels[] = $d->format('d M');
                $data[]   = (float) ($dailyTotals[$d->format('Y-m-d')] ?? 0);
            }
        } elseif ($granularity === 'week') {
            $bucket = [];
            foreach ($dailyTotals as $date => $total) {
                $weekStart = Carbon::parse($date)->startOfWeek()->format('Y-m-d');
                $bucket[$weekStart] = ($bucket[$weekStart] ?? 0) + $total;
            }
            ksort($bucket);
            foreach ($bucket as $weekStart => $total) {
                $labels[] = 'Wk of ' . Carbon::parse($weekStart)->format('d M');
                $data[]   = (float) $total;
            }
        } else {
            $bucket = [];
            foreach ($dailyTotals as $date => $total) {
                $monthKey = Carbon::parse($date)->format('Y-m');
                $bucket[$monthKey] = ($bucket[$monthKey] ?? 0) + $total;
            }
            ksort($bucket);
            foreach ($bucket as $monthKey => $total) {
                $labels[] = Carbon::parse($monthKey . '-01')->format('M Y');
                $data[]   = (float) $total;
            }
        }

        return [$labels, $data, $granularity];
    }

    private function dailyOrdersAndReturns(Carbon $start, Carbon $end): array
    {
        $orders  = Order::whereBetween('created_at', [$start, $end])->select(DB::raw('DATE(created_at) as d'), DB::raw('COUNT(*) as cnt'))->groupBy('d')->pluck('cnt', 'd');
        $returns = OrderReturn::whereBetween('created_at', [$start, $end])->select(DB::raw('DATE(created_at) as d'), DB::raw('COUNT(*) as cnt'))->groupBy('d')->pluck('cnt', 'd');

        $labels     = [];
        $orderData  = [];
        $returnData = [];

        for ($d = $start->copy(); $d->lte($end); $d->addDay()) {
            $key          = $d->format('Y-m-d');
            $labels[]     = $d->format('D');
            $orderData[]  = (int) ($orders[$key] ?? 0);
            $returnData[] = (int) ($returns[$key] ?? 0);
        }

        return ['labels' => $labels, 'orders' => $orderData, 'returns' => $returnData];
    }
}