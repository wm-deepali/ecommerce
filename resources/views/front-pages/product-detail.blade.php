@extends('layouts.app')
@section('content')

   @php
    // Category/Subcategory size chart — prefer the subcategory's if set,
    // fall back to the parent category's.
    $sizeChartImage = optional($product->subcategory)->size_chart_image
        ?? optional($product->category)->size_chart_image;

    // Real availability: if this product has stock-type variants, that's
    // the source of truth — the base `stock` column can go stale relative
    // to variants. Falls back to the base column only for products with
    // no stock variants at all.
    $stockVariants = $product->variants->where('type', 'stock');
    $detailStock = $stockVariants->count()
        ? $stockVariants->sum('stock')
        : $product->stock;
@endphp

    <style>
.qty-btn:disabled {
    opacity: 0.35;
    cursor: not-allowed;
}
        
        .aq-preloader-logo img {
    width: 66px;
    position: absolute;
    top: 72px;
    inset-inline-start: 0;
    /* width: 100%; */
    left: 38px;
}
        /* ── Video gallery thumb (play icon overlay) ───────────────── */
        .aq-gallery-thumb-video { position: relative; cursor: pointer; }
        .aq-thumb-play-icon {
            position: absolute; inset: 0; display: flex; align-items: center; justify-content: center;
            background: rgba(0,0,0,.35); color: #fff; font-size: 14px; border-radius: inherit;
        }
        #aqMainProductVideo { width: 100%; height: 100%; object-fit: cover; border-radius: inherit; }

        /* ── Size chart trigger ─────────────────────────────────────── */
        .aq-size-chart-link {
            background: transparent; border: none; padding: 0; font-size: 12.5px; font-weight: 600;
            color: #b5904a; display: inline-flex; align-items: center; gap: 5px; cursor: pointer;
            text-decoration: underline;
        }
        .aq-size-chart-link:hover { opacity: .8; }
        #sizeChartModal .modal-body { text-align: center; padding: 20px; }
        #sizeChartModal .modal-body img { max-width: 100%; border-radius: 8px; }

        /* ── Variant control types ─────────────────────────────────── */
        .aq-color-swatch {
            min-width: 50px;
            min-height: 50px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background: #fff;
            padding: 2px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }
        .aq-color-swatch-inner {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: block;
        }

    .aq-color-swatch.active {
    border-color: #c98f9d;
    box-shadow: 0 0 0 2px rgb(181 74 132 / 25%);
}
    
    
        .aq-image-swatch {
            border: 1px solid #e5e5e5; border-radius: 6px; padding: 3px; cursor: pointer;
            background: #fff; display: inline-flex;
        }
        .aq-image-swatch img { width: 44px; height: 44px; object-fit: cover; border-radius: 4px; }
        .aq-image-swatch.active { border-color: #b5904a; box-shadow: 0 0 0 2px rgba(181,144,74,.25); }

        .aq-radio-option {
            display: inline-flex; align-items: center; gap: 6px; cursor: pointer;
            padding: 6px 12px; border: 1px solid #e5e5e5; border-radius: 20px;
        }
        .aq-radio-option.active { border-color: #b5904a; background: rgba(181,144,74,.08); }

        .aq-size-dropdown { max-width: 260px; }

        /* ── Desktop Gallery Layout & Sticky column ────────────────── */
       .aq-sticky-column {
    position: sticky;
    top: 20px;
    align-self: flex-start;

    /*max-height: calc(100vh - 140px);*/
    /*overflow-y: auto;*/

    scrollbar-width: none;
    -ms-overflow-style: none;
}

.aq-sticky-column::-webkit-scrollbar {
    display: none;
}
        .aq-gallery-thumbs {
            display: flex;
            gap: 12px;
            overflow: auto;
            scrollbar-width: none;
        }
        .aq-gallery-thumbs::-webkit-scrollbar { display: none; }
        
        .aq-gallery-thumb-item {
            flex-shrink: 0;
            width: 70px;
            height: 90px;
            border: 1px solid #e5e5e5;
            cursor: pointer;
            border-radius: 4px;
            overflow: hidden;
        }
        .aq-gallery-thumb-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .aq-gallery-thumb-item.active {
            border-color: #b5904a;
            box-shadow: 0 0 0 2px rgba(181,144,74,.25);
        }

        /* ── Typography & Clean Design (Right Column) ─────────────── */
        .design-brand {
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #777;
            margin-bottom: 15px;
            display: block;
        }
        .design-title {
            font-family: 'Times New Roman', Times, serif; /* Elegant serif fallback */
            font-size: 22px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: #333;
            line-height: 1.4;
            margin-bottom: 10px;
        }
        .design-tax-info {
            font-size: 13px;
            color: #777;
            margin-bottom: 25px;
            display: block;
        }
        .design-size-chart {
            font-size: 13px;
            color: #333;
            text-decoration: underline;
            display: flex;
            align-items: center;
            gap: 8px;
            background: none;
            border: none;
            padding: 0;
            margin-bottom: 30px;
            cursor: pointer;
        }
        .design-size-chart i {
            font-size: 16px;
        }
        
        /* ── Button Styles ────────────────────────────────────────── */
        .btn-design-primary {
            background-color: #4a4a4a;
            color: #fff;
            border: none;
            padding: 15px;
            width: 100%;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .btn-design-primary:hover {
            background-color: #333;
        }
        .btn-design-secondary {
            background-color: #f5f5f5;
            color: #555;
            border: 1px solid #ddd;
            padding: 15px;
            width: 100%;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s ease;
            /*margin-top: 10px;*/
        }
        .btn-design-secondary:hover {
            background-color: #eee;
        }

        /* ── Accordion Clean Design ───────────────────────────────── */
        .design-accordion .accordion-item {
            border: none;
            border-bottom: 1px solid #e0e0e0;
            background: transparent;
            border-radius: 0 !important;
        }
        .design-accordion .accordion-button {
            background: transparent !important;
            color: #333;
            font-size: 13px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            padding: 20px 0;
            box-shadow: none !important;
        }
        .design-accordion .accordion-button::after {
            content: '+';
            background-image: none !important;
            font-size: 24px;
            font-weight: 300;
            display: flex;
            align-items: center;
            justify-content: center;
            transform: none !important;
            line-height: 1;
            width: 24px;
            height: 24px;
        }
        .design-accordion .accordion-button:not(.collapsed)::after {
            content: '\2212'; /* Unicode minus sign for perfect vertical centering */
            background-image: none !important;
        }
       .design-accordion .accordion-body {
    padding: 20px 20px 20px 20px;
    font-size: 14px;
    color: #666;
    line-height: 1.6;
}
        .aq-details-price-box {
    background-color: var(--aq-color-cream);
    border-radius: 12px;
    border-left: 2px solid var(--aq-color-maroon) !important;
}

h5.aq-size-title {
    color: black;
    font-size: 18px;
    font-weight: 600;
}
 
 
 .aq-size-badge {
    border: 1px solid #ddd;
    padding: 3px 8px;
    font-size: 14px;
    border-radius: 4px;
    color: #555;
    cursor: pointer;
    transition: all 0.3s;
    font-family: Inter, sans-serif;
    min-width: 50px;
    min-height: 50px;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    column-gap: .875rem;
    position: relative;
}


.aq-moq-info-list p {
font-size:15px;
}

.aq-product-details-area .aq-gallery-thumb-item {
    width: 60px!important;
    
}

.aq-product-accordion .accordion-item {
    
    border-radius: 0px !important;
   
}


.aq-product-details-area .aq-product-details-summary {
    padding-left: 0px!important;
}

.aq-product-accordion .accordion {
    border: none;
    border-top: 1px solid #8080800f !important;
}



.aq-product-accordion .accordion-button {
   
    font-size: 16px!important;
   
    padding: 9px 26px!important;
   
}

.aq-product-accordion .accordion-button::before {
    content: "";
    width: 36px;
    height: 36px;
    
}

.aq-catpage-hero {
   
    min-height: 43px !important;
    height: 43px;
  
}

.aq-floating-gift-box {
    position: absolute;
    width: 30px;
    height: 30px;
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 12px;
    backdrop-filter: blur(5px);
    z-index: 2;
    display: flex;
    align-items: center;
    justify-content: center;
    color: rgba(255, 255, 255, 0.15);
    font-size: 12px;
    pointer-events: none;
}

#variant-images-container,
#variant-thumbs-container {
    display: contents;
}
#variant-images-container,
#variant-thumbs-container {
    display: contents;
}

/* Baseline (desktop) — recreates the gap-4 spacing */
.aq-gallery-slides {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

/* ══════════════════════════════════════════════
   VARIANT AVAILABILITY — diagonal line for "not
   available in this color" + small "Sold Out"
   label for "available combo but zero stock"
   ══════════════════════════════════════════════ */
.variant-option-unavailable {
    position: relative !important;
    opacity: 0.4 !important;
    pointer-events: none !important;
    cursor: not-allowed !important;
}
.variant-option-unavailable::after {
    content: '';
    position: absolute;
    left: 3px;
    right: 3px;
    top: 50%;
    height: 1px;
    background: #999;
    transform: rotate(-18deg);
    pointer-events: none;
}

.variant-option-soldout {
    position: relative !important;
    opacity: 0.55 !important;
    pointer-events: none !important;
    cursor: not-allowed !important;
}
.aq-soldout-label {
    position: absolute;
    bottom: 2px;
    left: 50%;
    transform: translateX(-50%);
    font-size: 8px;
    line-height: 1;
    font-weight: 700;
    letter-spacing: .2px;
    color: #b3261e;
    text-transform: uppercase;
    white-space: nowrap;
    pointer-events: none;
}
/* radio/image swatch labels need extra bottom room so the label
   doesn't collide with the size text */
.aq-radio-option.variant-option-soldout,
.aq-image-swatch.variant-option-soldout {
    padding-bottom: 16px;
}

/* ══════════════════════════════════════════════
   MOBILE — Image Slider + Sticky disable + 2-col grid
   Single, flat 991.98px block — no nesting
   ══════════════════════════════════════════════ */
@media (max-width: 991.98px) {

    .aq-gallery-slides {
        display: flex;
        flex-direction: row;
        flex-wrap: nowrap;
        overflow-x: auto;
        scroll-snap-type: x mandatory;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
        gap: 0;
    }
    .aq-gallery-slides::-webkit-scrollbar { display: none; }

    .aq-gallery-slides .aq-gallery-main-img-wrap {
        flex: 0 0 100%;
        min-width: 100%;
        scroll-snap-align: start;
        margin: 0;
    }
    .aq-gallery-slides .aq-gallery-main-img,
    .aq-gallery-slides video {
        width: 100%;
        aspect-ratio: 3 / 4;
        object-fit: cover;
        border-radius: 0 !important;
    }

    .aq-product-gallery > .d-lg-none.aq-gallery-thumbs {
        display: none !important;
    }

    .aq-gallery-dots {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 7px;
        padding: 14px 0 4px;
    }
    .aq-gallery-dots .aq-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #d9d9d9;
        border: none;
        padding: 0;
        cursor: pointer;
        transition: all .25s ease;
    }
    .aq-gallery-dots .aq-dot.active {
        background: #333;
        width: 8px;
        height: 8px;
    }

    .aq-product-details-summary {
        padding-top: 4px;
    }
    .design-title {
        font-size: 19px;
    }
    .aq-details-price-box {
        margin-top: 4px;
    }

    /* Sticky OFF on mobile — everything just stacks normally */
    .aq-product-details-area .aq-sticky-column {
        position: static !important;
    }
}

/* ══════════════════════════════════════════════
   MOBILE — 2-column New Arrivals / Related Products cards
   Separate 575.98px block — only once, not nested
   ══════════════════════════════════════════════ */
@media (max-width: 575.98px) {

    .aq-new-arrivals-section .aq-product-card-desc,
    .aq-related-products-section .aq-product-card-desc,
    .aq-new-arrivals-section .aq-product-card-sizes,
    .aq-related-products-section .aq-product-card-sizes {
        display: none !important;
    }

    .aq-new-arrivals-section .col,
    .aq-related-products-section .col {
        display: flex;
    }
    .aq-new-arrivals-section .aq-product-card,
    .aq-related-products-section .aq-product-card {
        width: 100%;
        display: flex;
        flex-direction: column;
    }
    .aq-new-arrivals-section .aq-product-card-info,
    .aq-related-products-section .aq-product-card-info {
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .aq-new-arrivals-section .aq-product-card-title,
    .aq-related-products-section .aq-product-card-title {
        font-size: 13.5px;
        line-height: 1.35;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 2.7em;
    }

    .aq-new-arrivals-section .aq-product-card-bottom,
    .aq-related-products-section .aq-product-card-bottom {
        margin-top: auto;
        padding-top: 10px;
    }

    .aq-new-arrivals-section .aq-product-card-price-group,
    .aq-related-products-section .aq-product-card-price-group {
        display: flex;
        flex-wrap: wrap;
        align-items: baseline;
        column-gap: 6px;
        row-gap: 2px;
    }
    .aq-new-arrivals-section .aq-product-card-price,
    .aq-related-products-section .aq-product-card-price {
        font-size: 15px;
    }
    .aq-new-arrivals-section .aq-product-card-old-price,
    .aq-related-products-section .aq-product-card-old-price {
        font-size: 12px;
    }
    .aq-new-arrivals-section .aq-product-card-discount,
    .aq-related-products-section .aq-product-card-discount {
        font-size: 10.5px;
        font-weight: 600;
        color: #000 !important;
        white-space: nowrap;
        flex-basis: 100%;
        width: fit-content;
        background-color: #f8f2e9;
        padding: 2px 8px;
        border-radius: 20px;
        margin-top: 3px;
        letter-spacing: 0.3px;
    }

    .aq-new-arrivals-section .aq-product-card-cta,
    .aq-related-products-section .aq-product-card-cta {
        font-size: 11px;
        letter-spacing: 0.3px;
        padding: 9px 6px;
        gap: 6px;
        white-space: nowrap;
    }
    .aq-new-arrivals-section .aq-product-card-cta i,
    .aq-related-products-section .aq-product-card-cta i {
        font-size: 12px;
    }

}
    </style>

    <main>

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
                <!--<h1 class="aq-catpage-title">{{ $product->name }}</h1>-->
                
                
                
               <div class="aq-catpage-breadcrumbs">
    <a href="{{ route('home') }}">Home</a>
    <span>/</span>
    <a href="{{ route('products.listing', $product->category->slug) }}">
        {{ $product->category->name }}
    </a>
    <span class="d-none d-md-inline">/</span>
    <span class="current d-none d-md-inline">
        {{ $product->name }}
    </span>
</div>
                
                
                
            </div>
        </section> 


        <!-- 1. Luxury Product Details Container -->
        <section class="aq-product-details-area pt-50 pb-60">
            <div class="container-fluid px-4 px-xl-5">
                <!-- Elegant Breadcrumbs -->
             <!--   <div class="aq-details-breadcrumbs mb-40">
                    <a href="{{ route('home') }}">Home</a>
                    <span class="divider">/</span>
                    <a href="{{ route('products.listing', $product->category->slug) }}">
                        {{ $product->category->name }}
                    </a>
                    <span class="divider">/</span>
                    <span class="current">
                        {{ $product->name }}
                    </span>
                </div> -->

                <div class="row g-5 justify-content-between">

                    <!-- Left Column: Thumbnails (Sticky) -->
                    <div class="col-lg-1 d-none d-lg-block">
                        <div class="aq-sticky-column">
                            <div class="aq-gallery-thumbs d-flex flex-column h-100">
                                <div id="variant-thumbs-container"></div>
                                @foreach($product->images as $index => $image)
                                    <div class="aq-gallery-thumb-item {{ $index == 0 ? 'active' : '' }}" onclick="document.getElementById('main-img-{{ $index }}').scrollIntoView({behavior: 'smooth', block: 'center'})">
                                        <img src="{{ asset('storage/' . ($image->thumb ?? $image->image)) }}" alt="{{ $product->name }}" />
                                    </div>
                                @endforeach

                                @foreach($product->videos as $index => $video)
                                    <div class="aq-gallery-thumb-item aq-gallery-thumb-video" onclick="document.getElementById('main-video-{{ $index }}').scrollIntoView({behavior: 'smooth', block: 'center'})">
                                        <img src="{{ $product->display_image }}" alt="{{ $product->name }} video" />
                                        <span class="aq-thumb-play-icon"><i class="fa-solid fa-play"></i></span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    
                    <!-- Middle Column: Main Images Stacked (Scrollable) -->
                    <div class="col-lg-7 col-md-12">
                        <div class="aq-product-gallery position-relative d-flex flex-column gap-4">
                            <div class="aq-gallery-badge-wrap position-absolute" style="top: 10px; left: 10px; z-index: 10;">
                                @foreach($product->collections->take(2) as $index => $collection)
                                    <span class="aq-gallery-badge {{ $index == 0 ? 'bestseller' : 'logo-branding' }}">
                                        {{ $collection->name }}
                                    </span>
                                @endforeach
                            </div>

                            <!-- Variant preview image — populated when a color/image variant is selected -->
                            <div class="aq-gallery-slides" id="aqGallerySlides">
                            <div id="variant-images-container"></div>

                            <!-- All Images Stacked -->
                            @foreach($product->images as $index => $image)
                                <div class="aq-gallery-main-img-wrap" id="main-img-{{ $index }}">
                                    <img src="{{ asset('storage/' . $image->image) }}" alt="{{ $product->name }}"
                                        class="aq-gallery-main-img" style="width: 100%; border-radius: 8px; object-fit: cover;" />
                                </div>
                            @endforeach

                            <!-- All Videos Stacked -->
                            @foreach($product->videos as $index => $video)
                                <div class="aq-gallery-main-img-wrap" id="main-video-{{ $index }}">
                                    <video src="{{ asset('storage/' . $video->video) }}" style="width: 100%; border-radius: 8px; object-fit: cover;" controls playsinline></video>
                                </div>
                            @endforeach
                            </div>

<!-- Mobile-only dot indicators (JS-populated) -->
<div class="aq-gallery-dots d-lg-none" id="aqGalleryDots"></div>
                            
                            <!-- Mobile Thumbnails -->
                            <div class="d-lg-none aq-gallery-thumbs d-flex flex-row overflow-auto mt-3">
                                @foreach($product->images as $index => $image)
                                    <div class="aq-gallery-thumb-item {{ $index == 0 ? 'active' : '' }}" onclick="document.getElementById('main-img-{{ $index }}').scrollIntoView({behavior: 'smooth', block: 'center'})">
                                       <img src="{{ asset('storage/' . ($image->thumb ?? $image->image)) }}" alt="{{ $product->name }}" />
                                        
                                    </div>
                                @endforeach
                                @foreach($product->videos as $index => $video)
                                    <div class="aq-gallery-thumb-item aq-gallery-thumb-video" onclick="document.getElementById('main-video-{{ $index }}').scrollIntoView({behavior: 'smooth', block: 'center'})">
                                        <img src="{{ $product->display_image }}" alt="{{ $product->name }} video" />
                                        <span class="aq-thumb-play-icon"><i class="fa-solid fa-play"></i></span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- SUITABLE FOR SELECTIONS — Desktop only (mobile version moved below Buy buttons) -->
                        <div class="aq-details-suitable-wrap mt-40 mb-20 d-none d-lg-block">
                            <h5 class="aq-details-suitable-title">
                                <i class="fa-solid fa-check-double"></i> Perfectly Suited For
                            </h5>

                            <!-- Occasions Grid -->
                            <div class="aq-details-suitable-grid">
                                @foreach($product->occasions as $occasion)
                                    <div class="aq-details-suitable-item">
                                        <div class="aq-details-suitable-icon">
                                            <i class="fa-solid fa-gift"></i>
                                        </div>
                                        <span>{{ $occasion->title }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        
                       <!-- Trust Badges Section — Desktop only (mobile version moved below Buy buttons) -->
                        <div class="aq-luxury-trust-badges d-none d-lg-block">
                            @if($product->pan_india)
                                <div class="aq-trust-badge-item">
                                    <span class="aq-trust-badge-icon">
                                        <i class="fa-solid fa-truck-fast"></i>
                                    </span>
                                    <div class="aq-trust-badge-content">
                                        <span class="aq-trust-badge-text">PAN India Delivery</span>
                                        <span class="aq-trust-badge-sub">{{ $product->delivery_time ?: 'Express Shipping Available' }}</span>
                                    </div>
                                </div>
                            @endif

                            @if($product->quality)
                                <div class="aq-trust-badge-item">
                                    <span class="aq-trust-badge-icon">
                                        <i class="fa-solid fa-circle-check"></i>
                                    </span>
                                    <div class="aq-trust-badge-content">
                                        <span class="aq-trust-badge-text">100% Quality Audited</span>
                                        <span class="aq-trust-badge-sub">Strict Assurance Audit</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Right Column: Product Specs & Ordering Drawer Trigger -->
                    <div class="col-lg-4 col-12">
                        <div class="aq-sticky-column" style="padding-right: 10px;">
                        
                        
                        
                        <div class="aq-product-details-summary">
                            <span class="design-brand">
                                {{ $product->subcategory->name ?? $product->category->name }}
                            </span>
                            <h2 class="design-title">
                                {{ $product->name }}
                            </h2>
                            <!--<span class="design-tax-info">Inclusive of all taxes.</span>-->

                          

                            <!-- Pricing box -->
                             <div class="aq-details-price-box p-3 mb-25" id="aqPriceBox"
                                  style="{{ $detailStock >= $product->min_qty ? '' : 'display:none' }}">
                                <div class="d-flex flex-column gap-1">
                                    @php
                                        $discount = ($product->mrp > 0 && $product->mrp > $product->price)
                                            ? round((($product->mrp - $product->price) / $product->mrp) * 100)
                                            : 0;
                                    @endphp

                                    <div class="aq-price-mrp-row d-flex align-items-center gap-2 mb-2"
                                         id="priceMrpRow"
                                         style="{{ $discount > 0 ? '' : 'display:none !important' }}">
                                        <span class="mrp-label">
                                            <span class="mrp-value" id="productMrp">
                                                ₹{{ number_format($product->mrp) }}
                                            </span>
                                        </span>
                                        <span class="discount-badge" id="productDiscount">
                                            {{ $discount }}% OFF
                                        </span>
                                    </div>

                                    <div class="aq-price-offered-row d-flex align-items-baseline gap-2">
                                        <span class="aq-details-price" id="productPrice">
                                            ₹{{ number_format($product->price) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="aq-moq-info-list">
                                    <p class="mb-0">
                                        <i class="fa-solid fa-truck-fast"></i> Delivery Time:
                                        <strong>{{ $product->delivery_time }}</strong>
                                    </p>
                                </div>
                            </div>

                          
                            
                            <!-- Promo Discount Box -->
                             <div class="coupon-container" id="couponContainer"></div>
                            

                            <p class="aq-details-short-desc">
                                {{ $product->short_description }}
                            </p>
                              {{-- Info rows: every attribute (variant-backed or not) that's NOT selectable --}}
    @foreach($variantAttributes as $attributeId => $attribute)

        @if(!$attribute['is_selectable'])
  
                            
                           <div class="aq-creative-details-block mt-25 mb-30">


            <div class="aq-detail-item">
                <div class="aq-detail-content">
                    <span class="aq-detail-label">
                        {{ strtoupper($attribute['name']) }}
                    </span>
                    <span class="aq-detail-value">
                        {{ collect($attribute['values'])->pluck('value')->implode(', ') }}
                    </span>
                </div>
            </div>

            {{-- Only variant-backed attributes need the hidden matching button —
                 non-variant attributes have no price/image/stock/sku dependency,
                 so there's nothing for the JS matcher to key off of. --}}
            @if($attribute['has_variant'] ?? true)
                <button type="button" class="variant-option active d-none"
                    data-attribute-id="{{ $attributeId }}"
                    data-value-id="{{ $attribute['default_value_id'] }}"
                    data-price-dependent="{{ !empty($attribute['price_dependent']) ? 1 : 0 }}"
                    data-image-dependent="{{ !empty($attribute['image_dependent']) ? 1 : 0 }}"
                    data-stock-dependent="{{ !empty($attribute['stock_dependent']) ? 1 : 0 }}"
                    data-sku-dependent="{{ !empty($attribute['sku_dependent']) ? 1 : 0 }}"></button>
            @endif

            
        </div>
        @endif

    @endforeach



<!-- Co-Branding Customizer -->
<!-- Size / Variant Selection -->
@foreach($variantAttributes as $attributeId => $attribute)

    @if($attribute['is_selectable'])

        <div class="aq-size-selection-panel mb-3">

            <div class="d-flex align-items-center justify-content-between mb-2">
                <h5 class="aq-size-title mb-0">
                    {{ $attribute['name'] }}
                </h5>

                @if($sizeChartImage && $loop->first)
                    <button type="button" class="aq-size-chart-link"
                        data-bs-toggle="modal" data-bs-target="#sizeChartModal">
                        <i class="fa-regular fa-image"></i> Size Chart
                    </button>
                @endif
            </div>

            @switch($attribute['type'])

                {{-- Dropdown: real <select> for UX, driven by hidden proxy
                     buttons so the existing click-based JS logic stays
                     completely untouched. --}}
                @case('dropdown')
                    <select class="form-select aq-size-dropdown" data-attribute-id="{{ $attributeId }}">
                        <option value="" disabled selected>Select {{ $attribute['name'] }}</option>
                        @foreach($attribute['values'] as $valueId => $value)
                            <option value="{{ $valueId }}" data-original-text="{{ $value['value'] }}">{{ $value['value'] }}</option>
                        @endforeach
                    </select>
                    <div class="d-none">
                        @foreach($attribute['values'] as $valueId => $value)
                            <button type="button" class="variant-option"
                                data-attribute-id="{{ $attributeId }}"
                                data-value-id="{{ $valueId }}"
                                data-price-dependent="{{ !empty($attribute['price_dependent']) ? 1 : 0 }}"
                                data-image-dependent="{{ !empty($attribute['image_dependent']) ? 1 : 0 }}"
                                data-stock-dependent="{{ !empty($attribute['stock_dependent']) ? 1 : 0 }}"
                                data-sku-dependent="{{ !empty($attribute['sku_dependent']) ? 1 : 0 }}"></button>
                        @endforeach
                    </div>
                    @break

                @case('color_swatch')
                    <div class="aq-product-size-row d-flex flex-wrap gap-2">
                        @foreach($attribute['values'] as $valueId => $value)
                            <button type="button" class="aq-color-swatch variant-option"
                                title="{{ $value['value'] }}"
                                data-attribute-id="{{ $attributeId }}"
                                data-value-id="{{ $valueId }}"
                                data-price-dependent="{{ !empty($attribute['price_dependent']) ? 1 : 0 }}"
                                data-image-dependent="{{ !empty($attribute['image_dependent']) ? 1 : 0 }}"
                                data-stock-dependent="{{ !empty($attribute['stock_dependent']) ? 1 : 0 }}"
                                data-sku-dependent="{{ !empty($attribute['sku_dependent']) ? 1 : 0 }}">
                                <span class="aq-color-swatch-inner" style="background-color: {{ $value['hex_code'] ?: '#ccc' }};"></span>
                            </button>
                        @endforeach
                    </div>
                    @break

                @case('image')
                    <div class="aq-product-size-row gap-2">
                        @foreach($attribute['values'] as $valueId => $value)
                            <button type="button" class="aq-image-swatch variant-option"
                                title="{{ $value['value'] }}"
                                data-attribute-id="{{ $attributeId }}"
                                data-value-id="{{ $valueId }}"
                                data-price-dependent="{{ !empty($attribute['price_dependent']) ? 1 : 0 }}"
                                data-image-dependent="{{ !empty($attribute['image_dependent']) ? 1 : 0 }}"
                                data-stock-dependent="{{ !empty($attribute['stock_dependent']) ? 1 : 0 }}"
                                data-sku-dependent="{{ !empty($attribute['sku_dependent']) ? 1 : 0 }}">
                                @if($value['image'])
                                    <img src="{{ asset('storage/' . $value['image']) }}" alt="{{ $value['value'] }}">
                                @else
                                    {{ $value['value'] }}
                                @endif
                            </button>
                        @endforeach
                    </div>
                    @break

                @case('radio')
                    <div class="aq-product-size-row gap-3">
                        @foreach($attribute['values'] as $valueId => $value)
                            <label class="aq-radio-option variant-option"
                                data-attribute-id="{{ $attributeId }}"
                                data-value-id="{{ $valueId }}"
                                data-price-dependent="{{ !empty($attribute['price_dependent']) ? 1 : 0 }}"
                                data-image-dependent="{{ !empty($attribute['image_dependent']) ? 1 : 0 }}"
                                data-stock-dependent="{{ !empty($attribute['stock_dependent']) ? 1 : 0 }}"
                                data-sku-dependent="{{ !empty($attribute['sku_dependent']) ? 1 : 0 }}">
                                <input type="radio" name="attr_{{ $attributeId }}"> {{ $value['value'] }}
                            </label>
                        @endforeach
                    </div>
                    @break

                {{-- 'button' and any unknown type fall back to the original look --}}
                @default
                    <div class="aq-product-size-row gap-2">
                        @foreach($attribute['values'] as $valueId => $value)
                            <button type="button" class="aq-size-badge variant-option"
                                data-attribute-id="{{ $attributeId }}"
                                data-value-id="{{ $valueId }}"
                                data-price-dependent="{{ !empty($attribute['price_dependent']) ? 1 : 0 }}"
                                data-image-dependent="{{ !empty($attribute['image_dependent']) ? 1 : 0 }}"
                                data-stock-dependent="{{ !empty($attribute['stock_dependent']) ? 1 : 0 }}"
                                data-sku-dependent="{{ !empty($attribute['sku_dependent']) ? 1 : 0 }}">
                                {{ $value['value'] }}
                            </button>
                        @endforeach
                    </div>
            @endswitch

        </div>

    @endif

@endforeach




@if($product->addons->isNotEmpty())
<div class="aq-stitching-box">

    <div class="card aq-stitch-card">

        <div class="card-body">

            <h2 class="aq-title">
               Choose Add ons?
            </h2>

            <p class="aq-subtitle">
                Choose Your Style
            </p>

            <div class="row g-2">

                @foreach($product->addons as $addon)

                    <div class="col-lg-6">

                        <label class="aq-option">

                            <input type="checkbox" class="aq-addon-option"
                                data-addon-id="{{ $addon->id }}"
                                data-addon-price="{{ $addon->price }}">

                            <span class="aq-checkbox"></span>

                            <span class="aq-text">
                                {{ $addon->detail }}
                                <strong>(+₹{{ number_format($addon->price, 2) }})</strong>
                            </span>

                        </label>

                    </div>

                @endforeach

            </div>

        </div>

    </div>

</div>
@endif

                            <!-- Interactive Quantity and Action -->
                            <div class=" mb-30 mt-30">
                                <div class="d-flex flex-column gap-2 w-100">
                                    <div class="aq-qty-selector luxury-qty d-flex align-items-center justify-content-center gap-3">
                                        <button type="button" class="qty-btn" onclick="aqAdjustQty(-1)"><i
                                                class="fa-solid fa-minus"></i></button>
                                  
                                        <input type="number" id="aqDetailQty" value="{{ $product->min_qty }}"
    min="{{ $product->min_qty }}" max="{{ $detailStock }}" />

<span id="currentStock" class="d-none">
    {{ $detailStock }}
</span>
                                        <button type="button" class="qty-btn" onclick="aqAdjustQty(1)"><i
                                                class="fa-solid fa-plus"></i></button>
                                    </div>
                                   @if($detailStock >= $product->min_qty)
    <button type="button"
        class="btn-design-primary aq-add-to-cart-btn"
        onclick="addToCart({{ $product->id }})">
        Add to Cart
    </button>
@else
    <button type="button" class="btn-design-primary" disabled
        style="background:#999;cursor:not-allowed;">
        Out of Stock
    </button>
@endif
                                    
                                   @if($detailStock >= $product->min_qty)
<button class="btn-design-secondary aq-buy-now-btn"
    onclick="addToCart({{ $product->id }})">
    <i class="fa-brands fa-whatsapp" style="font-size:18px;"></i> Buy it Now
</button>
@else
<button class="btn-design-secondary" disabled
    style="cursor:not-allowed;">
    Out of Stock
</button>
@endif
                                </div>
                            </div>
                        </div>

                        <!-- Mobile-only: Suitable For + Trust Badges (shown here so product info comes right after images) -->
                        <div class="d-lg-none">
                            <div class="aq-details-suitable-wrap mt-30 mb-20">
                                <h5 class="aq-details-suitable-title">
                                    <i class="fa-solid fa-check-double"></i> Perfectly Suited For
                                </h5>
                                <div class="aq-details-suitable-grid">
                                    @foreach($product->occasions as $occasion)
                                        <div class="aq-details-suitable-item">
                                            <div class="aq-details-suitable-icon">
                                                <i class="fa-solid fa-gift"></i>
                                            </div>
                                            <span>{{ $occasion->title }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="aq-luxury-trust-badges">
                                @if($product->pan_india)
                                    <div class="aq-trust-badge-item">
                                        <span class="aq-trust-badge-icon">
                                            <i class="fa-solid fa-truck-fast"></i>
                                        </span>
                                        <div class="aq-trust-badge-content">
                                            <span class="aq-trust-badge-text">PAN India Delivery</span>
                                            <span class="aq-trust-badge-sub">{{ $product->delivery_time ?: 'Express Shipping Available' }}</span>
                                        </div>
                                    </div>
                                @endif

                                @if($product->quality)
                                    <div class="aq-trust-badge-item">
                                        <span class="aq-trust-badge-icon">
                                            <i class="fa-solid fa-circle-check"></i>
                                        </span>
                                        <div class="aq-trust-badge-content">
                                            <span class="aq-trust-badge-text">100% Quality Audited</span>
                                            <span class="aq-trust-badge-sub">Strict Assurance Audit</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                       <div class="aq-product-accordion " >
                       <div class="accordion design-accordion pt-30 " id="productAccordion">

    <!-- Full Description -->
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingDesc">
            <button class="accordion-button collapsed" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#collapseDesc"
                aria-expanded="false"
                aria-controls="collapseDesc">
                Full Description
            </button>
        </h2>

        <div id="collapseDesc"
            class="accordion-collapse collapse"
            aria-labelledby="headingDesc"
            data-bs-parent="#productAccordion">
            <div class="accordion-body">
                {!! $product->description !!}
            </div>
        </div>
    </div>

    <!-- Fabric & Care -->
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingBrand">
            <button class="accordion-button collapsed"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#collapseBrand"
                aria-expanded="false"
                aria-controls="collapseBrand">
                Fabric & Care
            </button>
        </h2>

        <div id="collapseBrand"
            class="accordion-collapse collapse"
            aria-labelledby="headingBrand"
            data-bs-parent="#productAccordion">
            <div class="accordion-body">
                {!! $product->fabric_care !!}
            </div>
        </div>
    </div>

    <!-- Shipping & Delivery -->
    @if($product->shipping_delivery)
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingShipping">
            <button class="accordion-button collapsed"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#collapseShipping"
                aria-expanded="false"
                aria-controls="collapseShipping">
                Shipping & Delivery
            </button>
        </h2>

        <div id="collapseShipping"
            class="accordion-collapse collapse"
            aria-labelledby="headingShipping"
            data-bs-parent="#productAccordion">
            <div class="accordion-body">
                {!! $product->shipping_delivery !!}
            </div>
        </div>
    </div>
    @endif

    <!-- Exchange Policy -->
    @if($product->exchange_policy)
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingExchange">
            <button class="accordion-button collapsed"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#collapseExchange"
                aria-expanded="false"
                aria-controls="collapseExchange">
                Exchange Policy
            </button>
        </h2>

        <div id="collapseExchange"
            class="accordion-collapse collapse"
            aria-labelledby="headingExchange"
            data-bs-parent="#productAccordion">
            <div class="accordion-body">
                {!! $product->exchange_policy !!}
            </div>
        </div>
    </div>
    @endif

    <!-- Customization / Assistance -->
    @if($product->customization_assistance)
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingCustomization">
            <button class="accordion-button collapsed"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#collapseCustomization"
                aria-expanded="false"
                aria-controls="collapseCustomization">
                Customization / Assistance
            </button>
        </h2>

        <div id="collapseCustomization"
            class="accordion-collapse collapse"
            aria-labelledby="headingCustomization"
            data-bs-parent="#productAccordion">
            <div class="accordion-body">
                {!! $product->customization_assistance !!}
            </div>
        </div>
    </div>
    @endif


    @if($setting && $setting->product_reviews)
    <!-- Reviews -->
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingReviews">
            <button class="accordion-button collapsed"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#collapseReviews"
                aria-expanded="false"
                aria-controls="collapseReviews">
                Reviews ({{ $reviewsCount }})
            </button>
        </h2>

        <div id="collapseReviews"
            class="accordion-collapse collapse"
            aria-labelledby="headingReviews"
            data-bs-parent="#productAccordion">
            <div class="accordion-body">

                <h4 class="aq-tab-heading">Customer Reviews</h4>

                @if($reviews->isEmpty())
                    <p class="aq-tab-text">No reviews yet for this product.</p>
                @else

                    @foreach($reviews as $review)

                        <div class="aq-review-item mb-30 pb-3 border-bottom">

                            <div class="d-flex justify-content-between align-items-start">

                                <div>
                                    <div class="aq-review-stars mb-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fa-{{ $i <= $review->rating ? 'solid' : 'regular' }} fa-star"></i>
                                        @endfor
                                    </div>

                                    <strong class="aq-review-title">
                                        {{ $review->title }}
                                    </strong>
                                </div>

                                @if($review->verified_purchase)
                                    <span class="badge bg-success">
                                        Verified Purchase
                                    </span>
                                @endif

                            </div>

                            <p class="aq-review-body mt-2 mb-2">
                                {{ $review->review }}
                            </p>

                            @if($review->images->isNotEmpty())

                                <div class="aq-review-images d-flex gap-2 mb-2">

                                    @foreach($review->images as $image)

                                        <img src="{{ asset('storage/' . $image->image) }}"
                                            alt="Review image"
                                            style="width:70px;height:70px;object-fit:cover;border-radius:6px;">

                                    @endforeach

                                </div>

                            @endif

                            <span class="text-muted small">
                                {{ $review->customer->name ?? 'Anonymous' }} ·
                                {{ $review->created_at->format('d M Y') }}
                            </span>

                        </div>

                    @endforeach

                    <div class="mt-30">
                        {{ $reviews->links() }}
                    </div>

                @endif

            </div>
        </div>
    </div>
    @endif

</div>
                        </div> <!-- End Right Column Sticky -->
                    </div>

                </div>
        </section>

        <!-- 2. New Arrivals Section -->
        <section class="aq-new-arrivals-section pt-60 pb-60">
            <div class="container">
                <div class="row align-items-center mb-40">
                    <div class="col-12 text-center">
                        <div class="aq-creative-title-box">
                            <span class="aq-creative-subtitle">Our Latest Collections</span>
                            <h2 class="aq-creative-title">New Arrivals</h2>
                            <div class="aq-creative-title-line"></div>
                        </div>
                    </div>
                </div>
                <div class="row row-cols-xl-4 row-cols-lg-3 row-cols-sm-2 row-cols-2 g-4 justify-content-center last_child_hide_in_tabs">
                    @foreach($newArrivals as $newArrival)

                        @php
                            $otherImages = $newArrival->images
                                ->where('is_default', 0)
                                ->values();
                                
    $newArrivalStock = $newArrival->variants->count()
        ? $newArrival->variants->where('type', 'stock')->sum('stock')
        : $newArrival->stock;
@endphp

                        <div class="col">
                            <div class="aq-product-card" data-category="onboarding" data-price="1899">
                                <div class="aq-product-card-top">
                                    <div class="aq-product-media-wrapper">

                                        <img src="{{ $newArrival->display_image }}" class="aq-product-card-img primary-img"
                                            alt="{{ $newArrival->name }}" />
                                            
<img src="{{ isset($otherImages[0]) ? asset('storage/' . ($otherImages[0]->thumb ?? $otherImages[0]->image)) : $newArrival->display_image }}"
    class="secondary-img" alt="{{ $newArrival->name }}" />

<img src="{{ isset($otherImages[1]) ? asset('storage/' . ($otherImages[1]->thumb ?? $otherImages[1]->image)) : $newArrival->display_image }}"
    class="tertiary-img" alt="{{ $newArrival->name }}" />


                                        <video src="{{ asset('assets/img/corporate/reals_video.mp4') }}"
                                            class="aq-product-card-video" muted loop playsinline>
                                        </video>

                                        <div class="aq-product-media-indicator">
                                            <span class="aq-media-dot active"></span>
                                            <span class="aq-media-dot"></span>
                                            <span class="aq-media-dot"></span>
                                            <span class="aq-media-dot"></span>
                                        </div>

                                    </div>
                                    @if($newArrival->collections->isNotEmpty())
                                        <div class="aq-product-badges">
                                            <span class="aq-product-badge bestseller">
                                                {{ $newArrival->collections->first()->name }}
                                            </span>
                                        </div>
                                    @endif

                                    <div class="aq-product-brand-badge">
                                        <img src="{{ $newArrival->display_image }}" alt="{{ $newArrival->name }}" />
                                    </div>

                                    <div class="aq-product-actions">
                                        <button class="aq-product-action-btn" title="Quick Consultation"
                                            onclick="openGlobalDrawer('about_page')">
                                            <i class="fa-regular fa-envelope"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="aq-product-card-info">
                                    <span class="aq-product-card-brand-name">
                                        {{ $newArrival->subcategory->name ?? $newArrival->category->name }}
                                    </span>

                                    <h4 class="aq-product-card-title">
                                        <a href="{{ route('product.details', $newArrival->slug) }}">
                                            {{ $newArrival->name }}
                                        </a>
                                    </h4>
                                    <p class="aq-product-card-desc">
                                        {{ \Illuminate\Support\Str::limit(strip_tags($newArrival->short_description), 80) }}
                                    </p>

                                    <div class="aq-product-card-price-group">
  @if($newArrivalStock >= $newArrival->min_qty)
                                        <span class="aq-product-card-price">
                                            ₹{{ number_format($newArrival->price) }}
                                        </span>

                                        @if($newArrival->mrp > $newArrival->price)
                                            <span class="aq-product-card-old-price">
                                                ₹{{ number_format($newArrival->mrp) }}
                                            </span>

                                            <span class="aq-product-card-discount">
    (You Save {{ round((($newArrival->mrp - $newArrival->price) / $newArrival->mrp) * 100) }}% Off)
</span>
                                         @endif
                                        @endif

                                    </div>
                                   @php
    $listingAttributes = \App\Models\CategoryAttribute::where('category_id', $newArrival->category_id)
        ->where('show_on_listing', 1)
        ->pluck('attribute_id')
        ->toArray();

    $listingValues = $newArrival->attributeValues
        ->whereIn('attribute_id', $listingAttributes);

    $groupedValues = $listingValues->groupBy('attribute_id');

@endphp

@if($groupedValues->count())
    @foreach($groupedValues as $attributeValues)
        <a href="{{ route('product.details', $newArrival->slug) }}"
           style="text-decoration:none;color:inherit;">
            <div class="aq-product-card-sizes">
                @foreach($attributeValues as $attributeValue)
                    <span class="aq-size-badge">
                        {{ $attributeValue->value->value }}
                    </span>
                @endforeach
            </div>
        </a>
    @endforeach
@endif
                                   <div class="aq-product-card-bottom">
    @if($newArrivalStock >= $newArrival->min_qty)
        <button class="aq-product-card-cta"
                onclick="addToCartCard({{ $newArrival->id }}, {{ $newArrival->min_qty }}, this)">
            <i class="fa-solid fa-cart-shopping"></i> Add to Cart
        </button>
    @else
        <button class="aq-product-card-cta" disabled style="background:#999;cursor:not-allowed;">
            <i class="fa-solid fa-ban"></i> Sold Out
        </button>
    @endif
</div>
                                </div>
                            </div>
                        </div>

                    @endforeach

                </div>
            </div>
        </section>

        <!-- 3. Related Products Section -->
        <section class="aq-related-products-section pt-60 pb-60">
            <div class="container">
                <div class="row align-items-center mb-40">
                    <div class="col-12 text-center">
                        <div class="aq-creative-title-box">
                            <span class="aq-creative-subtitle">View Other Products</span>
                            <h2 class="aq-creative-title">Related Products</h2>
                            <div class="aq-creative-title-line"></div>
                        </div>
                    </div>
                </div>
                <div class="row row-cols-xl-4 row-cols-lg-3 row-cols-sm-2 row-cols-2 g-4 justify-content-center last_child_hide_in_tabs">

                    @foreach($relatedProducts as $relatedProduct)

                        @php
                            $otherImages = $relatedProduct->images
                                ->where('is_default', 0)
                                ->values();
                                 $relatedStock = $relatedProduct->variants->count()
        ? $relatedProduct->variants->where('type', 'stock')->sum('stock')
        : $relatedProduct->stock;
                        @endphp

                        <div class="col">
                            <div class="aq-product-card" data-category="onboarding" data-price="1899">
                                <div class="aq-product-card-top">
                                    <div class="aq-product-media-wrapper">

                                        <img src="{{ $relatedProduct->display_image }}" class="aq-product-card-img primary-img"
                                            alt="{{ $relatedProduct->name }}" />

                                        <img src="{{ isset($otherImages[0]) ? asset('storage/' . $otherImages[0]->image) : $relatedProduct->display_image }}"
                                            class="secondary-img" alt="{{ $relatedProduct->name }}" />

                                        <img src="{{ isset($otherImages[1]) ? asset('storage/' . $otherImages[1]->image) : $relatedProduct->display_image }}"
                                            class="tertiary-img" alt="{{ $relatedProduct->name }}" />

                                        <video src="{{ asset('assets/img/corporate/reals_video.mp4') }}"
                                            class="aq-product-card-video" muted loop playsinline>
                                        </video>

                                        <div class="aq-product-media-indicator">
                                            <span class="aq-media-dot active"></span>
                                            <span class="aq-media-dot"></span>
                                            <span class="aq-media-dot"></span>
                                            <span class="aq-media-dot"></span>
                                        </div>

                                    </div>
                                    @if($relatedProduct->collections->isNotEmpty())
                                        <div class="aq-product-badges">
                                            <span class="aq-product-badge bestseller">
                                                {{ $relatedProduct->collections->first()->name }}
                                            </span>
                                        </div>
                                    @endif

                                    <div class="aq-product-brand-badge">
                                        <img src="{{ $relatedProduct->display_image }}" alt="{{ $relatedProduct->name }}" />
                                    </div>

                                    <div class="aq-product-actions">
                                        <button class="aq-product-action-btn" title="Quick Consultation"
                                            onclick="openGlobalDrawer('about_page')">
                                            <i class="fa-regular fa-envelope"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="aq-product-card-info">
                                    <span class="aq-product-card-brand-name">
                                        {{ $relatedProduct->subcategory->name ?? $relatedProduct->category->name }}
                                    </span>

                                    <h4 class="aq-product-card-title">
                                        <a href="{{ route('product.details', $relatedProduct->slug) }}">
                                            {{ $relatedProduct->name }}
                                        </a>
                                    </h4>
                                    <p class="aq-product-card-desc">
                                        {{ \Illuminate\Support\Str::limit(strip_tags($relatedProduct->short_description), 80) }}
                                    </p>

                                    <div class="aq-product-card-price-group">
 @if($relatedStock >= $relatedProduct->min_qty)
                                        <span class="aq-product-card-price">
                                            ₹{{ number_format($relatedProduct->price) }}
                                        </span>

                                        @if($relatedProduct->mrp > $relatedProduct->price)
                                            <span class="aq-product-card-old-price">
                                                ₹{{ number_format($relatedProduct->mrp) }}
                                            </span>

                                            <span class="aq-product-card-discount">
                                                ({{ round((($relatedProduct->mrp - $relatedProduct->price) / $relatedProduct->mrp) * 100) }}%
                                                OFF)
                                            </span>
                                        @endif
                                        @endif

                                        </div>
                                       @php
    $listingAttributes = \App\Models\CategoryAttribute::where('category_id', $relatedProduct->category_id)
        ->where('show_on_listing', 1)
        ->pluck('attribute_id')
        ->toArray();

    $listingValues = $relatedProduct->attributeValues
        ->whereIn('attribute_id', $listingAttributes);

    $groupedValues = $listingValues->groupBy('attribute_id');

@endphp

@if($groupedValues->count())
    @foreach($groupedValues as $attributeValues)
        <a href="{{ route('product.details', $relatedProduct->slug) }}"
           style="text-decoration:none;color:inherit;">
            <div class="aq-product-card-sizes">
                @foreach($attributeValues as $attributeValue)
                    <span class="aq-size-badge">
                        {{ $attributeValue->value->value }}
                    </span>
                @endforeach
            </div>
        </a>
    @endforeach
@endif

<div class="aq-product-card-bottom">
    @if($relatedStock >= $relatedProduct->min_qty)
        <button class="aq-product-card-cta"
                onclick="addToCartCard({{ $relatedProduct->id }}, {{ $relatedProduct->min_qty }}, this)">
            <i class="fa-solid fa-cart-shopping"></i> Add to Cart
        </button>
    @else
        <button class="aq-product-card-cta" disabled style="background:#999;cursor:not-allowed;">
            <i class="fa-solid fa-ban"></i> Sold Out
        </button>
    @endif
</div>
                                </div>
                            </div>
                        </div>

                    @endforeach

                </div>
            </div>
        </section>



    </main>

    <!-- Size Chart Modal -->
    @if($sizeChartImage)
    <div class="modal fade" id="sizeChartModal" tabindex="-1" aria-labelledby="sizeChartModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sizeChartModalLabel">Size Chart</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img src="{{ asset('storage/' . $sizeChartImage) }}" alt="Size Chart">
                </div>
            </div>
        </div>
    </div>
    @endif


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>

        const variantsByType = @json($variantsByType);
        const storageBaseUrl = "{{ asset('storage') }}";


        let selectedValues = [];
        let selectedAddonIds = [];
        let selectedAddonTotal = 0;

        // Single source of truth for the currently active unit price/mrp.
        // Always a plain number — updated by the variant click handler,
        // read by updatePriceDisplay(). Never read stale DOM state.
        let currentUnitPrice = {{ (float) $product->price }};
        let currentUnitMrp = {{ (float) $product->mrp }};


        const activeCoupons = @json($activeCoupons);

function renderBestCoupon(totalPriceForCoupon) {
  
    const $container = $('#couponContainer');

    if (!activeCoupons.length) {
        $container.html('');
        return;
    }

    // Sirf woh coupons jinka minimum_order_amount current total se satisfy ho raha hai
   const qty = parseInt($('#aqDetailQty').val()) || 1;

const eligible = activeCoupons.filter(function (c) {

    const amountEligible =
        !c.minimum_order_amount ||
        parseFloat(c.minimum_order_amount) <= totalPriceForCoupon;

    const quantityEligible =
        !c.minimum_order_quantity ||
        qty >= parseInt(c.minimum_order_quantity);

    return amountEligible && quantityEligible;
});

    if (!eligible.length) {
        $container.html('');
        return;
    }

    // Actual discount amount har eligible coupon ka nikal ke sabse zyada wala pick karo
    function actualDiscount(c) {
        let discount = 0;
        if (c.discount_type === 'percentage') {
            discount = (totalPriceForCoupon * parseFloat(c.discount_value)) / 100;
            if (c.maximum_discount) {
                discount = Math.min(discount, parseFloat(c.maximum_discount));
            }
        } else {
            discount = parseFloat(c.discount_value);
        }
        return discount;
    }

    let best = eligible[0];
    let bestAmount = actualDiscount(best);

    eligible.forEach(function (c) {
        const amt = actualDiscount(c);
        if (amt > bestAmount) {
            best = c;
            bestAmount = amt;
        }
    });

    let descText = '';
    if (best.discount_type === 'percentage') {
        descText = 'Get ' + parseFloat(best.discount_value) + '% off';
        if (best.maximum_discount) {
            descText += ' (up to ₹' + Math.round(best.maximum_discount).toLocaleString('en-IN') + ')';
        }
    } else {
        descText = 'Flat ₹' + Math.round(best.discount_value).toLocaleString('en-IN') + ' off';
    }
    if (best.minimum_order_amount) {
        descText += ' on orders above ₹' + Math.round(best.minimum_order_amount).toLocaleString('en-IN');
    }
    if (best.minimum_order_quantity) {
    descText += ' | Min Qty: ' + best.minimum_order_quantity;
}

    $container.html(`
        <div class="coupon-card" id="coupon-${best.code}" onclick="copyCouponCode('${best.code}')" style="cursor:pointer;">
          <div class="coupon-icon">
            <img src="https://cdn.shopify.com/s/files/1/0826/6157/2916/files/discount-44c58e749e567564fb2f555dff7651bd1440b89dd808b77e29f72cddeb818dfa.svg?v=1747926128" alt="Discount Icon">
          </div>
          <div class="coupon-details">
            <div class="coupon-code">USE CODE: ${best.code}</div>
            <div class="coupon-desc">${descText}</div>
          </div>
        </div>
    `);
}

function copyCouponCode(code) {
    navigator.clipboard.writeText(code).then(function () {
        Swal.fire({
            icon: 'success',
            title: 'Copied!',
            text: 'Coupon code "' + code + '" copied to clipboard.',
            timer: 1500,
            showConfirmButton: false
        });
    });
}

        // ── Auto-select the matching value of every OTHER selectable
// attribute when one is picked (e.g. Color=Blue → Size auto-picks
// XL if that's the only size Blue comes in) ─────────────────────
//
// The "master" combination list is whichever type array's entries
// carry the most attribute-value ids per combo — that's the
// fullest picture of which combinations are actually valid
// together (stock/sku almost always depend on every selectable
// attribute combined).
function getMasterVariantList() {
    let best = [];
    let bestAttrCount = -1;
    Object.keys(variantsByType).forEach(function (type) {
        const list = variantsByType[type] || [];
        if (list.length && Array.isArray(list[0].values)) {
            const attrCount = list[0].values.length;
            if (attrCount > bestAttrCount) {
                bestAttrCount = attrCount;
                best = list;
            }
        }
    });
    return best;
}

// ══════════════════════════════════════════════════════════════
// Combo availability — for every stock-dependent attribute value
// (typically Size), work out one of three states relative to the
// OTHER attributes currently selected (typically Color):
//
//   1. normal     — a combo exists and has stock  > 0
//   2. sold out   — a combo exists but its stock  <= 0   → small
//                   "Sold Out" label, option disabled
//   3. unavailable — no such combo exists at all for the current
//                    selection (e.g. size not offered in that
//                    color) → diagonal strike line, disabled
//
// Before any color is picked, we fall back to a simple "is this
// size sold out everywhere" check so the page still makes sense
// on first load.
// ══════════════════════════════════════════════════════════════
function updateComboAvailability() {
    const stockList = variantsByType['stock'] || [];
    if (!stockList.length) return;

    const attributeIds = [...new Set(
        $('.variant-option').map(function () { return $(this).data('attribute-id'); }).get()
    )];

    attributeIds.forEach(function (attrId) {

        const otherActiveValueIds = $('.variant-option.active')
            .filter(function () { return $(this).data('attribute-id') != attrId; })
            .map(function () { return parseInt($(this).data('value-id')); })
            .get();

        $('.variant-option[data-attribute-id="' + attrId + '"]').each(function () {
            const $opt = $(this);

            // Reset to a clean state first.
            $opt.removeClass('variant-option-unavailable variant-option-soldout');
            $opt.find('.aq-soldout-label').remove();

            const $ddOpt = $('.aq-size-dropdown[data-attribute-id="' + attrId + '"] option[value="' + $opt.data('value-id') + '"]');
            if ($ddOpt.length) {
                $ddOpt.prop('disabled', false).text($ddOpt.data('original-text'));
            }

            if ($opt.data('stock-dependent') != 1) return; // only relevant for the stock-driving attribute (Size)

            const valueId = parseInt($opt.data('value-id'));

            if (otherActiveValueIds.length === 0) {
                // Nothing else selected yet — just flag sizes that are
                // completely out of stock across every color/combo.
                const combosWithValue = stockList.filter(function (c) { return c.values.includes(valueId); });
                const totalStock = combosWithValue.reduce(function (sum, c) { return sum + (parseInt(c.stock) || 0); }, 0);

                if (combosWithValue.length && totalStock <= 0) {
                    markSoldOut($opt, $ddOpt);
                }
                return;
            }

            // A color (or other attribute) is selected — find the exact combo.
            const matchingCombo = stockList.find(function (combo) {
                if (!combo.values.includes(valueId)) return false;
                return otherActiveValueIds.every(function (id) { return combo.values.includes(id); });
            });

            if (!matchingCombo) {
                markUnavailable($opt, $ddOpt);
            } else if ((parseInt(matchingCombo.stock) || 0) <= 0) {
                markSoldOut($opt, $ddOpt);
            }
        });
    });
}

function markUnavailable($opt, $ddOpt) {
    $opt.addClass('variant-option-unavailable');
    if ($ddOpt && $ddOpt.length) {
        $ddOpt.prop('disabled', true).text($ddOpt.data('original-text') + ' (Not Available)');
    }
}

function markSoldOut($opt, $ddOpt) {
    $opt.addClass('variant-option-soldout').append('<span class="aq-soldout-label">Sold Out</span>');
    if ($ddOpt && $ddOpt.length) {
        $ddOpt.prop('disabled', true).text($ddOpt.data('original-text') + ' (Sold Out)');
    }
}

$(document).ready(function () {
    updateComboAvailability();
    updateQtyButtonStates();  
    updatePriceDisplay(); // initial load pe coupon + price sync ho jayega
});

const masterVariantList = getMasterVariantList();function autoSelectDependentAttributes(changedAttributeId, changedValueId) {
    if (!masterVariantList.length) return;

    const matchingCombos = masterVariantList.filter(function (combo) {
        return combo.values.includes(changedValueId);
    });
    if (!matchingCombos.length) return;

    // Stock of the SPECIFIC combo that pairs the just-clicked value with a
    // given candidate value — not the candidate's stock in isolation across
    // every other combo. This is what makes Black+S (0 stock) get skipped
    // even when S itself has stock under some other color.
    function comboStockFor(candidateValueId) {
        const combo = matchingCombos.find(function (c) {
            return c.values.includes(candidateValueId);
        });
        return combo ? (parseInt(combo.stock) || 0) : 0;
    }

    const otherAttributeIds = new Set();
    $('.variant-option').each(function () {
        const attrId = $(this).data('attribute-id');
        if (attrId != changedAttributeId) otherAttributeIds.add(attrId);
    });

    otherAttributeIds.forEach(function (attrId) {
        const attrValueIds = $('.variant-option[data-attribute-id="' + attrId + '"]')
            .map(function () { return parseInt($(this).data('value-id')); })
            .get();

        const validValuesForThisAttr = new Set();
        matchingCombos.forEach(function (combo) {
            combo.values.forEach(function (v) {
                if (attrValueIds.includes(v)) validValuesForThisAttr.add(v);
            });
        });

        if (validValuesForThisAttr.size === 0) return;

        // Prefer the first valid value whose SPECIFIC combo (with the
        // just-clicked value) actually has stock; only fall back to a
        // 0-stock combo if literally nothing else pairs with it.
        let chosenValueId = attrValueIds.find(function (id) {
            return validValuesForThisAttr.has(id) && comboStockFor(id) > 0;
        });

        if (chosenValueId === undefined) {
            chosenValueId = attrValueIds.find(function (id) {
                return validValuesForThisAttr.has(id);
            });
        }

        if (chosenValueId === undefined) return;

        $('.variant-option[data-attribute-id="' + attrId + '"]').removeClass('active');
        $('.variant-option[data-attribute-id="' + attrId + '"][data-value-id="' + chosenValueId + '"]').addClass('active');
        $('.aq-size-dropdown[data-attribute-id="' + attrId + '"]').val(chosenValueId);
    });
}
        function findVariantForType(type) {
            const relevantIds = $('.variant-option.active')
                .filter(function () { return $(this).data(type + '-dependent') == 1; })
                .map(function () { return parseInt($(this).data('value-id')); })
                .get();

            if (relevantIds.length === 0) return null;

            return (variantsByType[type] || []).find(function (variant) {
                return relevantIds.length === variant.values.length &&
                    relevantIds.every(function (id) { return variant.values.includes(id); });
            }) || null;
        }

$(document).on('click', '.variant-option', function () {

    if ($(this).hasClass('variant-option-unavailable') || $(this).hasClass('variant-option-soldout')) {
        return; // guard against programmatic/keyboard triggers on a disabled option
    }

    const attributeId = $(this).data('attribute-id');
    const clickedValueId = parseInt($(this).data('value-id'));

    $('.variant-option[data-attribute-id="' + attributeId + '"]').removeClass('active');
    $(this).addClass('active');

    // Auto-highlight the matching value(s) of any other selectable
    // attribute(s) — this is what makes Blue→XL, Pink→L etc. work.
    autoSelectDependentAttributes(attributeId, clickedValueId);

    selectedValues = $('.variant-option.active')
                .map(function () { return parseInt($(this).data('value-id')); })
                .get();

            const priceVariant = findVariantForType('price');
            const imageVariant = findVariantForType('image');
            const stockVariant = findVariantForType('stock');
            const skuVariant   = findVariantForType('sku');

            window.currentVariantIds = {
                price: priceVariant ? priceVariant.id : null,
                image: imageVariant ? imageVariant.id : null,
                stock: stockVariant ? stockVariant.id : null,
                sku:   skuVariant   ? skuVariant.id   : null,
            };

            // Always resolve to a real number — fall back to the base
            // product's price/mrp when no price-variant matches this
            // combination, or when the matched variant has a null mrp.
            if (priceVariant) {
                currentUnitPrice = parseFloat(priceVariant.price) || 0;
                currentUnitMrp   = parseFloat(priceVariant.mrp)   || 0;
            } else {
                currentUnitPrice = {{ (float) $product->price }};
                currentUnitMrp   = {{ (float) $product->mrp }};
            }

            updatePriceDisplay();

const stockValue = stockVariant ? stockVariant.stock : {{ (int) $detailStock }};
            
            $('#currentStock').text(stockValue);

            // ← NAYA ADD KIYA: price box ko stock ke hisaab se toggle karo
            if (stockValue < {{ (int) $product->min_qty }}) {
                $('#aqPriceBox').hide();
                if ($('#aqOutOfStockBox').length === 0) {
                    $('#aqPriceBox').after('<div class="aq-details-price-box p-3 mb-25" id="aqOutOfStockBox"><span class="aq-details-price" style="color:#999;">Currently Out of Stock</span></div>');
                } else {
                    $('#aqOutOfStockBox').show();
                }
            } else {
                $('#aqPriceBox').show();
                $('#aqOutOfStockBox').hide();
            }


            if (stockValue > 0) {
                $('#aqDetailQty')
                    .attr('max', stockValue)
                    .val(Math.max(
                        parseInt($('#aqDetailQty').attr('min')) || 1,
                        Math.min(parseInt($('#aqDetailQty').val()) || 1, stockValue)
                    ));
            } else {
                $('#aqDetailQty').attr('max', 0).val(0);
            }

            if (stockValue < 1) {
                $('.aq-add-to-cart-btn').prop('disabled', true).html('<i class="fa-solid fa-ban"></i> Out of Stock');
                $('.aq-buy-now-btn').prop('disabled', true).text('Out of Stock');
            } else {
                $('.aq-add-to-cart-btn').prop('disabled', false).html('<i class="fa-solid fa-bag-shopping"></i> Add to Cart');
                $('.aq-buy-now-btn').prop('disabled', false).text('Buy it Now');
            }

          if (imageVariant && imageVariant.images?.length) {
    updateVariantImages(imageVariant.images);
} else {
    $('#variant-images-container').html('');
    $('#variant-thumbs-container').html('');
    rebuildGalleryDots();   // ← ADD KARO: base images pe wapas dots resync
}


updateComboAvailability();
});

  function updateVariantImages(images) {

    $('#variant-images-container').html('');
    $('#variant-thumbs-container').html('');

    if (!images || !images.length) {
        return;
    }

    images.forEach(function(imageObj, index) {

        // Support both the new {image, thumb} shape and a plain string,
        // in case any older cached response still sends a flat path.
        const mainPath  = typeof imageObj === 'string' ? imageObj : imageObj.image;
        const thumbPath = typeof imageObj === 'string' ? imageObj : (imageObj.thumb || imageObj.image);

        const mainSrc  = storageBaseUrl + '/' + mainPath;
        const thumbSrc = storageBaseUrl + '/' + thumbPath;

        $('#variant-thumbs-container').append(`
            <div class="aq-gallery-thumb-item variant-thumb ${index === 0 ? 'active' : ''}"
                 onclick="document.getElementById('variant-main-${index}').scrollIntoView({behavior:'smooth', block:'center'})">
                <img src="${thumbSrc}" alt="">
            </div>
        `);

        $('#variant-images-container').append(`
            <div class="aq-gallery-main-img-wrap"
                 id="variant-main-${index}">
                <img src="${mainSrc}"
                     class="aq-gallery-main-img"
                     style="width:100%;border-radius:8px;object-fit:cover;">
            </div>
        `);
    });

    document.getElementById('variant-main-0')
        ?.scrollIntoView({ behavior:'smooth', block:'center' });

    rebuildGalleryDots();
}

$(document).on('change', '.aq-size-dropdown', function () {
    const attributeId = $(this).data('attribute-id');
    const valueId = $(this).val();
    $('.variant-option[data-attribute-id="' + attributeId + '"][data-value-id="' + valueId + '"]').trigger('click');
});

$(document).on('change', '.aq-addon-option', function () {
    selectedAddonIds = $('.aq-addon-option:checked')
        .map(function () { return parseInt($(this).data('addon-id')); })
        .get();

    selectedAddonTotal = $('.aq-addon-option:checked').toArray()
        .reduce(function (sum, el) { return sum + (parseFloat($(el).data('addon-price')) || 0); }, 0);

    updatePriceDisplay();
    // ← HATA DIYA: rebuildGalleryDots(); (addon change ka images/dots se koi lena dena nahi tha)
});

        function showMainImage() {
            $('#aqMainProductVideo').get(0).pause();
            $('#aqMainProductVideo').hide();
            $('#aqMainProductImg').show();
        }

        function showMainVideo(src) {
            const video = $('#aqMainProductVideo').get(0);
            video.src = src;
            $('#aqMainProductImg').hide();
            $('#aqMainProductVideo').show();
            video.play();
        }

        function updateMainMedia(thumb, src, type) {
            if (type === 'video') {
                showMainVideo(src);
            } else {
                document.getElementById('aqMainProductImg').src = src;
                showMainImage();
            }
            document.querySelectorAll('.aq-gallery-thumb-item').forEach(t => t.classList.remove('active'));
            thumb.classList.add('active');
        }

        function updateMainImage(thumb, imgSrc) {
            updateMainMedia(thumb, imgSrc, 'image');
        }

     function aqAdjustQty(amount) {
    const qtyInput = document.getElementById('aqDetailQty');
    if (!qtyInput) return;

    const minQty = parseInt(qtyInput.min) || 1;
    const maxQty = parseInt(qtyInput.max) || 0;
    let newVal = parseInt(qtyInput.value || minQty) + amount;

    if (newVal < minQty) newVal = minQty;
    if (maxQty > 0 && newVal > maxQty) newVal = maxQty;

    qtyInput.value = newVal;
    updateQtyButtonStates();
    updatePriceDisplay();
}

function updateQtyButtonStates() {
    const qtyInput = document.getElementById('aqDetailQty');
    if (!qtyInput) return;

    const minQty = parseInt(qtyInput.min) || 1;
    const maxQty = parseInt(qtyInput.max) || 0;
    const val = parseInt(qtyInput.value) || minQty;

    $('.qty-btn').eq(0).prop('disabled', val <= minQty);  // minus button
    $('.qty-btn').eq(1).prop('disabled', maxQty > 0 && val >= maxQty);  // plus button

    // Stock hint text
    let $hint = $('#aqStockHint');
    if (!$hint.length) {
        $hint = $('<div id="aqStockHint" style="font-size:12px;color:#999;text-align:center;margin-top:4px;"></div>');
        $('.aq-qty-selector').after($hint);
    }
    if (maxQty > 0 && maxQty <= 5) {
        $hint.text('Only ' + maxQty + ' left in stock').show();
    } else {
        $hint.hide();
    }
}


        /*
        |--------------------------------------------------------------------
        | Single function that owns all price/mrp/discount DOM updates.
        | - Addons are added to BOTH price and mrp equally, so they never
        |   shift the discount % — only the variant's own price vs mrp does.
        | - Everything is rounded to whole rupees with Math.round BEFORE
        |   formatting, so displayed price/mrp/discount can never disagree
        |   due to separate rounding of price vs mrp vs their difference.
        |--------------------------------------------------------------------
        */
       function updatePriceDisplay() {

    const qty = parseInt($('#aqDetailQty').val()) || 1;

    const unitPriceWithAddons = currentUnitPrice + selectedAddonTotal;
    const unitMrpWithAddons   = currentUnitMrp + selectedAddonTotal;

    const totalPrice = Math.round(qty * unitPriceWithAddons);
    const totalMrp   = Math.round(qty * unitMrpWithAddons);

    $('#productPrice').text('₹' + totalPrice.toLocaleString('en-IN'));

    let discount = 0;

    if (totalMrp > 0 && totalPrice < totalMrp) {
        discount = Math.round(((totalMrp - totalPrice) / totalMrp) * 100);
    }

    if (discount > 0) {
        $('#productMrp').text('₹' + totalMrp.toLocaleString('en-IN'));
        $('#productDiscount').text(discount + '% OFF');
        $('#priceMrpRow').show();
    } else {
        $('#priceMrpRow').hide();
    }

    renderBestCoupon(totalPrice); // ← naya add kiya
}

        document.getElementById('aqDetailQty')?.addEventListener('change', function () {
            const minQty = parseInt(this.min) || 1;
            const maxQty = parseInt(this.max) || 0;

            let value = parseInt(this.value) || minQty;
            if (value < minQty) value = minQty;
            if (maxQty > 0 && value > maxQty) value = maxQty;

            this.value = value;
            updatePriceDisplay();
        });

        function addToCart(productId) {
            const stock = parseInt($('#currentStock').text()) || 0;
            const quantity = parseInt($('#aqDetailQty').val());

            if (stock <= 0 || quantity > stock) {
                Swal.fire({ icon: 'error', title: 'Out of Stock', text: 'Requested quantity is not available.' });
                return;
            }

            const variantIds = window.currentVariantIds || { price: null, image: null, stock: null, sku: null };

            $.ajax({
                url: "{{ route('cart.add') }}",
                type: "POST",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    product_id: productId,
                    price_variant_id: variantIds.price,
                    image_variant_id: variantIds.image,
                    stock_variant_id: variantIds.stock,
                    sku_variant_id:   variantIds.sku,
                    selected_values: selectedValues,
                    addon_ids: selectedAddonIds,
                    quantity: quantity
                },
                success: function (response) {
                    if (response.status) {
                        Swal.fire({
                            icon: 'success', title: 'Success', text: response.message,
                            timer: 1500, showConfirmButton: false
                        });

                        $('.cart-count').text(response.cart_count);
                        fireTrackingEvents(response.tracking_events); 
                         refreshMiniCart(response);          // ← add this

                        if (response.mini_cart_html) {
                            $('.aq-cartmini-body').html(response.mini_cart_html);
                        }
                        if (response.cart_subtotal) {
                            $('#miniCartSubtotal').text('₹' + response.cart_subtotal);
                        }

                        markAddedToCart();
                    } else {
                        Swal.fire({ icon: 'error', title: 'Error', text: 'Unable to add product.' });
                    }
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: 'error', title: 'Error',
                        text: xhr.responseJSON?.message ?? 'Something went wrong.'
                    });
                }
            });
        }

        function markAddedToCart() {
            const addBtn = document.querySelector('.aq-add-to-cart-btn');
            if (!addBtn) return;

            addBtn.innerHTML = '<i class="fa-solid fa-bag-shopping"></i> View Cart';
            addBtn.onclick = function () {
                window.location.href = "{{ route('cart') }}";
            };
        }
        /* ── Mobile slider dots: build + sync + click-to-jump ────────── */
let galleryDotsObserver = null;

function rebuildGalleryDots() {
    const container = document.getElementById('aqGallerySlides');
    const dotsWrap   = document.getElementById('aqGalleryDots');
    if (!container || !dotsWrap) return;

    if (galleryDotsObserver) {
        galleryDotsObserver.disconnect();
    }

    const slides = container.querySelectorAll('.aq-gallery-main-img-wrap');
    dotsWrap.innerHTML = '';
    if (slides.length <= 1) return;

    slides.forEach(function (slide, index) {
        const dot = document.createElement('button');
        dot.type = 'button';
        dot.className = 'aq-dot' + (index === 0 ? ' active' : '');
        dot.setAttribute('aria-label', 'Go to slide ' + (index + 1));
        dot.addEventListener('click', function () {
            slide.scrollIntoView({ behavior: 'smooth', inline: 'start', block: 'nearest' });
        });
        dotsWrap.appendChild(dot);
    });

    galleryDotsObserver = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                const idx = Array.prototype.indexOf.call(slides, entry.target);
                dotsWrap.querySelectorAll('.aq-dot').forEach(function (d, i) {
                    d.classList.toggle('active', i === idx);
                });
            }
        });
    }, { root: container, threshold: 0.6 });

    slides.forEach(function (slide) { galleryDotsObserver.observe(slide); });
}

$(document).ready(function () { rebuildGalleryDots(); });

function addToCartCard(productId, minQty, btnEl) {

    const $btn = $(btnEl);
    const originalHTML = $btn.html();

    $.ajax({
        url: "{{ route('cart.add') }}",
        type: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            product_id: productId,
            quantity: minQty
        },
        success: function (response) {
            if (response.status) {
                Swal.fire({ icon: 'success', title: 'Success', text: response.message, timer: 1500, showConfirmButton: false });
                $('.cart-count').text(response.cart_count);
                 fireTrackingEvents(response.tracking_events);
                refreshMiniCart(response);

                $btn.html('<i class="fa-solid fa-check"></i> Added to Cart').prop('disabled', true);
                setTimeout(function () {
                    $btn.html(originalHTML).prop('disabled', false);
                }, 1500);
            } else {
                Swal.fire({ icon: 'error', title: 'Error', text: response.message ?? 'Unable to add product.' });
            }
        },
        error: function (xhr) {
            Swal.fire({
                icon: 'error', title: 'Error',
                text: xhr.responseJSON?.message ?? 'Something went wrong.'
            });
        }
    });
}
    </script>
    
    
    @if(!empty($viewItemScript))
<script>
    {!! $viewItemScript !!}
</script>
@endif

@endsection