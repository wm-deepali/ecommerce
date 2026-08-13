<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderReturn;
use App\Models\Product;
use App\Models\Customer;
use App\Services\StockService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct(protected StockService $stockService) {}

    public function index()
    {
        $now = Carbon::now();
        $startThis = $now->copy()->startOfMonth();
        $startLast = $now->copy()->subMonth()->startOfMonth();
        $endLast   = $now->copy()->subMonth()->endOfMonth();

        // ── Revenue ──────────────────────────────────────────
        $revenueThisMonth = Order::where('payment_status', 'paid')
            ->where('created_at', '>=', $startThis)
            ->sum('grand_total');

        $revenueLastMonth = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$startLast, $endLast])
            ->sum('grand_total');

        $revenueGrowth = $this->percentChange($revenueLastMonth, $revenueThisMonth);

        // ── Products ─────────────────────────────────────────
        $totalProducts = Product::count();
        $productsLastMonth = Product::where('created_at', '<', $startThis)->count();
        $productGrowth = $this->percentChange($productsLastMonth, $totalProducts);

        // ── Orders ───────────────────────────────────────────
        $totalOrders = Order::count();
        $ordersThisMonth = Order::where('created_at', '>=', $startThis)->count();
        $ordersLastMonth = Order::whereBetween('created_at', [$startLast, $endLast])->count();
        $orderGrowth = $this->percentChange($ordersLastMonth, $ordersThisMonth);

        // ── Customers ────────────────────────────────────────
        $totalCustomers = Customer::count();
        $customersThisMonth = Customer::where('created_at', '>=', $startThis)->count();
        $customersLastMonth = Customer::whereBetween('created_at', [$startLast, $endLast])->count();
        $customerGrowth = $this->percentChange($customersLastMonth, $customersThisMonth);

        // ── Pending payments ─────────────────────────────────
        $pendingPayments = Order::where('payment_status', 'pending')->sum('grand_total');
        $pendingPaymentsCount = Order::where('payment_status', 'pending')->count();

        // ── Order status breakdown ───────────────────────────
        $statusCounts = Order::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $statusTotal = $statusCounts->sum() ?: 1;

        $pendingPct    = round((($statusCounts['pending'] ?? 0) / $statusTotal) * 100);
        $processingPct = round((($statusCounts['processing'] ?? 0) / $statusTotal) * 100);
        $deliveredPct  = round((($statusCounts['delivered'] ?? 0) / $statusTotal) * 100);

        // ── Quick stats ──────────────────────────────────────
        $avgOrderValue = $ordersThisMonth > 0
            ? round($revenueThisMonth / $ordersThisMonth)
            : 0;

        $totalReturns = OrderReturn::count();
        $returnRate = $totalOrders > 0
            ? round(($totalReturns / $totalOrders) * 100, 1)
            : 0;

        $fulfilledToday = Order::where('status', 'delivered')
            ->whereDate('updated_at', $now->toDateString())
            ->count();

        // ── Sales chart - last 6 months ──────────────────────
        $chartLabels = [];
        $chartData = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = $now->copy()->subMonths($i);
            $chartLabels[] = $month->format('M');
            $chartData[] = (float) Order::where('payment_status', 'paid')
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('grand_total');
        }

        // ── Recent orders ────────────────────────────────────
        $recentOrders = Order::latest()->take(5)->get();

        // ── Top selling products this month ──────────────────
        $topProducts = OrderItem::select('product_id', 'product_name', DB::raw('SUM(quantity) as total_qty'))
            ->whereHas('order', fn ($q) => $q->where('created_at', '>=', $startThis))
            ->groupBy('product_id', 'product_name')
            ->orderByDesc('total_qty')
            ->take(4)
            ->get();

        // ── Stock alert banner ───────────────────────────────
        [$criticalThreshold] = $this->stockService->thresholds();
        $criticalProducts = Product::where('stock', '<=', $criticalThreshold)->get();
        $showStockBanner = $criticalProducts->isNotEmpty();

        return view('admin.dashboard.index', compact(
            'revenueThisMonth', 'revenueGrowth',
            'totalProducts', 'productGrowth',
            'totalOrders', 'orderGrowth',
            'totalCustomers', 'customerGrowth',
            'pendingPayments', 'pendingPaymentsCount',
            'pendingPct', 'processingPct', 'deliveredPct',
            'avgOrderValue', 'returnRate', 'fulfilledToday',
            'chartLabels', 'chartData',
            'recentOrders', 'topProducts',
            'criticalProducts', 'showStockBanner'
        ));
    }

    private function percentChange($old, $new): float
    {
        if ($old <= 0) {
            return $new > 0 ? 100.0 : 0.0;
        }

        return round((($new - $old) / $old) * 100, 1);
    }
}