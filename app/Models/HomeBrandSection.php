<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeBrandSection extends Model
{
    protected $fillable = [
        'subtitle',
        'title',
        'description',
        'button_text',
        'button_link',
        'main_image',
        'status'
    ];

    public function images()
    {
        return $this->hasMany(
            HomeBrandSectionImage::class
        )->orderBy('sort_order');
    }
}