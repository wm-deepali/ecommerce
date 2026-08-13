<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuthLog extends Model
{
    protected $fillable = [
        'user_type',
        'email',
        'event',
        'status',
        'ip_address',
        'user_agent',
        'error_message',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];
}