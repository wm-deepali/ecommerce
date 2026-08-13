<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsReportExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(protected Collection $rows)
    {
    }

    public function collection(): Collection
    {
        return $this->rows;
    }

    public function headings(): array
    {
        return ['#', 'Product', 'SKU', 'Category', 'Units Sold', 'Revenue', 'Avg Price', 'Orders', 'Stock', 'Status', 'Avg Rating', 'Growth %'];
    }

    /**
     * @param  \App\Models\Product  $p  Decorated by ProductReportController::decorateProduct()
     */
    public function map($p): array
    {
        return [
            $p->rank,
            $p->name,
            $p->sku,
            $p->category_name ?: 'Uncategorized',
            $p->units_sold,
            $p->revenue,
            $p->avg_price,
            $p->order_count,
            $p->stock,
            ucfirst(str_replace('_', ' ', $p->stock_status)),
            round($p->reviews_avg_rating ?? 0, 1),
            $p->growth,
        ];
    }
}