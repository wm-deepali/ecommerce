<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use App\Models\Coupon;
use App\Models\AttributeValue;
use App\Models\ProductAddon;
use App\Services\Tracking\PixelTracker;

class CartController extends Controller
{

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',

            'price_variant_id' => 'nullable|exists:product_variants,id',
            'image_variant_id' => 'nullable|exists:product_variants,id',
            'stock_variant_id' => 'nullable|exists:product_variants,id',
            'sku_variant_id' => 'nullable|exists:product_variants,id',

            'selected_values' => 'nullable|array',
            'selected_values.*' => 'integer|exists:attribute_values,id',

            'addon_ids' => 'nullable|array',
            'addon_ids.*' => 'integer|exists:product_addons,id',

            'quantity' => 'nullable|integer|min:1',
        ]);

      $product = Product::with('variants.values')->findOrFail($request->product_id);
$quantity = $request->quantity ?? $product->min_qty;

/*
|--------------------------------------------------------------------------
| Default-variant resolution — jab koi variant id bheja hi nahi gaya
| (listing page ka "Add to Cart"), lekin product ke variants hain, to
| khud-ba-khud ek in-stock combination pick karo.
|--------------------------------------------------------------------------
*/
if (!$request->filled('stock_variant_id') && $product->variants->isNotEmpty()) {

    $stockVariants = $product->variants->where('type', 'stock');

    $defaultStockVariant = $stockVariants->firstWhere('stock', '>', 0)
        ?? $stockVariants->first();

    if ($defaultStockVariant) {

        $defaultValueIds = $defaultStockVariant->values
            ->pluck('attribute_value_id')
            ->sort()
            ->values()
            ->toArray();

        $request->merge([
            'stock_variant_id' => $defaultStockVariant->id,
            'selected_values' => $defaultValueIds,
        ]);

        foreach (['price', 'image', 'sku'] as $type) {

            $match = $product->variants
                ->where('type', $type)
                ->first(function ($variant) use ($defaultValueIds) {
                    $ids = $variant->values
                        ->pluck('attribute_value_id')
                        ->sort()
                        ->values()
                        ->toArray();
                    return $ids === $defaultValueIds;
                });

            if ($match) {
                $request->merge([$type . '_variant_id' => $match->id]);
            }
        }
    }
}

