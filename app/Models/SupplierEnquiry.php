<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierEnquiry extends Model
{
    protected $fillable = [
        'name',
        'company',
        'email',
        'phone',
        'category_id',
        'quantity',
        'delivery_date',
        'description',
        'city',
        'catalogue',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}