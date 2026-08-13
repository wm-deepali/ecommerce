<?php

namespace App\Exports;

use App\Models\Order;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OrderReportExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function __construct(protected Carbon $from, protected Carbon $to)
    {
    }

    public function collection()
    {
        return Order::with(['items', 'courier', 'city'])
            ->whereBetween('created_at', [$this->from->copy()->startOfDay(), $this->to->copy()->endOfDay()])
            ->latest()
            ->get();
    }

    public function headings(): array
    {
        return [
            'Order #',
            'Customer',
            'City',
            'Date',
            'Items',
            'Amount',
            'Payment Method',
            'Payment Status',
            'Courier',
            'Tracking No.',
            'Status',
        ];
    }

    public function map($order): array
    {
        return [
            $order->order_number,
            $order->customer_name,
            $order->city?->name ?? '',
            $order->created_at->format('d M Y h:i A'),
            $order->items->count(),
            $order->grand_total,
            strtoupper($order->payment_method),
            ucfirst($order->payment_status),
            $order->courier?->name ?? '',
            $order->tracking_number ?? '',
            ucfirst($order->status),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}