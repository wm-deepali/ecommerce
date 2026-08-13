@extends('layouts.app')
@section('content')

    <style>
        .wishlist-active {
            background: #ff4d94 !important;
            color: #fff !important;
        }

        .wishlist-active svg path {
            stroke: #fff !important;
        }
    </style>

    <main>

        <!-- slider area start -->
        <div class="aqf-slider-area">
            <div class="swiper aqf-slider-active p-relative">
                <div class="swiper-wrapper">

                    @foreach($sliders as $slider)

                        <!-- Desktop Slider 1 -->
                        <div class="swiper-slide d-none d-md-block">
                            <div class="aqf-slider-item aqf-slider-height d-flex align-items-center" data-bg-color="#F5F5F5">
                                <a href="{{ $slider->link ?: '#' }}" class="aq-slider-banner-overlay-link"></a>
                                <div class="aqf-slider-thumb include-bg"
                                    data-background="{{ asset('storage/' . $slider->image) }}">
                                </div>
                                <div class="container custom-fluid-container">
                                    <div class="row align-items-center">
                                        <div class="col-xl-6 col-lg-7 col-md-8">
                                            <div class="aqf-slider-content">
                                                <div class="aqf-slider-btn-wrap d-flex align-items-center gap-3">
                                                    {{-- ✅ FIX: was hardcoded to route('categories') — now goes
                                                    wherever the admin set the link for THIS slide when
                                                    creating/editing it. Falls back to the categories page
                                                    only if the admin left the link field empty. --}}
                                                    <a class="aq-btn-black"
                                                        href="{{ $slider->link ?: route('categories') }}">Explore
                                                        Products</a>
                                                    <a class="aq-btn-black btn-red-bg" href="javascript:void(0);"
                                                        onclick="openGlobalDrawer('home')">Get Bulk
                                                        Quote</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @endforeach


                    @foreach($sliders as $slider)

                        <!-- Mobile Slider 1 -->
                        <div class="swiper-slide d-block d-md-none">
                            <div class="aqf-slider-item aqf-slider-height d-flex align-items-center" data-bg-color="#F5F5F5">
                                <a href="{{ $slider->link ?: '#' }}" class="aq-slider-banner-overlay-link"></a>
                                <div class="aqf-slider-thumb include-bg"
                                    data-background="{{ asset('storage/' . $slider->image) }}">
                                </div>
                                <div class="container custom-fluid-container">
                                    <div class="row align-items-center">
                                        <div class="col-xl-6 col-lg-7 col-md-8">
                                            <div class="aqf-slider-content">
                                                <div class="aqf-slider-btn-wrap d-flex align-items-center gap-3">
                                                    {{-- ✅ same fix applied to the mobile slide --}}
                                                    <a class="aq-btn-black"
                                                        href="{{ $slider->link ?: route('categories') }}">Explore
                                                        Products</a>
                                                    <a class="aq-btn-black btn-red-bg" href="javascript:void(0);"
                                                        onclick="openGlobalDrawer('home')">Get Bulk
                                                        Quote</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @endforeach


                </div>
                <div class="aqf-slider-dot"></div>
            </div>
        </div>
        <!-- slider area end -->


        <!-- text slide area start -->
        <div class="aqf-text-slide-area aqf-text-slide-bdr fix">
            <div class="aqf-text-slide-wrap pt-20 pb-20">
                @foreach($textSliders as $item)

                    <div class="aqf-text-slide-item">

                        <p>{{ $item->title }}</p>

                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="17" viewBox="0 0 15 17" fill="none">

                                <path d="M8.27778 0.5L0.5 10.1H7.5L6.72222 16.5L14.5 6.9H7.5L8.27778 0.5Z" stroke="currentcolor"
                                    stroke-linecap="round" stroke-linejoin="round">
                                </path>

                            </svg>
                        </span>

                    </div>

                @endforeach

            </div>
        </div>
        <!-- text slide area end -->


        <!-- categories area start -->
        <!--   <section class="aqf-categories-area">
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
                            <div class="container custom-fluid-container">
                                <div class="row align-items-center mb-40">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-12">

                                        <div class="aq-creative-title-box ">
                                            <span class="aq-creative-subtitle">Curated For You</span>
                                            <h4 class="aq-creative-title">Shop by Category</h4>
                                            <div class="aq-creative-title-line"></div>
                                        </div>


                                        <div class="position-relative">
                                            <div class="aqf-categories-nav text-end ">
                                                <button class="aqf-categories-prev"><i class="fal fa-angle-left"></i></button>
                                                <button class="aqf-categories-next"><i class="fal fa-angle-right"></i></button>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="swiper aqf-categories-active">
                                            <div class="swiper-wrapper">

                                                @foreach($popularCategories as $category)

                                                    <!-- Women Wear -->
        <!--    <div class="swiper-slide">
                                                        <div class="aqf-categories-item text-center">
                                                            <a href="{{ route('products.listing', $category->slug) }}">

                                                                <div class="aqf-categories-img">
                                                                    <img src="{{ asset('storage/' . $category->image) }}"
                                                                        alt="{{ $category->name }}" alt="{{$category->name  }}">
                                                                </div>
                                                                <span
                                                                    style="font-family: var(--aq-ff-heading); font-size: 18px; font-weight: 500; color: var(--aq-color-black);">
                                                                    {{ $category->name }}
                                                                </span>
                                                            </a>
                                                        </div>
                                                    </div>


                                                @endforeach


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </section> -->
        <!-- categories area end -->


        <!-- Section 1: Premium Pastel Trust Cards Start -->



        <!-- Section 1: Premium Pastel Trust Cards End -->



        <!-- collection area start -->
        <section>
            <div class="aqf-collection-area fix ">
                <div class="container custom-fluid-container">
                    <div class="aqf-collection-top mb-40">
                        <div class="row align-items-end">
                            <div class="col-md-12">

                                <div class="aq-creative-title-box">
                                    <span class="aq-creative-subtitle">Celebrate Moments</span>
                                    <h4 class="aq-creative-title">Explore Chikankari Collections</h4>
                                    <div class="aq-creative-title-line"></div>
                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="aqf-collection-slider-wrap">
                        <div class="swiper aqf-collection-active">
                            <div class="swiper-wrapper">

                                @foreach($occasions as $occasion)

                                    <div class="swiper-slide">
                                        <div class="aqf-collection-item p-relative">
                                            <div class="aqf-collection-thumb">
                                                <img src="{{ asset('storage/' . $occasion->image) }}"
                                                    alt="{{ $occasion->title }}">
                                            </div>
                                            <div
                                                class="aqf-collection-content-wrap d-flex align-items-center justify-content-between">
                                                <div class="aqf-collection-content">
                                                    <h4 class="aqf-collection-title">
                                                        <a
                                                            href="{{ route('occasions.listing', $occasion->slug) }}">{{ $occasion->title }}</a>
                                                    </h4>
                                                    <span>{{ $occasion->sub_title }}</span>
                                                </div>
                                                <div class="aqf-collection-link-wrap">
                                                    <a class="aqf-collection-link"
                                                        href="{{ route('occasions.listing', $occasion->slug) }}">
                                                        <span>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                                                viewBox="0 0 12 12" fill="none">
                                                                <path
                                                                    d="M0.75 5.75H10.75M10.75 5.75L5.75 0.75M10.75 5.75L5.75 10.75"
                                                                    stroke="currentcolor" stroke-width="1.5"
                                                                    stroke-linecap="round" stroke-linejoin="round"></path>
                                                            </svg>
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>

        <!-- product area start -->
        <section>
            <div class="aq-product-area pt-20 pb-20 ">
                <div class="container custom-fluid-container">
                    <div class="aq-product-top mb-40">
                        <div class="row align-items-end">
                            <div class="col-md-12">


                                <div class="aq-creative-title-box">
                                    <span class="aq-creative-subtitle">Top Rated</span>
                                    <h4 class="aq-creative-title">Best Selling</h4>
                                    <div class="aq-creative-title-line"></div>
                                </div>

                            </div>
                            <div class="col-md-12">
                                <div class="aq-product-tab-btn text-center  mb-15">
                                    <ul class="nav nav-tab d-inline-flex" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-links active" id="home-tab" data-bs-toggle="tab"
                                                data-bs-target="#home-tab-pane" type="button" role="tab"
                                                aria-controls="home-tab-pane" aria-selected="true">New Arrivals</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-links" id="profile-tab" data-bs-toggle="tab"
                                                data-bs-target="#profile-tab-pane" type="button" role="tab"
                                                aria-controls="profile-tab-pane" aria-selected="false">Best
                                                Sellers</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-links" id="contact-tab" data-bs-toggle="tab"
                                                data-bs-target="#contact-tab-pane" type="button" role="tab"
                                                aria-controls="contact-tab-pane" aria-selected="false">Premium</button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab"
                            tabindex="0">
                            <div class="row row-cols-xl-4 row-cols-lg-4 row-cols-md-2 row-cols-sm-2 row-cols-1">

                                @foreach($newArrivalProducts as $product)
                                    <div class="col">
                                        <div class="aq-product-item aq-product-main mb-20" data-lazy="true">
                                            <div class="aq-product-thumb aq-img-hover-wrap p-relative mb-10">

                                                @if($product->discount > 0 || $product->new_arrival)
                                                    <div class="aq-product-badge">

                                                        @if($product->discount > 0)

                                                            @if($product->discount_type == 'percentage')
                                                                <span class="clr-sale">
                                                                    -{{ rtrim(rtrim(number_format($product->discount, 2), '0'), '.') }}%
                                                                </span>
                                                            @else
                                                                <span class="clr-sale">
                                                                    ₹{{ number_format($product->discount) }} OFF
                                                                </span>
                                                            @endif

                                                        @endif

                                                        <span class="clr-new">new</span>

                                                    </div>
                                                @endif
                                                <div class="aq-product-action">

                                                    <button type="button" class="aq-product-action-btn aq-tooltip"
                                                        data-bs-toggle="modal" data-bs-target="#producQuickViewModal">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="16"
                                                            viewBox="0 0 19 16" fill="none">
                                                            <path
                                                                d="M12.0557 7.75429C12.0557 9.42922 10.7022 10.7827 9.0273 10.7827C7.35238 10.7827 5.99891 9.42922 5.99891 7.75429C5.99891 6.07937 7.35238 4.72589 9.0273 4.72589C10.7022 4.72589 12.0557 6.07937 12.0557 7.75429Z"
                                                                stroke="currentcolor" stroke-width="1.5" stroke-linecap="round"
                                                                stroke-linejoin="round"></path>
                                                            <path
                                                                d="M9.02734 14.75C12.0134 14.75 14.7965 12.9905 16.7337 9.94517C17.495 8.75242 17.495 6.74758 16.7337 5.55483C14.7965 2.50952 12.0134 0.75 9.02734 0.75C6.04124 0.75 3.25816 2.50952 1.321 5.55483C0.559668 6.74758 0.559668 8.75242 1.321 9.94517C3.25816 12.9905 6.04124 14.75 9.02734 14.75Z"
                                                                stroke="currentcolor" stroke-width="1.5" stroke-linecap="round"
                                                                stroke-linejoin="round"></path>
                                                        </svg>
                                                        <span class="aq-tooltip-item">Quick View</span>
                                                    </button>
                                                    <button type="button" onclick="addToWishlist({{ $product->id }})"
                                                        class="aq-product-action-btn aq-wishlist-btn aq-tooltip {{ in_array($product->id, $wishlistIds ?? []) ? 'wishlist-active' : '' }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="16"
                                                            viewBox="0 0 18 16" fill="none">
                                                            <path
                                                                d="M14.7197 1.52347C12.5744 0.244089 10.7019 0.759666 9.57712 1.58092C9.11591 1.91766 8.88531 2.08602 8.74963 2.08602C8.61396 2.08602 8.38336 1.91766 7.92215 1.58092C6.79733 0.759666 4.9249 0.244089 2.77958 1.52347C-0.0359114 3.20253 -0.67299 8.7418 5.82126 13.4151C7.05821 14.3052 7.67668 14.7502 8.74963 14.7502C9.82258 14.7502 10.4411 14.3052 11.678 13.4151C18.1723 8.7418 17.5352 3.20253 14.7197 1.52347Z"
                                                                stroke="currentcolor" stroke-width="1.5" stroke-linecap="round">
                                                            </path>
                                                        </svg>
                                                        <span class="aq-tooltip-item">Add To Wishlist</span>
                                                    </button>

                                                </div>

                                                <a href="{{ route('product.details', $product->slug) }}">

                                                    <img class="lazyload aq-product-img"
                                                        src="{{ asset($product->display_image) }}" alt="{{ $product->name }}" />

                                                    <img class="aq-img-hover lazyload"
                                                        src="{{ asset($product->display_image) }}" alt="{{ $product->name }}" />

                                                </a>
                                            </div>
                                            <div class="aq-product-content text-center text-md-start">

                                                <h4 class="aq-product-title mb-10">
                                                    <a href="{{ route('product.details', $product->slug) }}">
                                                        {{ $product->name }}
                                                    </a>
                                                </h4>
                                                <div class="aq-product-price">

                                                    <ins>
                                                        <span class="aq-product-new-price">
                                                            ₹{{ number_format($product->price) }}
                                                        </span>
                                                    </ins>

                                                    @if($product->mrp > $product->price)
                                                        <del>
                                                            <span class="aq-product-old-price">
                                                                ₹{{ number_format($product->mrp) }}
                                                            </span>
                                                        </del>
                                                    @endif

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab"
                            tabindex="0">
                            <div class="row row-cols-xl-4 row-cols-lg-3 row-cols-md-2 row-cols-sm-2 row-cols-1">

                                @foreach($bestSellers as $product)

                                    <div class="col">
                                        <div class="aq-product-item aq-product-main mb-20" data-lazy="true">
                                            <div class="aq-product-thumb aq-img-hover-wrap p-relative mb-10">
                                                @if($product->discount > 0 || $product->best_seller)
                                                    <div class="aq-product-badge">

                                                        @if($product->discount > 0)

                                                            @if($product->discount_type == 'percentage')
                                                                <span class="clr-sale">
                                                                    -{{ rtrim(rtrim(number_format($product->discount, 2), '0'), '.') }}%
                                                                </span>
                                                            @else
                                                                <span class="clr-sale">
                                                                    ₹{{ number_format($product->discount) }} OFF
                                                                </span>
                                                            @endif

                                                        @endif
                                                        <span class="clr-hot">Hot</span>
                                                    </div>
                                                @endif
                                                <div class="aq-product-action">

                                                    <button type="button" class="aq-product-action-btn aq-tooltip"
                                                        data-bs-toggle="modal" data-bs-target="#producQuickViewModal">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="16"
                                                            viewBox="0 0 19 16" fill="none">
                                                            <path
                                                                d="M12.0557 7.75429C12.0557 9.42922 10.7022 10.7827 9.0273 10.7827C7.35238 10.7827 5.99891 9.42922 5.99891 7.75429C5.99891 6.07937 7.35238 4.72589 9.0273 4.72589C10.7022 4.72589 12.0557 6.07937 12.0557 7.75429Z"
                                                                stroke="currentcolor" stroke-width="1.5" stroke-linecap="round"
                                                                stroke-linejoin="round"></path>
                                                            <path
                                                                d="M9.02734 14.75C12.0134 14.75 14.7965 12.9905 16.7337 9.94517C17.495 8.75242 17.495 6.74758 16.7337 5.55483C14.7965 2.50952 12.0134 0.75 9.02734 0.75C6.04124 0.75 3.25816 2.50952 1.321 5.55483C0.559668 6.74758 0.559668 8.75242 1.321 9.94517C3.25816 12.9905 6.04124 14.75 9.02734 14.75Z"
                                                                stroke="currentcolor" stroke-width="1.5" stroke-linecap="round"
                                                                stroke-linejoin="round"></path>
                                                        </svg>
                                                        <span class="aq-tooltip-item">Quick View</span>
                                                    </button>
                                                    <button type="button" onclick="addToWishlist({{ $product->id }})"
                                                        class="aq-product-action-btn aq-wishlist-btn aq-tooltip {{ in_array($product->id, $wishlistIds ?? []) ? 'wishlist-active' : '' }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="16"
                                                            viewBox="0 0 18 16" fill="none">
                                                            <path
                                                                d="M14.7197 1.52347C12.5744 0.244089 10.7019 0.759666 9.57712 1.58092C9.11591 1.91766 8.88531 2.08602 8.74963 2.08602C8.61396 2.08602 8.38336 1.91766 7.92215 1.58092C6.79733 0.759666 4.9249 0.244089 2.77958 1.52347C-0.0359114 3.20253 -0.67299 8.7418 5.82126 13.4151C7.05821 14.3052 7.67668 14.7502 8.74963 14.7502C9.82258 14.7502 10.4411 14.3052 11.678 13.4151C18.1723 8.7418 17.5352 3.20253 14.7197 1.52347Z"
                                                                stroke="currentcolor" stroke-width="1.5" stroke-linecap="round">
                                                            </path>
                                                        </svg>
                                                        <span class="aq-tooltip-item">Add To Wishlist</span>
                                                    </button>

                                                </div>
                                                <a href="{{ route('product.details', $product->slug) }}">

                                                    <img class="lazyload aq-product-img"
                                                        src="{{ asset($product->display_image) }}" alt="{{ $product->name }}" />

                                                    <img class="aq-img-hover lazyload"
                                                        src="{{ asset($product->display_image) }}" alt="{{ $product->name }}" />

                                                </a>
                                            </div>
                                            <div class="aq-product-content">

                                                <h4 class="aq-product-title mb-10">
                                                    <a href="{{ route('product.details', $product->slug) }}">
                                                        {{ $product->name }}
                                                    </a>
                                                </h4>
                                                <div class="aq-product-price">

                                                    <ins>
                                                        <span class="aq-product-new-price">
                                                            ₹{{ number_format($product->price) }}
                                                        </span>
                                                    </ins>

                                                    @if($product->mrp > $product->price)
                                                        <del>
                                                            <span class="aq-product-old-price">
                                                                ₹{{ number_format($product->mrp) }}
                                                            </span>
                                                        </del>
                                                    @endif

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                        <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab"
                            tabindex="0">
                            <div class="row row-cols-xl-4 row-cols-lg-3 row-cols-md-2 row-cols-sm-2 row-cols-1">

                                @foreach($premiumCollections as $product)
                                    <div class="col">
                                        <div class="aq-product-item aq-product-main mb-20" data-lazy="true">
                                            <div class="aq-product-thumb aq-img-hover-wrap p-relative mb-10">
                                                @if($product->discount > 0 || $product->featured)
                                                    <div class="aq-product-badge">

                                                        @if($product->discount > 0)

                                                            @if($product->discount_type == 'percentage')
                                                                <span class="clr-sale">
                                                                    -{{ rtrim(rtrim(number_format($product->discount, 2), '0'), '.') }}%
                                                                </span>
                                                            @else
                                                                <span class="clr-sale">
                                                                    ₹{{ number_format($product->discount) }} OFF
                                                                </span>
                                                            @endif

                                                        @endif
                                                        <span class="clr-hot">Hot</span>

                                                    </div>
                                                @endif

                                                <div class="aq-product-action">

                                                    <button type="button" class="aq-product-action-btn aq-tooltip"
                                                        data-bs-toggle="modal" data-bs-target="#producQuickViewModal">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="16"
                                                            viewBox="0 0 19 16" fill="none">
                                                            <path
                                                                d="M12.0557 7.75429C12.0557 9.42922 10.7022 10.7827 9.0273 10.7827C7.35238 10.7827 5.99891 9.42922 5.99891 7.75429C5.99891 6.07937 7.35238 4.72589 9.0273 4.72589C10.7022 4.72589 12.0557 6.07937 12.0557 7.75429Z"
                                                                stroke="currentcolor" stroke-width="1.5" stroke-linecap="round"
                                                                stroke-linejoin="round"></path>
                                                            <path
                                                                d="M9.02734 14.75C12.0134 14.75 14.7965 12.9905 16.7337 9.94517C17.495 8.75242 17.495 6.74758 16.7337 5.55483C14.7965 2.50952 12.0134 0.75 9.02734 0.75C6.04124 0.75 3.25816 2.50952 1.321 5.55483C0.559668 6.74758 0.559668 8.75242 1.321 9.94517C3.25816 12.9905 6.04124 14.75 9.02734 14.75Z"
                                                                stroke="currentcolor" stroke-width="1.5" stroke-linecap="round"
                                                                stroke-linejoin="round"></path>
                                                        </svg>
                                                        <span class="aq-tooltip-item">Quick View</span>
                                                    </button>
                                                    <button type="button" onclick="addToWishlist({{ $product->id }})"
                                                        class="aq-product-action-btn aq-wishlist-btn aq-tooltip {{ in_array($product->id, $wishlistIds ?? []) ? 'wishlist-active' : '' }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="16"
                                                            viewBox="0 0 18 16" fill="none">
                                                            <path
                                                                d="M14.7197 1.52347C12.5744 0.244089 10.7019 0.759666 9.57712 1.58092C9.11591 1.91766 8.88531 2.08602 8.74963 2.08602C8.61396 2.08602 8.38336 1.91766 7.92215 1.58092C6.79733 0.759666 4.9249 0.244089 2.77958 1.52347C-0.0359114 3.20253 -0.67299 8.7418 5.82126 13.4151C7.05821 14.3052 7.67668 14.7502 8.74963 14.7502C9.82258 14.7502 10.4411 14.3052 11.678 13.4151C18.1723 8.7418 17.5352 3.20253 14.7197 1.52347Z"
                                                                stroke="currentcolor" stroke-width="1.5" stroke-linecap="round">
                                                            </path>
                                                        </svg>
                                                        <span class="aq-tooltip-item">Add To Wishlist</span>
                                                    </button>

                                                </div>
                                                <a href="{{ route('product.details', $product->slug) }}">

                                                    <img class="lazyload aq-product-img"
                                                        src="{{ asset($product->display_image) }}" alt="{{ $product->name }}" />

                                                    <img class="aq-img-hover lazyload"
                                                        src="{{ asset($product->display_image) }}" alt="{{ $product->name }}" />

                                                </a>

                                            </div>
                                            <div class="aq-product-content text-center text-md-start">

                                                <h4 class="aq-product-title mb-10">
                                                    <a href="{{ route('product.details', $product->slug) }}">
                                                        {{ $product->name }}
                                                    </a>
                                                </h4>
                                                <div class="aq-product-price">

                                                    <ins>
                                                        <span class="aq-product-new-price">
                                                            ₹{{ number_format($product->price) }}
                                                        </span>
                                                    </ins>

                                                    @if($product->mrp > $product->price)
                                                        <del>
                                                            <span class="aq-product-old-price">
                                                                ₹{{ number_format($product->mrp) }}
                                                            </span>
                                                        </del>
                                                    @endif

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- product area end -->

        <section class="aqf-pastel-features-section pt-40 pb-40">
            <div class="container custom-fluid-container">
                <div class="row g-4 aqf-pastel-inner ">

                    @foreach($featureCards as $card)

                        <div class="col-lg-4 col-md-6 col-12">

                            <div class="aqf-pastel-card {{ $card->card_class }}">

                                <div class="aqf-pastel-icon-wrapper">

                                    <div class="aqf-pastel-icon">

                                        <i class="{{ $card->icon }}"></i>

                                    </div>

                                </div>

                                <div class="aqf-pastel-content">

                                    <h4 class="aqf-pastel-title">
                                        {{ $card->title }}
                                    </h4>

                                    <p class="aqf-pastel-desc">
                                        {{ $card->content }}
                                    </p>

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>
            </div>
        </section>
        <!-- collection area end -->


        <!-- deals area start -->
        <section>
            <div class="aqf-deals-area  ">
                <div class="aqf-deals-wrap py-3" data-bg-color="rgb(255 246 246 / 43%)">
                    <div class="container custom-fluid-container">
                        <div class="row">
                            <div class="col-xl-5 col-lg-6">
                                @foreach($dealBanners as $index => $banner)
                                    <div class="aqf-deals-banner-wrap p-relative mr-30">
                                        <div class="aqf-deals-banner-thumb">
                                            <img class="w-100 d-none d-md-block" src="{{ asset('storage/' . $banner->image) }}"
                                                alt="{{ $banner->title }}">
                                            <img class="w-100 d-md-none" src="{{ asset('storage/' . $banner->image) }}"
                                                alt="{{ $banner->title }}">
                                        </div>
                                        <div class="aqf-deals-banner-content">
                                            <h4 class="aq-section-title fs-44 aq-text-white mb-20">
                                                {!! $banner->title !!}

                                                <span>
                                                    {!! $banner->highlight_text !!}
                                                </span>

                                            </h4>
                                            <span> {{ $banner->offer_text }}</span>
                                        </div>
                                        <div class="aqf-deals-banner-btn">
                                            <a class="aq-btn-black blur-bg w-100 text-center" href="{{ $banner->button_link }}">
                                                {{ $banner->button_text }}</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="col-xl-7 col-lg-6">
                                <div class="aqf-deals-slider-main pt-60 pb-40">
                                    <div class="aqf-deals-slider-top mb-15">
                                        <div class="row">
                                            <div class="col-xl-8 col-lg-8 col-md-8">
                                                <div class="aq-product-3-top-right mb-15">
                                                    <div class="aqf-deals-countbox d-flex align-items-center">
                                                        <div class="aqf-deals-tag-premium">
                                                            Special Discount & Deals
                                                        </div>
                                                        <div class="aqf-deals-subtitle-premium ml-25">
                                                            Best Seller
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-4">
                                                <div
                                                    class="aqf-deals-slider-arrow d-flex justify-content-start justify-content-md-end align-items-center mb-15 mr-60">
                                                    <button class="aqf-deals-prev">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                            viewBox="0 0 14 14" fill="none">
                                                            <path
                                                                d="M12.75 6.75H0.75M0.75 6.75L6.75 0.75M0.75 6.75L6.75 12.75"
                                                                stroke="currentcolor" stroke-width="1.5"
                                                                stroke-linecap="round" stroke-linejoin="round"></path>
                                                        </svg>
                                                    </button>
                                                    <span class="aqf-arrow-border"></span>
                                                    <button class="aqf-deals-next">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                            viewBox="0 0 14 14" fill="none">
                                                            <path
                                                                d="M0.75 6.75H12.75M12.75 6.75L6.75 0.75M12.75 6.75L6.75 12.75"
                                                                stroke="currentcolor" stroke-width="1.5"
                                                                stroke-linecap="round" stroke-linejoin="round"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="aqf-deals-slider-wrap fix">
                                        <div class="swiper aqf-deals-slider-active">
                                            <div class="swiper-wrapper">
                                               @foreach($saleProducts as $product)

                                                    <div class="swiper-slide">
                                                        <div class="aq-product-item aq-product-main " data-lazy="true">

                                                            @php
                                                                $availableStock = $product->variants->where('type', 'stock')->count()
                                                                    ? $product->variants->where('type', 'stock')->sum('stock')
                                                                    : $product->stock;
                                                            @endphp

                                                            <div class="aq-product-thumb aq-img-hover-wrap p-relative mb-10">
                                                                @if($product->discount > 0)
                                                                    <div class="aq-product-badge">

                                                                        @if($product->discount_type == 'percentage')
                                                                            <span class="clr-sale">
                                                                                {{ $product->discount }}%
                                                                            </span>
                                                                        @else
                                                                            <span class="clr-sale">
                                                                                ₹{{ number_format($product->discount) }} OFF
                                                                            </span>
                                                                        @endif

                                                                    </div>
                                                                @endif
                                                                <div class="aq-product-action">
                                                                    @if($availableStock >= $product->min_qty)
                                                                        <button type="button"
                                                                            onclick="addToCart({{ $product->id }}, {{ $product->min_qty }}, this)"
                                                                            class="aq-product-action-btn aq-tooltip">

                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="18"
                                                                                height="18" viewBox="0 0 18 18" fill="none">
                                                                                <path
                                                                                    d="M6.19751 0.75L3.30151 3.654M11.3015 0.75L14.1975 3.654M6.95776 10.3501V13.1901M10.6375 10.3501V13.1901M1.94997 7.14993L3.07797 14.0619C3.33397 15.6139 3.94997 16.7499 6.23796 16.7499H11.062C13.55 16.7499 13.918 15.6619 14.206 14.1579L15.55 7.14993M0.75 5.42996C0.75 3.94996 1.542 3.82996 2.526 3.82996H14.974C15.958 3.82996 16.75 3.94996 16.75 5.42996C16.75 7.14996 15.958 7.02996 14.974 7.02996H2.526C1.542 7.02996 0.75 7.14996 0.75 5.42996Z"
                                                                                    stroke="currentcolor" stroke-width="1.5"
                                                                                    stroke-linecap="round">
                                                                                </path>
                                                                            </svg>

                                                                            <span class="aq-tooltip-item">Add to Cart</span>
                                                                        </button>
                                                                    @else
                                                                        <button type="button" disabled
                                                                            class="aq-product-action-btn aq-tooltip"
                                                                            style="opacity:.6;cursor:not-allowed">

                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="18"
                                                                                height="18" viewBox="0 0 18 18" fill="none">
                                                                                <path
                                                                                    d="M6.19751 0.75L3.30151 3.654M11.3015 0.75L14.1975 3.654M6.95776 10.3501V13.1901M10.6375 10.3501V13.1901M1.94997 7.14993L3.07797 14.0619C3.33397 15.6139 3.94997 16.7499 6.23796 16.7499H11.062C13.55 16.7499 13.918 15.6619 14.206 14.1579L15.55 7.14993M0.75 5.42996C0.75 3.94996 1.542 3.82996 2.526 3.82996H14.974C15.958 3.82996 16.75 3.94996 16.75 5.42996C16.75 7.14996 15.958 7.02996 14.974 7.02996H2.526C1.542 7.02996 0.75 7.14996 0.75 5.42996Z"
                                                                                    stroke="currentcolor" stroke-width="1.5"
                                                                                    stroke-linecap="round">
                                                                                </path>
                                                                            </svg>

                                                                            <span class="aq-tooltip-item">Sold Out</span>
                                                                        </button>
                                                                    @endif
                                                                    <button type="button"
                                                                        class="aq-product-action-btn aq-tooltip"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#producQuickViewModal">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="19"
                                                                            height="16" viewBox="0 0 19 16" fill="none">
                                                                            <path
                                                                                d="M12.0557 7.75429C12.0557 9.42922 10.7022 10.7827 9.0273 10.7827C7.35238 10.7827 5.99891 9.42922 5.99891 7.75429C5.99891 6.07937 7.35238 4.72589 9.0273 4.72589C10.7022 4.72589 12.0557 6.07937 12.0557 7.75429Z"
                                                                                stroke="currentcolor" stroke-width="1.5"
                                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                            </path>
                                                                            <path
                                                                                d="M9.02734 14.75C12.0134 14.75 14.7965 12.9905 16.7337 9.94517C17.495 8.75242 17.495 6.74758 16.7337 5.55483C14.7965 2.50952 12.0134 0.75 9.02734 0.75C6.04124 0.75 3.25816 2.50952 1.321 5.55483C0.559668 6.74758 0.559668 8.75242 1.321 9.94517C3.25816 12.9905 6.04124 14.75 9.02734 14.75Z"
                                                                                stroke="currentcolor" stroke-width="1.5"
                                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                            </path>
                                                                        </svg>
                                                                        <span class="aq-tooltip-item">Quick View</span>
                                                                    </button>
                                                                    <button type="button"
                                                                        onclick="addToWishlist({{ $product->id }})"
                                                                        class="aq-product-action-btn aq-wishlist-btn aq-tooltip {{ in_array($product->id, $wishlistIds ?? []) ? 'wishlist-active' : '' }}">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="18"
                                                                            height="16" viewBox="0 0 18 16" fill="none">
                                                                            <path
                                                                                d="M14.7197 1.52347C12.5744 0.244089 10.7019 0.759666 9.57712 1.58092C9.11591 1.91766 8.88531 2.08602 8.74963 2.08602C8.61396 2.08602 8.38336 1.91766 7.92215 1.58092C6.79733 0.759666 4.9249 0.244089 2.77958 1.52347C-0.0359114 3.20253 -0.67299 8.7418 5.82126 13.4151C7.05821 14.3052 7.67668 14.7502 8.74963 14.7502C9.82258 14.7502 10.4411 14.3052 11.678 13.4151C18.1723 8.7418 17.5352 3.20253 14.7197 1.52347Z"
                                                                                stroke="currentcolor" stroke-width="1.5"
                                                                                stroke-linecap="round"></path>
                                                                        </svg>
                                                                        <span class="aq-tooltip-item">Add To Wishlist</span>
                                                                    </button>

                                                                </div>
                                                                <a href="{{ route('product.details', $product->slug) }}">

                                                                    <img class="lazyload aq-product-img"
                                                                        src="{{ asset($product->display_image) }}"
                                                                        alt="{{ $product->name }}" />

                                                                    <img class="aq-img-hover lazyload"
                                                                        src="{{ asset($product->display_image) }}"
                                                                        alt="{{ $product->name }}" />

                                                                </a>
                                                            </div>
                                                            <div class="aq-product-content">

                                                                <h4 class="aq-product-title mb-10">
                                                                    <a href="{{ route('product.details', $product->slug) }}">
                                                                        {{ $product->name }}
                                                                    </a>
                                                                </h4>
                                                                @if($availableStock >= $product->min_qty)
                                                                <div class="aq-product-price">
                                                                    <ins>
                                                                        <span class="aq-product-new-price">
                                                                            ₹{{ number_format($product->price, 2) }}
                                                                        </span>
                                                                    </ins>
                                                                    @if($product->mrp > $product->price)
                                                                        <del>
                                                                            <span class="aq-product-old-price">
                                                                                ₹{{ number_format($product->mrp, 2) }}
                                                                            </span>
                                                                        </del>
                                                                    @endif
                                                                </div>
                                                                @endif

                                                            </div>
                                                        </div>
                                                    </div>

                                                @endforeach

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- deals area end -->








        <!--  <section class="hero-section2 ">
                            <div class="position-relative">

                                <div class="aqf-floating-shape aqf-floating-shape-1">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <polyline points="20 12 20 22 4 22 4 12"></polyline>
                                        <rect x="2" y="7" width="20" height="5"></rect>
                                        <line x1="12" y1="22" x2="12" y2="7"></line>
                                        <path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"></path>
                                        <path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"></path>
                                    </svg>
                                </div>
                                <div class="aqf-floating-shape aqf-floating-shape-2">
                                    <svg viewBox="0 0 100 100" fill="currentColor">
                                        <path d="M50 0 L60 40 L100 50 L60 60 L50 100 L40 60 L0 50 L40 40 Z" />
                                    </svg>
                                </div>

                                <div class="container custom-fluid-container">
                                    <div class="row justify-content-center pt-20 pb-20">
                                        <div class="col-xl-12">


                                            <div class="aq-creative-title-box">
                                                <span class="aq-creative-subtitle">Elegant Attire for Every Celebration</span>
                                                <h4 class="aq-creative-title">Elegant Attire for Every Celebration</h4>
                                                <div class="aq-creative-title-line"></div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="row g-3 pt-md-5 ">
                                        <div class="col-lg-8 ">
                                            <div class="hero-slider-wrap">
                                                <div class="hero-slider swiper hero-slider-active">
                                                    <div class="swiper-wrapper">

                                                        @foreach($heroSlides as $slide)

                                                            <div class="hero-single swiper-slide">

                                                                <div class="container custom-fluid-container">

                                                                    <div class="row align-items-center">

                                                                        <div class="col-md-12 col-lg-7">

                                                                            <div class="hero-content">

                                                                                <h6 class="hero-sub-title">
                                                                                    {{ $slide->subtitle }}
                                                                                </h6>

                                                                                <h1 class="hero-title">
                                                                                    {!! $slide->title  !!}
                                                                                </h1>

                                                                                <p>
                                                                                    {{ $slide->description }}
                                                                                </p>

                                                                                @if($slide->button_text)

                                                                                    <div class="hero-btn">

                                                                                        <a href="{{ $slide->button_link }}" class="aq-btn-black">

                                                                                            {{ $slide->button_text }}

                                                                                            <i class="fas fa-arrow-right"></i>

                                                                                        </a>

                                                                                    </div>

                                                                                @endif

                                                                            </div>

                                                                        </div>

                                                                        <div class="col-md-12 col-lg-5">

                                                                            <div class="hero-right">

                                                                                <div class="hero-img">

                                                                                    <img src="{{ asset('storage/' . $slide->image) }}"
                                                                                        alt="{{ $slide->title }}" loading="lazy" />

                                                                                </div>

                                                                            </div>

                                                                        </div>

                                                                    </div>

                                                                </div>

                                                            </div>

                                                        @endforeach

                                                    </div>
                                                    <!-- Swiper Pagination/Navigation -->
        <!--       <div class="swiper-pagination"></div>
                                                    <div class="swiper-button-prev hero-slider-prev"></div>
                                                    <div class="swiper-button-next hero-slider-next"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="small-banner">
                                                <div class="container custom-fluid-container">
                                                    <div class="row">

                                                        @foreach($heroBanners as $banner)

                                                            <div class="col-md-6 col-lg-12 px-lg-0">

                                                                <div class="banner-item">

                                                                    <img src="{{ asset('storage/' . $banner->image) }}"
                                                                        alt="{{ $banner->title }}" loading="lazy" />

                                                                    <div class="banner-content">

                                                                        <p>
                                                                            {{ $banner->small_text }}
                                                                        </p>

                                                                        <h3>
                                                                            {!!  $banner->title !!}
                                                                        </h3>

                                                                        <a href="{{ $banner->button_link }}">
                                                                            {{ $banner->button_text }}
                                                                        </a>

                                                                    </div>

                                                                </div>

                                                            </div>

                                                        @endforeach

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section> -->




        <section>
            <div class="aq-luxury-tabs-section pt-20 pb-20 p-relative">
                <!-- Floating Shapes -->
                <div class="aq-luxury-shape luxury-shape-1 d-none d-xl-block">
                    <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                        <path fill="#C5A059" opacity="0.1"
                            d="M44.7,-76.4C58.3,-69.2,69.8,-57.4,77.3,-43.8C84.8,-30.2,88.3,-15.1,87.4,-0.5C86.5,14,81.1,28.1,72.9,40.3C64.6,52.5,53.5,62.8,40.8,70.5C28.1,78.2,14,83.3,-0.6,84.4C-15.3,85.4,-30.6,82.4,-44,75.1C-57.4,67.8,-68.9,56.3,-76.3,42.7C-83.6,29.1,-86.8,14.6,-87.3,-0.3C-87.8,-15.2,-85.7,-30.3,-78.6,-43.7C-71.5,-57.1,-59.4,-68.8,-45.5,-75.8C-31.5,-82.8,-15.8,-85.1,-0.1,-84.9C15.5,-84.7,31.1,-83.6,44.7,-76.4Z"
                            transform="translate(100 100)" />
                    </svg>
                </div>

                <div class="container custom-fluid-container">
                    <div class="row justify-content-center">
                        <div class="col-xl-12">
                            <div class="aq-creative-title-box">
                                <span class="aq-creative-subtitle">Exquisite Selection</span>
                                <h4 class="aq-creative-title">Premium Collection</h4>
                                <div class="aq-creative-title-line"></div>
                            </div>
                        </div>
                    </div>

                    <div class="aq-luxury-tabs-wrapper">
                        <div class="row align-items-center">
                            <div class="col-xl-3 col-lg-3 col-md-12">
                                <div class="aq-luxury-tab-nav nav flex-column nav-pills" id="luxury-tabs" role="tablist"
                                    aria-orientation="vertical">

                                    @foreach($featuredCategories as $index => $category)
