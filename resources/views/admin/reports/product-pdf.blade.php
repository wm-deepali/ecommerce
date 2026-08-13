<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Product Report</title>
<style>
    @page { margin: 24px 28px; }
    body { font-family: 'DejaVu Sans', sans-serif; color: #202223; font-size: 10.5px; }
    h1 { font-size: 17px; margin: 0 0 2px; }
    .crumb { font-size: 9.5px; color: #8c9196; margin-bottom: 6px; }
    .filters { font-size: 9.5px; color: #6d7175; margin-bottom: 14px; }
    .filters span { display: inline-block; margin-right: 14px; }
    .filters b { color: #202223; }

    .section-title { font-size: 11.5px; font-weight: bold; margin: 16px 0 8px; padding-bottom: 4px; border-bottom: 1px solid #e3e5e8; }

    table.kpi-table { width: 100%; border-collapse: collapse; margin-bottom: 4px; }
    table.kpi-table td { width: 25%; border: 1px solid #e3e5e8; padding: 8px 10px; vertical-align: top; }
    .kpi-label { font-size: 8.5px; text-transform: uppercase; color: #8c9196; font-weight: bold; }
    .kpi-value { font-size: 14px; font-weight: bold; margin-top: 3px; }
    .kpi-sub { font-size: 8.5px; color: #8c9196; margin-top: 2px; }

    table.data-table { width: 100%; border-collapse: collapse; }
    table.data-table th { background: #fafafa; border: 1px solid #e3e5e8; padding: 5px 7px; text-align: left; font-size: 8.5px; text-transform: uppercase; color: #6d7175; }
    table.data-table td { border: 1px solid #e3e5e8; padding: 5px 7px; font-size: 9.5px; }
    table.data-table tfoot td { font-weight: bold; background: #fafafa; }

    .two-col { width: 100%; }
    .two-col td { vertical-align: top; width: 50%; padding-right: 10px; }
    .three-col td { vertical-align: top; width: 33.33%; padding-right: 10px; }

    .pill-active   { color: #007a5e; font-weight: bold; }
    .pill-inactive { color: #b22222; font-weight: bold; }
    .pill-low      { color: #916a00; font-weight: bold; }

    .text-muted { color: #8c9196; }
    .text-right { text-align: right; }
    .growth-up   { color: #007a5e; font-weight: bold; }
    .growth-down { color: #b22222; font-weight: bold; }
</style>
</head>
<body>

    <h1>Product Report</h1>
    <div class="crumb">{{ $start->format('d M Y') }} &ndash; {{ $end->format('d M Y') }} &middot; Generated {{ now()->format('d M Y, H:i') }}</div>
    <div class="filters">
        @if($search)<span><b>Search:</b> {{ $search }}</span>@endif
        @if($categoryName)<span><b>Category:</b> {{ $categoryName }}</span>@endif
        @if($status)<span><b>Status:</b> {{ ucfirst(str_replace('_',' ',$status)) }}</span>@endif
        <span><b>Sorted by:</b> {{ str_replace('_', ' ', $sortBy) }}</span>
    </div>

    <!-- KPIs -->
    <table class="kpi-table">
        <tr>
            <td>
                <div class="kpi-label">Total Products</div>
                <div class="kpi-value">{{ number_format($totalProducts) }}</div>
                <div class="kpi-sub">{{ $newProductsCount }} new this period</div>
            </td>
            <td>
                <div class="kpi-label">Total Units Sold</div>
                <div class="kpi-value">{{ number_format($unitsThis) }}</div>
                <div class="kpi-sub">{{ $unitsGrowth >= 0 ? '+' : '' }}{{ $unitsGrowth }}% vs prev period</div>
            </td>
            <td>
                <div class="kpi-label">Total Revenue</div>
                <div class="kpi-value">Rs. {{ number_format($revenueThis) }}</div>
                <div class="kpi-sub">{{ $revenueGrowth >= 0 ? '+' : '' }}{{ $revenueGrowth }}% vs prev period</div>
            </td>
            <td>
                <div class="kpi-label">Out of Stock</div>
                <div class="kpi-value">{{ number_format($outOfStockNow) }}</div>
                <div class="kpi-sub">{{ $outOfStockDelta >= 0 ? '+' : '' }}{{ $outOfStockDelta }} from last period</div>
            </td>
        </tr>
    </table>

    <!-- Revenue by Category + Key Metrics + Category counts -->
    <div class="section-title">Revenue by Category, Key Metrics &amp; Catalog Breakdown</div>
    <table class="three-col">
        <tr>
            <td>
                <table class="data-table">
                    <thead><tr><th>Category</th><th class="text-right">Revenue</th><th class="text-right">%</th></tr></thead>
                    <tbody>
                        @foreach($donutCategories as $cat)
                            <tr>
                                <td>{{ $cat['name'] }}</td>
                                <td class="text-right">Rs. {{ number_format($cat['revenue']) }}</td>
                                <td class="text-right">{{ $cat['pct'] }}%</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </td>
            <td>
                <table class="data-table">
                    <tbody>
                        <tr><td>Avg Revenue / Product</td><td class="text-right">Rs. {{ number_format($avgRevenuePerProduct) }}</td></tr>
                        <tr><td>Avg Units / Product</td><td class="text-right">{{ $avgUnitsPerProduct }}</td></tr>
                        <tr><td>Avg Rating (all)</td><td class="text-right">{{ $avgRating > 0 ? $avgRating : '—' }}</td></tr>
                        <tr><td>Return Rate</td><td class="text-right">{{ $returnRate }}%</td></tr>
                        <tr><td>Products with Reviews</td><td class="text-right">{{ $reviewedPct }}%</td></tr>
                        <tr><td>Conversion Rate</td><td class="text-right">{{ $conversionRate }}%</td></tr>
                    </tbody>
                </table>
            </td>
            <td>
                <table class="data-table">
                    <thead><tr><th>Category</th><th class="text-right">Products</th></tr></thead>
                    <tbody>
                        @forelse($categoryProductCounts as $cat)
                            <tr><td>{{ $cat->name }}</td><td class="text-right">{{ number_format($cat->products_count) }}</td></tr>
                        @empty
                            <tr><td colspan="2" class="text-muted">No categories found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </td>
        </tr>
    </table>

    <!-- Top Rated -->
    <div class="section-title">Highest Rated Products</div>
    <table class="data-table">
        <thead><tr><th>Product</th><th class="text-right">Reviews</th><th class="text-right">Avg Rating</th></tr></thead>
        <tbody>
            @forelse($topRated as $p)
                <tr>
                    <td>{{ $p->name }}</td>
                    <td class="text-right">{{ number_format($p->reviews_count) }}</td>
                    <td class="text-right">{{ round($p->reviews_avg_rating, 1) }}</td>
                </tr>
            @empty
                <tr><td colspan="3" class="text-muted">No reviews yet.</td></tr>
            @endforelse
        </tbody>
    </table>

    <!-- Product Performance -->
    <div class="section-title">Product Performance ({{ number_format($products->count()) }} products{{ ($search || $categoryId || $status) ? ', filtered' : '' }})</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>#</th><th>Product</th><th>SKU</th><th>Category</th>
                <th class="text-right">Units Sold</th><th class="text-right">Revenue</th>
                <th class="text-right">Avg Price</th><th class="text-right">Orders</th>
                <th class="text-right">Stock</th><th class="text-right">Rating</th>
                <th class="text-right">Growth</th><th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $p)
                @php
                    $pillClass = match($p->stock_status) {
                        'out_of_stock' => 'pill-inactive',
                        'low_stock'    => 'pill-low',
                        'inactive'     => 'pill-inactive',
                        default        => 'pill-active',
                    };
                    $pillLabel = match($p->stock_status) {
                        'out_of_stock' => 'Out of Stock',
                        'low_stock'    => 'Low Stock',
                        'inactive'     => 'Inactive',
                        default        => 'Active',
                    };
                    $rating = round($p->reviews_avg_rating ?? 0, 1);
                @endphp
                <tr>
                    <td>{{ $p->rank }}</td>
                    <td>{{ $p->name }}</td>
                    <td>{{ $p->sku }}</td>
                    <td>{{ $p->category_name ?: 'Uncategorized' }}</td>
                    <td class="text-right">{{ number_format($p->units_sold) }}</td>
                    <td class="text-right">Rs. {{ number_format($p->revenue) }}</td>
                    <td class="text-right">Rs. {{ number_format($p->avg_price) }}</td>
                    <td class="text-right">{{ number_format($p->order_count) }}</td>
                    <td class="text-right">{{ number_format($p->stock) }}</td>
                    <td class="text-right">{{ $rating > 0 ? $rating : '—' }}</td>
                    <td class="text-right {{ $p->growth > 0 ? 'growth-up' : ($p->growth < 0 ? 'growth-down' : '') }}">{{ $p->growth > 0 ? '+' : '' }}{{ $p->growth }}%</td>
                    <td class="{{ $pillClass }}">{{ $pillLabel }}</td>
                </tr>
            @empty
                <tr><td colspan="12" class="text-muted">No products found matching your filters.</td></tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4">Total</td>
                <td class="text-right">{{ number_format($products->sum('units_sold')) }}</td>
                <td class="text-right">Rs. {{ number_format($products->sum('revenue')) }}</td>
                <td colspan="6"></td>
            </tr>
        </tfoot>
    </table>

</body>
</html>