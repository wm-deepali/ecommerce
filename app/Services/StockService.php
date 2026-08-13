<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\StockHistory;
use App\Models\StockSetting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class StockService
{
    /**
     * Add stock — admin restock, bulk import, customer return, etc.
     * Pass $variant to credit a specific stock-type variant instead of the
     * parent product (used when the product has stock-dependent variants).
     */
    public function credit(
        Product $product,
        int $quantity,
        string $reason,
        ?Model $reference = null,
        ?int $createdBy = null,
        ?string $note = null,
        ?ProductVariant $variant = null
    ): StockHistory {
        if ($quantity <= 0) {
            throw new RuntimeException('Credit quantity must be a positive number.');
        }

        return DB::transaction(function () use ($product, $quantity, $reason, $reference, $createdBy, $note, $variant) {
            if ($variant) {
                $variant = ProductVariant::whereKey($variant->id)->lockForUpdate()->first();

                $before = $variant->stock;
                $variant->stock = $before + $quantity;
                $variant->save();

                $after = $variant->stock;

                // Keep the parent product's `stock` column in sync with its
                // stock-type variants — anything reading $product->stock
                // directly (detail page, exports, etc.) stays correct.
                $this->syncProductStockFromVariants($product);
            } else {
                $product = Product::whereKey($product->id)->lockForUpdate()->first();

                $before = $product->stock;
                $product->stock = $before + $quantity;
                $product->save();

                $after = $product->stock;
            }

            $history = $this->logHistory($product, $variant, 'credit', $quantity, $before, $after, $reason, $reference, $createdBy, $note);

            if (!$variant) {
                $this->syncListingVisibility($product);
            }

            return $history;
        });
    }

    /**
     * Remove stock — customer order, damage write-off, etc.
     * Throws if there isn't enough stock unless $allowNegative is true.
     * Pass $variant to debit a specific stock-type variant instead of the
     * parent product (used when the product has stock-dependent variants).
     */
    public function debit(
        Product $product,
        int $quantity,
        string $reason,
        ?Model $reference = null,
        ?int $createdBy = null,
        ?string $note = null,
        bool $allowNegative = false,
        ?ProductVariant $variant = null
    ): StockHistory {
        if ($quantity <= 0) {
            throw new RuntimeException('Debit quantity must be a positive number.');
        }

        return DB::transaction(function () use ($product, $quantity, $reason, $reference, $createdBy, $note, $allowNegative, $variant) {
            if ($variant) {
                // Locks the row so two simultaneous orders can't both pass a stock
                // check against the same starting quantity and oversell the variant.
                $variant = ProductVariant::whereKey($variant->id)->lockForUpdate()->first();

                $before = $variant->stock;

                if (!$allowNegative && $quantity > $before) {
                    throw new RuntimeException(
                        "Insufficient stock for \"{$product->name}\" ({$variant->sku}). Available: {$before}, requested: {$quantity}."
                    );
                }

                $variant->stock = $before - $quantity;
                $variant->save();

                $after = $variant->stock;

                // Keep the parent product's `stock` column in sync with its
                // stock-type variants — anything reading $product->stock
                // directly (detail page, exports, etc.) stays correct.
                $this->syncProductStockFromVariants($product);
            } else {
                // Locks the row so two simultaneous orders can't both pass a stock
                // check against the same starting quantity and oversell the product.
                $product = Product::whereKey($product->id)->lockForUpdate()->first();

                $before = $product->stock;

                if (!$allowNegative && $quantity > $before) {
                    throw new RuntimeException(
                        "Insufficient stock for \"{$product->name}\". Available: {$before}, requested: {$quantity}."
                    );
                }

                $product->stock = $before - $quantity;
                $product->save();

                $after = $product->stock;
            }

            $history = $this->logHistory($product, $variant, 'debit', $quantity, $before, $after, $reason, $reference, $createdBy, $note);

            if (!$variant) {
                $this->syncListingVisibility($product);
            }
            
$this->checkStockAlert($product, $variant, $after);

            return $history;
        });
    }

    /**
     * Set stock to an exact value — used by the inline "Update Stock" field on
     * the Stock Management table. Records the difference as a credit/debit.
     * Pass $variant to set a specific stock-type variant's stock instead of
     * the parent product's.
     */
    public function setStock(
        Product $product,
        int $newStock,
        string $reason,
        ?int $createdBy = null,
        ?string $note = null,
        ?ProductVariant $variant = null
    ): ?StockHistory {
        return DB::transaction(function () use ($product, $newStock, $reason, $createdBy, $note, $variant) {
            if ($variant) {
                $variant = ProductVariant::whereKey($variant->id)->lockForUpdate()->first();

                $before = $variant->stock;
                $diff = $newStock - $before;

                if ($diff === 0) {
                    return null;
                }

                $variant->stock = $newStock;
                $variant->save();

                // Keep the parent product's `stock` column in sync with its
                // stock-type variants — anything reading $product->stock
                // directly (detail page, exports, etc.) stays correct.
                $this->syncProductStockFromVariants($product);
            } else {
                $product = Product::whereKey($product->id)->lockForUpdate()->first();

                $before = $product->stock;
                $diff = $newStock - $before;

                if ($diff === 0) {
                    return null;
                }

                $product->stock = $newStock;
                $product->save();
            }

            $history = $this->logHistory(
                $product,
                $variant,
                $diff > 0 ? 'credit' : 'debit',
                abs($diff),
                $before,
                $newStock,
                $reason,
                null,
                $createdBy,
                $note
            );

            if (!$variant) {
                $this->syncListingVisibility($product);
            }

            return $history;
        });
    }

    /**
     * critical | low | watch | in_stock — purely based on the global thresholds.
     * Pass $variant to check a specific stock-type variant's stock instead of
     * the parent product's.
     */
    public function status(Product $product, ?ProductVariant $variant = null): string
    {
        [$critical, $low, $watch] = $this->thresholds();

        $stock = $variant ? $variant->stock : $product->stock;

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

    public function thresholds(): array
    {
        $settings = StockSetting::current();

        return [
            $settings->critical_threshold,
            $settings->low_stock_threshold,
            $settings->watch_list_threshold,
        ];
    }

    protected function logHistory(
        Product $product,
        ?ProductVariant $variant,
        string $type,
        int $quantity,
        int $before,
        int $after,
        string $reason,
        ?Model $reference,
        ?int $createdBy,
        ?string $note
    ): StockHistory {
        return StockHistory::create([
            'product_id' => $product->id,
            'stock_variant_id' => $variant?->id,
            'type' => $type,
            'quantity' => $quantity,
            'stock_before' => $before,
            'stock_after' => $after,
            'reason' => $reason,
            'reference_type' => $reference ? $reference::class : null,
            'reference_id' => $reference?->getKey(),
            'created_by' => $createdBy,
            'note' => $note,
        ]);
    }

    /**
     * Mirrors the "Auto-Disable Listings" toggle on the Stock Alerts page —
     * hides a product from the storefront once it hits the critical threshold,
     * and brings it back once restocked above it.
     *
     * Only runs for plain-product stock movements. When a stock-type variant
     * is debited/credited, this is intentionally skipped — one variant hitting
     * zero shouldn't disable the whole product while other variants still have
     * stock. Let me know if you want product-level auto-disable to kick in
     * once ALL of a product's stock variants are exhausted; that's a separate
     * check this method doesn't currently make.
     */
    protected function syncListingVisibility(Product $product): void
    {
        if (!StockSetting::current()->auto_disable_out_of_stock) {
            return;
        }

        [$critical] = $this->thresholds();
        $shouldBeActive = $product->stock > $critical;

        if ((bool) $product->status !== $shouldBeActive) {
            $product->update(['status' => $shouldBeActive]);
        }
    }

    /**
     * Keeps the parent product's `stock` column in sync as the sum of its
     * stock-type variants. Called after any variant-level credit/debit/set
     * so `product.stock` never goes stale relative to its variants — e.g.
     * the product detail page, exports, and anything else that reads
     * `$product->stock` directly (without checking variants) stays correct.
     *
     * NOTE: verify `product_id` is the correct FK column name on your
     * product_variants table before relying on this.
     */
    protected function syncProductStockFromVariants(Product $product): void
    {
        $total = ProductVariant::where('product_id', $product->id)
            ->where('type', 'stock')
            ->sum('stock');

        if ($product->stock !== $total) {
            $product->stock = $total;
            $product->save();
        }

        $this->syncListingVisibility($product);
    }

    /**
     * Simplified 3-state status for the Stock Management UI.
     * Returns 'out' | 'low' | 'in'
     * Pass $variant to check a specific stock-type variant's stock instead of
     * the parent product's.
     */
    public function simpleStatus(Product $product, ?ProductVariant $variant = null): string
    {
        [$critical, $low] = $this->thresholds();

        $stock = $variant ? $variant->stock : $product->stock;

        if ($stock <= $critical)
            return 'out';
        if ($stock <= $low)
            return 'low';

        return 'in';
    }
    
    /**
 * Fires an admin notification when stock crosses into low/out-of-stock
 * territory after a debit. Uses the same thresholds as status()/simpleStatus()
 * so the notification lines up with what the Stock Management UI shows.
 */
protected function checkStockAlert(Product $product, ?ProductVariant $variant, int $after): void
{
    [$critical, $low] = $this->thresholds();

    // Only fire on the exact crossing points, not on every debit while
    // already below threshold — avoids spamming a notification per order
    // once a product is already known to be low/out.
    if ($after > $low) {
        return;
    }

    $label = $variant
        ? $product->name . ' (' . ($variant->label ?? $variant->sku) . ')'
        : $product->name;

    $sku = $variant->sku ?? $product->sku ?? null;

    if ($after <= $critical) {
        \App\Models\AdminNotification::notify([
            'type'      => 'stock',
            'title'     => 'Out of stock warning',
            'message'   => "{$label} is now out of stock.",
            'reference' => $sku ?? "PRD-{$product->id}",
            'icon'      => 'fa-exclamation-triangle',
            'url'       => route('admin.products.edit', $product->id),
            'link_text' => 'View Product',
        ]);
    } else {
        \App\Models\AdminNotification::notify([
            'type'      => 'stock',
            'title'     => 'Low stock alert',
            'message'   => "{$label} has only {$after} units remaining. Restock soon to avoid lost sales.",
            'reference' => $sku ?? "PRD-{$product->id}",
            'icon'      => 'fa-exclamation-triangle',
            'url'       => route('admin.products.edit', $product->id),
            'link_text' => 'View Product',
        ]);
    }
}

}