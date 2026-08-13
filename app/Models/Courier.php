<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    protected $fillable = [
        'name',
        'website_url',
        'is_active',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}