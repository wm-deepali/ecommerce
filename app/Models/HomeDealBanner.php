<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeDealBanner extends Model
{
    protected $fillable = [
        'image',
        'title',
        'highlight_text',
        'offer_text',
        'button_text',
        'button_link',
        'sort_order',
        'status',
    ];
}