<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorEnquiry extends Model
{
    protected $fillable = [
        'name',
        'company',
        'email',
        'phone',
        'vendor_type_id',
        'description',
        'capacity',
        'city',
        'catalogue',
        'status'
    ];

    public function type()
    {
        return $this->belongsTo(VendorType::class, 'vendor_type_id');
    }
}