<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItemAddon extends Model
{
    protected $fillable = [
        'cart_item_id',
        'addon_id',
        'detail',
        'price',
    ];

    public function cartItem()
    {
        return $this->belongsTo(CartItem::class);
    }

    public function addon()
    {
        return $this->belongsTo(ProductAddon::class, 'addon_id');
    }
}