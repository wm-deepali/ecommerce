<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ProductsReportExport;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderReturn;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ProductReportController extends Controller
{
    private function resolveRange(string $range): array
    {
        $now = now();
        return match ($range) {
            '7days'   => [$now->copy()->subDays(6)->startOfDay(),  $now->copy()->endOfDay()],
            '3months' => [$now->copy()->subMonths(3)->startOfDay(), $now->copy()->endOfDay()],
            '6months' => [$now->copy()->subMonths(6)->startOfDay(), $now->copy()->endOfDay()],
            'year'    => [$now->copy()->startOfYear()->startOfDay(), $now->copy()->endOfDay()],
            'custom'  => [
                Carbon::parse(request('start_date'))->startOfDay(),
                Carbon::parse(request('end_date'))->endOfDay(),
            ],
            default   => [$now->copy()->subDays(29)->startOfDay(), $now->copy()->endOfDay()], // 30days
        };
    }

    private function prevRange(Carbon $start, Carbon $end): array
    {
        $days = $start->diffInDays($end) + 1;
        $prevEnd = $start->copy()->subSecond();
        $prevStart = $prevEnd->copy()->subDays($days - 1)->startOfDay();
        return [$prevStart, $prevEnd];
    }

    public function index(Request $request)
    {
        // ── Filters ──────────────────────────────────────────
        $range      = $request->input('range', '30days');
        $search     = $request->input('search', '');
        $categoryId = $request->input('category_id', '');
        $status     = $request->input('status', '');
        $sortBy     = $request->input('sort_by', 'revenue');
        $perPage    = (int) $request->input('per_page', 15);

        [$start, $end] = $this->resolveRange($range);
        [$prevStart, $prevEnd] = $this->prevRange($start, $end);

        $data = $this->buildReportData($start, $end, $prevStart, $prevEnd);

        $products = $this->buildProductsQuery($start, $end, $prevStart, $prevEnd, $search, $categoryId, $status, $sortBy)
            ->paginate($perPage)
            ->withQueryString();

        $products->getCollection()->transform(function ($p, $i) use ($products) {
            $rank = ($products->currentPage() - 1) * $products->perPage() + $i + 1;
            return $this->decorateProduct($p, $rank);
        });

        $categories = Category::orderBy('name')->get(['id', 'name']);

        return view('admin.reports.product', array_merge(
            compact('range', 'search', 'categoryId', 'status', 'sortBy', 'categories', 'start', 'end', 'products'),
            $data
        ));
    }

    public function exportCsv(Request $request)
    {
        $range      = $request->input('range', '30days');
        $search     = $request->input('search', '');
        $categoryId = $request->input('category_id', '');
        $status     = $request->input('status', '');
        $sortBy     = $request->input('sort_by', 'revenue');

        [$start, $end] = $this->resolveRange($range);
        [$prevStart, $prevEnd] = $this->prevRange($start, $end);

        $products = $this->buildProductsQuery($start, $end, $prevStart, $prevEnd, $search, $categoryId, $status, $sortBy)
            ->get()
            ->values()
            ->map(fn ($p, $i) => $this->decorateProduct($p, $i + 1));

        $filename = 'product-report-' . $start->format('Y-m-d') . '-to-' . $end->format('Y-m-d') . '.csv';

        return Excel::download(new ProductsReportExport($products), $filename, \Maatwebsite\Excel\Excel::CSV);
    }

    public function exportPdf(Request $request)
    {
        $range      = $request->input('range', '30days');
        $search     = $request->input('search', '');
        $categoryId = $request->input('category_id', '');
        $status     = $request->input('status', '');
        $sortBy     = $request->input('sort_by', 'revenue');

        [$start, $end] = $this->resolveRange($range);
        [$prevStart, $prevEnd] = $this->prevRange($start, $end);

        $data = $this->buildReportData($start, $end, $prevStart, $prevEnd);

        $products = $this->buildProductsQuery($start, $end, $prevStart, $prevEnd, $search, $categoryId, $status, $sortBy)
            ->get()
            ->values()
            ->map(fn ($p, $i) => $this->decorateProduct($p, $i + 1));

        $categoryName = $categoryId ? Category::find($categoryId)?->name : null;

        $pdf = Pdf::loadView('admin.reports.product-pdf', array_merge(
            compact('range', 'search', 'categoryId', 'categoryName', 'status', 'sortBy', 'start', 'end', 'products'),
            $data
        ))->setPaper('a4', 'landscape');

        $filename = 'product-report-' . $start->format('Y-m-d') . '-to-' . $end->format('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * KPIs, charts, and sidebar metrics for the report — independent of the
     * product-table filters (search/category/status/sort) since they describe
     * the whole catalog/date range, not the filtered list.
     */
    private function buildReportData(Carbon $start, Carbon $end, Carbon $prevStart, Carbon $prevEnd): array
    {
        // ── KPI: Total Products ───────────────────────────────
        $totalProducts    = Product::count();
        $newProductsCount = Product::whereBetween('created_at', [$start, $end])->count();

        // ── KPI: Total Units Sold ─────────────────────────────
        $unitsThis = (int) OrderItem::join('orders', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.payment_status', 'paid')
            ->whereBetween('orders.created_at', [$start, $end])
            ->sum('order_items.quantity');

        $unitsPrev = (int) OrderItem::join('orders', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.payment_status', 'paid')
            ->whereBetween('orders.created_at', [$prevStart, $prevEnd])
            ->sum('order_items.quantity');

        $unitsGrowth = $this->percentChange($unitsPrev, $unitsThis);

        // ── KPI: Total Revenue ────────────────────────────────
        $revenueThis = (float) OrderItem::join('orders', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.payment_status', 'paid')
            ->whereBetween('orders.created_at', [$start, $end])
            ->sum('order_items.total');

        $revenuePrev = (float) OrderItem::join('orders', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.payment_status', 'paid')
            ->whereBetween('orders.created_at', [$prevStart, $prevEnd])
            ->sum('order_items.total');

        $revenueGrowth = $this->percentChange($revenuePrev, $revenueThis);

        // ── KPI: Out of Stock ─────────────────────────────────
        $outOfStockNow  = Product::where('stock', '<=', 0)->count();
        $outOfStockPrev = Product::where('stock', '<=', 0)
            ->where('updated_at', '<', $start)->count();
        $outOfStockDelta = $outOfStockNow - $outOfStockPrev;

        // ── Bar chart: top 8 products by units ────────────────
        $topBarProducts = OrderItem::join('orders', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.payment_status', 'paid')
            ->whereBetween('orders.created_at', [$start, $end])
            ->select('order_items.product_name', DB::raw('SUM(order_items.quantity) as units'))
            ->groupBy('order_items.product_id', 'order_items.product_name')
            ->orderByDesc('units')
            ->take(8)
            ->get();

        $maxUnits = $topBarProducts->max('units') ?: 1;

        // ── Revenue trend (monthly, last 12 months) ───────────
        $trendStart = now()->subMonths(11)->startOfMonth()->startOfDay();
        $trendEnd   = now()->endOfMonth()->endOfDay();

        $monthlyRevenue = OrderItem::join('orders', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.payment_status', 'paid')
            ->whereBetween('orders.created_at', [$trendStart, $trendEnd])
            ->select(
                DB::raw("DATE_FORMAT(orders.created_at, '%Y-%m') as month_key"),
                DB::raw('SUM(order_items.total) as revenue')
            )
            ->groupBy('month_key')
            ->orderBy('month_key')
            ->pluck('revenue', 'month_key');

        $trendLabels = [];
        $trendSeries = [];
        $maxRevenue  = 0;
        for ($m = $trendStart->copy(); $m->lte(now()->startOfMonth()); $m->addMonth()) {
            $key           = $m->format('Y-m');
            $val           = (float) ($monthlyRevenue[$key] ?? 0);
            $trendLabels[] = $m->format('M');
            $trendSeries[] = $val;
            $maxRevenue    = max($maxRevenue, $val);
        }

        $trendPoints = $this->buildSvgPolyline($trendSeries, $maxRevenue, 700, 130);

        // Per-point coordinates for individual <circle> markers (one per month)
        $trendCoords = [];
        $n = count($trendSeries);
        $maxRev = $maxRevenue ?: 1;
        foreach ($trendSeries as $i => $val) {
            $x = $n === 1 ? 350 : ($i / ($n - 1)) * 700;
            $y = 130 - (($val / $maxRev) * 130);
            $trendCoords[] = ['x' => round($x, 1), 'y' => round($y, 1)];
        }

        // ── Revenue by Category (sidebar donut) ───────────────
        $categoryRevRaw = OrderItem::join('orders', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
            ->where('orders.payment_status', 'paid')
            ->whereBetween('orders.created_at', [$start, $end])
            ->select('categories.name as category_name', DB::raw('SUM(order_items.total) as revenue'))
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('revenue')
            ->get();

        $totalCatRevenue = (float) $categoryRevRaw->sum('revenue') ?: 1;

        $donutColors      = ['#303d89', '#0069d9', '#007a5e', '#f59e0b', '#e3e5e8'];
        $donutCategories  = collect();
        $circumference    = 2 * M_PI * 40;

        $top4Cat      = $categoryRevRaw->take(4);
        $othersRevCat = $categoryRevRaw->skip(4)->sum('revenue');

        foreach ($top4Cat as $i => $cat) {
            $donutCategories->push([
                'name'    => $cat->category_name ?: 'Uncategorized',
                'revenue' => (float) $cat->revenue,
                'pct'     => round(($cat->revenue / $totalCatRevenue) * 100),
                'color'   => $donutColors[$i],
            ]);
        }
        if ($othersRevCat > 0) {
            $donutCategories->push([
                'name'    => 'Others',
                'revenue' => (float) $othersRevCat,
                'pct'     => round(($othersRevCat / $totalCatRevenue) * 100),
                'color'   => $donutColors[4],
            ]);
        }

        $offset = 0;
        $donutSegments = $donutCategories->map(function ($cat) use ($circumference, &$offset) {
            $arc    = ($cat['pct'] / 100) * $circumference;
            $gap    = $circumference - $arc;
            $seg    = ['dash' => "{$arc} {$gap}", 'offset' => -$offset, 'color' => $cat['color']];
            $offset += $arc;
            return array_merge($cat, $seg);
        });

        // ── Products by Category count ────────────────────────
        $categoryProductCounts = Category::withCount('products')
            ->orderByDesc('products_count')
            ->take(5)
            ->get();

        $maxCatCount = $categoryProductCounts->max('products_count') ?: 1;

        // ── Key Metrics ────────────────────────────────────────
        $avgRevenuePerProduct = $totalProducts > 0 ? round($revenueThis / $totalProducts) : 0;
        $avgUnitsPerProduct   = $totalProducts > 0 ? round($unitsThis / $totalProducts, 1) : 0;

        $avgRating = round(DB::table('product_reviews')->avg('rating') ?? 0, 1);

        $returnsCount     = OrderReturn::whereBetween('created_at', [$start, $end])->count();
        $totalOrdersCount = Order::where('payment_status', 'paid')->whereBetween('created_at', [$start, $end])->count();
        $returnRate       = $totalOrdersCount > 0 ? round(($returnsCount / $totalOrdersCount) * 100, 1) : 0;

        $productsWithReviews = Product::has('reviews')->count();
        $reviewedPct         = $totalProducts > 0 ? round(($productsWithReviews / $totalProducts) * 100) : 0;

        // Placeholder until real page-view tracking exists.
        $conversionRate = $totalOrdersCount > 0 ? round(($totalOrdersCount / max($totalOrdersCount * 26, 1)) * 100, 1) : 0;

        // ── Top Rated Products ─────────────────────────────────
        $topRated = Product::withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->having('reviews_avg_rating', '>', 0)
            ->orderByDesc('reviews_avg_rating')
            ->take(4)
            ->get();

        return compact(
            'totalProducts', 'newProductsCount',
            'unitsThis', 'unitsGrowth',
            'revenueThis', 'revenueGrowth',
            'outOfStockNow', 'outOfStockDelta',
            'topBarProducts', 'maxUnits',
            'trendLabels', 'trendSeries', 'trendPoints', 'trendCoords',
            'donutCategories', 'donutSegments', 'totalCatRevenue',
            'categoryProductCounts', 'maxCatCount',
            'avgRevenuePerProduct', 'avgUnitsPerProduct',
            'avgRating', 'returnRate', 'reviewedPct',
            'conversionRate',
            'topRated'
        );
    }

    /**
     * Builds the (unexecuted) filtered/sorted product query shared by the
     * on-screen paginated table, the CSV export, and the PDF export — so all
     * three always reflect the same search/category/status/sort filters.
     */
    private function buildProductsQuery(
        Carbon $start,
        Carbon $end,
        Carbon $prevStart,
        Carbon $prevEnd,
        string $search,
        $categoryId,
        string $status,
        string $sortBy
    ) {
        $salesSubquery = OrderItem::join('orders', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.payment_status', 'paid')
            ->whereBetween('orders.created_at', [$start, $end])
            ->select(
                'order_items.product_id',
                DB::raw('SUM(order_items.quantity) as units_sold'),
                DB::raw('SUM(order_items.total) as revenue'),
                DB::raw('COUNT(DISTINCT order_items.order_id) as order_count')
            )
            ->groupBy('order_items.product_id');

        $prevSalesSubquery = OrderItem::join('orders', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.payment_status', 'paid')
            ->whereBetween('orders.created_at', [$prevStart, $prevEnd])
            ->select('order_items.product_id', DB::raw('SUM(order_items.total) as prev_revenue'))
            ->groupBy('order_items.product_id');

        $query = Product::query()
            ->leftJoinSub($salesSubquery, 'sales', 'products.id', '=', 'sales.product_id')
            ->leftJoinSub($prevSalesSubquery, 'prev_sales', 'products.id', '=', 'prev_sales.product_id')
            ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
            ->leftJoin('product_images as default_img', function ($join) {
                $join->on('default_img.product_id', '=', 'products.id')
                     ->where('default_img.is_default', 1);
            })
            ->withAvg('reviews', 'rating')
            ->select(
                'products.id',
                'products.name',
                'products.sku',
                'products.stock',
                'products.status',
                'default_img.image as image',
                'categories.name as category_name',
                DB::raw('COALESCE(sales.units_sold, 0) as units_sold'),
                DB::raw('COALESCE(sales.revenue, 0) as revenue'),
                DB::raw('COALESCE(sales.order_count, 0) as order_count'),
                DB::raw('COALESCE(prev_sales.prev_revenue, 0) as prev_revenue')
            );

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('products.name', 'like', "%{$search}%")
                  ->orWhere('products.sku', 'like', "%{$search}%");
            });
        }

        if ($categoryId) {
            $query->where('products.category_id', $categoryId);
        }

        if ($status === 'active') {
            $query->where('products.status', 1)->where('products.stock', '>', 0);
        } elseif ($status === 'inactive') {
            $query->where('products.status', 0);
        } elseif ($status === 'out_of_stock') {
            $query->where('products.stock', '<=', 0);
        } elseif ($status === 'low_stock') {
            $query->whereBetween('products.stock', [1, 10]);
        }

        $query->orderBy(match ($sortBy) {
            'units'  => 'units_sold',
            'orders' => 'order_count',
            'stock'  => 'products.stock',
            'rating' => 'reviews_avg_rating',
            'newest' => 'products.created_at',
            default  => 'revenue',
        }, $sortBy === 'stock' ? 'asc' : 'desc');

        return $query;
    }

    /**
     * Adds the computed display fields (rank, growth, avg price, stock status)
     * to a single product row. Shared by the table, CSV export, and PDF export.
     */
    private function decorateProduct(Product $p, int $rank): Product
    {
        $prevRev  = (float) $p->prev_revenue;
        $thisRev  = (float) $p->revenue;
        $growth   = $prevRev > 0 ? round((($thisRev - $prevRev) / $prevRev) * 100, 1) : ($thisRev > 0 ? 100.0 : 0.0);
        $avgPrice = $p->units_sold > 0 ? round($p->revenue / $p->units_sold) : 0;

        $stockStatus = match (true) {
            $p->stock <= 0  => 'out_of_stock',
            $p->stock <= 10 => 'low_stock',
            !$p->status     => 'inactive',
            default         => 'active',
        };

        $stockPct = $p->stock > 0 ? min(round(($p->stock / 300) * 100), 100) : 0;

        $p->rank         = $rank;
        $p->growth       = $growth;
        $p->avg_price    = $avgPrice;
        $p->stock_status = $stockStatus;
        $p->stock_pct    = $stockPct;

        return $p;
    }

    private function percentChange($old, $new): float
    {
        if ($old <= 0) return $new > 0 ? 100.0 : 0.0;
        return round((($new - $old) / $old) * 100, 1);
    }

    private function buildSvgPolyline(array $series, float $maxVal, int $width, int $height): string
    {
        $n = count($series);
        if ($n === 0) return '';
        if ($maxVal === 0) $maxVal = 1;

        $points = [];
        foreach ($series as $i => $val) {
            $x = $n === 1 ? $width / 2 : ($i / ($n - 1)) * $width;
            $y = $height - (($val / $maxVal) * $height);
            $points[] = round($x, 1) . ',' . round($y, 1);
        }
        return implode(' ', $points);
    }
}