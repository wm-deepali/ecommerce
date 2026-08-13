<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AccountController extends Controller
{
    public function index()
    {
        return view('user.account-details');
    }

    public function updateProfile(Request $request)
    {
        $customer = auth('customer')->user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'unique:customers,email,' . $customer->id],
            'mobile' => ['required', 'string', 'max:15'],
            'dob' => ['nullable', 'date', 'before:today'],
            'gender' => ['nullable', 'in:male,female,other,prefer_not'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,svg', 'max:2048'],
        ]);

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')
                ->store('customers/avatars', 'public');
        }

        $customer->update($data);

        \App\Models\Notification::create([
            'customer_id' => $customer->id,
            'title' => 'Profile Updated',
            'message' => 'Your account profile has been updated successfully.',
            'icon' => 'fa-user',
            'color' => 'system-icon',
        ]);

        return back()->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $customer = auth('customer')->user();
        $hasPassword = (bool) $customer->password;

        $rules = [
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
        ];

        if ($hasPassword) {
            $rules['current_password'] = ['required', 'string'];
        }

        $request->validate($rules);

        if ($hasPassword && !Hash::check($request->current_password, $customer->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $customer->update(['password' => $request->password]);

        \App\Models\Notification::create([
            'customer_id' => $customer->id,
            'title' => 'Password Changed',
            'message' => 'Your account password was changed successfully.',
            'icon' => 'fa-key',
            'color' => 'security-icon',
        ]);

        return back()->with('success', 'Password updated successfully.');
    }

    public function deleteAccount(Request $request)
    {
        $customer = auth('customer')->user();

        Auth::guard('customer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $customer->delete(); // SoftDeletes — data is retained

        \App\Models\Notification::create([
            'customer_id' => $customer->id,
            'title' => 'Account Deleted',
            'message' => 'Your account deletion request has been processed.',
            'icon' => 'fa-user-xmark',
            'color' => 'security-icon',
        ]);

        return redirect('/')->with('success', 'Your account has been deleted.');
    }
}