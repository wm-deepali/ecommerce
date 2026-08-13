@extends('layouts.app')
@section('content')

    <main class="aq-faq-page">

        <!-- FAQ Hero Section -->
        <section class="aq-catpage-hero aq-apparel-hero">
            <div class="aq-hero-glow"></div>
            <div class="aq-floating-gift-box aq-floating-shape-1">
                <i class="fa-solid fa-wand-magic-sparkles"></i>
            </div>
            <div class="aq-floating-gift-box aq-floating-shape-2">
                <i class="fa-regular fa-star"></i>
            </div>
            <div class="aq-catpage-hero-content">
                <h1 class="aq-catpage-title">Frequently Asked Questions</h1>
                <div class="aq-catpage-breadcrumbs">
                    <a href="{{ route('home') }}">Home</a>
                    <span>/</span>
                    <span>FAQ</span>
                </div>
            </div>
        </section>

        <div class="aq-faq-parent-wrapper pt-120 pb-120">
            <div class="container">

                <div class="row justify-content-center text-center mb-50">
                    <div class="col-lg-8">
                        <span class="aq-section-title-sm">Client Services</span>
                        <h2 class="aq-section-title force-center-line text-center mt-10">How Can We Help You?</h2>
                        <p class="aq-section-desc mt-15">Find answers to the most common questions about our Chikankari
                            collections, shipping, returns, and bespoke orders.</p>
                    </div>
                </div>
                <div class="aq-faq-content-wrapper">

                    <div class="row justify-content-center">
                        <div class="col-lg-10">

                            <div class="accordion accordion-luxury" id="faqProductCare">

                                @foreach($faqs as $faq)
                                    <div class="accordion-item border-0 mb-4 rounded-4 shadow-sm overflow-hidden"
                                        style="transition: all 0.3s ease;">

                                        <h2 class="accordion-header" id="heading{{ $faq->id }}">
                                            <button class="accordion-button fw-md-bold fw-semibold fs-5 text-dark collapsed"
                                                type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $faq->id }}"
                                                aria-expanded="false" aria-controls="collapse{{ $faq->id }}"
                                                style="background-color: #fff; padding: 25px 30px; box-shadow: none;">

                                                <i class="fa-solid fa-circle-question me-3" style="color: #C98F9D;"></i>
                                                {{ $faq->question }}
                                            </button>
                                        </h2>

                                        <div id="collapse{{ $faq->id }}" class="accordion-collapse collapse"
                                            aria-labelledby="heading{{ $faq->id }}" data-bs-parent="#faqProductCare">

                                            <div class="accordion-body bg-white lh-lg fs-6"
                                                style="padding: 0 30px 30px 65px; border-top: 1px solid rgba(0,0,0,0.03); color: #666;">

                                                {!! nl2br(e($faq->answer)) !!}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>


                        </div>
                    </div>

                    <!-- Contact CTA -->
                    <div class="text-center mt-60">
                        <p style="font-size: 16px; color: #555; margin-bottom: 20px;">Still have questions? Our design
                            consultants are here to assist you.</p>
                        <a href="{{ route('contact-us') }}" class="aq-btn-black"
                            style="background-color: #C98F9D; border-radius: 30px; padding: 12px 30px;">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
    </main>


@endsection