<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'name',
        'sub_title',
        'cost',
        'duration',
        'button_text',
        'is_popular'
    ];

    public function features()
    {
        return $this->hasMany(PackageFeature::class);
    }
}
