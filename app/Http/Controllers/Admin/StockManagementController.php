<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\StockHistory;
use App\Services\StockService;
use Illuminate\Http\Request;

class StockManagementController extends Controller
{
    public function __construct(protected StockService $stock)
    {
    }

    /**
     * Main Stock Management listing page.
     * Rows are "lines": a plain product is one line; a product with
     * stock-type variants contributes one line per variant instead.
     */
    public function index(Request $request)
    {
        $lines = $this->buildLines($request);

        $sort = $request->input('sort', 'stock_asc');
        $lines = match ($sort) {
            'stock_desc' => $lines->sortByDesc('stock'),
            'name_asc' => $lines->sortBy('display_name'),
            'recent' => $lines->sortByDesc('updated_at'),
            default => $lines->sortBy('stock'),
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

        $categories = Category::with('products:id,name,sku,stock,category_id')
            ->orderBy('name')
            ->get();

        // KPI stats over ALL lines (unfiltered by search/category/status)
        $allLines = $this->buildLines($request, applyFilters: false);
        $stats = [
            'total' => $allLines->count(),
            'in_stock' => $allLines->where('status', 'in')->count(),
            'low' => $allLines->where('status', 'low')->count(),
            'out' => $allLines->where('status', 'out')->count(),
            'units' => $allLines->sum('stock'),
        ];

        return view('admin.stock.index', compact('products', 'categories', 'stats'));
    }

    /**
     * Builds the flattened list of "lines" (one per plain product, one per
     * stock-type variant) with search/category/status filters applied.
     */
    protected function buildLines(Request $request, bool $applyFilters = true): \Illuminate\Support\Collection
    {
        $variantProductIds = ProductVariant::where('type', 'stock')->pluck('product_id')->unique();

        $productQuery = Product::with('category')->whereNotIn('id', $variantProductIds);
        $variantQuery = ProductVariant::where('type', 'stock')
            ->with([
                'product.category',
                'values.attributeValue.attribute'
            ]);

        if ($applyFilters) {
            if ($search = $request->input('search')) {
                $productQuery->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('sku', 'like', "%{$search}%")
                        ->orWhere('product_code', 'like', "%{$search}%");
                });

                $variantQuery->where(function ($q) use ($search) {
                    $q->where('sku', 'like', "%{$search}%")
                        ->orWhereHas('product', function ($pq) use ($search) {
                            $pq->where('name', 'like', "%{$search}%")
                                ->orWhere('product_code', 'like', "%{$search}%");
                        });
                });
            }

            if ($categoryId = $request->input('category_id')) {
                $productQuery->where('category_id', $categoryId);
                $variantQuery->whereHas('product', fn($pq) => $pq->where('category_id', $categoryId));
            }
        }

        $lines = collect();

        foreach ($productQuery->get() as $product) {
            $lines->push([
                'kind' => 'product',
                'id' => $product->id,
                'product' => $product,
                'variant' => null,
                'display_name' => $product->name,
                'sub_label' => null,
                'sku' => $product->sku,
                'product_code' => $product->product_code,
                'category' => $product->category,
                'stock' => $product->stock,
                'min_qty' => $product->min_qty,
                'status' => $this->stock->simpleStatus($product),
                'active' => (bool) $product->status,
                'updated_at' => $product->updated_at,
                'image' => $product->display_image,
            ]);
        }

        foreach ($variantQuery->get() as $variant) {
            $product = $variant->product;
            if (!$product) {
                continue;
            }

            $variantLabel = $variant->values
                ->map(function ($value) {
                    return $value->attributeValue->value ?? null;
                })
                ->filter()
                ->implode(' | ');

            $lines->push([
                'kind' => 'variant',
                'id' => $variant->id,
                'product' => $product,
                'variant' => $variant,
                'display_name' => $product->name,
                'sub_label' => $variantLabel ?: ($variant->sku ?: "Variant #{$variant->id}"),
                'sku' => $variant->sku,
                'product_code' => $product->product_code,
                'category' => $product->category,
                'stock' => $variant->stock,
                'min_qty' => $product->min_qty,
                'status' => $this->stock->simpleStatus($product, $variant),
                'active' => (bool) $product->status,
                'updated_at' => $variant->updated_at,
                'image' => $product->display_image,
            ]);
        }

