<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnquiryItem extends Model
{
    protected $fillable = [
        'enquiry_id',
        'product_id',
        'customization_id',
        'quantity',
        'price',
        'total',
        'options'
    ];

    public function enquiry()
    {
        return $this->belongsTo(Enquiry::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function customization()
    {
        return $this->belongsTo(Customization::class);
    }
}