<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
    protected $fillable = [
        'title',
        'image',
        'column_no',
        'height_class',
        'sort_order',
        'status',
    ];
}