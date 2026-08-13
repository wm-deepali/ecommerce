<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryAttribute extends Model
{
    protected $fillable = [
        'category_id',
        'attribute_id',

        'is_required',

        'used_for_variant',

        'is_selectable',

        'price_dependent',
        'image_dependent',
        'stock_dependent',
        'sku_dependent',

        'show_in_filter',
        'show_on_listing',

        'sort_order',
        'status',
    ];

    protected $casts = [
        'is_required'      => 'boolean',

        'used_for_variant' => 'boolean',

        'is_selectable'    => 'boolean',

        'price_dependent'  => 'boolean',
        'image_dependent'  => 'boolean',
        'stock_dependent'  => 'boolean',
        'sku_dependent'    => 'boolean',

        'show_in_filter'   => 'boolean',
        'show_on_listing'  => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function values()
    {
        return $this->attribute->values();
    }

    /*
    |--------------------------------------------------------------------------
    | Dependency mode resolvers
    |--------------------------------------------------------------------------
    | 'none'         → this attribute doesn't affect this thing
    | 'independent'  → this attribute alone decides it
    | 'combination'  → this attribute + others (all *_dependent=true in the
    |                   same category) jointly decide it
    */

    public function priceMode(): string
    {
        return $this->resolveMode('price_dependent');
    }

    public function imageMode(): string
    {
        return $this->resolveMode('image_dependent');
    }

    public function stockMode(): string
    {
        return $this->resolveMode('stock_dependent');
    }

    public function skuMode(): string
    {
        return $this->resolveMode('sku_dependent');
    }

    /**
     * Does this attribute participate in variant generation at all —
     * i.e. is it selectable AND drives at least one of price/image/stock/sku?
     */
    public function isVariantAttribute(): bool
    {
        return $this->used_for_variant && (
            $this->price_dependent ||
            $this->image_dependent ||
            $this->stock_dependent ||
            $this->sku_dependent
        );
    }

    protected function resolveMode(string $field): string
    {
        if (! $this->{$field}) {
            return 'none';
        }

        $countInCategory = static::where('category_id', $this->category_id)
            ->where($field, true)
            ->count();

        return $countInCategory > 1 ? 'combination' : 'independent';
    }

    /**
     * Get all sibling attributes (including self) that share this
     * category and have the given dependency flag turned on.
     * Useful for building the cartesian-product variant table.
     */
    public static function dependentGroup(int $categoryId, string $field)
    {
        return static::with('attribute.values')
            ->where('category_id', $categoryId)
            ->where($field, true)
            ->orderBy('sort_order')
            ->get();
    }
}