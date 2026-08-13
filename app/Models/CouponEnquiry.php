<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CouponEnquiry extends Model
{
    protected $fillable = ['email', 'country_code', 'phone', 'whatsapp_optin', 'status'];
}