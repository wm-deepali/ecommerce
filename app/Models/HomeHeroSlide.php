<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeHeroSlide extends Model
{
    protected $fillable = [
        'subtitle',
        'title',
        'description',
        'button_text',
        'button_link',
        'image',
        'sort_order',
        'status'
    ];
}