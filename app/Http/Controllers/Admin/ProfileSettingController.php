<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ProfileSettingController extends Controller
{
    public function index()
    {
        return view('admin.profile-setting.index');
    }


    public function resetPassword(Request $request)
    {
        // Validate fields
        $request->validate([
            'password' => 'required|min:6|confirmed',
        ], [
            'password.confirmed' => 'Passwords do not match',
        ]);

        try {
            $admin = Auth::user(); // Logged in admin

            // Update password securely
            $admin->password = Hash::make($request->password);
            $admin->save();

            return redirect()->back()->with('success', 'Password updated successfully!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong, try again.');
        }
    }

}
