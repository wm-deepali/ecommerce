<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Wishlist;
use App\Models\AuthLog;

class CustomerAuthController extends Controller
{
    public function registerForm(Request $request)
    {
        if (Auth::guard('customer')->check()) {
            return redirect()->route('user.dashboard.index');
        }

        if ($request->filled('redirect')) {
            session(['url.intended' => $request->redirect]);
        }

        return view('user.register');
    }

    public function loginForm(Request $request)
    {
        if (Auth::guard('customer')->check()) {
            return redirect()->route('user.dashboard.index');
        }

        if ($request->filled('redirect')) {
            session(['url.intended' => $request->redirect]);
        }

        return view('user.login');
    }

    public function register(Request $request)
    {
        // alternate_mobile is optional, but if filled must still be a valid format
        $validated = $request->validate(
            [
                'name' => ['required', 'max:100', 'regex:/^[A-Za-z\s]+$/'],
                'email' => ['required', 'email', 'unique:customers,email'],
                'mobile' => ['required', 'regex:/^[6-9]\d{9}$/', 'unique:customers,mobile'],
                'alternate_mobile' => ['nullable', 'regex:/^[6-9]\d{9}$/'],
                'password' => ['required', 'min:8', 'confirmed'],
            ],
            [
                'name.regex' => 'Name should contain only letters.',
                'mobile.regex' => 'Enter a valid Indian mobile number.',
                'alternate_mobile.regex' => 'Enter a valid alternate mobile number.',
                'password.confirmed' => 'Password and confirm password do not match.',
            ]
        );

        $customer = Customer::create($validated);

// ADD THIS — admin notification
\App\Models\AdminNotification::notify([
    'type'      => 'customer',
    'title'     => 'New customer registered',
    'message'   => "{$customer->name} ({$customer->email}) created a new account.",
    'icon'      => 'fa-user-plus',
    'url'       => route('admin.customers.show', $customer->id),
    'link_text' => 'View Customer',
]);

        \App\Services\Email\EmailDispatcher::send(
            'welcome',
            $customer->email,
            [
                '{customer_name}' => $customer->name,
            ]
        );

        // Capture the guest session id BEFORE regenerating it, so the guest
        // cart/wishlist tied to this session can still be found and merged.
        $guestSessionId = session()->getId();

        Auth::guard('customer')->login($customer);

        $this->mergeGuestCart($customer, $guestSessionId);
        $this->mergeGuestWishlist($customer, $guestSessionId);

        $request->session()->regenerate();

        // Sends the customer back to wherever they came from (e.g. the cart
        // page) instead of always landing on the dashboard after signup.
       return redirect()
            ->intended(route('user.dashboard.index'))
            ->with('success', 'Registration completed successfully.')
            ->with('fire_signup_event', 'email_password');
    }


    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->boolean('remember');

       if (Auth::guard('customer')->attempt($credentials, $remember)) {

    $customer = Auth::guard('customer')->user();

    $guestSessionId = session()->getId();

    $this->mergeGuestCart($customer, $guestSessionId);
    $this->mergeGuestWishlist($customer, $guestSessionId);

    $request->session()->regenerate();

    AuthLog::create([
        'user_type'  => 'customer',
        'email'      => $customer->email,
        'event'      => 'login',
        'status'     => 'success',
        'ip_address' => $request->ip(),
        'user_agent' => $request->userAgent(),
    ]);

  return redirect()
                ->intended(route('user.dashboard.index'))
                ->with('success', 'Login successful.')
                ->with('fire_login_event', true);
}

AuthLog::create([
    'user_type'     => 'customer',
    'email'         => $credentials['email'],
    'event'         => 'login_failed',
    'status'        => 'failed',
    'ip_address'    => $request->ip(),
    'user_agent'    => $request->userAgent(),
    'error_message' => 'Invalid email or password',
]);

return back()
    ->withInput()
    ->withErrors([
        'email' => 'Invalid email or password.',
    ]);

        return back()
            ->withInput()
            ->withErrors([
                'email' => 'Invalid email or password.',
            ]);
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }


    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();

        $customer = Customer::firstOrCreate(
            [
                'email' => $googleUser->email,
            ],
            [
                'name' => $googleUser->name,
                'google_id' => $googleUser->id,
                'avatar' => $googleUser->avatar,
                'password' => bcrypt(str()->random(20)),
                'mobile' => time(),
                'alternate_mobile' => time() + 1,
            ]
        );


