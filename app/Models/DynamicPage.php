<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DynamicPage extends Model
{
    protected $fillable = [
        'page_name',
        'heading',
        'content',
        'meta_title',
        'meta_description',
        'status'
    ];
}