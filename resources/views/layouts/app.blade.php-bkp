<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>

    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php
    require_once app_path('Helpers/seo.php');
    $seo = getSeo();
    @endphp

    <title>
        {{ $seo->meta_title ?? $general?->site_name ?? config('app.name') }}
    </title>

    <meta name="description" content="{{ $seo->meta_description ?? $general?->tagline }}">

    @if($seo && $seo->scripts)
    {!! $seo->scripts !!}
    @endif

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="{{ $general?->favicon
    ? asset('storage/' . $general->favicon)
    : asset('favicon.ico') }}">

    <!-- CSS here -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom-animation.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome-pro.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/spacing.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom-luxury.css') }}">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap"
        rel="stylesheet" />
</head>



<body>

    <!-- pre loader area start -->
    <div id="loading">
        <div id="loading-center">
            <div id="loading-center-absolute">
                <div class="aq-preloader-content">
                    <div class="aq-preloader-logo">
                        <div class="aq-preloader-circle">
                            <svg width="190" height="190" viewBox="0 0 380 380" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <circle stroke="#D9D9D9" cx="190" cy="190" r="180" stroke-width="6"
                                    stroke-linecap="round"></circle>
                                <circle stroke="red" cx="190" cy="190" r="180" stroke-width="6" stroke-linecap="round">
                                </circle>
                            </svg>
                        </div>
                        <img src="{{ $general?->logo
    ? asset('storage/' . $general->logo)
    : asset('assets/img/corporate/Oudhyana_img/logo.png') }}" alt="{{ $general?->site_name ?? config('app.name') }}">
                    </div>
                    <!-- <h3 class="aq-preloader-title">Oudhyana</h3> -->
                    <!-- <p class="aq-preloader-subtitle">Loading..</p> -->
                </div>
            </div>
        </div>
    </div>
    <!-- pre loader area end -->

    <!-- back to top start -->
    <div class="progress-wrap">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"></path>
        </svg>
    </div>
    <!-- back to top end -->

    <!-- search area -->
    <div class="aq-search-wrap aq-search-area">
        <div class="aq-search-close">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                <path d="M12.75 0.75L0.75 12.75M0.75 0.75L12.75 12.75" stroke="currentcolor" stroke-width="1.5"
                    stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
        </div>
        <div class="aq-search-inner-wrap">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="aq-search-input p-relative mb-60">
                            <form action="{{ route('search.suggestions') }}" method="GET" autocomplete="off">
                                <div class="aq-search-input-wrap">
                                    <input type="text" class="searchInput" name="q"
                                        placeholder="Search Suites, Kurta, Ethnic wears..." />

                                    <button type="submit" class="aq-search-btn">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>

                                    <div class="searchSuggestions search-suggestions"></div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-3">
                        <div class="aq-search-cat-wrap mb-30">
                            <h4 class="aq-search-cat-title mb-35">Popular Searches</h4>
                            <div class="aq-search-cat">
                                @foreach($popularCategories as $category)
                                <a href="{{ route('products.listing', $category->slug) }}">
                                    {{ $category->name }}
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-9">
                        <div class="aq-search-product mb-30">

                            <h4 class="aq-search-cat-title mb-35">
                                Recently Viewed Products
                            </h4>

                            <div class="row row-cols-xl-4 row-cols-lg-4 row-cols-md-2 row-cols-sm-2 row-cols-1">

                                @forelse($recentProducts as $product)

                                <div class="col">
                                    <div class="aq-product-item aq-product-main mb-40" data-lazy="true">
                                        <div class="aq-product-thumb aq-img-hover-wrap p-relative mb-10">
                                            <a href="{{ route('product.details', $product->slug) }}">

                                                <img class="lazyload aq-product-img"
                                                    src="{{ asset('storage/' . $product->display_image) }}"
                                                    alt="{{ $product->name }}" loading="lazy" />

                                                <img class="aq-img-hover lazyload"
                                                    src="{{ asset('storage/' . $product->display_image) }}"
                                                    alt="{{ $product->name }}" loading="lazy" />
                                            </a>
                                        </div>
                                        <div class="aq-product-content">
                                            <span class="aqf-product-3-category">Premium Hampers</span>
                                            <h4 class="aq-product-title mb-5">
                                                <a href="{{ route('product.details', $product->slug) }}">
                                                    {{ $product->name }}</a>
                                            </h4>
                                            <div class="aq-product-price">
                                                <ins><span class="aq-product-new-price">${{
                                                        number_format($product->price, 2) }}</span></ins>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                @empty

                                <div class="col-12">
                                    <p>No recently viewed products found.</p>
                                </div>

                                @endforelse

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- search area -->

    <!-- Cartmini area -->
    <div class="aq-cartmini-area aq-cartmini-active d-flex flex-column justify-content-between">
        <div class="aq-cartmini-header">
            <i class="aq-cartmini-close aq-cartmini-close-icon fa-regular fa-xmark" role="button"
                aria-label="Close Cart" tabindex="0"></i>
            <h4 class="aq-cartmini-title">Shopping Cart</h4>
        </div>
        <div class="aq-cartmini-body">
            @include('layouts.mini-cart')
        </div>

        <div class="aq-cartmini-footer">
            <div class="aq-cartmini-total d-flex justify-content-between align-items-center">
                <span class="aq-cartmini-total-title">Subtotal</span>
                <span class="aq-cartmini-total-value" id="miniCartSubtotal">
                    ₹{{ number_format($miniCart->total_amount ?? 0, 2) }}
                </span>
            </div>
            <div class="aq-cartmini-main-btn d-flex justify-content-between">
                <a href="{{ route('cart') }}" class="aq-btn-black btn-red-bg text-center w-100">View Cart</a>
                <a href="{{ route('checkout') }}" class="aq-btn-black text-center w-100">Checkout</a>
            </div>
        </div>
    </div>
    <!-- Cartmini area -->

    <!-- wishlist popup -->
    <div class="aq-wishlist-popup-wrap aq-wishlist-popup aq-wishlist-active">
        <div class="aq-wishlist-popup-top d-flex justify-content-between align-items-center">
            <div>
                <span class="aq-wishlist-popup-name">Wishlist</span>
                <span class="aq-wishlist-popup-count">(2)</span>
            </div>
            <span class="aq-wishlist-popup-close aq-wishlist-close"><i class="fa-regular fa-xmark"></i></span>
        </div>
        <div class="aq-wishlist-popup-middle">
            <div
                class="aq-wishlist-popup-item d-flex justify-content-center justify-content-sm-between align-items-center">
                <div class="aq-wishlist-popup-thumb-wrap d-flex align-items-center">
                    <span class="aq-wishlist-popup-remove"><i class="fa-regular fa-xmark"></i></span>
                    <div class="aq-wishlist-popup-thumb  d-flex align-items-center">
                        <a href="product-details-default.html">
                            <img src="{{ asset('assets/img/corporate/nazneen_georgette_kurti.png') }}"
                                alt="Nazneen Kurti">
                        </a>
                        <div class="aq-wishlist-popup-thumb-info">
                            <h4 class="aq-wishlist-popup-title"><a href="product-details-default.html">Mosaic Vanity
                                    Bag</a></h4>
                            <span class="aq-wishlist-popup-price">₹8,500</span>
                        </div>
                    </div>
                </div>
                <div class="aq-wishlist-popup-btn">
                    <button class="aq-btn-black btn-red-bg  btn-h-40">Add to bag</button>
                </div>
            </div>
            <div
                class="aq-wishlist-popup-item d-flex justify-content-center justify-content-sm-between align-items-center">
                <div class="aq-wishlist-popup-thumb-wrap d-flex align-items-center">
                    <span class="aq-wishlist-popup-remove"><i class="fa-regular fa-xmark"></i></span>
                    <div class="aq-wishlist-popup-thumb  d-flex align-items-center">
                        <a href="product-details-default.html">
                            <img src="{{ asset('assets/img/corporate/shama_cotton_anarkali.png') }}"
                                alt="Shama Anarkali">
                        </a>
                        <div class="aq-wishlist-popup-thumb-info">
                            <h4 class="aq-wishlist-popup-title"><a href="product-details-default.html">Georgia Mini
                                    Bag</a></h4>
                            <span class="aq-wishlist-popup-price">578.00</span>
                        </div>
                    </div>
                </div>
                <div class="aq-wishlist-popup-btn">
                    <button class="aq-btn-black btn-red-bg  btn-h-40">Add to bag</button>
                </div>
            </div>
            <div
                class="aq-wishlist-popup-item d-flex justify-content-center justify-content-sm-between align-items-center">
                <div class="aq-wishlist-popup-thumb-wrap d-flex align-items-center">
                    <span class="aq-wishlist-popup-remove"><i class="fa-regular fa-xmark"></i></span>
                    <div class="aq-wishlist-popup-thumb  d-flex align-items-center">
                        <a href="product-details-default.html">
                            <img src="{{ asset('assets/img/corporate/gallery_unstitched_suit.png') }}" alt="Gift Box">
                        </a>
                        <div class="aq-wishlist-popup-thumb-info">
                            <h4 class="aq-wishlist-popup-title"><a href="product-details-default.html">Osette Backpack
                                    Bag</a></h4>
                            <span class="aq-wishlist-popup-price">578.00</span>
                        </div>
                    </div>
                </div>
                <div class="aq-wishlist-popup-btn">
                    <button class="aq-btn-black btn-red-bg  btn-h-40">Add to bag</button>
                </div>
            </div>
        </div>
        <div class="aq-wishlist-popup-bottom d-flex justify-content-between align-items-center">
            <a class="aq-line-anim" href="wishlist.html">Open wishlist page</a>
            <a class="aq-line-anim" href="product-default.html">Continue shopping</a>
        </div>
        <div class="aq-wishlist-popup-text">
            <p><b>Shama Cotton Anarkali</b> has been added to Wishlist.</p>
        </div>
    </div>
    <!-- wishlist popup -->



    <!-- Modal -->
    <div class="modal fade aq-product-modal" id="producQuickViewModal" role="dialog" tabindex="-1"
        aria-labelledby="producQuickViewModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="aq-product-modal-content">
                    <button type="button" class="aq-product-modal-close-btn" data-bs-dismiss="modal">
                        <i class="fa-regular fa-xmark"></i>
                    </button>
                </div>

                <div id="quickViewLoader" class="text-center py-5">
                    <div class="spinner-border" role="status"></div>
                </div>

                <div id="quickViewContent" class="row justify-content-center" style="display:none;">
                    <div class="col-lg-6 col-md-10">
                        <div class="aq-modal-slider-wrap">
                            <div class="swiper aq-modal-slider-active p-relative">
                                <div class="swiper-wrapper" id="qvSwiperWrapper"></div>
                                <div class="aq-modal-slider-arrow">
                                    <button class="aq-modal-prev">
                                        <span><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                                viewBox="0 0 12 12" fill="none">
                                                <path d="M10.75 5.75H0.75M0.75 5.75L5.75 10.75M0.75 5.75L5.75 0.75"
                                                    stroke="currentcolor" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                            </svg></span>
                                    </button>
                                    <button class="aq-modal-next">
                                        <span><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                                viewBox="0 0 12 12" fill="none">
                                                <path d="M0.75 5.75H10.75M10.75 5.75L5.75 0.75M10.75 5.75L5.75 10.75"
                                                    stroke="currentcolor" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                            </svg></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="aq-product-details-wrap pt-20">

                            <div class="aq-product-details-category"><span id="qvCategory"></span></div>
                            <h3 class="aq-product-details-title mb-10" id="qvTitle"></h3>

                            <div class="tp-product-details-inventory">
                                <div class="aq-product-details-rating-wrapper d-flex align-items-center">
                                    <div class="aq-product-details-rating-box d-flex align-items-center mb-10">
                                        <div class="aq-product-details-rating" id="qvStars"></div>
                                        <div class="aq-product-details-reviews">
                                            <span id="qvReviewsCount"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="aq-product-details-price-wrap mb-30">
                                <ins><span class="aq-product-details-price new-price" id="qvPrice"></span></ins>
                                <del><span class="aq-product-details-old-price" id="qvMrp"
                                        style="margin-left:10px;display:none;"></span></del>
                            </div>

                            <div id="qvVariantsWrap"></div>

                            <div class="aq-product-details-action-wrapper mb-20">
                                <div class="aq-product-details-action-item-wrapper d-sm-flex align-items-center">
                                    <div class="aq-product-details-quantity">
                                        <div class="aq-product-quantity mb-10 mr-10">
                                            <span class="aq-cart-minus" onclick="qvAdjustQty(-1)">
                                                <svg width="11" height="2" viewBox="0 0 11 2" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M1 1H10" stroke="currentColor" stroke-width="1.5"
                                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                                </svg>
                                            </span>
                                            <input class="aq-cart-input" type="text" id="qvQty" value="1"
                                                aria-label="Quantity">
                                            <span class="aq-cart-plus" onclick="qvAdjustQty(1)">
                                                <svg width="11" height="12" viewBox="0 0 11 12" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M1 6H10" stroke="currentColor" stroke-width="1.5"
                                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                                    <path d="M5.5 10.5V1.5" stroke="currentColor" stroke-width="1.5"
                                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                                </svg>
                                            </span>
                                        </div>
                                    </div>
                                    <div
                                        class="aq-product-details-add-to-cart product-btn-style-2 d-flex align-items-center mb-10 w-100">
                                        <button class="aq-product-details-add-to-cart-btn aq-btn-black radius-30 w-100"
                                            id="qvAddToCartBtn" onclick="qvAddToCart(false)">Add To Cart</button>
                                        <button type="button"
                                            class="aq-product-action-btn aq-wishlist-btn aq-tooltip-top"
                                            id="qvWishlistBtn" onclick="qvAddToWishlist()">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="16"
                                                viewBox="0 0 18 16" fill="none">
                                                <path
                                                    d="M14.7197 1.52347C12.5744 0.244089 10.7019 0.759666 9.57712 1.58092C9.11591 1.91766 8.88531 2.08602 8.74963 2.08602C8.61396 2.08602 8.38336 1.91766 7.92215 1.58092C6.79733 0.759666 4.9249 0.244089 2.77958 1.52347C-0.0359114 3.20253 -0.67299 8.7418 5.82126 13.4151C7.05821 14.3052 7.67668 14.7502 8.74963 14.7502C9.82258 14.7502 10.4411 14.3052 11.678 13.4151C18.1723 8.7418 17.5352 3.20253 14.7197 1.52347Z"
                                                    stroke="currentcolor" stroke-width="1.5" stroke-linecap="round">
                                                </path>
                                            </svg>
                                            <span class="aq-tooltip-item">Wishlist</span>
                                        </button>
                                    </div>
                                </div>
                                <button class="aq-product-details-buy-now-btn aq-btn-black btn-red-bg radius-30 w-100"
                                    id="qvBuyNowBtn" onclick="qvAddToCart(true)">Buy Now</button>
                            </div>

                            <a class="product-view-details-btn aq-line-anim" id="qvViewDetailsLink" href="#">
                                View Full Details
                                <span><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"
                                        fill="none">
                                        <path d="M0.75 5.75H10.75M10.75 5.75L5.75 0.75M10.75 5.75L5.75 10.75"
                                            stroke="currentcolor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round"></path>
                                    </svg></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->

    <!-- offcanvas area start -->
    <div class="aq-offcanvas-wrap">
        <div class="aq-offcanvas-top d-flex align-items-center justify-content-between">
            <div class="aq-offcanvas-logo">
                <a href="{{ url('/') }}">
                    <img src="{{ $general?->logo ? asset('storage/' . $general->logo) : asset('assets/img/corporate/Oudhyana_img/logo.png') }}"
                        alt="{{ $general?->site_name }}">

                    <div>
                        {{ $general?->tagline ?? "" }}
                    </div>
                </a>
            </div>
            <button type="button" class="aq-offcanvas-close " aria-label="Close Menu"
                style="cursor: pointer; z-index: 99;"
                onclick="document.querySelector('.aq-offcanvas-wrap')?.classList.remove('opened'); document.querySelector('.body-overlay')?.classList.remove('opened');">
                <i class="fal fa-times" style="font-size: 20px;font-weight:700;"></i>
            </button>
        </div>
        <div class="aq-offcanvas-menu-wrap">
            <div class="aq-offcanvas-menu">
                <nav></nav>
            </div>
        </div>
        <div class="aq-offcanvas-bottom">
            <div class="aq-offcanvas-btn-wrap d-flex justify-content-between align-items-center">
                <a class="aq-offcanvas-btn" href="{{ route('user.login') }}">Login</a>
                <a class="aq-offcanvas-btn btn-black-bg" href="{{ route('wishlist.index') }}">Wishlist</a>
            </div>

        </div>
    </div>
    <!-- offcanvas area end -->

    <!-- Body Overlay -->
    <div class="body-overlay"
        onclick="document.querySelector('.aq-offcanvas-wrap')?.classList.remove('opened'); document.querySelector('.body-overlay')?.classList.remove('opened');">
    </div>
    <!-- Body Overlay -->

    <!-- bottom-sticky header -->
    <div class="aq-bottom-menu d-md-none">
        <div class="container">
            <div class="row row-cols-5">
                <div class="col">
                    <a href="{{ route('home') }}">
                        <div class="aq-bottom-menu-item">
                            <i>
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="16" viewBox="0 0 15 16"
                                    fill="none">
                                    <path
                                        d="M14.6336 6.77452L8.38359 0.374602C8.1492 0.13474 7.83138 0 7.5 0C7.16862 0 6.8508 0.13474 6.61641 0.374602L0.366414 6.77452C0.249777 6.89307 0.157319 7.03418 0.0944167 7.18964C0.0315145 7.34511 -0.000577075 7.51183 7.85428e-06 7.68011V15.36C7.85428e-06 15.5297 0.0658559 15.6925 0.183066 15.8126C0.300276 15.9326 0.459247 16 0.625007 16H5.625C5.79076 16 5.94973 15.9326 6.06694 15.8126C6.18415 15.6925 6.25 15.5297 6.25 15.36V10.8801H8.75V15.36C8.75 15.5297 8.81585 15.6925 8.93306 15.8126C9.05027 15.9326 9.20924 16 9.375 16H14.375C14.5408 16 14.6997 15.9326 14.8169 15.8126C14.9341 15.6925 15 15.5297 15 15.36V7.68011C15.0006 7.51183 14.9685 7.34511 14.9056 7.18964C14.8427 7.03418 14.7502 6.89307 14.6336 6.77452ZM13.75 14.72H10V10.2401C10 10.0703 9.93415 9.90755 9.81694 9.78753C9.69973 9.66751 9.54076 9.60008 9.375 9.60008H5.625C5.45924 9.60008 5.30027 9.66751 5.18306 9.78753C5.06585 9.90755 5 10.0703 5 10.2401V14.72H1.25001V7.68011L7.5 1.28019L13.75 7.68011V14.72Z"
                                        fill="#343330"></path>
                                </svg>
                            </i>
                            <span>Home</span>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="{{ route('user.account.details') }}">
                        <div class="aq-bottom-menu-item">
                            <i>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="15" viewBox="0 0 16 15"
                                    fill="none">
                                    <path
                                        d="M15.9093 14.0873C14.7389 12.1146 12.9352 10.7001 10.8303 10.0295C11.8715 9.42526 12.6804 8.50449 13.1329 7.40862C13.5854 6.31276 13.6563 5.10239 13.3349 3.9634C13.0135 2.82441 12.3174 1.81978 11.3537 1.10378C10.3899 0.387776 9.2117 0 8 0C6.7883 0 5.6101 0.387776 4.64633 1.10378C3.68257 1.81978 2.98653 2.82441 2.6651 3.9634C2.34368 5.10239 2.41464 6.31276 2.8671 7.40862C3.31955 8.50449 4.12848 9.42526 5.16965 10.0295C3.06476 10.6993 1.26112 12.1138 0.0907097 14.0873C0.0477887 14.1555 0.0193195 14.2314 0.00698187 14.3106C-0.00535579 14.3897 -0.00131202 14.4704 0.0188746 14.548C0.0390612 14.6256 0.0749818 14.6984 0.124517 14.7623C0.174052 14.8261 0.236198 14.8796 0.307289 14.9196C0.37838 14.9597 0.456975 14.9854 0.538437 14.9954C0.6199 15.0053 0.702579 14.9992 0.781598 14.9775C0.860616 14.9558 0.934373 14.9189 0.998516 14.8689C1.06266 14.819 1.11589 14.757 1.15507 14.6866C2.6029 12.2472 5.16197 10.7907 8 10.7907C10.838 10.7907 13.3971 12.2472 14.8449 14.6866C14.8841 14.757 14.9373 14.819 15.0015 14.8689C15.0656 14.9189 15.1394 14.9558 15.2184 14.9775C15.2974 14.9992 15.3801 15.0053 15.4616 14.9954C15.543 14.9854 15.6216 14.9597 15.6927 14.9196C15.7638 14.8796 15.8259 14.8261 15.8755 14.7623C15.925 14.6984 15.9609 14.6256 15.9811 14.548C16.0013 14.4704 16.0054 14.3897 15.993 14.3106C15.9807 14.2314 15.9522 14.1555 15.9093 14.0873ZM3.69646 5.39639C3.69646 4.56657 3.94886 3.7554 4.42174 3.06543C4.89462 2.37547 5.56674 1.83771 6.35311 1.52015C7.13948 1.2026 8.00478 1.11951 8.83958 1.2814C9.67438 1.44329 10.4412 1.84288 11.0431 2.42965C11.6449 3.01641 12.0548 3.764 12.2208 4.57786C12.3869 5.39173 12.3017 6.23533 11.976 7.00197C11.6502 7.76862 11.0986 8.42388 10.3909 8.8849C9.6832 9.34592 8.85116 9.59199 8 9.59199C6.85901 9.5908 5.76509 9.14838 4.95829 8.36181C4.15148 7.57524 3.69768 6.50876 3.69646 5.39639Z"
                                        fill="#343330"></path>
                                </svg>
                            </i>
                            <span>Account</span>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="{{ route('categories') }}">
                        <div class="aq-bottom-menu-item">
                            <i>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="15" viewBox="0 0 16 15"
                                    fill="none">
                                    <path
                                        d="M16 5C16.0003 4.94189 15.9925 4.88403 15.9769 4.82812L14.8731 0.90625C14.7989 0.646027 14.6438 0.417159 14.431 0.253823C14.2182 0.0904875 13.959 0.00144761 13.6923 0H2.30769C2.04095 0.00144761 1.78182 0.0904875 1.56901 0.253823C1.3562 0.417159 1.20112 0.646027 1.12692 0.90625L0.0238466 4.82812C0.00795568 4.88399 -7.25706e-05 4.94185 4.94245e-07 5V6.25C4.94245e-07 6.73514 0.111216 7.21362 0.32484 7.64754C0.538463 8.08147 0.848627 8.45892 1.23077 8.75V14.375C1.23077 14.5408 1.2956 14.6997 1.41101 14.8169C1.52642 14.9342 1.68294 15 1.84615 15H14.1538C14.317 15 14.4736 14.9342 14.589 14.8169C14.7044 14.6997 14.7692 14.5408 14.7692 14.375V8.75C15.1514 8.45892 15.4615 8.08147 15.6751 7.64754C15.8888 7.21362 16 6.73514 16 6.25V5ZM2.30769 1.25H13.6923L14.5708 4.375H1.43154L2.30769 1.25ZM6.15384 5.625H9.84615V6.25C9.84615 6.74728 9.65164 7.22419 9.30542 7.57583C8.9592 7.92746 8.48963 8.125 8 8.125C7.51037 8.125 7.04079 7.92746 6.69457 7.57583C6.34835 7.22419 6.15384 6.74728 6.15384 6.25V5.625ZM4.92307 5.625V6.25C4.92296 6.57243 4.84099 6.88938 4.68507 7.17023C4.52915 7.45109 4.30455 7.68637 4.03297 7.85334C3.76139 8.02031 3.452 8.11333 3.13469 8.12342C2.81738 8.13351 2.50287 8.06033 2.22154 7.91094C2.17873 7.87709 2.13164 7.84924 2.08154 7.82812C1.82083 7.65861 1.60627 7.42524 1.4576 7.14947C1.30894 6.8737 1.23093 6.5644 1.23077 6.25V5.625H4.92307ZM13.5385 13.75H2.46154V9.3125C2.66412 9.35398 2.87026 9.37491 3.07692 9.375C3.5546 9.375 4.02572 9.26205 4.45296 9.04508C4.88021 8.82812 5.25185 8.51311 5.53846 8.125C5.82506 8.51311 6.19671 8.82812 6.62395 9.04508C7.0512 9.26205 7.52232 9.375 8 9.375C8.47767 9.375 8.94879 9.26205 9.37604 9.04508C9.80328 8.82812 10.1749 8.51311 10.4615 8.125C10.7481 8.51311 11.1198 8.82812 11.547 9.04508C11.9743 9.26205 12.4454 9.375 12.9231 9.375C13.1297 9.37491 13.3359 9.35398 13.5385 9.3125V13.75ZM13.9177 7.82812C13.8682 7.84928 13.8217 7.87686 13.7792 7.91016C13.4979 8.0597 13.1834 8.13304 12.866 8.12307C12.5487 8.11311 12.2392 8.0202 11.9675 7.85329C11.6959 7.68639 11.4712 7.45115 11.3152 7.1703C11.1591 6.88944 11.0771 6.57247 11.0769 6.25V5.625H14.7692V6.25C14.769 6.56447 14.6909 6.87382 14.542 7.1496C14.3932 7.42537 14.1785 7.6587 13.9177 7.82812Z"
                                        fill="#343330"></path>
                                </svg>
                            </i>
                            <span>Shop</span>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="{{ route('wishlist.index') }}">
                        <div class="aq-bottom-menu-item">
                            <button class="p-relative">
                                <span class="count-box">3</span>
                                <i>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="15" viewBox="0 0 18 15"
                                        fill="none">
                                        <path
                                            d="M13.0179 0C11.3585 0 9.90563 0.693914 9 1.86685C8.09437 0.693914 6.64152 0 4.98214 0C3.66125 0.00144779 2.39489 0.512355 1.46088 1.42064C0.52687 2.32892 0.00148881 3.56039 0 4.84489C0 10.3149 8.34027 14.7425 8.69545 14.9254C8.78906 14.9744 8.8937 15 9 15C9.1063 15 9.21094 14.9744 9.30455 14.9254C9.65973 14.7425 18 10.3149 18 4.84489C17.9985 3.56039 17.4731 2.32892 16.5391 1.42064C15.6051 0.512355 14.3387 0.00144779 13.0179 0ZM9 13.6595C7.53268 12.828 1.28571 9.04041 1.28571 4.84489C1.28699 3.89193 1.67684 2.97835 2.36978 2.3045C3.06272 1.63065 4.00218 1.25154 4.98214 1.25029C6.54509 1.25029 7.85732 2.05986 8.40536 3.36017C8.45379 3.47483 8.53618 3.57289 8.64206 3.64191C8.74794 3.71093 8.87253 3.74778 9 3.74778C9.12747 3.74778 9.25206 3.71093 9.35794 3.64191C9.46382 3.57289 9.54621 3.47483 9.59464 3.36017C10.1427 2.05752 11.4549 1.25029 13.0179 1.25029C13.9978 1.25154 14.9373 1.63065 15.6302 2.3045C16.3232 2.97835 16.713 3.89193 16.7143 4.84489C16.7143 9.03416 10.4657 12.8272 9 13.6595Z"
                                            fill="#343330"></path>
                                    </svg>
                                </i>
                            </button>
                            <span>Wishlist</span>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <div class="aq-bottom-menu-item aq-cart-btn">
                        <button class="p-relative">
                            <span class="count-box">3</span>
                            <i>
                                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="14" viewBox="0 0 17 14"
                                    fill="none">
                                    <path
                                        d="M15.6923 0H1.30769C0.960871 0 0.628254 0.13409 0.383014 0.372773C0.137774 0.611456 0 0.935179 0 1.27273V12.7273C0 13.0648 0.137774 13.3885 0.383014 13.6272C0.628254 13.8659 0.960871 14 1.30769 14H15.6923C16.0391 14 16.3717 13.8659 16.617 13.6272C16.8622 13.3885 17 13.0648 17 12.7273V1.27273C17 0.935179 16.8622 0.611456 16.617 0.372773C16.3717 0.13409 16.0391 0 15.6923 0ZM15.6923 12.7273H1.30769V1.27273H15.6923V12.7273ZM12.4231 3.81818C12.4231 4.83083 12.0098 5.802 11.274 6.51804C10.5383 7.23409 9.54046 7.63636 8.5 7.63636C7.45954 7.63636 6.46169 7.23409 5.72597 6.51804C4.99025 5.802 4.57692 4.83083 4.57692 3.81818C4.57692 3.64941 4.64581 3.48755 4.76843 3.3682C4.89105 3.24886 5.05736 3.18182 5.23077 3.18182C5.40418 3.18182 5.57049 3.24886 5.69311 3.3682C5.81573 3.48755 5.88462 3.64941 5.88462 3.81818C5.88462 4.49328 6.16016 5.14072 6.65064 5.61809C7.14112 6.09546 7.80636 6.36364 8.5 6.36364C9.19364 6.36364 9.85888 6.09546 10.3494 5.61809C10.8398 5.14072 11.1154 4.49328 11.1154 3.81818C11.1154 3.64941 11.1843 3.48755 11.3069 3.3682C11.4295 3.24886 11.5958 3.18182 11.7692 3.18182C11.9426 3.18182 12.109 3.24886 12.2316 3.3682C12.3542 3.48755 12.4231 3.64941 12.4231 3.81818Z"
                                        fill="#343330"></path>
                                </svg>
                            </i>
                        </button>
                        <span>Cart</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- bottom-sticky header -->




    <header>

        <!-- header area start -->
        <!-- top bar area start -->

        <!-- Offer Bar -->
        <div class="offer-bar">

            <div class="offer-slider">

                @foreach($announcements as $announcement)

                <div class="offer-item {{ $loop->first ? 'active' : '' }}">

                    @if($announcement->link)

                    <a href="{{ $announcement->link }}" style="color: inherit; text-decoration:none;">

                        <span>
                            {{ $announcement->title }}
                        </span>

                    </a>

                    @else

                    <span>
                        {{ $announcement->title }}
                    </span>

                    @endif

                </div>

                @endforeach

            </div>


        </div>


        <!-- top bar area end -->

        <div class="aq-header-top-area aq-header-top-bdr"
            style="background: rgb(255 246 246 / 43%); position: relative;">
            <div class="container container-1830">
                <div class="row align-items-center">
                    <!-- Mobile Hamburger Menu (Left side) -->
                    <div class="col-3 d-md-none d-flex align-items-center">
                        <button type="button" class="aq-offcanvas-toggle" aria-label="Open Menu"
                            style="position: relative; background: transparent; border: none; padding: 0; color: #1c1c1c; cursor: pointer; z-index: 99;"
                            onclick="document.querySelector('.aq-offcanvas-wrap')?.classList.add('opened'); document.querySelector('.body-overlay')?.classList.add('opened');">
                            <i>
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                                    viewBox="0 0 24 24" fill="none">
                                    <path d="M4 12H20" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M4 6H20" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M4 18H20" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </i>
                        </button>
                    </div>

                    <!-- Logo Column (Centered on mobile) -->
                    <div class="col-xl-3 col-lg-3 col-md-3 col-6 text-center text-md-start">
                        <div class="aq-header-logo pt-10 pb-10 d-flex justify-content-center justify-content-md-start">
                            <a href="{{ url('/') }}">
                                <img class="mobile-logo-img" style="width: 160px; max-width: 100%; height: auto;" src="{{ $general?->logo
    ? asset('storage/' . $general->logo)
    : asset('assets/img/corporate/Oudhyana_img/logo.png') }}" alt="{{ $general?->site_name }}">

                                <div class=" d-md-block">
                                    {{ $general?->tagline ?? '' }}
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-7 col-lg-6 col-md-6 d-none d-md-block">
                        <div class="aq-header-search-form" style="position: relative;">
                            <form action="{{ route('search.suggestions') }}" method="GET" autocomplete="off"
                                style="display: flex; align-items: center; border: 1px solid #ddd; border-radius: 30px; background: #fff; overflow: hidden; padding: 2px 2px 2px 20px;">
                                <input class="searchInput" name="q" type="text"
                                    placeholder="Search Suits, Kurta, Ethnic Wears..."
                                    style="border: none; outline: none; width: 100%; padding: 10px 0; font-size: 14px; background: transparent;box-shadow: none;">
                                <button type="submit"
                                    style="background: #c98f9d; color: #fff; border: none; border-radius: 50px; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; cursor: pointer; margin-left: 10px; margin-right: 2px;"><i
                                        class="fa fa-search"></i></button>
                                <div class="searchSuggestions search-suggestions"></div>
                            </form>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-3 col-3">
                        <div class="aq-header-right-options text-end">
                            <ul style="display: flex; align-items: center; justify-content: flex-end; gap: 15px;">
                                <li class="d-md-none aq-mobile-search-btn-wrapper">
                                    <button type="button" class="aq-mobile-search-btn" aria-label="Search"
                                        style="position: relative; background: transparent; border: none; padding: 0; color: #1c1c1c; cursor: pointer;">
                                        <i>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="11" cy="11" r="8"></circle>
                                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                            </svg>
                                        </i>
                                    </button>
                                </li>
                                <li class="aq-header-top-wishlist d-none d-md-inline-block">
                                    <button class="aq-wishlist-btn" aria-label="Wishlist"
                                        style="position: relative; background: transparent; border: none; padding: 0;">
                                        <span class="count-box wishlist-count"
                                            style="background: #c98f9d; color: #fff;">
                                            {{ \App\Models\Wishlist::current()->count() }}
                                        </span>
                                        <i>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="21" height="20"
                                                viewBox="0 0 21 20" fill="none">
                                                <path
                                                    d="M6.50726 4.80303C5.44195 5.14334 4.68503 6.09974 4.59044 7.22502M10.4856 18.6038C12.6562 17.2679 14.6755 15.6957 16.5073 13.9152C17.7951 12.633 18.7756 11.0698 19.3735 9.3454C20.4494 6.00032 19.1927 2.17084 15.6755 1.03753C13.827 0.442448 11.8081 0.782566 10.2505 1.95149C8.69225 0.783989 6.67412 0.443991 4.82552 1.03753C1.30833 2.17084 0.0425004 6.00032 1.11845 9.3454C1.71636 11.0698 2.69679 12.633 3.98465 13.9152C5.81647 15.6957 7.83575 17.2679 10.0064 18.6038L10.2414 18.75L10.4856 18.6038Z"
                                                    stroke="currentcolor" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                            </svg>
                                        </i>
                                    </button>
                                </li>
                                <li class="aq-header-top-cart aq-cart-btn">
                                    <button aria-label="Shopping Cart"
                                        style="position: relative; background: transparent; border: none; padding: 0;">
                                        @php
                                        $cart = auth()->check()
                                        ? \App\Models\Cart::where('user_id', auth()->id())->first()
                                        : \App\Models\Cart::where('session_id', session()->getId())->first();
                                        @endphp

                                        <span class="count-box cart-count" style="background: #c98f9d; color: #fff;">
                                            {{ $cart?->items()->sum('quantity') ?? 0 }}
                                        </span>
                                        <i>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="21"
                                                viewBox="0 0 20 21" fill="none">
                                                <path
                                                    d="M5.48681 5.07041C5.48681 2.68433 7.4211 0.750039 9.80717 0.750039C10.9562 0.74517 12.0598 1.1982 12.874 2.00895C13.6882 2.81971 14.1459 3.92139 14.1458 5.07041M6.84107 9.57384H6.88684M12.6721 9.57388H12.7179M5.62368 19.972H13.9715C17.0379 19.972 19.3903 18.8645 18.7221 14.4068L17.944 8.3656C17.5321 6.14134 16.1134 5.29008 14.8685 5.29008H4.69004C3.42688 5.29008 2.0905 6.20542 1.61453 8.3656L0.836493 14.4068C0.268988 18.361 2.55732 19.972 5.62368 19.972Z"
                                                    stroke="currentcolor" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                            </svg>
                                        </i>
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Mobile Search Drawer Overlay -->
        <div class="aq-mobile-search-drawer"
            style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100vh; background: rgba(0,0,0,0.6); z-index: 99999;">
            <div class="search-drawer-content"
                style="background: #fff; width: 100%; padding: 25px 20px; border-bottom-left-radius: 15px; border-bottom-right-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); transform: translateY(-100%); transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h5
                        style="margin: 0; font-size: 20px; color: #222; font-family: var(--aq-ff-heading); font-weight: 600;">
                        What are you looking for?</h5>
                    <button class="close-search-drawer"
                        style="background: #f5f5f5; border: none; width: 32px; height: 32px; border-radius: 50%; font-size: 18px; cursor: pointer; color: #333; display: flex; align-items: center; justify-content: center; line-height: 1;">&times;</button>
                </div>
                <form action="#" class="aq-header-search-form"
                    style="display: flex; align-items: center; border: 2px solid #e5e5e5; border-radius: 8px; background: #fff; padding: 2px; transition: border-color 0.3s;">
                    <button type="submit"
                        style="background: transparent; color: #111; border: none; width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; font-size: 18px;"><i
                            class="fal fa-search"></i></button>
                    <input class="searchInput" name="q" type="text"
                        placeholder="Search premium chikankari, products, brands..."
                        style="border: none; outline: none; width: 100%; padding: 12px 10px 12px 0; font-size: 15px; background: transparent; color: #333;">
                    <div class="searchSuggestions search-suggestions"></div>
                </form>
                <div class="search-suggestions" style="margin-top: 25px;">
                    <span
                        style="font-size: 11px; color: #999; text-transform: uppercase; font-weight: 700; letter-spacing: 1.5px;">Popular
                        Searches</span>
                    <div style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: 15px;">
                        <a href="#"
                            style="padding: 8px 16px; background: #f9f9f9; border: 1px solid #eee; border-radius: 30px; font-size: 13px; color: #444; text-decoration: none; transition: all 0.2s;">Chikan
                            Kurti</a>
                        <a href="#"
                            style="padding: 8px 16px; background: #f9f9f9; border: 1px solid #eee; border-radius: 30px; font-size: 13px; color: #444; text-decoration: none; transition: all 0.2s;">Bridal
                            Lehenga</a>
                        <a href="#"
                            style="padding: 8px 16px; background: #f9f9f9; border: 1px solid #eee; border-radius: 30px; font-size: 13px; color: #444; text-decoration: none; transition: all 0.2s;">Mens
                            Kurta</a>
                        <a href="#"
                            style="padding: 8px 16px; background: #f9f9f9; border: 1px solid #eee; border-radius: 30px; font-size: 13px; color: #444; text-decoration: none; transition: all 0.2s;">Organza
                            Pieces</a>
                        <a href="#"
                            style="padding: 8px 16px; background: #f9f9f9; border: 1px solid #eee; border-radius: 30px; font-size: 13px; color: #444; text-decoration: none; transition: all 0.2s;">Bedsheet
                            Sets</a>
                    </div>
                </div>
            </div>
        </div>


        <div class="aq-header-bottom-area d-none d-xl-block p-relative" data-bg-color="rgb(255 246 246 / 43%)">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-12">
                        <div class="aq-header-menu aq-header-dropdown text-center">
                            <nav class="aq-mobile-menu-active">
                                <ul>
                                    <li><a href="{{ route('home') }}">Home</a></li>
                                    <li><a href="{{ route('about-us') }}">About Us</a></li>
                                    <li class="has-dropdown p-static">
                                        <a href="#">Chikankari Luxury Curation</a>
                                        <div class="aq-megamenu-wrap aq-corp-megamenu mega-menu">
                                            <div class="container">
                                                <div class="aq-corp-megamenu-inner">

                                                    @forelse($headerAttributes as $attribute)

                                                    <div class="aq-corp-megamenu-col">
                                                        <h6 class="aq-corp-megamenu-heading">
                                                            Shop By {{ $attribute->name }}
                                                        </h6>

                                                        <ul>
                                                            @forelse($attribute->values as $value)

                                                            <li>
                                                                <a
                                                                    href="{{ route('attribute.listing', [$attribute->slug, $value->slug]) }}">
                                                                    {{ $value->value }}
                                                                </a>
                                                            </li>

                                                            @empty

                                                            <li>
                                                                <a href="#">
                                                                    No {{ $attribute->name }} Found
                                                                </a>
                                                            </li>

                                                            @endforelse
                                                        </ul>
                                                    </div>

                                                    @empty

                                                    <div class="aq-corp-megamenu-col">
                                                        <h6 class="aq-corp-megamenu-heading">
                                                            Attributes
                                                        </h6>
                                                        <ul>
                                                            <li>
                                                                <a href="#">
                                                                    No Attributes Found
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>

                                                    @endforelse

                                                    <div class="aq-corp-megamenu-col">
                                                        <h6 class="aq-corp-megamenu-heading">
                                                            Shop By Collections
                                                        </h6>

                                                        <ul>

                                                            @foreach($headerCollections as $collection)

                                                            <li><a
                                                                    href="{{ route('collections.listing', $collection->slug) }}">{{
                                                                    $collection->name }}</a>
                                                            </li>

                                                            @endforeach

                                                        </ul>
                                                    </div>

                                                    <div class="aq-corp-megamenu-col">
                                                        <h6 class="aq-corp-megamenu-heading">Price Range</h6>
                                                        <ul>
                                                            @foreach(config('price_ranges') as $band)
                                                            <li><a href="{{ route('price.listing', $band['slug']) }}">{{
                                                                    $band['label'] }}</a>
                                                            </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                    <div class="aq-corp-megamenu-col">
                                                        <h6 class="aq-corp-megamenu-heading">Shop By Occasions</h6>
                                                        <ul>

                                                            @forelse($headerOccasions as $occasion)

                                                            <li><a
                                                                    href="{{ route('occasions.listing', $occasion->slug) }}">{{
                                                                    $occasion->title }}</a>
                                                            </li>

                                                            @empty

                                                            <li>
                                                                <a href="#">No Occasions Found</a>
                                                            </li>

                                                            @endforelse

                                                        </ul>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                    <!--      <li class="has-dropdown p-static">
                                        <a href="#">Categories</a>
                                        <div class="aq-megamenu-wrap aq-megamenu-img-wrap mega-menu">
                                            <div class="container">
                                                <div
                                                    class="row row-cols-xl-6 row-cols-lg-3 row-cols-md-2 row-cols-1 gx-20">
                                                    @foreach($menuCategories as $category)
                                                        <div class="col">
                                                            <div class="aq-megamenu-img-item mb-20">
                                                                <a href="{{ route('products.listing', $category->slug) }}">
                                                                    <div class="aq-megamenu-img">
                                                                        @if($category->image)
                                                                            <img src="{{ asset('storage/' . $category->image) }}"
                                                                                alt="{{ $category->name }}">
                                                                        @else
                                                                            <img src="{{ asset('assets/images/no-image.png') }}"
                                                                                alt="{{ $category->name }}">
                                                                        @endif
                                                                    </div><span
                                                                        class="aq-megamenu-img-title">{{ $category->name }}</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    @endforeach

                                                </div>
                                            </div>
                                        </div>
                                    </li> -->

                                    @foreach($navbarCategories as $category)

                                    <li class="has-dropdown">

                                        <a href="{{ route('products.listing', $category->slug) }}">
                                            {{ $category->name }}
                                        </a>

                                        @if($category->children->count())

                                        <ul class="submenu">

                                            @foreach($category->children as $subcategory)

                                            <li>
                                                <a
                                                    href="{{ route('products.listing', $category->slug) }}?subcategory={{ $subcategory->slug }}">
                                                    {{ $subcategory->name }}
                                                </a>
                                            </li>

                                            @endforeach

                                        </ul>

                                        @endif

                                    </li>

                                    @endforeach
                                    <li><a
                                            href="https://oudhyanachikankaari.com/dynamic/collections/end-of-season-sale">End
                                            of Season Sale</a></li>
                                    <!--  <li><a href="{{ route('blogs') }}">Blogs</a></li> -->
                                    <li><a href="{{ route('contact-us') }}">Contact</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- header area end -->


        <style>
            @media (max-width: 767px) {
                .offer-item span {
                    font-size: 11px;
                    display: block;
                    white-space: nowrap;
                    overflow: hidden;
                    text-overflow: ellipsis;
                }

                .aq-header-logo img {
                    max-width: 120px !important;
                }

                .aq-header-right-options ul {
                    gap: 10px !important;
                }
            }
        </style>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var searchBtn = document.querySelector('.aq-mobile-search-btn');
                var searchDrawer = document.querySelector('.aq-mobile-search-drawer');
                var drawerContent = searchDrawer ? searchDrawer.querySelector('.search-drawer-content') : null;
                var closeBtn = document.querySelector('.close-search-drawer');
                var searchInput = searchDrawer ? searchDrawer.querySelector('input') : null;

                function openSearch() {
                    searchDrawer.style.display = 'block';
                    // Trigger reflow
                    void searchDrawer.offsetWidth;
                    drawerContent.style.transform = 'translateY(0)';
                    document.body.style.overflow = 'hidden'; // prevent background scrolling
                    if (searchInput) setTimeout(() => searchInput.focus(), 300);
                }

                function closeSearch() {
                    drawerContent.style.transform = 'translateY(-100%)';
                    document.body.style.overflow = '';
                    setTimeout(function () {
                        searchDrawer.style.display = 'none';
                    }, 300);
                }

                if (searchBtn && searchDrawer) {
                    searchBtn.addEventListener('click', function (e) {
                        e.preventDefault();
                        openSearch();
                    });
                }

                if (closeBtn) {
                    closeBtn.addEventListener('click', function (e) {
                        e.preventDefault();
                        closeSearch();
                    });
                }

                // Close on overlay click
                if (searchDrawer) {
                    searchDrawer.addEventListener('click', function (e) {
                        if (e.target === searchDrawer) {
                            closeSearch();
                        }
                    });
                }
            });
        </script>

    </header>


    @yield('content')

    <!-- Premium Bespoke Bulk Enquiry Side Drawer Markup -->
    <div class="aq-drawer-parent-wrap" id="aqEnquiryDrawerWrap">
        <div class="aq-drawer-overlay" id="aqDrawerOverlay"></div>
        <div class="aq-drawer-card-body">
            <!-- Close Button -->
            <button class="aq-drawer-close-btn" id="aqDrawerCloseBtn" aria-label="Close Enquiry Drawer">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <!-- Drawer Header -->
            <div class="aq-drawer-header">
                <div class="aq-drawer-header-icon">
                    <i class="fa-solid fa-bag-shopping"></i>
                </div>
                <h3 class="aq-drawer-title">Bulk Order Enquiry</h3>
                <p class="aq-drawer-subtitle">Send enquiry for Bulk orders for Chikankari suits, sarees, kurtis, and
                    women's ethnic
                    wear with competitive pricing, premium quality, and timely delivery.</p>
            </div>

            <!-- Scrollable Content -->
            <div class="aq-drawer-form-scrollable">
                <!-- Form State -->
                <form class="aq-drawer-form" id="aqDrawerForm" method="POST" action="{{ route('general.enquiry') }}">
                    @csrf

                    <input type="hidden" name="source" id="global_source">

                    <div class="aq-drawer-form-row">
                        <div class="aq-drawer-form-group">
                            <label class="aq-drawer-label">Full Name *</label>
                            <div class="aq-drawer-input-wrapper">
                                <i class="fa-regular fa-user"></i>
                                <input type="text" name="name" value="{{ old('name') }}" class="aq-drawer-input"
                                    placeholder="Enter your name" required>
                            </div>
                        </div>
                    </div>

                    <div class="aq-drawer-form-row">
                        <div class="aq-drawer-form-group">
                            <label class="aq-drawer-label">Brand Name *</label>
                            <div class="aq-drawer-input-wrapper">
                                <i class="fa-solid fa-building"></i>
                                <input type="text" name="company" value="{{ old('company') }}" class="aq-drawer-input"
                                    placeholder="Your Brand Name" required>
                            </div>
                        </div>
                    </div>

                    <div class="aq-drawer-form-row">
                        <div class="aq-drawer-form-group">
                            <label class="aq-drawer-label">Email Address *</label>
                            <div class="aq-drawer-input-wrapper">
                                <i class="fa-regular fa-envelope"></i>
                                <input type="email" name="email" value="{{ old('email') }}" class="aq-drawer-input"
                                    placeholder="xyz@gmail.com" required>
                            </div>
                        </div>
                    </div>

                    <div class="aq-drawer-form-row">
                        <div class="aq-drawer-form-group">
                            <label class="aq-drawer-label">Mobile Number *</label>
                            <div class="aq-drawer-input-wrapper">
                                <i class="fa-solid fa-phone-flip"></i>
                                <input type="tel" name="phone" value="{{ old('phone') }}" class="aq-drawer-input"
                                    placeholder="+91 98765 43210" pattern="[6-9]{1}[0-9]{9}" maxlength="10" required>
                            </div>
                        </div>
                    </div>

                    <div class="aq-drawer-form-row">
                        <div class="aq-drawer-form-group">
                            <label class="aq-drawer-label">
                                Message / Special Requirement
                            </label>

                            <div class="aq-drawer-input-wrapper textarea-wrapper">
                                <i class="fa-regular fa-comment-dots"></i>

                                <textarea name="message" class="aq-drawer-textarea"
                                    placeholder="Any specific requirement or customization needed?">{{ old('message') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}">
                        </div>
                    </div>

                    <div class="aq-drawer-form-footer">

                        <button type="submit" class="aq-drawer-submit-btn">

                            <span>Submit Enquiry</span>

                            <i class="fa-solid fa-arrow-right-long"></i>

                        </button>

                        <div class="aq-drawer-secure-note">
                            <i class="fa-solid fa-shield-halved"></i>
                            <span>Bulk pricing available. Quick response guaranteed.<span>
                        </div>

                    </div>

                </form>


                <!-- Success State -->
                <div class="aq-drawer-success-state" id="aqDrawerSuccess">
                    <div class="aq-drawer-success-icon">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <h4 class="aq-drawer-success-title">Request Submitted!</h4>
                    <p class="aq-drawer-success-desc">
                        Thank you for your bulk order inquiry. Our team will contact you shortly with wholesale
                        pricing, product catalogs, and customization options within <strong>2 business hours</strong>.
                    </p>

                    <button type="button" class="aq-drawer-success-close-btn" id="aqDrawerSuccessClose">
                        Return to Site
                    </button>
                </div>
            </div>
        </div>
    </div>


    <footer>

        <!-- footer area start -->
        <div class="aq-footer-area-luxury p-relative">
            <div class="aq-footer-shape-top"></div>


            <div class="container">
                <div class="aq-footer-main pt-30 pb-30">




                    <div class="row">
                        <!-- Column 1: Branding & Intro -->
                        <div class="col-xl-4 col-lg-4 col-md-12">
                            <div class="aq-footer-widget footer-col-brand mb-50">
                                <div class="aq-footer-logo-luxury mb-35">
                                    <a href="{{ route('home') }}">
                                        @if(!empty($general?->logo))
                                        <img src="{{ asset('storage/' . $general->logo) }}"
                                            alt="{{ $general?->site_name }}"
                                            style="filter: brightness(0) invert(1); width: 180px;">
                                        @endif
                                    </a>
                                </div>
                                @if(!empty($general?->footer_description))
                                <p class="aq-footer-intro-text">
                                    {!! $general->footer_description !!}
                                </p>
                                @endif
                                <div class="aq-footer-social-luxury mt-40">
                                    
                                    @if($general?->whatsapp)
    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $general->whatsapp) }}" target="_blank" class="social-icon">
        <i class="fa-brands fa-whatsapp"></i>
    </a>
