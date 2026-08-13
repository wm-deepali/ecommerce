@extends('layouts.app')
@section('content')

    <main>

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
                <div class="aq-catpage-breadcrumbs">
                    <a href="{{ route('home') }}">Home</a>
                    <span>/</span>
                    <span>Categories</span>
                </div>
            </div>
        </section>

        <!-- categories area start -->
        <section class="aqf-categories-area">
            <div class="aqf-cat-floating-shape aqf-cat-shape-1">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
                </svg>
            </div>
            <div class="aqf-cat-floating-shape aqf-cat-shape-2">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                    stroke-linejoin="round">
                    <rect x="3" y="8" width="18" height="13" rx="2" ry="2" />
                    <path d="M12 8V21M3 13h18M12 8L7 2M12 8l5-6" />
                </svg>
            </div>
            <div class="container">
                <div class="row align-items-center mb-40">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                        <div class="aq-creative-title-box">
                            <span class="aq-creative-subtitle">Curated For You</span>
                            <h4 class="aq-creative-title">Shop by Category</h4>
                            <div class="aq-creative-title-line"></div>
                        </div>
                    </div>
                </div>

                <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 g-4 pb-30 mb-50">

                    @forelse($categories as $category)

                                <div class="col">
                                    <div class="aqf-categories-item text-center">
                                                                               <a href="{{ route('products.listing', $category->slug) }}">
                                            <div class="aqf-categories-img">
                                                <img src="{{ $category->image
                        ? asset('storage/' . $category->image)
                        : asset('assets/img/no-image.png') }}" alt="{{ $category->name }}" loading="lazy" />
                                            </div>
                                            <span
                                                style="font-family: var(--aq-ff-heading); font-size: 18px; font-weight: 500; color: var(--aq-color-black);">
                                                {{ $category->name }}
                                            </span>
                                        </a>
                                    </div>
                                </div>

                    @empty
                        <div class="col-12 text-center">
                            <p>No categories found.</p>
                        </div>
                    @endforelse

                </div>
            </div>
            </div>
        </section>
        <!-- categories area end -->
    </main>

@endsection