<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class StoredCartController extends Controller
{
    public function index(Request $request)
    {
        $query = $this->baseQuery();

        $this->applyFilters($query, $request);

        // Stats — always unfiltered
        $totalCarts = Cart::whereNotNull('user_id')->count();
        $totalCartValue = Cart::whereNotNull('user_id')->sum('grand_total');
        $avgCartValue = $totalCarts > 0 ? $totalCartValue / $totalCarts : 0;
        $abandonedToday = Cart::whereNotNull('user_id')
            ->whereDate('updated_at', today())
            ->count();

        $carts = $query->paginate(25)->withQueryString();

        return view('admin.customers.stored-carts', compact(
            'carts',
            'totalCarts',
            'totalCartValue',
            'avgCartValue',
            'abandonedToday'
        ));
    }

    public function export(Request $request): StreamedResponse
    {
        $query = $this->baseQuery();
        $this->applyFilters($query, $request);

        $filename = 'stored-carts-' . now()->format('Y-m-d-His') . '.csv';

        return response()->streamDownload(function () use ($query) {

            $handle = fopen('php://output', 'w');

            // BOM for Excel UTF-8 compatibility
            fwrite($handle, "\xEF\xBB\xBF");

            // Header row
            fputcsv($handle, [
                'Cart ID',
                'Customer Name',
                'Customer Email',
                'Customer Phone',
                'Total Items',
                'Total Qty',
                'Subtotal (₹)',
                'Discount (₹)',
                'Tax Amount (₹)',
                'Grand Total (₹)',
                'Coupon Code',
                'GST Type',
                'Product Names',
                'Last Updated',
                'Cart Age (Days)',
            ]);

            // Stream in chunks of 200 to avoid memory issues
            $query->chunk(200, function ($carts) use ($handle) {
                foreach ($carts as $cart) {
                    $items = $cart->items;
                    $totalQty = $items->sum('quantity');
                    $itemCount = $items->count();
                    $productNames = $items
                        ->map(fn($i) => optional($i->product)->name ?? 'Unknown')
                        ->implode(' | ');

                    fputcsv($handle, [
                        $cart->id,
                        $cart->user?->name ?? '',
                        $cart->user?->email ?? '',
                        $cart->user?->mobile ?? '',
                        $itemCount,
                        $totalQty,
                        number_format($cart->subtotal, 2, '.', ''),
                        number_format($cart->discount ?? 0, 2, '.', ''),
                        number_format($cart->tax_amount ?? 0, 2, '.', ''),
                        number_format($cart->grand_total, 2, '.', ''),
                        $cart->coupon_code ?? '',
                        $cart->gst_type ?? '',
                        $productNames,
                        $cart->updated_at->format('d M Y h:i A'),
                        $cart->updated_at->diffInDays(now()),
                    ]);
                }
            });

            fclose($handle);

        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control' => 'no-store, no-cache',
            'Pragma' => 'no-cache',
        ]);
    }

    public function destroy(Cart $cart)
    {
        $cart->items()->delete();
        $cart->delete();

        return redirect()->route('admin.stored-carts.index')
            ->with('success', 'Cart cleared successfully.');
    }

    // ── Shared helpers ────────────────────────────────────────────────────────

    private function baseQuery()
    {
        return Cart::with(['user', 'items.product', 'items.imageVariant', 'items.skuVariant', 'items.addons'])
            ->whereNotNull('user_id')
            ->where(fn($q) => $q->where('grand_total', '>', 0)
                ->orWhere('total_amount', '>', 0));
    }

    private function applyFilters($query, Request $request): void
    {
        if ($search = $request->input('search')) {
            $query->whereHas(
                'user',
                fn($q) =>
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
            );
        }

        if ($age = $request->input('cart_age')) {
            $query->where('updated_at', '>=', match ($age) {
                'today' => now()->startOfDay(),
                '2days' => now()->subDays(2),
                'week' => now()->subDays(7),
                default => now()->subYears(10),
            });
        }

        if ($minVal = $request->input('min_value')) {
            $query->where('grand_total', '>=', $minVal);
        }

        $sortBy = $request->input('sort_by', 'updated_at');
        $query->orderBy(
            in_array($sortBy, ['updated_at', 'grand_total']) ? $sortBy : 'updated_at',
            'desc'
        );
    }
}