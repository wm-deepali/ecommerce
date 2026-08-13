<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderReturn extends Model
{
    protected $fillable = [
        'order_id',
        'order_item_id',
        'customer_id',
        'return_reason_id',
        'details',
        'type',
        'status',
        'admin_note',
        // Refund info
        'refund_method',
        'upi_id',
        'qr_image',
        'bank_name',
        'account_name',
        'account_number',
        'ifsc_code',
        'bank_branch',
        'account_type',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function returnReason()
    {
        return $this->belongsTo(ReturnReason::class);
    }

    /**
     * Human-readable refund method label.
     */
    public function getRefundMethodLabelAttribute(): string
    {
        return match ($this->refund_method) {
            'upi' => 'UPI ID',
            'qr' => 'QR Code',
            'bank' => 'Bank Transfer',
            default => '—',
        };
    }

    public function refundTransaction()
    {
        return $this->hasOne(RefundTransaction::class);
    }

}