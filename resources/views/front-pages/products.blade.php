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
                <h1 class="aq-catpage-title">{{ $category->name ?? $pageTitle ?? '' }}</h1>
                <div class="aq-catpage-breadcrumbs">
                    <a href="{{ route('home') }}">Home</a>
                    <span>/</span>
                    <span>{{ $category->name ?? $pageTitle ?? 'Product Listing' }}</span>
                </div>
            </div>
        </section>



        <!-- 3. Interactive Catalog Viewport (Sidebar + Product Catalog) -->
        <section class="aq-catpage-main-layout" id="aq-catalog-section">
            <div class="container">
                <div class="row">
                    <!-- Left Sidebar Filter Console -->
                    <div class="col-lg-3 mb-4 mb-lg-0">
                        <div class="aq-filter-sidebar">
                            <button class="aq-filter-close-btn" id="aq-mobile-filter-close"
                                aria-label="Close Mobile Filters"
                                onclick="document.querySelector('.aq-filter-sidebar').classList.remove('active'); document.querySelector('.body-overlay').classList.remove('opened'); document.body.style.overflow='';"><i
                                    class="fa-solid fa-xmark"></i></button>
                            <!-- Widget Search -->
                            <div class="aq-sidebar-search">
                                <input type="text" id="aq-sidebar-search-input" placeholder="Search within results..." />
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </div>

                            {{-- Widget: Price Range --}}
                            {{-- Hidden on the price-band landing page itself, since the page is --}}
                            {{-- already locked to one band. Stacking the generic slider on top --}}
                            {{-- of the band would only ever narrow it further, which is confusing UX. --}}
                            @if($contextType !== 'price')
                                <div class="aq-filter-widget">
                                    <button class="aq-filter-header" type="button">
                                        <span>Price Range</span>
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </button>
                                    <div class="aq-filter-content">
                                        <div class="aq-price-slider-wrap">
                                            <input type="range" class="aq-price-range-slider" id="priceRange" min="200"
                                                max="10000" step="100" value="10000" />
                                            <div class="aq-price-inputs">
                                                <div class="aq-price-box">Min: ₹200</div>
                                                <div class="aq-price-box" id="maxPriceLabel">Max: ₹10,000</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- Widget: Category-specific Attributes (Fabric, etc.) --}}
                            {{-- Only available on a category landing page, since these come from --}}
                            {{-- the category_attributes pivot for the currently locked category. --}}
                            @if($category)
                                @foreach($category->categoryAttributes as $categoryAttribute)

                                    @if($categoryAttribute->show_in_filter)

                                        <div class="aq-filter-widget">

                                            <button class="aq-filter-header" type="button">
                                                <span>{{ $categoryAttribute->attribute->name }}</span>
                                                <i class="fa-solid fa-chevron-down"></i>
                                            </button>

                                            <div class="aq-filter-content">

                                                <ul class="aq-filter-list">

                                                    @foreach($categoryAttribute->attribute->values as $value)

                                                        <li class="aq-filter-item"
                                                            data-filter-type="attribute"
                                                            data-attribute-id="{{ $categoryAttribute->attribute->id }}"
                                                            data-value-id="{{ $value->id }}">

                                                            <div class="aq-filter-checkbox">
                                                                <i class="fa-solid fa-check"></i>
                                                            </div>

                                                            <span class="aq-filter-label">
                                                                {{ $value->value }}
                                                            </span>

                                                        </li>

                                                    @endforeach

                                                </ul>

                                            </div>

                                        </div>

                                    @endif

                                @endforeach
                            @endif

                            {{-- Widget: Premium Brands / Collections --}}
                            {{-- Hidden on the collection landing page itself, since the page is --}}
                            {{-- already locked to one collection. --}}
                            @if($contextType !== 'collection')
                                <div class="aq-filter-widget">
                                    <button class="aq-filter-header" type="button">
                                        <span>Collections</span>
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </button>
                                    <div class="aq-filter-content">
                                        <ul class="aq-filter-list">
                                            @foreach($collections as $collection)
                                                <li class="aq-filter-item" data-filter-type="collection"
                                                    data-id="{{ $collection->id }}">

                                                    <div class="aq-filter-checkbox">
                                                        <i class="fa-solid fa-check"></i>
                                                    </div>

                                                    <span class="aq-filter-label">
                                                        {{ $collection->name }}
                                                    </span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif

                            {{-- Widget: Shop By Occasion --}}
                            {{-- Hidden on the occasion landing page itself, since the page is --}}
                            {{-- already locked to one occasion. --}}
                            @if($contextType !== 'occasion')
                                <div class="aq-filter-widget">
                                    <button class="aq-filter-header" type="button">
                                        <span>Shop By Occasion</span>
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </button>
                                    <div class="aq-filter-content">
                                        <ul class="aq-filter-list">
                                            @foreach($occasions as $occasion)
                                                <li class="aq-filter-item" data-filter-type="occasion"
                                                    data-id="{{ $occasion->id }}">

                                                    <div class="aq-filter-checkbox">
                                                        <i class="fa-solid fa-check"></i>
                                                    </div>

                                                    <span class="aq-filter-label">
                                                        {{ $occasion->title }}
                                                    </span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif

                            {{-- Widget: Category --}}
                            {{-- Only shown on non-category pages (collection / occasion / attribute / price), --}}
                            {{-- letting the visitor narrow an otherwise category-wide listing down --}}
                            {{-- to one category. Single-select: choosing a category clears any other. --}}
                            @if($contextType !== 'category')
                                <div class="aq-filter-widget">
                                    <button class="aq-filter-header" type="button">
                                        <span>Category</span>
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </button>
                                    <div class="aq-filter-content">
                                        <ul class="aq-filter-list">
                                            @foreach($categories as $cat)
                                                <li class="aq-filter-item" data-filter-type="category"
                                                    data-id="{{ $cat->id }}">

                                                    <div class="aq-filter-checkbox">
                                                        <i class="fa-solid fa-check"></i>
                                                    </div>

                                                    <span class="aq-filter-label">
                                                        {{ $cat->name }}
                                                    </span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif

                            <!-- Clear all CTA -->
                            <button type="button" class="aq-btn-black w-100 mt-20" id="aq-clear-filters-btn"
                                style="border-radius:12px; font-size:13px; padding:10px;">
                                Reset All Filters
                            </button>
                        </div>
                        
                        
           

