<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [

        'category_id',
        'subcategory_id',

        'name',
        'slug',

        'sku',
        'product_code',

        'short_description',
        'description',
        'delivery_returns',
        'fabric_care',

        // ✅ new Content-tab fields
        'shipping_delivery',
        'exchange_policy',
        'customization_assistance',

        'mrp',
        'discount_type',
        'discount',
        'price',

        'stock',
        'min_qty',

        'delivery_time',

        'quality',
        'pan_india',

        'meta_title',
        'meta_description',

        'status',

    ];

    protected $casts = [

        'status' => 'boolean',
        'quality' => 'boolean',
        'pan_india' => 'boolean',

    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Category::class, 'subcategory_id');
    }

    /**
     * ✅ Used across all grid/listing views (homepage sections, product
     * listing pages, luxury tabs, etc). Prefers the compressed THUMB
     * (400px) since these are always shown small — falls back to the
     * full image for older rows created before the thumb column existed.
     */
    public function getDisplayImageAttribute()
    {
        $default = $this->images()
            ->where('is_default', 1)
            ->first();

        if ($default) {
            return asset('storage/' . ($default->thumb ?? $default->image));
        }

        $image = $this->images()->first();

        return $image
            ? asset('storage/' . ($image->thumb ?? $image->image))
            : null;
    }

    public function attributeValues()
    {
        return $this->hasMany(ProductAttributeValue::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    // ✅ new: product videos (Media → Video)
    public function videos()
    {
        return $this->hasMany(ProductVideo::class);
    }

    // ✅ new: addon options (Addon Options section)
    public function addons()
    {
        return $this->hasMany(ProductAddon::class);
    }

    // OCCASIONS
    public function occasions()
    {
        return $this->belongsToMany(
            GiftingOccasion::class,
            'occasion_product',
            'product_id',
            'occasion_id'
        );
    }

    public function collections()
    {
        return $this->belongsToMany(
            Collection::class,
            'collection_product',
            'product_id',
            'collection_id'
        );
    }

    public function cartItems()
    {
        return $this->hasMany(
            CartItem::class
        );
    }

    public function scopeVisible($query)
    {
        $query->where('status', 1);

        if (StockSetting::current()->auto_disable_out_of_stock) {
            $query->where('stock', '>', 0);
        }

        return $query;
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function approvedReviews()
    {
        return $this->hasMany(ProductReview::class)->where('status', 'approved');
    }

    public function keywords()
    {
        return $this->hasMany(ProductKeyword::class);
    }

}