        if ($applyFilters && ($status = $request->input('stock_status'))) {
            $lines = $lines->filter(fn($l) => $l['status'] === $status);
        }

        return $lines->values();
    }

    /**
     * Inline "Update Stock" for a plain product.
     */
    public function updateStock(Request $request, Product $product)
    {
        $validated = $request->validate([
            'stock' => 'required|integer|min:0',
            'note' => 'nullable|string|max:255',
        ]);

        $this->stock->setStock(
            $product,
            $validated['stock'],
            'admin_adjustment',
            auth()->id(),
            $validated['note'] ?? null,
        );

        $product->refresh();
        $status = $this->stock->simpleStatus($product);

        return response()->json([
            'stock' => $product->stock,
            'status' => $status,
            'active' => (bool) $product->status,
        ]);
    }

    /**
     * Inline "Update Stock" for a stock-type variant.
     */
    public function updateVariantStock(Request $request, ProductVariant $variant)
    {
        $validated = $request->validate([
            'stock' => 'required|integer|min:0',
            'note' => 'nullable|string|max:255',
        ]);

        $this->stock->setStock(
            $variant->product,
            $validated['stock'],
            'admin_adjustment',
            auth()->id(),
            $validated['note'] ?? null,
            $variant
        );

        $variant->refresh();
        $status = $this->stock->simpleStatus($variant->product, $variant);

        return response()->json([
            'stock' => $variant->stock,
            'status' => $status,
            'active' => (bool) $variant->product->status,
        ]);
    }

    /**
     * "Quick Restock" for a plain product.
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

        return back()->with('success', "{$validated['quantity']} units added to {$product->name}.");
    }

    /**
     * "Quick Restock" for a stock-type variant.
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

        $label = $variant->product->name . ($variant->sku ? " ({$variant->sku})" : '');

        return back()->with('success', "{$validated['quantity']} units added to {$label}.");
    }

    /**
     * Stock history modal for a plain product.
     */
    public function history(Product $product)
    {
        $entries = StockHistory::where('product_id', $product->id)
            ->whereNull('stock_variant_id')
            ->with('creator:id,name')
            ->latest()
            ->take(50)
            ->get();

        return response()->json($this->historyPayload($entries, $product->stock));
    }

    /**
     * Stock history modal for a stock-type variant.
     */
    public function historyVariant(ProductVariant $variant)
    {
        $entries = StockHistory::where('stock_variant_id', $variant->id)
            ->with('creator:id,name')
            ->latest()
            ->take(50)
            ->get();

        return response()->json($this->historyPayload($entries, $variant->stock));
    }

    private function historyPayload($entries, int $currentStock): array
    {
        $added = $entries->where('type', 'credit')->sum('quantity');
        $removed = $entries->where('type', 'debit')->sum('quantity');

        $history = $entries->map(fn($h) => [
            'type' => $h->type,
            'reason' => $h->reason,
            'quantity' => $h->quantity,
            'stock_before' => $h->stock_before,
            'stock_after' => $h->stock_after,
            'note' => $h->note,
            'creator' => $h->creator?->name,
            'created_at' => $h->created_at->format('d M Y, g:i a'),
        ]);

        return [
            'summary' => [
                'added' => $added,
                'removed' => $removed,
                'current' => $currentStock,
            ],
            'history' => $history,
        ];
    }

    /**
     * NOTE: still product-only (does not include variant lines yet).
     * Extending this needs a CSV column-format decision for variants first.
     */
    public function export(Request $request)
    {
        [$criticalThreshold, $lowThreshold] = $this->stock->thresholds();

        $query = Product::with('category')->select('products.*');

        if ($search = $request->input('search')) {
            $query->where(fn($q) => $q->where('name', 'like', "%{$search}%")
                ->orWhere('sku', 'like', "%{$search}%")
                ->orWhere('product_code', 'like', "%{$search}%"));
        }
        if ($categoryId = $request->input('category_id')) {
            $query->where('category_id', $categoryId);
        }
        if ($status = $request->input('stock_status')) {
            match ($status) {
                'out' => $query->where('stock', '<=', $criticalThreshold),
                'low' => $query->where('stock', '>', $criticalThreshold)->where('stock', '<=', $lowThreshold),
                'in' => $query->where('stock', '>', $lowThreshold),
                default => null,
            };
        }

        $products = $query->orderBy('stock')->get();
        $filename = 'stock-' . now()->format('Y-m-d-His') . '.csv';

        return response()->stream(function () use ($products, $criticalThreshold, $lowThreshold) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, ['ID', 'Product Name', 'SKU', 'Product Code', 'Category', 'Stock', 'Min Qty', 'Status', 'Visibility', 'Last Updated']);

            foreach ($products as $p) {
                $status = match (true) {
                    $p->stock <= $criticalThreshold => 'Out of Stock',
                    $p->stock <= $lowThreshold => 'Low Stock',
                    default => 'In Stock',
                };

                fputcsv($handle, [
                    $p->id,
                    $p->name,
                    $p->sku,
                    $p->product_code,
                    $p->category->name ?? 'Uncategorized',
                    $p->stock,
                    $p->min_qty,
                    $status,
                    $p->status ? 'Active' : 'Inactive',
                    $p->updated_at->format('d M Y, g:i A'),
                ]);
            }

            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }

    /**
     * NOTE: still product-only. CSV format would need a Variant ID column
     * to disambiguate rows before this can safely touch variant stock.
     */
    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        $handle = fopen($request->file('csv_file')->getRealPath(), 'r');
        $header = fgetcsv($handle);
        $updated = 0;
        $skipped = 0;
        $errors = [];

        while (($row = fgetcsv($handle)) !== false) {
            $id = trim($row[0] ?? '');
            $stock = trim($row[5] ?? '');

            if (!is_numeric($id) || !is_numeric($stock) || (int) $stock < 0) {
                $skipped++;
                continue;
            }

            $product = Product::find((int) $id);

            if (!$product) {
                $errors[] = "Product ID {$id} not found.";
                $skipped++;
                continue;
            }

            $this->stock->setStock(
                $product,
                (int) $stock,
                'bulk_import',
                auth()->id(),
                'Bulk CSV update',
            );

            $updated++;
        }

        fclose($handle);

        $message = "{$updated} products updated.";
        if ($skipped) {
            $message .= " {$skipped} rows skipped.";
        }

        return back()->with('success', $message)->with('bulk_errors', $errors);
    }

    /**
     * NOTE: dropdown still lists plain products only. Let me know if you
     * want variant options grouped in here too.
     */
    public function addStockEntry(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'type' => 'required|in:credit,debit',
            'reason' => 'required|in:restock,admin_adjustment,bulk_import,damage,return,initial_stock',
            'note' => 'nullable|string|max:255',
        ]);

        $product = Product::findOrFail($validated['product_id']);

        if ($validated['type'] === 'credit') {
            $this->stock->credit(
                $product,
                $validated['quantity'],
                $validated['reason'],
                null,
                auth()->id(),
                $validated['note'] ?? null,
            );
        } else {
            $this->stock->debit(
                $product,
                $validated['quantity'],
                $validated['reason'],
                null,
                auth()->id(),
                $validated['note'] ?? null,
                allowNegative: false,
            );
        }

        return back()->with('success', "Stock entry recorded for {$product->name}.");
    }

    public function downloadTemplate()
    {
        $filename = 'stock-bulk-update-template.csv';

        return response()->stream(function () {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, ['ID', 'Product Name', 'SKU', 'Product Code', 'Category', 'Stock', 'Min Qty']);

            fputcsv($handle, [1, 'Example Product A', 'SKU-00001', 'CODE-001', 'Electronics', 50, 5]);
            fputcsv($handle, [2, 'Example Product B', 'SKU-00002', 'CODE-002', 'Clothing', 100, 10]);
            fputcsv($handle, [99, 'Example Product C', 'SKU-00099', 'CODE-099', 'Footwear', 0, 3]);

            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
        ]);
    }
}