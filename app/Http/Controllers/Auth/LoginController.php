<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AuthLog;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();

            if (auth()->user()) {

                AuthLog::create([
                    'user_type'  => 'admin',
                    'email'      => $request->email,
                    'event'      => 'login',
                    'status'     => 'success',
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ]);

                return redirect()->to('admin/dashboard');
            }

            return redirect()->to('/login');
        }

        AuthLog::create([
            'user_type'     => 'admin',
            'email'         => $request->email,
            'event'         => 'login_failed',
            'status'        => 'failed',
            'ip_address'    => $request->ip(),
            'user_agent'    => $request->userAgent(),
            'error_message' => 'Invalid email or password',
        ]);

        return back()->with('error', 'Email-Address And Password Are Wrong.');
    }
}