<button class="aq-luxury-tab-card {{ $index == 0 ? 'active' : '' }}"
                                            id="tab-{{ $category->id }}-tab" data-bs-toggle="pill"
                                            data-bs-target="#tab-{{ $category->id }}" type="button" role="tab"
                                            aria-controls="tab-executive" aria-selected="true"
                                            data-slug="{{ $category->slug }}"
                                            data-name="{{ $category->name }}">

                                            <span class="aq-luxury-tab-title">
                                                {{ $category->name }}
                                            </span>

                                            <span class="aq-luxury-tab-price">

                                                @if($category->min_price && $category->max_price)

                                                    ₹{{ number_format($category->min_price) }}

                                                    @if($category->min_price != $category->max_price)
                                                        - ₹{{ number_format($category->max_price) }}
                                                    @endif

                                                @else
                                                    Price on Request
                                                @endif

                                            </span>

                                            <div class="aq-luxury-tab-line"></div>

                                        </button>

                                    @endforeach


                                </div>
                            </div>

                            <div class="col-xl-9 col-lg-9 col-md-12">
                                <div class="tab-content aq-luxury-tab-content" id="luxury-tabsContent">

                                    @foreach($featuredCategories as $index => $category)

                                        <!-- Pane 1 -->
                                        <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}"
                                            id="tab-{{ $category->id }}" role="tabpanel" aria-labelledby="tab-executive-tab">
                                            <div class="aq-luxury-showcase">
                                                <div class="row g-4">

                                                    @foreach($category->products->take(6) as $product)
                                                        <div class="col-lg-4 col-md-6">
                                                            <div class="aq-luxury-item-card">
                                                                <div class="aq-luxury-item-img">
                                                                    <img src="{{ asset($product->display_image) }}"
                                                                        alt="{{ $product->name }}">
                                                                </div>
                                                                <div class="aq-luxury-item-info">
                                                                    <h4 class="aq-luxury-item-title">
                                                                        {{ $product->name }}
                                                                    </h4>

                                                                    <span class="aq-luxury-item-price">
                                                                        ₹{{ number_format($product->price) }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach

                                                </div>

                                            </div>


                                        </div>

                                    @endforeach


                                </div>
                            </div>
                        </div>

                       <div class="mt-40 text-center ">
                            <a href="{{ route('products.listing', $featuredCategories->first()->slug) }}" class="aq-btn-luxury" id="luxuryExploreBtn">
                                Explore {{ $featuredCategories->first()->name }}
                                <i class="fa-solid fa-arrow-right-long ml-10"></i>
                            </a>
                        </div>
                    </div>
                </div>
        </section>



        <!-- saller area start -->
        <section>
            <div class="aqf-seller-area  fix pt-20 pb-20 ">
                <div class="container custom-fluid-container">
                    <div class="row justify-content-center">
                        <div class="col-xl-12">
                            <div class="aq-creative-title-box text-center">
                                <span class="aq-creative-subtitle">Premium Chikankari Solutions</span>
                                <h4 class="aq-creative-title">Exquisite Hand-Embroidered Kurta Sets & Trousseau</h4>
                                <p class="aq-creative-desc mx-auto"
                                    style="max-width: 700px; color: #666; margin-top: 15px;">Elevate your timeless
                                    wardrobe
                                    with our authentic handcrafted apparel. From elegant Kurta Sets to luxurious
                                    Anarkalis, we offer traditional outfits that leave a lasting
                                    impression on every occasion.</p>
                                <div class="aq-creative-title-line mx-auto"></div>
                            </div>
                        </div>
                    </div>
                    <div class="aq-product-slide-wrap p-relative">
                        <div class="aq-product-arrow">
                            <button class="aq-product-prev">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="7" height="12" viewBox="0 0 7 12"
                                        fill="none">
                                        <path d="M5.75 10.75L0.75 5.75L5.75 0.75" stroke="currentcolor" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </span>
                            </button>
                            <button class="aq-product-next">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="7" height="12" viewBox="0 0 7 12"
                                        fill="none">
                                        <path d="M0.75 10.75L5.75 5.75L0.75 0.75" stroke="currentcolor" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </span>
                            </button>
                        </div>
                        <div class="swiper aq-product-active">
                            <div class="swiper-wrapper">

                                @foreach($exclusiveCollections as $product)

                                    <div class="swiper-slide">
                                        <div class="aq-product-item aq-product-main mb-20" data-lazy="true">
                                            <div class="aq-product-thumb aq-img-hover-wrap p-relative mb-10">
                                                @if($product->discount > 0)
                                                    <div class="aq-product-badge">

                                                        @if($product->discount_type == 'percentage')
                                                            <span class="clr-sale">
                                                                -{{ $product->discount }}%
                                                            </span>
                                                        @else
                                                            <span class="clr-sale">
                                                                ₹{{ number_format($product->discount) }} OFF
                                                            </span>
                                                        @endif

                                                    </div>
                                                @endif
                                                <div class="aq-product-action">
                                                    <button type="button" class="aq-product-action-btn aq-tooltip"
                                                        data-bs-toggle="modal" data-bs-target="#producQuickViewModal"
                                                        onclick="loadQuickView({{ $product->id }})">
                                                        <i class="fa-regular fa-eye"></i>
                                                        <span class="aq-tooltip-item">Quick View</span>
                                                    </button>
                                                    <button type="button" onclick="addToWishlist({{ $product->id }})"
                                                        class="aq-product-action-btn aq-wishlist-btn aq-tooltip {{ in_array($product->id, $wishlistIds ?? []) ? 'wishlist-active' : '' }}">
                                                        <i class="fa-regular fa-heart"></i>
                                                        <span class="aq-tooltip-item">Add To Wishlist</span>
                                                    </button>
                                                </div>
                                                <a href="{{ route('product.details', $product->slug) }}">

                                                    <img class="lazyload aq-product-img"
                                                        src="{{ asset($product->display_image) }}" alt="{{ $product->name }}" />

                                                    <img class="aq-img-hover lazyload"
                                                        src="{{ asset($product->display_image) }}" alt="{{ $product->name }}" />

                                                </a>
                                            </div>
                                            <div class="aq-product-content">
                                                <h4 class="aq-product-title mb-10">
                                                    <a href="{{ route('product.details', $product->slug) }}">
                                                        {{ $product->name }}
                                                    </a>
                                                </h4>

                                                <div class="aq-product-price">

                                                    <ins>
                                                        <span class="aq-product-new-price">
                                                            ₹{{ number_format($product->price) }}
                                                        </span>
                                                    </ins>

                                                    @if($product->mrp > $product->price)
                                                        <del>
                                                            <span class="aq-product-old-price">
                                                                ₹{{ number_format($product->mrp) }}
                                                            </span>
                                                        </del>
                                                    @endif

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- saller area end -->




        <!-- summer area end -->
        <section class="">
            <div class="aqf-summer-suit-area p-relative pt-20 pb-20">
                <div class="aqf-floating-shape aqf-floating-shape-1">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                        stroke-linejoin="round">
                        <polyline points="20 12 20 22 4 22 4 12"></polyline>
                        <rect x="2" y="7" width="20" height="5"></rect>
                        <line x1="12" y1="22" x2="12" y2="7"></line>
                        <path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"></path>
                        <path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"></path>
                    </svg>
                </div>
                <div class="aqf-floating-shape aqf-floating-shape-2">
                    <svg viewBox="0 0 100 100" fill="currentColor">
                        <path d="M50 0 L60 40 L100 50 L60 60 L50 100 L40 60 L0 50 L40 40 Z" />
                    </svg>
                </div>
                <div class="container custom-fluid-container">
                    <div class="aqf-summer-wrap" data-bg-color="#FAFAFA">
                        <div class="row align-items-center">
                            <div class="col-xl-5 col-lg-7 d-none d-lg-block">
                                <div class="aqf-summer-suit-img">
                                    @if($brandSection && $brandSection->main_image)

                                        <img src="{{ asset('storage/' . $brandSection->main_image) }}"
                                            alt="{{ $brandSection->title }}" />

                                    @endif
                                </div>
                            </div>
                            <div class="col-xl-7 col-lg-5">
                                <div class="aqf-summer-slider-wrap pl-35">
                                    <div class="row align-items-center">
                                        <div class="col-xl-7">
                                            <div class="aqf-summer-title-wrap">
                                                <span class="aq-section-subtitle mb-15">
                                                    {{ $brandSection->subtitle }}</span>
                                                <h3 class="aq-section-title ff-satoshi-med fs-60">
                                                    {!! $brandSection->title  !!}
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="col-xl-5">
                                            <div class="aqf-summer-slider text-center mb-50">
                                                <div class="swiper aqf-summer-active">
                                                    <div class="swiper-wrapper">

                                                        @foreach($brandSection->images as $image)

                                                            <div class="swiper-slide">

                                                                <div class="aqf-summer-slider-item">

                                                                    <img class="w-100"
                                                                        src="{{ asset('storage/' . $image->image) }}" alt="" />

                                                                </div>

                                                            </div>

                                                        @endforeach

                                                    </div>
                                                    <div
                                                        class="aqf-summer-slider-arrow d-flex justify-content-center align-items-center mt-20">
                                                        <button class="aqf-summer-prev">
                                                            <i class="fa-solid fa-arrow-left"></i>
                                                        </button>
                                                        <span class="aqf-arrow-border"></span>
                                                        <button class="aqf-summer-next">
                                                            <i class="fa-solid fa-arrow-right"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <div class="aqf-summer-slider-content mb-60">
                                                <p>
                                                    {!! $brandSection->description !!}
                                                </p>

                                                @if($brandSection->button_text)

                                                    <div class="aqf-summer-btn">

                                                        <a href="{{ $brandSection->button_link }}" class="aq-btn-black">

                                                            {{ $brandSection->button_text }}

                                                            <i class="fa-solid fa-arrow-right-long ml-10"></i>

                                                        </a>

                                                    </div>

                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- summer area end -->



        <!-- reels area start -->
        <!--   <section>
                            <div class="aqf-reels-area fix pb-md-50 ">
                                <div class="container custom-fluid-container">
                                    <div class="aqf-collection-top mb-40">
                                        <div class="row align-items-end">
                                            <div class="col-md-12">



                                                <div class="aq-creative-title-box">
                                                    <span class="aq-creative-subtitle">Video Showcase</span>
                                                    <h4 class="aq-creative-title">Gift Inspiration Reels</h4>
                                                    <div class="aq-creative-title-line"></div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                    <div class="aqf-reels-slider-wrap">
                                        <div class="swiper aqf-reels-active">
                                            <div class="swiper-wrapper">
                                                @foreach($reels as $reel)

                                                                        <div class="swiper-slide">
                                                                            <div class="aqf-reel-item p-relative">

                                                                                <div class="aqf-reel-video">

                                                                                    @if($reel->reel_file)

                                                                                        <video autoplay muted loop playsinline preload="none">
                                                                                            <source src="{{ asset('storage/' . $reel->reel_file) }}" type="video/mp4">
                                                                                        </video>


                                                                                    @elseif($reel->reel_url)

                                                                                        <video autoplay muted loop playsinline preload="none">
                                                                                            <source src="{{ $reel->reel_url }}" type="video/mp4">
                                                                                        </video>

                                                                                    @endif

                                                                                </div>

                                                                                <div class="aqf-reel-content-wrap">

                                                                                    <div class="aqf-reel-profile">

                                                                                        <img src="{{ $reel->photo
                                                    ? asset('storage/' . $reel->photo)
                                                    : asset('assets/img/default-user.png') }}" alt="{{ $reel->name }}" />

                                                                                        <h4 class="aqf-reel-title">
                                                                                            {{ $reel->name }}
                                                                                        </h4>

                                                                                    </div>

                                                                                </div>

                                                                            </div>
                                                                        </div>

                                                @endforeach

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </section>
                        <!-- reels area end -->



        <!--   <section>
                            <div class="masonry-main-section p-relative pt-20 pb-20">
                                <!-- Floating Star Shapes -->
        <!--      <div class="aq-star-shape star-1 d-none d-xl-block">
                                    <svg viewBox="0 0 100 100" fill="#C5A059">
                                        <path d="M50 0 L60 40 L100 50 L60 60 L50 100 L40 60 L0 50 L40 40 Z"></path>
                                    </svg>
                                </div>
                                <div class="aq-star-shape star-2 d-none d-xl-block">
                                    <svg viewBox="0 0 100 100" fill="#800000">
                                        <path d="M50 0 L60 40 L100 50 L60 60 L50 100 L40 60 L0 50 L40 40 Z"></path>
                                    </svg>
                                </div>
                                <div class="aq-star-shape star-3 d-none d-xl-block">
                                    <svg viewBox="0 0 100 100" fill="#C5A059">
                                        <path d="M50 0 L60 40 L100 50 L60 60 L50 100 L40 60 L0 50 L40 40 Z"></path>
                                    </svg>
                                </div>
                                <div class="aq-star-shape star-4 d-none d-xl-block">
                                    <svg viewBox="0 0 100 100" fill="#800000">
                                        <path d="M50 0 L60 40 L100 50 L60 60 L50 100 L40 60 L0 50 L40 40 Z"></path>
                                    </svg>
                                </div>
                                <div class="aq-star-shape star-5 d-none d-xl-block">
                                    <svg viewBox="0 0 100 100" fill="#C5A059">
                                        <path d="M50 0 L60 40 L100 50 L60 60 L50 100 L40 60 L0 50 L40 40 Z"></path>
                                    </svg>
                                </div>


                                <div class="container custom-fluid-container">


                                    <div class="row justify-content-center">
                                        <div class="col-xl-12">

                                            <div class="aq-creative-title-box pt-30">
                                                <span class="aq-creative-subtitle">Curated Portfolio</span>
                                                <h4 class="aq-creative-title">Our Luxury Instagram Gallery</h4>
                                                <div class="aq-creative-title-line"></div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="row g-4 masonry-wrapper">

                                        <!-- COLUMN 1 -->
        <!--   <div class="col-lg-4 col-md-6">
                                            <div class="masonry-column">
                                                <div class="masonry-track direction-down">

                                                    @foreach($galleryColumn1 as $image)

                                                        <div class="masonry-card {{ $image->height_class }}">
                                                            <img src="{{ asset('storage/' . $image->image) }}" alt="{{ $image->title }}" />
                                                        </div>

                                                    @endforeach

                                                </div>
                                            </div>
                                        </div>

                                        <!-- COLUMN 2 -->
        <!--    <div class="col-lg-4 col-md-6">
                                            <div class="masonry-column">
                                                <div class="masonry-track direction-up">

                                                    @foreach($galleryColumn2 as $image)

                                                        <div class="masonry-card {{ $image->height_class }}">
                                                            <img src="{{ asset('storage/' . $image->image) }}" alt="{{ $image->title }}"
                                                                loading="lazy" />
                                                        </div>

                                                    @endforeach

                                                </div>
                                            </div>
                                        </div>


                                        <!-- COLUMN 3 -->
        <!--    <div class="col-lg-4 col-md-12">
                                            <div class="masonry-column">
                                                <div class="masonry-track direction-down">

                                                    @foreach($galleryColumn3 as $image)

                                                        <div class="masonry-card {{ $image->height_class }}">
                                                            <img src="{{ asset('storage/' . $image->image) }}" alt="{{ $image->title }}"
                                                                loading="lazy" />
                                                        </div>

                                                    @endforeach

                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>

                        </section> -->



        <!-- testimonial area start -->
        <section>
            <div class="aqf-testimonial-area-creative fix pt-20 pb-20">
                <div class="container custom-fluid-container">
                    <div class="row justify-content-center">
                        <div class="aq-creative-title-box">
                            <span class="aq-creative-subtitle">Client Testimonials</span>
                            <h2 class="aq-creative-title">The Voice of Excellence</h2>
                            <div class="aq-creative-title-line"></div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-xl-12">
                            <div class="aqf-testimonial-slider p-relative">
                                <div class="aqf-testimonial-arrow">
                                    <button class="aqf-testimonial-prev">
                                        <i class="fa-regular fa-chevron-left"></i>
                                    </button>
                                    <button class="aqf-testimonial-next">
                                        <i class="fa-regular fa-chevron-right"></i>
                                    </button>
                                </div>
                                <div class="swiper aqf-testimonial-active">
                                    <div class="swiper-wrapper">
                                        @foreach($testimonials as $testimonial)

                                                                        <div class="swiper-slide">
                                                                            <div class="aqf-testimonial-card-creative">
                                                                                <div class="aqf-testimonial-image-creative">
                                                                                    <img src="{{ $testimonial->photo
                                            ? asset('storage/' . $testimonial->photo)
                                            : asset('assets/img/no-image.png') }}" alt="{{ $testimonial->name }}">
                                                                                </div>
                                                                                <div class="aqf-testimonial-content-creative">
                                                                                    <div class="aqf-testimonial-quote-v2">
                                                                                        <i class="fa-solid fa-quote-left"></i>
                                                                                    </div>
                                                                                    <div class="aqf-testimonial-text-v2">
                                                                                        <p>
                                                                                            "{{ $testimonial->feedback }}"
                                                                                        </p>
                                                                                    </div>
                                                                                    <div class="aqf-testimonial-author-v2">
                                                                                        <h4>{{ $testimonial->name }}</h4>

                                                                                        @if($testimonial->rating)
                                                                                            <span>
                                                                                                ⭐ {{ $testimonial->rating }}/5
                                                                                            </span>
                                                                                        @endif
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                        @endforeach
                                    </div>
                                    <!-- Pagination -->
                                    <div class="aqf-testimonial-dot text-center"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- trust area start -->

                    <!-- trust area end -->
                </div>
            </div>
            </div>
        </section>
        <!-- trust area end -->




        <!-- customer experience area start -->
        <section class="aqf-why-us-section" style="background-color: var(--aq-color-pink-light); ">
            <div class="aqf-why-us-accent-bar" style="background-color: var(--aq-color-gold);"></div>
            <div class="container custom-fluid-container">
                <!-- Header -->
                <div class="aqf-why-us-header text-center mb-60">
                    <h2 class="aqf-why-us-title"
                        style="font-family: var(--aq-ff-heading);  color: var(--aq-color-black); font-weight: 600;">
                        {!!  $why->heading !!}
                    </h2>
                    <div class="aqf-why-us-subtitle-wrap d-flex justify-content-center align-items-center gap-3 mt-15">
                        <p class="aqf-why-us-subtitle"
                            style="font-family: var(--aq-ff-body); font-size: 16px; color: #7A6960; margin: 0;">
                            {{ $why->sub_heading ?? '' }}
                        </p>
                    </div>
                </div>

                <!-- Feature Cards -->
                <div class="row g-4 aqf-why-us-cards">

                    @foreach($whyCards as $index => $card)

                        <div class="col-xl-4 col-md-4 col-12">

                            <div class="aqf-why-card"
                                style="background: #fff; padding: 40px 30px; border-radius: 8px; border: 1px solid var(--aq-color-cream-dark); transition: all 0.3s ease;">

                                <div class="aqf-why-card-number"
                                    style="font-family: var(--aq-ff-heading); font-size: 24px; color: var(--aq-color-gold); opacity: 0.6; margin-bottom: 15px;">

                                    {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}

                                </div>

                                <div class="aqf-why-card-icon"
                                    style="font-size: 32px; color: var(--aq-color-black); margin-bottom: 20px;">

                                    <i class="{{ $card->icon }}"></i>

                                </div>

                                <h4 class="aqf-why-card-title"
                                    style="font-family: var(--aq-ff-heading); font-size: 22px; color: var(--aq-color-black); font-weight: 600; margin-bottom: 10px;">

                                    {{ $card->title }}

                                </h4>

                                <p class="aqf-why-card-desc"
                                    style="font-family: var(--aq-ff-body); font-size: 14px; line-height: 1.6; color: #7A6960; margin: 0;">

                                    {{ $card->content }}

                                </p>

                            </div>

                        </div>

                    @endforeach

                </div>
            </div>
        </section>
        <!-- customer experience area end -->

        <!-- newsletter area start -->
        <section class="aq-newsletter-section" style="background-color: var(--aq-color-cream); padding: 80px 0;">
            <div class="container custom-fluid-container">
                <div class="row justify-content-center">
                    <div class="col-xl-10">
                        <h2 class="aq-newsletter-title">Subscribe for exclusive Chikankari updates and premium heritage
                            curations
                        </h2>
                        <p class="aq-newsletter-subtitle">Get early access to our premium collections and custom order
                            pricing guides.</p>

                        <div class="aq-newsletter-form-wrap">
                            <form action="#" class="aq-newsletter-form">
                                <div class="aq-newsletter-input-group">
                                    <i class="fa-regular fa-envelope"></i>
                                    <input type="email" class="aq-newsletter-input" placeholder="Enter your email">
                                </div>
                                <button type="submit" class="aq-newsletter-btn">Subscribe</button>
                            </form>
                            <p class="aq-newsletter-footer">You will be able to unsubscribe at any time. <br> Read our
                                Privacy Policy <a href="#">here</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- footer categories area start -->
        <section class="aq-footer-categories-section">
            <div class="container custom-fluid-container">
                <div class="aq-footer-cat-container">
                    <!-- Group 1: Recipient -->
                    <div class="aq-footer-cat-group">
                        <span class="aq-footer-cat-label">Shop Collections</span>
                        <div class="aq-footer-cat-links">
                            @foreach($menuCategories as $footerCategory)
                                <a href="{{ route('products.listing', $footerCategory->slug) }}" class="aq-footer-cat-link">
                                    {{ $footerCategory->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Group 2: Occasion -->
                    <div class="aq-footer-cat-group">
                        <span class="aq-footer-cat-label">Shop by Occasion</span>
                        <div class="aq-footer-cat-links">
                            @foreach($headerOccasions->take(10) as $occasion)
                                <a href="{{ route('occasions.listing', $occasion->slug) }}" class="aq-footer-cat-link">
                                    {{ $occasion->title }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Group 4: Price -->
                    <div class="aq-footer-cat-group">
                        <span class="aq-footer-cat-label">By Price</span>
                        <div class="aq-footer-cat-links">
                            @foreach(config('price_ranges') as $band)
                                <a href="{{ route('price.listing', $band['slug']) }}"
                                    class="aq-footer-cat-link">{{ $band['label'] }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- footer categories area end -->

        <script>

document.querySelectorAll('.aq-luxury-tab-card').forEach(function (tabBtn) {
    tabBtn.addEventListener('shown.bs.tab', function (e) {
        const slug = e.target.dataset.slug;
        const name = e.target.dataset.name;
        const exploreBtn = document.getElementById('luxuryExploreBtn');
        if (exploreBtn) {
            exploreBtn.href = "{{ url('products') }}/" + slug;
            exploreBtn.innerHTML = 'Explore ' + name + ' <i class="fa-solid fa-arrow-right-long ml-10"></i>';
        }
    });
});
            function addToCart(productId, quantity, btnEl) {

    const $btn = btnEl ? $(btnEl) : null;
    const $tooltipText = $btn ? $btn.find('.aq-tooltip-item') : null;
    const originalText = $tooltipText ? $tooltipText.text() : null;

    $.ajax({
        url: "{{ route('cart.add') }}",
        type: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            product_id: productId,
            quantity: quantity
        },
        success: function (response) {

            if (response.status) {

                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.message,
                    timer: 1500,
                    showConfirmButton: false
                });

                $('.cart-count').text(response.cart_count);
                 fireTrackingEvents(response.tracking_events); 
                refreshMiniCart(response);

                if ($tooltipText) {
                    $tooltipText.text('Added to Cart');
                    setTimeout(function () {
                        $tooltipText.text(originalText);
                    }, 1500);
                }

            } else {
                Swal.fire({ icon: 'error', title: 'Error', text: 'Unable to add product.' });
            }
        },
        error: function (xhr) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: xhr.responseJSON?.message ?? 'Something went wrong.'
            });
        }
    });
}

            function addToWishlist(productId) {

                $.ajax({
                    url: "{{ route('wishlist.add') }}",
                    type: "POST",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        product_id: productId
                    },
                    success: function (response) {

                        if (response.status) {

                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            });
fireTrackingEvents(response.tracking_events);
                            $('.wishlist-count').text(response.wishlist_count);

                        } else {

                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message ?? 'Unable to add to wishlist.'
                            });

                        }

                    },
                    error: function (xhr) {

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON?.message ?? 'Something went wrong.'
                        });

                    }
                });
            }

        </script>

        <!-- First time popup modal -->
        <div id="firstTimeModalOverlay" class="first-time-modal-overlay">
            <div class="first-time-modal">
                <button id="closeFirstTimeModal" class="close-modal-btn">&times;</button>
                <div class="first-time-modal-content">
                    <div class="modal-left-side">
                        <!-- We assume a placeholder or you can replace with correct image path -->
                        <img src="{{ asset('popup/popupimg.webp') }}"
     alt="Chikankari Arrivals"
     style="background:#e9dcc9;" />
                        <div class="modal-left-text">
                            <!--<span>Discover new</span>-->
                            <!--<h2>Chikankari</h2>-->
                            <!--<span class="arrivals-text">Arrivals</span>-->
                        </div>
                    </div>
                    <div class="modal-right-side">
                        <h3>PERKS AWAIT—JUST FOR YOU</h3>
                        <p>Enjoy 5% off on your first order when you sign up—<br>just for trying us out!</p>
                        <form id="firstTimeForm" class="first-time-form">
                            <input type="email" name="email" placeholder="Enter your email address" required>
                            <div class="phone-input-group">
                                <div class="country-code">
                                    <img src="https://flagcdn.com/w20/in.png" alt="India">
                                    <span>+91</span>
                                    <span class="dropdown-arrow">▾</span>
                                </div>
                                <input type="tel" name="phone" placeholder="Enter your phone number" required>
                            </div>
                            <label class="whatsapp-optin">
                                <input type="checkbox" name="whatsapp_optin" checked>
                                <span>Receive important information and updates on <img
                                        src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg"
                                        alt="WhatsApp" width="16" height="16"> WhatsApp</span>
                            </label>
                            <button type="submit" class="claim-now-btn">CLAIM NOW</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                // Show modal after 4 seconds every time the page loads
                setTimeout(function () {
                    var modal = document.getElementById('firstTimeModalOverlay');
                    if (modal) {
                        modal.style.display = 'flex';
                    }
                }, 4000);

                // Close modal
                var closeBtn = document.getElementById('closeFirstTimeModal');
                if (closeBtn) {
                    closeBtn.addEventListener('click', function () {
                        document.getElementById('firstTimeModalOverlay').style.display = 'none';
                    });
                }

                var modalOverlay = document.getElementById('firstTimeModalOverlay');
                if (modalOverlay) {
                    modalOverlay.addEventListener('click', function (e) {
                        if (e.target === this) {
                            this.style.display = 'none';
                        }
                    });
                }

                // Form submission
                var form = document.getElementById('firstTimeForm');
                if (form) {
                    form.addEventListener('submit', function (e) {
                        e.preventDefault();

                        var email = form.querySelector('input[name="email"]').value;
                        var phone = form.querySelector('input[name="phone"]').value;
                        var whatsappOptin = form.querySelector('input[name="whatsapp_optin"]').checked;

                        $.ajax({
                            url: "{{ route('coupon-enquiry.store') }}",
                            type: "POST",
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content'),
                                email: email,
                                phone: phone,
                                whatsapp_optin: whatsappOptin ? 1 : 0
                            },
                            success: function (response) {
                                if (response.status) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Thank You!',
                                        text: response.message,
                                        timer: 1800,
                                        showConfirmButton: false
                                    });
                                    document.getElementById('firstTimeModalOverlay').style.display = 'none';
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: response.message ?? 'Something went wrong.'
                                    });
                                }
                            },
                            error: function (xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: xhr.responseJSON?.message ?? 'Something went wrong.'
                                });
                            }
                        });
                    });
                }
            });
        </script>
@endsection