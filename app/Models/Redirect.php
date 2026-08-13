<?php
// app/Models/Redirect.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Redirect extends Model
{
    protected $fillable = [
        'from_url', 'to_url', 'type', 'is_active', 'hits', 'note',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'hits'      => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}