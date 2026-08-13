<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'site_name',
        'tagline',
        'header_logo',
        'footer_logo',
        'favicon',
        'admin_login_logo',
        'admin_dashboard_logo',
        'admin_email',
        'support_email',
        'phone',
        'whatsapp',
        'business_address',
        'footer_description',
        'footer_copyright',
        'google_map_url',
        'facebook',
        'instagram',
        'twitter',
        'linkedin',
        'youtube',
        'pinterest',
        'currency',
        'currency_symbol',
        'timezone',
        'maintenance_mode',
        'admin_session_timeout',
        'product_reviews',
        'wishlist',
        'stock_alerts',
        'cod_enabled'
    ];

    protected $casts = [
        'maintenance_mode' => 'boolean',
        'product_reviews' => 'boolean',
        'wishlist' => 'boolean',
        'stock_alerts' => 'boolean',
        'cod_enabled' => 'boolean',
    ];
}