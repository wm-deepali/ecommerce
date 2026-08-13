<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralEnquiry extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'message',
        'source',
        'status',
    ];
}