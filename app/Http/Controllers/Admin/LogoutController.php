<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AuthLog;
use Auth;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        $admin = Auth::user();

        Auth::logout();

        if ($admin) {
            AuthLog::create([
                'user_type'  => 'admin',
                'email'      => $admin->email,
                'event'      => 'logout',
                'status'     => 'success',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        }

        return redirect()->route('login')
                ->with('success','Logout successfully.');
    }
}