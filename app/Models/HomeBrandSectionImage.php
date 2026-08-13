<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeBrandSectionImage extends Model
{
    protected $fillable = [
        'home_brand_section_id',
        'image',
        'sort_order',
        'status'
    ];

    public function section()
    {
        return $this->belongsTo(
            HomeBrandSection::class,
            'home_brand_section_id'
        );
    }
}