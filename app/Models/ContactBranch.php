<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactBranch extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'address',
        'phone',
        'email',
        'working_hours',
        'icon',
        'status'
    ];
}