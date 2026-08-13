<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\StockSetting;
use App\Services\StockService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StockAlertsController extends Controller
{
    public function __construct(protected StockService $stock)
    {
    }

    /**
     * Stock Alerts listing page. Rows are "lines": one per plain product,
     * one per stock-type variant.
     */
    public function index(Request $request)
    {
        [$critical, $low, $watch] = $this->stock->thresholds();

        $lines = $this->buildLines($request);

        $sort = $request->input('sort', 'severity');
        $lines = match ($sort) {
            'stock_asc' => $lines->sortBy('stock'),
            'recent' => $lines->sortByDesc('updated_at'),
            'name_asc' => $lines->sortBy('display_name'),
            default => $lines
                ->sortBy('stock')
                ->sortBy(fn($l) => match ($l['severity']) { 'critical' => 0, 'low' => 1, default => 2}),
        };

        $lines = $lines->values();

        $page = (int) $request->input('page', 1);
        $perPage = 20;

        $products = new \Illuminate\Pagination\LengthAwarePaginator(
            $lines->forPage($page, $perPage)->values(),
            $lines->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $categories = Category::orderBy('name')->get();

        // KPI / sidebar figures over ALL alert-range lines (unfiltered)
        $allLines = $this->buildLines($request, applyFilters: false);

        $kpi = [
            'critical' => $allLines->where('severity', 'critical')->count(),
            'low' => $allLines->where('severity', 'low')->count(),
            'watch' => $allLines->where('severity', 'watch')->count(),
        ];

        $topCritical = $allLines
            ->where('severity', '!=', 'watch')
            ->sortBy('stock')
            ->take(5)
            ->values();

        $byCategory = $allLines
            ->groupBy(fn($l) => $l['category']->name ?? 'Uncategorized')
            ->map(fn($group, $name) => (object) [
                'name' => $name,
                'critical_count' => $group->where('severity', 'critical')->count(),
                'low_count' => $group->where('severity', 'low')->count(),
            ])
            ->filter(fn($c) => $c->critical_count > 0 || $c->low_count > 0)
            ->sortByDesc('critical_count')
            ->values();

        $settings = StockSetting::current();

        return view('admin.stock.alerts', compact(
            'products',
            'categories',
            'kpi',
            'topCritical',
            'byCategory',
            'settings',
            'critical',
            'low',
            'watch'
        ));
    }

    /**
     * Builds the flattened alert-range list (stock <= watch threshold),
     * one line per plain product or stock-type variant.
     */
    protected function buildLines(Request $request, bool $applyFilters = true): \Illuminate\Support\Collection
    {
        [$critical, $low, $watch] = $this->stock->thresholds();

        $variantProductIds = ProductVariant::where('type', 'stock')->pluck('product_id')->unique();

        $productQuery = Product::with('category')
            ->whereNotIn('id', $variantProductIds)
            ->where('stock', '<=', $watch);

        $variantQuery = ProductVariant::where('type', 'stock')
            ->where('stock', '<=', $watch)
            ->with([
                'product.category',
                'values.attributeValue.attribute'
            ]);

        if ($applyFilters) {
            if ($search = $request->input('search')) {
                $productQuery->where(fn($q) => $q->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%")
                    ->orWhere('product_code', 'like', "%{$search}%"));

                $variantQuery->where(fn($q) => $q->where('sku', 'like', "%{$search}%")
                    ->orWhereHas('product', function ($pq) use ($search) {
                        $pq->where('name', 'like', "%{$search}%")
                            ->orWhere('product_code', 'like', "%{$search}%");
                    }));
            }

            if ($categoryId = $request->input('category_id')) {
                $productQuery->where('category_id', $categoryId);
                $variantQuery->whereHas('product', fn($pq) => $pq->where('category_id', $categoryId));
            }
        }

        $lines = collect();

        foreach ($productQuery->get() as $product) {
            $lines->push($this->lineFrom($product, null, $critical, $low));
        }

        foreach ($variantQuery->get() as $variant) {
            if (!$variant->product) {
                continue;
            }
            $lines->push($this->lineFrom($variant->product, $variant, $critical, $low));
        }

        if ($applyFilters && ($severity = $request->input('severity'))) {
            $lines = $lines->filter(fn($l) => $l['severity'] === $severity);
        }

        return $lines->values();
    }

    private function lineFrom(Product $product, ?ProductVariant $variant, int $critical, int $low): array
    {
        $stock = $variant ? $variant->stock : $product->stock;

        return [
            'kind' => $variant ? 'variant' : 'product',
            'id' => $variant ? $variant->id : $product->id,
            'product' => $product,
            'variant' => $variant,
            'display_name' => $product->name,
            'sub_label' => $variant ? $this->variantLabel($variant) : null,
            'sku' => $variant ? $variant->sku : $product->sku,
            'product_code' => $product->product_code,
            'category' => $product->category,
            'stock' => $stock,
            'min_qty' => $product->min_qty,
            'severity' => $stock <= $critical ? 'critical' : ($stock <= $low ? 'low' : 'watch'),
            'updated_at' => $variant ? $variant->updated_at : $product->updated_at,
            'image' => $product->display_image,
        ];
    }

    /**
     * Quick Restock — plain product.
     */
    public function restock(Request $request, Product $product)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $this->stock->credit(
            $product,
            $validated['quantity'],
            'restock',
            null,
            auth()->id(),
        );

        $product->refresh();
        [$critical, $low, $watch] = $this->stock->thresholds();

        return response()->json([
            'stock' => $product->stock,
            'severity' => $this->severity($product->stock, $critical, $low, $watch),
            'active' => (bool) $product->status,
        ]);
    }

    /**
     * Quick Restock — stock-type variant.
     */
    public function restockVariant(Request $request, ProductVariant $variant)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $this->stock->credit(
            $variant->product,
            $validated['quantity'],
            'restock',
            null,
            auth()->id(),
            null,
            $variant
        );

        $variant->refresh();
        [$critical, $low, $watch] = $this->stock->thresholds();

        return response()->json([
            'stock' => $variant->stock,
            'severity' => $this->severity($variant->stock, $critical, $low, $watch),
            'active' => (bool) $variant->product->status,
        ]);
    }

    public function updateThresholds(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'critical_threshold' => 'required|integer|min:0',
                'low_stock_threshold' => 'required|integer|min:0|gte:critical_threshold',
                'watch_list_threshold' => 'required|integer|min:0|gte:low_stock_threshold',
            ],
            [
                'low_stock_threshold.gte' => 'Low Stock must be ≥ Critical threshold.',
                'watch_list_threshold.gte' => 'Watch List must be ≥ Low Stock threshold.',
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        StockSetting::current()->update($validator->validated());
        app(\App\Services\StockAlertService::class)->sendAlertEmailIfNeeded();

        return back()->with('success', 'Alert thresholds updated.');
    }

    public function updateNotifications(Request $request)
    {
        StockSetting::current()->update([
            'notify_email' => $request->boolean('notify_email'),
            'notify_dashboard' => $request->boolean('notify_dashboard'),
            'auto_disable_out_of_stock' => $request->boolean('auto_disable_out_of_stock'),
        ]);

        return back()->with('success', 'Notification preferences updated.');
    }

    private function severity(int $stock, int $critical, int $low, int $watch): string
    {
        if ($stock <= $critical) {
            return 'critical';
        }
        if ($stock <= $low) {
            return 'low';
        }
        if ($stock <= $watch) {
            return 'watch';
        }
        return 'in_stock';
    }

    public function export(Request $request)
    {
        $lines = $this->buildLines($request)
            ->sortBy('stock')
            ->sortBy(fn($l) => match ($l['severity']) { 'critical' => 0, 'low' => 1, default => 2});

        $filename = 'stock-alerts-' . now()->format('Y-m-d-His') . '.csv';

        $callback = function () use ($lines) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, ['ID', 'Type', 'Product Name', 'Variant', 'SKU', 'Product Code', 'Category', 'Stock', 'Min Qty', 'Severity', 'Last Updated']);

            foreach ($lines as $l) {
                $sev = match ($l['severity']) { 'critical' => 'Critical', 'low' => 'Low Stock', default => 'Watch'};

                fputcsv($handle, [
                    $l['id'],
                    $l['kind'] === 'variant' ? 'Variant' : 'Product',
                    $l['display_name'],
                    $l['sub_label'] ?? '',
                    $l['sku'],
                    $l['product_code'],
                    $l['category']->name ?? 'Uncategorized',
                    $l['stock'],
                    $l['min_qty'],
                    $sev,
                    $l['updated_at']->format('d M Y, g:i A'),
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }

    public function restockAllCritical(Request $request)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        [$critical] = $this->stock->thresholds();

        $variantProductIds = ProductVariant::where('type', 'stock')->pluck('product_id')->unique();

        $products = Product::whereNotIn('id', $variantProductIds)
            ->where('stock', '<=', $critical)
            ->get();

        $variants = ProductVariant::where('type', 'stock')
            ->where('stock', '<=', $critical)
            ->with('product')
            ->get();

        foreach ($products as $product) {
            $this->stock->credit($product, $validated['quantity'], 'restock', null, auth()->id());
        }

        foreach ($variants as $variant) {
            if (!$variant->product) {
                continue;
            }
            $this->stock->credit($variant->product, $validated['quantity'], 'restock', null, auth()->id(), null, $variant);
        }

        $count = $products->count() + $variants->count();

        return back()->with(
            'success',
            "Added {$validated['quantity']} units to {$count} critical items."
        );
    }

    private function variantLabel(ProductVariant $variant): string
    {
        $label = $variant->values
            ->map(function ($value) {

                $attributeName = $value->attributeValue->attribute->name ?? '';
                $attributeValue = $value->attributeValue->value ?? '';

                return trim($attributeName . ': ' . $attributeValue);
            })
            ->filter()
            ->implode(' | ');

        return $label ?: ($variant->sku ?: "Variant #{$variant->id}");
    }

}