<?php

namespace App\Exports;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderReturn;
use App\Models\RefundTransaction;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

// ── Place this file at: app/Exports/SalesReportExport.php ───────────────────

class SalesReportExport implements WithMultipleSheets
{
    public function __construct(
        public readonly Carbon $start,
        public readonly Carbon $end
    ) {}

    public function sheets(): array
    {
        return [
            new SalesKpiSheet($this->start, $this->end),
            new TopProductsSheet($this->start, $this->end),
            new DailyBreakdownSheet($this->start, $this->end),
            new PaymentMethodsSheet($this->start, $this->end),
        ];
    }
}

// ── Sheet 1: KPI Summary ─────────────────────────────────────────────────────

class SalesKpiSheet implements FromCollection, WithHeadings, WithTitle, WithStyles, WithColumnWidths
{
    public function __construct(
        private Carbon $start,
        private Carbon $end
    ) {}

    public function title(): string { return 'Summary'; }

    public function headings(): array
    {
        return ['Metric', 'This Period', 'Previous Period', 'Change'];
    }

    public function collection()
    {
        $days      = $this->start->diffInDays($this->end) + 1;
        $prevEnd   = $this->start->copy()->subSecond();
        $prevStart = $prevEnd->copy()->subDays($days - 1)->startOfDay();

        $revenueThis = (float) Order::where('payment_status', 'paid')->whereBetween('created_at', [$this->start, $this->end])->sum('grand_total');
        $revenuePrev = (float) Order::where('payment_status', 'paid')->whereBetween('created_at', [$prevStart, $prevEnd])->sum('grand_total');

        $ordersThis = Order::whereBetween('created_at', [$this->start, $this->end])->count();
        $ordersPrev = Order::whereBetween('created_at', [$prevStart, $prevEnd])->count();

        $unitsThis = (int) OrderItem::join('orders', 'orders.id', '=', 'order_items.order_id')->where('orders.payment_status', 'paid')->whereBetween('orders.created_at', [$this->start, $this->end])->sum('order_items.quantity');
        $unitsPrev = (int) OrderItem::join('orders', 'orders.id', '=', 'order_items.order_id')->where('orders.payment_status', 'paid')->whereBetween('orders.created_at', [$prevStart, $prevEnd])->sum('order_items.quantity');

        $returnsThis    = OrderReturn::whereBetween('created_at', [$this->start, $this->end])->count();
        $returnRateThis = $ordersThis > 0 ? round(($returnsThis / $ordersThis) * 100, 1) : 0;

        $grossRevenue   = (float) Order::where('payment_status', 'paid')->whereBetween('created_at', [$this->start, $this->end])->sum('subtotal');
        $discounts      = (float) Order::where('payment_status', 'paid')->whereBetween('created_at', [$this->start, $this->end])->sum('discount');
        $refunds        = (float) RefundTransaction::whereBetween('created_at', [$this->start, $this->end])->sum('amount');
        $tax            = (float) Order::where('payment_status', 'paid')->whereBetween('created_at', [$this->start, $this->end])->sum('tax_amount');

        $pct = fn($old, $new) => $old > 0 ? round((($new - $old) / $old) * 100, 1) . '%' : ($new > 0 ? '+100%' : '0%');

        return collect([
            ['Period', $this->start->format('d M Y') . ' – ' . $this->end->format('d M Y'), $prevStart->format('d M Y') . ' – ' . $prevEnd->format('d M Y'), ''],
            ['', '', '', ''],
            ['Total Revenue (₹)',      number_format($revenueThis, 2), number_format($revenuePrev, 2), $pct($revenuePrev, $revenueThis)],
            ['Total Orders',           number_format($ordersThis),     number_format($ordersPrev),     $pct($ordersPrev, $ordersThis)],
            ['Avg. Order Value (₹)',   $ordersThis > 0 ? number_format($revenueThis / $ordersThis, 2) : 0, $ordersPrev > 0 ? number_format($revenuePrev / $ordersPrev, 2) : 0, ''],
            ['Units Sold',             number_format($unitsThis),      number_format($unitsPrev),      $pct($unitsPrev, $unitsThis)],
            ['Return Rate',            $returnRateThis . '%',          '',                             ''],
            ['', '', '', ''],
            ['Gross Revenue (₹)',      number_format($grossRevenue, 2), '', ''],
            ['Discounts Given (₹)',    number_format($discounts, 2),   '', ''],
            ['Refunds / Returns (₹)',  number_format($refunds, 2),     '', ''],
            ['Tax Collected GST (₹)',  number_format($tax, 2),         '', ''],
            ['Net Revenue (₹)',        number_format($revenueThis, 2), '', ''],
        ]);
    }

    public function columnWidths(): array
    {
        return ['A' => 28, 'B' => 22, 'C' => 22, 'D' => 14];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '303d89']], 'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']]],
        ];
    }
}

// ── Sheet 2: Top Products ────────────────────────────────────────────────────

