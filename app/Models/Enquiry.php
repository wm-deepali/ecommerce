<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    protected $fillable = [
        'business_name',
        'owner_name',
        'email',
        'mobile',
        'address',
        'state_id',
        'city_id',
        'user_id',
        'session_id'
    ];

    // Relations
    public function items()
    {
        return $this->hasMany(EnquiryItem::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
