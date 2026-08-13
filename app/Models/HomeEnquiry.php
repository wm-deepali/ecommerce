<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeEnquiry extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'message',
        'ip',
        'user_agent'
    ];
}