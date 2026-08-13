<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailLog extends Model
{
    protected $fillable = [
        'event_key',
        'to_email',
        'to_name',
        'subject',
        'status',
        'reference',
        'error_message',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];
}