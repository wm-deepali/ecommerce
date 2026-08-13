@extends('layouts.admin-app')

@section('content')

<style>
    body {
        background: #f3f4f6;
    }

    .login-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .login-card {
        width: 100%;
        max-width: 950px;
        display: flex;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        background: #fff;
    }

.logo-box {
    background: #fff;
    padding: 15px;
    border-radius: 15px;
    display: inline-block;
    margin-bottom: 20px;
}

.logo-box img {
    width: 140px;
    height: auto;
    max-height: 90px;
    object-fit: contain;
}
    .login-left {
        width: 45%;
        background: linear-gradient(135deg, #c98fbb, #c98fbb);
        color: #fff;
        text-align: center;
        padding: 40px 20px;
    }

    .login-left img {
        width: 120px;
        margin-bottom: 20px;
    }

    .login-left h2 {
        font-weight: 600;
        margin-bottom: 10px;
    }

    .login-left p {
        font-size: 14px;
        opacity: 0.9;
    }

    .login-right {
        width: 55%;
        padding: 40px;
    }

    .login-title {
        font-weight: 600;
        margin-bottom: 25px;
        color: #333;
    }

    .form-control {
        border-radius: 10px;
        padding: 12px;
        background: #fcf4ef;
        border: none;
    }

    .form-control:focus {
        box-shadow: none;
        border: 1px solid #00310814;
        background: #00310814;
    }

    .btn-login {
        width: 100%;
        padding: 12px;
        border-radius: 12px;
        border: none;
        background: linear-gradient(90deg, #c98fbb, #c98fbb);
        color: #fff;
        font-weight: 500;
    }

    .btn-login:hover {
        opacity: 0.9;
    }

    .form-check-label {
        font-size: 14px;
    }

    .forgot-link {
        font-size: 14px;
        text-decoration: none;
        color: #f97316;
    }

    .forgot-link:hover {
        text-decoration: underline;
    }

    @media (max-width: 768px) {
        .login-card {
            flex-direction: column;
        }
        .login-left, .login-right {
            width: 100%;
        }
        .login-left {
    background: linear-gradient(135deg, #f97316, #fbbf24);
}
    }
</style>

@php
    $loginLogo = $general?->admin_login_logo;
    $siteName = $general?->site_name ?? 'Web Mingo E-Commerce';
    $tagline = $general?->tagline ?? 'By Web Mingo';
@endphp

<div class="login-wrapper">
    <div class="login-card">

        <!-- LEFT SIDE -->
        <div class="login-left">

    <div class="logo-box">
        @if($loginLogo)
            <img src="{{ asset('storage/' . $loginLogo) }}" alt="{{ $siteName }}">
        @else
            <img src="{{ asset('assets/img/corporate/Oudhyana_img/logo.png') }}" alt="{{ $siteName }}">
        @endif
    </div>

    <h2>{{ $siteName }}</h2>
    <p>{{ $tagline }}</p>
</div>

        <!-- RIGHT SIDE -->
        <div class="login-right">
            <h4 class="login-title">Admin Login</h4>

            <form method="POST" action="{{ route('login.post') }}">
                @csrf

                <!-- EMAIL -->
                <div class="mb-3">
                    <label>Email Address</label>
                    <input id="email" type="email"
                        class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}"
                        required autofocus>

                    @error('email')
                        <span class="invalid-feedback d-block">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- PASSWORD -->
                <div class="mb-3">
                    <label>Password</label>
                    <input id="password" type="password"
                        class="form-control @error('password') is-invalid @enderror"
                        name="password" required>

                    @error('password')
                        <span class="invalid-feedback d-block">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- REMEMBER -->
                <div class="mb-3 d-flex justify-content-between align-items-center">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox"
                            name="remember" id="remember"
                            {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label">
                            Remember Me
                        </label>
                    </div>

                    @if (Route::has('password.request'))
                        <a class="forgot-link" href="{{ route('password.request') }}">
                            Forgot Password?
                        </a>
                    @endif
                </div>

                <!-- BUTTON -->
                <button type="submit" class="btn btn-login">
                    Login
                </button>

            </form>
        </div>

    </div>
</div>

@endsection