@extends('layouts.app')
@section('content')

  <main class="aq-why-choose-page">
        <!-- 1. Luxury Inner Banner / Hero Section -->
        <section class="aq-catpage-hero">
            <div class="aq-hero-glow"></div>
            <div class="aq-floating-gift-box aq-floating-shape-1">
                <i class="fa-solid fa-gift"></i>
            </div>
            <div class="aq-floating-gift-box aq-floating-shape-2">
                <i class="fa-solid fa-gem"></i>
            </div>
            <div class="aq-catpage-hero-content">
                <h1 class="aq-catpage-title">Why Choose Us</h1>
                <div class="aq-catpage-breadcrumbs">
                    <a href="{{ route('home') }}">Home</a>
                    <span>/</span>
                    <span>Why Choose Us</span>
                </div>
            </div>
        </section>

        <!-- Breadcrumb Bar -->



        <!-- Features Section -->
        <section class="aq-why-features-creative pb-100 pt-100 p-relative">
            <!-- Ambient Backgrounds -->
            <div class="aq-ambient-glow-1"></div>
            <div class="aq-ambient-glow-2"></div>

            <div class="container p-relative z-index-1">
                <div class="row justify-content-center text-center mb-70">
                    <div class="col-lg-8">
                        <span class="aq-section-title-sm">Our Value Proposition</span>
                        <h2 class="aq-section-title">Why Choose Oudhyana India</h2>
                        <p class="aq-section-desc" style="max-width: 700px; margin: 0 auto;">
                            From premium Chikankari product selection to seamless customization and reliable delivery, we provide
                            end-to-end luxury gifting solutions designed to save your time and elevate your brand.
                        </p>
                    </div>
                </div>

                <div class="row g-4 aq-staggered-grid">
                    <div class="col-lg-4 col-md-6 aq-stagger-item">
                        <div class="aq-creative-card">
                            <div class="aq-creative-icon">
                                <i class="fa-solid fa-palette"></i>
                            </div>
                            <h4 class="aq-creative-title">Premium Quality & Handcrafting</h4>
                            <p class="aq-creative-desc">We offer meticulously curated handcrafted Chikankari apparel that meet high-quality
                                standards, complemented by premium packaging and bespoke branding solutions.</p>
                            <div class="aq-creative-card-glow"></div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 aq-stagger-item delay-1">
                        <div class="aq-creative-card">
                            <div class="aq-creative-icon">
                                <i class="fa-solid fa-truck-fast"></i>
                            </div>
                            <h4 class="aq-creative-title">Efficient & Reliable Delivery</h4>
                            <p class="aq-creative-desc">Our streamlined logistics ensure timely and dependable delivery
                                across India, with the flexibility to accommodate urgent requirements through expedited
                                processing.</p>
                            <div class="aq-creative-card-glow"></div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 aq-stagger-item delay-2">
                        <div class="aq-creative-card">
                            <div class="aq-creative-icon">
                                <i class="fa-solid fa-leaf"></i>
                            </div>
                            <h4 class="aq-creative-title">Sustainable Gifting Solutions</h4>
                            <p class="aq-creative-desc">We offer a thoughtfully curated range of eco-conscious products
                                crafted from sustainable materials, enabling your brand to align with responsible and
                                environmentally mindful practices.</p>
                            <div class="aq-creative-card-glow"></div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 aq-stagger-item">
                        <div class="aq-creative-card">
                            <div class="aq-creative-icon">
                                <i class="fa-solid fa-tags"></i>
                            </div>
                            <h4 class="aq-creative-title">Cost-Effective Value</h4>
                            <p class="aq-creative-desc">We deliver optimal value through competitive pricing structures,
                                ensuring high-quality gifting solutions without compromising on standards, especially
                                for bulk and recurring requirements.</p>
                            <div class="aq-creative-card-glow"></div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 aq-stagger-item delay-1">
                        <div class="aq-creative-card">
                            <div class="aq-creative-icon">
                                <i class="fa-solid fa-certificate"></i>
                            </div>
                            <h4 class="aq-creative-title">Quality Assurance & Support</h4>
                            <p class="aq-creative-desc">Every order undergoes strict quality checks, supported by a
                                responsive team committed to addressing concerns promptly and ensuring a smooth client
                                experience.</p>
                            <div class="aq-creative-card-glow"></div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 aq-stagger-item delay-2">
                        <div class="aq-creative-card">
                            <div class="aq-creative-icon">
                                <i class="fa-solid fa-handshake-angle"></i>
                            </div>
                            <h4 class="aq-creative-title">Dedicated Corporate Assistance</h4>
                            <p class="aq-creative-desc">We provide end-to-end support with structured coordination,
                                including requirement consultation, artwork approvals, and seamless execution from
                                product selection to final delivery.</p>
                            <div class="aq-creative-card-glow"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="aq-luxury-cta-section pt-100 pb-100 p-relative mt-60">
            <!-- Ambient Glows -->
            <div class="aq-cta-glow-1"></div>
            <div class="aq-cta-glow-2"></div>

            <div class="container p-relative">
                <div class="row justify-content-center">
                    <div class="col-xl-8 col-lg-10 text-center">
                        <span class="aq-section-title-sm mb-15 d-inline-block">Begin Your Journey</span>
                        <h2 class="font-family-heading mb-25">
                            Elevate Your <span>Wardrobe</span>
                        </h2>
                        <p class="mb-45">
                            Explore our exclusive collection of handcrafted Anarkalis, Sarees, and Gowns designed to bring timeless elegance and Chikankari artistry to your style.
                        </p>

                        <div class="d-flex justify-content-center align-items-center flex-wrap gap-3">
                            <a href="product_details.html"
                                class="aq-cta-btn-primary d-inline-flex align-items-center justify-content-center">
                                Shop New Arrivals
                            </a>
                            <a href="{{ route('categories') }}"
                                class="aq-cta-btn-outline d-inline-flex align-items-center justify-content-center">
                                Explore Collections <i class="fa-solid fa-arrow-right-long ml-10"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Trusted Partners Section -->
        <section>
            <div class="aqf-brand-area pt-20 pb-20">
                <div class="container">
                    <div class="aq-creative-title-box mb-60 pt-30">
                        <span class="aq-creative-subtitle">Trusted Partners</span>
                        <h2 class="aq-creative-title">
                            Trusted by 500+ Leading Companies
                        </h2>
                        <div class="aq-creative-title-line"></div>
                    </div>

                    <div class="swiper aq-brand-active">
                        <div class="swiper-wrapper align-items-center">
                            <div class="swiper-slide">
                                <div class="aq-brand-item">
                                    <img src="assets/img/corporate/amazon_logo.webp" alt="Amazon" />
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="aq-brand-item">
                                    <img src="assets/img/corporate/google_logo.webp" alt="Google" />
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="aq-brand-item">
                                    <img src="assets/img/corporate/ibm_logo.webp" alt="IBM" />
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="aq-brand-item">
                                    <img src="assets/img/corporate/netflix_logo.webp" alt="Netflix" />
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="aq-brand-item">
                                    <img src="assets/img/corporate/microsoft_logo.webp" alt="Microsoft" />
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="aq-brand-item">
                                    <img src="assets/img/corporate/apple_logo.webp" alt="Apple" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- CTA Section -->


    </main>

@endsection

