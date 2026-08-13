<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\Wishlist;
use Illuminate\Pagination\LengthAwarePaginator;

class CustomerWishlistController extends Controller
{
    // Same palette pattern used elsewhere in the admin (avatar colors)
    protected $avatarColors = ['#303d89', '#0069d9', '#6d28d9', '#c0392b', '#007a5e', '#2980b9', '#916a00', '#7f8c8d', '#e67e22'];

    public function index(Request $request)
    {
        $query = Customer::whereHas('wishlists')
            ->withCount('wishlists')
            ->with(['wishlists' => function ($q) {
                $q->with('product')->latest();
            }]);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Heat filter (server-side, based on actual wishlist item count)
        if ($request->filled('heat')) {
            switch ($request->heat) {
                case 'hot':
                    $query->whereHas('wishlists', fn ($q) => $q, '>=', 10);
                    break;
                case 'warm':
                    $query->whereHas('wishlists', fn ($q) => $q, '>=', 4)
                          ->whereHas('wishlists', fn ($q) => $q, '<=', 9);
                    break;
                case 'cool':
                    $query->whereHas('wishlists', fn ($q) => $q, '>=', 1)
                          ->whereHas('wishlists', fn ($q) => $q, '<=', 3);
                    break;
            }
        }

        // Pull the matching customers (unpaginated at this point — we need
        // computed fields like totalValue/heat before we can sort/paginate)
        $allCustomers = $query->get();

        // Build per-row data (same shape as before)
        $rows = $allCustomers->map(function ($customer) {
            $items = $customer->wishlists;
            $itemCount = $items->count();
            $totalValue = $items->sum(fn ($i) => optional($i->product)->price ?? 0);
            $avgValue = $itemCount ? $totalValue / $itemCount : 0;
            $lastItem = $items->first(); // already latest() ordered
            $recent = $items->take(3);

            $heat = $itemCount >= 10 ? 'hot' : ($itemCount >= 4 ? 'warm' : 'cool');

            $initials = collect(explode(' ', $customer->name))
                ->map(fn ($p) => strtoupper(substr($p, 0, 1)))
                ->take(2)
                ->implode('');

            $colorIndex = $customer->id % count($this->avatarColors);

            return (object) [
                'customer'    => $customer,
                'initials'    => $initials,
                'color'       => $this->avatarColors[$colorIndex],
                'itemCount'   => $itemCount,
                'totalValue'  => $totalValue,
                'avgValue'    => $avgValue,
                'heat'        => $heat,
                'recent'      => $recent,
                'lastAdded'   => $lastItem->created_at ?? null,
                'lastProduct' => optional(optional($lastItem)->product)->name,
            ];
        });

        // Sorting
        switch ($request->get('sort', 'last_added')) {
            case 'most_items':
                $rows = $rows->sortByDesc('itemCount');
                break;
            case 'highest_value':
                $rows = $rows->sortByDesc('totalValue');
                break;
            case 'name_az':
                $rows = $rows->sortBy(fn ($r) => strtolower($r->customer->name));
                break;
            case 'last_added':
            default:
                $rows = $rows->sortByDesc(fn ($r) => $r->lastAdded);
                break;
        }
        $rows = $rows->values();

        // CSV export — respects current search/heat/sort filters
        if ($request->boolean('export')) {
            return $this->exportCsv($rows);
        }

        // Manual pagination (needed since sort/heat depend on computed fields)
        $perPage = 9;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $pagedRows = $rows->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $customers = new LengthAwarePaginator(
            $pagedRows,
            $rows->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $rows = $pagedRows;

        // KPIs (overall stats — not affected by filters)
        $totalCustomersWithWishlist = Customer::whereHas('wishlists')->count();
        $totalCustomers = Customer::count();
        $totalItems = Wishlist::whereNotNull('customer_id')->count();
        $avgItemsPerCustomer = $totalCustomersWithWishlist
            ? round($totalItems / $totalCustomersWithWishlist, 1)
            : 0;
        $totalValue = Wishlist::whereNotNull('customer_id')
            ->with('product')
            ->get()
            ->sum(fn ($w) => optional($w->product)->price ?? 0);

        return view('admin.customers.customer-wishlist', compact(
            'customers', 'rows', 'totalCustomersWithWishlist', 'totalCustomers',
            'totalItems', 'avgItemsPerCustomer', 'totalValue'
        ));
    }

    protected function exportCsv($rows)
    {
        $filename = 'customer-wishlists-' . now()->format('Y-m-d-His') . '.csv';

        return response()->streamDownload(function () use ($rows) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Customer', 'Email', 'Items', 'Total Value', 'Avg Value', 'Activity', 'Last Added', 'Last Product']);

            foreach ($rows as $row) {
                fputcsv($handle, [
                    $row->customer->name,
                    $row->customer->email,
                    $row->itemCount,
                    $row->totalValue,
                    round($row->avgValue, 2),
                    ucfirst($row->heat),
                    $row->lastAdded ? $row->lastAdded->format('Y-m-d H:i') : '',
                    $row->lastProduct ?? '',
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

public function show(Customer $customer)
{
    $lowStockThreshold = 5;

    $wishlists = Wishlist::where('customer_id', $customer->id)
        ->whereHas('product')
        ->with(['product.category', 'product.images', 'product.variants.values.attributeValue.attribute'])
        ->latest()
        ->get();

    $items = $wishlists->map(function ($w) use ($lowStockThreshold) {
        $product = $w->product;
        $stock = (int) $product->stock;

        $stockStatus = $stock <= 0 ? 'out' : ($stock <= $lowStockThreshold ? 'low' : 'in');
        $stockLabel = match ($stockStatus) {
            'out' => 'Out of Stock',
            'low' => "Low Stock · {$stock} left",
            default => 'In Stock',
        };

        $hasDiscount = $product->mrp && $product->mrp > $product->price;
        $discountPercent = $hasDiscount
            ? round((($product->mrp - $product->price) / $product->mrp) * 100)
            : null;

        $colorVariants = $product->variants
            ->flatMap(fn ($variant) => $variant->values)
            ->filter(fn ($value) => optional(optional($value->attributeValue)->attribute)->name === 'Color')
            ->map(fn ($value) => $value->attributeValue)
            ->unique('id')
            ->values();

        return (object) [
            'wishlist_id'     => $w->id,
            'product'         => $product,
            'stockStatus'     => $stockStatus,
            'stockLabel'      => $stockLabel,
            'hasDiscount'     => $hasDiscount,
            'discountPercent' => $discountPercent,
            'colorVariants'   => $colorVariants,
            'addedAt'         => $w->created_at,
        ];
    });

    // CSV export — respects this customer's current wishlist items
    if (request()->boolean('export')) {
        return $this->exportCustomerCsv($customer, $items);
    }

    $totalItems  = $items->count();
    $totalValue  = $items->sum(fn ($i) => $i->product->price);
    $inStock     = $items->where('stockStatus', 'in')->count();
    $outOfStock  = $items->where('stockStatus', 'out')->count();

    $oldestAdded = $items->min(fn ($i) => $i->addedAt);
    $oldestDays  = $oldestAdded ? now()->diffInDays($oldestAdded) : 0;

    $heat = $totalItems >= 10 ? 'hot' : ($totalItems >= 4 ? 'warm' : 'cool');

    $initials = collect(explode(' ', $customer->name))
        ->map(fn ($p) => strtoupper(substr($p, 0, 1)))
        ->take(2)
        ->implode('');

    $avatarColors = ['#303d89', '#0069d9', '#6d28d9', '#c0392b', '#007a5e', '#2980b9', '#916a00', '#7f8c8d', '#e67e22'];
    $avatarColor = $avatarColors[$customer->id % count($avatarColors)];

    return view('admin.customers.customer-wishlist-detail', compact(
        'customer', 'items', 'totalItems', 'totalValue', 'inStock', 'outOfStock',
        'oldestDays', 'heat', 'initials', 'avatarColor'
    ));
}

protected function exportCustomerCsv(Customer $customer, $items)
{
    $filename = 'wishlist-' . \Illuminate\Support\Str::slug($customer->name) . '-' . now()->format('Y-m-d-His') . '.csv';

    return response()->streamDownload(function () use ($items) {
        $handle = fopen('php://output', 'w');
        fputcsv($handle, ['Product', 'SKU', 'Category', 'Price', 'MRP', 'Discount %', 'Stock Status', 'Date Added']);

        foreach ($items as $item) {
            $product = $item->product;
            fputcsv($handle, [
                $product->name,
                $product->sku ?? $product->product_code,
                optional($product->category)->name ?? 'Uncategorized',
                $product->price,
                $product->mrp,
                $item->hasDiscount ? $item->discountPercent : '',
                $item->stockLabel,
                $item->addedAt->format('Y-m-d H:i'),
            ]);
        }

        fclose($handle);
    }, $filename, [
        'Content-Type' => 'text/csv',
    ]);
}

// Remove a single wishlist item (used by the "×" button on both grid & list views)
public function removeItem($wishlistId)
{
    $wishlist = Wishlist::findOrFail($wishlistId);
    $wishlist->delete();

    return response()->json([
        'success' => true,
        'message' => 'Item removed from wishlist.',
    ]);
}

public function clearWishlist(Customer $customer)
{
    $deletedCount = Wishlist::where('customer_id', $customer->id)->delete();

    return response()->json([
        'success' => true,
        'message' => "Removed {$deletedCount} item(s) from {$customer->name}'s wishlist.",
    ]);
}
}