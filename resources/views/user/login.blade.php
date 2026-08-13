@extends('layouts.app')
@section('content')

    <main class="aq-auth-page">
        <!-- Hero Section -->
        <section class="aq-catpage-hero">
            <div class="aq-hero-glow"></div>
            <div class="aq-floating-gift-box aq-floating-shape-1">
                <i class="fa-solid fa-lock"></i>
            </div>
            <div class="aq-catpage-hero-content">
                <h1 class="aq-catpage-title">Welcome Back</h1>
                <div class="aq-catpage-breadcrumbs">
                    <span class="text-white opacity-75">LOGIN</span>
                </div>
            </div>
        </section>

        <!-- Auth Section -->
        <section class="aq-auth-section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-10 col-lg-12">
                        <div class="aq-auth-container">

                            <!-- Left: Benefits / Info -->
                            <div class="col-lg-5 aq-auth-left">
                                <div class="aq-auth-left-bg"></div>
                                <div class="aq-auth-left-content">
                                    <div class="mb-40">
                                        <h3 class="font-family-heading"
                                            style="color: var(--aq-color-maroon); font-size: 28px; font-weight: 700; margin-bottom: 10px;">
                                            Login</h3>
                                        <p style="color: #555; font-size: 16px;">Sign in to avail the best deals and unlock
                                            superior discounts!</p>
                                    </div>

                                    <div class="aq-auth-benefits-list mt-40">
                                        <div class="aq-auth-benefit-item">
                                            <div class="aq-auth-benefit-icon">
                                                <i class="fa-solid fa-crown"></i>
                                            </div>
                                            <div class="aq-auth-benefit-text">
                                                <h5>Zero Membership Fees</h5>
                                                <p>Access Oudhyana VIP without any subscription charges.</p>
                                            </div>
                                        </div>

                                        <div class="aq-auth-benefit-item">
                                            <div class="aq-auth-benefit-icon">
                                                <i class="fa-solid fa-tags"></i>
                                            </div>
                                            <div class="aq-auth-benefit-text">
                                                <h5>Lowest Price Guaranteed</h5>
                                                <p>Explore unbeatable prices and unmatchable value on premium Chikankari.
                                                </p>
                                            </div>
                                        </div>

                                        <div class="aq-auth-benefit-item">
                                            <div class="aq-auth-benefit-icon">
                                                <i class="fa-solid fa-shield"></i>
                                            </div>
                                            <div class="aq-auth-benefit-text">
                                                <h5>100% Secure & Spam Free</h5>
                                                <p>Guaranteed data protection & spam-free inbox.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right: Form -->
                            <div class="col-lg-7 aq-auth-right">
                                <h3 class="font-family-heading aq-auth-form-title">Login to Your Account</h3>
                                <p class="aq-auth-form-subtitle">Enter your details to unlock superior discounts</p>

                                @if(session('success'))
                                    <div class="alert alert-success mb-3">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                @if ($errors->any())
                                    <div class="alert alert-danger mb-3">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <form id="aqLoginForm" action="{{ route('user.login.store') }}" method="POST"
                                    class="aq-contact-page">
                                    @csrf

                                    <!-- Email / Username -->
                                    <div class="mb-4 position-relative">
                                        <i class="fa-regular fa-envelope position-absolute aq-contact-input-icon"></i>
                                        <input type="email" name="email" value="{{ old('email') }}"
                                            class="form-control aq-contact-input" required placeholder="Email Address" />

                                        @error('email')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- Password -->
                                    <div class="mb-4 position-relative">
                                        <i class="fa-solid fa-lock position-absolute aq-contact-input-icon"></i>
                                        <input type="password" name="password" class="form-control aq-contact-input"
                                            required placeholder="Password" />

                                        @error('password')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <label class="aq-custom-check">
                                            <input type="checkbox" id="loginRemember" name="remember">
                                            <span class="checkmark"></span>
                                            Remember me
                                        </label>
                                        <a href="#"
                                            style="font-size: 13px; color: var(--aq-color-maroon); font-weight: 600; text-decoration: underline; white-space: nowrap; margin-left: 10px;">Forgot
                                            Password?</a>
                                    </div>

                                    <button type="submit" class="aq-contact-btn-submit w-100 mb-4"
                                        style="background: var(--aq-color-maroon); color: #fff; padding: 15px; border-radius: 8px; border: none; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; transition: 0.3s; margin-top: 5px;">
                                        <span>Login to Account</span>
                                        <i class="fa-solid fa-arrow-right ml-10"></i>
                                    </button>

                                    <!-- Divider -->
                                    <div class="d-flex align-items-center mb-4">
                                        <hr class="flex-grow-1 m-0" style="border-color: #ddd;">
                                        <span class="mx-3 text-muted"
                                            style="font-size: 13px; text-transform: uppercase; letter-spacing: 1px;">Or
                                            Login with</span>
                                        <hr class="flex-grow-1 m-0" style="border-color: #ddd;">
                                    </div>

                                    <!-- Google Auth Button -->
                                    <a href="{{ route('google.login') }}"
                                        class="w-100 d-flex justify-content-center align-items-center"
                                        style="background: #fff; color: #555; padding: 12px; border-radius: 8px; border: 1px solid #ddd; font-weight: 600; font-size: 15px; transition: 0.3s; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Google_%22G%22_logo.svg"
                                            alt="Google" style="width: 20px; margin-right: 10px;">
                                        Sign in with Google
                                    </a>
                                </form>

                                <!-- <div class="aq-auth-alt-link">
                                                    <a href="#"><i class="fa-solid fa-globe mr-5"></i> Click here for International Users</a>
                                                </div> -->
                               <div class="aq-auth-alt-link mt-15">
    Don't have an account?
    <a href="{{ route('user.register', request('redirect') ? ['redirect' => request('redirect')] : []) }}">
        Sign Up here
    </a>
</div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>


 {{-- Pixel/GA tracking — this form is a plain POST redirect (not AJAX), so
         the controller flashes fire_login_event / fire_signup_event to the
         session and we fire the corresponding event here once the page
         reloads on success. Covers both the email/password form above and
         the Google OAuth redirect (both land back on a page carrying this
         flash via CustomerAuthController). --}}
    @if(session('fire_login_event'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                if (typeof fireTrackingEvents === 'function') {
                    try {
                        fireTrackingEvents([{ type: 'gtag', name: 'login', params: {} }]);
                    } catch (err) {
                        console.error('Tracking event failed (ignored):', err);
                    }
                }
            });
        </script>
    @endif

    @if(session('fire_signup_event'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                if (typeof fireTrackingEvents === 'function') {
                    try {
                        fireTrackingEvents([{
                            type: 'gtag',
                            name: 'sign_up',
                            params: { method: @json(session('fire_signup_event')) }
                        }]);
                    } catch (err) {
                        console.error('Tracking event failed (ignored):', err);
                    }
                }
            });
        </script>
    @endif

@endsection