<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeFeatureCard extends Model
{
    protected $fillable = [
        'icon',
        'title',
        'content',
        'card_class',
        'sort_order',
        'status'
    ];
}