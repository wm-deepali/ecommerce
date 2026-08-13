<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class StockSetting extends Model
{
    protected $fillable = [
        'critical_threshold',
        'low_stock_threshold',
        'watch_list_threshold',
        'notify_email',
        'notify_dashboard',
        'auto_disable_out_of_stock',
    ];

    protected $casts = [
        'notify_email' => 'boolean',
        'notify_dashboard' => 'boolean',
        'auto_disable_out_of_stock' => 'boolean',
    ];

    /**
     * This table only ever holds one row. current() fetches it — creating it
     * with defaults the first time it's needed — and caches it so every
     * stock check doesn't hit the database.
     */
    public static function current(): self
    {
        return Cache::rememberForever('stock_settings', function () {
            return static::query()->firstOrCreate([], [
                'critical_threshold' => 0,
                'low_stock_threshold' => 20,
                'watch_list_threshold' => 30,
                'notify_email' => true,
                'notify_dashboard' => true,
                'auto_disable_out_of_stock' => true,
            ]);
        });
    }

    public static function forget(): void
    {
        Cache::forget('stock_settings');
    }

    protected static function booted(): void
    {
        static::saved(fn () => static::forget());
    }
}