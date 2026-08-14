<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ndr extends Model
{
    protected $fillable = [
        'order_id',
        'reason',
        'remarks',
        'status',
        'attempt_count',
        'next_attempt_date',
        'marked_by',
        'resolved_at',
    ];

    protected $casts = [
        'next_attempt_date' => 'date',
        'resolved_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function refundTransaction()
    {
        return $this->hasOne(RefundTransaction::class);
    }

    public function getReasonLabelAttribute(): string
    {
        return match ($this->reason) {
            'customer_unavailable' => 'Customer Unavailable',
            'wrong_address' => 'Wrong / Incomplete Address',
            'refused_cod' => 'Refused COD Payment',
            'address_unserviceable' => 'Area Not Serviceable',
            'requested_reschedule' => 'Customer Requested Reschedule',
            'other' => 'Other',
            default => ucfirst($this->reason),
        };
    }
}