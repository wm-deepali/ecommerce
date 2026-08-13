<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RefundTransaction extends Model
{
    protected $fillable = [
        'order_return_id',
        'order_id',
        'customer_id',
        'refund_method',
        'upi_id',
        'bank_name',
        'account_name',
        'account_number',
        'ifsc_code',
        'bank_branch',
        'account_type',
        'utr_id',
        'amount',
        'remarks',
        'payment_proof',
    ];

    public function orderReturn()
    {
        return $this->belongsTo(OrderReturn::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function getPaymentProofUrlAttribute(): ?string
    {
        return $this->payment_proof
            ? asset('storage/' . $this->payment_proof)
            : null;
    }
}
