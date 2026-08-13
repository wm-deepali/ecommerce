<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderReturn;
use App\Models\OrderStatusHistory; // ← confirm this is the correct model name
use Carbon\Carbon;
use Illuminate\Http\Request;


class OrderReportController extends Controller
{
    public function index(Request $request)
    {
         $preset = $request->input('preset', 'this_month');
    [$from, $to] = $this->resolveRange($preset, $request->input('start_date'), $request->input('end_date'));

    $data = $this->buildReportData($from, $to);
    $data['preset'] = $preset;
    
         return view('admin.reports.order-reports', $data);
      
    }
    
    
    protected function buildReportData(Carbon $from, Carbon $to): array
{
    
    
        $days     = $from->diffInDays($to) + 1;
        $prevTo   = $from->copy()->subDay();
        $prevFrom = $prevTo->copy()->subDays($days - 1);

        $baseQuery = fn () => Order::whereBetween('created_at', [$from->copy()->startOfDay(), $to->copy()->endOfDay()]);
        $prevQuery = fn () => Order::whereBetween('created_at', [$prevFrom->copy()->startOfDay(), $prevTo->copy()->endOfDay()]);

        $totalOrders     = $baseQuery()->count();
        $prevTotalOrders = $prevQuery()->count();

        $delivered     = $baseQuery()->where('status', 'delivered')->count();
        $cancelled     = $baseQuery()->where('status', 'cancelled')->count();
        $prevCancelled = $prevQuery()->where('status', 'cancelled')->count();

        $returnedCount = OrderReturn::whereBetween('created_at', [$from, $to])->count();

        $deliveryRate    = $totalOrders > 0 ? round($delivered / $totalOrders * 100) : 0;
        $ordersGrowth    = $prevTotalOrders > 0 ? round((($totalOrders - $prevTotalOrders) / $prevTotalOrders) * 100, 1) : null;
        $cancelledGrowth = $prevCancelled > 0 ? round((($cancelled - $prevCancelled) / $prevCancelled) * 100, 1) : null;

        // ── Avg fulfilment time — order created_at → latest 'delivered' statusHistory ──
        $deliveredOrders = $baseQuery()
            ->where('status', 'delivered')
            ->with(['statusHistory' => fn ($q) => $q->where('status', 'delivered')->latest()])
            ->get();

        $fulfilmentDays = $deliveredOrders->map(function ($order) {
            $deliveredAt = $order->statusHistory->first()?->created_at;
            return $deliveredAt ? $order->created_at->diffInDays($deliveredAt) : null;
        })->filter(fn ($d) => $d !== null)->values();

        $avgFulfilment = $fulfilmentDays->count() > 0 ? round($fulfilmentDays->avg(), 1) : 0;
        $returnRate    = $totalOrders > 0 ? round($returnedCount / $totalOrders * 100, 1) : 0;

        // ── Order volume trend ──
        $trendRaw = $baseQuery()->selectRaw('DATE(created_at) as d, COUNT(*) as c')
            ->groupBy('d')->pluck('c', 'd');

        $trendLabels = [];
        $trendData   = [];
        $cursor      = $from->copy();
        while ($cursor->lte($to)) {
            $key = $cursor->format('Y-m-d');
            $trendLabels[] = $cursor->format('j M');
            $trendData[]   = (int) ($trendRaw[$key] ?? 0);
            $cursor->addDay();
        }
        $busiestIdx   = count($trendData) ? array_search(max($trendData), $trendData) : null;
        $busiestDay   = $busiestIdx !== null ? $from->copy()->addDays($busiestIdx)->format('d M Y') : null;
        $busiestCount = $busiestIdx !== null ? $trendData[$busiestIdx] : 0;

        // ── Status donut ──
        $statusCounts = $baseQuery()->selectRaw('status, COUNT(*) as c')->groupBy('status')->pluck('c', 'status');
        $statusMap = [
            'delivered'  => ['label' => 'Delivered',  'color' => '#007a5e'],
            'processing' => ['label' => 'Processing', 'color' => '#0069d9'],
            'pending'    => ['label' => 'Pending',    'color' => '#916a00'],
            'cancelled'  => ['label' => 'Cancelled',  'color' => '#b22222'],
            'shipped'    => ['label' => 'Shipped',    'color' => '#6d28d9'],
        ];
        $statusBreakdown = [];
        foreach ($statusMap as $key => $meta) {
            $count = (int) ($statusCounts[$key] ?? 0);
            $statusBreakdown[] = [
                'label' => $meta['label'],
                'color' => $meta['color'],
                'count' => $count,
                'pct'   => $totalOrders > 0 ? round($count / $totalOrders * 100) : 0,
            ];
        }

        // ── City chart (top 7) ──
        $cityData = $baseQuery()->whereNotNull('city_id')
            ->selectRaw('city_id, COUNT(*) as c')
            ->groupBy('city_id')
            ->orderByDesc('c')
            ->limit(7)
            ->with('city')
            ->get()
            ->map(fn ($row) => ['name' => $row->city?->name ?? 'Unknown', 'count' => $row->c]);

        // ── Fulfilment distribution ──
        $buckets = ['1d' => 0, '2d' => 0, '3d' => 0, '4d' => 0, '5d' => 0, '6d' => 0, '7d+' => 0];
        foreach ($fulfilmentDays as $d) {
            $key = $d >= 7 ? '7d+' : max(1, (int) $d) . 'd';
            if (!isset($buckets[$key])) $key = '7d+';
            $buckets[$key]++;
        }

        // ── Period comparison — first half vs second half, this period vs previous ──
        $mid     = $from->copy()->addDays(intdiv($days, 2));
        $prevMid = $prevFrom->copy()->addDays(intdiv($days, 2));

        $firstHalfCurrent  = $baseQuery()->where('created_at', '<', $mid)->count();
        $secondHalfCurrent = $baseQuery()->where('created_at', '>=', $mid)->count();
        $firstHalfPrev     = $prevQuery()->where('created_at', '<', $prevMid)->count();
        $secondHalfPrev    = $prevQuery()->where('created_at', '>=', $prevMid)->count();

        // ── Daily breakdown — last 7 days within range ──
        $tempDays = [];
        for ($i = 0; $i < 7; $i++) {
            $d = $to->copy()->subDays($i);
            if ($d->lt($from)) break;

            $tempDays[] = [
                'date'      => $d,
                'orders'    => Order::whereDate('created_at', $d)->count(),
                'delivered' => Order::whereDate('created_at', $d)->where('status', 'delivered')->count(),
                'cancelled' => Order::whereDate('created_at', $d)->where('status', 'cancelled')->count(),
            ];
        }
        $dailyBreakdown = [];
        foreach ($tempDays as $idx => $row) {
            $yesterday = $tempDays[$idx + 1] ?? null;
            $row['vs_yesterday'] = $yesterday && $yesterday['orders'] > 0
                ? round((($row['orders'] - $yesterday['orders']) / $yesterday['orders']) * 100, 1)
                : null;
            $dailyBreakdown[] = $row;
        }
        $sevenDayTotals = [
            'orders'    => array_sum(array_column($tempDays, 'orders')),
            'delivered' => array_sum(array_column($tempDays, 'delivered')),
            'cancelled' => array_sum(array_column($tempDays, 'cancelled')),
        ];

        // ── Order list table ──
        $orders = $baseQuery()->with(['items', 'courier', 'city'])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $periodItemsTotal = (clone $baseQuery())
    ->withCount('items')
    ->get()
    ->sum('items_count');
        $periodAmountTotal = $baseQuery()->sum('grand_total');

        // ── Top cancellation reasons — grouped by the free-text note on the 'cancelled' statusHistory entry ──
        $cancelReasons = OrderStatusHistory::whereHas('order', function ($q) use ($from, $to) {
                $q->whereBetween('created_at', [$from, $to])->where('status', 'cancelled');
            })
            ->where('status', 'cancelled')
            ->selectRaw('remarks, COUNT(*) as c')
            ->groupBy('remarks')
            ->orderByDesc('c')
            ->limit(5)
            ->get();

        $cancelReasonsTotal = $cancelReasons->sum('c');

        // ── Key metrics ──
        $processingShipped = $baseQuery()->whereIn('status', ['processing', 'shipped'])->count();
        $pending           = $baseQuery()->where('status', 'pending')->count();
        $codCount          = $baseQuery()->where('payment_method', 'cod')->count();
        $peakHour          = $baseQuery()->selectRaw('HOUR(created_at) as h, COUNT(*) as c')
            ->groupBy('h')->orderByDesc('c')->first();
        $avgOrderValue = $totalOrders > 0 ? round($periodAmountTotal / $totalOrders) : 0;
        
        return compact(
    'from', 'to',
    'totalOrders',
    'delivered',
    'cancelled',
    'deliveryRate',
    'ordersGrowth',
    'cancelledGrowth',
    'avgFulfilment',
    'returnRate',
    'returnedCount',
    'trendLabels',
    'trendData',
    'busiestDay',
    'busiestCount',
    'statusBreakdown',
    'cityData',
    'buckets',
    'firstHalfCurrent',
    'secondHalfCurrent',
    'firstHalfPrev',
    'secondHalfPrev',
    'dailyBreakdown',
    'sevenDayTotals',
    'orders',
    'periodItemsTotal',
    'periodAmountTotal',
    'cancelReasons',
    'cancelReasonsTotal',
    'processingShipped',
    'pending',
    'codCount',
    'peakHour',
    'avgOrderValue'
);
        
}

public function exportExcel(Request $request)
{
    $preset = $request->input('preset', 'this_month');
    [$from, $to] = $this->resolveRange($preset, $request->input('start_date'), $request->input('end_date'));

    $filename = 'order-report-' . $from->format('Y-m-d') . '-to-' . $to->format('Y-m-d') . '.xlsx';

    return \Maatwebsite\Excel\Facades\Excel::download(
        new \App\Exports\OrderReportExport($from, $to),
        $filename
    );
}

public function exportPdf(Request $request)
{
    $preset = $request->input('preset', 'this_month');
    [$from, $to] = $this->resolveRange($preset, $request->input('start_date'), $request->input('end_date'));

    // Reuse the same data-building logic as index() by calling it and
    // pulling the view data back out, so PDF/Excel/HTML always stay in sync.
    $data = $this->buildReportData($from, $to);

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.reports.order-reports-pdf', $data)
        ->setPaper('a4', 'landscape')
        ->setOptions([
            'defaultFont' => 'DejaVu Sans',
            'isRemoteEnabled' => false,
            'isHtml5ParserEnabled' => true,
            'dpi' => 150,
        ]);

    $filename = 'Order-Report-' . $from->format('d-M-Y') . '-to-' . $to->format('d-M-Y') . '.pdf';

    return $pdf->download($filename);
}

    protected function resolveRange(string $preset, ?string $startDate, ?string $endDate): array
    {
        $today = Carbon::today();

        return match ($preset) {
            'today'      => [$today->copy(), $today->copy()],
            'yesterday'  => [$today->copy()->subDay(), $today->copy()->subDay()],
            'last_month' => [$today->copy()->subMonthNoOverflow()->startOfMonth(), $today->copy()->subMonthNoOverflow()->endOfMonth()],
            'this_year'  => [$today->copy()->startOfYear(), $today->copy()],
            'custom'     => [
                $startDate ? Carbon::parse($startDate) : $today->copy()->startOfMonth(),
                $endDate ? Carbon::parse($endDate) : $today->copy(),
            ],
            default      => [$today->copy()->startOfMonth(), $today->copy()],
        };
    }
}