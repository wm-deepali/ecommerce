<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = [
        'product_id',
        'image',
        'thumb',
        'is_default',
        'sort_order',
    ];

    protected $casts = [

        'is_default' => 'boolean',

    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}