<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = [
        'name',
        'logo',
        'status'
    ];

    public function categories()
    {
        return $this->belongsToMany(
            Category::class,
            'brand_category'
        );
    }
}
