<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [

        'customer_id',
        'address_id',

        'order_number',

        'customer_name',
        'customer_email',
        'customer_phone',

        'address_line_1',
        'address_line_2',

        'state_id',
        'city_id',
        'pincode',

        'coupon_code',

        'subtotal',
        'discount',
        'tax_amount',
        'grand_total',

        'gst_type',

        'cgst_rate',
        'sgst_rate',
        'igst_rate',

        'cgst_amount',
        'sgst_amount',
        'igst_amount',

        'payment_method',
        'payment_status',

        'transaction_id',

        'razorpay_order_id',
        'razorpay_payment_id',
        'razorpay_signature',

        'status',
        'tracking_number',
        'courier_id'
    ];

    public function customer()
    {
        return $this->belongsTo(
            Customer::class
        );
    }

    public function address()
    {
        return $this->belongsTo(
            CustomerAddress::class,
            'address_id'
        );
    }

    public function items()
    {
        return $this->hasMany(
            OrderItem::class
        );
    }

    public function invoice()
    {
        return $this->hasOne(
            Invoice::class
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

    public function statusHistory()
    {
        return $this->hasMany(OrderStatusHistory::class)
            ->latest();
    }

    public function courier()
    {
        return $this->belongsTo(Courier::class);
    }

    public function returns()
    {
      return $this->hasMany(
            OrderReturn::class
        );
    }

}