// ADD THIS — only fires for a genuinely new signup, not existing Google login
if ($customer->wasRecentlyCreated) {
    \App\Models\AdminNotification::notify([
        'type'      => 'customer',
        'title'     => 'New customer registered',
        'message'   => "{$customer->name} ({$customer->email}) signed up via Google.",
        'icon'      => 'fa-user-plus',
        'url'       => route('admin.customers.show', $customer->id),
        'link_text' => 'View Customer',
    ]);
}
        $isNewCustomer = $customer->wasRecentlyCreated; // 👈 new
       Auth::guard('customer')->login($customer);
       

AuthLog::create([
    'user_type'  => 'customer',
    'email'      => $customer->email,
    'event'      => 'login',
    'status'     => 'success',
    'ip_address' => request()->ip(),
    'user_agent' => request()->userAgent(),
    'meta'       => ['provider' => 'google'],
]);

$guestSessionId = session()->getId();

        $this->mergeGuestCart($customer, $guestSessionId);
        $this->mergeGuestWishlist($customer, $guestSessionId);

 // 👇 new — flash for session-based tracking, same as email/password paths above
        if ($isNewCustomer) {
            session()->flash('fire_signup_event', 'google_oauth');
        } else {
            session()->flash('fire_login_event', true);
        }
        
        return redirect()->intended(route('home'));
    }

  public function logout(Request $request)
{
    $customer = Auth::guard('customer')->user();

    Auth::guard('customer')->logout();

    if ($customer) {
        AuthLog::create([
            'user_type'  => 'customer',
            'email'      => $customer->email,
            'event'      => 'logout',
            'status'     => 'success',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
    }

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('user.login');
}

    private function mergeGuestCart(Customer $customer, $guestSessionId)
    {
        $guestCart = Cart::with('items.addons')
            ->where('session_id', $guestSessionId)
            ->first();

        if (!$guestCart) {
            return;
        }

        $userCart = Cart::firstOrCreate(
            [
                'user_id' => $customer->id
            ],
            [
                'session_id' => $guestSessionId,
                'total_amount' => 0
            ]
        );

        if ($guestCart->id == $userCart->id) {

            $userCart->update([
                'user_id' => $customer->id
            ]);

            return;
        }

        foreach ($guestCart->items as $item) {

            // Two line items only count as "the same" if product + every
            // variant reference + the selected attribute snapshot all match.
            // Otherwise different size/color combos would collapse into one row.
            $existingItem = CartItem::where('cart_id', $userCart->id)
                ->where('product_id', $item->product_id)
                ->where('price_variant_id', $item->price_variant_id)
                ->where('image_variant_id', $item->image_variant_id)
                ->where('stock_variant_id', $item->stock_variant_id)
                ->where('sku_variant_id', $item->sku_variant_id)
                ->get()
                ->first(function ($candidate) use ($item) {
                    return $candidate->selected_attributes === $item->selected_attributes;
                });

            if ($existingItem) {

                $existingItem->quantity += $item->quantity;
                $existingItem->total =
                    $existingItem->quantity * $existingItem->price;

                $existingItem->save();

            } else {

                $newItem = CartItem::create([
                    'cart_id' => $userCart->id,
                    'product_id' => $item->product_id,
                    'price_variant_id' => $item->price_variant_id,
                    'image_variant_id' => $item->image_variant_id,
                    'stock_variant_id' => $item->stock_variant_id,
                    'sku_variant_id' => $item->sku_variant_id,
                    'selected_attributes' => $item->selected_attributes,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'total' => $item->total,
                ]);

                // Carry over addons attached to the guest's line item
                foreach ($item->addons as $addon) {
                    $newItem->addons()->create([
                        'addon_id' => $addon->addon_id,
                        'detail' => $addon->detail,
                        'price' => $addon->price,
                    ]);
                }
            }
        }

        $userCart->update([
            'total_amount' => $userCart->items()->sum('total')
        ]);

        $guestCart->items()->each(function ($item) {
            $item->addons()->delete();
        });
        $guestCart->items()->delete();
        $guestCart->delete();
    }

    private function mergeGuestWishlist(Customer $customer, $guestSessionId)
    {
        $guestWishlistItems = Wishlist::where(
            'session_id',
            $guestSessionId
        )->get();

        if ($guestWishlistItems->isEmpty()) {
            return;
        }

        foreach ($guestWishlistItems as $item) {

            $exists = Wishlist::where(
                'customer_id',
                $customer->id
            )
                ->where(
                    'product_id',
                    $item->product_id
                )
                ->exists();

            if (!$exists) {

                Wishlist::create([
                    'customer_id' => $customer->id,
                    'session_id' => null,
                    'product_id' => $item->product_id,
                    'expires_at' => $item->expires_at,
                ]);
            }
        }

        Wishlist::where(
            'session_id',
            session()->getId()
        )->delete();
    }

}