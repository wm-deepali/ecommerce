<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class TaxReportController extends Controller
{
    /** GST slabs to bucket orders into */
    private array $slabs = [0, 5, 12, 18, 28];

    public function index(Request $request)
    {
        [$from, $to] = $this->resolveDateRange($request);

        $baseQuery = $this->filteredQuery($request, $from, $to);

        // ── Top summary cards ──
        $summary = (clone $baseQuery)->selectRaw('
                SUM(subtotal) as taxable_value,
                SUM(cgst_amount) as cgst_total,
                SUM(sgst_amount) as sgst_total,
                SUM(igst_amount) as igst_total,
                SUM(tax_amount) as total_tax
            ')->first();

      // ── GST slab breakup ──
$orders = (clone $baseQuery)->get(); // needed to bucket per-order since slab isn't a stored column

$slabBreakup = [];
foreach ($this->slabs as $slab) {
    $slabBreakup[$slab] = ['taxable' => 0, 'tax' => 0];
}

foreach ($orders as $order) {
    $rate = $this->orderSlabRate($order);
    $nearest = collect($this->slabs)->sort()->first(fn ($s) => $s >= round($rate)) ?? end($this->slabs);
    $slabBreakup[$nearest]['taxable'] += $order->subtotal;
    $slabBreakup[$nearest]['tax'] += $order->tax_amount;
}

        // ── Paginated order-wise detail table ──
        $ordersPaginated = $this->filteredQuery($request, $from, $to)
            ->with(['invoice', 'state']) // adjust relation names if different
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        // ── Page totals (for tfoot) ──
        $pageTotals = [
            'taxable' => $ordersPaginated->sum('subtotal'),
            'cgst'    => $ordersPaginated->sum('cgst_amount'),
            'sgst'    => $ordersPaginated->sum('sgst_amount'),
            'igst'    => $ordersPaginated->sum('igst_amount'),
            'tax'     => $ordersPaginated->sum('tax_amount'),
            'total'   => $ordersPaginated->sum('grand_total'),
        ];

        return view('admin.reports.tax-reports', [
            'from'         => $from,
            'to'           => $to,
            'summary'      => $summary,
            'slabBreakup'  => $slabBreakup,
            'orders'       => $ordersPaginated,
            'pageTotals'   => $pageTotals,
            'totalCount'   => (clone $baseQuery)->count(),
        ]);
    }

    public function exportCsv(Request $request)
    {
        [$from, $to] = $this->resolveDateRange($request);

        $orders = $this->filteredQuery($request, $from, $to)
            ->with(['invoice', 'state'])
            ->orderByDesc('created_at')
            ->get();

        $filename = 'gst-tax-report-' . $from->format('Y-m-d') . '-to-' . $to->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($orders) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Invoice No', 'Order ID', 'Invoice Date', 'Customer', 'State', 'Tax Type', 'GST Slab', 'Taxable Amt', 'CGST', 'SGST', 'IGST', 'Total Tax', 'Invoice Total']);

            foreach ($orders as $order) {
                $rate = $this->orderSlabRate($order);
                fputcsv($handle, [
                    optional($order->invoice)->invoice_number ?? '—', // adjust if column name differs
                    $order->order_number,
                    optional($order->invoice)->invoice_date?->format('d M Y') ?? optional($order->created_at)->format('d M Y'), // adjust if column name differs
                    $order->customer_name,
                    optional($order->state)->name ?? '—',
                    $order->gst_type === 'intra' ? 'CGST+SGST' : 'IGST',
                    round($rate) . '%',
                    $order->subtotal,
                    $order->cgst_amount,
                    $order->sgst_amount,
                    $order->igst_amount,
                    $order->tax_amount,
                    $order->grand_total,
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function filteredQuery(Request $request, Carbon $from, Carbon $to)
    {
        $query = Order::whereBetween('created_at', [$from->startOfDay(), $to->endOfDay()])
            ->where('payment_status', 'paid');

        if ($request->filled('gst_slab')) {
            // Slab isn't a stored column, so filter in PHP after fetch if you need exact slab filtering.
            // Left as a hook — apply post-fetch filtering in index() if this becomes a real requirement.
        }

        if ($request->filled('tax_type')) {
            $query->where('gst_type', $request->tax_type === 'igst' ? 'inter' : 'intra');
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', strtolower($request->payment_status));
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhereHas('invoice', fn ($iq) => $iq->where('invoice_number', 'like', "%{$search}%")); // adjust if column name differs
            });
        }

        return $query;
    }

    private function resolveDateRange(Request $request): array
    {
        $from = $request->filled('date_from')
            ? Carbon::parse($request->date_from)
            : now()->subDays(29);

        $to = $request->filled('date_to')
            ? Carbon::parse($request->date_to)
            : now();

        return [$from, $to];
    }

    private function orderSlabRate(Order $order): float
    {
        return $order->gst_type === 'intra'
            ? (float) $order->cgst_rate + (float) $order->sgst_rate
            : (float) $order->igst_rate;
    }
}