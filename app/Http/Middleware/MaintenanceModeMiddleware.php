<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Setting;

class MaintenanceModeMiddleware
{
    public function handle($request, Closure $next)
    {
        $setting = Setting::first();

        if (
            $setting?->maintenance_mode && !$request->is('admin/*')
        ) {
            return response()->view(
                'maintenance',
                [],
                503
            );
        }

        return $next($request);
    }
}