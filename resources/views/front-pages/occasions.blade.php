@extends('layouts.app')
@section('content')
    <main class="aq-occasions-page">
        <!-- Occasions Hero Section -->
        <section class="aq-catpage-hero aq-apparel-hero">
            <div class="aq-hero-glow"></div>
            <div class="aq-floating-gift-box aq-floating-shape-1">
                <i class="fa-solid fa-champagne-glasses"></i>
            </div>
            <div class="aq-floating-gift-box aq-floating-shape-2">
                <i class="fa-solid fa-crown"></i>
            </div>
            <div class="aq-catpage-hero-content">
                <h1 class="aq-catpage-title">Shop by Occasion</h1>
                <div class="aq-catpage-breadcrumbs">
                    <a href="{{ route('home') }}">Home</a>
                    <span>/</span>
                    <span>Occasions</span>
                </div>
            </div>
        </section>

        <!-- Occasions Grid -->
        <div class="aq-occasions-wrap pt-90 pb-90">
            <div class="container">
                <div class="row justify-content-center text-center mb-50">
                    <div class="col-lg-8">
                        <span class="aq-section-title-sm">Curated For Your Moments</span>
                        <h2 class="aq-section-title force-center-line text-center mt-10">Every Moment is an Occasion</h2>
                        <p class="aq-section-desc mt-15">From
                            grand weddings to intimate festive gatherings, discover hand-embroidered Chikankari
                            ensembles perfectly tailored for your special moments.</p>
                    </div>
                </div>

                <div class="row g-4">
                    @foreach($occasions as $occasion)
                        <div class="col-lg-4 col-md-6">
                            <div class="aq-occasion-card"
                                style="position: relative; border-radius: 12px; overflow: hidden; height: 350px; box-shadow: 0 10px 30px rgba(0,0,0,0.08);">

                                <img src="{{ asset('storage/' . $occasion->image) }}" alt="{{ $occasion->title }}"
                                    style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.7s ease;">

                                <div class="aq-occasion-overlay" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;
                            background: linear-gradient(to top, rgba(0,0,0,0.8), rgba(0,0,0,0.1));
                            display: flex; flex-direction: column; justify-content: flex-end; padding: 30px;">

                                    <h3 style="color:#fff; font-size:24px; font-weight:500;">
                                        {{ $occasion->title }}
                                    </h3>

                                    @if($occasion->sub_title)
                                        <h6 style="color:#fff;">
                                            {{ $occasion->sub_title }}
                                        </h6>
                                    @endif

                                    <p style="color:#f0f0f0; margin-bottom:20px;">
                                        {{ Str::limit($occasion->short_description, 120) }}
                                    </p>

                                    <a href="{{ route('occasions.listing', $occasion->slug) }}" class="aq-btn-black" style="align-self:flex-start; background:transparent; color:#fff;
                                border:1px solid #fff; padding:8px 20px; border-radius:30px;">
                                        Explore Collection
                                    </a>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>

        <style>
            .aq-occasion-card:hover img {
                transform: scale(1.05);
            }

            .aq-occasion-card .aq-btn-black:hover {
                background: #C98F9D !important;
                color: #fff !important;
                border-color: #C98F9D !important;
            }
        </style>
    </main>

@endsection