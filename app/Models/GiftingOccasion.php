<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GiftingOccasion extends Model
{
    protected $fillable = [
        'title',
        'old_id',
        'sub_title',
        'short_description',
        'slug',
        'meta_title',
        'meta_description',
        'image',
        'icon',
        'status'
    ];

    // 🔥 Products linked
    public function products()
    {
        return $this->belongsToMany(
            Product::class,
            'occasion_product',
            'occasion_id',
            'product_id'
        );
    }
}