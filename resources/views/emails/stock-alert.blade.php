<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Alert</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { background: #f1f2f4; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Arial, sans-serif; font-size: 14px; color: #202223; }
        .wrapper { max-width: 620px; margin: 32px auto; background: #fff; border-radius: 12px; overflow: hidden; border: 1px solid #e3e5e8; }
        .header { background: #303d89; padding: 24px 28px; }
        .header-title { color: #fff; font-size: 18px; font-weight: 700; }
        .header-sub { color: rgba(255,255,255,.7); font-size: 13px; margin-top: 4px; }
        .body { padding: 24px 28px; }
        .section-title { font-size: 12px; font-weight: 700; letter-spacing: .06em; text-transform: uppercase; margin-bottom: 12px; }
        .section-title.red { color: #b22222; }
        .section-title.amber { color: #916a00; }
        .product-row { display: flex; align-items: center; justify-content: space-between; padding: 10px 14px; border-radius: 8px; margin-bottom: 6px; }
        .product-row.critical { background: #fff8f8; border: 1px solid #f5c6c6; }
        .product-row.low      { background: #fffcf2; border: 1px solid #f0d060; }
        .product-name { font-size: 13px; font-weight: 600; color: #202223; }
        .product-meta { font-size: 11.5px; color: #8c9196; margin-top: 2px; font-family: 'Courier New', monospace; }
        .stock-badge { font-size: 13px; font-weight: 700; padding: 3px 10px; border-radius: 20px; white-space: nowrap; }
        .stock-badge.critical { background: #fce8e8; color: #b22222; }
        .stock-badge.low      { background: #fff5cc; color: #916a00; }
        .divider { height: 1px; background: #e3e5e8; margin: 20px 0; }
        .summary-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; margin-bottom: 20px; }
        .summary-tile { border-radius: 8px; padding: 14px; text-align: center; }
        .summary-tile.red    { background: #fce8e8; }
        .summary-tile.amber  { background: #fff5cc; }
        .summary-tile.blue   { background: #e8f2ff; }
        .summary-tile-val  { font-size: 24px; font-weight: 800; }
        .summary-tile.red   .summary-tile-val { color: #b22222; }
        .summary-tile.amber .summary-tile-val { color: #916a00; }
        .summary-tile.blue  .summary-tile-val { color: #0069d9; }
        .summary-tile-label { font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: .04em; color: #8c9196; margin-top: 4px; }
        .cta { display: block; background: #303d89; color: #fff; text-decoration: none; text-align: center; padding: 12px 24px; border-radius: 8px; font-weight: 600; font-size: 14px; margin-top: 20px; }
        .footer { background: #f9fafb; border-top: 1px solid #e3e5e8; padding: 16px 28px; font-size: 12px; color: #8c9196; text-align: center; }
        .empty-note { font-size: 13px; color: #8c9196; text-align: center; padding: 16px; }
        @media(max-width:480px) { .summary-grid { grid-template-columns: 1fr; } .body { padding: 16px; } }
    </style>
</head>
<body>
<div class="wrapper">

    {{-- Header --}}
    <div class="header">
        <div class="header-title">⚠️ Stock Alert Report</div>
        <div class="header-sub">{{ now()->format('l, d F Y — g:i A') }}</div>
    </div>

    <div class="body">

        {{-- Summary tiles --}}
        <div class="summary-grid">
            <div class="summary-tile red">
                <div class="summary-tile-val">{{ count($critical) }}</div>
                <div class="summary-tile-label">Out of Stock</div>
            </div>
            <div class="summary-tile amber">
                <div class="summary-tile-val">{{ count($low) }}</div>
                <div class="summary-tile-label">Low Stock</div>
            </div>
            <div class="summary-tile blue">
                <div class="summary-tile-val">{{ count($critical) + count($low) }}</div>
                <div class="summary-tile-label">Total Alerts</div>
            </div>
        </div>

        {{-- Critical section --}}
        @if(count($critical) > 0)
            <div class="section-title red">🔴 Out of Stock (≤ {{ $criticalThreshold }} units)</div>
            @foreach($critical as $product)
                <div class="product-row critical">
                    <div>
                        <div class="product-name">{{ $product['name'] }}</div>
                        <div class="product-meta">SKU: {{ $product['sku'] }} · {{ $product['category'] }}</div>
                    </div>
                    <span class="stock-badge critical">{{ $product['stock'] }} left</span>
                </div>
            @endforeach
            <div class="divider"></div>
        @endif

        {{-- Low stock section --}}
        @if(count($low) > 0)
            <div class="section-title amber">🟡 Low Stock (≤ {{ $lowThreshold }} units)</div>
            @foreach($low as $product)
                <div class="product-row low">
                    <div>
                        <div class="product-name">{{ $product['name'] }}</div>
                        <div class="product-meta">SKU: {{ $product['sku'] }} · {{ $product['category'] }}</div>
                    </div>
                    <span class="stock-badge low">{{ $product['stock'] }} left</span>
                </div>
            @endforeach
            <div class="divider"></div>
        @endif

        @if(count($critical) === 0 && count($low) === 0)
            <div class="empty-note">✅ All products are sufficiently stocked.</div>
        @endif

        {{-- CTA --}}
        <a href="{{ route('admin.stock.alerts') }}" class="cta">
            View Stock Alerts Dashboard →
        </a>

    </div>

    <div class="footer">
        This alert was sent automatically by your store's stock monitoring system.<br>
        To disable these emails, turn off <strong>Email Alerts</strong> in the Stock Alerts settings.
    </div>

</div>
</body>
</html>