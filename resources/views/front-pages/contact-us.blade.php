@extends('layouts.app')
@section('content')

    <main class="aq-contact-page">
        <!-- Hero Section -->
        <section class="aq-catpage-hero">
            <div class="aq-hero-glow"></div>
            <div class="aq-floating-gift-box aq-floating-shape-1">
                <i class="fa-solid fa-gem"></i>
            </div>
            <div class="aq-floating-gift-box aq-floating-shape-2">
                <i class="fa-solid fa-gem"></i>
            </div>
            <div class="aq-catpage-hero-content">
                <h1 class="aq-catpage-title">Contact Us</h1>
                <div class="aq-catpage-breadcrumbs">
                    <span class="text-white opacity-75">CONTACT US</span>
                </div>
            </div>
        </section>

        <!-- Contact Content Section -->
        <section class="aq-contact-content pt-100 pb-100">
            <div class="container">
                <div class="row g-5">
                    <!-- Left: Locations -->
                    <div class="col-lg-5">
                        <div class="aq-contact-info-wrapper pe-lg-4">
                            <h3 class="font-family-heading mb-40">Our Offices</h3>

                             @foreach($branches as $branch)
                                <div class="aq-office-card {{ $loop->first ? 'corporate-card' : '' }} mb-30 p-4">
                                    <div class="d-flex align-items-start">
                                        <div class="aq-office-icon me-3 mt-1">
                                            {!! $branch->icon ?: '<i class="fa-solid fa-location-dot"></i>' !!}
                                        </div>

                                        <div>
                                            <h4 class="font-family-heading mb-2">
                                                {{ $branch->title }}
                                            </h4>

                                            <p class="aq-office-address mb-2">
                                                {!! nl2br(e($branch->address)) !!}
                                            </p>

                                            <div class="aq-office-details">

                                                @if($branch->phone)
                                                    <strong>Phone:</strong> {{ $branch->phone }}<br>
                                                @endif

                                                @if($branch->email)
                                                    <strong>Email:</strong> {{ $branch->email }}<br>
                                                @endif

                                                @if($branch->working_hours)
                                                    <strong>Working Hours:</strong>
                                                    {{ $branch->working_hours }}
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                    
                        </div>
                    </div>

                    <!-- Right: Form -->
                    <div class="col-lg-7">
                        <div class="aq-contact-form-wrapper p-5">
                            <h3 class="font-family-heading mb-4 aq-contact-form-title">Send us a Message</h3>

                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif


                            <form id="aqContactPageForm" method="POST" action="{{ route('contact.submit') }}">
                                @csrf

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label class="aq-contact-label">Your Name *</label>
                                        <div class="position-relative">
                                            <i class="fa-regular fa-user position-absolute aq-contact-input-icon"></i>
                                            <input type="text" name="name"
                                                class="form-control aq-contact-input @error('name') is-invalid @enderror"
                                                value="{{ old('name') }}" placeholder="E.g. Rajesh Kumar">
                                        </div>
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label class="aq-contact-label">Email Address *</label>
                                        <div class="position-relative">
                                            <i class="fa-regular fa-envelope position-absolute aq-contact-input-icon"></i>
                                            <input type="email" name="email"
                                                class="form-control aq-contact-input @error('email') is-invalid @enderror"
                                                value="{{ old('email') }}" placeholder="xyz@gmail.com">
                                        </div>
                                        @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label class="aq-contact-label">Mobile Number *</label>
                                        <div class="position-relative">
                                            <i class="fa-solid fa-phone position-absolute aq-contact-input-icon"></i>
                                            <input type="text" name="mobile" maxlength="10"
                                                class="form-control aq-contact-input @error('mobile') is-invalid @enderror"
                                                value="{{ old('mobile') }}" placeholder="9876543210">
                                        </div>
                                        @error('mobile')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label class="aq-contact-label">Brand Name</label>
                                        <div class="position-relative">
                                            <i class="fa-solid fa-building position-absolute aq-contact-input-icon"></i>
                                            <input type="text" name="company" class="form-control aq-contact-input"
                                                value="{{ old('company') }}" placeholder="E.g. Brand Name">
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="aq-contact-label">Select Inquiry Type *</label>
                                    <select name="inquiry_type"
                                        class="form-select aq-contact-input @error('inquiry_type') is-invalid @enderror">
                                        <option value="">What can we help you with?</option>
                                        <option value="Bespoke Bridal Curation" {{ old('inquiry_type') == 'Bespoke Bridal Curation' ? 'selected' : '' }}>
                                            Bespoke Bridal Curation
                                        </option>
                                        <option value="Premium Collections" {{ old('inquiry_type') == 'Premium Collections' ? 'selected' : '' }}>
                                            Premium Collections
                                        </option>
                                        <option value="Bulk Order Enquiry" {{ old('inquiry_type') == 'Bulk Order Enquiry' ? 'selected' : '' }}>
                                            Bulk Order Enquiry
                                        </option>
                                        <option value="Other" {{ old('inquiry_type') == 'Other' ? 'selected' : '' }}>
                                            Other
                                        </option>
                                    </select>
                                    @error('inquiry_type')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="aq-contact-label">Your Message *</label>
                                    <textarea name="message"
                                        class="form-control aq-contact-input @error('message') is-invalid @enderror"
                                        rows="4"
                                        placeholder="Tell us about your requirements...">{{ old('message') }}</textarea>
                                    @error('message')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                {{-- Google reCAPTCHA --}}
                                <div class="mb-4">
                                    <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}">
                                    </div>

                                    @error('g-recaptcha-response')
                                        <small class="text-danger d-block mt-2">{{ $message }}</small>
                                    @enderror
                                </div>

                                <button type="submit" class="aq-contact-btn-submit w-100">
                                    <span>Send Message</span>
                                    <i class="fa-solid fa-paper-plane ms-2"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <style>
        .is-invalid {
            border-color: #dc3545 !important;
        }

        .invalid-feedback {
            display: block;
            font-size: 13px;
            color: #dc3545;
            margin-top: 6px;
        }
    </style>
@endsection