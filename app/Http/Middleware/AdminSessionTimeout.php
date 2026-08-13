<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AdminSessionTimeout
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {

            $setting = Setting::first();

            $timeout = $setting?->admin_session_timeout ?? 60;

            $lastActivity = session('admin_last_activity');

            if (
                $lastActivity &&
                now()->diffInMinutes(
                    Carbon::parse($lastActivity)
                ) > $timeout
            ) {
                Auth::logout();

                session()->invalidate();
                session()->regenerateToken();

                return redirect()
                    ->route('login') // change if your admin login route differs
                    ->with(
                        'error',
                        'Session expired due to inactivity.'
                    );
            }

            session([
                'admin_last_activity' => now()
            ]);
        }

        return $next($request);
    }
}