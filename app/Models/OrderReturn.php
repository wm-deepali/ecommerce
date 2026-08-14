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

    public function refundTransaction()
    {
        return $this->hasOne(RefundTransaction::class);
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

    /**
     * Total amount that should be refunded for this return:
     * item line total (price × qty) + any addons on that item + a
     * proportional share of the order's tax.
     *
     * Tax is stored only at order level (orders.tax_amount), not per item,
     * so it is prorated based on this item's share of order.subtotal.
     * order.subtotal and order_items.total both exclude addons (per
     * Cart::recalculateTotals()), so the proportion lines up correctly.
     * Addons themselves are untaxed in this system and are added as-is.
     */
    public function getRefundableAmountAttribute(): float
    {
        $item = $this->orderItem;
        $order = $this->order;

        if (!$item || !$order) {
            return 0;
        }

        $addonsTotal = $item->addons->sum('price');
        $itemCostWithAddons = $item->total + $addonsTotal;

        if ((float) $order->subtotal <= 0) {
            return round($itemCostWithAddons, 2);
        }

        $itemShare = $item->total / $order->subtotal;
        $proratedTax = $itemShare * $order->tax_amount;

        return round($itemCostWithAddons + $proratedTax, 2);
    }
}