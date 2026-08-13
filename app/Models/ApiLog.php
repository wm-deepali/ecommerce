<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiLog extends Model
{
    protected $fillable = [
        'method',
        'endpoint',
        'service',
        'status_code',
        'response_time_ms',
        'request_payload',
        'response_payload',
        'error_message',
        'ip_address',
    ];

    protected $casts = [
        'request_payload' => 'array',
        'response_payload' => 'array',
        'status_code' => 'integer',
        'response_time_ms' => 'integer',
    ];
}