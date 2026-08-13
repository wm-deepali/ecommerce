<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmtpSetting extends Model
{
    protected $fillable = [
        'smtp_host',
        'smtp_port',
        'smtp_username',
        'smtp_password',
        'smtp_encryption',
        'from_name',
        'from_email',
        'reply_to_name',
        'reply_to_email',
        'order_confirmation',
        'order_shipped',
        'order_delivered',
        'order_cancelled',      // add
        'payment_received',     // add
        'coupon',               // add
        'welcome',              // add
        'password_reset',
        'new_order_alert',
        'low_stock_alert',
    ];

    protected $casts = [
        'order_confirmation' => 'boolean',
        'order_shipped' => 'boolean',
        'order_delivered' => 'boolean',
        'order_cancelled' => 'boolean',  // add
        'payment_received' => 'boolean',  // add
        'coupon' => 'boolean',  // add
        'welcome' => 'boolean',  // add
        'password_reset' => 'boolean',
        'new_order_alert' => 'boolean',
        'low_stock_alert' => 'boolean',
    ];

    /**
     * Always return a singleton row (id = 1).
     */
    public static function getInstance(): self
    {
        return static::firstOrCreate(['id' => 1]);
    }
}