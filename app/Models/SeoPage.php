<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoPage extends Model
{
    protected $fillable = [
        'page_key',
        'page_name',
        'slug',
        'meta_title',
        'meta_description',
        'scripts',
    ];
}
