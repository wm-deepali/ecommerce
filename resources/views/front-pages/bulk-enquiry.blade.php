@extends('layouts.app')
@section('content')

    <main class="aq-bulk-page"></main>


    <!-- 1. Luxury Inner Banner / Hero Section -->
    <section class="aq-catpage-hero aq-apparel-hero">
        <div class="aq-hero-glow"></div>
        <div class="aq-floating-gift-box aq-floating-shape-1">
            <i class="fa-solid fa-wand-magic-sparkles"></i>
        </div>
        <div class="aq-floating-gift-box aq-floating-shape-2">
            <i class="fa-regular fa-star"></i>
        </div>
        <div class="aq-catpage-hero-content">
            <h1 class="aq-catpage-title">Bulk Enquiry </h1>
            <div class="aq-catpage-breadcrumbs">
                <a href="{{ route('home') }}">Home</a>
                <span>/</span>
                <span>Bulk Enquiry</span>
            </div>
        </div>
    </section> <!-- collection area start -->

    <div class="aq-luxury-page-wrap pt-md-5 pb-md-5">
        <div class="container">

            <!-- Intro & Form Section -->
            <div class="row align-items-center mb-80 mt-50">
                <div class="col-lg-5 mb-5 mb-lg-0">
                    <span class="aq-luxury-subtitle">Bespoke Curation for Bulk Orders</span>
                    <h2 class="aq-luxury-title mb-4">Elevate Your Wardrobe with our Premium Collections</h2>
                    <p class="aq-luxury-desc mb-4">
                        Discover premium Chikankari suits, sarees, kurtis, and elegant women's ethnic wear, 
                        handcrafted with exquisite embroidery, exceptional quality, and delivered across India.
                    </p>
                    <div class="aq-luxury-contact-info">
                        <div class="info-item">
                            <i class="fa-solid fa-envelope"></i>
                            <div>
                                <h6>Email Us</h6>
                                <p>
                                    @if(!empty($general?->support_email))
                                        <p>{{ $general->support_email }}</p>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fa-solid fa-phone"></i>
                            <div>
                                <h6>Call Us</h6>
                                <p>
                                    @if(!empty($general?->phone))
                                        <p>{{ $general->phone }}</p>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="aq-luxury-form-wrapper">
                        <h3 class="form-title">Bulk Order Enquiry</h3>
                        <p class="form-subtitle">Please provide your details below. Our procurement team will
                            contact you within 48 hours.</p>


                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('supplier.enquiry.submit') }}" method="POST" enctype="multipart/form-data"
                            class="aq-luxury-form">
                            @csrf

                            <div class="row g-4">

                                <!-- Name -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Contact Person Name *</label>
                                        <input type="text" name="name" value="{{ old('name') }}"
                                            class="form-control @error('name') is-invalid @enderror"
                                            placeholder="Enter full name">

                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Company -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Company / Firm Name *</label>
                                        <input type="text" name="company" value="{{ old('company') }}"
                                            class="form-control @error('company') is-invalid @enderror"
                                            placeholder="Your Company Name">

                                        @error('company')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email Address *</label>
                                        <input type="email" name="email" value="{{ old('email') }}"
                                            class="form-control @error('email') is-invalid @enderror"
                                            placeholder="you@company.com">

                                        @error('email')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Phone -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Mobile / WhatsApp Number *</label>
                                        <input type="text" name="phone" value="{{ old('phone') }}"
                                            class="form-control @error('phone') is-invalid @enderror"
                                            placeholder="+91 9876543210">

                                        @error('phone')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Category -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Product Category Interested In *</label>

                                        <select name="category_id"
                                            class="form-control @error('category_id') is-invalid @enderror">

                                            <option value="">Select Category</option>

                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach

                                        </select>

                                        @error('category_id')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Quantity -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Estimated Quantity Required</label>
                                        <input type="number" min="1" name="quantity" value="{{ old('quantity') }}"
                                            class="form-control @error('quantity') is-invalid @enderror" placeholder="500">

                                        @error('quantity')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror

                                    </div>
                                </div>

                                <!-- Delivery Date -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Target Delivery Date</label>
                                        <input type="date" name="delivery_date" value="{{ old('delivery_date') }}"
                                            class="form-control @error('delivery_date') is-invalid @enderror">

                                        @error('delivery_date')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror

                                    </div>
                                </div>

                                <!-- City -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Delivery City</label>
                                        <input type="text" name="city" value="{{ old('city') }}"
                                            class="form-control @error('city') is-invalid @enderror"
                                            placeholder="Delhi, Mumbai">

                                        @error('city')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Catalogue -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Upload Reference Catalogue</label>
                                        <input type="file" name="catalogue" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                            class="form-control @error('catalogue') is-invalid @enderror">


                                        <small class="text-muted">
                                            PDF, DOC, DOCX, JPG, PNG (Max 2MB)
                                        </small>

                                        @error('catalogue')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Design & Embroidery Preferences</label>

                                        <textarea name="description" rows="4"
                                            class="form-control @error('description') is-invalid @enderror"
                                            placeholder="Describe your requirements...">{{ old('description') }}</textarea>

                                        @error('description')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror

                                    </div>
                                </div>

                                <!-- Captcha -->
                                <div class="col-12">
                                    <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}">
                                    </div>

                                    @error('g-recaptcha-response')
                                        <small class="text-danger d-block mt-2">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>

                                <div class="col-md-8 mx-auto text-center mt-4">
                                    <button type="submit" class="aq-bulk-submit-btn w-100">
                                        Request Bulk Quote
                                    </button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </main>

@endsection