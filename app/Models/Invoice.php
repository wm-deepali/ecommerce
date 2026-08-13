<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [

        'order_id',

        'invoice_number',
        'invoice_date',

        'customer_name',
        'customer_email',
        'customer_phone',

        'billing_address',

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

        'status',
    ];

    protected $casts = [

        'invoice_date' => 'date',

        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'grand_total' => 'decimal:2',

        'cgst_rate' => 'decimal:2',
        'sgst_rate' => 'decimal:2',
        'igst_rate' => 'decimal:2',

        'cgst_amount' => 'decimal:2',
        'sgst_amount' => 'decimal:2',
        'igst_amount' => 'decimal:2',
    ];

    public function order()
    {
        return $this->belongsTo(
            Order::class
        );
    }
}