{{-- Visual subcategory list --}}
@if($category)
    <div class="aq-filter-widget aq-filter-sidebar mt-3 pb-3">

        <button class="aq-filter-header" type="button">
            <span>Category</span>
            <i class="fa-solid fa-chevron-down"></i>
        </button>

        <div class="aq-filter-content">
            <ul class="aq-filter-list">

                @foreach($subcategories as $subcategory)

                    <li class="aq-filter-item {{ request('subcategory') == $subcategory->slug ? 'active' : '' }}">

                        <a href="{{ route('products.listing', $category->slug) }}?subcategory={{ $subcategory->slug }}"
                            class="d-flex align-items-center justify-content-between w-100 text-decoration-none">

                            <div class="aq-filter-label">
                                {{ $subcategory->name }}
                                <span class="aq-category-count">
                                    ({{ $subcategory->sub_category_products_count }})
                                </span>
                            </div>

                            <i class="fa-solid fa-chevron-right"></i>

                        </a>

                    </li>

                @endforeach

            </ul>
        </div>

    </div>
@endif
                    </div>

                    <!-- Right Product Grid -->
                    <div class="col-lg-9">
                        <!-- Header filter summary bar -->
                        <div class="aq-layout-header">
                            <span class="aq-layout-header-title" id="aq-active-category-title">
                                @if($category)
                                    {{ request('subcategory')
                                        ? $subcategories->firstWhere('slug', request('subcategory'))?->name
                                        : $category->name
                                    }} Collection
                                @else
                                    {{ $pageTitle }} Collection
                                @endif
                            </span>
                            <div class="aq-layout-header-options">
                                <button type="button" class="btn btn-outline-dark d-lg-none" id="aq-mobile-filter-open-btn"
                                    style="border-radius: 8px; font-size: 13px; padding: 6px 12px; border: 1px solid #ddd;"
                                    onclick="document.querySelector('.aq-filter-sidebar').classList.add('active'); document.querySelector('.body-overlay').classList.add('opened'); document.body.style.overflow='hidden';">
                                    <i class="fa-solid fa-filter"></i> Filters
                                </button>
                                <span class="d-none d-sm-inline"
                                    style="font-family: Inter, sans-serif; font-size: 13px; color: #666;"
                                    id="aq-product-results-count">Showing {{ $products->total() }} Products</span>
                                <select class="aq-sort-select">
                                    <option value="popularity">Sort By: Popularity</option>
                                    <option value="price-low">Price: Low to High</option>
                                    <option value="price-high">Price: High to Low</option>
                                    <option value="newest">Sort By: Newest</option>
                                </select>
                            </div>
                        </div>

                        <!-- Product Cards Grid -->

                        <div class="aq-product-grid" id="aq-product-catalog-grid">
                            @include('front-pages.partials.product-grid')
                        </div>

                        <div id="aq-pagination-wrapper" class="mt-4">
                            {{ $products->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </section>



        <!-- 6. Bottom Sticky Category Link Area (For SEO/Footer Links) -->
        <section class="aq-footer-categories-section">
            <div class="container">
                <div class="aq-footer-cat-container">
                    <div class="aq-footer-cat-group">
                        <span class="aq-footer-cat-label">Shop by Recipient</span>
                        <div class="aq-footer-cat-links">
                            @foreach($menuCategories as $footerCategory)
                                <a href="{{ route('products.listing', $footerCategory->slug) }}" class="aq-footer-cat-link">
                                    {{ $footerCategory->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
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
                </div>
            </div>
        </section>
    </main>

    <script>

        document.addEventListener("DOMContentLoaded", function () {
            // Sticky scrolled header transition to green background on scroll
            window.addEventListener('scroll', () => {
                const header = document.querySelector('.header-sticky');
                if (header) {
                    if (window.scrollY > 80) {
                        header.classList.add('scrolled-green');
                    } else {
                        header.classList.remove('scrolled-green');
                    }
                }
            });

            // Sidebar accordion collapsible toggle listener
            const filterHeaders = document.querySelectorAll(".aq-filter-header");
            filterHeaders.forEach(header => {
                header.addEventListener("click", function () {
                    this.classList.toggle("collapsed");
                    const content = this.nextElementSibling;
                    if (content) {
                        if (content.style.maxHeight) {
                            content.style.maxHeight = null;
                        } else {
                            content.style.maxHeight = content.scrollHeight + "px";
                        }
                    }
                });

                // Initialize default height
                const content = header.nextElementSibling;
                if (content) {
                    content.style.maxHeight = content.scrollHeight + "px";
                }
            });

            // Context locked on this page: category | collection | occasion | attribute | price
            const contextType = "{{ $contextType }}";
            const contextId = {{ $contextModel->id ?? 'null' }};
            const contextPriceMin = {{ isset($priceBand['min']) ? $priceBand['min'] : 'null' }};
            const contextPriceMax = {{ isset($priceBand['max']) ? $priceBand['max'] : 'null' }};

            function applyFilters() {

                let collections = [];
                let occasions = [];
                let categoryIds = [];
                let attributeValues = [];

                document.querySelectorAll(
                    '.aq-filter-item.active[data-filter-type="collection"]'
                ).forEach(item => {
                    collections.push(item.dataset.id);
                });

                document.querySelectorAll(
                    '.aq-filter-item.active[data-filter-type="occasion"]'
                ).forEach(item => {
                    occasions.push(item.dataset.id);
                });

                document.querySelectorAll(
                    '.aq-filter-item.active[data-filter-type="category"]'
                ).forEach(item => {
                    categoryIds.push(item.dataset.id);
                });

                document.querySelectorAll(
                    '.aq-filter-item.active[data-filter-type="attribute"]'
                ).forEach(item => {
                    attributeValues.push(item.dataset.valueId);
                });

                const search =
                    document.getElementById('aq-sidebar-search-input')?.value || '';

                const maxPrice =
                    document.getElementById('priceRange')?.value || '';

                const sortBy =
                    document.querySelector('.aq-sort-select')?.value || '';

                fetch("{{ route('products.filter') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        context_type: contextType,
                        context_id: contextId,
                        context_price_min: contextPriceMin,
                        context_price_max: contextPriceMax,
                        category_id: categoryIds[0] || null,
                        collections,
                        occasions,
                        attribute_values: attributeValues,
                        search,
                        max_price: maxPrice,
                        sort_by: sortBy
                    })
                })
                    .then(response => response.json())
                    .then(data => {

                        document.getElementById(
                            'aq-product-catalog-grid'
                        ).innerHTML = data.html;
                        document.getElementById(
                            'aq-pagination-wrapper'
                        ).innerHTML = data.pagination;

                        document.getElementById(
                            'aq-product-results-count'
                        ).innerHTML = `Showing ${data.count} Products`;
                    });
            }

            const filterItems = document.querySelectorAll(".aq-filter-item");
            filterItems.forEach(item => {

                item.addEventListener("click", function () {

                    // Category widget is single-select: picking one clears the rest.
                    if (this.dataset.filterType === "category") {
                        const wasActive = this.classList.contains("active");
                        document.querySelectorAll(
                            '.aq-filter-item[data-filter-type="category"]'
                        ).forEach(el => el.classList.remove("active"));
                        if (!wasActive) {
                            this.classList.add("active");
                        }
                    } else {
                        this.classList.toggle("active");
                    }

                    applyFilters();

                });

            });

            const priceSlider = document.getElementById("priceRange");
            const maxPriceLabel = document.getElementById("maxPriceLabel");
            // Price slider dynamic value display
            if (priceSlider) {
                priceSlider.addEventListener("input", function () {

                    maxPriceLabel.innerText =
                        "Max: ₹" + parseInt(this.value).toLocaleString('en-IN');

                    applyFilters();

                });
            }


            // Search filtering listener
            const searchInput = document.getElementById("aq-sidebar-search-input");
            if (searchInput) {

                let searchTimeout;

                searchInput.addEventListener("input", function () {

                    clearTimeout(searchTimeout);

                    searchTimeout = setTimeout(() => {

                        applyFilters();

                    }, 500);

                });

            }

            const sortSelect = document.querySelector('.aq-sort-select');

            if (sortSelect) {

                sortSelect.addEventListener('change', function () {

                    applyFilters();

                });

            }

            // Reset filters logic
            const clearBtn = document.getElementById("aq-clear-filters-btn");
            if (clearBtn) {

                clearBtn.addEventListener("click", function () {

                    if (priceSlider) {
                        priceSlider.value = 10000;
                        maxPriceLabel.innerText = "Max: ₹10,000";
                    }

                    if (searchInput) {
                        searchInput.value = "";
                    }

                    filterItems.forEach(item => {
                        item.classList.remove("active");
                    });

                    const sortSelect =
                        document.querySelector('.aq-sort-select');

                    if (sortSelect) {
                        sortSelect.selectedIndex = 0;
                    }

                    applyFilters();

                });

            }

        });

        document.addEventListener('DOMContentLoaded', function () {
            function initProductHoverSliders() {
                document.querySelectorAll('.aq-product-card').forEach(card => {
                    const mediaItems = Array.from(card.querySelectorAll('.aq-product-media-wrapper > img, .aq-product-media-wrapper > video'));
                    const dots = card.querySelectorAll('.aq-media-dot');
                    let hoverInterval;
                    let currentIndex = 0;

                    card.addEventListener('mouseenter', () => {
                        if (mediaItems.length <= 1) return;

                        // Immediately show second image on hover
                        currentIndex = 1;
                        updateMedia();

                        // Then cycle every 2 seconds
                        hoverInterval = setInterval(() => {
                            currentIndex = (currentIndex + 1) % mediaItems.length;
                            updateMedia();
                        }, 2000);
                    });

                    card.addEventListener('mouseleave', () => {
                        clearInterval(hoverInterval);
                        currentIndex = 0;
                        updateMedia();
                    });

                    function updateMedia() {
                        mediaItems.forEach((item, index) => {
                            item.style.opacity = index === currentIndex ? '1' : '0';

                            // Play/Pause video logic
                            if (item.tagName === 'VIDEO') {
                                if (index === currentIndex) {
                                    item.play().catch(e => console.log('Autoplay prevented'));
                                } else {
                                    item.pause();
                                }
                            }
                        });

                        dots.forEach((dot, index) => {
                            if (index === currentIndex) {
                                dot.classList.add('active');
                            } else {
                                dot.classList.remove('active');
                            }
                        });
                    }
                });
            }

            initProductHoverSliders();

            // Re-init if new products are loaded (optional, for dynamic rendering)
            const grid = document.getElementById('aq-product-catalog-grid');
            if (grid) {
                const observer = new MutationObserver(initProductHoverSliders);
                observer.observe(grid, { childList: true });
            }
            // Close filter sidebar when body overlay is clicked
            const bodyOverlay = document.querySelector('.body-overlay');
            const filterSidebar = document.querySelector('.aq-filter-sidebar');
            if (bodyOverlay && filterSidebar) {
                bodyOverlay.addEventListener('click', function () {
                    filterSidebar.classList.remove('active');
                    bodyOverlay.classList.remove('opened');
                    document.body.style.overflow = '';
                });
            }
        });

function addToCart(productId, minQty, btnEl) {

    const $btn = btnEl ? $(btnEl) : null;
    const originalHTML = $btn ? $btn.html() : null;

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

                if ($btn) {
                    $btn.html('<i class="fa-solid fa-check"></i> Added to Cart').prop('disabled', true);
                    setTimeout(function () {
                        $btn.html(originalHTML).prop('disabled', false);
                    }, 1500);
                }
            } else {
                Swal.fire({ icon: 'error', title: 'Error', text: response.message ?? 'Unable to add product.' });
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

                            $('.wishlist-count').text(response.wishlist_count);
                             fireTrackingEvents(response.tracking_events);

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

@endsection