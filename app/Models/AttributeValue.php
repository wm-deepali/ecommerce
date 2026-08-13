<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AttributeValue extends Model
{
    protected $fillable = [
        'attribute_id',
        'value',
        'image',
        'hex_code',
        'slug',
        'meta_title',
        'meta_description',
        'sort_order',
        'status'
    ];

    protected static function booted()
    {
        static::saving(function ($attributeValue) {
            if (empty($attributeValue->slug)) {
                $attributeValue->slug = Str::slug($attributeValue->value);
            }
        });
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
}