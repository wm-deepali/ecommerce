<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ndr;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class NdrReportController extends Controller
{
    private const OPEN_STATUSES     = ['pending', 'reattempt'];
    private const RESOLVED_STATUSES = ['delivered', 'rto', 'cancelled'];

    public function index(Request $request)
    {
        // ── Date range resolution (same pattern as SalesReportController) ──
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

        $prevEnd   = $start->copy()->subSecond();
        $prevStart = $prevEnd->copy()->subDays($days - 1)->startOfDay();

        $activePreset = $this->detectPreset($start, $end);

        // ── KPI: Total NDRs raised ───────────────────────────
        $ndrsThis = Ndr::whereBetween('created_at', [$start, $end])->count();
        $ndrsPrev = Ndr::whereBetween('created_at', [$prevStart, $prevEnd])->count();
        $ndrGrowth = $this->percentChange($ndrsPrev, $ndrsThis);
        // For NDR volume, a drop is good — flip the sense for the badge
        $ndrImproved = $ndrGrowth < -0.05;
        $ndrWorsened = $ndrGrowth > 0.05;

        // ── Status distribution for the period ───────────────
        $statusCounts = Ndr::whereBetween('created_at', [$start, $end])
            ->select('status', DB::raw('COUNT(*) as cnt'))
            ->groupBy('status')
            ->pluck('cnt', 'status');

        $deliveredThis = (int) ($statusCounts['delivered'] ?? 0);
        $rtoThis       = (int) ($statusCounts['rto'] ?? 0);
        $cancelledThis = (int) ($statusCounts['cancelled'] ?? 0);
        $openThis      = (int) ($statusCounts['pending'] ?? 0) + (int) ($statusCounts['reattempt'] ?? 0);
        $resolvedThis  = $deliveredThis + $rtoThis + $cancelledThis;

        $deliveryRecoveryRate = $resolvedThis > 0 ? round(($deliveredThis / $resolvedThis) * 100, 1) : 0;
        $rtoRate              = $resolvedThis > 0 ? round(($rtoThis / $resolvedThis) * 100, 1) : 0;

        // ── Previous period recovery rate (for KPI growth badge) ──
        $prevStatusCounts = Ndr::whereBetween('created_at', [$prevStart, $prevEnd])
            ->select('status', DB::raw('COUNT(*) as cnt'))
            ->groupBy('status')
            ->pluck('cnt', 'status');

        $deliveredPrev = (int) ($prevStatusCounts['delivered'] ?? 0);
        $rtoPrev       = (int) ($prevStatusCounts['rto'] ?? 0);
        $cancelledPrev = (int) ($prevStatusCounts['cancelled'] ?? 0);
        $resolvedPrev  = $deliveredPrev + $rtoPrev + $cancelledPrev;
        $recoveryRatePrev = $resolvedPrev > 0 ? round(($deliveredPrev / $resolvedPrev) * 100, 1) : 0;
        $recoveryDelta     = round($deliveryRecoveryRate - $recoveryRatePrev, 1);
        $recoveryImproved  = $recoveryDelta > 0.05;
        $recoveryWorsened  = $recoveryDelta < -0.05;

        // ── KPI: Avg attempts & avg resolution time ──────────
        $avgAttempts = round((float) Ndr::whereBetween('created_at', [$start, $end])->avg('attempt_count'), 1);

        $avgResolutionHours = Ndr::whereBetween('created_at', [$start, $end])
            ->whereIn('status', self::RESOLVED_STATUSES)
            ->whereNotNull('resolved_at')
            ->select(DB::raw('AVG(TIMESTAMPDIFF(HOUR, created_at, resolved_at)) as avg_hrs'))
            ->value('avg_hrs');

        $avgResolutionDays = $avgResolutionHours ? round($avgResolutionHours / 24, 1) : null;

        // ── NDR Trend Over Time (daily count) ────────────────
        $dailyTotals = Ndr::whereBetween('created_at', [$start, $end])
            ->select(DB::raw('DATE(created_at) as d'), DB::raw('COUNT(*) as cnt'))
            ->groupBy('d')
            ->pluck('cnt', 'd');

        [$trendLabels, $trendSeries, $granularity] = $this->bucketSeries($dailyTotals, $start, $end, $days);

        $worstDay = null;
        $worstDayCount = 0;
        if ($dailyTotals->isNotEmpty()) {
            $worstDayCount = (int) $dailyTotals->max();
            $worstDay = $dailyTotals->search($worstDayCount);
        }

        // ── NDR by Reason (donut) ─────────────────────────────
        $reasonRaw = Ndr::whereBetween('created_at', [$start, $end])
            ->select('reason', DB::raw('COUNT(*) as cnt'))
            ->groupBy('reason')
            ->orderByDesc('cnt')
            ->get();

        $palette = ['#b22222', '#916a00', '#303d89', '#6d28d9', '#8c9196'];
        $reasonBreakdown = collect();

        if ($ndrsThis > 0) {
            $top4 = $reasonRaw->take(4);
            $othersCount = $reasonRaw->skip(4)->sum('cnt');

            foreach ($top4 as $i => $row) {
                $reasonBreakdown->push([
                    'name'  => (new Ndr(['reason' => $row->reason]))->reason_label,
                    'count' => (int) $row->cnt,
                    'pct'   => round(($row->cnt / $ndrsThis) * 100),
                    'color' => $palette[$i],
                ]);
            }

            if ($othersCount > 0) {
                $reasonBreakdown->push([
                    'name'  => 'Other',
                    'count' => (int) $othersCount,
                    'pct'   => round(($othersCount / $ndrsThis) * 100),
                    'color' => $palette[4],
                ]);
            }
        }

        // ── Status Outcome Breakdown (bar) ───────────────────
        $statusBar = [
            'labels' => ['Pending', 'Reattempt', 'Delivered', 'RTO', 'Cancelled'],
            'data'   => [
                (int) ($statusCounts['pending'] ?? 0),
                (int) ($statusCounts['reattempt'] ?? 0),
                $deliveredThis,
                $rtoThis,
                $cancelledThis,
            ],
            'colors' => ['#916a00', '#0069d9', '#007a5e', '#b22222', '#8c9196'],
        ];

        // ── Daily Breakdown table (last 7 days) ──────────────
        $last7End   = $end->lessThan(now()) ? $end->copy()->endOfDay() : now()->endOfDay();
        $last7Start = $last7End->copy()->subDays(6)->startOfDay();

        $rawDaily = Ndr::whereBetween('created_at', [$last7Start, $last7End])
            ->select(
                DB::raw('DATE(created_at) as d'),
                DB::raw('COUNT(*) as raised'),
                DB::raw("SUM(CASE WHEN status = 'delivered' THEN 1 ELSE 0 END) as delivered"),
                DB::raw("SUM(CASE WHEN status = 'rto' THEN 1 ELSE 0 END) as rto")
            )
            ->groupBy('d')
            ->get()
            ->keyBy('d');

        $dailyBreakdown = [];
        for ($d = $last7Start->copy(); $d->lte($last7End); $d->addDay()) {
            $key = $d->format('Y-m-d');
            $row = $rawDaily[$key] ?? null;
            $dailyBreakdown[] = [
                'date'      => $d->copy(),
                'raised'    => (int) ($row->raised ?? 0),
                'delivered' => (int) ($row->delivered ?? 0),
                'rto'       => (int) ($row->rto ?? 0),
            ];
        }
        $dailyBreakdown = array_reverse($dailyBreakdown);
        $weekTotalRaised    = array_sum(array_column($dailyBreakdown, 'raised'));
        $weekTotalDelivered = array_sum(array_column($dailyBreakdown, 'delivered'));
        $weekTotalRto       = array_sum(array_column($dailyBreakdown, 'rto'));

        // ── Worst-affected orders (highest attempt_count, still open) ──
        $worstOrders = Ndr::with('order')
            ->whereBetween('created_at', [$start, $end])
            ->whereIn('status', self::OPEN_STATUSES)
            ->orderByDesc('attempt_count')
            ->take(5)
            ->get()
            ->map(fn ($n) => [
                'order_number' => $n->order->order_number ?? '—',
                'customer'     => $n->order->customer_name ?? '—',
                'reason'       => $n->reason_label,
                'attempts'     => $n->attempt_count,
                'status'       => ucfirst($n->status),
                'next_attempt' => optional($n->next_attempt_date)->format('d M Y'),
                'ndr_id'       => $n->id,
            ]);

        $viewData = compact(
            'start', 'end', 'activePreset',
            'ndrsThis', 'ndrGrowth', 'ndrImproved', 'ndrWorsened',
            'deliveredThis', 'rtoThis', 'cancelledThis', 'openThis', 'resolvedThis',
            'deliveryRecoveryRate', 'rtoRate',
            'recoveryDelta', 'recoveryImproved', 'recoveryWorsened',
            'avgAttempts', 'avgResolutionDays',
            'trendLabels', 'trendSeries', 'granularity',
            'worstDay', 'worstDayCount',
            'reasonBreakdown',
            'statusBar',
            'dailyBreakdown', 'weekTotalRaised', 'weekTotalDelivered', 'weekTotalRto',
            'worstOrders'
        );

        return view('admin.reports.ndr', $viewData);
    }

    // ────────────────────────────────────────────────────────
    // Export (CSV — reuses the same shape as NdrController::export)
    // ────────────────────────────────────────────────────────

    public function export(Request $request)
    {
        $end = $request->filled('end_date')
            ? Carbon::parse($request->end_date)->endOfDay()
            : now()->endOfDay();

        $start = $request->filled('start_date')
            ? Carbon::parse($request->start_date)->startOfDay()
            : now()->startOfMonth()->startOfDay();

        $ndrs = Ndr::with('order')
            ->whereBetween('created_at', [$start, $end])
            ->latest()
            ->get();

        $filename = 'ndr-report_' . $start->format('Y-m-d') . '_to_' . $end->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($ndrs) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'NDR ID', 'Order', 'Customer', 'Reason', 'Status',
                'Attempts', 'Next Attempt', 'Marked By', 'Raised On', 'Resolved On',
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

    // ────────────────────────────────────────────────────────
    // Private helpers (same logic as SalesReportController)
    // ────────────────────────────────────────────────────────

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

        if ($start->isSameDay($today) && $end->isSameDay($today))                                                                       return 'today';
        if ($start->isSameDay($today->copy()->subDay()) && $end->isSameDay($today->copy()->subDay()))                                    return 'yesterday';
        if ($start->isSameDay($today->copy()->startOfMonth()) && $end->isSameDay($today))                                               return 'this_month';
        if ($start->isSameDay($today->copy()->subMonth()->startOfMonth()) && $end->isSameDay($today->copy()->subMonth()->endOfMonth()))  return 'last_month';
        if ($start->isSameDay($today->copy()->startOfYear()) && $end->isSameDay($today))                                                return 'this_year';

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
                $data[]   = (int) ($dailyTotals[$d->format('Y-m-d')] ?? 0);
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
                $data[]   = (int) $total;
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
                $data[]   = (int) $total;
            }
        }

        return [$labels, $data, $granularity];
    }
}