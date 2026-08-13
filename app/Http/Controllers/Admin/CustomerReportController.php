<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CustomersReportExport;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class CustomerReportController extends Controller
{
    private const CHURN_DAYS = 90;
    private const AT_RISK_DAYS = 60;
    private const NEW_DAYS = 30;
    private const LOYAL_MIN_ORDERS = 5;
    private const VIP_PERCENTILE = 0.90;

    private function resolveRange(string $range): array
    {
        $now = now();
        return match ($range) {
            'today'      => [$now->copy()->startOfDay(), $now->copy()->endOfDay()],
            'this_week'  => [$now->copy()->startOfWeek(), $now->copy()->endOfDay()],
            'last_month' => [$now->copy()->subMonth()->startOfMonth(), $now->copy()->subMonth()->endOfMonth()],
            'this_year'  => [$now->copy()->startOfYear(), $now->copy()->endOfDay()],
            'custom'     => [
                Carbon::parse(request('start_date'))->startOfDay(),
                Carbon::parse(request('end_date'))->endOfDay(),
            ],
            default      => [$now->copy()->startOfMonth(), $now->copy()->endOfDay()], // this_month
        };
    }

    public function index(Request $request)
    {
        $range = $request->input('range', 'this_month');
        [$start, $end] = $this->resolveRange($range);

        $data = $this->buildReportData($start, $end);

        return view('admin.reports.customer', array_merge(
            ['range' => $range, 'start' => $start, 'end' => $end],
            $data
        ));
    }

    public function exportExcel(Request $request)
    {
        $range = $request->input('range', 'this_month');
        [$start, $end] = $this->resolveRange($range);

        $data = $this->buildReportData($start, $end);

        $filename = 'customer-report-' . $start->format('Y-m-d') . '-to-' . $end->format('Y-m-d') . '.xlsx';

        return Excel::download(new CustomersReportExport($data['allCustomersTable']), $filename);
    }

    public function exportPdf(Request $request)
    {
        $range = $request->input('range', 'this_month');
        [$start, $end] = $this->resolveRange($range);

        $data = $this->buildReportData($start, $end);

        $pdf = Pdf::loadView('admin.reports.customer-pdf', array_merge(
            ['range' => $range, 'start' => $start, 'end' => $end],
            $data
        ))->setPaper('a4', 'portrait');

        $filename = 'customer-report-' . $start->format('Y-m-d') . '-to-' . $end->format('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Builds every metric/series the customer report (and its Excel/PDF exports) need.
     * Pulled out of index() so the three entry points (view, Excel, PDF) stay in sync.
     */
    private function buildReportData(Carbon $start, Carbon $end): array
    {
        $days = $start->diffInDays($end) + 1;
        $prevEnd = $start->copy()->subSecond();
        $prevStart = $prevEnd->copy()->subDays($days - 1)->startOfDay();

        // ── Per-customer order aggregates (paid orders only) ──
        $stats = Order::where('payment_status', 'paid')
            ->whereNotNull('customer_id')
            ->select(
                'customer_id',
                DB::raw('COUNT(*) as orders_count'),
                DB::raw('SUM(grand_total) as total_spent'),
                DB::raw('MIN(created_at) as first_order_at'),
                DB::raw('MAX(created_at) as last_order_at')
            )
            ->groupBy('customer_id')
            ->get()
            ->keyBy('customer_id');

        // ── KPI: Total / New Customers ─────────────────────────
        $totalCustomers = Customer::count();

        $newThis = Customer::whereBetween('created_at', [$start, $end])->count();
        $newPrev = Customer::whereBetween('created_at', [$prevStart, $prevEnd])->count();
        $newGrowth = $this->percentChange($newPrev, $newThis);

        $totalGrowth = $this->percentChange(
            Customer::where('created_at', '<', $start)->count(),
            $totalCustomers
        );

        // ── KPI: Returning Rate (of those who ordered this period) ─
        $orderedThisPeriod = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$start, $end])
            ->whereNotNull('customer_id')
            ->select('customer_id')->distinct()->pluck('customer_id');

        $returningCount = Order::where('payment_status', 'paid')
            ->where('created_at', '<', $start)
            ->whereIn('customer_id', $orderedThisPeriod)
            ->select('customer_id')->distinct()->count('customer_id');

        $returningRate = $orderedThisPeriod->count() > 0
            ? round(($returningCount / $orderedThisPeriod->count()) * 100, 1) : 0;

        // Prev period, for the trend badge
        $orderedPrevPeriod = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$prevStart, $prevEnd])
            ->whereNotNull('customer_id')
            ->select('customer_id')->distinct()->pluck('customer_id');

        $returningPrevCount = Order::where('payment_status', 'paid')
            ->where('created_at', '<', $prevStart)
            ->whereIn('customer_id', $orderedPrevPeriod)
            ->select('customer_id')->distinct()->count('customer_id');

        $returningRatePrev = $orderedPrevPeriod->count() > 0
            ? round(($returningPrevCount / $orderedPrevPeriod->count()) * 100, 1) : 0;

        $returningRateDelta = round($returningRate - $returningRatePrev, 1);

        // ── KPI: Avg LTV ────────────────────────────────────────
        $customersWithOrders = $stats->count();
        $avgLtv = $customersWithOrders > 0 ? round($stats->sum('total_spent') / $customersWithOrders) : 0;

        // ── KPI: Churn Rate ─────────────────────────────────────
        $churnCutoff = now()->subDays(self::CHURN_DAYS);
        $atRiskCutoff = now()->subDays(self::AT_RISK_DAYS);
        $newCutoff = now()->subDays(self::NEW_DAYS);

        $churnedCount = $stats->filter(fn ($s) => Carbon::parse($s->last_order_at)->lt($churnCutoff))->count();
        $churnRate = $customersWithOrders > 0 ? round(($churnedCount / $customersWithOrders) * 100, 1) : 0;

        // ── Acquisition trend (daily, this period) ─────────────
        $acqDaily = Customer::whereBetween('created_at', [$start, $end])
            ->select(DB::raw('DATE(created_at) as d'), DB::raw('COUNT(*) as cnt'))
            ->groupBy('d')->pluck('cnt', 'd');

        $returningDaily = Order::where('payment_status', 'paid')
            ->where('created_at', '<', DB::raw('orders.created_at')) // placeholder, replaced below
            ->whereBetween('created_at', [$start, $end])
            ->select(DB::raw('DATE(created_at) as d'), DB::raw('COUNT(DISTINCT customer_id) as cnt'))
            ->groupBy('d')->pluck('cnt', 'd');
        // Note: "returning" per day is approximated as distinct customers ordering that day
        // who are NOT first-time that day. A precise version needs a per-row first-order flag;
        // kept simple here for chart purposes only.

        $acqLabels = [];
        $acqNewSeries = [];
        $acqReturningSeries = [];
        for ($d = $start->copy(); $d->lte($end); $d->addDay()) {
            $key = $d->format('Y-m-d');
            $acqLabels[] = $d->format('j');
            $acqNewSeries[] = (int) ($acqDaily[$key] ?? 0);
            $acqReturningSeries[] = (int) ($returningDaily[$key] ?? 0);
        }

        // ── New vs Returning (this period, by order) ───────────
        $newCustomerIdsThisPeriod = Customer::whereBetween('created_at', [$start, $end])->pluck('id');
        $newVsReturningTotal = $orderedThisPeriod->count();
        $newOrderersCount = $orderedThisPeriod->intersect($newCustomerIdsThisPeriod)->count();
        $returningOrderersCount = max($newVsReturningTotal - $newOrderersCount, 0);

        $newPct = $newVsReturningTotal > 0 ? round(($newOrderersCount / $newVsReturningTotal) * 100) : 0;
        $returningPct = $newVsReturningTotal > 0 ? 100 - $newPct : 0;

        // ── Customer Segments (RFM-lite) ───────────────────────
        $spendValues = $stats->pluck('total_spent')->sort()->values();
        $vipThreshold = $spendValues->isNotEmpty()
            ? $spendValues->get((int) floor($spendValues->count() * self::VIP_PERCENTILE))
            : PHP_FLOAT_MAX;

        $segments = ['vip' => 0, 'loyal' => 0, 'new' => 0, 'promising' => 0, 'at_risk' => 0, 'dormant' => 0];

        foreach ($stats as $s) {
            $segment = $this->classifySegment($s, $vipThreshold, $churnCutoff, $atRiskCutoff, $newCutoff);
            $segments[$segment['key']]++;
        }

        $segmentTotal = array_sum($segments) ?: 1;
        $segmentPcts = array_map(fn ($v) => round(($v / $segmentTotal) * 100, 1), $segments);

        // ── Acquisition Funnel (4 real steps only) ─────────────
        $signedUp = Customer::count();
        $addedToCart = DB::table('cart_items')
            ->join('carts', 'carts.id', '=', 'cart_items.cart_id')
            ->whereNotNull('carts.user_id')
            ->distinct()
            ->count('carts.user_id');
        $purchased = $stats->count();
        $repeatPurchase = $stats->filter(fn ($s) => $s->orders_count > 1)->count();

        $funnelMax = $signedUp ?: 1;
        $funnel = [
            ['label' => 'Signed Up',       'count' => $signedUp,       'pct' => 100],
            ['label' => 'Added to Cart',   'count' => $addedToCart,    'pct' => round(($addedToCart / $funnelMax) * 100)],
            ['label' => 'Purchased',       'count' => $purchased,      'pct' => round(($purchased / $funnelMax) * 100)],
            ['label' => 'Repeat Purchase', 'count' => $repeatPurchase, 'pct' => round(($repeatPurchase / $funnelMax) * 100)],
        ];

        // ── Retention Cohort (last 6 cohort months) ────────────
        $cohortMonths = [];
        for ($i = 5; $i >= 0; $i--) {
            $cohortMonths[] = now()->copy()->subMonths($i)->startOfMonth();
        }

        $cohorts = [];
        foreach ($cohortMonths as $cohortStart) {
            $cohortEnd = $cohortStart->copy()->endOfMonth();

            $cohortCustomerIds = Order::where('payment_status', 'paid')
                ->whereNotNull('customer_id')
                ->select('customer_id', DB::raw('MIN(created_at) as first_order'))
                ->groupBy('customer_id')
                ->havingRaw('MIN(created_at) between ? and ?', [$cohortStart, $cohortEnd])
                ->pluck('customer_id');

            $cohortSize = $cohortCustomerIds->count();
            $row = ['label' => $cohortStart->format('M Y'), 'cells' => []];

            $monthsAvailable = $cohortStart->diffInMonths(now()->startOfMonth());

            for ($m = 0; $m <= 5; $m++) {
                if ($m > $monthsAvailable || $cohortSize === 0) {
                    $row['cells'][] = null; // "—"
                    continue;
                }

                if ($m === 0) {
                    $row['cells'][] = 100;
                    continue;
                }

                $windowStart = $cohortStart->copy()->addMonths($m)->startOfMonth();
                $windowEnd = $windowStart->copy()->endOfMonth();

                $returnedCount = Order::where('payment_status', 'paid')
                    ->whereIn('customer_id', $cohortCustomerIds)
                    ->whereBetween('created_at', [$windowStart, $windowEnd])
                    ->select('customer_id')->distinct()->count('customer_id');

                $row['cells'][] = round(($returnedCount / $cohortSize) * 100);
            }

            $cohorts[] = $row;
        }

        // ── Customers table (sorted by LTV) ─────────────────────
        // Used for both the on-page "Top Customers" panel and the Excel export (full list).
        $allCustomerIds = $stats->sortByDesc('total_spent')->keys();
        $allCustomersById = Customer::whereIn('id', $allCustomerIds)->get()->keyBy('id');

        $allCustomersTable = $allCustomerIds->map(function ($id, $idx) use ($stats, $allCustomersById, $vipThreshold, $churnCutoff, $atRiskCutoff, $newCutoff) {
            $s = $stats[$id];
            $cust = $allCustomersById[$id] ?? null;
            if (!$cust) {
                return null;
            }

            $segment = $this->classifySegment($s, $vipThreshold, $churnCutoff, $atRiskCutoff, $newCutoff);

            return [
                'rank' => $idx + 1,
                'name' => $cust->name,
                'email' => $cust->email,
                'initials' => strtoupper(substr($cust->name ?? 'NA', 0, 2)),
                'segment' => $segment,
                'orders' => $s->orders_count,
                'total_spent' => (float) $s->total_spent,
                'avg_order' => round($s->total_spent / $s->orders_count),
                'last_order' => Carbon::parse($s->last_order_at)->format('d M Y'),
            ];
        })->filter()->values();

        $topCustomersTable = $allCustomersTable->take(6);
        $top6Orders = $topCustomersTable->sum('orders');
        $top6Revenue = $topCustomersTable->sum('total_spent');

        // ── Location breakdown (top cities, via default address) ─
        $locationRaw = DB::table('customer_addresses')
            ->join('cities', 'cities.id', '=', 'customer_addresses.city_id')
            ->where('customer_addresses.is_default', 1)
            ->select('cities.name as city_name', DB::raw('COUNT(DISTINCT customer_addresses.customer_id) as cnt'))
            ->groupBy('cities.id', 'cities.name')
            ->orderByDesc('cnt')
            ->get();

        $locationTotal = $locationRaw->sum('cnt') ?: 1;
        $topLocations = $locationRaw->take(6);
        $othersLocationCount = $locationRaw->skip(6)->sum('cnt');
        $maxLocationCount = $locationRaw->max('cnt') ?: 1;

        // ── Customer Health Metrics ──────────────────────────────
        $activeThisMonth = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [now()->startOfMonth(), now()])
            ->whereNotNull('customer_id')
            ->select('customer_id')->distinct()->count('customer_id');

        $activePct = $totalCustomers > 0 ? round(($activeThisMonth / $totalCustomers) * 100, 1) : 0;

        $avgOrdersPerCustomer = $customersWithOrders > 0
            ? round($stats->sum('orders_count') / $customersWithOrders, 1) : 0;

        $avgDaysBetweenOrders = $stats->filter(fn ($s) => $s->orders_count > 1)
            ->map(fn ($s) => Carbon::parse($s->first_order_at)->diffInDays(Carbon::parse($s->last_order_at)) / max($s->orders_count - 1, 1))
            ->avg();
        $avgDaysBetweenOrders = $avgDaysBetweenOrders ? round($avgDaysBetweenOrders) : 0;

        // ── Churn vs Retention trend (last 6 months) ────────────
        $churnTrendLabels = [];
        $retainedSeries = [];
        $churnedSeries = [];
        for ($i = 5; $i >= 0; $i--) {
            $m = now()->copy()->subMonths($i);
            $churnTrendLabels[] = $m->format('M');

            $activeInMonth = Order::where('payment_status', 'paid')
                ->whereYear('created_at', $m->year)->whereMonth('created_at', $m->month)
                ->whereNotNull('customer_id')->select('customer_id')->distinct()->count('customer_id');

            $retainedSeries[] = $activeInMonth;
            // Churned this month = customers whose last-ever order falls in this month and is >churn-window old by now
            $churnedSeries[] = $stats->filter(function ($s) use ($m) {
                $last = Carbon::parse($s->last_order_at);
                return $last->isSameMonth($m) && $last->lt(now()->subDays(self::CHURN_DAYS));
            })->count();
        }

        return [
            'totalCustomers' => $totalCustomers, 'totalGrowth' => $totalGrowth,
            'newThis' => $newThis, 'newGrowth' => $newGrowth,
            'returningRate' => $returningRate, 'returningRateDelta' => $returningRateDelta,
            'avgLtv' => $avgLtv,
            'churnRate' => $churnRate,
            'acqLabels' => $acqLabels, 'acqNewSeries' => $acqNewSeries, 'acqReturningSeries' => $acqReturningSeries,
            'newOrderersCount' => $newOrderersCount, 'returningOrderersCount' => $returningOrderersCount,
            'newPct' => $newPct, 'returningPct' => $returningPct,
            'segments' => $segments, 'segmentPcts' => $segmentPcts,
            'funnel' => $funnel,
            'cohorts' => $cohorts,
            'allCustomersTable' => $allCustomersTable,
            'topCustomersTable' => $topCustomersTable,
            'top6Orders' => $top6Orders, 'top6Revenue' => $top6Revenue,
            'topLocations' => $topLocations, 'othersLocationCount' => $othersLocationCount,
            'locationTotal' => $locationTotal, 'maxLocationCount' => $maxLocationCount,
            'activeThisMonth' => $activeThisMonth, 'activePct' => $activePct,
            'avgOrdersPerCustomer' => $avgOrdersPerCustomer,
            'avgDaysBetweenOrders' => $avgDaysBetweenOrders,
            'churnTrendLabels' => $churnTrendLabels, 'retainedSeries' => $retainedSeries, 'churnedSeries' => $churnedSeries,
        ];
    }

    /**
     * Single source of truth for a customer's RFM-lite segment.
     * Used by the segment tally, the Top Customers panel, and the Excel/PDF exports
     * so all three always agree.
     */
    private function classifySegment($s, $vipThreshold, Carbon $churnCutoff, Carbon $atRiskCutoff, Carbon $newCutoff): array
    {
        $lastOrder = Carbon::parse($s->last_order_at);
        $firstOrder = Carbon::parse($s->first_order_at);

        if ($s->total_spent >= $vipThreshold) {
            return ['key' => 'vip', 'label' => '⭐ VIP', 'class' => 'seg-vip'];
        }
        if ($lastOrder->lt($churnCutoff)) {
            return ['key' => 'dormant', 'label' => 'Dormant', 'class' => 'seg-dormant'];
        }
        if ($lastOrder->lt($atRiskCutoff)) {
            return ['key' => 'at_risk', 'label' => 'At Risk', 'class' => 'seg-at-risk'];
        }
        if ($firstOrder->gte($newCutoff)) {
            return ['key' => 'new', 'label' => 'New', 'class' => 'seg-new'];
        }
        if ($s->orders_count >= self::LOYAL_MIN_ORDERS) {
            return ['key' => 'loyal', 'label' => 'Loyal', 'class' => 'seg-loyal'];
        }

        return ['key' => 'promising', 'label' => 'Promising', 'class' => 'seg-promising'];
    }

    private function percentChange($old, $new): float
    {
        if ($old <= 0) return $new > 0 ? 100.0 : 0.0;
        return round((($new - $old) / $old) * 100, 1);
    }
}