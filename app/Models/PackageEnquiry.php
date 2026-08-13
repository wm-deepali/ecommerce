<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageEnquiry extends Model
{
    protected $fillable = [
        'package_id',
        'name',
        'company',
        'email',
        'phone',
        'message'
    ];
}
