@extends('layouts.app')
@section('content')

    <main class="aq-blog-details-page">

        <section class="aq-catpage-hero aq-apparel-hero">
            <div class="aq-hero-glow"></div>
            <div class="aq-floating-gift-box aq-floating-shape-1">
                <i class="fa-solid fa-wand-magic-sparkles"></i>
            </div>
            <div class="aq-floating-gift-box aq-floating-shape-2">
                <i class="fa-regular fa-star"></i>
            </div>
            <div class="aq-catpage-hero-content">
                <h1 class="aq-catpage-title">{{ $blog->title }}</h1>
                <div class="aq-catpage-breadcrumbs">
                    <a href="{{ route('home') }}">Home</a>
                    <span>/</span>
                    <a href="{{ route('blogs') }}">Blog</a>
                    <span>/</span>
                    <span>{{ Str::limit($blog->title, 40) }}</span>
                </div>
            </div>
        </section>

        <div class="aq-blog-details-parent-wrapper pt-120 pb-120">
            <div class="container">

                <div class="row g-5">
                    <div class="col-lg-8">
                        <div class="aq-blog-main-content aq-luxury-card">
                            <div class="aq-blog-featured-img-wrap position-relative">
                                <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}"
                                    class="aq-blog-featured-img">
                            </div>
                            <div class="aq-blog-content-inner">
                                <h2 class="aq-blog-title display-5 fw-bold">{{ $blog->title }}</h2>
                                <div
                                    class="aq-blog-meta d-flex align-items-center flex-wrap gap-4 mb-md-4 pb-md-4 border-bottom border-light">
                                    <div class="meta-item"><i class="fa-regular fa-calendar text-gold"></i> <span
                                            class="ms-2">{{ $blog->created_at->format('M d, Y') }}</span></div>
                                    <div class="meta-item"><i class="fa-regular fa-user text-gold"></i> <span
                                            class="ms-2">By Oudhyana Edit</span></div>
                                    @php
                                        $readTime = max(
                                            1,
                                            ceil(str_word_count(strip_tags($blog->content)) / 200)
                                        );
                                    @endphp

                                    <div class="meta-item"><i class="fa-regular fa-clock text-gold"></i> <span
                                            class="ms-2">{{ $readTime }} Min Read</span></div>
                                </div>

                                <div class="aq-blog-body fs-5 text-secondary lh-lg">
                                   {!! $blog->content !!}
                                </div>
  @php
                                    $shareUrl = urlencode(request()->url());
                                    $shareTitle = urlencode($blog->title);
                                @endphp


                                <div
                                    class="aq-blog-footer mt-5 pt-4 border-top border-light d-flex flex-column flex-md-row justify-content-end align-items-md-center gap-4">
                                    <div class="aq-blog-share d-flex align-items-center gap-3">
                                        <span class="fw-bold text-dark">Share:</span>
                                          <a href="https://wa.me/?text={{ $shareTitle }}%20{{ $shareUrl }}" target="_blank"
                                            class="aq-share-icon rounded-circle bg-light d-flex align-items-center justify-content-center text-dark transition-all hover-gold"
                                            style="width: 36px; height: 36px;"><i class="fa-brands fa-whatsapp"></i></a>
                                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}"
                                            target="_blank"
                                            class="aq-share-icon rounded-circle bg-light d-flex align-items-center justify-content-center text-dark transition-all hover-gold"
                                            style="width: 36px; height: 36px;"><i class="fa-brands fa-facebook-f"></i></a>
                                        <a href="https://www.instagram.com/" target="_blank"
                                            class="aq-share-icon rounded-circle bg-light d-flex align-items-center justify-content-center text-dark transition-all hover-gold"
                                            style="width: 36px; height: 36px;"><i class="fa-brands fa-instagram"></i></a>
                                        <a href="https://twitter.com/intent/tweet?text={{ $shareTitle }}&url={{ $shareUrl }}"
                                            target="_blank"
                                            class="aq-share-icon rounded-circle bg-light d-flex align-items-center justify-content-center text-dark transition-all hover-gold"
                                            style="width: 36px; height: 36px;"><i class="fa-brands fa-x"></i></a>
                                        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $shareUrl }}"
                                            target="_blank"
                                            class="aq-share-icon rounded-circle bg-light d-flex align-items-center justify-content-center text-dark transition-all hover-gold"
                                            style="width: 36px; height: 36px;"><i class="fa-brands fa-linkedin-in"></i></a>
                                       
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Author Box -->
                        <div
                            class="aq-author-box mt-5 p-4 p-md-5 bg-white rounded-4 shadow-sm d-flex flex-column flex-md-row gap-4 align-items-center align-items-md-start transition-all hover-shadow-lg">
                            <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&q=80&w=150&h=150"
                                alt="Author" class="rounded-circle object-fit-cover shadow-sm"
                                style="width: 120px; height: 120px; border: 4px solid #fdfbf9;">
                            <div class="aq-author-info text-center text-md-start">
                                <h4 class="fw-bold text-dark mb-1">Ananya Singh</h4>
                                <span class="text-gold fw-medium small text-uppercase letter-spacing-1 d-block mb-3">Fashion
                                    Curator</span>
                                <p class="text-secondary mb-0">Ananya brings over a decade of fashion expertise,
                                    specializing in curating unforgettable ethnic looks that perfectly align with
                                    traditional heritage and modern aesthetics.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 mt-2">
                        <div class="aq-blog-sidebar "> <!-- Search Widget -->
                            <div
                                class="aq-sidebar-widget bg-white p-4 rounded-4 shadow-sm mb-4 transition-all hover-shadow">
                                <h4 class="aq-sidebar-title fw-bold text-dark mb-4 position-relative pb-2">Search
                                    Articles
                                    <span
                                        class="position-absolute bottom-0 start-0 w-25 border-bottom border-2 border-gold"></span>
                                </h4>
                                <form action="{{ route('blog.details', $blog->slug) }}" method="GET"
                                    class="position-relative">
                                    <input type="text" name="search" value="{{ request('search') }}"
                                        class="form-control bg-light border-0 py-3 ps-3 pe-5 rounded-3 shadow-none focus-ring focus-ring-gold"
                                        placeholder="Search...">
                                    <button type="submit"
                                        class="position-absolute top-50 end-0 translate-middle-y border-0 bg-transparent pe-3 text-gold transition-all hover-dark"><i
                                            class="fa-solid fa-magnifying-glass"></i></button>
                                </form>
                            </div>

                            @if(request()->filled('search'))

                                <div
                                    class="aq-sidebar-widget bg-white p-4 rounded-4 shadow-sm mb-4 transition-all hover-shadow">

                                    <h4 class="aq-sidebar-title fw-bold text-dark mb-4 position-relative pb-2">

                                        Search Results

                                        <span
                                            class="position-absolute bottom-0 start-0 w-25 border-bottom border-2 border-gold">
                                        </span>

                                    </h4>

                                    <div class="aq-sidebar-blog-cards d-flex flex-column gap-3">

                                        @forelse($searchResults as $result)

                                            <div
                                                class="aq-sidebar-blog-card d-flex align-items-center gap-3 transition-all cursor-pointer group">

                                                <div class="aq-sidebar-blog-thumb-wrap rounded-3 overflow-hidden shadow-sm"
                                                    style="width:85px;height:85px;flex-shrink:0;">

                                                    <img src="{{ asset('storage/' . $result->image) }}" alt="{{ $result->title }}"
                                                        class="w-100 h-100 object-fit-cover">

                                                </div>

                                                <div class="aq-sidebar-blog-info">

                                                    <span class="aq-sidebar-blog-date small text-muted d-block mb-1">
                                                        <i class="fa-regular fa-calendar text-gold me-1"></i>
                                                        {{ $result->created_at->format('M d, Y') }}
                                                    </span>

                                                    <h5 class="aq-sidebar-blog-title fs-6 fw-bold mb-0 lh-sm">

                                                        <a href="{{ route('blog.details', $result->slug) }}"
                                                            class="text-dark text-decoration-none">

                                                            {{ Str::limit($result->title, 55) }}

                                                        </a>

                                                    </h5>

                                                </div>

                                            </div>

                                        @empty

                                            <div class="text-center py-3">
                                                No blogs found for "{{ request('search') }}"
                                            </div>

                                        @endforelse

                                    </div>

                                </div>

                            @endif

                            <!-- Latest Blogs Widget -->
                            <div
                                class="aq-sidebar-widget bg-white p-4 rounded-4 shadow-sm mb-4 transition-all hover-shadow">
                                <h4 class="aq-sidebar-title fw-bold text-dark mb-4 position-relative pb-2">Latest
                                    Insights
                                    <span
                                        class="position-absolute bottom-0 start-0 w-25 border-bottom border-2 border-gold"></span>
                                </h4>
                                <div class="aq-sidebar-blog-cards d-flex flex-column gap-3">

                                    @if(isset($latestBlogs) && $latestBlogs->count())

                                        @foreach($latestBlogs as $latest)

                                            <div
                                                class="aq-sidebar-blog-card d-flex align-items-center gap-3 transition-all cursor-pointer group">

                                                <div class="aq-sidebar-blog-thumb-wrap rounded-3 overflow-hidden shadow-sm"
                                                    style="width:85px;height:85px;flex-shrink:0;">

                                                    <img src="{{ asset('storage/' . $latest->image) }}" alt="{{ $latest->title }}"
                                                        class="w-100 h-100 object-fit-cover">

                                                </div>

                                                <div class="aq-sidebar-blog-info">

                                                    <span class="aq-sidebar-blog-date small text-muted d-block mb-1">

                                                        <i class="fa-regular fa-calendar text-gold me-1"></i>

                                                        {{ $latest->created_at->format('M d, Y') }}

                                                    </span>

                                                    <h5 class="aq-sidebar-blog-title fs-6 fw-bold mb-0 lh-sm">

                                                        <a href="{{ route('blog.details', $latest->slug) }}"
                                                            class="text-dark text-decoration-none">

                                                            {{ Str::limit($latest->title, 55) }}

                                                        </a>

                                                    </h5>

                                                </div>

                                            </div>

                                        @endforeach

                                    @else

                                        {{-- Keep your existing 3 static cards here unchanged --}}

                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>
@endsection