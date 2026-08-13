<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = [

        'cart_id',
        'product_id',

        // ── Type-specific variant refs (replaces old single variant_id) ──
        'price_variant_id',
        'image_variant_id',
        'stock_variant_id',
        'sku_variant_id',

        // Snapshot of all selected attribute values (variant-backed or not),
        // for display purposes only — not used in price/stock computation.
        'selected_attributes',

        'quantity',

        'price',
        'total',

    ];

    protected $casts = [
        'selected_attributes' => 'array',
    ];

    public function cart()
    {
        return $this->belongsTo(
            Cart::class
        );
    }

    public function product()
    {
        return $this->belongsTo(
            Product::class
        );
    }

    public function priceVariant()
    {
        return $this->belongsTo(ProductVariant::class, 'price_variant_id');
    }

    public function imageVariant()
    {
        return $this->belongsTo(ProductVariant::class, 'image_variant_id');
    }

    public function stockVariant()
    {
        return $this->belongsTo(ProductVariant::class, 'stock_variant_id');
    }

    public function skuVariant()
    {
        return $this->belongsTo(ProductVariant::class, 'sku_variant_id');
    }

    public function addons()
    {
        return $this->hasMany(CartItemAddon::class);
    }

    public function getAddonsTotalAttribute()
    {
        return $this->addons->sum('price');
    }
}