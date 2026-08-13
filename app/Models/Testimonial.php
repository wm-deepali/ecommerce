<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'type',
        'name',
        'feedback',
        'rating',
        'photo',
        'reel_file',
        'reel_url',
        'status'
    ];
}
