<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [

        'order_id',

        'product_id',

        // ── Type-specific variant refs (replaces old single variant_id) ──
        'price_variant_id',
        'image_variant_id',
        'stock_variant_id',
        'sku_variant_id',

        // Snapshot of all selected attribute values, carried over from the
        // cart item at order time — for display purposes only.
        'selected_attributes',

        'product_name',

        'quantity',

        'price',
        'total',
    ];

    protected $casts = [
        'selected_attributes' => 'array',
    ];

    public function order()
    {
        return $this->belongsTo(
            Order::class
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
        return $this->hasMany(OrderItemAddon::class);
    }

    public function getAddonsTotalAttribute()
    {
        return $this->addons->sum('price');
    }

    public function review()
    {
        return $this->hasOne(ProductReview::class);
    }

}