@endif
                                    @if($general?->facebook)
                                    <a href="{{ $general->facebook }}" target="_blank" class="social-icon">
                                        <i class="fa-brands fa-facebook-f"></i>
                                    </a>
                                    @endif

                                    @if($general?->twitter)
                                    <a href="{{ $general->twitter }}" target="_blank" class="social-icon">
                                        <i class="fa-brands fa-twitter"></i>
                                    </a>
                                    @endif

                                    @if($general?->linkedin)
                                    <a href="{{ $general->linkedin }}" target="_blank" class="social-icon">
                                        <i class="fa-brands fa-linkedin-in"></i>
                                    </a>
                                    @endif

                                    @if($general?->instagram)
                                    <a href="{{ $general->instagram }}" target="_blank" class="social-icon">
                                        <i class="fa-brands fa-instagram"></i>
                                    </a>
                                    @endif

                                    @if($general?->youtube)
                                    <a href="{{ $general->youtbe }}" target="_blank" class="social-icon">
                                        <i class="fa-brands fa-youtube"></i>
                                    </a>
                                    @endif
                                </div>


                            </div>
                        </div>



                        <!-- Column 3: Company -->
                        <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6">
                            <div class="aq-footer-widget mb-50">
                                <h4 class="aq-footer-title-luxury"><i class="fa-solid fa-building-columns mr-10"></i>
                                    Company</h4>
                                <ul class="aq-footer-menu-luxury">
                                    <li><a href="{{ route('about-us') }}"><i class="fa-solid fa-chevron-right"></i>
                                            About Us</a></li>
                                    <li><a href="{{ route('about-us') }}"><i class="fa-solid fa-chevron-right"></i> Our
                                            Heritage</a></li>
                                    <li><a href="{{ route('contact-us') }}"><i class="fa-solid fa-chevron-right"></i>
                                            Contact Us</a></li>
                                    <li><a href="{{ route('blogs') }}"><i class="fa-solid fa-chevron-right"></i>
                                            Blogs</a></li>
                                    <li><a href="{{ route('faqs') }}"><i class="fa-solid fa-chevron-right"></i> FAQs</a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Column 4: Quick Links -->
                        <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6">
                            <div class="aq-footer-widget mb-50">
                                <h4 class="aq-footer-title-luxury"><i class="fa-solid fa-link mr-10"></i> Quick
                                    Links</h4>
                                <ul class="aq-footer-menu-luxury">
                                    <li><a href="{{ route('categories') }}"><i class="fa-solid fa-chevron-right"></i>
                                            Shop All Collections</a></li>
                                    @foreach($headerCollections as $collection)

                                    <li><a href="{{ route('collections.listing', $collection->slug) }}"><i
                                                class="fa-solid fa-chevron-right"></i>{{ $collection->name }}</a>
                                    </li>

                                    @endforeach

                                </ul>
                            </div>
                        </div>

                        <!-- Column 2: Get in Touch -->
                        <div class="col-xl-4 col-lg-4 col-md-12">
                            <div class="aq-footer-widget mb-50">
                                <h4 class="aq-footer-title-luxury"><i class="fa-solid fa-headset mr-10"></i> GET IN
                                    TOUCH</h4>
                                <div class="aq-footer-contact-luxury">

                                    <div class="aq-contact-item-luxury d-flex align-items-start gap-3 mb-20">
                                        <div class="aq-contact-icon-box">
                                            <i class="fa-solid fa-location-dot"></i>
                                        </div>
                                        <div class="aq-contact-content-luxury">
                                            <h6>ADDRESS</h6>
                                            @if(!empty($general?->business_address))
                                            <p>{{ $general->business_address }}</p>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="aq-contact-item-luxury d-flex align-items-start gap-3 mb-20">
                                        <div class="aq-contact-icon-box">
                                            <i class="fa-solid fa-phone"></i>
                                        </div>
                                        <div class="aq-contact-content-luxury">
                                            <h6>PHONE</h6>
                                            @if(!empty($general?->phone))
                                            <p>{{ $general->phone }}</p>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="aq-contact-item-luxury d-flex align-items-start gap-3 mb-20">
                                        <a href="https://wa.me/0000000000" target="_blank">
                                            <div class="aq-contact-icon-box">
                                                <i class="fa-brands fa-whatsapp"></i>
                                            </div>
                                        </a>
                                        <div class="aq-contact-content-luxury">
                                            <h6>WHATSAPP</h6>
                                            @if(!empty($general?->whatsapp))
                                            <p>
                                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $general->whatsapp) }}"
                                                    target="_blank">

                                                    {{ $general->whatsapp }}

                                                </a>
                                            </p>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="aq-contact-item-luxury d-flex align-items-start gap-3 mb-20">
                                        <div class="aq-contact-icon-box">
                                            <i class="fa-solid fa-envelope"></i>
                                        </div>
                                        <div class="aq-contact-content-luxury">
                                            <h6>EMAIL</h6>
                                            @if(!empty($general?->support_email))
                                            <p>{{ $general->support_email }}</p>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="aq-footer-divider my-40"></div>

                    <!-- Lower Footer: Disclaimer & Policies -->
                    <div class="row align-items-center">

                        <div class="col-xl-12 col-lg-12">
                            <div class="aq-footer-policy-links text-center mb-20 mt-10">
                                @foreach($footerPages as $page)
                                <a href="{{ route('dynamic.page', \Illuminate\Support\Str::slug($page->page_name)) }}">
                                    {{ $page->heading }}</a>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-xl-12 col-lg-12">
                            <div class="aq-footer-disclaimer mb-20 mt-10">
                                <p><strong>Disclaimer:</strong> Oudhyana India provides Chikankari Suiting solutions
                                    only to businesses, institutions, and registered entities. All prices are
                                    exclusive
                                    of taxes. Product images are for representation only. Actual product may vary
                                    slightly. We are not responsible for any typographical errors. All trademarks
                                    and
                                    brand names belong to their respective owners.</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="aq-footer-bottom-luxury">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-md-6 text-center text-md-start">
                            <p class="copyright-text">Â© 2026 <span>Oudhyana India</span>. All Rights Reserved.</p>
                        </div>
                        <div class="col-md-6 text-center text-md-end">
                            <p class="copyright-create">Designed & Developed by <a href="#" target="_blank">Webmingo</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- footer area end -->
        <!-- footer area end -->

        <!-- footer area end -->

        </div>
        <!-- footer area end -->


        <div class="footer_whatspp">

            @if(!empty($general?->whatsapp))
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $general->whatsapp) }}" target="_blank"
                class="social-whatspp" title="WhatsApp">

                <i class="fa-brands fa-whatsapp"></i>

            </a>
            @endif

        </div>

    </footer>


    <style>
        .aqf-slider-height {
            height: 600px;
            width: 100%;
            position: relative;
            overflow: hidden;
        }

        @media (max-width: 991px) {
            .aqf-slider-height {
                height: 500px;
            }
        }

        @media (max-width: 767px) {
            .aqf-slider-height {
                height: 400px;
            }
        }

        .aqf-slider-thumb.include-bg {
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
        }
    </style>
    <!-- Floating Action Buttons -->
    <div class="floating-buttons"
        style="position: fixed; bottom: 30px; right: 30px; z-index: 9999; display: flex; flex-direction: column; gap: 15px;">

    </div>

    <style>
        /* WhatsApp floating button styling with elegant scroll animation */
        .footer_whatspp {
            position: fixed;
            right: 40px;
            bottom: 40px;
            /* Positioned at 120px when at the top */
            z-index: 99999;
            opacity: 0;
            visibility: hidden;
            transform: scale(0.8);
            transition: bottom 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275),
                opacity 0.4s ease,
                visibility 0.4s ease,
                transform 0.4s ease;
        }

        /* Active class to fade and scale in */
        .footer_whatspp.whatspp-active {
            opacity: 1;
            visibility: visible;
            transform: scale(1);
        }

        /* Scrolled class to move down to 40px */
        .footer_whatspp.whatspp-active.whatspp-scrolled {
            bottom: 120px;
        }

        .social-whatspp {
            transition: all 0.3s ease;
        }

        .social-whatspp:hover {
            transform: scale(1.1);
            box-shadow: 0 10px 25px rgba(37, 211, 102, 0.5);
        }

        /* Progress back-to-top button styling */
        .progress-wrap {
            position: fixed;
            right: 46px;
            bottom: 44px;
            height: 50px;
            width: 50px;
            cursor: pointer;
            display: block;
            border-radius: 50%;
            box-shadow: inset 0 0 0 2px rgba(128, 0, 0, 0.15);
            z-index: 9999;
            opacity: 0;
            visibility: hidden;
            transform: translateY(15px);
            transition: all 200ms linear;
            background-color: #fff;
        }

        .progress-wrap.active-progress {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .progress-wrap::after {
            position: absolute;
            width: 50px !important;
            height: 50px !important;
            color: #800000 !important;
            /* Deep Maroon matching user palette */
            left: 0;
            top: 0;
            cursor: pointer;
            display: block;
            z-index: 1;
            transition: all 200ms linear;
            background-size: 14px 10px !important;
            /* Scale native SVG arrow beautifully */
        }

        .progress-wrap:hover::after {
            color: #B87333 !important;
            /* Copper/Gold hover */
        }

        .progress-wrap svg path {
            fill: none;
            stroke: #800000;
            /* Deep Maroon matching user palette */
            stroke-width: 4;
            box-sizing: border-box;
            transition: all 200ms linear;
        }

        .whatsapp-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(37, 211, 102, 0.4);
        }

        .enquiry-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(184, 115, 51, 0.4);
            background: #9e622b;
        }

        .submenu {
            position: absolute;
            top: 100%;
            left: 0;
            background: white;

            min-width: 220px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            list-style: none;
            padding: 15px 0;
            text-align: left;
            z-index: 99;
        }

        li.has-dropdown:hover>.submenu {
            opacity: 1;
            visibility: visible;
            top: 110%;
        }

        .submenu li a {
            display: block;
            padding: 8px 25px;
            color: #333;
            font-size: 14px;
            transition: all 0.3s;
        }

        .submenu li a:hover {
            color: #B87333;
            padding-left: 30px;
        }

        /* Mobile adjustments for floating buttons */
        @media (max-width: 768px) {
            .footer_whatspp {
                right: 20px;
                bottom: 100px !important;
            }

            .footer_whatspp.whatspp-active.whatspp-scrolled {
                bottom: 20px !important;
            }

            .social-whatspp {
                width: 50px !important;
                height: 50px !important;
                font-size: 20px !important;
            }

            .progress-wrap {
                right: 85px !important;
                /* Side-by-side with WhatsApp on mobile */
                bottom: 20px !important;
                height: 40px !important;
                width: 40px !important;
            }

            .progress-wrap::after {
                height: 40px !important;
                width: 40px !important;
                background-size: 11px 8px !important;
                /* Scale SVG arrow beautifully for mobile */
            }

            .floating-buttons {
                bottom: 20px;
                right: 20px;
                gap: 10px;
            }

            .enquiry-btn {
                padding: 10px 18px;
                font-size: 13px;
            }

            .whatsapp-btn {
                width: 50px;
                height: 50px;
            }
        }
    </style>


    <!-- JS here -->
    <script src="{{ asset('assets/js/vendor/jquery.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-bundle.js') }}"></script>
    <script src="{{ asset('assets/js/swiper-bundle.js') }}"></script>
    <script src="{{ asset('assets/js/magnific-popup.js') }}"></script>
    <script src="{{ asset('assets/js/nice-select.js') }}"></script>
    <script src="{{ asset('assets/js/purecounter.js') }}"></script>
    <script src="{{ asset('assets/js/isotope-pkgd.js') }}"></script>
    <script src="{{ asset('assets/js/lazysize.min.js') }}"></script>
    <script src="{{ asset('assets/js/slider-active.js') }}"></script>
    <script src="{{ asset('assets/js/imagesloaded-pkgd.js') }}"></script>
    <script src="{{ asset('assets/js/ajax-form.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>



    @if(session('success_general'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const drawerWrap = document.getElementById("aqEnquiryDrawerWrap");
            const drawerForm = document.getElementById("aqDrawerForm");
            const drawerSuccess = document.getElementById("aqDrawerSuccess");

            // Open drawer
            if (drawerWrap) {
                drawerWrap.classList.add("active");
            }

            // Hide form
            if (drawerForm) {
                drawerForm.classList.add("hidden");
            }

            // Show success state
            setTimeout(() => {
                if (drawerSuccess) {
                    drawerSuccess.classList.add("active");
                }
            }, 250);

        });
    </script>
    @endif

    @if($errors->generalForm->any())
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const drawerWrap = document.getElementById('aqEnquiryDrawerWrap');

            if (drawerWrap) {
                drawerWrap.classList.add('active');
                document.body.style.overflow = 'hidden';
            }

            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                html: `{!! implode('<br>', $errors->generalForm->all()) !!}`
            });

        });
    </script>
    @endif

    <!-- Bulk Orders Submission Handler & Drawer Controller -->
    <script>


        document.addEventListener("DOMContentLoaded", function () {
            const drawerWrap = document.getElementById("aqEnquiryDrawerWrap");
            const drawerOverlay = document.getElementById("aqDrawerOverlay");
            const drawerCloseBtn = document.getElementById("aqDrawerCloseBtn");
            const drawerForm = document.getElementById("aqDrawerForm");
            const drawerSuccess = document.getElementById("aqDrawerSuccess");
            const drawerSuccessClose = document.getElementById("aqDrawerSuccessClose");

            window.openGlobalDrawer = function (source = 'general') {

                const sourceField = document.getElementById('global_source');

                if (sourceField) {
                    sourceField.value = source;
                }

                // Hide any open bootstrap modal if present safely
                const activeModal = document.querySelector('.modal.show');
                if (activeModal) {
                    try {
                        if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                            const modalInstance = bootstrap.Modal.getInstance(activeModal);
                            if (modalInstance) {
                                modalInstance.hide();
                            }
                        } else if (typeof jQuery !== 'undefined' && jQuery.fn && jQuery.fn.modal) {
                            jQuery(activeModal).modal('hide');
                        } else if (typeof $ !== 'undefined' && $.fn && $.fn.modal) {
                            $(activeModal).modal('hide');
                        }
                    } catch (err) {
                        console.warn("Bootstrap modal close warning: ", err);
                    }
                }


                drawerWrap.classList.add('active');
                document.body.style.overflow = "hidden";
            };

            // Close Drawer Function
            function closeEnquiryDrawer() {
                drawerWrap.classList.remove("active");
                document.body.style.overflow = ""; // Re-enable scroll

                // Reset form state after transition completes
                setTimeout(() => {
                    drawerForm.classList.remove("hidden");
                    drawerSuccess.classList.remove("active");
                    drawerForm.reset();
                    // Reset input focus wrappers
                    document.querySelectorAll('.aq-drawer-input-wrapper, .aq-drawer-select-wrapper').forEach(wrap => {
                        wrap.classList.remove("focus");
                    });
                }, 500);
            }

            // Setup input wrapper active state indicators
            function setupInputEffects() {
                const inputs = document.querySelectorAll(
                    '.aq-drawer-input, .aq-drawer-select, .aq-drawer-textarea'
                );

                inputs.forEach(input => {
                    const wrapper = input.closest('.aq-drawer-input-wrapper, .aq-drawer-select-wrapper');
                    if (!wrapper) return;

                    input.addEventListener("focus", () => {
                        wrapper.classList.add("focus");
                    });

                    input.addEventListener("blur", () => {
                        wrapper.classList.remove("focus");
                    });
                });
            }

            // Bind click events for closing
            if (drawerCloseBtn) drawerCloseBtn.addEventListener("click", closeEnquiryDrawer);
            if (drawerOverlay) drawerOverlay.addEventListener("click", closeEnquiryDrawer);
            if (drawerSuccessClose) drawerSuccessClose.addEventListener("click", closeEnquiryDrawer);

            // ESC key closes drawer
            document.addEventListener("keydown", function (e) {
                if (e.key === "Escape" && drawerWrap.classList.contains("active")) {
                    closeEnquiryDrawer();
                }
            });

            // Initialize Setup
            setupInputEffects();
            observer.observe(document.body, { childList: true, subtree: true });
        });
    </script>

    <!-- WhatsApp scroll behavior script -->
    <script>

        document.addEventListener("DOMContentLoaded", function () {
            var whatsappBtn = document.querySelector(".footer_whatspp");
            if (whatsappBtn) {
                // Check initial scroll position on page load
                if (window.scrollY > 10) {
                    whatsappBtn.classList.add("whatspp-active", "whatspp-scrolled");
                }
                window.addEventListener("scroll", function () {
                    if (window.scrollY > 10) {
                        // Scrolled state: make active and slide down to bottom: 40px
                        whatsappBtn.classList.add("whatspp-active", "whatspp-scrolled");
                    } else {
                        // Back at the top: keep active but slide back up to bottom: 120px
                        whatsappBtn.classList.add("whatspp-active");
                        whatsappBtn.classList.remove("whatspp-scrolled");
                    }
                }, { passive: true });
            }
        });

    </script>

    <script>
        $(document).ready(function () {

            const storagePath = "{{ asset('storage') }}";
            const noImage = "{{ asset('assets/images/no-image.png') }}";

            let searchRequest = null;

            $(document).on('keyup', '.searchInput', function () {

                let input = $(this);
                let query = input.val().trim();

                let suggestionsBox = input
                    .closest('.aq-header-search-form')
                    .find('.searchSuggestions');

                if (query.length < 2) {
                    suggestionsBox.hide().empty();
                    return;
                }

                // Abort previous request
                if (searchRequest) {
                    searchRequest.abort();
                }

                searchRequest = $.ajax({
                    url: "{{ route('search.suggestions') }}",
                    type: "GET",
                    data: {
                        q: query
                    },
                    success: function (response) {

                        let html = '';

                        // Products
                        if (response.products?.length) {

                            html += '<div class="section-title">Products</div>';

                            response.products.forEach(item => {

                                let image = item.image || noImage;

                                html += `
                            <a href="/product/${item.slug}" class="d-flex align-items-center gap-2">
                                <img src="${image}"
                                     width="40"
                                     height="40"
                                     style="object-fit:cover;border-radius:6px;">
                                <span>${item.name}</span>
                            </a>
                        `;
                            });
                        }

                        // Categories
                        if (response.categories?.length) {

                            html += '<div class="section-title">Categories</div>';

                            response.categories.forEach(item => {

                                let image = item.image
                                    ? `${storagePath}/${item.image}`
                                    : noImage;

                                html += `
                            <a href="/category/${item.slug}" class="d-flex align-items-center gap-2">
                                <img src="${image}"
                                     width="40"
                                     height="40"
                                     style="object-fit:cover;border-radius:6px;">
                                <span>${item.name}</span>
                            </a>
                        `;
                            });
                        }

                        // Sub Categories
                        if (response.subcategories?.length) {

                            html += '<div class="section-title">Sub Categories</div>';

                            response.subcategories.forEach(item => {

                                let image = item.image
                                    ? `${storagePath}/${item.image}`
                                    : noImage;

                                html += `
                            <a href="/category/${item.parent_slug}?subcategory=${item.slug}"
                               class="d-flex align-items-center gap-2">
                                <img src="${image}"
                                     width="40"
                                     height="40"
                                     style="object-fit:cover;border-radius:6px;">
                                <span>${item.name}</span>
                            </a>
                        `;
                            });
                        }

                        // Occasions
                        if (response.occasions?.length) {

                            html += '<div class="section-title">Occasions</div>';

                            response.occasions.forEach(item => {

                                let image = item.image
                                    ? `${storagePath}/${item.image}`
                                    : noImage;

                                html += `
                            <a href="/products?occasion=${item.slug}"
                               class="d-flex align-items-center gap-2">
                                <img src="${image}"
                                     width="40"
                                     height="40"
                                     style="object-fit:cover;border-radius:6px;">
                                <span>${item.title}</span>
                            </a>
                        `;
                            });
                        }

                        suggestionsBox.html(
                            html ||
                            `<div class="p-3 text-center">No results found</div>`
                        ).show();
                    },
                    error: function (xhr, status) {
                        if (status !== 'abort') {
                            suggestionsBox.hide().empty();
                        }
                    }
                });
            });

            // Hide suggestions when clicking outside
            $(document).on('click', function (e) {
                if (!$(e.target).closest('.aq-header-search-form').length) {
                    $('.searchSuggestions').hide();
                }
            });

        });
    </script>

    <script>
        document.querySelectorAll('.remove-cart-item').forEach(btn => {
            btn.addEventListener('click', function () {

                let itemId = this.getAttribute('data-id');

                let url = "{{ url('cart/remove') }}/" + itemId;

                fetch(url, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    }
                })
                    .then(res => res.json())
                    .then(data => {

                        Swal.fire({
                            icon: 'success',
                            title: 'Removed!',
                            text: data.message,
                            timer: 1200,
                            showConfirmButton: false
                        });

                        // ✅ Remove item from UI instantly
                        this.closest('.aq-cartmini-product-item').remove();

                        // ✅ Reload page (to update totals + header count)
                        setTimeout(() => {
                            location.reload();
                        }, 800);

                    });

            });
        });


        document.querySelectorAll('.aq-cart-plus').forEach(btn => {

            btn.addEventListener('click', function () {

                updateCartQty(this.dataset.id, 'plus');
            });

        });

        document.querySelectorAll('.aq-cart-minus').forEach(btn => {

            btn.addEventListener('click', function () {

                updateCartQty(this.dataset.id, 'minus');
            });

        });

        function updateCartQty(itemId, action) {
            fetch("{{ route('cart.update.quantity') }}", {

                method: "POST",

                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },

                body: JSON.stringify({
                    item_id: itemId,
                    action: action
                })

            })
                .then(res => res.json())
                .then(data => {

                    location.reload();

                });
        }



    </script>

    <script>
        const quickViewBaseUrl = "{{ route('product.quickview', ['id' => '__ID__']) }}";

        let qvCurrentProduct = null;
        let qvVariants = [];
        let qvSwiper = null;

        function loadQuickView(productId) {
            $('#quickViewContent').hide();
            $('#quickViewLoader').show();

            $.ajax({
                url: quickViewBaseUrl.replace('__ID__', productId),
                type: 'GET',
                success: function (response) {
                    if (response.status) {
                        renderQuickView(response);
                    }
                },
                error: function () {
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Unable to load product.' });
                },
                complete: function () {
                    $('#quickViewLoader').hide();
                    $('#quickViewContent').show();
                }
            });
        }

        function renderQuickView(data) {
            qvCurrentProduct = data.product;
            qvCurrentProduct.variant_id = null;
            qvVariants = data.variants;

            $('#qvCategory').text(data.product.category);
            $('#qvTitle').text(data.product.name);
            $('#qvViewDetailsLink').attr('href', data.product.url);

            setQvPrice(data.product.price, data.product.mrp);

            let starsHtml = '';
            for (let i = 1; i <= 5; i++) {
                starsHtml += '<span><i class="fa-' + (i <= Math.round(data.avgRating) ? 'solid' : 'regular') + ' fa-star"></i></span>';
            }
            $('#qvStars').html(starsHtml);
            $('#qvReviewsCount').text('(' + data.reviewsCount + ' review' + (data.reviewsCount === 1 ? '' : 's') + ')');

            // slider
            let slidesHtml = '';
            data.product.images.forEach(function (img) {
                slidesHtml += '<div class="swiper-slide"><div class="aq-modal-slider"><img class="w-100" src="' + img + '" alt="' + data.product.name + '"></div></div>';
            });
            $('#qvSwiperWrapper').html(slidesHtml);

            if (qvSwiper) qvSwiper.destroy(true, true);
            qvSwiper = new Swiper('.aq-modal-slider-active', {
                loop: data.product.images.length > 1,
                navigation: { nextEl: '.aq-modal-next', prevEl: '.aq-modal-prev' }
            });

            // variant buttons
            let variantsHtml = '';
            Object.keys(data.variantAttributes).forEach(function (attrId) {
                const attr = data.variantAttributes[attrId];
                variantsHtml += '<div class="aq-product-details-size mb-20"><h4 class="aq-product-details-title-sm mb-15">' + attr.name + '</h4><div class="aq-product-details-size-list">';
                Object.keys(attr.values).forEach(function (valueId) {
                    variantsHtml += '<button type="button" class="qv-variant-option" data-attribute-id="' + attrId + '" data-value-id="' + valueId + '">' + attr.values[valueId] + '</button>';
                });
                variantsHtml += '</div></div>';
            });
            $('#qvVariantsWrap').html(variantsHtml);

            $('#qvQty').val(data.product.min_qty || 1).attr('max', data.product.stock);
            updateQvStockState(data.product.stock);
        }

        function setQvPrice(price, mrp) {
            $('#qvPrice').text('₹' + Number(price).toLocaleString('en-IN'));
            if (mrp > price) {
                $('#qvMrp').text('₹' + Number(mrp).toLocaleString('en-IN')).show();
            } else {
                $('#qvMrp').hide();
            }
        }

        $(document).on('click', '.qv-variant-option', function () {
            const attributeId = $(this).data('attribute-id');

            $('.qv-variant-option[data-attribute-id="' + attributeId + '"]').removeClass('active');
            $(this).addClass('active');

            const selectedValues = $('.qv-variant-option.active').map(function () {
                return parseInt($(this).data('value-id'));
            }).get();

            const matchedVariant = qvVariants.find(function (variant) {
                return selectedValues.every(value => variant.values.includes(value));
            });

            if (matchedVariant) {
                qvCurrentProduct.variant_id = matchedVariant.id;
                setQvPrice(matchedVariant.price, matchedVariant.mrp);
                updateQvStockState(matchedVariant.stock);

                if (matchedVariant.image) {
                    $('#qvSwiperWrapper').prepend('<div class="swiper-slide"><div class="aq-modal-slider"><img class="w-100" src="/storage/' + matchedVariant.image + '"></div></div>');
                    qvSwiper.update();
                    qvSwiper.slideTo(0);
                }
            }
        });

        function updateQvStockState(stock) {
            qvCurrentProduct.stock = stock;
            $('#qvQty').attr('max', stock);

            if (stock > 0) {
                $('#qvAddToCartBtn').prop('disabled', false).text('Add To Cart');
                $('#qvBuyNowBtn').prop('disabled', false).text('Buy Now');
            } else {
                $('#qvAddToCartBtn').prop('disabled', true).text('Out of Stock');
                $('#qvBuyNowBtn').prop('disabled', true).text('Out of Stock');
            }
        }

        function qvAdjustQty(amount) {
            const input = document.getElementById('qvQty');
            const max = parseInt(input.getAttribute('max')) || 9999;
            let val = (parseInt(input.value) || 1) + amount;
            if (val < 1) val = 1;
            if (val > max) val = max;
            input.value = val;
        }

        function qvAddToCart(buyNow) {
            if (!qvCurrentProduct || qvCurrentProduct.stock <= 0) return;

            const quantity = parseInt($('#qvQty').val()) || 1;

            $.ajax({
                url: "{{ route('cart.add') }}",
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    product_id: qvCurrentProduct.id,
                    variant_id: qvCurrentProduct.variant_id,
                    quantity: quantity
                },
                success: function (response) {
                    if (response.status) {
                        Swal.fire({ icon: 'success', title: 'Success', text: response.message, timer: 1500, showConfirmButton: false });
                        $('.cart-count').text(response.cart_count);
                        if (buyNow) {
                            window.location.href = "{{ route('cart') }}";
                        }
                    } else {
                        Swal.fire({ icon: 'error', title: 'Error', text: 'Unable to add product.' });
                    }
                },
                error: function (xhr) {
                    Swal.fire({ icon: 'error', title: 'Error', text: xhr.responseJSON?.message ?? 'Something went wrong.' });
                }
            });
        }

        function qvAddToWishlist() {
            if (!qvCurrentProduct) return;
            addToWishlist(qvCurrentProduct.id); // reuses the existing global wishlist function
        }

        // reset content when modal closes so old data doesn't flash next time
        $('#producQuickViewModal').on('hidden.bs.modal', function () {
            $('#quickViewContent').hide();
            $('#qvSwiperWrapper').empty();
            $('#qvVariantsWrap').empty();
            qvCurrentProduct = null;
        });
    </script>

    <style>
        .search-suggestions {
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            max-height: 400px;
            overflow-y: auto;
            z-index: 9999;
            display: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, .08);
        }

        .search-suggestions a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 15px;
            color: #333;
            text-decoration: none;
        }

        .search-suggestions a:hover {
            background: #f8f8f8;
        }

        .search-suggestions .section-title {
            font-size: 12px;
            font-weight: 700;
            color: #999;
            padding: 10px 15px 5px;
            text-transform: uppercase;
        }
    </style>

    <!-- Video Lightbox -->
    <div id="aqf-video-lightbox" class="aqf-video-lightbox">
        <div class="aqf-lightbox-overlay"></div>
        <button class="aqf-lightbox-close" aria-label="Close Lightbox"><i class="fa-solid fa-xmark"></i></button>
        <button class="aqf-lightbox-prev" aria-label="Previous Video"><i class="fa-solid fa-chevron-left"></i></button>
        <button class="aqf-lightbox-next" aria-label="Next Video"><i class="fa-solid fa-chevron-right"></i></button>

        <div class="aqf-lightbox-content">
            <div class="aqf-lightbox-video-wrapper">
                <video id="aqf-lightbox-video" controls autoplay playsinline></video>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var topArea = document.querySelector('.aq-header-top-area');
            var bottomArea = document.querySelector('.aq-header-bottom-area');
            var offerBar = document.querySelector('.offer-bar');

            if (topArea) {
                var topAreaHeight = topArea.offsetHeight;

                window.addEventListener('scroll', function () {
                    var stickyOffset = offerBar ? offerBar.offsetHeight : 0;

                    if (window.scrollY > stickyOffset) {
                        topArea.style.position = 'fixed';
                        topArea.style.top = '0';
                        topArea.style.left = '0';
                        topArea.style.width = '100%';
                        topArea.style.zIndex = '1020';
                        topArea.style.boxShadow = '0 4px 15px rgba(0, 0, 0, 0.05)';
                        topArea.style.background = '#fff';

                        if (bottomArea) {
                            bottomArea.style.marginTop = topAreaHeight + 'px';
                        }
                    } else {
                        topArea.style.position = 'relative';
                        topArea.style.top = '';
                        topArea.style.left = '';
                        topArea.style.width = '';
                        topArea.style.zIndex = '';
                        topArea.style.boxShadow = '';
                        topArea.style.background = 'rgb(255 246 246 / 43%)';

                        if (bottomArea) {
                            bottomArea.style.marginTop = '0';
                        }
                    }
                });
            }
        });
    </script>
</body>

</html>