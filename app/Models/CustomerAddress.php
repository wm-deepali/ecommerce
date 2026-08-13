<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    protected $fillable = [

        'customer_id',

        'name',
        'email',
        'phone',

        'address_line_1',
        'address_line_2',

        'state_id',
        'city_id',

        'pincode',

        'address_type',

        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function customer()
    {
        return $this->belongsTo(
            Customer::class
        );
    }

    public function state()
    {
        return $this->belongsTo(
            State::class
        );
    }

    public function city()
    {
        return $this->belongsTo(
            City::class
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function isDefault()
    {
        return $this->is_default;
    }

    public function fullAddress()
    {
        return collect([
            $this->address_line_1,
            $this->address_line_2,
            $this->city?->name,
            $this->state?->name,
            $this->pincode,
            $this->country,
        ])->filter()->implode(', ');
    }

    public function orders()
    {
        return $this->hasMany(
            Order::class,
            'address_id'
        );
    }

}