<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockHistory extends Model
{
    protected $fillable = [
        'product_id',
        'stock_variant_id',
        'type',
        'quantity',
        'stock_before',
        'stock_after',
        'reason',
        'reference_type',
        'reference_id',
        'created_by',
        'note',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function reference()
    {
        return $this->morphTo();
    }

    // Point this at whichever model manages your admin/staff users
    // (e.g. App\Models\Admin if admins are a separate guard/table).
    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

    public function isCredit(): bool
    {
        return $this->type === 'credit';
    }

    public function isDebit(): bool
    {
        return $this->type === 'debit';
    }

    public function stockVariant()
    {
        return $this->belongsTo(ProductVariant::class, 'stock_variant_id');
    }

}