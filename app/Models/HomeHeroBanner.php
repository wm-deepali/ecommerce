<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeHeroBanner extends Model
{
    protected $fillable = [
        'image',
        'small_text',
        'title',
        'button_text',
        'button_link',
        'sort_order',
        'status'
    ];
}