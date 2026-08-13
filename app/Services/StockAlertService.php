<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Setting;
use App\Models\StockSetting;
use App\Services\Email\EmailDispatcher;
use Illuminate\Support\Facades\Log;

class StockAlertService
{
    public function __construct(protected StockService $stock) {}

    public function sendAlertEmailIfNeeded(): void
    {
        $settings = StockSetting::current();

        if (!$settings->notify_email) {
            return;
        }

        [$critical, $low] = $this->stock->thresholds();

        $variantProductIds = ProductVariant::where('type', 'stock')->pluck('product_id')->unique();

        $criticalProducts = Product::with('category')
            ->whereNotIn('id', $variantProductIds)
            ->where('stock', '<=', $critical)
            ->orderBy('stock')
            ->get();

        $lowProducts = Product::with('category')
            ->whereNotIn('id', $variantProductIds)
            ->where('stock', '>', $critical)
            ->where('stock', '<=', $low)
            ->orderBy('stock')
            ->get();

        $criticalVariants = ProductVariant::where('type', 'stock')
            ->where('stock', '<=', $critical)
            ->with('product.category')
            ->orderBy('stock')
            ->get()
            ->filter(fn($v) => $v->product);

        $lowVariants = ProductVariant::where('type', 'stock')
            ->where('stock', '>', $critical)
            ->where('stock', '<=', $low)
            ->with('product.category')
            ->orderBy('stock')
            ->get()
            ->filter(fn($v) => $v->product);

        $totalCritical = $criticalProducts->count() + $criticalVariants->count();
        $totalLow = $lowProducts->count() + $lowVariants->count();

        if ($totalCritical === 0 && $totalLow === 0) {
            return;
        }

        $adminEmail = Setting::first()?->admin_email;

        if (!$adminEmail) {
            return;
        }

        try {
            EmailDispatcher::send(
                'low-stock-alert',
                $adminEmail,
                [
                    '{report_date}' => now()->format('l, d F Y — g:i A'),

                    '{total_count}' => $totalCritical + $totalLow,
                    '{critical_count}' => $totalCritical,
                    '{low_count}' => $totalLow,
                    '{critical_threshold}' => $critical,
                    '{low_threshold}' => $low,

                    '{critical_products}' => $this->renderProductList(
                        $criticalProducts,
                        $criticalVariants,
                        '🔴 Out of Stock (≤ ' . $critical . ' units)',
                        'critical'
                    ),
                    '{low_products}' => $this->renderProductList(
                        $lowProducts,
                        $lowVariants,
                        '🟡 Low Stock (≤ ' . $low . ' units)',
                        'low'
                    ),

                    '{admin_stock_url}' => route('admin.stock.alerts'),
                ]
            );
        } catch (\Exception $e) {
            Log::error('Stock alert email failed: ' . $e->getMessage());
        }
    }

    /**
     * Render a list of colored rows for both plain products and stock-type
     * variants, used to fill the {critical_products} / {low_products}
     * smart blocks.
     */
    protected function renderProductList($products, $variants, string $sectionTitle, string $variant): string
    {
        if ($products->isEmpty() && $variants->isEmpty()) {
            return '';
        }

        $isCritical = $variant === 'critical';

        $rowBg = $isCritical ? '#fff8f8' : '#fffcf2';
        $rowBorder = $isCritical ? '#f5c6c6' : '#f0d060';
        $badgeBg = $isCritical ? '#fce8e8' : '#fff5cc';
        $badgeColor = $isCritical ? '#b22222' : '#916a00';
        $titleColor = $isCritical ? '#b22222' : '#916a00';

        $rows = '';

        $renderRow = function (string $name, string $meta, int $stock) use ($rowBg, $rowBorder, $badgeBg, $badgeColor) {
            return "
        <tr>
            <td style='padding:10px 14px;background:{$rowBg};border:1px solid {$rowBorder};border-radius:8px 0 0 8px'>
                <div style='font-size:13px;font-weight:600;color:#202223'>{$name}</div>
                <div style='font-size:11.5px;color:#8c9196;margin-top:2px;font-family:\"Courier New\",monospace'>{$meta}</div>
            </td>
            <td style='padding:10px 14px;background:{$rowBg};border:1px solid {$rowBorder};border-left:none;border-radius:0 8px 8px 0;text-align:right;white-space:nowrap'>
                <span style='font-size:13px;font-weight:700;padding:3px 10px;border-radius:20px;background:{$badgeBg};color:{$badgeColor}'>{$stock} left</span>
            </td>
        </tr>
        <tr><td colspan='2' style='height:6px;line-height:6px;font-size:0'>&nbsp;</td></tr>";
        };

        foreach ($products as $product) {
            $sku = $product->sku ?? '—';
            $category = $product->category->name ?? 'Uncategorized';
            $rows .= $renderRow($product->name, "SKU: {$sku} · {$category}", $product->stock);
        }

        foreach ($variants as $productVariant) {
            $product = $productVariant->product;
            $sku = $productVariant->sku ?? '—';
            $category = $product->category->name ?? 'Uncategorized';
            $rows .= $renderRow($product->name . ' — ' . ($productVariant->sku ?: "Variant #{$productVariant->id}"), "SKU: {$sku} · {$category}", $productVariant->stock);
        }

        return "
    <div style='font-size:12px;font-weight:700;letter-spacing:.06em;text-transform:uppercase;color:{$titleColor};margin:20px 0 10px'>{$sectionTitle}</div>
    <table style='width:100%;border-collapse:separate;border-spacing:0' cellpadding='0' cellspacing='0'>
        <tbody>{$rows}
        </tbody>
    </table>";
    }
}