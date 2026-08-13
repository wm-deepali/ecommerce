<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ProductVariant extends Model
{
    // type: 'price' | 'image' | 'stock' | 'sku'
    // Each row belongs to exactly one dependency type — it only carries
    // the field(s) relevant to that type. This lets a product have, say,
    // an independent Image-variant table (built from Colour only) and a
    // separate Price-variant table (built from Colour + Size combined).
    const TYPE_PRICE = 'price';
    const TYPE_IMAGE = 'image';
    const TYPE_STOCK = 'stock';
    const TYPE_SKU = 'sku';
    protected $fillable = [
        'product_id',
        'type',
        'sku',
        'mrp',
        'discount_type',
        'discount',
        'price',
        'stock',
        'image',
        'status',
        'is_available'
    ];
    protected $casts = [
        'status' => 'boolean',
            'is_available' => 'boolean',

    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function values()
    {
        return $this->hasMany(ProductVariantValue::class, 'variant_id');
    }

    // ✅ New: multiple images per image-type variant, stored in
    // product_variant_images (one row per image, with is_default flag).
    // The existing single `image` column stays in sync as a convenience
    // pointer to the default/first image, so any older code reading
    // $variant->image directly keeps working.
    public function images()
    {
        return $this->hasMany(ProductVariantImage::class, 'variant_id');
    }

    public function priceCartItems()
    {
        return $this->hasMany(CartItem::class, 'price_variant_id');
    }
    public function imageCartItems()
    {
        return $this->hasMany(CartItem::class, 'image_variant_id');
    }
    public function stockCartItems()
    {
        return $this->hasMany(CartItem::class, 'stock_variant_id');
    }
    public function skuCartItems()
    {
        return $this->hasMany(CartItem::class, 'sku_variant_id');
    }
    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }
}