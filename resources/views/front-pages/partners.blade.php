@extends('layouts.app')
@section('content')


 <main class="aq-contact-page aq-partners-page">
        <!-- Hero Section -->
        <section class="aq-catpage-hero">
            <div class="aq-hero-glow"></div>
            <div class="aq-floating-gift-box aq-floating-shape-1">
                <i class="fa-solid fa-handshake"></i>
            </div>
            <div class="aq-floating-gift-box aq-floating-shape-2">
                <i class="fa-solid fa-gem"></i>
            </div>
            <div class="aq-catpage-hero-content">
                <h1 class="aq-catpage-title">Our Partners</h1>
                <div class="aq-catpage-breadcrumbs">
                    <span class="text-white opacity-75">PARTNERS & COLLABORATIONS</span>
                </div>
            </div>
        </section>

        <!-- Partner Content Section -->
        <section class="aq-partner-content pt-100 pb-100">
            <div class="container">
                <div class="row g-5 align-items-center">
                    
                    <!-- Left: Information / Benefits -->
                    <div class="col-lg-6">
                        <div class="aq-partner-info-wrapper pe-lg-4">
                            <span class="aq-section-title-sm mb-15 d-inline-block" style="color: var(--aq-color-maroon); letter-spacing: 2px; font-weight: 600; text-transform: uppercase;">Collaborate With Us</span>
                            <h2 class="font-family-heading mb-30">Become an Oudhyana Partner</h2>
                            <p class="mb-40" style="color: #555; font-size: 16px; line-height: 1.8;">
                                Join our exclusive network of premium boutiques, luxury curators, and esteemed B2B distributors. We provide authentic, handcrafted Chikankari apparel tailored for your discerning clientele. Partnering with Oudhyana guarantees unmatched craftsmanship, reliable delivery, and dedicated support.
                            </p>
                            
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="aq-partner-benefit-card text-center p-4">
                                        <div class="icon-wrap mb-3">
                                            <i class="fa-solid fa-gem"></i>
                                        </div>
                                        <h4>Premium Quality</h4>
                                        <p>100% authentic, handcrafted luxury apparel.</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="aq-partner-benefit-card text-center p-4">
                                        <div class="icon-wrap mb-3">
                                            <i class="fa-solid fa-chart-line"></i>
                                        </div>
                                        <h4>B2B Pricing</h4>
                                        <p>Exclusive margins for bulk and wholesale orders.</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="aq-partner-benefit-card text-center p-4">
                                        <div class="icon-wrap mb-3">
                                            <i class="fa-solid fa-headset"></i>
                                        </div>
                                        <h4>Dedicated Support</h4>
                                        <p>A dedicated manager for your wholesale orders.</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="aq-partner-benefit-card text-center p-4">
                                        <div class="icon-wrap mb-3">
                                            <i class="fa-solid fa-box-open"></i>
                                        </div>
                                        <h4>Custom Branding</h4>
                                        <p>Bespoke packaging and labeling options.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Form -->
                    <div class="col-lg-6">
                        <div class="aq-contact-form-wrapper p-5" style="background: #fcfbf9; border: 1px solid rgba(201, 143, 157, 0.2); border-radius: 20px;">
                            <h3 class="font-family-heading mb-4 aq-contact-form-title">Partner Registration</h3>
                            
                            <form id="aqPartnerPageForm" onsubmit="event.preventDefault(); window.location.href='thankyou.html';">
                                <div class="row">
                                    <div class="col-md-12 mb-4">
                                        <label class="aq-contact-label">Business Name *</label>
                                        <div class="position-relative">
                                            <i class="fa-solid fa-building position-absolute aq-contact-input-icon"></i>
                                            <input type="text" class="form-control aq-contact-input" required placeholder="E.g. Luxe Boutiques Inc." />
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label class="aq-contact-label">Contact Person *</label>
                                        <div class="position-relative">
                                            <i class="fa-regular fa-user position-absolute aq-contact-input-icon"></i>
                                            <input type="text" class="form-control aq-contact-input" required placeholder="Your Name" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label class="aq-contact-label">Business Email *</label>
                                        <div class="position-relative">
                                            <i class="fa-regular fa-envelope position-absolute aq-contact-input-icon"></i>
                                            <input type="email" class="form-control aq-contact-input" required placeholder="hello@company.com" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label class="aq-contact-label">Mobile Number *</label>
                                        <div class="position-relative">
                                            <i class="fa-solid fa-phone position-absolute aq-contact-input-icon"></i>
                                            <input type="tel" class="form-control aq-contact-input" required placeholder="+91 0000 000 000" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label class="aq-contact-label">Business Type *</label>
                                        <select class="form-select aq-contact-input" required>
                                            <option value="" disabled selected>Select Type</option>
                                            <option value="Retail Boutique">Retail Boutique</option>
                                            <option value="Wholesale Distributor">Wholesale Distributor</option>
                                            <option value="Online Retailer">Online Retailer</option>
                                            <option value="Corporate Gifting Agency">Corporate Gifting Agency</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="aq-contact-label">Tell us about your requirements...</label>
                                    <textarea class="form-control aq-contact-input" required placeholder="E.g., We are looking for custom bridal collections for our boutique..." rows="4"></textarea>
                                </div>
                                <button type="submit" class="aq-contact-btn-submit w-100" style="background: var(--aq-color-maroon); color: #fff; padding: 15px; border-radius: 8px; border: none; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; transition: 0.3s;">
                                    <span>Submit Partnership Enquiry</span>
                                    <i class="fa-solid fa-paper-plane ml-10"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

@endsection