$priceVariant = $request->price_variant_id ? ProductVariant::find($request->price_variant_id) : null;
        $imageVariant = $request->image_variant_id ? ProductVariant::find($request->image_variant_id) : null;
        $stockVariant = $request->stock_variant_id ? ProductVariant::find($request->stock_variant_id) : null;
        $skuVariant = $request->sku_variant_id ? ProductVariant::find($request->sku_variant_id) : null;

        $price = $priceVariant->price ?? $product->price;
        $stock = $stockVariant->stock ?? $product->stock;

        if ($stock < $product->min_qty) {
            return response()->json([
                'status' => false,
                'message' => 'Product is out of stock.'
            ], 422);
        }

        if ($quantity > $stock) {
            return response()->json([
                'status' => false,
                'message' => "Only {$stock} units available."
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | Selected attribute values — snapshot for display (Size: L, Color: Red)
        | Independent of the 4 variant ids above, since a selectable attribute
        | may not be price/image/stock/sku-dependent at all.
        |--------------------------------------------------------------------------
        */
        $selectedAttributes = [];

        if ($request->filled('selected_values')) {
            $selectedAttributes = AttributeValue::with('attribute')
                ->whereIn('id', $request->selected_values)
                ->get()
                ->map(fn($av) => [
                    'attribute_id' => $av->attribute_id,
                    'attribute' => $av->attribute->name ?? null,
                    'value_id' => $av->id,
                    'value' => $av->value,
                ])
                ->values()
                ->toArray();
        }

        /*
        |--------------------------------------------------------------------------
        | Selected addons — snapshot detail + price (per unit)
        |--------------------------------------------------------------------------
        */
        $selectedAddons = collect();

        if ($request->filled('addon_ids')) {
            $selectedAddons = ProductAddon::where('product_id', $product->id)
                ->whereIn('id', $request->addon_ids)
                ->get();
        }

        $addonUnitTotal = $selectedAddons->sum('price');

        /*
        |--------------------------------------------------------------------------
        | Get Cart
        |--------------------------------------------------------------------------
        */

        if (auth('customer')->check()) {

            $customer = auth('customer')->user();

            $cart = Cart::firstOrCreate(
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

            $cart = Cart::firstOrCreate(
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

        /*
        |--------------------------------------------------------------------------
        | Existing Item — customized lines (with addons) always create a new
        | line rather than merging, so each customization stays distinct.
        | Plain lines (no addons) still merge on identical variant selection,
        | same as before.
        |--------------------------------------------------------------------------
        */
        $item = null;

        if ($selectedAddons->isEmpty()) {
            $item = CartItem::where('cart_id', $cart->id)
                ->where('product_id', $product->id)
                ->where('price_variant_id', $priceVariant->id ?? null)
                ->where('image_variant_id', $imageVariant->id ?? null)
                ->where('stock_variant_id', $stockVariant->id ?? null)
                ->where('sku_variant_id', $skuVariant->id ?? null)
                ->doesntHave('addons')
                ->first();
        }

        if ($item) {

            $newQty = $item->quantity + $quantity;

            if ($newQty > $stock) {
                return response()->json([
                    'status' => false,
                    'message' => "Only {$stock} units available."
                ], 422);
            }

            $item->quantity = $newQty;
            $item->total = $item->quantity * ($item->price + $addonUnitTotal);
            $item->save();

        } else {

            $item = CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,

                'price_variant_id' => $priceVariant->id ?? null,
                'image_variant_id' => $imageVariant->id ?? null,
                'stock_variant_id' => $stockVariant->id ?? null,
                'sku_variant_id' => $skuVariant->id ?? null,

                'selected_attributes' => $selectedAttributes,

                'quantity' => $quantity,
                'price' => $price,
                'total' => $quantity * ($price + $addonUnitTotal),
            ]);

            foreach ($selectedAddons as $addon) {
                $item->addons()->create([
                    'addon_id' => $addon->id,
                    'detail' => $addon->detail,
                    'price' => $addon->price,
                ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Recalculate Cart
        |--------------------------------------------------------------------------
        */

        $cart->recalculateTotals();
        $cart->refresh();

        // Adding items can only make a coupon's conditions easier to satisfy,
        // but a percentage discount amount still needs to track the new subtotal.
        $couponResult = $this->revalidateCoupon($cart);

        if ($couponResult && $couponResult['removed']) {
            $cart->recalculateTotals();
            $cart->refresh();
        }

 /*
        |--------------------------------------------------------------------------
        | Pixel/GA tracking — add-to-cart event. Price used is the resolved
        | variant price (or base price), same value the cart line was priced at.
        |--------------------------------------------------------------------------
        */
        $trackingEvents = PixelTracker::addToCart($product, $quantity, $price);
        
        /*
        |--------------------------------------------------------------------------
        | Render mini cart partial — lets the frontend swap the sidebar in
        | without a full page reload.
        |--------------------------------------------------------------------------
        */
        $cart->load([
            'items.product',
            'items.imageVariant',
            'items.addons',
        ]);

        $miniCartHtml = view('layouts.mini-cart', ['miniCart' => $cart])->render();

        return response()->json([
            'status' => true,
            'message' => 'Product added to cart successfully.',
            'cart_count' => $cart->items()->sum('quantity'),
            'cart_total' => $cart->grand_total,
            'cart_subtotal' => number_format($cart->total_amount ?? $cart->items()->sum('total'), 2),
            'mini_cart_html' => $miniCartHtml,
            'coupon_removed' => $couponResult['removed'] ?? false,
            'coupon_message' => $couponResult['message'] ?? null,
            'discount' => $cart->discount,
            'tracking_events' => $trackingEvents,
        ]);
    }

    public function cart()
    {
        $with = [
            'items.product.images',
            'items.product.category',
            'items.product.subcategory',
            'items.priceVariant',
            'items.addons',
        ];

        if (auth('customer')->check()) {

            $cart = Cart::with($with)
                ->where('user_id', auth('customer')->id())
                ->first();

        } else {

            $cart = Cart::with($with)
                ->where('session_id', session()->getId())
                ->first();
        }

        // Recalculate GST based on latest default address
        if ($cart) {
            $cart->recalculateTotals();
            $cart->refresh();

            // Cart may have been touched from another tab/request since the coupon was applied
            $this->revalidateCoupon($cart);
            $cart->refresh();
        }

        return view(
            'front-pages.cart',
            compact('cart')
        );
    }

   public function remove($id)
    {
        $item = CartItem::findOrFail($id);

        if (auth('customer')->check()) {
            if ($item->cart->user_id != auth('customer')->id()) {
                abort(403);
            }
        } else {
            if ($item->cart->session_id != session()->getId()) {
                abort(403);
            }
        }

        $cart = $item->cart;

  // capture before delete — product/qty/price won't exist on $item after this
        $trackingEvents = PixelTracker::removeFromCart(
            $item->product,
            $item->quantity,
            $item->price
        );


        $item->delete();

        $cart->recalculateTotals();
        $cart->refresh();

        $couponResult = $this->revalidateCoupon($cart);

        if ($couponResult && $couponResult['removed']) {
            $cart->recalculateTotals();
            $cart->refresh();
        }

        $cart->load(['items.product', 'items.imageVariant', 'items.addons']);
        $miniCartHtml = view('layouts.mini-cart', ['miniCart' => $cart])->render();

        return response()->json([
            'status' => true,
            'message' => 'Item removed successfully',
            'cart_total' => $cart->grand_total,
            'cart_count' => $cart->items()->sum('quantity'),
            'cart_subtotal' => number_format($cart->total_amount ?? $cart->items()->sum('total'), 2),
            'mini_cart_html' => $miniCartHtml,
            'coupon_removed' => $couponResult['removed'] ?? false,
            'coupon_message' => $couponResult['message'] ?? null,
            'discount' => $cart->discount,
             'tracking_events' => $trackingEvents,
        ]);
    }

    public function updateQuantity(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:cart_items,id',
            'action' => 'required|in:plus,minus',
        ]);

        $item = CartItem::findOrFail($request->item_id);

        if (auth('customer')->check()) {

            if ($item->cart->user_id != auth('customer')->id()) {
                abort(403);
            }

        } else {

            if ($item->cart->session_id != session()->getId()) {
                abort(403);
            }
        }

        // Stock now comes from the item's stock-variant (if any), else the
        // base product — same idea as before, just repointed to the new column.
        $stock = $item->stockVariant
            ? $item->stockVariant->stock
            : $item->product->stock;

        $minQty = $item->product->min_qty;

        if ($request->action == 'plus') {

            if ($item->quantity + 1 > $stock) {

                return response()->json([
                    'status' => false,
                    'message' => 'Only ' . $stock . ' units available in stock.'
                ], 422);
            }

            $item->quantity++;

        } elseif ($request->action == 'minus') {

            if ($item->quantity - 1 >= $minQty) {
                $item->quantity--;
            }
        }

        // Addon prices are per-unit, so they scale with quantity too — same
        // rule as the "Add to Cart" price computation.
        $addonUnitTotal = $item->addons->sum('price');

        $item->total = $item->quantity * ($item->price + $addonUnitTotal);
        $item->save();

       $cart = $item->cart;

        $cart->recalculateTotals();
        $cart->refresh();

        $couponResult = $this->revalidateCoupon($cart);

        if ($couponResult && $couponResult['removed']) {
            $cart->recalculateTotals();
            $cart->refresh();
        }

        $baseMrp = $item->priceVariant->mrp ?? $item->product->mrp;
        $totalMrp = ($baseMrp + $addonUnitTotal) * $item->quantity;

        $cart->load(['items.product', 'items.imageVariant', 'items.addons']);
        $miniCartHtml = view('layouts.mini-cart', ['miniCart' => $cart])->render();

        return response()->json([
            'status' => true,
            'quantity' => $item->quantity,
            'item_total' => $item->total,
            'total_mrp' => $totalMrp,
            'cart_total' => $cart->grand_total,
            'cart_count' => $cart->items()->sum('quantity'),
            'cart_subtotal' => number_format($cart->total_amount ?? $cart->items()->sum('total'), 2),
            'mini_cart_html' => $miniCartHtml,
            'coupon_removed' => $couponResult['removed'] ?? false,
            'coupon_message' => $couponResult['message'] ?? null,
            'discount' => $cart->discount,
        ]);
    }

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required'
        ]);

        $cart = auth('customer')->check()
            ? Cart::where('user_id', auth('customer')->id())->first()
            : Cart::where('session_id', session()->getId())->first();

        if (!$cart) {
            return response()->json([
                'status' => false,
                'message' => 'Cart not found'
            ]);
        }

        $coupon = Coupon::where('code', $request->coupon_code)
            ->where('status', 1)
            ->first();

        if (!$coupon) {

            return response()->json([
                'status' => false,
                'message' => 'Invalid coupon code'
            ]);
        }

        if ($coupon->start_date && now()->lt($coupon->start_date)) {

            return response()->json([
                'status' => false,
                'message' => 'Coupon not started yet'
            ]);
        }

        if ($coupon->end_date && now()->gt($coupon->end_date)) {

            return response()->json([
                'status' => false,
                'message' => 'Coupon expired'
            ]);
        }

        $subtotal = $cart->items()->sum('total');

        if (
            $coupon->minimum_order_amount &&
            $subtotal < $coupon->minimum_order_amount
        ) {

            return response()->json([
                'status' => false,
                'message' => 'Minimum order amount not reached'
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Minimum Order Quantity Check
        |--------------------------------------------------------------------------
        */

        $totalQuantity = $cart->items()->sum('quantity');

        if (
            $coupon->minimum_order_quantity &&
            $totalQuantity < $coupon->minimum_order_quantity
        ) {

            $remainingQty = $coupon->minimum_order_quantity - $totalQuantity;

            return response()->json([
                'status' => false,
                'message' => "Add {$remainingQty} more item" . ($remainingQty > 1 ? 's' : '') . " to unlock this coupon (minimum {$coupon->minimum_order_quantity} items required)."
            ]);
        }

        if ($coupon->discount_type == 'percentage') {

            $discount =
                ($subtotal * $coupon->discount_value) / 100;

            if (
                $coupon->maximum_discount &&
                $discount > $coupon->maximum_discount
            ) {
                $discount = $coupon->maximum_discount;
            }

        } else {

            $discount = $coupon->discount_value;
        }

        $cart->update([
            'coupon_id' => $coupon->id,
            'coupon_code' => $coupon->code,
            'discount' => $discount
        ]);

        $cart->recalculateTotals();
        $cart->refresh();

        return response()->json([
            'status' => true,
            'message' => 'Coupon applied successfully'
        ]);
    }

    public function removeCoupon()
    {
        $cart = auth('customer')->check()
            ? Cart::where('user_id', auth('customer')->id())->first()
            : Cart::where('session_id', session()->getId())->first();

        $cart->update([
            'coupon_id' => null,
            'coupon_code' => null,
            'discount' => 0
        ]);

        $cart->recalculateTotals();
        $cart->refresh();

        return response()->json([
            'status' => true
        ]);
    }

    /**
     * Re-check an applied coupon's conditions against the cart's current
     * subtotal/quantity. Removes the coupon if it no longer qualifies,
     * and re-syncs a percentage discount's amount if the subtotal shifted.
     *
     * Call this after any operation that changes cart contents (add,
     * remove, quantity update) — right after recalculateTotals()/refresh().
     */
    private function revalidateCoupon(Cart $cart): ?array
    {
        if (!$cart->coupon_id) {
            return null;
        }

        $coupon = Coupon::find($cart->coupon_id);

        if (!$coupon || !$coupon->status) {
            $cart->update(['coupon_id' => null, 'coupon_code' => null, 'discount' => 0]);

            return [
                'removed' => true,
                'message' => 'Your applied coupon is no longer available and has been removed.',
            ];
        }

        $subtotal = $cart->subtotal;
        $totalQuantity = $cart->items()->sum('quantity');

        $amountOk = !$coupon->minimum_order_amount || $subtotal >= $coupon->minimum_order_amount;
        $qtyOk = !$coupon->minimum_order_quantity || $totalQuantity >= $coupon->minimum_order_quantity;

        if (!$amountOk || !$qtyOk) {
            $cart->update(['coupon_id' => null, 'coupon_code' => null, 'discount' => 0]);

            return [
                'removed' => true,
                'message' => "Coupon \"{$coupon->code}\" was removed — your cart no longer meets its minimum requirement.",
            ];
        }

        // Cart still qualifies — but a percentage discount amount needs to
        // track the new subtotal (flat discounts don't change).
        if ($coupon->discount_type === 'percentage') {
            $discount = ($subtotal * $coupon->discount_value) / 100;

            if ($coupon->maximum_discount && $discount > $coupon->maximum_discount) {
                $discount = $coupon->maximum_discount;
            }

            if ((float) $discount !== (float) $cart->discount) {
                $cart->update(['discount' => $discount]);
            }
        }

        return ['removed' => false];
    }

}