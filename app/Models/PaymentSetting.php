<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentSetting extends Model
{
    protected $fillable = [

        'live_mode',

        'test_key_id',
        'test_key_secret',

        'live_key_id',
        'live_key_secret',
    ];

    protected $casts = [
        'live_mode' => 'boolean',
    ];
}