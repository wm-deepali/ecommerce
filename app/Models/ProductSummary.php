<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSummary extends Model
{
    protected $fillable = [
        'product_id',
        'summary'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}