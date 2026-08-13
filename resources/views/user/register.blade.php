@extends('layouts.app')
@section('content')

    <main class="aq-auth-page">
        <!-- Hero Section -->
        <section class="aq-catpage-hero">
            <div class="aq-hero-glow"></div>
            <div class="aq-floating-gift-box aq-floating-shape-1">
                <i class="fa-solid fa-user-plus"></i>
            </div>
            <div class="aq-catpage-hero-content">
                <h1 class="aq-catpage-title">Register with Us</h1>
                <div class="aq-catpage-breadcrumbs">
                    <span class="text-white opacity-75">SIGN UP</span>
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
                                            Register Now</h3>
                                        <p style="color: #555; font-size: 16px;">Welcome! Register to avail the best deals
                                            and unlock superior discounts!</p>
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
                                <h3 class="font-family-heading aq-auth-form-title">Create an Account</h3>
                                <p class="aq-auth-form-subtitle">Enter your details to get started</p>
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
                                <form id="aqRegisterForm" action="{{ route('user.register.store') }}" method="POST"
                                    class="aq-contact-page">
                                    @csrf

                                    <div class="row g-3 mb-4">
                                        <div class="col-md-6">
                                            <div class="position-relative">
                                                <i class="fa-regular fa-user position-absolute aq-contact-input-icon"></i>
                                                <input type="text" name="name" class="form-control aq-contact-input"
                                                    required minlength="2" maxlength="100" pattern="[A-Za-z\s]+"
                                                    placeholder="Full Name" />
                                            </div>
                                            @error('name')
                                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <div class="position-relative">
                                                <i
                                                    class="fa-regular fa-envelope position-absolute aq-contact-input-icon"></i>
                                                <input type="email" name="email" class="form-control aq-contact-input"
                                                    required maxlength="255" placeholder="Email Address" />
                                            </div>
                                            @error('email')
                                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <div class="position-relative">
                                                <i class="fa-solid fa-phone position-absolute aq-contact-input-icon"></i>
                                                <input type="tel" name="mobile" id="mobileInput" class="form-control aq-contact-input"
                                                    required maxlength="10" pattern="[6-9]{1}[0-9]{9}" placeholder="Mobile Number" />
                                            </div>
                                            @error('mobile')
                                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <div class="position-relative">
                                                <i
                                                    class="fa-solid fa-phone-volume position-absolute aq-contact-input-icon"></i>
                                              <input type="tel" name="alternate_mobile" id="alternateMobileInput"
    class="form-control aq-contact-input" maxlength="10"
    pattern="[6-9]{1}[0-9]{9}" placeholder="Alternate Number (Optional)" />
                                            </div>
                                            @error('alternate_mobile')
                                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <div class="position-relative">
                                                <i class="fa-solid fa-lock position-absolute aq-contact-input-icon"></i>
                                                <input type="password" name="password" id="passwordInput" class="form-control aq-contact-input"
                                                    required minlength="8" placeholder="Password (Min 8 Characters)"
                                                    style="padding-right: 40px;" />
                                                <i class="fa-regular fa-eye toggle-password-icon" data-target="passwordInput"
                                                   style="position:absolute; right:15px; top:50%; transform:translateY(-50%); cursor:pointer; color:#999;"></i>
                                            </div>
                                            @error('password')
                                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <div class="position-relative">
                                                <i class="fa-solid fa-lock position-absolute aq-contact-input-icon"></i>
                                                <input type="password" name="password_confirmation" id="confirmPasswordInput"
                                                    class="form-control aq-contact-input" required minlength="8"
                                                    placeholder="Confirm Password"
                                                    style="padding-right: 40px;" />
                                                <i class="fa-regular fa-eye toggle-password-icon" data-target="confirmPasswordInput"
                                                   style="position:absolute; right:15px; top:50%; transform:translateY(-50%); cursor:pointer; color:#999;"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label class="aq-custom-check">
                                            <input type="checkbox" id="registerTerms" required checked>
                                            <span class="checkmark"></span>
                                            I accept Oudhyana's <a href="term-condition.html">Privacy Policy</a> <span
                                                class="mx-1">&amp;</span> <a href="term-condition.html">T&Cs</a>.
                                        </label>
                                    </div>

                                    <button type="submit" class="aq-contact-btn-submit w-100 mb-4"
                                        style="background: var(--aq-color-maroon); color: #fff; padding: 15px; border-radius: 8px; border: none; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; transition: 0.3s; margin-top: 10px;">
                                        <span>Create Account</span>
                                        <i class="fa-solid fa-arrow-right ml-10"></i>
                                    </button>

                                    <!-- Divider -->
                                    <div class="d-flex align-items-center mb-4">
                                        <hr class="flex-grow-1 m-0" style="border-color: #ddd;">
                                        <span class="mx-3 text-muted"
                                            style="font-size: 13px; text-transform: uppercase; letter-spacing: 1px;">Or
                                            Register with</span>
                                        <hr class="flex-grow-1 m-0" style="border-color: #ddd;">
                                    </div>

                                    <!-- Google Auth Button -->
                                    <a href="{{ route('google.login') }}" type="button"
                                        class="w-100 d-flex justify-content-center align-items-center"
                                        style="background: #fff; color: #555; padding: 12px; border-radius: 8px; border: 1px solid #ddd; font-weight: 600; font-size: 15px; transition: 0.3s; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Google_%22G%22_logo.svg"
                                            alt="Google" style="width: 20px; margin-right: 10px;">
                                        Sign up with Google
                                    </a>
                                </form>

                                <!-- <div class="aq-auth-alt-link">
                                                        <a href="#"><i class="fa-solid fa-globe mr-5"></i> Click here for International
                                                            Users</a>
                                                    </div> -->
                                <div class="aq-auth-alt-link mt-15">
                                    Already have an account? <a href="{{ route('user.login') }}">Login here</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
    const mobileInput = document.getElementById('mobileInput');
    const altInput = document.getElementById('alternateMobileInput');
    const altError = document.getElementById('alternateMobileError');

    function checkSameNumber() {
        if (altInput.value.trim() !== '' && altInput.value.trim() === mobileInput.value.trim()) {
            altError.classList.remove('d-none');
            altInput.classList.add('is-invalid');
            return false;
        } else {
            altError.classList.add('d-none');
            altInput.classList.remove('is-invalid');
            return true;
        }
    }

    mobileInput.addEventListener('input', checkSameNumber);
    altInput.addEventListener('input', checkSameNumber);

    document.getElementById('aqRegisterForm').addEventListener('submit', function (e) {
        if (!checkSameNumber()) {
            e.preventDefault();
            altInput.focus();
        }
    });
});

        
        document.querySelectorAll('.toggle-password-icon').forEach(function (icon) {
            icon.addEventListener('click', function () {
                const targetInput = document.getElementById(icon.getAttribute('data-target'));
                if (targetInput.type === 'password') {
                    targetInput.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    targetInput.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });
    </script>
    
    {{-- Pixel/GA tracking — this form is a plain POST redirect (not AJAX), so
         the controller flashes fire_signup_event / fire_login_event to the
         session. Covers the email/password signup above AND a Google OAuth
         signup/login that happens to redirect back through this page (e.g.
         intended URL was the register page). --}}
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

@endsection