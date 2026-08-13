<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $fillable = [
        'customer_id',
        'session_id',
        'product_id',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeCurrent($query)
    {
        if (auth('customer')->check()) {
            return $query->where(
                'customer_id',
                auth('customer')->id()
            );
        }

        return $query->where(
            'session_id',
            session()->getId()
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public static function addProduct(Product $product)
    {
        return static::firstOrCreate([
            'customer_id' => auth('customer')->check()
                ? auth('customer')->id()
                : null,

            'session_id' => auth('customer')->check()
                ? null
                : session()->getId(),

            'product_id' => $product->id,
        ]);
    }

    public static function removeProduct(Product $product)
    {
        return static::current()
            ->where('product_id', $product->id)
            ->delete();
    }
}