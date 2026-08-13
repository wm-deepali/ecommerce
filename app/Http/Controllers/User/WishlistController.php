<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Index
    |--------------------------------------------------------------------------
    */

    public function index()
    {
      $wishlists = Wishlist::current()
    ->with([
        'product.category',
        'product.subcategory',
        'product.images',
        'product.variants',   // ← needed for stock-type variant sum below
    ])
    ->latest()
    ->get();

        return view('user.wishlist', compact('wishlists'));
    }

    /*
    |--------------------------------------------------------------------------
    | Add to Wishlist
    |--------------------------------------------------------------------------
    */

    public function add(Request $request)
    {
        $settings = Setting::first();

        if (!$settings || !$settings->wishlist) {
            return response()->json([
                'status' => false,
                'message' => 'Wishlist feature is disabled.',
            ]);
        }

        $product = Product::findOrFail($request->product_id);

        $exists = Wishlist::current()
            ->where('product_id', $product->id)
            ->exists();

        if ($exists) {
            return response()->json([
                'status' => false,
                'message' => 'Product is already in your wishlist.',
                'wishlist_count' => Wishlist::current()->count(),
            ]);
        }

        Wishlist::addProduct($product);
         $trackingEvents = \App\Services\Tracking\PixelTracker::addToWishlist($product); 

        return response()->json([
            'status' => true,
            'message' => 'Product added to wishlist successfully.',
            'wishlist_count' => Wishlist::current()->count(),
            'tracking_events' => $trackingEvents,

        ]);

    }


    /*
    |--------------------------------------------------------------------------
    | Remove from Wishlist
    |--------------------------------------------------------------------------
    */

    public function remove(Request $request, Product $product)
    {
        Wishlist::removeProduct($product);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Removed from wishlist.',
            ]);
        }

        return back()->with('success', 'Item removed from your wishlist.');
    }


    /*
    |--------------------------------------------------------------------------
    | Move to Cart
    |--------------------------------------------------------------------------
    */

    public function moveToCart(Request $request, Product $product)
{
    $product->loadMissing('variants');

    /*
    |--------------------------------------------------------------------------
    | Real stock check — same pattern used on listing/detail pages. A wishlist
    | item can go out of stock after being saved, so this must be re-checked
    | at move time, not just relied on from the page render.
    |--------------------------------------------------------------------------
    */
    $stockVariants = $product->variants->where('type', 'stock');
    $stock = $stockVariants->count()
        ? $stockVariants->sum('stock')
        : $product->stock;

    if ($stock < $product->min_qty) {

        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => "{$product->name} is currently out of stock.",
            ], 422);
        }

        return back()->with('error', "{$product->name} is currently out of stock.");
    }

    /*
    |--------------------------------------------------------------------------
    | Get or create the customer/guest cart — matches CartController@add's
    | schema exactly (cart_id + price/total on the item), not a flat
    | customer_id/session_id row on CartItem which doesn't match the schema.
    |--------------------------------------------------------------------------
    */
    if (auth('customer')->check()) {

        $customer = auth('customer')->user();

        $cart = \App\Models\Cart::firstOrCreate(
            ['user_id' => $customer->id],
            [
                'session_id' => session()->getId(),
                'total_amount' => 0,
                'subtotal' => 0,
                'discount' => 0,
                'tax_amount' => 0,
                'grand_total' => 0,
            ]
        );

    } else {

        $cart = \App\Models\Cart::firstOrCreate(
            ['session_id' => session()->getId()],
            [
                'total_amount' => 0,
                'subtotal' => 0,
                'discount' => 0,
                'tax_amount' => 0,
                'grand_total' => 0,
            ]
        );
    }

    $quantity = $product->min_qty ?: 1;

    // Plain line, no variant/addon selection from the wishlist — merge into
    // an existing identical plain line if one exists, same rule CartController
    // uses for non-customized items.
    $item = CartItem::where('cart_id', $cart->id)
        ->where('product_id', $product->id)
        ->whereNull('price_variant_id')
        ->whereNull('image_variant_id')
        ->whereNull('stock_variant_id')
        ->whereNull('sku_variant_id')
        ->doesntHave('addons')
        ->first();

    if ($item) {

        $newQty = $item->quantity + $quantity;

        if ($newQty > $stock) {
            $newQty = $stock; // cap rather than fail — item is already in cart
        }

        $item->quantity = $newQty;
        $item->total = $item->quantity * $item->price;
        $item->save();

    } else {

        $item = CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => $quantity,
            'price' => $product->price,
            'total' => $quantity * $product->price,
        ]);
    }

    $cart->recalculateTotals();

    Wishlist::removeProduct($product);

    if ($request->expectsJson()) {
        return response()->json([
            'success' => true,
            'message' => "{$product->name} moved to cart.",
        ]);
    }

    return back()->with('success', "{$product->name} moved to your cart.");
}

}