class TopProductsSheet implements FromCollection, WithHeadings, WithTitle, WithStyles, WithColumnWidths
{
    public function __construct(private Carbon $start, private Carbon $end) {}

    public function title(): string { return 'Top Products'; }

    public function headings(): array
    {
        return ['#', 'Product Name', 'SKU', 'Category', 'Units Sold', 'Revenue (₹)', 'Avg. Price (₹)', 'Share %'];
    }

    public function collection()
    {
        $totalRevenue = (float) OrderItem::join('orders', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.payment_status', 'paid')
            ->whereBetween('orders.created_at', [$this->start, $this->end])
            ->sum('order_items.total');

        return OrderItem::join('orders', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
            ->where('orders.payment_status', 'paid')
            ->whereBetween('orders.created_at', [$this->start, $this->end])
            ->select(
                'order_items.product_name', 'products.sku',
                'categories.name as category_name',
                DB::raw('SUM(order_items.quantity) as units'),
                DB::raw('SUM(order_items.total) as revenue')
            )
            ->groupBy('order_items.product_id', 'order_items.product_name', 'products.sku', 'categories.name')
            ->orderByDesc('revenue')
            ->take(10)
            ->get()
            ->map(fn($p, $i) => [
                $i + 1,
                $p->product_name,
                $p->sku,
                $p->category_name ?: 'Uncategorized',
                (int) $p->units,
                number_format((float) $p->revenue, 2),
                $p->units > 0 ? number_format($p->revenue / $p->units, 2) : 0,
                $totalRevenue > 0 ? round(($p->revenue / $totalRevenue) * 100) . '%' : '0%',
            ]);
    }

    public function columnWidths(): array
    {
        return ['A' => 5, 'B' => 32, 'C' => 14, 'D' => 18, 'E' => 12, 'F' => 16, 'G' => 16, 'H' => 10];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '303d89']]],
        ];
    }
}

// ── Sheet 3: Daily Breakdown ─────────────────────────────────────────────────

class DailyBreakdownSheet implements FromCollection, WithHeadings, WithTitle, WithStyles, WithColumnWidths
{
    public function __construct(private Carbon $start, private Carbon $end) {}

    public function title(): string { return 'Daily Breakdown'; }

    public function headings(): array
    {
        return ['Date', 'Day', 'Orders', 'Revenue (₹)', 'Returns'];
    }

    public function collection()
    {
        $orders = Order::whereBetween('created_at', [$this->start, $this->end])
            ->select(DB::raw('DATE(created_at) as d'), DB::raw('COUNT(*) as cnt'), DB::raw("SUM(CASE WHEN payment_status = 'paid' THEN grand_total ELSE 0 END) as rev"))
            ->groupBy('d')->get()->keyBy('d');

        $returns = OrderReturn::whereBetween('created_at', [$this->start, $this->end])
            ->select(DB::raw('DATE(created_at) as d'), DB::raw('COUNT(*) as cnt'))
            ->groupBy('d')->pluck('cnt', 'd');

        $rows = [];
        for ($d = $this->start->copy(); $d->lte($this->end); $d->addDay()) {
            $key    = $d->format('Y-m-d');
            $rows[] = [
                $d->format('d M Y'),
                $d->format('l'),
                (int) ($orders[$key]->cnt ?? 0),
                number_format((float) ($orders[$key]->rev ?? 0), 2),
                (int) ($returns[$key] ?? 0),
            ];
        }

        return collect(array_reverse($rows));
    }

    public function columnWidths(): array
    {
        return ['A' => 14, 'B' => 12, 'C' => 10, 'D' => 16, 'E' => 10];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '303d89']]],
        ];
    }
}

// ── Sheet 4: Payment Methods ─────────────────────────────────────────────────

class PaymentMethodsSheet implements FromCollection, WithHeadings, WithTitle, WithStyles, WithColumnWidths
{
    public function __construct(private Carbon $start, private Carbon $end) {}

    public function title(): string { return 'Payment Methods'; }

    public function headings(): array
    {
        return ['Payment Method', 'Transactions', 'Revenue (₹)', 'Share %'];
    }

    public function collection()
    {
        $totalRevenue = (float) Order::where('payment_status', 'paid')->whereBetween('created_at', [$this->start, $this->end])->sum('grand_total');

        return Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$this->start, $this->end])
            ->select('payment_method', DB::raw('COUNT(*) as txns'), DB::raw('SUM(grand_total) as revenue'))
            ->groupBy('payment_method')
            ->orderByDesc('revenue')
            ->get()
            ->map(fn($row) => [
                ucfirst($row->payment_method),
                $row->txns,
                number_format((float) $row->revenue, 2),
                $totalRevenue > 0 ? round(($row->revenue / $totalRevenue) * 100) . '%' : '0%',
            ]);
    }

    public function columnWidths(): array
    {
        return ['A' => 22, 'B' => 16, 'C' => 18, 'D' => 10];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '303d89']]],
        ];
    }
}