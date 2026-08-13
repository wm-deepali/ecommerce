<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeTextSlider extends Model
{
    protected $fillable = [
        'title',
        'sort_order',
        'status'
    ];
}